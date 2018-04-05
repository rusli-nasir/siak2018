<script>
$(document).ready(function(){

	<?php if ($this->check_session->get_level()==13): ?>
		 bootbox.alert({
         title: "<b class='text-info'><i class='fa fa-info-circle'></i> INFORMASI </b> ",
         message: "Klik tombol <b><i class='fa fa-pencil'></i></b> untuk mengedit",
         animate: false,
     });
	<?php endif ?>

	$("#cetak").click(function(){
		var mode = 'iframe'; //popup
		var close = mode == "popup";
		var options = { mode : mode, popClose : close};
		$("#div-cetak").printArea( options );
	});


	$("#kembali").click(function(){
		window.location.href = "<?php echo base_url(); ?>index.php/rsa_potongan_lainnya/daftar_potongan_lainnya/<?php echo $data_ptla->kode_unit_subunit ?>";
	});

	$("#tolak").click(function(){
		var no_spm = $("#tolak").attr('rel');
		var kd_unit = $("#tolak").attr('data-kode-unit');
		$.ajax({
			type:"POST",
			url:"<?=site_url("rsa_potongan_lainnya/modal_tolak")?>",
			data:'no_spm='+no_spm+'&kd_unit='+kd_unit,
			success:function(respon){
				$("#modal_content").html(respon);
			},
			complete:function(){
				$('#alasan').modal('show');
			}
		});
	});

	$(document).on("keyup",".xnumber",function(event){
			// skip for arrow keys
			if(event.which >= 37 && event.which <= 40) return;
			// format number
			$(this).html(function(index, value) {
				var val = value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
				return val
				;
			});
		});

	$(".edit-ptla").click(function(){
		var rel = $(this).attr('rel');
		var id = $(this).attr('id');
		// alert(rel);
		$('#'+rel).attr('contenteditable','true');
		$('#'+rel).css('border-bottom','1px solid red');
		$('#'+rel).focus();
		$('#'+id).hide();
		$('#save_'+id).show();
	});

	$(".save-edit-ptla").click(function(){
		var rel = $(this).attr('rel');
		var id = $(this).attr('id');
		var id_trx = $(this).attr('data-id-trx');
		var table_name = $(this).attr('data-table-name');
		if (table_name == 'nominal') {
			var value = string_to_angka($('#'+rel).html());
		}else{
			var value = $('#'+rel).html();
		}

		// alert(rel+' '+id+' '+id_trx+' '+value);

		$.ajax({
			type:"POST",
			url:"<?=site_url("rsa_potongan_lainnya/update_ptla_edit")?>",
			data:'id_trx='+id_trx+'&table_name='+table_name+'&value='+value,
			success:function(respon){
				// alert(respon);
			},
			complete:function(){
				var result = 0;
				$('[id^="nominal_ptla_"]').each(function(){
					result = parseInt(string_to_angka($(this).html())) + result;
				});

				$('#'+rel).attr('contenteditable','false');
				$('#'+rel).css('border-bottom','none');
				$('#'+id).hide();
				$('#edit_'+rel).show();
				$('#jml_ptla').html(angka_to_string(result));
			}
		});
	});		

	$(document).on("click","#setuju",function(e){
		var no_spm = $("#setuju").attr('rel');
		if(confirm('Anda yakin menyetujui ?')){
			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_potongan_lainnya/proses_ptla")?>",
				data:'no_spm='+no_spm,
				success:function(respon){
					if (respon == 'sukses') {
						alert(respon);
						window.location.href = "<?php echo base_url(); ?>index.php/rsa_potongan_lainnya/daftar_potongan_lainnya/<?php echo $data_ptla->kode_unit_subunit ?>";
					}else{
						alert(respon);
						window.location.href = "<?php echo base_url(); ?>index.php/rsa_potongan_lainnya/daftar_potongan_lainnya/<?php echo $data_ptla->kode_unit_subunit ?>";
					}
				}
			});
		}
	});

});

	function string_to_angka(str){
		return parseInt(str.split('.').join(""));
	}

	function angka_to_string(num){
		var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		return str_hasil;
	}
</script>
<style>
	.bar{
		vertical-align: middle !important;
    	margin: -60px 0px 0px 0px !important;
	}
