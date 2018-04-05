<script>
	$('#tgl_sp2d').datepicker({
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

		var no_sp2d = $("#no_sp2d").val();
		// alert();
		$("#no_sp2d").val(no_sp2d.replace(no_sp2d.substr(-8,8),bulan_str+"/"+tahun));
		// console.log(tahun);
	});
</script>
<form id="form_edit_sp2d" onsubmit="return false">
	<input type="hidden" id="id" name="id" value="<?php echo $id ?>" required>
	<div class="modal-header blue-gradient text-white">
		<button type="button" class="close" data-dismiss="modal" style="color: #fff;opacity: 1;">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
		<h4 class="modal-title text-center" id="myModalLabel">
			<b style="color:#fff;">Formulir Edit SP2D</b>
		</h4>
	</div>

	<div class="modal-body">
		
		<table class="table-condensed" style="margin: auto;width: 70%;">
			<tbody>
				<tr>
					<td><b>Nomor SPM</b></td>
					<td><b>:</b></td>
					<td align="left">
						<input type="text" class="validate[required] form-control" id="no_spm" name="no_spm" value="<?php echo $no_spm ?>" DISABLED required>
					</td>
				</tr>
				<tr>
					<td><b>Nomor SP2D</b></td>
					<td><b>:</b></td>
					<td align="left">
						<input type="text" class="validate[required] form-control" id="no_sp2d" name="no_sp2d" value="<?php echo $no_sp2d ?>" required>
					</td>
				</tr>
				<tr>
					<td><b>Tanggal SP2D</b></td>
					<td><b>:</b></td>
					<td align="left">
						<div class="input-group">
							<label class="input-group-addon btn" for="tgl_sp2d">
								&nbsp;<span class="glyphicon glyphicon-calendar"></span>
							</label>  
							<input type="text" class="validate[required] form-control readonly" id="tgl_sp2d" name="tgl_sp2d" value="<?php echo $tgl_sp2d ?>" required>
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
								<option value="0" style="font-weight: bold;color: red;" <?php if ($kd_akun_kas == null) {echo "selected";} ?> >+Tambah Manual</option>
								<?php foreach ($rekening_bank as $data): ?>
									<option value="<?php echo $data->kode_akun ?>" <?php if ($data->kode_akun == $kd_akun_kas) {echo "selected";} ?> ><?php echo $data->nama_akun ?></option>
								<?php endforeach ?>
							</select>
						</div>
							<input type="text" class="validate[required] form-control" name="bank_2" id="bank_2" <?php if ($kd_akun_kas != null) {echo 'style="display: none;"';}else{echo 'value="'.$bank.'"';} ?> >
					</td>
				</tr>
				<!-- <tr>
					<td><b>Rekening Bank</b></td>
					<td><b>:</b></td>
					<td align="left">
						<div class="input-group">
							<label class="input-group-addon btn" for="rek">
								&nbsp;<span><i class="fa fa-credit-card"></i></span>
							</label>
							<input type="text" class="validate[required] form-control" id="rek" name="rek" required>
						</div>
					</td>
				</tr> -->
				<tr>
					<td><b>Nominal SP2D</b></td>
					<td><b>:</b></td>
					<td align="left">
						<div class="input-group">
							<label class="input-group-addon btn" for="nominal">
								<span><b>Rp</b></span>
							</label>
							<input type="text" class="validate[required] form-control xnumber" id="nominal" name="nominal" value="<?php echo number_format($nominal_sp2d,0,',','.') ?>" disabled>
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
					<td><b>Keterangan</b></td>
					<td><b>:</b></td>
					<td align="left">
						<!-- <span style="font-size: 11px;">*Jika tidak ada keterangan yang ingin ditambahkan, isi dengan tanda ( - ) demi keseragaman</span> -->
						<textarea class="form-control" id="keterangan" name="keterangan" cols="50" rows="3" style="resize:vertical;"><?php echo $keterangan ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
		
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