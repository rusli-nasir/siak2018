<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutam extends CI_Controller {

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
			$this->skp = $this->load->database('skp', TRUE);
			$this->eduk = $this->load->database('eduk', TRUE);

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
			// if(!isset($_SESSION['tutam']['tahun'])){
			// 	$_SESSION['tutam']['tahun'] = $this->cur_tahun;
			// }

		}
  }


	public function index()
	{
    	$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption(date('m'));
		// $subdata['dt'] = $this->cantik2_model->get_data_pegawai_tutam();
		$data['main_content']	= $this->load->view('kepegawaian/tutam',$subdata,TRUE);
	    $list["menu"]           = $this->menu_model->show();
	    $list["submenu"]        = $this->menu_model->show();
	    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
	    $data['message']	= validation_errors();
	    $this->load->view('main_template',$data);
	}

	public function tutam_proses(){
		if(isset($_POST)){
			if(isset($_POST['act']) && $_POST['act']=='tutam_proses'){
				$_SESSION['tutam']['bulan'] = $_POST['bulan'];
				$_SESSION['tutam']['tahun'] = $_POST['tahun'];
				$dt = $this->cantik2_model->get_data_pegawai_tutam();
				$sql_e = array();
				$arr = array();
				// AMBIL DATA NOMINAL TUTAM DAN KAITKAN DENGAN DATA YANG ADA
				for($j=0;$j<count($dt);$j++){
					$dt[$j]->nominal = $this->cantik_model->getNominalTutam($dt[$j]->tgs_tambahan_id,$dt[$j]->kelompok);
					if($dt[$j]->nominal != 0){
						if($dt[$j]->kelompok==3){
							$pajak = 0.05;
						}elseif($dt[$j]->kelompok==4){
							$pajak = 0.15;
						}
						$nom_pajak = ceil($dt[$j]->nominal*$pajak);
						$bersih = $dt[$j]->nominal - $nom_pajak;
						// $dt[$j]->nominal = $nominal;
						$dt[$j]->bersih = $bersih;
						$dt[$j]->nom_pajak = $nom_pajak;
						$dt[$j]->pajak = $pajak;
						$arr[$dt[$j]->nip][] = (array)$dt[$j];
					}
				}
				unset($dt);
				$brr = array();
				foreach ($arr as $k => $v) {
					if(count($v)==1){
						$brr[] = $v[0];
					}else{
						foreach ($v as $k1 => $r) {
					    $nominal[$k1]  = $r['nominal'];
						}
						array_multisort($nominal, SORT_DESC);
						$key = $this->cantik2_model->searchForId($nominal[0],$v);
						$brr[] = $v[$key];
						// $brr[] = $nominal;
					}
				}
				unset($arr);
				// echo "<pre>"; print_r($brr); echo "</pre>"; exit;
				// END AMBIL

				// for($j=0;$j<count($dt);$j++){
				// 	$v = $dt[$j];
				// 	$nominal2 = 0; $nominal0 = 0;
				// 	$nominal = $this->cantik_model->getNominalTutam($v->tgs_tambahan_id,$v->kelompok);
				// 	if($nominal == 0){
				// 		// continue;
				// 	}
				// 	if($j<(count($dt)-1) && $dt[($j+1)]->nip == $v->nip){
				// 		$nominal2 = $this->cantik_model->getNominalTutam($dt[($j+1)]->tgs_tambahan_id,$dt[($j+1)]->kelompok);
				// 		if($nominal <= $nominal2){
				// 			// continue;
				// 		}
				// 	}
				// 	if($j!=0 && $dt[($j-1)]->nip == $v->nip){
				// 		$nominal0 = $this->cantik_model->getNominalTutam($dt[($j-1)]->tgs_tambahan_id,$dt[($j-1)]->kelompok);
				// 		if($nominal0 >= $nominal){
				// 			// continue;
				// 		}
				// 	}
				// 	if($v->kelompok==3){
				// 		$pajak = 0.05;
				// 	}elseif($v->kelompok==4){
				// 		$pajak = 0.15;
				// 	}
				// 	$nom_pajak = round($nominal*$pajak);
				// 	$bersih = $nominal - $nom_pajak;
				// 	$dt[$j]->nominal = $nominal;
				// 	$dt[$j]->bersih = $bersih;
				// 	$dt[$j]->nom_pajak = $nom_pajak;
				// 	$dt[$j]->pajak = $pajak;
				// }
				// for($j=0;$j<count($dt);$j++){
				// 	if($dt[$j]->nominal!=0){
				// 		$arr[] = (array)$dt[$j];
				// 	}
				// }
				// $brr = array();
				// for($j=0;$j<count($arr);$j++){
				// 	if(($j+1)<(count($arr)-1) && $arr[$j]['nip'] == $arr[$j+1]['nip'] && $arr[$j]['nominal'] <= $arr[$j+1]['nominal']){
				// 		continue;
				// 	}else{
				// 		$brr[] = $arr[$j];
				// 	}
				// }
				// $crr = array();
				// for($j=(count($brr)-1);$j>=0;$j--){
				// 	if(($j-1) < 0 && $dt[$j]->nip == $dt[$j-1]->nip && $dt[$j]->nominal <= $dt[($j-1)]->nominal ){
				// 		continue;
				// 	}else{
				// 		$crr[] = $brr[$j];
				// 	}
				// }
				// $drr = array();
				// for($j=0;$j<count($crr);$j++){
				// 	if(($j+1)<(count($crr)-1) && $crr[$j]['nip'] == $crr[$j+1]['nip'] && $crr[$j]['nominal'] <= $crr[$j+1]['nominal']){
				// 		continue;
				// 	}else{
				// 		$drr[] = $crr[$j];
				// 	}
				// }
				// $j = 1;
				// echo "<table class=\"table table-striped table-condensed small\">";
				foreach ($brr as $k => $v) {
					$sql = "SELECT id FROM kepeg_tr_tutam WHERE nip LIKE '".$v['nip']."' AND tahun LIKE '".$_SESSION['tutam']['tahun']."' AND bulan LIKE '".$_SESSION['tutam']['bulan']."' AND fk_rsa_unit LIKE '".$_SESSION['rsa_kode_unit_subunit']."'";
					$q = $this->db->query($sql);
					if($q->num_rows()<=0){
						// $rek = (array)$this->cantik_model->get_rekening_tutam($v['nip']);
						$bank = $this->cantik2_model->getDataRekening($v['id'],3);
						if(is_null($bank)){
							$bank['kelompok_bank'] = '';
							$bank['nmpemilik'] = '';
							$bank['norekening'] = '';
						}
						$sql_e[] = "('".$_SESSION['tutam']['tahun']."', '".$_SESSION['tutam']['bulan']."', '".$v['id']."', '".$this->cantik_model->encodeText(addslashes($v['nama']))."', '".$v['nip']."', '".$v['golongan_id']."', '".$v['gol']."', '".$v['unit_id']."', '".$v['status']."', '".$v['kelompok']."', '".$v['tgs_tambahan_id']."', '".$v['tugas_tambahan']."', '".$v['det_tgs_tambahan']."', '".$v['npwp']."', '".$bank['kelompok_bank']."', '".$this->cantik_model->encodeText(addslashes($bank['nmpemilik']))."', '".$this->cantik_model->encodeText(addslashes($bank['norekening']))."', '".$v['nominal']."', '".$v['pajak']."', '".$v['nom_pajak']."', '".$v['bersih']."', NOW(), '".$_SESSION['rsa_kode_unit_subunit']."')";
					}
					// echo "<tr><td>".$j."</td><td>".$v['nama']."</td><td>".$v['tugas_tambahan']."<br/>".$v['det_tgs_tambahan']."</td><td>".$bank['kelompok_bank']."(".$bank['jenisrek'].")<br/>".$bank['norekening']."</td></tr>"; // ngecek tabungan
					// echo "<tr><td>".$j."</td><td>".$v['nama']."</td><td>".$v['tugas_tambahan']."<br/>".$v['det_tgs_tambahan']."</td><td>".$this->cantik_model->number($v['nominal'])."</td></tr>"; // ngecek nominal kotor
					$j++;
				}
				// echo "</table>";
				// exit;
				if(count($sql_e)>0){
					$sql="INSERT INTO kepeg_tr_tutam(tahun, bulan, pegid, nama, nip, golongan_id, golpeg, unit_id, status, kelompok, tgs_tambahan_id, tugas_tambahan, det_tgs_tambahan, npwp, nmbank, nmpemilik, norekening, nominal, pajak, nom_pajak, bersih, waktu_proses,fk_rsa_unit) VALUES".implode(", ",$sql_e);
					// echo "<pre>".$sql."</pre>"; exit;
					// echo $sql; exit;
					if(!$this->db->query($sql)){
						// echo $this->db->_error_message(); exit;
						echo $this->cantik_model->msgGagal("Gagal melakukan eksekusi perintah."); exit;
					}
				}
				echo "1"; exit;
			}

			if(isset($_POST['act']) && $_POST['act']=='tutam_lihat'){
				$_SESSION['tutam']['bulan'] = $_POST['bulan'];
				$_SESSION['tutam']['tahun'] = $_POST['tahun'];
				echo "1"; exit;
			}

			if(isset($_POST['act']) && $_POST['act']=='tutam_hapus_single'){
				if(isset($_POST['id'])){
          			$sql = "DELETE FROM `kepeg_tr_tutam` WHERE `id` = ".intval($_POST['id']);
					$this->db->query($sql);
			          echo 1; exit;
			    }
        		echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
			}


		} // end post
	} // end function

	public function daftar()
	{
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption($_SESSION['tutam']['bulan']);
		// $subdata['dt'] = $this->cantik2_model->get_data_tutam();
		$data['main_content']	= $this->load->view('kepegawaian/tutam_daftar',$subdata,TRUE);
    	$data['main_menu']	= $this->load->view('main_menu','',TRUE);
    	$data['message']	= validation_errors();
    	$this->load->view('main_template',$data);
	}
	public function daftar_ajax(){
		$subdata['dt'] = $this->cantik2_model->getDataTutam();
		$this->load->view('kepegawaian/tutam_daftar_ajax',$subdata);
	}

	public function daftar_cetak()
	{
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['dt'] = $this->cantik2_model->getDataTutam();
		$subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
		$subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$subdata['filename'] = date('Ymd')."_tutam_dosen.xls";
		$data['main_content']	= $this->load->view('kepegawaian/tutam_daftar_cetak',$subdata,TRUE);
    	$data['message']	= validation_errors();
    	$this->load->view('cetak_template_excel',$data);
	}

	public function hapus_daftar_tutam(){
		$sql = "DELETE FROM kepeg_tr_tutam WHERE bulan LIKE '".$_SESSION['tutam']['bulan']."' AND tahun LIKE '".$_SESSION['tutam']['tahun']."' AND fk_rsa_unit LIKE '".$_SESSION['rsa_kode_unit_subunit']."%'";
		if($this->db->query($sql)){
			echo 1; exit;
		}
		echo $this->cantik_model->msgGagal('Gagal menghapus daftar tugas tambahan.'); exit;
	}

}
