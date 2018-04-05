<script>


</script>

<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<div>
					<h3>Kuitansi</h3><hr>

				<div class="alert alert-warning col-lg-4">
					SPM : <span style="color: ;"><?php echo base64_decode(urldecode($this->uri->segment(3))) ?></span>
				</div>
				</br>
				<table class="table table-striped">
					<thead>
						<tr class="" style="" >
							<th class="col-md-1" style="text-align: center;" >No</th>
							<th class="col-md-5">Nomor Bukti</th>
							<th class="col-md-2">Akun</th>
							<th class="col-md-2"></th>
							<th class="col-md-2" style="text-align: center;">Aksi</th>
						</tr>
					</thead>
					<tbody id="row_space">
						<?php $i = 1 ?>
						<?php foreach ($kuitansi as $key => $kuitansi): ?>
							
							<tr>
								<td style="text-align: center;">
									<?php echo $i ?>
								</td>
								<td>
									<?php echo $kuitansi->no_bukti ?>
								</td>
								<td>
									<?php echo $kuitansi->kode_akun4digit ?>
								</td>
								<td>
									<?php if ($jumlah > 0): ?>
										kuitansi baru : <span class="badge badge-danger"><?=$jumlah?>
									<?php else: ?>
										kuitansi baru : <span class="badge badge-success"><?=$jumlah?>
									<?php endif ?>
								</td>
								<td style="text-align: center;">
									<a type="button" class="spm_cair btn btn-danger btn-sm" rel=""id="" aria-label="Center Align" href="<?=site_url('rsa_gaji_kuitansi/detail_kuitansi/'.urlencode(base64_encode($kuitansi->no_bukti)))?>">GO !</a>
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

<div class="modal" id="lihat_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="margin-top: 80px;">
		<div class="modal-content" id="modal_content">
		</div>
	</div>
</div>