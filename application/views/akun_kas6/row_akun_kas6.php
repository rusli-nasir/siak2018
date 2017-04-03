<?php foreach($result_akun_kas6 as $num_row=>$row){ ?>
<tr id="<?=$row->kd_kas_6?>" height="25px">
	<td align="center"><?=$row->kd_kas_6?></td>
	<td><?=$row->nm_kas_6?></td>
        <td align="right" rel="<?=$row->kd_kas_6?>" class="nominal_akun" >0</td>
        <td >
            <button class="btn btn-sm btn-warning" id="btn-nominal" rel="<?=$row->kd_kas_6?>" ><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Tambah</button>
        </td>
	<td align="center"><a href="javascript:void(0)" class="edit" rel="<?=$row->kd_kas_6?>" name="edit">Edit</a></td>
	<td align="center"><a href="javascript:void(0)" rel="<?=$row->kd_kas_6?>" class="delete">Delete</a></td>
</tr>
<?php } ?>