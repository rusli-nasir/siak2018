<script type="text/javascript">
	$(document).on('click','.halaman',function(e){
		$.post('<?php echo site_url('cantik/set_halaman'); ?>',{'id':$(this).attr('id')},function(data){
			if(data=='1'){
				window.location.reload();
			}else{
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
			}
		});
	});
	$(document).on('submit','#form_lihat',function(e){
		e.preventDefault();
		$.post($(this).attr('action'),$(this).serialize(),function(data){
			if(data=='1'){
				$('#kriteria_lihat').modal('hide');
				window.location='<?php echo site_url("cantik/mungil"); ?>';
			}else{
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
			}
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
</style>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h4 class="page-header">
					<i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Data Tenaga Kerja Kontrak Undip
				</h4>
				<div class="text-right">
					<button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Proses Gaji TKK</button>
					<button type="button" class="btn btn-primary btn-flat btn-sm" data-toggle="modal" data-target="#kriteria"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Gaji TKK</button>
				</div>
				<ul class="nav nav-tabs" role="tablist" id="kentut_tab">
	        <li role="presentation" class="active"><a href="#dt_peg" role="tab" data-toggle="tab" aria-expanded="true"><i class="glyphicon glyphicon-list"></i>Daftar TKK</a></li>
  			</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="dt_peg">
						<div style="background-color:#ccc;padding:5px;">
							<div style="background-color:#fff;">
								<table class="table table-bordered table-hover small" style="margin-bottom:0;">
									<thead style="background-color:#337ab7;color:#fff;">
										<tr>
											<th class="text-center">No</th>
											<th class="text-center">Nama</th>
											<th class="text-center">NIK</th>
											<th class="text-center">Jabatan</th>
											<th class="text-center">Status</th>
											<th class="text-center">Jenis</th>
											<th class="text-center">NPWP</th>
											<th class="text-center">No. Rek.</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
<?php
	if($jt>0){
		$i=1;
		if(isset($_SESSION['tkk']['page'])){
			$i = (($_SESSION['tkk']['page']-1)*$this->cantik_model->_maxPage)+1;
		}
		foreach($dt as $entut => $v){
?>
										<tr>
											<td class="text-right"><?php echo $i; ?>.</td>
											<td><?php echo $v->nama; ?></td>
											<td><?php echo $v->nip; ?></td>
											<td><?php echo $v->jabatan; ?></td>
											<td class="text-center"><?php echo $this->cantik_model->getStatus($v->status); ?></td>
											<td class="text-center"><?php echo $this->cantik_model->getJenisPeg($v->jnspeg); ?></td>
											<td><?php echo $v->npwp; ?></td>
											<td><?php echo $this->cantik_model->getRekening($v->id,1); ?></td>
											<td><button type="button" class="btn btn-primary btn-sm dt_bayar" title="daftar proses pembayaran gaji" id="<?php echo $v->nip; ?>"><i class="glyphicon glyphicon-credit-card"</button></td>
										</tr>
<?php
			$i++;
		}
	}
?>
									</tbody>
								</table>
							</div>
							<div class="text-center">
								<ul class="pagination pagination-sm" style="margin:0;margin-top:10px;">
<?php
	$page = ceil($jt/$this->cantik_model->_maxPage);
	for($j=1;$j<=$page;$j++){
		$s = "";
		if(isset($_SESSION['tkk']['page']) && $_SESSION['tkk']['page']==$j){
			$s = " class=\"active\"";
		}elseif((!isset($_SESSION['tkk']['page']) && $j==1)){
			$s = " class=\"active\"";
		}
?>
									<li<?php echo $s; ?>><a href="javascript:void(0);" class="halaman" id="<?php echo $j; ?>"><?php echo $j; ?></a></li>
<?php
	}
?>
	              </ul>
								<?php //echo $page; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form_proses" action="<?php echo site_url('cantik/aku_cinta'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="pdkt"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Data Gaji TKK</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
          <div class="row">
          	<div class="col-md-6 col-xs-12">
		          <div class="form-group<?php echo $_cari1; ?>">
		            <label for="unit_id">Unit Pegawai:</label>
		            <select name="unit_id" id="unit_id" class="form-control input-sm">
		            	<option value="">seluruhnya</option>
		              <?php echo $unitOption; ?>
		            </select>
		          </div>
	        	</div>
	        	<div class="col-md-6 col-xs-12">
							<div class="form-group<?php echo $_cari6; ?>">
		            <label for="jnspeg">Jenis Pegawai:</label>
		            <select name="jnspeg" id="jnspeg" class="form-control input-sm">
		              <?php
										$_jenispeg = array(array(1,'Dosen Pengajar'),array(2,'Tenaga Kependidikan'));
										foreach ($_jenispeg as $k => $v) {
											$_s = "";
											if(isset($_SESSION['tkk']['jnspeg']) && $_SESSION['tkk']['jnspeg']==$v[0]){
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
		      </div>
		      <div class="row">
						<div class="form-group<?php echo $_cari5; ?>">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-12">
										<label>Status Pegawai:</label>
									</div>
								</div>
								<div class="col-lg-12">
	            <?php
								$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar');
								foreach ($stt as $k => $v) {
									$ch = "";
									if(isset($_SESSION['tkk']['status']) && in_array($k,$_SESSION['tkk']['status'])){
										$ch = " checked = \"checked\"";
									}
							?>
		              <div class="small col-lg-3 col-md-6 col-xs-12">
		                <label>
		                  <input type="checkbox" name="status[]" id="status" value="<?php echo $k; ?>"<?php echo $ch; ?>/>
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
							<div class="form-group<?php echo $_cari3; ?>">
								<label for="tahun">Tahun:</label>
	              <input type="text" class="form-control input-sm" name="tahun" maxlength="4" <?php echo $_tahun; ?>/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group<?php echo $_cari4; ?>">
		            <label for="bulan">Bulan:</label>
		            <select name="bulan" id="bulan" class="form-control input-sm">
									<?php echo $bulanOption; ?>
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
<div class="modal fade" id="kriteria_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form_lihat" action="<?php echo site_url('cantik/aku_cinta'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="pemuja_rahasia"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Lihat Data Gaji TKK</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
          <div class="row">
          	<div class="col-md-6 col-xs-12">
		          <div class="form-group<?php echo $_cari1; ?>">
		            <label for="unit_id">Unit Pegawai:</label>
		            <!-- <select name="unit_id" id="unit_id" class="form-control input-sm">
		            	<option value="">seluruhnya</option>
		              <?php echo $unitOption; ?>
		            </select> -->
								<select name="unit_id[]" id="unit_id" class="form-control input-sm" multiple="multiple">
<?php
	if(is_array($ut)){
		foreach ($ut as $k => $v) {
			$c = "";
			if(isset($_SESSION['tkk']['unit']) && in_array($v->id,$_SESSION['tkk']['unit'])){
				$c = " selected=\"selected\"";
			}
?>
									<option value="<?php echo $v->id; ?>"<?php echo $c; ?> style="padding:5px 0"/>&nbsp;<?php echo $v->unit; ?></option>
<?php
		}
	}
?>
								</select>
		          </div>
	        	</div>
	        	<div class="col-md-6 col-xs-12">
							<div class="form-group<?php echo $_cari6; ?>">
		            <label for="jnspeg">Jenis Pegawai:</label>
		            <select name="jnspeg" id="jnspeg" class="form-control input-sm">
		              <?php
										$_jenispeg = array(array(1,'Dosen Pengajar'),array(2,'Tenaga Kependidikan'));
										foreach ($_jenispeg as $k => $v) {
											$_s = "";
											if(isset($_SESSION['tkk']['jnspeg']) && $_SESSION['tkk']['jnspeg']==$v[0]){
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
		      </div>
		      <div class="row">
						<div class="form-group<?php echo $_cari5; ?>">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-12">
										<label>Status Pegawai:</label>
									</div>
								</div>
								<div class="col-lg-12">
	            <?php
								$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar');
								foreach ($stt as $k => $v) {
									$ch = "";
									if(isset($_SESSION['tkk']['status']) && in_array($k,$_SESSION['tkk']['status'])){
										$ch = " checked = \"checked\"";
									}
							?>
		              <div class="small col-lg-3 col-md-6 col-xs-12">
		                <label>
		                  <input type="checkbox" name="status[]" id="status" value="<?php echo $k; ?>"<?php echo $ch; ?>/>
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
							<div class="form-group<?php echo $_cari3; ?>">
								<label for="tahun">Tahun:</label>
	              <input type="text" class="form-control input-sm" name="tahun" maxlength="4" <?php echo $_tahun; ?>/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group<?php echo $_cari4; ?>">
		            <label for="bulan">Bulan:</label>
		            <select name="bulan" id="bulan" class="form-control input-sm">
									<?php echo $bulanOption; ?>
								</select>
		          </div>
						</div>
					</div>

        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-primary btn-flat btn-sm lihat_data"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
