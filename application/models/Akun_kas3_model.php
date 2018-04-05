<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Akun_kas3_model extends CI_Model{
/* -------------- Constructor ------------- */
	 public function __construct()
    {
            parent::__construct();
	}
	
/* -------------- Method ------------- */
	/*	Fungsi untuk mencari data output	*/
	function search_akun_kas3($kd_kas_2='', $kata_kunci=''){
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		$where = "kd_kas_2 = '{$kd_kas_2}'";
		if($kata_kunci!='')
		{
			$where .= " AND (kd_kas_3 LIKE '%{$kata_kunci}%' OR nm_kas_3 LIKE '%{$kata_kunci}%')";
		}

		$this->db->where($where);
		$this->db->order_by("kd_kas_3", "asc"); 
		/* running query	*/
		$query		= $this->db->get('akun_kas3');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function add_akun_kas3($data){
		//var_dump($data);die;
		return $this->db->insert("akun_kas3",$data);
	}
	
	function get_akun_kas3($kode_akun2digit){

		$rba = $this->load->database('rba', TRUE);
		$query = "SELECT DISTINCT kode_akun3digit,nama_akun3digit FROM akun_belanja WHERE kode_akun2digit = '{$kode_akun2digit}' ORDER BY kode_akun3digit";
		$query = $rba->query($query);

		if ($query->num_rows() > 0){
			
			return $query->result();
		}else{
			return array();
		}
	}

	function get_akun_sebelum($kode_akun2digit){
		$rba = $this->load->database('rba', TRUE);
		$query = "SELECT DISTINCT kode_akun2digit,nama_akun2digit FROM akun_belanja WHERE kode_akun2digit = '{$kode_akun2digit}'";
		$query = $rba->query($query);

		if($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function get_all_akun_kas3($where=""){

		if(is_array($where)){
				
			$this->db->where("kd_kas_2",$where["kd_kas_2"]);
			$this->db->order_by('kd_kas_3', 'ASC');
		
		}

		$query = $this->db->get("akun_kas3");
		//	var_dump($where);die;
		if ($query->num_rows() > 0){
			
			return $query->result();
		}else{
			return array();
		}
	}
	
	
	function edit_akun_kas3($data,$where){
		if(is_array($where)){
			$this->db->where("kd_kas_3",$where["kd_kas_3"]);
			$this->db->where("kd_kas_2",$where["kd_kas_2"]);
		}
		return $this->db->update("akun_kas3",$data);
	}
	
	function delete_akun_kas3($where){

		$this->db->delete("akun_kas3",$where);
		$this->db->delete("akun_kas4",$where);
		$this->db->delete("akun_kas5",$where);
		$this->db->delete("akun_kas6",$where);

		return true;
	}

	function get_single_akun_kas3($where,$field){

		$this->db->where($where);	

		$query = $this->db->get('akun_kas3')->row();

		if(empty($field)){
			return $query ;
		}
		elseif($field=='nama'){
			return $query->nm_kas_3 ;
		}


	}
}
?>