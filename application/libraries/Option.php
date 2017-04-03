<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Option{
	 public function __construct()
        {
                // Call the CI_Model constructor
                // parent::__construct();
        }
	
	// function sumber_dana(){
	// 	return array('-'	=> nbs(3).'- Pilih Sumber Dana -'.nbs(3),
	// 					'PNBP' => nbs(3).'PNBP'.nbs(3),
	// 					'RM' 	=> nbs(3).'Rupiah Murni'.nbs(3),
	// 					'PLN' 	=> nbs(3).'Pinjaman Luar Negeri'.nbs(3)
	// 				);
	// }

	function sumber_dana(){
		return array(''	=> nbs(3).'- Pilih -'.nbs(3),
						'SELAIN-APBN' => nbs(3).'SELAIN APBN'.nbs(3),
						'APBN-BPPTNBH' 	=> nbs(3).'APBN (BPPTNBH)'.nbs(3),
						'APBN-LAINNYA' 	=> nbs(3).'SPI & SILPA'.nbs(3)
					);
	}
	
	function jenis_report(){
		return array(	'-'=>nbs(3).'- Pilih Jenis Laporan -'.nbs(3),
						'1'=>nbs(3).'Kertas Kerja RKA-KL Rincian Belanja Satuan Kerja'.nbs(3),
						'2'=>nbs(3).'Rekapitulasi RAB / Kertas Kerja'.nbs(3),
						'3'=>nbs(3).'Rencana Bisnis dan Anggaran'.nbs(3)
					);
	}
	
	function pilihan_tahun($th=''){
		$tahun['-']	= nbs(3).'- Pilih Tahun -'.nbs(3);
		if(is_array($th)){
			foreach($th as $item){
				$tahun[$item->tahun] = nbs(3).$item->tahun.nbs(3);
			}
		}else{
			if(empty($th)) $th = date("Y")+2;
			for($i=date("Y")+2;$i>=($th-10);$i--){
				$tahun[$i]	= nbs(3).$i.nbs(3);
			}
		}
		
		return $tahun;
	}
	
	function status_revisi(){
		return array('belum' 		=> 'belum',
					 'ditolak' 		=> 'ditolak',
					 'disetujui' 	=> 'disetujui',
					);
	}
	
	function user_level(){
		return array(
					 '1' => 'AKUNTANSI', // HIDE BY IDRIS
					'2' => 'KPA',
					'3' => 'VERIFIKATOR',
					'4' => 'PUMK',
					'5' => 'BUU',
					'11' => 'KUASA BUU',
					'13' => 'BENDAHARA',
					'14' => 'PPK SUKPA',
					'15' => 'PPPK',
					'16' => 'PPK',
					//'4' => 'pengawas', // HIDE BY IDRIS
					);
	}
	
	
	function flag_aktif(){
		return array('ya' => 'ya',
					 'tidak' => 'tidak',
					);
	}
	
	function user_revisi(){
		return array('0' => 'tidak',
					 '1' => 'ya',
					 '2' => 'khusus'
					);
	}
	
	function get_option_tahun($minimal,$maksimal){
		if ($minimal>$maksimal){
			return array();
		}else{
			for($i=$maksimal;$i>=$minimal;$i--){
				$tahun[$i]	= nbs(3).$i.nbs(3);
			}
		}
		return $tahun;
	}
	
	function get_option_unit($query){
		$option['9999']	= nbs(3)."- Semua Fakultas -";
		foreach($query->result() as $row){
			$option[$row->kode_unit] = nbs(3).$row->nama_unit.nbs(3);
		}
		$ci =& get_instance();
		$ci->db->like('LEFT(kode_subunit,2)','99');
		$ci->db->not_like('kode_subunit','9999');
		$ci->db->select('kode_subunit, nama_subunit');
		$query = $ci->db->get('rsa_subunit');
		foreach ($query->result() as $row){
			$option[$row->kode_subunit] = nbs(3).$row->nama_subunit.nbs(3);
		}
		
		return $option;
	}
	
	function get_option_subunit($kode_unit='',$nama_subunit=''){
		$option[$kode_unit]	= nbs(3)."- Semua Subunit -".nbs(3);
		$option[$kode_unit."99"]	= nbs(3)."$nama_subunit".nbs(3);
		
		$ci =& get_instance();
		//$ci->db->like('LEFT(kode_subunit,2)','99');
		//$ci->db->not_like('kode_subunit','9999');
		$ci->db->select('kode_subunit, nama_subunit');
		$ci->db->where(array(
			'LEFT(kode_subunit,2)' => $kode_unit,
			'RIGHT(kode_subunit,2) !=' => '99'
				));
		$query = $ci->db->get('rsa_subunit');
		foreach ($query->result() as $row){
			$option[$row->kode_subunit] = nbs(3).$row->nama_subunit.nbs(3);
		}
		//print_r($option);
		return $option;
	}
	
	function get_option_jenjang(){
		$jenjang[0] = "D3";
		$jenjang['1'] = "S1";
		$jenjang['2'] = "S2";
		$jenjang['3'] = "S3";
		$jenjang['4'] = "Profesi";
		$jenjang['5'] = "Non-jenjang";
		
		return $jenjang;
	}
	
	function get_option_output(){
		$option['']	= nbs(3)."- Semua Output -".nbs(3);
		
		$ci =& get_instance();
		//$ci->db->like('LEFT(kode_subunit,2)','99');
		//$ci->db->not_like('kode_subunit','9999');
		$query = $ci->db->query("SELECT kode_output, nama_output
									FROM output
									WHERE kode_kegiatan = '4078'
									ORDER BY kode_output ASC");
		foreach ($query->result() as $row){
			$option[$row->kode_output] = nbs(3).'('.$row->kode_output.') '.$row->nama_output.nbs(3);
		}
		//print_r($option);
		return $option;
	}
	
	function get_option_akun_pendapatan(){
		$option['']	= nbs(3)."- Semua Akun Pendapatan -".nbs(3);
		
		$ci =& get_instance();
		$query = $ci->db->query("SELECT kode_pendapatan, nama_pendapatan
									FROM pendapatan
									ORDER BY kode_pendapatan ASC");
		foreach ($query->result() as $row){
			$option[$row->kode_pendapatan] = nbs(3).'('.$row->kode_pendapatan.') '.$row->nama_pendapatan.nbs(3);
		}
		//print_r($option);
		return $option;
	}
	//add alaik
	function opt_kegiatan(){
		$option['']	= nbs(1)."- Pilih Tujuan -".nbs(1);
		
		$ci =& get_instance();
		$query = $ci->db->query("SELECT kode_kegiatan, nama_kegiatan
									FROM kegiatan
									ORDER BY kode_kegiatan ASC");
		foreach ($query->result() as $row){
			$option[$row->kode_kegiatan] = nbs(1).'('.$row->kode_kegiatan.') '.$row->nama_kegiatan.nbs(1);
		}
		//print_r($option);
		return $option;
	}
	//add alaik 
	function opt_bidang(){
		return array(''	=> nbs(3).'- Pilih -'.nbs(3),
						'BIDANG I' => nbs(3).'BIDANG I'.nbs(3),
						'BIDANG II' 	=> nbs(3).'BIDANG II'.nbs(3),
						'BIDANG III' 	=> nbs(3).'BIDANG III'.nbs(3),
						'BIDANG IV' 	=> nbs(3).'BIDANG IV'.nbs(3)
					);
	}
	function opt_unit_kepeg(){
		$option['']	= nbs(1)."- Pilih Unit -".nbs(1);
		
		$ci =& get_instance();
		$query = $ci->db->query("SELECT id, unit
									FROM kepeg_unit
									ORDER BY id ASC");
		foreach ($query->result() as $row){
			$option[$row->id] = nbs(1).'('.$row->id.') '.$row->unit.nbs(1);
		}
		//print_r($option);
		return $option;
	}
	
}
?>
