<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutam_rsnd extends CI_Controller {
	
	private $cur_tahun = '' ;
	private $rek_tunj_pns = 2;
	private $rek_nonpns = 2;

	public function __construct()
  {
		parent::__construct();

		$this->cur_tahun = $this->setting_model->get_tahun();
		// Your own constructor code
		if(!$this->check_session->user_session() || ( intval($_SESSION['rsa_kode_unit_subunit'])!=51 && intval(substr($_SESSION['rsa_kode_unit_subunit'],0,2))!=42 )){	/*	Jika session user belum diset	*/
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
			if(!isset($_SESSION['tutam_rsnd']['tahun'])){
				$_SESSION['tutam_rsnd']['tahun'] = $this->cur_tahun;
			}
			
		}
  }


	public function index()
	{
		$subdata['pegawaiRSNDOption'] = $this->cantik_model->get_dosen_rsnd();
		$subdata['jabatanRSNDOption'] = $this->cantik_model->get_jabatan_rsnd();
    $subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption(date('m'));
		$subdata['dt'] = $this->cantik_model->get_data_pegawai_tutam();
		$data['main_content']	= $this->load->view('modul_gaji/tutam_rsnd',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('main_template',$data);
	}
	
	public function tutam_proses(){
		if(isset($_POST)){
			if(isset($_POST['act']) && $_POST['act']=='tutam_proses'){
				$_SESSION['tutam_rsnd']['bulan'] = $_POST['bulan'];
				$p = $_POST['personal'];
				foreach($p as $k => $v){
					$a = explode(" - ",$v);
					$nip = $a[0];
					$nama = $a[1];
					$tgs_tambahan_id = $a[2];
					$tugas_tambahan = $a[3];
					$sql = "SELECT a.nama, a.nip, a.golongan_id, a.unit_id, a.status, d.kelompok, e.nmbank, e.norekening
									FROM kepeg_tb_pegawai a
									LEFT JOIN kepeg_tb_golongan d ON a.golongan_id = d.id
									LEFT JOIN kepeg_tb_rekening e ON a.id = e.pegawai_id WHERE a.nip LIKE '".$nip."' AND jenisrek = 2";
					$dt = $this->db->query($sql)->row();
					$sql = "SELECT id FROM kepeg_tr_tutam_rsnd WHERE nip LIKE '".$nip."' AND tahun LIKE '".$_SESSION['tutam']['tahun']."' AND bulan LIKE '".$_SESSION['tutam']['bulan']."' AND tgs_tambahan_id = ".$tgs_tambahan_id;
					$q = $this->db->query($sql);
					if($q->num_rows()<=0){
						$nominal = $this->cantik_model->get_nominal_tutam_rsnd($tgs_tambahan_id, $dt->kelompok);
						if(intval($dt->kelompok) == 4){
							$pajak = 0.15;
						}else{
							$pajak = 0.05;
						}
						$nom_pajak = ceil($nominal*$pajak);
						$bersih = $nominal - $nom_pajak;
						$sql_e[] = "('".$_SESSION['tutam_rsnd']['tahun']."', '".$_SESSION['tutam_rsnd']['bulan']."', '".$dt->nama."', '".$dt->nip."', '".$dt->golongan_id."', '".$dt->unit_id."', '".$dt->status."', '".$dt->kelompok."', '".$tgs_tambahan_id."', '".$tugas_tambahan."', 'Rumah Sakit Pendidikan', '".$dt->nmbank."', '".$dt->norekening."', '".$nominal."', '".$pajak."', '".$nom_pajak."', '".$bersih."', NOW())";
					}
				}
				if(count($sql_e)>0){
					$sql="INSERT INTO kepeg_tr_tutam_rsnd(tahun, bulan, nama, nip, golongan_id, unit_id, status, kelompok, tgs_tambahan_id, tugas_tambahan, det_tgs_tambahan, nmbank, norekening, nominal, pajak, nom_pajak, bersih, waktu_proses) VALUES".implode(", ",$sql_e);
					//echo $sql; exit;
					$this->db->query($sql);
				}
				echo "1"; exit;
			}
			
			if(isset($_POST['act']) && $_POST['act']=='tutam_lihat'){
				$_SESSION['tutam_rsnd']['bulan'] = $_POST['bulan'];
				echo "1"; exit;
			}
			
			if(isset($_POST['act']) && $_POST['act']=='tutam_hapus_single'){
				if(isset($_POST['id'])){
          $sql = "DELETE FROM `kepeg_tr_tutam_rsnd` WHERE `id` = ".intval($_POST['id']);
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
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption($_SESSION['tutam_rsnd']['bulan']);
		$subdata['dt'] = $this->cantik_model->get_data_tutam_rsnd();
		$data['main_content']	= $this->load->view('modul_gaji/tutam_rsnd_daftar',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('main_template',$data);
	}
	
	public function daftar_cetak()
	{
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['dt'] = $this->cantik_model->get_data_tutam_rsnd();
		$subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
		$subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$data['main_content']	= $this->load->view('modul_gaji/tutam_rsnd_daftar_cetak',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    //$data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('cetak_template_excel',$data);
	}

}