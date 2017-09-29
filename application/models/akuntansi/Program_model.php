<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Program_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }
	
	public function get_select_program(){
		// program -> kegiatan -> sub kegiatan
		$tujuan = $this->db2->get('kegiatan')->result_array();
		$sasaran = $this->db2->get('output')->result_array();
		$program = $this->db2->get('program')->result_array();
		$kegiatan = $this->db2->get('komponen_input')->result_array();
		$subkegiatan = $this->db2->get('subkomponen_input')->result_array();

		$data = array();

		$data['tujuan'] = $tujuan;
		$data['sasaran'] = $sasaran;
		$data['program'] = $program;
		$data['kegiatan'] = $kegiatan;
		$data['subkegiatan'] = $subkegiatan;

		return $data;
	}

	public function get_nama_composite($kode_tingkat)
	{
		$param = str_split($kode_tingkat,2);
		$banyaknya = count($param);
		if ($banyaknya == 1){
			return $this->get_nama_tujuan($param[0]);
		}elseif ($banyaknya == 2) {
			return $this->get_nama_sasaran($param[0],$param[1]);
		}elseif ($banyaknya == 3) {
			return $this->get_nama_program($param[0],$param[1],$param[2]);
		}elseif ($banyaknya == 4) {
			return $this->get_nama_kegiatan($param[0],$param[1],$param[2],$param[3]);
		}elseif ($banyaknya == 5) {
			return $this->get_nama_kegiatan($param[0],$param[1],$param[2],$param[3],$param[4]);
		}
	}

	public function get_nama_tujuan($kode_kegiatan)
	{
		return $this->db2->where('kode_kegiatan',$kode_kegiatan)->get('kegiatan')->row_array()['nama_kegiatan'];
	}

	public function get_nama_sasaran($kode_kegiatan,$kode_output)
	{
		return $this->db2
							->where('kode_kegiatan',$kode_kegiatan)
							->where('kode_output',$kode_output)
						 ->get('output')->row_array()['nama_output'];
	}

	public function get_nama_program($kode_kegiatan,$kode_output,$kode_program)
	{
		return $this->db2
							->where('kode_kegiatan',$kode_kegiatan)
							->where('kode_output',$kode_output)
							->where('kode_program',$kode_program)
						 ->get('program')->row_array()['nama_program'];
	}

	public function get_nama_kegiatan($kode_kegiatan,$kode_output,$kode_program,$kode_komponen)
	{
		return $this->db2
							->where('kode_kegiatan',$kode_kegiatan)
							->where('kode_output',$kode_output)
							->where('kode_program',$kode_program)
							->where('kode_komponen',$kode_komponen)
						 ->get('komponen_input')->row_array()['nama_komponen'];
	}

	public function get_nama_subkegiatan($kode_kegiatan,$kode_output,$kode_program,$kode_komponen,$kode_subkomponen)
	{
		return $this->db2
							->where('kode_kegiatan',$kode_kegiatan)
							->where('kode_output',$kode_output)
							->where('kode_program',$kode_program)
							->where('kode_komponen',$kode_komponen)
							->where('kode_subkomponen',$kode_subkomponen)
						 ->get('subkomponen_input')->row_array()['nama_subkomponen'];
	}
}