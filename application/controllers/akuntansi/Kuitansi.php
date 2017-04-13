<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuitansi extends MY_Controller {
	private $data;

	public function __construct(){
        parent::__construct();
        $this->data['menu1'] = true;
        $this->cek_session_in();
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
    }

	public function index($id = 0){
		$this->data['tab1'] = true;
		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword);
		
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_ls($id = 0){
		$this->data['tab2'] = true;
		//search
		if(isset($_POST['keyword_ls'])){
			$keyword = $this->input->post('keyword_ls');
			$this->session->set_userdata('keyword_ls', $keyword);		
		}else{
			if($this->session->userdata('keyword_ls')!=null){
				$keyword = $this->session->userdata('keyword_ls');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_ls(null, null, $keyword);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_ls');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_ls($config['per_page'], $id, $keyword);
		
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function reset_search(){
		$this->session->unset_userdata('keyword');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_ls(){
		$this->session->unset_userdata('keyword_ls');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_jadi(){
		$this->session->unset_userdata('keyword_jadi');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_jadi_ls(){
		$this->session->unset_userdata('keyword_jadi_ls');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function jadi($id = 0){
		$this->data['menu1'] = null;
		$this->data['menu2'] = true;
		$this->data['tab2'] = true;
		//search
		if(isset($_POST['keyword_jadi'])){
			$keyword = $this->input->post('keyword_jadi');
			$this->session->set_userdata('keyword_jadi', $keyword);		
		}else{
			if($this->session->userdata('keyword_jadi')!=null){
				$keyword = $this->session->userdata('keyword_jadi');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_jadi(null, null, $keyword);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/jadi');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_jadi($config['per_page'], $id, $keyword);
		
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_jadi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function jadi_ls($id = 0){
		$this->data['menu1'] = null;
		$this->data['menu2'] = true;
		$this->data['tab1'] = true;
		//search
		if(isset($_POST['keyword_jadi_ls'])){
			$keyword = $this->input->post('keyword_jadi_ls');
			$this->session->set_userdata('keyword_jadi_ls', $keyword);		
		}else{
			if($this->session->userdata('keyword_jadi_ls')!=null){
				$keyword = $this->session->userdata('keyword_jadi_ls');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_jadi_ls(null, null, $keyword);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/jadi_ls');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_jadi_ls($config['per_page'], $id, $keyword);
		
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_jadi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
}
