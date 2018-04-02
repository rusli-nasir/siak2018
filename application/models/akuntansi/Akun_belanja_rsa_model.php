<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_belanja_rsa_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->load->model('akuntansi/Akun_model', 'Akun_model');
    }

    public function get_all_akun_belanja()
    {
        $akun_konversi = array();
        $hasil = array();
        $data = $this->db2->select('kode_akun')->select('nama_akun')->get('akun_belanja')->result_array();


        $konversi = $this->db->select('dari,ke')->from('akuntansi_akun_konversi')->get()->result_array();
        foreach ($konversi as $entry) {
            $akun_konversi[$entry['dari']] = $entry['ke'];
        }

        foreach ($data as $entry){
            $kode = $entry['kode_akun'];
            if (isset($akun_konversi[$kode])) {
                $entry['kode_akun'] = $akun_konversi[$kode];
                $entry['nama_akun'] = $this->Akun_model->get_nama_akun($entry['kode_akun']);
            }
            $hasil[] = $entry;
        }
        $hasil = array_unique($hasil,SORT_REGULAR);


        return $hasil;
    }

}