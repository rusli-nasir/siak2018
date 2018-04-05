<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Akun_kas2 extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


    public function __construct()
    {
            parent::__construct();
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation'));
		$this->load->helper('vayes_helper');
		$this->load->helper('form');
		$this->load->model(array('akun_kas2_model'));
	}
	
/* -------------- Method ------------- */
	function index()
	{
		show_404('page');
	}
	
	function daftar_akun_kas2($kode_akun1digit)
	{
		/* check session	*/
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			/*	Set data untuk main template */
			$data['user_menu']								= $this->load->view('user_menu','',TRUE);
			$data['main_menu']								= $this->load->view('main_menu','',TRUE);		
			$tahun = $this->setting_model->get_tahun();
			$subdata['cur_tahun'] 							= $tahun;
			$subdata_akun_kas2['result_akun_kas2'] 	= $this->akun_kas2_model->get_akun_kas2($kode_akun1digit);
			// vdebug($subdata_akun_kas2);
			$subdata['row_akun_kas2'] 						= $this->load->view("akun_kas2/row_akun_kas2",$subdata_akun_kas2,TRUE);
			$subdata['result_akun_kas']					= $this->akun_kas2_model->get_akun_sebelum($kode_akun1digit);
			$data['main_content'] 							= $this->load->view("akun_kas2/daftar_akun_kas2",$subdata,TRUE);
			//$data['breadcrumb']	= $this->load->view('breadcrumb_',array('list'=>array(array('Kas 2','class="current"'))),TRUE);
			/*	Load main template	*/
			//var_dump($subdata);die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
	}
	
	function search_akun_kas2()
	{
		/* check session	*/
		// if($this->check_session->user_session() && ($this->check_session->get_level()==2 || $this->check_session->get_level()==3)){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$subdata['data_row'] 	= $this->akun_kas2_model->search_akun_kas2();
			$data['akun_kas2'] 		= $this->load->view('akun_kas2/responds_akun_kas2',$subdata,True);
			
			/*	Load main template	*/
			$this->load->view('akun_kas2/search_akun_kas2',$data);
		}else{
			show_404('page');
		}		
	}
	
	function responds_kegiatan()
	{
		/* check session	*/
		// if($this->check_session->user_session() && ($this->check_session->get_level()==2 || $this->check_session->get_level()==3)){
		if($this->check_session->get_level()==31){
			$data['data_row'] = $this->kegiatan_model->search_kegiatan($this->input->post('keyword'));
			
			/*	Load main template	*/
			$this->load->view('responds_kegiatan_',$data);
		}else{
			show_404('page');
		}		
	}

	// function get_row_i_kegiatan()
	// {
	// 	/* check session	*/
	// 	// if($this->check_session->user_session() && ($this->check_session->get_level()==2 || $this->check_session->get_level()==3)){
	// 	if($this->check_session->get_level()==31){
	// 		$subdata['data_row'] 	= $this->kegiatan_model->search_kegiatan();
	// 		 $this->load->view('responds_kegiatan_',$subdata);
			
	// 		/*	Load main template	*/
	// 		//$this->load->view('search_kegiatan_',$data);
	// 	}else{
	// 		show_404('page');
	// 	}		
	// }

	
	/* Method untuk mengeksekusi tambah data kegiatan */
	function check_exist_akun_kas2($kd_kas_2){

		$this->form_validation->set_message('check_exist_akun_kas2','Maaf, kode tsb sudah terdaftar.');

		$result = $this->akun_kas2_model->get_akun_kas2($kd_kas_2);

		if(empty($result)){
			return true;
		}
		else{
			return false;
		}

	}

	function exec_add_akun_kas2(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){

			$this->form_validation->set_rules('kd_kas_2','kd_kas_2','required|is_natural_no_zero|min_length[2]|callback_check_exist_akun_kas2');

			$this->form_validation->set_message('is_unique', 'Maaf, {field} sudah terdaftar');

			if ($this->form_validation->run()){
				$data = array(
					"kd_kas_2" => $this->input->post("kd_kas_2"),
					"nm_kas_2" => $this->input->post("nm_kas_2"),
				);
				$this->akun_kas2_model->add_akun_kas2($data);
				echo "berhasil";

			}
			else {
				echo validation_errors();
			}

			
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk menampilkan form edit data kegiatan */
	function get_form_edit(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$kd_kas_2 				= form_prep($this->input->post("kd_kas_2"));
			$data['result_akun_kas2'] 	= $this->akun_kas2_model->get_akun_kas2($kd_kas_2);
			$this->load->view('akun_kas2/form_edit_akun_kas2',$data);
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk mengeksekusi edit data kegiatan */
	function exec_edit_akun_kas2(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$kd_kas_2 = form_prep($this->input->post("kd_kas_2"));
			$nm_kas_2 = form_prep($this->input->post("nm_kas_2"));
			$data_edit = array(
				'nm_kas_2' => $nm_kas_2,
			);
			$this->akun_kas2_model->edit_akun_kas2($data_edit,$kd_kas_2);
			$data["result_akun_kas2"] = $this->akun_kas2_model->get_akun_kas2($kd_kas_2);
			$this->load->view('akun_kas2/row_akun_kas2',$data);
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk menampilkan konfirmasi hapus data kegiatan*/
	function confirmation_delete(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$data['url']		= site_url('akun_kas2/exec_delete/'.$this->uri->segment(3));
			$data['message']	= "Apakah anda yakin akan menghapus data ini ( kode : ".$this->uri->segment(3).") ?";
			$this->load->view('confirmation_',$data);
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk mengeksekusi hapus data kegiatan */
	function exec_delete(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			if($this->uri->segment(3)){
				if($this->akun_kas2_model->delete_akun_kas2($this->uri->segment(3))){
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
	
	/* Method untuk refresh row data kegiatan */
	function get_row_akun_kas2(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$data['result_akun_kas2'] = $this->akun_kas2_model->get_akun_kas2();
			$this->load->view("akun_kas2/row_akun_kas2",$data);
		}else{
			show_404('page');
		}
	}
	
	/* Method untuk filter data kegiatan */
	function filter_akun_kas2(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)){
			$keyword = form_prep($this->input->post("keyword"));
			$data['result_akun_kas2'] = $this->akun_kas2_model->search_akun_kas2($keyword);
			$this->load->view("akun_kas2/row_akun_kas2",$data);
		}else{
			show_404('page');
		}
	}
}
?>