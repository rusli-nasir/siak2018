<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Kuitansi extends CI_Controller {
    
    private $cur_tahun = '' ;
	
    public function __construct()
    {
            parent::__construct();
            
            $this->cur_tahun = $this->setting_model->get_tahun();
            
            if ($this->check_session->user_session()){
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model('kuitansi_model');
        $this->load->model('kuitansipengembalian_model');
        $this->load->model('rsa_ks_model');
		$this->load->model('menu_model');
		$this->load->model('unit_model');
		$this->load->model('subunit_model');
		$this->load->model('master_unit_model'); 
            }else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}
	
/* -------------- Method ------------- */
	function index()
	{
		/* check session	*/
		if($this->check_session->user_session()){
			redirect('kuitansi/daftar_kuitansi/','refresh');
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}
        
        function submit_kuitansi(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){

                // die;

                $this->load->model('tor_model');

                // die;

                // echo $this->input->post('pajak_kode_usulan'); die;


                $pajak_kode_usulan_ = json_decode($this->input->post('pajak_kode_usulan'));


                $ok = TRUE ;

                foreach($pajak_kode_usulan_ as $pajak_kode_usulan ){
                    $data_ = $this->tor_model->get_status_dpa($pajak_kode_usulan,$this->input->post('sumber_dana'),$this->cur_tahun);
                    $c = count($data_);
                    if($c > 0){
                        if($data_[$c-1]['aktif']=='1'){
                            $ok = FALSE ;
                            break;
                        }
                    }

                }




                if(!$ok){

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi gagal disubmit, silahkan coba lagi.</div>');

                    echo 'gagal';

                    die;

                }

                $total_dpa = 0 ;

                /* KONDISI DIBAWAH DI MATIKAN KARENA AGAR BISA MEMBUAT KUITANSI SEBANYAK BANYAK NYA */

//                 if($ok){

//                     $saldo = get_saldo_up($this->check_session->get_unit(),$this->cur_tahun);

//                     foreach($pajak_kode_usulan_ as $pajak_kode_usulan ){
                    
// //                    get_single_detail_rsa_dpa($kode_usulan_belanja,$kode_akun_tambah,$sumber_dana,$tahun){
//                         $detail_belanja = $this->tor_model->get_single_detail_rsa_dpa(substr($pajak_kode_usulan,0,24),substr($pajak_kode_usulan,24,3),$this->input->post('sumber_dana'),$this->cur_tahun);

//                         $total_dpa = $total_dpa + ( $detail_belanja->harga_satuan * $detail_belanja->volume ) ;
//                     }

//                     if($saldo < $total_dpa){
//                         $ok = FALSE ;
//                         // break;
//                     }

//                 }

                /* END KONSISI */

                //  echo $ok ; die ; 
 

                if(!$ok){

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi gagal disubmit, silahkan coba lagi.</div>');

                    echo 'gagal';

                    die;

                }


                $kode_akun_tambah = json_decode($this->input->post('kode_akun_tambah'));
                $kode_usulan_belanja = $this->input->post('kode_usulan_belanja');
                
                $data_id_kuitansi = array(
//                        'jenis' => $this->input->post('jenis'),
                        'tahun' => $this->cur_tahun ,
//                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'alias' => $this->check_session->get_alias(),
                    );

                $no_bukti = $this->kuitansi_model->get_next_id($data_id_kuitansi);
                
                
//                var_dump($this->input->post());die;
                
                // KUITANSI MAX < 50 JT
                
//                $data = array();
//                $i = 0 ;
//                foreach($kode_akun_tambah as $k){
                    $data= array(
                        'kode_unit' => $this->check_session->get_unit(),
                        'kode_usulan_belanja' => $kode_usulan_belanja,
                        'kode_akun4digit' => substr($kode_usulan_belanja,18,4),
                        // 'kode_akun5digit' => substr($kode_usulan_belanja,18,5),
                        // 'kode_akun' => substr($kode_usulan_belanja,18,6),
                        'jenis' => $this->input->post('jenis'),
                        'no_bukti' => $no_bukti,
                        'uraian' => $this->input->post('uraian'),
                        'tgl_kuitansi' => date("Y-m-d H:i:s"),
                        'tahun' => $this->cur_tahun,
                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'penerima_uang' => $this->input->post('penerima_uang'),
                        'penerima_uang_nip' =>  $this->input->post('penerima_uang_nip'),
                        'penerima_barang' => $this->input->post('penerima_barang'),
                        'penerima_barang_nip' => $this->input->post('penerima_barang_nip'),
                        'nmpppk' => $this->input->post('nmpppk'),
                        'nippppk' => $this->input->post('nippppk'),
                        'nmbendahara' => $this->input->post('nmbendahara'),
                        'nipbendahara' => $this->input->post('nipbendahara'),
                        'nmpumk' => $this->input->post('nmpumk'),
                        'nippumk' => $this->input->post('nippumk'),
                        'aktif' => '1',
                        'cair' => '0',
  
                    );

//                    $this->kuitansi_model->insert_data_kuitansi($data);die;
//                    var_dump($data);die;
//                    $i++;
//                    
//                }

                $id_kuitansi = $this->kuitansi_model->insert_data_kuitansi($data);
                
                $pajak_kode_usulan_ = json_decode($this->input->post('pajak_kode_usulan'));
                $pajak_id_input_ = json_decode($this->input->post('pajak_id_input'));
                $pajak_jenis_ = json_decode($this->input->post('pajak_jenis'));
                $pajak_dpp_ = json_decode($this->input->post('pajak_dpp'));
                $pajak_persen_ = json_decode($this->input->post('pajak_persen'));
                $pajak_nilai_ = json_decode($this->input->post('pajak_nilai'));
//                var_dump($pajak_id_input_);
//                var_dump($pajak_jenis_);
                $ii = 0 ;
                
                foreach($pajak_kode_usulan_ as $pajak_kode_usulan ){
                    
//                    get_single_detail_rsa_dpa($kode_usulan_belanja,$kode_akun_tambah,$sumber_dana,$tahun){
                    $detail_belanja = $this->tor_model->get_single_detail_rsa_dpa(substr($pajak_kode_usulan,0,24),substr($pajak_kode_usulan,24,3),$this->input->post('sumber_dana'),$this->cur_tahun);
                    $data = array(
                        'id_kuitansi' => $id_kuitansi,
                        'no_bukti' => $no_bukti,//$this->input->post('no_bukti'),
                        'kode_usulan_belanja' => substr($pajak_kode_usulan,0,24),
                        'kode_akun_tambah' => substr($pajak_kode_usulan,24,3),
                        'deskripsi' => $detail_belanja->deskripsi,
                        'volume' => $detail_belanja->volume,
                        'satuan' => $detail_belanja->satuan,
                        'harga_satuan' => $detail_belanja->harga_satuan,
                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'tahun' => $this->cur_tahun,
                    );
                    $id_kuitansi_detail = $this->kuitansi_model->insert_data_usulan($data);
//                    $i = 0;
                  if(!empty($pajak_id_input_[$ii])){  
                        foreach($pajak_id_input_[$ii] as $k => $pajak_id_input ){
//                            if(!empty($pajak_id_input)){
//                                $i = 0;
//                                var_dump($pajak_id_input);
//                                foreach($pajak_id_input as $j => $p){
                            $v = $pajak_jenis_[$ii][$k];
                            if($v == 'ppn'){$v = 'PPN';}
                            else if($v == 'pphps21'){
                                    if ($pajak_id_input == '51'){
                                        $v = 'Tabungan Pajak';
                                    }elseif ($pajak_id_input == '52'){
                                        $v = 'Potongan Pajak';
                                    }else{
                                        $v = 'PPh_Ps_21';
                                    }
                                }
                            else if($v == 'pphps22'){$v = 'PPh_Ps_22';}
                            else if($v == 'pphps23'){$v = 'PPh_Ps_23';}
                            else if($v == 'pphps26'){$v = 'PPh_Ps_26';}
                            else if($v == 'pphps42'){$v = 'PPh_Ps_4(2)';}
                            else if($v == 'lainnya'){$v = 'Lainnya';}
                                    
                            $jenis_pajak = $v;
                            
                                    $data = array(
                                        'id_kuitansi_detail' => $id_kuitansi_detail,
                                        'no_bukti' => $no_bukti,//$this->input->post('no_bukti'),
                                        'id_input_pajak' => $pajak_id_input,
                                        'jenis_pajak' => $jenis_pajak,
                                        'dpp' => $pajak_dpp_[$ii][$k],
                                        'persen_pajak' => $pajak_persen_[$ii][$k],
                                        'rupiah_pajak' => str_replace(".","",$pajak_nilai_[$ii][$k]),
                                    );
                                    $this->kuitansi_model->insert_data_pajak($data);
//                                    $i++;  
//                                }
//                            }
                            
                        }
                    }
                    
//                    var_dump($id_kuitansi_detail);die;
                    $ii++ ;
                }
                
                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi telah disubmit.</div>');

                echo 'sukses';
                
//                var_dump($id_kuitansi);die;
//                die;
//                if($this->kuitansi_model->insert_data($data)){
//                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi telah disubmit.</div>');
//                    echo 'sukses';
//                }else{
//                    echo 'gagal';
//                }
            }
            else{
                redirect('welcome','refresh');	// redirect ke halaman home
            }
        }

        function submit_kuitansi_pengembalian(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){

                // $this->load->model('tor_model');

                // die;

                // echo $this->input->post('pajak_kode_usulan'); die;

                // echo "<pre>";
                // var_dump($this->input->post());
                // die;


                $pajak_kode_usulan_ = json_decode($this->input->post('pajak_kode_usulan'));


                $ok = TRUE ;

                // foreach($pajak_kode_usulan_ as $pajak_kode_usulan ){
                //     $data_ = $this->tor_model->get_status_dpa($pajak_kode_usulan,$this->input->post('sumber_dana'),$this->cur_tahun);
                //     $c = count($data_);
                //     if($c > 0){
                //         if($data_[$c-1]['aktif']=='1'){
                //             $ok = FALSE ;
                //             break;
                //         }
                //     }

                // }




                // if(!$ok){

                //     $this->session->set_flashdata('message', '<div class="alert alert-danger" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi gagal disubmit, silahkan coba lagi.</div>');

                //     echo 'gagal';

                //     die;

                // }

                $total_dpa = 0 ;

                /* KONDISI DIBAWAH DI MATIKAN KARENA AGAR BISA MEMBUAT KUITANSI SEBANYAK BANYAK NYA */

//                 if($ok){

//                     $saldo = get_saldo_up($this->check_session->get_unit(),$this->cur_tahun);

//                     foreach($pajak_kode_usulan_ as $pajak_kode_usulan ){
                    
// //                    get_single_detail_rsa_dpa($kode_usulan_belanja,$kode_akun_tambah,$sumber_dana,$tahun){
//                         $detail_belanja = $this->tor_model->get_single_detail_rsa_dpa(substr($pajak_kode_usulan,0,24),substr($pajak_kode_usulan,24,3),$this->input->post('sumber_dana'),$this->cur_tahun);

//                         $total_dpa = $total_dpa + ( $detail_belanja->harga_satuan * $detail_belanja->volume ) ;
//                     }

//                     if($saldo < $total_dpa){
//                         $ok = FALSE ;
//                         // break;
//                     }

//                 }

                /* END KONSISI */

                //  echo $ok ; die ; 
 

                // if(!$ok){

                //     $this->session->set_flashdata('message', '<div class="alert alert-danger" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi gagal disubmit, silahkan coba lagi.</div>');

                //     echo 'gagal';

                //     die;

                // }


                $kode_akun_tambah = json_decode($this->input->post('kode_akun_tambah'));
                $kode_usulan_belanja = $this->input->post('kode_usulan_belanja');
                
                $data_id_kuitansi = array(
//                        'jenis' => $this->input->post('jenis'),
                        'tahun' => $this->cur_tahun ,
//                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'alias' => $this->check_session->get_alias(),
                    );

                // $no_bukti = $this->kuitansi_model->get_next_id($data_id_kuitansi);

                $no_bukti = $this->kuitansipengembalian_model->get_next_id($data_id_kuitansi);

                // $next_id = $next_id . 'P' ;
                
                
//                var_dump($this->input->post());die;
                
                // KUITANSI MAX < 50 JT
                
//                $data = array();
//                $i = 0 ;
//                foreach($kode_akun_tambah as $k){
                    $data= array(
                        'kode_unit' => $this->check_session->get_unit(),
                        'kode_usulan_belanja' => $kode_usulan_belanja,
                        'kode_akun4digit' => substr($kode_usulan_belanja,18,4),
                        'jenis' => $this->input->post('jenis'),
                        'no_bukti' => $no_bukti,
                        'uraian' => $this->input->post('uraian'),
                        'tgl_kuitansi' => date("Y-m-d H:i:s"),
                        'tahun' => $this->cur_tahun,
                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'penerima_uang' => $this->input->post('penerima_uang'),
                        'penerima_uang_nip' =>  $this->input->post('penerima_uang_nip'),
                        'penerima_barang' => $this->input->post('penerima_barang'),
                        'penerima_barang_nip' => $this->input->post('penerima_barang_nip'),
                        'nmpppk' => $this->input->post('nmpppk'),
                        'nippppk' => $this->input->post('nippppk'),
                        'nmbendahara' => $this->input->post('nmbendahara'),
                        'nipbendahara' => $this->input->post('nipbendahara'),
                        'nmpumk' => $this->input->post('nmpumk'),
                        'nippumk' => $this->input->post('nippumk'),
                        'aktif' => '1',
                        'cair' => '0',
  
                    );

//                    $this->kuitansi_model->insert_data_kuitansi($data);die;
//                    var_dump($data);die;
//                    $i++;
//                    
//                }

                $id_kuitansi = $this->kuitansipengembalian_model->insert_data_kuitansi($data);
                
                $pajak_kode_usulan_ = json_decode($this->input->post('pajak_kode_usulan'));
                $pajak_id_input_ = json_decode($this->input->post('pajak_id_input'));
                $pajak_jenis_ = json_decode($this->input->post('pajak_jenis'));
                $pajak_dpp_ = json_decode($this->input->post('pajak_dpp'));
                $pajak_persen_ = json_decode($this->input->post('pajak_persen'));
                $pajak_nilai_ = json_decode($this->input->post('pajak_nilai'));
//                var_dump($pajak_id_input_);
//                var_dump($pajak_jenis_);
                $ii = 0 ;
                
                foreach($pajak_kode_usulan_ as $pajak_kode_usulan ){
                    
//                    get_single_detail_rsa_dpa($kode_usulan_belanja,$kode_akun_tambah,$sumber_dana,$tahun){
                    // $detail_belanja = $this->tor_model->get_single_detail_rsa_dpa(substr($pajak_kode_usulan,0,24),substr($pajak_kode_usulan,24,3),$this->input->post('sumber_dana'),$this->cur_tahun);

                    $detail_belanja = json_decode($this->input->post('data_detail')) ;

                    $data = array(
                        'id_kuitansi' => $id_kuitansi,
                        'no_bukti' => $no_bukti,//$this->input->post('no_bukti'),
                        'kode_usulan_belanja' => substr($pajak_kode_usulan,0,24),
                        'kode_akun_tambah' => substr($pajak_kode_usulan,24,3),
                        'deskripsi' => $detail_belanja->deskripsi,
                        'volume' => $detail_belanja->volume,
                        'satuan' => $detail_belanja->satuan,
                        'harga_satuan' => $detail_belanja->harga_satuan,
                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'tahun' => $this->cur_tahun,
                    );
                    $id_kuitansi_detail = $this->kuitansipengembalian_model->insert_data_usulan($data);
//                    $i = 0;
                  if(!empty($pajak_id_input_[$ii])){  
                        foreach($pajak_id_input_[$ii] as $k => $pajak_id_input ){
//                            if(!empty($pajak_id_input)){
//                                $i = 0;
//                                var_dump($pajak_id_input);
//                                foreach($pajak_id_input as $j => $p){
                            $v = $pajak_jenis_[$ii][$k];
                            if($v == 'ppn'){$v = 'PPN';}
                            else if($v == 'pphps21'){$v = 'PPh_Ps_21';}
                            else if($v == 'pphps22'){$v = 'PPh_Ps_22';}
                            else if($v == 'pphps23'){$v = 'PPh_Ps_23';}
                            else if($v == 'pphps26'){$v = 'PPh_Ps_26';}
                            else if($v == 'pphps42'){$v = 'PPh_Ps_4(2)';}
                            else if($v == 'lainnya'){$v = 'Lainnya';}
                                    
                            $jenis_pajak = $v;
                            
                                    $data = array(
                                        'id_kuitansi_detail' => $id_kuitansi_detail,
                                        'no_bukti' => $no_bukti,//$this->input->post('no_bukti'),
                                        'id_input_pajak' => $pajak_id_input,
                                        'jenis_pajak' => $jenis_pajak,
                                        'dpp' => $pajak_dpp_[$ii][$k],
                                        'persen_pajak' => $pajak_persen_[$ii][$k],
                                        'rupiah_pajak' => str_replace(".","",$pajak_nilai_[$ii][$k]),
                                    );
                                    $this->kuitansi_model->insert_data_pajak($data);
//                                    $i++;  
//                                }
//                            }
                            
                        }
                    }
                    
//                    var_dump($id_kuitansi_detail);die;
                    $ii++ ;
                }
                
                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi Pengembalian telah disubmit.</div>');

                echo 'sukses';
                
//                var_dump($id_kuitansi);die;
//                die;
//                if($this->kuitansi_model->insert_data($data)){
//                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi telah disubmit.</div>');
//                    echo 'sukses';
//                }else{
//                    echo 'gagal';
//                }
            }
            else{
                redirect('welcome','refresh');  // redirect ke halaman home
            }
        }
        
        function get_next_id(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                    $data = array(
//                        'jenis' => $this->input->post('jenis'),
                        'tahun' => $this->cur_tahun ,
//                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'alias' => $this->input->post('alias'),
                    );
                    echo $this->kuitansi_model->get_next_id($data);
            }
            else{
                redirect('welcome','refresh');	// redirect ke halaman home
            }
        }
        
        function daftar_kuitansi($jenis='',$tahun="",$kode_unit_subunit="",$enc_str_no_spm=""){
                    
                    if($kode_unit_subunit == ''){
                        $kode_unit_subunit = $this->check_session->get_unit();
                    }
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
                    
                    if($jenis==''){
                        redirect('dashboard','refresh');	// redirect ke halaman home
                    }else{
                        if($jenis=='KS'){

                            if($enc_str_no_spm != ''){

                                $enc_str_no_spm = urldecode($enc_str_no_spm);

                                if( base64_encode(base64_decode($enc_str_no_spm, true)) === $enc_str_no_spm){
                                    $enc_str_no_spm = base64_decode($enc_str_no_spm);
                                }else{
                                    redirect(site_url('/'));
                                }

                                $subdata['no_spm_ks'] = $enc_str_no_spm ;
                                $this->load->model('kas_bendahara_model');
                                $nilai_spm = $this->rsa_ks_model->get_kas_bendahara_by_spm($enc_str_no_spm);
                                // echo $nilai_spm; die;
                                $subdata['nilai_spm'] = $nilai_spm ;
                                // echo $enc_str_no_spm ; die;

                                // echo $enc_str_no_spm ; die ;

                            }else{

                                $subdata['no_spm_ks'] = '-' ;
                                $subdata['nilai_spm'] = '0' ;

                            }

                        } else if($jenis=='TP'){
                            $this->load->model('kas_bendahara_model');
                            $subdata['no_spm_tup'] = $this->kas_bendahara_model->get_last_spm_tup_cair($kode_unit_subunit,$this->cur_tahun);
                        } else if($jenis=='GP'){
                            $this->load->model('kas_bendahara_model');
                            $subdata['no_spm_gup'] = $this->kas_bendahara_model->get_last_spm_gup_cair($kode_unit_subunit,$this->cur_tahun);
                        }
                    }

                    /* check session	*/
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
//                            if(strlen($kode_unit_subunit)==2){
//                                $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
//                            }
//                            elseif(strlen($kode_unit_subunit)==4){
//                                    $subdata['nm_unit']         = $this->unit_model->get_nama($kode_unit_subunit) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
//                            }elseif(strlen($kode_unit_subunit)==4){
//                                    $subdata['nm_unit']         = $this->unit_model->get_nama($kode_unit_subunit) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
//                            }
                            
                            if(strlen($kode_unit_subunit)==2){
                                $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
                            }
                            elseif(strlen($kode_unit_subunit)==4){
                                if((substr($kode_unit_subunit,0,2) == '14')||(substr($kode_unit_subunit,0,2) == '15')||(substr($kode_unit_subunit,0,2) == '16')||(substr($kode_unit_subunit,0,2) == '17')){


                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2)) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);

                                }else{

                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2));
                                }

                            }elseif(strlen($kode_unit_subunit)==6){
                                if((substr($kode_unit_subunit,0,2) == '14')||(substr($kode_unit_subunit,0,2) == '15')||(substr($kode_unit_subunit,0,2) == '16')||(substr($kode_unit_subunit,0,2) == '17')){

                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2)) . ' - ' . $this->unit_model->get_real_nama(substr($kode_unit_subunit,0,4));

                                }else{
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2));
                                }
                            }
                            // echo $kode_unit_subunit;
                            // echo '<pre>';
                            // var_dump($subdata);die;
