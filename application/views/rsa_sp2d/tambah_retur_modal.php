<script>
	$('#tgl_retur').datepicker({
		format: "yyyy-mm-dd",
	}).on('changeDate', function (e) {
		var bulan = new Date(e.date).getMonth() + 1;
		var tahun = String(e.date).split(" ")[3];

		if (bulan == "1") {
			var bulan_str = "JAN";
		}else if (bulan == "2") {
			var bulan_str = "FEB";
		}else if (bulan == "3") {
			var bulan_str = "MAR";
		}else if (bulan == "4") {
			var bulan_str = "APR";
		}else if (bulan == "5") {
			var bulan_str = "MEI";
		}else if (bulan == "6") {
			var bulan_str = "JUN";
		}else if (bulan == "7") {
			var bulan_str = "JUL";
		}else if (bulan == "8") {
			var bulan_str = "AGU";
		}else if (bulan == "9") {
			var bulan_str = "SEP";
		}else if (bulan == "10") {
			var bulan_str = "OKT";
		}else if (bulan == "11") {
			var bulan_str = "NOV";
		}else if (bulan == "12") {
			var bulan_str = "DES";
		}

		var no_retur = $("#new_no_retur").val();
		// alert();
		$("#new_no_retur").val(no_retur.replace(no_retur.substr(-8,8),bulan_str+"/"+tahun));
		// console.log('ddasda');
	});
	$('#nominal').focus(function() {
		if ($(this).val()==0) {
			$(this).val('');
		}
	});
