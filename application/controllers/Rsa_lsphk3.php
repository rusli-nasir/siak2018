<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class rsa_lsphk3 extends CI_Controller{
/* -------------- Constructor ------------- */
            
    private $cur_tahun;
	public function __construct(){ 
		parent::__construct();
			//load library, helper, and model
			
            $this->cur_tahun = $this->setting_model->get_tahun();
			$this->load->library(array('form_validation','option'));
			$this->load->helper('form');
			$this->load->model(array('rsa_lsphk3_model','setting_up_model','kuitansi_lsphk3_model'));
			$this->load->model("user_model");
			$this->load->model("unit_model");
            $this->load->model('menu_model');
			$this->load->helper("security");              
		}
		
		#methods ======================
		
		//define method index()
		function index(){
			$data['cur_tahun'] = $this->cur_tahun ;
                        $data['main_content']	= $this->load->view('rsa_lsphk3/index','',TRUE);
                        // $data['main_menu']	= $this->load->view('form_login','',TRUE);
                        $list["menu"] = $this->menu_model->show();
                        $list["submenu"] = $this->menu_model->show();
                        $data['main_menu']	= $this->load->view('main_menu','',TRUE);
//                        $data['message']	= validation_errors();
                        $this->load->view('main_template',$data);
		}
		
		//define method daftar_unit()
		
		function input_rsa_lsphk3(){
			if($this->check_session->user_session() && $this->check_session->get_level()==13){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
				$data['main_content'] 			= $this->load->view("rsa_lsphk3/input_rsa_lsphk3",$subdata,TRUE);
				$this->load->view('main_template',$data);
			}
			else{
				redirect('home','refresh');	// redirect ke halaman home
			}		
		}
                
           function spp_lsphk3($data_url=''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){
					
                    $id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
					$id=$id_[0];
					//var_dump($id);die;
					
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
                                
                                $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($this->check_session->get_unit(),$this->cur_tahun,$id);
								//var_dump($dokumen_lsphk3 = '');die;
                                $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                $subdata['unit_id'] = $this->check_session->get_unit();
                                $subdata['alias'] = $this->check_session->get_alias();
                                $array_id = '';
                                $pengeluaran = 0;
								 //$pekerjaan ='';
                              if(($dokumen_lsphk3 == '')||($dokumen_lsphk3 == 'SPP-DITOLAK')||($dokumen_lsphk3 == 'SPM-DITOLAK-KPA')||($dokumen_lsphk3 == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_lsphk3 == 'SPM-DITOLAK-KBUU')){
                                    $du = '' ;
                                    if($data_url != ''){
                                        $du = $data_url;
                                        $data_url = urldecode($data_url);
                                        if(base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_array_id($data_);
											//var_dump($data_);die;
                                        }else{
                                            $pengeluaran = 0;
                                        }
                                    }else{
                                        $pengeluaran = 0;
                                    }
									$subdata['kontrak_id'] = $this->kuitansi_lsphk3_model->get_kontrakid_by_array_id($data_);
									$subdata['detkontrak'] = $this->kuitansi_lsphk3_model->get_kontrak_by_id($data_);
									$subdata['pekerjaan'] = $this->kuitansi_lsphk3_model->get_pekerjaan_by_array_id($data_);
                                    $subdata['rel_kuitansi'] = $du;
									//var_dump($subdata['detkontrak']);die;
                                    $subdata['detail_lsphk3'] 			= array(
																					//'job' => $uraian,
                                                                                    'nom' => $pengeluaran,
                                                                                    'terbilang' => $this->convertion->terbilang($pengeluaran), 
                                                                                    
                                                                                );
                                    // var_dump($pekerjaan);die;                               

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
                                    );
                                    $subdata['tgl_spp'] = $this->rsa_lsphk3_model->get_tgl_spp($this->check_session->get_unit(),$this->cur_tahun,$id);

                                    $nomor_trx_ = $this->rsa_lsphk3_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun,$id);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");  
                                    $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-LSP3'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B");  
//                                    var_dump($subdata);die;
                                
                         }else{
                                    $nomor_trx = $this->rsa_lsphk3_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun,$id); 
									//var_dump($nomor_trx);die;
                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx,$id);
									//var_dump($nomor_trx);die;
                                    $du = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_lsphk3_model->get_id_detail_by_str_nomor_spp($nomor_trx);
									//var_dump($data_kuitansi);die;
                                    $kuitansi_d = array();
                                    if(!empty($data_kuitansi)){
                                        foreach($data_kuitansi as $dk){
                                            $kuitansi_d[] = $dk->id_kuitansi;
                                        }
                                    }
                                        $du_ = json_encode($kuitansi_d);
										
                                        $data_url = urlencode(base64_encode($du_));
                                        $du = $data_url ;
                                        $data_url = urldecode($data_url);
										//var_dump($du);die;
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
											
											 //$array_id = base64_decode($data_url) ;
    //                                        $array_id = $this->input->post('rel_kuitansi');
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
											
                                            $pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
									$subdata['kontrak_id'] = $this->kuitansi_lsphk3_model->get_kontrakid_by_array_id($data_);
									$subdata['detkontrak'] = $this->kuitansi_lsphk3_model->get_kontrak_by_id($data_);
									//var_dump($subdata['kontrak_id']);die;
									$subdata['pekerjaan'] = $this->kuitansi_lsphk3_model->get_pekerjaan_by_array_id($data_);
                                    $subdata['rel_kuitansi'] = $du;
                                    $subdata['detail_lsphk3'] 	= array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 
                                                                );
									//var_dump($subdata['detail_lsphk3']);die;
                                    $subdata['cur_tahun'] = $data_spp->tahun;
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,                                      
                                    );
                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp));  
								}
                                
                                $data_akun_pengeluaran = array();   
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit($data__);
                                    $rincian_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_rekap_detail_kuitansi($data__);
                                  //  echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
                                    $data_spp_pajak = $this->kuitansi_lsphk3_model->get_spp_pajak($data__);
