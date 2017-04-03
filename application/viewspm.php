<?php foreach($result_spm as $num_row=>$row):?>
<tr id="<?=$row->id?>" height="25px">
	<td align="center"><a href="<?=site_url("spm/detail_spm/".$row->id)?>"><?=$row->tahun?><a></td>
	<td><?=$row->tgl_spm?></td>
	<td><?=$row->kd_spm?></td>
	<td><?=$row->no_spm?></td>
	<td><?=$row->kode_unit?></td>
	<td><?=$row->jumlah?></td>
	<td><?=$row->penerima?></td>
	<td><?=$row->revisi?></td>
	<td><?=$row->status?></td>
	<td align="center"><a href="javascript:void(0)" class="edit" rel="<?=$row->kode_kegiatan?>" name="edit">Edit</a></td>
	<td align="center"><a href="javascript:void(0)" rel="<?=$row->kode_kegiatan?>" class="delete" data-toggle="modal" data-target="#myModal">Delete</a></td>
</tr>
<?php endforeach;?>