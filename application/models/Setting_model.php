<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Setting_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
/* -------------- Method ------------- */
	// function get_tahun(){
	// 	$this->db->where('nama','tahun');
	// 	$query =$this->db->get('setting');
	// 	if($query->num_rows()!=1){
	// 		return false;
	// 	}else{
	// 		$tahun = $query->row();
	// 		return $tahun->nilai;
	// 	}
	// }
	
	function edit_tahun($tahun){
		$this->db->where('nama','tahun');
		$this->db->update('setting',array('nilai'=>$tahun));
	}
	
	// function get_available_tahun($unit=""){
		
	// 	$q = $this->db->query("SELECT tahun FROM detail_belanja WHERE flag_cetak='1'
	// 							UNION SELECT tahun FROM detail_pendapatan WHERE flag_cetak='1' GROUP BY tahun ORDER BY tahun DESC");
	// 	return $q->result();
	// }

	// ADDED BY IDRIS

	function get_pagu($tahun=''){
		if($tahun==''){
			$tahun = $this->get_tahun();
		}
		//$this->db->where('nama','tahun');
		$this->db->where('nilai',$tahun);
		$query =$this->db->get('setting');
		if($query->num_rows()!=1){
			return false;
		}else{
			$tahun = $query->row();
			return array('selain_apbn' => $tahun->selain_apbn,'apbn_bpptnbh' => $tahun->apbn_bpptnbh,'apbn_lainnya' => $tahun->apbn_lainnya);
		}
	}

	function edit_apbn($selain_apbn,$tahun=''){
		if($tahun==''){
			$tahun = $this->get_tahun();
		}
		//var_dump($tahun);die;
		//$this->db->where('nama','tahun');
		$this->db->where('flag','1');
		$this->db->update('setting',array('selain_apbn'=>$selain_apbn));
	}

	function edit_apbn_bpptnbh($apbn_bpptnbh,$tahun=''){
		if($tahun==''){
			$tahun = $this->get_tahun();
		}
		//$this->db->where('nama','tahun');
		$this->db->where('nilai',$tahun);
		$this->db->update('setting',array('apbn_bpptnbh'=>$apbn_bpptnbh));
	}

	function edit_apbn_lainnya($apbn_lainnya,$tahun=''){
		if($tahun==''){
			$tahun = $this->get_tahun();
		}
		//$this->db->where('nama','tahun');
		$this->db->where('nilai',$tahun);
		$this->db->update('setting',array('apbn_lainnya'=>$apbn_lainnya));
	}

	function get_tahun(){
		$this->db->where('flag','1');
		$query =$this->db->get('setting');
		if($query->num_rows()!=1){
			return false;
		}else{
			$tahun = $query->row();
			return $tahun->nilai;
		}
	}

	function get_gup(){
		$this->db->where('flag','1');
		$query =$this->db->get('setting');
		if($query->num_rows()!=1){
			return false;
		}else{
			$tahun = $query->row();
			return $tahun->gup;
		}
	}

	function get_tup(){
		$this->db->where('flag','1');
		$query =$this->db->get('setting');
		if($query->num_rows()!=1){
			return false;
		}else{
			$tahun = $query->row();
			return $tahun->tup;
		}
	}


	function get_lsk(){
		$this->db->where('flag','1');
		$query =$this->db->get('setting');
		if($query->num_rows()!=1){
			return false;
		}else{
			$tahun = $query->row();
			return $tahun->lsk;
		}
	}

	function get_lsnk(){
		$this->db->where('flag','1');
		$query =$this->db->get('setting');
		if($query->num_rows()!=1){
			return false;
		}else{
			$tahun = $query->row();
			return $tahun->lsnk;
		}
	}

	function get_available_tahun($unit=""){
		
		$q1 = $this->db->query("SELECT tahun FROM detail_belanja WHERE flag_cetak='1'
								UNION SELECT tahun FROM detail_pendapatan WHERE flag_cetak='1' GROUP BY tahun ORDER BY tahun DESC");
		$r1 = $q1->result();

		$q2 = $this->db->query("SELECT nilai FROM setting");

		$r2 = $q2->result();

		//var_dump($r1);
		//var_dump($r2);
		//die;

		return compact($r1,$r2);
	}

	function ubah_tahun($tahun){
		$this->reset_flag_setting();
		$query = $this->db->where('nilai',$tahun)->get('setting');

		if($query->num_rows()!=0){
			$this->db->where('nilai',$tahun);
			$this->db->update('setting',array('flag'=>'1'));
		}
		else{
			$this->db->insert('setting',array('nilai'=>$tahun,'flag'=>'1','lsk'=>'1','lsnk'=>'1'));
					//var_dump($query);die;
		}



		
	}

	function ubah_gup($posisi){


			$this->db->where('flag','1');
			$this->db->update('setting',array('gup'=>$posisi));

		
	}

	function ubah_tup($posisi){


			$this->db->where('flag','1');
			$this->db->update('setting',array('tup'=>$posisi));

		
	}

	function ubah_lsk($posisi){


			$this->db->where('flag','1');
			$this->db->update('setting',array('lsk'=>$posisi));

		
	}

	function ubah_lsnk($posisi){


			$this->db->where('flag','1');
			$this->db->update('setting',array('lsnk'=>$posisi));

		
	}

	function reset_flag_setting(){
		$this->db->where('flag','1');
		$this->db->update('setting',array('flag'=>'0'));
	}

}
?>