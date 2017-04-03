<script type="text/javascript">
	$(document).ready(function(){
<?php
	$_dsb = "";
	if(isset($cur_tahun) && strlen(trim($cur_tahun))==4){
		$_dsb = " disabled = \"disabled\"";
?>
		$('#kentut').on('submit',function(e){
			e.preventDefault();
			var data = $('#kentut #tahun').val();
			window.location='<?php echo site_url('Rsa_lsphk3/daftar_spm')."/tahun/"; ?>'+data;
		});
		$('#kentut .pilih_tahun').on('click',function(e){
			e.preventDefault();
			var data = $('#kentut #tahun').val();
			if(data.length == 0){
				$('#myModalMsg .body-msg-text').html('<p class="alert alert-warning">Pilih tahun SPP LS Pegawai yang ada, atau buat SPP terlebih dahulu.</p>');
				$('#myModalMsg').modal('show');
				return false;
			}
			$('#kentut').submit();
		});
<?php
	}
?>
		$('.kirimppk').on('click',function(e){
			e.preventDefault();
			var a=confirm('Yakin kirim pengajuan SPP LS-Pegawai ini ke PPK SUKPA?');
			if(a){
				var id_sppls = $(this).attr('id');
	      var proses = $(this).attr('rel');
	      var data = "id_sppls=" + id_sppls + "&proses=" + proses;

	      $.ajax({
	          type:"POST",
	          url :"<?=site_url("Rsa_lsphk3/spp_to_spm")?>",
	          data:data,
	          success:function(data){
	              if(data == '1'){
	                  window.location.reload();
	              }else{
	              	$('#myModalMsg .body-msg-text').html(data);
									$('#myModalMsg').modal('show');
	              }
	          }
	      });
	    }
		});
		$('.yes').on('click',function(e){
			e.preventDefault();
			var a=confirm('Yakin setujui SPP yang dikirim Bendahara?');
			if(a){
				var id_sppls = $(this).attr('id');
	      var proses = $(this).attr('rel');
	      var data = "id_sppls=" + id_sppls + "&proses=" + proses;

	      $.ajax({
	          type:"POST",
	          url :"<?=site_url("tor/spp_to_spm")?>",
	          data:data,
	          success:function(data){
	              if(data == '1'){
	                  window.location.reload();
	              }else{
	              	$('#myModalMsg .body-msg-text').html(data);
									$('#myModalMsg').modal('show');
	              }
	          }
	      });
	    }
		});
		$('.no').on('click',function(e){
			e.preventDefault();
			$('#alasan_nolak #id_sppls').val($(this).attr('id'));
			$('#alasan_nolak #proses').val($(this).attr('rel'));
			$('#myModalMessage').modal('show');
		});
		$('.lihat').on('click', function(e){
			e.preventDefault();
			window.location = '<?php echo site_url("tor/sppLS"); ?>/id/'+$(this).attr('id');
		});
		$('#alasan_nolak').on('submit',function(e){
			e.preventDefault();
			if($('#alasan_nolak #alasan_tolak').val().length==0){
				$('#myModalMsg .body-msg-text').html('<p class="alert alert-danger text-center">Masukkan alasan penolakan!</p>');
				$('#myModalMsg').modal('show');
				return false;
			}
			var data = $('#alasan_nolak').serialize();
			$.ajax({
        type:"POST",
        url :"<?=site_url("tor/spp_to_spm")?>",
        data:data,
        success:function(data){
          if(data == '1'){
            window.location.reload();
          }else{
          	$('#myModalMsg .body-msg-text').html(data);
						$('#myModalMsg').modal('show');
          }
        }
      });
		});
		$('.tolak_mentah2').on('click',function(e){
			e.preventDefault();
			$('#alasan_nolak').submit();
		});
		$('.histori').on('click',function(e){
			e.preventDefault();
			var id_sppls = $(this).attr('id');
      var data = "id_sppls=" + id_sppls;
			$.ajax({
        type:"POST",
        url :"<?=site_url("tor/spp_tolak_detail")?>",
        data:data,
        success:function(data){
        	$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
        }
      });
		});
		$('.buat-spm').on('click',function(e){
			e.preventDefault();
			var id_sppls = $(this).attr('id');
      var data = "id_sppls=" + id_sppls;
      var proses = $(this).attr('rel');
      var data = "id_sppls=" + id_sppls + "&proses=" + proses;
			$.ajax({
        type:"POST",
        url :"<?=site_url("tor/spp_to_spm")?>",
        data:data,
        success:function(data){
        	if(data=='1'){
        		window.location='<?php echo site_url('tor/daftar_spmlspeg/tahun/'.$cur_tahun); ?>';
        	}else{
        		$('#myModalMsg .body-msg-text').html(data);
						$('#myModalMsg').modal('show');
        	}
        }
      });
		});
	});
	 $(document).on("click",".btn_proses",function(){
					
					 var id = $(this).attr('rel');
					 var rel = [];
						rel[0] = id;
						$('#rel_kuitansi').val(JSON.stringify(rel));
						$('#form_usulkan_spm').submit();
					 //var data =Base64.encode(id); 
                   // document.location.href = "<?=site_url("rsa_lsphk3/spp_lsphk3")?>/"+id;
					//window.location="<?=site_url("rsa_lsphk3/spm_lsphk3")?>/"+id;
                });
