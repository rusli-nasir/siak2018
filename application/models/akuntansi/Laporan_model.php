<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->db_laporan = $this->load->database('laporan',TRUE);
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');

    }

    function read_buku_besar_group($group = null){
        $query = $this->db_laporan->query("SELECT * FROM akuntansi_kuitansi_jadi GROUP BY $group");
        return $query;
    }

    public function get_pajak()
    {
        $query = $this->db->get('akuntansi_pajak')->result_array();
        $array_hasil = array();
        foreach($query as $entry) {
            $array_hasil[$entry['akun']] = $entry;
        }
    }

    function read_buku_besar_akun_group($group = null,$akun = null,$unit = null,$sumber_dana=null,$start_date=null,$end_date=null){

        $this->db_laporan
            ->where("tipe != 'memorial' AND tipe != 'jurnal_umum' AND tipe != 'pajak' AND tipe != 'penerimaan' AND tipe != 'pengembalian'")
            // ->order_by('no_bukti')
            ;

        if ($akun != null){
            $this->db_laporan->like($group,$akun,'after');
        }

        if ($sumber_dana != null){
            $this->db_laporan->where('jenis_pembatasan_dana',$sumber_dana);
        }

        if ($start_date != null and $end_date != null){
            $this->db_laporan->where("(tanggal BETWEEN '$start_date' AND '$end_date')");
        }

        if ($unit != null) {
                $this->db_laporan->where('unit_kerja',$unit);
            }


        // echo $this->db_laporan->get_compiled_select();

        $query = $this->db_laporan->get('akuntansi_kuitansi_jadi')->result_array();



        // print_r($this->db->get_compiled_select());die();
        // $query = $this->db_laporan->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE $group LIKE '$akun%' AND tipe<>'memorial' AND tipe<>'jurnal_umum' GROUP BY $group")->result_array();
        return $query;
    }

    public function get_relasi_kuitansi_akun($id_kuitansi_jadi,$tipe,$jenis)
    {
        return $this->db_laporan->get_where('akuntansi_relasi_kuitansi_akun',array('id_kuitansi_jadi' => $id_kuitansi_jadi,'tipe' => $tipe, 'jenis' => $jenis))->result_array();
    }



    public function get_akun_tabel_utama($array_akun=null,$jenis=null,$unit = null,$sumber_dana=null,$start_date=null,$end_date=null){
        $array_tipe  = array('debet','kredit');

        $array_jenis = array();
        if ($jenis == null){
            $array_jenis = array('akrual','kas');
        }else {
            $array_jenis[] = $jenis;
        }

        $kolom = array(
                'debet' => array(
                        'kas' => 'akun_debet',
                        'akrual' => 'akun_debet_akrual',
                    ),
                'kredit' => array(
                        'kas' => 'akun_kredit',
                        'akrual' => 'akun_kredit_akrual'
                    ),
            );

        $data = array();

        if ($jenis == 'pajak') {
            // pajak dilihat dari relasi akun, jenis pajak akan konflik dengan array kolom
            return $data;
        }
        foreach ($array_tipe as $tipe) {
            foreach ($array_jenis as $jenis) {
                foreach ($array_akun as $akun) {
                    $query = $this->read_buku_besar_akun_group($kolom[$tipe][$jenis],$akun,$unit,$sumber_dana,$start_date,$end_date);
                    foreach ($query as $hasil) {
                        $entry = $hasil;
                        $entry['tipe'] = $tipe;
                        $entry['jenis'] = $jenis;
                        $entry['akun'] = $hasil[$kolom[$tipe][$jenis]];
                        $entry['jumlah'] = $hasil['jumlah_'.$tipe];
                        $entry['pre_tanggal'] = $entry['tanggal'];
                        $entry['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal($entry['tanggal']);
                        $data[] = $entry;
                    }
                }
                
            }
        }

        return ($data);

    }

    public function get_akun_tabel_relasi($array_akun,$jenis=null,$unit = null,$sumber_dana=null,$start_date=null,$end_date=null,$mode = null)
    {
        $data = array();
        $data_pajak = $this->get_pajak();
        foreach ($array_akun as $akun) {
            // $query = $this->db_laporan->query("SELECT * FROM akuntansi_relasi_kuitansi_akun WHERE akun LIKE '$akun%'")->result_array();

            $this->db_laporan->like('akun',$akun,'after');  


            // if ($start_date != null and $end_date != null){
            //     $this->db_laporan->where("(tanggal BETWEEN '$start_date' AND '$end_date')");
            // }

            if ($jenis != null){
                $this->db_laporan->where('jenis',$jenis);
                if ($mode == 'neraca') {
                    $this->db_laporan->or_where('jenis','pajak');
                }
            }


            $query = $this->db_laporan->get('akuntansi_relasi_kuitansi_akun')->result_array();


            $data2 = array();
            foreach ($query as $entry2) {
                // karena pajak dihitung sebagai pemasukan dan pengeluaran jadi diisi debet kredit
                if ($entry2['jenis'] == 'pajak') {
                    if ($entry2['persen_pajak'] != null) {
                        $entry2['persen_pajak'] .= " %";
                    }
                    if ($data_pajak[$entry2['akun']]['jenis'] == 'potongan' or $data_pajak[$entry2['akun']]['jenis'] == 'null') {
                        $entry2['uraian'] = $data_pajak[$entry2['akun']]['nama_akun'];
                    } else {
                        $entry2['uraian'] = ucwords(str_replace("_", " ", $entry2['jenis_pajak'])) . " " . $entry2['persen_pajak'];
                    }
                    $entry2['tipe'] = 'debet';
                    $data2[] = $entry2;
                    $entry2['tipe'] = 'kredit';
                    $data2[] = $entry2;
                } else {
                    $data2[] = $entry2;
                }
                
            }

            $query = $data2;

            foreach ($query as $hasil) {
                $entry = array();
                $this->db_laporan->where('id_kuitansi_jadi',$hasil['id_kuitansi_jadi']);

                if ($start_date != null and $end_date != null){
                    $this->db_laporan->where("(tanggal BETWEEN '$start_date' AND '$end_date')");
                }

                
                if ($sumber_dana != null){
                    $this->db_laporan->where('jenis_pembatasan_dana',$sumber_dana);
                }

                if ($unit != null) {
                    $this->db_laporan->where('unit_kerja',$unit);
                }
                // echo "(tanggal BETWEEN '$start_date' AND '$end_date')" ;die();


                $entry = $this->db_laporan->get('akuntansi_kuitansi_jadi')->row_array();
                // print_r($this->db->get_compiled_select());die();
                if ($entry != null) {
                    $entry = array_merge($entry,$hasil);
                    $entry['pre_tanggal'] = $entry['tanggal'];
                    $entry['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal($entry['tanggal']);
                    $data[] = $entry;
                }
            }
       
            // print_r($data);die();

            // if ($jenis == 'pajak') {
            //     $data2 = array();
            //     foreach ($data as $entry) {
            //         // karena pajak dihitung sebagai pemasukan dan pengeluaran jadi diisi debet kredit
            //         if ($entry['persen_pajak'] != null) {
            //             $entry['persen_pajak'] .= " %";
            //         }
            //         $entry['uraian'] = ucwords(str_replace("_", " ", $entry['jenis_pajak'])) . " " . $entry['persen_pajak'];
            //         $entry['tipe'] = 'debet';
            //         $data2[] = $entry;
            //         $entry['tipe'] = 'kredit';
            //         $data2[] = $entry;
            //     }
            //     $data =array_merge($data,$data2);
            // }
            return ($data);
        }

        // echo "aaa";
        
    }

    public function get_data_buku_besar($array_akun,$jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null,$mode = null)
    {
        $tabel_utama = array();
        $tabel_relasi = array();
        $tabel_relasi_pajak = array();

        $tabel_utama = $this->Laporan_model->get_akun_tabel_utama($array_akun,$jenis,$unit,$sumber_dana,$start_date,$end_date);

        // print_r($array_akun);die();

        $tabel_relasi = $this->Laporan_model->get_akun_tabel_relasi($array_akun,$jenis,$unit,$sumber_dana,$start_date,$end_date,$mode);         
        $tabel_relasi_pajak = $this->Laporan_model->get_akun_tabel_relasi($array_akun,'pajak',$unit,$sumber_dana,$start_date,$end_date);         

        $hasil = array_merge($tabel_utama,$tabel_relasi,$tabel_relasi_pajak);

        // print_r($jenis);die();
        // print_r($hasil);die();


        $data = array();
        foreach ($hasil as $entry) {
            $data[$entry['akun']][] = $entry;
        }

        foreach ($data as $key => $value) {
            usort($data[$key],function($a,$b){
                $hasil = strcmp($a['pre_tanggal'],$b['pre_tanggal']);
                if ($hasil == 0) {
                    $hasil = strcmp($a['no_bukti'],$b['no_bukti']);
                }
                return $hasil;
            });
        }

        return $data;
    }

    public function read_rekap_jurnal($jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null)
    {

        $array_jenis = array('pajak');
        if ($jenis == null){
            $array_jenis = array('akrual','kas');
        }else {
            $array_jenis[] = $jenis;
        }

        $kolom = array(
            'debet' => array(
                    'kas' => 'akun_debet',
                    'akrual' => 'akun_debet_akrual',
                ),
            'kredit' => array(
                    'kas' => 'akun_kredit',
                    'akrual' => 'akun_kredit_akrual'
                ),
        );

        if ($sumber_dana != null){
            $this->db_laporan->where('jenis_pembatasan_dana',$sumber_dana);
        }

        if ($start_date != null and $end_date != null){
            $this->db_laporan->where("(tanggal BETWEEN '$start_date' AND '$end_date')");
        }

        // if ($jenis != null){
        //     $this->db_laporan->where('jenis',$jenis);
        // }

        if ($unit != null) {
            $this->db_laporan->where('unit_kerja',$unit);
        }

        // $this->db_laporan->where("tipe <> 'pajak'");

        $this->db_laporan->order_by('tanggal')->order_by('no_bukti');

        $query = $this->db_laporan->get('akuntansi_kuitansi_jadi')->result_array();

        // print_r($query);die();

        $i = 0;
        $data = array();
        foreach ($query as $entry) {
            $data[$i]['transaksi'] = $entry;
            if ($entry['tipe'] == 'memorial' or $entry['tipe'] == 'jurnal_umum' or $entry['tipe'] == 'pajak' or $entry['tipe'] == 'pengembalian'or $entry['tipe'] == 'penerimaan') {
                $this->db_laporan->where('id_kuitansi_jadi',$entry['id_kuitansi_jadi']);

                $in_query = $this->db_laporan->get('akuntansi_relasi_kuitansi_akun')->result_array();

                if ($entry['tipe'] == 'pajak') {
                    $data2 = array();
                    foreach ($in_query as $entry2) {
                        // karena pajak dihitung sebagai pemasukan dan pengeluaran jadi diisi debet kredit
                        if ($entry2['persen_pajak'] != null) {
                            $entry2['persen_pajak'] .= " %";
                        }
                        $entry2['uraian'] = ucwords(str_replace("_", " ", $entry2['jenis_pajak'])) . " " . $entry2['persen_pajak'];
                        $entry2['tipe'] = 'debet';
                        $data2[] = $entry2;
                        $entry2['tipe'] = 'kredit';
                        $data2[] = $entry2;
                    }
                    $in_query = $data2;
                    
                }
                $data[$i]['akun'] = array_filter($in_query, function ($row) use ($array_jenis){
                                                return in_array($row['jenis'],$array_jenis);
                                            });
                
                // $data[$i]['akun'] = $in_query;
            }else {
                foreach ($kolom as $key_kolom => $in_kolom) {
                    foreach ($array_jenis as $key_jenis => $in_jenis) {
                        if ($in_jenis != 'pajak') {
                            $isi_akun = array();
                            $isi_akun['tipe'] = $key_kolom;
                            $isi_akun['jenis'] = $in_jenis;
                            $isi_akun['akun'] = $entry[$kolom[$key_kolom][$in_jenis]];
                            $isi_akun['jumlah'] = $entry['jumlah_'.$key_kolom];
                            $data[$i]['akun'][] = $isi_akun;
                        }
                    }
                }
            }
            $i++;
        }

        return $data;

    }

    public function get_data_jurnal_umum($jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null)
    {
        $array_tipe  = array('debet','kredit');

        $array_jenis = array();
        if ($jenis == null){
            $array_jenis = array('akrual','kas');
        }else {
            $array_jenis[] = $jenis;
        }

        $kolom = array(
                'debet' => array(
                        'kas' => 'akun_debet',
                        'akrual' => 'akun_debet_akrual',
                    ),
                'kredit' => array(
                        'kas' => 'akun_kredit',
                        'akrual' => 'akun_kredit_akrual'
                    ),
            );

        $data = array();
        foreach ($array_tipe as $tipe) {
            foreach ($array_jenis as $jenis) {
                $query = $this->read_jurnal_umum($kolom[$tipe][$jenis],$akun);
                print_r($query);
                foreach ($query as $hasil) {
                    $entry = $hasil;
                    $entry['tipe'] = $tipe;
                    $entry['jenis'] = $jenis;
                    $entry['akun'] = $hasil[$kolom[$tipe][$jenis]];
                    $entry['jumlah'] = $hasil['jumlah_'.$tipe];
                    $entry['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal($entry['tanggal']);
                    $data[] = $entry;
                }
                
            }
        }

        return ($data);
    }

    // kode_akun = 123
    // tipe = debet
    // jenis = akrual
    // jumlah  = 1234
}