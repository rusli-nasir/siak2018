<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Dpa_model extends CI_Model {
/* -------------- Constructor ------------- */

		private $db2;
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				$this->db2 = $this->load->database('rba', TRUE);
        }

        // function get_dpa_unit_usul($sumber_dana,$tahun){
        function get_dpa_unit_usul(){
                $rba = $this->load->database('rba', TRUE);
                // $query1 = "SELECT unit.nama_unit,unit.kode_unit "
                //         . "FROM detail_belanja_ "
                //         . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                //         . "WHERE detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' "
                //         . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,2) "
                //         . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,2) ASC";

                $query = "SELECT unit.nama_unit,unit.kode_unit "
                        . "FROM unit "
                        . "GROUP BY unit.kode_unit "
                        . "ORDER BY unit.kode_unit ASC";

                $q = $rba->query($query);

		$result = $q->result();

		return $result ;

        }
        
        // function get_dpa_unit_usul_verifikator($sumber_dana,$id_user_verifikator,$tahun){
        function get_dpa_unit_usul_verifikator($id_user_verifikator){
            
            $rba = $this->load->database('rba', TRUE);

            // $query1 = "SELECT unit.nama_unit,unit.kode_unit "
            //         . "FROM detail_belanja_ "
            //         . "JOIN rba_2018.unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = rba_2018.unit.kode_unit "
            //         . "JOIN rsa_2018.rsa_verifikator_unit ON rba_2018.unit.kode_unit = rsa_2018.rsa_verifikator_unit.kode_unit_subunit "
            //         . "WHERE rsa_2018.rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
            //         . "AND detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' "
            //         . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,2) "
            //         . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,2) ASC";

            $query = "SELECT unit.nama_unit,unit.kode_unit "
                        . "FROM unit "
                        . "JOIN rsa_2018.rsa_verifikator_unit ON rba_2018.unit.kode_unit = rsa_2018.rsa_verifikator_unit.kode_unit_subunit "
                        . "WHERE rsa_2018.rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
                        . "GROUP BY unit.kode_unit "
                        . "ORDER BY unit.kode_unit ASC";
                        
//              $rba = $this->load->database('rba', TRUE);
//                $query = "SELECT unit.nama_unit,unit.kode_unit "
//                        . "FROM detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
//                        . "WHERE detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' "
//                        . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,2) "
//                        . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,2) ASC";

                $q = $rba->query($query);

		$result = $q->result();

		return $result ;
            
        }
		//tambahan takut error
        function get_dpa_unit_usul_ya($sumber_dana,$tahun,$kode_unit){
			//var_dump($tahun);die;
                //$rba = $this->load->database('rba', TRUE);

                $query = "SELECT unit.nama_unit,unit.kode_unit,nama_unit,sumber_dana,SUM(volume*harga_satuan)as total,alias,sumber_dana,tahun "
                        . "FROM detail_belanja_ "
                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' AND LEFT(detail_belanja_.kode_usulan_belanja,2) = '{$kode_unit}' "
                        . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,2) ASC";

                $q = $this->db->query($query);

		$result = $q->result();

		return $result ;

        }
		  function get_program_unit_usul($unit,$sumber_dana,$tahun){
              $rba = $this->load->database('rba', TRUE);
                $query = "SELECT *,SUM(volume*harga_satuan)as total,rba_2018.unit.nama_unit,rba_2018.kegiatan.nama_kegiatan,rba_2018.output.nama_output,rba_2018.program.nama_program
FROM rsa_2018.rsa_detail_belanja_

JOIN rba_2018.unit ON LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = rba_2018.unit.kode_unit

LEFT JOIN rba_2018.kegiatan ON rba_2018.kegiatan.kode_kegiatan = SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,7,2)
LEFT JOIN rba_2018.output ON kode_output = SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2) AND rba_2018.output.kode_kegiatan = SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2)
LEFT JOIN rba_2018.program ON kode_program = SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,11,2) AND rba_2018.program.kode_kegiatan = SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2) AND rba_2018.program.kode_output = SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2)
 "
                        . "WHERE rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' AND LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' "
                        . "GROUP BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,6)"
                        . "ORDER BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,6) ASC";
			//var_dump($query);die;
                $q = $this->db->query($query);//query($query);
		//var_dump($query);die;
		$result = $q->result();

		return $result ;

        }
        
        function get_program_unit_usul_idris($unit,$sumber_dana,$tahun){

              $rba = $this->load->database('rba', TRUE);

                $query = "SELECT *,SUM(det1.volume*det1.harga_satuan)as total,rba_2018.unit.nama_unit,rba_2018.kegiatan.nama_kegiatan,rba_2018.output.nama_output,rba_2018.program.nama_program
FROM rba_2018.detail_belanja_ AS det1

JOIN rba_2018.unit ON LEFT(det1.kode_usulan_belanja,2) = rba_2018.unit.kode_unit

LEFT JOIN rba_2018.kegiatan ON rba_2018.kegiatan.kode_kegiatan = SUBSTR(det1.kode_usulan_belanja,7,2)
LEFT JOIN rba_2018.output ON kode_output = SUBSTR(det1.kode_usulan_belanja,9,2) AND rba_2018.output.kode_kegiatan = SUBSTR(det1.kode_usulan_belanja,7,2)
LEFT JOIN rba_2018.program ON kode_program = SUBSTR(det1.kode_usulan_belanja,11,2) AND rba_2018.program.kode_kegiatan = SUBSTR(det1.kode_usulan_belanja,7,2) AND rba_2018.program.kode_output = SUBSTR(det1.kode_usulan_belanja,9,2)
 "
                        . "WHERE det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' AND LEFT(det1.kode_usulan_belanja,2) = '{$unit}' " 
                        . "AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' AND LEFT(det2.kode_usulan_belanja,2) = '{$unit}' GROUP BY LEFT(det2.kode_usulan_belanja,2)  ) "
                        . "GROUP BY SUBSTR(det1.kode_usulan_belanja,7,6)"
                        . "ORDER BY SUBSTR(det1.kode_usulan_belanja,7,6) ASC";

        // echo $query; die; 

            //var_dump($query);die;
        $q = $rba->query($query);//query($query);
        //var_dump($query);die;
        $result = $q->result();

        return $result ;

        }
        
        
		 function get_jumlah_unit_usul($unit,$sumber_dana,$tahun){

                $query = "SELECT *,rba_2018.unit.nama_unit,rba_2018.unit.kode_unit,SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,6) as program,SUM(volume*harga_satuan)as total  FROM rsa_detail_belanja_"
                        . " JOIN rba_2018.unit ON LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = rba_2018.unit.kode_unit "
                        . "WHERE rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' AND LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' ";

         $q = $this->db->query($query);//query($query);
		$result = $q->result();

		return $result ;

        }
        
        function get_jumlah_unit_usul_idris($unit,$sumber_dana,$tahun){

            $rba = $this->load->database('rba',TRUE);

                $query = "SELECT *,rba_2018.unit.nama_unit,rba_2018.unit.kode_unit,SUBSTR(det1.kode_usulan_belanja,7,6) as program,SUM(det1.volume*det1.harga_satuan)as total  FROM detail_belanja_ AS det1"
                        . " JOIN rba_2018.unit ON LEFT(det1.kode_usulan_belanja,2) = rba_2018.unit.kode_unit "
                        . "WHERE det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' AND LEFT(det1.kode_usulan_belanja,2) = '{$unit}' "
                        . "AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' AND LEFT(det2.kode_usulan_belanja,2) = '{$unit}' GROUP BY LEFT(det2.kode_usulan_belanja,2)  ) " ;

         $q = $rba->query($query);//query($query);
        $result = $q->result();

        return $result ;

        }
        
        function get_dpa_unit_impor($unit,$tahun){ // $sumber_dana, SUMBER DANA DIHILANGKAN
//                $rba = $this->load->database('rba', TRUE);
                $lenunit = strlen($unit);
                $query = "SELECT MAX(rba_2018.detail_belanja_.impor) AS impor "
                        . "FROM rba_2018.detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,{$lenunit}) "
                        . "ORDER BY LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,{$lenunit}) ASC";
                        
                       // echo $query; die;

                $q = $this->db->query($query);

		$result = $q->row();

		return empty($result)?'0':$result->impor ;

        }
        
        function get_dpa_unit_revisi($unit,$tahun){ // SUMBER DANA DIHILANGKAN
//                $rba = $this->load->database('rba', TRUE);
                $lenunit = strlen($unit);
                $query = "SELECT MAX(rba_2018.detail_belanja_.revisi) AS revisi "
                        . "FROM rba_2018.detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,{$lenunit}) "
                        . "ORDER BY LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,{$lenunit}) ASC";
                        
                       // echo $query; die;

                $q = $this->db->query($query);

		$result = $q->row();

		return empty($result)?'0':$result->revisi ;

        }
        
        function get_dpa_unit_proses_to_validate_ppk($unit,$sumber_dana,$tahun){
//                $rba = $this->load->database('rba', TRUE);

                $query = "SELECT COUNT(rsa_detail_belanja_.proses) AS proses "
                        . "FROM rsa_detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                        . "AND LEFT(rsa_detail_belanja_.proses,1) = '1' "
//                        . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) ASC";

                $q = $this->db->query($query);

		$result = $q->row();

		return empty($result)?'0':$result->proses ;

        }

        function get_dpa_unit_proses_to_validate($unit,$sumber_dana,$tahun){
//                $rba = $this->load->database('rba', TRUE);

                $query = "SELECT COUNT(rsa_detail_belanja_.proses) AS proses "
                        . "FROM rsa_detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                        . "AND LEFT(rsa_detail_belanja_.proses,1) = '2' "
//                        . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) ASC";


                // echo $query; die;

                $q = $this->db->query($query);

		$result = $q->row();

		return empty($result)?'0':$result->proses ;

        }

