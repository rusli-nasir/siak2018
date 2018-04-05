<script>

	$("#reset").click(function(){
			$("#alasan").modal('toggle');
		});

	$(document).on("click","#add_tolak",function(e){

		var nomor_sspb = $("#nomor_sspb").val();
		var nomor_trx_spm = $("#nomor_spm").val();
		var ket = $("#ket").val();
		e.preventDefault();
		if(confirm('Anda yakin menolak SSPB ?')){
			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_sspb/update_status_tolak")?>",
				data:'nomor_sspb='+nomor_sspb+'&nomor_trx_spm='+nomor_trx_spm+'&ket='+ket,
				success:function(respon){
					if(respon == "true"){
						window.location.reload();
					}else if(respon == "false"){
						bootbox.alert({
							title: " <span style='color: red;'>PERHATIAN !!",
							message: "GAGAL",
							callback: function(){ 
								window.location.reload();
							}
						});
					}

				}
			});
		}
		return false;

	});
	
</script>

<div class="container-fluid">
	<div class="col-lg-12">
		<h4><b>Konfirmasi</b></h4><hr>
		<div id="temp" style="display:none">
		</div>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active">
				<form id="tolak" >
					<table class="table-condensed">
						<tbody>
							<input type="hidden" class="validate[required]  form-control" value="<?php echo $nomor_sspb ?>" id="nomor_sspb" name="nomor_sspb"  >
							<input type="hidden" class="validate[required]  form-control" value="<?php echo $nomor_spm ?>" id="nomor_spm" name="nomor_spm" >
							<tr>
								<td><b>Alasan Penolakan</b></td>
								<td align="left">
									<textarea rows="4" cols="100" type="text"  class="validate[required] form-control" id="ket" name="ket" value=""></textarea>
								</td>
							</tr>
							<tr>
								<td align="right" colspan="2" style="text-align: right;">
									<div class="alert alert-danger" style="text-align: center;">
										<button type="button" class="btn btn-primary btn-sm" id="add_tolak" aria-label="Left Align" style="margin-right: 5px;">SIMPAN</button>
										<button type="reset" class="btn btn-warning btn-sm" id="reset" aria-label="Center Align">BATAL</button>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>