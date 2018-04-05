<?php foreach($result_akun_kas5 as $num_row=>$row):?>
<tr id="<?=$row->kode_akun5digit?>" height="25px">
	<td align="center"><?=$row->kode_akun5digit?></td>
	<td ><a href="<?=site_url("akun_kas6/daftar_akun_kas6/".$row->kode_akun5digit)?>"><?=$row->nama_akun5digit?></a></td>
</tr>
<?php endforeach;?>