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
        $this->load->model('akuntansi/Pengembalian_model', 'Pengembalian_model');
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
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10

        //Verifikasi tanggal dulu, batal upload kalau tanggal tidak memenuhi regex 2017-XX-XX

        $report_tanggal = array();
        $awal_tahun = $this->session->userdata('setting_tahun')."-01-01";
        $akhir_tahun = $this->session->userdata('setting_tahun')."-12-31";

        for ($row=11; $row <= $highestRow; $row++) { 
            if($objWorksheet->getCellByColumnAndRow(5,$row)->getValue()!=null){
                $tanggal = $objWorksheet->getCellByColumnAndRow(2,$row)->getValue();
                if(substr($tanggal, 0,1)=="'"){
                    $tanggal=substr($tanggal, 1);              
                }
                // $tanggal = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tanggal));
                $tanggal = $this->tanggal_excel_normalisasi($tanggal);
                if ($tanggal < $awal_tahun or $tanggal > $akhir_tahun){
                    $temp_report_tanggal = array();

                    $temp_report_tanggal['no_spm'] = $objWorksheet->getCellByColumnAndRow(1,$row)->getValue();
                    $temp_report_tanggal['uraian'] = $objWorksheet->getCellByColumnAndRow(5,$row)->getValue();
                    $temp_report_tanggal['tanggal'] = $tanggal;
                    $report_tanggal[] = $temp_report_tanggal;
                }
            }
        }

        if ($report_tanggal != null){
            echo "Tanggal entry dibawah tidak sesuai kriteria input : <br/>";
            foreach ($report_tanggal as $entry) {
                echo "<hr/>";
                echo "No. SPM : ".$entry['no_spm']."<br/>";
                echo "Uraian : ".$entry['uraian']."<br/>";
                echo "Tanggal terdeteksi : ".$entry['tanggal']."<br/><hr/>";
            }
            die();
        }

        //verifikasi akun dulu, batal upload kalau ada akun yang tidak terdeteksi

        $start_akun = $end_akun = 6;

        $akun = $objWorksheet->getCellByColumnAndRow($end_akun,9)->getValue();
        $array_akun = array();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumn);

        while ($akun != null and $end_akun < $highestColumn ) {
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
        // print_r($array_akun);

        if (count($array_non_akun) > 0) {
            echo "Akun di bawah ini tidak terdeteksi : <br/>";
            foreach ($array_non_akun as $entry) {
                echo "$entry<br/>";
            }
            echo "<a href='".$_SERVER['HTTP_REFERER']."''>kembali</a>";
            die();
        }

        // die('masuk ke proses');

    

        // Cari mulai kolom debet-kredit mulai dari berapa sampai berapa

        $start_akun = $end_akun = 6;

        $val = $objWorksheet->getCellByColumnAndRow($end_akun,5)->getValue();
        // die($val);
        while ($val == '' or $val == 'DEBET-KREDIT') {
            $end_akun++;
            $val = $objWorksheet->getCellByColumnAndRow($end_akun,5)->getValue();
        } 

        $start_debet = $start_akun;
        $end_debet = $end_akun - 1;

        //end Cari mulai kolom debet-kredit...

        // Cari kolom potongan dan pajak 

        $start_potongan = $end_akun;
        $val = $objWorksheet->getCellByColumnAndRow($end_akun,5)->getValue();
        while ($val == '' or $val == 'POTONGAN') {
            $end_akun++;
            $val = $objWorksheet->getCellByColumnAndRow($end_akun,5)->getValue();
        } 

        $end_potongan = $end_akun - 1;

        // Cari kolom pengembalian

        $start_pengembalian = $end_akun;
        $val = $objWorksheet->getCellByColumnAndRow($end_akun,5)->getValue();
        while ($val == '' or $val == 'PENGEMBALIAN') {
            $end_akun++;
            $val = $objWorksheet->getCellByColumnAndRow($end_akun,5)->getValue();
        } 

        $end_pengembalian = $end_akun - 1;

        // echo $objWorksheet->getCellByColumnAndRow($end_debet,9)->getValue()."<br/>";
        // echo $objWorksheet->getCellByColumnAndRow($end_potongan,9)->getValue()."<br/>";
        // echo $objWorksheet->getCellByColumnAndRow($end_pengembalian,9)->getValue()."<br/>";
        // die();
        // print_r($end_akun);die('aa');

        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumnIndex = $end_akun; // e.g. 5

        $index = 0;

        $data = array();

        for ($row=11; $row <= $highestRow; $row++) { 
            $entry = array();
            $array_relasi = array();
            $array_pajak = array();
            $array_pengembalian = array();
            $tanggal = $objWorksheet->getCellByColumnAndRow(2,$row)->getValue();
            // $tanggal = $objWorksheet->getCellByColumnAndRow(2,$row)->getOldCalculatedValue();
            // print_r($tanggal);die();
            //$tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);
            /*if($objWorksheet->getCellByColumnAndRow(2,$row)->getValue()!=null){
                $arr_tgl = explode('/', $tanggal);
                echo $row;
                print_r($arr_tgl);
                die();
                $tgl_jadi = $arr_tgl[2].'-'.$arr_tgl[1].'-'.$arr_tgl[0];
                $tanggal = $tgl_jadi;
            }*/
            if(substr($tanggal, 0,1)=="'"){
                $tanggal=substr($tanggal, 1);
            }

            
            // $tanggal = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tanggal));
            $tanggal = $this->tanggal_excel_normalisasi($tanggal);
            if(substr($tanggal, 0,4)!='2017'){
                $arr_tgl = explode('/', $objWorksheet->getCellByColumnAndRow(2,$row)->getValue());
                $tgl_jadi = $arr_tgl[2].'-'.$arr_tgl[1].'-'.$arr_tgl[0];
                $tanggal = $tgl_jadi;
            }

            if($objWorksheet->getCellByColumnAndRow(5,$row)->getValue()!=null){
                $entry['tanggal'] = $entry['tanggal_bukti'] = $tanggal;
                $entry['uraian'] = $objWorksheet->getCellByColumnAndRow(5,$row)->getValue();
                $entry['no_bukti'] = $objWorksheet->getCellByColumnAndRow(3,$row)->getValue();
                $entry['unit_kerja'] = 92;
                $entry['tipe'] = 'jurnal_umum';
                $entry['jenis'] = 'jurnal_umum';
                $entry['jenis_pembatasan_dana'] = 'terikat_temporer';

                $entry['flag'] =3;
                $entry['status'] = 4;

                $entry['tanggal_posting'] = $waktu_jurnal_umum;
                $entry['tanggal_verifikasi'] = $waktu_jurnal_umum;
                $entry['tanggal_jurnal'] = $waktu_jurnal_umum;

                // print_r($entry);die();
                // print_r($start_debet);
                // echo "|";
                // print_r($end_debet);
                // echo "==";
                // print_r($start_potongan);
                // echo "|";
                // print_r($end_potongan);
                // echo "==";
                // print_r($start_pengembalian);
                // echo "|";
                // print_r($end_pengembalian);die();
                
                for ($kolom=$start_debet; $kolom <= $end_debet; $kolom++) { 
                    $akun = $objWorksheet->getCellByColumnAndRow($kolom,9)->getValue();
                    $akun = explode('-',$akun);
                    $jumlah = $objWorksheet->getCellByColumnAndRow($kolom,$row)->getValue();
                    //sebagai debet-kas
                    if ($jumlah != 0 and $jumlah != '-') {

                        // ISI ARRAY RELASI

                        $entry_relasi['tipe'] = 'debet';
                        $entry_relasi['jenis'] = 'kas';
                        $entry_relasi['no_bukti'] = $entry['no_bukti'];
                        $entry_relasi['akun'] = $akun[0];
                        $entry_relasi['jumlah'] = $jumlah;

                        $array_relasi[] = $entry_relasi;

                        //sebagai debet-akrual
                        $entry_relasi['tipe'] = 'debet';
                        $entry_relasi['jenis'] = 'akrual';
                        $entry_relasi['no_bukti'] = $entry['no_bukti'];
                        $entry_relasi['akun'] = substr_replace($akun[0],'7',0,1);
                        $entry_relasi['jumlah'] = $jumlah;

                        $array_relasi[] = $entry_relasi;

                        //sebagai kredit-kas
                        $entry_relasi['tipe'] = 'kredit';
                        $entry_relasi['jenis'] = 'kas';
                        $entry_relasi['no_bukti'] = $entry['no_bukti'];
                        $entry_relasi['akun'] = $akun[1];
                        $entry_relasi['jumlah'] = $jumlah;

                        $array_relasi[] = $entry_relasi;

                        //sebagai kredit-akrual
                        $entry_relasi['tipe'] = 'kredit';
                        $entry_relasi['jenis'] = 'akrual';
                        $entry_relasi['no_bukti'] = $entry['no_bukti'];
                        $entry_relasi['akun'] = substr_replace($akun[1],'6',0,1);
                        $entry_relasi['jumlah'] = $jumlah;

                        $array_relasi[] = $entry_relasi;

                    }

                }

                //SUSUN RELASI POTONGAN
                $entry_pajak = array();


                for ($kolom=$start_potongan; $kolom <= $end_potongan; $kolom++) { 
                    $akun = $objWorksheet->getCellByColumnAndRow($kolom,9)->getValue();;
                    $jumlah = $objWorksheet->getCellByColumnAndRow($kolom,$row)->getValue();
                    // echo $akun. "-";
                    // echo $jumlah. "-<br/>";
                    //sebagai debet-kas
                    if ($jumlah != 0 and $jumlah != '-') {

                        // ISI ARRAY PAJAK

                        $entry_pajak['jenis'] = 'pajak';
                        $entry_pajak['no_bukti'] = $entry['no_bukti'];
                        $entry_pajak['akun'] = $akun;
                        // print_r($entry_pajak);die();                    
                        $entry_pajak['jumlah'] = $jumlah;

                        // echo $entry_pajak['jenis'].":";
                        // echo $akun.":";
                        // echo $entry['no_bukti'].":";
                        // echo $jumlah.":";

                        $array_pajak[] = $entry_pajak;
                    }

                }


                $entry_pengembalian = array();
                for ($kolom=$start_pengembalian; $kolom <= $end_pengembalian; $kolom++) { 
                    $akun = $objWorksheet->getCellByColumnAndRow($kolom,9)->getValue();;
                    $akun = explode('-',$akun);
                    $jumlah = $objWorksheet->getCellByColumnAndRow($kolom,$row)->getValue();
                    //sebagai debet-kas
                    if ($jumlah != 0 and $jumlah != '-') {

                        // ISI ARRAY RELASI

                        $entry_pengembalian['tipe'] = 'kredit';
                        $entry_pengembalian['jenis'] = 'kas';
                        $entry_pengembalian['no_bukti'] = $entry['no_bukti'];
                        $entry_pengembalian['akun'] = $akun[0];
                        $entry_pengembalian['jumlah'] = $jumlah;

                        $array_pengembalian[] = $entry_pengembalian;

                        //sebagai kredit-akrual
                        $entry_pengembalian['tipe'] = 'kredit';
                        $entry_pengembalian['jenis'] = 'akrual';
                        $entry_pengembalian['no_bukti'] = $entry['no_bukti'];
                        $entry_pengembalian['akun'] = substr_replace($akun[0],'7',0,1);
                        $entry_pengembalian['jumlah'] = $jumlah;

                        $array_pengembalian[] = $entry_pengembalian;

                        //sebagai debet-kas
                        $entry_pengembalian['tipe'] = 'debet';
                        $entry_pengembalian['jenis'] = 'kas';
                        $entry_pengembalian['no_bukti'] = $entry['no_bukti'];
                        $entry_pengembalian['akun'] = $akun[1];
                        $entry_pengembalian['jumlah'] = $jumlah;

                        $array_pengembalian[] = $entry_pengembalian;

                        //sebagai debet-akrual
                        $entry_pengembalian['tipe'] = 'debet';
                        $entry_pengembalian['jenis'] = 'akrual';
                        $entry_pengembalian['no_bukti'] = $entry['no_bukti'];
                        $entry_pengembalian['akun'] = substr_replace($akun[1],'6',0,1);
                        $entry_pengembalian['jumlah'] = $jumlah;

                        $array_pengembalian[] = $entry_pengembalian;

                    }

                }
                $data[$row]['entry'] = $entry;
                $data[$row]['relasi'] = $array_relasi;
                $data[$row]['pajak'] = $array_pajak;
                $data[$row]['pengembalian'] = $array_pengembalian;
                // print_r($array_pajak);
                // echo (count($array_pajak));
                
                // echo $start_potongan .'-'.$end_potongan;

                // print_r($data);die();

            }
        }

        // foreach ($data as $entry_data) {
        //     $entry = $entry_data['entry'];
        //     $array_relasi = $entry_data['relasi'];
        //     $array_pajak = $entry_data['pajak'];
        //     $array_pengembalian = $entry_data['pengembalian'];
        //     echo "<pre>";
        //     print_r($array_relasi);die();
        //     echo "</pre>";
        // }
        // die('aaaa');

        foreach ($data as $entry_data) {

            $entry = $entry_data['entry'];
            $array_relasi = $entry_data['relasi'];
            $array_pajak = $entry_data['pajak'];
            $array_pengembalian = $entry_data['pengembalian'];

            // print_r($array_relasi);die();

            $id_kuitansi_jadi = $this->Kuitansi_model->add_kuitansi_jadi($entry);


            if ($array_relasi != null) {
                for ($i=0;$i<count($array_relasi);$i++) {
                    $array_relasi[$i]['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                }
                $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($array_relasi);  
            }

            if ($array_pajak != null) {
                $updater = array();
                $q4 = $this->Pajak_model->insert_pajak($id_kuitansi_jadi,$array_pajak);
                $updater['id_pajak'] = $q4;
                $q5 = $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_jadi);

                $q6 = $this->Posting_model->posting_kuitansi_full($q4);
            }

            if ($array_pengembalian != null) {
                $id_kuitansi_pengembalian = $this->Pengembalian_model->insert_pengembalian($id_kuitansi_jadi);
                for ($i=0;$i<count($array_pengembalian);$i++) {
                    $array_pengembalian[$i]['id_kuitansi_jadi'] = $id_kuitansi_pengembalian;
                }
                $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($array_pengembalian);  
                $q6 = $this->Posting_model->posting_kuitansi_full($id_kuitansi_pengembalian);
            }

            $q6 = $this->Posting_model->posting_kuitansi_full($id_kuitansi_jadi);

        }


        if ($id_kuitansi_jadi) {
            redirect('akuntansi/jurnal_umum');
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
		$config['base_url'] = site_url('akuntansi/jurnal_umum/index');
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
            <select class="form-control" name="id_pajak[]">
              <option value="">Pilih Jenis</option>';
              foreach($akun_pajak->result() as $result){ 
              echo '<option value="'.$result->id_akun_pajak.'" '.($result->kode_akun==$selected ? "selected":"").'>'.$result->nama_akun.'</option>';
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
            $entry['id_pengembalian'] = 0;
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
            unset($entry['id_pajak']);
            unset($entry['persen_pajak']);

            unset($entry['kegiatan']);
            unset($entry['output']);
            unset($entry['program']);
            unset($entry['id_pengembalian']);

            // print_r($entry);die();

            $akun = $this->input->post();
            
            $entry_pajak = array();
            $array_pajak = array();
            if ($akun['id_pajak'][0] != null) {
                for ($i=0;$i < count($akun['id_pajak']);$i++) {
                    $entry_pajak['jumlah'] = $this->normal_number($akun['jumlah'][$i]);
                    $get_jenis_pajak = $this->db->query("SELECT * FROM akuntansi_pajak WHERE id_akun_pajak=".$akun['id_pajak'][$i]."")->row_array();
                    $entry_pajak['jenis_pajak'] = $get_jenis_pajak['jenis_pajak'];
                    // $entry_pajak['persen_pajak'] = $akun['persen_pajak'][$i];
                    $entry_pajak['jenis'] = 'pajak';
                    $entry_pajak['akun'] = $get_jenis_pajak['kode_akun'];

                    $array_pajak[] = $entry_pajak;
                }
            }


            $q1 = $this->Kuitansi_model->add_kuitansi_jadi($entry);

            $id_kuitansi_jadi = $q1;

            $entry_relasi = array();
            $relasi = array();
            $array_pengembalian = array();
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
          
            $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($entry_relasi);          
            
            //  input pajak

            if ($array_pajak != null) {
                $updater = array();
                $q4 = $this->Pajak_model->insert_pajak($id_kuitansi_jadi,$array_pajak);
                $updater['id_pajak'] = $q4;
                $q5 = $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_jadi);

                $q6 = $this->Posting_model->posting_kuitansi_full($q4);
            }

            //insert pengembalian di akuntansi kuitansi jadi
            if ($akun['akun_kredit_pengembalian'][0] != null) {
               $id_kuitansi_pengembalian = $this->Pengembalian_model->insert_pengembalian($id_kuitansi_jadi);

               if ($akun['akun_kredit_pengembalian'][0] != null) {
                    for ($i=0; $i < count($akun['akun_kredit_pengembalian']); $i++) { 
                        $pengembalian['akun'] = $akun['akun_kredit_pengembalian'][$i];
                        $pengembalian['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_pengembalian'][$i]);
                        $pengembalian['tipe'] = 'debet';
                        $pengembalian['no_bukti'] = $entry['no_bukti'];
                        $pengembalian['id_kuitansi_jadi'] = $id_kuitansi_pengembalian;
                        $pengembalian['jenis'] = 'kas';

                        $array_pengembalian[] = $pengembalian;
                    }
                }

                if ($akun['akun_debet_pengembalian'][0] != null) {
                    for ($i=0; $i < count($akun['akun_debet_pengembalian']); $i++) { 
                        $pengembalian['akun'] = $akun['akun_debet_pengembalian'][$i];
                        $pengembalian['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_pengembalian'][$i]);
                        $pengembalian['tipe'] = 'kredit';
                        $pengembalian['no_bukti'] = $entry['no_bukti'];
                        $pengembalian['id_kuitansi_jadi'] = $id_kuitansi_pengembalian;
                        $pengembalian['jenis'] = 'kas';

                        $array_pengembalian[] = $pengembalian;
                    }
                }

                if ($akun['akun_kredit_pengembalian_akrual'][0] != null) {
                    for ($i=0; $i < count($akun['akun_kredit_pengembalian_akrual']); $i++) { 
                        $pengembalian['akun'] = $akun['akun_kredit_pengembalian_akrual'][$i];
                        $pengembalian['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_pengembalian_akrual'][$i]);
                        $pengembalian['tipe'] = 'debet';
                        $pengembalian['no_bukti'] = $entry['no_bukti'];
                        $pengembalian['id_kuitansi_jadi'] = $id_kuitansi_pengembalian;
                        $pengembalian['jenis'] = 'akrual';

                        $array_pengembalian[] = $pengembalian;
                    }
                }

                if ($akun['akun_debet_pengembalian_akrual'][0] != null) {
                    for ($i=0; $i < count($akun['akun_debet_pengembalian_akrual']); $i++) { 
                        $pengembalian['akun'] = $akun['akun_debet_pengembalian_akrual'][$i];
                        $pengembalian['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_pengembalian_akrual'][$i]);
                        $pengembalian['tipe'] = 'kredit';
                        $pengembalian['no_bukti'] = $entry['no_bukti'];
                        $pengembalian['id_kuitansi_jadi'] = $id_kuitansi_pengembalian;
                        $pengembalian['jenis'] = 'akrual';

                        $array_pengembalian[] = $pengembalian;
                    }
                }
                // print_r($array_pengembalian);die();
                $q2 = $this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($array_pengembalian);
                $updater = array();
                $updater['id_pengembalian'] = $id_kuitansi_pengembalian;
                $q5 = $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_jadi);
                $q6 = $this->Posting_model->posting_kuitansi_full($id_kuitansi_pengembalian);
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
            // $query_konversi = $this->db->query("SELECT * FROM akuntansi_akun_konversi WHERE dari='".$result->kode_akun."'");
            // if($query_konversi->num_rows() > 0){
            //     $konversi = $query_konversi->row_array();
            //     $query_aset = $this->db->query("SELECT * FROM akuntansi_aset_6 WHERE akun_6='".$konversi['dari']."'")->row_array();
            //     $data[$i]['akun_6'] = $query_aset['akun_6'];
            //     $data[$i]['nama'] = $query_aset['nama'];
            // }else{
            $result->kode_akun[0] = '7';
            $data[$i]['akun_6'] = $result->kode_akun;
            $data[$i]['nama'] = $result->nama_akun;
            // }
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
            // print_r($this->input->post());die();
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

            unset($entry['akun_kredit_pengembalian']);
            unset($entry['akun_kredit_pengembalian_akrual']);
            unset($entry['akun_debet_pengembalian']);
            unset($entry['akun_debet_pengembalian_akrual']);
            unset($entry['jumlah_akun_kredit_pengembalian']);
            unset($entry['jumlah_akun_kredit_pengembalian_akrual']);
            unset($entry['jumlah_akun_debet_pengembalian']);
            unset($entry['jumlah_akun_debet_pengembalian_akrual']);

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
            unset($entry['id_pajak']);
            unset($entry['persen_pajak']);
            unset($entry['id_pengembalian']);

            // print_r($entry);die();


            $akun = $this->input->post();

            // print_r($akun);die();

            $entry_pajak = array();
            $array_pajak = array();
            if ($akun['id_pajak'][0] != null and isset($akun['id_pajak'])) {
                for ($i=0;$i < count($akun['id_pajak']);$i++) {
                    $entry_pajak['jumlah'] = $this->normal_number($akun['jumlah'][$i]);
                    $get_jenis_pajak = $this->db->query("SELECT * FROM akuntansi_pajak WHERE id_akun_pajak=".$akun['id_pajak'][$i]."")->row_array();
                    $entry_pajak['jenis_pajak'] = $get_jenis_pajak['jenis_pajak'];
                    $entry_pajak['jenis'] = 'pajak';
                    $entry_pajak['akun'] = $get_jenis_pajak['kode_akun'];

                    $array_pajak[] = $entry_pajak;
                }
            }

            $entry_pengembalian = array();
            if ($akun['akun_kredit_pengembalian'][0] != null) {
                // $id_kuitansi_pengembalian = $this->Pengembalian_model->insert_pengembalian($id_kuitansi_jadi);
                for ($i=0; $i < count($akun['akun_kredit_pengembalian']); $i++) { 


                    $pengembalian['akun'] = $akun['akun_kredit_pengembalian'][$i];
                    $pengembalian['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_pengembalian'][$i]);
                    $pengembalian['tipe'] = 'kredit';
                    $pengembalian['no_bukti'] = $entry['no_bukti'];
                    $pengembalian['id_kuitansi_jadi'] = $id_kuitansi_pengembalian;
                    $pengembalian['jenis'] = 'kas';

                    $array_pengembalian[] = $pengembalian;
                }

                for ($i=0; $i < count($akun['akun_debet_pengembalian']); $i++) { 



                    $pengembalian['akun'] = $akun['akun_debet_pengembalian'][$i];
                    $pengembalian['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_pengembalian'][$i]);
                    $pengembalian['tipe'] = 'debet';
                    $pengembalian['no_bukti'] = $entry['no_bukti'];
                    $pengembalian['id_kuitansi_jadi'] = $id_kuitansi_pengembalian;
                    $pengembalian['jenis'] = 'kas';

                    $array_pengembalian[] = $pengembalian;
                }

                for ($i=0; $i < count($akun['akun_kredit_pengembalian_akrual']); $i++) { 

                    $pengembalian['akun'] = $akun['akun_kredit_pengembalian_akrual'][$i];
                    $pengembalian['jumlah'] = $this->normal_number($akun['jumlah_akun_kredit_pengembalian_akrual'][$i]);
                    $pengembalian['tipe'] = 'kredit';
                    $pengembalian['no_bukti'] = $entry['no_bukti'];
                    $pengembalian['id_kuitansi_jadi'] = $id_kuitansi_pengembalian;
                    $pengembalian['jenis'] = 'akrual';

                    $array_pengembalian[] = $pengembalian;
                }

                for ($i=0; $i < count($akun['akun_kredit_pengembalian_akrual']); $i++) { 

                    $pengembalian['akun'] = $akun['akun_debet_pengembalian_akrual'][$i];
                    $pengembalian['jumlah'] = $this->normal_number($akun['jumlah_akun_debet_pengembalian_akrual'][$i]);
                    $pengembalian['tipe'] = 'debet';
                    $pengembalian['no_bukti'] = $entry['no_bukti'];
                    $pengembalian['id_kuitansi_jadi'] = $id_kuitansi_pengembalian;
                    $pengembalian['jenis'] = 'akrual';

                    $array_pengembalian[] = $pengembalian;
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
                $updater = array();
                $updater['id_pajak'] = 0;
                $q5 = $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_jadi);
            }

            if ($temp_kuitansi['id_pengembalian'] != 0){
                $this->Pengembalian_model->hapus_pengembalian($temp_kuitansi['id_pengembalian']);
            }

            if ($array_pengembalian != null) {
                $updater = array();
                $q7 = $this->Pengembalian_model->insert_pengembalian_with_array($id_kuitansi_jadi,$array_pengembalian);
                $updater['id_pengembalian'] = $q7;
                $q5 = $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_jadi);

                $q8 = $this->Posting_model->posting_kuitansi_full($q7);

            }else{
                $updater = array();
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
                $data['hasil'][$i]['kode_akun'] = $result->akun;
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

    public function tanggal_excel_normalisasi($tanggal){
        $arr_tgl = explode('/', $tanggal);
        if (!isset($arr_tgl[2])){
            $tanggal_normal = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tanggal)); 
        }else{
            $tanggal_normal = $arr_tgl[2].'-'.$arr_tgl[1].'-'.$arr_tgl[0];
        }
        return $tanggal_normal;
    }
    
}
