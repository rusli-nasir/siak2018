<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ikk_dosen extends CI_Controller {

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
			// if(!isset($_SESSION['ikk_dosen']['tahun'])){
			// 	$_SESSION['ikk_dosen']['tahun'] = $this->cur_tahun;
			// }

		}
  }


	public function index()
	{
    	$subdata['cur_tahun'] = $this->cur_tahun;
		// $subdata['bulanOption'] = $this->cantik_model->getBulanOption(date('m'));
		// $subdata['dt'] = $this->cantik_model->get_data_pegawai_tutam();
		$data['main_content']	= $this->load->view('kepegawaian/ikk_dosen/ikk_dosen',$subdata,TRUE);
	    // $list["menu"] = $this->menu_model->show();
	    // $list["submenu"] = $this->menu_model->show();
	    $data['main_menu'] = $this->load->view('main_menu','',TRUE);
	    $data['message'] = validation_errors();
	    $this->load->view('main_template',$data);
	}

	public function ikk_proses(){
		if(isset($_POST)){
			if(isset($_POST['act']) && $_POST['act']=='ikk_proses'){
				$_SESSION['ikk_dosen']['sms'] = $_POST['sms'];
        		$_SESSION['ikk_dosen']['tahun'] = $_POST['tahun'];
				$_unit_id = $this->cantik_model->get_kode_kepeg_unit($_SESSION['rsa_kode_unit_subunit']); 
				// langsung ambil dari sesi user.
        		$_SESSION['ikk_dosen']['unit_id'] = $_unit_id;
				$dt = $this->cantik2_model->get_data_pegawai_ikk($_SESSION['ikk_dosen']);
				// echo $dt; exit;
		        // echo "<pre>"; print_r($dt); echo "</pre>"; exit;
		        // $j = 1;
				// echo "<table class=\"table table-striped table-condensed\">";
				$sql_e=array();
				foreach ($dt as $k => $v) {
				// echo "<tr><td>".$j."</td><td>'".$v['nip']."</td><td>".$v['nama']."</td><td>".$v['bersih']."</td></tr>";
					$sql = "SELECT `id` FROM `kepeg_tr_ikk_dosen` WHERE `fk_id_dosen` LIKE '".$v->id_dosen."' AND `tahun` LIKE '".$_SESSION['ikk_dosen']['tahun']."' AND `sms` LIKE '".$_SESSION['ikk_dosen']['sms']."' AND `fk_fak` LIKE '".$_unit_id."';";
					// echo $sql."<br />";
					$q = $this->db->query($sql);
					if($q->num_rows()<=0){
            			$bruto = $v->total_dapat;
						if($v->fak == $v->unit){
							if($v->komposisi == 2 && $v->sks_ikw >= 16){
								$bruto = .85*$bruto;
							}elseif($v->komposisi == 2 && $v->sks_ikw < 16){
								$bruto = 0;
							}elseif($v->komposisi == 0){
								$bruto = 0;
							}
						}else{
							if($v->komposisi == 2 && $v->sks_ikw >= 12){
								$bruto = .85*$bruto;
							}elseif($v->komposisi == 2 && $v->sks_ikw < 12){
								$bruto = 0;
							}elseif($v->komposisi == 0){
								$bruto = 0;
							}
						}
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
						$nom_pph = round($nom_pph);
						$bruto = round($bruto);
						$netto = round($bruto - $nom_pph);
						$rek = (array)$this->cantik2_model->getDataRekening($v->id_dosen, 2);
						$sql_e[] = "('".$_SESSION['ikk_dosen']['tahun']."', '".$_SESSION['ikk_dosen']['sms']."', '".$_SESSION['ikk_dosen']['unit_id']."', '".$v->unit_id."',  '".$v->id_dosen."', '".$this->cantik_model->encodeText(addslashes($v->nama))."', '".$this->cantik_model->encodeText(addslashes($v->nip))."', '".$v->total_dapat."', '".$v->komposisi."', '".$netto."', '".$v->status."', '".$v->posisi_penetapan."', '".$this->cantik_model->encodeText(addslashes($rek['norekening']))."', '".$this->cantik_model->encodeText(addslashes($rek['nmpemilik']))."', '".$rek['kelompok_bank']."', NOW(), '".$v->sks_ikw."', '".$v->kelompok."', '".$bruto."', '".$pph."', '".$nom_pph."')";
					}
					// $j++;
				}
				// echo "</table>";
				// echo count($brr);
				// exit;
				// echo "<pre>"; print_r($sql_e); exit;
				if(count($sql_e)>0){
					$sql="INSERT INTO `kepeg_tr_ikk_dosen` (`tahun`, `sms`, `fk_fak`, `fk_unit`, `fk_id_dosen`, `nama`, `nip`, `total_dapat`, `komposisi`, `netto`, `status`, `posisi_penetapan`, `norekening`, `namarekening`, `bank`, `waktutambah`, `sks_ikw`, `gol`, `bruto`, `pph`, `pajak`) VALUES".implode(", ",$sql_e);
					// echo "<pre>".$sql."</pre>"; exit;
					$this->db->query($sql);
				}
				echo "1"; exit;
			}

			if(isset($_POST['act']) && $_POST['act']=='ikk_lihat'){
				$_SESSION['ikk_dosen']['sms'] = $_POST['sms'];
        		$_SESSION['ikk_dosen']['tahun'] = $_POST['tahun'];
				$_unit_id = $this->cantik_model->get_kode_kepeg_unit($_SESSION['rsa_kode_unit_subunit']); 
				// langsung ambil dari sesi user.
        		$_SESSION['ikk_dosen']['unit_id'] = $_unit_id;
				echo "1"; exit;
			}

			if(isset($_POST['act']) && $_POST['act']=='ikk_hapus_single'){
				if(isset($_POST['id'])){
          			$sql = "DELETE FROM `kepeg_tr_ikk_dosen` WHERE `id` = ".intval($_POST['id']);
					$this->db->query($sql);
		          echo 1; exit;
		        }
        		echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
			}

			if(isset($_POST['act']) && $_POST['act']=='ikk_hapus_daftar'){
				if(isset($_SESSION['ikk_dosen'])){
          			$sql = "DELETE FROM `kepeg_tr_ikk_dosen` WHERE `tahun` LIKE '".$_SESSION['ikk_dosen']['tahun']."' AND `sms` LIKE '".$_SESSION['ikk_dosen']['sms']."' AND fk_fak LIKE '".$_SESSION['ikk_dosen']['unit_id']."'";
					$this->db->query($sql);
          			echo 1; exit;
		        }
		        echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
			}


		} // end post
	} // end function

	public function daftar()
	{
		// echo "--failed"; exit;
		$subdata['cur_tahun'] = $this->cur_tahun;
		// $subdata['dt'] = $this->cantik_model->get_data_ikk();
		// print_r($subdata['dt']); exit;
		$subdata['dt'] = null;
		$data['main_content']	= $this->load->view('kepegawaian/ikk_dosen/ikk_dosen_daftar',$subdata,TRUE);
    	// $list["menu"]           = $this->menu_model->show();
    	// $list["submenu"]        = $this->menu_model->show();
    	$data['main_menu']	= $this->load->view('main_menu','',TRUE);
	    // $data['message']	= validation_errors();
	    $this->load->view('main_template',$data);
	}

	public function reload_daftar()
	{
		$subdata['dt'] = $this->cantik_model->get_data_ikk();
    $this->load->view('kepegawaian/ikk_dosen/ikk_dosen_daftar_reload',$subdata);
	}

	public function daftar_cetak()
	{
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['dt'] = $this->cantik_model->get_data_ikk();
		$subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
		$subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$subdata['filename'] = date('Ymd')."_ikkdosen_".strtolower(str_replace(' ','-',$this->cantik2_model->getUnitShort($_SESSION['ikk_dosen']['unit_id']))).".xls";
		$data['main_content']	= $this->load->view('kepegawaian/ikk_dosen/ikk_dosen_daftar_cetak',$subdata,TRUE);  
    $data['message']	= validation_errors();
    $this->load->view('cetak_template_excel',$data);
	}

}