//                            $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
                            $subdata['alias']               = $this->unit_model->get_alias($kode_unit_subunit);
//                            if($this->check_session->get_level() == '13'){
//                                $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun);
//                            }elseif($this->check_session->get_level() == '4'){
//                                $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi_own($jenis,$kode_unit_subunit,$tahun);
//                            }
//                            echo '<pre>';var_dump($subdata['daftar_kuitansi']);echo '</pre>';die;
                            $subdata['jenis'] = $jenis;
                            $subdata['k_tab'] = 'k-aktif';
                            $subdata['tsite'] = "kuitansi/daftar_kuitansi" ;
                            $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun,'AKTIF');
                            $subdata['daftar_kuitansi_unit']          = $this->kuitansi_model->get_kuitansi_unit($jenis,$kode_unit_subunit,$tahun,'AKTIF');

                            $subdata['daftar_kuitansi_pengembalian']          = $this->kuitansipengembalian_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun,'AKTIF');

                            // vdebug( $subdata['daftar_kuitansi_pengembalian']);

                            $this->load->model('tor_model');

                            $subdata['pppk']                = $this->tor_model->get_pppk(substr($this->check_session->get_unit(),0,2));

                            $subdata['ppk']                = $this->tor_model->get_ppk(substr($this->check_session->get_unit(),0,2));

                            $subdata['pic_kuitansi']        = $this->tor_model->get_pic_kuitansi($this->check_session->get_unit());
                            $subdata['tahun']               = $this->cur_tahun ;

                            // $subdata['unit_kerja'] = $this->unit_model->get_nama($kode_unit_subunit);

                            // echo '<pre>';
                            // var_dump($subdata); die;
                            // $subdata['alias']               = $this->tor_model->get_alias_unit($this->check_session->get_unit());

                            $subdata['kode_unit'] = $kode_unit_subunit ;
                            $subdata['sumber_dana'] = 'SELAIN-APBN' ;

                            $dg = $this->input->get();

                            if(!empty($dg)){
                                if(!empty($dg['u'])){
                                    $subdata['dgu'] = $dg['u'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['n'])){
                                    $subdata['dgn'] = $dg['n'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['t'])){
                                    $subdata['dgt'] = $dg['t'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['r'])){
                                    $subdata['dgr'] = $dg['r'] ;

                                }
                            }

                            // vdebug($subdata);
                            $data['main_content']           = $this->load->view("kuitansi/daftar_kuitansi",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;

                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
                
                function daftar_kuitansi_batal($jenis='',$tahun="",$kode_unit_subunit="",$enc_str_no_spm=""){
                    
                    if($kode_unit_subunit == ''){
                        $kode_unit_subunit = $this->check_session->get_unit();
                    }
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
                    
                    if($jenis==''){
                        redirect('dashboard','refresh');    // redirect ke halaman home
                    }else{
                        if($jenis=='KS'){

                            if($enc_str_no_spm != ''){

                                $enc_str_no_spm = urldecode($enc_str_no_spm);

                                if( base64_encode(base64_decode($enc_str_no_spm, true)) === $enc_str_no_spm){
                                    $enc_str_no_spm = base64_decode($enc_str_no_spm);
                                }else{
                                    redirect(site_url('/'));
                                }

                                $subdata['no_spm_ks'] = $enc_str_no_spm ;
                                $this->load->model('kas_bendahara_model');
                                $nilai_spm = $this->rsa_ks_model->get_kas_bendahara_by_spm($enc_str_no_spm);
                                // echo $nilai_spm; die;
                                $subdata['nilai_spm'] = $nilai_spm ;
                                // echo $enc_str_no_spm ; die;

                                // echo $enc_str_no_spm ; die ;

                            }else{

                                $subdata['no_spm_ks'] = '-' ;
                                $subdata['nilai_spm'] = '0' ;

                            }

                        } else if($jenis=='TP'){
                            $this->load->model('kas_bendahara_model');
                            $subdata['no_spm_tup'] = $this->kas_bendahara_model->get_last_spm_tup_cair($kode_unit_subunit,$this->cur_tahun);
                        } else if($jenis=='GP'){
                            $this->load->model('kas_bendahara_model');
                            $subdata['no_spm_gup'] = $this->kas_bendahara_model->get_last_spm_gup_cair($kode_unit_subunit,$this->cur_tahun);
                        }
                    }

                    /* check session	*/
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
//                            if(strlen($kode_unit_subunit)==2){
//                                $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
//                            }
//                            elseif(strlen($kode_unit_subunit)==4){
//                                    $subdata['nm_unit']         = $this->unit_model->get_nama($kode_unit_subunit) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
//                            }elseif(strlen($kode_unit_subunit)==4){
//                                    $subdata['nm_unit']         = $this->unit_model->get_nama($kode_unit_subunit) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
//                            }
                            
                            if(strlen($kode_unit_subunit)==2){
                                $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
                            }
                            elseif(strlen($kode_unit_subunit)==4){
                                if((substr($kode_unit_subunit,0,2) == '14')||(substr($kode_unit_subunit,0,2) == '15')||(substr($kode_unit_subunit,0,2) == '16')||(substr($kode_unit_subunit,0,2) == '17')){
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2)) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
                                }else{
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2));
                                }

                            }elseif(strlen($kode_unit_subunit)==6){
                                if((substr($kode_unit_subunit,0,2) == '14')||(substr($kode_unit_subunit,0,2) == '15')||(substr($kode_unit_subunit,0,2) == '16')||(substr($kode_unit_subunit,0,2) == '17')){
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2)) . ' - ' . $this->unit_model->get_real_nama(substr($kode_unit_subunit,0,4));
                                }else{
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2));
                                }
                            }
