<?php
	// mulai proses untuk pengambilan gaji
	$_cari1 = ""; $_cari2 = ""; $_cari3 = ""; $_cari4 = ""; $_cari5 = ""; $_cari6 = "";
	$_unit_id = "";
	$_status_kepeg = "";
	$_bulan = date('n');
	$_tahun = "";
	$_classTab[1] = "active";
	$_classTab_[1] = " active";
	$_classTab_[2] = "";
	$_classTab[2] = "";
	if(isset($_SESSION['ikw'])){
		if(isset($_SESSION['ikw']['unit_id']) && isExist($_SESSION['ikw']['unit_id'],'kepeg_unit','id')){
			$_unit_id = $_SESSION['ikw']['unit_id'];
			$_cari1 = " has-success";
		}
		if(isset($_SESSION['ikw']['status_kepeg'])){
			$_status_kepeg = $_SESSION['ikw']['status_kepeg'];
			$_cari2 = " has-success";
		}
		if(isset($_SESSION['ikw']['bulan']) && is_numeric($_SESSION['ikw']['bulan'])){
			$_bulan = $_SESSION['ikw']['bulan'];
			$_cari3 = " has-success";
		}
		if(isset($_SESSION['ikw']['tahun']) && strlen(trim($_SESSION['ikw']['tahun']))==4){
			$_tahun = " value=\"".$_SESSION['ikw']['tahun']."\"";
			$_cari4 = " has-success";
		}
		if(isset($_SESSION['ikw']['proses']['status'])){
			$_cari5 = " has-success";
		}
		if(isset($_SESSION['ikw']['jnspeg'])){
			$_cari6 = " has-success";
		}
		// untuk tab
		if(isset($_SESSION['ikw']['form']['tab']) && ($_SESSION['ikw']['form']['tab']==1 || $_SESSION['ikw']['form']['tab']==2)){
			foreach ($_classTab as $key => $value) {
				$_classTab[$key] = "";
				$_classTab_[$key] = "";
			}
	    $_classTab[$_SESSION['ikw']['form']['tab']] = "active";
	    $_classTab_[$_SESSION['ikw']['form']['tab']] = " active";
	  }
	}
