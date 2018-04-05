<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker.css" rel="stylesheet">

<script type="text/javascript">
	$(document).ready(function(){

	<?php if ($this->check_session->get_level()==13): ?>
		 bootbox.alert({
         title: "<b class='text-info'><i class='fa fa-info-circle'></i> INFORMASI </b> ",
         message: "Fitur <b>Edit</b> untuk potongan lainnya sudah aktif. Anda dapat memperbaiki data yang belum sesuai pada halaman <b>Dokumen Bukti Potongan</b>. <br />Klik tombol <b><i class='fa fa-search'></i></b> untuk membuka <b>Dokumen Bukti Potongan.</b>",
         animate: false,
     });
	<?php endif ?>

		$(document).on("click","#pilih_tahun",function(){
//                        if($("#form_dpa").validationEngine("validate")){
//                            var sumber_dana = $('#sumber_dana').val();
                            window.location = "<?=site_url("rsa_potongan_lainnya/daftar_potongan_lainnya/").$kode_unit_subunit."/"?>" + $("#jenis").val() + '/' + $("#bulan").val() ;

                    //        $('#tb-empty').hide(function(){
                    //                $('#tb-isi').show(function(){
                    //                    get_unit_dpa();

                    //                });
                    //            });


//                        }


                    });

			// $(document).on("click","#createspp",function(){

   //                          window.location = "<?=site_url("rsa_cair/spm/")?>/" ;

   //                          // alert('t');



   //                  });

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

		$(document).on("change","#jenis_potongan",function(event){
			if ($("#jenis_potongan").val() == 'null') {
				var no_spm = $("#no_spm").val();
				var jenis_trx = $("#jenis_trx").val();
				$.ajax({
					type:"POST",
					url:"<?=site_url("rsa_potongan_lainnya/get_akun_belanja_option")?>",
					data:'no_spm='+no_spm+'&jenis_trx='+jenis_trx,
					success:function(data){
						$('#akun_belanja').html(data);
					}
				});
				$("#row_akun_belanja").show();
				$("#akun_belanja").focus();
			}else{
				$('#akun_belanja').html('');
				$("#row_akun_belanja").hide();
			}
		});

		$(document).on("click",".btn-ptla",function(){
			var id_trx_urut_spm_cair = $(this).attr('data-id_trx_urut_spm_cair');
			var no_spm = $(this).attr('data-no-spm');
			var kode_unit_subunit = $(this).attr('data-kd-unit');
			var jenis = $(this).attr('data-jenis');
			var nominal_ptla = $(this).attr('data-nominal-ptla');

			$('#id_trx_urut_spm_cair').val($(this).attr('data-id_trx_urut_spm_cair'));

			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_potongan_lainnya/potongan_lainnya_modal")?>",
				data:'no_spm='+no_spm+'&kode_unit_subunit='+kode_unit_subunit+'&jenis='+jenis+'&nominal_ptla='+nominal_ptla+'&id_trx_urut_spm_cair='+id_trx_urut_spm_cair,
				success:function(data){
					$('#modal_content').html(data);
					$('#add_ptla_modal').modal('show');
				}
			});

		});

		$(document).on("click",".btn-ajukan",function(){
			var no_spm = $(this).attr('data-no-spm');
			if(confirm('Anda yakin mengajukan ?')){
				$.ajax({
					type:"POST",
					url:"<?=site_url("rsa_potongan_lainnya/proses_ptla")?>",
					data:'no_spm='+no_spm,
					success:function(respon){
						if (respon == 'sukses') {
							alert(respon);
							location.reload();
						}else{
							alert(respon);
						}
					}
				});
			}
		});

		// $(document).on("click","#close_sp2d",function(){
		// 	$('#no_spm_txt').html('');
		// 	$('#kode_unit_subunit').val('');
		// 	$('#no_spm').val('');
		// 	$('#tgl_sp2d').val('');
		// 	$('#nominal').val('');
		// 	$('#keterangan').val('');
		// });

		$("#add_ptla_modal").on("hidden.bs.modal",function(){
			// $('#no_spm_txt').html('');
			$('#kode_unit_subunit').val('');
			$('#jenis_trx').val('');
			$('#no_sp2d').val('');
			$('#no_spm').val('');
			$('#tgl_sp2d').val('');
			$('#nominal').val('');
			$('#keterangan').val('');
			$('#bank').val('');
			$('#bank').html('');
			$('#nominal_belum_sp2d').html('');
			$('#error_nominal').hide();
			$('#nominal').css('border','1px solid #ccc');
			$('#id_trx_urut_spm_cair').val('');
			// alert('ads');
		});

		$(document).on("submit","#form_ptla",function(e){
			// alert(string_to_angka($('#nominal').val()));
			var data=$("#form_ptla").serialize();

			var kode_unit_subunit = $('#kode_unit_subunit').val();
			var jenis = $('#jenis_trx').val();
			var no_spm = $('#no_spm').val();
			var no_spm_encoded = $('#no_spm_encoded').val();
			// var no_ptla = $('#new_no_ptla').val();
			var kd_akun_kas = $('#jenis_potongan').val();
			var jenis_potongan = $('#jenis_potongan option:selected').text().substr(0, 43);
			var akun_belanja = $('#akun_belanja').val();
			var akun_belanja_ket = null;
			if (akun_belanja != null) {
				var akun_belanja_ket = '['+akun_belanja+'] '+$('#akun_belanja option:selected').text().substr(27, 200);
			}
			var nominal = string_to_angka($('#nominal').val());
			var keterangan = $('#keterangan').val();
			var nominal_ptla = $('#nominal_ptla').val();
			var nominal_belum_ptla = parseInt(string_to_angka($('#nominal_belum_ptla').html()));

			if (nominal <= nominal_belum_ptla) {
				if (nominal > 0) {
					if($("#form_ptla").validationEngine("validate")){
						$.ajax({
							type:"POST",
							url:"<?=site_url("rsa_potongan_lainnya/add_ptla")?>",
							data:'no_spm='+no_spm+'&kode_unit_subunit='+kode_unit_subunit+'&nominal='+nominal+'&keterangan='+keterangan+'&jenis='+jenis+'&nominal_ptla='+nominal_ptla+'&jenis_potongan='+jenis_potongan+'&kd_akun_kas='+kd_akun_kas+'&akun_belanja='+akun_belanja+'&akun_belanja_ket='+akun_belanja_ket,
							success:function(respon){
								// $('#add_ptla_modal').modal('hide');
								if (respon=="sukses"){
									$('#add_ptla_modal').modal('hide');
									alert(respon);

									var id_trx_urut_spm_cair = $('#id_trx_urut_spm_cair').val();
									var sudah_ptla = string_to_angka($('#sudah_ptla_'+id_trx_urut_spm_cair).html());
									var new_sudah_ptla = sudah_ptla + nominal;
									$('#sudah_ptla_'+id_trx_urut_spm_cair).html(angka_to_string(new_sudah_ptla));

									if (nominal == nominal_belum_ptla) {
										$('#btn_'+id_trx_urut_spm_cair).html('<i class="fa fa-share-square-o"></i> Ajukan');
										$('#btn_'+id_trx_urut_spm_cair).removeClass('btn-warning');
										$('#btn_'+id_trx_urut_spm_cair).removeClass('btn-ptla');
										$('#btn_'+id_trx_urut_spm_cair).addClass('btn-primary');
										$('#btn_'+id_trx_urut_spm_cair).addClass('btn-ajukan');
										var btn_lihat_href = "window.location.href='<?php echo site_url(); ?>/rsa_potongan_lainnya/dokumen_ptla/"+no_spm_encoded+"'";
										$('#btn_group_ptla_'+id_trx_urut_spm_cair).append('<button class="btn btn-sm btn-default btn-lihat" title="lihat" onclick="'+btn_lihat_href+'"><i class="fa fa-search"></i></button>');
									}
								} else {
									$('#add_ptla_modal').modal('hide');
									alert(respon);
									if (nominal == nominal_belum_ptla) {
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).html('<button class="btn btn-xs btn-success btn-ptla" disabled>Selesai</button>');
									}
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
				$('#error_nominal_text').html('Tidak dapat melebihi Rp. '+ $('#nominal_belum_ptla').html() +' !');
				$('#error_nominal').show();
				$('#nominal').css('border','1px solid #bd0808');
				$('#nominal').focus();
			}

		});

		$(".readonly").keydown(function(e){
        	e.preventDefault();
   		});

    });
        
	function string_to_angka(str){
		return parseInt(str.split('.').join(""));
	}

	function angka_to_string(num){
		var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		return str_hasil;
	}

	function open_tolak(msg,user,tgl){
		bootbox.alert({
			title: "TELAH DITOLAK OLEH "+user,
			message: '<b>Ditolak pada tanggal :</b> '+tgl+'<br/><b>Alasan Penolakan :</b> <br/>'+msg,
			animate:false,
		});
	}

</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->

		<div class="row">
			<div class="col-lg-12">
				<h2>POTONGAN LAINNYA</h2> 
			</div>
		</div>
		<hr />

		<div class="row">
			<div class="col-md-12">

				<form id="kentut" class="form-horizontal">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-1">Jenis : </label>
								<div class="col-md-3">
									<select name="jenis" id="jenis" class="validate[required] form-control">
										<option value="00">[ SEMUA ]</option>
										<option value="UP">[ UP ]</option>
										<option value="PUP">[ PUP ]</option>
										<option value="GUP">[ GUP ]</option>
										<option value="TUP">[ TUP ]</option>
										<option value="TUP-NIHIL">[ TUP-NIHIL ]</option>
										<option value="LSP">[ LSP ]</option>
				                    <!--
				                    <option value="LS3">[ LS3 ]</option>
				                  -->
				                  <option value="LSK">[ LSK ]</option>
				                  <option value="LSNK">[ LSNK ]</option>
				               </select>
				            </div>
				         </div>
				         <div class="form-group">
				         	<label class="col-md-1">Bulan : </label>
				         	<div class="col-md-3">
				         		<select name="bulan" id="bulan" class="validate[required] form-control">
				         			<option value="" >[ SEMUA ]</option>
				         			<option value="01">Januari</option>
				         			<option value="02">Februari</option>
				         			<option value="03">Maret</option>
				         			<option value="04">April</option>
				         			<option value="05">Mei</option>
				         			<option value="06">Juni</option>
				         			<option value="07">Juli</option>
				         			<option value="08">Agustus</option>
				         			<option value="09">September</option>
				         			<option value="10">Oktober</option>
				         			<option value="11">November</option>
				         			<option value="12">Desember</option>
				         		</select>
				         	</div>
				         </div>
				         <div class="form-group">
				         	<div class="col-md-1">
				         		&nbsp;
				         	</div>
				         	<div class="col-md-3">
				         		<button type="button" class="btn btn-danger btn-sm" id="pilih_tahun"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Apply Filter</button>
				         	</div>
				         </div>
				      </div>
				   </div>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-info"><span class="text-warning"><b>Filter : </b></span> <b>Tahun [ <span class="text-danger"><b><?=$cur_tahun?></b></span> ] Unit [ <span class="text-danger"><b><?=$kode_unit_subunit?></b></span> ] Jenis [ <span class="text-danger"><b><?=$jenis?></b></span> ]</b> Bulan [ <span class="text-danger"><b><?=$bulan?></b></span> ]</b></div>
			</div>

			<div class="col-md-12 table-responsive">
				<table class="table table-bordered table-striped table-hover small" style="overflow: hidden;">
					<thead>
						<tr>
							<th class="text-center col-md-1">No</th>
							<th class="text-center col-md-3">SPM</th>
							<th class="text-center col-md-1">JENIS</th>
							<th class="text-center col-md-2">Tanggal</th>
							<th class="text-center col-md-1">Bruto</th>
							<th class="text-center col-md-1">Pajak</th>
							<th class="text-center col-md-1">Netto</th>
							<th class="text-center col-md-1">Potongan Lainnya</th>
							<th class="text-center col-md-1">Selesai</th>
							<th class="text-center col-md-1" style="min-width: 150px;">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(!empty($daftar_spm)){
							$i=1;foreach ($daftar_spm as $key => $value) {?>		
							<?php if ($value->potongan_lainnya > 0): ?>
								<tr <?php if ($value->tolakstatus == 1){echo "style='background-color:#ffe7e7;'";} ?>>
									<td class="text-center"><?php echo $i; ?>.</td>
									<td class="text-center"><?php echo $value->str_nomor_trx_spm; ?></td>
									<td class="text-center"><?php echo $value->jenis_trx; ?></td>
									<td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_proses)); ?><br /></td>
									<td class="text-right"><?php echo number_format($value->nominal, 0, ",", "."); ?></td>
									<td class="text-right"><?php echo number_format($value->pajak, 0, ",", "."); ?></td>
									<td class="text-right"><?php echo number_format($value->netto, 0, ",", "."); ?></td>
									<td class="text-right"><b><?php echo number_format($value->potongan_lainnya, 0, ",", "."); ?></b></td>
									<td class="text-right" id="sudah_ptla_<?php echo $value->id_trx_urut_spm_cair ?>" style="font-weight: bold;">
										<?php echo number_format($value->nominal_sudah_ptla, 0, ",", "."); ?>
									</td>
									<td class="text-center">
										<?php if ($value->tolakstatus == 1): ?>
											<span class="glyphicon glyphicon-exclamation-sign text-danger" style="cursor:pointer;font-size: 16px;vertical-align: middle;" title="ditolak" onclick="open_tolak('<?php echo $value->tolakket ?>','<?php echo $value->tolakuser ?>','<?php echo $value->tolaktgl ?>')" aria-hidden="true"></span>
										<?php endif ?>
										<div class="btn-group" role="group" id="btn_group_ptla_<?php echo $value->id_trx_urut_spm_cair; ?>">
											<?php
											$persen_ptla = 0;
											if ($value->potongan_lainnya > 0) {
												$persen_ptla = ($value->nominal_sudah_ptla / $value->potongan_lainnya) * 100;
											}
											?>
											<?php if ($persen_ptla == 100): ?>
												<?php if ($value->proses == 0): ?>
													<?php if ($value->tolakstatus == 1): ?>
														<button class="btn btn-xs btn-info btn-ajukan" data-no-spm="<?php echo $value->str_nomor_trx_spm; ?>"><i class="fa fa-share-square-o"></i> Ajukan</button>
														<button class="btn btn-xs btn-default btn-lihat" title="lihat" onclick="window.location.href='<?php echo site_url().'/rsa_potongan_lainnya/dokumen_ptla/'.urlencode(base64_encode($value->str_nomor_trx_spm)) ?>'"><i class="fa fa-search"></i></button>
													<?php else: ?>
														<button class="btn btn-xs btn-primary btn-ajukan" data-no-spm="<?php echo $value->str_nomor_trx_spm; ?>"><i class="fa fa-share-square-o"></i> Ajukan</button>
														<button class="btn btn-xs btn-default btn-lihat" title="lihat" onclick="window.location.href='<?php echo site_url().'/rsa_potongan_lainnya/dokumen_ptla/'.urlencode(base64_encode($value->str_nomor_trx_spm)) ?>'"><i class="fa fa-search"></i></button>
													<?php endif ?>
												<?php elseif($value->proses == 1): ?>
													<?php if ($this->check_session->get_level()==3): ?>
														<?php if ($value->tolakstatus == 1): ?>
															<button class="btn btn-sm btn-info btn-lihat" title="lihat" onclick="window.location.href='<?php echo site_url().'/rsa_potongan_lainnya/dokumen_ptla/'.urlencode(base64_encode($value->str_nomor_trx_spm)) ?>'"><i class="fa fa-file-text-o"></i> Lihat</button>
														<?php else: ?>
															<button class="btn btn-sm btn-primary btn-lihat" title="lihat" onclick="window.location.href='<?php echo site_url().'/rsa_potongan_lainnya/dokumen_ptla/'.urlencode(base64_encode($value->str_nomor_trx_spm)) ?>'"><i class="fa fa-file-text-o"></i> Lihat</button>
														<?php endif ?>
													<?php else: ?>
														<button class="btn btn-xs btn-danger" disabled><i class="fa fa-clock-o"></i> Verifikator</button>
														<button class="btn btn-xs btn-default btn-lihat" title="lihat" onclick="window.location.href='<?php echo site_url().'/rsa_potongan_lainnya/dokumen_ptla/'.urlencode(base64_encode($value->str_nomor_trx_spm)) ?>'"><i class="fa fa-search"></i></button>
													<?php endif ?>
												<?php elseif($value->proses == 2): ?>
													<?php if ($this->check_session->get_level()==11): ?>
														<?php if ($value->tolakstatus == 1): ?>
															<button class="btn btn-sm btn-info btn-lihat" title="lihat" onclick="window.location.href='<?php echo site_url().'/rsa_potongan_lainnya/dokumen_ptla/'.urlencode(base64_encode($value->str_nomor_trx_spm)) ?>'"><i class="fa fa-file-text-o"></i> Lihat</button>
														<?php else: ?>
															<button class="btn btn-sm btn-primary btn-lihat" title="lihat" onclick="window.location.href='<?php echo site_url().'/rsa_potongan_lainnya/dokumen_ptla/'.urlencode(base64_encode($value->str_nomor_trx_spm)) ?>'"><i class="fa fa-file-text-o"></i> Lihat</button>
														<?php endif ?>
													<?php else: ?>
														<button class="btn btn-xs btn-danger" disabled><i class="fa fa-clock-o"></i> KBUU</button>
														<button class="btn btn-xs btn-default btn-lihat" title="lihat" onclick="window.location.href='<?php echo site_url().'/rsa_potongan_lainnya/dokumen_ptla/'.urlencode(base64_encode($value->str_nomor_trx_spm)) ?>'"><i class="fa fa-search"></i></button>
													<?php endif ?>
												<?php elseif($value->proses == 3): ?>
													<button class="btn btn-xs btn-success" disabled><i class="fa fa-check-square-o"></i> Selesai</button>
													<button class="btn btn-xs btn-default btn-lihat" title="lihat" onclick="window.location.href='<?php echo site_url().'/rsa_potongan_lainnya/dokumen_ptla/'.urlencode(base64_encode($value->str_nomor_trx_spm)) ?>'"><i class="fa fa-search"></i></button>
												<?php endif ?>

											<?php else: ?>
												<button class="btn btn-sm btn-warning btn-ptla" id="btn_<?php echo $value->id_trx_urut_spm_cair; ?>" data-nominal-ptla="<?php echo $value->potongan_lainnya; ?>" data-jenis="<?php echo $value->jenis_trx; ?>" data-kd-unit="<?php echo $value->kode_unit_subunit; ?>" data-no-spm="<?php echo $value->str_nomor_trx_spm; ?>" data-id_trx_urut_spm_cair="<?php echo $value->id_trx_urut_spm_cair; ?>"><i class="glyphicon glyphicon-plus-sign"></i> Potongan</button>
											<?php endif ?>
										</div>
									</td>
								</tr>
								<?php $i++;endif ?>

								<?php
							}
						}else{
							?>
							<tr>
								<td colspan="10" class="text-center alert-warning">
									Tidak ada data
								</td>
							</tr>
							<?php
						}
						?>
						<tr>
							<td colspan="10" >&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<!-- end content -->
	</div>
</div>

<div class="modal" id="myModalMessage" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i> Perhatian :</h4>
          </div>
          <div class="modal-body" style="margin:15px;padding:0px;padding-bottom: 15px;word-wrap: break-word;">
          	<form id="alasan_nolak">
          		<input type="hidden" name="id_sppls" id="id_sppls" value=""/>
          		<input type="hidden" name="proses" id="proses" value="0"/>
          		<div class="form-group">
          			<label for="alasan_tolak">Alasan Menolak SPP:</label>
          			<textarea class="form-control" name="alasan_tolak" id="alasan_tolak"></textarea>
          		</div>
          	</form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning tolak_mentah2"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> OK</button>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_ptla_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding: 20px;">
	<div class="modal-dialog modal-lg" style="width: 95%;padding: 0px;margin: 0px auto;">
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