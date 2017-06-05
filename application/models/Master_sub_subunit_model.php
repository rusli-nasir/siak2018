<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
class Master_sub_subunit_model extends CI_Model{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
	}

	function get_sub_subunit($select="",$where="",$order="",$limit="",$start=0){
		if(!empty($select)) $this->db->select($select);
		if(!empty($where)) $this->db->where($where);
		if(!empty($order)) $this->db->order_by($order);
		if(!empty($limit)) $this->db->limit((int)$limit, (int)$start);
		
		$q = $this->db->get("rsa_sub_subunit");
		return $q->result();
	}

	function add_sub_subunit($data=''){
		if(!empty($data)){
			return $this->db->insert('rsa_sub_subunit',$data);
		}		
		return false;
	}

	function delete_sub_subunit($where=""){
		if(!empty($where)){
			return $this->db->delete("rsa_sub_subunit",$where);
		}
		return false;
	}

	function edit_sub_subunit($data="",$where=""){
		return $this->db->update('rsa_sub_subunit',$data,$where);
	}

	function get_single_sub_subunit($where="",$field=""){

		$rba = $this->load->database('rba', TRUE);

		$rba->where('kode_sub_subunit',$where);

		$query = $rba->get('sub_subunit')->row();

		if(empty($field)){
			return $query ;
		}
		elseif($field=='nama'){
			return $query->nama_sub_subunit ;
		}

		


	}

	function get_child_sub_subunit($subunit){
                
                $rba = $this->load->database('rba', TRUE);
                
		$rba->where('LEFT(kode_sub_subunit,'.strlen($subunit).')',$subunit);

		$query = $rba->order_by('kode_sub_subunit','ASC')->get('sub_subunit');

		$result = $query->result();

		return $result ;

	}



}