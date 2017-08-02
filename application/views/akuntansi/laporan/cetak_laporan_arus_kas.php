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
					<th>20X0</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0;$j=0;$index=0;
				foreach($data_all as $order=>$entry){
				 foreach ($akun[$order] as $key_1 => $akun_1) {
					foreach($nama_lvl_1[$order][$key_1] as $key=>$value){ ?>
						<tr>
							<td></td>
							<td class="tab0"><?php echo $value.' '.$jenis_pembatasan[$order]; ?></td>
							<td></td>
							<td></td>
						</tr>
						<?php foreach($nama_lvl_2[$order][$key_1] as $key=>$value){ 
							$jumlah_sekarang[$index] = 0;
							$jumlah_awal[$index] = 0;
							?>
								<tr>
									<td></td>
									<td class="tab1"><?php echo $value; ?></td>
									<td></td>
									<td></td>
								</tr>	
								<?php if($level==3){
									$counter=0;foreach($nama_lvl_3[$order][$key_lvl_2[$order][$key]] as $key_3=>$value){ 
										$jumlah_sekarang[$index] += $saldo_sekarang_lvl_3[$order][$key_lvl_2[$order][$key]][$counter];
										$jumlah_awal[$index] +=$saldo_awal_lvl_3[$order][$key_lvl_2[$order][$key]][$counter];
										?>
										<tr>
											<td></td>
											<td class="tab2"><?php echo $value; ?></td>
											<td class="tab2" align="right"><?php echo eliminasi_negatif($saldo_sekarang_lvl_3[$order][$key_lvl_2[$order][$key]][$counter]); ?></td>
											<td class="tab2" align="right"><?php echo eliminasi_negatif($saldo_awal_lvl_3[$order][$key_lvl_2[$order][$key]][$counter]); ?></td>
										</tr>
							<?php  $counter++; }
									}else{ ?>
									<?php foreach($nama_lvl_3[$order][$key_lvl_2[$order][$key]] as $key_3=>$value){ ?>
										<tr>
											<td></td>
											<td class="tab2"><?php echo $value; ?></td>
											<td></td>
											<td></td>
										</tr>
									<?php $counter=0;foreach($nama_lvl_4[$order][$key_lvl_3[$order][$key_3]] as $key_4=>$value){ 
										$jumlah_sekarang[$index] += $saldo_sekarang_lvl_4[$order][$key_lvl_3[$order][$key_3]][$counter];
										$jumlah_awal[$index] += $saldo_awal_lvl_4[$order][$key_lvl_3[$order][$key_3]][$counter];
										?>
											<tr>
												<td></td>
												<td class="tab3"><?php echo $value; ?></td>
												<td class="tab2" align="right"><?php echo eliminasi_negatif($saldo_sekarang_lvl_4[$order][$key_lvl_3[$order][$key_3]][$counter]); ?></td>
												<td class="tab2" align="right"><?php echo eliminasi_negatif($saldo_awal_lvl_4[$order][$key_lvl_3[$order][$key_3]][$counter]); ?></td>
											</tr>
									<?php 	$counter++; 
											} 
											$j++;
										}				
									}	
									?>
									<tr style="background-color:#F7F2AF">
										<td colspan="2" align="right"><b>Jumlah </b></td>
										<td align="right"><?php echo eliminasi_negatif($jumlah_sekarang[$index]); ?></td>
										<td align="right"><?php echo eliminasi_negatif($jumlah_awal[$index]); ?></td>
									</tr>
								<?php			
						  	}	
						  		$index++;
								$i++; 
						}
					}
				} ?>
				<tr>
					<td></td>
					<td><b>ARUS KAS DARI AKTIVITAS INVESTASI</b></td>
					<td></td>
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
					<td></td>
				</tr>
				<?php } ?>
				<tr>
					<td></td>
					<td><b>ARUS KAS DARI AKTIVITAS PENDANAAN</b></td>
					<td></td>
					<td></td>
				</tr>
				<?php foreach($data_pendanaan as $key=>$value){ ?>
				<tr>
					<td></td>
					<td class="tab2"><?php echo str_replace('_', ' ', $key); ?></td>
					<td align="right"></td>
					<td></td>
				</tr>
					<?php foreach($value as $key_1=>$value_1){ ?>
					<tr>
						<td></td>
						<td class="tab3"><?php echo str_replace('_', ' ', $key_1); ?></td>
						<td align="right"><?php echo eliminasi_negatif($value_1['saldo']); ?></td>
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