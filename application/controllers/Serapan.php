<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Serapan extends CI_Controller
{
  private $cur_tahun = '' ;
  	public function __construct()
  	{
    	parent::__construct();
    	$this->cur_tahun = $this->setting_model->get_tahun();

    	 if ($this->check_session->user_session()){
  			/* Load library, helper, dan Model */
	  		$this->load->library(array('form_validation','option'));
	  		$this->load->helper('form');
	  		$this->load->model('serapan_model');
	      $this->load->model('user_model');
	  		$this->load->model('menu_model');
	  		$this->load->model('unit_model');
	  		$this->load->model('subunit_model');
	  		$this->load->model('master_unit_model');
		}else{
      		redirect('welcome','refresh');	// redirect ke halaman home
	  	}

	}

	function index($sumber_dana = '',$triwulan = '',$unit = '')
	{
		/* check session	*/
		if($this->check_session->user_session()){
			// var_dump($subdata['detail_rsa_kontrak']);die;
			if($sumber_dana == ''){
				$sumber_dana = 'SELAIN-APBN';
			}
			if($unit == ''){
				$unit = $this->check_session->get_unit();
			}
			if($triwulan == ''){
				$triwulan = '5';
			}

			// echo $sumber_dana .' - '. $unit .' - '. $this->cur_tahun ; die ;
			// $subdata['data_akun'] = $this->serapan_model->get_akun($sumber_dana,$unit,$this->cur_tahun,$triwulan);
			// $subdata['data_anggaran'] = $this->serapan_model->get_anggaran($sumber_dana,$unit,$this->cur_tahun);
			// $subdata['data_serapan'] = $this->serapan_model->get_serapan($sumber_dana,$unit,$this->cur_tahun,$triwulan);
			$subdata['data_anggaran_serapan'] = $this->serapan_model->get_data_anggaran_serapan($sumber_dana,$unit,$this->cur_tahun,$triwulan)->data;
			$subdata['anggaran_all'] = $this->serapan_model->get_data_anggaran_serapan($sumber_dana,$unit,$this->cur_tahun,$triwulan)->anggaran;
			$subdata['serapan_all'] = $this->serapan_model->get_data_anggaran_serapan($sumber_dana,$unit,$this->cur_tahun,$triwulan)->serapan;
			$subdata['jumlah_proses'] = $this->serapan_model->get_total_proses($sumber_dana,$unit,$this->cur_tahun,$triwulan);
			// vdebug($subdata['jumlah_proses']);
			// echo '<pre>' ;
			// var_dump($subdata) ; 
			// echo '</pre>' ; 
			// die ;

			$subdata['tahun'] =  $this->cur_tahun;
			$subdata['unit'] =  $unit ; 
			$subdata['r_unit'] =  $this->check_session->get_unit();
			$subdata['triwulan'] =  $triwulan;
			if($this->check_session->get_unit() == '99'){
				$subdata['data_unit'] = $this->unit_model->get_all_unit();
				// var_dump($this->unit_model->get_all_unit()); die;
			}
			$subdata['sumber_dana'] =  $sumber_dana;
			$subdata['a_tab'] = 'a-undip';

			$cur_triwulan = '' ;

			if($triwulan == '5'){
					$cur_triwulan = 'S/D SEKARANG' ;
			}elseif($triwulan == '4'){
				$cur_triwulan = 'PER 31 DESEMBER 2017' ;
			}elseif($triwulan == '3'){
				$cur_triwulan = 'PER 30 SEPTEMBER 2017' ;
			}elseif($triwulan == '2'){
				$cur_triwulan = 'PER 30 JUNI 2017' ;
			}else{
				$cur_triwulan = 'PER 31 MARET 2017' ;
			}

			$subdata['cur_triwulan'] 	= $cur_triwulan;
			$data['cur_tahun'] 			= $this->cur_tahun;
			$data['main_menu']         = $this->load->view('main_menu','',TRUE);
			$data['main_content'] 		= $this->load->view("serapan/index",$subdata,TRUE);
			/* Load main template	*/
			// echo '<pre>';var_dump($subdata['detail_rsa_kontrak']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

	function gass($sumber_dana = '',$triwulan = '',$unit = '')
	{
		/* check session	*/
		if($this->check_session->user_session()){
			// var_dump($subdata['detail_rsa_kontrak']);die;
			if($sumber_dana == ''){
				$sumber_dana = 'SELAIN-APBN';
			}
			if($unit == ''){
				$unit = $this->check_session->get_unit();
			}
			if($triwulan == ''){
				$triwulan = '5';
			}

			// echo $sumber_dana .' - '. $unit .' - '. $this->cur_tahun ; die ;
			$subdata['data_akun'] = $this->serapan_model->get_akun($sumber_dana,$unit,$this->cur_tahun,$triwulan);
			$subdata['data_anggaran'] = $this->serapan_model->get_anggaran($sumber_dana,$unit,$this->cur_tahun);
			$subdata['data_serapan'] = $this->serapan_model->get_serapan($sumber_dana,$unit,$this->cur_tahun,$triwulan);
			// $subdata['data_anggaran_serapan'] = $this->serapan_model->get_data_anggaran_serapan($sumber_dana,$unit,$this->cur_tahun,$triwulan);
			// vdebug($subdata['data_anggaran_serapan']);

			// echo '<pre>' ;
			// var_dump($subdata) ; 
			// echo '</pre>' ; 
			// die ;

			$subdata['tahun'] =  $this->cur_tahun;
			$subdata['unit'] =  $unit ; 
			$subdata['r_unit'] =  $this->check_session->get_unit();
			$subdata['triwulan'] =  $triwulan;
			if($this->check_session->get_unit() == '99'){
				$subdata['data_unit'] = $this->unit_model->get_all_unit();
				// var_dump($this->unit_model->get_all_unit()); die;
			}
			$subdata['sumber_dana'] =  $sumber_dana;
			$subdata['a_tab'] = 'a-undip';

			$cur_triwulan = '' ;

			if($triwulan == '5'){
					$cur_triwulan = 'S/D SEKARANG' ;
			}elseif($triwulan == '4'){
				$cur_triwulan = 'PER 31 DESEMBER 2017' ;
			}elseif($triwulan == '3'){
				$cur_triwulan = 'PER 30 SEPTEMBER 2017' ;
			}elseif($triwulan == '2'){
				$cur_triwulan = 'PER 30 JUNI 2017' ;
			}else{
				$cur_triwulan = 'PER 31 MARET 2017' ;
			}

			$subdata['cur_triwulan'] 	= $cur_triwulan;
			$data['cur_tahun'] 			= $this->cur_tahun;
			$data['main_menu']         = $this->load->view('main_menu','',TRUE);
			$data['main_content'] 		= $this->load->view("serapan/index_old",$subdata,TRUE);
			/* Load main template	*/
			// echo '<pre>';var_dump($subdata['detail_rsa_kontrak']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

	function dikti($sumber_dana = '',$triwulan = '',$unit = '')
	{
		/* check session	*/
		if($this->check_session->user_session()){
			// var_dump($subdata['detail_rsa_kontrak']);die;
			if($sumber_dana == ''){
				$sumber_dana = 'SELAIN-APBN';
			}
			if($unit == ''){
				$unit = $this->check_session->get_unit();
			}
			if($triwulan == ''){
				$triwulan = '5';
			}
			$subdata['data_akun'] = $this->serapan_model->get_akun_dikti($sumber_dana,$unit,$this->cur_tahun,$triwulan);
			$subdata['data_anggaran'] = $this->serapan_model->get_anggaran_dikti($sumber_dana,$unit,$this->cur_tahun);
			$subdata['data_serapan'] = $this->serapan_model->get_serapan_dikti($sumber_dana,$unit,$this->cur_tahun,$triwulan);
			// echo '<pre>' ;
			// var_dump($subdata) ; 
			// echo '</pre>' ; 
			// die ;
			$subdata['tahun'] =  $this->cur_tahun;
			$subdata['unit'] =  $unit ; 
			$subdata['r_unit'] =  $this->check_session->get_unit();
			$subdata['triwulan'] =  $triwulan;
			if($this->check_session->get_unit() == '99'){
				$subdata['data_unit'] = $this->unit_model->get_all_unit();
				// var_dump($this->unit_model->get_all_unit()); die;
			}
			$subdata['sumber_dana'] =  $sumber_dana;
			$subdata['a_tab'] = 'a-dikti';

			$cur_triwulan = '' ;

			if($triwulan == '5'){
					$cur_triwulan = 'S/D SEKARANG' ;
			}elseif($triwulan == '4'){
				$cur_triwulan = 'PER 31 DESEMBER 2017' ;
			}elseif($triwulan == '3'){
				$cur_triwulan = 'PER 30 SEPTEMBER 2017' ;
			}elseif($triwulan == '2'){
				$cur_triwulan = 'PER 30 JUNI 2017' ;
			}else{
				$cur_triwulan = 'PER 31 MARET 2017' ;
			}

			$subdata['cur_triwulan'] =  $cur_triwulan;
			
			$data['cur_tahun'] =  $this->cur_tahun;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
			$data['main_content'] 		= $this->load->view("serapan/dikti",$subdata,TRUE);
			/* Load main template	*/
			// echo '<pre>';var_dump($subdata['detail_rsa_kontrak']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}
	function get_anggaran($kode_akun,$sumber_dana,$unit,$tahun){
		/* check session	*/
		if($this->check_session->user_session()){
			// var_dump($subdata['detail_rsa_kontrak']);die;
			$anggaran =  $this->serapan_model->get_anggaran($kode_akun,$sumber_dana,$unit,$tahun);
			echo $anggaran ; 

		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

	}
	function get_anggaran_dikti($kode_akun,$sumber_dana,$unit,$tahun){
		/* check session	*/
		if($this->check_session->user_session()){
			// var_dump($subdata['detail_rsa_kontrak']);die;
			$anggaran =  $this->serapan_model->get_anggaran_dikti($kode_akun,$sumber_dana,$unit,$tahun);
			echo $anggaran ; 

		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

	}
	function get_serapan($kode_akun,$sumber_dana,$unit,$tahun,$triwulan){
		/* check session	*/
		if($this->check_session->user_session()){
			// var_dump($subdata['detail_rsa_kontrak']);die;
			$anggaran =  $this->serapan_model->get_serapan($kode_akun,$sumber_dana,$unit,$tahun,$triwulan);
			echo $anggaran ; 

		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

	function get_serapan_dikti($kode_akun,$sumber_dana,$unit,$tahun,$triwulan){
		/* check session	*/
		if($this->check_session->user_session()){
			// var_dump($subdata['detail_rsa_kontrak']);die;
			$anggaran =  $this->serapan_model->get_serapan_dikti($kode_akun,$sumber_dana,$unit,$tahun,$triwulan);
			echo $anggaran ; 

		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

	}
	function tes(){
		
		$id_kuitansi =  $this->serapan_model->get_kuitansi();

		$this->load->view('serapan/tes',$data);
	}

}