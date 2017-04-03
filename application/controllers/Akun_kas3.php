<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Akun_kas3 extends CI_Controller{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model(array('akun_kas3_model','akun_kas2_model','menu_model'));
	}
	
/* -------------- Method ------------- */
	function index()
	{
		show_404('page');
	}
	
	/* Method untuk menampilkan daftar data output */
	function daftar_akun_kas3($kd_akun_kas2){
		/* check session	*/
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
			$tahun = $this->setting_model->get_tahun();
			$subdata['cur_tahun'] = $tahun;
			$subdata_akun_kas3['result_akun_kas3'] 	= $this->akun_kas3_model->search_akun_kas3($kd_akun_kas2);
			$subdata['row_akun_kas3']				= $this->load->view("akun_kas3/row_akun_kas3",$subdata_akun_kas3,TRUE);
			$subdata['result_akun_kas2']			= $this->akun_kas2_model->get_akun_kas2($kd_akun_kas2);
			$data['main_content']					= $this->load->view("akun_kas3/daftar_akun_kas3",$subdata,TRUE);
			//var_dump($subdata);die;
			///*	Load main template	*/
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
	}
	
	function search_akun_kas3(){
		/* check session	*/
		// if($this->check_session->user_session() && ($this->check_session->get_level()==2 || $this->check_session->get_level()==3)){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$subdata['data_row'] = $this->akun_kas3_model->search_akun_kas3($this->uri->segment(3));
			$subdata['kode']  = array(
									'kd_akun_kas2' => $this->uri->segment(3)
								);
			$data['akun_kas3'] 	= $this->load->view('akun_kas3/responds_akun_kas3',$subdata,True);
			
			/*	Load main template	*/
			$this->load->view('akun_kas3/search_akun_kas3',$data);
		}else{
			show_404('page');
		}		
	}
	
	function responds_akun_kas3(){
		/* check session	*/
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$data['data_row'] = $this->akun_kas3_model->search_akun_kas3($this->input->post('kd_akun_kas2'),$this->input->post('keyword'));

			var_dump($data);die;
			
			/*	Load main template	*/
			$this->load->view('responds_akun_kas3',$data);
		}else{
			show_404('page');
		}		
	}

	
	
	/* Method untuk mengeksekusi tambah data output*/
	function exec_add_akun_kas3(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			//$kd_kas_3 = form_prep($this->input->post('kd_kas_2').$this->input->post('kd_kas_3'));
			$this->form_validation->set_rules('kd_kas_3','Kode KAS 3','required|is_natural_no_zero|min_length[1]|callback_check_exist_akun_kas3['.$this->input->post("kd_kas_2").']');		

			if ($this->form_validation->run()){
					$kd_kas_3 = form_prep($this->input->post('kd_kas_2').$this->input->post('kd_kas_3'));
				$data = array(
					'kd_kas_2' => form_prep($this->input->post("kd_kas_2")),
					'kd_kas_3' => $kd_kas_3,
					'nm_kas_3' => form_prep($this->input->post("nm_kas_3")),
				);
				$this->akun_kas3_model->add_akun_kas3($data);
				//var_dump($data);
				echo "berhasil";

			}
			else {
				echo validation_errors();
			}

			
		}else{
			show_404('page');
		}
	}
	function check_exist_akun_kas3($kd_kas_3,$kd_kas_2){

		$this->form_validation->set_message('check_exist_akun_kas3','Maaf, kode Kas 3 tsb sudah terdaftar.');
		$kode=$kd_kas_2.$kd_kas_3;
		//var_dump($kode);die;
		$result = $this->akun_kas3_model->get_akun_kas3(array('kd_kas_3'=>$kode));
		//var_dump($result);die;
		if(empty($result)){
			return true;
		}
		else{
			return false;
		}

	}
	
	/* Method untuk menampilkan form edit data output */
	function get_form_edit(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$kd_kas_3 			= form_prep($this->input->post("kd_kas_3"));
			$kd_kas_2 			= form_prep($this->input->post("kd_kas_2"));
			$data['result_akun_kas3'] 	= $this->akun_kas3_model->get_akun_kas3(array("kd_kas_3"=>$kd_kas_3,"kd_kas_2"=>$kd_kas_2));
			$this->load->view('akun_kas3/form_edit_akun_kas3',$data);
		}else{
			show_404('page');
		}	
	}
	
	/* Method untuk mengeksekusi edit data output */
	function exec_edit_akun_kas3(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$kd_kas_2 	= form_prep($this->input->post("kd_kas_2"));
			$kd_kas_3 	= form_prep($this->input->post("kd_kas_3"));
			$nm_kas_3 	= form_prep($this->input->post("nm_kas_3"));
			$where 	= array(
				"kd_kas_3"	=> $kd_kas_3,
				"kd_kas_2"	=> $kd_kas_2,
			);
			$this->akun_kas3_model->edit_akun_kas3(array('nm_kas_3'=>$nm_kas_3),$where);
			$data['result_akun_kas3'] 	= $this->akun_kas3_model->get_akun_kas3($where);
			$this->load->view("akun_kas3/row_akun_kas3",$data);
		}else{
			show_404('page');
		}	
	}
	
	/* Method untuk menampilkan konfirmasi hapus data output*/
	function confirmation_delete(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$data['url']		= site_url('akun_kas3/exec_delete/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
			$data['message']	= "Apakah anda yakin akan menghapus data ini?";
			$this->load->view('confirmation_',$data);
		}else{
			show_404('page');
		}	
	}
	
	/* Method untuk mengeksekusi hapus data output */
	function exec_delete(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			if($this->uri->segment(3) && $this->uri->segment(4)){
				if($this->akun_kas3_model->delete_akun_kas3(array('kd_kas_2'=>$this->uri->segment(3),'kd_kas_3'=>$this->uri->segment(4)))){
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
	
	/* Method untuk filter data output */
	function filter_akun_kas3(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$keyword 		= form_prep($this->input->post("keyword"));
			$kd_kas_2 	= form_prep($this->input->post("kd_kas_2"));
			$subdata_akun_kas3['result_akun_kas3'] 	= $this->akun_kas3_model->search_akun_kas3($kd_kas_2,$keyword);
			$this->load->view("akun_kas3/row_akun_kas3",$subdata_akun_kas3);
		}else{
			show_404('page');
		}	
	}
	
	/* Method untuk refresh row data output */
	function get_row_akun_kas3($kd_kas_2){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$subdata_akun_kas3['result_akun_kas3'] 	= $this->akun_kas3_model->search_akun_kas3($kd_kas_2);
			$this->load->view("akun_kas3/row_akun_kas3",$subdata_akun_kas3);
		}else{
			show_404('page');
		}	
	}
}
?>