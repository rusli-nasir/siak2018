<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class rsa_lsphk3_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
function search_rsa_lsphk3($kata_kunci=''){
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
    
         function check_dokumen_lsphk3($kode_unit_subunit,$tahun,$id){
            $q = $this->db->query("SELECT posisi FROM trx_lsphk3 WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND aktif = '1'  AND tahun = '{$tahun}'AND id_kuitansi='{$id}'");
			//var_dump($kode_unit_subunit);die;
            if($q->num_rows() > 0){
               return $q->row()->posisi ;
            }else{
                return '';
            }
        }
		
        
      function get_tgl_spp($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT MAX(tgl_proses) AS tgl_proses FROM trx_nomor_lsphk3 WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}'");
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
		 function get_nomor_next_spp($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT IFNULL(MAX(nomor_trx),0) AS nt FROM trx_nomor_lsphk3 WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' ");
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
        
        function get_daftar_spp($kode_unit_subunit,$tahun){
            
            $query = "SELECT *,t1.tgl_proses AS tgl_proses_status "
                    . "FROM trx_nomor_lsphk3 AS tt1 "
                    . "JOIN trx_lsphk3 AS t1 ON t1.id_trx_nomor_lsphk3 = tt1.id_trx_nomor_lsphk3 "
                    . "WHERE tt1.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND jenis = 'SPP' "
                    . "AND tt1.tahun = '{$tahun}' "
                    . "AND t1.tgl_proses IN ( "
                        . "SELECT MAX(t2.tgl_proses) FROM trx_lsphk3 AS t2 "
                        . "WHERE t2.id_trx_nomor_lsphk3 = t1.id_trx_nomor_lsphk3 )" ;
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
        }
		 function get_nomor_spp($kode_unit_subunit,$tahun,$id){
              $q = $this->db->query("SELECT str_nomor_trx AS nt FROM trx_nomor_lsphk3 WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}'  AND id_kuitansi='{$id}' ");
			  //var_dump($q);die;
            if($q->num_rows() > 0){
               return $q->row()->nt ;
            }else{
                return '' ;
            }
        }
		 function get_data_spp($str_nomor_trx,$id){
          //  $this->db->where('str_nomor_trx',$str_nomor_trx,'id_kuitansi',$id);
            //$query = $this->db->get("trx_spp_lsphk3_data");
			//echo "SELECT * FROM trx_spp_lsphk3_data WHERE str_nomor_trx = '{$str_nomor_trx}' AND id_kuitansi='{$id}' "; exit;
			$query = $this->db->query("SELECT * FROM trx_spp_lsphk3_data WHERE str_nomor_trx = '{$str_nomor_trx}' AND id_kuitansi='{$id}' ");
    	//print_r($query);die;
//            if($query->num_rows()>0){
                    return $query->row();
//            }else{
//                    return array();
//            }
        }
		 function lihat_ket($kode_unit_subunit,$tahun,$id){
            $q = $this->db->query("SELECT ket FROM trx_lsphk3 WHERE kode_unit_subunit = '{$kode_unit_subunit}'  AND tahun = '{$tahun}' AND id_kuitansi='{$id}'");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->ket ;
            }else{
                return '';
            }
        }
		 function proses_nomor_spp_lsphk3($kode_unit,$data){
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('jenis', 'SPP');
            $this->db->where('kode_unit_subunit', $kode_unit);
            $this->db->update('trx_nomor_lsphk3', array('aktif'=>'0')); 
            
            return $this->db->insert('trx_nomor_lsphk3',$data);
            
        }
		function get_id_nomor_lsphk3($jenis,$kode_unit_subunit,$tahun,$id){
//            echo "SELECT id_trx_nomor_lsphk3 FROM trx_nomor_up WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}' AND aktif='1' "; die;
            $q = $this->db->query("SELECT id_trx_nomor_lsphk3 FROM trx_nomor_lsphk3 WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}'  AND id_kuitansi='{$id}' ");
//            var_dump($q->num_rows());die;
            if($q->num_rows() > 0){
               return $q->row()->id_trx_nomor_lsphk3 ;
            }else{
            
            }
        }
		function proses_lsphk3($kode_unit,$data,$id){
           if(($data['posisi'] == 'SPP-DITOLAK')||($data['posisi'] == 'SPM-DITOLAK-KPA')||($data['posisi'] == 'SPM-DITOLAK-VERIFIKATOR')||($data['posisi'] == 'SPM-DITOLAK-KBUU')){
                    $this->db->where('tahun', $data['tahun']);
                    $this->db->where('aktif', '1');
                    $this->db->where('kode_unit_subunit', $kode_unit);
					$this->db->where('id_kuitansi', $id);
                    $this->db->update('trx_nomor_lsphk3', array('aktif'=>'0'));    
            }
			//var_dump($data);die;
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('kode_unit_subunit', $kode_unit);
			$this->db->where('id_kuitansi', $id);
            $this->db->update('trx_lsphk3', array('aktif'=>'0')); 
            return $this->db->insert('trx_lsphk3',$data);
            
        }
		function proses_data_spp($data){
			//var_dump($data);die;
            return $this->db->insert("trx_spp_lsphk3_data",$data);
        }
	function get_nomor_next_spm($kode_unit_subunit,$tahun){
            $q = $this->db->query("SELECT IFNULL(MAX(nomor_trx),0) AS nt FROM trx_nomor_lsphk3 WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' ");
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
		 function get_verifikator($kode_unit_subunit){
            $str2 = "SELECT rsa_user.nm_lengkap,rsa_user.nomor_induk FROM rsa_verifikator_unit "
                    . "JOIN rsa_user ON rsa_user.id = rsa_verifikator_unit.id_user_verifikator "
                    . "WHERE rsa_verifikator_unit.kode_unit_subunit = '{$kode_unit_subunit}' " ;
			
            $q = $this->db->query($str2);
                   return $q->row();
              
        }
		function get_tgl_spm_kpa($kode_unit_subunit,$tahun,$nomor_trx_spm){
            
            $str = "SELECT trx_lsphk3.tgl_proses FROM trx_nomor_lsphk3 "
                    . "JOIN trx_lsphk3 ON trx_nomor_lsphk3.id_trx_nomor_lsphk3 = trx_lsphk3.id_trx_nomor_lsphk3 "
                    . "WHERE trx_nomor_lsphk3.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_lsphk3.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_lsphk3.posisi = 'SPM-DRAFT-KPA' AND trx_nomor_lsphk3.tahun = '{$tahun}' "
                    . "AND trx_nomor_lsphk3.aktif = '1'";
                    
//            var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
		function get_tgl_spm($kode_unit_subunit,$tahun,$id){
            $q = $this->db->query("SELECT tgl_proses AS tgl_proses FROM trx_nomor_lsphk3 WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}' AND id_kuitansi='{$id}'");
             //  var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            
            
        }
	function get_tgl_spm_verifikator($kode_unit_subunit,$tahun,$nomor_trx_spm){
            
            $str = "SELECT trx_lsphk3.tgl_proses FROM trx_nomor_lsphk3 "
                    . "JOIN trx_lsphk3 ON trx_nomor_lsphk3.id_trx_nomor_lsphk3 = trx_lsphk3.id_trx_nomor_lsphk3 "
                    . "WHERE trx_nomor_lsphk3.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_lsphk3.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_lsphk3.posisi = 'SPM-FINAL-VERIFIKATOR' AND trx_nomor_lsphk3.tahun = '{$tahun}' "
                    . "AND trx_nomor_lsphk3.aktif = '1'";
                    
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
            
            $str = "SELECT trx_lsphk3.tgl_proses FROM trx_nomor_lsphk3 "
                    . "JOIN trx_lsphk3 ON trx_nomor_lsphk3.id_trx_nomor_lsphk3 = trx_lsphk3.id_trx_nomor_lsphk3 "
                    . "WHERE trx_nomor_lsphk3.kode_unit_subunit = '{$kode_unit_subunit}' "
                    . "AND trx_nomor_lsphk3.str_nomor_trx = '{$nomor_trx_spm}' "
                    . "AND trx_lsphk3.posisi = 'SPM-FINAL-KBUU' AND trx_nomor_lsphk3.tahun = '{$tahun}' "
                    . "AND trx_nomor_lsphk3.aktif = '1'";
                    
//            var_dump($str);die;
                    
            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->tgl_proses ;
                }else{
                    return '';
                } 
            

        }
	function get_nomor_spm($kode_unit_subunit,$tahun,$id){
            
//            echo "SELECT str_nomor_trx AS nt FROM trx_nomor_up WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPP'  AND tahun = '{$tahun}' AND aktif = '1' " ; die;
            
            $q = $this->db->query("SELECT str_nomor_trx AS nt FROM trx_nomor_lsphk3 WHERE kode_unit_subunit = '{$kode_unit_subunit}' AND jenis = 'SPM'  AND tahun = '{$tahun}'AND id_kuitansi = '{$id}' ");
            
            
            if($q->num_rows() > 0){
               return $q->row()->nt ;
            }else{
                return '' ;
            }
        }
	function get_data_spm($str_nomor_trx){
		//var_dump($str_nomor_trx);die;
            $this->db->where('str_nomor_trx',$str_nomor_trx);
            $query = $this->db->get("trx_spm_lsphk3_data");
   //print_r($str_nomor_trx);die;
//            if($query->num_rows()>0){
                    return $query->row();
//            }else{
//                    return array();
//            }
        }
		 function proses_nomor_spm_lsphk3($kode_unit,$data,$id){
            
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('jenis', 'SPM');
			$this->db->where('kode_unit_subunit', $kode_unit);
            $this->db->where('id_kuitansi', $id);
            $this->db->update('trx_nomor_lsphk3', array('aktif'=>'0')); 
            return $this->db->insert('trx_nomor_lsphk3',$data);
            
        }
		 function proses_trx_spp_spm($data){
            
            return $this->db->insert('trx_spp_spm',$data);
            
        }
		 function proses_data_spm($data){
			//var_dump($data);die;
            return $this->db->insert("trx_spm_lsphk3_data",$data);
        }
		
        
        function proses_verifikator_lsphk3($data){
		//print_r($data);die;
		return $this->db->insert("trx_spm_verifikator",$data);
		
	}
	function get_kontrakid_by_array_id($data){
        $pekerjaan = 0 ;
		// $id=$data['array_id'];
      foreach($data['array_id'] as $id){
            $str = "SELECT * FROM rsa_spm_prosespihak3 LEFT JOIN rsa_kuitansi_pihak3 ON rsa_spm_prosespihak3.id_rup=rsa_kuitansi_pihak3.kontrak_id LEFT JOIN rsa_spm_rekananpihak3 ON rsa_spm_prosespihak3.id_rekanan=rsa_spm_rekananpihak3.id_rekanan WHERE kuitansi_id = '{$id}' ";
               // . "AND rsa.rsa_kuitansi.id_kuitansi = '{$id}' "
                //. "AND rsa.rsa_kuitansi.tahun = '{$data['tahun']}' ";

         //   var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }
        }

        return $pekerjaan;
    }
	function get_kontrak_by_id($data){
        //$pekerjaan = 0 ;
		 $id=$data['array_id'];
      foreach($data['array_id'] as $id){
            $str = "SELECT * FROM rsa_spm_rinciankontrak LEFT JOIN rsa_kuitansi_pihak3 ON rsa_spm_rinciankontrak.id_pembayaran=rsa_kuitansi_pihak3.kontrak_id LEFT JOIN rsa_spm_kontrakpihak3 ON rsa_spm_rinciankontrak. 	id_pembayaran=rsa_spm_kontrakpihak3.id WHERE kuitansi_id = '{$id}' ";
               // . "AND rsa.rsa_kuitansi.id_kuitansi = '{$id}' "
                //. "AND rsa.rsa_kuitansi.tahun = '{$data['tahun']}' ";

         //   var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }
      }

        //return $pekerjaan;
    }
	function get_pekerjaan_by_array_id($data){
        $pekerjaan = 0 ;
		 $id=$data['array_id'];
      foreach($data['array_id'] as $id){
            $str = "SELECT * "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$data['kode_unit_subunit']}' "
                . "AND rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id}' "
                . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$data['tahun']}' ";

         //   var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                    return $q->result();
                }
    }

        //return $pekerjaan;
    }
	function get_pengeluaran_by_array_id($data){
        $pengeluaran = 0 ;
       foreach($data['array_id'] as $id){
            $str = "SELECT SUM(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS pengeluaran "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail "
                . "ON rsa.rsa_kuitansi_detail.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "JOIN rsa.rsa_detail_belanja_ "
                . "ON rsa.rsa_detail_belanja_.kode_usulan_belanja = rsa.rsa_kuitansi_detail.kode_usulan_belanja "
                . "AND rsa.rsa_detail_belanja_.kode_akun_tambah = rsa.rsa_kuitansi_detail.kode_akun_tambah "
                . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$data['kode_unit_subunit']}' "
                . "AND rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id}' "
                . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$data['tahun']}' "
                . "GROUP BY rsa.rsa_kuitansi_lsphk3.kode_unit";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   $pengeluaran = $pengeluaran + $q->row()->pengeluaran;
                }
        
	   }
        return $pengeluaran;
    }
	function get_pengeluaran_by_akun5digitl3($data){
//        var_dump($data);die;
                $str_ = '';
				 $id=$data['array_id'];
                if(count($data['array_id']) > 1){
                   foreach($data['array_id'] as $id){
                        $str_ .= "rsa.rsa_kuitansi.id_kuitansi = '{$id}' OR " ;
                  }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
               }else{
                    $str_ = "rsa.rsa_kuitansi.id_kuitansi = '{$data['array_id'][0]}'" ;
                }
   //     echo $str_ ; die;
                $str = "SELECT SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,7,10) AS rka,rsa.rsa_kuitansi.id_kuitansi,SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,7,10) AS kode_usulan_rkat,rba.komponen_input.nama_komponen,rba.subkomponen_input.nama_subkomponen,rba.akun_belanja.nama_akun5digit,"
                        . "rsa.rsa_kuitansi.kode_akun5digit,SUM(rsa.rsa_kuitansi_detail.volume*rsa.rsa_kuitansi_detail.harga_satuan) AS pengeluaran "
                        . "FROM rsa.rsa_kuitansi "
                        . "JOIN rsa.rsa_kuitansi_detail "
                        . "ON rsa.rsa_kuitansi_detail.id_kuitansi = rsa.rsa_kuitansi.id_kuitansi "
                        . "JOIN rba.komponen_input ON rba.komponen_input.kode_kegiatan = SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,7,2) "
                        . "AND rba.komponen_input.kode_output = SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,9,2) "
                        . "AND rba.komponen_input.kode_program = SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,11,2) "
                        . "AND rba.komponen_input.kode_komponen = SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,13,2) "
                        . "JOIN rba.subkomponen_input ON rba.subkomponen_input.kode_kegiatan = SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,7,2) "
                        . "AND rba.subkomponen_input.kode_output = SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,9,2) "
                        . "AND rba.subkomponen_input.kode_program = SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,11,2) "
                        . "AND rba.subkomponen_input.kode_komponen = SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,13,2) "
                        . "AND rba.subkomponen_input.kode_subkomponen = SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,15,2) "
                        . "JOIN rba.akun_belanja ON rba.akun_belanja.kode_akun5digit = rsa.rsa_kuitansi.kode_akun5digit "
                        . "AND rba.akun_belanja.kode_akun = rsa.rsa_kuitansi.kode_akun "
                        . "AND rba.akun_belanja.sumber_dana = rsa.rsa_kuitansi.sumber_dana "
                        . "WHERE rsa.rsa_kuitansi.kode_unit = '{$data['kode_unit_subunit']}' "
                        . "AND rsa.rsa_kuitansi.jenis = 'LS3' "
                        . "AND ( " . $str_ . " ) "
                        . "AND rsa.rsa_kuitansi.tahun = '{$data['tahun']}' "
                        . "GROUP BY SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,7,10),SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,19,5) "
                        . "ORDER BY SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,7,10) ASC,SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,19,5) ASC";

                //        echo $str;die;
//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }
	function get_rekap_detail_kuitansi($data){
		 $id=$data['array_id'];
        $str_ = '';
               if(count($data['array_id']) > 1){
                   foreach($data['array_id'] as $id){
                        $str_ .= "rsa.rsa_kuitansi.id_kuitansi = '{$id}' OR " ;
                 }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
               }else{
                    $str_ = "rsa.rsa_kuitansi.id_kuitansi = '{$data['array_id'][0]}'" ;
                }

        $str = "SELECT SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,7,10) AS rka,rsa.rsa_kuitansi.no_bukti,rsa.rsa_kuitansi.tgl_kuitansi,rsa.rsa_kuitansi.uraian,rba.akun_belanja.nama_akun,rsa.rsa_kuitansi.kode_akun5digit,rsa.rsa_kuitansi.kode_akun,rsa.rsa_kuitansi_detail.id_kuitansi_detail,rsa.rsa_kuitansi_detail.kode_akun_tambah,rsa.rsa_kuitansi_detail.deskripsi,rsa.rsa_kuitansi_detail.volume,"
                . "rsa.rsa_kuitansi_detail.satuan,rsa.rsa_kuitansi_detail.harga_satuan,(rsa.rsa_kuitansi_detail.volume * rsa.rsa_kuitansi_detail.harga_satuan) AS bruto,"
                . "GROUP_CONCAT(rsa_kuitansi_detail_pajak.jenis_pajak SEPARATOR ',<br>') AS pajak_nom,"
                . "SUM(rsa_kuitansi_detail_pajak.rupiah_pajak) AS total_pajak "
                . "FROM rsa.rsa_kuitansi "
                . "JOIN rsa.rsa_kuitansi_detail "
                . "ON rsa.rsa_kuitansi_detail.id_kuitansi = rsa.rsa_kuitansi.id_kuitansi "
                . "LEFT JOIN rsa.rsa_kuitansi_detail_pajak "
                . "ON rsa.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa.rsa_kuitansi_detail.id_kuitansi_detail "
                . "JOIN rba.akun_belanja ON rba.akun_belanja.kode_akun = rsa.rsa_kuitansi.kode_akun "
                . "AND rba.akun_belanja.sumber_dana = rsa.rsa_kuitansi.sumber_dana "
                . "WHERE rsa.rsa_kuitansi.tahun = '{$data['tahun']}' "
                . "AND ( " . $str_ . " ) "
                . "GROUP BY rsa.rsa_kuitansi_detail.id_kuitansi_detail "
                . "ORDER BY SUBSTR(rsa.rsa_kuitansi.kode_usulan_belanja,7,10) ASC,"
                . "rsa.rsa_kuitansi.kode_akun ASC,"
                . "rsa.rsa_kuitansi_detail.kode_akun_tambah ASC,"
                . "rsa.rsa_kuitansi.tgl_kuitansi,"
                . "rsa.rsa_kuitansi_detail_pajak.jenis_pajak ASC";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){

                   return $q->result();
                }else{
                    return '';
                }
    }
	function get_spp_pajak($data){
				 $id=$data['array_id'];
                $str_ = '';
               if(count($data['array_id']) > 1){
                  foreach($data['array_id'] as $id){
                        $str_ .= "rsa.rsa_kuitansi.id_kuitansi = '{$id}' OR " ;
                  }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
              }else{
                    $str_ = "rsa.rsa_kuitansi.id_kuitansi = '{$data['array_id'][0]}'" ;
                }

                $str = "SELECT rsa.rsa_kuitansi.id_kuitansi,"
                        . "SUBSTR(rsa.rsa_kuitansi_detail_pajak.jenis_pajak,1,3) AS jenis,"
                        . "SUM(rsa.rsa_kuitansi_detail_pajak.rupiah_pajak) AS rupiah "
                        . "FROM rsa.rsa_kuitansi "
                        . "JOIN rsa.rsa_kuitansi_detail "
                        . "ON rsa.rsa_kuitansi_detail.id_kuitansi = rsa.rsa_kuitansi.id_kuitansi "
                        . "JOIN rsa.rsa_kuitansi_detail_pajak "
                        . "ON rsa.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa.rsa_kuitansi_detail.id_kuitansi_detail "
                        . "WHERE rsa.rsa_kuitansi.kode_unit = '{$data['kode_unit_subunit']}' "
                        . "AND rsa.rsa_kuitansi.jenis = 'LS3' "
                        . "AND ( " . $str_ . " ) "
                        . "AND rsa.rsa_kuitansi.tahun = '{$data['tahun']}' "
                        . "GROUP BY SUBSTR(rsa.rsa_kuitansi_detail_pajak.jenis_pajak,1,3) "
                        . "ORDER BY SUBSTR(rsa.rsa_kuitansi_detail_pajak.jenis_pajak,1,3) DESC";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }
	function get_lsphk3_unit_usul_verifikator($id_user_verifikator,$tahun){
            //var_dump($id_user_verifikator);die;
            $query = "SELECT rba.unit.nama_unit,rba.unit.kode_unit,COUNT(rsa.trx_lsphk3.posisi)AS jumlah,rsa.trx_lsphk3.posisi, rsa.trx_lsphk3.tahun "
                    . "FROM rba.unit"
                    . " JOIN rsa_verifikator_unit ON rba.unit.kode_unit = rsa_verifikator_unit.kode_unit_subunit "
                    . "LEFT JOIN rsa.trx_lsphk3 ON rba.unit.kode_unit = rsa.trx_lsphk3.kode_unit_subunit "
                    . "WHERE rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
                    . "AND ( rsa.trx_lsphk3.aktif = '1' OR rsa.trx_lsphk3.aktif IS NULL ) "
                    . "AND ( rsa.trx_lsphk3.tahun = '{$tahun}' OR rsa.trx_lsphk3.tahun IS NULL ) "
                    . "GROUP BY rba.unit.kode_unit "
                    . "ORDER BY rba.unit.kode_unit ASC";
                        
                     // echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
	
	 function get_lsphk3_subunit_usul_verifikator($id_user_verifikator,$tahun){
            
            $query = "SELECT rba.subunit.nama_subunit,rba.subunit.kode_subunit,COUNT(rsa.trx_lsphk3.posisi)as jumlah,rsa.trx_lsphk3.posisi,rsa.trx_lsphk3.tahun "
                    . "FROM rba.subunit "
                    . "JOIN rsa_verifikator_unit ON SUBSTR(rba.subunit.kode_subunit,1,2) = rsa_verifikator_unit.kode_unit_subunit "
                    . "LEFT JOIN rsa.trx_lsphk3 ON rba.subunit.kode_subunit = rsa.trx_lsphk3.kode_unit_subunit "
                    . "WHERE rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
                    . "AND ( rsa.trx_lsphk3.aktif = '1' OR rsa.trx_lsphk3.aktif IS NULL ) "
                    . "AND ( rsa.trx_lsphk3.tahun = '{$tahun}' OR rsa.trx_lsphk3.tahun IS NULL ) "
                    . "GROUP BY rba.subunit.kode_subunit "
                    . "ORDER BY rba.subunit.kode_subunit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
		
		function get_spm_verifikator($kode_unit,$id_user_verifikator,$tahun){
            //var_dump($id_user_verifikator);die;
            $query = "SELECT rba.unit.nama_unit,rba.unit.kode_unit,rsa.trx_lsphk3.posisi,rsa.trx_lsphk3.posisi, rsa.trx_lsphk3.tahun,rsa.trx_nomor_lsphk3.str_nomor_trx,rsa.trx_lsphk3.id_kuitansi "
                    . "FROM rba.unit"
                    . " JOIN rsa_verifikator_unit ON rba.unit.kode_unit = rsa_verifikator_unit.kode_unit_subunit "
                    . "LEFT JOIN rsa.trx_lsphk3 ON rba.unit.kode_unit = rsa.trx_lsphk3.kode_unit_subunit "
					. "LEFT JOIN rsa.trx_nomor_lsphk3 ON rsa.trx_lsphk3.id_trx_nomor_lsphk3 = rsa.trx_nomor_lsphk3.id_trx_nomor_lsphk3 "
                    . "WHERE rsa_verifikator_unit.id_user_verifikator = '{$id_user_verifikator}' "
                    . "AND ( rsa.trx_lsphk3.aktif = '1' OR rsa.trx_lsphk3.aktif IS NULL ) "
					 . "AND rsa.trx_lsphk3.kode_unit_subunit = '{$kode_unit}' "
                    . "AND rsa.trx_lsphk3.tahun = '{$tahun}' "
                    //. "GROUP BY rba.unit.kode_unit "
                    . "ORDER BY rba.unit.kode_unit ASC";
                        
                     // echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
		function get_spm_unit($id){
            //var_dump($id_user_verifikator);die;
            $query = "SELECT kode_unit_subunit,tahun FROM trx_lsphk3 WHERE aktif='1' AND id_kuitansi='{$id}'";
            $q = $this->db->query($query);
		
		$result = $q->result();
		return $result ;
            
        }
		 function get_lsphk3_unit_usul_kbuu($tahun){
            
            $query = "SELECT rba.unit.nama_unit,rba.unit.kode_unit,COUNT(rsa.trx_lsphk3.posisi)AS jumlah,rsa.trx_lsphk3.posisi, rsa.trx_lsphk3.tahun "
                    . "FROM rba.unit LEFT JOIN rsa.trx_lsphk3 ON rba.unit.kode_unit = rsa.trx_lsphk3.kode_unit_subunit "
                    . "WHERE ( rsa.trx_lsphk3.aktif = '1' OR rsa.trx_lsphk3.aktif IS NULL ) "
                    . "AND ( rsa.trx_lsphk3.tahun = '{$tahun}' OR rsa.trx_lsphk3.tahun IS NULL ) "
                    . "GROUP BY rba.unit.kode_unit "
                    . "ORDER BY rba.unit.kode_unit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
        
        function get_lsphk3_subunit_usul_kbuu($tahun){
            
            $query = "SELECT rba.subunit.nama_subunit,rba.subunit.kode_subunit,COUNT(rsa.trx_lsphk3.posisi)AS jumlah,rsa.trx_lsphk3.posisi, rsa.trx_lsphk3.tahun "
                    . "FROM rba.subunit LEFT JOIN rsa.trx_lsphk3 ON rba.subunit.kode_subunit = rsa.trx_lsphk3.kode_unit_subunit "
                    . "WHERE ( rsa.trx_lsphk3.aktif = '1' OR rsa.trx_lsphk3.aktif IS NULL ) "
                    . "AND ( rsa.trx_lsphk3.tahun = '{$tahun}' OR rsa.trx_lsphk3.tahun IS NULL ) "
                    . "GROUP BY rba.subunit.kode_subunit "
                    . "ORDER BY rba.subunit.kode_subunit ASC";
                        
//                        echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
        }
	function get_spm_kbuu($kode_unit,$tahun){
            //var_dump($id_user_verifikator);die;
            $query = "SELECT rba.unit.nama_unit,rba.unit.kode_unit,rsa.trx_lsphk3.posisi,rsa.trx_lsphk3.posisi, rsa.trx_lsphk3.tahun,rsa.trx_nomor_lsphk3.str_nomor_trx,rsa.trx_lsphk3.id_kuitansi "
                    . "FROM rba.unit"
                    . " JOIN rsa_verifikator_unit ON rba.unit.kode_unit = rsa_verifikator_unit.kode_unit_subunit "
                    . "LEFT JOIN rsa.trx_lsphk3 ON rba.unit.kode_unit = rsa.trx_lsphk3.kode_unit_subunit "
					. "LEFT JOIN rsa.trx_nomor_lsphk3 ON rsa.trx_lsphk3.id_trx_nomor_lsphk3 = rsa.trx_nomor_lsphk3.id_trx_nomor_lsphk3 "
                    . "WHERE ( rsa.trx_lsphk3.aktif = '1' OR rsa.trx_lsphk3.aktif IS NULL ) "
					 . "AND rsa.trx_lsphk3.kode_unit_subunit = '{$kode_unit}' "
                    . "AND rsa.trx_lsphk3.tahun = '{$tahun}' "
                    //. "GROUP BY rba.unit.kode_unit "
                    . "ORDER BY rba.unit.kode_unit ASC";
                        
                     // echo $query; die;

                $q = $this->db->query($query);

		$result = $q->result();
                
//                var_dump($result);die;

		return $result ;
            
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
			//var_dump($data);die;
            return $this->db->insert("trx_urut_spm_cair",$data);
            
        }
		function final_lsphk3($kode_unit,$data){

            $this->db->where('tahun', $data['tahun']);
            $this->db->where('aktif', '1');
            $this->db->where('kd_unit', $kode_unit);
            $this->db->update('kas_bendahara', array('aktif'=>'0'));
            
            return $this->db->insert('kas_bendahara',$data);
            
        }
	

}
?>