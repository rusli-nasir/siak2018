<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['menu8'] = true;
        $this->cek_session_in();
        $this->load->model('akuntansi/Saldo_model', 'Saldo_model');
        $this->data['db2'] = $this->load->database('rba',TRUE);
    }

	public function index($akun = 1){
		if($akun==1){
			$this->data['tab1'] = true;
		}else if($akun==2){
			$this->data['tab2'] = true;
		}else{
			$this->data['tab3'] = true;
		}
		
		$this->data['query'] = $this->Saldo_model->read_by_akun($akun);

		$temp_data['content'] = $this->load->view('akuntansi/saldo_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function tambah(){
		$this->data['tab1'] = true;

		$this->data['query_1'] = $this->Saldo_model->read_akun_6('akuntansi_aset_6', null);
		$this->data['query_2'] = $this->Saldo_model->read_akun_6('akuntansi_hutang_6', null);
		$this->data['query_3'] = $this->Saldo_model->read_akun_6('akuntansi_aset_bersih_6', null);

		$temp_data['content'] = $this->load->view('akuntansi/saldo_tambah',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function tambah_proses(){
		$kode_akun = $this->input->post('kode_akun');
		$tahun = $this->input->post('tahun');
		$saldo_awal = $this->input->post('saldo_awal');

		//cek
		$query_cek = $this->Saldo_model->read(array('akun'=>$kode_akun, 'tahun'=>$tahun));
		if($query_cek->num_rows() == 0){
			$data = array(
				'akun'=>$kode_akun,
				'tahun'=>$tahun,
				'saldo_awal'=>$saldo_awal,
				'saldo_sekarang'=>$saldo_awal
			);

			$insert = $this->Saldo_model->create($data);
			if($insert){
				redirect(site_url('akuntansi/saldo/tambah?balasan=1'));
			}else{
				redirect(site_url('akuntansi/saldo/tambah?balasan=2'));
			}
		}else{
			redirect(site_url('akuntansi/saldo/tambah?balasan=3'));
		}	
	}

	public function edit($id){
		$this->data['tab1'] = true;

		$this->data['id'] = $id;
		$this->data['query'] = $this->Saldo_model->read(array('id'=>$id))->row_array();
		$this->data['query_1'] = $this->Saldo_model->read_akun_6('akuntansi_aset_6', null);
		$this->data['query_2'] = $this->Saldo_model->read_akun_6('akuntansi_hutang_6', null);
		$this->data['query_3'] = $this->Saldo_model->read_akun_6('akuntansi_aset_bersih_6', null);

		$temp_data['content'] = $this->load->view('akuntansi/saldo_edit',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function edit_proses($id){
		$kode_akun = $this->input->post('kode_akun');
		$tahun = $this->input->post('tahun');
		$saldo_awal = $this->input->post('saldo_awal');
		$saldo_sekarang = $this->input->post('saldo_sekarang');
		$query = $this->Saldo_model->read(array('id'=>$id))->row_array();

		$data = array(
				'akun'=>$kode_akun,
				'tahun'=>$tahun,
				'saldo_awal'=>$saldo_awal,
				'saldo_sekarang'=>$saldo_sekarang
			);

		//cek
		if($kode_akun==$query['akun'] AND $tahun==$query['tahun']){
			$insert = $this->Saldo_model->update(array('id'=>$id), $data);
		}else{
			$query_cek = $this->Saldo_model->read(array('akun'=>$kode_akun, 'tahun'=>$tahun));
			if($query_cek->num_rows() == 0){
				$insert = $this->Saldo_model->update(array('id'=>$id), $data);
			}else{
				redirect(site_url('akuntansi/saldo/edit/'.$id.'/?balasan=3'));
			}
		}

		if($insert){
			redirect(site_url('akuntansi/saldo/edit/'.$id.'/?balasan=1'));
		}else{
			redirect(site_url('akuntansi/saldo/edit/'.$id.'/?balasan=2'));
		}
	}

	public function delete($id){
		$delete = $this->Saldo_model->delete(array('id'=>$id));
		if($delete){
			redirect(site_url('akuntansi/saldo/index/?balasan=3'));
		}else{
			redirect(site_url('akuntansi/saldo/index/?balasan=4'));
		}
	}
}