//                                    print_r($data_spp_pajak);die;
                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                   echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    $data_akun_rkat = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun_rkat($data___);
                                 
                                    $data_akun_pengeluaran_lalu = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit_lalu($data___);
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
                                }
                                
                                
                                
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['doc_lsphk3'] = $dokumen_lsphk3;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                $subdata['ket'] = $this->rsa_lsphk3_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun,$id);
                                //var_dump($subdata['pekerjaan']); die();
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata['detail_pic']);die;
				$data['main_content'] 			= $this->load->view("rsa_lsphk3/spp_lsphk3",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
                
                
		function create_spm_lsphk3(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
							$array_id = $this->input->post('rel_kuitansi');
                            $data = urlencode(base64_encode($array_id)); 
							//var_dump($data);die;
                            // redirect(site_url('rsa_lsphk3/spp_lsphk3_bendahara/' . $data));
							redirect(site_url('rsa_lsphk3/spm_lsphk3/' . $data));
                        }
                        
                    }
                } 
                
		function create_spp_lsphk3(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
							$array_id = $this->input->post('rel_kuitansi');
                            $data = urlencode(base64_encode($array_id)); 
                            // redirect(site_url('rsa_lsphk3/spp_lsphk3_bendahara/' . $data));
							redirect(site_url('rsa_lsphk3/spp_lsphk3/' . $data));
                        }
                        
                    }
                }
		function view_spm_lsphk3_kpa(){
            // var_dump($_POST); exit;
                    if($this->check_session->user_session() && (($this->check_session->get_level()==2)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
							$array_id = $this->input->post('rel_kuitansi');
                            $data = urlencode(base64_encode($array_id)); 
                            // redirect(site_url('rsa_lsphk3/spp_lsphk3_bendahara/' . $data));
							redirect(site_url('rsa_lsphk3/spm_lsphk3_kpa/' . $data));
                        }
                        
                    }
                }
		function view_spm_lsphk3_verifikator(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==3)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
							$array_id = $this->input->post('rel_kuitansi');
                            $data = urlencode(base64_encode($array_id)); 
                            // redirect(site_url('rsa_lsphk3/spp_lsphk3_bendahara/' . $data));
							redirect(site_url('rsa_lsphk3/spm_lsphk3_verifikator/' . $data));
                        }
                        
                    }
                }
		function usulkan_spp_lsphk3(){
			  if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $bulan = $nomor_[3];
                        $jenis = $this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                        $rel_kuitansi_ = $this->input->post('rel_kuitansi');
                        $rel_kuitansi = urldecode($rel_kuitansi_);
                        if( base64_encode(base64_decode($rel_kuitansi, true)) === $rel_kuitansi){
                            $rel_kuitansi = base64_decode($rel_kuitansi);
                        }else{
                            redirect(site_url('/'));
                        }
                                              
						$rel_k = json_decode($rel_kuitansi);
						$rel_k_ = $rel_k[0] ;
						$id=$rel_k_;
                        
                        $data = array(
                            'kode_unit_subunit' => $kd_unit,
                            'nomor_trx' => $nomor_[0],
                            'str_nomor_trx' => $nomor_trx,
                            'jenis' => $jenis,
                            'tgl_proses' => date("Y-m-d H:i:s"),
                            'aktif' => '1',
                            'bulan' => $bulan,
                            'tahun' => $tahun,
							'id_kuitansi'=> $rel_k_,
                        );
                        //var_dump($id);die;
                        $data_spp = array(
                            'kode_unit_subunit' => $kd_unit,
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
							'id_kuitansi'=> $rel_k_,
                        );
                        
                      // var_dump($rel_k_);die;
                        
                        $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($kd_unit,$tahun,$id);
                        //var_dump($data);die;
                        if(($dokumen_lsphk3 == '')||($dokumen_lsphk3 == 'SPP-DITOLAK')||($dokumen_lsphk3 == 'SPM-DITOLAK-KPA')||($dokumen_lsphk3 == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_lsphk3 == 'SPM-DITOLAK-KBUU')){
                            if($this->rsa_lsphk3_model->proses_nomor_spp_lsphk3($kd_unit,$data) && $this->rsa_lsphk3_model->proses_data_spp($data_spp)){

                                $data = array(
                                    'kode_unit_subunit' => $kd_unit,
                                    'posisi' => $proses,
                                    'id_trx_nomor_lsphk3' => $this->rsa_lsphk3_model->get_id_nomor_lsphk3($jenis,$kd_unit,$this->cur_tahun,$id),
                                    'ket' => $ket,
                                    'aktif' => '1',
                                    'tahun' => $tahun,
                                    'tgl_proses' => date("Y-m-d H:i:s"),
									'id_kuitansi'=> $rel_k_,
                                );

                                //var_dump($id_trx_nomor_lsphk3);die;

                                if($this->rsa_lsphk3_model->proses_lsphk3($kd_unit,$data,$id)){
                                    
                                    $data = array(
                                        'rel_kuitansi' => $rel_kuitansi,
                                        'str_nomor_trx' => $nomor_trx,
                                    );
                                    $this->load->model('kuitansi_lsphk3_model');
                                    $this->kuitansi_lsphk3_model->insert_spp($data);
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
                }
                }
		function usulkan_spp_lsphk3_nk(){
			  if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $bulan = $nomor_[3];
                        $jenis = $this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                        $rel_kuitansi_ = $this->input->post('rel_kuitansi');
                        $rel_kuitansi = urldecode($rel_kuitansi_);
                        if( base64_encode(base64_decode($rel_kuitansi, true)) === $rel_kuitansi){
                            $rel_kuitansi = base64_decode($rel_kuitansi);
                        }else{
                            redirect(site_url('/'));
                        }
                        
						$nm_subkomponen = json_decode($this->input->post('nm_subkomponen'));
                        $keluaran = json_decode($this->input->post('keluaran'));
						
						$rel_k = json_decode($rel_kuitansi);
						$rel_k_ = $rel_k[0] ;
						$id=$rel_k_;
						//var_dump($id);die;
						
                        
//                            var_dump($keluaran);die;
                        $c_subkomponen = count($nm_subkomponen);
                            $f_subkomponen = array() ;
                            foreach($keluaran as $kel){
                                if(!empty($kel)){
                                    foreach($nm_subkomponen as $nms){
                                        if($nms == $kel[0]){
                                            if (!in_array($nms, $f_subkomponen)) {
                                                $f_subkomponen[] = $nms ; break ;
                                            }
                                        }
                                    }
                                }
                            }
                            
                            //var_dump($f_subkomponen);die;
                            
                            $c_keluaran = count($f_subkomponen);
                            
//                            echo $c_keluaran . '  ' . $c_subkomponen ; die;
                            
                            if(($c_subkomponen > 0) && ($c_subkomponen == $c_keluaran)){
                                
                               $data = array(
									'kode_unit_subunit' => $kd_unit,
									'nomor_trx' => $nomor_[0],
									'str_nomor_trx' => $nomor_trx,
									'jenis' => $jenis,
									'tgl_proses' => date("Y-m-d H:i:s"),
									'aktif' => '1',
									'bulan' => $bulan,
									'tahun' => $tahun,
									'id_kuitansi'=> $id,
							);
                        $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($kd_unit,$tahun,$id);
                       // var_dump($data);die;
                        if(($dokumen_lsphk3 == '')||($dokumen_lsphk3 == 'SPP-DITOLAK')||($dokumen_lsphk3 == 'SPM-DITOLAK-KPA')||($dokumen_lsphk3 == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_lsphk3 == 'SPM-DITOLAK-KBUU')){
                            
							if($this->rsa_lsphk3_model->proses_nomor_spp_lsphk3($kd_unit,$data,$id)){
							
							$data_spp = array(
                            'kode_unit_subunit' => $kd_unit,
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
							'id_kuitansi'=> $id,
                        );
						 $data = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'posisi' => $proses,
                                            'id_trx_nomor_lsphk3' => $this->rsa_lsphk3_model->get_id_nomor_lsphk3($jenis,$kd_unit,$this->cur_tahun,$id),
                                            'ket' => $ket,
                                            'aktif' => '1',
                                            'tahun' => $tahun,
                                            'tgl_proses' => date("Y-m-d H:i:s"),
											'id_kuitansi'=> $id,
                                        );
										
						if($this->rsa_lsphk3_model->proses_lsphk3($kd_unit,$data,$id) && $this->rsa_lsphk3_model->proses_data_spp($data_spp)){	
                                //if($this->rsa_lsphk3_model->proses_lsphk3($kd_unit,$data,$id)){
                                      $keluaran = json_decode($this->input->post('keluaran'));
                                            $data = array();
                                            foreach($keluaran as $kel){
                                                if(!empty($kel)){
                                                    $data[] = array(
                                                        'str_nomor_trx_spp' => $nomor_trx,
                                                        'kode_usulan_rka' => $kel[0],
                                                        'keluaran' => $kel[1],
                                                        'volume' => $kel[2],
                                                        'satuan' => $kel[3],
                                                        'kode_unit_subunit' => $kd_unit,
                                                        'tahun' => $this->cur_tahun,
														'id_kuitansi' => $id,
                                                    );
                                                }
                                            }
									$this->rsa_lsphk3_model->insert_keluaran($data);
                                    $data = array(
                                        'rel_kuitansi' => $rel_kuitansi,
                                        'str_nomor_trx' => $nomor_trx,
                                    );
                                    $this->load->model('kuitansi_lsphk3_model');
                                    $this->kuitansi_lsphk3_model->insert_spp($data);
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM LS3NK anda berhasil disubmit.</div>');
                                    	echo "sukses";
                                    }else{
                                            echo "gagal";
                                        }

                                    }else{
                                        echo "gagal";
                                    }

                                }
                                
                               
 
                            }else{
                                echo "gagal";
                            }


                            
                        }

                        }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                        }
                }
		   
		function proses_spp_lsphk3(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
						$id = $this->input->post('kuitansi_id');
						//var_dump($id);die;
                        $nomor_ = explode('/',$nomor_trx);
                        $jenis = 'SPP';//$this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;

                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                'id_trx_nomor_lsphk3' => $this->rsa_lsphk3_model->get_id_nomor_lsphk3($jenis,$kd_unit,$this->cur_tahun,$id),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s"),
								'id_kuitansi'=> $id,
                            );
                            
                          // var_dump($data);die;
                        
                        $ok = FALSE ;
                            
                        $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($kd_unit,$tahun,$id);
                       //var_dump($dokumen_lsphk3);die;
                        if(($proses == 'SPP-FINAL')&&($dokumen_lsphk3 == 'SPP-DRAFT')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPP-DITOLAK')&&($dokumen_lsphk3 == 'SPP-DRAFT')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }
                            
                        if($ok){
//                            echo 'jos'; die;
                            if($this->rsa_lsphk3_model->proses_lsphk3($kd_unit,$data,$id)){
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
			function proses_spm_lsphk3(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
						$id = $this->input->post('kuitansi_id');
                        $jenis = 'SPM';//$this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
						//var_dump($ket);die;
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                'id_trx_nomor_lsphk3' => $this->rsa_lsphk3_model->get_id_nomor_lsphk3($jenis,$kd_unit,$this->cur_tahun,$id),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s"),
								'id_kuitansi'=> $id,
                            );
                            
                            //var_dump($data);die;
                            
                        $ok = FALSE ;
                            
                        $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($kd_unit,$tahun,$id);
						//var_dump($dokumen_lsphk3);die;
                        
                        if(($proses == 'SPM-DRAFT-KPA')&&($dokumen_lsphk3 == 'SPM-DRAFT-PPK')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-KPA')&&($dokumen_lsphk3 == 'SPM-DRAFT-PPK')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-FINAL-VERIFIKATOR')&&($dokumen_lsphk3 == 'SPM-DRAFT-KPA')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-VERIFIKATOR')&&($dokumen_lsphk3 == 'SPM-DRAFT-KPA')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-FINAL-KBUU')&&($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-KBUU')&&($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-FINAL-BUU')&&($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPM-DITOLAK-BUU')&&($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }
                            
                        if($ok){
//                            echo 'jos';die;
                            $nomor_trx_spm = $this->rsa_lsphk3_model->get_id_nomor_lsphk3('SPM',$kd_unit,$tahun,$id);
							//var_dump($nomor_trx_spm);die;
                            
                            if($this->rsa_lsphk3_model->proses_lsphk3($kd_unit,$data,$id)){
                                if($this->check_session->get_level() == 3){
                                    $verifikator = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
                                    $data_verifikator = array(
                                        'nomor_trx_spm' => $nomor_trx_spm,
                                        'str_nomor_trx_spm' => $nomor_trx,
                                        'kode_unit_subunit' => $kd_unit,
                                        'jenis_trx' => 'LS3',
                                        'id_rsa_user_verifikator' => $verifikator->id,
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );
                                    if($this->rsa_lsphk3_model->proses_verifikator_lsphk3($data_verifikator)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM L3 anda berhasil disubmit.</div>');
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
                }
		  function spm_lsphk3_kpa($data_url=''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==2)||($this->check_session->get_level()==100))){
				// var_dump($data_url);die;

						$data['user_menu']	= $this->load->view('user_menu','',TRUE);
						$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				//$subdata_rsa_up['result_rsa_up'] 		= $this->rsa_lsphk3_model->search_rsa_up();
				$id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
				$id=$id_[0];
				// var_dump($id);die;
				
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
                                
                                $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($this->check_session->get_unit(),$this->cur_tahun,$id);
                              
                                $subdata['doc_lsphk3'] = $dokumen_lsphk3;
                               // var_dump($dokumen_lsphk3);die;
							    $nomor_trx_spp = $this->rsa_lsphk3_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun,$id); 
                                
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
																	
                                        $du = $data_url ;
                                        $data_url = urldecode($data_url);
										// var_dump($data_url);die;
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
											
											 //$array_id = base64_decode($data_url) ;
    //                                        $array_id = $this->input->post('rel_kuitansi');
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
											
                                            $pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
									$subdata['kontrak_id'] = $this->kuitansi_lsphk3_model->get_kontrakid_by_array_id($data_);
									$subdata['detkontrak'] = $this->kuitansi_lsphk3_model->get_kontrak_by_id($data_);
									//$data_akun_pengeluaran = $this->rsa_lsphk3_model->get_pengeluaran_by_akun5digit($data__);
								// var_dump($data_spp);die;
                                 if(($dokumen_lsphk3 == 'SPP-FINAL') || ($dokumen_lsphk3 == 'SPP-DRAFT') || ($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx_spp,$id);
                                    // var_dump($data_spp);die;
                                    $subdata['detail_lsphk3']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
									
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,                                       
                                    );


                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                
                                $nomor_trx_spm = '';
                                // echo "<pre>"; var_dump($subdata); echo "</pre>";  die;
                                if(($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_lsphk3_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun,$id);  
                                  // var_dump($nomor_trx_spm);die;
                                    $data_spm = $this->rsa_lsphk3_model->get_data_spm($nomor_trx_spm);
									//echo "<pre>";
									//var_dump($data_spm);die;
									//echo "</pre>";
                                    $subdata['detail_lsphk3'] 	= array(
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
                                    $subdata['detail_kuasa_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkbuu,
                                        'nomor_induk' => $data_spm->nipkbuu
                                    );
									 $subdata['detail_verifikator']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmverifikator,
                                        'nomor_induk' => $data_spm->nipverifikator
                                    );
                                    $subdata['detail_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmbuu,
                                        'nomor_induk' => $data_spm->nipbuu
                                    );
                                    

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
                                // echo "<pre>"; var_dump($subdata); echo "</pre>";  die;
                                $data_akun_pengeluaran = array();   
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit($data__);
                                    $rincian_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_rekap_detail_kuitansi($data__);
                                  //  echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
                                    $data_spp_pajak = $this->kuitansi_lsphk3_model->get_spp_pajak($data__);
                                    // var_dump($data_spp_pajak);die;
                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                   echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    $data_akun_rkat = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun_rkat($data___);
                                 
                                    $data_akun_pengeluaran_lalu = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit_lalu($data___);
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
                                }
                                
                                
                                // echo "<pre>"; var_dump($subdata); echo "</pre>";  die;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                 $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                 $subdata['tgl_spm_kpa'] = $this->rsa_lsphk3_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_lsphk3_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_lsphk3_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');
                                $subdata['ket'] = $this->rsa_lsphk3_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun,$id);
								//var_dump($subdata['ket']);die;
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
                               // echo "<pre>"; var_dump($subdata); echo "</pre>";  die;
				$data['main_content'] 			= $this->load->view("rsa_lsphk3/spm_lsphk3_kpa",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
		
			function usulkan_spm_lsphk3(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14))){
                        if($this->input->post('proses')){
                            $proses = $this->input->post('proses');
                            $nomor_trx = $this->input->post('nomor_trx');
                            $nomor_trx_spp = $this->input->post('nomor_trx_spp');
                            $nomor_ = explode('/',$nomor_trx);
                            $bulan = $nomor_[3];
							$jenis = $this->input->post('jenis');
							//$id = $this->input->post('kuitansi_id');
							$ket = $this->input->post('ket')?$this->input->post('ket'):'';
							$kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
							$tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
							$id = $this->input->post('kuitansi_id');
                                          
							
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
								'id_kuitansi'=> $id,
                            );
                            
                                // var_dump($data);die; 

    //                        var_dump($data_spm);die;

                            $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($kd_unit,$tahun,$id);
							//var_dump($dokumen_lsphk3);die;
                            if($dokumen_lsphk3 == 'SPP-FINAL'){
    //                        $this->rsa_lsphk3_model->proses_data_spm($data_spm);
    //                        var_dump($data_spm);die;

                                if($this->rsa_lsphk3_model->proses_nomor_spm_lsphk3($kd_unit,$data,$id)){
                                    $data_spm = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'nomor_trx_spm' => $this->rsa_lsphk3_model->get_id_nomor_lsphk3($jenis,$kd_unit,$this->cur_tahun,$id),
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
										//'id_kuitansi'=> $id,
                                    );
								//var_dump($data_spm);die;
                                    $data_spp_spm = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'nomor_trx_spp' => $this->rsa_lsphk3_model->get_id_nomor_lsphk3('SPP',$kd_unit,$this->cur_tahun,$id),//$nomor_spp_[0],$this->rsa_lsphk3_model->get_id_nomor_lsphk3($jenis,$kd_unit,$this->cur_tahun),
                                        'str_nomor_trx_spp' => $nomor_trx_spp,
										//var_dump($nomor_trx_spp);die;
                                        'nomor_trx_spm' => $this->rsa_lsphk3_model->get_id_nomor_lsphk3('SPM',$kd_unit,$this->cur_tahun,$id),//$nomor_[0],
                                        'str_nomor_trx_spm' =>$nomor_trx,
                                        'jenis_trx' => 'LS3',
                                        'tahun' => $tahun,
										//'id_kuitansi'=> $id,
                                    );
									// var_dump($data_spp_spm);die;
                                    $data = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'posisi' => $proses,
                                        'id_trx_nomor_lsphk3' => $this->rsa_lsphk3_model->get_id_nomor_lsphk3($jenis,$kd_unit,$this->cur_tahun,$id),
                                        'ket' => $ket,
                                        'aktif' => '1',
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s"),
										'id_kuitansi'=> $id,
                                    );

                                  // var_dump($data);die;

                                    if($this->rsa_lsphk3_model->proses_lsphk3($kd_unit,$data,$id)&& $this->rsa_lsphk3_model->proses_trx_spp_spm($data_spp_spm) && $this->rsa_lsphk3_model->proses_data_spm($data_spm)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM UP anda berhasil disubmit.</div>');
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
				function spm_lsphk3($data_url=''){
			   //$id='';
                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				$id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
					$id=$id_[0];
				//var_dump($id);die;
                                $subdata['cur_tahun'] = $this->cur_tahun;
                                $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                $subdata['unit_id'] = $this->check_session->get_unit();
                                $subdata['alias'] = $this->check_session->get_alias();
//                                $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');

                                $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($this->check_session->get_unit(),$this->cur_tahun,$id);
                            //var_dump($dokumen_lsphk3);die;
                                $subdata['doc_lsphk3'] = $dokumen_lsphk3;
                                $subdata['tgl_spm'] = $this->rsa_lsphk3_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun,$id);
                              //  var_dump($subdata['tgl_spm']);die;
                                $nomor_trx_spp = $this->rsa_lsphk3_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun,$id); 
                                 //var_dump($nomor_trx_spp);die;
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
                                
                                $array_id = '';
                                $pengeluaran = 0;
                                
                                if(($dokumen_lsphk3 == 'SPP-FINAL') || ($dokumen_lsphk3 == 'SPP-DRAFT') || ($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx_spp,$id);
                                   // var_dump($data_spp);die;
                                    
                                    $du = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_lsphk3_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
								//	var_dump($data_kuitansi);die;
                                    $kuitansi_d = array();
                                    if(!empty($data_kuitansi)){
                                        foreach($data_kuitansi as $dk){
                                            $kuitansi_d[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 

                                        $du_ = json_encode($kuitansi_d);
                                        $data_url = urlencode(base64_encode($du_));
                                        $du = $data_url ;
                                        $data_url = urldecode($data_url);
										//var_dump($du_);die;
                                        if($id!=0){
                                            $array_id = base64_decode($data_url) ;
    //                                        $array_id = $this->input->post('rel_kuitansi');
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                               'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengeluaran = $this->rsa_lsphk3_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }
									$subdata['kontrak_id'] = $this->kuitansi_lsphk3_model->get_kontrakid_by_array_id($data_);
									$subdata['detkontrak'] = $this->kuitansi_lsphk3_model->get_kontrak_by_id($data_);
								
									$subdata['pekerjaan'] = $this->rsa_lsphk3_model->get_pekerjaan_by_array_id($data_);
									//var_dump($subdata['pekerjaan']);die;
                                    $subdata['rel_kuitansi'] = $du;
                                    
                                    $subdata['detail_lsphk3']   = array(
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



    //                                if(($dokumen_lsphk3 == '') || ($dokumen_lsphk3 == 'SPP-DITOLAK') || ($dokumen_lsphk3 == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                if(($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_lsphk3_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun,$id);  
                                    //var_dump($nomor_trx_spm);die;
                                    $data_spm = $this->rsa_lsphk3_model->get_data_spm($nomor_trx_spm);
									//var_dump($data_spm);die;
                                    $subdata['detail_spm_lsphk3'] 	= array(
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
                                    
                                    $nomor_trx_ = $this->rsa_lsphk3_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-LS PIHAK KE-3'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    
//                                    echo $nomor_trx_spp ; die;
                                    
//                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx_spp);
                                    $subdata['detail_spm_lsphk3'] 	= array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    
                                    $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                    $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
									$subdata['detail_verifikator']  = $this->rsa_lsphk3_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
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
                                    
                                }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
									$subdata['kontrak_id'] = $this->kuitansi_lsphk3_model->get_kontrakid_by_array_id($data_);
									$subdata['detkontrak'] = $this->kuitansi_lsphk3_model->get_kontrak_by_id($data_);
									//var_dump($subdata['detkontrak']);die;
									$subdata['pekerjaan'] = $this->rsa_lsphk3_model->get_pekerjaan_by_array_id($data_);
                                    //print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit($data__);
//                                    $data_array_id = json_decode($array_id);
//                                    if(count($data_array_id) > 1){
//                                        foreach($data_array_id as $id){
////                                            $str_ .= "rsa.rsa_kuitansi.id_kuitansi = '{$id}' OR " ;
//                                            $rincian_akun_pengeluaran[] = $this->kuitansi_model->get_rekap_detail_kuitansi($id,$this->cur_tahun);
//                                        }
////                                        $str_ = substr($str_,0,  strlen($str_) - 3 );
//                                    }else{
//                                        $rincian_akun_pengeluaran[] = $this->kuitansi_model->get_rekap_detail_kuitansi($data_array_id[0],$this->cur_tahun);
////                                        $str_ = "rsa.rsa_kuitansi.id_kuitansi = '{$data['array_id'][0]}'" ;
//                                    }
                                    
//                                    function get_data_detail_kuitansi($id_kuitansi,$tahun){
//                                    $rincian_akun_pengeluaran = 
                                    $rincian_akun_pengeluaran = $this->rsa_lsphk3_model->get_rekap_detail_kuitansi($data__);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                    $data_spp_pajak = $this->kuitansi_lsphk3_model->get_spp_pajak($data__);
                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    $data_akun_rkat = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $data_akun_pengeluaran_lalu = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit_lalu($data___);
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
                                 //   var_dump($data_spp_pajak);die;
                                }
								
                                
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                               // var_dump($subdata['data_spp_pajak']);die;
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                //$subdata['detail_verifikator']  = $this->rsa_lsphk3_model->get_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_lsphk3_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_lsphk3_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_lsphk3_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_lsphk3_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun,$id);
                                
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
				$data['main_content'] 			= $this->load->view("rsa_lsphk3/spm_lsphk3",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
			
		function daftar_spp(){
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14))){
					$kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();   
					$subdata['daftar_spp'] = array();
					$subdata['cur_tahun'] = $this->cur_tahun;
					$unit=$this->check_session->get_unit();
					$sql = "SELECT tahun FROM trx_lsphk3 GROUP BY tahun ORDER BY tahun ASC";
					$subdata['tahun'] = $this->db->query($sql)->result();
					// $d = $this->uri->uri_to_assoc(3);
					// if(isset($d['tahun'])){
						$sql = "SELECT a.*,b.*,DATE_FORMAT(a.tgl_proses, '%d %M %Y') as tanggal2 FROM trx_lsphk3 a LEFT JOIN trx_nomor_lsphk3 b ON a.id_kuitansi = b.id_kuitansi LEFT JOIN rsa_kuitansi_lsphk3 c ON a.id_kuitansi=c.id_kuitansi WHERE a.kode_unit_subunit='{$unit}' AND a.tahun='".intval($subdata['cur_tahun'])."' AND b.jenis='SPP' AND c.jenis='L3' GROUP BY a.id_kuitansi ORDER BY a.id_kuitansi DESC";
						$subdata['daftar_spp'] = $this->db->query($sql)->result();
						
						//var_dump($sql);die;
					// }
					$data['user_menu']  = $this->load->view('user_menu','',TRUE);
					$data['main_menu']  = $this->load->view('main_menu','',TRUE);
					$data['main_content'] = $this->load->view("rsa_lsphk3/daftar_spp",$subdata,TRUE);
					$this->load->view('main_template',$data);
			}else{
				redirect('welcome','refresh');
				}
		}
		function daftar_spp_l3nk(){
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14))){
					$kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();   
					$subdata['daftar_spp'] = array();
					$subdata['cur_tahun'] = $this->cur_tahun;
					$unit=$this->check_session->get_unit();
					$sql = "SELECT tahun FROM trx_lsphk3 GROUP BY tahun ORDER BY tahun ASC";
					$subdata['tahun'] = $this->db->query($sql)->result();
					// $d = $this->uri->uri_to_assoc(3);
					// if(isset($d['tahun'])){
						$sql = "SELECT a.*,b.*,DATE_FORMAT(a.tgl_proses, '%d %M %Y') as tanggal2 FROM trx_lsphk3 a LEFT JOIN trx_nomor_lsphk3 b ON a.id_kuitansi = b.id_kuitansi LEFT JOIN rsa_kuitansi_lsphk3 c ON a.id_kuitansi=c.id_kuitansi WHERE a.kode_unit_subunit='{$unit}' AND a.tahun='".intval($subdata['cur_tahun'])."' AND b.jenis='SPP' AND c.jenis='L3NK' GROUP BY a.id_kuitansi ORDER BY a.id_kuitansi DESC";
						$subdata['daftar_spp'] = $this->db->query($sql)->result();
						
						//var_dump($sql);die;
					// }
					$data['user_menu']  = $this->load->view('user_menu','',TRUE);
					$data['main_menu']  = $this->load->view('main_menu','',TRUE);
					$data['main_content'] = $this->load->view("rsa_lsphk3/daftar_spp_l3nk",$subdata,TRUE);
					$this->load->view('main_template',$data);
			}else{
				redirect('welcome','refresh');
				}
		}
		function daftar_spm(){
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
					$kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();   
					$subdata['daftar_spm'] = array();
					$unit=$this->check_session->get_unit();
					$subdata['cur_tahun'] = $this->cur_tahun;
					$sql = "SELECT tahun FROM trx_lsphk3 GROUP BY tahun ORDER BY tahun ASC";
					$subdata['tahun'] = $this->db->query($sql)->result();
					// $d = $this->uri->uri_to_assoc(3);
					// if(isset($d['tahun'])){
						$sql = "SELECT a.*,b.*,DATE_FORMAT(a.tgl_proses, '%d %M %Y') as tanggal2 FROM trx_lsphk3 a LEFT JOIN trx_nomor_lsphk3 b ON a.id_kuitansi = b.id_kuitansi LEFT JOIN rsa_kuitansi_lsphk3 c ON a.id_kuitansi=c.id_kuitansi WHERE a.kode_unit_subunit='{$unit}' AND a.tahun='".intval($subdata['cur_tahun'])."' AND b.jenis='SPM' AND c.jenis='L3' GROUP BY a.id_kuitansi ORDER BY a.id_kuitansi DESC";
						$subdata['daftar_spm'] = $this->db->query($sql)->result();
						
						//var_dump($sql);die;
					// }
					$data['user_menu']  = $this->load->view('user_menu','',TRUE);
					$data['main_menu']  = $this->load->view('main_menu','',TRUE);
					$data['main_content'] = $this->load->view("rsa_lsphk3/daftar_spm",$subdata,TRUE);
					$this->load->view('main_template',$data);
			}else{
				redirect('welcome','refresh');
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
                            $sql = "SELECT kode_unit_subunit FROM rsa_verifikator_unit WHERE id_user_verifikator = ".$user->id;
                            $r = $this->db->query($sql)->result();
                            // var_dump($r); exit;
                            $subdata['unit_usul'] 		= $this->rsa_lsphk3_model->get_lsphk3_unit_usul_verifikator($user->id, $tahun, $r);
                            $subdata['subunit_usul']  		= $this->rsa_lsphk3_model->get_lsphk3_subunit_usul_verifikator($user->id,$tahun, $r);
                            // echo '<pre>';var_dump($subdata['subunit_usul']);echo '</pre>';die;
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();\
                            // print_r($subdata); exit;
                            $data['main_content'] 		= $this->load->view("rsa_lsphk3/daftar_unit",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
		function daftar_spm_verifikator($kode_unit,$tahun){
			$data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3))){
					$user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
					$subdata['cur_tahun'] =  $tahun;					
					$subdata['spm_usul']= $this->rsa_lsphk3_model->get_spm_verifikator($kode_unit,$user->id,$tahun);
                    $subdata['id_unit'] = $kode_unit;
					$data['user_menu']  = $this->load->view('user_menu','',TRUE);
					$data['main_menu']  = $this->load->view('main_menu','',TRUE);
					$data['main_content'] = $this->load->view("rsa_lsphk3/daftar_unit_verifikator",$subdata,TRUE);
					$this->load->view('main_template',$data);
			}else{
				redirect('welcome','refresh');
				}
		}
		function spm_lsphk3_verifikator($data_url=''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3))){
				//set data for main template
				$id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
				$id=$id_[0];
			
				$subdata['spm_unit']= $this->rsa_lsphk3_model->get_spm_unit($id);
				$kd_unit=$subdata['spm_unit'][0]->kode_unit_subunit;
				$tahun= $subdata['spm_unit'][0]->tahun;
				//var_dump($tahun);die;
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
                                // $this->check_session->get_alias();
								$dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($kd_unit,$tahun,$id);
                                $subdata['doc_lsphk3'] = $dokumen_lsphk3;
                                 $subdata['doc_lsphk3'] = $dokumen_lsphk3;
                               //var_dump($dokumen_lsphk3);die;
							    $nomor_trx_spp = $this->rsa_lsphk3_model->get_nomor_spp($kd_unit,$tahun,$id); 
                                
//                               echo $nomor_trx_spp ; die;
                                
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
																	
                                        $du = $data_url ;
                                        $data_url = urldecode($data_url);
										//var_dump($data_url);die;
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
											
											 //$array_id = base64_decode($data_url) ;
    //                                        $array_id = $this->input->post('rel_kuitansi');
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $tahun,
                                            );
											
                                            $pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
									$subdata['kontrak_id'] = $this->kuitansi_lsphk3_model->get_kontrakid_by_array_id($data_);
									$subdata['detkontrak'] = $this->kuitansi_lsphk3_model->get_kontrak_by_id($data_);
									//$data_akun_pengeluaran = $this->rsa_lsphk3_model->get_pengeluaran_by_akun5digit($data__);
								//var_dump($subdata['kontrak_id']);die;
                                
                                if(($dokumen_lsphk3 == 'SPP-FINAL') || ($dokumen_lsphk3 == 'SPP-DRAFT') || ($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx_spp,$id);
                                    //var_dump($data_spp);die;
                                    $subdata['detail_lsphk3']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
									
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,                                       
                                    );


                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                
                                $nomor_trx_spm = '';
                                
                                if(($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_lsphk3_model->get_nomor_spm($kd_unit,$tahun,$id);  
                                  // var_dump($nomor_trx_spm);die;
                                    $data_spm = $this->rsa_lsphk3_model->get_data_spm($nomor_trx_spm);
									//echo "<pre>";
									//var_dump($data_spm);die;
									//echo "</pre>";
                                    $subdata['detail_lsphk3'] 	= array(
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
                                    $subdata['detail_kuasa_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkbuu,
                                        'nomor_induk' => $data_spm->nipkbuu
                                    );
									 $subdata['detail_verifikator']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmverifikator,
                                        'nomor_induk' => $data_spm->nipverifikator
                                    );
                                    $subdata['detail_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmbuu,
                                        'nomor_induk' => $data_spm->nipbuu
                                    );
                                    

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
                                $data_akun_pengeluaran = array();   
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit($data__);
                                    $rincian_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_rekap_detail_kuitansi($data__);
                                  //  echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
                                    $data_spp_pajak = $this->kuitansi_lsphk3_model->get_spp_pajak($data__);
//                                    print_r($data_spp_pajak);die;
                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                   echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    $data_akun_rkat = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun_rkat($data___);
                                 
                                    $data_akun_pengeluaran_lalu = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit_lalu($data___);
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
                                }
                                
                                
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                 $subdata['tgl_spm_kpa'] = $this->rsa_lsphk3_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');
                                $subdata['tgl_spm_verifikator'] = $this->rsa_lsphk3_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_lsphk3_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_lsphk3_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun,$id);

				$data['main_content'] 			= $this->load->view("rsa_lsphk3/spm_lsphk3_verifikator",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
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
                            $subdata['unit_usul'] 		= $this->rsa_lsphk3_model->get_lsphk3_unit_usul_kbuu($tahun);
                            $subdata['subunit_usul'] 		= $this->rsa_lsphk3_model->get_lsphk3_subunit_usul_kbuu($tahun);
//                            echo '<pre>';var_dump($subdata['subunit_usul']);echo '</pre>';die;
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_lsphk3/daftar_unit_kbuu",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
	function daftar_spm_kbuu($kode_unit,$tahun){
			$data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
					$subdata['cur_tahun'] =  $tahun;					
					$subdata['spm_usul']= $this->rsa_lsphk3_model->get_spm_kbuu($kode_unit,$tahun);
					$data['user_menu']  = $this->load->view('user_menu','',TRUE);
					$data['main_menu']  = $this->load->view('main_menu','',TRUE);
					$data['main_content'] = $this->load->view("rsa_lsphk3/daftar_spm_kbuu",$subdata,TRUE);
					$this->load->view('main_template',$data);
			}else{
				redirect('welcome','refresh');
				}
		}
	function view_spm_lsphk3_kbuu(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==11)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
							$array_id = $this->input->post('rel_kuitansi');
                            $data = urlencode(base64_encode($array_id)); 
                            // redirect(site_url('rsa_lsphk3/spp_lsphk3_bendahara/' . $data));
							redirect(site_url('rsa_lsphk3/spm_lsphk3_kbuu/' . $data));
                        }
                        
                    }
                }
	function spm_lsphk3_kbuu($data_url=''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
				//set data for main template
				$id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
				$id=$id_[0];
			
				$subdata['spm_unit']= $this->rsa_lsphk3_model->get_spm_unit($id);
				$kd_unit=$subdata['spm_unit'][0]->kode_unit_subunit;
				$tahun= $subdata['spm_unit'][0]->tahun;
				//var_dump($tahun);die;
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
                                // $this->check_session->get_alias();
								$dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($kd_unit,$tahun,$id);
                               
                               
                               //var_dump($dokumen_lsphk3);die;
							    $nomor_trx_spp = $this->rsa_lsphk3_model->get_nomor_spp($kd_unit,$tahun,$id); 
                                
//                               echo $nomor_trx_spp ; die;
                                
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
																	
                                        $du = $data_url ;
                                        $data_url = urldecode($data_url);
										//var_dump($data_url);die;
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
											
											 //$array_id = base64_decode($data_url) ;
    //                                        $array_id = $this->input->post('rel_kuitansi');
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $tahun,
                                            );
											
                                            $pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
									$subdata['kontrak_id'] = $this->kuitansi_lsphk3_model->get_kontrakid_by_array_id($data_);
									$subdata['detkontrak'] = $this->kuitansi_lsphk3_model->get_kontrak_by_id($data_);
									//$data_akun_pengeluaran = $this->rsa_lsphk3_model->get_pengeluaran_by_akun5digit($data__);
								//var_dump($subdata['kontrak_id']);die;
                                
                                if(($dokumen_lsphk3 == 'SPP-FINAL') || ($dokumen_lsphk3 == 'SPP-DRAFT') || ($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx_spp,$id);
                                    //var_dump($data_spp);die;
                                    $subdata['detail_lsphk3']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
									
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,                                       
                                    );


                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                
                                $nomor_trx_spm = '';
                                
                                if(($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_lsphk3_model->get_nomor_spm($kd_unit,$tahun,$id);  
                                  // var_dump($nomor_trx_spm);die;
                                    $data_spm = $this->rsa_lsphk3_model->get_data_spm($nomor_trx_spm);
									//echo "<pre>";
									//var_dump($data_spm);die;
									//echo "</pre>";
                                    $subdata['detail_lsphk3'] 	= array(
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
                                    $subdata['detail_kuasa_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmkbuu,
                                        'nomor_induk' => $data_spm->nipkbuu
                                    );
									 $subdata['detail_verifikator']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmverifikator,
                                        'nomor_induk' => $data_spm->nipverifikator
                                    );
                                    $subdata['detail_buu']  = (object)array(
                                        'nm_lengkap' => $data_spm->nmbuu,
                                        'nomor_induk' => $data_spm->nipbuu
                                    );
                                    

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
                                $data_akun_pengeluaran = array();   
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit($data__);
                                    $rincian_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_rekap_detail_kuitansi($data__);
                                  //  echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
                                    $data_spp_pajak = $this->kuitansi_lsphk3_model->get_spp_pajak($data__);
//                                    print_r($data_spp_pajak);die;
                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                   echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    $data_akun_rkat = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun_rkat($data___);
                                 
                                    $data_akun_pengeluaran_lalu = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit_lalu($data___);
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
                                }
                                
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                 $subdata['doc_lsphk3'] = $dokumen_lsphk3;
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                 $subdata['tgl_spm_kpa'] = $this->rsa_lsphk3_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_lsphk3_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_lsphk3_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_lsphk3_model->lihat_ket($kd_unit,$tahun,$id);
								 $this->load->model('akun_kas6_model');
                                
                                $subdata['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();

				$data['main_content'] 			= $this->load->view("rsa_lsphk3/spm_lsphk3_kbuu",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
		 function proses_final_lsphk3(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx_spm = $this->input->post('nomor_trx');
                        $nomor_ = explode('/', $nomor_trx_spm);
                        $nomor = (int)$nomor_[0] ;
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->input->post('kd_unit');
						$id=$this->input->post('kuitansi_id');
                        $data = array(
                            'kode_unit_subunit' => $kd_unit,
                            'id_trx_nomor_lsphk3' => $this->rsa_lsphk3_model->get_id_nomor_lsphk3('SPM',$kd_unit,$this->input->post('tahun'),$id),
                            'posisi' => $proses,
                            'ket' => $ket,
                            'aktif' => '1',
                            'tahun' => $this->input->post('tahun'),
                            'tgl_proses' => date("Y-m-d H:i:s"),
							'id_kuitansi'=> $id,
                        );
                        
                        $ok = FALSE ;
                            
                        $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($kd_unit,$this->input->post('tahun'),$id);
                        
                        if(($proses == 'SPM-FINAL-KBUU')&&($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }
                            
                        if($ok){
                            
//                            echo 'jos';die;
                            
                            if($this->rsa_lsphk3_model->proses_lsphk3($kd_unit,$data,$id)){

                                $data = array(
                                    'tgl_trx' => date("Y-m-d H:i:s"),
                                    'kd_akun_kas' => '112111',
                                    'kd_unit' => $kd_unit,
                                    'deskripsi' => 'LS3 UNIT ' . $kd_unit,//$this->input->post('deskripsi'),
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
                                    'deskripsi' => 'ISI LS3 UNIT ' . $kd_unit,
                                    'no_spm' => '-',
                                    'debet' => '0',
                                    'kredit' => $nominal,
                                    'saldo' => $saldo,
                                    'aktif' => '1',
                                    'tahun' => $this->input->post('tahun'),
                                );

                                $data_spm_cair = array(
                                    'no_urut' => $this->rsa_lsphk3_model->get_next_urut_spm_cair($this->input->post('tahun')),
//                                    'nomor_trx_spm' => $this->rsa_up_model->get_id_nomor_up('SPM',$kd_unit,$this->input->post('tahun')),//,$nomor,
                                    'str_nomor_trx_spm' => $nomor_trx_spm,
                                    'kode_unit_subunit' => $kd_unit,
                                    'jenis_trx' => 'LS3',
                                    'tgl_proses' => date('Y-m-d H:i:s'),
                                    'bulan' => $nomor_[3],
                                    'tahun' => $this->input->post('tahun')
                                );

    //                            var_dump($data_spm_cair);die;

                                if($this->rsa_lsphk3_model->final_lsphk3($kd_unit,$data) && $this->kas_undip_model->isi_trx($data_kas) && $this->rsa_lsphk3_model->spm_cair($data_spm_cair)){
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
                }

    public function proses_bypass_spp(){
        // print_r($_POST);
        $kode_unit = $_SESSION['rsa_kode_unit_subunit'];
        $kode_usulan_belanja = $_POST['kode_usulan_belanja'];
        $kode_akun5digit = substr($kode_usulan_belanja, -6, 5);
        $kode_akun = substr($kode_usulan_belanja, -6);
        $jenis = 'L3';
        $alias = $this->check_session->get_alias();
        $sql = "SELECT no_bukti FROM rsa_kuitansi_lsphk3 WHERE no_bukti LIKE '".$alias."%' ORDER BY no_bukti DESC LIMIT 0,1";
        $q=$this->db->query($sql);
        if($q->num_rows()>0){
            $nomor = substr($q->row()->no_bukti,-5);
            $nomor = intval($nomor) + 1;
            $_no = "";
            for($i=0;$i<(5-strlen($nomor));$i++){
                $_no .= "0";
            }
            $nomor = $_no.$nomor;
        }else{
            $nomor = '00001';
        }
        $no_bukti = $alias.$nomor;
        $uraian = $_POST['uraian'];
        $bpp = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
        $nmbendahara = $bpp->nm_lengkap;
        $nipbendahara = $bpp->nomor_induk;
        $sql = "";
        $sql = "INSERT INTO rsa_kuitansi_lsphk3(kode_unit, kode_usulan_belanja, kode_akun5digit, kode_akun, jenis, no_bukti, uraian, tgl_kuitansi, tahun, sumber_dana, penerima_uang, penerima_uang_nip, penerima_barang, penerima_barang_nip, nmpppk, nippppk, nmbendahara, nipbendahara, str_nomor_trx, aktif, cair) VALUES('".$kode_unit."')";
        exit;
    }
	function create_spm_lsphk3_nk(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
							$array_id = $this->input->post('rel_kuitansi');
                            $data = urlencode(base64_encode($array_id)); 
							//var_dump($data);die;
                            // redirect(site_url('rsa_lsphk3/spp_lsphk3_bendahara/' . $data));
							redirect(site_url('rsa_lsphk3/spm_lsphk3_nk/' . $data));
                        }
                        
                    }
                } 
	//create spp l3 nk
		function create_spp_lsphk3_nk(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
							$array_id = $this->input->post('rel_kuitansi');
                            $data = urlencode(base64_encode($array_id)); 
                            // redirect(site_url('rsa_lsphk3/spp_lsphk3_bendahara/' . $data));
							redirect(site_url('rsa_lsphk3/spp_lsphk3_nk/' . $data));
                        }
                        
                    }
                }	
		 function spp_lsphk3_nk($data_url=''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){
                    $id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
					$id=$id_[0];
					//var_dump($id);die;
					
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
                                
                                $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($this->check_session->get_unit(),$this->cur_tahun,$id);
								// var_dump($dokumen_lsphk3 = '');die;
                                $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                $subdata['unit_id'] = $this->check_session->get_unit();
                                $subdata['alias'] = $this->check_session->get_alias();
                                $array_id = '';
                                $pengeluaran = 0;
								 //$pekerjaan ='';
                              if(($dokumen_lsphk3 == '')||($dokumen_lsphk3 == 'SPP-DITOLAK')||($dokumen_lsphk3 == 'SPM-DITOLAK-KPA')||($dokumen_lsphk3 == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_lsphk3 == 'SPM-DITOLAK-KBUU')){
                                    $du = '' ;
                                    if($data_url != ''){
                                        $du = $data_url;
                                        $data_url = urldecode($data_url);
                                        if(base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_array_id($data_);
											// var_dump($pengeluaran);die;

                                        }else{
                                            $pengeluaran = 0;
                                        }
                                    }else{
                                        $pengeluaran = 0;
                                    }
                                    // var_dump($data_);die;
									$subdata['kuitansi'] = $this->kuitansi_lsphk3_model->get_kuitansi_id($data_);
                                    // var_dump($subdata['kuitansi']); exit;
                                    $subdata['rel_kuitansi'] = $du;
									//var_dump($kuitansi);die;
                                    $subdata['detail_lsphk3'] = array(
																					//'job' => $uraian,
                                                                                    'nom' => $pengeluaran,
                                                                                    'terbilang' => $this->convertion->terbilang($pengeluaran), 
                                                                                    
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
                                    );
                                    $subdata['tgl_spp'] = $this->rsa_lsphk3_model->get_tgl_spp($this->check_session->get_unit(),$this->cur_tahun,$id);

                                    $nomor_trx_ = $this->rsa_lsphk3_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);
									
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");  
                                    $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-LSP3'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B");  
                                  //  var_dump($subdata);die;
                                
                         }else{
                                    $nomor_trx = $this->rsa_lsphk3_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun,$id); 
                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx,$id);
									//var_dump($nomor_trx);die;
                                    $du = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_lsphk3_model->get_id_detail_by_str_nomor_spp($nomor_trx);
									//var_dump($data_kuitansi);die;
                                    $kuitansi_d = array();
                                    if(!empty($data_kuitansi)){
                                        foreach($data_kuitansi as $dk){
                                            $kuitansi_d[] = $dk->id_kuitansi;
                                        }
                                    }
                                        $du_ = json_encode($kuitansi_d);
										
                                        $data_url = urlencode(base64_encode($du_));
										
                                        $du = $data_url ;
                                        $data_url = urldecode($data_url);
										//var_dump($du);die;
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
											
											 //$array_id = base64_decode($data_url) ;
    //                                        $array_id = $this->input->post('rel_kuitansi');
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
											
                                            $pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
									$subdata['kuitansi'] = $this->kuitansi_lsphk3_model->get_kuitansi_id($data_);
									//var_dump('$data_');die;
                                    $subdata['rel_kuitansi'] = $du;
                                    $subdata['detail_lsphk3'] 	= array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 
                                                                );
									//var_dump($subdata['detail_lsphk3']);die;
                                    $subdata['cur_tahun'] = $data_spp->tahun;
                                    $subdata['detail_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,                                      
                                    );
                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp));  
								}
                                
                                $data_akun_pengeluaran = array();   
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digitnk($data__);
                                    $rincian_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_rekap_detail_kuitansi($data__);
                                  //  echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
                                    $data_spp_pajak = $this->kuitansi_lsphk3_model->get_spp_pajaknk($data__);
  //                                 print_r($data_spp_pajak);die;
  //get_spp_pajak
                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                   echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    $data_akun_rkat = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun_rkat($data___);
                                 
                                    $data_akun_pengeluaran_lalu = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit_lalu($data___);
									$rincian_keluaran = $this->rsa_lsphk3_model->get_keluaran($nomor_trx,$id);
									//var_dump($rincian_keluaran);die;
                                }
                                
                               // $kuitansi=$this->kuitansi_lsphk3_model->get_kuitansi_id($data_);
							
                          //      $subdata['kuitansi'] = $kuitansi;
								//var_dump($subdata['kuitansi']);die;
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['doc_lsphk3'] = $dokumen_lsphk3;
								$subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                $subdata['ket'] = $this->rsa_lsphk3_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun,$id);
                               // var_dump($subdata['kuitansi']); die();
				//$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
