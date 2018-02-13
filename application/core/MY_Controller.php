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
				redirect(site_url('akuntansi/kuitansi/monitor'));
			} else if($this->session->userdata('level')==2){
				if($this->session->userdata('kode_unit')==null){
					redirect(site_url('akuntansi/kuitansi/index'));
				}else{
					redirect(site_url('akuntansi/kuitansi/monitor'));
				}
			} else if($this->session->userdata('level')==3){
				redirect(site_url('akuntansi/penerimaan/index'));
			} else if($this->session->userdata('level')==4){
				redirect(site_url('akuntansi/kuitansi/monitor'));
			} else if($this->session->userdata('level')==6){
				redirect(site_url('akuntansi/kuitansi/monitor'));
			} else if($this->session->userdata('level')==7){
				redirect(site_url('akuntansi/laporan/buku_besar'));
			} else if($this->session->userdata('level')==8){
				redirect(site_url('akuntansi/penerimaan/index'));
			} else if($this->session->userdata('level')==5){
				redirect(site_url('akuntansi/jurnal_umum'));
			} else if($this->session->userdata('level')==9){
				redirect(site_url('akuntansi/user/manage'));
			}else if($this->session->userdata('level')==10){
				redirect(site_url('akuntansi/laporan/lainnya'));
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