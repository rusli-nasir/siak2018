<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Akun_kas5 extends CI_Controller{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model(array('akun_kas5_model','akun_kas4_model','akun_kas3_model','akun_kas2_model','menu_model'));
	}
	
/* -------------- Method ------------- */
	function index()
	{
		show_404('page');
	}
	
	/* Method untuk menampilkan daftar komponen input*/
	function daftar_akun_kas5($kd_kas_2,$kd_kas_3,$kd_kas_4)
	{
		/* check session	*/
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);	
			$tahun = $this->setting_model->get_tahun();
			$subdata['cur_tahun'] = $tahun;
			$subdata_akun_kas5["result_akun_kas5"] = $this->akun_kas5_model->search_akun_kas5($kd_kas_2,$kd_kas_3,$kd_kas_4);
			$subdata["row_akun_kas5"]	= $this->load->view("akun_kas5/row_akun_kas5",$subdata_akun_kas5,TRUE);
			$subdata["result_akun_kas2"]	= $this->akun_kas2_model->get_akun_kas2($kd_kas_2);
			$subdata["result_akun_kas3"]	= $this->akun_kas3_model->get_akun_kas3(array('kd_kas_3'=>$kd_kas_3,'kd_kas_2'=>$kd_kas_2));
			$subdata["result_akun_kas4"]	= $this->akun_kas4_model->get_akun_kas4(array('kd_kas_4'=>$kd_kas_4,'kd_kas_3'=>$kd_kas_3,'kd_kas_2'=>$kd_kas_2));

			$data["main_content"]			= $this->load->view("akun_kas5/daftar_akun_kas5",$subdata,TRUE);
			
			/*	Load main template	*/
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
	}
	
	function search_akun_kas5()
	{
		/* check session	*/
		// if($this->check_session->user_session() && ($this->check_session->get_level()==2 || $this->check_session->get_level()==3)){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$subdata['data_row']= $this->komponen_input_model->search_komponen_input($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5));
			$subdata['kode']  = array(
									'kode-kegiatan' => $this->uri->segment(3),
									'kode-output' => $this->uri->segment(4),
									'kode-program' => $this->uri->segment(5),
								);
			$data['komponen_input'] 	= $this->load->view('responds_komponen_input_',$subdata,True);

			// echo'</pre>'; var_dump($data);echo'</pre>';die;
			
			/*	Load main template	*/
			$this->load->view('search_komponen_input_',$data);
		}else{
			show_404('page');
		}		
	}
	
	function responds_akun_kas5()
	{
		/* check session	*/
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$data['data_row'] = $this->komponen_input_model->search_komponen_input($this->input->post('kode-kegiatan'), $this->input->post('kode-output'), $this->input->post('kode-program'), $this->input->post('keyword'));
			
			/*	Load main template	*/
			$this->load->view('responds_komponen_input_',$data);
		}else{
			show_404('page');
		}		
	}
	
	/* Method untuk filter data komponen */
	function filter_akun_kas5(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$keyword 	= form_prep($this->input->post("keyword"));
			$kd_kas_4 	= form_prep($this->input->post("kd_kas_4"));
			$kd_kas_3 	= form_prep($this->input->post("kd_kas_3"));
			$kd_kas_2 	= form_prep($this->input->post("kd_kas_2"));
			$subdata_akun_kas5['result_akun_kas5'] 	= $this->akun_kas5_model->search_akun_kas5($kd_kas_2,$kd_kas_3,$kd_kas_4,$keyword);
			$this->load->view("akun_kas5/row_akun_kas5",$subdata_akun_kas5);
		}else{
			show_404('page');
		}	
	}
	
	/* Method untuk refresh row data komponen */
	function get_row_akun_kas5($kd_kas_2,$kd_kas_3,$kd_kas_4){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$subdata_akun_kas5['result_akun_kas5'] 	= $this->akun_kas5_model->search_akun_kas5($kd_kas_2,$kd_kas_3,$kd_kas_4);
			$this->load->view("akun_kas5/row_akun_kas5",$subdata_akun_kas5);
		}else{
			show_404('page');
		}	
	}
	
	function check_exist_akun_kas5($kd_kas_5,$kd_kas_4){

		$kode = $kd_kas_4.$kd_kas_5;

		$this->form_validation->set_message('check_exist_akun_kas5','Maaf, kode Kas tsb sudah terdaftar.');

		$result = $this->akun_kas5_model->get_akun_kas5(array('kd_kas_5'=>$kode));

		if(empty($result)){
			return true;
		}
		else{
			return false;
		}

	}

	/* Method untuk mengeksekusi tambah data komponen*/
	function exec_add_akun_kas5(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){

			$this->form_validation->set_rules('kd_kas_5','Kode kas 5','required|is_natural_no_zero|min_length[1]|callback_check_exist_akun_kas5['.$this->input->post("kd_kas_4").']');
			if ($this->form_validation->run()){
				$kd_kas_5 = form_prep($this->input->post('kd_kas_4').$this->input->post('kd_kas_5'));
				$data = array(
					'kd_kas_2' => form_prep($this->input->post("kd_kas_2")),
					'kd_kas_3' 	=> form_prep($this->input->post("kd_kas_3")),
					'kd_kas_4' 	=> form_prep($this->input->post("kd_kas_4")),
					'kd_kas_5' => $kd_kas_5,
					'nm_kas_5' => form_prep($this->input->post("nm_kas_5")),
//					'nominal' => form_prep($this->input->post("nominal_kas_5")),
                                        'nominal' => '',
				);
				
				$this->akun_kas5_model->add_akun_kas5($data);
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
			$data['url']		= site_url('akun_kas5/exec_delete/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6));
			$data['message']	= "Apakah anda yakin akan menghapus data ini?";
			$this->load->view('confirmation_',$data);
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk mengeksekusi hapus data komponen input */
	function exec_delete(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			if($this->uri->segment(3) && $this->uri->segment(4) && $this->uri->segment(5) && $this->uri->segment(6)){
				if($this->akun_kas5_model->delete_akun_kas5(array('kd_kas_2'=>$this->uri->segment(3),'kd_kas_3'=>$this->uri->segment(4),'kd_kas_4'=>$this->uri->segment(5),'kd_kas_5'=>$this->uri->segment(6)))){
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
	
	/* Method untuk menampilkan form edit data komponen input */
	function get_form_edit(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$where = array(
				'kd_kas_4' 	=>form_prep($this->input->post("kd_kas_4")),
				'kd_kas_3' 		=>form_prep($this->input->post("kd_kas_3")),
				'kd_kas_2'		=>form_prep($this->input->post("kd_kas_2")),
				'kd_kas_5' 		=>form_prep($this->input->post("kd_kas_5")),
			);
			$data['result_akun_kas5'] 	= $this->akun_kas5_model->get_akun_kas5($where);
			$this->load->view("akun_kas5/form_edit_akun_kas5",$data);
		}else{
			show_404('page');
		}	
	}
	
	/* Method untuk mengeksekusi edit data komponen */
	function exec_edit_akun_kas5(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$kd_kas_2 	= form_prep($this->input->post("kd_kas_2"));
			$kd_kas_3 	= form_prep($this->input->post("kd_kas_3"));
			$kd_kas_4 	= form_prep($this->input->post("kd_kas_4"));
			$kd_kas_5 	= form_prep($this->input->post("kd_kas_5"));
			$nm_kas_5 	= form_prep($this->input->post("nm_kas_5"));
//			$nominal 	= form_prep($this->input->post("nominal"));
                        $nominal        = '';
			$where 	= array(
				"kd_kas_4"	=> $kd_kas_4,
				"kd_kas_3"	=> $kd_kas_3,
				"kd_kas_2"	=> $kd_kas_2,
				"kd_kas_5"	=> $kd_kas_5,
			);
			$this->akun_kas5_model->edit_akun_kas5(array('nm_kas_5'=>$nm_kas_5,'nominal'=>$nominal),$where);
			$data['result_akun_kas5'] 	= $this->akun_kas5_model->get_akun_kas5($where);
			$this->load->view("akun_kas5/row_akun_kas5",$data);
		}else{
			show_404('page');
		}	
	}
}
?>