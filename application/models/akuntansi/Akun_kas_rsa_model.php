<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_kas_rsa_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }

    public function get_all_akun_kas()
    {
        return $this->db->get('akun_kas6')->result_array();
    }

    
}