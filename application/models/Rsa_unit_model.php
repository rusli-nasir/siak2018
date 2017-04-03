<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rsa_unit_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
/* -------------- Method ------------- */
	/*	Fungsi untuk mencari data rsa_unit	*/
	function search_rsa_unit($kata_kunci=''){
		/*	Filter xss n sepecial char */
		
		$kata_kunci	= form_prep($kata_kunci);
		if($kata_kunci!='')
		{
			$this->db->like('no', $kata_kunci);
			$this->db->or_like('kode_unit_rba', $kata_kunci); 
			$this->db->or_like('kode_unit_kepeg', $kata_kunci); 
		}
		$this->db->order_by("no", "asc"); 
		/* running query	*/
		$query		= $this->db->get('rsa_unit');
		
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	function get_rsa_unit($where=""){
		if(!$where==""){
			$this->db->where('kode_unit_rba',$where);
		}
		$this->db->order_by("kode_unit_rba");
		$query = $this->db->get("rsa_unit");
	//	print_r($query);die;
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	/* Method untuk menghapus data user */
	function delete_rsa_unit($id){
		return $this->db->delete("rsa_unit",array('no'=>$id));
	}
	
	/* Method untuk menambah data user */
	function add_rsa_unit($data){
		return $this->db->insert("rsa_unit",$data);
	}
	
	function edit_rsa_unit($data,$where){
		$this->db->where("no",$where);
		return $this->db->update('rsa_unit',$data);
	}
	
	/* Method untuk mengambil data subunit */
	function get_subunit(){
		$this->db->select('kode_subunit, nama_subunit');
		$this->db->from('rsa_subunit');
		$this->db->order_by("nama_subunit", "asc"); 
		$query = $this->db->get();
		if ($query->num_rows()>0){
			$subunit = $query->result();
				foreach($subunit as $row){
					$opt_subunit["$row->kode_subunit"] = $row->nama_subunit;
				}
			return $opt_subunit;
		
		}else{
			return array();
		}
	}
	
	// function get_subunit2(){
	// 	$query = $this->db->query("	SELECT 	kode_unit AS kode_unit_subunit, 
	// 								nama_unit AS nama_unit_subunit 
	// 						FROM unit
	// 						WHERE kode_unit != '99' 
							
	// 						UNION
							
	// 						SELECT kode_subunit AS kode_unit_subunit, 
	// 							nama_subunit AS nama_unit_subunit 
	// 						FROM subunit 
	// 						WHERE RIGHT(kode_subunit,2) != '99' OR  kode_subunit='9999'

	// 						UNION
							
	// 						SELECT kode_subunit AS kode_unit_subunit, 
	// 							nama_subunit AS nama_unit_subunit 
	// 						FROM subunit 
	// 						WHERE RIGHT(kode_subunit,2) != '99' OR  kode_subunit='9999'

	// 						ORDER BY nama_unit_subunit ASC");

	// 	if ($query->num_rows()>0){
	// 		$subunit = $query->result();
			
	// 			foreach($subunit as $row){
	// 				$opt_subunit["$row->kode_unit_subunit"] = $row->nama_unit_subunit.($row->kode_unit_subunit=='9999'?' [admin]':(strlen($row->kode_unit_subunit)>2?" [subunit]":" [unit]"));
	// 			}
				
	// 		return $opt_subunit;
		
	// 	}else{
	// 		return array();
	// 	}
	// }
	
	function non_aktif(){
		$this->db->where("level !=","1");
		$data = array(
				"flag_aktif"	=> "tidak",
			);
		return $this->db->update('rsa_user',$data);
	}
	
	function aktif(){
		$this->db->where("level !=","1");
		$data = array(
				"flag_aktif"	=> "ya",
			);
		return $this->db->update('rsa_user',$data);
	}

	// EDIT BY IDRIS

		function get_subunit2(){
		$rba = $this->load->database('rba', TRUE);
		$query = "SELECT kode_unit AS kode_unit_subunit,nama_unit AS nama_unit_subunit 
				FROM unit WHERE kode_unit != '99' UNION SELECT kode_subunit AS kode_unit_subunit, 
				nama_subunit AS nama_unit_subunit 
				FROM subunit WHERE RIGHT(kode_subunit,2) != '99' OR  kode_subunit='9999' UNION
				SELECT kode_sub_subunit AS kode_unit_subunit, nama_sub_subunit AS nama_unit_subunit 
				FROM sub_subunit ORDER BY kode_unit_subunit ASC";
		$q=$rba->query($query);
		if ($q->num_rows()>0){
			
			
			$subunit =$q->result();
			
				foreach($subunit as $row){

					$unit = "";


					if( $row->kode_unit_subunit =='9999' ){
						$unit = "admin";
					}
					else{
						if(strlen($row->kode_unit_subunit)==2){
							$unit = "unit";
						}
						elseif(strlen($row->kode_unit_subunit)==4){
							$unit = "subunit";
						}
						elseif(strlen($row->kode_unit_subunit)==6){
							$unit = "sub_subunit";
						}

					}

					


					$opt_subunit["$row->kode_unit_subunit"] = $row->kode_unit_subunit.' - '.$row->nama_unit_subunit.' ['.$unit.']' ;

				}
				
			return $opt_subunit;
		
		}else{
			return array();
		}
	}

        function search_user($kata_kunci='',$batas='',$get=''){
		/*	Filter xss n sepecial char */

		$kata_kunci	= form_prep($kata_kunci);

		$where = '';
		$where1 = '';
		$where2 = '';
		$where3 = '';

		if ($get=='id')
		{	
			$where .= " WHERE rsa_user.username = '{$kata_kunci}' " ; 
		} else {
			if($kata_kunci!='')
			{
				$where1 .= " WHERE ( rsa_unit.nama_unit LIKE '%{$kata_kunci}%' "; 
				$where1 .= " OR rsa_user.username LIKE '%{$kata_kunci}i%' ) ";

				$where2 .= " WHERE ( rsa_subunit.nama_subunit LIKE '%{$kata_kunci}%' "; 
				$where2 .= " OR rsa_user.username LIKE '%{$kata_kunci}%' ) "; 

				$where3 .= " WHERE ( rsa_sub_subunit.nama_sub_subunit LIKE '%{$kata_kunci}%' "; 
				$where3 .= " OR rsa_user.username LIKE '%{$kata_kunci}%' ) "; 
			}
			//$this->db->order_by("username", "asc"); 
		}

		$sql1 = ' 	SELECT 	
						nama_unit AS nama_subunit,
						username,
						level,
						kode_unit_subunit,
						flag_aktif,
						user_revisi

					FROM rsa_user
					
					JOIN rsa_unit ON rsa_unit.kode_unit = rsa_user.kode_unit_subunit

					'.$where.$where1.'

					UNION

					SELECT 	
							nama_subunit AS nama_subunit,
							username,
							level,
							kode_unit_subunit,
							flag_aktif,
							user_revisi

					FROM rsa_user

					JOIN rsa_subunit ON rsa_subunit.kode_subunit = rsa_user.kode_unit_subunit

					'.$where.$where2.'

					UNION

					SELECT 	
							nama_sub_subunit AS nama_subunit,
							username,
							level,
							kode_unit_subunit,
							flag_aktif,
							user_revisi

					FROM rsa_user

					JOIN rsa_sub_subunit ON rsa_sub_subunit.kode_sub_subunit = rsa_user.kode_unit_subunit

					'.$where.$where3.'

					ORDER BY kode_unit_subunit,level,username ASC
				';
		
		

		if ($batas!=''){
			$sql .= 'LIMIT 0, ' . $batas ;
			$query	= $this->db->query($sql1);
		}
		else {
			$query	= $this->db->query($sql1);
		}

		if ($query->num_rows()>0){
			return $query->result();
		}
		else{
			return array();
		}

	}

	function delete_user_by_unit($unit){
		
		$where = '';

		if(strlen($unit)==2){
			$where = 'LEFT(kode_unit_subunit,2)';
		}
		elseif(strlen($unit)==4){
			$where = 'LEFT(kode_unit_subunit,4)';
		}
		else{
			$where = 'kode_unit_subunit';
		}

		return $this->db->delete("rsa_user",array($where=>$unit));

	}
}
?>