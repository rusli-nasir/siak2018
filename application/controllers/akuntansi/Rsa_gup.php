<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class rsa_gup extends MY_Controller{
    private $cur_tahun;
    public function __construct(){ 
        // $this->cek_session_in();
        parent::__construct();
            //load library, helper, and model
        $this->cur_tahun = $this->setting_model->get_tahun();
        $this->load->library(array('form_validation','option','Url_encoder','shorturl'));
        $this->load->helper('form');
        $this->load->model(array('setting_up_model','kuitansi_model','kuitansipengembalian_model','rsa_gup_model'));
        $this->load->model("user_model");
                    $this->load->model("unit_model");
                    $this->load->model('menu_model');
        $this->load->helper("security");
    }
    
    function index(){
        $this->data['tab'] = 'rsa_gup';
        $this->data['content'] = $this->load->view('akuntansi/rsa_gup_detail',$this->data,true);
        $this->load->view('akuntansi/content_template',$this->data,false);
    }
    
    function get_data_kuitansi(){
        $this->load->model('kuitansi_model');
        $id = $this->input->post('id');
        $cur_tahun = $this->input->post('t');
        if($id){
            $data_kuitansi = $this->kuitansi_model->get_data_kuitansi($id,$cur_tahun);
            $data_detail_kuintansi = $this->kuitansi_model->get_data_detail_kuitansi($id,$cur_tahun);
            $data_detail_pajak_kuintansi = $this->kuitansi_model->get_data_detail_pajak_kuitansi($id,$cur_tahun);
            echo json_encode(array(
                'kuitansi' => $data_kuitansi,
                'kuitansi_detail' => $data_detail_kuintansi,
                'kuitansi_detail_pajak' => $data_detail_pajak_kuintansi
                    )
                );
        }
    }
    
    function jurnal($id_kw = null){
        $this->data['id_kw'] = $id_kw;
        $no_spm = urldecode($this->input->get('spm'));
        // echo $no_spm;die();
        $this->load->model('akuntansi/rsa_gup2_model');
        $_spm = $this->rsa_gup2_model->get_spm_detail($no_spm, array('tahun', 'kode_unit', 'str_nomor_trx'));
        
        if(!$_spm){
            $this->data['tab'] = 'rsa_gup';
            $this->data['content'] = "<h1>Jurnal tidak ditemukan</h1>";
            $this->load->view('akuntansi/content_template',$this->data);
            return;
        }
        
        $kd_unit = $_spm->kode_unit;
        if(strlen($kd_unit)>4){$kd_unit = substr($kd_unit, 0, 4);}
        $tahun = $_spm->tahun;
                                
        $this->load->model('unit_model');
        $this->load->model('rsa_gup_model');
        $this->load->model('kuitansi_model');
        $this->data['cur_tahun'] = $tahun;
        if(strlen($kd_unit)==2){
            $this->data['unit_kerja'] = $this->unit_model->get_nama($kd_unit);
            $this->data['unit_id'] = $kd_unit ;
            $this->data['kd_unit'] = $kd_unit ;
            $this->data['alias'] = $this->unit_model->get_alias($kd_unit);
        }
        elseif(strlen($kd_unit)==4){
                $this->data['unit_kerja'] = $this->unit_model->get_nama($kd_unit) . ' - ' . $this->unit_model->get_real_nama($kd_unit);
                $this->data['unit_id'] = $kd_unit;
                $this->data['kd_unit'] = $kd_unit ;
                $this->data['alias'] = $this->unit_model->get_alias($kd_unit);
        }
                                
        $dokumen_gup = $this->rsa_gup_model->check_dokumen_gup($kd_unit,$tahun);
        if ($dokumen_gup == null) {
            $kd_unit = substr($kd_unit,0,2);
            $dokumen_gup = $this->rsa_gup_model->check_dokumen_gup($kd_unit,$tahun);
        }

        $this->data['doc_up'] = $dokumen_gup;

        $nomor_trx_spp =  $_spm->str_nomor_trx;
//        $nomor_trx_spp = $this->rsa_gup_model->get_nomor_spp($kd_unit,$tahun); 
                                
                                
        $this->data_spp = (object)array(
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

        if(($dokumen_gup == 'SPP-FINAL') || ($dokumen_gup == 'SPP-DRAFT') || ($dokumen_gup == 'SPM-DRAFT-PPK') || ($dokumen_gup == 'SPM-DRAFT-KPA') || ($dokumen_gup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_gup == 'SPM-FINAL-KBUU')){

            $this->data_spp = $this->rsa_gup_model->get_data_spp($nomor_trx_spp);

            $this->data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
            $kuitansi_d = array();
            if(!empty($this->data_kuitansi)){
                foreach($this->data_kuitansi as $dk){
                    $kuitansi_d[] = $dk->id_kuitansi;
                }
            }
            $du_ = json_encode($kuitansi_d);
            $this->data_url = urlencode(base64_encode($du_));
            $du = $this->data_url ;
            $this->data_url = urldecode($this->data_url);
            // echo base64_encode(base64_decode($this->data_url, true));
            // print_r($this->data_url);
            // die();
            if( base64_encode(base64_decode($this->data_url, true)) === $this->data_url){
                //$array_id = base64_decode($this->data_url) ;
                $array_id = $this->data_spp->data_kuitansi;
                $this->data_ = array(
                    'kode_unit_subunit' => $kd_unit,
                    'array_id' => json_decode($array_id),
                    'tahun' => $this->data['cur_tahun'],
                );
                
                $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($this->data_);
            }else{
                $pengeluaran = 0;
            }

            $this->data['detail_gup']   = array(
                                            'nom' => $this->data_spp->jumlah_bayar,
                                            'terbilang' => $this->data_spp->terbilang, 

                                        );

            $this->data['detail_pic']  = (object) array(
                'untuk_bayar' => $this->data_spp->untuk_bayar,
                'penerima' => $this->data_spp->penerima,
                'alamat_penerima' => $this->data_spp->alamat,
                'nama_bank_penerima' => $this->data_spp->nmbank,
                'no_rek_penerima' => $this->data_spp->rekening,
                'npwp_penerima' => $this->data_spp->npwp,
                'nmbendahara' => $this->data_spp->nmbendahara,
                'nipbendahara' => $this->data_spp->nipbendahara,


            );


            $this->data['tgl_spp'] = $this->data_spp->tgl_spp;

            $this->data['cur_tahun_spp'] = $this->data_spp->tahun;
            setlocale(LC_ALL, 'id_ID.utf8');$this->data['bulan'] = strftime("%B", strtotime($this->data_spp->tgl_spp)); 


        }else{

           $this->data['cur_tahun_spp'] = '';

        }



        //$nomor_trx_spm = '';

        if(($dokumen_gup == 'SPM-DRAFT-PPK') || ($dokumen_gup == 'SPM-DRAFT-KPA') || ($dokumen_gup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_gup == 'SPM-FINAL-KBUU')){

            //$nomor_trx_spm = $this->rsa_gup_model->get_nomor_spm($kd_unit,$tahun);  
            $nomor_trx_spm = $no_spm;  

            $this->data_spm = $this->rsa_gup_model->get_data_spm($nomor_trx_spm);
            $this->data['detail_gup_spm']   = array(
                                            'nom' => $this->data_spm->jumlah_bayar,
                                            'terbilang' => $this->data_spm->terbilang, 

                                        );

            $this->data['detail_ppk']  = (object)array(
                'nm_lengkap' => $this->data_spm->nmppk,
                'nomor_induk' => $this->data_spm->nipppk
            );
            $this->data['detail_kpa']  = (object)array(
                'nm_lengkap' => $this->data_spm->nmkpa,
                'nomor_induk' => $this->data_spm->nipkpa
            );
            $this->data['detail_verifikator']  = (object)array(
                'nm_lengkap' => $this->data_spm->nmverifikator,
                'nomor_induk' => $this->data_spm->nipverifikator
            );
            $this->data['detail_kuasa_buu']  = (object)array(
                'nm_lengkap' => $this->data_spm->nmkbuu,
                'nomor_induk' => $this->data_spm->nipkbuu
            );
            $this->data['detail_buu']  = (object)array(
                'nm_lengkap' => $this->data_spm->nmbuu,
                'nomor_induk' => $this->data_spm->nipbuu
            );

            $this->data['detail_pic_spm']  = (object) array(
                'untuk_bayar' => $this->data_spm->untuk_bayar,
                'penerima' => $this->data_spm->penerima,
                'alamat_penerima' => $this->data_spm->alamat,
                'nama_bank_penerima' => $this->data_spm->nmbank,
                'no_rek_penerima' => $this->data_spm->rekening,
                'npwp_penerima' => $this->data_spm->npwp,

    //                                        'tgl_spp' => $this->data_spp->tgl_spp,

            );

            $this->data['tgl_spm'] = $this->data_spm->tgl_spm;

            $this->data['cur_tahun_spm'] = $this->data_spm->tahun;

        }else{

            $this->data['cur_tahun_spm'] = '';
            $this->data['tgl_spm'] = '' ;
        }

        $this->data_akun_pengeluaran = array();
        $this->data_spp_pajak = array();
        $this->data_akun_rkat = array();
        $this->data_akun_pengeluaran_lalu = array();
        $rincian_akun_pengeluaran = array();
        $rincian_keluaran = array();
        $daftar_kuitansi = array();


        if($pengeluaran > 0){
            $this->data__ = array(
                'kode_unit_subunit' => $kd_unit,
                'tahun' => $tahun,
                'array_id' => json_decode($array_id)
            );
            $this->data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($this->data__);


            $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($this->data__);
            $this->data_spp_pajak = $this->kuitansi_model->get_spp_pajak($this->data__);
            $this->data_akun5digit = array();
            foreach($this->data_akun_pengeluaran as $da){
                $this->data_akun5digit[] =  $da->kode_akun5digit ;
            }

            $this->data___ = array(
                'kode_unit_subunit' => $kd_unit,
                'tahun' => $tahun,
                'kode_akun5digit' => $this->data_akun5digit
            );


            $this->data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($this->data___);

            $nomor_spm = $this->rsa_gup_model->get_spm_by_spp($nomor_trx_spp);



            if(empty($nomor_spm)){

                $this->data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($kd_unit,$tahun);


            }else{

                $nomor_spm_cair_before = $this->rsa_gup_model->get_nomer_spm_cair_lalu($kd_unit,$tahun);



                $this->data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_spm($nomor_spm);

                if($nomor_spm_cair_before != $nomor_spm){
                     $this->data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($kd_unit,$tahun);
                }
            }




                $this->data_akun5digit_before = array();

                if(!empty($this->data_akun_before)){
                    foreach($this->data_akun_before as $dk){
                        $this->data_akun5digit_before[] =  $dk->kode_akun5digit ;
                    }

                    $this->data___lalu = array(
                        'kode_unit_subunit' => $kd_unit,
                        'tahun' => $tahun,
                        'kode_akun5digit' => $this->data_akun5digit_before
                    );


                    $this->data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($this->data___lalu);

                }
            $rincian_keluaran = $this->rsa_gup_model->get_keluaran($nomor_trx_spp);

            $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
        }


        $this->data['data_akun_pengeluaran'] = $this->data_akun_pengeluaran;
        $this->data['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
        $this->data['data_akun_rkat'] = $this->data_akun_rkat;
        $this->data['data_akun_pengeluaran_lalu'] = $this->data_akun_pengeluaran_lalu;
        $this->data['data_spp_pajak'] = $this->data_spp_pajak;
        $this->data['rincian_keluaran'] = $rincian_keluaran;
        $this->data['rel_kuitansi'] = $du;
        $this->data['daftar_kuitansi'] = $daftar_kuitansi;
        $this->data['nomor_spp'] = $nomor_trx_spp;

        $this->data['nomor_spm'] = $nomor_trx_spm;


        $this->data['tgl_spm_kpa'] = $this->rsa_gup_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);

        $this->data['tgl_spm_verifikator'] = $this->rsa_gup_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);

        $this->data['tgl_spm_kbuu'] = $this->rsa_gup_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);

        $this->data['ket'] = $this->rsa_gup_model->lihat_ket($kd_unit,$tahun);

        $this->load->model('akun_kas6_model');

        $this->data['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();
                //$this->data['main_content']           = $this->load->view("rsa_gup/spm_gup_kbuu",$this->data,TRUE);
                //$this->load->view('main_template',$this->data);
            
        $this->data['tab'] = 'rsa_gup';
        $this->data['content'] = $this->load->view('akuntansi/rsa_gup_detail',$this->data,true);
        $this->load->view('akuntansi/content_template',$this->data);
    }

     function spm_gup_lihat($url){


            if(1){



                $url = urldecode($url);

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

                                $nomor_trx_spm = $url ;
                                
                                
                                $dokumen_gup = $this->rsa_gup_model->check_dokumen_gup_by_str_trx($url);

                                // echo $dokumen_gup ; die;
                              
                                $subdata['doc_up'] = $dokumen_gup;
                                
//                                $subdata['tgl_spm'] = $this->rsa_gup_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_gup_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spp = $this->rsa_gup_model->get_spp_by_spm($nomor_trx_spm);

                                // echo $nomor_trx_spp ; die;
                                
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
                                
                                if(($dokumen_gup == 'SPP-FINAL') || ($dokumen_gup == 'SPP-DRAFT') || ($dokumen_gup == 'SPM-DRAFT-PPK') || ($dokumen_gup == 'SPM-DRAFT-KPA') || ($dokumen_gup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_gup == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_gup_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
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
                                    $subdata['detail_gup']   = array(
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

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                if(($dokumen_gup == 'SPM-DRAFT-PPK') || ($dokumen_gup == 'SPM-DRAFT-KPA') || ($dokumen_gup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_gup == 'SPM-FINAL-KBUU')){
                                    
                                    // $nomor_trx_spm = $this->rsa_gup_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                    
                                    $data_spm = $this->rsa_gup_model->get_data_spm($nomor_trx_spm);
                                    // var_dump($data_spm);die;
                                    $subdata['detail_gup_spm']  = array(
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
                                    // var_dump($subdata);die;
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
                                    
                                    // $nomor_trx_ = $this->rsa_gup_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    // setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    // $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-GUP'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    

                                    // $subdata['detail_gup_spm']  = array(
                                    //                                 'nom' => $data_spp->jumlah_bayar,
                                    //                                 'terbilang' => $data_spp->terbilang, 

                                    //                             );
                                    
                                    // $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                    // $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
                                    // $subdata['detail_verifikator']  = $this->rsa_gup_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
                                    // $subdata['detail_kuasa_buu']  = $this->user_model->get_detail_rsa_user('99','11');
                                    // $subdata['detail_buu']  = $this->user_model->get_detail_rsa_user('99','5');
                                    
                                    // $subdata['detail_spm_pic']  = (object) array(
                                    //     'untuk_bayar' => $data_spp->untuk_bayar,
                                    //     'penerima' => $data_spp->penerima,
                                    //     'alamat_penerima' => $data_spp->alamat,
                                    //     'nama_bank_penerima' => $data_spp->nmbank,
                                    //     'no_rek_penerima' => $data_spp->rekening,
                                    //     'npwp_penerima' => $data_spp->npwp,
                                        
                                    // );

                                    // $subdata['cur_tahun_spm'] = $this->cur_tahun;
                                    // $subdata['tgl_spm'] = '';
                                    
                                }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                $daftar_kuitansi = array();
                            
                                
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__);

                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);
                                   // echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__);
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
                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $nomor_spm = $this->rsa_gup_model->get_spm_by_spp($nomor_trx_spp);
                                    
//                                    echo $nomor_spm_cair_before; die;
                                    
                                    if(empty($nomor_spm)){
                                        
                                        $data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                        var_dump($data_akun_before); die;
                                        
                                    }else{

                                        
                                        $data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_spm($nomor_spm);

                                    }

                                        $data_akun5digit_before = array();

    //                                    if(!empty($data_akun_pengeluaran)){

                                        if(!empty($data_akun_before)){
                                            foreach($data_akun_before as $dk){
                                                $data_akun5digit_before[] =  $dk->kode_akun5digit ;
                                            }
                                            
                                            $data___lalu = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'tahun' => $this->cur_tahun,
                                                'kode_akun5digit' => $data_akun5digit_before
                                            );

        //                                    echo '<pre>';print_r($data___lalu);echo '</pre>';die;

                                            $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___lalu);
                                        
                                        }

                                    $rincian_keluaran = $this->rsa_gup_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
                                }


                                
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['detail_verifikator']  = $this->rsa_gup_model->get_verifikator_by_spm($nomor_trx_spm);

                                // var_dump($subdata['detail_verifikator']) ; die;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_gup_model->get_tgl_spm_kpa_by_spm($nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_gup_model->get_tgl_spm_verifikator_by_spm($nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_gup_model->get_tgl_spm_kbuu_by_spm($nomor_trx_spm);

                                $subdata['ket'] = $this->rsa_gup_model->lihat_ket_by_str_trx($nomor_trx_spm);

                                // var_dump($subdata) ; die;
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                // $data['main_content']           = $this->load->view("rsa_gup/spm_gup_lihat",$subdata,TRUE);
                // $this->load->view('main_template',$data);
                $data['main_content']           = $this->load->view("akuntansi/spm_gup_lihat",$subdata,TRUE);
                $data['content'] = '';
                $this->load->view('akuntansi/content_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
        }
    

    function spm_gup_lihat_99($url,$kd_unit,$tahun){


                    if(1){

                            $url = urldecode($url);

                            $url = base64_decode($url);



                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE); 

                                $subdata['cur_tahun'] = $tahun;


                                if(strlen($kd_unit)==2){
                                    $subdata['unit_kerja'] = $this->unit_model->get_nama_unit($kd_unit); // $this->check_session->get_nama_unit();
                                    $subdata['unit_id'] = $kd_unit; //$this->check_session->get_unit();
                                    $subdata['alias'] = $this->unit_model->get_alias($kd_unit); // $this->check_session->get_alias();
                                }
                                elseif(strlen($kd_unit)==4){
                                        $subdata['unit_kerja'] = $this->unit_model->get_nama($kd_unit) . ' - ' . $this->unit_model->get_real_nama($kd_unit);//$this->check_session->get_nama_unit();
                                        $subdata['unit_id'] = $kd_unit; //$this->check_session->get_unit();
                                        $subdata['alias'] = $this->unit_model->get_alias($kd_unit);
                                }
//                                $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');

                                $nomor_trx_spm = $url ;
                                
                                
                                $dokumen_gup = $this->rsa_gup_model->check_dokumen_gup_by_str_trx($url);

                                // echo $dokumen_gup ; die;
                              
                                $subdata['doc_up'] = $dokumen_gup;
                                
//                                $subdata['tgl_spm'] = $this->rsa_gup_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_gup_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spp = $this->rsa_gup_model->get_spp_by_spm($nomor_trx_spm);

                                // echo $nomor_trx_spp ; die;
                                
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
                                
                                if(($dokumen_gup == 'SPP-FINAL') || ($dokumen_gup == 'SPP-DRAFT') || ($dokumen_gup == 'SPM-DRAFT-PPK') || ($dokumen_gup == 'SPM-DRAFT-KPA') || ($dokumen_gup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_gup == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_gup_model->get_data_spp($nomor_trx_spp);
                                   // var_dump($data_spp);die;
                                    
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
                                    // var_dump($data_kuitansi);die;
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
                                           // echo $array_id ; die ;
                                            $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                            $data_ = array(
                                                'kode_unit_subunit' => $kd_unit, // $this->check_session->get_unit(),
                                                'array_id' => json_decode($array_id),
                                                'tahun' => $tahun,
                                            );

                                            $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                            // echo $pengeluaran ; die ;
                                        }else{
                                            $pengeluaran = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }

                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
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
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }

                                        // echo $pengembalian; die;

                                    $subdata['detail_gup']   = array(
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

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
                                    $subdata['cur_tahun_spp'] = $data_spp->tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 

                                
                                }else{
                                    
                                   $subdata['cur_tahun_spp'] = '';
                                    
                                }
                                
                                if(($dokumen_gup == 'SPM-DRAFT-PPK') || ($dokumen_gup == 'SPM-DRAFT-KPA') || ($dokumen_gup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_gup == 'SPM-FINAL-KBUU')){
                                    
                                    // $nomor_trx_spm = $this->rsa_gup_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                    
                                    $data_spm = $this->rsa_gup_model->get_data_spm($nomor_trx_spm);
                                    // var_dump($data_spm);die;
                                    $subdata['detail_gup_spm']  = array(
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
                                    // var_dump($subdata);die;
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
                                                                    
                                }
                                
                                $data_akun_pengeluaran = array();
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                $daftar_kuitansi = array();
                                
//                                if($pengeluaran > 0){
//                                    $data__ = array(
//                                        'kode_unit_subunit' => $this->check_session->get_unit(),
//                                        'tahun' => $this->cur_tahun,
//                                        'array_id' => json_decode($array_id)
//                                    );
////                                    print_r($data__);die;
//                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__);
////                                    $data_array_id = json_decode($array_id);
////                                    if(count($data_array_id) > 1){
////                                        foreach($data_array_id as $id){
//////                                            $str_ .= "rsa.rsa_kuitansi.id_kuitansi = '{$id}' OR " ;
////                                            $rincian_akun_pengeluaran[] = $this->kuitansi_model->get_rekap_detail_kuitansi($id,$this->cur_tahun);
////                                        }
//////                                        $str_ = substr($str_,0,  strlen($str_) - 3 );
////                                    }else{
////                                        $rincian_akun_pengeluaran[] = $this->kuitansi_model->get_rekap_detail_kuitansi($data_array_id[0],$this->cur_tahun);
//////                                        $str_ = "rsa.rsa_kuitansi.id_kuitansi = '{$data['array_id'][0]}'" ;
////                                    }
//                                    
////                                    function get_data_detail_kuitansi($id_kuitansi,$tahun){
////                                    $rincian_akun_pengeluaran = 
//                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);
////                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
//                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__);
//                                    $data_akun5digit = array();
////                                    if(!empty($data_akun_pengeluaran)){
//                                    foreach($data_akun_pengeluaran as $da){
//                                        $data_akun5digit[] =  $da->kode_akun5digit ;
//                                    }
////                                    
////                                    echo '<pre>';print_r($data___);echo '</pre>';die;
//                                    
//                                    $data___ = array(
//                                        'kode_unit_subunit' => $this->check_session->get_unit(),
//                                        'tahun' => $this->cur_tahun,
//                                        'kode_akun5digit' => $data_akun5digit
//                                    );
////                                    echo '<pre>';print_r($data___);echo '</pre>';die;
//                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
//                                    
//                                    $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___);
////                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
////                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
////                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
////                                    var_dump($data_spp_pajak);die;
//                                    $rincian_keluaran = $this->rsa_gup_model->get_keluaran($nomor_trx_spp);
//                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
//                                }
                                
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,//$this->check_session->get_unit(),
                                        'tahun' => $tahun,//$this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__);
                                   // var_dump($data_akun_pengeluaran);die;
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
                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);
                                   // echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__);

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
                                        'kode_unit_subunit' => $kd_unit,//$this->check_session->get_unit(),
                                        'tahun' => $tahun,//$this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
//                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
//                                    
//                                    $nomor_spm_cair_lalu = $this->rsa_gup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
//                                    
//                                    $nomor_spp_cair_lalu = $this->rsa_gup_model->get_spp_by_spm($nomor_spm_cair_lalu);
//                                    
//                                    echo $nomor_spm_cair_lalu; die;
                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $nomor_spm = $this->rsa_gup_model->get_spm_by_spp($nomor_trx_spp);
                                    
//                                    echo $nomor_spm_cair_before; die;
                                    
                                    if(empty($nomor_spm)){

                                        // BELUM SPM DAN SPP AKTIF
                                        
                                        $data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($kd_unit,$tahun);//$this->check_session->get_unit(),$this->cur_tahun);
                                    
                                       // var_dump($data_akun_before); die;
                                        
                                    }else{

                                        // SUDAH SPM DAN SPP TIDAK AKTIF

                                        $nomor_spm_cair_before = $this->rsa_gup_model->get_nomer_spm_cair_lalu($kd_unit,$tahun);//$this->check_session->get_unit(),$this->cur_tahun);

                                        // echo $nomor_spm_cair_before ; die;
                                        
                                        $data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_spm($nomor_spm);

                                        if($nomor_spm_cair_before != $nomor_spm){
                                             $data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($kd_unit,$tahun);//$this->check_session->get_unit(),$this->cur_tahun);
                                        }

                                        // echo $nomor_spm; die;
                                    
                                       // var_dump($data_akun_before); die;
                                    }
                                    
                                    
//                                    
//                                    $nomor_spm_cair_before = $this->rsa_gup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                    if($nomor_spp_cair_lalu != $nomor_trx){
//                                        $data_akun_lalu = $this->kuitansi_model->get_gup_akun_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
    //                                    echo '<pre>';print_r($data_akun_lalu);echo '</pre>';die;

                                        $data_akun5digit_before = array();

    //                                    if(!empty($data_akun_pengeluaran)){

                                        if(!empty($data_akun_before)){
                                            foreach($data_akun_before as $dk){
                                                $data_akun5digit_before[] =  $dk->kode_akun5digit ;
                                            }
                                            
                                            $data___lalu = array(
                                                'kode_unit_subunit' => $kd_unit,//$this->check_session->get_unit(),
                                                'tahun' => $tahun,//$this->cur_tahun,
                                                'kode_akun5digit' => $data_akun5digit_before
                                            );

        //                                    echo '<pre>';print_r($data___lalu);echo '</pre>';die;

                                            $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___lalu);
                                        
                                        }
                                        
                                        
//                                    }
                                    
                                    
                                    
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
//                                    $rincian_keluaran = $this->rsa_gup_model->get_keluaran($nomor_trx);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                    $rincian_keluaran = $this->rsa_gup_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
                                }

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
                                $subdata['rel_kuitansi'] = $du_p;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['daftar_kuitansi_pengembalian'] = $daftar_kuitansi_pengembalian;
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                //$subdata['tgl_spm_kpa'] = $this->rsa_gup_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_kpa'] = $this->rsa_gup_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);
                                
                                //$subdata['tgl_spm_verifikator'] = $this->rsa_gup_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_verifikator'] = $this->rsa_gup_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                //$subdata['tgl_spm_kbuu'] = $this->rsa_gup_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_kbuu'] = $this->rsa_gup_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);
                                
                                // $subdata['ket'] = $this->rsa_gup_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);

                                $subdata['ket'] = $this->rsa_gup_model->lihat_ket_by_str_trx($nomor_trx_spm);//$kd_unit,$tahun);

                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                                // echo '<pre>' ;
                                // var_dump($data) ; 
                                // echo '</pre>' ; 
                                // die ;
                $data['main_content'] = $this->load->view("akuntansi/spm_gup_lihat",$subdata,TRUE);
                $data['content'] = '';
                $data['bukti'] = true;
                $this->load->view('akuntansi/content_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
        }

    function getMonth($date){
        $exp=explode(" ",$date);
        $exl=explode("-",$exp[0]);
        return $exl[1];
    }
    
    function wordMonthShort($nilai){
        switch(intval($nilai)){
            case 1 : return "Jan";break;
            case 2 : return "Feb";break;
            case 3 : return "Mar";break;
            case 4 : return "Apr";break;
            case 5 : return "Mei";break;
            case 6 : return "Jun";break;
            case 7 : return "Jul";break;
            case 8 : return "Agu";break;
            case 9 : return "Sep";break;
            case 10 : return "Okt";break;
            case 11 : return "Nov";break;
            case 12 : return "Des";break;
        }
    }
    
    function spmls($garbage, $id){
        $this->load->model("user_model");
        $this->load->model("cantik_model");
        $d['id'] = $id;
        $sql = "SELECT a.*, b.untuk_bayar, b.penerima, b.alamat, b.nama_bank, b.rekening, b.npwp FROM kepeg_tr_spmls a LEFT JOIN kepeg_tr_sppls b ON b.id_sppls = a.id_tr_sppls WHERE id_spmls =".intval($d['id']);
        // echo $sql; exit;
        $sub = $this->db->query($sql)->result();
        $akun = explode(",",$sub[0]->detail_belanja);
        $sql = "SELECT * FROM rsa_detail_belanja_ WHERE id_rsa_detail!=0 AND";
        $i=0;
        foreach ($akun as $k => $v) {
            $vSQL2[$i]="kode_usulan_belanja LIKE '".substr($v, 0, -3)."' AND kode_akun_tambah LIKE '".substr($v, -3)."'";
            $i++;
        }
        $vSQL2 = implode(" OR ", $vSQL2);
        $sql = $sql."(".$vSQL2.") ORDER BY kode_akun_tambah ASC";
        $akun = $this->db->query($sql)->result();
        $subdata['cur_tahun'] = $sub[0]->tahun;
        $subdata['cur_bulan'] = $this->wordMonthShort($this->getMonth($sub['0']->tanggal));
        $subdata['tgl_spp'] = $sub[0]->tanggal;
        $subdata['unit_kerja'] = $sub[0]->namaunitsukpa;
        // $subdata['unit_id'] = $this->check_session->get_unit();
        $subdata['alias'] = "WR2";
        $subdata['detail_up'] = $sub[0];
        $subdata['akun_detail'] = $akun;
        $jm = strlen($sub[0]->id_spmls);
        $subdata['id_spmls'] = "";
        for($i=0;$i<(5-$jm);$i++){
            $subdata['id_spmls'] .= "0";
        }
        $subdata['id_spmls'] .= $sub[0]->id_spmls;
        // $subdata['bpp'] = $this->user_model->get_detail_rsa_user($sub[0]->unitsukpa, '13');
        // $subdata['ppk'] = $this->user_model->get_detail_rsa_user($sub[0]->unitsukpa, '14');
        $subdata['kpa'] = $this->user_model->get_detail_rsa_user($sub[0]->unitsukpa, '2');
        $subdata['buu'] = $this->user_model->get_detail_rsa_user('99', '5');
        $subdata['kbuu'] = $this->user_model->get_detail_rsa_user('99', '11');
//        if(intval($_SESSION['rsa_level'])==3){
//          $subdata['bver'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
//        }
        return $this->load->view("akuntansi/form-spmls",$subdata,TRUE);
    }
    
    function sppls($garbage, $id){
        $this->load->model("user_model");
        $this->load->model("cantik_model");
        $d['id'] = $id;
        $sql = "SELECT * FROM kepeg_tr_sppls WHERE id_sppls =".$d['id'];
        $sub = $this->db->query($sql)->result();
        $akun = explode(",",$sub[0]->detail_belanja);
        $sql = "SELECT * FROM rsa_detail_belanja_ WHERE id_rsa_detail!=0 AND";
        $i=0;
        foreach ($akun as $k => $v) {
            $vSQL2[$i]="kode_usulan_belanja LIKE '".substr($v, 0, -3)."' AND kode_akun_tambah LIKE '".substr($v, -3)."'";
            $i++;
        }
        $vSQL2 = implode(" OR ", $vSQL2);
        $sql = $sql."(".$vSQL2.") ORDER BY kode_akun_tambah ASC";
        $akun = $this->db->query($sql)->result();
        $subdata['cur_tahun'] = $sub[0]->tahun;
        $subdata['cur_bulan'] = $this->wordMonthShort($this->getMonth($sub['0']->tanggal));
        $subdata['tgl_spp'] = $sub[0]->tanggal;
        $subdata['unit_kerja'] = $this->session->userdata('username');
        $subdata['unit_id'] = $this->session->userdata('kode_unit');
        $subdata['alias'] = $this->session->userdata('alias');
        $subdata['detail_up'] = $sub[0];
        $subdata['akun_detail'] = $akun;
        $jm = strlen($sub[0]->id_sppls);
        $subdata['id_sppls'] = "";
        for($i=0;$i<(5-$jm);$i++){
            $subdata['id_sppls'] .= "0";
        }
//                $subdata['detail_pic'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
        $subdata['id_sppls'] .= $sub[0]->id_sppls;
        return $this->load->view("akuntansi/form-sppls",$subdata,TRUE);
    }
    
    function lspg($garbage, $id){
        $this->load->helper('lspg');
        
        $sql = "SELECT id_tr_sppls FROM kepeg_tr_spmls WHERE id_spmls =".$id;
        $nomor_sppls = $this->db->query($sql)->row()->id_tr_sppls;
        
        
        $subdata['spm'] = $this->spmls($garbage, $id);
        $subdata['spp'] = $this->sppls($garbage, $nomor_sppls);
        
        $this->data['content'] = $this->load->view("akuntansi/bukti_lspg",$subdata,TRUE);
        $this->load->view('akuntansi/content_template',$this->data);
    }
    
    function up($kd_unit,$tahun){
        $this->load->model('rsa_up_model');		
                                
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
                                

        $dokumen_up = $this->rsa_up_model->check_dokumen_up($kd_unit,$tahun);

        $subdata['doc_up'] = $dokumen_up;

        $nomor_trx_spp = $this->rsa_up_model->get_nomor_spp($kd_unit,$tahun); 


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

        if(($dokumen_up == 'SPP-FINAL') || ($dokumen_up == 'SPP-DRAFT') || ($dokumen_up == 'SPM-DRAFT-PPK') || ($dokumen_up == 'SPM-DRAFT-KPA') || ($dokumen_up == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_up == 'SPM-FINAL-KBUU')){
            $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
            $subdata['detail_up']   = array(
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
        if(($dokumen_up == 'SPM-DRAFT-PPK') || ($dokumen_up == 'SPM-DRAFT-KPA') || ($dokumen_up == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_up == 'SPM-FINAL-KBUU')){
            $nomor_trx_spm = $this->rsa_up_model->get_nomor_spm($kd_unit,$tahun);  
            $data_spm = $this->rsa_up_model->get_data_spm($nomor_trx_spm);
            $subdata['detail_up'] 	= array(
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
            $subdata['detail_pic_spm']  = (object) array(
                'untuk_bayar' => $data_spm->untuk_bayar,
                'penerima' => $data_spm->penerima,
                'alamat_penerima' => $data_spm->alamat,
                'nama_bank_penerima' => $data_spm->nmbank,
                'no_rek_penerima' => $data_spm->rekening,
                'npwp_penerima' => $data_spm->npwp,
            );
            $subdata['tgl_spm'] = $data_spm->tgl_spm;
            $subdata['cur_tahun_spm'] = $data_spm->tahun;
        }else{
            $subdata['cur_tahun_spm'] = '';
            $subdata['tgl_spm'] = '' ;
        }
        $subdata['nomor_spp'] = $nomor_trx_spp;
        $subdata['nomor_spm'] = $nomor_trx_spm;
        $subdata['tgl_spm_kpa'] = $this->rsa_up_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);
        $subdata['tgl_spm_verifikator'] = $this->rsa_up_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);
        $subdata['tgl_spm_kbuu'] = $this->rsa_up_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);
        $subdata['ket'] = $this->rsa_up_model->lihat_ket($kd_unit,$tahun);
        $this->load->model('akun_kas6_model');
        $subdata['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();
        $this->data['content'] = $this->load->view("akuntansi/bukti_up",$subdata,TRUE);
        $this->load->view('akuntansi/content_template',$this->data);
    }
    
    function tup($kd_unit,$tahun){
        $this->load->model('unit_model');
        $this->load->model('Rsa_tambah_tup_model', 'rsa_tambah_tup_model');
        $subdata['cur_tahun'] = $tahun;
        if(strlen($kd_unit)==2){
            $subdata['unit_kerja'] = $this->unit_model->get_nama($kd_unit);
            $subdata['unit_id'] = $kd_unit ;
            $subdata['kd_unit'] = $kd_unit ;
            $subdata['alias'] = $this->unit_model->get_alias($kd_unit);
        }
        elseif(strlen($kd_unit)==4){
            $subdata['unit_kerja'] = $this->unit_model->get_nama($kd_unit) . ' - ' . $this->unit_model->get_real_nama($kd_unit);
            $subdata['unit_id'] = $kd_unit;
            $subdata['kd_unit'] = $kd_unit ;
            $subdata['alias'] = $this->unit_model->get_alias($kd_unit);
        }


        $dokumen_tup = $this->rsa_tambah_tup_model->check_dokumen_tambah_tup($kd_unit,$tahun);

        $subdata['doc_tup'] = $dokumen_tup;

        $nomor_trx_spp = $this->rsa_tambah_tup_model->get_nomor_spp($kd_unit,$tahun); 


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

        if(($dokumen_tup == 'SPP-FINAL') || ($dokumen_tup == 'SPP-DRAFT') || ($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
            $data_spp = $this->rsa_tambah_tup_model->get_data_spp($nomor_trx_spp);
            $subdata['detail_tup']   = array(
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

        if(($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
            $nomor_trx_spm = $this->rsa_tambah_tup_model->get_nomor_spm($kd_unit,$tahun);

            $data_spm = $this->rsa_tambah_tup_model->get_data_spm($nomor_trx_spm);
            $subdata['detail_tup'] 	= array(
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

            $subdata['detail_pic_spm']  = (object) array(
                'untuk_bayar' => $data_spm->untuk_bayar,
                'penerima' => $data_spm->penerima,
                'alamat_penerima' => $data_spm->alamat,
                'nama_bank_penerima' => $data_spm->nmbank,
                'no_rek_penerima' => $data_spm->rekening,
                'npwp_penerima' => $data_spm->npwp,
            );
            $subdata['tgl_spm'] = $data_spm->tgl_spm;
            $subdata['cur_tahun_spm'] = $data_spm->tahun;
        }else{
            $subdata['cur_tahun_spm'] = '';
            $subdata['tgl_spm'] = '' ;
        }

        $subdata['nomor_spp'] = $nomor_trx_spp;

        $subdata['nomor_spm'] = $nomor_trx_spm;


        $subdata['tgl_spm_kpa'] = $this->rsa_tambah_tup_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);

        $subdata['tgl_spm_verifikator'] = $this->rsa_tambah_tup_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);

        $subdata['tgl_spm_kbuu'] = $this->rsa_tambah_tup_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);

        $subdata['ket'] = $this->rsa_tambah_tup_model->lihat_ket($kd_unit,$tahun);

        $this->load->model('akun_kas6_model');

        $subdata['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();
        $data['content'] 			= $this->load->view("akuntansi/bukti_tup",$subdata,TRUE);
        $this->load->view('akuntansi/content_template',$data);
    }
}
