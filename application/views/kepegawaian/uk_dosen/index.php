<script type="text/javascript">
	$(function(){
		// untuk form
		$('#form-ikk').on('submit',function(e){
			e.preventDefault();
			var tahun = $('#form-ikk .tahun').val();
			var sms = $('#form-ikk .sms').val();
			var a = confirm('Yakin memproses data Uang Kinerja Dosen tahun '+tahun+' semester '+sms+'?\n\n\nProses yang dibuat tidak akan mangganti data yang sudah ada.\nData yang sudah ada akan dilewati. Untuk mengganti data, hapus daftar dan lakukan proses ulang.');
			if(a){
				// $('#kriteria_ikk').modal('hide');
				$.post('<?php echo site_url('uk_dosen/set_uk_lppm'); ?>',$('#form-ikk').serialize(),function(data){
					if(data!='1'){
						$('#myModalMsg .body-msg-text').html(data);
						$('#myModalMsg').modal('show');
					}else{
						window.location='<?php echo site_url('uk_dosen/daftar'); ?>';
					}
				});
			}
			return false;
		});

		$('#form-ikk-lihat').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_ikk_lihat').modal('hide');
			$.post('<?php echo site_url('uk_dosen/uk_proses'); ?>',$('#form-ikk-lihat').serialize(),function(data){
				if(data!=1){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					window.location='<?php echo site_url('uk_dosen/daftar'); ?>';
					return false;
					//$('#form-ipp')[0].reset();
				}
			});
		});
	});

	$(document).on('mouseover','.duh_lihat, .duh_proses',function(e){
		// $('.kikiki').show();
	});
	$(document).on('mouseout','.duh_lihat, .duh_proses',function(e){
		// $('.kikiki').hide();
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
					<i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Data Uang Kinerja (UK) Dosen - <a href="<?php echo site_url('kepegawaian'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #3</a>
				</h4>
        <p>&nbsp;</p>
				<p class="text-right">
					<button type="button" class="btn btn-default btn-flat btn-sm duh_proses" data-toggle="modal" data-target="#kriteria_ikk_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Uang Kinerja</button>
					<button type="button" class="btn btn-primary btn-flat btn-sm duh_lihat" data-toggle="modal" data-target="#kriteria_ikk"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Uang Kinerja</button>
				</p>
			</div>
		  <div class="col-md-12 result_data">
				<p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="btn btn-sm btn-primary"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Uang Kinerja</span>&nbsp;&nbsp; untuk memulai proses data Uang Kinerja (UK) Dosen.</p>
			</div>
		</div>

	</div>

</div>



<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ikk" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ikk" action="<?php echo site_url('uk_dosen/set_uk_lppm'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="uk_proses"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Uang Kinerja</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
          <div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan:</label>
	              <input name="tahun" type="text" class="form-control input-sm text-right tahun" value="<?php if(isset($_SESSION['uk_dosen']['tahun'])){ echo $_SESSION['uk_dosen']['tahun']; }else{ echo $cur_tahun; } ?>"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="sms">Semester Pencairan:</label>
		            <select name="sms" id="sms" class="form-control input-sm sms">
                  <option value="1"<?php echo $ch[0]; ?>>Semester 1</option>
                  <option value="2"<?php echo $ch[1]; ?>>Semester 2</option>
								</select>
		          </div>
						</div>
            <div class="col-md-4">
							<div class="form-group">
		            <label for="unit_id">Unit:</label><br/>
								<span><?php echo $this->cantik2_model->nama_unit_kepeg_rba($_SESSION['rsa_kode_unit_subunit']); ?></span>
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
<div class="modal fade" id="kriteria_ikk_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ikk-lihat" action="<?php echo site_url('uk_dosen/uk_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="uk_lihat"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data UK</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan:</label>
	              <input name="tahun" type="text" class="form-control input-sm text-right tahun" value="<?php if(isset($_SESSION['uk_dosen']['tahun'])){ echo $_SESSION['uk_dosen']['tahun']; }else{ echo $cur_tahun; } ?>"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="sms">Semester Pencairan:</label>
		            <select name="sms" id="sms" class="form-control input-sm">
                  <option value="1"<?php echo $ch[0]; ?>>Semester 1</option>
                  <option value="2"<?php echo $ch[1]; ?>>Semester 2</option>
								</select>
		          </div>
						</div>
            <div class="col-md-4">
							<div class="form-group">
		            <label for="unit_id">Unit:</label><br/>
								<span><?php //echo get_h_unit($_SESSION['rsa_kode_unit_subunit']); ?>
									<?php echo $this->cantik2_model->nama_unit_kepeg_rba($_SESSION['rsa_kode_unit_subunit']); ?>
								</span>
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
<?php
	// print_r($_SESSION);
?>
