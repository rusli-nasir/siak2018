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
		<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-3.1.0/jquery-3.1.0.min.js"></script>
		<!-- <link href="<?php echo base_url();?>/assets/akuntansi/css/bootstrap.min.css" rel="stylesheet"> -->
		<!-- <script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap.min.js"></script> -->
		<script src="<?php echo base_url();?>/assets/akuntansi/js/jquery.print.js"></script>
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

    	td { 
			    padding: 4px;
			}
		thead {
			text-align: center;
		}
		</style>
	</head>
	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<?php if(!isset($excel)){ ?>
			&nbsp;&nbsp;
			<a download="neraca_saldo.xls" id="download_excel" class="no-print"><button  class="btn btn-success" type="button">Download excel</button></a>
				<button class="btn btn-success" type="button" id="print_tabel">Cetak</button>
			<?php echo form_open("akuntansi/laporan/cetak_neraca_saldo/excel",array("class"=>"form-horizontal")); ?>
				<input type="hidden" name="tipe" value="excel">
				<input type="hidden" name="unit" value="<?php echo $this->input->post('unit') ?>">
				<input type="hidden" name="level" value="<?php echo $this->input->post('level') ?>">
				<input type="hidden" name="basis" value="<?php echo $this->input->post('basis') ?>">
				<input type="hidden" name="daterange" value="<?php echo $this->input->post('daterange') ?>">
				<input type="hidden" name="sumber_dana" value="<?php echo $this->input->post('sumber_dana') ?>">
				<input type="hidden" name="akun[]" value="<?php echo $this->input->post('akun')[0] ?>">
				<!-- <input class="btn excel" type="submit" name="Download excel" value="Download Excel"> -->
			</form>
			<?php 
			$arr_sumber = explode('_', $sumber);
			$link_cetak = 'cetak_'.$arr_sumber[1].'_'.$arr_sumber[2];
			?>
			<?php echo form_open("akuntansi/laporan/cetak_neraca_saldo",array("class"=>"form-horizontal", "target"=>"_blank")); ?>
				<input type="hidden" name="tipe" value="pdf">
				<input type="hidden" name="unit" value="<?php echo $this->input->post('unit') ?>">
				<input type="hidden" name="basis" value="<?php echo $this->input->post('basis') ?>">
				<input type="hidden" name="daterange" value="<?php echo $this->input->post('daterange') ?>">
				<input type="hidden" name="sumber_dana" value="<?php echo $this->input->post('sumber_dana') ?>">
				<input type="hidden" name="akun[]" value="<?php echo $this->input->post('akun')[0] ?>">
				<!-- <input class="btn pdf"  type="submit" name="Cetak PDF" value="Cetak PDF"> -->
			</form>
		<?php } ?>
		<div id="printed_table">
		<div align="center" style="font-weight:bold">
			<?php echo $teks_unit; ?><br/>
			NERACA SALDO<br/>
			<?php if ($tingkat != null): ?>
			Berdasarkan <?php echo ucfirst($tingkat) ?><br/>
			<?php endif ?>
			<?php echo $teks_periode; ?><br/><br/>
		</div>
		<?php 
		if($level!=3){
			echo '<table style="font-size:10pt;" class="level_6">
						<tr>
							<td width="150px"><b>Unit Kerja</b></td>
							<td>:'.$teks_unit.'</td>
						</tr>
						<tr>
							<td><b>Tahun Anggaran</b></td>
							<td>:'.$teks_tahun_anggaran.'</td>
						</tr>
				</table>';
			echo '<table style="width:1300px;font-size:10pt;" class="border level_6">
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
			}

			$i = 1;
			$counter = 0;

			$jumlah_debet = 0;
		    $jumlah_kredit = 0;
	        $jumlah_neraca_debet = 0;
	        $jumlah_neraca_kredit = 0;
	        $arr_3 = array();

	        $cur_debet = 0;
       		$cur_kredit = 0;
       		$cur_neraca_debet = 0;
       		$cur_neraca_kredit = 0;

	        $cum_debet = 0;
       		$cum_kredit = 0;
       		$cum_neraca_debet = 0;
       		$cum_neraca_kredit = 0;

       		$cur_header = null;

	       	foreach ($query_tingkat as $data_query) {
	       		$i = 1;
	       		$query = $data_query['data'];
	       		$header_each = $data_query['header'];

	       		$cur_debet = $jumlah_debet - $cum_debet;
	       		$cur_kredit = $jumlah_kredit - $cum_kredit;
	       		$cur_neraca_debet = $jumlah_neraca_debet - $cum_neraca_debet;
	       		$cur_neraca_kredit = $jumlah_neraca_kredit - $cum_neraca_kredit;

	       		$cum_debet += $cur_debet;
	       		$cum_kredit += $cur_kredit;
	       		$cum_neraca_debet += $cur_neraca_debet;
	       		$cum_neraca_kredit += $cur_neraca_kredit;

	       		// echo "$jumlah_debet - $cur_debet <br/>";

	       		if ($cur_header != null){
	       			echo '<tr style="background-color:#B1E9F2">
	       						<td colspan="3"><b>Jumlah '.$cur_header.'</b></td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($cur_debet).'</td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($cur_kredit).'</td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($cur_neraca_debet).'</td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($cur_neraca_kredit).'</td>
			    		  </tr>';
	       		}
	       		echo "<tr style='background-color:#AEFFB8'><td colspan=10>$header_each</td></tr>";

	       		$cur_header = $header_each;
	       		

				foreach ($query as $key => $entry) {			
			    	$debet = 0;
			    	$kredit = 0;
			    	$case_hutang = in_array(substr($key,0,1),array(2,3,4,6));
			    	$saldo = get_saldo_awal($key);
			    	/*if($key==111302){
			    		echo $key.' = '.$saldo;
			    		die();
			    	}*/
		            if ($saldo != null) {
		                $saldo = $saldo['saldo_awal'];
		            }

		            if ($case_hutang) {
		                $kredit = $saldo;
		            } else {
		                $debet = $saldo;
		            }

		            if($level!=3){
						echo '<tr>
								<td>'.$i.'</td>
								<td>'.str_replace('-pajak', '', $key).'</td>
								<td>';
								if(strlen((string)$key)==6){
									echo get_nama_akun_v((string)$key);
								}else{
									echo strtoupper(get_nama_akun_v((string)$key));
								}
								echo '</td>';
					}	

							$arr_3[$counter]['kode_akun'] = $key;
							$arr_3[$counter]['uraian'] = get_nama_akun_v((string)$key);

					
						foreach ($entry as $transaksi) {
			    			if ($transaksi['tipe'] == 'debet'){
			    				$debet += $transaksi['jumlah'];
			    				if ($case_hutang and $transaksi['jumlah'] > 0) {
			                        $saldo -= $transaksi['jumlah'];
			                    } else {
			                        $saldo += $transaksi['jumlah'];
			                    }
			                    // echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($debet).'</td>';
			    			} else if ($transaksi['tipe'] == 'kredit'){
								$kredit += $transaksi['jumlah'];
								if ($case_hutang and $transaksi['jumlah'] > 0) {
			                        $saldo += $transaksi['jumlah'];
			                    } else {
			                        $saldo -= $transaksi['jumlah'];
			                    }
			                    // echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($kredit).'</td>';
			    			}
			    		}



			    		/*if(substr(get_nama_akun_v((string)$key),0,2)=='PPh' or substr(get_nama_akun_v((string)$key),0,2)=='PPN'){
			    			$string_num = (string)($debet);
			    			$debet = substr($string_num, 0, -1);
			    		}*/

			    		if ($debet < 0 or $kredit < 0){
			    			$jumlah_debet += abs($kredit);
			    			$jumlah_kredit += abs($debet);
			    			if($level!=3){
								echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($kredit).'</td>
								<td align="right" style="font-size:8pt">'.eliminasi_negatif($debet).'</td>';
							}	
							$arr_3[$counter]['mutasi_debit'] = abs($kredit);    			
							$arr_3[$counter]['mutasi_kredit'] = abs($debet);    			
			    		} else {
			    			$jumlah_debet += abs($debet);
			    			$jumlah_kredit += abs($kredit);
			    			if($level!=3){
				    			echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($debet).'</td>
								<td align="right" style="font-size:8pt">'.eliminasi_negatif($kredit).'</td>';
							}
							$arr_3[$counter]['mutasi_debit'] = abs($debet);    			
							$arr_3[$counter]['mutasi_kredit'] = abs($kredit); 
			    		}


			    		if ($case_hutang) {
			                $saldo_neraca = $kredit - $debet;
			            } else {
			                $saldo_neraca = $debet - $kredit;
			            }

					
						if ($kredit > $debet) {
							$saldo_neraca = abs($saldo_neraca);
			                $jumlah_neraca_kredit += $saldo_neraca;
			    //             echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($kredit).'</td>
							// <td align="right" style="font-size:8pt">'.eliminasi_negatif($debet).'</td>';
							if($level!=3){
				                echo '<td align="right" style="font-size:8pt">0.00</td>';
				                echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($saldo_neraca).'</td>';
				            }
			                $arr_3[$counter]['neraca_debit'] = 0;    			
							$arr_3[$counter]['neraca_kredit'] = abs($saldo_neraca); 
			            } elseif ($kredit < $debet) {
			                $saldo_neraca = abs($saldo_neraca);
			                $jumlah_neraca_debet += $saldo_neraca;
			    //             echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($debet).'</td>
							// <td align="right" style="font-size:8pt">'.eliminasi_negatif($kredit).'</td>';
							if($level!=3){
				                echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($saldo_neraca).'</td>';
				                echo '<td align="right" style="font-size:8pt">0.00</td>';
				            }
			                $arr_3[$counter]['neraca_debit'] = abs($saldo_neraca);    			
							$arr_3[$counter]['neraca_kredit'] = 0;
			            }else{
			            	if($level!=3){
				            	echo '<td align="right" style="font-size:8pt">0.00</td>';
				            	echo '<td align="right" style="font-size:8pt">0.00</td>';
				            }
			            	$arr_3[$counter]['neraca_debit'] = 0;    			
							$arr_3[$counter]['neraca_kredit'] = 0; 
			            }

			        if($level!=3){
						echo '</tr>';
					}

					$i++;
					$counter++;
				}
	       	}
	       	$cur_debet = $jumlah_debet - $cum_debet;
       		$cur_kredit = $jumlah_kredit - $cum_kredit;
       		$cur_neraca_debet = $jumlah_neraca_debet - $cum_neraca_debet;
       		$cur_neraca_kredit = $jumlah_neraca_kredit - $cum_neraca_kredit;
	       	echo '<tr style="background-color:#B1E9F2">
	       						<td colspan="3"><b>Jumlah '.$cur_header.'</b></td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($cur_debet).'</td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($cur_kredit).'</td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($cur_neraca_debet).'</td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($cur_neraca_kredit).'</td>
			    		  </tr>';
			if($level!=3){
	    		echo '</tbody>
		    			<tfoot>
						 	<tr style="background-color:#B1E9F2;">
			    				<td align="right" colspan="3" style="background-color:#B1E9F2"><b>Jumlah Total</b></td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($jumlah_debet).'</td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($jumlah_kredit).'</td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($jumlah_neraca_debet).'</td>
			    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($jumlah_neraca_kredit).'</td>
			    			</tr>
		    			</tfoot>
					</table>';
			}

				//Men-3-digitkan hasil neraca saldo
				$result = array();
				foreach ($arr_3 as $data) {
				  $kode_akun = substr($data['kode_akun'],0,3);
				  $cek_di_pajak = check_di_pajak($data['kode_akun']);
				  if($cek_di_pajak>0){
				  	$result[$kode_akun.'-pajak'][] = $data;
				  }else{
				  	$result[$kode_akun][] = $data;
				  }
				}

				//print_r($result);
				$display_3_digit = array();

				foreach ($result as $key => $value) {
					$display_3_digit[$key]['kode_akun'] = $key;
					$display_3_digit[$key]['mutasi_debit'] = 0;
					$display_3_digit[$key]['mutasi_kredit'] = 0;
					$display_3_digit[$key]['neraca_debit'] = 0;
					$display_3_digit[$key]['neraca_kredit'] = 0;
					foreach($value as $inner_key => $inner_data){
						$display_3_digit[$key]['mutasi_debit'] += $inner_data['mutasi_debit'];
						$display_3_digit[$key]['mutasi_kredit'] += $inner_data['mutasi_kredit'];
						$display_3_digit[$key]['neraca_debit'] += $inner_data['neraca_debit'];
						$display_3_digit[$key]['neraca_kredit'] += $inner_data['neraca_kredit'];
					}
				}

			if($level==3){
				echo '<table style="font-size:10pt;" class="level_3">
						<tr>
							<td width="150px"><b>Unit Kerja</b></td>
							<td>:'.$teks_unit.'</td>
						</tr>
						<tr>
							<td><b>Tahun Anggaran</b></td>
							<td>:'.$teks_tahun_anggaran.'</td>
						</tr>
				</table>';
				echo '<table style="width:1300px;font-size:10pt;" class="border level_3">
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
					$nomor = 1;
					$jumlah_debet = 0;
				    $jumlah_kredit = 0;
			        $jumlah_neraca_debet = 0;
			        $jumlah_neraca_kredit = 0;
				foreach ($display_3_digit as $key => $value) {
					echo '<tr>';
					echo '<td>'.$nomor.'</td>';
					echo '<td>'.str_replace('-pajak', '', $value['kode_akun']).'</td>';
					echo '<td>';
					echo get_nama_akun_v((string)$value['kode_akun']);
					echo '</td>';
					echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($value['mutasi_debit']).'</td>';
					echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($value['mutasi_kredit']).'</td>';
					echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($value['neraca_debit']).'</td>';
					echo '<td align="right" style="font-size:8pt">'.eliminasi_negatif($value['neraca_kredit']).'</td>';
					echo '</tr>';
					$jumlah_debet += $value['mutasi_debit'];
				    $jumlah_kredit += $value['mutasi_kredit'];
			        $jumlah_neraca_debet += $value['neraca_debit'];
			        $jumlah_neraca_kredit += $value['neraca_kredit'];
					$nomor++;
				}
				echo '</tbody>
	    			<tfoot>
					 	<tr style="background-color:#B1E9F2;">
		    				<td align="right" colspan="3" style="background-color:#B1E9F2"><b>Jumlah Total</b></td>
		    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($jumlah_debet).'</td>
		    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($jumlah_kredit).'</td>
		    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($jumlah_neraca_debet).'</td>
		    				<td align="right" style="font-size:8pt">'.eliminasi_negatif($jumlah_neraca_kredit).'</td>
		    			</tr>
	    			</tfoot>
				</table>'; 
			}
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
	</div>
	</body>
		<script type="text/javascript">
		$(function(){
		    $('#download_excel').click(function(){
		        var result = 'data:application/vnd.ms-excel,' + encodeURIComponent($('#printed_table').html()) 
		        this.href = result;
		        this.download = "neraca_saldo.xls";
		        return true;
		    })
		    $('#print_tabel').click(function(){
		        $("#printed_table").print();
		    })
		})

	</script>
