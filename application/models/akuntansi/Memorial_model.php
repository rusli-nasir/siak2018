<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Memorial_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba', TRUE);
    }
	
	public function generate_nomor_bukti()
	{
		$latest = $this->db->order_by('id_kuitansi_jadi','DESC')->get_where('akuntansi_kuitansi_jadi',array('tipe' => 'memorial'))->row_array();

		if ($latest != null){
			$no_bukti = (int)substr($latest['no_bukti'],1);
			$no_bukti++;
		} else {
			$no_bukti = 1;
		}

		return 'M'.sprintf("%06d", $no_bukti);
	}

	public function hapus_memorial($id_kuitansi_jadi)
	{
		$this->db->where('id_kuitansi_jadi',$id_kuitansi_jadi);
		$this->db->delete('akuntansi_kuitansi_jadi');


		$this->db->where('id_kuitansi_jadi',$id_kuitansi_jadi);
		$this->db->delete('akuntansi_relasi_kuitansi_akun');
	}

	public function read_akun($table){
		$query = $this->db->get($table);
		return $query;
	}

	public function read_akun_rba($table){
		$query = $this->db2->get($table);
		return $query;
	}
}