//                            $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
                            $subdata['alias']               = $this->unit_model->get_alias($kode_unit_subunit);
//                            if($this->check_session->get_level() == '13'){
//                                $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun);
//                            }elseif($this->check_session->get_level() == '4'){
//                                $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi_own($jenis,$kode_unit_subunit,$tahun);
//                            }
//                            echo '<pre>';var_dump($subdata['daftar_kuitansi']);echo '</pre>';die;
                            $subdata['jenis'] = $jenis;
                            $subdata['k_tab'] = 'k-batal';
                            $subdata['tsite'] = "kuitansi/daftar_kuitansi_batal" ;

                            $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun,'BATAL');

                            $subdata['daftar_kuitansi_pengembalian']          = $this->kuitansipengembalian_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun,'BATAL');

                            // echo '<pre>'; var_dump($subdata); die;

                            $subdata['daftar_kuitansi_unit']          = $this->kuitansi_model->get_kuitansi_unit($jenis,$kode_unit_subunit,$tahun,'BATAL');

                            $this->load->model('tor_model');

                            $subdata['pppk']                = $this->tor_model->get_pppk(substr($this->check_session->get_unit(),0,2));
                            $subdata['pic_kuitansi']        = $this->tor_model->get_pic_kuitansi($this->check_session->get_unit());
                            $subdata['tahun']               = $this->cur_tahun ;
                            // $subdata['alias']               = $this->tor_model->get_alias_unit($this->check_session->get_unit());

                            $subdata['kode_unit'] = $kode_unit_subunit ;
                            $subdata['sumber_dana'] = 'SELAIN-APBN' ;

                            $dg = $this->input->get();


                            if(!empty($dg)){
                                if(!empty($dg['u'])){
                                    $subdata['dgu'] = $dg['u'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['n'])){
                                    $subdata['dgn'] = $dg['n'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['t'])){
                                    $subdata['dgt'] = $dg['t'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['r'])){
                                    $subdata['dgr'] = $dg['r'] ;

                                }
                            }

                            $data['main_content']           = $this->load->view("kuitansi/daftar_kuitansi",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
                
                function daftar_kuitansi_cair($jenis='',$tahun="",$kode_unit_subunit="",$enc_str_no_spm=""){
                    
                    if($kode_unit_subunit == ''){
                        $kode_unit_subunit = $this->check_session->get_unit();
                    }

                    // echo $kode_unit_subunit ; die ;
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
                    
                    if($jenis==''){
                        redirect('dashboard','refresh');    // redirect ke halaman home
                    }else{
                        if($jenis=='KS'){

                            if($enc_str_no_spm != ''){

                                $enc_str_no_spm = urldecode($enc_str_no_spm);

                                if( base64_encode(base64_decode($enc_str_no_spm, true)) === $enc_str_no_spm){
                                    $enc_str_no_spm = base64_decode($enc_str_no_spm);
                                }else{
                                    redirect(site_url('/'));
                                }

                                $subdata['no_spm_ks'] = $enc_str_no_spm ;
                                $this->load->model('kas_bendahara_model');
                                $nilai_spm = $this->rsa_ks_model->get_kas_bendahara_by_spm($enc_str_no_spm);
                                // echo $nilai_spm; die;
                                $subdata['nilai_spm'] = $nilai_spm ;
                                // echo $enc_str_no_spm ; die;

                                // echo $enc_str_no_spm ; die ;

                            }else{

                                $subdata['no_spm_ks'] = '-' ;
                                $subdata['nilai_spm'] = '0' ;

                            }

                        } else if($jenis=='TP'){
                            $this->load->model('kas_bendahara_model');
                            $subdata['no_spm_tup'] = $this->kas_bendahara_model->get_last_spm_tup_cair($kode_unit_subunit,$this->cur_tahun);
                        } else if($jenis=='GP'){
                            $this->load->model('kas_bendahara_model');
                            $subdata['no_spm_gup'] = $this->kas_bendahara_model->get_last_spm_gup_cair($kode_unit_subunit,$this->cur_tahun);
                        }
                    }

                    /* check session	*/
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4)||($this->check_session->get_level()==17))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['kode_unit_subunit']           = $kode_unit_subunit;
                            $subdata['cur_tahun']           = $tahun;