</script>
<form id="form_retur" onsubmit="return false">
	<input type="hidden" id="kode_unit_subunit" name="kode_unit_subunit" value="<?php echo $kode_unit_subunit ?>" required>
	<input type="hidden" id="jenis" name="jenis" value="<?php echo $jenis ?>" required>
	<input type="hidden" id="nominal_sp2d" name="nominal_sp2d" value="<?php echo $nominal_sp2d ?>" required>
	<input type="hidden" id="potongan_lainnya" name="potongan_lainnya" value="<?php echo $potongan_lainnya ?>" required>

	<input type="hidden" id="id_trx_urut_spm_cair" value="<?php echo $id_trx_urut_spm_cair ?>">

	<div class="modal-header peach-gradient text-white">
		<button type="button" class="close" data-dismiss="modal" style="color: #fff;opacity: 1;">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
		<h3 class="modal-title text-center" id="myModalLabel">
			<b style="color:#000;">Formulir Retur SP2D</b>
		</h3>
		<h4 class="modal-title text-center" id="myModalLabel" style="color: #000;">
			<b>No.SPM <span style="color: #631d01;"><?php echo $no_spm ?></span></b>
		</h4>
	</div>

	<div class="modal-body">
		<div class="row">
			<div class="col-md-5">
				<h4>Riwayat</h4>
				<table class="table table-striped table-bordered" style="font-size: 12px;">
					<thead>
						<tr>
							<th class="text-center" style="min-width: 100px;vertical-align: middle;">Tanggal</th>
							<th style="min-width: 150px;" class="text-center" style="vertical-align: middle;">Jenis</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($list_riwayat)): ?>
							<?php foreach ($list_riwayat as $data): ?>
								<?php 
								$color = '';
								if ($data->jenis_trx == 'RETUR') {
									$color = '#e47c32';
								}elseif ($data->jenis_trx == 'SP2D') {
									$color = '#009688';
								}

								?>
								<tr>
									<td class="text-center" style="vertical-align: middle;"><?php echo $data->tgl_trx ?></td>
									<td class="text-center" style="vertical-align: middle;"><span class="label" style="background-color: <?php echo $color ?>;font-size: 12px;"><?php echo $data->jenis_trx ?></span> <?php if($data->jenis_sp2d_retur!=null){echo '- '.$data->jenis_sp2d_retur;} ?></td>
									<td><?php echo $data->keterangan ?></td>
								</tr>
							<?php endforeach ?>
						<?php else: ?>
							<tr>
								<td style="text-align: center;" colspan="3">
									--tidak ada data--
								</td>
							</tr>
						<?php endif ?>
					</tbody>
				</table>
			</div>
			<div class="col-md-7" style="border-left: 1px solid #ddd;">
				<table class="table-condensed" style="width: 100%;">
					<tbody>
						<tr>
							<td><b>Nomor SPM Cair</b></td>
							<td><b>:</b></td>
							<td align="left">
								<input type="text" class="validate[required] form-control" id="no_spm" name="no_spm" value="<?php echo $no_spm ?>" disabled  required>
							</td>
						</tr>
						<tr>
							<td><b>Nomor RETUR</b></td>
							<td><b>:</b></td>
							<td align="left">
								<input type="text" class="validate[required] form-control" id="new_no_retur" name="no_retur" value="<?php echo $new_no_retur ?>" required>
								<input type="hidden" class="validate[required] form-control" id="new_no_retur_tmp" name="new_no_retur_tmp" value="<?php echo $new_no_retur ?>" required>
								<input type="hidden" class="validate[required] form-control" id="no_retur_sblm_tmp" name="no_retur_sblm_tmp" value="<?php echo $no_retur_sblm ?>" required>
								<input type="hidden" class="validate[required] form-control" id="no_retur_encoded" name="no_retur_encoded" value="<?php echo urlencode(base64_encode($new_no_retur)) ?>"
								<?php if (substr($no_retur_sblm,0,4)!=0000): ?>
								<span>
									<input type="checkbox" name="no_retur_sblm" id="no_retur_sblm" value="1" style="width:20px;background-color: blue;position:relative;left: 0px;margin:0px;">
									<label for="no_retur_sblm" style="font-weight: normal;width:200px;position:relative;left: 0px;display:inline-block;vertical-align:middle; ">No.RETUR Sebelum</label>
								</span>
								<?php endif ?>
							</td>
						</tr>
						<tr>
							<td><b>Tanggal RETUR</b></td>
							<td><b>:</b></td>
							<td align="left">
								<div class="input-group">
									<label class="input-group-addon btn" for="tgl_retur">
										&nbsp;<span class="glyphicon glyphicon-calendar"></span>
									</label>  
									<input type="text" class="validate[required] form-control readonly" id="tgl_retur" name="tgl_retur">
								</div>
							</td>
						</tr>
						<tr>
							<td><b>Bank</b></td>
							<td><b>:</b></td>
							<td align="left">
								<div class="input-group">
									<label class="input-group-addon btn" for="bank">
										&nbsp;<span><i class="fa fa-university"></i></span>
									</label>
									<select class="validate[required] form-control" name="bank" id="bank" required>
										<option value="">- Pilih Rekening Bank -</option>
										<option value="0" style="font-weight: bold;color: red;">+Tambah Manual</option>
										<?php foreach ($rekening_bank as $data): ?>
											<option value="<?php echo $data->kode_akun ?>"><?php echo $data->nama_akun ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<input type="text" class="validate[required] form-control" name="bank_2" id="bank_2" style="display: none;">
							</td>
						</tr>
						<tr>
							<td><b>Jumlah RETUR</b></td>
							<td><b>:</b></td>
							<td align="left">
								<div class="input-group">
									<label class="input-group-addon btn" for="nominal">
										<span><b>Rp</b></span>
									</label>
									<input type="text" class="validate[required] form-control xnumber" id="nominal" name="nominal" value="0" required>
								</div>
							</td>
						</tr>
						<tr id="error_nominal" style="display: none;">
							<td style="padding: 0px;"></td>
							<td style="padding: 0px;"></td>
							<td align="left" class="text-danger" style="font-size: 12px;padding: 0px 5px 0px 5px;">
								<b><span id="error_nominal_text" class="alert alert-danger" style="padding: 5px;"></span></b>
							</td>
						</tr>
						<tr>
							<td style="padding: 0px;"></td>
							<td style="padding: 0px;"></td>
							<td align="left" class="text-info" style="font-size: 12px;padding: 0px;">
								&nbsp;&nbsp;Nominal yang telah SP2D : 
								<b>Rp. <span id="nominal_telah_sp2d" style="display: inline;width: auto;"><?php echo number_format($nominal_sp2d,0,',','.') ?></span></b>
								dari
								<b>Rp. <span id="nominal_cair" style="display: inline;width: auto;"><?php echo number_format($nominal_cair,0,',','.') ?></span></b>
							</td>
						</tr>
						<tr>
							<td><b>Keterangan</b></td>
							<td><b>:</b></td>
							<td align="left">
								<!-- <span style="font-size: 11px;">*Jika tidak ada keterangan yang ingin ditambahkan, isi dengan tanda ( - ) demi keseragaman</span> -->
								<textarea class="form-control" id="keterangan" name="keterangan" cols="50" rows="3" style="resize:vertical;"></textarea>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
	</div>

	<div class="modal-footer">
		<button type="reset" id="close_sp2d" class="btn btn-default cancel btn-sm" aria-label="Center Align" data-dismiss="modal">
			Batal
		</button>
		<button type="submit" class="btn btn-primary submit btn-sm" aria-label="Left Align" >
			Simpan
		</button>
	</div>
</form>