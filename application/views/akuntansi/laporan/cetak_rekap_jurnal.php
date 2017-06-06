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
		window.print();
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

		        foreach ($query as $entry) {
		        	$transaksi = $entry['transaksi'];
            		$akun = $entry['akun'];
            		$nama_unit = get_nama_unit($transaksi['unit_kerja']);
            		
            		echo '<tr>
            				<td align="center" style="background-color:#D0FCEE">'.$iter.'</td>
            				<td align="center" colspan="5" style="background-color:#D0FCEE" align="right">Keterangan</td>
            				<td colspan="3">'.$nama_unit.':<br/>'.$transaksi['uraian'].'</td>
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
				                    echo '<td align="right">'.number_format($in_akun['jumlah'],2).'</td>';
				                    echo '<td align="right">0.00</td>';
				                    $jumlah_debet += $in_akun['jumlah'];
				                }elseif ($in_akun['tipe'] == 'kredit') {
				                    echo '<td align="right">0.00</td>';
				                    echo '<td align="right">'.number_format($in_akun['jumlah'],2).'</td>';
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
    				<td align="right">'.number_format($jumlah_debet,2).'</td>
    				<td align="right">'.number_format($jumlah_kredit,2).'</td>
    			</tr>';
			?>
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