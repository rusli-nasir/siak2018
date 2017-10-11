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
        $this->load->model('akuntansi/Akun_model', 'Akun_model');
        $this->load->model('akuntansi/Penerimaan_model', 'Penerimaan_model');
        $this->load->model('akuntansi/Posting_model', 'Posting_model');
        $this->load->library('excel');
    }

    public function import_penerimaan()
    {
        $this->load->library('excel');
        $temp_data['content'] = $this->load->view('akuntansi/form_upload_penerimaan',null,true);
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
            $this->import_penerimaan_backend($data['full_path']);
        }
    }

    public function import_penerimaan_backend($file)
    {
        
        $inputFileType = PHPExcel_IOFactory::identify($file);

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);

        $sal_penerimaan = $this->Akun_model->get_kode_sal_penerimaan();
        $waktu_penerimaan = date('Y-m-d H:i:s');

        $i = 0;

        $data = array();
        $array_akun = array();

        $start_akun = $end_akun = 4;
        while ($objPHPExcel->setActiveSheetIndex($i)){
            $objWorksheet = $objPHPExcel->getActiveSheet();

            $array_akun[] = $objWorksheet->getTitle();
            $val = $objWorksheet->getCellByColumnAndRow($end_akun,1)->getValue();
            while ($val != '') {
                $array_akun[] = $val;
                $end_akun++;
                $val = $objWorksheet->getCellByColumnAndRow($end_akun,1)->getValue();
            }

            if($i <$objPHPExcel->getSheetCount()-1 ) $i++; else break; 
        }

        $array_non_akun = array();
        foreach ($array_akun as $entry) {
            // print_r($entry);die();
            $entry = (string)$entry;
            $nama = $this->Akun_model->get_nama_akun($entry);
            if ($nama == '-' or $nama == null) {
                $array_non_akun[] = $entry;
            }
        }
        // print_r($array_akun);

        if (count($array_non_akun) > 0) {
            echo "Akun di bawah ini tidak terdeteksi : <br/>";
            foreach ($array_non_akun as $entry) {
                echo "$entry<br/>";
            }
            echo "<a href='".$_SERVER['HTTP_REFERER']."''>kembali</a>";
            die();
        }


        $i = 0;

        while ($objPHPExcel->setActiveSheetIndex($i)){

            $objWorksheet = $objPHPExcel->getActiveSheet();
            
            $akun_debet_akrual = $objWorksheet->getTitle();

            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
            // $highestColumnIndex = 4; // e.g. 5

            $index = 0;


            for ($row=2; $row <= $highestRow; $row++) { 
                $entry = array();
                $entry_relasi = array();
                $array_relasi = array();
                $array_data = array();
                $tanggal = $this->tanggal_excel_normalisasi($objWorksheet->getCellByColumnAndRow(1,$row)->getValue());
                if(substr($tanggal, 0, 1)=='-'){
                    $tanggal = $objWorksheet->getCellByColumnAndRow(1,$row)->getCalculatedValue();
                    $tanggal = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tanggal));
                }
                //$tanggal = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tanggal)); 
                $entry['tanggal'] = $entry['tanggal_bukti'] = $tanggal;
                $entry['uraian'] = $objWorksheet->getCellByColumnAndRow(3,$row)->getValue();
                $entry['no_bukti'] = $objWorksheet->getCellByColumnAndRow(2,$row)->getValue();
                // $entry['akun_debet'] = $sal_penerimaan;
                // $entry['akun_kredit'] = $akun_kredit_kas;
                // $entry['akun_debet_akrual'] = $akun_debet_akrual;
                // $entry['akun_kredit_akrual'] = substr_replace($akun_kredit_kas,'6',0,1);
                // $entry['jumlah_debet'] = $objWorksheet->getCellByColumnAndRow(4,$row)->getValue();
                // $entry['jumlah_kredit'] = $entry['jumlah_debet'];
                $entry['unit_kerja'] = 9999;
                $entry['tipe'] = 'penerimaan';
                $entry['jenis'] = 'penerimaan';
                $entry['jenis_pembatasan_dana'] = 'tidak_terikat';

                for ($kolom=$start_akun; $kolom <= $end_akun; $kolom++) { 
                    $akun = $objWorksheet->getCellByColumnAndRow($kolom,1)->getValue();
                    $jumlah = $objWorksheet->getCellByColumnAndRow($kolom,$row)->getValue();
                    if ($jumlah != 0 and $jumlah != '-') {
                        if($jumlah<0){
                            //negatif
                            $entry_relasi['tipe'] = 'kredit';
                            $entry_relasi['jenis'] = 'kas';
                            $entry_relasi['no_bukti'] = $entry['no_bukti'];
                            $entry_relasi['akun'] = $sal_penerimaan;
                            $entry_relasi['jumlah'] = abs($jumlah);

                            $array_relasi[] = $entry_relasi;

                            //sebagai debet-akrual
                            $entry_relasi['tipe'] = 'kredit';
                            $entry_relasi['jenis'] = 'akrual';
                            $entry_relasi['no_bukti'] = $entry['no_bukti'];
                            $entry_relasi['akun'] = $akun_debet_akrual;
                            $entry_relasi['jumlah'] = abs($jumlah);

                            $array_relasi[] = $entry_relasi;

                            //sebagai kredit-kas
                            $entry_relasi['tipe'] = 'debet';
                            $entry_relasi['jenis'] = 'kas';
                            $entry_relasi['no_bukti'] = $entry['no_bukti'];
                            $entry_relasi['akun'] = $akun;
                            $entry_relasi['jumlah'] = abs($jumlah);

                            $array_relasi[] = $entry_relasi;

                            //sebagai kredit-akrual
                            $entry_relasi['tipe'] = 'debet';
                            $entry_relasi['jenis'] = 'akrual';
                            $entry_relasi['no_bukti'] = $entry['no_bukti'];
                            $entry_relasi['akun'] = substr_replace($akun,'6',0,1);
                            $entry_relasi['jumlah'] = abs($jumlah);

                            $array_relasi[] = $entry_relasi;
                        }else{
                            //positif
                            $entry_relasi['tipe'] = 'debet';
                            $entry_relasi['jenis'] = 'kas';
                            $entry_relasi['no_bukti'] = $entry['no_bukti'];
                            $entry_relasi['akun'] = $sal_penerimaan;
                            $entry_relasi['jumlah'] = $jumlah;

                            $array_relasi[] = $entry_relasi;

                            //sebagai debet-akrual
                            $entry_relasi['tipe'] = 'debet';
                            $entry_relasi['jenis'] = 'akrual';
                            $entry_relasi['no_bukti'] = $entry['no_bukti'];
                            $entry_relasi['akun'] = $akun_debet_akrual;
                            $entry_relasi['jumlah'] = $jumlah;

                            $array_relasi[] = $entry_relasi;

                            //sebagai kredit-kas
                            $entry_relasi['tipe'] = 'kredit';
                            $entry_relasi['jenis'] = 'kas';
                            $entry_relasi['no_bukti'] = $entry['no_bukti'];
                            $entry_relasi['akun'] = $akun;
                            $entry_relasi['jumlah'] = $jumlah;

                            $array_relasi[] = $entry_relasi;

                            //sebagai kredit-akrual
                            $entry_relasi['tipe'] = 'kredit';
                            $entry_relasi['jenis'] = 'akrual';
                            $entry_relasi['no_bukti'] = $entry['no_bukti'];
                            $entry_relasi['akun'] = substr_replace($akun,'6',0,1);
                            $entry_relasi['jumlah'] = $jumlah;

                            $array_relasi[] = $entry_relasi;
                        }
                    }
                }

                $entry['flag'] =3;
                $entry['status'] = 4;

                $entry['tanggal_posting'] = $waktu_penerimaan;
                $entry['tanggal_verifikasi'] = $waktu_penerimaan;
                $entry['tanggal_jurnal'] = $waktu_penerimaan;

                $entry_data['entry'] = $entry;
                $entry_data['relasi'] = $array_relasi;

                $data[] = $entry_data;
            }

            if($i <$objPHPExcel->getSheetCount()-1 ) $i++; else break; 

        }

        foreach ($data as $entry_data) {

            $entry = $entry_data['entry'];
            $array_relasi = $entry_data['relasi'];

            $id_kuitansi_jadi = $this->Kuitansi_model->add_kuitansi_jadi($entry);

            if ($array_relasi != null) {
                for ($i=0;$i<count($array_relasi);$i++) {
                    $array_relasi[$i]['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                }
                $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($array_relasi);  
            }

            $q6 = $this->Posting_model->posting_kuitansi_full($id_kuitansi_jadi);

        }

        if ($id_kuitansi_jadi) {
            redirect('akuntansi/penerimaan');
        } else {
            die('gagal menginput');
        }

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
        $this->data['total_a'] = $total;
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
		// $this->form_validation->set_rules('akun_kredit_akrual','Akun kredit (Akrual)','required');
		// $this->form_validation->set_rules('akun_kredit','Akun kredit (Kas)','required');
		// $this->form_validation->set_rules('no_bukti','No. Bukti','required');
		$this->form_validation->set_rules('tanggal','Tanggal','required');
		// $this->form_validation->set_rules('unit_kerja','unit_kerja','required');
		$this->form_validation->set_rules('uraian','uraian','required');
		// $this->form_validation->set_rules('kas_akun_debet','Akun debet (kas)','required');
		// $this->form_validation->set_rules('akun_debet_akrual','Akun debet (akrual)','required');
		// $this->form_validation->set_rules('akun_debet_akrual','Akun debet (kas)','required');
		// $this->form_validation->set_rules('jumlah_akun_debet','Jumlah Akun Debet','required');
		// $this->form_validation->set_rules('jumlah_akun_kredit','Jumlah Akun Kredit','required');

		if($this->form_validation->run())     
        {   
            $entry = $this->input->post();
            $akun = $entry;

            unset($entry['simpan']);
            unset($entry['akun_debet_kas']);
            unset($entry['jumlah_akun_debet_kas']);
            unset($entry['akun_kredit_kas']);
            unset($entry['jumlah_akun_kredit_kas']);
            unset($entry['akun_debet_akrual']);
            unset($entry['jumlah_akun_debet_akrual']);
            unset($entry['akun_kredit_akrual']);
            unset($entry['jumlah_akun_kredit_akrual']);

            $entry['no_bukti'] = $this->Penerimaan_model->generate_nomor_bukti();
            $entry['id_kuitansi'] = null;
            $entry['no_spm'] = null;
            $entry['jenis'] = 'penerimaan';
            $entry['kode_kegiatan'] = null;
            $entry['tipe'] = 'penerimaan';
            $entry['flag'] =3;
            $entry['status'] = 4;
            $entry['unit_kerja'] = 9999;
            $date_penerimaan = date('Y-m-d H:i:s');
            $entry['tanggal_posting'] = $date_penerimaan;
            $entry['tanggal_verifikasi'] = $date_penerimaan;
            $entry['tanggal_jurnal'] = $date_penerimaan;

            // print_r($entry);

            $q1 = $this->Kuitansi_model->add_kuitansi_jadi($entry);

            $id_kuitansi_jadi = $q1;

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

            $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($entry_relasi);

            $q3 = $this->Posting_model->posting_kuitansi_full($q1);
            $riwayat = array();
            $riwayat['id_kuitansi_jadi'] = $q1;
            $riwayat['status'] = 4;
            $riwayat['flag'] = 3;

            $this->Riwayat_model->add_riwayat($riwayat);

            redirect('akuntansi/penerimaan');


        } else {
        	$this->data['no_bukti'] = $this->Penerimaan_model->generate_nomor_bukti();
        	$this->data['all_unit_kerja'] = $this->Unit_kerja_model->get_all_unit_kerja();
            // $this->data['akun_kas_rsa'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
        	$this->data['akun_kas_akrual'] = $this->Akun_model->get_akun_penerimaan();
            $this->data['akun_kas_akrual'][]= $this->Akun_model->get_akun_sal_penerimaan();

            $this->data['sal_penerimaan'][] = $this->Akun_model->get_akun_sal_penerimaan();
        	// $this->data['data_akun_debet'] = array_merge($this->Akun_lra_model->get_akun_debet(),$this->Akun_model->get_akun_sal_penerimaan());
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
        $this->form_validation->set_rules('tanggal','Tanggal','required');
        $this->form_validation->set_rules('uraian','uraian','required');

		if($this->form_validation->run())     
        {   
            $temp_kuitansi = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
            $entry = $this->input->post();
            // print_r($entry);die();
            $akun = $entry;
            $relas = array();

            $delete_relasi_lama = $this->db->query("DELETE FROM akuntansi_relasi_kuitansi_akun WHERE id_kuitansi_jadi='".$id_kuitansi_jadi."'");

            unset($entry['simpan']);
            unset($entry['akun_debet_kas']);
            unset($entry['jumlah_akun_debet_kas']);
            unset($entry['akun_kredit_kas']);
            unset($entry['jumlah_akun_kredit_kas']);
            unset($entry['akun_debet_akrual']);
            unset($entry['jumlah_akun_debet_akrual']);
            unset($entry['akun_kredit_akrual']);
            unset($entry['jumlah_akun_kredit_akrual']);

            $entry['no_bukti'] = $temp_kuitansi['no_bukti'];
            $entry['id_kuitansi'] = null;
            $entry['no_spm'] = null;
            $entry['jenis'] = 'penerimaan';
            $entry['kode_kegiatan'] = null;
            $entry['tipe'] = 'penerimaan';
            $entry['flag'] =3;
            $entry['status'] = 4;
            $entry['unit_kerja'] = 9999;
            $date_penerimaan = date('Y-m-d H:i:s');
            $entry['tanggal_posting'] = $date_penerimaan;
            $entry['tanggal_verifikasi'] = $date_penerimaan;
            $entry['tanggal_jurnal'] = $date_penerimaan;

            $q1 = $this->Kuitansi_model->edit_kuitansi_jadi($entry, $id_kuitansi_jadi);


            // $id_kuitansi_jadi = $q1;

            for ($i=0; $i < count($akun['akun_debet_akrual']); $i++) { 
                if ($akun['jumlah_akun_debet_akrual'][$i] != null){
                    $relasi['akun'] = $akun['akun_debet_akrual'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_akrual'][$i]);
                    $relasi['tipe'] = 'debet';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'akrual';

                    $entry_relasi[] = $relasi;
                }
            }

            for ($i=0; $i < count($akun['akun_kredit_akrual']); $i++) { 
                if ($akun['jumlah_akun_kredit_akrual'][$i] != null){
                    $relasi['akun'] = $akun['akun_kredit_akrual'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_akrual'][$i]);
                    $relasi['tipe'] = 'kredit';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'akrual';

                    $entry_relasi[] = $relasi;
                }
            }

            for ($i=0; $i < count($akun['akun_debet_kas']); $i++) { 
                if ($akun['jumlah_akun_debet_kas'][$i]){
                    $relasi['akun'] = $akun['akun_debet_kas'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_kas'][$i]);
                    $relasi['tipe'] = 'debet';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'kas';

                    $entry_relasi[] = $relasi;
                }
            }

            for ($i=0; $i < count($akun['akun_kredit_kas']); $i++) { 
                if ($akun['jumlah_akun_kredit_kas'][$i]){
                    $relasi['akun'] = $akun['akun_kredit_kas'][$i];
                    $relasi['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_kas'][$i]);
                    $relasi['tipe'] = 'kredit';
                    $relasi['no_bukti'] = $entry['no_bukti'];
                    $relasi['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                    $relasi['jenis'] = 'kas';

                    $entry_relasi[] = $relasi;
                }
            }
// 
            // print_r($entry);
            // print_r($entry_relasi);
            // die();

            $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($entry_relasi);

            $this->Posting_model->hapus_posting_full($id_kuitansi_jadi);
            
            $q3 = $this->Posting_model->posting_kuitansi_full($id_kuitansi_jadi);

            $riwayat = array();
            $riwayat['id_kuitansi_jadi'] = $q1;
            $riwayat['status'] = 4;
            $riwayat['flag'] = 3;

            $this->Riwayat_model->add_riwayat($riwayat);

            redirect('akuntansi/penerimaan');




        } else {
        	$this->data = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
        	// print_r($this->data);die();
        	$this->data['mode'] = $mode;
        	$this->data['all_unit_kerja'] = $this->Unit_kerja_model->get_all_unit_kerja();
        	// $this->data['akun_kas_rsa'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
            $this->data['akun_kas_akrual'] = $this->Akun_model->get_akun_penerimaan();
            $this->data['akun_kas_akrual'][]=$this->Akun_model->get_akun_sal_penerimaan();
            $this->data['sal_penerimaan'][] = $this->Akun_model->get_akun_sal_penerimaan();
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
        // $isian['akun_kas_rsa'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
        $isian['akun_kas_akrual'] = $this->Akun_model->get_akun_penerimaan();
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

    public function reset_search(){
        $this->session->unset_userdata('keyword_penerimaan');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function tanggal_excel_normalisasi($tanggal){
        $arr_tgl = explode('/', $tanggal);
        $tanggal_normal = $arr_tgl[2].'-'.$arr_tgl[1].'-'.$arr_tgl[0];
        return $tanggal_normal;
    }
}
