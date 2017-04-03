<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Setting_up extends CI_Controller {

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
		$this->load->model(array('setting_up_model','menu_model'));
		$this->cur_tahun = $this->setting_model->get_tahun();
	}
	
/* -------------- Method ------------- */
	function index()
	{		
            $data['cur_tahun'] = $this->cur_tahun ;
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11)||($this->check_session->get_level()==3))){
		if ($this->input->post()){
			
//                                if ($this->check_session->get_level()==11){
                                        $this->form_validation->set_rules('total','TOTAL UP','xss_clean|required|is_natural');
                                        //$this->form_validation->set_rules('total_rm','APBN BPPTNBH','xss_clean|required|is_natural|callback_check_setting_total_alokasi_rm');
                                        //$this->form_validation->set_rules('total_lainnya','APBN LAINNYA','xss_clean|required|is_natural|callback_check_setting_total_alokasi_lainnya');

//                                }
//                                die;
                                if (is_array($this->input->post('setting_up'))) {
                                        $data = $this->input->post('setting_up') ;
                                        //print_r($data);exit;
                                    foreach ( $data as $key => $value) {
                                        $this->form_validation->set_rules('setting_up['.$key.']','setting_up','xss_clean|required');

                                    }
                                }
                                
                                if (is_array($this->input->post('setting_up_subunit'))) {
                                        $data = $this->input->post('setting_up_subunit') ;
                                        //print_r($data);exit;
                                    foreach ( $data as $key => $value) {
                                        $this->form_validation->set_rules('setting_up_subunit['.$key.']','setting_up_subunit','xss_clean|required');

                                    }
                                }

                                if($this->form_validation->run()==TRUE)
                                {
                                        $arrSetting_up = $this->input->post('setting_up');
                                        $arrSetting_up_subunit = $this->input->post('setting_up_subunit');
                                        //$arrRM = $this->input->post('rm');
                                        //$lainnya = $this->input->post('lainnya');
                                        //print_r($arrSetting_up);
                                        //exit;
//                                        echo '<pre>';print_r($arrSetting_up_subunit);echo '</pre>';die;
                                        $ok = false;
                                        foreach ($arrSetting_up as $kdSubUnit => $isi) {
                                                if ($this->setting_up_model->check_setting_up($kdSubUnit,$this->cur_tahun)){
                                                        $data_edit = array(
                                                                'jumlah'	=> $isi,
                                                                //'nomor'	=> '0001/FT/SPP-UP/JAN/2017',
                                                                //'rm'			=> $arrRM[$kdSubUnit],
                                                                //'apbn_lainnya'		=> $lainnya[$kdSubUnit],
                                                                'tahun'		=> $this->cur_tahun
                                                        );
                                                        if ($this->setting_up_model->edit_setting_up($data_edit,$kdSubUnit,$this->cur_tahun)){
                                                                $ok = true;
                                                        } else {
                                                                $ok = false;
                                                        }
                                                } else {
                                                        $data = array(
                                                                'kode_unit_subunit' => $kdSubUnit,
                                                                'jumlah'	=> $isi,
                                                                //'nomor'	=> $nomor,
                                                                'tahun'		=> $this->cur_tahun
                                                        );
                                                        if ($this->setting_up_model->add_setting_up($data)){
                                                                $ok = true ;
                                                        } else {
                                                                $ok = false ;
                                                        }
                                                }
                                        }
                                        foreach ($arrSetting_up_subunit as $kdSubUnit => $isi) {
                                                if ($this->setting_up_model->check_setting_up($kdSubUnit,$this->cur_tahun)){
                                                        $data_edit = array(
                                                                'jumlah'	=> $isi,
                                                                //'nomor'	=> '0001/FT/SPP-UP/JAN/2017',
                                                                //'rm'			=> $arrRM[$kdSubUnit],
                                                                //'apbn_lainnya'		=> $lainnya[$kdSubUnit],
                                                                'tahun'		=> $this->cur_tahun
                                                        );
                                                        if ($this->setting_up_model->edit_setting_up($data_edit,$kdSubUnit,$this->cur_tahun)){
                                                                $ok = true;
                                                        } else {
                                                                $ok = false;
                                                        }
                                                } else {
                                                        $data = array(
                                                                'kode_unit_subunit' => $kdSubUnit,
                                                                'jumlah'	=> $isi,
                                                                //'nomor'	=> $nomor,
                                                                'tahun'		=> $this->cur_tahun
                                                        );
                                                        if ($this->setting_up_model->add_setting_up($data)){
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
//		if ($this->check_session->user_session()){
//			if($this->check_session->get_level()==11){
                                
//				$subdata['result_subunit']	= $this->setting_up_model->get_subunit($this->check_session->get_ori_unit());
				$subdata['result_unit']	= $this->setting_up_model->get_unit();
                                $subdata['result_subunit']	= array(
                                            $this->setting_up_model->get_subunit('41'),
                                            $this->setting_up_model->get_subunit('42'),
                                            $this->setting_up_model->get_subunit('43'),
                                            $this->setting_up_model->get_subunit('44'),
                                        );
				$subdata['setting_up']                  = $this->setting_up_model->get_setting_up_per_unit($subdata['result_unit'],$this->cur_tahun);
                                $subdata['setting_up_subunit']		= $this->setting_up_model->get_setting_up_per_subunit($subdata['result_subunit'],$this->cur_tahun);
//				echo '<pre>';print_r($subdata['setting_up_subunit']);echo '</pre>';die;
				//echo "<hr/>";
			


//			}elseif($this->check_session->get_level()==13){
//                            redirect('rsa_up/index','refresh');
//                        }elseif($this->check_session->get_level()==14){
//                            redirect('rsa_up/index','refresh');
//                        }
//			else {
//				redirect('welcome','refresh');
//			}

			

			//echo $this->check_session->get_ori_unit();
//			$subdata['total_setting_up'] = $this->setting_up_model->get_total_setting_up($this->check_session->get_ori_unit(),$this->cur_tahun);


			// echo '<pre>';var_dump($subdata);echo '</pre>';die;

//			$subdata['message'] = isset($message)?$message:'';
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
			$list["submenu"]        = $this->menu_model->show();
			$data['main_content']	= $this->load->view('setting_up/setting_up',$subdata,TRUE);


			$this->load->view('main_template',$data);
		} else {
                        redirect('welcome','refresh');
                }
	}

	function tes(){


	}

	function inputan_check($str){

	}
	

	function check_setting_up($str1){
		
		/*	set message error	*/
		//foreach ($str as $kdSubUnit => $isi) {
			if (!$this->is_natural($str1)){
				$this->form_validation->set_message('check_setting_up','Maaf dana UP harus angka.');
				return FALSE;
				//break;
			}
		
		
	}

	
	function is_natural($str)
    {
    	if ( ! preg_match( '/^[0-9]+$/', $str))
    	{
    		return FALSE;
    	}
    	    
   		return TRUE;
    }


    // EDIT BY IDRIS

	function check_total_setting_up($str)
	{
		/*	set message error	*/
		$this->form_validation->set_message('check_total_setting_up','Maaf total alokasi belanja SELAIN APBN melebihi alokasi');
			$query	 = $this->setting_up_model->get_setting_up($this->check_session->get_ori_unit(),$this->cur_tahun);
		$row	 = $query->result();
		$setting_up = isset($row[0]->jumlah)?$row[0]->jumlah:0;
		return ($str<=$setting_up);
	}

   

		function check_setting_total_setting_up($str)
	{
		/*	set message error	*/
		$this->form_validation->set_message('check_setting_total_setting_up','Maaf total alokasi belanja SELAIN APBN melebihi alokasi');
		
		$setting_up	 = $this->Setting_up_model->get_total_setting_alokasi($this->check_session->get_ori_unit(),$this->cur_tahun);

		return ($str<=$alokasi);
	}

   	function check_setting_total_alokasi_rm($str)
	{
		/*	set message error	*/
		$this->form_validation->set_message('check_setting_total_alokasi_rm','Maaf total alokasi belanja APBN (BPPTNBH) melebihi alokasi');
		
		$alokasi	 = $this->alokasi_model->get_total_setting_alokasi_rm($this->check_session->get_ori_unit(),$this->cur_tahun);

		return ($str<=$alokasi);
	}

	function check_setting_total_alokasi_lainnya($str)
	{
		/*	set message error	*/
		$this->form_validation->set_message('check_setting_total_alokasi_lainnya','Maaf total alokasi belanja APBN LAINNYA melebihi alokasi');
		
		$alokasi	 = $this->alokasi_model->get_total_setting_alokasi_lainnya($this->check_session->get_ori_unit(),$this->cur_tahun);

		return ($str<=$alokasi);
	}


}
?>