<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Kuitansi_lsphk3 extends CI_Controller {
    
    private $cur_tahun = '' ;
	
    public function __construct()
    {
            parent::__construct();
            
            $this->cur_tahun = $this->setting_model->get_tahun();
            
            if ($this->check_session->user_session()){
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model('kuitansi_lsphk3_model');
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
			redirect('kuitansi_lsphk3/daftar_kuitansi_lsphk3/','refresh');
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}
        
        function submit_kuitansi(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                $kode_akun_tambah = $this->input->post('kode_akun_tambah');
                $kode_usulan_belanja = $this->input->post('kode_usulan_belanja');
                
                $data_id_kuitansi = array(
//                        'jenis' => $this->input->post('jenis'),
                        'tahun' => $this->cur_tahun ,
//                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'alias' => $this->check_session->get_alias(),
                    );

                $no_bukti = $this->kuitansi_lsphk3_model->get_next_id($data_id_kuitansi);
                
                
//                var_dump($this->input->post());die;
                
                // KUITANSI MAX < 50 JT
                
//                $data = array();
//                $i = 0 ;
//                foreach($kode_akun_tambah as $k){
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
//                    $this->kuitansi_lsphk3_model->insert_data_kuitansi($data);die;
//                    var_dump($data);die;
//                    $i++;
//                    
//                }
                $id_kuitansi = $this->kuitansi_lsphk3_model->insert_data_kuitansi($data);
                
                $pajak_kode_usulan_ = json_decode($this->input->post('pajak_kode_usulan'));
                $pajak_id_input_ = json_decode($this->input->post('pajak_id_input'));
                $pajak_jenis_ = json_decode($this->input->post('pajak_jenis'));
                $pajak_dpp_ = json_decode($this->input->post('pajak_dpp'));
                $pajak_persen_ = json_decode($this->input->post('pajak_persen'));
                $pajak_nilai_ = json_decode($this->input->post('pajak_nilai'));
//                var_dump($pajak_id_input_);
//                var_dump($pajak_jenis_);
                $ii = 0 ;
                $this->load->model('tor_model');
                foreach($pajak_kode_usulan_ as $pajak_kode_usulan ){
                    
//                    get_single_detail_rsa_dpa($kode_usulan_belanja,$kode_akun_tambah,$sumber_dana,$tahun){
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
                    $id_kuitansi_detail = $this->kuitansi_lsphk3_model->insert_data_usulan($data);
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
                                        'no_bukti' => $this->input->post('no_bukti'),
                                        'id_input_pajak' => $pajak_id_input,
                                        'jenis_pajak' => $jenis_pajak,
                                        'dpp' => $pajak_dpp_[$ii][$k],
                                        'persen_pajak' => $pajak_persen_[$ii][$k],
                                        'rupiah_pajak' => str_replace(".","",$pajak_nilai_[$ii][$k]),
                                    );
                                    $this->kuitansi_lsphk3_model->insert_data_pajak($data);
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
//                if($this->kuitansi_lsphk3_model->insert_data($data)){
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
        
        function get_next_id(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
                    $data = array(
//                        'jenis' => $this->input->post('jenis'),
                        'tahun' => $this->cur_tahun ,
//                        'sumber_dana' => $this->input->post('sumber_dana'),
                        'alias' => $this->input->post('alias'),
                    );
                    echo $this->kuitansi_lsphk3_model->get_next_id($data);
            }
            else{
                redirect('welcome','refresh');	// redirect ke halaman home
            }
        }
        
        function daftar_kuitansi($jenis='',$tahun="",$kode_unit_subunit=""){
                    
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
//                                $subdata['daftar_kuitansi']          = $this->kuitansi_lsphk3_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun);
//                            }elseif($this->check_session->get_level() == '4'){
//                                $subdata['daftar_kuitansi']          = $this->kuitansi_lsphk3_model->get_kuitansi_own($jenis,$kode_unit_subunit,$tahun);
//                            }
//                            echo '<pre>';var_dump($subdata['daftar_kuitansi']);echo '</pre>';die;
                            $subdata['daftar_kuitansi']          = $this->kuitansi_lsphk3_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun);
                            $data['main_content']           = $this->load->view("kuitansi_lsphk3/daftar_kuitansi",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
                
                function get_data_kuitansi(){
                    if($this->input->post('id')){
                        $data_kuitansi = $this->kuitansi_lsphk3_model->get_data_kuitansi($this->input->post('id'),$this->cur_tahun);
                        $data_detail_kuintansi = $this->kuitansi_lsphk3_model->get_data_detail_kuitansi($this->input->post('id'),$this->cur_tahun);
                        $data_detail_pajak_kuintansi = $this->kuitansi_lsphk3_model->get_data_detail_pajak_kuitansi($this->input->post('id'),$this->cur_tahun);
//                        var_dump(array(
//                            'kuitansi' => $data_kuitansi,
//                            'kuitansi_detail' => $data_detail_kuintansi,
//                            'kuitansi_detail_pajak' => $data_detail_pajak_kuintansi
//                                )
//                            );die;
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
//                        $this->pdf->load_view('kuitansi_lsphk3/table',array('content' => $html));
//                        $html = base64_decode($this->input->post('dtable'));
                        $unit = $this->input->post('dunit');
                        $nbukti = $this->input->post('nbukti');
                        $tahun = $this->input->post('dtahun');    
                        $html_ = $this->load->view('kuitansi_lsphk3/table',array('content' => $html),TRUE);
//                        echo $html_ ; die;
//                        $h = $this->load->view("rsa_up/cetak",array('html'=>$html),TRUE);
//                        echo $h;
                        $this->load->library('Pdfgen');
                        $this->pdfgen->cetak($html_,'KUITANSI_'.$unit.'_'.$nbukti.'_'.$tahun);
//                            $this->load->library('pdf');
//                            $this->pdf->load_view('kuitansi_lsphk3/table',array('content' => $html));
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
                            if($this->kuitansi_lsphk3_model->proses_kuitansi($data,$this->input->post('id'))){
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

                $no_bukti = $this->kuitansi_lsphk3_model->get_next_id($data_id_kuitansi);
				$data= array(
					'kode_unit' => $this->check_session->get_unit(),
					'kode_usulan_belanja' => $kode_usulan_belanja,
					'kode_akun5digit' => substr($kode_usulan_belanja,18,5),
					'kode_akun' => substr($kode_usulan_belanja,18,6),
					'kode_akun_tambah' => $kode_akun_tambah,
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
					'nmpihak3' => $this->input->post('nmphk3'),
					'alamat' => $this->input->post('alamat'),
					'norekpihak3' => $this->input->post('norekpihak3'),
					'npwp' => $this->input->post('npwp'),
					'nmbankphk3' => $this->input->post('nmbankphk3'),
					'nmrekening' => $this->input->post('nmrekening'),
				);
                 //print_r($data); exit;
				$id_kuitansi = $this->kuitansi_lsphk3_model->insert_data_kuitansi($data);
				// echo $id_kuitansi; exit;
				// kalo lebih dari 1 :
				// $id_kontrak = explode(",",$this->input->post('id_kontrak'));
				$id_kontrak = $this->input->post('id_kontrak');
				$data = array(
							'kuitansi_id' => $id_kuitansi,
							'kontrak_id' => intval($id_kontrak),
						);
                $id_kuitansi_pihak3 = $this->kuitansi_lsphk3_model->insert_data_kuitansi_kontrak($data);
				
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
                    $id_kuitansi_detail = $this->kuitansi_lsphk3_model->insert_data_usulan($data);
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
							$this->kuitansi_lsphk3_model->insert_data_pajak($data);
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
                            $subdata['daftar_kuitansi']          = $this->kuitansi_lsphk3_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun);
//                            echo '<pre>';var_dump($subdata['daftar_kuitansi']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("kuitansi_lsphk3/daftar_kuitansi2",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
				function daftar_data_sppnk($jenis='',$tahun="",$kode_unit_subunit=""){
                    
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
                            $subdata['daftar_kuitansi']          = $this->kuitansi_lsphk3_model->get_kuitansi($jenis,$kode_unit_subunit,$tahun);
//                            echo '<pre>';var_dump($subdata['daftar_kuitansi']);echo '</pre>';die;
                            $data['main_content']           = $this->load->view("kuitansi_lsphk3/daftar_data_sppnk",$subdata,TRUE);
                            /*	Load main template	*/
    //			echo '<pre>';var_dump($subdata['unit_usul_impor']);echo '</pre>';die;
                            $this->load->view('main_template',$data);
                    }else{
                            redirect('welcome','refresh');	// redirect ke halaman home
                    }
                }
				
}