<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal_umum extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['menu6'] = true;
        $this->cek_session_in();
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
        $this->load->model('akuntansi/Riwayat_model', 'Riwayat_model');
        $this->load->model('akuntansi/Akun_kas_rsa_model', 'Akun_kas_rsa_model');
        $this->load->model('akuntansi/Akun_belanja_rsa_model', 'Akun_belanja_rsa_model');
        $this->load->model('akuntansi/Unit_kerja_model', 'Unit_kerja_model');
        $this->load->model('akuntansi/Jurnal_umum_model', 'Jurnal_umum_model');
        $this->load->model('akuntansi/Relasi_kuitansi_akun_model', 'Relasi_kuitansi_akun_model');
        $this->load->model('akuntansi/Akun_lra_model', 'Akun_lra_model');
        $this->load->model('akuntansi/Akun_model', 'Akun_model');
        $this->load->model('akuntansi/Posting_model', 'Posting_model');
        $this->load->model('akuntansi/Memorial_model', 'Memorial_model');
        $this->load->model('akuntansi/Pajak_model', 'Pajak_model');
        $this->load->library('excel');
    }

    public function coba()
    {
        $this->Posting_model->posting_kuitansi_full(16);
    }

    public function import_jurnal_umum()
    {
        $this->load->library('excel');
        $temp_data['content'] = $this->load->view('akuntansi/form_upload_jurnal_umum',null,true);
        $this->load->view('akuntansi/content_template',$temp_data,false);
    }

    public function do_upload($alert = null,$notice = null)
    {
        
        $config['upload_path'] = './assets/akuntansi/upload';
        $config['allowed_types'] = 'xlsx|xls';
        $config['max_size'] = '20000';
        // $config['max_width']  = '1024';
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        // die('aaa');
        

        if ( ! $this->upload->do_upload())
        {
            echo $this->upload->display_errors('<p>', '</p>');
            die('gagal mengupload');
        }
        else
        {
            $data = $this->upload->data();
            $this->import_jurnal_umum_backend($data['full_path']);
        }
    }

    public function import_jurnal_umum_backend($file)
    {
        $inputFileType = PHPExcel_IOFactory::identify($file);

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);

        $sal_jurnal_umum = $this->Akun_model->get_kode_sal_jurnal_umum();
        $waktu_jurnal_umum = date('Y-m-d H:i:s');

        $i = 0;

        $data = array();


        $objWorksheet = $objPHPExcel->getActiveSheet();

        //verifikasi akun dulu, batal upload kalau ada akun yang tidak terdeteksi

        $start_akun = $end_akun = 6;

        $akun = $objWorksheet->getCellByColumnAndRow($end_akun,9)->getValue();
        $array_akun = array();

        while ($akun != null and $akun != 'TOTAL NILAI MAK') {
            if (strpos($akun, '-') == -1) {
                $array_akun[] = $akun;
            } else {
                $array_akun = array_merge($array_akun,explode('-', $akun));
            }
            $end_akun++;
            $akun = $objWorksheet->getCellByColumnAndRow($end_akun,9)->getValue();
        }

        $array_non_akun = array();
        foreach ($array_akun as $entry) {
            $nama = $this->Akun_model->get_nama_akun($entry);
            if ($nama == '-' or $nama == null) {
                $array_non_akun[] = $entry;
            }
        }

        if (count($array_non_akun) > 0) {
            echo "Akun di bawah ini tidak terdeteksi : <br/>";
            foreach ($array_non_akun as $entry) {
                echo "$entry<br/>";
            }
            echo "<a href='".$_SERVER['HTTP_REFERER']."''>kembali</a>";
            die();
        }

        die('masuk ke proses');

        // print_r($array_akun);
    

        // Cari mulai kolom debet mulai dari berapa sampai berapa

        $start_akun = $end_akun = 6;

        $val = $objWorksheet->getCellByColumnAndRow($end_akun,6)->getValue();
        while ($val == '' or $val == 'DEBET') {
            $end_akun++;
            $val = $objWorksheet->getCellByColumnAndRow($end_akun,6)->getValue();
        } 

        $end_akun = $end_akun - 1;

        //end Cari mulai kolom debet...

        // print_r($end_akun);die('aa');

        $highestRow = $objWorksheet->getHighestRow() - 4; // e.g. 10
        $highestColumnIndex = $end_akun; // e.g. 5

        $index = 0;

        for ($row=10; $row <= $highestRow; $row++) { 
            $entry = array();
            $tanggal = $objWorksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue();
            $tanggal = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tanggal)); 
            $entry['tanggal'] = $entry['tanggal_bukti'] = $tanggal;
            $entry['uraian'] = $objWorksheet->getCellByColumnAndRow(5,$row)->getValue();
            $entry['no_bukti'] = $objWorksheet->getCellByColumnAndRow(3,$row)->getValue();
            $entry['unit_kerja'] = 92;
            $entry['tipe'] = 'jurnal_umum';
            $entry['jenis'] = 'jurnal_umum';
            $entry['jenis_pembatasan_dana'] = 'tidak_terikat';

            $entry['flag'] =3;
            $entry['status'] = 4;

            $entry['tanggal_posting'] = $waktu_jurnal_umum;
            $entry['tanggal_verifikasi'] = $waktu_jurnal_umum;
            $entry['tanggal_jurnal'] = $waktu_jurnal_umum;
            
            for ($kolom=$start_akun; $kolom <= $end_akun; $kolom++) { 
                $entry['akun_kredit'] = $sal_jurnal_umum;
                $entry['akun_debet'] = $objWorksheet->getCellByColumnAndRow($kolom,7)->getCalculatedValue();
                $entry['akun_kredit_akrual'] = '911101';
                $entry['akun_debet_akrual'] = substr_replace($entry['akun_kredit'],'7',0,1);
                $entry['jumlah_debet'] = $objWorksheet->getCellByColumnAndRow($kolom,$row)->getValue();
                $entry['jumlah_kredit'] = $entry['jumlah_debet'];

                if ($entry['jumlah_debet'] != 0){
                    $data[] = $entry;
                }

            }
        }
        print_r($data);
        die();

        if ($this->Jurnal_umum_model->insert_penerimaan_batch($data)) {
            redirect('akuntansi/penerimaan');
        } else {
            die('gagal menginput');
        }

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

		$total_data = $this->Kuitansi_model->read_by_tipe(null, null, $keyword, 'jurnal_umum');
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

		$this->data['query'] = $this->Kuitansi_model->read_by_tipe($config['per_page'], $id, $keyword, 'jurnal_umum');
		
		$temp_data['content'] = $this->load->view('akuntansi/jurnal_umum_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function tambah(){
		$this->data['akun_kas'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
		$temp_data['content'] = $this->load->view('akuntansi/memorial_tambah',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function get_output($kode_kegiatan){
        $query = $this->Memorial_model->read_output($kode_kegiatan);
        echo '<option value="">Pilih Output</option>';
        foreach($query->result() as $result){
            echo '<option value="'.$result->kode_output.'">'.$result->kode_output.' - '.$result->nama_output.'</option>';
        }
    }

    public function get_program($kode_kegiatan, $kode_output){
        $query = $this->Memorial_model->read_program($kode_kegiatan, $kode_output);
        echo '<option value="">Pilih Program</option>';
        foreach($query->result() as $result){
            echo '<option value="'.$result->kode_program.'">'.$result->kode_program.' - '.$result->nama_program.'</option>';
        }
    }
    
    public function add_pajak($selected=null){
        $akun_pajak = $this->Pajak_model->get_pajak();
        echo ' <tr>
          <td>
            <select class="form-control" name="jenis_pajak[]">
              <option value="">Pilih Jenis</option>';
              foreach($akun_pajak->result() as $result){ 
              echo '<option value="'.$result->jenis_pajak.'" '.($result->jenis_pajak==$selected ? "selected":"").'>'.$result->jenis_pajak.'</option>';
              }
        echo '</select>
          </td>
          <td><input type="text" name="jumlah[]" pattern="[0-9.,]{1,20}" maxlength="20" class="form-control jumlah number_pajak"></td>
          <td><button type="button" class="del_pajak btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button></td>
        </tr>';
    }

	public function input_jurnal_umum()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('jenis_pembatasan_dana','Jenis Pembatasan Dana','required');
		$this->form_validation->set_rules('akun_kredit_akrual[]','Akun kredit (Akrual)','required');
		$this->form_validation->set_rules('akun_debet_akrual[]','Akun debet (Akrual)','required');
		$this->form_validation->set_rules('no_bukti','No. Bukti','required');
		$this->form_validation->set_rules('no_spm','No. SPM','required');
		$this->form_validation->set_rules('tanggal','Tanggal','required');
		$this->form_validation->set_rules('jenis','Jenis','required');
		$this->form_validation->set_rules('unit_kerja','unit_kerja','required');
		$this->form_validation->set_rules('uraian','uraian','required');
		// $this->form_validation->set_rules('tipe','Tipe','required');
		// $this->form_validation->set_rules('kas_akun_debet','Akun debet (kas)','required');
		// $this->form_validation->set_rules('akun_debet_akrual','Akun debet (akrual)','required');
		// $this->form_validation->set_rules('jumlah_akun_debet','Jumlah Akun Debet','required');
        $this->form_validation->set_rules('jumlah_akun_kredit_akrual[]','Jumlah Akun Kredit','required');
		$this->form_validation->set_rules('jumlah_akun_debet_akrual[]','Jumlah Akun debet','required');
        
		if($this->form_validation->run())     
        {   
            $entry = $this->input->post();
            unset($entry['simpan']);
            $entry['id_kuitansi'] = null;
            $entry['akun_debet'] = $entry['akun_debet_kas'][0];
            unset($entry['akun_debet_kas']);
            $entry['akun_kredit'] = $entry['akun_kredit_kas'][0];
            unset($entry['akun_kredit_kas']);

            $entry['akun_debet_akrual'] = $entry['akun_debet_akrual'][0];
            unset($entry['akun_debet_akrual']);
            $entry['akun_kredit_akrual'] = $entry['akun_kredit_akrual'][0];
            unset($entry['akun_kredit_akrual']);

            //pengembalian
            $entry['akun_debet_pengembalian'] = $entry['akun_debet_pengembalian'][0];
            unset($entry['akun_debet_pengembalian']);
            $entry['akun_kredit_pengembalian'] = $entry['akun_kredit_pengembalian'][0];
            unset($entry['akun_kredit_pengembalian']);
            $entry['akun_debet_pengembalian_akrual'] = $entry['akun_debet_pengembalian_akrual'][0];
            unset($entry['akun_debet_pengembalian_akrual']);
            $entry['akun_kredit_pengembalian_akrual'] = $entry['akun_kredit_pengembalian_akrual'][0];
            unset($entry['akun_kredit_pengembalian_akrual']);

            $entry['jumlah_debet'] = array_sum($entry['jumlah_akun_debet_akrual']);
            unset($entry['jumlah_akun_debet_akrual']);
            $entry['jumlah_kredit'] = array_sum($entry['jumlah_akun_kredit_akrual']);
            unset($entry['jumlah_akun_kredit_akrual']);
            unset($entry['jumlah_akun_kredit_kas']);
            unset($entry['jumlah_akun_debet_kas']);

            //pengembalian
            $entry['jumlah_debet_pengembalian'] = array_sum($entry['jumlah_akun_debet_pengembalian']);
            unset($entry['jumlah_akun_debet_pengembalian']);
            unset($entry['jumlah_debet_pengembalian']);          
            $entry['jumlah_kredit_pengembalian'] = array_sum($entry['jumlah_akun_kredit_pengembalian']);
            unset($entry['jumlah_akun_kredit_pengembalian']);
            unset($entry['jumlah_kredit_pengembalian']);
            $entry['jumlah_akun_debet_pengembalian_akrual'] = array_sum($entry['jumlah_akun_debet_pengembalian_akrual']);
            unset($entry['jumlah_akun_debet_pengembalian_akrual']);
            $entry['jumlah_akun_kredit_pengembalian_akrual'] = array_sum($entry['jumlah_akun_kredit_pengembalian_akrual']);
            unset($entry['jumlah_akun_kredit_pengembalian_akrual']);

            $entry['flag'] = 3;
            $entry['status'] = 4;
            $entry['tipe'] = 'jurnal_umum';
            $entry['kode_user'] = $this->session->userdata('kode_user');
            // $entry['kode_kegiatan'] = $this->input->post('unit_kerja').'000000'.$this->input->post('kegiatan').$this->input->post('output').$this->input->post('program');
            $entry['tanggal_posting'] = date('Y-m-d H:i:s');
            $entry['tanggal_verifikasi'] = date('Y-m-d H:i:s');
            $entry['tanggal_jurnal'] = date('Y-m-d H:i:s');
            
            unset($entry['jumlah']);
            unset($entry['jenis_pajak']);
            unset($entry['persen_pajak']);

            unset($entry['kegiatan']);
            unset($entry['output']);
            unset($entry['program']);

            // print_r($entry);die();

            $akun = $this->input->post();
            
            $entry_pajak = array();
            $array_pajak = array();
            if ($akun['jenis_pajak'][0] != null) {
                for ($i=0;$i < count($akun['jenis_pajak']);$i++) {
                    $entry_pajak['jumlah'] = $this->normal_number($akun['jumlah'][$i]);
                    $entry_pajak['jenis_pajak'] = $akun['jenis_pajak'][$i];
                    // $entry_pajak['persen_pajak'] = $akun['persen_pajak'][$i];
                    $entry_pajak['jenis'] = 'pajak';
                    $entry_pajak['akun'] = $this->Pajak_model->get_akun_by_jenis($entry_pajak['jenis_pajak'])['kode_akun'];

                    $array_pajak[] = $entry_pajak;
                }
            }


            $q1 = $this->Kuitansi_model->add_kuitansi_jadi($entry);

            $id_kuitansi_jadi = $q1;

            $entry_relasi = array();
            $relasi = array();
            $pengembalian = array();
            for ($i=0; $i < count($akun['akun_debet_akrual']); $i++) { 
                $relasi['akun'] = $akun['akun_debet_akrual'][$i];
                $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_akrual'][$i]);
                $relasi['tipe'] = 'debet';
                $relasi['no_bukti'] = $entry['no_bukti'];
                $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                $relasi['jenis'] = 'akrual';

                $entry_relasi[] = $relasi;
            }

            for ($i=0; $i < count($akun['akun_kredit_akrual']); $i++) { 
                $relasi['akun'] = $akun['akun_kredit_akrual'][$i];
                $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_akrual'][$i]);
                $relasi['tipe'] = 'kredit';
                $relasi['no_bukti'] = $entry['no_bukti'];
                $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                $relasi['jenis'] = 'akrual';

                $entry_relasi[] = $relasi;
            }

            if ($akun['akun_debet_kas'][0] != null) {
                for ($i=0; $i < count($akun['akun_debet_kas']); $i++) { 
                    $relasi['akun'] = $akun['akun_debet_kas'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_kas'][$i]);
                    $relasi['tipe'] = 'debet';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'kas';

                    $entry_relasi[] = $relasi;
                }
            }

            if ($akun['akun_kredit_kas'][0] != null) {
                for ($i=0; $i < count($akun['akun_kredit_kas']); $i++) { 
                	$relasi['akun'] = $akun['akun_kredit_kas'][$i];
                	$relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_kas'][$i]);
                	$relasi['tipe'] = 'kredit';
                	$relasi['no_bukti'] = $entry['no_bukti'];
                	$relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'kas';

                	$entry_relasi[] = $relasi;
                }
            }

            if ($akun['akun_kredit_pengembalian'][0] != null) {
                for ($i=0; $i < count($akun['akun_kredit_pengembalian']); $i++) { 
                    $relasi['akun'] = $akun['akun_kredit_pengembalian'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_pengembalian'][$i]);
                    $relasi['tipe'] = 'debit';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'kas';

                    $entry_relasi_pengembalian[] = $pengembalian;
                }
            }

            if ($akun['akun_debet_pengembalian'][0] != null) {
                for ($i=0; $i < count($akun['akun_debet_pengembalian']); $i++) { 
                    $relasi['akun'] = $akun['akun_debet_pengembalian'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_pengembalian'][$i]);
                    $relasi['tipe'] = 'kredit';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'kas';

                    $entry_relasi_pengembalian[] = $pengembalian;
                }
            }

            if ($akun['akun_kredit_pengembalian_akrual'][0] != null) {
                for ($i=0; $i < count($akun['akun_kredit_pengembalian_akrual']); $i++) { 
                    $relasi['akun'] = $akun['akun_kredit_pengembalian_akrual'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_pengembalian_akrual'][$i]);
                    $relasi['tipe'] = 'debit';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'akrual';

                    $entry_relasi_pengembalian[] = $pengembalian;
                }
            }

            if ($akun['akun_debet_pengembalian_akrual'][0] != null) {
                for ($i=0; $i < count($akun['akun_debet_pengembalian_akrual']); $i++) { 
                    $relasi['akun'] = $akun['akun_debet_pengembalian_akrual'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_pengembalian_akrual'][$i]);
                    $relasi['tipe'] = 'kredit';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'akrual';

                    $entry_relasi_pengembalian[] = $pengembalian;
                }
            }

            
            $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($entry_relasi);
            
            //  input pajak

            if ($array_pajak != null) {
                $updater = array();
                $q4 = $this->Pajak_model->insert_pajak($id_kuitansi_jadi,$array_pajak);
                $updater['id_pajak'] = $q4;
                $q5 = $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_jadi);

                $q6 = $this->Posting_model->posting_kuitansi_full($q4);
            }

            if ($array_pajak != null) {
                $updater = array();
                $q4 = $this->Pajak_model->insert_pajak($id_kuitansi_jadi,$array_pajak);
                $updater['id_pajak'] = $q4;
                $q5 = $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_jadi);

                $q6 = $this->Posting_model->posting_kuitansi_full($q4);
            }

            $q3 = $this->Posting_model->posting_kuitansi_full($id_kuitansi_jadi);

            $riwayat = array();
            $riwayat['id_kuitansi_jadi'] = $q1;
            $riwayat['status'] = 'posted';
            $riwayat['flag'] = 3;

            $this->Riwayat_model->add_riwayat($riwayat);

            redirect('akuntansi/jurnal_umum');


        } else {
        	$this->data['all_unit_kerja'] = $this->Unit_kerja_model->get_all_unit_kerja();
//            $this->data['akun_kredit'] = $this->Akun_lra_model->get_akun_kredit();
//            $this->data['akun_debet'] = $this->Akun_lra_model->get_akun_debet();
            $this->data['akun_kas'] = $this->get_akun_kas();
            $this->data['akun_akrual'] = $this->get_akun_akrual();
            $this->data['akun_pajak'] = $this->Pajak_model->get_pajak();

            //kode kegiatan
            $this->data['kegiatan'] = $this->Memorial_model->read_akun_rba('kegiatan');
			$temp_data['content'] = $this->load->view('akuntansi/jurnal_umum_tambah',$this->data,true);
			$this->load->view('akuntansi/content_template',$temp_data,false);
        }
	}
    
    public function get_akun_kas(){
        $query_1 = $this->Memorial_model->read_akun('akuntansi_aset_6');
        $query_2 = $this->Memorial_model->read_akun('akuntansi_hutang_6');
        $query_3 = $this->Memorial_model->read_akun('akuntansi_aset_bersih_6');
        $query_4 = $this->Memorial_model->read_akun('akuntansi_lra_6');
        $query_5 = $this->Memorial_model->read_akun_rba('akun_belanja');
        $query_6 = $this->Memorial_model->read_akun('akuntansi_pembiayaan_6');
        $query_7 = $this->Memorial_model->read_akun('akuntansi_sal_6');

        $i = 0;
        foreach($query_1->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }
        foreach($query_2->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }
        foreach($query_3->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }
        foreach($query_4->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }
        foreach($query_5->result() as $result){
            $data[$i]['akun_6'] = $result->kode_akun;
            $data[$i]['nama'] = $result->nama_akun;
            $i++;
        }
        foreach($query_6->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }
        foreach($query_7->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }

        return $data;
    }

    public function get_akun_akrual(){
        $query_1 = $this->Memorial_model->read_akun('akuntansi_aset_6');
        $query_2 = $this->Memorial_model->read_akun('akuntansi_hutang_6');
        $query_3 = $this->Memorial_model->read_akun('akuntansi_aset_bersih_6');
        $query_4 = $this->Memorial_model->read_akun('akuntansi_lra_6');
        $query_5 = $this->Memorial_model->read_akun_rba('akun_belanja');
        $query_6 = $this->Memorial_model->read_akun('akuntansi_pembiayaan_6');
        $query_7 = $this->Memorial_model->read_akun('akuntansi_sal_6');

        $i = 0;
        foreach($query_1->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }
        foreach($query_2->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }
        foreach($query_3->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }
        foreach($query_4->result() as $result){
            $result->akun_6[0] = '6';
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }
        foreach($query_5->result() as $result){
            $result->kode_akun[0] = '7';
            $data[$i]['akun_6'] = $result->kode_akun;
            $data[$i]['nama'] = $result->nama_akun;
            $i++;
        }
        foreach($query_6->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }
        foreach($query_7->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }

        return $data;
    }

	public function edit_jurnal_umum($id_kuitansi_jadi,$mode = null)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('jenis_pembatasan_dana','Jenis Pembatasan Dana','required');
		// $this->form_validation->set_rules('akun_kredit_akrual','Akun kredit (Akrual)','required');
		// $this->form_validation->set_rules('akun_kredit','Akun kredit (Kas)','required');
		$this->form_validation->set_rules('no_bukti','No. Bukti','required');
		// $this->form_validation->set_rules('no_spm','No. SPM','required');
		$this->form_validation->set_rules('tanggal','Tanggal','required');
		$this->form_validation->set_rules('jenis','Jenis','required');
		$this->form_validation->set_rules('unit_kerja','unit_kerja','required');
        $this->form_validation->set_rules('uraian','uraian','required');
		$this->form_validation->set_rules('kode_kegiatan','kode_kegiatan','required');
		// $this->form_validation->set_rules('tipe','Tipe','required');
		// $this->form_validation->set_rules('kas_akun_debet','Akun debet (kas)','required');
		// $this->form_validation->set_rules('akun_debet_akrual','Akun debet (akrual)','required');
		// $this->form_validation->set_rules('jumlah_akun_debet','Jumlah Akun Debet','required');
		// $this->form_validation->set_rules('jumlah_akun_kredit','Jumlah Akun Kredit','required|matches[jumlah_akun_debet]');

		if($this->form_validation->run())     
        {   
            $delete_relasi_lama = $this->db->query("DELETE FROM akuntansi_relasi_kuitansi_akun WHERE id_kuitansi_jadi='".$id_kuitansi_jadi."'");
            
             $entry = $this->input->post();
            unset($entry['simpan']);
            $entry['id_kuitansi'] = null;
            //$entry['no_bukti'] = $this->Memorial_model->generate_nomor_bukti();
            $entry['akun_debet'] = $entry['akun_debet_kas'][0];
            $entry['akun_kredit_akrual'] = $entry['akun_kredit_akrual'][0];
            $entry['akun_debet_akrual'] = $entry['akun_debet_akrual'][0];
            $entry['akun_kredit'] = $entry['akun_kredit_kas'][0];
            unset($entry['akun_kredit_kas']);
            unset($entry['akun_debet_kas']);
            unset($entry['akun_kredit_akrual']);
            unset($entry['akun_debet_akrual']);
            $entry['jumlah_debet'] = array_sum($entry['jumlah_akun_debet_kas']);
            unset($entry['jumlah_akun_debet_akrual']);
            unset($entry['jumlah_akun_debet_kas']);
            $entry['jumlah_kredit'] = array_sum($entry['jumlah_akun_kredit_akrual']);
            unset($entry['jumlah_akun_kredit_akrual']);
            unset($entry['jumlah_akun_kredit_kas']);
            $entry['tipe'] = 'jurnal_umum';
            $entry['flag'] = 3;
            $entry['status'] = 4;
            $entry['kode_user'] = $this->session->userdata('kode_user');
            // $entry['kode_kegiatan'] = $this->input->post('unit_kerja').'000000'.$this->input->post('kegiatan').$this->input->post('output').$this->input->post('program');

            unset($entry['kegiatan']);
            unset($entry['output']);
            unset($entry['program']);

            unset($entry['jumlah']);
            unset($entry['jenis_pajak']);
            unset($entry['persen_pajak']);


            $akun = $this->input->post();

            // print_r($akun);die();

            $entry_pajak = array();
            $array_pajak = array();
            if ($akun['jenis_pajak'][0] != null and isset($akun['jenis_pajak'])) {
                for ($i=0;$i < count($akun['jenis_pajak']);$i++) {
                    $entry_pajak['jumlah'] = $this->normal_number($akun['jumlah'][$i]);
                    $entry_pajak['jenis_pajak'] = $akun['jenis_pajak'][$i];
                    $entry_pajak['jenis'] = 'pajak';
                    $entry_pajak['akun'] = $this->Pajak_model->get_akun_by_jenis($entry_pajak['jenis_pajak'])['kode_akun'];

                    $array_pajak[] = $entry_pajak;
                }
            }

            $q1 = $this->Kuitansi_model->edit_kuitansi_jadi($entry, $id_kuitansi_jadi);


            $entry_relasi = array();
            $relasi = array();

            for ($i=0; $i < count($akun['akun_debet_akrual']); $i++) { 
                $relasi['akun'] = $akun['akun_debet_akrual'][$i];
                $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_akrual'][$i]);
                $relasi['tipe'] = 'debet';
                $relasi['no_bukti'] = $entry['no_bukti'];
                $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                $relasi['jenis'] = 'akrual';

                $entry_relasi[] = $relasi;
            }

            for ($i=0; $i < count($akun['akun_kredit_akrual']); $i++) { 
                $relasi['akun'] = $akun['akun_kredit_akrual'][$i];
                $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_akrual'][$i]);
                $relasi['tipe'] = 'kredit';
                $relasi['no_bukti'] = $entry['no_bukti'];
                $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                $relasi['jenis'] = 'akrual';

                $entry_relasi[] = $relasi;
            }

            if ($akun['akun_debet_kas'][0] != null) {
                for ($i=0; $i < count($akun['akun_debet_kas']); $i++) { 
                    $relasi['akun'] = $akun['akun_debet_kas'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_kas'][$i]);
                    $relasi['tipe'] = 'debet';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'kas';

                    $entry_relasi[] = $relasi;
                }
            }

            if ($akun['akun_kredit_kas'][0] != null) {
                for ($i=0; $i < count($akun['akun_kredit_kas']); $i++) { 
                    $relasi['akun'] = $akun['akun_kredit_kas'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_kas'][$i]);
                    $relasi['tipe'] = 'kredit';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'kas';

                    $entry_relasi[] = $relasi;
                }
            }

            // print_r($entry_relasi);die();

            $temp_kuitansi = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);

            if ($temp_kuitansi['id_pajak'] != 0) {
                $this->Pajak_model->hapus_pajak($temp_kuitansi['id_pajak']);
            }

            if ($array_pajak != null) {
                $updater = array();
                $q4 = $this->Pajak_model->insert_pajak($id_kuitansi_jadi,$array_pajak);
                $updater['id_pajak'] = $q4;
                $q5 = $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_jadi);

                $q6 = $this->Posting_model->posting_kuitansi_full($q4);
            } else {
                $updater['id_pajak'] = 0;
                $q5 = $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_jadi);
            }

            
            $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($entry_relasi);

            $this->Posting_model->hapus_posting_full($id_kuitansi_jadi);
            $q3 = $this->Posting_model->posting_kuitansi_full($id_kuitansi_jadi);
         

            // $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($entry_relasi);

            // $q2 = $this->Kuitansi_model->update_kuitansi_jadi($id_kuitansi_jadi,$entry);

            // if ($q1 and $q2)
            //     $this->session->set_flashdata('success','Berhasil menyimpan !');
            // else
            //     $this->session->set_flashdata('warning','Gagal menyimpan !');

            // die('selesai');

            redirect('akuntansi/jurnal_umum');

        } else {
        	$this->data = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
        	$this->data['mode'] = $mode;
        	$this->data['all_unit_kerja'] = $this->Unit_kerja_model->get_all_unit_kerja();
        	$this->data['akun_kas'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
        	$this->data['akun_belanja'] = $this->Akun_belanja_rsa_model->get_all_akun_belanja();
//            $this->data['akun_kredit'] = $this->Akun_lra_model->get_akun_kredit();
//            $this->data['akun_debet'] = $this->Akun_lra_model->get_akun_debet();
            $this->data['akun_kas'] = $this->get_akun_kas();
            $this->data['akun_akrual'] = $this->get_akun_akrual();
            $this->data['akun_pajak'] = $this->Pajak_model->get_pajak();

            //kode kegiatan
            $this->data['kegiatan'] = $this->Memorial_model->read_akun_rba('kegiatan');
            //kode output
            $this->data['output'] = $this->Memorial_model->read_output(substr($this->data['kode_kegiatan'],8,2));
            //kode program
            $this->data['program'] = $this->Memorial_model->read_program(substr($this->data['kode_kegiatan'],8,2), substr($this->data['kode_kegiatan'],10,2));

            $query_kas_kredit = $this->Memorial_model->read_akun_relasi(array('id_kuitansi_jadi'=>$id_kuitansi_jadi, 'tipe'=>'kredit','jenis'=>'kas'))->result();
            $query_kas_debet = $this->Memorial_model->read_akun_relasi(array('id_kuitansi_jadi'=>$id_kuitansi_jadi, 'tipe'=>'debet','jenis'=>'kas'))->result();
            $query_akrual_kredit = $this->Memorial_model->read_akun_relasi(array('id_kuitansi_jadi'=>$id_kuitansi_jadi, 'tipe'=>'kredit','jenis'=>'akrual'))->result();
            $query_akrual_debet = $this->Memorial_model->read_akun_relasi(array('id_kuitansi_jadi'=>$id_kuitansi_jadi, 'tipe'=>'debet','jenis'=>'akrual'))->result();

            $this->data['total_kas_kredit'] = 0;
            $this->data['total_kas_debet'] = 0;
            $this->data['total_akrual_kredit'] = 0;
            $this->data['total_akrual_debet'] = 0;
            foreach($query_kas_kredit as $result){
                $this->data['total_kas_kredit'] += $result->jumlah;
            }
            foreach($query_kas_debet as $result){
                $this->data['total_kas_debet'] += $result->jumlah;
            }
            foreach($query_akrual_kredit as $result){
                $this->data['total_akrual_kredit'] += $result->jumlah;
            }
            foreach($query_akrual_debet as $result){
                $this->data['total_akrual_debet'] += $result->jumlah;
            }

			$temp_data['content'] = $this->load->view('akuntansi/jurnal_umum_edit',$this->data,true);
			$this->load->view('akuntansi/content_template',$temp_data,false);
        }
	}

	public function detail_jurnal_umum($id_kuitansi_jadi,$mode='lihat')
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

        $this->data['content'] = $this->load->view('akuntansi/jurnal_umum_detail',$isian,true);
        $this->load->view('akuntansi/content_template',$this->data,false);
    }

    public function hapus_jurnal_umum($id_kuitansi_jadi)
    {
    	$this->Jurnal_umum_model->hapus_jurnal_umum($id_kuitansi_jadi);
    }
    
    public function get_kas_debet($id_kuitansi_jadi, $tipe, $jenis){
        if($tipe=='pajak'){
            $query = $this->Relasi_kuitansi_akun_model->get_relasi_kuitansi_akun($jenis);
            $result = (object) $query;

            $i=0;
            foreach($result as $result){
                $result = (object) $result;
                $data['hasil'][$i]['akun'] = $result->jenis_pajak;
                $data['hasil'][$i]['persen_pajak'] = $result->persen_pajak;
                $data['hasil'][$i]['jumlah'] = $result->jumlah;
                $i++;
            }

            header('Content-Type: application/json');
            echo json_encode($data);
            
        }else{
            $query = $this->Memorial_model->read_akun_relasi(array('id_kuitansi_jadi'=>$id_kuitansi_jadi, 'tipe'=>$tipe, 'jenis'=>$jenis));
            $total = $query->num_rows();
            $result = $query->result();

            $i=0;
            foreach($result as $result){
                $data['hasil'][$i]['akun'] = $result->akun;
                $data['hasil'][$i]['jumlah'] = $result->jumlah;
                $i++;
            }

            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
	
}
