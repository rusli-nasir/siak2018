<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['menu9'] = true;
        $this->cek_session_in();
        $this->cek_session_in();
        $this->load->model('akuntansi/Laporan_model', 'Laporan_model');
        $this->load->model('akuntansi/Akun_model', 'Akun_model');
        $this->data['db2'] = $this->load->database('rba',TRUE);

        $this->load->library('excel');
    }

	public function buku_besar($id = 0){
		$this->data['tab1'] = true;

		$this->data['query_debet'] = $this->Laporan_model->read_buku_besar_group('akun_debet');
		$this->data['query_debet_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_debet_akrual');
		$this->data['query_kredit'] = $this->Laporan_model->read_buku_besar_group('akun_kredit');
		$this->data['query_kredit_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_kredit_akrual');

		$temp_data['content'] = $this->load->view('akuntansi/buku_besar_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function coba($value='')
	{
		$akun = array(1,2,3,4,5,6,7,8,9);


		// $tabel_relasi = $this->Laporan_model->get_akun_tabel_relasi($akun);
		// $tabel_utama = $this->Laporan_model->get_akun_tabel_utama($akun);

		// print_r($tabel_relasi);

		// print_r($tabel_utama + $tabel_relasi);
		// print_r(array_merge($tabel_utama,$tabel_relasi));
		print_r($this->Laporan_model->get_data_buku_besar($akun));

		
		// $this->Relasi_kuitansi_akun_model->get_relasi_kuitansi_akun()
	}

	public function get_buku_besar()
    {
    // 	if ($tipe == 'sak'){
    // 		$akun = array(1,4);
    // 	}else if($tipe == 'lra'){
    // 		$akun = array(6,7);
    // 	}

    	$akun = array(1,2,3,4,5,6,7,8,9);

    	$data = $this->Laporan_model->get_data_buku_besar($akun);

    	$n_akun = count($data);

    	// print_r($n_akun);
    	// print_r($data);
    	// die();

    	

        // $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
        // $rendererLibrary = 'mpdf';
        // $rendererLibraryPath = APPPATH.'third_party/'.$rendererLibrary;
        // if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
        //     die(
        //         'Please set the $rendererName and $rendererLibraryPath values' .
        //             PHP_EOL .
        //         ' as appropriate for your directory structure'
        //         );
        // }
        $path_template = realpath(FCPATH).'/assets/akuntansi/template_excel/template_buku_besar.xls';
        $excel = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $excel->load($path_template);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $row = 3;
        $height = 12;
        for ($i=0; $i < $n_akun-1; $i++) { 
    		$this->copyRows($objWorksheet,$row,$row+$height,10,6);
    		$row = $row+$height;
    	}

    	$row = 10;
    	$nama_row = $row-7;
    	$kode_row = $row-6;
    	foreach ($data as $key => $entry) {
    		$i = 1;
    		$next_row = 11;

	    	$nama_row = $row-7;
	    	$kode_row = $row-6;

	    	$objWorksheet->setCellValueByColumnAndRow(3,$nama_row,$this->Akun_model->get_nama_akun((string)$key));
	    	$objWorksheet->setCellValueByColumnAndRow(3,$kode_row,$key);

    		foreach ($entry as $transaksi) {
    			$objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,1); 
    			$objWorksheet->setCellValueByColumnAndRow(0,$row,$transaksi['tanggal']);
    			$objWorksheet->setCellValueByColumnAndRow(1,$row,$transaksi['uraian']);
    			$objWorksheet->setCellValueByColumnAndRow(2,$row,$transaksi['kode_user']);
    			if ($transaksi['tipe'] == 'debet'){
    				$objWorksheet->setCellValueByColumnAndRow(3,$row,$transaksi['jumlah']);
    			} else if ($transaksi['tipe'] == 'kredit'){
					$objWorksheet->setCellValueByColumnAndRow(4,$row,$transaksi['jumlah']);
    			}
    			$next_row;
    			$row++;
    		}
    		$row = $row + $next_row + $i;

    		$i++;
    		// $objWorksheet->setCellValueByColumnAndRow(2,$i+$row,$i+1);
    	}



      

        // $nilai = $data['nilai'];
        // $baris = 22;
        // for ($i=0; $i < count($nilai); $i++) { 
        //     $objWorksheet->setCellValueByColumnAndRow(2,$i+$baris,$i+1);
        //     $objWorksheet->setCellValueByColumnAndRow(3,$i+$baris,$nilai[$i]['nama_mapel']);
        //     $objWorksheet->setCellValueByColumnAndRow(5,$i+$baris,$nilai[$i]['nilai']);
        //     $objWorksheet->setCellValueByColumnAndRow(6,$i+$baris,$this->konversiNilai($nilai[$i]['nilai']));
        // }
        // $objWorksheet->setCellValue('F26',$data['jumlah']);
        // $objWorksheet->setCellValue('G26',$this->konversiNilai($data['jumlah']));


        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
        $output['data'] = $objWriter->generateHTMLHeader();
        $output['data'] .= $objWriter->generateStyles();
        $output['data'] .= $objWriter->generateSheetData();
        $output['data'] .= $objWriter->generateHTMLFooter();
        
    

        $this->load->view('akuntansi/laporan/buku_besar',$output);

    }

    function copyRows(PHPExcel_Worksheet $sheet,$srcRow,$dstRow,$height,$width) {
        for ($row = 0; $row < $height; $row++) {
               for ($col = 0; $col < $width; $col++) {
                $cell = $sheet->getCellByColumnAndRow($col, $srcRow + $row);
                $style = $sheet->getStyleByColumnAndRow($col, $srcRow + $row);
                $dstCell = PHPExcel_Cell::stringFromColumnIndex($col) . (string)($dstRow + $row);
                $sheet->setCellValue($dstCell, $cell->getValue());
                $sheet->duplicateStyle($style, $dstCell);
            }

            $h = $sheet->getRowDimension($srcRow + $row)->getRowHeight();
            $sheet->getRowDimension($dstRow + $row)->setRowHeight($h);
        }

        foreach ($sheet->getMergeCells() as $mergeCell) {
            $mc = explode(":", $mergeCell);
            $col_s = preg_replace("/[0-9]*/", "", $mc[0]);
            $col_e = preg_replace("/[0-9]*/", "", $mc[1]);
            $row_s = ((int)preg_replace("/[A-Z]*/", "", $mc[0])) - $srcRow;
            $row_e = ((int)preg_replace("/[A-Z]*/", "", $mc[1])) - $srcRow;

            if (0 <= $row_s && $row_s < $height) {
                $merge = $col_s . (string)($dstRow + $row_s) . ":" . $col_e . (string)($dstRow + $row_e);
                $sheet->mergeCells($merge);
            } 
        }
    }
}
