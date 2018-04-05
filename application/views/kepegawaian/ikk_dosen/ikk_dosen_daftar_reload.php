<p>&nbsp;</p>
<?php
	if(!is_null($dt) && count($dt)>0){
?>
<div class="text-right">
	<button class="btn btn-default print_daftar" type="button"><i class="glyphicon glyphicon-print"></i>&nbsp;<i class="glyphicon glyphicon-th-list"></i> Cetak Daftar</button>
</div>
<p>&nbsp;</p>
<?php
	}
?>
<table class="small table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th class="text-center" width="50">No</th>
			<th class="text-center">Nama/NIP</th>
			<th class="text-center">Gol</th>
			<th class="text-center">Unit</th>
			<th class="text-center">100% IKK</th>
			<th class="text-center">Komposisi</th>
			<th class="text-center">Bruto</th>
			<th class="text-center">PPH</th>
			<th class="text-center">Pajak</th>
			<th class="text-center">Netto</th>
			<th class="text-center">Bank/No Rek./Nama</th>
			<th width="50"><button class="btn btn-xs btn-danger del_daftar" type="button"><i class="glyphicon glyphicon-trash"></i>&nbsp;<i class="glyphicon glyphicon-th-list"></i></button></th>
		</tr>
	</thead>
	<tbody>
<?php
if(!is_null($dt) && count($dt)>0){
	$no = 1;
	$total_bruto = 0;
	$total_netto = 0;
	$total_dapat = 0;
	$total_pajak = 0;
	foreach ($dt as $k => $v) {
?>
		<tr>
			<td class="text-right"><?php echo $no; ?></td>
			<td><?php echo $v->nama; ?><br /><?php echo $v->nip; ?></td>
			<td class="text-center"><?php echo $v->gol; ?></td>
			<td class="text-center"><?php echo $this->cantik2_model->getUnitShort($v->fk_unit); ?></td>
			<td class="text-right"><?php echo $this->cantik_model->number($v->total_dapat); ?></td>
			<td class="text-center"><?php echo $this->cantik_model->showkomposisi($v->komposisi,$v->sks_ikw,$v->fk_fak,$v->fk_unit); ?></td>
			<td class="text-right"><?php echo $this->cantik_model->number($v->bruto); ?></td>
			<td class="text-right"><?php echo ($v->pph*100); ?>%</td>
			<td class="text-right"><?php echo $this->cantik_model->number($v->pajak); ?></td>
			<td class="text-right"><?php echo $this->cantik_model->number($v->netto); ?></td>
			<td><?php echo $v->bank; ?><br /><?php echo $v->norekening; ?><br /><?php echo $v->namarekening; ?></td>
			<td class="text-center">
				<button class="btn btn-xs btn-danger del_item" type="button" rel="<?php echo $v->id; ?>"><i class="glyphicon glyphicon-trash"></i></button>
			</td class="text-center">
		</tr>
<?php
		$total_dapat+=$v->total_dapat;
		$total_bruto+=$v->bruto;
		$total_netto+=$v->netto;
		$total_pajak+=$v->pajak;
		$no++;
	}
?>
		<tr>
			<td class="text-center" colspan="4">Total</td>
			<td class="text-right"><?php echo $this->cantik_model->number($total_dapat); ?></td>
			<td>&nbsp;</td>
			<td class="text-right"><?php echo $this->cantik_model->number($total_bruto); ?></td>
			<td>&nbsp;</td>
			<td class="text-right"><?php echo $this->cantik_model->number($total_pajak); ?></td>
			<td class="text-right"><?php echo $this->cantik_model->number($total_netto); ?></td>
			<td class="text-center" colspan="4">&nbsp;</td>
		</tr>
<?php
}else{
?>
		<tr>
			<td class="text-center info" colspan="15">tidak ada daftar untuk tahun dan semester tersebut.</td>
		</tr>
<?php
}
?>
	</tbody>
</table>
