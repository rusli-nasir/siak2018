<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relasi_kuitansi_akun_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db_laporan = $this->load->database('laporan',TRUE);
    }
	
	public function update_relasi_kuitansi_akun($id_kuitansi_jadi,$entry,$type = null)
	{
		if ($type == 'post') {
			$this->db_laporan->where('id_kuitansi_jadi',$id_kuitansi_jadi);
			$this->db_laporan->delete('akuntansi_relasi_kuitansi_akun');

			return $this->db_laporan->insert_batch('akuntansi_relasi_kuitansi_akun',$entry);	
		}else{
			$this->db->where('id_kuitansi_jadi',$id_kuitansi_jadi);
			$this->db->delete('akuntansi_relasi_kuitansi_akun');

			return $this->db->insert_batch('akuntansi_relasi_kuitansi_akun',$entry);	
		}
		
	}

	public function hapus_relasi_kuitansi_akun($id_kuitansi_jadi,$type = null)
	{
		if ($type == 'post') {
			$this->db_laporan->where('id_kuitansi_jadi',$id_kuitansi_jadi);
			return $this->db->delete('akuntansi_relasi_kuitansi_akun');
		} else {
			$this->db_laporan->where('id_kuitansi_jadi',$id_kuitansi_jadi);
			return $this->db->delete('akuntansi_relasi_kuitansi_akun');
		}
		
	}

	public function insert_relasi_kuitansi_akun($entry,$type = null)
	{
		if ($type == 'post')
			return $this->db_laporan->insert_batch('akuntansi_relasi_kuitansi_akun',$entry);
		else
			return $this->db->insert_batch('akuntansi_relasi_kuitansi_akun',$entry);
	}

	public function get_relasi_kuitansi_akun($id_kuitansi_jadi)
	{
		return $this->db->get_where('akuntansi_relasi_kuitansi_akun',array('id_kuitansi_jadi' => $id_kuitansi_jadi))->result_array();
	}
}