?>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses  Insentif Kinerja Wajib
        </h3>
      </div>
      <div class="box-body">
        <p class="text-right">
					<?php
						if(isset($_SESSION['ikw'])){
					?>
						<button type="button" class="btn btn-default btn-flat btn-sm reset_data"><i class="fa fa-television"></i>&nbsp;&nbsp;&nbsp;Bersihkan layar</button>
					<?php
						}
					?>
          <button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_ikw"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses  Insentif Kinerja Wajib</button>
        </p>
      </div>
    </div>
		<div class="result_data">
			<?php
				if(isset($_SESSION['ikw'])){
			?>
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs pull-right">
					<li class="<?php echo $_classTab[2]; ?>"><a href="#tab_2" class="_tab_" data-toggle="tab" aria-expanded="false"><i class="fa fa-columns"></i>&nbsp;&nbsp;&nbsp;Total  Insentif Kinerja Wajib</a></li>
					<li class="<?php echo $_classTab[1]; ?>"><a href="#tab_1" class="_tab_" data-toggle="tab" aria-expanded="false"><i class="fa fa-scissors"></i>&nbsp;&nbsp;&nbsp;Potongan  Insentif Kinerja Wajib</a></li>
					<li class="pull-left header"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses  Insentif Kinerja Wajib</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane <?php echo $_classTab_[1]; ?>" id="tab_1">
						<!-- tabel potongan ikw -->
						<div class="table-responsive no-padding">
							<h4 class="text-center">Tabel Potongan  Insentif Kinerja Wajib <?php echo getStatusKepeg($_SESSION['ikw']['status_kepeg']); ?>
								<br/>
				<?php
					if(isset($_SESSION['ikw']['unit_id']) && isExist($_SESSION['ikw']['unit_id'],'kepeg_unit','id')){
						echo getValue($_SESSION['ikw']['unit_id'],'kepeg_unit','id','unit');
					}
				?>
								<br/>
								Bulan <?php echo wordMonth($_SESSION['ikw']['bulan']); ?> Tahun <?php echo $_SESSION['ikw']['tahun']; ?>
							</h4>
				<?php
					$VStatusPeg = "a.`statuspeg` = ".$_SESSION['ikw']['status_kepeg'];
					if($_SESSION['ikw']['status_kepeg']==1 || $_SESSION['ikw']['status_kepeg']==3){
						$VStatusPeg = "(a.`statuspeg` = 1 OR a.`statuspeg` = 3)";
						$_jenisrek = $_CONFIG['rek_tunj_pns'];
					}else{
						$_jenisrek = $_CONFIG['rek_nonpns'];
					}
					$sql = "SELECT a.`ikw`, a.`nip`, a.`pajak`, c.`nama`, c.`npwp`, d.`gol`, e.`jabatan`, b.*, f.`norekening` FROM `kepeg_tr_ikw` a RIGHT JOIN `kepeg_tr_pot_ikw` b ON a.`id_trans` = b.`id_trans_ikw` LEFT JOIN `kepeg_tb_pegawai` c ON a.`nip` = c.`nip` LEFT JOIN `kepeg_tb_golongan` d ON c.`golongan_id` = d.`id` LEFT JOIN `kepeg_tb_jabatan` e ON c.`jabatan_id` = e.`id` LEFT JOIN kepeg_tb_rekening f ON c.id = f.pegawai_id WHERE a.`bulan` LIKE '".$_SESSION['ikw']['bulan']."' AND a.`tahun` LIKE '".$_SESSION['ikw']['tahun']."' AND ".$VStatusPeg." AND a.`jenispeg` = ".$_SESSION['ikw']['jnspeg']." AND f.jenisrek = ".$_jenisrek;
					if(isset($_SESSION['ikw']['unit_id'])){
						$sql.=" AND a.unitid = ".$_SESSION['ikw']['unit_id'];
					}
					if(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])>1){
						$sql.= " AND ( c.`status` = ".implode(" OR c.`status` = ", $_SESSION['ikw']['proses']['status']).")";
					}elseif(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])==1){
						$sql.= " AND c.`status` = ".$_SESSION['ikw']['proses']['status'][0];
					}
					$sql.=$_CONFIG['ikw']['order'];
					$jum = getRow($sql);
					if($jum>0){
						$data = getdatadb($sql);
				?>
							<form id="jamaah" action="<?php echo $GLOBALS['path']; ?>/process.php" method="post">
								<input type="hidden" name="act" id="act" value="ikw_pot_hapus_berjamaah"/>
								<div class="message-jamaah"></div>
								<p class="pull-right">
									<button type="button" class="btn btn-danger btn-flat btn-sm hapus_data"><i class="fa fa-trash"></i>&nbsp;&nbsp;Hapus yang dipilih</button>
									<button type="button" class="btn btn-primary btn-flat btn-sm simpan_data"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan perubahan yang dibuat</button>
									<button type="button" class="btn btn-primary btn-flat btn-sm cetak_data"><i class="fa fa-download"></i>&nbsp;&nbsp;Download daftar ini</button>
								</p>
								<?php echo showDaftarPotonganIKW($data); ?>
							</form>
				<?php
					}else{
						echo msgGagal("Tidak ada data yang diharapkan, sehingga harus melakukan proses data  Insentif Kinerja Wajib terlebih dahulu.");
					}
				?>
						</div>
						<!-- end tabel potongan ikw -->
					</div>
					<div class="tab-pane <?php echo $_classTab_[2]; ?>" id="tab_2">
						<!-- tabel ikw totalan -->
						<div class="table-responsive no-padding">
							<h4 class="text-center">Tabel  Insentif Kinerja Wajib <?php echo getStatusKepeg($_SESSION['ikw']['status_kepeg']); ?>
								<br/>
				<?php
					if(isset($_SESSION['ikw']['unit_id']) && isExist($_SESSION['ikw']['unit_id'],'kepeg_unit','id')){
						echo getValue($_SESSION['ikw']['unit_id'],'kepeg_unit','id','unit');
					}
				?>
								<br/>
								Bulan <?php echo wordMonth($_SESSION['ikw']['bulan']); ?> Tahun <?php echo $_SESSION['ikw']['tahun']; ?>
							</h4>
				<?php
					$VStatusPeg = "a.`statuspeg` = ".$_SESSION['ikw']['status_kepeg'];
					if($_SESSION['ikw']['status_kepeg']==1 || $_SESSION['ikw']['status_kepeg']==3){
						$VStatusPeg = "(a.`statuspeg` = 1 OR a.`statuspeg` = 3)";
						$_jenisrek = $_CONFIG['rek_tunj_pns'];
					}else{
						$_jenisrek = $_CONFIG['rek_nonpns'];
					}
					$sql = "SELECT a.*, c.nama, c.npwp, d.gol, e.jabatan, f.norekening FROM `kepeg_tr_ikw` a LEFT JOIN `kepeg_tb_pegawai` c ON a.nip = c.nip LEFT JOIN `kepeg_tb_golongan` d ON c.golongan_id = d.id LEFT JOIN `kepeg_tb_jabatan` e ON c.`jabatan_id` = e.`id` LEFT JOIN kepeg_tb_rekening f ON c.id = f.pegawai_id WHERE a.`bulan` LIKE '".$_SESSION['ikw']['bulan']."' AND a.`tahun` LIKE '".$_SESSION['ikw']['tahun']."' AND ".$VStatusPeg." AND a.jenispeg = ".$_SESSION['ikw']['jnspeg']." AND f.jenisrek = ".$_jenisrek;
					if(isset($_SESSION['ikw']['unit_id'])){
						$sql.=" AND a.`unitid` = ".$_SESSION['ikw']['unit_id'];
					}
					if(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])>1){
						$sql.= " AND ( c.`status` = ".implode(" OR c.`status` = ", $_SESSION['ikw']['proses']['status']).")";
					}elseif(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])==1){
						$sql.= " AND c.`status` = ".$_SESSION['ikw']['proses']['status'][0];
					}
					$sql.=$_CONFIG['ikw']['order'];
					$jum = getRow($sql);
					if($jum>0){
						$data = getdatadb($sql);
				?>
							<form id="jamaah2" action="<?php echo $GLOBALS['path']; ?>/process.php" method="post">
								<input type="hidden" name="act" id="act" value="ikw_hapus_berjamaah"/>
								<div class="message-jamaah2"></div>
								<p class="pull-right">
									<button type="button" class="btn btn-danger btn-flat btn-sm hapus_data2"><i class="fa fa-trash"></i>&nbsp;&nbsp;Hapus yang dipilih</button>
									<button type="button" class="btn btn-primary btn-flat btn-sm simpan_data2"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan perubahan yang dibuat</button>
									<button type="button" class="btn btn-primary btn-flat btn-sm cetak_data2"><i class="fa fa-download"></i>&nbsp;&nbsp;Download daftar ini</button>
								</p>
								<?php echo showDaftarIKW($data); ?>
							</form>
				<?php
					}else{
						echo msgGagal("Tidak ada data yang diharapkan, sehingga harus melakukan proses data  Insentif Kinerja Wajib terlebih dahulu.");
					}
				?>
						</div>
						<!-- end tabel ikw totalan -->
					</div>
				</div>
				<!-- /.tab-content -->
			</div>
			<?php
				}else{
			?>
			<p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="small text-bold"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses  IKW</span>&nbsp;&nbsp; untuk memulai proses data  Insentif Kinerja Wajib.</p>
			<?php
				}
			?>
		</div>
  </div>
