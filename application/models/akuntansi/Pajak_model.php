<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pajak_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
    }


    public function get_tabel_by_jenis($jenis)
    {
        if ($jenis == 'GP' or $jenis == 'TUP_NIHIL' or $jenis == 'GUP_NIHIL' or $jenis == 'LK' or $jenis == 'LN' or $jenis == 'EM') {
            return 'rsa_kuitansi_detail_pajak';
        }elseif ($jenis == 'L3' or $jenis == 'LSPHK3') {
            return 'rsa_kuitansi_detail_pajak_lsphk3';
        }elseif ($jenis == 'TUP_PENGEMBALIAN'  or $jenis == 'GUP_PENGEMBALIAN') {
            return 'rsa_kuitansi_detail_pajak_pengembalian';
        }
    }

    public function get_tabel_detail_by_jenis($jenis)
    {
        if ($jenis == 'GP' or $jenis == 'TUP_NIHIL' or $jenis == 'GUP_NIHIL' or $jenis == 'LK' or $jenis == 'LN'  or $jenis == 'EM') {
            return 'rsa_kuitansi_detail';
        }elseif ($jenis == 'L3' or $jenis == 'LSPHK3') {
            return 'rsa_kuitansi_detail_lsphk3';
        }elseif ($jenis == 'TUP_PENGEMBALIAN'  or $jenis == 'GUP_PENGEMBALIAN') {
            return 'rsa_kuitansi_detail_pengembalian';
        }
    }

    public function get_tabel_utama_by_jenis($jenis)
    {
    	if ($jenis == 'GP' or $jenis == 'TUP_NIHIL'  or $jenis == 'GUP_NIHIL' or $jenis == 'LK' or $jenis == 'LN'  or $jenis == 'EM') {
    		return 'rsa_kuitansi';
    	}elseif ($jenis == 'L3' or $jenis == 'LSPHK3') {
    		return 'rsa_kuitansi_lsphk3';
    	}elseif ($jenis == 'TUP_PENGEMBALIAN' or $jenis == 'GUP_PENGEMBALIAN') {
            return 'rsa_kuitansi_pengembalian';
        }
    }

    // public function get_detail_pajak($no_bukti,$jenis)
    // {
    //     // $hasil = $this->db->get_where($this->get_tabel_by_jenis($jenis),array('no_bukti' => $no_bukti))->result_array();

    //     $from = $this->get_tabel_by_jenis($jenis);
    //     $hasil = $this->db
    //                 ->select('*')
    //                 ->select_sum('rupiah_pajak')
    //                 ->group_by('jenis_pajak')
    //                 ->where('no_bukti',$no_bukti)
    //                 ->get($from)
    //                 ->result_array()
    //                 ;


    //     $data = array();

    //     $data_2 = array();

    //     foreach ($hasil as $entry) {
    //         if ($entry['jenis_pajak'] == 'Lainnya' or $entry['jenis_pajak'] == 'PPh_Ps_4(2)') {
    //             $entry['jenis_pajak'] = 'PPh_final';
    //         }
    //         $detail = $this->db->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row_array();
    //         if ($detail != null) {
    //           $data[] = array_merge($entry,$detail);  
    //         }
    //     }



    //     // foreach ($data as $entry) {
    //     //     $jumlah_pajak = $entry['rupiah_pajak'];
    //     //     $unset($entry['rupiah_pajak']);
    //     //     $data_2[$entry['jenis_pajak']] = $entry;
    //     //     $data_2[$entry['jenis_pajak']['rupiah_pajak']] += $jumlah_pajak;
    //     // }

    //     return $data;
    // }

    public function get_detail_pajak_lama($no_bukti,$jenis)
    {
        // $hasil = $this->db->get_where($this->get_tabel_by_jenis($jenis),array('no_bukti' => $no_bukti))->result_array();

        $from = $this->get_tabel_by_jenis($jenis);
        $hasil = $this->db
                    ->select('*')
                    ->select_sum('rupiah_pajak')
                    ->group_by('jenis_pajak')
                    ->where('no_bukti',$no_bukti)
                    ->get($from)
                    ->result_array()
                    ;


        $data = array();

        $data_2 = array();

        foreach ($hasil as $entry) {
            $detail = $this->db->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row_array();
            if ($detail != null) {
              $data[] = array_merge($entry,$detail);  
            }
        }



        // foreach ($data as $entry) {
        //     $jumlah_pajak = $entry['rupiah_pajak'];
        //     $unset($entry['rupiah_pajak']);
        //     $data_2[$entry['jenis_pajak']] = $entry;
        //     $data_2[$entry['jenis_pajak']['rupiah_pajak']] += $jumlah_pajak;
        // }

        return $data;
    }


    // public function get_detail_pajak($id_kuitansi,$jenis)
    // {
    //     // $hasil = $this->db->get_where($this->get_tabel_by_jenis($jenis),array('no_bukti' => $no_bukti))->result_array();

    //     $hasil = $this->db
    //                 ->select('*')
    //                 ->select_sum('rupiah_pajak')
    //                 ->group_by('jenis_pajak')
    //                 ->where('no_bukti',$no_bukti)
    //                 ->get($this->get_tabel_by_jenis($jenis))
    //                 ->result_array()
    //                 ;

    //     $data = array();

    //     $data_2 = array();

    //     foreach ($hasil as $entry) {
    //         if ($entry['jenis_pajak'] == 'Lainnya' or $entry['jenis_pajak'] == 'PPh_Ps_4(2)') {
    //             $entry['jenis_pajak'] = 'PPh_final';
    //         }
    //         $detail = $this->db->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row_array();
    //         if ($detail != null) {
    //           $data[] = array_merge($entry,$detail);  
    //         }
    //     }



    //     // foreach ($data as $entry) {
    //     //     $jumlah_pajak = $entry['rupiah_pajak'];
    //     //     $unset($entry['rupiah_pajak']);
    //     //     $data_2[$entry['jenis_pajak']] = $entry;
    //     //     $data_2[$entry['jenis_pajak']['rupiah_pajak']] += $jumlah_pajak;
    //     // }

    //     return $data;
    // }

    public function get_detail_pajak_baru($id_kuitansi,$jenis)
    {
        // $hasil = $this->db->get_where($this->get_tabel_by_jenis($jenis),array('no_bukti' => $no_bukti))->result_array();

        $tabel_detail = $this->get_tabel_detail_by_jenis($jenis);
        $tabel_utama = $this->get_tabel_utama_by_jenis($jenis);
        $tabel_pajak = $this->get_tabel_by_jenis($jenis);

        $query = "SELECT tp.*,SUM(tp.rupiah_pajak) as rupiah_pajak FROM $tabel_utama as tu, $tabel_detail as td, $tabel_pajak as tp WHERE tu.id_kuitansi='$id_kuitansi' AND td.id_kuitansi = tu.id_kuitansi AND td.id_kuitansi_detail=tp.id_kuitansi_detail AND tp.rupiah_pajak > 0 GROUP BY tp.jenis_pajak";

        $pajak_valid = array('PPh_Ps_21','PPh_Ps_22','PPh_Ps_22','PPh_Ps_23','PPh_Ps_26','PPN');
        // echo $query;die();


        $hasil =  $this->db->query($query)->result_array();

        // $hasil = $this->db
        //             ->select('*')
        //             ->select_sum('rupiah_pajak')
        //             ->group_by('jenis_pajak')
        //             ->join($tabel_detail,"$tabel_detail.id_kuitansi = rsa")
        //             ->where('no_bukti',$no_bukti)
        //             ->get($this->get_tabel_by_jenis($jenis))
        //             ->result_array()
        //             ;

        $data = array();

        $data_2 = array();

        foreach ($hasil as $entry) {
            if (!in_array($entry['jenis_pajak'],$pajak_valid)) {
                $entry['jenis_pajak'] = 'PPh_final';
            }
            $detail = $this->db->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row_array();
            if ($detail != null) {
              $data[] = array_merge($entry,$detail);  
            }
        }



        // foreach ($data as $entry) {
        //     $jumlah_pajak = $entry['rupiah_pajak'];
        //     $unset($entry['rupiah_pajak']);
        //     $data_2[$entry['jenis_pajak']] = $entry;
        //     $data_2[$entry['jenis_pajak']['rupiah_pajak']] += $jumlah_pajak;
        // }

        return $data;
    }

    public function get_detail_pajak($no_bukti,$jenis)
    {
    	// $hasil = $this->db->get_where($this->get_tabel_by_jenis($jenis),array('no_bukti' => $no_bukti))->result_array();

        $tabel_detail = $this->get_tabel_detail_by_jenis($jenis);
        $tabel_utama = $this->get_tabel_utama_by_jenis($jenis);
        $tabel_pajak = $this->get_tabel_by_jenis($jenis);

        if ($tabel_detail == null){
            return null;
        }

        $query = "SELECT tp.*,SUM(tp.rupiah_pajak) as rupiah_pajak FROM $tabel_utama as tu, $tabel_detail as td, $tabel_pajak as tp WHERE tu.no_bukti='$no_bukti' AND td.id_kuitansi = tu.id_kuitansi AND td.id_kuitansi_detail=tp.id_kuitansi_detail AND tp.rupiah_pajak > 0 GROUP BY tp.jenis_pajak";

        $pajak_valid = array('PPh_Ps_21','PPh_Ps_22','PPh_Ps_22','PPh_Ps_23','PPh_Ps_26','PPN');
        // echo $query;die();


        $hasil =  $this->db->query($query)->result_array();

        // $hasil = $this->db
        //             ->select('*')
        //             ->select_sum('rupiah_pajak')
        //             ->group_by('jenis_pajak')
        //             ->join($tabel_detail,"$tabel_detail.id_kuitansi = rsa")
        //             ->where('no_bukti',$no_bukti)
        //             ->get($this->get_tabel_by_jenis($jenis))
        //             ->result_array()
        //             ;

    	$data = array();

        $data_2 = array();

    	foreach ($hasil as $entry) {
            if (!in_array($entry['jenis_pajak'],$pajak_valid)) {
                $entry['jenis_pajak'] = 'PPh_final';
            }
    		$detail = $this->db->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row_array();
            if ($detail != null) {
    		  $data[] = array_merge($entry,$detail);  
            }
    	}



        // foreach ($data as $entry) {
        //     $jumlah_pajak = $entry['rupiah_pajak'];
        //     $unset($entry['rupiah_pajak']);
        //     $data_2[$entry['jenis_pajak']] = $entry;
        //     $data_2[$entry['jenis_pajak']['rupiah_pajak']] += $jumlah_pajak;
        // }

    	return $data;
    }


    public function get_transfer_pajak($id_kuitansi_jadi)
    {
        $kuitansi = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' => $id_kuitansi_jadi))->row_array();
        $pajak_valid = array('PPh_Ps_21','PPh_Ps_22','PPh_Ps_22','PPh_Ps_23','PPh_Ps_26','PPN');

        $jenis = $kuitansi['jenis'];
        $id_kuitansi = $kuitansi['id_kuitansi'];
        $tabel_detail = $this->get_tabel_detail_by_jenis($jenis);
        $tabel_utama = $this->get_tabel_utama_by_jenis($jenis);
        $tabel_pajak = $this->get_tabel_by_jenis($jenis);

        if ($tabel_detail == null){
            return null;
        }

        // print_r($jenis);die();


        $query = "SELECT tp.jenis_pajak,tp.persen_pajak,SUM(tp.rupiah_pajak) as jumlah FROM $tabel_utama as tu, $tabel_detail as td, $tabel_pajak as tp WHERE tu.id_kuitansi='$id_kuitansi' AND td.id_kuitansi = tu.id_kuitansi AND td.id_kuitansi_detail=tp.id_kuitansi_detail AND tp.rupiah_pajak > 0 GROUP BY tp.jenis_pajak";

        $hasil =  $this->db->query($query)->result_array();




    	// $hasil = $this->db->select('jenis_pajak')
    	// 				  ->select('persen_pajak')
     //                      ->select_sum('rupiah_pajak','jumlah')
     //                      ->group_by('jenis_pajak')
    	// 				  // ->select('rupiah_pajak as jumlah',false)
    	// 				  ->get_where($this->get_tabel_by_jenis($kuitansi['jenis']),array('no_bukti' => $kuitansi['no_bukti']))
    	// 				  ->result_array();

    	$data = array();

    	foreach ($hasil as $entry) {
            if (!in_array($entry['jenis_pajak'],$pajak_valid)) {
                $entry['jenis_pajak'] = 'PPh_final';
            }
    		$detail = $this->db->select('kode_akun as akun',false)->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row_array();
            if ($detail != null ){
    		  $detail['jenis'] = 'pajak';
    		  $data[] = array_merge($entry,$detail);
            }
    	}
    	return $data;
    }

    public function insert_pajak($id_kuitansi_jadi,$array_pajak)
    {
    	$kuitansi = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' => $id_kuitansi_jadi))->row_array();
    	$kuitansi['tipe'] = 'pajak';


    	if ($array_pajak != null) {
    		$kuitansi['akun_debet'] = 0;
    		$kuitansi['akun_debet_akrual'] = 0;
    		$kuitansi['jumlah_debet'] = 0;
    		$kuitansi['akun_kredit'] = 0;
    		$kuitansi['akun_kredit_akrual'] = 0;
    		$kuitansi['jumlah_kredit'] = 0;
            $kuitansi['uraian'] = "Pemungutan dan Penyetoran Pajak " . $kuitansi['uraian'];


    		$id_kuitansi_awal = $kuitansi['id_kuitansi_jadi'];


    		unset($kuitansi['id_kuitansi_jadi']);
            unset($kuitansi['id_pengembalian']);

    		$this->db->insert('akuntansi_kuitansi_jadi',$kuitansi);
            $id_kuitansi = $this->db->insert_id();
    		foreach ($array_pajak as $entry_pajak) {
    			$entry_pajak['id_kuitansi_jadi'] = $id_kuitansi;
    			$entry_pajak['no_bukti'] = $kuitansi['no_bukti'];
    			// print_r($entry_pajak)
    			$this->db->insert('akuntansi_relasi_kuitansi_akun',$entry_pajak);
    		}

            $updater['id_pajak'] = $id_kuitansi;

            $this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_awal);

            return $id_kuitansi;

    	}
    }


	public function get_pajak(){
        $query = $this->db->get('akuntansi_pajak');
        return $query;
    }

    public function get_detail_pajak_jadi($id_kuitansi_jadi)
    {
        $id_pajak = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' => $id_kuitansi_jadi))->row_array()['id_pajak'];

        $this->db->where('id_kuitansi_jadi',$id_pajak);
        $this->db->from('akuntansi_relasi_kuitansi_akun');
        $this->db->join('akuntansi_pajak','akuntansi_pajak.jenis_pajak = akuntansi_relasi_kuitansi_akun.jenis_pajak');

        return $this->db->get()->result_array();
    }

    public function get_akun_by_jenis($jenis_pajak)
    {
        return $this->db->get_where('akuntansi_pajak',array('jenis_pajak' => $jenis_pajak))->row_array();
    }

    public function hapus_pajak($id_pajak)
    {
        $this->db->where('id_kuitansi_jadi',$id_pajak);
        $this->db->delete('akuntansi_kuitansi_jadi');
        $this->db->where('id_kuitansi_jadi',$id_pajak)->where('jenis','pajak');
        $this->db->delete('akuntansi_relasi_kuitansi_akun');

        $this->Posting_model->hapus_posting_full($id_pajak);
    }
}