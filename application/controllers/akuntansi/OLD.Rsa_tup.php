<?php
    if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    class rsa_tup extends CI_Controller{
/* -------------- Constructor ------------- */
            
            private $cur_tahun;
    public function __construct(){ 
        parent::__construct();
            //load library, helper, and model
                $this->cur_tahun = $this->setting_model->get_tahun();
            //$this->load->library(array('form_validation','option','Url_encoder','shorturl'));
            $this->load->helper('form');
            $this->load->model(array('rsa_tup_model','rsa_tambah_tup_model','setting_up_model','kuitansi_model','kuitansipengembalian_model'));
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
                
                        $data['main_content']   = $this->load->view('rsa_tup/index','',TRUE);
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
                
                function create_spp_tup(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){
                        if($this->input->post('rel_kuitansi')){
                            $array_id = $this->input->post('rel_kuitansi');
                            $array_id_pengembalian = $this->input->post('rel_kuitansi_pengembalian');
                            $data = base64_encode($array_id);
                            $data_pengembalian = base64_encode($array_id_pengembalian); 
                            // echo '1. ' ; echo $data ; echo '<br>' ; 
                            // $data = $this->url_encoder->encode($data);
                            // echo '2. ' ; echo $data ; echo '<br>' ;
                            $data = urlencode($this->shorturl->_encode_string_array($data)) ;
                            $data_pengembalian = urlencode($this->shorturl->_encode_string_array($data_pengembalian)) ;
                            // echo '3. ' ; echo $data ; echo '<br>' ;
                            // $data = $this->shorturl->_decode_string_array($data) ;
                            // echo '4. ' ; echo $data ; echo '<br>' ;
                            // $data = $this->shorturl->encode($data) ;
                            // echo '4. ' ; echo $data ; echo '<br>' ;
                            // $data = $this->shorturl->decode($data) ;
                            // echo '5. ' ; echo $data ; echo '<br>' ;
                            // die;
                            // echo $data ; die;
//                            $this->load->library('encrypt');
//                            $data = $this->encrypt->encode($array_id);
                            redirect(site_url('rsa_tup/spp_tup/' . $data . '/' . $data_pengembalian));
                        }
                        
                    }
                }
                
                function check_tup_(){
                    $mysql = "SELECT data_kuitansi FROM trx_spm_tup_nihil_data WHERE str_nomor_trx = '00001/SVO/SPM-TUP-NIHIL/JUN/2017' " ;

                    $q = $this->db->query($mysql) ;

                    $data = $q->row();

                    // var_dump($data) ; die ;

                    $str = str_replace('[', '', $data->data_kuitansi) ;
                    $str = str_replace(']', '', $str) ;

                    // echo $str ; die  ;
                   
                    $mysql = "SELECT kode_usulan_belanja,kode_akun_tambah,deskripsi FROM rsa_kuitansi_detail WHERE id_kuitansi IN (".$str.") " ; 

                    // echo $mysql ;  die ;

                    $q = $this->db->query($mysql) ;

                    $data = $q->result();

                    // echo '<pre>' ; var_dump($data) ; echo '</pre>' ;die ;

                    foreach($data as $d){ 
                        $mysql = "UPDATE rsa_detail_belanja_ SET proses = '63' WHERE kode_usulan_belanja = '{$d->kode_usulan_belanja}' AND kode_akun_tambah = '{$d->kode_akun_tambah}' "  ;

                        // echo $mysql ; die ;

                        $this->db->query($mysql) ;

                    }

                    echo 'done' ;

                }

                function check_tup_data(){
                    $mysql = "SELECT data_kuitansi FROM trx_spm_tup_nihil_data WHERE str_nomor_trx = '00003/LPM/SPM-TUP-NIHIL/JUN/2017' " ;

                    $q = $this->db->query($mysql) ;

                    $data = $q->row();

                    // var_dump($data) ; die ;

                    $str = str_replace('[', '', $data->data_kuitansi) ;
                    $str = str_replace(']', '', $str) ;

                    // echo $str ; die  ;
                   
                    $mysql = "UPDATE rsa_kuitansi SET cair = '1' WHERE id_kuitansi IN (".$str.") " ;

                    $this->db->query($mysql) ; 

                    // // echo $mysql ;  die ;

                    // $q = $this->db->query($mysql) ;

                    // $data = $q->result();

                    // // echo '<pre>' ; var_dump($data) ; echo '</pre>' ;die ;

                    // foreach($data as $d){ 
                    //     $mysql = "UPDATE rsa_detail_belanja_ SET proses = '63' WHERE kode_usulan_belanja = '{$d->kode_usulan_belanja}' AND kode_akun_tambah = '{$d->kode_akun_tambah}' "  ;

                    //     // echo $mysql ; die ;

                    //     $this->db->query($mysql) ;

                    // }

                    echo 'done' ;

                }

                function check_tup_data_tgl(){

                    $mysql = "SELECT data_kuitansi FROM trx_spm_tup_nihil_data WHERE str_nomor_trx = '00001/SVO/SPM-TUP-NIHIL/JUN/2017' " ;

                    $q = $this->db->query($mysql) ;

                    $data = $q->row();

                    // var_dump($data) ; die ;

                    $str = str_replace('[', '', $data->data_kuitansi) ;
                    $str = str_replace(']', '', $str) ;

                    // echo $str ; // die  ;

                    $mysql2 = "SELECT trx_tup_nihil.tgL_proses FROM  trx_spm_tup_nihil_data JOIN trx_tup_nihil ON trx_spm_tup_nihil_data.nomor_trx_spm = trx_tup_nihil.id_trx_nomor_tup WHERE trx_spm_tup_nihil_data.str_nomor_trx = '00001/SVO/SPM-TUP-NIHIL/JUN/2017' AND trx_tup_nihil.posisi = 'SPM-FINAL-KBUU' " ; 

                    // echo $mysql2 ; die ;

                    $q2 = $this->db->query($mysql2) ;

                    $data2 = $q2->row();

                    // echo '<pre>' ; var_dump($data2) ; echo '</pre>' ; // die ;


                   
                    $mysql3 = "SELECT kode_usulan_belanja,kode_akun_tambah,deskripsi FROM rsa_kuitansi_detail WHERE id_kuitansi IN (".$str.") " ; 

                    // echo $mysql ;  die ;

                    $q3 = $this->db->query($mysql3) ;

                    $data3 = $q3->result();

                    // echo '<pre>' ; var_dump($data3) ; echo '</pre>' ; // die ;

                    foreach($data3 as $d){ 
                        $mysql = "UPDATE rsa_detail_belanja_ SET tanggal_transaksi = '{$data2->tgL_proses}' WHERE kode_usulan_belanja = '{$d->kode_usulan_belanja}' AND kode_akun_tambah = '{$d->kode_akun_tambah}' "  ;

                        // echo $mysql ; die ;

                        $this->db->query($mysql) ;

                    }

                    echo 'done' ;

                }

                function spp_tup($data_url = '',$data_url_pengembalian = ''){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==100))){
                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                //$subdata_rsa_up['result_rsa_up']      = $this->rsa_up_model->search_rsa_up();
                                
                                $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($this->check_session->get_unit(),$this->cur_tahun);

                                // echo $dokumen_tup ; die ;
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

                                
                                $tgl_ok = false ;

                                if((($dokumen_tup == 'SPM-FINAL-KBUU')&&($data_url != ''))){
                                    $dokumen_tup = '' ;
                                    $tgl_ok = true ;
                                }
                                
                                if(($dokumen_tup == '')||($dokumen_tup == 'SPP-DITOLAK')||($dokumen_tup == 'SPM-DITOLAK-KPA')||($dokumen_tup == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_tup == 'SPM-DITOLAK-KBUU')){

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

                                    $du_p = '' ;

                                    if($data_url_pengembalian != ''){
                                        
                                        $data_url_pengembalian = urldecode($data_url_pengembalian);
                                        $data_url_pengembalian = $this->shorturl->_decode_string_array($data_url_pengembalian);
                                        $du_p = $data_url_pengembalian;

                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;
                                            // echo $array_id ; die;
    //                                        $array_id = $this->input->post('rel_kuitansi');

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

                                    $subdata['detail_tup']          = array(
                                                                                    'nom' => $pengeluaran,
                                                                                    'pengembalian' => $pengembalian ,
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
//                                        'tgl_spp' => $rsa_user->tgl_spp,
                                    );
//                                    var_dump($rsa_user);
//                                    echo "<br />";
//                                    echo "<br />";
//                                    echo "<br />";
//                                    var_dump($subdata['detail_pic']);die;

                                
                                    if(!$tgl_ok){
                                        $subdata['tgl_spp'] = $this->rsa_tup_model->get_tgl_spp($this->check_session->get_unit(),$this->cur_tahun);
                                    }else{
                                        $subdata['tgl_spp'] = '';
                                    }
//                                    echo $subdata['tgl_spp'];die;
                                    $nomor_trx_ = $this->rsa_tup_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");  
                                    $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-TUP-NIHIL'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B");  
                                   // var_dump($subdata);die;
                                
                                }else{
                                    
                                    $nomor_trx = $this->rsa_tup_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 
                                    $data_spp = $this->rsa_tup_model->get_data_spp($nomor_trx);
                                    
                                    $du = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx);
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

                                    $du_p = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx);
                                    // var_dump($data_kuitansi_pengembalian); die ;
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
                                        // echo $data_url_pengembalian ; die ;
                                        if( base64_encode(base64_decode($data_url_pengembalian, true)) === $data_url_pengembalian){
                                            $array_id_pengembalian = base64_decode($data_url_pengembalian) ;
    //                                        $array_id = $this->input->post('rel_kuitansi');
                                            $data_ = array(
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }
//                                    }else{
//                                        $pengeluaran = 0;
//                                    }

                                        // echo $pengembalian ; die ;

                                    $subdata['rel_kuitansi'] = $du;
                                    
                                    $subdata['detail_tup']  = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
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



    //                                if(($dokumen_tup == '') || ($dokumen_tup == 'SPP-DITOLAK') || ($dokumen_tup == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 
                                    
                                    
                                }
                                
                                $data_akun_pengeluaran = array();   
                                $data_spp_pajak = array();
                                $data_rekap_pajak = array();
                                $data_rekap_bruto = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
                                   // print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__,'TP');
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
                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'TP');

                                    // var_dump($data_spp_pajak) ; die ;

                                    $data_rekap_pajak = $this->kuitansi_model->get_rekap_pajak_by_array_id($data__);
                                    $data_rekap_bruto = $this->kuitansi_model->get_rekap_bruto_by_array_id($data__);
