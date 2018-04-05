<script type="text/javascript">
	var row_focus = localStorage.getItem("row_focus_retur");
	if (row_focus!=null) {
		$('html, body').animate({scrollTop: $(row_focus).offset().top}, 2000);
	}
$(document).ready(function(){


	$(document).on("click",".edit_retur",function(){
		var id = $(this).attr('rel');
		var no_spm = $(this).attr('data-no-spm');
		var nominal_cair = $(this).attr('data-nominal-cair');
		var jenis = $(this).attr('data-jenis');

		$.ajax({
			type:"POST",
			url:"<?=site_url("rsa_sp2d/get_edit_retur_modal")?>",
			data:'id='+id+'&no_spm='+no_spm+'&nominal_cair='+nominal_cair+'&jenis='+jenis,
			success:function(data){
				$('#modal_content_edit_retur').html(data);
				$('#edit_retur_modal').modal('show');
			}
		});
	});

	$(document).on("submit","#form_edit_retur",function(e){
		var id = $('#id').val();
		var no_retur = $('#no_retur').val();
		var tgl_retur = $('#tgl_retur').val();
		var keterangan = $('#keterangan').val();

		if ($("#bank").val() == '0') {
			var bank = $( "#bank_2" ).val();
			var kd_akun_kas = '';
		}else{
			var bank = $( "#bank option:selected" ).text();
			var kd_akun_kas = $('#bank').val();
		}
		
		if($("#form_edit_retur").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_sp2d/update_retur")?>",
				data:'no_retur='+no_retur+'&tgl_retur='+tgl_retur+'&bank='+bank+'&kd_akun_kas='+kd_akun_kas+'&keterangan='+keterangan+'&id='+id,
				success:function(respon_json){
					// $('#add_sp2d_modal').modal('hide');
					var respon = JSON.parse(respon_json);
					if (respon=="sukses"){
						$('#edit_retur_modal').modal('hide');
						alert(respon);

						var focus_id = (parseInt(id) - 6);
						if (focus_id <= 0) {
							focus_id = 1;
						}
						localStorage.setItem("row_focus_retur", "#retur_row_"+focus_id);
						location.reload();
					} else {
						$('#edit_retur_modal').modal('hide');
						alert(respon);
					}
				}
			});
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
	});

	$(document).on("click","#cetak_retur",function(){
			var no_retur = $(this).attr('rel');
			$.ajax({
					type:"POST",
					url:"<?=site_url("rsa_sp2d/cetak_sp2d_retur/")?>"+no_retur,
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
		});

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
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/tambah_sp2d') ?>" ><b><i class="fa fa-plus-circle"></i> Tambah SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d') ?>"><b><i class="fa fa-list"></i> Daftar SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d_100') ?>"><b><i class="fa fa-list"></i> Daftar SP2D 100%</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/tambah_retur') ?>"><b><i class="fa fa-plus-circle"></i> Tambah RETUR</b></a></li>
				<li role="presentation" class="active"><a href="#daftar_retur" aria-controls="daftar_retur"  role="tab" data-toggle="tab"><b><i class="fa fa-list"></i> Daftar RETUR</b></a></li>
				<!-- <li role="presentation"><a href="<?php echo site_url('rsa_sp2d/history_sp2d') ?>" ><b>Riwayat SP2D</b></a></li> -->
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/sp2d_per_spm') ?>"><b><i class="fa fa-file-text-o"></i> Laporan SP2D per SPM</b></a></li>
			</ul>
		</div>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="daftar_retur">
				
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
									<th class="text-center" style="min-width: 110px;">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list_retur)): ?>
									<?php $i=1; foreach ($list_retur as $data): ?>
										<tr id="retur_row_<?php echo $data->id_trx_urut_sp2d_retur ?>">
											<td class="text-center" style="min-width:50px;vertical-align: middle;" <?php if ($data->id_trx_urut_spm_sp2d != null){echo 'rowspan="2"';} ?>><?php echo $i ?> <?php if ($data->id_trx_urut_spm_sp2d != null){echo '<i class="text-success fa fa-check-square-o"></i>';} ?></td>
											<td class="text-center"><?php echo $data->str_nomor_trx_retur ?></td>
											<td class="text-center" style="vertical-align: middle;" <?php if ($data->id_trx_urut_spm_sp2d != null){echo 'rowspan="2"';} ?> ><a href="javascript:void(0)" data-no-spm="<?php echo $data->str_nomor_trx_spm ?>" class="btn-riwayat"><?php echo $data->str_nomor_trx_spm ?></a></td>
											<td class="text-center"><?php echo $data->tgl_retur ?></td>
											<td class="text-center" style="vertical-align: middle;"><span class="label" style="background-color: #e47c32;font-size: 12px;">RETUR</span></td>
											<td class="text-left"><?php echo $data->bank ?></td>
											<td class="text-right"><b>Rp.&nbsp;<?php echo number_format($data->nominal_retur,0,',','.') ?></b></td>
											<td><?php echo $data->keterangan ?></td>
											<td class="text-center" style="vertical-align: middle;" <?php if ($data->id_trx_urut_spm_sp2d != null){echo 'rowspan="2"';} ?>>
												<div class="btn-group" role="group">
													<button type="button" class="btn btn-xs btn-warning edit_retur" rel="<?php echo $data->id_trx_urut_sp2d_retur ?>" data-no-spm="<?php echo $data->str_nomor_trx_spm ?>" data-nominal-cair="<?php echo $data->nominal_spm_cair ?>" data-jenis="<?php echo $data->jenis_trx ?>"><i class="fa fa-pencil"></i> Edit</button>
													<button class="btn btn-xs btn-default btn-riwayat" data-no-spm="<?php echo $data->str_nomor_trx_spm; ?>"><i class="fa fa-search"></i></button>
													<button type="button" id="cetak_retur" title="cetak" class="btn btn-xs btn-default cetak" rel="<?php echo urlencode(base64_encode($data->str_nomor_trx_retur)) ?>">
														<i class="fa fa-print"></i>
													</button>
												</div>
											</td>
										</tr>
										<?php if ($data->id_trx_urut_spm_sp2d != null): ?>
												<tr>
													<td class="text-center" style="background-color: #;"><?php echo $data->data_sp2d->str_nomor_trx_sp2d ?></td>
													<td class="text-center" style="background-color: #;"><?php echo $data->data_sp2d->tgl_sp2d ?></td>
													<td class="text-center" style="background-color: #;vertical-align: middle;">
														<span class="label" style="background-color: #009688;font-size: 12px;">SP2D</span>
														 <br>
														 <br>
														<?php echo $data->data_sp2d->jenis_sp2d ?></td>
													<td class="text-left" style="background-color: #;"><?php echo $data->data_sp2d->bank ?></td>
													<td class="text-right" style="background-color: #;"><b>Rp.&nbsp;<?php echo number_format($data->data_sp2d->nominal,0,',','.') ?></b></td>
													<td style="background-color: #;"><?php echo $data->data_sp2d->keterangan ?></td>
												</tr>
										<?php endif ?>
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

<div class="modal fade" id="edit_retur_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="modal_content_edit_retur">

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