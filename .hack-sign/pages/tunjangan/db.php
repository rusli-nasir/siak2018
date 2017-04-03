<?php

	$_CONFIG['tunjangan']['order'] = " ORDER BY a.unitid, a.nip";

	// dialog untuk proses tenaga non pns
	function showDialogProsesTunjanganNonPNS($data){
		$unit = "seluruh unit Undip";
		$sql = "SELECT nip, nama FROM kepeg_tb_pegawai WHERE status_kepeg = ".intval($data['status_kepeg']);
		if(is_numeric($data['unit_id']) && isExist($data['unit_id'],'kepeg_unit','id')){
			$sql.=" AND unit_id = ".intval($data['unit_id']);
			$unit = "unit ".getUnit($data['unit_id']);
		}
		if(isset($_SESSION['tunjangan']['proses']['status']) && is_array($_SESSION['tunjangan']['proses']['status']) && count($_SESSION['tunjangan']['proses']['status'])>1){
			$sql.= " AND ( status = ".implode(" OR status = ", $_SESSION['tunjangan']['proses']['status']).")";
		}elseif(isset($_SESSION['tunjangan']['proses']['status']) && is_array($_SESSION['tunjangan']['proses']['status']) && count($_SESSION['tunjangan']['proses']['status'])==1){
			$sql.= " AND status = ".$_SESSION['tunjangan']['proses']['status'][0];
		}
		$row=getRow($sql);
		$aksi = "";
		$html = "<div class=\"callout\">
			<h4><i class=\"fa fa-bullhorn\"></i>&nbsp;&nbsp;Informasi Proses Data Tunjangan Kesejahterahan</h4>
			<p>&nbsp;</p>
			<p>Jumlah Pegawai <strong>".getStatusKepeg($data['status_kepeg'])."</strong> yang terdaftar di <strong>".$unit."</strong> melalui proses ini adalah <strong>$row</strong> orang.</p>";
		if($row > 0){
			if(isset($data['status'])){
				$data['status'] = implode(";",$data['status']);
			}
			$aksi = "<button type=\"button\" onclick=\"javascript:\$.post('".$GLOBALS['path']."/process.php',{'page':'tunjangan','act':'tunjangan_proses2','data':'".implode(",",$data)."'},function(data){ if(data!='1'){\$('.result_data').html(data);}else{window.location.reload();} });\" class=\"btn btn-primary btn-flat btn-sm\"><i class=\"fa fa-spinner\"></i>&nbsp;&nbsp;&nbsp;Proses Daftar Tunjangan</button>";
			$html.="<p>Klik ".$aksi." untuk melakukan proses pembuatan daftar tunjangan untuk Bulan <strong>".wordMonth($data['bulan'])."</strong> Tahun <strong>".$data['tahun']."</strong>.</p><p><span class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Perhatian: Data yang sudah dibuat, akan dilewati.</span></p>";
		}else{
			$html.="<p class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Tidak dapat melakukan proses pembuatan daftar tunjangan karena jumlah pegawai tidak ada.</p>";
		}
		$html.="</div>";
		return $html;
	}

	function showDaftarTunjanganBLU($_CONFIG){
		$sql = "SELECT a.id, c.nama, d.jabatan, a.pasangan, a.nominalp, a.anak, a.nominala, a.nominalb, a.nominalt, b.nominalg AS gaji
						FROM kepeg_tr_dtunjangan a
						LEFT JOIN kepeg_tr_dgaji b ON a.nip = b.nip AND a.bulan = b.bulan AND a.tahun = b.tahun
						LEFT JOIN kepeg_tb_pegawai c ON a.nip = c.nip
						LEFT JOIN kepeg_tb_jabatan d ON c.jabatan_id = d.id
						WHERE a.statuspeg = '".intval($_SESSION['tunjangan']['status_kepeg'])."' AND a.bulan = '".intval($_SESSION['tunjangan']['bulan'])."' AND a.tahun = '".intval($_SESSION['tunjangan']['tahun'])."'";
		if( isset($_SESSION['tunjangan']['unit_id']) && is_numeric($_SESSION['tunjangan']['unit_id']) && isExist( $_SESSION['tunjangan']['unit_id'],'kepeg_unit','id') ){
			$sql.=" AND a.unitid = ".intval($_SESSION['tunjangan']['unit_id']);
		}
		$sql.= $_CONFIG['tunjangan']['order'];
		// echo $sql;
		$row = getRow($sql);
		// echo "<br/>Jumlah data: ".$row;
		echo "<div class=\"table-responsive no-padding\">";
		echo "<h4 class=\"text-center\">Tabel Tunjangan Kesejahterahan Pegawai ".getStatusKepeg($_SESSION['tunjangan']['status_kepeg']);
		echo "<br/>";
		if(isset($_SESSION['tunjangan']['unit_id']) && isExist($_SESSION['tunjangan']['unit_id'],'kepeg_unit','id')){
			echo getValue($_SESSION['tunjangan']['unit_id'],'kepeg_unit','id','unit');
			echo "<br/>";
		}
		echo "Bulan ".wordMonth($_SESSION['tunjangan']['bulan']);
		echo " Tahun ".$_SESSION['tunjangan']['tahun'];
		echo "</h4>";
		// jika row nya lebih dari 0
		if($row > 0){
			echo "<form id=\"jamaah\" action=\"".$GLOBALS['path']."/process.php\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"act\" id=\"act\" value=\"tunjangan_hapus_berjamaah\"/>";
			echo "<div class=\"message-jamaah\"></div>";

			echo "<p class=\"pull-right\">
				<button type=\"button\" class=\"btn btn-danger btn-flat btn-sm hapus_data\"><i class=\"fa fa-trash\"></i>&nbsp;&nbsp;Hapus yang dipilih</button>
				<button type=\"button\" class=\"btn btn-primary btn-flat btn-sm simpan_data\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan perubahan yang dibuat</button>
			</p>";

			echo "<table class=\"table table-bordered table-hover small tabel_tunjangan scroll-300\">";
			echo "<thead>";
			echo "<tr> <th rowspan=\"2\" class=\"text-center\"><input type=\"checkbox\" class=\"master_id\" id=\"master_id\"/></th> <th rowspan=\"2\" class=\"text-center\">No</th> <th rowspan=\"2\" class=\"text-center\">Nama</th> <th rowspan=\"2\" class=\"text-center\">Jabatan</th> <th rowspan=\"2\" class=\"text-center\">Gaji</th> <th colspan=\"6\" class=\"text-center\">Tunjangan Kesejahterahan</th> <th width=\"50px\" rowspan=\"2\">&nbsp;</th> </tr>";
			echo "<tr> <th class=\"text-center\">Jumlah<br/>Suami/Istri</th> <th class=\"text-center\">Tunjangan<br/>Suami/Istri</th> <th class=\"text-center\">Jumlah<br/>Anak</th> <th class=\"text-center\">Tunjangan<br/>Anak</th> <th class=\"text-center\">Tunjangan<br/>Beras</th> <th class=\"text-center\">Jumlah Bruto</th> </tr>";
			echo "</thead>";
			$i=1;
			$totalg = 0;
			$totalp = 0;
			$totalnp = 0;
			$totala = 0;
			$totalna = 0;
			$totalb = 0;
			$total = 0;
			echo "<tbody>";
			$data = getdatadb($sql);
			foreach ($data as $k => $v) {
				echo "<tr>";
				echo "<td class=\"text-center\">";
				echo "<input type=\"hidden\" name=\"_id[]\" value=\"".$v['id']."\"/>";
				echo "<input type=\"checkbox\" name=\"id[]\" class=\"id_tr_tunjangan\" value=\"".$v['id']."\"/>";
				echo "</td>";
				echo "<td class=\"text-right\">";
				echo $i;
				echo ".</td>";
				echo "<td>";
				echo $v['nama'];
				echo "</td>";
				echo "<td>";
				echo $v['jabatan'];
				echo "</td>";
				echo "<td class=\"text-right\">";
				echo number_format($v['gaji'],0,',','.');
				echo ",-</td>";

				echo "<td><input type=\"text\" name=\"pasangan[]\" class=\"form-control input-sm text-right tunjangan_ubah_pasangan\" style=\"max-width:50px;\" maxlength=\"2\" id=\"".$v['id']."\" value=\"".$v['pasangan']."\"/></td>";
				echo "<td class=\"text-right\">".number_format($v['nominalp'],0,',','.').",-</td>";
				echo "<td><input type=\"text\" name=\"anak[]\" class=\"form-control input-sm text-right tunjangan_ubah_anak\" style=\"max-width:50px;\" maxlength=\"2\" id=\"".$v['id']."\" value=\"".$v['anak']."\"/></td>";
				echo "<td class=\"text-right\">".number_format($v['nominala'],0,',','.').",-</td>";
				echo "<td class=\"text-right\">".number_format($v['nominalb'],0,',','.').",-</td>";
				echo "<td class=\"text-right\">".number_format($v['nominalt'],0,',','.').",-</td>";

				echo "<td>";
				echo "<button type=\"button\" class=\"btn btn-danger btn-flat btn-sm hapus_single\" id=\"".$v['id']."\"><i class=\"fa fa-trash\"></i></button>";
				echo "</td>";
				echo "</tr>";
				$totalg += $v['gaji'];
				$totalp += $v['pasangan'];
				$totalnp += $v['nominalp'];
				$totala += $v['anak'];
				$totalna += $v['nominala'];
				$totalb += $v['nominalb'];
				$total += $v['nominalt'];
				$i++;
			}
			echo "<tr>";
			echo "<th colspan=\"4\" class=\"text-center\">TOTAL</td>";
			echo "<th class=\"text-right\">";
			echo number_format($totalg,0,',','.');
			echo ",-</th>";
			echo "<th class=\"text-right\">";
			echo number_format($totalp,0,',','.');
			echo ",-</th>";
			echo "<th class=\"text-right\">";
			echo number_format($totalnp,0,',','.');
			echo ",-</th>";
			echo "<th class=\"text-right\">";
			echo number_format($totala,0,',','.');
			echo ",-</th>";
			echo "<th class=\"text-right\">";
			echo number_format($totalna,0,',','.');
			echo ",-</th>";
			echo "<th class=\"text-right\">";
			echo number_format($totalb,0,',','.');
			echo ",-</th>";
			echo "<th class=\"text-right\">";
			echo number_format($total,0,',','.');
			echo ",-</th>";
			echo "<th>&nbsp;</th>";
			echo "</tr>";
			echo "</tbody>";
			echo "</table>";

			echo "<p>
				<button type=\"button\" class=\"btn btn-danger btn-flat btn-sm hapus_data\"><i class=\"fa fa-trash\"></i>&nbsp;&nbsp;Hapus yang dipilih</button>
				<button type=\"button\" class=\"btn btn-primary btn-flat btn-sm simpan_data\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan perubahan yang dibuat</button>
			</p>";

			echo "</div>";
			echo "</form>";
		}else{
			echo msgGagal("Tidak ada data yang diharapkan, sehingga harus melakukan proses data tunjangan terlebih dahulu. Jangan lupa untuk memproses data gaji terlebih dahulu.");
		}
	}

	function showDaftarTunjanganKONTRAK($_CONFIG){
		echo msgGagal("Tidak ada data yang diharapkan, sehingga harus melakukan proses data tunjangan Kesejahterahan (istri, anak, dll) terlebih dahulu. Jangan lupa untuk memproses data gaji terlebih dahulu.");
	}
?>
