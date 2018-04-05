<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Akun_kas_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
/* -------------- Method ------------- */
	/*	Fungsi untuk mencari data kegiatan	*/
	function search_akun_kas($kata_kunci=''){
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		if($kata_kunci!='')
		{
			$this->db->like('kd_kas_2', $kata_kunci);
			$this->db->or_like('nm_kas_2', $kata_kunci); 
		}
		$this->db->order_by("kd_kas_2", "asc"); 
		/* running query	*/
		$query		= $this->db->get('akun_kas2');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	/* Method untuk mengambil data kegiatan */
	function get_akun_kas(){
		$rba = $this->load->database('rba', TRUE);
		$query = "SELECT DISTINCT kode_akun1digit,nama_akun1digit FROM akun_belanja ORDER BY kode_akun1digit";
		$query = $rba->query($query);

		if($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	/* Method untuk mengubah data kegiatan */
	function edit_akun_kas($data,$where){
		$this->db->where("kd_kas_2",$where);
		return $this->db->update('akun_kas2',$data);
	}
	
	/* Method untuk menghapus data kegiatan */
	function delete_akun_kas($kd_kas_2){
		$this->db->delete("akun_kas2",array('kd_kas_2'=>$kd_kas_2));
		/* $this->db->delete("akun_kas3",array('kd_kas_2'=>$kd_kas_2));
		$this->db->delete("akun_kas4",array('kd_kas_2'=>$kd_kas_2));
		$this->db->delete("akun_kas5",array('kd_kas_2'=>$kd_kas_2));
		$this->db->delete("akun_kas6",array('kd_kas_2'=>$kd_kas_2));*/
		return true;
	}
	
	/* Method untuk menambah data kegiatan */
	function add_akun_kas($data){
		return $this->db->insert("akun_kas2",$data);
	}


	function get_single_akun_kas($where,$field){

		$this->db->where($where);

		$query = $this->db->get('akun_kas2')->row();

		if(empty($field)){
			return $query ;
		}
		elseif($field=='nama'){
			return $query->nm_kas_2 ;
		}


	}

}
?>