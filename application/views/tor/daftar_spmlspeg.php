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
			window.location='<?php echo site_url('tor/daftar_spmlspeg')."/tahun/"; ?>'+data;
		});
		$('#kentut .pilih_tahun').on('click',function(e){
			e.preventDefault();
			var data = $('#kentut #tahun').val();
			if(data.length == 0){
				$('#myModalMsg .body-msg-text').html('<p class="alert alert-warning">Pilih tahun SPM LS Pegawai yang ada, atau proses SPM terlebih dahulu.</p>');
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
			var a=confirm('Yakin kirim pengajuan SPM LS-Pegawai ini ke KPA SUKPA?');
			if(a){
				var id_spmls = $(this).attr('id');
	      var proses = $(this).attr('rel');
	      var data = "id_spmls=" + id_spmls + "&proses=" + proses;

	      $.ajax({
	          type:"POST",
	          url :"<?=site_url("tor/spm_to_cair")?>",
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
			var a=confirm('Yakin setujui SPM yang dikirim oleh PPK-SUKPA?');
			if(a){
				var id_spmls = $(this).attr('id');
	      var proses = $(this).attr('rel');
	      var data = "id_spmls=" + id_spmls + "&proses=" + proses;

	      $.ajax({
	          type:"POST",
	          url :"<?=site_url("tor/spm_to_cair")?>",
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
			$('#alasan_nolak #id_spmls').val($(this).attr('id'));
			$('#alasan_nolak #proses').val($(this).attr('rel'));
			$('#myModalMessage').modal('show');
		});
		$('.lihat').on('click', function(e){
			e.preventDefault();
			window.location = '<?php echo site_url("tor/spmls"); ?>/id/'+$(this).attr('id');
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
        url :"<?=site_url("tor/spm_to_cair")?>",
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
			var id_spmls = $(this).attr('id');
      var data = "id_spmls=" + id_spmls;
			$.ajax({
        type:"POST",
        url :"<?=site_url("tor/spm_tolak_detail")?>",
        data:data,
        success:function(data){
        	$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
        }
      });
		});
		$('#cair_banget').on('submit',function(e){
			e.preventDefault();
			var n = $("#cair_banget input[name='akun_cair']:checked").length;
			if(n<=0){
					$('#myModalMsg .body-msg-text').html('<p class="alert alert-warning">Pilih salah satu untuk melanjutkan proses.</p>');
					$('#myModalMsg').modal('show');
					return false;
			}
			var a=confirm('Yakin cairkan SPM ini menggunakan nomor rekening terpilih?');
			if(a){
				var data = $('#cair_banget').serialize();
				// alert(data); return false;
				$.ajax({
		      type:"POST",
		      url :"<?=site_url("tor/spm_to_cair")?>",
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
			}else{
				$('#myModalMessage2').modal('hide');
				return false;
			}
		});
		$('.cair').on('click',function(e){
			e.preventDefault();
			$('#cair_banget #id_spmls').val($(this).attr('id'));
			$('#cair_banget #proses').val($(this).attr('rel'));
			$('#myModalMessage2').modal('show');
		});
		$('.alirkan').on('click',function(e){
			e.preventDefault();
			$('#cair_banget').submit();
		});
	});
</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->

		<div class="row">
			<div class="col-md-12">
				<h3 class="page-header">
					<i class="glyphicon glyphicon-book"></i>
					Daftar SPM LS-Pegawai
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
									<select name="tahun" id="tahun" class="form-control input-sm"<?php echo $_dsb;?>>
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
									<button type="button" class="btn btn-primary btn-sm pilih_tahun"<?php echo $_dsb;?>>Pilih Tahun</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered table-striped table-hover small">
					<thead>
					<tr>
						<th class="text-center">No</th>
						<th class="text-center">Tanggal</th>
						<th class="text-center">Nomor</th>
						<th class="text-center">Unit Pengusul</th>
						<th class="text-center">Keperluan</th>
						<th class="text-center">Jumlah</th>
						<th class="text-center">Status</th>
						<th class="text-center" width="180">&nbsp;</th>
					</tr>
					</thead>
					<tbody>
	<?php
		if(isset($daftar_spmlspeg) && count($daftar_spmlspeg)>0){
			$i=1;
			foreach ($daftar_spmlspeg as $key => $value) {
	?>
					<tr>
						<td class="text-right"><?php echo $i; ?>.</td>
						<td><?php echo $value->tanggal2; ?></td>
						<td class="text-center"><?php echo $value->nomor; ?></td>
						<td class="text-center"><?php echo $value->unitsukpa; ?></td>
						<td><?php echo $this->cantik_model->decodeText($value->untuk_bayar); ?></td>
						<td class="text-right"><?php echo number_format($value->total_sumberdana,0,',','.'); ?>,-</td>
						<td class="text-center"><?php echo $value->status; ?></td>
						<td class="text-center">
							<div class="btn-group">
							<?php
								if($_SESSION['rsa_level']=='14'){
									if($value->proses==0){
							?>
								<a class="btn btn-primary btn-sm kirimppk" rel="1" id="<?php echo $value->id_spmls; ?>" title="Ajukan SPM ke KPA SUKPA"><i class="glyphicon glyphicon-cloud-upload"></i></a>
							<?php
									}elseif(in_array(intval($value->proses),array(1,2,3,4))){
										// masa menanti kentut yang indah
										echo "<a class=\"btn btn-default btn-sm\" disabled=\"disabled\" title=\"Menunggu proses pencairan\"><i class=\"fa fa-spinner\"></i></a>";
									}
								}
								if($_SESSION['rsa_level']==2 && $value->proses==1){
							?>
								<a class="btn btn-primary btn-sm yes" rel="<?php echo $rel; ?>" id="<?php echo $value->id_spmls; ?>" title="Setujui SPM ini"><i class="glyphicon glyphicon-thumbs-up"></i></a>
								<a class="btn btn-danger btn-sm no" rel="9" id="<?php echo $value->id_spmls; ?>" title="Tolak SPM ini"><i class="glyphicon glyphicon-thumbs-down"></i></a>
							<?php
								}
								if($_SESSION['rsa_level']==3 && $value->proses==2){
							?>
								<a class="btn btn-primary btn-sm yes" rel="<?php echo $rel; ?>" id="<?php echo $value->id_spmls; ?>" title="Setujui SPM ini"><i class="glyphicon glyphicon-thumbs-up"></i></a>
								<a class="btn btn-danger btn-sm no" rel="9" id="<?php echo $value->id_spmls; ?>" title="Tolak SPM ini"><i class="glyphicon glyphicon-thumbs-down"></i></a>
							<?php
								}
								if($_SESSION['rsa_level']==5 && $value->proses==3){
							?>
								<a class="btn btn-primary btn-sm yes" rel="<?php echo $rel; ?>" id="<?php echo $value->id_spmls; ?>" title="Setujui SPM ini"><i class="glyphicon glyphicon-thumbs-up"></i></a>
								<a class="btn btn-danger btn-sm no" rel="9" id="<?php echo $value->id_spmls; ?>" title="Tolak SPM ini"><i class="glyphicon glyphicon-thumbs-down"></i></a>
							<?php
								}
								if($_SESSION['rsa_level']=='11' && ($value->proses==3 || $value->proses==4)){
							?>
								<a class="btn btn-primary btn-sm cair" rel="<?php echo $rel; ?>" id="<?php echo $value->id_spmls; ?>" title="Cairkan SPM ini"><i class="glyphicon glyphicon-gift"></i></a>
								<a class="btn btn-danger btn-sm no" rel="9" id="<?php echo $value->id_spmls; ?>" title="Tolak SPM ini"><i class="glyphicon glyphicon-thumbs-down"></i></a>
							<?php
								}
							?>
								<a class="btn btn-default btn-sm histori" rel="1" id="<?php echo $value->id_spmls; ?>" title="Lihat histori penolakan"><i class="glyphicon glyphicon-th-list"></i></a>
								<a class="btn btn-default btn-sm lihat" rel="1" id="<?php echo $value->id_spmls; ?>" title="Lihat dan ubah rincian"><i class="glyphicon glyphicon-search"></i></a>
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
						Tidak ada usulan SPM
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

<div class="modal" id="myModalMessage" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i> Perhatian :</h4>
          </div>
          <div class="modal-body" style="margin:15px;padding:0px;padding-bottom: 15px;word-wrap: break-word;">
          	<form id="alasan_nolak">
          		<input type="hidden" name="id_spmls" id="id_spmls" value=""/>
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

<div class="modal" id="myModalMessage2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i> Perhatian :</h4>
          </div>
          <div class="modal-body" style="margin:15px;padding:0px;padding-bottom: 15px;word-wrap: break-word;">
          	<form id="cair_banget">
          		<input type="hidden" name="id_spmls" id="id_spmls" value=""/>
          		<input type="hidden" name="proses" id="proses" value="0"/>
					<?php
						foreach ($akun_cair as $key => $value) {
					?>
							<div class="input-group">
								<span class="input-group-addon">
									<input type="radio" name="akun_cair" id="akun_cair" value="<?php echo $value->kd_kas_6; ?>"/>
								</span>
								<input type="text" class="form-control"  value="<?php echo $value->nm_kas_6; ?> (Rp. <?php echo number_format($value->saldo,0,',','.'); ?>,-)" readonly="readonly"/>
							</div>
					<?php
						}
					?>
          	</form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary alirkan"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> OK</button>
          </div>
        </div>
    </div>
</div>
