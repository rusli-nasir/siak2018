<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepegawaian extends CI_Controller {


	public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    if(!$this->check_session->user_session()){	/*	Jika session user belum diset	*/
			redirect('/','refresh');
		}else{	/*	Jika session user sudah diset	*/
			$this->cur_tahun = $this->setting_model->get_tahun();
			$this->load->helper('form');
			$this->load->model('login_model');
			$this->load->model('menu_model');
			$this->load->model('user_model');
			$this->load->library('form_validation');
			$this->load->library('revisi_session');
			$this->load->model('cantik_model');
			$this->load->model('setting_model');
		}
  }

	public function index()
	{
		$subdata['cur_tahun'] = $this->cur_tahun;
    $unit = $this->check_session->get_unit();
		$data['main_content']	= $this->load->view('kepegawaian/index',$subdata,TRUE);
    $list["menu"]           = $this->menu_model->show();
    $list["submenu"]        = $this->menu_model->show();
    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
    $data['message']	= validation_errors();
    $this->load->view('main_template',$data);
	}

}
