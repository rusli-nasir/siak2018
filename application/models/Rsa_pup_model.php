<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rsa_pup_model extends CI_Model {
/* -------------- Constructor ------------- */

    
        public function __construct()
        {
                
                parent::__construct();
                
        }
    
        
        function check_dokumen_pup($kode_unit_subunit,$tahun,$id_trx_nomor_pup = ""){
            $q = $this->db->query("SELECT posisi FROM trx_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1'  AND tahun = '{$tahun}' AND id_trx_nomor_pup = '{$id_trx_nomor_pup}' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->posisi ;
            }else{
                return '';
            }
        }
        
        function lihat_ket($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT ket FROM trx_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->ket ;
            }else{
                return '';
            }
        }

        function lihat_ket_by_nomor_trx($str_nomor_trx){

            // echo"SELECT ket FROM trx_pup JOIN trx_nomor_pup ON trx_nomor_pup.id_trx_nomor_pup = trx_pup.id_trx_nomor_pup WHERE trx_nomor_pup.str_nomor_trx = '{$str_nomor_trx}'" ; die ;

            $query = "SELECT trx_pup.ket FROM trx_pup JOIN trx_nomor_pup ON trx_nomor_pup.id_trx_nomor_pup = trx_pup.id_trx_nomor_pup WHERE trx_nomor_pup.str_nomor_trx = '{$str_nomor_trx}' AND  trx_pup.aktif = '1' " ;


            // $querym = "SELECT * FROM trx_nomor_pup WHERE str_nomor_trx LIKE '{$str_nomor_trx}'" ;


            // echo $query ;

            $q = $this->db->query($query);

           // var_dump($q->row());die;

            if($q->num_rows() > 0){
               return $q->row()->ket ;
            }else{
                return '';
            }
        }
        
        function proses_nomor_spp_pup($kode_unit,$data){
            
            // $this->db->where('tahun', $data['tahun']);
            // $this->db->where('aktif', '1');
            // $this->db->where('jenis', 'SPP');
            // $this->db->where('kode_unit_subunit', $kode_unit);
            // $this->db->update('trx_nomor_pup', array('aktif'=>'0')); 
            
            return $this->db->insert('trx_nomor_pup',$data);
            
        }
        
        function proses_nomor_spm_pup($kode_unit,$data){
            
            // $this->db->where('tahun', $data['tahun']);
            // $this->db->where('aktif', '1');
            // $this->db->where('jenis', 'SPM');
            // $this->db->where('kode_unit_subunit', $kode_unit);
            // $this->db->update('trx_nomor_pup', array('aktif'=>'0')); 
            
            return $this->db->insert('trx_nomor_pup',$data);
            
        }
        
        function proses_trx_spp_spm($data){
            
            return $this->db->insert('trx_spp_spm',$data);
            
        }
        
        function proses_pup($kode_unit,$data,$id_nomor_pup){
            
            if(($data['posisi'] == 'SPP-DITOLAK')||($data['posisi'] == 'SPM-DITOLAK-KPA')||($data['posisi'] == 'SPM-DITOLAK-VERIFIKATOR')||($data['posisi'] == 'SPM-DITOLAK-KBUU')){
                    // $this->db->where('tahun', $data['tahun']);
                    // $this->db->where('aktif', '1');
                    // $this->db->where('kode_unit_subunit', $kode_unit);
                    // $this->db->update('trx_nomor_pup', array('aktif'=>'0'));    

            }
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('kode_unit_subunit', $kode_unit);
            $this->db->where('id_trx_nomor_pup', $id_nomor_pup);
            $this->db->update('trx_pup', array('aktif'=>'0')); 
            
            return $this->db->insert('trx_pup',$data);
            
        }
        
        function final_pup($kode_unit,$data){
            
            
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('kd_unit', $kode_unit);
            $this->db->where('jenis', 'UP');
            $this->db->update('kas_bendahara', array('aktif'=>'0'));
            
            return $this->db->insert('kas_bendahara',$data);
            
        }
        
        function get_tgl_spp($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT MAX(tgl_proses) AS tgl_proses FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif='1' ");
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
        
        function get_nomor_spp($kode_unit_subunit,$tahun){
            
//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' " ; die;

//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' ";die;
            
            $q = $this->db->query("SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' ");
            
            
            
            if($q->num_rows() > 0){
               return $q->row()->nt ;
            }else{
                return '' ;
            }
        }

        function get_nomor_spp_by_id($id_trx_nomor_pup_spp){
            
//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' " ; die;

//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' ";die;

            $q = $this->db->query("SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE id_trx_nomor_pup = '{$id_trx_nomor_pup}' ");
            
            
            
            if($q->num_rows() > 0){
               return $q->row()->nt ;
            }else{
                return '' ;
            }
        }

        
        
        function get_nomor_spm($kode_unit_subunit,$tahun){
            
//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' " ; die;
            
            $q = $this->db->query("SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' AND aktif = '1' ");
            
            
            if($q->num_rows() > 0){
               return $q->row()->nt ;
            }else{
                return '' ;
            }
        }

        function get_nomor_spm_by_id($id_trx_nomor_pup_spm){
            
//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' " ; die;
            

            $q = $this->db->query("SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE id_trx_nomor_pup = '{$id_trx_nomor_pup_spm}' ");

            // echo "SELECT str_nomor_trx AS nt FROM trx_nomor_pup WHERE id_trx_nomor_pup = '{$id_trx_nomor_pup}' " ;  die ;
            
            if($q->num_rows() > 0){
               return $q->row()->nt ;
            }else{
                return '' ;
            }
        }
        
        function get_nomor_next_spp($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT IFNULL(MAX(nomor_trx),0) AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
//            if($q->num_rows() > 0){
//               return $q->row()->tgl_proses ;
//            }else{
                $x = intval($q->row()->nt) + 1;
        if(strlen($x)==1){
                $x = '000'.$x;
        }
        elseif(strlen($x)==2){
                $x = '00'.$x;
        }
        elseif(strlen($x)==3){
                $x = '0'.$x;
        }
        elseif(strlen($x)==4){
                $x = $x;
        }
        // elseif(strlen($x)==5){
        //      $x = $x;
        // }

        return $x;
//            } 
        }
        
        function get_nomor_next_spm($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT IFNULL(MAX(nomor_trx),0) AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
//            if($q->num_rows() > 0){
//               return $q->row()->tgl_proses ;
//            }else{
                $x = intval($q->row()->nt) + 1;
        if(strlen($x)==1){
                $x = '000'.$x;
        }
        elseif(strlen($x)==2){
                $x = '00'.$x;
        }
        elseif(strlen($x)==3){
                $x = '0'.$x;
        }
        elseif(strlen($x)==4){
                $x = $x;
        }
  //       elseif(strlen($x)==5){
        //      $x = $x;
        // }

        return $x;
//            } 
        }
        
        function get_id_nomor_pup($jenis,$kode_unit_subunit,$tahun){
//            echo "SELECT id_trx_nomor_pup FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}' AND aktif='1' "; die;
            $q = $this->db->query("SELECT id_trx_nomor_pup FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}' AND aktif='1' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->id_trx_nomor_pup ;
            }else{
            
            }
        }

        function get_id_nomor_pup_by_nomor_trx($str_nomor_trx){
//            echo "SELECT id_trx_nomor_pup FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}' AND aktif='1' "; die;
            $q = $this->db->query("SELECT id_trx_nomor_pup FROM trx_nomor_pup WHERE str_nomor_trx = '{$str_nomor_trx}' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->id_trx_nomor_pup ;
            }else{
            
            }
        }
        
        function get_tgl_spm($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT tgl_proses AS tgl_proses FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' AND aktif='1' ");
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
        
        function get_tgl_spm_kpa($kode_unit_subunit,$tahun,$nomor_trx_spm){
            
            $str = "SELECT trx_pup.tgl_proses FROM trx_nomor_pup "
                    . "JOIN trx_pup ON trx_nomor_pup.id_trx_nomor_pup = trx_pup.id_trx_nomor_pup "
                    . "WHERE trx_nomor_pup.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_pup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_pup.posisi = 'SPM-DRAFT-KPA' AND trx_nomor_pup.tahun = '{$tahun}' "
                    . "AND trx_nomor_pup.aktif = '1'";
                    
//            var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
        
        function get_tgl_spm_verifikator($kode_unit_subunit,$tahun,$nomor_trx_spm){
            
            $str = "SELECT trx_pup.tgl_proses FROM trx_nomor_pup "
                    . "JOIN trx_pup ON trx_nomor_pup.id_trx_nomor_pup = trx_pup.id_trx_nomor_pup "
                    . "WHERE trx_nomor_pup.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_pup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_pup.posisi = 'SPM-FINAL-VERIFIKATOR' AND trx_nomor_pup.tahun = '{$tahun}' "
                    . "AND trx_nomor_pup.aktif = '1'";
                    
//            var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
        
        function get_tgl_spm_kbuu($kode_unit_subunit,$tahun,$nomor_trx_spm){
            
            $str = "SELECT trx_pup.tgl_proses FROM trx_nomor_pup "
                    . "JOIN trx_pup ON trx_nomor_pup.id_trx_nomor_pup = trx_pup.id_trx_nomor_pup "
                    . "WHERE trx_nomor_pup.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_pup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_pup.posisi = 'SPM-FINAL-KBUU' AND trx_nomor_pup.tahun = '{$tahun}' "
                    . "AND trx_nomor_pup.aktif = '1'";
                    
//            var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            

        }
        
        function get_pup_unit_usul($tahun){
            
            // $query = "SELECT rba_2018.unit.nama_unit,rba_2018.unit.kode_unit,rsa_2018.trx_pup.posisi,rsa_2018.trx_pup.aktif,rsa_2018.trx_pup.tgl_proses,rsa_2018.trx_pup.tahun "
                    // . "FROM rba_2018.unit LEFT JOIN rsa_2018.trx_pup ON rba_2018.unit.kode_unit = rsa_2018.trx_pup.kode_unit_subunit "
                    // . "WHERE ( rsa_2018.trx_pup.aktif = '1' OR rsa_2018.trx_pup.aktif IS NULL ) "
                    // . "AND ( rsa_2018.trx_pup.tahun = '{$tahun}' OR rsa_2018.trx_pup.tahun IS NULL ) "
                    // . "GROUP BY rba_2018.unit.kode_unit "
                    // . "ORDER BY rba_2018.unit.kode_unit ASC";

            $query = "SELECT t1.nama_unit,t1.kode_unit,IFNULL(t3.jml,0) AS jml
FROM rba_2018.unit t1
LEFT JOIN (
    SELECT tr1.kode_unit_subunit AS kode_unit,COUNT(tr1.posisi) AS jml 
    FROM rsa_2018.trx_pup AS tr1 
    WHERE tr1.tahun = '{$tahun}' AND tr1.posisi = 'SPM-FINAL-VERIFIKATOR'  AND tr1.aktif = '1'
    GROUP BY tr1.kode_unit_subunit
) AS t3
ON t1.kode_unit = t3.kode_unit
GROUP BY t1.kode_unit 
ORDER BY t1.kode_unit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

        $result = $q->result();
                
//                var_dump($result);die;

        return $result ;
            
        }
        
        function get_pup_subunit_usul($tahun){
            
            // $query = "SELECT rba_2018.subunit.nama_subunit,rba_2018.subunit.kode_subunit,rsa_2018.trx_pup.posisi,rsa_2018.trx_pup.aktif,rsa_2018.trx_pup.tgl_proses,rsa_2018.trx_pup.tahun "
            //         . "FROM rba_2018.subunit LEFT JOIN rsa_2018.trx_pup ON rba_2018.subunit.kode_subunit = rsa_2018.trx_pup.kode_unit_subunit "
            //         . "WHERE ( rsa_2018.trx_pup.aktif = '1' OR rsa_2018.trx_pup.aktif IS NULL ) "
            //         . "AND ( rsa_2018.trx_pup.tahun = '{$tahun}' OR rsa_2018.trx_pup.tahun IS NULL ) "
            //         . "GROUP BY rba_2018.subunit.kode_subunit "
            //         . "ORDER BY rba_2018.subunit.kode_subunit ASC";

            $query = "SELECT t1.nama_subunit,t1.kode_subunit,IFNULL(t3.jml,0) AS jml
FROM rba_2018.subunit t1
LEFT JOIN (
    SELECT tr1.kode_unit_subunit AS kode_unit,COUNT(tr1.posisi) AS jml 
    FROM rsa_2018.trx_pup AS tr1 
    WHERE tr1.tahun = '{$tahun}' AND tr1.posisi = 'SPM-FINAL-VERIFIKATOR' AND tr1.aktif = '1'
    GROUP BY tr1.kode_unit_subunit
) AS t3
ON t1.kode_subunit = t3.kode_unit
GROUP BY t1.kode_subunit 
ORDER BY t1.kode_subunit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

        $result = $q->result();
                
//                var_dump($result);die;

        return $result ;
            
        }
        
        function get_pup_unit_usul_verifikator($id_user_verifikator,$tahun){
            
            // $query2 = "SELECT rba_2018.unit.nama_unit,rba_2018.unit.kode_unit,rsa_2018.trx_pup.posisi,rsa_2018.trx_pup.aktif,rsa_2018.trx_pup.tgl_proses,rsa_2018.trx_pup.tahun "
                    // . "FROM rba_2018.unit "
                    // . "JOIN rsa_verifikator_unit ON rba_2018.unit.kode_unit = rsa_verifikator_unit.kode_unit_subunit "
                    // . "LEFT JOIN rsa_2018.trx_pup ON rba_2018.unit.kode_unit = rsa_2018.trx_pup.kode_unit_subunit "
                    // . "WHERE rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
                    // . "AND ( rsa_2018.trx_pup.aktif = '1' OR rsa_2018.trx_pup.aktif IS NULL ) "
                    // . "AND ( rsa_2018.trx_pup.tahun = '{$tahun}' OR rsa_2018.trx_pup.tahun IS NULL ) "
                    // . "GROUP BY rba_2018.unit.kode_unit "
                    // . "ORDER BY rba_2018.unit.kode_unit ASC";


            // $query = "SELECT rba_2018.unit.nama_unit,rba_2018.unit.kode_unit,rsa_2018.trx_pup.tahun,SUM(IF(rsa_2018.trx_pup.posisi='SPM-DRAFT-KPA',1,0)) AS posisi_ver,SUM(IF((rsa_2018.trx_pup.posisi='SPM-FINAL-VERIFIKATOR')OR(rsa_2018.trx_pup.posisi='SPM-FINAL-KBUU')OR(rsa_2018.trx_pup.posisi='SPM-FINAL-BUU'),1,0)) AS posisi_out_ver FROM rba_2018.unit JOIN rsa_verifikator_unit ON rba_2018.unit.kode_unit = rsa_verifikator_unit.kode_unit_subunit LEFT JOIN rsa_2018.trx_pup ON rba_2018.unit.kode_unit = rsa_2018.trx_pup.kode_unit_subunit WHERE rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' AND ( rsa_2018.trx_pup.aktif = '1' OR rsa_2018.trx_pup.aktif IS NULL ) AND ( rsa_2018.trx_pup.tahun = '{$tahun}' OR rsa_2018.trx_pup.tahun IS NULL ) GROUP BY rba_2018.unit.kode_unit ORDER BY rba_2018.unit.kode_unit ASC" ;

                        $query = "SELECT t1.nama_unit,t1.kode_unit,IFNULL(t3.jml,0) AS jml
FROM rba_2018.unit t1
JOIN rsa_2018.rsa_verifikator_unit AS t2 ON t1.kode_unit = t2.kode_unit_subunit 
LEFT JOIN (
    SELECT tr1.kode_unit_subunit AS kode_unit,COUNT(tr1.posisi) AS jml 
    FROM rsa_2018.trx_pup AS tr1 
    WHERE tr1.tahun = '{$tahun}' AND tr1.posisi = 'SPM-DRAFT-KPA'  AND tr1.aktif = '1'
    GROUP BY tr1.kode_unit_subunit
) AS t3
ON t1.kode_unit = t3.kode_unit
WHERE t2.id_user_verifikator = '{$id_user_verifikator}' 
GROUP BY t1.kode_unit 
ORDER BY t1.kode_unit ASC";

                       // echo $query; die;

                $q = $this->db->query($query);

        $result = $q->result();
                
//                var_dump($result);die;

        return $result ;
            
        }
        
        function get_pup_subunit_usul_verifikator($id_user_verifikator,$tahun){
            
            // $query = "SELECT rba_2018.subunit.nama_subunit,rba_2018.subunit.kode_subunit,rsa_2018.trx_pup.posisi,rsa_2018.trx_pup.aktif,rsa_2018.trx_pup.tgl_proses,rsa_2018.trx_pup.tahun "
            //         . "FROM rba_2018.subunit "
            //         . "JOIN rsa_verifikator_unit ON SUBSTR(rba_2018.subunit.kode_subunit,1,2) = rsa_verifikator_unit.kode_unit_subunit "
            //         . "LEFT JOIN rsa_2018.trx_pup ON rba_2018.subunit.kode_subunit = rsa_2018.trx_pup.kode_unit_subunit "
            //         . "WHERE rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
            //         . "AND ( rsa_2018.trx_pup.aktif = '1' OR rsa_2018.trx_pup.aktif IS NULL ) "
            //         . "AND ( rsa_2018.trx_pup.tahun = '{$tahun}' OR rsa_2018.trx_pup.tahun IS NULL ) "
            //         . "GROUP BY rba_2018.subunit.kode_subunit "
            //         . "ORDER BY rba_2018.subunit.kode_subunit ASC";

            $query = "SELECT t1.nama_subunit,t1.kode_subunit,IFNULL(t3.jml,0) AS jml
FROM rba_2018.subunit t1
JOIN rsa_2018.rsa_verifikator_unit AS t2 ON SUBSTR(t1.kode_subunit,1,2) = t2.kode_unit_subunit 
LEFT JOIN (
    SELECT tr1.kode_unit_subunit AS kode_unit,COUNT(tr1.posisi) AS jml 
    FROM rsa_2018.trx_pup AS tr1 
    WHERE tr1.tahun = '{$tahun}' AND tr1.posisi = 'SPM-DRAFT-KPA' AND tr1.aktif = '1'
    GROUP BY tr1.kode_unit_subunit
) AS t3
ON t1.kode_subunit = t3.kode_unit
WHERE t2.id_user_verifikator = '{$id_user_verifikator}' 
GROUP BY t1.kode_subunit 
ORDER BY t1.kode_subunit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

        $result = $q->result();
                
//                var_dump($result);die;

        return $result ;
            
        }
        
        function get_pup_unit($tahun){
            
            $query = "SELECT rba_2018.unit.nama_unit,rba_2018.unit.kode_unit,rsa_2018.kas_bendahara.saldo "
                    . "FROM rba_2018.unit "
                    . "LEFT JOIN rsa_2018.kas_bendahara ON rba_2018.unit.kode_unit = rsa_2018.kas_bendahara.kd_unit "
                    . "WHERE ( rsa_2018.kas_bendahara.aktif = '1' OR rsa_2018.kas_bendahara.saldo IS NULL ) "
                    . "AND ( rsa_2018.kas_bendahara.tahun = '{$tahun}' OR rsa_2018.kas_bendahara.tahun IS NULL ) "
                    . "ORDER BY rba_2018.unit.kode_unit ASC" ;
                        
//                        echo $query; die;

                $q = $this->db->query($query);

        $result = $q->result();
                
//                var_dump($result);die;

        return $result ;
            
        }
        
//        function get_verifikator($kode_unit_subunit,$tahun,$nomor_trx_spm){
        function get_verifikator($kode_unit_subunit){
//            $str = "SELECT rsa_user.nm_lengkap,rsa_user.nip FROM trx_spm_verifikator "
//                    . "JOIN rsa_user ON rsa_user.id = trx_spm_verifikator.id_rsa_user_verifikator "
//                    . "JOIN trx_nomor_pup ON trx_nomor_pup.nomor_trx = trx_spm_verifikator.nomor_trx_spm "
//                    . "WHERE trx_nomor_pup.kode_unit_subunit = '{$kode_unit_subunit}' "
//                    . "AND trx_nomor_pup.nomor_trx = '{$nomor_trx_spm}' "
//                    . "AND trx_spm_verifikator.tahun = '{$tahun}' ";
                    
            
                    
//            $nomor_ = explode('/',$nomor_trx_spm);
//            $nomor = (int)$nomor_[0];
                    
//            $str1 = "SELECT rsa_user.nm_lengkap,rsa_user.nomor_induk "
//                    . "FROM trx_spm_verifikator "
//                    . "JOIN rsa_user ON rsa_user.id = trx_spm_verifikator.id_rsa_user_verifikator "
//                    . "WHERE trx_spm_verifikator.kode_unit_subunit = '{$kode_unit_subunit}' "
//                    . "AND trx_spm_verifikator.nomor_trx_spm = '{$nomor}' "
//                    . "AND jenis_trx = 'TUP' "
//                    . "AND trx_spm_verifikator.tahun = '{$tahun}' " ;
                    
            $str2 = "SELECT rsa_user.nm_lengkap,rsa_user.nomor_induk FROM rsa_verifikator_unit "
                    . "JOIN rsa_user ON rsa_user.id = rsa_verifikator_unit.id_user_verifikator "
                    . "WHERE rsa_verifikator_unit.kode_unit_subunit = '{$kode_unit_subunit}' " ;
                    
//            var_dump($str1);die;
//            $q = $this->db->query($str1);        
            $q = $this->db->query($str2);
    //            var_dump($q->num_rows());die;
                // if($q->num_rows() > 0){
//                var_dump($q->row());die;
                   return $q->row();
                // }else{
                   // return '';
                // } 
        }
        
        function proses_verifikator_pup($data){
        //print_r($data);die;
        return $this->db->insert("trx_spm_verifikator",$data);
        
    }
        
        function get_next_urut_spm_cair($tahun){
            $q = $this->db->query("SELECT IFNULL(MAX(no_urut),0) AS nt FROM trx_urut_spm_cair WHERE tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
//            if($q->num_rows() > 0){
//               return $q->row()->tgl_proses ;
//            }else{
                $x = intval($q->row()->nt) + 1;
        if(strlen($x)==1){
                $x = '00000'.$x;
        }
        elseif(strlen($x)==2){
                $x = '0000'.$x;
        }
        elseif(strlen($x)==3){
                $x = '000'.$x;
        }
                elseif(strlen($x)==4){
                $x = '00'.$x;
        }
                elseif(strlen($x)==5){
                $x = '0'.$x;
        }
                elseif(strlen($x)==6){
                $x = $x;
        }
                

        return $x;
        }
        
        function spm_cair($data){
            return $this->db->insert("trx_urut_spm_cair",$data);
            
        }
        
        function get_daftar_spp($kode_unit_subunit,$tahun){
            
            // $query2 = "SELECT *,t1.tgl_proses,t2.jumlah_bayar AS tgl_proses_status "
            //         . "FROM trx_nomor_lsnk AS tt1 "
            //         . "JOIN trx_lsnk AS t1 ON t1.id_trx_nomor_lsnk = tt1.id_trx_nomor_lsnk "
            //         . "JOIN trx_spp_lsnk_data AS t2 ON t2.nomor_trx_spp = tt1.id_trx_nomor_lsnk "
            //         . "WHERE tt1.kode_unit_subunit = '{$kode_unit_subunit}' "
            //         . "AND jenis = 'SPP' "
            //         . "AND tt1.tahun = '{$tahun}' "
            //         . "AND t1.tgl_proses IN ( "
            //             . "SELECT MAX(t2.tgl_proses) FROM trx_lsnk AS t2 "
            //             . "WHERE t2.id_trx_nomor_lsnk = t1.id_trx_nomor_lsnk ) " 
            //         . "ORDER BY tt1.id_trx_nomor_lsnk " ;

            $query = "SELECT tt1.str_nomor_trx AS str_nomor_trx_spp,t3.str_nomor_trx AS str_nomor_trx_spm,t1.tgl_proses,t2.untuk_bayar,t2.jumlah_bayar, t1.posisi FROM trx_nomor_pup AS tt1 JOIN trx_pup AS t1 ON t1.id_trx_nomor_pup = tt1.id_trx_nomor_pup JOIN trx_spp_pup_data AS t2 ON t2.nomor_trx_spp = tt1.id_trx_nomor_pup LEFT JOIN trx_spm_pup_data AS t3 ON t3.nomor_trx_spm = t1.id_trx_nomor_pup_spm WHERE tt1.kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP' AND tt1.tahun = '{$tahun}' AND t1.aktif = '1' GROUP BY tt1.id_trx_nomor_pup ORDER BY tt1.id_trx_nomor_pup DESC" ;
                        
            // echo $query; die;

                $q = $this->db->query($query);

        $result = $q->result();
                
//                var_dump($result);die;

        return $result ;
        }

        function get_daftar_spm($kode_unit_subunit,$tahun){
            
            $query = "SELECT *,t1.tgl_proses AS tgl_proses_status "
                    . "FROM trx_nomor_pup AS tt1 "
                    . "JOIN trx_pup AS t1 ON t1.id_trx_nomor_pup = tt1.id_trx_nomor_pup "
                    . "WHERE tt1.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND jenis = 'SPM' "
                    . "AND tt1.tahun = '{$tahun}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_pup AS t2 "
                        . "WHERE t2.id_trx_nomor_pup = t1.id_trx_nomor_pup )" ;
                        
//                        echo $query; die;

                $q = $this->db->query($query);

        $result = $q->result();
                
//                var_dump($result);die;

        return $result ;
        }
        
        function proses_data_spp($data){
            return $this->db->insert("trx_spp_pup_data",$data);
        }
        
        function get_data_spp($str_nomor_trx){
            $this->db->where('str_nomor_trx',$str_nomor_trx);
            $query = $this->db->get("trx_spp_pup_data");
    //  print_r($query);die;
//            if($query->num_rows()>0){
                    return $query->row();
//            }else{
//                    return array();
//            }
        }
        
        function proses_data_spm($data){
            return $this->db->insert("trx_spm_pup_data",$data);
        }
        
        function get_data_spm($str_nomor_trx){
            $this->db->where('str_nomor_trx',$str_nomor_trx);
            $query = $this->db->get("trx_spm_pup_data");
    //  print_r($query);die;
//            if($query->num_rows()>0){
                    return $query->row();
//            }else{
//                    return array();
//            }
        }
        
//        function get_urut($kode_unit_subunit,$jenis,$tahun){
//            $q = $this->db->query("SELECT IFNULL(MAX(urut),0) AS nt FROM trx_nomor_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
//            if($q->num_rows() > 0){
//               return $q->row()->tgl_proses ;
//            }else{
//                $x = intval($q->row()->nt) + 1;
//      if(strlen($x)==1){
//              $x = '0000'.$x;
//      }
//      elseif(strlen($x)==2){
//              $x = '000'.$x;
//      }
//      elseif(strlen($x)==3){
//              $x = '00'.$x;
//      }
//                elseif(strlen($x)==4){
//              $x = '0'.$x;
//      }
//                elseif(strlen($x)==5){
//              $x = $x;
//      }

//      return $x;
//        }


            function ks_to_nihil($data_pup_to_nihil){

                $this->db->where('tahun', $data_pup_to_nihil['tahun']);
                $this->db->where('status', '1');
                $this->db->where('kd_unit_subunit', $data_pup_to_nihil['kode_unit_subunit']);
                $this->db->update('trx_pup_to_nihil', array('status'=>'0'));


                return $this->db->insert("trx_pup_to_nihil",$data_pup_to_nihil);

            }


            function get_status_nihil($unit,$tahun){

                $query = "SELECT str_nomor_trx_spm_pup FROM trx_pup_to_nihil WHERE kode_unit_subunit = '{$unit}' AND status = '1'" ;

                // echo $query ; die;

                $q = $this->db->query($query);

                if($q->num_rows() > 0){
                   return $q->row()->str_nomor_trx_spm_pup ;
                }else{
                    return '';
                } 

            }

            function get_unit_under_verifikator($id_user_verifikator){
            $query = "SELECT kode_unit_subunit FROM rsa_verifikator_unit WHERE id_user_verifikator = '{$id_user_verifikator}' " ;

            $q = $this->db->query($query);

            return $q->result() ;

        }


            function get_notif_approve($kode_unit_subunit,$level,$id_user_verifikator){

                    $query = '' ;

                    if($level == '14'){ // PPK SUKPA
                           $query = "SELECT COUNT(posisi) AS jml FROM trx_pup WHERE ( posisi = 'SPP-DRAFT' OR posisi = 'SPP-FINAL' ) AND kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1' " ; 

                        }else if($level == '2'){ // KPA
                            $query = "SELECT COUNT(posisi) AS jml FROM trx_pup WHERE posisi = 'SPM-DRAFT-PPK' AND kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1' " ; 

                        }else if($level == '3'){ // VERIFIKATOR

                            $unit = $this->get_unit_under_verifikator($id_user_verifikator);
                            $str_unit = '' ;
                            foreach($unit as $u){
                                $str_unit = $str_unit . "'". $u->kode_unit_subunit . "'," ; 
                            }

                            $str_unit = substr($str_unit, 0, -1);

                            // echo $str_unit ; die ;

                            $query = "SELECT COUNT(posisi) AS jml FROM trx_pup WHERE posisi = 'SPM-DRAFT-KPA' AND SUBSTR(kode_unit_subunit,1,2) IN ({$str_unit}) AND aktif = '1' " ; 

                           // echo $query ; die ;

                        }else if($level == '11'){ // KBUU
                            $query = "SELECT COUNT(posisi) AS jml FROM trx_pup WHERE posisi = 'SPM-FINAL-VERIFIKATOR' AND aktif = '1' GROUP BY  posisi " ;

                        }

                        // echo $query ; die ;

                    $q = $this->db->query($query);

                    if($q->num_rows() > 0){
                       return $q->row()->jml;
                    }else{
                        return '0';
                    }

        }

        function get_nomor_spp_urut($unit,$tahun){

            $query = "SELECT MAX(id_trx_nomor_pup) AS id_max FROM  trx_nomor_pup WHERE kode_unit_subunit = '{$unit}' AND tahun = '{$tahun}' AND jenis = 'SPP' " ;

            // echo $query ; die;


            $q = $this->db->query($query);

                    if(!is_null($q->row()->id_max)){
                       return $q->row()->id_max;
                    }else{
                        return '0';
                    }



        }

        function get_nomor_spp_urut_by_nomor_spp($str_nomor_trx_spp){

            $query = "SELECT id_trx_nomor_pup FROM  trx_nomor_pup WHERE str_nomor_trx = '{$str_nomor_trx_spp}' " ;

            // echo $query ; die;


            $q = $this->db->query($query);

                    if(!is_null($q->row()->id_trx_nomor_pup)){
                       return $q->row()->id_trx_nomor_pup;
                    }else{
                        return '0';
                    }



        }

        function get_nomor_spm_urut_by_nomor_spp($str_nomor_trx_spp){

            $query = "SELECT nomor_trx_spm FROM trx_spp_spm WHERE str_nomor_trx_spp = '{$str_nomor_trx_spp}' " ;

            // echo $query ; die;


            $q = $this->db->query($query);

                    if(!is_null($q->row()->nomor_trx_spm)){
                       return $q->row()->nomor_trx_spm;
                    }else{
                        return '0';
                    }



        }


        function check_dokumen_pup_by_str_trx($no_str_trx){

            $query = "SELECT posisi "
                    . "FROM trx_nomor_pup AS tt1 "
                    . "JOIN trx_pup AS t1 ON t1.id_trx_nomor_pup = tt1.id_trx_nomor_pup "
                    . "WHERE tt1.str_nomor_trx = '{$no_str_trx}' "
                    . "AND t1.id_trx_pup = ( 
SELECT MAX(t2.id_trx_pup) FROM trx_pup AS t2 WHERE t2.id_trx_nomor_pup = t1.id_trx_nomor_pup )" ;

// echo $query; die;

            $q = $this->db->query($query);
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->posisi ;
            }else{
                return '';
            }
        }

        function get_data_untuk_pekerjaan($q,$kode_unit_subunit,$tahun){

            $query = "SELECT DISTINCT(untuk_bayar) FROM  trx_spp_pup_data WHERE untuk_bayar LIKE '%{$q}%' AND kode_unit_subunit = '{$kode_unit_subunit}' AND tahun = '{$tahun}' " ;

            // echo $query ; die;


            $q = $this->db->query($query);

                    if($q->num_rows() > 0){
                       return $q->result();
                    }else{
                        return array();
                    }

        }


        function get_data_penerima($q,$kode_unit_subunit,$tahun){

            $query = "SELECT DISTINCT(CONCAT(penerima,'|',alamat,'|',nmbank,'|',nmrekening,'|',rekening,'|',npwp)) AS str_penerima FROM  trx_spp_pup_data WHERE penerima LIKE '%{$q}%' AND kode_unit_subunit = '{$kode_unit_subunit}' AND tahun = '{$tahun}' " ;

            // echo $query ; die;


            $q = $this->db->query($query);

                    if($q->num_rows() > 0){
                       return $q->result();
                    }else{
                        return array();
                    }

        }

        function get_spm_by_spp($str_nomor_trx_spp){
            
            $this->db->where('str_nomor_trx_spp',$str_nomor_trx_spp);
            $q = $this->db->get('trx_spp_spm');
            
            if($q->num_rows() > 0){
                return $q->row()->str_nomor_trx_spm; 
            }else{
                return ''; 
            }
            
            
        }
        
        function get_spp_by_spm($str_nomor_trx_spm){
            
            $this->db->where('str_nomor_trx_spm',$str_nomor_trx_spm);
            $q = $this->db->get('trx_spp_spm');
            
            if($q->num_rows() > 0){
                return $q->row()->str_nomor_trx_spp; 
            }else{
                return ''; 
            }
            
            
        }

        function get_tgl_spm_kpa_by_spp($nomor_trx_spp){

            $str = "SELECT trx_pup.tgl_proses FROM trx_nomor_pup "
                    . "JOIN trx_pup ON trx_nomor_pup.id_trx_nomor_pup = trx_pup.id_trx_nomor_pup "
                    . "WHERE trx_nomor_pup.str_nomor_trx = '{$nomor_trx_spp}' "
                    . "AND trx_pup.posisi = 'SPM-DRAFT-KPA'" ;
                
                    
           // var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }

        function get_tgl_spm_verifikator_by_spp($nomor_trx_spp){
            
            $str = "SELECT trx_pup.tgl_proses FROM trx_nomor_pup "
                    . "JOIN trx_pup ON trx_nomor_pup.id_trx_nomor_pup = trx_pup.id_trx_nomor_pup "
                    . "WHERE trx_nomor_pup.str_nomor_trx = '{$nomor_trx_spp}' "
                    . "AND trx_pup.posisi = 'SPM-FINAL-VERIFIKATOR'";
                    
           // var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }

        function get_tgl_spm_kbuu_by_spp($nomor_trx_spp){
            
            $str = "SELECT trx_pup.tgl_proses FROM trx_nomor_pup "
                    . "JOIN trx_pup ON trx_nomor_pup.id_trx_nomor_pup = trx_pup.id_trx_nomor_pup "
                    . "WHERE trx_nomor_pup.str_nomor_trx = '{$nomor_trx_spp}' "
                    . "AND trx_pup.posisi = 'SPM-FINAL-KBUU'";
                    
//            var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            

        }

        function get_verifikator_by_spm($nomor_trx_spm){ 

            $str2 = "SELECT nmverifikator AS nm_lengkap,nipverifikator AS nomor_induk FROM trx_spm_pup_data "
                    . "WHERE str_nomor_trx = '{$nomor_trx_spm}' " ;
                    
     
            $q = $this->db->query($str2);
                   return $q->row();

        }

        function lihat_ket_by_str_trx($no_str_trx){
            // $q = $this->db->query("SELECT ket FROM trx_pup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1'  AND tahun = '{$tahun}' ");

            $query = "SELECT ket "
                    . "FROM trx_nomor_pup AS tt1 "
                    . "JOIN trx_pup AS t1 ON t1.id_trx_nomor_pup = tt1.id_trx_nomor_pup "
                    . "WHERE tt1.str_nomor_trx = '{$no_str_trx}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_pup AS t2 "
                        . "WHERE t2.id_trx_nomor_pup = t1.id_trx_nomor_pup )" ;

            $q = $this->db->query($query);

//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->ket ;
            }else{
                return '';
            }
        }

        function check_exist_pup($nomor_trx,$tahun){
            $this->db->where('str_nomor_trx',$nomor_trx);
            $this->db->where('tahun',$tahun);
            $query = $this->db->get('trx_nomor_pup');
            if ($query->num_rows()>0){
                return true;
            }else{
                return false;
            }
        }
    
    
    
}
?>