</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->

		<div class="row">
			<div class="col-md-12">
				<h3 class="page-header">
					<i class="glyphicon glyphicon-book"></i>
					Daftar SPM LS P3 NON KONTRAK
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<form id="kentut" class="form-horizontal">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-1">Tahun: </label>
								<div class="col-md-3">
									<select name="tahun" id="tahun" class="form-control input-sm"<?php echo $_dsb; ?>>
										<option value="">-</option>
								<?php
									if(count($tahun)>0){
										foreach ($tahun as $key => $value) {
											$s = "";
											if($value->tahun == $cur_tahun){
												$s = " selected=\"selected\"";
											}
								?>
										<option value="<?php echo $value->tahun; ?>"<?php echo $s; ?>><?php echo $value->tahun; ?></option>
								<?php
										}
									}
								?>
									</select>
								</div>
								<div class="col-md-1">
									<button type="button" class="btn btn-primary btn-sm pilih_tahun"<?php echo $_dsb; ?>>Pilih Tahun</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 table-responsive">
				<table class="table table-bordered table-striped table-hover small">
					<thead>
					<tr>
						<th class="text-center">No</th>
						<th class="text-center">Tanggal</th>
						<th class="text-center">Nomor</th>
						
						<th class="text-center" width="150">Proses SPM</th>
					</tr>
					</thead>
					<tbody>
	<?php
		if(isset($daftar_spm) && count($daftar_spm)>0){
			$i=1;
			foreach ($daftar_spm as $key => $value) {
	?>
					<tr>
						<td class="text-right"><?php echo $i; ?>.</td>
						<td><?php echo $value->tanggal2; ?></td>
						<td class="text-center"><?php echo $value->str_nomor_trx; ?></td>
						<td class="text-center">
							<div class="btn-group">
							
                             <button type="button" class="btn btn-success btn-sm btn_proses" rel="<?php echo $value->id_kuitansi; ?>" title="Diajukan SPM"><i class="glyphicon glyphicon-file"></i></button>
                            
							</div>
						</td>
					</tr>
	<?php
				$i++;
			}
		}else{
	?>
					<tr>
						<td colspan="8" class="text-center alert-warning">
						Tidak ada usulan SPP
						</td>
					</tr>
	<?php
		}
	?>
					</tbody>
				</table>
			</div>
		</div>

		<!-- end content -->
	</div>
</div>
<form action="<?=site_url('rsa_lsphk3/view_spm_lsphk3_kpa_nk')?>" id="form_usulkan_spm" method="post" style="display: none">
					<input type="text" name="rel_kuitansi" id="rel_kuitansi" value=""/>
				</form>

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
