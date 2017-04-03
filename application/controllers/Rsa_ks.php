<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class rsa_ks extends CI_Controller{
/* -------------- Constructor ------------- */
            
            private $cur_tahun;
	public function __construct(){ 
		parent::__construct();
			//load library, helper, and model
                $this->cur_tahun = $this->setting_model->get_tahun();
			$this->load->library(array('form_validation','option'));
			$this->load->helper('form');
			$this->load->model(array('rsa_ks_model','setting_up_model'));
			$this->load->model("user_model");
                        $this->load->model('menu_model');
			$this->load->helper("security");
                        

		}
		
		#methods ======================
		
		//define method index()
		function index(){
			$data['cur_tahun'] = $this->cur_tahun ;
                
                        $data['main_content']	= $this->load->view('rsa_ks/index','',TRUE);
                        // $data['main_menu']	= $this->load->view('form_login','',TRUE);
                        $list["menu"] = $this->menu_model->show();
                        $list["submenu"] = $this->menu_model->show();
                        $data['main_menu']	= $this->load->view('main_menu','',TRUE);
//                        $data['message']	= validation_errors();
                        $this->load->view('main_template',$data);
		}
		
		//define method daftar_unit()
		function daftar_rsa_up(){
			if($this->check_session->user_session() && $this->check_session->get_level()==2){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_up_model->search_rsa_up();
				$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
				$subdata['row_rsa_up'] 			= $this->load->view("rsa_up/row_rsa_up",$subdata_rsa_up,TRUE);
				$data['main_content'] 			= $this->load->view("rsa_up/daftar_rsa_up",$subdata,TRUE);
				$this->load->view('main_template',$data);
			}
			else{
				redirect('home','refresh');	// redirect ke halaman home
			}		
		}
		function input_rsa_up(){
			if($this->check_session->user_session() && $this->check_session->get_level()==13){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_up_model->search_rsa_up();
				//$subdata['row_rsa_up'] 			= $this->load->view("rsa_up/row_rsa_up",$subdata_rsa_up,TRUE);
				$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
				$data['main_content'] 			= $this->load->view("rsa_up/input_rsa_up",$subdata,TRUE);
				$this->load->view('main_template',$data);
			}
			else{
				redirect('home','refresh');	// redirect ke halaman home
			}		
		}
                
                function spp_up(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_up_model->search_rsa_up();
				$subdata['detail_up'] 			= array(
                                                                                    'nom' => $this->setting_up_model->get_setting_up($this->check_session->get_unit(),$this->cur_tahun),
                                                                                    'terbilang' => $this->convertion->terbilang($this->setting_up_model->get_setting_up($this->check_session->get_unit(),$this->cur_tahun)), 
                                                                                    
                                                                                );
                                $subdata['cur_tahun'] = $this->cur_tahun;
                                $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                $subdata['unit_id'] = $this->check_session->get_unit();
                                $subdata['alias'] = $this->check_session->get_alias();
                                $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                
                                $dokumen_up = $this->rsa_up_model->check_dokumen_up($this->check_session->get_unit(),$this->cur_tahun);
                                
//                                if(($dokumen_up == '') || ($dokumen_up == 'SPP-DITOLAK') || ($dokumen_up == 'SPM-DITOLAK')){
//                                    $subdata['siap_spp'] = 'ok';
//                                }else{
//                                    $subdata['siap_spp'] = 'no_ok';
//                                }
                                
                                 $subdata['doc_up'] = $dokumen_up;
                                 
                                 $subdata['tgl_spp'] = $this->rsa_up_model->get_tgl_spp($this->check_session->get_unit(),$this->cur_tahun);
                                 if(($dokumen_up == '')||($dokumen_up == 'SPP-DITOLAK')||($dokumen_up == 'SPM-DITOLAK-KPA')||($dokumen_up == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_up == 'SPM-DITOLAK-KBUU')){
                                    $nomor_trx_ = $this->rsa_up_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");  
                                    $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-UP'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                 }else{
                                    $nomor_trx = $this->rsa_up_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 
                                 }
                                 
                                 $subdata['nomor_spp'] = $nomor_trx;
                                 $subdata['ket'] = $this->rsa_up_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata['detail_pic']);die;
				$data['main_content'] 			= $this->load->view("rsa_up/spp_up",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
                
                function spm_up(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_up_model->search_rsa_up();
				$subdata['detail_up'] 			= array(
                                                                                    'nom' => $this->setting_up_model->get_setting_up($this->check_session->get_unit(),$this->cur_tahun),
                                                                                    'terbilang' => $this->convertion->terbilang($this->setting_up_model->get_setting_up($this->check_session->get_unit(),$this->cur_tahun)), 
                                                                                    
                                                                                );
                                $subdata['cur_tahun'] = $this->cur_tahun;
                                $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                $subdata['unit_id'] = $this->check_session->get_unit();
                                $subdata['alias'] = $this->check_session->get_alias();
                                $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
                                
                                $subdata['detail_kuasa_buu']  = $this->user_model->get_detail_rsa_user('99','11');
                                $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');
                                
                                $dokumen_up = $this->rsa_up_model->check_dokumen_up($this->check_session->get_unit(),$this->cur_tahun);
                                
//                                if(($dokumen_up == 'SPP-DRAFT')){
//                                    $subdata['siap_spm'] = 'ok';
//                                }else{
//                                    $subdata['siap_spm'] = 'no_ok';
//                                }
                                
                                $subdata['doc_up'] = $dokumen_up;
                                
                                $subdata['tgl_spp'] = $this->rsa_up_model->get_tgl_spp($this->check_session->get_unit(),$this->cur_tahun);
                                
                                $subdata['tgl_spm'] = $this->rsa_up_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                if($dokumen_up == 'SPP-FINAL'){
                                    $nomor_trx_ = $this->rsa_up_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-UP'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                }else{
                                    $nomor_trx_spm = $this->rsa_up_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                }
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_up_model->get_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $nomor_trx_spp = $this->rsa_up_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun);  
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                           
                                $subdata['ket'] = $this->rsa_up_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
				$data['main_content'] 			= $this->load->view("rsa_up/spm_up",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
                
                function spm_up_kpa(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==2)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_up_model->search_rsa_up();
				$subdata['detail_up'] 			= array(
                                                                                    'nom' => $this->setting_up_model->get_setting_up($this->check_session->get_unit(),$this->cur_tahun),
                                                                                    'terbilang' => $this->convertion->terbilang($this->setting_up_model->get_setting_up($this->check_session->get_unit(),$this->cur_tahun)), 
                                                                                    
                                                                                );
                                $subdata['cur_tahun'] = $this->cur_tahun;
                                $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                $subdata['unit_id'] = $this->check_session->get_unit();
                                $subdata['alias'] = $this->check_session->get_alias();
                                $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
                                
                                $subdata['detail_kuasa_buu']  = $this->user_model->get_detail_rsa_user('99','11');
                                $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');
                                
                                $dokumen_up = $this->rsa_up_model->check_dokumen_up($this->check_session->get_unit(),$this->cur_tahun);
                                
//                                if(($dokumen_up == 'SPP-DRAFT')){
//                                    $subdata['siap_spm'] = 'ok';
//                                }else{
//                                    $subdata['siap_spm'] = 'no_ok';
//                                }
                                
                                $subdata['doc_up'] = $dokumen_up;
                                
                                $subdata['tgl_spp'] = $this->rsa_up_model->get_tgl_spp($this->check_session->get_unit(),$this->cur_tahun);
                                
                                $subdata['tgl_spm'] = $this->rsa_up_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                $nomor_trx_spm = $this->rsa_up_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_up_model->get_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_up_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
				$data['main_content'] 			= $this->load->view("rsa_up/spm_up_kpa",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
                
                function daftar_unit($tahun=''){
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
                    
                    
		
                    /* check session	*/
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['unit_usul'] 		= $this->rsa_up_model->get_up_unit_usul($tahun);
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_up/daftar_unit",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
                
                function daftar_unit_kbuu($tahun=''){
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }

                    /* check session	*/
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['unit_usul'] 		= $this->rsa_up_model->get_up_unit_usul($tahun);
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_up/daftar_unit_kbuu",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
                
                function spm_up_verifikator($kd_unit,$tahun){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_up_model->search_rsa_up();
				$subdata['detail_up'] 			= array(
                                                                                    'nom' => $this->setting_up_model->get_setting_up($kd_unit,$tahun),
                                                                                    'terbilang' => $this->convertion->terbilang($this->setting_up_model->get_setting_up($kd_unit,$tahun)), 
                                                                                    
                                                                                );
                                $subdata['cur_tahun'] = $tahun;
                                $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                $subdata['unit_id'] = $kd_unit ; //$this->check_session->get_unit();
                                $this->load->model('unit_model');
                                $subdata['alias'] = $this->unit_model->get_alias($kd_unit);// $this->check_session->get_alias();
                                $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($kd_unit,'13');
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($kd_unit,'14');
                                $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($kd_unit,'2');
                                
                                $subdata['detail_kuasa_buu']  = $this->user_model->get_detail_rsa_user('99','11');
                                $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');
                                
                                $subdata['kd_unit'] = $kd_unit ;
                                
                                $dokumen_up = $this->rsa_up_model->check_dokumen_up($kd_unit,$tahun);
                                
//                                if(($dokumen_up == 'SPP-DRAFT')){
//                                    $subdata['siap_spm'] = 'ok';
//                                }else{
//                                    $subdata['siap_spm'] = 'no_ok';
//                                }
                                
                                $subdata['doc_up'] = $dokumen_up;
                                
                                $subdata['tgl_spp'] = $this->rsa_up_model->get_tgl_spp($kd_unit,$tahun);
                                
                                $subdata['tgl_spm'] = $this->rsa_up_model->get_tgl_spm($kd_unit,$tahun);
                                
                                $nomor_trx_spm = $this->rsa_up_model->get_nomor_spm($kd_unit,$tahun);  
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $detail_verifikator  = $this->rsa_up_model->get_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                if(!isset($detail_verifikator->nm_lengkap)){
                                    $detail_verifikator = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
                                }
                                
                                $subdata['detail_verifikator']  = $detail_verifikator ;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);
                                
                                
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_up_model->lihat_ket($kd_unit,$tahun);
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
				$data['main_content'] 			= $this->load->view("rsa_up/spm_up_verifikator",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
                
                function spm_up_kbuu($kd_unit,$tahun){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==11)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_up_model->search_rsa_up();
				$subdata['detail_up'] 			= array(
                                                                                    'nom' => $this->setting_up_model->get_setting_up($kd_unit,$this->cur_tahun),
                                                                                    'terbilang' => $this->convertion->terbilang($this->setting_up_model->get_setting_up($kd_unit,$this->cur_tahun)), 
                                                                                    
                                                                                );
                                $this->load->model('unit_model');
                                $subdata['cur_tahun'] = $tahun;
                                $subdata['unit_kerja'] = $this->unit_model->get_nama($kd_unit);//$this->check_session->get_nama_unit();
                                $subdata['unit_id'] = $kd_unit ; //$this->check_session->get_unit();
                                
                                $subdata['alias'] = $this->unit_model->get_alias($kd_unit);// $this->check_session->get_alias();
                                $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($kd_unit,'13');
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($kd_unit,'14');
                                $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($kd_unit,'2');
                                
                                $subdata['detail_kuasa_buu']  = $this->user_model->get_detail_rsa_user('99','11');
                                $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');
                                
                                $subdata['kd_unit'] = $kd_unit ;
                                
                                $dokumen_up = $this->rsa_up_model->check_dokumen_up($kd_unit,$tahun);
                                
//                                if(($dokumen_up == 'SPP-DRAFT')){
//                                    $subdata['siap_spm'] = 'ok';
//                                }else{
//                                    $subdata['siap_spm'] = 'no_ok';
//                                }
                                
                                $subdata['doc_up'] = $dokumen_up;
                                
                                $subdata['tgl_spp'] = $this->rsa_up_model->get_tgl_spp($kd_unit,$tahun);
                                
                                $subdata['tgl_spm'] = $this->rsa_up_model->get_tgl_spm($kd_unit,$tahun);
                                
                                $nomor_trx_spm = $this->rsa_up_model->get_nomor_spm($kd_unit,$tahun);  
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_up_model->get_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_up_model->lihat_ket($kd_unit,$tahun);
                                
                                $this->load->model('akun_kas6_model');
                                
                                $subdata['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();//(array('kd_kas_3'=>'111'));
                                
//                                var_dump( $subdata['kas_undip']);die;
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
				$data['main_content'] 			= $this->load->view("rsa_up/spm_up_kbuu",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
                
                function cetak_spp(){
                    
                    if($this->input->post('dtable')){
                        $html = base64_decode($this->input->post('dtable'));
                        $unit = $this->input->post('dunit');
                        $tahun = $this->input->post('dtahun');
//                        echo $html;die;
//                        $h = $this->load->view("rsa_up/cetak",array('html'=>$html),TRUE);
//                        echo $h;
                        $this->load->library('Pdfgen'); 
                        $this->pdfgen->cetak($html,'SPP_UP_'.$unit.'_'.''.$tahun);
                    }
                    
//                    $this->PdfGen->filename('test.pdf');
//                    $this->PdfGen->paper('a4', 'portrait');
//
//                    //Load html view
//                    $this->PdfGen->html("<h1>Some Title</h1><p>Some content in here</p>");
//                    $this->PdfGen->create('save');
                }
                
                function cetak_spm(){
                    
                    if($this->input->post('dtable_2')){
                        $html = base64_decode($this->input->post('dtable_2'));
                        $unit = $this->input->post('unit');
                        $tahun = $this->input->post('tahun');
//                        echo $html;die;
                        $this->load->library('Pdfgen'); 
                        $this->pdfgen->cetak($html,'SPM_UP_'.$unit.'_'.''.$tahun);
                    }
                }
                
                function usulkan_spp_up(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $bulan = $nomor_[3];
                        $jenis = $this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                        
                        $data = array(
                            'kode_unit_subunit' => $kd_unit,
                            'nomor_trx' => $nomor_[0],
                            'str_nomor_trx' => $nomor_trx,
                            'jenis' => $jenis,
                            'tgl_proses' => date("Y-m-d H:i:s"),
                            'aktif' => '1',
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                        );
                        
                        $data_spp = array(
                            'kd_unit_subunit' => $kd_unit,
                            'str_nomor_trx' => $nomor_trx,
                            'jumlah_bayar' => $this->input->post('jumlah_bayar'),
                            'untuk_bayar' => $this->input->post('untuk_bayar'),
                            'penerima' => $this->input->post('penerima'),
                            'alamat' => $this->input->post('alamat'),
                            'nmbank' => $this->input->post('nmbank'),
                            'rekening' => $this->input->post('rekening'),
                            'npwp' => $this->input->post('npwp'),
                            'tahun' => $tahun,
                            'nmbendahara' => $this->input->post('nmbendahara'),
                            'nipbendahara' => $this->input->post('nipbendahara'),
                            'tgl_spp' => date("Y-m-d H:i:s"),
                        );
                        
                        var_dump($data_spp);die;
                        
                        if($this->rsa_up_model->proses_nomor_spp_up($kd_unit,$data) && $this->rsa_up_model->proses_data_spp($data_spp)){
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );
                            
//                            var_dump($data);die;

                            if($this->rsa_up_model->proses_up($kd_unit,$data)){
                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM UP anda berhasil disubmit.</div>');
                                echo "sukses";
                            }else{
                                echo "gagal";
                            }
                            
                        }else{
                            echo "gagal";
                        }
                        
                        
                    }
                }
                
                function usulkan_spm_up(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_trx_spp = $this->input->post('nomor_trx_spp');
                        $nomor_ = explode('/',$nomor_trx);
                        $bulan = $nomor_[3];
                        
                        $nomor_spp_ = explode('/',$nomor_trx_spp);
                        
                        
                        $jenis = $this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                        
                        $data = array(
                            'kode_unit_subunit' => $kd_unit,
                            'nomor_trx' => $nomor_[0],
                            'str_nomor_trx' => $nomor_trx,
                            'jenis' => $jenis,
                            'tgl_proses' => date("Y-m-d H:i:s"),
                            'aktif' => '1',
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            
                        );
                        
                        $data_spp_spm = array(
                            'kd_unit_subunit' => $kd_unit,
                            'nomor_trx_spp' => $nomor_spp_[0],
                            'nomor_trx_spm' => $nomor_[0],
                            'jenis_trx' => 'UP',
                            'tgl_proses' => date("Y-m-d H:i:s"),
                            'tahun' => $tahun,
                        );
                        
//                        var_dump($data);die;
                        
                        if($this->rsa_up_model->proses_nomor_spm_up($kd_unit,$data) && $this->rsa_up_model->proses_trx_spp_spm($data_spp_spm)){
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );
                            
//                            var_dump($data);die;

                            if($this->rsa_up_model->proses_up($kd_unit,$data)){
                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM UP anda berhasil disubmit.</div>');
                                echo "sukses";
                            }else{
                                echo "gagal";
                            }
                            
                        }else{
                            echo "gagal";
                        }
                        
                        
                    }
                }
                
                function proses_spp_up(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $jenis = $this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                        
                        
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );
                            
//                            var_dump($data);die;

                            if($this->rsa_up_model->proses_up($kd_unit,$data)){
                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM UP anda berhasil disubmit.</div>');
                                echo "sukses";
                            }else{
                                echo "gagal";
                            }

                        
                        
                    }
                }
                
                function proses_spm_up(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $jenis = $this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                        
                        
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );
                            
//                            var_dump($data);die;

                            if($this->rsa_up_model->proses_up($kd_unit,$data)){
                                if($this->check_session->get_level() == 3){
                                    $verifikator = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
                                    
                                    $data_verifikator = array(
                                        'nomor_trx_spm' => $nomor_[0],
                                        'kode_unit_subunit' => $kd_unit,
                                        'jenis_trx' => 'UP',
                                        'id_rsa_user_verifikator' => $verifikator->id,
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );
                                    if($this->rsa_up_model->proses_verifikator_up($data_verifikator)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM UP anda berhasil disubmit.</div>');
                                        echo "sukses";
                                    }else{
                                        echo "gagal";
                                    }
                                }else{
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM UP anda berhasil disubmit.</div>');
                                    echo "sukses";
                                }
                            }else{
                                echo "gagal";
                            }

                        
                        
                    }
                }
                
                function proses_final_up(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx_spm = $this->input->post('nomor_trx');
                        $nomor_ = explode('/', $nomor_trx_spm);
                        $nomor = (int)$nomor_[0] ;
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->input->post('kd_unit');
                        $data = array(
                            'kode_unit_subunit' => $kd_unit,
                            'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up('SPM',$kd_unit,$this->input->post('tahun')),
                            'posisi' => $proses,
                            'ket' => $ket,
                            'aktif' => '1',
                            'tahun' => $this->input->post('tahun'),
                            'tgl_proses' => date("Y-m-d H:i:s")
                        );
                        
                        if($this->rsa_up_model->proses_up($kd_unit,$data)){
                            
                            $data = array(
                                'tgl_trx' => date("Y-m-d H:i:s"),
                                'kd_akun_kas' => '112111',
                                'kd_unit' => $kd_unit,
                                'deskripsi' => $this->input->post('deskripsi'),
                                'no_spm' => $this->input->post('nomor_trx'),
                                'kredit' => '0',
                                'debet' => $this->input->post('kredit'),
                                'saldo' => $this->input->post('kredit'),
                                'aktif' => '1',
                                'tahun' => $this->input->post('tahun'),
                            );
                            
                            $this->load->model('kas_undip_model');
                            $kd_akun_kas = $this->input->post('kd_akun_kas') ;
                            $nominal = $this->input->post('nominal') ;
                            $saldo = $this->kas_undip_model->get_nominal($kd_akun_kas) - $nominal ;
                            
                            $data_kas = array(
                                'tgl_trx' => date('Y-m-d H:i:s'),
                                'kd_akun_kas' => $kd_akun_kas,
                                'kd_unit' => '99',
                                'deskripsi' => 'ISI UP UNIT ' . $kd_unit,
                                'no_spm' => '-',
                                'debet' => '0',
                                'kredit' => $nominal,
                                'saldo' => $saldo,
                                'aktif' => '1',
                                'tahun' => $this->input->post('tahun'),
                            );
                            
                            $data_spm_cair = array(
                                'no_urut' => $this->rsa_up_model->get_next_urut_spm_cair($this->input->post('tahun')),
                                'no_trx_spm' => $nomor,
                                'kode_unit_subunit' => $kd_unit,
                                'jenis_trx' => 'UP',
                                'tgl_proses' => date('Y-m-d H:i:s'),
                                'bulan' => $nomor_[3],
                                'tahun' => $this->input->post('tahun')
                            );

//                            var_dump($data_spm_cair);die;
                            
                            if($this->rsa_up_model->final_up($kd_unit,$data) && $this->kas_undip_model->isi_trx($data_kas) && $this->rsa_up_model->spm_cair($data_spm_cair)){
                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM UP anda berhasil disubmit.</div>');
                                echo "sukses";
                            }else{
                                echo "gagal";
                            }
                        }else{
                            echo "gagal";
                        }
                    }
                }
		
		//define method exec_add_unit()
		//execute add data unit
		function exec_add_rsa_up(){

			if($this->input->post()){

				if($this->check_session->user_session() && $this->check_session->get_level()==2){
				
						// get kode otomatis
						// $top_unit = $this->master_unit_model->get_unit('',array('kode_unit !=' => '99'),'kode_unit DESC',1);

						// if(count($top_unit)>0) $top_unit=$top_unit[0];

						// $kode = strlen(($top_unit->kode_unit+1)+"")==1?"0".($top_unit->kode_unit+1):$top_unit->kode_unit+1;
                                        if($this->input->post()){
											
                                            $this->form_validation->set_rules('no_up','no_up','required|min_length[2]|callback_check_exist_rsa_up');
											$this->form_validation->set_rules('kode_unit_kepeg','Kode Unit Kepegawaian','required');
											$this->form_validation->set_rules('tgl_transaksi','tgl_transaksi','required');
											$this->form_validation->set_rules('kd_transaksi','kd_transaksi','required');
											$this->form_validation->set_rules('debet','Debit','required');
											$this->form_validation->set_rules('kepada','kepada','required');
											$this->form_validation->set_rules('bendahara_bp','bendahara_bp','required');
											$this->form_validation->set_rules('alamat','Alamat','required');
											$this->form_validation->set_rules('no_rek','Nomor rekening','required');
											$this->form_validation->set_rules('npwp','NPWP','required');
                                            if ($this->form_validation->run()){
                                                $data = array(
												
												'no_up' => form_prep($this->input->post('no_up')),
												'kode_unit_kepeg' => form_prep($this->input->post('kode_unit_kepeg')),
												'tgl_transaksi' => form_prep($this->input->post('tgl_transaksi')),
												'kd_transaksi' => form_prep($this->input->post('kd_transaksi')),
												'debet' => form_prep($this->input->post('debet')),
												'kepada' => form_prep($this->input->post('kepada')),
												'bendahara_bp' => form_prep($this->input->post('bendahara_bp')),
												'alamat' => form_prep($this->input->post('alamat')),
												'no_rek' => form_prep($this->input->post('no_rek')),
												'npwp' => form_prep($this->input->post('npwp')),
												
						);
							                    $this->rsa_up_model->add_rsa_up($data);
                                                echo "berhasil";
                                                
                                            }else{
                                                    echo validation_errors();

                                            }
                                
                                        }
						
						
				}
				else{
					show_404('page');
				}

			}


		}		
		
		//define method get_form_edit()
		//get form for edit unit
		function get_form_edit(){
			if($this->check_session->user_session() && $this->check_session->get_level()==1){
				$kode_unit 	= form_prep($this->input->post('kode_unit'));
				$data['result_unit'] = $this->unit_model->get_unit($kode_unit);
				$this->load->view('form_edit_unit_',$data);
			}
			else{
				show_404('page');
			}
		}
		
		//define method exec_edit_unit()
		//execute edit process
		function exec_edit_unit(){
			if($this->check_session->user_session() && $this->check_session->get_level()==1){
				$kode_unit = form_prep($this->input->post('kode_unit'));
				$nama_unit = form_prep($this->input->post('nama_unit'));
				$data_edit = array(
					'nama_unit' => $nama_unit,
				);
				$this->unit_model->edit_unit($data_edit,$kode_unit);
				$data['result_unit'] = $this->unit_model->get_unit($kode_unit);
				$this->load->view('row_unit_',$data);
			}
			else{
				show_404('page');
			}
		}
		
		//define method confirmation_delete()
		//call confirmation before delete unit
		function confirmation_delete(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				if($this->uri->segment(3)!='99'){ //jika bukan user pusat
					$data['url']		= site_url('rsa_up/exec_delete/'.$this->uri->segment(3));
					$data['message']	= "Apakah anda yakin akan menghapus data ini ( kode : ".$this->uri->segment(3).") ?";
					$this->load->view('confirmation_',$data);
				}else{ //jika user pusat
					$data['class']	 = 'option box';
					$data['class_btn']	 = 'ya';
					$data['message'] = 'Unit pusat tidak diijinkan untuk dihapus';
					$this->load->view('messagebox_',$data);
				}
			}
			else{
				show_404('page');
			}
		}
		
		//define method exec_delete()
		//execute delete process
		function exec_delete(){
			print_r($this->uri->segment(3));die;
		if($this->check_session->user_session() && $this->check_session->get_level()==100){
			if($this->uri->segment(3)){
				if($this->rsa_up_model->delete_rsa_up(array('no'=>$this->uri->segment(3)))){
					$data['class']	 = 'option box';
					$data['class_btn']	 = 'ya';
					$data['message'] = 'Data berhasil dihapus';
				}else{
					$data['class']	 = 'boxerror';
					$data['class_btn']	 = 'tidak';
					$data['message'] = 'Data gagal dihapus';
				}
			}else{
				$data['class']	 = 'boxerror';
				$data['class_btn']	 = 'tidak';
				$data['message'] = 'Tidak ada data yang dihapus';
			}
			$this->load->view('messagebox_',$data);
		}else{
			show_404('page');
		}
	}
		
		//define method get_row_unit()
		//this method for refresh list unit
		function get_row_rsa_up(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				$data['result_rsa_up'] = $this->rsa_up_model->get_rsa_up();
				$this->load->view('rsa_up/row_rsa_up',$data);
			}
			else{
				show_404('page');
			}
		}
		
		//define search_unit()
		//this method for search unit
		function filter_rsa_up(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				$keyword = form_prep($this->input->post('keyword'));
				$data['result_rsa_up'] = $this->rsa_up_model->search_rsa_up($keyword);
				$this->load->view('rsa_up/row_rsa_up',$data);
			}
			else{
				show_404('page');
			}
                        
                        
		}
                
               function check_exist_rsa_up($no_up){

                        $this->form_validation->set_message('check_exist_rsa_up', 'Maaf, kode RSA tsb sudah terdaftar');

                        $result = $this->rsa_up_model->get_rsa_up($no_up);

                        if(empty($result)){
                                return true;
                        }
                        else{
                                return false;
                        }

                }
                function check_exist_rba_unit($kode_unit_rba){

                        $this->form_validation->set_message('check_exist_rba_unit', 'Maaf, kode RBA Unit tsb sudah terdaftar');

                        $result = $this->rsa_up_model->get_rsa_up($kode_unit_rba);

                        if(empty($result)){
                                return true;
                        }
                        else{
                                return false;
                        }

                }
                
                
                function saldo($tahun=''){
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
                    
                    
		
                    /* check session	*/
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['unit_usul'] 		= $this->rsa_up_model->get_up_unit($tahun);
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_up/saldo",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
                
                function daftar_spp($tahun="",$kode_unit_subunit=""){
                    
                    if($kode_unit_subunit == ''){
                        $kode_unit_subunit = $this->check_session->get_unit();
                    }
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }

                    /* check session	*/
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
                            $subdata['daftar_spp']          = $this->rsa_ks_model->get_daftar_spp($kode_unit_subunit,$tahun);
//                            echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("rsa_ks/daftar_spp",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
                
		
	}

?>
