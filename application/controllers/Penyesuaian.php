<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyesuaian extends CI_Controller {
	
	private $cur_tahun;
	public function __construct()
	{
		parent::__construct();
		$this->cur_tahun = $this->setting_model->get_tahun();
		$this->load->model('penyesuaian_model');
		$this->load->model('menu_model');
	}

	public function index()
	{
		/* check session	*/
			$data['cur_tahun'] = $this->cur_tahun ;
			if($this->check_session->user_session()){
			$list["menu"] = $this->menu_model->show();
			$list["submenu"] = $this->menu_model->show();
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);
			$this->load->view('main_template',$data);
			$this->load->view('penyesuaian/penyesuaian');
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

	}


	public function sesuaikan()
	{
		// $min_epoch = strtotime('2017-12-31 09:00:00');
		// $max_epoch = strtotime('2017-12-31 16:00:00');

		// $rand_epoch = rand($min_epoch, $max_epoch);

		// $date = date('Y-m-d H:i:s', $rand_epoch);

		$data1 = array(
						'tanggal_transaksi'	=> $date
					);
		$data2 = array(
						'tanggal_impor'		=> $date
					);

		$sesuaikan = $this->penyesuaian_model->sesuaikan1($data1,$data2);
		
		if ($sesuaikan) {
			echo 'sukses';
		}else{
			echo 'error';
		};

	}


	public function sesuaikan2()
	{

		$data = array(
						'tgl_proses'		=> '2017-12-31 23:59:59'
					);
		$data2 = array(
						'tgl_spm'		=> '2017-12-31 23:59:59'
					);
		$data3 = array(
						'tgl_spp'		=> '2017-12-31 23:59:59'
					);
		$data4 = array(
						'tgl_proses_tambah_tup'		=> '2017-12-31 23:59:59'
					);
		$data5 = array(
						'tgl_proses_tambah_ks'		=> '2017-12-31 23:59:59'
					);
		

		$sesuaikan2 = $this->penyesuaian_model->sesuaikan2($data,$data2,$data3,$data4,$data5);
		
		if ($sesuaikan2) {
			echo 'sukses';
		}else{
			echo 'error';
		};

	}

	public function sesuaikan3()
	{
		$data = array(
						'tgl_kuitansi'	=> '2017-12-31 23:59:59'
					);

		$sesuaikan3 = $this->penyesuaian_model->sesuaikan3($data);
		
		if ($sesuaikan3) {
			echo 'sukses';
		}else{
			echo 'error';
		};

	}

		public function get_notif_kuitansi()
	{
		$tidak_sesuai = $this->penyesuaian_model->get_tidak_sesuaikan_kuitansi();
		if ($tidak_sesuai > 0) {
			echo $tidak_sesuai;
		}else{
			echo '0';
		}
	}

	public function get_notif_tidak_sesuai()
	{
		$tidak_sesuai = $this->penyesuaian_model->get_tidak_sesuaikan();
		if ($tidak_sesuai > 0) {
			echo $tidak_sesuai;
		}else{
			echo '0';
		}
	}

	public function get_notif_trx()
	{
		$tidak_sesuai = $this->penyesuaian_model->get_sesuaikan_trx();
		if ($tidak_sesuai > 0) {
			echo $tidak_sesuai;
		}else{
			echo '0';
		}
	}

	public function get_notif_all()
	{
		$tidak_sesuai1 = $this->penyesuaian_model->get_tidak_sesuaikan_kuitansi();
		$tidak_sesuai2 = $this->penyesuaian_model->get_tidak_sesuaikan();
		$tidak_sesuai3 = $this->penyesuaian_model->get_sesuaikan_trx();

		$tidak_sesuai_all = $tidak_sesuai1 + $tidak_sesuai2 + $tidak_sesuai3;
		if ($tidak_sesuai_all > 0) {
			echo $tidak_sesuai_all;
		}else{
			echo '0';
		}
	}

	function daftar_belum_sesuai(){
			if($this->check_session->user_session()){
			$data['cur_tahun'] = $this->cur_tahun ;
			$list["menu"] = $this->menu_model->show();
			$list["submenu"] = $this->menu_model->show();
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);
			$data['querys'] = $this->penyesuaian_model->data_tidak_sesuai();
			$this->load->view('main_template',$data);
			$this->load->view('penyesuaian/daftar_penyesuaian');
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

	function daftar_kuitansi_belum_sesuai(){
			if($this->check_session->user_session()){

			$nomor_trx = '';
			if ($this->input->post('nomor_trx') != '') {
				$nomor_trx = $this->input->post('nomor_trx');
			}
			

			$data['cur_tahun'] 	= $this->cur_tahun ;
			$list["menu"] 		 	= $this->menu_model->show();
			$list["submenu"] 	 	= $this->menu_model->show();
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);
			$data['querys'] 		= $this->penyesuaian_model->data_kuitansi_tidak_sesuai($nomor_trx);
			$this->load->view('main_template',$data);
			$this->load->view('penyesuaian/daftar_penyesuaian_kwitansi');
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

}

/* End of file Penyesuaian.php */
/* Location: ./application/controllers/Penyesuaian.php */