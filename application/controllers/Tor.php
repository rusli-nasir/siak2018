<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Tor extends CI_Controller {
  private $cur_tahun = '' ;
  public function __construct(){
    parent::__construct();
    $this->cur_tahun = $this->setting_model->get_tahun();
    if ($this->check_session->user_session()){
  		/*	Load library, helper, dan Model	*/
  		$this->load->library(array('form_validation','option'));
  		$this->load->helper('form');
  		$this->load->model('tor_model');
		$this->load->model('kuitansi_lsphk3_model');
                $this->load->model('user_model');
  		$this->load->model('menu_model');
  		$this->load->model('unit_model');
  		$this->load->model('subunit_model');
  		$this->load->model('master_unit_model');
			$this->load->model('cantik_model');
      if($this->cantik_model->manual_override()){
        // otomatis set status
        if(!isset($_SESSION['ovr']['status'])){
          $_SESSION['ovr']['status'] = array(1,3,6,12);
        }

        // otomatis set tahun
        if(!isset($_SESSION['ovr']['tahun'])){
          $_SESSION['ovr']['tahun'] = $this->cur_tahun;
        }

        // otomatis set seluruh unit
        if(!isset($_SESSION['ovr']['unit_id'])){
          if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42'){
            $_SESSION['ovr']['unit_id'] = $this->cantik_model->getUnitChecked();
          }else{
            $_SESSION['ovr']['unit_id'] = $this->cantik_model->get_unit_rba($this->check_session->get_unit());
          }
        }
      }
    }else{
      redirect('welcome','refresh');	// redirect ke halaman home
	  }
  }

