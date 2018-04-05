<div class="col-md-12">
	<table class="table table-bordered table-condensed small">
		<thead>
			<tr class="info">
				<th class="text-center" width="30">No</th>
				<th class="text-center">Nama/NIP</th>
				<th class="text-center" class="text-center" width="150">Tugas Tambahan</th>
				<th class="text-center" width="80">Gol/Status</th>
				<th class="text-center" class="text-center" width="150">NPWP</th>
				<th class="text-center" width="250">Bank</th>
				<th class="text-center" width="100">Nominal</th>
				<th class="text-center" width="30">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$i=1;
			foreach ($dt as $k => $v) {
		?>
			<tr>
				<td rowspan="3" class="text-right"><?php echo $i; ?></td>
				<td><span class="_update" contenteditable="true" rel="nama.<?php echo $v->id; ?>"><?php echo $v->nama; ?></span></td>
				<td><span class="_update" contenteditable="true" rel="tugas_tambahan.<?php echo $v->id; ?>"><?php echo $v->tugas_tambahan; ?></span></td>
				<td><?php echo $this->cantik2_model->opsiGolongan('golongan_id','golongan_id','_update-select input-sm','golongan_id.'.$v->id,$v->golongan_id); ?></td>
				<td rowspan="3"><span class="_update" contenteditable="true" rel="npwp.<?php echo $v->id; ?>"><?php echo $v->npwp; ?></span></td>
				<td><span class="_update" contenteditable="true" rel="nmbank.<?php echo $v->id; ?>"><?php echo $v->nmbank; ?></span></td>
				<td rowspan="3" class="text-right"><span class="_update" contenteditable="true" rel="nominal.<?php echo $v->id; ?>"><?php echo number_format($v->nominal,0,',','.'); ?></span>,-</td>
				<td rowspan="3">
					<button class="_delete btn btn-xs btn-danger" rel="<?php echo $v->id; ?>"><i class="fa fa-trash"></i></button>
				</td>
			</tr>
			<tr>
				<td><span class="_update" contenteditable="true" rel="nip.<?php echo $v->id; ?>"><?php echo $v->nip; ?></span></td>
				<td><span class="_update" contenteditable="true" rel="det_tgs_tambahan.<?php echo $v->id; ?>"><?php echo $v->det_tgs_tambahan; ?></span></td>
				<td><?php echo $this->cantik2_model->opsiStatus('status','status','_update-select input-sm','status.'.$v->id,$v->status); ?></td>
				<td><span class="_update" contenteditable="true" rel="norekening.<?php echo $v->id; ?>"><?php echo $v->norekening; ?></span></td>
			</tr>
			<tr>
				<td style="background: #eee;" colspan="3">&nbsp;</td>
				<td><span class="_update" contenteditable="true" rel="nmpemilik.<?php echo $v->id; ?>"><?php echo $v->nmpemilik; ?></span></td>
			</tr>
		<?php
				$i++;
			}
		?>	
		</tbody>
	</table>
</div>
