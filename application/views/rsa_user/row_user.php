<?php foreach($result_user as $num_row=>$row):?>
<tr id="<?=$row->username?>" height="25px">
    <td class="text-danger"><b><?=$row->nama_subunit?></b></td>
	<td ><?=$this->convertion->get_user_level($row->level);?></td>
	<td><?=$row->username?></td>
	<td>terenkripsi</td>
	<td align="center"><?=$row->flag_aktif?></td>
	<td align="center"><a href="javascript:void(0)" class="edit" rel="<?=$row->username?>" name="edit">Edit</a></td>
	<td align="center"><a href="javascript:void(0)" rel="<?=$row->username?>" class="delete">Delete</a></td>
</tr>
<?php endforeach;?>