/* -------------- Method ------------- */
	function index()
	{
		/* check session	*/
		if($this->check_session->user_session()){
			redirect('tor/daftar_tor/','refresh');
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

        function usulan_tor($kode,$sumber_dana){

            $data['cur_tahun'] = $this->cur_tahun ;

            /* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                        $unit = $this->check_session->get_unit() ;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
                        $subdata['tor_usul']            = $this->tor_model->get_tor_usul($kode);//$this->tor_model->get_tor_usul(substr($kode,2,10));
                        $subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($unit,$kode,$sumber_dana,$this->cur_tahun);
//                        echo '<pre>'; var_dump($subdata['tor_usul']);echo '</pre>';die;
                        $subdata['detail_rsa']          = $this->tor_model->get_detail_rsa($unit,$kode,$sumber_dana,$this->cur_tahun);
                        $this->load->model('dpa_model');
                        $subdata['impor']               = $this->dpa_model->get_dpa_unit_impor($unit,$sumber_dana,$this->cur_tahun);
                        $subdata['revisi']              = $this->dpa_model->get_dpa_unit_revisi($unit,$sumber_dana,$this->cur_tahun);
//                        echo '<pre>'; var_dump($subdata['impor'] );echo '</pre>';die;
//                        echo '<pre>'; var_dump($subdata['detail_rsa'] );echo '</pre>';die;
						            $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                        $subdata['sumber_dana'] 	= $sumber_dana;
                        $subdata['kode']                = $kode;

			$data['main_content'] 		= $this->load->view("tor/usulan_tor",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

        }


        function usulan_tor_to_validate_kpa($kode,$sumber_dana,$tahun){

            $data['cur_tahun'] = $this->cur_tahun ;

            /* check session  */
    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
        $unit = $this->check_session->get_unit() ;
      $data['main_menu']              = $this->load->view('main_menu','',TRUE);
//      $subdata['rsa_usul']    = $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
    $subdata['tor_usul']            = $this->tor_model->get_tor_usul($kode);//$this->tor_model->get_tor_usul(substr($kode,2,10));

    $subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($unit,$kode,$sumber_dana,$tahun);
    $subdata['detail_rsa_to_validate']      = $this->tor_model->get_detail_rsa_to_validate($unit,$kode,$sumber_dana,$tahun);
//                var_dump($subdata['detail_rsa_to_validate']);die;
    //$subdata['detail_rsa_to_validate']->kode_usulan_belanja;
    $subdata['detail_rsa_kontrak'] = array();
    foreach($subdata['detail_rsa_to_validate'] as $r){
      if(substr($r->proses,1,1)=='4'){

        $kodex=$r->kode_usulan_belanja;
        $kode_akun_tambah=$r->kode_akun_tambah;
        //var_dump($kode_akun_tambah);die;
        $subdata['detail_rsa_kontrak'][$kodex.$kode_akun_tambah]= $this->tor_model->get_detail_rsa_kontrak($kodex,$tahun,$kode_akun_tambah,$unit);
        //var_dump($subdata['detail_rsa_kontrak'][$kodex.$kode_akun_tambah]);die;
      }

    }
    // var_dump($subdata['detail_rsa_kontrak']); exit;
    //var_dump($subdata['detail_rsa_kontrak']);die;
    $subdata['opt_sumber_dana']   = $this->option->sumber_dana();
    $subdata['sumber_dana']   = $sumber_dana;
      $subdata['tahun']   = $tahun;
      $subdata['kode']                = $kode;
      $data['main_content']     = $this->load->view("tor/usulan_tor_to_validate_kpa",$subdata,TRUE);
      /*  Load main template  */
      //echo '<pre>';var_dump($subdata['detail_rsa_kontrak']);echo '</pre>';die;
      $this->load->view('main_template',$data);
    }else{
      redirect('welcome','refresh');  // redirect ke halaman home
    }

        }

        function usulan_tor_to_validate_ppk($kode,$sumber_dana,$tahun){

            $data['cur_tahun'] = $this->cur_tahun ;

            /* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==14))){
        $unit = $this->check_session->get_unit() ;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
		$subdata['tor_usul']            = $this->tor_model->get_tor_usul($kode);//$this->tor_model->get_tor_usul(substr($kode,2,10));

		$subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($unit,$kode,$sumber_dana,$tahun);
		$subdata['detail_rsa_to_validate']      = $this->tor_model->get_detail_rsa_to_validate($unit,$kode,$sumber_dana,$tahun);
//                var_dump($subdata['detail_rsa_to_validate']);die;
		//$subdata['detail_rsa_to_validate']->kode_usulan_belanja;
		$subdata['detail_rsa_kontrak'] = array();
		foreach($subdata['detail_rsa_to_validate'] as $r){
			if(substr($r->proses,1,1)=='4'){

				$kodex=$r->kode_usulan_belanja;
				$kode_akun_tambah=$r->kode_akun_tambah;
				//var_dump($kode_akun_tambah);die;
				$subdata['detail_rsa_kontrak'][$kodex.$kode_akun_tambah]= $this->tor_model->get_detail_rsa_kontrak($kodex,$tahun,$kode_akun_tambah,$unit);
				//var_dump($subdata['detail_rsa_kontrak'][$kodex.$kode_akun_tambah]);die;
			}

		}
    // var_dump($subdata['detail_rsa_kontrak']); exit;
		//var_dump($subdata['detail_rsa_kontrak']);die;
		$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
		$subdata['sumber_dana'] 	= $sumber_dana;
      $subdata['tahun'] 	= $tahun;
      $subdata['kode']                = $kode;
			$data['main_content'] 		= $this->load->view("tor/usulan_tor_to_validate_ppk",$subdata,TRUE);
			/*	Load main template	*/
			//echo '<pre>';var_dump($subdata['detail_rsa_kontrak']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

        }


        function usulan_tor_to_validate($kode,$sumber_dana,$tahun,$unit=''){

            $data['cur_tahun'] = $this->cur_tahun ;

            /* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3))){
      if($unit==''){
        $unit = $this->check_session->get_unit() ;
      }
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
      $subdata['tor_usul']            = $this->tor_model->get_tor_usul($kode);//$this->tor_model->get_tor_usul(substr($kode,2,10));
      $subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($unit,$kode,$sumber_dana,$tahun);
      $subdata['detail_rsa_to_validate']          = $this->tor_model->get_detail_rsa_to_validate($unit,$kode,$sumber_dana,$tahun);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
      $subdata['sumber_dana'] 	= $sumber_dana;
      $subdata['tahun'] 	= $tahun;
      $subdata['unit'] 	= $unit;
      $subdata['nama_unit']  = $this->unit_model->get_single_unit($unit,'nama');
      $subdata['kode']                = $kode;
			$data['main_content'] 		= $this->load->view("tor/usulan_tor_to_validate",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

        }

        function usulan_tor_to_validate_kbuu($kode,$sumber_dana,$tahun,$unit=''){

            $data['cur_tahun'] = $this->cur_tahun ;

            /* check session  */
    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
      if($unit==''){
        $unit = $this->check_session->get_unit() ;
      }
      $data['main_menu']              = $this->load->view('main_menu','',TRUE);
//      $subdata['rsa_usul']    = $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
      $subdata['tor_usul']            = $this->tor_model->get_tor_usul($kode);//$this->tor_model->get_tor_usul(substr($kode,2,10));
      $subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($unit,$kode,$sumber_dana,$tahun);
      $subdata['detail_rsa_to_validate']          = $this->tor_model->get_detail_rsa_to_validate($unit,$kode,$sumber_dana,$tahun);
      $subdata['opt_sumber_dana']   = $this->option->sumber_dana();
      $subdata['sumber_dana']   = $sumber_dana;
      $subdata['tahun']   = $tahun;
      $subdata['unit']  = $unit;
      $subdata['nama_unit']  = $this->unit_model->get_single_unit($unit,'nama');
      $subdata['kode']                = $kode;
      // $data['main_content']     = $this->load->view("tor/usulan_tor_to_validate",$subdata,TRUE);
      $data['main_content']     = $this->load->view("tor/usulan_tor_to_validate_kbuu",$subdata,TRUE);
      /*  Load main template  */
//      echo '<pre>';var_dump($subdata);echo '</pre>';die;
      $this->load->view('main_template',$data);
    }else{
      redirect('welcome','refresh');  // redirect ke halaman home
    }

        }

        function realisasi_tor($kode,$sumber_dana,$jenis){

//           echo $this->cur_tahun ; die;

            $data['cur_tahun'] = $this->cur_tahun ;


            /* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
		$unit = $this->check_session->get_unit();
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
      $subdata['tor_usul']            = $this->tor_model->get_tor_usul($kode);//$this->tor_model->get_tor_usul(substr($kode,2,10));
      $subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($unit,$kode,$sumber_dana,$this->cur_tahun);
      $subdata['detail_rsa_dpa']      = $this->tor_model->get_detail_rsa_dpa($unit,$kode,$sumber_dana,$this->cur_tahun);

      // echo '<pre>';var_dump( $subdata['detail_rsa_dpa'] );echo '</pre>';die;

    if(intval($jenis) == 4){
  	  foreach($subdata['detail_rsa_dpa'] as $r){
  		  if(substr($r->proses,1,1)=='4'){
    			$kode=$r->kode_usulan_belanja;
    			$vol=$r->volume;
    			$harga=$r->harga_satuan;
    			$nominal=$vol*$harga;
    			$tahun=$this->cur_tahun;
    			$subdata['kontrak'][$r->kode_usulan_belanja.$r->kode_akun_tambah]=$this->tor_model->get_detail_rsa_kontrak2($kode,$tahun,$nominal,$unit);
    			#var_dump($subdata['kontrak']);die;
  		  }
  	  }
    }

	  // var_dump($subdata['kontrak']); exit;
	  // $subdata['kontrak']            = $this->tor_model->get_kontrak($kode);
//      echo '<pre>';
     //  var_dump( $subdata['detail_rsa_dpa']);
//      echo '</pre>';die;
      $subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
      $subdata['sumber_dana'] 	= $sumber_dana;
      $subdata['kode']                = $kode;
      $subdata['tahun']               = $this->cur_tahun ;

      if(strlen($this->check_session->get_unit())==2){
        $subdata['kode_unit']           = $this->check_session->get_unit();
        $subdata['nm_unit']             = $this->check_session->get_nama_unit();
      }
      elseif(strlen($this->check_session->get_unit())==4){
            if((substr($this->check_session->get_unit(),0,2) == '41')||(substr($this->check_session->get_unit(),0,2) == '42')||(substr($this->check_session->get_unit(),0,2) == '43')||(substr($this->check_session->get_unit(),0,2) == '44')){
                $subdata['kode_unit']           = substr($this->check_session->get_unit(),0,2);
                $subdata['nm_unit']             = $this->unit_model->get_nama_unit(substr($this->check_session->get_unit(),0,2)) . ' - ' . $this->check_session->get_nama_unit();
            }else{
                $subdata['kode_unit']           = substr($this->check_session->get_unit(),0,2);
                $subdata['nm_unit']             = $this->unit_model->get_nama_unit(substr($this->check_session->get_unit(),0,2));
            }

      }elseif(strlen($this->check_session->get_unit())==6){
            if((substr($this->check_session->get_unit(),0,2) == '41')||(substr($this->check_session->get_unit(),0,2) == '42')||(substr($this->check_session->get_unit(),0,2) == '43')||(substr($this->check_session->get_unit(),0,2) == '44')){
                $subdata['kode_unit']           = substr($this->check_session->get_unit(),0,2);
                $subdata['nm_unit']             = $this->unit_model->get_nama_unit(substr($this->check_session->get_unit(),0,2)) . ' - ' . $this->unit_model->get_nama_subunit(substr($this->check_session->get_unit(),0,4));
            }else{
                $subdata['kode_unit']           = substr($this->check_session->get_unit(),0,2);
                $subdata['nm_unit']             = $this->unit_model->get_nama_unit(substr($this->check_session->get_unit(),0,2));
            }
      }

      $subdata['alias']               = $this->tor_model->get_alias_unit($this->check_session->get_unit());
      $subdata['jenis']               = $jenis;
      $subdata['pic_kuitansi']        = $this->tor_model->get_pic_kuitansi($this->check_session->get_unit());
      $subdata['pppk']                = $this->tor_model->get_pppk(substr($this->check_session->get_unit(),0,2));

      $subdata['cur_tahun'] = $this->cur_tahun ;

     // var_dump($subdata['pic_kuitansi'] );die;

      if($this->check_session->get_level() == '4'){
          $subdata['pumk'] = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
      }

      // tambahan dari dhanu
      if(intval($jenis)==2){
        if($this->cantik_model->manual_override()){
          $subdata['status_kepeg'] = array();
          if(isset($_SESSION['ovr']['status_kepeg'])){
            $subdata['status_kepeg'] = $_SESSION['ovr']['status_kepeg'];
          }
          $subdata['unitList'] = $this->cantik_model->getUnitList($_SESSION['ovr']['unit_id']);
          $subdata['statusKepegOption'] = $this->cantik_model->getStatusKepegFullCheckbox($subdata['status_kepeg']);
          $_bulan = date('m');
          if(isset($_SESSION['ovr']['bulan'])){
            $_bulan = $_SESSION['ovr']['bulan'];
          }
          $subdata['bulanOption'] = $this->cantik_model->getBulanOption($_bulan);
          $subdata['jenisOption'] = $this->cantik_model->get_opsi_jenis_sppls();
          $subdata['semesterOption'] = $this->cantik_model->get_opsi_semester();
        }
      }
      // end here

			$data['main_content'] 		= $this->load->view("tor/realisasi_tor",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

        }

        function get_next_kode_akun_tambah($kode,$sumber_dana){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                echo $this->tor_model->get_next_kode_akun_tambah($kode,$sumber_dana,$this->cur_tahun);
            }

        }

        function delete_rsa_detail_belanja(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                $id_rsa_detail = $this->input->post('id_rsa_detail');
                if($this->tor_model->do_delete_rsa_detail_belanja($id_rsa_detail)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Data berhasil dihapus.</div>');
                    echo "sukses";
                }
                else{
                    echo "gagal";
                }
            }
        }

        function add_rsa_detail_belanja(){

            $this->form_validation->set_rules('kode_akun_tambah','Kode Akun Tambah','xss_clean|required');
            $this->form_validation->set_rules('deskripsi','Deskripsi','xss_clean|required');
            $this->form_validation->set_rules('volume','Volume','xss_clean|required|numeric');
            $this->form_validation->set_rules('satuan','Satuan','xss_clean|required');
            $this->form_validation->set_rules('impor','Impor','xss_clean|required');
            $this->form_validation->set_rules('harga_satuan','Harga satuan','xss_clean|required|is_natural_no_zero');
            $kode_usulan_belanja = $this->input->post('kode_usulan_belanja') ;
            $sumber_dana = $this->input->post('sumber_dana') ;
            if($this->form_validation->run()==TRUE){
                $data = array(
                            'kode_usulan_belanja' => $kode_usulan_belanja,
                            'deskripsi' => $this->input->post('deskripsi'),
                            'sumber_dana' => $sumber_dana,
                            'volume' => $this->input->post('volume'),
                            'satuan' => $this->input->post('satuan'),
                            'harga_satuan' => $this->input->post('harga_satuan'),
                            'tahun' => $this->cur_tahun,
                            'username' => substr($this->input->post('kode_usulan_belanja'),0,6),
                            'tanggal_transaksi' => date("Y-m-d H:i:s"),
                            'flag_cetak' => '1',
                            'revisi' => $this->input->post('revisi'),
                            'kode_akun_tambah' =>  $this->tor_model->get_next_kode_akun_tambah($kode_usulan_belanja,$sumber_dana,$this->cur_tahun),//$this->input->post('kode_akun_tambah'),
                            'impor' => $this->input->post('impor'),
                            'tanggal_impor' => date("Y-m-d H:i:s"),
                            'proses' => '0',
                        );
//                        var_dump($data);die;
                if($this->tor_model->add_rsa_detail_belanja($data)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Data berhasil disimpan.</div>');
                    echo "sukses";
                }else{
                    echo "gagal";
                }
            }else{
                    echo "gagal";
                }


        }

        function edit_rsa_detail_belanja(){



//            $this->form_validation->set_rules('kode_akun_tambah','Kode Akun Tambah','xss_clean|required');
//            $this->form_validation->set_rules('deskripsi','Deskripsi','xss_clean|required');
            $this->form_validation->set_rules('deskripsi','Deskripsi','required');
            $this->form_validation->set_rules('volume','Volume','xss_clean|required|numeric');
            $this->form_validation->set_rules('satuan','Satuan','xss_clean|required');
            $this->form_validation->set_rules('harga_satuan','Harga satuan','xss_clean|required|is_natural_no_zero');

            $id_rsa_detail = $this->input->post('id_rsa_detail');
            if($this->form_validation->run()==TRUE){
//                echo $this->input->post('deskripsi');
//
//            die;
                $data = array(
//                            'kode_usulan_belanja' => $this->input->post('kode_usulan_belanja'),
                            'deskripsi' => $this->input->post('deskripsi'),
//                            'sumber_dana' => $this->input->post('sumber_dana'),
                            'volume' => $this->input->post('volume'),
                            'satuan' => $this->input->post('satuan'),
                            'harga_satuan' => $this->input->post('harga_satuan'),
//                            'tahun' => $this->cur_tahun,
//                            'username' => substr($this->input->post('kode_usulan_belanja'),0,6),
//                            'tanggal_transaksi' => date("Y-m-d H:i:s"),
//                            'flag_cetak' => '1',
//                            'revisi' => $this->input->post('revisi'),
//                            'kode_akun_tambah' => $this->input->post('kode_akun_tambah'),
//                            'impor' => $this->input->post('impor'),
//                            'tanggal_impor' => date("Y-m-d H:i:s"),
//                            'proses' => '0',
                        );
//                        var_dump($data);die;
                if($this->tor_model->edit_rsa_detail_belanja($data,$id_rsa_detail)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Data berhasil diubah.</div>');
                    echo "sukses";
                }else{
                    echo "gagal";
                }
            }


        }

        function proses_tor(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
                $kode = $this->input->post('kode');
                $sumber_dana = $this->input->post('sumber_dana');
                if($this->tor_model->post_proses_tor($kode, $sumber_dana, $this->cur_tahun)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Usulan sub kegiatan terkirim !</div>');
                    echo "sukses";
                }else{
                    echo "gagal";
                }

            }

        }

        function proses_tor_rsa_detail(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                $id_rsa_detail = $this->input->post('id_rsa_detail');
                $proses = $this->input->post('proses');
                if($this->tor_model->post_proses_tor_rsa_detail($id_rsa_detail,$proses)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Usulan berhasil dikirim.</div>');
                    echo "sukses";
                }else{
                    echo "gagal";
                }

            }
        }

        function proses_tor_rsa_to_validate(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==3)||($this->check_session->get_level()==14))){
                $id_rsa_detail = $this->input->post('id_rsa_detail');
                $proses = $this->input->post('proses');

                // tambahan dari dhanu
                if(intval($proses) == 0){
                    $sql = "DELETE FROM kepeg_tr_temp_sppls WHERE id_rsa_detail = ".intval($id_rsa_detail);
                    $this->db->query($sql);
                }
                // end tambahan dari dhanu

                if($this->tor_model->post_proses_tor_to_validate($id_rsa_detail,$proses)){
                    //$this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Usulan berhasil divalidasi.</div>');
                    echo "sukses";
                }else{
                    echo "gagal";
                }

            }
        }


        function refresh_row_detail($kode,$sumber_dana){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2)||($this->check_session->get_level()==13)||($this->check_session->get_level()==14)||($this->check_session->get_level()==4))){
                $unit = $this->check_session->get_unit() ;
                $data['detail_rsa']          = $this->tor_model->get_detail_rsa($unit,$kode,$sumber_dana,$this->cur_tahun);
                $data['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($unit,$kode,$sumber_dana,$this->cur_tahun);
                $this->load->view('tor/usulan_tor_row',$data);
            }
        }

        function form_edit_detail($id_rsa_detail){
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4)))
		{
			$data['value']	= $this->tor_model->get_single_detail($id_rsa_detail);

			$this->load->view('tor/row_edit_tor',$data);
		}else{
			show_404();
		}
	}

        function refresh_row_detail_to_validate_ppk($kode,$sumber_dana,$tahun){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11)||($this->check_session->get_level()==14))){
//                $data['detail_rsa']          = $this->tor_model->get_detail_rsa($kode,$sumber_dana,$this->cur_tahun);
                $unit = $this->check_session->get_unit() ;
                $data['detail_rsa_to_validate']          = $this->tor_model->get_detail_rsa_to_validate($unit,$kode,$sumber_dana,$tahun);
//				$data['detail_rsa_to_validate']      = $this->tor_model->get_detail_rsa_to_validate($kode,$sumber_dana,$tahun);
		//$subdata['detail_rsa_to_validate']->kode_usulan_belanja;
				foreach($data['detail_rsa_to_validate'] as $r){
					if(substr($r->proses,1,1)=='4'){
						$kodex=$r->kode_usulan_belanja;
				$kode_akun_tambah=$r->kode_akun_tambah;
				//var_dump($kode_akun_tambah);die;
				$data['detail_rsa_kontrak'][$kodex.$kode_akun_tambah]= $this->tor_model->get_detail_rsa_kontrak($kodex,$tahun,$kode_akun_tambah,$unit);
					}

				}
                $data['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($unit,$kode,$sumber_dana,$tahun);
                $this->load->view('tor/usulan_tor_row_to_validate_ppk',$data);
            }
        }

        function refresh_row_detail_to_validate($kode,$sumber_dana,$tahun,$unit=''){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11)||($this->check_session->get_level()==14)||($this->check_session->get_level()==3))){
//                $data['detail_rsa']          = $this->tor_model->get_detail_rsa($kode,$sumber_dana,$this->cur_tahun);
                if($unit==''){
                    $unit = $this->check_session->get_unit() ;
                }
                $data['detail_rsa_to_validate']          = $this->tor_model->get_detail_rsa_to_validate($unit,$kode,$sumber_dana,$tahun);
                $data['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($unit,$kode,$sumber_dana,$tahun);
                $this->load->view('tor/usulan_tor_row_to_validate',$data);
            }
        }

        function form_edit_detail_to_validate_ppk($id_rsa_detail){
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11)||($this->check_session->get_level()==14)))
		{
			$data['value']	= $this->tor_model->get_single_detail($id_rsa_detail);

			$this->load->view('tor/row_edit_tor_to_validate_ppk',$data);
		}else{
			show_404();
		}
	}

        function form_edit_detail_to_validate($id_rsa_detail){
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11)||($this->check_session->get_level()==14)||($this->check_session->get_level()==3)))
		{
			$data['value']	= $this->tor_model->get_single_detail($id_rsa_detail);

			$this->load->view('tor/row_edit_tor_to_validate',$data);
		}else{
			show_404();
		}
	}

	function daftar_tor_()
	{
		/* check session	*/
		if($this->check_session->user_session() && $this->check_session->get_level()==1){
			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			//$data['main_content']	= $this->load->view('main_content','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);

			//$subdata_tor['result'] 		= $this->tor_model->get_tor();
			//$subdata['row_tor'] 				= $this->load->view("row_tor",$subdata_tor,TRUE);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 				= $this->load->view("daftar_tor",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($data);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

	function daftar_tor()
	{

		/* check session	*/
		if($this->check_session->user_session() && $this->check_session->get_level()==1){
			/*	Set data untuk main template */


			// $data['user_menu']	= $this->load->view('user_menu','',TRUE);
			//$data['main_content']	= $this->load->view('main_content','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);

			$subdata_tor['result'] 		= $this->tor_model->get_tor();
			// $subdata['row_tor'] 				= $this->load->view("row_tor",$subdata_tor,TRUE);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 		= $this->load->view("tor/daftar_tor",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($data);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}
	function get_sub_subunit(){
		if($this->input->post()){
			$this->load->model('master_sub_subunit_model');
			$result = $this->master_sub_subunit_model->get_child_sub_subunit($this->input->post('kode_sub_subunit'));
			$return = '<option value="">-pilih-</option>';
			foreach($result as $r){
				$return .= '<option value="'.$r->kode_sub_subunit.'">'.$r->kode_sub_subunit.' - '.$r->nama_sub_subunit.' [sub_subunit]</option>';
			}
			echo $return ;
		}
	}

	function get_subunit(){
		if($this->input->post()){
			$this->load->model('subunit_model');
			$result = $this->subunit_model->get_child_subunit($this->input->post('kode_subunit'));
			$return = '<option value="">-pilih-</option>';
			foreach($result as $r){
				$return .= '<option value="'.$r->kode_subunit.'">'.$r->kode_subunit.' - '.$r->nama_subunit.' [subunit]</option>';
			}
			echo $return ;
		}
	}
	function get_unit(){
		if($this->input->post()){
			$this->load->model('master_unit_model');
			$result = $this->master_unit_model->get_child_unit($this->input->post('kode_unit'));
			$return = '<option value="">-pilih-</option>';
			foreach($result as $r){
				$return .= '<option value="'.$r->kode_unit.'">'.$r->kode_unit.' - '.$r->nama_unit.' [unit]</option>';
			}
			echo $return ;
		}
	}
	function get_row($sumber_dana=''){
		if($this->check_session->user_session() && ($this->check_session->get_level()==1)){
			$data['result'] = $this->tor_model->search_tor($sumber_dana);
			//print_r($data);die;
			$this->load->view("row_tor",$data);
		}else{
			show_404('page');
		}
	}
	function filter(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==1)){
			$keyword 		= form_prep($this->input->post("keyword"));
			$sumber_dana 	= form_prep($this->input->post("sumber_dana"));
			$data['result'] = $this->tor_model->search_tor($sumber_dana,$keyword);
			//print_r($data);die;
			$this->load->view("row_tor",$data);
		}else{
			show_404('page');
		}
	}
	function input_tor()
	{
		/* check session	*/
		if($this->check_session->user_session() && $this->check_session->get_level()==1){
			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			//$data['main_content']	= $this->load->view('main_content','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);


			$data['main_content'] 				= $this->load->view("input_tor","",TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($data);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}
        function show_komponen_input(){
            if($this->check_session->user_session() && $this->check_session->get_level()==1){
                if($this->input->post()){
                    $unit = $this->input->post('unit');
                    $sumber_dana = $this->input->post('sumber_dana');
                    $tahun = $this->input->post('tahun');

                    $tor_kegiatan_usul = $this->tor_model->get_tor_kegiatan_usul($unit,$sumber_dana,$tahun);

//                    var_dump($tor_kegiatan_usul);die;

                    $data['tor_kegiatan_usul'] = $tor_kegiatan_usul ;
//                    var_dump($data);die;
                    $this->load->view('tor/row_tor',$data);


                }
            }

        }




    // CREATE BY DHANU // DELETE BUT CONFIRM IF CAUSED ERROR
    function msgSukses($m){
    return "<div class=\"alert alert-success alert-dismissible text-center\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"glyphicon glyphicon-lamp\"></i>&nbsp;&nbsp;".$m."</div>";
    }

    function msgGagal($m){
    return "<div class=\"alert alert-danger alert-dismissible text-center\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"glyphicon glyphicon-alert\"></i>&nbsp;&nbsp;".$m."</div>";
    }

    function getOpsiJenisPeg(){
    $result = array(1=>'Dosen Pengajar', 2=>'Tenaga Kependidikan');
    $return = '<option value=""> seluruhnya </option>';
    foreach($result as $k => $v){
    $return .= '<option value="'.$k.'">'.$v.'</option>';
    }
    echo $return ;
    }

    function getOpsiStatusPeg(){
    $result = array(1=>'Pegawai Negeri Sipil',2=>'Pegawai Tetap Non PNS (BLU)',4=>'Tenaga Kerja Kontrak');
    $return = '<option value=""> seluruhnya </option>';
    foreach($result as $k => $v){
    $return .= '<option value="'.$k.'">'.$v.'</option>';
    }
    echo $return ;
    }

    function getOpsiStatusPeg2(){
    $result = array(1=>'Pegawai Negeri Sipil',2=>'Pegawai Tetap Non PNS (BLU)',4=>'Tenaga Kerja Kontrak');
    // $return = '<option value=""> seluruhnya </option>';
    foreach($result as $k => $v){
    // $return .= '<option value="'.$k.'">'.$v.'</option>';
      $return .= '<div class="col-md-3 col-lg-3">';
      $return .= '<div class="input-group small checkbox" style="border-bottom:1px solid #f00;margin:0;vertical-align:top;"><label style="margin:0;line-height:1;display:block;">';
      $return .= '<input type="checkbox" name="lampStatusLSPeg[]" id="lampStatusLSPeg" value="'.$k.'" style="line-height:1;margin-top:0;"/>';
      $return .= $v;
      $return .= '</label></div>';
      $return .= '</div>';
    }
    echo $return ;
    }

    function getOpsiUnitPeg(){
    $result = $this->db->query("SELECT * FROM kepeg_unit")->result();
    $i=0;
    $return = '<div class="row">';
    foreach($result as $v){
    if($i%4==0){
    $return.= '</div><div class="row">';
    }
    $return .= '<div class="col-md-3 col-lg-3">';
    $return .= '<div class="input-group small checkbox" style="border-bottom:1px solid #f00;margin:0;vertical-align:top;"><label style="margin:0;line-height:1;display:block;">';
    $return .= '<input type="checkbox" name="lampUnitLSPeg[]" id="lampUnitLSPeg" value="'.$v->id.'" style="line-height:1;margin-top:0;"/>';
    $return .= $v->unit;
    $return .= '</label></div>';
    $return .= '</div>';
    $i++;
    }
    $return.= '</div>';
    echo $return ;
    }

    function wordMonth($nilai){
    switch(intval($nilai)){
    case 1 : return "Januari";break;
    case 2 : return "Februari";break;
    case 3 : return "Maret";break;
    case 4 : return "April";break;
    case 5 : return "Mei";break;
    case 6 : return "Juni";break;
    case 7 : return "Juli";break;
    case 8 : return "Agustus";break;
    case 9 : return "September";break;
    case 10 : return "Oktober";break;
    case 11 : return "November";break;
    case 12 : return "Desember";break;
    }
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

    function getMonth($date){
    $exp=explode(" ",$date);
    $exl=explode("-",$exp[0]);
    return $exl[1];
    }

    function checkSPPLSPegawai(){
        if(isset($_GET)){
            $_POST = $_GET;
        }
        //print_r($_POST); exit;
        $button = "<a href=\"javascript:;\" id=\"reprocess_check_splss_pegawai\" class=\"btn btn-primary btn-flat btn-sm\"><i class=\"glyphicon glyphicon-repeat\"></i> Reprocess</a>";
        $sql = "";
        $array = array('ikw','ipp','tutam','tutam_rsnd');
        if(!isset($_POST['jenisLSPeg']) || !in_array(strtolower($_POST['jenisLSPeg']),$array)){
            echo "<p class=\"alert alert-warning\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i>&nbsp;&nbsp;&nbsp;Pilih jenis SPP LS Pegawai. Diperuntukan untuk pembuatan lampiran.</p>";
            exit;
        }
        if(!isset($_POST['varTambahan'])){
          echo $this->msgGagal("Pilih variabel tambahan yang masuk yaitu <strong>Tahun</strong>. <br/>".$button); exit;
        }
        $sql.="SELECT * FROM rsa_detail_belanja_ WHERE id_rsa_detail = ".intval($_POST['id_rsa_detail']);
        // echo $sql.$button; exit;
        $hasil = $this->db->query($sql)->result();
        if(count($hasil)<=0){
            echo $this->msgGagal("Tidak ada data detail sub kegiatan yang dimaksud. <br/>".$button); exit;
        }
        if(isset($_POST['jenisLSPeg']) && strtolower($_POST['jenisLSPeg'])=='ipp'){
            $penting = $this->getDataIPP($_POST);
            //print_r($penting); exit;
            if(count($penting)<=0){
                echo $this->msgGagal("Buat daftar penerima IPP untuk LS Pegawai terlebih dahulu melalui menu kepegawaian.<br/>".$button); exit;
            }
            if($hasil[0]->harga_satuan != $penting['total']){
                echo $this->msgGagal("Jumlah dana yang dibutuhkan antara daftar lampiran tidak sama dengan jumlah dana usulan.<br/>Cek kembali daftar pembayaran pegawai Anda.<br/>Jumlah Dana yang terdapat pada Daftar Pegawai : ".number_format($penting['total'],0,',','.')."<br/>Jumlah Dana yang diusulkan : ".number_format($hasil[0]->harga_satuan,0,',','.')."<br/>".$button); exit;
            }
            // masukkan ke tabel temporary, menunggu dibuat menjadi spp
            $_POST['tahun'] = $hasil[0]->tahun;
            $variabel = base64_encode(serialize($_POST));
            $sql = "INSERT INTO kepeg_tr_temp_sppls(id_rsa_detail, kode_akun_tambah, kode_usulan_belanja, variabel, waktu) VALUES('".intval($_POST['id_rsa_detail'])."', '".$hasil[0]->kode_akun_tambah."', '".$hasil[0]->kode_usulan_belanja."', '".$variabel."', NOW())";
            $this->db->query($sql); // execute it
            echo "1"; exit;
        }elseif (isset($_POST['jenisLSPeg']) && strtolower($_POST['jenisLSPeg'])=='ikw'){
            $penting = $this->getDataIKW($_POST);
            if(count($penting)<=0){
                echo $this->msgGagal("Buat daftar penerima IKW untuk LS Pegawai terlebih dahulu melalui menu kepegawaian.<br/>".$button); exit;
            }
            if($hasil[0]->harga_satuan != $penting['total']){
                echo $this->msgGagal("Jumlah dana yang dibutuhkan antara daftar lampiran tidak sama dengan jumlah dana usulan.<br/>Cek kembali daftar pembayaran pegawai Anda.<br/>Jumlah Dana yang terdapat pada Daftar Pegawai : ".number_format($penting['total'],0,',','.')."<br/>Jumlah Dana yang diusulkan : ".number_format($hasil[0]->harga_satuan,0,',','.')."<br/>".$button); exit;
            }
            // masukkan ke tabel temporary, menunggu dibuat menjadi spp
            $_POST['tahun'] = $hasil[0]->tahun;
            $variabel = base64_encode(serialize($_POST));
            $sql = "INSERT INTO kepeg_tr_temp_sppls(id_rsa_detail, kode_akun_tambah, kode_usulan_belanja, variabel, waktu) VALUES('".intval($_POST['id_rsa_detail'])."', '".$hasil[0]->kode_akun_tambah."', '".$hasil[0]->kode_usulan_belanja."', '".$variabel."', NOW())";
            $this->db->query($sql); // execute it
            echo "1"; exit;
        }elseif (isset($_POST['jenisLSPeg']) && strtolower($_POST['jenisLSPeg'])=='tutam'){
            $penting = $this->getDataTutam($_POST);
            if(count($penting)<=0){
                echo $this->msgGagal("Buat daftar penerima Tutam untuk LS Pegawai terlebih dahulu melalui menu kepegawaian.<br/>".$button); exit;
            }
            if($hasil[0]->harga_satuan != $penting['total']){
                echo $this->msgGagal("Jumlah dana yang dibutuhkan antara daftar lampiran tidak sama dengan jumlah dana usulan.<br/>Cek kembali daftar pembayaran pegawai Anda.<br/>Jumlah Dana yang terdapat pada Daftar Pegawai : ".number_format($penting['total'],0,',','.')."<br/>Jumlah Dana yang diusulkan : ".number_format($hasil[0]->harga_satuan,0,',','.')."<br/>".$button); exit;
            }
            // masukkan ke tabel temporary, menunggu dibuat menjadi spp
            $_POST['tahun'] = $hasil[0]->tahun;
            $variabel = base64_encode(serialize($_POST));
            $sql = "INSERT INTO kepeg_tr_temp_sppls(id_rsa_detail, kode_akun_tambah, kode_usulan_belanja, variabel, waktu) VALUES('".intval($_POST['id_rsa_detail'])."', '".$hasil[0]->kode_akun_tambah."', '".$hasil[0]->kode_usulan_belanja."', '".$variabel."', NOW())";
            // echo $sql.$button;exit;
            $this->db->query($sql); // execute it
            echo "1"; exit;
        }elseif (isset($_POST['jenisLSPeg']) && strtolower($_POST['jenisLSPeg'])=='tutam_rsnd'){
            $penting = $this->getDataTutamRSND($_POST);
            if(count($penting)<=0){
                echo $this->msgGagal("Buat daftar penerima Tutam RSND untuk LS Pegawai terlebih dahulu melalui menu kepegawaian.<br/>".$button); exit;
            }
            if($hasil[0]->harga_satuan != $penting['total']){
                echo $this->msgGagal("Jumlah dana yang dibutuhkan antara daftar lampiran tidak sama dengan jumlah dana usulan.<br/>Cek kembali daftar pembayaran pegawai Anda.<br/>Jumlah Dana yang terdapat pada Daftar Pegawai : ".number_format($penting['total'],0,',','.')."<br/>Jumlah Dana yang diusulkan : ".number_format($hasil[0]->harga_satuan,0,',','.')."<br/>".$button); exit;
            }
            // masukkan ke tabel temporary, menunggu dibuat menjadi spp
            $_POST['tahun'] = $hasil[0]->tahun;
            $variabel = base64_encode(serialize($_POST));
            $sql = "INSERT INTO kepeg_tr_temp_sppls(id_rsa_detail, kode_akun_tambah, kode_usulan_belanja, variabel, waktu) VALUES('".intval($_POST['id_rsa_detail'])."', '".$hasil[0]->kode_akun_tambah."', '".$hasil[0]->kode_usulan_belanja."', '".$variabel."', NOW())";
            // echo $sql.$button;exit;
            $this->db->query($sql); // execute it
            echo "1"; exit;
        }
    }

    function getDataIPP($data){
        $vSQL = " WHERE id_trans!= 0";
        if(isset($data['lampJenisLSPeg']) && in_array($data['lampJenisLSPeg'],array(1,2))){
            $vSQL .= " AND jenispeg = ".$data['lampJenisLSPeg'];
        }
        if(isset($data['lampStatusLSPeg']) && in_array($data['lampStatusLSPeg'],array(1,2,4))){
            if($data['lampStatusLSPeg']==1){
                $vSQL .= " AND ( statuspeg = 1 OR statuspeg = 3 )";
            }else{
                $vSQL .= " AND statuspeg = ".$data['lampStatusLSPeg'];
            }
        }
        if(isset($data['lampUnitLSPeg']) && count($data['lampUnitLSPeg'])>0){
            $vSQL .= " AND ( unitid = ".$data['lampUnitLSPeg'][0];
            if(count($data['lampUnitLSPeg'])>1){
                for($i=1;$i<(count($data['lampUnitLSPeg']));$i++){
                    $vSQL .= " OR unitid = ".$data['lampUnitLSPeg'][$i];
                }
            }
            $vSQL .= " )";
        }
        $cur_tahun = substr($data['varTambahan'],0,4);
        $cur_bulan = substr($data['varTambahan'],4);
        $vSQL.=" AND tahun LIKE '".$cur_tahun."' AND semester LIKE '".$cur_bulan."'";
        $sql = "SELECT SUM(a.ipp) AS total, SUM(a.netto) AS jumlah, SUM(a.potongan) AS pajak, a.unitid, b.unit, a.jenispeg, a.statuspeg, a.tahun
            FROM kepeg_tr_ipp a LEFT JOIN kepeg_unit b ON a.unitid = b.id
            ".$vSQL." GROUP BY a.tahun";
        //echo $sql; exit;
        $penting = $this->db->query($sql)->result();
        return array('total'=>$penting[0]->total, 'jumlah_bayar'=>$penting[0]->jumlah, 'pajak'=>$penting[0]->pajak, 'potongan'=>0, 'tanggal'=>date('Y-m-d'));
    }

    function getDataIKW($data){
        $vSQL = " WHERE id_trans!= 0";
        if(isset($data['lampJenisLSPeg']) && in_array($data['lampJenisLSPeg'],array(1,2))){
            $vSQL .= " AND jenispeg = ".$data['lampJenisLSPeg'];
        }
        if(isset($data['lampStatusLSPeg']) && in_array($data['lampStatusLSPeg'],array(1,2,4))){
            if($data['lampStatusLSPeg']==1){
                $vSQL .= " AND ( statuspeg = 1 OR statuspeg = 3 )";
            }else{
                $vSQL .= " AND statuspeg = ".$data['lampStatusLSPeg'];
            }
        }
        if(isset($data['lampUnitLSPeg']) && count($data['lampUnitLSPeg'])>0){
            $vSQL .= " AND ( unitid = ".$data['lampUnitLSPeg'][0];
            if(count($data['lampUnitLSPeg'])>1){
                for($i=1;$i<(count($data['lampUnitLSPeg']));$i++){
                    $vSQL .= " OR unitid = ".$data['lampUnitLSPeg'][$i];
                }
            }
            $vSQL .= " )";
        }
        $cur_tahun = substr($data['varTambahan'],0,4);
        $cur_bulan = substr($data['varTambahan'],4);
        $vSQL.=" AND a.tahun LIKE '".$cur_tahun."' AND a.bulan LIKE '".$cur_bulan."'";
            $sql = "SELECT SUM(a.ikw) AS total, SUM(a.netto) AS jumlah, SUM(a.pot_ikw) AS potongan, SUM(a.jml_pajak) AS jml_pajak, SUM(a.pot_lainnya) AS pot_lainnya, a.unitid, b.unit, a.jenispeg, a.statuspeg, a.tahun FROM kepeg_tr_ikw a LEFT JOIN kepeg_unit b ON a.unitid = b.id
            ".$vSQL." GROUP BY a.tahun";
        $penting = $this->db->query($sql)->result();
        return array('total'=>$penting[0]->total, 'jumlah_bayar'=>$penting[0]->jumlah, 'pajak'=>$penting[0]->jml_pajak, 'potongan'=>($penting[0]->pot_lainnya+$penting[0]->potongan), 'tanggal'=>date('Y-m-d'));
    }

    function getDataTutam($data){
        $vSQL = " WHERE a.id!= 0";
        if(isset($data['lampJenisLSPeg']) && in_array($data['lampJenisLSPeg'],array(1,2))){
            $vSQL .= " AND b.jnspeg = ".$data['lampJenisLSPeg'];
        }
        if(isset($data['lampStatusLSPeg']) && in_array($data['lampStatusLSPeg'],array(1,2,4))){
            if($data['lampStatusLSPeg']==1){
                $vSQL .= " AND ( b.status_kepeg = 1 OR b.status_kepeg = 3 )";
            }else{
                $vSQL .= " AND b.status_kepeg = ".$data['lampStatusLSPeg'];
            }
        }
        if(isset($data['lampUnitLSPeg']) && count($data['lampUnitLSPeg'])>0){
            $vSQL .= " AND ( a.unit_id = ".$data['lampUnitLSPeg'][0];
            if(count($data['lampUnitLSPeg'])>1){
                for($i=1;$i<(count($data['lampUnitLSPeg']));$i++){
                    $vSQL .= " OR a.unit_id = ".$data['lampUnitLSPeg'][$i];
                }
            }
            $vSQL .= " )";
        }
        $cur_tahun = substr($data['varTambahan'],0,4);
        $cur_bulan = substr($data['varTambahan'],4);
        $vSQL.=" AND a.tahun LIKE '".$cur_tahun."' AND a.bulan LIKE '".$cur_bulan."'";
            $sql = "SELECT SUM(a.nominal) AS total, SUM(a.bersih) AS jumlah, SUM(a.nom_pajak) AS jml_pajak, a.unit_id, c.unit, b.jnspeg, b.status_kepeg, a.tahun FROM kepeg_tr_tutam a LEFT JOIN kepeg_unit c ON a.unit_id = c.id LEFT JOIN kepeg_tb_pegawai b ON a.nip = b.nip
            ".$vSQL." GROUP BY a.tahun";
        $penting = $this->db->query($sql)->result();
        return array('total'=>$penting[0]->total, 'jumlah_bayar'=>$penting[0]->jumlah, 'pajak'=>$penting[0]->jml_pajak, 'potongan'=>0, 'tanggal'=>date('Y-m-d'));
    }

    function getDataTutamRSND($data){
        $vSQL = " WHERE a.id!= 0";
        if(isset($data['lampJenisLSPeg']) && in_array($data['lampJenisLSPeg'],array(1,2))){
            $vSQL .= " AND b.jnspeg = ".$data['lampJenisLSPeg'];
        }
        if(isset($data['lampStatusLSPeg']) && in_array($data['lampStatusLSPeg'],array(1,2,4))){
            if($data['lampStatusLSPeg']==1){
                $vSQL .= " AND ( b.status_kepeg = 1 OR b.status_kepeg = 3 )";
            }else{
                $vSQL .= " AND b.status_kepeg = ".$data['lampStatusLSPeg'];
            }
        }
        if(isset($data['lampUnitLSPeg']) && count($data['lampUnitLSPeg'])>0){
            $vSQL .= " AND ( a.unit_id = ".$data['lampUnitLSPeg'][0];
            if(count($data['lampUnitLSPeg'])>1){
                for($i=1;$i<(count($data['lampUnitLSPeg']));$i++){
                    $vSQL .= " OR a.unit_id = ".$data['lampUnitLSPeg'][$i];
                }
            }
            $vSQL .= " )";
        }
        $cur_tahun = substr($data['varTambahan'],0,4);
        $cur_bulan = substr($data['varTambahan'],4);
        $vSQL.=" AND a.tahun LIKE '".$cur_tahun."' AND a.bulan LIKE '".$cur_bulan."'";
            $sql = "SELECT SUM(a.nominal) AS total, SUM(a.bersih) AS jumlah, SUM(a.nom_pajak) AS jml_pajak, a.unit_id, c.unit, b.jnspeg, b.status_kepeg, a.tahun FROM kepeg_tr_tutam_rsnd a LEFT JOIN kepeg_unit c ON a.unit_id = c.id LEFT JOIN kepeg_tb_pegawai b ON a.nip = b.nip
            ".$vSQL." GROUP BY a.tahun";
        $penting = $this->db->query($sql)->result();
        return array('total'=>$penting[0]->total, 'jumlah_bayar'=>$penting[0]->jumlah, 'pajak'=>$penting[0]->jml_pajak, 'potongan'=>0, 'tanggal'=>date('Y-m-d'));
    }

    function checkSPPLSExist($data){
        $sqlCheck = "SELECT id_sppls FROM kepeg_tr_sppls WHERE detail_belanja LIKE '".$data['akun_i']."' AND jenissppls LIKE '".$data['jenisLSPeg']."' AND tahun LIKE '".$data['tahun']."'";
        $cek = $this->db->query($sqlCheck)->result();
        if(count($cek)>0){
            return true;
        }
        return false;
    }

    function getSPPLSID($data){
        $sqlCheck = "SELECT id_sppls FROM kepeg_tr_sppls WHERE detail_belanja LIKE '".$data['akun_i']."' AND jenissppls LIKE '".$data['jenisLSPeg']."' AND tahun LIKE '".$data['tahun']."'";
        $cek = $this->db->query($sqlCheck)->result();
        if(count($cek)>0){
            return $cek[0]->id_sppls;
        }
        return false;
    }

    function createSPPLSPeg($data){
      $id_sppls2 = $data['nomor'];
      $alias = $this->check_session->get_alias();
      $cur_tahun= $data['tahun'];
      $cur_bulan = $this->wordMonthShort(date('m'));
      $nomor = $id_sppls2."/".$alias."/SPP-LS PGW/".strtoupper($cur_bulan)."/".$cur_tahun;
      // $nomor = $data
      $sql = "INSERT INTO kepeg_tr_sppls(nomor, tahun, tanggal, jumlah_bayar, total_sumberdana, jenissppls, detail_belanja, potongan, pajak, namabpsukpa, nipbpsukpa, unitsukpa, waktu_proses, penerima, alamat, rekening, npwp) VALUES ('".$nomor."','".$data['tahun']."', NOW(), ".$data['jumlah_bayar'].", ".$data['total_sumberdana'].", '".$data['jenisLSPeg']."', '".$data['akun_i']."', '".$data['potongan']."', '".$data['pajak']."', '".$data['namabpsukpa']."', '".$data['nipbpsukpa']."', '".$data['unitsukpa']."',NOW(), 'Terlampir', 'Jalan Prof. H. Soedarto, SH Tembalang Semarang', 'Terlampir', 'Terlampir')";
      // echo $sql; exit;
      $this->db->query($sql);
      $id_sppls = $this->db->insert_id();
      $this->addLog($id_sppls, 'kepeg_tr_sppls', $data['jenisLSPeg'], 'SPP dibuat.');
      return $id_sppls; exit;
    }

    function createSPMfromSPP($id){
        $sql = "SELECT * FROM kepeg_tr_sppls WHERE id_sppls = ".$id." AND proses = 1";
        $r = $this->db->query($sql)->result();
        // echo "<pre>"; print_r($r); echo "</pre>"; exit;
        if(count($r)>0){
            $bpp = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '13');
            $ppk = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
            $kpa = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '2');
            $buu = $this->user_model->get_detail_rsa_user('99', '5');
            $kbuu = $this->user_model->get_detail_rsa_user('99', '11');
            $verSQL = "SELECT b.nm_lengkap, b.nomor_induk FROM rsa_verifikator_unit a LEFT JOIN rsa_user b ON a.id_user_verifikator = b.id WHERE a.kode_unit_subunit = '".substr($_SESSION['rsa_kode_unit_subunit'], 0, 2)."'";
            $ver = $this->db->query($verSQL)->row();
            // echo $verSQL;
            // $id_spmls2 = substr($r[0]->nomor,0,5);
            $id_spmls2 = $this->cantik_model->get_id_last_spm();
            // echo $id_spmls2; exit;
            $alias = $this->check_session->get_alias();
            $cur_tahun= $r[0]->tahun;
            $cur_bulan = $this->wordMonthShort(date('m'));
            $nomor = $id_spmls2."/".$alias."/SPM-LS PGW/".strtoupper($cur_bulan)."/".$cur_tahun;
            // echo $nomor; exit;
            $sql = "INSERT INTO kepeg_tr_spmls(
                        id_tr_sppls, namabp, nipbp, jumlah_bayar, nomor, tanggal, tahun, detail_belanja, potongan, pajak, total_sumberdana, namappk, nipppk, namakpa, nipkpa, namaver, nipver, namabuu, nipbuu, namakbuu, nipkbuu, unitsukpa, namaunitsukpa, waktu_proses, status
                    ) VALUES (
                        '".$id."',
                        '".$bpp->nm_lengkap."',
                        '".$bpp->nomor_induk."',
                        '".$r[0]->jumlah_bayar."',
                        '".$nomor."',
                        NOW(),
                        '".$r[0]->tahun."',
                        '".$r[0]->detail_belanja."',
                        '".$r[0]->potongan."',
                        '".$r[0]->pajak."',
                        '".$r[0]->total_sumberdana."',
                        '".encodeText($ppk->nm_lengkap)."',
                        '".encodeText($ppk->nomor_induk)."',
                        '".encodeText($kpa->nm_lengkap)."',
                        '".encodeText($kpa->nomor_induk)."',
                        '".encodeText($ver->nm_lengkap)."',
                        '".encodeText($ver->nomor_induk)."',
                        '".encodeText($buu->nm_lengkap)."',
                        '".encodeText($buu->nomor_induk)."',
                        '".encodeText($kbuu->nm_lengkap)."',
                        '".encodeText($kbuu->nomor_induk)."',
                        '".$r[0]->unitsukpa."',
                        '".$_SESSION['rsa_nama_unit']."',
                        NOW(),
                        'SPM telah dibuat oleh PPK SUKPA'
                    )";
            // echo encodeText($ppk->nm_lengkap);
            // echo $sql; exit;
            // exit;
            $this->db->query($sql);
            $id_spmls = $this->db->insert_id();
            // $id_spmls2 = "";
            // $jm = strlen($id_spmls);
            // for($i=0;$i<(5-$jm);$i++){
            //     $id_spmls2 .= "0";
            // }
            // $id_spmls2 .= $id_spmls;
            // $sql = "UPDATE `kepeg_tr_spmls` SET `nomor` = '".$nomor."' WHERE `id_spmls` = ".$id_spmls;
            // $this->db->query($sql);
            $akun_ = explode(",",$r[0]->detail_belanja);
            foreach ($akun_ as $k => $v) {
                $this->cantik_model->update_rsa_detail_belanja($v,'52');
            }
            $this->addLog($id_spmls, 'kepeg_tr_spmls', $r[0]->jenissppls, 'SPM dibuat.');
            return $id_spmls; exit;
        }
    }

    function prosesSPPLS(){
        // print_r($_POST); exit;
        $sql = "";
        $akun = explode(",",$_POST['akunSPPLS']);
        $akun_k = array_search('', $akun);
        unset($akun[$akun_k]);
        $sql.="SELECT SUM(harga_satuan) AS nominal, tahun FROM rsa_detail_belanja_ WHERE id_rsa_detail!=0 AND ";
        $sql2 = "SELECT variabel FROM kepeg_tr_temp_sppls WHERE id!=0 AND ";
        $sql3 = "UPDATE rsa_detail_belanja_ SET proses = '42' WHERE id_rsa_detail!=0 AND "; //update
        $i=0;
        foreach ($akun as $k => $v) {
            $vSQL2[$i]="(`kode_usulan_belanja` LIKE '".substr($v, 0, -3)."' AND `kode_akun_tambah` LIKE '".substr($v, -3)."')";
            $i++;
        }
        $vSQL2 = implode(" OR ", $vSQL2);
        $sql = $sql.$vSQL2." GROUP BY tahun";
        $sql2 = $sql2.$vSQL2;
        $sql3 = $sql3.$vSQL2;
        // echo $sql; echo "<br />"; echo $sql2; exit;
        $hasil = $this->db->query($sql)->result();
        $penting = $this->db->query($sql2)->result();
        $data['pajak'] = 0;
        $data['jumlah_bayar'] = 0;
        $data['potongan'] = 0;
        foreach ($penting as $key => $value) {
            $x = unserialize(base64_decode($value->variabel));
            // print_r($x);
            if($x['jenisLSPeg']=='ipp'){
                $y = $this->getDataIPP($x);
            }elseif($x['jenisLSPeg']=='ikw'){
                $y = $this->getDataIKW($x);
            }
            // $data['jumlah_bayar'] += $y['jumlah_bayar'];
            // print_r($y);
            $data['pajak'] += $y['pajak'];
            $data['potongan'] += $y['potongan'];
            $data['jenisLSPeg'] = $x['jenisLSPeg'];
        }
        // exit;
        $data['akun_i'] = implode(",", $akun);
        $data['total_sumberdana'] = $hasil[0]->nominal;
        $data['jumlah_bayar'] = $data['total_sumberdana'] - ($data['pajak']+$data['potongan']);
        $data['tahun'] = $hasil[0]->tahun;
        $data['namabpsukpa'] = "-";
        $data['nipbpsukpa'] = "-";
        $data['unitsukpa'] = $_SESSION['rsa_kode_unit_subunit'];
        // print_r($data); exit;
        $sql = "SELECT nomor FROM kepeg_tr_sppls ORDER BY nomor DESC LIMIT 0,1";
        // echo $sql; exit;
        $w = $this->db->query($sql)->row();
        if(count($w)>0){
          $data['nomor'] = lspeg_autonumber(substr($w->nomor,0,5),5);
        }else{
          $data['nomor'] = '00001';
        }
        // print_r($data); exit;
        $q = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
        // print_r($q); exit;
        if(count($q)>0){
            $data['namabpsukpa'] = $q->nm_lengkap;
            $data['nipbpsukpa'] = $q->nomor_induk;
        }
        unset($q);
        // echo $sql3; exit;
        // if(!$this->checkSPPLSExist($data)){
        // $subdata['cur_tahun'] = $this->cur_tahun;
            echo $this->createSPPLSPeg($data);
            $this->db->query($sql3); // untuk update status tabel
        // }
        // else{
            // echo $this->getSPPLSID($data);
            // $this->db->query($sql3); // untuk update status tabel
        // }
        exit;
    }

    function sppLS(){
        $d = $this->uri->uri_to_assoc(3);
        $sql = "SELECT * FROM kepeg_tr_sppls WHERE id_sppls =".intval($d['id']);
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
        $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
        $subdata['unit_id'] = $this->check_session->get_unit();
        $subdata['alias'] = $this->check_session->get_alias();
        $subdata['detail_up'] = $sub[0];
        $subdata['akun_detail'] = $akun;
        $jm = strlen($sub[0]->id_sppls);
        $subdata['id_sppls'] = "";
        for($i=0;$i<(5-$jm);$i++){
            $subdata['id_sppls'] .= "0";
        }
        $subdata['id_sppls'] .= $sub[0]->id_sppls;
        $subdata['detail_pic'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view("tor/form-sppls",$subdata,TRUE);
        $this->load->view('main_template',$data);
    }
    function simpanSPPLSPeg(){
        $sql = "UPDATE `kepeg_tr_sppls` SET `".$_POST['id']."` = '".htmlentities($_POST['value'],ENT_QUOTES)."' WHERE id_sppls = ".$_POST['key'];
        $this->db->query($sql);
        exit;
    }
    function simpanSPMLSPeg(){
        $sql = "UPDATE `kepeg_tr_spmls` SET `".$_POST['id']."` = '".htmlentities($_POST['value'],ENT_QUOTES)."' WHERE id_spmls = ".$_POST['key'];
        $this->db->query($sql);
        exit;
    }
    function sppLScetak(){
        $d = $this->uri->uri_to_assoc(3);
        $sql = "SELECT * FROM kepeg_tr_sppls WHERE id_sppls =".intval($d['id']);
        $sub = $this->db->query($sql)->result();
        $jm = strlen($sub[0]->id_sppls);
        $subdata['id_sppls'] = "";
        for($i=0;$i<(5-$jm);$i++){
            $subdata['id_sppls'] .= "0";
        }
        $subdata['id_sppls'] .= $sub[0]->id_sppls;
        if($this->input->post('dtable')){
            $data['main_content'] = base64_decode($this->input->post('dtable'));
            $this->load->view('cetak_template',$data);
        }
    }
    function daftar_spplspeg(){
        $vSQL = "";
        // if($_SESSION['rsa_level']=='14'){
        //     $vSQL= " AND proses = 1";
        // }
        $dt = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
        if(intval($dt->level) == 3 || intval($dt->level) == 11 ){
          $unt = $this->cantik_model->get_unit_verifikator($dt->id);
          // print_r($unt); exit;
          if(!is_null($unt)){
            $vSQL.=" AND ";
            $vSQL2 = array();
            foreach ($unt as $k => $v) {
              // if(strlen($v->kode_unit_subunit)==2){
              //   $vSQL2[] = "a.unitsukpa LIKE '".$v->kode_unit_subunit."%'";
              // }else
              // if(strlen($v->kode_unit_subunit)==1){
              //   $vSQL2[] = "a.unitsukpa LIKE '".$v->kode_unit_subunit."'";
              // }
              $vSQL2[] = "a.unitsukpa LIKE '".$v->kode_unit_subunit."%'";
            }
            $vSQL.=implode(" OR ", $vSQL2);
          }
        }else{
          $vSQL .= " AND a.unitsukpa LIKE '".$dt->kode_unit_subunit."'";
        }

        $subdata['daftar_spplspeg'] = array();
        $subdata['cur_tahun'] = $this->cur_tahun;
        $sql = "SELECT tahun FROM kepeg_tr_sppls GROUP BY tahun ORDER BY tahun ASC";
        $subdata['tahun'] = $this->db->query($sql)->result();
        // $d = $this->uri->uri_to_assoc(3);
        // if(isset($d['tahun'])){
            $sql = "SELECT a.*,DATE_FORMAT(a.tanggal, '%d %M %Y') as tanggal2,COUNT(b.id) AS jml_tolak FROM kepeg_tr_sppls a LEFT JOIN kepeg_tr_sppls_detail b ON a.id_sppls = b.id_tr_sppls WHERE tahun LIKE '".intval($subdata['cur_tahun'])."'".$vSQL." GROUP BY a.id_sppls ORDER BY a.nomor DESC";
            $subdata['daftar_spplspeg'] = $this->db->query($sql)->result();
            // $subdata['cur_tahun'] = $d['tahun'];
        // }
        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view("tor/daftar_spplspeg",$subdata,TRUE);
        $this->load->view('main_template',$data);
    }
    function spp_to_spm(){
        $status = "Pengajuan ke PPK SUKPA";
        if($_POST['proses']==9){
          $pelaku = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], $_SESSION['rsa_level']);
          $sql = "INSERT INTO kepeg_tr_sppls_detail(id_tr_sppls, alasan_tolak, penolak, waktu_proses) VALUES('".$_POST['id_sppls']."', '".htmlentities($_POST['alasan_tolak'],ENT_QUOTES)."', '".$pelaku->nama." - ".$_SESSION['rsa_nama_unit']."', NOW())";
          $this->db->query($sql);
          $status = "Ditolak ".$pelaku->nama." - ".$_SESSION['rsa_nama_unit'];
          $dt = $this->get_detail_belanja_spp($_POST['id_sppls']);
          // print_r($dt); exit;
          $akun = explode(",",$dt->detail_belanja);
          foreach ($akun as $key => $value) {
            $this->batal_dpa_22($value);
            // $dt = $this->get_rsa_detail_belanja_single($v);
            // $this->histori_batal_dpa($dt);
          }
          // exit;
          // $this->batal_dpa_spp($akun);
        }
        if($_POST['proses']==2){
            $status = "disetujui ".$pelaku->nama." - ".$_SESSION['rsa_nama_unit'];
        }
        if($_POST['proses']==3){
            $status = "diajukan SPM";
            $this->createSPMfromSPP($_POST['id_sppls']);
            // exit;
        }
        $sql = "UPDATE kepeg_tr_sppls SET proses = ".intval($_POST['proses']).", status = '".$status."' WHERE id_sppls = ".intval($_POST['id_sppls']);
        // echo $sql; exit;
        if($this->db->query($sql)){
            $dt = $this->db->query('SELECT jenissppls FROM kepeg_tr_sppls WHERE id_sppls='.$_POST['id_sppls'])->row();
            $this->addLog($_POST['id_sppls'], 'kepeg_tr_sppls', $dt->jenissppls, $status);
            echo "1"; exit;
        }
        echo $this->msgGagal('Kegagalan sistem memproses perintah.'); exit;
    }
    function spp_tolak_detail(){
        if(isset($_POST['id_sppls'])){
            $sql = "SELECT * FROM kepeg_tr_sppls_detail WHERE id_tr_sppls = ".intval($_POST['id_sppls']);
            $r = $this->db->query($sql)->result();
            if(count($r)>0){
                echo "<table class=\"table table-bordered small\">";
                echo "<tr><th class=\"text-center\">No</th><th class=\"text-center\">Tanggal</th><th class=\"text-center\">Alasan</th><th class=\"text-center\">Penolak</th></tr>";
                $i=1;
                foreach ($r as $k => $v) {
                    echo "<tr>";
                    echo "<td class=\"text-right\">".$i."</td>";
                    echo "<td>".$v->waktu_proses."</td>";
                    echo "<td>".html_entity_decode($v->alasan_tolak,ENT_QUOTES)."</td>";
                    echo "<td>".$v->penolak."</td>";
                    echo "</tr>";
                    $i++;
                }
                echo "</table>";
            }else{
                echo "<p class=\"alert alert-warning\">Tidak ada data penolakan.</p>";
            }
            exit;
        }
    }
    function daftar_spmlspeg(){
        $vSQL = "";
        /*if(intval($_SESSION['rsa_kode_unit_subunit'])!=99){
          $vSQL.= " AND c.unitsukpa = '".$_SESSION['rsa_kode_unit_subunit']."'";
        }*/

        /*$dt = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
        $unt = $this->cantik_model->get_unit_verifikator($dt->id);
        if(!is_null($unt)){
          $vSQL.=" AND ";
          $vSQL2 = array();
          foreach ($unt as $k => $v) {
            $vSQL2[] = "a.unitsukpa LIKE '".$v->kode_unit_subunit."%'";
          }
          $vSQL.="(".implode(" OR ", $vSQL2).")";
        }*/

        $dt = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
        if(intval($dt->level) == 3 || intval($dt->level) == 11 ){
          $unt = $this->cantik_model->get_unit_verifikator($dt->id);
          // print_r($unt); exit;
          if(!is_null($unt)){
            $vSQL.=" AND ";
            $vSQL2 = array();
            foreach ($unt as $k => $v) {
              // if(strlen($v->kode_unit_subunit)==2){
              //   $vSQL2[] = "a.unitsukpa LIKE '".$v->kode_unit_subunit."%'";
              // }else
              // if(strlen($v->kode_unit_subunit)==1){
              //   $vSQL2[] = "a.unitsukpa LIKE '".$v->kode_unit_subunit."'";
              // }
              $vSQL2[] = "a.unitsukpa LIKE '".$v->kode_unit_subunit."%'";
            }
            $vSQL.=implode(" OR ", $vSQL2);
          }
        }else{
          $vSQL .= " AND a.unitsukpa LIKE '".$dt->kode_unit_subunit."'";
        }

        if($_SESSION['rsa_level']=='2'){
            // $vSQL= " AND a.proses = 1";
            $subdata['rel'] = 2;
        }
        if($_SESSION['rsa_level']=='3'){
            // $vSQL= " AND a.proses = 2";
            $subdata['rel'] = 3;
        }
        if($_SESSION['rsa_level']=='5'){
            // $vSQL= " AND a.proses = 3";
            $subdata['rel'] = 4;
        }
        if($_SESSION['rsa_level']=='11'){
            // $vSQL= " AND (a.proses = 4 OR a.proses = 3)";
            $subdata['rel'] = 5;
        }
        $subdata['daftar_spmlspeg'] = array();
        $subdata['cur_tahun'] = $this->cur_tahun;
        $sql = "SELECT tahun FROM kepeg_tr_spmls GROUP BY tahun ORDER BY tahun ASC";
        $subdata['tahun'] = $this->db->query($sql)->result();
        $sql = "SELECT * FROM akun_kas6 a LEFT JOIN kas_undip b ON a.kd_kas_6 = b.kd_akun_kas WHERE b.aktif = 1";
        $subdata['akun_cair'] = $this->db->query($sql)->result();
        // $d = $this->uri->uri_to_assoc(3);
        // if(isset($d['tahun'])){
            $sql = "SELECT a.*,DATE_FORMAT(a.tanggal, '%d %M %Y') as tanggal2,COUNT(b.id) AS jml_tolak, c.untuk_bayar FROM kepeg_tr_spmls a LEFT JOIN kepeg_tr_spmls_detail b ON a.id_spmls = b.id_tr_spmls LEFT JOIN kepeg_tr_sppls c ON a.id_tr_sppls = c.id_sppls WHERE a.tahun LIKE '".intval($subdata['cur_tahun'])."'".$vSQL." GROUP BY a.id_spmls ORDER BY a.nomor DESC";
            $subdata['daftar_spmlspeg'] = $this->db->query($sql)->result();
            // $subdata['cur_tahun'] = $d['tahun'];
        // }
        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view("tor/daftar_spmlspeg",$subdata,TRUE);
        $this->load->view('main_template',$data);
    }
    // fungsi untuk mengambil akun dari spmls
    function get_detail_belanja_spm($id){
      $dt = $this->db->query("SELECT detail_belanja FROM kepeg_tr_spmls WHERE id_spmls LIKE '".intval($id)."'")->row();
      return $dt;
    }
    // fungsi untuk mengambil akun dari sppls
    function get_detail_belanja_spp($id){
      $dt = $this->db->query("SELECT detail_belanja FROM kepeg_tr_sppls WHERE id_sppls LIKE '".intval($id)."'")->row();
      return $dt;
    }
    // fungsi proses berjalannya spm ke pencairan
    function spm_to_cair(){
        //print_r($_POST); exit;
        $_akun_cair = "";
        $pelaku = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], $_SESSION['rsa_level']);
        $status = "Pengajuan";
        if($_POST['proses']==9){
            $sql = "INSERT INTO kepeg_tr_spmls_detail(id_tr_spmls, alasan_tolak, penolak, waktu_proses) VALUES('".$_POST['id_spmls']."', '".htmlentities($_POST['alasan_tolak'],ENT_QUOTES)."', '".$pelaku->nama."', NOW())";
            $this->db->query($sql);
            $status = "Ditolak ".$pelaku->nama;
            $dt = $this->get_detail_belanja_spm($_POST['id_spmls']);
            $akun = explode(",",$dt->detail_belanja);
            foreach ($akun as $key => $value) {
              $this->batal_dpa_22($value);
            }
        }
        if($_POST['proses']==1){
            $status = "Pengajuan ke KPA SUKPA";
        }
        if(in_array(intval($_POST['proses']),array(2,3,4))){
          if(intval($_SESSION['rsa_level'])==3){
            $this->add_verifikator_spm($_POST['id_spmls']);
            $this->cantik_model->update_spmls('tglver',date('Y-m-d'),$_POST['id_spmls']);
          }
          $status = "disetujui ".$pelaku->nama.", menunggu proses selanjutnya.";
        }
        if($_POST['proses']==5){
          $status = "dicairkan oleh KBUU melalui akun ".$_POST['akun_cair'];
          $this->ambil_dana_kas($_POST['id_spmls'], $_POST['akun_cair']);
          $this->urut_spm_cair($_POST['id_spmls']);
          foreach ($akun as $key => $value) {
            $this->cantik_model->update_rsa_detail_belanja($value,'62');
          }
          $_akun_cair = ", akun_cair = '".$_POST['akun_cair']."'";
        }
        $sql = "UPDATE `kepeg_tr_spmls` SET `proses` = ".intval($_POST['proses']).", `status` = '".$status."'".$_akun_cair." WHERE `id_spmls` = ".intval($_POST['id_spmls']);
        if($_POST['proses']==5){
        	// echo $sql; exit;
        }
        if($this->db->query($sql)){
        		if($_POST['proses']==5){
		        	// echo 'SELECT b.jenissppls FROM kepeg_tr_spmls a LEFT JOIN kepeg_tr_sppls b ON a.id_tr_sppls = b.id_sppls WHERE a.id_spmls = '.$_POST['id_spmls']; exit;
		        }
            $dt = $this->db->query('SELECT b.jenissppls FROM kepeg_tr_spmls a LEFT JOIN kepeg_tr_sppls b ON a.id_tr_sppls = b.id_sppls WHERE a.id_spmls = '.$_POST['id_spmls'])->row();
            $this->addLog($_POST['id_spmls'], 'kepeg_tr_spmls', $dt->jenissppls, $status);
            echo "1"; exit;
        }
        echo $this->msgGagal('Kegagalan sistem memproses perintah.');
        exit;
    }
    // fungsi untuk view detal penolakan spm
    function spm_tolak_detail(){
        if(isset($_POST['id_spmls'])){
            $sql = "SELECT * FROM kepeg_tr_spmls_detail WHERE id_tr_spmls = ".intval($_POST['id_spmls']);
            $r = $this->db->query($sql)->result();
            if(count($r)>0){
                echo "<table class=\"table table-bordered small\">";
                echo "<tr><th class=\"text-center\">No</th><th class=\"text-center\">Tanggal</th><th class=\"text-center\">Alasan</th><th class=\"text-center\">Penolak</th></tr>";
                $i=1;
                foreach ($r as $k => $v) {
                    echo "<tr>";
                    echo "<td class=\"text-right\">".$i."</td>";
                    echo "<td>".$v->waktu_proses."</td>";
                    echo "<td>".html_entity_decode($v->alasan_tolak,ENT_QUOTES)."</td>";
                    echo "<td>".$v->penolak."</td>";
                    echo "</tr>";
                    $i++;
                }
                echo "</table>";
            }else{
                echo "<p class=\"alert alert-warning text-center\">Tidak ada data penolakan.</p>";
            }
            exit;
        }
    }
    function spmls(){
        $d = $this->uri->uri_to_assoc(3);
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

        
        $subdata['kd_unit'] = $sub[0]->unitsukpa;
        $subdata['kpa'] = $this->user_model->get_detail_rsa_user($sub[0]->unitsukpa, '2');
        $subdata['buu'] = $this->user_model->get_detail_rsa_user('99', '5');
        $subdata['kbuu'] = $this->user_model->get_detail_rsa_user('99', '11');
        if(intval($_SESSION['rsa_level'])==3){
          $subdata['bver'] = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
        }
        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view("tor/form-spmls",$subdata,TRUE);
        $this->load->view('main_template',$data);
    }
    function spmLScetak(){
        $d = $this->uri->uri_to_assoc(3);
        $sql = "SELECT * FROM kepeg_tr_spmls WHERE id_spmls =".intval($d['id']);
        $sub = $this->db->query($sql)->result();
        $jm = strlen($sub[0]->id_spmls);
        $subdata['id_spmls'] = "";
        for($i=0;$i<(5-$jm);$i++){
            $subdata['id_spmls'] .= "0";
        }
        $subdata['id_spmls'] .= $sub[0]->id_spmls;
        if($this->input->post('dtable')){
            $data['main_content'] = base64_decode($this->input->post('dtable'));
            $this->load->view('cetak_template',$data);
        }
    }
    function lspeg(){
        $subdata['cur_tahun'] = date('Y');
        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view("tor/dashboard_lspeg",$subdata,TRUE);
        $this->load->view('main_template',$data);
    }
    // tambah log untuk spm maupun spp
    function addLog($id,$tabel,$jenis,$status){
      $dt = $this->db->query("SELECT * FROM ".$tabel." WHERE id_".substr($tabel,-5)." = ".$id)->result();
      if(count($dt)>0){
        $this->db->query("INSERT INTO kepeg_tr_lspeg_log(id_tr, nomor_tr, tabel_tr, jenis_tr, status_tr, waktu_tr) VALUES('".$id."', '".$dt[0]->nomor."', '".$tabel."', '".$jenis."', '".$status."', NOW())");
      }
    }
    // untuk tambahkan verifikator yang ada
    function add_verifikator_spm($id_spmls){
      $dt = $this->db->query("SELECT * FROM `kepeg_tr_spmls` WHERE `id_spmls` = ".$id_spmls)->row();
      if(count($dt)>0){
        $v = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
        $this->db->query("INSERT INTO trx_spm_verifikator(nomor_trx_spm, kode_unit_subunit, jenis_trx, id_rsa_user_verifikator, tgl_proses, tahun, str_nomor_trx_spm) VALUES('".intval(str_replace("0","",substr($dt->nomor,0,5)))."', '".$dt->unitsukpa."', 'LSP', '".$v->id."', NOW(), '".$dt->tahun."', '".$dt->nomor."')");
        $this->db->query("UPDATE kepeg_tr_spmls SET namaver = '".$v->nm_lengkap."', nipver = '".$v->nomor_induk."' WHERE `id_spmls` = ".$id_spmls);
      }
    }
    // untuk daftar pencairan Spm
    function urut_spm_cair($id){
    	// echo "SELECT * FROM `kepeg_tr_spmls` WHERE `id_spmls` = ".$id; exit;
      $dt = $this->db->query("SELECT * FROM `kepeg_tr_spmls` WHERE `id_spmls` = ".$id)->row();
      // if(count($dt)>0){
      $no_urut = $this->db->query("SELECT `no_urut` FROM `trx_urut_spm_cair` ORDER BY no_urut DESC LIMIT 0,1")->row();
      // $no_urut = intval($no_urut->no_urut)+1;
      $no_urut = $this->cantik_model->lspgw_autonumber($no_urut->no_urut,6);
      $sql = "INSERT INTO trx_urut_spm_cair(no_urut, str_nomor_trx_spm, kode_unit_subunit, jenis_trx, tgl_proses, bulan, tahun) VALUES('".$no_urut."', '".$dt->nomor."', '".$dt->unitsukpa."', 'LSP', NOW(), '".$this->wordMonthShort($this->getMonth($dt->tanggal))."', '".$dt->tahun."')";
      // echo $sql; exit;
      $this->db->query($sql);
      // }
    }
    // pilihan untuk mengambil dana terakhir dari record, dan memotongnya
    function ambil_dana_kas($id_spmls, $akun_cair){
      $sql = "SELECT a.total_sumberdana, a.nomor, a.tahun, b.untuk_bayar, a.unitsukpa FROM kepeg_tr_spmls a LEFT JOIN kepeg_tr_sppls b ON a.id_tr_sppls = b.id_sppls WHERE a.id_spmls = ".$id_spmls;
      $sql2 = "SELECT * FROM kas_undip WHERE kd_akun_kas LIKE '".$akun_cair."' AND aktif = 1 ORDER BY aktif DESC LIMIT 0,1";
      $spm = $this->db->query($sql)->row();
      $akun = $this->db->query($sql2)->row();
      $kredit = $spm->total_sumberdana;
      $no_spm = $spm->nomor;

      $debet = 0;
      $saldo = $akun->saldo - $kredit;
      $tahun = $spm->tahun;
      $deskripsi = $spm->untuk_bayar;
      $unit = $spm->unitsukpa;
      // ubah aktif ke 0;
      $sql = "UPDATE kas_undip SET aktif = 0 WHERE id_kas_bendahara = ".$akun->id_kas_bendahara;
      $sql2 = "INSERT INTO kas_undip(tgl_trx, kd_akun_kas, deskripsi, no_spm, debet, kredit, saldo, aktif, tahun, kd_unit) VALUES(NOW(), '".$akun_cair."', '".$deskripsi."', '".$no_spm."', '0', '".$kredit."', '".$saldo."', '1', '".$tahun."', '".$unit."')";
      // echo $sql."<br/>";
      // echo $sql2; exit;
      $this->db->query($sql); $this->db->query($sql2);
      return $saldo;
    }
    // untuk mengambil variabel tambahan untuk proses realisasi dpa
    function proses_lspeg_var(){
      $html = "<label class=\"control-label col-md-3 small\">Tahun:</label>";
      $html .= "<div class=\"col-md-9\"><select name=\"varTambahan\" id=\"varTambahan\" class=\"form-control input-sm\">";
      if($_POST['jenisLSPeg']=='ipp'){
        $dt = $this->db->query("SELECT semester, tahun FROM kepeg_tr_ipp GROUP BY semester, tahun  ORDER BY tahun, semester ASC")->result();
        if(count($dt)>0){
          foreach ($dt as $k => $v) {
            $html.="<option value=\"".$v->tahun.$v->semester."\">Semester ".$v->semester." Tahun ".$v->tahun."</option>";
          }
        }
      }elseif($_POST['jenisLSPeg']=='ikw'){
        $dt = $this->db->query("SELECT bulan, tahun FROM kepeg_tr_ikw GROUP BY bulan, tahun ORDER BY tahun, bulan ASC")->result();
        if(count($dt)>0){
          foreach ($dt as $k => $v) {
            $html.="<option value=\"".$v->tahun.$v->bulan."\">Bulan ".$this->wordMonthShort(intval($v->bulan))." Tahun ".$v->tahun."</option>";
          }
        }
      }elseif($_POST['jenisLSPeg']=='tutam'){
        $dt = $this->db->query("SELECT bulan, tahun FROM kepeg_tr_tutam GROUP BY bulan, tahun ORDER BY tahun, bulan ASC")->result();
        if(count($dt)>0){
          foreach ($dt as $k => $v) {
            $html.="<option value=\"".$v->tahun.$v->bulan."\">Bulan ".$this->wordMonthShort(intval($v->bulan))." Tahun ".$v->tahun."</option>";
          }
        }
      }
      $html.="</select>";
      echo $html;
      exit;
    }
    // fungsi untuk batalDPA()
    function batal_dpa($akun){
//        echo "UPDATE rsa_detail_belanja_ SET proses = 0 WHERE kode_usulan_belanja LIKE '".substr($akun,0,-3)."' AND kode_akun_tambah LIKE '".substr($akun,-3)."'" ;die;
      if($this->db->query("UPDATE rsa_detail_belanja_ SET proses = 0 WHERE kode_usulan_belanja LIKE '".substr($akun,0,-3)."' AND kode_akun_tambah LIKE '".substr($akun,-3)."'")){
        return true;
      }
      return false;
//      exit;
    }
    // fungsi untuk batalDPA()
    function batal_dpa_22($akun){
      $sql = "UPDATE rsa_detail_belanja_ SET proses = '32' WHERE kode_usulan_belanja LIKE '".substr($akun,0,-3)."' AND kode_akun_tambah LIKE '".substr($akun,-3)."'";
      // echo $sql; exit;
      if($this->db->query($sql)){
        return true;
      }
      return false;
    }
    // fungsi untuk input akunDPA batal untuk dimasukkan ke dalam tabel baru
    function histori_batal_dpa($dt){
      $blob = base64_encode(serialize($dt));
      $v = $this->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
      $sql = "INSERT INTO rsa_detail_belanja_batal(akun, konten_detail_belanja, tukang_batalin, unit_tukang_batalin, id_tukang_batalin, waktu_batal) VALUES('".$dt->kode_usulan_belanja.$dt->kode_akun_tambah."', '".$blob."', '".$_SESSION['rsa_username']."', '".$_SESSION['rsa_kode_unit_subunit']."', '".$v->id."', NOW())";
//       echo $sql; exit;
      $this->db->query($sql);
//      exit;
    }
    // fungsi untuk batalin DPA dari view
    function prosesBatalDPA(){
      $dt = $this->get_rsa_detail_belanja_single($_POST['akunne']);
//      var_dump($dt); die;
      if(count($dt)>0){
        $this->histori_batal_dpa($dt);
//        echo '2';die;
        $this->batal_dpa($_POST['akunne']);
        echo "1";
        // echo $this->msgSukses("Sukses membatalkan DPA yang diusulkan.");
      }else{
        echo $this->msgGagal("Gagal melakukan pemilihan DPA, mungkin DPA tidak ditemukan.");
      }
      exit;
    }
    function get_rsa_detail_belanja_single($akun){
      $dt = $this->db->query("SELECT * FROM `rsa_detail_belanja_` WHERE `kode_usulan_belanja` LIKE '".substr($akun,0,-3)."' AND kode_akun_tambah LIKE '".substr($akun,-3)."'")->row();
      return $dt;
    }
    function proses_override_sppls(){
      // fungsi untuk override proses pembuatan sppls dengan validasi
      // 777echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
      if(isset($_POST) && isset($_POST['act']) && $_POST['act'] == 'override_spp'){
        // if(!isset($_POST['pajak']) || intval($_POST['pajak'])<=0){
        //   echo $this->msgGagal('Masukkan pajak, karena pajak tidak mungkin bernilai 0 atau kurang dari itu.'); exit;
        // }
        if(!isset($_POST['potongan']) || intval($_POST['potongan'])<0){
          echo $this->msgGagal('Masukkan pajak, karena pajak tidak mungkin bernilai kurang dari 0.'); exit;
        }
				if($_SESSION['rsa_kode_unit_subunit'] != '81'){
        	if(!isset($_POST['unit_id']) || !is_array($_POST['unit_id']) || count($_POST['unit_id'])<=0 ){
          	echo $this->msgGagal('Pilih unit yang akan di-proses.'); exit;
        	}
				}else{
					$_POST['unit_id'] = array('81');
				}
        if(!isset($_POST['status']) || !is_array($_POST['status']) || count($_POST['status'])<=0 ){
          echo $this->msgGagal('Pilih status pegawai yang akan di-proses.'); exit;
        }
        if(!isset($_POST['jnspeg']) || !in_array(intval($_POST['jnspeg']),array(1,2))){
          echo $this->msgGagal('Pilih jenis pegawai yang diproses.'); exit;
        }
        if(isset($_POST['jenisSPPLSPeg']) && $_POST['jenisSPPLSPeg']=='ipp'){
          if(!isset($_POST['semester']) || !in_array(intval($_POST['semester']),array(1,2))){
            echo $this->msgGagal('Pilih semester proses pencairan.'); exit;
          }
        }else{
          if(!isset($_POST['bulan']) || !in_array(intval($_POST['bulan']),array(1,2,3,4,5,6,7,8,9,10,11,12))){
            echo $this->msgGagal('Pilih bulan proses pencairan.'); exit;
          }
        }
        if(!isset($_POST['tahun']) || strlen(trim($_POST['tahun']))!=4){
          echo $this->msgGagal('Masukkan tahun proses pencairan.'); exit;
        }
        if(isset($_POST['akun'])){
          $_POST['akun'] = explode(",", trim($_POST['akun']));
          unset($_POST['akun'][(count($_POST['akun'])-1)]);
        }
        if(!isset($_POST['akun']) || !is_array($_POST['akun']) || count($_POST['akun'])<=0 ){
          echo $this->msgGagal('Pilih akun dpa yang akan di-proses menjadi SPP.'); exit;
        }
				// exit;
        echo $this->cantik_model->insert_do_sppls($_POST);
        // echo "<pre>"; print_r($_POST); echo "</pre>";
      }
      exit;
    }
    // END HERE
	//LS PIHAK 3
	function tampil_data_gedang(){
		$html = "";
		$sql = "SELECT a.*,b.deskripsi FROM `rsa_spm_kontrakpihak3` a LEFT JOIN `rsa_detail_belanja_` b ON a.kode_usulan_belanja = b.kode_usulan_belanja WHERE a.kode_usulan_belanja LIKE '".$_POST['akun']."' GROUP BY a.id";
		$q=$this->db->query($sql);
		if($q->num_rows()>0){
			$d = $q->result();
			foreach($d as $k => $v){
				$html.="<option value=\"".$v->id."\">".$v->deskripsi." - (Terbayar : ".number_format($v->kontrak_terbayar,2,',','.').") - Termin (".$v->termin.")</option>";
			}
		}
		echo $html;exit;
	}
  // untuk melakukan pengecekan terhadap jumlah dana dengan yang ada.
  function cocoklogi_dpa_kontrak(){
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit;
    // if(isset($_POST)){
      // if($_POST['daftar_kontrak']){
      //   $sql = "SELECT * FROM rsa_spm_kontrakpihak3";
      // }
    // }
  }
  // end tambahan kontrak
  //add lsphk3
   function realisasi_tor_lsphk3($kode,$sumber_dana,$jenis){

          // echo $this->cur_tahun ; die;

            $data['cur_tahun'] = $this->cur_tahun ;

            /* check session  */
    if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
    $unit = $this->check_session->get_unit();
      $data['main_menu']              = $this->load->view('main_menu','',TRUE);
//      $subdata['rsa_usul']    = $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
      $subdata['tor_usul']            = $this->tor_model->get_tor_usul($kode);//$this->tor_model->get_tor_usul(substr($kode,2,10));
      $subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($unit,$kode,$sumber_dana,$this->cur_tahun);
      $subdata['detail_rsa_dpa']      = $this->kuitansi_lsphk3_model->get_detail_rsa_dpa_lsphk3($unit,$kode,$sumber_dana,$this->cur_tahun);
    foreach($subdata['detail_rsa_dpa'] as $r){
      if(substr($r->proses,1,1)=='4'){
        $kode=$r->kode_usulan_belanja;
      $akun_tambah = $r->kode_akun_tambah;
        $vol=$r->volume;
        $harga=$r->harga_satuan;
        $nominal=$vol*$harga;
        $tahun=$this->cur_tahun;
        $subdata['kontrak'][$r->kode_usulan_belanja.$r->kode_akun_tambah]=$this->tor_model->get_detail_rsa_kontrak2($kode,$akun_tambah,$tahun,$nominal,$unit);
        // var_dump($subdata['kontrak']);die;
      }
    }
    // var_dump($subdata['kontrak']); exit;
    // $subdata['kontrak']            = $this->tor_model->get_kontrak($kode);
//      echo '<pre>';
     //  var_dump( $subdata['detail_rsa_dpa']);
//      echo '</pre>';die;
      $subdata['opt_sumber_dana']   = $this->option->sumber_dana();
      $subdata['sumber_dana']   = $sumber_dana;
      $subdata['kode']                = $kode;
      $subdata['tahun']               = $this->cur_tahun ;
      if(strlen($this->check_session->get_unit())==2){
        $subdata['kode_unit']           = $this->check_session->get_unit();
        $subdata['nm_unit']             = $this->check_session->get_nama_unit();
      }
      elseif(strlen($this->check_session->get_unit())==4){
            if((substr($this->check_session->get_unit(),0,2) == '41')||(substr($this->check_session->get_unit(),0,2) == '42')||(substr($this->check_session->get_unit(),0,2) == '43')||(substr($this->check_session->get_unit(),0,2) == '44')){
                $subdata['kode_unit']           = substr($this->check_session->get_unit(),0,2);
                $subdata['nm_unit']             = $this->unit_model->get_nama_unit(substr($this->check_session->get_unit(),0,2)) . ' - ' . $this->check_session->get_nama_unit();
            }else{
                $subdata['kode_unit']           = substr($this->check_session->get_unit(),0,2);
                $subdata['nm_unit']             = $this->unit_model->get_nama_unit(substr($this->check_session->get_unit(),0,2));
            }

      }elseif(strlen($this->check_session->get_unit())==6){
            if((substr($this->check_session->get_unit(),0,2) == '41')||(substr($this->check_session->get_unit(),0,2) == '42')||(substr($this->check_session->get_unit(),0,2) == '43')||(substr($this->check_session->get_unit(),0,2) == '44')){
                $subdata['kode_unit']           = substr($this->check_session->get_unit(),0,2);
                $subdata['nm_unit']             = $this->unit_model->get_nama_unit(substr($this->check_session->get_unit(),0,2)) . ' - ' . $this->unit_model->get_nama_subunit(substr($this->check_session->get_unit(),0,4));
            }else{
                $subdata['kode_unit']           = substr($this->check_session->get_unit(),0,2);
                $subdata['nm_unit']             = $this->unit_model->get_nama_unit(substr($this->check_session->get_unit(),0,2));
            }
      }
      $subdata['alias']               = $this->tor_model->get_alias_unit($this->check_session->get_unit());
      $subdata['jenis']               = $jenis;
      $subdata['pic_kuitansi']        = $this->tor_model->get_pic_kuitansi($this->check_session->get_unit());
      $subdata['pppk']                = $this->tor_model->get_pppk(substr($this->check_session->get_unit(),0,2));
	  $subdata['ppk']                = $this->tor_model->get_ppk(substr($this->check_session->get_unit(),0,2));
	  $subdata['allpppk']                = $this->tor_model->get_allpppk();
	  $subdata['allppk']                = $this->tor_model->get_allppk();
	   $subdata['ppksukpa']                = $this->tor_model->get_pppk(substr($this->check_session->get_unit(),0,2));

//      var_dump($subdata['pic_kuitansi'] );die;

      if($this->check_session->get_level() == '4'){
          $subdata['pumk'] = $this->user_model->get_detail_rsa_user_by_username($this->check_session->get_username());
      }

      // tambahan dari dhanu
      if($this->cantik_model->manual_override()){
        $subdata['status_kepeg'] = array();
        if(isset($_SESSION['ovr']['status_kepeg'])){
          $subdata['status_kepeg'] = $_SESSION['ovr']['status_kepeg'];
        }
        $subdata['unitList'] = $this->cantik_model->getUnitList($_SESSION['ovr']['unit_id']);
        $subdata['statusKepegOption'] = $this->cantik_model->getStatusKepegFullCheckbox($subdata['status_kepeg']);
        $_bulan = date('m');
        if(isset($_SESSION['ovr']['bulan'])){
          $_bulan = $_SESSION['ovr']['bulan'];
        }
        $subdata['bulanOption'] = $this->cantik_model->getBulanOption($_bulan);
        $subdata['jenisOption'] = $this->cantik_model->get_opsi_jenis_sppls();
        $subdata['semesterOption'] = $this->cantik_model->get_opsi_semester();
      }
      // end here

      $data['main_content']     = $this->load->view("tor/realisasi_tor_lsphk3",$subdata,TRUE);
      /*  Load main template  */
//      echo '<pre>';var_dump($subdata);echo '</pre>';die;
      $this->load->view('main_template',$data);
    }else{
      redirect('welcome','refresh');  // redirect ke halaman home
    }

        }



        function get_status_dpa(){

          if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){

              $rka = $this->input->post('rka');
              $sumber_dana = $this->input->post('sumber_dana');
              $tahun = $this->input->post('tahun');

              $jenis = $this->tor_model->get_status_jenis($rka,$sumber_dana,$tahun);

              // echo $jenis ; die;

              if((substr($jenis,1,1) == '1') || (substr($jenis,1,1) == '3') || (substr($jenis,1,1) == '5')){ // GUP , TUP dan KS

                  $r = $this->tor_model->get_status_dpa($rka,$sumber_dana,$tahun);
              
                  // var_dump($r);

                  $nr = count($r);

                  if($nr > 0){
                    echo json_encode($r[$nr - 1]);
                  }

              }else if(substr($jenis,1,1) == '2'){ // LS PEGAWAI
                $r = array(
                  'id_kuitansi' => '-',
                  'aktif'=> '1',
                  'no_bukti'=> '-',
                  'str_nomor_trx'=> '', // SPP
                  'str_nomor_trx_spm'=> '', // SPM
                  'proses'=>substr($jenis,0,1),
                  );
                echo json_encode($r);
              }

              // var_dump($r[$nr]);


        }
      }
}
