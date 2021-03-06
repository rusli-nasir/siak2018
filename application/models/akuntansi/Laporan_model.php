   <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->db_laporan = $this->load->database('laporan',TRUE);
        $this->db_pendapatan = $this->load->database('pendapatan',TRUE);
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->load->model('akuntansi/Akun_model', 'Akun_model');

    }

    function read_buku_besar_group($group = null){
        $query = $this->db_laporan->query("SELECT * FROM akuntansi_kuitansi_jadi GROUP BY $group");
        return $query;
    }

    function get_tanggal_input(){
        $query = $this->db_laporan->query("SELECT tanggal_jurnal,max(tanggal) as last_tanggal FROM akuntansi_kuitansi_jadi WHERE jenis = 'jurnal_umum' GROUP BY tanggal_jurnal HAVING COUNT(*) > 1 ORDER BY MONTH(max(tanggal))");
        return $query->result();
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

    public function get_neraca($array_akun,$jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null,$mode = null,$tingkat = null,$sumber = null, $array_tipe_jurnal = null)
    {

        // die('aaa');
        // echo "<pre>";

        if(($sumber_dana=='tidak_terikat' or $sumber_dana == null) and $this->session->userdata('level') == 3 and $unit == null){
            $mode = 'saldo';
        }else{
            $mode = null;
        }
        $array_tipe  = array('debet','kredit');

        $placer = 'akun';
        if ($sumber == 'biaya') {
            $placer = 'kode_akun_sub';
            $group_identifier = 'kode_akun_sub';
            $awal_tahun = $this->session->userdata('setting_tahun')."-01-01";
            $akhir_tahun = $this->session->userdata('setting_tahun')."-12-31";
            // die("BETWEEN $awal_tahun AND $akhir_tahun");
        }

        // $array_tipe_jurnal = array('memorial');

        $array_all_tipe_jurnal = array('pajak','memorial');


        // $sumber = 'biaya';

        if ($sumber == null) {
            $from = 'akuntansi_kuitansi_jadi';
            $from_init = 'akuntansi_kuitansi_jadi';
        }elseif ($sumber == 'biaya') {
            $this->db_laporan->query("DROP TABLE IF EXISTS `temp_biaya`");
            $this->db_laporan->query(" CREATE TABLE temp_biaya AS 
                    (
                    SELECT DISTINCT tabel_kuitansi.*,
                        tabel_akun.kode_akun_sub,
                        tabel_akun.kode_akun as biaya,
                        max(tabel_input.revisi) as revisi 
                    FROM
                        (SELECT *,SUBSTRING(kuitansi.kode_kegiatan,1,16) as kode_subkomponen_input FROM rsa.akuntansi_kuitansi_jadi as kuitansi 
                            HAVING kode_subkomponen_input <>'' AND LENGTH(kode_subkomponen_input) = 16) 
                         AS tabel_kuitansi,
                         rba.ket_subkomponen_input_ as tabel_input,
                         rba.ref_akun as tabel_akun
                    WHERE 
                         (tabel_kuitansi.tanggal BETWEEN '$awal_tahun' AND '$akhir_tahun')
                         AND tabel_kuitansi.kode_subkomponen_input = tabel_input.kode_subkomponen_input
                         AND tabel_input.jenis_biaya = tabel_akun.nama_akun
                         AND tabel_input.jenis_komponen = tabel_akun.nama_akun_sub
                    GROUP BY
                        tabel_input.kode_subkomponen_input
    
                     )");
            // die("selesaaai");
            $from = "temp_biaya";
            $from_init = "temp_biaya as akuntansi_kuitansi_jadi";

        }

        // echo "(tanggal BETWEEN '$start_date' AND '$end_date')";die();

        $year = $this->session->userdata('setting_tahun');

        $array_jenis = array();
        if ($jenis == null){
            $array_jenis = array('akrual','kas');
        }else {
            $array_jenis[] = $jenis;
        }

        if ($tingkat != null or $sumber != null) {
            $array_akun = array(5);
        }

        // $array_akun = array(111102);

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
        $debet = 0;
        $kredit = 0;

        if ($mode == 'saldo' and $tingkat == null) {
            $array_saldo = $this->Akun_model->get_saldo_awal_batch($array_akun);
            foreach ($array_saldo as $akun => $saldo) {
                $entry = array();
                $case_hutang = in_array(substr($akun,0,1),[2,3,4,6]);
                if ($start_date != "$year-01-01") {
                    $rekap = $this->get_rekap(array($akun),null,'akrual',$unit,'rekap',$sumber_dana,$start_date,$end_date);
                    if ($case_hutang) {
                        $saldo +=  $rekap['kredit']['jumlah'] - $rekap['debet']['jumlah'];
                    } else {
                        $saldo +=  $rekap['debet']['jumlah'] - $rekap['kredit']['jumlah'];
                    }
                }
                if ($case_hutang) {
                    $entry['tipe'] = 'kredit';
                } else {
                    $entry['tipe'] = 'debet';
                }
                $entry['jumlah'] = $saldo;
                $entry['akun'] = $akun;
                $entry['tanggal'] = $start_date;
                $entry['uraian'] = "Saldo per ".$this->Jurnal_rsa_model->reKonversiTanggal($start_date);
                $query1[$akun][] = $entry;
            }
        }

        
        if ($tingkat != null) {
            $chart_length_tingkat = array();
            $chart_length_tingkat['tujuan'] = 2;
            $chart_length_tingkat['sasaran'] = 4;
            $chart_length_tingkat['program'] = 6;
            $chart_length_tingkat['kegiatan'] = 8;
            $chart_length_tingkat['subkegiatan'] = 10;

            $length_kegiatan = $chart_length_tingkat[$tingkat];

        }



        

        // return $query1;
        // $query1 = array();

        // echo $debet ."--". $kredit;

        // print_r($query1);die();

        //public function get_rekap($array_akun,$array_not_akun = null,$jenis=null,$unit=null,$laporan = null,$sumber_dana = null,$start_date = null, $end_date = null)

        foreach ($array_tipe as $tipe) {
            foreach ($array_jenis as $jenis) {
                foreach ($array_akun as $akun) {
                    $cari = $kolom[$tipe][$jenis];
                    $added_select = null;
                    if ($tingkat != null ) {
                        $group_tingkat = "substring(kode_kegiatan,7,$length_kegiatan)";
                        $added_select = "substring(kode_kegiatan,7,$length_kegiatan) as tingkat,";
                    }
                    $this->db_laporan->select("$added_select $cari as akun, sum(jumlah_debet) as jumlah");
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

                    if ($tingkat != null){
                        $this->db_laporan->where("kode_kegiatan <> ''");
                    }

                    if ($array_tipe_jurnal != null) {
                        if (in_array('pengeluaran', $array_tipe_jurnal)){
                            $where_tipe = '(1 ';
                            $array_differ_tipe = array_diff($array_all_tipe_jurnal,$array_tipe_jurnal);
                            foreach ($array_differ_tipe as $each_tipe) {
                                $where_tipe.= " AND tipe!='$each_tipe' "; 
                            }
                        }else{
                            $where_tipe = '(0 ';
                            foreach ($array_tipe_jurnal as $each_tipe) {
                                $where_tipe.= " OR tipe='$each_tipe' ";                
                            }
                        }
                        $where_tipe .= ")";
                        // $this->db_laporan->where("kode_kegiatan  ''");
                    }

                    // if ($regex_kegiatan != null){
                    //     $this->db_laporan->where("kode_kegiatan REGEXP '$regex_kegiatan'");   
                    // }


                    // $this->db_laporan->where('unit_kerja',$unit);
                    if ($sumber != null){
                        $in_group_identifier = $group_identifier;
                    }else{
                        $in_group_identifier = $kolom[$tipe][$jenis];
                    }

                    $this->db_laporan->group_by($in_group_identifier);

                    if ($tingkat != null){
                        $this->db_laporan->group_by($group_tingkat);
                    }
                    // echo $this->db_laporan->get_compiled_select();die();

                    // $this->db_laporan->cache_on();

                    $hasil = $this->db_laporan->get($from_init)->result_array();

                    // $this->db_laporan->cache_off();

                    // print_r($hasil);die();

                    for ($i=0; $i < count($hasil); $i++) { 
                        $hasil[$i]['tipe'] = $tipe;
                        if ($tingkat != null){
                            $query1[$hasil[$i]['tingkat']][$hasil[$i][$placer]][] = $hasil[$i];
                        }else {
                            $query1[$hasil[$i][$placer]][] = $hasil[$i];                        
                        }
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

                        $added_select = null;
                        $added_group = null;
                        if ($tingkat != null ) {
                            $group_tingkat = "substring(kode_kegiatan,7,$length_kegiatan)";
                            $added_select = "substring(kode_kegiatan,7,$length_kegiatan) as tingkat,";
                            $added_group = ",substring(kode_kegiatan,7,$length_kegiatan)";
                            $added_query .= "AND tu.kode_kegiatan <> ''";
                        }

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
                        $where_tipe = ' 1 ';
                        if ($array_tipe_jurnal != null) {
                            if (in_array('pengeluaran', $array_tipe_jurnal)){
                                $where_tipe = '(1 ';
                                $array_differ_tipe = array_diff($array_all_tipe_jurnal,$array_tipe_jurnal);
                                foreach ($array_differ_tipe as $each_tipe) {
                                    $where_tipe.= " AND tu.tipe!='$each_tipe' "; 
                                }
                            }else{
                                $where_tipe = '(0 ';
                                foreach ($array_tipe_jurnal as $each_tipe) {
                                    $where_tipe.= " OR tu.tipe='$each_tipe' ";                
                                }
                            }
                            $where_tipe .= ")";
                        }

                        // if ($regex_kegiatan != null){
                        //     $added_query .= "AND kode_kegiatan REGEXP '$regex_kegiatan'";   
                        // }

                        $query_pajak1 = "OR tu.tipe = 'pajak'";
                        $query_pajak2 = "or tr.jenis = 'pajak'";
                        // $query_pajak1 = "";
                        // $query_pajak2 = "";

                        if ($sumber != null){
                            $in_group_identifier = $group_identifier;
                        }else{
                            $in_group_identifier = 'tr.akun';
                        }

                        // $this->db_laporan->cache_on();

                        $query = "SELECT tr.akun,tu.tipe as jenis_pajak,$added_select sum(jumlah) as jumlah FROM $from as tu, akuntansi_relasi_kuitansi_akun as tr WHERE
                                 tr.id_kuitansi_jadi = tu.id_kuitansi_jadi 
                                 AND (tu.tipe = 'memorial' OR tu.tipe = 'jurnal_umum' $query_pajak1 OR tu.tipe = 'penerimaan' OR tu.tipe = 'pengembalian') AND $where_tipe 
                                 $added_query 
                                 AND (tr.tipe = '$tipe' $query_pajak2)
                                 GROUP BY tr.akun $added_group
                        ";

                        // echo $query."\n";

                        $hasil = $this->db_laporan->query($query)->result_array();

                        // $this->db_laporan->cache_off();

                        // echo "<pre>";
                        // print_r($hasil);die();  

                        for ($i=0; $i < count($hasil); $i++) { 
                            $hasil[$i]['tipe'] = $tipe;
                            // if ($hasil[$i]['jenis'] == 'MEMORIAL' AND $tipe == 'kredit') {
                            //     $hasil[$i]['jumlah'] = $hasil[$i]['jumlah']/2;
                            // }
                            if ($hasil[$i]['jenis_pajak'] == 'pajak') {
                                if ($tipe == 'debet') 
                                    $query1[$hasil[$i][$placer]][0] = $hasil[$i];        
                                else
                                    $query1[$hasil[$i][$placer]][1] = $hasil[$i];        
                            } else {
                                if ($tingkat != null){
                                    $query1[$hasil[$i]['tingkat']][$hasil[$i][$placer]][] = $hasil[$i];
                                }else {
                                    $query1[$hasil[$i][$placer]][] = $hasil[$i];                        
                                }
                            }
                            // print_r($query1);die();
                        }



                }
            }
        }

        // die();

        // if ($sumber == 'biaya'){
            // print_r($query1);die();
        // }

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
        // echo "<pre>";
        // print_r($query1);die();
        return $query1;

        // $hasil = array_merge($query1,$query2);
        // print_r($hasil);die();



    }

    public function revamp_get_neraca($array_akun,$jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null,$mode = null,$tingkat = null,$sumber = null)
    {
        if(($sumber_dana=='tidak_terikat' or $sumber_dana == null) and $this->session->userdata('level') == 3 and $unit == null){
            $mode = 'saldo';
        }else{
            $mode = null;
        }
        $array_tipe  = array('debet','kredit');

        $regex_string = '';

        foreach ($array_akun as $entry_akun) {
            $regex_string .= "^".$entry_akun."(.*)|";
        }
        $regex_string = substr($regex_string,0,-1);
        die($regex_string);

        $sql = "
                SELECT 
                    akuntansi_kuitansi_jadi.*,
                    CASE 
                        WHEN akun_debet_akrual = 
        ";
    }

    public function generate_access_buku_besar($tipe)
    {

        return $form_format;
    }


    public function get_rekap($array_akun,$array_not_akun = null,$jenis=null,$unit=null,$laporan = null,$sumber_dana = null,$start_date = null, $end_date = null,$array_uraian = null,$tingkat = null,$sumber = null)
    {
        $array_tipe  = array('debet','kredit');

        // print_r($array_uraian);die();
        // echo $sumber_dana;

        $array_jenis = array();
        if ($jenis == null){
            $array_jenis = array('akrual','kas');
        }else {
            $array_jenis[] = $jenis;
        }

        $year = $this->session->userdata('setting_tahun');

        if ($start_date == null AND $end_date == null) {
            $start_date = "$year-01-01";  
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

        if ($tingkat != null) {
            $chart_length_tingkat = array();
            $chart_length_tingkat['tujuan'] = 2;
            $chart_length_tingkat['sasaran'] = 4;
            $chart_length_tingkat['program'] = 6;
            $chart_length_tingkat['kegiatan'] = 8;
            $chart_length_tingkat['subkegiatan'] = 10;

            $length_kegiatan = $chart_length_tingkat[$tingkat];

        }

        foreach ($array_tipe as $tipe) {
            foreach ($array_jenis as $jenis) {
                foreach ($array_akun as $akun) {
                    $cari = $kolom[$tipe][$jenis];
                    $added_select = null;
                    if ($tingkat != null ) {
                        $group_tingkat = "substring(kode_kegiatan,7,$length_kegiatan)";
                        $added_select = "substring(kode_kegiatan,7,$length_kegiatan) as tingkat,";
                        $cari = $group_tingkat;
                    }
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

                    if ($array_uraian != null and $array_uraian != 'hai'){
                        $where_query = "";
                        $where_query .= "( 0 ";
                        foreach ($array_uraian as $uraian) {
                            $where_query .= " OR uraian LIKE '%".$uraian."%' ";
                        }
                        $where_query .= ")";
                        $this->db_laporan->where($where_query);
                    }

                    if ($akun != null){
                        $this->db_laporan->like($kolom[$tipe][$jenis],$akun,'after');
                    }

                    if ($tingkat != null){
                        // $this->db_laporan->where("kode_kegiatan <> ''");
                        // $this->db_laporan->where("kode_kegiatan NOT LIKE '%0000%'");
                    }else{
                        $this->db_laporan->group_by($kolom[$tipe][$jenis]);
                    }

                    // $this->db_laporan->where("jenis != 'KS'");

                    if ($tingkat != null){
                        $this->db_laporan->group_by($group_tingkat);
                    }

                    if ($array_not_akun != null){
                        foreach ($array_not_akun as $not_akun) {

                            $this->db_laporan->not_like($kolom[$tipe][$jenis],$not_akun,'after');
                        }
                    }

                    if ($unit != null) {
                        $this->db_laporan->where('unit_kerja',$unit);
                    }

                    // $this->db_laporan->where('unit_kerja',$unit);


                    //comment after this
                    // $this->db_laporan->from('akuntansi_kuitansi_jadi');
                    // echo $this->db_laporan->get_compiled_select();
                    // die();
                    //comment
                    // if ($array_uraian != null) {
                        // echo $this->db_laporan->get_compiled_select();
                    // }


                    $hasil = $this->db_laporan->get('akuntansi_kuitansi_jadi')->result_array();


                    for ($i=0; $i < count($hasil); $i++) { 
                        $hasil[$i]['tipe'] = $tipe;
                        $query1[$hasil[$i]['akun']][] = $hasil[$i];
                    }

                }
            }
        }

        // if ($array_uraian == 'hai') {

        //     print_r($query1);die();
        // }


        $query2 = array();

        $query_pajak1 = "OR tu.tipe = 'pajak'";
        $query_pajak2 = "or tr.jenis = 'pajak'";
        // $iter_pajak = 0;
        // $cur_tipe = 'debet';
        $last_tipe = 'debet';

        // echo "<pre>";


        foreach ($array_tipe as $tipe) {
            foreach ($array_jenis as $jenis) {
                    foreach ($array_akun as $akun) {

                        $added_query = "";

                        $added_select =',tr.akun';
                        $added_group = "tr.akun";
                        if ($tingkat != null ) {
                            $group_tingkat = "substring(kode_kegiatan,7,$length_kegiatan)";
                            $added_select = ",substring(kode_kegiatan,7,$length_kegiatan) as akun";
                            $added_group = "substring(kode_kegiatan,7,$length_kegiatan)";
                            // $added_query .= "AND tu.kode_kegiatan <> '' ";
                            // $added_query .= "AND substring(kode_kegiatan,7,$length_kegiatan) NOT LIKE '%000%' ";
                        }

                        if ($unit != null){
                            $added_query .= " AND tu.unit_kerja = '$unit'";
                        }
                        if ($akun != null){
                            $added_query .= " AND tr.akun LIKE '$akun%'";
                        }
                        if ($sumber_dana != null){
                            $added_query .= " AND tu.jenis_pembatasan_dana = '$sumber_dana'";
                        }

                        if ($array_not_akun) {
                            foreach ($array_not_akun as $not_akun) {
                                $added_query .= " AND tr.akun NOT LIKE '$not_akun%' ";
                                $this->db_laporan->not_like($kolom[$tipe][$jenis],$not_akun,'after');
                            }
                        }

                        if ($start_date != null and $end_date != null){
                            $added_query .= " and (tu.tanggal BETWEEN '$start_date' AND '$end_date' )";
                        }

                        if ($array_uraian != null){
                            $added_query .= "AND ( 0 ";
                            foreach ($array_uraian as $uraian) {
                                $added_query .= " OR tu.uraian LIKE '%".$uraian."%' ";
                            }
                            $added_query .= ")";
                        }

                        $query_pajak1 = "OR tu.tipe = 'pajak'";
                        $query_pajak2 = "or tr.jenis = 'pajak'";

                        $query = "SELECT tu.tipe as jenis_pajak $added_select,sum(jumlah) as jumlah FROM akuntansi_kuitansi_jadi as tu, akuntansi_relasi_kuitansi_akun as tr WHERE
                                 tr.id_kuitansi_jadi = tu.id_kuitansi_jadi 
                                 AND (tu.tipe = 'memorial' OR tu.tipe = 'jurnal_umum' $query_pajak1 OR tu.tipe = 'penerimaan' OR tu.tipe = 'pengembalian')
                                 $added_query 
                                 AND (tr.tipe = '$tipe' $query_pajak2)
                                 AND (tr.jenis = '$jenis')
                                 GROUP BY $added_group

                        ";

                        // echo $query;
                        // die($query);

                        $hasil = $this->db_laporan->query($query)->result_array();

                        for ($i=0; $i < count($hasil); $i++) { 
                            $hasil[$i]['tipe'] = $tipe;
                            $hasil[$i]['jumlah'] = $hasil[$i]['jumlah'];
                            $query1[$hasil[$i]['akun']][] = $hasil[$i];
                        }
                }
            }
        }

        // die();


        foreach ($query1 as $key => $value) {
            $query1[$key] = array_unique($query1[$key],SORT_REGULAR);
        }
 
        // if ($array_uraian != null) {
        //     // print_r($array_uraian);die();
            // if ($array_akun == array(7)) {
            //     print_r($query1);die();
            // }
        // }



        if ($laporan == 'saldo' or $laporan == 'anggaran') { // FIX disini biar yang diluar yang ga ada transaksinya ketampil juga
            $saldo = array();
            $temp_saldo = array();
            foreach ($array_akun as $akun) {
                $this->db->like('akun',$akun,'after');
                $this->db->where('tahun',$year);
                $this->db->select('saldo_awal,akun');

                $temp_saldo = array_merge($temp_saldo,$this->db->get('akuntansi_saldo')->result_array());
            }

            // print_r($temp_saldo);die();
            foreach ($query1 as $akun => $posisi) {
                $saldo[$akun] = 0;
            }

            foreach ($temp_saldo as $entry) {
                $saldo[$entry['akun']] = $entry['saldo_awal'];
            }
            $data['saldo'] = $saldo;
        }

        if ($laporan == 'sum') {
            // print_r($array_akun);die();
            $sum_debet = 0;
            $sum_kredit = 0;
            $sum_saldo = 0;    
            $temp_saldo = array();    
            foreach ($array_akun as $akun) {
                $this->db->like('akun',$akun,'after');
                $this->db->where('tahun',$year);
                $this->db->select('saldo_awal,akun');

                $temp_saldo = array_merge($temp_saldo,$this->db->get('akuntansi_saldo')->result_array());
            }


            // print_r($temp_saldo);die();
            $data['saldo'] = 0;

            foreach ($temp_saldo as $entry) {
                $data['saldo'] += $entry['saldo_awal'];
            }

            // print_r($data);

            // $data['saldo'] = $saldo;


            foreach ($query1 as $akun => $sub_query) {
                // $sum_saldo +=  $this->db->select('saldo_awal')->get_where('akuntansi_saldo',array('akun' => $akun, 'tahun' => $year))->row_array()['saldo_awal'];
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
            // $data['saldo'] = $sum_saldo;
            // print_r($array_akun[0]);die();
            $case_hutang = in_array(substr($array_akun[0],0,1),[2,3,4,6]);

            if ($case_hutang) {
                $data['nett'] = ($sum_kredit - $sum_debet);
                $data['balance'] = $data['saldo'] + ($sum_kredit - $sum_debet);
            }else{
                $data['balance'] = $data['saldo'] + ($sum_debet - $sum_kredit);
                $data['nett'] = ($sum_debet - $sum_kredit);
            }

            return $data;
        }

        if ($laporan == 'anggaran') {

            $query_sumber_dana = '';
            if ($sumber_dana != null){
                if ($sumber_dana == 'tidak_terikat'){
                    $query_sumber_dana = "AND sumber_dana IN ('SELAIN-APBN','SPI-SILPA','APBN-LAINNYA')";
                }elseif ($sumber_dana == 'terikat_temporer') {
                    $query_sumber_dana = "AND sumber_dana IN ('APBN-BPPTNBH')";
                }
            }

            

            $tahun = $year;
            $anggaran = array();
            $query_unit = '';
            if ($unit != null){
                $query_unit .= "AND LEFT(kode_usulan_belanja,2) = '$unit'";
            }

            $tabel_sumber_dana = array(
                'tidak_terikat' => array('SELAIN-APBN','SPI-SILPA','APBN-LAINNYA'),
                'terikat_temporer' => array('APBN-BPPTNBH'),
            );

            $added_query = '';

            if ($sumber_dana != null){
                $string_sumber_dana = implode("','",$tabel_sumber_dana[$sumber_dana]);
                $added_query .= " AND rba.detail_belanja_.sumber_dana IN ('$string_sumber_dana')";
            }


            $query_max_unit_revisi  = "SELECT max(revisi) as max_revisi,LEFT(kode_usulan_belanja,2) as unit FROM `detail_belanja_` WHERE 1 $query_unit GROUP BY LEFT(kode_usulan_belanja,2)";
            // die($query_max_unit_revisi);
            $max_revisi = $this->db2->query($query_max_unit_revisi)->result_array();
            $revisi_unit = array();
            $anggaran_temp = array();

            foreach ($max_revisi as $entry_revisi) {
                $revisi_unit[$entry_revisi['unit']] = $entry_revisi['max_revisi'];
            }
            // foreach ($query1 as $akun => $posisi) {
            //     $anggaran[$akun] = 0;
            // }



            foreach ($array_akun as $akun) {
                // ambil dari array akun aja, dikelompokin per akun
                if (substr($akun, 0,1) == 5 ) {

                    $group_by = "SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6)";
                    $selected_query = ",$group_by as akun";
                    if ($tingkat != null){
                        $group_by = "SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,$length_kegiatan)";
                        $selected_query = ",$group_by as akun";
                        $added_query = "AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,$length_kegiatan) NOT LIKE '%0000%'";

                    }

                    // echo "<pre>";

                    foreach ($revisi_unit as $unit => $revisi) {
                        $lenunit = 2;
                        $query = "SELECT SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS jumlah $selected_query  FROM rba.detail_belanja_ WHERE SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6) LIKE '$akun%' AND  SUBSTR(rba.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba.detail_belanja_.tahun = '{$tahun}' AND rba.detail_belanja_.revisi ='{$revisi}' $added_query $query_sumber_dana GROUP BY $group_by";
                        // echo $query."\n";
                        $anggaran_temp = array_merge($anggaran_temp,$this->db2->query($query)->result_array());
                    }
                    // die();


                    // $added_query = "1 ";
                    // $added_query_in = "1 ";


                    // if ($unit != null){
                    //     $lenunit = strlen($unit);
                    //     $added_query .= "AND SUBSTR(rba.detail_belanja_.username,1,{$lenunit}) = '{$unit}' ";
                    //     $added_query_in = "AND SUBSTR(rba.detail_belanja_.username,1,{$lenunit}) = '{$unit}' ";
                    // }


                    // $query = "SELECT SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS jumlah FROM rba.detail_belanja_ WHERE  $added_query AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6) = '{$akun}' AND rba.detail_belanja_.tahun = '{$year}' AND rba.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba.detail_belanja_ AS det2 WHERE $added_query_in AND det2.tahun = '{$year}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6)";

                    // print_r($query);die();

                    // $anggaran[$akun] = $this->db2->query($query)->row_array()['jumlah'];
                } elseif (substr($akun,0,1) == 4 or substr($akun,0,1) == 8) {
                    if ($unit != null) {
                        $this->db_pendapatan->where('LEFT(sukpa,2)',$unit);
                    } 
                    $this->db_pendapatan->like('akun',$akun,'after');
                    if ($this->session->userdata('level') == 1){
                        $this->db_pendapatan->select("0 as jumlah,akun");
                    }else{
                        $this->db_pendapatan->select("SUM(jml_nilai) as jumlah,akun");
                    }
                    $this->db_pendapatan->group_by('akun');

                    // $anggaran[$akun] += $this->db2->get('target')->row_array()['jumlah'];
                    $anggaran_temp = array_merge($anggaran_temp,$this->db_pendapatan->get('target')->result_array());

                    if ($unit != null) {
                        $this->db->where('kode_unit',$unit);
                    } 
                    $this->db->like('akun',$akun,'after');
                    if ($this->session->userdata('level') == 1){
                        $this->db->select("0 as jumlah,akun");
                    }else{
                        $this->db->select("SUM(anggaran) as jumlah,akun");
                    }
                    $this->db->group_by('akun');    

                    $anggaran_temp = array_merge($anggaran_temp,$this->db->get('akuntansi_anggaran')->result_array());                
                } 
            }



            foreach ($anggaran_temp as $entry) {
                $anggaran[$entry['akun']] = 0;
            }

            foreach ($anggaran_temp as $entry) {
                $anggaran[$entry['akun']] += $entry['jumlah'];
            }

            // echo "<pre>";
            // print_r($anggaran);die();
            $data['anggaran'] = $anggaran;
        }

        $data['posisi'] = $query1;

        // print_r($hasil);die();

        // print_r($query1);die();

        return $data;

        // $hasil = array_merge($query1,$query2);
        // print_r($hasil);die();



    }


    public function get_buku_besar($array_akun,$jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null,$mode = null,$regex_kegiatan = null)
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

                    if ($regex_kegiatan != null){
                        $this->db_laporan->where("kode_kegiatan REGEXP '$regex_kegiatan'");   
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

                        if ($regex_kegiatan != null){
                            $added_query .= "AND kode_kegiatan REGEXP '$regex_kegiatan'";   
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

    public function read_rekap_jurnal($jenis=null,$unit=null,$sumber_dana=null,$start_date=null,$end_date=null,$tanggal_jurnal = null,$array_tipe = null)
    {

        // die($tanggal_jurnal);
        // 
        // $array_tipe = array('penerimaan');
        $array_all_tipe = array('pajak','pengembalian','memorial','penerimaan');

        $array_jenis = array('pajak');
        if ($jenis == null){
            $array_jenis = array('akrual','kas');
        }else {
            $array_jenis[] = $jenis;
        }

        $null_pengeluaran = '';

        if ($array_tipe != null) {
            if (in_array('pengeluaran', $array_tipe)){
                $where_tipe = '(1 ';
                $array_differ_tipe = array_diff($array_all_tipe,$array_tipe);
                foreach ($array_differ_tipe as $each_tipe) {
                    $where_tipe.= " AND akuntansi_kuitansi_jadi.tipe!='$each_tipe' "; 
                }
            }else{
                $null_pengeluaran = "AND tipe != 'pengeluaran'";
                
                $where_tipe = '(0 ';
                foreach ($array_tipe as $each_tipe) {
                    $where_tipe.= " OR akuntansi_kuitansi_jadi.tipe='$each_tipe' ";                
                }
            }
            $where_tipe .= ")";
        }

        // die($where_tipe);



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

        if ($tanggal_jurnal != null){
            $start_date = $this->session->userdata('setting_tahun')."-01-01";
            $end_date = $this->session->userdata('setting_tahun')."-12-31";
        }


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

        if ($tanggal_jurnal != null) {
            $this->db_laporan->where('tanggal_jurnal',$tanggal_jurnal);
        }

        // $this->db_laporan->where("tipe <> 'pajak'");

        $this->db_laporan->order_by('akuntansi_kuitansi_jadi.tanggal')->order_by('akuntansi_kuitansi_jadi.no_bukti');

        // $this->db_laporan->limit(0, 50);

        $this->db_laporan->stop_cache();

        $this->db_laporan->where("tipe != 'memorial' AND tipe != 'jurnal_umum' AND tipe != 'penerimaan' $null_pengeluaran AND tipe != 'pajak' AND tipe != 'pengembalian'");

        // echo $this->db_laporan->get_compiled_select();die();

        $query = $this->db_laporan->get('akuntansi_kuitansi_jadi')->result_array();

        // echo "<pre>";
        // print_r($query);die();

        $this->db_laporan->select('*,akuntansi_kuitansi_jadi.tipe as tipe');
        $this->db_laporan->select('akuntansi_relasi_kuitansi_akun.jenis as jenis_relasi');
        $this->db_laporan->select('akuntansi_relasi_kuitansi_akun.tipe as tipe_relasi');

        $this->db_laporan->from('akuntansi_kuitansi_jadi');

        if ($array_tipe != null){
            $this->db_laporan->where($where_tipe);
        }

        $this->db_laporan->join('akuntansi_relasi_kuitansi_akun','akuntansi_kuitansi_jadi.id_kuitansi_jadi = akuntansi_relasi_kuitansi_akun.id_kuitansi_jadi');

        // echo $this->db_laporan->get_compiled_select();die();

        $query2 = $this->db_laporan->get()->result_array();

        $query = array_merge($query,$query2);



        $i = 0;
        $data = array();
        foreach ($query as $entry) {
            $data[$entry['id_kuitansi_jadi']]['transaksi'] = $entry;
            if ($entry['tipe'] == 'memorial' or $entry['tipe'] == 'jurnal_umum' or $entry['tipe'] == 'penerimaan' or $entry['tipe'] == 'pajak' or $entry['tipe'] == 'pengembalian') {

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

        // print_r(end($data));die();

        foreach ($data as $indeks => $entry) {
            if (!isset($entry['akun'])){
                unset($data[$indeks]);
            }
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