<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class rsa_tambah_em extends CI_Controller{
/* -------------- Constructor ------------- */
            
    private $cur_tahun;
	public function __construct(){ 
		parent::__construct();
			//load library, helper, and model
                $this->cur_tahun = $this->setting_model->get_tahun();
			$this->load->library(array('form_validation','option'));
			$this->load->helper('form');
			$this->load->model(array('rsa_tambah_em_model'));//,'setting_up_model'));
			$this->load->model("user_model");
            $this->load->model("unit_model");
            $this->load->model('menu_model');
			$this->load->helper("security");
                        

		}
		
		#methods ======================
		
		//define method index()
		function index(){
			$data['cur_tahun'] = $this->cur_tahun ;
                
                        $data['main_content']	= $this->load->view('rsa_tambah_em/index','',TRUE);
                        // $data['main_menu']	= $this->load->view('form_login','',TRUE);
                        $list["menu"] = $this->menu_model->show();
                        $list["submenu"] = $this->menu_model->show();
                        $data['main_menu']	= $this->load->view('main_menu','',TRUE);
//                        $data['message']	= validation_errors();
                        $this->load->view('main_template',$data);
		}
		
		//define method daftar_unit()
		function daftar_rsa_tambah_em(){
			if($this->check_session->user_session() && $this->check_session->get_level()==2){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				$subdata_rsa_tambah_em['result_rsa_tambah_em'] 		= $this->rsa_tambah_em_model->search_rsa_tambah_em();
				$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
				$subdata['row_rsa_tambah_em'] 			= $this->load->view("rsa_tambah_em/row_rsa_tambah_em",$subdata_rsa_tambah_em,TRUE);
				$data['main_content'] 			= $this->load->view("rsa_tambah_em/daftar_rsa_tambah_em",$subdata,TRUE);
				$this->load->view('main_template',$data);
			}
			else{
				redirect('home','refresh');	// redirect ke halaman home
			}		
		}
		function input_rsa_tambah_em(){
			if($this->check_session->user_session() && $this->check_session->get_level()==13){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_tambah_em['result_rsa_tambah_em'] 		= $this->rsa_tambah_em_model->search_rsa_tambah_em();
				//$subdata['row_rsa_tambah_em'] 			= $this->load->view("rsa_tambah_em/row_rsa_tambah_em",$subdata_rsa_tambah_em,TRUE);
				$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
				$data['main_content'] 			= $this->load->view("rsa_tambah_em/input_rsa_tambah_em",$subdata,TRUE);
				$this->load->view('main_template',$data);
			}
			else{
				redirect('home','refresh');	// redirect ke halaman home
			}		
		}
                
                function spp_tambah_em(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){
				//set data for main template

                        // if($urut_spp == ""){
                        //     $urut_spp = '1' ;
                        // }

				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_tambah_em['result_rsa_tambah_em'] 		= $this->rsa_tambah_em_model->search_rsa_tambah_em();


                $id_max_nomor_tambah_em = $this->rsa_tambah_em_model->get_nomor_spp_urut($this->check_session->get_unit(),$this->cur_tahun) ;

                $id_max_nomor_tambah_em = $id_max_nomor_tambah_em + 1 ;

                // echo  $id_max_nomor_tambah_em; die;
                                
                                $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($this->check_session->get_unit(),$this->cur_tahun,$id_max_nomor_tambah_em);
                               
                               // echo $dokumen_tambah_em ; die ;

                                if(strlen($this->check_session->get_unit())==2){
                                    $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                    $subdata['unit_id'] = $this->check_session->get_unit();
                                    $subdata['alias'] = $this->check_session->get_alias();
                                }
                                elseif(strlen($this->check_session->get_unit())==4){
                                        $subdata['unit_kerja'] = $this->unit_model->get_nama($this->check_session->get_unit()) . ' - ' . $this->unit_model->get_real_nama($this->check_session->get_unit());//$this->check_session->get_nama_unit();
                                        $subdata['unit_id'] = $this->check_session->get_unit();
                                        $subdata['alias'] = $this->unit_model->get_alias($this->check_session->get_unit());
                                }
                                if(($dokumen_tambah_em == '')||($dokumen_tambah_em == 'SPP-DITOLAK')||($dokumen_tambah_em == 'SPM-DITOLAK-KPA')||($dokumen_tambah_em == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_tambah_em == 'SPM-DITOLAK-KBUU')){
                                    $subdata['detail_tambah_em'] 	= array(
                                                                    'nom' => '0',
                                                                    'terbilang' => $this->convertion->terbilang('0'), 

                                                                );
                                    $subdata['cur_tahun'] = $this->cur_tahun;
                                    $rsa_user = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'penerima' => $rsa_user->nm_lengkap,
                                        'alamat_penerima' => $rsa_user->alamat,
                                        'nama_bank_penerima' => $rsa_user->nama_bank,
                                        'no_rek_penerima' => $rsa_user->no_rek,
                                        'npwp_penerima' => $rsa_user->npwp,
                                        'nmbendahara' => $rsa_user->nm_lengkap,
                                        'nipbendahara' => $rsa_user->nomor_induk,
//                                        'tgl_spp' => $rsa_user->tgl_spp,
                                    );
//                                    var_dump($rsa_user);
//                                    echo "<br />";
//                                    echo "<br />";
//                                    echo "<br />";
//                                    var_dump($subdata['detail_pic']);die;



    //                                if(($dokumen_tambah_em == '') || ($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $this->rsa_tambah_em_model->get_tgl_spp($this->check_session->get_unit(),$this->cur_tahun);

                                    $nomor_trx_ = $this->rsa_tambah_em_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");  
                                    $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-EM'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                
                                }else{
                                    $nomor_trx = $this->rsa_tambah_em_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 
                                    $data_spp = $this->rsa_tambah_em_model->get_data_spp($nomor_trx);
                                    $subdata['detail_tambah_em'] 	= array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    $subdata['cur_tahun'] = $data_spp->tahun;
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_tambah_em == '') || ($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                }

                                $subdata['id_nomor_tambah_em'] = $id_max_nomor_tambah_em ;
                                
                                $subdata['doc_tambah_em'] = $dokumen_tambah_em;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['ket'] = $this->rsa_tambah_em_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                
//                                $urut_spp_pup = $this->rsa_tambah_em_model->get_urut($this->check_session->get_unit(),'SPP',$this->cur_tahun);
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata['detail_pic']);die;
				$data['main_content'] 			= $this->load->view("rsa_tambah_em/spp_tambah_em",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }

                function spumk_tambah_em(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==4)||($this->check_session->get_level()==100))){
                //set data for main template

                        // if($urut_spp == ""){
                        //     $urut_spp = '1' ;
                        // }

                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                //$subdata_rsa_tambah_em['result_rsa_tambah_em']        = $this->rsa_tambah_em_model->search_rsa_tambah_em();


                $id_max_nomor_tambah_em = $this->rsa_tambah_em_model->get_nomor_spp_urut($this->check_session->get_unit(),$this->cur_tahun) ;

                $id_max_nomor_tambah_em = $id_max_nomor_tambah_em + 1 ;

                // echo  $id_max_nomor_tambah_em; die;
                                
                                $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($this->check_session->get_unit(),$this->cur_tahun,$id_max_nomor_tambah_em);
                               
                               // echo $dokumen_tambah_em ; die ;

                                if(strlen($this->check_session->get_unit())==2){
                                    $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                    $subdata['unit_id'] = $this->check_session->get_unit();
                                    $subdata['alias'] = $this->check_session->get_alias();
                                }
                                elseif(strlen($this->check_session->get_unit())==4){
                                        $subdata['unit_kerja'] = $this->unit_model->get_nama($this->check_session->get_unit()) . ' - ' . $this->unit_model->get_real_nama($this->check_session->get_unit());//$this->check_session->get_nama_unit();
                                        $subdata['unit_id'] = $this->check_session->get_unit();
                                        $subdata['alias'] = $this->unit_model->get_alias($this->check_session->get_unit());
                                }
                                if(($dokumen_tambah_em == '')||($dokumen_tambah_em == 'SPP-DITOLAK')||($dokumen_tambah_em == 'SPM-DITOLAK-KPA')||($dokumen_tambah_em == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_tambah_em == 'SPM-DITOLAK-KBUU')){
                                    $subdata['detail_tambah_em']    = array(
                                                                    'nom' => '0',
                                                                    'terbilang' => $this->convertion->terbilang('0'), 

                                                                );
                                    $subdata['cur_tahun'] = $this->cur_tahun;
                                    $rsa_user = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'penerima' => $rsa_user->nm_lengkap,
                                        'alamat_penerima' => $rsa_user->alamat,
                                        'nama_bank_penerima' => $rsa_user->nama_bank,
                                        'no_rek_penerima' => $rsa_user->no_rek,
                                        'npwp_penerima' => $rsa_user->npwp,
                                        'nmbendahara' => $rsa_user->nm_lengkap,
                                        'nipbendahara' => $rsa_user->nomor_induk,
//                                        'tgl_spp' => $rsa_user->tgl_spp,
                                    );
//                                    var_dump($rsa_user);
//                                    echo "<br />";
//                                    echo "<br />";
//                                    echo "<br />";
//                                    var_dump($subdata['detail_pic']);die;



    //                                if(($dokumen_tambah_em == '') || ($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $this->rsa_tambah_em_model->get_tgl_spp($this->check_session->get_unit(),$this->cur_tahun);

                                    $nomor_trx_ = $this->rsa_tambah_em_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");  
                                    $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-KS'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                
                                }else{
                                    $nomor_trx = $this->rsa_tambah_em_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 
                                    $data_spp = $this->rsa_tambah_em_model->get_data_spp($nomor_trx);
                                    $subdata['detail_tambah_em']    = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    $subdata['cur_tahun'] = $data_spp->tahun;
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_tambah_em == '') || ($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                }

                                $subdata['id_nomor_tambah_em'] = $id_max_nomor_tambah_em ;
                                
                                $subdata['doc_tambah_em'] = $dokumen_tambah_em;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['ket'] = $this->rsa_tambah_em_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                
