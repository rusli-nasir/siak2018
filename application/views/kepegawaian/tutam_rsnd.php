<script src="<?php echo base_url(); ?>/frontpage/js/select2.full.min.js"></script>
<script type="text/javascript">
$(function(){
	//$('.select2').select2();
	$('.plus_personal').on('click',function(){
		$('#personal_list').modal('show');
	});
	
	$('.what_a_fck').on('click',function(){
		var data = '<li><input type="hidden" name="personal[]" class="personal" value="' + $('#orange').val() + ' - ' + $('#jabatane').val() + '"/>' + $('#orange').val() + ' - ' + $('#jabatane').val() + '</li>';
		$('.daftar_personal').append(data);
		alert('Data ditambahkan.');
	});
	
	$('#form-tutam-rsnd').on('submit',function(e){
		e.preventDefault();
		var n = $('.personal').length;
		if(n>0){
			var data = $(this).serialize();
			$.post('<?php echo site_url('tutam_rsnd/tutam_proses'); ?>',data,function(r){
				if(r==1){
					window.location = '<?php echo site_url('tutam_rsnd/daftar'); ?>';
				}else{
					$('#myModalMsg .body-msg-text').html(r);
					$('#myModalMsg').modal('show');
				}
			});
		}else{
			$('#myModalMsg .body-msg-text').html("Masukkan data personal!");
			$('#myModalMsg').modal('show');
		}
		return false;
	});
	
	$('#form-tutam-lihat').on('submit',function(e){
		e.preventDefault();
		$('#kriteria_tutam_lihat').modal('hide');
		$.post('<?php echo site_url('tutam_rsnd/tutam_proses'); ?>',$('#form-tutam-lihat').serialize(),function(data){
			if(data!=1){
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
				return false;
			}else{
				window.location='<?php echo site_url('tutam_rsnd/daftar'); ?>';
				return false;
				//$('#form-ipp')[0].reset();
			}
		});
	});
	
});
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/frontpage/css/select2.min.css">
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
	input[type="text"].form-control{
		display:inline;
	}
</style>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h4 class="page-header">
					<i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Data Insentif Tugas Tambahan RSND - <a href="<?php echo site_url('modul_gaji'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #2</a>
				</h4>
				<p class="text-right">
					<button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_tutam_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Tugas Tambahan</button>
					<button type="button" class="btn btn-primary btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_tutam"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Insentif Tugas Tambahan</button>
				</p>
			</div>
		  <div class="col-md-12 result_data">
				<p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="small text-bold"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Insentif Tugas Tambahan</span>&nbsp;&nbsp; untuk memulai proses data Insentif Tugas Tambahan.</p>
			</div>
		</div>
	</div>
</div>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_tutam" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-tutam-rsnd" action="<?php echo site_url('tutam/tutam_proses'); ?>" method="post" enctype="multipart/form-data">
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
							<label>Personal yang diberi Tugas: 
              	<button type="button" class="btn btn-default btn-sm plus_personal" title="Tambahkan personal">+</button>
              </label>
              <ol class="daftar_personal small">
                <!--<li><input type="hidden" name="personal[]" value=""/></li>-->
              </ol>
	            </div>
						</div>
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
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="personal_list" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data Insentif Kinerja Wajib</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
        	<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Pegawai Dosen yang diberi Tugas Tambahan:</label>
	              <select class="form-control select2 input-sm" id="orange">
            <?php
							echo $pegawaiRSNDOption;
						?>
                </select>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="jabatan">Jabatan dalam RSND:</label>
		            <select id="jabatane" class="form-control input-sm select2">
						<?php
							echo $jabatanRSNDOption;
						?>
								</select>
		          </div>
						</div>
					</div>

        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
            <button type="button" class="btn btn-primary btn-flat btn-sm what_a_fck"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Tambahkan personal</button>
          </div>
        </div>
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
      <form id="form-tutam-lihat" action="<?php echo site_url('tutam_rsnd/tutam_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="tutam_lihat"/>
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data Insentif Kinerja Wajib</h5>
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