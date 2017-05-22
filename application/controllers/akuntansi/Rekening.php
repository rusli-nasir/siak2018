<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekening extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['menu7'] = true;
        $this->cek_session_in();
        $this->load->model('akuntansi/Rekening_model', 'Rekening_model');
        $this->data['db2'] = $this->load->database('rba',TRUE);
    }

	public function index($id = 0){
		$this->data['tab1'] = true;
		
		$this->data['query'] = $this->Rekening_model->read(null);

		$temp_data['content'] = $this->load->view('akuntansi/rekening_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function tambah(){
		$this->data['tab1'] = true;

		$this->data['query_unit'] = $this->Rekening_model->read_unit();

		$temp_data['content'] = $this->load->view('akuntansi/rekening_tambah',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function tambah_proses(){
		$kode_unit = $this->input->post('kode_unit');
		$kode_rekening = $this->input->post('kode_rekening');
		$uraian = $this->input->post('uraian');

		$data = array(
				'akun_1'=>'1',
				'akun_2'=>'11',
				'akun_3'=>'111',
				'akun_4'=>'1111',
				'kode_unit'=>$kode_unit,
				'akun_6'=>$kode_rekening,
				'nama'=>$uraian
			);

		$insert = $this->Rekening_model->create($data);
		if($insert){
			redirect(site_url('akuntansi/rekening/index?balasan=1'));
		}else{
			redirect(site_url('akuntansi/rekening/tambah?balasan=2'));
		}
	}

	public function edit($id){
		$this->data['tab1'] = true;

		$this->data['id'] = $id;
		$this->data['query'] = $this->Rekening_model->read(array('id_akuntansi_aset_6'=>$id))->row_array();
		$this->data['query_unit'] = $this->Rekening_model->read_unit();

		$temp_data['content'] = $this->load->view('akuntansi/rekening_edit',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function edit_proses($id){
		$kode_unit = $this->input->post('kode_unit');
		$kode_rekening = $this->input->post('kode_rekening');
		$uraian = $this->input->post('uraian');

		$data = array(
				'kode_unit'=>$kode_unit,
				'akun_6'=>$kode_rekening,
				'nama'=>$uraian
			);

		$insert = $this->Rekening_model->update(array('id_akuntansi_aset_6'=>$id), $data);
		if($insert){
			redirect(site_url('akuntansi/rekening/edit/'.$id.'/?balasan=1'));
		}else{
			redirect(site_url('akuntansi/rekening/edit/'.$id.'/?balasan=2'));
		}
	}

	public function delete($id){
		$delete = $this->Rekening_model->delete(array('id_akuntansi_aset_6'=>$id));
		if($delete){
			redirect(site_url('akuntansi/rekening/index/?balasan=3'));
		}else{
			redirect(site_url('akuntansi/rekening/index/?balasan=4'));
		}
	}
}
