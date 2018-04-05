<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker.css" rel="stylesheet">

<script type="text/javascript">
	$(document).ready(function(){

		$(document).on("click","#pilih_tahun",function(){
//                        if($("#form_dpa").validationEngine("validate")){
//                            var sumber_dana = $('#sumber_dana').val();
                            window.location = "<?=site_url("rsa_sp2d/daftar_sp2d_100/")?>" + $("#tahun").val() + '/' + $("#unit").val() + '/' + $("#jenis").val() + '/' + $("#bulan").val()  ;

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

		$(document).on("change","#no_sp2d_sblm",function(event){
			if ($("#no_sp2d_sblm").is(':checked')) {
				$("#new_no_sp2d").val($("#no_sp2d_sblm_tmp").val());
			}else{
				$("#new_no_sp2d").val($("#new_no_sp2d_tmp").val());
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

		$(document).on("click",".btn-sp2d",function(){
			var id_trx_urut_spm_cair = $(this).attr('data-id_trx_urut_spm_cair');
			var no_spm = $(this).attr('data-no-spm');
			var kode_unit_subunit = $(this).attr('data-kd-unit');
			var jenis = $(this).attr('data-jenis');
			var nominal_cair = $(this).attr('data-nominal-cair');
			var pajak = $(this).attr('data-pajak');
			var netto = $(this).attr('data-netto');
			var potongan_lainnya = $(this).attr('data-potongan-lainnya');

			$('#id_trx_urut_spm_cair').val($(this).attr('data-id_trx_urut_spm_cair'));

			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_sp2d/sp2d_modal")?>",
				data:'no_spm='+no_spm+'&kode_unit_subunit='+kode_unit_subunit+'&jenis='+jenis+'&nominal_cair='+nominal_cair+'&id_trx_urut_spm_cair='+id_trx_urut_spm_cair+'&pajak='+pajak+'&netto='+netto+'&potongan_lainnya='+potongan_lainnya,
				success:function(data){
					$('#modal_content').html(data);
					$('#add_sp2d_modal').modal('show');
				}
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

		// $(document).on("click","#close_sp2d",function(){
		// 	$('#no_spm_txt').html('');
		// 	$('#kode_unit_subunit').val('');
		// 	$('#no_spm').val('');
		// 	$('#tgl_sp2d').val('');
		// 	$('#nominal').val('');
		// 	$('#keterangan').val('');
		// });

		$("#add_sp2d_modal").on("hidden.bs.modal",function(){
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

		$("#riwayat_sp2d_modal").on("hidden.bs.modal",function(){
			$('#riwayat_sp2d_modal_content').html('');
		});

		$(document).on("submit","#form_sp2d",function(e){
			// alert(string_to_angka($('#nominal').val()));
			var data=$("#form_sp2d").serialize();

			var kode_unit_subunit = $('#kode_unit_subunit').val();
			var jenis = $('#jenis_trx').val();
			var no_spm = $('#no_spm').val();
			var no_sp2d = $('#new_no_sp2d').val();
			var no_sp2d_encoded = $('#no_sp2d_encoded').val();
			var tgl_sp2d = $('#tgl_sp2d').val();
			var nominal = string_to_angka($('#nominal').val());
			var keterangan = $('#keterangan').val();
			var nominal_sp2d = $('#nominal_sp2d').val();
			var jenis_sp2d = $('#jenis_sp2d').val();
			var nominal_belum_sp2d = parseInt(string_to_angka($('#nominal_belum_sp2d').html()));
			var potongan_lainnya = $('#potongan_lainnya').val();
			console.log(potongan_lainnya);

			if ($("#bank").val() == '0') {
				var bank = $( "#bank_2" ).val();
				var kd_akun_kas = '';
			}else{
				var bank = $( "#bank option:selected" ).text();
				var kd_akun_kas = $('#bank').val();
			}
			

			if (nominal <= nominal_belum_sp2d) {
				if (nominal > 0) {
					if($("#form_sp2d").validationEngine("validate")){
						$.ajax({
							type:"POST",
							url:"<?=site_url("rsa_sp2d/add_sp2d")?>",
							data:'no_spm='+no_spm+'&no_sp2d='+no_sp2d+'&kode_unit_subunit='+kode_unit_subunit+'&tgl_sp2d='+tgl_sp2d+'&nominal='+nominal+'&keterangan='+keterangan+'&jenis='+jenis+'&nominal_sp2d='+nominal_sp2d+'&bank='+bank+'&kd_akun_kas='+kd_akun_kas+'&jenis_sp2d='+jenis_sp2d,
							success:function(text_respon){
								// $('#add_sp2d_modal').modal('hide');
								var respon = JSON.parse(text_respon);
								if (respon=="sukses"){
									$('#add_sp2d_modal').modal('hide');
									alert(respon);
									// var new_nominal_belum_sp2d = (parseInt(nominal_belum_sp2d) - parseInt(potongan_lainnya));
									// console.log(parseInt(nominal_belum_sp2d)+' - '+parseInt(potongan_lainnya)+ ' = ' +new_nominal_belum_sp2d);
									console.log('nominal_sp2d = '+nominal);
									if ( nominal == nominal_belum_sp2d) {
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).html('SP2D 100%');
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).prop('disabled', true);
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).removeClass('btn-primary');
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).addClass('btn-success');
									}

									$.ajax({
										type:"POST",
										url:"<?=site_url("rsa_sp2d/cetak_sp2d_retur/")?>"+no_sp2d_encoded,
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
									$('#add_sp2d_modal').modal('hide');
									alert(respon);
									// var new_nominal_belum_sp2d = (parseInt(nominal_belum_sp2d) - parseInt(potongan_lainnya));
									if (nominal == nominal_belum_sp2d) {
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).html('SP2D 100%');
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).prop('disabled', true);
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).removeClass('btn-primary');
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).addClass('btn-success');
									}
									location.reload();
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
				$('#error_nominal_text').html('Tidak dapat melebihi Rp. '+ $('#nominal_belum_sp2d').html() +' !');
				$('#error_nominal').show();
				$('#nominal').css('border','1px solid #bd0808');
				$('#nominal').focus();
			}

		});

		$(".readonly").keydown(function(e){
        	e.preventDefault();
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
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/tambah_sp2d') ?>"><i class="fa fa-plus-circle"></i> <b>Tambah SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d') ?>"><b><i class="fa fa-list"></i> Daftar SP2D</b></a></li>
				<li role="presentation" class="active"><a href="#daftar_sp2d_100" aria-controls="daftar_sp2d_100" role="tab" data-toggle="tab"><b><i class="fa fa-list"></i> Daftar SP2D 100%</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/tambah_retur') ?>"><b><i class="fa fa-plus-circle"></i> Tambah RETUR</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_retur') ?>"><b><i class="fa fa-list"></i> Daftar RETUR</b></a></li>
				<!-- <li role="presentation"><a href="<?php echo site_url('rsa_sp2d/history_sp2d') ?>"><b>Riwayat SP2D</b></a></li> -->
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/sp2d_per_spm') ?>"><b><i class="fa fa-file-text-o"></i> Laporan SP2D per SPM</b></a></li>
			</ul>
		</div>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="daftar_sp2d_100">
		<div class="row">
					<div class="col-lg-12">
						<h2>DAFTAR SP2D 100%</h2> 
					</div>
				</div>
				<hr />

				<div class="row">
					<div class="col-md-12">
		                            
						<form id="kentut" class="form-horizontal">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-1">Tahun : </label>
										<div class="col-md-3">
											<?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'validate[required] form-control','id'=>'tahun'))?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-1">Unit : </label>
										<div class="col-md-6">
											 <select name="unit" id="unit" class="validate[required] form-control">
							                    <!--<option value="">-pilih-</option>-->
							                    <option value="99">99 - [ SEMUA ]</option>
							                    <?php foreach($data_unit as $du): ?>
							                    <option value="<?=$du->kode_unit?>"><?=$du->kode_unit?> - <?=$du->nama_unit?> [ <?=$du->alias?> ]</option>
							                    <?php endforeach; ?>
							                    
							                </select>
										</div>
									</div>
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
												<option value="JAN">Januari</option>
												<option value="FEB">Februari</option>
												<option value="MAR">Maret</option>
												<option value="APR">April</option>
												<option value="MEI">Mei</option>
												<option value="JUN">Juni</option>
												<option value="JUL">Juli</option>
												<option value="AGU">Agustus</option>
												<option value="SEP">September</option>
												<option value="OKT">Oktober</option>
												<option value="NOP">November</option>
												<option value="DES">Desember</option>
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
						<table class="table table-bordered table-striped table-hover small">
							<thead>
							<tr>
								<th class="text-center col-md-1">No</th>
		                  <th class="text-center col-md-3">SPM</th>
		                  <th class="text-center col-md-1">JENIS</th>
								<th class="text-center col-md-2">Tanggal</th>
								<th class="text-center col-md-1">Bruto</th>
								<th class="text-center col-md-1">Pajak</th>
								<th class="text-center col-md-1">Potongan Lainnya</th>
								<th class="text-center col-md-1">Netto</th>
								<th class="text-center col-md-1">Sudah SP2D</th>
								<th class="text-center col-md-1" style="min-width: 150px;">SP2D</th>
							</tr>
							</thead>
							<tbody>
			<?php
				if(!empty($daftar_spm)){
					foreach ($daftar_spm as $key => $value) {
			?>
							<tr>
								<td class="text-center"><?php echo $value->no_urut; ?>.</td>
								<td class="text-center"><a href="javascript:void(0)" data-no-spm="<?php echo $value->str_nomor_trx_spm ?>" class="btn-riwayat"><?php echo $value->str_nomor_trx_spm; ?></a></td>
								<td class="text-center"><?php echo $value->jenis_trx; ?></td>
		                  <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_proses)); ?><br /></td>
		                  <td class="text-right"><?php echo number_format($value->nominal, 0, ",", "."); ?></td>
		                  <td class="text-right"><?php echo number_format($value->pajak, 0, ",", "."); ?></td>
		                  <td class="text-right"><?php echo number_format($value->potongan_lainnya, 0, ",", "."); ?></td>
		                  <td class="text-right"><?php echo number_format($value->netto, 0, ",", "."); ?></td>
		                  <td class="text-right"><?php echo number_format($value->nominal_sudah_sp2d, 0, ",", "."); ?></td>
								<td class="text-center" >
									<div class="btn-group" role="group">
			                  <?php
			                  	$persen_sp2d = ($value->nominal_sudah_sp2d / ($value->nominal-$value->potongan_lainnya)) * 100;
			                  ?>
									<?php if ($persen_sp2d == 100): ?>
										<button class="btn btn-xs btn-success btn-sp2d" disabled>100%</button>
									<?php elseif($value->nominal_sudah_sp2d == 0): ?>
										<button class="btn btn-xs btn-primary btn-sp2d" id="btn_<?php echo $value->id_trx_urut_spm_cair; ?>" data-nominal-cair="<?php echo $value->nominal; ?>" data-jenis="<?php echo $value->jenis_trx; ?>" data-kd-unit="<?php echo $value->kode_unit_subunit; ?>" data-no-spm="<?php echo $value->str_nomor_trx_spm; ?>" data-id_trx_urut_spm_cair="<?php echo $value->id_trx_urut_spm_cair; ?>" data-pajak="<?php echo $value->pajak; ?>" data-netto="<?php echo $value->netto; ?>" data-potongan-lainnya="<?php echo $value->potongan_lainnya; ?>"><i class="glyphicon glyphicon-plus-sign"></i> SP2D</button>
									<?php else: ?>
										<button class="btn btn-xs btn-warning btn-sp2d" id="btn_<?php echo $value->id_trx_urut_spm_cair; ?>" data-nominal-cair="<?php echo $value->nominal; ?>" data-jenis="<?php echo $value->jenis_trx; ?>" data-kd-unit="<?php echo $value->kode_unit_subunit; ?>" data-no-spm="<?php echo $value->str_nomor_trx_spm; ?>" data-id_trx_urut_spm_cair="<?php echo $value->id_trx_urut_spm_cair; ?>" data-pajak="<?php echo $value->pajak; ?>" data-netto="<?php echo $value->netto; ?>" data-potongan-lainnya="<?php echo $value->potongan_lainnya; ?>" ><i class="glyphicon glyphicon-plus-sign"></i> SP2D <?php echo number_format($persen_sp2d, 2, ",", "."); ?>%</button>
									<?php endif ?>
										<button class="btn btn-xs btn-default btn-riwayat" data-no-spm="<?php echo $value->str_nomor_trx_spm; ?>"><i class="fa fa-search"></i></button>
									</div>
								</td>
							</tr>

			<?php
					}
				}else{
			?>
							<tr>
								<td colspan="8" class="text-center alert-warning">
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

<div class="modal fade" id="add_sp2d_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding: 20px;">
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

<div id="div_cetak" style="display: none;"></div>