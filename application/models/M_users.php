<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_users extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_all(){
        return $this->db->get('users')->result_array();
    }

    public function get_by_id(){
        return $this->db->get_where('users', ['id' => $id])->result_array();
    }

    public function add($data){
        $this->db->insert('users', $data);
    }

    public function get_by_email($email){
        return $this->db->get_where('users', ['email' => $email]);
    }

    public function save_profile($data){
        $where = ['id' => $data['id']];
        $this->db->update('users', $data, $where);
    }
}