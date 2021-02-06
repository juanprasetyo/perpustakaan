<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Users extends CI_Controller
{
    function __construct(){
        parent::__construct();
        
        $this->load->model('M_users');
        $this->load->model('M_books');
        $this->load->model('M_pinjam');

        $this->load->library('session');

        is_logged_in();
    }

    public function index(){
        $email = $this->session->userdata('email');
        $data  = [
            'title'  => 'home',
            'user'   => $this->M_users->get_by_email($email)->row_array(),
            'active' => ''
        ];

        $this->load->view('layouts/V_Header'    , $data);
        $this->load->view('layouts/V_Sidebar'   , $data);
        $this->load->view('pages/V_Dashboard'   , $data);
        $this->load->view('layouts/V_Footer'    , $data);
    }

    public function view_profile(){
        $email = $this->session->userdata('email');
        $data  = [
            'title'  => 'profile',
            'user'   => $this->M_users->get_by_email($email)->row_array(),
            'active' => ''
        ];
        $this->load->view('layouts/V_Header'    , $data);
        $this->load->view('layouts/V_Sidebar'   , $data);
        $this->load->view('pages/V_Profile'     , $data);
        $this->load->view('layouts/V_Footer'    , $data);
    }

    public function view_edit_profile(){
        // Load Library form_validation
        $this->load->library('form_validation');
        // Load helper file
        $this->load->helper('file');

        $email  = $this->session->userdata('email');
        $data   = [
            'title'  => 'edit profile',
            'user'   => $this->M_users->get_by_email($email)->row_array(),
            'active' => ''
        ];

        // Set rule form_validation
        $this->form_validation->set_rules('inputNama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('inputPhone', 'Phone', 'required|trim|numeric|max_length[14]');
        $this->form_validation->set_rules('inputAddress', 'Alamat', 'required|trim');

        // Jika form_validation salah
        if($this->form_validation->run() == false){
            // Tampilkan halaman edit
            $this->load->view('layouts/V_Header'    , $data);
            $this->load->view('layouts/V_Sidebar'   , $data);
            $this->load->view('pages/V_EditProfile' , $data);
            $this->load->view('layouts/V_Footer'    , $data);
        } else {
            // Siap proses save
            $data = [
                'id'      => $this->input->post('id-user'),
                'name'    => $this->input->post('inputNama'),
                'email'   => $this->input->post('inputEmail'),
                'phone'   => $this->input->post('inputPhone'),
                'address' => $this->input->post('inputAddress'),
                'image'   => $_FILES['inputImage']['name']
            ];
            $this->_save_edit_profile($data);
        }
        

    }

    private function _save_edit_profile($data){
        // Jika tidak ada input image
        if($data['image'] == NULL) {
            // Setting image jadi data image lama
            $data['image'] = $this->input->post('old-image');

            // save perubahan
            $this->M_users->save_profile($data);
            redirect(base_url('editProfile'));
        } else {
            $ext = strtolower(end((explode('.', $data['image']))));
            if(!($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png')){
                $this->session->set_flashdata('alert-notif', [
                    'type'   => 'error',
                    'title'  => 'Oops...',
                    'text'   => 'File yang anda masukkan salah!',
                    'footer' => 'File yang dapat digunakan jpg,jpeg,png.'
                ]);
                redirect(base_url('editProfile'));
            } else {
                // Config untuk upload Image
                $config = [
                    'upload_path'    => './assets/img/profile/'.$data['email'],
                    'allowed_types'  => 'jpg|jpeg|png',
                    'file_name'      => $data['id'],
                    'overwrite'      => TRUE
                ];
        
                // Load library upload
                $this->load->library('upload', $config);
        
                // Jika directory dengan nama email tidak ada, buat folder
                $dir_exist = true;
                if(!is_dir('assets/img/profile/'.$data['email'])){
                    mkdir('./assets/img/profile/'.$data['email'], 0777, true);
                    $dir_exist = false;
                }
        
                if(! $this->upload->do_upload('inputImage')){
                    // Jika gagal / tidak ada upload image hapus directory dengan nama email yang dibuat sebelumnya
                    if(!$dir_exist){
                        rmdir('./assets/img/profile/'.$data['email'], 0777, true);
                    }
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('alert-notif', [
                        'type'   => 'error',
                        'title'  => 'Oops...',
                        'text'   => 'Maaf, ada kesalahan.',
                        'footer' => ''
                    ]);
                    redirect(base_url('editProfile'));
                } else {
                    $file   = array('upload_data' => $this->upload->data());
                    $data['image'] = $file['upload_data']['orig_name'];
                    $this->session->set_flashdata('alert-notif', [
                        'type'   => 'success',
                        'title'  => 'Success...',
                        'text'   => 'Profile anda telah berhasil di Update.',
                        'footer' => ''
                    ]);
                    $this->M_users->save_profile($data);
                    redirect(base_url('editProfile'));
                }
            }
        }
    }
}