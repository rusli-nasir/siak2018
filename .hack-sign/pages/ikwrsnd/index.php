<?php
// untuk RSND
		$sql = "SELECT a.nama, a.nip, a.jnspeg, a.status, a.status_kepeg, a.jabatan_id, b.kelompok, b.gol, c.jabatan, d.nmbank, d.norekening, a.npwp, c.bobot
					FROM kepeg_tb_pegawai a
					LEFT JOIN kepeg_tb_golongan b ON a.golongan_id = b.id
					LEFT JOIN kepeg_tb_jabatan c ON a.jabatan_id = c.id
					LEFT JOIN kepeg_tb_rekening d ON a.id = d.pegawai_id
					WHERE ( a.status_kepeg = 1 OR a.status_kepeg = 2 OR a.status_kepeg = 3 )
					AND ( a.status = 1 OR a.status = 3 OR a.status = 6 OR a.status = 12 )
					AND unit_id = 27 AND jenisrek = 2
					ORDER BY a.golongan_id DESC, a.nip, a.nama";
		$dt = getdatadb($sql);

		function getIKWRSND($id,$kel){
			/*if($id<=5){
				$id = 6;
			}*/
			$sql = 'SELECT bruto FROM kepeg_tb_ikw_rsnd WHERE grade_id = '.$id.' AND golongan_id = '.$kel;
			//return $sql;
			$dt = getdata($sql);
			return $dt['bruto'];
		}
?>
<form id="masukkan-db">
<input type="hidden" name="act" value="ikw_proses_rsnd"/>
<input type="hidden" name="bulan" value="<?php echo date('m'); ?>"/>
<input type="hidden" name="tahun" value="<?php echo date('Y'); ?>"/>
<input type="hidden" name="unit_id" value="27"/>
<input type="hidden" name="jenisrek" value="2"/>
<input type="hidden" name="status_kepeg" value="1,2,3"/>
<input type="hidden" name="status" value="1,3,6,12"/>
<div class="col-md-12" style="background-color:#ccc;padding:5px;">
	<div class="col-md-12" style="background-color:#fff;">
		<div class="row">
			<div class="page-header">
				<h3 class="text-center">Biaya IKW untuk Tendik Rumah Sakit Pendidikan Universitas Diponegoro</h3>
				<h4 class="text-center">Bulan <?php echo wordMonth(date('m')); ?> Tahun <?php echo date('Y'); ?></h4>
                <p class="text-center"><button type="button" class="btn btn-default btn-sm simpan-db">Simpan ke DB</button></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="background-color:#fff;padding:5px;">
				<table class="table table-bordered table-striped small">
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>NIP</th>
						<th>Jenis Pegawai</th>
						<th>Status</th>
						<th>Jabatan</th>
						<th>NPWP</th>
						<th>Bank</th>
						<th>No Rek.</th>
						<th>Bruto</th>
						<th>Pajak</th>
						<th>Jumlah Pajak</th>
						<th>Netto</th>
					</tr>
<?php
	$i=1;
	$total_bruto = 0;
	$total_pajak = 0;
	$total_netto = 0;
	foreach ($dt as $k => $v) {
		$pajak = 0;
		$kelompok = $v['kelompok'];
		if($v['kelompok']<=2 && $v['status_kepeg']==2){
			$kelompok = 3;
		}
		if($v['kelompok']<=3 && $v['status_kepeg']==2 && strlen(trim($v['npwp']))>0){
			$pajak = 0.05;
		}elseif($v['kelompok']<=3 && $v['status_kepeg']==2 && strlen(trim($v['npwp']))<=0){
			$pajak = 0.06;
		}elseif($v['kelompok']==4){
			$pajak = 0.15;
		}else{
			if($kelompok==3){
				$pajak = 0.05;
			}
		}
		$nominal = getIKWRSND($v['bobot'], $kelompok);
		if($v['status']==12){
			$nominal = $nominal*0.75; // 75%
		}
		$jml_pajak = ceil($pajak*$nominal);
		$netto = $nominal-$jml_pajak;
		$total_bruto+=$nominal;
		$total_pajak+=$jml_pajak;
		$total_netto+=$netto;
		$cls = "";
		if(strlen(trim($nominal))<=0){
			$cls = " style=\"background-color:#ccc;\"";
		}
?>
					<tr<?php echo $cls; ?>>
						<td><?php echo $i; ?></td>
						<td><?php echo $v['nama']; ?></td>
						<td>'<?php echo $v['nip']; ?></td>
						<td><?php echo getStatusKepeg($v['status_kepeg']); ?></td>
						<td><?php echo getStatus($v['status']); ?></td>
						<td><?php echo $v['jabatan']; ?></td>
						<td>'<?php echo $v['npwp']; ?></td>
						<td><?php echo $v['nmbank']; ?></td>
						<td>'<?php echo $v['norekening']; ?></td>
						<td class="text-right"><?php echo $nominal; ?></td>
						<td class="text-center"><?php echo $pajak*100; ?>%</td>
						<td class="text-right"><?php echo $jml_pajak; ?></td>
						<td class="text-right"><?php echo $netto; ?></td>
					</tr>
<?php
		$i++;
	}
?>
					<tr>
						<td colspan="9">&nbsp;</td>
						<td class="text-right"><?php echo $total_bruto; ?></td>
						<td>&nbsp;</td>
						<td class="text-right"><?php echo $total_pajak; ?></td>
						<td class="text-right"><?php echo $total_netto; ?></td>
					</tr>
				</table>
                <table class="table small" style="border:0;">
				<?php
                	$html.="<tr><td width=\"33%\">";
					#1
					$html.= "Mengetahui,<br/>";
					$html.= "Pejabat Pembuat Komitmen SUKPA, <br/>";
					$html.= "<br/><br/><br/><br/>";
					$html.= "Lulut Handayani, SE.<br/>";
					$html.= "NIP. 198305012005012001";
					$html.="</td><td width=\"34%\">";
					#2
					$html.= "<br/>Bendahara Pengeluaran SUKPA, <br/>";
					$html.= "<br/><br/><br/><br/>";
					$html.= "Anggraeni Dewi Lestari<br/>";
					$html.= "NIP. 196809102007012001";
					$html.="</td><td width=\"33%\">";
					#3
					$html.= "Semarang, ".date("d")." ".wordMonth(date('m'))." ".date('Y')."<br/>Pembuat Daftar, <br/>";
					$html.= "<br/><br/><br/><br/>";
					$html.= "Eni {....}<br/>";
					$html.= "NIP. {maaf isi sendiri}";
					$html.="</td></tr>";
					echo $html;
				?>
                </table>
			</div>
		</div>
	</div>
</div>
</form>