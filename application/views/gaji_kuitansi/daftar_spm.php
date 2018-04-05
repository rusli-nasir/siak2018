<script>
$(document).ready(function(){


});
	

</script>

<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<div>
					<h2>SPM</h2><hr>

				</br>
				<table class="table table-striped">
					<thead>
						<tr class="" style="" >
							<th class="col-md-1" style="text-align: center;" >No</th>
							<th class="col-md-4">Nomor SPM</th>
							<th class="col-md-1">Jenis</th>
							<th class="col-md-2"></th>
							<th class="col-md-2">Nominal</th>
							<th class="col-md-2" style="text-align: center;">Aksi</th>
						</tr>
					</thead>
					<tbody id="row_space">
						<?php $i = 1 ?>
						<?php foreach ($spm as $key => $spm_cair): ?>
							
							<tr>
								<td style="text-align: center;">
									<?php echo $i ?>
								</td>
								<td>
									<?php echo $spm_cair->str_nomor_trx_spm ?>
								</td>
								<td>
									<?php echo $spm_cair->jenis_trx ?>
								</td>
								<td class="">
									<?php if ($jumlah > 0): ?>
										kuitansi baru : <span class="badge badge-danger"><?=$jumlah?>
									<?php else: ?>
										kuitansi baru : <span class="badge badge-success"><?=$jumlah?>
									<?php endif ?>
								</td>
								<td style="text-align: right;">
									<?php echo number_format($spm_cair->nominal,0,',','.') ?>
								</td>
								<td style="text-align: center;">
									<a type="button" class="spm_cair btn btn-danger btn-sm" rel=""id="" aria-label="Center Align" href="<?=site_url('rsa_gaji_kuitansi/kuitansi/'.urlencode(base64_encode($spm_cair->str_nomor_trx_spm)))?>">GO !</a>
								</td>
							</tr>
							<?php  $i++; endforeach  ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>