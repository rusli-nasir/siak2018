<?php 
	
	if ($this->uri->segment(3) == '1') {
		$bulan = "Januari";
	}elseif ($this->uri->segment(3) == '2') {
		$bulan = "Februari";
	}elseif ($this->uri->segment(3) == '3') {
		$bulan = "Maret";
	}elseif ($this->uri->segment(3) == '4') {
		$bulan = "April";
	}elseif ($this->uri->segment(3) == '5') {
		$bulan = "Mei";
	}elseif ($this->uri->segment(3) == '6') {
		$bulan = "Juni";
	}elseif ($this->uri->segment(3) == '7') {
		$bulan = "Juli";
	}elseif ($this->uri->segment(3) == '8') {
		$bulan = "Agustus";
	}elseif ($this->uri->segment(3) == '9') {
		$bulan = "September";
	}elseif ($this->uri->segment(3) == '10') {
		$bulan = "Oktober";
	}elseif ($this->uri->segment(3) == '11') {
		$bulan = "November";
	}elseif ($this->uri->segment(3) == '12') {
		$bulan = "Desember";
	}elseif ($this->uri->segment(3) == '13') {
		$bulan = '';
	}else{
		$bulan = '';
	}
?>
<script>
	$(document).on("change","#bulan",function(){
		if ($("#bulan").val() == '') {
			$("#bulan").focus();
			$("#bulan").css('border','1px solid red');
			$("#err_bulan").html('*Pilih Bulan');
			return false;
		}
			window.location = "<?=site_url("rsa_potongan_lainnya/potongan_lainnya_per_spm/")?>" + $("#bulan").val()  ;

		var e = document.getElementById("bulan");
		var isi = e.options[e.selectedIndex].text;
	});

	$(document).on("click","#dl",function(){

		$( ".tb-isi" ).each(function( index ) {
			$('#tb-hidden').append($(this).html());
		});


		$('#tb-hidden').find('td').css('border','thin solid #000');
		$('.td_bottom_tebel').css('border-bottom','3px solid #000');

		var uri = $("#table-sp2d").excelexportjs({
			containerid: "table-sp2d"
			, datatype: "table"
			, returnUri: true
		});

        // var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");


        // var uri = tablesToExcel(['table_spp','table_f1a','table_spj','table_rekapakun'], ['SPP','F1A','SPJ','REKAP'], 'download_rsa_excel.xls');

        // var uri = tablesToExcel(['table_spp'], ['SPP'], 'download_rsa_excel.xls');

        // (['tbl1','tbl2'], ['ProductDay1','ProductDay2'], 'TestBook.xls', 'Excel')

        var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");
        
        var bulan = '<?php echo $bulan ?>';
        if (bulan != '') {
        	var nama_file = 'download_ptla_<?php echo $bulan ?>.xls';
        }else{
        	var nama_file = 'download_ptla_all.xls';
        }

        saveAs(blob, nama_file);

        // tablesToExcel(['table_spp','table_spp'], ['first','second'], 'myfile.xls');
        // tablesToExcel(['1', '2'], ['first', 'second'], 'myfile.xls');
    });
	function b64toBlob(b64Data, contentType, sliceSize) {
		contentType = contentType || '';
		sliceSize = sliceSize || 512;

		var byteCharacters = atob(b64Data);
		var byteArrays = [];

		for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
			var slice = byteCharacters.slice(offset, offset + sliceSize);

			var byteNumbers = new Array(slice.length);
			for (var i = 0; i < slice.length; i++) {
				byteNumbers[i] = slice.charCodeAt(i);
			}

			var byteArray = new Uint8Array(byteNumbers);

			byteArrays.push(byteArray);
		}

		var blob = new Blob(byteArrays, {type: contentType});
		return blob;
	}
