<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->db_laporan = $this->load->database('laporan',TRUE);
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->load->model('akuntansi/Akun_model', 'Akun_model');

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
            $array_hasil[$entry['kode_akun']] = $entry;
        }
        return $array_hasil;
    }

    function read_buku_besar_akun_group($group = null,$akun = null,$unit = null,$sumber_dana=null,$start_date=null,$end_date=null){

        $this->db_laporan
            ->where("tipe <> 'memorial' AND tipe <> 'jurnal_umum' AND tipe <> 'pajak' AND tipe <> 'penerimaan' AND tipe <> 'pengembalian'")
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
        ini_set('memory_limit', '256M');
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

            // $this->db_laporan->from('akuntansi_relasi_kuitansi_akun');
            $query = $this->db_laporan->get('akuntansi_relasi_kuitansi_akun')->result_array();



            $data2 = array();
            foreach ($query as $entry2) {
                // karena pajak dihitung sebagai pemasukan dan pengeluaran jadi diisi debet kredit
                if ($entry2['jenis'] == 'pajak') {
                    if ($entry2['persen_pajak'] != null) {
                        $entry2['persen_pajak'] .= " %";
                    }
                    $entry2['uraian'] = $data_pajak[$entry2['akun']]['nama_akun'];
                    $entry2['tipe'] = 'debet';
                    $data2[] = $entry2;
                    $entry2['tipe'] = 'kredit';
                    $data2[] = $entry2;
                } else {
                    $data2[] = $entry2;
                }
                
            }

            $query = $data2;

            // print_r($data2);die();

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
                    $baru = $entry;
                    $entry = array_merge($baru,$hasil);
                    unset($baru);
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
        }
        return ($data);

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
        // $tabel_relasi_pajak = $this->Laporan_model->get_akun_tabel_relasi($array_akun,'pajak',$unit,$sumber_dana,$start_date,$end_date);  
        $tabel_relasi_pajak = array();       

        // print_r($tabel_utama);die();
        // print_r($tabel_relasi);die();

        $hasil = array_merge($tabel_utama,$tabel_relasi,$tabel_relasi_pajak);


        // print_r($jenis);die();
        // print_r($tabel_relasi);die();


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

    public function get_neraca($array_akun,$jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null,$mode = null)
    {

        $mode = 'saldo';
        $array_tipe  = array('debet','kredit');

        // echo "(tanggal BETWEEN '$start_date' AND '$end_date')";die();

        $year = date("Y");

        $array_jenis = array();
        if ($jenis == null){
            $array_jenis = array('akrual','kas');
        }else {
            $array_jenis[] = $jenis;
        }

        // $array_jenis = array('akrual','kas');

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

        // print_r($array_akun);die();

        

        $data = array();

        $query1 = array();

        if ($mode == 'saldo') {
            $array_saldo = $this->Akun_model->get_saldo_awal_batch($array_akun);
            $saldo = 0;
            foreach ($array_saldo as $akun => $saldo) {
                $case_hutang = in_array(substr($akun,0,1),[2,3,4,6]);
                if ($start_date != "$year-01-01") {
                    $rekap = $this->get_rekap(array($akun),null,'akrual',$unit,'rekap',$sumber_dana,$start_date,$end_date);
                    if ($case_hutang) {
                        $saldo +=  $rekap['kredit']['jumlah'] - $rekap['debet']['jumlah'];
                    } else {
                        $saldo +=  $rekap['debet']['jumlah'] - $rekap['kredit']['jumlah'];
                    }
                }
                $entry['tipe'] = 'debet';
                $entry['jumlah'] = $saldo;
                $entry['akun'] = $akun;
                $query1[$akun][] = $entry[];
            }
        }

        print_r($query1);die();

        //public function get_rekap($array_akun,$array_not_akun = null,$jenis=null,$unit=null,$laporan = null,$sumber_dana = null,$start_date = null, $end_date = null)

        foreach ($array_tipe as $tipe) {
            foreach ($array_jenis as $jenis) {
                foreach ($array_akun as $akun) {
                    $cari = $kolom[$tipe][$jenis];
                    $this->db_laporan->select("*, $cari as akun, sum(jumlah_debet) as jumlah");
                    $this->db_laporan
                        ->where("tipe <> 'memorial' AND tipe <> 'jurnal_umum' AND tipe <> 'pajak' AND tipe <> 'penerimaan' AND tipe <> 'pengembalian'")
                        // ->order_by('no_bukti')
                        ;

                    if ($akun != null){
                        $this->db_laporan->like($kolom[$tipe][$jenis],$akun,'after');
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

                    // $this->db_laporan->where('unit_kerja',$unit);

                    $this->db_laporan->group_by($kolom[$tipe][$jenis]);

                    // echo $this->db_laporan->get_compiled_select();die();

                    $hasil = $this->db_laporan->get('akuntansi_kuitansi_jadi')->result_array();

                    // print_r($hasil);die();

                    for ($i=0; $i < count($hasil); $i++) { 
                        $hasil[$i]['tipe'] = $tipe;
                        $query1[$hasil[$i]['akun']][] = $hasil[$i];
                    }

                }
            }
        }


        $query2 = array();

        $query_pajak1 = "OR tu.tipe = 'pajak'";
        $query_pajak2 = "or tr.jenis = 'pajak'";
        // $iter_pajak = 0;
        // $cur_tipe = 'debet';
        $last_tipe = 'debet';


        foreach ($array_tipe as $tipe) {
            foreach ($array_jenis as $jenis) {
                    foreach ($array_akun as $akun) {
                        $added_query = "";

                        if ($unit != null){
                            $added_query .= "AND tu.unit_kerja = '$unit'";
                        }
                        if ($sumber_dana != null){
                            $added_query .= "AND tu.jenis_pembatasan_dana = '$sumber_dana'";
                        }
                        if ($akun != null){
                            $added_query .= "AND tr.akun LIKE '$akun%'";
                        }
                        if ($start_date != null and $end_date != null){
                            $added_query .= "and tu.tanggal BETWEEN '$start_date' AND '$end_date'";
                        }

                        $query_pajak1 = "OR tu.tipe = 'pajak'";
                        $query_pajak2 = "or tr.jenis = 'pajak'";
                        // $query_pajak1 = "";
                        // $query_pajak2 = "";

                        $query = "SELECT tr.akun,tu.*,tu.tipe as jenis_pajak, sum(jumlah) as jumlah FROM akuntansi_kuitansi_jadi as tu, akuntansi_relasi_kuitansi_akun as tr WHERE
                                 tr.id_kuitansi_jadi = tu.id_kuitansi_jadi 
                                 AND (tu.tipe = 'memorial' OR tu.tipe = 'jurnal_umum' $query_pajak1 OR tu.tipe = 'penerimaan' OR tu.tipe = 'pengembalian')
                                 $added_query 
                                 AND (tr.tipe = '$tipe' $query_pajak2)
                                 GROUP BY tr.akun

                        ";

                        // echo $query."\n";

                        $hasil = $this->db_laporan->query($query)->result_array();

                        // print_r($hasil);die();

                        for ($i=0; $i < count($hasil); $i++) { 
                            $hasil[$i]['tipe'] = $tipe;
                            // if ($hasil[$i]['jenis'] == 'MEMORIAL' AND $tipe == 'kredit') {
                            //     $hasil[$i]['jumlah'] = $hasil[$i]['jumlah']/2;
                            // }
                            if ($hasil[$i]['jenis_pajak'] == 'pajak') {
                                if ($tipe == 'debet') 
                                    $query1[$hasil[$i]['akun']][0] = $hasil[$i];        
                                else
                                    $query1[$hasil[$i]['akun']][1] = $hasil[$i];        
                            } else {
                                $query1[$hasil[$i]['akun']][] = $hasil[$i];                            
                            }
                        }



                }
            }
        }

        // foreach ($query1 as $key => $value) {
        //     $query1[$key] = array_unique($query1[$key],SORT_REGULAR);
        // }

        // foreach ($query1 as $key => $transaksi) {
        //     if (in_array(substr($key,0,1),[1,2,3])) {
        //         $case_hutang = in_array(substr($key,0,1),[2,3,4,6]);
        //         $saldo_awal = $this->Akun_model->get_saldo_awal($key);
        //         if ($saldo_awal != null) {
        //             $saldo_awal = $saldo_awal['saldo_awal'];
        //             if ($case_hutang) {
                        
        //             }
        //         }

        //     }
        // }

        // print_r($hasil);die();

        // print_r($query1);die();
        return $query1;

        // $hasil = array_merge($query1,$query2);
        // print_r($hasil);die();



    }


    public function get_rekap($array_akun,$array_not_akun = null,$jenis=null,$unit=null,$laporan = null,$sumber_dana = null,$start_date = null, $end_date = null)
    {
        $array_tipe  = array('debet','kredit');

        // print_r($laporan);die();

        $array_jenis = array();
        if ($jenis == null){
            $array_jenis = array('akrual','kas');
        }else {
            $array_jenis[] = $jenis;
        }

        $year = date("Y");
        if ($start_date == null) {
            $start_date = "$year-01-01";        
        }elseif ($end_date == null) {
            $end_date = "$year-12-31";        
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

        $query1 = array();

        foreach ($array_tipe as $tipe) {
            foreach ($array_jenis as $jenis) {
                foreach ($array_akun as $akun) {
                    $cari = $kolom[$tipe][$jenis];
                    $this->db_laporan->select("$cari as akun, sum(jumlah_debet) as jumlah");
                    $this->db_laporan
                        ->where("tipe <> 'memorial' AND tipe <> 'jurnal_umum' AND tipe <> 'pajak' AND tipe <> 'penerimaan' AND tipe <> 'pengembalian'")
                        // ->order_by('no_bukti')
                        ;
                    if ($start_date != null and $end_date != null){
                        $this->db_laporan->where("(tanggal BETWEEN '$start_date' AND '$end_date')");
                    }

                    if ($sumber_dana != null){
                        $this->db_laporan->where('jenis_pembatasan_dana',$sumber_dana);
                    }

                    if ($akun != null){
                        $this->db_laporan->like($kolom[$tipe][$jenis],$akun,'after');
                    }

                    if ($array_not_akun != null){
                        $this->db_laporan->not_in($kolom[$tipe][$jenis],$array_not_akun);
                    }

                    if ($unit != null) {
                            $this->db_laporan->where('unit_kerja',$unit);
                        }

                    // $this->db_laporan->where('unit_kerja',$unit);

                    $this->db_laporan->group_by($kolom[$tipe][$jenis]);

                    // echo $this->db_laporan->get_compiled_select();die();

                    $hasil = $this->db_laporan->get('akuntansi_kuitansi_jadi')->result_array();


                    for ($i=0; $i < count($hasil); $i++) { 
                        $hasil[$i]['tipe'] = $tipe;
                        $query1[$hasil[$i]['akun']][] = $hasil[$i];
                    }

                }
            }
        }


        $query2 = array();

        $query_pajak1 = "OR tu.tipe = 'pajak'";
        $query_pajak2 = "or tr.jenis = 'pajak'";
        // $iter_pajak = 0;
        // $cur_tipe = 'debet';
        $last_tipe = 'debet';


        foreach ($array_tipe as $tipe) {
            foreach ($array_jenis as $jenis) {
                    foreach ($array_akun as $akun) {
                        $added_query = "";

                        if ($unit != null){
                            $added_query .= "AND tu.unit_kerja = '$unit'";
                        }
                        if ($akun != null){
                            $added_query .= "AND tr.akun LIKE '$akun%'";
                        }
                        if ($sumber_dana != null){
                            $added_query .= "AND tu.jenis_pembatasan_dana = '$sumber_dana'";
                        }
                        if ($array_not_akun) {
                            $added_query .= "AND tr.akun NOT IN (";
                            foreach ($array_not_akun as $not_akun) {
                                $added_query .= "'$not_akun',";
                            }
                            $added_query = substr($added_query,0,-1);
                            $added_query .= ")";
                        }

                        if ($start_date != null and $end_date != null){
                            $added_query .= "and tu.tanggal BETWEEN '$start_date' AND '$end_date'";
                        }

                        $query_pajak1 = "OR tu.tipe = 'pajak'";
                        $query_pajak2 = "or tr.jenis = 'pajak'";
                        // $query_pajak1 = "";
                        // $query_pajak2 = "";

                        $query = "SELECT tr.akun,tu.tipe as jenis_pajak,sum(jumlah) as jumlah FROM akuntansi_kuitansi_jadi as tu, akuntansi_relasi_kuitansi_akun as tr WHERE
                                 tr.id_kuitansi_jadi = tu.id_kuitansi_jadi 
                                 AND (tu.tipe = 'memorial' OR tu.tipe = 'jurnal_umum' $query_pajak1 OR tu.tipe = 'penerimaan' OR tu.tipe = 'pengembalian')
                                 $added_query 
                                 AND (tr.tipe = '$tipe' $query_pajak2)
                                 GROUP BY tr.akun

                        ";

                        // echo $query."\n";

                        $hasil = $this->db_laporan->query($query)->result_array();

                        for ($i=0; $i < count($hasil); $i++) { 
                            $hasil[$i]['tipe'] = $tipe;
                            $hasil[$i]['jumlah'] = $hasil[$i]['jumlah'];
                            $query1[$hasil[$i]['akun']][] = $hasil[$i];
                        }


                }
            }
        }


        foreach ($query1 as $key => $value) {
            $query1[$key] = array_unique($query1[$key],SORT_REGULAR);
        }



        if ($laporan == 'saldo') {
            $saldo = array();
            foreach ($query1 as $akun => $posisi) {
                $saldo[$akun] = $this->db->select('saldo_awal')->get_where('akuntansi_saldo',array('akun' => $akun, 'tahun' => $year))->row_array()['saldo_awal'];
            }
            $data['saldo'] = $saldo;
        }

        if ($laporan == 'sum') {
            $sum_debet = 0;
            $sum_kredit = 0;
            $sum_saldo = 0;        
            foreach ($query1 as $akun => $sub_query) {
                $sum_saldo +=  $this->db->select('saldo_awal')->get_where('akuntansi_saldo',array('akun' => $akun, 'tahun' => $year))->row_array()['saldo_awal'];
                foreach ($sub_query as $entry) {
                    if ($entry['tipe'] == 'debet') {
                        $sum_debet += $entry['jumlah'];
                    } elseif ($entry['tipe'] == 'kredit'){
                        $sum_kredit += $entry['jumlah'];
                    }
                }
            }
            $data['debet'] = $sum_debet;
            $data['kredit'] = $sum_kredit;
            $data['saldo'] = $sum_saldo;
            return $data;
        }

        $data['posisi'] = $query1;

        // print_r($hasil);die();

        // print_r($query1);die();

        return $data;

        // $hasil = array_merge($query1,$query2);
        // print_r($hasil);die();



    }


    public function get_buku_besar($array_akun,$jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null,$mode = null)
    {
        // echo "(tanggal BETWEEN '$start_date' AND '$end_date')";die();
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

        $query1 = array();

        foreach ($array_jenis as $jenis) {
            foreach ($array_akun as $akun) {
                foreach ($array_tipe as $tipe) {
                    $cari = $kolom[$tipe][$jenis];
                    $this->db_laporan->select("*, $cari as akun, jumlah_debet as jumlah");
                    $this->db_laporan
                        ->where("tipe <> 'memorial' AND tipe <> 'jurnal_umum' AND tipe <> 'pajak' AND tipe <> 'penerimaan' AND tipe <> 'pengembalian'")
                        // ->order_by('no_bukti')
                        ;

                    if ($akun != null){
                        $this->db_laporan->like($kolom[$tipe][$jenis],$akun,'after');
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

                    // $this->db_laporan->where('unit_kerja',$unit);

                    // $this->db_laporan->group_by($kolom[$tipe][$jenis]);

                    // echo $this->db_laporan->get_compiled_select();die();
                    // echo $this->db_laporan->get_compiled_select();die();

                    $hasil = $this->db_laporan->get('akuntansi_kuitansi_jadi')->result_array();

                    for ($i=0; $i < count($hasil); $i++) { 
                        $hasil[$i]['tipe'] = $tipe;
                        $query1[$hasil[$i]['akun']][] = $hasil[$i];
                    }

                }
            }
        }


        $query2 = array();

        foreach ($array_jenis as $jenis) {
                foreach ($array_akun as $akun) {
                    foreach ($array_tipe as $tipe) {
                        $added_query = "";

                        if ($unit != null){
                            $added_query .= "AND tu.unit_kerja = '$unit'";
                        }
                        if ($sumber_dana != null){
                            $added_query .= "AND tu.jenis_pembatasan_dana = '$sumber_dana'";
                        }
                        if ($akun != null){
                            $added_query .= "AND tr.akun LIKE '$akun%'";
                        }
                        if ($start_date != null and $end_date != null){
                            $added_query .= "and tu.tanggal BETWEEN '$start_date' AND '$end_date'";
                        }

                        $query = "SELECT tr.akun,tu.*,tr.jumlah,tu.tipe as jenis_pajak FROM akuntansi_kuitansi_jadi as tu, akuntansi_relasi_kuitansi_akun as tr WHERE
                                 tr.id_kuitansi_jadi = tu.id_kuitansi_jadi 
                                 AND (tu.tipe = 'memorial' OR tu.tipe = 'jurnal_umum' OR tu.tipe = 'pajak' OR tu.tipe = 'penerimaan' OR tu.tipe = 'pengembalian')
                                 $added_query 
                                 AND (tr.tipe = '$tipe' or tr.jenis = 'pajak' )

                        ";


                        $hasil = $this->db_laporan->query($query)->result_array();

                        for ($i=0; $i < count($hasil); $i++) { 
                            $hasil[$i]['tipe'] = $tipe;
                            // if ($hasil[$i]['jenis_pajak'] == 'pajak') {
                            //     $hasil[$i]['jumlah'] = $hasil[$i]['jumlah'] / 2 ;
                            // }
                            $query1[$hasil[$i]['akun']][] = $hasil[$i];
                        }



                }
            }
        }

        foreach ($query1 as $key => $value) {
            usort($query1[$key],function($a,$b){
                $hasil = strcmp($a['tanggal'],$b['tanggal']);
                if ($hasil == 0) {
                    $hasil = strcmp($a['no_bukti'],$b['no_bukti']);
                    if ($hasil == 0) {
                        if ($a['tipe'] == 'kredit') {
                            return 1;
                        }
                    }
                }
                return $hasil;
            });
        }
        
        foreach ($query1 as $key => $value) {
            $query1[$key] = array_unique($query1[$key],SORT_REGULAR);
        }

        
        ksort($query1);
        return $query1;

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

        $this->db_laporan->start_cache();

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

        $this->db_laporan->order_by('akuntansi_kuitansi_jadi.tanggal')->order_by('akuntansi_kuitansi_jadi.no_bukti');

        // $this->db_laporan->limit(0, 50);

        $this->db_laporan->stop_cache();

        $this->db_laporan->where("tipe != 'memorial' AND tipe != 'jurnal_umum' AND tipe != 'pajak' AND tipe != 'pengembalian'");

        $query = $this->db_laporan->get('akuntansi_kuitansi_jadi')->result_array();


        $this->db_laporan->select('*,akuntansi_kuitansi_jadi.tipe as tipe');
        $this->db_laporan->select('akuntansi_relasi_kuitansi_akun.jenis as jenis_relasi');
        $this->db_laporan->select('akuntansi_relasi_kuitansi_akun.tipe as tipe_relasi');

        $this->db_laporan->from('akuntansi_kuitansi_jadi');

        $this->db_laporan->join('akuntansi_relasi_kuitansi_akun','akuntansi_kuitansi_jadi.id_kuitansi_jadi = akuntansi_relasi_kuitansi_akun.id_kuitansi_jadi');

        $query2 = $this->db_laporan->get()->result_array();

        $query = array_merge($query,$query2);

        $i = 0;
        $data = array();
        foreach ($query as $entry) {
            $data[$entry['id_kuitansi_jadi']]['transaksi'] = $entry;
            if ($entry['tipe'] == 'memorial' or $entry['tipe'] == 'jurnal_umum' or $entry['tipe'] == 'pajak' or $entry['tipe'] == 'pengembalian') {

                $in_query = $entry;
                // print_r($in_query);die();

                // if ($entry['tipe'] == 'memorial')  {
                //     echo 'ketemu';
                //     print_r($in_query);
                //     die();
                // }


                if ($entry['tipe'] == 'pajak') {
                    $data2 = array();
                    $entry2['akun'] = $in_query['akun'];
                    $entry2['jumlah'] = $in_query['jumlah'];
                    $entry2['uraian'] = ucwords(str_replace("_", " ", $in_query['jenis_pajak'])) . " " . $in_query['persen_pajak'] . '%';
                    $entry2['tipe'] = 'debet';
                    $data[$entry['id_kuitansi_jadi']]['akun'][] = $entry2;
                    $entry2['tipe'] = 'kredit';
                    $data[$entry['id_kuitansi_jadi']]['akun'][] = $entry2;
                    $in_query = $data2;
                } else {
                    if (in_array($in_query['jenis_relasi'],$array_jenis)) {
                        $entry2['akun'] = $in_query['akun'];
                        $entry2['jumlah'] = $in_query['jumlah'];
                        $entry2['tipe'] = $in_query['tipe_relasi'];
                        $data[$entry['id_kuitansi_jadi']]['akun'][] = $entry2;
                    }
                }
                // $data[$i]['akun'] = array_filter($in_query, function ($row) use ($array_jenis){
                //                                 return in_array($row['jenis'],$array_jenis);
                //                             });
                $entry2 = null;
            }else {
                foreach ($kolom as $key_kolom => $in_kolom) {
                    foreach ($array_jenis as $key_jenis => $in_jenis) {
                        if ($in_jenis != 'pajak') {
                            $isi_akun = array();
                            $isi_akun['tipe'] = $key_kolom;
                            $isi_akun['jenis'] = $in_jenis;
                            $isi_akun['akun'] = $entry[$kolom[$key_kolom][$in_jenis]];
                            $isi_akun['jumlah'] = $entry['jumlah_'.$key_kolom];
                            $data[$entry['id_kuitansi_jadi']]['akun'][] = $isi_akun;
                        }
                    }
                }
            }
            $i++;
        }

        return $data;

    }

    // public function read_rekap_jurnal($jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null)
    // {

    //     $array_jenis = array('pajak');
    //     if ($jenis == null){
    //         $array_jenis = array('akrual','kas');
    //     }else {
    //         $array_jenis[] = $jenis;
    //     }

    //     $kolom = array(
    //         'debet' => array(
    //                 'kas' => 'akun_debet',
    //                 'akrual' => 'akun_debet_akrual',
    //             ),
    //         'kredit' => array(
    //                 'kas' => 'akun_kredit',
    //                 'akrual' => 'akun_kredit_akrual'
    //             ),
    //     );

    //     if ($sumber_dana != null){
    //         $this->db_laporan->where('jenis_pembatasan_dana',$sumber_dana);
    //     }

    //     if ($start_date != null and $end_date != null){
    //         $this->db_laporan->where("(tanggal BETWEEN '$start_date' AND '$end_date')");
    //     }

    //     // if ($jenis != null){
    //     //     $this->db_laporan->where('jenis',$jenis);
    //     // }

    //     if ($unit != null) {
    //         $this->db_laporan->where('unit_kerja',$unit);
    //     }

    //     // if ($unit == '9999') {
    //     //    $this->db_laporan->where('tipe','penerimaan');  
    //     // }

    //     // $this->db_laporan->where("tipe <> 'pajak'");

    //     $this->db_laporan->order_by('tanggal')->order_by('no_bukti');

    //     // die($unit);
    //     // die($this->db_laporan->get_compiled_select());

    //     $query = $this->db_laporan->get('akuntansi_kuitansi_jadi')->result_array();

    //     // print_r($query);die();

    //     $i = 0;
    //     $data = array();
    //     foreach ($query as $entry) {
    //         $data[$i]['transaksi'] = $entry;
    //         if ($entry['tipe'] == 'memorial' or $entry['tipe'] == 'jurnal_umum' or $entry['tipe'] == 'pajak' or $entry['tipe'] == 'pengembalian' or $entry['tipe'] == 'penerimaan') {
    //             $this->db_laporan->where('id_kuitansi_jadi',$entry['id_kuitansi_jadi']);

    //             $in_query = $this->db_laporan->get('akuntansi_relasi_kuitansi_akun')->result_array();

    //             if ($entry['tipe'] == 'pajak') {
    //                 foreach ($in_query as $entry2) {
    //                     // karena pajak dihitung sebagai pemasukan dan pengeluaran jadi diisi debet kredit
    //                     $entry2['uraian'] = $data_pajak[$entry2['akun']]['nama_akun'];
    //                     // $entry2['uraian'] = ucwords(str_replace("_", " ", $entry2['jenis_pajak'])) . " " . $entry2['persen_pajak'];
    //                     $entry2['tipe'] = 'debet';
    //                     $data2[] = $entry2;
    //                     $entry2['tipe'] = 'kredit';
    //                     $data2[] = $entry2;
    //                 }
    //                 $in_query = $data2;
                    
    //             }
    //             $data[$i]['akun'] = array_filter($in_query, function ($row) use ($array_jenis){
    //                                             return in_array($row['jenis'],$array_jenis);
    //                                         });
                
    //             // $data[$i]['akun'] = $in_query;
    //         }else {
    //             foreach ($kolom as $key_kolom => $in_kolom) {
    //                 foreach ($array_jenis as $key_jenis => $in_jenis) {
    //                     if ($in_jenis != 'pajak') {
    //                         $isi_akun = array();
    //                         $isi_akun['tipe'] = $key_kolom;
    //                         $isi_akun['jenis'] = $in_jenis;
    //                         $isi_akun['akun'] = $entry[$kolom[$key_kolom][$in_jenis]];
    //                         $isi_akun['jumlah'] = $entry['jumlah_'.$key_kolom];
    //                         $data[$i]['akun'][] = $isi_akun;
    //                     }
    //                 }
    //             }
    //         }
    //         $i++;
    //     }

    //     return $data;

    // }

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