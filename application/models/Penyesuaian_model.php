<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Penyesuaian_model extends CI_Model {
/* -------------- Constructor ------------- */
  public function __construct()
  {
		 // Call the CI_Model constructor
		 parent::__construct();
  }
	

	function sesuaikan1($data1,$data2){
		
		$this->db->set($data1);
		$this->db->where('tanggal_transaksi >' , '2017-12-31 23:59:59');
		$query1 = $this->db->update('rsa_detail_belanja_');

		$this->db->set($data2);
		$this->db->where('tanggal_impor >' , '2017-12-31 23:59:59');
		$query2 = $this->db->update('rsa_detail_belanja_');
	
		if ($query1 && $query2) {
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	function sesuaikan2($data,$data2,$data3,$data4,$data5){
		
		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query1 = $this->db->update('trx_gup');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query2 = $this->db->update('trx_nomor_gup');

		$this->db->set($data2);
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query3 = $this->db->update('trx_spm_gup_data');

		$this->db->set($data3);
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query4 = $this->db->update('trx_spp_gup_data');
	
		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query5 = $this->db->update('trx_lsk');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query6 = $this->db->update('trx_nomor_lsk');

		$this->db->set($data2);
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query7 = $this->db->update('trx_spm_lsk_data');

		$this->db->set($data3);
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query8 = $this->db->update('trx_spp_lsk_data');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query9 = $this->db->update('trx_lsnk');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query10 = $this->db->update('trx_nomor_lsnk');

		$this->db->set($data2);
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query11 = $this->db->update('trx_spm_lsnk_data');

		$this->db->set($data3);
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query12 = $this->db->update('trx_spp_lsnk_data');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query13 = $this->db->update('trx_tup');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query14 = $this->db->update('trx_nomor_tup');

		$this->db->set($data2);
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query15 = $this->db->update('trx_spm_tup_data');

		$this->db->set($data3);
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query16 = $this->db->update('trx_spp_tup_data');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query17 = $this->db->update('trx_tambah_tup');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query18 = $this->db->update('trx_nomor_tambah_tup');

		$this->db->set($data2);
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query19 = $this->db->update('trx_spm_tambah_tup_data');

		$this->db->set($data3);
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query20 = $this->db->update('trx_spp_tambah_tup_data');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query21 = $this->db->update('trx_tambah_ks');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query22 = $this->db->update('trx_nomor_tambah_ks');

		$this->db->set($data2);
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query23 = $this->db->update('trx_spm_tambah_ks_data');

		$this->db->set($data3);
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query24 = $this->db->update('trx_spp_tambah_ks_data');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query25 = $this->db->update('trx_keluaran');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query26 = $this->db->update('trx_urut_spm_cair');

		$this->db->set($data4);
		$this->db->where('tgl_proses_tambah_tup >' , '2017-12-31 23:59:59');
		$query27 = $this->db->update('trx_tambah_tup_to_nihil');

		$this->db->set($data5);
		$this->db->where('tgl_proses_tambah_ks >' , '2017-12-31 23:59:59');
		$query28 = $this->db->update('trx_tambah_ks_to_nihil');

		$this->db->set($data);
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query29 = $this->db->update('trx_em');


		if ($query1 && $query2 && $query3 && $query4 && $query5 && $query6 && $query7 && $query8 && $query9 && $query10 && $query1 && $query12 && $query13 && $query14 && $query15 && $query16 && $query17 && $query18 && $query19 && $query20 && $query21 && $query22 && $query23 && $query24 && $query25 && $query26 && $query27 && $query28 && $query29) {
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

		function sesuaikan3($data){
		
		$this->db->set($data);
		$this->db->where('tgl_kuitansi >' , '2017-12-31 23:59:59');
		$query = $this->db->update('rsa_kuitansi');

		if ($query) {
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	function get_sesuaikan_trx(){
		$this->db->from('trx_gup');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query1 = $this->db->get();

		$this->db->from('trx_nomor_gup');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query2 = $this->db->get();

		$this->db->from('trx_spm_gup_data');
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query3 = $this->db->get();

		$this->db->from('trx_spp_gup_data');
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query4 = $this->db->get();
	
		$this->db->from('trx_lsk');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query5 = $this->db->get();

		$this->db->from('trx_nomor_lsk');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query6 = $this->db->get();

		$this->db->from('trx_spm_lsk_data');
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query7 = $this->db->get();

		$this->db->from('trx_spp_lsk_data');
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query8 = $this->db->get();

		$this->db->from('trx_lsnk');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query9 = $this->db->get();

		$this->db->from('trx_nomor_lsnk');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query10 = $this->db->get();

		$this->db->from('trx_spm_lsnk_data');
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query11 = $this->db->get();

		$this->db->from('trx_spp_lsnk_data');
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query12 = $this->db->get();

		$this->db->from('trx_tup');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query13 = $this->db->get();

		$this->db->from('trx_nomor_tup');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query14 = $this->db->get();

		$this->db->from('trx_spm_tup_data');
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query15 = $this->db->get();

		$this->db->from('trx_spp_tup_data');
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query16 = $this->db->get();

		$this->db->from('trx_tambah_tup');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query17 = $this->db->get();

		$this->db->from('trx_nomor_tambah_tup');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query18 = $this->db->get();

		$this->db->from('trx_spm_tambah_tup_data');
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query19 = $this->db->get();

		$this->db->from('trx_spp_tambah_tup_data');
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query20 = $this->db->get();

		$this->db->from('trx_tambah_ks');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query21 = $this->db->get();

		$this->db->from('trx_nomor_tambah_ks');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query22 = $this->db->get();

		$this->db->from('trx_spm_tambah_ks_data');
		$this->db->where('tgl_spm >' , '2017-12-31 23:59:59');
		$query23 = $this->db->get();

		$this->db->from('trx_spp_tambah_ks_data');
		$this->db->where('tgl_spp >' , '2017-12-31 23:59:59');
		$query24 = $this->db->get();

		$this->db->from('trx_keluaran');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query25 = $this->db->get();

		$this->db->from('trx_urut_spm_cair');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query26 = $this->db->get();

		$this->db->from('trx_tambah_tup_to_nihil');
		$this->db->where('tgl_proses_tambah_tup >' , '2017-12-31 23:59:59');
		$query27 = $this->db->get();

		$this->db->from('trx_tambah_ks_to_nihil');
		$this->db->where('tgl_proses_tambah_ks >' , '2017-12-31 23:59:59');
		$query28 = $this->db->get();

		$this->db->from('trx_em');
		$this->db->where('tgl_proses >' , '2017-12-31 23:59:59');
		$query29 = $this->db->get();

		$query = $query1->num_rows() + $query2->num_rows() + $query3->num_rows() + $query4->num_rows() + $query5->num_rows() + $query6->num_rows() + $query7->num_rows() + $query8->num_rows() + $query9->num_rows() + $query10->num_rows() + $query11->num_rows() + $query12->num_rows() + $query13->num_rows() + $query14->num_rows() + $query15->num_rows() + $query16->num_rows() + $query17->num_rows() + $query18->num_rows() + $query19->num_rows() + $query20->num_rows() + $query21->num_rows() + $query22->num_rows() + $query23->num_rows() + $query24->num_rows() + $query25->num_rows() + $query26->num_rows() + $query27->num_rows() + $query28->num_rows() + $query29->num_rows();

		// print_r($query5); die;
		return $query;
		

	}

	function get_tidak_sesuaikan(){
		$this->db->from('rsa_detail_belanja_');
		$this->db->where('tanggal_transaksi >' , '2017-12-31 23:59:59');
		$this->db->or_where('tanggal_impor >' , '2017-12-31 23:59:59');
		$query = $this->db->get();

		return $query->num_rows();
	}

		function get_tidak_sesuaikan_kuitansi(){
		$this->db->from('rsa_kuitansi');
		$this->db->where('tgl_kuitansi >' , '2017-12-31 23:59:59');
		$query = $this->db->get();

		return $query->num_rows();
	}

	function data_tidak_sesuai(){
		$this->db->from('rsa_detail_belanja_');
		$this->db->where('tanggal_transaksi >' , '2017-12-31 23:59:59');
		$this->db->or_where('tanggal_impor >' , '2017-12-31 23:59:59');
		$query = $this->db->get();

		return $query->result();
	}

	function data_kuitansi_tidak_sesuai($nomor_trx){
		$query = "SELECT rsa_kuitansi.id_kuitansi, rsa_kuitansi_detail.id_kuitansi_detail, rsa_kuitansi.str_nomor_trx, rsa_kuitansi_detail.kode_usulan_belanja, rsa_kuitansi.tgl_kuitansi, rsa_detail_belanja_.revisi, rsa_detail_belanja_.impor, rsa_detail_belanja_.proses
					FROM rsa_kuitansi
					JOIN rsa_kuitansi_detail
						ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi
					JOIN rsa_detail_belanja_
						ON rsa_kuitansi_detail.kode_usulan_belanja = rsa_detail_belanja_.kode_usulan_belanja
						AND rsa_kuitansi_detail.kode_akun_tambah = rsa_detail_belanja_.kode_akun_tambah
					WHERE rsa_kuitansi.str_nomor_trx = '{$nomor_trx}'";
		$result = $this->db->get($query);

		if ($result->num_rows>0) {
			return $result->result();
		}else{
			return array();
		}
		
	}
}
?>