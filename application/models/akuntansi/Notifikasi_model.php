<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }

    public function get_jumlah_notifikasi($level,$status = 'proses')
    {
        return $this->db->get_where('akuntansi_kuitansi_jadi',array('flag'=>$level-1,'status' => $status))->num_rows();
        // $hasil = array();

        // $hasil['kode_akun'] = array_column($query, 'kode_akun');
        // $hasil['nama_akun'] = array_column($query, 'nama_akun');

        // return $hasil;
    }

    
}