//                            if(strlen($kode_unit_subunit)==2){
//                                $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
//                            }
//                            elseif(strlen($kode_unit_subunit)==4){
//                                    $subdata['nm_unit']         = $this->unit_model->get_nama($kode_unit_subunit) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
//                            }elseif(strlen($kode_unit_subunit)==4){
//                                    $subdata['nm_unit']         = $this->unit_model->get_nama($kode_unit_subunit) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
//                            }
                            
                            if(strlen($kode_unit_subunit)==2){
                                $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
                            }
                            elseif(strlen($kode_unit_subunit)==4){
                                if((substr($kode_unit_subunit,0,2) == '14')||(substr($kode_unit_subunit,0,2) == '15')||(substr($kode_unit_subunit,0,2) == '16')||(substr($kode_unit_subunit,0,2) == '17')){
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2)) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
                                }else{
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2));
                                }

                            }elseif(strlen($kode_unit_subunit)==6){
                                if((substr($kode_unit_subunit,0,2) == '14')||(substr($kode_unit_subunit,0,2) == '15')||(substr($kode_unit_subunit,0,2) == '16')||(substr($kode_unit_subunit,0,2) == '17')){
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2)) . ' - ' . $this->unit_model->get_real_nama(substr($kode_unit_subunit,0,4));
                                }else{
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2));
                                }
                            }
