<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pajak_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
    }


    public function get_tabel_by_jenis($jenis)
    {
    	if ($jenis == 'GP') {
    		return 'rsa_kuitansi_detail_pajak';
    	}elseif ($jenis == 'L3') {
    		return 'rsa_kuitansi_detail_pajak_lsphk3';
    	}
    }

    public function get_detail_pajak($no_bukti,$jenis)
    {
    	$hasil = $this->db->get_where($this->get_tabel_by_jenis($jenis),array('no_bukti' => $no_bukti))->result_array();
    	
    	$data = array();

    	foreach ($hasil as $entry) {
    		$detail = $this->db->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row_array();
    		$data[] = array_merge($entry,$detail);
    	}

    	return $data;
    }

    public function get_transfer_pajak($id_kuitansi_jadi)
    {
    	$kuitansi = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' => $id_kuitansi_jadi))->row_array();

    	$hasil = $this->db->select('jenis_pajak')
    					  ->select('persen_pajak')
    					  ->select('rupiah_pajak as jumlah',false)
    					  ->get_where($this->get_tabel_by_jenis($kuitansi['jenis']),array('no_bukti' => $kuitansi['no_bukti']))
    					  ->result_array();

    	$data = array();

    	foreach ($hasil as $entry) {
    		$detail = $this->db->select('kode_akun as akun',false)->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row_array();
    		$detail['jenis'] = 'pajak';
    		$data[] = array_merge($entry,$detail);
    	}
    	return $data;
    }

    public function insert_pajak($id_kuitansi_jadi,$array_pajak)
    {
    	$kuitansi = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' => $id_kuitansi_jadi))->row_array();
    	$kuitansi['tipe'] = 'pajak';


    	if ($array_pajak != null and $kuitansi['jenis'] != 'NK') {
    		$kuitansi['akun_debet'] = 0;
    		$kuitansi['akun_debet_akrual'] = 0;
    		$kuitansi['jumlah_debet'] = 0;
    		$kuitansi['akun_kredit'] = 0;
    		$kuitansi['akun_kredit_akrual'] = 0;
    		$kuitansi['jumlah_kredit'] = 0;

    		$id_kuitansi_awal = $kuitansi['id_kuitansi_jadi'];

    		$updater['has_pajak'] = 1;

    		$this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_awal);

    		unset($kuitansi['id_kuitansi_jadi']);

    		$id_kuitansi = $this->db->insert('akuntansi_kuitansi_jadi',$kuitansi);
    		foreach ($array_pajak as $entry_pajak) {
    			$entry_pajak['id_kuitansi_jadi'] = $id_kuitansi;
    			$entry_pajak['no_bukti'] = $kuitansi['no_bukti'];
    			// print_r($entry_pajak)
    			$this->db->insert('akuntansi_relasi_kuitansi_akun',$entry_pajak);
    		}
    	}
    }


	
}