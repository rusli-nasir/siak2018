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

			$('#id_trx_urut_spm_cair').val($(this).attr('data-id_trx_urut_spm_cair'));

			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_sp2d/retur_modal")?>",
				data:'no_spm='+no_spm+'&kode_unit_subunit='+kode_unit_subunit+'&jenis='+jenis+'&nominal_cair='+nominal_cair+'&id_trx_urut_spm_cair='+id_trx_urut_spm_cair,
				success:function(data){
					$('#modal_content').html(data);
					// $('#tgl_retur').val(date_now());
					$('#add_retur_modal').modal('show');
				}
			});
		});

		$(document).on("click",".edit_sp2d",function(){
			var id = $(this).attr('rel');
			var no_spm = $(this).attr('data-no-spm');
			var nominal_cair = $(this).attr('data-nominal-cair');
			var jenis = $(this).attr('data-jenis');

			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_sp2d/get_edit_sp2d_modal")?>",
				data:'id='+id+'&no_spm='+no_spm+'&nominal_cair='+nominal_cair+'&jenis='+jenis,
				success:function(data){
					$('#modal_content_edit_sp2d').html(data);
					$('#edit_sp2d_modal').modal('show');
				}
			});
		});

		$(document).on("submit","#form_edit_sp2d",function(e){
			var id = $('#id').val();
			var no_sp2d = $('#no_sp2d').val();
			var tgl_sp2d = $('#tgl_sp2d').val();
			var keterangan = $('#keterangan').val();

			if ($("#bank").val() == '0') {
				var bank = $( "#bank_2" ).val();
				var kd_akun_kas = '';
			}else{
				var bank = $( "#bank option:selected" ).text();
				var kd_akun_kas = $('#bank').val();
			}
			
			if($("#form_edit_sp2d").validationEngine("validate")){
				$.ajax({
					type:"POST",
					url:"<?=site_url("rsa_sp2d/update_sp2d")?>",
					data:'no_sp2d='+no_sp2d+'&tgl_sp2d='+tgl_sp2d+'&bank='+bank+'&kd_akun_kas='+kd_akun_kas+'&keterangan='+keterangan+'&id='+id,
					success:function(respon){
						// $('#add_sp2d_modal').modal('hide');
						if (respon=="sukses"){
							$('#edit_sp2d_modal').modal('hide');
							alert(respon);

							localStorage.setItem("row_focus", "#sp2d_row_"+id);
							location.reload();
						} else {
							$('#edit_sp2d_modal').modal('hide');
							alert(respon);
						}
					}
				});
			}
		});

		$("#add_retur_modal").on("hidden.bs.modal",function(){
			$('#kode_unit_subunit').val('');
			$('#jenis').val('');
			$('#no_spm').val('');
			$('#tgl_retur').val('');
			$('#nominal').val('');
			$('#keterangan').val('');
			$('#nominal_telah_sp2d').html('');
			$('#nominal_cair').html('');
			$('#bank').val('');
			$('#bank').html('');
			$('#error_nominal').hide();
			$('#nominal').css('border','1px solid #ccc');
			$('#id_trx_urut_spm_cair').val('');
		});

		$(document).on("submit","#form_retur",function(e){
			// alert(string_to_angka($('#nominal').val()));
			var data=$("#form_retur").serialize();
			var id_trx_urut_spm_cair = $('#id_trx_urut_spm_cair').val();
			var kode_unit_subunit = $('#kode_unit_subunit').val();
			var jenis = $('#jenis').val();
			var no_spm = $('#no_spm').val();
			var no_retur = $('#new_no_retur').val();
			var tgl_retur = $('#tgl_retur').val();
			var nominal = string_to_angka($('#nominal').val());
			var keterangan = $('#keterangan').val();
			var nominal_sp2d = $('#nominal_sp2d').val();
			var nominal_telah_sp2d = parseInt(string_to_angka($('#nominal_telah_sp2d').html()));

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

								var nominal_telah_sp2d_new = nominal_telah_sp2d - nominal;

								if (respon=="sukses"){
									alert(respon);
									if (nominal_telah_sp2d_new == 0) {
										$('#btn_retur_'+id_trx_urut_spm_cair).html('<button class="btn btn-danger btn-sm" disabled>Retur</button>');
									}

									var new_persentase =  nominal_telah_sp2d_new / string_to_angka($('#nominal_cair').html()) * 100;
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
								} else {
									alert(respon);
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

		$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
			var id = $(e.target).attr("href").substr(1);
			window.location.hash = id;
		});

		$("ul.nav-tabs > li > a").on("click", function(e) {
			location.reload();
		});

		var hash = window.location.hash;
		$('.nav-tabs a[href="' + hash + '"]').tab('show');
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
</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->

		<div class="tab-base">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/tambah_sp2d') ?>" ><b>Tambah SP2D</b></a></li>
				<li role="presentation" class="active"><a href="#daftar_sp2d" aria-controls="daftar_sp2d" role="tab" data-toggle="tab"><b>Daftar SP2D</b></a></li>
				<li role="presentation"><a href="#retur" aria-controls="retur" role="tab" data-toggle="tab"><b>Retur</b></a></li>
				<li role="presentation"><a href="#daftar_retur" aria-controls="daftar_retur"  role="tab" data-toggle="tab"><b>Daftar RETUR</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/history_sp2d') ?>" ><b>Riwayat SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/sp2d_per_spm') ?>"><b>Laporan SP2D per SPM</b></a></li>
			</ul>
		</div>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="daftar_sp2d">

				<div class="row">
					<div class="col-lg-12">
						<h2>DAFTAR SP2D</h2> 
					</div>
				</div>

				<hr />

				<div class="row">
					<div class="col-md-12 table-responsive">
						<table class="table table-bordered table-striped table-hover small">
							<thead>
								<tr>
									<th class="text-center">No</th>
			                  <th class="text-center" style="width: 190px;">Nomor SP2D</th>
			                  <th class="text-center" style="width: 190px;">Nomor SPM</th>
			                  <th class="text-center" style="width: 100px;">Tanggal SP2D</th>
									<th class="text-center">Bank</th>
									<th class="text-center">Nominal SP2D</th>
									<th class="text-center">Jenis</th>
									<th class="text-center">Keterangan</th>
									<th class="text-center">Unit</th>
									<th class="text-center">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list_sp2d)): ?>
									<?php $i=1; foreach ($list_sp2d as $item): ?>
										<tr id="sp2d_row_<?php echo $item->id_trx_urut_spm_sp2d ?>">
											<td class="text-center"><?php echo $i ?></td>
											<td class="text-center"><?php echo $item->str_nomor_trx_sp2d ?></td>
											<td class="text-center"><a href="<?php echo site_url().'/rsa_sp2d/history_sp2d/'.urlencode(base64_encode($item->str_nomor_trx_spm)); ?>"><?php echo $item->str_nomor_trx_spm ?></a></td>
											<td class="text-center"><?php echo $item->tgl_sp2d ?></td>
											<td class="text-left"><?php echo $item->bank ?></td>
											<td class="text-right"><b>Rp.&nbsp;<?php echo number_format($item->nominal_sp2d,0,',','.') ?></b></td>
											</td>
											<td class="text-left"><?php echo $item->jenis_sp2d ?></td>
											<td><?php echo $item->keterangan ?></td>
											<?php if ($item->nama_subunit == ''): ?>
												<td><?php echo $item->nama_unit?></td>
											<?php else: ?>
												<td><?php echo $item->nama_unit?> (<?php echo $item->nama_subunit?>)</td>
											<?php endif ?>
											<td><button type="button" class="btn btn-xs btn-primary edit_sp2d" rel="<?php echo $item->id_trx_urut_spm_sp2d ?>" data-no-spm="<?php echo $item->str_nomor_trx_spm ?>" data-nominal-cair="<?php echo $item->nominal_spm_cair ?>" data-jenis="<?php echo $item->jenis_trx ?>"><i class="fa fa-pencil"></i> Edit</button></td>
										</tr>
									<?php $i++; endforeach ?>
								<?php else: ?>
									<tr>
										<td colspan="7" class="text-center">- Tidak Ada Data -</td>
									</tr>
								<?php endif ?>
		               </tbody>
						</table>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="retur">

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
									<th class="text-center col-md-1">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($daftar_spm as $spm): ?>
									<tr>
										<td class="text-center" style="vertical-align: middle;"><?php echo $i ?></td>
										<td class="text-center" style="vertical-align: middle;"><b><?php echo $spm->str_nomor_trx_spm ?></b></td>
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
										<?php if ($spm->nominal_sudah_sp2d == 0): ?>
											<td style="vertical-align: middle;text-align: center;" id="btn_retur_<?php echo $spm->id_trx_urut_spm_cair ?>">
												<button class="btn btn-danger	btn-sm" disabled>Retur</button>
											</td>
										<?php else: ?>
											<td style="vertical-align: middle;text-align: center;" id="btn_retur_<?php echo $spm->id_trx_urut_spm_cair ?>">
												<button class="btn btn-danger btn-sm btn-retur" data-nominal-cair="<?php echo $spm->nominal; ?>" data-jenis="<?php echo $spm->jenis_trx; ?>" data-kd-unit="<?php echo $spm->kode_unit_subunit; ?>" data-no-spm="<?php echo $spm->str_nomor_trx_spm; ?>" data-id_trx_urut_spm_cair="<?php echo $spm->id_trx_urut_spm_cair; ?>">Retur</button>
											</td>
										<?php endif ?>
									</tr>
								<?php $i++; endforeach ?>
		               </tbody>
						</table>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="daftar_retur">
				
				<div class="row">
					<div class="col-lg-12">
						<h2>DAFTAR RETUR</h2> 
					</div>
				</div>
				<hr />

				<div class="row">
					<div class="col-md-12 table-responsive">
						<table class="table table-bordered table-striped table-hover small">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center" style="width: 190px;">Nomor RETUR</th>
									<th class="text-center" style="width: 190px;">Nomor SPM</th>
									<th class="text-center" style="width: 100px;">Tanggal RETUR</th>
									<th class="text-center" style="width: 100px;">Jenis</th>
									<th class="text-center">Bank</th>
									<th class="text-center">Nominal Retur</th>
									<th class="text-center">Keterangan</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list_retur)): ?>
									<?php $i=1; foreach ($list_retur as $data): ?>
										<tr>
											<td class="text-center"><?php echo $i ?></td>
											<td class="text-center"><?php echo $data->str_nomor_trx_retur ?></td>
											<td class="text-center"><?php echo $data->str_nomor_trx_spm ?></td>
											<td class="text-center"><?php echo $data->tgl_retur ?></td>
											<td class="text-center">[RETUR]</td>
											<td class="text-left"><?php echo $data->bank ?></td>
											<td class="text-right"><b>Rp.&nbsp;<?php echo number_format($data->nominal_retur,0,',','.') ?></b></td>
											<td><?php echo $data->keterangan ?></td>
										</tr>
										<?php foreach ($list_sp2d as $item): ?>
											<?php if ($data->str_nomor_trx_spm == $item->str_nomor_trx_spm && $item->jenis_sp2d == "Pembayaran RETUR"): ?>
												<tr>
													<td class="text-center">&nbsp;</td>
													<td class="text-center"><?php echo $item->str_nomor_trx_sp2d ?></td>
													<td class="text-center">&nbsp;</td>
													<td class="text-center"><?php echo $item->tgl_sp2d ?></td>
													<td class="text-center">[<?php echo $item->jenis_sp2d ?>]</td>
													<td class="text-left"><?php echo $item->bank ?></td>
													<td class="text-right"><b>Rp.&nbsp;<?php echo number_format($item->nominal_sp2d,0,',','.') ?></b></td>
													<td><?php echo $item->keterangan ?></td>
												</tr>
											<?php endif ?>
										<?php endforeach ?>
									<?php $i++; endforeach ?>
								<?php else: ?>
									<tr>
										<td colspan="7" class="text-center">- Tidak Ada Data -</td>
									</tr>
								<?php endif ?>
		               </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- end content -->
	</div>
</div>

<div class="modal fade" id="add_retur_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="modal_content">

		</div>
	</div>
</div>

<div class="modal fade" id="edit_sp2d_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="modal_content_edit_sp2d">

		</div>
	</div>
</div>