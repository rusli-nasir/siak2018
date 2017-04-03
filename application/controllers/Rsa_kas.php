<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Rsa_kas extends CI_Controller {

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


/* -------------- Property -------------------*/	
	private $cur_tahun;

/* -------------- Constructor ------------- */
    public function __construct()
    {
            parent::__construct();
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model(array('rsa_kas_model','menu_model'));
		$this->cur_tahun = $this->setting_model->get_tahun();
	}
	
/* -------------- Method ------------- */
	function index()
	{		
            $data['cur_tahun'] = $this->cur_tahun ;
            if($this->check_session->user_session() && (($this->check_session->get_level()==100))){
		if ($this->input->post()){
			
                                        $this->form_validation->set_rules('total','TOTAL KAS','xss_clean|required|is_natural');
                                     

//                                }
                                
                                if (is_array($this->input->post('rsa_kas'))) {
                                        $data = $this->input->post('rsa_kas') ;
                                        //print_r($data);exit;
                                    foreach ( $data as $key => $value) {
                                        $this->form_validation->set_rules('rsa_kas['.$key.']','rsa_kas','xss_clean|required');

                                    }
                                }

                                if($this->form_validation->run()==TRUE)
                                {
                                        $arrRsa_kas = $this->input->post('rsa_kas');
                                        $ok = false;
                                        foreach ($arrRsa_kas as $kdSubUnit => $isi) {
                                                if ($this->rsa_kas_model->check_rsa_kas($kdSubUnit,$this->cur_tahun)){
                                                        $data_edit = array(
                                                                'jumlah'	=> $isi,
                                                                'tahun'		=> $this->cur_tahun
                                                        );
                                                        if ($this->rsa_kas_model->edit_rsa_kas($data_edit,$kdSubUnit,$this->cur_tahun)){
                                                                $ok = true;
                                                        } else {
                                                                $ok = false;
                                                        }
                                                } else {
                                                        $data = array(
                                                                'kd_akun_kas' => $kdSubUnit,
                                                                'jumlah'	=> $isi,
                                                                'tahun'		=> $this->cur_tahun
                                                        );
                                                        if ($this->rsa_kas_model->add_rsa_kas($data)){
                                                                $ok = true ;
                                                        } else {
                                                                $ok = false ;
                                                        }
                                                }
                                        }
                                        if($ok == true){
                                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Data berhasil disimpan.</div>');
                                                redirect(current_url());
                                        } else {
                                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-warning-sign" aria-hidden="true"></span> Data gagal disimpan.</div>');
                                                redirect(current_url());
                                        }
                                } else {
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-warning-sign" aria-hidden="true"></span> Data gagal disimpan.</div>');
                                        redirect(current_url());
                                }
                        
		}

                                
				//$subdata['result_subunit']	= $this->setting_up_model->get_subunit($this->check_session->get_ori_unit());
				$subdata['result_akun4']	= $this->rsa_kas_model->get_akun4();
				$subdata['rsa_kas']		= $this->rsa_kas_model->get_rsa_kas_per_akun($subdata['result_akun4'],$this->cur_tahun);
				//print_r($subdata['setting_up']);
				//echo "<hr/>";	

			//echo $this->check_session->get_ori_unit();
			//$subdata['total_rsa_kas'] = $this->rsa_kas_model->get_total_rsa_kas($subdata['result_akun4'],$this->cur_tahun);


			// echo '<pre>';var_dump($subdata);echo '</pre>';die;

//			$subdata['message'] = isset($message)?$message:'';
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
			$list["submenu"] = $this->menu_model->show();
			$data['main_content']	= $this->load->view('rsa_kas/rsa_kas',$subdata,TRUE);


			$this->load->view('main_template',$data);
		} else {
                        redirect('welcome','refresh');
                }
	}

	


}
?>