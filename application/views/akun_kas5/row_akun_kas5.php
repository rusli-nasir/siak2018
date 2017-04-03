<?php foreach($result_akun_kas5 as $num_row=>$row){?>
<tr id="<?=$row->kd_kas_5?>" height="25px">
	<td align="center"><?=$row->kd_kas_5?></td>
	<td><a href="<?=site_url("akun_kas6/daftar_akun_kas6/".$row->kd_kas_2."/".$row->kd_kas_3."/".$row->kd_kas_4."/".$row->kd_kas_5)?>"><?=$row->nm_kas_5?></a></td>
	<!--<td align="center"><?=$row->nominal?></td>-->
	<td align="center"><a href="javascript:void(0)" class="edit" rel="<?=$row->kd_kas_5?>" name="edit">Edit</a></td>
	<td align="center"><a href="javascript:void(0)" rel="<?=$row->kd_kas_5?>" class="delete">Delete</a></td>
</tr>
<?php } ?>