<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jurnal_umum_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
    }
	

	public function hapus_jurnal_umum($id_kuitansi_jadi)
	{
		$this->db->where('id_kuitansi_jadi',$id_kuitansi_jadi);
		$this->db->delete('akuntansi_kuitansi_jadi');


		$this->db->where('id_kuitansi_jadi',$id_kuitansi_jadi);
		$this->db->delete('akuntansi_relasi_kuitansi_akun');
	}
}