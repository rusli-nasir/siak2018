<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Biaya_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }

    public function get_nama_biaya($kode)
    {
    	$level = strlen($kode);
    	if ($level == 2){
    		$keyword = 'kode_akun';
    		$value = 'nama_akun';
    	}elseif ($level == 3) {
    		$keyword = 'kode_akun_sub';
    		$value = 'nama_akun_sub';
    	}
    	return $this->db2->get_where('ref_akun',array($keyword => $kode))->row_array()[$value];

    }
	

	
}