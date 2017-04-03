<?php foreach($result_jenis_spm as $num_row=>$row){
	?>

<tr id="<?=$row->kd_spm?>" height="25px">
	<td><?=$row->jenis_spm?></td>
	<td align="center"><a href="<?=site_url("spm/input_spm/".$row->kd_spm)?>" class="btn btn-warning">Pilih SPM</a></td>
</tr>
<?php } ?>