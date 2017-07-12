<!DOCTYPE>
<?php
if(isset($excel)){
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=neraca_saldo.xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
}
?>
<html>
	<head>
		<title>Neraca Saldo</title>
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
		<script type="text/javascript">
		//window.print();
		</script>
	</head>
	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<?php if(!isset($excel)){ ?>
			&nbsp;&nbsp;
			<?php echo form_open("akuntansi/laporan/cetak_neraca_saldo/excel",array("class"=>"form-horizontal")); ?>
				<input type="hidden" name="tipe" value="excel">
				<input type="hidden" name="unit" value="<?php echo $this->input->post('unit') ?>">
				<input type="hidden" name="basis" value="<?php echo $this->input->post('basis') ?>">
				<input type="hidden" name="daterange" value="<?php echo $this->input->post('daterange') ?>">
				<input type="hidden" name="sumber_dana" value="<?php echo $this->input->post('sumber_dana') ?>">
				<input type="hidden" name="akun[]" value="<?php echo $this->input->post('akun')[0] ?>">
				<input class="btn excel" type="submit" name="Download excel" value="Download Excel">
			</form>
			<?php 
			$arr_sumber = explode('_', $sumber);
			$link_cetak = 'cetak_'.$arr_sumber[1].'_'.$arr_sumber[2];
			?>
			<?php echo form_open("akuntansi/laporan/$link_cetak",array("class"=>"form-horizontal", "target"=>"_blank")); ?>
				<input type="hidden" name="tipe" value="pdf">
				<input type="hidden" name="unit" value="<?php echo $this->input->post('unit') ?>">
				<input type="hidden" name="basis" value="<?php echo $this->input->post('basis') ?>">
				<input type="hidden" name="daterange" value="<?php echo $this->input->post('daterange') ?>">
				<input type="hidden" name="sumber_dana" value="<?php echo $this->input->post('sumber_dana') ?>">
				<input type="hidden" name="akun[]" value="<?php echo $this->input->post('akun')[0] ?>">
				<input class="btn pdf"  type="submit" name="Cetak PDF" value="Cetak PDF">
			</form>
		<?php } ?>
		<div align="center" style="font-weight:bold">
			<?php echo $teks_unit; ?><br/>
			NERACA SALDO<br/>
			<?php echo $teks_periode; ?><br/><br/>
		</div>
		<?php 
			echo '<table style="font-size:10pt;">
						<tr>
							<td width="150px"><b>Unit Kerja</b></td>
							<td>:'.$teks_unit.'</td>
						</tr>
						<tr>
							<td><b>Tahun Anggaran</b></td>
							<td>:'.$teks_tahun_anggaran.'</td>
						</tr>
				</table>';
			echo '<table style="width:1300px;font-size:10pt;" class="border">
					<thead style="background-color:#ECF379;height:45px">
						<tr style="background-color:#ECF379;">
							<th rowspan="2">No</th>
							<th rowspan="2">Kode</th>
							<th width="500px" rowspan="2">Uraian</th>
							<th colspan="2">Mutasi</th>
							<th colspan="2">Neraca Saldo</th>
						</tr>
						<tr style="background-color:#ECF379;">
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
		    	$debet = 0;
		    	$kredit = 0;
		    	$case_hutang = in_array(substr($key,0,1),[2,3,4,6]);
		    	$saldo = get_saldo_awal($key);
	            if ($saldo != null) {
	                $saldo = $saldo['saldo_awal'];
	            }

				echo '<tr>
						<td>'.$i.'</td>
						<td>'.$key.'</td>
						<td>'.get_nama_akun_v((string)$key).'</td>';
					foreach ($entry as $transaksi) {
		    			if ($transaksi['tipe'] == 'debet'){
		    				if ($case_hutang) {
		                        $saldo -= $transaksi['jumlah'];
		                    } else {
		                        $saldo += $transaksi['jumlah'];
		                    }
		    				$debet += $transaksi['jumlah'];
		    			} else if ($transaksi['tipe'] == 'kredit'){
							if ($case_hutang) {
		                        $saldo += $transaksi['jumlah'];
		                    } else {
		                        $saldo -= $transaksi['jumlah'];
		                    }
							$kredit += $transaksi['jumlah'];
		    			}
		    		}


		    		$jumlah_debet += $debet;
		    		$jumlah_kredit += $kredit;

		    		echo '<td align="right">'.eliminasi_negatif($debet).'</td>
						<td align="right">'.eliminasi_negatif($kredit).'</td>';

		    		if ($case_hutang) {
		                $saldo_neraca = $kredit - $debet;
		            } else {
		                $saldo_neraca = $debet - $kredit;
		            }

				
					if ($saldo_neraca > 0) {
		                $jumlah_neraca_debet += $saldo_neraca;
		                echo '<td align="right">0.00</td>';
		                echo '<td align="right">'.eliminasi_negatif($saldo_neraca).'</td>';
		            } elseif ($saldo_neraca < 0) {
		                $saldo_neraca = abs($saldo_neraca);
		                $jumlah_neraca_kredit += $saldo_neraca;
		                echo '<td align="right">0.00</td>';
		                echo '<td align="right">'.eliminasi_negatif($saldo_neraca).'</td>';
		            }else{
		            	echo '<td align="right">0.00</td>';
		            	echo '<td align="right">0.00</td>';
		            }

				echo '</tr>';

				$i++;
			}
    		echo '</tbody>
	    			<tfoot>
					 	<tr style="background-color:#B1E9F2;">
		    				<td align="right" colspan="3" style="background-color:#B1E9F2"><b>Jumlah Total</b></td>
		    				<td align="right">'.eliminasi_negatif($jumlah_debet).'</td>
		    				<td align="right">'.eliminasi_negatif($jumlah_kredit).'</td>
		    				<td align="right">'.eliminasi_negatif($jumlah_neraca_debet).'</td>
		    				<td align="right">'.eliminasi_negatif($jumlah_neraca_kredit).'</td>
		    			</tr>
	    			</tfoot>
				</table>';
		?>
		<table width="1300px;">
			<tbody>
				<tr>
					<td colspan="4" width="800px;"></td>
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
	</body>
</html>
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
	if (isset($kode_akun)){
			if (substr($kode_akun,0,1) == 5){
				return $ci->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
			} else if (substr($kode_akun,0,1) == 7){
				$kode_akun[0] = 5;
				$nama = $ci->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
				$uraian_akun = explode(' ', $nama);
				if(isset($uraian_akun[0])){
		            if($uraian_akun[0]!='beban'){
		              $uraian_akun[0] = 'beban';
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
			}else if (substr($kode_akun,0,1) == 8){
				$hasil =  $ci->db->get_where('akuntansi_pembiayaan_6',array('akun_6' => $kode_akun))->row_array()['nama'];
				if ($hasil == null) {
					$hasil = $ci->db->get_where('akuntansi_pajak',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
				}
				return $hasil;
			} else if (substr($kode_akun,0,1) == 9){
				return $ci->db->get_where('akuntansi_sal_6', array('akun_6' => $kode_akun))->row_array()['nama'];
			} else if (substr($kode_akun,0,1) == 1){
				$hasil = $ci->db->get_where('akuntansi_kas_rekening',array('kode_rekening' => $kode_akun))->row_array()['uraian'];
				/*if ($hasil == null){
					$hasil = $ci->db->get_where('akun_kas6',array('kd_kas_6' => $kode_akun))->row_array()['nm_kas_6'];
				}*/
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
	$ci =& get_instance();
	$tahun = gmdate('Y');
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

function format_nip($value)
{
    return str_replace("'",'',$value);
}
?>