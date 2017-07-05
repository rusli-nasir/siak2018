<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengembalian_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	public function insert_pengembalian($id_kuitansi_jadi)
    {
    	$kuitansi = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' => $id_kuitansi_jadi))->row_array();
    	$kuitansi['tipe'] = 'pengembalian';

		$kuitansi['akun_debet'] = 0;
		$kuitansi['akun_debet_akrual'] = 0;
		$kuitansi['jumlah_debet'] = 0;
		$kuitansi['akun_kredit'] = 0;
		$kuitansi['akun_kredit_akrual'] = 0;
		$kuitansi['jumlah_kredit'] = 0;
        $kuitansi['uraian'] = "Pengembalian " . $kuitansi['uraian'];


		$id_kuitansi_awal = $kuitansi['id_kuitansi_jadi'];


		unset($kuitansi['id_kuitansi_jadi']);
		unset($kuitansi['id_pengembalian']);

		$this->db->insert('akuntansi_kuitansi_jadi',$kuitansi);
        $id_kuitansi_pengembalian = $this->db->insert_id();
		
        $this->db->where(array('id_kuitansi_jadi'=>$id_kuitansi_jadi));
		$query = $this->db->update('akuntansi_kuitansi_jadi', array('id_pengembalian'=>$id_kuitansi_pengembalian));

    	return $id_kuitansi_pengembalian;
    }
}