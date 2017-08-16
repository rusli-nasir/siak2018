<?php 
if($atribut['cetak']){ 
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=laporan_posisi_keuangan.xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
}
?>
<!DOCTYPE>
<html>
	<head>
		<title>Laporan Aktifitas</title>
		<style type="text/css">
		@page{
			size:landscape;
		}
		.border {
		    border-collapse: collapse;
		}

		.border td,
		.border th{
		    border: 1px solid black;
		}
		.tab0{padding-left:0px !important;font-weight:bold;}
		.tab1{padding-left:20px !important;font-weight:bold;}
		.tab2{padding-left:40px !important;}
		.tab3{padding-left:60px !important;}
		.btn{padding:10px;box-shadow:1px 1px 2px #bdbdbd;border:0px;}
    	.excel{background-color:#A3A33E;color:#fff;}
    	.pdf{background-color:#588097;color:#fff;}
		</style>
		<script type="text/javascript">
		</script>
	</head>
	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<?php if($atribut['cetak']=='cetak'){ ?>
		<?php }else{ ?>
		<form action="<?php echo site_url('akuntansi/laporan/lainnya') ?>" method="post">
			<input type="hidden" name="jenis_laporan" value="Posisi Keuangan">
			<input type="hidden" name="level" value="<?php echo $level; ?>">
			<input type="hidden" name="daterange" value="<?php if(isset($daterange)) echo 'daterange'; ?>">
			<input type="hidden" name="cetak" value="cetak">
			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Cetak</button>
		</form>
		<?php } ?>
		<div align="center">
			<div style="font-weight:bold">
				UNIVERSITAS DIPONEGORO<br/>
				Laporan Realisasi Anggaran<br/>
				<?php echo $atribut['teks_periode']; ?><br/>
			</div>
			(Disajikan dalam Rupiah, kecuali dinyatakan lain)<br/><br/>
		</div>
		<table style="width:1100px;font-size:10pt;margin:0 auto" class="border">
			<thead>
				<tr style="background-color:#ECF379;height:45px">
					<th width="30px"></th>
					<th width="550px">URAIAN</th>
					<th>Anggaran</th>
					<th>Realisasi</th>
					<th>Realisasi Diatas(Dibawah) Anggaran</th>
					<th>%</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0;$j=0;$index=0;
				foreach ($akun as $key_1 => $akun_1) {
					foreach($nama_lvl_1[$key_1] as $key=>$value){ 
						$jumlah_sekarang[$index] = 0;
						$jumlah_awal[$index] = 0;
						$jumlah_selisih[$index] = 0;
						$namanya = $value; ?>
					<tr>
						<td></td>
						<td class="tab0"><?php echo $value; ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php foreach($nama_lvl_2[$key_1] as $key=>$value){ ?>
						<tr>
							<td></td>
							<td class="tab1"><?php echo $value; ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php if($level==3){
								$counter=0;foreach($nama_lvl_3[$key_lvl_2[$i]] as $key=>$value){ 
									$jumlah_sekarang[$index] += $saldo_sekarang_lvl_3[$key_lvl_2[$i]][$counter];
									$jumlah_awal[$index] += $anggaran_awal_lvl_3[$key_lvl_2[$i]][$counter];
									?>
									<tr>
										<td></td>
										<td class="tab2"><?php echo $value; ?></td>
										<td align="right"><?php echo eliminasi_negatif($anggaran_awal_lvl_3[$key_lvl_2[$i]][$counter]); ?></td>
										<td align="right"><?php echo eliminasi_negatif($saldo_sekarang_lvl_3[$key_lvl_2[$i]][$counter]); ?></td>
										<td align="right"><?php $selisih = -abs($saldo_sekarang_lvl_3[$key_lvl_2[$i]][$counter]) + abs($anggaran_awal_lvl_3[$key_lvl_2[$i]][$counter]);
										echo eliminasi_negatif($selisih); 
										$jumlah_selisih[$index] += abs($selisih);
										?></td>
										<td align="right">
											<?php 
											if($anggaran_awal_lvl_3[$key_lvl_2[$i]][$counter]>0){ 
												if ($anggaran_awal_lvl_3[$key_lvl_2[$i]][$counter] != 0) {
													$persen = ($selisih/$anggaran_awal_lvl_3[$key_lvl_2[$i]][$counter])*100; 												
												} else {
													$persen = 0;
												}
												echo abs(number_format($persen)).'%';
											} 
											?></td>
									</tr>
						<?php  $counter++; }
							}else{ 
								foreach($nama_lvl_3[$key_lvl_2[$i]] as $key=>$value){ ?>
									<tr>
										<td></td>
										<td class="tab2"><?php echo $value; ?></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
							<?php $counter=0;foreach($nama_lvl_4[$key_lvl_3[$j]] as $key=>$value){ 
								$jumlah_sekarang[$index] += $saldo_sekarang_lvl_4[$key_lvl_3[$j]][$counter];
								$jumlah_awal[$index] += $anggaran_awal_lvl_4[$key_lvl_3[$j]][$counter];
								?>
									<tr>
										<td></td>
										<td class="tab3"><?php echo $value; ?></td>
										<td align="right"><?php echo eliminasi_negatif($anggaran_awal_lvl_4[$key_lvl_3[$j]][$counter]); ?></td>
										<td align="right"><?php echo eliminasi_negatif($saldo_sekarang_lvl_4[$key_lvl_3[$j]][$counter]); ?></td>
										<td align="right"><?php $selisih = - abs($saldo_sekarang_lvl_4[$key_lvl_3[$j]][$counter]) + abs($anggaran_awal_lvl_4[$key_lvl_3[$j]][$counter]);
										echo eliminasi_negatif($selisih); 
										$jumlah_selisih[$index] += abs($selisih);
										?></td>
										<td align="right">
											<?php 
											if($anggaran_awal_lvl_4[$key_lvl_3[$j]][$counter]>0){ 
												if ($anggaran_awal_lvl_4[$key_lvl_3[$i]][$counter] != 0) {
													$persen = ($selisih/$anggaran_awal_lvl_4[$key_lvl_2[$i]][$counter])*100; 
												} else {
													$persen = 0;
												}
												echo abs(number_format($persen)).'%';
											} 
											?></td>
									</tr>
							<?php 	$counter++; } 
								$j++;
								}
							} ?>
					<?php 	$i++; } ?>
					<tr style="background-color:#F7F2AF">
						<td></td>
						<td class="tab0">JUMLAH <?php echo $namanya; ?></td>
						<td align="right"><?php echo eliminasi_negatif($jumlah_awal[$index]); ?></td>
						<td align="right"><?php echo eliminasi_negatif($jumlah_sekarang[$index]); ?></td>
						<td align="right"><?php echo eliminasi_negatif($jumlah_selisih[$index]); ?></td>
						<td></td>
					</tr>
				<?php	
					}
				} ?>	
			</tbody>
		</table>
		<br/>
		<table width="1300px;">
			<tbody>
				<tr>
					<td colspan="4" width="600px;"></td>
					<td colspan="4">
						<?php 
					    $pejabat = get_pejabat('all','rektor');
					    $teks_kpa = "Rektor";
					    $teks_unit = "UNIVERSITAS DIPONEGORO";
						echo 'Semarang, '.$atribut['periode_ttd'].'<br/>'.$teks_kpa.'<br/>';
						echo $teks_unit.'<br/><br/><br/><br/>';
						echo $pejabat['nama'].'<br/>NIP. '.$pejabat['nip'];
						?>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>

<?php
function eliminasi_negatif($value)
{
    if ($value < 0) 
    	return number_format(abs($value),2,',','.');
        // return "(". number_format(abs($value),2,',','.') .")";
    else
        return number_format($value,2,',','.');
}
function get_pejabat($unit, $jabatan){
	$ci =& get_instance();
	$ci->db->where('unit', $unit);
	$ci->db->where('jabatan', $jabatan);
	return $ci->db->get('akuntansi_pejabat')->row_array();
}
?>