<!DOCTYPE>
<html>
	<head>
		<title>Rekap Jurnal</title>
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
		</script>
	</head>
	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		&nbsp;&nbsp;
		<?php echo form_open("akuntansi/laporan/$sumber/excel",array("class"=>"form-horizontal")); ?>
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
		<div align="right" style="width:1200px;margin-top:40px;">
			<div style="width:400px" align="left">
				<?php 
				echo 'Semarang, '.$periode_akhir.'<br/>Pengguna Anggaran<br/>';
				echo get_nama_unit($unit).'<br/><br/><br/><br/>';
				$pejabat = get_pejabat($unit, 'kpa'); 
				echo $pejabat['nama'].'<br/>NIP. '.$pejabat['nip'];
				?>
			</div>
		</div>
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
	$hasil = $ci->db->get_where('akuntansi_saldo',array('akun' => $kode_akun))->row_array();

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