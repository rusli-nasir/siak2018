<?php
	// mulai proses untuk pengambilan gaji
	$_cari1 = ""; $_cari2 = ""; $_cari3 = ""; $_cari4 = ""; $_cari5 = "";
	$_unit_id = "";
	$_status_kepeg = "";
	$_bulan = date('n');
	$_tahun = "";
	if(isset($_SESSION['tunjangan'])){
		if(isset($_SESSION['tunjangan']['unit_id']) && isExist($_SESSION['tunjangan']['unit_id'],'kepeg_unit','id')){
			$_unit_id = $_SESSION['tunjangan']['unit_id'];
			$_cari1 = " has-success";
		}
		if(isset($_SESSION['tunjangan']['status_kepeg'])){
			$_status_kepeg = $_SESSION['tunjangan']['status_kepeg'];
			$_cari2 = " has-success";
		}
		if(isset($_SESSION['tunjangan']['bulan']) && is_numeric($_SESSION['tunjangan']['bulan'])){
			$_bulan = $_SESSION['tunjangan']['bulan'];
			$_cari3 = " has-success";
		}
		if(isset($_SESSION['tunjangan']['tahun']) && strlen(trim($_SESSION['tunjangan']['tahun']))==4){
			$_tahun = " value=\"".$_SESSION['tunjangan']['tahun']."\"";
			$_cari4 = " has-success";
		}
		if(isset($_SESSION['tunjangan']['proses']['status'])){
			$_cari5 = " has-success";
		}
	}
?>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Tunjangan Kesejaterahan
        </h3>
      </div>
      <div class="box-body">
        <p class="text-right">
				<?php
					if(isset($_SESSION['tunjangan'])){
				?>
					<button type="button" class="btn btn-default btn-flat btn-sm reset_data"><i class="fa fa-television"></i>&nbsp;&nbsp;&nbsp;Bersihkan layar</button>
				<?php
					}
				?>
          <button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_tunjangan"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Tunjangan Kesejaterahan</button>
        </p>
        <div class="result_data">
          <?php
            if(isset($_SESSION['tunjangan'])){
              if($_status_kepeg == 2){
                showDaftarTunjanganBLU($_CONFIG);
              }elseif($_status_kepeg == 4){
								//showDaftarTunjanganKONTRAK($_CONFIG);
								echo msgGagal("Tunjangan Kesejaterahan tidak diperuntukkan bagi Tenaga Kontrak.");
              }
            }else{
          ?>
          <p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="small text-bold"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Tunjangan</span>&nbsp;&nbsp; untuk memulai proses data tunjangan kesejaterahan.</p>
          <?php
            }
          ?>
        </div>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </div>
</div>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_tunjangan" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-tunjangan" action="<?php echo $_PATH; ?>/process.php?page=<?php echo $_GET['page']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="tunjangan_proses"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Data Tunjangan Kesejaterahan</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
          <div class="form-group<?php echo $_cari1; ?>">
            <label for="unit_id">Unit Pegawai:</label>
            <select name="unit_id" id="unit_id" class="form-control input-sm">
            	<option value="">seluruhnya</option>
              <?php echo getUnitOption($_unit_id); ?>
            </select>
          </div>
					<div class="form-group<?php echo $_cari2; ?>">
            <label for="status_kepeg">Status Kepegawaian:</label>
            <select name="status_kepeg" id="status_kepeg" class="form-control input-sm">
              <?php echo getStatusKepegOption($_status_kepeg); ?>
            </select>
          </div>
					<div class="form-group<?php echo $_cari5; ?>">
						<label>Status Pegawai:</label>
            <div class="scroll-150">
						<?php
							$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar');
							foreach ($stt as $k => $v) {
								$ch = "";
								if(isset($_SESSION['tunjangan']['proses']['status']) && in_array($k,$_SESSION['tunjangan']['proses']['status'])){
									$ch = " checked = \"checked\"";
								}
						?>
              <div class="checkbox small">
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
          <div class="form-group<?php echo $_cari3; ?>">
            <label for="bulan">Bulan Penggajian:</label>
            <select name="bulan" id="bulan" class="form-control input-sm">
              <?php echo getBulanOption($_bulan); ?>
            </select>
          </div>
          <div class="form-group<?php echo $_cari4; ?>">
            <label for="tahun">Tahun Penggajian:</label>
            <input type="text" class="form-control input-sm" id="tahun" name="tahun" maxlength="4" placeholder="Tahun"<?php echo $_tahun; ?>/>
          </div>
        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-primary btn-flat btn-sm do_data"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Data</button>
            <button type="button" class="btn btn-default btn-flat btn-sm lihat_data"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button>
						<button type="button" class="btn btn-default btn-flat btn-sm reset_data"><i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;Reset Data</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
