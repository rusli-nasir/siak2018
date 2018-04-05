	<table id="table" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;margin: 0px auto;" cellspacing="0" border="1" cellpadding="0">
		<tbody>
			<tr>
				<td colspan="7" style="text-align: center;padding-top: 5px;padding-bottom: 5px;"><img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60"></td>
			</tr>
			<tr>
				<td style="border:0px;width: 0.1%;white-space:nowrap;"></td>
				<td style="border:0px;width: 1%;white-space:nowrap;"></td>
				<td style="border:0px;width: 1%;white-space:nowrap;"></td>
				<td style="border:0px;width: 1%;white-space:nowrap;"></td>
				<td style="border:0px;width: 1%;white-space:nowrap;"></td>
				<td style="border:0px;width: 1%;white-space:nowrap;"></td>
				<td style="border:0px;width: 0.1%;white-space:nowrap;"></td>
			</tr>
			<tr >
				<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
			</tr>
			<tr style="">
				<td colspan="7" style="text-align: center;font-size: 20px;border-bottom: none;border-top: none"><b>UNIVERSITAS DIPONEGORO</b></td>
			</tr>
			<tr style="border-top: none;">
				<td colspan="7" style="text-align: center;font-size: 16px;border-bottom: none;border-top: none;"><b>NOMOR RETUR : <?php echo $cetak_sp2d->nomor_trx ?></b></td>
			</tr>
			<tr >
				<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
			</tr>
			<tr >
				<td style="border-right: none;">&nbsp;</td>
				<td style="border-left: none;border-right: none;" colspan="5" ><b>Satuan Unit Kerja Pengguna Anggaran (SUKPA) : 
					<?php if ($cetak_sp2d->nama_subunit =="") {
						echo $cetak_sp2d->nama_unit;
							}else{
						echo $cetak_sp2d->nama_subunit;
							}  ?> 
						</b></td>
				<td style="border-left: none;">&nbsp;</td>
			</tr>
			<tr>
				<td style="border-right: none;">&nbsp;</td>
				<td colspan="2" style="border-right: none;border-left: none;"><b>Unit Kerja :  <?php echo $cetak_sp2d->nama_unit ?></b> </td> 
				<td style="text-align: center;border-left: none;border-right: none;" colspan="2">&nbsp;</td>
				<td style="border-left: none;border-right: none;"></td>
				<td style="border-left: none;">&nbsp;</td>
			</tr>
			<tr >
				<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
			</tr>
			<tr>
				<td style="border-right: none;border-bottom: none;border-top: none;">&nbsp;</td>
				<td colspan="5" style="border-right: none;border-left: none;line-height: 16px;border-bottom: none;border-top: none;">
					<table>
						<tr>
							<td>• Nomor SPM</td>
							<td style="padding: 0px 10px 0px 10px;">:</td>
							<td><?php echo $cetak_sp2d->str_nomor_trx_spm ?></td>
						</tr>
						<tr>
							<td>• Tanggal RETUR</td>
							<td style="padding: 0px 10px 0px 10px;">:</td>
							<td><?php echo $cetak_sp2d->tgl_sp2d ?></td>
						</tr>
						<tr>
							<td>• Nominal</td>
							<td style="padding: 0px 10px 0px 10px;">:</td>
							<td><?php echo 'Rp&nbsp;'.number_format($cetak_sp2d->nominal,0,',','.') ?></td>
						</tr>
						<tr>
							<td>• Bank</td>
							<td style="padding: 0px 10px 0px 10px;">:</td>
							<td><?php echo $cetak_sp2d->bank ?></td>
						</tr>
						<tr>
							<td>• Keterangan</td>
							<td style="padding: 0px 10px 0px 10px;">:</td>
							<td><?php echo $cetak_sp2d->keterangan ?></td>
						</tr>
					</table><!-- 
					<ol style="list-style-type: square;margin-top: 0px;margin-bottom: 0px;" ><b>
						<li> : <?php echo $cetak_sp2d->str_nomor_trx_spm ?></li>
						<li> : Rp. <?php echo number_format($cetak_sp2d->nominal,0,',','.') ?></li>
						<li> : <?php echo $cetak_sp2d->bank ?></li>
						<li>Jenis SP2D : <?php echo $cetak_sp2d->jenis_sp2d ?></li>
						<li> : <?php echo $cetak_sp2d->keterangan ?></li></b>
					</ol> -->
				</td>
				<td style="border-left: none;border-bottom: none;border-top: none;">&nbsp;</td>
			</tr>
			<tr >
				<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
			</tr>
		</tbody>
	</table>




