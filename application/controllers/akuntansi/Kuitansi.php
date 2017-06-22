<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuitansi extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['menu1'] = true;
        $this->cek_session_in();
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
        $this->data['db2'] = $this->load->database('rba',TRUE);
    }

    public function pilih_unit(){
    	if($this->session->userdata('level')=='2' AND $this->session->userdata('username')=='verifikator'){	
	        //$this->db3 = $this->load->database('rsa', true);
	    	$this->db2 = $this->load->database('rba', true);
	    	$this->data['query_unit'] = $this->db2->query("SELECT * FROM unit ORDER BY nama_unit ASC");
	        $this->data['tmp'] = $this->db->query("SELECT unit_kerja, COUNT(*) as jumlah FROM akuntansi_kuitansi_jadi WHERE flag=1 AND tipe<>'pajak' AND (status='direvisi' OR status='proses') GROUP BY unit_kerja ORDER BY jumlah ASC");
	        foreach($this->data['tmp']->result_array() as $token){
	            $this->data['jumlah_verifikasi'][$token['unit_kerja']] = $token['jumlah'];
	        }
	        $this->data['tmp'] = $this->db->query("SELECT unit_kerja, COUNT(*) as jumlah FROM akuntansi_kuitansi_jadi WHERE flag=2 AND tipe<>'pajak' AND (status='proses') GROUP BY unit_kerja ORDER BY jumlah ASC");
	        foreach($this->data['tmp']->result_array() as $token){
	            $this->data['jumlah_posting'][$token['unit_kerja']] = $token['jumlah'];
	        }
	    	$temp_data['content'] = $this->load->view('akuntansi/pilih_unit',$this->data,true);
			$this->load->view('akuntansi/content_template',$temp_data,false);
		}else{
			redirect(site_url('akuntansi/kuitansi/jadi'));
		}
    }

    public function set_unit_session($kode_unit, $posting=null){
    	$this->session->set_userdata('kode_unit', $kode_unit);
    	if($posting) redirect(site_url('akuntansi/kuitansi/posting')); else redirect(site_url('akuntansi/kuitansi/jadi'));
    }

	public function index($id = 0){
		$this->data['tab1'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

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

		$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit);
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

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit);
		$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_gup($id = 0){
		$this->data['tab9'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword_gu'])){
			$keyword = $this->input->post('keyword_gu');
			$this->session->set_userdata('keyword_gu', $keyword);		
		}else{
			if($this->session->userdata('keyword_gu')!=null){
				$keyword = $this->session->userdata('keyword_gu');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_gup(null, null, $keyword, $kode_unit);
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

		$this->data['query'] = $this->Kuitansi_model->read_gup($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_gup('SPM-FINAL-KBUU', 0)->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_gup('SPM-FINAL-KBUU', 1)->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/up_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function index_nihil($id = 0){
		$this->data['tab7'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

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

		$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit);
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

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function index_up($id = 0){
		$this->data['tab4'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword_up'])){
			$keyword = $this->input->post('keyword_up');
			$this->session->set_userdata('keyword_up', $keyword);		
		}else{
			if($this->session->userdata('keyword_up')!=null){
				$keyword = $this->session->userdata('keyword_up');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_up(null, null, $keyword, $kode_unit);
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

//		$this->data['query'] = $this->Kuitansi_model->total_up('SPM-FINAL-KBUU', 0);
		$this->data['query'] = $this->Kuitansi_model->read_up($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_up('SPM-FINAL-KBUU', 0)->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_up('SPM-FINAL-KBUU', 1)->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/up_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function index_pup($id = 0){
		$this->data['tab6'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

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

		$total_data = $this->Kuitansi_model->read_pup(null, null, $keyword, $kode_unit);
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

		$this->data['query'] = $this->Kuitansi_model->read_pup($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_pup('SPM-FINAL-KBUU', 0)->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_pup('SPM-FINAL-KBUU', 1)->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/up_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function index_tup($id = 0){
		$this->data['tab5'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

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

		$total_data = $this->Kuitansi_model->read_tup(null, null, $keyword, $kode_unit);
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

		$this->data['query'] = $this->Kuitansi_model->read_tup($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_tup('SPM-FINAL-KBUU', 0)->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_tup('SPM-FINAL-KBUU', 1)->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/tup_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function index_tup_nihil($id = 0){
		$this->data['tab8'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

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

		$total_data = $this->Kuitansi_model->read_tup_nihil(null, null, $keyword, $kode_unit);
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

		$this->data['query'] = $this->Kuitansi_model->read_tup_nihil($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/tup_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_ls($id = 0){
		$this->data['tab2'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

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

		$this->data['kuitansi_non_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/lsphk3_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_spm($id = 0){
		$this->data['tab3'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword_spm'])){
			$keyword = $this->input->post('keyword_spm');
			$this->session->set_userdata('keyword_spm', $keyword);		
		}else{
			if($this->session->userdata('keyword_spm')!=null){
				$keyword = $this->session->userdata('keyword_spm');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_spm(null, null, $keyword);
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
		$config['base_url'] = site_url('akuntansi/kuitansi/index_spm');
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

		$this->data['query'] = $this->Kuitansi_model->read_spm($config['per_page'], $id, $keyword);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'proses'=>5, 'substr(unitsukpa,1,2)'=>$this->session->userdata('kode_unit')), 'kepeg_tr_spmls')->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'proses'=>5, 'substr(unitsukpa,1,2)'=>$this->session->userdata('kode_unit')), 'kepeg_tr_spmls')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/spm_non_kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}	

	public function jadi($id = 0, $jenis = 'GP'){
		$this->data['menu1'] = null;
		$this->data['menu2'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			redirect(site_url('akuntansi/kuitansi/pilih_unit'));
			$kode_unit = null;
		}

		//search
		$keyword = '';
		if(isset($_POST['keyword_jadi_'.$jenis])){
			$keyword = $this->input->post('keyword_jadi_'.$jenis);
			$this->session->set_userdata('keyword_jadi_'.$jenis, $keyword);		
		}else{
			if($this->session->userdata('keyword_jadi_'.$jenis)!=null){
				$keyword = $this->session->userdata('keyword_jadi_'.$jenis);
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_jadi(null, null, $keyword, $kode_unit, $jenis);
		$total = $total_data->num_rows();
		$this->data['total_a'] = $total_data->num_rows();

		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*3;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/jadi');
	 	$config['per_page'] = '3';
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

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_jadi($config['per_page'], $id, $keyword, $kode_unit, $jenis);
		$this->data['query'] = $this->data['query']->result_array();
        $this->load->model('akuntansi/Akun_model');
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
            $this->data['query'][$key] = (object) $this->data['query'][$key];
        }

        $this->data['kuitansi_ok'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'tipe'=>'pengeluaran', 'jenis'=>$jenis, 'flag'=>2,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'tipe'=>'pengeluaran', 'jenis'=>$jenis, 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_revisi'] = $this->Kuitansi_model->read_total(array('status'=>'revisi', 'tipe'=>'pengeluaran', 'jenis'=>$jenis, 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();

        if($jenis=='UP'){
        	$this->data['tab1'] = true;
        }else if($jenis=='PUP'){
        	$this->data['tab2'] = true;
        }else if($jenis=='GUP'){
        	$this->data['tab9'] = true;
        }else if($jenis=='GP'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab3'] = true;
        }else if($jenis=='GP_NIHIL'){
        	$this->data['tab4'] = true;
        }else if($jenis=='TUP'){
        	$this->data['tab5'] = true;
        }else if($jenis=='TUP_NIHIL'){
        	$this->data['tab6'] = true;
        }

        $this->data['jenis'] = $jenis;

		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_jadi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function jadi_ls($id = 0){
		$this->data['menu1'] = null;
		$this->data['menu2'] = true;
		$this->data['tab7'] = true;
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

		$this->data['kuitansi_ok'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'jenis'=>'LSPHK3', 'flag'=>2,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'jenis'=>'LSPHK3', 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_revisi'] = $this->Kuitansi_model->read_total(array('status'=>'revisi', 'jenis'=>'LSPHK3', 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_lsphk3_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function jadi_spm($id = 0){
		$this->data['menu1'] = null;
		$this->data['menu2'] = true;
		$this->data['tab8'] = true;
		//search
		if(isset($_POST['keyword_spm_jadi'])){
			$keyword = $this->input->post('keyword_spm_jadi');
			$this->session->set_userdata('keyword_spm_jadi', $keyword);		
		}else{
			if($this->session->userdata('keyword_spm_jadi')!=null){
				$keyword = $this->session->userdata('keyword_spm_jadi');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_jadi_spm(null, null, $keyword);
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
		$config['base_url'] = site_url('akuntansi/kuitansi/jadi_spm');
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

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_jadi_spm($config['per_page'], $id, $keyword);

		$this->data['kuitansi_ok'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'tipe<>'=>'pajak', 'jenis'=>'NK', 'flag'=>2,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'tipe<>'=>'pajak', 'jenis'=>'NK', 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_revisi'] = $this->Kuitansi_model->read_total(array('status'=>'revisi', 'tipe<>'=>'pajak', 'jenis'=>'NK', 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/spm_non_kuitansi_list_jadi',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function reset_search(){
		$this->session->unset_userdata('keyword');
		$this->session->unset_userdata('keyword_up');
		$this->session->unset_userdata('keyword_pup');
		$this->session->unset_userdata('keyword_gu');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_ls(){
		$this->session->unset_userdata('keyword_ls');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_spm(){
		$this->session->unset_userdata('keyword_spm');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_jadi(){
		$this->session->unset_userdata('keyword_jadi');
		$this->session->unset_userdata('keyword_jadi_UP');
		$this->session->unset_userdata('keyword_jadi_PUP');
		$this->session->unset_userdata('keyword_jadi_GP');
		$this->session->unset_userdata('keyword_jadi_GUP');
		$this->session->unset_userdata('keyword_jadi_TUP');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_jadi_ls(){
		$this->session->unset_userdata('keyword_jadi_ls');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_jadi_spm(){
		$this->session->unset_userdata('keyword_spm_jadi');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function send_service($id_kuitansi_jadi = 0){
		$query = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);

		echo json_encode($query);
	}
    
    public function posting($id=0, $jenis = 'GP'){
		$this->data['menu3'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			redirect(site_url('akuntansi/kuitansi/pilih_unit'));
			$kode_unit = null;
		}

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

		$total_data = $this->Kuitansi_model->read_kuitansi_posting(null, null, $keyword, $kode_unit, $jenis);
        
        $this->data['all_query'] = $total_data->result();
        
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

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_posting($config['per_page'], $id, $keyword, $kode_unit, $jenis);
		$this->data['query'] = $this->data['query']->result_array();
        $this->load->model('akuntansi/Akun_model');
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
            $this->data['query'][$key] = (object) $this->data['query'][$key];
        }
        
        if($jenis=='UP'){
        	$this->data['tab1'] = true;
        }else if($jenis=='PUP'){
        	$this->data['tab2'] = true;
        }else if($jenis=='GP'){
        	$this->data['tab3'] = true;
        }else if($jenis=='GP_NIHIL'){
        	$this->data['tab4'] = true;
        }else if($jenis=='TUP'){
        	$this->data['tab5'] = true;
        }else if($jenis=='TUP_NIHIL'){
        	$this->data['tab6'] = true;
        }
        
		$temp_data['content'] = $this->load->view('akuntansi/posting_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
    }
    
    public function posting_ls(){
		$this->data['menu3'] = true;
		$this->data['tab2'] = true;
        
        if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			redirect(site_url('akuntansi/kuitansi/pilih_unit'));
			$kode_unit = null;
		}
        
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

		$total_data = $this->Kuitansi_model->read_kuitansi_posting_ls(null, null, $keyword, $kode_unit);
        $this->data['all_query'] = $total_data->result();

        
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

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_posting_ls($config['per_page'], $id, $keyword, $kode_unit);
        $this->data['query'] = $this->data['query']->result_array();
        $this->load->model('akuntansi/Akun_model');
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
            $this->data['query'][$key] = (object) $this->data['query'][$key];
        }
		
		$temp_data['content'] = $this->load->view('akuntansi/posting_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
    }
    
    public function posting_spm(){
		$this->data['menu3'] = true;
		$this->data['tab8'] = true;
        
        if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			redirect(site_url('akuntansi/kuitansi/pilih_unit'));
			$kode_unit = null;
		}
        
		//search
		if(isset($_POST['keyword_spm_jadi'])){
			$keyword = $this->input->post('keyword_spm_jadi');
			$this->session->set_userdata('keyword_spm_jadi', $keyword);		
		}else{
			if($this->session->userdata('keyword_spm_jadi')!=null){
				$keyword = $this->session->userdata('keyword_spm_jadi');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_posting_spm(null, null, $keyword, $kode_unit);
        $this->data['all_query'] = $total_data->result();
        
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
		$config['base_url'] = site_url('akuntansi/kuitansi/jadi_spm');
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

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_posting_spm($config['per_page'], $id, $keyword, $kode_unit);
        $this->data['query'] = $this->data['query']->result_array();
        $this->load->model('akuntansi/Akun_model');
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
            $this->data['query'][$key] = (object) $this->data['query'][$key];
        }
		
		$temp_data['content'] = $this->load->view('akuntansi/posting_nk_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
    }

    /*=================================== MONITORING =========================================*/
    /*=================================== MONITORING =========================================*/
    /*=================================== MONITORING =========================================*/

    public function monitor($print = false){
    	$this->db2 = $this->load->database('rba', true);
    	if($this->session->userdata('kode_unit')!=null){
    		$filter = 'WHERE kode_unit="'.$this->session->userdata('kode_unit').'"';
    	}else{
    		$filter = '';
    	}
    	$this->data['query_unit'] = $this->db2->query("SELECT * FROM unit $filter ORDER BY nama_unit ASC");

    	if($this->input->post('daterange')!=null){
	    	$daterange = $this->input->post('daterange');
	        $date_t = explode(' - ', $daterange);
	        $periode_awal = strtodate($date_t[0]);
	        $periode_akhir = strtodate($date_t[1]);
	        $this->data['periode'] = $daterange;
	    }else{
	    	$periode_awal = null;
	        $periode_akhir = null;
	        $this->data['periode'] = 'Semua Periode';
	    }

    	$i=0;
    	foreach($this->data['query_unit']->result() as $result){
    		$this->data['total_kuitansi'][$i] = $this->get_total_kuitansi($result->kode_unit, $periode_awal, $periode_akhir);
    		$this->data['non_verif'][$i] = $this->get_total_data($result->kode_unit, 'non_verif', $periode_awal, $periode_akhir);
    		$this->data['setuju'][$i] = $this->get_total_data($result->kode_unit, 'setuju', $periode_awal, $periode_akhir);
    		$this->data['revisi'][$i] = $this->get_total_data($result->kode_unit, 'revisi', $periode_awal, $periode_akhir);
    		$this->data['posting'][$i] = $this->get_total_data($result->kode_unit, 'posting', $periode_awal, $periode_akhir);
    		$i++;
    	}
        /*$this->data['tmp'] = $this->db->query("SELECT unit_kerja, COUNT(*) as jumlah FROM akuntansi_kuitansi_jadi WHERE flag=1 AND (status='direvisi' OR status='proses') GROUP BY unit_kerja ORDER BY jumlah ASC");
        foreach($this->data['tmp']->result_array() as $token){
            $this->data['jumlah_verifikasi'][$token['unit_kerja']] = $token['jumlah'];
        }
        $this->data['tmp'] = $this->db->query("SELECT unit_kerja, COUNT(*) as jumlah FROM akuntansi_kuitansi_jadi WHERE flag=2 AND (status='proses') GROUP BY unit_kerja ORDER BY jumlah ASC");
        foreach($this->data['tmp']->result_array() as $token){
            $this->data['jumlah_posting'][$token['unit_kerja']] = $token['jumlah'];
        }*/

        if($print==true){
        	$this->load->view('akuntansi/monitor_print',$this->data,false);
        }else{
    		$temp_data['content'] = $this->load->view('akuntansi/monitor',$this->data,true);
			$this->load->view('akuntansi/content_template',$temp_data,false);
		}
    }

    function get_total_data($kode_unit, $jenis, $periode_awal, $periode_akhir){
		if($jenis=='setuju'){
			$cond = array('unit_kerja'=>$kode_unit, 'status'=>'proses', 'flag'=>2);
		}else if($jenis=='revisi'){
			$cond = array('unit_kerja'=>$kode_unit, 'status'=>'revisi', 'flag'=>1);
		}else if($jenis=='posting'){
			$cond = array('unit_kerja'=>$kode_unit, 'status'=>'posted');
		}else if($jenis=='non_verif'){
			$cond = array('unit_kerja'=>$kode_unit, 'status'=>'proses', 'flag'=>1);
		}
		$this->db->where($cond);
		if($periode_awal!=null AND $periode_akhir!=null){
    		$this->db->where("(tanggal BETWEEN '$periode_awal' AND '$periode_akhir')");
    	}
		$query = $this->db->get('akuntansi_kuitansi_jadi');
		$q = $query->num_rows();
		return $q;
	}

	function get_total_kuitansi($kode_unit, $periode_awal, $periode_akhir){
		$this->db->where(array('kode_unit'=>$kode_unit, 'cair'=>1));
		if($periode_awal!=null AND $periode_akhir!=null){
    		$this->db->where("(tgl_kuitansi BETWEEN '$periode_awal' AND '$periode_akhir')");
    	}
		$query = $this->db->get('rsa_kuitansi');
		$q = $query->num_rows();
		return $q;
	}
    
    /****************** RUPIAH MURNI ************************/
    
    // Redirect ke memorial
    
    /****************** RUPIAH MURNI ************************/
}
