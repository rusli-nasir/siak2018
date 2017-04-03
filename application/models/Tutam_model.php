<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tutam_model extends CI_Model {
/* -------------- Constructor ------------- */
  public $db2;
  public $_maxPage = 0;
  public function __construct()
  {
    // Call the CI_Model constructor
    parent::__construct();
    $this->db2 = $this->load->database('rba', TRUE);
    $this->_maxPage = 25;
    // pre status
    if(!isset($_SESSION['tutam']['status'])){
      $_SESSION['tutam']['status'] = array(1,3,6,12);
    }
  }

  public function daftar_pegawai(){
    $vSQL = "";
    $vLimit = " LIMIT 0,".$this->_maxPage;
    if(isset($_SESSION['tutam'])){
      if(isset($_SESSION['tutam']['status']) && count($_SESSION['tutam']['status'])>0){
        foreach ($_SESSION['tutam']['status'] as $k => $v) {
          $vStatus[]= " status = ".$v;
        }
        $vSQL .= " AND (".implode(" OR ",$vStatus).")";
      }
      if(isset($_SESSION['tutam']['unit_id']) && count($_SESSION['tutam']['unit_id'])>0){
        foreach ($_SESSION['tutam']['unit_id'] as $k => $v) {
          $vStatus[]= " unit_id LIKE '".$v."'";
        }
        $vSQL .= " AND (".implode(" OR ",$vStatus).")";
      }
      // untuk limit pages
      if(isset($_SESSION['tutam']['page'])){
        $vLimit = " LIMIT ".((intval($_SESSION['tutam']['page'])-1)*$this->_maxPage).",".$this->_maxPage;
      }
    }
    $sql = "SELECT a.`id`, a.`nama`, a.`nip`, a.`jabatan_id`, a.`golongan_id`, a.`status`, a.`jnspeg`, a.`npwp`, COUNT(c.id) AS jum_tgs_tambahan FROM kepeg_tb_pegawai a LEFT JOIN kepeg_tb_jabatan b ON a.jabatan_id = b.id LEFT JOIN kepeg_tb_riwayat_tgs_tambahan c ON a.id = c.pegawai_id WHERE a.id != 0 AND (a.status_kepeg LIKE '1' OR a.status_kepeg LIKE '2' OR a.status_kepeg LIKE '3') AND c.status_aktif = 1 ".$vSQL." GROUP BY a.id ORDER BY a.golongan_id".$vLimit;
    $q = $this->db->query($sql);
    if($q->num_rows()<=0){
      return 0;
    }else{
      // return $sql;
      return $q->result();
    }
  }

  public function jumlah_pegawai(){
    $vSQL = "";
    $vLimit = " LIMIT 0,".$this->_maxPage;
    if(isset($_SESSION['tutam'])){
      if(isset($_SESSION['tutam']['status']) && count($_SESSION['tutam']['status'])>0){
        foreach ($_SESSION['tutam']['status'] as $k => $v) {
          $vStatus[]= " status = ".$v;
        }
        $vSQL .= " AND (".implode(" OR ",$vStatus).")";
      }
      if(isset($_SESSION['tutam']['unit_id']) && count($_SESSION['tutam']['unit_id'])>0){
        foreach ($_SESSION['tutam']['unit_id'] as $k => $v) {
          $vStatus[]= " unit_id LIKE '".$v."'";
        }
        $vSQL .= " AND (".implode(" OR ",$vStatus).")";
      }
      // untuk limit pages
      if(isset($_SESSION['tutam']['page'])){
        $vLimit = " LIMIT ".((intval($_SESSION['tutam']['page'])-1)*$this->_maxPage).",".$this->_maxPage;
      }
    }
    $sql = "SELECT a.`id`, a.`nama`, a.`nip`, a.`jabatan_id`, a.`golongan_id`, a.`status`, a.`jnspeg`, a.`npwp`, COUNT(c.id) AS jum_tgs_tambahan FROM kepeg_tb_pegawai a LEFT JOIN kepeg_tb_jabatan b ON a.jabatan_id = b.id LEFT JOIN kepeg_tb_riwayat_tgs_tambahan c ON a.id = c.pegawai_id WHERE a.id != 0 AND (a.status_kepeg LIKE '1' OR a.status_kepeg LIKE '2' OR a.status_kepeg LIKE '3') AND c.status_aktif = 1 ".$vSQL." GROUP BY a.id ORDER BY a.golongan_id".$vLimit;
    $q = $this->db->query($sql);
    if($q->num_rows()<=0){
      return 0;
    }else{
      return $q->num_rows();
    }
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
			'12'=>'Tugas Belajar');
		return $stt[$status];
	}

  public function getJenisPeg($jns){
		$array = array(1=>'Dosen', 2=>'Tendik');
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
		$sql = "SELECT * FROM kepeg_unit";
		$data = $this->db->query($sql)->result();
		$html = "";
		foreach ($data as $key => $value) {
			$s="";
			if($value->id==$unit){ $s = " selected"; }
			$html.= "<option value=\"".$value->id."\"".$s.">".$value->unit."</option>";
		}
		return $html;
	}

	public function getUnit($unit){
		$sql = "SELECT unit FROM kepeg_unit WHERE id =".intval($unit);
		$data = $this->db->query($sql)->row();
		return $data->unit;
	}

  public function getBulanOption($dpilih){
		$selected=array("","","","","","","","","","","","");
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
			default : $selected[11]="selected=\"selected\"";break;
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
	    <option value=\"12\" ".$selected[11].">Desember</option>";
	}

  public function daftar_unit_kepeg(){
    $sql = "SELECT * FROM kepeg_unit";
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      return $q->result();
    }
    return 0;
  }
}
?>
