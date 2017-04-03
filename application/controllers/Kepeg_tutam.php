<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Kepeg_tutam extends CI_Controller {

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
			$this->load->model('tutam_model');
    }else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

  /* -------------- Method ------------- */
  public function index(){
    $subdata['_cari1'] = ""; $subdata['_cari2'] = ""; $subdata['_cari3'] = ""; $subdata['_cari3_1'] = ""; $subdata['_cari3_2'] = ""; $subdata['_cari4'] = ""; $subdata['_cari5'] = ""; $subdata['_ch_1'] = ""; $subdata['_ch_2'] = ""; $subdata['_cari6'] = "";
		$subdata['_unit_id'] = "";
		$subdata['_status_kepeg'] = "";
		$subdata['_tahun'] = " value=\"".$this->cur_tahun."\" readonly=\"readonly\"";
    $subdata['_bulan'] = date("m");
		$subdata['_cari6'] = " has-success";
		if(isset($_SESSION['tutam'])){
			if(isset($_SESSION['tutam']['unit_id'])){
				$subdata['_unit_id'] = $_SESSION['tutam']['unit_id'];
				$subdata['_cari1'] = " has-success";
			}
			if(isset($_SESSION['tutam']['status_kepeg'])){
				$subdata['_status_kepeg'] = $_SESSION['tutam']['status_kepeg'];
				$subdata['_cari2'] = " has-success";
			}
			if(isset($_SESSION['tutam']['tahun']) && strlen(trim($_SESSION['tutam']['tahun']))==4){
				$subdata['_tahun'] = " value=\"".$this->cur_tahun."\" readonly=\"readonly\"";
				$subdata['_cari3'] = " has-success";
			}
			if(isset($_SESSION['tutam']['bulan']) && is_numeric($_SESSION['tutam']['bulan'])){
				$subdata['_cari4'] = " has-success";
			}
			if(isset($_SESSION['tutam']['status'])){
				$subdata['_cari5'] = " has-success";
			}
			/*if(isset($_SESSION['tutam']['jnspeg'])){
				$subdata['_cari6'] = " has-success";
			}*/
		}
    $subdata['dt'] = $this->tutam_model->daftar_pegawai();
    $subdata['jt'] = $this->tutam_model->jumlah_pegawai();
    $subdata['ut'] = $this->tutam_model->daftar_unit_kepeg();
    print_r($subdata['dt']); exit;
    $subdata['unitOption'] = $this->tutam_model->getUnitOption($subdata['_unit_id']);
    $subdata['bulanOption'] = $this->tutam_model->getBulanOption($subdata['_bulan']);
    $subdata['cur_tahun'] = $this->cur_tahun;
    $data['main_content']	= $this->load->view('tutam/lihat_data',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('main_template',$data);
  }

  public function set_halaman(){
    if(isset($_POST['id'])){
      if(intval($_POST['id'])==1){
        unset($_SESSION['tutam']['page']); echo "1"; exit;
      }
      $_SESSION['tutam']['page'] = $_POST['id']; echo "1"; exit;
    }
    echo "Tidak dapat melakukan set halaman."; exit;
  }

  public function proses_tutam(){
    if(isset($_POST['act'])){
      if($_POST['act']=='pemuja_rahasia'){
        // if(isset($_POST['']))
        // print_r($_POST);
        if(isset($_POST['unit_id'])){
          $_SESSION['tutam']['unit_id'] = $_POST['unit_id'];
        }
        if(isset($_POST['jnspeg'])){
          $_SESSION['tutam']['jnspeg'] = $_POST['jnspeg'];
        }
        if(isset($_POST['status'])){
          $_SESSION['tutam']['status'] = $_POST['status'];
        }
        if(isset($_POST['tahun'])){
          $_SESSION['tutam']['tahun'] = $_POST['tahun'];
        }
        if(isset($_POST['bulan'])){
          $_SESSION['tutam']['bulan'] = $_POST['bulan'];
        }
        // print_r($_SESSION['tutam']);
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

  public function lihat_data(){
    
  }
}
