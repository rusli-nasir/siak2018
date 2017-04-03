<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Akun_kas4 extends CI_Controller{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model(array('akun_kas4_model','akun_kas3_model','akun_kas2_model','menu_model'));
	}
	
/* -------------- Method ------------- */
	function index()
	{
		show_404('page');
	}
	
	/* Method untuk menampilkan daftar program*/
	function daftar_akun_kas4($kd_kas_2,$kd_kas_3)
	{
		/* check session	*/
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);	
			$tahun = $this->setting_model->get_tahun();
			$subdata['cur_tahun'] = $tahun;
			$subdata_akun_kas4["result_akun_kas4"] = $this->akun_kas4_model->search_akun_kas4($kd_kas_2,$kd_kas_3);
			$subdata["row_akun_kas4"]	= $this->load->view("akun_kas4/row_akun_kas4",$subdata_akun_kas4,TRUE);
			$subdata["result_akun_kas2"]	= $this->akun_kas2_model->get_akun_kas2($kd_kas_2);
			$subdata["result_akun_kas3"]	= $this->akun_kas3_model->get_akun_kas3(array('kd_kas_3'=>$kd_kas_3,'kd_kas_2'=>$kd_kas_2));
			$data["main_content"]		= $this->load->view("akun_kas4/daftar_akun_kas4",$subdata,TRUE);
			
			/*	Load main template	*/
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
	}	

	function search_akun_kas4()
	{
		/* check session	*/
		// if($this->check_session->user_session() && ($this->check_session->get_level()==2 || $this->check_session->get_level()==3)){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$subdata['data_row']= $this->akun_kas4_model->search_akun_kas4($this->uri->segment(3),$this->uri->segment(4));
			$subdata['kode']  = array(
									'kd_kas_2' => $this->uri->segment(3),
									'kd_kas_3' => $this->uri->segment(4)
								);
			$data['akun_kas4'] 	= $this->load->view('akun_kas4/responds_akun_kas4',$subdata,True);
			
			/*	Load main template	*/
			$this->load->view('search_akun_kas4_',$data);
		}else{
			show_404('page');
		}		
	}
	
	function responds_program()
	{
		/* check session	*/
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$data['data_row'] = $this->akun_kas4_model->search_akun_kas4($this->input->post('kode-kegiatan'), $this->input->post('kode-output'), $this->input->post('keyword'));
			
			/*	Load main template	*/
			$this->load->view('responds_program_',$data);
		}else{
			show_404('page');
		}		
	}
	
	/* Method untuk filter data komponen */
	function filter_akun_kas4(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$keyword 	= form_prep($this->input->post("keyword"));
			$kd_kas_3 	= form_prep($this->input->post("kd_kas_3"));
			$kd_kas_2 	= form_prep($this->input->post("kd_kas_2"));
			$subdata_akun_kas4['result_akun_kas4'] 	= $this->akun_kas4_model->search_akun_kas4($kd_kas_2,$kd_kas_3,$keyword);
			$this->load->view("akun_kas4/row_akun_kas4",$subdata_akun_kas4);
		}else{
			show_404('page');
		}	
	}
	
	/* Method untuk refresh row data program */
	function get_row_akun_kas4($kd_kas_2,$kd_kas_3){
		//var_dump($kode-kegiatan);die;
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$subdata_akun_kas4['result_akun_kas4'] 	= $this->akun_kas4_model->search_akun_kas4($kd_kas_2,$kd_kas_3);
			$this->load->view("akun_kas4/row_akun_kas4",$subdata_akun_kas4);
		}else{
			show_404('page');
		}	
	}


	function check_exist_akun_kas4($kd_kas_4,$kd_kas_3){

		$kode = $kd_kas_3.$kd_kas_4;

		$this->form_validation->set_message('check_exist_akun_kas4','Maaf, kode Kas 4 tsb sudah terdaftar.');

		$result = $this->akun_kas4_model->get_akun_kas4(array('kd_kas_4'=>$kode));
		//var_dump($kode);die;
		if(empty($result)){
			return true;
		}
		else{
			return false;
		}

	}
	
	/* Method untuk mengeksekusi tambah data program*/
	function exec_add_akun_kas4(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$kd_kas_4 = form_prep($this->input->post('kd_kas_3').$this->input->post('kd_kas_4'));
			$this->form_validation->set_rules('kd_kas_4','Kode Kas 4','required|is_natural_no_zero|min_length[1]|callback_check_exist_akun_kas4['.$this->input->post("kd_kas_3").']');			

			if ($this->form_validation->run()){
					$kd_kas_4 = form_prep($this->input->post('kd_kas_3').$this->input->post('kd_kas_4'));
				$data = array(
					'kd_kas_2' => form_prep($this->input->post("kd_kas_2")),
					'kd_kas_3' 	=> form_prep($this->input->post("kd_kas_3")),
					'kd_kas_4' => $kd_kas_4,
					'nm_kas_4' => form_prep($this->input->post("nm_kas_4")),
				
				);
				$this->akun_kas4_model->add_akun_kas4($data);
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
			$data['url']		= site_url('akun_kas4/exec_delete/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5));
			$data['message']	= "Apakah anda yakin akan menghapus data ini?";
			$this->load->view('confirmation_',$data);
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk mengeksekusi hapus data komponen input */
	function exec_delete(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			if($this->uri->segment(3) && $this->uri->segment(4) && $this->uri->segment(5)){
                                if($this->akun_kas4_model->delete_akun_kas4(array('kd_kas_2'=>$this->uri->segment(3),'kd_kas_3'=>$this->uri->segment(4),'kd_kas_4'=>$this->uri->segment(5)))){
//				if($this->akun_kas4_model->delete_program(array('kode_kegiatan'=>$this->uri->segment(3),'kode_output'=>$this->uri->segment(4),'kode_program'=>$this->uri->segment(5)))){
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
        
        /* Method untuk menampilkan form edit data output */
	function get_form_edit(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$kd_kas_4 			= form_prep($this->input->post("kd_kas_4"));
                        $kd_kas_3 			= form_prep($this->input->post("kd_kas_3"));
			$kd_kas_2 			= form_prep($this->input->post("kd_kas_2"));
			$data['result_akun_kas4'] 	= $this->akun_kas4_model->get_akun_kas4(array("kd_kas_4"=>$kd_kas_4,"kd_kas_3"=>$kd_kas_3,"kd_kas_2"=>$kd_kas_2));
			$this->load->view('akun_kas4/form_edit_akun_kas4',$data);
		}else{
			show_404('page');
		}	
	}
	
	/* Method untuk menampilkan form edit data komponen input */
//	function get_form_edit(){
//		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
//			$where = array(
//				'kd_kas_3' 	=>form_prep($this->input->post("kd_kas_3")),
//				'kd_kas_2'	=>form_prep($this->input->post("kd_kas_2")),
//				'kd_kas_4' =>form_prep($this->input->post("kd_kas_4")),
//			);
//			$data['result_akun_kas4'] 	= $this->akun_kas4_model->get_single_akun_kas4($where,$field);
//			//var_dump($data);die;
//			$this->load->view("akun_kas4/form_edit_akun_kas4",$data);
//		}else{
//			show_404('page');
//		}	
//	}
	
	/* Method untuk mengeksekusi edit data komponen */
	function exec_edit_akun_kas4(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$kd_kas_2 	= form_prep($this->input->post("kd_kas_2"));
			$kd_kas_3 	= form_prep($this->input->post("kd_kas_3"));
			$kd_kas_4 	= form_prep($this->input->post("kd_kas_4"));
			$nm_kas_4 	= form_prep($this->input->post("nm_kas_4"));
			//$bidang 		= form_prep($this->input->post("bidang"));
			$where 	= array(
				"kd_kas_3"	=> $kd_kas_3,
				"kd_kas_2"	=> $kd_kas_2,
				"kd_kas_4"	=> $kd_kas_4,
				"nm_kas_4"=>$nm_kas_4,
				
			);
			$this->akun_kas4_model->edit_akun_kas4(array('nm_kas_4'=>$nm_kas_4),$where);
			$data['result_akun_kas4'] 	= $this->akun_kas4_model->get_akun_kas4($where);
			$this->load->view("akun_kas4/row_akun_kas4",$data);
		}else{
			show_404('page');
		}	
	}
}
?>