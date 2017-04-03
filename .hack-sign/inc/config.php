<?php
$_KEY = "MUST SET"; // key for including php
$_SALT = "!@#$%^&*()"; // used for encrypting
function connect(){
	$host="localhost";
	$user="rba";
	$pass="rbaund1p";
	$dbname="rsa";

	$link=mysqli_connect($host,$user,$pass);
	$db=mysqli_select_db($link,$dbname);

	if(!$link || !$db) die(":: Error Database Connection ::");
	return $link;
}

function highlight($kata,$kunci,$color){
	$rsl=str_ireplace($kunci,"<span style='background-color:".$color.";'>".$kunci."</span>",$kata);
	return $rsl;
}

function execute($sql){
	$link = connect();
	if(!($rsl = mysqli_query($link, $sql))){ return die("<h3>:: Bad SQL query! Check your SQL syntax. SQL = <i>".$sql."</i></h3>"); }
	$last_id = mysqli_insert_id($link);
	mysqli_close($link);
	return $last_id;
}

function getdata($sql){
	$link = connect();
	$hasil = mysqli_query($link, $sql);
	$data = mysqli_fetch_assoc($hasil);
	mysqli_close($link);
	return $data;
}

function getRow($sql){
	$link = connect();
	$hasil = mysqli_query($link, $sql);
	$data = mysqli_num_rows($hasil);
	mysqli_close($link);
	return $data;
}

function getdatadb($script){
	$link = connect();
	if(!$rsl = mysqli_query($link, $script)){
		return "<h3>Looks like there're trouble in your script. <i>".$script."</i></h3>";
	}else{
		$tabl=array();
		if (mysqli_num_rows($rsl) > 0)
		{
			$i = 0;
			while($tabl[$i] = mysqli_fetch_assoc($rsl))$i++;
			unset($tabl[$i]);
		}
		mysqli_free_result($rsl);
		return $tabl;
	}
	mysqli_close($link);
}

function makeZero($content){
	if(is_numeric($content)){
		if($content>0){
			return $content;
		}else{
			return 0;
		}
	}else{return 0;}
}

function getDay($date){
	$exp=explode(" ",$date);
	$exl=explode("-",$exp[0]);
	return $exl[2];
}
function getMonth($date){
	$exp=explode(" ",$date);
	$exl=explode("-",$exp[0]);
	return $exl[1];
}
function getYear($date){
	$exp=explode(" ",$date);
	$exl=explode("-",$exp[0]);
	return $exl[0];
}
function getTime($date){
	$exp=explode(" ",$date);
	return $exp[1];
}
function getTanggal($date){
	$exp=explode(" ",$date);
	return $exp[0];
}

function noSecond($time){
	$exp = explode(":",$time);
	return $exp[0].":".$exp[1];
}

function wordMonth($nilai){
	switch(intval($nilai)){
		case 1 : return "Januari";break;
		case 2 : return "Februari";break;
		case 3 : return "Maret";break;
		case 4 : return "April";break;
		case 5 : return "Mei";break;
		case 6 : return "Juni";break;
		case 7 : return "Juli";break;
		case 8 : return "Agustus";break;
		case 9 : return "September";break;
		case 10 : return "Oktober";break;
		case 11 : return "November";break;
		case 12 : return "Desember";break;
	}
}

function wordDay($nilai){
	switch(strtolower($nilai)){
		case 'sunday' : return "Minggu";break;
		case 'monday' : return "Senin";break;
		case 'tuesday' : return "Selasa";break;
		case 'wednesday' : return "Rabu";break;
		case 'thursday' : return "Kamis";break;
		case 'friday' : return "Jumat";break;
		case 'saturday' : return "Sabtu";break;
	}
}
function balikTgl($tgl){
	$array=explode("-",$tgl);
	return $array[2]." ".wordMonth($array[1])." ".$array[0];
}
function getInputDate($tgl){
	$array=explode("-",$tgl);
	return $array[2]."-".$array[1]."-".$array[0];
}
function getFrontTahun($kode){
	if(cekKeyword($kode)!=''){
		return substr($kode,0,4);
	}
}

// Fungsi untuk merubah Angka menjadi Tulisan Huruf
// Penggunaan:
// convertAngka(25500);
// output: dua ratus lima puluh ribu lima ratus

function doone2($onestr) {
    $tsingle = array("","satu ","dua ","tiga ","empat ","lima ",
	"enam ","tujuh ","delapan ","sembilan ");
       return strtoupper($tsingle[$onestr] . $answer);
}

function doone($onestr) {
    $tsingle = array("","se","dua ","tiga ","empat ","lima ", "enam ","tujuh ","delapan ","sembilan ");
       return strtoupper($tsingle[$onestr] . $answer);
}

function dotwo($twostr) {
    $tdouble = array("","puluh ","dua puluh ","tiga puluh ","empat puluh ","lima puluh ", "enam puluh ","tujuh puluh ","delapan puluh ","sembilan puluh ");
    $teen = array("sepuluh ","sebelas ","dua belas ","tiga belas ","empat belas ","lima belas ", "enam belas ","tujuh belas ","delapan belas ","sembilan belas ");
    if ( substr($twostr,1,1) == '0') {
		$ret = doone2(substr($twostr,0,1));
    } else if (substr($twostr,1,1) == '1') {
		$ret = $teen[substr($twostr,0,1)];
    } else {
		$ret = $tdouble[substr($twostr,1,1)] . doone2(substr($twostr,0,1));
    }
    return strtoupper($ret);
}

