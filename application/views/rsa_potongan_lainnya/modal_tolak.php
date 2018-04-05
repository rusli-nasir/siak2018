<script>

	$("#reset").click(function(){
			$("#alasan").modal('toggle');
		});

  	$(document).on("submit","#tolak",function(e){
		var no_spm = $("#no_spm").val();
		var ket = $("#ket").val();
		if(ket != "") {
			if(confirm('Anda yakin menyetujui ?')){
				$.ajax({
					type:"POST",
					url:"<?=site_url("rsa_potongan_lainnya/update_status_tolak")?>",
					data:'no_spm='+no_spm+'&ket='+ket,
					success:function(respon){
						if (respon == 'sukses') {
							alert(respon);
							window.location.href = "<?php echo base_url(); ?>index.php/rsa_potongan_lainnya/daftar_potongan_lainnya/<?php echo $kd_unit ?>";
						}else{
							alert(respon);
							window.location.href = "<?php echo base_url(); ?>index.php/rsa_potongan_lainnya/daftar_potongan_lainnya/<?php echo $kd_unit ?>";
						}
					}
				});
			}
		}
    	return false;
  	});
	
</script>

<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-12">
			<h4><b>Konfirmasi</b></h4><hr>
			<div id="temp" style="display:none">
			</div>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active">
					<form id="tolak" >
						<table class="table-condensed">
							<tbody>
								<input type="hidden" class="validate[required]  form-control" value="<?php echo $no_spm ?>" id="no_spm" name="no_spm" >
								<tr>
									<td><b>Alasan Penolakan</b></td>
									<td align="left">
										<textarea rows="4" cols="100" type="text"  class="validate[required] form-control" id="ket" name="ket" required></textarea>
									</td>
								</tr>
								<tr>
									<td align="center" colspan="2" style="text-align: center;">
										<div class="" style="text-align: center;margin: 0px auto;">
											<button type="submit" class="btn btn-primary btn-sm" id="add_tolak" aria-label="Left Align" style="margin-right: 5px;">SIMPAN</button>
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
</div>