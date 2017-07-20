<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }
	
	public function get_nama_akun($kode_akun){
		if (isset($kode_akun)){
			if (substr($kode_akun,0,1) == 5){
				return $this->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
			} else if (substr($kode_akun,0,1) == 7){
				$kode_akun[0] = 5;
				$nama = $this->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
				$uraian_akun = explode(' ', $nama);
				if(isset($uraian_akun[0])){
		            if($uraian_akun[0]!='beban'){
		              $uraian_akun[0] = 'beban';
		            }
		        }
	            $hasil_uraian = implode(' ', $uraian_akun);
	            return $hasil_uraian;
			} else if (substr($kode_akun,0,1) == 6 or substr($kode_akun,0,1) == 4){
				$kode_akun[0] = 4;
				$hasil =  $this->db->get_where('akuntansi_lra_6',array('akun_6' => $kode_akun))->row_array()['nama'];
				if ($hasil == null) {
					$hasil = $this->db->get_where('akuntansi_pajak',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
				}
				return $hasil;
			}else if (substr($kode_akun,0,1) == 8){
				$hasil =  $this->db->get_where('akuntansi_pembiayaan_6',array('akun_6' => $kode_akun))->row_array()['nama'];
				if ($hasil == null) {
					$hasil = $this->db->get_where('akuntansi_pajak',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
				}
				return $hasil;
			} else if (substr($kode_akun,0,1) == 9){
				return $this->db->get_where('akuntansi_sal_6', array('akun_6' => $kode_akun))->row_array()['nama'];
			} else if (substr($kode_akun,0,1) == 1){
				$hasil = $this->db->get_where('akuntansi_kas_rekening',array('kode_rekening' => $kode_akun))->row_array()['uraian'];
				if ($hasil == null){
					$hasil = $this->db->get_where('akuntansi_aset_6',array('akun_6' => $kode_akun))->row_array()['nama'];
				}
				// if ($hasil == null){
				// 	$hasil = $this->db->get_where('akun_kas6',array('kd_kas_6' => $kode_akun))->row_array()['nm_kas_6'];
				// }
				return $hasil;
			} else {
				return 'Nama tidak ditemukan';
			}
		}
		
	}

	public function get_akun_by_level($kode_akun,$level,$tabel)
	{
		$replacer = 0;
		if ($kode_akun == 6) {
			$kode_akun = 4;
			$replacer = 6;
		}
		$data = array();

		if ($kode_akun == 5 or $kode_akun == 7) {
			$kode_akun = 5;
			$replacer = 7;
			for ($i=1; $i <= $level; $i++) { 
				$this->db2->select("kode_akun".$i."digit as akun_$i");
			}
			$this->db2->select("nama_akun".$level."digit as nama");
			$this->db2
					 ->like("kode_akun".$level."digit",$kode_akun,'after')
					 ->group_by("kode_akun".$level."digit")
					 ->from("akun_belanja")
			;
			// echo $this->db2->get_compiled_select();die();
			$hasil = $this->db2->get()->result_array();
			// print_r($hasil);die();
			// echo "atas";
			// $data = array();


		} else {
			// echo "bawah";die();
			// echo $kode_akun;
			$this->db
				->like("akun_$level",$kode_akun,'after')
				->from("akuntansi_".$tabel."_".$level)
			;

			$hasil = $this->db->get()->result_array();




		}


		if ($replacer != 0) {
			foreach ($hasil as $key => $entry) {
				if ($level == 3) {
					$entry['nama'] = str_replace("Biaya","Beban",$entry['nama']);
					$entry['nama'] = ucwords(strtolower($entry['nama']));
					$data[substr_replace($entry['akun_1'],$replacer,0,1)][substr_replace($entry['akun_2'],$replacer,0,1)][substr_replace($entry['akun_3'],$replacer,0,1)] = $entry;
				} else {
					$entry['nama'] = str_replace("Biaya","Beban",$entry['nama']);
					$entry['nama'] = ucwords(strtolower($entry['nama']));
					$data[substr_replace($entry['akun_1'],$replacer,0,1)][substr_replace($entry['akun_2'],$replacer,0,1)][substr_replace($entry['akun_3'],$replacer,0,1)][substr_replace($entry['akun_4'],$replacer,0,1)] = $entry;
				}
			}
		} else {
			foreach ($hasil as $key => $entry) {
				if ($level == 3) {
					$entry['nama'] = ucwords(strtolower($entry['nama']));
					$data[$entry['akun_1']][$entry['akun_2']][$entry['akun_3']] = $entry;
				} else {
					$entry['nama'] = ucwords(strtolower($entry['nama']));
					$data[$entry['akun_1']][$entry['akun_2']][$entry['akun_3']][$entry['akun_4']] = $entry;
				}
			}
		}


		return $data;

		

	}

	public function get_nama_akun_by_level($kode_akun,$level,$tabel)
	{
		$sub_kode = substr($kode_akun,0,1);


		if ($sub_kode == 6) {
			$kode_akun = substr_replace($kode_akun,'4',0,1);
		}

		if ($sub_kode == 5 or $sub_kode == 7) {
			$kode_akun = substr_replace($kode_akun,'5',0,1);

			$this->db2->select("nama_akun".$level."digit as nama");
			$this->db2
					 ->like("kode_akun".$level."digit",$kode_akun,'after')
					 ->where("kode_akun".$level."digit",$kode_akun)
					 ->group_by("kode_akun".$level."digit")
					 ->from("akun_belanja")
			;

			return ucwords(str_replace("Biaya","Beban",$this->db2->get()->row_array()['nama']));
		} else {
			$this->db
				->like("akun_$level",$kode_akun,'after')
				->from("akuntansi_".$tabel."_".$level)
				->where("akun_$level",$kode_akun)
			;

			return ucwords($this->db->get()->row_array()['nama']);
		}

	}

	public function get_saldo_awal($kode_akun)
	{
		
		$tahun = gmdate('Y');

		$hasil = $this->db->get_where('akuntansi_saldo',array('akun' => $kode_akun,'tahun' => $tahun))->row_array();

		return $hasil;
	}

	public function get_akun_penerimaan()
    {
        $this->db->not_like('nama', 'Operasional');
        return $this->db->get('akuntansi_aset_6')->result_array();
    }

	public function get_kode_sal_penerimaan()
    {
        $this->db->where('kode_unit',9999);
        return $this->db->get('akuntansi_sal_6')->row_array()['akun_6'];
    }

	public function get_akun_sal_penerimaan()
    {
        $this->db->where('kode_unit',9999);
        return $this->db->get('akuntansi_sal_6')->row_array();
    }

	public function get_kode_sal_jurnal_umum()
    {
        $this->db->where('kode_unit',92);
        return $this->db->get('akuntansi_sal_6')->row_array()['akun_6'];
    }
}