function convertAngka($num) {
	$tdiv = array("","","ratus ","ribu ", "ratus ", "juta ", "ratus ","miliar ");
	$divs = array( 0,0,0,0,0,0,0);
	$pos = 0; // index into tdiv;
	// make num a string, and reverse it, because we run through it backwards
	// bikin num ke string dan dibalik, karena kita baca dari arah balik
	$num=strval(strrev(number_format($num,2,'.','')));
	$answer = ""; // mulai dari sini
	while (strlen($num)) {
		if ( strlen($num) == 1 || ($pos >2 && $pos % 2 == 1))  {
			$answer = doone(substr($num,0,1)) . $answer;
			$num= substr($num,1);
		} else {
			$answer = dotwo(substr($num,0,2)) . $answer;
			$num= substr($num,2);
			if ($pos < 2)
				$pos++;
		}
		if (substr($num,0,1) == '.') {
			if (! strlen($answer))
				$answer = "";
			$answer = "" . $answer . "";
			$num= substr($num,1);
			// kasih tanda "nol" jika tidak ada
			if (strlen($num) == 1 && $num == '0') {
				$answer = "" . $answer;
				$num= substr($num,1);
			}
		}
	    // add separator
	    if ($pos >= 2 && strlen($num)) {
			if (substr($num,0,1) != 0  || (strlen($num) >1 && substr($num,1,1) != 0
				&& $pos %2 == 1)  ) {
				// check for missed millions and thousands when doing hundreds
				// cek kalau ada yg lepas pada juta, ribu dan ratus
				if ( $pos == 4 || $pos == 6 ) {
					if ($divs[$pos -1] == 0)
						$answer = $tdiv[$pos -1 ] . $answer;
				}
				// standard
				$divs[$pos] = 1;
				$answer = $tdiv[$pos++] . $answer;
			} else {
				$pos++;
			}
		}
    }
    return strtoupper($answer);
}

// end function ubah angka -> huruf

function jin_pendek ($var, $len = 200, $txt_titik = "...") {
	if (strlen ($var) < $len) { return $var; }
	if (preg_match ("/(.{1,$len})\s/", $var, $match)) {  return $match [1] . $txt_titik;  }
	else { return substr ($var, 0, $len) . $txt_titik; }
}

function isExist($id,$table,$field){
	if(strlen(trim($id))>0 && strpos($id,'%')===false && strpos($id,'\\')===false){
		$sql = "SELECT COUNT(*) AS `jum` FROM `".$table."` WHERE `".$field."` LIKE '".$id."'";
		$data=getdata($sql);
		if($data['jum']>0){
			return true;
		}else{	return false; }
	}else{
		return false;
	}
}

function convertLine($var){
	$var = str_replace("\n\r","<br/>",$var);
	$var = str_replace("\r\n","<br/>",$var);
	$var = str_replace("\n","<br/>",$var);
	return $var;
}

function getValue($id,$table,$field,$target){
	if(strlen(trim($id))>0 && strpos($id,'%')===false && strpos($id,'\\')===false && isExist($id,$table,$field)){
		$sql = "SELECT `".$target."` FROM `".$table."` WHERE `".$field."` LIKE '".$id."'";
		$data=getdata($sql);
		if(count($data)>0){
			return $data[$target];
		}else{	return false; }
	}else{
		return false;
	}
}

function decodeText($text){
	return html_entity_decode($text,ENT_QUOTES);
}

function encodeText($text){
	return htmlentities($text,ENT_QUOTES);
}

function validateTime($time,$format){
	if($format==12){
		return preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $time);
	}elseif($format==24){
		return preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $time);
	}
	return false;
}

function validateDate($date, $format = 'Y-m-d H:i:s'){
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}

// config skin
/*
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
Note*: all skins have '-light' available too.
*/
$_CONFIG['skin'] = "skin-blue-light";
// start config sidebar
$_CONFIG['sidebar_state']="";
if(isset($_SESSION['sidebar_state']) && $_SESSION['sidebar_state']==1){
	$_CONFIG['sidebar_state']=" sidebar-collapse";
}
// other config
$_CONFIG['active'][0] = "";
$_CONFIG['menu_open'][0]="";
$_CONFIG['display'][0]="";
// set for path
$_CONFIG['path'] = "http://rsa.apps.undip.ac.id/hack-sign";
// $_CONFIG['path'] = "http://rsa.undip/hack-sign";
$_PATH = $_CONFIG['path'];
$GLOBALS['path'] = $_PATH;
// config for folder include mods
$_CONFIG['folder'] = "pages/";
// config for total items view per page
$_count = 10;
$_CONFIG['count'] = 10;
// configurasi untuk penyimpanan files transaksi dan lain2nya
$_CONFIG['filetype'] = array('jpg','jpeg','bmp','gif','png','pdf','doc','docx','xls','xlsx'); // allowed file types
$_CONFIG['filefolder'] = "files/";
// title site
$_CONFIG['title'] = "Gajian - Modul Pengeluaran untuk Non PNS";
$_CONFIG['institusi'] = "<a href=\"http://10.69.12.215/rsa/hack-sign/\">- H.A.C.K /SIGN</a>";
$_CONFIG['logo'] = "<a href=\"".$_PATH."\" class=\"navbar-brand\"><i class=\"fa fa-apple\"></i></a>";
// setting untuk rekening
$_CONFIG['rek_nonpns'] = 3;
$_CONFIG['rek_tunj_pns'] = 1;
$_CONFIG['rek_gaji_pns'] = 1;
// end configuration

?>
