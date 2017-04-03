<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Geser_model extends CI_Model {
/* -------------- Constructor ------------- */

		private $db2;
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				$this->db2 = $this->load->database('rba', TRUE);
        }
        
        function get_geser_unit_usul($sumber_dana,$tahun,$kode_unit){
                $rba = $this->load->database('rba', TRUE);
               // var_dump($rba);die;
                $query = "SELECT unit.nama_unit,unit.kode_unit,LEFT(detail_belanja_b.kode_usulan_belanja,10) as program,LEFT(detail_belanja_b.kode_usulan_belanja,6,2) as kegiatan  FROM detail_belanja_b"
                        . " JOIN unit ON LEFT(detail_belanja_b.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE detail_belanja_b.sumber_dana = '{$sumber_dana}' AND detail_belanja_b.tahun = '{$tahun}' AND LEFT(detail_belanja_b.kode_usulan_belanja,2) = '{$kode_unit}' "
                        . "GROUP BY LEFT(detail_belanja_b.kode_usulan_belanja,10) "
                        . "ORDER BY LEFT(detail_belanja_b.kode_usulan_belanja,10) ASC";
                $q = $rba->query($query);
		//var_dump($query);die;
		$result = $q->result();

		return $result ;

        }
		function get_nama_program($kode){
			$rba = $this->load->database('rba', TRUE);
			$this->db->where($where);
			 $query = "SELECT nama_program "
                        . "FROM program "
                        . "WHERE kode_kegiatan = '{$kd1}' AND kode_output = '{$kd2}' AND kode_program = '{$kd3}' "
                        . "GROUP BY LEFT(detail_belanja_.kode_usulan_belanja,10) "
                        . "ORDER BY LEFT(detail_belanja_.kode_usulan_belanja,10) ASC";
			$query = $rba->query($query);
			if(empty($field)){
			return $query ;
		}
			elseif($field=='nama'){
			return $query->nama_program ;
		}


	}
	function get_dpa_unit_rkat($kode_unit,$sumber_dana,$tahun){
                $rba = $this->load->database('rba', TRUE);
                
                $query = "SELECT MAX(impor) AS impor FROM detail_belanja_b WHERE "
                        . "LEFT(detail_belanja_b.kode_usulan_belanja,2) = '{$kode_unit}' AND detail_belanja_b.sumber_dana = '{$sumber_dana}' AND detail_belanja_b.tahun = '{$tahun}' "
                        . "GROUP BY LEFT(detail_belanja_b.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(detail_belanja_b.kode_usulan_belanja,2) ASC";
                
                $q = $rba->query($query);
                
                $result = $q->row();

			$revisi = empty($result)?'0':$result->impor ;

                $query = "SELECT SUM(detail_belanja_b.volume*detail_belanja_b.harga_satuan) AS rkat "
                        . "FROM detail_belanja_b "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE LEFT(detail_belanja_b.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_b.sumber_dana = '{$sumber_dana}' AND detail_belanja_b.tahun = '{$tahun}' AND revisi = '{$revisi}' "
                        . "GROUP BY LEFT(detail_belanja_b.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(detail_belanja_b.kode_usulan_belanja,2) ASC";

                $q = $rba->query($query);

		$result = $q->row();
	
		return empty($result)?'0':$result->rkat ;

        }
        
        function get_dpa_unit_rsa($kode_unit,$sumber_dana,$tahun){
//                $rba = $this->load->database('rba', TRUE);
            
                $query = "SELECT MAX(rsa_detail_belanja_.impor) AS impor "
                        . "FROM rsa_detail_belanja_ "
//                        . "JOIN unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = unit.kode_unit "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) ASC";

                $q = $this->db->query($query);

		$result = $q->row();

		$impor = empty($result)?'0':$result->impor ;
                
                $query = "SELECT SUM(rsa_detail_belanja_.volume*rsa_detail_belanja_.harga_satuan) AS rsa "
                        . "FROM rsa_detail_belanja_ "
//                        . "JOIN rba.unit ON LEFT(detail_belanja_.kode_usulan_belanja,2) = rba.unit.kode_unit "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' AND rsa_detail_belanja_.impor = '{$impor}' "
                        . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) "
                        . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) ASC";

                $q = $this->db->query($query);
		
		$result = $q->row();
	
		return empty($result)?'0':$result->rsa ;

        }
        
        
      
}