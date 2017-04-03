<?php foreach($result_rsa_ikw as $num_row=>$row):?>
<tr id="<?=$row->id_trans?>" height="25px">
	<td ><?=$row->bulan?></td>
	<td ><?=$row->tahun?></td>
	<td ><?=$row->nip?></td>
	<td align="center"><a href="javascript:void(0)" class="edit" rel="<?=$row->no?>" name="edit">Edit</a></td>
	<td align="center"><a href="javascript:void(0)" rel="<?=$row->no?>" class="delete" data-toggle="modal" data-target="#myModal">Delete</a></td>
</tr>
<?php endforeach;?>