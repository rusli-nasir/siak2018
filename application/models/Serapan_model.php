<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Serapan_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
        function get_akun_dikti($sumber_dana,$unit,$tahun,$triwulan){

            $rba = $this->load->database('rba', TRUE);

            $query = "SELECT rba_2018.ref_akun.kode_akun,rba_2018.ref_akun.nama_akun,rba_2018.ref_akun.kode_akun_sub,rba_2018.ref_akun.nama_akun_sub FROM rba_2018.ref_akun GROUP BY rba_2018.ref_akun.kode_akun_sub ORDER BY rba_2018.ref_akun.kode_akun_sub" ;

            // WHERE rba_2018.akun_belanja.sumber_dana = '{$sumber_dana}' 
            
            // echo $query ; die;

            $q = $rba->query($query);
            // var_dump($q); die;
            // echo '<pre>';
            // var_dump($q->result()); 
            // echo '</pre>';die;

            // return $q->result() ;

            $r1 = array();




            foreach($q->result() as $d){
                
                $r = array() ;
                $r['kode_akun'] = $d->kode_akun ;
                $r['nama_akun'] = $d->nama_akun ;
                $r['kode_akun_sub'] = $d->kode_akun_sub ;
                $r['nama_akun_sub'] = $d->nama_akun_sub ;

                // $r['anggaran'] = $this->get_anggaran_dikti($d->kode_akun_sub,$sumber_dana,$unit,$tahun);
                // $r['serapan'] = $this->get_serapan_dikti($d->kode_akun_sub,$sumber_dana,$unit,$tahun,$triwulan);


                $r1[] = (object)$r ;

          }
   // echo '<pre>' ;
   // var_dump((object)$r1); 
   // echo '</pre>' ;
   // die;

          return $r1 ; 

        }
        function get_akun($sumber_dana,$unit,$tahun,$triwulan){

            $rba = $this->load->database('rba', TRUE);

            $query = "SELECT rba_2018.akun_belanja.kode_akun1digit,rba_2018.akun_belanja.nama_akun1digit,rba_2018.akun_belanja.kode_akun2digit,rba_2018.akun_belanja.nama_akun2digit,rba_2018.akun_belanja.kode_akun3digit,rba_2018.akun_belanja.nama_akun3digit,rba_2018.akun_belanja.kode_akun4digit,rba_2018.akun_belanja.nama_akun4digit,rba_2018.akun_belanja.kode_akun5digit,rba_2018.akun_belanja.nama_akun5digit,rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun FROM rba_2018.akun_belanja WHERE rba_2018.akun_belanja.sumber_dana = '{$sumber_dana}' AND rba_2018.akun_belanja.kode_akun1digit = '5'  GROUP BY rba_2018.akun_belanja.kode_akun ORDER BY rba_2018.akun_belanja.kode_akun" ;
            
            //echo $query ; die;

            $q = $rba->query($query);
            // var_dump($q); die;
            // echo '<pre>';
            // var_dump($q->result()); 
            // echo '</pre>';die;

            // return $q->result() ;


            $r1 = array();

            foreach($q->result() as $d){

                $r = array() ;
                $r['kode_akun1digit'] = $d->kode_akun1digit ;
                $r['nama_akun1digit'] = $d->nama_akun1digit ;
                $r['kode_akun2digit'] = $d->kode_akun2digit ;
                $r['nama_akun2digit'] = $d->nama_akun2digit ;
                $r['kode_akun3digit'] = $d->kode_akun3digit ;
                $r['nama_akun3digit'] = $d->nama_akun3digit ;
                $r['kode_akun4digit'] = $d->kode_akun4digit ;
                $r['nama_akun4digit'] = $d->nama_akun4digit ;
                $r['kode_akun5digit'] = $d->kode_akun5digit ;
                $r['nama_akun5digit'] = $d->nama_akun5digit ;
                $r['kode_akun'] = $d->kode_akun ;
                $r['nama_akun'] = $d->nama_akun ;

                // $r['anggaran'] = $this->get_anggaran($d->kode_akun,$sumber_dana,$unit,$tahun);
                // $r['serapan'] = $this->get_serapan($d->kode_akun,$sumber_dana,$unit,$tahun,$triwulan);


                $r1[] = (object)$r ;

          }
   // echo '<pre>' ;
   // var_dump((object)$r1); 
   // echo '</pre>' ;
   // die;

          return $r1 ; 

        }

        function get_data_anggaran_serapan($sumber_dana,$unit,$tahun,$triwulan){

            $rba = $this->load->database('rba', TRUE);

            $query = "SELECT rba_2018.akun_belanja.kode_akun1digit,rba_2018.akun_belanja.nama_akun1digit,rba_2018.akun_belanja.kode_akun2digit,rba_2018.akun_belanja.nama_akun2digit,rba_2018.akun_belanja.kode_akun3digit,rba_2018.akun_belanja.nama_akun3digit,rba_2018.akun_belanja.kode_akun4digit,rba_2018.akun_belanja.nama_akun4digit,rba_2018.akun_belanja.kode_akun5digit,rba_2018.akun_belanja.nama_akun5digit,rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun FROM rba_2018.akun_belanja WHERE rba_2018.akun_belanja.sumber_dana = '{$sumber_dana}' AND (rba_2018.akun_belanja.kode_akun1digit = '5' OR rba_2018.akun_belanja.kode_akun1digit = '8') GROUP BY rba_2018.akun_belanja.kode_akun ORDER BY rba_2018.akun_belanja.kode_akun" ;
            
            //echo $query ; die;

            $q = $rba->query($query);
            $z = $q->result();
            // var_dump($q); die;
            // echo '<pre>';
            // var_dump($q->result()); 
            // echo '</pre>';die;

            // return $q->result() ;


            // $r1 = array();
            // vdebug($z);

            $lenunit = strlen($unit);
            if($triwulan == '1'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-03-31 23:59:59' )" ;
            }elseif($triwulan == '2'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-06-30 23:59:59' )" ;
            }elseif($triwulan == '3'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-09-30 23:59:59' )" ;
            }elseif($triwulan == '4'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-12-31 23:59:59' )" ;
            }elseif($triwulan == '5'){
                $nw = date('Y-m-d H:i:s');
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '{$nw}' )" ;
            }

            if ($unit != 99) {
                $where_unit_1 = 'AND SUBSTR(t1.username,1,'.$lenunit.') = '.$unit;
                $where_unit_2 = 'AND SUBSTR(t2.username,1,'.$lenunit.') = '.$unit;
            }else{
                $where_unit_1 = '';
                $where_unit_2 = '';
            }

            $query_anggaran = "
                SELECT tbakun.kode_akun4digit,IF(ISNULL(tbjml.jml),0,tbjml.jml) AS jum
                FROM rba_2018.akun_belanja AS tbakun
                LEFT JOIN ( SELECT tba.akun,SUM(tba.jumlah) AS jml
                            FROM (
                                    SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit,
                                        SUBSTR(t1.kode_usulan_belanja,-6,4) AS akun,
                                        SUM(t1.harga_satuan * t1.volume) AS jumlah, 
                                        t1.revisi AS revisi 
                                    FROM detail_belanja_ AS t1 
                                    WHERE t1.sumber_dana = '{$sumber_dana}' 
                                        AND t1.tahun = '{$tahun}' 
                                        {$where_unit_1}
                                    GROUP BY SUBSTR(t1.kode_usulan_belanja,-6,4),SUBSTR(t1.kode_usulan_belanja,1,2),t1.revisi 
                                    ORDER BY SUBSTR(t1.kode_usulan_belanja,1,2),SUBSTR(t1.kode_usulan_belanja,-6,4),t1.revisi
                                    ) AS tba 
                            JOIN ( 
                                    SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, MAX(t2.revisi) AS revisi 
                                    FROM detail_belanja_ AS t2 
                                    WHERE t2.sumber_dana = '{$sumber_dana}' 
                                        AND t2.tahun = '{$tahun}'
                                        {$where_unit_2}
                                    GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2) 
                                    ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2) ) AS tbb 
                                ON tba.kdunit = tbb.kdunit AND tba.revisi = tbb.revisi 
                            GROUP BY tba.akun ORDER BY tba.akun 
                            ) AS tbjml 
                    ON tbakun.kode_akun4digit = tbjml.akun
                WHERE tbakun.kode_akun1digit = '5' OR tbakun.kode_akun1digit = '8'
                GROUP BY tbakun.kode_akun4digit 
                ORDER BY tbakun.kode_akun4digit" ;

            $query_anggaran = $rba->query($query_anggaran);
            $anggaran = $query_anggaran->result();
            // vdebug($anggaran);

            $query_serapan = "SELECT tbakun.kode_akun,IF(ISNULL(tbjml.jml),0,tbjml.jml) AS jum 
                            FROM rba_2018.akun_belanja AS tbakun 
                            LEFT JOIN (
                                        SELECT tba.akun,SUM(tba.jumlah) AS jml 
                                        FROM (  
                                                SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit, 
                                                        SUBSTR(t1.kode_usulan_belanja,-6,6) AS akun, 
                                                        SUM(t1.harga_satuan * t1.volume) AS jumlah, 
                                                        t1.revisi AS revisi 
                                                FROM rsa_detail_belanja_ AS t1 
                                                WHERE t1.sumber_dana = '{$sumber_dana}' 
                                                    AND SUBSTR(t1.proses,1,1) = '6'
                                                    {$str}
                                                    AND t1.tahun = '{$tahun}'
                                                    {$where_unit_1}
                                                GROUP BY SUBSTR(t1.kode_usulan_belanja,-6,6),SUBSTR(t1.kode_usulan_belanja,1,2),t1.revisi 
                                                ORDER BY SUBSTR(t1.kode_usulan_belanja,1,2),SUBSTR(t1.kode_usulan_belanja,-6,6),t1.revisi
                                            ) AS tba 
                                        JOIN ( 
                                                SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, 
                                                        MAX(t2.revisi) AS revisi 
                                                FROM rsa_detail_belanja_ AS t2 
                                                WHERE t2.sumber_dana = '{$sumber_dana}' 
                                                    AND t2.tahun = '{$tahun}'
                                                    {$where_unit_2}
                                                GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2) 
                                                ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2)
                                            ) AS tbb 
                                            ON tba.kdunit = tbb.kdunit 
                                            AND tba.revisi = tbb.revisi 
                                        GROUP BY tba.akun 
                                        ORDER BY tba.akun
                                    ) AS tbjml 
                            ON tbakun.kode_akun = tbjml.akun 
                            WHERE tbakun.kode_akun1digit = '5' OR tbakun.kode_akun1digit = '8'
                            GROUP BY tbakun.kode_akun 
                            ORDER BY tbakun.kode_akun" ;
                            // vdebug($query_serapan);
            $query_serapan = $this->db->query($query_serapan);
            $serapan = $query_serapan->result();

            // vdebug($serapan);

            foreach($z as $d){
                $data[$d->kode_akun1digit] = array(
                    'nama_akun1d'=>$d->nama_akun1digit,
                    'anggaran'=> 0,
                    'serapan'=> 0,
                );
                // $rr = array_unique($x);
            }
            // 
            // vdebug($data);

            $serapan_all = 0;
            $anggaran_all = 0;
            foreach ($data as $key_1d => $value_1d) {
            	$serapan_1d	 = 0;
            	$anggaran_1d = 0;
                foreach($z as $d){
                    if ($key_1d == substr($d->kode_akun2digit, 0,1)) {
                        $data[$key_1d]['data'][$d->kode_akun2digit] = array(
                            'nama_akun2d'=>$d->nama_akun2digit,
                            'anggaran'=> 0,
                            'serapan'=> 0,
                        );

                    }
                }
                foreach ($data[$key_1d]['data'] as $key_2d => $value_2d) {
	                $serapan_2d	 = 0;
	            	$anggaran_2d = 0;

                    foreach($z as $d){
                        if ($key_2d == substr($d->kode_akun3digit, 0,2)) {
                            $data[$key_1d]['data'][$key_2d]['data'][$d->kode_akun3digit] = array(
                                'nama_akun3d'=>$d->nama_akun3digit,
                                'anggaran'=> 0,
                                'serapan'=> 0,
                            );
                        }
                    }

                    foreach ($data[$key_1d]['data'][$key_2d]['data'] as $key_3d => $value_3d) {
                        $serapan_3d  = 0;
                        $anggaran_3d = 0;

                        foreach($z as $d){
                            if ($key_3d == substr($d->kode_akun4digit, 0,3)) {
                                $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$d->kode_akun4digit] = array(
                                    'nama_akun4d'=>$d->nama_akun4digit,
                                    'anggaran'=> 0,
                                    'serapan'=> 0,
                                );
                            }
                        }

                        foreach ($data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'] as $key_4d => $value_4d) {
                        	$serapan_4d = 0;

                            foreach($z as $d){
                                if ($key_4d == substr($d->kode_akun5digit, 0,4)) {
                                    $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$d->kode_akun5digit] = array(
                                        'nama_akun5d'=>$d->nama_akun5digit,
                                        'serapan'=> 0,
                                    );
                                }
                            }

                            foreach ($data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'] as $key_5d => $value_5d) {
                            	$serapan_5d = 0;

                                foreach($z as $d){
                                    if ($key_5d == substr($d->kode_akun, 0,5)) {
                                        $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$key_5d]['data'][$d->kode_akun] = array(
                                            'nama_akun6d'=>$d->nama_akun,
                                            'serapan'=> 0,
                                        );

                                        foreach($serapan as $result_serapan){
                                            if ($d->kode_akun == $result_serapan->kode_akun) {
                                                $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$key_5d]['data'][$d->kode_akun]['serapan'] = $result_serapan->jum;
                                            }
                                        }

                                        $serapan_all = $serapan_all + $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$key_5d]['data'][$d->kode_akun]['serapan'];

                                        $serapan_1d = $serapan_1d + $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$key_5d]['data'][$d->kode_akun]['serapan'];
                                        $data[$key_1d]['serapan'] = $serapan_1d;

                                        $serapan_2d = $serapan_2d + $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$key_5d]['data'][$d->kode_akun]['serapan'];
                                        $data[$key_1d]['data'][$key_2d]['serapan'] = $serapan_2d;

                                        $serapan_3d = $serapan_3d + $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$key_5d]['data'][$d->kode_akun]['serapan'];
                                        $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['serapan'] = $serapan_3d;

                                        $serapan_4d = $serapan_4d + $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$key_5d]['data'][$d->kode_akun]['serapan'];
                                        $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['serapan'] = $serapan_4d;

                                        $serapan_5d = $serapan_5d + $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$key_5d]['data'][$d->kode_akun]['serapan'];
                                        $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$key_5d]['serapan'] = $serapan_5d;
                                    }
                                }
                            }

                            foreach($anggaran as $result_anggaran){
                                if ($key_4d == $result_anggaran->kode_akun4digit) {
                                    $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['anggaran'] = $result_anggaran->jum;
                                }
                            }

                            $anggaran_all = $anggaran_all + $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['anggaran'];

                            $anggaran_1d = $anggaran_1d + $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['anggaran'];
                            $data[$key_1d]['anggaran'] = $anggaran_1d;

                            $anggaran_2d = $anggaran_2d + $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['anggaran'];
                            $data[$key_1d]['data'][$key_2d]['anggaran'] = $anggaran_2d;

                            $anggaran_3d = $anggaran_3d + $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['anggaran'];
                            $data[$key_1d]['data'][$key_2d]['data'][$key_3d]['anggaran'] = $anggaran_3d;
                        }
                    }
                }
            }
            // vdebug(count($data[5]['data'][52]['data'][521]['data'][5217]['data'][52171]['data']));
            
            // $r1 = (object)$rr ;
   // echo '<pre>' ;
   // var_dump((object)$r1); 
   // echo '</pre>' ;
   // die;

        $fulldata['anggaran']    = $anggaran_all;
        $fulldata['serapan']    = $serapan_all;
        $fulldata['data']    = $data;
        // vdebug($fulldata);

        return (object) $fulldata;

        }
        
        // function get_anggaran($kode_akun,$sumber_dana,$unit,$tahun){
        function get_anggaran($sumber_dana,$unit,$tahun){

            $rba = $this->load->database('rba', TRUE);

            // $jum = 0 ;

            $res = array();

            if($unit != '99'){

                $lenunit = strlen($unit);

                // $query = "SELECT SUM(rba_2018.detail_belanja_.volume*rba_2018.detail_belanja_.harga_satuan) AS jum FROM rba_2018.detail_belanja_ WHERE SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND  SUBSTR(rba_2018.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' AND rba_2018.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,19,6)" ;

                // echo '<pre>' ;
                // echo $query ; 
                // echo '</pre>' ; 

                // echo '<br>' ; 
                // echo '<br>' ; 

                // $q = $rba->query($query);

                // $jum = empty($q->num_rows())?'0':$q->row()->jum ;

                $query = "
                SELECT tbakun.kode_akun,IF(ISNULL(tbjml.jml),0,tbjml.jml) AS jum
                FROM rba_2018.akun_belanja AS tbakun
                LEFT JOIN ( SELECT tba.akun,SUM(tba.jumlah) AS jml
                            FROM (
                                    SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit,
                                        RIGHT(t1.kode_usulan_belanja,6) AS akun,
                                        SUM(t1.harga_satuan * t1.volume) AS jumlah, 
                                        t1.revisi AS revisi 
                                    FROM detail_belanja_ AS t1 
                                    WHERE SUBSTR(t1.username,1,{$lenunit}) = '{$unit}' 
                                        AND t1.sumber_dana = '{$sumber_dana}' 
                                        AND t1.tahun = '{$tahun}' 
                                        GROUP BY RIGHT(t1.kode_usulan_belanja,6),SUBSTR(t1.kode_usulan_belanja,1,2),t1.revisi 
                                        ORDER BY SUBSTR(t1.kode_usulan_belanja,1,2),RIGHT(t1.kode_usulan_belanja,6),t1.revisi
                                    ) AS tba 
                            JOIN ( 
                                    SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, MAX(t2.revisi) AS revisi 
                                    FROM detail_belanja_ AS t2 
                                    WHERE SUBSTR(t2.username,1,{$lenunit}) = '{$unit}' 
                                        AND t2.sumber_dana = '{$sumber_dana}' 
                                        AND t2.tahun = '{$tahun}' 
                                    GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2) 
                                    ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2) ) AS tbb 
                                ON tba.kdunit = tbb.kdunit AND tba.revisi = tbb.revisi 
                                GROUP BY tba.akun ORDER BY tba.akun 
                                    ) AS tbjml 
                    ON tbakun.kode_akun = tbjml.akun 
                GROUP BY tbakun.kode_akun 
                ORDER BY tbakun.kode_akun" ;

                // echo $query ; die ;

                $q = $rba->query($query);
                // vdebug($q->result());
                $arr = array();
                foreach($q->result() as $a){
                    $arr[$a->kode_akun] = $a->jum ;
                }

                $res = $arr ;


            }else{

                // $query = "SELECT rba_2018.unit.kode_unit FROM rba_2018.unit GROUP BY rba_2018.unit.kode_unit ORDER BY rba_2018.unit.kode_unit" ; 

                // $q = $rba->query($query);

                // if(!empty($q->num_rows())){



                //     // $i = 1;

                //     // var_dump($q->result_array()); die;

                //     $t = 0 ; 

                //     $units = $q->result_array() ;

                //     foreach($units AS $u){

                //         $unit = $u['kode_unit'] ;

                //         $lenunit = strlen($unit);

                //         $query = "SELECT SUM(rba_2018.detail_belanja_.volume*rba_2018.detail_belanja_.harga_satuan) AS jum FROM rba_2018.detail_belanja_ WHERE SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND  SUBSTR(rba_2018.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' AND rba_2018.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,19,6)" ;

                //         // echo $query ; echo '<br>' ; echo '<br>' ;

                //         $q2 = $rba->query($query);

                //         $t2 = (int)empty($q2->num_rows())?'0':(int)$q2->row()->jum ; 


                //         $t = $t + $t2 ;

                //         // $jum = $jum + (int)empty($q2->num_rows())?'0':$q2->row()->jum ;

                //         // echo $unit ; die ;

                //         // $i = $i + empty($q2->num_rows())?0:(int)$q2->row()->jum ;

                //         // $s = $s . $unit ;

                //         // $jum = $jum + 1 ; 

                //         // $jum = $jum + empty($q2->num_rows())?0:(int)$q2->row()->jum ;

                        

                //     }

                //     $jum = $t ; 


                //     // echo $i ; die ;

                //     // echo $jum ; die ;

                       
                // }

                // echo $sumber_dana .' - '. $unit .' - '. $tahun ; 

                // echo '<br>';

                $query = "SELECT tbakun.kode_akun,IF(ISNULL(tbjml.jml),0,tbjml.jml) AS jum 
                FROM rba_2018.akun_belanja AS tbakun 
                LEFT JOIN (
                            SELECT tba.akun,SUM(tba.jumlah) AS jml 
                            FROM (  
                                SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit,
                                    RIGHT(t1.kode_usulan_belanja,6) AS akun, 
                                    SUM(t1.harga_satuan * t1.volume) AS jumlah, 
                                    t1.revisi AS revisi 
                                FROM detail_belanja_ AS t1 
                                WHERE t1.sumber_dana = '{$sumber_dana}' 
                                AND t1.tahun = '{$tahun}' 
                                GROUP BY RIGHT(t1.kode_usulan_belanja,6),SUBSTR(t1.kode_usulan_belanja,1,2),t1.revisi 
                                ORDER BY SUBSTR(t1.kode_usulan_belanja,1,2),RIGHT(t1.kode_usulan_belanja,6),t1.revisi
                                ) AS tba 
                            JOIN (
                                SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, MAX(t2.revisi) AS revisi 
                                FROM detail_belanja_ AS t2 
                                WHERE t2.sumber_dana = '{$sumber_dana}' 
                                AND t2.tahun = '{$tahun}' 
                                GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2) 
                                ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2) 
                                ) AS tbb 
                                ON tba.kdunit = tbb.kdunit 
                            AND tba.revisi = tbb.revisi 
                            GROUP BY tba.akun ORDER BY tba.akun
                            ) AS tbjml 
                    ON tbakun.kode_akun = tbjml.akun 
                GROUP BY tbakun.kode_akun 
                ORDER BY tbakun.kode_akun" ;

                // echo $query ; die ;

                $q = $rba->query($query);
                // vdebug($q->result());

                $arr = array();
                foreach($q->result() as $a){
                    $arr[$a->kode_akun] = $a->jum ;
                }

                $res = $arr ;


            }

            // echo '<pre>'; var_dump($arr); die;


            return $res ; 

        }
        // function get_anggaran_dikti($kode_akun,$sumber_dana,$unit,$tahun){
        function get_anggaran_dikti($sumber_dana,$unit,$tahun){

            $rba = $this->load->database('rba', TRUE);

            // $jum = 0 ;

            $res = array();

            if($unit != '99'){

                $lenunit = strlen($unit);

                // $query = "SELECT SUM(rba_2018.detail_belanja_.volume*rba_2018.detail_belanja_.harga_satuan) AS jum FROM rba_2018.detail_belanja_ JOIN rba_2018.ket_subkomponen_input_ ON rba_2018.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,1,16) JOIN rba_2018.ref_akun ON rba_2018.ket_subkomponen_input_.jenis_biaya = rba_2018.ref_akun.nama_akun AND rba_2018.ket_subkomponen_input_.jenis_komponen = rba_2018.ref_akun.nama_akun_sub WHERE rba_2018.ref_akun.kode_akun_sub = '{$kode_akun}' AND SUBSTR(rba_2018.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' AND rba_2018.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) AND rba_2018.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rba_2018.detail_belanja_ AS det3 WHERE SUBSTR(det3.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY LEFT(det3.kode_usulan_belanja,2) ) GROUP BY rba_2018.ref_akun.kode_akun_sub" ;

                // $q = $rba->query($query);

                // $jum = empty($q->num_rows())?'0':$q->row()->jum ;

                $query = "SELECT tc1.kode_akun,tc1.kode_akun_sub,tc2.jml AS jum FROM ref_akun AS tc1 LEFT JOIN( SELECT tba.jenis_biaya, tba.jenis_komponen,SUM(tba.jumlah) AS jml FROM ( SELECT tba1.kdunit,tba1.kdusul,tba1.jumlah,tba1.revisi,tba2.jenis_biaya,tba2.jenis_komponen FROM ( SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit,SUBSTR(t1.kode_usulan_belanja,1,16) AS kdusul, SUM(t1.harga_satuan * t1.volume) AS jumlah, t1.revisi AS revisi FROM detail_belanja_ AS t1 WHERE SUBSTR(t1.username,1,{$lenunit}) = '{$unit}' AND t1.sumber_dana = '{$sumber_dana}' AND t1.tahun = '{$tahun}' GROUP BY SUBSTR(t1.kode_usulan_belanja,1,16), t1.revisi ORDER BY SUBSTR(t1.kode_usulan_belanja,1,2),SUBSTR(t1.kode_usulan_belanja,1,16) ) AS tba1 JOIN ket_subkomponen_input_ AS tba2 ON tba1.kdusul = tba2.kode_subkomponen_input AND  tba1.revisi = tba2.revisi ORDER BY tba1.kdunit,tba1.kdusul ) AS tba JOIN ( SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, MAX(t2.revisi) AS revisi FROM detail_belanja_ AS t2 WHERE SUBSTR(t2.username,1,{$lenunit}) = '{$unit}' AND t2.sumber_dana = '{$sumber_dana}' AND t2.tahun = '{$tahun}' GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2) ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2) ) AS tbb ON tba.kdunit = tbb.kdunit AND tba.revisi = tbb.revisi GROUP BY tba.jenis_biaya, tba.jenis_komponen ORDER BY tba.jenis_biaya, tba.jenis_komponen ) AS tc2 ON tc1.nama_akun = tc2.jenis_biaya AND tc1.nama_akun_sub = tc2.jenis_komponen" ;

                // echo $query ; die ;

                $q = $rba->query($query);

                $arr = array();
                foreach($q->result() as $a){
                    $arr[$a->kode_akun_sub] = $a->jum ;
                }

                $res = $arr ;



                // "SELECT SUM(rba_2018.detail_belanja_.volume*rba_2018.detail_belanja_.harga_satuan) AS jum FROM rba_2018.detail_belanja_ WHERE SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND  SUBSTR(rba_2018.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' AND rba_2018.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,19,6)" ;

                //echo $query ; die;

            }else{
                // $query = "SELECT SUM(rba_2018.detail_belanja_.volume*rba_2018.detail_belanja_.harga_satuan) AS jum FROM rba_2018.detail_belanja_ JOIN rba_2018.ket_subkomponen_input_ ON rba_2018.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,1,16) JOIN rba_2018.ref_akun ON rba_2018.ket_subkomponen_input_.jenis_biaya = rba_2018.ref_akun.nama_akun AND rba_2018.ket_subkomponen_input_.jenis_komponen = rba_2018.ref_akun.nama_akun_sub WHERE rba_2018.ref_akun.kode_akun_sub = '{$kode_akun}' AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' AND rba_2018.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY det2.tahun ) AND rba_2018.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rba_2018.detail_belanja_ AS det3 WHERE det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY det3.tahun ) GROUP BY rba_2018.ref_akun.kode_akun_sub" ;

                // $query = "SELECT rba_2018.unit.kode_unit FROM rba_2018.unit GROUP BY rba_2018.unit.kode_unit ORDER BY rba_2018.unit.kode_unit" ; 

                // $q = $rba->query($query);

                // if(!empty($q->num_rows())){


                //     $t = 0 ; 

                //     $units = $q->result_array() ;

                //     foreach($units AS $u){

                //         $unit = $u['kode_unit'] ;

                //         $lenunit = strlen($unit);

                //         $query = "SELECT SUM(rba_2018.detail_belanja_.volume*rba_2018.detail_belanja_.harga_satuan) AS jum FROM rba_2018.detail_belanja_ JOIN rba_2018.ket_subkomponen_input_ ON rba_2018.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,1,16) JOIN rba_2018.ref_akun ON rba_2018.ket_subkomponen_input_.jenis_biaya = rba_2018.ref_akun.nama_akun AND rba_2018.ket_subkomponen_input_.jenis_komponen = rba_2018.ref_akun.nama_akun_sub WHERE rba_2018.ref_akun.kode_akun_sub = '{$kode_akun}' AND SUBSTR(rba_2018.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' AND rba_2018.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) AND rba_2018.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rba_2018.detail_belanja_ AS det3 WHERE SUBSTR(det3.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY LEFT(det3.kode_usulan_belanja,2) ) GROUP BY rba_2018.ref_akun.kode_akun_sub" ;

                //         // echo $query ; die ;

                //         $q2 = $rba->query($query);

                //         $t2 = (int)empty($q2->num_rows())?'0':(int)$q2->row()->jum ; 


                //         $t = $t + $t2 ;

                //     }

                //     $jum = $t ; 

                       
                // }

                $query = "SELECT tc1.kode_akun,tc1.kode_akun_sub,tc2.jml AS jum FROM ref_akun AS tc1 LEFT JOIN( SELECT tba.jenis_biaya, tba.jenis_komponen,SUM(tba.jumlah) AS jml FROM ( SELECT tba1.kdunit,tba1.kdusul,tba1.jumlah,tba1.revisi,tba2.jenis_biaya,tba2.jenis_komponen FROM ( SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit,SUBSTR(t1.kode_usulan_belanja,1,16) AS kdusul, SUM(t1.harga_satuan * t1.volume) AS jumlah, t1.revisi AS revisi FROM detail_belanja_ AS t1 WHERE t1.sumber_dana = '{$sumber_dana}' AND t1.tahun = '{$tahun}' GROUP BY SUBSTR(t1.kode_usulan_belanja,1,16), t1.revisi ORDER BY SUBSTR(t1.kode_usulan_belanja,1,2),SUBSTR(t1.kode_usulan_belanja,1,16) ) AS tba1 JOIN ket_subkomponen_input_ AS tba2 ON tba1.kdusul = tba2.kode_subkomponen_input AND  tba1.revisi = tba2.revisi ORDER BY tba1.kdunit,tba1.kdusul ) AS tba JOIN ( SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, MAX(t2.revisi) AS revisi FROM detail_belanja_ AS t2 WHERE t2.sumber_dana = '{$sumber_dana}' AND t2.tahun = '{$tahun}' GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2) ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2) ) AS tbb ON tba.kdunit = tbb.kdunit AND tba.revisi = tbb.revisi GROUP BY tba.jenis_biaya, tba.jenis_komponen ORDER BY tba.jenis_biaya, tba.jenis_komponen ) AS tc2 ON tc1.nama_akun = tc2.jenis_biaya AND tc1.nama_akun_sub = tc2.jenis_komponen" ;

                // echo $query ; die ;

                $q = $rba->query($query);

                $arr = array();
                foreach($q->result() as $a){
                    $arr[$a->kode_akun_sub] = $a->jum ;
                }

                $res = $arr ;

            }


            return $res ; 
            // return 0 ;
        }
        
        // function get_serapan($kode_akun,$sumber_dana,$unit,$tahun,$triwulan){
        function get_serapan($sumber_dana,$unit,$tahun,$triwulan){

            // $rba = $this->load->database('rba', TRUE);

            $str = '' ;

            // $jum = 0 ;

            $res = array();

            if($triwulan == '1'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-03-31 23:59:59' )" ;
            }elseif($triwulan == '2'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-06-30 23:59:59' )" ;
            }elseif($triwulan == '3'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-09-30 23:59:59' )" ;
            }elseif($triwulan == '4'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-12-31 23:59:59' )" ;
            }elseif($triwulan == '5'){
                $nw = date('Y-m-d H:i:s');
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '{$nw}' )" ;
            }

            if($unit != '99'){

                $lenunit = strlen($unit);

                // $query = "SELECT SUM(rsa_2018.rsa_detail_belanja_.volume*rsa_2018.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa_2018.rsa_detail_belanja_ WHERE SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND  SUBSTR(rsa_2018.rsa_detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rsa_2018.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_2018.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa_2018.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." AND rsa_2018.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,19,6)" ;

                // $q = $this->db->query($query);

                // $jum = empty($q->num_rows())?'0':$q->row()->jum ;

                $query = "SELECT tbakun.kode_akun,IF(ISNULL(tbjml.jml),0,tbjml.jml) AS jum FROM rba_2018.akun_belanja AS tbakun LEFT JOIN ( SELECT tba.akun,SUM(tba.jumlah) AS jml FROM (  SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit, RIGHT(t1.kode_usulan_belanja,6) AS akun, SUM(t1.harga_satuan * t1.volume) AS jumlah, t1.revisi AS revisi FROM rsa_detail_belanja_ AS t1 WHERE SUBSTR(t1.username,1,{$lenunit}) = '{$unit}' AND t1.sumber_dana = '{$sumber_dana}' AND SUBSTR(t1.proses,1,1) = '6' ". $str ." AND t1.tahun = '{$tahun}' GROUP BY RIGHT(t1.kode_usulan_belanja,6),SUBSTR(t1.kode_usulan_belanja,1,2),t1.revisi ORDER BY SUBSTR(t1.kode_usulan_belanja,1,2),RIGHT(t1.kode_usulan_belanja,6),t1.revisi) AS tba JOIN ( SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, MAX(t2.revisi) AS revisi FROM rsa_detail_belanja_ AS t2 WHERE SUBSTR(t2.username,1,{$lenunit}) = '{$unit}' AND t2.sumber_dana = '{$sumber_dana}' AND t2.tahun = '{$tahun}' GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2) ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2) ) AS tbb ON tba.kdunit = tbb.kdunit AND tba.revisi = tbb.revisi GROUP BY tba.akun ORDER BY tba.akun ) AS tbjml ON tbakun.kode_akun = tbjml.akun GROUP BY tbakun.kode_akun ORDER BY tbakun.kode_akun" ;

                // echo $query ; die ;

                $q = $this->db->query($query);

                // $jum = empty($q->num_rows())?'0':$q->row()->jum ;

                $arr = array();
                foreach($q->result() as $a){
                    $arr[$a->kode_akun] = $a->jum ;
                }

                $res = $arr ;


            }else{

                // $query = "SELECT SUM(rsa_2018.rsa_detail_belanja_.volume*rsa_2018.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa_2018.rsa_detail_belanja_ WHERE SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND rsa_2018.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_2018.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa_2018.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." GROUP BY SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,19,6)" ;

                // AND rsa_2018.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY det2.tahun ) 
                // echo $query ; die ;

                // $rba = $this->load->database('rba', TRUE);

                // $query = "SELECT rba_2018.unit.kode_unit FROM rba_2018.unit GROUP BY rba_2018.unit.kode_unit ORDER BY rba_2018.unit.kode_unit" ; 

                // $q = $rba->query($query);

                // if(!empty($q->num_rows())){

                //     $t = 0 ; 

                //     $units = $q->result_array() ;

                //     $rsa = $this->load->database('default', TRUE);

                //     foreach($units AS $u){

                //         $unit = $u['kode_unit'] ;

                //         $lenunit = strlen($unit);

                //         $query = "SELECT SUM(rsa_2018.rsa_detail_belanja_.volume*rsa_2018.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa_2018.rsa_detail_belanja_ WHERE SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND  SUBSTR(rsa_2018.rsa_detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rsa_2018.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_2018.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa_2018.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." AND rsa_2018.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,19,6)" ;     

                //         $q2 = $rsa->query($query);

                //         $t2 = (int)empty($q2->num_rows())?'0':(int)$q2->row()->jum ; 

                //         // echo $t2  ; die ; 

                //         $t = $t + $t2 ;

                //     }

                //     $jum = $t ; 

                // }

                $query = "SELECT tbakun.kode_akun,IF(ISNULL(tbjml.jml),0,tbjml.jml) AS jum FROM rba_2018.akun_belanja AS tbakun LEFT JOIN ( SELECT tba.akun,SUM(tba.jumlah) AS jml FROM (  SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit, RIGHT(t1.kode_usulan_belanja,6) AS akun, SUM(t1.harga_satuan * t1.volume) AS jumlah, t1.revisi AS revisi FROM rsa_detail_belanja_ AS t1 WHERE t1.sumber_dana = '{$sumber_dana}' AND SUBSTR(t1.proses,1,1) = '6' ". $str ." AND t1.tahun = '{$tahun}' GROUP BY RIGHT(t1.kode_usulan_belanja,6),SUBSTR(t1.kode_usulan_belanja,1,2),t1.revisi ORDER BY SUBSTR(t1.kode_usulan_belanja,1,2),RIGHT(t1.kode_usulan_belanja,6),t1.revisi) AS tba JOIN ( SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, MAX(t2.revisi) AS revisi FROM rsa_detail_belanja_ AS t2 WHERE t2.sumber_dana = '{$sumber_dana}' AND t2.tahun = '{$tahun}' GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2) ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2) ) AS tbb ON tba.kdunit = tbb.kdunit AND tba.revisi = tbb.revisi GROUP BY tba.akun ORDER BY tba.akun ) AS tbjml ON tbakun.kode_akun = tbjml.akun GROUP BY tbakun.kode_akun ORDER BY tbakun.kode_akun" ;

                // echo $query ; die ;

                $q = $this->db->query($query);

                // $jum = empty($q->num_rows())?'0':$q->row()->jum ;

                $arr = array();
                foreach($q->result() as $a){
                    $arr[$a->kode_akun] = $a->jum ;
                }

                $res = $arr ;

            }


            return $res ; 
            // return 0 ;
        }
        // function get_serapan_dikti($kode_akun,$sumber_dana,$unit,$tahun,$triwulan){
        function get_serapan_dikti($sumber_dana,$unit,$tahun,$triwulan){

            // $rba = $this->load->database('rba', TRUE);

            $str = '' ;

            // $jum = 0 ;

            $res = array();

            if($triwulan == '1'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01' AND '2018-03-31' )" ;
            }elseif($triwulan == '2'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01' AND '2018-06-30' )" ;
            }elseif($triwulan == '3'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01' AND '2018-09-30' )" ;
            }elseif($triwulan == '4'){
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01' AND '2018-12-31' )" ;
            }elseif($triwulan == '5'){
                $nw = date('Y-m-d');
                $str = "AND ( t1.tanggal_transaksi BETWEEN '2018-01-01' AND '{$nw}' )" ;
            }

            if($unit != '99'){

                $lenunit = strlen($unit);

                // $query = "SELECT SUM(rsa_2018.rsa_detail_belanja_.volume*rsa_2018.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa_2018.rsa_detail_belanja_ JOIN rba_2018.ket_subkomponen_input_ ON rba_2018.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,1,16) JOIN rba_2018.ref_akun ON rba_2018.ket_subkomponen_input_.jenis_biaya = rba_2018.ref_akun.nama_akun AND rba_2018.ket_subkomponen_input_.jenis_komponen = rba_2018.ref_akun.nama_akun_sub WHERE rba_2018.ref_akun.kode_akun_sub = '{$kode_akun}' AND SUBSTR(rsa_2018.rsa_detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rsa_2018.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_2018.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa_2018.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." AND rsa_2018.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) AND rba_2018.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det3 WHERE SUBSTR(det3.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY LEFT(det3.kode_usulan_belanja,2) ) GROUP BY rba_2018.ref_akun.kode_akun_sub" ;

                // $q = $this->db->query($query);

                // $jum = empty($q->num_rows())?'0':$q->row()->jum ;

                $query = "SELECT tc1.kode_akun,tc1.kode_akun_sub,tc2.jml AS jum FROM rba_2018.ref_akun AS tc1 LEFT JOIN( SELECT tba.jenis_biaya, tba.jenis_komponen,SUM(tba.jumlah) AS jml FROM ( SELECT tba1.kdunit,tba1.kdusul,tba1.jumlah,tba1.revisi,tba2.jenis_biaya,tba2.jenis_komponen FROM ( SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit,SUBSTR(t1.kode_usulan_belanja,1,16) AS kdusul, SUM(t1.harga_satuan * t1.volume) AS jumlah, t1.revisi AS revisi FROM rsa_detail_belanja_ AS t1 WHERE t1.sumber_dana = '{$sumber_dana}' AND SUBSTR(t1.username,1,{$lenunit}) = '{$unit}' AND SUBSTR(t1.proses,1,1) = '6' ". $str ." AND t1.tahun = '{$tahun}' GROUP BY SUBSTR(t1.kode_usulan_belanja,1,16), t1.revisi ORDER BY SUBSTR(t1.kode_usulan_belanja,1,2),SUBSTR(t1.kode_usulan_belanja,1,16) ) AS tba1 JOIN rba_2018.ket_subkomponen_input_ AS tba2 ON tba1.kdusul = tba2.kode_subkomponen_input AND  tba1.revisi = tba2.revisi ORDER BY tba1.kdunit,tba1.kdusul ) AS tba JOIN ( SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, MAX(t2.revisi) AS revisi FROM rsa_detail_belanja_ AS t2 WHERE t2.sumber_dana = '{$sumber_dana}' AND SUBSTR(t2.username,1,{$lenunit}) = '{$unit}' AND t2.tahun = '{$tahun}' GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2) ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2) ) AS tbb ON tba.kdunit = tbb.kdunit AND tba.revisi = tbb.revisi GROUP BY tba.jenis_biaya, tba.jenis_komponen ORDER BY tba.jenis_biaya, tba.jenis_komponen ) AS tc2 ON tc1.nama_akun = tc2.jenis_biaya AND tc1.nama_akun_sub = tc2.jenis_komponen" ;

                // echo $query ; die ;

                $q = $this->db->query($query);

                $arr = array();
                foreach($q->result() as $a){
                    $arr[$a->kode_akun_sub] = $a->jum ;
                }

                $res = $arr ;

                // echo $query ; die ;

            }else{

                // $query = "SELECT SUM(rsa_2018.rsa_detail_belanja_.volume*rsa_2018.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa_2018.rsa_detail_belanja_ JOIN rba_2018.ket_subkomponen_input_ ON rba_2018.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,1,16) JOIN rba_2018.ref_akun ON rba_2018.ket_subkomponen_input_.jenis_biaya = rba_2018.ref_akun.nama_akun AND rba_2018.ket_subkomponen_input_.jenis_komponen = rba_2018.ref_akun.nama_akun_sub WHERE rba_2018.ref_akun.kode_akun_sub = '{$kode_akun}' AND rsa_2018.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_2018.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa_2018.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." AND rsa_2018.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY det2.tahun ) AND rba_2018.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det3 WHERE det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY det3.tahun ) GROUP BY rba_2018.ref_akun.kode_akun_sub" ;

                // $rba = $this->load->database('rba', TRUE);

                // $query = "SELECT rba_2018.unit.kode_unit FROM rba_2018.unit GROUP BY rba_2018.unit.kode_unit ORDER BY rba_2018.unit.kode_unit" ; 

                // $q = $rba->query($query);

                // if(!empty($q->num_rows())){

                //     $t = 0 ; 

                //     $units = $q->result_array() ;

                //     $rsa = $this->load->database('default', TRUE);

                //     foreach($units AS $u){

                //         $unit = $u['kode_unit'] ;

                //         $lenunit = strlen($unit);

                //         $query = "SELECT SUM(rsa_2018.rsa_detail_belanja_.volume*rsa_2018.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa_2018.rsa_detail_belanja_ JOIN rba_2018.ket_subkomponen_input_ ON rba_2018.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,1,16) JOIN rba_2018.ref_akun ON rba_2018.ket_subkomponen_input_.jenis_biaya = rba_2018.ref_akun.nama_akun AND rba_2018.ket_subkomponen_input_.jenis_komponen = rba_2018.ref_akun.nama_akun_sub WHERE rba_2018.ref_akun.kode_akun_sub = '{$kode_akun}' AND SUBSTR(rsa_2018.rsa_detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rsa_2018.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_2018.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa_2018.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." AND rsa_2018.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) AND rba_2018.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det3 WHERE SUBSTR(det3.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY LEFT(det3.kode_usulan_belanja,2) ) GROUP BY rba_2018.ref_akun.kode_akun_sub" ;  

                //         $q2 = $rsa->query($query);

                //         $t2 = (int)empty($q2->num_rows())?'0':(int)$q2->row()->jum ; 

                //         // echo $t2  ; die ; 

                //         $t = $t + $t2 ;

                //     }

                //     $jum = $t ; 

                // }

                $query = "SELECT tc1.kode_akun,tc1.kode_akun_sub,tc2.jml AS jum FROM rba_2018.ref_akun AS tc1 LEFT JOIN( SELECT tba.jenis_biaya, tba.jenis_komponen,SUM(tba.jumlah) AS jml FROM ( SELECT tba1.kdunit,tba1.kdusul,tba1.jumlah,tba1.revisi,tba2.jenis_biaya,tba2.jenis_komponen FROM ( SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit,SUBSTR(t1.kode_usulan_belanja,1,16) AS kdusul, SUM(t1.harga_satuan * t1.volume) AS jumlah, t1.revisi AS revisi FROM rsa_detail_belanja_ AS t1 WHERE t1.sumber_dana = '{$sumber_dana}' AND SUBSTR(t1.proses,1,1) = '6' ". $str ." AND t1.tahun = '{$tahun}' GROUP BY SUBSTR(t1.kode_usulan_belanja,1,16), t1.revisi ORDER BY SUBSTR(t1.kode_usulan_belanja,1,2),SUBSTR(t1.kode_usulan_belanja,1,16) ) AS tba1 JOIN rba_2018.ket_subkomponen_input_ AS tba2 ON tba1.kdusul = tba2.kode_subkomponen_input AND  tba1.revisi = tba2.revisi ORDER BY tba1.kdunit,tba1.kdusul ) AS tba JOIN ( SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, MAX(t2.revisi) AS revisi FROM rsa_detail_belanja_ AS t2 WHERE t2.sumber_dana = '{$sumber_dana}' AND t2.tahun = '{$tahun}' GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2) ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2) ) AS tbb ON tba.kdunit = tbb.kdunit AND tba.revisi = tbb.revisi GROUP BY tba.jenis_biaya, tba.jenis_komponen ORDER BY tba.jenis_biaya, tba.jenis_komponen ) AS tc2 ON tc1.nama_akun = tc2.jenis_biaya AND tc1.nama_akun_sub = tc2.jenis_komponen" ;

                echo $query ; die ;

                $q = $this->db->query($query);

                $arr = array();
                foreach($q->result() as $a){
                    $arr[$a->kode_akun_sub] = $a->jum ;
                }

                $res = $arr ;

            }

            // echo $query ; die ;

            // $q = $rba->query($query);
            
            // var_dump($q); die;
            // echo '<pre>';
            // var_dump($q->result()); 
            // echo '</pre>';die;

            return $res ; 
            // return 0 ;
        }

        function get_total_serapan($unit,$tahun){
            $lenunit = strlen($unit);
            $query  = "SELECT SUM(rsa_2018.rsa_detail_belanja_.volume*rsa_2018.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa_detail_belanja_ WHERE SUBSTR(rsa_2018.rsa_detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rsa_2018.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa_2018.rsa_detail_belanja_.proses,1,1) = '6' GROUP BY SUBSTR(rsa_2018.rsa_detail_belanja_.username,1,{$lenunit}) " ; 


            // echo $query ; die;

            $q = $this->db->query($query);
            // var_dump($q); die;
            // echo '<pre>';
            // var_dump($q->result()); 
            // echo '</pre>';die;

            return empty($q->num_rows())?'0':$q->row()->jum ;
        }
        function get_kuitansi(){

            die ;

            $query = "SELECT trx_spm_gup_data.data_kuitansi FROM trx_urut_spm_cair JOIN trx_spm_gup_data ON trx_spm_gup_data.str_nomor_trx = trx_urut_spm_cair.str_nomor_trx_spm WHERE ( trx_urut_spm_cair.tgl_proses BETWEEN '2018-01-01' AND '2018-03-31' ) AND ( trx_urut_spm_cair.jenis_trx = 'GUP' )" ;

            $q = $this->db->query($query);

            $r = $q->result() ;

            $sr = '';

            foreach ($r as $rr) {
                $sr = $sr . $rr->data_kuitansi ;
            }

            $sr = str_replace("][",",",$sr);
            $sr = str_replace("\"","",$sr);
            $sr = substr($sr,1,-1) ;
            $ar = explode(",", $sr);
            // var_dump($ar); die;
            // echo $sr ; die;
            $i = 1 ;

            foreach($ar as $arr){
                
                $query = "UPDATE rsa_kuitansi_detail JOIN rsa_detail_belanja_ ON rsa_detail_belanja_.kode_usulan_belanja = rsa_kuitansi_detail.kode_usulan_belanja AND rsa_detail_belanja_.kode_akun_tambah = rsa_kuitansi_detail.kode_akun_tambah SET rsa_detail_belanja_.tanggal_transaksi = '2018-03-01' WHERE rsa_kuitansi_detail.id_kuitansi = '{$arr}'" ;

                if($this->db->query($query)){
                    echo $i . ' - ' . $arr . ' - GOOD ' ;
                    echo '<br>' ;
                }else{
                    echo $i . ' - ' . $arr . ' - BAD ' ;
                    echo '<br>' ;
                }

                $i++ ;

            }

            die;

            


        }
        function get_akun_($unit,$tahun){

        	$rba = $this->load->database('rba', TRUE);

            $query2 = "SELECT rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun,SUM(rba_2018.detail_belanja_.volume*rba_2018.detail_belanja_.harga_satuan) AS jum FROM rba_2018.akun_belanja LEFT JOIN rba_2018.detail_belanja_ ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,19,6) = rba_2018.akun_belanja.kode_akun WHERE SUBSTR(rba_2018.detail_belanja_.username,1,2) = '{$unit}' AND rba_2018.detail_belanja_.sumber_dana = 'SELAIN-APBN' AND rba_2018.akun_belanja.sumber_dana = 'SELAIN-APBN' AND rba_2018.detail_belanja_.tahun = '{$tahun}' AND rba_2018.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,2) = '{$unit}' AND det2.sumber_dana = 'SELAIN-APBN' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY rba_2018.akun_belanja.kode_akun ORDER BY rba_2018.akun_belanja.kode_akun" ;


        	$query3 = "SELECT rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun,SUM(rba_2018.detail_belanja_.volume*rba_2018.detail_belanja_.harga_satuan) AS jum FROM rba_2018.detail_belanja_ JOIN rba_2018.akun_belanja ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,19,6) = rba_2018.akun_belanja.kode_akun WHERE SUBSTR(rba_2018.detail_belanja_.username,1,2) = '{$unit}' AND rba_2018.detail_belanja_.sumber_dana = 'SELAIN-APBN' AND rba_2018.akun_belanja.sumber_dana = 'SELAIN-APBN' AND rba_2018.detail_belanja_.tahun = '{$tahun}' AND rba_2018.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,2) = '{$unit}' AND det2.sumber_dana = 'SELAIN-APBN' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,19,6) ORDER BY SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,19,6)" ;
        	
        	// echo $query ; die;

			$q = $rba->query($query);
			// var_dump($q); die;
			// echo '<pre>';
			// var_dump($q->result()); 
			// echo '</pre>';die;

			return $q->result() ;

        }
        function get_data_($unit,$tahun){


        	$query = "SELECT rba_2018.akun_belanja.kode_akun5digit,rba_2018.akun_belanja.nama_akun5digit,rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun,SUM(rsa_2018.rsa_detail_belanja_.volume*rsa_2018.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa_2018.rsa_detail_belanja_ JOIN rba_2018.akun_belanja ON SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,19,6) = rba_2018.akun_belanja.kode_akun WHERE SUBSTR(rsa_2018.rsa_detail_belanja_.username,1,2) = '{$unit}' AND rsa_2018.rsa_detail_belanja_.sumber_dana = 'SELAIN-APBN' AND rsa_2018.rsa_detail_belanja_.tahun = '{$tahun}' GROUP BY rsa_2018.rsa_detail_belanja_.kode_usulan_belanja ORDER BY rba_2018.akun_belanja.kode_akun" ;
        	// echo $query ; die;

			$q = $this->db->query($query);
			// var_dump($q); die;
			// echo '<pre>';
			// var_dump($q->result()); 
			// echo '</pre>';die;

			return $q->result() ;

        }

        function get_total_proses($sumber_dana,$unit,$tahun,$triwulan){
           $str = '' ;

            $lenunit = strlen($unit);

            $res = array();

            if($triwulan == '1'){
                $str = "AND ( tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-03-31 23:59:59' )" ;
            }elseif($triwulan == '2'){
                $str = "AND ( tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-06-30 23:59:59' )" ;
            }elseif($triwulan == '3'){
                $str = "AND ( tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-09-30 23:59:59' )" ;
            }elseif($triwulan == '4'){
                $str = "AND ( tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '2018-12-31 23:59:59' )" ;
            }elseif($triwulan == '5'){
                $nw = date('Y-m-d H:i:s');
                $str = "AND ( tanggal_transaksi BETWEEN '2018-01-01 00:00:00' AND '{$nw}' )" ;
            }

            if ($unit != 99) {
                $where_unit_1 = 'AND SUBSTR(username,1,'.$lenunit.') = '.$unit;
                
            }else{
                $where_unit_1 = '';
            }

            $query = "SELECT sum(volume*harga_satuan) as jumlah, proses
                        FROM rsa_detail_belanja_
                        WHERE substr(proses,1,1) = '6' and sumber_dana = '{$sumber_dana}'  and  tahun = {$tahun} {$str} {$where_unit_1}
                        -- AND RIGHT(kode_usulan_belanja,6) IN(SELECT kode_akun FROM rba_2018.akun_belanja WHERE kode_akun1digit = '5' OR kode_akun1digit = '8' )
                        GROUP BY proses" ;
            
            // vdebug($query);

            $query= $this->db->query($query);
            // vdebug($query->num_rows());
            if ($query->num_rows() > 0) {
                return $query->result();
            }else{
                return array();
            }
        }
    }


