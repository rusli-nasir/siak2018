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

		// $data['maintenance'] = "Untuk penyesuaian awal tahun 2018, sedang ada penyesuaian sistem di bagian laporan-laporan";
		// $data['is_demo'] = (strpos($server_uri,'localhost') !== false);

		// echo strpos($server_uri,'localhost');
		// print_r($data);
		// die();


		$this->load->view('akuntansi/login',$data);
	}

	public function audit()
	{
		$username = 'auditor';
		$password = 'auditor';
		$query 	= $this->login_model->get_user($username, $password);
		$row = $query->row();
		$login_data = array(
					'id'	=>  $row->id,
					'username'	=>  $set_username,
					'kode_unit'	=>  $row->kode_unit,
					'kode_user'	=>  $row->kode_user,
					'alias'	=>  'auditor',
					'level'	=>  $row->level,
					'setting_tahun' => 2018,
				);
		$this->session->set_userdata($login_data);
		redirect(site_url('akuntansi/laporan/lainnya'));
	}

	public function link_login(){
		?>
		<link href="http://10.37.19.95/portal/assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<link href="http://10.37.19.95/portal/assets/css/style.css" rel="stylesheet">
		<a href="javascript:void(0);" onclick="return dopost_siak()" target="_blank" class="btn btn-xs btn-white" style="float:right; margin-top: 5px; padding-top: 4px;padding-bottom: 4px;"> <i class="fa fa-angle-double-right"></i></a>
		<script> 
			function dopost_siak(){
				window.open("http://10.69.12.215/rsa/2017/index.php/akuntansi/login/audit","blank") ;
			}
		</script>
		<?php
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
					'level'	=>  $row->level,
					'setting_tahun' => 2018,
				);
				// print_r($login_data);
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
			}else if($this->session->userdata('level')==10){
				redirect(site_url('akuntansi/laporan/lainnya'));
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
