<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
    protected $data;
	public function __construct(){
		parent::__construct();
		$this->load->driver('session');
        
        if($this->session->userdata('level')){
            $this->load->model('akuntansi/Notifikasi_model', 'Notifikasi_model');

            $this->data['jumlah_notifikasi'] = $this->Notifikasi_model->get_jumlah_notifikasi();
        }
	}

	public function cek_session_in(){
		// print_r($this->session->userdata());die();
		if($this->session->userdata('id')==null){
			redirect(site_url('akuntansi/login/index'));
		}
	}

	public function cek_session_out(){
		if($this->session->userdata('id')!=null){
			if($this->session->userdata('level')==1){
				redirect(site_url('akuntansi/kuitansi'));
			}else{
				redirect(site_url('akuntansi/kuitansi/jadi'));
			}
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
	
	public function normal_number($number){
		return str_replace('.', '', $number);
	}
}
?>