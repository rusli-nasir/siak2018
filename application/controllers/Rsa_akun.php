<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Rsa_akun extends CI_Controller{
/* -------------- Constructor ------------- */
    
private $cur_tahun = '';


public function __construct(){
		parent::__construct();
                
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model(array('akun_model','setting_model'));
                $this->cur_tahun = $this->setting_model->get_tahun();
                
	}
	
/* -------------- Method ------------- */
	function index()
	{
		show_404('page');
	}

	function get_akun_by_id($id){
		$row_akun = $this->akun_model->get_akun_by_id($id);
		echo json_encode($row_akun);

	}
	

}
?>