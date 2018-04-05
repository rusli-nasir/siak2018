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
		// var_dump($data);die;
		$this->db->where("username",$where);
		return $this->db->update('rsa_user',$data);
	}

	function update_verifikator($data,$where){
		// var_dump($data);die;
		$this->db->where("kode_unit_subunit",$where);
		return $this->db->update('rsa_verifikator_unit',$data);
	}
	function tambah_verifikator($data){
		return $this->db->insert("rsa_verifikator_unit",$data);
	}


	function delete_verifikator($data,$where){
		// var_dump($data);die;
		$this->db->where("id_verifikator_unit",$where);
		return $this->db->update('rsa_verifikator_unit',$data);
	}

	function delete_mapping_verifikator($id_verifikator_unit){
		// var_dump($data);die;
		$this->db->where("id_verifikator_unit",$id_verifikator_unit);
		return $this->db->delete("rsa_verifikator_unit");
	}

	function check_mapping_exist($kode_unit_subunit){
		$this->db->where("kode_unit_subunit",$kode_unit_subunit);
		$q = $this->db->get("rsa_verifikator_unit");
		if($q->num_rows() > 0 ){
			return $q->row_array();
		}else{
			return array();
		}

	}

	function insert_mapping_verifikator($data){
		return $this->db->insert("rsa_verifikator_unit",$data);

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
							$opt_subunit["$row->kode_unit_subunit"] = array(
									'id_unit' => 0,
									'id' => $row->kode_unit_subunit,
									'nama' => $row->kode_unit_subunit.' - '.$row->nama_unit_subunit.' ['.$unit.']'
								);
						}
						elseif(strlen($row->kode_unit_subunit)==4){
							$unit = "subunit";
							$opt_subunit["$row->kode_unit_subunit"] = array(
									'id_unit' => 0,
									'id' => $row->kode_unit_subunit,
									'nama' => '&nbsp;&nbsp;&nbsp;&nbsp;'.$row->kode_unit_subunit.' - '.$row->nama_unit_subunit.' ['.$unit.']'
								);
						}
						elseif(strlen($row->kode_unit_subunit)==6){
							$unit = "sub_subunit";
							$opt_subunit["$row->kode_unit_subunit"] = array(
									'id_unit' => 0,
									'id' => $row->kode_unit_subunit,
									'nama' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row->kode_unit_subunit.' - '.$row->nama_unit_subunit.' ['.$unit.']'
								);
						}

					}

				}
				// vdebug($opt_subunit);
			return $opt_subunit;
		
		}else{
			return array();
		}
	}

	function get_subunit_pusat(){
		$rba = $this->load->database('rba', TRUE);
	 	$query = $rba->query("	SELECT 	kode_unit AS kode_unit_subunit, 
									nama_unit AS nama_unit_subunit 
							FROM unit
							WHERE kode_unit = 99 
							");

		if ($query->num_rows()>0){
			$subunit = $query->result();
			// vdebug($subunit);
				foreach($subunit as $row){

					$unit = "";

					if( $row->kode_unit_subunit =='9999' ){
						$unit = "admin";
					}
					else{
						if(strlen($row->kode_unit_subunit)==2){
							$unit = "unit";
							$opt_subunit_pusat["$row->kode_unit_subunit"] = array(
									'id_unit' => 0,
									'id' => $row->kode_unit_subunit,
									'nama' => $row->kode_unit_subunit.' - '.$row->nama_unit_subunit.' ['.$unit.']'
								);
						}			
					}
				}
				// vdebug($opt_subunit);
			return $opt_subunit_pusat;
		
		}else{
			return array();
		}
	}
	
		function get_2digit (){
		$rba = $this->load->database('rba', TRUE);
	 	$query2 = $rba->query("	SELECT 	kode_unit AS kode_unit_subunit, 
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
		if ($query2->num_rows()>0){
			$subunit = $query2->result();
				foreach($subunit as $row){
					$unit = "";
					if( $row->kode_unit_subunit =='9999' ){
						$unit = "admin";
					}
					else{
						if(strlen($row->kode_unit_subunit)==2){
							if (substr($row->kode_unit_subunit,0,2) != '14' && substr($row->kode_unit_subunit,0,2) != '15' && substr($row->kode_unit_subunit,0,2) != '16' && substr($row->kode_unit_subunit,0,2) != '17' ){
								$unit = "unit";
								$opt_subunit2["$row->kode_unit_subunit"] = array(
									'id_unit' => 0,
									'id' => $row->kode_unit_subunit,
									'nama' => '<b>'.$row->kode_unit_subunit.' - '.$row->nama_unit_subunit.' ['.$unit.'] </b>'
								);
							}
							elseif (substr($row->kode_unit_subunit,0,2) == '14' || substr($row->kode_unit_subunit,0,2) == '15' || substr($row->kode_unit_subunit,0,2) == '16' || substr($row->kode_unit_subunit,0,2) == '17' ){
								$unit = "unit";
								$opt_subunit2["$row->kode_unit_subunit"] = array(
									'id_unit' => $row->kode_unit_subunit,
									'id' => null,
									'nama' => '<b>'.$row->kode_unit_subunit.' - '.$row->nama_unit_subunit.' ['.$unit.'] </b>'
								);
							}
						}
						elseif(strlen($row->kode_unit_subunit)==4){
							if (substr($row->kode_unit_subunit,0,2) == '14' || substr($row->kode_unit_subunit,0,2) == '15' || substr($row->kode_unit_subunit,0,2) == '16' || substr($row->kode_unit_subunit,0,2) =='17' ){
								$unit = "subunit";
								$opt_subunit2["$row->kode_unit_subunit"] = array(
									'id_unit' => 0,
									'id' => $row->kode_unit_subunit,
									'nama' => '&nbsp;&nbsp;&nbsp;&nbsp;'.$row->kode_unit_subunit.' - '.$row->nama_unit_subunit.' ['.$unit.']'
								);
							}
						}
					}
				}
				// vdebug($opt_subunit2);
			return $opt_subunit2;
		}else{
			return array();
		}
	}

		function is_kpa_unit($level='',$subunit='') {
		    $this->db->select('username');
		    $this->db->where('level', $level);
		    $this->db->where('kode_unit_subunit', $subunit);
		    $query = $this->db->get('rsa_user');

		    if ($query->num_rows() > 0) {
		        return true;
		    } else {
		        return false;
		    }
		}

		function is_verifikator($unit='') {
		    $this->db->select('kode_unit_subunit');
		    $this->db->where('kode_unit_subunit', $unit);
		    $query = $this->db->get('rsa_verifikator_unit');

		    if ($query->num_rows() > 0) {
		        return true;
		    } else {
		        return false;
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

/*

	function get_daftar_user($search=''){

		$rba = $this->load->database('rba', TRUE);

		$sql = "SELECT b.nama_unit, FROM rsa_2018.rsa_user AS a JOIN rba_2018.unit AS b ON SUBSTR(a.kode_unit_subunit,1,2) = b.kode_unit
				WHERE  b.nama_unit = '{$search}' OR "


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
				$where1 .= " WHERE ( rba_2018.unit.nama_unit LIKE '%{$kata_kunci}%' "; 
				$where1 .= " OR rsa_user.username LIKE '%{$kata_kunci}i%' ) ";
				

				$where2 .= " WHERE ( rba_2018.subunit.nama_subunit LIKE '%{$kata_kunci}%' "; 
				$where2 .= " OR rsa_user.username LIKE '%{$kata_kunci}%' ) "; 

				$where3 .= " WHERE ( rba_2018.sub_subunit.nama_sub_subunit LIKE '%{$kata_kunci}%' "; 
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
					
					JOIN rba_2018.unit ON rba_2018.unit.kode_unit = substr(rsa_user.kode_unit_subunit,1,2)

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

					FROM rsa_user

					JOIN rba_2018.subunit ON rba_2018.subunit.kode_subunit = substr(rsa_user.kode_unit_subunit,1,2)

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

					FROM rsa_user

					JOIN rba_2018.sub_subunit ON rba_2018.sub_subunit.kode_sub_subunit = substr(rsa_user.kode_unit_subunit,1,2)

					'.$where.$where3.'

					ORDER BY SUBSTR(kode_unit_subunit,1,2),level,SUBSTR(kode_unit_subunit,1,6),username ASC
				';
		
		// echo $sql1; die;

		if ($batas!=''){
			// $sql .= 'LIMIT 0, ' . $batas ;
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
									FROM rba_2018.subunit WHERE LEFT(kode_subunit,1)=4
									ORDER BY kode_subunit ASC");
		foreach ($query->result() as $row){
			$option[$row->kode_subunit] = nbs(1).'('.$row->kode_subunit.') '.$row->nama_subunit.nbs(1);
		}
		//print_r($option);
		return $option;
	}

	public function get_user_verifikator_unit(){
		
		$query = "SELECT rsa_user.id,rsa_user.nm_lengkap,rsa_user.username,rsa_user.flag_aktif,rba_2018.unit.nama_unit,rba_2018.unit.alias,rsa_user.nomor_induk,id_verifikator_unit
						FROM rsa_verifikator_unit
						Join rsa_user
							ON rsa_user.id = rsa_verifikator_unit.id_user_verifikator
						JOIN rba_2018.unit
							ON rba_2018.unit.kode_unit = rsa_verifikator_unit.kode_unit_subunit
						ORDER BY rsa_user.id";
		$query = $this->db->query($query);
		// vdebug($query);

		if ($query->num_rows()>0){
			return $query->result();
		}
		else{
			return array();
		}
	}

	function get_nama_verifikator(){
		
		$query = "SELECT DISTINCT id,username,nm_lengkap
						FROM rsa_user
						WHERE level = 4
						ORDER BY rsa_user.id";
		$query = $this->db->query($query);
		// vdebug($query);

		if ($query->num_rows()>0){
			return $query->result();
		}
		else{
			return array();
		}
	}

	function get_unit_verifikator(){
		
	 	$query = "	SELECT 	kode_unit AS kode_unit_subunit, 
									nama_unit AS nama_unit_subunit 
							FROM rba_2018.unit
							WHERE kode_unit != 99
							";
		$query = $this->db->query($query);
		if ($query->num_rows()>0){
			$subunit = $query->result();
			// vdebug($subunit);
				foreach($subunit as $row){

					$unit = "";

					if( $row->kode_unit_subunit =='9999' ){
						$unit = "admin";
					}
					else{
						if(strlen($row->kode_unit_subunit)==2){
							$unit = "unit";
							$opt_unit_verifikator["$row->kode_unit_subunit"] = array(
									'id' => $row->kode_unit_subunit,
									'nama' => $row->kode_unit_subunit.' - '.$row->nama_unit_subunit.' ['.$unit.']'
								);
						}			
					}
				}
				// vdebug($opt_subunit);
			return $opt_unit_verifikator;
		
		}else{
			return array();
		}
	}
	
}
?>