<?php foreach($result_akun_kas2 as $num_row=>$row):?>
<tr id="<?=$row->kode_akun2digit?>" height="25px">
	<td align="center"><?=$row->kode_akun2digit?></td>
	<td ><a href="<?=site_url("akun_kas3/daftar_akun_kas3/".$row->kode_akun2digit)?>"><?=$row->nama_akun2digit?></a></td>
</tr>
<?php endforeach;?>