//                            $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
                            $subdata['alias']               = $this->unit_model->get_alias($kode_unit_subunit);
//                            if($this->check_session->get_level() == '13'){
//                                $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun);
//                            }elseif($this->check_session->get_level() == '4'){
//                                $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi_own($jenis,$kode_unit_subunit,$tahun);
//                            }
//                            echo '<pre>';var_dump($subdata['daftar_kuitansi']);echo '</pre>';die;
                            $subdata['jenis'] = $jenis;
                            $subdata['k_tab'] = 'k-cair';
                            $subdata['tsite'] = "kuitansi/daftar_kuitansi_cair" ;
                            // echo  $kode_unit_subunit ; die;
                            $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun,'CAIR');

                            $subdata['daftar_kuitansi_pengembalian']          = $this->kuitansipengembalian_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun,'CAIR');

                            $subdata['daftar_kuitansi_unit']          = $this->kuitansi_model->get_kuitansi_unit($jenis,$kode_unit_subunit,$tahun,'CAIR');

                            $this->load->model('tor_model');

                            $subdata['pppk']                = $this->tor_model->get_pppk(substr($this->check_session->get_unit(),0,2));
                            $subdata['pic_kuitansi']        = $this->tor_model->get_pic_kuitansi($this->check_session->get_unit());
                            $subdata['tahun']               = $this->cur_tahun ;
                            // $subdata['alias']               = $this->tor_model->get_alias_unit($this->check_session->get_unit());

                            $subdata['kode_unit'] = $kode_unit_subunit ;
                            $subdata['sumber_dana'] = 'SELAIN-APBN' ;

                            $dg = $this->input->get();

                            if(!empty($dg)){
                                if(!empty($dg['u'])){
                                    $subdata['dgu'] = $dg['u'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['n'])){
                                    $subdata['dgn'] = $dg['n'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['t'])){
                                    $subdata['dgt'] = $dg['t'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['r'])){
                                    $subdata['dgr'] = $dg['r'] ;

                                }
                            }

                            $data['main_content']           = $this->load->view("kuitansi/daftar_kuitansi",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }


                function daftar_kuitansi_cair_99($jenis='',$tahun="",$kode_unit_subunit=""){
                    
                    if($kode_unit_subunit == ''){
                        // $kode_unit_subunit = $this->check_session->get_unit();
                        redirect('dashboard','refresh');
                    }

                    // echo $kode_unit_subunit ; die ;
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
                    
                    if($jenis==''){
                        redirect('dashboard','refresh');    // redirect ke halaman home
                    }

                    /* check session    */
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4)||($this->check_session->get_level()==17)||($this->check_session->get_level()==11))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['kode_unit_subunit']           = $kode_unit_subunit;
                            $subdata['cur_tahun']           = $tahun;
