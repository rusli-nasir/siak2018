<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends MY_Controller {
	private $data;

	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
    }

	public function index(){
        $data['tab'] = 'beranda';
		$data['content'] = $this->load->view('akuntansi/rup_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$data,false);
	}
}
