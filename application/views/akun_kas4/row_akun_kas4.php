<?php foreach($result_akun_kas4 as $num_row=>$row){?>
<tr id="<?=$row->kd_kas_4?>" height="25px">
	<td align="center"><?=$row->kd_kas_4?></td>
	<td><a href="<?=site_url("akun_kas5/daftar_akun_kas5/".$row->kd_kas_2."/".$row->kd_kas_3."/".$row->kd_kas_4)?>"><?=$row->nm_kas_4?></a></td>
	<td align="center"><a href="javascript:void(0)" class="edit" rel="<?=$row->kd_kas_4?>" name="edit">Edit</a></td>
	<td align="center"><a href="javascript:void(0)" rel="<?=$row->kd_kas_4?>" class="delete" data-toggle="modal" data-target="#myModal">Delete</a></td>
</tr>
<?php } ?>