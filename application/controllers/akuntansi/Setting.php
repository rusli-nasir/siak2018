<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		 $this->load->helper('url');
		 $this->cek_session_in();
		 $this->load->library('session');
		 $this->load->model('akuntansi/Setting_model_akuntansi', 'Setting_model');
		 setlocale(LC_NUMERIC, 'Indonesian');
	}

	public function index()
	{
		$tahun_awal = '2017';
		$tahun_sekarang = date('Y');
		$tahun = array();

		while ($tahun_awal <= $tahun_sekarang){
			$tahun[] = $tahun_awal;
			$tahun_awal++;
		}
		$this->data['tahun'] = $tahun;
		$this->data['tahun_selected'] = $this->Setting_model->get_tahun();
		$temp_data['content'] = $this->load->view('akuntansi/setting',$this->data,true);
      $this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function setting_tahun(){
		$tahun = $this->input->post('tahun');
		$data = array(
                    'nama' =>  'TAHUN',
                    'nilai' => $tahun,
                    'flag' => 1
                );
		$this->Setting_model->setting_tahun($data);
		$this->session->set_flashdata('success', 'Settingan tahun berhasil diubah!');
		redirect('/akuntansi/Setting/');

	}

}

/* End of file Setting.php */
/* Location: ./application/controllers/akuntansi/Setting.php */