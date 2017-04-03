<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	private $data;

	public function __construct(){
        parent::__construct();    

        $this->load->model('akuntansi/login_model', 'login_model');
    }

	public function index(){
		$this->cek_session_out();
		$this->load->view('akuntansi/login');
	}

	public function login_proses()
	{
		$this->cek_session_out();
		$data['report'] = 0;
		$login = false;
		
		if($this->input->post('submit')!=null){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$query 	= $this->login_model->get_user($username, $password);
			if ($query->num_rows()!=0){
				$row = $query->row();
				$login_data = array(
					'id'	=>  $row->id,
					'username'	=>  $row->username,
					'level'	=>  $row->level
				);
				print_r($login_data);
				$this->session->set_userdata($login_data);
				$login = true;
			}else{
				$data['report'] = 2;
			}
		}else{
			$data['report'] = 0;
		}
		$this->load->view('akuntansi/login', $data);

		if ($login) {
			redirect(site_url('akuntansi/beranda'));
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('akuntansi/login');
	}
}
