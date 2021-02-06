<?php 
    defined('BASEPATH') or exit('No direct script access allowed');

    function is_logged_in(){
        $ci = & get_instance();
        if($ci->session->userdata('status') !== 'login'){
            redirect(base_url('login'));
        }
    }

?>