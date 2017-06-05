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

            $query = "SELECT rba.ref_akun.kode_akun,rba.ref_akun.nama_akun,rba.ref_akun.kode_akun_sub,rba.ref_akun.nama_akun_sub FROM rba.ref_akun GROUP BY rba.ref_akun.kode_akun_sub ORDER BY rba.ref_akun.kode_akun_sub" ;

            // WHERE rba.akun_belanja.sumber_dana = '{$sumber_dana}' 
            
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

                $r['anggaran'] = $this->get_anggaran_dikti($d->kode_akun_sub,$sumber_dana,$unit,$tahun);
                $r['serapan'] = $this->get_serapan_dikti($d->kode_akun_sub,$sumber_dana,$unit,$tahun,$triwulan);


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

            $query = "SELECT rba.akun_belanja.kode_akun1digit,rba.akun_belanja.nama_akun1digit,rba.akun_belanja.kode_akun2digit,rba.akun_belanja.nama_akun2digit,rba.akun_belanja.kode_akun3digit,rba.akun_belanja.nama_akun3digit,rba.akun_belanja.kode_akun4digit,rba.akun_belanja.nama_akun4digit,rba.akun_belanja.kode_akun5digit,rba.akun_belanja.nama_akun5digit,rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun FROM rba.akun_belanja WHERE rba.akun_belanja.sumber_dana = '{$sumber_dana}' GROUP BY rba.akun_belanja.kode_akun ORDER BY rba.akun_belanja.kode_akun" ;
            
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

                $r['anggaran'] = $this->get_anggaran($d->kode_akun,$sumber_dana,$unit,$tahun);
                $r['serapan'] = $this->get_serapan($d->kode_akun,$sumber_dana,$unit,$tahun,$triwulan);


                $r1[] = (object)$r ;

          }
   // echo '<pre>' ;
   // var_dump((object)$r1); 
   // echo '</pre>' ;
   // die;

          return $r1 ; 

        }
        function get_anggaran($kode_akun,$sumber_dana,$unit,$tahun){

            $rba = $this->load->database('rba', TRUE);

            $jum = 0 ;

            if($unit != '99'){

                $lenunit = strlen($unit);

                $query = "SELECT SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS jum FROM rba.detail_belanja_ WHERE SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND  SUBSTR(rba.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba.detail_belanja_.tahun = '{$tahun}' AND rba.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6)" ;

                // echo '<pre>' ;
                // echo $query ; 
                // echo '</pre>' ; 

                // echo '<br>' ; 
                // echo '<br>' ; 

                $q = $rba->query($query);

                $jum = empty($q->num_rows())?'0':$q->row()->jum ;

            }else{

                $query = "SELECT rba.unit.kode_unit FROM rba.unit GROUP BY rba.unit.kode_unit ORDER BY rba.unit.kode_unit" ; 

                $q = $rba->query($query);

                if(!empty($q->num_rows())){



                    // $i = 1;

                    // var_dump($q->result_array()); die;

                    $t = 0 ; 

                    $units = $q->result_array() ;

                    foreach($units AS $u){

                        $unit = $u['kode_unit'] ;

                        $lenunit = strlen($unit);

                        $query = "SELECT SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS jum FROM rba.detail_belanja_ WHERE SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND  SUBSTR(rba.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba.detail_belanja_.tahun = '{$tahun}' AND rba.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6)" ;

                        // echo $query ; echo '<br>' ; echo '<br>' ;

                        $q2 = $rba->query($query);

                        $t2 = (int)empty($q2->num_rows())?'0':(int)$q2->row()->jum ; 


                        $t = $t + $t2 ;

                        // $jum = $jum + (int)empty($q2->num_rows())?'0':$q2->row()->jum ;

                        // echo $unit ; die ;

                        // $i = $i + empty($q2->num_rows())?0:(int)$q2->row()->jum ;

                        // $s = $s . $unit ;

                        // $jum = $jum + 1 ; 

                        // $jum = $jum + empty($q2->num_rows())?0:(int)$q2->row()->jum ;

                        

                    }

                    $jum = $t ; 


                    // echo $i ; die ;

                    // echo $jum ; die ;

                       
                }

            }


            return $jum ;

        }
        function get_anggaran_dikti($kode_akun,$sumber_dana,$unit,$tahun){

            $rba = $this->load->database('rba', TRUE);

            $jum = 0 ;

            if($unit != '99'){

                $lenunit = strlen($unit);

                $query = "SELECT SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS jum FROM rba.detail_belanja_ JOIN rba.ket_subkomponen_input_ ON rba.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rba.detail_belanja_.kode_usulan_belanja,1,16) JOIN rba.ref_akun ON rba.ket_subkomponen_input_.jenis_biaya = rba.ref_akun.nama_akun AND rba.ket_subkomponen_input_.jenis_komponen = rba.ref_akun.nama_akun_sub WHERE rba.ref_akun.kode_akun_sub = '{$kode_akun}' AND SUBSTR(rba.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba.detail_belanja_.tahun = '{$tahun}' AND rba.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) AND rba.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rba.detail_belanja_ AS det3 WHERE SUBSTR(det3.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY LEFT(det3.kode_usulan_belanja,2) ) GROUP BY rba.ref_akun.kode_akun_sub" ;

                $q = $rba->query($query);

                $jum = empty($q->num_rows())?'0':$q->row()->jum ;



                // "SELECT SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS jum FROM rba.detail_belanja_ WHERE SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND  SUBSTR(rba.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba.detail_belanja_.tahun = '{$tahun}' AND rba.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6)" ;

                //echo $query ; die;

            }else{
                // $query = "SELECT SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS jum FROM rba.detail_belanja_ JOIN rba.ket_subkomponen_input_ ON rba.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rba.detail_belanja_.kode_usulan_belanja,1,16) JOIN rba.ref_akun ON rba.ket_subkomponen_input_.jenis_biaya = rba.ref_akun.nama_akun AND rba.ket_subkomponen_input_.jenis_komponen = rba.ref_akun.nama_akun_sub WHERE rba.ref_akun.kode_akun_sub = '{$kode_akun}' AND rba.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba.detail_belanja_.tahun = '{$tahun}' AND rba.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba.detail_belanja_ AS det2 WHERE det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY det2.tahun ) AND rba.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rba.detail_belanja_ AS det3 WHERE det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY det3.tahun ) GROUP BY rba.ref_akun.kode_akun_sub" ;

                $query = "SELECT rba.unit.kode_unit FROM rba.unit GROUP BY rba.unit.kode_unit ORDER BY rba.unit.kode_unit" ; 

                $q = $rba->query($query);

                if(!empty($q->num_rows())){


                    $t = 0 ; 

                    $units = $q->result_array() ;

                    foreach($units AS $u){

                        $unit = $u['kode_unit'] ;

                        $lenunit = strlen($unit);

                        $query = "SELECT SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS jum FROM rba.detail_belanja_ JOIN rba.ket_subkomponen_input_ ON rba.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rba.detail_belanja_.kode_usulan_belanja,1,16) JOIN rba.ref_akun ON rba.ket_subkomponen_input_.jenis_biaya = rba.ref_akun.nama_akun AND rba.ket_subkomponen_input_.jenis_komponen = rba.ref_akun.nama_akun_sub WHERE rba.ref_akun.kode_akun_sub = '{$kode_akun}' AND SUBSTR(rba.detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rba.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba.detail_belanja_.tahun = '{$tahun}' AND rba.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) AND rba.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rba.detail_belanja_ AS det3 WHERE SUBSTR(det3.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY LEFT(det3.kode_usulan_belanja,2) ) GROUP BY rba.ref_akun.kode_akun_sub" ;

                        // echo $query ; die ;

                        $q2 = $rba->query($query);

                        $t2 = (int)empty($q2->num_rows())?'0':(int)$q2->row()->jum ; 


                        $t = $t + $t2 ;

                    }

                    $jum = $t ; 

                       
                }

            }


            return $jum ; 
            // return 0 ;
        }
        function get_serapan($kode_akun,$sumber_dana,$unit,$tahun,$triwulan){

            // $rba = $this->load->database('rba', TRUE);

            $str = '' ;

            $jum = 0 ;

            if($triwulan == '1'){
                $str = "AND ( rsa.rsa_detail_belanja_.tanggal_transaksi BETWEEN '2017-01-01' AND '2017-03-31' )" ;
            }elseif($triwulan == '2'){
                $str = "AND ( rsa.rsa_detail_belanja_.tanggal_transaksi BETWEEN '2017-01-01' AND '2017-06-30' )" ;
            }elseif($triwulan == '3'){
                $str = "AND ( rsa.rsa_detail_belanja_.tanggal_transaksi BETWEEN '2017-01-01' AND '2017-09-30' )" ;
            }elseif($triwulan == '4'){
                $str = "AND ( rsa.rsa_detail_belanja_.tanggal_transaksi BETWEEN '2017-01-01' AND '2017-12-31' )" ;
            }elseif($triwulan == '5'){
                $nw = date('Y-m-d');
                $str = "AND ( rsa.rsa_detail_belanja_.tanggal_transaksi BETWEEN '2017-01-01' AND '{$nw}' )" ;
            }

            if($unit != '99'){

                $lenunit = strlen($unit);

                $query = "SELECT SUM(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa.rsa_detail_belanja_ WHERE SUBSTR(rsa.rsa_detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND  SUBSTR(rsa.rsa_detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rsa.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." AND rsa.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rsa.rsa_detail_belanja_.kode_usulan_belanja,19,6)" ;

                $q = $this->db->query($query);

                $jum = empty($q->num_rows())?'0':$q->row()->jum ;


            }else{

                // $query = "SELECT SUM(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa.rsa_detail_belanja_ WHERE SUBSTR(rsa.rsa_detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND rsa.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." GROUP BY SUBSTR(rsa.rsa_detail_belanja_.kode_usulan_belanja,19,6)" ;

                // AND rsa.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa.rsa_detail_belanja_ AS det2 WHERE det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY det2.tahun ) 
                // echo $query ; die ;

                $rba = $this->load->database('rba', TRUE);

                $query = "SELECT rba.unit.kode_unit FROM rba.unit GROUP BY rba.unit.kode_unit ORDER BY rba.unit.kode_unit" ; 

                $q = $rba->query($query);

                if(!empty($q->num_rows())){

                    $t = 0 ; 

                    $units = $q->result_array() ;

                    $rsa = $this->load->database('default', TRUE);

                    foreach($units AS $u){

                        $unit = $u['kode_unit'] ;

                        $lenunit = strlen($unit);

                        $query = "SELECT SUM(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa.rsa_detail_belanja_ WHERE SUBSTR(rsa.rsa_detail_belanja_.kode_usulan_belanja,19,6) = '{$kode_akun}' AND  SUBSTR(rsa.rsa_detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rsa.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." AND rsa.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rsa.rsa_detail_belanja_.kode_usulan_belanja,19,6)" ;     

                        $q2 = $rsa->query($query);

                        $t2 = (int)empty($q2->num_rows())?'0':(int)$q2->row()->jum ; 

                        // echo $t2  ; die ; 

                        $t = $t + $t2 ;

                    }

                    $jum = $t ; 

                }

            }


            return $jum ; 
            // return 0 ;
        }
        function get_serapan_dikti($kode_akun,$sumber_dana,$unit,$tahun,$triwulan){

            // $rba = $this->load->database('rba', TRUE);

            $str = '' ;

            $jum = 0 ;

            if($triwulan == '1'){
                $str = "AND ( rsa.rsa_detail_belanja_.tanggal_transaksi BETWEEN '2017-01-01' AND '2017-03-31' )" ;
            }elseif($triwulan == '2'){
                $str = "AND ( rsa.rsa_detail_belanja_.tanggal_transaksi BETWEEN '2017-01-01' AND '2017-06-30' )" ;
            }elseif($triwulan == '3'){
                $str = "AND ( rsa.rsa_detail_belanja_.tanggal_transaksi BETWEEN '2017-01-01' AND '2017-09-30' )" ;
            }elseif($triwulan == '4'){
                $str = "AND ( rsa.rsa_detail_belanja_.tanggal_transaksi BETWEEN '2017-01-01' AND '2017-12-31' )" ;
            }elseif($triwulan == '5'){
                $nw = date('Y-m-d');
                $str = "AND ( rsa.rsa_detail_belanja_.tanggal_transaksi BETWEEN '2017-01-01' AND '{$nw}' )" ;
            }

            if($unit != '99'){

                $lenunit = strlen($unit);

                $query = "SELECT SUM(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa.rsa_detail_belanja_ JOIN rba.ket_subkomponen_input_ ON rba.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rsa.rsa_detail_belanja_.kode_usulan_belanja,1,16) JOIN rba.ref_akun ON rba.ket_subkomponen_input_.jenis_biaya = rba.ref_akun.nama_akun AND rba.ket_subkomponen_input_.jenis_komponen = rba.ref_akun.nama_akun_sub WHERE rba.ref_akun.kode_akun_sub = '{$kode_akun}' AND SUBSTR(rsa.rsa_detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rsa.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." AND rsa.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) AND rba.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rsa.rsa_detail_belanja_ AS det3 WHERE SUBSTR(det3.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY LEFT(det3.kode_usulan_belanja,2) ) GROUP BY rba.ref_akun.kode_akun_sub" ;

                $q = $this->db->query($query);

                $jum = empty($q->num_rows())?'0':$q->row()->jum ;

                // echo $query ; die ;

            }else{

                // $query = "SELECT SUM(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa.rsa_detail_belanja_ JOIN rba.ket_subkomponen_input_ ON rba.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rsa.rsa_detail_belanja_.kode_usulan_belanja,1,16) JOIN rba.ref_akun ON rba.ket_subkomponen_input_.jenis_biaya = rba.ref_akun.nama_akun AND rba.ket_subkomponen_input_.jenis_komponen = rba.ref_akun.nama_akun_sub WHERE rba.ref_akun.kode_akun_sub = '{$kode_akun}' AND rsa.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." AND rsa.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa.rsa_detail_belanja_ AS det2 WHERE det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY det2.tahun ) AND rba.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rsa.rsa_detail_belanja_ AS det3 WHERE det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY det3.tahun ) GROUP BY rba.ref_akun.kode_akun_sub" ;

                $rba = $this->load->database('rba', TRUE);

                $query = "SELECT rba.unit.kode_unit FROM rba.unit GROUP BY rba.unit.kode_unit ORDER BY rba.unit.kode_unit" ; 

                $q = $rba->query($query);

                if(!empty($q->num_rows())){

                    $t = 0 ; 

                    $units = $q->result_array() ;

                    $rsa = $this->load->database('default', TRUE);

                    foreach($units AS $u){

                        $unit = $u['kode_unit'] ;

                        $lenunit = strlen($unit);

                        $query = "SELECT SUM(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa.rsa_detail_belanja_ JOIN rba.ket_subkomponen_input_ ON rba.ket_subkomponen_input_.kode_subkomponen_input = SUBSTR(rsa.rsa_detail_belanja_.kode_usulan_belanja,1,16) JOIN rba.ref_akun ON rba.ket_subkomponen_input_.jenis_biaya = rba.ref_akun.nama_akun AND rba.ket_subkomponen_input_.jenis_komponen = rba.ref_akun.nama_akun_sub WHERE rba.ref_akun.kode_akun_sub = '{$kode_akun}' AND SUBSTR(rsa.rsa_detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rsa.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa.rsa_detail_belanja_.proses,1,1) = '6' ". $str ." AND rsa.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) AND rba.ket_subkomponen_input_.revisi = ( SELECT MAX(det3.revisi) FROM rsa.rsa_detail_belanja_ AS det3 WHERE SUBSTR(det3.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det3.sumber_dana = '{$sumber_dana}' AND det3.tahun = '{$tahun}' GROUP BY LEFT(det3.kode_usulan_belanja,2) ) GROUP BY rba.ref_akun.kode_akun_sub" ;  

                        $q2 = $rsa->query($query);

                        $t2 = (int)empty($q2->num_rows())?'0':(int)$q2->row()->jum ; 

                        // echo $t2  ; die ; 

                        $t = $t + $t2 ;

                    }

                    $jum = $t ; 

                }

            }

            // echo $query ; die ;

            // $q = $rba->query($query);
            
            // var_dump($q); die;
            // echo '<pre>';
            // var_dump($q->result()); 
            // echo '</pre>';die;

            return $jum ; 
            // return 0 ;
        }
        function get_total_serapan($unit,$tahun){
            $lenunit = strlen($unit);
            $query  = "SELECT SUM(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa_detail_belanja_ WHERE SUBSTR(rsa.rsa_detail_belanja_.username,1,{$lenunit}) = '{$unit}' AND rsa.rsa_detail_belanja_.tahun = '{$tahun}' AND SUBSTR(rsa.rsa_detail_belanja_.proses,1,1) = '6' GROUP BY SUBSTR(rsa.rsa_detail_belanja_.username,1,{$lenunit}) " ; 


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

            $query = "SELECT trx_spm_gup_data.data_kuitansi FROM trx_urut_spm_cair JOIN trx_spm_gup_data ON trx_spm_gup_data.str_nomor_trx = trx_urut_spm_cair.str_nomor_trx_spm WHERE ( trx_urut_spm_cair.tgl_proses BETWEEN '2017-01-01' AND '2017-03-31' ) AND ( trx_urut_spm_cair.jenis_trx = 'GUP' )" ;

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
                
                $query = "UPDATE rsa_kuitansi_detail JOIN rsa_detail_belanja_ ON rsa_detail_belanja_.kode_usulan_belanja = rsa_kuitansi_detail.kode_usulan_belanja AND rsa_detail_belanja_.kode_akun_tambah = rsa_kuitansi_detail.kode_akun_tambah SET rsa_detail_belanja_.tanggal_transaksi = '2017-03-01' WHERE rsa_kuitansi_detail.id_kuitansi = '{$arr}'" ;

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

            $query2 = "SELECT rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS jum FROM rba.akun_belanja LEFT JOIN rba.detail_belanja_ ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6) = rba.akun_belanja.kode_akun WHERE SUBSTR(rba.detail_belanja_.username,1,2) = '{$unit}' AND rba.detail_belanja_.sumber_dana = 'SELAIN-APBN' AND rba.akun_belanja.sumber_dana = 'SELAIN-APBN' AND rba.detail_belanja_.tahun = '{$tahun}' AND rba.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,2) = '{$unit}' AND det2.sumber_dana = 'SELAIN-APBN' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY rba.akun_belanja.kode_akun ORDER BY rba.akun_belanja.kode_akun" ;


        	$query3 = "SELECT rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS jum FROM rba.detail_belanja_ JOIN rba.akun_belanja ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6) = rba.akun_belanja.kode_akun WHERE SUBSTR(rba.detail_belanja_.username,1,2) = '{$unit}' AND rba.detail_belanja_.sumber_dana = 'SELAIN-APBN' AND rba.akun_belanja.sumber_dana = 'SELAIN-APBN' AND rba.detail_belanja_.tahun = '{$tahun}' AND rba.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,2) = '{$unit}' AND det2.sumber_dana = 'SELAIN-APBN' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6) ORDER BY SUBSTR(rba.detail_belanja_.kode_usulan_belanja,19,6)" ;
        	
        	// echo $query ; die;

			$q = $rba->query($query);
			// var_dump($q); die;
			// echo '<pre>';
			// var_dump($q->result()); 
			// echo '</pre>';die;

			return $q->result() ;

        }
        function get_data_($unit,$tahun){


        	$query = "SELECT rba.akun_belanja.kode_akun5digit,rba.akun_belanja.nama_akun5digit,rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,SUM(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS jum FROM rsa.rsa_detail_belanja_ JOIN rba.akun_belanja ON SUBSTR(rsa.rsa_detail_belanja_.kode_usulan_belanja,19,6) = rba.akun_belanja.kode_akun WHERE SUBSTR(rsa.rsa_detail_belanja_.username,1,2) = '{$unit}' AND rsa.rsa_detail_belanja_.sumber_dana = 'SELAIN-APBN' AND rsa.rsa_detail_belanja_.tahun = '{$tahun}' GROUP BY rsa.rsa_detail_belanja_.kode_usulan_belanja ORDER BY rba.akun_belanja.kode_akun" ;
        	// echo $query ; die;

			$q = $this->db->query($query);
			// var_dump($q); die;
			// echo '<pre>';
			// var_dump($q->result()); 
			// echo '</pre>';die;

			return $q->result() ;

        }
    }