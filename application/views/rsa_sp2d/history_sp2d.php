<script type="text/javascript">
	$(document).ready(function(){
		$('#tgl_sp2d').datepicker({
			format: "yyyy-mm-dd"
		});

		$(document).on("submit","#form_cari_riwayat_sp2d",function(e){

			var no_spm = $.trim($('#no_spm').val());

			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_sp2d/search_riwayat_sp2d")?>",
				data:'no_spm='+no_spm,
				success:function(data){
					$('#data_riwayat').html(data);
				}
			});

		});
	});        

	function string_to_angka(str){
		return parseInt(str.split('.').join(""));
	}

	function angka_to_string(num){
		var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		return str_hasil;
	}

</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->

		<div class="tab-base">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/tambah_sp2d') ?>#tambah_sp2d"><b>Tambah SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d') ?>#daftar_sp2d"><b>Daftar SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d') ?>#retur"><b>Retur</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d') ?>#daftar_retur"><b>Daftar RETUR</b></a></li>
				<li role="presentation" class="active"><a href="#history_sp2d" aria-controls="history_sp2d" role="tab" data-toggle="tab"><b>Riwayat SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/sp2d_per_spm') ?>"><b>Laporan SP2D per SPM</b></a></li>
			</ul>
		</div>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="tambah_sp2d">
				<div class="row">
					<div class="col-lg-12">
						<h2>Riwayat SP2D</h2> 
					</div>
				</div>
				<hr />

				<div class="row">
					<div class="col-md-12">
						<form id="form_cari_riwayat_sp2d" onsubmit="return false">
							<span><strong>Masukan No. SPM</strong></span>
							<div class="input-group">
								<label class="input-group-addon btn" for="no_spm">
									&nbsp;<i class="fa fa-search"></i>
								</label>
								<input type="text" class="validate[required] form-control readonly" id="no_spm" name="no_spm" required>
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari Riwayat</button>
								</span>
							</div>
						</form>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12" id="data_riwayat">
						<?php if (!empty($this->uri->segment(3))): ?>
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
											<td><span style="color: <?php echo $color ?>;"><?php echo number_format($data->nominal,2,',','.') ?></span></td>
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
						<?php endif ?>
					</div>
				</div>

			</div>
		</div>
		<!-- end content -->
	</div>
</div>