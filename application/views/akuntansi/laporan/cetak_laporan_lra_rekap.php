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
		<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-3.1.0/jquery-3.1.0.min.js"></script>
		<!-- <link href="<?php echo base_url();?>/assets/akuntansi/css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
		<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>/assets/akuntansi/js/jquery.print.js"></script>
		<title>Rekap Laporan Realisasi Anggaran</title>
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
			<!-- <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Cetak</button> -->
		</form>
		<a download="neraca_saldo.xls" id="download_excel" class="no-print"><button  class="btn btn-success" type="button">Download excel</button></a>
		<button class="btn btn-success no-print" type="button" id="print_tabel">Cetak</button>
		<?php } ?>
		<div id="printed_table">
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

			td { 
			    padding: 4px;
			}
			.tab0{padding-left:0px !important;font-weight:bold;}
			.tab1{padding-left:20px !important;font-weight:bold;}
			.tab2{padding-left:40px !important;}
			.tab3{padding-left:60px !important;}
			.btn{padding:10px;box-shadow:1px 1px 2px #bdbdbd;border:0px;}
	    	.excel{background-color:#A3A33E;color:#fff;}
	    	.pdf{background-color:#588097;color:#fff;}

	    	tbody tr:nth-child(even) {
			   background-color: #ccc;
			}
		</style>
		<?php foreach ($parse_all as $jenis_lra => $parse): ?>
			
			<div align="center">
				<div style="font-weight:bold">
					<?php echo str_replace("Fak.","Fakultas ",$nama_unit); ?><br/>
					Laporan Realisasi Anggaran (<?php echo ucwords($jenis_lra) ?>) <br/>
					Periode yang berakhir pada <?php echo $tanggal_laporan; ?><br/>
				</div>
				(Disajikan dalam Rupiah, kecuali dinyatakan lain)<br/><br/>
			</div>
			<table style="width:90%;font-size:10pt;margin:0 auto" class="border">
				<thead>
					<tr style="background-color:#FFC2FF;height:45px">
						<th >No.</th>
						<th width="50%">URAIAN</th>
						<th width="15%">Anggaran</th>
						<th width="15%">Realisasi</th>
						<th width="15%">Realisasi Diatas(Dibawah) Anggaran</th>
						<th width="5%">%</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 0; 
						  foreach ($parse as $key => $entry): ?>
						  	<?php if ($entry['level'] != 0 or $entry['type'] != 'index' or true): ?>
								<tr 
									<?php if (!isset($entry['level_spec'])): ?>
										<?php if ($entry['type'] == 'sum'): ?>
											style="background-color: #EDED74;font-weight: bold;"
										<?php elseif ($entry['level'] == $atribut['level']-2): ?>
											style="background-color: #7CFFFF;font-weight: bold;"
										<?php elseif ($entry['level'] < $atribut['level']-1): ?>
											style="background-color: #54FFA9;font-weight: bold;"
										<?php endif ?>
									<?php else: ?>
										<?php if ($entry['type'] == 'sum'): ?>
											style="background-color: #EDED74;font-weight: bold;"
										<?php elseif ($entry['level'] == $entry['level_spec']-2): ?>
											style="background-color: #7CFFFF;font-weight: bold;"
										<?php elseif ($entry['level'] < $entry['level_spec']-1): ?>
											style="background-color: #54FFA9;font-weight: bold;"
										<?php endif ?>
										
									<?php endif ?>
								>
									<?php if ($jenis_laporan == 'rekap'): ?>
										<td> <?php echo ++$no; ?></td>
									<?php else: ?>
										<td> <?php if ($entry['type'] != 'sum') echo $entry['akun'] ?></td>
									<?php endif ?>
									<td>
										<?php 
										for ($i=0; $i < $entry['level']*2; $i++) { 
											echo "&nbsp;&nbsp;";
										}

										 ?>
										<?php
											if ($entry['level'] < $atribut['level']-1) {
												$entry['nama'] = strtolower($entry['nama']);
												$entry['nama'] = ucwords($entry['nama']);
											}
											$entry['nama'] = str_replace('Apbn', "APBN", $entry['nama']);
											$entry['nama'] = str_replace('bp Ptnbh', "BP PTNBH", $entry['nama']);
											$entry['nama'] = str_replace(' Ptn ', " PTN ", $entry['nama']);
											$entry['nama'] = str_replace(' Bh', " BH", $entry['nama']);
											$entry['nama'] = str_replace(' Pns', " PNS", $entry['nama']);
											$entry['nama'] = str_replace(' Beban', " Biaya", $entry['nama']);
											$entry['nama'] = str_replace('Beban', "Biaya", $entry['nama']);
											$entry['nama'] = str_replace(' BEBAN', " BIAYA", $entry['nama']);
											$entry['nama'] = str_replace('bumu', "BUMU", $entry['nama']);
										 	echo $entry['nama'];
										 ?>
										</td>
									<td align="right"><?php  echo eliminasi_negatif($entry['anggaran']) ?></td>
									<td  align="right"><?php  echo eliminasi_negatif($entry['realisasi']) ?></td>
									<td  align="right"><?php  echo eliminasi_negatif($entry['selisih']) ?></td>
									<td  align="right"><?php  echo number_format($entry['persentase'],2); ?></td>
									
								</tr>
							<?php endif ?>
						
					<?php endforeach ?>
				</tbody>
			</table>
			<br/>
		<?php endforeach ?>
		<table width="100%">
			<tbody>
				<tr>
					<td colspan="4" width="70%"></td>
					<td colspan="4">
						<?php 
						$pejabat = $kpa;
					    $teks_unit = str_replace("Fak.","Fakultas ",$nama_unit);
						echo 'Semarang, '.$atribut['periode_ttd'].'<br/>'.$teks_kpa.'<br/>';
						echo $teks_unit.'<br/><br/><br/><br/>';
						echo $pejabat['nama'].'<br/>NIP. '.$pejabat['nip'];
						?>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
	</body>
	<script type="text/javascript">
		$('#download_excel').click(function(){
		        var result = 'data:application/vnd.ms-excel,' + encodeURIComponent($('#printed_table').html()) 
		        this.href = result;
		        this.download = "laporan_realisasi_anggaran.xls";
		        return true;
		    })
		    $('#print_tabel').click(function(){
		        $("#printed_table").print();
		    })
	</script>
</html>

<?php
function eliminasi_negatif($value)
{
    if ($value < 0) 
    	return number_format(abs($value),2,',','.');
        // return "(". number_format(abs($value),2,',','.') .")";
    elseif ($value === null)
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