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

    //edited by fahmi



	function transaksi_kas(){
        $data['cur_tahun'] = $this->cur_tahun ;
      if($this->check_session->user_session() && $this->check_session->get_level() == 11){
            $list["menu"] = $this->menu_model->show();
            $list["submenu"] = $this->menu_model->show();
            $data['main_menu']  = $this->load->view('main_menu','',TRUE);
            
            $subdata['daftar_transaksi_kas']            = $this->rsa_kas_model->get_daftar_kas();
            $subdata['daftar_saldo']            = $this->rsa_kas_model->get_saldo();
                // vdebug($subdata['daftar_saldo']);
                
            $data['main_content'] = $this->load->view('rsa_kas/transaksi_kas',$subdata,TRUE);
            $this->load->view('main_template',$data);
            // vdebug($subdata);
        }else{
            redirect('welcome','refresh');  
         }

    }

    function ganti_kas(){
        $subdata['opt_spm']            = $this->rsa_kas_model->get_no_spm_kas();
        $subdata['opt_kd_akun_kas']            = $this->rsa_kas_model->get_no_kas();
        // vdebug( $subdata['opt_spm']);
        $this->load->view('rsa_kas/ganti_kas',$subdata);
    }

    function get_isi_kas(){
        $no_spm = $this->input->post("no_spm");
        $subdata['isi_kas']            = $this->rsa_kas_model->get_isi_kas($no_spm);

        // vdebug( $subdata['opt_spm']);
        $this->load->view('rsa_kas/isi_kas',$subdata);
    }


    function exec_add_ganti_kas(){
        if($this->input->post()){
            if($this->check_session->user_session()){

                $this->form_validation->set_rules('no_spm','No_spm','required'); 
                $this->form_validation->set_rules('kd_akun_kas_1','Kd_akun_kas_1','required');
                $this->form_validation->set_rules('deskripsi','Deskripsi','required');
                $this->form_validation->set_rules('kd_unit','Kd_unit','required');
                $this->form_validation->set_rules('kredit_awal','Kredit_awal','required');
                $this->form_validation->set_rules('kd_akun_kas_2','Kd_akun_kas_2','required');


                if ($this->form_validation->run()){
                    $kode1 = $this->input->post("kd_akun_kas_1");
                    $kode2 = $this->input->post("kd_akun_kas_2");
                    $saldo1 = $this->rsa_kas_model->get_saldo_aktif($kode1);
                    $saldo2 = $this->rsa_kas_model->get_saldo_aktif($kode2);

                    if ($kode1 != $kode2) {
                        $data1 = array(
                            "tgl_trx"                   => date('Y-m-d H:i:s'),
                            "kd_akun_kas"               => $this->input->post("kd_akun_kas_1"),
                            "kd_unit"                   => $this->input->post("kd_unit"),
                            "deskripsi"                 => $this->input->post("deskripsi"),
                            "no_spm"                    => $this->input->post("no_spm"),
                            "debet"                     => $this->input->post("kredit_awal"),
                            "kredit"                    => '0',
                            "saldo"                     => $saldo1 + $this->input->post("kredit_awal"),
                            "aktif"                     => '1'
                        );

                        $data2 = array(
                            "tgl_trx"                   => date('Y-m-d H:i:s'),
                            "kd_akun_kas"               => $this->input->post("kd_akun_kas_2"),
                            "kd_unit"                   => $this->input->post("kd_unit"),
                            "deskripsi"                 => $this->input->post("deskripsi"),
                            "no_spm"                    => $this->input->post("no_spm"),
                            "debet"                     => '0',
                            "kredit"                    => $this->input->post("kredit_awal"),
                            "saldo"                     => $saldo2 - $this->input->post("kredit_awal"),
                            "aktif"                     => '1'
                        );


                        $update1 = $this->rsa_kas_model->update_data($kode1);
                        $update2 = $this->rsa_kas_model->update_data($kode2);

                        $add_data1 = $this->rsa_kas_model->add_data($data1);
                        $add_data2 = $this->rsa_kas_model->add_data($data2);
                    }else{
                        $this->session->set_flashdata('error', 'Data tidak tersimpan karena pindah akun yang sama');
                        redirect('rsa_kas/transaksi_kas','refresh'); 
                    }
                    
                    
                    if($update1 && $update2 && $add_data1 && $add_data2){
                         redirect('rsa_kas/transaksi_kas','refresh'); 
                    }
                    else{
                        $this->session->set_flashdata('error', 'Data tidak tersimpan ada yang salah');
                        redirect('rsa_kas/get_isi_kas','refresh');
                    }  
                }
                else{
                   vdebug($this->form_validation->run()); 
                } 
            }else{
                show_404('page');
            }
        }
    }



}
?>