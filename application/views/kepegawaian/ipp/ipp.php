<script type="text/javascript">
	$(function(){
		// untuk form
		$('#form-ipp').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_ipp').modal('hide');
			$.post('<?php echo site_url('ipp/ipp_proses'); ?>',$('#form-ipp').serialize(),function(data){
				if(data!=1){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					$('.result_data').load('<?php echo site_url('ipp/showDialogProsesIPP'); ?>');
					return false;
					//$('#form-ipp')[0].reset();
				}
			});
		});

		$('#form-ipp-lihat').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_ipp_lihat').modal('hide');
			$.post('<?php echo site_url('ipp/ipp_proses'); ?>',$('#form-ipp-lihat').serialize(),function(data){
				if(data!=1){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					window.location='<?php echo site_url('ipp/ipp_daftar'); ?>';
					return false;
					//$('#form-ipp')[0].reset();
				}
			});
		});

		// checkbox
		$('.master_unit_id').change(function () {
	    if ($(this).prop('checked')) {
	        $('.unit_id:checkbox').prop('checked', true);
	    } else {
	        $('.unit_id:checkbox').prop('checked', false);
	    }
			cek_checked();
		});
		//$('#master_unit_id').trigger('change');
		// checkbox
		$('.master_status_kepeg').change(function () {
	    if ($(this).prop('checked')) {
	        $('.status_kepeg:checkbox').prop('checked', true);
	    } else {
	        $('.status_kepeg:checkbox').prop('checked', false);
	    }
			cek_checked();
		});
		//$('#master_status_kepeg').trigger('change');
		// checkbox
		$('.master_status').change(function () {
	    if ($(this).prop('checked')) {
	        $('.status:checkbox').prop('checked', true);
	    } else {
	        $('.status:checkbox').prop('checked', false);
	    }
			cek_checked();
		});
		//$('#master_status').trigger('change');

		// modal madul // reset status jika cancel
		$('#kriteria_ipp').on('hidden.bs.modal', function () {
				$('#form-ipp')[0].reset();
				cek_checked();
		});

		$('input[type=checkbox]').each(function(){
			$(this).on('change',function(){
				cek_checked();
			});
		});

		cek_checked();

	});

	$(document).on('click','#proses_2',function(e){
		e.preventDefault();
		$.post('<?php echo site_url('ipp/ipp_proses'); ?>', {'act':'ipp_proses2'}, function(data){
			if(data==1){
				window.location='<?php echo site_url('ipp/ipp_daftar'); ?>';
				return false;
			}else{
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
				return false;
			}
		});
	});

	$(document).on('click','.reset_sesi',function(e){
		var a = confirm("Yakin akan menghapus sesi?");
		if(a){
			$.post('<?php echo site_url('ipp/reset_sesi'); ?>',function(r){
				window.location.reload();
			});
		}
	});

	function cek_checked(){
		//var sList = "";
		$('input[type=checkbox]').each(function () {
				this.checked ? $(this).parent().addClass('color-red') : $(this).parent().removeClass('color-red');
				//sList += "(" + $(this).val() + "-" + (this.checked ? "checked" : "not checked") + ")";
		});
		//console.log (sList);
	}
</script>
<style type="text/css">
	.scroll-150{
    overflow-x:hidden;max-height:100px;
  }
  .input-group-addon{
  	min-width: inherit;
  }
	label{
		cursor:pointer;
	}
	.color-red{
		color:#f00;
		font-weight:normal;
	}
</style>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h4 class="page-header">
					<i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Data Insentif Perbaikan Penghasilan - <a href="<?php echo site_url('kepegawaian'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #3</a>
				</h4>
				<p class="text-right">
					<button type="button" class="btn btn-warning btn-sm reset_sesi"><i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;Reset Sesi</button>
					<button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_ipp_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Perbaikan Penghasilan</button>
					<button type="button" class="btn btn-primary btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_ipp"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Insentif Perbaikan Penghasilan</button>
				</p>
			</div>
		  <div class="col-md-12 result_data">
				<p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="small text-bold"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Tunjangan IPP</span>&nbsp;&nbsp; untuk memulai proses data Insentif Perbaikan Penghasilan.</p>
        <pre>
        	<?php //print_r($_SESSION); ?>
        </pre>
			</div>
		</div>
	</div>
