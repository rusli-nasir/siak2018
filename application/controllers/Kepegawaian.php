<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepegawaian extends CI_Controller {

	
	public function __construct()
    {
            parent::__construct();

            

            // Your own constructor code
            if(!$this->check_session->user_session()){	/*	Jika session user belum diset	*/

				redirect('/','refresh');
				
	
			}
			else{	/*	Jika session user sudah diset	*/
			
				$this->load->helper('form');
				$this->load->model('login_model');
				$this->load->model('menu_model');
				$this->load->library('form_validation');
				$this->load->library('revisi_session');

			}
    }


	public function index()
	{
		

        
                        $unit = $this->check_session->get_unit(); 
			$data['main_content']	= $this->load->view('kepegawaian/kepeg_index','',TRUE);
                        $list["menu"]           = $this->menu_model->show();
                        $list["submenu"]        = $this->menu_model->show();
                        $data['main_menu']	= $this->load->view('main_menu','',TRUE);
                        $data['message']	= validation_errors();
                        $this->load->view('main_template2',$data);
                                       
                
	}
        
        public function view_pegawai($bulan,$tahun,$nip)
	{
		
                $this->load->model('M_kepeg');
                $dtpeg = $this->M_kepeg->getpegawai(); 
                $tbl['dtpeg']=$dtpeg;
            
		$data['main_content']	= $this->load->view('kepegawaian/index','',TRUE);
		$list["menu"] = $this->menu_model->show();
		$list["submenu"] = $this->menu_model->show();
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('main_template2',$data);
	}
        
        
        public function gjnonpns()
	{
		
		$data['main_content']	= $this->load->view('kepegawaian/nonpns','',TRUE);
		$list["menu"] = $this->menu_model->show();
		$list["submenu"] = $this->menu_model->show();
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('main_template2',$data);
	}
        
        public function load_dtpeg() {
          
            $this->load->model('M_kepeg');
            $dtpeg = $this->M_kepeg->getpegawai(); 
            $tbl['dtpeg']=$dtpeg;
            $data['main_content']	= $this->load->view('kepegawaian/data',$tbl,TRUE);
	    $list["menu"] = $this->menu_model->show();
	    $list["submenu"] = $this->menu_model->show();
	    $data['main_menu']	= $this->load->view('main_menu','',TRUE);
	    $data['message']	= validation_errors();
           
	    $this->load->view('main_template2',$data);
           
            
        }
        
        public function cari_data()
        {
            $keyword = $this->uri->segment(3);
         $data = $this->db->from('kepeg_tb_pegawai')->like('nama',$keyword)->get();	

		// format keluaran di dalam array
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->nama,
                                'nip'	=>$row->nip              
				
				

			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);


        }
        
        public function proses_data(){
            
                $this->load->model('M_kepeg');
               
                $data['main_content']	= $this->load->view('kepegawaian/proses_data','',TRUE);
		$list["menu"]           = $this->menu_model->show();
		$list["submenu"]        = $this->menu_model->show();
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('main_template2',$data);
            
        }

	public function iframe(){
            
                $this->load->model('M_kepeg');
               
                $data['main_content']	= $this->load->view('kepegawaian/iframe','',TRUE);
		$list["menu"]           = $this->menu_model->show();
		$list["submenu"]        = $this->menu_model->show();
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('main_template2',$data);
            
        }
        
         public function proses_data_fakultas(){
            
                $id_fak= $this->input->post('unit');
                $bulan= $this->input->post('bulan');
                $tahun= $this->input->post('tahun');
                $proses= $this->input->post('proses');
             
                if($proses=="lihat data"){            
                
                    
                $this->load->model('M_kepeg');
                $nama_fak = $this->M_kepeg->get_nm_fak($id_fak); 
                
                
                $dtpegfak = $this->M_kepeg->getpegawai_pns_dosen_fak($id_fak); 
                $dtpegfak_nondosen = $this->M_kepeg->getpegawai_pns_fak($id_fak);
                $dtpegfak_blu = $this->M_kepeg->getpegawai_blu_fak($id_fak);
                $dtpegfak_cpns = $this->M_kepeg->getpegawai_cpns_fak($id_fak);
                $dtpegfak_kontrak = $this->M_kepeg->getpegawai_kontrak_fak($id_fak);
                $datatbl['dtpegfak']=$dtpegfak;
                $datatbl['dtpegfak_nondosen']=$dtpegfak_nondosen;
                $datatbl['dtpegfak_blu']=$dtpegfak_blu;
                $datatbl['dtpegfak_cpns']=$dtpegfak_cpns;
                $datatbl['dtpegfak_kontrak']=$dtpegfak_kontrak;
                $datatbl['id_fak']=$id_fak;
                $datatbl['nama_fak']=$nama_fak;
                $datatbl['bulan']=$bulan;
                $datatbl['tahun']=$tahun;
                
                $data['main_content']	= $this->load->view('kepegawaian/proses_data_fak',$datatbl,TRUE);
		$list["menu"]           = $this->menu_model->show();
		$list["submenu"]        = $this->menu_model->show();
		$data['main_menu']	= $this->load->view('main_menu','',TRUE);
		$data['message']	= validation_errors();
		$this->load->view('main_template2',$data);
                
         } else {
             $this->cetak_ikw();
         }
            
        }
        
        public function cek_data() {
             $no=1;
             $bulan='11';
             $tahun='2016';
             $id_fak='1';
             $this->load->model('M_kepeg');
             
             $pns_dosen=$this->M_kepeg->getpegawai_pns_dosen_fak($id_fak);
             foreach($pns_dosen->result() as $dosen){
                 $data_gaji=$this->M_kepeg->cari_get_gaji_q($bulan,$tahun,$dosen->nip);
                 foreach($data_gaji->result()as $gaji){$gajibersih=$gaji->bersih;}
                 echo $no++."-".$dosen->nama."-".$dosen->nip."-".$gajibersih."<BR>";
             }
              $this->M_kepeg->cari_get_gaji_q($bulan,$tahun,'');
             
        }
        
        public function cetak_lpp_sm(){
            
            $tahun="2017";
            $file=  "http://10.69.12.215/rsa/assets/kepeg_js/undip.png";
            $jenis_laporan="LS-PEGAWAI";
            $nomor_laporan="110/FKU/SPP-LS PGW/Mei/2017";
            $tanggal=" 5 Mei 2017";
            $unit_kerja="Fak. Kedokteran Umum";
            $kode_unit="14";
            $pembayaran_total="54.000.000";
            $pembayaran_total_huruf="Lima Puluh Empat Juta Rupiah Ribu Rupiah";
            $kode_pembayaran=" Insentif Kelebihan Kerja";
            $dana_selain_apbn="54.400.000";
            
            $this->load->library('fpdf/fpdf');
		$pdf = new FPDF_Protection();
		$pdf->SetProtection(array('print'));
		$pdf->AddPage('P','A4');
               
                $pdf->SetFont('Helvetica', 'B', 12);
                $pdf->SetXY(185, 16);
		$pdf->Cell(0, 00, 'F1');
                
                $pdf->Line(20, 20, 20, 280); //line melingkar
                $pdf->Line(20, 20, 190, 20);
                $pdf->Line(20, 280, 190, 280);
                $pdf->Line(190, 280, 190, 20);
                
                $pdf->Line(20, 36, 190, 36);
                
                $pdf->Image($file,95,21,13,13);      
                
                $pdf->SetFont('Helvetica', 'B', 10);
		
		$pdf->SetXY(77, 39);
		$pdf->Cell(0, 00, 'UNIVERSITAS DIPONEGORO');
		
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetXY(76, 43);
		$pdf->Cell(0, 00, 'SURAT PERMINTAAN PEMBAYARAN');
                $pdf->SetXY(21, 49);
		$pdf->Cell(0, 00, 'TAHUN ANGGARAN : '.$tahun);
                $pdf->SetXY(21, 52);
		$pdf->Cell(0, 00, 'Tanggal     : '.$tanggal);
                $pdf->SetXY(127, 52);
		$pdf->Cell(0, 00, 'Nomor     : '.$nomor_laporan);
                $pdf->SetXY(87, 49);
		$pdf->Cell(0, 00, 'JENIS: '.$jenis_laporan);
                
                $pdf->Line(20, 55, 190, 55);
                $pdf->Line(20, 59, 190, 59);
                $pdf->Line(20, 63, 190, 63);
                $pdf->SetXY(21, 57);
		$pdf->Cell(0, 00, 'Satuan Unit Kerja Pengguna Anggaran (SUKPA): '.$unit_kerja);
                $pdf->SetXY(21, 61);
		$pdf->Cell(0, 00, 'Unit Kerja : '.$unit_kerja.'           Kode Unit Kerja : '.$kode_unit);
                
                $pdf->SetFont('Helvetica', '', 8);
                $pdf->SetXY(87, 66);
		$pdf->Cell(0, 00,'Kepada Yth.');
                $pdf->SetXY(87, 70);
		$pdf->Cell(0, 00,'Pengguna Anggaran/Kuasa Pengguna Anggaran');
                $pdf->SetXY(87, 74);
		$pdf->Cell(0, 00,'SUKPA '.$unit_kerja);
                $pdf->SetXY(87, 78);
		$pdf->Cell(0, 00,'di Semarang');
                
                $pdf->SetXY(21, 87);
		$pdf->Cell(0, 00,'Dengan berpedoman pada dokumen RKAT yang telah disetujui oleh MWA, bersama ini kami mengajukan'
                        . ' Surat Permintaan  ');
                $pdf->SetXY(21, 91);
		$pdf->Cell(0, 00,'Pembayaran sebagai berikut:');
                $pdf->SetXY(21, 95);
		$pdf->Cell(0, 00,'a. Jumlah pembayaran yang diminta      :  Rp.'.$pembayaran_total.'.-');
                $pdf->SetXY(60, 99);
		$pdf->Cell(0, 00,'Terbilang:'.$pembayaran_total_huruf);
                $pdf->SetXY(21, 103);
		$pdf->Cell(0, 00,'b. Untuk pembayaran                              :'.$kode_pembayaran);
                $pdf->SetXY(21, 107);
		$pdf->Cell(0, 00,'c. Nama Penerima                                  : Terlampir');
                $pdf->SetXY(21, 111);
		$pdf->Cell(0, 00,'d. Alamat                                                 :  JL. Prof Sudharto Tembalang');
                $pdf->SetXY(21, 115);
		$pdf->Cell(0, 00,'e. Nomor Rekening                                 : Terlmapir');
                $pdf->SetXY(21, 119);
		$pdf->Cell(0, 00,'f. Nomor NPWP                                       : Terlampir');
                $pdf->SetXY(21, 123);
		$pdf->Cell(0, 00,'g. Sumber dana dari APBN                    : ');
                $pdf->SetXY(21, 127);
		$pdf->Cell(0, 00,'h. Sumber dana selain APBN                 : Rp.'.$dana_selain_apbn.'.-');
                $pdf->SetXY(21, 131);
		$pdf->Cell(0, 00,'Pembayaran sebaimana tersebut diatas ,dibebankan pada pengeluaran dengan uraian sebagai berikut:');
                
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->Line(20, 134, 190, 134);
                $pdf->SetXY(31, 136);
		$pdf->Cell(0, 00,'PENGELUARAN');
                $pdf->SetXY(120, 136);
		$pdf->Cell(0, 00,'PERHITUNGAN TERKAIT PIHAK LAIN ');
                $pdf->Line(20, 139, 190, 139);
                
                $pdf->SetFont('Helvetica', '', 8);
                $pdf->SetXY(21, 142);
		$pdf->Cell(0, 00,'Jenis Belanja / Nama Akun');
                $pdf->SetXY(75, 144);
		$pdf->Cell(0, 00,'Kode Akun');
                $pdf->SetXY(105, 144);
		$pdf->Cell(0, 00,'Jumlah Uang');
                $pdf->SetXY(21, 146);
		$pdf->Cell(0, 00,' ');
                $pdf->Line(20, 149, 190, 149);
                $pdf->SetXY(21, 152);
		$pdf->Cell(0, 00,'Biaya tunjangan / insentif');
                $pdf->SetXY(21, 156);
		$pdf->Cell(0, 00,' kinerja dosen PNS');
                $pdf->Line(20, 159, 190, 159);
                
                $pdf->SetXY(21, 162);
		$pdf->Cell(0, 00,'Biaya tunjangan / insentif');
                $pdf->SetXY(21, 166);
		$pdf->Cell(0, 00,' tenaga dosen Non PNS');
                $pdf->Line(20, 169, 190, 169);
                
                $pdf->SetXY(21, 172);
		$pdf->Cell(0, 00,'Biaya tunjangan / kinerja');
                $pdf->SetXY(21, 176);
		$pdf->Cell(0, 00,' tenaga kependidikan PNS');
                $pdf->Line(20, 179, 190, 179);
                
                $pdf->SetXY(21, 182);
		$pdf->Cell(0, 00,'Biaya tunjangan / kinerja');
                $pdf->SetXY(21, 186);
		$pdf->Cell(0, 00,' tenaga kependidikan Non PNS');
                $pdf->Line(20, 189, 190, 189);
                
                $pdf->Line(65, 139, 65, 189);
                $pdf->Line(95, 139, 95, 189);
                $pdf->Line(130, 139, 130, 189);
                
                $pdf->Output();
                
                
        }
        
        public function cetak_ikw()
	{
            $id_fak='1';
            $bulan='11';
            $tahun='2016';
            $this->load->model('M_kepeg');
            $datenow= date("Y-m-d");  
            $tanggal_ini=$this->M_kepeg->TanggalIndo($datenow);
            $nama_fak = $this->M_kepeg->get_nm_fak($id_fak); 
             
             $no=0;
              $dtpegfak = $this->M_kepeg->getpegawai_pns_dosen_fak($id_fak); 
              $array_dsn_pns = array();
              foreach ($dtpegfak->result() as $peg){
                  $no++;
             
              
              $dtad = $this->M_kepeg->cari_get_gaji_q($bulan,$tahun,$peg->nip); 
              foreach($dtad->result() as $ada){$hasil=$ada->hasil;}
                     if($hasil!='1'){${'gaji_bersih_pns'.$no}="0";}else{
                         
                         $dtgaji = $this->M_kepeg->cari_get_gaji_data($bulan,$tahun, $peg->nip);
                            foreach ($dtgaji->result() as $gaji){
                                ${'gaji_bersih_pns'.$no}=$gaji->bersih;
                            }
                     }
                    $array_dsn_pns[] = array("nip" => $peg->nip,  "nama" => $peg->nama,"gaji"=>${'gaji_bersih_pns'.$no});
                            
                          
              }
              //echo "<PRE>";
              //print_r($array_dsn_pns);
              //echo "</PRE>";
             
                 $sum = 0;
               foreach ($array_dsn_pns as $ar_gaji) {
                   $sum += $ar_gaji['gaji'];
               }
              
            
		$this->load->library('fpdf/fpdf');
		$pdf = new FPDF_Protection();
		$pdf->SetProtection(array('print'));
                
		$pdf->AddPage('L','A4');
                $pdf->SetMargins(10, 10); 
                $pdf->SetAutoPageBreak(true, 10);
		
		$pdf->Image(base_url().'/assets/img/logo.png', 145, 15, 14, 17);
		$pdf->SetFont('Helvetica', 'B', 12);
		$pdf->SetXY(265, 10);
		$pdf->Cell(0, 00, 'F1B - IKW');
		$pdf->SetXY(122, 37);
		$pdf->Cell(0, 00, 'UNIVERSITAS DIPONEGORO');
		$pdf->SetFont('Helvetica', 'B', 9);
		$pdf->SetXY(100, 42);
		$pdf->Cell(0, 00, 'LAMPIRAN SURAT PERMINTAAN PEMBAYARAN LS-PEGAWAI-IKK');
		$pdf->SetXY(100, 46);
		$pdf->Cell(0, 0, 'NO SPP : 109/WRII/SPP-LS PGW/Mei/2017');
		$pdf->SetXY(100, 50);
		$pdf->Cell(0, 0, 'SUKPA : Wakil Rektor II');
		$pdf->SetXY(170, 46);
		$pdf->Cell(0, 0, 'TANGGAL : '.$tanggal_ini);
		$pdf->SetXY(170, 50);
		$pdf->Cell(0, 0, 'UNIT KERJA : BAUK');

		//tabel kiri atas
		$pdf->Line(10, 55, 100, 55);
		$pdf->Line(10, 61, 100, 61);
		$pdf->Line(10, 67, 100, 67);
		$pdf->Line(10, 55, 10, 67);
		$pdf->Line(20, 55, 20, 67);
		$pdf->Line(100, 55, 100, 67);
		
		//tabel kanan atas
		$pdf->Line(190, 55, 285, 55);
		$pdf->Line(190, 61, 285, 61);
		$pdf->Line(190, 67, 285, 67);
		$pdf->Line(190, 55, 190, 67);
		$pdf->Line(200, 55, 200, 67);
		$pdf->Line(285, 55, 285, 67);

		$pdf->SetFont('Helvetica', 'B', 10);
		$pdf->SetXY(13,58);
		$pdf->Cell(0, 00, 'V');
		$pdf->SetXY(13,64);
		$pdf->Cell(0, 00, 'V');
		$pdf->SetXY(193,58);
		$pdf->Cell(0, 00, 'V');
		$pdf->SetXY(193,64);
		$pdf->Cell(0, 00, 'V');

		$pdf->SetFont('Helvetica', '', 9);
		$pdf->SetXY(21,58);
		$pdf->Cell(0, 00, 'Daftar pegawai penerima IKW dosen PNS');
		$pdf->SetXY(21,64);
		$pdf->Cell(0, 00, 'Daftar pegawai penerima IKW dosen Non PNS');
		$pdf->SetXY(201,58);
		$pdf->Cell(0, 00, 'Daftar pegawai penerima IKW Tendik PNS');
		$pdf->SetXY(201,64);
		$pdf->Cell(0, 00, 'Daftar pegawai penerima IKW Tendik Non PNS');
		
		$pdf->SetFont('Helvetica', 'B', 12);
		$pdf->SetXY(40,75);
		$pdf->Cell(0, 00, 'DAFTAR PEGAWAI PENERIMA INSENTIF KINERJA WAJIB DOSEN PNS - '.$nama_fak);

		//tabel utama
		
		//tabel header
		//line horisontal
		$pdf->Line(10, 80, 285, 80);
		$pdf->Line(75, 96, 285, 96);
		$pdf->Line(10, 100, 285, 100);
		//line vertikal
		$pdf->Line(10, 80, 10, 100);
		$pdf->Line(20, 80, 20, 100);
		$pdf->Line(50, 80, 50, 100);
		$pdf->Line(60, 80, 60, 100);
		$pdf->Line(75, 80, 75, 100);
		$pdf->Line(96, 80, 96, 100);
		$pdf->Line(118, 80, 118, 100);
		$pdf->Line(140, 80, 140, 100);
		$pdf->Line(156, 80, 156, 100);
		$pdf->Line(176, 80, 176, 100);
		$pdf->Line(197, 80, 197, 100);
		$pdf->Line(208, 80, 208, 100);
		$pdf->Line(230, 80, 230, 100);
		$pdf->Line(258, 80, 258, 100);
		$pdf->Line(285, 80, 285, 100);
		//konten tabel header
		$pdf->SetFont('Helvetica', '', 7);
		$pdf->SetXY(12,90);
		$pdf->Cell(0, 00, 'NO');
		$pdf->SetXY(23,90);
		$pdf->Cell(0, 00, 'NAMA LENGKAP');
		$pdf->SetXY(51,90);
		$pdf->Cell(0, 00, 'GOL');
		$pdf->SetXY(60,90);
		$pdf->Cell(0, 00, 'JABATAN');
		$pdf->SetXY(79,82);
		$pdf->Cell(0, 00, 'JUMLAH');
		$pdf->SetXY(76,85);
		$pdf->Cell(0, 00, 'PEMBAYARAN');
		$pdf->SetXY(81,88);
		$pdf->Cell(0, 00, '100%');
		$pdf->SetXY(82,91);
		$pdf->Cell(0, 00, '(Rp)');
		$pdf->SetXY(83,98);
		$pdf->Cell(0, 00, '(a)');
		$pdf->SetXY(99,83);
		$pdf->Cell(0, 00, 'POTONGAN');
		$pdf->SetXY(104,86);
		$pdf->Cell(0, 00, 'IKW');
		$pdf->SetXY(104,89);
		$pdf->Cell(0, 00, '(Rp)');
		$pdf->SetXY(105,98);
		$pdf->Cell(0, 00, '(b)');
		$pdf->SetXY(122,82);
		$pdf->Cell(0, 00, 'JUMLAH');
		$pdf->SetXY(120,85);
		$pdf->Cell(0, 00, 'PEMBAYARAN');
		$pdf->SetXY(122,88);
		$pdf->Cell(0, 00, 'PER BULAN');
		$pdf->SetXY(120,91);
		$pdf->Cell(0, 00, 'SEMESTER INI');
		$pdf->SetXY(125,94);
		$pdf->Cell(0, 00, '(Rp)');
		$pdf->SetXY(126,98);
		$pdf->Cell(0, 00, '(c)');
		$pdf->SetXY(143,82);
		$pdf->Cell(0, 00, 'TARIF');
		$pdf->SetXY(141,85);
		$pdf->Cell(0, 00, 'PENGENA');
		$pdf->SetXY(141,88);
		$pdf->Cell(0, 00, 'AN PAJAK');
		$pdf->SetXY(144,91);
		$pdf->Cell(0, 00, '(%)');
		$pdf->SetXY(144,98);
		$pdf->Cell(0, 00, '(d)');
		$pdf->SetXY(160,84);
		$pdf->Cell(0, 00, 'JUMLAH');
		$pdf->SetXY(158,87);
		$pdf->Cell(0, 00, 'PAJAK YANG');
		$pdf->SetXY(159,90);
		$pdf->Cell(0, 00, 'DIPUNGUT');
		$pdf->SetXY(158,98);
		$pdf->Cell(0, 00, '(e) = (c)x(d)');
		$pdf->SetXY(180,82);
		$pdf->Cell(0, 00, 'JUMLAH');
		$pdf->SetXY(177,85);
		$pdf->Cell(0, 00, 'PEMBAYARAN');
		$pdf->SetXY(180,88);
		$pdf->Cell(0, 00, 'SETELAH');
		$pdf->SetXY(177,91);
		$pdf->Cell(0, 00, 'PERHITUNGAN');
		$pdf->SetXY(180,94);
		$pdf->Cell(0, 00, 'PAJAK');
		$pdf->SetXY(180,98);
		$pdf->Cell(0, 00, '(f) = (c)-(e)');
		$pdf->SetXY(198,86);
		$pdf->Cell(0, 00, 'NPWP');
		$pdf->SetXY(199,98);
		$pdf->Cell(0, 00, '(g)');
		$pdf->SetXY(210,84);
		$pdf->Cell(0, 00, 'POTONGAN');
		$pdf->SetXY(212,87);
		$pdf->Cell(0, 00, 'LAINNYA');
		$pdf->SetXY(216,98);
		$pdf->Cell(0, 00, '(h)');
		$pdf->SetXY(237,83);
		$pdf->Cell(0, 00, 'JUMLAH');
		$pdf->SetXY(233,86);
		$pdf->Cell(0, 00, 'PEMBAYARAN');
		$pdf->SetXY(237,89);
		$pdf->Cell(0, 00, 'BERSIH');
		$pdf->SetXY(236,98);
		$pdf->Cell(0, 00, '(i) = (f)-(h)');
		$pdf->SetXY(265,82);
		$pdf->Cell(0, 00, 'ALAMAT');
		$pdf->SetXY(265,85);
		$pdf->Cell(0, 00, 'TUJUAN');
		$pdf->SetXY(262,88);
		$pdf->Cell(0, 00, 'TRANSFER/NO');
		$pdf->SetXY(264,91);
		$pdf->Cell(0, 00, 'REKENING');
		$pdf->SetXY(266,94);
		$pdf->Cell(0, 00, 'BANK');
		$pdf->SetXY(268,98);
		$pdf->Cell(0, 00, '(j)');
		
		//KONTEN TABEL
		$x=100;
		$y1=80;
		$y2=100;
		$isi_y=98;
                
               
		for ($i=0;$i<=count($array_dsn_pns);$i++) {
			$x = $x+5;
			$y1 = $y1+5;
			$y2 = $y2+5;
			$isi_y = $isi_y+5;
			
			//line horisontal
			$pdf->Line(10, $x, 285, $x);
			//line vertikal
			$pdf->Line(10, $y1, 10, $y2);
			$pdf->Line(20, $y1, 20, $y2);
			$pdf->Line(50, $y1, 50, $y2);
			$pdf->Line(60, $y1, 60, $y2);
			$pdf->Line(75, $y1, 75, $y2);
			$pdf->Line(96, $y1, 96, $y2);
			$pdf->Line(118, $y1, 118, $y2);
			$pdf->Line(140, $y1, 140, $y2);
			$pdf->Line(156, $y1, 156, $y2);
			$pdf->Line(176, $y1, 176, $y2);
			$pdf->Line(197, $y1, 197, $y2);
			$pdf->Line(208, $y1, 208, $y2);
			$pdf->Line(230, $y1, 230, $y2);
			$pdf->Line(258, $y1, 258, $y2);
			$pdf->Line(285, $y1, 285, $y2);
			
			//isi
			$pdf->SetXY(12, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(21, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(52, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(61, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(76, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(97, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(119, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(142, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(157, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(177, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(198, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(209, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(232, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(259, $isi_y);
			$pdf->Cell(0, 0, $i);
		}
		
		//JUMLAH
		for ($i=111;$i<=111;$i++) {
			$x = $x+5;
			$y1 = $y1+5;
			$y2 = $y2+5;
			$isi_y = $isi_y+5;
			
			//line horisontal
			$pdf->Line(10, $x, 285, $x);
			//line vertikal
			$pdf->Line(10, $y1, 10, $y2);
			$pdf->Line(20, $y1, 20, $y2);
			$pdf->Line(75, $y1, 75, $y2);
			$pdf->Line(96, $y1, 96, $y2);
			$pdf->Line(118, $y1, 118, $y2);
			$pdf->Line(140, $y1, 140, $y2);
			$pdf->Line(156, $y1, 156, $y2);
			$pdf->Line(176, $y1, 176, $y2);
			$pdf->Line(197, $y1, 197, $y2);
			$pdf->Line(208, $y1, 208, $y2);
			$pdf->Line(230, $y1, 230, $y2);
			$pdf->Line(258, $y1, 258, $y2);
			$pdf->Line(285, $y1, 285, $y2);
			
			//isi
			$pdf->SetXY(48, $isi_y);
			$pdf->Cell(0, 0, 'Jumlah');			
			$pdf->SetXY(76, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(97, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(119, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(157, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(177, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(209, $isi_y);
			$pdf->Cell(0, 0, $i);			
			$pdf->SetXY(232, $isi_y);
			$pdf->Cell(0, 0, $i);			
		}
		
		//ttd
		$pdf->SetFont('Helvetica', '', 9);
		$pdf->SetXY(20,$isi_y+12);
		$pdf->Cell(0, 00, 'Mengetahui,');
		$pdf->SetXY(20,$isi_y+17);
		$pdf->Cell(0, 00, 'Pejabat Pelaksana dan Pengendali Kegiatan');
		$pdf->SetXY(20,$isi_y+34);
		$pdf->Cell(0, 00, 'Makaryo');
		$pdf->SetXY(20,$isi_y+39);
		$pdf->Cell(0, 00, 'NIP. 9790123');
		
		$pdf->SetFont('Helvetica', '', 9);
		$pdf->SetXY(200,$isi_y+10);
		$pdf->Cell(0, 00, 'Semarang, 5 Mei 2017');
		$pdf->SetXY(200,$isi_y+17);
		$pdf->Cell(0, 00, 'Bendahara Pengeluaran SUKPA');
		$pdf->SetXY(200,$isi_y+34);
		$pdf->Cell(0, 00, 'Baik Namaku');
		$pdf->SetXY(200,$isi_y+39);
		$pdf->Cell(0, 00, 'NIP. 65321678');
		
		$pdf->Output(); 
	}
 
        
        public function dasbord() {
            
            
            
        }
 
}
		