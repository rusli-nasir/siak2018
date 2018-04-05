<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutam_mwa extends CI_Controller {
	
	private $cur_tahun = '' ;
	private $rek_tunj_pns = 2;
	private $rek_nonpns = 2;

	public function __construct()
  {
		parent::__construct();

		$this->cur_tahun = $this->setting_model->get_tahun();
		// Your own constructor code
		if(!$this->check_session->user_session() || intval($_SESSION['rsa_kode_unit_subunit'])!=21 ){	/*	Jika session user belum diset	*/
			redirect('/','refresh');
		}else{	/*	Jika session user sudah diset	*/
			$this->load->helper('form');
			$this->load->model('login_model');
			$this->load->model('menu_model');
			$this->load->model('user_model');
			$this->load->library('form_validation');
			$this->load->library('revisi_session');
			$this->load->model('cantik_model');
			$this->load->model('cantik2_model');
			$this->load->model('setting_model');			
		}
  }


	public function index()
	{
    	$subdata['cur_tahun'] = $this->cur_tahun;
    	$bulan = date('m');
    	if(isset($_SESSION['tutam_mwa']['bulan'])){
    		$bulan = $_SESSION['tutam_mwa']['bulan'];
    	}
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption($bulan);
		$data['main_content']	= $this->load->view('kepegawaian/mwa/tutam',$subdata,TRUE);
	    $list["menu"]           = $this->menu_model->show();
	    $list["submenu"]        = $this->menu_model->show();
	    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
	    $data['message']	= validation_errors();
	    $this->load->view('main_template',$data);
	}
	
	public function tutam_proses(){
		if(isset($_POST)){
			if(isset($_POST['act']) && $_POST['act']=='tutam_proses'){
				$_SESSION['tutam_mwa']['bulan'] = $_POST['bulan'];
				$_SESSION['tutam_mwa']['tahun'] = $_POST['tahun'];
				$d = $this->cantik2_model->get_data_tutam_mwa();
				$sql_e = array();
				foreach($d as $k => $v){
					$sql = "SELECT id FROM kepeg_tr_tutam WHERE pegid LIKE '".$v->id."' AND tahun LIKE '".$_SESSION['tutam_mwa']['tahun']."' AND bulan LIKE '".$_SESSION['tutam_mwa']['bulan']."' AND fk_rsa_unit LIKE '".$_SESSION['rsa_kode_unit_subunit']."'";
					// echo $sql."<br/>";
					$q = $this->db->query($sql);
					if($q->num_rows()<=0){
						$sql_e[] = "('".$_SESSION['tutam_mwa']['tahun']."', '".$_SESSION['tutam_mwa']['bulan']."', '".$v->pegid."', '".$this->cantik_model->encodeText(addslashes($v->nama))."', '".$v->nip."', '".$v->golongan_id."', '".$v->golpeg."', '".$v->unit_id."', '".$v->status."', '".$v->kelompok."', '".$v->tgs_tambahan_id."', '".$v->tugas_tambahan."', '".$v->det_tgs_tambahan."', '".$v->npwp."', '".$v->nmbank."', '".$this->cantik_model->encodeText(addslashes($v->nmpemilik))."', '".$this->cantik_model->encodeText(addslashes($v->norekening))."', '".$v->nominal."', '".$v->pajak."', '".$v->nom_pajak."', '".$v->bersih."', NOW(), '".$_SESSION['rsa_kode_unit_subunit']."')";
						// echo "('".$_SESSION['tutam_mwa']['tahun']."', '".$_SESSION['tutam_mwa']['bulan']."', '".$v->id."', '".$this->cantik_model->encodeText(addslashes($v->nama))."', '".$v->nip."', '".$v->golongan_id."', '".$v->golpeg."', '".$v->unit_id."', '".$v->status."', '".$v->kelompok."', '".$v->tgs_tambahan_id."', '".$v->tugas_tambahan."', '".$v->det_tgs_tambahan."', '".$v->npwp."', '".$v->nmbank."', '".$this->cantik_model->encodeText(addslashes($v->nmpemilik))."', '".$this->cantik_model->encodeText(addslashes($v->norekening))."', '".$v->nominal."', '".$v->pajak."', '".$v->nom_pajak."', '".$v->bersih."', NOW(), '".$_SESSION['rsa_kode_unit_subunit']."')<br />";
					}
					// echo "('".$_SESSION['tutam_mwa']['tahun']."', '".$_SESSION['tutam_mwa']['bulan']."', '".$v->pegid."', '".$this->cantik_model->encodeText(addslashes($v->nama))."', '".$v->nip."', '".$v->golongan_id."', '".$v->golpeg."', '".$v->unit_id."', '".$v->status."', '".$v->kelompok."', '".$v->tgs_tambahan_id."', '".$v->tugas_tambahan."', '".$v->det_tgs_tambahan."', '".$v->npwp."', '".$v->nmbank."', '".$this->cantik_model->encodeText(addslashes($v->nmpemilik))."', '".$this->cantik_model->encodeText(addslashes($v->norekening))."', '".$v->nominal."', '".$v->pajak."', '".$v->nom_pajak."', '".$v->bersih."', NOW(), '".$_SESSION['rsa_kode_unit_subunit']."')<br />";
				}
				// exit;
				if(count($sql_e)>0){
					$sql="INSERT INTO kepeg_tr_tutam(tahun, bulan, pegid, nama, nip, golongan_id, golpeg, unit_id, status, kelompok, tgs_tambahan_id, tugas_tambahan, det_tgs_tambahan, npwp, nmbank, nmpemilik, norekening, nominal, pajak, nom_pajak, bersih, waktu_proses,fk_rsa_unit) VALUES".implode(", ",$sql_e);
					if(!$this->db->query($sql)){
						echo $this->cantik_model->msgGagal("Gagal melakukan eksekusi perintah."); exit;
					}
				}
				echo "1"; exit;
			}
			
			if(isset($_POST['act']) && $_POST['act']=='tutam_lihat'){
				$_SESSION['tutam_mwa']['bulan'] = $_POST['bulan'];
				$_SESSION['tutam_mwa']['tahun'] = $_POST['tahun'];
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
		$subdata['bulanOption'] = $this->cantik_model->getBulanOption($_SESSION['tutam_mwa']['bulan']);
		// $subdata['dt'] = $this->cantik2_model->get_data_tutam();
		$data['main_content']	= $this->load->view('kepegawaian/mwa/tutam_daftar',$subdata,TRUE);
    	$list["menu"]           = $this->menu_model->show();
    	$list["submenu"]        = $this->menu_model->show();
    	$data['main_menu']	= $this->load->view('main_menu','',TRUE);
    	$data['message']	= validation_errors();
    	$this->load->view('main_template',$data);
	}
	public function daftar_ajax(){
		$subdata['dt'] = $this->cantik2_model->getDataTutam();
		$this->load->view('kepegawaian/mwa/tutam_daftar_ajax',$subdata);
	}
	
	public function daftar_cetak()
	{
		$subdata['cur_tahun'] = $this->cur_tahun;
		$subdata['dt'] = $this->cantik2_model->getDataTutam();
		$subdata['ppk'] = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
		$subdata['bpp'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$subdata['filename'] = date('Ymd')."_tutam_mwa.xls";
		$data['main_content']	= $this->load->view('kepegawaian/mwa/tutam_daftar_cetak',$subdata,TRUE);
	    $data['message']	= validation_errors();
	    $this->load->view('cetak_template_excel',$data);
	}
	public function hapus_daftar_tutam(){
		$sql = "DELETE FROM `kepeg_tr_tutam` WHERE `bulan` LIKE '".$_SESSION['tutam_mwa']['bulan']."' AND `tahun` LIKE '".$_SESSION['tutam_mwa']['tahun']."' AND `fk_rsa_unit` LIKE '".$_SESSION['rsa_kode_unit_subunit']."%'";
		// echo $sql; exit;
		if($this->db->query($sql)){
			echo 1; exit;
		}
		echo $this->cantik_model->msgGagal('Gagal menghapus daftar tugas tambahan.'); exit;
	}

	public function daftar_mwa_ajax()
	{
		$subdata['dt'] = $this->cantik2_model->get_data_tutam_mwa(); // dapatkan list mwa dari data yang dimasukkan scara manual.
		$this->load->view('kepegawaian/mwa/tutam_daftar_mwa',$subdata);
	}

	public function daftar_mwa_ajax_update()
	{
		$post = $this->input->post();
		if($post['field'] == 'nominal'){
			$post['value'] = str_replace(".", "", $post['value']);
			$post['value'] = str_replace(",", ".", $post['value']);
		}
		echo $this->cantik2_model->update_data_tutam_mwa($post);
	}

	public function daftar_mwa_ajax_delete()
	{
		$post = $this->input->post();
		$post['id'] = intval($post['id']);
		echo $this->cantik2_model->delete_data_tutam_mwa($post);
	}

	public function daftar_mwa_ajax_add()
	{
		$post = $this->input->post();
		echo $this->cantik2_model->add_data_tutam_mwa($post);
	}

	public function daftar_mwa_ajax_pegawai()
	{
		$q = $this->input->post('q');
		echo $this->cantik2_model->pegawai_data_tutam_mwa($q);
	}

	public function daftar_mwa_ajax_pegawai_id(){
		$id = $this->input->post('id');
		echo json_encode($this->cantik2_model->get_data_pegawai_id($id));
	}

}