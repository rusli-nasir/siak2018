<?php 
if($atribut['cetak']){ 
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=lpe.xls");  //File name extension was wrong
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

		<title>Laporan Perubahan Aset Neto</title>
		<script type="text/javascript">
		</script>
	</head>
	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<?php if($atribut['cetak']=='cetak'){ ?>
		<?php }else{ ?>
		<a download="lpe.xls" id="download_excel"><button  class="btn btn-success" type="button">Download excel</button></a>
		<button class="btn btn-success" type="button" id="print_tabel">Cetak</button>
		<?php } ?>
		<div id="printed_table">
		<style type="text/css">
			@page{
				size: A4 portrait;
			}
			.border {
			    border-collapse: collapse;
			}
			
			hr{
				border-color:black;
				border-size: 10px;
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
			<div style="font-weight:bold;">
				UNIVERSITAS DIPONEGORO<br/>
				LAPORAN PERUBAHAN ASET NETO <br/>
				<?php echo $atribut['daterange']; ?><br/>
			</div>
				(Disajikan dalam Rupiah, kecuali dinyatakan lain)<br/>	
		</div>			
		<hr>
	</br>
		<table style="width:70%;font-size:12pt;margin:0 auto" class="border">
			<tr>
				<td>Aset Neto Awal</td>
				<td align="right"><?php echo eliminasi_negatif($surplus)?></td>
			</tr>
			<tr>
				<td>Laba Bersih</td>
				<td align="right"><?php echo eliminasi_negatif($saldo_awal) ?></td>
			</tr>
			<tr style="font-weight:bold;background-color: #EDED74">
				<td>Aset Neto Akhir Per 31 Desember <?php echo $tahun ?></td>
				<td align="right"><?php echo eliminasi_negatif($surplus + $saldo_awal) ?></td>
			</tr>
		</tbody>
	</table>
	<br/>
	<br/>
	<table width="100%;">
		<tbody>
			<tr style="page-break-inside: avoid;">
				<td colspan="4" width="60%;"></td>
				<td colspan="4" >
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
		this.download = "lpe.xls";
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
		return '('.number_format(abs($value),2,',','.').')';
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