//         function get_dpa_unit_rkat($unit,$sumber_dana,$tahun){
//                 $rba = $this->load->database('rba', TRUE);

//                 $query = "SELECT MAX(revisi) AS revisi FROM detail_belanja_ WHERE "
//                         . "LEFT(detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' "
//                         . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,2) "
//                         . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,2) ASC";

//                 $q = $rba->query($query);

//                 $result = $q->row();

// 		$revisi = empty($result)?'0':$result->revisi ;

//                 $query = "SELECT SUM(detail_belanja_.volume*detail_belanja_.harga_satuan) AS rkat "
//                         . "FROM detail_belanja_ "
// //                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
//                         . "WHERE LEFT(detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' AND revisi = '{$revisi}' "
//                         . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,2) "
//                         . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,2) ASC";


//                         // echo $query ; die;

//                 $q = $rba->query($query);

// 		$result = $q->row();

// 		return empty($result)?'0':$result->rkat ;

//         }


        function get_dpa_unit_rkat($unit,$tahun,$sumber_dana=""){
        // echo $sumber_dana; die;
               $rba = $this->load->database('rba', TRUE);
            // $this->cur_tahun = $this->setting_model->get_tahun();
            // $tahun = $this->cur_tahun;

                $query = "SELECT MAX(revisi) AS revisi FROM detail_belanja_ WHERE "
                        . "LEFT(detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,2) ASC";

                $q = $rba->query($query);

                $result = $q->row();

        $revisi = empty($result)?'0':$result->revisi ;

        if($sumber_dana==""){

                $query = "SELECT SUM(detail_belanja_.volume*detail_belanja_.harga_satuan) AS rkat "
                        . "FROM detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE LEFT(detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_.tahun = '{$tahun}' AND revisi = '{$revisi}' "
                        . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,2) ASC";

        }else{

                    $query = "SELECT SUM(detail_belanja_.volume*detail_belanja_.harga_satuan) AS rkat "
                        . "FROM detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE LEFT(detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' AND revisi = '{$revisi}' "
                        . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,2) ASC";

        }


                        // echo $query ; die;

                $q = $rba->query($query);

        $result = $q->row();

        return empty($result)?'0':$result->rkat ;

        }

        function get_dpa_unit_rsa($unit,$sumber_dana,$tahun){
               $rba = $this->load->database('rba', TRUE);

                $query1 = "SELECT MAX(rsa_detail_belanja_.impor) AS impor "
                        . "FROM rsa_detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) ASC";

                $query = "SELECT MAX(detail_belanja_.impor) AS impor "
                        . "FROM detail_belanja_ "
                        . "WHERE SUBSTR(detail_belanja_.kode_usulan_belanja,1,2) = '{$unit}' AND detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY SUBSTR(detail_belanja_.kode_usulan_belanja,1,2) ";


                        // echo $query ; die;

                // $q = $this->db->query($query);
                        $q = $rba->query($query);

		$result = $q->row();

		$impor = empty($result)?'0':$result->impor ;

                $query = "SELECT SUM(detail_belanja_.volume*detail_belanja_.harga_satuan) AS rsa "
                        . "FROM detail_belanja_ "
//                        . "JOIN rba_2018.unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = rba_2018.unit.kode_unit "
                        . "WHERE SUBSTR(detail_belanja_.kode_usulan_belanja,1,2) = '{$unit}' AND detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' AND detail_belanja_.impor = '{$impor}' "
                        . "GROUP BY SUBSTR(detail_belanja_.kode_usulan_belanja,1,2) ";

                        // echo $query ; die;

                // $q = $this->db->query($query);

                        $q = $rba->query($query);

		$result = $q->row();

		return empty($result)?'0':$result->rsa ;

        }


        function post_dpa_impor($unit,$sumber_dana,$tahun){

            $rba = $this->load->database('rba', TRUE);

            $query = "SELECT MAX(revisi) AS revisi FROM detail_belanja_ WHERE "
                    . "LEFT(detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' "
                    . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,2) "
                    . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,2) ASC";

            $q = $rba->query($query);

            $result = $q->row();

            $revisi = empty($result)?'0':$result->revisi ;

            $query = "SELECT MAX(rsa_detail_belanja_.impor) AS impor "
                    . "FROM rsa_detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                    . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                    . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) "
                    . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) ASC";

            $q = $this->db->query($query);

            $result = $q->row();

            $impor = empty($result)?'1':($result->impor + 1 ) ;
            
            if(($impor - 1) == $revisi){

                $tanggal_impor = date("Y-m-d H:i:s");

                $query = "INSERT INTO rsa_detail_belanja_ (kode_usulan_belanja,deskripsi,sumber_dana,volume,satuan,harga_satuan,tahun,username,tanggal_transaksi,flag_cetak,revisi,kode_akun_tambah,impor,tanggal_impor) "
                        . "SELECT kode_usulan_belanja,deskripsi,sumber_dana,volume,satuan,harga_satuan,tahun,username,tanggal_transaksi,flag_cetak,revisi,kode_akun_tambah,'{$impor}' AS impor,'{$tanggal_impor}' AS tanggal_impor FROM rba_2018.detail_belanja_ WHERE LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.revisi = '{$revisi}'";

    //            echo $query ; die ;

                return $this->db->query($query);
            }else{
                false;
            }

        }
		//IMPORT REVISI KE RKAT
		function post_dpa_revisi($unit,$sumber_dana,$tahun){
             $query = "SELECT MAX(impor) AS impor "
                    . "FROM rsa_detail_belanja_  WHERE LEFT(kode_usulan_belanja,2) = '{$unit}' AND sumber_dana = '{$sumber_dana}' AND tahun = '{$tahun}' "
                    . "GROUP BY LEFT(kode_usulan_belanja,2) "
                    . "ORDER BY LEFT(kode_usulan_belanja,2) ASC";

            $q = $this->db->query($query);
            $result = $q->row();

            $impor = empty($result)?'0':$result->impor ;
            $rba = $this->load->database('rba', TRUE);


			$query = "SELECT MAX(detail_belanja_b.revisi) AS revisi FROM detail_belanja_b WHERE LEFT(detail_belanja_b.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_b.sumber_dana = '{$sumber_dana}' AND detail_belanja_b.tahun = '{$tahun}' "
                    . "GROUP BY LEFT(detail_belanja_b.kode_usulan_belanja,2) "
                    . "ORDER BY LEFT(detail_belanja_b.kode_usulan_belanja,2) ASC";

            $q = $rba->query($query);
            $result = $q->row();
            $revisi = empty($result)?'1':($result->revisi + 1 ) ;
            $tanggal_impor = date("Y-m-d H:i:s");
            $query = "INSERT INTO rba_2018.detail_belanja_b (kode_usulan_belanja,deskripsi,sumber_dana,volume,satuan,harga_satuan,tahun,username,tanggal_transaksi,flag_cetak,revisi,kode_akun_tambah,impor,proses) "
                    . "SELECT kode_usulan_belanja,deskripsi,sumber_dana,volume,satuan,harga_satuan,tahun,username,tanggal_transaksi,flag_cetak,revisi,kode_akun_tambah,impor,proses FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.impor = '{$impor}'";

            //echo $query ; die ;

              return $this->db->query($query);

        }

        function get_dpa_unit_to_validate($unit,$sumber_dana,$tahun){
//                $rba = $this->load->database('rba', TRUE);

                $query = "SELECT MAX(rsa_detail_belanja_.impor) AS impor "
                        . "FROM rsa_detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) " ;

                $q = $this->db->query($query);

		$result = $q->row();

		$impor = empty($result)?'0':$result->impor ;

                $query = "SELECT SUM(rsa_detail_belanja_.volume*rsa_detail_belanja_.harga_satuan) AS rsa "
                        . "FROM rsa_detail_belanja_ "
//                        . "JOIN rba_2018.unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = rba_2018.unit.kode_unit "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' AND rsa_detail_belanja_.impor = '{$impor}' "
                        . "AND LEFT(rsa_detail_belanja_.proses,1) = '6' "
                        . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) ";

                $q = $this->db->query($query);

		$result = $q->row();

		return empty($result)?'0':$result->rsa ;

        }



        function get_dpa_program_usul($unit,$sumber_dana,$tahun){
                $rba = $this->load->database('rba', TRUE);
                
                $lenkd = strlen($unit);

                $query = "SELECT LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) AS k_unit,SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) AS kode_rka,rba_2018.program.nama_program,rba_2018.komponen_input.nama_komponen,rba_2018.subkomponen_input.nama_subkomponen,SUM(rsa_detail_belanja_.volume*rsa_detail_belanja_.harga_satuan) AS jumlah_tot,rsa_detail_belanja_.proses "
                        . "FROM rsa_detail_belanja_ "
                        . "JOIN rba_2018.program ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2) = rba_2018.program.kode_kegiatan AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2) = rba_2018.program.kode_output AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,11,2) = rba_2018.program.kode_program "
                        . "JOIN rba_2018.komponen_input ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2) = rba_2018.komponen_input.kode_kegiatan AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2) = rba_2018.komponen_input.kode_output AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,11,2) = rba_2018.komponen_input.kode_program AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,13,2) = rba_2018.komponen_input.kode_komponen "
                        . "JOIN rba_2018.subkomponen_input ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2) = rba_2018.subkomponen_input.kode_kegiatan AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2) = rba_2018.subkomponen_input.kode_output AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,11,2) = rba_2018.subkomponen_input.kode_program AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,13,2) = rba_2018.subkomponen_input.kode_komponen AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,15,2) = rba_2018.subkomponen_input.kode_subkomponen "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) "
                        . "ORDER BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) ASC";
                        
                $query2 = "SELECT SUBSTR(det1.kode_usulan_belanja,1,2) AS k_unit,SUBSTR(det1.kode_usulan_belanja,7,10) AS kode_rka,rba_2018.program.nama_program,rba_2018.komponen_input.nama_komponen,rba_2018.subkomponen_input.nama_subkomponen,SUM(det1.volume*det1.harga_satuan) AS jumlah_tot "
                        . "FROM rba_2018.detail_belanja_ AS det1 "
                        . "JOIN rba_2018.program ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.program.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.program.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.program.kode_program "
                        . "JOIN rba_2018.komponen_input ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.komponen_input.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.komponen_input.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.komponen_input.kode_program AND SUBSTR(det1.kode_usulan_belanja,13,2) = rba_2018.komponen_input.kode_komponen "
                        . "JOIN rba_2018.subkomponen_input ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.subkomponen_input.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.subkomponen_input.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.subkomponen_input.kode_program AND SUBSTR(det1.kode_usulan_belanja,13,2) = rba_2018.subkomponen_input.kode_komponen AND SUBSTR(det1.kode_usulan_belanja,15,2) = rba_2018.subkomponen_input.kode_subkomponen "
                        . "WHERE SUBSTR(det1.kode_usulan_belanja,1,{$lenkd}) = '{$unit}' "
                        . "AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' "
                        . "AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE LEFT(det2.kode_usulan_belanja,{$lenkd}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,{$lenkd})  ) "
                        . "GROUP BY SUBSTR(det1.kode_usulan_belanja,7,10) "
                        . "ORDER BY SUBSTR(det1.kode_usulan_belanja,7,10) ASC";


