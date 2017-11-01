<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	public function __construct(){
        parent::__construct();    

        $this->load->model('akuntansi/login_model', 'login_model');
        $this->load->helper('url');
    }

	public function index(){
		$this->cek_session_out();
		$data= array();
		$server_uri = base_url(uri_string());
		// die($server_uri);
		$data['is_demo'] = (strpos($server_uri,'pak.undip.ac.id') !== false);
		// $data['is_demo'] = (strpos($server_uri,'localhost') !== false);

		// echo strpos($server_uri,'localhost');
		// print_r($data);
		// die();


		$this->load->view('akuntansi/login',$data);
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

				if($row->level==1 or $row->level==5){
					$data_unit = $this->get_unit($row->kode_unit);
					$set_username = $data_unit['nama'];
					$alias = $data_unit['alias'];
				}else{
					$set_username = $row->username;
					$alias = null;
				}

				$login_data = array(
					'id'	=>  $row->id,
					'username'	=>  $set_username,
					'kode_unit'	=>  $row->kode_unit,
					'kode_user'	=>  $row->kode_user,
					'alias'	=>  $alias,
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
			if($this->session->userdata('level')==1){
				redirect(site_url('akuntansi/kuitansi/monitor'));
			} else if($this->session->userdata('level')==2){
				if($this->session->userdata('kode_unit')==null){
					redirect(site_url('akuntansi/kuitansi/index'));
				}else{
					redirect(site_url('akuntansi/kuitansi/monitor'));
				}
			} else if($this->session->userdata('level')==3){
				redirect(site_url('akuntansi/penerimaan/index'));
			} else if($this->session->userdata('level')==4){
				redirect(site_url('akuntansi/kuitansi/monitor'));
			} else if($this->session->userdata('level')==6){
				redirect(site_url('akuntansi/kuitansi/monitor'));
			} else if($this->session->userdata('level')==7){
				redirect(site_url('akuntansi/laporan/buku_besar'));
			} else if($this->session->userdata('level')==8){
				redirect(site_url('akuntansi/penerimaan/index'));
			} else if($this->session->userdata('level')==5){
				redirect(site_url('akuntansi/jurnal_umum'));
			} else if($this->session->userdata('level')==9){
				redirect(site_url('akuntansi/user/manage'));
			}
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('akuntansi/login');
	}

	public function get_unit($unit){
		$this->db2 = $this->load->database('rba', true);

		$query = "SELECT * FROM unit WHERE kode_unit='$unit'";
		$q = $this->db2->query($query)->result();
		foreach($q as $result){
			$data['nama'] = $result->nama_unit;
			$data['alias'] = $result->alias;
		}

		return $data;
	}
}
