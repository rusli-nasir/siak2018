<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal_rsa extends MY_Controller {
	private $data;

	public function __construct(){
        parent::__construct();
        // $this->cek_session_in();
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->load->model('Rsa_unit_model');
    }

	public function input_jurnal($id_kuitansi){
		$isian = $this->Jurnal_rsa_model->get_kuitansi($id_kuitansi);
        $data['tab'] = 'beranda';
        // $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian);
		$data['content'] = $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian,true);
		$this->load->view('akuntansi/content_template',$data,false);
	}

	public function coba()
	{
		$id_kuitansi = 4176;
		print_r($this->Jurnal_rsa_model->get_data_kuitansi($id_kuitansi));
		$query = "SELECT SUM(rsa.rsa_kuitansi_detail.volume*rsa.rsa_kuitansi_detail.harga_satuan) AS pengeluaran FROM rsa_kuitansi,rsa_kuitansi_detail WHERE rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi AND rsa_kuitansi.id_kuitansi=$id_kuitansi GROUP BY rsa.rsa_kuitansi.id_kuitansi";
    	print_r($this->db->query($query)->row_array()['pengeluaran']);
	}
}
