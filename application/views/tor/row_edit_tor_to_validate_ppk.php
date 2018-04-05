<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	$volume = isset($value->volume)?$value->volume:'0';
	$harga_satuan = isset($value->harga_satuan)?$value->harga_satuan:'0';
?>
	<td >
            <input name="kode_akun_tambah_edit" class="form-control" id="kode_akun_tambah_edit" type="text" value="<?php echo $value->kode_akun_tambah; ?>" readonly="readonly" /></td>
	<td >
            <!-- <input name="deskripsi_edit" class="validate[required] form-control" id="deskripsi_edit" type="text" value="<?php echo $value->deskripsi; ?>" /> -->
            <textarea name="deskripsi_edit" class="validate[required] form-control" id="deskripsi_edit" rows="1"><?php echo $value->deskripsi; ?></textarea>
        </td>
	<td ><input name="volume_edit" rel="<?=$value->kode_usulan_belanja?>" class="validate[required,funcCall[checkfloat]] calculate form-control xfloat" id="volume_edit" type="text" value="<?php echo $value->volume + 0; ?>" data-toggle="tooltip" data-placement="top" title="Silahkan masukan angka bulat atau pecahan." /></td>
	<td ><input name="satuan_edit" class="validate[required,maxSize[30]] form-control" id="satuan_edit" type="text" value="<?php echo $value->satuan; ?>" /></td>
	<td ><input name="tarif_edit" rel="<?=$value->kode_usulan_belanja?>" class="validate[required,custom[integer],min[1]] calculate form-control xnumber" id="tarif_edit" type="text" value="<?php echo $value->harga_satuan;?>" /></td>
	<td >
            <input name="jumlah_edit" id="jumlah_edit" type="text" class="form-control" readonly="readonly" value="<?php echo ($value->volume * $value->harga_satuan); ?>" />
            <input name="jumlah_edit_before" id="jumlah_edit_before" type="hidden" value="<?php echo ($value->volume * $value->harga_satuan); ?>" />
        </td>
	<td align="center" >
		<div class="btn-group">
				<button type="button" style="padding-left:5px;padding-right:5px;" class="btn btn-default btn-sm" onclick="submitedit('<?php echo $value->id_rsa_detail; ?>','<?php echo $value->kode_usulan_belanja; ?>')" id="btn-edit" aria-label="Left Align" data-kode-usulan="<?php echo $value->kode_usulan_belanja ?>"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
				<button type="reset" style="padding-left:5px;padding-right:5px;" class="btn btn-default btn-sm" id="btn-cancel" onclick="canceledit('<?=$value->kode_usulan_belanja?>')" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			</div>
	</td>
        <td>
                    

                                                    <div class="btn-group">
                                                        <button type="button" disabled="disabled" style="padding-left:5px;padding-right:5px;" rel="" class="btn btn-success btn-sm" onclick="doedit('')" aria-label="Left Align">Yes</button>
                                                        <button type="button" disabled="disabled" style="padding-left:5px;padding-right:5px;" rel="" class="btn btn-danger btn-sm" id="delete_" aria-label="Center Align">No</button>
                                                    </div>
                                                </td>
