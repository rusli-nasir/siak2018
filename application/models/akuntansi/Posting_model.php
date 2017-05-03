<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posting_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
        $this->load->model('akuntansi/Relasi_kuitansi_akun_model', 'Relasi_kuitansi_akun_model');

        $this->load->spark('curl/1.2.1');
        $this->load->spark('restclient/2.1.0');
        $this->cek_session_in();
        $this->load->library('rest');

	    $config = array('server'  => 'http://localhost/laporan_akuntansi/index.php/api/kuitansi/',
	                //'api_key'         => 'Setec_Astronomy'
	                //'api_name'        => 'X-API-KEY'
	                'http_user'       => 'rsa',
	                'http_pass'       => 'TheH4$hslingingslicer',
	                'http_auth'       => 'digest',
	                //'ssl_verify_peer' => TRUE,
	                //'ssl_cainfo'      => '/certs/cert.pem'
	    );
		$this->rest->initialize($config);
    }

    public function posting_kuitansi_full($id_kuitansi_jadi){
		$this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
		$this->load->model('akuntansi/Riwayat_model', 'Riwayat_model');

		$data = $this->Kuitansi_model->get_kuitansi_posting($id_kuitansi_jadi);
		$relasi = $this->Relasi_kuitansi_akun_model->get_relasi_kuitansi_akun();
		$hasil = $this->rest->post('input', $data, 'json');

		if ($relasi != null){
			$hasil = $this->rest->post('input_relasi', $relasi, 'json');
		}
		
		if ($hasil !== null){
			$data = $this->Kuitansi_model->get_kuitansi_posting($id_kuitansi_jadi);

	    	echo 'masuk';

	    	$riwayat = array();

	        $kuitansi = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);
	        $riwayat['flag'] = $kuitansi['flag'] + 1;
	        $riwayat['status'] = 4;
	        $riwayat['komentar'] ='';
	        $riwayat['id_kuitansi_jadi'] = $id_kuitansi_jadi;

	        $entry['flag'] = $riwayat['flag'];
	        $entry['status'] = 4;
	        $this->Riwayat_model->add_riwayat($riwayat);
	        $this->Kuitansi_model->update_kuitansi_jadi($id_kuitansi_jadi,$entry);
	        $this->session->set_flashdata('success','Berhasil menyimpan !');
		} else{
            $this->session->set_flashdata('warning','Gagal menyimpan !');
     	}

		redirect('akuntansi/kuitansi');
     	// echo 'selesai';

	}
	
	
}