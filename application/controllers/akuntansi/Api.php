<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';


class Api extends REST_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('akuntansi/Laporan_model', 'Laporan_model');
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
    }

    public function kuitansi_get()
    {
  //   	error_reporting(E_ALL);
		// ini_set('display_errors', 1);
    	header("Access-Control-Allow-Origin: *");

    	$kode_kegiatan = $this->get('kode_kegiatan');
    	$data = $this->Kuitansi_model->get_kuitansi_jadi_by_kode_kegiatan($kode_kegiatan);

    	if ($data != null){
    		$this->set_response($data,REST_Controller::HTTP_OK);
    	}else {
	        $this->set_response([
                'status' => FALSE,
                'message' => 'Kuitansi tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
    	}

    }

	
}
