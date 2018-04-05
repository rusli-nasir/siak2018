<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rsa_tambah_tup_model extends CI_Model {
/* -------------- Constructor ------------- */

	
        public function __construct()
        {
                
                parent::__construct();
				
        }
	
	function search_rsa_tup($kata_kunci=''){
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		if($kata_kunci!='')
		{
			$this->db->like('kd_transaksi', $kata_kunci);
			//$this->db->or_like('no_spm', $kata_kunci);
		}
		$this->db->order_by("no_tup", "asc"); 
		/* running query	*/
		$query		= $this->db->get('rsa_tup');
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	function add_rsa_tup($data){
		//print_r($data);die;
		return $this->db->insert("rsa_tup",$data);
		
	}
	function get_rsa_tup($where=""){
		if(!$where==""){
			$this->db->where('no_tup',$where);
		}
		$this->db->order_by("no_tup");
		$query = $this->db->get("rsa_tup");
	//	print_r($query);die;
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
        
        function check_dokumen_tambah_tup($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT posisi FROM trx_tambah_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->posisi ;
            }else{
                return '';
            }
        }
        
        function lihat_ket($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT ket FROM trx_tambah_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->ket ;
            }else{
                return '';
            }
        }

        function lihat_ket_by_str_trx($str_trx){
            // $q = $this->db->query("SELECT ket FROM trx_gup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1'  AND tahun = '{$tahun}' ");

            $query = "SELECT ket "
                    . "FROM trx_nomor_tambah_tup AS tt1 "
                    . "JOIN trx_tambah_tup AS t1 ON t1.id_trx_nomor_tambah_tup = tt1.id_trx_nomor_tambah_tup "
                    . "WHERE tt1.str_nomor_trx = '{$no_str_trx}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_tambah_tup AS t2 "
                        . "WHERE t2.id_trx_nomor_tambah_tup = t1.id_trx_nomor_tambah_tup )" ;

            $q = $this->db->query($query);

//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->ket ;
            }else{
                return '';
            }
        }
        
        function proses_nomor_spp_tambah_tup($kode_unit,$data){
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('jenis', 'SPP');
            $this->db->where('kode_unit_subunit', $kode_unit);
            $this->db->update('trx_nomor_tambah_tup', array('aktif'=>'0')); 
            
            return $this->db->insert('trx_nomor_tambah_tup',$data);
            
        }
        
        function proses_nomor_spm_tambah_tup($kode_unit,$data){
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('jenis', 'SPM');
            $this->db->where('kode_unit_subunit', $kode_unit);
            $this->db->update('trx_nomor_tambah_tup', array('aktif'=>'0')); 
            
            return $this->db->insert('trx_nomor_tambah_tup',$data);
            
        }
        
        function proses_trx_spp_spm($data){
            
            return $this->db->insert('trx_spp_spm',$data);
            
        }
        
        function proses_tambah_tup($kode_unit,$data){
            
            if(($data['posisi'] == 'SPP-DITOLAK')||($data['posisi'] == 'SPM-DITOLAK-KPA')||($data['posisi'] == 'SPM-DITOLAK-VERIFIKATOR')||($data['posisi'] == 'SPM-DITOLAK-KBUU')){
                    $this->db->where('tahun', $data['tahun']);
                    $this->db->where('aktif', '1');
                    $this->db->where('kode_unit_subunit', $kode_unit);
                    $this->db->update('trx_nomor_tambah_tup', array('aktif'=>'0'));    
            }
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('kode_unit_subunit', $kode_unit);
            $this->db->update('trx_tambah_tup', array('aktif'=>'0')); 
            
            return $this->db->insert('trx_tambah_tup',$data);
            
        }
        
        function final_tambah_tup($kode_unit,$data){
            
            
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '2');
            $this->db->where('kd_unit', $kode_unit);
            $this->db->update('kas_bendahara', array('aktif'=>'0'));
            
            return $this->db->insert('kas_bendahara',$data);
            
        }
        
        function get_tgl_spp($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT MAX(tgl_proses) AS tgl_proses FROM trx_nomor_tambah_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif='1' ");
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
        
        function get_nomor_spp($kode_unit_subunit,$tahun){
            
//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' " ; die;

//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' ";die;
            
            $q = $this->db->query("SELECT str_nomor_trx AS nt FROM trx_nomor_tambah_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' ");
            
            
            
            if($q->num_rows() > 0){
               return $q->row()->nt ;
            }else{
                return '' ;
            }
        }
        
        function get_nomor_spm($kode_unit_subunit,$tahun){
            
//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' " ; die;
            
            $q = $this->db->query("SELECT str_nomor_trx AS nt FROM trx_nomor_tambah_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' AND aktif = '1' ");
            
            
            if($q->num_rows() > 0){
               return $q->row()->nt ;
            }else{
                return '' ;
            }
        }
        
        function get_nomor_next_spp($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT IFNULL(MAX(nomor_trx),0) AS nt FROM trx_nomor_tambah_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' ");
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
            $q = $this->db->query("SELECT IFNULL(MAX(nomor_trx),0) AS nt FROM trx_nomor_tambah_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' ");
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
        
        function get_id_nomor_tambah_tup($jenis,$kode_unit_subunit,$tahun){
//            echo "SELECT id_trx_nomor_tup FROM trx_nomor_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}' AND aktif='1' "; die;
            $q = $this->db->query("SELECT id_trx_nomor_tambah_tup FROM trx_nomor_tambah_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}' AND aktif='1' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->id_trx_nomor_tambah_tup ;
            }else{
            
            }
        }
        
        function get_tgl_spm($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT tgl_proses AS tgl_proses FROM trx_nomor_tambah_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' AND aktif='1' ");
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
        
        function get_tgl_spm_kpa($kode_unit_subunit,$tahun,$nomor_trx_spm){
            
            $str = "SELECT trx_tambah_tup.tgl_proses FROM trx_nomor_tambah_tup "
                    . "JOIN trx_tambah_tup ON trx_nomor_tambah_tup.id_trx_nomor_tambah_tup = trx_tambah_tup.id_trx_nomor_tambah_tup "
                    . "WHERE trx_nomor_tambah_tup.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_tambah_tup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_tambah_tup.posisi = 'SPM-DRAFT-KPA' AND trx_nomor_tambah_tup.tahun = '{$tahun}' "
                    . "AND trx_nomor_tambah_tup.aktif = '1'";
                    
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
            
            $str = "SELECT trx_tambah_tup.tgl_proses FROM trx_nomor_tambah_tup "
                    . "JOIN trx_tambah_tup ON trx_nomor_tambah_tup.id_trx_nomor_tambah_tup = trx_tambah_tup.id_trx_nomor_tambah_tup "
                    . "WHERE trx_nomor_tambah_tup.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_tambah_tup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_tambah_tup.posisi = 'SPM-FINAL-VERIFIKATOR' AND trx_nomor_tambah_tup.tahun = '{$tahun}' "
                    . "AND trx_nomor_tambah_tup.aktif = '1'";
                    
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
            
            $str = "SELECT trx_tambah_tup.tgl_proses FROM trx_nomor_tambah_tup "
                    . "JOIN trx_tambah_tup ON trx_nomor_tambah_tup.id_trx_nomor_tambah_tup = trx_tambah_tup.id_trx_nomor_tambah_tup "
                    . "WHERE trx_nomor_tambah_tup.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_tambah_tup.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_tambah_tup.posisi = 'SPM-FINAL-KBUU' AND trx_nomor_tambah_tup.tahun = '{$tahun}' "
                    . "AND trx_nomor_tambah_tup.aktif = '1'";
                    
//            var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            

        }
        
        function get_tambah_tup_unit_usul($tahun){
            
            $query = "SELECT rba.unit.nama_unit,rba.unit.kode_unit,rsa.trx_tambah_tup.posisi,rsa.trx_tambah_tup.aktif,rsa.trx_tambah_tup.tgl_proses,rsa.trx_tambah_tup.tahun "
                    . "FROM rba.unit LEFT JOIN rsa.trx_tambah_tup ON rba.unit.kode_unit = rsa.trx_tambah_tup.kode_unit_subunit "
                    . "WHERE ( rsa.trx_tambah_tup.aktif = '1' OR rsa.trx_tambah_tup.aktif IS NULL ) "
                    . "AND ( rsa.trx_tambah_tup.tahun = '{$tahun}' OR rsa.trx_tambah_tup.tahun IS NULL ) "
                    . "GROUP BY rba.unit.kode_unit "
                    . "ORDER BY rba.unit.kode_unit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
        
        function get_tambah_tup_subunit_usul($tahun){
            
            $query = "SELECT rba.subunit.nama_subunit,rba.subunit.kode_subunit,rsa.trx_tambah_tup.posisi,rsa.trx_tambah_tup.aktif,rsa.trx_tambah_tup.tgl_proses,rsa.trx_tambah_tup.tahun "
                    . "FROM rba.subunit LEFT JOIN rsa.trx_tambah_tup ON rba.subunit.kode_subunit = rsa.trx_tambah_tup.kode_unit_subunit "
                    . "WHERE ( rsa.trx_tambah_tup.aktif = '1' OR rsa.trx_tambah_tup.aktif IS NULL ) "
                    . "AND ( rsa.trx_tambah_tup.tahun = '{$tahun}' OR rsa.trx_tambah_tup.tahun IS NULL ) "
                    . "GROUP BY rba.subunit.kode_subunit "
                    . "ORDER BY rba.subunit.kode_subunit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
        
        function get_tambah_tup_unit_usul_verifikator($id_user_verifikator,$tahun){
            
            $query = "SELECT rba.unit.nama_unit,rba.unit.kode_unit,rsa.trx_tambah_tup.posisi,rsa.trx_tambah_tup.aktif,rsa.trx_tambah_tup.tgl_proses,rsa.trx_tambah_tup.tahun "
                    . "FROM rba.unit "
                    . "JOIN rsa_verifikator_unit ON rba.unit.kode_unit = rsa_verifikator_unit.kode_unit_subunit "
                    . "LEFT JOIN rsa.trx_tambah_tup ON rba.unit.kode_unit = rsa.trx_tambah_tup.kode_unit_subunit "
                    . "WHERE rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
                    . "AND ( rsa.trx_tambah_tup.aktif = '1' OR rsa.trx_tambah_tup.aktif IS NULL ) "
                    . "AND ( rsa.trx_tambah_tup.tahun = '{$tahun}' OR rsa.trx_tambah_tup.tahun IS NULL ) "
                    . "GROUP BY rba.unit.kode_unit "
                    . "ORDER BY rba.unit.kode_unit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
        
        function get_tambah_tup_subunit_usul_verifikator($id_user_verifikator,$tahun){
            
            $query = "SELECT rba.subunit.nama_subunit,rba.subunit.kode_subunit,rsa.trx_tambah_tup.posisi,rsa.trx_tambah_tup.aktif,rsa.trx_tambah_tup.tgl_proses,rsa.trx_tambah_tup.tahun "
                    . "FROM rba.subunit "
                    . "JOIN rsa_verifikator_unit ON SUBSTR(rba.subunit.kode_subunit,1,2) = rsa_verifikator_unit.kode_unit_subunit "
                    . "LEFT JOIN rsa.trx_tambah_tup ON rba.subunit.kode_subunit = rsa.trx_tambah_tup.kode_unit_subunit "
                    . "WHERE rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
                    . "AND ( rsa.trx_tambah_tup.aktif = '1' OR rsa.trx_tambah_tup.aktif IS NULL ) "
                    . "AND ( rsa.trx_tambah_tup.tahun = '{$tahun}' OR rsa.trx_tambah_tup.tahun IS NULL ) "
                    . "GROUP BY rba.subunit.kode_subunit "
                    . "ORDER BY rba.subunit.kode_subunit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
        
        function get_tup_unit($tahun){
            
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
        function get_verifikator($kode_unit_subunit){
//            $str = "SELECT rsa_user.nm_lengkap,rsa_user.nip FROM trx_spm_verifikator "
//                    . "JOIN rsa_user ON rsa_user.id = trx_spm_verifikator.id_rsa_user_verifikator "
//                    . "JOIN trx_nomor_tup ON trx_nomor_tup.nomor_trx = trx_spm_verifikator.nomor_trx_spm "
//                    . "WHERE trx_nomor_tup.kode_unit_subunit = '{$kode_unit_subunit}' "
//                    . "AND trx_nomor_tup.nomor_trx = '{$nomor_trx_spm}' "
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
        
        function proses_verifikator_tambah_tup($data){
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
                    . "FROM trx_nomor_tambah_tup AS tt1 "
                    . "JOIN trx_tambah_tup AS t1 ON t1.id_trx_nomor_tambah_tup = tt1.id_trx_nomor_tambah_tup "
                    . "WHERE tt1.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND jenis = 'SPP' "
                    . "AND tt1.tahun = '{$tahun}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_tambah_tup AS t2 "
                        . "WHERE t2.id_trx_nomor_tambah_tup = t1.id_trx_nomor_tambah_tup )" ;
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
        }

        function get_daftar_spm($kode_unit_subunit,$tahun){
            
            $query = "SELECT *,t1.tgl_proses AS tgl_proses_status "
                    . "FROM trx_nomor_tambah_tup AS tt1 "
                    . "JOIN trx_tambah_tup AS t1 ON t1.id_trx_nomor_tambah_tup = tt1.id_trx_nomor_tambah_tup "
                    . "WHERE tt1.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND jenis = 'SPM' "
                    . "AND tt1.tahun = '{$tahun}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_tambah_tup AS t2 "
                        . "WHERE t2.id_trx_nomor_tambah_tup = t1.id_trx_nomor_tambah_tup )" ;
                        
//                        echo $query; die;

                $q = $this->db->query($query);

        $result = $q->result();
                
//                var_dump($result);die;

        return $result ;
        }
        
        function proses_data_spp($data){
            return $this->db->insert("trx_spp_tambah_tup_data",$data);
        }
        
        function get_data_spp($str_nomor_trx){
            $this->db->where('str_nomor_trx',$str_nomor_trx);
            $query = $this->db->get("trx_spp_tambah_tup_data");
    //	print_r($query);die;
//            if($query->num_rows()>0){
                    return $query->row();
//            }else{
//                    return array();
//            }
        }
        
        function proses_data_spm($data){
            return $this->db->insert("trx_spm_tambah_tup_data",$data);
        }
        
        function get_data_spm($str_nomor_trx){
            $this->db->where('str_nomor_trx',$str_nomor_trx);
            $query = $this->db->get("trx_spm_tambah_tup_data");
    //	print_r($query);die;
//            if($query->num_rows()>0){
                    return $query->row();
//            }else{
//                    return array();
//            }
        }
        
//        function get_urut($kode_unit_subunit,$jenis,$tahun){
//            $q = $this->db->query("SELECT IFNULL(MAX(urut),0) AS nt FROM trx_nomor_tambah_tup WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}'  AND tahun = '{$tahun}' ");
//            var_dump($q->num_rows());die;
//            if($q->num_rows() > 0){
//               return $q->row()->tgl_proses ;
//            }else{
//                $x = intval($q->row()->nt) + 1;
//		if(strlen($x)==1){
//				$x = '0000'.$x;
//		}
//		elseif(strlen($x)==2){
//				$x = '000'.$x;
//		}
//		elseif(strlen($x)==3){
//				$x = '00'.$x;
//		}
//                elseif(strlen($x)==4){
//				$x = '0'.$x;
//		}
//                elseif(strlen($x)==5){
//				$x = $x;
//		}

//		return $x;
//        }


            function tup_to_nihil($data_tup_to_nihil){

                $this->db->where('tahun', $data_tup_to_nihil['tahun']);
                $this->db->where('status', '1');
                $this->db->where('kd_unit_subunit', $data_tup_to_nihil['kode_unit_subunit']);
                $this->db->update('trx_tambah_tup_to_nihil', array('status'=>'0'));


                return $this->db->insert("trx_tambah_tup_to_nihil",$data_tup_to_nihil);

            }


            function get_status_nihil($unit,$tahun){

                $query = "SELECT str_nomor_trx_spm_tup FROM trx_tambah_tup_to_nihil WHERE kode_unit_subunit = '{$unit}' AND status = '1'" ;

                // echo $query ; die;

                $q = $this->db->query($query);

                if($q->num_rows() > 0){
                   return $q->row()->str_nomor_trx_spm_tup ;
                }else{
                    return '';
                } 

            }

            function get_spm_tup_nihil_by_spm_tambah_tup($str_nomor_trx_spm_tambah_tup){

                $query = "SELECT str_nomor_trx_spm_tup FROM trx_tambah_tup_to_nihil WHERE str_nomor_trx_spm_tambah_tup = '{$str_nomor_trx_spm_tambah_tup}' " ;

                // echo $query ; die;

                $q = $this->db->query($query);

                if($q->num_rows() > 0){
                   return $q->row()->str_nomor_trx_spm_tup ;
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
                           $query = "SELECT COUNT(posisi) AS jml FROM trx_tambah_tup WHERE posisi = 'SPP-DRAFT' AND kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1' " ; 

                        }else if($level == '2'){ // KPA
                            $query = "SELECT COUNT(posisi) AS jml FROM trx_tambah_tup WHERE posisi = 'SPM-DRAFT-PPK' AND kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1' " ; 

                        }else if($level == '3'){ // VERIFIKATOR

                            $unit = $this->get_unit_under_verifikator($id_user_verifikator);
                            $str_unit = '' ;
                            foreach($unit as $u){
                                $str_unit = $str_unit . "'". $u->kode_unit_subunit . "'," ; 
                            }

                            $str_unit = substr($str_unit, 0, -1);

                            // echo $str_unit ; die ;

                            $query = "SELECT COUNT(posisi) AS jml FROM trx_tambah_tup WHERE posisi = 'SPM-DRAFT-KPA' AND SUBSTR(kode_unit_subunit,1,2) IN ({$str_unit}) AND aktif = '1' " ; 

                           // echo $query ; die ;

                        }else if($level == '11'){ // KBUU
                            $query = "SELECT COUNT(posisi) AS jml FROM trx_tambah_tup WHERE posisi = 'SPM-FINAL-VERIFIKATOR' AND aktif = '1' GROUP BY  posisi " ;

                        }

                        // echo $query ; die ;

                    $q = $this->db->query($query);

                    if($q->num_rows() > 0){
                       return $q->row()->jml;
                    }else{
                        return '0';
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

        function get_aktif_spp($kode_unit_subunit,$tahun){
            $this->db->where('kode_unit_subunit',$kode_unit_subunit);
            $this->db->where('tahun',$tahun);
            $this->db->where('aktif','1');
            $this->db->where('jenis','SPP');
            $q = $this->db->get('trx_nomor_tambah_tup');
            
            if($q->num_rows() > 0){
                return $q->row()->str_nomor_trx; 
            }else{
                return ''; 
            }
        }

        function get_aktif_spm($kode_unit_subunit,$tahun){
            $this->db->where('kode_unit_subunit',$kode_unit_subunit);
            $this->db->where('tahun',$tahun);
            $this->db->where('aktif','1');
            $this->db->where('jenis','SPM');
            $q = $this->db->get('trx_nomor_tambah_tup');
            
            if($q->num_rows() > 0){
                return $q->row()->str_nomor_trx; 
            }else{
                return ''; 
            }
        }


        function check_dokumen_tambah_tup_by_str_trx($no_str_trx){

            $query = "SELECT posisi "
                    . "FROM trx_nomor_tambah_tup AS tt1 "
                    . "JOIN trx_tambah_tup AS t1 ON t1.id_trx_nomor_tambah_tup = tt1.id_trx_nomor_tambah_tup "
                    . "WHERE tt1.str_nomor_trx = '{$no_str_trx}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_tambah_tup AS t2 "
                        . "WHERE t2.id_trx_nomor_tambah_tup = t1.id_trx_nomor_tambah_tup )" ;

            $q = $this->db->query($query);
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->posisi ;
            }else{
                return '';
            }
        }
        
	
	
	
}
?>