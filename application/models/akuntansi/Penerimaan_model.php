<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penerimaan_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db_laporan = $this->load->database('laporan',TRUE);

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

	public function generate_nomor_bukti_batch($number)
	{
		$latest = $this->db->order_by('id_kuitansi_jadi','DESC')->get_where('akuntansi_kuitansi_jadi',array('tipe' => 'penerimaan'))->row_array();

		$data = array();

		for ($i=0; $i < $number; $i++) { 
			if ($latest != null){
				$no_bukti = (int)substr($latest['no_bukti'],1);
				$no_bukti += $i;
			} else {
				$no_bukti = 1;
			}
			$data[] = 'P'.sprintf("%06d", $no_bukti);
		}

		return $data;


	}

	public function hapus_penerimaan($id_kuitansi_jadi)
	{
		$this->db->where('id_kuitansi_jadi',$id_kuitansi_jadi);
		$this->db->delete('akuntansi_kuitansi_jadi');
	}

	public function insert_penerimaan_batch($data)
	{
		$q1 = $this->db->insert_batch('akuntansi_kuitansi_jadi', $data);

		for ($i=0; $i < count($data); $i++) { 
			unset($data[$i]['status']);
		}
		$q2 = $this->db_laporan->insert_batch('akuntansi_kuitansi_jadi', $data);

		return $q1 and $q2;
	}
}