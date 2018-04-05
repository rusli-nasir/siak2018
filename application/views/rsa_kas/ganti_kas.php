<script>
	$(document).ready(function(){


	$("#no_spm").change(function() {
		var isi = $(this).val();
			set_isi_kas(isi);
	});

		function set_isi_kas(no_spm){
			var data = "no_spm="+no_spm;
			$.ajax({
				type:"POST",
				url:"<?=site_url('rsa_kas/get_isi_kas')?>",
				data:data,
				success:function(respon){
					$("#kd_akun").html(respon);
				}
			});
		}

	$(document).on("click","#add",function(){
		if($("#form_ganti_kas").validationEngine("validate")){
		   $("#form_ganti_kas").submit();
	
	   }
   });

   $(document).on("click","#keluar",function(){
		
		   $('#lihat_modal').modal("hide");
	
	   
   });


	});


</script>

<h3 style="padding-left: 25px;padding-right: 25px;"><b>GANTI AKUN KAS</b></h3><hr>
<div class="row">
	<div class="col-lg-12">
		<div id="temp" style="display:none">
		</div>
		<div class="tab-content">
			<form id="form_ganti_kas" method="post" action="<?=site_url("rsa_kas/exec_add_ganti_kas")?>" style="padding-left: 25px;padding-right: 25px;">
						<table class="table-condensed">
							<tbody>
								<tr>
									<td><b>SPM</b></td>
									<td align="left">
										<select style="min-width: 617px;" class="validate[required] form-control" name="no_spm" id="no_spm">
											<option value="" disabled="disabled" selected="selected">- pilih -</option>
										<?php foreach ($opt_spm as $key => $value): ?>
											<?php if( substr($value['no_spm'],0,1) != "-"){ ?>
											<option id="" value="<?php echo $value['no_spm'] ?>">
												<?php echo $value['no_spm'] ?>
											</option>
											<?php } ?>
										<?php endforeach ?>
										</select>
									</td>
								</tr>
							</tbody>	
							<tbody id="kd_akun">
								<tr>
									<td class="col-md-2"><b>Kode Akun Kas</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control"  id="kd_akun_kas_1" name="kd_akun_kas_1" >
									</td>
								</tr>
								<tr>
									<td class="col-md-2"><b>Deskripsi</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control"  id="deskripsi" name="deskripsi" >
									</td>
								</tr>
								<tr>
									<td class="col-md-2"><b>Kode Unit</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control"  id="kd_unit" name="kd_unit" >
									</td>
								</tr>
								<tr>
									<td class="col-md-2"><b>Kredit</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control"  id="kredit_awal" name="kredit_awal" >
									</td>
								</tr>
							</tbody>
							<tbody>
								<tr>
									<td class="col-md-2"><b style="color: red;">PINDAH KE</b></td>
									<td align="left">
										
									</td>
								</tr>
								<tr>
									<td class="col-md-2"><b>Akun Kas Ganti</b></td>
									<td align="left">
										<select style="min-width: 617px;" class="validate[required] form-control" name="kd_akun_kas_2" id="kd_akun_kas_2">
											<option value="" disabled="disabled" selected="selected">- pilih -</option>
										<?php foreach ($opt_kd_akun_kas as $key => $value): ?>
											<option id="" value="<?php echo $value['kd_akun_kas'] ?>">
												<?php echo $value['kd_akun_kas'] ?>
											</option>
										<?php endforeach ?>
										</select>
									</td>
								</tr>
								<tr>
									<td class="">&nbsp;</td>
									<td align="left"  >
										<div class="alert alert-warning">
										<div class="btn-group" >
											<button type="button" class="btn btn-primary btn-sm" id="add" aria-label="Left Align" style="margin-right: 5px;">SIMPAN</button>
											<button type="button" class="btn btn-warning btn-sm" id="keluar" aria-label="Center Align">KELUAR</button>
										</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
		</div>
	</div>
</div>