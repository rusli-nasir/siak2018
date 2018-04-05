<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Rsa_gaji_kuitansi extends CI_Controller{
/* -------------- Constructor ------------- */
            
    private $cur_tahun;
	public function __construct(){ 
		parent::__construct();
			//load library, helper, and model
		$this->cur_tahun = $this->setting_model->get_tahun();
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model('menu_model');
		$this->load->model('rsa_gaji_kuitansi_model');
		$this->load->helper("security");
		$this->load->helper("vayes_helper");
                        
		}
		
		#methods ======================
		
		//define method index()
		public function index($jenis=""){
        /* check session    */
       
	            redirect('welcome','refresh');  // redirect ke halaman home
         }

         function spm($jenis=""){
        /* check session    */
            $data['cur_tahun'] = $this->cur_tahun ;
            if($this->check_session->user_session()){
            	$unit = $this->check_session->get_unit();
            	
            	 $subdata['spm']			= $this->rsa_gaji_kuitansi_model->get_spm($jenis,$unit);
            	 $subdata['jumlah']			= 0;
            	// vdebug($subdata['dana_pumk']);
	            $data['main_content'] =  $this->load->view('gaji_kuitansi/daftar_spm',$subdata,TRUE);
	            $list["menu"] = $this->menu_model->show();
	            $list["submenu"] = $this->menu_model->show();
	            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
	            
	            $this->load->view('main_template',$data);
	        }else{
	            redirect('welcome','refresh');  // redirect ke halaman home
	        }
         }

         function kuitansi($spm=""){
        /* check session    */
            $data['cur_tahun'] = $this->cur_tahun ;
            if($this->check_session->user_session()){
            	$unit = $this->check_session->get_unit();

            	if($spm != ''){
                    $spm = base64_decode(urldecode($spm));
                     // urlencode(base64_encode($no_spm));
                    $subdata['kuitansi']			= $this->rsa_gaji_kuitansi_model->get_kuitansi($spm);
                    $subdata['jumlah']			= 0;
                    // vdebug($subdata['kuitansi']);

                }else {
                	redirect('rsa_gaji_kuitansi/');
                }
            	 
            	// vdebug($subdata['dana_pumk']);
	            $data['main_content'] =  $this->load->view('gaji_kuitansi/daftar_kuitansi',$subdata,TRUE);
	            $list["menu"] = $this->menu_model->show();
	            $list["submenu"] = $this->menu_model->show();
	            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
	            
	            $this->load->view('main_template',$data);
	        }else{
	            redirect('welcome','refresh');  // redirect ke halaman home
	        }
         }

         function detail_kuitansi($no_bukti=""){
        /* check session    */
            $data['cur_tahun'] = $this->cur_tahun ;
            if($this->check_session->user_session()){
            	$unit = $this->check_session->get_unit();

            	if($no_bukti != ''){
                    $no_bukti = base64_decode(urldecode($no_bukti));
                     // urlencode(base64_encode($no_spm));
                    $subdata['detail']			= $this->rsa_gaji_kuitansi_model->get_detail_kuitansi($no_bukti);
                    // vdebug($subdata['kuitansi']);

                }else {
                	redirect('rsa_gaji_kuitansi/');
                }
            	 
            	// vdebug($subdata['dana_pumk']);
	            $data['main_content'] =  $this->load->view('gaji_kuitansi/daftar_detail',$subdata,TRUE);
	            $list["menu"] = $this->menu_model->show();
	            $list["submenu"] = $this->menu_model->show();
	            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
	            
	            $this->load->view('main_template',$data);
	        }else{
	            redirect('welcome','refresh');  // redirect ke halaman home
	        }
         }

}

