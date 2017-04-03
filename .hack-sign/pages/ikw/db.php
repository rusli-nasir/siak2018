<?php

	$_CONFIG['ikw']['order'] = " ORDER BY c.`golongan_id` DESC, c.`jabatan_id` ASC, a.`nip` ASC";

	function showDialogProsesTunjanganIKW($data){
		$unit = "seluruh unit Undip";
		if($data['status_kepeg']!=1 && $data['status_kepeg']!=3){
			// set bila merupakan CPNS atau PNS
			$_status_kepeg = "status_kepeg = ".intval($data['status_kepeg']);
		}else{
			$_status_kepeg = "( status_kepeg = 1 OR status_kepeg = 3 )";
		}
		$sql = "SELECT nip, nama FROM kepeg_tb_pegawai WHERE ".$_status_kepeg." AND jnspeg = ".intval($data['jnspeg']);
		if(is_numeric($data['unit_id']) && isExist($data['unit_id'],'kepeg_unit','id')){
			$sql.=" AND unit_id = ".intval($data['unit_id']);
			$unit = "unit ".getUnit($data['unit_id']);
		}
		if(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])>1){
			$sql.= " AND ( status = ".implode(" OR status = ", $_SESSION['ikw']['proses']['status']).")";
		}elseif(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])==1){
			$sql.= " AND status = ".$_SESSION['ikw']['proses']['status'][0];
		}
		// return $sql; exit;
		$row=getRow($sql);
		$aksi = "";
		$html = "<div class=\"box box-primary box-solid\"><div class=\"box-body\">";
		$html .= "<div class=\"callout\">
			<h4><i class=\"fa fa-bullhorn\"></i>&nbsp;&nbsp;Informasi Proses Data  Insentif Kinerja Wajib</h4>
			<p>&nbsp;</p>
			<p>Jumlah Pegawai <strong>".getStatusKepeg($data['status_kepeg'])."</strong> yang terdaftar di <strong>".$unit."</strong> melalui proses ini adalah <strong>$row</strong> orang.</p>";
		if($row > 0){
			if(isset($data['status'])){
				$data['status'] = implode(";",$data['status']);
			}
			$aksi = "<button type=\"button\" onclick=\"javascript:\$.post('".$GLOBALS['path']."/process.php',{'page':'ikw','act':'ikw_proses2','data':'".implode(",",$data)."'},function(data){ if(data!='1'){\$('.result_data').html(data);}else{window.location.reload();} });\" class=\"btn btn-primary btn-flat btn-sm\"><i class=\"fa fa-spinner\"></i>&nbsp;&nbsp;&nbsp;Proses Daftar  IKW</button>";
			$html.="<p>Klik ".$aksi." untuk melakukan proses pembuatan daftar  IKW untuk Bulan <strong>".wordMonth($data['bulan'])."</strong> Tahun <strong>".$data['tahun']."</strong>.</p><p><span class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Perhatian: Data yang sudah dibuat, akan dilewati.</span></p>";
		}else{
			$html.="<p class=\"text-red text-bold\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Tidak dapat melakukan proses pembuatan daftar  IKW karena jumlah pegawai tidak ada.</p>";
		}
		// $html.="<p>".$sql."</p>";
		$html.="</div></div></div>";
		return $html;
	}

	function showDaftarPotonganIKW($data){
		$html="";
		$html.="<table class=\"table table-bordered table-hover small tabel_pot_ikw\">";
		$html.="<thead>";
		$html.="<tr><th class=\"text-center\"><input type=\"checkbox\" class=\"master_id\" id=\"master_id\"/></th><th class=\"text-center\">No</th><th class=\"text-center\">Nama</th><th class=\"text-center\">NIP</th><th class=\"text-center\">No.Rek.</th><th class=\"text-center\">NPWP</th><th class=\"text-center\">Jabatan</th><th class=\"text-center\">Golongan</th><th class=\"text-center\">Nominal IKW</th><th class=\"text-center\">Capaian yang dicapai</th><th class=\"text-center\">Capaian Kinerja Wajib</th><th class=\"text-center\">Kinerja tidak Tercapai</th><th class=\"text-center\">Jumlah Potongan</th><th width=\"50px\">&nbsp;</th></tr>";
		$html.="</thead>";
		$i=1;
		$j=1;
		$total_ikw = 0; $total_pot = 0;
		$html.="<tbody>";
		foreach ($data as $k => $v) {
			$html.="<tr>";
			$html.="<td class=\"text-center\">";
			$html.="<input tabindex=\"-1\" type=\"checkbox\" name=\"id[]\" class=\"id_trans\" value=\"".$v['id_trans']."\"/>";
			$html.="<input type=\"hidden\" name=\"_id[]\" value=\"".$v['id_trans']."\"/>";
			$html.="<input type=\"hidden\" name=\"id_trans_ikw[]\" value=\"".$v['id_trans_ikw']."\"/>";
			$html.="<input type=\"hidden\" name=\"ikw[]\" value=\"".$v['ikw']."\"/>";
			$html.="<input type=\"hidden\" name=\"pajak[]\" value=\"".$v['pajak']."\"/>";
			$html.="</td>";
			$html.="<td class=\"text-right\">".$i.".</td>";
			$html.="<td>".$v['nama']."</td>";
			$html.="<td>".$v['nip']."</td>";
			$html.="<td>".$v['norekening']."</td>";
			$html.="<td>".$v['npwp']."</td>";
			$html.="<td>".$v['jabatan']."</td>";
			$html.="<td>".$v['gol']."</td>";
			$html.="<td class=\"text-right\">".number_format($v['ikw'],0,',','.').",-</td>";
			$html.= "<td class=\"text-center\"><input type=\"text\" name=\"capaian_smt_sblm[]\" class=\"form-control input-sm text-center ikw_ubah_capaian_smt_sblm\" style=\"max-width:75px;display:inline;\" tabindex=\"".$j."\" maxlength=\"4\" id=\"".$v['id_trans']."\" value=\"".$v['capaian_smt_sblm']."\"/></td>";
			$html.= "<td class=\"text-center\"><input type=\"text\" name=\"kinerja_wajib[]\" class=\"form-control input-sm text-center ikw_ubah_kinerja_wajib\" style=\"max-width:75px;display:inline;\" tabindex=\"".($j+1)."\" maxlength=\"4\" id=\"".$v['id_trans']."\" value=\"".$v['kinerja_wajib']."\"/></td>";
			$html.="<td class=\"text-center\">".$v['kinerja_tdk_tercapai']."</td>";
			$html.="<td class=\"text-right\">".number_format($v['jml_pot'],0,',','.').",-</td>";
			$html.="<td>";
			$html.="<button tabindex=\"-1\" type=\"button\" class=\"btn btn-danger btn-flat btn-sm hapus_single\" id=\"".$v['id_trans']."\"><i class=\"fa fa-trash\"></i></button>";
			$html.="</td>";
			$html.="</tr>";
			$i++;
			$j+=2;
			$total_ikw += $v['ikw'];
			$total_pot += $v['jml_pot'];
		}
		$html.="<th class=\"text-center\" colspan=\"8\">TOTAL</th>";
		$html.="<th class=\"text-right\">".number_format($total_ikw,0,',','.').",-</th>";
		$html.="<th colspan=\"3\">&nbsp;</th>";
		$html.="<th class=\"text-right\">".number_format($total_pot,0,',','.').",-</th>";
		$html.="</tbody>";
		$html.="</table>";
		return $html;
	}

	function showDaftarPotonganIKWCetak($data){
		$html="";
		$html.="<table class=\"tabel_pot_ikw\" border=\"1\" style=\"border-collapse:collapse;\">";
		$html.="<thead>";
		$html.="<tr><th style=\"text-align:center;\">No</th><th style=\"text-align:center;\">Nama</th><th style=\"text-align:center;\">NIP</th><th style=\"text-align:center;\">Status</th><th style=\"text-align:center;\">Bank</th><th style=\"text-align:center;\">No. Rek.</th><th style=\"text-align:center;\">NPWP</th><th style=\"text-align:center;\">Jabatan</th><th style=\"text-align:center;\">Golongan</th><th style=\"text-align:center;\">Nominal IKW</th><th style=\"text-align:center;\">Capaian SMT Sebelumnya</th><th style=\"text-align:center;\">Capaian Kinerja Wajib</th><th style=\"text-align:center;\">Kinerja tidak Tercapai</th><th style=\"text-align:center;\">Jumlah Potongan</th> </tr>";
		$html.="</thead>";
		$i=1;
		$j=1;
		$total_ikw = 0; $total_pot = 0;
		$html.="<tbody>";
		foreach ($data as $k => $v) {
			$html.="<tr>";
			$html.="<td style=\"text-align:right;\">".$i.".</td>";
			$html.="<td>".$v['nama']."</td>";
			$html.="<td width=\"200\">'".$v['nip']."</td>";
			$html.="<td>".getStatus($v['status'])."</td>";
			$html.="<td>".$v['nmbank']."</td>";
			$html.="<td width=\"200\">'".$v['norekening']."</td>";
			$html.="<td width=\"200\">'".$v['npwp']."</td>";
			$html.="<td>".$v['jabatan']."</td>";
			$html.="<td>".$v['gol']."</td>";
			$html.="<td style=\"text-align:right;\">".$v['ikw']."</td>";
			$html.= "<td style=\"text-align:center;\">".$v['capaian_smt_sblm']."</td>";
			$html.= "<td style=\"text-align:center;\">".$v['kinerja_wajib']."</td>";
			$html.="<td style=\"text-align:center;\">".$v['kinerja_tdk_tercapai']."</td>";
			$html.="<td style=\"text-align:right;\">".$v['jml_pot']."</td>";
			$html.="</tr>";
			$i++;
			$j+=2;
			$total_ikw += $v['ikw'];
			$total_pot += $v['jml_pot'];
		}
		$html.="<th style=\"text-align:center;\" colspan=\"9\">TOTAL</th>";
		$html.="<th style=\"text-align:right;\">".number_format($total_ikw,0,',','.').",-</th>";
		$html.="<th colspan=\"3\">&nbsp;</th>";
		$html.="<th style=\"text-align:right;\">".number_format($total_pot,0,',','.').",-</th>";
		$html.="</tbody>";
		$html.="</table>";
		return $html;
	}

	function showDaftarIKW($data){
		$html="";
		$html.="<table class=\"table table-bordered table-hover small tabel_ikw\">";
		$html.="<thead>";
		$html.="<tr><th class=\"text-center\"><input type=\"checkbox\" class=\"master_id2\" id=\"master_id2\"/></th><th class=\"text-center\">No</th><th class=\"text-center\">Nama</th><th class=\"text-center\">NIP</th><th class=\"text-center\">No.Rek.</th><th class=\"text-center\">NPWP</th><th class=\"text-center\">Jabatan</th><th class=\"text-center\">Golongan</th><th class=\"text-center\">Nominal IKW</th>
			<th class=\"text-center\">Pot. IKW</th>
			<th class=\"text-center\">Bruto</th>
			<th class=\"text-center\">Pajak</th>
			<th class=\"text-center\">Jumlah Pajak</th>
			<th class=\"text-center\">Bayar</th>
			<th class=\"text-center\">Pot. Lainnya</th>
			<th class=\"text-center\">Netto</th>
			<th width=\"50px\">&nbsp;</th></tr>";
		$html.="</thead>";
		$i=1;
		$j=1;
		$total_ikw = 0; $total_pot = 0; $total_bruto =0; $total_pajak =0; $total_byr_pajak =0; $total_netto =0; $total_potlainnya = 0;
		$html.="<tbody>";
		foreach ($data as $k => $v) {
			$html.="<tr>";
			$html.="<td class=\"text-center\">";
			$html.="<input tabindex=\"-1\" type=\"checkbox\" name=\"id2[]\" class=\"id_trans2\" value=\"".$v['id_trans']."\"/>";
			$html.="<input type=\"hidden\" name=\"_id2[]\" value=\"".$v['id_trans']."\"/>";
			$html.="<input type=\"hidden\" name=\"byr_stlh_pajak[]\" value=\"".$v['byr_stlh_pajak']."\"/>";
			$html.="</td>";
			$html.="<td class=\"text-right\">".$i.".</td>";
			$html.="<td>".$v['nama']."</td>";
			$html.="<td>".$v['nip']."</td>";
			$html.="<td>'".$v['norekening']."</td>";
			$html.="<td>'".$v['npwp']."</td>";
			$html.="<td>".$v['jabatan']."</td>";
			$html.="<td>".$v['gol']."</td>";
			$html.="<td class=\"text-right\">".number_format($v['ikw'],0,',','.').",-</td>";
			$html.="<td class=\"text-right\">".number_format($v['pot_ikw'],0,',','.').",-</td>";
			$html.="<td class=\"text-right\">".number_format($v['bruto'],0,',','.').",-</td>";
			$html.="<td class=\"text-center\">".number_format($v['pajak']*100,0,',','.')."%</td>";
			$html.="<td class=\"text-right\">".number_format($v['jml_pajak'],0,',','.').",-</td>";
			$html.="<td class=\"text-right\">".number_format($v['byr_stlh_pajak'],0,',','.').",-</td>";
			$html.= "<td class=\"text-center\"><input type=\"text\" name=\"pot_lainnya[]\" class=\"form-control input-sm text-center ikw_ubah_pot_lainnya\" style=\"max-width:100px;display:inline;\" tabindex=\"".$j."\" maxlength=\"15\" id=\"".$v['id_trans']."\" value=\"".$v['pot_lainnya']."\"/></td>";
			$html.="<td class=\"text-right\">".number_format($v['netto'],0,',','.').",-</td>";
			$html.="<td>";
			$html.="<button tabindex=\"-1\" type=\"button\" class=\"btn btn-danger btn-flat btn-sm hapus_single2\" id=\"".$v['id_trans']."\"><i class=\"fa fa-trash\"></i></button>";
			$html.="</td>";
			$html.="</tr>";
			$i++;
			$j+=1;
			$total_ikw += $v['ikw'];
			$total_pot += $v['pot_ikw'];
			$total_bruto += $v['bruto'];
			$total_pajak += $v['jml_pajak'];
			$total_byr_pajak += $v['byr_stlh_pajak'];
			$total_netto += $v['netto'];
			$total_potlainnya += $v['pot_lainnya'];
		}
		$html.="<th class=\"text-center\" colspan=\"8\">TOTAL</th>";
		$html.="<th class=\"text-right\">".number_format($total_ikw,0,',','.').",-</th>";
		$html.="<th class=\"text-right\">".number_format($total_pot,0,',','.').",-</th>";
		$html.="<th class=\"text-right\">".number_format($total_bruto,0,',','.').",-</th>";
		$html.="<th></th>";
		$html.="<th class=\"text-right\">".number_format($total_pajak,0,',','.').",-</th>";
		$html.="<th class=\"text-right\">".number_format($total_byr_pajak,0,',','.').",-</th>";
		$html.="<th class=\"text-right\">".number_format($total_potlainnya,0,',','.').",-</th>";
		$html.="<th class=\"text-right\">".number_format($total_netto,0,',','.').",-</th>";
		$html.="</tbody>";
		$html.="</table>";
		return $html;
	}

	function showDaftarIKWCetak($data){
		$html="";
		$html.="<table class=\"tabel_ikw\" border=\"1\" style=\"border-collapse:collapse;\">";
		$html.="<thead>";
		$html.="<tr> <th class=\"text-center\">No</th><th class=\"text-center\">Nama</th><th class=\"text-center\">NIP</th><th style=\"text-align:center;\">Status</th><th class=\"text-center\">Unit</th><th style=\"text-align:center;\">Bank</th><th class=\"text-center\">No.Rek.</th><th class=\"text-center\">NPWP</th><th class=\"text-center\">Jabatan</th><th class=\"text-center\">Golongan</th><th class=\"text-center\">Nominal IKW</th>
			<th class=\"text-center\">Pot. IKW</th>
			<th class=\"text-center\">Bruto</th>
			<th class=\"text-center\">Pajak</th>
			<th class=\"text-center\">Jumlah Pajak</th>
			<th class=\"text-center\">Bayar</th>
			<th class=\"text-center\">Pot. Lainnya</th>
			<th class=\"text-center\">Netto</th> </tr>";
		$html.="</thead>";
		$i=1;
		$j=1;
		$total_ikw = 0; $total_pot = 0; $total_bruto =0; $total_pajak =0; $total_byr_pajak =0; $total_netto =0; $total_potlainnya = 0;
		$html.="<tbody>";
		foreach ($data as $k => $v) {
			$html.="<tr>";
			$html.="<td class=\"text-right\">".$i.".</td>";
			$html.="<td>".$v['nama']."</td>";
			$html.="<td>'".$v['nip']."</td>";
			$html.="<td>".getStatus($v['status'])."</td>";
			$html.="<td>".getUnit($v['unit_id'])."</td>";
			$html.="<td>".$v['nmbank']."</td>";
			$html.="<td>'".$v['norekening']."</td>";
			$html.="<td>'".$v['npwp']."</td>";
			$html.="<td>".$v['jabatan']."</td>";
			$html.="<td>".$v['gol']."</td>";
			$html.="<td class=\"text-right\">".$v['ikw']."</td>";
			$html.="<td class=\"text-right\">".$v['pot_ikw']."</td>";
			$html.="<td class=\"text-right\">".$v['bruto']."</td>";
			$html.="<td class=\"text-center\">".number_format($v['pajak']*100,0,',','.')."%</td>";
			$html.="<td class=\"text-right\">".$v['jml_pajak']."</td>";
			$html.="<td class=\"text-right\">".$v['byr_stlh_pajak']."</td>";
			$html.= "<td class=\"text-center\">".$v['pot_lainnya']."</td>";
			$html.="<td class=\"text-right\">".$v['netto']."</td>";
			$html.="</tr>";
			$i++;
			$j+=1;
			$total_ikw += $v['ikw'];
			$total_pot += $v['pot_ikw'];
			$total_bruto += $v['bruto'];
			$total_pajak += $v['jml_pajak'];
			$total_byr_pajak += $v['byr_stlh_pajak'];
			$total_netto += $v['netto'];
			$total_potlainnya += $v['pot_lainnya'];
		}
		$html.="<tr>";
		$html.="<th class=\"text-center\" colspan=\"9\">TOTAL</th>";
		$html.="<th class=\"text-right\">".number_format($total_ikw,0,',','.').",-</th>";
		$html.="<th class=\"text-right\">".number_format($total_pot,0,',','.').",-</th>";
		$html.="<th class=\"text-right\">".number_format($total_bruto,0,',','.').",-</th>";
		$html.="<th></th>";
		$html.="<th class=\"text-right\">".number_format($total_pajak,0,',','.').",-</th>";
		$html.="<th class=\"text-right\">".number_format($total_byr_pajak,0,',','.').",-</th>";
		$html.="<th class=\"text-right\">".number_format($total_potlainnya,0,',','.').",-</th>";
		$html.="<th class=\"text-right\">".number_format($total_netto,0,',','.').",-</th>";
		$html.="</tr>";
		$html.="</tbody>";
		$html.="</table>";
		$html.="<p>&nbsp;</p>";
		$html.="<table style=\"width:100%;\">";
		$html.="<tr><td colspan=\"10\"></td><td colspan=\"4\">Semarang, ".balikTgl(date('Y-m-d'))."</td></tr>";
		$html.="<tr><td colspan=\"5\" width=\"35%\">";
		#1
		$html.= "Mengetahui,<br/>";
		$html.= "Pejabat Pembuat Komitmen SUKPA, <br/>";
		$html.= "<br/><br/><br/><br/>";
		$html.= "M. Muntafi, S.Sos<br/>";
		$html.= "NIP. 197007172007011002";
		$html.="</td><td colspan=\"3\" width=\"33%\">";
		#2
		$html.= "<br/>Bendahara Pengeluaran SUKPA, <br/>";
		$html.= "<br/><br/><br/><br/>";
		$html.= "Aryati Eka Dewi<br/>";
		$html.= "NIP. 198101272003122001";
		$html.="</td><td colspan=\"3\" width=\"30%\">";
		#3
		$html.= "<br/>Pembuat Daftar, <br/>";
		$html.= "<br/><br/><br/><br/>";
		$html.= "Asri Setyaning<br/>";
		$html.= "NIP. H.7.1987082910062053";
		$html.="</td></tr>";
		$html.="</table>";
		return $html;
	}
?>
