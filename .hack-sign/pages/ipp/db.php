<?php

	$_CONFIG['ipp']['order'] = " ORDER BY `jabatan_id`";
	$_CONFIG['ipp']['nominal'] = 5000000; // otomatis 5 juta, jare mas wahyu

	function showDialogProsesIPP($data){
		$unit = "seluruh unit Undip";
		if($data['status_kepeg']!=1 && $data['status_kepeg']!=3){
			// set bila merupakan CPNS atau PNS
			$_status_kepeg = "status_kepeg = ".intval($data['status_kepeg']);
		}else{
			$_status_kepeg = "( status_kepeg = 1 OR status_kepeg = 3 )";
		}
		$sql = "SELECT nip, nama FROM kepeg_tb_pegawai WHERE ".$_status_kepeg." AND jnspeg = ".intval($data['jnspeg']);
		if(is_numeric($data['unit_id']) && isExist($data['unit_id'],'kepeg_unit','id')){
			$sql.=" AND `unit_id` = ".intval($data['unit_id']);
			$unit = "unit ".getUnit($data['unit_id']);
		}
		if(isset($_SESSION['ipp']['proses']['status']) && is_array($_SESSION['ipp']['proses']['status']) && count($_SESSION['ipp']['proses']['status'])>1){
			$sql.= " AND ( `status` = ".implode(" OR status = ", $_SESSION['ipp']['proses']['status']).")";
		}elseif(isset($_SESSION['ipp']['proses']['status']) && is_array($_SESSION['ipp']['proses']['status']) && count($_SESSION['ipp']['proses']['status'])==1){
			$sql.= " AND `status` = ".$_SESSION['ipp']['proses']['status'][0];
		}
		$row=getRow($sql);
		$aksi = "";
		$html = "<div class=\"box box-primary box-solid\"><div class=\"box-body\">";
		$html .= "<div class=\"callout\">
			<h4><i class=\"fa fa-bullhorn\"></i>&nbsp;&nbsp;Informasi Proses Data Insentif Perbaikan Penghasilan</h4>
			<p>&nbsp;</p>
			<p>Jumlah Pegawai <strong>".getJenisPeg($data['jnspeg'])." ".getStatusKepeg($data['status_kepeg'])."</strong> yang terdaftar di <strong>".$unit."</strong> melalui proses ini adalah <strong>$row</strong> orang.</p>";
		if($row > 0){
			if(isset($data['status'])){
				$data['status'] = implode(";",$data['status']);
			}
			$aksi = "<button type=\"button\" onclick=\"javascript:\$.post('".$GLOBALS['path']."/process.php',{'page':'ipp','act':'ipp_proses2','data':'".implode(",",$data)."'},function(data){ if(data!='1'){\$('.result_data').html(data);}else{window.location.reload();} });\" class=\"btn btn-primary btn-flat btn-sm\"><i class=\"fa fa-spinner\"></i>&nbsp;&nbsp;&nbsp;Proses Daftar Insentif Perbaikan Penghasilan</button>";
			$html.="<p>Klik ".$aksi." untuk melakukan proses pembuatan daftar Insentif Perbaikan Penghasilan pada tahun <strong>".$data['tgl_transaksi']."</strong> untuk Pembayaran Semester <strong>".getSemester($data['semester'])."</strong>.</p><p><span class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Perhatian: Data yang sudah dibuat, akan dilewati.</span></p>";
		}else{
			$html.="<p class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Tidak dapat melakukan proses pembuatan daftar  IPP karena jumlah pegawai tidak ada.</p>";
		}
		// $html.="<p>".$sql."</p>";
		$html.="</div></div></div>";
		return $html;
	}

	function showDaftarIPP($data){
		$html="";
		$html.="<table class=\"table table-bordered table-hover small tabel_ipp\">";
		$html.="<thead>";
		$html.="<tr> <th style=\"text-align:center\"><input type=\"checkbox\" class=\"master_id\" id=\"master_id\"/></th> <th style=\"text-align:center\">No</th> <th style=\"text-align:center\">Nama</th> <th style=\"text-align:center\">No. Rek.</th> <th style=\"text-align:center\">NPWP</th> <th style=\"text-align:center\">Golongan</th> <th style=\"text-align:center\">Bruto</th> <th style=\"text-align:center\">Pajak</th> <th style=\"text-align:center\">Potongan</th> <th style=\"text-align:center\">Netto</th> <th style=\"text-align:center\">Semester</th> <th width=\"50px\">&nbsp;</th></tr>";
		$html.="</thead>";
		$i=1;
		$total_ipp = 0; $total_pot = 0; $total_net = 0;
		$html.="<tbody>";
		foreach ($data as $k => $v) {
			$html.="<tr>";
			$html.="<td style=\"text-align:center\">";
			$html.="<input tabindex=\"-1\" type=\"checkbox\" name=\"id[]\" class=\"id\" value=\"".$v['id_trans']."\"/>";
			$html.="<input type=\"hidden\" name=\"_id[]\" value=\"".$v['id_trans']."\"/>";
			$html.="</td>";
			$html.="<td style=\"text-align:right\">".$i.".</td>";
			$html.="<td>".$v['nama']."</td>";
			$html.="<td>".$v['norekening']."</td>";
			$html.="<td>".$v['npwp']."</td>";
			$html.="<td>".$v['gol']."</td>";
			$html.="<td style=\"text-align:right\">".number_format($v['ipp'],0,',','.').",-</td>";
			$html.="<td style=\"text-align:center\">".($v['pajak']*100)."%</td>";
			$html.="<td style=\"text-align:right\">".number_format($v['potongan'],0,',','.').",-</td>";
			$html.="<td style=\"text-align:right\">".number_format($v['netto'],0,',','.').",-</td>";
			$html.="<td style=\"text-align:center\">".getSemester($v['semester'])."</td>";
			$html.="<td>";
			$html.="<button tabindex=\"-1\" type=\"button\" class=\"btn btn-danger btn-flat btn-sm hapus_single\" id=\"".$v['id_trans']."\"><i class=\"fa fa-trash\"></i></button>";
			$html.="</td>";
			$html.="</tr>";
			$i++;
			$total_ipp += $v['ipp'];
			$total_pot += $v['potongan'];
			$total_net += $v['netto'];
		}
		$html.="<th style=\"text-align:center\" colspan=\"6\">TOTAL</th>";
		$html.="<th style=\"text-align:right\">".number_format($total_ipp,0,',','.').",-</th>";
		$html.="<th style=\"text-align:right\">&nbsp;</th>";
		$html.="<th style=\"text-align:right\">".number_format($total_pot,0,',','.').",-</th>";
		$html.="<th style=\"text-align:right\">".number_format($total_net,0,',','.').",-</th>";
		$html.="<th colspan=\"2\">&nbsp;</th>";
		$html.="</tbody>";
		$html.="</table>";
		return $html;
	}

	function showDaftarIPPCetak($data){
		$html="";
		$html.="<table class=\"tabel_ipp\" border=\"1\" style=\"border-collapse:collapse;width:100%;\">";
		$html.="<thead>";
		$html.="<tr> <th style=\"text-align:center\">No</th> <th style=\"text-align:center\">Nama</th> <th style=\"text-align:center\">No. Rek.</th> <th style=\"text-align:center\">NPWP</th> <th style=\"text-align:center\">Golongan</th> <th style=\"text-align:center\">Bruto</th> <th style=\"text-align:center\">Pajak</th> <th style=\"text-align:center\">Potongan</th> <th style=\"text-align:center\">Netto</th> <th style=\"text-align:center\">Semester</th></tr>";
		$html.="</thead>";
		$i=1;
		$total_ipp = 0; $total_pot = 0; $total_net = 0;
		$html.="<tbody>";
		foreach ($data as $k => $v) {
			$html.="<tr>";
			$html.="<td style=\"text-align:right\">".$i.".</td>";
			$html.="<td>".$v['nama']."</td>";
			$html.="<td>".$v['norekening']." </td>";
			$html.="<td>".$v['npwp']." </td>";
			$html.="<td>".$v['gol']."</td>";
			$html.="<td style=\"text-align:right\">".number_format($v['ipp'],0,',','.').",-</td>";
			$html.="<td style=\"text-align:center\">".($v['pajak']*100)."%</td>";
			$html.="<td style=\"text-align:right\">".number_format($v['potongan'],0,',','.').",-</td>";
			$html.="<td style=\"text-align:right\">".number_format($v['netto'],0,',','.').",-</td>";
			$html.="<td style=\"text-align:center\">".getSemester($v['semester'])."</td>";
			$html.="</tr>";
			$i++;
			$total_ipp += $v['ipp'];
			$total_pot += $v['potongan'];
			$total_net += $v['netto'];
		}
		$html.="<th style=\"text-align:center\" colspan=\"5\">TOTAL</th>";
		$html.="<th style=\"text-align:right\">".number_format($total_ipp,0,',','.').",-</th>";
		$html.="<th style=\"text-align:right\">&nbsp;</th>";
		$html.="<th style=\"text-align:right\">".number_format($total_pot,0,',','.').",-</th>";
		$html.="<th style=\"text-align:right\">".number_format($total_net,0,',','.').",-</th>";
		$html.="<th>&nbsp;</th>";
		$html.="</tbody>";
		$html.="</table>";
		$html.="<p>&nbsp;</p>";
		$html.="<table style=\"width:100%;\">";
		$html.="<tr><td colspan=\"7\"></td><td colspan=\"3\">Semarang, ".balikTgl(date('Y-m-d'))."</td></tr>";
		$html.="<tr><td colspan=\"4\" width=\"35%\">";
		#1
		// $sql = "SELECT * FROM rsa_user WHERE kode_unit_subunit LIKE '".$_SESSION['rsa_kode_unit_subunit']."' AND level LIKE '15'";
		// $bpp = getdata($sql);
		$html.= "Mengetahui,<br/>";
		// $html.= "Pejabat Pelaksana &amp; Pengendali Kegiatan SUKPA, <br/>";
		// $html.= "<br/><br/><br/><br/>";
		// $html.= $bpp['nm_lengkap']."<br/>";
		// $html.= "NIP. ".$bpp['nomor_induk'];
		$html.= "Pejabat Pembuat Komitmen SUKPA, <br/>";
		$html.= "<br/><br/><br/><br/>";
		$html.= "M. Muntafi, S.Sos<br/>";
		$html.= "NIP. 197007172007011002";
		$html.="</td><td colspan=\"3\" width=\"33%\">";
		#2
		// $sql = "SELECT * FROM rsa_user WHERE kode_unit_subunit LIKE '".$_SESSION['rsa_kode_unit_subunit']."' AND level LIKE '14'";
		// $ppk = getdata($sql);
		// $html.= "<br/>Pejabat Pembuat Komitmen SUKPA, <br/>";
		// $html.= "<br/><br/><br/><br/>";
		// $html.= $ppk['nm_lengkap']."<br/>";
		// $html.= "NIP. ".$ppk['nomor_induk'];
		$html.= "<br/>Bendahara Pengeluaran SUKPA, <br/>";
		$html.= "<br/><br/><br/><br/>";
		$html.= "Aryati Eka Dewi<br/>";
		$html.= "NIP. 198101272003122001";
		$html.="</td><td colspan=\"3\" width=\"30%\">";
		#3
		// $sql = "SELECT * FROM rsa_user WHERE kode_unit_subunit LIKE '".$_SESSION['rsa_kode_unit_subunit']."' AND level LIKE '13'";
		// $ppk = getdata($sql);
		$html.= "<br/>Pembuat Daftar, <br/>";
		$html.= "<br/><br/><br/><br/>";
		$html.= "Asri Setyaning<br/>";
		$html.= "NIP. H.7.1987082910062053";
		$html.="</td></tr>";
		$html.="</table>";
		return $html;
	}
?>
