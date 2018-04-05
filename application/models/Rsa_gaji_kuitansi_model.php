<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rsa_gaji_kuitansi_model extends CI_Model {
	/* -------------- Constructor ------------- */

	public function __construct()
	{
		parent::__construct();	
	}
	
	function get_spm($jenis,$unit){
		$query = "SELECT DISTINCT a.str_nomor_trx_spm,b.jenis_trx, b.nominal
					FROM rsa_kuitansi as a
					JOIN trx_urut_spm_cair as b
						ON a.str_nomor_trx_spm = b.str_nomor_trx_spm
					WHERE b.jenis_trx = '{$jenis}' 
						AND ((SUBSTR(a.kode_usulan_belanja,19,4) BETWEEN 5111 AND 5319) OR (SUBSTR(a.kode_usulan_belanja,19,4) BETWEEN 5331 AND 5331)) 
						AND b.kode_unit_subunit = '{$unit}'
					ORDER BY a.str_nomor_trx_spm,a.no_bukti ASC
		";
		$query = $this->db->query($query);

        // vdebug($query->result());
		if ($query->num_rows() > 0){
			return $query->result();
		}else{
			return array();
		}
	}

	function get_kuitansi($spm){
		$query = "SELECT DISTINCT a.no_bukti, a.kode_akun4digit
					FROM rsa_kuitansi as a
					JOIN trx_urut_spm_cair as b
						ON a.str_nomor_trx_spm = b.str_nomor_trx_spm
					WHERE b.str_nomor_trx_spm = '{$spm}' 
						AND ((SUBSTR(a.kode_usulan_belanja,19,4) BETWEEN 5111 AND 5319) OR (SUBSTR(a.kode_usulan_belanja,19,4) BETWEEN 5331 AND 5331)) 
					ORDER BY a.str_nomor_trx_spm,a.no_bukti ASC
		";
		$query = $this->db->query($query);

        // vdebug($query->result());
		if ($query->num_rows() > 0){
			return $query->result();
		}else{
			return array();
		}
	}

		function get_detail_kuitansi($no_bukti){
		$query = "SELECT DISTINCT a.kode_usulan_belanja, a.kode_akun_tambah
					FROM rsa_kuitansi_detail as a 
					JOIN rsa_kuitansi as b
						ON a.id_kuitansi = b.id_kuitansi
					JOIN trx_urut_spm_cair as c
						ON b.str_nomor_trx_spm = c.str_nomor_trx_spm
					WHERE b.no_bukti = '{$no_bukti}'
					ORDER BY a.kode_usulan_belanja, a.kode_akun_tambah ASC
		";
		$query = $this->db->query($query);

        // vdebug($query->result());
		if ($query->num_rows() > 0){
			return $query->result();
		}else{
			return array();
		}
	}

}