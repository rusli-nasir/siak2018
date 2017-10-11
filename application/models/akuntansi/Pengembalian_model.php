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
		$kuitansi['id_pajak'] = 0;
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

    public function insert_pengembalian_with_array($id_kuitansi_jadi,$array_pengembalian)
    {
        $kuitansi = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' => $id_kuitansi_jadi))->row_array();
        $kuitansi['tipe'] = 'pengembalian';


        if ($array_pengembalian != null) {
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
            $id_kuitansi = $this->db->insert_id();
            foreach ($array_pengembalian as $entry_pengembalian) {
                $entry_pengembalian['id_kuitansi_jadi'] = $id_kuitansi;
                $entry_pengembalian['no_bukti'] = $kuitansi['no_bukti'];
                // print_r($entry_pengembalian);
                $this->db->insert('akuntansi_relasi_kuitansi_akun',$entry_pengembalian);
            }
            // die();

            $updater['id_pengembalian'] = $id_kuitansi;

            $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_awal);

            return $id_kuitansi;

        }
    }

    public function hapus_pengembalian($id_pengembalian)
    {
        $this->db->where('id_kuitansi_jadi',$id_pengembalian);
        $this->db->delete('akuntansi_kuitansi_jadi');
        $this->db->where('id_kuitansi_jadi',$id_pengembalian);
        $this->db->delete('akuntansi_relasi_kuitansi_akun');

        $this->Posting_model->hapus_posting_full($id_pengembalian);
    }
}