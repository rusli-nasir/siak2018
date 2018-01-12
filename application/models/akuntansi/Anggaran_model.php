<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggaran_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database('default', TRUE);
	}

	public function upload_pendapatan_temporer($data){
		$this->db->replace('akuntansi_anggaran', $data); 
	}

}

/* End of file Anggaran_model.php */
/* Location: ./application/models/akuntansi/Anggaran_model.php */