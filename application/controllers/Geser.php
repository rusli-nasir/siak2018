<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Geser extends CI_Controller {
    
    private $cur_tahun = '' ;
    public function __construct()
    {
            parent::__construct();
            
            $this->cur_tahun = $this->setting_model->get_tahun();
            
            if ($this->check_session->user_session()){
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model('geser_model');
		$this->load->model('menu_model');
		$this->load->model('unit_model');
		$this->load->model('subunit_model');
		$this->load->model('master_unit_model'); 
            }else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
    }
    function index(){
        if($this->check_session->get_level()==1){	/*	Jika session user yang aktif unit fakultas	/ biro */
                redirect('dpa/daftar_unit','refresh');
        }
        elseif($this->check_session->get_level()==2){	/*	Jika session user yang aktif unit fakultas	/ biro */
                redirect('dpa/dashboard_dpa','refresh');
        }
        elseif($this->check_session->get_level()==11){	/*	Jika session user yang aktif unit fakultas	/ biro */
                redirect('dpa/daftar_validasi_dpa','refresh');
        }
        elseif($this->check_session->get_level()==100){
            redirect('geser/daftar_unit','refresh');
        }

    }
    
    function daftar_program($kode_unit)
    {
		//var_dump($kode_unit);die;
        $data['cur_tahun'] = $this->cur_tahun ;
		
		/* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==1))){
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
			$subdata['unit_usul'] 		= $this->geser_model->get_geser_unit_usul('SELAIN-APBN','2017',$kode_unit);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 		= $this->load->view("geser/daftar_program",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
    }
	function get_impor_rkat_unit($kode_unit,$sumber_dana,$tahun){
        $result = $this->geser_model->get_dpa_unit_rkat($kode_unit,$sumber_dana,$tahun);
		var_dump($result);die;
        echo number_format($result, 0, ",", ".");
    }
	function get_impor_rsa_unit($kode_unit,$sumber_dana,$tahun){
        $result = $this->geser_model->get_dpa_unit_rsa($kode_unit,$sumber_dana,$tahun);
        echo number_format($result, 0, ",", ".");
    }
    
 
}