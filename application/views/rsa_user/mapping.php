<script type="text/javascript">
var status_edit = true;

$(document).ready(function(){


	$(document).on("click","#reset_form_verifikator",function(e){
		$('#form_verifikator').validationEngine('hide');
    });


	$(document).on("submit","#form_verifikator",function(e){
      var aksi = $(this).attr('data-aksi');
      var verifikator = $('#nama_verifikator').val();
      var unit = $('#unit_verifikator').val();
      // alert(aksi);
      // if (aksi == 'tambah') {
      // 	tambah_verifikator();
      // }
  		e.preventDefault();
          //<---- stop submiting the forms
     $.ajax({
         type: "POST",
         url: "<?=site_url("user/is_verifikator")?>",
         dataType: "json",
         data: "verifikator="+verifikator+"&unit="+unit,   
         // data: { "email": email, "password": password },                      
         success: function(data){

         		edit_verifikator();
         }
     	});
    });

	

	function edit_verifikator(){
		var data= $("#form_verifikator").serialize();
		if($("#form_verifikator").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url:"<?=site_url("user/exec_verifikator")?>",
				data:data,
				success:function(respon){
					if (respon=="berhasil"){
						//refresh_row();
						//redirect('user/daftar_user','refresh');    
						bootbox.alert({
							title: "Konfirmasi",
						    message: "Mapping Berhasil Disimpan",
						    animate: false,
						    callback: function(){ 
						        window.location.reload();
						    }
						});
					} else {
						var r = respon;
						while (r.search(/<[^>]*>/)!=-1){
							r = r.replace(/<[^>]*>/,'');
						}
						alert(r);
					}
				}
			});
		}
	}

	$(document).on("click",".delete_verifikator",function(){
		var data = $(this).val();
		var id = $(this).attr('rel');

	    if (confirm("Apakah yakin menghapus?")) {
	       $.ajax({
				type:"POST",
				url:"<?=site_url("user/exec_verifikator_delete")?>",
				data:"unit="+data,
				success:function(respon){
					if (respon=="berhasil"){
						//refresh_row();
						//redirect('user/daftar_user','refresh'); 

						// $('#tr_'+id).remove();

						bootbox.alert({
							title: "Konfirmasi",
						    message: "Mapping Berhasil Dihapus",
						    animate: false,
						    callback: function(){ 
						        window.location.reload();
						    }
						});

						 

					} else {
						var r = respon;
						while (r.search(/<[^>]*>/)!=-1){
							r = r.replace(/<[^>]*>/,'');
						}
						alert(r);
					}
				}
			});
	    }
	    return false;	
    });


});





//action untuk membatalkan pengubahan data


</script>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<div>
					<h2>MAPPING VERIFIKATOR</h2><hr>

					<!-- Nav tabs -->



					</br>
					<div class="col-md-12" style="margin-bottom: 30px;">
						<form id="form_verifikator" onsubmit="return false" data-aksi="tambah">
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<table class="table-condensed">
									<tr>
										<td class="col-md-2"><b>Verifikator</b></td>
										<td align="left">
											<select style="min-width: 617px;" class="validate[required] form-control" name="nama_verifikator" id="nama_verifikator" >
												<option id="" value="">
													- Pilih Verifikator -
												</option>
												<?php foreach ($opt_verifikator as $key => $value): ?>
													<option id="" value="<?php echo $value->id ?>">
														<?php echo $value->username ?> - <?php echo $value->nm_lengkap ?>
													</option>
												<?php endforeach ?>
											</select>
										</td>
									</tr>							
									<tr>
										<td class="col-md-2" ><b>Unit</b></td>
										<td align="left">
											<select class="validate[required] form-control" name="unit_verifikator" id="unit_verifikator" data-aksi="tambah">
												<option id="" value="">
													- Pilih Unit -
												</option>
												<?php foreach ($opt_unit_verifikator as $key => $value): ?>
													<option id="" value="<?php echo $value['id'] ?>">
														<?php echo $value['nama'] ?>
													</option>
												<?php endforeach ?>
											</select>
										</td>
									</tr>				
									<tr>
										<td align="left" colspan="2">
											<div class="btn-group">
												<button type="submit" class="btn btn-primary btn-sm" id="add" aria-label="Left Align" style="margin-right: 5px;">SIMPAN</button>
												<button type="reset" class="btn btn-warning btn-sm" id="reset_form_verifikator" aria-label="Center Align">RESET</button>
											</div>
										</td>
									</tr>
								</table>
							</div>
							<div class="col-md-1"></div>	
						</form>
					</div>
				<table class="table table-strip">
					<thead>
						<tr class="blue-gradient" style="color: white;" >
								<!-- <th class="col-md-1">ID User Verifikator</th> -->
								<th class="col-md-3">Nama Lengkap</th>
								<!-- <th class="col-md-2">NIP</th> -->
								<th class="col-md-2">Username</th>
								<th class="col-md-5">Nama Unit</th>
								<th class="col-md-1" style="text-align: center;">Alias</th>
								<!-- <th class="col-md-1" style="text-align: center;">Aktif</th> -->
								<th class="col-md-1" style="text-align: center;">Aksi</th>
							</tr>
						</thead>
						<tbody id="row_space">
							
							<?php $username_tmp = '';$color_tmp = '#f9f9f9';
							foreach ($user_verifikator as $n => $verifikator): ?>
							<?php 
								if (substr($verifikator->alias,0,1) == 'F') {
									$color_alias = "primary";
								}elseif (substr($verifikator->alias,0,1) == 'W') {
									$color_alias = "danger";
								}elseif (substr($verifikator->nama_unit,0,7) == 'SEKOLAH') {
									$color_alias = "warning";
								}else{
									$color_alias = "success";
								}
							 ?>
							<?php
								if ($verifikator->username != $username_tmp) {
									if ($color_tmp == '#f9f9f9') {
										$color_tmp='#fffff';
									}else{
										$color_tmp = '#f9f9f9';
									}
								}else{
									$color_tmp = $color_tmp;
								}
							?>
							<tr style="background-color: <?php echo $color_tmp ?>;" id="tr_<?=$n?>">
<!-- 								<td>
									<?php if ($verifikator->username != $username_tmp): ?>
										<?php echo $verifikator->id ?>
									<?php endif ?>	
								</td> -->
								<td>
									<?php if ($verifikator->username != $username_tmp): ?>
										<?php echo $verifikator->nm_lengkap ?>
									<?php endif ?>	
								</td>
								<!--
								<td>
									<?php if ($verifikator->username != $username_tmp): ?>
										<?php echo $verifikator->nomor_induk ?>
									<?php endif ?>	
								</td>
								-->
								<td>
									<?php if ($verifikator->username != $username_tmp): ?>
										<?php echo $verifikator->username ?>
									<?php endif ?>	
								</td>
								<td><b><?php echo $verifikator->nama_unit ?></b></td>
								<td class="text-center"><span style="font-size: small;" class="label label-<?php echo $color_alias ?>"><?php echo $verifikator->alias ?></span></td>
								<!-- <td class="text-center"><?php echo $verifikator->flag_aktif ?></td> -->
								<td>
								<button type="button" class="delete_verifikator btn btn-danger btn-sm" rel="<?=$n?>" value="<?php echo $verifikator->id_verifikator_unit ?>" id="delete_verifikator_<?php echo $verifikator->id_verifikator_unit ?>" aria-label="Center Align">DELETE</button>
								</td>
							</tr>
							<?php $username_tmp = $verifikator->username ?>
							<?php endforeach ?>

						</tbody>
					</table>

		</div>
	</div>
</div>
</div>
</div>

