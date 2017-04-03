<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->driver('session');
	}

	public function cek_session_in(){
		if($this->session->userdata('id')==null){
			redirect(site_url('akuntansi/login/index'));
		}
	}

	public function cek_session_out(){
		if($this->session->userdata('id')!=null){
			redirect(site_url('akuntansi/beranda'));
		}
	}

	public function normalisasi_tanggal($tanggal = null){
		if($tanggal!=null){
			$tanggal_array = explode('/', $tanggal);
			$format_baru = $tanggal_array[2].'-'.$tanggal_array[0].'-'.$tanggal_array[1];
		}else{
			$format_baru = null;
		}
		return $format_baru;
	}
}
?>