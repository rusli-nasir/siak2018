<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ref_akun_model extends CI_Model {
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
			$this->db->like('kode_akun', $kata_kunci);
                        $this->db->or_like('kode_akun_sub', $kata_kunci);
			$this->db->or_like('nama_akun', $kata_kunci);
			$this->db->or_like('nama_akun_sub', $kata_kunci);			
		}
		$this->db->order_by("kode_akun", "asc"); 
		/* running query	*/
		$query		= $this->db->get('ref_akun');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	/* Method untuk mengambil data ref_akun */
	function get_ref_akun($where=""){
		//var_dump($where);die;
		if(!$where==""){
			$this->db->where('kode_akun_sub',$where);
		}
		$this->db->order_by("kode_akun_sub");
		$query = $this->db->get("ref_akun");
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function get_ref_akun_valid($where=""){
		//var_dump ($where);die;
		if(is_array($where)){
			$this->db->where("kode_akun_sub",$where["kode_akun_sub"]);
			//$this->db->where("kode_akun",$where["kode_akun"]);
		}
	
		$query = $this->db->get("ref_akun");
		//var_dump ($query);die;
		if ($query->num_rows() >0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	/* Method untuk mengubah data kegiatan */
	function edit_ref_akun($data,$where){
		//var_dump($where);die;
		$this->db->where("kode_akun_sub",$where);
		return $this->db->update('ref_akun',$data);
	}
	
	/* Method untuk menghapus data ref_akun */
	function delete_ref_akun($where){
		
		if(is_array($where)){
			$this->db->where("kode_akun",$where['kode_akun']);
			$this->db->where("kode_akun_sub",$where['kode_akun_sub']);
			//$this->db->where("kode_kegiatan",$where['kode_kegiatan']);
		}

		return $this->db->delete("ref_akun");
		//var_dump($this->db->delete("program"));die;
	}
	
	/* Method untuk menambah data kegiatan */
	function add_ref_akun($data){
		//var_dump($data);die;
		return $this->db->insert("ref_akun",$data);
	}


	function get_single_ref_akun($where="",$field){

		$this->db->where('kode_akun_sub',$where);

		$query = $this->db->get('ref_akun')->row();

		if(empty($field)){
			return $query ;
		}
		elseif($field=='nama'){
			return $query->nama_ref_akun ;
		}


	}

}
?>