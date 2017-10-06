<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rsa_tup_model extends CI_Model {
/* -------------- Constructor ------------- */

	
        public function __construct()
        {
                
                parent::__construct();
				
        }
	
	function search_rsa_up($kata_kunci=''){
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		if($kata_kunci!='')
		{
			$this->db->like('kd_transaksi', $kata_kunci);
			//$this->db->or_like('no_spm', $kata_kunci);
		}
		$this->db->order_by("no_up", "asc"); 
		/* running query	*/
		$query		= $this->db->get('rsa_up');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	function add_rsa_up($data){
		//print_r($data);die;
		return $this->db->insert("rsa_up",$data);
		
	}
	function get_rsa_up($where=""){
		if(!$where==""){
			$this->db->where('no_up',$where);
		}
		$this->db->order_by("no_up");
		$query = $this->db->get("rsa_up");
	//	print_r($query);die;
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
        
        function check_dokumen_tup($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT posisi FROM trx_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->posisi ;
            }else{
                return '';
            }
        }

        function check_dokumen_tup_by_str_trx($no_str_trx){

            $query = "SELECT posisi "
                    . "FROM trx_nomor_tup AS tt1 "
                    . "JOIN trx_tup AS t1 ON t1.id_trx_nomor_tup = tt1.id_trx_nomor_tup "
                    . "WHERE tt1.str_nomor_trx = '{$no_str_trx}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_tup AS t2 "
                        . "WHERE t2.id_trx_nomor_tup = t1.id_trx_nomor_tup )" ;

            $q = $this->db->query($query);
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->posisi ;
            }else{
                return '';
            }
        }
        
        function lihat_ket($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT ket FROM trx_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->ket ;
            }else{
                return '';
            }
        }

        function lihat_ket_by_str_trx($str_trx){
            // $q = $this->db->query("SELECT ket FROM trx_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1'  AND tahun = '{$tahun}' ");

            $query = "SELECT ket "
                    . "FROM trx_nomor_tup AS tt1 "
                    . "JOIN trx_tup AS t1 ON t1.id_trx_nomor_tup = tt1.id_trx_nomor_tup "
                    . "WHERE tt1.str_nomor_trx = '{$no_str_trx}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_tup AS t2 "
                        . "WHERE t2.id_trx_nomor_tup = t1.id_trx_nomor_tup )" ;

            $q = $this->db->query($query);

//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->ket ;
            }else{
                return '';
            }
        }
        
        function proses_nomor_spp_tup($kode_unit,$data){
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('jenis', 'SPP');
            $this->db->where('kode_unit_subunit', $kode_unit);
            $this->db->update('trx_nomor_tup', array('aktif'=>'0')); 
            
            return $this->db->insert('trx_nomor_tup',$data);
            
        }
               
        function proses_nomor_spm_tup($kode_unit,$data){
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('jenis', 'SPM');
            $this->db->where('kode_unit_subunit', $kode_unit);
            $this->db->update('trx_nomor_tup', array('aktif'=>'0')); 
            
            return $this->db->insert('trx_nomor_tup',$data);
            
        }
        
        function proses_trx_spp_spm($data){
            
            return $this->db->insert('trx_spp_spm',$data);
            
        }
        
        function proses_tup($kode_unit,$data){
            
            if(($data['posisi'] == 'SPP-DITOLAK')||($data['posisi'] == 'SPM-DITOLAK-KPA')||($data['posisi'] == 'SPM-DITOLAK-VERIFIKATOR')||($data['posisi'] == 'SPM-DITOLAK-KBUU')){
                    $this->db->where('tahun', $data['tahun']);
                    $this->db->where('aktif', '1');
                    $this->db->where('kode_unit_subunit', $kode_unit);
                    $this->db->update('trx_nomor_tup', array('aktif'=>'0'));    
            }
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('kode_unit_subunit', $kode_unit);
            $this->db->update('trx_tup', array('aktif'=>'0')); 
            
            return $this->db->insert('trx_tup',$data);
            
        }
        
        function final_tup($kode_unit,$data){
            
            
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('kd_unit', $kode_unit);
            $this->db->update('kas_bendahara', array('aktif'=>'0'));
            
            return $this->db->insert('kas_bendahara',$data);
            
        }
        
        function get_tgl_spp($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT MAX(tgl_proses) AS tgl_proses FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif='1' ");
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
        
        function get_nomor_spp($kode_unit_subunit,$tahun){
            
//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_up WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' " ; die;

//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_up WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' ";die;
            
            $q = $this->db->query("SELECT str_nomor_trx AS nt FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' ");
            
            
            
            if($q->num_rows() > 0){
               return $q->row()->nt ;
            }else{
                return '' ;
            }
        }
        
        function get_nomor_spm($kode_unit_subunit,$tahun){
            
//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_up WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' " ; die;
            
            $q = $this->db->query("SELECT str_nomor_trx AS nt FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' AND aktif = '1' ");
            
            
            if($q->num_rows() > 0){
               return $q->row()->nt ;
            }else{
                return '' ;
            }
        }
        
        function get_nomor_next_spp($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT IFNULL(MAX(nomor_trx),0) AS nt FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
//            if($q->num_rows() > 0){
//               return $q->row()->tgl_proses ;
//            }else{
                $x = intval($q->row()->nt) + 1;
		if(strlen($x)==1){
				$x = '0000'.$x;
		}
		elseif(strlen($x)==2){
				$x = '000'.$x;
		}
		elseif(strlen($x)==3){
				$x = '00'.$x;
		}
                elseif(strlen($x)==4){
				$x = '0'.$x;
		}
                elseif(strlen($x)==5){
				$x = $x;
		}

		return $x;
//            } 
        }
        
        function get_nomor_next_spm($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT IFNULL(MAX(nomor_trx),0) AS nt FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
//            if($q->num_rows() > 0){
//               return $q->row()->tgl_proses ;
//            }else{
                $x = intval($q->row()->nt) + 1;
		if(strlen($x)==1){
				$x = '0000'.$x;
		}
		elseif(strlen($x)==2){
				$x = '000'.$x;
		}
		elseif(strlen($x)==3){
				$x = '00'.$x;
		}
                elseif(strlen($x)==4){
				$x = '0'.$x;
		}
                elseif(strlen($x)==5){
				$x = $x;
		}

		return $x;
//            } 
        }
        
        function get_id_nomor_tup($jenis,$kode_unit_subunit,$tahun){
//            echo "SELECT id_trx_nomor_up FROM trx_nomor_up WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}' AND aktif='1' "; die;
            $q = $this->db->query("SELECT id_trx_nomor_tup FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}' AND aktif='1' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->id_trx_nomor_tup ;
            }else{
            
            }
        }
        
        function get_tgl_spm($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT tgl_proses AS tgl_proses FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' AND aktif='1' ");
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
        
        function get_tgl_spm_kpa($kode_unit_subunit,$tahun,$nomor_trx_spm){
            
            $str = "SELECT trx_tup.tgl_proses FROM trx_nomor_tup "
                    . "JOIN trx_tup ON trx_nomor_tup.id_trx_nomor_tup = trx_tup.id_trx_nomor_tup "
                    . "WHERE trx_nomor_tup.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_tup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_tup.posisi = 'SPM-DRAFT-KPA' AND trx_nomor_tup.tahun = '{$tahun}' "
                    . "AND trx_nomor_tup.aktif = '1'";
                    
//            var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }


        function get_tgl_spm_kpa_by_spm($nomor_trx_spm){

            $str = "SELECT trx_tup.tgl_proses FROM trx_nomor_tup "
                    . "JOIN trx_tup ON trx_nomor_tup.id_trx_nomor_tup = trx_tup.id_trx_nomor_tup "
                    . "WHERE trx_nomor_tup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_tup.posisi = 'SPM-DRAFT-KPA'" ;
                
                    
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
            
            $str = "SELECT trx_tup.tgl_proses FROM trx_nomor_tup "
                    . "JOIN trx_tup ON trx_nomor_tup.id_trx_nomor_tup = trx_tup.id_trx_nomor_tup "
                    . "WHERE trx_nomor_tup.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_tup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_tup.posisi = 'SPM-FINAL-VERIFIKATOR' AND trx_nomor_tup.tahun = '{$tahun}' "
                    . "AND trx_nomor_tup.aktif = '1'";
                    
           // var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }

        function get_tgl_spm_verifikator_by_spm($nomor_trx_spm){
            
            $str = "SELECT trx_tup.tgl_proses FROM trx_nomor_tup "
                    . "JOIN trx_tup ON trx_nomor_tup.id_trx_nomor_tup = trx_tup.id_trx_nomor_tup "
                    . "WHERE trx_nomor_tup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_tup.posisi = 'SPM-FINAL-VERIFIKATOR'";
                    
           // var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
        
        function get_tgl_spm_kbuu($kode_unit_subunit,$tahun,$nomor_trx_spm){
            
            $str = "SELECT trx_tup.tgl_proses FROM trx_nomor_tup "
                    . "JOIN trx_tup ON trx_nomor_tup.id_trx_nomor_tup = trx_tup.id_trx_nomor_tup "
                    . "WHERE trx_nomor_tup.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_tup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_tup.posisi = 'SPM-FINAL-KBUU' AND trx_nomor_tup.tahun = '{$tahun}' "
                    . "AND trx_nomor_tup.aktif = '1'";
                    
//            var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            

        }

        function get_tgl_spm_kbuu_by_spm($nomor_trx_spm){
            
            $str = "SELECT trx_tup.tgl_proses FROM trx_nomor_tup "
                    . "JOIN trx_tup ON trx_nomor_tup.id_trx_nomor_tup = trx_tup.id_trx_nomor_tup "
                    . "WHERE trx_nomor_tup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_tup.posisi = 'SPM-FINAL-KBUU'";
                    
//            var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            

        }
        
        function get_tup_unit_usul($tahun){
            
            $query = "SELECT rba.unit.nama_unit,rba.unit.kode_unit,rsa.trx_tup.posisi,rsa.trx_tup.aktif,rsa.trx_tup.tgl_proses,rsa.trx_tup.tahun "
                    . "FROM rba.unit LEFT JOIN rsa.trx_tup ON rba.unit.kode_unit = rsa.trx_tup.kode_unit_subunit "
                    . "WHERE ( rsa.trx_tup.aktif = '1' OR rsa.trx_tup.aktif IS NULL ) "
                    . "AND ( rsa.trx_tup.tahun = '{$tahun}' OR rsa.trx_tup.tahun IS NULL ) "
                    . "GROUP BY rba.unit.kode_unit "
                    . "ORDER BY rba.unit.kode_unit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
        
        function get_tup_subunit_usul($tahun){
            
            $query = "SELECT rba.subunit.nama_subunit,rba.subunit.kode_subunit,rsa.trx_tup.posisi,rsa.trx_tup.aktif,rsa.trx_tup.tgl_proses,rsa.trx_tup.tahun "
                    . "FROM rba.subunit LEFT JOIN rsa.trx_tup ON rba.subunit.kode_subunit = rsa.trx_tup.kode_unit_subunit "
                    . "WHERE ( rsa.trx_tup.aktif = '1' OR rsa.trx_tup.aktif IS NULL ) "
                    . "AND ( rsa.trx_tup.tahun = '{$tahun}' OR rsa.trx_tup.tahun IS NULL ) "
                    . "GROUP BY rba.subunit.kode_subunit "
                    . "ORDER BY rba.subunit.kode_subunit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
        
        function get_tup_unit_usul_verifikator($id_user_verifikator,$tahun){
            
            $query = "SELECT rba.unit.nama_unit,rba.unit.kode_unit,rsa.trx_tup.posisi,rsa.trx_tup.aktif,rsa.trx_tup.tgl_proses,rsa.trx_tup.tahun "
                    . "FROM rba.unit "
                    . "JOIN rsa_verifikator_unit ON rba.unit.kode_unit = rsa_verifikator_unit.kode_unit_subunit "
                    . "LEFT JOIN rsa.trx_tup ON rba.unit.kode_unit = rsa.trx_tup.kode_unit_subunit "
                    . "WHERE rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
                    . "AND ( rsa.trx_tup.aktif = '1' OR rsa.trx_tup.aktif IS NULL ) "
                    . "AND ( rsa.trx_tup.tahun = '{$tahun}' OR rsa.trx_tup.tahun IS NULL ) "
                    . "GROUP BY rba.unit.kode_unit "
                    . "ORDER BY rba.unit.kode_unit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
        
        function get_tup_subunit_usul_verifikator($id_user_verifikator,$tahun){
            
            $query = "SELECT rba.subunit.nama_subunit,rba.subunit.kode_subunit,rsa.trx_tup.posisi,rsa.trx_tup.aktif,rsa.trx_tup.tgl_proses,rsa.trx_tup.tahun "
                    . "FROM rba.subunit "
                    . "JOIN rsa_verifikator_unit ON SUBSTR(rba.subunit.kode_subunit,1,2) = rsa_verifikator_unit.kode_unit_subunit "
                    . "LEFT JOIN rsa.trx_tup ON rba.subunit.kode_subunit = rsa.trx_tup.kode_unit_subunit "
                    . "WHERE rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
                    . "AND ( rsa.trx_tup.aktif = '1' OR rsa.trx_tup.aktif IS NULL ) "
                    . "AND ( rsa.trx_tup.tahun = '{$tahun}' OR rsa.trx_tup.tahun IS NULL ) "
                    . "GROUP BY rba.subunit.kode_subunit "
                    . "ORDER BY rba.subunit.kode_subunit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
        
        function get_up_unit($tahun){
            
            $query = "SELECT rba.unit.nama_unit,rba.unit.kode_unit,rsa.kas_bendahara.saldo "
                    . "FROM rba.unit "
                    . "LEFT JOIN rsa.kas_bendahara ON rba.unit.kode_unit = rsa.kas_bendahara.kd_unit "
                    . "WHERE ( rsa.kas_bendahara.aktif = '1' OR rsa.kas_bendahara.saldo IS NULL ) "
                    . "AND ( rsa.kas_bendahara.tahun = '{$tahun}' OR rsa.kas_bendahara.tahun IS NULL ) "
                    . "ORDER BY rba.unit.kode_unit ASC" ;
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
        
//        function get_verifikator($kode_unit_subunit,$tahun,$nomor_trx_spm){
//            $str = "SELECT rsa_user.nm_lengkap,rsa_user.nip FROM trx_spm_verifikator "
//                    . "JOIN rsa_user ON rsa_user.id = trx_spm_verifikator.id_rsa_user_verifikator "
//                    . "JOIN trx_nomor_tup ON trx_nomor_tup.nomor_trx = trx_spm_verifikator.nomor_trx_spm "
//                    . "WHERE trx_nomor_tup.kode_unit_subunit = '{$kode_unit_subunit}' "
//                    . "AND trx_nomor_tup.nomor_trx = '{$nomor_trx_spm}' "
//                    . "AND trx_spm_verifikator.tahun = '{$tahun}' ";
//                    
//            $nomor_ = explode('/',$nomor_trx_spm);
//            $nomor = (int)$nomor_[0];
//                    
//            $str1 = "SELECT rsa_user.nm_lengkap,rsa_user.nomor_induk "
//                    . "FROM trx_spm_verifikator "
//                    . "JOIN rsa_user ON rsa_user.id = trx_spm_verifikator.id_rsa_user_verifikator "
//                    . "WHERE trx_spm_verifikator.kode_unit_subunit = '{$kode_unit_subunit}' "
//                    . "AND trx_spm_verifikator.nomor_trx_spm = '{$nomor}' "
//                    . "AND jenis_trx = 'GUP' "
//                    . "AND trx_spm_verifikator.tahun = '{$tahun}' " ;
//                    
////            var_dump($str1);die;
//                    
//            $q = $this->db->query($str1);
//    //            var_dump($q->num_rows());die;
//                // if($q->num_rows() > 0){
//                   return $q->row();
//                // }else{
//                   // return '';
//                // } 
//        }
        
        function get_verifikator_by_spm($nomor_trx_spm){ 

            $str2 = "SELECT nmverifikator AS nm_lengkap,nipverifikator AS nomor_induk FROM trx_spm_tup_data "
                    . "WHERE str_nomor_trx = '{$nomor_trx_spm}' " ;
                    
     
            $q = $this->db->query($str2);
                   return $q->row();

        }

        function get_verifikator($kode_unit_subunit){
//            $str = "SELECT rsa_user.nm_lengkap,rsa_user.nip FROM trx_spm_verifikator "
//                    . "JOIN rsa_user ON rsa_user.id = trx_spm_verifikator.id_rsa_user_verifikator "
//                    . "JOIN trx_nomor_up ON trx_nomor_up.nomor_trx = trx_spm_verifikator.nomor_trx_spm "
//                    . "WHERE trx_nomor_up.kode_unit_subunit = '{$kode_unit_subunit}' "
//                    . "AND trx_nomor_up.nomor_trx = '{$nomor_trx_spm}' "
//                    . "AND trx_spm_verifikator.tahun = '{$tahun}' ";
                    
            
                    
//            $nomor_ = explode('/',$nomor_trx_spm);
//            $nomor = (int)$nomor_[0];
                    
//            $str1 = "SELECT rsa_user.nm_lengkap,rsa_user.nomor_induk "
//                    . "FROM trx_spm_verifikator "
//                    . "JOIN rsa_user ON rsa_user.id = trx_spm_verifikator.id_rsa_user_verifikator "
//                    . "WHERE trx_spm_verifikator.kode_unit_subunit = '{$kode_unit_subunit}' "
//                    . "AND trx_spm_verifikator.nomor_trx_spm = '{$nomor}' "
//                    . "AND jenis_trx = 'UP' "
//                    . "AND trx_spm_verifikator.tahun = '{$tahun}' " ;
            
            $unit  = substr($kode_unit_subunit,0,2);

            $str2 = "SELECT rsa_user.nm_lengkap,rsa_user.nomor_induk FROM rsa_verifikator_unit "
                    . "JOIN rsa_user ON rsa_user.id = rsa_verifikator_unit.id_user_verifikator "
                    . "WHERE rsa_verifikator_unit.kode_unit_subunit = '{$unit}' " ;
                    
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
        
        function proses_verifikator_tup($data){
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
            
            $query = "SELECT *,t1.tgl_proses AS tgl_proses_status "
                    . "FROM trx_nomor_tup AS tt1 "
                    . "JOIN trx_tup AS t1 ON t1.id_trx_nomor_tup = tt1.id_trx_nomor_tup "
                    . "WHERE tt1.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND jenis = 'SPP' "
                    . "AND tt1.tahun = '{$tahun}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_tup AS t2 "
                        . "WHERE t2.id_trx_nomor_tup = t1.id_trx_nomor_tup )" ;
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
        }

        function get_daftar_spm($kode_unit_subunit,$tahun){
            
            $query = "SELECT *,t1.tgl_proses AS tgl_proses_status "
                    . "FROM trx_nomor_tup AS tt1 "
                    . "JOIN trx_tup AS t1 ON t1.id_trx_nomor_tup = tt1.id_trx_nomor_tup "
                    . "WHERE tt1.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND jenis = 'SPM' "
                    . "AND tt1.tahun = '{$tahun}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_tup AS t2 "
                        . "WHERE t2.id_trx_nomor_tup = t1.id_trx_nomor_tup )" ;
                        
//                        echo $query; die;

                $q = $this->db->query($query);

        $result = $q->result();
                
//                var_dump($result);die;

        return $result ;
        }
        
        function proses_data_spp($data){
            return $this->db->insert("trx_spp_tup_data",$data);
        }
        
        function get_data_spp($str_nomor_trx){
            $this->db->where('str_nomor_trx',$str_nomor_trx);
            $query = $this->db->get("trx_spp_tup_data");
    //	print_r($query);die;
//            if($query->num_rows()>0){
                    return $query->row();
//            }else{
//                    return array();
//            }
        }
        
        function proses_data_spm($data){
            return $this->db->insert("trx_spm_tup_data",$data);
        }
        
        function get_data_spm($str_nomor_trx){
            $this->db->where('str_nomor_trx',$str_nomor_trx);
            $query = $this->db->get("trx_spm_tup_data");
    //	print_r($query);die;
//            if($query->num_rows()>0){
                    return $query->row();
//            }else{
//                    return array();
//            } 
        }
        
        function insert_keluaran($data){
            return $this->db->insert_batch("trx_keluaran",$data);
        }
        
        
        function get_keluaran($nomor_trx){
            $this->db->where("str_nomor_trx_spp",$nomor_trx);
            $query = $this->db->get('trx_keluaran');
            return $query->result();
        }
        
        function proses_tup_spp_rka($data){

            $rel_kuitansi = json_decode($data['rel_kuitansi']);

            foreach($rel_kuitansi as $rel){
//                $this->db->where('id_kuitansi', $rel);
//                $this->db->update('rsa_kuitansi', array('str_nomor_trx'=>$data['str_nomor_trx']));
                    $query = "UPDATE rsa_detail_belanja_ "
                        . "JOIN rsa_kuitansi_detail ON rsa_kuitansi_detail.kode_usulan_belanja = rsa_detail_belanja_.kode_usulan_belanja "
                        . "AND rsa_kuitansi_detail.kode_akun_tambah = rsa_detail_belanja_.kode_akun_tambah "
                        . "JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi "
                        . "SET rsa_detail_belanja_.proses = '41' "
                        . "WHERE rsa_kuitansi.str_nomor_trx = '{$data['str_nomor_trx']}'" ; 
//                echo $query ; die;
                $this->db->query($query);
            }

        }
        
        function tolak_tup_spp_rka($data){

            $rel_kuitansi = json_decode($data['rel_kuitansi']);

            foreach($rel_kuitansi as $rel){
//                $this->db->where('id_kuitansi', $rel);
//                $this->db->update('rsa_kuitansi', array('str_nomor_trx'=>$data['str_nomor_trx']));
                    $query = "UPDATE rsa_detail_belanja_ "
                        . "JOIN rsa_kuitansi_detail ON rsa_kuitansi_detail.kode_usulan_belanja = rsa_detail_belanja_.kode_usulan_belanja "
                        . "AND rsa_kuitansi_detail.kode_akun_tambah = rsa_detail_belanja_.kode_akun_tambah "
                        . "JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi "
                        . "SET rsa_detail_belanja_.proses = '31' "
                        . "WHERE rsa_kuitansi.str_nomor_trx = '{$data['str_nomor_trx']}'" ; 
//                echo $query ; die;
                $this->db->query($query);
            }

        }
        
        function proses_tup_spm_rka($data){

            $rel_kuitansi = json_decode($data['rel_kuitansi']);

            foreach($rel_kuitansi as $rel){
//                $this->db->where('id_kuitansi', $rel);
//                $this->db->update('rsa_kuitansi', array('str_nomor_trx'=>$data['str_nomor_trx']));
                    $query = "UPDATE rsa_detail_belanja_ "
                        . "JOIN rsa_kuitansi_detail ON rsa_kuitansi_detail.kode_usulan_belanja = rsa_detail_belanja_.kode_usulan_belanja "
                        . "AND rsa_kuitansi_detail.kode_akun_tambah = rsa_detail_belanja_.kode_akun_tambah "
                        . "JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi "
                        . "SET rsa_detail_belanja_.proses = '51' "
                        . "WHERE rsa_kuitansi.str_nomor_trx_spm = '{$data['str_nomor_trx_spm']}'" ; 
//                echo $query ; die;
                $this->db->query($query);
            }

        }
        
        function proses_tup_cair_rka($data){

            $rel_kuitansi = json_decode($data['rel_kuitansi']);

            foreach($rel_kuitansi as $rel){
//                $this->db->where('id_kuitansi', $rel);
//                $this->db->update('rsa_kuitansi', array('str_nomor_trx'=>$data['str_nomor_trx']));
                $nw = date('Y-m-d H:i:s');
                    $query = "UPDATE rsa_detail_belanja_ "
                        . "JOIN rsa_kuitansi_detail ON rsa_kuitansi_detail.kode_usulan_belanja = rsa_detail_belanja_.kode_usulan_belanja "
                        . "AND rsa_kuitansi_detail.kode_akun_tambah = rsa_detail_belanja_.kode_akun_tambah "
                        . "JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi "
                        . "SET rsa_detail_belanja_.proses = '61', rsa_detail_belanja_.tanggal_transaksi = '{$nw}' "
                        . "WHERE rsa_kuitansi.str_nomor_trx_spm = '{$data['str_nomor_trx_spm']}'" ; 
//                echo $query ; die;
                $this->db->query($query);
            }

        }
        
        function tolak_tup_spm_rka($data){

            $rel_kuitansi = json_decode($data['rel_kuitansi']);

            foreach($rel_kuitansi as $rel){
//                $this->db->where('id_kuitansi', $rel);
//                $this->db->update('rsa_kuitansi', array('str_nomor_trx'=>$data['str_nomor_trx']));
                    $query = "UPDATE rsa_detail_belanja_ "
                        . "JOIN rsa_kuitansi_detail ON rsa_kuitansi_detail.kode_usulan_belanja = rsa_detail_belanja_.kode_usulan_belanja "
                        . "AND rsa_kuitansi_detail.kode_akun_tambah = rsa_detail_belanja_.kode_akun_tambah "
                        . "JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi "
                        . "SET rsa_detail_belanja_.proses = '31' "
                        . "WHERE rsa_kuitansi.str_nomor_trx_spm = '{$data['str_nomor_trx_spm']}'" ; 
//                echo $query ; die;
                $this->db->query($query);
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
        
        function get_nomer_spm_cair_lalu($kode_unit_subunit,$tahun){
            $str = "SELECT t1.str_nomor_trx_spm FROM trx_urut_spm_cair AS t1 "
                    . "WHERE t1.kode_unit_subunit = '{$kode_unit_subunit}' AND t1.jenis_trx = 'GUP' AND t1.tahun = '{$tahun}' "
                    . "AND tgl_proses = ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.kode_unit_subunit = '{$kode_unit_subunit}' AND t2.jenis_trx = 'GUP' AND t2.tahun = '{$tahun}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
//                    echo $str; die;
                    
            $q = $this->db->query($str);
//            var_dump($q->result());die;
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->str_nomor_trx_spm;
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
                           $query = "SELECT COUNT(posisi) AS jml FROM trx_tup WHERE posisi = 'SPP-DRAFT' AND kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1' " ; 

                        }else if($level == '2'){ // KPA
                            $query = "SELECT COUNT(posisi) AS jml FROM trx_tup WHERE posisi = 'SPM-DRAFT-PPK' AND kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1' " ; 

                        }else if($level == '3'){ // VERIFIKATOR

                            $unit = $this->get_unit_under_verifikator($id_user_verifikator);
                            $str_unit = '' ;
                            foreach($unit as $u){
                                $str_unit = $str_unit . "'". $u->kode_unit_subunit . "'," ; 
                            }

                            $str_unit = substr($str_unit, 0, -1);

                            // echo $str_unit ; die ;

                            $query = "SELECT COUNT(posisi) AS jml FROM trx_tup WHERE posisi = 'SPM-DRAFT-KPA' AND kode_unit_subunit IN ({$str_unit}) AND aktif = '1' " ; 

                           // echo $query ; die ;

                        }else if($level == '11'){ // KBUU
                            $query = "SELECT COUNT(posisi) AS jml FROM trx_tup WHERE posisi = 'SPM-FINAL-VERIFIKATOR' AND aktif = '1' GROUP BY  posisi " ;

                        }

                        // echo $query ; die ;

                    $q = $this->db->query($query);

                    if($q->num_rows() > 0){
                       return $q->row()->jml;
                    }else{
                        return '0';
                    }

        }

        function tup_to_nihil($data_tup_to_nihil){


                $this->db->where('tahun', $data_tup_to_nihil['tahun']);
                $this->db->where('status', '1');
                $this->db->where('kd_unit_subunit', $data_tup_to_nihil['kode_unit_subunit']);

                return $this->db->update("trx_tambah_tup_to_nihil",$data_tup_to_nihil);

            }




	
	
	
}
?>