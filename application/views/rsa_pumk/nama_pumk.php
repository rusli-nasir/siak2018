<?php if($username == null){ ?>
	<tr>
		<td class="col-md-2"><b>Nama PUMK</b></td>
		<td align="left">
			<input type="text" class="validate[required]  form-control"  id="nama_pumk" name="nama_pumk">
		</td>
	</tr>
	<tr>
		<td class="col-md-2"><b>NIP</b></td>
		<td align="left">
			<input type="text" class="validate[required]  form-control"  id="nip" name="nip" >
		</td>
	</tr>
<?php }else{ ?>
	<tr>
		<td class="col-md-2"><b>Nama PUMK</b></td>
		<td align="left">
			<input type="text" class="validate[required]  form-control" value="<?php echo $username->nm_lengkap ?>" id="nama_pumk" name="nama_pumk" readonly="readonly" >
		</td>
	</tr>
	<tr>
		<td class="col-md-2"><b>NIP</b></td>
		<td align="left">
			<input type="text" class="validate[required]  form-control" value="<?php echo $username->nomor_induk ?>" id="nip" name="nip" readonly="readonly" >
		</td>
	</tr>
<?php } ?>

