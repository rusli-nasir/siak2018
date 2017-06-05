<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Cantik extends CI_Controller {

  private $cur_tahun = '' ;

  public function __construct(){
    parent::__construct();
    $this->cur_tahun = $this->setting_model->get_tahun();
    // if ($this->check_session->user_session()){
  		/*	Load library, helper, dan Model	*/
  		$this->load->library(array('form_validation','option'));
  		$this->load->helper('form');
      $this->load->model('user_model');
  		$this->load->model('menu_model');
      $this->load->model('login_model');
			$this->load->model('cantik_model');
    // }else{
		// 	redirect('welcome','refresh');	// redirect ke halaman home
		// }
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

  // public function set_halaman(){
  //   if(isset($_POST['id'])){
  //     if(intval($_POST['id'])==1){
  //       unset($_SESSION['tkk']['page']); echo "1"; exit;
  //     }
  //     $_SESSION['tkk']['page'] = $_POST['id']; echo "1"; exit;
  //   }
  //   echo "Tidak dapat melakukan set halaman."; exit;
  // }
  //
  // public function aku_cinta(){
  //   if(isset($_POST['act'])){
  //     if($_POST['act']=='pemuja_rahasia'){
  //       // if(isset($_POST['']))
  //       // print_r($_POST);
  //       if(isset($_POST['unit_id'])){
  //         $_SESSION['tkk']['unit_id'] = $_POST['unit_id'];
  //       }
  //       if(isset($_POST['jnspeg'])){
  //         $_SESSION['tkk']['jnspeg'] = $_POST['jnspeg'];
  //       }
  //       if(isset($_POST['status'])){
  //         $_SESSION['tkk']['status'] = $_POST['status'];
  //       }
  //       if(isset($_POST['tahun'])){
  //         $_SESSION['tkk']['tahun'] = $_POST['tahun'];
  //       }
  //       if(isset($_POST['bulan'])){
  //         $_SESSION['tkk']['bulan'] = $_POST['bulan'];
  //       }
  //       // print_r($_SESSION['tkk']);
  //       echo "1";
  //       exit;
  //     }
  //     if($_POST['act']=='pdkt'){
  //       // if(isset($_POST['']))
  //       print_r($_POST);
  //       exit;
  //     }
  //   }
  // }
  //
  // public function mungil(){
  //   $subdata['_cari1'] = ""; $subdata['_cari2'] = ""; $subdata['_cari3'] = ""; $subdata['_cari3_1'] = ""; $subdata['_cari3_2'] = ""; $subdata['_cari4'] = ""; $subdata['_cari5'] = ""; $subdata['_ch_1'] = ""; $subdata['_ch_2'] = ""; $subdata['_cari6'] = "";
	// 	$subdata['_unit_id'] = "";
	// 	$subdata['_status_kepeg'] = "";
	// 	$subdata['_tahun'] = " value=\"".$this->cur_tahun."\" readonly=\"readonly\"";
  //   $subdata['_bulan'] = date("m");
	// 	// $subdata['_classTab'][1] = "active";
	// 	// $subdata['_classTab_'][1] = " active";
	// 	if(isset($_SESSION['tkk'])){
	// 		if(isset($_SESSION['tkk']['unit_id'])){
	// 			$subdata['_unit_id'] = $_SESSION['tkk']['unit_id'];
	// 			$subdata['_cari1'] = " has-success";
	// 		}
	// 		if(isset($_SESSION['tkk']['status_kepeg'])){
	// 			$subdata['_status_kepeg'] = $_SESSION['tkk']['status_kepeg'];
	// 			$subdata['_cari2'] = " has-success";
	// 		}
	// 		if(isset($_SESSION['tkk']['tahun']) && strlen(trim($_SESSION['tkk']['tahun']))==4){
	// 			$subdata['_tahun'] = " value=\"".$this->cur_tahun."\" readonly=\"readonly\"";
	// 			$subdata['_cari3'] = " has-success";
	// 		}
	// 		if(isset($_SESSION['tkk']['bulan']) && is_numeric($_SESSION['tkk']['bulan'])){
	// 			$subdata['_cari4'] = " has-success";
	// 		}
	// 		if(isset($_SESSION['tkk']['status'])){
	// 			$subdata['_cari5'] = " has-success";
	// 		}
	// 		if(isset($_SESSION['tkk']['jnspeg'])){
	// 			$subdata['_cari6'] = " has-success";
	// 		}
	// 	}
  //   $subdata['dt'] = $this->cantik_model->daftar_pegawai_kontrak();
  //   $subdata['jt'] = $this->cantik_model->jumlah_pegawai_kontrak();
  //   $subdata['ut'] = $this->cantik_model->daftar_unit_kepeg();
  //   $subdata['unitOption'] = $this->cantik_model->getUnitOption($subdata['_unit_id']);
  //   $subdata['bulanOption'] = $this->cantik_model->getBulanOption($subdata['_bulan']);
  //   $subdata['cur_tahun'] = $this->cur_tahun;
  //   $data['main_content']	= $this->load->view('cantik/banget',$subdata,TRUE);
  //   $list["menu"]           = $this->menu_model->show();
  //   $list["submenu"]        = $this->menu_model->show();
  //   $data['main_menu']	= $this->load->view('main_menu','',TRUE);
  //   $data['message']	= validation_errors();
  //   $this->load->view('main_template',$data);
  // }

  public function kayanesih(){
    $sql = "SELECT a.nomor, a.detail_belanja, b.tgl_proses FROM kepeg_tr_spmls a JOIN trx_urut_spm_cair b ON a.nomor = b.str_nomor_trx_spm WHERE proses = 5";
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      $r = $q->result();
      foreach ($r as $k => $v) {
        $akun = explode(",",$v->detail_belanja);
        foreach ($akun as $k2 => $v2) {
          $sql = "UPDATE rsa_detail_belanja_ SET tanggal_transaksi = '".$v->tgl_proses."', proses = '62' WHERE kode_usulan_belanja LIKE '".substr($v2,0,24)."' AND kode_akun_tambah LIKE '".substr($v2,-3)."'";
          $this->db->query($sql);
          // echo $sql; echo "<br />";
        }
      }
    }
  }

  public function kataorang(){
    // $sql = "SELECT a.tgl_proses, c.kode_akun_tambah, c.kode_usulan_belanja FROM trx_lsphk3 a LEFT JOIN rsa_kuitansi_pihak3 b ON a.id_kuitansi = b.kuitansi_id LEFT JOIN rsa_spm_kontrakpihak3 c ON c.id_kontrak = b.kontrak_id WHERE posisi LIKE 'SPM-FINAL-KBUU' ORDER BY c.kode_usulan_belanja";
    $sql = "SELECT a.tgl_proses, b.kode_usulan_belanja, b.jenis, b.kode_akun_tambah FROM trx_lsphk3 a JOIN rsa_kuitansi_lsphk3 b ON a.id_kuitansi = b.id_kuitansi JOIN rsa_kuitansi_pihak3 c ON b.id_kuitansi = c.kuitansi_id WHERE posisi LIKE 'SPM-FINAL-KBUU' ORDER BY b.jenis";
    // $sql = "SELECT b.kode_usulan_belanja, b.jenis, c.kode_akun_tambah FROM trx_lsphk3 a JOIN rsa_kuitansi_lsphk3 b ON a.id_kuitansi = b.id_kuitansi JOIN rsa_detail_belanja_ c ON b.kode_usulan_belanja = c.kode_usulan_belanja WHERE posisi LIKE 'SPM-FINAL-KBUU'  GROUP BY c.kode_akun_tambah ORDER BY b.jenis";
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      $r = $q->result();
      // print_r($r); exit;
      $i = 1;
      foreach ($r as $k => $v) {
        // $akun = explode(",",$v->detail_belanja);
        // if(!is_null($v->kode_usulan_belanja) || !is_null($v->kode_akun_tambah)){
        $dt = '65';
          if($v->jenis == 'L3'){
            $dt = '64';
          }
          $sql = "UPDATE rsa_detail_belanja_ SET tanggal_transaksi = '".$v->tgl_proses."', proses = '".$dt."' WHERE kode_usulan_belanja LIKE '".$v->kode_usulan_belanja."' AND kode_akun_tambah LIKE '".$v->kode_akun_tambah."'";
          if($this->db->query($sql)){
            echo $i.". ".$sql; echo " : Berhasil **<br />";
          }else{
            echo $i.". ".$sql; echo " : Gagal **<br />";
          }
          // echo $i.". ".$sql; echo "<br />";
          // echo $i.". ".$v->tgl_proses." | ".$v->kode_usulan_belanja." | ".$v->kode_akun_tambah." | ".$v->jenis."<br />";
          // echo $i.". ".$v->kode_usulan_belanja." | ".$v->kode_akun_tambah." | ".$v->jenis."<br />";
          $i++;
        // }else{

        // }
      }
    }
  }

}
