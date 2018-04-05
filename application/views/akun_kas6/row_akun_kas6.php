<?php foreach($result_akun_kas6 as $num_row=>$row){ ?>
<tr id="<?=$row->kode_akun?>" height="25px">
	<td align="center"><?=$row->kode_akun?></td>
	<td><?=$row->nama_akun?></td>
        <td align="right" rel="<?=$row->kode_akun?>" class="nominal_akun" >0</td>
        <td colspan="3" align="right">
            <button class="btn btn-sm btn-warning" id="btn-nominal" rel="<?=$row->kode_akun?>" ><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Tambah</button>
        </td>
<!-- 	<td align="center"><a href="javascript:void(0)" class="edit" rel="<?=$row->kode_akun?>" name="edit">Edit</a></td>
	<td align="center"><a href="javascript:void(0)" rel="<?=$row->kode_akun?>" class="delete">Delete</a></td> -->
</tr>
<?php } ?>