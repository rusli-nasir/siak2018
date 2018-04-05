<?php
    if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    class rsa_em extends CI_Controller{
/* -------------- Constructor ------------- */
            
            private $cur_tahun;
    public function __construct(){ 
        parent::__construct();
            //load library, helper, and model
                $this->cur_tahun = $this->setting_model->get_tahun();
            $this->load->library(array('form_validation','option','Url_encoder','shorturl'));
            $this->load->helper('form');
            $this->load->model(array('rsa_em_model','akun_model','setting_up_model','kuitansi_model','kuitansipengembalian_model'));
            $this->load->model("user_model");
                        $this->load->model("unit_model");
                        $this->load->model('menu_model');
            $this->load->helper("security");
                        

        }
        
        #methods ======================
        
        //define method index()
        function index(){
                    if($this->check_session->user_session()){
                        $data['cur_tahun'] = $this->cur_tahun ;
                        $subdata['jenis']           = 'em';
                        $data['main_content']   = $this->load->view('rsa_em/index',$subdata,TRUE);
                        // $data['main_menu']   = $this->load->view('form_login','',TRUE);
                        $list["menu"] = $this->menu_model->show();
                        $list["submenu"] = $this->menu_model->show();
                        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
//                        $data['message']  = validation_errors();
                        $this->load->view('main_template',$data);
                    }else{
                        redirect('welcome','refresh');  // redirect ke halaman home
                    }
        }
        
        //define method daftar_unit()
        function daftar_rsa_up(){
            if($this->check_session->user_session() && $this->check_session->get_level()==2){
                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                $subdata_rsa_up['result_rsa_up']        = $this->rsa_up_model->search_rsa_up();
                $subdata['opt_unit_kepeg']      = $this->option->opt_unit_kepeg();
                $subdata['row_rsa_up']          = $this->load->view("rsa_up/row_rsa_up",$subdata_rsa_up,TRUE);
                $data['main_content']           = $this->load->view("rsa_up/daftar_rsa_up",$subdata,TRUE);
                $this->load->view('main_template',$data);
            }
            else{
                redirect('home','refresh'); // redirect ke halaman home
            }       
        }
        function input_rsa_up(){
            if($this->check_session->user_session() && $this->check_session->get_level()==13){
                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                //$subdata_rsa_up['result_rsa_up']      = $this->rsa_up_model->search_rsa_up();
                //$subdata['row_rsa_up']            = $this->load->view("rsa_up/row_rsa_up",$subdata_rsa_up,TRUE);
                $subdata['opt_unit_kepeg']      = $this->option->opt_unit_kepeg();
                $data['main_content']           = $this->load->view("rsa_up/input_rsa_up",$subdata,TRUE);
                $this->load->view('main_template',$data);
            }
            else{
                redirect('home','refresh'); // redirect ke halaman home
            }       
        }
                
                function create_spp_em(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
                            
                            $array_id = $this->input->post('rel_kuitansi');
                            $array_id_pengembalian = $this->input->post('rel_kuitansi_pengembalian');
                            // CHECK APAKAH KUITANSI MEMANG BENAR BISA DIBUAT SPP
                            $dataList = substr($array_id, 1, -1);
                            $a_list = explode(',', $dataList);
                            $err = false ;
                            if($dataList!=''){ // CHECK JIKA ADA KUITANSI SPJ
                                foreach($a_list as $al){
                                        if(!$this->kuitansi_model->check_valid_kuitansi_by_id(substr($al, 1, -1),$this->cur_tahun)){
                                            $err = true ;
                                            break;
                                        }
                                }
                                if($err){
                                    $this->load->library('user_agent');
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" style="text-align:center"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> Kuitansi ada yang tidak bisa dibuat <u>SPP</u>.</div>');
                                    redirect($this->agent->referrer());
                                }
                            }
                            // END CHECK
                                $data = base64_encode($array_id);
                                $data_pengembalian = base64_encode($array_id_pengembalian); 

                                $data = urlencode($this->shorturl->_encode_string_array($data)) ;
                                $data_pengembalian = urlencode($this->shorturl->_encode_string_array($data_pengembalian)) ;


                                // $this->session->set_flashdata('array_id', $data);
                                // $this->session->set_flashdata('array_id_pengembalian', $data_pengembalian);
                                $this->session->set_tempdata('array_id', $data, 300);
                                $this->session->set_tempdata('array_id_pengembalian', $data_pengembalian, 300);
                                

                            // redirect(site_url('rsa_tup/spp_tup/' . $data . '/' . $data_pengembalian));
                            redirect(site_url('rsa_em/spp_em/')) ;
                        }
                        
                    }
                }
                
            
                function spp_em(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){


                        // $data_url = $this->session->flashdata('array_id');
                        //$data_url_pengembalian = $this->session->flashdata('array_id_pengembalian');

                        if($this->session->tempdata('array_id')!=null){
                            $data_url = $this->session->tempdata('array_id');
                            $data_url_pengembalian = $this->session->tempdata('array_id_pengembalian');
                        }else{
                            redirect('kuitansi/daftar_kuitansi/EM');
                        }
                        

                        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                        $data['main_menu']  = $this->load->view('main_menu','',TRUE);     



                                $id_max_nomor = $this->rsa_em_model->get_nomor_spp_urut($this->check_session->get_unit(),$this->cur_tahun) ;

                                $id_max_nomor = $id_max_nomor + 1 ;

                                $dokumen = '' ;
                            

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
                                $array_id_pengembalian = '';
                                $pengeluaran = 0;
                                $pengembalian = 0;
                                $du = '' ;
                                $du_p = '' ;

                                

                                $tgl_ok = true ;



                                ///////////
                                /// SPP ///
                                ///////////

                                    $du = '' ;

                                    if($data_url != ''){
                                        
                                        $data_url = urldecode($data_url);
                                        $data_url = $this->shorturl->_decode_string_array($data_url);
                                        $du = $data_url;

                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
                                            // echo $array_id ; die;
    //                                        $array_id = $this->input->post('rel_kuitansi');
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                            // echo $pengeluaran;die;
                                        }else{
                                            $pengeluaran = 0;
                                        }
                                    }else{
                                        $pengeluaran = 0;
                                    }

                                    // echo $pengeluaran ; die ;


                                    // echo '<pre>';
                                    // var_dump($data_url);die;

                                    $du_p = '' ;

                                    if($data_url_pengembalian != ''){
                                        
                                        $data_url_pengembalian = urldecode($data_url_pengembalian);
                                        $data_url_pengembalian = $this->shorturl->_decode_string_array($data_url_pengembalian);
                                        $du_p = $data_url_pengembalian;

                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;

                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $this->cur_tahun,
                                            );

                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                            // echo $pengeluaran;die;
                                        }else{
                                            $pengembalian = 0;
                                        }
                                    }else{
                                        $pengembalian = 0;
                                    }

                                    // echo $pengembalian ; die ;

                                    $subdata['rel_kuitansi'] = $du;
                                    $subdata['rel_kuitansi_pengembalian'] = $du_p;

                                    $subdata['detail_spp']          = array(
                                                                                    'nom' => $pengeluaran,
                                                                                    'pengembalian' => $pengembalian ,
                                                                                    'terbilang' => $this->convertion->terbilang($pengeluaran), 
                                                                                    
                                                                                );
                                    
                                    $subdata['cur_tahun'] = $this->cur_tahun;
                                    $rsa_user = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');

                                    $subdata['detail_pic']  = (object) array(
                                        'penerima' => '-',
                                        'alamat_penerima' => '-',
                                        'nama_bank_penerima' => '-',
                                        'no_rek_penerima' => '-',
                                        'npwp_penerima' => '-',
                                        'nmbendahara' => $rsa_user->nm_lengkap,
                                        'nipbendahara' => $rsa_user->nomor_induk,
//                                        'tgl_spp' => $rsa_user->tgl_spp,
                                    );


                                
                                    $subdata['tgl_spp'] = '';


                                    $nomor_trx_ = $this->rsa_em_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);

                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");$thn = strftime("%Y");

                                    $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-EM'.'/'.strtoupper($bln).'/'.$thn;

                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B");  

                                   // var_dump($subdata);die;
                                
                                
                                $data_akun_pengeluaran = array();   
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();

                                // if($pengeluaran > 0){

                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );

                                    // echo '<pre>';
                                    // var_dump($data__);die;

                                    // $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__,'EM');
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun4digit($data__,'EM');

                                    // echo '<pre>';
                                    // var_dump($data_akun_pengeluaran);die;

                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);

                                    // echo '<pre>';
                                    // var_dump($rincian_akun_pengeluaran);die;

                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'EM');

                                    // echo '<pre>';
                                    // var_dump($data_spp_pajak);die;

                                    $data_rekap_pajak = $this->kuitansi_model->get_rekap_pajak_by_array_id($data__,$this->cur_tahun);
                                    $data_rekap_bruto = $this->kuitansi_model->get_rekap_bruto_by_array_id($data__,$this->cur_tahun);

                                    // echo '<pre>';
                                    // var_dump($data_rekap_pajak);
                                    // var_dump($data_rekap_bruti);die;

//                                    if(!empty($data_akun_pengeluaran)){
                                    $data_akun4digit = array();
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun4digit[] =  $da->kode_akun4digit ;
                                    }
