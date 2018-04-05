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
		$('#kriteria_ikw').on('hidden.bs.modal', function () {
				$('#form-ikw')[0].reset();
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
					<i class="fa fa-coffee"></i>&nbsp;&nbsp;Data Insentif Kinerja Wajib - <a href="<?php echo site_url('modul_gaji'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #2</a>
				</h4>
				<p class="text-right">
					<button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_ikw_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Kinerja Wajib</button>
					<button type="button" class="btn btn-primary btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_ikw"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Insentif Kinerja Wajib</button>
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
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
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
							/*
								$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar', '13'=>'Diberhentikan sementara');
								foreach ($stt as $k => $v) {
									$ch = "";
									if(isset($_SESSION['ipp']['status']) && in_array($k,$_SESSION['ipp']['status'])){
										$ch = " checked = \"checked\"";
									}
							?>
		              <div class="small col-md-3 col-sm-6 col-xs-12">
		                <label>
		                  <input type="checkbox" class="status" name="status[]" id="status" value="<?php echo $k; ?>"<?php echo $ch; ?>/>
		                  <?php echo $v; ?>
		                </label>
		              </div>
							<?php
								}
								*/
								echo $this->cantik_model->opsiStatusKepeg($_SESSION['ikw']['status']);
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
								<label>Tahun Pencairan IKW:</label>
	              <input type="text" class="form-control input-sm" value="<?php echo $cur_tahun; ?>" readonly="readonly"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="bulan">Bulan Pencairan IKW:</label>
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
            <!-- <button type="button" class="btn btn-default btn-flat btn-sm lihat_data"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button> -->
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
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
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
								/*
								$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar', '13'=>'Diberhentikan sementara');
								foreach ($stt as $k => $v) {
									$ch = "";
									if(isset($_SESSION['ikw']['status']) && in_array($k,$_SESSION['ikw']['status'])){
										$ch = " checked = \"checked\"";
									}
							?>
		              <div class="small col-md-3 col-sm-6 col-xs-12">
		                <label>
		                  <input type="checkbox" class="status" name="status[]" id="status" value="<?php echo $k; ?>"<?php echo $ch; ?>/>
		                  <?php echo $v; ?>
		                </label>
		              </div>
							<?php
								}
								*/
								echo $this->cantik_model->opsiStatusKepeg($_SESSION['ikw']['status']);
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
                      if(isset($_SESSION['ikw']['jnspeg']) && $_SESSION['ikw']['jnspeg']==$v[0]){
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
								<label>Tahun Pencairan IKW:</label>
	              <input type="text" class="form-control input-sm" value="<?php echo $cur_tahun; ?>" readonly="readonly"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="bulan">Bulan Pencairan IKW:</label>
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
            <!-- <button type="button" class="btn btn-default btn-flat btn-sm lihat_data"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button> -->
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
