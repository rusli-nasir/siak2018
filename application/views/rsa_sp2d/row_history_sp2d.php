
<h3>No. SPM <span style="color:#e69a0f;"><?php echo $no_spm ?></span></h3>
<table class="table table-striped table-bordered" style="font-size: 12px;">
	<thead>
		<th style="vertical-align: middle;">No</th>
		<th style="vertical-align: middle;width: 90px;">Tanggal</th>
		<th style="vertical-align: middle;">Jenis</th>
		<th style="vertical-align: middle;width: 210px;">No.SP2D/No.RETUR</th>
		<th style="vertical-align: middle;">Bank</th>
		<th style="vertical-align: middle;">Nominal</th>
		<th style="vertical-align: middle;">Jenis SP2D/RETUR</th>
		<th style="vertical-align: middle;">Keterangan</th>
	</thead>
	<tbody>
		<?php if (!empty($history)): ?>
			<?php $i=1; foreach ($history as $data): ?>
			<?php 
				$color = '';
				if ($data->jenis_trx == 'RETUR') {
					$color = '#d9534f';
				}elseif ($data->jenis_trx == 'SP2D') {
					$color = '#009688';
				}

				if (!empty($nominal_sp2d_retur)) {
					$persentase = ($nominal_sp2d_retur/$nominal_cair) * 100;
					$color_persen = '';
					if ($persentase == 100) {
						$color_persen = '#84e891';
					}else{
						$color_persen = '#ffd07a';
					}
				}

			?>
				<tr>
					<td><?php echo $i ?></td>
					<td class="text-center"><?php echo $data->tgl_trx ?></td>
					<td class="text-center"><span class="label" style="background-color: <?php echo $color ?>;font-size: 12px;"><?php echo $data->jenis_trx ?></span></td>
					<td><?php echo $data->no_trx ?></td>
					<td><?php echo $data->bank ?></td>
					<td class="text-right"><span style="color: <?php echo $color ?>;"><?php echo number_format($data->nominal,2,',','.') ?></span></td>
					<td><?php echo $data->jenis_sp2d_retur ?></td>
					<td><?php echo $data->keterangan ?></td>
				</tr>
			<?php $i++; endforeach ?>
		<?php else: ?>
			<tr>
				<td colspan="8" class="text-center">- Tida Ada Data -</td>
			</tr>
		<?php endif ?>
		<?php if (!empty($nominal_sp2d_retur)): ?>
			<tr>
				<td colspan="5" class="text-right"><b>Total SP2D</b></td>
				<td colspan="2" class="text-right">Rp. <?php echo number_format($nominal_sp2d_retur,2,',','.') ?></td>
				<td rowspan="2" class="text-center" style="vertical-align: middle;font-size: 20px;background-color: <?php echo $color_persen; ?>;"><b><?php echo number_format($persentase,2,',','.'); ?>% Cair</b></td>
			</tr>
			<tr>
				<td colspan="5" class="text-right"><b>Nominal SPM Cair</b></td>
				<td colspan="2" class="text-right">Rp. <?php echo number_format($nominal_cair,2,',','.') ?></td>
			</tr>
		<?php endif ?>
	</tbody>
</table>