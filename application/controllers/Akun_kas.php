<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Ref_akun extends CI_Controller{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model(array('akun_kas_model','menu_model'));
	}
	
/* -------------- Method ------------- */
	function index()
	{
		show_404('page');
	}
	
	/* Method untuk menampilkan daftar program*/
	function daftar_akun_kas()
	{
		/* check session	*/
		if($this->check_session->user_session() && $this->check_session->get_level()==100){
			/*	Set data untuk main template */
			$data['main_menu']= $this->load->view('main_menu','',TRUE);	
			$tahun = $this->setting_model->get_tahun();
			$subdata['cur_tahun'] = $tahun;
			$subdata_akun["result_akun_kas"] = $this->akun_kas_model->get_akun_kas();
			$subdata["row_akun_kas"]	= $this->load->view("akun_kas2/row_akun_kas",$subdata_akun,TRUE);
			$data['main_content'] 		= $this->load->view("akun_kas1/daftar_akun_kas",$subdata,TRUE);
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
	}

	

	function search_ref_akun()
	{
		/* check session	*/
		// if($this->check_session->user_session() && ($this->check_session->get_level()==2 || $this->check_session->get_level()==3)){
		if($this->check_session->get_level()==31){
			$subdata['data_row']= $this->ref_akun_model->search_ref_akun();
			$data['ref_akun'] 	= $this->load->view('responds_ref_akun',$subdata,True);
			
			/*	Load main template	*/
			$this->load->view('search_ref_akun_',$data);
		}else{
			show_404('page');
		}		
	}
	
	function responds_ref_akun()
	{
		/* check session	*/
		// if($this->check_session->user_session() && ($this->check_session->get_level()==2 || $this->check_session->get_level()==3)){
		if($this->check_session->get_level()==31){
			$data['data_ref_iku'] = $this->ref_akun_model->search_ref_akun($this->input->post('keyword'));
			
			/*	Load main template	*/
			$this->load->view('responds_ref_akun',$data);
		}else{
			show_404('page');
		}		
	}
	
	/* Method untuk filter data iku */
	function filter_ref_akun(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==1 || $this->check_session->get_level()==2)){
			$keyword = form_prep($this->input->post("keyword"));
			$data['result_ref_akun'] = $this->ref_akun_model->search_ref_akun($keyword);
			$this->load->view("row_ref_akun",$data);
		}else{
			show_404('page');
		}
	}

	
	/* Method untuk refresh row data Ref Iku */
	function get_row_ref_akun(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==1 || $this->check_session->get_level()==2)){
			$data['result_ref_akun'] = $this->ref_akun_model->get_ref_akun();
			$this->load->view("row_ref_akun",$data);
		}else{
			show_404('page');
		}
	}


	function check_exist_ref_akun($kode_akun_sub,$kode){

		//$kode = explode(',', $kode_);
		//var_dump($kode);die;
		$this->form_validation->set_message('check_exist_ref_akun','Maaf, kode Akun tsb sudah terdaftar di tabel biaya.');
		$result = $this->ref_akun_model->get_ref_akun_valid(array('kode_akun'=>$kode,'kode_akun_sub'=>$kode_akun_sub));
		if(empty($result)){
			return true;
		}
		else{
			return false;
		}

	}
	
	/* Method untuk mengeksekusi tambah data ref akun*/
	function exec_add_ref_akun(){
		if($this->check_session->user_session() && $this->check_session->get_level()==1){
			$this->form_validation->set_rules('kode_akun_sub','kode_akun_sub','required|is_natural_no_zero|callback_check_exist_ref_akun['.$this->input->post("kode_akun").']');			
			if ($this->form_validation->run()){
				$data = array(
					'kode_akun' => form_prep($this->input->post("kode_akun")),
					'nama_akun' 	=> form_prep($this->input->post("nama_akun")),
					'kode_akun_sub' => form_prep($this->input->post("kode_akun_sub")),
					'nama_akun_sub' => form_prep($this->input->post("nama_akun_sub")),
				);
				$this->ref_akun_model->add_ref_akun($data);
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
		if($this->check_session->user_session() && $this->check_session->get_level()==1){
			$data['url']		= site_url('ref_akun/exec_delete/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
			$data['message']	= "Apakah anda yakin akan menghapus data ini?";
			$this->load->view('confirmation_',$data);
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk mengeksekusi hapus data komponen input */
	function exec_delete(){
		if($this->check_session->user_session() && $this->check_session->get_level()==1){
			if($this->uri->segment(3) && $this->uri->segment(4)){
				if($this->ref_akun_model->delete_ref_akun(array('kode_akun_sub'=>$this->uri->segment(3),'kode_akun'=>$this->uri->segment(4)))){
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
	
	/*function get_form_edit(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==1 || $this->check_session->get_level()==2)){
			$kd_inc 			= form_prep($this->input->post("kd_inc"));
			$kode_kegiatan 	= form_prep($this->input->post("kode_kegiatan"));
			$data['result_ref_iku'] 	= $this->ref_iku_model->get_ref_iku_edit($kd_inc);
			$data['opt_kegiatan']		= $this->option->opt_kegiatan();
			//$data["result_output"]	= $this->output_model->get_all_output(array('kode_kegiatan'=>$kode_kegiatan));
			//var_dump($data);die;
			//$data["result_output"]	= array();
			$this->load->view('form_edit_ref_iku',$data);
		}else{
			show_404('page');
		}
	} */
	function get_form_edit(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==1 || $this->check_session->get_level()==2)){
			
			//if ($this->form_validation->run()){
					$kode_akun_sub				= form_prep($this->input->post("kode_akun_sub"));
					
					$data['result_ref_akun'] 	= $this->ref_akun_model->get_ref_akun_valid(array('kode_akun_sub'=>$kode_akun_sub));
					//var_dump($data);die;
					$this->load->view('form_edit_ref_akun',$data);
			
		}else{
			show_404('page');
		}
	}
	
	
	function exec_edit_ref_akun(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==1 || $this->check_session->get_level()==2)){
                    
                    $kode_akun_sub = $this->input->post('kode_akun_sub');
                    $kode_akun_sub_before = $this->input->post('kode_akun_sub_before');
                        
                    if($kode_akun_sub != $kode_akun_sub_before){
                        $this->form_validation->set_rules('kode_akun_sub','kode_akun_sub','required|is_natural_no_zero|callback_check_exist_ref_akun['.$this->input->post("kode_akun").']');			

                    }

                    $this->form_validation->set_rules('nama_akun','Nama Akun','required');
                    $this->form_validation->set_rules('nama_akun_sub','Nama Akun Sub','required');
			
                    if ($this->form_validation->run()){
					$kode_akun 		= form_prep($this->input->post("kode_akun"));
					$nama_akun 		= form_prep($this->input->post("nama_akun"));
					$kode_akun_sub 	= form_prep($this->input->post("kode_akun_sub"));
					$nama_akun_sub 	= form_prep($this->input->post("nama_akun_sub"));
					
					$data_edit = array(
						'kode_akun' => $kode_akun,
						'nama_akun' => $nama_akun,
						'kode_akun_sub' => $kode_akun_sub,
						'nama_akun_sub' => $nama_akun_sub,
					);
//                                        var_dump($data_edit);die;
					$this->ref_akun_model->edit_ref_akun($data_edit,$kode_akun_sub_before);
//					$data['result_ref_akun'] 	= $this->ref_akun_model->get_ref_akun($kode_akun_sub);
//					//var_dump($data);die;
//					$this->load->view('row_ref_akun',$data);
                    }
			else {
                            echo validation_errors();
			}
		
		}else{
			show_404('page');
		}
	}
}
?>