<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Dpa extends CI_Controller {
    
    private $cur_tahun = '' ;
	
    public function __construct()
    {
            parent::__construct();
            
            $this->cur_tahun = $this->setting_model->get_tahun();
            
            if ($this->check_session->user_session()){
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option','convertion'));
		$this->load->helper(array('form'));
		$this->load->model('dpa_model');
		$this->load->model('menu_model');
		$this->load->model('unit_model');
		$this->load->model('subunit_model');
		$this->load->model('master_unit_model'); 
		$this->load->model('geser_model'); 
		$this->load->model('master_unit_model');
		$this->cur_tahun = $this->setting_model->get_tahun();
	
            }else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
    }
    function index(){
        if($this->check_session->get_level()==1){ // AKUNTANSI	/*	Jika session user yang aktif unit fakultas	/ biro */
                redirect('dpa/daftar_unit','refresh');
        }
        elseif($this->check_session->get_level()==2){ // KPA	/*	Jika session user yang aktif unit fakultas	/ biro */
                redirect('dpa/dashboard_dpa','refresh');
        }
        elseif($this->check_session->get_level()==13){ // BENDAHARA	/*	Jika session user yang aktif unit fakultas	/ biro */
                redirect('dpa/dashboard_dpa','refresh');
        }
        elseif($this->check_session->get_level()==14){ // PPK	/*	Jika session user yang aktif unit fakultas	/ biro */
                redirect('dpa/dashboard_dpa','refresh');
        }
        elseif($this->check_session->get_level()==4){ // PUMK	/*	Jika session user yang aktif unit fakultas	/ biro */
                redirect('dpa/dashboard_dpa','refresh');
        }
        elseif($this->check_session->get_level()==3){ // VERIFIKATOR	/*	Jika session user yang aktif unit fakultas	/ biro */
                //redirect('dpa/daftar_validasi_dpa','refresh');
            redirect('dpa/dashboard_dpa','refresh');
        }
        elseif($this->check_session->get_level()==100){
            redirect('dpa/daftar_unit','refresh');
        }

    }
    
    function dashboard_dpa(){
        $data['cur_tahun'] = $this->cur_tahun ;
            $data['main_menu']              = $this->load->view('main_menu','',TRUE);
//            $subdata['unit_usul'] 		= $this->dpa_model->get_dpa_unit_usul('SELAIN-APBN','2017');
//            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
            $data['main_content'] 		= $this->load->view("dpa/dashboard_dpa",'',TRUE);
            /*	Load main template	*/
//			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
            $this->load->view('main_template',$data);
        
    }
	 function cetak_dpa(){ 
			//var_dump(sumber_dana);die;
			//echo "<pre>";
			$array = $this->uri->uri_to_assoc(3);
			$unit = $array['unit'];
            $sumber_dana = $array['sumber_dana'];
            $tahun = $array['tahun'];
			//var_dump($unit);die;
			$data['main_menu']  = $this->load->view('main_menu','',TRUE);
 			//$u_unit = $kode_unit;
			$tahun=$this->setting_model->get_tahun();			
			$subdata['sumber_dana']         = $sumber_dana ;
			//$terbilang=$this->convertion->terbilang();	
			
			//$subdata['result_unit_usul'] 	= $this->dpa_model->get_dpa_unit_usul_ya('SELAIN-APBN','2017',$kode_unit);
			$subdata['result_program_usul'] 	= $this->dpa_model->get_program_unit_usul_idris($unit,$sumber_dana,$tahun);
			$text_program = array();
			// $data['text_program']=array();
			
			foreach($subdata['result_program_usul'] as $r){
				$kode=$r->kode_usulan_belanja;
				//$kode=substr($kodex,0,16);
				$subdata['text_sasaran'][substr($kode,6,4)] = $this->dpa_model->get_single_output(array('kode_kegiatan'=>substr($kode,6,2),'kode_output'=>substr($kode,9,2)),'nama');
				$subdata['text_program'][substr($kode,6,6)] = $this->dpa_model->get_single_program(array('kode_kegiatan'=>substr($kode,7,2),'kode_output'=>substr($kode,9,2),'kode_program'=>substr($kode,11,2)),'nama');
				
			}
			
			#echo "<pre>";
			#print_r($subdata);
			#echo "</pre>";
			#exit;
			
			// var_dump($data['text_program']); exit;
			//print_r($subdata['result_program_usul']);exit;
			
			//$data[''];
			/*foreach($l as $a => $b){
				$l[$a]=array_unique($b);
			}*/
			/*
			$html = "<table border=\"1\" style=\"border-collapse:collapse;margin:-1;\">";
			$html.= "<tr><th>TUJUAN</th><th>SASARAN</th><th>PROGRAM</th></tr>";
			foreach( $k as $x1 => $x2 ){
				$html.= "<tr>";
				$html.= "<td>".$x2."</td>";
				$html.= "<td><table border=\"1\" style=\"border-collapse:collapse;margin:-1;\">";
				foreach( $j[$x2] as $x3 => $x4 ){
					$html.= "<tr>";
					$html.= "<td>".$x4."</td>";
					$html.= "</tr>";
				}
				$html.= "</table></td>";
				$html.= "<td><table border=\"1\" style=\"border-collapse:collapse;margin:-1;\">";
				foreach( $j[$x2] as $x3 => $x4 ){
					foreach( $l[$x4] as $x5 => $x6 ){
						$html.= "<tr>";
						$html.= "<td>".$x6[0]."</td>";
						$html.= "<td align=\"right\">Rp. ".number_format($x6[1],2,",",".")."</td>";
						$html.= "</tr>";
					}
				}
				$html.= "</table></td>";
				$html.= "</tr>";
			}
			$html.= "</table>";
			echo $html; exit;
			*/
			// print_r($l); echo "</pre>"; exit;
			
			$subdata['result_jumlah_usul'] 	= $this->dpa_model->get_jumlah_unit_usul_idris($unit,$sumber_dana,$tahun);
			$subdata['terbilang'] = $this->convertion->terbilang($subdata['result_jumlah_usul'][0]->total);
			//var_dump($subdata['result_jumlah_usul']);die;
			$data['main_content'] 		= $this->load->view("dpa/cetak_dpa",$subdata,TRUE);
			
			
			
            /*	Load main template	*/
//			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
            $this->load->view('main_template',$data);
			
        
    }
	function cetak_dpa2(){    
			$data['main_menu']  = $this->load->view('main_menu','',TRUE);
			$array = $this->uri->uri_to_assoc(3);
			$u_unit = $array['unit'];
            $sumber_dana = $array['sumber_dana'];
            $tahun = $array['tahun'];
			//var_dump($kode_unit);
			$data['unit'] = $this->unit_model->get_single_unit($u_unit,'nama');
			$data['kode_unit'] =$u_unit;
			$result_usulan = $this->dpa_model->get_all_ket_subkomponen_input($u_unit,$sumber_dana,$tahun);
            //echo '<pre>';var_dump($result_usulan);echo '</pre>'; die;
			// echo '<pre>';echo $this->check_session->get_unit();echo '</pre>'; die;
			$result_usulan_total = $this->dpa_model->get_all_total_usulan_belanja($result_usulan);
			$kode =  array();
					foreach($result_usulan as $r){
						$kode[] = array('kode_subkomponen_input' => $r->kode_subkomponen_input,'indikator_keluaran' => $r->indikator_keluaran,'volume' => $r->volume);
					}
			$data['kode'] = $kode;
					$rincian_kode_usulan =  array();
					foreach($result_usulan as $r){
						$rincian_kode_usulan[] = $this->dpa_model->get_rincian_kode_usulan($r->kode_subkomponen_input); 
					}

					$data['rincian_kode_usulan'] = $rincian_kode_usulan;
                                       $rekap_belanja = $this->dpa_model->get_rekap_usulan_belanja_by_sd($u_unit,$sumber_dana,$tahun);
                                        $data_rekap_belanja =  array();   
                                        $r_u_unit = array() ;
                                        $r_kode_akun = array() ;
                                        $r_total_b = array() ;
                                        $in = 0 ;          
					foreach($rekap_belanja as $r){
                                        if (!(in_array($r->u_unit.$r->kriteria_usul, $r_u_unit))){
                                        $r_kode_akun = array() ;
                                                    $r_total_b = array() ;
                                                    $r_kode_akun[] = $r->kode_akun ;
                                                    $r_total_b[] = $r->total_b ;
                                                    
                                                    $data_rekap_belanja[$in] = array(
                                                                                    'u_unit' => $r->u_unit,
                                                                                    'kriteria_usul' => $r->kriteria_usul,
                                                                                    'volume_b' => $this->dpa_model->get_rekap_volume_subkomponen_input($r->u_unit, $r->kriteria_usul, $tahun),
                                                                                    'kode_akun' => $r_kode_akun,
                                                                                    'total_b' => $r_total_b
                                                                            );
                                                    
                                                    $r_u_unit[] = $r->u_unit.$r->kriteria_usul ;
//                                                    $r_kriteria_usul[] = $r->kriteria_usul ;
                                                    $in++;
                                                    
                                                }else{
                                                    
                                                    $data_rekap_belanja[$in - 1]['kode_akun'][] = $r->kode_akun ;
                                                    $data_rekap_belanja[$in - 1]['total_b'][] = $r->total_b ;
                                                    
                                                    
                                                }
                                                
                                                    
					}

					$data['data_rekap_belanja'] = $data_rekap_belanja;
                                        
                                        ///

					// $data_sum_total_belanja =  0;
					$akun_dipakai = array();
                                        
                                        $r_akun_dipakai = $this->dpa_model->get_all_used_akun_belanja($u_unit,$sumber_dana,$tahun);

					foreach($r_akun_dipakai as $data_){
						// if($data_){
							// foreach($data_ as $data__){
//								$data_sum_total_belanja = $data_sum_total_belanja + ($data__->harga_satuan * $data__->volume) ;
                                                                // $data_sum_total_belanja = $data_sum_total_belanja + $data_->total_b ;
//								if (!(in_array($data_->kode_akun, $akun_dipakai))){ 
									$akun_dipakai[] = $data_->kode_akun ;
//								}
							// }

						// }
						
					}
                                        
					$data['akun_dipakai'] = $akun_dipakai;

					// $data['total_by_akun'] = $this->usulan_belanja_model_->get_total_by_akun($data['data_detail_belanja']);

//					echo '<pre>';var_dump($data);echo '</pre>'; die;

					// $this->load->view("layout_rr_01_",$data);
                                        
                                        if($sumber_dana=="APBN-LAINNYA"){
                                            $sumber_dana='SPI & SILPA';
//                                            echo '<pre>';var_dump($data);echo '</pre>'; die;
                                        }
                                        else{
                                            $sumber_dana=$sumber_dana;
                                        }

					//$view =  $this->load->view("dpa/cetak_dpa2",$data,TRUE);
			
			
			$data['main_content'] = $this->load->view("dpa/cetak_dpa2",$data,TRUE);
            $this->load->view('main_template',$data);
			
        
    }
    
    function daftar_unit($tahun="")
    {
        
        $data['cur_tahun'] = $this->cur_tahun ;
		
		/* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==1))){
			
                        
			if(empty($tahun)){
                            $tahun = $this->cur_tahun ;
                        }

            $subdata['cur_tahun']               = $tahun;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
			// $subdata['unit_usul'] 		= $this->dpa_model->get_dpa_unit_usul('SELAIN-APBN','2017');
			$subdata['unit_usul'] 		= $this->dpa_model->get_dpa_unit_usul();
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 		= $this->load->view("dpa/daftar_unit",$subdata,TRUE);

			// var_dump($subdata['unit_usul']); die;
			
			
			
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
    }
    
    function daftar_dpa($sumber_dana = "")
    {
        
        $data['cur_tahun'] = $this->cur_tahun ;
        
//        var_dump($this->check_session->get_unit());die;
		
		/* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                        $unit = $this->check_session->get_unit() ;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
                        if(!empty($sumber_dana)){
                            $subdata['rsa_usul'] 	= $this->dpa_model->get_dpa_program_usul($unit,$sumber_dana,$this->cur_tahun);
                        }
                        $subdata['sumber_dana']         = $sumber_dana ;
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 		= $this->load->view("dpa/daftar_dpa",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata['rsa_usul']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
    }
    
    function daftar_validasi_dpa_ppk($unit,$sumber_dana = "",$tahun="")
    {
        
        $data['cur_tahun'] = $this->cur_tahun ;
		
		/* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){

			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
                        if(empty($tahun)){
                            $tahun = $this->cur_tahun ;
                        }
                        $subdata['cur_tahun']               = $tahun;
			$subdata['unit_usul'] 		= $this->dpa_model->get_dpa_unit_usul('SELAIN-APBN',$tahun);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 		= $this->load->view("dpa/daftar_validasi_dpa",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
    }
    
    function daftar_validasi_dpa($sumber_dana = "",$tahun="")
    {
        
        $data['cur_tahun'] = $this->cur_tahun ;
		
		/* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3))){

			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
                        if(empty($tahun)){
                            $tahun = $this->cur_tahun ;
                        }
                        $subdata['cur_tahun']               = $tahun;
                        $this->load->model('user_model');
                        $user = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
                        $subdata['unit_usul'] 		= $this->dpa_model->get_dpa_unit_usul_verifikator($user->id);
                            
//			$subdata['unit_usul'] 		= $this->dpa_model->get_dpa_unit_usul('SELAIN-APBN',$tahun);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 		= $this->load->view("dpa/daftar_validasi_dpa",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
    }
    
    function daftar_validasi_rsa_ppk($sumber_dana = "")
    {
        
        $data['cur_tahun'] = $this->cur_tahun ;
        
//        var_dump($this->check_session->get_unit());die;
		
		/* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14))){
//                        $unit = $this->check_session->get_unit() ;
                        $unit = $this->check_session->get_unit();
                        $tahun = $this->cur_tahun;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
                        if(!empty($sumber_dana)){
                            $subdata['rsa_usul_to_validate'] 	= $this->dpa_model->get_dpa_program_usul_to_validate_ppk($unit,$sumber_dana,$tahun);
                        }
                        $subdata['sumber_dana']         = $sumber_dana ;
                        $subdata['tahun']         = $tahun ;
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 		= $this->load->view("dpa/daftar_dpa_to_validate_ppk",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata['rsa_usul_to_validate']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
    }
    
    function daftar_validasi_rsa($unit,$sumber_dana = "",$tahun)
    {
        
        $data['cur_tahun'] = $this->cur_tahun ;
        
//        var_dump($this->check_session->get_unit());die;
		
		/* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3))){
//                        $unit = $this->check_session->get_unit() ;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
                        if(!empty($sumber_dana)){
                            $subdata['rsa_usul_to_validate'] 	= $this->dpa_model->get_dpa_program_usul_to_validate($unit,$sumber_dana,$tahun);
                        }
                        $subdata['sumber_dana']         = $sumber_dana ;
                        $subdata['tahun']         = $tahun ;
                        $subdata['unit']         = $unit ;
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 		= $this->load->view("dpa/daftar_dpa_to_validate",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata['rsa_usul_to_validate']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
    }
    
    function tabel_dpa($sumber_dana,$tahun){
        /* check session	*/
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
                    $unit = $this->check_session->get_unit() ;
                    $subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,$sumber_dana,$tahun);
                    $this->load->view("dpa/tabel_dpa",$subdata);
            }else{
                    redirect('welcome','refresh');	// redirect ke halaman home
            }
        
    }
    
    function get_proses_number_to_validate_ppk($sumber_dana,$tahun){
        $unit = $this->check_session->get_unit();
        $result = $this->dpa_model->get_dpa_unit_proses_to_validate_ppk($unit,$sumber_dana,$tahun);
        if($result == 0){
            echo 'usulan baru : <span class="badge">'.$result.'</span>';
        }else{
            echo 'usulan baru : <span class="badge badge-danger">'.$result.'</span>';
        }
    }
    
    function get_proses_number_to_validate($unit,$sumber_dana,$tahun){
        $result = $this->dpa_model->get_dpa_unit_proses_to_validate($unit,$sumber_dana,$tahun);
        if($result == 0){
            echo 'usulan baru : <span class="badge">'.$result.'</span>';
        }else{
            echo 'usulan baru : <span class="badge badge-danger">'.$result.'</span>';
        }
    }
        
    function get_impor_number_unit($unit,$sumber_dana,$tahun){
        $result = $this->dpa_model->get_dpa_unit_impor($unit,$sumber_dana,$tahun);
        if($result == 0){
            echo 'impor ke-<span class="badge">'.$result.'</span>';
        }else{
            if(($result % 2)==0){
                echo 'impor ke-<span class="badge badge-success">'.$result.'</span>';
            }else{
                echo 'impor ke-<span class="badge badge-danger">'.$result.'</span>';
            }
            
        }
        
        
    }
    
    function get_impor_rkat_unit($unit,$sumber_dana,$tahun){
        $result = $this->dpa_model->get_dpa_unit_rkat($unit,$sumber_dana,$tahun);
        echo number_format($result, 0, ",", ".");
    }
    
    function get_impor_rsa_unit($unit,$sumber_dana,$tahun){
        $result = $this->dpa_model->get_dpa_unit_rsa($unit,$sumber_dana,$tahun);
        echo number_format($result, 0, ",", ".");
    }
    
    function get_impor_dpa_unit($unit,$sumber_dana,$tahun){
        $result = $this->dpa_model->get_dpa_unit_to_validate($unit,$sumber_dana,$tahun);
        echo number_format($result, 0, ",", ".");
    }
    
    function post_impor_unit(){
        
//        sleep(1);
        if($this->input->post()){
            $unit = $this->input->post('unit');
            $sumber_dana = $this->input->post('sumber_dana');
            $tahun = $this->input->post('tahun');
            if($this->dpa_model->post_dpa_impor($unit,$sumber_dana,$tahun)){
                echo 'sukses';
            }
            else{
                echo 'gagal';
            }
        }
    }
	//import revisi ke rkat
	function post_revisi_unit(){
        sleep(1);
        if($this->input->post()){
            $unit = $this->input->post('unit');
            $sumber_dana = $this->input->post('sumber_dana');
            $tahun = $this->input->post('tahun');
            if($this->dpa_model->post_dpa_revisi($unit,$sumber_dana,$tahun)){
                echo 'sukses';
            }
            else{
                echo 'gagal';
            }
        }
    }
    
    
    function realisasi_dpa($sumber_dana = "", $jenis = "")
    {
        
        $data['cur_tahun'] = $this->cur_tahun ;
        
//        var_dump($this->check_session->get_unit());die;
		
		/* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                        $unit = $this->check_session->get_unit() ;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
                        if(!empty($sumber_dana)){
                            $subdata['rsa_usul'] 	= $this->dpa_model->get_rsa_program_usul($unit,$sumber_dana,$this->cur_tahun);
                        }
                        $subdata['sumber_dana']         = $sumber_dana ;
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                        $subdata['jenis']               = $jenis;
			$data['main_content'] 		= $this->load->view("dpa/realisasi_dpa",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata['rsa_usul']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
    }

	function kroscek(){


// 		$data['main_menu']              = $this->load->view('main_menu','',TRUE);
// 			$subdata['unit_usul'] 		= $this->dpa_model->get_dpa_unit_usul('SELAIN-APBN','2017');
// 			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
// 			$data['main_content'] 		= $this->load->view("dpa/daftar_unit",$subdata,TRUE);
			
			
			
// 			/*	Load main template	*/
// //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
// 			$this->load->view('main_template',$data);

		$data['cur_tahun'] = $this->cur_tahun ;
		
		/* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==1))){
			
                        
			if(empty($tahun)){
                            $tahun = $this->cur_tahun ;
                        }
                        $subdata['cur_tahun']               = $tahun;
			$subdata['cur_tahun'] = $this->cur_tahun ;

		$data['main_menu']          = $this->load->view('main_menu','',TRUE);


		$subdata['akun_kroscek']    = $this->dpa_model->get_kroscek_akun($sumber_dana,$this->cur_tahun);

		// var_dump($subdata); die;

		$data['main_content'] 		= $this->load->view("dpa/kroscek",$subdata,TRUE);
		$this->load->view('main_template',$data);
			
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		


		
	}


	function get_nama_sub_subunit($kode){

		// echo 'dd';
		// die;
		$kode_sub_subunit = substr($kode,0,6);
		$nama = $this->dpa_model->get_nama_sub_subunit($kode_sub_subunit);

		echo $nama;
	}

	function get_rba($kode,$sumber_dana,$tahun){

		// echo 'dd';
		// die;
		// $kode_sub_subunit = substr($kode,0,6);
		$jumlah = $this->dpa_model->get_rba($kode,$sumber_dana,$tahun);

		echo $jumlah;
	}

	function get_rsa($kode,$sumber_dana,$tahun){

		// echo 'dd';
		// die;
		// $kode_sub_subunit = substr($kode,0,6);
		$jumlah = $this->dpa_model->get_rsa($kode,$sumber_dana,$tahun);

		echo $jumlah;
	}


}