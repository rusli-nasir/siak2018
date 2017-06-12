<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_akuntansi_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }
	
	public function generate_kode_user($kode_unit){
		$last_user = $this->db->order_by('id','desc')->get_where('akuntansi_user',array('kode_unit' => $kode_unit))->row_array();

		$unit_short = $this->db2->get_where('unit', array('kode_unit' => $kode_unit))->row_array()['alias'];

		if ($last_user == null) {
			return $unit_short.'-01';
		} else {
			$no_user = (int)substr($last_user['kode_user'],4);
			$no_user++;

			return $unit_short.'-'.sprintf("%02d", $no_user);
		}
	}
}