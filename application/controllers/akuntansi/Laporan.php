<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['menu9'] = true;
        $this->cek_session_in();
        $this->load->model('akuntansi/Laporan_model', 'Laporan_model');
        $this->data['db2'] = $this->load->database('rba',TRUE);
    }

	public function buku_besar($id = 0){
		$this->data['tab1'] = true;

		$this->data['query_debet'] = $this->Laporan_model->read_buku_besar_group('akun_debet');
		$this->data['query_debet_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_debet_akrual');
		$this->data['query_kredit'] = $this->Laporan_model->read_buku_besar_group('akun_kredit');
		$this->data['query_kredit_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_kredit_akrual');

		$temp_data['content'] = $this->load->view('akuntansi/buku_besar_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
}
