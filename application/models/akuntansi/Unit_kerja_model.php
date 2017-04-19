<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_kerja_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }

    public function get_all_unit_kerja()
    {
        $hasil = $this->db2->get('unit')->result_array();
        // $hasil = array();

        // $hasil['kode_akun'] = array_column($query, 'kode_akun');
        // $hasil['nama_akun'] = array_column($query, 'nama_akun');

        return $hasil;
    }

    
}