</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->

		<div class="tab-base">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation"><a href="<?php echo site_url('rsa_potongan_lainnya/tambah_potongan_lainnya') ?>"><b><i class="fa fa-plus-circle"></i> Tambah Potongan Lainnya</b></a></li>
				<li role="presentation" class="active"><a href="#" aria-controls="laporan_ptla_per_spm" role="tab" data-toggle="tab"><b><i class="fa fa-list"></i> Daftar Potongan Lainnya</b></a></li>
			</ul>
		</div>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="laporan_ptla_per_spm">
				<div class="row">
					<div class="col-lg-8">
						<h2>Laporan Potongan Lainnya Per SPM <?php if($bulan != '13' AND $bulan != ''){echo 'Bulan '.$bulan;} ?></h2> 
						<br>
						<form id="kentut" class="form-horizontal">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-1">Bulan: </label>
										<div class="col-md-6">
											<select name="bulan" id="bulan" class="validate[required] form-control">
												<option value="">- Pilih Bulan -</option>
												<option value="13" <?php if($this->uri->segment(3)=='13'){echo 'selected';} ?>>[ SEMUA ]</option>
												<option value="1" <?php if($this->uri->segment(3)=='1'){echo 'selected';} ?>>Januari</option>
												<option value="2" <?php if($this->uri->segment(3)=='2'){echo 'selected';} ?>>Februari</option>
												<option value="3" <?php if($this->uri->segment(3)=='3'){echo 'selected';} ?>>Maret</option>
												<option value="4" <?php if($this->uri->segment(3)=='4'){echo 'selected';} ?>>April</option>
												<option value="5" <?php if($this->uri->segment(3)=='5'){echo 'selected';} ?>>Mei</option>
												<option value="6" <?php if($this->uri->segment(3)=='6'){echo 'selected';} ?>>Juni</option>
												<option value="7" <?php if($this->uri->segment(3)=='7'){echo 'selected';} ?>>Juli</option>
												<option value="8" <?php if($this->uri->segment(3)=='8'){echo 'selected';} ?>>Agustus</option>
												<option value="9" <?php if($this->uri->segment(3)=='9'){echo 'selected';} ?>>September</option>
												<option value="10" <?php if($this->uri->segment(3)=='10'){echo 'selected';} ?>>Oktober</option>
												<option value="11" <?php if($this->uri->segment(3)=='11'){echo 'selected';} ?>>November</option>
												<option value="12" <?php if($this->uri->segment(3)=='12'){echo 'selected';} ?>>Desember</option>
											</select>
											<span id="err_bulan" style="color: red;"></span>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-md-1">
											&nbsp;
										</div>
										<!-- <div class="col-md-3">
											<button type="button" class="btn btn-danger btn-sm" id="pilih_tahun"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Apply Filter</button>
										</div> -->
									</div>
								</div>
							</div>
						</form>	
					</div>

					<div class="col-sm-4">
						<button class="btn btn-danger" id="dl" style="height: 150px; margin: 25px auto; width: 40%; display: block;"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> <br>Download<br>(.xls)</button>
					</div>
				</div>
				<hr />

				<div class="row">
					<div class="col-lg-12">
						<table class="table table-striped table-bordered" style="font-size: 11px;">
						<?php if (count($list_ptla) == 0): ?>
							<tr>
								<td style="text-align: center;">
									--tidak ada data--
								</td>
							</tr>
						<?php endif ?>
							<?php foreach ($list_ptla as $key => $value): ?>
								<?php $tmp_array = array(); ?>
									<thead>
										<tr>
											<th class="text-center" style="vertical-align: middle;">NO SPM</th>
											<th class="text-center">JENIS POTONGAN</th>
											<th class="text-center">KETERANGAN</th>
											<th class="text-center">NOMINAL</th>
											<th class="text-center" style="min-width: 120px;">UNIT</th>
										</tr>
									</thead>
									<tbody class="tb-isi">
									<?php foreach ($list_ptla[$key]['data_ptla'] as $key2 => $value2): ?>
										<tr>
										<?php if (!in_array($value2['no_spm'], $tmp_array)): ?>
											<td class="text-center" rowspan="<?php echo count($list_ptla[$key]['data_ptla']); ?>" style="vertical-align: middle;padding: 2px;border-bottom: 0px;text-align: center;"><?php echo $value2['no_spm']; ?></td>
										<?php endif ?>
											<td style="vertical-align: middle;padding: 2px;border-bottom:none;"><b style="text-transform: uppercase;"><?php echo strtoupper( $value2['jenis_potongan']); ?></b></td>
											<td style="vertical-align: middle;padding: 2px;border-bottom:none;"><?php echo $value2['keterangan']; ?></td>
											<td class="text-right" style="vertical-align: middle;padding: 2px;text-align: right;"><?php echo number_format(abs($value2['nominal']),0,',','.'); ?></td>
											<?php if (!in_array($value2['no_spm'], $tmp_array)): ?>
												<td rowspan="<?php echo count($list_ptla[$key]['data_ptla']); ?>" class="text-center" style="border-bottom: 0px;width: 50px;vertical-align: middle;text-align: center;"><?php echo $value2['nama_unit']; ?></td>
												<?php $tmp_array[] = $value2['no_spm']; ?>
											<?php endif ?>
											<?php $tmp_array[] = $value2['no_spm']; ?>
										</tr>
									<?php endforeach ?>
									<tr>
										<td class="text-center" rowspan="2" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;text-align: center;">TOTAL</td>
										<td colspan="2" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;">POTONGAN LAINNYA TELAH DIURAIKAN</td>
										<td class="text-right" style="vertical-align: middle;padding: 2px;border-top: 3px solid #000;text-align: right;"><?php echo number_format($value['total_ptla'],0,',','.'); ?></td>
										<td rowspan="2" class="text-center" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;font-size: 16px;text-align: center;"><b><?php echo $value['persentase']; ?></b></td>
									</tr>
									<tr>
										<td colspan="2" style="vertical-align: middle;padding: 2px;">POTONGAN LAINNYA</td>
										<td class="text-right" style="vertical-align: middle;padding: 2px;text-align: right;"><?php echo number_format($value['potongan_lainnya'],0,',','.'); ?></td>
									</tr>
									<tr style="background-color: #fff;">
										<td colspan="5">&nbsp;</td>
									</tr>
								</tbody>
							<?php endforeach ?>
								
								<!-- <tr>
									<td style="vertical-align: middle;padding: 2px;">KETERANGAN 2</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;">694.500.500,00</td>
									<td class="text-center" style="vertical-align: middle;padding: 2px;">0005/FIS/SP2D-UP/JAN/2018</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;">10-01-2018</td>
									<td class="text-left" style="vertical-align: middle;padding: 2px;">Kas Bank Mandiri Operasional - 1360020170319</td>
								</tr>
								<tr>
									<td style="vertical-align: middle;padding: 2px;border-bottom: 0px;">POTONGAN KETERANGAN 3</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;border-bottom: 2px solid #000;">168.658.737,00</td>
									<td class="text-center" style="vertical-align: middle;padding: 2px;border-bottom: 0px;"></td>
									<td style="border-bottom: 0px;"></td>
								</tr>
								<tr>
									<td class="text-left" rowspan="2" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;">TOTAL</td>
									<td style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;">BRUTO SP2D</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;">7.840.000.000,00</td>
									<td rowspan="2" colspan="3" class="text-center" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;font-size: 16px;"><b>100%</b></td>
								</tr>
								<tr>
									<td style="vertical-align: middle;padding: 2px;">BRUTO SPM CAIR</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;">7.840.000.000,00</td>
								</tr>
								<tr>
									<td colspan="7">&nbsp;</td>
								</tr>
								<tr>
									<td class="text-center" rowspan="3" style="vertical-align: middle;border-bottom: 0px;">NO.SPM/231/321/23/1</td>
									<td style="vertical-align: middle;padding: 2px;">KETERANGAN 1</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;">6.976.841.263,00</td>
									<td class="text-center" style="vertical-align: middle;padding: 2px;">0004/FIS/SP2D-UP/JAN/2018</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;">10-01-2018</td>
									<td class="text-left" style="vertical-align: middle;padding: 2px;">Kas Bank Mandiri Operasional - 1360020170319</td>
									<td rowspan="5" style="border-bottom: 0px;"></td>
								</tr>
								<tr>
									<td style="vertical-align: middle;padding: 2px;">KETERANGAN 2</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;">694.500.500,00</td>
									<td class="text-center" style="vertical-align: middle;padding: 2px;">0005/FIS/SP2D-UP/JAN/2018</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;">10-01-2018</td>
									<td class="text-left" style="vertical-align: middle;padding: 2px;">Kas Bank Mandiri Operasional - 1360020170319</td>
								</tr>
								<tr>
									<td style="vertical-align: middle;padding: 2px;border-bottom: 0px;">POTONGAN KETERANGAN 3</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;border-bottom: 2px solid #000;">168.658.737,00</td>
									<td class="text-center" style="vertical-align: middle;padding: 2px;border-bottom: 0px;"></td>
									<td style="border-bottom: 0px;"></td>
								</tr>
								<tr>
									<td class="text-left" rowspan="2" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;">TOTAL</td>
									<td style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;">BRUTO SP2D</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;">7.840.000.000,00</td>
									<td rowspan="2" colspan="3" class="text-center" style="vertical-align: middle;padding: 2px;border-top: 1px solid #000;font-size: 16px;"><b>100%</b></td>
								</tr>
								<tr>
									<td style="vertical-align: middle;padding: 2px;">BRUTO SPM CAIR</td>
									<td class="text-right" style="vertical-align: middle;padding: 2px;">7.840.000.000,00</td>
								</tr> -->
							
						</table>
					</div>

					<div id="hidden-table" style="display:none">
						<table class="" id="table-sp2d">
							<thead>
								<tr style="" >
									<th class="" style="text-align:center;vertical-align: middle;text-transform: uppercase;" colspan="7">
										<h5><b>
											UNIVERSITAS DIPONEGORO<br/>
											LAPORAN POTONGAN LAINNYA<br/>
											TAHUN ANGGARAN <?=$tahun?><br/>
											<span style="text-transform: uppercase;"><?php if($bulan != ''){echo 'BULAN '.strtoupper($bulan);} ?></span>
											</b>
										</h5>
									</th>
								</tr>
								<tr>
									<th class="text-center" style="vertical-align: middle;text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">NO SPM</th>
									<th class="text-center" style="text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">JENIS POTONGAN</th>
									<th class="text-center" style="text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">KETERANGAN</th>
									<th class="text-center" style="text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;">NOMINAL</th>
									<th class="text-center" style="text-align:center;vertical-align: middle;border:thin solid #000;background-color: #EEE;min-width: 120px;">UNIT</th>
								</tr>
							</thead>
							<tbody id="tb-hidden" >
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
		<!-- end content -->
	</div>
</div>


