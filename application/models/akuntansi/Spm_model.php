<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spm_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->load->model('rsa_gup_model');
    }
	
	public function get_tanggal_spm($no_spm,$jenis = null)
	{
		if ($jenis != 'NK'){
			$data = $this->rsa_gup_model->get_data_spm($no_spm);
        	return $data->tgl_spm;
		}

		$data = $this->db->get_where('kepeg_tr_spmls',array('nomor' => $no_spm))->row_array();
		if ($data != null) {
			return $data['tanggal'];
		}
	}
}