//                                $urut_spp_pup = $this->rsa_tambah_em_model->get_urut($this->check_session->get_unit(),'SPP',$this->cur_tahun);
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata['detail_pic']);die;
                $data['main_content']           = $this->load->view("rsa_tambah_em/spumk_tambah_em",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }


                function spp_tambah_em_lihat($url = ''){


                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){


                        $url = urldecode($url);

                            if( base64_encode(base64_decode($url, true)) === $url){
                                $url = base64_decode($url);
                            }else{
                                redirect(site_url('/'));
                            }


                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       



                                $nomor_trx_spp = $url ;
                                
                                
                                $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em_by_str_trx($nomor_trx_spp);


                                // echo $dokumen_tambah_em ; die;

                                if(strlen($this->check_session->get_unit())==2){
                                    $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                    $subdata['unit_id'] = $this->check_session->get_unit();
                                    $subdata['alias'] = $this->check_session->get_alias();
                                }
                                elseif(strlen($this->check_session->get_unit())==4){
                                        $subdata['unit_kerja'] = $this->unit_model->get_nama($this->check_session->get_unit()) . ' - ' . $this->unit_model->get_real_nama($this->check_session->get_unit());//$this->check_session->get_nama_unit();
                                        $subdata['unit_id'] = $this->check_session->get_unit();
                                        $subdata['alias'] = $this->unit_model->get_alias($this->check_session->get_unit());
                                }

                                $array_id = '';
                                $pengeluaran = 0;
                                
                                $tgl_ok = false ;


                                    $nomor_trx = $nomor_trx_spp ;

                                    $data_spp = $this->rsa_tambah_em_model->get_data_spp($nomor_trx);

                                    
                                    $subdata['detail_tambah_em']  = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    $subdata['cur_tahun'] = $data_spp->tahun;
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_gup == '') || ($dokumen_gup == 'SPP-DITOLAK') || ($dokumen_gup == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 
                                    
                                    

                                $subdata['doc_tambah_em'] = $dokumen_tambah_em;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                // $subdata['ket'] = $this->rsa_tambah_em_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                $subdata['ket'] = $this->rsa_tambah_em_model->lihat_ket_by_nomor_trx($nomor_trx);
//                                echo $subdata['tgl_spp'];die;
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata['detail_pic']);die;
                                