//                                    
//                                  // echo '<pre>';
                                    // var_dump($data_spp_pajak);die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun4digit' => $data_akun4digit
                                    );

                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    // $nomor_spm = $this->rsa_em_model->get_spm_by_spp($nomor_trx);

                                        
                                    $data_akun_before = $this->kuitansi_model->get_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);

                                    // echo '<pre>';
                                    // var_dump($data_akun_before);die;


                                    $data_akun4digit_before = array();


                                    if(!empty($data_akun_before)){

                                        foreach($data_akun_before as $dk){
                                            $data_akun4digit_before[] =  $dk->kode_akun4digit ;
                                        }
                                        
                                        $data___lalu = array(
                                            'kode_unit_subunit' => $this->check_session->get_unit(),
                                            'tahun' => $this->cur_tahun,
                                            'kode_akun4digit' => $data_akun4digit_before
                                        );

    //                                    echo '<pre>';print_r($data___lalu);echo '</pre>';die;

                                        // $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___lalu,'EM');

                                        $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun4digit_lalu($data___lalu,'EM');
                                    
                                    }
                                        

                                    // $rincian_keluaran = $this->rsa_em_model->get_keluaran($nomor_trx);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;

                                    // echo '<pre>';
                                    // var_dump($data_akun_pengeluaran);die;

                                    $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                    $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                    $subdata['data_akun_rkat'] = $data_akun_rkat;
                                    $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                    $subdata['data_spp_pajak'] = $data_spp_pajak;
                                    $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                    $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                    $subdata['rincian_keluaran'] = $rincian_keluaran;
                               


                                // }

                                $subdata['id_nomor'] = $id_max_nomor;
                                $subdata['jenis'] = 'em';

                                // var_dump($subdata);die;

                                $subdata['doc'] = $dokumen;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                $subdata['ket'] = '';

                                // $list_akun = $this->akun_model->get_list_akun_1d('1');

                                // $subdata['list_akun'] = $list_akun;


                                $data['main_content']           = $this->load->view("rsa_pengesahan/spp_pengesahan",$subdata,TRUE);

                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }

            function spp_em_lihat($url = ''){


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
                //$subdata_rsa_up['result_rsa_up']      = $this->rsa_up_model->search_rsa_up();
                                
                                // $dokumen_em = $this->rsa_em_model->check_dokumen_em($this->check_session->get_unit(),$this->cur_tahun);


                                $nomor_trx_spp = $url ;
                                
                                
                                $dokumen = $this->rsa_em_model->check_dokumen_em_by_str_trx($url);


                                // echo $dokumen_em ; die;

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

                                // if(strlen($this->check_session->get_unit())==2){
                                //     $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
                                //     $subdata['unit_id'] = $this->check_session->get_unit();
                                //     $subdata['alias'] = $this->check_session->get_alias();
                                // }
                                // elseif(strlen($this->check_session->get_unit())==4){
                                //         $subdata['unit_kerja'] = $this->unit_model->get_nama($this->check_session->get_unit()) . ' - ' . $this->unit_model->get_real_nama($this->check_session->get_unit());//$this->check_session->get_nama_unit();
                                //         $subdata['unit_id'] = $this->check_session->get_unit();
                                //         $subdata['alias'] = $this->unit_model->get_alias($this->check_session->get_unit());
                                // }

                                $array_id = '';
                                $pengeluaran = 0;
                                
                                $tgl_ok = false ;


                                ///////////
                                /// SPP ///
                                ///////////


                                    $nomor_trx = $nomor_trx_spp ;

                                    $data_spp = $this->rsa_em_model->get_data_spp($nomor_trx);
                                    
                                    $du = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx,'EM');
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
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
    //                                        $array_id = $this->input->post('rel_kuitansi');
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }

                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx,'EM');
                                    // var_dump($data_kuitansi_pengembalian); die;
                                    $kuitansi_d_pengembalian = array();
                                    if(!empty($data_kuitansi_pengembalian)){
                                        foreach($data_kuitansi_pengembalian as $dk){
                                            $kuitansi_d_pengembalian[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_p = json_encode($kuitansi_d_pengembalian);
                                        $data_url_pengembalian = urlencode(base64_encode($du_p));
                                        $du_p = $data_url_pengembalian ;
                                        $data_url_pengembalian = urldecode($data_url_pengembalian);
                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
                                           // echo $array_id_pengembalian ; die ;
                                            $array_id_pengembalian = $data_spp->data_kuitansi_pengembalian;
                                           // echo $array_id_pengembalian ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }

                                        // echo $pengembalian; die;
                                    
                                    $subdata['detail_spp']  = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );

                                    // echo $pengeluaran; die;

                                    // echo '<pre>';
                                    // var_dump($subdata);die;

                                    $subdata['cur_tahun'] = $data_spp->tahun;
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



    //                                if(($dokumen_em == '') || ($dokumen_em == 'SPP-DITOLAK') || ($dokumen_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    $subdata['alias_spp'] = $data_spp->alias_spp;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 
                                    
                                    // var_dump($subdata); die;
                                    
                                // }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                $daftar_kuitansi = array();
                                $daftar_kuitansi_pengembalian = array();

                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'array_id' => json_decode($array_id)
                                    );

                                    // echo '<pre>';
                                    // var_dump($data__);die;

                                    // $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__,'EM');
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun4digit($data__,'EM');

                                    // echo '<pre>';
                                    // var_dump($data_akun_pengeluaran);die;

                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);

                                    // echo '<pre>';
                                    // var_dump($rincian_akun_pengeluaran);die;

                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'EM');

                                    // echo '<pre>';
                                    // var_dump($data_spp_pajak);die;

                                    $data_rekap_pajak = $this->kuitansi_model->get_rekap_pajak_by_array_id($data__,$tahun);
                                    $data_rekap_bruto = $this->kuitansi_model->get_rekap_bruto_by_array_id($data__,$tahun);

                                    // echo '<pre>';
                                    // var_dump($data_rekap_pajak);
                                    // var_dump($data_rekap_bruti);die;

//                                    if(!empty($data_akun_pengeluaran)){
                                    $data_akun4digit = array();
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun4digit[] =  $da->kode_akun4digit ;
                                    }
