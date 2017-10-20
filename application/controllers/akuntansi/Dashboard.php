<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
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
}
