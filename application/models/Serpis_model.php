<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Serpis_model extends CI_Model {
/* -------------- Constructor ------------- */

		private $db2;
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				$this->db2 = $this->load->database('rba', TRUE);
        }


        function get_kontrak_p3($unit,$sumber_dana,$tahun){
                $query = "SELECT LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) AS k_unit,SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) AS kode_rka,rba.program.nama_program,rba.komponen_input.nama_komponen,rba.subkomponen_input.nama_subkomponen,SUM(rsa_detail_belanja_.volume*rsa_detail_belanja_.harga_satuan) AS jumlah_tot,rsa_detail_belanja_.proses "
                        . "FROM rsa_detail_belanja_ "
                        . "JOIN rba.program ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2) = rba.program.kode_kegiatan AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2) = rba.program.kode_output AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,11,2) = rba.program.kode_program "
                        . "JOIN rba.komponen_input ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2) = rba.komponen_input.kode_kegiatan AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2) = rba.komponen_input.kode_output AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,11,2) = rba.komponen_input.kode_program AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,13,2) = rba.komponen_input.kode_komponen "
                        . "JOIN rba.subkomponen_input ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,2) = rba.subkomponen_input.kode_kegiatan AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,9,2) = rba.subkomponen_input.kode_output AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,11,2) = rba.subkomponen_input.kode_program AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,13,2) = rba.subkomponen_input.kode_komponen AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,15,2) = rba.subkomponen_input.kode_subkomponen "
						 . "JOIN rsa_spm_kontrakpihak3 ON rsa_detail_belanja_.kode_usulan_belanja= rsa_spm_kontrakpihak3.kode_usulan_belanja "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) "
                        . "ORDER BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) ASC";

                $q= $this->db->query($query);
		//var_dump($query);die;
		$result = $q->result();

		return $result ;

        }
		function get_detail_kontrak($kode,$sumber_dana,$tahun){
             $rba = $this->load->database('rba', TRUE);
            $unit = substr($kode,0,2);
            $rka = substr($kode,2,10);
            
            $query  = "SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_usulan_belanja,rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,rba.subunit.nama_subunit,rba.sub_subunit.nama_sub_subunit,volume,deskripsi,satuan,harga_satuan,kode_akun_tambah,RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) AS akun,rsa_detail_belanja_.impor,rsa_detail_belanja_.proses FROM "
                    . "rsa_spm_kontrakpihak3 "
					. "JOIN rsa_detail_belanja_ ON rsa_spm_kontrakpihak3.kode_usulan_belanja= rsa_detail_belanja_.kode_usulan_belanja "
                    . "JOIN rba.akun_belanja ON RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) = rba.akun_belanja.kode_akun AND rsa_detail_belanja_.sumber_dana = rba.akun_belanja.sumber_dana "
                    . "JOIN rba.subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,4) = rba.subunit.kode_subunit "
                    . "JOIN rba.sub_subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,6) = rba.sub_subunit.kode_sub_subunit "
                    . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' "
                    . "AND rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}') "
                    . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                    . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "rsa_detail_belanja_.kode_akun_tambah ASC" ;
			var_dump($query);die;
			  $query		= $this->db->query($query) ;
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
        }
        
     
}
