<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Output_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db_laporan = $this->load->database('rba',TRUE);
    }

	public function get_nama_output($kode_kegiatan)
	{
		if (strlen($kode_kegiatan) <= 10 ){
			return "-";
		} else {
			try {
				$this->db_laporan->where('kode_kegiatan',substr($kode_kegiatan,6,2));
				$this->db_laporan->where('kode_output',substr($kode_kegiatan,8,2));
				$hasil = $this->db_laporan->get('output')->row_array();

				if ($hasil == null)
					throw new Exception("Error Processing Request", 1);

				return $hasil['nama_output'];	
			} catch (Exception $e) {
				return "-";
			}
		}
	}
}