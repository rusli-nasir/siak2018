<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_biaya_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }
	
	public function get_structure_akun_biaya()
	{
		$query = "
					SELECT 
						nama_subkomponen as nama, 
						concat(kode_kegiatan, kode_output, kode_program, kode_komponen, kode_subkomponen) as kode_subkomponen,
						biaya
					FROM  subkomponen_input";
		
		$subkomponen = $this->db2->query($query)->result_array();

		$ref_akun = $this->db2->get('ref_akun')->result_array();

		$data_subkomponen = array();
		$data_akun = array();

		foreach ($subkomponen as $each_subkomponen) {
			$data_subkomponen[$each_subkomponen['biaya']][$each_subkomponen['kode_subkomponen']] = $each_subkomponen;
		}

		foreach ($ref_akun as $akun) {
			if (isset($data_subkomponen[$akun['kode_akun_sub']])){
				$data_akun[$akun['kode_akun']]['nama'] = $akun['nama_akun'];
				$data_akun[$akun['kode_akun']]['data'][$akun['kode_akun_sub']]['nama'] = $akun['nama_akun_sub'];
				$data_akun[$akun['kode_akun']]['data'][$akun['kode_akun_sub']]['data'] = $data_subkomponen[$akun['kode_akun_sub']];
			}
		}

		$data[5]['nama'] = "Biaya";
		$data[5]['data'] = $data_akun;

		return $data;

		// echo "<pre>";
		// print_r($data);
		// die();
	}
}