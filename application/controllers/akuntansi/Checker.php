<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checker extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
        $this->load->library('excel');
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
    }

	public function import_cek_spm_siak()
    {
        $this->load->library('excel');
        $temp_data['content'] = $this->load->view('akuntansi/form_upload_cek_spm_siak',null,true);
        $this->load->view('akuntansi/content_template',$temp_data,false);
    }

    public function do_upload_cek_siak($alert = null,$notice = null)
    {
        // die('aaaa');
        
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
            $this->import_cek_spm_siak_backend($data['full_path']);
        }
    }

    public function cek_spm_jumlah()
    {
        $spm = '00001/BPS/SPM-LS PIHAK KE-3/JUL/2017';
        $jumlah = 10315000;

        print_r($this->Kuitansi_model->cari_kuitansi_dari_rsa($spm,$jumlah));
        die();

    }

    public function import_cek_spm_siak_backend($file)
    {
        // die('aaa');

        // die (($a = false) == false);
        
        $inputFileType = PHPExcel_IOFactory::identify($file);

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);

        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10


        $header_row = 2;
        $start_row = 3;
        $column_taufik = 5;
        $last_row = $highestRow;
        $last_column = PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());
        $init_column = $last_column;
        $header_column = $last_column;
        $objWorksheet->setCellValueByColumnAndRow($header_column,$header_row,"proses_siak");
        $objWorksheet->setCellValueByColumnAndRow(++$header_column,$header_row,"SPM Jumlah sama Siak");
        $objWorksheet->setCellValueByColumnAndRow(++$header_column,$header_row,"proses rsa");
        $objWorksheet->setCellValueByColumnAndRow(++$header_column,$header_row,"keterangan rsa");
        $objWorksheet->setCellValueByColumnAndRow(++$header_column,$header_row,"SPM jumlah sama RSA");
        $spm_column = 2;

        $data_siak = $this->Kuitansi_model->read_kuitansi_all('posted');
        $data_siak_proses = $this->Kuitansi_model->read_kuitansi_all('proses');

        $spm_siak = $data_siak['spm'];
        $jumlah_siak = $data_siak['jumlah_spm'];

        $spm_siak_proses = $data_siak_proses['spm'];
        $jumlah_siak_proses = $data_siak_proses['jumlah_spm'];

        $array_spm = array();

        // foreach ($jumlah_siak as $spm => $jumlah) {
        //     $this->Kuitansi_model->cari_kuitansi_dari_rsa($spm,$jumlah);
        // }
        // unlink($file);

        for ($row=$start_row; $row <= $last_row; $row++) { 
            if ($objWorksheet->getCellByColumnAndRow($column_taufik,$row)->getValue() != null){
                $spm_ori = $objWorksheet->getCellByColumnAndRow($spm_column,$row)->getValue();
                $spm = str_replace(' ','',$spm_ori);
                $jumlah = $objWorksheet->getCellByColumnAndRow($column_taufik,$row)->getValue();
                // $this->Kuitansi_model->cari_kuitansi_dari_rsa($spm_ori,$jumlah);
                if (!in_array($spm, $spm_siak)) {
                    $objWorksheet->setCellValueByColumnAndRow(10,$row,"tidak");
                    if ($cocok_jumlah = array_search($jumlah, $jumlah_siak)){
                        $objWorksheet->setCellValueByColumnAndRow(11,$row,$cocok_jumlah);
                    }
                    elseif (!$cocok_jumlah){
                        if (!in_array($spm, $spm_siak_proses)){
                            if ($cocok_jumlah_proses = array_search($jumlah, $jumlah_siak_proses)){
                                $objWorksheet->setCellValueByColumnAndRow(11,$row,$cocok_jumlah_proses);
                            }elseif (!$cocok_jumlah_proses) {
                                $cocok_rsa = $this->Kuitansi_model->read_spm_rsa($spm_ori,$jumlah);
                                $objWorksheet->setCellValueByColumnAndRow(12,$row,$cocok_rsa['posisi']);
                                $objWorksheet->setCellValueByColumnAndRow(13,$row,$cocok_rsa['ket']);
                                if ($cocok_rsa['sama_nominal'] == 1){
                                    $objWorksheet->setCellValueByColumnAndRow(14,$row,$cocok_rsa['no_spm']);
                                }
                            }
                        }
                        if(in_array($spm, $spm_siak_proses)){
                            $objWorksheet->setCellValueByColumnAndRow(10,$row,"proses");        
                        }
                    }
                }else{
                    $objWorksheet->setCellValueByColumnAndRow(10,$row,"ada");
                }
            }
            $last_column = $init_column;
        }

        unlink($file);
        // die('selesai');


        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=rekap_spm.xls");
        header('Cache-Control: max-age=0');
        // $objWriter = new PHPExcel_Writer_HTML($objPHPExcel,'excel5');  
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        // print_r(array_diff($spm_siak,$array_spm));


        


    }
}