</html>
<?php
function check_di_pajak($kode_akun)
{
	$ci =& get_instance();
    $hasil = $ci->db->where('kode_akun',$kode_akun)->get('akuntansi_pajak')->num_rows();
    return $hasil;
}

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
	$kode_akun = explode('-',$kode_akun);
	$count_kode = count($kode_akun);
	$kode_akun = $kode_akun[0];
	$level = strlen($kode_akun);
	if (isset($kode_akun)){
		if(strlen($kode_akun)>3){
			if($count_kode > 1){
				if(substr($kode_akun, 0, 3)=='411'){
					return 'Pemungutan/Penyetoran Pajak';
				}else{
					$query = $ci->db->query("SELECT nama_akun FROM akuntansi_pajak WHERE kode_akun LIKE '".substr($kode_akun, 0, 3)."%' LIMIT 0,1")->row_array();
					$data = explode(' ',$query['nama_akun']);
					return $data[0].' '.$data[1].' '.$data[2];
				}
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
	if (1) {
	// if ($ci->session->userdata('kode_unit') != 42 and $ci->session->userdata('kode_unit') != 9999 and $ci->session->userdata('level') !=3) {
		return null;
	}
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
    	return number_format(abs($value),2,',','.');
        // return "(". number_format(abs($value),2,',','.') .")";
    else
        return number_format($value,2,',','.');
}

function format_nip($value)
{
    return str_replace("'",'',$value);
}
?>