//                                    if(!empty($data_akun_pengeluaran)){
                                    $data_akun5digit = array();
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
//                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
//                                    
//                                    $nomor_spm_cair_lalu = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
//                                    
//                                    $nomor_spp_cair_lalu = $this->rsa_tup_model->get_spp_by_spm($nomor_spm_cair_lalu);
//                                    
//                                    echo $nomor_spm_cair_lalu; die;
                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $nomor_spm = $this->rsa_tup_model->get_spm_by_spp($nomor_trx);

                                    // echo $nomor_spm ; die ;
                                    
                                    // echo $nomor_spm_cair_before; die;
                                    
                                    if(empty($nomor_spm)){
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);
                                    
                                       // var_dump($data_akun_before); die;
                                        
                                    }else{
                                        
                                        $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);

                                        // echo $nomor_spm_cair_before . ' - ' . $nomor_spm ; die;
                                        
                                        

                                        if($nomor_spm_cair_before != $nomor_spm){
                                             $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);
                                        }else{
                                            $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_spm($nomor_spm);
                                        }
                                    
//                                        var_dump($data_akun_before); die;
                                    }
                                    
                                    
//                                    
//                                    $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                    if($nomor_spp_cair_lalu != $nomor_trx){
//                                        $data_akun_lalu = $this->kuitansi_model->get_tup_akun_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
    //                                    echo '<pre>';print_r($data_akun_lalu);echo '</pre>';die;

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
                                        
                                        
//                                    }
                                    // echo '<pre>' ; 
                                    // var_dump($data_rekap_bruto); 
                                    // echo '</pre>' ; die;
                                    
                                    
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
                                   // echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;

                                    $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                    $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                    $subdata['data_akun_rkat'] = $data_akun_rkat;
                                    $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                    $subdata['data_spp_pajak'] = $data_spp_pajak;
                                    $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                    $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                    $subdata['rincian_keluaran'] = $rincian_keluaran;
                               


                                }

                                $subdata['doc_tup'] = $dokumen_tup;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                $subdata['ket'] = $this->rsa_tup_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                $data['main_content']           = $this->load->view("rsa_tup/spp_tup",$subdata,TRUE);

                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }

            function spp_tup_lihat($url = ''){


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
                //$subdata_rsa_up['result_rsa_up']      = $this->rsa_up_model->search_rsa_up();
                                
                                // $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($this->check_session->get_unit(),$this->cur_tahun);


                                $nomor_trx_spp = $url ;
                                
                                
                                $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup_by_str_trx($url);


                                // echo $dokumen_tup ; die;

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

                                // if((($dokumen_tup == 'SPM-FINAL-KBUU')&&($data_url != ''))){
                                //     $dokumen_tup = '' ;
                                //     $tgl_ok = true ;
                                // }
                                
//                                 if(($dokumen_tup == '')||($dokumen_tup == 'SPP-DITOLAK')||($dokumen_tup == 'SPM-DITOLAK-KPA')||($dokumen_tup == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_tup == 'SPM-DITOLAK-KBUU')){

//                                     $du = '' ;
//                                     if($data_url != ''){
//                                         $du = $data_url;
//                                         $data_url = urldecode($data_url);
//                                         if( base64_encode(base64_decode($data_url, true)) === $data_url){
//                                             $array_id = base64_decode($data_url) ;
//                                             // echo $array_id ; die;
//     //                                        $array_id = $this->input->post('rel_kuitansi');
//                                             $data_ = array(
//                                                 'kode_unit_subunit' => $this->check_session->get_unit(),
//                                                 'array_id' => json_decode($array_id),
//                                                 'tahun' => $this->cur_tahun,
//                                             );
//                                             $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
//                                             // echo $pengeluaran;die;
//                                         }else{
//                                             $pengeluaran = 0;
//                                         }
//                                     }else{
//                                         $pengeluaran = 0;
//                                     }
//                                     $subdata['rel_kuitansi'] = $du;
//                                     $subdata['detail_tup']          = array(
//                                                                                     'nom' => $pengeluaran,
//                                                                                     'terbilang' => $this->convertion->terbilang($pengeluaran), 
                                                                                    
//                                                                                 );
                                                                    

//                                     $subdata['cur_tahun'] = $this->cur_tahun;
//                                     $rsa_user = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
//                                     $subdata['detail_pic']  = (object) array(
//                                         'penerima' => $rsa_user->nm_lengkap,
//                                         'alamat_penerima' => $rsa_user->alamat,
//                                         'nama_bank_penerima' => $rsa_user->nama_bank,
//                                         'no_rek_penerima' => $rsa_user->no_rek,
//                                         'npwp_penerima' => $rsa_user->npwp,
//                                         'nmbendahara' => $rsa_user->nm_lengkap,
//                                         'nipbendahara' => $rsa_user->nomor_induk,
// //                                        'tgl_spp' => $rsa_user->tgl_spp,
//                                     );
// //                                    var_dump($rsa_user);
// //                                    echo "<br />";
// //                                    echo "<br />";
// //                                    echo "<br />";
// //                                    var_dump($subdata['detail_pic']);die;



//     //                                if(($dokumen_tup == '') || ($dokumen_tup == 'SPP-DITOLAK') || ($dokumen_tup == 'SPM-DITOLAK')){
//     //                                    $subdata['siap_spp'] = 'ok';
//     //                                }else{
//     //                                    $subdata['siap_spp'] = 'no_ok';
//     //                                }
// //                                  
//                                     if(!$tgl_ok){
//                                         $subdata['tgl_spp'] = $this->rsa_tup_model->get_tgl_spp($this->check_session->get_unit(),$this->cur_tahun);
//                                     }else{
//                                         $subdata['tgl_spp'] = '';
//                                     }
// //                                    echo $subdata['tgl_spp'];die;
//                                     $nomor_trx_ = $this->rsa_tup_model->get_nomor_next_spp($this->check_session->get_unit(),$this->cur_tahun);
//                                     setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");  
//                                     $nomor_trx = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPP-GUP'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
//                                     setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B");  
// //                                    var_dump($subdata);die;
                                
//                                 }else{
                                    
                                    
                                    
                                    // $nomor_trx = $this->rsa_tup_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                    $nomor_trx = $nomor_trx_spp ;

                                    $data_spp = $this->rsa_tup_model->get_data_spp($nomor_trx);
                                    
                                    $du = '' ;
//                                    if($data_url != ''){
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx);
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
                                    $subdata['rel_kuitansi'] = $du;
                                    
                                    $subdata['detail_tup']  = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
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



    //                                if(($dokumen_tup == '') || ($dokumen_tup == 'SPP-DITOLAK') || ($dokumen_tup == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 
                                    
                                    
                                // }
                                
                                $data_akun_pengeluaran = array();   
                                $data_spp_pajak = array();
                                $data_akun_rkat = array();
                                $data_akun_pengeluaran_lalu = array();
                                $rincian_akun_pengeluaran = array();
                                $rincian_keluaran = array();
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
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
//                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
//                                    
//                                    $nomor_spm_cair_lalu = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
//                                    
//                                    $nomor_spp_cair_lalu = $this->rsa_tup_model->get_spp_by_spm($nomor_spm_cair_lalu);
//                                    
//                                    echo $nomor_spm_cair_lalu; die;
                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    // $nomor_spm = $this->rsa_tup_model->get_spm_by_spp($nomor_trx);


                                    $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_spp($nomor_spp);
                                    