//                                var_dump($subdata);die;
                                
                $data['main_content']           = $this->load->view("rsa_tambah_em/spp_tambah_em",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }
                
                function spm_tambah_em($url = ''){


                    if(1){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_tambah_em['result_rsa_tambah_em'] 		= $this->rsa_tambah_em_model->search_rsa_tambah_em();
//				$subdata['detail_tambah_em'] 			= array(
//                                                                                    'nom' => $this->setting_tambah_em_model->get_setting_tambah_em($this->check_session->get_unit(),$this->cur_tahun),
//                                                                                    'terbilang' => $this->convertion->terbilang($this->setting_tambah_em_model->get_setting_tambah_em($this->check_session->get_unit(),$this->cur_tahun)), 
//                                                                                    
//                                                                                );

                                $url = urldecode($url);

                                $url = base64_decode($url);

                                $str_nomor_trx_spp = $url ;

                                // echo  $str_nomor_trx_spp; die;

                                $id_nomor_tambah_em = $this->rsa_tambah_em_model->get_nomor_spp_urut_by_nomor_spp($str_nomor_trx_spp) ;

                                // echo  $id_nomor_tambah_em; die;
                                
                                $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($this->check_session->get_unit(),$this->cur_tahun,$id_nomor_tambah_em);

                                // echo  $dokumen_tambah_em; die;


                                $subdata['cur_tahun'] = $this->cur_tahun;

                                if(strlen($this->check_session->get_unit())==2){
                                    $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                    $subdata['unit_id'] = $this->check_session->get_unit();
                                    $subdata['alias'] = $this->check_session->get_alias();
                                }
                                elseif(strlen($this->check_session->get_unit())==4){
                                        $subdata['unit_kerja'] = $this->unit_model->get_nama($this->check_session->get_unit()) . ' - ' . $this->unit_model->get_real_nama($this->check_session->get_unit());//$this->check_session->get_nama_unit();
                                        $subdata['unit_id'] = $this->check_session->get_unit();
                                        $subdata['alias'] = $this->unit_model->get_alias($this->check_session->get_unit());
                                }
//                                $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                
                                
                                // $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($this->check_session->get_unit(),$this->cur_tahun);

                                $subdata['doc_tambah_em'] = $dokumen_tambah_em;
                                
//                                $subdata['tgl_spm'] = $this->rsa_tambah_em_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_tambah_em_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spp = $str_nomor_trx_spp ;
                                
                               // echo $nomor_trx_spp ;die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '',
                                    'terbilang' => '',
                                    'untuk_bayar' => '',
                                    'penerima' => '',
                                    'alamat' => '',
                                    'nmbank' => '',
                                    'rekening' => '',
                                    'npwp' => '',
                                    'nmbendahara' => '',
                                    'nipbendahara' => '',
                                    'tgl_spp' => ''
                                );
                                // SPP

                                
                                if(($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK-KPA') || ($dokumen_tambah_em == 'SPP-FINAL') || ($dokumen_tambah_em == 'SPP-DRAFT') || ($dokumen_tambah_em == 'SPM-DRAFT-PPK') || ($dokumen_tambah_em == 'SPM-DRAFT-KPA') || ($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tambah_em == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_tambah_em_model->get_data_spp($nomor_trx_spp);
                                   // var_dump($data_spp);die;
                                    $subdata['detail_tambah_em']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_tambah_em == '') || ($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }
//                                    echo $data_spp->tgl_spp; die
                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                if(($dokumen_tambah_em == 'SPM-DITOLAK-KPA') || ($dokumen_tambah_em == 'SPM-DRAFT-PPK') || ($dokumen_tambah_em == 'SPM-DRAFT-KPA') || ($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tambah_em == 'SPM-FINAL-KBUU')){
                                    
                                    // $nomor_trx_spm = $this->rsa_tambah_em_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  

                                     $id_nomor_tambah_em_spm = $this->rsa_tambah_em_model->get_nomor_spm_urut_by_nomor_spp($nomor_trx_spp) ;
                                    
                                    $nomor_trx_spm = $this->rsa_tambah_em_model->get_nomor_spm_by_id($id_nomor_tambah_em_spm);  
                                    
                                    $data_spm = $this->rsa_tambah_em_model->get_data_spm($nomor_trx_spm);
                                    $subdata['detail_spm_tambah_em'] 	= array(
                                                                    'nom' => $data_spm->jumlah_bayar,
                                                                    'terbilang' => $data_spm->terbilang, 

                                                                );
                                    
                                    $subdata['detail_ppk']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmppk,
                                        'nomor_induk' => $data_spm->nipppk
                                    );
                                    $subdata['detail_kpa']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkpa,
                                        'nomor_induk' => $data_spm->nipkpa
                                    );
                                    $subdata['detail_verifikator']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmverifikator,
                                        'nomor_induk' => $data_spm->nipverifikator
                                    );
                                    $subdata['detail_kuasa_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkbuu,
                                        'nomor_induk' => $data_spm->nipkbuu
                                    );
                                    $subdata['detail_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmbuu,
                                        'nomor_induk' => $data_spm->nipbuu
                                    );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_spm_pic']  = (object) array(
                                        'untuk_bayar' => $data_spm->untuk_bayar,
                                        'penerima' => $data_spm->penerima,
                                        'alamat_penerima' => $data_spm->alamat,
                                        'nama_bank_penerima' => $data_spm->nmbank,
                                        'no_rek_penerima' => $data_spm->rekening,
                                        'npwp_penerima' => $data_spm->npwp,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );

                                    $subdata['cur_tahun_spm'] = $data_spm->tahun;
                                    $subdata['tgl_spm'] = $data_spm->tgl_spm;
                                     
                                }else{
                                    
                                    $nomor_trx_ = $this->rsa_tambah_em_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-KS'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    
//                                    echo $nomor_trx_spp ; die;
                                    
//                                    $data_spp = $this->rsa_tambah_em_model->get_data_spp($nomor_trx_spp);
                                    $subdata['detail_spm_tambah_em'] 	= array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    
                                    $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                    $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
                                    $subdata['detail_verifikator']  = $this->rsa_tambah_em_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
                                    $subdata['detail_kuasa_buu']  = $this->user_model->get_detail_rsa_user('99','11');
                                    $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');
                                    
                                    $subdata['detail_spm_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );

                                    $subdata['cur_tahun_spm'] = $this->cur_tahun;
                                    $subdata['tgl_spm'] = '';

    //                                if(($dokumen_tambah_em == '') || ($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

//                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                }

                                $subdata['id_nomor_tambah_em'] = $id_nomor_tambah_em ;
                                
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_tambah_em_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_tambah_em_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_tambah_em_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                // $subdata['ket'] = $this->rsa_tambah_em_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                // echo $this->rsa_tambah_em_model->lihat_ket_by_nomor_trx($nomor_trx_spp); die ;
                                $subdata['ket'] = $this->rsa_tambah_em_model->lihat_ket_by_nomor_trx($nomor_trx_spp);
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
				$data['main_content'] 			= $this->load->view("rsa_tambah_em/spm_tambah_em",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
                
                function spm_tambah_em_kpa($url = ''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==2)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_tambah_em['result_rsa_tambah_em'] 		= $this->rsa_tambah_em_model->search_rsa_tambah_em();


                                $url = urldecode($url);

                                if( base64_encode(base64_decode($url, true)) === $url){
                                    $url = base64_decode($url);
                                }else{
                                    redirect(site_url('/'));
                                }

                                $str_nomor_trx_spp = $url ;

                                // echo  $str_nomor_trx_spp; die;

                                $id_nomor_tambah_em = $this->rsa_tambah_em_model->get_nomor_spp_urut_by_nomor_spp($str_nomor_trx_spp) ;

                                // echo  $id_nomor_tambah_em; die;
                                
                                $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($this->check_session->get_unit(),$this->cur_tahun,$id_nomor_tambah_em);

                                // echo  $dokumen_tambah_em; die;
				
                                $subdata['cur_tahun'] = $this->cur_tahun;
                                if(strlen($this->check_session->get_unit())==2){
                                    $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                    $subdata['unit_id'] = $this->check_session->get_unit();
                                    $subdata['alias'] = $this->check_session->get_alias();
                                }
                                elseif(strlen($this->check_session->get_unit())==4){
                                        $subdata['unit_kerja'] = $this->unit_model->get_nama($this->check_session->get_unit()) . ' - ' . $this->unit_model->get_real_nama($this->check_session->get_unit());//$this->check_session->get_nama_unit();
                                        $subdata['unit_id'] = $this->check_session->get_unit();
                                        $subdata['alias'] = $this->unit_model->get_alias($this->check_session->get_unit());
                                }
                                
                                // $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($this->check_session->get_unit(),$this->cur_tahun,$id_nomor_tambah_em);

                                $subdata['doc_tambah_em'] = $dokumen_tambah_em;
                                
                                $nomor_trx_spp = $str_nomor_trx_spp ; // $this->rsa_tambah_em_model->get_nomor_spp_by_id($id_nomor_tambah_em); 
                                
                                // echo $nomor_trx_spp ; die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '',
                                    'terbilang' => '',
                                    'untuk_bayar' => '',
                                    'penerima' => '',
                                    'alamat' => '',
                                    'nmbank' => '',
                                    'rekening' => '',
                                    'npwp' => '',
                                    'nmbendahara' => '',
                                    'nipbendahara' => '',
                                    'tgl_spp' => ''
                                );
                                // SPP
                                
                                if(($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK-KPA') || ($dokumen_tambah_em == 'SPP-FINAL') || ($dokumen_tambah_em == 'SPP-DRAFT') || ($dokumen_tambah_em == 'SPM-DRAFT-PPK') || ($dokumen_tambah_em == 'SPM-DRAFT-KPA') || ($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tambah_em == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_tambah_em_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    $subdata['detail_tambah_em']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_tambah_em == '') || ($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
//                                $subdata['tgl_spm'] = $this->rsa_tambah_em_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                $nomor_trx_spm = '';
                                
                                if(($dokumen_tambah_em == 'SPM-DITOLAK-KPA') || ($dokumen_tambah_em == 'SPM-DRAFT-PPK') || ($dokumen_tambah_em == 'SPM-DRAFT-KPA') || ($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tambah_em == 'SPM-FINAL-KBUU')){

                                    $id_nomor_tambah_em_spm = $this->rsa_tambah_em_model->get_nomor_spm_urut_by_nomor_spp($nomor_trx_spp) ;
                                    
                                    $nomor_trx_spm = $this->rsa_tambah_em_model->get_nomor_spm_by_id($id_nomor_tambah_em_spm);  

                                    // echo $nomor_trx_spm ; die ;
                                    
                                    $data_spm = $this->rsa_tambah_em_model->get_data_spm($nomor_trx_spm);
                                    $subdata['detail_tambah_em_spm'] 	= array(
                                                                    'nom' => $data_spm->jumlah_bayar,
                                                                    'terbilang' => $data_spm->terbilang, 

                                                                );
                                    
                                    $subdata['detail_ppk']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmppk,
                                        'nomor_induk' => $data_spm->nipppk
                                    );
                                    $subdata['detail_kpa']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkpa,
                                        'nomor_induk' => $data_spm->nipkpa
                                    );
                                    $subdata['detail_verifikator']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmverifikator,
                                        'nomor_induk' => $data_spm->nipverifikator
                                    );
                                    $subdata['detail_kuasa_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkbuu,
                                        'nomor_induk' => $data_spm->nipkbuu
                                    );
                                    $subdata['detail_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmbuu,
                                        'nomor_induk' => $data_spm->nipbuu
                                    );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic_spm']  = (object) array(
                                        'untuk_bayar' => $data_spm->untuk_bayar,
                                        'penerima' => $data_spm->penerima,
                                        'alamat_penerima' => $data_spm->alamat,
                                        'nama_bank_penerima' => $data_spm->nmbank,
                                        'no_rek_penerima' => $data_spm->rekening,
                                        'npwp_penerima' => $data_spm->npwp,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );
                                    
                                    $subdata['cur_tahun_spm'] = $data_spm->tahun;

                                    $subdata['tgl_spm'] = $data_spm->tgl_spm;
                                     
                                }else{
                                    
                                    $subdata['cur_tahun_spm'] = '';
                                    $subdata['tgl_spm'] = '' ;
                                    
                                }

                                $subdata['id_nomor_tambah_em'] = $id_nomor_tambah_em ;
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_tambah_em_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_tambah_em_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_tambah_em_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                // $subdata['ket'] = $this->rsa_tambah_em_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                $subdata['ket'] = $this->rsa_tambah_em_model->lihat_ket_by_nomor_trx($nomor_trx_spp);
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
				$data['main_content'] 			= $this->load->view("rsa_tambah_em/spm_tambah_em_kpa",$subdata,TRUE);
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
                            $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
