<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
/* -------------- Constructor ------------- */
private $db2;
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	

	/* Method untuk menghapus data user */
	function delete_user($username){
		return $this->db->delete("rsa_user",array('username'=>$username));
	}
	
	/* Method untuk menambah data user */
	function add_user($data){
		return $this->db->insert("rsa_user",$data);
	}
	
	function edit_user($data,$where){
		//var_dump($data);die;
		$this->db->where("username",$where);
		return $this->db->update('rsa_user',$data);
	}
	
	/* Method untuk mengambil data subunit */
		
	 function get_subunit2(){
		$rba = $this->load->database('rba', TRUE);
	 	$query = $rba->query("	SELECT 	kode_unit AS kode_unit_subunit, 
									nama_unit AS nama_unit_subunit 
							FROM unit
							WHERE kode_unit != '99' 
							
							UNION
							
							SELECT kode_subunit AS kode_unit_subunit, 
								nama_subunit AS nama_unit_subunit 
							FROM subunit 
							WHERE RIGHT(kode_subunit,2) != '99' OR  kode_subunit='9999'

							UNION
							
							SELECT kode_sub_subunit AS kode_unit_subunit, 
								nama_sub_subunit AS nama_unit_subunit 
							FROM sub_subunit 

							ORDER BY kode_unit_subunit ASC");

		if ($query->num_rows()>0){
			$subunit = $query->result();
			
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

	/* EDIT BY IDRIS
		function get_subunit2(){
		$rba = $this->load->database('rba', TRUE);
		$query = $rba->query("SELECT kode_unit AS kode_unit_subunit, 
									nama_unit AS nama_unit_subunit 
									
							FROM unit
							WHERE kode_unit != '99' 
							
						ORDER BY kode_unit ASC");

		if ($query->num_rows()>0){
			$subunit = $query->result();
			
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

					


					$opt_subunit["$row->kode_unit_subunit"] = $row->kode_unit_subunit.' - '.$row->nama_unit_subunit.'' ;

				}
				
			return $opt_subunit;
		
		}else{
			return array();
		}
	}
*/
        function search_user($kata_kunci='',$batas='',$get=''){
		/*	Filter xss n sepecial char */
		$rba = $this->load->database('rba', TRUE);
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
				$where1 .= " WHERE ( rba.unit.nama_unit LIKE '%{$kata_kunci}%' "; 
				$where1 .= " OR rsa_user.username LIKE '%{$kata_kunci}i%' ) ";
				

				$where2 .= " WHERE ( rba.subunit.nama_subunit LIKE '%{$kata_kunci}%' "; 
				$where2 .= " OR rsa_user.username LIKE '%{$kata_kunci}%' ) "; 

				$where3 .= " WHERE ( rba.sub_subunit.nama_sub_subunit LIKE '%{$kata_kunci}%' "; 
				$where3 .= " OR rsa_user.username LIKE '%{$kata_kunci}%' ) "; 
				
				//$where4 .= " WHERE ( rsa_user.nm_lengkap LIKE '%{$kata_kunci}%' "; 
				 
			}
			//$this->db->order_by("username", "asc"); 
		}

		$sql1 = ' 	SELECT 	
						nama_unit AS nama_subunit,
						username,
						level,
						kode_unit_subunit,
						flag_aktif,
						nm_lengkap,
						nomor_induk,
						nama_bank,
						no_rek,
						npwp,
						alamat,
						kd_pisah

					FROM rsa_user
					
					JOIN rba.unit ON rba.unit.kode_unit = rsa_user.kode_unit_subunit

					'.$where.$where1.'

					UNION

					SELECT 	
							nama_subunit AS nama_subunit,
							username,
							level,
							kode_unit_subunit,
							flag_aktif,
							nm_lengkap,
						nomor_induk,
						nama_bank,
						no_rek,
						npwp,
						alamat,
							kd_pisah

					FROM rsa.rsa_user

					JOIN rba.subunit ON rba.subunit.kode_subunit = rsa_user.kode_unit_subunit

					'.$where.$where2.'

					UNION

					SELECT 	
							nama_sub_subunit AS nama_subunit,
							username,
							level,
							kode_unit_subunit,
							flag_aktif,
							nm_lengkap,
						nomor_induk,
						nama_bank,
						no_rek,
						npwp,
						alamat,
							kd_pisah

					FROM rsa.rsa_user

					JOIN rba.sub_subunit ON rba.sub_subunit.kode_sub_subunit = rsa_user.kode_unit_subunit

					'.$where.$where3.'

					ORDER BY level,username ASC
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
        
        
        function get_detail_rsa_user($kode_unit,$level){
            $this->db->where('level',$level);
            $this->db->where('kode_unit_subunit',$kode_unit);
            
            $q = $this->db->get('rsa_user');
            return $q->row();
            
            
            
            
        }
        
        function get_detail_rsa_user_by_username($username){
            $this->db->where('username',$username);
            
            $q = $this->db->get('rsa_user');
            return $q->row();
            
            
            
        }
        function get_detail_edit_user($username,$level){
            $this->db->where('username',$username);
            $this->db->where('level',$level);
            
            $q = $this->db->get('rsa_user');
            return $q->row();   
        }
		function get_subunit_warek(){
		
		$option['']	= nbs(1)."- Pilih Kode Unit Pemisah -".nbs(1);
		$rba = $this->load->database('rba', TRUE);
		$query = $rba->query("SELECT kode_subunit, nama_subunit
									FROM rba.subunit WHERE LEFT(kode_subunit,1)=4
									ORDER BY kode_subunit ASC");
		foreach ($query->result() as $row){
			$option[$row->kode_subunit] = nbs(1).'('.$row->kode_subunit.') '.$row->nama_subunit.nbs(1);
		}
		//print_r($option);
		return $option;
	}
		
}
?>