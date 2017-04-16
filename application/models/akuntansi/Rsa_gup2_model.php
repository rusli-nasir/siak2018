<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rsa_gup2_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }
    
    function get_spm_detail($no_spm, ... $columns){
        return $this->db
                    ->select($columns)
                    ->where('str_nomor_trx_spm', $no_spm)
                    ->limit(1)
                    ->get('rsa_kuitansi')
                    ->row();
    }

}