</style>
<div id="page-wrapper" >
	<div id="page-inner">
		<h3><b>BUKTI POTONGAN</b></h3><hr>
		
		<?php if($data_ptla->proses == 1): ?>
			<?php if ($this->check_session->get_level()==3): ?>
				<div class="alert alert-success" style="border:1px solid #a94442;">Potongan Lainnya Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah diajukan oleh <b><span class="text-danger" >BENDAHARA </span></b> .</div>
			<?php else: ?>
				<div class="alert alert-info" style="border:1px solid #a94442;">Potongan Lainnya Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >VERIFIKATOR</span></b> .</div>
			<?php endif ?>
		<?php elseif($data_ptla->proses == 2): ?>
			<?php if ($this->check_session->get_level()==11): ?>
				<div class="alert alert-success" style="border:1px solid #a94442;">Potongan Lainnya Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah disetujui oleh <b><span class="text-danger" >VERIFIKATOR </span></b> .</div>
			<?php else: ?>
				<div class="alert alert-info" style="border:1px solid #a94442;">Potongan Lainnya Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KUASA BUU</span></b> .</div>
			<?php endif ?>
		<?php elseif($data_ptla->proses == 3): ?>
				<div class="alert alert-success" style="border:1px solid #a94442;">Potongan Lainnya Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah disetujui oleh <b><span class="text-danger" >KUASA BUU </span></b> .</div>
		<?php endif ?>

		<div class="progress-round">
			<div class="circle <?php if($data_ptla->proses >= 1){echo 'done';} ?>">
				<span class="label">1</span>
				<span class="title">Bendahara</span>
			</div>
			<span class="bar <?php if($data_ptla->proses >= 1){echo 'done';} ?>"></span>
			<div class="circle <?php if($data_ptla->proses >= 2){echo 'done';} ?>">
				<span class="label">2</span>
				<span class="title">Verifikator</span>
			</div>
			<span class="bar <?php if($data_ptla->proses >= 2){echo 'done';} ?>"></span>
			<div class="circle <?php if($data_ptla->proses >= 3){echo 'done';} ?>">
				<span class="label">3</span>
				<span class="title">KBUU</span>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div id="temp" style="display:none">
				</div>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active">
						<div style="background-color: #EEE;">
							<div id="div-cetak" style="margin: 0px auto;">
								<table id="table" style="margin: 0px auto;font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0">
									<tbody>
										<tr>
											<td colspan="7" style="text-align: center;padding-top: 5px;padding-bottom: 5px;"><img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60"></td>
										</tr>
										<tr>
											<td style="border:0px;width: 0.1%;white-space:nowrap;"></td>
											<td style="border:0px;width: 1%;white-space:nowrap;"></td>
											<td style="border:0px;width: 1%;white-space:nowrap;"></td>
											<td style="border:0px;width: 1%;white-space:nowrap;"></td>
											<td style="border:0px;width: 1%;white-space:nowrap;"></td>
											<td style="border:0px;width: 2%;white-space:nowrap;"></td>
											<td style="border:0px;width: 0.1%;white-space:nowrap;"></td>
										</tr>
										<tr >
											<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr style="">
											<td colspan="7" style="text-align: center;font-size: 20px;border-bottom: none;border-top: none"><b>UNIVERSITAS DIPONEGORO</b></td>
										</tr>
										<tr style="border-top: none;">
											<td colspan="7" style="text-align: center;font-size: 16px;border-bottom: none;border-top: none;"><b>BUKTI POTONGAN SPM: <?php echo $data_ptla->str_nomor_trx_spm ?></b></td>
										</tr>
										<tr >
											<td colspan="7" style="border-bottom: none;border-top: none;"></td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="2" style="border-right: none;border-left: none;"><b>Tanggal	: <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($data_ptla->tglbendahara)?'':strftime("%d %B %Y", strtotime($data_ptla->tglbendahara)); ?></b></td>
											<td style="text-align: center;border-left: none;border-right: none;" colspan="2">&nbsp;</td>
											<td style="border-left: none;border-right: none;"><b>Nomor SPM: <?php echo $data_ptla->str_nomor_trx_spm ?></b></td>
											<td style="border-left: none;border-right: none;">&nbsp;</td>
										</tr>
										<tr >
											<td style="border-right: none;">&nbsp;</td>
											<td style="border-left: none;border-right: none;" colspan="5" ><b>Satuan Unit Kerja Pengguna Anggaran (SUKPA) : <?php if ($data_ptla->nama_subunit ==""){
												echo $data_ptla->nama_unit;
											} else{
												echo $data_ptla->nama_subunit;
											}?>
												
											</b></td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="2" style="border-right: none;border-left: none;"><b>Unit Kerja : <?php echo $data_ptla->nama_unit ?> </b> </td> 
											<td style="text-align: center;border-left: none;border-right: none;" colspan="2">&nbsp;</td>
											<td style="border-left: none;border-right: none;"><b>Kode Unit Kerja : <?php echo $data_ptla->kode_unit_subunit ?> </b></td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
										<tr >
											<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr >
											<td style="border-right: none;border-bottom: none;border-top: none;">&nbsp;</td>
											<td colspan="5" style="border-bottom: none;border-top: none;border-right: none;border-left: none;">Berikut adalah uraian potongan lainnya :</td>
											<td style="border-left: none;border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;border-bottom: none;border-top: none;">&nbsp;</td>
											<td colspan="5" style="border-right: none;border-left: none;line-height: 16px;border-bottom: none;border-top: none;">
												<ol style="list-style-type: lower-alpha;margin-top: 0px;margin-bottom: 0px;" >
													<li>Total potongan lainnya : Rp. <?php echo number_format($data_ptla->jml_ptla, 0, ",", ".") ?> ,-<br>
													(Terbilang : <b><?php echo $data_ptla->terbilang ?> </b> )</li>
													<li>
														Uraian potongan : 
														<br>
														<table class="" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 100%;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0">
															<thead>
																<tr style="border-left: 1px;border-right: 1px;">
																	<th class="col-md-5" style="text-align: center;border-right: 1px solid #000;">Jenis Potongan</th>
																	<th class="col-md-2" style="text-align: center;border-right: 1px solid #000;">Nominal</th>
																	<th class="col-md-5" style="text-align: center;">Keterangan</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($data_ptla->data as $ptla): ?>
																	<tr style="border-left: 1px;border-right: 1px;">
																		<td style="text-align: left;padding-left: 10px;border-right: 1px solid #000;">
																			<?php echo $ptla->jenis_potongan ?>
																		</td>
																		<td style="padding-left: 0px;text-align: right;padding-right: 10px;border-right: 1px solid #000;">
																			<span class="xnumber" id="nominal_ptla_<?php echo $ptla->id_trx_urut_potongan_lainnya ?>"><?php echo number_format($ptla->nominal, 0, ",", ".") ?></span> 
																			<?php if ($this->check_session->get_level()==13): ?>
																				<span class="edit-ptla" id="edit_nominal_ptla_<?php echo $ptla->id_trx_urut_potongan_lainnya ?>" rel="nominal_ptla_<?php echo $ptla->id_trx_urut_potongan_lainnya ?>" style="cursor: pointer;color:orange;">
																					<i class="fa fa-pencil"></i>
																				</span>
																				<span class="save-edit-ptla" id="save_edit_nominal_ptla_<?php echo $ptla->id_trx_urut_potongan_lainnya ?>" rel="nominal_ptla_<?php echo $ptla->id_trx_urut_potongan_lainnya ?>" data-table-name="nominal" data-id-trx="<?php echo $ptla->id_trx_urut_potongan_lainnya ?>" style="cursor: pointer;color:blue;display: none;">
																					<i class="fa fa-floppy-o"></i>
																				</span>
																			<?php endif ?>
																		</td>
																		<td style="<?php if($ptla->keterangan == '-'){echo "text-align: center;";}else{echo "text-align: left;";} ?>padding-left: 10px;">
																			<span id="keterangan_ptla_<?php echo $ptla->id_trx_urut_potongan_lainnya ?>"><?php echo $ptla->keterangan ?></span> 
																			<?php if ($this->check_session->get_level()==13): ?>
																				<span class="edit-ptla" id="edit_keterangan_ptla_<?php echo $ptla->id_trx_urut_potongan_lainnya ?>" rel="keterangan_ptla_<?php echo $ptla->id_trx_urut_potongan_lainnya ?>" style="cursor: pointer;color:orange;">
																					<i class="fa fa-pencil"></i>
																				</span>
																				<span class="save-edit-ptla" id="save_edit_keterangan_ptla_<?php echo $ptla->id_trx_urut_potongan_lainnya ?>" rel="keterangan_ptla_<?php echo $ptla->id_trx_urut_potongan_lainnya ?>" data-table-name="keterangan" data-id-trx="<?php echo $ptla->id_trx_urut_potongan_lainnya ?>" style="cursor: pointer;color:blue;display: none;">
																					<i class="fa fa-floppy-o"></i>
																				</span>
																			<?php endif ?>
																		</td>
																	</tr>
																<?php endforeach ?>
																<tr style="border-left: 1px;border-right: 1px;">
																	<td style="text-align: right;padding-right: 10px;font-weight: bold;border-top: 2px solid #000;border-right: 1px solid #000;">Total</td>
																	<td style="text-align: right;padding-right: 10px;font-weight: bold;border-top: 2px solid #000;border-right: 1px solid #000;" id="jml_ptla"><?php echo number_format($data_ptla->jml_ptla, 0, ",", ".") ?></td>
																	<td style="text-align: right;padding-right: 10px;font-weight: bold;border-top: 2px solid #000;">&nbsp;</td>
																</tr>
															</tbody>
														</table>
													</li>
												</ol>
											</td>
											<td style="border-left: none;border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr >
											<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;border-top: none;">&nbsp;</td>
											<td colspan="5" style="line-height: 16px;border-bottom: none;border-top: none;border-left: none;border-right: none;">
												Bukti potongan sebagaimana dimaksud diatas, disusun guna menjelaskan nominal potongan lainnya pada SPM terkait.<br><br>														
											</td>
											<td style="border-left: none;border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="2" style="line-height: 16px;border-right: none;border-left: none;" class="ttd">
												
											</td>
											<td colspan="2" style="border-right: none;border-left: none;">&nbsp;</td>
											<td colspan="1" style="line-height: 16px;border-left: none;border-right: none;" class="ttd">
												Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($data_ptla->tglbendahara)?'':strftime("%d %B %Y", strtotime($data_ptla->tglbendahara)); ?> <br>
												Bendahara Pengeluaran SUKPA<br>
												<br>
												<br>
												<br>
												<br>
												<br>
												<span id=""><?php echo $data_ptla->nmbendahara ?></span><br>
												NIP. <span id=""><?php echo $data_ptla->nipbendahara ?></span><br>
											</td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="2" style="line-height: 16px;border-right: none;border-left: none;" class="ttd">
												Dokumen telah diverifikasi<br>
												kelengkapannya oleh Verifikator<br>
												Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($data_ptla->tglverifikator)?'':strftime("%d %B %Y", strtotime($data_ptla->tglverifikator)); ?><br />
												<br>
												<br>
												<br>
												<br>
												<br>
												<span id=""><?php echo $data_ptla->nmverifikator ?></span><br>
												NIP. <span id=""><?php echo $data_ptla->nipverifikator ?></span><br>
											</td>
											<td colspan="2" style="border-right: none;border-left: none;">&nbsp;</td>
											<td colspan="1" style="line-height: 16px;border-left: none;border-right: none;" class="ttd">
												Dokumen telah diverifikasi<br>
												kelengkapannya oleh KBUU<br>
												Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($data_ptla->tglkbuu)?'':strftime("%d %B %Y", strtotime($data_ptla->tglkbuu)); ?><br />
												<br>
												<br>
												<br>
												<br>
												<br>
												<span id=""><?php echo $data_ptla->nmkbuu ?></span><br>
												NIP. <span id=""><?php echo $data_ptla->nipkbuu ?></span><br>
											</td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="5"  style="line-height: 16px;border-right: none;border-left: none">
												
												<ul>
												</ul>
											</td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<div class="alert alert-warning" style="text-align:center">
									<button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
									<button type="button" class="btn btn-warning" id="kembali" rel=""><span class="glyphicon glyphicon-back" aria-hidden="true"></span> Kembali</button>
								</div>
							</div>
						</div>
					</div>
					<?php if ($data_ptla->proses==1): ?>
						<?php if ($this->check_session->get_level()==3): ?>
							<div class="alert alert-danger" style="text-align:center">
								<button type="button" class="btn btn-success" id="setuju" rel="<?php echo $data_ptla->str_nomor_trx_spm ?>" ><span class="glyphicon glyphicon" aria-hidden="true"></span>SETUJU</button>
								<button type="button" class="btn btn-danger" id="tolak" rel="<?php echo $data_ptla->str_nomor_trx_spm ?>" data-kode-unit="<?php echo $data_ptla->kode_unit_subunit ?>"><span class="glyphicon glyphicon-back" aria-hidden="true"></span>TOLAK</button>
							</div>
						<?php endif ?>
				 	<?php elseif($data_ptla->proses==2): ?> 
				 		<?php if ($this->check_session->get_level()==11): ?>
							<div class="alert alert-danger" style="text-align:center">
								<button type="button" class="btn btn-success" id="setuju" rel="<?php echo $data_ptla->str_nomor_trx_spm ?>" ><span class="glyphicon glyphicon" aria-hidden="true"></span>SETUJU</button>
								<button type="button" class="btn btn-danger" id="tolak" rel="<?php echo $data_ptla->str_nomor_trx_spm ?>" data-kode-unit="<?php echo $data_ptla->kode_unit_subunit ?>"><span class="glyphicon glyphicon-back" aria-hidden="true"></span>TOLAK</button>
							</div>
						<?php endif ?>
				 	<?php endif ?> 
				</div>
			</div>
		</div>	

		
	</div>
</div>

<div class="modal" id="alasan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="margin-top: 80px;">
		<div class="modal-content" id="modal_content">
		</div>
	</div>
</div>



