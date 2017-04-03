<?php
	// mulai proses untuk pengambilan gaji
	$_cari1 = ""; $_cari2 = ""; $_cari3 = ""; $_cari4 = ""; $_cari5 = "";
	$_unit_id = "";
	$_status_kepeg = "";
	$_bulan = date('n');
	$_tahun = "";
	$_message = "<div class=\"alert alert-warning text-center\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;&nbsp;Pilih data yang akan diproses.</div>";
	if(isset($_SESSION['gaji'])){
		if(isset($_SESSION['gaji']['unit_id']) && isExist($_SESSION['gaji']['unit_id'],'kepeg_unit','id')){
			$_unit_id = $_SESSION['gaji']['unit_id'];
			$_cari1 = " has-success";
		}
		if(isset($_SESSION['gaji']['status_kepeg'])){
			$_status_kepeg = $_SESSION['gaji']['status_kepeg'];
			$_cari2 = " has-success";
		}
		if(isset($_SESSION['gaji']['bulan']) && is_numeric($_SESSION['gaji']['bulan'])){
			$_bulan = $_SESSION['gaji']['bulan'];
			$_cari3 = " has-success";
		}
		if(isset($_SESSION['gaji']['tahun']) && strlen(trim($_SESSION['gaji']['tahun']))==4){
			$_tahun = " value=\"".$_SESSION['gaji']['tahun']."\"";
			$_cari4 = " has-success";
		}
		if(isset($_SESSION['gaji']['proses']['status'])){
			$_cari5 = " has-success";
		}
	}
?>
<div class="row">
	<div class="col-md-3">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">
					<i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Gaji
				</h3>
			</div>
			<form id="prosesgaji" action="<?php echo $_PATH; ?>/process.php?page=<?php echo $_GET['page']; ?>" method="post">
				<input type="hidden" id="act" name="act" value="gaji_proses"/>
				<div class="box-body">
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
						<div class="scroll-100">
						<?php
							$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar');
							foreach ($stt as $k => $v) {
								$ch = "";
								if(isset($_SESSION['gaji']['proses']['status']) && in_array($k,$_SESSION['gaji']['proses']['status'])){
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
				<div class="box-footer">
					<div class="btn-group pull-right">
            <button type="submit" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Data</button>
            <button type="button" class="btn btn-default btn-flat btn-sm lihat_data"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button>
          </div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-9">
		<div class="box box-default box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-folder-open-o"></i>&nbsp;&nbsp;&nbsp;Hasil Proses Gaji</h3>
			</div>
			<div class="box-body result_data">
				<?php
					if(isset($_SESSION['gaji'])){
				?>
					<p class="text-right">
						<button type="button" class="btn btn-default btn-flat btn-sm reset_data"><i class="fa fa-television"></i>&nbsp;&nbsp;&nbsp;Bersihkan layar</button>
					</p>
				<?php
						// CONCAT(b.glr_dpn,' ',b.nama,' ',b.glr_blkg) AS nama
						if(is_numeric($_status_kepeg) && isset($_SESSION['gaji']['bulan']) && is_numeric($_SESSION['gaji']['bulan']) && isset($_SESSION['gaji']['tahun']) && strlen(trim($_SESSION['gaji']['tahun']))==4){
							$sql = "SELECT a.id, a.nip, b.nama, c.jabatan, d.ijazah, a.nominalg AS gaji FROM kepeg_tr_dgaji a LEFT JOIN kepeg_tb_pegawai b ON a.nip = b.nip LEFT JOIN kepeg_tb_jabatan c ON b.jabatan_id = c.id LEFT JOIN kepeg_tb_pendidikan d ON d.id = b.ijazah_id WHERE status_kepeg = '".intval($_SESSION['gaji']['status_kepeg'])."' AND bulan = '".intval($_SESSION['gaji']['bulan'])."' AND tahun = '".intval($_SESSION['gaji']['tahun'])."'";
							if(isset($_SESSION['gaji']['unit_id']) && is_numeric($_SESSION['gaji']['unit_id']) && isExist($_SESSION['gaji']['unit_id'],'kepeg_unit','id')){
								$sql.=" AND unit_id = ".intval($_SESSION['gaji']['unit_id']);
							}
							$sql.= $_CONFIG['gaji']['order'];
							$row = getRow($sql);
							if($row>0){
								$_dbData = getdatadb($sql);
								showDaftarGaji($_dbData);
							}else{
								echo msgGagal("Belum ada data yang diharapkan, sehingga perlu melakukan proses data terlebih dahulu.<br/>Terimakasih.");
							}
						}
					}else{
						echo $_message;
					}
				?>
			</div>
		</div>
	</div>
</div>
