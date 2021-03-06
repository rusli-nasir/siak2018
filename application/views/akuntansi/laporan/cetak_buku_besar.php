<!DOCTYPE>
<?php
if(isset($excel)){
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=buku_besar.xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
}
?>
<html>
	<head>
		<title>Buku Besar</title>
		<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-3.1.0/jquery-3.1.0.min.js"></script>
		<script src="<?php echo base_url();?>/assets/akuntansi/js/jquery.print.js"></script>
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
		<?php echo form_open("akuntansi/laporan/cetak_buku_besar",array("class"=>"form-horizontal")); ?>
			<input type="hidden" name="tipe" value="excel">
			<input type="hidden" name="unit" value="<?php echo $this->input->post('unit') ?>">
			<input type="hidden" name="basis" value="<?php echo $this->input->post('basis') ?>">
			<input type="hidden" name="daterange" value="<?php echo $this->input->post('daterange') ?>">
			<input type="hidden" name="sumber_dana" value="<?php echo $this->input->post('sumber_dana') ?>">
			<input type="hidden" name="tujuan" value="<?php echo $this->input->post('tujuan') ?>">
			<input type="hidden" name="sasaran" value="<?php echo $this->input->post('sasaran') ?>">
			<input type="hidden" name="program" value="<?php echo $this->input->post('program') ?>">
			<input type="hidden" name="kegiatan" value="<?php echo $this->input->post('kegiatan') ?>">
			<input type="hidden" name="subkegiatan" value="<?php echo $this->input->post('subkegiatan') ?>">
			<input type="hidden" name="akun[]" value="<?php echo $this->input->post('akun')[0] ?>">
			<a download="buku_besar.xls" id="download_excel" class="no-print"><button  class="btn btn-success" type="button">Download excel</button></a>
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
			<input type="hidden" name="tujuan" value="<?php echo $this->input->post('tujuan') ?>">
			<input type="hidden" name="sasaran" value="<?php echo $this->input->post('sasaran') ?>">
			<input type="hidden" name="program" value="<?php echo $this->input->post('program') ?>">
			<input type="hidden" name="kegiatan" value="<?php echo $this->input->post('kegiatan') ?>">
			<input type="hidden" name="subkegiatan" value="<?php echo $this->input->post('subkegiatan') ?>">
			<input type="hidden" name="akun[]" value="<?php echo $this->input->post('akun')[0] ?>">
			<button class="btn btn-success no-print" type="button" id="print_tabel">Cetak</button>
		</form>
		<?php } ?>
		<div id="printed_table">
		<div align="center" style="font-weight:bold">
			<?php echo $teks_unit; ?><br/>
			BUKU BESAR<br/>
			<?php echo $periode_text; ?>
		</div>
		<?php if ($string_tujuan != null): ?>
			<hr/>
			<table style="font-size:10pt;">
				<tr>
					<td width="15%x" style="font-weight:bold;">Tujuan</td>
					<td colspan="7"><?php echo $string_tujuan ?></td>
				</tr>
				<?php if ($string_sasaran != null): ?>
					<tr>
						<td style="font-weight:bold;">Output</td>
						<td colspan="7"><?php echo $string_sasaran ?>'</td>
					</tr>					
				<?php endif ?>
				<?php if ($string_program != null): ?>
					<tr>
						<td style="font-weight:bold;">Program</td>
						<td colspan="7"><?php echo $string_program ?>'</td>
					</tr>					
				<?php endif ?>
				<?php if ($string_kegiatan != null): ?>
					<tr>
						<td style="font-weight:bold;">Kegiatan</td>
						<td colspan="7"><?php echo $string_kegiatan ?>'</td>
					</tr>					
				<?php endif ?>
				<?php if ($string_subkegiatan != null): ?>
					<tr>
						<td style="font-weight:bold;">Subkegiatan</td>
						<td colspan="7"><?php echo $string_subkegiatan ?>'</td>
					</tr>					
				<?php endif ?>
			</table>		
			<hr/>	
		<?php endif ?>
		<?php
		$baris = 4;
		$item = 1;
		$total_data = 4;//count($query); 
		$break = 'on';

		foreach ($query as $key=>$entry){
			echo '<table style="font-size:10pt;">
					<tr>
						<td width="180px" style="font-weight:bold;">Unit Kerja</td>
						<td>:'.$teks_unit.'</td>
					</tr>
					<tr>
						<td style="font-weight:bold;">Tahun Anggaran</td>
						<td>:'.$teks_tahun_anggaran.'</td>
					</tr>
					<tr>
						<td style="font-weight:bold;">Kode Akun</td>
						<td>:'.$key.'</td>
					</tr>
					<tr>
						<td style="font-weight:bold;">Nama Akun</td>
						<td>:'.get_nama_akun_v((string)$key).'</td>
					</tr>
				</table>';
			$saldo = get_saldo_awal($key);
	    	$jumlah_debet = 0;
	    	$jumlah_kredit = 0;
	    	$case_hutang = in_array(substr($key,0,1),[2,3,4,6]);

	    	echo '<table style="font-size:10pt;width:1100px;border:1px solid #bdbdbd;margin-bottom:20px;" class="border">
	    			<thead>
	    				<tr style="background-color:#ECF379">
	    					<th>No</th>
	    					<th>Tanggal</th>
	    					<th>No. Bukti</th>
	    					<th width="350px;">Uraian</th>
	    					<th>Ref</th>
	    					<th>Debet<br/>(Rp)</th>
	    					<th>Kredit<br/>(Rp)</th>
	    					<th>Saldo<br/>(Rp)</th>
	    				</tr>
	    			</thead>
	    			<tbody>';
    		$iter = 0;
	    	foreach ($entry as $transaksi) {	
	    		if ($check) {
	    			$iter++;
	    			$saldo = $query[$key]['saldo'];
	    			echo '<tr>
						<td>'.$iter.'</td>
						<td>'.$periode_awal.'</td>
						<td></td>
						<td>Saldo per '.$periode_awal.'</td>
						<td></td>';
						echo '<td align="right">0</td>';
						echo '<td align="right">0</td>';
						echo '<td align="right">'.eliminasi_negatif($saldo).'</td>';
						echo '</tr>';
						$iter++;
	    		} else{
		    		$iter++;
		    		if ($iter == 1 and $saldo != null) {
		    			$saldo = $saldo['saldo_awal'];
		    			echo '<tr>
							<td>'.$iter.'</td>
							<td>1 Januari '.$teks_tahun.'</td>
							<td></td>
							<td>Saldo Awal</td>
							<td></td>';
							echo '<td align="right">0</td>';
							echo '<td align="right">0</td>';
							echo '<td align="right">'.eliminasi_negatif($saldo).'</td>';
							echo '</tr>';
		    			$iter++;
		    		}
		    	}
		    	if ($transaksi['tanggal'] != NULL) {
					echo '<tr>
						<td>'.$iter.'</td>
						<td>'.$transaksi['tanggal'].'</td>
						<td>'.$transaksi['no_bukti'].'</td>
						<td width="350px;">'.$transaksi['uraian'].'</td>
						<td>_'.$transaksi['jenis'].'_</td>';
						if ($transaksi['tipe'] == 'debet'){
		    				echo '<td align="right">'.eliminasi_negatif($transaksi['jumlah']).'</td>';
		    				echo '<td align="right">0</td>';
		    				if ($case_hutang) {
		                        $saldo -= $transaksi['jumlah'];
		                    } else {
		    				    $saldo += $transaksi['jumlah'];
		                    }
		    				$jumlah_debet += $transaksi['jumlah'];
		    			} else if ($transaksi['tipe'] == 'kredit'){
		    				echo '<td align="right">0</td>';
							echo '<td align="right">'.eliminasi_negatif($transaksi['jumlah']).'</td>';
							if ($case_hutang) {
		                        $saldo += $transaksi['jumlah'];
		                    } else {
		                        $saldo -= $transaksi['jumlah'];
		                    }
							$jumlah_kredit += $transaksi['jumlah'];
		    			}
					echo '<td align="right">'.eliminasi_negatif($saldo).'</td>
					</tr>';
	    		}
	    	}
    		echo '</tbody>
    				<tr>
    					<td align="right" colspan="5" style="background-color:#B1E9F2">Jumlah Total</td>
    					<td align="right" style="background-color:#B1E9F2">'.eliminasi_negatif($jumlah_debet).'</td>
    					<td align="right" style="background-color:#B1E9F2">'.eliminasi_negatif($jumlah_kredit).'</td>
    					<td align="right" style="background-color:#B1E9F2">'.eliminasi_negatif($saldo).'</td>
    				</tr>
    			</table>';
		$item++;
		}
		?>
		<br/>
		<table width="1100px;">
			<tbody>
				<tr>
					<td colspan="4" width="600px;"></td>
					<td colspan="4">
						<?php 
						if ($unit == null or $unit == 9999 or $unit == 52) {
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
	<script type="text/javascript">
		function printPDF() {
		    var printDoc = new jsPDF();
		    printDoc.fromHTML($('#pdf').get(0), 10, 10, {'width': 180});
		    printDoc.autoPrint();
		    printDoc.output("dataurlnewwindow"); // this opens a new popup,  after this the PDF opens the print window view but there are browser inconsistencies with how this is handled
		}

		$('#print_tabel').click(function(){
	        $("#printed_table").print();
	    })

	    $('#download_excel').click(function(){
	        var result = 'data:application/vnd.ms-excel,' + encodeURIComponent($('#printed_table').html()) 
	        this.href = result;
	        this.download = "buku_besar.xls";
	        return true;
	    })
	</script>
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
	// return $ci->Akun_model->get_nama_akun($kode_akun);
	$kode_akun = explode('-',$kode_akun);
	$count_kode = count($kode_akun);
	$kode_akun = $kode_akun[0];
	$level = strlen($kode_akun);
	if (isset($kode_akun)){
		if(strlen($kode_akun)>3){
			if($count_kode > 1){
				// if(substr($kode_akun, 0, 3)=='411'){
				// 	return 'Pemungutan/Penyetoran Pajak';
				// }else{
				// 	$query = $ci->db->query("SELECT nama_akun FROM akuntansi_pajak WHERE kode_akun LIKE '".substr($kode_akun, 0, 3)."%' LIMIT 0,1")->row_array();
				// 	$data = explode(' ',$query['nama_akun']);
				// 	return $data[0].' '.$data[1].' '.$data[2];
				// }
			}else{
				if (substr($kode_akun,0,1) == 5){
					if ($level == 6){
						$selected = 'kode_akun';
					}else{
						$selected = "kode_akun".$level."digit";
					}
					return $ci->db->get_where('akun_belanja',array($selected => $kode_akun))->row_array()['nama_akun'];
				} else if (substr($kode_akun,0,1) == 7){
					$kode_akun[0] = 5;
					if ($level == 6){
						$selected = 'kode_akun';
					}else{
						$selected = "kode_akun".$level."digit";
					}
					$nama = $ci->db->get_where('akun_belanja',array($selected => $kode_akun))->row_array()['nama_akun'];
					$uraian_akun = explode(' ', $nama);
					if(isset($uraian_akun[0])){
			            if($uraian_akun[0]!='beban'){
			              $uraian_akun[0] = 'Beban';
			            }
			        }
		            $hasil_uraian = implode(' ', $uraian_akun);
		            return $hasil_uraian;
				} else if (substr($kode_akun,0,1) == 6 or substr($kode_akun,0,1) == 4){
					$kode_akun[0] = 4;
					$hasil =  $ci->db->get_where("akuntansi_lra_$level",array("akun_$level" => $kode_akun))->row_array()["nama"];
					if ($hasil == null) {
						$hasil = $ci->db->get_where("akuntansi_pajak",array("kode_akun" => $kode_akun))->row_array()["nama_akun"];
					}
					return $hasil;
				}else if (substr($kode_akun,0,1) == 8){
					$hasil =  $ci->db->get_where("akuntansi_pembiayaan_$level",array("akun_$level" => $kode_akun))->row_array()["nama"];
					if ($hasil == null) {
						$hasil = $ci->db->get_where("akuntansi_pajak",array("kode_akun" => $kode_akun))->row_array()["nama_akun"];
					}
					return $hasil;
				} else if (substr($kode_akun,0,1) == 9){
					return $ci->db->get_where("akuntansi_sal_$level", array("akun_$level" => $kode_akun))->row_array()["nama"];
				} else if (substr($kode_akun,0,1) == 2){
					return $ci->db->get_where("akuntansi_hutang_$level", array("akun_$level" => $kode_akun))->row_array()["nama"];
				} else if (substr($kode_akun,0,1) == 3){
					return $ci->db->get_where("akuntansi_aset_bersih_$level", array("akun_$level" => $kode_akun))->row_array()["nama"];
				} else if (substr($kode_akun,0,1) == 1){
					$hasil = $ci->db->get_where("akuntansi_kas_rekening",array("kode_rekening" => $kode_akun))->row_array()["uraian"];
					if ($hasil == null){
						$hasil = $ci->db->get_where("akuntansi_aset_$level",array("akun_$level" => $kode_akun))->row_array()["nama"];
					}
					// if ($hasil == null){
					// 	$hasil = $ci->db->get_where('akun_kas6',array('kd_kas_6' => $kode_akun))->row_array()['nm_kas_6'];
					// }
					return $hasil;
				} else {
					return 'Nama tidak ditemukan';
				}
			}
		}else{
			switch (substr($kode_akun, 0, 1)) {
				case 1:
					$tabelnya = 'akuntansi_aset_3';
					break;
				case 2:
					$tabelnya = 'akuntansi_hutang_3';
					break;
				case 3:
					$tabelnya = 'akuntansi_aset_bersih_3';
					break;
				case 4:
					$tabelnya = 'akuntansi_lra_3';
					break;
				case 5:
					$tabelnya = 'akun_belanja';
					break;
				case 6:
					$kode_akun[0] = 4;
					$tabelnya = 'akuntansi_lra_3';
					break;
				case 7:
					$kode_akun[0] = 5;
					$tabelnya = 'akun_belanja';
					break;
				case 8:
					$tabelnya = 'akuntansi_pembiayaan_3';
					break;
				case 9:
					$tabelnya = 'akuntansi_sal_3';
					break;
				default:
					# code...
					break;
			}

			if(substr($kode_akun, 0, 1)=='5' OR substr($kode_akun, 0, 1)=='7'){
				$atribut = 'kode_akun3digit';
			}else{
				$atribut = 'akun_3';
			}

			$query = $ci->db->query('SELECT * FROM '.$tabelnya.' WHERE '.$atribut.'='.$kode_akun.'')->row_array();
			if($query==null){
				$query = $ci->db->query('SELECT * FROM akuntansi_pajak WHERE kode_akun LIKE "%kode_akun%"')->row_array();
				return $query['nama_akun'];
			}else{
				if(substr($kode_akun, 0, 1)=='5'){
					return $query['nama_akun3digit'];
				}else if(substr($kode_akun, 0, 1)=='7'){
					$uraian_akun = explode(' ', $query['nama_akun3digit']);
					if(isset($uraian_akun[0])){
			            if($uraian_akun[0]!='beban'){
			              $uraian_akun[0] = 'Beban';
			            }
			        }
			        $hasil_uraian = implode(' ', $uraian_akun);
			        return $hasil_uraian;
				}else{
					return $query['nama'];
				}	
			}		
		}
	}
	
}

function get_saldo_awal($kode_akun){
	
	$ci =& get_instance();
	if ($ci->session->userdata('kode_unit') != 42 and $ci->session->userdata('kode_unit') != 9999 and $ci->session->userdata('level') !=3) {
		return null;
	}
	$tahun = $ci->session->userdata('setting_tahun');
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
	if(!is_array($value)){
	    if ($value < 0) 
	        return "(". number_format(abs($value),2,',','.') .")";
	    else
	        return number_format($value,2,',','.');
	}
}

function format_nip($value)
{
    return str_replace("'",'',$value);
}
?>