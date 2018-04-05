<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rsa_sspb_model extends CI_Model {
	/* -------------- Constructor ------------- */

	public function __construct()
	{
		parent::__construct();	
	}
	
	function get_spm_cair($unit){
		$query = "SELECT str_nomor_trx_spm, nominal, jenis_trx
					FROM trx_urut_spm_cair
					WHERE kode_unit_subunit = '{$unit}' AND (jenis_trx = 'GUP' OR jenis_trx = 'TUP-NIHIL' OR jenis_trx = 'LSP' OR jenis_trx = 'EM')
					ORDER BY jenis_trx,no_urut 
					";
		$query = $this->db->query($query);

        // vdebug($query2->result());
		if ($query->num_rows() > 0){
			return $query->result();
		}else{
			return array();
		}
	}

	function get_akun_belanja($jenis="",$spm=""){
			if ($jenis == 'LSP') {
				$query2 ="SELECT detail_belanja
							FROM kepeg_tr_spmls
							WHERE nomor = '{$spm}'
							";
				$query2 = $this->db->query($query2);
				$result2 = $query2->row();

				$pecah = explode(',',$result2->detail_belanja);
				// vdebug($pecah);

				foreach ($pecah as $value) {
					$query = " SELECT a.kode_usulan_belanja, a.kode_akun_tambah, a.volume*a.harga_satuan as nominal, c.jenis_trx as jenis
							FROM rsa_detail_belanja_ as a
							JOIN kepeg_tr_spmls as b
							ON a.kode_usulan_belanja = substr('{$value}',1,24) AND a.kode_akun_tambah = substr('{$value}',25,27)
							JOIN trx_urut_spm_cair as c
							ON c.str_nomor_trx_spm = b.nomor
							WHERE b.nomor = '{$spm}'
							";
					
					$query = $this->db->query($query);
					$result[] = $query->row();
				}
				// $result = (object) $result;
			}else{
				$query ="SELECT a.kode_usulan_belanja, a.kode_akun_tambah , a.volume*a.harga_satuan as nominal, d.jenis_trx as jenis
							FROM rsa_detail_belanja_ as a
							JOIN rsa_kuitansi_detail as b
							ON a.kode_usulan_belanja = b.kode_usulan_belanja AND a.kode_akun_tambah = b.kode_akun_tambah
							JOIN rsa_kuitansi as c
							ON c.id_kuitansi = b.id_kuitansi
							JOIN trx_urut_spm_cair as d
							ON d.str_nomor_trx_spm = c.str_nomor_trx_spm
							WHERE c.str_nomor_trx_spm = '{$spm}'
						 ";
				$query = $this->db->query($query);
				$result = $query->result();
			}

        // vdebug($result);
		if ($query->num_rows() > 0){
			return $result;
		}else{
			return array();
		}
	}

	function get_data_akun($kode="",$jenis=""){
			$query = "SELECT kode_usulan_belanja, kode_akun_tambah , volume*harga_satuan as nominal, deskripsi, sumber_dana
					FROM rsa_detail_belanja_
					WHERE kode_usulan_belanja = substr('{$kode}',1,24) AND kode_akun_tambah = substr('{$kode}',25,27)
					";
		$query = $this->db->query($query);

        // vdebug($query->result());
		if ($query->num_rows() > 0){
			return $query->row();
		}else{
			return array();
		}
	}

	function get_bank(){
		$query = "SELECT DISTINCT kode_akun, nama_akun 
		FROM rba_2018.akun_belanja
		WHERE kode_akun = '111163'";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			$bank = $query->row();
			$opt_bank = array(
				'kode_akun' => $bank->kode_akun,
				'nama_akun' => $bank->nama_akun
			);
			return $opt_bank;
		}else{
			return array();
		}
	}

	function get_bendahara($unit){
		$query = "SELECT nm_lengkap, nomor_induk
		FROM rsa_user
		WHERE kode_unit_subunit = '{$unit}' AND level = '13'
		";
		$query = $this->db->query($query); 
		if ($query->num_rows() > 0){
			return $query->row(); 
		}else{
			return 0;
		}
	}

	function get_verifikator($unit){

		$unit = substr($unit,0,2);
		
		$query = "SELECT nm_lengkap, nomor_induk
		FROM rsa_user as a
		JOIN rsa_verifikator_unit as b
		ON a.id = b.id_user_verifikator
		WHERE b.kode_unit_subunit = '{$unit}' AND a.level = '3'
		";
		$query = $this->db->query($query); 
		if ($query->num_rows() > 0){
			return $query->row(); 
		}else{
			return 0;
		}
	}

	function get_kpa($unit){
		$query = "SELECT nm_lengkap, nomor_induk
		FROM rsa_user
		WHERE kode_unit_subunit = '{$unit}' AND level = '2'
		";
		$query = $this->db->query($query); 
		if ($query->num_rows() > 0){
			return $query->row(); 
		}else{
			return 0;
		}
	}

	function get_ppksukpa($unit){
		$query = "SELECT nm_lengkap, nomor_induk
		FROM rsa_user
		WHERE kode_unit_subunit = '{$unit}' AND level = '14'
		";
		$query = $this->db->query($query); 
		if ($query->num_rows() > 0){
			return $query->row(); 
		}else{
			return 0;
		}
	}

	function get_kuasabuu(){
		$query = "SELECT nm_lengkap, nomor_induk
		FROM rsa_user
		WHERE level = '11'
		";
		$query = $this->db->query($query); 
		if ($query->num_rows() > 0){
			return $query->row(); 
		}else{
			return 0;
		}
	}

	function get_buu(){
		$query = "SELECT nm_lengkap, nomor_induk
		FROM rsa_user
		WHERE level = '5'
		";
		$query = $this->db->query($query); 
		if ($query->num_rows() > 0){
			return $query->row(); 
		}else{
			return 0;
		}
	}

	

	function get_alias($unit){
		$query = "SELECT alias 
		FROM rba_2018.unit as a
		WHERE a.kode_unit = {$unit}";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->row()->alias;
		}else{
			return 0;
		}
	}

	function get_new_nomor($unit){
		$query = "SELECT SUBSTR(nomor_sspb,1,4) as no_urut 
		FROM trx_sspb_data
		WHERE SUBSTR(nomor_sspb,6,3) = '{$unit}'
		ORDER by SUBSTR(nomor_sspb,1,4) DESC limit 1";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->row()->no_urut;
		}else{
			return 0;
		}
	}

	function add_sspb($data){
		$insert = $this->db->insert('trx_sspb_data', $data);
		if ($insert) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function add_trx_sspb($data){
		$insert = $this->db->insert('trx_sspb', $data);
		if ($insert) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function get_data_sspb($sspb){
		$query = "SELECT a.* , b.nama_unit,c.nama_subunit,d.kode_akun4digit,d.nama_akun4digit
		FROM trx_sspb_data as a
		LEFT JOIN rba_2018.unit as b
		ON b.kode_unit = substr(a.kode_unit_subunit,1,2)
		LEFT JOIN rba_2018.subunit as c
		ON c.kode_subunit = a.kode_unit_subunit
		LEFT JOIN rba_2018.akun_belanja as d
		ON d.kode_akun = substr(a.kode_usulan_belanja,19,6)
		WHERE nomor_sspb = '{$sspb}'
		";
		$query = $this->db->query($query);
		// vdebug($query->row());
		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return 0;
		}
	}

	function daftar_sspb($unit){
		
			$query = "SELECT a.*, b.posisi
			FROM trx_sspb_data as a
			LEFT JOIN trx_sspb as b
			ON a.nomor_sspb = b.nomor_sspb
			WHERE a.kode_unit_subunit = {$unit} AND b.aktif = 1
			ORDER BY a.nomor_sspb
			";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return array();
		}
	}

	function total_sspb($unit){
			$query = "SELECT a.jumlah_bayar as total
			FROM trx_sspb_data as a
			LEFT JOIN trx_sspb as b
			ON a.nomor_sspb = b.nomor_sspb
			WHERE a.kode_unit_subunit = {$unit} AND b.posisi = 'SSPB-FINAL-KBUU' AND b.aktif = 1
			GROUP BY a.kode_unit_subunit
			";

		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->row()->total;
		}else{
			return 0;
		}
	}

	function get_status($nomor){
		$query = "SELECT posisi, ket 
		FROM trx_sspb
		WHERE nomor_sspb = '{$nomor}' AND aktif = 1
		";
		$query = $this->db->query($query);
		// vdebug($query->row());
		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return 0;
		}
	}

	function set_aktif($nomor){
		$query ="UPDATE trx_sspb 
			SET aktif='0' 
			WHERE nomor_sspb = '{$nomor}' "
			;
		$update = $this->db->query($query);   
		if ($update) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function set_tanggal($data,$nomor){
		$this->db->where('nomor_sspb', $nomor);
        $query = $this->db->update('trx_sspb_data', $data);
        return ($query) ? true : false;
	}

	function get_unit($nomor){
		$query = "SELECT kode_unit_subunit 
		FROM trx_sspb_data
		WHERE nomor_sspb = '{$nomor}'
		";
		$query = $this->db->query($query);
		// vdebug($query->row());
		if ($query->num_rows() > 0) {
			return $query->row()->kode_unit_subunit;
		}else{
			return 0;
		}
	}

	function daftar_unit_verifikator($username){
		$query = "SELECT d.kode_subunit as kode_unit , d.nama_subunit as nama_unit,
				(SELECT COUNT(aktif)
			FROM trx_sspb 
			WHERE kode_unit_subunit = d.kode_subunit AND posisi = 'SSPB-DRAFT-KPA' AND aktif = 1) AS jumlah
		FROM rba_2018.unit as a
		JOIN rba_2018.subunit as d
		ON substr(d.kode_subunit,1,2) = a.kode_unit
		JOIN rsa_verifikator_unit as b
		ON b.kode_unit_subunit = a.kode_unit
		JOIN rsa_user as c
		ON b.id_user_verifikator = c.id
		WHERE c.username = '{$username}' AND (a.kode_unit = '14' OR a.kode_unit = '15' OR a.kode_unit = '16' OR a.kode_unit = '17')
		UNION
		SELECT a.kode_unit , a.nama_unit, 
			(SELECT COUNT(aktif)
			FROM trx_sspb  
			WHERE kode_unit_subunit = a.kode_unit AND posisi = 'SSPB-DRAFT-KPA' AND aktif = 1) AS jumlah
		FROM rba_2018.unit as a
		JOIN rsa_verifikator_unit as b
		ON b.kode_unit_subunit = a.kode_unit
		JOIN rsa_user as c
		ON b.id_user_verifikator = c.id
		WHERE c.username = '{$username}'
		ORDER BY kode_unit
		";
		$query = $this->db->query($query);
		// vdebug($query->result());
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return array();
		}
	}

	function daftar_unit_kbuu(){
		$query = "SELECT d.kode_subunit as kode_unit , d.nama_subunit as nama_unit, 
			(SELECT COUNT(aktif)
			FROM trx_sspb 
			WHERE kode_unit_subunit = d.kode_subunit AND posisi = 'SSPB-FINAL-VERIFIKATOR' AND aktif = 1) AS jumlah
		FROM rba_2018.unit as a
		JOIN rba_2018.subunit as d
		ON substr(d.kode_subunit,1,2) = a.kode_unit
		WHERE  a.kode_unit = '14' OR a.kode_unit = '15' OR a.kode_unit = '16' OR a.kode_unit = '17'
		UNION
		SELECT a.kode_unit , a.nama_unit, 
			(SELECT COUNT(aktif)
			FROM trx_sspb  
			WHERE kode_unit_subunit = a.kode_unit AND posisi = 'SSPB-FINAL-VERIFIKATOR' AND aktif = 1) AS jumlah
		FROM rba_2018.unit as a
		ORDER BY kode_unit
		";
		$query = $this->db->query($query);
		// vdebug($query->result());
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return array();
		}
	}

	function get_notif($level="",$username="",$unit=""){
		if ($level == 11) {
		$query = "SELECT COUNT(aktif) as jumlah
			FROM trx_sspb 
			WHERE posisi = 'SSPB-FINAL-VERIFIKATOR' AND aktif = 1";
		} elseif($level == 3){
			$query = "SELECT COUNT(aktif) as jumlah
				FROM trx_sspb as a
				JOIN rsa_verifikator_unit as b
				ON substr(b.kode_unit_subunit,1,2) = a.kode_unit_subunit
				JOIN rsa_user as c
				ON b.id_user_verifikator = c.id
				WHERE c.username = '{$username}' AND posisi = 'SSPB-DRAFT-KPA' AND aktif = 1";
		}elseif($level == 2){
			$query = "SELECT COUNT(aktif) as jumlah
				FROM trx_sspb 
				WHERE kode_unit_subunit = '{$unit}' AND posisi = 'SSPB-DRAFT-PPK' AND aktif = 1";
		}elseif($level == 14){
			$query = "SELECT COUNT(aktif) as jumlah
				FROM trx_sspb 
				WHERE kode_unit_subunit = '{$unit}' AND posisi = 'SSPB-DRAFT' AND aktif = 1";
		}
		$query = $this->db->query($query);
		// vdebug($query->result());
		if ($query->num_rows() > 0) {
			return $query->row()->jumlah;
		}else{
			return 0;
		}

	}

}