//                            $subdata['unit_usul'] 		= $this->rsa_tambah_em_model->get_tambah_em_unit_usul_verifikator($user->id,$tahun);
                            $subdata['unit_usul'] 		= $this->rsa_tambah_em_model->get_tambah_em_unit_usul_verifikator($user->id,$tahun);
                            // echo '<pre>';var_dump($subdata['unit_usul']);echo '</pre>';die;
                            $subdata['subunit_usul']  		= $this->rsa_tambah_em_model->get_tambah_em_subunit_usul_verifikator($user->id,$tahun);
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_tambah_em/daftar_unit",$subdata,TRUE);
                            /*	Load main template	*/
    			// echo '<pre>';var_dump($subdata['unit_usul']);echo '</pre>';die;
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
                            $subdata['unit_usul'] 		= $this->rsa_tambah_em_model->get_tambah_em_unit_usul($tahun);
                            $subdata['subunit_usul'] 		= $this->rsa_tambah_em_model->get_tambah_em_subunit_usul($tahun);
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_tambah_em/daftar_unit_kbuu",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
                
                function spm_tambah_em_verifikator($kd_unit,$tahun){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				
                                $this->load->model('unit_model');
                                $subdata['cur_tahun'] = $tahun;
                                if(strlen($kd_unit)==2){
                                    $subdata['unit_kerja'] = $this->unit_model->get_nama($kd_unit);
                                    $subdata['unit_id'] = $kd_unit ;
                                    $subdata['kd_unit'] = $kd_unit ;
                                    $subdata['alias'] = $this->unit_model->get_alias($kd_unit);
                                }
                                elseif(strlen($kd_unit)==4){
                                        $subdata['unit_kerja'] = $this->unit_model->get_nama($kd_unit) . ' - ' . $this->unit_model->get_real_nama($kd_unit);//$this->check_session->get_nama_unit();
                                        $subdata['unit_id'] = $kd_unit;
                                        $subdata['kd_unit'] = $kd_unit ;
                                        $subdata['alias'] = $this->unit_model->get_alias($kd_unit);
                                }
                                $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($kd_unit,$tahun);
                              
                                $subdata['doc_tambah_em'] = $dokumen_tambah_em;
                                
                                $nomor_trx_spp = $this->rsa_tambah_em_model->get_nomor_spp($kd_unit,$tahun); 
                                
//                                echo $nomor_trx_spp ; die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '',
                                    'terbilang' => '',
                                    'untuk_bayar' => '',
                                    'penerima' => '',
                                    'alamat' => '',
                                    'nmbank' => '',
                                    'rekening' => '',
                                    'npwp' => '',
                                    'nmbendahara' => '',
                                    'nipbendahara' => '',
                                    'tgl_spp' => ''
                                );
                                // SPP
                                
                                if(($dokumen_tambah_em == 'SPP-FINAL') || ($dokumen_tambah_em == 'SPP-DRAFT') || ($dokumen_tambah_em == 'SPM-DRAFT-PPK') || ($dokumen_tambah_em == 'SPM-DRAFT-KPA') || ($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tambah_em == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_tambah_em_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    $subdata['detail_tambah_em']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_tambah_em == '') || ($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                
//                                $subdata['tgl_spm'] = $this->rsa_tambah_em_model->get_tgl_spm($kd_unit,$tahun);
                                
                                $nomor_trx_spm = '';
                                
                                if(($dokumen_tambah_em == 'SPM-DRAFT-PPK') || ($dokumen_tambah_em == 'SPM-DRAFT-KPA') || ($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tambah_em == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_tambah_em_model->get_nomor_spm($kd_unit,$tahun);  
                                    
                                    $data_spm = $this->rsa_tambah_em_model->get_data_spm($nomor_trx_spm);
                                    $subdata['detail_tambah_em_spm'] 	= array(
                                                                    'nom' => $data_spm->jumlah_bayar,
                                                                    'terbilang' => $data_spm->terbilang, 

                                                                );
                                    
                                    $subdata['detail_ppk']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmppk,
                                        'nomor_induk' => $data_spm->nipppk
                                    );
                                    $subdata['detail_kpa']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkpa,
                                        'nomor_induk' => $data_spm->nipkpa
                                    );
                                    $subdata['detail_verifikator']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmverifikator,
                                        'nomor_induk' => $data_spm->nipverifikator
                                    );
                                    $subdata['detail_kuasa_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkbuu,
                                        'nomor_induk' => $data_spm->nipkbuu
                                    );
                                    $subdata['detail_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmbuu,
                                        'nomor_induk' => $data_spm->nipbuu
                                    );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic_spm']  = (object) array(
                                        'untuk_bayar' => $data_spm->untuk_bayar,
                                        'penerima' => $data_spm->penerima,
                                        'alamat_penerima' => $data_spm->alamat,
                                        'nama_bank_penerima' => $data_spm->nmbank,
                                        'no_rek_penerima' => $data_spm->rekening,
                                        'npwp_penerima' => $data_spm->npwp,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );

                                    
                                    $subdata['cur_tahun_spm'] = $data_spm->tahun;
                                    $subdata['tgl_spm'] = $data_spm->tgl_spm;
                                     
                                }else{
                                    $subdata['cur_tahun_spm'] = '';
                                    $subdata['tgl_spm'] = '';
                                    
                                }
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
//                                echo $nomor_trx_spm ; die;
                                
