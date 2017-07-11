<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	public function get_nama_akun($kode_akun){
		if (isset($kode_akun)){
			if (substr($kode_akun,0,1) == 5){
				return $this->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
			} else if (substr($kode_akun,0,1) == 7){
				$kode_akun[0] = 5;
				$nama = $this->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
				$uraian_akun = explode(' ', $nama);
				if(isset($uraian_akun[2])){
		            if($uraian_akun[0]!='beban'){
		              $uraian_akun[0] = 'beban';
		            }
		        }
	            $hasil_uraian = implode(' ', $uraian_akun);
	            return $hasil_uraian;
			} else if (substr($kode_akun,0,1) == 6 or substr($kode_akun,0,1) == 4){
				$kode_akun[0] = 4;
				$hasil =  $this->db->get_where('akuntansi_lra_6',array('akun_6' => $kode_akun))->row_array()['nama'];
				if ($hasil == null) {
					$hasil = $this->db->get_where('akuntansi_pajak',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
				}
				return $hasil;
			}else if (substr($kode_akun,0,1) == 8){
				$hasil =  $this->db->get_where('akuntansi_pembiayaan_6',array('akun_6' => $kode_akun))->row_array()['nama'];
				if ($hasil == null) {
					$hasil = $this->db->get_where('akuntansi_pajak',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
				}
				return $hasil;
			} else if (substr($kode_akun,0,1) == 9){
				return $this->db->get_where('akuntansi_sal_6', array('akun_6' => $kode_akun))->row_array()['nama'];
			} else if (substr($kode_akun,0,1) == 1){
				$hasil = $this->db->get_where('akuntansi_kas_rekening',array('kode_rekening' => $kode_akun))->row_array()['uraian'];
				if ($hasil == null){
					$hasil = $this->db->get_where('akuntansi_aset_6',array('akun_6' => $kode_akun))->row_array()['nama'];
				}
				// if ($hasil == null){
				// 	$hasil = $this->db->get_where('akun_kas6',array('kd_kas_6' => $kode_akun))->row_array()['nm_kas_6'];
				// }
				return $hasil;
			} else {
				return 'Nama tidak ditemukan';
			}
		}
		
	}

	public function get_saldo_awal($kode_akun)
	{
		$tahun = gmdate('Y');

		$hasil = $this->db->get_where('akuntansi_saldo',array('akun' => $kode_akun,'tahun' => $tahun))->row_array();

		return $hasil;
	}

	public function get_akun_penerimaan()
    {
        $this->db->not_like('nama', 'Operasional');
        return $this->db->get('akuntansi_aset_6')->result_array();
    }

	public function get_kode_sal_penerimaan()
    {
        $this->db->where('kode_unit',9999);
        return $this->db->get('akuntansi_sal_6')->row_array()['akun_6'];
    }

	public function get_kode_sal_jurnal_umum()
    {
        $this->db->where('kode_unit',92);
        return $this->db->get('akuntansi_sal_6')->row_array()['akun_6'];
    }
}