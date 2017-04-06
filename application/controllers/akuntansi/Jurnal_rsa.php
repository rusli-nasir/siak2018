<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal_rsa extends MY_Controller {
	private $data;

	public function __construct(){
        parent::__construct();
        // $this->cek_session_in();
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->load->model('akuntansi/Akun_kas_rsa_model', 'Akun_kas_rsa_model');
        $this->load->model('akuntansi/Akun_belanja_rsa_model', 'Akun_belanja_rsa_model');
        $this->load->model('Rsa_unit_model');
    }

	public function input_jurnal($id_kuitansi){
		$isian = $this->Jurnal_rsa_model->get_kuitansi($id_kuitansi);
		$isian['akun_kas'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
		$isian['akun_belanja'] = $this->Akun_belanja_rsa_model->get_all_akun_belanja();
        $data['tab'] = 'beranda';
        $data['menu1'] = true;
        // print_r($isian['akun_kas']);die();
        // $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian);
		$data['content'] = $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian,true);
		$this->load->view('akuntansi/content_template',$data,false);
	}

	public function coba()
	{
		print_r($this->Akun_belanja_rsa_model->get_all_akun_belanja());
	}
}
