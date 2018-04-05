<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ipp extends CI_Controller {

	private $cur_tahun = '' ;
	private $nominal_ipp = 5000000;
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

			// otomatis set status
			if(!isset($_SESSION['ipp']['status'])){
				$_SESSION['ipp']['status'] = array(1,3,6,12,13,14);
			}

			// otomatis set tahun
			// if(!isset($_SESSION['ipp']['tahun'])){
			// 	$_SESSION['ipp']['tahun'] = $this->cur_tahun;
			// }

			// otomatis set seluruh unit
			// if(!isset($_SESSION['ipp']['unit_id'])){
			// 	if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42'){
			// 		$_SESSION['ipp']['unit_id'] = $this->cantik_model->getUnitChecked();
			// 	}else{
			// 		$_SESSION['ipp']['unit_id'] = $this->cantik_model->get_unit_rba($this->check_session->get_unit());
			// 	}
			// }

		}
  }


	// public function index()
	// {
	// 	$subdata['cur_tahun'] = $this->cur_tahun;
 //    $unit = $this->check_session->get_unit();
	// 	$data['main_content']	= $this->load->view('kepegawaian/ipp/modul',$subdata,TRUE);
 //    $list["menu"]           = $this->menu_model->show();
 //    $list["submenu"]        = $this->menu_model->show();
 //    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
 //    $data['message']	= validation_errors();
 //    $this->load->view('main_template',$data);
	// }

	public function index()
	{
		$subdata['status_kepeg'] = array();
		if(isset($_SESSION['ipp']['status_kepeg'])){
			$subdata['status_kepeg'] = $_SESSION['ipp']['status_kepeg'];
		}
		$subdata['cur_tahun'] = $this->cur_tahun;
		$unit = "";
		if(isset($_SESSION['ipp']['unit_id'])){
			$unit = $_SESSION['ipp']['unit_id'];
		}
		$subdata['unitList'] = $this->cantik2_model->getUnitList($unit);
		$subdata['statusKepegOption'] = $this->cantik_model->getStatusKepegFullCheckbox($subdata['status_kepeg']);
		$unit = $this->check_session->get_unit();
		$data['main_content']	= $this->load->view('kepegawaian/ipp/ipp',$subdata,TRUE);
		$list["menu"]           = $this->menu_model->show();
		$list["submenu"]        = $this->menu_model->show();
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('main_template',$data);
	}

	public function showDialogProsesIPP(){
		if(!isset($_SESSION['ipp'])){
			echo $this->cantik_model->msgGagal('Pilih kriteria proses IPP sebelum melakukan proses'); exit;
		}
		$unit = "seluruh unit Universitas Diponegoro";
		$row = $this->cantik2_model->get_total_row('ipp');
		$aksi = "";
		$html = "";
		$html .= "<div class=\"alert\">
			<h4 class=\"page-header\"><i class=\"fa fa-bullhorn\"></i>&nbsp;&nbsp;Informasi Proses Data Insentif Perbaikan Penghasilan</h4>
			<p>Jumlah Pegawai yang akan di-proses adalah <strong>".$row."</strong> orang.</p>";
		if($row > 0){
			$aksi = "<button type=\"button\" class=\"btn btn-primary btn-sm\" id=\"proses_2\"><i class=\"fa fa-spinner\"></i>&nbsp;&nbsp;&nbsp;Proses Daftar Insentif Perbaikan Penghasilan</button>";
			$html.="<p>Klik ".$aksi." untuk melakukan proses pembuatan daftar Insentif Perbaikan Penghasilan pada tahun <strong>".$_SESSION['ipp']['tahun']."</strong> untuk Pembayaran Semester <strong>".$this->cantik_model->getSemester($_SESSION['ipp']['semester'])."</strong>.</p><p class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Perhatian: <strong>Data yang sudah dibuat, akan dilewati.</strong></p>";
		}else{
			$html.="<p class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Tidak dapat melakukan proses pembuatan daftar  IPP karena jumlah pegawai tidak ada.</p>";
		}
		$html.="</div>";
		echo $html;
		exit;
	}

	public function ipp_proses(){
		$debug = 1;
		if(isset($_POST)){
		if($_POST['act']=='ipp_proses'){
      	$_SESSION['ipp']['semester'] = $_POST['semester'];
      	$_SESSION['ipp']['tahun'] = $_POST['tahun'];
        if(isset($_POST['unit_id'])){
          $_SESSION['ipp']['unit_id'] = $_POST['unit_id'];
        }else{
          /*if(isset($_SESSION['ipp']['unit_id']) && substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42'){
            $_SESSION['ipp']['unit_id'] = $this->cantik_model->getUnitCheckedAll(); // select all unit
          }*/
					echo $this->cantik_model->msgGagal('Maaf, pilih salah satu unit yang akan diproses.'); exit;
        }
        if(isset($_POST['status_kepeg'])){
          $_SESSION['ipp']['status_kepeg'] = $_POST['status_kepeg'];
        }else{
					echo $this->cantik_model->msgGagal('Pilih salah satu/lebih status pegawai yang akan dibuat.'); exit;
				}
        if(isset($_POST['jnspeg'])){
          $_SESSION['ipp']['jnspeg'] = $_POST['jnspeg'];
        }
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['ipp']['status'] = $_POST['status'];
          unset($_POST['status']); // langsung unset setelah menjadi $_SESSION;
        }else{
          if(isset($_SESSION['ipp']['status'])){
            unset($_SESSION['ipp']['status']);
          }
        }
				echo "1"; exit;
			} // end if ipp_proses

			if($_POST['act']=='ipp_proses2'){
        if(in_array('4',$_SESSION['ipp']['status_kepeg'])){ // jika merupakan Tenaga KONTRAK
		      echo $this->cantik_model->msgGagal("Maaf, kamu cantik! (*_-)"); exit;
        }
        $vSQL = "";
				if(isset($_SESSION['ipp']['status_kepeg']) && is_array($_SESSION['ipp']['status_kepeg']) && count($_SESSION['ipp']['status_kepeg'])>1){
					$vSQL.= " AND ( `status_kepeg` = ".implode(" OR status_kepeg = ", $_SESSION['ipp']['status_kepeg']).")";
				}elseif(isset($_SESSION['ipp']['status_kepeg']) && is_array($_SESSION['ipp']['status_kepeg']) && count($_SESSION['ipp']['status_kepeg'])==1){
					$vSQL.= " AND `status_kepeg` = ".$_SESSION['ipp']['status_kepeg'][0];
				}
				if(isset($_SESSION['ipp']['unit_id']) && is_array($_SESSION['ipp']['unit_id']) && count($_SESSION['ipp']['unit_id'])>1){
					$vSQL.= " AND ( `unit_id` = ".implode(" OR unit_id = ", $_SESSION['ipp']['unit_id']).")";
				}elseif(isset($_SESSION['ipp']['unit_id']) && is_array($_SESSION['ipp']['unit_id']) && count($_SESSION['ipp']['unit_id'])==1){
					$vSQL.= " AND `unit_id` = ".$_SESSION['ipp']['unit_id'][0];
				}
				if(isset($_SESSION['ipp']['status']) && is_array($_SESSION['ipp']['status']) && count($_SESSION['ipp']['status'])>1){
					$vSQL.= " AND ( `status` = ".implode(" OR status = ", $_SESSION['ipp']['status']).")";
				}elseif(isset($_SESSION['ipp']['status']) && is_array($_SESSION['ipp']['status']) && count($_SESSION['ipp']['status'])==1){
					$vSQL.= " AND `status` = ".$_SESSION['ipp']['status'][0];
				}
        $sql = "SELECT a.id, a.`nip`, CONCAT(a.`glr_dpn`,' ',a.`nama`,' ',a.`glr_blkg`) AS nama,  a.`unit_id`, c.`unit_short`, a.`status_kepeg`, a.`jnspeg`, a.`golongan_id`, b.gol, b.`kelompok`, a.`npwp`, a.`status` FROM `tb_pegawai` a LEFT JOIN `tb_golongan` b ON a.`golongan_id` = b.`id` LEFT JOIN tb_unit c ON a.`unit_id` = c.`id` WHERE a.`jnspeg` = ".intval($_SESSION['ipp']['jnspeg']).$vSQL;
				// echo $sql; exit;
				$row = $this->eduk->query($sql)->num_rows(); //echo $row; exit;
        if($row > 0){
					$sql_e_ = array();
          $r = $this->eduk->query($sql)->result();
					foreach ($r as $k => $v) {
            $sql_e = "SELECT `id_trans` FROM kepeg_tr_ipp WHERE `pegid` LIKE '".$v->id."' AND `tahun` LIKE '".$_SESSION['ipp']['tahun']."' AND `semester` LIKE '".$_SESSION['ipp']['semester']."' AND fk_rsa_unit = '".$_SESSION['rsa_kode_unit_subunit']."'";
				    $row = $this->db->query($sql_e)->num_rows();
            if($row==0){
              if(intval($v->kelompok)==4){
                $_pajak = 0.15;
              }elseif(intval($v->kelompok)==3){
                $_pajak = 0.05;
                if($v->status_kepeg==2){
                  if(strlen(trim($v->npwp))<1){
                    $_pajak = 0.06;
                  }else{
                    $_pajak = 0.05;
                  }
								}
              }else{
								if($v->status_kepeg==2){
                  if(strlen(trim($v->npwp))<1){
                    $_pajak = 0.06;
                  }else{
                    $_pajak = 0.05;
                  }
								}else{
									$_pajak = 0;
								}
              }
              $_potongan = ceil($_pajak * $this->nominal_ipp);
              $_netto = $this->nominal_ipp - $_potongan;
              $bank = $this->cantik2_model->getDataRekening($v->id,2);
							if(is_null($bank)){
								$bank['kelompok_bank'] = '';
								$bank['nmpemilik'] = '';
								$bank['norekening'] = '';
							}
							$sql_e_[] = "('".$_SESSION['ipp']['tahun']."', '".$_SESSION['ipp']['semester']."', '".$v->id."', '".$v->nip."', '".$this->cantik_model->encodeText(addslashes($v->nama))."', '".$v->golongan_id."', '".$v->gol."', '".$this->cantik_model->encodeText(addslashes($v->npwp))."', '".$v->unit_id."', '".$v->unit_short."', '".$v->status_kepeg."', '".$v->jnspeg."', '".$bank['kelompok_bank']."', '".$this->cantik_model->encodeText(addslashes($bank['nmpemilik']))."', '".$this->cantik_model->encodeText(addslashes($bank['norekening']))."', '".$this->nominal_ipp."', '".$_pajak."', '".$_potongan."', '".$_netto."', '".$_SESSION['rsa_kode_unit_subunit']."', '".$v->status."')";
							// echo "<p class=\"small\">('".$_SESSION['ipp']['tahun']."', '".$_SESSION['ipp']['semester']."', '".$v->id."', '".$v->nip."', '".$this->cantik_model->encodeText(addslashes($v->nama))."', '".$v->golongan_id."', '".$v->gol."', '".$this->cantik_model->encodeText(addslashes($v->npwp))."', '".$v->unit_id."', '".$v->unit_short."', '".$v->status_kepeg."', '".$v->jnspeg."', '".$bank['kelompok_bank']."', '".$this->cantik_model->encodeText(addslashes($bank['nmpemilik']))."', '".$this->cantik_model->encodeText(addslashes($bank['norekening']))."', '".$this->nominal_ipp."', '".$_pajak."', '".$_potongan."', '".$_netto."', '".$_SESSION['rsa_kode_unit_subunit']."')</p>";
            }
          }
					// exit;
					if(count($sql_e_)>0){
						$sql_e = "INSERT INTO `kepeg_tr_ipp` (`tahun`, `semester`, `pegid`, `nip`, `nama`, `golongan_id`, `golpeg`, `npwp`, `unitid`, `nama_unit_short`, `statuspeg`, `jenispeg`, `nmbank`, `nmpemilik`, `norekening`, `ipp`, `pajak`, `potongan`, `netto`, `fk_rsa_unit`, `status`) VALUES".implode(", ",$sql_e_)."";
						$this->db->query($sql_e);
					}
          echo 1;
        } // end if row
				exit;
			} // end if ipp_proses2

			if($_POST['act']=='ipp_reset'){
				unset($_SESSION['ipp']); // hapus session IPP
				echo 1;
				exit;
			} // end if ipp_reset

			if($_POST['act']=='ipp_hapus_single'){
				if(isset($_POST['id']) && $this->cantik_model->isExist(intval($_POST['id']),'kepeg_tr_ipp','id_trans')){
          $sql = "DELETE FROM `kepeg_tr_ipp` WHERE `id_trans` = ".$_POST['id'];
					$this->db->query($sql);
          echo 1; exit;
        }
        echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
			} // end if ipp_hapus_single

			if($_POST['act']=='ipp_hapus_daftar'){
				echo $this->cantik2_model->hapusDataIPP(); exit;      
			} // end if ipp_hapus_single

			if($_POST['act']=='ipp_lihat'){
        $_SESSION['ipp']['semester'] = $_POST['semester'];
        $_SESSION['ipp']['tahun'] = $_POST['tahun'];
        if(isset($_POST['unit_id'])){
          $_SESSION['ipp']['unit_id'] = $_POST['unit_id'];
        }else{
          /*if(isset($_SESSION['ipp']['unit_id']) && substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42'){
            $_SESSION['ipp']['unit_id'] = $this->cantik_model->getUnitCheckedAll(); // select all unit
          }*/
					echo $this->cantik_model->msgGagal('Maaf, pilih salah satu unit yang akan diproses.'); exit;
        }
        if(isset($_POST['status_kepeg'])){
          $_SESSION['ipp']['status_kepeg'] = $_POST['status_kepeg'];
        }else{
					echo $this->cantik_model->msgGagal('Pilih salah satu/lebih status pegawai yang akan dibuat.'); exit;
				}
        if(isset($_POST['jnspeg'])){
          $_SESSION['ipp']['jnspeg'] = $_POST['jnspeg'];
        }
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['ipp']['status'] = $_POST['status'];
          unset($_POST['status']); // langsung unset setelah menjadi $_SESSION;
        }else{
          if(isset($_SESSION['ipp']['status'])){
            unset($_SESSION['ipp']['status']);
          }
        }
				// $_SESSION['ipp']['tahun'] = $_POST['tahun'];
				echo "1"; exit;
			} // end if ipp_proses

			if($_POST['act']=='ipp_reset'){
				unset($_SESSION['ipp']); // hapus session IPP
				echo 1;
				exit;
			} // end if ipp_reset

		} // if act == POST
	} // end function ipp_proses

	public function ipp_daftar()
	{
		$subdata['status_kepeg'] = array();
		if(isset($_SESSION['ipp']['status_kepeg'])){
			$subdata['status_kepeg'] = $_SESSION['ipp']['status_kepeg'];
		}
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['unitList'] = $this->cantik2_model->getUnitList($_SESSION['ipp']['unit_id']);
		$subdata['statusKepegOption'] = $this->cantik_model->getStatusKepegFullCheckbox($subdata['status_kepeg']);
		$subdata['daftar_unit'] = $this->cantik2_model->get_unit('ipp');
		$subdata['daftar_status'] = $this->cantik2_model->get_status('ipp');
		$unit = $this->check_session->get_unit();
		$data['main_content']	= $this->load->view('kepegawaian/ipp/ipp_daftar',$subdata,TRUE);
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('main_template',$data);
	}

	public function daftar_cetak()
	{
		$subdata['status_kepeg'] = array();
		if(isset($_SESSION['ipp']['status_kepeg'])){
			$subdata['status_kepeg'] = $_SESSION['ipp']['status_kepeg'];
		}
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['unitList'] = $this->cantik2_model->getUnitList($_SESSION['ipp']['unit_id']);
		$subdata['daftar_unit'] = $this->cantik2_model->get_unit('ipp');
		$subdata['daftar_status'] = $this->cantik2_model->get_status('ipp');
		$subdata['dt'] = $this->cantik2_model->getDataIPP();
		$subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
		$subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$unit = $this->check_session->get_unit();
		$subdata['filename'] = date('Ymd')."_ipp_".strtolower(str_replace(' ','-',$this->cantik_model->getJenisPeg($_SESSION['ipp']['jnspeg']))).".xls";
		$data['main_content']	= $this->load->view('kepegawaian/ipp/ipp_daftar_cetak',$subdata,TRUE);
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$this->load->view('cetak_template_excel',$data);
	}

	public function reset_sesi(){
		unset($_SESSION['ipp']); exit;
	}

	public function reload_daftar(){
		$subdata['dt'] = $this->cantik2_model->getDataIPP();
		$this->load->view('kepegawaian/ipp/ipp_daftar_ajax',$subdata);
	}

}
