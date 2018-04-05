<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cantik_model extends CI_Model {
/* -------------- Constructor ------------- */
  public $db2;
  public $_maxPage = 0;
	public $rek_gaji;
	public $rek_tunj;
  public function __construct()
  {
    // Call the CI_Model constructor
    parent::__construct();
    $this->db2 = $this->load->database('rba', TRUE);
    $this->eduk = $this->load->database('eduk', TRUE);
    $this->_maxPage = 25;
		$this->rek_tunj = 2;
		$this->rek_gaji = 1;
  }

  // public function doone2($onestr,$answer) {
  //     $tsingle = array("","satu ","dua ","tiga ","empat ","lima ","enam ","tujuh ","delapan ","sembilan ");
  //        return strtoupper($tsingle[$onestr] );
  // }
  //
  // public function doone($onestr,$answer) {
  //     $tsingle = array("","se","dua ","tiga ","empat ","lima ", "enam ","tujuh ","delapan ","sembilan ");
  //        return strtoupper($tsingle[$onestr] );
  // }
  //
  // public function dotwo($twostr,$answer) {
  //     $tdouble = array("","puluh ","dua puluh ","tiga puluh ","empat puluh ","lima puluh ", "enam puluh ","tujuh puluh ","delapan puluh ","sembilan puluh ");
  //     $teen = array("sepuluh ","sebelas ","dua belas ","tiga belas ","empat belas ","lima belas ", "enam belas ","tujuh belas ","delapan belas ","sembilan belas ");
  //     if ( substr($twostr,1,1) == '0') {
  //         $ret = $this->cantik_model->doone2(substr($twostr,0,1),$answer);
  //     } else if (substr($twostr,1,1) == '1') {
  //         $ret = $teen[substr($twostr,0,1)];
  //     } else {
  //         $ret = $tdouble[substr($twostr,1,1)] . $this->cantik_model->doone2(substr($twostr,0,1),$answer);
  //     }
  //     return strtoupper($ret);
  // }
  //
  // public function convertAngka($num) {
  //     $tdiv = array("","","ratus ","ribu ", "ratus ", "juta ", "ratus ","miliar ");
  //     $divs = array( 0,0,0,0,0,0,0);
  //     $pos = 0; // index into tdiv;
  //     // make num a string, and reverse it, because we run through it backwards
  //     // bikin num ke string dan dibalik, karena kita baca dari arah balik
  //     $num=strval(strrev(number_format($num,2,'.','')));
  //     $answer = ""; // mulai dari sini
  //     while (strlen($num)) {
  //         if ( strlen($num) == 1 || ($pos >2 && $pos % 2 == 1))  {
  //             $answer = $this->cantik_model->doone2(substr($num,0,1),$answer) . $answer;
  //             $num= substr($num,1);
  //         } else {
  //             $answer = $this->cantik_model->dotwo(substr($num,0,2),$answer) . $answer;
  //             $num= substr($num,2);
  //             if ($pos < 2)
  //                 $pos++;
  //         }
  //         if (substr($num,0,1) == '.') {
  //             if (! strlen($answer))
  //                 $answer = "";
  //             $answer = "" . $answer . "";
  //             $num= substr($num,1);
  //             // kasih tanda "nol" jika tidak ada
  //             if (strlen($num) == 1 && $num == '0') {
  //                 $answer = "" . $answer;
  //                 $num= substr($num,1);
  //             }
  //         }
  //         // add separator
  //         if ($pos >= 2 && strlen($num)) {
  //             if (substr($num,0,1) != 0  || (strlen($num) >1 && substr($num,1,1) != 0
  //                 && $pos %2 == 1)  ) {
  //                 // check for missed millions and thousands when doing hundreds
  //                 // cek kalau ada yg lepas pada juta, ribu dan ratus
  //                 if ( $pos == 4 || $pos == 6 ) {
  //                     if ($divs[$pos -1] == 0)
  //                         $answer = $tdiv[$pos -1 ] . $answer;
  //                 }
  //                 // standard
  //                 $divs[$pos] = 1;
  //                 $answer = $tdiv[$pos++] . $answer;
  //             } else {
  //                 $pos++;
  //             }
  //         }
  //     }
  //     return strtoupper($answer);
  // }

  public function convertAngka($x){
    $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    if ($x < 12)
      return " " . $abil[$x];
    elseif ($x < 20)
      return $this->convertAngka($x - 10) . " belas";
    elseif ($x < 100)
      return $this->convertAngka($x / 10) . " puluh" . $this->convertAngka($x % 10);
    elseif ($x < 200)
      return " seratus" . $this->convertAngka($x - 100);
    elseif ($x < 1000)
      return $this->convertAngka($x / 100) . " ratus" . $this->convertAngka($x % 100);
    elseif ($x < 2000)
      return " seribu" . $this->convertAngka($x - 1000);
    elseif ($x < 1000000)
      return $this->convertAngka($x / 1000) . " ribu" . $this->convertAngka($x % 1000);
    elseif ($x < 1000000000)
      return $this->convertAngka($x / 1000000) . " juta" . $this->convertAngka($x % 1000000);
    elseif ($x < 1000000000000)
      return $this->convertAngka($x / 1000000000) . " milyar" . $this->convertAngka($x % 1000000000);
  }

  public function getStatus($status){
		$stt = array(
			'1'=>'Aktif Bekerja',
			'2'=>'Pensiun',
			'3'=>'Cuti',
			'4'=>'Meninggal Dunia',
			'5'=>'Pindah Instansi Lain',
			'6'=>'Ijin Belajar',
			'7'=>'Non Aktif',
			'8'=>'Diberhentikan',
			'9'=>'Mengundurkan Diri',
			'10'=>'Dipekerjakan',
			'11'=>'Diperbantukan',
			'12'=>'Tugas Belajar',
			'13'=>'Diberhentikan sementara');
		return $stt[$status];
	}

  public function getJenisPeg($jns){
		$array = array(1=>'Dosen Pengajar', 2=>'Tenaga Kependidikan');
		return $array[$jns];
	}

  public function getRekening($id, $kode){
    $sql = "SELECT * FROM kepeg_tb_rekening WHERE pegawai_id = ".$id." AND jenisrek = ".$kode;
    $q = $this->db->query($sql);
    if($q->num_rows()<=0){
      return "-";
    }else{
      return $q->row()->norekening;
    }
  }

  public function getDataRekening($id, $kode){
    $sql = "SELECT * FROM kepeg_tb_rekening WHERE pegawai_id = ".$id." AND jenisrek = ".$kode;
    $q = $this->db->query($sql);
    if($q->num_rows()<=0){
      return null;
    }else{
      return $q->result();
    }
  }

  public function get_nama_jabatan_by_id($id){
  	$sql = "SELECT jabatan FROM kepeg_tb_jabatan WHERE id = ".intval($id);
  	$q = $this->db->query($sql);
  	if($q->num_rows()>0){
  		return $q->row()->jabatan;
  	}
  	return "-";
  }

  public function getPendidikan($pend){
		$sma = array(1,2,3,14,15,16,17);
		$d3 = array(4,5,6);
		$s1 = array(7,8,9,10,11,12,13);
		if(in_array($pend,$sma)){
			return "SMA";
		}
		if(in_array($pend,$d3)){
			return "DIII";
		}
		if(in_array($pend,$s1)){
			return "S1";
		}
		return "ES TELLER";
	}

	public function ambilGajiSetup($peg,$kat,$pend){
		$sql = "SELECT jumlah FROM kepeg_tr_gaji_setup WHERE jns_pegawai LIKE '".$peg."' AND kategori LIKE '".$kat."' AND jenis LIKE '".$pend."'";
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			return $q->row()->jumlah;
		}
		return 0;
	}

	public function gajiKontrak($pend){
		$pend = $this->cantik_model->getPendidikan($pend);
		return $this->cantik_model->ambilGajiSetup('KONTRAK','GAPOK',$pend);
	}

	function uangMakanKontrak($hari,$pend){
		$pend = $this->cantik_model->getPendidikan($pend);
		return $hari * $this->cantik_model->ambilGajiSetup('KONTRAK','UM',$pend);
	}

  public function isExist($id,$table,$field){
		if(strlen(trim($id))>0 && strpos($id,'%')===false && strpos($id,'\\')===false){
			$sql = "SELECT * FROM `".$table."` WHERE `".$field."` LIKE '".$id."'";
			// echo $sql; exit;
			$data=$this->db->query($sql)->num_rows();
			if($data>0){
				return true;
			}
		}
		return false;
	}

	public function getValue($id,$table,$field,$target){
		if(strlen(trim($id))>0 && strpos($id,'%')===false && strpos($id,'\\')===false && $this->isExist($id,$table,$field)){
			$sql = "SELECT `".$target."` FROM `".$table."` WHERE `".$field."` LIKE '".$id."'";
			$data=$this->db->query($sql)->row();
			if($data){
				return $data->$target;
			}else{	return false; }
		}else{
			return false;
		}
	}

	public function decodeText($text){
		return html_entity_decode($text,ENT_QUOTES);
	}

	public function encodeText($text){
		return htmlentities($text,ENT_QUOTES);
	}

  public function getUnitOption($unit){
		$sql = "SELECT * FROM tb_unit";
		$data = $this->eduk->query($sql)->result();
		$html = "";
		foreach ($data as $key => $value) {
			$s="";
			if($value->id==$unit){ $s = " selected"; }
			$html.= "<option value=\"".$value->id."\"".$s.">".$value->unit."</option>";
		}
		return $html;
	}

	public function getUnitList($unit){
		// return implode($unit,",");
		$sql = "SELECT * FROM tb_unit";
		$data = $this->eduk->query($sql)->result();
		$html = "";
		if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='15' || substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='25'){
			foreach ($data as $key => $value) {
				$s="";
				if(is_array($unit) && count($unit)>0 && in_array($value->id,$unit)){ $s = " checked"; }
				$html.= "<div class=\"col-md-2 small\"><label><input type=\"checkbox\" class=\"unit_id\" name=\"unit_id[]\" value=\"".$value->id."\"".$s.">&nbsp;".$value->unit_short."</label></div>";
			}
		}else{
			foreach ($data as $key => $value) {
				$s=" disabled=\"disabled\"";
				$t="";
				$c="";
				if(((is_array($unit) && count($unit)==1 && $value->id == $unit[0]) || (!is_array($unit)) && $value->id == $unit)){ $c=" checked=\"checked\""; $s = ""; $t = " class=\"unit_id\" name=\"unit_id[]\" value=\"".$value->id."\"";
					$html.= "<div class=\"col-md-2 small\"><label><input type=\"checkbox\"".$t.$s.$c.">&nbsp;".$value->unit_short."</label></div>";
				}
			}
		}
		return $html;
	}

	public function getUnitChecked(){
		$sql = "SELECT * FROM tb_unit";
		$data = $this->eduk->query($sql)->result();
		$arr = array();
		foreach ($data as $key => $value) {
			if($value->id == 27){
				continue;
			}
			$arr[] = $value->id;
		}
		return $arr;
	}

	public function getUnitCheckedAll(){
		$sql = "SELECT * FROM tb_unit";
		$data = $this->eduk->query($sql)->result();
		$arr = array();
		foreach ($data as $key => $value) {
			$arr[] = $value->id;
		}
		return $arr;
	}

	public function getUnit($unit){
		$sql = "SELECT unit FROM tb_unit WHERE id =".intval($unit);
		$data = $this->eduk->query($sql)->row();
		return $data->unit;
	}

	public function getUnitShort($unit){
		$sql = "SELECT unit_short FROM tb_unit WHERE id =".intval($unit);
		$data = $this->eduk->query($sql)->row();
		return $data->unit_short;
	}

  public function getBulanOption($dpilih){
		$selected=array("","","","","","","","","","","","","");
		switch($dpilih){
			case 1 : $selected[0]="selected=\"selected\"";break;
			case 2 : $selected[1]="selected=\"selected\"";break;
			case 3 : $selected[2]="selected=\"selected\"";break;
			case 4 : $selected[3]="selected=\"selected\"";break;
			case 5 : $selected[4]="selected=\"selected\"";break;
			case 6 : $selected[5]="selected=\"selected\"";break;
			case 7 : $selected[6]="selected=\"selected\"";break;
			case 8 : $selected[7]="selected=\"selected\"";break;
			case 9 : $selected[8]="selected=\"selected\"";break;
			case 10 : $selected[9]="selected=\"selected\"";break;
			case 11 : $selected[10]="selected=\"selected\"";break;
			case 12 : $selected[11]="selected=\"selected\"";break;
			default : $selected[12]="selected=\"selected\"";break;
		}
		return "
		<option value=\"1\" ".$selected[0].">Januari</option>
	    <option value=\"2\" ".$selected[1].">Februari</option>
	    <option value=\"3\" ".$selected[2].">Maret</option>
	    <option value=\"4\" ".$selected[3].">April</option>
	    <option value=\"5\" ".$selected[4].">Mei</option>
	    <option value=\"6\" ".$selected[5].">Juni</option>
	    <option value=\"7\" ".$selected[6].">Juli</option>
	    <option value=\"8\" ".$selected[7].">Agustus</option>
	    <option value=\"9\" ".$selected[8].">September</option>
	    <option value=\"10\" ".$selected[9].">Oktober</option>
	    <option value=\"11\" ".$selected[10].">November</option>
	    <option value=\"12\" ".$selected[11].">Desember</option>
	    <option value=\"13\" ".$selected[12].">IKW ke-13</option>";
	}

  public function daftar_unit_kepeg(){
    $sql = "SELECT * FROM kepeg_unit";
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      return $q->result();
    }
    return 0;
  }

	public function getStatusKepegFullOption($status){
		$data = array(array('id'=>1,'nama'=>'Pegawai Negeri Sipil (PNS)'), array('id'=>2,'nama'=>'Pegawai Tetap Non PNS (BLU)'), array('id'=>3,'nama'=>'Calon Pegawai Negeri Sipil (CPNS)'), array('id'=>4,'nama'=>'Tenaga Kontrak'));
		$html = "";
		foreach ($data as $key => $value) {
			$s="";
			if($value['id']==$status){ $s = " selected"; }
			$html.= "<option value=\"".$value['id']."\"".$s.">".$value['nama']."</option>";
		}
		return $html;
	}

	public function getStatusKepegOption($status){
		$data = array(array('id'=>1,'nama'=>'Pegawai Negeri Sipil (PNS)'), array('id'=>2,'nama'=>'Pegawai Tetap Non PNS (BLU)'), array('id'=>4,'nama'=>'Tenaga Kontrak'));
		$html = "";
		foreach ($data as $key => $value) {
			$s="";
			if($value['id']==$status){ $s = " selected"; }
			$html.= "<option value=\"".$value['id']."\"".$s.">".$value['nama']."</option>";
		}
		return $html;
	}

	public function getStatusKepegFullCheckbox($status){
		$data = array(array('id'=>1,'nama'=>'Pegawai Negeri Sipil (PNS)'), array('id'=>2,'nama'=>'Pegawai Tetap Non PNS (BLU)'), array('id'=>3,'nama'=>'Calon Pegawai Negeri Sipil (CPNS)'), array('id'=>4,'nama'=>'Tenaga Kontrak'));
		$html = "";
		foreach ($data as $key => $value) {
			$s="";
			if(is_array($status) && count($status)>0 && in_array($value['id'],$status)){ $s = " checked"; }
			$html.= "<div class=\"col-md-3 small\"><label><input type=\"checkbox\" class=\"status_kepeg\" name=\"status_kepeg[]\" value=\"".$value['id']."\"".$s.">".$value['nama']."</label></div>";
		}
		return $html;
	}

	public function msgSukses($m){
		return "<div class=\"alert alert-success alert-dismissible text-center\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\"><i class=\"glyphicon glyphicon-remove\"></i></button><i class=\"glyphicon glyphicon-lamp\"></i>&nbsp;&nbsp;".$m."</div>";
	}

	public function msgGagal($m){
		return "<div class=\"alert alert-danger alert-dismissible text-center\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\"><i class=\"glyphicon glyphicon-remove\"></i></button><i class=\"glyphicon glyphicon-alert\"></i>&nbsp;&nbsp;".$m."</div>";
	}

	public function getBobot($jab){
		$sql="SELECT `bobot` FROM kepeg_tb_jabatan WHERE id=".intval($jab);
		$jum = $this->db->query($sql)->row();
		if($jum){
			$rsl['bobot'] = $jum->bobot;
			return $rsl['bobot'];
		}
	}

	function getIKWBruto($gol,$bobot){
		$sql = "SELECT bruto FROM kepeg_tb_ikw WHERE grade_id = ".intval($bobot)." AND golongan_id = ".intval($gol);
		$jum = $this->db->query($sql);
		if($jum->num_rows()>0){
			$rsl = $jum->row();
			return $rsl->bruto;
		}
		return 0;
	}

	function getIKWRSND($gol,$bobot){
		$sql = "SELECT bruto FROM kepeg_tb_ikw_rsnd WHERE grade_id = ".intval($bobot)." AND golongan_id = ".intval($gol);
		$jum = $this->db->query($sql);
		if($jum->num_rows()>0){
			$rsl = $jum->row();
			return $rsl->bruto;
		}
		return 0;
	}

	function getIKWNetto($gol,$bobot){
		$sql = "SELECT netto FROM kepeg_tb_ikw WHERE grade_id = ".intval($bobot)." AND golongan_id = ".intval($gol);
		$jum = $this->db->query($sql);
		if($jum->num_rows()>0){
			$rsl = $jum->row();
			return $rsl->netto;
		}
		return 0;
	}

	function getIKW($gol,$bobot){
		$sql = "SELECT netto,bruto FROM kepeg_tb_ikw WHERE grade_id = ".intval($bobot)." AND golongan_id = ".intval($gol);
		$jum = $this->db->query($sql);
		if($jum->num_rows()>0){
			$rsl = $jum->row();
			return array('bruto'=>$rsl->bruto, 'netto'=>$rsl->netto);
		}
		return array('netto'=>0,'bruto'=>0);
	}

	public function getSemester($sms){
		switch (intval($sms)) {
			case 1:
				return "Ganjil";
				break;

			default:
				return "Genap";
				break;
		}
	}

	public function getStatusKepeg($status){
		$data = array(1=>'Pegawai Negeri Sipil',3=>'Calon Pegawai Negeri Sipil',2=>'Pegawai Tetap Non PNS (BLU)',4=>'Tenaga Kontrak');
		return $data[$status];
	}

	public function getInputDate($tgl){
		$array=explode("-",$tgl);
		return $array[2]."-".$array[1]."-".$array[0];
	}

	public function wordMonth($nilai){
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
			case 13 : return "IKW ke-13";break;
		}
	}

	function wordMonthShort($nilai){
    switch(intval($nilai)){
	    case 1 : return "Jan";break;
	    case 2 : return "Feb";break;
	    case 3 : return "Mar";break;
	    case 4 : return "Apr";break;
	    case 5 : return "Mei";break;
	    case 6 : return "Jun";break;
	    case 7 : return "Jul";break;
	    case 8 : return "Agu";break;
	    case 9 : return "Sep";break;
	    case 10 : return "Okt";break;
	    case 11 : return "Nov";break;
	    case 12 : return "Des";break;
    }
   }

	public function wordDay($nilai){
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

	public function balikTgl($tgl){
		$array=explode("-",$tgl);
		return $array[2]." ".$this->wordMonth($array[1])." ".$array[0];
	}

	public function validateTime($time,$format){
		if($format==12){
			return preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $time);
		}elseif($format==24){
			return preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $time);
		}
		return false;
	}

	public function validateDate($date, $format = 'Y-m-d H:i:s'){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	public function number($i){
		return number_format($i,0,',','.').",-";
	}

	public function pajak($i){
		return ($i*100)."%";
	}

	public function getGolongan($id){
		$sql = "SELECT * FROM kepeg_tb_golongan WHERE id =".$id;
		return $this->db->query($sql)->row()->gol;
	}

	public function get_data_ipp(){
		if(isset($_SESSION['ipp'])){
			$vSQL = "";
			if(isset($_SESSION['ipp']['status_kepeg']) && is_array($_SESSION['ipp']['status_kepeg']) && count($_SESSION['ipp']['status_kepeg'])>1){
				$vSQL.= " AND ( b.`status_kepeg` = ".implode(" OR b.status_kepeg = ", $_SESSION['ipp']['status_kepeg']).")";
			}elseif(isset($_SESSION['ipp']['status_kepeg']) && is_array($_SESSION['ipp']['status_kepeg']) && count($_SESSION['ipp']['status_kepeg'])==1){
				$vSQL.= " AND b.`status_kepeg` = ".$_SESSION['ipp']['status_kepeg'][0];
			}
			if(isset($_SESSION['ipp']['unit_id']) && is_array($_SESSION['ipp']['unit_id']) && count($_SESSION['ipp']['unit_id'])>1){
				$vSQL.= " AND ( b.`unit_id` = ".implode(" OR b.unit_id = ", $_SESSION['ipp']['unit_id']).")";
			}elseif(isset($_SESSION['ipp']['unit_id']) && is_array($_SESSION['ipp']['unit_id']) && count($_SESSION['ipp']['unit_id'])==1){
				$vSQL.= " AND b.`unit_id` = ".$_SESSION['ipp']['unit_id'][0];
			}
			if(isset($_SESSION['ipp']['status']) && is_array($_SESSION['ipp']['status']) && count($_SESSION['ipp']['status'])>1){
				$vSQL.= " AND ( b.`status` = ".implode(" OR b.status = ", $_SESSION['ipp']['status']).")";
			}elseif(isset($_SESSION['ipp']['status']) && is_array($_SESSION['ipp']['status']) && count($_SESSION['ipp']['status'])==1){
				$vSQL.= " AND b.`status` = ".$_SESSION['ipp']['status'][0];
			}
			if(isset($_SESSION['ipp']['tahun'])){
				$vSQL.= " AND a.tahun = ".$_SESSION['ipp']['tahun'];
			}
			if(isset($_SESSION['ipp']['semester'])){
				$vSQL.= " AND a.semester = ".$_SESSION['ipp']['semester'];
			}
			// otomatis terpanggil
			$sql = "SELECT a.*, b.nama, b.npwp, b.status, b.golongan_id, c.*, d.unit FROM kepeg_tr_ipp a LEFT JOIN kepeg_tb_pegawai b ON a.nip = b.nip LEFT JOIN kepeg_tb_rekening c ON b.id = c.pegawai_id LEFT JOIN kepeg_unit d ON b.unit_id = d.id WHERE c.jenisrek = ".$this->rek_gaji." AND b.jnspeg = ".$_SESSION['ipp']['jnspeg'].$vSQL." ORDER BY b.unit_id, b.golongan_id DESC";
			// echo $sql; exit;
			if($this->db->query($sql)->num_rows()){
				return $this->db->query($sql)->result();
			}
			return array();
		}
	}

	/*get khusus list IPP*/
	public function get_unit_ipp(){
		$str = array();
		if(isset($_SESSION['ipp']['unit_id']) && is_array($_SESSION['ipp']['unit_id']) && count($_SESSION['ipp']['unit_id'])>0){
			foreach($_SESSION['ipp']['unit_id'] as $k => $v){
				$str[] = $this->getUnitShort($v);
			}
		}
		return implode(", ",$str);
	}

	public function get_status_ipp(){
		$str = array();
		if(isset($_SESSION['ipp']['status_kepeg']) && is_array($_SESSION['ipp']['status_kepeg']) && count($_SESSION['ipp']['status_kepeg'])>0){
			foreach($_SESSION['ipp']['status_kepeg'] as $k => $v){
				$str[] = $this->getStatusKepeg($v);
			}
		}
		return implode(", ",$str);
	}

	public function get_status_kerja_ipp(){
		$str = array();
		if(isset($_SESSION['ipp']['status']) && is_array($_SESSION['ipp']['status']) && count($_SESSION['ipp']['status'])>0){
			foreach($_SESSION['ipp']['status'] as $k => $v){
				$str[] = $this->getStatus($v);
			}
		}
		return implode(", ",$str);
	}

	/*get khusus list TKK*/
	// untuk Gaji TKK
	public function get_data_tkk(){
		if(isset($_SESSION['tkk'])){
			$vSQL = "";
			if(isset($_SESSION['tkk']['status_kepeg']) && is_array($_SESSION['tkk']['status_kepeg']) && count($_SESSION['tkk']['status_kepeg'])>1){
				$vSQL.= " AND ( b.`status_kepeg` = ".implode(" OR b.status_kepeg = ", $_SESSION['tkk']['status_kepeg']).")";
			}elseif(isset($_SESSION['tkk']['status_kepeg']) && is_array($_SESSION['tkk']['status_kepeg']) && count($_SESSION['tkk']['status_kepeg'])==1){
				$vSQL.= " AND b.`status_kepeg` = ".$_SESSION['tkk']['status_kepeg'][0];
			}
			if(isset($_SESSION['tkk']['unit_id']) && is_array($_SESSION['tkk']['unit_id']) && count($_SESSION['tkk']['unit_id'])>1){
				$vSQL.= " AND ( b.`unit_id` = ".implode(" OR b.unit_id = ", $_SESSION['tkk']['unit_id']).")";
			}elseif(isset($_SESSION['tkk']['unit_id']) && is_array($_SESSION['tkk']['unit_id']) && count($_SESSION['tkk']['unit_id'])==1){
				$vSQL.= " AND b.`unit_id` = ".$_SESSION['tkk']['unit_id'][0];
			}
			if(isset($_SESSION['tkk']['status']) && is_array($_SESSION['tkk']['status']) && count($_SESSION['tkk']['status'])>1){
				$vSQL.= " AND ( b.`status` = ".implode(" OR b.status = ", $_SESSION['tkk']['status']).")";
			}elseif(isset($_SESSION['tkk']['status']) && is_array($_SESSION['tkk']['status']) && count($_SESSION['tkk']['status'])==1){
				$vSQL.= " AND b.`status` = ".$_SESSION['tkk']['status'][0];
			}
			if(isset($_SESSION['tkk']['tahun'])){
				$vSQL.= " AND a.tahun = ".$_SESSION['tkk']['tahun'];
			}
			if(isset($_SESSION['tkk']['bulan'])){
				$vSQL.= " AND a.bulan = ".$_SESSION['tkk']['bulan'];
			}
      // if($_SESSION['tkk']['status_kepeg'][0] == 1){
			//      $vSQL.=" AND c.jenisrek LIKE '1'"; // khusus gaji tkk
      // }elseif($_SESSION['tkk']['status_kepeg'] == 1){
			//      $vSQL.=" AND c.jenisrek LIKE '1'"; // khusus gaji tkk
      // }
			// otomatis terpanggil
			// $sql = "SELECT a.*, b.nama, b.npwp, b.status, d.unit_short FROM kepeg_tr_dgaji a LEFT JOIN kepeg_tb_pegawai b ON a.nip = b.nip LEFT JOIN kepeg_unit d ON b.unit_id = d.id WHERE b.jnspeg = ".$_SESSION['tkk']['jnspeg'].$vSQL." ORDER BY b.unit_id, b.golongan_id DESC";
			// $sql = "SELECT a.id, a.pegid, a.jabid, d.unit_short, a.status, a.nominalg, a.nip, b.nama, c.kelompok_bank, c.nmpemilik, c.norekening
			// 				FROM kepeg_tr_dgaji a
			// 				LEFT JOIN kepeg_tb_pegawai b ON a.nip = b.nip
			// 				LEFT JOIN kepeg_tb_rekening c ON b.id = c.pegawai_id
			// 				LEFT JOIN kepeg_unit d ON b.unit_id = d.id
			// 				WHERE c.jenisrek = 1 AND b.jnspeg = ".$_SESSION['tkk']['jnspeg'].$vSQL." ORDER BY b.unit_id, b.id";
      $sql = "SELECT a.id, a.pegid, a.jabid, d.unit_short, a.status, a.nominalg, a.nip, b.nama, '' AS kelompok_bank, '' AS nmpemilik, '' AS norekening
							FROM kepeg_tr_dgaji a
							LEFT JOIN kepeg_tb_pegawai b ON a.nip = b.nip
							LEFT JOIN kepeg_unit d ON b.unit_id = d.id
							WHERE b.jnspeg = ".$_SESSION['tkk']['jnspeg'].$vSQL." ORDER BY b.unit_id, b.id";
			// echo $sql; exit;
			if($this->db->query($sql)->num_rows()){
				return $this->db->query($sql)->result();
			}
			return array();
		}
	}

	public function get_unit_tkk(){
		$str = array();
		if(isset($_SESSION['tkk']['unit_id']) && is_array($_SESSION['tkk']['unit_id']) && count($_SESSION['tkk']['unit_id'])>0){
			foreach($_SESSION['tkk']['unit_id'] as $k => $v){
				$str[] = $this->getUnitShort($v);
			}
		}
		return implode(", ",$str);
	}

	public function get_status_tkk(){
		$str = array();
		if(isset($_SESSION['tkk']['status_kepeg']) && is_array($_SESSION['tkk']['status_kepeg']) && count($_SESSION['tkk']['status_kepeg'])>0){
			foreach($_SESSION['tkk']['status_kepeg'] as $k => $v){
				$str[] = $this->getStatusKepeg($v);
			}
		}
		return implode(", ",$str);
	}

	public function get_status_kerja_tkk(){
		$str = array();
		if(isset($_SESSION['tkk']['status']) && is_array($_SESSION['tkk']['status']) && count($_SESSION['tkk']['status'])>0){
			foreach($_SESSION['tkk']['status'] as $k => $v){
				$str[] = $this->getStatus($v);
			}
		}
		return implode(", ",$str);
	}

	public function get_nominal_tkk($jabid, $pedid, $nik, $jnspeg){
		if($jnspeg == 2){
			$sql = "SELECT nominal FROM kepeg_tb_kontrak_tendik WHERE jabid LIKE '".intval($jabid)."' AND pedid LIKE '".intval($pedid)."'";
			$q = $this->db->query($sql);
			if($q->num_rows()>0){
				return $q->row()->nominal;
			}else{
				$sql = "SELECT gaji_pokok FROM kepeg_tb_gaji_kontrak_source WHERE nik LIKE '".$nik."'";
				$q = $this->db->query($sql);
				if($q->num_rows()>0){
					return $q->row()->gaji_pokok;
				}
			}
		}else{
			$sql = "SELECT nominal FROM kepeg_tb_kontrak_dosen WHERE pedid LIKE '".intval($pedid)."'";
			$q = $this->db->query($sql);
			if($q->num_rows()>0){
				return $q->row()->nominal;
			}
		}
		return 0;
	}

	/*get list untuk IKW*/
	public function get_unit_ikw(){
		$str = array();
		if(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])>0){
			foreach($_SESSION['ikw']['unit_id'] as $k => $v){
				$str[] = $this->getUnitShort($v);
			}
		}
		return implode(", ",$str);
	}

	public function get_status_ikw(){
		$str = array();
		if(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])>0){
			foreach($_SESSION['ikw']['status_kepeg'] as $k => $v){
				$str[] = $this->getStatusKepeg($v);
			}
		}
		return implode(", ",$str);
	}

	public function get_status_kerja_ikw(){
		$str = array();
		if(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])>0){
			foreach($_SESSION['ikw']['status'] as $k => $v){
				$str[] = $this->getStatus($v);
			}
		}
		return implode(", ",$str);
	}

	public function get_unit_rba($kd){
		if($kd!='99'){
			/*if(strlen($kd)<=2){
				$kd.="%";
			}*/
			if(strlen($kd)>2){
				// $kd.="%";
				$kd = substr($kd, 0, 2)."%";
			}
			$sql = "SELECT `kode_unit_kepeg` FROM `rsa_unit` WHERE `kode_unit_rba` LIKE '".$kd."%'";
			// return $sql;
			$dt = $this->db->query($sql);
			if($dt->num_rows()>0){
				return array(0=>$dt->row()->kode_unit_kepeg);
			}
		}else{
			return array(0=>'Kantor Pusat');
		}
	}


  //======================== IKW ===================== //
	public function get_data_ikw($kelompok_bank=''){
		if(isset($_SESSION['ikw'])){
			$vSQL = "";
			if(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])>1){
				$vSQL.= " AND ( b.`status_kepeg` = ".implode(" OR b.status_kepeg = ", $_SESSION['ikw']['status_kepeg']).")";
			}elseif(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])==1){
				$vSQL.= " AND b.`status_kepeg` = ".$_SESSION['ikw']['status_kepeg'][0];
			}
			if(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])>1){
				$vSQL.= " AND ( b.`unit_id` = ".implode(" OR b.unit_id = ", $_SESSION['ikw']['unit_id']).")";
			}elseif(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])==1){
				$vSQL.= " AND b.`unit_id` = ".$_SESSION['ikw']['unit_id'][0];
			}
			if(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])>1){
				$vSQL.= " AND ( b.`status` = ".implode(" OR b.status = ", $_SESSION['ikw']['status']).")";
			}elseif(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])==1){
				$vSQL.= " AND b.`status` = ".$_SESSION['ikw']['status'][0];
			}
			if(isset($_SESSION['ikw']['tahun'])){
				$vSQL.= " AND a.tahun = ".$_SESSION['ikw']['tahun'];
			}
			if(isset($_SESSION['ikw']['bulan'])){
				$vSQL.= " AND a.bulan = ".$_SESSION['ikw']['bulan'];
			}
		  $vTSQL = "";
		  if($_SESSION['ikw']['bulan']<=6 && $_SESSION['ikw']['bulan']>=1){
		    $sms = 'SMT02'.($_SESSION['ikw']['tahun']-1);
		  }else
		  if($_SESSION['ikw']['bulan']<=12 && $_SESSION['ikw']['bulan']>=7){
		    $sms = 'SMT01'.$_SESSION['ikw']['tahun'];
		    // $vTSQL = " AND g.periode_ikw LIKE '".$sms."'";
		  }
      $tbKehadiran = "";
      $tbKehadiranSQL = "SELECT * FROM kepeg_tb_hadir_ikw WHERE periode_ikw LIKE '".$sms."'";
      // echo $tbKehadiranSQL; exit;
      $q= $this->db->query($tbKehadiranSQL);
      if($q->num_rows()>0){
      	$tbKehadiran = " LEFT JOIN kepeg_tb_hadir_ikw g ON a.nip = g.nip";
      	$vTSQL = " AND g.periode_ikw LIKE '".$sms."'";
      	$vTField = ", g.jam";
      }

			// otomatis terpanggil
      if($_SESSION['ikw']['jnspeg'] == 2){
  			$sql = "SELECT a.*, b.nama, b.npwp, b.status, b.golongan_id, b.status_kepeg, c.*, d.unit, e.jabatan, e.bobot, f.kelompok".$vTField." FROM kepeg_tr_ikw a JOIN kepeg_tb_pegawai b ON a.nip = b.nip JOIN kepeg_tb_rekening c ON b.id = c.pegawai_id JOIN kepeg_unit d ON b.unit_id = d.id JOIN kepeg_tb_jabatan e ON e.id = b.jabatan_id LEFT JOIN `kepeg_tb_golongan` f ON b.`golongan_id` = f.`id`".$tbKehadiran." WHERE c.jenisrek = ".$this->rek_tunj." AND b.jnspeg = ".$_SESSION['ikw']['jnspeg'].$vSQL.$vTSQL." ORDER BY c.kelompok_bank, b.unit_id, b.golongan_id DESC, b.nip";
  			$sql_bank = "SELECT c.* FROM kepeg_tr_ikw a JOIN kepeg_tb_pegawai b ON a.nip = b.nip JOIN kepeg_tb_rekening c ON b.id = c.pegawai_id JOIN kepeg_unit d ON b.unit_id = d.id JOIN kepeg_tb_jabatan e ON e.id = b.jabatan_id LEFT JOIN `kepeg_tb_golongan` f ON b.`golongan_id` = f.`id`".$tbKehadiran." WHERE c.jenisrek = ".$this->rek_tunj." AND b.jnspeg = ".$_SESSION['ikw']['jnspeg'].$vSQL.$vTSQL." GROUP BY c.kelompok_bank";
      }else{
        $sql = "SELECT a.*, b.id AS id_peg, b.nama, b.npwp, b.status, b.golongan_id, b.status_kepeg, c.*, d.unit, e.jabatan, e.bobot, f.kelompok FROM kepeg_tr_ikw a JOIN kepeg_tb_pegawai b ON a.nip = b.nip JOIN kepeg_tb_rekening c ON b.id = c.pegawai_id JOIN kepeg_unit d ON b.unit_id = d.id JOIN kepeg_tb_jabatan e ON e.id = b.jabatan_id LEFT JOIN `kepeg_tb_golongan` f ON b.`golongan_id` = f.`id` WHERE c.jenisrek = ".$this->rek_tunj." AND b.jnspeg = ".$_SESSION['ikw']['jnspeg'].$vSQL." ORDER BY c.kelompok_bank, b.unit_id, b.golongan_id DESC, b.nip";
        $sql_bank = "SELECT c.* FROM kepeg_tr_ikw a JOIN kepeg_tb_pegawai b ON a.nip = b.nip JOIN kepeg_tb_rekening c ON b.id = c.pegawai_id JOIN kepeg_unit d ON b.unit_id = d.id JOIN kepeg_tb_jabatan e ON e.id = b.jabatan_id LEFT JOIN `kepeg_tb_golongan` f ON b.`golongan_id` = f.`id` WHERE c.jenisrek = ".$this->rek_tunj." AND b.jnspeg = ".$_SESSION['ikw']['jnspeg'].$vSQL." GROUP BY c.kelompok_bank";
      }
			// echo $sql; exit;
			if($this->db->query($sql)->num_rows()){
				return array($this->db->query($sql)->result(), $this->db->query($sql_bank)->result());
			}
			return array();
		}
	}

  public function hapus_ikw(){
		if(isset($_SESSION['ikw'])){
			$vSQL = "";
			if(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])>1){
				$vSQL.= " AND ( `statuspeg` = ".implode(" OR `statuspeg` = ", $_SESSION['ikw']['status_kepeg']).")";
			}elseif(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])==1){
				$vSQL.= " AND `statuspeg` = ".$_SESSION['ikw']['status_kepeg'][0];
			}
			if(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])>1){
				$vSQL.= " AND ( `unitid` = ".implode(" OR unitid = ", $_SESSION['ikw']['unit_id']).")";
			}elseif(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])==1){
				$vSQL.= " AND `unitid` = ".$_SESSION['ikw']['unit_id'][0];
			}
			if(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])>1){
				$vSQL.= " AND ( `status` = ".implode(" OR status = ", $_SESSION['ikw']['status']).")";
			}elseif(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])==1){
				$vSQL.= " AND `status` = ".$_SESSION['ikw']['status'][0];
			}
			if(isset($_SESSION['ikw']['tahun'])){
				$vSQL.= " AND `tahun` = ".$_SESSION['ikw']['tahun'];
			}
			if(isset($_SESSION['ikw']['bulan'])){
				$vSQL.= " AND `bulan` = ".$_SESSION['ikw']['bulan'];
			}

      $sql = "DELETE FROM `kepeg_tr_ikw` WHERE `jenispeg` = ".$_SESSION['ikw']['jnspeg'].$vSQL." AND fk_rsa_unit LIKE '".$_SESSION['rsa_kode_unit_subunit']."%'";
      // return $sql;
      if($this->db->query($sql)){
				return true;
			}
			return false;
		}
	}
  //=================== IKW ===============//


	public function getNominalTutam($id,$kel){
		$sql = "SELECT brutto FROM kepeg_tb_nominaltutam WHERE id = ".$id." AND golongan_id = ".$kel;
		$hsl = $this->db->query($sql);
		if($hsl->num_rows()>0){
			return $hsl->row()->brutto;
		}
		return 0;
	}

	public function get_data_pegawai_tutam(){
		$vSQL = "";
		if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)!='15' && substr($_SESSION['rsa_kode_unit_subunit'],0,2)!='25'){
			$unit = $this->cantik_model->get_unit_rba($_SESSION['rsa_kode_unit_subunit']);
			$vSQL = " AND a.unit_id LIKE '".$unit[0]."'";
		}
		if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='15' || substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='25'){
			$vSQL = " AND ( b.tgs_tambahan_id!='43' AND b.tgs_tambahan_id!='44' AND b.tgs_tambahan_id!='45' )";
		}
		/*$sql =	"SELECT a.nama, a.nip, a.golongan_id, a.unit_id, a.status, d.kelompok, b.tgs_tambahan_id, c.tugas_tambahan, b.det_tgs_tambahan, e.nmbank, e.norekening
		FROM kepeg_tb_pegawai a
		RIGHT JOIN kepeg_tb_riwayat_tgs_tambahan b ON a.id = b.pegawai_id
		LEFT JOIN kepeg_tb_tgs_tambahan c ON b.tgs_tambahan_id = c.id
		LEFT JOIN kepeg_tb_golongan d ON a.golongan_id = d.id
		LEFT JOIN kepeg_tb_rekening e ON a.id = e.pegawai_id
		WHERE b.status_aktif = 1 AND (a.status = 1 OR a.status = 3 OR a.status = 6 OR a.status = 12) AND e.jenisrek = 2".$vSQL." ORDER BY a.golongan_id, a.nip";*/
		$sql =	"SELECT a.nama, a.nip, a.golongan_id, a.unit_id, a.status, d.kelompok, b.tgs_tambahan_id, c.tugas_tambahan, b.det_tgs_tambahan
		FROM kepeg_tb_pegawai a
		RIGHT JOIN kepeg_tb_riwayat_tgs_tambahan b ON a.id = b.pegawai_id
		LEFT JOIN kepeg_tb_tgs_tambahan c ON b.tgs_tambahan_id = c.id
		LEFT JOIN kepeg_tb_golongan d ON a.golongan_id = d.id
		WHERE b.status_aktif = 1 AND (a.status = 1 OR a.status = 3 OR a.status = 6 OR a.status = 12) ".$vSQL." ORDER BY a.golongan_id, a.nip";
		// echo $sql; exit;
		// AND a.nip NOT LIKE '%196006271990011001%'
		$dt = $this->db->query($sql)->result();
		return $dt;
	}

	public function get_data_tutam(){
		$vSQL = "";
		if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)!='15' && substr($_SESSION['rsa_kode_unit_subunit'],0,2)!='25'){
			$unit = $this->cantik_model->get_unit_rba($_SESSION['rsa_kode_unit_subunit']);
			$vSQL = " AND a.unit_id LIKE '".$unit[0]."'";
		}
		// otomatis terpanggil
		// $sql = "SELECT a.*, b.npwp FROM kepeg_tr_tutam a LEFT JOIN kepeg_tb_pegawai b ON a.nip = b.nip WHERE a.tahun LIKE '".$_SESSION['tutam']['tahun']."' AND a.bulan LIKE '".$_SESSION['tutam']['bulan']."'".$vSQL." ORDER BY a.unit_id, a.golongan_id DESC";
		$sql = "SELECT a.*, b.npwp FROM kepeg_tr_tutam a LEFT JOIN kepeg_tb_pegawai b ON a.nip = b.nip WHERE a.tahun LIKE '".$_SESSION['tutam']['tahun']."' AND a.bulan LIKE '".$_SESSION['tutam']['bulan']."'".$vSQL." ORDER BY a.nmbank, a.nip";
		if($this->db->query($sql)->num_rows()){
			return $this->db->query($sql)->result();
		}
		return array();
	}

	public function get_dosen_rsnd(){
		$sql = "SELECT * FROM kepeg_tb_pegawai WHERE jnspeg = 1 AND unit_id = 4 AND ( status = 1 OR status = 3 OR status = 6 OR status = 12) AND ( status_kepeg = 1 OR status_kepeg = 3 )";
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			$html = "";
			$d = $q->result();
			foreach($d as $k => $v){
				$html.="<option value=\"".$v->nip." - ".$v->nama."\">".$v->nama."</option>";
			}
			return $html;
		}
		return "";
	}

	public function get_jabatan_rsnd(){
		$sql = "SELECT * FROM kepeg_tb_tutam_rsnd";
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			$html = "";
			$d = $q->result();
			foreach($d as $k => $v){
				$html.="<option value=\"".$v->id." - ".$v->jabatan."\">".$v->jabatan."</option>";
			}
			return $html;
		}
		return array();
	}

	public function get_nominal_tutam_rsnd($jab, $gol){
		$sql = "SELECT nominal FROM kepeg_tb_nominal_tutam_rsnd WHERE id_jabatan = ".intval($jab)." AND id_golongan = ".intval($gol);
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			return $q->row()->nominal;
		}
		return 0;
	}

	public function get_data_tutam_rsnd(){
		$vSQL = "";
		// otomatis terpanggil
		$sql = "SELECT a.*, b.npwp FROM kepeg_tr_tutam_rsnd a LEFT JOIN kepeg_tb_pegawai b ON a.nip = b.nip WHERE a.tahun LIKE '".$_SESSION['tutam_rsnd']['tahun']."' AND a.bulan LIKE '".$_SESSION['tutam_rsnd']['bulan']."'".$vSQL." ORDER BY a.unit_id, a.golongan_id DESC";
		if($this->db->query($sql)->num_rows()){
			return $this->db->query($sql)->result();
		}
		return array();
	}

	public function manual_override(){
		$sql = "SELECT * FROM kepeg_tb_konfig";
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			return $q->row();
		}
		return 0;
	}

	public function get_status_override(){
		$o = $this->manual_override();
		if($o->manual_override == 1){
			return true;
		}
		return false;
	}

	public function get_status_upload(){
		$o = $this->manual_override();
		if($o->file_upload == 1){
			return true;
		}
		return false;
	}

	public function get_keterangan_override(){
		$o = $this->manual_override();
		if(strlen(trim($o->keterangan_override))>0){
			return $o->keterangan_override;
		}
		return "";
	}

	public function get_opsi_jenis_sppls($jenis=''){
		$sql = "SELECT * FROM kepeg_tb_jenis_sppls";
		$q = $this->db->query($sql)->result();
		$html = "<select class=\"form-control input-sm\" name=\"jenisSPPLSPeg\" id=\"jenisSPPLSPeg\">";
		foreach ($q as $k => $v) {
			$s = "";
			if($jenis == $v->jenis){ $s=" selected"; }
			$html.="<option value=\"".$v->jenis."\"".$s.">";
			$html.=$v->keterangan;
			$html.="</option>";
		}
		$html.="</select>";
		return $html;
	}

	public function get_ket_jenis_sppls($jenis){
		if(strlen(trim($jenis))>0 && strpos($jenis,'%')===false && strpos($jenis,'\\')===false){
			$sql = "SELECT keterangan FROM kepeg_tb_jenis_sppls WHERE jenis LIKE '".$jenis."'";
			$q = $this->db->query($sql);
			if($q->num_rows()>0){
				return $q->row()->keterangan;
			}
		}
		return '';
	}

	public function get_opsi_semester($id=0){
		$html = "<select name=\"semester\" id=\"semester\" class=\"form-control input-sm\">";
			foreach (array(array(1,'Ganjil'),array(2,'Genap')) as $k => $v) {
				$_s = "";
				if($id==$v[0]){
					$_s = " selected";
				}
				$html.= "<option value=\"".$v[0]."\"".$_s.">".$v[1]."</option>";
			}
		$html.= "</select>";
		return $html;
	}

	public function lspgw_autonumber($id_terakhir, $panjang_angka) {
    // $angka = str_replace('0','',$id_terakhir);
	$angka = $id_terakhir;
    $angka = intval($angka);
    $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
    // menggabungkan kode dengan nilang angka baru
    $id_baru = $angka_baru;
    return $id_baru;
  }

  public function addLSPegLog($id,$tabel,$jenis,$status){
    $q = $this->db->query("SELECT nomor FROM ".$tabel." WHERE id_".substr($tabel,-5)." = ".$id);
    if($q->num_rows()>0){
    	$dt = $q->row();
      $this->db->query("INSERT INTO kepeg_tr_lspeg_log(id_tr, nomor_tr, tabel_tr, jenis_tr, status_tr, waktu_tr) VALUES('".$id."', '".$dt->nomor."', '".$tabel."', '".$jenis."', '".$status."', NOW())");
    }
  }

  public function update_rsa_detail_belanja($akun='', $kode='32'){
  	$sql = "UPDATE `rsa_detail_belanja_` SET `proses` = '".$kode."', `tanggal_transaksi` = NOW() WHERE `kode_usulan_belanja` LIKE '".substr($akun,0,24)."' AND `kode_akun_tambah` LIKE '".substr($akun,-3)."'";
  	$this->db->query($sql);
  }

	public function insert_do_sppls($dt){
		$sql = "SELECT nomor FROM kepeg_tr_sppls WHERE unitsukpa LIKE '".$_SESSION['rsa_kode_unit_subunit']."' ORDER BY nomor DESC LIMIT 0,1";
		$q = $this->db->query($sql);
		if($q->num_rows()<=0){
			$nomor = '0001';
		}else{
			$nomor = $this->cantik_model->lspgw_autonumber($q->row()->nomor,4);
		}
		$cur_tahun = $dt['tahun'];
		$cur_bulan = $this->cantik_model->wordMonthShort(date('m'));
		$alias = $this->check_session->get_alias();
		$_nomor = $nomor."/".$alias."/SPP-LS PGW/".strtoupper($cur_bulan)."/".$cur_tahun;
		$_tanggal = date('Y-m-d');
		// $_sukpa = $_SESSION['rsa_nama_unit'];
		if(strlen(trim($_SESSION['rsa_kode_unit_subunit']))>2){
			$_sukpa = get_h_unit(substr($_SESSION['rsa_kode_unit_subunit'],0,2) ). ' - ' . get_h_subunit($_SESSION['rsa_kode_unit_subunit']) ;
		}else{
			$_sukpa = get_h_unit(substr($_SESSION['rsa_kode_unit_subunit'],0,2) ) ;
		}
		if(strlen($_SESSION['rsa_kode_unit_subunit'])==2){
			$_unit_kerja = $_sukpa ; //$_SESSION['rsa_nama_unit'];
		}else{
			// $_unit_kerja = get_pa_warek($_SESSION['rsa_kode_unit_subunit'])." - ".$_SESSION['rsa_nama_unit'];
			$_unit_kerja = $_sukpa ; //$_SESSION['rsa_nama_unit'];
		}
		$_kode_uk = $_SESSION['rsa_kode_unit_subunit'];
		$sql = "SELECT volume, harga_satuan, kode_usulan_belanja, kode_akun_tambah, deskripsi FROM rsa_detail_belanja_ WHERE id_rsa_detail!=0";
		$sql_ =array();
		foreach ($dt['akun'] as $k => $v) {
			$sql_[] = "(kode_usulan_belanja LIKE '".substr($v,0,24)."' AND kode_akun_tambah LIKE '".substr($v,-3)."')";
		}
		$sql_ = implode(" OR ",$sql_);
		$sql.=" AND (".$sql_.")";
		// echo $sql; exit;
		$q = $this->db->query($sql);
		if($q->num_rows()<=0){
			return $this->cantik_model->msgGagal("Kode akun dpa tidak dikenali");
		}
		$_total_sumberdana = 0;
		$_jumlah_bayar = 0;
		$_pajak = intval(str_replace(".", "", $dt['pajak']));
		$_potongan_pajak = intval(str_replace(".", "", $dt['potongan_pajak']));
		$_potongan = intval(str_replace(".", "", $dt['potongan']));
		$_untuk_bayar = array();
		foreach ($q->result() as $k => $v) {
			$_total_sumberdana += ($v->volume * $v->harga_satuan);
			$this->cantik_model->update_rsa_detail_belanja($v->kode_usulan_belanja.$v->kode_akun_tambah, '42');
			$_untuk_bayar[] = $v->deskripsi;
		}
		$_jumlah_bayar = $_total_sumberdana - ($_pajak + $_potongan + $_potongan_pajak);
		$CI = get_instance();
		$CI->load->model('user_model');
		$bpp = $CI->user_model->get_detail_rsa_user_by_username($_SESSION['rsa_username']);
		$_akun = implode(",",$dt['akun']);
		// masukkan ke dalam kepeg_tr_sppls
		$sql = "INSERT INTO kepeg_tr_sppls(nomor, tahun, tanggal, jumlah_bayar, total_sumberdana, jenissppls, detail_belanja, potongan, pajak, potongan_pajak, namabpsukpa, nipbpsukpa, unitsukpa, waktu_proses, penerima, alamat, rekening, npwp, nama_bank, status, sukpa, unit_kerja, kode_uk, untuk_bayar) VALUES ('".$_nomor."','".$dt['tahun']."', '".$_tanggal."', ".$_jumlah_bayar.", ".$_total_sumberdana.", '".$dt['jenisSPPLSPeg']."', '".$_akun."', '".$_potongan."', '".$_pajak."', '".$_potongan_pajak."', '".encodeText($bpp->nm_lengkap)."', '".encodeText($bpp->nomor_induk)."', '".$bpp->kode_unit_subunit."',NOW(), 'Terlampir', 'Jalan Prof. H. Soedarto, SH Tembalang Semarang', 'Terlampir', 'Terlampir', 'Terlampir', 'SPP dibuat Bendahara SUKPA', '".$_sukpa."', '".$_unit_kerja."', '".$_kode_uk."', '".encodeText(implode(" , ",$_untuk_bayar))."')";
		$this->db->query($sql);
    $id_sppls = $this->db->insert_id();
    // masukkan ke dalam kepeg_tr_sppls_daftar
    $sql = "INSERT INTO kepeg_tr_sppls_daftar VALUES('','".$id_sppls."', '".$dt['tahun']."', '".$dt['jenisSPPLSPeg']."', '".$_pajak."', '".$_potongan_pajak."', '".$_potongan."', '".$_total_sumberdana."', '".$_jumlah_bayar."', '".implode(",", $dt['unit_id'])."', '".implode(",", $dt['status'])."', '".$dt['jnspeg']."', '".$dt['bulan']."', '".$dt['semester']."', '".$_akun."', NOW(), NULL)";
    $this->db->query($sql);
    // masukkan ke dalam log
    $this->cantik_model->addLSPegLog($id_sppls, 'kepeg_tr_sppls', $dt['jenisSPPLSPeg'], 'SPP dibuat.');
    return $id_sppls;
	}

	// untuk melihat status yang ada pada SPP dan SPM
	public function get_status_form($proses=0, $jenis='spp'){
		$ac = array('', '', '', '', '');
		$j = 0;
		if($jenis == 'spp'){
			$j=0;
			for($i=0;$i<$proses;$i++){
				$ac[$i] = ' done';
				$j++;
			}
		}
		if($jenis == 'spm'){
			$j=0;
			for($i=0;$i<$proses;$i++){
				$ac[$i] = ' done';
				$j++;
			}
		}
		$ac[$j] = ' active';
		return $ac;
	}

	public function get_id_last_spm(){
		$sql = "SELECT nomor FROM kepeg_tr_spmls WHERE unitsukpa LIKE '".$_SESSION['rsa_kode_unit_subunit']."' ORDER BY nomor DESC LIMIT 0,1";
		$q = $this->db->query($sql);
		if($q->num_rows()<=0){
			$nomor = '0001';
		}else{
			$nomor = $this->cantik_model->lspgw_autonumber($q->row()->nomor,4);
		}
		return $nomor;
	}

	public function get_unit_verifikator($id){
		$sql = "SELECT kode_unit_subunit FROM rsa_verifikator_unit WHERE id_user_verifikator = ".intval($id);
		// echo $sql;exit;
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			return $q->result();
		}
		return null;
	}

	public function get_subkomponen($komp){
		$sql = "SELECT * FROM subkomponen_input WHERE kode_kegiatan LIKE '".substr($komp, 0, 2)."' AND kode_output LIKE '".substr($komp, 2, 2)."' AND kode_program LIKE '".substr($komp, 4, 2)."' AND kode_komponen LIKE '".substr($komp, 6, 2)."' AND kode_subkomponen LIKE '".substr($komp, 8, 2)."'";
		$q = $this->db2->query($sql);
		if($q->num_rows()>0){
			return $q->row()->nama_subkomponen;
		}
		return null;
	}

	public function update_spmls($field = '', $value='', $id=0){
		$sql = "UPDATE kepeg_tr_spmls SET $field = '$value' WHERE id_spmls = ".$id;
		if($field!='' && $value!='' && $id>0 ){
			$this->db->query($sql);
			return true;
		}
		return false;
	}

	public function get_rekening_tutam($nip){
		$sql = "SELECT kelompok_bank, nmbank, nmpemilik, norekening FROM kepeg_tb_rekening a LEFT JOIN kepeg_tb_pegawai b ON a.pegawai_id = b.id WHERE jenisrek = 3 AND b.nip LIKE '".$nip."'";
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			return $q->row();
		}
		$sql = "SELECT kelompok_bank, nmbank, nmpemilik, norekening FROM kepeg_tb_rekening a LEFT JOIN kepeg_tb_pegawai b ON a.pegawai_id = b.id WHERE jenisrek = 2 AND b.nip LIKE '".$nip."'";
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			return $q->row();
		}
	}

	public function get_rekening_by_id($pegawai_id, $jenisrek){
		$sql = "SELECT kelompok_bank, nmbank, nmpemilik, norekening FROM kepeg_tb_rekening WHERE pegawai_id = ".$pegawai_id." AND jenisrek = ".$jenisrek;
		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			return $q->row();
		}
		return null;
	}

  public function set_persentase_ikw($jam=0,$komposisi=0){
    // $sql = "SELECT * FROM ";
    if(isset($_SESSION['ikw']['jnspeg']) && $_SESSION['ikw']['jnspeg']==2){
      if($jam>=851){
        return 1;
      }elseif($jam>=801 && $jam <=850){
        return .9;
      }elseif($jam>=761 && $jam <= 800){
        return .8;
      }elseif($jam>=740 && $jam <= 760){
        return .75;
      }else{
        return 0;
      }
    }else{
      if($jam>=16 && $komposisi == 1){
        return 1;
      }elseif($jam>=12 && $jam <16 && $komposisi == 1){
        return ($jam/16);
      }elseif($jam>=16 && $komposisi == 2){
        return .85;
      }elseif($jam>=12 && $jam <16 && $komposisi == 2){
        return ($jam/16);
      }else{
        return 0;
      }
    }
  }

  // ========================================= UNTUK IKK INSENTIF KELEBIHAN ++++++++++++++++++++++++++++++++++++//
  public function get_data_pegawai_ikk($v){
    $vSQL = "";
    if(is_array($v)){
      if(isset($v['tahun']) && isset($v['sms'])){
        $thnsms = $v['tahun'].$v['sms'];
        $vSQL.=" AND a.thnskp LIKE '".$thnsms."'";
      }
      if(isset($v['unit_id'])){
        $vSQL.=" AND a.fak LIKE '".$v['unit_id']."'";
      }
    }
    $sql = "SELECT a.thnskp, a.id_dosen, d.nama, d.nip, SUM(a.kinerja * b.tarif) AS total_dapat, dtp.komposisi, dtp.sks_ikw, d.unit_id, a.fak, a.status, e.posisi_penetapan
            FROM tb_penetapan_ikk a LEFT JOIN tb_tarif b ON a.id_tarif = b.id_tarif
            LEFT JOIN (SELECT id_dosen, komposisi, sks_ikw FROM dt_penetapan WHERE thnskp LIKE '20171' GROUP BY id_dosen) dtp ON a.id_dosen = dtp.id_dosen
            LEFT JOIN tb_pegawai d ON a.id_dosen = d.id
            LEFT JOIN dt_ikk e ON (e.id_dosen = a.id_dosen AND e.unit1 = a.fak)
            WHERE a.status = 1 AND e.posisi_penetapan = 2 ".$vSQL."
            GROUP BY a.id_dosen
            ORDER BY total_dapat, a.id_dosen";
            // return $sql;
    $skp = $this->load->database('skp', TRUE);
    $q = $skp->query($sql);
    if($q->num_rows()>0){
      return $q->result();
    }
    return null;
  }
  public function get_kode_kepeg_unit($kode){
    $sql="SELECT * FROM rsa_unit WHERE kode_unit_rba LIKE '".$kode."'";
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      return $q->row()->kode_unit_kepeg;
    }
    return 0;
  }
  public function get_nama_unit_kepeg($kode){
    $sql="SELECT * FROM `kepeg_unit` WHERE `id` LIKE '".$kode."'";
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      return $q->row()->unit;
    }
    return 0;
  }
  public function get_data_ikk(){
		if(isset($_SESSION['ikk_dosen'])){
			$vSQL = "";
			if(isset($_SESSION['ikk_dosen']['tahun'])){
				$vSQL.= " AND tahun LIKE '".$_SESSION['ikk_dosen']['tahun']."'";
			}
			if(isset($_SESSION['ikk_dosen']['sms'])){
				$vSQL.= " AND sms LIKE '".$_SESSION['ikk_dosen']['sms']."'";
			}
      if(isset($_SESSION['ikk_dosen']['unit_id'])){
				$vSQL.= " AND fk_fak LIKE '".$_SESSION['ikk_dosen']['unit_id']."'";
			}
			// otomatis terpanggil
			$sql = "SELECT * FROM kepeg_tr_ikk_dosen WHERE id != 0".$vSQL." ORDER BY fk_unit, total_dapat, fk_id_dosen";
      // echo $sql; exit;
      $q = $this->db->query($sql);
			if($q->num_rows()>0){
				return $q->result();
			}
			return null;
		}
    return null;
	}
  public function showkomposisi($kom, $sks){
    $kom = intval($kom);
    $msg = "";
    if($kom == 0){
      $msg.= "belum disetujui pimpinan.";
    }else
    if($kom == 1){
      $msg.= "sesuai komposisi.";
    }else
    if($kom == 2){
      $msg.= "tidak sesuai komposisi.";
    }
    if($sks < 16){
      $msg.= "<br/>(< 16 SKS)";
    }elseif($sks >= 16){
      $msg.= "<br/>(>= 16 SKS)";
    }
    return $msg;
  }
  // ========================================= END HERE - IKK INSENTIF KELEBIHAN ++++++++++++++++++++++++++++++++++++//
}
?>
