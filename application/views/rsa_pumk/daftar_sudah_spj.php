<script>

	$(document).ready(function(){

		$(document).on('change', '.ck', function(){
			if($(this).is(':checked')){
				var value = $(this).attr("rel");
			}
		});

		 $(document).on('change', '.all_ck', function(){
            if($(this).is(':checked')){
                $('.ck:checkbox').each(function() {
                    this.checked = true;                        
                });
            }else{
                $('.ck:checkbox').each(function() {
                    this.checked = false;                        
                });
            }
        });

		$(document).on("click",'.btn-lihat-kuitansi',function(){

            var id = $(this).attr('rel');
            	$.ajax({
						type:"POST",
						url:"<?=site_url("rsa_pumk/daftar_kuitansi_spj")?>",
						data:"id="+id,
						success:function(respon){
							$("#modal_content1").html(respon);
						},
						complete:function(){
							$('#lihat_modal').modal('show');
						}
					});

      });

		$("#terima_spj").click(function(event){
				event.preventDefault();
				var kuitansi = $(".ck:checkbox:checked").map(function(){
					return $(this).attr("rel");
			    }).get(); // <----
				var data = "data="+kuitansi;
			if (confirm("yakin mensetujui SPJ dengan id"+data+"?")) {
				$.ajax({
					type:"POST",
					url:"<?=site_url("rsa_pumk/terima_spj")?>",
					data:data,
					success:function(respon){
						 if(respon.valid = true){
			          		bootbox.alert({
									title: "Sedah DIsetuji",
								    message: "SPJ TELAH DISETUJI",
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


		$("#tolak_spj").click(function(event){
				event.preventDefault();
				var kuitansi = $(".ck:checkbox:checked").map(function(){
					return $(this).attr("rel");
			    }).get(); // <----
				var data = "data="+kuitansi;
			if (confirm("yakin menolak SPJ dengan id"+data+"?")) {
				$.ajax({
					type:"POST",
					url:"<?=site_url("rsa_pumk/tolak_spj")?>",
					data:data,
					success:function(respon){
						 if(respon.valid = true){
			          		bootbox.alert({
									title: "Sedah Ditolak",
								    message: "SPJ TELAH DITOLAK",
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

		function string_to_angka(str){
			return str.split('.').join("");
		}

		function angka_to_string(num){
			var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			return str_hasil;
		}
		
	});

</script>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<div>
					<h2>DAFTAR KUITANSI SUDAH SPJ</h2><hr>
				</br>
				<table class="table table-bordered table-striped small"  style="" >
					<thead>
						<tr>
							<td align="right" colspan="11">
								<div class="btn-group " >
									<button type="button" class="btn btn-success btn-sm" id="terima_spj" aria-label="Left Align" style="margin-right: 5px;">TERIMA SPJ</button>
									<button type="button" class="btn btn-danger btn-sm" id="tolak_spj" aria-label="Left Align" style="margin-right: 5px;">TOLAK SPJ</button>
								</div>
							</td>
						</tr>
						<tr>
							<th colspan="11" class="text-center alert-success">DAFTAR SPJ</th>
						</tr>
						<tr>
							<th class="text-center " style="vertical-align: middle;">No</th>
							<th class="text-center col-md-1" style="vertical-align: middle;">ID SPJ</th>
							<th class="text-center " style="vertical-align: middle;">Unit</th>
							<th class="text-center col-md-1" style="vertical-align: middle;">Kuitansi</th>
							<th class="text-center col-md-2" style="vertical-align: middle;">Tanggal SPJ</th>
							<th class="text-center col-md-2" style="vertical-align: middle;">Nama PUMK</th>
							<th class="text-center col-md-1" style="vertical-align: middle;">NIP PUMK</th>
							<th class="text-center " style="vertical-align: middle;">&nbsp;</th>
							<th class="text-center col-md-1" style="vertical-align: middle;">Status</th>
							<!--<th class="text-center col-md-1">Proses</th>-->
							<th class="text-center col-md-1">
								<div class="input-group">
									<span class="input-group-addon" style="background-color: #f9ff83;"> 
										<input type="checkbox" aria-label="" rel="" class="all_ck">
									</span>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						
						<?php foreach ($daftar_sudah_spj as $key => $value): ?>
							<tr>
								<td class="text-center"><?php echo $key + 1; ?>.</td>
								<td class="text-center"><?php echo $value->id; ?></td>
								<td class="text-center"><?php echo $value->kode_unit; ?></td>
								<td class="text-center"><?php echo $value->kuitansi; ?></td>
								<td class="text-center" ><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_spj)); ?><br /></td>
								<td class="text-center" id=""><?php echo $value->nm_pumk; ?></td>
								<td class="text-center">
									<?php echo $value->nip_pumk; //number_format($value->pengeluaran, 0, ",", "."); ?>
								</td>
								<td class="text-center">
									<div class="btn-group">
										<button  class="btn btn-default btn-sm btn-lihat-kuitansi" rel="<?php echo $value->id; ?>" ><i class="glyphicon glyphicon-search"></i></button>
									</div>
								</td>
								<td class="text-center">
									<?php if ($value->proses == 2): ?>
										<span class="label label-danger" >SUDAH DISETUJI</span> 
									<?php elseif($value->proses == 1): ?>
										<span class="label label-success ">BELUM</span>
									<?php endif ?>									
								</td>
								<td class="text-center">
									<div class="input-group">
										<span class="input-group-addon">
											<?php if ($value->proses == 2): ?>
												<input type="checkbox" aria-label="" rel="" class="" id="" disabled>
											<?php elseif($value->proses == 1): ?>
												<input type="checkbox" aria-label="" rel="<?=$value->id?>" class="ck" id="ck_<?=$value->id?>">
											<?php endif ?>
										</span>
									</div>
								</td>
							</tr>
						</tbody>
					<?php endforeach ?>
				</table>

				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="lihat_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="margin-top: 80px;">
		<div class="modal-content" id="modal_content1">
		</div>
	</div>
</div>
