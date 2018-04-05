<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Um_tkk extends CI_Controller {

	private $cur_tahun = '' ;
	private $rek_tunj_pns = 2;
	private $rek_nonpns = 2;

	public function __construct()
  {
		parent::__construct();

		$this->cur_tahun = $this->setting_model->get_tahun();
		// Your own constructor code
		if(!$this->check_session->user_session()){	/*	Jika session user belum diset	*/
			redirect('/','refresh');
		}else{	/*	Jika session user sudah diset	*/
			$this->load->helper('form');
			$this->load->model('login_model');
			$this->load->model('menu_model');
			$this->load->model('user_model');
			$this->load->library('form_validation');
			$this->load->library('revisi_session');
			$this->load->model('cantik_model');
			$this->load->model('cantik2_model');
			$this->load->model('setting_model');

			// otomatis set tahun
			// if(!isset($_SESSION['uk_dosen']['tahun'])){
			// 	$_SESSION['uk_dosen']['tahun'] = $this->cur_tahun;
			// }

		}
  }


	public function index()
	{
		$data['heading'] = "<span style=\"background-color:#f00;color:#fff;\">&nbsp;!&nbsp;</span>&nbsp;&nbsp;&nbsp;<span style=\"color:#f00;\">Masih dalam pengembangan</span>";
		$data['message'] = "<p style=\"text-align:center;\"><img src=\"".base_url('assets/img/working-on-progress.jpg')."\" width=\"640\"/></p><p style=\"text-align:center;\">Modul ini masih dalam pengembangan, silahkan tunggu beberapa saat lagi.<br/>Waktu pengembangan bergantung pada jumlah <em>job</em> yang di<em>handle</em>.</p><p style=\"text-align:center;\">Silahkan kembali ke halaman sebelumnya, atau dapat kembali ke halaman muka melalui <a href=\"".site_url()."\">link ini</a></p>";
		$this->load->view('kepegawaian/error/error_general',$data);
		// $ch = array(' selected','');
		// if(isset($_SESSION['uk_dosen']['sms'])){
		// 	if(intval($_SESSION['uk_dosen']['sms']) != 1){
		// 		$ch = array('',' selected');
		// 	}
		// }
		// $subdata['ch'] = $ch;
  //   $subdata['cur_tahun'] = $this->cur_tahun;
		// $data['main_content']	= $this->load->view('kepegawaian/uk_dosen/index',$subdata,TRUE);
  //   $data['main_menu'] = $this->load->view('main_menu','',TRUE);
  //   $data['message'] = validation_errors();
  //   $this->load->view('main_template',$data);
	}

	public function uk_proses(){

		if(isset($_POST['act']) && $_POST['act']=='uk_lihat'){
			$_SESSION['uk_dosen']['sms'] = $_POST['sms'];
      $_SESSION['uk_dosen']['tahun'] = $_POST['tahun'];
			$_unit_id = $this->cantik2_model->get_kode_kepeg_unit($_SESSION['rsa_kode_unit_subunit']); // langsung ambil dari sesi user.
      $_SESSION['uk_dosen']['unit_id'] = $_unit_id;
			echo "1"; exit;
		}

		if(isset($_POST['act']) && $_POST['act']=='uk_hapus_single'){
			if(isset($_POST['id'])){
        $sql = "DELETE FROM `kepeg_tr_uk_dosen` WHERE `id` = ".intval($_POST['id']);
        // echo $sql; exit;
				$this->db->query($sql);
        echo 1; exit;
      }
      echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
		}

		if(isset($_POST['act']) && $_POST['act']=='uk_hapus_daftar'){
			if(isset($_SESSION['uk_dosen'])){
        $sql = "DELETE FROM `kepeg_tr_uk_dosen` WHERE `tahun` LIKE '".$_SESSION['uk_dosen']['tahun']."' AND `sms` LIKE '".$_SESSION['uk_dosen']['sms']."' AND fk_fak LIKE '".$_SESSION['uk_dosen']['unit_id']."'";
				$this->db->query($sql);
        echo 1; exit;
      }
      echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
		}

	}

	// public function uk_proses(){
	// 	if(isset($_POST)){
	// 		if(isset($_POST['act']) && $_POST['act']=='uk_proses'){
	// 			$_SESSION['uk_dosen']['sms'] = $_POST['sms'];
 //        $_SESSION['uk_dosen']['tahun'] = $_POST['tahun'];
	// 			$_unit_id = $this->cantik_model->get_kode_kepeg_unit($_SESSION['rsa_kode_unit_subunit']); // langsung ambil dari sesi user.
 //        $_SESSION['uk_dosen']['unit_id'] = $_unit_id;
	// 			$dt = $this->cantik_model->get_data_pegawai_ikk($_SESSION['uk_dosen']);
	// 			// echo $dt; exit;
 //        // echo "<pre>"; print_r($dt); echo "</pre>"; exit;
 //        // $j = 1;
	// 			// echo "<table class=\"table table-striped table-condensed\">";
	// 			$sql_e=array();
	// 			foreach ($dt as $k => $v) {
	// 			// echo "<tr><td>".$j."</td><td>'".$v['nip']."</td><td>".$v['nama']."</td><td>".$v['bersih']."</td></tr>";
	// 				$sql = "SELECT `id` FROM `kepeg_tr_uk_dosen` WHERE `fk_id_dosen` LIKE '".$v->id_dosen."' AND `tahun` LIKE '".$_SESSION['uk_dosen']['tahun']."' AND `sms` LIKE '".$_SESSION['uk_dosen']['sms']."' AND `fk_fak` LIKE '".$_unit_id."';";
	// 				// echo $sql."<br />";
	// 				$q = $this->db->query($sql);
	// 				if($q->num_rows()<=0){
 //            $bruto = $v->total_dapat;
	// 					if($v->fak == $v->unit){
	// 						if($v->komposisi == 2 && $v->sks_ikw >= 16){
	// 							$bruto = .85*$bruto;
	// 						}elseif($v->komposisi == 2 && $v->sks_ikw < 16){
	// 							$bruto = 0;
	// 						}elseif($v->komposisi == 0){
	// 							$bruto = 0;
	// 						}
	// 					}else{
	// 						if($v->komposisi == 2 && $v->sks_ikw >= 12){
	// 							$bruto = .85*$bruto;
	// 						}elseif($v->komposisi == 2 && $v->sks_ikw < 12){
	// 							$bruto = 0;
	// 						}elseif($v->komposisi == 0){
	// 							$bruto = 0;
	// 						}
	// 					}
	// 					if($v->kelompok == '3'){
	// 						$pph = .05;
	// 						$nom_pph = $pph*$bruto;
	// 					}elseif($v->kelompok == '4'){
	// 						$pph = .15;
	// 						$nom_pph = $pph*$bruto;
	// 					}elseif(!in_array($v->kelompok,array('1','2','3','4'))){
	// 						$pph = 0;
	// 						$nom_pph = 0;
	// 					}
	// 					$nom_pph = round($nom_pph);
	// 					$bruto = round($bruto);
	// 					$netto = round($bruto - $nom_pph);
	// 					$rek = (array)$this->cantik_model->get_rekening_by_id($v->id_dosen, 2);
	// 					$sql_e[] = "('".$_SESSION['uk_dosen']['tahun']."', '".$_SESSION['uk_dosen']['sms']."', '".$_SESSION['uk_dosen']['unit_id']."', '".$v->unit_id."',  '".$v->id_dosen."', '".$this->cantik_model->encodeText($v->nip)."', '".$v->total_dapat."', '".$v->komposisi."', '".$netto."', '".$v->status."', '".$v->posisi_penetapan."', '".$this->cantik_model->encodeText($rek['norekening'])."', '".$this->cantik_model->encodeText($rek['nmpemilik'])."', '".$rek['kelompok_bank']."', NOW(), '".$v->sks_ikw."', '".$v->kelompok."', '".$bruto."', '".$pph."', '".$nom_pph."')";
	// 				}
	// 				// $j++;
	// 			}
	// 			// echo "</table>";
	// 			// echo count($brr);
	// 			// exit;
	// 			// echo "<pre>"; print_r($sql_e); exit;
	// 			if(count($sql_e)>0){
	// 				$sql="INSERT INTO `kepeg_tr_uk_dosen` (`tahun`, `sms`, `fk_fak`, `fk_unit`, `fk_id_dosen`, `nip`, `total_dapat`, `komposisi`, `netto`, `status`, `posisi_penetapan`, `norekening`, `namarekening`, `bank`, `waktutambah`, `sks_ikw`, `gol`, `bruto`, `pph`, `pajak`) VALUES".implode(", ",$sql_e);
	// 				// echo "<pre>".$sql."</pre>"; exit;
	// 				$this->db->query($sql);
	// 			}
	// 			echo "1"; exit;
	// 		}

	// 		if(isset($_POST['act']) && $_POST['act']=='uk_lihat'){
	// 			$_SESSION['uk_dosen']['sms'] = $_POST['sms'];
 //        $_SESSION['uk_dosen']['tahun'] = $_POST['tahun'];
	// 			$_unit_id = $this->cantik_model->get_kode_kepeg_unit($_SESSION['rsa_kode_unit_subunit']); // langsung ambil dari sesi user.
 //        $_SESSION['uk_dosen']['unit_id'] = $_unit_id;
	// 			echo "1"; exit;
	// 		}

	// 		if(isset($_POST['act']) && $_POST['act']=='uk_hapus_single'){
	// 			if(isset($_POST['id'])){
 //          $sql = "DELETE FROM `kepeg_tr_uk_dosen` WHERE `id` = ".intval($_POST['id']);
	// 				$this->db->query($sql);
 //          echo 1; exit;
 //        }
 //        echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
	// 		}

	// 		if(isset($_POST['act']) && $_POST['act']=='uk_hapus_daftar'){
	// 			if(isset($_SESSION['uk_dosen'])){
 //          $sql = "DELETE FROM `kepeg_tr_uk_dosen` WHERE `tahun` LIKE '".$_SESSION['uk_dosen']['tahun']."' AND `sms` LIKE '".$_SESSION['uk_dosen']['sms']."' AND fk_fak LIKE '".$_SESSION['uk_dosen']['unit_id']."'";
	// 				$this->db->query($sql);
 //          echo 1; exit;
 //        }
 //        echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
	// 		}


	// 	} // end post
	// } // end function

	public function daftar()
	{
		$ch = array(' selected','');
		if(isset($_SESSION['uk_dosen']['sms'])){
			if(intval($_SESSION['uk_dosen']['sms']) != 1){
				$ch = array('',' selected');
			}
		}
		$subdata['ch'] = $ch;
		$subdata['cur_tahun'] = $this->cur_tahun;
		$data['main_content']	= $this->load->view('kepegawaian/uk_dosen/daftar',$subdata,TRUE);
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $this->load->view('main_template',$data);
	}

	public function reload_daftar()
	{
		$subdata['dt'] = $this->cantik2_model->get_data_uk();
		// print_r($subdata['dt']); exit;
    $this->load->view('kepegawaian/uk_dosen/daftar_reload',$subdata);
	}

	public function daftar_cetak()
	{
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['dt'] = $this->cantik2_model->get_data_uk();
		$subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
		$subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$subdata['filename'] = date('Ymd')."_ukdosen_".strtolower(str_replace(' ','_',$this->cantik2_model->nama_unit_kepeg_rba($_SESSION['rsa_kode_unit_subunit']))).".xls";
		$data['main_content']	= $this->load->view('kepegawaian/uk_dosen/daftar_cetak',$subdata,TRUE);
    $data['message']	= validation_errors();
    $this->load->view('cetak_template_excel',$data);
	}

	public function set_uk_lppm(){
		// error_reporting(0);
		if(isset($_POST['sms'])){
			$_SESSION['uk_dosen']['sms'] = $_POST['sms'];
		}
		if(isset($_POST['tahun'])){
			$_SESSION['uk_dosen']['tahun'] = $_POST['tahun'];
		}
		
		$_unit_id = $this->cantik2_model->get_kode_kepeg_unit($_SESSION['rsa_kode_unit_subunit']); // langsung ambil dari sesi user.
		$_SESSION['uk_dosen']['unit_id'] = $_unit_id;

		$xyz = $_SESSION['uk_dosen'];
		$dt = $this->cantik2_model->get_data_pegawai_uk($xyz);
		// print_r($dt); exit;
		$sql_e=array();
		if(!is_null($dt)){
			foreach ($dt as $k => $v) {
				$sql = "SELECT `id` FROM `kepeg_tr_uk_dosen` WHERE `fk_id_dosen` LIKE '".$v->id_dosen."' AND `tahun` LIKE '".$xyz['tahun']."' AND `sms` LIKE '".$xyz['sms']."' AND `fk_fak` LIKE '".$_unit_id."';";
				// echo $sql."<br />";
				$q = $this->db->query($sql);
				if($q->num_rows()<=0){
					$bruto = $v->nilai_ikk;
					if($v->kelompok == '3'){
						$pph = .05;
						$nom_pph = $pph*$bruto;
					}elseif($v->kelompok == '4'){
						$pph = .15;
						$nom_pph = $pph*$bruto;
					}elseif(!in_array($v->kelompok,array('1','2','3','4'))){
						$pph = 0;
						$nom_pph = 0;
					}
					$nom_pph = ceil($nom_pph);
					$bruto = ceil($bruto);
					$netto = ceil($bruto - $nom_pph);
					$rek = $this->cantik2_model->getDataRekening($v->id_dosen, 2);

					$sql_e[] = "('".$xyz['tahun']."', '".$xyz['sms']."', '".$xyz['unit_id']."', '".$v->unit_id."',  '".$v->id_dosen."', '".$this->cantik_model->encodeText(addslashes($v->nama))."', '".$this->cantik_model->encodeText(addslashes($v->nip))."', '".$v->golongan_id."', '".$v->gol."', '".$v->kelompok."', '".$this->cantik_model->encodeText(addslashes($v->npwp))."', '".$bruto."', '".$pph."', '".$nom_pph."', '".$netto."', '".$v->status."', '".$this->cantik_model->encodeText(addslashes($rek['norekening']))."', '".$this->cantik_model->encodeText(addslashes($rek['nmpemilik']))."', '".$rek['kelompok_bank']."', NOW())";

					// echo "<p class=\"small\">('".$xyz['tahun']."', '".$xyz['sms']."', '".$xyz['unit_id']."', '".$v->unit_id."',  '".$v->id_dosen."', '".$this->cantik_model->encodeText($v->nip)."', '".$this->cantik_model->encodeText(addslashes($v->nama))."', '".$netto."', '".$v->golongan_id."', '".$v->gol."', '".$v->kelompok."', '".$this->cantik_model->encodeText(addslashes($v->npwp))."', '".$bruto."', '".$pph."', '".$nom_pph."', '".$netto."', '".$v->status."', '".$this->cantik_model->encodeText(addslashes($rek['norekening']))."', '".$this->cantik_model->encodeText(addslashes($rek['nmpemilik']))."', '".$rek['kelompok_bank']."', NOW())</p>";
				}
			}
		}
		// echo "<pre>";
		// print_r($sql_e);
		// echo "</pre>";
		// exit;
		if(count($sql_e)>0){
			$sql="INSERT INTO `kepeg_tr_uk_dosen` (`tahun`, `sms`, `fk_fak`, `fk_unit`, `fk_id_dosen`, `nama`, `nip`, `gol`, `golpeg`, `kelompok`, `npwp`, `bruto`, `pph`, `pajak`, `netto`, `status`, `norekening`, `namarekening`, `bank`, `waktutambah`) VALUES".implode(", ",$sql_e);
			// echo "<p class=\"small\">".$sql."</p>"; exit;
			$this->db->query($sql);
			echo 1; exit;
		}else{
			echo $this->cantik_model->msgGagal("Tidak ada data yang dimasukkan."); exit;
		}
	}

}
