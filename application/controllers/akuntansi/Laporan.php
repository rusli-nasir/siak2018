<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['menu9'] = true;
        $this->cek_session_in();
        $this->cek_session_in();
        //$this->load->model('akuntansi/Laporan_model', 'Laporan_model');
        $this->load->model('akuntansi/Akun_model', 'Akun_model');
        $this->data['db2'] = $this->load->database('rba',TRUE);

        $this->load->library('excel');
    }

	public function buku_besar($id = 0){
		$this->data['tab1'] = true;

//		$this->data['query_debet'] = $this->Laporan_model->read_buku_besar_group('akun_debet');
//		$this->data['query_debet_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_debet_akrual');
//		$this->data['query_kredit'] = $this->Laporan_model->read_buku_besar_group('akun_kredit');
//		$this->data['query_kredit_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_kredit_akrual');
        $this->db2 = $this->load->database('rba', true);
        $this->load->model('akuntansi/Memorial_model', 'Memorial_model');
        $this->data['query_unit'] = $this->db2->query("SELECT * FROM unit ORDER BY nama_unit ASC");
        $this->data['query_akun_kas'] = $this->get_akun_kas();
        $this->data['query_akun_akrual'] = $this->get_akun_akrual();

		$temp_data['content'] = $this->load->view('akuntansi/buku_besar_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function get_akun_kas(){
        $query_1 = $this->Memorial_model->read_akun('akuntansi_aset_6');
        $query_2 = $this->Memorial_model->read_akun('akuntansi_hutang_6');
        $query_3 = $this->Memorial_model->read_akun('akuntansi_aset_bersih_6');
        $query_4 = $this->Memorial_model->read_akun('akuntansi_lra_6');
        $query_5 = $this->Memorial_model->read_akun_rba('akun_belanja');
        $query_6 = $this->Memorial_model->read_akun('akuntansi_pembiayaan_6');

        $i = 0;
        foreach($query_1->result() as $result){
            if($i==0){
                $data[$i]['akun_6'] = '911101';
                $data[$i]['nama'] = 'SAL';
            }else{
                $data[$i]['akun_6'] = $result->akun_6;
                $data[$i]['nama'] = $result->nama;
            }
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
        $data[$i]['akun_6'] = '911101';
        $data[$i]['nama'] = 'SAL';

        return $data;
    }

    public function get_akun_akrual(){
        $query_1 = $this->Memorial_model->read_akun('akuntansi_aset_6');
        $query_2 = $this->Memorial_model->read_akun('akuntansi_hutang_6');
        $query_3 = $this->Memorial_model->read_akun('akuntansi_aset_bersih_6');
        $query_4 = $this->Memorial_model->read_akun('akuntansi_lra_6');
        $query_5 = $this->Memorial_model->read_akun_rba('akun_belanja');
        $query_6 = $this->Memorial_model->read_akun('akuntansi_pembiayaan_6');

        $i = 0;
        foreach($query_1->result() as $result){
            if($i==0){
                $data[$i]['akun_6'] = '911101';
                $data[$i]['nama'] = 'SAL';
            }else{
                $data[$i]['akun_6'] = $result->akun_6;
                $data[$i]['nama'] = $result->nama;
            }
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

        return $data;
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

	public function get_($value='')
	{
		# code...
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

        $path_template = realpath(FCPATH).'/assets/akuntansi/template_excel/template_buku_besar.xls';
        $excel = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $excel->load($path_template);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $row = 5;
        $height = 12;
        for ($i=0; $i < $n_akun-1; $i++) { 
    		$this->copyRows($objWorksheet,$row,$row+$height,12,7);
    		$row = $row+$height;
    	}

    	$row = 13;
    	$kode_row = $row-6;
    	$nama_row = $row-5;
    	foreach ($data as $key => $entry) {
    		$i = 1;
    		$next_row = 11;

	    	$kode_row = $row-6;
	    	$nama_row = $row-5;

	    	$objWorksheet->setCellValueByColumnAndRow(2,$nama_row,$this->Akun_model->get_nama_akun((string)$key));
	    	$objWorksheet->setCellValueByColumnAndRow(2,$kode_row,$key);

	    	$saldo = $this->Akun_model->get_saldo_awal($key);
	    	$jumlah_debet = 0;
	    	$jumlah_kredit = 0;
	    	$iter = 0;

    		foreach ($entry as $transaksi) {
    			$iter++;
    			$objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,1); 
    			$objWorksheet->setCellValueByColumnAndRow(0,$row,$iter);
    			$objWorksheet->setCellValueByColumnAndRow(1,$row,$transaksi['tanggal']);
    			$objWorksheet->setCellValueByColumnAndRow(2,$row,$transaksi['uraian']);
    			$objWorksheet->setCellValueByColumnAndRow(3,$row,$transaksi['kode_user']);
    			if ($transaksi['tipe'] == 'debet'){
    				$objWorksheet->setCellValueByColumnAndRow(4,$row,number_format($transaksi['jumlah'],2,',','.'));
    				$saldo += $transaksi['jumlah'];
    				$jumlah_debet += $transaksi['jumlah'];
    			} else if ($transaksi['tipe'] == 'kredit'){
					$objWorksheet->setCellValueByColumnAndRow(5,$row,number_format($transaksi['jumlah'],2,',','.'));
					$saldo -= $transaksi['jumlah'];
					$jumlah_kredit += $transaksi['jumlah'];
    			}
    			$objWorksheet->setCellValueByColumnAndRow(6,$row,number_format($saldo,2,',','.'));
    			$next_row;
    			$row++;
    		}
    		$objWorksheet->setCellValueByColumnAndRow(4,$row+1,number_format($jumlah_debet,2,',','.'));
    		$objWorksheet->setCellValueByColumnAndRow(5,$row+1,number_format($jumlah_kredit,2,',','.'));
    		$objWorksheet->setCellValueByColumnAndRow(6,$row+1,number_format($saldo,2,',','.'));

    		$row = $row + $next_row + $i;

    		$i++;
    		// $objWorksheet->setCellValueByColumnAndRow(2,$i+$row,$i+1);
    	}

        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
        $output['data'] = $objWriter->generateHTMLHeader();
        $output['data'] .= $objWriter->generateStyles();
        $output['data'] .= $objWriter->generateSheetData();
        $output['data'] .= $objWriter->generateHTMLFooter();
        $output['teks_cetak'] = 'Print Buku Besar';
        
    

        $this->load->view('akuntansi/laporan/laporan',$output);

    }

    public function get_neraca_saldo()
    {
    // 	if ($tipe == 'sak'){
    // 		$akun = array(1,4);
    // 	}else if($tipe == 'lra'){
    // 		$akun = array(6,7);
    // 	}

    	$akun = array(1,2,3,4,5,6,7,8,9);

    	$data = $this->Laporan_model->get_data_buku_besar($akun,'akrual');

    	ksort($data);

    	$n_akun = count($data);

        $path_template = realpath(FCPATH).'/assets/akuntansi/template_excel/template_neraca_saldo.xls';
        $excel = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $excel->load($path_template);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $jumlah_debet = 0;
	    $jumlah_kredit = 0;

    	$row = 11;
    	$i = 1;

    	foreach ($data as $key => $entry) {

	    	$saldo = $this->Akun_model->get_saldo_awal($key);
	    	$debet = 0;
	    	$kredit = 0;
	    	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1); 
	    	$objWorksheet->setCellValueByColumnAndRow(0,$row,$i);
	    	$objWorksheet->setCellValueByColumnAndRow(1,$row,$key);
	    	$objWorksheet->setCellValueByColumnAndRow(2,$row,$this->Akun_model->get_nama_akun((string)$key));


    		foreach ($entry as $transaksi) {
    			if ($transaksi['tipe'] == 'debet'){
    				$saldo += $transaksi['jumlah'];
    				$debet += $transaksi['jumlah'];
    			} else if ($transaksi['tipe'] == 'kredit'){
					$saldo -= $transaksi['jumlah'];
					$kredit += $transaksi['jumlah'];
    			}
    		}


    		$jumlah_debet += $debet;
    		$jumlah_kredit += $kredit;

    		$objWorksheet->setCellValueByColumnAndRow(3,$row,number_format($debet,2,',','.'));
    		$objWorksheet->setCellValueByColumnAndRow(4,$row,number_format($kredit,2,',','.'));

    		$row++;

    		$i++;
    		// $objWorksheet->setCellValueByColumnAndRow(2,$i+$row,$i+1);
    	}

    	$objWorksheet->setCellValueByColumnAndRow(3,$row+1,number_format($jumlah_debet,2,',','.'));
    	$objWorksheet->setCellValueByColumnAndRow(4,$row+1,number_format($jumlah_kredit,2,',','.'));

        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
        $output['data'] = $objWriter->generateHTMLHeader();
        $output['data'] .= $objWriter->generateStyles();
        $output['data'] .= $objWriter->generateSheetData();
        $output['data'] .= $objWriter->generateHTMLFooter();
        $output['teks_cetak'] = 'Print Neraca Saldo';
        
    

        $this->load->view('akuntansi/laporan/laporan',$output);

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
