<form id="form_retur" onsubmit="return false">
	<input type="hidden" id="kode_unit_subunit" name="kode_unit_subunit" value="<?php echo $kode_unit_subunit ?>" required>
	<input type="hidden" id="jenis" name="jenis" value="<?php echo $jenis ?>" required>
	<input type="hidden" id="nominal_sp2d" name="nominal_sp2d" value="<?php echo $nominal_sp2d ?>" required>

	<input type="hidden" id="id_trx_urut_spm_cair" value="<?php echo $id_trx_urut_spm_cair ?>">

	<div class="modal-header peach-gradient text-white">
		<button type="button" class="close" data-dismiss="modal" style="color: #fff;opacity: 1;">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
		<h4 class="modal-title text-center" id="myModalLabel">
			<b style="color:#000;">Formulir Retur SP2D</b>
		</h4>
	</div>

	<div class="modal-body">
		
		<table class="table-condensed" style="margin: auto;width: 70%;">
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
							<input type="text" class="validate[required] form-control" id="bank" name="bank" required>
						</div>
					</td>
				</tr>
				<tr>
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
						<b>Rp. <span id="nominal_telah_sp2d" style="display: inline;width: auto;"><?php echo $nominal_sp2d ?></span></b>
						dari
						<b>Rp. <span id="nominal_cair" style="display: inline;width: auto;"><?php echo $nominal_cair ?></span></b>
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

	<div class="modal-footer">
		<button type="reset" id="close_sp2d" class="btn btn-default cancel btn-sm" aria-label="Center Align" data-dismiss="modal">
			Batal
		</button>
		<button type="submit" class="btn btn-primary submit btn-sm" aria-label="Left Align" >
			Simpan
		</button>
	</div>
</form>