<form id="form_ptla" onsubmit="return false">
	<input type="hidden" id="kode_unit_subunit" name="kode_unit_subunit" value="<?php echo $kode_unit_subunit ?>" required>
	<input type="hidden" id="jenis_trx" name="jenis" value="<?php echo $jenis ?>" required>
	<input type="hidden" id="nominal_ptla" name="nominal_ptla" value="<?php echo $nominal_ptla ?>" required>

	<input type="hidden" id="id_trx_urut_spm_cair" value="<?php echo $id_trx_urut_spm_cair ?>">

	<div class="modal-header peach-gradient text-white">
		<button type="button" class="close" data-dismiss="modal" style="color: #fff;opacity: 1;">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
		<h4 class="modal-title text-center" id="myModalLabel">
			<b style="color:#fff;">Formulir Potongan Lainnya</b>
		</h4>
	</div>

	<div class="modal-body">
		
		<table class="table-condensed" style="margin: auto;width: 70%;">
			<tbody>
				<tr>
					<td style="min-width: 150px;"><b>Nomor SPM Cair</b></td>
					<td><b>:</b></td>
					<td align="left">
						<input type="text" class="validate[required] form-control" id="no_spm" name="no_spm" value="<?php echo $no_spm ?>" DISABLED required>
						<input type="hidden" class="validate[required] form-control" id="no_spm_encoded" name="no_spm_encoded" value="<?php echo urlencode(base64_encode($no_spm)) ?>" DISABLED required>
					</td>
				</tr>
				<!-- <tr>
					<td><b>Nomor Potongan</b></td>
					<td><b>:</b></td>
					<td align="left">
						<input type="text" class="validate[required] form-control" id="new_no_ptla" name="no_ptla" value="<?php echo $new_no_ptla ?>" required>
						<input type="hidden" class="validate[required] form-control" id="new_no_ptla_tmp" name="new_no_ptla_tmp" value="<?php echo $new_no_ptla ?>" required>
						<input type="hidden" class="validate[required] form-control" id="no_ptla_sblm_tmp" name="no_ptla_sblm_tmp" value="<?php echo $no_ptla_sblm ?>" required>
						<?php if (substr($no_ptla_sblm,0,4)!=0000): ?>
							<span>
								<input type="checkbox" name="no_ptla_sblm" id="no_ptla_sblm" value="1" style="width:20px;background-color: blue;position:relative;left: 0px;margin:0px; ">
								<label for="no_ptla_sblm" style="font-weight: normal;width:200px;position:relative;left: 0px;display:inline-block;vertical-align:middle; ">No.ptla Sebelum</label>
							</span>
						<?php endif ?>
					</td>
				</tr> -->
				<!-- <tr>
					<td><b>Tanggal Potongan</b></td>
					<td><b>:</b></td>
					<td align="left">
						<div class="input-group">
							<label class="input-group-addon btn" for="tgl_ptla">
								&nbsp;<span class="glyphicon glyphicon-calendar"></span>
							</label>  
							<input type="text" class="validate[required] form-control readonly" id="tgl_ptla" name="tgl_ptla" required>
						</div>
					</td>
				</tr> -->
				<!-- <tr>
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
								<?php// foreach ($rekening_bank as $data): ?>
									<option value="<?php// echo $data->kode_akun ?>"><?php// echo $data->nama_akun ?></option>
								<?php// endforeach ?>
							</select>
						</div>
							<input type="text" class="validate[required] form-control" name="bank_2" id="bank_2" style="display: none;">
					</td>
				</tr> -->
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
					<td><b>Jenis Potongan</b></td>
					<td><b>:</b></td>
					<td align="left">
						<div class="input-group">
							<label class="input-group-addon btn" for="bank">
								&nbsp;<span><i class="fa fa-scissors"></i></span>
							</label>
							<select class="validate[required] form-control" name="jenis_potongan" id="jenis_potongan" required="">
								<option value="">- Pilih Jenis Potongan -</option>
								<option value="217611">Utang BPJS Kesehatan</option>
								<option value="217612">Utang BPJS Ketenagaakerjaan</option>
								<option value="431312">Denda Keterlambatan Pekerjaan</option>
								<option value="431313">Denda Penyelesaian Pekerjaan</option>
								<option value="431314">Tuntutan Ganti Rugi</option>
								<option value="null">Kelebihan Pembayaran Bulan/Tahun Sebelumnya [ IKW/IKK/IPP/Gaji Kontrak/Uang Makan/ITP ]</option>
							</select>
						</div>
					</td>
				</tr>
				<!-- <tr id="row_akun_belanja" style="display: none;">
					<td><b>Data Belanja</b></td>
					<td><b>:</b></td>
					<td align="left">
							<select class="validate[required] form-control" name="akun_belanja" id="akun_belanja">
								<option value="">- Pilih Data Belanja Untuk Kelebihan Pembayaran -</option>
							</select>
					</td>
				</tr> -->
				<tr>
					<td><b>Nominal</b></td>
					<td><b>:</b></td>
					<td align="left">
						<div class="input-group">
							<label class="input-group-addon btn" for="nominal">
								<span><b>Rp</b></span>
							</label>
							<input type="text" class="validate[required] form-control xnumber" id="nominal" name="nominal" value="<?php echo number_format($nominal_belum_ptla,0,',','.') ?>" required>
						</div>
					</td>
				</tr>
				<tr>
					<td style="padding: 0px;"></td>
					<td style="padding: 0px;"></td>
					<td align="left" class="text-info" style="font-size: 12px;padding: 0px;">
						&nbsp;&nbsp;Nominal potongan lainnya yang belum diuraikan : 
						<b>Rp. <span id="nominal_belum_ptla" style="display: inline;width: auto;"><?php echo number_format($nominal_belum_ptla,0,',','.') ?></span></b>
						dari
						<b>Rp. <span id="nominal_cair" style="display: inline;width: auto;"><?php echo number_format($nominal_ptla,0,',','.') ?></span></b>
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
						<textarea class="form-control" id="keterangan" name="keterangan" cols="50" rows="3" style="resize:vertical;"></textarea>
					</td>
				</tr>
			</tbody>
		</table>
		
	</div>

	<div class="modal-footer">
		<button type="reset" id="close_ptla" class="btn btn-default cancel btn-sm" aria-label="Center Align" data-dismiss="modal">
			Batal
		</button>
		<button type="submit" class="btn btn-primary submit btn-sm" aria-label="Left Align" >
			Simpan
		</button>
	</div>
</form>