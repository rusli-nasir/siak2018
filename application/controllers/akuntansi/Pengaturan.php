<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
    }

	public function ganti_password(){
		$temp_data['content'] = $this->load->view('akuntansi/ganti_password',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function ganti_password_proses(){
		//$this->load->model('akuntansi/User_model', 'User_model');

        if($this->input->post('password_baru') != $this->input->post('password_confirm')){
            $this->session->set_flashdata('error', 'Password Baru dan Ulangi Password Baru tidak sama.');
//        } else if($this->User_model->ganti_password()){
//            $this->session->set_flashdata('success', 'Ganti password berhasil.');
        } else {
            $this->session->set_flashdata('error', 'Password lama salah.');
        }
        
        redirect(site_url('akuntansi/pengaturan/ganti_password'));
	}
}