//                                $detail_verifikator  = $this->rsa_tambah_em_model->get_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
//                                if(!isset($detail_verifikator->nm_lengkap)){
//                                    $detail_verifikator = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
//                                }
//                                
//                                $subdata['detail_verifikator']  = $detail_verifikator ;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_tambah_em_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);
                                
                                
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_tambah_em_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_tambah_em_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_tambah_em_model->lihat_ket($kd_unit,$tahun);
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
				$data['main_content'] 			= $this->load->view("rsa_tambah_em/spm_tambah_em_verifikator",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
                
                function spm_tambah_em_kbuu($kd_unit,$tahun){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==11)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_tambah_em['result_rsa_tambah_em'] 		= $this->rsa_tambah_em_model->search_rsa_tambah_em();
                                
                                $this->load->model('unit_model');
                                $subdata['cur_tahun'] = $tahun;
                                if(strlen($kd_unit)==2){
                                    $subdata['unit_kerja'] = $this->unit_model->get_nama($kd_unit);
                                    $subdata['unit_id'] = $kd_unit ;
                                    $subdata['kd_unit'] = $kd_unit ;
                                    $subdata['alias'] = $this->unit_model->get_alias($kd_unit);
                                }
                                elseif(strlen($kd_unit)==4){
                                        $subdata['unit_kerja'] = $this->unit_model->get_nama($kd_unit) . ' - ' . $this->unit_model->get_real_nama($kd_unit);//$this->check_session->get_nama_unit();
                                        $subdata['unit_id'] = $kd_unit;
                                        $subdata['kd_unit'] = $kd_unit ;
                                        $subdata['alias'] = $this->unit_model->get_alias($kd_unit);
                                }
                                
//                                $subdata['alias'] = $this->unit_model->get_alias($kd_unit);// $this->check_session->get_alias();
                               
                                $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($kd_unit,$tahun);
                              
                                $subdata['doc_tambah_em'] = $dokumen_tambah_em;
                                
                                $nomor_trx_spp = $this->rsa_tambah_em_model->get_nomor_spp($kd_unit,$tahun); 
                                
//                                echo $nomor_trx_spp ; die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '',
                                    'terbilang' => '',
                                    'untuk_bayar' => '',
                                    'penerima' => '',
                                    'alamat' => '',
                                    'nmbank' => '',
                                    'rekening' => '',
                                    'npwp' => '',
                                    'nmbendahara' => '',
                                    'nipbendahara' => '',
                                    'tgl_spp' => ''
                                );
                                // SPP
                                
                                if(($dokumen_tambah_em == 'SPP-FINAL') || ($dokumen_tambah_em == 'SPP-DRAFT') || ($dokumen_tambah_em == 'SPM-DRAFT-PPK') || ($dokumen_tambah_em == 'SPM-DRAFT-KPA') || ($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tambah_em == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_tambah_em_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    $subdata['detail_tambah_em']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );
                                    



    //                                if(($dokumen_tambah_em == '') || ($dokumen_tambah_em == 'SPP-DITOLAK') || ($dokumen_tambah_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
//                                $subdata['tgl_spm'] = $this->rsa_tambah_em_model->get_tgl_spm($kd_unit,$tahun);
                                
                                $nomor_trx_spm = '';
                                
                                if(($dokumen_tambah_em == 'SPM-DRAFT-PPK') || ($dokumen_tambah_em == 'SPM-DRAFT-KPA') || ($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tambah_em == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_tambah_em_model->get_nomor_spm($kd_unit,$tahun);

                                    // echo $nomor_trx_spm ; die ;  
                                    
                                    $data_spm = $this->rsa_tambah_em_model->get_data_spm($nomor_trx_spm);
                                    $subdata['detail_tambah_em'] 	= array(
                                                                    'nom' => $data_spm->jumlah_bayar,
                                                                    'terbilang' => $data_spm->terbilang, 

                                                                );
                                    
                                    $subdata['detail_ppk']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmppk,
                                        'nomor_induk' => $data_spm->nipppk
                                    );
                                    $subdata['detail_kpa']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkpa,
                                        'nomor_induk' => $data_spm->nipkpa
                                    );
                                    $subdata['detail_verifikator']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmverifikator,
                                        'nomor_induk' => $data_spm->nipverifikator
                                    );
                                    $subdata['detail_kuasa_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkbuu,
                                        'nomor_induk' => $data_spm->nipkbuu
                                    );
                                    $subdata['detail_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmbuu,
                                        'nomor_induk' => $data_spm->nipbuu
                                    );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic_spm']  = (object) array(
                                        'untuk_bayar' => $data_spm->untuk_bayar,
                                        'penerima' => $data_spm->penerima,
                                        'alamat_penerima' => $data_spm->alamat,
                                        'nama_bank_penerima' => $data_spm->nmbank,
                                        'no_rek_penerima' => $data_spm->rekening,
                                        'npwp_penerima' => $data_spm->npwp,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );

                                    $subdata['tgl_spm'] = $data_spm->tgl_spm;
                                    
                                    $subdata['cur_tahun_spm'] = $data_spm->tahun;
                                     
                                }else{
                                    
                                    $subdata['cur_tahun_spm'] = '';
                                    $subdata['tgl_spm'] = '' ;
                                }
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
//                                $subdata['detail_verifikator']  = $this->rsa_tambah_em_model->get_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_tambah_em_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_tambah_em_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_tambah_em_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_tambah_em_model->lihat_ket($kd_unit,$tahun);
                                
                                $this->load->model('akun_kas6_model');
                                
                                $subdata['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();//(array('kd_kas_3'=>'111'));
                                
//                                var_dump( $subdata['kas_undip']);die;
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
				$data['main_content'] 			= $this->load->view("rsa_tambah_em/spm_tambah_em_kbuu",$subdata,TRUE);
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
//                        $h = $this->load->view("rsa_tambah_em/cetak",array('html'=>$html),TRUE);
//                        echo $h;
                        $this->load->library('Pdfgen'); 
                        $this->pdfgen->cetak($html,'SPP_tambah_em_'.$unit.'_'.''.$tahun);
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
                        $this->pdfgen->cetak($html,'SPM_tambah_em_');
                    }
                }
                
                function usulkan_spp_tambah_em(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                        if($this->input->post('proses')){
                            $proses = $this->input->post('proses');
                            $nomor_trx = $this->input->post('nomor_trx');
                            $nomor_ = explode('/',$nomor_trx);
                            $bulan = $nomor_[3];
                            $jenis = 'SPP';//$this->input->post('jenis');
                            $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                            $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                            $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;

                            $id_nomor_tambah_em = $this->input->post('id_nomor_tambah_em') ;

                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'nomor_trx' => $nomor_[0],
                                'str_nomor_trx' => $nomor_trx,
                                'jenis' => $jenis,
                                'tgl_proses' => date("Y-m-d H:i:s"),
                                'aktif' => '1',
                                'bulan' => $bulan,
                                'tahun' => $tahun,
//                                'urut' => $this->rsa_tambah_em_model->get_urut($kd_unit,$jenis,$tahun)
                            );
                            
                            

                            // $data_spp = array(
                            //     'kode_unit_subunit' => $kd_unit,
                            //     'str_nomor_trx' => $nomor_trx,
                            //     'jumlah_bayar' => $this->input->post('jumlah_bayar'),
                            //     'terbilang' => $this->input->post('terbilang'),
                            //     'untuk_bayar' => $this->input->post('untuk_bayar'),
                            //     'penerima' => $this->input->post('penerima'),
                            //     'alamat' => $this->input->post('alamat'),
                            //     'nmbank' => $this->input->post('nmbank'),
                            //     'rekening' => $this->input->post('rekening'),
                            //     'npwp' => $this->input->post('npwp'),
                            //     'tahun' => $tahun,
                            //     'nmbendahara' => $this->input->post('nmbendahara'),
                            //     'nipbendahara' => $this->input->post('nipbendahara'),
                            //     'tgl_spp' => date("Y-m-d H:i:s"),
                            // );

                           // var_dump($data_spp);die;


                            $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($kd_unit,$tahun,$id_nomor_tambah_em);

                            if(($dokumen_tambah_em == '')||($dokumen_tambah_em == 'SPP-DITOLAK')||($dokumen_tambah_em == 'SPM-DITOLAK-KPA')||($dokumen_tambah_em == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_tambah_em == 'SPM-DITOLAK-KBUU')||($dokumen_tambah_em == 'SPM-FINAL-KBUU')){

        //                        var_dump($data_spp);die;

    //                            echo 'jos';die;

                                if($this->rsa_tambah_em_model->proses_nomor_spp_tambah_em($kd_unit,$data) ){
                                    
                                    $data_spp = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        // 'nomor_trx_spp' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em($jenis,$kd_unit,$this->cur_tahun),
                                        'nomor_trx_spp' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em_by_nomor_trx($nomor_trx),
                                        'str_nomor_trx' => $nomor_trx,
                                        'jumlah_bayar' => $this->input->post('jumlah_bayar'),
                                        'terbilang' => $this->input->post('terbilang'),
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
                                    
                                    $data = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'posisi' => $proses,
                                        // 'id_trx_nomor_tambah_em' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em($jenis,$kd_unit,$this->cur_tahun),
                                        'id_trx_nomor_tambah_em' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em_by_nomor_trx($nomor_trx),
                                        'ket' => $ket,
                                        'aktif' => '1',
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );

                                   // var_dump($data);die;

                                    if($this->rsa_tambah_em_model->proses_tambah_em($kd_unit,$data,$id_nomor_tambah_em)&& $this->rsa_tambah_em_model->proses_data_spp($data_spp)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM KS anda berhasil disubmit.</div>');
                                        echo urlencode(base64_encode($nomor_trx)); //"sukses";
                                    }else{
                                        echo "gagal";
                                    }

                                }else{
                                    echo "gagal";
                                }

                            }else{
                                echo "gagal";
                            }

                        }
                    }else{
                        redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
                
                
                function usulkan_spm_tambah_em(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14))){
                        if($this->input->post('proses')){
                            $proses = $this->input->post('proses');
                            $nomor_trx = $this->input->post('nomor_trx');
                            $nomor_trx_spp = $this->input->post('nomor_trx_spp');
                            $nomor_ = explode('/',$nomor_trx);
                            $bulan = $nomor_[3];

                            $id_nomor_tambah_em = $this->input->post('id_nomor_tambah_em') ;

                            $nomor_spp_ = explode('/',$nomor_trx_spp);


                            $jenis = 'SPM';//$this->input->post('jenis');
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
//                                'urut' => $this->rsa_tambah_em_model->get_urut($kd_unit,$jenis,$tahun)

                            );

                            $data_spp_spm = array(
                                'kode_unit_subunit' => $kd_unit,
                                'nomor_trx_spp' => $nomor_spp_[0],
                                'str_nomor_trx_spp' => $nomor_trx_spp,
                                'nomor_trx_spm' => $nomor_[0],
                                'str_nomor_trx_spm' =>$nomor_trx,
                                'jenis_trx' => 'KS',
                                'tahun' => $tahun,
                            );

                            

                           // var_dump($data);die;

                            $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($kd_unit,$tahun,$id_nomor_tambah_em);

                            // echo $dokumen_tambah_em ; die;

                            if($dokumen_tambah_em == 'SPP-FINAL'){
    //                        $this->rsa_tambah_em_model->proses_data_spm($data_spm);
    //                        var_dump($data_spm);die;

                                if($this->rsa_tambah_em_model->proses_nomor_spm_tambah_em($kd_unit,$data)){

                                    $id_trx_nomor_tambah_em = $this->rsa_tambah_em_model->get_id_nomor_tambah_em_by_nomor_trx($nomor_trx_spp) ;
                                    $id_trx_nomor_tambah_em_spm = $this->rsa_tambah_em_model->get_id_nomor_tambah_em_by_nomor_trx($nomor_trx) ;

                                    $data_spm = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        // 'nomor_trx_spm' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em($jenis,$kd_unit,$this->cur_tahun),
                                        'nomor_trx_spm' => $id_trx_nomor_tambah_em_spm,
                                        'str_nomor_trx' => $nomor_trx,
                                        'jumlah_bayar' => $this->input->post('jumlah_bayar'),
                                        'terbilang' => $this->input->post('terbilang'),
                                        'untuk_bayar' => $this->input->post('untuk_bayar'),
                                        'penerima' => $this->input->post('penerima'),
                                        'alamat' => $this->input->post('alamat'),
                                        'nmbank' => $this->input->post('nmbank'),
                                        'rekening' => $this->input->post('rekening'),
                                        'npwp' => $this->input->post('npwp'),
                                        'tahun' => $tahun,
                                        'nmppk' => $this->input->post('nmppk'),
                                        'nipppk' => $this->input->post('nipppk'),
                                        'nmkpa' => $this->input->post('nmkpa'),
                                        'nipkpa' => $this->input->post('nipkpa'),
                                        'nmpa' => $this->input->post('nmpa'),
                                        'nippa' => $this->input->post('nippa'),
                                        'nmverifikator' => $this->input->post('nmverifikator'),
                                        'nipverifikator' => $this->input->post('nipverifikator'),
                                        'nmkbuu' => $this->input->post('nmkbuu'),
                                        'nipkbuu' => $this->input->post('nipkbuu'),
                                        'nmbuu' => $this->input->post('nmbuu'),
                                        'nipbuu' => $this->input->post('nipbuu'),
                                        'tgl_spm' => date("Y-m-d H:i:s"),
                                    );

                                    $data_spp_spm = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        // 'nomor_trx_spp' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em('SPP',$kd_unit,$this->cur_tahun),
                                        'nomor_trx_spp' => $id_trx_nomor_tambah_em,
                                        'str_nomor_trx_spp' => $nomor_trx_spp,
                                        // 'nomor_trx_spm' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em('SPM',$kd_unit,$this->cur_tahun),
                                        'nomor_trx_spm' => $id_trx_nomor_tambah_em_spm,
                                        'str_nomor_trx_spm' =>$nomor_trx,
                                        'jenis_trx' => 'KS',
                                        'tahun' => $tahun,
                                    );

                                    $data = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'posisi' => $proses,
                                        // 'id_trx_nomor_tambah_em' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em($jenis,$kd_unit,$this->cur_tahun),
                                        'id_trx_nomor_tambah_em' => $id_trx_nomor_tambah_em,
                                        'id_trx_nomor_tambah_em_spm' => $id_trx_nomor_tambah_em_spm,
                                        'ket' => $ket,
                                        'aktif' => '1',
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );

                                   // var_dump($data);die;

                                    if($this->rsa_tambah_em_model->proses_tambah_em($kd_unit,$data,$id_trx_nomor_tambah_em) && $this->rsa_tambah_em_model->proses_trx_spp_spm($data_spp_spm) && $this->rsa_tambah_em_model->proses_data_spm($data_spm)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM KS anda berhasil disubmit.</div>');
                                        echo "sukses";
                                    }else{
                                        echo "gagal";
                                    }

                                }else{
                                    echo "gagal";
                                }

                            }else{
                                echo "gagal";
                            }

                        }
                    }else{
                        redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
                
                function proses_spp_tambah_em(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $jenis = 'SPP';//$this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;

                        $id_nomor_tambah_em = $this->input->post('id_nomor_tambah_em') ;
                    
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                // 'id_trx_nomor_tambah_em' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em($jenis,$kd_unit,$this->cur_tahun),
                                'id_trx_nomor_tambah_em' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em_by_nomor_trx($nomor_trx),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );
                            
                           // var_dump($data);die;
                        
                        $ok = FALSE ;
                            
                        $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($kd_unit,$tahun,$id_nomor_tambah_em);
                        
                        if(($proses == 'SPP-FINAL')&&($dokumen_tambah_em == 'SPP-DRAFT')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPP-DITOLAK')&&($dokumen_tambah_em == 'SPP-DRAFT')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }
                            
                        if($ok){
//                            echo 'jos'; die;
                            if($this->rsa_tambah_em_model->proses_tambah_em($kd_unit,$data,$id_nomor_tambah_em)){
                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM KS anda berhasil disubmit.</div>');
                                echo "sukses";
                            }else{
                                echo "gagal";
                            }
                        }else{
                            echo "gagal";
                        }

                        
                        
                    }
                }
                
                function proses_spm_tambah_em(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $jenis = 'SPM';//$this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;

                        $id_nomor_tambah_em = $this->input->post('id_nomor_tambah_em') ;
                        
                        
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                // 'id_trx_nomor_tambah_em' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em($jenis,$kd_unit,$this->cur_tahun),
                                'id_trx_nomor_tambah_em' => $id_nomor_tambah_em,
                                'id_trx_nomor_tambah_em_spm' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em_by_nomor_trx($nomor_trx),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );
                            
