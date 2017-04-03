<?php foreach($result_rsa_up as $num_row=>$row):?>
<tr id="<?=$row->no_up?>" height="25px">
	<td ><?=$row->no_up?></td>
	<td ><?=$row->kode_unit_kepeg?></td>
	<td ><?=$row->tgl_transaksi?></td>
	<td ><?=$row->kd_transaksi?></td>
	<td ><?=$row->debet?></td>
	<td align="center"><a href="javascript:void(0)" class="edit" rel="<?=$row->no_up?>" name="edit">Edit</a></td>
	<td align="center"><a href="javascript:void(0)" rel="<?=$row->no_up?>" class="delete" data-toggle="modal" data-target="#myModal">Delete</a></td>
</tr>
<?php endforeach;?>