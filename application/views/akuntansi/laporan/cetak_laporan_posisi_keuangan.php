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
				Laporan Posisi Keuangan<br/>
				31 DESEMBER 20X1<br/>
			</div>
			(Disajikan dalam Rupiah, kecuali dinyatakan lain)<br/><br/>
		</div>
		<table style="width:1100px;font-size:10pt;margin:0 auto" class="border">
			<thead>
				<tr style="background-color:#ECF379;height:45px">
					<th width="30px"></th>
					<th width="750px">URAIAN</th>
					<th>31 Des 20X1</th>
					<th>31 Des 20X0</th>
					<th>Selisih/Kenaikan</th>
					<th>%</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($akun as $key_1 => $akun_1) {
					foreach($nama_lvl_1[$key_1] as $key=>$value){ ?>
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
							<td class="tab1"><?php echo $key; ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php $i=0;foreach($nama_lvl_3[$key_1] as $key=>$value){ ?>
							<tr>
								<td></td>
								<td class="tab2"><?php echo $value; ?></td>
								<td><?php echo $saldo_sekarang_lvl_3[$key_1][$i]; ?></td>
								<td><?php echo $saldo_awal_lvl_3[$key_1][$i]; ?></td>
								<td></td>
								<td></td>
							</tr>
						<?php 	$i++; } ?>
					<?php 	} ?>
				<?php	
					}
				} ?>	
			</tbody>
		</table>
	</body>
</html>