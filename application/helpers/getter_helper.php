<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_nama_sumber_dana'))
{
     function get_nama_sumber_dana($where){

		if($where=='01'){
			return 'SELAIN-APBN' ;
		}elseif($where=='02'){
			return 'APBN-BPPTNBH' ;
		}elseif($where=='03'){
			return 'APBN-LAINNYA' ;
		}


	}
}

	function get_id_sumber_dana($where){

		if($where=='SELAIN-APBN'){
			return '01' ;
		}elseif($where=='APBN-BPPTNBH'){
			return '02' ;
		}elseif($where=='APBN-LAINNYA'){
			return '03' ;
		}


	}
	function get_unit_name($kode_unit){

		$CI = get_instance();



		$name = 'asd' ;

		if(strlen($kode_unit)==6){
			$CI->load->model('master_sub_subunit_model');
			$name = $CI->master_sub_subunit_model->get_single_sub_subunit($kode_unit,'nama');

		}elseif(strlen($kode_unit)==4){
            // echo $kode_unit ; die ;
			$CI->load->model('subunit_model');
			$name = $CI->subunit_model->get_single_subunit($kode_unit,'nama');

		}elseif(strlen($kode_unit)==2){
			$CI->load->model('unit_model');
			$name = $CI->unit_model->get_single_unit($kode_unit,'nama');

		}

		return $name;
	}
	function get_kegiatan_name($kode){
		$CI = get_instance();
		$name = 'asd' ;
		$CI->load->model('dpa_model');
		$name = $CI->dpa_model->get_single_kegiatan($kode,'nama');

		return $name;

	}

  function get_nama_akun($kode){
		$CI = get_instance();
		$name = 'asd' ;
		$CI->load->model('akun_model');
		$name = $CI->akun_model->get_nama_akun5digit($kode,'SELAIN-APBN');
		return $name;
	}


    function get_level($level){
		switch ($level){
                        case '0'  : return '';break;
			            case '100': return 'ADMIN';break;
                        case '1'  : return 'AKUNTANSI';break;
                        case '2'  : return 'KPA';break;
                        case '3'  : return 'VERIFIKATOR';break;
                        case '4'  : return 'PUMK';break;
                        case '5'  : return 'BUU';break;
			            case '11' : return 'KUASA BUU';break;
                        case '13' : return 'BENDAHARA';break;
                        case '14' : return 'PPK SUKPA';break;
                        case '15' : return 'PPPK';break;
                        case '16' : return 'PPK';break;
			default : return '';break;
		}
    }

    function get_saldo_up($kode_unit,$tahun){
//        echo $kode_unit . $tahun ;
        $CI = get_instance();
        $saldo = 0 ;
        $CI->load->model('kas_bendahara_model');
        $CI->load->model('kuitansi_model');
        if((substr($kode_unit,0,2)=='41')||(substr($kode_unit,0,2)=='42')||(substr($kode_unit,0,2)=='43')||(substr($kode_unit,0,2)=='44')){
            if(strlen($kode_unit)>4){
                $kode_unit = substr($kode_unit,0,4);
            }
            $saldo = $CI->kas_bendahara_model->get_kas_saldo($kode_unit,$tahun);
    //        echo $saldo;
            // echo $pengeluaran;
            $pengeluaran = $CI->kuitansi_model->get_pengeluaran($kode_unit,$tahun);
            // echo $pengeluaran;
        }else{
            if(strlen($kode_unit)>2){
                $kode_unit = substr($kode_unit,0,2);
            }
            $saldo = $CI->kas_bendahara_model->get_kas_saldo($kode_unit,$tahun);
    //        echo $saldo;
            $pengeluaran = $CI->kuitansi_model->get_pengeluaran($kode_unit,$tahun);   
            // echo $pengeluaran;
        }
//        echo $pengeluaran;

        return ($saldo - $pengeluaran);

        // return $saldo ;

    }


    function get_saldo_tup($kode_unit,$tahun){
//        echo $kode_unit . $tahun ;
        $CI = get_instance();
        $saldo = 0 ;
        $CI->load->model('kas_bendahara_model');
        $CI->load->model('kuitansi_model');
        if((substr($kode_unit,0,2)=='41')||(substr($kode_unit,0,2)=='42')||(substr($kode_unit,0,2)=='43')||(substr($kode_unit,0,2)=='44')){
            if(strlen($kode_unit)>4){
                $kode_unit = substr($kode_unit,0,4);
            }
            $saldo = $CI->kas_bendahara_model->get_kas_saldo_tup($kode_unit,$tahun);
    //        echo $saldo;
            // echo $pengeluaran;
            $pengeluaran = $CI->kuitansi_model->get_pengeluaran_tup($kode_unit,$tahun);
            // echo $pengeluaran;
        }else{
            if(strlen($kode_unit)>2){
                $kode_unit = substr($kode_unit,0,2);
            }
            $saldo = $CI->kas_bendahara_model->get_kas_saldo_tup($kode_unit,$tahun);
    //        echo $saldo;
            $pengeluaran = $CI->kuitansi_model->get_pengeluaran_tup($kode_unit,$tahun);   
            // echo $pengeluaran;
        }
//        echo $pengeluaran;
        
        return ($saldo - $pengeluaran);

        // return $saldo ;

    }
    
    function get_pagu_rkat($kode_unit,$tahun,$jenis){
        $CI = get_instance();
        $pagu = 0 ;
        $CI->load->model('dpa_model');
//        $CI->load->model('kuitansi_model');
        // if((substr($kode_unit,0,2)=='41')||(substr($kode_unit,0,2)=='42')||(substr($kode_unit,0,2)=='43')||(substr($kode_unit,0,2)=='44')){
        //     if(strlen($kode_unit)>4){
        //         $kode_unit = substr($kode_unit,0,4);
        //     }
        //     $pagu = $CI->dpa_model->get_pagu_rkat($kode_unit,$tahun,$jenis);

        // }else{
        //     if(strlen($kode_unit)>2){
        //         $kode_unit = substr($kode_unit,0,2);
        //     }
        //     $pagu = $CI->dpa_model->get_pagu_rkat($kode_unit,$tahun,$jenis);

        // }

        $pagu = $CI->dpa_model->get_pagu_rkat($kode_unit,$tahun,$jenis);

        return $pagu ;
    }
    
    function get_total_pengeluaran($kode_unit,$tahun){
        $CI = get_instance();
        $pengeluaran = 0 ;
        // $CI->load->model('kas_bendahara_model');
        $CI->load->model('serapan_model');
        // if((substr($kode_unit,0,2)=='41')||(substr($kode_unit,0,2)=='42')||(substr($kode_unit,0,2)=='43')||(substr($kode_unit,0,2)=='44')){
        //     if(strlen($kode_unit)>4){
        //         $kode_unit = substr($kode_unit,0,4);
        //     }
        //     // $pengeluaran = $CI->kas_bendahara_model->get_total_pengeluaran_bendahara($kode_unit,$tahun);
        //     // echo $pengeluaran;
        //     $pengeluaran = $CI->serapan_model->get_total_serapan($kode_unit,$tahun);


        // }else{
        //     if(strlen($kode_unit)>2){
        //         $kode_unit = substr($kode_unit,0,2);
        //     }
        //     // $pengeluaran = $CI->kas_bendahara_model->get_total_pengeluaran_bendahara($kode_unit,$tahun);
        //     $pengeluaran = $CI->serapan_model->get_total_serapan($kode_unit,$tahun);
        //     // echo $pengeluaran;

        // }

        $pengeluaran = $CI->serapan_model->get_total_serapan($kode_unit,$tahun);
        
        
        return $pengeluaran;
    }

    function get_total_pencairan_up($tahun){
        $CI = get_instance();
        $saldo = 0 ;
        $CI->load->model('kas_up_model');
        $saldo= $CI->kas_up_model->get_total_pencairan_up($tahun);
        
        return $saldo;
    }

    function get_total_kas(){
        $CI = get_instance();
        $saldo = 0 ;
        $CI->load->model('kas_undip_model');
        $saldo = $CI->kas_undip_model->get_total_kas();
        return $saldo;
    }
    
    function get_h_unit($kode_unit){
            $CI = get_instance();
            $CI->load->model('unit_model');
            $nama_unit = $CI->unit_model->get_nama_unit($kode_unit);
            return $nama_unit;
    }
    
    function get_h_subunit($kode_unit){
            $CI = get_instance();
            $CI->load->model('unit_model');
            $nama_subunit = $CI->unit_model->get_nama_subunit($kode_unit);
            return $nama_subunit;
    }
    
    function get_h_sub_subunit($kode_unit){
            $CI = get_instance();
            $CI->load->model('unit_model');
            $nama_sub_subunit = $CI->unit_model->get_nama_sub_subunit($kode_unit,0,2);
            return $nama_sub_subunit;
    }

    function lspeg_autonumber($id_terakhir, $panjang_angka) {
      $angka = str_replace('0','',$id_terakhir);
      $angka = intval($angka);
      $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
      // menggabungkan kode dengan nilang angka baru
      $id_baru = $angka_baru;
      return $id_baru;
    }

    function encodeText($txt){
        return htmlentities($txt,ENT_QUOTES);
    }

    function decodeText($txt){
        return html_entity_decode($txt,ENT_QUOTES);
    }

    function datetostr($date){
        $list = 
            array(
                'JANUARI',
                'FEBRUARI',
                'MARET',
                'APRIL',
                'MEI',
                'JUNI',
                'JULI',
                'AGUSTUS',
                'SEPTEMBER',
                'OKTOBER',
                'NOVEMBER',
                'DESEMBER'
                 );
        $tokens = explode('-', $date);
        $tokens[1] = ucfirst(strtolower($list[intval($tokens[1])-1]));
        return $tokens[2].' '.$tokens[1].' '.$tokens[0];
    }
    
    function strtodate($str){
        if(!$str) return null;
        $list = 
            array(
                'JANUARI'=>'01',
                'FEBRUARI'=>'02',
                'MARET'=>'03',
                'APRIL'=>'04',
                'MEI'=>'05',
                'JUNI'=>'06',
                'JULI'=>'07',
                'AGUSTUS'=>'08',
                'SEPTEMBER'=>'09',
                'OKTOBER'=>'10',
                'NOVEMBER'=>'11',
                'DESEMBER'=>'12'
                 );
        $tokens = explode(' ', $str);
        $tokens[1] = $list[strtoupper($tokens[1])];
        return $tokens[2].'-'.$tokens[1].'-'.$tokens[0];
    }
