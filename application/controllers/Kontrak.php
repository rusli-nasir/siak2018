<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Kontrak extends CI_Controller {

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

      if(!isset($_SESSION['tkk']['status'])){
        $_SESSION['tkk']['status'] = array(1,3,6,12,13);
      }

      if(!isset($_SESSION['tkk']['status_kepeg'])){
        $_SESSION['tkk']['status_kepeg'][0] = 4;
      }

      // otomatis set tahun
      if(!isset($_SESSION['tkk']['tahun'])){
        $_SESSION['tkk']['tahun'] = $this->cur_tahun;
      }

      // otomatis set seluruh unit
      if(!isset($_SESSION['tkk']['unit_id'])){
        if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42' || substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='91'){
          $_SESSION['tkk']['unit_id'] = $this->cantik_model->getUnitChecked();
        }else{
          $_SESSION['tkk']['unit_id'] = $this->cantik_model->get_unit_rba($this->check_session->get_unit());
        }
      }
    }else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

  /* -------------- Method ------------- */
  public function index(){
    $subdata['status_kepeg'] = array();
    if(isset($_SESSION['tkk']['status_kepeg'])){
      $subdata['status_kepeg'] = $_SESSION['tkk']['status_kepeg'];
    }
    $subdata['cur_tahun'] = $this->cur_tahun;
    $subdata['unitList'] = $this->cantik_model->getUnitList($_SESSION['tkk']['unit_id']);
    // $subdata['statusKepegOption'] = $this->cantik_model->getStatusKepegFullCheckbox($subdata['status_kepeg']);
    $unit = $this->check_session->get_unit();
    if(!isset($_SESSION['tkk']['bulan'])){
      $bulan = date('m');
    }else{
      $bulan = $_SESSION['tkk']['bulan'];
    }
    $subdata['bulanOption'] = $this->cantik_model->getBulanOption($bulan);
    $data['main_content'] = $this->load->view('modul_gaji/kontrak',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']  = $this->load->view('main_menu','',TRUE);
    $data['message']  = validation_errors();
    $this->load->view('main_template',$data);
  }

  public function proses(){
    // print_r($_SESSION); exit;
    // set session
    // data yang diklik -> dimasukkan ke dalam session
    unset($_SESSION['tkk']);
    $_SESSION['tkk']['tahun'] = $this->cur_tahun;
    if(isset($_POST['unit_id'])){
      $_SESSION['tkk']['unit_id'] = $_POST['unit_id'];
    }
    if(isset($_POST['status_kepeg'])){
      // $_SESSION['tkk']['status_kepeg'] = $_POST['status_kepeg'];
      $_SESSION['tkk']['status_kepeg'][0] = $_POST['status_kepeg'];
    }
    if(isset($_POST['status'])){
      $_SESSION['tkk']['status'] = $_POST['status'];
    }
    if(isset($_POST['jnspeg'])){
      $_SESSION['tkk']['jnspeg'] = $_POST['jnspeg'];
    }
    if(isset($_POST['bulan'])){
      $_SESSION['tkk']['bulan'] = $_POST['bulan'];
    }
    echo "1";
    exit;
  }

  public function proses_lihat(){
    unset($_SESSION['tkk']);

    $_SESSION['tkk']['tahun'] = $_POST['tahun'];

    if(isset($_POST['unit_id'])){
      $_SESSION['tkk']['unit_id'] = $_POST['unit_id'];
    }else{
      echo $this->cantik_model->msgGagal("Pilih salah satu unit yang akan ditampilkan data gaji tenaga kontrak-nya."); exit;
    }

    if(isset($_POST['status_kepeg'])){
      $_SESSION['tkk']['status_kepeg'][0] = $_POST['status_kepeg'];
    }

    if(isset($_POST['status'])){
      $_SESSION['tkk']['status'] = $_POST['status'];
    }else{
      echo $this->cantik_model->msgGagal("Pilih salah satu status yang akan ditampilkan data gaji tenaga kontrak-nya."); exit;
    }

    if(isset($_POST['jnspeg'])){
      $_SESSION['tkk']['jnspeg'] = $_POST['jnspeg'];
    }

    if(isset($_POST['bulan'])){
      $_SESSION['tkk']['bulan'] = $_POST['bulan'];
    }

    echo 1; exit;
  }

  public function showDialogProsesGaji(){
    if(!isset($_SESSION['tkk'])){
      echo $this->cantik_model->msgGagal('Pilih kriteria proses gaji tenaga kontrak sebelum melakukan proses'); exit;
    }
    $unit = "seluruh unit Universitas Diponegoro";
    $sql = "SELECT id FROM kepeg_tb_pegawai WHERE jnspeg = ".intval($_SESSION['tkk']['jnspeg']);
    if(isset($_SESSION['tkk']['status_kepeg']) && is_array($_SESSION['tkk']['status_kepeg']) && count($_SESSION['tkk']['status_kepeg'])>1){
      $sql.= " AND ( `status_kepeg` = ".implode(" OR status_kepeg = ", $_SESSION['tkk']['status_kepeg']).")";
    }elseif(isset($_SESSION['tkk']['status_kepeg']) && is_array($_SESSION['tkk']['status_kepeg']) && count($_SESSION['tkk']['status_kepeg'])==1){
      $sql.= " AND `status_kepeg` = ".$_SESSION['tkk']['status_kepeg'][0];
    }
    if(isset($_SESSION['tkk']['unit_id']) && is_array($_SESSION['tkk']['unit_id']) && count($_SESSION['tkk']['unit_id'])>1){
      $sql.= " AND ( `unit_id` = ".implode(" OR unit_id = ", $_SESSION['tkk']['unit_id']).")";
    }elseif(isset($_SESSION['tkk']['unit_id']) && is_array($_SESSION['tkk']['unit_id']) && count($_SESSION['tkk']['unit_id'])==1){
      $sql.= " AND `unit_id` = ".$_SESSION['tkk']['unit_id'][0];
    }
    if(isset($_SESSION['tkk']['status']) && is_array($_SESSION['tkk']['status']) && count($_SESSION['tkk']['status'])>1){
      $sql.= " AND ( `status` = ".implode(" OR status = ", $_SESSION['tkk']['status']).")";
    }elseif(isset($_SESSION['tkk']['status']) && is_array($_SESSION['tkk']['status']) && count($_SESSION['tkk']['status'])==1){
      $sql.= " AND `status` = ".$_SESSION['tkk']['status'][0];
    }
    // echo $sql; exit;
    $row = $this->db->query($sql)->num_rows();
    $aksi = "";
    $html = "";
    $html .= "<div class=\"alert small\">
      <h4 class=\"page-header\"><i class=\"fa fa-bullhorn\"></i>&nbsp;&nbsp;Informasi Proses Data Gaji Tenaga Kontrak ".$this->cantik_model->getJenisPeg($_SESSION['tkk']['jnspeg'])."</h4>
      <p>Jumlah Pegawai yang akan di-proses adalah <strong>".$row."</strong> orang.</p>";
    $html.="<p>Unit yang diproses : <strong>".$this->cantik_model->get_unit_tkk()."</strong></p>";
    $html.="<p>Status Kepegawaian yang diproses : <strong>".$this->cantik_model->get_status_tkk()."</strong></p>";
    $html.="<p>Status Personel yang diproses : <strong>".$this->cantik_model->get_status_kerja_tkk()."</strong></p>";
    if($row > 0){
      $aksi = "<button type=\"button\" class=\"btn btn-primary btn-sm\" id=\"proses_2\"><i class=\"fa fa-spinner\"></i>&nbsp;&nbsp;&nbsp;Proses Daftar Gaji Tenaga Kerja Kontrak</button>";
      $html.="<p>Klik ".$aksi." untuk melakukan proses pembuatan daftar Gaji Tenaga Kontrak pada tahun <strong>".$_SESSION['tkk']['tahun']."</strong> untuk Pembayaran Bulan <strong>".$this->cantik_model->wordMonth($_SESSION['tkk']['bulan'])."</strong>.</p><p class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Perhatian: <strong>Data yang sudah dibuat, akan dilewati.</strong></p>";
    }else{
      $html.="<p class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Tidak dapat melakukan proses pembuatan daftar gaji tenaga kontrak karena jumlah pegawai tidak ada.</p>";
    }
    $html.="</div>";
    echo $html;
    exit;
  }


  public function proses2(){
    if(!isset($_SESSION['tkk'])){
      echo $this->cantik_model->msgGagal('Pilih kriteria proses gaji tenaga kontrak sebelum melakukan proses'); exit;
    }
    $unit = "seluruh unit Universitas Diponegoro";
    $sql = "SELECT id, nip, unit_id, ijazah_id, jabatan_id, status_kepeg, jnspeg, status FROM kepeg_tb_pegawai WHERE jnspeg = ".intval($_SESSION['tkk']['jnspeg']);
    if(isset($_SESSION['tkk']['status_kepeg']) && is_array($_SESSION['tkk']['status_kepeg']) && count($_SESSION['tkk']['status_kepeg'])>1){
      $sql.= " AND ( `status_kepeg` = ".implode(" OR status_kepeg = ", $_SESSION['tkk']['status_kepeg']).")";
    }elseif(isset($_SESSION['tkk']['status_kepeg']) && is_array($_SESSION['tkk']['status_kepeg']) && count($_SESSION['tkk']['status_kepeg'])==1){
      $sql.= " AND `status_kepeg` = ".$_SESSION['tkk']['status_kepeg'][0];
    }
    if(isset($_SESSION['tkk']['unit_id']) && is_array($_SESSION['tkk']['unit_id']) && count($_SESSION['tkk']['unit_id'])>1){
      $sql.= " AND ( `unit_id` = ".implode(" OR unit_id = ", $_SESSION['tkk']['unit_id']).")";
    }elseif(isset($_SESSION['tkk']['unit_id']) && is_array($_SESSION['tkk']['unit_id']) && count($_SESSION['tkk']['unit_id'])==1){
      $sql.= " AND `unit_id` = ".$_SESSION['tkk']['unit_id'][0];
    }
    if(isset($_SESSION['tkk']['status']) && is_array($_SESSION['tkk']['status']) && count($_SESSION['tkk']['status'])>1){
      $sql.= " AND ( `status` = ".implode(" OR status = ", $_SESSION['tkk']['status']).")";
    }elseif(isset($_SESSION['tkk']['status']) && is_array($_SESSION['tkk']['status']) && count($_SESSION['tkk']['status'])==1){
      $sql.= " AND `status` = ".$_SESSION['tkk']['status'][0];
    }
    $q = $this->db->query($sql);
    $row = $q->num_rows();
    if($row > 0){
      $d = $q->result();
      $i=1;
      foreach ($d as $k => $v) {
        $sql = "SELECT * FROM kepeg_tr_dgaji WHERE bulan LIKE '".$_SESSION['tkk']['bulan']."' AND tahun LIKE '".$_SESSION['tkk']['tahun']."' AND pegid = ".$v->id." AND nip LIKE '".$v->nip."'";
        $q2 = $this->db->query($sql);
        if($q2->num_rows()==0){
          $sql = "INSERT INTO kepeg_tr_dgaji(bulan, tahun, pegid, nip, unitid, pedid, jabid, jnspeg, status, statuspeg, nominalg) VALUES ('".$_SESSION['tkk']['bulan']."', '".$_SESSION['tkk']['tahun']."', '".$v->id."', '".$v->nip."', '".$v->unit_id."', '".$v->ijazah_id."', '".$v->jabatan_id."', '".$v->jnspeg."', '".$v->status."', '".$v->status_kepeg."', '".$this->cantik_model->get_nominal_tkk($v->jabatan_id, $v->ijazah_id, $v->nip, $v->jnspeg)."')";
          // echo $sql."<br />";
          $this->db->query($sql);
        }
        $i++;
      }
    }
    echo "1";
    exit;
  }

  public function daftar(){
    $subdata['status_kepeg'] = array();
    if(isset($_SESSION['tkk']['status_kepeg'])){
      $subdata['status_kepeg'] = $_SESSION['tkk']['status_kepeg'];
    }
    $subdata['cur_tahun'] = $this->cur_tahun;
    $subdata['unitList'] = $this->cantik_model->getUnitList($_SESSION['tkk']['unit_id']);
    // $subdata['statusKepegOption'] = $this->cantik_model->getStatusKepegFullCheckbox($subdata['status_kepeg']);
    $unit = $this->check_session->get_unit();
    if(!isset($_SESSION['tkk']['bulan'])){
      $bulan = date('m');
    }else{
      $bulan = $_SESSION['tkk']['bulan'];
    }
    $subdata['dt'] = $this->cantik_model->get_data_tkk();
    $subdata['daftar_unit'] = $this->cantik_model->get_unit_tkk();
    $subdata['jenis_peg'] = $this->cantik_model->get_status_tkk();
    $subdata['daftar_status'] = $this->cantik_model->get_status_kerja_tkk();
    $subdata['bulanOption'] = $this->cantik_model->getBulanOption($bulan);
    $data['main_content'] = $this->load->view('modul_gaji/kontrak_daftar',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']  = $this->load->view('main_menu','',TRUE);
    $data['message']  = validation_errors();
    $this->load->view('main_template',$data);
  }

  public function hapus(){
    $sql="DELETE FROM kepeg_tr_dgaji WHERE id=".intval($_POST['id']);
    if($this->db->query($sql)){
      echo "1";
    }
    exit;
  }

  public function hapus_daftar(){
    if(isset($_SESSION['tkk'])){
      $vSQL = "";
      if(isset($_SESSION['tkk']['status_kepeg']) && is_array($_SESSION['tkk']['status_kepeg']) && count($_SESSION['tkk']['status_kepeg'])>1){
        $vSQL.= " AND ( `statuspeg` = ".implode(" OR statuspeg = ", $_SESSION['tkk']['status_kepeg']).")";
      }elseif(isset($_SESSION['tkk']['status_kepeg']) && is_array($_SESSION['tkk']['status_kepeg']) && count($_SESSION['tkk']['status_kepeg'])==1){
        $vSQL.= " AND statuspeg = ".$_SESSION['tkk']['status_kepeg'][0];
      }
      if(isset($_SESSION['tkk']['unit_id']) && is_array($_SESSION['tkk']['unit_id']) && count($_SESSION['tkk']['unit_id'])>1){
        $vSQL.= " AND ( unitid = ".implode(" OR b.unit_id = ", $_SESSION['tkk']['unit_id']).")";
      }elseif(isset($_SESSION['tkk']['unit_id']) && is_array($_SESSION['tkk']['unit_id']) && count($_SESSION['tkk']['unit_id'])==1){
        $vSQL.= " AND unitid = ".$_SESSION['tkk']['unit_id'][0];
      }
      if(isset($_SESSION['tkk']['status']) && is_array($_SESSION['tkk']['status']) && count($_SESSION['tkk']['status'])>1){
        $vSQL.= " AND ( `status` = ".implode(" OR status = ", $_SESSION['tkk']['status']).")";
      }elseif(isset($_SESSION['tkk']['status']) && is_array($_SESSION['tkk']['status']) && count($_SESSION['tkk']['status'])==1){
        $vSQL.= " AND `status` = ".$_SESSION['tkk']['status'][0];
      }
      if(isset($_SESSION['tkk']['tahun'])){
        $vSQL.= " AND tahun = ".$_SESSION['tkk']['tahun'];
      }
      if(isset($_SESSION['tkk']['bulan'])){
        $vSQL.= " AND bulan = ".$_SESSION['tkk']['bulan'];
      }
      $sql="DELETE FROM kepeg_tr_dgaji WHERE id!=0".$vSQL;
      // echo $sql; exit;
      if($this->db->query($sql)){
        echo "1";
      }
    }
    exit;
  }

  public function daftar_cetak(){
    $subdata['status_kepeg'] = array();
    if(isset($_SESSION['tkk']['status_kepeg'])){
      $subdata['status_kepeg'] = $_SESSION['tkk']['status_kepeg'];
    }
    $subdata['cur_tahun'] = $this->cur_tahun;
    $subdata['dt'] = $this->cantik_model->get_data_tkk();
    $subdata['daftar_unit'] = $this->cantik_model->get_unit_tkk();
    $subdata['jenis_peg'] = $this->cantik_model->get_status_tkk();
    $subdata['daftar_status'] = $this->cantik_model->get_status_kerja_tkk();
    $subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
    $subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
    $data['main_content'] = $this->load->view('modul_gaji/kontrak_daftar_cetak',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    //$data['main_menu']  = $this->load->view('main_menu','',TRUE);
    $data['message']  = validation_errors();
    // $data['filename'] = "daftar_cetak_gaji_tkk_".str_replace(", ", "-", $subdata['daftar_unit'])."_".date('YmdHis').".xls";
    $data['filename'] = $_SESSION['tkk']['tahun'].$_SESSION['tkk']['bulan']."_daftar_cetak_gaji_tkk_".date('YmdHis').".xls";
    $this->load->view('cetak_template_excel',$data);
  }

}
