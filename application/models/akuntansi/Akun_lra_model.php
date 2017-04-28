<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_lra_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }

    public function get_akun_debet()
    {
        return $this->db->select('akun_6')->select('nama')->get('akuntansi_lra_6')->result_array();
    }

    public function get_akun_kredit()
    {
        $hasil = $this->db->select('akun_6')->select('nama')->get('akuntansi_lra_6')->result_array();
        for ($i=0; $i < count($hasil); $i++) { 
            $hasil[$i]['akun_6'][0] = 6;
        }
        return $hasil;
    }

    
}