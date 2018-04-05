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
			// $subdata['heading'] = "PERHATIAN (SESI)";
			// $subdata['message'] = "Sesi Anda sudah habis. Silahkan login kembali.";
			// $this->load->view('errors/html/error_general',$subdata);
		}else{	/*	Jika session user sudah diset	*/
			// set db
			$this->skp = $this->load->database('skp', TRUE);
			$this->eduk = $this->load->database('eduk', TRUE);

			$this->load->helper('form');
			$this->load->model('login_model');
			$this->load->model('menu_model');
			$this->load->model('user_model');
			$this->load->library('form_validation');
			$this->load->library('revisi_session');
			$this->load->model('setting_model');
			$this->load->model('cantik_model');
			$this->load->model('cantik2_model');

			// otomatis set status
			if(!isset($_SESSION['ikw']['status'])){
				$_SESSION['ikw']['status'] = array(1,3,6,12,13,14);
			}

			// otomatis set tahun
			// if(!isset($_SESSION['ikw']['tahun'])){
			// 	$_SESSION['ikw']['tahun'] = $this->cur_tahun;
			// }

			// otomatis set seluruh unit
			if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='18'){
				$_SESSION['ikw']['unit_id'][0] = $this->cantik2_model->get_kode_kepeg_unit($_SESSION['rsa_kode_unit_subunit']);
			}
			// if(!isset($_SESSION['ikw']['unit_id'])){
			// 	if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42'){
			// 		$_SESSION['ikw']['unit_id'] = $this->cantik2_model->getUnitChecked();
			// 	}else{
			// 		$_SESSION['ikw']['unit_id'] = $this->cantik2_model->get_unit_rba($this->check_session->get_unit());
			// 	}
			// }

		}
  }


	public function index()
	{
		// print_r($_SESSION); exit;
    $subdata['status_kepeg'] = array();
		if(isset($_SESSION['ikw']['status_kepeg'])){
			$subdata['status_kepeg'] = $_SESSION['ikw']['status_kepeg'];
		}
		$subdata['cur_tahun'] = $this->cur_tahun;
		$unit = "";
		if(isset($_SESSION['ikw']['unit_id'])){
			$unit = $_SESSION['ikw']['unit_id'];
		}
		$subdata['unitList'] = $this->cantik2_model->getUnitList($unit);
		$subdata['statusKepegOption'] = $this->cantik_model->getStatusKepegFullCheckbox($subdata['status_kepeg']);
		$unit = $this->check_session->get_unit();
		$bulan = date('m');
		if(isset($_SESSION['ikw']['bulan'])){
			$bulan = $_SESSION['ikw']['bulan'];
		}
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption($bulan);
		$data['main_content']	= $this->load->view('kepegawaian/ikw',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('main_template',$data);
	}

	public function reset_sesi(){
		unset($_SESSION['ikw']); exit;
	}

	public function showDialogProsesIKW(){
		if(!isset($_SESSION['ikw'])){
			echo $this->cantik_model->msgGagal('Pilih kriteria proses IKW sebelum melakukan proses'); exit;
		}
		$unit = "seluruh unit Universitas Diponegoro";
		$row = $this->cantik2_model->get_total_row('ikw');
		$aksi = "";
		$html = "";
		$html .= "<div class=\"alert small\">
			<h4 class=\"page-header\"><i class=\"fa fa-bullhorn\"></i>&nbsp;&nbsp;Informasi Proses Data Insentif Kinerja Wajib ".$this->cantik_model->getJenisPeg($_SESSION['ikw']['jnspeg'])."</h4>
			<p>Jumlah Pegawai yang akan di-proses adalah <strong>".$row."</strong> orang.</p>";
		$html.="<p>Unit yang diproses : <strong>".$this->cantik2_model->get_unit('ikw')."</strong></p>";
		$html.="<p>Status Kepegawaian yang diproses : <strong>".$this->cantik2_model->get_status('ikw')."</strong></p>";
		$html.="<p>Status Personel yang diproses : <strong>".$this->cantik2_model->get_status_kerja('ikw')."</strong></p>";
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
				if(isset($_POST['tahun'])){
          $_SESSION['ikw']['tahun'] = $_POST['tahun'];
        }
				echo "1"; exit;
			}
			//===============// //==============//

			//======================// REAL PROCESS //==============//
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
				$vTSQL = "";$vDSQL = "";
				if($_SESSION['ikw']['bulan']<=6 && $_SESSION['ikw']['bulan']>=1){
					$sms = 'SMT02'.($_SESSION['ikw']['tahun']-1);
					$vTSQL = " AND d.`periode_ikw` LIKE '".$sms."'";
					$smsDosen = ($_SESSION['ikw']['tahun']-1).'2';
					$vDSQL = " AND `thnskp` LIKE '".$smsDosen."'";
				}else
				if($_SESSION['ikw']['bulan']<=12 && $_SESSION['ikw']['bulan']>=7){
					$sms = 'SMT01'.$_SESSION['ikw']['tahun'];
					$vTSQL = " AND d.`periode_ikw` LIKE '".$sms."'";
					$smsDosen = $_SESSION['ikw']['tahun'].'1';
					$vDSQL = " AND `thnskp` LIKE '".$smsDosen."'";
				}
				if($_SESSION['ikw']['jnspeg'] == 2){ // tendik
	        $sql = "SELECT a.`id`, a.`nip`, a.`nama`, a.`unit_id`, a.`status_kepeg`, a.`jnspeg`, a.`golongan_id`, b.`gol`, b.`kelompok`, a.`npwp`, c.`bobot`, a.`status`, d.`jam_perolehan` AS jam, a.`tmt_status`, TIMESTAMPDIFF(MONTH,a.tmt_status,'".$_SESSION['ikw']['tahun']."-".$_SESSION['ikw']['bulan']."-01') AS waktu, c.`jabatan`, a.jabatan_id FROM `tb_pegawai` a LEFT JOIN `tb_golongan` b ON a.`golongan_id` = b.`id` LEFT JOIN `tb_jabatan` c ON a.`jabatan_id` = c.`id` LEFT JOIN `tb_riwayatikw` d ON a.`id` = d.`pegawai_id` WHERE a.`jnspeg` = ".intval($_SESSION['ikw']['jnspeg']).$vSQL.$vTSQL;
	        if($_SESSION['rsa_kode_unit_subunit'] == 27){
	        	$sql = "SELECT a.`id`, a.`nip`, a.`nama`, a.`unit_id`, a.`status_kepeg`, a.`jnspeg`, a.`golongan_id`, b.`gol`, b.`kelompok`, a.`npwp`, c.`bobot`, a.`status`,a.`tmt_status`, c.`jabatan`, a.`jabatan_id`, '851' AS jam, TIMESTAMPDIFF(MONTH,a.tmt_status,'".$_SESSION['ikw']['tahun']."-".$_SESSION['ikw']['bulan']."-01') AS waktu FROM `tb_pegawai` a LEFT JOIN `tb_golongan` b ON a.`golongan_id` = b.`id` LEFT JOIN `tb_jabatan` c ON a.`jabatan_id` = c.`id` WHERE a.`jnspeg` = ".intval($_SESSION['ikw']['jnspeg']).$vSQL.$vTSQL;
	        }
				}else{ // dosen
					$sql = "SELECT a.`id`, a.`nip`, a.`nama`, a.`unit_id`, a.`status_kepeg`, a.`jnspeg`, a.`golongan_id`, b.`kelompok`, b.`gol`, a.`npwp`, c.`bobot`, a.`status`, a.`tmt_status`, TIMESTAMPDIFF(MONTH,a.tmt_status,'".$_SESSION['ikw']['tahun']."-".$_SESSION['ikw']['bulan']."-01') AS waktu, c.`jabatan`, a.jabatan_id FROM `tb_pegawai` a LEFT JOIN `tb_golongan` b ON a.`golongan_id` = b.`id` LEFT JOIN `tb_jabatan` c ON a.`jabatan_id` = c.`id` WHERE a.`jnspeg` = ".intval($_SESSION['ikw']['jnspeg']).$vSQL;
				}
				// echo $sql; exit;
				$row = $this->eduk->query($sql)->num_rows();

        if($row > 0){
        	$persen = 1;
					$sql_e_ = array();
          $r = $this->eduk->query($sql)->result();

					foreach ($r as $k => $v) { // START FOREACH ROWS
            $sql_e = "SELECT `id_trans` FROM `kepeg_tr_ikw` WHERE `nip` LIKE '".$v->nip."' AND `tahun` LIKE '".intval($_SESSION['ikw']['tahun'])."' AND `bulan` LIKE '".intval($_SESSION['ikw']['bulan'])."' AND `fk_rsa_unit` LIKE '".$_SESSION['rsa_kode_unit_subunit']."%'";
            $row = $this->db->query($sql_e)->num_rows();
            if($row==0){ // START ROW >0 FOR `kepeg_tr_ikw`
              if(intval($v->kelompok)==4){
                $_pajak = 0.15;
              }elseif(intval($v->kelompok)==3){
                $_pajak = 0.05;
								if(strlen(trim($v->npwp))<1){
									$_pajak = 0.06;
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
              $_kelompok = $v->kelompok;
              $_bobot = $v->bobot;
              if(intval($v->status) == 13){
              	$_bobot = 5;
              }
							// echo "<p class=\"small\">".$v->nip." | ".$v->nama." (".$v->status.") | ".$v->npwp." | ".$_pajak."</p>";
							$ikw = 0;
							$bruto = 0;
							$persen = 1;
							// $time = 0;
							// $var = 0;
							// $now = 0;
							// $max_lifetime = (4380 * 3600);
							if(intval($v->jnspeg) == 2){ //==========  jika merupakan pegawai tendik

								if($v->unit_id == 27){ // bila merupakan RSND
									$ikw = $this->cantik2_model->getIKWRSND($_kelompok, $v->jabatan_id);
									// if($_SESSION['ikw']['bulan']>=1 && $_SESSION['ikw']['bulan']<=12){
									// 	$persen = $this->cantik_model->set_persentase_ikw($v->jam);
									// 	$ikw = round($ikw * $persen);
									// }
								}else{
									$ikw = $this->cantik_model->getIKWBruto($_kelompok, $_bobot);
									// if($v->status_kepeg==2 && $v->kelompok == 2){
									// 	$ikw = round($ikw * (1 / (1-$_pajak)));
									// }
								}
								if($v->status == 12 || $v->status == 14){
									// $var = strtotime($v->tmt_status);
									// $now = strtotime($_SESSION['ikw']['tahun']."-".$this->cantik2_model->addnol($_SESSION['ikw']['bulan'])."-25");
									// $time = ($now-$var);
									$bruto = $ikw; // jika lebih kecil atau sama dengan.
									// if($time>$max_lifetime){ // jika lebih besar dari aslinya
									if(intval($v->waktu) > 6){
										$persen = $this->pot_tugasbelajar;
										$bruto = $ikw*$persen;
										// dianggap tidak mau menetapi tmt_status
										if(is_null($v->tmt_status) || strlen(trim($v->tmt_status))<12){
											$bruto = 0;
										}
									}
								}else{
									$bruto = $ikw; // jika IKW ke 13
									if($_SESSION['ikw']['bulan']>=1 && $_SESSION['ikw']['bulan']<=12){ // IKW 1 - 12
										$persen = $this->cantik_model->set_persentase_ikw($v->jam);
										$bruto = ceil($ikw * $persen);
									}
								}
								$v->komposisi = 0;
								// echo "<p class='small'>".$v->nama." (".$v->status.") | Status: ".$v->status." | jab_id: ".$v->jabatan_id." | IKW: ".number_format($bruto,0,',','.')." | net: ".($bruto-ceil($bruto*$_pajak))."</p>";

							}else{ //=========== jika merupakan pegawai dosen


								$ikw = $this->cantik_model->getIKWBruto($_kelompok, $_bobot);
								// $ikw_full = $ikw;
								// if($v->status_kepeg==2 && $v->kelompok == 2){
								// 	$ikw = round($ikw * (1 / (1-$_pajak)));
								// }
								if($v->status == 12 || $v->status == 14){
									// $var = strtotime($v->tmt_status);
									// $now = strtotime($_SESSION['ikw']['tahun']."-".$this->cantik2_model->addnol($_SESSION['ikw']['bulan'])."-25");
									// $time = ($now-$var);
									// if($time>$max_lifetime){
									if(intval($v->waktu) > 6){
										$persen = $this->pot_tugasbelajar;
										$bruto = $ikw*$persen;

										// dianggap tidak mau menetapi tmt_status
										if(is_null($v->tmt_status) || strlen(trim($v->tmt_status))<12){
											$bruto = 0;
										}
									}else{
										$bruto = $ikw;

										// dianggap tidak mau menetapi tmt_status
										if(is_null($v->tmt_status) || strlen(trim($v->tmt_status))<12){
											$bruto = 0;
										}
									}
									$t['sks_ikw'] = 12;
									$t['komposisi'] = 1;
								}else{
									// query untuk mendapatkan penetapan IKW DOsen
									if($_SESSION['ikw']['bulan']>=1 && $_SESSION['ikw']['bulan']<=12){
										$sql_dosen = "SELECT * FROM `dt_penetapan` WHERE `posisi_penetapan` = '3' AND `id_dosen` = '".$v->id."'".$vDSQL;
										$q = $this->skp->query($sql_dosen);
										if($q->num_rows()<=0){
											$bruto = 0;
										}else{
											$t = (array)$q->row();
											$persen = $this->cantik_model->set_persentase_ikw($t['sks_ikw'], $t['komposisi']);
											$bruto = ceil($ikw * $persen);
										}
									}
									// END DOsen
								}
								$v->jam = $t['sks_ikw'];
								$v->komposisi = $t['komposisi'];
								// echo "<p class=\"small\">".$v->nip." | ".$v->nama." (".$v->status.") -> IKW: ".number_format($ikw,0,',','.')." | ".$persen." | ".$t['sks_ikw']." | ".$t['komposisi']." | IKW Net: ".number_format($bruto,0,',','.')."</p>";
							}

              $_jml_pajak = ceil($_pajak * $bruto);
              $_byr_stlh_pajak = $bruto - $_jml_pajak;
							$_netto = $_byr_stlh_pajak;
							$bank = $this->cantik2_model->getDataRekening($v->id,2);
							if(is_null($bank)){
								$bank['kelompok_bank'] = '';
								$bank['nmpemilik'] = '';
								$bank['norekening'] = '';
							}
							$sql_e_[] = "('".$_SESSION['ikw']['tahun']."', '".$_SESSION['ikw']['bulan']."', '".$v->id."', '".$v->nip."', '".$this->cantik_model->encodeText($v->nama)."', '".$v->jabatan."','".$v->unit_id."', '".$v->status."', '".$v->status_kepeg."', '".$v->jnspeg."', '".$v->gol."', '".$this->cantik_model->encodeText($v->npwp)."', '".$ikw."', '".$bruto."', '".$_pajak."', '".$_jml_pajak."', '".$_byr_stlh_pajak."', '".$_netto."', '".$v->jam."', '".$v->komposisi."', ".$persen.", '".$bank['kelompok_bank']."', '".$this->cantik_model->encodeText($bank['nmpemilik'])."', '".$this->cantik_model->encodeText($bank['norekening'])."', '".$_SESSION['rsa_kode_unit_subunit']."')";

							// echo "<p class='small'>('".$_SESSION['ikw']['tahun']."', '".$_SESSION['ikw']['bulan']."', '".$v->id."', '".$v->nip."', '".$this->cantik_model->encodeText($v->nama)."', '".$v->jabatan."','".$v->unit_id."', '".$v->status."', '".$v->status_kepeg."', '".$v->jnspeg."', '".$v->gol."', '".$this->cantik_model->encodeText($v->npwp)."', '".$ikw."', '".$bruto."', '".$_pajak."', '".$_jml_pajak."', '".$_byr_stlh_pajak."', '".$_netto."', '".$v->jam."', '".$v->komposisi."', ".$persen.", '".$bank['kelompok_bank']."', '".$this->cantik_model->encodeText($bank['nmpemilik'])."', '".$this->cantik_model->encodeText($bank['norekening'])."', '".$_SESSION['rsa_kode_unit_subunit']."')</p>";
            } // END IF ROW 0 FOR `kepeg_tr_ikw`
          } // END FOR

					// exit;

					if(count($sql_e_)>0){
						$sql_e = "INSERT INTO `kepeg_tr_ikw`(tahun, bulan, pegid, nip, nama, jabatan, unitid, status, statuspeg, jenispeg, golpeg, npwp, ikw, bruto, pajak, jml_pajak, byr_stlh_pajak, netto, jam, komposisi, persentase, bank, nama_pemilik, no_rekening, fk_rsa_unit) VALUES ".implode(", ",$sql_e_)."";
						// echo "<pre>".$sql_e."</pre>"; exit;
						// if($_SESSION['ikw']['jnspeg']==1){
						// 	echo $sql_e; exit;
						// 	exit;
						// }
						if(!$this->db->query($sql_e)){
							echo $this->db->_error_message(); exit;
						}
					}
          echo 1;
        } // end if row
				exit;
			}

			//====================// LIHAT DAFTAR IKW //========================//
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
				if(isset($_POST['tahun'])){
          $_SESSION['ikw']['tahun'] = $_POST['tahun'];
        }
				echo "1"; exit;
			}
			//==============// END IKW LIHAT //=================//

			if(isset($_POST['act']) && $_POST['act']=='ikw_hapus_single'){
				if(isset($_POST['id'])){
          $sql = "DELETE FROM `kepeg_tr_ikw` WHERE `id_trans` = ".intval($_POST['id']);
					$this->db->query($sql);
          echo 1; exit;
        }
        echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
			}
			if(isset($_POST['act']) && $_POST['act']=='ikw_hapus_kelompok'){
				// echo $this->cantik_model->hapus_ikw(); exit;
				if($this->cantik_model->hapus_ikw()){
					echo "1"; exit;
				}else{
        	echo $this->cantik_model->msgGagal("Tidak ada yang dapat dihapus."); exit;
				}
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
				/*if(isset($_POST['id'])){
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
				}*/
				echo $this->cantik_model->msgGagal('Perhitungan diberlakukan secara otomatis sehingga pemotongan IKW melalui halaman ini tidak dipergunakan.<br/>Mohon maaf dan terimakasih.'); exit;
			}


		} // end post
	} // end function


	//=================== DAFTAR =================//
	public function daftar()
	{
		$subdata['status_kepeg'] = array();
		if(isset($_SESSION['ikw']['status_kepeg'])){
			$subdata['status_kepeg'] = $_SESSION['ikw']['status_kepeg'];
		}
		$bulan = date('m');
		if(isset($_SESSION['ikw']['bulan'])){
			$bulan = $_SESSION['ikw']['bulan'];
		}
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['unitList'] = $this->cantik2_model->getUnitList($_SESSION['ikw']['unit_id']);
		$subdata['statusKepegOption'] = $this->cantik_model->getStatusKepegFullCheckbox($subdata['status_kepeg']);
		$subdata['daftar_unit'] = $this->cantik2_model->get_unit('ikw');
		$subdata['daftar_status'] = $this->cantik2_model->get_status('ikw');
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption($bulan);
		$subdata['pot_tugasbelajar'] = $this->pot_tugasbelajar;
		$unit = $this->check_session->get_unit();
		$data['main_content']	= $this->load->view('kepegawaian/ikw_daftar',$subdata,TRUE);
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('main_template',$data);
	}

	public function daftar_ajax(){
		$subdata['dt'] = $this->cantik2_model->getDataIKW();
		// print_r($subdata); exit;
		$this->load->view('kepegawaian/ikw_daftar_ajax',$subdata);
	}
	//=====================================================//


	public function daftar_cetak()
	{
		$subdata['status_kepeg'] = array();
		if(isset($_SESSION['ikw']['status_kepeg'])){
			$subdata['status_kepeg'] = $_SESSION['ikw']['status_kepeg'];
		}
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['unitList'] = $this->cantik2_model->getUnitList($_SESSION['ikw']['unit_id']);
		$subdata['daftar_unit'] = $this->cantik2_model->get_unit('ikw');
		$subdata['daftar_status'] = $this->cantik2_model->get_status('ikw');
		$subdata['dt'] = $this->cantik2_model->getDataIKW();
		$subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
		$subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$subdata['pot_tugasbelajar'] = $this->pot_tugasbelajar;
		// $this->load->view('kepegawaian/ikw_daftar_cetak',$subdata); exit;
		$subdata['filename'] = date('Ymd')."_ikw_".strtolower(str_replace(' ','-',$this->cantik_model->getJenisPeg($_SESSION['ikw']['jnspeg']))).".xls";
		$data['main_content']	= $this->load->view('kepegawaian/ikw_daftar_cetak',$subdata,TRUE);
		// $list["menu"]           = $this->menu_model->show();
		// $list["submenu"]        = $this->menu_model->show();
		//$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('cetak_template_excel',$data);
		//$this->load->view('cetak_template',$data);
	}

}
