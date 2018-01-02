<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['menu8'] = true;
        $this->cek_session_in();
        $this->load->model('akuntansi/Saldo_model', 'Saldo_model');
        $this->load->model('akuntansi/Akun_model', 'Akun_model');
        $this->data['db2'] = $this->load->database('rba',TRUE);
    }

	public function index($akun = 1){
		if($akun==1){
			$this->data['tab1'] = true;
		}else if($akun==2){
			$this->data['tab2'] = true;
		}else{
			$this->data['tab3'] = true;
		}
		
		$this->data['query'] = $this->Saldo_model->read_by_akun($akun);

		$temp_data['content'] = $this->load->view('akuntansi/saldo_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function tambah(){
		$this->data['tab1'] = true;

		$this->data['query_1'] = $this->Saldo_model->read_akun_6('akuntansi_aset_6', null);
		$this->data['query_2'] = $this->Saldo_model->read_akun_6('akuntansi_hutang_6', null);
		$this->data['query_3'] = $this->Saldo_model->read_akun_6('akuntansi_aset_bersih_6', null);

		$temp_data['content'] = $this->load->view('akuntansi/saldo_tambah',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function tambah_proses(){
		$kode_akun = $this->input->post('kode_akun');
		$tahun = $this->input->post('tahun');
		$saldo_awal = $this->input->post('saldo_awal');
		//$saldo_kredit_awal = $this->input->post('saldo_kredit_awal');

		//cek
		$query_cek = $this->Saldo_model->read(array('akun'=>$kode_akun, 'tahun'=>$tahun));
		if($query_cek->num_rows() == 0){
			$data = array(
				'akun'=>$kode_akun,
				'tahun'=>$tahun,
				'saldo_awal'=>$this->normal_number($saldo_awal)/*,
				'saldo_sekarang'=>$saldo_awal,
				'saldo_kredit_awal'=>$saldo_kredit_awal,
				'saldo_kredit_sekarang'=>$saldo_kredit_awal*/
			);

			$insert = $this->Saldo_model->create($data);
			if($insert){
				redirect(site_url('akuntansi/saldo/tambah?balasan=1'));
			}else{
				redirect(site_url('akuntansi/saldo/tambah?balasan=2'));
			}
		}else{
			redirect(site_url('akuntansi/saldo/tambah?balasan=3'));
		}	
	}

	public function edit($id){
		$this->data['tab1'] = true;

		$this->data['id'] = $id;
		$this->data['query'] = $this->Saldo_model->read(array('id'=>$id))->row_array();
		$this->data['query_1'] = $this->Saldo_model->read_akun_6('akuntansi_aset_6', null);
		$this->data['query_2'] = $this->Saldo_model->read_akun_6('akuntansi_hutang_6', null);
		$this->data['query_3'] = $this->Saldo_model->read_akun_6('akuntansi_aset_bersih_6', null);

		$temp_data['content'] = $this->load->view('akuntansi/saldo_edit',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function edit_proses($id){
		$kode_akun = $this->input->post('kode_akun');
		$tahun = $this->input->post('tahun');
		$saldo_awal = $this->input->post('saldo_awal');
		/*$saldo_sekarang = $this->input->post('saldo_sekarang');
		$saldo_kredit_awal = $this->input->post('saldo_kredit_awal');
		$saldo_kredit_sekarang = $this->input->post('saldo_kredit_sekarang');*/
		$query = $this->Saldo_model->read(array('id'=>$id))->row_array();

		$data = array(
				'akun'=>$kode_akun,
				'tahun'=>$tahun,
				'saldo_awal'=>$this->normal_number($saldo_awal)/*,
				'saldo_sekarang'=>$saldo_sekarang,
				'saldo_kredit_awal'=>$saldo_kredit_awal,
				'saldo_kredit_sekarang'=>$saldo_kredit_sekarang*/
			);

		//cek
		if($kode_akun==$query['akun'] AND $tahun==$query['tahun']){
			$insert = $this->Saldo_model->update(array('id'=>$id), $data);
		}else{
			$query_cek = $this->Saldo_model->read(array('akun'=>$kode_akun, 'tahun'=>$tahun));
			if($query_cek->num_rows() == 0){
				$insert = $this->Saldo_model->update(array('id'=>$id), $data);
			}else{
				redirect(site_url('akuntansi/saldo/edit/'.$id.'/?balasan=3'));
			}
		}

		if($insert){
			redirect(site_url('akuntansi/saldo/edit/'.$id.'/?balasan=1'));
		}else{
			redirect(site_url('akuntansi/saldo/edit/'.$id.'/?balasan=2'));
		}
	}

	public function delete($id){
		$delete = $this->Saldo_model->delete(array('id'=>$id));
		if($delete){
			redirect(site_url('akuntansi/saldo/index/?balasan=3'));
		}else{
			redirect(site_url('akuntansi/saldo/index/?balasan=4'));
		}
	}

	public function upload_saldo($mode = null)
	{
		$data['destination'] = 'akuntansi/saldo/do_upload_saldo/'.$mode;
        $temp_data['content'] = $this->load->view('akuntansi/form_upload_cek',$data,true);
        $this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function do_upload_saldo($mode = null)
    {
    		$this->load->library('excel');
            $config['upload_path'] = './assets/akuntansi/upload';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '20000';

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload())
            {
                echo $this->upload->display_errors('<p>', '</p>');
                die('gagal mengupload');
            }

            $data = $this->upload->data();

            $file = $data['full_path'];

            $tabel_akun = array(
            	1 => 'akuntansi_aset_6',
            	2 => 'akuntansi_hutang_6',
            	3 => 'akuntansi_aset_bersih_6',
            );

            $inputFileType = PHPExcel_IOFactory::identify($file);

            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($file);


    		$data = array();

    		$i = 0;

            while ($objPHPExcel->setActiveSheetIndex($i)){
            	$objWorksheet = $objPHPExcel->getActiveSheet();
            	$highest_row = $objWorksheet->getHighestRow(); // e.g. 10
        		$highestColumnIndex = 7; // e.g. 5

        		$kolom_nama = 5;
        		$kolom_debet = 6;
        		$kolom_kredit = 7;

        		$start_row = 6;


        		for ($row=$start_row; $row <= $highest_row; $row++) { 	
        			if ( $objWorksheet->getCellByColumnAndRow(1,$row)->getValue() != '' and $objWorksheet->getCellByColumnAndRow(4,$row)->getValue() != '' and $objWorksheet->getCellByColumnAndRow(5,$row)->getValue() != 'dst') {
	        			$string_akun = "";
	        			for ($col=0; $col <= 4; $col++) { 
	        				$string_akun .= $objWorksheet->getCellByColumnAndRow($col,$row)->getValue();
	        			}
	        			$first_akun = $objWorksheet->getCellByColumnAndRow(0,$row)->getValue();
		        		$entry_data = array();
		        		$entry_data['akun'] = $string_akun;
		        		$entry_data['saldo_awal'] = $objWorksheet->getCellByColumnAndRow($kolom_debet,$row)->getValue() - $objWorksheet->getCellByColumnAndRow($kolom_kredit,$row)->getValue();
		        		if ($first_akun == 2 or $first_akun == 3){
		        			$entry_data['saldo_awal'] *= -1;
		        		}
		        		$entry_data['nama_akun'] = $objWorksheet->getCellByColumnAndRow($kolom_nama,$row)->getValue();
		        		$entry_data['nama_asal'] = $this->Akun_model->get_nama_akun($entry_data['akun']);

		        		$data[] = $entry_data;

	        			$entry_saldo = $entry_data;
	        			$entry_saldo['tahun'] = 2017;
	        			unset($entry_saldo['nama_akun']);
	        			unset($entry_saldo['nama_asal']);
	        			if ($entry_data['saldo_awal'] != 0) {
	        				$this->db->insert('akuntansi_saldo',$entry_saldo);
	        			}
	        			if ($entry_data['nama_akun'] != $entry_data['nama_asal']){
	        				$this->db->where('akun_6',$entry_saldo['akun']);
	        				$this->db->update($tabel_akun[$first_akun],array('nama' => $entry_data['nama_asal']));
	        			}

	        		}
        		}

        		$index = 0;

            	if($i <$objPHPExcel->getSheetCount()-1 ) $i++; else break; 
            }

            echo "<pre>";

            print_r($data);

            unlink($file);
            die($file);
    }
}
