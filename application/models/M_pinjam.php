<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pinjam extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_all($email){
        $this->db->select('*');
        $this->db->from('pinjam');
        $this->db->join('users', 'users.id = pinjam.id_peminjam');
        $this->db->join('buku', 'buku.id = pinjam.id_buku');
        $this->db->where('email', $email);
        return $this->db->get()->result_array();
    }

    public function get_by_book($data){
        $where = [
            'id_peminjam' => $data['id_peminjam'],
            'id_buku'     => $data['id_buku']
        ];

        return $this->db->get_where('pinjam', $where);
    }

    public function pinjam($data){
        $this->db->insert('pinjam', $data);
    }

    public function tambah_pinjam($data){
        $book  = $this->get_by_book($data)->row_array();
        $value  = [
            'jumlah_buku' => $book['jumlah_buku'] + 1
        ];
        $where = [
            'id_peminjam' => $data['id_peminjam'],
            'id_buku'     => $data['id_buku']
        ];

        $this->db->update('pinjam', $value, $where);
    }

    public function delete_pinjam($where){
        $this->db->delete('pinjam', $where);
    }
}