<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
    
    private $cur_tahun = '' ;
    
	public function __construct()
    {
            parent::__construct();

            $this->cur_tahun = $this->setting_model->get_tahun();

            // Your own constructor code
            if(!$this->check_session->user_session()){	/*	Jika session user belum diset	*/

				redirect('/','refresh');
				
	
			}
			else{	/*	Jika session user sudah diset	*/
			
				$this->load->helper('form');
				$this->load->model('login_model');
				$this->load->model('menu_model');
				$this->load->library('form_validation');
				$this->load->library('revisi_session');

			}
    }


	public function index()
	{
		$data['cur_tahun'] = $this->cur_tahun ;
                
//                if (($this->check_session->user_session()) && ($this->check_session->get_level()==1)){
                    $data['main_content']	= $this->load->view('dashboard','',TRUE);
//                }elseif(($this->check_session->user_session()) && ($this->check_session->get_level()==2)){
//                    $data['main_content']	= $this->load->view('dashboard_kpa','',TRUE);
//                }elseif(($this->check_session->user_session()) && ($this->check_session->get_level()==11)){
//                    $data['main_content']	= $this->load->view('dashboard_buu','',TRUE);
//                }
		
		// $data['main_menu']	= $this->load->view('form_login','',TRUE);
		$list["menu"] = $this->menu_model->show();
		$list["submenu"] = $this->menu_model->show();
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['kd_pisah'] = $this->check_session->get_kd_pisah();
//		$data['message']	= validation_errors();
		$this->load->view('main_template',$data);
	}

}
		