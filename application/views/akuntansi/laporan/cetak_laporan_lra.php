<?php 
if($atribut['cetak']){ 
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=laporan_lra.xls");  //File name extension was wrong
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
			<input type="hidden" name="jenis_laporan" value="Realisasi Anggaran">
			<input type="hidden" name="level" value="<?php echo $level; ?>">
			<input type="hidden" name="daterange" value="<?php if(isset($atribut['parsing_date'])) echo $atribut['parsing_date']; ?>">
			<input type="hidden" name="cetak" value="cetak">
			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Cetak</button>
		</form>
		<?php } ?>
		<div align="center">
			<div style="font-weight:bold">
				<?php echo $nama_unit ?><br/>
				Laporan Realisasi Anggaran<br/>
				<?php echo $atribut['daterange']; ?><br/>
			</div>
			(Disajikan dalam Rupiah, kecuali dinyatakan lain)<br/><br/>
		</div>
		<table style="width:1100px;font-size:10pt;margin:0 auto" class="border">
			<thead>
				<tr style="background-color:#ECF379;height:45px">
					<th width="30px">No.</th>
					<th width="550px">URAIAN</th>
					<th>Anggaran</th>
					<th>Realisasi</th>
					<th>Realisasi Diatas(Dibawah) Anggaran</th>
					<th>%</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$no = 0; 
					  foreach ($parse as $key => $entry): ?>
					<tr <?php if ($entry['type'] == 'sum'): ?>
						style="background-color: #8DB4E2";
					<?php endif ?> >
						<td> &nbsp;<?php echo ++$no ?></td>
						<td>
							<?php 
							for ($i=0; $i < $entry['level']; $i++) { 
								echo "&nbsp;&nbsp;";
							}

							 ?>
							<?php echo $entry['nama'] ?>
							</td>
						<td align="right"><?php if ($entry['type'] != "index") echo eliminasi_negatif($entry['anggaran']) ?></td>
						<td  align="right"><?php if ($entry['type'] != "index") echo eliminasi_negatif($entry['realisasi']) ?></td>
						<td  align="right"><?php if ($entry['type'] != "index") echo eliminasi_negatif($entry['selisih']) ?></td>
						<td  align="right"><?php if ($entry['type'] != "index") echo number_format($entry['persentase'],2); ?></td>
						
					</tr>
					
				<?php endforeach ?>
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
    elseif ($value = null)
    	return '';
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