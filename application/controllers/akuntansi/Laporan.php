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
        $this->load->model('akuntansi/Pajak_model', 'Pajak_model');
        $this->load->model('akuntansi/Pejabat_model', 'Pejabat_model');        
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

    public function lainnya(){
        $this->data['menu9'] = null;
        $this->data['menu15'] = true;
        $this->data['tab1'] = true;

//      $this->data['query_debet'] = $this->Laporan_model->read_buku_besar_group('akun_debet');
//      $this->data['query_debet_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_debet_akrual');
//      $this->data['query_kredit'] = $this->Laporan_model->read_buku_besar_group('akun_kredit');
//      $this->data['query_kredit_akrual'] = $this->Laporan_model->read_buku_besar_group('akun_kredit_akrual');
        if($this->input->post('jenis_laporan')!=null){
            $level = $this->input->post('level');
            $daterange = $this->input->post('daterange');
            $date_t = explode(' - ', $daterange);
            $data['periode_awal'] = strtodate($date_t[0]);
            $data['periode_akhir'] = strtodate($date_t[1]) or null;
            $teks_periode = "";
            if ($data['periode_awal'] != null and $data['periode_akhir'] != null){
                $teks_periode .= "PER ".$this->Jurnal_rsa_model->reKonversiTanggal($data['periode_awal']) . " - ".$this->Jurnal_rsa_model->reKonversiTanggal($data['periode_akhir']);
            }
            $data['teks_periode'] = $teks_periode;
            if($this->input->post('jenis_laporan')=='Aktifitas'){
                $this->get_lapak($level, $data);
            }else if($this->input->post('jenis_laporan')=='Posisi Keuangan'){
                $this->get_lpk($level, $data);
            }else if($this->input->post('jenis_laporan')=='Realisasi Anggaran'){
                $this->get_lra($level, $data);
            }else if($this->input->post('jenis_laporan')=='Arus Kas'){
                $this->get_laporan_arus($level, $data);
            }
        }else{
            $this->db2 = $this->load->database('rba', true);
            $this->data['query_unit'] = $this->db2->query("SELECT * FROM unit");

            $temp_data['content'] = $this->load->view('akuntansi/laporan_lainnya_list',$this->data,true);
            $this->load->view('akuntansi/content_template',$temp_data,false);
        }
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
        $query_7 = $this->Pajak_model->get_pajak();
        $query_8 = $this->Memorial_model->read_akun('akuntansi_sal_6');

        $i = 0;
        $data[$i]['akun_6'] = 'all';
        $data[$i]['nama'] = 'Semua Akun';
        $i++;
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
            $data[$i]['akun_6'] = $result->kode_akun;
            $data[$i]['nama'] = $result->nama_akun;
            $i++;
        }
        foreach($query_8->result() as $result){
            $data[$i]['akun_6'] = $result->akun_6;
            $data[$i]['nama'] = $result->nama;
            $i++;
        }

        if($get_json){
            $json_data['hasil'] = $data;

            header('Content-Type: application/json');
            echo json_encode($json_data);
        } else return $data;
    }

    public function get_pajak(){
        $akun_pajak = $this->Pajak_model->get_pajak();
        echo '<select name="akun[]" class="form-control">';
        foreach($akun_pajak->result() as $result){
            echo '<option value="'.$result->kode_akun.'">'.$result->kode_akun.' - '.$result->nama_akun.'</option>';
        }
        echo '</select>';
    }

    public function get_akun_akrual($get_json = null){
        $this->load->model('akuntansi/Memorial_model', 'Memorial_model');
        $query_1 = $this->Memorial_model->read_akun('akuntansi_aset_6');
        $query_2 = $this->Memorial_model->read_akun('akuntansi_hutang_6');
        $query_3 = $this->Memorial_model->read_akun('akuntansi_aset_bersih_6');
        $query_4 = $this->Memorial_model->read_akun('akuntansi_lra_6');
        $query_5 = $this->Memorial_model->read_akun_rba('akun_belanja');
        $query_6 = $this->Memorial_model->read_akun('akuntansi_pembiayaan_6');
        $query_7 = $this->Pajak_model->get_pajak();
        $query_8 = $this->Memorial_model->read_akun('akuntansi_sal_6');

        $i = 0;
        $data[$i]['akun_6'] = 'all';
        $data[$i]['nama'] = 'Semua Akun';
        $i++;
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
            $data[$i]['akun_6'] = $result->kode_akun;
            $data[$i]['nama'] = $result->nama_akun;
            $i++;
        }
        foreach($query_8->result() as $result){
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
        ini_set('memory_limit', '256M');
        $basis = $this->input->post('basis');
        $unit = $this->input->post('unit');
        $sumber_dana = $this->input->post('sumber_dana');
        
        $daterange = $this->input->post('daterange');
        $date_t = explode(' - ', $daterange);
        $periode_awal = strtodate($date_t[0]);
        $periode_akhir = strtodate($date_t[1]);

        $teks_unit = null;

        if ($unit == 'all' or $unit == 9999) {
            $unit = null;
            $teks_unit = "UNIVERSITAS DIPONEGORO";
        } else {
            $teks_unit = $this->Unit_kerja_model->get_nama_unit($unit);
            $teks_unit = strtoupper(str_replace('Fak.', "Fakultas ", $teks_unit));
        }
        if ($sumber_dana == 'all') {
            $sumber_dana = null;
        } 

        // print_r($this->input->post());die();
		// $akun = array(1,2,3,4,5,6,7,8,9);
        //public function read_rekap_jurnal($jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null)
        $data = $this->Laporan_model->read_rekap_jurnal($basis,$unit,$sumber_dana,$periode_awal,$periode_akhir);


        // print_r($data == null);die();
        if ($data == null){
            $this->load->view('akuntansi/no_data',true);
            return 0;
        }

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



        $objWorksheet->setCellValueByColumnAndRow(0,1,$teks_unit);
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
                // $objWorksheet->getStyleByColumnAndRow(2,$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                // $objWorksheet->getStyleByColumnAndRow(3,$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $objWorksheet->setCellValueExplicitByColumnAndRow(2,$row,$transaksi['no_spm'],PHPExcel_Cell_DataType::TYPE_STRING);
                $objWorksheet->setCellValueExplicitByColumnAndRow(3,$row,$transaksi['no_bukti'],PHPExcel_Cell_DataType::TYPE_STRING);
                $objWorksheet->getStyleByColumnAndRow(4,$row)->getNumberFormat()->setFormatCode('0000');
                $objWorksheet->setCellValueByColumnAndRow(4,$row,"".substr($transaksi['kode_kegiatan'],6,4));
                // echo substr($transaksi['kode_kegiatan'],6,4);die();
                $objWorksheet->setCellValueByColumnAndRow(5,$row,$in_akun['akun']);
                if ($in_akun['tipe'] == 'debet'){
                    $objWorksheet->setCellValueByColumnAndRow(7,$row,$this->eliminasi_negatif($in_akun['jumlah']));
                    $objWorksheet->setCellValueByColumnAndRow(8,$row,0);
                    $jumlah_debet += $in_akun['jumlah'];
                }elseif ($in_akun['tipe'] == 'kredit') {
                    $objWorksheet->getStyleByColumnAndRow(5,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objWorksheet->setCellValueByColumnAndRow(8,$row,$this->eliminasi_negatif($in_akun['jumlah']));
                    $objWorksheet->setCellValueByColumnAndRow(7,$row,0);
                    $jumlah_kredit += $in_akun['jumlah'];
                }
                $objWorksheet->setCellValueByColumnAndRow(6,$row, $this->Akun_model->get_nama_akun($in_akun['akun']));

            }



            $iter++;
            $row+=1;

        }

        $objWorksheet->setCellValueByColumnAndRow(7,$row,$this->eliminasi_negatif($jumlah_debet));
        $objWorksheet->setCellValueByColumnAndRow(8,$row,$this->eliminasi_negatif($jumlah_kredit));

        if ($unit == null or $unit == 9999) {
            $kpa = $this->Pejabat_model->get_pejabat('all','rektor');
            $teks_kpa = "Rektor";
        } else {
            $kpa = $this->Pejabat_model->get_pejabat($unit,'kpa');
            $teks_kpa = "Pengguna Anggaran";
        }


        $row = $objWorksheet->getHighestRow() + 2;
        $kolom_kpa = 7;

        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,"Semarang, ". $this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir));
        $row++;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,$teks_kpa);
        $row++;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,$teks_unit);
        $row += 4;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+2,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,$kpa['nama']);
        $row ++;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,"NIP. " . $this->format_nip($kpa['nip']));



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
        $periode_akhir = strtodate($date_t[1]) or null;

        $mode = null;

        $teks_unit = null;


        if ($unit == 'all' or $unit == 9999) {
            if ($unit == 'all') {
                $unit = null;
            }
            // $mode = 'neraca';
            $teks_unit = "UNIVERSITAS DIPONEGORO";
        } else {
            $teks_unit = $this->Unit_kerja_model->get_nama_unit($unit);
            $teks_unit = strtoupper(str_replace('Fak.', "Fakultas ", $teks_unit));
        }


        if ($sumber_dana == 'all') {
            $sumber_dana = null;
        }

        $array_akun = array();

        if ($akun == 'all'){
            $array_akun = array(1,2,3,4,5,6,7,8,9);
            $mode = 'neraca';
        }
        else {
            $array_akun[] = $akun;
            // $mode = 'neraca';
        }

        // print_r($mode);die();


    	$data = $this->Laporan_model->get_data_buku_besar($array_akun,$basis,$unit,$sumber_dana,$periode_awal,$periode_akhir,$mode);

        if ($data == null){
            $this->load->view('akuntansi/no_data',true);
            return 0;
        }


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

        // $teks_unit = "UNIVERSITAS DIPONEGORO";

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

            $case_hutang = in_array(substr($key,0,1),[2,3,4,6]);

	    	$kode_row = $row-6;
	    	$nama_row = $row-5;
            $tahun_row = $row-7;
            $unit_row = $row-8;

	    	$objWorksheet->setCellValueByColumnAndRow(2,$nama_row,":".$this->Akun_model->get_nama_akun((string)$key));
            $objWorksheet->setCellValueByColumnAndRow(2,$kode_row,":".$key);
            $objWorksheet->setCellValueByColumnAndRow(2,$tahun_row,":".$teks_tahun_anggaran);
	    	$objWorksheet->setCellValueByColumnAndRow(2,$unit_row,":".$teks_unit);

	    	$saldo = $this->Akun_model->get_saldo_awal($key);
            // print_r($saldo);die();
	    	$jumlah_debet = 0;
	    	$jumlah_kredit = 0;
	    	$iter = 0;

    		foreach ($entry as $transaksi) {
    			$iter++;
                if ($iter == 1 and $saldo != null) {
                    $objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,1); 
                    $objWorksheet->setCellValueByColumnAndRow(0,$row,$iter);
                    $objWorksheet->setCellValueByColumnAndRow(1,$row,'01 Januari '.$teks_tahun);
                    $objWorksheet->setCellValueByColumnAndRow(3,$row,'Saldo Awal');
                    // $objWorksheet->setCellValueByColumnAndRow(8,$row,$saldo['saldo_kredit_awal']);

                    $saldo = $saldo['saldo_awal'];

                    $objWorksheet->setCellValueByColumnAndRow(7,$row,$this->eliminasi_negatif($saldo));

                    $row++;
                    $iter++;
                }
                
    			$objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1,1); 
    			$objWorksheet->setCellValueByColumnAndRow(0,$row,$iter);
                $objWorksheet->setCellValueByColumnAndRow(1,$row,$transaksi['tanggal']);
                $objWorksheet->setCellValueExplicitByColumnAndRow(2,$row,$transaksi['no_bukti'],PHPExcel_Cell_DataType::TYPE_STRING);
    			// $objWorksheet->setCellValueByColumnAndRow(2,$row,$transaksi['no_bukti']);
    			$objWorksheet->setCellValueByColumnAndRow(3,$row,$transaksi['uraian']);
    			$objWorksheet->setCellValueByColumnAndRow(4,$row,$transaksi['kode_user']);
    			if ($transaksi['tipe'] == 'debet'){
    				$objWorksheet->setCellValueByColumnAndRow(5,$row,$this->eliminasi_negatif($transaksi['jumlah']));
                    $objWorksheet->setCellValueByColumnAndRow(6,$row,0);
                    if ($case_hutang) {
                        $saldo -= $transaksi['jumlah'];
                    } else {
    				    $saldo += $transaksi['jumlah'];
                    }
    				$jumlah_debet += $transaksi['jumlah'];
    			} else if ($transaksi['tipe'] == 'kredit'){
					$objWorksheet->setCellValueByColumnAndRow(6,$row,$this->eliminasi_negatif($transaksi['jumlah']));
                    $objWorksheet->setCellValueByColumnAndRow(5,$row,0);
					if ($case_hutang) {
                        $saldo += $transaksi['jumlah'];
                    } else {
                        $saldo -= $transaksi['jumlah'];
                    }
					$jumlah_kredit += $transaksi['jumlah'];
    			}
    			$objWorksheet->setCellValueByColumnAndRow(7,$row,$this->eliminasi_negatif($saldo));
    			$next_row;
    			$row++;
    		}
    		$objWorksheet->setCellValueByColumnAndRow(5,$row+1,$this->eliminasi_negatif($jumlah_debet));
    		$objWorksheet->setCellValueByColumnAndRow(6,$row+1,$this->eliminasi_negatif($jumlah_kredit));
    		$objWorksheet->setCellValueByColumnAndRow(7,$row+1,$this->eliminasi_negatif($saldo));

    		$row = $row + $next_row + $i;

    		$i++;
    		// $objWorksheet->setCellValueByColumnAndRow(2,$i+$row,$i+1);
    	}

        // ============================================

        // ============================================


        if ($unit == null or $unit == 9999) {
            $kpa = $this->Pejabat_model->get_pejabat('all','rektor');
            $teks_kpa = "Rektor";
        } else {
            $kpa = $this->Pejabat_model->get_pejabat($unit,'kpa');
            $teks_kpa = "Pengguna Anggaran";
        }

        $row = $objWorksheet->getHighestRow() + 2;
        $kolom_kpa = 6;



        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,"Semarang, ". $this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir));
        $row++;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,$teks_kpa);
        $row++;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,$teks_unit);
        $row += 4;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+2,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,$kpa['nama']);
        $row ++;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,"NIP. " . $this->format_nip($kpa['nip']));


        // $penyusun = $this->Pejabat_model->get_pejabat($unit,'operator');
        // $ppk = $this->Pejabat_model->get_pejabat($unit,'ppk');

        // $row = $objWorksheet->getHighestRow() + 2;
        // $kolom_penyusun = 2;
        // $kolom_ppk = 7;

        // $objWorksheet->setCellValueByColumnAndRow($kolom_ppk,$row,"Semarang, ". $this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir));
        // $row++;
        // $objWorksheet->setCellValueByColumnAndRow($kolom_penyusun,$row,"Penyusun Laporan");
        // $objWorksheet->setCellValueByColumnAndRow($kolom_ppk,$row,"Pejabat Pembuat Komitmen");
        // $row++;
        // $objWorksheet->setCellValueByColumnAndRow($kolom_ppk,$row,$this->Unit_kerja_model->get_nama_unit($unit));
        // $row += 4;
        // $objWorksheet->setCellValueByColumnAndRow($kolom_penyusun,$row,$penyusun['nama']);
        // $objWorksheet->setCellValueByColumnAndRow($kolom_ppk,$row,$ppk['nama']);
        // $row ++;
        // $objWorksheet->setCellValueByColumnAndRow($kolom_penyusun,$row,"NIP. " . $penyusun['nip']);
        // $objWorksheet->setCellValueByColumnAndRow($kolom_ppk,$row,"NIP. " . $ppk['nip']);

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

    public function cetak_buku_besar(){
        $tipe = $this->input->post('tipe');
        $akun = $this->input->post('akun')[0];
        $basis = $this->input->post('basis');
        $unit = $this->input->post('unit');
        $sumber_dana = $this->input->post('sumber_dana');
        $data['sumber'] = 'get_buku_besar';
        
        $daterange = $this->input->post('daterange');
        $date_t = explode(' - ', $daterange);
        $periode_awal = strtodate($date_t[0]);
        $periode_akhir = strtodate($date_t[1]) or null;    


        if ($unit == 'all') {
            $unit = null;
            // $mode = 'neraca';
            $data['teks_unit'] = "UNIVERSITAS DIPONEGORO";
        } else {
            $data['teks_unit'] = $this->Unit_kerja_model->get_nama_unit($unit);
            $data['teks_unit'] = strtoupper(str_replace('Fak.', "Fakultas ", $data['teks_unit']));
        }

        if ($sumber_dana == 'all') {
            $sumber_dana = null;
        }


        $array_akun = array();

        if ($akun == 'all') {
            $array_akun = array(1,2,3,4,5,6,7,8,9);
            $mode = 'neraca';

            $query_pajak = $this->db->query("SELECT kode_akun FROM akuntansi_pajak")->result();      

            if($basis=='kas'){
                $array_akun = array(2,3,4,5,8,9);
            }else{
                $array_akun = array(1,2,3,6,7,8,423141);
            }
            foreach ($query_pajak as $result) {
                $array_akun[] = $result->kode_akun;
            }
        }
        else {
            $array_akun[] = $akun;
        }



        $teks_sumber_dana = "BUKU BESAR ";
        $teks_periode = "";
        
        $teks_tahun = substr($periode_akhir,0,4);
        $data['teks_tahun_anggaran'] = "TAHUN ANGGARAN $teks_tahun";
        $mode = null;


        if ($periode_awal != null and $periode_akhir != null){
            $teks_periode .= "PER ".$this->Jurnal_rsa_model->reKonversiTanggal($periode_awal) . " - ".$this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir);
        }


        if ($sumber_dana != null) {
            $teks_sumber_dana .= "DARI DANA ".strtoupper(str_replace('_',' ',$sumber_dana));
        }

        $data['periode_text'] = $teks_periode;
        $data['unit'] = $unit;
        $data['periode_akhir'] = $this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir);
        $data['teks_tahun'] = substr($periode_akhir,0,4);
        // die($mode);

        // $data['query'] = $this->Laporan_model->get_data_buku_besar($array_akun,$basis,$unit,$sumber_dana,$periode_awal,$periode_akhir,$mode);
        $data['query'] = $this->Laporan_model->get_buku_besar($array_akun,$basis,$unit,$sumber_dana,$periode_awal,$periode_akhir,$mode);
        // print_r($data['query']);die();
        if($tipe=='pdf'){
            $this->load->view('akuntansi/laporan/pdf_buku_besar',$data);
        }else if($tipe=='excel'){
            $data['excel'] = true;
            $this->load->view('akuntansi/laporan/cetak_buku_besar',$data);
        }else{
            $this->load->view('akuntansi/laporan/cetak_buku_besar',$data);
        }

    }

    public function cetak_rekap_jurnal(){
        $tipe = $this->input->post('tipe');
        $basis = $this->input->post('basis');
        $unit = $this->input->post('unit');
        $sumber_dana = $this->input->post('sumber_dana');
        $data['sumber'] = 'get_rekap_jurnal';
        
        $daterange = $this->input->post('daterange');
        $date_t = explode(' - ', $daterange);
        $periode_awal = strtodate($date_t[0]);
        $periode_akhir = strtodate($date_t[1]) or null;

         if ($unit == 'all' or $unit == 9999) {
            if ($unit == 'all') {
                $unit = null;
            }
            // $unit = null;
            $data['teks_unit'] = "UNIVERSITAS DIPONEGORO";
        } else {
            $data['teks_unit'] = $this->Unit_kerja_model->get_nama_unit($unit);
            $data['teks_unit'] = strtoupper(str_replace('Fak.', "Fakultas ", $data['teks_unit']));
        }
        if ($sumber_dana == 'all') {
            $sumber_dana = null;
        } 

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

        $data['teks_periode'] = $teks_periode;
        $data['teks_tahun_anggaran'] = $teks_tahun_anggaran;

        $data['unit'] = $unit;
        $data['periode_akhir'] = $this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir);

        // print_r($this->input->post());die();
        // $akun = array(1,2,3,4,5,6,7,8,9);
        //public function read_rekap_jurnal($jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null)
        $data['query'] = $this->Laporan_model->read_rekap_jurnal($basis,$unit,$sumber_dana,$periode_awal,$periode_akhir);
        // print_r($data['query']);die();

        if($tipe=='pdf'){
            $this->load->view('akuntansi/laporan/pdf_rekap_jurnal',$data);
        }else if($tipe=='excel'){
            $data['excel'] = true;
            $this->load->view('akuntansi/laporan/cetak_rekap_jurnal',$data);
        }else{
            $this->load->view('akuntansi/laporan/cetak_rekap_jurnal',$data);
        }
    }

    public function cetak_neraca_saldo(){
        ini_set('memory_limit', '256M');       

        $basis = $this->input->post('basis');
        $tipe = $this->input->post('tipe');
        $daterange = $this->input->post('daterange');
        $date_t = explode(' - ', $daterange);
        $periode_awal = strtodate($date_t[0]);
        $periode_akhir = strtodate($date_t[1]) or null;
        $level = $this->input->post('level');

        // $query_pajak = $this->db->query("SELECT kode_akun FROM akuntansi_pajak")->result();      

        // if($basis=='kas'){
        //     $array_akun = array(4,5);
        // }else{
        //     $array_akun = array(6,7,423141);
        // }
        // foreach ($query_pajak as $result) {
        //     $array_akun[] = $result->kode_akun;
        // }

        $query_pajak = $this->db->query("SELECT kode_akun FROM akuntansi_pajak")->result();      

        if($basis=='kas'){
            $array_akun = array(4,5,8,9);
        }else{
            $array_akun = array(1,2,3,6,7,423141);
        }
        foreach ($query_pajak as $result) {
            $array_akun[] = $result->kode_akun;
        }
        
        $sumber_dana = $this->input->post('sumber_dana');
        if ($sumber_dana == 'all') {
            $sumber_dana = null;
        }
        $data['sumber'] = 'get_neraca_saldo';
        $unit = $this->input->post('unit');

        $teks_unit = null;


        if ($unit == 'all' or $unit == 'penerimaan') {
            $unit = null;
            $mode = 'neraca';
            $data['teks_unit'] = "UNIVERSITAS DIPONEGORO";
        } else {
            $data['teks_unit'] = $this->Unit_kerja_model->get_nama_unit($unit);
            $data['teks_unit'] = strtoupper(str_replace('Fak.', "Fakultas ", $data['teks_unit']));
        }

        // $data = $this->Laporan_model->get_data_buku_besar($akun,'akrual');
        // $data['query'] = $this->Laporan_model->get_data_buku_besar($array_akun,$basis,$unit,$sumber_dana,$periode_awal,$periode_akhir,'neraca');
        $data['query'] = $this->Laporan_model->get_neraca($array_akun,$basis,$unit,$sumber_dana,$periode_awal,$periode_akhir,'neraca');
        // print_r($data['query']);
        // die();
        
        ksort($data['query']);

        /*if ($level == 3) {
            $data_3 = array();
            foreach ($data['query'] as $akun => $entry) {
                foreach ($entry as $inner_entry) {
                    $check = $this->db->query("SELECT * FROM akuntansi_pajak WHERE kode_akun='".$akun."'");
                    if($check->num_rows() > 0){
                        $data_3[substr($akun,0,3).'-pajak'][] = $inner_entry;
                    }else{
                        $data_3[substr($akun,0,3)][] = $inner_entry;
                    }
                }
            }
            $data['query'] = $data_3;
        }*/
        /*print_r($data['query']);
        die();*/

        // print_r($data_3);die();




        $teks_sumber_dana = "NERACA SALDO ";
        $teks_periode = "";

        $teks_tahun_anggaran = substr($periode_akhir,0,4);
        $teks_unit = "UNIVERSITAS DIPONEGORO";

        if ($periode_awal != null and $periode_akhir != null){
            $teks_periode .= "PER ".$this->Jurnal_rsa_model->reKonversiTanggal($periode_awal) . " - ".$this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir);
        }


        if ($sumber_dana != null) {
            $teks_sumber_dana .= "DARI DANA ".strtoupper(str_replace('_',' ',$sumber_dana));
        }

        // ksort($data);

        $n_akun = count($data);

        $data['teks_periode'] = $teks_periode;
        $data['teks_tahun_anggaran'] = $teks_tahun_anggaran;
        $data['unit'] = $unit;
        $data['periode_akhir'] = $this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir);
        $data['level'] = $level;

        if($tipe=='pdf'){
            $this->load->view('akuntansi/laporan/pdf_neraca_saldo',$data);
        }else if($tipe=='excel'){
            $data['excel'] = true;
            $this->load->view('akuntansi/laporan/cetak_neraca_saldo',$data);
        }else{
            $this->load->view('akuntansi/laporan/cetak_neraca_saldo',$data);
        }
    }

    public function cetak_laporan_aktifitas(){
        $this->load->view('akuntansi/laporan/cetak_laporan_aktifitas');
    }

    public function cetak_laporan_posisi_keuangan(){
        $this->load->view('akuntansi/laporan/cetak_laporan_posisi_keuangan');
    }

    public function cetak_laporan_arus_kas(){
        $this->load->view('akuntansi/laporan/cetak_laporan_arus_kas');
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
        $unit = $this->input->post('unit');

        $teks_unit = null;


        if ($unit == 'all' or $unit == 9999) {
            $unit = null;
            $mode = 'neraca';
            $teks_unit = "UNIVERSITAS DIPONEGORO";
        } else {
            $teks_unit = $this->Unit_kerja_model->get_nama_unit($unit);
            $teks_unit = strtoupper(str_replace('Fak.', "Fakultas ", $teks_unit));
        }


    	// $data = $this->Laporan_model->get_data_buku_besar($akun,'akrual');
        $data = $this->Laporan_model->get_data_buku_besar($array_akun,$basis,$unit,$sumber_dana,$periode_awal,$periode_akhir,'neraca');
        // $data = $this->Laporan_model->get_neraca($array_akun,$basis,$unit,$sumber_dana,$periode_awal,$periode_akhir,'neraca');


        if ($data == null){
            $this->load->view('akuntansi/no_data',true);
            return 0;
        }

        $teks_sumber_dana = "NERACA SALDO ";
        $teks_periode = "";

        $teks_tahun_anggaran = substr($periode_akhir,0,4);

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

        $objWorksheet->setCellValueByColumnAndRow(0,1,$teks_unit);
        $objWorksheet->setCellValueByColumnAndRow(0,2,$teks_sumber_dana);
        $objWorksheet->setCellValueByColumnAndRow(0,3,$teks_periode);
        $objWorksheet->setCellValueByColumnAndRow(2,6,":".$teks_tahun_anggaran);
        $objWorksheet->setCellValueByColumnAndRow(2,5,":".$teks_unit);

        $jumlah_debet = 0;
	    $jumlah_kredit = 0;
        $jumlah_neraca_debet = 0;
        $jumlah_neraca_kredit = 0;

    	$row = 11;
    	$i = 1;

    	foreach ($data as $key => $entry) {
            // $key = '911101';
            $debet = 0;
            $kredit = 0;

            $case_hutang = in_array(substr($key,0,1),[2,3,4,6]);

	    	$saldo = $this->Akun_model->get_saldo_awal($key);
            if ($saldo != null) {
                $saldo = $saldo['saldo_awal'];
            }
	    	// $debet = 0;
	    	// $kredit = 0;
            // print_r($saldo);
	    	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1); 
	    	$objWorksheet->setCellValueByColumnAndRow(0,$row,$i);
	    	$objWorksheet->setCellValueByColumnAndRow(1,$row,$key);
	    	$objWorksheet->setCellValueByColumnAndRow(2,$row,$this->Akun_model->get_nama_akun((string)$key));


    		foreach ($entry as $transaksi) {
    			if ($transaksi['tipe'] == 'debet'){
                    if ($case_hutang) {
                        $saldo -= $transaksi['jumlah'];
                    } else {
                        $saldo += $transaksi['jumlah'];
                    }
    				$debet += $transaksi['jumlah'];
    			} else if ($transaksi['tipe'] == 'kredit'){
                    if ($case_hutang) {
                        $saldo += $transaksi['jumlah'];
                    } else {
                        $saldo -= $transaksi['jumlah'];
                    }
					$kredit += $transaksi['jumlah'];
    			}
    		}


    		$jumlah_debet += $debet;
    		$jumlah_kredit += $kredit;

    		$objWorksheet->setCellValueByColumnAndRow(3,$row,$this->eliminasi_negatif($debet));
    		$objWorksheet->setCellValueByColumnAndRow(4,$row,$this->eliminasi_negatif($kredit));


            if ($case_hutang) {
                $saldo_neraca = $kredit - $debet;
            } else {
                $saldo_neraca = $debet - $kredit;
            }


            $objWorksheet->setCellValueByColumnAndRow(5,$row,0);
            $objWorksheet->setCellValueByColumnAndRow(6,$row,0);

            if ($saldo_neraca > 0) {
                $jumlah_neraca_debet += $saldo_neraca;
                $objWorksheet->setCellValueByColumnAndRow(5,$row,$this->eliminasi_negatif($saldo_neraca));
            } elseif ($saldo_neraca < 0) {
                $saldo_neraca = abs($saldo_neraca);
                $jumlah_neraca_kredit += $saldo_neraca;
                $objWorksheet->setCellValueByColumnAndRow(6,$row,$this->eliminasi_negatif($saldo_neraca));
            }

    		$row++;

    		$i++;
    		// $objWorksheet->setCellValueByColumnAndRow(2,$i+$row,$i+1);
    	}

        $objWorksheet->setCellValueByColumnAndRow(3,$row+1,$this->eliminasi_negatif($jumlah_debet));
        $objWorksheet->setCellValueByColumnAndRow(4,$row+1,$this->eliminasi_negatif($jumlah_kredit));
    	$objWorksheet->setCellValueByColumnAndRow(5,$row+1,$this->eliminasi_negatif($jumlah_neraca_debet));
    	$objWorksheet->setCellValueByColumnAndRow(6,$row+1,$this->eliminasi_negatif($jumlah_neraca_kredit));

        //===========================


        //===========================

        if ($unit == null or $unit == 9999) {
            $kpa = $this->Pejabat_model->get_pejabat('all','rektor');
            $teks_kpa = "Rektor";
        } else {
            $kpa = $this->Pejabat_model->get_pejabat($unit,'kpa');
            $teks_kpa = "Pengguna Anggaran";
        }

        $row = $objWorksheet->getHighestRow() + 2;
        $kolom_kpa = 5;

        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,"Semarang, ". $this->Jurnal_rsa_model->reKonversiTanggal($periode_akhir));
        $row++;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,$teks_kpa);
        $row++;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,$teks_unit);
        $row += 4;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+2,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,$kpa['nama']);
        $row ++;
        $objWorksheet->mergeCellsByColumnAndRow($kolom_kpa,$row,$kolom_kpa+1,$row);
        $objWorksheet->setCellValueByColumnAndRow($kolom_kpa,$row,"NIP. " . $this->format_nip($kpa['nip']));

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

    public function get_lpk($level, $parse_data = null)
    {       
        $jumlah_tahun_sekarang = 0;
        $jumlah_tahun_awal = 0;
        $array_akun = array(1,2,3);
        $year = gmdate('Y');
        $start_date = "$year-01-01";
        $end_date = "$year-31-12";
        $data = $this->Laporan_model->get_rekap($array_akun,null,'akrual',null,'saldo');
        $tabel_akun = array(
            1 => 'aset',
            2 => 'hutang',
            3 => 'aset_bersih',
        );
        $akun = array();

        // $array_akun = array(
        //     array(
        //         'akun' => 1,
        //         'special_case' => array(
        //                                 array(
        //                                     'order'=> 0,
        //                                     'akun' => array(111),
        //                                     'not_akun'=>null,
        //                                     'akun_pengurang' =>null,
        //                                 ),
        //                                 array(
        //                                     'order'=> 1,
        //                                     'akun' => array(112),
        //                                     'not_akun'=>null,
        //                                     'akun_pengurang' =>null,
        //                                 ),
        //                                 array(
        //                                     'order'=> 2,
        //                                     'akun' => array(1131,1132),
        //                                     'not_akun'=>null,
        //                                     'akun_pengurang' =>array(1133),
        //                                 ),
        //                                 array(
        //                                     'order'=> 3,
        //                                     'akun' => array(114),
        //                                     'not_akun'=>null,
        //                                     'akun_pengurang' =>null,
        //                                 ),
        //                                 array(
        //                                     'order'=> 3,
        //                                     'akun' => array(115),
        //                                     'not_akun'=>null,
        //                                     'akun_pengurang' =>null,
        //                                 ),
        //                             )
        //     ),

        // );

        foreach ($array_akun as $kd_awal) {
            $akun = $akun + $this->Akun_model->get_akun_by_level($kd_awal,$level,$tabel_akun[$kd_awal]);
        }


        $rekap = array();

        foreach ($data['posisi'] as $kd_akun => $entry) {
            foreach ($entry as $inner_entry) {
                $rekap[substr($kd_akun,0,$level)][$inner_entry['tipe']] = 0;
            }
        }

        foreach ($data['posisi'] as $kd_akun => $entry) {
            foreach ($entry as $inner_entry) {
                $rekap[substr($kd_akun,0,$level)][$inner_entry['tipe']] += $inner_entry['jumlah'];
            }
        }

        foreach ($data['saldo'] as $kd_akun => $entry) {
            $rekap[substr($kd_akun,0,$level)]['saldo_awal'] = 0;
        }

        foreach ($data['saldo'] as $kd_akun => $entry) {
            $rekap[substr($kd_akun,0,$level)]['saldo_awal'] += $entry;
        }

        // print_r($data);
        // print_r($akun);
        // print_r($rekap);
        // die();
        $order = 0;
        $parsed = array();
        $entry_parsed = array();

        $data['akun'] = $akun;
        foreach ($akun as $key_1 => $akun_1) {
            $nama = $this->Akun_model->get_nama_akun_by_level($key_1,1,$tabel_akun[$key_1]);
            $data['nama_lvl_1'][$key_1][] = $nama;
            $entry_parsed = array(
               'order' => ++$order,
               'level' => 0,
               'akun' => $key_1,
               'type' => 'index',
               'nama' => $nama,
               'start_sum' => null,
               'end_sum' => null,
               'sum_negatif' => null,
               'jumlah_now' => null,
               'jumlah_last' => null,
               'selisih' => null,
               'persentase' => null,
            );
            $parsed[] = $entry_parsed;
            //echo "$key_1 - $nama<br/>";
            foreach($akun_1 as $key_2 => $akun_2){
                $nama = $this->Akun_model->get_nama_akun_by_level($key_2,2,$tabel_akun[$key_1]);
                $data['nama_lvl_2'][$key_1][] = $nama;
                $data['key_lvl_2'][] = $key_2;

                $entry_parsed = array(
                   'order' => ++$order,
                   'level' => 1,
                   'akun' => $key_2,
                   'type' => 'index',
                   'nama' => $nama,
                   'sum_negatif' => null,
                   'start_sum' => null,
                   'end_sum' => null,
                   'jumlah_now' => null,
                   'jumlah_last' => null,
                   'selisih' => null,
                   'persentase' => null,
                );

                $parsed[] = $entry_parsed;

                //echo "&nbsp;&nbsp;$key_2 -  $nama<br/>";
                foreach ($akun_2 as $key_3 => $akun_3) {
                    if ($level == 4) {
                        $nama = $this->Akun_model->get_nama_akun_by_level($key_3,3,$tabel_akun[$key_1]);
                        $data['nama_lvl_3'][$key_2][] = $nama;
                        $data['key_lvl_3'][] = $key_3;
                        $entry_parsed = array(
                           'order' => ++$order,
                           'level' => 2,
                           'akun' => $key_3,
                           'type' => 'index',
                           'nama' => $nama,
                           'sum_negatif' => null,
                           'start_sum' => null,
                           'end_sum' => null,
                           'jumlah_now' => null,
                           'jumlah_last' => null,
                           'selisih' => null,
                           'persentase' => null,
                        );

                        $parsed[] = $entry_parsed;

                        //echo "&nbsp;&nbsp;&nbsp;&nbsp;$key_3 - $nama<br/>";
                        foreach ($akun_3 as $key_4 => $akun_4) {
                            $debet = (isset($rekap[$key_4]['debet'])) ? $rekap[$key_4]['debet'] : 0 ;
                            $kredit = (isset($rekap[$key_4]['kredit'])) ? $rekap[$key_4]['kredit'] : 0 ;
                            if ($this->case_hutang($key_4)) {
                                $saldo_sekarang = $kredit - $debet;
                            } else {
                                $saldo_sekarang = $debet - $kredit;
                            }
                            $saldo_awal = (isset($rekap[$key_4]['saldo_awal'])) ? $rekap[$key_4]['saldo_awal'] : 0 ;
                            $nama = $akun_4['nama'];
                            $data['nama_lvl_4'][$key_3][] = $nama;
                            $data['saldo_sekarang_lvl_4'][$key_3][] = $saldo_sekarang;
                            $data['saldo_awal_lvl_4'][$key_3][] = $saldo_awal;
                            $jumlah_tahun_sekarang += $saldo_sekarang;
                            $jumlah_tahun_awal += $saldo_awal;
                            $entry_parsed = array(
                               'order' => ++$order,
                               'level' => 4,
                               'akun' => $key_4,
                               'type' => 'entry',
                               'nama' => $nama,
                               'sum_negatif' => null,
                               'start_sum' => null,
                               'end_sum' => null,
                               'jumlah_now' => $this->eliminasi_negatif($saldo_sekarang),
                               'jumlah_last' => $this->eliminasi_negatif($saldo_awal),
                               'selisih' => abs($saldo_sekarang - $saldo_awal),
                               'persentase' => ($saldo_awal == 0 or $saldo_sekarang == 0) ? 0 : abs($saldo_sekarang - $saldo_awal) / $saldo_awal * 100 ,
                            );
                            $parsed[] = $entry_parsed;
                            //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$key_4 - $nama|$saldo_sekarang|$saldo_awal<br/>";
                        }
                    } else {
                        $debet = (isset($rekap[$key_3]['debet'])) ? $rekap[$key_3]['debet'] : 0 ;
                        $kredit = (isset($rekap[$key_3]['kredit'])) ? $rekap[$key_3]['kredit'] : 0 ;
                        if ($this->case_hutang($key_3)) {
                            $saldo_sekarang = $kredit - $debet;
                        } else {
                            $saldo_sekarang = $debet - $kredit;
                        }
                        $saldo_awal = (isset($rekap[$key_3]['saldo_awal'])) ? $rekap[$key_3]['saldo_awal'] : 0 ;
                        $nama = $akun_3['nama'];
                        $data['nama_lvl_3'][$key_2][] = $nama;
                        $data['saldo_sekarang_lvl_3'][$key_2][] = $saldo_sekarang;
                        $data['saldo_awal_lvl_3'][$key_2][] = $saldo_awal;
                        $jumlah_tahun_sekarang += $saldo_sekarang;
                        $jumlah_tahun_awal += $saldo_awal;

                        $entry_parsed = array(
                           'order' => ++$order,
                           'level' => 3,
                           'akun' => $key_3,
                           'type' => 'entry',
                           'nama' => $nama,
                           'sum_negatif' => null,
                           'start_sum' => null,
                           'end_sum' => null,
                           'jumlah_now' => $this->eliminasi_negatif($saldo_sekarang),
                           'jumlah_last' => $this->eliminasi_negatif($saldo_awal),
                           'selisih' => abs($saldo_sekarang - $saldo_awal),
                           'persentase' => ($saldo_awal == 0 or $saldo_sekarang == 0) ? 0 : abs($saldo_sekarang - $saldo_awal) / $saldo_awal * 100 ,
                        );
                        $parsed[] = $entry_parsed;
                        //echo "&nbsp;&nbsp;&nbsp;&nbsp;$key_3  - $nama |$saldo_sekarang|$saldo_awal<br/>";
                    }
                }
            }
        }
        // foreach ($parsed as $val) {
        //     $entry = $val;
        //     for ($i=0; $i < $val['level']; $i++) { 
        //         echo "&nbsp;&nbsp;";
        //     }
        //     echo $entry['nama'] ." ". $entry['jumlah_now']  ." ". $entry['jumlah_last']  ."<br/> ";
        // }
        // die();

        // public function add_after_parse(&$parse,$jenis,$nama = null,$after,$array_akun,$level,$start_date,$end_date,$special_case = null)

        $this->add_after_parse($parsed,'lpk','Piutang Netto',121,array(1131,1132),3,$start_date,$end_date,array('pengurangan' => 1133));
        print_r($parsed);die();

        // $this->remove_parse($parsed,112);

        unset($data['posisi']);
        unset($data['saldo']);
        $data['atribut'] = $parse_data;
        $data['level'] = $level;
        $data['jumlah_tahun_sekarang'] = $jumlah_tahun_sekarang;
        $data['jumlah_tahun_awal'] = $jumlah_tahun_awal;
        $this->load->view('akuntansi/laporan/cetak_laporan_posisi_keuangan', $data);
    }

    public function get_lapak($level, $parse_data)
    {
        $jumlah_tahun_sekarang = 0;
        $jumlah_tahun_awal = 0;
        // $array_akun = array(6,7);
        $sumber_dana = array('tidak_terikat','terikat_temporer','terikat_permanen');
        $array_pembatasan = array(
            'tidak_terikat' => array(61,73,79),
            'terikat_temporer' => array(62,73,79),
            'terikat_permanen' => array(61,621,623,624,626,627,628,629,73,79)
        );

        $array_akun = array(
            'tidak_terikat' => array(6,7),
            'terikat_temporer' => array(6,7),
            'terikat_permanen' => array(6,7)
        );

        $array_aset = array();
        $array_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'] = array(3);

        $year = gmdate('Y');
        $last_year = $year - 1;

        if ($year == '2017') {
            $temp_aset = $this->Laporan_model->get_rekap($array_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'],null,'akrual',null,'saldo',"$year-01-01","$year-06-30");

            $aset_tahun_ini = array_sum($temp_aset['saldo']);
            $data_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'] = $aset_tahun_ini;
            $data_aset['tahun_ini'] = $aset_tahun_ini;


            $aset_tahun_lalu = 0;
            $data_aset['tahun_lalu'] = $aset_tahun_lalu;
        } else {
            $temp_aset = $this->Laporan_model->get_rekap($array_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'],null,'akrual',null,'saldo',"$year-01-01","$year-06-30");
            $aset_tahun_ini = array_sum($temp_aset['saldo']);
            $data_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'] = $aset_tahun_ini;
            $data_aset['tahun_ini'] = $aset_tahun_ini;

            $temp_aset = $this->Laporan_model->get_rekap($array_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'],null,'akrual',null,'saldo',"$last_year-01-01","$last_year-06-30");
            $aset_tahun_lalu = array_sum($temp_aset['saldo']);

            $data_aset['tahun_lalu'] = $aset_tahun_lalu;
        }        


        foreach ($sumber_dana as $jenis_pembatasan) {
            $data_all[$jenis_pembatasan] = $this->Laporan_model->get_rekap($array_akun[$jenis_pembatasan],$array_pembatasan[$jenis_pembatasan],'akrual',null,'saldo',$jenis_pembatasan);         
        }

        $tabel_akun = array(
            1 => 'aset',
            2 => 'hutang',
            3 => 'aset_bersih',
            4 => 'lra',
            5 => 'akun_belanja',
            6 => 'lra',
            7 => 'akun_belanja'
        );
        $urutan = array();
        $akun = array();       
        // print_r($akun);die();


        foreach ($data_all as $jenis_pembatasan => $data) {
            $akun = array();
            foreach ($array_akun[$jenis_pembatasan] as $kd_awal) {
                $kd_awal = substr($kd_awal,0,1);
                $akun = $akun + $this->Akun_model->get_akun_by_level($kd_awal,$level,$tabel_akun[$kd_awal],$array_pembatasan[$jenis_pembatasan]);
            }
            // if ($jenis_pembatasan == 'terikat_permanen') {
            //     print_r($data_all[$jenis_pembatasan]);die();
            // }

            $data_parsing['jenis_pembatasan'][] = $jenis_pembatasan;
            //echo "<hr/>".$jenis_pembatasan."<hr/>";
            $rekap = array();

            foreach ($data['posisi'] as $kd_akun => $entry) {
                foreach ($entry as $inner_entry) {
                    $rekap[substr($kd_akun,0,$level)][$inner_entry['tipe']] = 0;
                }
            }

            foreach ($data['posisi'] as $kd_akun => $entry) {
                foreach ($entry as $inner_entry) {
                    $rekap[substr($kd_akun,0,$level)][$inner_entry['tipe']] += $inner_entry['jumlah'];
                }
            }

            foreach ($data['saldo'] as $kd_akun => $entry) {
                $rekap[substr($kd_akun,0,$level)]['saldo_awal'] = 0;
            }

            foreach ($data['saldo'] as $kd_akun => $entry) {
                $rekap[substr($kd_akun,0,$level)]['saldo_awal'] += $entry;
            }

            // print_r($data);
            // print_r($akun);
            // print_r($rekap);
            // die();
            $data_parsing['akun'] = $akun;
            foreach ($akun as $key_1 => $akun_1) {
                $nama = $this->Akun_model->get_nama_akun_by_level($key_1,1,$tabel_akun[$key_1]);
                $data_parsing['nama_lvl_1'][$jenis_pembatasan][$key_1][] = $nama;
                $data_parsing['key_level_1'][] = $key_1;
                //echo "$key_1 - $nama<br/>";
                foreach($akun_1 as $key_2 => $akun_2){
                    $nama = $this->Akun_model->get_nama_akun_by_level($key_2,2,$tabel_akun[$key_1]);
                    $data_parsing['nama_lvl_2'][$jenis_pembatasan][$key_1][] = $nama;
                    $data_parsing['key_lvl_2'][] = $key_2;
                    //echo "&nbsp;&nbsp;$key_2 -  $nama<br/>";
                    foreach ($akun_2 as $key_3 => $akun_3) {
                        if ($level == 4) {
                            $nama = $this->Akun_model->get_nama_akun_by_level($key_3,3,$tabel_akun[$key_1]);
                            $data_parsing['nama_lvl_3'][$jenis_pembatasan][$key_2][] = $nama;
                            $data_parsing['key_lvl_3'][] = $key_3;
                            //echo "&nbsp;&nbsp;&nbsp;&nbsp;$key_3 - $nama<br/>";
                            foreach ($akun_3 as $key_4 => $akun_4) {
                                $debet = (isset($rekap[$key_4]['debet'])) ? $rekap[$key_4]['debet'] : 0 ;
                                $kredit = (isset($rekap[$key_4]['kredit'])) ? $rekap[$key_4]['kredit'] : 0 ;

                                if ($this->case_hutang($key_4)) {
                                    $saldo_sekarang = $kredit - $debet;
                                } else {
                                    $saldo_sekarang = $debet - $kredit;
                                }
                                
                                $saldo_awal = (isset($rekap[$key_4]['saldo_awal'])) ? $rekap[$key_4]['saldo_awal'] : 0 ;
                                $nama = $akun_4['nama'];
                                $data_parsing['nama_lvl_4'][$jenis_pembatasan][$key_3][] = $nama;
                                $data_parsing['saldo_sekarang_lvl_4'][$jenis_pembatasan][$key_3][] = $saldo_sekarang;
                                $data_parsing['saldo_awal_lvl_4'][$jenis_pembatasan][$key_3][] = $saldo_awal;
                                $jumlah_tahun_sekarang += $saldo_sekarang;
                                $jumlah_tahun_awal += $saldo_awal;
                                //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$key_4 - $nama|$saldo_sekarang|$saldo_awal<br/>";
                            }
                        } else {
                            $debet = (isset($rekap[$key_3]['debet'])) ? $rekap[$key_3]['debet'] : 0 ;
                            $kredit = (isset($rekap[$key_3]['kredit'])) ? $rekap[$key_3]['kredit'] : 0 ;
                            
                            if ($this->case_hutang($key_3)) {
                                $saldo_sekarang = $kredit - $debet;
                            } else {
                                $saldo_sekarang = $debet - $kredit;
                            }

                            $saldo_awal = (isset($rekap[$key_3]['saldo_awal'])) ? $rekap[$key_3]['saldo_awal'] : 0 ;
                            $nama = $akun_3['nama'];
                            $data_parsing['nama_lvl_3'][$jenis_pembatasan][$key_2][] = $nama;
                            $data_parsing['saldo_sekarang_lvl_3'][$jenis_pembatasan][$key_2][] = $saldo_sekarang;
                            $data_parsing['saldo_awal_lvl_3'][$jenis_pembatasan][$key_2][] = $saldo_awal;
                            $jumlah_tahun_sekarang += $saldo_sekarang;
                            $jumlah_tahun_awal += $saldo_awal;
                            //echo "&nbsp;&nbsp;&nbsp;&nbsp;$key_3  - $nama |$saldo_sekarang|$saldo_awal<br/>";
                        }
                    }
                }
            }
        }

        $data_parsing['atribut'] = $parse_data;
        $data_parsing['level'] = $level;
        $data_parsing['jumlah_tahun_sekarang'] = $jumlah_tahun_sekarang;
        $data_parsing['jumlah_tahun_awal'] = $jumlah_tahun_awal;
        $this->load->view('akuntansi/laporan/cetak_laporan_aktifitas', $data_parsing);
    }

    public function get_laporan_arus($level, $parse_data)
    {
        $array_akun = array(6,7);
        $data = array();
        $data_all = array();
        $array_investasi = array();
        $array_pendanaan = array();
        $array_not_pendanaan = array();
        $array_not_investasi = array();
        $array_special_investasi = array();


        $start_date = '2017-01-01';
        $end_date = '2017-12-31';
        
        $array_investasi['fluk_investasi'] = array(112);
        $array_investasi['fluk_penyertaan_ke_unit_usaha'] = array(121);
        $array_investasi['perolehan_aset_tetap'] = array(531,532,533,534,535,536);
        $array_investasi['hasil_penjualan_aset_tetap'] = array('penjualan aset tetap');
        $array_investasi['perolehan_persediaan'] = array(52111,52121,521214,521215,521216,521217);
        /*$array_investasi['lima_tiga'] = array(53);
        $array_investasi['lima_dua_satu'] = array(521);*/
        $array_investasi['penambahan_hasil_tak_berwujud'] = array(5371);
        // $array_investasi['investasi'] = array(121,112);
        $array_investasi['penerimaan_hasil_investasi'] = array(428);

        $array_not_investasi['perolehan_aset_tetap'] = array(521213,521212,52122);
        $array_not_investasi['lima_dua_satu'] = array(521213,521212,52122);

        $array_pendanaan['pendanaan_masuk']['perolehan_pinjaman'] = array(2);
        $array_pendanaan['pendanaan_masuk']['penerimaan_kembali_pokok_pinjaman'] = array(2);
        $array_pendanaan['pendanaan_masuk']['investasi'] = array(1);

        $array_pendanaan['pendanaan_keluar']['pemberian_pinjaman'] = array(1);
        $array_pendanaan['pendanaan_keluar']['pembayaran_kewajiban_jangka_pendek'] = array(21);
        $array_pendanaan['pendanaan_keluar']['pembayaran_kewajiban_jangka_panjang'] = array(22);

        $array_uraian_investasi['penerimaan_hasil_investasi'] = array('penerimaan hasil investasi');

        $array_special_investasi['perolehan_aset_tetap'] = array('tipe' => 'perubahan');
        $array_special_investasi['penambahan_hasil_tak_berwujud'] = array('tipe' => 'perubahan');
        $array_special_investasi['fluk_investasi'] = array('tipe' => 'perubahan');
        $array_special_investasi['fluk_penyertaan_ke_unit_usaha'] = array('tipe' => 'perubahan');


        $array_uraian['pendanaan_masuk']['perolehan_pinjaman'] = array('perolehan pinjaman','perolehan hutang','perolehan kewajiban');
        $array_uraian['pendanaan_masuk']['penerimaan_kembali_pokok_pinjaman'] = array('penerimaan kembali pokok pinjaman','penerimaan kembali pokok hutang','penerimaan kembali pokok kewajiban');
        $array_uraian['pendanaan_masuk']['investasi'] = array('pendanaan masuk investasi');

        $array_uraian['pendanaan_keluar']['pemberian_pinjaman'] = array('pemberian pinjaman');
        $array_uraian['pendanaan_keluar']['pembayaran_kewajiban_jangka_pendek'] = array('hutang','pembayaran pinjaman jangka pendek','pembayaran hutang jangka pendek','pembayaran kewajiban jangka pendek');
        $array_uraian['pendanaan_keluar']['pembayaran_kewajiban_jangka_panjang'] = array('hutang','pembayaran pinjaman jangka panjang','pembayaran hutang jangka panjang','pembayaran kewajiban jangka panjang');

        $sumber_dana = array('tidak_terikat','terikat_temporer','terikat_permanen');

        $array_akun = array(
                        array( 
                              'jenis_pembatasan' => 'tidak_terikat',
                              'list_akun' => array(6),
                              'special_case' => array(
                                                'jenis_pembatasan' => array('terikat_temporer','tidak_terikat'),
                                                'not_akun' => array(array(62),array(61))
                                        )

                            ),
                        array(
                              'jenis_pembatasan' => 'terikat_temporer',
                              'list_akun' => array(7)
                            ),
                        array(
                              'jenis_pembatasan' => 'tidak_terikat',
                              'list_akun' => array(7)
                            ),
        );

        $array_pembatasan = array(
            'tidak_terikat' => null,
            'terikat_temporer' => null,
            'terikat_permanen' => null
        );

        foreach ($array_akun as $key => $detail_pembatasan) {
            $jenis_pembatasan = $detail_pembatasan['jenis_pembatasan'];
            $temp_data = array();
            if (isset($detail_pembatasan['special_case'])) {
                $temp1 = array();
                $in_data = array();
                $in_data['saldo'] = array();
                $in_data['posisi'] = array();
                for ($i=0; $i < count($detail_pembatasan['special_case']['not_akun']); $i++) { 
                    $in_jenis_pembatasan = $detail_pembatasan['special_case']['jenis_pembatasan'][$i];
                    $in_not_akun = $detail_pembatasan['special_case']['not_akun'][$i];
                    $temp1 = $this->Laporan_model->get_rekap($array_akun[$key]['list_akun'],$in_not_akun,'akrual',null,'saldo',$in_jenis_pembatasan);
                    // $in_data = array_merge($in_data,$temp1);
                    // print_r($temp1);
                    $in_data['saldo'] +=  $temp1['saldo'];
                    $in_data['posisi'] +=  $temp1['posisi'];
                }
                $temp_data['data'] = $in_data;
            } else {
                $temp_data['data'] = $this->Laporan_model->get_rekap($array_akun[$key]['list_akun'],$array_pembatasan[$jenis_pembatasan],'akrual',null,'saldo',$jenis_pembatasan);
            }
            $temp_data['jenis_pembatasan'] = $jenis_pembatasan;
            $data_all[] = $temp_data;     
        }

        // print_r($data);die();


        //get_rekap($array_akun,$array_not_akun = null,$jenis=null,$unit=null,$laporan = null,$sumber_dana = null,$start_date = null, $end_date = null)


        $data_investasi = array();
        $data_pendanaan = array();
        foreach ($array_investasi as $nama => $akun) {
            $array_not = null;
            $array_kata = null;
            if (isset($array_not_investasi[$nama])) {
                $array_not = $array_not_investasi[$nama];
            }
            if (isset($array_uraian_investasi[$nama])){
                $array_kata = $array_uraian_investasi[$nama];
            }
            $data_investasi[$nama] = $this->Laporan_model->get_rekap($akun,$array_not,'akrual',null,'sum',null,$start_date,$end_date,$array_kata);
        }

        // print_r($data_investasi['investasi']);die();

        foreach ($array_pendanaan as $pendanaan => $sub_array_pendanaan ) {
            foreach ($sub_array_pendanaan as $nama => $akun) {
                $array_kata = null;
                $array_not = null;
                if (isset($array_not_investasi[$nama])) {
                    $array_not = $array_not_investasi[$nama];
                }
                if (isset($array_uraian[$pendanaan][$nama])) {
                    $array_kata = $array_uraian[$pendanaan][$nama];
                }
                $data_pendanaan[$pendanaan][$nama] = $this->Laporan_model->get_rekap($akun,null,'akrual',null,'sum',null,$start_date,$end_date,$array_kata);
            }
        }

        // print_r($data_investasi);
        // print_r($data_pendanaan);die();


        // $data = $this->Laporan_model->get_rekap($array_akun,null,'akrual',null,'saldo');
        $tabel_akun = array(
            1 => 'aset',
            2 => 'hutang',
            3 => 'aset_bersih',
            4 => 'lra',
            5 => 'akun_belanja',
            6 => 'lra',
            7 => 'akun_belanja'
        );
        $urutan = array();
        $akun = array();
        // print_r($akun);die();



        $rekap = array();

        $data_parsing['data_investasi'] = $data_investasi;
        $data_parsing['data_pendanaan'] = $data_pendanaan;
        $data_parsing['data_all'] = $data_all;
        
        /*------------------------------------------------*/
        /*-------------- dari aktifitas ------------------*/
        /*------------------------------------------------*/
        $data_all = array();

        $jumlah_tahun_sekarang = 0;
        $jumlah_tahun_awal = 0;
        // $array_akun = array(6,7);
        $sumber_dana = array('tidak_terikat','terikat_temporer','terikat_permanen');
        $array_pembatasan = array(
            'tidak_terikat' => array(61,73,79),
            'terikat_temporer' => array(62,73,79),
            'terikat_permanen' => array(61,621,623,624,626,627,628,629,73,79)
        );

        $array_akun = array(
            'tidak_terikat' => array(6,7),
            'terikat_temporer' => array(6,7),
            'terikat_permanen' => array(6,7)
        );

        $array_akun = array(
            array(
                    'order' => 1,
                    'akun' => array(6),
                    'not_akun' => $array_pembatasan['terikat_temporer'],
                    'pembatasan' => 'terikat_temporer'
            ),
            array(
                    'order' => 2,
                    'akun' => array(6),
                    'not_akun' => $array_pembatasan['tidak_terikat'],
                    'pembatasan' => 'tidak_terikat'
            ),
            array(
                    'order' => 3,
                    'akun' => array(7),
                    'not_akun' => $array_pembatasan['terikat_temporer'],
                    'pembatasan' => 'terikat_temporer'
            ),
            array(
                    'order' => 4,
                    'akun' => array(7),
                    'not_akun' => $array_pembatasan['tidak_terikat'],
                    'pembatasan' => 'tidak_terikat'
            ),
        );

        $array_aset = array();
        $array_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'] = array(3);

        $year = gmdate('Y');
        $last_year = $year - 1;

        if ($year == '2017') {
            $temp_aset = $this->Laporan_model->get_rekap($array_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'],null,'akrual',null,'saldo',"$year-01-01","$year-06-30");

            $aset_tahun_ini = array_sum($temp_aset['saldo']);
            $data_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'] = $aset_tahun_ini;
            $data_aset['tahun_ini'] = $aset_tahun_ini;


            $aset_tahun_lalu = 0;
            $data_aset['tahun_lalu'] = $aset_tahun_lalu;
        } else {
            $temp_aset = $this->Laporan_model->get_rekap($array_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'],null,'akrual',null,'saldo',"$year-01-01","$year-06-30");
            $aset_tahun_ini = array_sum($temp_aset['saldo']);
            $data_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'] = $aset_tahun_ini;
            $data_aset['tahun_ini'] = $aset_tahun_ini;

            $temp_aset = $this->Laporan_model->get_rekap($array_aset['aset_bersih_kekayaan_awal_PTN_badan_hukum'],null,'akrual',null,'saldo',"$last_year-01-01","$last_year-06-30");
            $aset_tahun_lalu = array_sum($temp_aset['saldo']);

            $data_aset['tahun_lalu'] = $aset_tahun_lalu;
        }        


        // foreach ($sumber_dana as $jenis_pembatasan) {
        //     $data_all[$jenis_pembatasan] = $this->Laporan_model->get_rekap($array_akun[$jenis_pembatasan],$array_pembatasan[$jenis_pembatasan],'akrual',null,'saldo',$jenis_pembatasan);         
        // }

        foreach ($array_akun as $data) {
            $data_all[$data['order']]['pembatasan'] = $data['pembatasan'];
            $data_all[$data['order']]['saldo'] = array();
            $data_all[$data['order']]['posisi'] = array();
        }

        foreach ($array_akun as $data) {
            $temp_data = $this->Laporan_model->get_rekap($data['akun'],$data['not_akun'],'akrual',null,'saldo',$data['pembatasan']);
            $data_all[$data['order']]['saldo'] += $temp_data['saldo'];
            $data_all[$data['order']]['posisi'] += $temp_data['posisi'];
        }

        $tabel_akun = array(
            1 => 'aset',
            2 => 'hutang',
            3 => 'aset_bersih',
            4 => 'lra',
            5 => 'akun_belanja',
            6 => 'lra',
            7 => 'akun_belanja'
        );
        $urutan = array();
        $akun = array();       
        // print_r($data_all);die();


        foreach ($data_all as $order => $data) {
            // print_r($data);die();
            $order -= 1;
            $data_akun = $array_akun[$order];
            $jenis_pembatasan = $data_akun['pembatasan'];

            $akun = array();
            foreach ($array_akun[$order]['akun'] as $kd_awal) {
                $kd_awal = substr($kd_awal,0,1);
                $akun = $akun + $this->Akun_model->get_akun_by_level($kd_awal,$level,$tabel_akun[$kd_awal],$array_pembatasan[$jenis_pembatasan]);
            }
            // if ($jenis_pembatasan == 'terikat_permanen') {
            //     print_r($data_all[$jenis_pembatasan]);die();
            // }

            $data_parsing['jenis_pembatasan'][] = $jenis_pembatasan;
            //echo "<hr/>".$jenis_pembatasan."<hr/>";
            $rekap = array();

            foreach ($data['posisi'] as $kd_akun => $entry) {
                foreach ($entry as $inner_entry) {
                    $rekap[substr($kd_akun,0,$level)][$inner_entry['tipe']] = 0;
                }
            }

            foreach ($data['posisi'] as $kd_akun => $entry) {
                foreach ($entry as $inner_entry) {
                    $rekap[substr($kd_akun,0,$level)][$inner_entry['tipe']] += $inner_entry['jumlah'];
                }
            }

            foreach ($data['saldo'] as $kd_akun => $entry) {
                $rekap[substr($kd_akun,0,$level)]['saldo_awal'] = 0;
            }

            foreach ($data['saldo'] as $kd_akun => $entry) {
                $rekap[substr($kd_akun,0,$level)]['saldo_awal'] += $entry;
            }

            $replacer = 
            $hasil = 

            // print_r($data);
            // print_r($akun);
            // print_r($rekap);
            // die();
            $data_parsing['akun'][$order] = $akun;
            $data_parsing['order'][] = $order;
            foreach ($akun as $key_1 => $akun_1) {
                $nama = $this->Akun_model->get_nama_akun_by_level($key_1,1,$tabel_akun[$key_1]);
                $data_parsing['nama_lvl_1'][$order][$key_1][] = $nama;
                $data_parsing['key_level_1'][] = $key_1;
                //echo "$key_1 - $nama<br/>";
                foreach($akun_1 as $key_2 => $akun_2){
                    $nama = $this->Akun_model->get_nama_akun_by_level($key_2,2,$tabel_akun[$key_1]);
                    $data_parsing['nama_lvl_2'][$order][$key_1][] = $nama;
                    $data_parsing['key_lvl_2'][] = $key_2;
                    //echo "&nbsp;&nbsp;$key_2 -  $nama<br/>";
                    foreach ($akun_2 as $key_3 => $akun_3) {
                        if ($level == 4) {
                            $nama = $this->Akun_model->get_nama_akun_by_level($key_3,3,$tabel_akun[$key_1]);
                            $data_parsing['nama_lvl_3'][$order][$key_2][] = $nama;
                            $data_parsing['key_lvl_3'][] = $key_3;
                            //echo "&nbsp;&nbsp;&nbsp;&nbsp;$key_3 - $nama<br/>";
                            foreach ($akun_3 as $key_4 => $akun_4) {
                                $debet = (isset($rekap[$key_4]['debet'])) ? $rekap[$key_4]['debet'] : 0 ;
                                $kredit = (isset($rekap[$key_4]['kredit'])) ? $rekap[$key_4]['kredit'] : 0 ;

                                if ($this->case_hutang($key_4)) {
                                    $saldo_sekarang = $kredit - $debet;
                                } else {
                                    $saldo_sekarang = $debet - $kredit;
                                }
                                
                                $saldo_awal = (isset($rekap[$key_4]['saldo_awal'])) ? $rekap[$key_4]['saldo_awal'] : 0 ;
                                $nama = $akun_4['nama'];
                                $data_parsing['nama_lvl_4'][$order][$key_3][] = $nama;
                                $data_parsing['saldo_sekarang_lvl_4'][$order][$key_3][] = $saldo_sekarang;
                                $data_parsing['saldo_awal_lvl_4'][$order][$key_3][] = $saldo_awal;
                                $jumlah_tahun_sekarang += $saldo_sekarang;
                                $jumlah_tahun_awal += $saldo_awal;
                                //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$key_4 - $nama|$saldo_sekarang|$saldo_awal<br/>";
                            }
                        } else {
                            $debet = (isset($rekap[$key_3]['debet'])) ? $rekap[$key_3]['debet'] : 0 ;
                            $kredit = (isset($rekap[$key_3]['kredit'])) ? $rekap[$key_3]['kredit'] : 0 ;
                            
                            if ($this->case_hutang($key_3)) {
                                $saldo_sekarang = $kredit - $debet;
                            } else {
                                $saldo_sekarang = $debet - $kredit;
                            }

                            $saldo_awal = (isset($rekap[$key_3]['saldo_awal'])) ? $rekap[$key_3]['saldo_awal'] : 0 ;
                            $nama = $akun_3['nama'];
                            $data_parsing['nama_lvl_3'][$order][$key_2][] = $nama;
                            $data_parsing['saldo_sekarang_lvl_3'][$order][$key_2][] = $saldo_sekarang;
                            $data_parsing['saldo_awal_lvl_3'][$order][$key_2][] = $saldo_awal;
                            $jumlah_tahun_sekarang += $saldo_sekarang;
                            $jumlah_tahun_awal += $saldo_awal;
                            //echo "&nbsp;&nbsp;&nbsp;&nbsp;$key_3  - $nama |$saldo_sekarang|$saldo_awal<br/>";
                        }
                    }
                }
            }
        }

        // print_r($rekap);die();

        $data_parsing['atribut'] = $parse_data;
        $data_parsing['level'] = $level;
        $data_parsing['jumlah_tahun_sekarang'] = $jumlah_tahun_sekarang;
        $data_parsing['jumlah_tahun_awal'] = $jumlah_tahun_awal;

        $this->load->view('akuntansi/laporan/cetak_laporan_arus_kas', $data_parsing);
    }

    public function get_lra($level, $parse_data)
    {
        $jumlah_tahun_sekarang = 0;
        $jumlah_tahun_awal = 0;
        $array_akun = array(4,5);
        $data = $this->Laporan_model->get_rekap($array_akun,null,'kas',null,'anggaran');
        $tabel_akun = array(
            4 => 'lra',
            5 => 'akun_belanja',
        );
        $akun = array();

        foreach ($array_akun as $kd_awal) {
            $akun = $akun + $this->Akun_model->get_akun_by_level($kd_awal,$level,$tabel_akun[$kd_awal]);
        }


        $rekap = array();

        foreach ($data['posisi'] as $kd_akun => $entry) {
            foreach ($entry as $inner_entry) {
                $rekap[substr($kd_akun,0,$level)][$inner_entry['tipe']] = 0;
            }
        }
 
        foreach ($data['posisi'] as $kd_akun => $entry) {
            foreach ($entry as $inner_entry) {
                $rekap[substr($kd_akun,0,$level)][$inner_entry['tipe']] += $inner_entry['jumlah'];
            }
        }

        foreach ($data['anggaran'] as $kd_akun => $entry) {
            $rekap[substr($kd_akun,0,$level)]['anggaran'] = 0;
        }

        foreach ($data['anggaran'] as $kd_akun => $entry) {
            $rekap[substr($kd_akun,0,$level)]['anggaran'] += $entry;
        }

        // print_r($data);
        // print_r($akun);
        // print_r($rekap);
        // die();
        $data['akun'] = $akun;
        $parsed = array();
        foreach ($akun as $key_1 => $akun_1) {
            $nama = $this->Akun_model->get_nama_akun_by_level($key_1,1,$tabel_akun[$key_1]);
            $data['nama_lvl_1'][$key_1][] = $nama;

            //echo "$key_1 - $nama<br/>";
            foreach($akun_1 as $key_2 => $akun_2){
                $nama = $this->Akun_model->get_nama_akun_by_level($key_2,2,$tabel_akun[$key_1]);
                $data['nama_lvl_2'][$key_1][] = $nama;
                $data['key_lvl_2'][] = $key_2;
                //echo "&nbsp;&nbsp;$key_2 -  $nama<br/>";
                foreach ($akun_2 as $key_3 => $akun_3) {
                    if ($level == 4) {
                        $nama = $this->Akun_model->get_nama_akun_by_level($key_3,3,$tabel_akun[$key_1]);
                        $data['nama_lvl_3'][$key_2][] = $nama;
                        $data['key_lvl_3'][] = $key_3;
                        //echo "&nbsp;&nbsp;&nbsp;&nbsp;$key_3 - $nama<br/>";
                        foreach ($akun_3 as $key_4 => $akun_4) {
                            $debet = (isset($rekap[$key_4]['debet'])) ? $rekap[$key_4]['debet'] : 0 ;
                            $kredit = (isset($rekap[$key_4]['kredit'])) ? $rekap[$key_4]['kredit'] : 0 ;
                            $saldo_sekarang = $debet - $kredit;
                            $anggaran = (isset($rekap[$key_4]['anggaran'])) ? $rekap[$key_4]['anggaran'] : 0 ;
                            // $saldo_awal = (isset($rekap[$key_4]['kredit'])) ? $rekap[$key_4]['saldo_awal'] : 0 ;
                            $nama = $akun_4['nama'];
                            $data['nama_lvl_4'][$key_3][] = $nama;
                            $data['saldo_sekarang_lvl_4'][$key_3][] = $saldo_sekarang;
                            $data['anggaran_awal_lvl_4'][$key_3][] = $anggaran;
                            //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$key_4 - $nama|$saldo_sekarang|$anggaran<br/>";
                        }
                    } else {
                        $debet = (isset($rekap[$key_3]['debet'])) ? $rekap[$key_3]['debet'] : 0 ;
                        $kredit = (isset($rekap[$key_3]['kredit'])) ? $rekap[$key_3]['kredit'] : 0 ;
                        $anggaran = (isset($rekap[$key_3]['anggaran'])) ? $rekap[$key_3]['anggaran'] : 0 ;
                        $saldo_sekarang = $debet - $kredit;
                        // $saldo_awal = (isset($rekap[$key_3]['kredit'])) ? $rekap[$key_3]['saldo_awal'] : 0 ;
                        $nama = $akun_3['nama'];
                        $data['nama_lvl_3'][$key_2][] = $nama;
                        $data['saldo_sekarang_lvl_3'][$key_2][] = $saldo_sekarang;
                        $data['anggaran_awal_lvl_3'][$key_2][] = $anggaran;
                        //echo "&nbsp;&nbsp;&nbsp;&nbsp;$key_3  - $nama |$saldo_sekarang|$anggaran<br/>";
                    }
                }
            }
        }
        $data['atribut'] = $parse_data;
        $data['level'] = $level;
        $data['jumlah_tahun_sekarang'] = $jumlah_tahun_sekarang;
        $data['jumlah_tahun_awal'] = $jumlah_tahun_awal;

        // print_r($rekap);die();

        $this->load->view('akuntansi/laporan/cetak_laporan_lra', $data);
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

    public function rekap_spm($cetak = null){
        if($this->input->post('unit')==null or $this->input->post('unit')=='all'){
            $filter_unit_gu = '';
            $filter_unit_up = '';
            $filter_unit_gup = '';
            $filter_unit_pup = '';
            $filter_unit_tup = '';
            $filter_unit_lsphk3 = '';
            $filter_unit_lspg = '';

            if($this->input->post('unit')=='all'){
                $kode_unit = $this->input->post('unit');
                $this->data['kode_unit'] = $kode_unit;
            }
        }else{   
            $kode_unit = $this->input->post('unit');
            $this->data['kode_unit'] = $kode_unit;        
            $filter_unit_gu = "AND substr(trx_gup.kode_unit_subunit,1,2)='".$kode_unit."'";
            $filter_unit_up = "AND substr(trx_up.kode_unit_subunit,1,2)='".$kode_unit."'";
            $filter_unit_gup = "AND substr(kode_unit,1,2)='".$kode_unit."'";
            $filter_unit_pup = "AND substr(trx_tambah_up.kode_unit_subunit,1,2)='".$kode_unit."'";
            $filter_unit_tup = "AND substr(trx_tambah_tup.kode_unit_subunit,1,2)='".$kode_unit."'";
            $filter_unit_lsphk3 = "AND substr(trx_lsphk3.kode_unit_subunit,1,2)='".$kode_unit."'";
            $filter_unit_lspg = "AND P.unitsukpa=".$kode_unit."";
        }

        if($this->input->post('daterange')!=null){
            $daterange = $this->input->post('daterange');
            $date_t = explode(' - ', $daterange);
            $periode_awal = strtodate($date_t[0]);
            $periode_akhir = strtodate($date_t[1]);
            $this->data['periode'] = $daterange;
            $filter_periode = "AND (tgl_spm BETWEEN '$periode_awal' AND '$periode_akhir')";
            $filter_periode_lspg = "AND (S.tanggal BETWEEN '$periode_awal' AND '$periode_akhir')";
        }else{
            $periode_awal = null;
            $periode_akhir = null;
            $this->data['periode'] = 'Semua Periode';
            $filter_periode = "";
            $filter_periode_lspg = "";
        }

        //up
        $this->data['up'] = $this->db->query("SELECT * FROM trx_spm_up_data, trx_up, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_up AND posisi='SPM-FINAL-KBUU' AND no_spm = str_nomor_trx
            $filter_unit_up $filter_periode");

        //gu
        $this->data['gu'] = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup AND posisi='SPM-FINAL-KBUU' AND no_spm = str_nomor_trx AND kredit=0 
            $filter_unit_gu $filter_periode");

        //pup
        $this->data['pup'] = $this->db->query("SELECT * FROM trx_spm_tambah_up_data, trx_tambah_up, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_tambah_up AND posisi='SPM-FINAL-KBUU' AND no_spm = str_nomor_trx 
            $filter_unit_pup $filter_periode");

        //tup
        $this->data['tup'] = $this->db->query("SELECT * FROM trx_spm_tambah_tup_data, trx_tambah_tup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_tambah_tup AND posisi='SPM-FINAL-KBUU' AND no_spm = str_nomor_trx
            $filter_unit_tup $filter_periode");

        //ls3
        $this->data['ls3'] = $this->db->query("SELECT * FROM trx_spm_lsphk3_data, trx_lsphk3, (select id_kuitansi, kode_akun, uraian, no_bukti, cair from rsa_kuitansi_lsphk3) as  rsa_kuitansi_lsphk3 WHERE id_trx_spm_lsphk3_data = id_trx_nomor_lsphk3 AND posisi='SPM-FINAL-KBUU' AND trx_lsphk3.id_kuitansi = rsa_kuitansi_lsphk3.id_kuitansi AND trx_spm_lsphk3_data.flag_proses_akuntansi=0 AND rsa_kuitansi_lsphk3.cair = 1
            $filter_unit_lsphk3 $filter_periode");

        //lspg
        $this->data['lspg'] = $this->db->query("SELECT * FROM kepeg_tr_spmls S, kepeg_tr_sppls P WHERE S.id_tr_sppls=P.id_sppls AND S.proses=5 $filter_unit_lspg $filter_periode_lspg");

        //gup
        //$this->data['gup'] = $this->db->query("SELECT * FROM rsa_kuitansi WHERE cair=1 $filter_unit_gup ORDER BY str_nomor_trx_spm ASC, no_bukti ASC");

        $this->db2 = $this->load->database('rba', true);
        $this->data['query_unit'] = $this->db2->query("SELECT * FROM unit");

        if($cetak==null){
            $temp_data['content'] = $this->load->view('akuntansi/rekap_spm',$this->data,true);
            $this->load->view('akuntansi/content_template',$temp_data,false);
        }else{
            $this->load->view('akuntansi/laporan/cetak_rekap_spm',$this->data);
        }
    }

    public function replace_parse(&$parse,$jenis,$replaced,$akun)
    {
        # code...
    }

    public function add_after_parse(&$parse,$jenis,$nama = null,$after,$array_akun,$level,$start_date,$end_date,$special_case = null)
    {

        // special case array dengan key pengurangan, penambahan

        if ($nama != null) {
            $tabel_akun = array(
                1 => 'aset',
                2 => 'hutang',
                3 => 'aset_bersih',
                4 => 'lra',
                5 => 'akun_belanja',
                6 => 'lra',
                7 => 'akun_belanja'
            );
            $nama = $this->Akun_model->get_nama_akun_by_level($array_akun[0],strlen($array_akun[0]),$tabel_akun[substr($array_akun[0],0,1)]);
        }
        if ($jenis == 'lpk') {     
            $data = $this->Laporan_model->get_rekap($array_akun,null,'akrual',null,'sum');
            // print_r($data);die();
            $pengurang = array();
            $penambah = array();
            $pengurang['saldo'] = 0;
            $pengurang['nett'] = 0; // kalo mau iclude saldo, nett ganti ke balance
            $penambah['saldo'] = 0;
            $penambah['nett'] = 0;

            // public function get_rekap($array_akun,$array_not_akun = null,$jenis=null,$unit=null,$laporan = null,$sumber_dana = null,$start_date = null, $end_date = null,$array_uraian = null)

            if ($special_case != null) {
                if (isset($special_case['pengurang'])){
                    $pengurang = $this->Laporan_model->get_rekap(array($speical_case['pengurang']),null,'akrual',null,'sum');
                }
                if (isset($special_case['pengurang'])){
                    $penambah = $this->Laporan_model->get_rekap(array($speical_case['penambah']),null,'akrual',null,'sum');
                }
            }

            $jumlah_last = $data['saldo'] - $pengurang['saldo'] + $penambah['saldo'];
            $jumlah_now = $data['nett'] - $pengurang['nett'] + $penambah['nett']; // kalo mau iclude saldo, nett ganti ke balance

            $entry_added = array(
               'order' => 'xx',
               'level' => 0,
               'akun' => $array_akun[0],
               'type' => 'index',
               'nama' => $nama,
               'start_sum' => null,
               'end_sum' => null,
               'sum_negatif' => null,
               'jumlah_now' => $jumlah_now,
               'jumlah_last' => $jumlah_last,
               'selisih' => abs($jumlah_now - $jumlah_last),
               'persentase' => ($jumlah_now == 0 or $jumlah_last == 0) ? 0 : abs($jumlah_now - $jumlah_last) / $jumlah_now * 100 ,
            );

            print_r($added_entry);die();


        }

        //cari posisi yang mau dimasukkan

        $i=0;
        $posisi = 0;
        while ($i < count($parse) and $posisi == 0) {
            if ($parse[$i]['akun'] == $after) {
                $posisi = $i;
            }
            ++$i;
        }

        array_splice($parse, $posisi, 0, $entry_added);

    }

    public function remove_parse(&$parse,$akun)
    {
        for ($i=0; $i < count($parse); $i++) { 
            if ($parse[$i]['akun'] == $akun) {
                unset($parse[$i]);
            }
        }
    }

    public function add_jumlah($jenis,$nama,$after,$start,$end)
    {
        # code...
    }



    public function case_hutang($x)
    {
        return in_array(substr($x,0,1),[2,3,4,6]);
    }


    public function eliminasi_negatif($value)
    {
        if ($value < 0) 
            return "(". number_format(abs($value),2,',','.') .")";
        else
            return number_format($value,2,',','.');
    }

    public function format_nip($value)
    {
        return str_replace("'",'',$value);
    }
}
