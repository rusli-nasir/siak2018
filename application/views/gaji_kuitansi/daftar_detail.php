<script>


</script>

<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<div>
					<h3>Detail Kuitansi</h3><hr>

				<div class="alert alert-warning col-lg-4">
					NO KUITANSI : <span style="color: ;"><?php echo base64_decode(urldecode($this->uri->segment(3))) ?></span>
				</div>
				</br>
				<table class="table table-striped">
					<thead>
						<tr class="" style="" >
							<th class="col-md-1" style="text-align: center;" >No</th>
							<th class="col-md-5">Kode Usulan Belanja</th>
							<th class="col-md-2">Akun Tambah</th>

							<th class="col-md-2" style="text-align: center;">Aksi</th>
						</tr>
					</thead>
					<tbody id="row_space">
						<?php $i = 1 ?>
						<?php foreach ($detail as $key => $kuitansi): ?>
							
							<tr>
								<td style="text-align: center;">
									<?php echo $i ?>
								</td>
								<td>
									<?php echo $kuitansi->kode_usulan_belanja ?>
								</td>
								<td>
									<?php echo $kuitansi->kode_akun_tambah ?>
								</td>
								<td style="text-align: center;">
									<button type="button" class="spm_cair btn btn-info btn-sm" id="" aria-label="Center Align" >TAMBAH</button>
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