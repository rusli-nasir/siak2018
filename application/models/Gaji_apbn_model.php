<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Gaji_apbn_model extends CI_Model {
	/* -------------- Constructor ------------- */

	public function __construct()
	{
		parent::__construct();	
	}
	
	function insert_trx($data){

		$insert = $this->db->insert('w_apbn_gaji_', $data);
		$insert_id = $this->db->insert_id();
		if ($insert) {
			return $insert_id;
		}else{
			return FALSE;
		}
	}

	function insert_detil($data,$tabel){
		$insert = $this->db->insert($tabel, $data);
		if ($insert) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

}