<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Setting extends CI_Controller {

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
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model('setting_model');
		$this->load->model('menu_model');
	}
	
/* -------------- Method ------------- */
	function index()
	{
		show_404('page');
	}
	
	function tahun(){
		if ($this->check_session->user_session() && $this->check_session->get_level()==11){
			if($this->input->post('tahun')){
				$this->form_validation->set_rules('tahun','Tahun','required|integer');
				if($this->form_validation->run()==true){
					$tahun_baru = form_prep($this->input->post('tahun'));

					// EDIT BY ALAIK 
					//$this->setting_model->edit_tahun($tahun_baru);
					$this->setting_model->ubah_tahun($tahun_baru);

					// END 
					
					

					$subdata['message']= '<div class="alert alert-success" style="text-align:center">Tahun berhasil diubah</div>';
				}
			}

			$tahun = $this->setting_model->get_tahun();

			if(!$tahun){
				$tahun = "Data Tahun Tidak Dapat Ditemukan atau Ada Lebih Dari 1 Data";
			}

			$subdata['cur_tahun'] = $tahun;
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);	
			$data['main_content'] 	= $this->load->view('setting/setting_tahun_',$subdata,TRUE);
			//$data['breadcrumb']	= $this->load->view('breadcrumb_',array('list'=>array(array('setting'),array('tahun','class="current"'))),TRUE);
			$this->load->view('main_template',$data);
		}else{
			redirect('home','refresh');
		}
	}

	function get_posisi($jenis){

		if($jenis=='gup'){
			$posisi = $this->setting_model->get_gup();
			if($posisi=='1'){
				echo 'yes';
			}else{
				echo 'no';
			}
		}elseif($jenis=='tup'){
			$posisi = $this->setting_model->get_tup();
			if($posisi=='1'){
				echo 'yes';
			}else{
				echo 'no';
			}
		}elseif($jenis=='lsk'){
			$posisi = $this->setting_model->get_lsk();
			if($posisi=='1'){
				echo 'yes';
			}else{
				echo 'no';
			}
		}else{
			$posisi = $this->setting_model->get_lsnk();
			if($posisi=='1'){
				echo 'yes';
			}else{
				echo 'no';
			}
		}

	}

	function proses_buka_tutup($jenis,$posisi){
		if($jenis=='gup'){
			if($posisi=='on'){
				$this->setting_model->ubah_gup('1');
			}else{
				$this->setting_model->ubah_gup('0');
			}
		}elseif($jenis=='tup'){
			if($posisi=='on'){
				$this->setting_model->ubah_tup('1');
			}else{
				$this->setting_model->ubah_tup('0');
			}
		}elseif($jenis=='lsk'){
			if($posisi=='on'){
				$this->setting_model->ubah_lsk('1');
			}else{
				$this->setting_model->ubah_lsk('0');
			}
		}else{
			if($posisi=='on'){
				$this->setting_model->ubah_lsnk('1');
			}else{
				$this->setting_model->ubah_lsnk('0');
			}
		}

		echo 'sukses';
	}

	function buka_tutup(){
		if ($this->check_session->user_session() && $this->check_session->get_level()==11){
			if($this->input->post('tahun')){
				$this->form_validation->set_rules('tahun','Tahun','required|integer');
				if($this->form_validation->run()==true){
					$tahun_baru = form_prep($this->input->post('tahun'));

					// EDIT BY ALAIK 
					//$this->setting_model->edit_tahun($tahun_baru);
					$this->setting_model->ubah_tahun($tahun_baru);

					// END 
					
					

					$subdata['message']= '<div class="alert alert-success" style="text-align:center">Tahun berhasil diubah</div>';
				}
			}

			$tahun = $this->setting_model->get_tahun();

			$gup = $this->setting_model->get_gup();
			$tup = $this->setting_model->get_tup();
			$lsk = $this->setting_model->get_lsk();
			$lsnk = $this->setting_model->get_lsnk();

			if(!$tahun){
				$tahun = "Data Tahun Tidak Dapat Ditemukan atau Ada Lebih Dari 1 Data";
			}

			$subdata['cur_tahun'] = $tahun;
			$subdata['gup'] = $gup;
			$subdata['tup'] = $tup;
			$subdata['lsk'] = $lsk;
			$subdata['lsnk'] = $lsnk;
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);	
			$data['main_content'] 	= $this->load->view('setting/buka_tutup',$subdata,TRUE);
			//$data['breadcrumb']	= $this->load->view('breadcrumb_',array('list'=>array(array('setting'),array('tahun','class="current"'))),TRUE);
			$this->load->view('main_template',$data);
		}else{
			redirect('home','refresh');
		}
	}

	
}
?>
