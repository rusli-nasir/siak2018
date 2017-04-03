<script type="text/javascript">
	$(function(){
		// untuk form
		$('#form-gajiblu').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_gajiblu').modal('hide');
			$.post('<?php echo site_url('gaji_blu/gajiblu_proses'); ?>',$(this).serialize(),function(data){
				if(data!='1'){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					$('.result_data').load('<?php echo site_url('gaji_blu/showDialogProsesGajiBLU'); ?>');
					return false;
				}
			});
		});
		
		$('#form-gajiblu-lihat').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_gajiblu_lihat').modal('hide');
			$.post('<?php echo site_url('gaji_blu/gajiblu_proses'); ?>',$('#form-gajiblu-lihat').serialize(),function(data){
				if(data!=1){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					window.location='<?php echo site_url('gaji_blu/daftar'); ?>';
					return false;
					//$('#form-ipp')[0].reset();
				}
			});
		});
		$('.master_unit_id').change(function () {
	    if ($(this).prop('checked')) {
	        $('.unit_id:checkbox').prop('checked', true);
	    } else {
	        $('.unit_id:checkbox').prop('checked', false);
	    }
			cek_checked();
		});
		$('.master_status').change(function () {
	    if ($(this).prop('checked')) {
	        $('.status:checkbox').prop('checked', true);
	    } else {
	        $('.status:checkbox').prop('checked', false);
	    }
			cek_checked();
		});
		$('#kriteria_gajiblu').on('hidden.bs.modal', function () {
				$('#form-gajiblu')[0].reset();
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
		$.post('<?php echo site_url('gaji_blu/gajiblu_proses'); ?>', {'act':'gajiblu_proses2'}, function(data){
			if(data==1){
				window.location='<?php echo site_url('gaji_blu/daftar'); ?>';
			}else{
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
			}
		});
	});
	
	function cek_checked(){
		$('input[type=checkbox]').each(function () {
				this.checked ? $(this).parent().addClass('color-red') : $(this).parent().removeClass('color-red');
		});
	}
</script>
<style type="text/css">
	input[type=checkbox]{
		margin:0;
	}
	.scroll-150{
    overflow-x:hidden;max-height:100px;
  }
  .input-group-addon{
  	min-width: inherit;
  }
	label{
		cursor:pointer;
		line-height: normal;
		font-size: 90%;
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
					<i class="fa fa-briefcase"></i>&nbsp;&nbsp;Data Gaji Tendik Non PNS (BLU) - <a href="<?php echo site_url('modul_gaji'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #2</a>
				</h4>
				<p class="text-right">
					<button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_gajiblu_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Gaji Tendik Non PNS (BLU)</button>
					<button type="button" class="btn btn-primary btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_gajiblu"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Gaji Tendik Non PNS (BLU)</button>
				</p>
			</div>
		  <div class="col-md-12 result_data">
				<p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="small text-bold"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Gaji Tendik Non PNS (BLU)</span>&nbsp;&nbsp; untuk memulai proses data Gaji Tendik Non PNS (BLU).</p>
        <pre>
        	<?php //print_r($_SESSION); ?>
        </pre>
			</div>
		</div>
	</div>
</div>



<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_gajiblu" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-gajiblu" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="gajiblu_proses"/>
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Gaji Tendik Non PNS (BLU)</h5>
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
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-12">
										<label>Status Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_status"/>&nbsp;cek semua</label></label>
									</div>
								</div>
								<div class="col-md-12">
	            <?php
								$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar');
								foreach ($stt as $k => $v) {
									$ch = "";
									if(isset($_SESSION['gaji_blu']['status']) && in_array($k,$_SESSION['gaji_blu']['status'])){
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
							?>
								</div>
							</div>
	          </div>
	        </div>
        	<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan IPP:</label>
	              <input type="text" class="form-control input-sm" value="<?php echo $cur_tahun; ?>" readonly="readonly"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="bulan">Bulan Pencairan IPP:</label>
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
<div class="modal fade" id="kriteria_gajiblu_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-gajiblu-lihat" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="gajiblu_lihat"/>
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data Gaji Tendik Non PNS (BLU)</h5>
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
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-12">
										<label>Status Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_status"/>&nbsp;cek semua</label></label>
									</div>
								</div>
								<div class="col-md-12">
	            <?php
								$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar');
								foreach ($stt as $k => $v) {
									$ch = "";
									if(isset($_SESSION['gaji_blu']['status']) && in_array($k,$_SESSION['gaji_blu']['status'])){
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
							?>
								</div>
							</div>
	          </div>
	        </div>
        	<div class="row">
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
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>