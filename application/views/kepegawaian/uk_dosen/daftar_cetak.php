<h4 style="text-align:center;font-size:16pt;">
	Daftar Dosen yang mendapatkan Uang Kinerja<br />
	<?php echo $this->cantik2_model->nama_unit_kepeg_rba($_SESSION['rsa_kode_unit_subunit']); ?><br />
	Tahun <?php echo $_SESSION['uk_dosen']['tahun']; ?> Semester <?php echo $_SESSION['uk_dosen']['sms']; ?>
</h4>
<table style="border-collapse:collapse;margin-right:auto;margin-left:auto;" border="1">
	<thead>
		<tr>
			<th style="text-align:center;" width="50">No</th>
			<th style="text-align:center;">Nama</th>
			<th style="text-align:center;">NIP</th>
			<th style="text-align:center;">Gol</th>
			<th style="text-align:center;">Unit</th>
			<th style="text-align:center;">Bruto</th>
			<th style="text-align:center;">PPH</th>
			<th style="text-align:center;">Pajak</th>
			<th style="text-align:center;">Netto</th>
			<th style="text-align:center;">NPWP</th>
			<th style="text-align:center;">Bank</th>
			<th style="text-align:center;">No Rek.</th>
			<th style="text-align:center;">Nama</th>
		</tr>
	</thead>
	<tbody>
<?php
if(!is_null($dt) && count($dt)>0){
	$no = 1;
	$total_bruto = 0;
	$total_netto = 0;
	$total_pajak = 0;
	foreach ($dt as $k => $v) {
?>
		<tr>
			<td style="text-align:right;"><?php echo $no; ?></td>
			<td><?php echo $v->nama; ?></td>
			<td style="text-align:center;">'<?php echo $v->nip; ?></td>
			<td style="text-align:center;"><?php echo $v->golpeg; ?></td>
			<td style="text-align:center;"><?php echo $this->cantik2_model->getUnitShort($v->fk_unit); ?></td>
			<td style="text-align:right;"><?php echo $v->bruto; ?></td>
			<td style="text-align:right;"><?php echo ($v->pph*100); ?>%</td>
			<td style="text-align:right;"><?php echo $v->pajak; ?></td>
			<td style="text-align:right;"><?php echo $v->netto; ?></td>
			<td style="text-align:center;">'<?php echo $v->npwp; ?></td>
			<td style="text-align:center;"><?php echo $v->bank; ?></td>
			<td style="text-align:center;">'<?php echo $v->norekening; ?></td>
			<td><?php echo $v->namarekening; ?></td>
		</tr>
<?php
		$total_bruto+=$v->bruto;
		$total_netto+=$v->netto;
		$total_pajak+=$v->pajak;
		$no++;
	}
?>
		<tr>
			<td style="text-align:center;" colspan="5">Total</td>
			<td style="text-align:right;"><?php echo $total_bruto; ?></td>
			<td>&nbsp;</td>
			<td style="text-align:right;"><?php echo $total_pajak; ?></td>
			<td style="text-align:right;"><?php echo $total_netto; ?></td>
			<td style="text-align:center;" colspan="4">&nbsp;</td>
		</tr>
<?php
}else{
?>
		<tr>
			<td style="text-align:center;" colspan="13">tidak ada daftar untuk tahun dan semester tersebut.</td>
		</tr>
<?php
}
?>
	</tbody>
</table>
<p>&nbsp;</p>
<table style="margin-right:auto;margin-left:auto;width:1000px;">
	<tr>
		<td colspan="5" style="border:none;">
			Mengetahui,<br />
			Pejabat Penatausahaan Keuangan SUKPA,<br />
			<br /><br /><br /><br />
			<?php echo $ppk->nm_lengkap; ?><br />
			NIP. <?php echo $ppk->nomor_induk; ?>
		</td>
		<td colspan="4" style="border:none;">
			&nbsp;<br />
			Bendahara Pengeluaran SUKPA,<br />
			<br /><br /><br /><br />
			<?php echo $bpp->nm_lengkap; ?><br />
			NIP. <?php echo $bpp->nomor_induk; ?>
		</td>
		<td colspan="4" style="border:none;">
			'<?php echo date("d")." ".$this->cantik_model->wordMonth(date("m"))." ".date("Y"); ?><br />
			Pembuat Daftar,<br />
			<br /><br /><br /><br />
			.................................<br />
			NIP. ............................
		</td>
	</tr>
</table>
