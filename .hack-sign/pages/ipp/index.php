<?php
	// mulai proses untuk pengambilan gaji
	$_cari1 = ""; $_cari2 = ""; $_cari3 = ""; $_cari3_1 = ""; $_cari3_2 = ""; $_cari4 = ""; $_cari5 = ""; $_ch_1 = ""; $_ch_2 = ""; $_cari6 = "";
	$_unit_id = "";
	$_status_kepeg = "";
	$_tgl_transaksi = " value=\"".date('Y')."\"";
	$_classTab[1] = "active";
	$_classTab_[1] = " active";
	if(isset($_SESSION['ipp'])){
		if(isset($_SESSION['ipp']['unit_id']) && isExist($_SESSION['ipp']['unit_id'],'kepeg_unit','id')){
			$_unit_id = $_SESSION['ipp']['unit_id'];
			$_cari1 = " has-success";
		}
		if(isset($_SESSION['ipp']['status_kepeg'])){
			$_status_kepeg = $_SESSION['ipp']['status_kepeg'];
			$_cari2 = " has-success";
		}
		if(isset($_SESSION['ipp']['tgl_transaksi'])){
			$_tgl_transaksi = " value=\"".$_SESSION['ipp']['tgl_transaksi']."\"";
			$_cari3 = " has-success";
		}
		if(isset($_SESSION['ipp']['pilih_tgl_transaksi'])){
			if($_SESSION['ipp']['pilih_tgl_transaksi']==1){
				$_cari3_1 = " has-success";
				$_ch_1 = " checked";
			}elseif($_SESSION['ipp']['pilih_tgl_transaksi']==2){
				$_cari3_2 = " has-success";
				$_ch_2 = " checked";
			}
		}
		if(isset($_SESSION['ipp']['semester']) && is_numeric($_SESSION['ipp']['semester'])){
			$_cari4 = " has-success";
		}
		if(isset($_SESSION['ipp']['proses']['status'])){
			$_cari5 = " has-success";
		}
		if(isset($_SESSION['ipp']['jnspeg'])){
			$_cari6 = " has-success";
		}
	}
