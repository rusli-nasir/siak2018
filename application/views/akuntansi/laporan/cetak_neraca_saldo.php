<!DOCTYPE>
<html>
	<head>
		<title>Neraca Saldo</title>
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
			NERACA SALDO<br/>
			<?php echo $teks_periode; ?><br/><br/>
		</div>
		<?php 
			echo '<table style="font-size:10pt;">
						<tr>
							<td width="250px"><b>Unit Kerja</b></td>
							<td>UNIVERSITAS DIPONEGORO</td>
						</tr>
						<tr>
							<td><b>Tahun Anggaran</b></td>
							<td>2017</td>
						</tr>
				</table>';
			echo '<table style="width:1300px;font-size:10pt;" border="1">
					<thead style="background-color:#ECF379;height:45px">
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">Kode</th>
							<th width="500px" rowspan="2">Uraian</th>
							<th colspan="2">Mutasi</th>
							<th colspan="2">Neraca Saldo</th>
						</tr>
						<tr>
							<th>DEBIT</th>
							<th>KREDIT</th>
							<th>DEBIT</th>
							<th>KREDIT</th>
						</tr>
					</thead>
					<tbody>';

			$i = 1;

			$jumlah_debet = 0;
		    $jumlah_kredit = 0;
	        $jumlah_neraca_debet = 0;
	        $jumlah_neraca_kredit = 0;

			foreach ($query as $key => $entry) {
				$saldo = get_saldo_awal($key);
		    	$debet = 0;
		    	$kredit = 0;

				echo '<tr>
						<td>'.$i.'</td>
						<td>'.$key.'</td>
						<td>'.get_nama_akun_v((string)$key).'</td>';
					foreach ($entry as $transaksi) {
		    			if ($transaksi['tipe'] == 'debet'){
		    				$saldo += $transaksi['jumlah'];
		    				$debet += $transaksi['jumlah'];
		    			} else if ($transaksi['tipe'] == 'kredit'){
							$saldo -= $transaksi['jumlah'];
							$kredit += $transaksi['jumlah'];
		    			}
		    		}


		    		$jumlah_debet += $debet;
		    		$jumlah_kredit += $kredit;
		    		$saldo_neraca = $debet - $kredit;

				echo '<td align="right">'.number_format($debet,2).'</td>
						<td align="right">'.number_format($kredit,2).'</td>';
					if ($saldo_neraca > 0) {
		                $jumlah_neraca_debet += $saldo_neraca;
		                echo '<td align="right">0.00</td>';
		                echo '<td align="right">'.number_format($saldo_neraca,2).'</td>';
		            } elseif ($saldo_neraca < 0) {
		                $saldo_neraca = abs($saldo_neraca);
		                $jumlah_neraca_kredit += $saldo_neraca;
		                echo '<td align="right">0.00</td>';
		                echo '<td align="right">'.number_format($saldo_neraca,2).'</td>';
		            }else{
		            	echo '<td align="right">0.00</td>';
		            	echo '<td align="right">0.00</td>';
		            }

				echo '</tr>';

				$i++;
			}
			echo '<tr>
    				<td align="right" colspan="3" style="background-color:#B1E9F2"><b>Jumlah Total</b></td>
    				<td align="right">'.number_format($jumlah_debet,2).'</td>
    				<td align="right">'.number_format($jumlah_kredit,2).'</td>
    				<td align="right">'.number_format($jumlah_neraca_debet,2).'</td>
    				<td align="right">'.number_format($jumlah_neraca_kredit,2).'</td>
    			</tr>
    			</tbody>
				</table>';
		?>
	</body>
</html>
<?php
function get_nama_akun_v($kode_akun){
	$ci =& get_instance();
	if (isset($kode_akun)){
		if (substr($kode_akun,0,1) == 5){
			return $ci->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
		} else if (substr($kode_akun,0,1) == 7){
			$kode_akun[0] = 5;
			$nama = $ci->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
			$uraian_akun = explode(' ', $nama);
			if(isset($uraian_akun[2])){
	            if($uraian_akun[2]!='beban'){
	              $uraian_akun[2] = 'beban';
	            }
	        }
            $hasil_uraian = implode(' ', $uraian_akun);
            return $hasil_uraian;
		} else if (substr($kode_akun,0,1) == 6 or substr($kode_akun,0,1) == 4){
			$kode_akun[0] = 4;
			$hasil =  $ci->db->get_where('akuntansi_lra_6',array('akun_6' => $kode_akun))->row_array()['nama'];
			if ($hasil == null) {
				$hasil = $ci->db->get_where('akuntansi_pajak',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
			}
			return $hasil;
		} else if (substr($kode_akun,0,1) == 9){
			return 'SAL';
		} else if (substr($kode_akun,0,1) == 1){
			$hasil = $ci->db->get_where('akuntansi_kas_rekening',array('kode_rekening' => $kode_akun))->row_array()['uraian'];
			if ($hasil == null){
				$hasil = $ci->db->get_where('akun_kas6',array('kd_kas_6' => $kode_akun))->row_array()['nm_kas_6'];
			}
			if ($hasil == null){
				$hasil = $ci->db->get_where('akuntansi_aset_6',array('akun_6' => $kode_akun))->row_array()['nama'];
			}
			return $hasil;
		} else {
			return 'Nama tidak ditemukan';
		}
	}
	
}

function get_saldo_awal($kode_akun){
	return 1000000000;
}
?>