<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Memorial extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['menu5'] = true;
        $this->cek_session_in();
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
        $this->load->model('akuntansi/Riwayat_model', 'Riwayat_model');
        $this->load->model('akuntansi/Akun_kas_rsa_model', 'Akun_kas_rsa_model');
        $this->load->model('akuntansi/Akun_belanja_rsa_model', 'Akun_belanja_rsa_model');
        $this->load->model('akuntansi/Unit_kerja_model', 'Unit_kerja_model');
        $this->load->model('akuntansi/Memorial_model', 'Memorial_model');
        $this->load->model('akuntansi/Relasi_kuitansi_akun_model', 'Relasi_kuitansi_akun_model');
        $this->load->model('akuntansi/Akun_lra_model', 'Akun_lra_model');
        $this->load->model('akuntansi/Posting_model', 'Posting_model');
    }

    public function coba($value='')
    {
        echo $this->Posting_model->posting_kuitansi_full($value);
    }

	public function index($id = 0){
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

		$total_data = $this->Kuitansi_model->read_by_tipe(null, null, $keyword, 'memorial');
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

		$this->data['query'] = $this->Kuitansi_model->read_by_tipe($config['per_page'], $id, $keyword, 'memorial');
		
		$temp_data['content'] = $this->load->view('akuntansi/memorial_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function tambah(){
		$this->data['akun_kas'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
		$temp_data['content'] = $this->load->view('akuntansi/memorial_tambah',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function input_memorial()
	{
		$this->load->library('form_validation');


		$this->form_validation->set_rules('jenis_pembatasan_dana','Jenis Pembatasan Dana','required');
		$this->form_validation->set_rules('no_bukti','No. Bukti','required');
		$this->form_validation->set_rules('kode_kegiatan','Kode Kegiatan','required');
		$this->form_validation->set_rules('tanggal','Tanggal','required');
		$this->form_validation->set_rules('jenis','Jenis','required');
		$this->form_validation->set_rules('unit_kerja','unit_kerja','required');
		$this->form_validation->set_rules('uraian','uraian','required');
//		$this->form_validation->set_rules('kas_akun_debet','Akun debet (kas)','required');
//		$this->form_validation->set_rules('jumlah_akun_debet','Jumlah Akun Debet','required');
//		$this->form_validation->set_rules('jumlah_akun_kredit','Jumlah Akun Kredit','required|matches[jumlah_akun_debet]');

		if($this->form_validation->run())     
        {   
            $entry = $this->input->post();
            unset($entry['simpan']);
            $entry['id_kuitansi'] = null;
            $entry['no_bukti'] = $this->Memorial_model->generate_nomor_bukti();
            $entry['akun_debet'] = $entry['kas_akun_debet'][0];
            $entry['akun_kredit'] = $entry['kas_akun_kredit'][0];
            unset($entry['kas_akun_kredit']);
            unset($entry['kas_akun_debet']);
            $entry['jumlah_debet'] = $entry['jumlah_akun_debet'][0];
            unset($entry['jumlah_akun_debet']);
            $entry['jumlah_kredit'] = $entry['jumlah_akun_kredit'][0];
            unset($entry['jumlah_akun_kredit']);
            $entry['tipe'] = 'memorial';
            $entry['flag'] = 3;
            $entry['status'] = 4;

            $akun = $this->input->post();

            $q1 = $this->Kuitansi_model->add_kuitansi_jadi($entry);

            $id_kuitansi_jadi = $q1;

            $relasi_debet = array();
            $entry_relasi = array();
            $relasi = array();
            for ($i=0; $i < count($akun['kas_akun_debet']); $i++) { 
                $relasi['akun'] = $akun['kas_akun_debet'][$i];
                $relasi['jumlah'] = $akun['jumlah_akun_debet'][$i];
                $relasi['tipe'] = 'debet';
                $relasi['no_bukti'] = $entry['no_bukti'];
                $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;

                $entry_relasi[] = $relasi;
            }

            $relasi_kredit = array();
            for ($i=0; $i < count($akun['kas_akun_kredit']); $i++) { 
                $relasi['akun'] = $akun['kas_akun_kredit'][$i];
                $relasi['jumlah'] = $akun['jumlah_akun_kredit'][$i];
                $relasi['tipe'] = 'kredit';
                $relasi['no_bukti'] = $entry['no_bukti'];
                $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;

                $entry_relasi[] = $relasi;
            }

            $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($entry_relasi);

            $q3 = $this->Posting_model->posting_kuitansi_full($id_kuitansi_jadi);

            $riwayat = array();
            $riwayat['id_kuitansi_jadi'] = $q1;
            $riwayat['status'] = 'posted';
            $riwayat['flag'] = 3;

            $this->Riwayat_model->add_riwayat($riwayat);

            redirect('akuntansi/memorial');


        } else {
            $this->data['no_bukti'] = $this->Memorial_model->generate_nomor_bukti();
        	$this->data['all_unit_kerja'] = $this->Unit_kerja_model->get_all_unit_kerja();
        	$this->data['akun_kredit'] = $this->Akun_lra_model->get_akun_kredit();
        	$this->data['akun_debet'] = $this->Akun_lra_model->get_akun_debet();
			$temp_data['content'] = $this->load->view('akuntansi/memorial_tambah',$this->data,true);
			$this->load->view('akuntansi/content_template',$temp_data,false);
        }
	}

	public function edit_memorial($id_kuitansi_jadi,$mode = null)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('jenis_pembatasan_dana','Jenis Pembatasan Dana','required');
		$this->form_validation->set_rules('no_bukti','No. Bukti','required');
		$this->form_validation->set_rules('kode_kegiatan','Kode Kegiatan','required');
		$this->form_validation->set_rules('tanggal','Tanggal','required');
		$this->form_validation->set_rules('jenis','Jenis','required');
		$this->form_validation->set_rules('unit_kerja','unit_kerja','required');
		$this->form_validation->set_rules('uraian','uraian','required');
		$this->form_validation->set_rules('kas_akun_debet','Akun debet (kas)','required');
//		$this->form_validation->set_rules('jumlah_akun_debet','Jumlah Akun Debet','required');
//		$this->form_validation->set_rules('jumlah_akun_kredit','Jumlah Akun Kredit','required|matches[jumlah_akun_debet]');

		if($this->form_validation->run())     
        {   
            $entry = $this->input->post();
            unset($entry['simpan']);
            $entry['id_kuitansi'] = null;
            $entry['akun_debet'] = $entry['kas_akun_debet'][0];
            unset($entry['kas_akun_debet']);
            $entry['jumlah_debet'] = $entry['jumlah_akun_debet'][0];
            unset($entry['jumlah_akun_debet']);
            $entry['jumlah_kredit'] = $entry['jumlah_akun_kredit'][0];
            unset($entry['jumlah_akun_kredit']);
            $entry['tipe'] = 'memorial';

            $akun = $this->input->post();

            $relasi_debet = array();
            $entry_relasi = array();
            $relasi = array();
            for ($i=0; $i < count($akun['kas_akun_debet']); $i++) { 
            	$relasi['akun'] = $akun['kas_akun_debet'][$i];
            	$relasi['jumlah'] = $akun['jumlah_akun_debet'][$i];
            	$relasi['tipe'] = 'debet';
            	$relasi['no_bukti'] = $entry['no_bukti'];
            	$relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;

            	$entry_relasi[] = $relasi;
            }

            $relasi_kredit = array();
            for ($i=0; $i < count($akun['kas_akun_kredit']); $i++) { 
            	$relasi['akun'] = $akun['kas_akun_kredit'][$i];
            	$relasi['jumlah'] = $akun['jumlah_akun_kredit'][$i];
            	$relasi['tipe'] = 'kredit';
            	$relasi['no_bukti'] = $entry['no_bukti'];
            	$relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;

            	$entry_relasi[] = $relasi;
            }

            
            if ($mode == 'revisi'){
                $riwayat = array();
                $kuitansi = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
                $riwayat['flag'] = $kuitansi['flag'];
                $riwayat['status'] = 5;
                $riwayat['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                $riwayat['komentar'] ='';

                $entry['status'] = 5;
                $this->Riwayat_model->add_riwayat($riwayat);

            }

            $q2 = $this->Kuitansi_model->update_kuitansi_jadi($id_kuitansi_jadi,$entry);

            $q1 = $this->Relasi_kuitansi_akun_model->update_relasi_kuitansi_akun($id_kuitansi_jadi,$entry_relasi);

            if ($q2 and $q1)
                $this->session->set_flashdata('success','Berhasil menyimpan !');
            else
                $this->session->set_flashdata('warning','Gagal menyimpan !');

            redirect('akuntansi/memorial');

        } else {
        	$this->data = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
        	$this->data['mode'] = $mode;
        	$this->data['all_unit_kerja'] = $this->Unit_kerja_model->get_all_unit_kerja();
        	$this->data['akun_kredit'] = $this->Akun_lra_model->get_akun_kredit();
        	$this->data['akun_debet'] = $this->Akun_lra_model->get_akun_debet();
			$temp_data['content'] = $this->load->view('akuntansi/memorial_edit',$this->data,true);
			$this->load->view('akuntansi/content_template',$temp_data,false);
        }
	}

	public function detail_memorial($id_kuitansi_jadi,$mode='lihat')
    {

        $isian = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
        // print_r($isian);die();
        $isian['all_unit_kerja'] = $this->data['all_unit_kerja'] = $this->Unit_kerja_model->get_all_unit_kerja();
        $isian['akun_kas'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
        $isian['akun_belanja'] = $this->Akun_belanja_rsa_model->get_all_akun_belanja();
        $isian['mode'] = $mode;

        $query_riwayat = $this->db->query("SELECT * FROM akuntansi_riwayat WHERE id_kuitansi_jadi='$id_kuitansi_jadi' ORDER BY id DESC LIMIT 0,1")->row_array();
        $isian['komentar'] = $query_riwayat['komentar'];
        // print_r($isian['akun_kas']);die();
        // $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian);

        $this->data['content'] = $this->load->view('akuntansi/memorial_detail',$isian,true);
        $this->load->view('akuntansi/content_template',$this->data,false);
    }

    public function hapus_memorial($id_kuitansi_jadi)
    {
    	$this->Memorial_model->hapus_memorial($id_kuitansi_jadi);
    }
	
}
