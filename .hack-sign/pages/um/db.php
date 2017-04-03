<?php

	$_CONFIG['um']['order'] = " ORDER BY a.unitid, a.nip";

	function showDialogProsesUangMakan($data){
		$unit = "seluruh unit Undip";
		$sql = "SELECT nip, nama FROM kepeg_tb_pegawai WHERE status_kepeg = ".intval($data['status_kepeg']);
		if(is_numeric($data['unit_id']) && isExist($data['unit_id'],'kepeg_unit','id')){
			$sql.=" AND unit_id = ".intval($data['unit_id']);
			$unit = "unit ".getUnit($data['unit_id']);
		}
		if(isset($_SESSION['um']['proses']['status']) && is_array($_SESSION['um']['proses']['status']) && count($_SESSION['um']['proses']['status'])>1){
			$sql.= " AND ( status = ".implode(" OR status = ", $_SESSION['um']['proses']['status']).")";
		}elseif(isset($_SESSION['um']['proses']['status']) && is_array($_SESSION['um']['proses']['status']) && count($_SESSION['um']['proses']['status'])==1){
			$sql.= " AND status = ".$_SESSION['um']['proses']['status'][0];
		}
		$row=getRow($sql);
		$aksi = "";
		$html = "<div class=\"callout\">
			<h4><i class=\"fa fa-bullhorn\"></i>&nbsp;&nbsp;Informasi Proses Data Uang Makan</h4>
			<p>&nbsp;</p>
			<p>Jumlah Pegawai <strong>".getStatusKepeg($data['status_kepeg'])."</strong> yang terdaftar di <strong>".$unit."</strong> melalui proses ini adalah <strong>$row</strong> orang.</p>";
		if($row > 0){
			if(isset($data['status'])){
				$data['status'] = implode(";",$data['status']);
			}
			$aksi = "<button type=\"button\" onclick=\"javascript:\$.post('".$GLOBALS['path']."/process.php',{'page':'um','act':'um_proses2','data':'".implode(",",$data)."'},function(data){ if(data!='1'){\$('.result_data').html(data);}else{window.location.reload();} });\" class=\"btn btn-primary btn-flat btn-sm\"><i class=\"fa fa-spinner\"></i>&nbsp;&nbsp;&nbsp;Proses Daftar Uang Makan</button>";
			$html.="<p>Klik ".$aksi." untuk melakukan proses pembuatan daftar uang makan untuk Bulan <strong>".wordMonth($data['bulan'])."</strong> Tahun <strong>".$data['tahun']."</strong>.</p><p><span class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Perhatian: Data yang sudah dibuat, akan dilewati.</span></p>";
		}else{
			$html.="<p class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Tidak dapat melakukan proses pembuatan daftar uang makan karena jumlah pegawai tidak ada.</p>";
		}
		$html.="</div>";
		return $html;
	}
?>
