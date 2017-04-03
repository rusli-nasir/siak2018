<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji_blu extends CI_Controller {
	
	private $cur_tahun = '' ;
	private $rek_tunj_pns = 2;
	private $rek_nonpns = 2;
	private $pot_tugasbelajar = 0.75;

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
			if(!isset($_SESSION['gaji_blu']['status'])){
				$_SESSION['gaji_blu']['status'] = array(1,3,6,12);
			}
			if(!isset($_SESSION['gaji_blu']['tahun'])){
				$_SESSION['gaji_blu']['tahun'] = $this->cur_tahun;
			}
			if(!isset($_SESSION['gaji_blu']['jnspeg'])){
				$_SESSION['gaji_blu']['jnspeg'] = 2;
			}
			if(!isset($_SESSION['gaji_blu']['status_kepeg'])){
				$_SESSION['gaji_blu']['status_kepeg'] = array(2);
			}
			if(!isset($_SESSION['gaji_blu']['unit_id'])){
				if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42'){
					$_SESSION['gaji_blu']['unit_id'] = $this->cantik_model->getUnitChecked();
				}else{
					$_SESSION['gaji_blu']['unit_id'] = $this->cantik_model->get_unit_rba($this->check_session->get_unit());
				}
			}
			
		}
  }


	public function index()
	{
    $subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['unitList'] = $this->cantik_model->getUnitList($_SESSION['gaji_blu']['unit_id']);
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption(date('m'));
		$data['main_content']	= $this->load->view('modul_gaji/gaji_blu',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('main_template',$data);
	}
	
	public function showDialogProsesGajiBLU(){
		if(!isset($_SESSION['gaji_blu'])){
			echo $this->cantik_model->msgGagal('Pilih kriteria proses Gaji Tenaga Tendik Non PNS (BLU) sebelum melakukan proses'); exit;
		}
		$unit = "seluruh unit Universitas Diponegoro";
		$sql = "SELECT id FROM kepeg_tb_pegawai WHERE jnspeg = ".intval($_SESSION['gaji_blu']['jnspeg'])." AND status_kepeg = ".$_SESSION['gaji_blu']['status_kepeg'][0];
		if(isset($_SESSION['gaji_blu']['unit_id']) && is_array($_SESSION['gaji_blu']['unit_id']) && count($_SESSION['gaji_blu']['unit_id'])>1){
			$sql.= " AND ( `unit_id` = ".implode(" OR unit_id = ", $_SESSION['gaji_blu']['unit_id']).")";
		}elseif(isset($_SESSION['gaji_blu']['unit_id']) && is_array($_SESSION['gaji_blu']['unit_id']) && count($_SESSION['gaji_blu']['unit_id'])==1){
			$sql.= " AND `unit_id` = ".$_SESSION['gaji_blu']['unit_id'][0];
		}
		if(isset($_SESSION['gaji_blu']['status']) && is_array($_SESSION['gaji_blu']['status']) && count($_SESSION['gaji_blu']['status'])>1){
			$sql.= " AND ( `status` = ".implode(" OR status = ", $_SESSION['gaji_blu']['status']).")";
		}elseif(isset($_SESSION['gaji_blu']['status']) && is_array($_SESSION['gaji_blu']['status']) && count($_SESSION['gaji_blu']['status'])==1){
			$sql.= " AND `status` = ".$_SESSION['gaji_blu']['status'][0];
		}
		// echo $sql; exit;
		$row = $this->db->query($sql)->num_rows();
		$aksi = "";
		$html = "";
		$html .= "<div class=\"alert small\">
			<h4 class=\"page-header\"><i class=\"fa fa-bullhorn\"></i>&nbsp;&nbsp;Informasi Proses Data Gaji Tenaga Tendik Non PNS (BLU)</h4>
			<p>Jumlah Pegawai yang akan di-proses adalah <strong>".$row."</strong> orang.</p>";
		$html.="<p>Unit yang diproses : <strong>".$this->cantik_model->get_unit_gaji_blu()."</strong></p>";
		$html.="<p>Status Personel yang diproses : <strong>".$this->cantik_model->get_status_kerja_gaji_blu()."</strong></p>";
		if($row > 0){
			$aksi = "<button type=\"button\" class=\"btn btn-primary btn-sm\" id=\"proses_2\"><i class=\"fa fa-spinner\"></i>&nbsp;&nbsp;&nbsp;Proses Daftar Gaji Tenaga Tendik Non PNS (BLU)</button>";
			$html.="<p>Klik ".$aksi." untuk melakukan proses pembuatan daftar Gaji Tenaga Tendik Non PNS (BLU) pada tahun <strong>".$_SESSION['gaji_blu']['tahun']."</strong> untuk Pembayaran Bulan <strong>".$this->cantik_model->wordMonth($_SESSION['gaji_blu']['bulan'])."</strong>.</p><p class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Perhatian: <strong>Data yang sudah dibuat, akan dilewati.</strong></p>";
		}else{
			$html.="<p class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Tidak dapat melakukan proses pembuatan daftar Gaji Tenaga Tendik Non PNS (BLU) karena jumlah pegawai tidak ada.</p>";
		}
		$html.="</div>";
		echo $html;
		exit;
	}
	
	public function gajiblu_proses(){
		// print_r($_POST); exit;
		if(isset($_POST)){
			if(isset($_POST['act']) && $_POST['act']=='gajiblu_proses'){
				$_SESSION['gaji_blu']['bulan'] = $_POST['bulan'];
        if(isset($_POST['unit_id']) && is_array($_POST['unit_id']) && count($_POST['unit_id'])>0){
          $_SESSION['gaji_blu']['unit_id'] = $_POST['unit_id'];
        }else{
          echo $this->cantik_model->msgGagal('Maaf, pilih salah satu unit yang akan diproses.'); exit;
        }
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['gaji_blu']['status'] = $_POST['status'];
          unset($_POST['status']); // langsung unset setelah menjadi $_SESSION;
        }else{
          if(isset($_SESSION['gaji_blu']['status'])){
            unset($_SESSION['gaji_blu']['status']);
          }
        }
				echo "1"; exit;
			}
			if(isset($_POST['act']) && $_POST['act']=='gajiblu_proses2'){
				if($_SESSION['gaji_blu']['status_kepeg'][0]!=2){
		      echo $this->cantik_model->msgGagal("Maaf, kamu terlalu cantik! (*_-)"); exit;
        }
        $vSQL = " AND status_kepeg = ".intval($_SESSION['gaji_blu']['status_kepeg'][0]);
				if(isset($_SESSION['gaji_blu']['unit_id']) && is_array($_SESSION['gaji_blu']['unit_id']) && count($_SESSION['gaji_blu']['unit_id'])>1){
					$vSQL.= " AND ( `unit_id` = ".implode(" OR unit_id = ", $_SESSION['gaji_blu']['unit_id']).")";
				}elseif(isset($_SESSION['gaji_blu']['unit_id']) && is_array($_SESSION['gaji_blu']['unit_id']) && count($_SESSION['gaji_blu']['unit_id'])==1){
					$vSQL.= " AND `unit_id` = ".$_SESSION['gaji_blu']['unit_id'][0];
				}
				if(isset($_SESSION['gaji_blu']['status']) && is_array($_SESSION['gaji_blu']['status']) && count($_SESSION['gaji_blu']['status'])>1){
					$vSQL.= " AND ( `status` = ".implode(" OR status = ", $_SESSION['gaji_blu']['status']).")";
				}elseif(isset($_SESSION['gaji_blu']['status']) && is_array($_SESSION['gaji_blu']['status']) && count($_SESSION['gaji_blu']['status'])==1){
					$vSQL.= " AND `status` = ".$_SESSION['gaji_blu']['status'][0];
				}
        $sql = "SELECT a.`nip`, a.`unit_id`, a.`status_kepeg`, a.`jnspeg`, a.`ijazah_id`, a.`golongan_id`, b.`kelompok`, a.`npwp`, c.bobot, a.status, a.mkth FROM `kepeg_tb_pegawai` a LEFT JOIN `kepeg_tb_golongan` b ON a.`golongan_id` = b.`id` LEFT JOIN kepeg_tb_jabatan c ON a.jabatan_id = c.id WHERE a.`jnspeg` = ".intval($_SESSION['gaji_blu']['jnspeg']).$vSQL;
				$q = $this->db->query($sql);
				$row = $q->num_rows(); 
        if($row > 0){
					if($this->cantik_model->insert_do_gaji_blu($q->result())){
						echo "1";
					}else{
						echo $this->cantik_model->msgGagal("Tidak dapat memproses gaji tenaga tendik non pns (blu)");
					}
        }else{
        	echo $this->cantik_model->msgGagal("Tidak dapat memproses gaji tenaga tendik non pns (blu)");
        }
				exit;
			}
			if(isset($_POST['act']) && $_POST['act']=='gajiblu_lihat'){
				$_SESSION['gaji_blu']['bulan'] = $_POST['bulan'];
        if(isset($_POST['unit_id'])){
          $_SESSION['gaji_blu']['unit_id'] = $_POST['unit_id'];
        }else{
          echo $this->cantik_model->msgGagal('Maaf, pilih salah satu unit yang akan diproses.'); exit;
        }
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['gaji_blu']['status'] = $_POST['status'];
          unset($_POST['status']); // langsung unset setelah menjadi $_SESSION;
        }else{
          if(isset($_SESSION['gaji_blu']['status'])){
            unset($_SESSION['gaji_blu']['status']);
          }
        }
				echo "1"; exit;
			}
			if(isset($_POST['act']) && $_POST['act']=='gajiblu_hapus_single'){
				if(isset($_POST['id'])){
          $sql = "DELETE FROM `kepeg_tr_dgaji` WHERE `id` = ".intval($_POST['id']);
					$this->db->query($sql);
          echo 1; exit;
        }
        echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
			}
			if(isset($_POST['act']) && $_POST['act']=='ikw_simpan_pot'){
				//print_r($_POST); exit;
				if(isset($_POST['id'])){
					$i=0;
					foreach ($_POST['id'] as $k => $v){
						if(intval($_POST['pot_lainnya'][$i])>0 && intval($_POST['byr_stlh_pajak'][$i])>0 && intval($_POST['pot_lainnya'][$i])!=intval($_POST['pot_lainnya_old'][$i])){
							$_POST['pot_lainnya'][$i] = str_replace(".","",$_POST['pot_lainnya'][$i]);
							$netto = intval($_POST['byr_stlh_pajak'][$i]) - intval($_POST['pot_lainnya'][$i]);
							$vSQL="UPDATE kepeg_tr_ikw SET pot_lainnya = '".intval($_POST['pot_lainnya'][$i])."', netto = '".$netto."' WHERE id_trans = ".intval($v);
							//echo $vSQL."<br/>";
							$this->db->query($vSQL);
						}
						$i++;
					}
					echo "1"; exit;
				}
				echo $this->cantik_model->msgGagal('Tidak ada data yang dapat diubah.'); exit;
			}
			
			if(isset($_POST['act']) && $_POST['act']=='ikw_simpan_pot_ikw'){
				//print_r($_POST); exit;
				if(isset($_POST['id'])){
					$i=0;
					foreach ($_POST['id'] as $k => $v){
						if(floatval($_POST['capaian_smt_sblm'][$i])!=floatval($_POST['capaian_smt_sblm_old'][$i]) || floatval($_POST['kinerja_wajib'][$i])!=floatval($_POST['kinerja_wajib_old'][$i])){
							$_POST['capaian_smt_sblm'][$i] = str_replace(",",".",$_POST['capaian_smt_sblm'][$i]);
							$_POST['kinerja_wajib'][$i] = str_replace(",",".",$_POST['kinerja_wajib'][$i]);
							$kinerja_tdk_tercapai = floatval($_POST['kinerja_wajib'][$i]) - floatval($_POST['capaian_smt_sblm'][$i]);
							$pot_ikw = ceil( intval($_POST['ikw'][$i]) * ($kinerja_tdk_tercapai/floatval($_POST['kinerja_wajib'][$i])) );
							$bruto = intval($_POST['ikw'][$i]) - $pot_ikw;
							$jml_pajak = ceil($bruto * floatval($_POST['pajak'][$i]));
							$byr_stlh_pajak = $bruto - $jml_pajak;
							$netto = $byr_stlh_pajak - intval($_POST['pot_lainnya'][$i]);
							$vSQL="UPDATE kepeg_tr_ikw SET capaian_smt_sblm = '".floatval($_POST['capaian_smt_sblm'][$i])."', kinerja_wajib = '".floatval($_POST['kinerja_wajib'][$i])."', kinerja_tdk_tercapai = '".$kinerja_tdk_tercapai."', pot_ikw = '".$pot_ikw."', bruto = '".$bruto."', jml_pajak = '".$jml_pajak."', byr_stlh_pajak = '".$byr_stlh_pajak."', netto = '".$netto."' WHERE id_trans = ".intval($v);
							//echo $vSQL."<br/>";
							$this->db->query($vSQL);
						}
						$i++;
					}
					echo "1"; exit;
				}
				echo $this->cantik_model->msgGagal('Tidak ada data yang dapat diubah.'); exit;
			}
			
			
		} // end post
	} // end function
	
	public function daftar()
	{
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['unitList'] = $this->cantik_model->getUnitList($_SESSION['gaji_blu']['unit_id']);
		$subdata['daftar_unit'] = $this->cantik_model->get_unit_gaji_blu();
		$subdata['daftar_status'] = $this->cantik_model->get_status_gaji_blu();
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption($_SESSION['gaji_blu']['bulan']);
		$subdata['dt'] = $this->cantik_model->get_data_gaji_blu();
		$data['main_content']	= $this->load->view('modul_gaji/gaji_blu_daftar',$subdata,TRUE);
		$list["menu"]           = $this->menu_model->show();
		$list["submenu"]        = $this->menu_model->show();
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('main_template',$data);
	}
	
	public function daftar_cetak()
	{
		$subdata['status_kepeg'] = array();
		if(isset($_SESSION['ikw']['status_kepeg'])){
			$subdata['status_kepeg'] = $_SESSION['ikw']['status_kepeg'];
		}
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['daftar_unit'] = $this->cantik_model->get_unit_ikw();
		$subdata['daftar_status'] = $this->cantik_model->get_status_ikw();
		$subdata['dt'] = $this->cantik_model->get_data_ikw();
		$subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
		$subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$data['main_content']	= $this->load->view('modul_gaji/ikw_daftar_cetak',$subdata,TRUE);
		$list["menu"]           = $this->menu_model->show();
		$list["submenu"]        = $this->menu_model->show();
		//$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('cetak_template_excel',$data);
		//$this->load->view('cetak_template',$data);
	}
	
	public function daftar2_cetak()
	{
		$subdata['status_kepeg'] = array();
		if(isset($_SESSION['ikw']['status_kepeg'])){
			$subdata['status_kepeg'] = $_SESSION['ikw']['status_kepeg'];
		}
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['daftar_unit'] = $this->cantik_model->get_unit_ikw();
		$subdata['daftar_status'] = $this->cantik_model->get_status_ikw();
		$subdata['dt'] = $this->cantik_model->get_data_ikw();
		$subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
		$subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$data['main_content']	= $this->load->view('modul_gaji/ikw_daftar2_cetak',$subdata,TRUE);
		$list["menu"]           = $this->menu_model->show();
		$list["submenu"]        = $this->menu_model->show();
		//$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('cetak_template_excel',$data);
		//$this->load->view('cetak_template',$data);
	}
	
	public function daftar_pot()
	{
		$subdata['status_kepeg'] = array();
		if(isset($_SESSION['ikw']['status_kepeg'])){
			$subdata['status_kepeg'] = $_SESSION['ikw']['status_kepeg'];
		}
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['unitList'] = $this->cantik_model->getUnitList($_SESSION['ikw']['unit_id']);
		$subdata['statusKepegOption'] = $this->cantik_model->getStatusKepegFullCheckbox($subdata['status_kepeg']);
		$subdata['daftar_unit'] = $this->cantik_model->get_unit_ikw();
		$subdata['daftar_status'] = $this->cantik_model->get_status_ikw();
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption($_SESSION['ikw']['bulan']);
		$unit = $this->check_session->get_unit();
		$subdata['dt'] = $this->cantik_model->get_data_ikw();
		$data['main_content']	= $this->load->view('modul_gaji/ikw_daftar2',$subdata,TRUE);
		$list["menu"]           = $this->menu_model->show();
		$list["submenu"]        = $this->menu_model->show();
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('main_template',$data);
	}

}