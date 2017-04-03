<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
class Master_unit_model extends CI_Model{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
	}
	
	function get_unit($select="",$where="",$order="",$limit="",$start=0){
		if(!empty($select)) $this->db->select($select);
		if(!empty($where)) $this->db->where($where);
		if(!empty($order)) $this->db->order_by($order);
		if(!empty($limit)) $this->db->limit((int)$limit, (int)$start);
		
		$q = $this->db->get("rsa_unit");
		return $q->result();
	}
	
	function add_unit($data=''){
		if(!empty($data)){
			return $this->db->insert('rsa_unit',$data);
		}		
		return false;
	}
	
	function delete_unit($where=""){
		if(!empty($where)){
			return $this->db->delete("rsa_unit",$where);
		}
		return false;
	}
	
	function edit_unit($data="",$where=""){
		return $this->db->update('rsa_unit',$data,$where);
	}
	
	function search_unit($kata_kunci=''){
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		if($kata_kunci!='')
		{
			$this->db->like('kode_unit', $kata_kunci);
			$this->db->or_like('nama_unit', $kata_kunci); 
		}
		$this->db->order_by("kode_unit", "asc"); 
		/* running query	*/
		$query		= $this->db->get('rsa_unit');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function get_subunit($select="",$where="",$order="",$limit="",$start=0){
		if(!empty($select)) $this->db->select($select);
		if(!empty($where)) $this->db->where($where);
		if(!empty($order)) $this->db->order_by($order);
		if(!empty($limit)) $this->db->limit((int)$limit, (int)$start);
		
		$q = $this->db->get("rsa_subunit");
		return $q->result();
	}
	
	function add_subunit($data=''){
		if(!empty($data)){
			return $this->db->insert('rsa_subunit',$data);
		}		
		return false;
	}
	
	function delete_subunit($where=""){
		if(!empty($where)){
			return $this->db->delete("rsa_subunit",$where);
		}
		return false;
	}
	function edit_subunit($data="",$where=""){
		return $this->db->update('rsa_subunit',$data,$where);
	}
	
	function search_subunit($kata_kunci='', $where=""){
		/*	Filter xss n sepecial char */
		/*
		if($kata_kunci!='')
		{
			$this->db->like('kode_subunit', $kata_kunci);
			$this->db->or_like('nama_subunit', $kata_kunci); 
			$this->db->or_like('nama_pejabat', $kata_kunci); 
			$this->db->or_like('nip', $kata_kunci); 
		}
		$this->db->order_by("kode_subunit", "asc"); 
		/* running query	*/
		//$query		= $this->db->get('subunit');
		$kata_kunci	= form_prep($kata_kunci);
		$kode_pendapatan = !empty($where['kode_unit'])?form_prep($where['kode_unit']):'';
		$query		= $this->db->query("
									SELECT * 
									FROM rsa_subunit
									WHERE 
										LEFT(kode_subunit,2)='{$kode_pendapatan}' AND 
										(
											kode_subunit LIKE '%{$kata_kunci}%' OR 
											nama_subunit LIKE '%{$kata_kunci}%' OR
											nama_pejabat LIKE '%{$kata_kunci}%' OR
											nip LIKE '%{$kata_kunci}%'
										)
									ORDER BY
										kode_subunit 
										");
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function get_unit_subunit($limit="",$start=0){
		$limit = !empty($limit)?" LIMIT $start,{$limit}":'';
		$q = $this->db->query("SELECT * 
								FROM rsa_unit
								LEFT JOIN rsa_subunit ON
									LEFT(subunit.kode_subunit,2)=unit.kode_unit
								$limit
								ORDER BY unit.kode_unit, subunit.kode_subunit");
		return $q->result();
	}

	// ADD BY IDRIS



	function get_single_subunit($where){

		if(!empty($where)) $this->db->where($where);
		
		$q = $this->db->get("rsa_subunit");
		return $q->result();
	}

	function get_single_parent_unit($where,$field=''){

		$this->db->where('kode_unit',substr($where,0,2));
		
		$q = $this->db->get("rsa_unit");

		if($field=='nama'){
			return $q->row()->nama_unit;
		}else{
			return $q->row();
		}
	}

	function get_child_unit(){
		// $this->db->where('unit',$subunit);
            
                $rba = $this->load->database('rba',TRUE);

		$query = $rba->order_by('kode_unit','ASC')->get('unit');

		$result = $query->result();

		return $result ;

	}




}