<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggaran extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->cek_session_in();
      $this->load->model('akuntansi/Anggaran_model', 'Anggaran_model');	
      $this->load->model('akuntansi/Unit_kerja_model', 'Unit_kerja_model');	
      $this->db2 = $this->load->database('rba',TRUE);
	}

	public function index()
	{
		
	}

	public function upload_pendapatan_temporer()
	{
		  $data['destination'] = 'akuntansi/Anggaran/do_upload_pendapatan_temporer/';
        $temp_data['content'] = $this->load->view('akuntansi/form_upload_cek',$data,true);
        $this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function do_upload_pendapatan_temporer()
	{
		$this->load->library('excel');
		$config['upload_path'] = './assets/akuntansi/upload';
		$config['allowed_types'] = 'xls|xlsx';
		$config['max_size'] = '20000';
		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			echo $this->upload->display_errors('<p>', '</p>');
			die('gagal mengupload');
		}

		$data = $this->upload->data();
        //print_r($data);die();

		$file = $data['full_path'];

		$inputFileType = PHPExcel_IOFactory::identify($file);

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);


		$data = array();

		$i = 0;
		$objPHPExcel->setActiveSheetIndex($i);
		$sheet = $objPHPExcel->getSheet($i); 
		$objWorksheet = $objPHPExcel->getActiveSheet();
            	$highest_row = $objWorksheet->getHighestRow(); // e.g. 10
            	// print_r($highest_row);die();
            	$tahun = $this->session->userdata('setting_tahun'); 	
            	$start_row = 5;

            	for ($row=$start_row; $row <= $highest_row-1; $row++) { 	
            		if ( $objWorksheet->getCellByColumnAndRow(2,$row)->getValue() == '') {
            			$unit = $objWorksheet->getCellByColumnAndRow(1,$row)->getValue(); 
            			$kode_unit = $this->get_unit($unit);
            			$row++;
            		}
            		$akun = $objWorksheet->getCellByColumnAndRow(2,$row)->getValue();
            		$anggaran = $objWorksheet->getCellByColumnAndRow(4,$row)->getValue();

            		$data = array(
            			'kode_unit' =>  $kode_unit,
            			'akun' =>  $akun,
            			'anggaran' =>  $anggaran,
            			'tahun' =>  $tahun,
            			'jenis_pembatasan_dana' =>  'terikat_temporer',
            		);
            		$this->Anggaran_model->upload_pendapatan_temporer($data);
            	}

            	$this->session->set_flashdata('success', 'Data berhasil diterima!');
            	redirect('/akuntansi/Anggaran/upload_pendapatan_temporer/');
            //  echo "<pre>";

            // print_r($data);die();

            // unlink($file);
            // die($file);
    }

	public function do_upload_pendapatan_temporerx()
    {
    		$this->load->library('excel');
            $config['upload_path'] = './assets/akuntansi/upload';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '20000';
            PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload())
            {
                echo $this->upload->display_errors('<p>', '</p>');
                die('gagal mengupload');
            }

            $data = $this->upload->data();

            $file = $data['full_path'];

            $inputFileType = PHPExcel_IOFactory::identify($file);

            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($file);


    		$data = array();

    		$i = 1;
         $objPHPExcel->setActiveSheetIndex($i);
         $sheet = $objPHPExcel->getSheet($i); 
            	$objWorksheet = $objPHPExcel->getActiveSheet();
            	$highest_row = $objWorksheet->getHighestRow(); // e.g. 10
            	// print_r($highest_row);die();

        		$start_row = 2;

        		$unit=0;
        		for ($row=$start_row; $row <= $highest_row; $row++) { 	
        			if ( $objWorksheet->getCellByColumnAndRow(7,$row)->getValue() != '') {
        				// $unit = $objWorksheet->getCellByColumnAndRow('1',$row)->getValue(); 
        			$kode_unit = $objWorksheet->getCellByColumnAndRow(0,$row)->getValue();
        			$akun6_digit='';
        			for ($i=1; $i < 6 ; $i++) { 
        				$akun_digit = $objWorksheet->getCellByColumnAndRow($i,$row)->getValue();
        				$akun6_digit = $akun6_digit.$akun_digit;
        			}
        			$akun = $akun6_digit;
        			$anggaran = $objWorksheet->getCellByColumnAndRow(7,$row)->getValue();
        			$tahun = $this->session->userdata('setting_tahun'); 

        			$data = array(
        				'kode_unit' =>  $kode_unit,
        				'akun' =>  $akun,
        				'anggaran' =>  $anggaran,
        				'tahun' =>  $tahun,
        				'jenis_pembatasan_dana' =>  'terikat_temporer',
        			);
        			$this->Anggaran_model->upload_pendapatan_temporer($data);
        			}
        		}

        		$this->session->set_flashdata('success', 'Data berhasil diterima!');
				redirect('/akuntansi/Anggaran/upload_pendapatan_temporer/');
            // echo "<pre>";

            // print_r($data);die();

            // unlink($file);
            // die($file);
    }

    public function get_unit($unit){
    	$query = $this->Unit_kerja_model->get_all_unit_kerja();
    	foreach ($query as $data) {
    		if ($unit == $data['alias'] or $unit == $data['nama_unit']) {
    			$unit = $data['kode_unit'];
    		}else{
    			$unit = NULL;
    		}
    	}
    	return $unit;
    }

}

/* End of file Anggaran.php */
/* Location: ./application/controllers/akuntansi/Anggaran.php */