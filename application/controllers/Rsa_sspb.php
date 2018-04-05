<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Rsa_sspb extends CI_Controller{
/* -------------- Constructor ------------- */
            
    private $cur_tahun;
	public function __construct(){ 
		parent::__construct();
			//load library, helper, and model
		$this->cur_tahun = $this->setting_model->get_tahun();
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model('menu_model');
		$this->load->model('rsa_sspb_model');
		$this->load->helper("security");
		$this->load->helper("vayes_helper");
                        
	}
		
		#methods ======================
		
		//define method index()
	public function index(){
        /* check session    */
        $data['cur_tahun'] = $this->cur_tahun ;
        if($this->check_session->user_session() && ($this->check_session->get_level()==13 || $this->check_session->get_level()==2 || $this->check_session->get_level()==3 || $this->check_session->get_level()==11 || $this->check_session->get_level()==14)){


            $unit = $this->check_session->get_unit();
            $level = $this->check_session->get_level(); 
        // vdebug($subdata['dana_pumk']);
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
            $data['main_content'] =  $this->load->view('rsa_sspb/index','',TRUE);

            $this->load->view('main_template',$data);
        }else{
        redirect('welcome','refresh');  // redirect ke halaman home
        }
    }

    function daftar_spm(){
        $data['cur_tahun'] = $this->cur_tahun ;
        if($this->check_session->user_session()){


            $unit = $this->check_session->get_unit();
            $level = $this->check_session->get_level(); 

            $subdata['spm_cair'] = $this->rsa_sspb_model->get_spm_cair($unit);
        // vdebug($subdata['dana_pumk']);
            $data['main_content'] =  $this->load->view('rsa_sspb/daftar_spm',$subdata,TRUE);
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);

            $this->load->view('main_template',$data);
        }else{
        redirect('welcome','refresh');  // redirect ke halaman home
        }
    }

    function daftar_akun_belanja($jenis="",$spm=""){
         $data['cur_tahun'] = $this->cur_tahun ;
        if($this->check_session->user_session()){
            $unit = $this->check_session->get_unit();
            $level = $this->check_session->get_level(); 

             if($spm != ''){
                    $spm = base64_decode(urldecode($spm));
                     // urlencode(base64_encode($no_spm));
                    $subdata['akun'] = $this->rsa_sspb_model->get_akun_belanja($jenis,$spm);
                    $subdata['spm'] = $spm;

                }else {
                	redirect('rsa_sspb/daftar_spm');
                }
                
        // vdebug($subdata);
            $data['main_content'] =  $this->load->view('rsa_sspb/daftar_akun_belanja',$subdata,TRUE);
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);

            $this->load->view('main_template',$data);
        }else{
            redirect('welcome','refresh');  // redirect ke halaman home
        }
    }
    
    function modal_tambah_sspb(){

        $kode = $this->input->post("nomor");
        $jenis = $this->input->post("jenis");
        $spm = $this->input->post("spm");
        $subdata['data_akun']           = $this->rsa_sspb_model->get_data_akun($kode,$jenis);
        $subdata['bank']           = $this->rsa_sspb_model->get_bank();
        $subdata['spm'] = $spm;

        $alias_unit = substr($spm,5,3);
		$get_new_nomor   		= $this->rsa_sspb_model->get_new_nomor($alias_unit);
		$no_urut      			= intval(ltrim($get_new_nomor, '0'));
		$new_no_urut  			= $no_urut + 1;
		$the_no_urut  			= sprintf('%04d', $new_no_urut);
		$bulan        			= array("","JAN","FEB","MAR","APR","MEI","JUN","JUL","AGU","SEP","OKT","NOV","DES");
		$bln          			= $bulan[date("n")];
		$new_no_sspb      		= $the_no_urut.'/'.$alias_unit.'/SSPB-'.$jenis.'/'.$bln.'/'.date('Y');

		$subdata['nomor_sspb'] = $new_no_sspb;
        // vdebug($subdata);

        $this->load->view('rsa_sspb/modal_sspb',$subdata);
    }

    function exec_add_sspb(){
        if($this->input->post()){
            if($this->check_session->user_session() && $this->check_session->get_level()==13){

                $this->form_validation->set_rules('nomor_spm','Nomor_spm','required'); 
                $this->form_validation->set_rules('kode_usulan_belanja','Kode_usulan_belanja','required'); 
                $this->form_validation->set_rules('kode_akun_tambah','Kode_akun_tambah','required');
                $this->form_validation->set_rules('deskripsi','Deskripsi','required');
                $this->form_validation->set_rules('tgl_sspb','Tgl_sspb','required');
                $this->form_validation->set_rules('nominal_pengembalian','Nominal_pengembalian','required');
                $this->form_validation->set_rules('nomor_sspb','Nomor_sspb','required');
                $this->form_validation->set_rules('bank','Bank','required');
                $this->form_validation->set_rules('keterangan','Keterangan','required');

                $unit = $this->check_session->get_unit();
                $kode_usulan_belanja = $this->input->post("kode_usulan_belanja");
                $kode_akun_tambah = $this->input->post("kode_akun_tambah");

              
                // vdebug($no_spm);

                if ($this->form_validation->run()){

                    $data = array(
                        "kode_unit_subunit"             => $unit,
                        "nomor_trx_spm"                 => $this->input->post("nomor_spm"),
                        "nomor_sspb"                 	=> $this->input->post("nomor_sspb"),
                        "deskripsi"                 	=> $this->input->post("deskripsi"),
                        "kode_usulan_belanja"           => $this->input->post("kode_usulan_belanja"),
                        "kode_akun_tambah"              => $this->input->post("kode_akun_tambah"),
                        "jumlah_bayar"                  => $this->input->post("nominal_pengembalian"),
                        "terbilang"                     => preg_replace('/\s\s+/', ' ',$this->convertion->terbilang((int)$this->input->post("nominal_pengembalian"))),
                        "tgl_sspb"                      => $this->input->post("tgl_sspb"),
                        "nmbank"						=> 'Mandiri',
                        "nmrekening"					=> 'Bank Mandiri Operasional',
                        "rekening"						=> '1360020170319',
                        "akun_bank"                     => $this->input->post("bank"),
                        "keterangan"                    => $this->input->post("keterangan"),
                        "tahun"                         => $this->cur_tahun,

                        "nmbendahara"                   => $this->rsa_sspb_model->get_bendahara($unit)->nm_lengkap,
                        "nipbendahara"                  => $this->rsa_sspb_model->get_bendahara($unit)->nomor_induk,
                        "nmppk"                         => $this->rsa_sspb_model->get_ppksukpa($unit)->nm_lengkap,
                        "nipppk"                        => $this->rsa_sspb_model->get_ppksukpa($unit)->nomor_induk,
                        "nmkpa"                         => $this->rsa_sspb_model->get_kpa($unit)->nm_lengkap,
                        "nipkpa"                        => $this->rsa_sspb_model->get_kpa($unit)->nomor_induk,
                        "nmverifikator"                 => $this->rsa_sspb_model->get_verifikator($unit)->nm_lengkap,
                        "nipverifikator"                => $this->rsa_sspb_model->get_verifikator($unit)->nomor_induk,
                        "nmkbuu"                        => $this->rsa_sspb_model->get_kuasabuu()->nm_lengkap,
                        "nipkbuu"                       => $this->rsa_sspb_model->get_kuasabuu()->nomor_induk,
                        "nmbuu"                         => $this->rsa_sspb_model->get_buu()->nm_lengkap,
                        "nipbuu"                        => $this->rsa_sspb_model->get_buu()->nomor_induk

                    );

                    $data2 = array(
                    	"kode_unit_subunit"             => $unit,
                        "nomor_trx_spm"                 => $this->input->post("nomor_spm"),
                        "nomor_sspb"                 	=> $this->input->post("nomor_sspb"),
                        "posisi"                 		=> 'SSPB-DRAFT',
                        "ket"           				=> '',
                        "aktif"           				=> 1,
                        "tahun"           				=> date("Y"),
                        "tgl_proses"           			=> date("Y-m-d"),
                    );
                // vdebug($data);
                    	$nomor_sspb = $this->input->post("nomor_sspb");
                        $sspb = $this->rsa_sspb_model->add_sspb($data);
                        $trx_sspb = $this->rsa_sspb_model->add_trx_sspb($data2);
                        if($sspb && $trx_sspb){
                        	$par = urlencode(base64_encode($nomor_sspb));
                        	redirect('rsa_sspb/cetak_sspb/'.$par.'');
                        }
                        else{
                            vdebug($sspb);
                        }
                }
            }else{
                show_404('page');
            }
        }
    }

    function cetak_sspb($sspb=""){

    	if($sspb != ''){
    		$sspb = base64_decode(urldecode($sspb));
                     // urlencode(base64_encode($no_spm));
    		$unit = $this->check_session->get_ori_unit();
    		$data['cur_tahun'] = $this->cur_tahun ;
    		$data['main_menu']  = $this->load->view('main_menu','',TRUE);
    		$subdata = $this->rsa_sspb_model->get_data_sspb($sspb);
            $subdata->doc = $this->rsa_sspb_model->get_status($sspb)->posisi;
            $subdata->ket = $this->rsa_sspb_model->get_status($sspb)->ket;
            $subdata->cur_tahun = $this->cur_tahun;
            $level = $this->check_session->get_level();
			$subdata->level = $level;
    		// vdebug($subdata);
    		$data['main_content'] = $this->load->view('rsa_sspb/cetak_sspb',$subdata,TRUE);
    		$this->load->view('main_template',$data);

    	}else{
    		redirect('rsa_sspb/daftar_spm','refresh');
    	}
    	
    }

    function daftar_unit_($username=""){
    	if($this->check_session->user_session()){

    		$level = $this->check_session->get_level();
    		if ($level == 11) {
    			$subdata['unit'] = $this->rsa_sspb_model->daftar_unit_kbuu();
    		}else{
    			$subdata['unit'] = $this->rsa_sspb_model->daftar_unit_verifikator($username);

    		}
        // vdebug($subdata['unit']);
    		$data['cur_tahun'] = $this->cur_tahun ;
    		$data['main_menu']  = $this->load->view('main_menu','',TRUE);
    		$data['main_content'] = $this->load->view('rsa_sspb/daftar_unit',$subdata,TRUE);
    		$this->load->view('main_template',$data);
    	}else{
        redirect('welcome','refresh');  // redirect ke halaman home
        }
    }

    function daftar_sspb($unit=""){
    	if($this->check_session->user_session()){


	    		if ($unit !="") {
	            $unit = $unit;// $unit = $this->input->post("unit");
	        } else{
	        	$unit = $this->check_session->get_ori_unit();
	        }
	        $data['cur_tahun'] = $this->cur_tahun ;
	        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
	        $subdata['daftar_sspb'] = $this->rsa_sspb_model->daftar_sspb($unit);
	        $subdata['total_sspb'] = $this->rsa_sspb_model->total_sspb($unit);

	        $data['main_content'] = $this->load->view('rsa_sspb/daftar_sspb',$subdata,TRUE);
	        $this->load->view('main_template',$data);
	    }else{
	        redirect('welcome','refresh');  // redirect ke halaman home
	    }
	}

    function update_status_setuju(){
    	$nomor_sspb = $this->input->post("nomor_sspb");
    	$nomor_spm = $this->input->post("nomor_trx_spm");
    	$unit = $this->rsa_sspb_model->get_unit($nomor_sspb);
    	$level = $this->check_session->get_level();

    	if ($level == '14') {
    		$posisi = 'SSPB-DRAFT-PPK';
    	}elseif ($level == '2') {
    		$posisi = 'SSPB-DRAFT-KPA';
    	}if ($level == '3') {
    		$posisi = 'SSPB-FINAL-VERIFIKATOR';
    		$data2 = array(
    			"tgl_verif" => date("Y-m-d")
    			);
    		$set_tanggal = $this->rsa_sspb_model->set_tanggal($data2,$nomor_sspb);
    	}if ($level == '11') {
    		$posisi = 'SSPB-FINAL-KBUU';
    		$data2 = array(
    			"tgl_kbuu" => date("Y-m-d"),
    			);
    		$set_tanggal = $this->rsa_sspb_model->set_tanggal($data2,$nomor_sspb);
    	}

    	$set_aktif = $this->rsa_sspb_model->set_aktif($nomor_sspb);
    	$data = array(
    		"kode_unit_subunit"             => $unit,
    		"nomor_trx_spm"                 => $nomor_spm,
    		"nomor_sspb"                 	=> $nomor_sspb ,
    		"posisi"                 		=> $posisi,
    		"ket"           				=> '',
    		"aktif"           				=> 1,
    		"tahun"           				=> date("Y"),
    		"tgl_proses"           			=> date("Y-m-d H:i:s")
    	);
    	$trx_sspb = $this->rsa_sspb_model->add_trx_sspb($data);

    	if($set_aktif && $trx_sspb){
    		echo "true";
    	}
    }

    function modal_tolak(){
    	$nomor_sspb = $this->input->post("nomor_sspb");
    	$nomor_spm = $this->input->post("nomor_trx_spm");
    	$subdata['nomor_sspb'] = $nomor_sspb;
    	$subdata['nomor_spm'] = $nomor_spm;

    	$this->load->view('rsa_sspb/modal_tolak',$subdata);
    }

     function update_status_tolak(){
    	$nomor_sspb = $this->input->post("nomor_sspb");
    	$nomor_spm = $this->input->post("nomor_trx_spm");
    	$ket = $this->input->post("ket");
    	$unit = $this->rsa_sspb_model->get_unit($nomor_sspb);
    	$level = $this->check_session->get_level();

    	if ($level == '14') {
    		$posisi = 'SSPB-DITOLAK-PPK';
    	}elseif ($level == '2') {
    		$posisi = 'SSPB-DITOLAK-KPA';
    	}if ($level == '3') {
    		$posisi = 'SSPB-DITOLAK-VERIFIKATOR';
    	}if ($level == '11') {
    		$posisi = 'SSPB-DITOLAK-KBUU';
    	}

    	$set_aktif = $this->rsa_sspb_model->set_aktif($nomor_sspb);
    	$data = array(
    		"kode_unit_subunit"             => $unit,
    		"nomor_trx_spm"                 => $nomor_spm,
    		"nomor_sspb"                 	=> $nomor_sspb ,
    		"posisi"                 		=> $posisi,
    		"ket"           				=> $ket,
    		"aktif"           				=> 1,
    		"tahun"           				=> date("Y"),
    		"tgl_proses"           			=> date("Y-m-d")
    	);
    	$trx_sspb = $this->rsa_sspb_model->add_trx_sspb($data);

    	if($set_aktif && $trx_sspb){
    		echo "true";
    	}else{
    		echo "false";
    	}
    }

    function get_notif_sspb_approve(){
            $level = $this->check_session->get_level() ;
            $user = $this->check_session->get_username();
            $unit =  $this->check_session->get_unit();
            $notif_up = $this->rsa_sspb_model->get_notif($level,$user,$unit);

            // vdebug($notif_up);
            echo $notif_up;
    }


}

