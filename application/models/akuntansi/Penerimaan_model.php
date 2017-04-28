<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penerimaan_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	public function generate_nomor_bukti()
	{
		$latest = $this->db->order_by('id_kuitansi_jadi','DESC')->get_where('akuntansi_kuitansi_jadi',array('tipe' => 'penerimaan'))->row_array();

		if ($latest != null){
			$no_bukti = (int)substr($latest['no_bukti'],1);
			$no_bukti++;
		} else {
			$no_bukti = 1;
		}

		return 'P'.sprintf("%06d", $no_bukti);
	}
}