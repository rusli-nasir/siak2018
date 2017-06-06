<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pejabat_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	public function get_pejabat($unit, $jabatan){
		$this->db->where('unit', $unit);
		$this->db->where('jabatan', $jabatan);
		return $this->db->get('akuntansi_pejabat')->row_array();
	}
}