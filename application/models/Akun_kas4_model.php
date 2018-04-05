<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Akun_kas4_model extends CI_Model{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
	}
	
/* -------------- Method ------------- */
	/*	Fungsi untuk mencari data program	*/
	function search_akun_kas4($kd_kas_2='', $kd_kas_3='', $kata_kunci=''){
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		$where = "kd_kas_2 = '{$kd_kas_2}' AND kd_kas_3 = '{$kd_kas_3}'";
		if($kata_kunci!='')
		{
			$where .= " AND (kd_kas_4 LIKE '%{$kata_kunci}%' OR nm_kas_4 LIKE '%{$kata_kunci}%')";
		}

		$this->db->where($where);
		$this->db->order_by("kd_kas_4", "asc"); 
		/* running query	*/
		$query		= $this->db->get('akun_kas4');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function get_akun_kas4($kode_akun3digit){

		$rba = $this->load->database('rba', TRUE);
		$query = "SELECT DISTINCT kode_akun4digit,nama_akun4digit FROM akun_belanja WHERE kode_akun3digit = '{$kode_akun3digit}' ORDER BY kode_akun4digit";
		$query = $rba->query($query);

		if ($query->num_rows() > 0){
			
			return $query->result();
		}else{
			return array();
		}
	}

	function get_akun_sebelum($kode_akun3digit){
		$rba = $this->load->database('rba', TRUE);
		$query = "SELECT DISTINCT kode_akun3digit,nama_akun3digit FROM akun_belanja WHERE kode_akun3digit = '{$kode_akun3digit}'";
		$query = $rba->query($query);

		if($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function add_akun_kas4($data){

		return $this->db->insert("akun_kas4",$data);
	}
	
	function edit_akun_kas4($data,$where){
		//var_dump($data);die;
		if(is_array($where)){
			$this->db->where("kd_kas_4",$where["kd_kas_4"]);
			$this->db->where("kd_kas_3",$where["kd_kas_3"]);
			$this->db->where("kd_kas_2",$where["kd_kas_2"]);
		}
		return $this->db->update("akun_kas4",$data);
	}
	
	function delete_akun_kas4($where){

		$this->db->delete("akun_kas4",$where);
		$this->db->delete("akun_kas5",$where);
		$this->db->delete("akun_kas6",$where);

		return true;
		//var_dump($this->db->delete("program"));die;
	}

	function get_single_akun_kas4($where,$field){

		$this->db->where($where);

		$query = $this->db->get('akun_kas4')->row();

		if(empty($field)){
			return $query ;
		}
		elseif($field=='nama'){
			return $query->nm_kas_4 ;
		}


	}

	
}
?>