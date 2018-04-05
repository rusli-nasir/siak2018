<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rsa_potongan_lainnya extends CI_Controller{
/* -------------- Constructor ------------- */
        
private $cur_tahun;

public function __construct(){ 
	parent::__construct();
		//load library, helper, and model
        
		$this->load->library(array('form_validation','option'));
        $this->load->helper('form');
		// $this->load->helper('vayes_helper');
		// $this->load->model(array('rsa_up_model','rsa_tambah_up_model','setting_up_model'));
		$this->load->model("user_model");
        $this->load->model("unit_model");
        $this->load->model('menu_model');
        $this->load->model("cair_model");
        $this->load->model("potongan_lainnya_model");
		$this->load->helper("security");
        
      	$this->cur_tahun = $this->setting_model->get_tahun();
	}

    public function index(){
        /* check session    */
        $data['cur_tahun'] = $this->cur_tahun ;
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){

            $unit = $this->check_session->get_unit();
            $level = $this->check_session->get_level(); 
        // vdebug($subdata['dana_pumk']);
            $data['main_content'] =  $this->load->view('rsa_potongan_lainnya/index','',TRUE);
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);

            $this->load->view('main_template',$data);
        }else{
        redirect('welcome','refresh');  // redirect ke halaman home
        }
    }


    public function tambah_potongan_lainnya($kode_unit_subunit="",$jenis='',$bulan=''){
                    
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
                    
            $data['cur_tahun'] =  $this->cur_tahun;
            
            $tahun = $this->cur_tahun ;
            
            if($kode_unit_subunit == ''){
                $kode_unit_subunit = $this->check_session->get_ori_unit() ;
                $subdata['kode_unit_subunit'] = $this->check_session->get_ori_unit() ;
            }elseif($kode_unit_subunit == '99'){
                $kode_unit_subunit = '99' ;
                $subdata['kode_unit_subunit'] = '99' ;
            }else{
                $subdata['kode_unit_subunit'] = $kode_unit_subunit  ;
            }

            if(($jenis == '')||($jenis == '00')){
                $jenis = '00' ;
               $subdata['jenis'] = 'SEMUA' ;
            }else{
                $subdata['jenis'] = $jenis ;
            }

             if($bulan == ''){
               $subdata['bulan'] = 'SEMUA' ;
            }else{
                $subdata['bulan'] = $bulan ;
            }

            /* check session    */
            //ver 3, bendahara 13, kbuu 11

            $data['main_menu']   = $this->load->view('main_menu','',TRUE);
            $daftar_spm          = $this->potongan_lainnya_model->get_ptla_by_spm_sp2d($tahun,$kode_unit_subunit,$jenis,$bulan);

            foreach ($daftar_spm as $key => $value) {
                $daftar_spm[$key]->nominal_sudah_ptla = $this->potongan_lainnya_model->get_nominal_ptla($value->str_nomor_trx_spm,$value->jenis_trx,$value->kode_unit_subunit)->nominal_sudah_ptla;
            }
            // vdebug($daftar_spm);
            $subdata['daftar_spm'] = $daftar_spm;

            $subdata['tahun']               = $this->cur_tahun ;

            $subdata['cur_tahun']           = $this->cur_tahun ;
            $subdata['data_unit']           = $this->unit_model->get_all_unit();
            if (strlen($kode_unit_subunit) == 2) {
                $subdata['nama_unit_subunit']   = $this->unit_model->get_nama_unit($kode_unit_subunit);
            }elseif(strlen($kode_unit_subunit) == 4){
                $subdata['nama_unit_subunit']   = $this->unit_model->get_nama_subunit($kode_unit_subunit);
            }
            // vdebug($subdata['data_unit']);
            $data['main_content']           =  $this->load->view("rsa_potongan_lainnya/tambah_potongan_lainnya",$subdata,TRUE);
            $this->load->view('main_template',$data);
        }else{
            redirect('welcome','refresh');  // redirect ke halaman home
        }
    }

    public function daftar_potongan_lainnya($kode_unit_subunit="",$jenis='',$bulan=''){
                    
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
                    
            $data['cur_tahun'] =  $this->cur_tahun;
            
            $tahun = $this->cur_tahun ;
            
            if($kode_unit_subunit == ''){
                $kode_unit_subunit = $this->check_session->get_ori_unit() ;
                $subdata['kode_unit_subunit'] = $this->check_session->get_ori_unit() ;
            }elseif($kode_unit_subunit == '99'){
                $kode_unit_subunit = '99' ;
                $subdata['kode_unit_subunit'] = '99' ;
            }else{
                $subdata['kode_unit_subunit'] = $kode_unit_subunit  ;
            }

            if(($jenis == '')||($jenis == '00')){
                $jenis = '00' ;
               $subdata['jenis'] = 'SEMUA' ;
            }else{
                $subdata['jenis'] = $jenis ;
            }

             if($bulan == ''){
               $subdata['bulan'] = 'SEMUA' ;
            }else{
                $subdata['bulan'] = $bulan ;
            }

            /* check session    */
            //ver 3, bendahara 13, kbuu 11

            $data['main_menu']   = $this->load->view('main_menu','',TRUE);
            $daftar_spm          = $this->potongan_lainnya_model->get_daftar_ptla($tahun,$kode_unit_subunit,$jenis,$bulan);

            foreach ($daftar_spm as $key => $value) {
                $daftar_spm[$key]->nominal_sudah_ptla = $this->potongan_lainnya_model->get_nominal_ptla($value->str_nomor_trx_spm,$value->jenis_trx,$value->kode_unit_subunit)->nominal_sudah_ptla;
            }
            // vdebug($daftar_spm);
            $subdata['daftar_spm'] = $daftar_spm;

            $subdata['tahun']               = $this->cur_tahun ;

            $subdata['cur_tahun']           = $this->cur_tahun ;
            $subdata['data_unit']           = $this->unit_model->get_all_unit();
            if (strlen($kode_unit_subunit) == 2) {
                $subdata['nama_unit_subunit']   = $this->unit_model->get_nama_unit($kode_unit_subunit);
            }elseif(strlen($kode_unit_subunit) == 4){
                $subdata['nama_unit_subunit']   = $this->unit_model->get_nama_subunit($kode_unit_subunit);
            }
            // vdebug($subdata['data_unit']);
            $data['main_content']           =  $this->load->view("rsa_potongan_lainnya/daftar_potongan_lainnya",$subdata,TRUE);
            $this->load->view('main_template',$data);
        }else{
            redirect('welcome','refresh');  // redirect ke halaman home
        }
    }

    public function get_akun_belanja_option(){
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
            $no_spm = $this->input->post('no_spm');
            $jenis = $this->input->post('jenis_trx');
            if ($no_spm != '') {
                $data['data_belanja']              = $this->potongan_lainnya_model->get_akun_belanja_option($no_spm,$jenis);
                
                $this->load->view('rsa_potongan_lainnya/option_akun_belanja',$data);
            }else{
                echo "error";
            }
        }else{
                echo "not authorized";;
        }
    }

	public function add_ptla(){
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
            $no_spm = $this->input->post('no_spm');
            $nominal = $this->input->post('nominal');
            $keterangan = $this->input->post('keterangan');
            $kode_unit_subunit = $this->input->post('kode_unit_subunit');
            $jenis = $this->input->post('jenis');
            $jenis_potongan = $this->input->post('jenis_potongan');
            $nominal_ptla = $this->input->post('nominal_ptla');
            // $akun_belanja = $this->input->post('akun_belanja');
            // $akun_belanja_ket = $this->input->post('akun_belanja_ket');
            $kd_akun_kas = $this->input->post('kd_akun_kas');

            $unit = $this->check_session->get_ori_unit() ;

            if ($kd_akun_kas == 'null') {
                $kd_akun_kas = null;
            }
            // if ($akun_belanja == 'null') {
            //     $akun_belanja = null;
            // }

            if ($keterangan == '') {
                $keterangan = '-';
            }

            // if($akun_belanja_ket != 'null'){
            //     $keterangan = $akun_belanja_ket;
            // }

            if ($no_spm != '' && $jenis_potongan != '' && $nominal != '' && $kode_unit_subunit != '' && $jenis != '' && $nominal_ptla != '') {

                $data = array(
                    "str_nomor_trx_spm"         => $no_spm,
                    "kode_unit_subunit"         => $kode_unit_subunit,
                    "jenis_trx"                 => $jenis,
                    "jenis_potongan"            => $jenis_potongan,
                    "kode_belanja"              => null,
                    "kd_akun_kas"               => $kd_akun_kas,
                    "tgl_proses"                => date("Y-m-d H:i:s"),
                    "nominal"                   => $nominal,
                    "keterangan"                => $keterangan,
                    "proses"                    => 0,
                    "tolakstatus"               => 0,

                    "nmbendahara"               => $this->potongan_lainnya_model->get_bendahara($unit)->nm_lengkap,
                    "nipbendahara"              => $this->potongan_lainnya_model->get_bendahara($unit)->nomor_induk,
                    "nmverifikator"             => $this->potongan_lainnya_model->get_verifikator($unit)->nm_lengkap,
                    "nipverifikator"            => $this->potongan_lainnya_model->get_verifikator($unit)->nomor_induk,
                    "nmkbuu"                    => $this->potongan_lainnya_model->get_kuasabuu()->nm_lengkap,
                    "nipkbuu"                   => $this->potongan_lainnya_model->get_kuasabuu()->nomor_induk,
                );

                $insert = $this->potongan_lainnya_model->insert_ptla($data);

                if($insert){
                    echo 'sukses';
                }else{
                    echo 'error';
                }
            }else{
                echo 'error';
            }
        }else{
                echo "not authorized";;
        }
    }

    public function potongan_lainnya_modal(){
        $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){

            $no_spm = $this->input->post('no_spm');
            $jenis = $this->input->post('jenis');
            $kode_unit_subunit = $this->input->post('kode_unit_subunit');
            $id_trx_urut_spm_cair   = $this->input->post('id_trx_urut_spm_cair');
            $nominal_ptla   = $this->input->post('nominal_ptla');


            $nominal_sudah_ptla = $this->potongan_lainnya_model->get_nominal_ptla($no_spm,$jenis,$kode_unit_subunit);

            $nominal_belum_ptla = intval($nominal_ptla) - intval($nominal_sudah_ptla->nominal_sudah_ptla);


            $data['nominal_ptla']              = $nominal_sudah_ptla->nominal_sudah_ptla;
            $data['nominal_ptla']              = $nominal_ptla;
            $data['kode_unit_subunit']         = $kode_unit_subunit;
            $data['jenis']                     = $jenis;
            $data['id_trx_urut_spm_cair']      = $id_trx_urut_spm_cair;
            $data['no_spm']                    = $no_spm;
            $data['nominal_belum_ptla']        = $nominal_belum_ptla;
            $data['rekening_bank']             = $this->potongan_lainnya_model->get_akun_belanja();
            
            // vdebug($data); 
            $this->load->view('rsa_potongan_lainnya/tambah_potongan_lainnya_modal',$data);
        }
    }

    public function daftar_ptla(){
         $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){

                $data['cur_tahun']              = $this->cur_tahun;
                $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                $subdata['tahun']               = $this->cur_tahun ;
                $subdata['list_ptla']           = $this->ptla_model->get_all_ptla();
                $subdata['list_retur']           = $this->ptla_model->get_all_retur();
                $subdata['daftar_spm']          = $this->cair_model->get_spm_cair($tahun,'99','00','');
                $data['main_content']           = $this->load->view("rsa_ptla/daftar_ptla",$subdata,TRUE);

                // vdebug($subdata['daftar_spm']);

                $this->load->view('main_template',$data);
        }else{
                redirect('welcome','refresh');
        }
    }

    public function get_edit_ptla_modal(){
        $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){

            $id = $this->input->post('id');
            $no_spm = $this->input->post('no_spm');
            $nominal_cair   = $this->input->post('nominal_cair');
            $jenis = $this->input->post('jenis');

            $get_ptla = $this->ptla_model->get_ptla_by_id($id);
            $nominal_ptla = $this->cair_model->get_nominal_ptla($no_spm,$jenis,$get_ptla->kode_unit_subunit);

            $nominal_belum_ptla = intval($nominal_cair) - intval($nominal_ptla->nominal_sudah_ptla);

            $data['id']                        = $get_ptla->id_trx_urut_spm_ptla;
            $data['no_ptla']                   = $get_ptla->str_nomor_trx_ptla;
            $data['nominal_ptla']              = $get_ptla->nominal;
            $data['nominal_cair']              = $nominal_cair;
            $data['no_spm']                    = $no_spm;
            // $data['nominal_belum_ptla']        = $nominal_belum_ptla;
            $data['rekening_bank']             = $this->ptla_model->get_akun_belanja();
            $data['keterangan']                =  $get_ptla->keterangan;
            $data['kd_akun_kas']               =  $get_ptla->kd_akun_kas;
            $data['tgl_ptla']                  =  $get_ptla->tgl_ptla;
            $data['bank']                      =  $get_ptla->bank;
            
            // vdebug($data); 
            $this->load->view('rsa_ptla/edit_ptla_modal',$data);
        }
    }

    public function potongan_lainnya_per_spm($bulan=""){

        if($bulan == ''){
            $bulan = '13';
        }

        $unit = $this->check_session->get_ori_unit();
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
                $data['cur_tahun']              = $this->cur_tahun;
                $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                $list_ptla                      = $this->potongan_lainnya_model->get_ptla_per_spm($unit);
                
                if (!empty($list_ptla)){
                    
                    foreach ($list_ptla as $key => $value) {
                        $list_ptla[$key]->nominal_cair = $this->cair_model->get_nominal_cair($value->no_spm);
                        
                        $potongan_lainnya = $this->potongan_lainnya_model->get_potongan_lainnya($value->no_spm);

                        $new_list[$value->no_spm] = array(
                            'potongan_lainnya'  => $potongan_lainnya,
                            'total_ptla'    => 0,
                            'persentase'    => 0,
                            'data_ptla'     => array()
                        );
                    }

                    // vdebug($new_list);
                    foreach ($new_list as $key2 => $value2) {
                        $total_ptla = 0;
                        $persentase = 0;
                        foreach ($list_ptla as $key3 => $value3) {
                            if ($key2 == $value3->no_spm) {

                                if ($value3->nama_subunit != null) {
                                    $nama_subunit = str_replace('dan ', '', $value3->nama_subunit);
                                    $words = explode(" ", $nama_subunit);
                                    $acronym = "";

                                    foreach ($words as $w) {
                                        $acronym .= $w[0];
                                    }
                                    $nama_unit_subunit = $value3->nama_unit.$acronym;
                                }else{
                                    $nama_unit_subunit = $value3->nama_unit;
                                }

                                $new_list[$key2]['data_ptla'][] = array(
                                    'no_spm' => $value3->no_spm,
                                    'jenis_trx' => $value3->jenis_trx,
                                    'tgl_proses' => $value3->tgl_proses,
                                    'nominal' => $value3->nominal,
                                    'jenis_potongan' => $value3->jenis_potongan,
                                    'keterangan' => $value3->keterangan,
                                    'nama_unit' => $nama_unit_subunit,
                                );

                                $total_ptla = $total_ptla + $value3->nominal;
                            }
                        }
                        $new_list[$key2]['total_ptla'] = $total_ptla;
                        $new_list[$key2]['persentase'] = number_format($total_ptla / $value2['potongan_lainnya'] * 100,2);
                        $new_list[$key2]['persentase'] .= '%';

                    }
                }else{
                    $new_list = array();
                }
                // vdebug($new_list);
           

                if ($bulan != 13) {
                    $no_spm_ptla_per_bulan = $this->potongan_lainnya_model->get_no_spm_ptla_per_bulan($bulan,$unit);
                    if (!empty($no_spm_ptla_per_bulan)) {
                        foreach ($new_list as $key => $value) {
                            foreach ($no_spm_ptla_per_bulan as $key2 => $value2) {
                                if ($key == $key2) {
                                    $newest_list[$key2] = $value;
                                }
                            }
                        }
                        // vdebug($new_list);
                    }else{
                        $newest_list = array();
                    }

                    $subdata['list_ptla']           = $newest_list;
                }else{
                    $subdata['list_ptla']           = $new_list;
                }

                $subdata['tahun']               = $this->cur_tahun;
                $data['main_content']           = $this->load->view("rsa_potongan_lainnya/potongan_lainnya_per_spm",$subdata,TRUE);

                $this->load->view('main_template',$data);
        }else{
                redirect('welcome','refresh');
        }
    }

    function dokumen_ptla($spm=""){
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
            if($spm != ''){
                $spm = base64_decode(urldecode($spm));
                         // urlencode(base64_encode($no_spm));
                $unit = $this->check_session->get_ori_unit();
                $level = $this->check_session->get_level();

                $data['cur_tahun'] = $this->cur_tahun;
                $data['main_menu']  = $this->load->view('main_menu','',TRUE);

                $subdata['data_ptla'] = $this->potongan_lainnya_model->get_data_ptla($spm);
                // $subdata->doc = $this->rsa_ptla_model->get_status($ptla);
                $subdata['cur_tahun'] = $this->cur_tahun;
                $subdata['level'] = $level;
                // vdebug($subdata);
                $data['main_content'] = $this->load->view('rsa_potongan_lainnya/cetak_potongan_lainnya',$subdata,TRUE);
                $this->load->view('main_template',$data);

            }else{
                redirect('rsa_ptla/daftar_spm','refresh');
            }
        }
    }

    function proses_ptla(){
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
            $no_spm = $this->input->post('no_spm');
            if($no_spm != ''){
                if ($this->check_session->get_level()==13) {
                    $proses = 1;
                    $data_update = array(
                        'tglbendahara'          => date("Y-m-d H:i:s"),
                        'bulan_ajukan'          => date("m"),
                        'proses'                => $proses,
                    );
                }elseif ($this->check_session->get_level()==3) {
                    $proses = 2;
                    $data_update = array(
                        'tglverifikator'        => date("Y-m-d H:i:s"),
                        'bulan_ajukan'          => date("m"),
                        'proses'                => $proses,
                    );
                }elseif ($this->check_session->get_level()==11) {
                    $proses = 3;
                    $data_update = array(
                        'tglkbuu'               => date("Y-m-d H:i:s"),
                        'bulan_ajukan'          => date("m"),
                        'proses'                => $proses,
                        'tolakstatus'           => 0,
                    );
                }

                

                $update = $this->potongan_lainnya_model->update_ptla_proses($no_spm,$data_update);
                if ($update) {
                    echo "sukses";
                }else{
                    echo "gagal";
                }
            }else{
                echo "error";;
            }
        }
    }

    function daftar_unit($username=""){
        $level = $this->check_session->get_level();
        if ($level == 11) {
            $subdata['unit'] = $this->potongan_lainnya_model->daftar_unit_kbuu();
        }else{
            $subdata['unit'] = $this->potongan_lainnya_model->daftar_unit_verifikator($username);
        }
        $data['cur_tahun'] = $this->cur_tahun ;
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view('rsa_potongan_lainnya/daftar_unit',$subdata,TRUE);
        $this->load->view('main_template',$data);
    }

    function modal_tolak(){
        $no_spm = $this->input->post("no_spm");
        $kd_unit = $this->input->post("kd_unit");
        $subdata['no_spm'] = $no_spm;
        $subdata['kd_unit'] = $kd_unit;

        $this->load->view('rsa_potongan_lainnya/modal_tolak',$subdata);
    }

    function update_status_tolak(){
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
            
            $no_spm = $this->input->post("no_spm");
            $ket = $this->input->post("ket");

            if($no_spm != ''){
                if ($this->check_session->get_level()==3) {
                    $data_update = array(
                        'tolaktgl'           => date("Y-m-d H:i:s"),
                        'tolakuser'          => 'VERIFIKATOR',
                        'tolakket'           => $ket,
                        'tolakstatus'        => 1,
                        'proses'             => 0,
                    );
                }elseif ($this->check_session->get_level()==11) {
                    $data_update = array(
                        'tolaktgl'           => date("Y-m-d H:i:s"),
                        'tolakuser'          => 'KUASA BUU',
                        'tolakket'           => $ket,
                        'tolakstatus'        => 1,
                        'proses'             => 0,
                    );
                }

                $update = $this->potongan_lainnya_model->update_ptla_tolak($no_spm,$data_update);
                if ($update) {
                    echo "sukses";
                }else{
                    echo "gagal";
                }
            }else{
                echo "error";;
            }
        }
    }

    function get_notif_ptla_approve(){
        $level = $this->check_session->get_level() ;
        $user = $this->check_session->get_username();
        $unit =  $this->check_session->get_unit();
        $notif_up = $this->potongan_lainnya_model->get_notif($level,$user,$unit);

        // vdebug($notif_up);
        echo $notif_up;
    }

    function update_ptla_edit(){
        if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11))){
            $id_trx = $this->input->post('id_trx');
            $table_name = $this->input->post('table_name');
            $value = $this->input->post('value');

            $data_update = array(
                $table_name => $value,
            );

            $update = $this->potongan_lainnya_model->update_ptla_edit($id_trx,$data_update);
            if ($update) {
                echo "sukses";
            }else{
                echo "gagal";
            }
        }else{
            echo "not authorized";;
        }
    }
}

