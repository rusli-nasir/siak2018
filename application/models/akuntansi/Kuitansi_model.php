<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kuitansi_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	function read_kuitansi($limit = null, $start = null, $keyword = null){
		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM rsa_kuitansi WHERE cair=1 AND 
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM rsa_kuitansi WHERE cair=1 AND 
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%')");
		}
		return $query;
	}

	function read_kuitansi_ls($limit = null, $start = null, $keyword = null){
		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND 
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND 
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%')");
		}
		return $query;
	}
}