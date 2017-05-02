<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relasi_kuitansi_akun_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	public function update_relasi_kuitansi_akun($id_kuitansi_jadi,$entry)
	{
		$this->db->where('id_kuitansi_jadi',$id_kuitansi_jadi);
		$this->db->delete('akuntansi_relasi_kuitansi_akun');

		return $this->db->insert_batch('akuntansi_relasi_kuitansi_akun',$entry);
	}

	public function insert_relasi_kuitansi_akun($id_kuitansi_jadi,$entry)
	{
		return $this->db->insert_batch('akuntansi_relasi_kuitansi_akun',$entry);
	}
}