//                            if(strlen($kode_unit_subunit)==2){
//                                $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
//                            }
//                            elseif(strlen($kode_unit_subunit)==4){
//                                    $subdata['nm_unit']         = $this->unit_model->get_nama($kode_unit_subunit) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
//                            }elseif(strlen($kode_unit_subunit)==4){
//                                    $subdata['nm_unit']         = $this->unit_model->get_nama($kode_unit_subunit) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
//                            }
                            
                            if(strlen($kode_unit_subunit)==2){
                                $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
                            }
                            elseif(strlen($kode_unit_subunit)==4){
                                if((substr($kode_unit_subunit,0,2) == '41')||(substr($kode_unit_subunit,0,2) == '42')||(substr($kode_unit_subunit,0,2) == '43')||(substr($kode_unit_subunit,0,2) == '44')){
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2)) . ' - ' . $this->unit_model->get_real_nama($kode_unit_subunit);
                                }else{
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2));
                                }

                            }elseif(strlen($kode_unit_subunit)==6){
                                if((substr($kode_unit_subunit,0,2) == '41')||(substr($kode_unit_subunit,0,2) == '42')||(substr($kode_unit_subunit,0,2) == '43')||(substr($kode_unit_subunit,0,2) == '44')){
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2)) . ' - ' . $this->unit_model->get_real_nama(substr($kode_unit_subunit,0,4));
                                }else{
                                    $subdata['nm_unit']         = $this->unit_model->get_nama_unit(substr($kode_unit_subunit,0,2));
                                }
                            }
//                            $subdata['nm_unit']             = $this->unit_model->get_nama($kode_unit_subunit);
                            $subdata['alias']               = $this->unit_model->get_alias($kode_unit_subunit);
