<?php foreach($result_akun_kas4 as $num_row=>$row):?>
<tr id="<?=$row->kode_akun4digit?>" height="25px">
	<td align="center"><?=$row->kode_akun4digit?></td>
	<td ><a href="<?=site_url("akun_kas5/daftar_akun_kas5/".$row->kode_akun4digit)?>"><?=$row->nama_akun4digit?></a></td>
</tr>
<?php endforeach;?>