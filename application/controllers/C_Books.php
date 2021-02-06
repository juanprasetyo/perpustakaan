<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Books extends CI_Controller
{
    function __construct(){
        parent::__construct();
        
        $this->load->model('M_users');
        $this->load->model('M_books');
        $this->load->model('M_pinjam');

        $this->load->library('session');

        is_logged_in();
    }

    public function show_books(){
        $email  = $this->session->userdata('email');
        $data   = [
            'title'  => 'books',
            'books'  => $this->M_books->get_all(),
            'user'   => $this->M_users->get_by_email($email)->row_array(),
        ];

        $this->load->view('layouts/V_Header'    , $data);
        $this->load->view('layouts/V_Sidebar'   , $data);
        $this->load->view('pages/V_Books'       , $data);
        $this->load->view('layouts/V_Footer'    , $data);
    }

    public function view_pinjam(){
        $email  = $this->session->userdata('email');
        $data   = [
            'title'  => 'pinjam',
            'books'  => $this->M_pinjam->get_all($email),
            'user'   => $this->M_users->get_by_email($email)->row_array(),
        ];

        $this->load->view('layouts/V_Header'    , $data);
        $this->load->view('layouts/V_Sidebar'   , $data);
        $this->load->view('pages/V_Pinjam'      , $data);
        $this->load->view('layouts/V_Footer'    , $data);
    }

    public function pinjam(){
        $book_id         = html_escape($this->input->post('book_id'));
        $user_id         = html_escape($this->input->post('user_id'));
        $jumlah_dipinjam = html_escape($this->input->post('jumlah_dipinjam'));

        $data = [
            'id'                 => '',
            'id_peminjam'        => $user_id,
            'id_buku'            => $book_id,
            'tanggal_pinjam'     => time(),
            'tanggal_kembalikan' => strtotime("+7 day"),
            'jumlah_buku'        => 1
        ];

        if($this->_check_pinjam($data) > 0){
            $this->M_pinjam->tambah_pinjam($data);
        } else {
            $this->M_pinjam->pinjam($data);
        }
        
        $this->M_books->update_jumlah($book_id, $jumlah_dipinjam);
        $this->output
             ->set_status_header(200)
             ->set_content_type('application/json', 'utf-8')
             ->set_output(json_encode('Buku berhasil dipinjam'));
    }

    private function _check_pinjam($data){
        return $this->M_pinjam->get_by_book($data)->num_rows();
    }

    public function kembalikan(){
        $book_id         = $this->input->post('book_id');
        $user_id         = $this->input->post('user_id');
        $jumlah_dipinjam = $this->input->post('jumlah_dipinjam');
        
        $data = [
            'id_peminjam' => $user_id,
            'id_buku'     => $book_id
        ];
        
        $jumlah_kembali  = $this->M_pinjam->get_by_book($data)->row_array()['jumlah_buku'];
        // echo "<pre>";
        // print_r($book_id);
        // print_r($data);
        // print_r($jumlah_kembali);
        // die;

        $this->M_books->update_jumlah_kembali($book_id, $jumlah_dipinjam, $jumlah_kembali);
        $this->M_pinjam->delete_pinjam($data);
        $this->output
             ->set_status_header(200)
             ->set_content_type('application/json', 'utf-8')
             ->set_output(json_encode('Buku telah dikembalikan'));
    }

    public function grafik(){
        $email = $this->session->email;
        $data  = [
            'title' => 'grafik',
            'books' => $this->M_books->get_all(),
            'user'  => $this->M_users->get_by_email($email)->row_array()
        ];

        $this->load->view('layouts/V_Header',  $data);
        $this->load->view('layouts/V_Sidebar', $data);
        $this->load->view('pages/V_Grafik',    $data);
        $this->load->view('layouts/V_Footer',  $data);
    }

    public function get_data_grafik(){
        $books = $this->M_books->get_all();
        $judul    = [];
        $banyak   = [];
        $dipinjam = [];
        foreach ($books as $book) {
            $judul[]    = $book['judul'];
            $banyak[]   = $book['jumlah'] - $book['dipinjam'];
            $dipinjam[] = $book['dipinjam'];
        }
        $data = [
            'judul'     => $judul,
            'banyak'    => $banyak,
            'dipinjam'  => $dipinjam
        ];

        echo json_encode($data);
    }

    public function add_book(){
        $data = [
            'judul'     => htmlspecialchars($this->input->post('bookName')),
            'penulis'   => htmlspecialchars($this->input->post('bookWriter')),
            'penerbit'  => htmlspecialchars($this->input->post('bookPublisher')),
            'jumlah'    => htmlspecialchars($this->input->post('numberOfBooks')),
        ];

    }
}