</div>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ipp" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ipp" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ipp_proses"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Insentif Perbaikan Penghasilan</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
          <div class="row">
          	<div class="col-md-12 col-xs-12">
		          <div class="form-group">
		            <label for="unit_id">Unit Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_unit_id"/>&nbsp;cek semua</label></label>
		            <div class="row">
                	<?php echo $unitList; ?>
                </div>
		          </div>
	        	</div>
          </div>
          <div class="row">
	        	<div class="col-md-12 col-xs-12">
							<div class="form-group">
		            <label for="status_kepeg">Status Kepegawaian:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_status_kepeg"/>&nbsp;cek semua</label></label>
                <div class="row">
                  <?php echo $statusKepegOption; ?>
                </div>
		          </div>
		        </div>
		      </div>
		      <div class="row">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-12">
										<label>Status Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_status"/>&nbsp;cek semua</label></label>
									</div>
								</div>
								<div class="col-md-12">
	            <?php
								echo $this->cantik2_model->getStatusList($_SESSION['ipp']['status']);
							?>
								</div>
							</div>
	          </div>
	        </div>
        	<div class="row">
          	<div class="col-md-4">
            	<div class="form-group">
                <label for="jnspeg">Jenis Pegawai:</label>
                <select name="jnspeg" id="jnspeg" class="form-control input-sm">
                  <?php
                    $_jenispeg = array(array(1,'Dosen Pengajar'),array(2,'Tenaga Kependidikan'));
                    foreach ($_jenispeg as $k => $v) {
                      $_s = "";
                      if(isset($_SESSION['ipp']['jnspeg']) && $_SESSION['ipp']['jnspeg']==$v[0]){
                        $_s = " selected";
                      }
                  ?>
                  <option value="<?php echo $v[0]; ?>"<?php echo $_s; ?>><?php echo $v[1]; ?></option>
                  <?php
                    }
                  ?>
                </select>
              </div>
            </div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan IPP:</label>
	              <input type="text" class="form-control input-sm" value="<?php if(isset($_SESSION['ipp']['tahun'])){ echo $_SESSION['ipp']['tahun']; }else{ echo $cur_tahun; } ?>" name="tahun" id="tahun"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="tahun">Semester Pencairan IPP:</label>
		            <select name="semester" id="semester" class="form-control input-sm">
						<?php
							foreach (array(array(1,'Ganjil'),array(2,'Genap')) as $k => $v) {
								$_s = "";
								if(isset($_SESSION['ipp']['semester']) && $_SESSION['ipp']['semester']==$v[0]){
									$_s = " selected=\"selected\"";
								}
						?>
									<option value="<?php echo $v[0]; ?>"<?php echo $_s; ?>><?php echo $v[1]; ?></option>
						<?php
							}
						?>
								</select>
		          </div>
						</div>
					</div>

        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-primary btn-flat btn-sm do_data"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Data</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ipp_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ipp-lihat" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ipp_lihat"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data Insentif Perbaikan Penghasilan</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
          <div class="row">
          	<div class="col-md-12 col-xs-12">
		          <div class="form-group">
		            <label for="unit_id">Unit Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_unit_id"/>&nbsp;cek semua</label></label>
		            <div class="row">
                	<?php echo $unitList; ?>
                </div>
		          </div>
	        	</div>
          </div>
          <div class="row">
	        	<div class="col-md-12 col-xs-12">
							<div class="form-group">
		            <label for="status_kepeg">Status Kepegawaian:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_status_kepeg"/>&nbsp;cek semua</label></label>
                <div class="row">
                  <?php echo $statusKepegOption; ?>
                </div>
		          </div>
		        </div>
		      </div>
		      <div class="row">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-12">
										<label>Status Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_status"/>&nbsp;cek semua</label></label>
									</div>
								</div>
								<div class="col-md-12">
	            			<?php
								echo $this->cantik2_model->getStatusList($_SESSION['ipp']['status']);
							?>
								</div>
							</div>
	          </div>
	        </div>
        	<div class="row">
          	<div class="col-md-4">
            	<div class="form-group">
                <label for="jnspeg">Jenis Pegawai:</label>
                <select name="jnspeg" id="jnspeg" class="form-control input-sm">
                  <?php
                    $_jenispeg = array(array(1,'Dosen Pengajar'),array(2,'Tenaga Kependidikan'));
                    foreach ($_jenispeg as $k => $v) {
                      $_s = "";
                      if(isset($_SESSION['ipp']['jnspeg']) && $_SESSION['ipp']['jnspeg']==$v[0]){
                        $_s = " selected";
                      }
                  ?>
                  <option value="<?php echo $v[0]; ?>"<?php echo $_s; ?>><?php echo $v[1]; ?></option>
                  <?php

                    }
                  ?>
                </select>
              </div>
            </div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan IPP:</label>
	              <input type="text" class="form-control input-sm" value="<?php if(isset($_SESSION['ipp']['tahun'])){ echo $_SESSION['ipp']['tahun']; }else{ echo $cur_tahun; } ?>" name="tahun" id="tahun"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="tahun">Semester Pencairan IPP:</label>
		            <select name="semester" id="semester" class="form-control input-sm">
						<?php
							foreach (array(array(1,'Ganjil'),array(2,'Genap')) as $k => $v) {
								$_s = "";
								if(isset($_SESSION['ipp']['semester']) && $_SESSION['ipp']['semester']==$v[0]){
									$_s = " selected=\"selected\"";
								}
						?>
									<option value="<?php echo $v[0]; ?>"<?php echo $_s; ?>><?php echo $v[1]; ?></option>
						<?php
							}
						?>
								</select>
		          </div>
						</div>
					</div>

        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-primary btn-flat btn-sm lihat_data"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
