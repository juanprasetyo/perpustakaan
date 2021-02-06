<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_books extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_all(){
        return $this->db->get('buku')->result_array();
    }

    public function get_by_id($id){
        return $this->db->get_where('buku', ['id' => $id])->result_array();
    }

    public function update_jumlah($id, $jumlah_dipinjam){
        $data  = [
            'dipinjam' => $jumlah_dipinjam + 1
        ];
        $where = [
            'id' => $id
        ];
        $this->db->update('buku', $data, $where);
    }

    public function update_jumlah_kembali($id, $jumlah_dipinjam, $jumlah_kembali){
        $value = [
            'dipinjam' => $jumlah_dipinjam - $jumlah_kembali
        ];
        $where = [
            'id' => $id
        ];
        $this->db->update('buku', $value, $where);
    }

    public function get_banyak_buku(){
        $this->db->select('judul, jumlah, dipinjam');
        $query = $this->db->get('buku');
        return $query->result_array();
    }
}