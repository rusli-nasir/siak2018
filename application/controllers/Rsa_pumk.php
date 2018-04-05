<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Rsa_pumk extends CI_Controller{
/* -------------- Constructor ------------- */
            
    private $cur_tahun;
	public function __construct(){ 
		parent::__construct();
			//load library, helper, and model
          $this->cur_tahun = $this->setting_model->get_tahun();
			$this->load->library(array('form_validation','option'));
			$this->load->helper('form');
         $this->load->model('menu_model');
         $this->load->model('rsa_pumk_model');
			$this->load->helper("security");
			$this->load->helper("vayes_helper");
                        
		}
		
		#methods ======================
		
		//define method index()
		public function index(){
        /* check session    */
            $data['cur_tahun'] = $this->cur_tahun ;
            if($this->check_session->user_session()){
            

            $unit = $this->check_session->get_unit();
            $level = $this->check_session->get_level();
            if($level == 13){
            	$subdata['dana_pumk']			= $this->rsa_pumk_model->get_jumlah_uang($unit);
            }elseif ($level == 4) {
            	 $subdata['dana']			= $this->rsa_pumk_model->get_jumlah_uang_pumk($unit);
            }
          
            // vdebug($subdata['dana_pumk']);
            $data['main_content'] =  $this->load->view('rsa_pumk/index',$subdata,TRUE);
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
            
            $this->load->view('main_template',$data);
        }else{
            redirect('welcome','refresh');  // redirect ke halaman home
            }
         }

         public function tambah_uang_pumk(){
        /* check session    */
            $data['cur_tahun'] = $this->cur_tahun ;
            if($this->check_session->user_session()){
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
            

            $kd_unit = $this->check_session->get_unit();
				$subdata['opt_username']			= $this->rsa_pumk_model->get_option_pumk($kd_unit);
				// $subdata['username']			= $this->rsa_pumk_model->get_pumk('pumkwr2-kepeg');
				// vdebug($subdata['username']);
				
				$alias_unit = $this->rsa_pumk_model->get_alias(substr($kd_unit,0,2));

				$get_new_nomor   		= $this->rsa_pumk_model->get_new_nomor($alias_unit);
            $no_urut      			= intval(ltrim($get_new_nomor, '0'));
            $new_no_urut  			= $no_urut + 1;
            $the_no_urut  			= sprintf('%04d', $new_no_urut);
            $bulan        			= array("","JAN","FEB","MAR","APR","MEI","JUN","JUL","AGU","SEP","OKT","NOV","DES");
            $bln          			= $bulan[date("n")];
            $new_no_pumk       	= $the_no_urut.'/'.$alias_unit.'/PUMK/'.'PANJAR/'.$bln.'/'.date('Y');
            $new_no_personal     = $the_no_urut.'/'.$alias_unit.'/PERSONAL/'.'PANJAR/'.$bln.'/'.date('Y');

            $nomor1 = array(
            					"pumk" 			=> $new_no_pumk,
									"personal" 			=> $new_no_personal
            					);
            $subdata['nomor'] = $nomor1;

            $data['main_content'] = $this->load->view('rsa_pumk/tambah_uang_pumk',$subdata,TRUE);
			 	$this->load->view('main_template',$data);
        }else{
            redirect('welcome','refresh');  
            }
         }

   function exec_add_uang_pumk(){

		if($this->input->post()){
			if($this->check_session->user_session() && $this->check_session->get_level()==13){

				$this->form_validation->set_rules('username','Username','required'); 
				$this->form_validation->set_rules('nama_pumk','Nama_pumk','required');
				$this->form_validation->set_rules('nip','Nip','required');
				$this->form_validation->set_rules('jumlah_dana','Jumlah_dana','required');
				$this->form_validation->set_rules('nomor_trx_rsa_pumk','Nomor_trx_rsa_pumk','required');
				$this->form_validation->set_rules('tanggal_proses','Tanggal_proses','required');
				$this->form_validation->set_rules('keperluan','Keperluan','required');

				$unit = $this->check_session->get_unit();
				$username = $this->input->post("username");
				$unit_username = $this->rsa_pumk_model->get_unit($username);
				if($unit_username == 0){
					$unit_username = $this->check_session->get_unit();
				} else{
					$unit_username = $this->rsa_pumk_model->get_unit($username);
				}
				// vdebug($unit_username);

				if ($this->form_validation->run()){
					$data = array(
						"username" 			=> $this->input->post("username"),
						"nama_pumk" 			=> $this->input->post("nama_pumk"),
						"nomor_induk" 			=> $this->input->post("nip"),
						"nomor_trx_rsa_pumk" 			=> $this->input->post("nomor_trx_rsa_pumk"),
						"tanggal_proses" 			=> $this->input->post("tanggal_proses"),
						"jumlah_dana"			=> $this->input->post("jumlah_dana"),
						"kode_unit_subunit"			=> $unit_username,
						"keperluan"				=> $this->input->post("keperluan"),
					);


					$nomor2 = $this->input->post('nomor_trx_rsa_pumk');

					$exists = $this->rsa_pumk_model->is_nomor_pumk($nomor2);
					if($exists){
						redirect('rsa_pumk/tambah_uang_pumk','refresh'); 
					}else{
						$uang_pumk = $this->rsa_pumk_model->add_uang_pumk($data);
						if($uang_pumk){

							$nomor_trx_rsa_pumk = $this->input->post("nomor_trx_rsa_pumk");
							$subdata['data_pumk'] = $this->rsa_pumk_model->get_cetak_pumk($nomor_trx_rsa_pumk);
							// vdebug($subdata['data_pumk']);
							$unit = $this->check_session->get_ori_unit();
							$subdata['bendahara'] = $this->rsa_pumk_model->get_bendahara($unit);
							$subdata['terbilang'] = $this->convertion->terbilang((int)$subdata['data_pumk']->jumlah_dana);
							$data['cur_tahun'] = $this->cur_tahun ;
			           			 $data['main_menu']  = $this->load->view('main_menu','',TRUE);

							$data['main_content'] = $this->load->view('rsa_pumk/cetak_pumk',$subdata,TRUE);
						 	$this->load->view('main_template',$data);
							// vdebug($subdata);
		
						}
						else{
							vdebug($uang_pumk);
						}
					}
				} 
			}else{
				show_404('page');
			}
		}
	}
		
	function get_pumk(){
		$username = $this->input->post("username");
		$subdata['username']			= $this->rsa_pumk_model->get_pumk($username);

		$this->load->view('rsa_pumk/nama_pumk',$subdata);	

	}

	function cetak_pumk(){
		$nomor_trx_rsa_pumk = $this->input->post("id");
		$subdata['data_pumk'] = $this->rsa_pumk_model->get_cetak_pumk($nomor_trx_rsa_pumk);
		$unit = $this->check_session->get_unit();
		$kode = strlen($unit);
            if ($kode = 6){
					$kd_bendahara = substr($this->check_session->get_unit(), 0,4);
            }elseif ($kode = 4){
					$kd_bendahara = substr($this->check_session->get_unit(), 0,2);
            }else{
            	$unit = $this->check_session->get_unit();
            }
      $subdata['terbilang'] = $this->convertion->terbilang((int)$subdata['data_pumk']->jumlah_dana);
      // vdebug($subdata['terbilang']);
		$subdata['bendahara'] = $this->rsa_pumk_model->get_bendahara($kd_bendahara);
		// vdebug($subdata['data_pumk']);
		$this->load->view('rsa_pumk/cetak_pumk_modal',$subdata);
	}

	function daftar_pumk(){
		$data['cur_tahun'] = $this->cur_tahun ;
      if($this->check_session->user_session()){
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
            
            $unit = $this->check_session->get_unit();
				$subdata['daftar_pumk']			= $this->rsa_pumk_model->get_daftar_pumk($unit);
				// vdebug($subdata['username']);
				
            $data['main_content'] = $this->load->view('rsa_pumk/daftar_pumk',$subdata,TRUE);
            // vdebug($subdata);
			 	$this->load->view('main_template',$data);
        }else{
            redirect('welcome','refresh');  
         }
	}

	function is_nomor_pumk() {
		$nomor = $this->input->post('nomor_trx_rsa_pumk');
		$exists = $this->rsa_pumk_model->is_nomor_pumk($nomor);

			if($exists){
				$msg = array(
					'valid' => false);
			}else{
				$msg = array(
					'valid' => true);

			}
		echo json_encode($msg);
		}

		function get_jenis(){
		$data = $this->input->post("id");
		$hasil = $this->rsa_pumk_model->get_jenis($data);

		if($hasil){
				$msg = array(
					'respon' => $hasil);
			}else{
				$msg = array(
					'respon' => false);
			}
		echo json_encode($msg);
		}

	function spj_pumk(){
		$data['cur_tahun'] = $this->cur_tahun ;
      if($this->check_session->user_session()){
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
            
            $unit = $this->check_session->get_ori_unit();
             $level = $this->check_session->get_level();
				$subdata['daftar_spj_pumk']			= $this->rsa_pumk_model->get_daftar_spj_pumk($unit);
				$subdata['nm_unit']			= $this->rsa_pumk_model->get_nama_unit($unit);
				if ($level == 4) {
            	 $subdata['dana']			= $this->rsa_pumk_model->get_jumlah_uang_pumk($unit);
            }else if($level == 13){
            	$subdata['dana']			= $this->rsa_pumk_model->get_jumlah_uang_pumk($unit);
            }
				// vdebug($subdata['daftar_spj_pumk']);
				// vdebug($subdata['nm_unit']	);
				// vdebug($subdata['daftar_spj_pumk']);
				
            $data['main_content'] = $this->load->view('rsa_pumk/spj_pumk',$subdata,TRUE);
			 	$this->load->view('main_template',$data);
            // vdebug($subdata);
        }else{
            redirect('welcome','refresh');  
         }
	}

	function form_tambah_spj_pumk(){
		$data = $this->input->post("data");
		// vdebug($data);
		$subdata['kuitansi'] = $data;
		$this->load->view('rsa_pumk/spj_modal',$subdata);
	}

	function exec_add_spj_pumk(){

		if($this->input->post()){
			if($this->check_session->user_session() ){

				$this->form_validation->set_rules('kuitansi','Kuitansi','required'); 
				$this->form_validation->set_rules('tgl_spj','Tgl_spj','required');
				$this->form_validation->set_rules('keterangan','Keterangan','required');

				$unit = $this->check_session->get_ori_unit();
				$username = $this->check_session->get_username();
				$pumk = $this->rsa_pumk_model->get_pumk($username);

				if ($this->form_validation->run()){
					$data = array(	
						"kuitansi"				=> $this->input->post("kuitansi"),
						"tgl_spj" 				=> $this->input->post("tgl_spj"),
						"kode_unit" 			=> $unit,
						"nm_pumk" 				=> $pumk->nm_lengkap ,
						"nip_pumk" 				=> $pumk->nomor_induk,
						"proses"					=> 1,
						"keterangan"			=> $this->input->post("keterangan"),
					);

					$data2 = $this->input->post("kuitansi");

					$tambah_spj = $this->rsa_pumk_model->add_spj_pumk($data);

					$id_spj = $this->rsa_pumk_model->get_id_spj($data2);
					$tambah_spj_detail = $this->rsa_pumk_model->add_spj_pumk_detail($data2,$id_spj);

						if($tambah_spj){
							// vdebug($subdata['data_pumk']);
							$data['cur_tahun'] = $this->cur_tahun ;
			            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
						 	$this->load->view('main_template',$data);

						 	redirect('rsa_pumk/spj_pumk','refresh');
									// vdebug($subdata);
						}else {
							vdebug($tambah_spj);
						}
					} 
			}else{
				show_404('page');
			}
		}
	}

	function daftar_sudah_spj(){
		$data['cur_tahun'] = $this->cur_tahun ;
      if($this->check_session->user_session()){
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
            
            $unit = $this->check_session->get_ori_unit();
				$subdata['daftar_sudah_spj']			= $this->rsa_pumk_model->get_daftar_sudah_spj($unit);
				// vdebug($subdata['daftar_sudah_spj']);
				
            $data['main_content'] = $this->load->view('rsa_pumk/daftar_sudah_spj',$subdata,TRUE);
			 	$this->load->view('main_template',$data);
            // vdebug($subdata);
        }else{
            redirect('welcome','refresh');  
         }
	}


	function terima_spj(){
		$data = $this->input->post("data");
		$hasil = $this->rsa_pumk_model->terima_spj($data);

		if($hasil){
				$msg = array(
					'respon' => true);
			}else{
				$msg = array(
					'respon' => false);
			}
		echo json_encode($msg);
	}

	function tolak_spj(){
		$data = $this->input->post("data");
		$hasil = $this->rsa_pumk_model->tolak_spj($data);

		if($hasil){
				$msg = array(
					'respon' => true);
			}else{
				$msg = array(
					'respon' => false);
			}
		echo json_encode($msg);
	}


	function daftar_kuitansi_spj(){
		$data = $this->input->post("id");
		$unit = $this->check_session->get_ori_unit();
		$subdata['data'] = $this->rsa_pumk_model->daftar_kuitansi_spj($data,$unit);
		$subdata['nm_unit']			= $this->rsa_pumk_model->get_nama_unit($unit);
		// vdebug($subdata);
		$this->load->view('rsa_pumk/daftar_kuitansi_sudah_spj',$subdata);
		
	}

	public function kembali_uang_pumk(){
        /* check session    */
            $data['cur_tahun'] = $this->cur_tahun ;
            if($this->check_session->user_session()){
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
            

            $kd_unit = $this->check_session->get_unit();
            $kode = strlen($kd_unit);
            if ($kode == 6){
					$kd_bendahara = substr($this->check_session->get_unit(), 0,4);
            }elseif ($kode == 4){
					$kd_bendahara = substr($this->check_session->get_unit(), 0,2);
            }else{
            	$kd_bendahara = $kd_unit;
            }
            
				
				$bendahara = $this->rsa_pumk_model->get_bendahara($kd_bendahara);
				
				$alias_unit = $this->rsa_pumk_model->get_alias(substr($kd_unit,0,2));

				$get_new_nomor   		= $this->rsa_pumk_model->get_new_nomor2($alias_unit);
            $no_urut      			= intval(ltrim($get_new_nomor, '0'));
            $new_no_urut  			= $no_urut + 1;
            $the_no_urut  			= sprintf('%04d', $new_no_urut);
            $bulan        			= array("","JAN","FEB","MAR","APR","MEI","JUN","JUL","AGU","SEP","OKT","NOV","DES");
            $bln          			= $bulan[date("n")];
            $level 				= $this->check_session->get_level();
            if($level == 13){
					$new_no_pumk       	= $the_no_urut.'/'.$alias_unit.'/PERSONAL/'.'KEMBALI/'.$bln.'/'.date('Y');
            }elseif ($level == 4) {
            	$new_no_pumk       	= $the_no_urut.'/'.$alias_unit.'/PUMK/'.'KEMBALI/'.$bln.'/'.date('Y');
            }
            

            $nomor1 = array(
            					"pumk" 			=> $new_no_pumk,
            					);
				// vdebug($kd_unit);
            $subdata['nomor'] = $nomor1;
            $subdata['bendahara'] = $bendahara;

            $data['main_content'] = $this->load->view('rsa_pumk/kembali_spj_pumk',$subdata,TRUE);
			 	$this->load->view('main_template',$data);
        }else{
            redirect('welcome','refresh');  
            }
         }

   function exec_add_uang_kembali(){
   	if($this->input->post()){
   		if($this->check_session->user_session()){
   			if($this->check_session->get_level()== 13){
   				$this->form_validation->set_rules('nama_pumk','Nama_pumk','required');
   				$this->form_validation->set_rules('nip_pumk','Nip_pumk','required');
   			}
   			$this->form_validation->set_rules('jumlah_dana','Jumlah_dana','required');
   			$this->form_validation->set_rules('nomor_trx_rsa_pumk_kembali','Nomor_trx_rsa_pumk_kembali','required');
   			$this->form_validation->set_rules('tanggal_proses','Tanggal_proses','required');
   			$this->form_validation->set_rules('keterangan','Keterangan','required');

   			$unit = $this->check_session->get_ori_unit();
   			$kode = strlen($unit);
   			if ($kode = 6){
   				$kd_bendahara = substr($this->check_session->get_unit(), 0,4);
   			}elseif ($kode = 4){
   				$kd_bendahara = substr($this->check_session->get_unit(), 0,2);
   			}

   			$username 			= $this->rsa_pumk_model->get_username($unit);
   			$nama_pumk			= $this->rsa_pumk_model->get_nama_pumk($unit);
   			$nomor_induk		= $this->rsa_pumk_model->get_nip_pumk($unit);

   			if ($this->form_validation->run()){

   				if($this->check_session->get_level()== 13){
   					$data = array(
   						"username" 			=> "personal",
   						"nama_pumk" 			=> $this->input->post("nama_pumk"),
   						"nomor_induk" 			=> $this->input->post("nip_pumk"),
   						"nomor_trx_rsa_pumk_kembali" 			=> $this->input->post("nomor_trx_rsa_pumk_kembali"),
   						"tanggal_proses" 			=> $this->input->post("tanggal_proses"),
   						"jumlah_dana"			=> $this->input->post("jumlah_dana"),
   						"kode_unit_subunit"			=> $unit,
   						"keterangan"				=> $this->input->post("keterangan"),
   					);
   				}else{
   					$data = array(
   						"username" 			=> $username,
   						"nama_pumk" 			=> $nama_pumk,
   						"nomor_induk" 			=> $nomor_induk,
   						"nomor_trx_rsa_pumk_kembali" 			=> $this->input->post("nomor_trx_rsa_pumk_kembali"),
   						"tanggal_proses" 			=> $this->input->post("tanggal_proses"),
   						"jumlah_dana"			=> $this->input->post("jumlah_dana"),
   						"kode_unit_subunit"			=> $unit,
   						"keterangan"				=> $this->input->post("keterangan"),
   					);
   				}

   				$nomor2 = $this->input->post('nomor_trx_rsa_pumk_kembali');
   				$exists = $this->rsa_pumk_model->is_nomor_pumk2($nomor2);

   				if($exists){
   					redirect('rsa_pumk/kembali_uang_pumk','refresh'); 
   				}else{
   					$uang_pumk = $this->rsa_pumk_model->kembali_uang_pumk($data);
   					if($uang_pumk){

   						$nomor_trx_rsa_pumk_kembali = $this->input->post("nomor_trx_rsa_pumk_kembali");
			// vdebug($nomor_trx_rsa_pumk_kembali);
   						$subdata['data_pumk'] = $this->rsa_pumk_model->get_cetak_pumk_kembali($nomor_trx_rsa_pumk_kembali);
			// vdebug($subdata['data_pumk']);
   						$subdata['bendahara'] = $this->rsa_pumk_model->get_bendahara($kd_bendahara);
   						$data['cur_tahun'] = $this->cur_tahun ;
   						$data['main_menu']  = $this->load->view('main_menu','',TRUE);

   						$data['main_content'] = $this->load->view('rsa_pumk/cetak_kembali',$subdata,TRUE);
   						$this->load->view('main_template',$data);
   					}else{
   						redirect('rsa_pumk/kembali_uang_pumk','refresh');
   					}
   				}
   			}else{
   				redirect('rsa_pumk/kembali_uang_pumk','refresh');
   			}	
   		}else{
   			show_404('page');
   		}
   	}
   }


	function cetak_kembali(){
		$nomor_trx_rsa_pumk_kembali = $this->input->post("id");
		$subdata['data_pumk'] = $this->rsa_pumk_model->get_cetak_pumk_kembali($nomor_trx_rsa_pumk_kembali);
		$unit = $this->check_session->get_unit();
		$kode = strlen($unit);
            if ($kode = 6){
					$kd_bendahara = substr($this->check_session->get_unit(), 0,4);
            }elseif ($kode = 4){
					$kd_bendahara = substr($this->check_session->get_unit(), 0,2);
            }else{
            	$unit = $this->check_session->get_unit();
            }
      $subdata['terbilang'] = $this->convertion->terbilang((int)$subdata['data_pumk']->jumlah_dana);
		$subdata['bendahara'] = $this->rsa_pumk_model->get_bendahara($kd_bendahara);
		$data['main_content'] = $this->load->view('rsa_pumk/cetak_pumk_modal_kembali',$subdata,TRUE);
	}

	function daftar_uang_kembali(){
		$data['cur_tahun'] = $this->cur_tahun ;
      if($this->check_session->user_session()){
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
            
            $unit = $this->check_session->get_unit();
				$subdata['daftar_pumk']			= $this->rsa_pumk_model->get_daftar_pumk_kembali($unit);
				// vdebug($subdata['username']);
				
            $data['main_content'] = $this->load->view('rsa_pumk/daftar_uang_kembali',$subdata,TRUE);
			 	$this->load->view('main_template',$data);
            // vdebug($subdata);
        }else{
            redirect('welcome','refresh');  
         }
	}

	function is_cek_harga(){
		$harga = $this->input->post('harga');
		if($this->check_session->get_level()== 13){
			$nip = $this->input->post('nip');
		}else{
			$nip = "";
		}
		
		$unit = $this->check_session->get_ori_unit();
		$dana		= $this->rsa_pumk_model->get_jumlah_uang_pumk($unit,$nip);

		if($dana+1 > $harga){
					echo "true";
			}else{
				echo "false";
			}
	}

	
	function print(){
		$data['cur_tahun'] = $this->cur_tahun ;
            // vdebug($subdata['dana_pumk']);
		
		$subdata["menu"] = $this->menu_model->show();
		$subdata["submenu"] = $this->menu_model->show();
		$subdata['data_unit'] = $this->rsa_pumk_model->print();
		$data['main_content'] = $this->load->view('rsa_pumk/printunit',$subdata,true);
		$data['main_menu']  = $this->load->view('main_menu','',TRUE);
		$this->load->view('main_template',$data);
	}

}

