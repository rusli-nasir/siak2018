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
		<div align="center">
			<div style="font-weight:bold">
				UNIVERSITAS DIPONEGORO<br/>
				LAPORAN PERUBAHAN ARUS KAS<br/>
				UNTUK TAHUN-TAHUN YANG BERAKHIR<br/>
				<?php echo $atribut['teks_periode']; ?><br/>
			</div>
			(Disajikan dalam Rupiah, kecuali dinyatakan lain)<br/><br/>
		</div>
		<table style="width:1100px;font-size:10pt;margin:0 auto" class="border">
			<thead>
				<tr style="background-color:#ECF379;height:45px">
					<th width="30px"></th>
					<th width="750px">URAIAN</th>
					<th>20X1</th>
				</tr>
			</thead>
			<tbody>
				<?php $j=0;$index=0;$index_atas=0;$total_semua_sekarang=0;$total_semua_awal=0;$counter=0;		
				foreach($order as $key_order=>$value_order){ ?>
					<?php foreach ($akun[$value_order] as $key_1 => $akun_1) { 
						$jumlah_sekarang[$index] = 0;
					?>
						<?php foreach($nama_lvl_1[$value_order][$key_1] as $key=>$value){  
							$nama_level_1 = $value;
							?>
						<tr>
							<td></td>
							<td class="tab0"><?php echo strtoupper($value); ?></td>
							<td></td>
						</tr>
							<?php foreach($nama_lvl_2[$value_order][$key_1] as $key_2=>$value_2){ ?>
								<tr>
									<td></td>
									<td class="tab1"><?php echo strtoupper($value_2); ?></td>
									<td></td>
								</tr>	
								<?php 
								if($level==3){
									$i=0;foreach($nama_lvl_3[$value_order][$key_lvl_2[$counter]] as $key_3=>$value){ 
										$jumlah_sekarang[$index] += $saldo_sekarang_lvl_3[$value_order][$key_lvl_2[$counter]][$i];
									?>
									<tr>
										<td></td>
										<td class="tab2"><?php echo strtoupper($value); ?></td>
										<td class="tab2" align="right"><?php echo eliminasi_negatif($saldo_sekarang_lvl_3[$value_order][$key_lvl_2[$counter]][$i]); ?></td>
									</tr>	
								<?php $i++; } ?>
							<?php $counter++; 
								}else{
								foreach($nama_lvl_3[$value_order][$key_lvl_2[$counter]] as $key_3=>$value){ ?>
								<tr>
									<td></td>
									<td class="tab2"><?php echo strtoupper($value); ?></td>
									<td class="tab2" align="right"></td>
								</tr>
								<?php $increment=0;foreach($nama_lvl_4[$value_order][$key_lvl_3[$j]] as $key_4=>$value){ ?>
									<tr>
										<td></td>
										<td class="tab3"><?php echo strtoupper($value); ?></td>
										<td class="tab2" align="right"><?php echo eliminasi_negatif($saldo_sekarang_lvl_4[$value_order][$key_lvl_3[$j]][$increment]); ?></td>
									</tr>
								<?php $increment++; } ?>
							<?php $j++; }
								$counter++; 
								} ?>
							<?php } ?>
							<tr style="background-color:#F7F2AF">
								<td colspan="2" class="tab2"><b>JUMLAH <?php echo strtoupper($nama_level_1); ?></b></td>
								<td align="right"><b>
									<?php 
									$total_semua_sekarang += $jumlah_sekarang[$index];
									echo eliminasi_negatif($jumlah_sekarang[$index]); 
									?></b></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php $index++; } ?>
				<tr style="background-color:#B1E9F2">
					<td colspan="2">KAS BERSIH DIPEROLEH DARI AKTIVITAS OPERASI</td>
					<td align="right"><?php echo eliminasi_negatif($total_semua_sekarang); ?></td>
				</tr>
				<tr>
					<td></td>
					<td><b>ARUS KAS DARI AKTIVITAS INVESTASI</b></td>
					<td></td>
				</tr>
				<?php foreach($data_investasi as $key=>$value){ ?>
				<tr>
					<td></td>
					<td class="tab2">
						<?php 
						$kode_akun = explode('_', $key);
						if($kode_akun[0]=='fluk'){
							$kode_akun[0] = '(Penambahan)/Pengurangan';
						}
						$hasil = implode(' ', $kode_akun);
						echo ucwords($hasil); 
						?>
					</td>
					<td align="right"><?php echo eliminasi_negatif($value['saldo'] + $value['debet'] - $value['kredit'] ); ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td></td>
					<td><b>ARUS KAS DARI AKTIVITAS PENDANAAN</b></td>
					<td></td>
					<!-- <td></td> -->
				</tr>
				<?php foreach($data_pendanaan as $key=>$value){ ?>
				<tr>
					<td></td>
					<td class="tab2"><?php echo str_replace('_', ' ', $key); ?></td>
					<td></td>
					<!-- <td align="right"></td> -->
				</tr>
					<?php foreach($value as $key_1=>$value_1){ ?>
					<tr>
						<td></td>
						<td class="tab3"><?php echo str_replace('_', ' ', $key_1); ?></td>
						<!-- <td align="right"><?php echo eliminasi_negatif($value_1['saldo']); ?></td> -->
						<td></td>
					</tr>
					<?php } ?>
				<?php } ?>
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
?>