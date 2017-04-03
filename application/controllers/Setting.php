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

	
}
?>
