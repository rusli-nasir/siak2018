<script>
	$('#tgl_spj').datepicker({
			format: "yyyy-mm-dd"
	});

	$("#reset").click(function(){
			$("#lihat_modal").modal('toggle');
		});

	$(document).on("click","#add_modal",function(){
		if($("#form_spj").validationEngine("validate")){
	           $("#form_spj").submit();            
		}
    	
  	});
	
</script>

<div class="row">
	<div class="col-lg-12">
		<h4><b>Tambah SPJ PUMK</b></h4><hr>
		<div id="temp" style="display:none">
		</div>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active">
					<form id="form_spj" method="post" action="<?=site_url("rsa_pumk/exec_add_spj_pumk")?>">
						<table class="table-condensed">
							<tbody>
								<tr>
									<td><b>Id Kuitansi</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control" value="<?php echo $kuitansi ?>" id="kuitansi" name="kuitansi" readonly="readonly" >
									</td>
								</tr>
								<tr>
									<td class="col-md-2"><b>Tanggal SPJ</b></td>
									<td align="left">
										<div class="input-group">
											<label class="input-group-addon btn" for="tgl_spj">
												&nbsp;<span class="glyphicon glyphicon-calendar"></span>
											</label>  
											<input type="text" class="validate[required] form-control readonly" id="tgl_spj" name="tgl_spj" required>
										</div>
									</td>
								</tr>
								<tr>
									<td><b>Keterangan</b></td>
									<td align="left">
										<textarea rows="4" cols="50" type="text"  class="validate[required] form-control" id="keterangan" name="keterangan" value=""></textarea>
									</td>
								</tr>
								<tr>
									<td align="left" colspan="2">
										<div class="btn-group " >
											<button type="button" class="btn btn-primary btn-sm" id="add_modal" aria-label="Left Align" style="margin-right: 5px;">SIMPAN</button>
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