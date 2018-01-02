<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
        $this->load->model('akuntansi/Spm_model', 'Spm_model');
    }

	public function index(){
		$hasil = array();
        $var_belum = $this->data['jumlah_notifikasi']->belum;
        $var_sudah = $this->data['jumlah_notifikasi']->sudah;
        foreach ($var_belum as $key => $value) {
        	$temp = array();
        	$temp['belum'] = $var_belum[$key];
        	$temp['sudah'] = $var_sudah[$key];
        	$hasil[] = $temp;
        }
        $var = array();
        $var['data']= $hasil;
        $this->load->view('akuntansi/dashboard/dashboard_operator',$var);
	}

    public function dashboard_proses($mode,$jenis = null)
    {
        // echo "<pre>";

        $array_all = array_keys($this->Spm_model->get_array_proses_spm());
        $data['spm'] = json_encode($this->Spm_model->get_spm_proses_rsa($mode,$array_all));
        $data['rekap'] = json_encode($this->Spm_model->get_spm_proses_rsa('total'));
        // echo json_encode($data);
        // print_r($this->Spm_model->get_spm_proses_rsa('total'));
        // die();
        $this->data['content'] = $this->load->view('akuntansi/dashboard/dashboard_proses_spm',$data,true);
        $this->load->view('akuntansi/content_template',$this->data,false);
    }
}
