<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Rsa_sp2d extends CI_Controller{

	private $cur_tahun;
    public function __construct(){ 
		parent::__construct();
			$this->load->library(array('form_validation','option'));
            $this->load->helper('form');
			$this->load->model("user_model");
            $this->load->model("unit_model");
            $this->load->model('menu_model');
            $this->load->model("cair_model");
            $this->load->model("sp2d_model");
			$this->load->helper("security");
          	$this->cur_tahun = $this->setting_model->get_tahun();
		}

    public function index(){
        $data['cur_tahun'] 		= $this->cur_tahun ;
        $data['main_content'] 	= $this->load->view('rsa_sp2d/menu_sp2d','',TRUE);
        $list["menu"] 			= $this->menu_model->show();
        $list["submenu"] 		= $this->menu_model->show();
        $data['main_menu']  	= $this->load->view('main_menu','',TRUE);
        $this->load->view('main_template',$data);
    }

    public function tambah_sp2d($tahun="",$kode_unit_subunit="",$jenis='',$bulan=''){
                    
                    
        $data['cur_tahun'] =  $this->cur_tahun;
        
        if($tahun == ''){
            $tahun = $this->cur_tahun ;
        }

        if(($kode_unit_subunit == '')||($kode_unit_subunit == '99')){
            $kode_unit_subunit = '99' ;
            $subdata['kode_unit_subunit'] = 'SEMUA' ;
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
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){

                $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                $subdata['daftar_spm']          = $this->sp2d_model->get_spm_cair($tahun,$kode_unit_subunit,$jenis,$bulan);
        // vdebug($bulan);

                // vdebug($subdata['daftar_spm']);
                $subdata['tahun']               = $this->cur_tahun ;

                $subdata['cur_tahun']           = $this->cur_tahun ;
                $subdata['data_unit']           = $this->unit_model->get_all_unit();
                $data['main_content']           =  $this->load->view("rsa_sp2d/tambah_sp2d",$subdata,TRUE);
                /*  Load main template  */
                // echo '<pre>';var_dump($subdata['daftar_spm']);echo '</pre>';die;
                $this->load->view('main_template',$data);
        }else{
                redirect('welcome','refresh');  // redirect ke halaman home
        }
    }

    public function tambah_retur(){
         $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){
                $data['cur_tahun']              = $this->cur_tahun;
                $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                $subdata['tahun']               = $this->cur_tahun ;
                $subdata['daftar_spm']          = $this->sp2d_model->get_spm_cair($tahun,'99','00','','tambah_retur');
                foreach ($subdata['daftar_spm'] as $key => $value) {
                    $potongan_lainnya = $this->sp2d_model->get_potongan_lainnya($value->str_nomor_trx_spm);
                    $subdata['daftar_spm'][$key]->potongan_lainnya = $potongan_lainnya;
                }
                $data['main_content']           = $this->load->view("rsa_sp2d/tambah_retur",$subdata,TRUE);
                $this->load->view('main_template',$data);
        }else{
                redirect('welcome','refresh');
        }
    }

	public function add_sp2d(){
        $no_spm = $this->input->post('no_spm');
        $no_sp2d = $this->input->post('no_sp2d');
        $tgl_sp2d = $this->input->post('tgl_sp2d');
        $nominal = $this->input->post('nominal');
        $keterangan = $this->input->post('keterangan');
        $kode_unit_subunit = $this->input->post('kode_unit_subunit');
        $jenis = $this->input->post('jenis');
        $nominal_sp2d = $this->input->post('nominal_sp2d');
        $bank = $this->input->post('bank');
        $kd_akun_kas = $this->input->post('kd_akun_kas');
        $jenis_sp2d = $this->input->post('jenis_sp2d');

        if ($keterangan == '') {
            $keterangan = '-';
        }

        if ($no_spm != '' && $no_sp2d != '' && $tgl_sp2d != '' && $nominal != '' && $kode_unit_subunit != '' && $jenis != '' && $nominal_sp2d != '' && $bank != '' ) {

            $data = array(
                'str_nomor_trx_spm' => $no_spm,
                'str_nomor_trx_sp2d' => $no_sp2d,
                'kode_unit_subunit' => $kode_unit_subunit,
                'jenis_trx'         => $jenis,
                'tgl_proses'        => date('Y-m-d H:i:s'),
                'tgl_sp2d'          => $tgl_sp2d,
                'nominal'           => $nominal,
                'keterangan'        => $keterangan,
                'kd_akun_kas'        => $kd_akun_kas,
                'bank'               => $bank,
                'jenis_sp2d'         => $jenis_sp2d
            );

            if ($jenis_sp2d == 'Pembayaran Retur') {
                $data['id_retur'] = $this->sp2d_model->get_last_retur_id($no_spm);
                // vdebug($data);
            }

            $insert = $this->sp2d_model->insert_sp2d($data);

            $nominal_sp2d_baru = $nominal_sp2d + $nominal;
            $data_update = array(
                'nominal_sudah_sp2d'    => $nominal_sp2d_baru
            );
            $update = $this->cair_model->update_nominal_sp2d($no_spm,$jenis,$kode_unit_subunit,$data_update);

            if($insert && $update){
                echo json_encode('sukses');
            }else{
                echo json_encode('error');
            }
        }else{
            echo json_encode('error');
        }
    }

    public function sp2d_modal(){
        $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){

            $no_spm = $this->input->post('no_spm');
            $jenis = $this->input->post('jenis');
            $kode_unit_subunit = $this->input->post('kode_unit_subunit');
            $id_trx_urut_spm_cair   = $this->input->post('id_trx_urut_spm_cair');
            $nominal_cair   = $this->input->post('nominal_cair');
            $pajak   = $this->input->post('pajak');
            $netto   = $this->input->post('netto');
            $potongan_lainnya   = $this->input->post('potongan_lainnya');


            $nominal_sp2d = $this->cair_model->get_nominal_sp2d($no_spm,$jenis,$kode_unit_subunit);

            /******************** GENERATE NEW NO SP2D ********************/
            $get_new_no_sp2d    = $this->sp2d_model->get_new_no_sp2d($no_spm);
            $no_urut            = intval(ltrim($get_new_no_sp2d, '0'));
            $new_no_urut        = $no_urut + 1;
            $the_no_urut        = sprintf('%04d', $new_no_urut);
            $bulan              = array("","JAN","FEB","MAR","APR","MEI","JUN","JUL","AGU","SEP","OKT","NOV","DES");
            $bln                = $bulan[date("n")];
            $new_no_sp2d        = $the_no_urut.'/'.substr($no_spm, 5,3).'/SP2D-'.$jenis.'/'.$bln.'/'.date('Y');
            $no_sp2d_sblm       = sprintf('%04d', $get_new_no_sp2d).'/'.substr($no_spm, 5,3).'/SP2D-'.$jenis.'/'.$bln.'/'.date('Y');
            /******************** !end GENERATE NEW NO SP2D ********************/

            $nominal_belum_sp2d = intval($nominal_cair) - intval($nominal_sp2d->nominal_sudah_sp2d);

            $data['list_riwayat'] = $this->sp2d_model->get_riwayat_sp2d_retur($no_spm);
            // vdebug($list_riwayat);
            $data['nominal_sp2d']              = $nominal_sp2d->nominal_sudah_sp2d;
            $data['new_no_sp2d']               = $new_no_sp2d;
            $data['nominal_cair']              = $nominal_cair;
            $data['no_sp2d_sblm']              = $no_sp2d_sblm;
            $data['kode_unit_subunit']         = $kode_unit_subunit;
            $data['jenis']                     = $jenis;
            $data['id_trx_urut_spm_cair']      = $id_trx_urut_spm_cair;
            $data['no_spm']                    = $no_spm;
            $data['nominal_belum_sp2d']        = $nominal_belum_sp2d;
            $data['pajak']                     = $pajak;
            $data['netto']                     = $netto;
            $data['rekening_bank']             = $this->sp2d_model->get_akun_belanja();
            $data['potongan_lainnya']          = $potongan_lainnya;
            
            // vdebug($data); 
            $this->load->view('rsa_sp2d/tambah_sp2d_modal',$data);
        }
    }

    public function daftar_sp2d(){
         $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){

                $data['cur_tahun']              = $this->cur_tahun;
                $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                $subdata['tahun']               = $this->cur_tahun ;
                $subdata['list_sp2d']           = $this->sp2d_model->get_all_sp2d();
                $subdata['list_retur']           = $this->sp2d_model->get_all_retur();
                $subdata['daftar_spm']          = $this->cair_model->get_spm_cair($tahun,'99','00','');
                foreach ($subdata['daftar_spm'] as $key => $value) {
                    $potongan_lainnya = $this->sp2d_model->get_potongan_lainnya($value->str_nomor_trx_spm);
                    $subdata['daftar_spm'][$key]->potongan_lainnya = $potongan_lainnya;
                }
                // vdebug($subdata['daftar_spm']);
                $data['main_content']           = $this->load->view("rsa_sp2d/daftar_sp2d",$subdata,TRUE);

                // vdebug($subdata['list_sp2d']);

                $this->load->view('main_template',$data);
        }else{
                redirect('welcome','refresh');
        }
    }

    public function daftar_retur(){
        $data['cur_tahun'] = $this->cur_tahun ;
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){
                $data['main_menu']  	= $this->load->view('main_menu','',TRUE);
                $subdata['list_retur']  = $this->sp2d_model->get_all_retur();
                $data['main_content'] 	= $this->load->view('rsa_sp2d/daftar_retur',$subdata,TRUE);
                $this->load->view('main_template',$data);
        }else{
                redirect('welcome','refresh');
        }
    }

    public function retur_modal(){
        $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){

            $no_spm = $this->input->post('no_spm');
            $jenis = $this->input->post('jenis');
            $kode_unit_subunit = $this->input->post('kode_unit_subunit');
            $id_trx_urut_spm_cair   = $this->input->post('id_trx_urut_spm_cair');
            $nominal_cair   = $this->input->post('nominal_cair');
            $potongan_lainnya   = $this->input->post('potongan_lainnya');

            $nominal_sp2d = $this->cair_model->get_nominal_sp2d($no_spm,$jenis,$kode_unit_subunit);

            /******************** GENERATE NEW NO RETUR ********************/
            $get_new_no_retur   = $this->sp2d_model->get_new_no_retur($no_spm);
            $no_urut_retur      = intval(ltrim($get_new_no_retur, '0'));
            $new_no_urut_retur  = $no_urut_retur + 1;
            $the_no_urut_retur  = sprintf('%04d', $new_no_urut_retur);
            $bulan_retur        = array("","JAN","FEB","MAR","APR","MEI","JUN","JUL","AGU","SEP","OKT","NOV","DES");
            $bln_retur          = $bulan_retur[date("n")];
            $new_no_retur       = $the_no_urut_retur.'/'.substr($no_spm, 5,3).'/RETUR-'.$jenis.'/'.$bln_retur.'/'.date('Y');
            $no_retur_sblm      = sprintf('%04d', $get_new_no_retur).'/'.substr($no_spm, 5,3).'/RETUR-'.$jenis.'/'.$bln_retur.'/'.date('Y');
            /******************** !end GENERATE NEW NO SP2D ********************/

            $data['list_riwayat'] = $this->sp2d_model->get_riwayat_sp2d_retur($no_spm);
            $data['nominal_sp2d']              = $nominal_sp2d->nominal_sudah_sp2d;
            $data['new_no_retur']              = $new_no_retur;
            $data['no_retur_sblm']             = $no_retur_sblm;
            $data['kode_unit_subunit']         = $kode_unit_subunit;
            $data['jenis']                     = $jenis;
            $data['id_trx_urut_spm_cair']      = $id_trx_urut_spm_cair;
            $data['no_spm']                    = $no_spm;
            $data['nominal_cair']              = $nominal_cair;
            $data['potongan_lainnya']          = $potongan_lainnya;
            $data['rekening_bank']             = $this->sp2d_model->get_akun_belanja();
            // vdebug($data); 
            $this->load->view('rsa_sp2d/tambah_retur_modal',$data);
        }
    }

    public function add_retur(){
        $no_spm = $this->input->post('no_spm');
        $no_retur = $this->input->post('no_retur');
        $tgl_retur = $this->input->post('tgl_retur');
        $nominal = $this->input->post('nominal');
        $keterangan = $this->input->post('keterangan');
        $kode_unit_subunit = $this->input->post('kode_unit_subunit');
        $jenis = $this->input->post('jenis');
        $nominal_sp2d = $this->input->post('nominal_sp2d');
        $bank = $this->input->post('bank');
        $kd_akun_kas = $this->input->post('kd_akun_kas');
        $potongan_lainnya = $this->input->post('potongan_lainnya');

        if ($keterangan == '') {
            $keterangan = '-';
        }

        if ($no_spm != '' && $nominal != '' && $kode_unit_subunit != '' && $jenis != '' && $nominal_sp2d != '' && $no_retur != '' && $bank != '' ) {

            $data = array(
                'str_nomor_trx_spm' => $no_spm,
                'kode_unit_subunit' => $kode_unit_subunit,
                'jenis_trx'         => $jenis,
                'tgl_proses'        => date('Y-m-d H:i:s'),
                'tgl_retur'          => $tgl_retur,
                'nominal'           => $nominal,
                'keterangan'        => $keterangan,
                'str_nomor_trx_retur' => $no_retur,
                'kd_akun_kas'         => $kd_akun_kas,
                'bank'               => $bank
            );

            $insert = $this->sp2d_model->insert_retur($data);

            $nominal_sp2d_baru = $nominal_sp2d - $nominal;
            $data_update = array(
                'nominal_sudah_sp2d'    => $nominal_sp2d_baru
            );
            $update = $this->cair_model->update_nominal_sp2d($no_spm,$jenis,$kode_unit_subunit,$data_update);

            if($insert && $update){
            	echo json_encode('sukses');
            }else{
                echo json_encode('error');
            }
        }else{
            echo json_encode('error');
        }
    }

    public function history_sp2d($no_spm = ''){
        $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){
                
                $data['cur_tahun']              = $this->cur_tahun;
                $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                $subdata['tahun']               = $this->cur_tahun ;
                if($no_spm != ''){
                    $no_spm = base64_decode(urldecode($no_spm));
                     // urlencode(base64_encode($no_spm));
                    $subdata['history']             = $this->sp2d_model->get_riwayat_sp2d_retur($no_spm);
                    $subdata['nominal_sp2d_retur']  = $this->sp2d_model->get_nominal_sp2d_retur($no_spm);
                    $subdata['nominal_cair']        = $this->cair_model->get_nominal_cair($no_spm);
                    $subdata['no_spm']              = $no_spm;
                }
                $data['main_content']           = $this->load->view("rsa_sp2d/history_sp2d",$subdata,TRUE);
                // vdebug($subdata['daftar_spm'])

                $this->load->view('main_template',$data);
        }else{
                redirect('welcome','refresh');
        }
    }

    public function search_riwayat_sp2d(){
        $no_spm = $this->input->post('no_spm');
        $data['history'] = $this->sp2d_model->get_riwayat_sp2d_retur($no_spm);
        $data['nominal_sp2d_retur'] = $this->sp2d_model->get_nominal_sp2d_retur($no_spm);
        $data['nominal_cair'] = $this->cair_model->get_nominal_cair($no_spm);
        $data['no_spm'] = $no_spm;

        $this->load->view('rsa_sp2d/row_history_sp2d',$data);
    }

    public function riwayat_sp2d_modal(){
        $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){
        	$no_spm = $this->input->post('no_spm');
            $list_riwayat = $this->sp2d_model->get_riwayat_sp2d_retur($no_spm);
            // vdebug($list_riwayat);

                if ($list_riwayat != 0){
	                foreach ($list_riwayat as $key => $value) {
	                	$list_riwayat[$key]->nominal_cair = $this->cair_model->get_nominal_cair($value->no_spm);
	                	
	                	$potongan_lainnya = $this->sp2d_model->get_potongan_lainnya($value->no_spm);

	                	$new_list[$value->no_spm] = array(
	                		'nominal_cair'	=> $this->cair_model->get_nominal_cair($value->no_spm),
	                		'potongan_lainnya'	=> $potongan_lainnya,
	                		'total_sp2d'	=> 0,
	                		'persentase'	=> 0,
	                		'data_sp2d'		=> array()
	                	);
	                }


	                foreach ($new_list as $key2 => $value2) {
	                	$total_sp2d = 0;
	                	$persentase = 0;
	                	foreach ($list_riwayat as $key3 => $value3) {
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

	                			$new_list[$key2]['data_sp2d'][] = array(
	                				'no_spm' => $value3->no_spm,
	                				'jenis_trx' => $value3->jenis_trx,
	                				'no_trx' => $value3->no_trx,
	                				'tgl_trx' => $value3->tgl_trx,
	                				'tgl_proses' => $value3->tgl_proses,
	                				'jenis_sp2d_retur' => $value3->jenis_sp2d_retur,
	                				'bank' => $value3->bank,
	                				'nominal' => $value3->nominal,
                                    'jenis_sp2d' => $value3->jenis_sp2d,
	                				'keterangan' => $value3->keterangan,
	                				'nama_unit' => $nama_unit_subunit,
	                			);

	                			$total_sp2d = $total_sp2d + $value3->nominal;
	                		}
	                	}
	                	$new_list[$key2]['total_sp2d'] = $total_sp2d;
	                	$new_list[$key2]['persentase'] = number_format(($total_sp2d +  $value2['potongan_lainnya']) / $value2['nominal_cair'] * 100,2);
	                	$new_list[$key2]['persentase'] .= '%';

	                }
                }else{
                    $new_list = array();
                }
				// vdebug($new_list);
           
                $subdata['list_riwayat']	= $new_list;
                $subdata['no_spm']			= $no_spm;
            $this->load->view('rsa_sp2d/history_sp2d_modal',$subdata);
        }
    }

    public function get_edit_sp2d_modal(){
        $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){

            $id 			= $this->input->post('id');
            $no_spm 		= $this->input->post('no_spm');
            $nominal_cair   = $this->input->post('nominal_cair');
            $jenis 			= $this->input->post('jenis');

            $get_sp2d 		= $this->sp2d_model->get_sp2d_by_id($id);
            $nominal_sp2d 	= $this->cair_model->get_nominal_sp2d($no_spm,$jenis,$get_sp2d->kode_unit_subunit);

            $nominal_belum_sp2d = intval($nominal_cair) - intval($nominal_sp2d->nominal_sudah_sp2d);

            $data['id']                        = $get_sp2d->id_trx_urut_spm_sp2d;
            $data['no_sp2d']                   = $get_sp2d->str_nomor_trx_sp2d;
            $data['nominal_sp2d']              = $get_sp2d->nominal;
            $data['nominal_cair']              = $nominal_cair;
            $data['no_spm']                    = $no_spm;
            // $data['nominal_belum_sp2d']        = $nominal_belum_sp2d;
            $data['rekening_bank']             = $this->sp2d_model->get_akun_belanja();
            $data['keterangan']                =  $get_sp2d->keterangan;
            $data['kd_akun_kas']               =  $get_sp2d->kd_akun_kas;
            $data['tgl_sp2d']                  =  $get_sp2d->tgl_sp2d;
            $data['bank']                      =  $get_sp2d->bank;
            
            // vdebug($data); 
            $this->load->view('rsa_sp2d/edit_sp2d_modal',$data);
        }
    }

    public function update_sp2d(){
        $id = $this->input->post('id');
        $no_sp2d = $this->input->post('no_sp2d');
        $tgl_sp2d = $this->input->post('tgl_sp2d');
        $bank = $this->input->post('bank');
        $kd_akun_kas = $this->input->post('kd_akun_kas');
        $keterangan = $this->input->post('keterangan');

        if ($keterangan == '') {
            $keterangan = '-';
        }

        if ($id != '' && $no_sp2d != '' && $tgl_sp2d != '' && $bank != '' ) {

            $data = array(
                'str_nomor_trx_sp2d'=> $no_sp2d,
                'tgl_sp2d'          => $tgl_sp2d,
                'bank'              => $bank,
                'kd_akun_kas'       => $kd_akun_kas,
                'keterangan'        => $keterangan,
                'kd_akun_kas'       => $kd_akun_kas,
                'bank'              => $bank
            );

            $update = $this->sp2d_model->update_sp2d($data,$id);

            if($update){
                echo json_encode('sukses');
            }else{
                echo json_encode('error');
            }
        }else{
            echo json_encode('error');
        }
    }

    public function get_edit_retur_modal(){
        $tahun =  $this->cur_tahun;
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){

            $id             = $this->input->post('id');
            $no_spm         = $this->input->post('no_spm');
            $nominal_cair   = $this->input->post('nominal_cair');
            $jenis          = $this->input->post('jenis');

            $get_retur       = $this->sp2d_model->get_retur_by_id($id);

            $nominal_sp2d   = $this->cair_model->get_nominal_sp2d($no_spm,$jenis,$get_retur->kode_unit_subunit);

            $data['id']                        = $get_retur->id_trx_urut_sp2d_retur;
            $data['no_retur']                   = $get_retur->str_nomor_trx_retur;
            $data['nominal_retur']              = $get_retur->nominal;
            $data['nominal_cair']              = $nominal_cair;
            $data['nominal_sudah_sp2d']        = $nominal_sp2d->nominal_sudah_sp2d;
            $data['no_spm']                    = $no_spm;
            // $data['nominal_belum_sp2d']        = $nominal_belum_sp2d;
            $data['rekening_bank']             = $this->sp2d_model->get_akun_belanja();
            $data['keterangan']                =  $get_retur->keterangan;
            $data['kd_akun_kas']               =  $get_retur->kd_akun_kas;
            $data['tgl_retur']                 =  $get_retur->tgl_retur;
            $data['bank']                      =  $get_retur->bank;
            
            // vdebug($data); 
            $this->load->view('rsa_sp2d/edit_retur_modal',$data);
        }
    }

    public function update_retur(){
        $id = $this->input->post('id');
        $no_retur = $this->input->post('no_retur');
        $tgl_retur = $this->input->post('tgl_retur');
        $bank = $this->input->post('bank');
        $kd_akun_kas = $this->input->post('kd_akun_kas');
        $keterangan = $this->input->post('keterangan');

        if ($keterangan == '') {
            $keterangan = '-';
        }

        if ($id != '' && $no_retur != '' && $tgl_retur != '' && $bank != '' ) {

            $data = array(
                'str_nomor_trx_retur'=> $no_retur,
                'tgl_retur'          => $tgl_retur,
                'bank'              => $bank,
                'kd_akun_kas'       => $kd_akun_kas,
                'keterangan'        => $keterangan,
                'kd_akun_kas'       => $kd_akun_kas,
                'bank'              => $bank
            );

            $update = $this->sp2d_model->update_retur($data,$id);

            if($update){
                echo json_encode('sukses');
            }else{
                echo json_encode('error');
            }
        }else{
            echo json_encode('error');
        }
    }

    public function sp2d_per_spm($bulan=""){

        if($bulan == ''){
                $bulan = '13';
            }

        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){
                
                $data['cur_tahun']              = $this->cur_tahun;
                $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                $list_sp2d 						= $this->sp2d_model->get_sp2d_per_spm();
                // vdebug($list_sp2d);
                        if ($list_sp2d != 0){
                            
        	                foreach ($list_sp2d as $key => $value) {
        	                	$list_sp2d[$key]->nominal_cair = $this->cair_model->get_nominal_cair($value->no_spm);
        	                	
        	                	$potongan_lainnya = $this->sp2d_model->get_potongan_lainnya($value->no_spm);

        	                	$new_list[$value->no_spm] = array(
        	                		'nominal_cair'	=> $this->cair_model->get_nominal_cair($value->no_spm),
        	                		'potongan_lainnya'	=> $potongan_lainnya,
        	                		'total_sp2d'	=> 0,
        	                		'persentase'	=> 0,
        	                		'data_sp2d'		=> array()
        	                	);
        	                }


        	                foreach ($new_list as $key2 => $value2) {
        	                	$total_sp2d = 0;
        	                	$persentase = 0;
        	                	foreach ($list_sp2d as $key3 => $value3) {
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

        	                			$new_list[$key2]['data_sp2d'][] = array(
        	                				'no_spm' => $value3->no_spm,
        	                				'jenis_trx' => $value3->jenis_trx,
        	                				'no_trx' => $value3->no_trx,
        	                				'tgl_trx' => $value3->tgl_trx,
        	                				'tgl_proses' => $value3->tgl_proses,
        	                				'jenis_sp2d_retur' => $value3->jenis_sp2d_retur,
        	                				'bank' => $value3->bank,
        	                				'nominal' => $value3->nominal,
                                            'jenis_sp2d' => $value3->jenis_sp2d,
        	                				'keterangan' => $value3->keterangan,
        	                				'nama_unit' => $nama_unit_subunit,
        	                			);

        	                			$total_sp2d = $total_sp2d + $value3->nominal;
        	                		}
        	                	}
        	                	$new_list[$key2]['total_sp2d'] = $total_sp2d;
        	                	$new_list[$key2]['persentase'] = number_format(($total_sp2d +  $value2['potongan_lainnya']) / $value2['nominal_cair'] * 100,2);
        	                	$new_list[$key2]['persentase'] .= '%';

        	                }
                        }else{
                            $new_list = array();
                        }
	                // vdebug($new_list);
           

                if ($bulan != '') {
                    $no_spm_sp2d_retur_per_bulan = $this->sp2d_model->get_no_spm_sp2d_retur_per_bulan($bulan);
                    // vdebug($no_spm_sp2d_retur_per_bulan);
                    foreach ($new_list as $key => $value) {
                        foreach ($no_spm_sp2d_retur_per_bulan as $key2 => $value2) {
                            if ($key == $key2) {
                                $newest_list[$key2] = $value;
                            }
                        }
                    }

                    $subdata['list_sp2d']           = $newest_list;
                }else{
                    $subdata['list_sp2d']           = $new_list;
                }

                $subdata['cetak_sp2d'] = $this->sp2d_model->cetak_daftar_sp2d();
                // vdebug($subdata['cetak_sp2d']);
                $subdata['tahun']			    = $this->cur_tahun;
                $data['main_content']           = $this->load->view("rsa_sp2d/sp2d_per_spm",$subdata,TRUE);

                $this->load->view('main_template',$data);
        }else{
                redirect('welcome','refresh');
        }
    }

    function cetak_sp2d_retur($no_sp2d_retur=""){

        $no_sp2d_retur = base64_decode(urldecode($no_sp2d_retur));
        $nomor = substr($no_sp2d_retur,9,4);

        if($nomor == 'SP2D'){
                     // urlencode(base64_encode($no_spm));
            // $data['cur_tahun']              = $this->cur_tahun;
            // $data['main_menu']              = $this->load->view('main_menu','',TRUE);
            $subdata['cetak_sp2d']          = $this->sp2d_model->cetak_daftar_sp2d($no_sp2d_retur);
            // $data['main_content']           = $this->load->view("rsa_sp2d/cetak_daftar_sp2d",$subdata,TRUE);
            // vdebug($subdata['cetak_sp2d']);
            $this->load->view('rsa_sp2d/cetak_sp2d',$subdata);
            
        }else{
            // urlencode(base64_encode($no_spm));
            // $data['cur_tahun']              = $this->cur_tahun;
            // $data['main_menu']              = $this->load->view('main_menu','',TRUE);
            $subdata['cetak_sp2d']          = $this->sp2d_model->cetak_daftar_sp2d($no_sp2d_retur);
            // $data['main_content']           = $this->load->view("rsa_sp2d/cetak_daftar_retur",$subdata,TRUE);
            // vdebug($subdata['cetak_sp2d']);
            $this->load->view('rsa_sp2d/cetak_retur',$subdata);
        }
        
    }

    public function daftar_sp2d_100($tahun="",$kode_unit_subunit="",$jenis='',$bulan=''){
                    
                    
        $data['cur_tahun'] =  $this->cur_tahun;
        
        if($tahun == ''){
            $tahun = $this->cur_tahun ;
        }

        if(($kode_unit_subunit == '')||($kode_unit_subunit == '99')){
            $kode_unit_subunit = '99' ;
            $subdata['kode_unit_subunit'] = 'SEMUA' ;
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
        if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==55)||($this->check_session->get_level()==11))){

                $data['main_menu']              = $this->load->view('main_menu','',TRUE);
                $subdata['daftar_spm']          = $this->sp2d_model->get_spm_cair($tahun,$kode_unit_subunit,$jenis,$bulan,'sp2d_100');
        // vdebug($bulan);

                // vdebug($subdata['daftar_spm']);
                $subdata['tahun']               = $this->cur_tahun ;

                $subdata['cur_tahun']           = $this->cur_tahun ;
                $subdata['data_unit']           = $this->unit_model->get_all_unit();
                $data['main_content']           =  $this->load->view("rsa_sp2d/daftar_sp2d_100",$subdata,TRUE);
                /*  Load main template  */
                // echo '<pre>';var_dump($subdata['daftar_spm']);echo '</pre>';die;
                $this->load->view('main_template',$data);
        }else{
                redirect('welcome','refresh');  // redirect ke halaman home
        }
    }
}

