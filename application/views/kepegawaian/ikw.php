<script type="text/javascript">
	$(function(){
		// untuk form
		$('#form-ikw').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_ikw').modal('hide');
			$.post($(this).attr('action'),$(this).serialize(),function(data){
				if(data!='1'){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					$('.result_data').load('<?php echo site_url('ikw/showDialogProsesIKW'); ?>');
					return false;
				}
			});
		});

		$('#form-ikw-lihat').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_ikw_lihat').modal('hide');
			$.post('<?php echo site_url('ikw/ikw_proses'); ?>',$('#form-ikw-lihat').serialize(),function(data){
				if(data!=1){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					window.location='<?php echo site_url('ikw/daftar'); ?>';
					return false;
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
		// $('#kriteria_ikw').on('hidden.bs.modal', function () {
		// 		$('#form-ikw')[0].reset();
		// 		cek_checked();
		// });

		$('input[type=checkbox]').each(function(){
			$(this).on('change',function(){
				cek_checked();
			});
		});

		cek_checked();

	});

	$(document).on('click','#proses_2',function(e){
		e.preventDefault();
		$.post('<?php echo site_url('ikw/ikw_proses'); ?>', {'act':'ikw_proses2'}, function(data){
			if(data==1){
				window.location='<?php echo site_url('ikw/daftar'); ?>';
			}else{
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
			}
		});
	});

	function cek_checked(){
		//var sList = "";
		$('input[type=checkbox]').each(function () {
				this.checked ? $(this).parent().addClass('color-red') : $(this).parent().removeClass('color-red');
				//sList += "(" + $(this).val() + "-" + (this.checked ? "checked" : "not checked") + ")";
		});
		//console.log (sList);
	}

	$(document).on('click','.reset_sesi',function(e){
		var a = confirm("Yakin akan menghapus sesi?");
		if(a){
			$.post('<?php echo site_url('ikw/reset_sesi'); ?>',function(r){
				window.location.reload();
			});
		}
	});
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
					<i class="fa fa-coffee"></i>&nbsp;&nbsp;Data Insentif Kinerja Wajib - <a href="<?php echo site_url('kepegawaian'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #3</a>
				</h4>
				<p class="text-right">
					<button type="button" class="btn btn-warning btn-sm reset_sesi"><i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;Reset Sesi</button>
					<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#kriteria_ikw_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Kinerja Wajib</button>
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#kriteria_ikw"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Insentif Kinerja Wajib</button>
				</p>
			</div>
		  <div class="col-md-12 result_data">
				<p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="small text-bold"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Insentif Kinerja Wajib</span>&nbsp;&nbsp; untuk memulai proses data Insentif Kinerja Wajib.</p>
        <pre>
        	<?php //print_r($_SESSION); ?>
        </pre>
			</div>
		</div>
	</div>
</div>



<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ikw" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ikw" action="<?php echo site_url('ikw/ikw_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ikw_proses"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Insentif Kinerja Wajib</h5>
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
								echo $this->cantik2_model->getStatusList($_SESSION['ikw']['status']);
							?>
								</div>
							</div>
	          </div>
	        </div>
        	<div class="row">
          	<div class="col-md-4">
            	<div class="form-group">
                <label for="jnspeg">Jenis Pegawai:</label>
                <?php
									$jnspeg = "";
									if(isset($_SESSION['ikw']['jnspeg'])){
										$jnspeg = $_SESSION['ikw']['jnspeg'];
									}
									echo $this->cantik2_model->getJenisPegawai($jnspeg);
								?>
              </div>
            </div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan:</label>
	              <input type="text" class="form-control input-sm" name="tahun" value="<?php if(isset($_SESSION['ikw']['tahun'])){ echo $_SESSION['ikw']['tahun']; }else{ echo $cur_tahun; } ?>" style="text-align:right;"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="bulan">Bulan Pencairan:</label>
		            <select name="bulan" id="bulan" class="form-control input-sm">
						<?php
							echo $bulanOption;
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
<div class="modal fade" id="kriteria_ikw_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ikw-lihat" action="<?php echo site_url('ikw/ikw_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ikw_lihat"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data Insentif Kinerja Wajib</h5>
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
								echo $this->cantik2_model->getStatusList($_SESSION['ikw']['status']);
							?>
								</div>
							</div>
	          </div>
	        </div>
        	<div class="row">
          	<div class="col-md-4">
            	<div class="form-group">
                <label for="jnspeg">Jenis Pegawai:</label>
                <?php
									$jnspeg = "";
									if(isset($_SESSION['ikw']['jnspeg'])){
										$jnspeg = $_SESSION['ikw']['jnspeg'];
									}
									echo $this->cantik2_model->getJenisPegawai($jnspeg);
								?>
              </div>
            </div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan:</label>
	              <input type="text" class="form-control input-sm" name="tahun" value="<?php if(isset($_SESSION['ikw']['tahun'])){ echo $_SESSION['ikw']['tahun']; }else{ echo $cur_tahun; } ?>" style="text-align:right;"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="bulan">Bulan Pencairan:</label>
		            <select name="bulan" id="bulan" class="form-control input-sm">
						<?php
							echo $bulanOption;
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
