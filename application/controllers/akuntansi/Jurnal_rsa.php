<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal_rsa extends MY_Controller {
	public function __construct(){
        parent::__construct();
        // $this->cek_session_in();
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
        $this->load->model('akuntansi/Memorial_model', 'Memorial_model');
        $this->load->model('akuntansi/Riwayat_model', 'Riwayat_model');
        $this->load->model('akuntansi/Pajak_model', 'Pajak_model');
        $this->load->model('akuntansi/Akun_kas_rsa_model', 'Akun_kas_rsa_model');
        $this->load->model('akuntansi/Akun_belanja_rsa_model', 'Akun_belanja_rsa_model');
        $this->load->model('Rsa_unit_model');

        setlocale(LC_NUMERIC, 'Indonesian');
    }

	public function input_jurnal($id_kuitansi,$jenis){

		$this->load->library('form_validation');

		$this->form_validation->set_rules('jenis_pembatasan_dana','Jenis Pembatasan Dana','required');
		// $this->form_validation->set_rules('akun_debet_akrual','Akun debet (Akrual)','required');
		$this->form_validation->set_rules('akun_kredit_akrual','Akun kredit (Akrual)','required');
		$this->form_validation->set_rules('akun_kredit','Akun kredit (Kas)','required');


		if($this->form_validation->run())     
        {   
            $entry = $this->input->post();

            $array_spm = $this->Spm_model->get_jenis_spm();
            if (in_array($jenis,$array_spm)){
                $kuitansi = $this->Spm_model->get_spm_transfer($id_kuitansi,$jenis);
            }
            else if ($jenis != 'NK')
                $kuitansi = $this->Kuitansi_model->get_kuitansi_transfer($id_kuitansi,$this->Kuitansi_model->get_tabel_by_jenis($jenis),$this->Kuitansi_model->get_tabel_detail_by_jenis($jenis));
            else {
                $kuitansi = $this->Kuitansi_model->get_kuitansi_transfer_nk($id_kuitansi);
                $kuitansi['status'] = 1;
                $kuitansi['no_bukti'] = $this->input->post('no_bukti');
                // print_r($kuitansi);die();
            }
            unset($entry['simpan']);

            $entry = array_merge($kuitansi,$entry);


            $entry['jumlah_kredit'] = $entry['jumlah_debet'];
            $entry['flag'] = 1;
            $entry['tipe'] = 'pengeluaran';
            $entry['tanggal_jurnal'] = date('Y-m-d H:i:s');


            $q1 = $this->Kuitansi_model->add_kuitansi_jadi($entry);

            $updater =  array();
            $updater['flag_proses_akuntansi'] = 1;

            if (in_array($jenis,$array_spm)){
                $q2 = $this->Spm_model->update_spm($id_kuitansi,$updater,$jenis);
                if ($jenis == 'LSPHK3') {
                    $array_pajak = $this->Pajak_model->get_transfer_pajak($q1);
                    $this->Pajak_model->insert_pajak($q1,$array_pajak);
                }
            }
            else if ($jenis != 'NK') {
                $q2 = $this->Kuitansi_model->update_kuitansi($id_kuitansi,$this->Kuitansi_model->get_tabel_by_jenis($kuitansi['jenis']),$updater);
                $array_pajak = $this->Pajak_model->get_transfer_pajak($q1);
                $this->Pajak_model->insert_pajak($q1,$array_pajak);
            }
            else{
                $q2 = $this->Kuitansi_model->update_kuitansi_nk($id_kuitansi,$updater);
                $pajak = $this->Pajak_model->get_akun_by_jenis('PPh_Ps_21');
                $pajak['akun'] = $pajak['kode_akun'];
                $pajak['persen_pajak'] = null;
                $pajak['jenis'] = 'pajak';

                $isian_ = $this->Kuitansi_model->get_kuitansi_nk($id_kuitansi);
                $pajak['jumlah'] = $isian_['pajak'];

                unset($pajak['kode_akun']);
                unset($pajak['id_akun_pajak']);
                unset($pajak['nama_akun']);

                if ($pajak['jumlah'] != 0) {
                    $array_pajak = array($pajak);
                } else {
                    $array_pajak = null;
                }

                // print_r($array_pajak);die();


                $this->Pajak_model->insert_pajak($q1,$array_pajak);
            }

            if ($q1 and $q2)
            	$this->session->set_flashdata('success','Berhasil menyimpan !');
            else
            	$this->session->set_flashdata('warning','Gagal menyimpan !');

            echo $jenis;

            $direct_url = 'akuntansi/kuitansi/index';
            if($jenis=='NK'){
                $direct_url = 'akuntansi/kuitansi/index_spm';
            }else if($jenis=='UP'){
                $direct_url = 'akuntansi/kuitansi/index_up';
            }else if($jenis=='PUP'){
                $direct_url = 'akuntansi/kuitansi/index_pup';
            }else if($jenis=='GP'){
                $direct_url = 'akuntansi/kuitansi/index';
            }else if($jenis=='GUP'){
                $direct_url = 'akuntansi/kuitansi/index_gup';
            }else if($jenis=='TUP'){
                $direct_url = 'akuntansi/kuitansi/index_tup';
            }
            redirect($direct_url);

        }
        else
        {          
            if (in_array($jenis,$this->Spm_model->get_jenis_spm())){
                $isian = $this->Spm_model->get_spm_input($id_kuitansi,$jenis);
                $isian['akun_sal'] = $this->Jurnal_rsa_model->get_akun_sal_by_unit($this->session->userdata('kode_unit'));
                if ($jenis == 'LSPHK3') {
                    $akun_debet_akrual = $isian['akun_debet'];
                    $akun_debet_akrual[0] = 7;
                    $isian['akun_debet_akrual'] = $akun_debet_akrual;
                    $isian['akun_sal'] = $this->Jurnal_rsa_model->get_akun_sal_by_unit('all');
                }
            }
            else if ($jenis != 'NK'){
			    $isian = $this->Jurnal_rsa_model->get_kuitansi($id_kuitansi,$this->Kuitansi_model->get_tabel_by_jenis($jenis),$this->Kuitansi_model->get_tabel_detail_by_jenis($jenis));
                $isian['jenis_pembatasan_dana'] = $this->Jurnal_rsa_model->get_jenis_pembatasan_dana($id_kuitansi,$this->Kuitansi_model->get_tabel_by_jenis($jenis));
                $akun_debet_akrual = $isian['kode_akun'];
                $akun_debet_akrual[0] = 7;
                $isian['akun_debet_akrual'] = $akun_debet_akrual;
                $isian['pajak'] = $this->Pajak_model->get_detail_pajak($isian['no_bukti'],$isian['jenis']);
                $isian['akun_sal'] = $this->Jurnal_rsa_model->get_akun_sal_by_unit($this->session->userdata('kode_unit'));

                // $isian['pajak'] = null;
                // print_r($isian);die();
                // print_r($isian['pajak']);die();
            } else {
                $isian = $this->Kuitansi_model->get_kuitansi_nk($id_kuitansi);
                $isian['id_kuitansi'] = $id_kuitansi;
                $isian['akun_debet_akrual'] = substr_replace($isian['kode_akun'], 7, 0,1);
                $isian['jenis_pembatasan_dana'] = '';
                // $isian['jenis_isian'] = 'nk';
                $isian['tanggal_bukti'] = $isian['tanggal'];

                if ($isian['pajak'] == 0) {
                    $isian['pajak'] = null;
                }else {
                    $pajak = $isian['pajak'];
                    unset($isian['pajak']);
                    $isian['pajak'][0] = $this->Pajak_model->get_akun_by_jenis('PPh_Ps_21');
                    $isian['pajak'][0]['rupiah_pajak'] = $pajak;
                    $isian['pajak'][0]['persen_pajak'] = null;
                }

                $isian['akun_sal'] = $this->Jurnal_rsa_model->get_akun_sal_by_unit('all');


                // print_r($isian);die();
            }
            // print_r($isian);die();
			//$isian['akun_kas'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
            $isian['query_1'] = $this->Memorial_model->read_akun('akuntansi_aset_6');
            $isian['query_2'] = $this->Memorial_model->read_akun('akuntansi_hutang_6');

			$isian['akun_belanja'] = $this->Akun_belanja_rsa_model->get_all_akun_belanja();
	        $this->data['tab'] = 'beranda';
	        $this->data['menu1'] = true;
            $isian['jenis'] = $jenis;
             //get rekening by unit
            $isian['akun_kas'] = $this->Jurnal_rsa_model->get_rekening_by_unit($this->session->userdata('kode_unit'))->result();
	        // print_r($isian['akun_kas']);die();
	        // $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian);
			$this->data['content'] = $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian,true);
			$this->load->view('akuntansi/content_template',$this->data,false);
        }


		
	}


    public function detail_kuitansi($id_kuitansi_jadi,$mode='lihat')
    {

        $isian = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);

        
        $isian['akun_sal'] = array($this->Jurnal_rsa_model->get_akun_sal_by_unit($this->session->userdata('kode_unit')));
        $isian['akun_sal'][] = $this->Jurnal_rsa_model->get_akun_sal_by_unit('all');
        $isian['akun_kas'] = $this->Jurnal_rsa_model->get_rekening_by_unit($this->session->userdata('kode_unit'))->result_array();
        $isian['pajak'] = $this->Pajak_model->get_detail_pajak_jadi($id_kuitansi_jadi);

        // print_r($isian);
        // print_r($isian['akun_sal']);die();

        $isian['akun_belanja'] = $this->Akun_belanja_rsa_model->get_all_akun_belanja();
        $isian['mode'] = $mode;
        $this->data['tab'] = 'beranda';
        $this->data['menu2'] = true;

        $query_riwayat = $this->db->query("SELECT * FROM akuntansi_riwayat WHERE id_kuitansi_jadi='$id_kuitansi_jadi' ORDER BY id DESC LIMIT 0,1")->row_array();
        $isian['komentar'] = $query_riwayat['komentar'];
        // print_r($isian['akun_kas']);die();
        // $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian);
        $this->data['content'] = $this->load->view('akuntansi/detail_kuitansi_jadi',$isian,true);
        $this->load->view('akuntansi/content_template',$this->data,false);
    }

    public function ganti_status($id_kuitansi_jadi)
    {
        $post = $this->input->post();
        $updater = array();
        $status = $this->input->post('status');

        $kuitansi = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
        $flag = $kuitansi['flag'];
        $jenis = $kuitansi['jenis'];

        $riwayat['status'] = $status;
        $riwayat['id_kuitansi_jadi'] = $id_kuitansi_jadi;
        $riwayat['flag'] = $flag;
        $riwayat['komentar'] = $this->input->post('komentar');

        $this->Riwayat_model->add_riwayat($riwayat);


        if ($status == 2){
            $status = 1;
            $riwayat['status'] = $status;
            $flag++;
            $riwayat['flag'] = $flag;
            $riwayat['komentar'] = '';
            $this->Riwayat_model->add_riwayat($riwayat);
        } 

        $updater['status'] = $status;
        $updater['flag'] = $flag;
        $updater['kode_user'] = $this->session->userdata('kode_user');
        $updater['tanggal_verifikasi'] = date('Y-m-d H:i:s');

        $this->Kuitansi_model->update_kuitansi_jadi($id_kuitansi_jadi,$updater);

        if ($kuitansi['id_pajak'] !== 0) {
            $this->Kuitansi_model->update_kuitansi_jadi($kuitansi['id_pajak'],$updater);    
        }

        $direct_url = 'akuntansi/kuitansi/jadi';
        if($jenis=='NK'){
            $direct_url = 'akuntansi/kuitansi/jadi_spm';
        }else if($jenis=='UP'){
            $direct_url = 'akuntansi/kuitansi/jadi/1/UP';
        }else if($jenis=='PUP'){
            $direct_url = 'akuntansi/kuitansi/jadi/1/PUP';
        }else if($jenis=='GP'){
            $direct_url = 'akuntansi/kuitansi/jadi/1/GP';
        }else if($jenis=='GUP'){
            $direct_url = 'akuntansi/kuitansi/jadi/1/GUP';
        }else if($jenis=='GP_NIHIL'){
            $direct_url = 'akuntansi/kuitansi/jadi/1/GP_NIHIL';
        }else if($jenis=='TUP'){
            $direct_url = 'akuntansi/kuitansi/jadi/1/TUP';
        }else if($jenis=='TUP_NIHIL'){
            $direct_url = 'akuntansi/kuitansi/jadi/1/TUP_NIHIL';
        }else if($jenis=='TUP'){
            $direct_url = 'akuntansi/kuitansi/index_tup';
        }
        redirect($direct_url);

    }

    public function edit_kuitansi_jadi($id_kuitansi_jadi,$mode=null)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('jenis_pembatasan_dana','Jenis Pembatasan Dana','required');
        $this->form_validation->set_rules('akun_kredit_akrual','Akun kredit (Akrual)','required');
        $this->form_validation->set_rules('akun_kredit','Akun kredit (Kas)','required');

        if($this->form_validation->run())     
        {   
            $entry = $this->input->post();
            unset($entry['simpan']);

            if ($mode == 'revisi'){
                $riwayat = array();
                $kuitansi = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
                $riwayat['flag'] = $kuitansi['flag'];
                $riwayat['status'] = 5;
                $riwayat['id_kuitansi_jadi'] = $id_kuitansi_jadi;
                $riwayat['komentar'] ='';

                $entry['status'] = 5;
                $entry['tanggal_jurnal'] = date('Y-m-d H:i:s');
                
                $this->Riwayat_model->add_riwayat($riwayat);

            }

            $q2 = $this->Kuitansi_model->update_kuitansi_jadi($id_kuitansi_jadi,$entry);

            if ($q2)
                $this->session->set_flashdata('success','Berhasil menyimpan !');
            else
                $this->session->set_flashdata('warning','Gagal menyimpan !');

            redirect('akuntansi/jurnal_rsa/detail_kuitansi/'.$id_kuitansi_jadi.'/lihat');

        }
        else
        {

            $isian = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
            // $isian['akun_kas'] = $this->Akun_kas_rsa_model->get_all_akun_kas();
            // $isian['akun_belanja'] = $this->Akun_belanja_rsa_model->get_all_akun_belanja();

            $isian['query_1'] = $this->Memorial_model->read_akun('akuntansi_aset_6');
            $isian['query_2'] = $this->Memorial_model->read_akun('akuntansi_hutang_6');

            $isian['akun_kas'] = $this->Jurnal_rsa_model->get_rekening_by_unit($this->session->userdata('kode_unit'))->result_array();

            $isian['akun_belanja'] = $this->Akun_belanja_rsa_model->get_all_akun_belanja();

            $isian['pajak'] = $this->Pajak_model->get_detail_pajak_jadi($id_kuitansi_jadi);

            $isian['mode'] = $mode;
            $this->data['tab'] = 'beranda';
            $this->data['menu1'] = true;

            $query_riwayat = $this->db->query("SELECT * FROM akuntansi_riwayat WHERE id_kuitansi_jadi='$id_kuitansi_jadi' ORDER BY id DESC LIMIT 0,1")->row_array();
            $isian['komentar'] = $query_riwayat['komentar'];
            $isian['akun_kas'] = $this->Jurnal_rsa_model->get_rekening_by_unit($this->session->userdata('kode_unit'))->result();
            $isian['akun_sal'] = array($this->Jurnal_rsa_model->get_akun_sal_by_unit($this->session->userdata('kode_unit')));
            $isian['akun_sal'][] = $this->Jurnal_rsa_model->get_akun_sal_by_unit('all');
            // print_r($isian['akun_kas']);die();
            // $this->load->view('akuntansi/rsa_jurnal_pengeluaran_kas/form_jurnal_pengeluaran_kas',$isian);
            $this->data['content'] = $this->load->view('akuntansi/edit_kuitansi_jadi',$isian,true);
            $this->load->view('akuntansi/content_template',$this->data,false);
        }
    }



	public function coba()
	{
        $this->load->model('akuntansi/Notifikasi_model', 'Notifikasi_model');
		print_r($this->Notifikasi_model->get_jumlah_notifikasi(2));
        print_r($_SESSION);
	}
}
