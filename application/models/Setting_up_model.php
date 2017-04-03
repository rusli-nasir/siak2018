<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Setting_up_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
/* -------------- Method ------------- */
	function get_setting_up($subunit='',$tahun){
		$this->db->where("tahun",$tahun);
		if ($subunit!='')$this->db->where("kode_unit_subunit",$subunit);
		$this->db->order_by("kode_unit_subunit ASC");
		$q = $this->db->get("setting_up");
                $q = $q->row();
                return $q->jumlah;
	}
	
	/* Method untuk menghapus data revisi */
	function delete_setting_up($id_revisi){
		return $this->db->delete("setting_up",array('id_revisi'=>$id_revisi));
	}
	
	/* Method untuk menambah data revisi */
	function add_setting_up($data){
		//var_dump($data);var_dump($kode);die;
		return $this->db->insert("setting_up",$data);
	}
	
	function edit_setting_up($data,$kode,$tahun){
		//var_dump($data);var_dump($kode);die;
		$this->db->where("kode_unit_subunit",$kode);
		$this->db->where("tahun",$tahun);
		return $this->db->update('setting_up',$data);
	}
	
	function get_subunit($unit){
		$unit = ($unit=='9999')?'99':$unit;
		$rba = $this->load->database('rba', TRUE);
		$query = $rba->query("SELECT kode_subunit, nama_subunit
					FROM subunit
					WHERE LEFT(kode_subunit,2)='{$unit}' AND kode_subunit!='9999'
					ORDER BY kode_subunit ASC");
		return $query->result();
	}
	
	function get_unit(){
                $rba = $this->load->database('rba', TRUE);
		$query = $rba->query("SELECT kode_unit, nama_unit
					FROM unit
					WHERE kode_unit!='99'
					ORDER BY kode_unit ASC");
		return $query->result();
	}
		
	// function get_alokasi_per_subunit($tahun){
	// 	$query = $this->get_alokasi('',$tahun);
	// 	$alokasi = array();
	// 	if ($query->num_rows()>0)
	// 	{
	// 		$row = $query->result();
	// 		foreach($row as $baris){
	// 			$alokasi[$baris->kode_unit_subunit] = $baris->jumlah;
	// 			$alokasi['rm'.$baris->kode_unit_subunit] = $baris->rm;
	// 			$alokasi['lainnya'.$baris->kode_unit_subunit] = $baris->apbn_lainnya;
	// 		}
	// 	}
	// 	// echo '<pre>';var_dump($alokasi);echo '</pre>';die;
	// 	return $alokasi;
	// }
	
	function check_setting_up($subunit,$tahun){
		$this->db->where("tahun",$tahun);
		$this->db->where("kode_unit_subunit",$subunit);
		$query = $this->db->get("setting_up");
		if ($query->num_rows()==1){
			return true;
		} else {
			return false;
		}
	}
	
	function get_total_setting_up($unit,$tahun){
		$unit = ($unit=='9999')?'99':$unit;

		$query= '';

		if(strlen($unit)==2){
                    
			$query = $this->db->query("SELECT sum(jumlah) as total
					FROM rsa_subunit, setting_up
					WHERE LEFT(kode_subunit,2)='{$unit}' AND kode_subunit=kode_unit_subunit AND tahun='{$tahun}'");
		}
		elseif(strlen($unit)==4){
                    
			$query = $this->db->query("SELECT sum(jumlah) as total
					FROM rsa_sub_subunit, setting_up
					WHERE LEFT(kode_sub_subunit,4)='{$unit}' AND kode_sub_subunit=kode_unit_subunit AND tahun='{$tahun}'");
		}


		

		$row = $query->result();
		$total = $row[0]->total;

		if ($unit=='99'){
			$query = $this->db->query("SELECT sum(jumlah) as total
					FROM rkat_unit, setting_up
					WHERE kode_unit!='99' AND kode_unit=kode_unit_subunit AND tahun='{$tahun}'");
			$row = $query->result();

			$total = $total + $row[0]->total;
		}
		
		return $total;
	}


	
	function get_anggaran($subunit,$tahun){
		if (strlen($subunit)==2){
			$and = "AND LEFT(kode_usulan_belanja, 2) = '{$subunit}'";
		} else {
			$and = "AND LEFT(kode_usulan_belanja, 4) = '{$subunit}'";
		}
	
		$query = $this->db->query("SELECT SUM(volume*harga_satuan) as jumlah
		FROM (`detail_belanja`, `akun_belanja`) WHERE `tahun` = '{$tahun}' AND flag_cetak = '1' 
		AND RIGHT(kode_usulan_belanja,6)=kode_akun AND detail_belanja.sumber_dana = 'PNBP' AND akun_belanja.sumber_dana = 'PNBP' {$and}");
		
		return $query;
	}
	
	// ADDED BY HUDA
	function get_total_alokasi_rm($unit,$tahun){
		$unit = ($unit=='9999')?'99':$unit;

		$query= '';

		if(strlen($unit)==2){
			$query = $this->db->query("SELECT sum(rm) as total
					FROM subunit, platform
					WHERE LEFT(kode_subunit,2)='{$unit}' AND kode_subunit=kode_unit_subunit AND tahun='{$tahun}'");
		}
		elseif(strlen($unit)==4){
			$query = $this->db->query("SELECT sum(rm) as total
					FROM sub_subunit, platform
					WHERE LEFT(kode_sub_subunit,4)='{$unit}' AND kode_sub_subunit=kode_unit_subunit AND tahun='{$tahun}'");
		}

		$row = $query->result();
		$total = $row[0]->total;

		if ($unit=='99'){
			$query = $this->db->query("SELECT sum(rm) as total
					FROM unit, platform
					WHERE kode_unit!='99' AND kode_unit=kode_unit_subunit AND tahun='{$tahun}'");
			$row = $query->result();
			$total = $total + $row[0]->total;
		}
		
		return $total;
	}
	
	// function get_total_alokasi_all($unit,$tahun){
	// 	$unit = ($unit=='9999')?'99':$unit;
	// 	$query = $this->db->query("SELECT sum(rm+jumlah) as total
	// 				FROM subunit, platform
	// 				WHERE LEFT(kode_subunit,2)='{$unit}' AND kode_subunit=kode_unit_subunit AND tahun='{$tahun}'");
	// 	$row = $query->result();
	// 	$total = $row[0]->total;
	// 	if ($unit=='99'){
	// 		$query = $this->db->query("SELECT sum(rm+jumlah) as total
	// 				FROM unit, platform
	// 				WHERE kode_unit!='99' AND kode_unit=kode_unit_subunit AND tahun='{$tahun}'");
	// 		$row = $query->result();
	// 		$total = $total + $row[0]->total;
	// 	}
		
	// 	return $total;
	// }
	
	function get_anggaran_rm($subunit,$tahun){
		if (strlen($subunit)==2){
			$and = "AND LEFT(kode_usulan_belanja, 2) = '{$subunit}'";
		} else {
			$and = "AND LEFT(kode_usulan_belanja, 4) = '{$subunit}'";
		}
	
		$query = $this->db->query("SELECT SUM(volume*harga_satuan) as jumlah_rm
		FROM (detail_belanja, akun_belanja) WHERE tahun = '{$tahun}' AND flag_cetak = '1' 
		AND RIGHT(kode_usulan_belanja,6)=kode_akun AND detail_belanja.sumber_dana = 'RM' AND akun_belanja.sumber_dana = 'RM' {$and}");
		
		return $query;
	}
	
	function get_alokasi_rm_per_subunit($tahun){
		$query = $this->get_alokasi('',$tahun);
		$alokasi = array();
		if ($query->num_rows()>0)
		{
			$row = $query->result();
			foreach($row as $baris){
				$alokasi[$baris->kode_unit_subunit] = $baris->rm;
			}
		}
		return $alokasi;
	}
	
	function get_alokasi_all_per_subunit($tahun){
		$query = $this->get_alokasi('',$tahun);
		$alokasi = array();
		if ($query->num_rows()>0)
		{
			$row = $query->result();
			foreach($row as $baris){
				$alokasi[$baris->kode_unit_subunit] = $baris->jumlah+$baris->rm;
			}
		}
		return $alokasi;
	}

	// ADDED BY IDRIS

	function get_anggaran_lainnya($subunit,$tahun){
		if (strlen($subunit)==2){
			$and = "AND LEFT(kode_usulan_belanja, 2) = '{$subunit}'";
		} else {
			$and = "AND LEFT(kode_usulan_belanja, 4) = '{$subunit}'";
		}
	
		$query = $this->db->query("SELECT SUM(volume*harga_satuan) as jumlah_lainnya
		FROM (detail_belanja, akun_belanja) WHERE tahun = '{$tahun}' AND flag_cetak = '1' 
		AND RIGHT(kode_usulan_belanja,6)=kode_akun AND detail_belanja.sumber_dana = 'LAINNYA' AND akun_belanja.sumber_dana = 'LAINNYA' {$and}");
		
		return $query;
	}

	function get_total_alokasi_lainnya($unit,$tahun){
		$unit = ($unit=='9999')?'99':$unit;

		$query= '';

		if(strlen($unit)==2){
			$query = $this->db->query("SELECT sum(apbn_lainnya) as total
					FROM subunit, platform
					WHERE LEFT(kode_subunit,2)='{$unit}' AND kode_subunit=kode_unit_subunit AND tahun='{$tahun}'");
		}
		elseif(strlen($unit)==4){
			$query = $this->db->query("SELECT sum(apbn_lainnya) as total
					FROM sub_subunit, platform
					WHERE LEFT(kode_sub_subunit,4)='{$unit}' AND kode_sub_subunit=kode_unit_subunit AND tahun='{$tahun}'");
		}

		$row = $query->result();
		$total = $row[0]->total;
		if ($unit=='99'){
			$query = $this->db->query("SELECT sum(apbn_lainnya) as total
					FROM unit, platform
					WHERE kode_unit!='99' AND kode_unit=kode_unit_subunit AND tahun='{$tahun}'");
			$row = $query->result();
			$total = $total + $row[0]->total;
		}
		
		return $total;
	}

	

	function get_total_setting_alokasi_rm($unit,$tahun){
		$query = $this->db->query("SELECT apbn_bpptnbh as total
					FROM setting
					WHERE nilai='{$tahun}'");
		$row = $query->result();
		$total = $row[0]->total;
		
		return $total;
	}

	function get_total_setting_alokasi_lainnya($unit,$tahun){
		$query = $this->db->query("SELECT apbn_lainnya as total
					FROM setting
					WHERE nilai='{$tahun}'");
		$row = $query->result();
		$total = $row[0]->total;
		
		return $total;
	}
	function get_total_setting_setting_up($unit,$tahun){
		$query = $this->db->query("SELECT selain_apbn as total
					FROM setting
					WHERE nilai='{$tahun}'");
		$row = $query->result();
		$total = $row[0]->total;
		
		return $total;
	}

	// ADD BY IDRIS

	function delete_setting_up_by_unit($id){

		$where = '';

		if(strlen($id)==2){
			$where = 'LEFT(kode_unit_subunit,2)';
		}
		elseif(strlen($id)==4){
			$where = 'LEFT(kode_unit_subunit,4)';
		}
		else{
			$where = 'kode_unit_subunit';
		}

		return $this->db->delete("setting_up",array($where=>$id));

	}

	function get_setting_up_per_unit($units,$tahun){

		$setting_up = array();

		foreach($units as $unit){
			$setting_up_x = array();
			$this->db->where("kode_unit_subunit",$unit->kode_unit);
			$this->db->where("tahun",$tahun);			
			$q = $this->db->get("setting_up");
			$row = $q->row();
			$setting_up_x[$unit->kode_unit] = isset($row->jumlah)?$row->jumlah:0 ;
			//$alokasi_x['rm'.$unit->kode_unit] = isset($row->rm)?$row->rm:0 ;
			//$alokasi_x['lainnya'.$unit->kode_unit] = isset($row->apbn_lainnya)?$row->apbn_lainnya:0 ;
			$setting_up[] = $setting_up_x;
			

		}


		// if ($query->num_rows()>0)
		// {
		// 	$row = $query->result();
		// 	foreach($row as $baris){
		// 		$alokasi[$baris->kode_unit_subunit] = $baris->jumlah;
		// 		$alokasi['rm'.$baris->kode_unit_subunit] = $baris->rm;
		// 		$alokasi['lainnya'.$baris->kode_unit_subunit] = $baris->apbn_lainnya;
		// 	}
		// }

		 //echo '<pre>';var_dump($setting_up);echo '</pre>';die;
		return $setting_up;
	}
        
        function get_setting_up_per_subunit($subunits,$tahun){

		$setting_up = array();

		foreach($subunits as $unit){
                    foreach($unit as $u){
                        $setting_up_x = array();
			$this->db->where("kode_unit_subunit",$u->kode_subunit);
			$this->db->where("tahun",$tahun);			
			$q = $this->db->get("setting_up");
			$row = $q->row();
			$setting_up_x[$u->kode_subunit] = isset($row->jumlah)?$row->jumlah:0 ;
			//$alokasi_x['rm'.$unit->kode_unit] = isset($row->rm)?$row->rm:0 ;
			//$alokasi_x['lainnya'.$unit->kode_unit] = isset($row->apbn_lainnya)?$row->apbn_lainnya:0 ;
			$setting_up[] = $setting_up_x;
                        
                    }
			
			

		}


		// if ($query->num_rows()>0)
		// {
		// 	$row = $query->result();
		// 	foreach($row as $baris){
		// 		$alokasi[$baris->kode_unit_subunit] = $baris->jumlah;
		// 		$alokasi['rm'.$baris->kode_unit_subunit] = $baris->rm;
		// 		$alokasi['lainnya'.$baris->kode_unit_subunit] = $baris->apbn_lainnya;
		// 	}
		// }

		 //echo '<pre>';var_dump($setting_up);echo '</pre>';die;
		return $setting_up;
	}

	function get_setting_up_total_per_unit($units,$tahun,$sd=""){

		$setting_up = array();


		foreach($units as $unit){
			$setting_up_x = array();
			$this->db->where("kode_unit_subunit",$unit->kode_unit);
			$this->db->where("tahun",$tahun);			
			$q = $this->db->get("setting_up");
			$row = $q->row();

			$setting_up_x[$unit->kode_unit] = isset($row->jumlah)?$row->jumlah:0 ;
			//$alokasi_x['rm'.$unit->kode_unit] = isset($row->rm)?$row->rm:0 ;
			//$alokasi_x['lainnya'.$unit->kode_unit] = isset($row->apbn_lainnya)?$row->apbn_lainnya:0 ;

			if($sd==""){
				$total = $setting_up_x[$unit->kode_unit] ;

			}
			/*
			elseif($sd=="SELAIN-APBN"){
				$total = $alokasi_x[$unit->kode_unit] ;

			}elseif($sd=="APBN-BPPTNBH"){
				$total = $alokasi_x['rm'.$unit->kode_unit] ;

			}
			elseif($sd=="APBN-LAINNYA"){
				$total = $alokasi_x['lainnya'.$unit->kode_unit] ;

			}
			*/

			$setting_up[] = array( $unit->kode_unit => $total ) ; 	

		}

		return $setting_up;
	}

	function get_setting_up_total_per_subunit($units,$tahun,$sd=""){

		$setting_up = array();


		foreach($units as $unit){
			$setting_up_x = array();
			$this->db->where("kode_unit_subunit",$unit->kode_subunit);
			$this->db->where("tahun",$tahun);			
			$q = $this->db->get("setting_up");
			$row = $q->row();

			$setting_up_x[$unit->kode_subunit] = isset($row->jumlah)?$row->jumlah:0 ;
			//$setting_up_x['rm'.$unit->kode_subunit] = isset($row->rm)?$row->rm:0 ;
			//$setting_up_x['lainnya'.$unit->kode_subunit] = isset($row->apbn_lainnya)?$row->apbn_lainnya:0 ;

			if($sd==""){
				$total = $setting_up_x[$unit->kode_subunit];

			}elseif($sd=="SELAIN-APBN"){
				$total = $alokasi_x[$unit->kode_subunit] ;

			}elseif($sd=="APBN-BPPTNBH"){
				$total = $alokasi_x['rm'.$unit->kode_subunit] ;

			}elseif($sd=="APBN-LAINNYA"){
				$total = $alokasi_x['lainnya'.$unit->kode_subunit] ;

			}

			$alokasi[] = array( $unit->kode_subunit => $total ) ; 	

		}

		return $alokasi;
	}

	function get_alokasi_total_per_sub_subunit($units,$tahun,$sd=""){

		$alokasi = array();


		foreach($units as $unit){
			$alokasi_x = array();
			$this->db->where("kode_unit_subunit",$unit->kode_sub_subunit);
			$this->db->where("tahun",$tahun);			
			$q = $this->db->get("platform");
			$row = $q->row();

			$alokasi_x[$unit->kode_sub_subunit] = isset($row->jumlah)?$row->jumlah:0 ;
			$alokasi_x['rm'.$unit->kode_sub_subunit] = isset($row->rm)?$row->rm:0 ;
			$alokasi_x['lainnya'.$unit->kode_sub_subunit] = isset($row->apbn_lainnya)?$row->apbn_lainnya:0 ;

			if($sd==""){
				$total = $alokasi_x[$unit->kode_sub_subunit] + $alokasi_x['rm'.$unit->kode_sub_subunit] + $alokasi_x['lainnya'.$unit->kode_sub_subunit] ;

			}elseif($sd=="SELAIN-APBN"){
				$total = $alokasi_x[$unit->kode_sub_subunit] ;

			}elseif($sd=="APBN-BPPTNBH"){
				$total = $alokasi_x['rm'.$unit->kode_sub_subunit] ;

			}elseif($sd=="APBN-LAINNYA"){
				$total = $alokasi_x['lainnya'.$unit->kode_sub_subunit] ;

			}

			$alokasi[] = array( $unit->kode_sub_subunit => $total ) ; 	

		}

		return $alokasi;
	}

	function get_alokasi_per_subunit($units,$tahun){

		$alokasi = array();

		foreach($units as $unit){
			$alokasi_x = array();
			$this->db->where("kode_unit_subunit",$unit->kode_subunit);
			$this->db->where("tahun",$tahun);			
			$q = $this->db->get("platform");
			$row = $q->row();
			$alokasi_x[$unit->kode_subunit] = isset($row->jumlah)?$row->jumlah:0 ;
			$alokasi_x['rm'.$unit->kode_subunit] = isset($row->rm)?$row->rm:0 ;
			$alokasi_x['lainnya'.$unit->kode_subunit] = isset($row->apbn_lainnya)?$row->apbn_lainnya:0 ;
			$alokasi[] = $alokasi_x;
			

		}


		// if ($query->num_rows()>0)
		// {
		// 	$row = $query->result();
		// 	foreach($row as $baris){
		// 		$alokasi[$baris->kode_unit_subunit] = $baris->jumlah;
		// 		$alokasi['rm'.$baris->kode_unit_subunit] = $baris->rm;
		// 		$alokasi['lainnya'.$baris->kode_unit_subunit] = $baris->apbn_lainnya;
		// 	}
		// }

		// echo '<pre>';var_dump($alokasi);echo '</pre>';die;
		return $alokasi;
	}

	function get_alokasi_per_sub_subunit($units,$tahun){

		$alokasi = array();

		foreach($units as $unit){
			$alokasi_x = array();
			$this->db->where("kode_unit_subunit",$unit->kode_sub_subunit);
			$this->db->where("tahun",$tahun);			
			$q = $this->db->get("platform");
			$row = $q->row();
			$alokasi_x[$unit->kode_sub_subunit] = isset($row->jumlah)?$row->jumlah:0 ;
			$alokasi_x['rm'.$unit->kode_sub_subunit] = isset($row->rm)?$row->rm:0 ;
			$alokasi_x['lainnya'.$unit->kode_sub_subunit] = isset($row->apbn_lainnya)?$row->apbn_lainnya:0 ;
			$alokasi[] = $alokasi_x;
			

		}


		// if ($query->num_rows()>0)
		// {
		// 	$row = $query->result();
		// 	foreach($row as $baris){
		// 		$alokasi[$baris->kode_unit_subunit] = $baris->jumlah;
		// 		$alokasi['rm'.$baris->kode_unit_subunit] = $baris->rm;
		// 		$alokasi['lainnya'.$baris->kode_unit_subunit] = $baris->apbn_lainnya;
		// 	}
		// }

		// echo '<pre>';var_dump($alokasi);echo '</pre>';die;
		return $alokasi;
	}

	function get_sub_subunit($unit){
		$unit = ($unit=='9999')?'99':$unit;
		$query = $this->db->query("SELECT kode_sub_subunit, nama_sub_subunit
					FROM sub_subunit
					WHERE LEFT(kode_sub_subunit,4)='{$unit}' 
					ORDER BY kode_sub_subunit ASC");
		return $query->result();
	}

	// Amodif BY IDRIS

	function get_total_alokasi_all($unit,$tahun){

		$unit = ($unit=='9999')?'99':$unit;



		$total = 0;

		if(strlen($unit)==2){
			$query = $this->db->query("SELECT sum(rm+jumlah+apbn_lainnya) as total
						FROM unit, platform
						WHERE LEFT(kode_unit,2)='{$unit}' AND kode_unit=kode_unit_subunit AND tahun='{$tahun}'");
			$row = $query->result();
			$total = $row[0]->total;
		}elseif(strlen($unit)==4){
			$query = $this->db->query("SELECT sum(rm+jumlah+apbn_lainnya) as total
						FROM subunit, platform
						WHERE LEFT(kode_subunit,4)='{$unit}' AND kode_subunit=kode_unit_subunit AND tahun='{$tahun}'");
			// echo "SELECT sum(rm+jumlah+apbn_lainnya) as total
			// 			FROM subunit, platform
			// 			WHERE LEFT(kode_subunit,4)='{$unit}' AND kode_subunit=kode_unit_subunit AND tahun='{$tahun}'" ; die;
			$row = $query->result();
			$total = $row[0]->total;
		}elseif(strlen($unit)==6){
			$query = $this->db->query("SELECT sum(rm+jumlah+apbn_lainnya) as total
						FROM sub_subunit, platform
						WHERE LEFT(kode_sub_subunit,6)='{$unit}' AND kode_sub_subunit=kode_unit_subunit AND tahun='{$tahun}'");
			$row = $query->result();
			$total = $row[0]->total;
		}

		if ($unit=='99'){
			$query = $this->db->query("SELECT sum(rm+jumlah+apbn_lainnya) as total
					FROM unit, platform
					WHERE kode_unit!='99' AND kode_unit=kode_unit_subunit AND tahun='{$tahun}'");
			$row = $query->result();
			$total = $total + $row[0]->total;
		}
		
		return $total;
		
		}

	function get_total_alokasi_all_per_unit($units,$tahun,$sd=""){

		$total_ = 0 ;


			// $total_ = $this->get_alokasi_total_per_subunit($units,$tahun,$sd="");



		foreach($units as $unit){
			$alokasi_x = array();
			$this->db->where("kode_unit_subunit",$unit->kode_unit);
			$this->db->where("tahun",$tahun);			
			$q = $this->db->get("platform");
			$row = $q->row();

			$alokasi_x[$unit->kode_unit] = isset($row->jumlah)?$row->jumlah:0 ;
			$alokasi_x['rm'.$unit->kode_unit] = isset($row->rm)?$row->rm:0 ;
			$alokasi_x['lainnya'.$unit->kode_unit] = isset($row->apbn_lainnya)?$row->apbn_lainnya:0 ;

			$total = 0 ;

			if($sd==""){
				$total = $alokasi_x[$unit->kode_unit] + $alokasi_x['rm'.$unit->kode_unit] + $alokasi_x['lainnya'.$unit->kode_unit] ;

			}elseif($sd=="SELAIN-APBN"){
				$total = $alokasi_x[$unit->kode_unit] ;

			}elseif($sd=="APBN-BPPTNBH"){
				$total = $alokasi_x['rm'.$unit->kode_unit] ;

			}elseif($sd=="APBN-LAINNYA"){
				$total = $alokasi_x['lainnya'.$unit->kode_unit] ;

			}

			// $alokasi[] = array( $unit->kode_subunit => $total ) ; 	

			$total_ =  $total_ + $total ;

		}

		// return $alokasi;



		return $total_ ;


	}

	function get_total_alokasi_all_per_subunit($units,$tahun,$sd=""){

		$total_ = 0 ;


			// $total_ = $this->get_alokasi_total_per_subunit($units,$tahun,$sd="");



		foreach($units as $unit){
			$alokasi_x = array();
			$this->db->where("kode_unit_subunit",$unit->kode_subunit);
			$this->db->where("tahun",$tahun);			
			$q = $this->db->get("platform");
			$row = $q->row();

			$alokasi_x[$unit->kode_subunit] = isset($row->jumlah)?$row->jumlah:0 ;
			$alokasi_x['rm'.$unit->kode_subunit] = isset($row->rm)?$row->rm:0 ;
			$alokasi_x['lainnya'.$unit->kode_subunit] = isset($row->apbn_lainnya)?$row->apbn_lainnya:0 ;

			$total = 0 ;

			if($sd==""){
				$total = $alokasi_x[$unit->kode_subunit] + $alokasi_x['rm'.$unit->kode_subunit] + $alokasi_x['lainnya'.$unit->kode_subunit] ;

			}elseif($sd=="SELAIN-APBN"){
				$total = $alokasi_x[$unit->kode_subunit] ;

			}elseif($sd=="APBN-BPPTNBH"){
				$total = $alokasi_x['rm'.$unit->kode_subunit] ;

			}elseif($sd=="APBN-LAINNYA"){
				$total = $alokasi_x['lainnya'.$unit->kode_subunit] ;

			}

			// $alokasi[] = array( $unit->kode_subunit => $total ) ; 	

			$total_ =  $total_ + $total ;

		}

		// return $alokasi;



		return $total_ ;


	}

	function get_total_alokasi_all_per_sub_subunit($units,$tahun,$sd=""){

		$total_ = 0 ;


			// $total_ = $this->get_alokasi_total_per_subunit($units,$tahun,$sd="");



		foreach($units as $unit){
			$alokasi_x = array();
			$this->db->where("kode_unit_subunit",$unit->kode_sub_subunit);
			$this->db->where("tahun",$tahun);			
			$q = $this->db->get("platform");
			$row = $q->row();

			$alokasi_x[$unit->kode_sub_subunit] = isset($row->jumlah)?$row->jumlah:0 ;
			$alokasi_x['rm'.$unit->kode_sub_subunit] = isset($row->rm)?$row->rm:0 ;
			$alokasi_x['lainnya'.$unit->kode_sub_subunit] = isset($row->apbn_lainnya)?$row->apbn_lainnya:0 ;

			$total = 0 ;

			if($sd==""){
				$total = $alokasi_x[$unit->kode_sub_subunit] + $alokasi_x['rm'.$unit->kode_sub_subunit] + $alokasi_x['lainnya'.$unit->kode_sub_subunit] ;

			}elseif($sd=="SELAIN-APBN"){
				$total = $alokasi_x[$unit->kode_sub_subunit] ;

			}elseif($sd=="APBN-BPPTNBH"){
				$total = $alokasi_x['rm'.$unit->kode_sub_subunit] ;

			}elseif($sd=="APBN-LAINNYA"){
				$total = $alokasi_x['lainnya'.$unit->kode_sub_subunit] ;

			}

			// $alokasi[] = array( $unit->kode_subunit => $total ) ; 	

			$total_ =  $total_ + $total ;

		}

		// return $alokasi;



		return $total_ ;


	}

	function get_total_alokasi_setting_by_unit($unit,$tahun,$sd=''){

		$unit = ($unit=='9999')?'99':$unit;

		$total = 0;

		$row= '';

		if($unit == '99'){
			$str = "SELECT *
							FROM setting
							WHERE nilai = '{$tahun}'";

				$query = $this->db->query($str);

				$row = $query->row();


			if($sd==''){

				$total = $row->selain_apbn + $row->apbn_bpptnbh + $row->apbn_lainnya ;

			}elseif($sd=='SELAIN-APBN'){

				$total = $row->selain_apbn;

			}elseif($sd=='APBN-BPPTNBH'){

				$total = $row->apbn_bpptnbh;

			}elseif($sd=='APBN-LAINNYA'){

				$total = $row->apbn_lainnya;

			}

		}
		else{
			if(strlen($unit)==2){
				$str = "SELECT *
							FROM unit
							JOIN platform
							ON unit.kode_unit = platform.kode_unit_subunit
							WHERE unit.kode_unit ='{$unit}' AND tahun='{$tahun}'";

				$query = $this->db->query($str);

				$row = $query->row();


			}elseif(strlen($unit)==4){

				$str = "SELECT *
							FROM subunit
							JOIN platform
							ON subunit.kode_subunit = platform.kode_unit_subunit
							WHERE subunit.kode_subunit ='{$unit}' AND tahun='{$tahun}'";

				$query = $this->db->query($str);

				$row = $query->row();
			
			}

			if($sd==''){

				$total = $row->jumlah + $row->rm + $row->apbn_lainnya ;

			}elseif($sd=='SELAIN-APBN'){

				$total = $row->jumlah;

			}elseif($sd=='APBN-BPPTNBH'){

				$total = $row->rm;

			}elseif($sd=='APBN-LAINNYA'){

				$total = $row->apbn_lainnya;

			}

		}

		// if(strlen($unit)==2){
		// 	$query = $this->db->query("SELECT sum(jumlah) as total
		// 			FROM subunit, platform
		// 			WHERE LEFT(kode_subunit,2)='{$unit}' AND kode_subunit=kode_unit_subunit AND tahun='{$tahun}'");
		// }
		// elseif(strlen($unit)==4){
		// 	$query = $this->db->query("SELECT sum(jumlah) as total
		// 			FROM sub_subunit, platform
		// 			WHERE LEFT(kode_sub_subunit,4)='{$unit}' AND kode_sub_subunit=kode_unit_subunit AND tahun='{$tahun}'");
		// }


		

		// $row = $query->result();
		// $total = $row[0]->total;

		// if ($unit=='99'){
		// 	$query = $this->db->query("SELECT sum(jumlah) as total
		// 			FROM unit, platform
		// 			WHERE kode_unit!='99' AND kode_unit=kode_unit_subunit AND tahun='{$tahun}'");
		// 	$row = $query->result();

		// 	$total = $total + $row[0]->total;
		// }

		// var_dump($row);


		
		
		return $total;
	}
		

	
}
?>