//                                    echo $nomor_spm_cair_before; die;
                                    
//                                     if(empty($nomor_spm)){
                                        
//                                         $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);
                                    
// //                                        var_dump($data_akun_before); die;
                                        
//                                     }else{
                                        
//                                         $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);

//                                         // echo $nomor_spm_cair_before . ' - ' . $nomor_spm ; die;
                                        
                                        

//                                         if($nomor_spm_cair_before != $nomor_spm){
//                                              $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);
//                                         }else{
//                                             $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_spm($nomor_spm);
//                                         }
                                    
// //                                        var_dump($data_akun_before); die;
//                                     }
                                    
                                    
//                                    
//                                    $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                    if($nomor_spp_cair_lalu != $nomor_trx){
//                                        $data_akun_lalu = $this->kuitansi_model->get_tup_akun_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
    //                                    echo '<pre>';print_r($data_akun_lalu);echo '</pre>';die;

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
                                        
                                        
//                                    }
                                    
                                    
                                    
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                }

                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['doc_tup'] = $dokumen_tup;
                                $subdata['nomor_spp'] = $nomor_trx;
                                $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                $subdata['ket'] = $this->rsa_tup_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
//                                echo $subdata['tgl_spp'];die;
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata['detail_pic']);die;
                                
//                                var_dump($subdata);die;
                                
                $data['main_content']           = $this->load->view("rsa_tup/spp_tup",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }
                
            function spm_tup(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){
                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                //$subdata_rsa_up['result_rsa_up']      = $this->rsa_up_model->search_rsa_up();
//              $subdata['detail_up']           = array(
//                                                                                    'nom' => $this->setting_up_model->get_setting_up($this->check_session->get_unit(),$this->cur_tahun),
//                                                                                    'terbilang' => $this->convertion->terbilang($this->setting_up_model->get_setting_up($this->check_session->get_unit(),$this->cur_tahun)), 
//                                                                                    
//                                                                                );
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
                                
                                
                                $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($this->check_session->get_unit(),$this->cur_tahun);

                                // echo $dokumen_tup ; die;
                              
                                $subdata['doc_up'] = $dokumen_tup;
                                
//                                $subdata['tgl_spm'] = $this->rsa_tup_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                $nomor_trx_spp = $this->rsa_tup_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 
                                
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

                                
                                if(($dokumen_tup == 'SPP-FINAL') || ($dokumen_tup == 'SPP-DRAFT') || ($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_tup_model->get_data_spp($nomor_trx_spp);
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

                                    $subdata['detail_tup']   = array(
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
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_tup == '') || ($dokumen_tup == 'SPP-DITOLAK') || ($dokumen_tup == 'SPM-DITOLAK')){
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
                                
                                if(($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_tup_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                    
                                    $data_spm = $this->rsa_tup_model->get_data_spm($nomor_trx_spm);
                                    // var_dump($data_spm);die;
                                    $subdata['detail_tup_spm']  = array(
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
                                    
                                    $nomor_trx_ = $this->rsa_tup_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-TUP-NIHIL'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    
//                                    echo $nomor_trx_spp ; die;
                                    
//                                    $data_spp = $this->rsa_up_model->get_data_spp($nomor_trx_spp);
                                    $subdata['detail_tup_spm']  = array(
                                                                    'nom' => $data_spp->jumlah_bayar,
                                                                    'pengembalian' => $data_spp->jumlah_pengembalian ,
                                                                    'terbilang' => $data_spp->terbilang, 

                                                                );

                                    // var_dump($subdata['detail_tup_spm']);die;
                                    
//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                                    
                                    $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                    $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
                                    $subdata['detail_verifikator']  = $this->rsa_tup_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
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

    //                                if(($dokumen_tup == '') || ($dokumen_tup == 'SPP-DITOLAK') || ($dokumen_tup == 'SPM-DITOLAK')){
    //                                    $subdata['siap_spp'] = 'ok';
    //                                }else{
    //                                    $subdata['siap_spp'] = 'no_ok';
    //                                }

//                                    $subdata['tgl_spp'] = $data_spp->tgl_spp;
                                    
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
//                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
//                                    
//                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
//                                }
                                
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__,'TP');
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
                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'TP');

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
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
//                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
//                                    
//                                    $nomor_spm_cair_lalu = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
//                                    
//                                    $nomor_spp_cair_lalu = $this->rsa_tup_model->get_spp_by_spm($nomor_spm_cair_lalu);
//                                    
//                                    echo $nomor_spm_cair_lalu; die;
                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $nomor_spm = $this->rsa_tup_model->get_spm_by_spp($nomor_trx_spp);
                                    
//                                    echo $nomor_spm_cair_before; die;
                                    
                                    if(empty($nomor_spm)){
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                        var_dump($data_akun_before); die;
                                        
                                    }else{
                                        
                                        $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);

                                        // echo $nomor_spm_cair_before ; die;
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_spm($nomor_spm);

                                        if($nomor_spm_cair_before != $nomor_spm){
                                             $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);
                                        }
                                    
//                                        var_dump($data_akun_before); die;
                                    }
                                    
                                    
//                                    
//                                    $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                    if($nomor_spp_cair_lalu != $nomor_trx){
//                                        $data_akun_lalu = $this->kuitansi_model->get_tup_akun_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
    //                                    echo '<pre>';print_r($data_akun_lalu);echo '</pre>';die;

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
                                        
                                        
//                                    }
                                    
                                    
                                    
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
//                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
                                    

                                }

                                // die;

                                $daftar_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_kuitansi_by_url_id(base64_decode(urldecode($du_p)));

                                // var_dump($daftar_kuitansi_pengembalian); die;
                                
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
                                
                                $subdata['detail_verifikator']  = $this->rsa_tup_model->get_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_tup_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_tup_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_tup_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_tup_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_tup/spm_tup",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }


            function spm_tup_lihat($url){


                    if($this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100))){

                            $url = urldecode($url);

                            if( base64_encode(base64_decode($url, true)) === $url){
                                $url = base64_decode($url);
                            }else{
                                redirect(site_url('/'));
                            }



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
                                
                                
                                $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup_by_str_trx($url);

                                // echo $dokumen_tup ; die;
                              
                                $subdata['doc_up'] = $dokumen_tup;
                                
//                                $subdata['tgl_spm'] = $this->rsa_tup_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spp = $this->rsa_tup_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spp = $this->rsa_tup_model->get_spp_by_spm($nomor_trx_spm);

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
                                
                                if(($dokumen_tup == 'SPP-FINAL') || ($dokumen_tup == 'SPP-DRAFT') || ($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_tup_model->get_data_spp($nomor_trx_spp);
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
                                    $subdata['detail_tup']   = array(
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
                                
                                if(($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
                                    
                                    // $nomor_trx_spm = $this->rsa_tup_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                    
                                    $data_spm = $this->rsa_tup_model->get_data_spm($nomor_trx_spm);
                                    // var_dump($data_spm);die;
                                    $subdata['detail_tup_spm']  = array(
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
                                    
                                    // $nomor_trx_ = $this->rsa_tup_model->get_nomor_next_spm($this->check_session->get_unit(),$this->cur_tahun);
                                    // setlocale(LC_ALL, 'id_ID.utf8');$bln = strftime("%h");
                                    // $nomor_trx_spm = $nomor_trx_.'/'.$this->check_session->get_alias().'/'.'SPM-GUP'.'/'.strtoupper($bln).'/'.$this->cur_tahun;
                                    

                                    // $subdata['detail_tup_spm']  = array(
                                    //                                 'nom' => $data_spp->jumlah_bayar,
                                    //                                 'terbilang' => $data_spp->terbilang, 

                                    //                             );
                                    
                                    // $subdata['detail_ppk']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'14');
                                    // $subdata['detail_kpa']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'2');
                                    // $subdata['detail_verifikator']  = $this->rsa_tup_model->get_verifikator(substr($this->check_session->get_unit(),0,2));
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
                                    
                                    $nomor_spm = $this->rsa_tup_model->get_spm_by_spp($nomor_trx_spp);
                                    
//                                    echo $nomor_spm_cair_before; die;
                                    
                                    if(empty($nomor_spm)){
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                        var_dump($data_akun_before); die;
                                        
                                    }else{

                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_spm($nomor_spm);

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

                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
                                    
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
                                
                                $subdata['detail_verifikator']  = $this->rsa_tup_model->get_verifikator_by_spm($nomor_trx_spm);

                                // var_dump($subdata['detail_verifikator']) ; die;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_tup_model->get_tgl_spm_kpa_by_spm($nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_tup_model->get_tgl_spm_verifikator_by_spm($nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_tup_model->get_tgl_spm_kbuu_by_spm($nomor_trx_spm);

                                $subdata['ket'] = $this->rsa_tup_model->lihat_ket_by_str_trx($nomor_trx_spm);

                                // var_dump($subdata) ; die;
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_tup/spm_tup_lihat",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
        }
                
                function spm_tup_kpa(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==2)||($this->check_session->get_level()==100))){
                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                //$subdata_rsa_up['result_rsa_up']      = $this->rsa_up_model->search_rsa_up();
                
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
                                
                                $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($this->check_session->get_unit(),$this->cur_tahun);

                                // echo $this->check_session->get_unit() ; die ;
                              
                                $subdata['doc_up'] = $dokumen_tup;
                                
                                $nomor_trx_spp = $this->rsa_tup_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 
                                
//                                echo $nomor_trx_spp ; die;
                                
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
                                
                                $array_id = '';
                                $array_id_pengembalian = '';
                                $pengeluaran = 0;
                                $pengembalian = 0;
                                $du = '' ;
                                $du_p = '' ;
                                
                                if(($dokumen_tup == 'SPP-FINAL') || ($dokumen_tup == 'SPP-DRAFT') || ($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){


                                  
                                    $data_spp = $this->rsa_tup_model->get_data_spp($nomor_trx_spp);
                                    
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
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
                                                'kode_unit_subunit' => $this->check_session->get_unit(),
                                                'array_id_pengembalian' => json_decode($array_id_pengembalian),
                                                'tahun' => $this->cur_tahun,
                                            );
                                            $pengembalian = $this->kuitansipengembalian_model->get_pengeluaran_by_array_id($data_);
                                        }else{
                                            $pengembalian = 0;
                                        }
                                    
                                    $subdata['detail_tup']   = array(
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
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_tup == '') || ($dokumen_tup == 'SPP-DITOLAK') || ($dokumen_tup == 'SPM-DITOLAK')){
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
                                
//                                $subdata['tgl_spm'] = $this->rsa_up_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                $nomor_trx_spm = '';
                                
                                if(($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_tup_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                    
                                    $data_spm = $this->rsa_tup_model->get_data_spm($nomor_trx_spm);
                                    $subdata['detail_tup_spm']   = array(
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
                                    // var_dump($subdata['detail_tup_spm']); die;
                                    
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
//                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
//                                    
//                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
//                                }
                                
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__,'TP');
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
                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'TP');

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
                                        'kode_unit_subunit' => $this->check_session->get_unit(),
                                        'tahun' => $this->cur_tahun,
                                        'kode_akun5digit' => $data_akun5digit
                                    );
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
//                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
//                                    
//                                    $nomor_spm_cair_lalu = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
//                                    
//                                    $nomor_spp_cair_lalu = $this->rsa_tup_model->get_spp_by_spm($nomor_spm_cair_lalu);
//                                    
//                                    echo $nomor_spm_cair_lalu; die;
                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $nomor_spm = $this->rsa_tup_model->get_spm_by_spp($nomor_trx_spp);
                                    
//                                    echo $nomor_spm_cair_before; die;
                                    
                                    if(empty($nomor_spm)){
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                        var_dump($data_akun_before); die;
                                        
                                    }else{
                                        
                                        $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);

                                        // echo $nomor_spm_cair_before ; die;
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_spm($nomor_spm);

                                        if($nomor_spm_cair_before != $nomor_spm){
                                             $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($this->check_session->get_unit(),$this->cur_tahun);
                                        }
                                    
//                                        var_dump($data_akun_before); die;
                                    }
                                    
                                    
//                                    
//                                    $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                    if($nomor_spp_cair_lalu != $nomor_trx){
//                                        $data_akun_lalu = $this->kuitansi_model->get_tup_akun_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
    //                                    echo '<pre>';print_r($data_akun_lalu);echo '</pre>';die;

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
                                        
                                        
//                                    }
                                    
                                    
                                    
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
//                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
                                    
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
                                $subdata['rel_kuitansi_pengembalian'] = $du_p;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['daftar_kuitansi_pengembalian'] = $daftar_kuitansi_pengembalian;
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_tup_model->get_tgl_spm_kpa($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_tup_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_tup_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_tup_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_tup/spm_tup_kpa",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }

            function spm_tup_lihat_99($url,$kd_unit,$tahun,$id_kuitansi){
                     if(1){
                        //$this->check_session->user_session() && (($this->check_session->get_level()==14)||($this->check_session->get_level()==100)||($this->check_session->get_level()==17)||($this->check_session->get_level()==11))

                        $url = base64_decode(urldecode($url));

                        $subdata['id_kuitansi'] = $id_kuitansi;

                            // if( base64_encode(base64_decode($url, true)) === $url){
                            //     $url = base64_decode($url);
                            // }else{
                            //     redirect(site_url('/'));
                            // }

                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                //$subdata_rsa_up['result_rsa_up']      = $this->rsa_up_model->search_rsa_up();
                
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

                                $nomor_trx_spm = $url ;

                                $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup_by_str_trx($url);

                                $subdata['doc_tup'] = $dokumen_tup;

                                // print_r($dokumen_tup);die();
                                
                                // $nomor_trx_spp = $this->rsa_up_model->get_nomor_spp($this->check_session->get_unit(),$this->cur_tahun); 

                                $nomor_trx_spp = $this->rsa_tup_model->get_spp_by_spm($nomor_trx_spm);
                                
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
                                
                                $array_id = '';
                                $array_id_pengembalian = '';
                                $pengeluaran = 0;
                                $pengembalian = 0;
                                $du = '' ;
                                $du_p = '' ;
                                
                                if(($dokumen_tup == 'SPP-FINAL') || ($dokumen_tup == 'SPP-DRAFT') || ($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){


                                  
                                    $data_spp = $this->rsa_tup_model->get_data_spp($nomor_trx_spp);
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'TUP');
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
                                    if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                        $array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                                        $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                        $data_ = array(
                                            'kode_unit_subunit' => $kd_unit,//$this->check_session->get_unit(),
                                            'array_id' => json_decode($array_id),
                                            'tahun' =>$tahun,// $this->cur_tahun,
                                        );
                                        $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                    }else{
                                        $pengeluaran = 0;
                                    }

                                    $data_kuitansi_pengembalian = $this->kuitansipengembalian_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp,'TUP');
                                    // var_dump($data_kuitansi_pengembalian); die;
                                    $kuitansi_d_pengembalian = array();
                                    if(!empty($data_kuitansi_pengembalian)){
                                        foreach($data_kuitansi_pengembalian as $dk){
                                            $kuitansi_d_pengembalian[] = $dk->id_kuitansi;
                                        }
                                    }

                                    // print_r($kuitansi_d_pengembalian);
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
                                    
                                    $subdata['detail_tup']   = array(
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
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_tup == '') || ($dokumen_tup == 'SPP-DITOLAK') || ($dokumen_tup == 'SPM-DITOLAK')){
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
                                
//                                $subdata['tgl_spm'] = $this->rsa_up_model->get_tgl_spm($this->check_session->get_unit(),$this->cur_tahun);
                                
                                // $nomor_trx_spm = '';
                                
                                if(($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
                                    
                                    // $nomor_trx_spm = $this->rsa_tup_model->get_nomor_spm($this->check_session->get_unit(),$this->cur_tahun);  
                                    
                                    $data_spm = $this->rsa_tup_model->get_data_spm($nomor_trx_spm);

                                    $subdata['detail_tup_spm']   = array(
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
                                    // var_dump($subdata['detail_tup_spm']); die;
                                    
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
//                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
//                                    
//                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
//                                }
                                
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,//$this->check_session->get_unit(),
                                        'tahun' => $tahun,//$this->cur_tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__,'TP');
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
                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'TP');

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
//                                    $nomor_spm_cair_lalu = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
//                                    
//                                    $nomor_spp_cair_lalu = $this->rsa_tup_model->get_spp_by_spm($nomor_spm_cair_lalu);
//                                    
//                                    echo $nomor_spm_cair_lalu; die;
                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $nomor_spm = $this->rsa_tup_model->get_spm_by_spp($nomor_trx_spp);
                                    
//                                    echo $nomor_spm_cair_before; die;
                                    
                                    if(empty($nomor_spm)){
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($kd_unit,$tahun);//$this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                        var_dump($data_akun_before); die;
                                        
                                    }else{
                                        
                                        $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($kd_unit,$tahun);//$this->check_session->get_unit(),$this->cur_tahun);

                                        // echo $nomor_spm_cair_before ; die;
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_spm($nomor_spm);

                                        if($nomor_spm_cair_before != $nomor_spm){
                                             $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($kd_unit,$tahun);//$this->check_session->get_unit(),$this->cur_tahun);
                                        }
                                    
//                                        var_dump($data_akun_before); die;
                                    }
                                    
                                    
//                                    
//                                    $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                    if($nomor_spp_cair_lalu != $nomor_trx){
//                                        $data_akun_lalu = $this->kuitansi_model->get_tup_akun_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
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

                                            $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___lalu,'TP');
                                        
                                        }
                                        
                                        
//                                    }
                                    
                                    
                                    
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
//                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
                                    
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
                                $subdata['tgl_spm_kpa'] = $this->rsa_tup_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);
                                
                                //$subdata['tgl_spm_verifikator'] = $this->rsa_gup_model->get_tgl_spm_verifikator($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_verifikator'] = $this->rsa_tup_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                //$subdata['tgl_spm_kbuu'] = $this->rsa_gup_model->get_tgl_spm_kbuu($this->check_session->get_unit(),$this->cur_tahun,$nomor_trx_spm);
                                $subdata['tgl_spm_kbuu'] = $this->rsa_tup_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);
                                
                                // $subdata['ket'] = $this->rsa_gup_model->lihat_ket($this->check_session->get_unit(),$this->cur_tahun);

                                $subdata['ket'] = $this->rsa_tup_model->lihat_ket_by_str_trx($nomor_trx_spm);//$kd_unit,$tahun);
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("akuntansi/spm_tup_lihat",$subdata,TRUE);
                $data['bukti'] = true;
                $data['content'] = '';
                $this->load->view('akuntansi/content_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
        }
                
                
                function daftar_unit($tahun=''){
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
                    
                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
                            $subdata['unit_usul']       = $this->rsa_tup_model->get_tup_unit_usul_verifikator($user->id,$tahun);
                            $subdata['subunit_usul']        = $this->rsa_tup_model->get_tup_subunit_usul_verifikator($user->id,$tahun);
//                            echo '<pre>';var_dump($subdata['subunit_usul']);echo '</pre>';die;
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana']   = $this->option->sumber_dana();
                            $data['main_content']       = $this->load->view("rsa_tup/daftar_unit",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
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
                            $subdata['unit_usul']       = $this->rsa_tup_model->get_tup_unit_usul($tahun);
                            $subdata['subunit_usul']        = $this->rsa_tup_model->get_tup_subunit_usul($tahun);
//                            echo '<pre>';var_dump($subdata['subunit_usul']);echo '</pre>';die;
                            $subdata['cur_tahun'] =  $tahun;
//                            $subdata['opt_sumber_dana']   = $this->option->sumber_dana();
                            $data['main_content']       = $this->load->view("rsa_tup/daftar_unit_kbuu",$subdata,TRUE);
                            /*  Load main template  */
    //          echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }
                
                function spm_tup_verifikator($kd_unit,$tahun){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3))){
                //set data for main template
                $data['user_menu']  = $this->load->view('user_menu','',TRUE);
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);       
                
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
                               
                                $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($kd_unit,$tahun);
                              
                                $subdata['doc_up'] = $dokumen_tup;
                                
                                $nomor_trx_spp = $this->rsa_tup_model->get_nomor_spp($kd_unit,$tahun); 
                                
//                                echo $nomor_trx_spp ; die;
                                
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
                                
                                if(($dokumen_tup == 'SPP-FINAL') || ($dokumen_tup == 'SPP-DRAFT') || ($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_tup_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
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
                                    if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                        $array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                                        $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                        $data_ = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'array_id' => json_decode($array_id),
                                            'tahun' => $this->cur_tahun,
                                        );
                                        $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                    }else{
                                        $pengeluaran = 0;
                                    }
                                    
                                    $subdata['detail_tup']   = array(
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
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_tup == '') || ($dokumen_tup == 'SPP-DITOLAK') || ($dokumen_tup == 'SPM-DITOLAK')){
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
                                
                                
//                                $subdata['tgl_spm'] = $this->rsa_up_model->get_tgl_spm($kd_unit,$tahun);
                                
                                $nomor_trx_spm = '';
                                
                                if(($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_tup_model->get_nomor_spm($kd_unit,$tahun);  
                                    
                                    $data_spm = $this->rsa_tup_model->get_data_spm($nomor_trx_spm);
                                    $subdata['detail_tup_spm']  = array(
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
//                                        'kode_unit_subunit' => $kd_unit,
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
//                                        'kode_unit_subunit' => $kd_unit,
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
//                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
//                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
//                                }
                                
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__,'TP');
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
                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'TP');

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
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
//                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
//                                    
//                                    $nomor_spm_cair_lalu = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
//                                    
//                                    $nomor_spp_cair_lalu = $this->rsa_tup_model->get_spp_by_spm($nomor_spm_cair_lalu);
//                                    
//                                    echo $nomor_spm_cair_lalu; die;
                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $nomor_spm = $this->rsa_tup_model->get_spm_by_spp($nomor_trx_spp);
                                    
//                                    echo $nomor_spm_cair_before; die;
                                    
                                    if(empty($nomor_spm)){
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($kd_unit,$tahun);
                                    
//                                        var_dump($data_akun_before); die;
                                        
                                    }else{

                                        // echo $nomor_spm ; die;

                                        $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($kd_unit,$tahun);

                                        // echo $nomor_spm_cair_before ; die;
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_spm($nomor_spm);

                                        if($nomor_spm_cair_before != $nomor_spm){
                                             $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($kd_unit,$tahun);
                                        }

                                        // if(empty($data_akun_before)){
                                        //     // SUDAH SPP DAN SPP AKTIF 
                                           
                                        // }
                                    
                                       // var_dump($data_akun_before); die;
                                    }
                                    
                                    
//                                    
//                                    $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                    if($nomor_spp_cair_lalu != $nomor_trx){
//                                        $data_akun_lalu = $this->kuitansi_model->get_tup_akun_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
    //                                    echo '<pre>';print_r($data_akun_lalu);echo '</pre>';die;

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

                                            $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___lalu);
                                        
                                        }
                                        
                                        
//                                    }
                                    
                                    
                                    
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
//                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
                                }
                                
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
//                                echo $nomor_trx_spm ; die;
                                
//                                $detail_verifikator  = $this->rsa_up_model->get_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
//                                if(!isset($detail_verifikator->nm_lengkap)){
//                                    $detail_verifikator = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
//                                }
//                                
//                                $subdata['detail_verifikator']  = $detail_verifikator ;
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_tup_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);
                                
                                
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_tup_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_tup_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_tup_model->lihat_ket($kd_unit,$tahun);
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("rsa_tup/spm_tup_verifikator",$subdata,TRUE);
                $this->load->view('main_template',$data);
            } 
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
                }
                
                function spm_tup_kbuu($id_kuitansi){
                    $query = $this->db->query("SELECT * FROM rsa_kuitansi WHERE id_kuitansi='".$id_kuitansi."'")->row_array();
                    $kd_unit = $query['kode_unit'];
                    $tahun = $query['tahun'];
                //set data for main template     
                //$subdata_rsa_up['result_rsa_up']      = $this->rsa_up_model->search_rsa_up();
                                
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
                                
                                //$subdata['alias'] = $this->unit_model->get_alias($kd_unit);// $this->check_session->get_alias();
                               
                                $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($kd_unit,$tahun);
                              
                                $subdata['doc_up'] = $dokumen_tup;
                                
                                $nomor_trx_spp = $this->rsa_tup_model->get_nomor_spp($kd_unit,$tahun); 
                                
//                                echo $nomor_trx_spp ; die;
                                
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
                                
                                if(($dokumen_tup == 'SPP-FINAL') || ($dokumen_tup == 'SPP-DRAFT') || ($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
                                    
                                    $data_spp = $this->rsa_tup_model->get_data_spp($nomor_trx_spp);
//                                    var_dump($data_spp);die;
                                    
                                    $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
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
                                    if( base64_encode(base64_decode($data_url, true)) === $data_url){
                                        $array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                                        $array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                                        $data_ = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'array_id' => json_decode($array_id),
                                            'tahun' => $this->cur_tahun,
                                        );
                                        $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                                    }else{
                                        $pengeluaran = 0;
                                    }
                                    
                                    $subdata['detail_tup']   = array(
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
                                        'npwp_penerima' => $data_spp->npwp,
                                        'nmbendahara' => $data_spp->nmbendahara,
                                        'nipbendahara' => $data_spp->nipbendahara,
                                        
//                                        'tgl_spp' => $data_spp->tgl_spp,
                                        
                                    );



    //                                if(($dokumen_tup == '') || ($dokumen_tup == 'SPP-DITOLAK') || ($dokumen_tup == 'SPM-DITOLAK')){
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
                                
//                                $subdata['tgl_spm'] = $this->rsa_up_model->get_tgl_spm($kd_unit,$tahun);
                                
                                $nomor_trx_spm = '';
                                
                                if(($dokumen_tup == 'SPM-DRAFT-PPK') || ($dokumen_tup == 'SPM-DRAFT-KPA') || ($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_tup == 'SPM-FINAL-KBUU')){
                                    
                                    $nomor_trx_spm = $this->rsa_tup_model->get_nomor_spm($kd_unit,$tahun);  
                                    
                                    $data_spm = $this->rsa_tup_model->get_data_spm($nomor_trx_spm);
                                    $subdata['detail_tup_spm']   = array(
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
//                                        'kode_unit_subunit' => $kd_unit,
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
//                                        'kode_unit_subunit' => $kd_unit,
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
//                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
//                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
//                                }
                                
                                if($pengeluaran > 0){
                                    $data__ = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'tahun' => $tahun,
                                        'array_id' => json_decode($array_id)
                                    );
//                                    print_r($data__);die;
                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__,'TP');
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
                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__,'TP');

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
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
//                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
//                                    
//                                    $nomor_spm_cair_lalu = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
//                                    
//                                    $nomor_spp_cair_lalu = $this->rsa_tup_model->get_spp_by_spm($nomor_spm_cair_lalu);
//                                    
//                                    echo $nomor_spm_cair_lalu; die;
                                    
                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
                                    
                                    $nomor_spm = $this->rsa_tup_model->get_spm_by_spp($nomor_trx_spp);
                                    
//                                    echo $nomor_spm_cair_before; die;
                                    
                                    if(empty($nomor_spm)){
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($kd_unit,$tahun);
                                    
//                                        var_dump($data_akun_before); die;
                                        
                                    }else{
                                        
                                        $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($kd_unit,$tahun);

                                        // echo $nomor_spm_cair_before ; die;
                                        
                                        $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_spm($nomor_spm);

                                        if($nomor_spm_cair_before != $nomor_spm){
                                             $data_akun_before = $this->kuitansi_model->get_tup_akun_before_by_unit($kd_unit,$tahun);
                                        }
                                    }
                                    
                                    
//                                    
//                                    $nomor_spm_cair_before = $this->rsa_tup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
//                                    if($nomor_spp_cair_lalu != $nomor_trx){
//                                        $data_akun_lalu = $this->kuitansi_model->get_tup_akun_lalu($this->check_session->get_unit(),$this->cur_tahun);
                                    
    //                                    echo '<pre>';print_r($data_akun_lalu);echo '</pre>';die;

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

                                            $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___lalu);
                                        
                                        }
                                        
                                        
