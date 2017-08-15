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
				Laporan Posisi Keuangan<br/>
				<?php echo $atribut['teks_periode']; ?><br/>
			</div>
			(Disajikan dalam Rupiah, kecuali dinyatakan lain)<br/><br/>
		</div>
		<table style="width:1100px;font-size:10pt;margin:0 auto" class="border">
			<thead>
				<tr style="background-color:#ECF379;height:45px">
					<th width="30px"></th>
					<th width="550px">URAIAN</th>
					<th>31 Des 20X1</th>
					<th>31 Des 20X0</th>
					<th>Selisih/Kenaikan</th>
					<th>%</th>
				</tr>
				<?php foreach ($parse as $key => $entry): ?>
					<tr <?php if ($entry['type'] == 'sum'): ?>
						style="background-color: #8DB4E2";
					<?php endif ?> >
						<td></td>
						<td>
							<?php 
							for ($i=0; $i < $entry['level']; $i++) { 
								echo "&nbsp";
							}

							 ?>
							<?php echo $entry['nama'] ?>
							</td>
						<td>
							<?php echo eliminasi_negatif($entry['jumlah_now']) ?>
						</td>
						<td><?php echo eliminasi_negatif($entry['jumlah_last']) ?></td>
						<td><?php echo eliminasi_negatif($entry['selisih']) ?></td>
						<td><?php echo $entry['persentase'] ?></td>
						
					</tr>
					
				<?php endforeach ?>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</body>
</html>

<?php
function eliminasi_negatif($value)
{
    if ($value < 0) 
    	// return number_format(abs($value),2,',','.');
        return "(". number_format(abs($value),2,',','.') .")";
    else
        return number_format($value,2,',','.');
}
?>