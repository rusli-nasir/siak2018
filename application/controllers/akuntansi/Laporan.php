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
        $this->load->model('akuntansi/Output_model', 'Output_model');
        $this->load->model('akuntansi/Unit_kerja_model', 'Unit_kerja_model');
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->data['db2'] = $this->load->database('rba',TRUE);
        setlocale(LC_NUMERIC, 'Indonesian');

        $this->load->library('excel');
    }

    public function buku_besar($id = 0){
        $this->data['tab1'] = true;

//      $this->data['query_debet'] = $this->Laporan_model->read_buku_besar_group('akun_debet');
//      $this->data['query_debet_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_debet_akrual');
//      $this->data['query_kredit'] = $this->Laporan_model->read_buku_besar_group('akun_kredit');
//      $this->data['query_kredit_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_kredit_akrual');
        $this->db2 = $this->load->database('rba', true);
        $this->load->model('akuntansi/Memorial_model', 'Memorial_model');
        $this->data['query_unit'] = $this->db2->query("SELECT * FROM unit");
        $this->data['query_akun_kas'] = $this->get_akun_kas();
        $this->data['query_akun_akrual'] = $this->get_akun_akrual();

        $temp_data['content'] = $this->load->view('akuntansi/buku_besar_list',$this->data,true);
        $this->load->view('akuntansi/content_template',$temp_data,false);
    }

    public function rekap_jurnal($id = 0){
        $this->data['tab1'] = true;

//      $this->data['query_debet'] = $this->Laporan_model->read_buku_besar_group('akun_debet');
//      $this->data['query_debet_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_debet_akrual');
//      $this->data['query_kredit'] = $this->Laporan_model->read_buku_besar_group('akun_kredit');
//      $this->data['query_kredit_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_kredit_akrual');
        $this->db2 = $this->load->database('rba', true);
        $this->load->model('akuntansi/Memorial_model', 'Memorial_model');
        $this->data['query_unit'] = $this->db2->query("SELECT * FROM unit");
        $this->data['query_akun_kas'] = $this->get_akun_kas();
        $this->data['query_akun_akrual'] = $this->get_akun_akrual();

        $temp_data['content'] = $this->load->view('akuntansi/rekap_jurnal_list',$this->data,true);
        $this->load->view('akuntansi/content_template',$temp_data,false);
    }

	public function neraca_saldo($id = 0){
		$this->data['tab1'] = true;

//		$this->data['query_debet'] = $this->Laporan_model->read_buku_besar_group('akun_debet');
//		$this->data['query_debet_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_debet_akrual');
//		$this->data['query_kredit'] = $this->Laporan_model->read_buku_besar_group('akun_kredit');
//		$this->data['query_kredit_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_kredit_akrual');
        $this->db2 = $this->load->database('rba', true);
        $this->load->model('akuntansi/Memorial_model', 'Memorial_model');
        $this->data['query_unit'] = $this->db2->query("SELECT * FROM unit");
        $this->data['query_akun_kas'] = $this->get_akun_kas();
        $this->data['query_akun_akrual'] = $this->get_akun_akrual();

		$temp_data['content'] = $this->load->view('akuntansi/neraca_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function get_akun_kas($get_json=null){
        $this->load->model('akuntansi/Memorial_model', 'Memorial_model');
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

        if($get_json){
            $json_data['hasil'] = $data;

            header('Content-Type: application/json');
            echo json_encode($json_data);
        } else return $data;
    }

    public function get_akun_akrual($get_json = null){
        $this->load->model('akuntansi/Memorial_model', 'Memorial_model');
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
        
        if($get_json){
            $json_data['hasil'] = $data;

            header('Content-Type: application/json');
            echo json_encode($json_data);
        } else return $data;

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
		// print_r($this->Laporan_model->get_data_buku_besar($akun));

        print_r($this->Output_model->get_nama_output('121412040901010201521222'));

		
		// $this->Relasi_kuitansi_akun_model->get_relasi_kuitansi_akun()
	}

	public function get_rekap_jurnal($mode = null)
	{
        $basis = $this->input->post('basis');
        $unit = $this->input->post('unit');
        $sumber_dana = $this->input->post('sumber_dana');
        
        $daterange = $this->input->post('daterange');
        $date_t = explode(' - ', $daterange);
        $periode_awal = strtodate($date_t[0]);
        $periode_akhir = strtodate($date_t[1]);

        if ($unit == 'all') {
            $unit = null;
        }
        if ($sumber_dana == 'all') {
            $sumber_dana = null;
        } 

        // print_r($this->input->post());die();
		// $akun = array(1,2,3,4,5,6,7,8,9);
        //public function read_rekap_jurnal($jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null)
        $data = $this->Laporan_model->read_rekap_jurnal($basis,$unit,$sumber_dana,$periode_awal,$periode_akhir);

        // print_r($data);die();

        $n_akun = count($data);

        $path_template = realpath(FCPATH).'/assets/akuntansi/template_excel/template_jurnal_umum.xls';
        $excel = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $excel->load($path_template);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $objWorksheet->setTitle('Rekap Jurnal');

        $row = $start_row = 9;

        $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,2*count($data));
        foreach ($data as $entry) {
            // echo count($entry['akun']);
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,count($entry['akun']));
        }
        // die();

        $BStyle = array(
          'borders' => array(
            'outline' => array(
              'style' => PHPExcel_Style_Border::BORDER_MEDIUM
            ),
            'top' => array(
              'style' => PHPExcel_Style_Border::BORDER_MEDIUM
            )

          )
        );

        $RowStyle = array(
          'borders' => array(
            'bottom' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );


        $CenteredStyle = array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, );

        $teks_sumber_dana = "JURNAL UMUM ";
        $teks_periode = "";
        $teks_tahun = substr($periode_akhir,0,4);
        $teks_tahun_anggaran = "TAHUN ANGGARAN $teks_tahun";

        if ($periode_awal != null and $periode_akhir != null){
            $teks_periode .= "PER ".$this->Jurnal_rsa_model->reKonversiTanggal($periode_awal) . " - ".$this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir);
        }


        if ($sumber_dana != null) {
            $teks_sumber_dana .= "DARI DANA ".strtoupper(str_replace('_',' ',$sumber_dana));
        }

        $objWorksheet->setCellValueByColumnAndRow(0,2,$teks_sumber_dana);
        $objWorksheet->setCellValueByColumnAndRow(0,3,$teks_periode);
        $objWorksheet->setCellValueByColumnAndRow(0,4,$teks_tahun_anggaran);


        $iter = 1;


        $jumlah_debet = 0;
        $jumlah_kredit = 0;



        foreach ($data as $entry) {
            $transaksi = $entry['transaksi'];
            $akun = $entry['akun'];
            
            $nama_unit = $this->Unit_kerja_model->get_nama_unit($transaksi['unit_kerja']);
            $row++;

            $row_teks = $row - 1;

            $objWorksheet->getStyle("A$row_teks:F$row_teks")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objWorksheet->getStyle("A$row_teks:G$row_teks")->applyFromArray(
                                                                                        array(
                                                                                            'fill' => array(
                                                                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                                'color' => array('rgb' => 'DCF8C6')
                                                                                            ),
                                                                                            'borders' => array(
                                                                                                'outline' => array(
                                                                                                  'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                                                                                                ),
                                                                                                'top' => array(
                                                                                                  'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    );

            $objWorksheet->mergeCellsByColumnAndRow(0,$row_teks,0,$row);
            $objWorksheet->setCellValueByColumnAndRow(0,$row_teks,$iter);
            $objWorksheet->mergeCellsByColumnAndRow(1,$row_teks,5,$row);
            $objWorksheet->setCellValueByColumnAndRow(1,$row_teks,'keterangan');
            // $objWorksheet->getStyleByColumnAndRow(0,$row_teks)->applyFromArray($BStyle);
            // $objWorksheet->getStyleByColumnAndRow(1,$row_teks)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $objWorksheet->getStyle("A$row_teks:I$row_teks")->applyFromArray($BStyle);
            
            $objWorksheet->setCellValueByColumnAndRow(0,$row_teks,$iter);
            $objWorksheet->mergeCellsByColumnAndRow(6,$row_teks,8,$row);
            $objWorksheet->setCellValueByColumnAndRow(6,$row_teks,$nama_unit." : \n".$transaksi['uraian']);
            // $objWorksheet->getStyleByColumnAndRow(6,$row_teks)->applyFromArray($BStyle);
            // $objWorksheet->getStyle("G$row_teks:I$row_teks")->applyFromArray($BStyle);
             // $objWorksheet->getStyle("A$row_teks:G$row_teks")->applyFromArray($BStyle);


            
            // $objWorksheet->setCellValueByColumnAndRow(6,$row,$transaksi['uraian']);

            foreach ($akun as $in_akun) {
                $row++;

                $objWorksheet->getStyle('A'.$row.':I'.$row)->applyFromArray($RowStyle);
                $objWorksheet->setCellValueByColumnAndRow(1,$row,$this->Jurnal_rsa_model->reKonversiTanggal($transaksi['tanggal']));
                $objWorksheet->setCellValueByColumnAndRow(2,$row,$transaksi['no_spm']);
                $objWorksheet->setCellValueByColumnAndRow(3,$row,$transaksi['no_bukti']);
                $objWorksheet->getStyleByColumnAndRow(4,$row)->getNumberFormat()->setFormatCode('0000');
                $objWorksheet->setCellValueByColumnAndRow(4,$row,"".substr($transaksi['kode_kegiatan'],6,4));
                // echo substr($transaksi['kode_kegiatan'],6,4);die();
                $objWorksheet->setCellValueByColumnAndRow(5,$row,$in_akun['akun']);
                if ($in_akun['tipe'] == 'debet'){
                    $objWorksheet->setCellValueByColumnAndRow(7,$row,$in_akun['jumlah']);
                    // $objWorksheet->setCellValueByColumnAndRow(8,$row,0);
                    $jumlah_debet += $in_akun['jumlah'];
                }elseif ($in_akun['tipe'] == 'kredit') {
                    $objWorksheet->getStyleByColumnAndRow(5,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objWorksheet->setCellValueByColumnAndRow(8,$row,$in_akun['jumlah']);
                    // $objWorksheet->setCellValueByColumnAndRow(7,$row,0);
                    $jumlah_kredit += $in_akun['jumlah'];
                }
                $objWorksheet->setCellValueByColumnAndRow(6,$row, $this->Akun_model->get_nama_akun($in_akun['akun']));

            }



            $iter++;
            $row+=1;

        }

        $objWorksheet->setCellValueByColumnAndRow(7,$row,$jumlah_debet);
        $objWorksheet->setCellValueByColumnAndRow(8,$row,$jumlah_kredit);

        if ($mode == 'excel'){
            $objWorksheet->getPageSetup()->setFitToPage(true);
            $objWorksheet->getPageSetup()->setFitToWidth(0);
            $objWorksheet->getPageSetup()->setFitToHeight(1);
            $objWorksheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(6,7);
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=rekap_jurnal.xls");
            header('Cache-Control: max-age=0');
            // $objWriter = new PHPExcel_Writer_HTML($objPHPExcel,'excel5');  
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;


        }

        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
        $output['data'] = $objWriter->generateHTMLHeader();
        $output['data'] .= $objWriter->generateStyles();
        $output['data'] .= $objWriter->generateSheetData();
        $output['data'] .= $objWriter->generateHTMLFooter();
        $output['teks_cetak'] = 'Print Rekap Jurnal';
        $output['sumber'] = 'get_rekap_jurnal';
        
    

        $this->load->view('akuntansi/laporan/laporan',$output);

	}

	public function get_buku_besar($mode = null)
    {
    // 	if ($tipe == 'sak'){
    // 		$akun = array(1,4);
    // 	}else if($tipe == 'lra'){
    // 		$akun = array(6,7);
    // 	}

        // print_r($this->input->post());die();

        // public function get_data_buku_besar($array_akun,$jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null)

        $akun = $this->input->post('akun')[0];
        $basis = $this->input->post('basis');
        $unit = $this->input->post('unit');
        $sumber_dana = $this->input->post('sumber_dana');
        
        $daterange = $this->input->post('daterange');
        $date_t = explode(' - ', $daterange);
        $periode_awal = strtodate($date_t[0]);
        $periode_akhir = strtodate($date_t[1]);

        if ($unit == 'all') {
            $unit = null;
        }
        if ($sumber_dana == 'all') {
            $sumber_dana = null;
        }

        $array_akun = array();

        if ($akun == 'all')
            $array_akun = array(1,2,3,4,5,6,7,8,9);
        else {
            $array_akun[] = $akun;
        }

        // print_r($array_akun);die();


    	$data = $this->Laporan_model->get_data_buku_besar($array_akun,$basis,$unit,$sumber_dana,$periode_awal,$periode_akhir);

        // print_r($data);die();

    	$n_akun = count($data);

        $path_template = realpath(FCPATH).'/assets/akuntansi/template_excel/template_buku_besar.xls';
        $excel = new PHPExcel_Reader_Excel5();

        $objPHPExcel = $excel->load($path_template);
        $objPHPExcel->setActiveSheetIndex(0); // index of sheet
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $objWorksheet->setTitle('Buku Besar');

        // $objWorksheet = $objPHPExcel->getActiveSheet();

        $row = 5;
        $height = 12;
        for ($i=0; $i < $n_akun-1; $i++) { 
    		$this->copyRows($objWorksheet,$row,$row+$height,12,8);
    		$row = $row+$height;
    	}

        $teks_sumber_dana = "BUKU BESAR ";
        $teks_periode = "";
        
        $teks_tahun = substr($periode_akhir,0,4);
        $teks_tahun_anggaran = "TAHUN ANGGARAN $teks_tahun";

        $teks_unit = "UNIVERSITAS DIPONEGORO";

        if ($periode_awal != null and $periode_akhir != null){
            $teks_periode .= "PER ".$this->Jurnal_rsa_model->reKonversiTanggal($periode_awal) . " - ".$this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir);
        }


        if ($sumber_dana != null) {
            $teks_sumber_dana .= "DARI DANA ".strtoupper(str_replace('_',' ',$sumber_dana));
        }

        $objWorksheet->setCellValueByColumnAndRow(0,2,$teks_sumber_dana);
        $objWorksheet->setCellValueByColumnAndRow(0,3,$teks_periode);


    	$row = 13;
    	$kode_row = $row-6;
    	$nama_row = $row-5;
    	foreach ($data as $key => $entry) {
    		$i = 1;
    		$next_row = 11;

	    	$kode_row = $row-6;
	    	$nama_row = $row-5;
            $tahun_row = $row-7;
            $unit_row = $row-8;

	    	$objWorksheet->setCellValueByColumnAndRow(2,$nama_row,$this->Akun_model->get_nama_akun((string)$key));
            $objWorksheet->setCellValueByColumnAndRow(2,$kode_row,$key);
            $objWorksheet->setCellValueByColumnAndRow(2,$tahun_row,$teks_tahun_anggaran);
	    	$objWorksheet->setCellValueByColumnAndRow(2,$unit_row,$teks_unit);

	    	$saldo = $this->Akun_model->get_saldo_awal($key);
	    	$jumlah_debet = 0;
	    	$jumlah_kredit = 0;
	    	$iter = 0;

    		foreach ($entry as $transaksi) {
    			$iter++;
                if ($iter == 1) {
                    $objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,1); 
                    $objWorksheet->setCellValueByColumnAndRow(0,$row,$iter);
                    $objWorksheet->setCellValueByColumnAndRow(1,$row,'01 Januari 2017');
                    $objWorksheet->setCellValueByColumnAndRow(3,$row,'Saldo Awal');
                    $objWorksheet->setCellValueByColumnAndRow(7,$row,$saldo);

                    $row++;
                    $iter++;
                }
    			$objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,1); 
    			$objWorksheet->setCellValueByColumnAndRow(0,$row,$iter);
                $objWorksheet->setCellValueByColumnAndRow(1,$row,$transaksi['tanggal']);
    			$objWorksheet->setCellValueByColumnAndRow(2,$row,$transaksi['no_bukti']);
    			$objWorksheet->setCellValueByColumnAndRow(3,$row,$transaksi['uraian']);
    			$objWorksheet->setCellValueByColumnAndRow(4,$row,$transaksi['kode_user']);
    			if ($transaksi['tipe'] == 'debet'){
    				$objWorksheet->setCellValueByColumnAndRow(5,$row,$transaksi['jumlah']);
    				$saldo += $transaksi['jumlah'];
    				$jumlah_debet += $transaksi['jumlah'];
    			} else if ($transaksi['tipe'] == 'kredit'){
					$objWorksheet->setCellValueByColumnAndRow(6,$row,$transaksi['jumlah']);
					$saldo -= $transaksi['jumlah'];
					$jumlah_kredit += $transaksi['jumlah'];
    			}
    			$objWorksheet->setCellValueByColumnAndRow(7,$row,$saldo);
    			$next_row;
    			$row++;
    		}
    		$objWorksheet->setCellValueByColumnAndRow(5,$row+1,$jumlah_debet);
    		$objWorksheet->setCellValueByColumnAndRow(6,$row+1,$jumlah_kredit);
    		$objWorksheet->setCellValueByColumnAndRow(7,$row+1,$saldo);

    		$row = $row + $next_row + $i;

    		$i++;
    		// $objWorksheet->setCellValueByColumnAndRow(2,$i+$row,$i+1);
    	}

        if ($mode == 'excel'){
            $objWorksheet->getPageSetup()->setFitToPage(true);
            $objWorksheet->getPageSetup()->setFitToWidth(0);
            $objWorksheet->getPageSetup()->setFitToHeight(1);
            $objWorksheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(10,11);
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=buku_besar.xls");
            header('Cache-Control: max-age=0');
            // $objWriter = new PHPExcel_Writer_HTML($objPHPExcel,'excel5');  
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;


        }

        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
        $output['data'] = $objWriter->generateHTMLHeader();
        $output['data'] .= $objWriter->generateStyles();
        $output['data'] .= $objWriter->generateSheetData();
        $output['data'] .= $objWriter->generateHTMLFooter();
        $output['teks_cetak'] = 'Print Buku Besar';
        $output['sumber'] = 'get_buku_besar';
        
    

        $this->load->view('akuntansi/laporan/laporan',$output);

    }

    public function get_neraca_saldo($mode = null)
    {
    // 	if ($tipe == 'sak'){
    // 		$akun = array(1,4);
    // 	}else if($tipe == 'lra'){
    // 		$akun = array(6,7);
    // 	}


    	$array_akun = array(1,2,3,4,5,6,7,8,9);

        $basis = $this->input->post('basis');
        
        $daterange = $this->input->post('daterange');
        $date_t = explode(' - ', $daterange);
        $periode_awal = strtodate($date_t[0]);
        $periode_akhir = strtodate($date_t[1]);
        
        $sumber_dana = $this->input->post('sumber_dana');
        $unit = $this->input->post('sumber_dana');

        if ($unit == 'all') {
            $unit = null;
        }

    	// $data = $this->Laporan_model->get_data_buku_besar($akun,'akrual');
        $data = $this->Laporan_model->get_data_buku_besar($array_akun,$basis,$unit,$sumber_dana,$periode_awal,$periode_akhir);

        $teks_sumber_dana = "BUKU BESAR ";
        $teks_periode = "";

        $teks_tahun_anggaran = substr($periode_akhir,0,4);
        $teks_unit = "UNIVERSITAS DIPONEGORO";

        if ($periode_awal != null and $periode_akhir != null){
            $teks_periode .= "PER ".$this->Jurnal_rsa_model->reKonversiTanggal($periode_awal) . " - ".$this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir);
        }


        if ($sumber_dana != null) {
            $teks_sumber_dana .= "DARI DANA ".strtoupper(str_replace('_',' ',$sumber_dana));
        }

    	ksort($data);

    	$n_akun = count($data);

        $path_template = realpath(FCPATH).'/assets/akuntansi/template_excel/template_neraca_saldo.xls';
        $excel = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $excel->load($path_template);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $objWorksheet->setTitle('neraca_saldo');

        $objWorksheet->setCellValueByColumnAndRow(0,2,$teks_sumber_dana);
        $objWorksheet->setCellValueByColumnAndRow(0,3,$teks_periode);
        $objWorksheet->setCellValueByColumnAndRow(2,6,$teks_tahun_anggaran);

        $jumlah_debet = 0;
	    $jumlah_kredit = 0;
        $jumlah_neraca_debet = 0;
        $jumlah_neraca_kredit = 0;

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

    		$objWorksheet->setCellValueByColumnAndRow(3,$row,$debet);
    		$objWorksheet->setCellValueByColumnAndRow(4,$row,$kredit);

            $saldo_neraca = $debet - $kredit;


            $objWorksheet->setCellValueByColumnAndRow(5,$row,0);
            $objWorksheet->setCellValueByColumnAndRow(6,$row,0);

            if ($saldo_neraca > 0) {
                $jumlah_neraca_debet += $saldo_neraca;
                $objWorksheet->setCellValueByColumnAndRow(5,$row,$saldo_neraca);
            } elseif ($saldo_neraca < 0) {
                $saldo_neraca = abs($saldo_neraca);
                $jumlah_neraca_kredit += $saldo_neraca;
                $objWorksheet->setCellValueByColumnAndRow(6,$row,$saldo_neraca);
            }

    		$row++;

    		$i++;
    		// $objWorksheet->setCellValueByColumnAndRow(2,$i+$row,$i+1);
    	}

        $objWorksheet->setCellValueByColumnAndRow(3,$row+1,$jumlah_debet);
        $objWorksheet->setCellValueByColumnAndRow(4,$row+1,$jumlah_kredit);
    	$objWorksheet->setCellValueByColumnAndRow(5,$row+1,$jumlah_neraca_debet);
    	$objWorksheet->setCellValueByColumnAndRow(6,$row+1,$jumlah_neraca_kredit);

        if ($mode == 'excel'){
            $objWorksheet->getPageSetup()->setFitToPage(true);
            $objWorksheet->getPageSetup()->setFitToWidth(0);
            $objWorksheet->getPageSetup()->setFitToHeight(1);
            $objWorksheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(8,9);
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=neraca_saldo.xls");
            header('Cache-Control: max-age=0');
            // $objWriter = new PHPExcel_Writer_HTML($objPHPExcel,'excel5');  
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;


        }

        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
        $output['data'] = $objWriter->generateHTMLHeader();
        $output['data'] .= $objWriter->generateStyles();
        $output['data'] .= $objWriter->generateSheetData();
        $output['data'] .= $objWriter->generateHTMLFooter();
        $output['teks_cetak'] = 'Print Neraca Saldo';
        $output['sumber'] = 'get_neraca_saldo';
        
    

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
