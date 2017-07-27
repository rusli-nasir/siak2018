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
		<div align="center" style="font-weight:bold">
			UNIVERSITAS DIPONEGORO<br/>
			Laporan Aktivitas<br/>
			<?php echo $atribut['teks_periode']; ?><br/><br/>
		</div>
		<table style="width:1100px;font-size:10pt;margin:0 auto" class="border">
			<thead>
				<tr style="background-color:#ECF379;height:45px">
					<th width="30px">No</th>
					<th width="750px">URAIAN</th>
					<th>TAHUN 20X1</th>
					<th>TAHUN 20X0</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0;$j=0;
				foreach($jenis_pembatasan as $key=>$value_pembatasan){ ?>
					<tr>
						<td colspan="4" align="center" style="background-color:#e6e6e6"><?php echo $value_pembatasan; ?></td>
					</tr>
				<?php foreach ($akun as $key_1 => $akun_1) {
						foreach($nama_lvl_1[$value_pembatasan][$key_1] as $key=>$value){ ?>
						<tr>
							<td></td>
							<td class="tab0"><?php echo $value; ?></td>
							<td></td>
							<td></td>
						</tr>
						<?php foreach($nama_lvl_2[$value_pembatasan][$key_1] as $key=>$value){ ?>
							<tr>
								<td></td>
								<td class="tab1"><?php echo $value; ?></td>
								<td></td>
								<td></td>
							</tr>	
							<?php if($level==3){
								$counter=0;foreach($nama_lvl_3[$value_pembatasan][$key_lvl_2[$i]] as $key=>$value){ ?>
									<tr>
										<td></td>
										<td class="tab2"><?php echo $value; ?></td>
										<td class="tab2"><?php echo eliminasi_negatif($saldo_sekarang_lvl_3[$value_pembatasan][$key_lvl_2[$i]][$counter]); ?></td>
										<td class="tab2"><?php echo eliminasi_negatif($saldo_awal_lvl_3[$value_pembatasan][$key_lvl_2[$i]][$counter]); ?></td>
									</tr>
						<?php  $counter++; }
								}else{ ?>
								<?php foreach($nama_lvl_3[$value_pembatasan][$key_lvl_2[$i]] as $key=>$value){ ?>
									<tr>
										<td></td>
										<td class="tab2"><?php echo $value; ?></td>
										<td></td>
										<td></td>
									</tr>
								<?php $counter=0;foreach($nama_lvl_4[$value_pembatasan][$key_lvl_3[$j]] as $key=>$value){ ?>
										<tr>
											<td></td>
											<td class="tab3"><?php echo $value; ?></td>
											<td class="tab2"><?php echo eliminasi_negatif($saldo_sekarang_lvl_4[$value_pembatasan][$key_lvl_3[$j]][$counter]); ?></td>
										<td class="tab2"><?php echo eliminasi_negatif($saldo_awal_lvl_4[$value_pembatasan][$key_lvl_3[$j]][$counter]); ?></td>
										</tr>
								<?php 	$counter++; 
										} 
										$j++;
									}				
								}				
							$i++;
							}
					  	}
					}
				} ?>	
			</tbody>
			<tfoot>
				<tr style="background-color:#B1E9F2">
					<td colspan="2" align="right">Total</td>
					<td align="right"><?php echo eliminasi_negatif($jumlah_tahun_sekarang); ?></td>
					<td align="right"><?php echo eliminasi_negatif($jumlah_tahun_awal); ?></td>
				</tr>
			</tfoot>
		</table>
	</body>
</html>

<?php
function eliminasi_negatif($value)
{
    if ($value < 0) 
    	return '('.number_format(abs($value),2,',','.').')';
        // return "(". number_format(abs($value),2,',','.') .")";
    else
        return number_format($value,2,',','.');
}
?>