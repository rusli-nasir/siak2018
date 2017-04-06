<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_belanja_rsa_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }

    public function get_all_akun_belanja()
    {
        $hasil = $this->db->select('kode_akun')->select('nama_akun')->get('akun_belanja')->result_array();
        // $hasil = array();

        // $hasil['kode_akun'] = array_column($query, 'kode_akun');
        // $hasil['nama_akun'] = array_column($query, 'nama_akun');

        return $hasil;
    }

    
}