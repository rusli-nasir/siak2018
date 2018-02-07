<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }


    
    /**
     * Gets the akun kerjasama permintaan.
     */
    public function get_akun_kerjasama_permintaan()
    {
    	return array(
    		'akun_debet' => array(
    							'akun_6' => "523159",
    							'nama' => $this->get_nama_akun("523159")
    						),
    		'akun_kredit' => array(
    							'akun_6' => "911101",
    							'nama' => $this->get_nama_akun("911101")
    						),
    		'akun_debet_akrual' => array(
    							'akun_6' => "723159",
    							'nama' => $this->get_nama_akun("723159")
    						),
    		'akun_kredit_akrual' => array(
    							'akun_6' => "111148",
    							'nama' => $this->get_nama_akun("111148")
    						)
    	);
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
		              $uraian_akun[0] = 'Beban';
		            }
		        }
	            $hasil_uraian = implode(' ', $uraian_akun);
	            return $hasil_uraian;
			} else if (substr($kode_akun,0,1) == 6 or substr($kode_akun,0,1) == 4){
				// $kode_akun[0] = 4;
				substr_replace($kode_akun,4,0,1);
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
			} else if (substr($kode_akun,0,1) == 2){
				return $this->db->get_where('akuntansi_hutang_6', array('akun_6' => $kode_akun))->row_array()['nama'];
			} else if (substr($kode_akun,0,1) == 3){
				return $this->db->get_where('akuntansi_aset_bersih_6', array('akun_6' => $kode_akun))->row_array()['nama'];
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

	public function get_konversi_akun_5($kode_akun)
	{
		$konversi = $this->db->get_where('akuntansi_akun_konversi',array('dari' => $kode_akun))->row_array();
		if ($konversi == null) {
			return substr_replace($kode_akun,7,0,1);
		}else {
			return $konversi['ke'];
		}
	}

	public function get_akun_by_level($kode_akun,$level,$tabel,$array_not_akun = null,$mode = null)
	{
		// die($tabel);
		$replacer = 0;
		if ($kode_akun == 6) {
			$kode_akun = 4;
			$replacer = 6;
		}
		$data = array();

		if ($kode_akun == 5 or $kode_akun == 7) {
			$replacer = $kode_akun;
			$kode_akun = 5;
			// $replacer = 7;
			for ($i=1; $i <= $level; $i++) { 
				$teks_kode = $i."digit";
				$teks_nama = $i."digit";
				if ($i == 5){
					$i++;
				}
				if ($i == 6){
					$teks_kode = "";
					$teks_nama = "";
				}
				$this->db2->select("kode_akun".$teks_kode." as akun_$i");
			}
			$this->db2->select("nama_akun".$teks_nama." as nama");

			if ($array_not_akun != null) {
				foreach ($array_not_akun as $not_akun) {
					if (substr($not_akun,0,1) == 7){
						$not_akun = substr_replace($not_akun,5,0,1);
					}
					$this->db2->not_like("kode_akun".$teks_kode,$not_akun,'after');
				}
			}
			$this->db2
					 ->like("kode_akun".$teks_kode,$kode_akun,'after')
					 ->group_by("kode_akun".$teks_kode)
					 ->from("akun_belanja")
			;
			// echo $this->db2->get_compiled_select();die();
			$hasil = $this->db2->get()->result_array();

			// BLOK GANTI NAMA KE BEBAN PENGADAAN JASA LAIN-LAIN
			
			// foreach ($hasil as $key => $value) {
			// 	if ($value['akun_3'] == 523){
			// 		$hasil[$key]['nama'] = "Beban Pengadaan Jasa Lain-lain";
			// 	}
			// }

			// =========================================
			
			// print_r($hasil);die();
			// echo "atas";
			// $data = array();


		} else {
			// echo "bawah";die();
			// echo $kode_akun;
			if ($array_not_akun != null) {
				foreach ($array_not_akun as $not_akun) {
					if (substr($not_akun,0,1) == 6){
						$not_akun = substr_replace($not_akun,4,0,1);
					}
					$this->db->not_like("akun_".$level,$not_akun,'after');
				}
			}
			$this->db
				->like("akun_$level",$kode_akun,'after')
				->from("akuntansi_".$tabel."_".$level)
			;

			if ($kode_akun == 8){
				$this->db->not_like("akun_".$level,825,'after');
			}
			// echo $this->db->get_compiled_select();die();

			$hasil = $this->db->get()->result_array();




		}

		// echo "<pre>";
		// print_r($hasil);die();
		if ($mode == 'singular'){
			foreach ($hasil as $key => $entry) {
				if ($level == 3) {
					if ($replacer == 7) {
						$entry['nama'] = str_replace("Biaya","Beban",$entry['nama']);
						$entry['nama'] = ucwords(strtolower($entry['nama']));
					}
					$data[] = $entry;
				} elseif($level == 4) {
					if ($replacer == 7) {
						$entry['nama'] = str_replace("Biaya","Beban",$entry['nama']);
						$entry['nama'] = ucwords(strtolower($entry['nama']));
					}
					$data[] = $entry;
				} elseif($level == 6) {
					if ($replacer == 7) {
						$entry['nama'] = str_replace("Biaya","Beban",$entry['nama']);
						$entry['nama'] = ucwords(strtolower($entry['nama']));
					}
					$data[] = $entry;
				}
			}
			return $data;
		}


		if ($replacer != 0) {
			foreach ($hasil as $key => $entry) {
				if ($level == 3) {
					if ($replacer == 7) {
						$entry['nama'] = str_replace("Biaya","Beban",$entry['nama']);
						$entry['nama'] = ucwords(strtolower($entry['nama']));
					}
					$data[substr_replace($entry['akun_1'],$replacer,0,1)][substr_replace($entry['akun_2'],$replacer,0,1)][substr_replace($entry['akun_3'],$replacer,0,1)] = $entry;
				} elseif($level == 4) {
					if ($replacer == 7) {
						$entry['nama'] = str_replace("Biaya","Beban",$entry['nama']);
						$entry['nama'] = ucwords(strtolower($entry['nama']));
					}
					$data[substr_replace($entry['akun_1'],$replacer,0,1)][substr_replace($entry['akun_2'],$replacer,0,1)][substr_replace($entry['akun_3'],$replacer,0,1)][substr_replace($entry['akun_4'],$replacer,0,1)] = $entry;
				} elseif($level == 6) {
					if ($replacer == 7) {
						$entry['nama'] = str_replace("Biaya","Beban",$entry['nama']);
						$entry['nama'] = ucwords(strtolower($entry['nama']));
					}
					$data[substr_replace($entry['akun_1'],$replacer,0,1)][substr_replace($entry['akun_2'],$replacer,0,1)][substr_replace($entry['akun_3'],$replacer,0,1)][substr_replace($entry['akun_4'],$replacer,0,1)][substr_replace($entry['akun_6'],$replacer,0,1)] = $entry;
				}
			}
		} else {
			foreach ($hasil as $key => $entry) {
				if ($level == 3) {
					$entry['nama'] = ucwords(strtolower($entry['nama']));
					$data[$entry['akun_1']][$entry['akun_2']][$entry['akun_3']] = $entry;
				} elseif($level == 4) {
					$entry['nama'] = ucwords(strtolower($entry['nama']));
					$data[$entry['akun_1']][$entry['akun_2']][$entry['akun_3']][$entry['akun_4']] = $entry;
				} elseif($level == 6) {
					$entry['nama'] = ucwords(strtolower($entry['nama']));
					$data[$entry['akun_1']][$entry['akun_2']][$entry['akun_3']][$entry['akun_4']][$entry['akun_6']] = $entry;
				}
			}
		}


		return $data;

		

	}

	public function get_nama_akun_by_level($kode_akun,$level,$tabel=null)
	{
		$sub_kode = substr($kode_akun,0,1);

		if($tabel == null){
			if ($sub_kode == 4){
				$tabel = 'lra';
			}elseif ($sub_kode == 8) {
				$tabel = 'pembiayaan';
			}
		}


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
		
		$tahun = $this->session->userdata('setting_tahun');

		$hasil = $this->db->get_where('akuntansi_saldo',array('akun' => $kode_akun,'tahun' => $tahun))->row_array();

		return $hasil;
	}

	public function get_saldo_awal_batch($array_akun)
	{
		$tahun = $this->session->userdata('setting_tahun');		
		$data = array();

		foreach ($array_akun as $akun) {
			$this->db->where('tahun',$tahun);
			$this->db->like('akun',$akun,'after');
			$query = $this->db->get('akuntansi_saldo')->result_array();

			foreach ($query as $hasil) {
				$data[$hasil['akun']] = $hasil['saldo_awal'];
			}
		}

		return $data;
	}


    public function get_all_akun_biaya()
    {
        $hasil = $this->db2->get('ref_akun')->result_array();

        $data = array();
        $temp_data = array();

        $temp_akun  = array();
        $temp_nama = array();
        $temp_regex = array();

        foreach ($hasil as $entry) {
        	$temp_regex = array();
        	$temp_akun = array();
        	$temp_kode = array();
            $temp_akun['kode_akun'] = $entry['kode_akun'];
            $temp_akun['kode_akun_sub']  = $entry['kode_akun_sub'];
            $temp_nama['nama_akun'] = $entry['nama_akun'];
            $temp_nama['nama_akun_sub'] = $entry['nama_akun_sub'];
            $regex = $this->db2->distinct()->select('kode_subkomponen_input')->get_where('ket_subkomponen_input_',array('jenis_biaya' => $temp_nama['nama_akun'],'jenis_komponen' => $temp_nama['nama_akun_sub']));
            while ($ea_regex = $regex->unbuffered_row()) {
                $string_akun = substr($ea_regex->kode_subkomponen_input, 0, 5);
                $string_kode = substr($ea_regex->kode_subkomponen_input, 5);
                $temp_regex[] = '^\\d{6}\\'.$string_kode.'\\d{2}'.$string_akun.'\\$';
                // $temp_akun[] = $string_akun;
                // $temp_kode[] = $string_kode;

                // $temp_regex[] = $string_kode.$string_akun;
            }
            $temp_data['kode'] = $temp_akun;
            $temp_data['nama'] = $temp_nama;
            $temp_data['regex'] = $temp_regex;
            // $temp_data['string_kode'] = $temp_kode;
            // $temp_data['string_akun'] = $temp_akun;
            $data[]=$temp_data;
        }
        return $data;
    }

    public function get_akun_kerjasama_penerimaan()
    {
    	return $this->db->get_where('akuntansi_aset_6',array('flag_penerimaan' => 1))->result_array();
    }

    public function get_akun_kerjasama_lra()
    {
    	return $this->db->get_where('akuntansi_lra_6',array('akun_3' => 424))->result_array();
    }

	public function get_akun_penerimaan()
    {
        $this->db->not_like('nama', 'Operasional');
        $result1 =  $this->db->get('akuntansi_aset_6')->result_array();
        $this->db->like('nama', 'Operasional BBM');
        $result2 =  $this->db->get('akuntansi_aset_6')->result_array();
        $this->db->like('akun_6', '111148');
        $result3 =  $this->db->get('akuntansi_aset_6')->result_array();
        $this->db->like('akun_6', '111302');
        $result3 =  $this->db->get('akuntansi_aset_6')->result_array();
        return array_merge($result1,$result2,$result3);
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

    public function get_akun_belanja_bbm($mode = null)
    {
    	$this->db->select('nama_akun as nama');
    	$this->db->select('kode_akun as akun_6');
    	$hasil = $this->db->get_where('akun_belanja',array('nama_akun' => 'Biaya BBM'))->row_array();

    	if ($mode == 'akrual'){
    		$hasil['akun_6'] = substr_replace($hasil['akun_6'],7,0,1);
    		$hasil['nama'] = substr_replace($hasil['nama'],'Beban',0,5);

    	}
    	return $hasil;
    }

    public function get_sal_bbm()
    {
    	return $this->db->get_where('akuntansi_sal_6',array('kode_unit' => 'bbm'))->row_array();
    }

    public function get_kas_bbm()
    {
    	return $this->db->get_where('akuntansi_aset_6',array('kode_unit' => 'bbm'))->row_array();
    }

    
}