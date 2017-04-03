<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Menu  extends CI_Controller {

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
		/* check session	*/
		if($this->check_session->get_level()!=1){
			redirect('home','refresh');	// redirect ke halaman home
		}
		$this->load->helper('form');
		$this->load->model('menu_model');
	}
	
/* -------------- Method ------------- */
	function index()
	{
		$subdata["menu"] = $this->menu_model->all();
		
		/*	Set data untuk main template */
		$list["menu"] = $this->menu_model->show();
		$data['user_menu']	= $this->load->view('user_menu_','',TRUE);
		$data['main_menu']	= $this->load->view('main_menu_',$list,TRUE);
		$data['content']	= $this->load->view('manage_menu_',$subdata,TRUE);
		$data['breadcrumb']	= $this->load->view('breadcrumb_',array('list'=>array(array('Setting'),array('Menu','class="current"'))),TRUE);
		
		/*	Load main template	*/
		$this->load->view('main_template_',$data);
	}
	
	function edit()
	{
		$id = form_prep($this->input->post("id"));
		$aktif = form_prep($this->input->post("active"));
		
		$activation = $this->menu_model->activation($id,$aktif);
		redirect('menu');
	}
}