//                                    
//                                  // echo '<pre>';
                                    // var_dump($data_spp_pajak);die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'kode_akun4digit' => $data_akun4digit
                                    );

                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    // $nomor_spm = $this->rsa_em_model->get_spm_by_spp($nomor_trx);

                                        
                                    $data_akun_before = $this->kuitansi_model->get_akun_before_by_unit($kd_unit,$tahun);

                                    // echo '<pre>';
                                    // var_dump($data_akun_before);die;


                                    $data_akun4digit_before = array();


                                    if(!empty($data_akun_before)){

                                        foreach($data_akun_before as $dk){
                                            $data_akun4digit_before[] =  $dk->kode_akun4digit ;
                                        }
                                        
                                        $data___lalu = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'tahun' => $tahun,
                                            'kode_akun4digit' => $data_akun4digit_before
                                        );

    //                                    echo '<pre>';print_r($data___lalu);echo '</pre>';die;

                                        // $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___lalu,'EM');

                                        $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun4digit_lalu($data___lalu,'EM');
                                    
                                    }
                                    

                                    $rincian_keluaran = $this->rsa_em_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
                                // // }


                                $daftar_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_kuitansi_by_url_id(base64_decode(urldecode($du_p)));

                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['rel_kuitansi_pengembalian'] = $du_p;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['daftar_kuitansi_pengembalian'] = $daftar_kuitansi_pengembalian;
                                $subdata['nomor_spp'] = $nomor_trx_spp;

                                $subdata['jenis'] = 'em';
                                $subdata['doc'] = $dokumen;
                                
                                // $subdata['ket'] = $this->rsa_gup_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($kd_unit,'14');
                                $subdata['ket'] = $this->rsa_em_model->lihat_ket_by_str_trx($nomor_trx); //$kd_unit,$tahun);
                                
                $data['main_content']           = $this->load->view("rsa_pengesahan/spp_pengesahan_lihat",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }

            function spm_em($url = ''){

                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){           
                            $hash_url = $url;                                                                     

                            $url = urldecode($url);

                            if( base64_encode(base64_decode($url, true)) === $url){
                                $url = base64_decode($url);
                            }else{
                                redirect(site_url('/'));
                            }


                            // echo $url ; die ;

                                

                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE); 

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
                                
                                $dokumen = $this->rsa_em_model->check_dokumen_em_by_str_trx($url);

                                // echo $dokumen ; die;
                              
                                $subdata['doc'] = $dokumen;
                                

                                $nomor_trx_spp = $url ;

                                 


                                $id_nomor = $this->rsa_em_model->get_nomor_spp_urut_by_nomor_spp($nomor_trx_spp) ;

                                // echo $id_nomor_em; die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '0',
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
                                $array_id_pengembalian = '';
                                $pengeluaran = 0;
                                $pengembalian = 0;
                                $du = '' ;
                                $du_p = '' ;

                                //////////////
                                /// SPP ///
                                /////////////

                                    
                                    $data_spp = $this->rsa_em_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
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
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                                            $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }

                                        // echo $pengeluaran; die;

                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
                                    // var_dump($data_kuitansi_pengembalian); die;
                                    $kuitansi_d_pengembalian = array();
                                    if(!empty($data_kuitansi_pengembalian)){
                                        foreach($data_kuitansi_pengembalian as $dk){
                                            $kuitansi_d_pengembalian[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_p = json_encode($kuitansi_d_pengembalian);
                                        $data_url_pengembalian = urlencode(base64_encode($du_p));
                                        $du_p = $data_url_pengembalian ;
                                        $data_url_pengembalian = urldecode($data_url_pengembalian);
                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
                                           // echo $array_id_pengembalian ; die ;
                                            $array_id_pengembalian = $data_spp->data_kuitansi_pengembalian;
                                           // echo $array_id_pengembalian ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }

                                        // echo $pengembalian ; die ;


                                    $subdata['detail_spp']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );

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
                                    
                                    $subdata['alias_spp'] = $data_spp->alias_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                    setlocale(LC_ALL, 'id_ID.utf8'); $subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 


                                //////////////
                                /// SPM ///
                                /////////////
                                
                                
                                    // PADA POSISI INI  SPM BELUM DIBUAT  //
                                    
                                
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                $daftar_kuitansi = array();
                                $daftar_kuitansi_pengembalian = array();

                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );

                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun4digit($data__,'EM');

                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);

                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'EM');

                                    $data_rekap_pajak = $this->kuitansi_model->get_rekap_pajak_by_array_id($data__,$this->cur_tahun);
                                    $data_rekap_bruto = $this->kuitansi_model->get_rekap_bruto_by_array_id($data__,$this->cur_tahun);

                                        $data_akun4digit = array();
                                        foreach($data_akun_pengeluaran as $da){
                                            $data_akun4digit[] =  $da->kode_akun4digit ;
                                        }

                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun4digit' => $data_akun4digit
                                    );

                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                

                                    $data_akun_before = $this->kuitansi_model->get_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);


                                    $data_akun4digit_before = array();


                                    if(!empty($data_akun_before)){

                                        foreach($data_akun_before as $dk){
                                            $data_akun4digit_before[] =  $dk->kode_akun4digit ;
                                        }
                                        
                                        $data___lalu = array(
                                            'kode_unit_subunit' => $this->check_session->get_unit(),
                                            'tahun' => $this->cur_tahun,
                                            'kode_akun4digit' => $data_akun4digit_before
                                        );

                                        $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun4digit_lalu($data___lalu,'EM');
                                    
                                    }
                                    

                                    $rincian_keluaran = $this->rsa_em_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));


                                $daftar_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_kuitansi_by_url_id(base64_decode(urldecode($du_p)));

                                $subdata['id_nomor'] = $id_nomor ;
                                
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['rel_kuitansi_pengembalian'] = $du_p;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['daftar_kuitansi_pengembalian'] = $daftar_kuitansi_pengembalian;
                                $subdata['nomor_spp'] = $nomor_trx_spp;


                                $subdata['hash_url'] = $hash_url;

                                $subdata['jenis'] = 'em';
                                
                                
                                $subdata['detail_verifikator']  = $this->rsa_em_model->get_verifikator($this->check_session->get_unit());

                                // $subdata['detail_verifikator']  = $this->rsa_em_model->get_verifikator_by_spm($nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_em_model->get_tgl_spm_kpa_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_em_model->get_tgl_spm_verifikator_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_em_model->get_tgl_spm_kbuu_by_spp($nomor_trx_spp);

                                $subdata['ket'] = $this->rsa_em_model->lihat_ket_by_str_trx($nomor_trx_spp);
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_pengesahan/spm_pengesahan",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }
                
            function spm_em_lanjut($url = ''){

                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){                                                                              

                            $url = urldecode($url);

                            if( base64_encode(base64_decode($url, true)) === $url){
                                $url = base64_decode($url);
                            }else{
                                redirect(site_url('/'));
                            }


                            // echo $url ; die ;

                                

                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE); 

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
                                
                                $dokumen = $this->rsa_em_model->check_dokumen_em_by_str_trx($url);

                                // echo $dokumen ; die;
                              
                                $subdata['doc'] = $dokumen;
                                

                                $nomor_trx_spp = $url ;


                                $id_nomor = $this->rsa_em_model->get_nomor_spp_urut_by_nomor_spp($nomor_trx_spp) ;

                                // echo $id_nomor_em; die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '0',
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
                                $array_id_pengembalian = '';
                                $pengeluaran = 0;
                                $pengembalian = 0;
                                $du = '' ;
                                $du_p = '' ;

                                //////////////
                                /// SPP ///
                                /////////////

                                    
                                    $data_spp = $this->rsa_em_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
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
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                                            $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }

                                        // echo $pengeluaran; die;

                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
                                    // var_dump($data_kuitansi_pengembalian); die;
                                    $kuitansi_d_pengembalian = array();
                                    if(!empty($data_kuitansi_pengembalian)){
                                        foreach($data_kuitansi_pengembalian as $dk){
                                            $kuitansi_d_pengembalian[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_p = json_encode($kuitansi_d_pengembalian);
                                        $data_url_pengembalian = urlencode(base64_encode($du_p));
                                        $du_p = $data_url_pengembalian ;
                                        $data_url_pengembalian = urldecode($data_url_pengembalian);
                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
                                           // echo $array_id_pengembalian ; die ;
                                            $array_id_pengembalian = $data_spp->data_kuitansi_pengembalian;
                                           // echo $array_id_pengembalian ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }

                                        // echo $pengembalian ; die ;


                                    $subdata['detail_spp']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );

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
                                    
                                    $subdata['alias_spp'] = $data_spp->alias_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                    setlocale(LC_ALL, 'id_ID.utf8'); $subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 


                                //////////////
                                /// SPM ///
                                /////////////
                                
                                
                                    
                                    $nomor_trx_ = $this->rsa_em_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-EM'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    
//                                    echo $nomor_trx_spp ; die;
                                    
//                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
                                    $subdata['detail_spm']  = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );

                                    // var_dump($subdata['detail_em_spm']);die;
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    
                                    $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                    $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
                                    $subdata['detail_verifikator']  = $this->rsa_em_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
                                    $subdata['detail_kuasa_buu']  = $this->user_model->get_detail_rsa_user('99','11');
                                    $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');
                                    
                                    $subdata['detail_spm_pic']  = (object) array(
                                        'untuk_bayar' => $data_spp->untuk_bayar,
                                        'penerima' => $data_spp->penerima,
                                        'alamat_penerima' => $data_spp->alamat,
                                        'nama_bank_penerima' => $data_spp->nmbank,
                                        'nama_rek_penerima' => $data_spp->nmrekening,
                                        'no_rek_penerima' => $data_spp->rekening,
                                        'npwp_penerima' => $data_spp->npwp,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );

                                    $subdata['cur_tahun_spm'] = $this->cur_tahun;
                                    $subdata['tgl_spm'] = '';

    //                                if(($dokumen_em == '') || ($dokumen_em == 'SPP-DITOLAK') || ($dokumen_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

//                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                $daftar_kuitansi = array();
                                $daftar_kuitansi_pengembalian = array();

                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );

                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun4digit($data__,'EM');

                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);

                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'EM');

                                    $data_rekap_pajak = $this->kuitansi_model->get_rekap_pajak_by_array_id($data__,$this->cur_tahun);
                                    $data_rekap_bruto = $this->kuitansi_model->get_rekap_bruto_by_array_id($data__,$this->cur_tahun);

                                        $data_akun4digit = array();
                                        foreach($data_akun_pengeluaran as $da){
                                            $data_akun4digit[] =  $da->kode_akun4digit ;
                                        }

                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun4digit' => $data_akun4digit
                                    );

                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                

                                    $data_akun_before = $this->kuitansi_model->get_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);


                                    $data_akun4digit_before = array();


                                    if(!empty($data_akun_before)){

                                        foreach($data_akun_before as $dk){
                                            $data_akun4digit_before[] =  $dk->kode_akun4digit ;
                                        }
                                        
                                        $data___lalu = array(
                                            'kode_unit_subunit' => $this->check_session->get_unit(),
                                            'tahun' => $this->cur_tahun,
                                            'kode_akun4digit' => $data_akun4digit_before
                                        );

                                        $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun4digit_lalu($data___lalu,'EM');
                                    
                                    }
                                    

                                    $rincian_keluaran = $this->rsa_em_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));


                                $daftar_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_kuitansi_by_url_id(base64_decode(urldecode($du_p)));

                                $subdata['id_nomor'] = $id_nomor ;
                                
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['rel_kuitansi_pengembalian'] = $du_p;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['daftar_kuitansi_pengembalian'] = $daftar_kuitansi_pengembalian;
                                $subdata['nomor_spp'] = $nomor_trx_spp;


                                $subdata['jenis'] = 'em';
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_em_model->get_verifikator($this->check_session->get_unit());

                                // $subdata['detail_verifikator']  = $this->rsa_em_model->get_verifikator_by_spm($nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_em_model->get_tgl_spm_kpa_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_em_model->get_tgl_spm_verifikator_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_em_model->get_tgl_spm_kbuu_by_spp($nomor_trx_spp);

                                $subdata['ket'] = $this->rsa_em_model->lihat_ket_by_str_trx($nomor_trx_spp);
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_pengesahan/spm_pengesahan_lanjut",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }


            function spm_em_lihat($url){


                    if($this->check_session->user_session() && (($this->check_session->get_level()==11)||($this->check_session->get_level()==2)||($this->check_session->get_level()==3||($this->check_session->get_level()==17)||($this->check_session->get_level()==14)||($this->check_session->get_level()==100)))){

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
                                
                                
                                $dokumen = $this->rsa_em_model->check_dokumen_em_by_str_trx($url);

                                // echo $dokumen_em ; die;
                              
                                $subdata['doc'] = $dokumen;
                                
//                                $subdata['tgl_spm'] = $this->rsa_em_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_em_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spm = $this->rsa_em_model->get_spm_by_spp($nomor_trx_spp);

                                // echo $nomor_trx_spm ; die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '0',
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
                                $du = '' ;
                                
                                //////////////
                                /// SPP ///
                                /////////////
                                    
                                    $data_spp = $this->rsa_em_model->get_data_spp($nomor_trx_spp);
                                   // var_dump($data_spp);die;
                                    
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
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
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                                            $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }

                                        // echo $pengeluaran; die;
                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
                                    // var_dump($data_kuitansi_pengembalian); die;
                                    $kuitansi_d_pengembalian = array();
                                    if(!empty($data_kuitansi_pengembalian)){
                                        foreach($data_kuitansi_pengembalian as $dk){
                                            $kuitansi_d_pengembalian[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_p = json_encode($kuitansi_d_pengembalian);
                                        $data_url_pengembalian = urlencode(base64_encode($du_p));
                                        $du_p = $data_url_pengembalian ;
                                        $data_url_pengembalian = urldecode($data_url_pengembalian);
                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
                                           // echo $array_id_pengembalian ; die ;
                                            $array_id_pengembalian = $data_spp->data_kuitansi_pengembalian;
                                           // echo $array_id_pengembalian ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }


                                        // echo $pengembalian; die;

                                    $subdata['detail_spp']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
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
                                    $subdata['alias_spp'] = $data_spp->alias_spp;
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                //////////////
                                /// SPM ///
                                /////////////
                                    
                                    $data_spm = $this->rsa_em_model->get_data_spm($nomor_trx_spm);
                                    // var_dump($data_spm);die;
                                    $subdata['detail_spm']  = array(
                                                                    'nom' => $data_spm->jumlah_bayar,
                                                                    'pengembalian' => $data_spm->jumlah_pengembalian ,
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
                                    // var_dump($subdata);die;
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_spm_pic']  = (object) array(
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

                                    $subdata['alias_spm'] = $data_spm->alias_spm;
                                     

                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                $daftar_kuitansi = array();
                                $daftar_kuitansi_pengembalian = array();

                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'array_id' => json_decode($array_id)
                                    );

                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun4digit($data__,'EM');

                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);

                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'EM');

                                    $data_rekap_pajak = $this->kuitansi_model->get_rekap_pajak_by_array_id($data__,$tahun);
                                    $data_rekap_bruto = $this->kuitansi_model->get_rekap_bruto_by_array_id($data__,$tahun);

                                        $data_akun4digit = array();
                                        foreach($data_akun_pengeluaran as $da){
                                            $data_akun4digit[] =  $da->kode_akun4digit ;
                                        }

                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'kode_akun4digit' => $data_akun4digit
                                    );

                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                

                                    $data_akun_before = $this->kuitansi_model->get_akun_before_by_unit($kd_unit,$tahun);


                                    $data_akun4digit_before = array();


                                    if(!empty($data_akun_before)){

                                        foreach($data_akun_before as $dk){
                                            $data_akun4digit_before[] =  $dk->kode_akun4digit ;
                                        }
                                        
                                        $data___lalu = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'tahun' => $tahun,
                                            'kode_akun4digit' => $data_akun4digit_before
                                        );

                                        $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun4digit_lalu($data___lalu,'EM');
                                    
                                    }
                                    

                                    $rincian_keluaran = $this->rsa_em_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));


                                $daftar_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_kuitansi_by_url_id(base64_decode(urldecode($du_p)));

                                // $subdata['id_nomor'] = $id_nomor ;
                                
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                // vdebug($subdata['data_rekap_pajak']);
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['rel_kuitansi_pengembalian'] = $du_p;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['daftar_kuitansi_pengembalian'] = $daftar_kuitansi_pengembalian;
                                $subdata['nomor_spp'] = $nomor_trx_spp;


                                $subdata['jenis'] = 'em';
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_em_model->get_verifikator_by_spm($nomor_trx_spm);

                                // var_dump($subdata['detail_verifikator']) ; die;

                                // echo $this->rsa_em_model->get_tgl_spm_kpa_by_spm($nomor_trx_spp); die;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_em_model->get_tgl_spm_kpa_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_em_model->get_tgl_spm_verifikator_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_em_model->get_tgl_spm_kbuu_by_spp($nomor_trx_spp);

                                $subdata['ket'] = $this->rsa_em_model->lihat_ket_by_str_trx($nomor_trx_spp);

                                // var_dump($subdata) ; die;
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_pengesahan/spm_pengesahan_lihat",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
        }
                
                function spm_em_kpa($url = ''){

                    if($this->check_session->user_session() && (($this->check_session->get_level()==2)||($this->check_session->get_level()==100))){

                            $url = urldecode($url);

                            if( base64_encode(base64_decode($url, true)) === $url){
                                $url = base64_decode($url);
                            }else{
                                redirect(site_url('/'));
                            }


                            // echo $url ; die ;

                                

                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE); 

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
                                
                                
                                $dokumen = $this->rsa_em_model->check_dokumen_em_by_str_trx($url);



                                // $dokumen_em = $this->rsa_em_model->check_dokumen_em($this->check_session->get_unit(),$this->cur_tahun);

                                // echo $dokumen_em ; die;
                              
                                $subdata['doc_em'] = $dokumen ;
                                
//                                $subdata['tgl_spm'] = $this->rsa_em_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_em_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spp = $url ;

                                // echo $nomor_trx_spp; 

                                $id_nomor = $this->rsa_em_model->get_nomor_spp_urut_by_nomor_spp($nomor_trx_spp) ;

                                // echo $id_nomor_em; die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '0',
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
                                $array_id_pengembalian = '';
                                $pengeluaran = 0;
                                $pengembalian = 0;
                                $du = '' ;
                                $du_p = '' ;

                                
                                    
                                    $data_spp = $this->rsa_em_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
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
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                                            $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }

                                        // echo $pengeluaran; die;

                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
                                    // var_dump($data_kuitansi_pengembalian); die;
                                    $kuitansi_d_pengembalian = array();
                                    if(!empty($data_kuitansi_pengembalian)){
                                        foreach($data_kuitansi_pengembalian as $dk){
                                            $kuitansi_d_pengembalian[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_p = json_encode($kuitansi_d_pengembalian);
                                        $data_url_pengembalian = urlencode(base64_encode($du_p));
                                        $du_p = $data_url_pengembalian ;
                                        $data_url_pengembalian = urldecode($data_url_pengembalian);
                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
                                           // echo $array_id_pengembalian ; die ;
                                            $array_id_pengembalian = $data_spp->data_kuitansi_pengembalian;
                                           // echo $array_id_pengembalian ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }

                                        // echo $pengembalian ; die ;

                                       // echo $data_spp->jumlah_pengembalian ; die ;

                                    $subdata['detail_spp']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
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



    //                                if(($dokumen_em == '') || ($dokumen_em == 'SPP-DITOLAK') || ($dokumen_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    $subdata['alias_spp'] = $data_spp->alias_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                    
                                    $nomor_trx_spm = $this->rsa_em_model->get_spm_by_spp($nomor_trx_spp);

                                    // echo $nomor_trx_spm; die;  

                                    $data_spm = $this->rsa_em_model->get_data_spm($nomor_trx_spm);
                                    // var_dump($data_spm);die;
                                    $subdata['detail_spm']  = array(
                                                                    'nom' => $data_spm->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
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
                                    // var_dump($subdata);die;
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_spm_pic']  = (object) array(
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

                                    $subdata['alias_spm'] = $data_spm->alias_spm;
                                     
       
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                $daftar_kuitansi = array();
                                $daftar_kuitansi_pengembalian = array();

                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );

                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun4digit($data__,'EM');

                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);

                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'EM');

                                    $data_rekap_pajak = $this->kuitansi_model->get_rekap_pajak_by_array_id($data__,$this->cur_tahun);
                                    $data_rekap_bruto = $this->kuitansi_model->get_rekap_bruto_by_array_id($data__,$this->cur_tahun);

                                        $data_akun4digit = array();
                                        foreach($data_akun_pengeluaran as $da){
                                            $data_akun4digit[] =  $da->kode_akun4digit ;
                                        }

                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun4digit' => $data_akun4digit
                                    );

                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                

                                    $data_akun_before = $this->kuitansi_model->get_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);


                                    $data_akun4digit_before = array();


                                    if(!empty($data_akun_before)){

                                        foreach($data_akun_before as $dk){
                                            $data_akun4digit_before[] =  $dk->kode_akun4digit ;
                                        }
                                        
                                        $data___lalu = array(
                                            'kode_unit_subunit' => $this->check_session->get_unit(),
                                            'tahun' => $this->cur_tahun,
                                            'kode_akun4digit' => $data_akun4digit_before
                                        );

                                        $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun4digit_lalu($data___lalu,'EM');
                                    
                                    }
                                    

                                    $rincian_keluaran = $this->rsa_em_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));


                                    $daftar_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_kuitansi_by_url_id(base64_decode(urldecode($du_p)));

                                $subdata['id_nomor'] = $id_nomor ;


                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['rel_kuitansi_pengembalian'] = $du_p;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['daftar_kuitansi_pengembalian'] = $daftar_kuitansi_pengembalian;
                                $subdata['nomor_spp'] = $nomor_trx_spp;


                                $subdata['jenis'] = 'em';
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_em_model->get_verifikator_by_spm($nomor_trx_spm);

                                // echo $this->rsa_em_model->get_tgl_spm_kpa_by_spm($nomor_trx_spp); die;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_em_model->get_tgl_spm_kpa_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_em_model->get_tgl_spm_verifikator_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_em_model->get_tgl_spm_kbuu_by_spp($nomor_trx_spp);

                                $subdata['ket'] = $this->rsa_em_model->lihat_ket_by_str_trx($nomor_trx_spp);
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_pengesahan/spm_pengesahan_kpa",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }


                function spm_em_verifikator($url = ''){

                    if($this->check_session->user_session() && (($this->check_session->get_level()==3)||($this->check_session->get_level()==100))){

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
                                
                                
                                $dokumen = $this->rsa_em_model->check_dokumen_em_by_str_trx($url);



                                // $dokumen_em = $this->rsa_em_model->check_dokumen_em($this->check_session->get_unit(),$this->cur_tahun);

                                // echo $dokumen_em ; die;
                              
                                $subdata['doc'] = $dokumen;
                                
//                                $subdata['tgl_spm'] = $this->rsa_em_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_em_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spp = $url ;

                                // echo $nomor_trx_spp; die;

                                $id_nomor = $this->rsa_em_model->get_nomor_spp_urut_by_nomor_spp($nomor_trx_spp) ;

                                // echo $id_nomor_em; die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '0',
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
                                $array_id_pengembalian = '';
                                $pengeluaran = 0;
                                $pengembalian = 0;
                                $du = '' ;
                                $du_p = '' ;

                                
                                // if(($dokumen_em == 'SPM-DRAFT-PPK')){
                                    
                                    $data_spp = $this->rsa_em_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
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
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                                            $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }

                                        // echo $pengeluaran; die;

                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
                                    // var_dump($data_kuitansi_pengembalian); die;
                                    $kuitansi_d_pengembalian = array();
                                    if(!empty($data_kuitansi_pengembalian)){
                                        foreach($data_kuitansi_pengembalian as $dk){
                                            $kuitansi_d_pengembalian[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_p = json_encode($kuitansi_d_pengembalian);
                                        $data_url_pengembalian = urlencode(base64_encode($du_p));
                                        $du_p = $data_url_pengembalian ;
                                        $data_url_pengembalian = urldecode($data_url_pengembalian);
                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
                                           // echo $array_id_pengembalian ; die ;
                                            $array_id_pengembalian = $data_spp->data_kuitansi_pengembalian;
                                           // echo $array_id_pengembalian ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }

                                        // echo $pengembalian ; die ;

                                       // echo $data_spp->jumlah_pengembalian ; die ;

                                    $subdata['detail_spp']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
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



    //                                if(($dokumen_em == '') || ($dokumen_em == 'SPP-DITOLAK') || ($dokumen_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    $subdata['alias_spp'] = $data_spp->alias_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;

                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                // }else{
                                    
                                //    // NOT WORK //
                                    
                                // }
                                
                                // if(($dokumen_em == 'SPM-DRAFT-PPK')){
                                    
                                    // $nomor_trx_spm = $this->rsa_em_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                    
                                    $nomor_trx_spm = $this->rsa_em_model->get_spm_by_spp($nomor_trx_spp);

                                    // echo $nomor_trx_spm; die;  

                                    $data_spm = $this->rsa_em_model->get_data_spm($nomor_trx_spm);
                                    // var_dump($data_spm);die;
                                    $subdata['detail_spm']  = array(
                                                                    'nom' => $data_spm->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
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
                                    // var_dump($subdata);die;
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_spm_pic']  = (object) array(
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

                                    $subdata['alias_spm'] = $data_spm->alias_spm;
                                     
                                // }else{
                                    
                                //     // NOT WORK //
                                    
                                // }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                $daftar_kuitansi = array();
                                $daftar_kuitansi_pengembalian = array();

                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'array_id' => json_decode($array_id)
                                    );

                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun4digit($data__,'EM');

                                    // echo '<pre>'; var_dump($data_akun_pengeluaran); die;

                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);

                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'EM');

                                    $data_rekap_pajak = $this->kuitansi_model->get_rekap_pajak_by_array_id($data__,$tahun);
                                    $data_rekap_bruto = $this->kuitansi_model->get_rekap_bruto_by_array_id($data__,$tahun);

                                        $data_akun4digit = array();
                                        foreach($data_akun_pengeluaran as $da){
                                            $data_akun4digit[] =  $da->kode_akun4digit ;
                                        }

                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'kode_akun4digit' => $data_akun4digit
                                    );

                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                

                                    $data_akun_before = $this->kuitansi_model->get_akun_before_by_unit($kd_unit,$tahun);


                                    $data_akun4digit_before = array();


                                    if(!empty($data_akun_before)){

                                        foreach($data_akun_before as $dk){
                                            $data_akun4digit_before[] =  $dk->kode_akun4digit ;
                                        }
                                        
                                        $data___lalu = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'tahun' => $tahun,
                                            'kode_akun4digit' => $data_akun4digit_before
                                        );

                                        $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun4digit_lalu($data___lalu,'EM');
                                    
                                    }
                                    

                                    $rincian_keluaran = $this->rsa_em_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));


                                    $daftar_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_kuitansi_by_url_id(base64_decode(urldecode($du_p)));

                                $subdata['id_nomor'] = $id_nomor ;


                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['rel_kuitansi_pengembalian'] = $du_p;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['daftar_kuitansi_pengembalian'] = $daftar_kuitansi_pengembalian;
                                $subdata['nomor_spp'] = $nomor_trx_spp;


                                $subdata['jenis'] = 'em';
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_em_model->get_verifikator_by_spm($nomor_trx_spm);


                                // var_dump($subdata['detail_verifikator']) ; die;

                                // echo $this->rsa_em_model->get_tgl_spm_kpa_by_spm($nomor_trx_spp); die;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_em_model->get_tgl_spm_kpa_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_em_model->get_tgl_spm_verifikator_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_em_model->get_tgl_spm_kbuu_by_spp($nomor_trx_spp);

                                $subdata['ket'] = $this->rsa_em_model->lihat_ket_by_str_trx($nomor_trx_spp);
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_pengesahan/spm_pengesahan_verifikator",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }


                function spm_em_kbuu($url = ''){

                    if($this->check_session->user_session() && (($this->check_session->get_level()==11)||($this->check_session->get_level()==100))){
                //set data for main template
                // $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                // $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                //$subdata_rsa_up['result_rsa_up']      = $this->rsa_up_model->search_rsa_up();
//              $subdata['detail_up']           = array(
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
                                
                                
                                $dokumen = $this->rsa_em_model->check_dokumen_em_by_str_trx($url);



                                // $dokumen_em = $this->rsa_em_model->check_dokumen_em($this->check_session->get_unit(),$this->cur_tahun);

                                // echo $dokumen_em ; die;
                              
                                $subdata['doc'] = $dokumen;
                                
//                                $subdata['tgl_spm'] = $this->rsa_em_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_em_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spp = $url ;

                                // echo $nomor_trx_spp; die;

                                $id_nomor = $this->rsa_em_model->get_nomor_spp_urut_by_nomor_spp($nomor_trx_spp) ;

                                // echo $id_nomor_em; die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '0',
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
                                $array_id_pengembalian = '';
                                $pengeluaran = 0;
                                $pengembalian = 0;
                                $du = '' ;
                                $du_p = '' ;

                                
                                // if(($dokumen_em == 'SPM-DRAFT-PPK')){
                                    
                                    $data_spp = $this->rsa_em_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
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
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                                            $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }

                                        // echo $pengeluaran; die;

                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
                                    // var_dump($data_kuitansi_pengembalian); die;
                                    $kuitansi_d_pengembalian = array();
                                    if(!empty($data_kuitansi_pengembalian)){
                                        foreach($data_kuitansi_pengembalian as $dk){
                                            $kuitansi_d_pengembalian[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_p = json_encode($kuitansi_d_pengembalian);
                                        $data_url_pengembalian = urlencode(base64_encode($du_p));
                                        $du_p = $data_url_pengembalian ;
                                        $data_url_pengembalian = urldecode($data_url_pengembalian);
                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
                                           // echo $array_id_pengembalian ; die ;
                                            $array_id_pengembalian = $data_spp->data_kuitansi_pengembalian;
                                           // echo $array_id_pengembalian ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }

                                        // echo $pengembalian ; die ;

                                       // echo $data_spp->jumlah_pengembalian ; die ;

                                    $subdata['detail_spm']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
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



    //                                if(($dokumen_em == '') || ($dokumen_em == 'SPP-DITOLAK') || ($dokumen_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    $subdata['alias_spp'] = $data_spp->alias_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                // }else{
                                    
                                //    // NOT WORK //
                                    
                                // }
                                
                                // if(($dokumen_em == 'SPM-DRAFT-PPK')){
                                    
                                    // $nomor_trx_spm = $this->rsa_em_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                    
                                    $nomor_trx_spm = $this->rsa_em_model->get_spm_by_spp($nomor_trx_spp);

                                    // echo $nomor_trx_spm; die;  

                                    $data_spm = $this->rsa_em_model->get_data_spm($nomor_trx_spm);
                                    // var_dump($data_spm);die;
                                    $subdata['detail_spm']  = array(
                                                                    'nom' => $data_spm->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
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
                                    // var_dump($subdata);die;
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_spm_pic']  = (object) array(
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

                                    $subdata['alias_spm'] = $data_spm->alias_spm;
                                     
                                // }else{
                                    
                                //     // NOT WORK //
                                    
                                // }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                $daftar_kuitansi = array();
                                $daftar_kuitansi_pengembalian = array();

                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'array_id' => json_decode($array_id)
                                    );

                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun4digit($data__,'EM');

                                    // echo '<pre>'; var_dump($data_akun_pengeluaran); die;

                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);

                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'EM');

                                    $data_rekap_pajak = $this->kuitansi_model->get_rekap_pajak_by_array_id($data__,$tahun);
                                    $data_rekap_bruto = $this->kuitansi_model->get_rekap_bruto_by_array_id($data__,$tahun);

                                        $data_akun4digit = array();
                                        foreach($data_akun_pengeluaran as $da){
                                            $data_akun4digit[] =  $da->kode_akun4digit ;
                                        }

                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'kode_akun4digit' => $data_akun4digit
                                    );

                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                

                                    $data_akun_before = $this->kuitansi_model->get_akun_before_by_unit($kd_unit,$tahun);


                                    $data_akun4digit_before = array();


                                    if(!empty($data_akun_before)){

                                        foreach($data_akun_before as $dk){
                                            $data_akun4digit_before[] =  $dk->kode_akun4digit ;
                                        }
                                        
                                        $data___lalu = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'tahun' => $tahun,
                                            'kode_akun4digit' => $data_akun4digit_before
                                        );

                                        $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun4digit_lalu($data___lalu,'EM');
                                    
                                    }
                                    

                                    $rincian_keluaran = $this->rsa_em_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));


                                    $daftar_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_kuitansi_by_url_id(base64_decode(urldecode($du_p)));

                                $subdata['id_nomor'] = $id_nomor ;


                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['rel_kuitansi_pengembalian'] = $du_p;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['daftar_kuitansi_pengembalian'] = $daftar_kuitansi_pengembalian;
                                $subdata['nomor_spp'] = $nomor_trx_spp;


                                $subdata['jenis'] = 'em';
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_em_model->get_verifikator_by_spm($nomor_trx_spm);

                                // var_dump($subdata['detail_verifikator']) ; die;

                                // echo $this->rsa_em_model->get_tgl_spm_kpa_by_spm($nomor_trx_spp); die;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_em_model->get_tgl_spm_kpa_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_em_model->get_tgl_spm_verifikator_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_em_model->get_tgl_spm_kbuu_by_spp($nomor_trx_spp);

                                $subdata['ket'] = $this->rsa_em_model->lihat_ket_by_str_trx($nomor_trx_spp);

                                $this->load->model('kas_undip_model');
                                
                                $subdata['kas_undip'] = $this->kas_undip_model->get_saldo_kas_all_akun();//get_akun_kas6_saldo();//(
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_pengesahan/spm_pengesahan_kbuu",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }


                function spm_em_lihat_99($url,$kd_unit="",$tahun=""){
                     if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100)||($this->check_session->get_level()==17)||($this->check_session->get_level()==11))){

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
                                
                                
                                $dokumen_em = $this->rsa_em_model->check_dokumen_em_by_str_trx($url);



                                // $dokumen_em = $this->rsa_em_model->check_dokumen_em($this->check_session->get_unit(),$this->cur_tahun);

                                // echo $dokumen_em ; die;
                              
                                $subdata['doc_em'] = $dokumen_em;
                                
//                                $subdata['tgl_spm'] = $this->rsa_em_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_em_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spp = $url ;

                                // echo $nomor_trx_spp; die;

                                $id_nomor_em = $this->rsa_em_model->get_nomor_spp_urut_by_nomor_spp($nomor_trx_spp) ;

                                // echo $id_nomor_em; die;
                                
                                $data_spp = (object)array(
                                    'jumlah_bayar' => '0',
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
                                $array_id_pengembalian = '';
                                $pengeluaran = 0;
                                $pengembalian = 0;
                                $du = '' ;
                                $du_p = '' ;

                                
                                // if(($dokumen_em == 'SPM-DRAFT-PPK')){
                                    
                                    $data_spp = $this->rsa_em_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
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
                                        if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                            $array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                                            $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $tahun,
                                            );
                                            $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengeluaran = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }

                                        // echo $pengeluaran; die;

                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'EM');
                                    // var_dump($data_kuitansi_pengembalian); die;
                                    $kuitansi_d_pengembalian = array();
                                    if(!empty($data_kuitansi_pengembalian)){
                                        foreach($data_kuitansi_pengembalian as $dk){
                                            $kuitansi_d_pengembalian[] = $dk->id_kuitansi;
                                        }
                                    }