//                            if($this->check_session->get_level() == '13'){
//                                $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun);
//                            }elseif($this->check_session->get_level() == '4'){
//                                $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi_own($jenis,$kode_unit_subunit,$tahun);
//                            }
//                            echo '<pre>';var_dump($subdata['daftar_kuitansi']);echo '</pre>';die;
                            $subdata['jenis'] = $jenis;
                            $subdata['k_tab'] = 'k-cair';
                            $subdata['tsite'] = "kuitansi/daftar_kuitansi_cair_99" ;
                            // echo  $kode_unit_subunit ; die;
                            $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun,'CAIR');
                            $subdata['daftar_kuitansi_unit']          = $this->kuitansi_model->get_kuitansi_unit($jenis,$kode_unit_subunit,$tahun,'CAIR');

                            $subdata['data_unit'] = $this->unit_model->get_all_unit();

                            $dg = $this->input->get();

                            if(!empty($dg)){
                                if(!empty($dg['u'])){
                                    $subdata['dgu'] = $dg['u'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['n'])){
                                    $subdata['dgn'] = $dg['n'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['t'])){
                                    $subdata['dgt'] = $dg['t'] ;

                                }
                            }

                            if(!empty($dg)){
                                if(!empty($dg['r'])){
                                    $subdata['dgr'] = $dg['r'] ;

                                }
                            }

                            // echo '<pre>';var_dump($subdata);echo '</pre>';die;

                            $data['main_content']           = $this->load->view("kuitansi/daftar_kuitansi_cair_99",$subdata,TRUE);
                            /*  Load main template  */
             // echo '<pre>';var_dump($subdata);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');  // redirect ke halaman home
                    }
                }
                
                function get_data_kuitansi(){
                    if($this->input->post('id')){
                        $data_kuitansi = $this->kuitansi_model->get_data_kuitansi($this->input->post('id'),$this->cur_tahun);
                        $data_detail_kuintansi = $this->kuitansi_model->get_data_detail_kuitansi($this->input->post('id'),$this->cur_tahun);
                        $data_detail_pajak_kuintansi = $this->kuitansi_model->get_data_detail_pajak_kuitansi($this->input->post('id'),$this->cur_tahun);

                       // var_dump(array(
                       //     'kuitansi' => $data_kuitansi,
                       //     'kuitansi_detail' => $data_detail_kuintansi,
                       //     'kuitansi_detail_pajak' => $data_detail_pajak_kuintansi
                       //         )
                       //     );
                       // die;

                        echo json_encode(array(
                            'kuitansi' => $data_kuitansi,
                            'kuitansi_detail' => $data_detail_kuintansi,
                            'kuitansi_detail_pajak' => $data_detail_pajak_kuintansi
                                )
                            );
                    }
                }

                function get_data_kuitansi_pengembalian(){
                    if($this->input->post('id')){
                        $data_kuitansi = $this->kuitansipengembalian_model->get_data_kuitansi($this->input->post('id'),$this->cur_tahun);
                        $data_detail_kuintansi = $this->kuitansipengembalian_model->get_data_detail_kuitansi($this->input->post('id'),$this->cur_tahun);
                        $data_detail_pajak_kuintansi = $this->kuitansipengembalian_model->get_data_detail_pajak_kuitansi($this->input->post('id'),$this->cur_tahun);
                       // var_dump(array(
                       //     'kuitansi' => $data_kuitansi,
                       //     'kuitansi_detail' => $data_detail_kuintansi,
                       //     'kuitansi_detail_pajak' => $data_detail_pajak_kuintansi
                       //         )
                       //     );
                       // die;
                        echo json_encode(array(
                            'kuitansi' => $data_kuitansi,
                            'kuitansi_detail' => $data_detail_kuintansi,
                            'kuitansi_detail_pajak' => $data_detail_pajak_kuintansi
                                )
                            );
                    }
                }
                
                function cetak_kuitansi(){
                    
                    if($this->input->post('dtable')){
//                        $this->load->library('pdf');
                        $html = base64_decode($this->input->post('dtable'));
//                        $this->pdf->load_view('kuitansi/table',array('content' => $html));
//                        $html = base64_decode($this->input->post('dtable'));
                        $unit = $this->input->post('dunit');
                        $nbukti = $this->input->post('nbukti');
                        $tahun = $this->input->post('dtahun');    
                        $html_ = $this->load->view('kuitansi/table',array('content' => $html),TRUE);
//                        echo $html_ ; die;
//                        $h = $this->load->view("rsa_up/cetak",array('html'=>$html),TRUE);
//                        echo $h;
                        $this->load->library('Pdfgen');
                        $this->pdfgen->cetak($html_,'KUITANSI_'.$unit.'_'.$nbukti.'_'.$tahun);
//                            $this->load->library('pdf');
//                            $this->pdf->load_view('kuitansi/table',array('content' => $html));
//                            $this->pdf->render();
//                            $this->pdf->stream("welcome.pdf");
                    }
                    
//                    $this->PdfGen->filename('test.pdf');
//                    $this->PdfGen->paper('a4', 'portrait');
//
//                    //Load html view
//                    $this->PdfGen->html("<h1>Some Title</h1><p>Some content in here</p>");
//                    $this->PdfGen->create('save');
                }
                
                
                function proses_kuitansi(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                        if($this->input->post()){
                            $data = array(
                                'aktif' => '0'
                            );
                            if($this->kuitansi_model->proses_kuitansi($data,$this->input->post('id'))){
                                echo 'sukses';
                            }else{
                                echo 'gagal';
                            }
                        }
                    }
                }


                function proses_kuitansi_pengembalian(){
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                        if($this->input->post()){
                            // var_dump($data); die;
                            $data = array(
                                'aktif' => '0'
                            );
                            if($this->kuitansipengembalian_model->proses_kuitansi($data,$this->input->post('id'))){
                                echo 'sukses';
                            }else{
                                echo 'gagal';
                            }
                        }
                    }
                }

		//tambahan alaik
		        
        function submit_kuitansi2(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                $kode_akun_tambah = $this->input->post('kode_akun_tambah');
                $kode_usulan_belanja = $this->input->post('kode_usulan_belanja');
                
                $data_id_kuitansi = array(
					'tahun' => $this->cur_tahun ,
					'alias' => $this->check_session->get_alias(),
				);

                $no_bukti = $this->kuitansi_model->get_next_id($data_id_kuitansi);
				$data= array(
					'kode_unit' => $this->check_session->get_unit(),
					'kode_usulan_belanja' => $kode_usulan_belanja,
					'kode_akun5digit' => substr($kode_usulan_belanja,18,5),
					'kode_akun' => substr($kode_usulan_belanja,18,6),
					'jenis' => $this->input->post('jenis'),
					'no_bukti' => $no_bukti,
					'uraian' => $this->input->post('uraian'),
					'tgl_kuitansi' => date("Y-m-d H:i:s"),
					'tahun' => $this->cur_tahun,
					'sumber_dana' => $this->input->post('sumber_dana'),
					'penerima_uang' => $this->input->post('penerima_uang'),
					'penerima_uang_nip' => '-', // $this->input->post('penerima_uang_nip')
					'penerima_barang' => $this->input->post('penerima_barang'),
					'penerima_barang_nip' => $this->input->post('penerima_barang_nip'),
					'nmpppk' => $this->input->post('nmpppk'),
					'nippppk' => $this->input->post('nippppk'),
					'nmbendahara' => $this->input->post('nmbendahara'),
					'nipbendahara' => $this->input->post('nipbendahara'),
					'nmpumk' => $this->input->post('nmpumk'),
					'nippumk' => $this->input->post('nippumk'),
					'aktif' => '1',
					'cair' => '0',
				);
				$id_kuitansi = $this->kuitansi_model->insert_data_kuitansi($data);
				
				// kalo lebih dari 1 :
				// $id_kontrak = explode(",",$this->input->post('id_kontrak'));
				$id_kontrak = $this->input->post('id_kontrak');
				$data = array(
							'kuitansi_id' => $id_kuitansi,
							'kontrak_id' => intval($id_kontrak),
						);
                $id_kuitansi_pihak3 = $this->kuitansi_model->insert_data_kuitansi_kontrak($data);
				
                $pajak_kode_usulan_ = json_decode($this->input->post('pajak_kode_usulan'));
                $pajak_id_input_ = json_decode($this->input->post('pajak_id_input'));
                $pajak_jenis_ = json_decode($this->input->post('pajak_jenis'));
                $pajak_dpp_ = json_decode($this->input->post('pajak_dpp'));
                $pajak_persen_ = json_decode($this->input->post('pajak_persen'));
                $pajak_nilai_ = json_decode($this->input->post('pajak_nilai'));

                $ii = 0 ;
                $this->load->model('tor_model');
                foreach($pajak_kode_usulan_ as $pajak_kode_usulan ){
                    $detail_belanja = $this->tor_model->get_single_detail_rsa_dpa(substr($pajak_kode_usulan,0,24),substr($pajak_kode_usulan,24,3),$this->input->post('sumber_dana'),$this->cur_tahun);
                    $data = array(
                        'id_kuitansi' => $id_kuitansi,
                        'no_bukti' => $this->input->post('no_bukti'),
                        'kode_usulan_belanja' => substr($pajak_kode_usulan,0,24),
                        'kode_akun_tambah' => substr($pajak_kode_usulan,24,3),
                        'deskripsi' => $detail_belanja->deskripsi,
                        'volume' => $detail_belanja->volume,
                        'satuan' => $detail_belanja->satuan,
                        'harga_satuan' => $detail_belanja->harga_satuan,
                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'tahun' => $this->cur_tahun,
                    );
                    $id_kuitansi_detail = $this->kuitansi_model->insert_data_usulan($data);
					if(!empty($pajak_id_input_[$ii])){  
                        foreach($pajak_id_input_[$ii] as $k => $pajak_id_input ){
                            $v = $pajak_jenis_[$ii][$k];
                            if($v == 'ppn'){$v = 'PPN';}
                            else if($v == 'pphps21'){$v = 'PPh_Ps_21';}
                            else if($v == 'pphps22'){$v = 'PPh_Ps_22';}
                            else if($v == 'pphps23'){$v = 'PPh_Ps_23';}
                            else if($v == 'pphps26'){$v = 'PPh_Ps_26';}
                            else if($v == 'pphps42'){$v = 'PPh_Ps_4(2)';}
                            else if($v == 'lainnya'){$v = 'Lainnya';}
                            $jenis_pajak = $v;
							$data = array(
								'id_kuitansi_detail' => $id_kuitansi_detail,
								'no_bukti' => $this->input->post('no_bukti'),
								'id_input_pajak' => $pajak_id_input,
								'jenis_pajak' => $jenis_pajak,
								'dpp' => $pajak_dpp_[$ii][$k],
								'persen_pajak' => $pajak_persen_[$ii][$k],
								'rupiah_pajak' => str_replace(".","",$pajak_nilai_[$ii][$k]),
							);
							$this->kuitansi_model->insert_data_pajak($data);
                        }
                    }
                    $ii++ ;
                }
                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi telah disubmit.</div>');
                echo 'sukses';
                
            }
            else{
                redirect('welcome','refresh');	// redirect ke halaman home
            }
        }

	function daftar_kuitansi2($jenis='',$tahun="",$kode_unit_subunit=""){
                    
                    if($kode_unit_subunit == ''){
                        $kode_unit_subunit = $this->check_session->get_unit();
                    }
                    
                    
                    $data['cur_tahun'] =  $this->cur_tahun;
                    
                    if($tahun == ''){
                        $tahun = $this->cur_tahun ;
                    }
                    
                    if($jenis==''){
                        redirect('dashboard','refresh');	// redirect ke halaman home
                    }

                    /* check session	*/
                    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                            $subdata['cur_tahun']           = $tahun;
                            $subdata['nm_unit']              = $this->unit_model->get_nama($kode_unit_subunit);
                            $subdata['alias']              = $this->unit_model->get_alias($kode_unit_subunit);
                            $subdata['daftar_kuitansi']          = $this->kuitansi_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun);
