<?php foreach($result_akun_kas as $num_row=>$row):?>
		<tr id="<?=$row->kode_akun1digit?>" height="25px" >
			<td align="center"><?php if ($row->kode_akun1digit == 1): ?><?=$row->kode_akun1digit?><?php endif ?></td>
			<td ><?php if ($row->kode_akun1digit == 1): ?><a href="<?=site_url("akun_kas2/daftar_akun_kas2/".$row->kode_akun1digit)?>"><?=$row->nama_akun1digit?></a><?php endif ?></td>
		</tr>
<?php endforeach;?>