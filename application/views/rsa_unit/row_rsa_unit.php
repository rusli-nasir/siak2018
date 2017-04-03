<?php foreach($result_rsa_unit as $num_row=>$row):?>
<tr id="<?=$row->no?>" height="25px">
	<td ><?=$row->kode_rsa_unit?></td>
	<td ><?=$row->kode_unit_kepeg?></td>
	<td ><?=$row->kode_unit_rba?></td>
	<td align="center"><a href="javascript:void(0)" class="edit" rel="<?=$row->no?>" name="edit">Edit</a></td>
	<td align="center"><a href="javascript:void(0)" rel="<?=$row->no?>" class="delete" data-toggle="modal" data-target="#myModal">Delete</a></td>
</tr>
<?php endforeach;?>