//                            echo '<pre>';var_dump($subdata['daftar_kuitansi']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("kuitansi/daftar_kuitansi2",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }

    function pindah_kuitansi_tup(){
        $data_kuitansi = $this->input->post('data');

        // $data = explode(',', $data)

        // foreach($data as $no_kuitansi){
            // $this->kuitansi_model->pindah_kuitansi_tup($data_kuitansi);
        // }

        if($this->kuitansi_model->pindah_kuitansi_tup($data_kuitansi)){
            $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi telah dipindah.</div>');
            echo 'sukses' ;
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Kuitansi gagal dipindah, silahkan coba lagi.</div>');
            echo 'gagal' ;
        }

        // echo 'sukses' ;
    }

    function get_data_pengembalian(){
        $data1 = array(
//                        'jenis' => $this->input->post('jenis'),
                        'tahun' => $this->cur_tahun ,
//                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'alias' => $this->input->post('alias'),
        );
        
        $next_id = $this->kuitansipengembalian_model->get_next_id($data1);

        // $next_id = $next_id . 'P' ;

        $this->load->model('akun_model');

        $kd_akun = '' ;
        $nm_subkegiatan = '';
        $uraian = '';
        $kode_usulan_belanja = '000000';

        if($this->input->post('jenis') == 'GP'){
            // $kd_akun = '113111' ;
            $uraian = 'Pengembalian GUP' ;

        }elseif($this->input->post('jenis') == 'TP'){
            // $kd_akun = '113112' ;
            $uraian = 'Pengembalian TUP' ;

        }elseif($this->input->post('jenis') == 'KS'){
            // $kd_akun = '113112' ;
            $uraian = 'Pengembalian KS' ;

        }

        if(strlen($this->check_session->get_unit()) == '2'){
            //  $kode_usulan_belanja = $this->check_session->get_unit() . '1111' ;
        }elseif(strlen($this->check_session->get_unit()) == '4'){
            // $kode_usulan_belanja = $this->check_session->get_unit() . '11' ;
        }

        $kode_usulan_belanja = '';//$kode_usulan_belanja . '000000000001' . $kd_akun ;

        // $nama_akun = $this->akun_model->get_nama_akun($kd_akun,'SELAIN-APBN');

        $data_ret = array(
                            'next_id'=>$next_id,
                            'nama_akun'=>'',//$nama_akun,
                            'nm_subkegiatan' => $nm_subkegiatan,
                            'kode_usulan_belanja' => $kode_usulan_belanja,
                            'uraian' => $uraian,
                        );

        echo json_encode($data_ret);
    }

    function edit_tgl_kuitansi(){

        if($this->input->post()){
            // echo $this->input->post('id') . ' - ' . $this->input->post('tgl_kuitansi') ; die;
            if($this->kuitansi_model->edit_tgl_kuitansi($this->input->post('id'),$this->input->post('tgl_kuitansi'),$this->cur_tahun)){
                echo "ok" ;
            }else{
                echo "gagal";
            }
            
        }
        
    }

    function edit_alias_no_bukti(){

        if($this->input->post()){
            // echo $this->input->post('id') . ' - ' . $this->input->post('tgl_kuitansi') ; die;
            if($this->kuitansi_model->edit_alias_kuitansi($this->input->post('id'),$this->input->post('alias_no_bukti'),$this->cur_tahun)){
                echo "ok" ;
            }else{
                echo "gagal";
            }
            
        }

    }

    function get_data_penerima(){

        $q = $this->input->get('query');
        $kode_unit_subunit = $this->check_session->get_unit();
        $data = $this->kuitansi_model->get_data_penerima($q,$kode_unit_subunit,$this->cur_tahun);
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

    function get_data_penerima_only(){

        $q = $this->input->get('query');
        $kode_unit_subunit = $this->check_session->get_unit();
        $data = $this->kuitansi_model->get_data_penerima_only($q,$kode_unit_subunit,$this->cur_tahun);
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

    function get_data_uraian(){

        $q = $this->input->get('query');
        $kode_unit_subunit = $this->check_session->get_unit();
        $data = $this->kuitansi_model->get_data_uraian($q,$kode_unit_subunit,$this->cur_tahun);
        $json = [];
        
        if(!empty($data)){

            foreach($data as $d){
                // $json['nama_pihak_ketiga'] = $d->penerima ;
                // $json['alamat_ketiga'] = $d->alamat ;

                // $json[] = array(
                //              'nama_pihak_ketiga' => $d->penerima,
                //              'alamat_ketiga'=>$d->alamat
                //             );
                $json[] = $d->uraian ;

            }
        }

        echo json_encode($json);

    }


                    function edit_kuitansi($id_kuitansi){
                        if($this->input->post()){
                            $post = array();
                            foreach ( $_POST as $key => $value )
                            {
                                $post[$key] = $this->input->post($key);
                            }
                            if($this->kuitansi_model->edit_kuitansi($id_kuitansi,$post,$this->cur_tahun)){
                                echo "done";
                            }
                            else{
                                echo "err";
                            }
                        }
                    }



}