<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Akun_kas6 extends CI_Controller{
/* -------------- Constructor ------------- */
    
private $cur_tahun = '';


public function __construct(){
		parent::__construct();
                
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model(array('akun_kas6_model','akun_kas5_model','akun_kas4_model','akun_kas3_model','akun_kas2_model','setting_model'));
                $this->cur_tahun = $this->setting_model->get_tahun();
                
	}
	
/* -------------- Method ------------- */
	function index()
	{
		show_404('page');
	}
	
	function daftar_akun_kas6($kd_kas_2,$kd_kas_3,$kd_kas_4,$kd_kas_5)
	{
		/* check session	*/
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);
			$tahun = $this->setting_model->get_tahun();
			$subdata['cur_tahun'] = $tahun;
			$subdata_akun_kas6["result_akun_kas6"] = $this->akun_kas6_model->search_akun_kas6($kd_kas_2,$kd_kas_3,$kd_kas_4,$kd_kas_5);
			$subdata["row_akun_kas6"]	= $this->load->view("akun_kas6/row_akun_kas6",$subdata_akun_kas6,TRUE);
			$subdata["result_akun_kas2"]	= $this->akun_kas2_model->get_akun_kas2($kd_kas_2);
			$subdata["result_akun_kas3"]	= $this->akun_kas3_model->get_akun_kas3(array('kd_kas_3'=>$kd_kas_3,'kd_kas_2'=>$kd_kas_2));
			$subdata["result_akun_kas4"]	= $this->akun_kas4_model->get_akun_kas4(array('kd_kas_4'=>$kd_kas_4,'kd_kas_3'=>$kd_kas_3,'kd_kas_2'=>$kd_kas_2));
			$subdata["result_akun_kas5"]	= $this->akun_kas5_model->get_akun_kas5(array('kd_kas_5'=>$kd_kas_5,'kd_kas_4'=>$kd_kas_4,'kd_kas_3'=>$kd_kas_3,'kd_kas_2'=>$kd_kas_2));
			$data["main_content"]			= $this->load->view("akun_kas6/daftar_akun_kas6",$subdata,TRUE);
			/*	Load main template	*/
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
	}
	
	function search_akun_kas6()
	{
		/* check session	*/
		// if($this->check_session->user_session() && ($this->check_session->get_level()==2 || $this->check_session->get_level()==3)){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$subdata['data_row']= $this->akun_kas6_model->search_akun_kas6($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5),$this->uri->segment(6));
			$subdata['kode']  = array(
									'kode-kegiatan' => $this->uri->segment(3),
									'kode-output' => $this->uri->segment(4),
									'kode-program' => $this->uri->segment(5),
									'kode-komponen' => $this->uri->segment(6)
								);
			$data['subkomponen_input'] 	= $this->load->view('responds_subkomponen_input_',$subdata,True);
			
			/*	Load main template	*/
			$this->load->view('search_akun_kas6_',$data);
		}else{
			show_404('page');
		}		
	}
	
	function responds_subkomponen_input()
	{
		/* check session	*/
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$data['data_row'] = $this->akun_kas6_model->search_akun_kas6($this->input->post('kode-kegiatan'), $this->input->post('kode-output'), $this->input->post('kode-program'), $this->input->post('kode-komponen'), $this->input->post('keyword'));
			
			/*	Load main template	*/
			$this->load->view('responds_subkomponen_input_',$data);
		}else{
			show_404('page');
		}		
	}
	
	function responds_add_subkomponen_input()
	{
		/* check session	*/
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			// Set aturan validasi
			$this->form_validation->set_rules('subkomponen-input','Nama sub komponen input','required|xss_clean|prep_for_form|trim|max_length[255]');
		
			if($this->form_validation->run()==TRUE){ /* Eksekusi validasi data*/
				$kode = $this->akun_kas6_model->get_max_kode($this->input->post('kode-kegiatan'), $this->input->post('kode-output'), $this->input->post('kode-komponen'));
				if($this->akun_kas6_model->add_subkomponen_input($kode, $this->input->post('subkomponen-input'),$this->input->post('kode-komponen'),$this->input->post('kode-output'),$this->input->post('kode-kegiatan'))){
					echo '<div class="correct message-correct">Data berhasil disimpan</div>';
				}else{
					echo '<div class="error message-error">Data gagal disimpan</div>';
				}
			}else{
				echo form_error('subkomponen-input','<div class="message-error error">','</div>');
			}
		}else{
			show_404('page');
		}		
	}
	
	/* Method untuk filter data subkomponen */
	function filter_akun_kas6(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$keyword 	= form_prep($this->input->post("keyword"));
			$kd_kas_4 	= form_prep($this->input->post("kd_kas_4"));
			$kd_kas_3 	= form_prep($this->input->post("kd_kas_3"));
			$kd_kas_2 	= form_prep($this->input->post("kd_kas_2"));
			$kd_kas_5 	= form_prep($this->input->post("kd_kas_5"));
			$subdata_akun_kas6['result_akun_kas6'] 	= $this->akun_kas6_model->search_akun_kas6($kd_kas_2,$kd_kas_3,$kd_kas_4,$kd_kas_5,$keyword);
			$this->load->view("akun_kas6/row_akun_kas6",$subdata_akun_kas6);
		}else{
			show_404('page');
		}	
	}
	
	/* Method untuk refresh row data subkomponen */
	function get_row_akun_kas6($kd_kas_2,$kd_kas_3,$kd_kas_4,$kd_kas_5){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$subdata_akun_kas6['result_akun_kas6'] 	= $this->akun_kas6_model->search_akun_kas6($kd_kas_2,$kd_kas_3,$kd_kas_4,$kd_kas_5);
			$this->load->view("akun_kas6/row_akun_kas6",$subdata_akun_kas6);
		}else{
			show_404('page');
		}	
	}

	function check_exist_akun_kas6($kd_kas_6,$kd_kas_5){
		$kode = $kd_kas_5.$kd_kas_6;
		$this->form_validation->set_message('check_exist_akun_kas6','Maaf, kode kas tsb sudah terdaftar.');
		//var_dump($kode);die;
		$result = $this->akun_kas6_model->get_akun_kas6(array('kd_kas_6'=>$kode));
		//var_dump($result);die;
		if(empty($result)){
			return true;
		}
		else{
			return false;
		}
	}

	
	/* Method untuk mengeksekusi tambah data subkomponen*/
	function exec_add_akun_kas6(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){

			$this->form_validation->set_rules('kd_kas_6','kd_kas_6','required|is_natural_no_zero|min_length[1]|callback_check_exist_akun_kas6['.$this->input->post("kd_kas_5").']');

			if ($this->form_validation->run()){
				$kd_kas_6 = form_prep($this->input->post('kd_kas_5').$this->input->post('kd_kas_6'));
				$data = array(
					'kd_kas_2' 	=> form_prep($this->input->post("kd_kas_2")),
					'kd_kas_3' 	=> form_prep($this->input->post("kd_kas_3")),
					'kd_kas_4' 	=> form_prep($this->input->post("kd_kas_4")),
					'kd_kas_5' 	=> form_prep($this->input->post("kd_kas_5")),
					'kd_kas_6' 	=> $kd_kas_6,
					'nm_kas_6' 	=> form_prep($this->input->post("nm_kas_6")),
                                        'nominal'       => form_prep($this->input->post("nominal_kas_6")),
					
				);
				//var_dump($kd_kas_6);die;
				$this->akun_kas6_model->add_akun_kas6($data);
					echo "berhasil";

			}
			else {
				echo validation_errors();
			}


			
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk menampilkan konfirmasi hapus data komponen input*/
	function confirmation_delete(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$data['url']		= site_url('akun_kas6/exec_delete/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7));
			$data['message']	= "Apakah anda yakin akan menghapus data ini?";
			$this->load->view('confirmation_',$data);
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk mengeksekusi hapus data komponen input */
	function exec_delete(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			if($this->uri->segment(3) && $this->uri->segment(4) && $this->uri->segment(5) && $this->uri->segment(6) && $this->uri->segment(7)){
				if($this->akun_kas6_model->delete_akun_kas6(array('kd_kas_2'=>$this->uri->segment(3),'kd_kas_3'=>$this->uri->segment(4),'kd_kas_4'=>$this->uri->segment(5),'kd_kas_5'=>$this->uri->segment(6),'kd_kas_6'=>$this->uri->segment(7)))){
					$data['class']	 = 'option box';
					$data['class_btn']	 = 'ya';
					$data['message'] = 'Data berhasil dihapus';
				}else{
					$data['class']	 = 'boxerror';
					$data['class_btn']	 = 'tidak';
					$data['message'] = 'Data gagal dihapus';
				}
			}else{
				$data['class']	 = 'boxerror';
				$data['class_btn']	 = 'tidak';
				$data['message'] = 'Tidak ada data yang dihapus';
			}
			$this->load->view('messagebox_',$data);
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk menampilkan form edit data subkomponen input */
	function get_form_edit(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$where = array(
				'kd_kas_6' 	=>form_prep($this->input->post("kd_kas_6")),
				'kd_kas_3' 		=>form_prep($this->input->post("kd_kas_3")),
				'kd_kas_2'		=>form_prep($this->input->post("kd_kas_2")),
				'kd_kas_4'		=>form_prep($this->input->post("kd_kas_4")),
				'kd_kas_5' 	=>form_prep($this->input->post("kd_kas_5")),
			);
                        
			$data['result_akun_kas6'] 	= $this->akun_kas6_model->get_akun_kas6($where);
			$this->load->view("akun_kas6/form_edit_akun_kas6",$data);
		}else{
			show_404('page');
		}	
	}
	
	/* Method untuk mengeksekusi edit data subkomponen */
	function exec_edit_akun_kas6(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$kd_kas_2 		= form_prep($this->input->post("kd_kas_2"));
			$kd_kas_3 		= form_prep($this->input->post("kd_kas_3"));
			$kd_kas_5 		= form_prep($this->input->post("kd_kas_5"));
			$kd_kas_4 		= form_prep($this->input->post("kd_kas_4"));
			$kd_kas_6 		= form_prep($this->input->post("kd_kas_6"));
			$nm_kas_6 	= form_prep($this->input->post("nm_kas_6"));
                        $nominal 	= form_prep($this->input->post("nominal"));
			$where 	= array(
				"kd_kas_3"		=> $kd_kas_3,
				"kd_kas_2"		=> $kd_kas_2,
				"kd_kas_4"		=> $kd_kas_4,
				"kd_kas_5"		=> $kd_kas_5,
				"kd_kas_6"		=> $kd_kas_6,
			/*	"biaya"	=> $biaya,
				"satuan"	=> $satuan,*/
			);
			$this->akun_kas6_model->edit_akun_kas6(array('nm_kas_6'=>$nm_kas_6,'nominal'=>$nominal),$where);
			$data['result_akun_kas6'] 	= $this->akun_kas6_model->get_akun_kas6($where);
			$this->load->view("akun_kas6/row_akun_kas6",$data);
		}else{
			show_404('page');
		}	
	}

	function get_satuan_biaya_keluaran(){

		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){

			if($this->input->post('kode_el')){
				$kode_el = $this->input->post('kode_el');
				$kode_el = explode('/', $kode_el);
				$row = $this->akun_kas6_model->get_single_subkomponen_ref_akun(array('kode_kegiatan'=>$kode_el[0],'kd_kas_3'=>$kode_el[1],'kode_program'=>$kode_el[2],'kode_komponen'=>$kode_el[3],'kode_subkomponen'=>$kode_el[4])) ;

				echo json_encode($row);
			}

		}
		else{
			show_404('page');

		}

	}
        
        function get_total_kas(){
            echo $this->kas_undip_model->get_total_kas();
        }
        
        function get_nominal(){
            if($this->input->post()){
                $this->load->model('kas_undip_model');
                echo $this->kas_undip_model->get_nominal($this->input->post('kd_akun_kas'));
            }
        }
        
        function tambah_nominal(){
            if($this->input->post()){
                $this->load->model('kas_undip_model');
                $kd_akun_kas = $this->input->post('kd_akun_kas') ;
                $nominal = $this->input->post('nominal') ;
                $saldo = $nominal + $this->kas_undip_model->get_nominal($kd_akun_kas);
                
            $data = array(
                'tgl_trx' => date('Y-m-d H:i:s'),
                'kd_akun_kas' => $kd_akun_kas,
                'kd_unit' => '99',
                'deskripsi' => 'ISI SALDO ' . $kd_akun_kas,
                'no_spm' => '-',
                'debet' => $nominal,
                'kredit' => '0',
                'saldo' => $saldo,
                'aktif' => '1',
                'tahun' => $this->cur_tahun,
            );
                if($this->kas_undip_model->isi_trx($data)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Tambah saldo berhasil.</div>');
                    echo 'sukses';
                }else{
                    echo 'gagal';
                }
            }
        }
}
?>