//                                    }
                                    
                                    
                                    
//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
//                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                                    $rincian_keluaran = $this->rsa_tup_model->get_keluaran($nomor_trx_spp);
                                    
                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
                                }
                                
                                $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                                $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                                $subdata['data_akun_rkat'] = $data_akun_rkat;
                                $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                                $subdata['data_spp_pajak'] = $data_spp_pajak;
                                $subdata['data_rekap_pajak'] = $data_rekap_pajak;
                                $subdata['data_rekap_bruto'] = $data_rekap_bruto;
                                $subdata['rincian_keluaran'] = $rincian_keluaran;
                                $subdata['rel_kuitansi'] = $du;
                                $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                                $subdata['nomor_spp'] = $nomor_trx_spp;
                                
                                $subdata['nomor_spm'] = $nomor_trx_spm;
                                
//                                $subdata['detail_verifikator']  = $this->rsa_up_model->get_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kpa'] = $this->rsa_tup_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_verifikator'] = $this->rsa_tup_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['tgl_spm_kbuu'] = $this->rsa_tup_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);
                                
                                $subdata['ket'] = $this->rsa_tup_model->lihat_ket($kd_unit,$tahun);
                                
                                $this->load->model('akun_kas6_model');
                                
                                $subdata['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();//(array('kd_kas_3'=>'111'));
                                
//                                var_dump( $subdata['kas_undip']);die;
                                
                //$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $data['main_content']           = $this->load->view("akuntansi/spm_tup_kbuu",$subdata,TRUE);
                $data['bukti'] = true;
                $data['content'] = '';
                $this->load->view('akuntansi/content_template',$data);
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
                
                function usulkan_spp_tup(){
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

    //                            echo $rel_kuitansi; die;

    //                            die;
                               // var_dump($data);die;

                                $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($kd_unit,$tahun);
                                
                                if($dokumen_tup == 'SPM-FINAL-KBUU'){
                                    $dokumen_tup = '' ;
                                }

                                if(($dokumen_tup == '')||($dokumen_tup == 'SPP-DITOLAK')||($dokumen_tup == 'SPM-DITOLAK-KPA')||($dokumen_tup == 'SPM-DITOLAK-VERIFIKATOR')||($dokumen_tup == 'SPM-DITOLAK-KBUU')){


                                    if($this->rsa_tup_model->proses_nomor_spp_tup($kd_unit,$data)){

                                        $data_spp = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'nomor_trx_spp' => $this->rsa_tup_model->get_id_nomor_tup($jenis,$kd_unit,$this->cur_tahun),
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
                                            'data_kuitansi' => $rel_kuitansi,
                                            'jumlah_pengembalian' => $this->input->post('jumlah_pengembalian'),
                                            'data_kuitansi_pengembalian' => $rel_kuitansi_pengembalian,
                                        );



                                        $data = array(
                                            'kode_unit_subunit' => $kd_unit,
                                            'posisi' => $proses,
                                            'id_trx_nomor_tup' => $this->rsa_tup_model->get_id_nomor_tup($jenis,$kd_unit,$this->cur_tahun),
                                            'ket' => $ket,
                                            'aktif' => '1',
                                            'tahun' => $tahun,
                                            'tgl_proses' => date("Y-m-d H:i:s")
                                        );

            //                            var_dump($data);die;

                                        if($this->rsa_tup_model->proses_tup($kd_unit,$data) && $this->rsa_tup_model->proses_data_spp($data_spp)){
                                            $keluaran = json_decode($this->input->post('keluaran'));
                                            $data = array();
                                            foreach($keluaran as $kel){
                                                if(!empty($kel)){
                                                    $data[] = array(
                                                        'str_nomor_trx_spp' => $nomor_trx,
                                                        'kode_usulan_rka' => $kel[0],
                                                        'jenis' => 'TUP',
                                                        'keluaran' => $kel[1],
                                                        'volume' => $kel[2],
                                                        'satuan' => $kel[3],
                                                        'kode_unit_subunit' => $kd_unit,
                                                        'tahun' => $this->cur_tahun,
                                                        'tgl_proses' => date("Y-m-d H:i:s"),
                                                    );
                                                }
                                            }

                                            $this->rsa_tup_model->insert_keluaran($data);

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

                                            $this->rsa_tup_model->proses_tup_spp_rka($data);

                                            $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM TUP-NIHIL anda berhasil disubmit.</div>');
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
                
                function usulkan_spm_tup(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14))){
                        if($this->input->post('proses')){
                            $proses = $this->input->post('proses');
                            $nomor_trx = $this->input->post('nomor_trx');
                            $nomor_trx_spp = $this->input->post('nomor_trx_spp');
                            $nomor_ = explode('/',$nomor_trx);
                            $bulan = $nomor_[3];

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
                            
                            
                            $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($kd_unit,$tahun);
                            
                            if($dokumen_tup == 'SPP-FINAL'){
                                
                                if($this->rsa_tup_model->proses_nomor_spm_tup($kd_unit,$data) ){
                                    $data_spm = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'nomor_trx_spm' => $this->rsa_tup_model->get_id_nomor_tup($jenis,$kd_unit,$this->cur_tahun),
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
                                        'data_kuitansi' => $rel_kuitansi,
                                        'jumlah_pengembalian' => $this->input->post('jumlah_pengembalian'),
                                        'data_kuitansi_pengembalian' => $rel_kuitansi_pengembalian,
                                    );
//                                    var_dump($data_spm);die;
                                    $data_spp_spm = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'nomor_trx_spp' => $this->rsa_tup_model->get_id_nomor_tup('SPP',$kd_unit,$this->cur_tahun),//$nomor_spp_[0],$this->rsa_up_model->get_id_nomor_up($jenis,$kd_unit,$this->cur_tahun),
                                        'str_nomor_trx_spp' => $nomor_trx_spp,
                                        'nomor_trx_spm' => $this->rsa_tup_model->get_id_nomor_tup('SPM',$kd_unit,$this->cur_tahun),//$nomor_[0],
                                        'str_nomor_trx_spm' =>$nomor_trx,
                                        'jenis_trx' => 'TUP',
                                        'tahun' => $tahun,
                                    );
                                    $data = array(
                                        'kode_unit_subunit' => $kd_unit,
                                        'posisi' => $proses,
                                        'id_trx_nomor_tup' => $this->rsa_tup_model->get_id_nomor_tup($jenis,$kd_unit,$this->cur_tahun),
                                        'ket' => $ket,
                                        'aktif' => '1',
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );

                                    if($this->rsa_tup_model->proses_tup($kd_unit,$data)&& $this->rsa_tup_model->proses_trx_spp_spm($data_spp_spm) && $this->rsa_tup_model->proses_data_spm($data_spm)){

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

                                        $this->rsa_tup_model->proses_tup_spm_rka($data);
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM TUP-NIHIL anda berhasil disubmit.</div>');
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
                
                function proses_spp_tup(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $jenis = $this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                        
                        if($this->input->post('rel_kuitansi')){
                            $rel_kuitansi_ = $this->input->post('rel_kuitansi');
                            $rel_kuitansi = urldecode($rel_kuitansi_);
                            if( base64_encode(base64_decode($rel_kuitansi, true)) === $rel_kuitansi){
                                $rel_kuitansi = base64_decode($rel_kuitansi);
                            }else{
                                redirect(site_url('/'));
                            }
                        }
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                'id_trx_nomor_tup' => $this->rsa_tup_model->get_id_nomor_tup($jenis,$kd_unit,$this->cur_tahun),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );
                            
//                            var_dump($data);die;
                        
                        $ok = FALSE ;
                            
                        $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($kd_unit,$tahun);
                        
                        if(($proses == 'SPP-FINAL')&&($dokumen_tup == 'SPP-DRAFT')){
                            $ok = TRUE ;
                        }elseif(($proses == 'SPP-DITOLAK')&&($dokumen_tup == 'SPP-DRAFT')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }
                        
                        if($ok){
//                            echo 'jos'; die;
                            if($this->rsa_tup_model->proses_tup($kd_unit,$data)){
                                if($proses == 'SPP-DITOLAK'){
                                    
                                    $data = array(
                                        'str_nomor_trx' => $nomor_trx,
                                        'rel_kuitansi' => $rel_kuitansi,
                                    );
                                    $this->rsa_tup_model->tolak_tup_spp_rka($data);
                                    $data = array(
                                        'rel_kuitansi' => $rel_kuitansi,
//                                        'str_nomor_trx' => $nomor_trx,
                                    );
                                    $this->load->model('kuitansi_model');
                                    $this->kuitansi_model->tolak_spp($data);
                                }
                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM TUP-NIHIL anda berhasil disubmit.</div>');
                                echo "sukses";
                            }else{
                                echo "gagal";
                            }
                        }else{
                            echo "gagal";
                        }

                        
                        
                    }
                }
                
                function proses_spm_tup(){
                    if($this->input->post('proses')){
                        $proses = $this->input->post('proses');
                        $nomor_trx = $this->input->post('nomor_trx');
                        $nomor_ = explode('/',$nomor_trx);
                        $jenis = 'SPM';//$this->input->post('jenis');
                        $ket = $this->input->post('ket')?$this->input->post('ket'):'';
                        $kd_unit = $this->check_session->get_unit()=='99'?$this->input->post('kd_unit'):$this->check_session->get_unit();
                        $tahun = $this->input->post('tahun')?$this->input->post('tahun'):$this->cur_tahun;
                        
                        if($this->input->post('rel_kuitansi')){
                            $rel_kuitansi_ = $this->input->post('rel_kuitansi');
                            $rel_kuitansi = urldecode($rel_kuitansi_);
                            if( base64_encode(base64_decode($rel_kuitansi, true)) === $rel_kuitansi){
                                $rel_kuitansi = base64_decode($rel_kuitansi);
                            }else{
                                redirect(site_url('/'));
                            }
                        }
                        
                            
                            $data = array(
                                'kode_unit_subunit' => $kd_unit,
                                'posisi' => $proses,
                                'id_trx_nomor_tup' => $this->rsa_tup_model->get_id_nomor_tup($jenis,$kd_unit,$this->cur_tahun),
                                'ket' => $ket,
                                'aktif' => '1',
                                'tahun' => $tahun,
                                'tgl_proses' => date("Y-m-d H:i:s")
                            );
                            
//                            var_dump($data);die;
                            
                            $ok = FALSE ;
                            
                            $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($kd_unit,$tahun);

                            if(($proses == 'SPM-DRAFT-KPA')&&($dokumen_tup == 'SPM-DRAFT-PPK')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-DITOLAK-KPA')&&($dokumen_tup == 'SPM-DRAFT-PPK')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-FINAL-VERIFIKATOR')&&($dokumen_tup == 'SPM-DRAFT-KPA')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-DITOLAK-VERIFIKATOR')&&($dokumen_tup == 'SPM-DRAFT-KPA')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-FINAL-KBUU')&&($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-DITOLAK-KBUU')&&($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-FINAL-BUU')&&($dokumen_tup == 'SPM-FINAL-KBUU')){
                                $ok = TRUE ;
                            }elseif(($proses == 'SPM-DITOLAK-BUU')&&($dokumen_tup == 'SPM-FINAL-KBUU')){
                                $ok = TRUE ;
                            }else{
                                $ok = FALSE;
                            }
                            
                            
//                            echo $proses ; die;
                            
                            if($ok){
//                            echo 'jos';die;
                            $nomor_trx_spm = $this->rsa_tup_model->get_id_nomor_tup('SPM',$kd_unit,$tahun);
                            
                            if($this->rsa_tup_model->proses_tup($kd_unit,$data)){
                                if(substr($proses,0,11) == 'SPM-DITOLAK'){
                                    
                                    $data = array(
                                        'str_nomor_trx_spm' => $nomor_trx,
                                        'rel_kuitansi' => $rel_kuitansi,
                                    );
//                                    var_dump(base64_decode(urldecode($rel_kuitansi)));die;
                                    $this->rsa_tup_model->tolak_tup_spm_rka($data);
                                    $data = array(
                                        'rel_kuitansi' => $rel_kuitansi,
//                                        'str_nomor_trx' => $nomor_trx,
                                    );
                                    $this->load->model('kuitansi_model');
                                    $this->kuitansi_model->tolak_spm($data);
                                }
                                if($this->check_session->get_level() == 3){
                                    $verifikator = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
                                    $data_verifikator = array(
                                        'nomor_trx_spm' => $nomor_trx_spm,
                                        'str_nomor_trx_spm' => $nomor_trx,
                                        'kode_unit_subunit' => $kd_unit,
                                        'jenis_trx' => 'GUP',
                                        'id_rsa_user_verifikator' => $verifikator->id,
                                        'tahun' => $tahun,
                                        'tgl_proses' => date("Y-m-d H:i:s")
                                    );
                                    if($this->rsa_tup_model->proses_verifikator_tup($data_verifikator)){
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM TUP-NIHIL anda berhasil disubmit.</div>');
                                        echo "sukses";
                                    }else{
                                        echo "gagal";
                                    }
                                }else{
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM TUP-NIHIL anda berhasil disubmit.</div>');
                                    echo "sukses";
                                }
                            }else{
                                echo "gagal";
                            }
                            
                        }

                        
                        
                    }
                }

                // function tes_(){

                //     $data_tup_to_nihil = array(
                //                     'kode_unit_subunit' => '71',
                //                     'str_nomor_trx_spm_tup' => '00003/LPM/SPM-TUP-NIHIL/JUN/2017',
                //                     'tgl_proses_tup' => '2017-07-10 14:22:47',
                //                     'tahun' => '2017',
                //                     'status' => '1',
                //                 );

                //     // var_dump($data_tup_to_nihil) ; die ;

                //     var_dump($this->rsa_tup_model->tup_to_nihil($data_tup_to_nihil)) ; die ;
                // }
                
                function proses_final_tup(){
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
                        
                        $data = array(
                            'kode_unit_subunit' => $kd_unit,
                            'id_trx_nomor_tup' => $this->rsa_tup_model->get_id_nomor_tup('SPM',$kd_unit,$this->input->post('tahun')),
                            'posisi' => $proses,
                            'ket' => $ket,
                            'aktif' => '1',
                            'tahun' => $this->input->post('tahun'),
                            'tgl_proses' => date("Y-m-d H:i:s")
                        );
                        
                        $ok = FALSE ;
                            
                        $dokumen_tup = $this->rsa_tup_model->check_dokumen_tup($kd_unit,$this->input->post('tahun'));
                        
                        if(($proses == 'SPM-FINAL-KBUU')&&($dokumen_tup == 'SPM-FINAL-VERIFIKATOR')){
                            $ok = TRUE ;
                        }else{
                            $ok = FALSE;
                        }
                            
                        if($ok){
                            
//                            echo $proses;die;
//                            $this->load->model('kas_bendahara_model');
//                            $saldo_ben = $this->kas_bendahara_model->get_kas_bendahara($kd_unit,$this->input->post('tahun'));
//                            echo $saldo_ben->saldo;die;
                            
                            if($this->rsa_tup_model->proses_tup($kd_unit,$data)){
                                
                                $this->load->model('kas_bendahara_model');
                                $saldo_ben = $this->kas_bendahara_model->get_kas_bendahara_tup($kd_unit,$this->input->post('tahun'));

                                $data_kredit = array(
                                    'tgl_trx' => date("Y-m-d H:i:s"),
                                    'kd_akun_kas' => '112111',
                                    'kd_unit' => $kd_unit,
                                    'deskripsi' => 'KREDIT TUP UNIT ' . $kd_unit,//$this->input->post('deskripsi'),
                                    'jenis' => 'TP',
                                    'no_spm' => $this->input->post('nomor_trx'),
                                    'kredit' => $this->input->post('kredit'),
                                    'debet' => '0',
                                    'saldo' => '0', // $saldo_ben->saldo - $this->input->post('kredit'), // DI '0' KAN KARENA AKAN DIKEMBALIKAN
                                    'aktif' => '2',
                                    'tahun' => $this->input->post('tahun'),
                                );

                                $pengembalian = $saldo_ben->saldo - $this->input->post('kredit') ; // PENGEMBALIAN KE AKUN UNDIP

                                $this->load->model('kas_undip_model');
                                $kd_akun_kas = $this->input->post('kd_akun_kas') ;
                                $nominal = $this->input->post('nominal') ;
                                $saldo = $this->kas_undip_model->get_nominal($kd_akun_kas) ; // - $nominal ;

                                $data_kas = array(
                                    'tgl_trx' => date('Y-m-d H:i:s'),
                                    'kd_akun_kas' => $kd_akun_kas,
                                    'kd_unit' => $kd_unit,//'99',
                                    'deskripsi' => 'PENGEMBALIAN TUP ( TUP-NIHIL ) UNIT ' . $kd_unit,
                                    'no_spm' => $this->input->post('nomor_trx'),
                                    'debet' => $pengembalian ,
                                    'kredit' => '0',
                                    'saldo' => $saldo + $pengembalian,
                                    'aktif' => '1',
                                    'tahun' => $this->input->post('tahun'),
                                );

                                $data_spm_cair = array(
                                    'no_urut' => $this->rsa_tup_model->get_next_urut_spm_cair($this->input->post('tahun')),
//                                    'nomor_trx_spm' => $this->rsa_up_model->get_id_nomor_up('SPM',$kd_unit,$this->input->post('tahun')),//,$nomor,
                                    'str_nomor_trx_spm' => $nomor_trx_spm,
                                    'str_nomor_trx_spp' => $this->rsa_tup_model->get_spp_by_spm($nomor_trx_spm),
                                    'kode_unit_subunit' => $kd_unit,
                                    'jenis_trx' => 'TUP-NIHIL',
                                    'nominal' => $nominal,
                                    'tgl_proses' => date('Y-m-d H:i:s'),
                                    'bulan' => $nomor_[3],
                                    'tahun' => $this->input->post('tahun')
                                );

    //                            var_dump($data_spm_cair);die;

                                $data_tup_to_nihil = array(
                                    'kode_unit_subunit' => $kd_unit,
                                    'str_nomor_trx_spm_tup' => $nomor_trx_spm,
                                    'tgl_proses_tup' => date('Y-m-d H:i:s'),
                                    'tahun' => $this->input->post('tahun'),
                                    'status' => '0',
                                );

                                if($this->rsa_tup_model->final_tup($kd_unit,$data_kredit) && $this->kas_undip_model->isi_trx($data_kas) && $this->rsa_tup_model->spm_cair($data_spm_cair) && $this->rsa_tup_model->tup_to_nihil($data_tup_to_nihil)){
                                    
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
                                    
                                    // $this->rsa_tup_model->final_tup($kd_unit,$data_debet);
                                    
                                    $data = array(
                                        'rel_kuitansi' => $rel_kuitansi,
                                        'str_nomor_trx_spm' => $this->input->post('nomor_trx'),
                                    );

                                    $this->load->model('kuitansi_model');
                                    $this->kuitansi_model->set_cair($data);

                                    $this->rsa_tup_model->proses_tup_cair_rka($data);

                                            
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> SPP/SPM TUP-NIHIL anda berhasil disubmit.</div>');
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
                            $subdata['daftar_spp']          = $this->rsa_tup_model->get_daftar_spp($kode_unit_subunit,$tahun);
//                            echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("rsa_tup/daftar_spp",$subdata,TRUE);
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
                            $subdata['daftar_spm']          = $this->rsa_tup_model->get_daftar_spm($kode_unit_subunit,$tahun);
//                            echo '<pre>';var_dump($subdata['daftar_spp']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("rsa_tup/daftar_spm",$subdata,TRUE);
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

                        $notif = $this->rsa_tup_model->get_notif_approve($kode_unit_subunit,$level,$user->id);

                        echo $notif ;
                    }

                }

                function get_notif_approve_all(){

                    if($this->check_session->user_session()){

                        $level = $this->check_session->get_level() ;

                        $kode_unit_subunit = $this->check_session->get_unit();

                        $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());

                        $notif_tup = $this->rsa_tup_model->get_notif_approve($kode_unit_subunit,$level,$user->id);

                        $notif_tambah_tup = $this->rsa_tambah_tup_model->get_notif_approve($kode_unit_subunit,$level,$user->id);

                        echo $notif_tup + $notif_tambah_tup ;
                    }

                }
                
        
    }

?>
