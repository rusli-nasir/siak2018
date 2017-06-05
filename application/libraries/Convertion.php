<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Convertion{
	 public function __construct()
        {
                // Call the CI_Model constructor
                // parent::__construct();
        }
	
	function get_month($month){
		switch ($month){
			case '01' : return 'Januari';break;
			case '02' : return 'Februari';break;
			case '03' : return 'Maret';break;
			case '04' : return 'April';break;
			case '05' : return 'Mei';break;
			case '06' : return 'Juni';break;
			case '07' : return 'Juli';break;
			case '08' : return 'Agustus';break;
			case '09' : return 'September';break;
			case '10' : return 'Oktober';break;
			case '11' : return 'November';break;
			case '12' : return 'Desember';break;
		}
	}
	
	function str_replace($string){
		$string	= str_replace('-sl-','/',$string);
		$string	= str_replace('-dn-','&',$string);
		$string	= str_replace('-pl-','+',$string);
		$string	= str_replace('-lt-','<',$string);
		$string	= str_replace('-gt-','>',$string);
		$string	= str_replace('-cp-','^',$string);
		$string	= str_replace('-sr-','!',$string);
		$string	= str_replace('-usd-','$',$string);
		$string	= str_replace('-er-','`',$string);
		$string	= str_replace('-et-','@',$string);
		$string	= str_replace('-kr-','#',$string);
		$string	= str_replace('-prs-','%',$string);
		$string	= str_replace('-str-','*',$string);
		$string	= str_replace('-kb-','(',$string);
		$string	= str_replace('-kt-',')',$string);
		$string	= str_replace('-kkb-','{',$string);
		$string	= str_replace('-kkt-','}',$string);
		$string	= str_replace('-ksb-','[',$string);
		$string	= str_replace('-kst-',']',$string);
		$string	= str_replace('-tk-',';',$string);
		$string	= str_replace('-sd-','=',$string);
		$string	= str_replace('-pd-','"',$string);
		$string	= str_replace('-ps-','\'',$string);
		$string	= str_replace('-tt-','\.',$string);
		$string	= str_replace('-km-',',',$string);
		$string	= str_replace('-qm-','?',$string);
		$string	= str_replace('-vt-','|',$string);
		$string	= str_replace('-bs-','\\',$string);
		return $string;
	}

	function get_golongan($gol){
		switch ($gol){
			case '0' : return '';break;
			case '1' : return 'Program Reguler 1';break;
			case '2' : return 'Program Reguler 2';break;
			case '3' : return 'Program D3';break;
			case '4' : return 'Program Pasca Sarjana';break;
			default : return '';break;
		}
	}
	
	function sub_satker($unit){
		switch($unit){
			case '01' : return '02';break;
			case '02' : return '03';break;
			case '03' : return '04';break;
			case '04' : return '05';break;
			case '05' : return '06';break;
			case '06' : return '07';break;
			case '07' : return '08';break;
			case '08' : return '09';break;
			case '09' : return '10';break;
			case '10' : return '11';break;
			case '11' : return '28';break;
			case '12' : return '12';break;
			case '13' : return '13';break;
			case '14' : return '14';break;
			case '15' : return '15';break;
			case '16' : return '16';break;
			case '17' : return '17';break;
			case '18' : return '20';break;
			case '19' : return '24';break;
			case '20' : return '25';break;
			case '21' : return '26';break;
			case '22' : return '27';break;
			default	: return '01';break;
		}
	}
	
	function get_semester($sem,$tahun){
		switch ($sem){
			case '1' : return 'SEMESTER GASAL'.$tahun.'/'.($tahun+1);break;
			case '2' : return 'SEMESTER GENAP'.($tahun-1).'/'.$tahun;break;
			default : return '';break;
		}
	}
	
	function terbilang($x) {
		$x = abs($x);
		$angka = array("", "satu", "dua", "tiga", "empat", "lima","enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($x <12) {
			$temp = "". $angka[$x]." ";
		} else if ($x <20) {
			$temp = $this->terbilang($x - 10). " belas ";
		} else if ($x <100) {
			$temp = $this->terbilang($x/10)." puluh ". $this->terbilang($x % 10);
		} else if ($x <200) {
			$temp = " seratus" . $this->terbilang($x - 100);
		} else if ($x <1000) {
			$temp = $this->terbilang($x/100) . " ratus " . $this->terbilang($x % 100);
		} else if ($x <2000) {
			$temp = " seribu" . $this->terbilang($x - 1000);
		} else if ($x <1000000) {
			$temp = $this->terbilang($x/1000) . " ribu " . $this->terbilang($x % 1000);
		} else if ($x <1000000000) {
			$temp = $this->terbilang($x/1000000) . " juta " . $this->terbilang($x % 1000000);
		} else if ($x <1000000000000) {
			$temp = $this->terbilang($x/1000000000) . " milyar " . $this->terbilang(fmod($x,1000000000));
		} else if ($x <1000000000000000) {
			$temp = $this->terbilang($x/1000000000000) . " trilyun " . $this->terbilang(fmod($x,1000000000000));
		}      
			return $temp;
	}
	
	function get_user_level($level){
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
	
	function get_ya_tidak($ya){
		switch ($ya){
			case '0' : return 'tidak';break;
			case '1' : return 'ya';break;
		}
	}
	
	function get_jabatan($subunit){
		if ($subunit==9999){ //universitas
			return 'Rektor';
		} else if ((substr($subunit,2,2)==99)){ //fakultas
			//kasus khusus 13 dan 14
			if(substr($subunit,0,2)=='13') {
				return 'Ketua';
			}else if(substr($subunit,0,2)=='14'){
				return 'Ketua';
			}
			
			return 'Dekan';
		} else { //subunit
			return 'Ketua';
		}
	}

	// ADD BY IDRIS

	function add_two_char($str){
		
		if(strlen($str)==1){
			$str = '0'.$str ;
		}

		return $str ;
	}

	function convert_nama_sumber_dana($where){

		if($where=='01'){
			return 'SELAIN-APBN' ;
		}elseif($where=='02'){
			return 'APBN-BPPTNBH' ;
		}elseif($where=='03'){
			return 'APBN-LAINNYA' ;
		}


	}

	function convert_id_sumber_dana($where){

		if($where=='SELAIN-APBN'){
			return '01' ;
		}elseif($where=='APBN-BPPTNBH'){
			return '02' ;
		}elseif($where=='APBN-LAINNYA'){
			return '03' ;
		}


	}
}
?>
