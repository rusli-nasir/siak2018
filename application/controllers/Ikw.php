<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ikw extends CI_Controller {

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

			// otomatis set status
			if(!isset($_SESSION['ikw']['status'])){
				$_SESSION['ikw']['status'] = array(1,3,6,12);
			}

			// otomatis set tahun
			if(!isset($_SESSION['ikw']['tahun'])){
				$_SESSION['ikw']['tahun'] = $this->cur_tahun;
			}

			// otomatis set seluruh unit
			if(!isset($_SESSION['ikw']['unit_id'])){
				if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42'){
					$_SESSION['ikw']['unit_id'] = $this->cantik_model->getUnitChecked();
				}else{
					$_SESSION['ikw']['unit_id'] = $this->cantik_model->get_unit_rba($this->check_session->get_unit());
				}
			}

		}
  }


	public function index()
	{
    $subdata['status_kepeg'] = array();
		if(isset($_SESSION['ikw']['status_kepeg'])){
			$subdata['status_kepeg'] = $_SESSION['ikw']['status_kepeg'];
		}
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['unitList'] = $this->cantik_model->getUnitList($_SESSION['ikw']['unit_id']);
		$subdata['statusKepegOption'] = $this->cantik_model->getStatusKepegFullCheckbox($subdata['status_kepeg']);
		$unit = $this->check_session->get_unit();
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption(date('m'));
		$data['main_content']	= $this->load->view('modul_gaji/ikw',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('main_template',$data);
	}

	public function showDialogProsesIKW(){
		if(!isset($_SESSION['ikw'])){
			echo $this->cantik_model->msgGagal('Pilih kriteria proses IKW sebelum melakukan proses'); exit;
		}
		$unit = "seluruh unit Universitas Diponegoro";
		$sql = "SELECT id FROM kepeg_tb_pegawai WHERE jnspeg = ".intval($_SESSION['ikw']['jnspeg']);
		if(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])>1){
			$sql.= " AND ( `status_kepeg` = ".implode(" OR status_kepeg = ", $_SESSION['ikw']['status_kepeg']).")";
		}elseif(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])==1){
			$sql.= " AND `status_kepeg` = ".$_SESSION['ikw']['status_kepeg'][0];
		}
		if(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])>1){
			$sql.= " AND ( `unit_id` = ".implode(" OR unit_id = ", $_SESSION['ikw']['unit_id']).")";
		}elseif(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])==1){
			$sql.= " AND `unit_id` = ".$_SESSION['ikw']['unit_id'][0];
		}
		if(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])>1){
			$sql.= " AND ( `status` = ".implode(" OR status = ", $_SESSION['ikw']['status']).")";
		}elseif(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])==1){
			$sql.= " AND `status` = ".$_SESSION['ikw']['status'][0];
		}
		// echo $sql; exit;
		$row = $this->db->query($sql)->num_rows();
		$aksi = "";
		$html = "";
		$html .= "<div class=\"alert small\">
			<h4 class=\"page-header\"><i class=\"fa fa-bullhorn\"></i>&nbsp;&nbsp;Informasi Proses Data Insentif Kinerja Wajib</h4>
			<p>Jumlah Pegawai yang akan di-proses adalah <strong>".$row."</strong> orang.</p>";
		$html.="<p>Unit yang diproses : <strong>".$this->cantik_model->get_unit_ikw()."</strong></p>";
		$html.="<p>Status Kepegawaian yang diproses : <strong>".$this->cantik_model->get_status_ikw()."</strong></p>";
		$html.="<p>Status Personel yang diproses : <strong>".$this->cantik_model->get_status_kerja_ikw()."</strong></p>";
		if($row > 0){
			$aksi = "<button type=\"button\" class=\"btn btn-primary btn-sm\" id=\"proses_2\"><i class=\"fa fa-spinner\"></i>&nbsp;&nbsp;&nbsp;Proses Daftar Insentif Kinerja Wajib</button>";
			$html.="<p>Klik ".$aksi." untuk melakukan proses pembuatan daftar Insentif Kinerja Wajib pada tahun <strong>".$_SESSION['ikw']['tahun']."</strong> untuk Pembayaran Bulan <strong>".$this->cantik_model->wordMonth($_SESSION['ikw']['bulan'])."</strong>.</p><p class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Perhatian: <strong>Data yang sudah dibuat, akan dilewati.</strong></p>";
		}else{
			$html.="<p class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Tidak dapat melakukan proses pembuatan daftar  IKW karena jumlah pegawai tidak ada.</p>";
		}
		$html.="</div>";
		echo $html;
		exit;
	}

	public function ikw_proses(){
		if(isset($_POST)){
			if(isset($_POST['act']) && $_POST['act']=='ikw_proses'){
				$_SESSION['ikw']['bulan'] = $_POST['bulan'];
        if(isset($_POST['unit_id'])){
          $_SESSION['ikw']['unit_id'] = $_POST['unit_id'];
        }else{
          /*if(isset($_SESSION['ikw']['unit_id']) && substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42'){
            $_SESSION['ikw']['unit_id'] = $this->cantik_model->getUnitCheckedAll(); // select all unit
          }*/
					echo $this->cantik_model->msgGagal('Maaf, pilih salah satu unit yang akan diproses.'); exit;
        }
        if(isset($_POST['status_kepeg'])){
          $_SESSION['ikw']['status_kepeg'] = $_POST['status_kepeg'];
        }else{
					echo $this->cantik_model->msgGagal('Pilih salah satu/lebih status pegawai yang akan dibuat.'); exit;
				}
        if(isset($_POST['jnspeg'])){
          $_SESSION['ikw']['jnspeg'] = $_POST['jnspeg'];
        }
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['ikw']['status'] = $_POST['status'];
          unset($_POST['status']); // langsung unset setelah menjadi $_SESSION;
        }else{
          if(isset($_SESSION['ikw']['status'])){
            unset($_SESSION['ikw']['status']);
          }
        }
				echo "1"; exit;
			}
			if(isset($_POST['act']) && $_POST['act']=='ikw_proses2'){
				if(in_array('4',$_SESSION['ikw']['status_kepeg'])){ // jika merupakan Tenaga KONTRAK
		      echo $this->cantik_model->msgGagal("Maaf, kamu terlalu cantik! (*_-)"); exit;
        }
        $vSQL = "";
				if(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])>1){
					$vSQL.= " AND ( `status_kepeg` = ".implode(" OR status_kepeg = ", $_SESSION['ikw']['status_kepeg']).")";
				}elseif(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])==1){
					$vSQL.= " AND `status_kepeg` = ".$_SESSION['ikw']['status_kepeg'][0];
				}
				if(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])>1){
					$vSQL.= " AND ( `unit_id` = ".implode(" OR unit_id = ", $_SESSION['ikw']['unit_id']).")";
				}elseif(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])==1){
					$vSQL.= " AND `unit_id` = ".$_SESSION['ikw']['unit_id'][0];
				}
				if(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])>1){
					$vSQL.= " AND ( `status` = ".implode(" OR status = ", $_SESSION['ikw']['status']).")";
				}elseif(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])==1){
					$vSQL.= " AND `status` = ".$_SESSION['ikw']['status'][0];
				}
        $sql = "SELECT a.`nip`, a.`unit_id`, a.`status_kepeg`, a.`jnspeg`, a.`golongan_id`, b.`kelompok`, a.`npwp`, c.bobot, a.status FROM `kepeg_tb_pegawai` a LEFT JOIN `kepeg_tb_golongan` b ON a.`golongan_id` = b.`id` LEFT JOIN kepeg_tb_jabatan c ON a.jabatan_id = c.id WHERE a.`jnspeg` = ".intval($_SESSION['ikw']['jnspeg']).$vSQL;
				// echo $sql; exit;
				$row = $this->db->query($sql)->num_rows();
        if($row > 0){
					$sql_e_ = array();
          $r = $this->db->query($sql)->result();
					foreach ($r as $k => $v) {
            $sql_e = "SELECT `id_trans` FROM kepeg_tr_ikw WHERE `nip` LIKE '".$v->nip."' AND `tahun` LIKE '".intval($_SESSION['ikw']['tahun'])."' AND `bulan` LIKE '".intval($_SESSION['ikw']['bulan'])."'";
            // echo $sql_e."<br/>";
				    $row = $this->db->query($sql_e)->num_rows();
            if($row==0){
              if(intval($v->kelompok)==4){
                $_pajak = 0.15;
              }elseif(intval($v->kelompok)==3){
                $_pajak = 0.05;
              }else{
								if($v->status_kepeg==2){
				          if(strlen(trim($v->npwp))<10){
				            $_pajak = 0.06;
				          }else{
				            $_pajak = 0.05;
				          }
								}else{
									$_pajak = 0;
								}
              }
              $_kelompok = $v->kelompok;
              $_bobot = $v->bobot;
              if(intval($v->status) == 13){
              	$_bobot = 5;
              }
							$ikw = 0;
							if($v->unit_id == 27){ // bila merupakan RSND
								$ikw = $this->cantik_model->getIKWRSND($_kelompok, $_bobot);
							}else{
								$ikw = $this->cantik_model->getIKWBruto($_kelompok, $_bobot);
								if($v->status_kepeg==2 && $v->kelompok == 2){
									$ikw = round($ikw * (1 / (1-$_pajak)));
								}
							}
							if($v->status == 12){
								$ikw = $ikw*$this->pot_tugasbelajar;
							}
              $_jml_pajak = round($_pajak * $ikw);
              $_byr_stlh_pajak = $ikw - $_jml_pajak;
							$_netto = $_byr_stlh_pajak;
							$sql_e_[] = "('".$_SESSION['ikw']['tahun']."', '".$_SESSION['ikw']['bulan']."', '".$v->nip."', '".$v->unit_id."', '".$v->status_kepeg."', '".$v->jnspeg."', '".$ikw."', '".$ikw."', '".$_pajak."', '".$_jml_pajak."', '".$_byr_stlh_pajak."', '".$_netto."')";
							// echo "('".$_SESSION['ikw']['tahun']."', '".$_SESSION['ikw']['bulan']."', '".$v->nip."', '".$v->unit_id."', '".$v->status_kepeg."', '".$v->jnspeg."', '".$ikw."', '".$ikw."', '".$_pajak."', '".$_jml_pajak."', '".$_byr_stlh_pajak."', '".$_netto."')<br />";
            }
          }
					//exit;
					if(count($sql_e_)>0){
						$sql_e = "INSERT INTO `kepeg_tr_ikw`(tahun, bulan, nip, unitid, statuspeg, jenispeg, ikw, bruto, pajak, jml_pajak, byr_stlh_pajak, netto) VALUES ".implode(", ",$sql_e_)."";
						// echo $sql_e."<br />";
						// echo $sql_e; exit;
						$this->db->query($sql_e);
					}
          echo 1;
        } // end if row
				exit;
			}
			if(isset($_POST['act']) && $_POST['act']=='ikw_lihat'){
				$_SESSION['ikw']['bulan'] = $_POST['bulan'];
        if(isset($_POST['unit_id'])){
          $_SESSION['ikw']['unit_id'] = $_POST['unit_id'];
        }else{
          /*if(isset($_SESSION['ikw']['unit_id']) && substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42'){
            $_SESSION['ikw']['unit_id'] = $this->cantik_model->getUnitCheckedAll(); // select all unit
          }*/
					echo $this->cantik_model->msgGagal('Maaf, pilih salah satu unit yang akan diproses.'); exit;
        }
        if(isset($_POST['status_kepeg'])){
          $_SESSION['ikw']['status_kepeg'] = $_POST['status_kepeg'];
        }else{
					echo $this->cantik_model->msgGagal('Pilih salah satu/lebih status pegawai yang akan dibuat.'); exit;
				}
        if(isset($_POST['jnspeg'])){
          $_SESSION['ikw']['jnspeg'] = $_POST['jnspeg'];
        }
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['ikw']['status'] = $_POST['status'];
          unset($_POST['status']); // langsung unset setelah menjadi $_SESSION;
        }else{
          if(isset($_SESSION['ikw']['status'])){
            unset($_SESSION['ikw']['status']);
          }
        }
				echo "1"; exit;
			}
			if(isset($_POST['act']) && $_POST['act']=='ikw_hapus_single'){
				if(isset($_POST['id'])){
          $sql = "DELETE FROM `kepeg_tr_ikw` WHERE `id_trans` = ".intval($_POST['id']);
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
							// echo $vSQL."<br/>";
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
							$pot_ikw = round( intval($_POST['ikw'][$i]) * ($kinerja_tdk_tercapai/floatval($_POST['kinerja_wajib'][$i])) );
							$bruto = intval($_POST['ikw'][$i]) - $pot_ikw;
							$jml_pajak = round($bruto * floatval($_POST['pajak'][$i]));
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
		$data['main_content']	= $this->load->view('modul_gaji/ikw_daftar',$subdata,TRUE);
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
