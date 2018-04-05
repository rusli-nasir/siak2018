<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class rsa_up extends CI_Controller{
/* -------------- Constructor ------------- */
            
    private $cur_tahun;
	public function __construct(){ 
		parent::__construct();
			//load library, helper, and model
                $this->cur_tahun = $this->setting_model->get_tahun();
			$this->load->library(array('form_validation','option'));
			$this->load->helper('form');
			$this->load->model(array('rsa_up_model','akun_model','kas_undip_model','kas_bendahara_model'));//,'setting_up_model'));
			$this->load->model("user_model");
            $this->load->model("unit_model");
            $this->load->model('menu_model');
			$this->load->helper("security");
                        

		}
		
		#methods ======================
		
		//define method index()
		function index(){
			$data['cur_tahun'] = $this->cur_tahun ;
                        $subdata['jenis']           = 'up';
                        $data['main_content']	= $this->load->view('rsa_permintaan/index',$subdata,TRUE);
                        // $data['main_menu']	= $this->load->view('form_login','',TRUE);
                        $list["menu"] = $this->menu_model->show();
                        $list["submenu"] = $this->menu_model->show();
                        $data['main_menu']	= $this->load->view('main_menu','',TRUE);
//                        $data['message']	= validation_errors();
                        $this->load->view('main_template',$data);
		}
		

		function input_rsa_up(){
			if($this->check_session->user_session() && $this->check_session->get_level()==13){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_up_model->search_rsa_up();
				//$subdata['row_rsa_up'] 			= $this->load->view("rsa_permintaan/row_rsa_up",$subdata_rsa_up,TRUE);
				$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
				$data['main_content'] 			= $this->load->view("rsa_permintaan/input_rsa_up",$subdata,TRUE);
				$this->load->view('main_template',$data);
			}
			else{
				redirect('home','refresh');	// redirect ke halaman home
			}		
		}
                
                function spp_up(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){
				//set data for main template

                        // if($urut_spp == ""){
                        //     $urut_spp = '1' ;
                        // }

				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_up_model->search_rsa_up();


                $id_max_nomor = $this->rsa_up_model->get_nomor_spp_urut($this->check_session->get_unit(),$this->cur_tahun) ;

                $id_max_nomor = $id_max_nomor + 1 ;

                // echo  $id_max_nomor_up; die;
                                
                                $dokumen = '';//$this->rsa_up_model->check_dokumen_up($this->check_session->get_unit(),$this->cur_tahun,$id_max_nomor_up);
                               
                               // echo $dokumen_up ; die ;

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

                                
                                    $subdata['detail_permintaan'] 	= array(
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


                                    $subdata['tgl_spp'] = '';

                                    $nomor_trx_ = $this->rsa_up_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);

                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");$thn = strftime("%Y");  

                                    $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-UP'.'/'.strtoupper($bln).'/'.$thn;
                                
                                

                                $subdata['id_nomor'] = $id_max_nomor ;
                                
                                $subdata['doc'] = $dokumen;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['ket'] = '';

                                $subdata['jenis'] = 'up';

                                $list_akun = $this->akun_model->get_list_akun_1d('1');

                                $subdata['list_akun'] = $list_akun;

                                // echo '<pre>';

                                // var_dump($list_akun); die;

                                // $kode_akun6d = '822111';
                                // $kode_akun5d = '82211';

                                // $subdata['akun'] = array(
                                //                         'kode_akun5digit' => $kode_akun5d,
                                //                         'nama_akun5digit' => $this->akun_model->get_nama_akun5digit($kode_akun6d)
                                //                     );
                                

				$data['main_content'] 			= $this->load->view("rsa_permintaan/spp_permintaan",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }

                function spumk_up(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==4)||($this->check_session->get_level()==100))){
                //set data for main template

                        // if($urut_spp == ""){
                        //     $urut_spp = '1' ;
                        // }

                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                //$subdata_rsa_up['result_rsa_up']        = $this->rsa_up_model->search_rsa_up();


                $id_max_nomor_up = $this->rsa_up_model->get_nomor_spp_urut($this->check_session->get_unit(),$this->cur_tahun) ;

                $id_max_nomor_up = $id_max_nomor_up + 1 ;

                // echo  $id_max_nomor_up; die;
                                
                                $dokumen_up = $this->rsa_up_model->check_dokumen_up($this->check_session->get_unit(),$this->cur_tahun,$id_max_nomor_up);
                               
                               // echo $dokumen_up ; die ;

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
                                if(($dokumen_up == '')||($dokumen_up == 'SPP-DITOLAK')||($dokumen_up == 'SPM-DITOLAK-KPA')||($dokumen_up == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_up == 'SPM-DITOLAK-KBUU')){
                                    $subdata['detail_up']    = array(
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



    //                                if(($dokumen_up == '') || ($dokumen_up == 'SPP-DITOLAK') || ($dokumen_up == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $this->rsa_up_model->get_tgl_spp($this->check_session->get_unit(),$this->cur_tahun);

                                    $nomor_trx_ = $this->rsa_up_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h"); $thn = strftime("%Y");  
                                    $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-UP'.'/'.strtoupper($bln).'/'.$thn;
                                
                                }else{
                                    $nomor_trx = $this->rsa_up_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 
                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx);
                                    $subdata['detail_up']    = array(
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



    //                                if(($dokumen_up == '') || ($dokumen_up == 'SPP-DITOLAK') || ($dokumen_up == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                }

                                $subdata['id_nomor_up'] = $id_max_nomor_up ;
                                
                                $subdata['doc_up'] = $dokumen_up;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['ket'] = $this->rsa_up_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                
//                                $urut_spp_pup = $this->rsa_up_model->get_urut($this->check_session->get_unit(),'SPP',$this->cur_tahun);
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata['detail_pic']);die;
                $data['main_content']           = $this->load->view("rsa_permintaan/spumk_up",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }


                function spp_up_lihat($url = ''){


                    if($this->check_session->user_session() && (($this->check_session->get_level()==11)||($this->check_session->get_level()==2)||($this->check_session->get_level()==3)||($this->check_session->get_level()==13)||($this->check_session->get_level()==17)||($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){


                        $url = urldecode($url);

                            if( base64_encode(base64_decode($url, true)) === $url){
                                $url = base64_decode($url);
                            }else{
                                redirect(site_url('/'));
                            }

                            // echo $url ; die ;

                            $arr_url = explode('/', $url);
                            $kd_unit = $this->unit_model->get_kd_unit_by_alias($arr_url[1]);
                            $tahun = $arr_url[4] ;

                            // echo $kd_unit; die;

                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       



                                $nomor_trx_spp = $url ;
                                
                                
                                $dokumen = $this->rsa_up_model->check_dokumen_up_by_str_trx($url);

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


                                $array_id = '';
                                $pengeluaran = 0;
                                
                                $tgl_ok = false ;


                                ///////////
                                /// SPP ///
                                ///////////


                                    $nomor_trx = $nomor_trx_spp ;

                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx);

                                    
                                    $subdata['detail_permintaan']  = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );


                                    $subdata['cur_tahun'] = $data_spp->tahun;

                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'nama_rek_penerima' => $data_spp->nmrekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );


                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 
                                    
                                    
                                $subdata['id_nomor_up'] = $this->rsa_up_model->get_id_nomor_up_by_nomor_trx($nomor_trx);

                                $subdata['doc'] = $dokumen;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($kd_unit,'14');

                                $subdata['ket'] = $this->rsa_up_model->lihat_ket_by_nomor_trx($nomor_trx);

                                $subdata['jenis'] = 'up';

                                $akun  = $this->akun_model->get_akun_by_id( $data_spp->id_akun_belanja);

                                $subdata['akun'] = array(
                                                        'id_akun_belanja' => $akun->id_akun_belanja,
                                                        'kode_akun' => $akun->kode_akun,
                                                        'nama_akun' => $akun->nama_akun,
                                                        'kode_akun5digit' => $akun->kode_akun5digit,
                                                        'nama_akun5digit' => $akun->nama_akun5digit,
                                                    );
                                
                $data['main_content']           = $this->load->view("rsa_permintaan/spp_permintaan_lihat",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }

                function spm_up_lihat($url = ''){


                    if($this->check_session->user_session() && (($this->check_session->get_level()==11)||($this->check_session->get_level()==2)||($this->check_session->get_level()==3)||($this->check_session->get_level()==17)||($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){


                        $url = urldecode($url);


                            if( base64_encode(base64_decode($url, true)) === $url){
                                $url = base64_decode($url);
                            }else{
                                redirect(site_url('/'));
                            }


                            $arr_url = explode('/', $url);
                            $kd_unit = $this->unit_model->get_kd_unit_by_alias($arr_url[1]);
                            $tahun = $arr_url[4] ;


                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       


                                $subdata['cur_tahun'] = $this->cur_tahun;

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

                                // $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');

                                $nomor_trx_spp = $url ;

                                // echo $nomor_trx_spm; die;

                                $id_nomor = $this->rsa_up_model->get_nomor_spp_urut_by_nomor_spp($nomor_trx_spp) ;
                                
                                
                                $dokumen = $this->rsa_up_model->check_dokumen_up_by_str_trx($url);

                                $nomor_trx_spm = $this->rsa_up_model->get_spm_by_spp($nomor_trx_spp);
                                
                                
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

                                // SPP //

                                
                                
                                    
                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
                                   // var_dump($data_spp);die;
                                    $subdata['detail_permintaan']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'nama_rek_penerima' => $data_spp->nmrekening,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_up == '') || ($dokumen_up == 'SPP-DITOLAK') || ($dokumen_up == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }
//                                    echo $data_spp->tgl_spp; die
                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                // SPM //
                                    
                                    // $nomor_trx_spm = $this->rsa_up_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  

                                     // $id_nomor_up_spm = $this->rsa_up_model->get_nomor_spm_urut_by_nomor_spp($nomor_trx_spp) ;
                                    
                                    // $nomor_trx_spm = $this->rsa_up_model->get_nomor_spm_by_id($id_nomor_up_spm);  
                                    
                                    $data_spm = $this->rsa_up_model->get_data_spm($nomor_trx_spm);
                                    $subdata['detail_permintaan_spm']    = array(
                                                                    'nom' => $data_spm->jumlah_bayar,
                                                                    'terbilang' => $data_spm->terbilang, 

                                                                );

                                    // echo '<pre>';
                                    // var_dump($subdata); die;
                                    
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
                                     

                                $subdata['id_nomor'] = $id_nomor ;
                                
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                // $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa($kd_unit ,$this->cur_tahun,$nomor_trx_spm);

                                $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa_by_spp($nomor_trx_spp);
                                
                                // $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator($kd_unit ,$this->cur_tahun,$nomor_trx_spm);

                                $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator_by_spp($nomor_trx_spp);
                                
                                // $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu($kd_unit ,$this->cur_tahun,$nomor_trx_spm);

                                $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu_by_spp($nomor_trx_spp);
                                
                                // $subdata['ket'] = $this->rsa_up_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                // echo $this->rsa_up_model->lihat_ket_by_nomor_trx($nomor_trx_spp); die ;
                                $subdata['ket'] = $this->rsa_up_model->lihat_ket_by_nomor_trx($nomor_trx_spp);

                                $subdata['doc'] = $dokumen;

                                $subdata['jenis'] = 'up';

                                $akun  = $this->akun_model->get_akun_by_id( $data_spp->id_akun_belanja);

                                $subdata['akun'] = array(
                                                        'id_akun_belanja' => $akun->id_akun_belanja,
                                                        'kode_akun' => $akun->kode_akun,
                                                        'nama_akun' => $akun->nama_akun,
                                                        'kode_akun5digit' => $akun->kode_akun5digit,
                                                        'nama_akun5digit' => $akun->nama_akun5digit,
                                                    );
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_permintaan/spm_permintaan_lihat",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }
                
                function spm_up($url = ''){


                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);	

                                $hash_url = $url;	

                                $url = urldecode($url);

                                if( base64_encode(base64_decode($url, true)) === $url){
                                    $url = base64_decode($url);
                                }else{
                                    redirect(site_url('/'));
                                }

                                $str_nomor_trx_spp = $url ;

                                $id_nomor = $this->rsa_up_model->get_nomor_spp_urut_by_nomor_spp($str_nomor_trx_spp) ;
                                
                                $dokumen = 'SPP-DRAFT';

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

                                ///////////
                                // SPP ////
                                //////////

                                    
                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
                                   // var_dump($data_spp);die;
                                    $subdata['detail_permintaan']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'nama_rek_penerima' => $data_spp->nmrekening,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );


                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;


                                ///////////
                                // SPM ////
                                //////////
                                 

                                    $nomor_trx_ = $this->rsa_up_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-KS'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    
//                                    echo $nomor_trx_spp ; die;
                                    
//                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
                                    $subdata['detail_permintaan_spm']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    
                                    $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                    $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
                                    $subdata['detail_verifikator']  = $this->rsa_up_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
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
                                     

                                $subdata['doc'] = $dokumen;

                                $subdata['id_nomor'] = $id_nomor ;
                                
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                

                                $subdata['ket'] = $this->rsa_up_model->lihat_ket_by_nomor_trx($nomor_trx_spp);

                                $subdata['hash_url'] = $hash_url;

                                $subdata['jenis'] = 'up';

                                $akun  = $this->akun_model->get_akun_by_id( $data_spp->id_akun_belanja);

                                $subdata['akun'] = array(
                                                        'id_akun_belanja' => $akun->id_akun_belanja,
                                                        'kode_akun' => $akun->kode_akun,
                                                        'nama_akun' => $akun->nama_akun,
                                                        'kode_akun5digit' => $akun->kode_akun5digit,
                                                        'nama_akun5digit' => $akun->nama_akun5digit,
                                                    );
                                

				$data['main_content'] 			= $this->load->view("rsa_permintaan/spm_permintaan",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }


                function spm_up_lanjut($url = ''){


                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){
                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                //$subdata_rsa_up['result_rsa_up']        = $this->rsa_up_model->search_rsa_up();
//              $subdata['detail_up']            = array(
//                                                                                    'nom' => $this->setting_up_model->get_setting_up($this->check_session->get_unit(),$this->cur_tahun),
//                                                                                    'terbilang' => $this->convertion->terbilang($this->setting_up_model->get_setting_up($this->check_session->get_unit(),$this->cur_tahun)), 
//                                                                                    
//                                                                                );

                                $url = urldecode($url);

                                if( base64_encode(base64_decode($url, true)) === $url){
                                    $url = base64_decode($url);
                                }else{
                                    redirect(site_url('/'));
                                }

                                $str_nomor_trx_spp = $url ;

                                // echo  $str_nomor_trx_spp; die;

                                $id_nomor = $this->rsa_up_model->get_nomor_spp_urut_by_nomor_spp($str_nomor_trx_spp) ;

                                // echo  $id_nomor; die;
                                
                                $dokumen = 'SPP-FINAL' ; // $this->rsa_up_model->check_dokumen_up($this->check_session->get_unit(),$this->cur_tahun,$id_nomor_up);

                                // echo  $dokumen_up; die;


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
                                
                                
                                // $dokumen_up = $this->rsa_up_model->check_dokumen_up($this->check_session->get_unit(),$this->cur_tahun);

                                
                                
//                                $subdata['tgl_spm'] = $this->rsa_up_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_up_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

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

                                /////////
                                // SPP //
                                /////////
                                
                              
                                    
                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
                                   // var_dump($data_spp);die;
                                    $subdata['detail_permintaan']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'nama_rek_penerima' => $data_spp->nmrekening,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );


                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;



                                /////////
                                // SPM //
                                /////////


                                    $nomor_trx_ = $this->rsa_up_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");$thn = strftime("%Y");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-UP'.'/'.strtoupper($bln).'/'.$thn;
                                    
//                                    echo $nomor_trx_spp ; die;
                                    
//                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
                                    $subdata['detail_permintaan_spm']    = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    
                                    $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                    $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
                                    $subdata['detail_verifikator']  = $this->rsa_up_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
                                    $subdata['detail_kuasa_buu']  = $this->user_model->get_detail_rsa_user('99','11');
                                    $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');

                                    // echo '<pre>';
                                    // var_dump($subdata); die;
                                    
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
                                     


                                $subdata['id_nomor'] = $id_nomor ;
                                
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                // $subdata['ket'] = $this->rsa_up_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                // echo $this->rsa_up_model->lihat_ket_by_nomor_trx($nomor_trx_spp); die ;
                                $subdata['ket'] = $this->rsa_up_model->lihat_ket_by_nomor_trx($nomor_trx_spp);

                                $subdata['doc'] = $dokumen;

                                $subdata['jenis'] = 'up';

                                $akun  = $this->akun_model->get_akun_by_id( $data_spp->id_akun_belanja);

                                $subdata['akun'] = array(
                                                        'id_akun_belanja' => $akun->id_akun_belanja,
                                                        'kode_akun' => $akun->kode_akun,
                                                        'nama_akun' => $akun->nama_akun,
                                                        'kode_akun5digit' => $akun->kode_akun5digit,
                                                        'nama_akun5digit' => $akun->nama_akun5digit,
                                                    );

                $data['main_content']           = $this->load->view("rsa_permintaan/spm_permintaan_lanjut",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }
                
                function spm_up_kpa($url = ''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==2)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_up_model->search_rsa_up();


                                $url = urldecode($url);

                                if( base64_encode(base64_decode($url, true)) === $url){
                                    $url = base64_decode($url);
                                }else{
                                    redirect(site_url('/'));
                                }

                                $str_nomor_trx_spp = $url ;

                                // echo  $str_nomor_trx_spp; die;

                                $id_nomor = $this->rsa_up_model->get_nomor_spp_urut_by_nomor_spp($str_nomor_trx_spp) ;

                                // echo  $id_nomor_up; die;
                                
                                $dokumen = 'SPM-DRAFT-PPK';//this->rsa_up_model->check_dokumen_up($this->check_session->get_unit(),$this->cur_tahun,$id_nomor_up);

                                // echo  $dokumen_up; die;
				
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
                                
                                // $dokumen_up = $this->rsa_up_model->check_dokumen_up($this->check_session->get_unit(),$this->cur_tahun,$id_nomor_up);
                                
                                $nomor_trx_spp = $str_nomor_trx_spp ; // $this->rsa_up_model->get_nomor_spp_by_id($id_nomor_up); 
                                
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

                                ////////
                                // SPP ///
                                ////////
                                
                                    
                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    $subdata['detail_permintaan']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'nama_rek_penerima' => $data_spp->nmrekening,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_up == '') || ($dokumen_up == 'SPP-DITOLAK') || ($dokumen_up == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                
                                ////////
                                // SPM ///
                                ////////

                                
                                    $nomor_trx_spm = '';
                                

                                    $id_nomor_up_spm = $this->rsa_up_model->get_nomor_spm_urut_by_nomor_spp($nomor_trx_spp) ;
                                    
                                    $nomor_trx_spm = $this->rsa_up_model->get_nomor_spm_by_id($id_nomor_up_spm);  

                                    // echo $nomor_trx_spm ; die ;
                                    
                                    $data_spm = $this->rsa_up_model->get_data_spm($nomor_trx_spm);
                                    $subdata['detail_permintaan_spm'] 	= array(
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
                                        'nama_rek_penerima' => $data_spm->nmrekening,
                                        'no_rek_penerima' => $data_spm->rekening,
                                        'npwp_penerima' => $data_spm->npwp,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );
                                    
                                    $subdata['cur_tahun_spm'] = $data_spm->tahun;

                                    $subdata['tgl_spm'] = $data_spm->tgl_spm;
                                     

                                $subdata['id_nomor'] = $id_nomor ;
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                // $subdata['ket'] = $this->rsa_up_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                $subdata['ket'] = $this->rsa_up_model->lihat_ket_by_nomor_trx($nomor_trx_spp);

                                $subdata['doc'] = $dokumen;

                                $subdata['jenis'] = 'up';


                                $akun  = $this->akun_model->get_akun_by_id( $data_spp->id_akun_belanja);

                                $subdata['akun'] = array(
                                                        'id_akun_belanja' => $akun->id_akun_belanja,
                                                        'kode_akun' => $akun->kode_akun,
                                                        'nama_akun' => $akun->nama_akun,
                                                        'kode_akun5digit' => $akun->kode_akun5digit,
                                                        'nama_akun5digit' => $akun->nama_akun5digit,
                                                    );

				$data['main_content'] 			= $this->load->view("rsa_permintaan/spm_permintaan_kpa",$subdata,TRUE);
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
//                            $subdata['unit_usul'] 		= $this->rsa_up_model->get_up_unit_usul_verifikator($user->id,$tahun);
                            $subdata['unit_usul'] 		= $this->rsa_up_model->get_up_unit_usul_verifikator($user->id,$tahun);
                            // echo '<pre>';var_dump($subdata['unit_usul']);echo '</pre>';die;
                            $subdata['subunit_usul']  		= $this->rsa_up_model->get_up_subunit_usul_verifikator($user->id,$tahun);
                            $subdata['cur_tahun'] =  $tahun;
                            $subdata['jenis'] =  'up';
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_permintaan/daftar_unit",$subdata,TRUE);
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
                            $subdata['unit_usul'] 		= $this->rsa_up_model->get_up_unit_usul($tahun);
                            // echo '<pre>';var_dump($subdata['unit_usul']);echo '</pre>';die;
                            $subdata['subunit_usul'] 		= $this->rsa_up_model->get_up_subunit_usul($tahun);
                            $subdata['cur_tahun'] =  $tahun;
                            $subdata['jenis'] =  'up';
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_permintaan/daftar_unit_kbuu",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }

                function daftar_spm_kbuu($tahun="",$kode_unit_subunit=""){
                    
                    if($kode_unit_subunit == ''){
                        $kode_unit_subunit = $this->check_session->get_unit();
                    }
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }

                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
                            $subdata['jenis']           = 'up';
                            $subdata['kode_unit']           = $kode_unit_subunit;
                            // $subdata['daftar_spm']          = $this->rsa_lsnk_model->get_daftar_spm($kode_unit_subunit,$tahun);
                            $subdata['daftar_spm']          = $this->rsa_up_model->get_daftar_spp($kode_unit_subunit,$tahun);
//                            echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("rsa_permintaan/daftar_spm_kbuu",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }

                function daftar_spm_verifikator($tahun="",$kode_unit_subunit=""){
                    
                    if($kode_unit_subunit == ''){
                        $kode_unit_subunit = $this->check_session->get_unit();
                    }
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }

                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14)||($this->check_session->get_level()==2)||($this->check_session->get_level()==3))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
                            $subdata['jenis']           = 'up';
                            $subdata['kode_unit']           = $kode_unit_subunit;
                            // $subdata['daftar_spm']          = $this->rsa_lsnk_model->get_daftar_spm($kode_unit_subunit,$tahun);
                            $subdata['daftar_spm']          = $this->rsa_up_model->get_daftar_spp($kode_unit_subunit,$tahun);
                           // echo '<pre>';var_dump($subdata['daftar_spm']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("rsa_permintaan/daftar_spm_verifikator",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }
                
                function spm_up_verifikator($url = ''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3))){
				        
                        $url = urldecode($url);

                            if( base64_encode(base64_decode($url, true)) === $url){
                                $url = base64_decode($url);
                            }else{
                                redirect(site_url('/'));
                            }

                            $arr_url = explode('/', $url);
                            $kd_unit = $this->unit_model->get_kd_unit_by_alias($arr_url[1]);
                            $tahun = $arr_url[4] ;
                            
                            // echo $kd_unit ; die ;

                                

                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE); 

                                $subdata['cur_tahun'] = $this->cur_tahun;


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
                                
                                
                                $dokumen =  'SPM-DRAFT-KPA' ; //$this->rsa_up_model->check_dokumen_up_by_str_trx($url);

                                $nomor_trx_spp = $url ;

                                // echo $nomor_trx_spp; die;

                                $id_nomor = $this->rsa_up_model->get_nomor_spp_urut_by_nomor_spp($nomor_trx_spp) ;
                                
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

                                ////////
                                // SPP ////
                                /////////
                                    
                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    $subdata['detail_permintaan']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'nama_rek_penerima' => $data_spp->nmrekening,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                
                                ////////
                                // SPM ////
                                /////////

                                    $nomor_trx_spm = $this->rsa_up_model->get_spm_by_spp($nomor_trx_spp);

                                    
                                    $data_spm = $this->rsa_up_model->get_data_spm($nomor_trx_spm);
                                    $subdata['detail_permintaan_spm'] 	= array(
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
                                        'nama_rek_penerima' => $data_spm->nmrekening,
                                        'no_rek_penerima' => $data_spm->rekening,
                                        'npwp_penerima' => $data_spm->npwp,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );

                                    
                                    $subdata['cur_tahun_spm'] = $data_spm->tahun;
                                    $subdata['tgl_spm'] = $data_spm->tgl_spm;
                                     
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                

                                $subdata['id_nomor'] = $id_nomor ;

                                $subdata['detail_verifikator']  = $this->rsa_up_model->get_verifikator_by_spm($nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu_by_spp($nomor_trx_spp);

                                $subdata['ket'] = $this->rsa_up_model->lihat_ket_by_str_trx($nomor_trx_spp);
                                
                                $subdata['doc'] = $dokumen;

                                $subdata['jenis'] = 'up';


                                $akun  = $this->akun_model->get_akun_by_id( $data_spp->id_akun_belanja);

                                $subdata['akun'] = array(
                                                        'id_akun_belanja' => $akun->id_akun_belanja,
                                                        'kode_akun' => $akun->kode_akun,
                                                        'nama_akun' => $akun->nama_akun,
                                                        'kode_akun5digit' => $akun->kode_akun5digit,
                                                        'nama_akun5digit' => $akun->nama_akun5digit,
                                                    );

				$data['main_content'] 			= $this->load->view("rsa_permintaan/spm_permintaan_verifikator",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
                
                function spm_up_kbuu($url = ''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==11)||($this->check_session->get_level()==100))){

				            $url = urldecode($url);

                            if( base64_encode(base64_decode($url, true)) === $url){
                                $url = base64_decode($url);
                            }else{
                                redirect(site_url('/'));
                            }

                            $arr_url = explode('/', $url);
                            $kd_unit = $this->unit_model->get_kd_unit_by_alias($arr_url[1]);
                            $tahun = $arr_url[4] ;
                            
                            // echo $kd_unit ; die ;

                                

                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE); 

                                $subdata['cur_tahun'] = $this->cur_tahun;


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
                                
                                
                                // $dokumen_up = $this->rsa_up_model->check_dokumen_up_by_str_trx($url);

                              
                                $dokumen = 'SPM-FINAL-VERIFIKATOR';//$dokumen_up;
                                
//                                $subdata['tgl_spm'] = $this->rsa_lsnk_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_lsnk_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spp = $url ;

                                // echo $nomor_trx_spp; die;

                                $id_nomor = $this->rsa_up_model->get_nomor_spp_urut_by_nomor_spp($nomor_trx_spp) ;
                                
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

                                /////////
                                // SPP ////
                                ////////
                                    
                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    $subdata['detail_permintaan']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'nama_rek_penerima' => $data_spp->nmrekening,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );
                                    



                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                /////////
                                // SPM ////
                                ////////


                                    $nomor_trx_spm = $this->rsa_up_model->get_spm_by_spp($nomor_trx_spp); 
                                    
                                    $data_spm = $this->rsa_up_model->get_data_spm($nomor_trx_spm);

                                    $subdata['detail_permintaan_spm'] 	= array(
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
                                        'nama_rek_penerima' => $data_spm->nmrekening,
                                        'no_rek_penerima' => $data_spm->rekening,
                                        'npwp_penerima' => $data_spm->npwp,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );

                                    $subdata['tgl_spm'] = $data_spm->tgl_spm;
                                    
                                    $subdata['cur_tahun_spm'] = $data_spm->tahun;
                                     

                                $subdata['id_nomor'] = $id_nomor ;

                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_up_model->get_verifikator_by_spm($nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu_by_spp($nomor_trx_spp);
                                
                                $subdata['ket'] = $this->rsa_up_model->lihat_ket_by_str_trx($nomor_trx_spp);
                                
                                $this->load->model('kas_undip_model');
                                
                                $subdata['kas_undip'] = $this->kas_undip_model->get_saldo_kas_all_akun();//get_akun_kas6_saldo();//(array('kd_kas_3'=>'111'));

                                // echo '<pre>';
                                // var_dump($subdata); die;
                            
                                $subdata['doc'] = $dokumen;

                                $subdata['jenis'] = 'up';

                                $akun  = $this->akun_model->get_akun_by_id( $data_spp->id_akun_belanja);

                                $subdata['akun'] = array(
                                                        'id_akun_belanja' => $akun->id_akun_belanja,
                                                        'kode_akun' => $akun->kode_akun,
                                                        'nama_akun' => $akun->nama_akun,
                                                        'kode_akun5digit' => $akun->kode_akun5digit,
                                                        'nama_akun5digit' => $akun->nama_akun5digit,
                                                    );

				$data['main_content'] 			= $this->load->view("rsa_permintaan/spm_permintaan_kbuu",$subdata,TRUE);
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
//                        $h = $this->load->view("rsa_permintaan/cetak",array('html'=>$html),TRUE);
//                        echo $h;
                        $this->load->library('Pdfgen'); 
                        $this->pdfgen->cetak($html,'SPP_up_'.$unit.'_'.''.$tahun);
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
                        $this->pdfgen->cetak($html,'SPM_up_');
                    }
                }
                
                function usulkan_spp_up(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                        if($this->input->post('proses')){
                            // die;
                            $proses = $this->input->post('proses');
                            $nomor_trx = $this->input->post('nomor_trx');
                            $nomor_ = explode('/',$nomor_trx);
                            $bulan = $nomor_[3];
                            $jenis = 'SPP';//$this->input->post('jenis');
                            $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                            $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                            $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;

                            $id_nomor_up = $this->input->post('id_nomor_up') ;

                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'nomor_trx' => $nomor_[0],
                                'str_nomor_trx' => $nomor_trx,
                                'jenis' => $jenis,
                                'tgl_proses' => date("Y-m-d H:i:s"),
                                'aktif' => '1',
                                'bulan' => $bulan,
                                'tahun' => $tahun,
//                                'urut' => $this->rsa_up_model->get_urut($kd_unit,$jenis,$tahun)
                            );
                            
                            $dokumen_up = $this->rsa_up_model->check_dokumen_up_by_str_trx($nomor_trx);

                            $check_exist_up = $this->rsa_up_model->check_exist_up($nomor_trx,$this->cur_tahun);

                            if((!$check_exist_up)&&($dokumen_up == '')){

                                if($this->rsa_up_model->proses_nomor_spp_up($kd_unit,$data) ){
                                    
                                    $data_spp = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        // 'nomor_trx_spp' => $this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                        'nomor_trx_spp' => $this->rsa_up_model->get_id_nomor_up_by_nomor_trx($nomor_trx),
                                        'str_nomor_trx' => $nomor_trx,
                                        'jumlah_bayar' => $this->input->post('jumlah_bayar'),
                                        'terbilang' => $this->input->post('terbilang'),
                                        'untuk_bayar' => $this->input->post('untuk_bayar'),
                                        'penerima' => $this->input->post('penerima'),
                                        'alamat' => $this->input->post('alamat'),
                                        'nmbank' => $this->input->post('nmbank'),
                                        'nmrekening' => $this->input->post('nmrekening'),
                                        'rekening' => $this->input->post('rekening'),
                                        'npwp' => $this->input->post('npwp'),
                                        'tahun' => $tahun,
                                        'nmbendahara' => $this->input->post('nmbendahara'),
                                        'nipbendahara' => $this->input->post('nipbendahara'),
                                        'tgl_spp' => date("Y-m-d H:i:s"),
                                        'id_akun_belanja' => $this->input->post('id_akun_belanja'),
                                    );
                                    
                                    $data = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'posisi' => $proses,
                                        // 'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                        'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up_by_nomor_trx($nomor_trx),
                                        'ket' => $ket,
                                        'aktif' => '1',
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );

                                   // var_dump($data);die;

                                    if($this->rsa_up_model->proses_up($kd_unit,$data,$id_nomor_up)&& $this->rsa_up_model->proses_data_spp($data_spp)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM anda berhasil disubmit.</div>');

                                        // echo urlencode(base64_encode($nomor_trx)); //"sukses";

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
                
                
                function usulkan_spm_up(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14))){
                        if($this->input->post('proses')){
                            $proses = $this->input->post('proses');
                            $nomor_trx = $this->input->post('nomor_trx');
                            $nomor_trx_spp = $this->input->post('nomor_trx_spp');
                            $nomor_ = explode('/',$nomor_trx);
                            $bulan = $nomor_[3];

                            $id_nomor_up = $this->input->post('id_nomor_up') ;

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
//                                'urut' => $this->rsa_up_model->get_urut($kd_unit,$jenis,$tahun)

                            );

                            // $data_spp_spm = array(
                            //     'kode_unit_subunit' => $kd_unit,
                            //     'nomor_trx_spp' => $nomor_spp_[0],
                            //     'str_nomor_trx_spp' => $nomor_trx_spp,
                            //     'nomor_trx_spm' => $nomor_[0],
                            //     'str_nomor_trx_spm' =>$nomor_trx,
                            //     'jenis_trx' => 'UP',
                            //     'tahun' => $tahun,
                            // );

                            

                            $dokumen_up = $this->rsa_up_model->check_dokumen_up_by_str_trx($nomor_trx_spp);

                            $check_exist_up = $this->rsa_up_model->check_exist_up($nomor_trx,$this->cur_tahun);

                            // echo $dokumen_lsnk; die;

                            // echo '<pre>' ; var_dump($this->input->post()); die;
                            
                            if((!$check_exist_up)&&($dokumen_up == 'SPP-FINAL')){

                                if($this->rsa_up_model->proses_nomor_spm_up($kd_unit,$data)){

                                    $id_trx_nomor_up = $this->rsa_up_model->get_id_nomor_up_by_nomor_trx($nomor_trx_spp) ;
                                    $id_trx_nomor_up_spm = $this->rsa_up_model->get_id_nomor_up_by_nomor_trx($nomor_trx) ;

                                    $data_spm = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        // 'nomor_trx_spm' => $this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                        'nomor_trx_spm' => $id_trx_nomor_up_spm,
                                        'str_nomor_trx' => $nomor_trx,
                                        'jumlah_bayar' => $this->input->post('jumlah_bayar'),
                                        'terbilang' => $this->input->post('terbilang'),
                                        'untuk_bayar' => $this->input->post('untuk_bayar'),
                                        'penerima' => $this->input->post('penerima'),
                                        'alamat' => $this->input->post('alamat'),
                                        'nmbank' => $this->input->post('nmbank'),
                                        'rekening' => $this->input->post('rekening'),
                                        'nmrekening' => $this->input->post('nmrekening'),
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
                                        'id_akun_belanja' => $this->input->post('id_akun_belanja'),
                                    );

                                    $data_spp_spm = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        // 'nomor_trx_spp' => $this->rsa_up_model->get_id_nomor_up('SPP',$kd_unit,$this->cur_tahun),
                                        'nomor_trx_spp' => $id_trx_nomor_up,
                                        'str_nomor_trx_spp' => $nomor_trx_spp,
                                        // 'nomor_trx_spm' => $this->rsa_up_model->get_id_nomor_up('SPM',$kd_unit,$this->cur_tahun),
                                        'nomor_trx_spm' => $id_trx_nomor_up_spm,
                                        'str_nomor_trx_spm' =>$nomor_trx,
                                        'jenis_trx' => 'UP',
                                        'tahun' => $tahun,
                                    );

                                    $data = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'posisi' => $proses,
                                        // 'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                        'id_trx_nomor_up' => $id_trx_nomor_up,
                                        'id_trx_nomor_up_spm' => $id_trx_nomor_up_spm,
                                        'ket' => $ket,
                                        'aktif' => '1',
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );

                                   // var_dump($data);die;

                                    if($this->rsa_up_model->proses_up($kd_unit,$data,$id_trx_nomor_up) && $this->rsa_up_model->proses_trx_spp_spm($data_spp_spm) && $this->rsa_up_model->proses_data_spm($data_spm)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM anda berhasil disubmit.</div>');
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
                
                function proses_spp_up(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $jenis = 'SPP';//$this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;

                        $id_nomor_up = $this->input->post('id_nomor_up') ;
                    
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                // 'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up_by_nomor_trx($nomor_trx),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );
                            
                        // echo '<pre>'; var_dump($data);die;
                        
                        $ok = FALSE ;
                            
                        //$dokumen = 'SPP-DRAFT'; //

                        $dokumen = $this->rsa_up_model->check_dokumen_up_by_str_trx($nomor_trx);
                        
                        if(($proses == 'SPP-FINAL')&&($dokumen == 'SPP-DRAFT')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPP-DITOLAK')&&($dokumen == 'SPP-DRAFT')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }    

                        // echo $ok ; die ;  
     
                            
                        if($ok){
                        

                            if($this->rsa_up_model->proses_up($kd_unit,$data,$id_nomor_up)){
                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM anda berhasil disubmit.</div>');
                                echo "sukses";
                            }else{
                                echo "gagal";
                            }

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
                        $jenis = 'SPM';//$this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;

                        $id_nomor_up = $this->input->post('id_nomor_up') ;
                        
                        
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                // 'id_trx_nomor_up' => $this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                'id_trx_nomor_up' => $id_nomor_up,
                                'id_trx_nomor_up_spm' => $this->rsa_up_model->get_id_nomor_up_by_nomor_trx($nomor_trx),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );
                            
                            // echo '<pre>';var_dump($data);die;
                            
                        $ok = FALSE ;
                            
                        $dokumen = $this->rsa_up_model->check_dokumen_up($kd_unit,$tahun,$id_nomor_up);

                        if(($proses == 'SPM-DRAFT-KPA')&&($dokumen == 'SPM-DRAFT-PPK')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-KPA')&&($dokumen == 'SPM-DRAFT-PPK')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-FINAL-VERIFIKATOR')&&($dokumen == 'SPM-DRAFT-KPA')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-VERIFIKATOR')&&($dokumen == 'SPM-DRAFT-KPA')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-FINAL-KBUU')&&($dokumen == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-KBUU')&&($dokumen == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-FINAL-BUU')&&($dokumen == 'SPM-FINAL-KBUU')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-BUU')&&($dokumen == 'SPM-FINAL-KBUU')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }
                        
                        
                        if($ok){

                            $nomor_trx_spm = $this->rsa_up_model->get_id_nomor_up_by_nomor_trx($nomor_trx) ;
                                    
                            if($this->rsa_up_model->proses_up($kd_unit,$data,$id_nomor_up)){
                                if($this->check_session->get_level() == 3){
                                    $verifikator = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
                                    $data_verifikator = array(
                                        'nomor_trx_spm' => $nomor_trx_spm ,//$this->rsa_up_model->get_id_nomor_up('SPM',$kd_unit,$tahun),//$nomor_[0],
                                        'str_nomor_trx_spm' => $nomor_trx,
                                        'kode_unit_subunit' => $kd_unit,
                                        'jenis_trx' => 'UP',
                                        'id_rsa_user_verifikator' => $verifikator->id,
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );
                                    if($this->rsa_up_model->proses_verifikator_up($data_verifikator)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM anda berhasil disubmit.</div>');
                                        echo "sukses";
                                    }else{
                                        echo "gagal";
                                    }
                                }else{
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM anda berhasil disubmit.</div>');
                                    echo "sukses";
                                }
                            }else{
                                echo "gagal";
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
                        
                        // $id_trx_nomor_lsnk = $this->rsa_lsnk_model->get_id_nomor_lsnk_by_nomor_trx($nomor_trx_spp) ;
                        $id_trx_nomor_up = $this->input->post('id_nomor_up') ;
                        $id_trx_nomor_up_spm = $this->rsa_up_model->get_id_nomor_up_by_nomor_trx($nomor_trx_spm) ;

                        $nomor_trx_spp = $this->rsa_up_model->get_spp_by_spm($nomor_trx_spm);

                        $tgl_proses = date("Y-m-d H:i:s") ;

                        $data = array(
                                    'kode_unit_subunit' => $kd_unit,
                                    'posisi' => $proses,
                                    'id_trx_nomor_up' => $id_trx_nomor_up,
                                    'id_trx_nomor_up_spm' => $id_trx_nomor_up_spm,
                                    'ket' => $ket,
                                    'aktif' => '1',
                                    'tahun' => $this->input->post('tahun'),
                                    'tgl_proses' => $tgl_proses,
                                );
                        
                        // $ok = FALSE ;

                        $ok = FALSE ;
                            
                        $dokumen_up = $this->rsa_up_model->check_dokumen_up_by_str_trx($nomor_trx_spp);

                        // echo '<pre>' ; var_dump($this->input->post()); die;
                        
                        if(($proses == 'SPM-FINAL-KBUU')&&($dokumen_up == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }

                        // echo '<pre>'; var_dump($data); die;
                            
                        if($ok){
                            
//                            echo $proses;die;
//                            $this->load->model('kas_bendahara_model');
//                            $saldo_ben = $this->kas_bendahara_model->get_kas_bendahara($kd_unit,$this->input->post('tahun'));
//                            echo $saldo_ben->saldo;die;

                            // echo $kd_unit . ' ' . $id_trx_nomor_up ; die;
                            
                            if($this->rsa_up_model->proses_up($kd_unit,$data,$id_trx_nomor_up)){
                                
                                // $this->load->model('kas_bendahara_model');
                                // $saldo_bendahara = $this->kas_bendahara_model->get_kas_saldo_tup($kd_unit,$this->cur_tahun);

                                $kd_akun_kas_bendahara = $this->input->post('kd_akun_kas_bendahara');

                                $saldo_penerima = $this->kas_bendahara_model->get_kas_bendahara_by_kd_akun_and_unit($kd_akun_kas_bendahara,$kd_unit,'UP',$this->cur_tahun);

                                // echo $saldo_penerima; die;
                                
                                $debet = $this->input->post('kredit') ;
                                $saldo_pic_akhir =  $saldo_penerima + $debet ;


                                $data = array(
                                    'tgl_trx' => $tgl_proses,
                                    'kd_akun_kas' =>  $kd_akun_kas_bendahara,
                                    'kd_unit' => $kd_unit,
                                    'deskripsi' => $this->input->post('deskripsi'),//'KS UNIT ' . $kd_unit,//$this->input->post('deskripsi'),
                                    'jenis' => 'UP',
                                    'no_spm' => $this->input->post('nomor_trx'),
                                    'kredit' => '0',
                                    'debet' => $debet,
                                    'saldo' => $saldo_pic_akhir,
                                    'aktif' => '1',
                                    'tahun' => $this->input->post('tahun'),
                                );

                                // echo '<pre>';
                                // var_dump($data); die;

                                $this->load->model('kas_undip_model');

                                $kd_akun_kas = $this->input->post('kd_akun_kas') ;
                                $nominal = $this->input->post('nominal') ;
                                $saldo = $this->kas_undip_model->get_nominal($kd_akun_kas) - $nominal ;

                                $data_kas = array(
                                    'tgl_trx' => $tgl_proses,
                                    'kd_akun_kas' => $kd_akun_kas,
                                    'kd_unit' => $kd_unit,//'99',
                                    'deskripsi' => $this->input->post('deskripsi'),//'ISI KS UNIT ' . $kd_unit,
                                    'no_spm' => $this->input->post('nomor_trx'),
                                    'debet' => '0',
                                    'kredit' => $nominal,
                                    'saldo' => $saldo,
                                    'aktif' => '1',
                                    'tahun' => $this->input->post('tahun'),
                                );

                                $data_spm_cair = array(
                                    'no_urut' => $this->rsa_up_model->get_next_urut_spm_cair($this->input->post('tahun')),
//                                    'nomor_trx_spm' => $this->rsa_up_model->get_id_nomor_up('SPM',$kd_unit,$this->input->post('tahun')),//,$nomor,
                                    'str_nomor_trx_spm' => $nomor_trx_spm,
                                    'str_nomor_trx_spp' => $nomor_trx_spp,
                                    'kode_unit_subunit' => $kd_unit,
                                    'jenis_trx' => 'UP',
                                    'nominal' => $nominal,
                                    'tgl_proses' => $tgl_proses,
                                    'bulan' => $nomor_[3],
                                    'tahun' => $this->input->post('tahun')
                                );

    //                            var_dump($data_spm_cair);die;

                                // $data_to_nihil = array(
                                //     'kode_unit_subunit' => $kd_unit,
                                //     'str_nomor_trx_spm_up' => $nomor_trx_spm,
                                //     'tgl_proses_up' => date('Y-m-d H:i:s'),
                                //     'tahun' => $this->input->post('tahun'),
                                //     'status' => '1',
                                // );

                                if($this->rsa_up_model->final_up($kd_unit,$data) && $this->kas_undip_model->isi_trx($data_kas) && $this->rsa_up_model->spm_cair($data_spm_cair)){ //&& $this->rsa_up_model->ks_to_nihil($data_ks_to_nihil)){

                                // if($this->kas_undip_model->isi_trx($data_kas) && $this->rsa_up_model->spm_cair($data_spm_cair)){
                                    
                                    // $saldo_ben = $this->kas_bendahara_model->get_kas_bendahara($kd_unit,$this->input->post('tahun'));
                                
                                    // $data_debet = array(
                                    //     'tgl_trx' => date("Y-m-d H:i:s"),
                                    //     'kd_akun_kas' => '112111',
                                    //     'kd_unit' => $kd_unit,
                                    //     'deskripsi' => 'DEBIT TUP UNIT ' . $kd_unit,//$this->input->post('deskripsi'),
                                    //     'no_spm' => $this->input->post('nomor_trx'),
                                    //     'kredit' => '0',
                                    //     'debet' => $this->input->post('kredit'),
                                    //     'saldo' => $saldo_ben->saldo + $this->input->post('kredit'),
                                    //     'aktif' => '2',
                                    //     'tahun' => $this->input->post('tahun'),
                                    // );
                                    
                                    // $this->rsa_lsnk_model->final_lsnk($kd_unit,$data_debet);
                                    
                                    // $data = array(
                                    //     'rel_kuitansi' => $rel_kuitansi,
                                    //     'str_nomor_trx_spm' => $this->input->post('nomor_trx'),
                                    // );

                                    // $data_pengembalian = array(
                                    //     'rel_kuitansi_pengembalian' => $rel_kuitansi_pengembalian,
                                    //     'str_nomor_trx_spm' => $this->input->post('nomor_trx'),
                                    // );

                                    // $this->kuitansi_model->set_cair($data);

                                    // $this->kuitansipengembalian_model->set_cair($data_pengembalian);

                                    // $this->rsa_lsnk_model->proses_lsnk_cair_rka($data);

                                            
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM anda berhasil disubmit.</div>');
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
					$data['url']		= site_url('rsa_permintaan/exec_delete/'.$this->uri->segment(3));
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
				$this->load->view('rsa_permintaan/row_rsa_up',$data);
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
				$this->load->view('rsa_permintaan/row_rsa_up',$data);
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
                            $data['main_content'] 		= $this->load->view("rsa_permintaan/saldo",$subdata,TRUE);
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
                            $subdata['kode_unit_subunit']           = $kode_unit_subunit;
                            $subdata['daftar_spp']          = $this->rsa_up_model->get_daftar_spp($kode_unit_subunit,$tahun);

                            // echo '<pre>';var_dump($subdata);echo '</pre>';die;

                            $subdata['jenis']           = 'up';

                            $data['main_content']           = $this->load->view("rsa_permintaan/daftar_spp",$subdata,TRUE);
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
                            $subdata['daftar_spp']          = $this->rsa_up_model->get_daftar_spp($kode_unit_subunit,$tahun);

                            // echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;

                            $data['main_content']           = $this->load->view("rsa_permintaan/daftar_spumk",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }

                function daftar_spm($tahun="",$kode_unit_subunit=""){
                    
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
                            $subdata['jenis']           = 'up';
                            $subdata['daftar_spp']          = $this->rsa_up_model->get_daftar_spp($kode_unit_subunit,$tahun);

                            // echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;



                            $data['main_content']           = $this->load->view("rsa_permintaan/daftar_spm",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }

                function daftar_spm_kpa($tahun="",$kode_unit_subunit=""){
                    
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
                            $subdata['jenis']           = 'up';
                            $subdata['daftar_spp']          = $this->rsa_up_model->get_daftar_spp($kode_unit_subunit,$tahun);

                            // echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;

                            $data['main_content']           = $this->load->view("rsa_permintaan/daftar_spm_kpa",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }
                
                function get_next_nomor_spp(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                            
                        $nomor_trx_ = $this->rsa_up_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);
                        setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");$thn = strftime("%Y");  
                        $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-UP'.'/'.strtoupper($bln).'/'.$thn;
                        
                        echo $nomor_trx ; 
                        
                    }
                }




                function get_status_nihil(){

                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                           // echo '5' ; 
                        $status = $this->rsa_up_model->get_status_nihil($this->check_session->get_unit(),$this->cur_tahun);
                        
                        echo $status ; 
                        
                    }

                }

                function get_notif_approve(){

                    if($this->check_session->user_session()){

                        $level = $this->check_session->get_level() ;

                        $kode_unit_subunit = $this->check_session->get_unit();

                        $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());

                        $notif = $this->rsa_up_model->get_notif_approve($kode_unit_subunit,$level,$user->id);

                        echo $notif ;
                    }

                }

                function get_data_untuk_pekerjaan(){
                    $q = $this->input->get('query');
                    $d = array('untuk_bayar'=>$q);
                    $kode_unit_subunit = $this->check_session->get_unit();
                    $data = $this->rsa_up_model->get_data_untuk_pekerjaan($d['untuk_bayar'],$kode_unit_subunit,$this->cur_tahun);
                    $json = [];

                    if(!empty($data)){

                        foreach($data as $d){
                            $json[] = $d->untuk_bayar ;
                        }
                    }

                    echo json_encode($json);
                }


                function get_data_penerima(){
                    $q = $this->input->get('query');
                    $kode_unit_subunit = $this->check_session->get_unit();
                    $data = $this->rsa_up_model->get_data_penerima($q,$kode_unit_subunit,$this->cur_tahun);
                    $json = [];
                    
                    if(!empty($data)){

                        foreach($data as $d){
                            // $json['nama_pihak_ketiga'] = $d->penerima ;
                            // $json['alamat_ketiga'] = $d->alamat ;

                            // $json[] = array(
                            //              'nama_pihak_ketiga' => $d->penerima,
                            //              'alamat_ketiga'=>$d->alamat
                            //             );
                            $json[] = $d->str_penerima ;

                        }
                    }

                    echo json_encode($json);
                }

                function get_notif_approve_all(){

                    if($this->check_session->user_session()){

                        $level = $this->check_session->get_level() ;

                        $kode_unit_subunit = $this->check_session->get_unit();

                        $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());

                        $notif_up = $this->rsa_up_model->get_notif_approve($kode_unit_subunit,$level,$user->id);

                        echo $notif_up ;
                    }

                }


               
                
                
		
	}

?>
