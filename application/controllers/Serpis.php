<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Serpis extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


/* -------------- Property -------------------*/
	private $cur_tahun;

/* -------------- Constructor ------------- */
    public function __construct()
    {
            parent::__construct();
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model(array('serpis_model','tor_model'));
		$this->cur_tahun = $this->setting_model->get_tahun();
	}

/* -------------- Method ------------- */
	function index()
	{
		  // $url  = "http://10.37.19.99/sikontrak/latihan/index.php/service/pembayaran/";
		 $url  = "http://10.37.19.99/sikontrak/index.php/service/pembayaran/";
		 //$url = "http://demorsa.apps.undip.ac.id/lemparan_sirenbang_murni.txt";
		 $s_kode_usulan_belanja= isset($_GET['kode_usulan_belanja']) ? $_GET['kode_usulan_belanja'] : '';
		 $fields = array('kode_usulan_belanja' => $s_kode_usulan_belanja);
			 $data = http_build_query($fields);
						$context = stream_context_create(array(
						'http' =>  array(
							'method'  => 'GET',
							'header'  => 'Content-type: application/x-www-form-urlencoded',
							'content' => $data,
						)
					));

     $result = file_get_contents($url, false, $context);
	 // echo($result); exit;
	 	// $vr2 = unserialize($result);
		$vr2 = json_decode($result,true);
		//echo "<pre>"; print_r($vr2); echo "</pre>"; exit;
		$sql2 = array();
		$tabel1 = array(); $tabel2 = array(); $tabel3 = array(); $tabel4 = array();
		$col_tabel1 = array(); $col_tabel2 = array(); $col_tabel3 = array(); $col_tabel4 = array();

		foreach ($vr2 as $k => $vr){
				$tabel2 = $vr['barang'];
				$tabel3 = $vr['kontrak'];
				$tabel4 = $vr['rekanan'];
				unset($vr['barang']); unset($vr['kontrak']); unset($vr['rekanan']);
				
				$tabel1 = $vr;
				if(is_array($tabel1) && count($tabel1)>0){
					$col_tabel1 = array_keys($tabel1);
				}
				if(is_array($tabel2) && count($tabel2)>0){
					$col_tabel2 = array_keys($tabel2[0]);
				}
				if(is_array($tabel3) && count($tabel3)>0){
					$col_tabel3 = array_keys($tabel3);
				}
				if(is_array($tabel4) && count($tabel4)>0){
					$col_tabel4 = array_keys($tabel4);
				}
				
				// utama ==> tabel1
				if(is_array($tabel1) && count($tabel1)>0){
					// print_r($tabel1); echo "<br />";
					$sql = "REPLACE INTO rsa_spm_kontrakpihak3(";
					$sql .= implode(", ",$col_tabel1).") VALUES ";
					/*$i=0;
					foreach($tabel1 as $x){
						$sql2[$i]="('".implode("', '", $x)."')";
						$i++;
					}
					$sql.=implode(", ",$sql2);*/
					$sql.= "('".implode("', '", $tabel1)."')";
					// echo "SQL 1 : ".$sql."<br />";
					$this->db->query($sql);
				}

				// barang ==> tabel2
				if(is_array($tabel2) && count($tabel2)>0){
					if(!empty($col_tabel2)){
						$sql = "REPLACE INTO rsa_spm_rinciankontrak(";
						$sql.= implode(", ",$col_tabel2).") VALUES ";
						$i=0;
						foreach($tabel2 as $x){
							$sql2[$i]="('".implode("', '", $x)."')";
							$i++;
						}
						$sql.=implode(", ",$sql2);
					}else{
						$sql = "REPLACE INTO rsa_spm_rinciankontrak VALUES ";
						// $sql.= implode(", ",$col_tabel2).") VALUES ";
						$i=0;
						foreach($tabel2 as $x){
							$sql2[$i]="('".implode("', '", $x)."')";
							$i++;
						}
						$sql.=implode(", ",$sql2);
					}
					// echo "SQL2 : ".$sql."<br />";
					$this->db->query($sql);
				}
				
				// proses ==> tabel3
				if(is_array($tabel3) && count($tabel3)>0){
					$sql = "REPLACE INTO rsa_spm_prosespihak3(";
					$sql.= implode(", ",$col_tabel3).") VALUES ";
					// $i=0;
					/*foreach($tabel3 as $x){
						$sql3[$i]="('".implode("', '", $x)."')";
						$i++;
					}*/
					$sql.= "('".implode("', '", $tabel3)."')";
					// $sql.=implode(", ",$sql3);
					// echo "SQL 3 : ".$sql."<br />";
					$this->db->query($sql);
				}


				// rekanan ==> tabel4
				if(is_array($tabel4) && count($tabel4)>0){
					$sql = "REPLACE INTO rsa_spm_rekananpihak3(";
					$sql.= implode(", ",$col_tabel4).") VALUES ";
					// $i=0;
					/*foreach($tabel4 as $x){
						$sql4[$i]="('".implode("', '", $x)."')";
						$i++;
					}
					$sql.=implode(", ",$sql4);
					$this->db->query($sql);*/
					$sql.= "('".implode("', '", $tabel4)."')";
					// echo "SQL 4 : ".$sql."<br />";
					$this->db->query($sql);
				}

				/*echo "<p>Preview Tabel :</p>";
				echo "<pre>";
				print_r($tabel1);
				print_r($tabel2);
				print_r($tabel3);
				print_r($tabel4);
				echo "</pre>";*/
		}


		redirect('dashboard','refresh');
		
	}
	function daftar_lsp3($sumber_dana = "")
    {
        
		$data['cur_tahun'] = $this->cur_tahun ;
        //        var_dump($this->check_session->get_unit());die;
		/* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
			$unit = $this->check_session->get_unit() ;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
                        if(!empty($sumber_dana)){
                            $subdata['rsa_kontrak'] 	= $this->serpis_model->get_kontrak_p3($unit,$sumber_dana,$this->cur_tahun);
                        }
                        $subdata['sumber_dana']         = $sumber_dana ;
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 		= $this->load->view("rsa_lsphk3/daftar_lsp3",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata['rsa_usul']);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}		
    }
	  function tabel_lsp3($sumber_dana,$tahun){
        /* check session	*/
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
                    $unit = $this->check_session->get_unit() ;
                    $subdata['rsa_usul'] 		= $this->serpis_model->get_kontrak_p3($unit,$sumber_dana,$tahun);
                    $this->load->view("rsa_lsphk3/tabel_lsp3",$subdata);
            }else{
                    redirect('welcome','refresh');	// redirect ke halaman home
            }
        
    }
	 function usulan_lsp3($kode,$sumber_dana){

            $data['cur_tahun'] = $this->cur_tahun ;

            /* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2)||($this->check_session->get_level()==13)||($this->check_session->get_level()==4))){
            $unit = $this->check_session->get_unit() ;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
                        $subdata['tor_usul']            = $this->tor_model->get_tor_usul(substr($kode,2,10));
                        $subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($kode,$sumber_dana,$this->cur_tahun);
                        $subdata['detail_rsa']          = $this->serpis_model->get_detail_kontrak($kode,$sumber_dana,$this->cur_tahun);
						$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                        $subdata['sumber_dana'] 		= $sumber_dana;
                        $subdata['kode']                = $kode;
			$data['main_content'] 		= $this->load->view("rsa_lsphk3/usulan_lsp3",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

        }
		function daftar_spplsp3(){
        $vSQL = "";
        if($_SESSION['rsa_level']=='14'){
            $vSQL= " AND proses = 1";
        }
        $subdata['daftar_spplsp3'] = array();
        $subdata['cur_tahun'] = $this->cur_tahun;
        $sql = "SELECT tahun FROM tr_spplsp3 GROUP BY tahun ORDER BY tahun ASC";
        $subdata['tahun'] = $this->db->query($sql)->result();
        // $d = $this->uri->uri_to_assoc(3);
        // if(isset($d['tahun'])){
            $sql = "SELECT a.*,DATE_FORMAT(a.tanggal, '%d %M %Y') as tanggal2,COUNT(b.id) AS jml_tolak FROM tr_spplsp3 a LEFT JOIN tr_spplsp3_detail b ON a.id_spplsp3 = b.id_tr_spplsp3 WHERE tahun LIKE '".intval($subdata['cur_tahun'])."'".$vSQL." GROUP BY a.id_spplsp3 ORDER BY a.nomor DESC";
            $subdata['daftar_spplsp3'] = $this->db->query($sql)->result();
            // $subdata['cur_tahun'] = $d['tahun'];
        // }
        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view("rsa_lsphk3/daftar_spplsp3",$subdata,TRUE);
        $this->load->view('main_template',$data);
    }

    function example_data(){
    	echo '[{"id":"1","id_kontrak":"9","kode_usulan_belanja":"111112040401020501521213","kode_akun_tambah":"001","nomor_kontrak":"12345678","tanggal":"2017-03-11","nilai_kontrak":"18750000","kontrak_terbayar":"18750000","denda":"0","termin":"Lunas","jenis_kegiatan":"FISIK","nomor_bap":"BAP/UNDIP/111","nomor_bast":"BAST/UNDIP/112","url_file":"http://simaset.undip.ac.id/sikontrak/latihan/assets/uploads/pembayaran/lampiran_barang.xlsx","subunit":"","barang":[{"id":"36","id_pembayaran":"1","no":"1","nama_barang":"Buku 1","jumlah":"150","satuan":"Unit","harga_satuan":"75000","jumlah_harga":"11250000"},{"id":"37","id_pembayaran":"1","no":"2","nama_barang":"Buku 2","jumlah":"50","satuan":"Unit","harga_satuan":"75000","jumlah_harga":"3750000"},{"id":"38","id_pembayaran":"1","no":"3","nama_barang":"Buku 3","jumlah":"50","satuan":"Unit","harga_satuan":"75000","jumlah_harga":"3750000"}],"kontrak":{"id":"9","id_rup":"8","id_rekanan":"209","tahun_anggaran":"2017","nama_kegiatan":"Cetak jurnal dan majalah","nama_paket_pengadaan":"Cetak jurnal dan majalah","id_paket":"8","jenis_pengadaan":"Jasa Lainnya","deskripsi":"Biaya cetak jurnal dan majalah","sumber_dana":"NON-APBN","pagu":"18750000","mak":"521213","nomor_kontrak":"12345678","nilai_kontrak":"18750000","metode_pemilihan_penyedia":"Pengadaan Langsung","mulai_pengadaan":"2017-02-08","selesai_pengadaan":"2017-03-10","mulai_pelaksanaan":"2017-03-11","selesai_pelaksanaan":"2017-06-09","lokasi":"Fakultas Psikologi","tahapan":"9","status":"5","flag":"1","tanggal_update":"2017-02-08 17:13:22"},"rekanan":{"id_rekanan":"209","npwp":"123456","nama_rekanan":"CV Sejahtera Abadi","alamat_rekanan":"Jl Diponegoro No 1","bank_rekanan":"Bank Mandiri","nama_rekening_bank":"CV Sejahtera Abadi","rekening_rekanan":"123456789","gambar_npwp":"","gambar_bank":""}},{"id":"2","id_kontrak":"10","kode_usulan_belanja":"131811010201020501518111","kode_akun_tambah":"001","nomor_kontrak":"KONTRAK/UNDIP/4123","tanggal":"2017-03-11","nilai_kontrak":"1800000","kontrak_terbayar":"1800000","denda":"0","termin":"Lunas","jenis_kegiatan":"FISIK","nomor_bap":"BAP/UNDIP/112","nomor_bast":"BAST/UNDIP/113","url_file":"http://simaset.undip.ac.id/sikontrak/latihan/assets/uploads/pembayaran/lampiran_barang1.xlsx","subunit":"","barang":[{"id":"41","id_pembayaran":"2","no":"1","nama_barang":"Pembicara 1","jumlah":"1","satuan":"orang/jam","harga_satuan":"900000","jumlah_harga":"900000"},{"id":"42","id_pembayaran":"2","no":"2","nama_barang":"Pembicara 2","jumlah":"1","satuan":"orang/jam","harga_satuan":"900000","jumlah_harga":"900000"}],"kontrak":{"id":"10","id_rup":"9","id_rekanan":"209","tahun_anggaran":"2017","nama_kegiatan":"Honorarium Narasumber tanggal 25 Januari 2017","nama_paket_pengadaan":"Honorarium Narasumber tanggal 25 Januari 2017","id_paket":"9","jenis_pengadaan":"Jasa Lainnya","deskripsi":"Honorarium Narasumber tanggal 25 Januari 2017","sumber_dana":"NON-APBN","pagu":"1800000","mak":"518111","nomor_kontrak":"KONTRAK/UNDIP/4123","nilai_kontrak":"1800000","metode_pemilihan_penyedia":"Pengadaan Langsung","mulai_pengadaan":"2017-02-08","selesai_pengadaan":"2017-03-10","mulai_pelaksanaan":"2017-03-11","selesai_pelaksanaan":"2017-06-09","lokasi":"LPPM","tahapan":"9","status":"5","flag":"1","tanggal_update":"2017-02-08 17:21:48"},"rekanan":{"id_rekanan":"209","npwp":"123456","nama_rekanan":"CV Sejahtera Abadi","alamat_rekanan":"Jl Diponegoro No 1","bank_rekanan":"Bank Mandiri","nama_rekening_bank":"CV Sejahtera Abadi","rekening_rekanan":"123456789","gambar_npwp":"","gambar_bank":""}},{"id":"3","id_kontrak":"7","kode_usulan_belanja":"121130040401020301521217","kode_akun_tambah":"001","nomor_kontrak":"1234567","tanggal":"2017-03-11","nilai_kontrak":"98000000","kontrak_terbayar":"90000000","denda":"0","termin":"1","jenis_kegiatan":"FISIK","nomor_bap":"123456","nomor_bast":"123456","url_file":"http://simaset.undip.ac.id/sikontrak/latihan/assets/uploads/pembayaran/lampiran_barang2.xlsx","subunit":"","barang":[{"id":"43","id_pembayaran":"3","no":"1","nama_barang":"Pembicara 1","jumlah":"1","satuan":"orang/jam","harga_satuan":"900000","jumlah_harga":"900000"},{"id":"44","id_pembayaran":"3","no":"2","nama_barang":"Pembicara 2","jumlah":"1","satuan":"orang/jam","harga_satuan":"900000","jumlah_harga":"900000"}],"kontrak":{"id":"7","id_rup":"6","id_rekanan":"208","tahun_anggaran":"2017","nama_kegiatan":"Pengadaan Konsumsi","nama_paket_pengadaan":"Pengadaan Konsumsi","id_paket":"6","jenis_pengadaan":"Jasa Lainnya","deskripsi":"Pengadaan Konsumsi Rapat","sumber_dana":"NON-APBN","pagu":"100000000","mak":"525111","nomor_kontrak":"1234567","nilai_kontrak":"98000000","metode_pemilihan_penyedia":"Pengadaan Langsung","mulai_pengadaan":"2017-02-08","selesai_pengadaan":"2017-03-10","mulai_pelaksanaan":"2017-03-11","selesai_pelaksanaan":"2017-06-09","lokasi":"Fakultas Hukum","tahapan":"9","status":"5","flag":"1","tanggal_update":"2017-02-08 11:40:33"},"rekanan":{"id_rekanan":"208","npwp":"123456789","nama_rekanan":"CV Insan Sejahtera","alamat_rekanan":"Jl Diponegoro No 1","bank_rekanan":"Bank Mandiri","nama_rekening_bank":"CV Insan Sejahtera","rekening_rekanan":"0987654321","gambar_npwp":"http://simaset.undip.ac.id/sikontrak/latihan/asset","gambar_bank":"http://simaset.undip.ac.id/sikontrak/latihan/asset"}}]';
    }
}
?>