?>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Insentif Perbaikan Penghasilan
        </h3>
      </div>
      <div class="box-body">
        <p class="text-right">
					<?php
						if(isset($_SESSION['ipp'])){
					?>
						<button type="button" class="btn btn-default btn-flat btn-sm reset_data"><i class="fa fa-television"></i>&nbsp;&nbsp;&nbsp;Bersihkan layar</button>
					<?php
						}
					?>
          <button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_ipp"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses IPP</button>
        </p>
      </div>
    </div>
		<div class="result_data">
			<?php
				if(isset($_SESSION['ipp'])){
			?>
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs pull-right">
					<li class="<?php echo $_classTab[1]; ?>"><a href="#tab_1" class="_tab_" data-toggle="tab" aria-expanded="false"><i class="fa fa-columns"></i>&nbsp;&nbsp; Insentif Perbaikan Penghasilan</a></li>
					<li class="pull-left header"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Insentif Perbaikan Penghasilan</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane <?php echo $_classTab_[1]; ?>" id="tab_1">
						<!-- tabel ipp -->
						<div class="table-responsive no-padding">
							<h4 class="text-center">Tabel Insentif Perbaikan Penghasilan <?php echo getJenisPeg($_SESSION['ipp']['jnspeg'])." ".getStatusKepeg($_SESSION['ipp']['status_kepeg']); ?>
								<br/>
				<?php
					if(isset($_SESSION['ipp']['unit_id']) && isExist($_SESSION['ipp']['unit_id'],'kepeg_unit','id')){
						echo getValue($_SESSION['ipp']['unit_id'],'kepeg_unit','id','unit');
					}
				?>
								<br/>
								Semester <?php echo getSemester($_SESSION['ipp']['semester']); ?><br/>Tanggal Transaksi <?php echo balikTgl(getInputDate(str_replace("/","-",$_SESSION['ipp']['tgl_transaksi']))); ?>
							</h4>
				<?php
					// $vSQL="";
					$VStatusPeg = "a.`statuspeg` = ".$_SESSION['ipp']['status_kepeg'];
					if($_SESSION['ipp']['status_kepeg']==1 || $_SESSION['ipp']['status_kepeg']==3){
						$VStatusPeg = "(a.`statuspeg` = 1 OR a.`statuspeg` = 3)";
						$_jenisrek = $_CONFIG['rek_tunj_pns'];
					}else{
						$_jenisrek = $_CONFIG['rek_nonpns'];
					}
					$sql = "SELECT a.*, c.`nama`, d.`gol`, e.`jabatan`, c.`npwp`, f.`norekening` FROM `kepeg_tr_ipp` a LEFT JOIN `kepeg_tb_pegawai` c ON a.`nip` = c.`nip` LEFT JOIN `kepeg_tb_golongan` d ON c.`golongan_id` = d.`id` LEFT JOIN `kepeg_tb_jabatan` e ON c.`jabatan_id` = e.`id` LEFT JOIN `kepeg_tb_rekening` f ON f.`pegawai_id` = c.`id` WHERE a.`tgl_transaksi` LIKE '".$_SESSION['ipp']['tgl_transaksi']."%' AND a.`semester` = ".$_SESSION['ipp']['semester']." AND ".$VStatusPeg." AND a.`jenispeg` = ".$_SESSION['ipp']['jnspeg']." AND f.jenisrek = ".$_jenisrek;

					if(isset($_SESSION['ipp']['unit_id'])){
						$sql.=" AND a.`unitid` = ".$_SESSION['ipp']['unit_id'];
					}

					if(isset($_SESSION['ipp']['proses']['status']) && is_array($_SESSION['ipp']['proses']['status']) && count($_SESSION['ipp']['proses']['status'])>1){
						$sql.= " AND ( c.`status` = ".implode(" OR c.`status` = ", $_SESSION['ipp']['proses']['status']).")";
					}elseif(isset($_SESSION['ipp']['proses']['status']) && is_array($_SESSION['ipp']['proses']['status']) && count($_SESSION['ipp']['proses']['status'])==1){
						$sql.= " AND c.`status` = ".$_SESSION['ipp']['proses']['status'][0];
					}

					// echo $sql;
					$jum = getRow($sql);
					if($jum>0){
						$data = getdatadb($sql);
				?>
							<form id="jamaah" action="<?php echo $GLOBALS['path']; ?>/process.php" method="post">
								<input type="hidden" name="act" id="act" value="ipp_hapus_berjamaah"/>
								<div class="message-jamaah"></div>
								<p class="pull-right">
									<button type="button" class="btn btn-danger btn-flat btn-sm hapus_data"><i class="fa fa-trash"></i>&nbsp;&nbsp;Hapus yang dipilih</button>
									<button type="button" class="btn btn-primary btn-flat btn-sm cetak_data"><i class="fa fa-download"></i>&nbsp;&nbsp;Download daftar ini</button>
								</p>
								<?php
									echo showDaftarIPP($data);
									// echo msgSukses("Sukses mengeksekusi sql. Jajalen. |_(^.^)_|");
								?>
							</form>
				<?php
					}else{
						echo msgGagal("Tidak ada data yang diharapkan, sehingga harus melakukan proses data  IPP terlebih dahulu.");
					}
				?>
						</div>
						<!-- end tabel potongan ikw -->
					</div>
				</div>
				<!-- /.tab-content -->
			</div>
			<?php
				}else{
			?>
			<p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="small text-bold"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses  IPP</span>&nbsp;&nbsp; untuk memulai proses data Insentif Perbaikan Penghasilan.</p>
			<?php
				}
			?>
		</div>
  </div>
</div>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ipp" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-ipp" action="<?php echo $_PATH; ?>/process.php?page=<?php echo $_GET['page']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ipp_proses"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Data  Insentif Perbaikan Penghasilan</h5>
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
								if(isset($_SESSION['ipp']['proses']['status']) && in_array($k,$_SESSION['ipp']['proses']['status'])){
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
          <div class="form-group<?php echo $_cari3; ?>">
            <label for="tgl_transaksi">Tahun  IPP:</label>
						<div class="row">
							<div class="col-md-6">
								<div class="input-group<?php echo $_cari3_1; ?>">
		              <input type="text" class="form-control input-sm" name="tgl_transaksi" id="tgl_transaksi" maxlength="4"<?php echo $_tgl_transaksi; ?>/>
		            </div>
							</div>
						</div>
          </div>
          <div class="form-group<?php echo $_cari4; ?>">
            <label for="tahun">Semester  IPP:</label>
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
