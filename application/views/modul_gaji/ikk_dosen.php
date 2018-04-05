<script type="text/javascript">
	$(function(){
		// untuk form
		$('#form-ikk').on('submit',function(e){
			e.preventDefault();
			var tahun = $('#form-ikk .tahun').val();
			var sms = $('#form-ikk .sms').val();
			var a = confirm('Yakin memproses data IKK Dosen tahun '+tahun+' semester '+sms+'?\n\n\nProses yang dibuat tidak akan mangganti data yang sudah ada.\nData yang sudah ada akan dilewati. Untuk mengganti data, hapus daftar dan lakukan proses ulang.');
			if(a){
				// $('#kriteria_ikk').modal('hide');
				$.post('<?php echo site_url('ikk_dosen/ikk_proses'); ?>',$('#form-ikk').serialize(),function(data){
					if(data!='1'){
						$('#myModalMsg .body-msg-text').html(data);
						$('#myModalMsg').modal('show');
					}else{
						window.location='<?php echo site_url('ikk_dosen/daftar'); ?>';
					}
				});
			}
			return false;
		});

		$('#form-ikk-lihat').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_ikk_lihat').modal('hide');
			$.post('<?php echo site_url('ikk_dosen/ikk_proses'); ?>',$('#form-ikk-lihat').serialize(),function(data){
				if(data!=1){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					window.location='<?php echo site_url('ikk_dosen/daftar'); ?>';
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
					<i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Data Insentif Kelebihan Kinerja (IKK) Dosen - <a href="<?php echo site_url('modul_gaji'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #2</a>
				</h4>
        <p>&nbsp;</p>
				<p class="text-right">
					<button type="button" class="btn btn-default btn-flat btn-sm duh_proses" data-toggle="modal" data-target="#kriteria_ikk_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Kelebihan</button>
					<button type="button" class="btn btn-primary btn-flat btn-sm duh_lihat" data-toggle="modal" data-target="#kriteria_ikk"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Insentif Kelebihan</button>
				</p>
			</div>
		  <div class="col-md-12 result_data">
				<p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="btn btn-sm btn-primary"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Insentif Kelebihan</span>&nbsp;&nbsp; untuk memulai proses data Insentif Kelebihan Kinerja (IKK) Dosen.</p>
			</div>
		</div>

	</div>

	<div class="row">
		<p class="small alert-info text-center kikiki" style="margin-top:10px;padding:5px;display:none;">
			|_( - _ -')_|&nbsp;
			Tolong memberikan donasi kepada programmer yang telah membuat aplikasi RSA. Terimakasih.
			&nbsp;|_( - _ -')_|
		</p>
	</div>

</div>



<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ikk" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ikk" action="<?php echo site_url('ikk_dosen/ikkproses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ikk_proses"/>
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Insentif Kelebihan</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
          <div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan IKK:</label>
	              <input type="text" class="form-control input-sm text-right tahun" value="<?php echo $cur_tahun; ?>"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="sms">Semester Pencairan IKK:</label>
		            <select name="sms" id="sms" class="form-control input-sm sms">
                  <option value="1">Semester 1</option>
                  <option value="2">Semester 2</option>
								</select>
		          </div>
						</div>
            <div class="col-md-4">
							<div class="form-group">
		            <label for="unit_id">Unit:</label><br/>
								<span><?php echo $this->cantik_model->nama_unit_kepeg_rba($_SESSION['rsa_kode_unit_subunit'])->unit; ?></span>
								<?php /*
		            <select name="unit_id" id="unit_id" class="form-control input-sm">
                  <?php
                    $sql = "SELECT * FROM kepeg_unit";
                    $q = $this->db->query($sql);
                    foreach ($q->result() as $k => $v) {
                      $s = "";
                      if(isset($_SESSION['ikk_dosen']['unit_id']) && $_SESSION['ikk_dosen']['unit_id']==$v->id ){
                        $s = " selected";
                      }
                  ?>
                  <<option value="<?php echo $v->id; ?>"<?php echo $s; ?>><?php echo $v->unit; ?></option>
                  <?php
                    }
                  ?>
								</select>
								*/ ?>
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
<div class="modal fade" id="kriteria_ikk_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ikk-lihat" action="<?php echo site_url('ikk_dosen/ikk_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ikk_lihat"/>
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data IKK</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan IKK:</label>
	              <input type="text" class="form-control input-sm text-right" value="<?php echo $cur_tahun; ?>"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="sms">Semester Pencairan IKK:</label>
		            <select name="sms" id="sms" class="form-control input-sm">
                  <option value="1">Semester 1</option>
                  <option value="2">Semester 2</option>
								</select>
		          </div>
						</div>
            <div class="col-md-4">
							<div class="form-group">
		            <label for="unit_id">Unit:</label><br/>
								<span><?php //echo get_h_unit($_SESSION['rsa_kode_unit_subunit']); ?>
									<?php echo $this->cantik_model->nama_unit_kepeg_rba($_SESSION['rsa_kode_unit_subunit'])->unit; ?>
								</span>
								<?php /*
		            <select name="unit_id" id="unit_id" class="form-control input-sm">
                  <?php
                    $sql = "SELECT * FROM kepeg_unit";
                    $q = $this->db->query($sql);
                    foreach ($q->result() as $k => $v) {
                      $s = "";
                      if(isset($_SESSION['ikk_dosen']['unit_id']) && $_SESSION['ikk_dosen']['unit_id']==$v->id ){
                        $s = " selected";
                      }
                  ?>
                  <<option value="<?php echo $v->id; ?>"<?php echo $s; ?>><?php echo $v->unit; ?></option>
                  <?php
                    }
                  ?>
								</select>
								*/ ?>
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
<?php
	// print_r($_SESSION);
?>
