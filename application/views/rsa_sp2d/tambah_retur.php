<script type="text/javascript">
	$(document).ready(function(){

		var row_focus = localStorage.getItem("row_focus");
		if (row_focus!=null) {
			$('html, body').animate({scrollTop: $(row_focus).offset().top}, 2000);
		}

		$(document).on("keyup","input.xnumber",function(event){
			// skip for arrow keys
			if(event.which >= 37 && event.which <= 40) return;
			// format number
			$(this).val(function(index, value) {
				return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
				;
			});
		});

		$(document).on("click",".btn-riwayat",function(){
			var no_spm = $(this).attr('data-no-spm');

			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_sp2d/riwayat_sp2d_modal")?>",
				data:'no_spm='+no_spm,
				success:function(data){
					$('#riwayat_sp2d_modal_content').html(data);
					$('#riwayat_sp2d_modal').modal('show');
				}
			});

		});


		$(document).on("change","#no_retur_sblm",function(event){
			if ($("#no_retur_sblm").is(':checked')) {
				$("#new_no_retur").val($("#no_retur_sblm_tmp").val());
			}else{
				$("#new_no_retur").val($("#new_no_retur_tmp").val());
			}
		});

		$(document).on("change","#bank",function(event){
			if ($("#bank").val() == '0') {
				$("#bank_2").show();
				$("#bank_2").focus();
			}else{
				$("#bank_2").hide();
			}
		});

		$(document).on("click",".btn-retur",function(){
			var id_trx_urut_spm_cair = $(this).attr('data-id_trx_urut_spm_cair');
			var no_spm = $(this).attr('data-no-spm');
			var kode_unit_subunit = $(this).attr('data-kd-unit');
			var jenis = $(this).attr('data-jenis');
			var nominal_cair = $(this).attr('data-nominal-cair');
			var potongan_lainnya = $(this).attr('data-potongan-lainnya');

			$('#id_trx_urut_spm_cair').val($(this).attr('data-id_trx_urut_spm_cair'));

			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_sp2d/retur_modal")?>",
				data:'no_spm='+no_spm+'&kode_unit_subunit='+kode_unit_subunit+'&jenis='+jenis+'&nominal_cair='+nominal_cair+'&id_trx_urut_spm_cair='+id_trx_urut_spm_cair+'&potongan_lainnya='+potongan_lainnya,
				success:function(data){
					$('#modal_content').html(data);
					// $('#tgl_retur').val(date_now());
					$('#add_retur_modal').modal('show');
				}
			});
		});

		$("#add_retur_modal").on("hidden.bs.modal",function(){
			$('#kode_unit_subunit').val('');
			$('#jenis').val('');
			$('#no_spm').val('');
			$('#tgl_retur').val('');
			$('#nominal').val('');
			$('#potongan_lainnya').val('');
			$('#keterangan').val('');
			$('#nominal_telah_sp2d').html('');
			$('#nominal_cair').html('');
			$('#bank').val('');
			$('#bank').html('');
			$('#error_nominal').hide();
			$('#nominal').css('border','1px solid #ccc');
			$('#id_trx_urut_spm_cair').val('');
		});

		$("#riwayat_sp2d_modal").on("hidden.bs.modal",function(){
			$('#riwayat_sp2d_modal_content').html('');
		});

		$(document).on("submit","#form_retur",function(e){
			// alert(string_to_angka($('#nominal').val()));
			var data=$("#form_retur").serialize();
			var id_trx_urut_spm_cair = $('#id_trx_urut_spm_cair').val();
			var kode_unit_subunit = $('#kode_unit_subunit').val();
			var jenis = $('#jenis').val();
			var no_spm = $('#no_spm').val();
			var no_retur = $('#new_no_retur').val();
			var no_retur_encoded = $('#no_retur_encoded').val();
			var tgl_retur = $('#tgl_retur').val();
			var nominal = string_to_angka($('#nominal').val());
			var keterangan = $('#keterangan').val();
			var nominal_sp2d = $('#nominal_sp2d').val();
			var nominal_telah_sp2d = parseInt(string_to_angka($('#nominal_telah_sp2d').html()));
			var potongan_lainnya = $('#potongan_lainnya').val();
			console.log(potongan_lainnya);

			if ($("#bank").val() == '0') {
				var bank = $( "#bank_2" ).val();
				var kd_akun_kas = '';
			}else{
				var bank = $( "#bank option:selected" ).text();
				var kd_akun_kas = $('#bank').val();
			}
			
			if (nominal <= nominal_telah_sp2d) {
				if (nominal > 0) {
					if($("#form_retur").validationEngine("validate")){
						$.ajax({
							type:"POST",
							url:"<?=site_url("rsa_sp2d/add_retur")?>",
							data:'no_spm='+no_spm+'&kode_unit_subunit='+kode_unit_subunit+'&nominal='+nominal+'&keterangan='+keterangan+'&jenis='+jenis+'&nominal_sp2d='+nominal_sp2d+'&no_retur='+no_retur+'&tgl_retur='+tgl_retur+'&bank='+bank+'&kd_akun_kas='+kd_akun_kas,
							success:function(respon){
								var text_respon = JSON.parse(respon);
								var nominal_telah_sp2d_new = nominal_telah_sp2d - nominal;

								if (text_respon=="sukses"){
									alert(text_respon);
									if (nominal_telah_sp2d_new == 0) {
										$('#btn_retur_'+id_trx_urut_spm_cair).html('<button class="btn btn-danger btn-sm" disabled>Retur</button>');
									}

									var new_persentase =  nominal_telah_sp2d_new / (parseInt(string_to_angka($('#nominal_cair').html())) - potongan_lainnya) * 100;
									var background = '#93d2e4';
									if (new_persentase == 100) {
										background = '#bdecb1';
									}

									var progressbar = '<div class="progress" style="margin-bottom: 0px;position:relative;">'+
																'<div class="progress-bar" role="progressbar" aria-valuenow="'+new_persentase+'" aria-valuemin="0" aria-valuemax="100" style="width:'+new_persentase+'%;font-size: 12px;background-color: '+background+';">'+
																	'<span style="position:absolute;left:0;width:100%;text-align:center;z-index:2;color:#696969;">'+
																		'<b style="color: #000;">'+new_persentase.toFixed(2)+'%</b>'+
																		'( Rp <b>'+angka_to_string(nominal_telah_sp2d_new)+'</b>'+
																		'dari <b>'+angka_to_string($('#nominal_cair').html())+'</b> )'+
																	'</span>'+
																'</div>'+
															'</div>';

									$('#progress_bar_'+id_trx_urut_spm_cair).html(progressbar);
									$('#add_retur_modal').modal('hide');

									$.ajax({
										type:"POST",
										url:"<?=site_url("rsa_sp2d/cetak_sp2d_retur/")?>"+no_retur_encoded,
										data:'',
										success:function(respon){
											if (respon != ""){
												$('#div_cetak').html(respon);
												$('#div_cetak').show();
												var mode = 'iframe';
												var close = mode == "popup";
												var options = { mode : mode, popClose : close};
												$("#div_cetak").printArea( options );
												$('#div_cetak').html('');
												$('#div_cetak').hide();
											}
										}
									});
								} else {
									alert(text_respon);
									if (nominal_telah_sp2d_new == 0) {
										$('#btn_retur_'+id_trx_urut_spm_cair).html('<button class="btn btn-danger btn-sm" disabled>Retur</button>');
									}
									$('#add_retur_modal').modal('hide');
								}
							}
						});
					}
				}else{
					$('#error_nominal_text').html('Nominal tidak boleh 0 !');
					$('#error_nominal').show();
					$('#nominal').css('border','1px solid #bd0808');
					$('#nominal').focus();
				}
			}else{
				$('#error_nominal_text').html('Tidak dapat melebihi Rp. '+ $('#nominal_telah_sp2d').html() +' !');
				$('#error_nominal').show();
				$('#nominal').css('border','1px solid #bd0808');
				$('#nominal').focus();
			}

		});

		$(document).on("click","#download_riwayat",function(){

			$('#tb-hidden').find('td').css('border','thin solid #000');
			$('.td_bottom_tebel').css('border-bottom','3px solid #000');

			var uri = $("#table-sp2d").excelexportjs({
				containerid: "table-sp2d"
				, datatype: "table"
				, returnUri: true
			});


			var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");

			var no_spm = $(this).attr('data-no-spm');

			var nama_file = 'download_sp2d_'+no_spm+'.xls';


			saveAs(blob, nama_file);

        // tablesToExcel(['table_spp','table_spp'], ['first','second'], 'myfile.xls');
        // tablesToExcel(['1', '2'], ['first', 'second'], 'myfile.xls');
     	});
	});

	function date_now(){
		var currentdate = new Date();
		var twoDigitMonth = currentdate.getMonth()+"";if(twoDigitMonth.length==1)	twoDigitMonth="0" +twoDigitMonth;
		var twoDigitDate = currentdate.getDate()+"";if(twoDigitDate.length==1)	twoDigitDate="0" +twoDigitDate;

		var twoDigitHour = currentdate.getHours()+"";if(twoDigitHour.length==1)	twoDigitHour="0" +twoDigitHour;
		var twoDigitMinute = currentdate.getMinutes()+"";if(twoDigitMinute.length==1)	twoDigitMinute="0" +twoDigitMinute;
		var twoDigitSecond = currentdate.getSeconds()+"";if(twoDigitSecond.length==1)	twoDigitSecond="0" +twoDigitSecond;
		var datetime = currentdate.getFullYear()+'/'+twoDigitMonth+'/'+twoDigitDate+' '+twoDigitHour+':'+twoDigitMinute+':'+twoDigitSecond;

		return datetime;
	}

	function string_to_angka(str){
		return parseInt(str.split('.').join(""));
	}

	function angka_to_string(num){
		var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		return str_hasil;
	}

	
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
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/tambah_sp2d') ?>" ><b><i class="fa fa-plus-circle"></i> Tambah SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d') ?>"><b><i class="fa fa-list"></i> Daftar SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d_100') ?>"><b><i class="fa fa-list"></i> Daftar SP2D 100%</b></a></li>
				<li role="presentation" class="active"><a href="#tambah_retur"  aria-controls="daftar_retur"  role="tab" data-toggle="tab"><b><i class="fa fa-plus-circle"></i> Tambah RETUR</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_retur') ?>"><b><i class="fa fa-list"></i> Daftar RETUR</b></a></li>
				<!-- <li role="presentation"><a href="<?php echo site_url('rsa_sp2d/history_sp2d') ?>" ><b>Riwayat SP2D</b></a></li> -->
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/sp2d_per_spm') ?>"><b><i class="fa fa-file-text-o"></i> Laporan SP2D per SPM</b></a></li>
			</ul>
		</div>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="retur">

				<div class="row">
					<div class="col-lg-12">
						<h2>RETUR SP2D</h2> 
					</div>
				</div>
				<hr />

				<div class="row">
					<div class="col-md-12 table-responsive">
						<table class="table table-bordered table-striped table-hover small">
							<thead>
								<tr>
									<th class="text-center">No</th>
			                  <th class="text-center col-md-3">Nomor SPM</th>
			                  <th class="text-center">Jenis</th>
									<th class="text-center col-md-5">Status SP2D</th>
									<th class="text-center col-md-2">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($daftar_spm as $spm): ?>
									<tr>
										<td class="text-center" style="vertical-align: middle;"><?php echo $i ?></td>
										<td class="text-center" style="vertical-align: middle;"><a href="javascript:void(0)" data-no-spm="<?php echo $spm->str_nomor_trx_spm ?>" class="btn-riwayat"><b><?php echo $spm->str_nomor_trx_spm ?></b></a></td>
										<td class="text-center" style="vertical-align: middle;"><?php echo $spm->jenis_trx ?></td>
										<?php 
											$nominal_cair = $spm->nominal;
											$nominal_sudah_sp2d = $spm->nominal_sudah_sp2d;

											$persentase = round(($nominal_sudah_sp2d / ($nominal_cair - $spm->potongan_lainnya)) * 100,2);
										?>
										<td style="vertical-align: middle;" id="progress_bar_<?php echo $spm->id_trx_urut_spm_cair ?>">
											<div class="progress" style="margin-bottom: 0px;position:relative;">
												<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $persentase ?>"
												aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $persentase ?>%;font-size: 12px;background-color: <?php if($persentase == 100){echo '#bdecb1';}else{echo '#93d2e4';} ?>;">
												<span style="position:absolute;left:0;width:100%;text-align:center;z-index:2;color:#696969;"><b style="color: #000;"><?php echo $persentase.'%</b> ( Rp <b>'. number_format($nominal_sudah_sp2d,0,',','.') .'</b> dari <b>'. number_format($spm->nominal,0,',','.') .'</b> '; if($spm->potongan_lainnya > 0){echo '<span style="color:#c50202;">dengan potongan '.number_format($spm->potongan_lainnya,0,',','.').'</span> )';}else{ echo ')';}; ?></span>
												</div>
											</div>
										</td>
										<td style="vertical-align: middle;text-align: center;" id="btn_retur_<?php echo $spm->id_trx_urut_spm_cair ?>">
											<div class="btn-group" role="group">
											<?php if ($spm->nominal_sudah_sp2d == 0): ?>
												<button class="btn btn-warning	btn-sm" disabled><i class="glyphicon glyphicon-plus-sign"></i> RETUR</button>
											<?php else: ?>
												<button class="btn btn-warning btn-sm btn-retur" data-nominal-cair="<?php echo $spm->nominal; ?>" data-jenis="<?php echo $spm->jenis_trx; ?>" data-kd-unit="<?php echo $spm->kode_unit_subunit; ?>" data-no-spm="<?php echo $spm->str_nomor_trx_spm; ?>" data-id_trx_urut_spm_cair="<?php echo $spm->id_trx_urut_spm_cair; ?>" data-potongan-lainnya="<?php echo $spm->potongan_lainnya; ?>"><i class="glyphicon glyphicon-plus-sign"></i> RETUR</button>
											<?php endif ?>
												<button class="btn btn-sm btn-default btn-riwayat" data-no-spm="<?php echo $spm->str_nomor_trx_spm; ?>"><i class="fa fa-search"></i></button>
											</div>
										</td>
									</tr>
								<?php $i++; endforeach ?>
		               </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- end content -->
	</div>
</div>

<div class="modal fade" id="add_retur_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding: 20px;">
	<div class="modal-dialog modal-lg"  style="width: 95%;padding: 0px;margin: 0px auto;">
		<div class="modal-content" id="modal_content" style="height: 100%;border-radius: 0;">

		</div>
	</div>
</div>

<div class="modal fade" id="riwayat_sp2d_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding: 20px;">
	<div class="modal-dialog modal-lg" style="width: 95%;padding: 0px;margin: 0px auto;">
		<div class="modal-content" id="riwayat_sp2d_modal_content" style="height: 100%;border-radius: 0;">

		</div>
	</div>
</div>

<div id="div_cetak" style="display: none;"></div>