//                            var_dump($data);die;
                            
                        $ok = FALSE ;
                            
                        $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($kd_unit,$tahun,$id_nomor_tambah_em);


                        // echo $dokumen_tambah_em ; die ;
                        
                        if(($proses == 'SPM-DRAFT-KPA')&&($dokumen_tambah_em == 'SPM-DRAFT-PPK')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-KPA')&&($dokumen_tambah_em == 'SPM-DRAFT-PPK')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-FINAL-VERIFIKATOR')&&($dokumen_tambah_em == 'SPM-DRAFT-KPA')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-VERIFIKATOR')&&($dokumen_tambah_em == 'SPM-DRAFT-KPA')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-FINAL-KBUU')&&($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-KBUU')&&($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-FINAL-BUU')&&($dokumen_tambah_em == 'SPM-FINAL-KBUU')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-BUU')&&($dokumen_tambah_em == 'SPM-FINAL-KBUU')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }
//                        $verifikator = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
//                        $data_verifikator = array(
//                                        'nomor_trx_spm' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em('SPM',$kd_unit,$tahun),//$nomor_[0],
//                                        'str_nomor_trx_spm' => $nomor_trx,
//                                        'kode_unit_subunit' => $kd_unit,
//                                        'jenis_trx' => 'PUP',
//                                        'id_rsa_user_verifikator' => $verifikator->id,
//                                        'tahun' => $tahun,
//                                        'tgl_proses' => date("Y-m-d H:i:s")
//                                    );
//                        
                                    
                            
                        if($ok){
//                            echo 'jos';die;
//                            var_dump($data);die;
                            
                            // $nomor_trx_spm = $this->rsa_tambah_em_model->get_id_nomor_tambah_em('SPM',$kd_unit,$tahun);//$nomor_[0],

                            $nomor_trx_spm = $this->rsa_tambah_em_model->get_id_nomor_tambah_em_by_nomor_trx($nomor_trx) ;

                            // echo $nomor_trx_spm ; die ;
                                    
                            if($this->rsa_tambah_em_model->proses_tambah_em($kd_unit,$data,$id_nomor_tambah_em)){
                                if($this->check_session->get_level() == 3){
                                    $verifikator = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
                                    $data_verifikator = array(
                                        'nomor_trx_spm' => $nomor_trx_spm ,//$this->rsa_tambah_em_model->get_id_nomor_tambah_em('SPM',$kd_unit,$tahun),//$nomor_[0],
                                        'str_nomor_trx_spm' => $nomor_trx,
                                        'kode_unit_subunit' => $kd_unit,
                                        'jenis_trx' => 'KS',
                                        'id_rsa_user_verifikator' => $verifikator->id,
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );
                                    if($this->rsa_tambah_em_model->proses_verifikator_tambah_em($data_verifikator)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM KS anda berhasil disubmit.</div>');
                                        echo "sukses";
                                    }else{
                                        echo "gagal";
                                    }
                                }else{
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM KS anda berhasil disubmit.</div>');
                                    echo "sukses";
                                }
                            }else{
                                echo "gagal";
                            }
                            
                        }

                        
                        
                    }
                }
                
                function proses_final_tambah_em(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx_spm = $this->input->post('nomor_trx');
                        $nomor_ = explode('/', $nomor_trx_spm);
                        $nomor = (int)$nomor_[0] ;
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->input->post('kd_unit');
                        $data = array(
                            'kode_unit_subunit' => $kd_unit,
                            'id_trx_nomor_tambah_em' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em('SPM',$kd_unit,$this->input->post('tahun')),
                            'posisi' => $proses,
                            'ket' => $ket,
                            'aktif' => '1',
                            'tahun' => $this->input->post('tahun'),
                            'tgl_proses' => date("Y-m-d H:i:s")
                        );
                        
                        $ok = FALSE ;
                            
                        $dokumen_tambah_em = $this->rsa_tambah_em_model->check_dokumen_tambah_em($kd_unit,$this->input->post('tahun'));
                        
                        if(($proses == 'SPM-FINAL-KBUU')&&($dokumen_tambah_em == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }
                            
                        if($ok){
                            
//                            echo 'jos';die;
                            
                            if($this->rsa_tambah_em_model->proses_tambah_em($kd_unit,$data)){
                                
                                $this->load->model('kas_bendahara_model');
                                $saldo_bendahara = $this->kas_bendahara_model->get_kas_saldo_tambah_em($kd_unit,$this->cur_tahun);
                                
                                $debet = $this->input->post('kredit') ;
                                $saldo_bendahara_akhir =  $saldo_bendahara + $debet ;

                                $data = array(
                                    'tgl_trx' => date("Y-m-d H:i:s"),
                                    'kd_akun_kas' => '112111',
                                    'kd_unit' => $kd_unit,
                                    'deskripsi' => 'TUP UNIT ' . $kd_unit,//$this->input->post('deskripsi'),
                                    'jenis' => 'TP',
                                    'no_spm' => $this->input->post('nomor_trx'),
                                    'kredit' => '0',
                                    'debet' => $debet,
                                    'saldo' => $saldo_bendahara_akhir,
                                    'aktif' => '2',
                                    'tahun' => $this->input->post('tahun'),
                                );

                                $this->load->model('kas_undip_model');
                                $kd_akun_kas = $this->input->post('kd_akun_kas') ;
                                $nominal = $this->input->post('nominal') ;
                                $saldo = $this->kas_undip_model->get_nominal($kd_akun_kas) - $nominal ;

                                $data_kas = array(
                                    'tgl_trx' => date('Y-m-d H:i:s'),
                                    'kd_akun_kas' => $kd_akun_kas,
                                    'kd_unit' => $kd_unit,//'99',
                                    'deskripsi' => 'ISI TUP UNIT ' . $kd_unit,
                                    'no_spm' => $this->input->post('nomor_trx'),
                                    'debet' => '0',
                                    'kredit' => $nominal,
                                    'saldo' => $saldo,
                                    'aktif' => '1',
                                    'tahun' => $this->input->post('tahun'),
                                );

                                $data_spm_cair = array(
                                    'no_urut' => $this->rsa_tambah_em_model->get_next_urut_spm_cair($this->input->post('tahun')),
//                                    'nomor_trx_spm' => $this->rsa_tambah_em_model->get_id_nomor_tambah_em('SPM',$kd_unit,$tahun),//$nomor,
                                    'str_nomor_trx_spm' => $nomor_trx_spm,
                                    'kode_unit_subunit' => $kd_unit,
                                    'jenis_trx' => 'TUP',
                                    'tgl_proses' => date('Y-m-d H:i:s'),
                                    'bulan' => $nomor_[3],
                                    'tahun' => $this->input->post('tahun')
                                );

                                $data_tambah_em_to_nihil = array(
                                    'kode_unit_subunit' => $kd_unit,
                                    'str_nomor_trx_spm_tambah_em' => $nomor_trx_spm,
                                    'tgl_proses_tambah_em' => date('Y-m-d H:i:s'),
                                    'tahun' => $this->input->post('tahun'),
                                    'status' => '1',
                                );

    //                            var_dump($data_spm_cair);die;

                                if($this->rsa_tambah_em_model->final_tambah_em($kd_unit,$data) && $this->kas_undip_model->isi_trx($data_kas) && $this->rsa_tambah_em_model->spm_cair($data_spm_cair) && $this->rsa_tambah_em_model->tup_to_nihil($data_tambah_em_to_nihil)){
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM KS anda berhasil disubmit.</div>');
                                    echo "sukses";
                                }else{
                                    echo "gagal";
                                }
                            }else{
                                echo "gagal";
                            }
                        
                        }
                    }
                }
		
		//define method exec_add_unit()
		//execute add data unit
		function exec_add_rsa_tambah_em(){

			if($this->input->post()){

				if($this->check_session->user_session() && $this->check_session->get_level()==2){
				
						// get kode otomatis
						// $top_unit = $this->master_unit_model->get_unit('',array('kode_unit !=' => '99'),'kode_unit DESC',1);

						// if(count($top_unit)>0) $top_unit=$top_unit[0];

						// $kode = strlen(($top_unit->kode_unit+1)+"")==1?"0".($top_unit->kode_unit+1):$top_unit->kode_unit+1;
                                        if($this->input->post()){
											
                                            $this->form_validation->set_rules('no_tambah_em','no_tambah_em','required|min_length[2]|callback_check_exist_rsa_tambah_em');
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
												
												'no_tambah_em' => form_prep($this->input->post('no_tambah_em')),
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
							                    $this->rsa_tambah_em_model->add_rsa_tambah_em($data);
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
					$data['url']		= site_url('rsa_tambah_em/exec_delete/'.$this->uri->segment(3));
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
				if($this->rsa_tambah_em_model->delete_rsa_tambah_em(array('no'=>$this->uri->segment(3)))){
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
		function get_row_rsa_tambah_em(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				$data['result_rsa_tambah_em'] = $this->rsa_tambah_em_model->get_rsa_tambah_em();
				$this->load->view('rsa_tambah_em/row_rsa_tambah_em',$data);
			}
			else{
				show_404('page');
			}
		}
		
		//define search_unit()
		//this method for search unit
		function filter_rsa_tambah_em(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				$keyword = form_prep($this->input->post('keyword'));
				$data['result_rsa_tambah_em'] = $this->rsa_tambah_em_model->search_rsa_tambah_em($keyword);
				$this->load->view('rsa_tambah_em/row_rsa_tambah_em',$data);
			}
			else{
				show_404('page');
			}
                        
                        
		}
                
               function check_exist_rsa_tambah_em($no_tambah_em){

                        $this->form_validation->set_message('check_exist_rsa_tambah_em', 'Maaf, kode RSA tsb sudah terdaftar');

                        $result = $this->rsa_tambah_em_model->get_rsa_tambah_em($no_tambah_em);

                        if(empty($result)){
                                return true;
                        }
                        else{
                                return false;
                        }

                }
                function check_exist_rba_unit($kode_unit_rba){

                        $this->form_validation->set_message('check_exist_rba_unit', 'Maaf, kode RBA Unit tsb sudah terdaftar');

                        $result = $this->rsa_tambah_em_model->get_rsa_tambah_em($kode_unit_rba);

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
                            $subdata['unit_usul'] 		= $this->rsa_tambah_em_model->get_tambah_em_unit($tahun);
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_tambah_em/saldo",$subdata,TRUE);
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
                            $subdata['daftar_spp']          = $this->rsa_tambah_em_model->get_daftar_spp($kode_unit_subunit,$tahun);

                            // echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;

                            $data['main_content']           = $this->load->view("rsa_tambah_em/daftar_spp",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }

                function daftar_spumk($tahun="",$kode_unit_subunit=""){
                    
                    if($kode_unit_subunit == ''){
                        $kode_unit_subunit = $this->check_session->get_unit();
                    }
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }

                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==4))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
                            $subdata['daftar_spp']          = $this->rsa_tambah_em_model->get_daftar_spp($kode_unit_subunit,$tahun);

                            // echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;

                            $data['main_content']           = $this->load->view("rsa_tambah_em/daftar_spumk",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }

                function daftar_spp_ppk($tahun="",$kode_unit_subunit=""){
                    
                    if($kode_unit_subunit == ''){
                        $kode_unit_subunit = $this->check_session->get_unit();
                    }
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }

                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
                            $subdata['daftar_spp']          = $this->rsa_tambah_em_model->get_daftar_spp($kode_unit_subunit,$tahun);

                            // echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;

                            $data['main_content']           = $this->load->view("rsa_tambah_em/daftar_spp_ppk",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }

                function daftar_spp_kpa($tahun="",$kode_unit_subunit=""){
                    
                    if($kode_unit_subunit == ''){
                        $kode_unit_subunit = $this->check_session->get_unit();
                    }
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }

                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
                            $subdata['daftar_spp']          = $this->rsa_tambah_em_model->get_daftar_spp($kode_unit_subunit,$tahun);

                            // echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;

                            $data['main_content']           = $this->load->view("rsa_tambah_em/daftar_spp_kpa",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }
                
                function get_next_nomor_spp(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                            
                        $nomor_trx_ = $this->rsa_tambah_em_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);
                        setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");  
                        $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-EM'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                        
                        echo $nomor_trx ; 
                        
                    }
                }




                function get_status_nihil(){

                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                           // echo '5' ; 
                        $status = $this->rsa_tambah_em_model->get_status_nihil($this->check_session->get_unit(),$this->cur_tahun);
                        
                        echo $status ; 
                        
                    }

                }

                function get_notif_approve(){

                    if($this->check_session->user_session()){

                        $level = $this->check_session->get_level() ;

                        $kode_unit_subunit = $this->check_session->get_unit();

                        $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());

                        $notif = $this->rsa_tambah_em_model->get_notif_approve($kode_unit_subunit,$level,$user->id);

                        echo $notif ;
                    }

                }


               
                
                
		
	}

?>
