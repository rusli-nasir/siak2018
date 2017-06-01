<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaan extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['menu4'] = true;
        $this->cek_session_in();
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
        $this->load->model('akuntansi/Riwayat_model', 'Riwayat_model');
        $this->load->model('akuntansi/Akun_kas_rsa_model', 'Akun_kas_rsa_model');
        $this->load->model('akuntansi/Akun_belanja_rsa_model', 'Akun_belanja_rsa_model');
        $this->load->model('akuntansi/Unit_kerja_model', 'Unit_kerja_model');
        $this->load->model('akuntansi/Akun_lra_model', 'Akun_lra_model');
        $this->load->model('akuntansi/Penerimaan_model', 'Penerimaan_model');
        $this->load->model('akuntansi/Posting_model', 'Posting_model');
    }

    public function coba($value='')
    {
    	print_r($this->Penerimaan_model->generate_nomor_bukti());
    }

	public function index($id = 0){
		//search
		if(isset($_POST['keyword_penerimaan'])){
			$keyword = $this->input->post('keyword_penerimaan');
			$this->session->set_userdata('keyword_penerimaan', $keyword);		
		}else{
			if($this->session->userdata('keyword_penerimaan')!=null){
				$keyword = $this->session->userdata('keyword_penerimaan');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_by_tipe(null, null, $keyword, 'penerimaan');
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
		$config['base_url'] = site_url('akuntansi/penerimaan/index');
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

		$this->data['query'] = $this->Kuitansi_model->read_by_tipe($config['per_page'], $id, $keyword, 'penerimaan');
		
		$temp_data['content'] = $this->load->view('akuntansi/penerimaan_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function tambah(){
		$this->data['akun_kas'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
		$temp_data['content'] = $this->load->view('akuntansi/penerimaan_tambah',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function input_penerimaan()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('jenis_pembatasan_dana','Jenis Pembatasan Dana','required');
		$this->form_validation->set_rules('akun_kredit_akrual','Akun kredit (Akrual)','required');
		$this->form_validation->set_rules('akun_kredit','Akun kredit (Kas)','required');
		// $this->form_validation->set_rules('no_bukti','No. Bukti','required');
		$this->form_validation->set_rules('tanggal','Tanggal','required');
		$this->form_validation->set_rules('unit_kerja','unit_kerja','required');
		$this->form_validation->set_rules('uraian','uraian','required');
		$this->form_validation->set_rules('kas_akun_debet','Akun debet (kas)','required');
		$this->form_validation->set_rules('akun_debet_akrual','Akun debet (akrual)','required');
		$this->form_validation->set_rules('akun_debet_akrual','Akun debet (kas)','required');
		$this->form_validation->set_rules('jumlah_akun_debet','Jumlah Akun Debet','required');
		$this->form_validation->set_rules('jumlah_akun_kredit','Jumlah Akun Kredit','required|matches[jumlah_akun_debet]');

		if($this->form_validation->run())     
        {   
            $entry = $this->input->post();
            unset($entry['simpan']);
            $entry['no_bukti'] = $this->Penerimaan_model->generate_nomor_bukti();
            $entry['id_kuitansi'] = null;
            $entry['no_spm'] = null;
            $entry['jenis'] = null;
            $entry['kode_kegiatan'] = null;
            $entry['akun_debet'] = $entry['kas_akun_debet'];
            unset($entry['kas_akun_debet']);
            $entry['jumlah_debet'] = $entry['jumlah_akun_debet'];
            unset($entry['jumlah_akun_debet']);
            $entry['jumlah_kredit'] = $entry['jumlah_akun_kredit'];
            unset($entry['jumlah_akun_kredit']);
            $entry['tipe'] = 'penerimaan';
            $entry['flag'] =3;
            $entry['status'] = 4;
            
            $entry['tanggal_posting'] = date('Y-m-d H:i:s');
            $entry['tanggal_verifikasi'] = date('Y-m-d H:i:s');
            $entry['tanggal_jurnal'] = date('Y-m-d H:i:s');


            $q1 = $this->Kuitansi_model->add_kuitansi_jadi($entry);
            $q2 = $this->Posting_model->posting_kuitansi_full($q1);
            $riwayat = array();
            $riwayat['id_kuitansi_jadi'] = $q1;
            $riwayat['status'] = 4;
            $riwayat['flag'] = 3;

            $this->Riwayat_model->add_riwayat($riwayat);

            redirect('akuntansi/penerimaan');


        } else {
        	$this->data['no_bukti'] = $this->Penerimaan_model->generate_nomor_bukti();
        	$this->data['all_unit_kerja'] = $this->Unit_kerja_model->get_all_unit_kerja();
        	$this->data['akun_kas_rsa'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
        	$this->data['data_akun_debet'] = $this->Akun_lra_model->get_akun_debet();
        	$this->data['data_akun_kredit'] = $this->Akun_lra_model->get_akun_kredit();
        	// $this->data['akun_belanja'] = $this->Akun_belanja_rsa_model->get_all_akun_belanja();
			$temp_data['content'] = $this->load->view('akuntansi/penerimaan_tambah',$this->data,true);
			$this->load->view('akuntansi/content_template',$temp_data,false);
        }
	}

	public function edit_penerimaan($id_kuitansi_jadi,$mode = null)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('jenis_pembatasan_dana','Jenis Pembatasan Dana','required');
		$this->form_validation->set_rules('akun_kredit_akrual','Akun kredit (Akrual)','required');
		$this->form_validation->set_rules('akun_kredit','Akun kredit (Kas)','required');
		$this->form_validation->set_rules('tanggal','Tanggal','required');
		$this->form_validation->set_rules('unit_kerja','unit_kerja','required');
		$this->form_validation->set_rules('uraian','uraian','required');
		$this->form_validation->set_rules('kas_akun_debet','Akun debet (kas)','required');
		$this->form_validation->set_rules('akun_debet_akrual','Akun debet (akrual)','required');
		$this->form_validation->set_rules('akun_debet_akrual','Akun debet (kas)','required');
		$this->form_validation->set_rules('jumlah_akun_debet','Jumlah Akun Debet','required');
		$this->form_validation->set_rules('jumlah_akun_kredit','Jumlah Akun Kredit','required|matches[jumlah_akun_debet]');

		if($this->form_validation->run())     
        {   
            $entry = $this->input->post();
            unset($entry['simpan']);
            $entry['id_kuitansi'] = null;
            $entry['no_spm'] = null;
            $entry['jenis'] = null;
            $entry['kode_kegiatan'] = null;
            $entry['akun_debet'] = $entry['kas_akun_debet'];
            unset($entry['kas_akun_debet']);
            $entry['jumlah_debet'] = $entry['jumlah_akun_debet'];
            unset($entry['jumlah_akun_debet']);
            $entry['jumlah_kredit'] = $entry['jumlah_akun_kredit'];
            unset($entry['jumlah_akun_kredit']);
            $entry['tipe'] = 'penerimaan';

            
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

            $q2 = $q2 and $this->Posting_model->hapus_posting_full($id_kuitansi_jadi);

            $q2 = $q2 and $this->Posting_model->posting_kuitansi_full($id_kuitansi_jadi);

            if ($q2)
                $this->session->set_flashdata('success','Berhasil menyimpan !');
            else
                $this->session->set_flashdata('warning','Gagal menyimpan !');

            redirect('akuntansi/penerimaan');

        } else {
        	$this->data = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
        	// print_r($this->data);die();
        	$this->data['mode'] = $mode;
        	$this->data['all_unit_kerja'] = $this->Unit_kerja_model->get_all_unit_kerja();
        	$this->data['akun_kas_rsa'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
        	$this->data['data_akun_debet'] = $this->Akun_lra_model->get_akun_debet();
        	$this->data['data_akun_kredit'] = $this->Akun_lra_model->get_akun_kredit();
			$temp_data['content'] = $this->load->view('akuntansi/penerimaan_edit',$this->data,true);
			$this->load->view('akuntansi/content_template',$temp_data,false);
        }
	}

	public function detail_penerimaan($id_kuitansi_jadi,$mode='lihat')
    {

        $isian = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
        // print_r($isian);die();
        $isian['all_unit_kerja'] = $this->data['all_unit_kerja'] = $this->Unit_kerja_model->get_all_unit_kerja();
        $isian['data_akun_debet'] = $this->Akun_lra_model->get_akun_debet();
        $isian['akun_kas_rsa'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
        $isian['data_akun_kredit'] = $this->Akun_lra_model->get_akun_kredit();
        $isian['mode'] = $mode;

        $query_riwayat = $this->db->query("SELECT * FROM akuntansi_riwayat WHERE id_kuitansi_jadi='$id_kuitansi_jadi' ORDER BY id DESC LIMIT 0,1")->row_array();
        $isian['komentar'] = $query_riwayat['komentar'];
        // print_r($isian['akun_kas']);die();
        // $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian);

        $this->data['content'] = $this->load->view('akuntansi/penerimaan_detail',$isian,true);
        $this->load->view('akuntansi/content_template',$this->data,false);
    }

    public function hapus_penerimaan($id_kuitansi_jadi)
    {
    	$this->Penerimaan_model->hapus_penerimaan($id_kuitansi_jadi);
    	redirect('akuntansi/penerimaan');
    }
}