//                                    $data_url_ = jss
//                                    urlencode(base64_encode($array_id)); 
                                        $du_p = json_encode($kuitansi_d_pengembalian);
                                        $data_url_pengembalian = urlencode(base64_encode($du_p));
                                        $du_p = $data_url_pengembalian ;
                                        $data_url_pengembalian = urldecode($data_url_pengembalian);
                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
                                           // echo $array_id_pengembalian ; die ;
                                            $array_id_pengembalian = $data_spp->data_kuitansi_pengembalian;
                                           // echo $array_id_pengembalian ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }

                                        // echo $pengembalian ; die ;

                                       // echo $data_spp->jumlah_pengembalian ; die ;

                                    $subdata['detail_em']   = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
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



    //                                if(($dokumen_em == '') || ($dokumen_em == 'SPP-DITOLAK') || ($dokumen_em == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;

                                    $subdata['alias_spp'] = $data_spp->alias_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                // }else{
                                    
                                //    // NOT WORK //
                                    
                                // }
                                
                                // if(($dokumen_em == 'SPM-DRAFT-PPK')){
                                    
                                    // $nomor_trx_spm = $this->rsa_em_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                    
                                    $nomor_trx_spm = $this->rsa_em_model->get_spm_by_spp($nomor_trx_spp);

                                    // echo $nomor_trx_spm; die;  

                                    $data_spm = $this->rsa_em_model->get_data_spm($nomor_trx_spm);
                                    // var_dump($data_spm);die;
                                    $subdata['detail_em_spm']  = array(
                                                                    'nom' => $data_spm->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
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
                                    // var_dump($subdata);die;
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    $subdata['detail_spm_pic']  = (object) array(
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

                                    $subdata['alias_spm'] = $data_spm->alias_spm;
                                     
                                // }else{
                                    
                                //     // NOT WORK //
                                    
                                // }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                $daftar_kuitansi = array();
                                
                                
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__,'EM');

                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);
                                   // echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'EM');

                                    $data_rekap_pajak = $this->kuitansi_model->get_rekap_pajak_by_array_id($data__);
                                    $data_rekap_bruto = $this->kuitansi_model->get_rekap_bruto_by_array_id($data__);

                                    $data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                                    foreach($data_akun_pengeluaran as $da){
                                        $data_akun5digit[] =  $da->kode_akun5digit ;
                                    }
