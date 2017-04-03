<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Cantik extends CI_Controller {

  private $cur_tahun = '' ;

  public function __construct(){
    parent::__construct();
    $this->cur_tahun = $this->setting_model->get_tahun();
    if ($this->check_session->user_session()){
  		/*	Load library, helper, dan Model	*/
  		$this->load->library(array('form_validation','option'));
  		$this->load->helper('form');
      $this->load->model('user_model');
  		$this->load->model('menu_model');
      $this->load->model('login_model');
			$this->load->model('cantik_model');
    }else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

  /* -------------- Method ------------- */
  public function index(){
    /*
    $subdata['_cari1'] = ""; $subdata['_cari2'] = ""; $subdata['_cari3'] = ""; $subdata['_cari3_1'] = ""; $subdata['_cari3_2'] = ""; $subdata['_cari4'] = ""; $subdata['_cari5'] = ""; $subdata['_ch_1'] = ""; $subdata['_ch_2'] = ""; $subdata['_cari6'] = "";
		$subdata['_unit_id'] = "";
		$subdata['_status_kepeg'] = "";
		$subdata['_tahun'] = " value=\"".$this->cur_tahun."\" readonly=\"readonly\"";
    $subdata['_bulan'] = date("m");
		// $subdata['_classTab'][1] = "active";
		// $subdata['_classTab_'][1] = " active";
		if(isset($_SESSION['tkk'])){
			if(isset($_SESSION['tkk']['unit_id'])){
				$subdata['_unit_id'] = $_SESSION['tkk']['unit_id'];
				$subdata['_cari1'] = " has-success";
			}
			if(isset($_SESSION['tkk']['status_kepeg'])){
				$subdata['_status_kepeg'] = $_SESSION['tkk']['status_kepeg'];
				$subdata['_cari2'] = " has-success";
			}
			if(isset($_SESSION['tkk']['tahun']) && strlen(trim($_SESSION['tkk']['tahun']))==4){
				$subdata['_tahun'] = " value=\"".$this->cur_tahun."\" readonly=\"readonly\"";
				$subdata['_cari3'] = " has-success";
			}
			if(isset($_SESSION['tkk']['bulan']) && is_numeric($_SESSION['tkk']['bulan'])){
				$subdata['_cari4'] = " has-success";
			}
			if(isset($_SESSION['tkk']['status'])){
				$subdata['_cari5'] = " has-success";
			}
			if(isset($_SESSION['tkk']['jnspeg'])){
				$subdata['_cari6'] = " has-success";
			}
		}
    $subdata['dt'] = $this->cantik_model->daftar_pegawai_kontrak();
    $subdata['jt'] = $this->cantik_model->jumlah_pegawai_kontrak();
    $subdata['ut'] = $this->cantik_model->daftar_unit_kepeg();
    // print_r($subdata['ut']); exit;
    $subdata['unitOption'] = $this->cantik_model->getUnitOption($subdata['_unit_id']);
    $subdata['bulanOption'] = $this->cantik_model->getBulanOption($subdata['_bulan']);
    $subdata['cur_tahun'] = $this->cur_tahun;
    $data['main_content']	= $this->load->view('cantik/kentut',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('main_template',$data);
    */
    redirect('modul_gaji/');
  }

  public function set_halaman(){
    if(isset($_POST['id'])){
      if(intval($_POST['id'])==1){
        unset($_SESSION['tkk']['page']); echo "1"; exit;
      }
      $_SESSION['tkk']['page'] = $_POST['id']; echo "1"; exit;
    }
    echo "Tidak dapat melakukan set halaman."; exit;
  }

  public function aku_cinta(){
    if(isset($_POST['act'])){
      if($_POST['act']=='pemuja_rahasia'){
        // if(isset($_POST['']))
        // print_r($_POST);
        if(isset($_POST['unit_id'])){
          $_SESSION['tkk']['unit_id'] = $_POST['unit_id'];
        }
        if(isset($_POST['jnspeg'])){
          $_SESSION['tkk']['jnspeg'] = $_POST['jnspeg'];
        }
        if(isset($_POST['status'])){
          $_SESSION['tkk']['status'] = $_POST['status'];
        }
        if(isset($_POST['tahun'])){
          $_SESSION['tkk']['tahun'] = $_POST['tahun'];
        }
        if(isset($_POST['bulan'])){
          $_SESSION['tkk']['bulan'] = $_POST['bulan'];
        }
        // print_r($_SESSION['tkk']);
        echo "1";
        exit;
      }
      if($_POST['act']=='pdkt'){
        // if(isset($_POST['']))
        print_r($_POST);
        exit;
      }
    }
  }

  public function mungil(){
    $subdata['_cari1'] = ""; $subdata['_cari2'] = ""; $subdata['_cari3'] = ""; $subdata['_cari3_1'] = ""; $subdata['_cari3_2'] = ""; $subdata['_cari4'] = ""; $subdata['_cari5'] = ""; $subdata['_ch_1'] = ""; $subdata['_ch_2'] = ""; $subdata['_cari6'] = "";
		$subdata['_unit_id'] = "";
		$subdata['_status_kepeg'] = "";
		$subdata['_tahun'] = " value=\"".$this->cur_tahun."\" readonly=\"readonly\"";
    $subdata['_bulan'] = date("m");
		// $subdata['_classTab'][1] = "active";
		// $subdata['_classTab_'][1] = " active";
		if(isset($_SESSION['tkk'])){
			if(isset($_SESSION['tkk']['unit_id'])){
				$subdata['_unit_id'] = $_SESSION['tkk']['unit_id'];
				$subdata['_cari1'] = " has-success";
			}
			if(isset($_SESSION['tkk']['status_kepeg'])){
				$subdata['_status_kepeg'] = $_SESSION['tkk']['status_kepeg'];
				$subdata['_cari2'] = " has-success";
			}
			if(isset($_SESSION['tkk']['tahun']) && strlen(trim($_SESSION['tkk']['tahun']))==4){
				$subdata['_tahun'] = " value=\"".$this->cur_tahun."\" readonly=\"readonly\"";
				$subdata['_cari3'] = " has-success";
			}
			if(isset($_SESSION['tkk']['bulan']) && is_numeric($_SESSION['tkk']['bulan'])){
				$subdata['_cari4'] = " has-success";
			}
			if(isset($_SESSION['tkk']['status'])){
				$subdata['_cari5'] = " has-success";
			}
			if(isset($_SESSION['tkk']['jnspeg'])){
				$subdata['_cari6'] = " has-success";
			}
		}
    $subdata['dt'] = $this->cantik_model->daftar_pegawai_kontrak();
    $subdata['jt'] = $this->cantik_model->jumlah_pegawai_kontrak();
    $subdata['ut'] = $this->cantik_model->daftar_unit_kepeg();
    $subdata['unitOption'] = $this->cantik_model->getUnitOption($subdata['_unit_id']);
    $subdata['bulanOption'] = $this->cantik_model->getBulanOption($subdata['_bulan']);
    $subdata['cur_tahun'] = $this->cur_tahun;
    $data['main_content']	= $this->load->view('cantik/banget',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('main_template',$data);
  }
}
