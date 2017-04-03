<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tor_model extends CI_Model {
/* -------------- Constructor ------------- */

		private $db2;
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				$this->db2 = $this->load->database('rba', TRUE);
        }
	

	
	public function get_db2()
        {
	  return $this->db2->get('detail_belanja_');
	}
        
        function get_detail_unit($kode_unit){
            
            $rba = $this->load->database('rba', TRUE);
            
            $query = "SELECT rba.unit.kode_unit, rba.unit.nama_unit "
                        . "FROM rba.unit "
                        . "WHERE rba.unit.kode_unit = '{$kode_unit}' ";
                        
                        
//                        echo $query ; die;
                        
            $q = $rba->query($query);

            $result = $q->row();
            
            return $result;
            
        }
        
        function get_tor_usul($kode_rka){
            
            $rba = $this->load->database('rba', TRUE);
            $kegiatan = substr($kode_rka,0,2);
            $output = substr($kode_rka,2,2);
            $program = substr($kode_rka,4,2);
            $komponen_input = substr($kode_rka,6,2);
            $subkomponen_input = substr($kode_rka,8,2);
            
            $query = "SELECT kegiatan.kode_kegiatan,output.kode_output,program.kode_program,komponen_input.kode_komponen,subkomponen_input.kode_subkomponen,kegiatan.nama_kegiatan,output.nama_output,program.nama_program,komponen_input.nama_komponen,subkomponen_input.nama_subkomponen "
                        . "FROM subkomponen_input "
                        . "JOIN kegiatan ON subkomponen_input.kode_kegiatan = kegiatan.kode_kegiatan "
                        . "JOIN output ON subkomponen_input.kode_kegiatan = output.kode_kegiatan AND subkomponen_input.kode_output = output.kode_output "
                        . "JOIN program ON subkomponen_input.kode_kegiatan = program.kode_kegiatan AND subkomponen_input.kode_output = program.kode_output AND subkomponen_input.kode_program = program.kode_program "
                        . "JOIN komponen_input ON subkomponen_input.kode_kegiatan = komponen_input.kode_kegiatan AND subkomponen_input.kode_output = komponen_input.kode_output AND subkomponen_input.kode_program = komponen_input.kode_program AND subkomponen_input.kode_komponen = komponen_input.kode_komponen "
                        . "WHERE subkomponen_input.kode_kegiatan = '{$kegiatan}' AND subkomponen_input.kode_output = '{$output}' AND subkomponen_input.kode_program = '{$program}' AND subkomponen_input.kode_komponen = '{$komponen_input}' AND subkomponen_input.kode_subkomponen = '{$subkomponen_input}' ";
                        
                        
//                        echo $query ; die;
                        
            $q = $rba->query($query);

            $result = $q->row();
            
            return $result;
            
        }
        
        function get_detail_rsa($unit,$kode,$sumber_dana,$tahun){
            
            //$unit = substr($kode,0,2);
            $lenunit = strlen($unit);
            $rka = $kode;//substr($kode,2,10);
            
            $query  = "SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_usulan_belanja,rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,rba.subunit.nama_subunit,rba.sub_subunit.nama_sub_subunit,volume,deskripsi,satuan,harga_satuan,kode_akun_tambah,RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) AS akun,rsa_detail_belanja_.impor,rsa_detail_belanja_.proses FROM "
                    . "rsa_detail_belanja_ "
                    . "JOIN rba.akun_belanja ON RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) = rba.akun_belanja.kode_akun AND rsa_detail_belanja_.sumber_dana = rba.akun_belanja.sumber_dana "
                    . "JOIN rba.subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,4) = rba.subunit.kode_subunit "
                    . "JOIN rba.sub_subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,6) = rba.sub_subunit.kode_sub_subunit "
                    . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' "
                    . "AND rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}') "
                    . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                    . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "rsa_detail_belanja_.kode_akun_tambah ASC" ;
                    
                $query		= $this->db->query($query) ;
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
        }
        
        function get_detail_rsa_to_validate($unit,$kode,$sumber_dana,$tahun){
            
            //$unit = substr($kode,0,2);
            $lenunit = strlen($unit);
            $rka = $kode;//substr($kode,2,10);
            
            $query  = "SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_usulan_belanja,rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,rba.subunit.nama_subunit,rba.sub_subunit.nama_sub_subunit,volume,deskripsi,satuan,harga_satuan,kode_akun_tambah,RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) AS akun,rsa_detail_belanja_.impor,rsa_detail_belanja_.proses FROM "
                    . "rsa_detail_belanja_ "
                    . "JOIN rba.akun_belanja ON RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) = rba.akun_belanja.kode_akun AND rsa_detail_belanja_.sumber_dana = rba.akun_belanja.sumber_dana "
                    . "JOIN rba.subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,4) = rba.subunit.kode_subunit "
                    . "JOIN rba.sub_subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,6) = rba.sub_subunit.kode_sub_subunit "
                    . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' "
                    . "AND rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ "
                                                            . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}') "
                    . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                    . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "rsa_detail_belanja_.kode_akun_tambah ASC" ;
