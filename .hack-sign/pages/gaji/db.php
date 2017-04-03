<?php
	// " ORDER BY a.unitid, a.nip"
	$_CONFIG['gaji']['order'] = " ORDER BY a.nip, b.nama";

	function showDialogProsesGaji($data){
		$unit = "seluruh unit Undip";
		$sql = "SELECT nip, nama FROM kepeg_tb_pegawai WHERE status_kepeg = ".intval($data['status_kepeg']);
		if(is_numeric($data['unit_id']) && isExist($data['unit_id'],'kepeg_unit','id')){
			$sql.=" AND unit_id = ".intval($data['unit_id']);
			$unit = "unit ".getUnit($data['unit_id']);
		}
		if(isset($_SESSION['gaji']['proses']['status']) && is_array($_SESSION['gaji']['proses']['status']) && count($_SESSION['gaji']['proses']['status'])>1){
			$sql.= " AND ( status = ".implode(" OR status = ", $_SESSION['gaji']['proses']['status']).")";
		}elseif(isset($_SESSION['gaji']['proses']['status']) && is_array($_SESSION['gaji']['proses']['status']) && count($_SESSION['gaji']['proses']['status'])==1){
			$sql.= " AND status = ".$_SESSION['gaji']['proses']['status'][0];
		}
		$row=getRow($sql);
		$aksi = "";
		$html = "<div class=\"callout\">
			<h4><i class=\"fa fa-bullhorn\"></i>&nbsp;&nbsp;Informasi</h4>
			Jumlah Pegawai <strong>".getStatusKepeg($data['status_kepeg'])."</strong> yang terdaftar di <strong>".$unit."</strong> melalui proses ini adalah <strong>$row</strong> orang.<br />";
		if($row > 0){
			if(isset($data['status'])){
				$data['status'] = implode(";",$data['status']);
			}
			$aksi = "<button type=\"button\" onclick=\"javascript:\$.post('".$GLOBALS['path']."/process.php',{'page':'gaji','act':'gaji_proses2','data':'".implode(",",$data)."'},function(data){ if(data!='1'){\$('.result_data').html(data);}else{window.location.reload();} });\" class=\"btn btn-primary btn-flat btn-sm\"><i class=\"fa fa-spinner\"></i>&nbsp;&nbsp;&nbsp;Proses Daftar Gaji</button>";
			$html.="Klik ".$aksi." untuk melakukan proses pembuatan daftar gaji untuk Bulan <strong>".wordMonth($data['bulan'])."</strong> Tahun <strong>".$data['tahun']."</strong>.<br /><span class=\"text-red\">Perhatian: Data yang sudah dibuat, akan dilewati.</span>";
		}else{
			$html.="Tidak dapat melakukan proses pembuatan daftar gaji karena jumlah pegawai tidak ada.";
		}
		$html.="</div>";
		return $html;
	}

	function showDaftarGaji($data){
		echo "<form id=\"jamaah\" action=\"".$GLOBALS['path']."/process.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"act\" id=\"act\" value=\"gaji_hapus_berjamaah\"/>";
		echo "<div class=\"table-responsive no-padding\">";
		echo "<h4 class=\"text-center\">Tabel Gaji Pegawai ".getStatusKepeg($_SESSION['gaji']['status_kepeg']);
		echo "<br/>";
		if(isset($_SESSION['gaji']['unit_id']) && isExist($_SESSION['gaji']['unit_id'],'kepeg_unit','id')){
			echo getValue($_SESSION['gaji']['unit_id'],'kepeg_unit','id','unit');
			echo "<br/>";
		}
		echo "Bulan ".wordMonth($_SESSION['gaji']['bulan']);
		echo " Tahun ".$_SESSION['gaji']['tahun'];
		echo "</h4>";
		echo "<p class=\"pull-right\"><button class=\"btn btn-danger btn-flat btn-sm hapus_data\"><i class=\"fa fa-trash\"></i>&nbsp;&nbsp;Hapus yang dipilih</button></p>";
		echo "<table class=\"table table-bordered table-hover small tabel_gaji\">";
		echo "<thead>";
		echo "<tr><th><input type=\"checkbox\" class=\"master_id\" id=\"master_id\"/></th><th>No</th><th>Nama</th><th>NIP</th><th>Jabatan</th><th>Pendidikan</th><th>Gaji</th><th width=\"50px\">&nbsp;</th></tr>";
		echo "</thead>";
		$i=1;
		$totalg = 0;
		echo "<tbody>";
		foreach ($data as $k => $v) {
			echo "<tr>";
			echo "<td class=\"text-center\">";
			echo "<input type=\"checkbox\" name=\"id[]\" class=\"id_tr_gaji\" value=\"".$v['id']."\"/>";
			echo "</td>";
			echo "<td class=\"text-right\">";
			echo $i;
			echo ".</td>";
			echo "<td>";
			echo $v['nama'];
			echo "</td>";
			echo "<td>";
			echo $v['nip'];
			echo "</td>";
			echo "<td>";
			echo $v['jabatan'];
			echo "</td>";
			echo "<td>";
			echo $v['ijazah'];
			echo "</td>";
			echo "<td class=\"text-right\">";
			echo number_format($v['gaji'],0,',','.');
			echo ",-</td>";
			echo "<td>";
			echo "<button type=\"button\" class=\"btn btn-danger btn-flat btn-sm hapus_single\" id=\"".$v['id']."\"><i class=\"fa fa-trash\"></i></button>";
			echo "</td>";
			echo "</tr>";
			$totalg += $v['gaji'];
			$i++;
		}
		echo "<tr>";
		echo "<th colspan=\"5\">&nbsp;</th>";
		echo "<th class=\"text-center\">TOTAL</th>";
		echo "<th class=\"text-right\">";
		echo number_format($totalg,0,',','.');
		echo ",-</th>";
		echo "<th>&nbsp;</th>";
		echo "</tr>";
		echo "</tbody>";
		echo "</table>";
		echo "<p><button class=\"btn btn-danger btn-flat btn-sm hapus_data\"><i class=\"fa fa-trash\"></i>&nbsp;&nbsp;Hapus yang dipilih</button></p>";
		echo "</div>";
		echo "</form>";
	}
?>
