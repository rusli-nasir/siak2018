<?php foreach($result_akun_kas3 as $num_row=>$row):?>
<tr id="<?=$row->kode_akun3digit?>" height="25px">
	<td align="center"><?=$row->kode_akun3digit?></td>
	<td ><a href="<?=site_url("akun_kas4/daftar_akun_kas4/".$row->kode_akun3digit)?>"><?=$row->nama_akun3digit?></a></td>
</tr>
<?php endforeach;?>