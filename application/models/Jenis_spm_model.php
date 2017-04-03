<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Jenis_spm_model extends CI_Model{
/* -------------- Constructor ------------- */
	 public function __construct()
    {
            parent::__construct();
	}
	
/* -------------- Method ------------- */
	/*	Fungsi untuk mencari data output	*/
	function search_jenis_spm(){
		$this->db->order_by("kd_spm", "asc"); 
		$query		= $this->db->get('rsa_jenis_spm');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
}
?>