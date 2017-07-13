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
        $this->load->library('rest');

	    $config = array('server'  => 'http://localhost/lapakuntansi/index.php/api/kuitansi/',
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
		$relasi = $this->Relasi_kuitansi_akun_model->get_relasi_kuitansi_akun($id_kuitansi_jadi);

		$hasil = $this->Kuitansi_model->add_kuitansi_jadi($data,'post');

		// $hasil = $this->rest->post('input', $data, 'json');

		if ($relasi != null and $hasil != null){
			$this->Relasi_kuitansi_akun_model->insert_relasi_kuitansi_akun($relasi,'post');
		}
		
		if ($hasil){
	        return true;
		} else{
            return false;
     	}

	}

	public function hapus_posting_full($id_kuitansi_jadi)
	{
		$this->db_laporan = $this->load->database('laporan',TRUE);

		$kuitansi = $this->db_laporan->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi',$id_kuitansi_jadi))->row_array();

		if ($kuitansi['id_pajak'] != 0) {
			$id_pajak = $kuitansi['id_pajak'];
			$this->db_laporan->where('id_kuitansi_jadi',$id_pajak)->delete('akuntansi_kuitansi_jadi');
			$this->db_laporan->where('id_kuitansi_jadi',$id_pajak)->delete('akuntansi_relasi_kuitansi_akun');
		}
		if ($kuitansi['id_pengembalian'] != 0) {
			$id_pengembalian = $kuitansi['id_pengembalian'];
			$this->db_laporan->where('id_kuitansi_jadi',$id_pengembalian)->delete('akuntansi_kuitansi_jadi');
			$this->db_laporan->where('id_kuitansi_jadi',$id_pengembalian)->delete('akuntansi_relasi_kuitansi_akun');
		}

		$this->db_laporan->where('id_kuitansi_jadi',$id_kuitansi_jadi)->delete('akuntansi_kuitansi_jadi');
		$this->db_laporan->where('id_kuitansi_jadi',$id_kuitansi_jadi)->delete('akuntansi_relasi_kuitansi_akun');

	}

	
	
}