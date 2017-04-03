<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Subunit_model extends CI_Model{
	
	//define constructor
	function __construct(){
		parent::__construct();
	}
	
	#define methods ----------------------
	
	//define method search_subunit()
	//this method for search unit 
	function search_subunit($kode_unit='',$kata_kunci=''){
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		$kode_unit = substr($kode_unit,0,2);
		$where = "left(kode_subunit,2) = '{$kode_unit}'";
		if($kata_kunci!='')
		{
			$where .= " AND (kode_subunit LIKE '%{$kata_kunci}%' OR nama_subunit LIKE '%{$kata_kunci}%')";
		}
		$this->db->where($where);
		$this->db->order_by("kode_subunit", "asc"); 
		/* running query	*/
		$query		= $this->db->get('rsa_subunit');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	//define add_unit()
	function add_subunit($data){
		return $this->db->insert('rsa_subunit',$data);
	}
	
	//define get_output()
	function get_subunit($where=""){
		if(is_array($where)){
			$this->db->where('kode_subunit',$where['kode_subunit']);
		}else if($where!=""){
			$this->db->where('kode_subunit',$where);
		}
		$query = $this->db->get('rsa_subunit');
		if ($query->num_rows>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	//define edit_output()
	function edit_subunit($data,$where){
		if(is_array($where)){
			$this->db->where('kode_subunit',$where['kode_subunit']);
		}
		return $this->db->update('rsa_subunit',$data);
	}
	
	//define delete_subunit()
	function delete_subunit($kode_subunit){
		$this->db->where('kode_subunit',$kode_subunit);
		return $this->db->delete('rsa_subunit');
	}

	function get_single_subunit($where="",$field){

		$this->db->where('kode_subunit',$where);

		$query = $this->db->get('rsa_subunit')->row();

		if(empty($field)){
			return $query ;
		}
		elseif($field=='nama'){
			return $query->nama_subunit ;
		}

		


	}

	function get_child_subunit($subunit){
            
                $rba = $this->load->database('rba', TRUE);
                
		$rba->where('LEFT(kode_subunit,'.strlen($subunit).')',$subunit);

		$query = $rba->order_by('kode_subunit','ASC')->get('subunit');

		$result = $query->result();

		return $result ;

	}

	
}
?>
