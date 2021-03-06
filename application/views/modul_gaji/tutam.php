<script type="text/javascript">
	$(function(){
		// untuk form
		$('#form-tutam').on('submit',function(e){
			e.preventDefault();
			var a = confirm('Yakin memproses data Tugas Tambahan?');
			if(a){
				$('#kriteria_tutam').modal('hide');
				$.post('<?php echo site_url('tutam/tutam_proses'); ?>',$('#form-tutam').serialize(),function(data){
					if(data!='1'){
						$('#myModalMsg .body-msg-text').html(data);
						$('#myModalMsg').modal('show');
						return false;
					}else{
						window.location='<?php echo site_url('tutam/daftar'); ?>';
						return false;
					}
				});
			}
			return false;
		});
		
		$('#form-tutam-lihat').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_tutam_lihat').modal('hide');
			$.post('<?php echo site_url('tutam/tutam_proses'); ?>',$('#form-tutam-lihat').serialize(),function(data){
				if(data!=1){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					window.location='<?php echo site_url('tutam/daftar'); ?>';
					return false;
					//$('#form-ipp')[0].reset();
				}
			});
		});
		
		// modal madul // reset status jika cancel
		$('#kriteria_tutam').on('hidden.bs.modal', function () {
				$('#form-tutam')[0].reset();
		});
		
		
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
					<i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Data Insentif Tugas Tambahan - <a href="<?php echo site_url('modul_gaji'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #2</a>
				</h4>
				<p class="text-right">
					<button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_tutam_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Tugas Tambahan</button>
					<button type="button" class="btn btn-primary btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_tutam"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Insentif Tugas Tambahan</button>
				</p>
			</div>
		  <div class="col-md-12 result_data">
				<p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="small text-bold"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Insentif Tugas Tambahan</span>&nbsp;&nbsp; untuk memulai proses data Insentif Tugas Tambahan.</p>
        <pre>
        	<?php //print_r($_SESSION); ?>
        </pre>
			</div>
		</div>
	</div>
</div>



<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_tutam" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-tutam" action="<?php echo site_url('tutam/tutam_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="tutam_proses"/>
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Insentif Tugas Tambahan</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
          <div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan Tugas Tambahan:</label>
	              <input type="text" class="form-control input-sm" value="<?php echo $cur_tahun; ?>" readonly="readonly"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="bulan">Bulan Pencairan Tugas Tambahan:</label>
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
<div class="modal fade" id="kriteria_tutam_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-tutam-lihat" action="<?php echo site_url('tutam/tutam_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="tutam_lihat"/>
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data Tugas Tambahan</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
        	<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan Tutam:</label>
	              <input type="text" class="form-control input-sm" value="<?php echo $cur_tahun; ?>" readonly="readonly"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="bulan">Bulan Pencairan Tutam:</label>
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