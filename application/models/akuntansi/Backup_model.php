<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backup_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
    }

	public function backup_rsa()
	{
		$this->load->model('akuntansi/Spm_model', 'Spm_model');

		$array_primary = array (
						'trx_spm_up_data' => 'id_trx_spm_up_data',
						'trx_spm_gup_data' => 'id_trx_spm_gup_data',
						'trx_spm_tambah_tup_data' => 'id_trx_spm_tambah_tup_data',
						'trx_spm_tambah_up_data' => 'id_trx_spm_tambah_up_data',
						'trx_spm_tup_data' => 'id_trx_spm_gup_data',
						'trx_spm_lsphk3_data' => 'id_trx_spm_lsphk3_data',
						'rsa_kuitansi' => 'id_kuitansi'
			);
							

		$tabel_jenis = $this->Spm_model->get_array_jenis();

		$tabel_jenis['GP'] = 'rsa_kuitansi';

		$data = array();

		// print_r($tabel_jenis);die();

		foreach ($tabel_jenis as $tabel) {
			$query = $this->db->select($array_primary[$tabel],"flag_proses_akuntansi")->get_where($tabel,array('flag_proses_akuntansi' => 1))->result_array();
			foreach ($query as $entry) {
				$data[$tabel][] = $entry[$array_primary[$tabel]];
			}
		}

		return $data;

	}

	public function restore_rsa()
	{
		$this->load->model('akuntansi/Spm_model', 'Spm_model');

		$array_primary = array (
						'trx_spm_up_data' => 'id_trx_spm_up_data',
						'trx_spm_gup_data' => 'id_trx_spm_gup_data',
						'trx_spm_tambah_tup_data' => 'id_trx_spm_tambah_tup_data',
						'trx_spm_tambah_up_data' => 'id_trx_spm_tambah_up_data',
						'trx_spm_tup_data' => 'id_trx_spm_gup_data',
						'trx_spm_lsphk3_data' => 'id_trx_spm_lsphk3_data',
						'rsa_kuitansi' => 'id_kuitansi'
			);
							

		$tabel_jenis = $this->Spm_model->get_array_jenis();

		$tabel_jenis['GP'] = 'rsa_kuitansi';
		$data = unserialize(file_get_contents(FCPATH."assets/akuntansi/backup/backup.txt"));

		echo "real query disabled : <br/>";

		foreach ($data as $tabel => $ids) {
			foreach ($ids as $id) {
				echo "update tabel $tabel dengan id : $id <br/>";
				// $this->db->where($array_primary[$tabel],$id)->set('flag_proses_akuntansi',1)->update($tabel);
			}
		}


		// print_r($tabel_jenis);die();


		// return $data;

	}
	
	
}