<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Spm extends CI_Controller {
	
    public function __construct()
    {
            parent::__construct();
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model('spm_model');
		$this->load->model('menu_model');
		$this->load->model('unit_model');
		$this->load->model('subunit_model');
		$this->load->model('master_unit_model'); 
	}
	
/* -------------- Method ------------- */
	function index()
	{
		/* check session	*/
		if($this->check_session->user_session()){
			redirect('Spm/daftar_spm/','refresh');
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}
	function daftar_spm()
	{
		/* check session	*/
		if($this->check_session->user_session() && $this->check_session->get_level()==1){
			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
			$subdata_spm['result_spm'] 		= $this->spm_model->search_spm();
			$subdata['row_spm'] 			= $this->load->view("spm/row_spm",$subdata_spm,TRUE);
			$data['main_content'] 			= $this->load->view("spm/daftar_spm",$subdata,TRUE);
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
	}
	
	


}