//                                    
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
                                    
                                    $data___ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );

                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $nomor_spm = $this->rsa_em_model->get_spm_by_spp($nomor_trx_spp);
                                    
//                                    echo $nomor_spm_cair_before; die;
                                    
                                    if(empty($nomor_spm)){
                                        
                                        $data_akun_before = $this->kuitansi_model->get_em_akun_before_by_unit($kd_unit,$tahun);
                                    
//                                        var_dump($data_akun_before); die;
                                        
                                    }else{
                                        
                                        $nomor_spm_cair_before = $this->rsa_em_model->get_nomer_spm_cair_lalu($kd_unit,$tahun);

                                        // echo $nomor_spm_cair_before ; die;
                                        
                                        $data_akun_before = $this->kuitansi_model->get_em_akun_before_by_spm($nomor_spm);

                                        if($nomor_spm_cair_before != $nomor_spm){
                                             $data_akun_before = $this->kuitansi_model->get_em_akun_before_by_unit($kd_unit,$tahun);
                                        }
                                    
//                                        var_dump($data_akun_before); die;
                                    }
                                    

                                        $data_akun5digit_before = array();

    //                                    if(!empty($data_akun_pengeluaran)){

                                        if(!empty($data_akun_before)){
                                            foreach($data_akun_before as $dk){
                                                $data_akun5digit_before[] =  $dk->kode_akun5digit ;
                                            }
                                            
                                            $data___lalu = array(
                                                'kode_unit_subunit' => $kd_unit,
                                                'tahun' => $tahun,
                                                'kode_akun5digit' => $data_akun5digit_before
                                            );

        //                                    echo '<pre>';print_r($data___lalu);echo '</pre>';die;

                                            $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___lalu,'EM');
                                        
                                        }
                                        
                                        
                                    $rincian_keluaran = $this->rsa_em_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
                                    

                                }

                                // die;

                                $daftar_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_kuitansi_by_url_id(base64_decode(urldecode($du_p)));

                                // var_dump($daftar_kuitansi_pengembalian); die;

                                // var_dump($data_spp_pajak); die;

                                $subdata['id_nomor_em'] = $id_nomor_em ;
                                
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['rel_kuitansi_pengembalian'] = $du_p;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['daftar_kuitansi_pengembalian'] = $daftar_kuitansi_pengembalian;
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_em_model->get_verifikator_by_spm($nomor_trx_spm);

                                // var_dump($subdata['detail_verifikator']) ; die;

                                // echo $this->rsa_em_model->get_tgl_spm_kpa_by_spm($nomor_trx_spp); die;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_em_model->get_tgl_spm_kpa_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_em_model->get_tgl_spm_verifikator_by_spp($nomor_trx_spp);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_em_model->get_tgl_spm_kbuu_by_spp($nomor_trx_spp);

                                $subdata['ket'] = $this->rsa_em_model->lihat_ket_by_str_trx($nomor_trx_spp);

                                $this->load->model('akun_kas6_model');

                                $subdata['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_em/spm_em_lihat",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }
                
//                 function daftar_unit($tahun=''){
                    
//                     $data['cur_tahun'] =  $this->cur_tahun;
                    
//                     if($tahun == ''){
//                         $tahun = $this->cur_tahun ;
//                     }
                    
//                     /* check session    */
//                     if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
//                             $data['main_menu']              = $this->load->view('main_menu','',TRUE);
//                             $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
//                             $subdata['unit_usul']       = $this->rsa_em_model->get_em_unit_usul_verifikator($user->id,$tahun);
//                             $subdata['subunit_usul']        = $this->rsa_em_model->get_em_subunit_usul_verifikator($user->id,$tahun);
// //                            echo '<pre>';var_dump($subdata['subunit_usul']);echo '</pre>';die;
//                             $subdata['cur_tahun'] =  $tahun;
// //                            $subdata['opt_sumber_dana']   = $this->option->sumber_dana();
//                             $data['main_content']       = $this->load->view("rsa_em/daftar_unit",$subdata,TRUE);
//                             /*  Load main template  */
//     //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
//                             $this->load->view('main_template',$data);
//                     }else{
//                             redirect('welcome','refresh');  // redirect ke halaman home
//                     }
//                 }


                function daftar_unit($tahun=''){
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
                    
                    
        
                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
//                            $subdata['unit_usul']         = $this->rsa_up_model->get_up_unit_usul_verifikator($user->id,$tahun);
                            $subdata['unit_usul']       = $this->rsa_em_model->get_em_unit_usul_verifikator($user->id,$tahun);
                            
                            $subdata['subunit_usul']        = $this->rsa_em_model->get_em_subunit_usul_verifikator($user->id,$tahun);
                            $subdata['cur_tahun'] =  $tahun;
                            $subdata['jenis'] =  'em';
//                            $subdata['opt_sumber_dana']   = $this->option->sumber_dana();

                            // echo '<pre>';var_dump($subdata);echo '</pre>';die;

                            $data['main_content']       = $this->load->view("rsa_pengesahan/daftar_unit",$subdata,TRUE);
                            /*  Load main template  */
                // echo '<pre>';var_dump($subdata['unit_usul']);echo '</pre>';die;


                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }
                
                function daftar_unit_kbuu($tahun=''){
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }

                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['unit_usul']       = $this->rsa_em_model->get_em_unit_usul($tahun);
                            // echo '<pre>';var_dump($subdata['unit_usul']);echo '</pre>';die;
                            $subdata['subunit_usul']        = $this->rsa_em_model->get_em_subunit_usul($tahun);
                            $subdata['cur_tahun'] =  $tahun;
                            $subdata['jenis'] =  'em';
//                            $subdata['opt_sumber_dana']   = $this->option->sumber_dana();
                            $data['main_content']       = $this->load->view("rsa_pengesahan/daftar_unit_kbuu",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
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
                
                function usulkan_spp_em(){
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

                            $id_nomor_em = $this->input->post('id_nomor_em') ;

                            $rel_kuitansi_ = $this->input->post('rel_kuitansi');
                            $rel_kuitansi = urldecode($rel_kuitansi_);
                            if( base64_encode(base64_decode($rel_kuitansi, true)) === $rel_kuitansi){
                                $rel_kuitansi = base64_decode($rel_kuitansi);
                            }else{
                                redirect(site_url('/'));
                            }

                            $rel_kuitansi_pengembalian_ = $this->input->post('rel_kuitansi_pengembalian');
                            $rel_kuitansi_pengembalian = urldecode($rel_kuitansi_pengembalian_);
                            if( base64_encode(base64_decode($rel_kuitansi_pengembalian, true)) === $rel_kuitansi_pengembalian){
                                $rel_kuitansi_pengembalian = base64_decode($rel_kuitansi_pengembalian);
                            }else{
                                redirect(site_url('/'));
                            }

                            // echo $rel_kuitansi_pengembalian ; 

                            $jml_kuitansi = count(json_decode($rel_kuitansi)) ; 
                            $jml_kuitansi_pengembalian = count(json_decode($rel_kuitansi_pengembalian)) ; 

                            // echo $jml_kuitansi ; die ;

                           // echo $rel_kuitansi ; die;
//                            var_dump($this->input->post('keluaran'));die;
//                            var_dump(json_decode($this->input->post('keluaran')));
//                            var_dump(json_decode($this->input->post('nm_subkomponen')));die;
                            
                            $nm_subkomponen = json_decode($this->input->post('nm_subkomponen'));
                            $keluaran = json_decode($this->input->post('keluaran'));
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
                            
//                            var_dump($f_subkomponen);die;
                            
                            $c_keluaran = count($f_subkomponen);
                            
//                            echo $c_keluaran . '  ' . $c_subkomponen ; die;


                            
                            if((($c_subkomponen > 0) && ($c_subkomponen == $c_keluaran) && ($jml_kuitansi > 0))||($jml_kuitansi_pengembalian >0)){
                                
                                


                                $dokumen_em = $this->rsa_em_model->check_dokumen_em_by_str_trx($nomor_trx);

                                $check_exist_em = $this->rsa_em_model->check_exist_em($nomor_trx,$this->cur_tahun);

                                if((!$check_exist_em)&&($dokumen_em == '')){

                                // if(true){

                                // if($dokumen_em == ''){

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

                                    if($this->rsa_em_model->proses_nomor_spp_em($kd_unit,$data)){

                                        // $tgl_spp_dibuat = $this->input->post('tgl_spp_dibuat');

                                        // $time = strtotime($tgl_spp_dibuat);

                                        // $tgl_spp_dibuat = date('Y-m-d H:i:s',$time);

                                        $data_spp = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'nomor_trx_spp' => $this->rsa_em_model->get_id_nomor_em_by_nomor_trx($nomor_trx),
                                            'str_nomor_trx' => $nomor_trx,
                                            'alias_spp' =>  $this->input->post('alias_spp'),
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
                                            'data_kuitansi' => $rel_kuitansi,
                                            'jumlah_pengembalian' => $this->input->post('jumlah_pengembalian'),
                                            'data_kuitansi_pengembalian' => $rel_kuitansi_pengembalian,
                                        );



                                        $data = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'posisi' => $proses,
                                            'id_trx_nomor_em' => $this->rsa_em_model->get_id_nomor_em_by_nomor_trx($nomor_trx),
                                            'ket' => $ket,
                                            'aktif' => '1',
                                            'tahun' => $tahun,
                                            'tgl_proses' => date("Y-m-d H:i:s")
                                        );

                                       // var_dump($data_spp);die;

                                        if($this->rsa_em_model->proses_em($kd_unit,$data,$id_nomor_em) && $this->rsa_em_model->proses_data_spp($data_spp)){
                                            $keluaran = json_decode($this->input->post('keluaran'));
                                            $data = array();
                                            foreach($keluaran as $kel){
                                                if(!empty($kel)){
                                                    $data[] = array(
                                                        'str_nomor_trx_spp' => $nomor_trx,
                                                        'kode_usulan_rka' => $kel[0],
                                                        'jenis' => 'EM',
                                                        'keluaran' => urldecode($kel[1]),
                                                        'volume' => $kel[2],
                                                        'satuan' => $kel[3],
                                                        'kode_unit_subunit' => $kd_unit,
                                                        'tahun' => $this->cur_tahun,
                                                        'tgl_proses' => date("Y-m-d H:i:s"),
                                                    );
                                                }
                                            }

                                            $this->rsa_em_model->insert_keluaran($data);

                                            $data = array(
                                                'rel_kuitansi' => $rel_kuitansi,
                                                'str_nomor_trx' => $nomor_trx,
                                            );

                                            $data_pengembalian = array(
                                                'rel_kuitansi_pengembalian' => $rel_kuitansi_pengembalian,
                                                'str_nomor_trx' => $nomor_trx,
                                            );

                                            $this->kuitansi_model->insert_spp($data);

                                            $this->kuitansipengembalian_model->insert_spp($data_pengembalian);

                                            $this->rsa_em_model->proses_em_spp_rka($data);

                                            $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM EM anda berhasil disubmit.</div>');

                                            $this->session->unset_tempdata('array_id');
                                            $this->session->unset_tempdata('array_id_pengembalian');

                                            echo "sukses";

                                        }else{
                                            echo "gagal";
                                        }

                                    }else{
                                        echo "gagal";
                                    }

                                }
                                
                                ///
 
                            }else{
                                echo "gagal";
                            }


                            
                        }

                        }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                        }
                }
                
                function usulkan_spm_em(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14))){
                        if($this->input->post('proses')){
                            $proses = $this->input->post('proses');
                            $nomor_trx = $this->input->post('nomor_trx');
                            $nomor_trx_spp = $this->input->post('nomor_trx_spp');
                            $nomor_ = explode('/',$nomor_trx);
                            $bulan = $nomor_[3];

                            $id_nomor_em = $this->input->post('id_nomor_em') ;

                            $nomor_spp_ = explode('/',$nomor_trx_spp);


                            $jenis = 'SPM';//$this->input->post('jenis');
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

                            $rel_kuitansi_pengembalian_ = $this->input->post('rel_kuitansi_pengembalian');
                            $rel_kuitansi_pengembalian = urldecode($rel_kuitansi_pengembalian_);
                            if( base64_encode(base64_decode($rel_kuitansi_pengembalian, true)) === $rel_kuitansi_pengembalian){
                                $rel_kuitansi_pengembalian = base64_decode($rel_kuitansi_pengembalian);
                            }else{
                                redirect(site_url('/'));
                            }

                            // echo $rel_kuitansi_pengembalian ; 

                            // $jml_kuitansi = count(json_decode($rel_kuitansi)) ; 
                            // $jml_kuitansi_pengembalian = count(json_decode($rel_kuitansi_pengembalian)) ; 


                            // echo $id_nomor_em; die;

                            // echo '<pre>';
                            // var_dump($this->input->post()); die;
                            
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
                            
                            
                            $dokumen_em = $this->rsa_em_model->check_dokumen_em_by_str_trx($nomor_trx_spp);

                            $check_exist_em = $this->rsa_em_model->check_exist_em($nomor_trx,$this->cur_tahun);

                            // echo $dokumen_em; die;

                            // echo '<pre>' ; var_dump($this->input->post()); die;
                            
                            if((!$check_exist_em)&&($dokumen_em == 'SPP-FINAL')){


                                // echo '<pre>' ; var_dump($this->input->post()); die;
                                
                                if($this->rsa_em_model->proses_nomor_spm_em($kd_unit,$data) ){

                                    $id_trx_nomor_em = $this->rsa_em_model->get_id_nomor_em_by_nomor_trx($nomor_trx_spp) ;
                                    $id_trx_nomor_em_spm = $this->rsa_em_model->get_id_nomor_em_by_nomor_trx($nomor_trx) ;

                                    // $tgl_spm_dibuat = $this->input->post('tgl_spm_dibuat');

                                    // $time = strtotime($tgl_spm_dibuat);

                                    // $tgl_spm_dibuat = date('Y-m-d H:i:s',$time);

                                    $data_spm = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'nomor_trx_spm' => $id_trx_nomor_em_spm,
                                        'str_nomor_trx' => $nomor_trx,
                                        // 'alias_spm' => $this->input->post('alias_spm'),
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
                                        'tgl_spm' => date("Y-m-d H:i:s"),//$tgl_spm_dibuat,//date("Y-m-d H:i:s"),
                                        'data_kuitansi' => $rel_kuitansi,
                                        'jumlah_pengembalian' => $this->input->post('jumlah_pengembalian'),
                                        'data_kuitansi_pengembalian' => $rel_kuitansi_pengembalian,
                                    );
//                                    var_dump($data_spm);die;
                                    $data_spp_spm = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'nomor_trx_spp' => $id_trx_nomor_em,//$nomor_spp_[0],$this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                        'str_nomor_trx_spp' => $nomor_trx_spp,
                                        'nomor_trx_spm' => $id_trx_nomor_em_spm,//$nomor_[0],
                                        'str_nomor_trx_spm' =>$nomor_trx,
                                        'jenis_trx' => 'EM',
                                        'tahun' => $tahun,
                                    );
                                    $data = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'posisi' => $proses,
                                        'id_trx_nomor_em' => $id_trx_nomor_em,
                                        'id_trx_nomor_em_spm' => $id_trx_nomor_em_spm,
                                        'ket' => $ket,
                                        'aktif' => '1',
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );

                                    if($this->rsa_em_model->proses_em($kd_unit,$data,$id_trx_nomor_em)&& $this->rsa_em_model->proses_trx_spp_spm($data_spp_spm) && $this->rsa_em_model->proses_data_spm($data_spm)){

                                        $data = array(
                                            'rel_kuitansi' => $rel_kuitansi,
                                            'str_nomor_trx_spm' => $nomor_trx,
                                        );

                                        $data_pengembalian = array(
                                                'rel_kuitansi_pengembalian' => $rel_kuitansi_pengembalian,
                                                'str_nomor_trx_spm' => $nomor_trx,
                                            );

                                        $this->kuitansi_model->insert_spm($data);

                                        $this->kuitansipengembalian_model->insert_spm($data_pengembalian);

                                        $this->rsa_em_model->proses_em_spm_rka($data);
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM EM anda berhasil disubmit.</div>');
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
                        redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }
                
                function proses_spp_em(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $jenis = $this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                        
                        $rel_kuitansi = array() ;
                        $rel_kuitansi_pengembalian = array() ;

                        if($this->input->post('rel_kuitansi')){
                            $rel_kuitansi_ = $this->input->post('rel_kuitansi');
                            $rel_kuitansi = urldecode($rel_kuitansi_);
                            if( base64_encode(base64_decode($rel_kuitansi, true)) === $rel_kuitansi){
                                $rel_kuitansi = base64_decode($rel_kuitansi);
                            }else{
                                redirect(site_url('/'));
                            }
                        }

                        if($this->input->post('rel_kuitansi_pengembalian')){
                            $rel_kuitansi_pengembalian_ = $this->input->post('rel_kuitansi_pengembalian');
                            $rel_kuitansi_pengembalian = urldecode($rel_kuitansi_pengembalian_);
                            if( base64_encode(base64_decode($rel_kuitansi_pengembalian, true)) === $rel_kuitansi_pengembalian){
                                $rel_kuitansi_pengembalian = base64_decode($rel_kuitansi_pengembalian);
                            }else{
                                redirect(site_url('/'));
                            }
                        }

                        $id_nomor_em = $this->input->post('id_nomor_em') ;
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                'id_trx_nomor_em' => $this->rsa_em_model->get_id_nomor_em_by_nomor_trx($nomor_trx),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );

                        // echo '<pre>';   
                        // var_dump($this->input->post());die;
                        
                        $ok = FALSE ;
                            
                        // $dokumen_em = $this->rsa_em_model->check_dokumen_em($kd_unit,$tahun);

                        $dokumen = $this->rsa_em_model->check_dokumen_em_by_str_trx($nomor_trx);
                        
                        if(($proses == 'SPP-FINAL')&&($dokumen == 'SPP-DRAFT')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPP-DITOLAK')&&($dokumen == 'SPP-DRAFT')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }

                        // echo $ok ; die ;
                        
                        if($ok){
//                            echo 'jos'; die;
                            if($this->rsa_em_model->proses_em($kd_unit,$data,$id_nomor_em)){

                                if($proses == 'SPP-DITOLAK'){ // APABILA PPK SUKPA MENOLAK SPP
                                    
                                    $data = array(
                                        'str_nomor_trx' => $nomor_trx,
                                        'rel_kuitansi' => $rel_kuitansi,
                                    );
                                    $this->rsa_em_model->tolak_em_spp_rka($data);
                                    $data = array(
                                        'rel_kuitansi' => $rel_kuitansi,
//                                        'str_nomor_trx' => $nomor_trx,
                                    );
                                    $data_pengembalian = array(
                                        'rel_kuitansi_pengembalian' => $rel_kuitansi_pengembalian,
//                                        'str_nomor_trx' => $nomor_trx,
                                    );
                                    // $this->load->model('kuitansi_model');
                                    $this->kuitansi_model->tolak_spp($data);

                                    $this->kuitansipengembalian_model->tolak_spp($data_pengembalian);
                                }
                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM EM anda berhasil disubmit.</div>');
                                echo "sukses";
                            }else{
                                echo "gagal";
                            }
                        }else{
                            echo "gagal";
                        }

                        
                        
                    }
                }
                
                function proses_spm_em(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $jenis = 'SPM';//$this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                        
                        $rel_kuitansi = array() ;
                        $rel_kuitansi_pengembalian = array() ;

                        if($this->input->post('rel_kuitansi')){
                            $rel_kuitansi_ = $this->input->post('rel_kuitansi');
                            $rel_kuitansi = urldecode($rel_kuitansi_);
                            if( base64_encode(base64_decode($rel_kuitansi, true)) === $rel_kuitansi){
                                $rel_kuitansi = base64_decode($rel_kuitansi);
                            }else{
                                redirect(site_url('/'));
                            }
                        }


                        if($this->input->post('rel_kuitansi_pengembalian')){
                            $rel_kuitansi_pengembalian_ = $this->input->post('rel_kuitansi_pengembalian');
                            $rel_kuitansi_pengembalian = urldecode($rel_kuitansi_pengembalian_);
                            if( base64_encode(base64_decode($rel_kuitansi_pengembalian, true)) === $rel_kuitansi_pengembalian){
                                $rel_kuitansi_pengembalian = base64_decode($rel_kuitansi_pengembalian);
                            }else{
                                redirect(site_url('/'));
                            }
                        }

                        $id_nomor_em = $this->input->post('id_nomor_em') ;
                        
                        // echo $this->rsa_em_model->get_id_nomor_em_by_nomor_trx($nomor_trx); die;
                            

                        $data = array(
                                    'kode_unit_subunit' => $kd_unit,
                                    'posisi' => $proses,
                                    'id_trx_nomor_em' => $id_nomor_em,
                                    'id_trx_nomor_em_spm' => $this->rsa_em_model->get_id_nomor_em_by_nomor_trx($nomor_trx),
                                    'ket' => $ket,
                                    'aktif' => '1',
                                    'tahun' => $tahun,
                                    'tgl_proses' => date("Y-m-d H:i:s"),
                                );
                            
                            // echo '<pre>'; var_dump($this->input->post()); die;
                            
                            $ok = FALSE ;
                            
                            $dokumen_em = $this->rsa_em_model->check_dokumen_em($kd_unit,$tahun,$id_nomor_em);

                            if(($proses == 'SPM-DRAFT-KPA')&&($dokumen_em == 'SPM-DRAFT-PPK')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-DITOLAK-KPA')&&($dokumen_em == 'SPM-DRAFT-PPK')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-FINAL-VERIFIKATOR')&&($dokumen_em == 'SPM-DRAFT-KPA')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-DITOLAK-VERIFIKATOR')&&($dokumen_em == 'SPM-DRAFT-KPA')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-FINAL-KBUU')&&($dokumen_em == 'SPM-FINAL-VERIFIKATOR')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-DITOLAK-KBUU')&&($dokumen_em == 'SPM-FINAL-VERIFIKATOR')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-FINAL-BUU')&&($dokumen_em == 'SPM-FINAL-KBUU')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-DITOLAK-BUU')&&($dokumen_em == 'SPM-FINAL-KBUU')){
                                $ok = TRUE ;
                            }else{
                                $ok = FALSE;
                            }
                            
                            
                            // echo '<pre>'; var_dump($this->input->post()) ; die;
                            
                            if($ok){
//                            echo 'jos';die;
                            $nomor_trx_spm = $this->rsa_em_model->get_id_nomor_em_by_nomor_trx($nomor_trx) ;

                            // echo $nomor_trx_spm; die;
                            
                            if($this->rsa_em_model->proses_em($kd_unit,$data,$id_nomor_em)){
                                if(substr($proses,0,11) == 'SPM-DITOLAK'){
                                    
                                    $data = array(
                                        'str_nomor_trx_spm' => $nomor_trx,
                                        'rel_kuitansi' => $rel_kuitansi,
                                    );
//                                    var_dump(base64_decode(urldecode($rel_kuitansi)));die;
                                    $this->rsa_em_model->tolak_em_spm_rka($data);

                                    $data = array(
                                        'rel_kuitansi' => $rel_kuitansi,
//                                        'str_nomor_trx' => $nomor_trx,
                                    );

                                    $data_pengembalian = array(
                                        'rel_kuitansi_pengembalian' => $rel_kuitansi_pengembalian,
//                                        'str_nomor_trx' => $nomor_trx,
                                    );
                                    // $this->load->model('kuitansi_model');
                                    $this->kuitansi_model->tolak_spm($data);

                                    $this->kuitansipengembalian_model->tolak_spm($data_pengembalian);
                                }
                                if($this->check_session->get_level() == 3){
                                    $verifikator = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
                                    $data_verifikator = array(
                                        'nomor_trx_spm' => $nomor_trx_spm,
                                        'str_nomor_trx_spm' => $nomor_trx,
                                        'kode_unit_subunit' => $kd_unit,
                                        'jenis_trx' => 'EM',
                                        'id_rsa_user_verifikator' => $verifikator->id,
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );
                                    if($this->rsa_em_model->proses_verifikator_em($data_verifikator)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM EM anda berhasil disubmit.</div>');
                                        echo "sukses";
                                    }else{
                                        echo "gagal";
                                    }
                                }else{
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM EM anda berhasil disubmit.</div>');
                                    echo "sukses";
                                }
                            }else{
                                echo "gagal";
                            }
                            
                        }

                        
                        
                    }
                }

                // function tes_(){

                //     $data_em_to_nihil = array(
                //                     'kode_unit_subunit' => '71',
                //                     'str_nomor_trx_spm_em' => '00003/LPM/SPM-TUP-NIHIL/JUN/2017',
                //                     'tgl_proses_em' => '2017-07-10 14:22:47',
                //                     'tahun' => '2017',
                //                     'status' => '1',
                //                 );

                //     // var_dump($data_em_to_nihil) ; die ;

                //     var_dump($this->rsa_em_model->tup_to_nihil($data_em_to_nihil)) ; die ;
                // }
                
                function proses_final_em(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx_spm = $this->input->post('nomor_trx');
                        $nomor_ = explode('/', $nomor_trx_spm);
                        $nomor = (int)$nomor_[0] ;
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->input->post('kd_unit');

                        
                        
                        $rel_kuitansi_ = $this->input->post('rel_kuitansi');
                        $rel_kuitansi = urldecode($rel_kuitansi_);
                        if( base64_encode(base64_decode($rel_kuitansi, true)) === $rel_kuitansi){
                            $rel_kuitansi = base64_decode($rel_kuitansi);
                        }else{
                            redirect(site_url('/'));
                        }

                        $rel_kuitansi_pengembalian_ = $this->input->post('rel_kuitansi_pengembalian');
                        $rel_kuitansi_pengembalian = urldecode($rel_kuitansi_pengembalian_);
                        if( base64_encode(base64_decode($rel_kuitansi_pengembalian, true)) === $rel_kuitansi_pengembalian){
                            $rel_kuitansi_pengembalian = base64_decode($rel_kuitansi_pengembalian);
                        }else{
                            redirect(site_url('/'));
                        }

                        // $id_trx_nomor_em = $this->rsa_em_model->get_id_nomor_em_by_nomor_trx($nomor_trx_spp) ;
                        $id_trx_nomor_em = $this->input->post('id_nomor_em') ;
                        $id_trx_nomor_em_spm = $this->rsa_em_model->get_id_nomor_em_by_nomor_trx($nomor_trx_spm) ;

                        $nomor_trx_spp = $this->rsa_em_model->get_spp_by_spm($nomor_trx_spm);

                        $tgl_proses = date("Y-m-d H:i:s");

                        $data = array(
                                    'kode_unit_subunit' => $kd_unit,
                                    'posisi' => $proses,
                                    'id_trx_nomor_em' => $id_trx_nomor_em,
                                    'id_trx_nomor_em_spm' => $id_trx_nomor_em_spm,
                                    'ket' => $ket,
                                    'aktif' => '1',
                                    'tahun' => $this->input->post('tahun'),
                                    'tgl_proses' => $tgl_proses,
                                );
                        
                        $ok = FALSE ;
                            
                        $dokumen_em = $this->rsa_em_model->check_dokumen_em_by_str_trx($nomor_trx_spp);

                        // echo '<pre>' ; var_dump($this->input->post()); die;
                        
                        if(($proses == 'SPM-FINAL-KBUU')&&($dokumen_em == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }

                        // echo '<pre>'; var_dump($this->input->post()); die;
                            
                        if($ok){
                            
//                            echo $proses;die;
//                            $this->load->model('kas_bendahara_model');
//                            $saldo_ben = $this->kas_bendahara_model->get_kas_bendahara($kd_unit,$this->input->post('tahun'));
//                            echo $saldo_ben->saldo;die;
                            
                            if($this->rsa_em_model->proses_em($kd_unit,$data,$id_trx_nomor_em)){
                                
                                // $this->load->model('kas_bendahara_model');
                                // $saldo_ben = $this->kas_bendahara_model->get_kas_bendahara_em($kd_unit,$this->input->post('tahun'));

                                // $data_kredit = array(
                                //     'tgl_trx' => date("Y-m-d H:i:s"),
                                //     'kd_akun_kas' => '112111',
                                //     'kd_unit' => $kd_unit,
                                //     'deskripsi' => 'KREDIT TUP UNIT ' . $kd_unit,//$this->input->post('deskripsi'),
                                //     'jenis' => 'TP',
                                //     'no_spm' => $this->input->post('nomor_trx'),
                                //     'kredit' => $this->input->post('kredit'),
                                //     'debet' => '0',
                                //     'saldo' => '0', // $saldo_ben->saldo - $this->input->post('kredit'), // DI '0' KAN KARENA AKAN DIKEMBALIKAN
                                //     'aktif' => '2',
                                //     'tahun' => $this->input->post('tahun'),
                                // );

                                // $pengembalian = $saldo_ben->saldo - $this->input->post('kredit') ; // PENGEMBALIAN KE AKUN UNDIP

                                // $pengembalian = $this->input->post('jumlah_pengembalian') ; // PENGEMBALIAN KE AKUN UNDIP

                                $this->load->model('kas_undip_model');

                                $kd_akun_kas = $this->input->post('kd_akun_kas') ;
                                $nominal = $this->input->post('nominal') ;
                                $saldo = $this->kas_undip_model->get_nominal($kd_akun_kas) - $nominal ;

                                $data_kas = array(
                                    'tgl_trx' => $tgl_proses,
                                    'kd_akun_kas' => $kd_akun_kas,
                                    'kd_unit' => $kd_unit,//'99',
                                    'deskripsi' => $this->input->post('deskripsi'),//'PEMBAYARAN EM UNIT ' . $kd_unit,
                                    'no_spm' => $this->input->post('nomor_trx'),
                                    'debet' => '0',
                                    'kredit' => $nominal,
                                    'saldo' => $saldo,
                                    'aktif' => '1',
                                    'tahun' => $this->input->post('tahun'),
                                );

                                $data_spm_cair = array(
                                    'no_urut' => $this->rsa_em_model->get_next_urut_spm_cair($this->input->post('tahun')),
//                                    'nomor_trx_spm' => $this->rsa_up_model->get_id_nomor_up('SPM',$kd_unit,$this->input->post('tahun')),//,$nomor,
                                    'str_nomor_trx_spm' => $nomor_trx_spm,
                                    'str_nomor_trx_spp' => $nomor_trx_spp,
                                    'kode_unit_subunit' => $kd_unit,
                                    'jenis_trx' => 'EM',
                                    'nominal' => $nominal,
                                    'tgl_proses' => $tgl_proses,
                                    'bulan' => $nomor_[3],
                                    'tahun' => $this->input->post('tahun')
                                );

    //                            var_dump($data_spm_cair);die;

                                // $data_em_to_nihil = array(
                                //     'kode_unit_subunit' => $kd_unit,
                                //     'str_nomor_trx_spm_em' => $nomor_trx_spm,
                                //     'tgl_proses_em' => date('Y-m-d H:i:s'),
                                //     'tahun' => $this->input->post('tahun'),
                                //     'status' => '0',
                                // );

                                if($this->kas_undip_model->isi_trx($data_kas) && $this->rsa_em_model->spm_cair($data_spm_cair)){
                                    
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
                                    
                                    // $this->rsa_em_model->final_em($kd_unit,$data_debet);
                                    
                                    $data = array(
                                        'rel_kuitansi' => $rel_kuitansi,
                                        'str_nomor_trx_spm' => $this->input->post('nomor_trx'),
                                        'tgl_proses' => $tgl_proses,
                                    );

                                    $data_pengembalian = array(
                                        'rel_kuitansi_pengembalian' => $rel_kuitansi_pengembalian,
                                        'str_nomor_trx_spm' => $this->input->post('nomor_trx'),
                                    );

                                    $this->kuitansi_model->set_cair($data);

                                    $this->kuitansipengembalian_model->set_cair($data_pengembalian);

                                    $this->rsa_em_model->proses_em_cair_rka($data);

                                            
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM EM anda berhasil disubmit.</div>');
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
                $kode_unit  = form_prep($this->input->post('kode_unit'));
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
                    $data['url']        = site_url('rsa_up/exec_delete/'.$this->uri->segment(3));
                    $data['message']    = "Apakah anda yakin akan menghapus data ini ( kode : ".$this->uri->segment(3).") ?";
                    $this->load->view('confirmation_',$data);
                }else{ //jika user pusat
                    $data['class']   = 'option box';
                    $data['class_btn']   = 'ya';
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
                    $data['class']   = 'option box';
                    $data['class_btn']   = 'ya';
                    $data['message'] = 'Data berhasil dihapus';
                }else{
                    $data['class']   = 'boxerror';
                    $data['class_btn']   = 'tidak';
                    $data['message'] = 'Data gagal dihapus';
                }
            }else{
                $data['class']   = 'boxerror';
                $data['class_btn']   = 'tidak';
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
                    
                    
        
                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['unit_usul']       = $this->rsa_up_model->get_up_unit($tahun);
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana']   = $this->option->sumber_dana();
                            $data['main_content']       = $this->load->view("rsa_up/saldo",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
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

                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
                            $subdata['daftar_spp']          = $this->rsa_em_model->get_daftar_spp($kode_unit_subunit,$tahun);
//                            echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;
                            
                            $subdata['jenis']           = 'em';

                            $data['main_content']           = $this->load->view("rsa_pengesahan/daftar_spp",$subdata,TRUE);
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
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14)||($this->check_session->get_level()==2))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
                            // $subdata['daftar_spm']          = $this->rsa_em_model->get_daftar_spm($kode_unit_subunit,$tahun);
                            $subdata['daftar_spp']          = $this->rsa_em_model->get_daftar_spp($kode_unit_subunit,$tahun);
                            $subdata['jenis']           = 'em';
                           // echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("rsa_pengesahan/daftar_spm",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
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
                            $subdata['jenis']           = 'em';
                            $subdata['kode_unit']           = $kode_unit_subunit;
                            // $subdata['daftar_spm']          = $this->rsa_em_model->get_daftar_spm($kode_unit_subunit,$tahun);
                            $subdata['daftar_spm']          = $this->rsa_em_model->get_daftar_spp($kode_unit_subunit,$tahun);
//                            echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("rsa_pengesahan/daftar_spm_kbuu",$subdata,TRUE);
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
                            $subdata['jenis']           = 'em';
                            $subdata['kode_unit']           = $kode_unit_subunit;
                            // $subdata['daftar_spm']          = $this->rsa_em_model->get_daftar_spm($kode_unit_subunit,$tahun);
                            $subdata['daftar_spm']          = $this->rsa_em_model->get_daftar_spp($kode_unit_subunit,$tahun);
                           // echo '<pre>';var_dump($subdata['daftar_spm']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("rsa_pengesahan/daftar_spm_verifikator",$subdata,TRUE);
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
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14)||($this->check_session->get_level()==2))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
                            $subdata['jenis']           = 'em';
                            // $subdata['daftar_spm']          = $this->rsa_em_model->get_daftar_spm($kode_unit_subunit,$tahun);
                            $subdata['daftar_spp']          = $this->rsa_em_model->get_daftar_spp($kode_unit_subunit,$tahun);
//                            echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("rsa_pengesahan/daftar_spm_kpa",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }

                function get_notif_approve(){

                    if($this->check_session->user_session()){

                        $level = $this->check_session->get_level() ;

                        $kode_unit_subunit = $this->check_session->get_unit();

                        $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());

                        $notif = $this->rsa_em_model->get_notif_approve($kode_unit_subunit,$level,$user->id);

                        echo $notif ;
                    }

                }

                function get_notif_approve_all(){

                    if($this->check_session->user_session()){

                        $level = $this->check_session->get_level() ;

                        $kode_unit_subunit = $this->check_session->get_unit();

                        $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());

                        $notif_em = $this->rsa_em_model->get_notif_approve($kode_unit_subunit,$level,$user->id);

                        echo $notif_em ;
                    }

                }

                function get_data_untuk_pekerjaan(){
                    $q = $this->input->get('query');
                    $d = array('untuk_bayar'=>$q);
                    $kode_unit_subunit = $this->check_session->get_unit();
                    $data = $this->rsa_em_model->get_data_untuk_pekerjaan($d['untuk_bayar'],$kode_unit_subunit,$this->cur_tahun);
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
                    $data = $this->rsa_em_model->get_data_penerima($q,$kode_unit_subunit,$this->cur_tahun);
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

                function get_data_json(){
                    $q = $this->input->get('query');
                    $d = array('penerima'=>$q);
                    $kode_unit_subunit = $this->check_session->get_unit();
                    $data = $this->rsa_em_model->get_data_json($d,$kode_unit_subunit,$this->cur_tahun);
                    $json = [];
                    
                    if(!empty($data)){

                        foreach($data as $d){
                            $json[] = $d->penerima ;
                        }
                    }

                    echo json_encode($json);
                }
                
        
    }

?>
