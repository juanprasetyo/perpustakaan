<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Login extends CI_Controller
{
    function __construct(){
        parent::__construct();

        $this->load->model('M_users');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index(){
        $this->_check_cookie();
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if($this->form_validation->run() == false){
            $this->load->view('layouts/V_Login');
        } else {
            $this->_login();
        }

    }

    private function _login(){
        $email = $this->input->post('email');

        $data = $this->M_users->get_by_email($email);
        if($data->num_rows() > 0){

            $password   = $this->input->post('password');
            $hash       = $data->row_array()['password'];

            if(password_verify($password, $hash)){
                $this->session->set_userdata([
                    'status'    => 'login',
                    'email'     => $email
                ]);

                if($this->input->post('remember')){
                    set_cookie('email', $email, 3600 * 24 * 30, '', '/');
                }
                redirect(base_url('dashboard'));
            } else {
                $this->session->set_flashdata('failed', 'Your Password is Wrong!');
                redirect(base_url('login'));
            }
        } else {
            $this->session->set_flashdata('failed', 'Your Email is Wrong!');
            redirect(base_url('login'));
        }
    }

    private function _check_cookie(){
        if(get_cookie('email') !== NULL){
            $this->session->set_flashdata('login', [
                'type'      => 'success',
                'message'   => 'Anda sudah login.'
            ]);
            redirect(base_url('dashboard'));
        }
    }

    public function register(){
        $this->form_validation->set_rules('full-name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            "is_unique" => "This email has been registered!"
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[4]');
        $this->form_validation->set_rules('password2', 'Password2', 'required|trim|matches[password]', [
            'required'  => "This field is required!",
            'matches'   => "Password doesn't matches!"
        ]);
        $this->form_validation->set_rules('gender', 'Gender', 'required');

        if($this->form_validation->run() == false){
            $this->load->view('layouts/V_Register');
        } else {
            $gender = $this->input->post('gender');
            $terms  = $this->input->post('terms');
            
            $data = [
                'name'          => $this->input->post('full-name'),
                'email'         => $this->input->post('email'),
                'phone'         => '',
                'address'       => '',
                'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'gender'        => $gender,
                'image'         => 'default-'.$gender.'.png',
                'role_id'       => 2,
                'date_created'  => time()
            ];
        
            if(isset($_POST['terms'])){
                $this->M_users->add($data);
                $this->session->set_flashdata('success', 'Your account has been created.');
                redirect(base_url('login'));
            } else {
                $this->session->set_flashdata('danger', 'Something went wrong!');
                redirect(base_url('register'));
            }
            
        }

    }

    public function logout(){
        $this->session->unset_userdata(['status', 'email']);
        $this->session->set_flashdata("success", "Your account has been logout");
        delete_cookie('email', '', '/');
        redirect(base_url('login'));
    }
}