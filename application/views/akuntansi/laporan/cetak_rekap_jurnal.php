<!DOCTYPE>
<html>
	<head>
		<title>Rekap Jurnal</title>
		<style type="text/css">
		@page{
			size:landscape;
		}
		</style>
		<script type="text/javascript">
		//window.print();
		</script>
	</head>
	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<div align="center" style="font-weight:bold">
			UNIVERSITAS DIPONEGORO<br/>
			JURNAL UMUM<br/>
			<?php echo $teks_periode; ?><br/>
			<?php echo $teks_tahun_anggaran; ?><br/><br/>
		</div>
		<table style="width:1300px;font-size:10pt;" border="1">
			<thead>
				<tr>
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

		        foreach ($query as $entry) {
		        	$transaksi = $entry['transaksi'];
            		$akun = $entry['akun'];
            		$nama_unit = get_nama_unit($transaksi['unit_kerja']);
            		
            		echo '<tr>
            				<td>'.$iter.'</td>
            				<td colspan="5" style="background-color:#B1E9F2" align="right">Keterangan</td>
            			</tr>';
		        	$iter++;
		        }
				?>
			</tbody>
		</table>
	</body>
</html>
<?php
function get_nama_unit($kode_unit)
    {
    	$ci =& get_instance();
    	$ci->db2 = $ci->load->database('rba', true);
        $hasil = $ci->db2->where('kode_unit',$kode_unit)->get('unit')->row_array();
        if ($hasil == null) {
            return '-';
        }
        return $hasil['nama_unit'];

    }

function get_saldo_awal($kode_akun){
	return 1000000000;
}
?>