<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class rsa_cair extends CI_Controller{
/* -------------- Constructor ------------- */
            
            private $cur_tahun;

	public function __construct(){ 
		parent::__construct();
			//load library, helper, and model
            
			$this->load->library(array('form_validation','option'));
			$this->load->helper('form');
			// $this->load->model(array('rsa_up_model','rsa_tambah_up_model','setting_up_model'));
			$this->load->model("user_model");
            $this->load->model("unit_model");
            $this->load->model('menu_model');
            $this->load->model("cair_model");
			$this->load->helper("security");

          	$this->cur_tahun = $this->setting_model->get_tahun();          

		}
	

	public function spm($tahun="",$kode_unit_subunit="",$jenis=''){
                    
                    
        $data['cur_tahun'] =  $this->cur_tahun;
        
        if($tahun == ''){
            $tahun = $this->cur_tahun ;
        }

        if(($kode_unit_subunit == '')||($kode_unit_subunit == '99')){
        	$kode_unit_subunit = '99' ;
            $subdata['kode_unit_subunit'] = 'SEMUA' ;
        }else{
        	$subdata['kode_unit_subunit'] = $kode_unit_subunit  ;
        }

        if(($jenis == '')||($jenis == '00')){
        	$jenis = '00' ;
           $subdata['jenis'] = 'SEMUA' ;
        }else{
        	$subdata['jenis'] = $jenis ;
        }

        /* check session	*/
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==17)||($this->check_session->get_level()==11))){

        		$data['main_menu']              = $this->load->view('main_menu','',TRUE);
        		$subdata['daftar_spm']          = $this->cair_model->get_spm_cair($tahun,$kode_unit_subunit,$jenis);
        		$subdata['tahun']               = $this->cur_tahun ;

        		$subdata['cur_tahun']               = $this->cur_tahun ;
        		$subdata['data_unit'] = $this->unit_model->get_all_unit();
				$data['main_content']           = $this->load->view("rsa_cair/daftar_spm",$subdata,TRUE);
				// vdebug($subdata);
                /*	Load main template	*/
				// echo '<pre>';var_dump($subdata['daftar_spm']);echo '</pre>';die;
                $this->load->view('main_template',$data);
        }else{
                redirect('welcome','refresh');	// redirect ke halaman home
        }
    }

}

