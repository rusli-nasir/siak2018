<script type="text/javascript">
$(function(){

	reload_daftar(); // daftar untuk data lain2

	$('.home').on('click', function(e){
		window.location = '<?php echo site_url('ipp'); ?>';
	});

	$('.cetak_daftar').on('click', function(e){
		window.location = '<?php echo site_url('ipp/daftar_cetak'); ?>';
	});

	$('.lihat_data').on('click',function(e){
		$('#kriteria_ipp_lihat').modal('hide');
		$.post($('#form-ipp-lihat').attr('action'),$('#form-ipp-lihat').serialize(),function(data){
			if(data!=1){
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
			}else{
				window.location.reload();
			}
		});
	});

	// checkbox
	$('#master_unit_id').change(function () {
		if ($(this).prop('checked')) {
				$('.unit_id:checkbox').prop('checked', true);
		} else {
				$('.unit_id:checkbox').prop('checked', false);
		}
		cek_checked();
	});
	//$('#master_unit_id').trigger('change');
	// checkbox
	$('#master_status_kepeg').change(function () {
		if ($(this).prop('checked')) {
				$('.status_kepeg:checkbox').prop('checked', true);
		} else {
				$('.status_kepeg:checkbox').prop('checked', false);
		}
		cek_checked();
	});
	//$('#master_status_kepeg').trigger('change');
	// checkbox
	$('#master_status').change(function () {
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
			$('#form-ipp-lihat')[0].reset();
			cek_checked();
	});

	$('input[type=checkbox]').each(function(){
		$(this).on('change',function(){
			cek_checked();
		});
	});

	cek_checked();

});

$(document).on('click','.trash',function(){
	var a=confirm('Yakin akan menghapus data dari daftar ini?');
	if(a){
		$.post('<?php echo site_url('ipp/ipp_proses'); ?>',{'id':$(this).attr('id'), 'act':'ipp_hapus_single'},function(data){
			if(data!='1'){
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
			}else{
				reload_daftar();
			}
		});
	}
});

$(document).on('click','.big-trash',function(){
	var a=confirm('Yakin akan menghapus daftar ini?');
	if(a){
		$.post('<?php echo site_url('ipp/ipp_proses'); ?>',{'id':$(this).attr('id'), 'act':'ipp_hapus_daftar'},function(data){
			if(data!='1'){
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
			}else{
				reload_daftar();
			}
		});
	}
});

function cek_checked(){
	$('input[type=checkbox]').each(function () {
			this.checked ? $(this).parent().addClass('color-red') : $(this).parent().removeClass('color-red');
	});
}

function reload_daftar(){
	$('.load-daftar').load('<?php echo site_url('ipp/reload_daftar'); ?>');
	$('._tooltip').tooltip();
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
        	<button type="button" class="btn btn-primary btn-sm home"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;Beranda Insentif Perbaikan Penghasilan</button>
					<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#kriteria_ipp_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Perbaikan Penghasilan</button>
				</p>
			</div>
		  <div class="col-md-12">
        <div class="col-md-12" style="background-color:#ccc;padding:5px;">
        	<p class="text-right">
            <button type="button" class="btn btn-default btn-sm cetak_daftar"><i class="glyphicon glyphicon-print"></i>&nbsp;&nbsp;&nbsp;Cetak daftar ini</button>
          </p>
        	<div class="col-md-12" style="background-color:#fff;padding:3px;">
          	<h4 class="text-center">
            	Daftar Penerima Insentif Perbaikan Penghasilan <?php echo $this->cantik_model->getJenisPeg($_SESSION['ipp']['jnspeg']); ?><br/>Universitas Diponegoro<br/>
              Semester <?php echo $this->cantik_model->getSemester($_SESSION['ipp']['semester']); ?> Tahun <?php echo $_SESSION['ipp']['tahun']; ?>
            </h4>
            <p style="font-weight:bold;" class="small">
            	Unit : <?php echo $daftar_unit; ?><br />
              Status Pegawai : <?php echo $daftar_status; ?>
            </p>
            <table class="table table-bordered table-striped small">
            	<thead>
                <tr>
                  <th>No</th>
                  <th>Nama/NIP</th>
                  <th>Unit</th>
                  <th>Gol.</th>
                  <th>Status</th>
                  <th>Bruto</th>
                  <th>Pajak</th>
                  <th>Jumlah Pajak</th>
                  <th>Netto</th>
                  <th class="text-center">
                  	<button type="button" class="btn btn-danger btn-xs big-trash" title="hapus seluruh daftar"><i class="glyphicon glyphicon-trash"></i>&nbsp;<i class="glyphicon glyphicon-list"></i></button>
                  </th>
                </tr>
               </thead>
               <tbody class="load-daftar">
               </tbody>
            </table>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>


<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ipp_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ipp-lihat" action="<?php echo site_url('ipp/ipp_proses'); ?>" method="post" enctype="multipart/form-data">
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
		            <label for="unit_id">Unit Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" id="master_unit_id"/>&nbsp;cek semua</label></label>
		            <div class="row">
                	<?php echo $unitList; ?>
                </div>
		          </div>
	        	</div>
          </div>
          <div class="row">
	        	<div class="col-md-12 col-xs-12">
							<div class="form-group">
		            <label for="status_kepeg">Status Kepegawaian:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" id="master_status_kepeg"/>&nbsp;cek semua</label></label>
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
										<label>Status Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" id="master_status"/>&nbsp;cek semua</label></label>
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
								<label>Tahun Pencairan:</label>
	              <input type="text" class="form-control input-sm" value="<?php if(isset($_SESSION['ipp']['tahun'])){echo $_SESSION['ipp']['tahun'];}else{echo $cur_tahun;} ?>" name="tahun" id="tahun"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="tahun">Semester Pencairan:</label>
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
