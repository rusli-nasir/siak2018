<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Spm_model extends CI_Model {
/* -------------- Constructor ------------- */

	
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				//$this->db2 = $this->load->database('rba', TRUE);
        }
	
	function search_spm($kata_kunci=''){
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		if($kata_kunci!='')
		{
			$this->db->like('kd_spm', $kata_kunci);
			$this->db->or_like('no_spm', $kata_kunci);
		}
		$this->db->order_by("id", "asc"); 
		/* running query	*/
		$query		= $this->db->get('rsa_spm');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	function add_spm($data){
		//print_r($data);die;
		return $this->db->insert("rsa_spm",$data);
		
	}
	function get_jenis(){
		$this->db->select('kd_spm,jenis_spm');
		$this->db->from('rsa_jenis_spm');
		$this->db->order_by("kd_spm", "asc"); 
		$query = $this->db->get();
		if ($query->num_rows()>0){
			$subunit = $query->result();
				foreach($subunit as $row){
					$opt_jenis["$row->kd_spm"] = $row->jenis_spm;
				}
			return $opt_jenis;
		
		}else{
			return array();
		}
	}
	
	
	
}
?>