<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker.css" rel="stylesheet">

<script type="text/javascript">
	$(document).ready(function(){
		$('#tgl_sp2d').datepicker({
			format: "yyyy-mm-dd"
		});

		$(document).on("click","#pilih_tahun",function(){
//                        if($("#form_dpa").validationEngine("validate")){
//                            var sumber_dana = $('#sumber_dana').val();
                            window.location = "<?=site_url("rsa_sp2d/tambah_sp2d/")?>" + $("#tahun").val() + '/' + $("#unit").val() + '/' + $("#jenis").val()  ;

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

		$(document).on("click",".btn-sp2d",function(){
			var no_spm = $(this).attr('data-no-spm');
			var kode_unit_subunit = $(this).attr('data-kd-unit');
			var jenis = $(this).attr('data-jenis');
			var nominal_cair = $(this).attr('data-nominal-cair');

			$('#id_trx_urut_spm_cair').val($(this).attr('data-id_trx_urut_spm_cair'));

			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_sp2d/get_nominal_sp2d")?>",
				data:'no_spm='+no_spm+'&kode_unit_subunit='+kode_unit_subunit+'&jenis='+jenis,
				success:function(data){
					var res = JSON.parse(data);
					var item = res.nominal_sp2d;
					var no_sp2d = res.new_no_sp2d;

					var nominal_sp2d = parseInt(item);
					var nominal_belum_sp2d = parseInt(nominal_cair) - parseInt(nominal_sp2d);
					
					$('#kode_unit_subunit').val(kode_unit_subunit);
					$('#new_no_sp2d').val(no_sp2d);
					$('#nominal_belum_sp2d').html(angka_to_string(nominal_belum_sp2d));
					$('#nominal_sp2d').val(nominal_sp2d);
					$('#nominal').val(angka_to_string(nominal_belum_sp2d));
					$('#jenis_trx').val(jenis);
					$('#no_spm').val(no_spm);
					$('#add_sp2d_modal').modal('show');
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
			$('#nominal_belum_sp2d').html('');
			$('#error_nominal').hide();
			$('#nominal').css('border','1px solid #ccc');
			$('#id_trx_urut_spm_cair').val('');
			// alert('ads');
		});

		$(document).on("submit","#form_sp2d",function(e){
			// alert(string_to_angka($('#nominal').val()));
			var data=$("#form_sp2d").serialize();

			var kode_unit_subunit = $('#kode_unit_subunit').val();
			var jenis = $('#jenis_trx').val();
			var no_spm = $('#no_spm').val();
			var no_sp2d = $('#new_no_sp2d').val();
			var tgl_sp2d = $('#tgl_sp2d').val();
			var nominal = string_to_angka($('#nominal').val());
			var keterangan = $('#keterangan').val();
			var nominal_sp2d = $('#nominal_sp2d').val();
			var nominal_belum_sp2d = parseInt(string_to_angka($('#nominal_belum_sp2d').html()));

			if (nominal <= nominal_belum_sp2d) {
				if (nominal > 0) {
					if($("#form_sp2d").validationEngine("validate")){
						$.ajax({
							type:"POST",
							url:"<?=site_url("rsa_sp2d/add_sp2d")?>",
							data:'no_spm='+no_spm+'&no_sp2d='+no_sp2d+'&kode_unit_subunit='+kode_unit_subunit+'&tgl_sp2d='+tgl_sp2d+'&nominal='+nominal+'&keterangan='+keterangan+'&jenis='+jenis+'&nominal_sp2d='+nominal_sp2d,
							success:function(respon){
								// $('#add_sp2d_modal').modal('hide');
								if (respon=="sukses"){
									$('#add_sp2d_modal').modal('hide');
									alert(respon);
									if (nominal == nominal_belum_sp2d) {
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).html('<button class="btn btn-xs btn-success btn-sp2d" disabled>SP2D 100%</button>');
									}
								} else {
									$('#add_sp2d_modal').modal('hide');
									alert(respon);
									if (nominal == nominal_belum_sp2d) {
										$('#btn_'+$('#id_trx_urut_spm_cair').val()).html('<button class="btn btn-xs btn-success btn-sp2d" disabled>SP2D 100%</button>');
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
				$('#error_nominal_text').html('Tidak dapat melebihi Rp. '+ $('#nominal_belum_sp2d').html() +' !');
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

</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->

		<div class="tab-base">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tambah_sp2d" aria-controls="tambah_sp2d" role="tab" data-toggle="tab"><b>Tambah SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d') ?>#daftar_sp2d"><b>Daftar SP2D</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d') ?>#retur"><b>Retur</b></a></li>
				<li role="presentation"><a href="<?php echo site_url('rsa_sp2d/daftar_sp2d') ?>#daftar_retur"><b>Daftar RETUR</b></a></li>
			</ul>
		</div>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="tambah_sp2d">
		<div class="row">
					<div class="col-lg-12">
						<h2>TAMBAH SP2D</h2> 
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
				<div class="alert alert-info"><span class="text-warning"><b>Filter : </b></span> <b>Tahun [ <span class="text-danger"><b><?=$cur_tahun?></b></span> ] Unit [ <span class="text-danger"><b><?=$kode_unit_subunit?></b></span> ] Jenis [ <span class="text-danger"><b><?=$jenis?></b></span> ]</b></div>
				</div>

					<div class="col-md-12 table-responsive">
						<table class="table table-bordered table-striped table-hover small">
							<thead>
							<tr>
								<th class="text-center col-md-1">No</th>
		                  <th class="text-center col-md-2">SPP</th>
		                  <th class="text-center col-md-2">SPM</th>
		                  <th class="text-center col-md-1">JENIS</th>
								<th class="text-center col-md-2">Tanggal</th>
								<th class="text-center col-md-1">Nominal</th>
								<th class="text-center col-md-1">SP2D</th>
							</tr>
							</thead>
							<tbody>
			<?php
				if(!empty($daftar_spm)){
					foreach ($daftar_spm as $key => $value) {
			?>
							<tr>
								<td class="text-center"><?php echo $value->no_urut; ?>.</td>
								<td class="text-center"><?php echo $value->str_nomor_trx_spp; ?> <?php echo isset($value->alias_spp)&&($value->alias_spp!='-')?'<span class="text-danger">( '.$value->alias_spp.' )</span>':'' ; ?></td>
								<td class="text-center"><?php echo $value->str_nomor_trx_spm; ?> <?php echo isset($value->alias_spm)&&($value->alias_spm!='-')?'<span class="text-danger">( '.$value->alias_spm.' )</span>':'' ; ?></td>
								<td class="text-center"><?php echo $value->jenis_trx; ?></td>
		                  <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_proses)); ?><br /></td>
		                  <td class="text-right"><?php echo number_format($value->nominal, 0, ",", "."); ?></td>

								<?php if ($value->nominal_sudah_sp2d == $value->nominal): ?>
									<td class="text-center" id="btn_<?php echo $value->id_trx_urut_spm_cair; ?>"><button class="btn btn-xs btn-success btn-sp2d" disabled>SP2D 100%</button></td>
								<?php else: ?>
									<td class="text-center" id="btn_<?php echo $value->id_trx_urut_spm_cair; ?>"><button class="btn btn-xs btn-primary btn-sp2d" data-nominal-cair="<?php echo $value->nominal; ?>" data-jenis="<?php echo $value->jenis_trx; ?>" data-kd-unit="<?php echo $value->kode_unit_subunit; ?>" data-no-spm="<?php echo $value->str_nomor_trx_spm; ?>" data-id_trx_urut_spm_cair="<?php echo $value->id_trx_urut_spm_cair; ?>"><i class="glyphicon glyphicon-plus-sign"></i> SP2D</button></td>
								<?php endif ?>
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
								<td colspan="8" >&nbsp;</td>
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

<div class="modal fade" id="add_sp2d_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="modal_content">

			<form id="form_sp2d" onsubmit="return false">
				<input type="hidden" id="kode_unit_subunit" name="kode_unit_subunit" required>
				<input type="hidden" id="jenis_trx" name="jenis" required>
				<input type="hidden" id="nominal_sp2d" name="nominal_sp2d" required>

				<input type="hidden" id="id_trx_urut_spm_cair">

				<div class="modal-header blue-gradient text-white">
					<button type="button" class="close" data-dismiss="modal" style="color: #fff;opacity: 1;">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title text-center" id="myModalLabel">
						<b style="color:#fff;">Formulir Tambah SP2D</b>
					</h4>
				</div>

				<div class="modal-body">
					
					<table class="table-condensed" style="margin: auto;width: 70%;">
						<tbody>
							<tr>
								<td align="left">
									<span><b>No. SPM</b></span>
									<input type="text" class="validate[required] form-control text-center" id="no_spm" name="no_spm" value="" DISABLED required>
								</td>
							</tr>
							<tr>
								<td align="left">
									<span><b>No. SP2D</b></span>
									<input type="text" class="validate[required] form-control text-center" id="new_no_sp2d" name="no_sp2d" value="" readonly>
								</td>
							</tr>
							<tr>
								<td align="left">
									<span><b>Tanggal SP2D</b></span>
									<div class="input-group">
										<label class="input-group-addon btn" for="tgl_sp2d">
											&nbsp;<span class="glyphicon glyphicon-calendar"></span>
										</label>  
										<input type="text" class="validate[required] form-control readonly text-center" id="tgl_sp2d" name="tgl_sp2d" placeholder="Tanggal SP2D" required>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<br>
					<div class="col-md-6">
						<h4 class="text-center">Bank 1</h4>
						<table class="table-condensed" style="margin: auto;width: 100%;">
							<tbody>
								<tr>
									<td align="left">
										<div class="input-group">
											<label class="input-group-addon btn" for="bank_1">
												&nbsp;<span><i class="fa fa-university"></i></span>
											</label>
											<input type="text" class="validate[required] form-control" id="bank_1" name="bank_1" placeholder="Bank" required>
										</div>
									</td>
								</tr>
								<tr>
									<td align="left">
										<div class="input-group">
											<label class="input-group-addon btn" for="rek_1">
												&nbsp;<span><i class="fa fa-credit-card"></i></span>
											</label>
											<input type="text" class="validate[required] form-control" id="rek_1" name="rek_1" placeholder="Rekening" required>
										</div>
									</td>
								</tr>
								<tr>
									<td align="left">
										<div class="input-group">
											<label class="input-group-addon btn" for="nominal">
												<span><b>Rp</b></span>
											</label>
											<input type="text" class="validate[required] form-control xnumber" id="nominal" name="nominal" placeholder="Nominal" required>
										</div>
									</td>
								</tr>
								<tr id="error_nominal" style="display: none;">
									<td align="left" class="text-danger" style="font-size: 12px;padding: 0px 5px 0px 5px;">
										<b><span id="error_nominal_text" class="alert alert-danger" style="padding: 5px;"></span></b>
									</td>
								</tr>
								<tr>
									<td align="left" class="text-info" style="font-size: 12px;padding: 0px;">
										&nbsp;&nbsp;Nominal yang belum SP2D : 
										<b>Rp. <span id="nominal_belum_sp2d" style="display: inline;width: auto;"></span></b>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-6" style="border-left: 1px solid #ddd;margin-bottom: 30px;">
						<h4 class="text-center">Bank 2</h4>
						<table class="table-condensed" style="margin: auto;width: 100%;">
							<tbody>
								<tr>
									<td align="left">
										<div class="input-group">
											<label class="input-group-addon btn" for="bank_2">
												&nbsp;<span><i class="fa fa-university"></i></span>
											</label>
											<input type="text" class="validate[required] form-control" id="bank_2" name="bank_2" placeholder="Bank" required>
										</div>
									</td>
								</tr>
								<tr>
									<td align="left">
										<div class="input-group">
											<label class="input-group-addon btn" for="rek_2">
												&nbsp;<span><i class="fa fa-credit-card"></i></span>
											</label>
											<input type="text" class="validate[required] form-control" id="rek_2" name="rek_2" placeholder="Rekening" required>
										</div>
									</td>
								</tr>
								<tr>
									<td align="left">
										<div class="input-group">
											<label class="input-group-addon btn" for="nominal_2">
												<span><b>Rp</b></span>
											</label>
											<input type="text" class="validate[required] form-control xnumber" id="nominal_2" name="nominal_2" placeholder="Nominal" required>
										</div>
									</td>
								</tr>
								<tr id="error_nominal" style="display: none;">
									<td align="left" class="text-danger" style="font-size: 12px;padding: 0px 5px 0px 5px;">
										<b><span id="error_nominal_text" class="alert alert-danger" style="padding: 5px;"></span></b>
									</td>
								</tr>
								<tr>
									<td align="left" class="text-info" style="font-size: 12px;padding: 0px;">
										&nbsp;&nbsp;Nominal yang belum SP2D : 
										<b>Rp. <span id="nominal_belum_sp2d" style="display: inline;width: auto;"></span></b>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<table class="table-condensed" style="margin: auto;width: 70%;">
						<tbody>
							<tr>
								<td><b>Keterangan</b></td>
								<td><b>:</b></td>
								<td align="left">
									<!-- <span style="font-size: 11px;">*Jika tidak ada keterangan yang ingin ditambahkan, isi dengan tanda ( - ) demi keseragaman</span> -->
									<textarea class="form-control" id="keterangan" name="keterangan" cols="50" rows="3" style="resize:vertical;"></textarea>
								</td>
							</tr>
						</tbody>
					</table>
					
				</div>

				<div class="modal-footer">
					<button type="reset" id="close_sp2d" class="btn btn-default cancel btn-sm" aria-label="Center Align" data-dismiss="modal">
						Batal
					</button>
					<button type="submit" class="btn btn-primary submit btn-sm" aria-label="Left Align" >
						Simpan
					</button>
				</div>
			</form>

		</div>
	</div>
</div>