<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal_rsa extends MY_Controller {
	private $data;

	public function __construct(){
        parent::__construct();
        // $this->cek_session_in();
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
        $this->load->model('akuntansi/Riwayat_model', 'Riwayat_model');
        $this->load->model('akuntansi/Akun_kas_rsa_model', 'Akun_kas_rsa_model');
        $this->load->model('akuntansi/Akun_belanja_rsa_model', 'Akun_belanja_rsa_model');
        $this->load->model('Rsa_unit_model');
    }

	public function input_jurnal($id_kuitansi,$jenis){

		$this->load->library('form_validation');

		$this->form_validation->set_rules('jenis_pembatasan_dana','Jenis Pembatasan Dana','required');
		$this->form_validation->set_rules('akun_debet_akrual','Akun debet (Akrual)','required');
		$this->form_validation->set_rules('akun_kredit_akrual','Akun kredit (Akrual)','required');
		$this->form_validation->set_rules('akun_kredit','Akun kredit (Kas)','required');

		if($this->form_validation->run())     
        {   
            $entry = $this->input->post();
            $kuitansi = $this->Kuitansi_model->get_kuitansi_transfer($id_kuitansi,$this->Kuitansi_model->get_tabel_by_jenis($jenis),$this->Kuitansi_model->get_tabel_detail_by_jenis($jenis));
            unset($entry['simpan']);

            $entry = array_merge($kuitansi,$entry);

            $entry['jumlah_kredit'] = $entry['jumlah_debet'];
            $entry['flag'] = 1;

            $q1 = $this->Kuitansi_model->add_kuitansi_jadi($entry);

            $updater =  array();
            $updater['flag_proses_akuntansi'] = 1;

            $q2 = $this->Kuitansi_model->update_kuitansi($id_kuitansi,$this->Kuitansi_model->get_tabel_by_jenis($kuitansi['jenis']),$updater);

            if ($q1 and $q2)
            	$this->session->set_flashdata('success','Berhasil menyimpan !');
            else
            	$this->session->set_flashdata('warning','Gagal menyimpan !');

            redirect('akuntansi/kuitansi');

        }
        else
        {

			$isian = $this->Jurnal_rsa_model->get_kuitansi($id_kuitansi,$this->Kuitansi_model->get_tabel_by_jenis($jenis),$this->Kuitansi_model->get_tabel_detail_by_jenis($jenis));
			$isian['akun_kas'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
			$isian['akun_belanja'] = $this->Akun_belanja_rsa_model->get_all_akun_belanja();
	        $data['tab'] = 'beranda';
	        $data['menu1'] = true;
	        // print_r($isian['akun_kas']);die();
	        // $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian);
			$data['content'] = $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian,true);
			$this->load->view('akuntansi/content_template',$data,false);
        }


		
	}


    public function detail_kuitansi($mode,$id_kuitansi)
    {
        
    }

    public function ganti_status($id_kuitansi)
    {
        $updater = array();
        $status = $this->input->post('status');

        $riwayat['status'] = $status;
        $riwayat['id_kuitansi'] = $id_kuitansi;
        $riwayat['komentar'] = $this->input->post('komentar');
        

        $this->Riwayat_model->add_riwayat($riwayat);
        $komentar = $this->input->post('komentar');

        $kuitansi = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi);

        if ($status == 2){
            $status = 1;
            $riwayat['status'] = $status;
            $riwayat['id_kuitansi'] = $id_kuitansi;
            $flag++;
        }

        $updater['status'] = $status;
        $updater['flag'] = $kuitansi['flag'];
        $this->Kuitansi_model->update_kuitansi($id_kuitansi,$this->Kuitansi_model->get_tabel_by_jenis($kuitansi['jenis']),$updater);


    }



	public function coba()
	{
		print_r($this->db->list_fields('akuntansi_kuitansi_jadi'));
	}
}
