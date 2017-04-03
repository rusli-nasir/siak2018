<?php
	function getNominalTutam($id,$kel){
		$sql = "SELECT brutto FROM kepeg_tb_nominaltutam WHERE id = ".$id." AND golongan_id = ".$kel;
		$hsl = getdata($sql);
		return $hsl['brutto'];
	}
	$sql =	"SELECT a.nama, a.nip, a.golongan_id, a.unit_id, a.status, d.kelompok, b.tgs_tambahan_id, c.tugas_tambahan, b.det_tgs_tambahan, e.nmbank, e.norekening
	FROM kepeg_tb_pegawai a
	RIGHT JOIN kepeg_tb_riwayat_tgs_tambahan b ON a.id = b.pegawai_id
	LEFT JOIN kepeg_tb_tgs_tambahan c ON b.tgs_tambahan_id = c.id
	LEFT JOIN kepeg_tb_golongan d ON a.golongan_id = d.id
	LEFT JOIN kepeg_tb_rekening e ON a.id = e.pegawai_id
	WHERE b.status_aktif = 1 AND a.nip NOT LIKE '%196006271990011001%' AND ( a.nip LIKE '%195403211980031002%' OR a.nip LIKE '%196605101997022001%' ) AND (a.status = 1 OR a.status = 3 OR a.status = 6 OR a.status = 12) AND e.jenisrek = 2 ORDER BY a.nip, a.nama";
	$dt = getdatadb($sql);
?>
<div style="padding:5px;background-color:#fff;">
<table align="center" class="table table-bordered table-striped small">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>NIP</th>
			<th>Tugas Tambahan</th>
			<th>Unit</th>
			<th>Status</th>
			<th>Lain2</th>
			<th>Nama Bank</th>
			<th>Rekening</th>
			<th>Nominal TuTam</th>
			<th>Pajak</th>
			<th>Jumlah Pajak</th>
			<th>Netto</th>
		</tr>
	</thead>
	<tbody>
<?php
	$i=1;
	$total = 0;
	$total_pajak = 0;
	$total_selanjutnya = 0;
	foreach ($dt as $k => $v) {
		$nominal = getNominalTutam($v['tgs_tambahan_id'],$v['kelompok']);
		if($nominal == 0){
			continue;
		}
		if($v['kelompok']==3){
			$pajak = 0.05;
		}elseif($v['kelompok']==4){
			$pajak = 0.15;
		}
		$nom_pajak = ceil($nominal*$pajak);
		$bersih = $nominal - $nom_pajak;
		$total += $nominal;
		$total_pajak += $nom_pajak;
		$total_selanjutnya += $bersih;
?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $v['nama']; ?></td>
			<td>'<?php echo $v['nip']; ?></td>
			<td><?php echo $v['tugas_tambahan']; ?> <?php echo $v['det_tgs_tambahan']; ?></td>
			<td><?php echo getUnit($v['unit_id']); ?></td>
			<td><?php echo getStatus($v['status']); ?></td>
			<td><?php echo $v['kelompok']."|".$v['tgs_tambahan_id']; ?></td>
			<td><?php echo $v['nmbank']; ?></td>
			<td>'<?php echo $v['norekening']; ?></td>
			<td align="right">'<?php echo $nominal; ?></td>
			<td align="right"><?php echo ($pajak*100); ?> %</td>
			<td align="right">'<?php echo $nom_pajak; ?></td>
			<td align="right">'<?php echo $bersih; ?></td>
		</tr>
<?php
		$i++;
	}
?>
		<tr>
			<td colspan="9">&nbsp;</td>
			<td><?php echo number_format($total,0,',','.'); ?></td>
			<td>&nbsp;</td>
			<td><?php echo number_format($total_pajak,0,',','.'); ?></td>
			<td><?php echo number_format($total_selanjutnya,0,',','.'); ?></td>
		</tr>
	</tbody>
</table>
</div>