//                                var_dump($subdata['detail_pic']);die;
				$data['main_content'] 			= $this->load->view("rsa_lsphk3/spp_lsphk3_nk",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
		//END
		function view_spm_lsphk3_kpa_nk(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==2)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
							$array_id = $this->input->post('rel_kuitansi');
                            $data = urlencode(base64_encode($array_id)); 
                            // redirect(site_url('rsa_lsphk3/spp_lsphk3_bendahara/' . $data));
							redirect(site_url('rsa_lsphk3/spm_lsphk3_kpa_nk/' . $data));
                        }
                        
                    }
                }
		function view_spm_lsphk3_verifikator_nk(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==3)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
							$array_id = $this->input->post('rel_kuitansi');
                            $data = urlencode(base64_encode($array_id)); 
							redirect(site_url('rsa_lsphk3/spm_lsphk3_verifikator_nk/' . $data));
                        }
                        
                    }
                }
		function spm_lsphk3_nk($data_url=''){
			   //$id='';
                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				$id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
					$id=$id_[0];
			
                                $subdata['cur_tahun'] = $this->cur_tahun;
                                $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                $subdata['unit_id'] = $this->check_session->get_unit();
                                $subdata['alias'] = $this->check_session->get_alias();

                                $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($this->check_session->get_unit(),$this->cur_tahun,$id);
                            //var_dump($dokumen_lsphk3);die;
                                $subdata['doc_lsphk3'] = $dokumen_lsphk3;
                                $subdata['tgl_spm'] = $this->rsa_lsphk3_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun,$id);
                               // var_dump($subdata['tgl_spm']);die;
                                $nomor_trx_spp = $this->rsa_lsphk3_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun,$id); 
                               //  var_dump($nomor_trx_spp);die;
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
                                
                                $array_id = '';
                                $pengeluaran = 0;
                                
                                if(($dokumen_lsphk3 == 'SPP-FINAL') || ($dokumen_lsphk3 == 'SPP-DRAFT') || ($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx_spp,$id);
                                    //var_dump($data_spp);die;
                                    
                                    $du = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_lsphk3_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
                                    $kuitansi_d = array();
                                    if(!empty($data_kuitansi)){
                                        foreach($data_kuitansi as $dk){
                                            $kuitansi_d[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_ = json_encode($kuitansi_d);
                                        $data_url = urlencode(base64_encode($du_));
                                        $du = $data_url ;
                                        $data_url = urldecode($data_url);
                                        // print_r(json_decode(base64_decode($data_url))); exit;
                                        if($id!=0){
                                            $array_id = base64_decode($data_url) ;
                                            // $array_id = $this->input->post('rel_kuitansi');
                                            // print_r($array_id); exit;
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
												'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengeluaran = $this->rsa_lsphk3_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
										
                                    $subdata['rel_kuitansi'] = $du;
                                    $subdata['detail_lsphk3']   = array(
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
                                        'idkuitansi' => $data_spp->id_kuitansi,
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );
									//var_dump($data_spp);die;

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                if(($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_lsphk3_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun,$id);  
                                    //var_dump($nomor_trx_spm);die;
                                    $data_spm = $this->rsa_lsphk3_model->get_data_spm($nomor_trx_spm);
									//var_dump($data_spm);die;
                                    $subdata['detail_spm_lsphk3'] 	= array(
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
                                    
                                    $nomor_trx_ = $this->rsa_lsphk3_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-LS PIHAK KE-3'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    $subdata['detail_spm_lsphk3'] 	= array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
                                    $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                    $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
									$subdata['detail_verifikator']  = $this->rsa_lsphk3_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
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
                                    
                                }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
									
                                    $data_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digitnk($data__);
                                    $rincian_akun_pengeluaran = $this->rsa_lsphk3_model->get_rekap_detail_kuitansi($data__);
                                    $data_spp_pajak = $this->kuitansi_lsphk3_model->get_spp_pajaknk($data__);
                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
									// $subdata['kuitansi'] = $this->kuitansi_lsphk3_model->get_kuitansi_id($data___);
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    $data_akun_rkat = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $data_akun_pengeluaran_lalu = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit_lalu($data___);
                                }
								$rincian_keluaran = $this->rsa_lsphk3_model->get_keluaran($nomor_trx_spp,$id);
								//var_dump($rincian_keluaran);die;
								$subdata['rincian_keluaran'] = $rincian_keluaran;
                               // $kuitansi=$this->kuitansi_lsphk3_model->get_kuitansi_id($data_);
						
                                // $subdata['kuitansi'] = $kuitansi;
								//var_dump($subdata['kuitansi']);die;
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
								$subdata['sumber_dana'] = $this->rsa_lsphk3_model->get_kuitansi($id);
								
                                $subdata['tgl_spm_kpa'] = $this->rsa_lsphk3_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_verifikator'] = $this->rsa_lsphk3_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_kbuu'] = $this->rsa_lsphk3_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_lsphk3_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun,$id);
                                
				$data['main_content'] 			= $this->load->view("rsa_lsphk3/spm_lsphk3_nk",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
		function spm_lsphk3_kpa_nk($data_url=''){
			   //$id='';
                    if($this->check_session->user_session() && (($this->check_session->get_level()==2)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				$id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
				$id=$id_[0];
			$id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
					$id=$id_[0];
			
                                $subdata['cur_tahun'] = $this->cur_tahun;
                                $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                $subdata['unit_id'] = $this->check_session->get_unit();
                                $subdata['alias'] = $this->check_session->get_alias();

                                $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($this->check_session->get_unit(),$this->cur_tahun,$id);
                            //var_dump($dokumen_lsphk3);die;
                                $subdata['doc_lsphk3'] = $dokumen_lsphk3;
                                $subdata['tgl_spm'] = $this->rsa_lsphk3_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun,$id);
                               // var_dump($subdata['tgl_spm']);die;
                                $nomor_trx_spp = $this->rsa_lsphk3_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun,$id); 
                               //  var_dump($nomor_trx_spp);die;
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
                                
                                $array_id = '';
                                $pengeluaran = 0;
                                
                                if(($dokumen_lsphk3 == 'SPP-FINAL') || ($dokumen_lsphk3 == 'SPP-DRAFT') || ($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx_spp,$id);
                                    //var_dump($data_spp);die;
                                    
                                    $du = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_lsphk3_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
                                    $kuitansi_d = array();
                                    if(!empty($data_kuitansi)){
                                        foreach($data_kuitansi as $dk){
                                            $kuitansi_d[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_ = json_encode($kuitansi_d);
                                        $data_url = urlencode(base64_encode($du_));
                                        $du = $data_url ;
                                        $data_url = urldecode($data_url);
                                        // print_r(json_decode(base64_decode($data_url))); exit;
                                        if($id!=0){
                                            $array_id = base64_decode($data_url) ;
                                            // $array_id = $this->input->post('rel_kuitansi');
                                            // print_r($array_id); exit;
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
												'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengeluaran = $this->rsa_lsphk3_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
										
                                    $subdata['rel_kuitansi'] = $du;
                                    $subdata['detail_lsphk3']   = array(
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
                                        'idkuitansi' => $data_spp->id_kuitansi,
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );
									//var_dump($data_spp);die;

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                if(($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_lsphk3_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun,$id);  
                                    //var_dump($nomor_trx_spm);die;
                                    $data_spm = $this->rsa_lsphk3_model->get_data_spm($nomor_trx_spm);
									//var_dump($data_spm);die;
                                    $subdata['detail_spm_lsphk3'] 	= array(
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
                                    
                                    $nomor_trx_ = $this->rsa_lsphk3_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-LS PIHAK KE-3'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    $subdata['detail_spm_lsphk3'] 	= array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
                                    $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                    $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
									$subdata['detail_verifikator']  = $this->rsa_lsphk3_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
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
                                    
                                }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
									
                                    $data_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digitnk($data__);
                                    $rincian_akun_pengeluaran = $this->rsa_lsphk3_model->get_rekap_detail_kuitansi($data__);
                                    $data_spp_pajak = $this->kuitansi_lsphk3_model->get_spp_pajaknk($data__);
                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
									// $subdata['kuitansi'] = $this->kuitansi_lsphk3_model->get_kuitansi_id($data___);
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    $data_akun_rkat = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $data_akun_pengeluaran_lalu = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit_lalu($data___);
                                }
								$rincian_keluaran = $this->rsa_lsphk3_model->get_keluaran($nomor_trx_spp,$id);
								//var_dump($rincian_keluaran);die;
								$subdata['rincian_keluaran'] = $rincian_keluaran;
                               // $kuitansi=$this->kuitansi_lsphk3_model->get_kuitansi_id($data_);
						
                                // $subdata['kuitansi'] = $kuitansi;
								//var_dump($subdata['kuitansi']);die;
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
								$subdata['sumber_dana'] = $this->rsa_lsphk3_model->get_kuitansi($id);
								
                                $subdata['tgl_spm_kpa'] = $this->rsa_lsphk3_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_verifikator'] = $this->rsa_lsphk3_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_kbuu'] = $this->rsa_lsphk3_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_lsphk3_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun,$id);
                                
				$data['main_content'] 			= $this->load->view("rsa_lsphk3/spm_lsphk3_kpa_nk",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
				function spm_lsphk3_verifikator_nk($data_url=''){
			   //$id='';
                    if($this->check_session->user_session() && (($this->check_session->get_level()==3)||($this->check_session->get_level()==100))){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				$id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
					$id=$id_[0];
				//	var_dump($id);die;
			
				$subdata['spm_unit']= $this->rsa_lsphk3_model->get_spm_unit($id);
				$kd_unit=$subdata['spm_unit'][0]->kode_unit_subunit;
				$tahun= $subdata['spm_unit'][0]->tahun;
				//var_dump($tahun);die;
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

                                $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($kd_unit,$this->cur_tahun,$id);
                            //var_dump($dokumen_lsphk3);die;
                                $subdata['doc_lsphk3'] = $dokumen_lsphk3;
                                $subdata['tgl_spm'] = $this->rsa_lsphk3_model->get_tgl_spm($kd_unit,$this->cur_tahun,$id);
                               // var_dump($subdata['tgl_spm']);die;
                                $nomor_trx_spp = $this->rsa_lsphk3_model->get_nomor_spp($kd_unit,$this->cur_tahun,$id); 
                               //  var_dump($nomor_trx_spp);die;
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
                                
                                $array_id = '';
                                $pengeluaran = 0;
                                
                                if(($dokumen_lsphk3 == 'SPP-FINAL') || ($dokumen_lsphk3 == 'SPP-DRAFT') || ($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx_spp,$id);
                                    //var_dump($data_spp);die;
                                    
                                    $du = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_lsphk3_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
                                    $kuitansi_d = array();
                                    if(!empty($data_kuitansi)){
                                        foreach($data_kuitansi as $dk){
                                            $kuitansi_d[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_ = json_encode($kuitansi_d);
                                        $data_url = urlencode(base64_encode($du_));
                                        $du = $data_url ;
                                        $data_url = urldecode($data_url);
                                        // print_r(json_decode(base64_decode($data_url))); exit;
                                        if($id!=0){
                                            $array_id = base64_decode($data_url) ;
                                            // $array_id = $this->input->post('rel_kuitansi');
                                            // print_r($array_id); exit;
                                            $data_ = array(
                                                // 'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'kode_unit_subunit' => $kd_unit,
												'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            // print_r($data_); exit;
                                            $pengeluaran = $this->rsa_lsphk3_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
										
                                    $subdata['rel_kuitansi'] = $du;
                                    $subdata['detail_lsphk3']   = array(
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
                                        'idkuitansi' => $data_spp->id_kuitansi,
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );
									//var_dump($data_spp);die;

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                if(($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_lsphk3_model->get_nomor_spm($kd_unit,$this->cur_tahun,$id);  
                                    //var_dump($nomor_trx_spm);die;
                                    $data_spm = $this->rsa_lsphk3_model->get_data_spm($nomor_trx_spm);
									//var_dump($data_spm);die;
                                    $subdata['detail_spm_lsphk3'] 	= array(
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
                                    
                                    $nomor_trx_ = $this->rsa_lsphk3_model->get_nomor_next_spm($kd_unit,$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-LS PIHAK KE-3'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    $subdata['detail_spm_lsphk3'] 	= array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
                                    $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($kd_unit,'14');
                                    $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
									$subdata['detail_verifikator']  = $this->rsa_lsphk3_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
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
                                    
                                }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
									// print_r($data__); exit;
                                    $data_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digitnk($data__);
                                    $rincian_akun_pengeluaran = $this->rsa_lsphk3_model->get_rekap_detail_kuitansi($data__);
                                    $data_spp_pajak = $this->kuitansi_lsphk3_model->get_spp_pajaknk($data__);
                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
									// $subdata['kuitansi'] = $this->kuitansi_lsphk3_model->get_kuitansi_id($data___);
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    $data_akun_rkat = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $data_akun_pengeluaran_lalu = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit_lalu($data___);
                                }
								$rincian_keluaran = $this->rsa_lsphk3_model->get_keluaran($nomor_trx_spp,$id);
								//var_dump($rincian_keluaran);die;
								$subdata['rincian_keluaran'] = $rincian_keluaran;
                             
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
								$subdata['sumber_dana'] = $this->rsa_lsphk3_model->get_kuitansi($id);
								
                                $subdata['tgl_spm_kpa'] = $this->rsa_lsphk3_model->get_tgl_spm_kpa($kd_unit,$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_verifikator'] = $this->rsa_lsphk3_model->get_tgl_spm_verifikator($kd_unit,$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_kbuu'] = $this->rsa_lsphk3_model->get_tgl_spm_kbuu($kd_unit,$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_lsphk3_model->lihat_ket($kd_unit,$this->cur_tahun,$id);
                // echo "<pre>"; print_r($subdata); echo "</pre>"; exit;              
				$data['main_content'] 			= $this->load->view("rsa_lsphk3/spm_lsphk3_verifikator_nk",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
		function daftar_spm_nk(){
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
					$kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();   
					$subdata['daftar_spm'] = array();
					$unit=$this->check_session->get_unit();
					$subdata['cur_tahun'] = $this->cur_tahun;
					$sql = "SELECT tahun FROM trx_lsphk3 GROUP BY tahun ORDER BY tahun ASC";
					$subdata['tahun'] = $this->db->query($sql)->result();
					// $d = $this->uri->uri_to_assoc(3);
					// if(isset($d['tahun'])){
						$sql = "SELECT a.*,b.*,DATE_FORMAT(a.tgl_proses, '%d %M %Y') as tanggal2 FROM trx_lsphk3 a LEFT JOIN trx_nomor_lsphk3 b ON a.id_kuitansi = b.id_kuitansi LEFT JOIN rsa_kuitansi_lsphk3 c ON a.id_kuitansi=c.id_kuitansi WHERE a.kode_unit_subunit='{$unit}' AND a.tahun='".intval($subdata['cur_tahun'])."' AND b.jenis='SPM' AND c.jenis='L3NK' GROUP BY a.id_kuitansi ORDER BY a.id_kuitansi DESC";
						$subdata['daftar_spm'] = $this->db->query($sql)->result();
						
						//var_dump($sql);die;
					// }
					$data['user_menu']  = $this->load->view('user_menu','',TRUE);
					$data['main_menu']  = $this->load->view('main_menu','',TRUE);
					$data['main_content'] = $this->load->view("rsa_lsphk3/daftar_spm_nk",$subdata,TRUE);
					$this->load->view('main_template',$data);
			}else{
				redirect('welcome','refresh');
				}
		}
		function daftar_unit_nk($tahun=''){
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
                    
                    /* check session	*/
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
							$sql = "SELECT kode_unit_subunit FROM rsa_verifikator_unit WHERE id_user_verifikator = ".$user->id;
                            $r = $this->db->query($sql)->result();
                            $subdata['unit_usul'] 		= $this->rsa_lsphk3_model->get_lsphk3_unit_usul_verifikator_nk($user->id,$tahun,$r);
                            $subdata['subunit_usul']  		= $this->rsa_lsphk3_model->get_lsphk3_subunit_usul_verifikator_nk($user->id,$tahun,$r);
//                            echo '<pre>';var_dump($subdata['subunit_usul']);echo '</pre>';die;
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_lsphk3/daftar_unit_nk",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
				//NK
		function daftar_spm_verifikator_nk($kode_unit,$tahun){
			$data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3))){
					$user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
					$subdata['cur_tahun'] =  $tahun;					
					$subdata['spm_usul']= $this->rsa_lsphk3_model->get_spm_verifikator_nk($kode_unit,$user->id,$tahun);
					$data['user_menu']  = $this->load->view('user_menu','',TRUE);
					$data['main_menu']  = $this->load->view('main_menu','',TRUE);
					$data['main_content'] = $this->load->view("rsa_lsphk3/daftar_unit_verifikator_nk",$subdata,TRUE);
					$this->load->view('main_template',$data);
			}else{
				redirect('welcome','refresh');
				}
		}
		//end nk
		 function daftar_unit_kbuu_nk($tahun=''){
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }

                    /* check session	*/
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['unit_usul'] 		= $this->rsa_lsphk3_model->get_lsphk3_unit_usul_kbuu_nk($tahun);
                            $subdata['subunit_usul'] 		= $this->rsa_lsphk3_model->get_lsphk3_subunit_usul_kbuu_nk($tahun);
//                            echo '<pre>';var_dump($subdata['subunit_usul']);echo '</pre>';die;
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                            $data['main_content'] 		= $this->load->view("rsa_lsphk3/daftar_unit_kbuu_nk",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
				function daftar_spm_kbuu_nk($kode_unit,$tahun){
			$data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
					$subdata['cur_tahun'] =  $tahun;					
					$subdata['spm_usul']= $this->rsa_lsphk3_model->get_spm_kbuu($kode_unit,$tahun);
					$data['user_menu']  = $this->load->view('user_menu','',TRUE);
					$data['main_menu']  = $this->load->view('main_menu','',TRUE);
					$data['main_content'] = $this->load->view("rsa_lsphk3/daftar_spm_kbuu_nk",$subdata,TRUE);
					$this->load->view('main_template',$data);
			}else{
				redirect('welcome','refresh');
				}
		}
		function view_spm_lsphk3_kbuu_nk(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==11)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
							$array_id = $this->input->post('rel_kuitansi');
                            $data = urlencode(base64_encode($array_id)); 
                            // redirect(site_url('rsa_lsphk3/spp_lsphk3_bendahara/' . $data));
							redirect(site_url('rsa_lsphk3/spm_lsphk3_kbuu_nk/' . $data));
                        }
                        
                    }
                }
		function spm_lsphk3_kbuu_nk($data_url=''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
				//set data for main template
				$id_ = json_decode(base64_decode(urldecode($data_url))); // urldecode(base64_decode($data_url);
				$id=$id_[0];
			
				$subdata['spm_unit']= $this->rsa_lsphk3_model->get_spm_unit($id);
				$kd_unit=$subdata['spm_unit'][0]->kode_unit_subunit;
				$tahun= $subdata['spm_unit'][0]->tahun;
				//var_dump($tahun);die;
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

                                $dokumen_lsphk3 = $this->rsa_lsphk3_model->check_dokumen_lsphk3($kd_unit,$this->cur_tahun,$id);
                            //var_dump($dokumen_lsphk3);die;
                                $subdata['doc_lsphk3'] = $dokumen_lsphk3;
                                $subdata['tgl_spm'] = $this->rsa_lsphk3_model->get_tgl_spm($kd_unit,$this->cur_tahun,$id);
                               // var_dump($subdata['tgl_spm']);die;
                                $nomor_trx_spp = $this->rsa_lsphk3_model->get_nomor_spp($kd_unit,$this->cur_tahun,$id); 
                               //  var_dump($nomor_trx_spp);die;
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
                                
                                $array_id = '';
                                $pengeluaran = 0;
                                
                                if(($dokumen_lsphk3 == 'SPP-FINAL') || ($dokumen_lsphk3 == 'SPP-DRAFT') || ($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_lsphk3_model->get_data_spp($nomor_trx_spp,$id);
                                    //var_dump($data_spp);die;
                                    
                                    $du = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_lsphk3_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
                                    $kuitansi_d = array();
                                    if(!empty($data_kuitansi)){
                                        foreach($data_kuitansi as $dk){
                                            $kuitansi_d[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_ = json_encode($kuitansi_d);
                                        $data_url = urlencode(base64_encode($du_));
                                        $du = $data_url ;
                                        $data_url = urldecode($data_url);
                                        // print_r(json_decode(base64_decode($data_url))); exit;
                                        if($id!=0){
                                            $array_id = base64_decode($data_url) ;
                                            // $array_id = $this->input->post('rel_kuitansi');
                                            // print_r($array_id); exit;
                                            $data_ = array(
                                                // 'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'kode_unit_subunit' => $kd_unit,
												'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            // print_r($data_); exit;
                                            $pengeluaran = $this->rsa_lsphk3_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
										
                                    $subdata['rel_kuitansi'] = $du;
                                    $subdata['detail_lsphk3']   = array(
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
                                        'idkuitansi' => $data_spp->id_kuitansi,
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );
									//var_dump($data_spp);die;

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                if(($dokumen_lsphk3 == 'SPM-DRAFT-PPK') || ($dokumen_lsphk3 == 'SPM-DRAFT-KPA') || ($dokumen_lsphk3 == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_lsphk3 == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_lsphk3_model->get_nomor_spm($kd_unit,$this->cur_tahun,$id);  
                                    //var_dump($nomor_trx_spm);die;
                                    $data_spm = $this->rsa_lsphk3_model->get_data_spm($nomor_trx_spm);
									//var_dump($data_spm);die;
                                    $subdata['detail_spm_lsphk3'] 	= array(
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
                                    
                                    $nomor_trx_ = $this->rsa_lsphk3_model->get_nomor_next_spm($kd_unit,$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-LS PIHAK KE-3'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    $subdata['detail_spm_lsphk3'] 	= array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
                                    $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($kd_unit,'14');
                                    $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
									$subdata['detail_verifikator']  = $this->rsa_lsphk3_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
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
                                    
                                }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
									// print_r($data__); exit;
                                    $data_akun_pengeluaran = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digitnk($data__);
                                    $rincian_akun_pengeluaran = $this->rsa_lsphk3_model->get_rekap_detail_kuitansi($data__);
                                    $data_spp_pajak = $this->kuitansi_lsphk3_model->get_spp_pajaknk($data__);
                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
									// $subdata['kuitansi'] = $this->kuitansi_lsphk3_model->get_kuitansi_id($data___);
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    $data_akun_rkat = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $data_akun_pengeluaran_lalu = $this->kuitansi_lsphk3_model->get_pengeluaran_by_akun5digit_lalu($data___);
                                }
								$rincian_keluaran = $this->rsa_lsphk3_model->get_keluaran($nomor_trx_spp,$id);
								//var_dump($rincian_keluaran);die;
								$subdata['rincian_keluaran'] = $rincian_keluaran;
                             
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                
                                
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
								$subdata['sumber_dana'] = $this->rsa_lsphk3_model->get_kuitansi($id);
								
                                $subdata['tgl_spm_kpa'] = $this->rsa_lsphk3_model->get_tgl_spm_kpa($kd_unit,$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_verifikator'] = $this->rsa_lsphk3_model->get_tgl_spm_verifikator($kd_unit,$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_kbuu'] = $this->rsa_lsphk3_model->get_tgl_spm_kbuu($kd_unit,$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_lsphk3_model->lihat_ket($kd_unit,$this->cur_tahun,$id);
                // echo "<pre>"; print_r($subdata); echo "</pre>"; exit;              
				$data['main_content'] 			= $this->load->view("rsa_lsphk3/spm_lsphk3_kbuu_nk",$subdata,TRUE);
				$this->load->view('main_template',$data);
			} 
			else{
				redirect('welcome','refresh');	// redirect ke halaman home
			}
                }
}
		
?>
