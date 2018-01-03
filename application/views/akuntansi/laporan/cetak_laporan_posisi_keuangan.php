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
		<title>Laporan Posisi Keuangan</title>
		<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-3.1.0/jquery-3.1.0.min.js"></script>
		<!-- <link href="<?php echo base_url();?>/assets/akuntansi/css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
		<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>/assets/akuntansi/js/jquery.print.js"></script>
		
		<script type="text/javascript">
		</script>
		<!-- <link href="<?php echo base_url();?>/assets/akuntansi/css/bootstrap.min.css" rel="stylesheet"> -->
	</head>
	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<?php if($atribut['cetak']=='cetak'){ ?>
		<?php }else{ ?>
		<form action="<?php echo site_url('akuntansi/laporan/lainnya') ?>" method="post">
			<input type="hidden" name="jenis_laporan" value="Posisi Keuangan">
			<input type="hidden" name="level" value="<?php echo $level; ?>">
			<input type="hidden" name="daterange" value="<?php if(isset($atribut['daterange'])) echo $atribut['daterange']; ?>">
			<input type="hidden" name="cetak" value="cetak">
			<!-- <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Cetak</button> -->
		</form>
		<a download="laporan_posisi_keuangan.xls" id="download_excel" class="no-print"><button  class="btn btn-success" type="button">Download excel</button></a>
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
			.tab0{padding-left:0px !important;font-weight:bold;}
			.tab1{padding-left:20px !important;font-weight:bold;}
			.tab2{padding-left:40px !important;}
			.tab3{padding-left:60px !important;}
			.btn{padding:10px;box-shadow:1px 1px 2px #bdbdbd;border:0px;}
	    	.excel{background-color:#A3A33E;color:#fff;}
	    	.pdf{background-color:#588097;color:#fff;}

	    	td { 
			    padding: 4px;
			}
		</style>
		<div align="center">
			<div style="font-weight:bold">
				UNIVERSITAS DIPONEGORO<br/>
				Laporan Posisi Keuangan<br/>
				<?php echo $atribut['daterange']; ?><br/>
			</div>
			(Disajikan dalam Rupiah, kecuali dinyatakan lain)<br/><br/>
		</div>
		<table align="center" style="width:90%;font-size:12pt;margin:0 auto;" class="border">
			<thead>
				<tr style="background-color:#FFC2FF;height:45px;">
					<th  style="text-align:center" width="">No</th>
					<th style="text-align:center" width="45%">URAIAN</th>
					<th style="text-align:center" width="15%"> <?php echo $atribut['daterange'];?></th>
					<th style="text-align:center" width="15%">31 Des <?php echo $this->session->userdata('setting_tahun')-1 ?></th>
					<th style="text-align:center" width="15%">Selisih/Kenaikan</th>
					<th style="text-align:center" width="5%">%</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$no = 0; 
					foreach ($parse as $key => $entry): ?>
					<tr 
						<?php if ($entry['type'] == 'sum'): ?>
							style="background-color: #EDED74;font-weight: bold;"
						<?php elseif ($entry['level'] == $atribut['level']-2): ?>
							style="background-color: #7CFFFF;font-weight: bold;"
						<?php elseif ($entry['level'] < $atribut['level']-1): ?>
							style="background-color: #54FFA9;font-weight: bold;"
						<?php endif ?>
					>
						<td> <?php if ($entry['type'] != 'sum') echo $entry['akun'] ?></td>
						<td>
							<?php 
							for ($i=0; $i < $entry['level']; $i++) { 
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
						<td align="right">
							<?php  if ($entry['type'] != "index") echo eliminasi_negatif($entry['jumlah_now']) ?>
						</td>
						<td  align="right"><?php if ($entry['type'] != "index") echo eliminasi_negatif($entry['jumlah_last']) ?></td>
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
		</div>
	</body>
	<script type="text/javascript">
		$('#download_excel').click(function(){
		        var result = 'data:application/vnd.ms-excel,' + encodeURIComponent($('#printed_table').html()) 
		        this.href = result;
		        this.download = "laporan_posisi_keuangan.xls";
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
    	// return number_format(abs($value),2,',','.');
        return "(". number_format(abs($value),2,',','.') .")";
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