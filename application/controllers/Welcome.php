<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
                /*	Load Model, helper dan Library	*/
                        $this->load->helper('form');
                        $this->load->model('login_model');
                        $this->load->model('Tor_model');
                        $this->load->model('menu_model');
                        $this->load->library('form_validation');
                        $this->load->library('revisi_session');
				//$this->Tor_model->get_db2();
                                
                                
	
			}
			else{	/*	Jika session user sudah diset	*/

				if($this->check_session->get_level()==100){	/*	Jika session user yang aktif unit pusat	*/
					redirect('dashboard','refresh');
				}
                                elseif($this->check_session->get_level()==1){	/*	Jika session user yang aktif unit fakultas	/ biro */
					redirect('dashboard','refresh');
				}
                                elseif($this->check_session->get_level()==11){	/*	Jika session user yang aktif unit fakultas	/ biro */
					redirect('dashboard','refresh');
				}
				elseif($this->check_session->get_level()==2){	/*	Jika session user yang aktif unit fakultas	/ biro */
					redirect('dashboard','refresh');
				}
				elseif($this->check_session->get_level()==3){	/*	Jika session user yang aktif unit departmen / direktorat / bagian */
					redirect('dashboard','refresh');
				}
				elseif($this->check_session->get_level()==31){	/*	Jika session user yang aktif unit sub bag / prodi */
					redirect('usulan_belanja/daftar_usulan','refresh');
				}else{	/*	Jika session user yang aktif sub unit	*/
					redirect('dashboard','refresh');
				}
			}
    }


	public function index()
	{
		$data['cur_tahun'] = $this->cur_tahun ;
		
		$data['main_content']	= $this->load->view('home',array('cur_tahun'=>$this->cur_tahun),TRUE);
		$data['main_menu']	= $this->load->view('form_login','',TRUE);
		$list["menu"]           = $this->menu_model->show();
                $list["submenu"]        = $this->menu_model->show();
		// $data['main_menu']	= $this->load->view('main_menu',TRUE);
		// $data['message']	= validation_errors();
		$this->load->view('main_template',$data);
	}

}
