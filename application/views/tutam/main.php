<script type="text/javascript">

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
	p{
		margin-bottom: 0;
		padding:3px;
	}
</style>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h4 class="page-header">
					<i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Data Insentif Perbaikan Penghasilan
				</h4>
				<ul class="nav nav-tabs" role="tablist" id="kentut_tab">
	        <li role="presentation" class="active"><a href="#boptn-bh" role="tab" data-toggle="tab" aria-expanded="true">BOPTN-BH</a></li>
					<li role="presentation"><a href="#70" role="tab" data-toggle="tab" aria-expanded="false">70%</a></li>
					<li role="presentation"><a href="#uang_makan" role="tab" data-toggle="tab" aria-expanded="false">Uang Makan</a></li>
	        <li role="presentation"><a href="#pnbp" role="tab" data-toggle="tab" aria-expanded="false">PNBP</a></li>
					<li role="presentation"><a href="#pajak" role="tab" data-toggle="tab" aria-expanded="false">Pajak</a></li>
					<li role="presentation"><a href="#kompilasi" role="tab" data-toggle="tab" aria-expanded="false">Kompilasi</a></li>
  			</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="boptn-bh">
						<div style="background-color:#ccc;padding:5px;">
							<div style="background-color:#fff;">
								<p>Tampilan Daftar yang dibayarkan untuk Tenaga Kontrak via BOPTN-BH</p>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="70">
						<div style="background-color:#ccc;padding:5px;">
							<div style="background-color:#fff;">
								Tampilan Daftar yang dibayarkan untuk Tenaga Kontrak Tunjangan Kinerja 70%
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="uang_makan">
						<div style="background-color:#ccc;padding:5px;">
							<div style="background-color:#fff;">
								Tampilan Daftar yang dibayarkan untuk Tenaga Kontrak Uang Makan
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="pnbp">
						<div style="background-color:#ccc;padding:5px;">
							<div style="background-color:#fff;">
								Tampilan Daftar yang dibayarkan untuk Tenaga Kontrak via PNBP
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="pajak">
						<div style="background-color:#ccc;padding:5px;">
							<div style="background-color:#fff;">
								Tampilan Daftar potongan pajak untuk Tenaga Kontrak
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="kompilasi">
						<div style="background-color:#ccc;padding:5px;">
							<div style="background-color:#fff;">
								Tampilan Daftar yang dibayarkan untuk Tenaga Kontrak Kompilasi
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php /*
<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ipp" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ipp" action="<?php echo site_url('modul_gaji/ipp_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ipp_proses"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Data Tunjangan IPP</h5>
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
							<div class="form-group<?php echo $_cari2; ?>">
		            <label for="status_kepeg">Status Kepegawaian:</label>
		            <select name="status_kepeg" id="status_kepeg" class="form-control input-sm">
		              <?php echo $statusKepegFullOption; ?>
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
									if(isset($_SESSION['ipp']['proses']['status']) && in_array($k,$_SESSION['ipp']['proses']['status'])){
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
					<div class="form-group<?php echo $_cari6; ?>">
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

        	<div class="row">
						<div class="col-md-4">
							<div class="form-group<?php echo $_cari3; ?>">
								<label for="tgl_transaksi">Tahun Pencairan IPP:</label>
	              <input type="text" class="form-control input-sm" name="tgl_transaksi" maxlength="4" <?php echo $_tgl_transaksi; ?>/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group<?php echo $_cari4; ?>">
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
            <!-- <button type="button" class="btn btn-default btn-flat btn-sm lihat_data"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button> -->
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="kriteria_ipp_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ipp_lihat" action="<?php echo site_url('modul_gaji/ipp_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ipp_proses"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Data Tunjangan IPP</h5>
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
							<div class="form-group<?php echo $_cari2; ?>">
		            <label for="status_kepeg">Status Kepegawaian:</label>
		            <select name="status_kepeg" id="status_kepeg" class="form-control input-sm">
		              <?php echo $statusKepegFullOption; ?>
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
									if(isset($_SESSION['ipp']['proses']['status']) && in_array($k,$_SESSION['ipp']['proses']['status'])){
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
					<div class="form-group<?php echo $_cari6; ?>">
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

        	<div class="row">
						<div class="col-md-4">
							<div class="form-group<?php echo $_cari3; ?>">
								<label for="tgl_transaksi">Tahun Pencairan IPP:</label>
	              <input type="text" class="form-control input-sm" name="tgl_transaksi" maxlength="4" <?php echo $_tgl_transaksi; ?>/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group<?php echo $_cari4; ?>">
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
            <button type="button" class="btn btn-default btn-flat btn-sm lihat_data"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
*/ ?>
