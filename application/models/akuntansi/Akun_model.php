<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	public function get_nama_akun($kode_akun){
		if (isset($kode_akun)){
			if ($kode_akun[0] == 5){
				return $this->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
			} else if ($kode_akun[0] == 7){
				$kode_akun[0] = 5;
				$nama = $this->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
				$uraian_akun = explode(' ', $nama);
				if(isset($uraian_akun[2])){
		            if($uraian_akun[2]!='beban'){
		              $uraian_akun[2] = 'beban';
		            }
		        }
	            $hasil_uraian = implode(' ', $uraian_akun);
	            return $hasil_uraian;
			} else if ($kode_akun[0] == 6 or $kode_akun[0] == 4){
				$kode_akun[0] = 4;
				return $this->db->get_where('akuntansi_lra_6',array('akun_6' => $kode_akun))->row_array()['nama'];
			} else if ($kode_akun[0] == 9){
				return 'SAL';
			} else if ($kode_akun[0] == 1){
				return $this->db->get_where('akuntansi_kas_rekening',array('kode_rekening' => $kode_akun))->row_array()['uraian'];
			} else {
				return 'Nama tidak ditemukan';
			}
		}
		
	}

	public function get_saldo_awal($kode_akun)
	{
		return 1000000000;
	}
}