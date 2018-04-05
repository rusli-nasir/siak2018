<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Rsa_gaji_apbn extends CI_Controller
{
	private $cur_tahun = '' ;
	public function __construct()
	{
		parent::__construct();
		$this->cur_tahun = $this->setting_model->get_tahun();

		if ($this->check_session->user_session()){
			/* Load library, helper, dan Model */
			$this->load->library(array('form_validation','option'));
			$this->load->library('excel_reader/Excel_reader');
			$this->load->library('CSVReader');
			$this->load->helper('form');
			$this->load->model('gaji_apbn_model');
			$this->load->model('user_model');
			$this->load->model('menu_model');
			$this->load->model('unit_model');
			$this->load->model('subunit_model');
			$this->load->model('master_unit_model');
		}else{
      		redirect('welcome','refresh');	// redirect ke halaman home
      	}

      }

      function index()
      {
      	if($this->check_session->user_session() && ($this->check_session->get_level()==11)){
      		$subdata['tahun'] =  $this->cur_tahun;
      		$subdata['data_unit'] = $this->unit_model->get_all_unit();
      		$data['cur_tahun'] 			= $this->cur_tahun;
      		$data['main_menu']         = $this->load->view('main_menu','',TRUE);
      		$data['main_content'] 		= $this->load->view("rsa_gaji_apbn/form_upload",$subdata,TRUE);
      		$this->load->view('main_template',$data);
      	}else{
      		redirect('welcome','refresh');
      	}
      }

      function upload($sumber_dana = '',$triwulan = '',$unit = '')
      {
      	/* check session	*/
      	if($this->check_session->user_session()){
			// var_dump($subdata['detail_rsa_kontrak']);die;
      		if($sumber_dana == ''){
      			$sumber_dana = 'SELAIN-APBN';
      		}
      		if($unit == ''){
      			$unit = $this->check_session->get_unit();
      		}
      		if($triwulan == ''){
      			$triwulan = '5';
      		}

			// echo $sumber_dana .' - '. $unit .' - '. $this->cur_tahun ; die ;
      		$subdata['data_akun'] = $this->serapan_model->get_akun($sumber_dana,$unit,$this->cur_tahun,$triwulan);
      		$subdata['data_anggaran'] = $this->serapan_model->get_anggaran($sumber_dana,$unit,$this->cur_tahun);
      		$subdata['data_serapan'] = $this->serapan_model->get_serapan($sumber_dana,$unit,$this->cur_tahun,$triwulan);
			// $subdata['data_anggaran_serapan'] = $this->serapan_model->get_data_anggaran_serapan($sumber_dana,$unit,$this->cur_tahun,$triwulan);
			// vdebug($subdata['data_anggaran_serapan']);

			// echo '<pre>' ;
			// var_dump($subdata) ; 
			// echo '</pre>' ; 
			// die ;

      		$subdata['tahun'] =  $this->cur_tahun;
      		$subdata['unit'] =  $unit ; 
      		$subdata['r_unit'] =  $this->check_session->get_unit();
      		$subdata['triwulan'] =  $triwulan;
      		if($this->check_session->get_unit() == '99'){
      			$subdata['data_unit'] = $this->unit_model->get_all_unit();
				// var_dump($this->unit_model->get_all_unit()); die;
      		}
      		$subdata['sumber_dana'] =  $sumber_dana;
      		$subdata['a_tab'] = 'a-undip';

      		$cur_triwulan = '' ;

      		if($triwulan == '5'){
      			$cur_triwulan = 'S/D SEKARANG' ;
      		}elseif($triwulan == '4'){
      			$cur_triwulan = 'PER 31 DESEMBER 2017' ;
      		}elseif($triwulan == '3'){
      			$cur_triwulan = 'PER 30 SEPTEMBER 2017' ;
      		}elseif($triwulan == '2'){
      			$cur_triwulan = 'PER 30 JUNI 2017' ;
      		}else{
      			$cur_triwulan = 'PER 31 MARET 2017' ;
      		}

      		$subdata['cur_triwulan'] 	= $cur_triwulan;
      		$data['cur_tahun'] 			= $this->cur_tahun;
      		$data['main_menu']         = $this->load->view('main_menu','',TRUE);
      		$data['main_content'] 		= $this->load->view("serapan/index_old",$subdata,TRUE);
      		/* Load main template	*/
			// echo '<pre>';var_dump($subdata['detail_rsa_kontrak']);echo '</pre>';die;
      		$this->load->view('main_template',$data);
      	}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

	function do_upload(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==11)){
			$subdata['tahun'] =  $this->cur_tahun;

			$file_ci_path = realpath(APPPATH . '../assets/uploads/files/');
			$config['upload_path'] = $file_ci_path;
			$config['allowed_types'] = 'xls';
			$config['max_size'] = '1000000';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('excel')) {
				$data['error'] = $this->upload->display_errors();
				vdebug($this->upload->data());
			} else {
				$file_data = $this->upload->data('full_path');

				if($this->upload->data('file_ext') == '.xls'){

					//******************************** INSERT TRX *********************************//
					$no_spm_apbn     	= $this->input->post('no_spm_apbn'); 
					$tahun     			= $this->input->post('tahun'); 
					$bulan     			= $this->input->post('bulan'); 
					$kode_unit     	= $this->input->post('kode_unit'); 
					$jenis_gaji     	= $this->input->post('jenis_gaji'); 
					$jabatan     		= $this->input->post('jabatan'); 

					if ($jenis_gaji == 'gapok_tunjangan') {
						$tabel = 'w_apbn_gaji_tunjangan';
					}

					$no_spm_apbn = 'NO_SPM/'.$tabel.'/'.$no_spm_apbn;

					$data_trx = array(
						'no_spm_apbn' => $no_spm_apbn,
						'bulan_gaji' => $bulan,
						'tahun_gaji' => $tahun,
						'kd_unit_subunit' => $kode_unit,
						'tgl_upload' => date('Y-m-d H:i:s'),
						'jenis_gaji' => $jenis_gaji,
						'jenis_jabatan' => $jabatan,
					);
					$id_insert = $this->gaji_apbn_model->insert_trx($data_trx);
					//******************************** INSERT TRX *********************************//

					//******************************** TRX DETIL *********************************//
	        		$this->excel_reader->read($file_data);
	        		$result =   $this->excel_reader->sheets[0];

	        		if ($jenis_gaji == 'gapok_tunjangan') {
		        		$header = array_values(
		        						array(
						        			1 => 'id_w_apbn_gaji_',
						        			2 => 'kdsatker',
						        			3 => 'kdanak',
						        			4 => 'kdsubanak',
						        			5 => 'bulan',
						        			6 => 'tahun',
						        			7 => 'nogaji',
						        			8 => 'kdjns',
						        			9 => 'nip',
						        			10 => 'nmpeg',
						        			11 => 'kdduduk',
						        			12 => 'kdgol',
						        			13 => 'npwp',
						        			14 => 'nmrek',
						        			15 => 'nm_bank',
						        			16 => 'rekening',
						        			17 => 'kdbankspan',
						        			18 => 'nmbankspan',
						        			19 => 'kdpos',
						        			20 => 'kdnegara',
						        			21 => 'kdkppn',
						        			22 => 'tipesup',
						        			23 => 'gjpokok',
						        			24 => 'tjistri',
						        			25 => 'tjanak',
						        			26 => 'tjupns',
						        			27 => 'tjstruk',
						        			28 => 'tjfungs',
						        			29 => 'tjdaerah',
						        			30 => 'tjpencil',
						        			31 => 'tjlain',
						        			32 => 'tjkompen',
						        			33 => 'pembul',
						        			34 => 'tjberas',
						        			35 => 'tjpph',
						        			36 => 'potpfkbul',
						        			37 => 'potpfk2',
						        			38 => 'potpfk10',
						        			39 => 'potpph',
						        			40 => 'potswrum',
						        			41 => 'potkelbtj',
						        			42 => 'potlain',
						        			43 => 'pottabrum',
						        			44 => 'bersih',
						        			45 => 'sandi',
						        			46 => 'kdkawin',
						        			47 => 'kdjab',
						        		)
		        					);
	        		}

					unset($result['cells'][1]);
					$result = array_values($result['cells']);
					// vdebug($header);

					foreach ($result as $key2 => $val2) {
						$val2[1] = $id_insert;
						$i = 1;
						foreach ($header as $key => $val) {
							$new_arr[$val] = $val2[$i];
							$i++;
						}
						$data_detil = $new_arr;
						$insert_detil = $this->gaji_apbn_model->insert_detil($data_detil,$tabel);
						// vdebug($new_arr);
						// $arr_result[]=$new_arr;
					}
					// vdebug($arr_result);

					if ($insert_detil && $id_insert != null || $id_insert != 'null') {
						$this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Upload Berhasil.</div>');
						redirect('rsa_gaji_apbn/','refresh');

					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-danger" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Upload Gagal.</div>');
						redirect('rsa_gaji_apbn/','refresh');
					}

				}else{
					$result = array('Error file type not readable');
				}
			}
		}else{
			redirect('welcome','refresh');
		}
	}
}