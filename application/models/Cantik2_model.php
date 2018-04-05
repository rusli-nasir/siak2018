<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cantik2_model extends CI_Model {
/* -------------- Constructor ------------- */
  public $db2;
  public $_maxPage = 0;
	public $rek_gaji;
	public $rek_tunj;
  public $cm;
  public function __construct()
  {
    // Call the CI_Model constructor
    parent::__construct();
    $this->skp = $this->load->database('skp', TRUE);
    $this->eduk = $this->load->database('eduk', TRUE);
    $this->rba = $this->load->database('rba', TRUE);

    $this->cm =& get_instance();
    $this->load->model('cantik_model');

    $this->_maxPage = 25;
		$this->rek_tunj = 2;
		$this->rek_gaji = 1;
  }

  public function searchForId($id, $array) {
    foreach ($array as $key => $val) {
       if ($val['nominal'] === $id) {
           return $key;
       }
    }
    return null;
  }

  // unit Kepeg // ambil langsung dari database sugik
  public function getUnitList($unit=array()){
		$sql = "SELECT * FROM tb_unit";
		$data = $this->eduk->query($sql)->result();
		$html = "";
    // untuk data
		// if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='42' || substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='91'){
			foreach ($data as $key => $value) {
				$s="";
				if(is_array($unit) && count($unit)>0 && in_array($value->id,$unit)){ $s = " checked"; }
        // if( substr($_SESSION['rsa_kode_unit_subunit'],0,2)=='18' && $value->id!=$this->get_kode_kepeg_unit(substr($_SESSION['rsa_kode_unit_subunit'],0,2)) ){
        //   continue;
        // }
				$html.= "<div class=\"col-md-2 small\" style=\"background:#eee;border:1px solid #fff;\"><label style=\"margin:0;\"><input type=\"checkbox\" class=\"unit_id\" name=\"unit_id[]\" value=\"".$value->id."\"".$s.">&nbsp;".$value->unit_short."</label></div>";
			}
		// }else{
		// 	foreach ($data as $key => $value) {
		// 		$s=" disabled=\"disabled\"";
		// 		$t="";
		// 		$c="";
		// 		if(((is_array($unit) && count($unit)==1 && $value->id == $unit[0]) || (!is_array($unit)) && $value->id == $unit)){ $c=" checked=\"checked\""; $s = ""; $t = " class=\"unit_id\" name=\"unit_id[]\" value=\"".$value->id."\"";
		// 			$html.= "<div class=\"col-md-2 small\"><label><input type=\"checkbox\"".$t.$s.$c.">&nbsp;".$value->unit_short."</label></div>";
		// 		}
		// 	}
		// }
		return $html;
	}

  public function addnol($str){
    if(strlen(trim($str))==1){
      return '0'.$str;
    }
    return $str;
  }

  public function getStatusList($status=array()){
    $html = "";
    $stt = array();
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
    	'12'=>'Tugas Belajar DN',
    	'13'=>'Diberhentikan Sementara',
    	'14'=>'Tugas Belajar LN',
    	'15'=>'Pembinaan Pegawai'
    );
    foreach ($stt as $k => $v) {
      $ch = "";
      if(isset($status) && in_array($k,$status)){
        $ch = " checked = \"checked\"";
      }
      $html.= "
      <div class=\"small col-md-3 col-sm-6 col-xs-12\">
        <label>
          <input type=\"checkbox\" class=\"status\" name=\"status[]\" id=\"status\" value=\"".$k."\"".$ch."/>
          ".$v."
        </label>
      </div>
      ";
    }
    return $html;
  }

  public function getJabatanPeg($id=0){
    $sql = "SELECT jabatan FROM tb_jabatan a LEFT JOIN tb_pegawai b ON a.id = b.jabatan_id WHERE b.id = '".$id."'";
    $q = $this->eduk->query($sql);
    if($q->num_rows()>0){
      return $q->row()->jabatan;
    }
    return "-";
  }

  public function getJenisPegawai($jns=''){
    $html = "<select name=\"jnspeg\" id=\"jnspeg\" class=\"form-control input-sm\">";
    $_jenispeg = array(array(1,'Dosen Pengajar'),array(2,'Tenaga Kependidikan'));
    foreach ($_jenispeg as $k => $v) {
      $_s = "";
      if(isset($jns) && $jns==$v[0]){
        $_s = " selected";
      }
      $html.= "<option value=\"".$v[0]."\"".$_s.">".$v[1]."</option>";
    }
    $html.="</select>";
    return $html;
  }

  public function get_data_pegawai_id($id=0){
    $sql = "SELECT * FROM tb_pegawai a LEFT JOIN tb_rekening b ON a.id = b.pegawai_id WHERE a.id = '".$id."' AND b.jenisrek = 2";
    $q = $this->eduk->query($sql);
    if($q->num_rows()>0){
      return (array)$q->row();
    }
    return null;
  }

  //===================SQL UMUM//============//
  public function get_total_row($k=''){
    if(isset($_SESSION[$k])){
      $sql = "SELECT id FROM tb_pegawai WHERE jnspeg = ".intval($_SESSION[$k]['jnspeg']);
  		if(isset($_SESSION[$k]['status_kepeg']) && is_array($_SESSION[$k]['status_kepeg']) && count($_SESSION[$k]['status_kepeg'])>1){
  			$sql.= " AND ( `status_kepeg` = ".implode(" OR status_kepeg = ", $_SESSION[$k]['status_kepeg']).")";
  		}elseif(isset($_SESSION[$k]['status_kepeg']) && is_array($_SESSION[$k]['status_kepeg']) && count($_SESSION[$k]['status_kepeg'])==1){
  			$sql.= " AND `status_kepeg` = ".$_SESSION[$k]['status_kepeg'][0];
  		}
  		if(isset($_SESSION[$k]['unit_id']) && is_array($_SESSION[$k]['unit_id']) && count($_SESSION[$k]['unit_id'])>1){
  			$sql.= " AND ( `unit_id` = ".implode(" OR unit_id = ", $_SESSION[$k]['unit_id']).")";
  		}elseif(isset($_SESSION[$k]['unit_id']) && is_array($_SESSION[$k]['unit_id']) && count($_SESSION[$k]['unit_id'])==1){
  			$sql.= " AND `unit_id` = ".$_SESSION[$k]['unit_id'][0];
  		}
  		if(isset($_SESSION[$k]['status']) && is_array($_SESSION[$k]['status']) && count($_SESSION[$k]['status'])>1){
  			$sql.= " AND ( `status` = ".implode(" OR status = ", $_SESSION[$k]['status']).")";
  		}elseif(isset($_SESSION[$k]['status']) && is_array($_SESSION[$k]['status']) && count($_SESSION[$k]['status'])==1){
  			$sql.= " AND `status` = ".$_SESSION[$k]['status'][0];
  		}
  		// echo $sql; exit;
  		return $this->eduk->query($sql)->num_rows();
    }
    return 0;
  }

  //============================// untuk GET kalimat //============================//

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

  public function get_unit_rba($unit){
    $sql = "SELECT alias,nama_unit FROM unit WHERE kode_unit ='".substr($unit,0,2)."'";
    $data = $this->rba->query($sql)->row();
    return (array) $data;
  }

  public function nama_unit_kepeg_rba($unit){
    $sql = "SELECT alias,nama_unit FROM unit WHERE kode_unit ='".substr($unit,0,2)."'";
    $data = $this->rba->query($sql)->row();
    return $data->nama_unit;
  }

  public function get_kode_kepeg_unit($kode){
    $sql="SELECT * FROM rsa_unit WHERE kode_unit_rba LIKE '".$kode."%'";
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      return $q->row()->kode_unit_kepeg;
    }
    return 0;
  }

  public function get_subunit_rba($unit){
    $sql = "SELECT nama_subunit FROM subunit WHERE kode_subunit ='".substr($unit,0,4)."'";
    $data = $this->rba->query($sql)->row();
    return $data->nama_subunit;
  }

  public function getStatusKepeg($status){
		$data = array(1=>'Pegawai Negeri Sipil',3=>'Calon Pegawai Negeri Sipil',2=>'Pegawai Tetap Non PNS (BLU)',4=>'Tenaga Kontrak');
		return $data[$status];
	}

  public function getStatus($status){
    $stt = array();
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
    	'12'=>'Tugas Belajar DN',
    	'13'=>'Diberhentikan Sementara',
    	'14'=>'Tugas Belajar LN',
    	'15'=>'Pembinaan Pegawai'
    );
		return $stt[$status];
	}

  public function opsiStatus($name='',$id='',$class='',$rel='',$check=''){
    // $stt = array();
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
      '12'=>'Tugas Belajar DN',
      '13'=>'Diberhentikan Sementara',
      '14'=>'Tugas Belajar LN',
      '15'=>'Pembinaan Pegawai'
    );
    $html = "<select name='".$name."' id='".$id."' class='".$class."' rel='".$rel."'>";
    foreach ($stt as $k => $v) {
      $c="";
      if($k == $check){ $c=" selected"; }
      $html.="<option value='".$k."'".$c.">".$v."</option>";
    }
    $html.= "</select>";
    return $html;
  }

  public function opsiGolongan($name='',$id='',$class='',$rel='',$check=''){
    $sql = "SELECT * FROM tb_golongan";
    $html = "<select name='".$name."' id='".$id."' class='".$class."' rel='".$rel."'>";
    foreach ($this->eduk->query($sql)->result() as $k => $v) {
      $c="";
      if($v->id == $check){ $c=" selected"; }
      if($v->id == 0){ $v->gol = "-"; $v->pangkat = "-"; }
      $html.="<option value='".$v->id."'".$c.">".$v->gol." (".$v->pangkat.")</option>";
    }
    $html.= "</select>";
    return $html;
  }

  public function get_golongan($v=""){
    $sql = "SELECT * FROM tb_golongan WHERE id = '".$v."' ";
    $q = $this->eduk->query($sql);
    if($q->num_rows()>0){
      return $q->row()->gol;
    }
    return null;
  }

  public function get_golongan_all($v=""){
    $sql = "SELECT * FROM tb_golongan WHERE id = '".$v."' ";
    $q = $this->eduk->query($sql);
    if($q->num_rows()>0){
      return (array)$q->row();
    }
    return null;
  }

  public function get_unit($k=''){
		$str = array();
		if(isset($_SESSION[$k]['unit_id']) && is_array($_SESSION[$k]['unit_id']) && count($_SESSION[$k]['unit_id'])>0){
			foreach($_SESSION[$k]['unit_id'] as $k => $v){
				$str[] = $this->getUnitShort($v);
			}
		}
		return implode(", ",$str);
	}

	public function get_status($k=''){
		$str = array();
		if(isset($_SESSION[$k]['status_kepeg']) && is_array($_SESSION[$k]['status_kepeg']) && count($_SESSION[$k]['status_kepeg'])>0){
			foreach($_SESSION[$k]['status_kepeg'] as $k => $v){
				$str[] = $this->getStatusKepeg($v);
			}
		}
		return implode(", ",$str);
	}

	public function get_status_kerja($k=''){
		$str = array();
		if(isset($_SESSION[$k]['status']) && is_array($_SESSION[$k]['status']) && count($_SESSION[$k]['status'])>0){
			foreach($_SESSION[$k]['status'] as $k => $v){
				$str[] = $this->getStatus($v);
			}
		}
		return implode(", ",$str);
	}

  public function getDataRekening($id, $kode){
    $sql = "SELECT * FROM tb_rekening WHERE pegawai_id = ".$id." AND jenisrek = ".$kode;
    $q = $this->eduk->query($sql);
    if($q->num_rows()<=0){
      if($kode==3){
        $kode = 2;
        $sql = "SELECT * FROM tb_rekening WHERE pegawai_id = ".$id." AND jenisrek = ".$kode;
        $q = $this->eduk->query($sql);
        if($q->num_rows()>0){
          return (array) $q->row();
        }
      }
      return null;
    }else{
      return (array) $q->row();
    }
  }
  //=============================// END // ================================//

  //============================== get data IKW ===========================//
  public function getDataIKW(){
    $vSQL = "";
    if(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])>1){
      $vSQL.= " AND ( a.`statuspeg` = ".implode(" OR a.`statuspeg` = ", $_SESSION['ikw']['status_kepeg']).")";
    }elseif(isset($_SESSION['ikw']['status_kepeg']) && is_array($_SESSION['ikw']['status_kepeg']) && count($_SESSION['ikw']['status_kepeg'])==1){
      $vSQL.= " AND a.`statuspeg` = ".$_SESSION['ikw']['status_kepeg'][0];
    }
    if(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])>1){
      $vSQL.= " AND ( a.`unitid` = ".implode(" OR a.`unitid` = ", $_SESSION['ikw']['unit_id']).")";
    }elseif(isset($_SESSION['ikw']['unit_id']) && is_array($_SESSION['ikw']['unit_id']) && count($_SESSION['ikw']['unit_id'])==1){
      $vSQL.= " AND a.`unitid` = ".$_SESSION['ikw']['unit_id'][0];
    }
    if(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])>1){
      $vSQL.= " AND ( a.`status` = ".implode(" OR a.`status` = ", $_SESSION['ikw']['status']).")";
    }elseif(isset($_SESSION['ikw']['status']) && is_array($_SESSION['ikw']['status']) && count($_SESSION['ikw']['status'])==1){
      $vSQL.= " AND a.`status` = ".$_SESSION['ikw']['status'][0];
    }
    if(isset($_SESSION['ikw']['tahun'])){
      $vSQL.= " AND a.`tahun` = ".$_SESSION['ikw']['tahun'];
    }
    if(isset($_SESSION['ikw']['bulan'])){
      $vSQL.= " AND a.`bulan` = ".$_SESSION['ikw']['bulan'];
    }
    $sql = "SELECT a.*, a.`netto` AS `byr_stlh_pajak` FROM kepeg_tr_ikw a WHERE a.fk_rsa_unit LIKE '".$_SESSION['rsa_kode_unit_subunit']."%' AND a.`jenispeg` = ".$_SESSION['ikw']['jnspeg'].$vSQL." ORDER BY a.id_trans";
    // echo $sql; exit;
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      return $q->result();
    }
    return null;
  }

  // ikw rsnd //
  function getIKWRSND($gol,$jabatan){
    $sql = "SELECT bruto FROM kepeg_tb_ikw_rsnd WHERE jabatan_id = ".intval($jabatan)." AND golongan_id = ".intval($gol);
    $jum = $this->db->query($sql);
    if($jum->num_rows()>0){
      $rsl = $jum->row();
      return $rsl->bruto;
    }
    return 0;
  }
  // end rsnd //
  //========================== end =============================//



  //=======================TUTAM=======================//
  public function get_data_pegawai_tutam(){
		$vSQL = "";
		// if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)!='42' && substr($_SESSION['rsa_kode_unit_subunit'],0,2)!='91'){
		// 	$unit = $this->cantik_model->get_unit_rba($_SESSION['rsa_kode_unit_subunit']);
		// 	$vSQL = " AND a.unit_id LIKE '".$unit[0]."'";
		// }
    // if(substr($_SESSION['rsa_kode_unit_subunit'],0,2)!='15' && substr($_SESSION['rsa_kode_unit_subunit'],0,2)!='25'){
		// 	$unit = $this->get_unit_rba($_SESSION['rsa_kode_unit_subunit'])['nama_unit'];
		// 	$vSQL = " AND a.unit_id LIKE '".$unit[0]."'";
		// }
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
		$sql =	"SELECT a.id, a.nama, a.nip, a.golongan_id, a.unit_id, a.status, a.npwp, d.gol, d.kelompok, b.tgs_tambahan_id, c.tugas_tambahan, b.det_tgs_tambahan
		FROM tb_pegawai a
		RIGHT JOIN tb_riwayat_tgs_tambahan b ON a.id = b.pegawai_id
		LEFT JOIN tb_tgs_tambahan c ON b.tgs_tambahan_id = c.id
		LEFT JOIN tb_golongan d ON a.golongan_id = d.id
		WHERE b.status_aktif = 1 AND (a.status = 1 OR a.status = 3 OR a.status = 6 OR a.status = 12 OR a.status = 13 OR a.status = 14) ".$vSQL." ORDER BY a.golongan_id, a.nip";
		// echo $sql; exit;
		$dt = $this->eduk->query($sql)->result();
		return $dt;
	}
  // get data IKW //
  public function getDataTutam(){
    $vSQL = "";

    if(isset($_SESSION['tutam']['tahun'])){
      $tahun = $_SESSION['tutam']['tahun'];
    }elseif(isset($_SESSION['tutam_mwa']['tahun'])){
      $tahun = $_SESSION['tutam_mwa']['tahun'];
    }elseif(isset($_SESSION['tutam_rsnd']['tahun'])){
      $tahun = $_SESSION['tutam_rsnd']['tahun'];
    }
    $vSQL.= " AND a.`tahun` = '".$tahun."'";
    
    if(isset($_SESSION['tutam']['bulan'])){
      $bulan = $_SESSION['tutam']['bulan'];
    }elseif(isset($_SESSION['tutam_mwa']['bulan'])){
      $bulan = $_SESSION['tutam_mwa']['bulan'];
    }elseif(isset($_SESSION['tutam_rsnd']['tahun'])){
      $bulan = $_SESSION['tutam_rsnd']['bulan'];
    }
    $vSQL.= " AND a.`bulan` = '".$bulan."'";

    $sql = "SELECT a.* FROM `kepeg_tr_tutam` a WHERE a.`fk_rsa_unit` LIKE '".$_SESSION['rsa_kode_unit_subunit']."%'".$vSQL." ORDER BY a.`nmbank`, a.`tgs_tambahan_id`";
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      return $q->result();
    }
    return null;
  }
  // end //
  // tutam mwa //
  public function get_data_tutam_mwa(){
    $sql = "SELECT * FROM kepeg_tb_tutam_mwa";
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      return $q->result();
    }
    return null;
  }
  public function update_data_tutam_mwa($p){
    $vF = "";
    if($p['field'] == 'golongan_id'){
      $vF = ", golpeg = '".$this->get_golongan($p['value'])."'";
    }
    $sql = "UPDATE kepeg_tb_tutam_mwa SET ".$p['field']." = '".$p['value']."'".$vF." WHERE id = '".$p['id']."'";
    // return $sql;
    // echo $this->cantik_model->msgGagal($sql);
    if($this->db->query($sql)){
      return $p['id'];
    }
    return $this->db->_error_message();
  }
  public function delete_data_tutam_mwa($p){
    $sql = "DELETE FROM kepeg_tb_tutam_mwa WHERE id = '".$p['id']."'";
    if($this->db->query($sql)){
      return $p['id'];
    }
    return $this->db->_error_message();
  }
  public function add_data_tutam_mwa($p){
    $g = $this->get_golongan_all($p['golongan_id']);
    if($g['kelompok'] == '4'){
      $pajak = .15;
    }elseif($g['kelompok'] == '3'){
      $pajak = .05;
    }else{
      $pajak = .15;
    }
    $p['nominal'] = str_replace('.', '', $p['nominal']);
    $p['nominal'] = str_replace(',', '.', $p['nominal']);
    $nom_pajak = ceil(intval($p['nominal'])*$pajak);
    $bersih = $p['nominal'] - $nom_pajak;
    $sql = "INSERT INTO `kepeg_tb_tutam_mwa` (`nama`, `pegid`, `nip`, `golongan_id`, `golpeg`, `unit_id`, `jabatan_id`, `status`, `kelompok`, `tgs_tambahan_id`, `tugas_tambahan`, `det_tgs_tambahan`, `npwp`, `nmbank`, `nmpemilik`, `norekening`, `nominal`, `pajak`, `nom_pajak`, `bersih`)
      VALUES ('".$this->cm->cantik_model->encodeText(addslashes($p['nama']))."', '".$p['pegid']."', '".$this->cm->cantik_model->encodeText(addslashes($p['nip']))."', '".$p['golongan_id']."', '".$g['gol']."', '".$p['unit_id']."', '".$p['jabatan_id']."', '".$p['status']."', '".$g['kelompok']."', '0', '".$p['tugas_tambahan']."', '".$p['det_tgs_tambahan']."', '".$p['npwp']."', '".$p['nmbank']."', '".$p['nmpemilik']."', '".$p['norekening']."', '".$p['nominal']."', '".$pajak."', '".$nom_pajak."', '".$bersih."')";
    if($this->db->query($sql)){
      // return $p['pegid'];
      return 1;
    }
    return $this->db->_error_message();
  }
  public function pegawai_data_tutam_mwa($t=''){
    $vSQL = "";
    if(strlen(trim($t))>0){
      $vSQL = " AND nama LIKE '%".$t."%'";
    }
    $sql =  "SELECT a.id, a.nama, a.glr_dpn, a.glr_blkg, a.nip, a.golongan_id, a.unit_id, a.status, a.npwp, b.gol, b.kelompok
    FROM tb_pegawai a
    LEFT JOIN tb_golongan b ON a.golongan_id = b.id
    WHERE (a.status = 1 OR a.status = 3 OR a.status = 6 OR a.status = 12 OR a.status = 13 OR a.status = 14) ".$vSQL." LIMIT 0,5";
    $q = $this->eduk->query($sql);
    if($q->num_rows()>0){
      $r = $q->result();
      $html = "<ul class=\"list_\">";
      foreach ($r as $k => $v) {
       $html.= "<li onclick=\"javascript:selectItem('".$v->id."');\" style=\"cursor:pointer;\">".$v->glr_dpn." ".$v->nama." ".$v->glr_blkg." (".$v->gol.")"."</li>";
      }
      $html.= "</ul>";
      return $html;
      // $json = array();
      // foreach ($r as $k => $v) {
      //   $json[] = array('id'=>$v->id, 'text'=>$v->glr_dpn." ".$v->nama." ".$v->glr_blkg." (".$v->gol.")");
      // }
      // return json_encode($json);
    }
    return null;
  }

  // end mwa //

  // tutam rsnd //
  public function get_data_tutam_rsnd(){
    $sql = "SELECT * FROM kepeg_tb_tutam_rsnd";
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      return $q->result();
    }
    return null;
  }
  public function update_data_tutam_rsnd($p){
    $vF = "";
    if($p['field'] == 'golongan_id'){
      $vF = ", golpeg = '".$this->get_golongan($p['value'])."'";
    }
    $sql = "UPDATE kepeg_tb_tutam_rsnd SET ".$p['field']." = '".$p['value']."'".$vF." WHERE id = '".$p['id']."'";
    // return $sql;
    // echo $this->cantik_model->msgGagal($sql);
    if($this->db->query($sql)){
      return $p['id'];
    }
    return $this->db->_error_message();
  }
  public function delete_data_tutam_rsnd($p){
    $sql = "DELETE FROM kepeg_tb_tutam_rsnd WHERE id = '".$p['id']."'";
    if($this->db->query($sql)){
      return $p['id'];
    }
    return $this->db->_error_message();
  }
  public function add_data_tutam_rsnd($p){
    $g = $this->get_golongan_all($p['golongan_id']);
    if($g['kelompok'] == '4'){
      $pajak = .15;
    }elseif($g['kelompok'] == '3'){
      $pajak = .05;
    }else{
      $pajak = .15;
    }
    $p['nominal'] = str_replace('.', '', $p['nominal']);
    $p['nominal'] = str_replace(',', '.', $p['nominal']);
    $nom_pajak = ceil(intval($p['nominal'])*$pajak);
    $bersih = $p['nominal'] - $nom_pajak;
    $sql = "INSERT INTO `kepeg_tb_tutam_rsnd` (`nama`, `pegid`, `nip`, `golongan_id`, `golpeg`, `unit_id`, `jabatan_id`, `status`, `kelompok`, `tgs_tambahan_id`, `tugas_tambahan`, `det_tgs_tambahan`, `npwp`, `nmbank`, `nmpemilik`, `norekening`, `nominal`, `pajak`, `nom_pajak`, `bersih`)
      VALUES ('".$this->cm->cantik_model->encodeText(addslashes($p['nama']))."', '".$p['pegid']."', '".$this->cm->cantik_model->encodeText(addslashes($p['nip']))."', '".$p['golongan_id']."', '".$g['gol']."', '".$p['unit_id']."', '".$p['jabatan_id']."', '".$p['status']."', '".$g['kelompok']."', '0', '".$p['tugas_tambahan']."', '".$p['det_tgs_tambahan']."', '".$p['npwp']."', '".$p['nmbank']."', '".$p['nmpemilik']."', '".$p['norekening']."', '".$p['nominal']."', '".$pajak."', '".$nom_pajak."', '".$bersih."')";
    if($this->db->query($sql)){
      // return $p['pegid'];
      return 1;
    }
    return $this->db->_error_message();
  }
  public function pegawai_data_tutam_rsnd($t=''){
    $vSQL = "";
    if(strlen(trim($t))>0){
      $vSQL = " AND nama LIKE '%".$t."%'";
    }
    $sql =  "SELECT a.id, a.nama, a.glr_dpn, a.glr_blkg, a.nip, a.golongan_id, a.unit_id, a.status, a.npwp, b.gol, b.kelompok
    FROM tb_pegawai a
    LEFT JOIN tb_golongan b ON a.golongan_id = b.id
    WHERE (a.status = 1 OR a.status = 3 OR a.status = 6 OR a.status = 12 OR a.status = 13 OR a.status = 14) ".$vSQL." LIMIT 0,5";
    $q = $this->eduk->query($sql);
    if($q->num_rows()>0){
      $r = $q->result();
      $html = "<ul class=\"list_\">";
      foreach ($r as $k => $v) {
       $html.= "<li onclick=\"javascript:selectItem('".$v->id."');\" style=\"cursor:pointer;\">".$v->glr_dpn." ".$v->nama." ".$v->glr_blkg." (".$v->gol.")"."</li>";
      }
      $html.= "</ul>";
      return $html;
    }
    return null;
  }

  // end rsnd //
  //-====================== END TUTAM ===============//

  //======================= IKK DOSEN ===============//

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
    $sql = "SELECT a.thnskp, a.id_dosen, SUM(a.kinerja * b.tarif) AS total_dapat, dtp.komposisi, dtp.sks_ikw, a.fak, a.status, e.posisi_penetapan
            FROM tb_penetapan_ikk a LEFT JOIN tb_tarif b ON a.id_tarif = b.id_tarif
            LEFT JOIN (SELECT id_dosen, komposisi, sks_ikw FROM dt_penetapan WHERE thnskp LIKE '".$thnsms."' GROUP BY id_dosen) dtp ON a.id_dosen = dtp.id_dosen
            LEFT JOIN dt_ikk e ON (e.id_dosen = a.id_dosen AND e.unit1 = a.fak)
            WHERE a.status = 1 AND e.posisi_penetapan = 2 ".$vSQL."
            GROUP BY a.id_dosen
            ORDER BY total_dapat, a.id_dosen";
    $q = $this->skp->query($sql);
    if($q->num_rows()>0){
      $r = array();
      $i = 0;
      foreach ($q->result() as $k => $v) {
        // $r[$i] = (array) $v;
        $r[$i] = $v;
        $sql = "SELECT CONCAT(glr_dpn,' ',nama,' ',glr_blkg) AS nama, nip, gol, kelompok, unit_id AS unit, unit_id FROM tb_pegawai a LEFT JOIN tb_golongan b ON a.golongan_id = b.id WHERE a.id = '".$v->id_dosen."'";
        $q2 = (array) $this->eduk->query($sql)->row();
        foreach ($q2 as $key => $value) {
          // $r[$i][$key] = $value;
          $r[$i]->$key = $value;
        }
        $i++;
      }
      return $r;
    }
    return null;
  }

  //======================= END =====================//

  //============================== get data IPP ===========================//
  public function getDataIPP(){
    $vSQL = "";
    if(isset($_SESSION['ipp']['status_kepeg']) && is_array($_SESSION['ipp']['status_kepeg']) && count($_SESSION['ipp']['status_kepeg'])>1){
      $vSQL.= " AND ( a.`statuspeg` = ".implode(" OR a.`statuspeg` = ", $_SESSION['ipp']['status_kepeg']).")";
    }elseif(isset($_SESSION['ipp']['status_kepeg']) && is_array($_SESSION['ipp']['status_kepeg']) && count($_SESSION['ipp']['status_kepeg'])==1){
      $vSQL.= " AND a.`statuspeg` = ".$_SESSION['ipp']['status_kepeg'][0];
    }
    if(isset($_SESSION['ipp']['unit_id']) && is_array($_SESSION['ipp']['unit_id']) && count($_SESSION['ipp']['unit_id'])>1){
      $vSQL.= " AND ( a.`unitid` = ".implode(" OR a.`unitid` = ", $_SESSION['ipp']['unit_id']).")";
    }elseif(isset($_SESSION['ipp']['unit_id']) && is_array($_SESSION['ipp']['unit_id']) && count($_SESSION['ipp']['unit_id'])==1){
      $vSQL.= " AND a.`unitid` = ".$_SESSION['ipp']['unit_id'][0];
    }
    if(isset($_SESSION['ipp']['status']) && is_array($_SESSION['ipp']['status']) && count($_SESSION['ipp']['status'])>1){
      $vSQL.= " AND ( a.`status` = ".implode(" OR a.`status` = ", $_SESSION['ipp']['status']).")";
    }elseif(isset($_SESSION['ipp']['status']) && is_array($_SESSION['ipp']['status']) && count($_SESSION['ipp']['status'])==1){
      $vSQL.= " AND a.`status` = ".$_SESSION['ipp']['status'][0];
    }
    if(isset($_SESSION['ipp']['tahun'])){
      $vSQL.= " AND a.`tahun` = ".$_SESSION['ipp']['tahun'];
    }
    if(isset($_SESSION['ipp']['bulan'])){
      $vSQL.= " AND a.`bulan` = ".$_SESSION['ipp']['bulan'];
    }
    $sql = "SELECT a.*, a.`netto` AS `byr_stlh_pajak` FROM kepeg_tr_ipp a WHERE a.fk_rsa_unit LIKE '".$_SESSION['rsa_kode_unit_subunit']."%' AND a.`jenispeg` = ".$_SESSION['ipp']['jnspeg'].$vSQL." ORDER BY a.`nmbank`, a.`unitid`, a.`golpeg` DESC, a.`nip`";
    // echo $sql; exit;
    $q = $this->db->query($sql);
    if($q->num_rows()>0){
      return $q->result();
    }
    return null;
  }

  public function hapusDataIPP(){
    $vSQL = "";
    if(isset($_SESSION['ipp']['status_kepeg']) && is_array($_SESSION['ipp']['status_kepeg']) && count($_SESSION['ipp']['status_kepeg'])>1){
      $vSQL.= " AND ( `statuspeg` = ".implode(" OR `statuspeg` = ", $_SESSION['ipp']['status_kepeg']).")";
    }elseif(isset($_SESSION['ipp']['status_kepeg']) && is_array($_SESSION['ipp']['status_kepeg']) && count($_SESSION['ipp']['status_kepeg'])==1){
      $vSQL.= " AND `statuspeg` = ".$_SESSION['ipp']['status_kepeg'][0];
    }
    if(isset($_SESSION['ipp']['unit_id']) && is_array($_SESSION['ipp']['unit_id']) && count($_SESSION['ipp']['unit_id'])>1){
      $vSQL.= " AND ( `unitid` = ".implode(" OR `unitid` = ", $_SESSION['ipp']['unit_id']).")";
    }elseif(isset($_SESSION['ipp']['unit_id']) && is_array($_SESSION['ipp']['unit_id']) && count($_SESSION['ipp']['unit_id'])==1){
      $vSQL.= " AND `unitid` = ".$_SESSION['ipp']['unit_id'][0];
    }
    if(isset($_SESSION['ipp']['status']) && is_array($_SESSION['ipp']['status']) && count($_SESSION['ipp']['status'])>1){
      $vSQL.= " AND ( `status` = ".implode(" OR `status` = ", $_SESSION['ipp']['status']).")";
    }elseif(isset($_SESSION['ipp']['status']) && is_array($_SESSION['ipp']['status']) && count($_SESSION['ipp']['status'])==1){
      $vSQL.= " AND `status` = ".$_SESSION['ipp']['status'][0];
    }
    if(isset($_SESSION['ipp']['tahun'])){
      $vSQL.= " AND `tahun` = ".$_SESSION['ipp']['tahun'];
    }
    if(isset($_SESSION['ipp']['bulan'])){
      $vSQL.= " AND `bulan` = ".$_SESSION['ipp']['bulan'];
    }
    $sql = "DELETE FROM kepeg_tr_ipp WHERE fk_rsa_unit LIKE '".$_SESSION['rsa_kode_unit_subunit']."%' AND `jenispeg` = ".$_SESSION['ipp']['jnspeg'].$vSQL;
    echo $sql; exit;
    if($this->db->query($sql)){
      return "1";
    }
    return null;
  }
  //========================== end =============================//

  //========================== Uang Kinerja Dosen ======================//

  public function get_data_pegawai_uk($v){
    $sql = "SELECT * FROM dt_uk WHERE thnskp LIKE '".$v['tahun'].$v['sms']."'";
    $q = $this->skp->query($sql);
    if($q->num_rows()>0){
      foreach ($q->result() as $key => $value) {
        $d[$key] = $value;
        $sql = "SELECT CONCAT(glr_dpn,' ',nama,' ',glr_blkg) AS nama, nip, golongan_id, gol, kelompok, npwp, status, unit_id FROM tb_pegawai a LEFT JOIN tb_golongan b ON a.golongan_id = b.id WHERE a.id = ".$value->id_dosen;
        $qr = $this->eduk->query($sql);
        if($qr->num_rows()>0){
          foreach ($qr->row() as $k => $v) {
            $d[$key]->$k = $v;
          }
        }
      }
      return $d;
    }
    return null;
  }
  public function get_data_uk(){
    if(isset($_SESSION['uk_dosen'])){
      $vSQL = "";
      if(isset($_SESSION['uk_dosen']['tahun'])){
        $vSQL.= " AND tahun LIKE '".$_SESSION['uk_dosen']['tahun']."'";
      }
      if(isset($_SESSION['uk_dosen']['sms'])){
        $vSQL.= " AND sms LIKE '".$_SESSION['uk_dosen']['sms']."'";
      }
      if(isset($_SESSION['uk_dosen']['unit_id'])){
        $vSQL.= " AND fk_fak LIKE '".$_SESSION['uk_dosen']['unit_id']."'";
      }
      // otomatis terpanggil
      $sql = "SELECT * FROM kepeg_tr_uk_dosen WHERE id != 0".$vSQL." ORDER BY fk_unit, netto, fk_id_dosen";
      // echo $sql; exit;
      $q = $this->db->query($sql);
      if($q->num_rows()>0){
        return $q->result();
      }
      return null;
    }
    return null;
  }

  //========================== end ============================//

}
?>