//                 var_dump($query);die;  
                $query		= $this->db->query($query) ;
				
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
        }
		
		//function get_detail_rsa_dpa($kode,$sumber_dana,$tahun){
        
        function get_detail_rsa_dpa($unit,$kode,$sumber_dana,$tahun){
            
//            $unit = substr($kode,0,2);
            $lenunit = strlen($unit);
            $rka = $kode;//substr($kode,2,10);
            
            $query1  = "SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_usulan_belanja,rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,rba.subunit.nama_subunit,rba.sub_subunit.nama_sub_subunit,"
                    . "rsa_detail_belanja_.kode_akun_tambah,SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,6) AS akun,rsa_detail_belanja_.impor,rsa_detail_belanja_.proses,rkd1.id_kuitansi,"
                    . "rsa_detail_belanja_.volume,rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan,rsa_kuitansi.aktif,rkd1.id_kuitansi AS rsa_kuitansi_detail_id_kuitansi,rsa_kuitansi.no_bukti,rsa_kuitansi.str_nomor_trx,rsa_kuitansi.str_nomor_trx_spm "
                    . "FROM rsa_detail_belanja_ "
                    . "JOIN rba.akun_belanja ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,6) = rba.akun_belanja.kode_akun AND rsa_detail_belanja_.sumber_dana = rba.akun_belanja.sumber_dana "
                    . "JOIN rba.subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,4) = rba.subunit.kode_subunit "
                    . "JOIN rba.sub_subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,6) = rba.sub_subunit.kode_sub_subunit "
                    . "LEFT JOIN rsa_kuitansi_detail AS rkd1 ON rsa_detail_belanja_.kode_usulan_belanja = rkd1.kode_usulan_belanja AND rsa_detail_belanja_.kode_akun_tambah = rkd1.kode_akun_tambah "
                    . "LEFT JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rkd1.id_kuitansi "
                    . "WHERE SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' AND SUBSTR(rsa_detail_belanja_.proses,1,1) > 2 "
                    . "AND rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' GROUP BY rsa_detail_belanja_.impor ) "
                    . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                    . "AND ( rkd1.id_kuitansi = (SELECT MAX(rkd2.id_kuitansi) FROM rsa_kuitansi_detail AS rkd2 WHERE rkd2.kode_usulan_belanja = rkd1.kode_usulan_belanja AND rkd2.kode_akun_tambah = rkd1.kode_akun_tambah AND rkd2.sumber_dana = '{$sumber_dana}' AND rkd2.tahun = '{$tahun}'  ) "
                    . "OR ISNULL(rkd1.id_kuitansi) ) " // -> DI COMMENT OLEH IDRIS
                    . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6), "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6), "
                    . "rsa_detail_belanja_.kode_akun_tambah "
                    . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "rsa_detail_belanja_.kode_akun_tambah ASC " ;


            $query  = "SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_usulan_belanja,rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,rba.subunit.nama_subunit,rba.sub_subunit.nama_sub_subunit,"
                    . "rsa_detail_belanja_.kode_akun_tambah,SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,6) AS akun,rsa_detail_belanja_.impor,rsa_detail_belanja_.proses,"
                    . "rsa_detail_belanja_.volume,rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan "
                    . "FROM rsa_detail_belanja_ "
                    . "JOIN rba.akun_belanja ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,6) = rba.akun_belanja.kode_akun AND rsa_detail_belanja_.sumber_dana = rba.akun_belanja.sumber_dana "
                    . "JOIN rba.subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,4) = rba.subunit.kode_subunit "
                    . "JOIN rba.sub_subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,6) = rba.sub_subunit.kode_sub_subunit "
                    . "WHERE SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' AND SUBSTR(rsa_detail_belanja_.proses,1,1) > 2 "
                    . "AND rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' GROUP BY rsa_detail_belanja_.impor ) "
                    . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                    . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6), "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6), "
                    . "rsa_detail_belanja_.kode_akun_tambah "
                    . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "rsa_detail_belanja_.kode_akun_tambah ASC " ;
                    
                
                   // echo $query ; die;
                    
                $query		= $this->db->query($query) ;
		if ($query->num_rows()>0){
                   // echo '<pre>';
                   // var_dump($query->result());echo '</pre>';die;
			return $query->result();
		}else{
			return array();
		}
        }


        function get_status_dpa($rka,$sumber_dana,$tahun){

            $kode_usulan_belanja = substr($rka,0,24);
            $kode_akun_tambah = substr($rka,24,3);

            // echo $kode_usulan_belanja . '-' . $kode_akun_tambah ; die;

            $query = "SELECT rsa_kuitansi.id_kuitansi,rsa_kuitansi.aktif,rsa_kuitansi.no_bukti,rsa_kuitansi.str_nomor_trx,rsa_kuitansi.str_nomor_trx_spm,rsa_detail_belanja_.proses " 
                    . "FROM rsa_kuitansi_detail "
                    . "JOIN rsa_detail_belanja_ ON rsa_detail_belanja_.kode_usulan_belanja = rsa_kuitansi_detail.kode_usulan_belanja AND rsa_detail_belanja_.kode_akun_tambah = rsa_kuitansi_detail.kode_akun_tambah "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi "
                    . "WHERE rsa_kuitansi_detail.kode_usulan_belanja = '{$kode_usulan_belanja}' AND rsa_kuitansi_detail.kode_akun_tambah = '{$kode_akun_tambah}' "
                    . "ORDER BY rsa_kuitansi_detail.id_kuitansi_detail";

            $query      = $this->db->query($query) ;

            return $query->result_array();


        }
        
        function get_single_detail_rsa_dpa($kode_usulan_belanja,$kode_akun_tambah,$sumber_dana,$tahun){
            
            $unit = substr($kode_usulan_belanja,0,2);
            
            $query  = "SELECT rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.volume,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan "
                    . "FROM rsa_detail_belanja_ "
                    . "WHERE rsa_detail_belanja_.kode_usulan_belanja = '{$kode_usulan_belanja}' AND rsa_detail_belanja_.kode_akun_tambah = '{$kode_akun_tambah}' "
                    . "AND rsa_detail_belanja_.impor = ( SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' ) "
                    . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' " ;
                    
//                    echo $query; die; 
                    
                $query		= $this->db->query($query) ;
		if ($query->num_rows()>0){
			return $query->row();
		}else{
			return array();
		}
        }
        
        function get_detail_akun_rba($unit,$kode,$sumber_dana,$tahun){
            //$unit = substr($kode,0,2);
            $lenunit = strlen($unit);
            $rka = $kode;//substr($kode,2,10);
            
            $rba = $this->load->database('rba', TRUE);
            
            $query  = "SELECT rba.detail_belanja_.kode_usulan_belanja,rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,rba.subunit.nama_subunit,rba.sub_subunit.nama_sub_subunit,SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS total_harga,rba.detail_belanja_.revisi FROM "
                    . "rba.detail_belanja_ "
                    . "JOIN rba.akun_belanja ON RIGHT(rba.detail_belanja_.kode_usulan_belanja,6) = rba.akun_belanja.kode_akun AND rba.detail_belanja_.sumber_dana = rba.akun_belanja.sumber_dana "
                    . "JOIN rba.subunit ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,1,4) = rba.subunit.kode_subunit "
                    . "JOIN rba.sub_subunit ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,1,6) = rba.sub_subunit.kode_sub_subunit "
                    . "WHERE LEFT(rba.detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' "
                    . "AND rba.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba.detail_belanja_.tahun = '{$tahun}' "
                    . "AND rba.detail_belanja_.revisi = (SELECT MAX(rba.detail_belanja_.revisi) FROM rba.detail_belanja_ WHERE LEFT(rba.detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}') "
                    . "GROUP BY LEFT(rba.detail_belanja_.kode_usulan_belanja,6),RIGHT(rba.detail_belanja_.kode_usulan_belanja,6) "
                    . "ORDER BY LEFT(rba.detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "RIGHT(rba.detail_belanja_.kode_usulan_belanja,6) ASC " ;
                    
                $query		= $rba->query($query) ;
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
            
        }
        
        function get_detail_akun_rba_to_validate_sub_kegiatan($kode,$sumber_dana,$tahun){
            $unit = substr($kode,0,2);
//            $rka = substr($kode,2,10);
            
            $rba = $this->load->database('rba', TRUE);
            
            $query  = "SELECT SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,10) AS kode_usulan_belanja, "
                    . "rba.kegiatan.kode_kegiatan,rba.kegiatan.nama_kegiatan,rba.output.kode_output,rba.output.nama_output,rba.program.kode_program,rba.program.nama_program,rba.komponen_input.kode_komponen,rba.komponen_input.nama_komponen,rba.subkomponen_input.kode_subkomponen,rba.subkomponen_input.nama_subkomponen "
                    . "FROM rba.detail_belanja_ "
                    . "JOIN rba.kegiatan ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,2) = rba.kegiatan.kode_kegiatan "
                    . "JOIN rba.output ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,2) = output.kode_kegiatan AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,9,2) = output.kode_output "
                    . "JOIN rba.program ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,2) = program.kode_kegiatan AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,9,2) = program.kode_output AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,11,2) = program.kode_program "
                    . "JOIN rba.komponen_input ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,2) = komponen_input.kode_kegiatan AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,9,2) = komponen_input.kode_output AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,11,2) = komponen_input.kode_program AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,13,2) = komponen_input.kode_komponen "
                    . "JOIN rba.subkomponen_input ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,2) = subkomponen_input.kode_kegiatan AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,9,2) = subkomponen_input.kode_output AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,11,2) = subkomponen_input.kode_program AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,13,2) = subkomponen_input.kode_komponen AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,15,2) = subkomponen_input.kode_subkomponen "
                    . "WHERE LEFT(rba.detail_belanja_.kode_usulan_belanja,2) = '{$unit}' "
                    . "AND rba.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba.detail_belanja_.tahun = '{$tahun}' "
                    . "AND rba.detail_belanja_.revisi = (SELECT MAX(rba.detail_belanja_.revisi) FROM rba.detail_belanja_ WHERE LEFT(rba.detail_belanja_.kode_usulan_belanja,2) = '{$unit}') "
                    . "GROUP BY SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,10) "
                    . "ORDER BY SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,10) ASC " ;
                    
                $query		= $rba->query($query) ;
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
            
        }
        
        function get_detail_akun_rba_to_validate($kode,$sumber_dana,$tahun){
            $unit = substr($kode,0,2);
//            $rka = substr($kode,2,10);
            
            $rba = $this->load->database('rba', TRUE);
            
            $query  = "SELECT rba.detail_belanja_.kode_usulan_belanja,rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,rba.subunit.nama_subunit,rba.sub_subunit.nama_sub_subunit,SUM(rba.detail_belanja_.volume*rba.detail_belanja_.harga_satuan) AS total_harga,rba.detail_belanja_.revisi, "
                    . "rba.kegiatan.kode_kegiatan,rba.kegiatan.nama_kegiatan,rba.output.kode_output,rba.output.nama_output,rba.program.kode_program,rba.program.nama_program,rba.komponen_input.kode_komponen,rba.komponen_input.nama_komponen,rba.subkomponen_input.kode_subkomponen,rba.subkomponen_input.nama_subkomponen "
                    . "FROM rba.detail_belanja_ "
                    . "JOIN rba.akun_belanja ON RIGHT(rba.detail_belanja_.kode_usulan_belanja,6) = rba.akun_belanja.kode_akun AND rba.detail_belanja_.sumber_dana = rba.akun_belanja.sumber_dana "
                    . "JOIN rba.subunit ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,1,4) = rba.subunit.kode_subunit "
                    . "JOIN rba.sub_subunit ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,1,6) = rba.sub_subunit.kode_sub_subunit "
                    . "JOIN rba.kegiatan ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,2) = rba.kegiatan.kode_kegiatan "
                    . "JOIN rba.output ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,2) = output.kode_kegiatan AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,9,2) = output.kode_output "
                    . "JOIN rba.program ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,2) = program.kode_kegiatan AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,9,2) = program.kode_output AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,11,2) = program.kode_program "
                    . "JOIN rba.komponen_input ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,2) = komponen_input.kode_kegiatan AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,9,2) = komponen_input.kode_output AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,11,2) = komponen_input.kode_program AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,13,2) = komponen_input.kode_komponen "
                    . "JOIN rba.subkomponen_input ON SUBSTR(rba.detail_belanja_.kode_usulan_belanja,7,2) = subkomponen_input.kode_kegiatan AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,9,2) = subkomponen_input.kode_output AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,11,2) = subkomponen_input.kode_program AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,13,2) = subkomponen_input.kode_komponen AND SUBSTR(rba.detail_belanja_.kode_usulan_belanja,15,2) = subkomponen_input.kode_subkomponen "
                    . "WHERE LEFT(rba.detail_belanja_.kode_usulan_belanja,2) = '{$unit}' "
                    . "AND rba.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba.detail_belanja_.tahun = '{$tahun}' "
                    . "AND rba.detail_belanja_.revisi = (SELECT MAX(rba.detail_belanja_.revisi) FROM rba.detail_belanja_ WHERE LEFT(rba.detail_belanja_.kode_usulan_belanja,2) = '{$unit}') "
                    . "GROUP BY LEFT(rba.detail_belanja_.kode_usulan_belanja,16),RIGHT(rba.detail_belanja_.kode_usulan_belanja,6) "
                    . "ORDER BY LEFT(rba.detail_belanja_.kode_usulan_belanja,16) ASC, "
                    . "RIGHT(rba.detail_belanja_.kode_usulan_belanja,6) ASC " ;
                    
                $query		= $rba->query($query) ;
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
            
        }
        
        function do_delete_rsa_detail_belanja($id_rsa_detail){
            return $this->db->delete('rsa_detail_belanja_', array('id_rsa_detail' => $id_rsa_detail));
        }
        
        function add_rsa_detail_belanja($data){
            return $this->db->insert('rsa_detail_belanja_',$data);
        }
        
        function edit_rsa_detail_belanja($data,$id_rsa_detail){
            return $this->db->update('rsa_detail_belanja_', $data, array('id_rsa_detail'=>$id_rsa_detail));
        }
        
        function get_next_kode_akun_tambah($kode_usul_belanja,$sumber_dana,$tahun){
		$q = $this->db->query("SELECT IFNULL(MAX(kode_akun_tambah),0) AS next_kode_akun_tambah FROM rsa_detail_belanja_ WHERE kode_usulan_belanja = '{$kode_usul_belanja}' AND sumber_dana = '{$sumber_dana}' AND tahun = '{$tahun}'");

		$row = $q->row();

		$x = intval($row->next_kode_akun_tambah) + 1;
		if(strlen($x)==1){
				$x = '00'.$x;
		}
		elseif(strlen($x)==2){
				$x = '0'.$x;
		}
		elseif(strlen($x)==3){
				$x = $x;
		}

		return $x;
	}
        
        function get_single_detail($id='')
	{
		/* running query	*/
		$query = $this->db->get_where('rsa_detail_belanja_', array('id_rsa_detail' => $id));
		if ($query->num_rows()>0){
			return $query->row();
		}else{
			return '';
		}
	}
        
        function post_proses_tor($kode,$sumber_dana,$tahun){
            
            $unit = substr($kode,0,2);
            $rka = substr($kode,2,10);
            $query = "UPDATE rsa_detail_belanja_ SET rsa_detail_belanja_.proses = '1' WHERE SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,2) = '{$unit}' "
                        . "AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' "
                        . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' "
                        . "AND rsa_detail_belanja_.tahun = '{$tahun}'" ;

            return $this->db->query($query);
                        
        }
        
        function post_proses_tor_rsa_detail($id_rsa_detail,$proses){
            
            $query = "UPDATE rsa_detail_belanja_ SET rsa_detail_belanja_.proses = '{$proses}' WHERE rsa_detail_belanja_.id_rsa_detail = '{$id_rsa_detail}' " ;

            return $this->db->query($query);
            
        }
        
        function post_proses_tor_to_validate($id_rsa_detail,$proses){
            
            $query = "UPDATE rsa_detail_belanja_ SET rsa_detail_belanja_.proses = '{$proses}' WHERE rsa_detail_belanja_.id_rsa_detail = '{$id_rsa_detail}' " ;

            return $this->db->query($query);
            
        }
        
        function post_proses_rsa_to_validate($id_rsa_detail){
            
            $query = "UPDATE rsa_detail_belanja_ SET rsa_detail_belanja_.proses = '2' WHERE rsa_detail_belanja_.id_rsa_detail = '{$id_rsa_detail}' " ;

            return $this->db->query($query);
            
        }
       
        
        
	function get_tor($where=""){
		if(!$where==""){
			$this->db2->where('kode_usulan_belanja',$where);
		}
		$this->db2->order_by("kode_usulan_belanja");
		$query = $this->db2->get("detail_belanja_");
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	function search_tor($sumber_dana='',$kata_kunci=''){
		/*	Filter xss n sepecial char */
		$kata_kunci	 = form_prep($kata_kunci);
		$sumber_dana = form_prep($sumber_dana);
		if($sumber_dana == ''){
			if($kata_kunci!='')
			{
				$where = "kode_usulan_belanja LIKE '%{$kata_kunci}%' OR deskripsi LIKE '%{$kata_kunci}%'";
				$this->db2->where($where);
			}
			
		}else{
			$where = "sumber_dana = '{$sumber_dana}'";	
				if($kata_kunci!='')
				{
					$where .= " AND (kode_usulan_belanja LIKE '%{$kata_kunci}%' OR nama_akun LIKE '%{$kata_kunci}%')";
				}
				$this->db2->where($where);
		}
		
		
		$this->db2->order_by("kode_usulan_belanja", "asc"); 
		/* running query	*/
		$query		= $this->db2->get('detail_belanja_');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
        
        function get_tor_kegiatan_usul($unit,$sumber_dana,$tahun){
                $rba = $this->load->database('rba', TRUE);
                
                $query = "SELECT LEFT(detail_belanja_.kode_usulan_belanja,2) AS k_unit,kegiatan.nama_kegiatan,kegiatan.kode_kegiatan,output.nama_output,output.kode_output,program.nama_program,program.kode_program,SUM(detail_belanja_.volume*detail_belanja_.harga_satuan) AS jumlah_tot "
                        . "FROM detail_belanja_ "
                        . "JOIN kegiatan ON SUBSTR(detail_belanja_.kode_usulan_belanja,7,2) = kegiatan.kode_kegiatan "
                        . "JOIN output ON SUBSTR(detail_belanja_.kode_usulan_belanja,7,2) = output.kode_kegiatan AND SUBSTR(detail_belanja_.kode_usulan_belanja,9,2) = output.kode_output "
                        . "JOIN program ON SUBSTR(detail_belanja_.kode_usulan_belanja,7,2) = program.kode_kegiatan AND SUBSTR(detail_belanja_.kode_usulan_belanja,9,2) = program.kode_output AND SUBSTR(detail_belanja_.kode_usulan_belanja,11,2) = program.kode_program "
                        . "WHERE LEFT(detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' "
                        . "GROUP BY SUBSTR(detail_belanja_.kode_usulan_belanja,7,6) "
                        . "ORDER BY SUBSTR(detail_belanja_.kode_usulan_belanja,7,6) ASC";
                
                $query = $rba->query($query);

		$result = $query->result();

		return $result ;

        }
        
        function get_alias_unit($kode_unit){
            $rba = $this->load->database('rba', TRUE);
            if(strlen($kode_unit)=='4'){
                $kode_unit_ = substr($kode_unit,0,2);
                $kode_subunit = substr($kode_unit,2,2);
                if($kode_unit_ == '41'){
                    switch ($kode_subunit){
                        case '11'       : return 'W11'; break;
                        case '13'       : return 'W12'; break;
                        case '12'       : return 'W13'; break;
                        case '14'       : return 'W14'; break;
                    }
                }elseif($kode_unit_ == '42'){
                    switch ($kode_subunit){
                        case '11'       : return 'W21'; break;
                        case '13'       : return 'W22'; break;
                        case '12'       : return 'W23'; break;
                        case '14'       : return 'W24'; break;
                    }
                }elseif($kode_unit_ == '43'){
                    switch ($kode_subunit){
                        case '11'       : return 'W31'; break;
                        case '13'       : return 'W32'; break;
                        case '12'       : return 'W33'; break;
                        case '14'       : return 'W34'; break;
                    }
                }elseif($kode_unit_ == '44'){
                    switch ($kode_subunit){
                        case '11'       : return 'W41'; break;
                        case '13'       : return 'W42'; break;
                        case '12'       : return 'W43'; break;
                        case '14'       : return 'W44'; break;
                    }
                }else{
                    $rba->where('unit.kode_unit',substr($kode_unit,0,2));
                    $q = $rba->get('rba.unit')->row();

                    return $q->alias ;
                }
            }elseif(strlen($kode_unit)=='6'){
                $kode_unit_ = substr($kode_unit,0,2);
                $kode_subunit = substr($kode_unit,2,2);
                if($kode_unit_ == '41'){
                    switch ($kode_subunit){
                        case '11'       : return 'W11'; break;
                        case '13'       : return 'W12'; break;
                        case '12'       : return 'W13'; break;
                        case '14'       : return 'W14'; break;
                    }
                }elseif($kode_unit_ == '42'){
                    switch ($kode_subunit){
                        case '11'       : return 'W21'; break;
                        case '13'       : return 'W22'; break;
                        case '12'       : return 'W23'; break;
                        case '14'       : return 'W24'; break;
                    }
                }elseif($kode_unit_ == '43'){
                    switch ($kode_subunit){
                        case '11'       : return 'W31'; break;
                        case '13'       : return 'W32'; break;
                        case '12'       : return 'W33'; break;
                        case '14'       : return 'W34'; break;
                    }
                }elseif($kode_unit_ == '44'){
                    switch ($kode_subunit){
                        case '11'       : return 'W41'; break;
                        case '13'       : return 'W42'; break;
                        case '12'       : return 'W43'; break;
                        case '14'       : return 'W44'; break;
                    }
                }else{
                    $rba->where('unit.kode_unit',substr($kode_unit,0,2));
                    $q = $rba->get('rba.unit')->row();

                    return $q->alias ;
                }
            }else{
                    $rba->where('unit.kode_unit',$kode_unit);
                    $q = $rba->get('rba.unit')->row();

                    return $q->alias ;
            }
            
        }
        
        function get_pic_kuitansi($kode_unit){
            
            if((substr($kode_unit,0,2) == '41')||(substr($kode_unit,0,2) == '42')||(substr($kode_unit,0,2) == '43')||(substr($kode_unit,0,2) == '44')){
                $kode_unit = $kode_unit;
            
            }else{
                $kode_unit = substr($kode_unit,0,2);
            }
            $data = array();
            $this->db->where('rsa_user.kode_unit_subunit',$kode_unit);
            $this->db->where('rsa_user.level','15');
            $q = $this->db->get('rsa_user')->row();
            $pppk_nm_lengkap = isset($q->nm_lengkap)?$q->nm_lengkap:'- belum ada -';
            $pppk_nip = isset($q->nip)?$q->nip:'- belum ada -';

            if((substr($kode_unit,0,2) == '41')||(substr($kode_unit,0,2) == '42')||(substr($kode_unit,0,2) == '43')||(substr($kode_unit,0,2) == '44')){
                $kode_unit = substr($kode_unit,0,4) ;
            }
            
            $this->db->where('rsa_user.kode_unit_subunit',$kode_unit);
            $this->db->where('rsa_user.level','13');
            $q = $this->db->get('rsa_user')->row();
            $bendahara_nm_lengkap = isset($q->nm_lengkap)?$q->nm_lengkap:'- belum ada -';
            $bendahara_nip = isset($q->nip)?$q->nip:'- belum ada -';
            
//            $this->db->where('rsa_user.kode_unit_subunit',$kode_unit);
//            $this->db->where('rsa_user.level','4');
//            $q = $this->db->get('rsa_user')->row();
//            $pumk_nm_lengkap = isset($q->nm_lengkap)?$q->nm_lengkap:'- belum ada -';
//            $pumk_nip = isset($q->nip)?$q->nip:'- belum ada -';
            
            return array('pppk_nm_lengkap' => $pppk_nm_lengkap , 'pppk_nip' => $pppk_nip , 'bendahara_nm_lengkap' => $bendahara_nm_lengkap , 'bendahara_nip' => $bendahara_nip );
        }
        
        
        
        function get_pppk($kode_unit_subunit){
            $lenunit = strlen($kode_unit_subunit);
            
            $query  = "SELECT id,nm_lengkap,nomor_induk "
                    . "FROM rsa_user "
                    . "WHERE LEFT(kode_unit_subunit,{$lenunit}) = '{$kode_unit_subunit}' "
                    . "AND level = '15' "
                    . "ORDER BY rsa_user.id ASC " ;
            
            $query = $this->db->query($query) ;
			
            if ($query->num_rows()>0){
                    return $query->result();
            }else{
                    return array();
            }
            
        }
        function get_ppk($kode_unit_subunit){
            $lenunit = strlen($kode_unit_subunit);
            
            $query  = "SELECT id,nm_lengkap,nomor_induk "
                    . "FROM rsa_user "
                    . "WHERE LEFT(kode_unit_subunit,{$lenunit}) = '{$kode_unit_subunit}' "
                    . "AND level = '16' "
                    . "ORDER BY rsa_user.id ASC " ;
            
            $query = $this->db->query($query) ;
            
            if ($query->num_rows()>0){
                    return $query->result();
            }else{
                    return array();
            }
            
        }
		function get_kontrak($kode){  
			$unit = substr($kode,0,2);
            $rka = substr($kode,2,10);		
            
			$query  = "SELECT * FROM rsa_spm_kontrakpihak3 WHERE kode_usulan_belanja='{$kode}' AND LEFT(kode_usulan_belanja,2) = '{$unit}' AND SUBSTR(kode_usulan_belanja,7,10) = '{$rka}' ORDER BY kode_usulan_belanja ASC " ;
			//var_dump($query);die;
            $query		= $this->db->query($query) ;
			
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
            
        }
        
		function get_detail_rsa_kontrak($kodex,$tahun,$kode_akun_tambah,$unit){
          
            //AND SUBSTR(kode_usulan_belanja,17,2) =
            $query  = "SELECT * FROM rsa_spm_kontrakpihak3 WHERE kode_usulan_belanja='{$kodex}' AND DATE_FORMAT(tanggal,'%Y')='{$tahun}' AND kode_akun_tambah='{$kode_akun_tambah}' GROUP BY kode_akun_tambah" ;
               // var_dump($query);die;
                $query		= $this->db->query($query) ;
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
        }
		function get_detail_rsa_kontrak2($kode,$akun_tambah,$tahun,$nominal,$unit){
            
            //AND SUBSTR(kode_usulan_belanja,17,2) =
            $query  = "SELECT * FROM rsa_spm_kontrakpihak3 WHERE kode_usulan_belanja='{$kode}' AND kode_akun_tambah='{$akun_tambah}' AND kontrak_terbayar='{$nominal}' AND DATE_FORMAT(tanggal,'%Y')='{$tahun}'  ORDER BY kode_usulan_belanja ASC" ;
                   // var_dump($query);die;
                $query		= $this->db->query($query) ;
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
        }
	
}