// echo $query2 ; die;
//                $q = $this->db->query($query);
                        
        $q = $rba->query($query2);

		$result = $q->result();

        $r = array();

        foreach($result as $res){
            $r1 = array() ;

            $r1['k_unit'] = $res->k_unit ;
            $r1['kode_rka'] = $res->kode_rka ;
            $r1['nama_program'] = $res->nama_program ;
            $r1['nama_komponen'] = $res->nama_komponen ;
            $r1['nama_subkomponen'] = $res->nama_subkomponen ;
            $r1['jumlah_tot'] = $res->jumlah_tot ;
            $r1['jumlah_rsa'] = $this->get_rsa_by_rka(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun) ;

            $r[] = (object)$r1 ;
        }



        // echo '<pre>' ;
        // var_dump((object)$r) ; 
        // echo '</pre>' ; 
        // die ;

		// return $result ;
        return (object)$r ;

        }

        function get_notif_dpa($unit,$tahun,$proses){
            $lenunit = strlen($unit) ;

            $query = "SELECT COUNT(det1.proses) AS jml FROM rsa_detail_belanja_  AS det1 WHERE SUBSTR(det1.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det1.tahun = '{$tahun}' AND SUBSTR(det1.proses,1,1) = '{$proses}' AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.tahun = '{$tahun}' GROUP BY SUBSTR(det2.kode_usulan_belanja,1,{$lenunit})  ) GROUP BY SUBSTR(det1.kode_usulan_belanja,1,{$lenunit}) " ;


            // echo $query; die;


            $q= $this->db->query($query);

            if($q->num_rows() > 0){
                return $q->row()->jml ;
            }else{
                return 0 ;
            }

        }

        function get_notif_dpa_siap($unit,$tahun,$jenis){

            $lenunit = strlen($unit) ;

            $jml_dpa = 0 ;

            // $query1 = "SELECT COUNT(det1.proses) AS jml FROM rsa_detail_belanja_  AS det1 WHERE SUBSTR(det1.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det1.tahun = '{$tahun}' AND SUBSTR(det1.proses,1,1) = '3'  AND SUBSTR(det1.proses,2,1) = '{$jenis}' AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.tahun = '{$tahun}' GROUP BY SUBSTR(det2.kode_usulan_belanja,1,{$lenunit})  ) GROUP BY SUBSTR(det1.kode_usulan_belanja,1,{$lenunit}) " ;

            $query = "SELECT COUNT(det1.proses) AS jml FROM rsa_2018.rsa_detail_belanja_ AS det1 WHERE SUBSTR(det1.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det1.tahun = '{$tahun}' AND SUBSTR(det1.proses,1,1) = '3' AND SUBSTR(det1.proses,2,1) = '{$jenis}' AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.tahun = '{$tahun}' GROUP BY SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) ) AND (det1.kode_usulan_belanja,det1.kode_akun_tambah) NOT IN ( SELECT rsa_kuitansi_detail.kode_usulan_belanja,rsa_kuitansi_detail.kode_akun_tambah FROM rsa_kuitansi_detail JOIN rsa_kuitansi ON rsa_kuitansi_detail.id_kuitansi = rsa_kuitansi.id_kuitansi  WHERE SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND rsa_kuitansi_detail.tahun = '{$tahun}' AND rsa_kuitansi.aktif = '1' AND rsa_kuitansi.cair = '0' )" ;


            // echo $query; die;


            $q= $this->db->query($query);

            if($q->num_rows() > 0){
                $jml_dpa = $q->row()->jml ;
            }

            return $jml_dpa ; 

        }


        function get_notif_dpa_kuitansi($unit,$tahun,$jenis){

            $lenunit = strlen($unit) ;

            $jml_dpa = 0 ;

            $jenis_txt = 'GP' ;

            if($jenis == '1'){
                $jenis_txt = 'GP' ;

            }elseif($jenis == '3'){
                $jenis_txt = 'TP' ;

            }


            $query = "SELECT COUNT(rsa_kuitansi.aktif) AS jml FROM rsa_kuitansi_detail JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi WHERE rsa_kuitansi.aktif = '1' AND rsa_kuitansi.cair = '0' AND SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND rsa_kuitansi.tahun = '{$tahun}' AND rsa_kuitansi.jenis = '{$jenis_txt}' GROUP BY SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,1,{$lenunit}) " ;

            // echo $query ; die;

            $q= $this->db->query($query);

            if($q->num_rows() > 0){
                $jml_dpa = $q->row()->jml ;
            }

            return $jml_dpa ; 

        }

        function get_notif_dpa_kuitansi_by_rka($unit,$kode,$sumber_dana,$tahun,$jenis){

            $lenunit = strlen($unit) ;

            $jml_dpa = 0 ;

            $jenis_txt = 'GP' ;

            if($jenis == '1'){
                $jenis_txt = 'GP' ;

            }elseif($jenis == '3'){
                $jenis_txt = 'TP' ;

            }


            $query = "SELECT COUNT(rsa_kuitansi.aktif) AS jml FROM rsa_kuitansi_detail JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi WHERE rsa_kuitansi.aktif = '1' AND rsa_kuitansi.cair = '0' AND SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,7,10) = '{$kode}' AND SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND rsa_kuitansi_detail.sumber_dana = '{$sumber_dana}' AND rsa_kuitansi.tahun = '{$tahun}' AND rsa_kuitansi.jenis = '{$jenis_txt}' GROUP BY SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,1,{$lenunit}) " ;

            // echo $query ; die;

            $q= $this->db->query($query);

            if($q->num_rows() > 0){
                $jml_dpa = $q->row()->jml ;
            }

            return $jml_dpa ; 

        }

        function get_rsa_program_usul($unit,$sumber_dana,$tahun){
//                $rba = $this->load->database('rba', TRUE);
                $lenunit = strlen($unit);
                $query = "SELECT LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) AS k_unit,SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) AS kode_rka,rba_2018.program.nama_program,rba_2018.komponen_input.nama_komponen,rba_2018.subkomponen_input.nama_subkomponen,SUM(rsa_detail_belanja_.volume*rsa_detail_belanja_.harga_satuan) AS jumlah_tot,rsa_detail_belanja_.proses "
                        . "FROM rsa_detail_belanja_ "
                        . "JOIN rba_2018.program ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2) = rba_2018.program.kode_kegiatan AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2) = rba_2018.program.kode_output AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,11,2) = rba_2018.program.kode_program "
                        . "JOIN rba_2018.komponen_input ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2) = rba_2018.komponen_input.kode_kegiatan AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2) = rba_2018.komponen_input.kode_output AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,11,2) = rba_2018.komponen_input.kode_program AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,13,2) = rba_2018.komponen_input.kode_komponen "
                        . "JOIN rba_2018.subkomponen_input ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2) = rba_2018.subkomponen_input.kode_kegiatan AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2) = rba_2018.subkomponen_input.kode_output AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,11,2) = rba_2018.subkomponen_input.kode_program AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,13,2) = rba_2018.subkomponen_input.kode_komponen AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,15,2) = rba_2018.subkomponen_input.kode_subkomponen "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' AND LEFT(rsa_detail_belanja_.proses,1) >= '3' "
                        . "GROUP BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) "
                        . "ORDER BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) ASC";

                $q= $this->db->query($query);

        $result = $q->result();

        return $result ;

        }
        
        function get_dpa_program_usul_to_validate_ppk($unit,$sumber_dana,$tahun){
//                $rba = $this->load->database('rba', TRUE);

                $rba = $this->load->database('rba', TRUE);
                
                $lenkd = strlen($unit);

                $query2 = "SELECT SUBSTR(det1.kode_usulan_belanja,1,2) AS k_unit,SUBSTR(det1.kode_usulan_belanja,7,10) AS kode_rka,rba_2018.program.nama_program,rba_2018.komponen_input.nama_komponen,rba_2018.subkomponen_input.nama_subkomponen,SUM(det1.volume*det1.harga_satuan) AS jumlah_tot "
                        . "FROM rba_2018.detail_belanja_ AS det1 "
                        . "JOIN rba_2018.program ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.program.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.program.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.program.kode_program "
                        . "JOIN rba_2018.komponen_input ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.komponen_input.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.komponen_input.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.komponen_input.kode_program AND SUBSTR(det1.kode_usulan_belanja,13,2) = rba_2018.komponen_input.kode_komponen "
                        . "JOIN rba_2018.subkomponen_input ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.subkomponen_input.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.subkomponen_input.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.subkomponen_input.kode_program AND SUBSTR(det1.kode_usulan_belanja,13,2) = rba_2018.subkomponen_input.kode_komponen AND SUBSTR(det1.kode_usulan_belanja,15,2) = rba_2018.subkomponen_input.kode_subkomponen "
                        . "WHERE SUBSTR(det1.kode_usulan_belanja,1,{$lenkd}) = '{$unit}' "
                        . "AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' "
                        . "AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE LEFT(det2.kode_usulan_belanja,{$lenkd}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,{$lenkd})  ) "
                        . "GROUP BY SUBSTR(det1.kode_usulan_belanja,7,10) "
                        . "ORDER BY SUBSTR(det1.kode_usulan_belanja,7,10) ASC";
						
						// echo $query2; die;

                $q= $this->db->query($query2);

		$result = $q->result();

        // echo '<pre>' ;
        // var_dump($result) ; 
        // echo '</pre>' ; 
        // die ;

        $r = array();

        foreach($result as $res){
            $r1 = array() ;

            $r1['k_unit'] = $res->k_unit ;
            $r1['kode_rka'] = $res->kode_rka ;
            $r1['nama_program'] = $res->nama_program ;
            $r1['nama_komponen'] = $res->nama_komponen ;
            $r1['nama_subkomponen'] = $res->nama_subkomponen ;
            $r1['jumlah_tot'] = $res->jumlah_tot ;
            $r1['jumlah_rsa'] = $this->get_rsa_by_rka(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun) ;
            $r1['jml_proses'] = $this->get_jml_proses(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun,'1') ;

            $r[] = (object)$r1 ;
        }



        // echo '<pre>' ;
        // var_dump((object)$r) ; 
        // echo '</pre>' ; 
        // die ;

        // return $result ;
        return (object)$r ;



        }

        function get_dpa_program_usul_to_validate_kpa($unit,$sumber_dana,$tahun){
//                $rba = $this->load->database('rba', TRUE);

                $rba = $this->load->database('rba', TRUE);
                
                $lenkd = strlen($unit);

                $query2 = "SELECT SUBSTR(det1.kode_usulan_belanja,1,2) AS k_unit,SUBSTR(det1.kode_usulan_belanja,7,10) AS kode_rka,rba_2018.program.nama_program,rba_2018.komponen_input.nama_komponen,rba_2018.subkomponen_input.nama_subkomponen,SUM(det1.volume*det1.harga_satuan) AS jumlah_tot "
                        . "FROM rba_2018.detail_belanja_ AS det1 "
                        . "JOIN rba_2018.program ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.program.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.program.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.program.kode_program "
                        . "JOIN rba_2018.komponen_input ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.komponen_input.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.komponen_input.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.komponen_input.kode_program AND SUBSTR(det1.kode_usulan_belanja,13,2) = rba_2018.komponen_input.kode_komponen "
                        . "JOIN rba_2018.subkomponen_input ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.subkomponen_input.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.subkomponen_input.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.subkomponen_input.kode_program AND SUBSTR(det1.kode_usulan_belanja,13,2) = rba_2018.subkomponen_input.kode_komponen AND SUBSTR(det1.kode_usulan_belanja,15,2) = rba_2018.subkomponen_input.kode_subkomponen "
                        . "WHERE SUBSTR(det1.kode_usulan_belanja,1,{$lenkd}) = '{$unit}' "
                        . "AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' "
                        . "AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE LEFT(det2.kode_usulan_belanja,{$lenkd}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,{$lenkd})  ) "
                        . "GROUP BY SUBSTR(det1.kode_usulan_belanja,7,10) "
                        . "ORDER BY SUBSTR(det1.kode_usulan_belanja,7,10) ASC";
                        
                        // echo $query; die;

                $q= $this->db->query($query2);

        $result = $q->result();

        // echo '<pre>' ;
        // var_dump($result) ; 
        // echo '</pre>' ; 
        // die ;

        $r = array();

        foreach($result as $res){
            $r1 = array() ;

            $r1['k_unit'] = $res->k_unit ;
            $r1['kode_rka'] = $res->kode_rka ;
            $r1['nama_program'] = $res->nama_program ;
            $r1['nama_komponen'] = $res->nama_komponen ;
            $r1['nama_subkomponen'] = $res->nama_subkomponen ;
            $r1['jumlah_tot'] = $res->jumlah_tot ;
            $r1['jumlah_rsa'] = $this->get_rsa_by_rka(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun) ;
            $r1['jml_proses'] = $this->get_jml_proses(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun,'1') ;

            $r[] = (object)$r1 ;
        }



        // echo '<pre>' ;
        // var_dump((object)$r) ; 
        // echo '</pre>' ; 
        // die ;

        // return $result ;
        return (object)$r ;



        }

        function get_dpa_program_usul_to_validate($unit,$sumber_dana,$tahun){
//                $rba = $this->load->database('rba', TRUE);

                $rba = $this->load->database('rba', TRUE);
                
                $lenkd = strlen($unit);

                $query2 = "SELECT SUBSTR(det1.kode_usulan_belanja,1,2) AS k_unit,SUBSTR(det1.kode_usulan_belanja,7,10) AS kode_rka,rba_2018.program.nama_program,rba_2018.komponen_input.nama_komponen,rba_2018.subkomponen_input.nama_subkomponen,SUM(det1.volume*det1.harga_satuan) AS jumlah_tot "
                        . "FROM rba_2018.detail_belanja_ AS det1 "
                        . "JOIN rba_2018.program ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.program.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.program.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.program.kode_program "
                        . "JOIN rba_2018.komponen_input ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.komponen_input.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.komponen_input.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.komponen_input.kode_program AND SUBSTR(det1.kode_usulan_belanja,13,2) = rba_2018.komponen_input.kode_komponen "
                        . "JOIN rba_2018.subkomponen_input ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.subkomponen_input.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.subkomponen_input.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.subkomponen_input.kode_program AND SUBSTR(det1.kode_usulan_belanja,13,2) = rba_2018.subkomponen_input.kode_komponen AND SUBSTR(det1.kode_usulan_belanja,15,2) = rba_2018.subkomponen_input.kode_subkomponen "
                        . "WHERE SUBSTR(det1.kode_usulan_belanja,1,{$lenkd}) = '{$unit}' "
                        . "AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' "
                        . "AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE LEFT(det2.kode_usulan_belanja,{$lenkd}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,{$lenkd})  ) "
                        . "GROUP BY SUBSTR(det1.kode_usulan_belanja,7,10) "
                        . "ORDER BY SUBSTR(det1.kode_usulan_belanja,7,10) ASC";

                $q= $this->db->query($query2);

		$result = $q->result();

        // echo '<pre>' ;
        // var_dump($result) ; 
        // echo '</pre>' ; 
        // die ;

        $r = array();

        foreach($result as $res){
            $r1 = array() ;

            $r1['k_unit'] = $res->k_unit ;
            $r1['kode_rka'] = $res->kode_rka ;
            $r1['nama_program'] = $res->nama_program ;
            $r1['nama_komponen'] = $res->nama_komponen ;
            $r1['nama_subkomponen'] = $res->nama_subkomponen ;
            $r1['jumlah_tot'] = $res->jumlah_tot ;
            $r1['jumlah_rsa'] = $this->get_rsa_by_rka(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun) ;
            $r1['jml_proses'] = $this->get_jml_proses(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun,'2') ;

            $r[] = (object)$r1 ;
        }



        // echo '<pre>' ;
        // var_dump((object)$r) ; 
        // echo '</pre>' ; 
        // die ;

        // return $result ;
        return (object)$r ;



        }

        function get_dpa_program_usul_to_validate_siap($unit,$sumber_dana,$tahun,$jenis){
//                $rba = $this->load->database('rba', TRUE);

                $rba = $this->load->database('rba', TRUE);
                
                $lenkd = strlen($unit);

                $query2 = "SELECT SUBSTR(det1.kode_usulan_belanja,1,2) AS k_unit,SUBSTR(det1.kode_usulan_belanja,7,10) AS kode_rka,rba_2018.program.nama_program,rba_2018.komponen_input.nama_komponen,rba_2018.subkomponen_input.nama_subkomponen,SUM(det1.volume*det1.harga_satuan) AS jumlah_tot "
                        . "FROM rba_2018.detail_belanja_ AS det1 "
                        . "JOIN rba_2018.program ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.program.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.program.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.program.kode_program "
                        . "JOIN rba_2018.komponen_input ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.komponen_input.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.komponen_input.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.komponen_input.kode_program AND SUBSTR(det1.kode_usulan_belanja,13,2) = rba_2018.komponen_input.kode_komponen "
                        . "JOIN rba_2018.subkomponen_input ON SUBSTR(det1.kode_usulan_belanja,7,2) = rba_2018.subkomponen_input.kode_kegiatan AND SUBSTR(det1.kode_usulan_belanja,9,2) = rba_2018.subkomponen_input.kode_output AND SUBSTR(det1.kode_usulan_belanja,11,2) = rba_2018.subkomponen_input.kode_program AND SUBSTR(det1.kode_usulan_belanja,13,2) = rba_2018.subkomponen_input.kode_komponen AND SUBSTR(det1.kode_usulan_belanja,15,2) = rba_2018.subkomponen_input.kode_subkomponen "
                        . "WHERE SUBSTR(det1.kode_usulan_belanja,1,{$lenkd}) = '{$unit}' "
                        . "AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' "
                        . "AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE LEFT(det2.kode_usulan_belanja,{$lenkd}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,{$lenkd})  ) "
                        . "GROUP BY SUBSTR(det1.kode_usulan_belanja,7,10) "
                        . "ORDER BY SUBSTR(det1.kode_usulan_belanja,7,10) ASC";
                        
                        // echo $query; die;

                $q= $this->db->query($query2);

        $result = $q->result();

        // echo '<pre>' ;
        // var_dump($result) ; 
        // echo '</pre>' ; 
        // die ;

        $r = array();

        foreach($result as $res){
            $r1 = array() ;

            $r1['k_unit'] = $res->k_unit ;
            $r1['kode_rka'] = $res->kode_rka ;
            $r1['nama_program'] = $res->nama_program ;
            $r1['nama_komponen'] = $res->nama_komponen ;
            $r1['nama_subkomponen'] = $res->nama_subkomponen ;
            $r1['jumlah_tot'] = $res->jumlah_tot ;
            $r1['jumlah_rsa'] = $this->get_rsa_by_rka(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun) ;
            if(($jenis == '1') || ($jenis == '3')){ // GUP , TUP
                $dpa_siap = $this->get_jml_proses_by_jenis(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun,'3',$jenis) ;  
                // $dpa_kuitansi =   $this->get_notif_dpa_kuitansi_by_rka(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun,$jenis) ; 
                $r1['jml_proses'] =   $dpa_siap  ;
            }else{
                $r1['jml_proses'] = $this->get_jml_proses_by_jenis(substr($unit,0,$lenkd),$res->kode_rka,$sumber_dana,$tahun,'3',$jenis) ;
            }
            

            $r[] = (object)$r1 ;
        }



        // echo '<pre>' ;
        // var_dump((object)$r) ; 
        // echo '</pre>' ; 
        // die ;

        // return $result ;
        return (object)$r ;



        }

        

        function get_dpa_tujuan_usul($unit,$sumber_dana,$tahun){
                $rba = $this->load->database('rba', TRUE);

                $query = "SELECT LEFT(detail_belanja_.kode_usulan_belanja,2) AS k_unit,kegiatan.nama_kegiatan,kegiatan.kode_kegiatan,output.nama_output,output.kode_output,program.nama_program,program.kode_program,SUM(detail_belanja_.volume*detail_belanja_.harga_satuan) AS jumlah_tot "
                        . "FROM detail_belanja_ "
                        . "JOIN kegiatan ON SUBSTR(detail_belanja_.kode_usulan_belanja,7,2) = kegiatan.kode_kegiatan "
                        . "JOIN output ON SUBSTR(detail_belanja_.kode_usulan_belanja,7,2) = output.kode_kegiatan AND SUBSTR(detail_belanja_.kode_usulan_belanja,9,2) = output.kode_output "
                        . "JOIN program ON SUBSTR(detail_belanja_.kode_usulan_belanja,7,2) = program.kode_kegiatan AND SUBSTR(detail_belanja_.kode_usulan_belanja,9,2) = program.kode_output AND SUBSTR(detail_belanja_.kode_usulan_belanja,11,2) = program.kode_program "
                        . "WHERE LEFT(detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY SUBSTR(detail_belanja_.kode_usulan_belanja,7,6) "
                        . "ORDER BY SUBSTR(detail_belanja_.kode_usulan_belanja,7,6) ASC";

                $q= $rba->query($query);

		$result = $q->result();

		return $result ;

        }
		//ambil komponen
		function get_all_ket_subkomponen_input($unit,$sumber_dana,$tahun,$search="",$orderby=""){
			//var_dump($unit);die;
				$rba = $this->load->database('rba', TRUE);
				if($unit == 'ALL'){
					// KONDISI UNTUK SELEKSI SEMUA USULAN
				}else{
					$rba->where('LEFT(kode_subkomponen_input,'.strlen($unit).')',$unit);
				}

				$rba->where('tahun',$tahun);
				if($search!="")
				{

					$rba->where("(kode_subkomponen_input LIKE '%{$search}%' OR indikator_keluaran LIKE '%{$search}%' OR satuan LIKE '%{$search}%' )") ;
				}
				if($orderby==""){
					$rba->order_by("RIGHT(kode_subkomponen_input, 10), ket_subkomponen_input_.username ASC");
				}
				elseif($orderby=="biaya"){
					$rba->join('ref_akun','ket_subkomponen_input_.jenis_biaya = ref_akun.nama_akun AND  ket_subkomponen_input_.jenis_komponen = ref_akun.nama_akun_sub');
					$rba->order_by("ref_akun.kode_akun, ref_akun.kode_akun_sub, SUBSTR(ket_subkomponen_input_.kode_subkomponen_input,7,10), ket_subkomponen_input_.username ASC");
				}

				$query =$rba->get('ket_subkomponen_input_');
				return $query->result();
	}


	function get_all_total_usulan_belanja($usulans){
		$rba = $this->load->database('rba', TRUE);
		$total_usulan = array();
		foreach($usulans as $usulan){
			// $this->get_detail_usulan_belanja_by_sd($usulan->kode_subkomponen_input,$usulan->sumber_dana_subkomponen,$usulan->tahun);

			$query = $rba->query("SELECT
										SUM((detail_belanja_.harga_satuan * detail_belanja_.volume)) AS total
									FROM
										detail_belanja_
									WHERE
										LEFT(detail_belanja_.kode_usulan_belanja,16)='{$usulan->kode_subkomponen_input}' AND
										detail_belanja_.tahun='{$usulan->tahun}' AND
										detail_belanja_.flag_cetak='1'
									GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,16)
									");
			//var_dump($query);die;
			$row = $query->row();

			$total_usulan_ = array();

			$total_usulan_[$usulan->kode_subkomponen_input] = isset($row->total)?$row->total:0;

			$total_usulan[] = $total_usulan_;

		}

		return $total_usulan ;

	}
	function get_rincian_kode_usulan($kode_usulan){
		$rba = $this->load->database('rba', TRUE);
        $rba->select("*,".$kode_usulan." AS kode_usulan");
		$rba->where('subkomponen_input.kode_kegiatan',substr($kode_usulan,6,2));
		$rba->where('subkomponen_input.kode_output',substr($kode_usulan,8,2));
		$rba->where('subkomponen_input.kode_program',substr($kode_usulan,10,2));
		$rba->where('subkomponen_input.kode_komponen',substr($kode_usulan,12,2));
		$rba->where('subkomponen_input.kode_subkomponen',substr($kode_usulan,14,2));
                $rba->join('kegiatan','kegiatan.kode_kegiatan = subkomponen_input.kode_kegiatan');
		$rba->join('output','output.kode_output = subkomponen_input.kode_output AND output.kode_kegiatan = subkomponen_input.kode_kegiatan');
		$rba->join('program','program.kode_kegiatan = subkomponen_input.kode_kegiatan AND program.kode_output = subkomponen_input.kode_output AND program.kode_program = subkomponen_input.kode_program');
		$rba->join('komponen_input','komponen_input.kode_kegiatan = subkomponen_input.kode_kegiatan AND komponen_input.kode_output = subkomponen_input.kode_output AND komponen_input.kode_program = subkomponen_input.kode_program AND komponen_input.kode_komponen = subkomponen_input.kode_komponen');
//		$this->db->join('subkomponen_input','subkomponen_input.kode_kegiatan = kegiatan.kode_kegiatan AND subkomponen_input.kode_output = output.kode_output AND subkomponen_input.kode_program = program.kode_program AND subkomponen_input.kode_komponen = komponen_input.kode_komponen');
		$query = $rba->get('subkomponen_input');

		return $query->row();

	}
	function get_rekap_usulan_belanja_by_sd($u_unit,$sd='',$tahun)
	{
			$rba = $this->load->database('rba', TRUE);

                $u_unit_len = 0 ;
                $str_s = '' ;

                if($u_unit == 'ALL'){
                    $str_s .= "WHERE sumber_dana = '{$sd}' AND detail_belanja_.tahun = '{$tahun}' " ;
                }else{
                    $u_unit_len = strlen($u_unit);
                    $str_s .= "WHERE LEFT(detail_belanja_.username,{$u_unit_len}) = '{$u_unit}' AND sumber_dana = '{$sd}' AND detail_belanja_.tahun = '{$tahun}' " ;
                }
                $u_unit_len = $u_unit_len + 2 ;
		$str = "SELECT LEFT(detail_belanja_.username,{$u_unit_len}) AS u_unit, "
                        . "SUBSTR(kode_usulan_belanja,7,10) AS kriteria_usul, "
                        . "RIGHT(kode_usulan_belanja,6) as kode_akun, "
                        . "SUM(detail_belanja_.volume*harga_satuan) AS total_b "
                        . "FROM detail_belanja_ " ;

                $str .= $str_s ;

                $str .= "GROUP BY LEFT(detail_belanja_.username,{$u_unit_len}), SUBSTR(kode_usulan_belanja,7,10), RIGHT(kode_usulan_belanja,6) "
                        . "ORDER BY SUBSTR(kode_usulan_belanja,7,10),LEFT(detail_belanja_.username,{$u_unit_len}),RIGHT(kode_usulan_belanja,6) ASC" ;

                $query = $rba->query($str);
		//print_r($this->db->last_query());
		//var_dump($this->db->last_query());die;
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	function get_all_used_akun_belanja($u_unit, $sd='', $tahun){
           $rba = $this->load->database('rba', TRUE);
            $str = '';
            $u_unit_len = 0 ;
            $str_s = '' ;

            if($u_unit == 'ALL'){
               $str .= "SELECT RIGHT(kode_usulan_belanja,6) AS kode_akun FROM detail_belanja_ "
                       . "WHERE sumber_dana = '{$sd}' AND tahun = '{$tahun}' "
                       . "GROUP BY RIGHT(kode_usulan_belanja,6) ORDER BY RIGHT(kode_usulan_belanja,6) ASC";
            }else{
                $u_unit_len = strlen($u_unit);
                $str .= "SELECT RIGHT(kode_usulan_belanja,6) AS kode_akun FROM detail_belanja_ "
                       . "WHERE LEFT(username,{$u_unit_len}) = '{$u_unit}' AND sumber_dana = '{$sd}' AND tahun = '{$tahun}' "
                       . "GROUP BY RIGHT(kode_usulan_belanja,6) ORDER BY RIGHT(kode_usulan_belanja,6) ASC";

            }
            $query = $rba->query($str);
			//var_dump($query);die;
            //print_r($this->db->last_query());
           // var_dump($rba->last_query());die;
            if ($query->num_rows()>0){
                    return $query->result();
            }else{
                    return array();
            }
        }

 function get_rekap_volume_subkomponen_input($u_unit, $kode='', $tahun){
             $rba = $this->load->database('rba', TRUE);
            $str = '';
            $u_unit_len = 0 ;

            $u_unit_len = strlen($u_unit);
            $str .= "SELECT SUM(volume) AS volume_b FROM ket_subkomponen_input_ "
                   . "WHERE LEFT(kode_subkomponen_input,{$u_unit_len}) = '{$u_unit}' AND RIGHT(kode_subkomponen_input,10) = '{$kode}' AND tahun = '{$tahun}' "
                    . "GROUP BY LEFT(kode_subkomponen_input,{$u_unit_len}), RIGHT(kode_subkomponen_input,10) ";


            $query = $rba->query($str);

            //print_r($this->db->last_query());
            //var_dump($this->db->last_query());die;
//            if ($query->num_rows()>0){
//                    return $query->result();
//            }else{
//                    return array();
//            }
            return $query->row()->volume_b;

        }
		//get kegiatan
		function get_single_kegiatan($where,$field){
			$rba = $this->load->database('rba', TRUE);
			$rba->where('kode_kegiatan',$where);
			$query = $rba->get('kegiatan')->row();
			if(empty($field)){
				return $query ;
			}
			elseif($field=='nama'){
				return $query->nama_kegiatan ;
			}
		}
		function get_single_output($where,$field){
                // vdebug($where);

            echo '<pre>';
            var_dump($where);
            
					$rba = $this->load->database('rba', TRUE);
					$query = $rba->get('output')->row();

				if(empty($field)){
					return $query ;
				}
				elseif($field=='nama'){
					return $query->nama_output ;
				}
		}
		function get_single_program($where,$field){
            // vdebug($where);
			$rba = $this->load->database('rba', TRUE);
				$rba->where($where);
				$query = $rba->get('program')->row();

				if(strlen(trim($field))<=0){
					if(count($query)>0){
						return $query;
					}
				}elseif($field=='nama'){
					if(count($query)>0){
						return $query->nama_program;
					}
				}
		}
                
        function get_pagu_rkat($kode_unit_subunit,$tahun,$jenis){
			$rba = $this->load->database('rba', TRUE);
			$rba->where('kode_unit_subunit',$kode_unit_subunit);
            $rba->where('tahun',$tahun);
            $q = $rba->get('platform');
            if($jenis == 'SELAIN-APBN'){
                return $q->row()->jumlah ;
            }elseif($jenis == 'APBN-BPPTNBH'){
                return $q->row()->rm ;
            }elseif($jenis == 'APBN-LAINNYA'){
                return $q->row()->apbn_lainnya ;
            }else{
                return 0;
            }
		}


        function get_kroscek_akun($sumber_dana,$tahun){

            $sql = "SELECT ta.kdunit,ta.kdsubsubunit,td.nama_sub_subunit AS unit,ta.kode_usulan_belanja,ta.anggaran,tc.serapan,tb.revisi
                    FROM (
                        SELECT SUBSTR(t1.kode_usulan_belanja,1,2) AS kdunit,SUBSTR(t1.kode_usulan_belanja,1,6) AS kdsubsubunit,SUBSTR(t1.kode_usulan_belanja,1,22) as kode_usulan_belanja,SUM(t1.volume * t1.harga_satuan) AS anggaran,t1.revisi
                        FROM rba_2018.detail_belanja_ AS t1
                        WHERE t1.sumber_dana = '{$sumber_dana}' AND t1.tahun = '{$tahun}'
                        GROUP BY SUBSTR(t1.kode_usulan_belanja,1,22), t1.revisi
                        ORDER BY SUBSTR(t1.kode_usulan_belanja,1,22), t1.revisi
                        ) AS ta
                    LEFT JOIN(
                        SELECT SUBSTR(t3.kode_usulan_belanja,1,2) AS kdunit,SUBSTR(t3.kode_usulan_belanja,1,22) as kode_usulan_belanja,SUM(t3.volume * t3.harga_satuan) AS serapan,t3.revisi
                        FROM rsa_2018.rsa_detail_belanja_ AS t3
                        WHERE t3.sumber_dana = '{$sumber_dana}' AND t3.tahun = '{$tahun}'
                        GROUP BY SUBSTR(t3.kode_usulan_belanja,1,22), t3.revisi
                        ORDER BY SUBSTR(t3.kode_usulan_belanja,1,22), t3.revisi
                        ) AS tc
                    ON ta.kode_usulan_belanja = tc.kode_usulan_belanja AND ta.revisi = tc.revisi
                    JOIN
                        (
                        SELECT SUBSTR(t2.kode_usulan_belanja,1,2) AS kdunit, MAX(t2.revisi) AS revisi
                        FROM rba_2018.detail_belanja_ AS t2
                        WHERE t2.sumber_dana = '{$sumber_dana}' AND t2.tahun = '{$tahun}'
                        GROUP BY SUBSTR(t2.kode_usulan_belanja,1,2)
                        ORDER BY SUBSTR(t2.kode_usulan_belanja,1,2)
                        ) AS tb
                    ON ta.kdunit = tb.kdunit AND ta.revisi = tb.revisi
                    JOIN rba_2018.sub_subunit AS td ON ta.kdsubsubunit = td.kode_sub_subunit
                    ORDER BY ta.kdunit,ta.kode_usulan_belanja,tb.revisi
                    " ;
            $q = $this->db->query($sql);
            $data = $q->result_array() ;
        // vdebug($data);
        // echo '<pre>'; var_dump($data); echo '</pre>';  die;
            return $data ; 
        }


        function get_kroscek_akun_($sumber_dana,$tahun){ // FUNGSI LAMA

            // $rba = $this->load->database('rba', TRUE);

            // $str1 = "(SELECT rba_2018.detail_belanja_.kode_usulan_belanja FROM rba_2018.detail_belanja_ WHERE rba_2018.detail_belanja_.sumber_dana = 'SELAIN-APBN' GROUP BY rba_2018.detail_belanja_.kode_usulan_belanja) UNION DISTINCT (SELECT rsa_2018.rsa_detail_belanja_.kode_usulan_belanja FROM rsa_2018.rsa_detail_belanja_ WHERE rsa_2018.rsa_detail_belanja_.sumber_dana = 'SELAIN-APBN' AND GROUP BY rsa_2018.rsa_detail_belanja_.kode_usulan_belanja) ORDER BY kode_usulan_belanja ASC" ;

            $rba = $this->load->database('rba', TRUE);

            $query = "SELECT rba_2018.unit.kode_unit FROM rba_2018.unit GROUP BY rba_2018.unit.kode_unit ORDER BY rba_2018.unit.kode_unit" ; 

            $q = $rba->query($query);

            $r0 = array();

            $units = array();

            if(!empty($q->num_rows())){



                // $i = 1;

                // var_dump($q->result_array()); die;

                $t = 0 ; 

                $units = $q->result_array() ;

                foreach($units AS $u){

                    $unit = $u['kode_unit'] ;

                    $lenunit = strlen($unit);


                    $str = "SELECT rba_2018.detail_belanja_.kode_usulan_belanja FROM rba_2018.detail_belanja_ WHERE SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) )  GROUP BY rba_2018.detail_belanja_.kode_usulan_belanja ORDER BY rba_2018.detail_belanja_.kode_usulan_belanja ASC" ;

                    $query = $rba->query($str);

                    $r0[] = $query->result_array() ;

                }


            }


            $r1 = array();

            if(!empty($r0)){
                foreach($r0 AS $rr){

                    foreach($rr AS $rr0){
                        $r1[] = $rr0['kode_usulan_belanja'] ;
                    }

                }

            }
            // echo '<pre>' ;
            // var_dump($r1); 
            // echo '</pre>' ; die;



            // $rba = $this->load->database('rba', TRUE);

            // $query = "SELECT rba_2018.unit.kode_unit FROM rba_2018.unit GROUP BY rba_2018.unit.kode_unit ORDER BY rba_2018.unit.kode_unit" ; 

            // $q = $rba->query($query);

            $r0 = array();

            if(!empty($units)){



                // $i = 1;

                // var_dump($q->result_array()); die;

                $t = 0 ; 

                // $units = $q->result_array() ;

                $rsa = $this->load->database('default', TRUE);

                foreach($units AS $u){

                    $unit = $u['kode_unit'] ;

                    $lenunit = strlen($unit);

                    $str = "SELECT rsa_2018.rsa_detail_belanja_.kode_usulan_belanja FROM rsa_2018.rsa_detail_belanja_ WHERE SUBSTR(rsa_2018.rsa_detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND rsa_2018.rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_2018.rsa_detail_belanja_.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) )  GROUP BY rsa_2018.rsa_detail_belanja_.kode_usulan_belanja ORDER BY rsa_2018.rsa_detail_belanja_.kode_usulan_belanja ASC" ;

                    $query = $rsa->query($str);

                    $r0[] = $query->result_array() ;

                }


            }


            $r2 = array();

            if(!empty($r0)){
                foreach($r0 AS $rr){

                    foreach($rr AS $rr0){
                        $r2[] = $rr0['kode_usulan_belanja'] ;
                    }

                }

            }

            // echo '<pre>' ;
            // var_dump($r2); 
            // echo '</pre>' ; die;

            

            

            // $query = $this->db->query($str);

            // $r2 = $query->result_array() ;

            // echo '<pre>' ;

            // echo var_dump($r1) ;

            // echo '</pre>' ;

            // die;

            // echo '<pre>' ;

            // echo count($r1) ;

            // echo '<br/>' ;

            // echo count($r2) ;

            $r3 = array_merge($r1, $r2);

            // echo '<br/>' ;

            // echo count($r3) ;

            // echo '</pre>' ;

            // echo '<pre>' ;

            // var_dump($r3) ;

            // echo '</pre>' ;

            // $r4 = array();

            // foreach($r3 as $rr){
            //     $r4[] = $rr['kode_usulan_belanja'] ;
            // }

            // echo '<br/>' ;

            // echo count($r4) ;

            $r5 = array_unique($r3);

            // echo '<br/>' ;

            // echo count($r5) ;

            // echo '<pre>' ;

            // var_dump($r5) ;

            // echo '</pre>' ;

            // die;

            asort($r5);

            $r6 = array();

            foreach($r5 as $rr5){

                $kode_sub_subunit = substr($rr5,0,6);

                $ret = array(); 

                $ret['unit'] = $this->get_nama_sub_subunit($kode_sub_subunit) ;
                $ret['kode_usulan_belanja'] = $rr5 ; 
                $ret['anggaran'] = $this->get_rba($rr5,$sumber_dana,$tahun) ;
                $ret['serapan'] = $this->get_rsa($rr5,$sumber_dana,$tahun) ;

                $r6[] = $ret ;

            }


            // var_dump($r6) ; die;

            


            return  $r6;

        }


        function get_nama_sub_subunit($kode_sub_subunit){

            $str = "SELECT rba_2018.sub_subunit.nama_sub_subunit FROM rba_2018.sub_subunit WHERE rba_2018.sub_subunit.kode_sub_subunit = '{$kode_sub_subunit}'" ;

            $query = $this->db->query($str);

            return $query->row()->nama_sub_subunit ;

        }

        function get_rba($kode,$sumber_dana,$tahun){

            // $str1 = "SELECT SUM(rba_demo.detail_belanja_.volume * rba_demo.detail_belanja_.harga_satuan) AS jumlah FROM rba_demo.detail_belanja_ WHERE rba_demo.detail_belanja_.kode_usulan_belanja = '{$kode}' GROUP BY rba_demo.detail_belanja_.kode_usulan_belanja" ;

            $unit = substr($kode,0,2);

            $str = "SELECT SUM(det1.volume * det1.harga_satuan) AS jumlah FROM rba_2018.detail_belanja_ AS det1 WHERE det1.kode_usulan_belanja = '{$kode}' AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rba_2018.detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,2) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY det1.kode_usulan_belanja" ;

            // echo $str ; die;

            $query = $this->db->query($str);

            if ($query->num_rows()>0){

                return $query->row()->jumlah ;
            }
            else{
                return '0';
            }

        }

        function get_rsa($kode,$sumber_dana,$tahun){

            $str = "SELECT SUM(det1.volume * det1.harga_satuan) AS jumlah FROM rsa_2018.rsa_detail_belanja_ AS det1 WHERE det1.kode_usulan_belanja = '{$kode}' AND det1.proses > 0 AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE det2.kode_usulan_belanja = '{$kode}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY LEFT(det2.kode_usulan_belanja,2) ) GROUP BY det1.kode_usulan_belanja" ;

            $query = $this->db->query($str);

            if ($query->num_rows()>0){

                return $query->row()->jumlah ;
            }
            else{
                return '0';
            }

        }

        function get_rsa_by_rka($unit,$kode,$sumber_dana,$tahun){

            $lenunit = strlen($unit) ;

            $str = "SELECT SUM(det1.volume * det1.harga_satuan) AS jumlah FROM rsa_2018.rsa_detail_belanja_ AS det1 WHERE SUBSTR(det1.kode_usulan_belanja,1,$lenunit) = '{$unit}' AND SUBSTR(det1.kode_usulan_belanja,7,10) = '{$kode}' AND SUBSTR(det1.proses,1,1) = '6' AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,$lenunit) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY SUBSTR(det2.kode_usulan_belanja,1,$lenunit) ) GROUP BY SUBSTR(det1.kode_usulan_belanja,7,10)" ;

            // echo $str ;  die;

            $query = $this->db->query($str);

            if ($query->num_rows()>0){

                return $query->row()->jumlah ;
            }
            else{
                return '0';
            }

        }

        function get_jml_proses($unit,$kode,$sumber_dana,$tahun,$id_proses){

            $lenunit = strlen($unit) ;

            $str = "SELECT COUNT(det1.proses) AS jml_proses FROM rsa_2018.rsa_detail_belanja_ AS det1 WHERE SUBSTR(det1.kode_usulan_belanja,1,$lenunit) = '{$unit}' AND SUBSTR(det1.kode_usulan_belanja,7,10) = '{$kode}' AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' AND SUBSTR(det1.proses,1,1) = '{$id_proses}' AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,$lenunit) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY SUBSTR(det2.kode_usulan_belanja,1,$lenunit) ) GROUP BY SUBSTR(det1.kode_usulan_belanja,1,$lenunit) " ;


            // echo $str ; die ;

            $query = $this->db->query($str);

            if ($query->num_rows()>0){

                return $query->row()->jml_proses ;
            }
            else{
                return '0';
            }

        }

        function get_jml_proses_by_jenis($unit,$kode,$sumber_dana,$tahun,$id_proses,$jenis){

            $lenunit = strlen($unit) ;

            $str1 = "SELECT COUNT(det1.proses) AS jml_proses FROM rsa_2018.rsa_detail_belanja_ AS det1 WHERE SUBSTR(det1.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND SUBSTR(det1.kode_usulan_belanja,7,10) = '{$kode}' AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' AND SUBSTR(det1.proses,1,1) = '{$id_proses}' AND SUBSTR(det1.proses,2,1) = '{$jenis}' AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY SUBSTR(det2.kode_usulan_belanja,1,$lenunit) ) GROUP BY SUBSTR(det1.kode_usulan_belanja,1,$lenunit) " ;

            $str = "SELECT COUNT(det1.proses) AS jml_proses FROM rsa_2018.rsa_detail_belanja_ AS det1 WHERE SUBSTR(det1.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND SUBSTR(det1.kode_usulan_belanja,7,10) = '{$kode}' AND det1.sumber_dana = '{$sumber_dana}' AND det1.tahun = '{$tahun}' AND SUBSTR(det1.proses,1,1) = '{$id_proses}' AND SUBSTR(det1.proses,2,1) = '{$jenis}' AND det1.revisi = ( SELECT MAX(det2.revisi) FROM rsa_2018.rsa_detail_belanja_ AS det2 WHERE SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND det2.sumber_dana = '{$sumber_dana}' AND det2.tahun = '{$tahun}' GROUP BY SUBSTR(det2.kode_usulan_belanja,1,{$lenunit}) ) AND (det1.kode_usulan_belanja,det1.kode_akun_tambah) NOT IN ( SELECT rsa_kuitansi_detail.kode_usulan_belanja,rsa_kuitansi_detail.kode_akun_tambah FROM rsa_kuitansi_detail JOIN rsa_kuitansi ON rsa_kuitansi_detail.id_kuitansi = rsa_kuitansi.id_kuitansi  WHERE SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,7,10) = '{$kode}' AND rsa_kuitansi_detail.sumber_dana = '{$sumber_dana}' AND rsa_kuitansi_detail.tahun = '{$tahun}' AND rsa_kuitansi.aktif = '1' AND rsa_kuitansi.cair = '0' )" ;


            // echo $str ; die ;

            $query = $this->db->query($str);

            if ($query->num_rows()>0){

                return $query->row()->jml_proses ;
            }
            else{
                return '0';
            }

        }

}
