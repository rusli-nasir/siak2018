	<div class="modal-header blue-gradient text-white">
		<button type="button" class="close" data-dismiss="modal" style="color: #fff;opacity: 1;">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
		<h3 class="modal-title text-center" id="myModalLabel">
			<b style="color:#fff;">Daftar Riwayat SP2D</b>
		</h3>
		<h4 class="modal-title text-center" id="myModalLabel">
			<b>No.SPM <span style="color: yellow;"><?php echo $no_spm ?></span></b>
		</h4>
	</div>

	<div class="modal-body" style="padding-top: 50px;padding-bottom: 50px;">

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
				<?php if (!empty($list_riwayat)): ?>
					<?php $i=1; foreach ($list_riwayat as $key => $value): ?>
						<?php foreach ($list_riwayat[$key]['data_sp2d'] as $key2 => $value2): ?>
						<?php 
						$color = '';
						if ($value2['jenis_trx'] == 'RETUR') {
							$color = '#e47c32';
						}elseif ($value2['jenis_trx'] == 'SP2D') {
							$color = '#009688';
						}

						if (!empty($value['persentase'])) {
							$color_persen = '';
							if ($value['persentase'] == 100) {
								$color_persen = '#84e891';
							}else{
								$color_persen = '#ffb988';
							}
						}

						?>
						<tr>
							<td><?php echo $i ?></td>
							<td class="text-center"><?php echo $value2['tgl_trx'] ?></td>
							<td class="text-center"><span class="label" style="background-color: <?php echo $color ?>;font-size: 12px;"><?php echo $value2['jenis_trx'] ?></span></td>
							<td>
								<?php echo $value2['no_trx'] ?>
								<button type="button" id="cetak_sp2d" title="cetak" class="btn btn-xs btn-default cetak" rel="<?php echo urlencode(base64_encode($value2['no_trx'])); ?>">
									<i class="fa fa-print"></i>
								</button>
							</td>
							<td><?php echo $value2['bank'] ?></td>
							<td class="text-right"><span style="color: <?php echo $color ?>;"><?php echo number_format(abs($value2['nominal']),2,',','.') ?></span></td>
							<td class="text-center"><?php if($value2['jenis_sp2d_retur']!=null){echo $value2['jenis_sp2d_retur'];}else{ echo 'Retur';} ?></td>
							<td><?php echo $value2['keterangan'] ?></td>
						</tr>
						<?php $i++; endforeach ?>
					<?php endforeach ?>
				<?php else: ?>
					<tr>
						<td colspan="8" class="text-center">- Tida Ada Data -</td>
					</tr>
				<?php endif ?>
				<?php if (!empty($value2['nominal'])): ?>
				<tr>
					<td colspan="5" class="text-right" style="color: red;border-bottom: none;"><b>Potongan Lainnya</b></td>
					<td class="text-right" style="color: red;border-bottom: none;">Rp. <?php echo number_format($value['potongan_lainnya'],2,',','.') ?></td>
					<td rowspan="3" colspan="2" class="text-center" style="vertical-align: middle;font-size: 20px;background-color: <?php echo $color_persen; ?>;"><b><?php echo $value['persentase']; ?> Cair</b></td>
				</tr>
				<tr>
					<td colspan="5" class="text-right" style="border-top:1px solid #000;"><b>Total SP2D</b></td>
					<td class="text-right" style="border-top:3px solid #000;">Rp. <?php echo number_format($value['total_sp2d'],2,',','.') ?></td>
				</tr>
				<tr>
					<td colspan="5" class="text-right"><b>Nominal SPM Cair</b></td>
					<td class="text-right">Rp. <?php echo number_format($value['nominal_cair'],2,',','.') ?></td>
				</tr>
				<?php endif ?>
			</tbody>
		</table>

		<div id="hidden-table" style="display:none">
			<table class="" id="table-sp2d">
				<thead>
					<tr style="" >
						<th class="" style="text-align:center;vertical-align: middle;text-transform: uppercase;" colspan="7">
							<h5><b>
								UNIVERSITAS DIPONEGORO<br/>
								LAPORAN SP2D<br/>
								TAHUN ANGGARAN 2018<br/>
								NO. SPM <?php echo $no_spm ?>
							</b>
						</h5>
					</th>
				</tr>
				<tr>
					<th class="text-center" style="vertical-align: middle;text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">NO SPM</th>
					<th class="text-center" style="text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">KETERANGAN</th>
					<th class="text-center" style="text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">NOMINAL</th>
					<th class="text-center" style="text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">NO SP2D/RETUR</th>
					<th class="text-center" style="text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">TANGGAL SP2D</th>
					<th class="text-center" style="text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">BANK</th>
					<th class="text-center" style="text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">UNIT</th>
				</tr>
			</thead>
			<tbody id="tb-hidden" >
				<?php if (count($list_riwayat) == 0): ?>
					<tr>
						<td style="text-align: center;">
							--tidak ada data--
						</td>
					</tr>
				<?php endif ?>
				<?php foreach ($list_riwayat as $key => $value): ?>
					<?php $tmp_array = array(); ?>
					<?php foreach ($list_riwayat[$key]['data_sp2d'] as $key2 => $value2): ?>
						<tr <?php if($value2['jenis_sp2d']=='Retur'){echo 'style="color:#e47c32;"';} ?>>
							<?php if (!in_array($value2['no_spm'], $tmp_array)): ?>
								<td class="text-center" rowspan="<?php echo count($list_riwayat[$key]['data_sp2d'])+1; ?>" style="vertical-align: middle;padding: 2px;border-bottom: 0px;text-align: center;"><?php echo $value2['no_spm']; ?></td>
							<?php endif ?>
							<td style="vertical-align: middle;padding: 2px;"><b style="text-transform: uppercase;">[<?php if($value2['jenis_sp2d']==null){echo 'RETUR';}else{echo strtoupper( $value2['jenis_sp2d']);} ?>]</b> <?php echo $value2['keterangan']; ?></td>
							<td class="text-right" style="vertical-align: middle;padding: 2px;text-align: right;"><?php echo number_format(abs($value2['nominal']),0,',','.'); ?></td>
							<td class="text-center" style="vertical-align: middle;padding: 2px;text-align: center;"><?php echo $value2['no_trx']; ?></td>
							<td class="text-center" style="vertical-align: middle;padding: 2px;text-align: center;"><?php echo $value2['tgl_trx']; ?></td>
							<td class="text-left" style="vertical-align: middle;padding: 2px;text-align: left;"><?php echo $value2['bank']; ?></td>
							<?php if (!in_array($value2['no_spm'], $tmp_array)): ?>
								<td rowspan="<?php echo count($list_riwayat[$key]['data_sp2d'])+3; ?>" class="text-center" style="border-bottom: 0px;width: 50px;vertical-align: middle;text-align: center;"><?php echo $value2['nama_unit']; ?></td>
								<?php $tmp_array[] = $value2['no_spm']; ?>
							<?php endif ?>
							<?php $tmp_array[] = $value2['no_spm']; ?>
						</tr>
					<?php endforeach ?>
					<tr>
						<td style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;border-bottom: none;color: red;">POTONGAN LAINNYA</td>
						<td class="text-right td_bottom_tebel" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;border-bottom: 3px solid #000;color: red;text-align: right;"><?php echo number_format($value['potongan_lainnya'],0,',','.'); ?></td>
						<td colspan="3" class="text-center" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;font-size: 16px;border-bottom: none;">&nbsp;</td>
					</tr>
					<tr>
						<td class="text-center" rowspan="2" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;text-align: center;">TOTAL</td>
						<td style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;">BRUTO SP2D</td>
						<td class="text-right" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;text-align: right;"><?php echo number_format($value['total_sp2d'],0,',','.'); ?></td>
						<td rowspan="2" colspan="3" class="text-center" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;font-size: 16px;text-align: center;"><b><?php echo $value['persentase']; ?></b></td>
					</tr>
					<tr>
						<td style="vertical-align: middle;padding: 2px;">BRUTO SPM CAIR</td>
						<td class="text-right" style="vertical-align: middle;padding: 2px;text-align: right;"><?php echo number_format($value['nominal_cair'],0,',','.'); ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	</div>

	<div class="modal-footer" style="text-align: center;">
		<button type="button" id="download_riwayat" class="btn btn-success btn-sm" data-no-spm="<?php echo $no_spm ?>" aria-label="Center Align">
			<i class="fa fa-download"></i> Download (.xls)
		</button>
		<!-- <button type="button" id="cetak_riwayat" class="btn btn-primary btn-sm" aria-label="Center Align">
			<i class="fa fa-print"></i> Cetak
		</button> -->
		<button type="button" id="close_riwayat_sp2d_modal" class="btn btn-danger btn-sm" aria-label="Center Align" data-dismiss="modal" style="float: right;">
			Tutup
		</button>
	</div>

<script>
	$(document).ready(function(){
		$(document).on("click","#cetak_sp2d",function(){
			var no_sp2d = $(this).attr('rel');
			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_sp2d/cetak_sp2d_retur/")?>"+no_sp2d,
				data:'',
				success:function(respon){
					if (respon != ""){
						$('#div_cetak').html(respon);
						$('#div_cetak').show();
						var mode = 'iframe';
						var close = mode == "popup";
						var options = { mode : mode, popClose : close};
						$("#div_cetak").printArea( options );
						$('#div_cetak').html('');
						$('#div_cetak').hide();
					}
				}
			});
		});
	});
</script>