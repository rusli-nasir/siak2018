<?php
if(isset($excel)){
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=Rekap_jurnal.xls");  //File name extension was wrong
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
		<title>Rekap Jurnal</title>
		<script type="text/javascript">
		</script>
	</head>

	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<?php if(isset($excel)){ ?>
		<?php }else{ ?>
		<form action="<?php echo site_url('akuntansi/laporan/cetak_rekap_jurnal') ?>" method="post">
			<input type="hidden" name="tipe" value="excel">
			<input type="hidden" name="unit" value="<?php echo $this->input->post('unit') ?>">
			<input type="hidden" name="basis" value="<?php echo $this->input->post('basis') ?>">
			<input type="hidden" name="daterange" value="<?php echo $this->input->post('daterange') ?>">
			<input type="hidden" name="sumber_dana" value="<?php echo $this->input->post('sumber_dana') ?>">
			<input type="hidden" name="akun[]" value="<?php echo $this->input->post('akun')[0] ?>">
			<input type="hidden" name="cetak" value="cetak">
			<!-- <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Cetak</button> -->
		</form>
		<a download="Rekap_jurnal.xls" id="download_excel" class="no-print"><button  class="btn btn-success" type="button">Download excel</button></a>
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
		.btn{padding:10px;box-shadow:1px 1px 2px #bdbdbd;border:0px;}
    	.excel{background-color:#A3A33E;color:#fff;}
    	.pdf{background-color:#588097;color:#fff;}
		</style>
		<div align="center" style="font-weight:bold">
			<?php echo $teks_unit; ?><br/>
			JURNAL UMUM<br/>
			<?php echo $teks_periode; ?><br/>
			<?php echo $teks_tahun_anggaran; ?><br/><br/>
		</div>
		<table style="width:1300px;font-size:10pt;" class="border">
			<thead>
				<tr style="background-color:#ECF379;height:45px">
					<th>No</th>
					<th>Tanggal</th>
					<th>NO. SPM</th>
					<th>NO. BUKTI</th>
					<th>OUTPUT</th>
					<th>Kode Akun</th>
					<th width="350px">URAIAN</th>
					<th>DEBET</th>
					<th>KREDIT</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$iter = 1;

		        $jumlah_debet = 0;
		        $jumlah_kredit = 0;

		        $baris = 6;
		        $total_data = 24;//count($query);

		        foreach ($query as $entry) {
		        	$transaksi = $entry['transaksi'];
            		$akun = $entry['akun'];
            		$nama_unit = get_nama_unit($transaksi['unit_kerja']);
            		
            		echo '<tr>
            				<td align="center" style="background-color:#D0FCEE">'.$iter.'</td>
            				<td align="center" colspan="5" style="background-color:#D0FCEE" align="right">Keterangan</td>
            				<td colspan="3" width="200px" style="background-color:#D0FCEE">'.$nama_unit.':<br/>'.$transaksi['uraian'].'</td>
            			</tr>';
            		foreach ($akun as $in_akun) {			
            			echo '<tr>
            					<td></td>
            					<td>'.date("d M Y", strtotime($transaksi['tanggal'])).'</td>
            					<td>'.$transaksi['no_spm'].'</td>
            					<td>'.$transaksi['no_bukti'].'</td>
            					<td>'.substr($transaksi['kode_kegiatan'],6,4).'</td>
            					<td>'.$in_akun['akun'].'</td>
            					<td>'.get_nama_akun_v($in_akun['akun']).'</td>';
            					if ($in_akun['tipe'] == 'debet'){
				                    echo '<td align="right">'.eliminasi_negatif($in_akun['jumlah']).'</td>';
				                    echo '<td align="right">0.00</td>';
				                    $jumlah_debet += $in_akun['jumlah'];
				                }elseif ($in_akun['tipe'] == 'kredit') {
				                    echo '<td align="right">0.00</td>';
				                    echo '<td align="right">'.eliminasi_negatif($in_akun['jumlah']).'</td>';
				                    $jumlah_kredit += $in_akun['jumlah'];
				                }
            			echo '</tr>';         			
            		}
		        	$iter++;
		        }
				?>
			</tbody>
			<?php
			echo '<tr>
    				<td align="right" colspan="7" style="background-color:#B1E9F2"><b>Jumlah Total</b></td>
    				<td align="right">'.eliminasi_negatif($jumlah_debet).'</td>
    				<td align="right">'.eliminasi_negatif($jumlah_kredit).'</td>
    			</tr>';
			?>
		</table>
		<br/>
		<table width="1100px;">
			<tbody>
				<tr>
					<td colspan="4" width="600px;"></td>
					<td colspan="4">
						<?php 
						if ($unit == null or $unit == 9999) {
						    $pejabat = get_pejabat('all','rektor');
						    $teks_kpa = "Rektor";
						    $teks_unit = "UNIVERSITAS DIPONEGORO";
						} else {
						    $pejabat = get_pejabat($unit,'kpa');
						    $teks_kpa = "Pengguna Anggaran";
						    $teks_unit = get_nama_unit($unit);
						}
						echo 'Semarang, '.$periode_akhir.'<br/>'.$teks_kpa.'<br/>';
						echo $teks_unit.'<br/><br/><br/><br/>';
						echo $pejabat['nama'].'<br/>NIP. '.$pejabat['nip'];
						?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	</body>
</html>

<script type="text/javascript">
	$('#download_excel').click(function(){
		var result = 'data:application/vnd.ms-excel,' + encodeURIComponent($('#printed_table').html()) 
		this.href = result;
		this.download = "Rekap_jurnal.xls";
		return true;
	})
	$('#print_tabel').click(function(){
		$("#printed_table").print();
	})
</script>

<?php
function get_nama_unit($kode_unit)
{
	if ($kode_unit == 9999) {
		return 'Penerimaan';
	}
	$ci =& get_instance();
	$ci->db2 = $ci->load->database('rba', true);
    $hasil = $ci->db2->where('kode_unit',$kode_unit)->get('unit')->row_array();
    if ($hasil == null) {
        return '-';
    }
    return $hasil['nama_unit'];

}

function get_nama_akun_v($kode_akun){
	$ci =& get_instance();
	return $ci->Akun_model->get_nama_akun($kode_akun);
}

function get_saldo_awal($kode_akun){
	$ci =& get_instance();
	if ($ci->session->userdata('kode_unit') != 42 AND $ci->session->userdata('kode_akun') != 9999) {
		return null;
	}
	$tahun = $this->session->userdata('setting_tahun');
	$hasil = $ci->db->get_where('akuntansi_saldo',array('akun' => $kode_akun,'tahun' => $tahun))->row_array();

	return $hasil;
}

function get_pejabat($unit, $jabatan){
	$ci =& get_instance();
	$ci->db->where('unit', $unit);
	$ci->db->where('jabatan', $jabatan);
	return $ci->db->get('akuntansi_pejabat')->row_array();
}

function eliminasi_negatif($value)
{
    if ($value < 0) 
        return "(". number_format(abs($value),2,',','.') .")";
    else
        return number_format($value,2,',','.');
}
?>