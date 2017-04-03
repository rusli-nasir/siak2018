<?php

	function ambilGajiSetup($peg,$kat,$pend){
		$sql = "SELECT jumlah FROM kepeg_tr_gaji_setup WHERE jns_pegawai LIKE '".$peg."' AND kategori LIKE '".$kat."' AND jenis LIKE '".$pend."'";
		$row = getRow($sql);
		if($row==0){
			return 0;
		}
		$data = getdata($sql);
		return $data['jumlah'];
	}

	function tunjanganBLU($nominal,$jns){
		if(strlen(trim($jns))>0){
			switch($jns){
				case 'suami' :
					$jumlah = ambilGajiSetup('BLU','TUNJANGAN',$jns);
					return ceil(($nominal*$jumlah)/100);
				break;
				case 'istri' :
					$jumlah = ambilGajiSetup('BLU','TUNJANGAN',$jns);
					return ceil(($nominal*$jumlah)/100);
				break;
				case 'anak' :
					$jumlah = ambilGajiSetup('BLU','TUNJANGAN',$jns);
					return ceil(($nominal*$jumlah)/100);
				break;
				case 'beras' :
					$jumlah = ambilGajiSetup('BLU','TUNJANGAN',$jns);
					return $jumlah;
				break;
			}
		}
		return 0;
	}

	function tunjanganBLUSuami($nominal){
		return tunjanganBLU($nominal,'suami');
	}

	function tunjanganBLUIstri($nominal){
		return tunjanganBLU($nominal,'istri');
	}

	function tunjanganBLUAnak($jum, $nominal){
		return $jum * tunjanganBLU($nominal,'anak');
	}

	function tunjanganBLUBeras($nominal){
		return tunjanganBLU($nominal,'beras');
	}

	function uangMakanBLU($hari,$pend){
		return $hari * ambilGajiSetup('BLU','UM',$pend);
	}

	function uangMakanKontrak($hari,$pend){
		return $hari * ambilGajiSetup('KONTRAK','UM',$pend);
	}

	function gajiKontrak($pend){
		$pend = getPend($pend);
		return ambilGajiSetup('KONTRAK','GAPOK',$pend);
	}

	function getPend($pend){
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

	function gajiBLU($mkth, $gol){
		if(is_numeric($mkth) && is_numeric($gol) && isExist($gol,'kepeg_tb_golongan','id')){
			$sql = "SELECT gaji FROM kepeg_tb_gapok WHERE id_gol = ".intval($gol)." AND mk = ".intval($mkth);
			$row = getRow($sql);
			if($row==0){
				return 0;
			}
			$data = getdata($sql);
			return $data['gaji'];
		}
		return 0;
	}

	function getUnitOption($unit){
		$sql = "SELECT * FROM kepeg_unit";
		$data = getdatadb($sql);
		foreach ($data as $key => $value) {
			$s="";
			if($value['id']==$unit){ $s = " selected"; }
			echo "<option value=\"".$value['id']."\"".$s.">".$value['unit']."</option>";
		}
	}

	function getUnit($unit){
		$sql = "SELECT unit FROM kepeg_unit WHERE id =".intval($unit);
		$data = getdata($sql);
		return $data['unit'];
	}

	function getStatusKepegOption($status){
		$data = array(array('id'=>2,'nama'=>'Pegawai Tetap Non PNS (BLU)'), array('id'=>4,'nama'=>'KONTRAK'));
		foreach ($data as $key => $value) {
			$s="";
			if($value['id']==$status){ $s = " selected"; }
			echo "<option value=\"".$value['id']."\"".$s.">".$value['nama']."</option>";
		}
	}

	function getStatusKepeg($status){
		$data = array(2=>'Pegawai Tetap Non PNS (BLU)',4=>'KONTRAK');
		return $data[$status];
	}

	function getBulanOption($dpilih){
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
		<option value=\"1\" ".$selected[0].">januari</option>
	    <option value=\"2\" ".$selected[1].">februari</option>
	    <option value=\"3\" ".$selected[2].">maret</option>
	    <option value=\"4\" ".$selected[3].">april</option>
	    <option value=\"5\" ".$selected[4].">mei</option>
	    <option value=\"6\" ".$selected[5].">juni</option>
	    <option value=\"7\" ".$selected[6].">juli</option>
	    <option value=\"8\" ".$selected[7].">agustus</option>
	    <option value=\"9\" ".$selected[8].">september</option>
	    <option value=\"10\" ".$selected[9].">oktober</option>
	    <option value=\"11\" ".$selected[10].">november</option>
	    <option value=\"12\" ".$selected[11].">desember</option>";
	}

	function getStatus($status){
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

	function msgSukses($m){
		return "<div class=\"alert alert-success alert-dismissible text-center\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"glyphicon glyphicon-lamp\"></i>&nbsp;&nbsp;".$m."</div>";
	}
	function msgGagal($m){
		return "<div class=\"alert alert-danger alert-dismissible text-center\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"glyphicon glyphicon-alert\"></i>&nbsp;&nbsp;".$m."</div>";
	}

	if(isset($_GET['page']) && strlen(trim($_GET['page']))>0){
		if(file_exists($_CONFIG['folder'].$_GET['page']."/db.php")){
			require_once $_CONFIG['folder'].$_GET['page']."/db.php";
		}
	}

?>
