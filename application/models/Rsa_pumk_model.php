<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rsa_pumk_model extends CI_Model {
	/* -------------- Constructor ------------- */

	public function __construct()
	{
		parent::__construct();	
	}
	
	function add_uang_pumk($data){

		$insert = $this->db->insert('trx_rsa_pumk', $data);
		if ($insert) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function get_option_pumk($unit){
		if (strlen($unit) == 2) {
			$query = "SELECT id,username,kode_unit_subunit
			FROM rsa_user
			WHERE substr(kode_unit_subunit,1,2) = substr('{$unit}',1,2) AND level = '4'
			ORDER BY kode_unit_subunit ASC";
		}elseif(strlen($unit) == 4){
			$query = "SELECT id,username,kode_unit_subunit
			FROM rsa_user
			WHERE substr(kode_unit_subunit,1,4) = substr('{$unit}',1,4) AND level = '4'
			ORDER BY kode_unit_subunit ASC";
		}elseif(strlen($unit) == 6){
			$query = "SELECT id,username,kode_unit_subunit
			FROM rsa_user
			WHERE substr(kode_unit_subunit,1,6) = substr('{$unit}',1,6) AND level = '4'
			ORDER BY kode_unit_subunit ASC";
		}
		
		$query2 = $this->db->query($query);
		if ($query2->num_rows() > 0){
			$username = $query2->result();
			foreach($username as $row){
				$opt_username["$row->username"] = array(
					'id' => $row->id,
					'username' => $row->username
				);
			}

			return $opt_username;
                // vdebug($opt_username);
		}else{
			return array();
		}
	}

	function get_pumk($username){
		$query = "SELECT nm_lengkap, nomor_induk
		FROM rsa_user
		WHERE username = '{$username}'";
		$query2 = $this->db->query($query);

        // vdebug($query2->result());
		if ($query2->num_rows() > 0){
			return $query2->row();
		}else{
			return null;
		}
	}

	function get_daftar_pumk($unit){
		$cek = $this->check_session->get_unit();
		if(strlen($cek) == 2){
			$query = "SELECT *
			FROM trx_rsa_pumk
			WHERE substr(kode_unit_subunit,1,2) = '{$unit}'
			";
		}elseif(strlen($cek) == 4 ){
			$query = "SELECT *
			FROM trx_rsa_pumk
			WHERE substr(kode_unit_subunit,1,4) = '{$unit}'
			";
		}else{
			$query = "SELECT *
			FROM trx_rsa_pumk
			WHERE substr(kode_unit_subunit,1,6) = '{$unit}'
			";
		}
		
		
		$query2 = $this->db->query($query);
		if ($query2->num_rows() > 0){
			return $query2->result();
		}else{
			return array();
		}
	}

	function get_daftar_pumk_kembali($unit){
		$cek = $this->check_session->get_unit();
    	// vdebug($cek);
		if(strlen($cek) == 2){
			$query = "SELECT *
			FROM trx_rsa_pumk_kembali
			WHERE substr(kode_unit_subunit,1,2) = '{$unit}'
			";
		}elseif(strlen($cek) == 4 ){
			$query = "SELECT *
			FROM trx_rsa_pumk_kembali
			WHERE substr(kode_unit_subunit,1,4) = '{$unit}'
			";
		}else{
			$query = "SELECT *
			FROM trx_rsa_pumk_kembali
			WHERE substr(kode_unit_subunit,1,6) = '{$unit}'
			";
		}
		
		$query2 = $this->db->query($query);
		if ($query2->num_rows() > 0){
			return $query2->result();
		}else{
			return array();
		}
	}

	function get_cetak_pumk($nomor_trx_rsa_pumk){
		$rba = $this->load->database('rba', TRUE);

		$query1 = "SELECT b.kode_unit_subunit, a.username
		FROM trx_rsa_pumk as a
		LEFT JOIN rsa_user as b
		ON a.username = b.username
		WHERE a.nomor_trx_rsa_pumk = '{$nomor_trx_rsa_pumk}'
		";
		$query1 = $this->db->query($query1); 
		$username = $query1->row()->username;

		if($username == 'personal'){
			$unit = $this->check_session->get_ori_unit();
		}else {
			$unit = $query1->row()->kode_unit_subunit; 
		}

		if (strlen($unit) == 2) {
			$query = "SELECT a.username, a.nomor_trx_rsa_pumk, a.nama_pumk, a.nomor_induk, a.tanggal_proses, a.jumlah_dana, a.keperluan,c.kode_unit as kode_unit_subunit,c.nama_unit,c.nama_unit as nama_subunit, c.kode_unit 
			FROM trx_rsa_pumk as a
			JOIN rba_2018.unit as c
			ON '{$unit}' = c.kode_unit
			WHERE a.nomor_trx_rsa_pumk = '{$nomor_trx_rsa_pumk}'
			";
		} elseif(strlen($unit) == 4){
			$query = "SELECT a.username,a.nomor_trx_rsa_pumk,a.nama_pumk,a.nomor_induk,a.tanggal_proses,a.jumlah_dana,a.keperluan,c.kode_subunit as kode_unit_subunit,c.nama_subunit,d.nama_unit, d.kode_unit
			FROM trx_rsa_pumk as a
			JOIN rba_2018.subunit as c
			ON '{$unit}' = c.kode_subunit
			JOIN rba_2018.unit as d
			ON substr('{$unit}',1,2) = d.kode_unit
			WHERE a.nomor_trx_rsa_pumk = '{$nomor_trx_rsa_pumk}'
			";
		} elseif(strlen($unit) == 6){
			$query = "SELECT a.username,a.nomor_trx_rsa_pumk, a.nama_pumk, a.nomor_induk, a.tanggal_proses, a.jumlah_dana, a.keperluan, c.kode_sub_subunit as kode_unit_subunit, c.nama_sub_subunit as nama_subunit,d.nama_unit,d.kode_unit
			FROM trx_rsa_pumk as a
			JOIN rba_2018.sub_subunit as c
			ON '{$unit}' = c.kode_sub_subunit
			JOIN rba_2018.unit as d
			ON substr('{$unit}',1,2) = d.kode_unit
			WHERE a.nomor_trx_rsa_pumk = '{$nomor_trx_rsa_pumk}'
			";
		}

		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0){
			return $query->row(); 
		}else{
			return 0;
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

	function is_nomor_pumk($nomor='') {
		$this->db->select('nomor_trx_rsa_pumk');
		$this->db->where('nomor_trx_rsa_pumk', $nomor);
		$query = $this->db->get('trx_rsa_pumk');

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function is_nomor_pumk2($nomor='') {
		$this->db->select('nomor_trx_rsa_pumk_kembali');
		$this->db->where('nomor_trx_rsa_pumk_kembali', $nomor);
		$query = $this->db->get('trx_rsa_pumk_kembali');

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}


	function get_new_nomor($unit){
		$query = "SELECT SUBSTR(nomor_trx_rsa_pumk,1,4) as no_urut 
		FROM trx_rsa_pumk 
		WHERE SUBSTR(nomor_trx_rsa_pumk,6,3) = '{$unit}'
		ORDER by SUBSTR(nomor_trx_rsa_pumk,1,4) DESC limit 1";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->row()->no_urut;
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

	function get_daftar_spj_pumk($unit){

		$level = $this->check_session->get_level();
		

		if($level == 13){
			$query2 = "SELECT a.id_kuitansi,a.kode_unit,a.kode_usulan_belanja,a.no_bukti,a.tgl_kuitansi,a.uraian,a.nmpumk,a.nippumk,d.proses, SUM(b.volume*b.harga_satuan) AS pengeluaran
			FROM rsa_kuitansi as a
			JOIN trx_urut_spm_cair as f 
			ON f.str_nomor_trx_spm = a.str_nomor_trx_spm
			LEFT JOIN rsa_kuitansi_detail as b
			ON a.id_kuitansi = b.id_kuitansi
			LEFT JOIN rsa_spj_pumk_detail as c
			ON c.id_kuitansi = a.id_kuitansi
			LEFT JOIN rsa_spj_pumk as d
			ON d.id = c.id_spj
			
			WHERE a.kode_unit = '{$unit}' 
			GROUP BY b.no_bukti desc";

		}elseif($level == 4){
			$query ="SELECT nomor_induk
			FROM rsa_user
			WHERE kode_unit_subunit = {$unit} AND level = '4'
			";
			$query = $this->db->query($query);
			$nomor = $query->row()->nomor_induk;

			$query2 = "SELECT a.id_kuitansi,a.kode_unit,a.kode_usulan_belanja,b.no_bukti,a.tgl_kuitansi,a.uraian,a.nmpumk,a.nippumk,d.proses, SUM(b.volume*b.harga_satuan) AS pengeluaran
			FROM rsa_kuitansi as a
			JOIN trx_urut_spm_cair as f 
			ON f.str_nomor_trx_spm = a.str_nomor_trx_spm
			JOIN rsa_kuitansi_detail as b
			ON a.id_kuitansi = b.id_kuitansi
			LEFT JOIN rsa_spj_pumk_detail as c
			ON c.id_kuitansi = a.id_kuitansi
			LEFT JOIN rsa_spj_pumk as d
			ON d.id = c.id_spj
			
			WHERE a.kode_unit = '{$unit}' AND a.nippumk = '{$nomor}'
			GROUP BY b.no_bukti desc
			";
		}

		
		
		$query2 = $this->db->query($query2);
        // vdebug($query2);
		if ($query2->num_rows() > 0){
			return $query2->result();
		}else{
			return array();
		}
	}

	function add_spj_pumk($data){

		$insert = $this->db->insert('rsa_spj_pumk', $data);
		if ($insert) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function get_id_spj($kuitansi){
		$query = "SELECT id as id_spj
		FROM rsa_spj_pumk 
		WHERE kuitansi = '{$kuitansi}'
		";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->row()->id_spj;
		}else{
			return 0;
		}  
	}

	function add_spj_pumk_detail($data,$id_spj){
		$data = explode(',', $data);
        // vdebug($data);
		foreach ($data as $key => $value) {
			$query ="INSERT INTO rsa_spj_pumk_detail (id_kuitansi, id_spj)
			VALUES ('$value','$id_spj')";
			
			$insert = $this->db->query($query);
		}    
		if ($insert) {
			return TRUE;
		}else{
			return FALSE;
		}
		
	}

	function get_daftar_sudah_spj($unit){
		
		if(strlen($unit) == 2){
			$query2 = "SELECT id,kuitansi,kode_unit, tgl_spj,nm_pumk,nip_pumk,proses
			FROM rsa_spj_pumk
			WHERE  substr(kode_unit,1,2) = '{$unit}' 
			GROUP BY id
			";
		}elseif(strlen($unit) == 4){
			$query2 = "SELECT id,kuitansi,kode_unit, tgl_spj,nm_pumk,nip_pumk,proses
			FROM rsa_spj_pumk
			WHERE  substr(kode_unit,1,4) = '{$unit}' 
			GROUP BY id
			";
		}
		
		
		$query2 = $this->db->query($query2);
        // vdebug($query2->result());
		if ($query2->num_rows() > 0){
			return $query2->result();
		}else{
			return array();
		}
	}

	function terima_spj($data){
		$data = explode(',', $data);
        // vdebug($data);
		foreach ($data as $key => $value) {
			$query ="UPDATE rsa_spj_pumk 
			SET proses='2' 
			WHERE id=$value"
			;
			
			$update = $this->db->query($query);
		}    
		if ($update) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function tolak_spj($data){
		$data = explode(',', $data);
        // vdebug($data);
		foreach ($data as $key => $value) {
			$query ="DELETE FROM rsa_spj_pumk 
			WHERE id = $value"
			;
			$query2 ="DELETE FROM rsa_spj_pumk_detail 
			WHERE id_spj = $value"
			;
			
			$update = $this->db->query($query);
			$update2 = $this->db->query($query2);
		}    
		if ($update && $update2) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function get_nama_unit($unit){

		$rba = $this->load->database('rba', TRUE);

		if (strlen($unit) == 2) {
			$query = "SELECT c.nama_unit
			FROM rba_2018.unit as c
			WHERE '{$unit}' = c.kode_unit
			";
		} elseif(strlen($unit) == 4){
			$query = "SELECT c.nama_subunit as nama_unit
			FROM rba_2018.subunit as c
			WHERE '{$unit}' = c.kode_subunit
			";
		} elseif(strlen($unit) == 6){
			$query = "SELECT c.nama_sub_subunit as nama_unit
			FROM rba_2018.sub_subunit as c
			WHERE '{$unit}' = c.kode_sub_subunit
			";
		}

		$query = $this->db->query($query);

		if ($query->num_rows() > 0){
			return $query->row()->nama_unit; 
		}else{
			return false;
		}
	}

	function get_jenis($id_kuitansi){

		$query = "SELECT jenis
		FROM rsa_kuitansi
		WHERE '{$id_kuitansi}' = id_kuitansi
		";
		$query = $this->db->query($query);

		if ($query->num_rows() > 0){
			return $query->row()->jenis; 
		}else{
			return false;
		}
	}

	function daftar_kuitansi_spj($id,$unit){

		$query2 = "SELECT a.id_kuitansi,a.kode_unit,a.kode_usulan_belanja,a.no_bukti,a.tgl_kuitansi,a.uraian,a.nmpumk,a.nippumk,d.id,d.proses, (SUM(b.volume*b.harga_satuan) - coalesce(e.rupiah_pajak, 0 )) AS pengeluaran
		FROM rsa_kuitansi as a
		JOIN rsa_kuitansi_detail as b
		ON a.id_kuitansi = b.id_kuitansi
		LEFT JOIN rsa_spj_pumk_detail as c
		ON c.id_kuitansi = a.id_kuitansi
		LEFT JOIN rsa_spj_pumk as d
		ON d.id = c.id_spj
		LEFT JOIN rsa_kuitansi_detail_pajak as e 
		ON b.id_kuitansi_detail = e.id_kuitansi_detail
		WHERE substr(a.kode_unit,1,4) = '{$unit}' AND d.id = '{$id}' 
		GROUP BY a.id_kuitansi
		";
		
		$query2 = $this->db->query($query2);
        // vdebug($query2->result());
		if ($query2->num_rows() > 0){
			return $query2->result();
		}else{
			return array();
		}
	}

	function kembali_uang_pumk($data){

		$insert = $this->db->insert('trx_rsa_pumk_kembali', $data);
		if ($insert) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function get_new_nomor2($unit){
		$query = "SELECT SUBSTR(nomor_trx_rsa_pumk_kembali,1,4) as no_urut 
		FROM trx_rsa_pumk_kembali 
		WHERE SUBSTR(nomor_trx_rsa_pumk_kembali,6,3) = '{$unit}'
		ORDER by SUBSTR(nomor_trx_rsa_pumk_kembali,1,4) DESC limit 1";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->row()->no_urut;
		}else{
			return 0;
		}
	}

	function get_unit($username){
		$query = "SELECT kode_unit_subunit
		FROM rsa_user
		WHERE username = '{$username}' AND level = '4'";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->row()->kode_unit_subunit;
		}else{
			return 0;
		}
	}

	function get_username ($unit){
		$query = "SELECT username 
		FROM rsa_user
		WHERE kode_unit_subunit = '{$unit}' AND level = '4'";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->row()->username;
		}else{
			return 0;
		}
	}


	function get_nip_pumk ($unit){
		$query = "SELECT nomor_induk 
		FROM rsa_user
		WHERE kode_unit_subunit = '{$unit}' AND level = '4'";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->row()->nomor_induk;
		}else{
			return 0;
		}
	}

	function get_nama_pumk ($unit){
		$query = "SELECT nm_lengkap 
		FROM rsa_user
		WHERE kode_unit_subunit = '{$unit}' AND level = '4'";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			return $query->row()->nm_lengkap;
		}else{
			return 0;
		}
	}

	function get_cetak_pumk_kembali($nomor_trx_rsa_pumk_kembali){
		$rba = $this->load->database('rba', TRUE);
		$level = $this->check_session->get_level();
		

		$query1 = "SELECT b.kode_unit_subunit, a.username
		FROM trx_rsa_pumk_kembali as a
		LEFT JOIN rsa_user as b
		ON a.username = b.username
		WHERE a.nomor_trx_rsa_pumk_kembali = '{$nomor_trx_rsa_pumk_kembali}'
		";
		$query1 = $this->db->query($query1); 
		
		if($level == 13){
			$unit = $this->check_session->get_unit(); 
			$username = 'personal';
		}else{
			$username = $query1->row()->username;
			$unit = $query1->row()->kode_unit_subunit;
		}
		
        // vdebug($unit); 


		if (strlen($unit) == 2) {
			$query = "SELECT a.username, a.nomor_trx_rsa_pumk_kembali, a.nama_pumk, a.nomor_induk, a.tanggal_proses, a.jumlah_dana, a.keterangan,c.kode_unit as kode_unit_subunit,c.nama_unit,c.nama_unit as nama_subunit, c.kode_unit 
			FROM trx_rsa_pumk_kembali as a
			JOIN rba_2018.unit as c
			ON '{$unit}' = c.kode_unit
			WHERE a.nomor_trx_rsa_pumk_kembali = '{$nomor_trx_rsa_pumk_kembali}'
			";
		} elseif(strlen($unit) == 4){
			$query = "SELECT a.username,a.nomor_trx_rsa_pumk_kembali,a.nama_pumk,a.nomor_induk,a.tanggal_proses,a.jumlah_dana,a.keterangan,c.kode_subunit as kode_unit_subunit,c.nama_subunit,d.nama_unit, d.kode_unit
			FROM trx_rsa_pumk_kembali as a
			JOIN rba_2018.subunit as c
			ON '{$unit}' = c.kode_subunit
			JOIN rba_2018.unit as d
			ON substr('{$unit}',1,2) = d.kode_unit
			WHERE a.nomor_trx_rsa_pumk_kembali = '{$nomor_trx_rsa_pumk_kembali}'
			";
		} elseif(strlen($unit) == 6){
			$query = "SELECT a.username,a.nomor_trx_rsa_pumk_kembali, a.nama_pumk, a.nomor_induk, a.tanggal_proses, a.jumlah_dana, a.keterangan, c.kode_sub_subunit as kode_unit_subunit, c.nama_sub_subunit as nama_subunit,d.nama_unit,d.kode_unit
			FROM trx_rsa_pumk_kembali as a
			JOIN rba_2018.sub_subunit as c
			ON '{$unit}' = c.kode_sub_subunit
			JOIN rba_2018.unit as d
			ON substr('{$unit}',1,2) = d.kode_unit
			WHERE a.nomor_trx_rsa_pumk_kembali = '{$nomor_trx_rsa_pumk_kembali}'
			";
		}

		$query = $this->db->query($query);

		if ($query->num_rows() > 0){
			return $query->row(); 
		}else{
			return false;
		}
	}

	function get_jumlah_uang_pumk($unit,$nip=""){
		$level = $this->check_session->get_level();  
		// vdebug($level);  	
		$nip = $nip;
		
		if($level == 13){
			if($nip !=""){
				$username = 'personal';
				$query2 = "SELECT SUM(a.jumlah_dana)  
				- coalesce((SELECT SUM(trx_rsa_pumk_kembali.jumlah_dana)
								FROM trx_rsa_pumk_kembali
								WHERE trx_rsa_pumk_kembali.username ='{$username}' ),0) 
				- coalesce((SELECT (SUM(e.volume*e.harga_satuan))
								FROM rsa_spj_pumk as c
								LEFT JOIN rsa_spj_pumk_detail as d 
									ON c.id = d.id_spj
								LEFT JOIN rsa_kuitansi_detail as e
									ON d.id_kuitansi = e.id_kuitansi
								LEFT JOIN rsa_kuitansi as f
									ON f.id_kuitansi = e.id_kuitansi
								WHERE c.kode_unit = '{$unit}'
								GROUP BY c.kode_unit) ,0)
				- coalesce((SELECT (SUM(rupiah_pajak)) as hasil
								FROM rsa_spj_pumk as c
								LEFT JOIN rsa_spj_pumk_detail as d 
									ON c.id = d.id_spj
								LEFT JOIN rsa_kuitansi_detail as e
									ON d.id_kuitansi = e.id_kuitansi
								LEFT JOIN rsa_kuitansi as f
									ON f.id_kuitansi = e.id_kuitansi
								LEFT JOIN rsa_kuitansi_detail_pajak as g 
									ON e.id_kuitansi_detail = g.id_kuitansi_detail
								WHERE c.kode_unit = '{$unit}'
								GROUP BY c.kode_unit),0)
				as hasil
				FROM trx_rsa_pumk as a
				WHERE a.username = '{$username} ' AND a.kode_unit_subunit = '{$unit}' AND a.nomor_induk = '{$nip}'
				";
			}else{
				$username = 'personal';
				$query2 = "SELECT SUM(a.jumlah_dana)  
				- coalesce((SELECT SUM(trx_rsa_pumk_kembali.jumlah_dana)
								FROM trx_rsa_pumk_kembali
								WHERE trx_rsa_pumk_kembali.username ='{$username}' ),0) 
				- coalesce((SELECT (SUM(e.volume*e.harga_satuan))
								FROM rsa_spj_pumk as c
								LEFT JOIN rsa_spj_pumk_detail as d 
									ON c.id = d.id_spj
								LEFT JOIN rsa_kuitansi_detail as e
									ON d.id_kuitansi = e.id_kuitansi
								LEFT JOIN rsa_kuitansi as f
									ON f.id_kuitansi = e.id_kuitansi
								WHERE c.kode_unit = '{$unit}'
								GROUP BY c.kode_unit) ,0)
				- coalesce((SELECT (SUM(rupiah_pajak)) as hasil
								FROM rsa_spj_pumk as c
								LEFT JOIN rsa_spj_pumk_detail as d 
									ON c.id = d.id_spj
								LEFT JOIN rsa_kuitansi_detail as e
									ON d.id_kuitansi = e.id_kuitansi
								LEFT JOIN rsa_kuitansi as f
									ON f.id_kuitansi = e.id_kuitansi
								LEFT JOIN rsa_kuitansi_detail_pajak as g 
									ON e.id_kuitansi_detail = g.id_kuitansi_detail
								WHERE c.kode_unit = '{$unit}'
								GROUP BY c.kode_unit),0)
				as hasil
				FROM trx_rsa_pumk as a
				WHERE a.username = '{$username} ' && a.kode_unit_subunit = '{$unit}'
				";
			}
		}elseif($level == 4){
			$query ="SELECT username, nomor_induk
			FROM rsa_user
			WHERE kode_unit_subunit = {$unit} AND level = '{$level}' 
			";
			$query = $this->db->query($query);
			$username = $query->row()->username;
			$nip = $query->row()->nomor_induk; 

			$query2 = "SELECT SUM(a.jumlah_dana)  
			- coalesce((SELECT SUM(trx_rsa_pumk_kembali.jumlah_dana)
			FROM trx_rsa_pumk_kembali
			WHERE trx_rsa_pumk_kembali.username ='{$username}' AND trx_rsa_pumk_kembali.nomor_induk = '{$nip}'),0) 
			- coalesce((SELECT (SUM(e.volume*e.harga_satuan))
			FROM rsa_spj_pumk as c
			LEFT JOIN rsa_spj_pumk_detail as d 
			ON c.id = d.id_spj
			LEFT JOIN rsa_kuitansi_detail as e
			ON d.id_kuitansi = e.id_kuitansi
			LEFT JOIN rsa_kuitansi as f
			ON f.id_kuitansi = e.id_kuitansi
			WHERE c.kode_unit = '{$unit}'
			GROUP BY c.kode_unit) ,0)
			- coalesce((SELECT (SUM(rupiah_pajak)) as hasil
			FROM rsa_spj_pumk as c
			LEFT JOIN rsa_spj_pumk_detail as d 
			ON c.id = d.id_spj
			LEFT JOIN rsa_kuitansi_detail as e
			ON d.id_kuitansi = e.id_kuitansi
			LEFT JOIN rsa_kuitansi as f
			ON f.id_kuitansi = e.id_kuitansi
			LEFT JOIN rsa_kuitansi_detail_pajak as g 
			ON e.id_kuitansi_detail = g.id_kuitansi_detail
			WHERE c.kode_unit = '{$unit}'
			GROUP BY c.kode_unit),0)
			as hasil
			FROM trx_rsa_pumk as a
			WHERE a.username = '{$username} '  AND a.nomor_induk = '{$nip}'
			";
		}

		
		$query2 = $this->db->query($query2);
		if ($query2->num_rows() > 0){
			return $query2->row()->hasil;
		}else{
			return 0;
		}
	}


	function get_jumlah_uang($unit){
   	// vdebug($unit);
		if (strlen($unit) == 2) {
			$query1 = "SELECT SUM(jumlah_dana) 
			- coalesce((SELECT SUM(jumlah_dana) 
				FROM trx_rsa_pumk_kembali
				WHERE substr(kode_unit_subunit,1,2) = '{$unit}'
				GROUP BY substr(kode_unit_subunit,1,2)),0)
				as hasil1
			FROM trx_rsa_pumk
			WHERE substr(kode_unit_subunit,1,2) = '{$unit}'
			GROUP BY substr(kode_unit_subunit,1,2)";
		}elseif(strlen($unit) == 4){
			$query1 = "SELECT SUM(jumlah_dana) 
			- coalesce((SELECT SUM(jumlah_dana)
			FROM trx_rsa_pumk_kembali
			WHERE substr(kode_unit_subunit,1,4) = '{$unit}'
			GROUP BY substr(kode_unit_subunit,1,4)),0)
			as hasil1
			FROM trx_rsa_pumk
			WHERE substr(kode_unit_subunit,1,4) = '{$unit}'
			GROUP BY substr(kode_unit_subunit,1,4)";
		}
		$query1 = $this->db->query($query1);
		if ($query1->num_rows() > 0 ){
			return $query1->row()->hasil1;
		}else{
			return 0;
		}
	}

	function print(){
		$rba = $this->load->database('rba', TRUE);
		$query = "SELECT * 
				FROM unit as a 
				join subunit as b 
					ON a.kode_unit = substr(b.kode_subunit,1,2) 
				join sub_subunit as c 
					ON b.kode_subunit = substr(c.kode_sub_subunit,1,4)";
		$query = $rba->query($query);
		if ($query->num_rows() > 0 ){
			return $query->result();
		}else{
			return 0;
		}
	}

}