</div>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ikw" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-ikw" action="<?php echo $_PATH; ?>/process.php?page=<?php echo $_GET['page']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ikw_proses"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Data  Insentif Kinerja Wajib</h5>
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
              <?php echo getStatusKepegOption2($_status_kepeg); ?>
            </select>
          </div>
					<div class="form-group<?php echo $_cari5; ?>">
						<label>Status Pegawai:</label>
            <div class="scroll-150">
						<?php
							$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar');
							foreach ($stt as $k => $v) {
								$ch = "";
								if(isset($_SESSION['ikw']['proses']['status']) && in_array($k,$_SESSION['ikw']['proses']['status'])){
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
					<div class="form-group<?php echo $_cari6; ?>">
            <label for="jnspeg">Jenis Pegawai:</label>
            <select name="jnspeg" id="jnspeg" class="form-control input-sm">
              <?php
								$_jenispeg = array(array(1,'Dosen Pengajar'),array(2,'Tenaga Kependidikan'));
								foreach ($_jenispeg as $k => $v) {
									$_s = "";
									if(isset($_SESSION['ikw']['jnspeg']) && $_SESSION['ikw']['jnspeg']==$v[0]){
										$_s = " selected";
									}
							?>
							<option value="<?php echo $v[0]; ?>"<?php echo $_s; ?>><?php echo $v[1]; ?></option>
							<?php
								}
							?>
            </select>
          </div>
          <div class="form-group<?php echo $_cari3; ?>">
            <label for="bulan">Bulan  IKW:</label>
            <select name="bulan" id="bulan" class="form-control input-sm">
              <?php echo getBulanOption($_bulan); ?>
            </select>
          </div>
          <div class="form-group<?php echo $_cari4; ?>">
            <label for="tahun">Tahun  IKW:</label>
            <input type="text" class="form-control input-sm" id="tahun" name="tahun" maxlength="4" placeholder="Tahun"<?php echo $_tahun; ?>/>
          </div>
        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-primary btn-flat btn-sm do_data"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Data</button>
            <button type="button" class="btn btn-default btn-flat btn-sm lihat_data"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
