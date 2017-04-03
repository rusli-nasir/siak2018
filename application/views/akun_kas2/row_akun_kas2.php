<?php foreach($result_akun_kas2 as $num_row=>$row):?>
<tr id="<?=$row->kd_kas_2?>" height="25px">
	<td align="center"><?=$row->kd_kas_2?></td>
	<td ><a href="<?=site_url("akun_kas3/daftar_akun_kas3/".$row->kd_kas_2)?>"><?=$row->nm_kas_2?></a></td>
	<td align="center"><a href="javascript:void(0)" class="edit" rel="<?=$row->kd_kas_2?>" name="edit">Edit</a></td>
	<td align="center"><a href="javascript:void(0)" rel="<?=$row->kd_kas_2?>" class="delete" data-toggle="modal" data-target="#myModal">Delete</a></td>
</tr>
<?php endforeach;?>