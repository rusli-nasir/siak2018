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
			$this->load->helper('form');
			$this->load->model('login_model');
			$this->load->model('menu_model');
			$this->load->model('user_model');
			$this->load->library('form_validation');
			$this->load->library('revisi_session');
			$this->load->model('cantik_model');
			$this->load->model('setting_model');
			
			// otomatis set tahun
			if(!isset($_SESSION['tutam']['tahun'])){
				$_SESSION['tutam']['tahun'] = $this->cur_tahun;
			}
			
		}
  }


	public function index()
	{
    $subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption(date('m'));
		$subdata['dt'] = $this->cantik_model->get_data_pegawai_tutam();
		$data['main_content']	= $this->load->view('modul_gaji/tutam',$subdata,TRUE);
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
				$dt = $this->cantik_model->get_data_pegawai_tutam();
				// print_r($dt); exit;
				$sql_e = array();
				for($j=0;$j<count($dt);$j++){
					$v = $dt[$j];
					$nominal2 = 0; $nominal0 = 0;
					$nominal = $this->cantik_model->getNominalTutam($v->tgs_tambahan_id,$v->kelompok);
					if($nominal == 0){
						continue;
					}
					if($j<(count($dt)-1) && $dt[($j+1)]->nip == $v->nip){
						$nominal2 = $this->cantik_model->getNominalTutam($dt[($j+1)]->tgs_tambahan_id,$dt[($j+1)]->kelompok);
						if($nominal<$nominal2){
							continue;
						}
					}
					if($j!=0 && $dt[($j-1)]->nip == $v->nip){
						$nominal0 = $this->cantik_model->getNominalTutam($dt[($j-1)]->tgs_tambahan_id,$dt[($j-1)]->kelompok);
						if($nominal0 > $nominal){
							continue;
						}
					}
					if($v->kelompok==3){
						$pajak = 0.05;
					}elseif($v->kelompok==4){
						$pajak = 0.15;
					}
					$nom_pajak = round($nominal*$pajak);
					$bersih = $nominal - $nom_pajak;
					$sql = "SELECT id FROM kepeg_tr_tutam WHERE nip LIKE '".$v->nip."' AND tahun LIKE '".$_SESSION['tutam']['tahun']."' AND bulan LIKE '".$_SESSION['tutam']['bulan']."'";
					$q = $this->db->query($sql);
					if($q->num_rows()<=0){
						$sql_e[] = "('".$_SESSION['tutam']['tahun']."', '".$_SESSION['tutam']['bulan']."', '".$v->nama."', '".$v->nip."', '".$v->golongan_id."', '".$v->unit_id."', '".$v->status."', '".$v->kelompok."', '".$v->tgs_tambahan_id."', '".$v->tugas_tambahan."', '".$v->det_tgs_tambahan."', '".$v->nmbank."', '".$v->norekening."', '".$nominal."', '".$pajak."', '".$nom_pajak."', '".$bersih."', NOW())";
					}
				}
				if(count($sql_e)>0){
					$sql="INSERT INTO kepeg_tr_tutam(tahun, bulan, nama, nip, golongan_id, unit_id, status, kelompok, tgs_tambahan_id, tugas_tambahan, det_tgs_tambahan, nmbank, norekening, nominal, pajak, nom_pajak, bersih, waktu_proses) VALUES".implode(", ",$sql_e);
					//echo $sql; exit;
					$this->db->query($sql);
				}
				echo "1"; exit;
			}
			
			if(isset($_POST['act']) && $_POST['act']=='tutam_lihat'){
				$_SESSION['tutam']['bulan'] = $_POST['bulan'];
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
		$subdata['dt'] = $this->cantik_model->get_data_tutam();
		$data['main_content']	= $this->load->view('modul_gaji/tutam_daftar',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('main_template',$data);
	}
	
	public function daftar_cetak()
	{
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['dt'] = $this->cantik_model->get_data_tutam();
		$subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
		$subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$data['main_content']	= $this->load->view('modul_gaji/tutam_daftar_cetak',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    //$data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('cetak_template_excel',$data);
	}

	public function hapus_daftar_tutam(){
		$sql = "DELETE FROM kepeg_tr_tutam WHERE bulan LIKE '".$_SESSION['tutam']['bulan']."' AND tahun LIKE '".$_SESSION['tutam']['tahun']."'";
		if($this->db->query($sql)){
			echo 1; exit;
		}
		echo $this->cantik_model->msgGagal('Gagal menghapus daftar tugas tambahan.'); exit;
	}

}