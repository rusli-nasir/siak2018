<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	private $data;

	public function __construct(){
        parent::__construct();
    }

	public function index(){
		$this->load->view('akuntansi/login');
	}

	public function konten(){
		$temp_data['content'] = $this->load->view('akuntansi/rup_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
}
