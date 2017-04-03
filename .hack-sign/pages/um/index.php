<?php
	// mulai proses untuk pengambilan gaji
	$_cari1 = ""; $_cari2 = ""; $_cari3 = ""; $_cari4 = ""; $_cari5 = "";
	$_unit_id = "";
	$_status_kepeg = "";
	$_bulan = date('n');
	$_tahun = "";
	if(isset($_SESSION['um'])){
		if(isset($_SESSION['um']['unit_id']) && isExist($_SESSION['um']['unit_id'],'kepeg_unit','id')){
			$_unit_id = $_SESSION['um']['unit_id'];
			$_cari1 = " has-success";
		}
		if(isset($_SESSION['um']['status_kepeg'])){
			$_status_kepeg = $_SESSION['um']['status_kepeg'];
			$_cari2 = " has-success";
		}
		if(isset($_SESSION['um']['bulan']) && is_numeric($_SESSION['um']['bulan'])){
			$_bulan = $_SESSION['um']['bulan'];
			$_cari3 = " has-success";
		}
		if(isset($_SESSION['um']['tahun']) && strlen(trim($_SESSION['um']['tahun']))==4){
			$_tahun = " value=\"".$_SESSION['um']['tahun']."\"";
			$_cari4 = " has-success";
		}
		if(isset($_SESSION['um']['proses']['status'])){
			$_cari5 = " has-success";
		}
	}
?>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Uang Makan
        </h3>
      </div>
      <div class="box-body">
        <p class="text-right">
					<?php
						if(isset($_SESSION['um'])){
					?>
						<button type="button" class="btn btn-default btn-flat btn-sm reset_data"><i class="fa fa-television"></i>&nbsp;&nbsp;&nbsp;Bersihkan layar</button>
					<?php
						}
					?>
          <button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_uangmakan"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Uang Makan</button>
        </p>
        <div class="result_data">
          <?php
            if(isset($_SESSION['um'])){

                $sql = "SELECT a.*, c.nama, d.jabatan
                        FROM kepeg_tr_dmakan a
                        LEFT JOIN kepeg_tb_pegawai c ON a.nip = c.nip
                        LEFT JOIN kepeg_tb_jabatan d ON c.jabatan_id = d.id
                        WHERE a.statuspeg = '".intval($_SESSION['um']['status_kepeg'])."' AND a.bulan = '".intval($_SESSION['um']['bulan'])."' AND a.tahun = '".intval($_SESSION['um']['tahun'])."'";
  							if( isset($_SESSION['um']['unit_id']) && is_numeric($_SESSION['um']['unit_id']) && isExist( $_SESSION['um']['unit_id'],'kepeg_unit','id') ){
  								$sql.=" AND a.unitid = ".intval($_SESSION['um']['unit_id']);
  							}
  							$sql.= $_CONFIG['um']['order'];
                // echo $sql;
                $row = getRow($sql);
                // echo "<br/>Jumlah data: ".$row;
                echo "<div class=\"table-responsive no-padding\">";
                echo "<h4 class=\"text-center\">Tabel Uang Makan Pegawai ".getStatusKepeg($_SESSION['um']['status_kepeg']);
                echo "<br/>";
                if(isset($_SESSION['um']['unit_id']) && isExist($_SESSION['um']['unit_id'],'kepeg_unit','id')){
                  echo getValue($_SESSION['um']['unit_id'],'kepeg_unit','id','unit');
                  echo "<br/>";
                }
                echo "Bulan ".wordMonth($_SESSION['um']['bulan']);
                echo " Tahun ".$_SESSION['um']['tahun'];
                echo "</h4>";
                // jika row nya lebih dari 0
                if($row > 0){
									$timeNow = wordMonth($_SESSION['um']['bulan'])." ".$_SESSION['um']['tahun'];
									if($_SESSION['um']['bulan']==1){
										$timePast = wordMonth(12)." ".($_SESSION['um']['tahun']-1);
									}else{
										$timePast = wordMonth($_SESSION['um']['bulan']-1)." ".$_SESSION['um']['tahun'];
									}
                  echo "<form id=\"jamaah\" action=\"".$GLOBALS['path']."/process.php\" method=\"post\">";
                  echo "<input type=\"hidden\" name=\"act\" id=\"act\" value=\"um_hapus_berjamaah\"/>";
                  echo "<div class=\"message-jamaah\"></div>";

                  echo "<p class=\"pull-right\">
                    <button type=\"button\" class=\"btn btn-danger btn-flat btn-sm hapus_data\"><i class=\"fa fa-trash\"></i>&nbsp;&nbsp;Hapus yang dipilih</button>
                    <button type=\"button\" class=\"btn btn-primary btn-flat btn-sm simpan_data\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan perubahan yang dibuat</button>
                  </p>";

                  echo "<table class=\"table table-bordered table-hover small tabel_tunjangan scroll-300\">";
                  echo "<thead>";
                  echo "<tr>
													<th rowspan=\"2\" class=\"text-center\"><input type=\"checkbox\" class=\"master_id\" id=\"master_id\"/></th>
													<th rowspan=\"2\" class=\"text-center\">No</th>
													<th rowspan=\"2\" class=\"text-center\">Nama</th>
													<th rowspan=\"2\" class=\"text-center\">Jabatan</th>
													<th colspan=\"6\" class=\"text-center\">Uang Makan</th>
													<th width=\"50px\" rowspan=\"2\">&nbsp;</th>
												</tr>";
                  echo "<tr>
													<th class=\"text-center\" style=\"max-width:75px;\">Jumlah hari kerja ".$timeNow."</th>
													<th class=\"text-center\" style=\"max-width:75px;\">Uang makan/hari</th>
													<th class=\"text-center\" style=\"max-width:75px;\">Uang Makan ".$timeNow."</th>
													<th class=\"text-center\" style=\"max-width:75px;\">Jumlah tidak hadir ".$timePast."</th>
													<th class=\"text-center\" style=\"max-width:75px;\">Potongan uang makan ".$timePast."</th>
													<th class=\"text-center\" style=\"max-width:75px;\">Penerimaan uang makan</th>
												</tr>";
                  echo "</thead>";
                  $i=1;
                  // $totalg = 0;
                  // $totalp = 0;
                  // $totalnp = 0;
                  // $totala = 0;
                  // $totalna = 0;
                  // $totalb = 0;
                  // $total = 0;
                  echo "<tbody>";
                  $data = getdatadb($sql);
                  foreach ($data as $k => $v) {
                    echo "<tr>";
                    echo "<td class=\"text-center\">";
                    echo "<input type=\"hidden\" name=\"_id[]\" value=\"".$v['id']."\"/>";
                    echo "<input type=\"checkbox\" name=\"id[]\" class=\"id_tr_um\" value=\"".$v['id']."\"/>";
                    echo "</td>";
                    echo "<td class=\"text-right\">";
                    echo $i;
                    echo ".</td>";
                    echo "<td nowrap=\"nowrap\">";
                    echo $v['nama'];
                    echo "</td>";
                    echo "<td>";
                    echo $v['jabatan'];
                    echo "</td>";

										// echo "<td class=\"text-center\" colspan=\"6\">".number_format($v['perharih'],0,',','.').",-</td>";
										if($i==1){
											echo "<td class=\"text-center\"><input type=\"text\" name=\"jumlahh\" class=\"form-control input-sm text-center um_ubah_jumlahh\" style=\"max-width:75px;display:inline;\" maxlength=\"2\" id=\"".$v['id']."\" value=\"".$v['jumlahh']."\"/></td>";
										}else{
											echo "<td class=\"text-center jumlahh\">".$v['jumlahh']."</td>";
										}
										echo "<td class=\"text-right\">".number_format($v['perharih'],0,',','.').",-</td>";
										echo "<td class=\"text-right\">".number_format($v['nominalh'],0,',','.').",-</td>";
										echo "<td class=\"text-center\"><input type=\"text\" name=\"jumlahth[]\" class=\"form-control input-sm text-center um_ubah_jumlahth\" style=\"max-width:75px;display:inline;\" maxlength=\"2\" id=\"".$v['id']."\" value=\"".$v['jumlahth']."\"/></td>";
										echo "<td class=\"text-right\">".number_format($v['nominalth'],0,',','.').",-</td>";
										echo "<td class=\"text-right\">".number_format($v['totalh'],0,',','.').",-</td>";
                    // echo "<td><input type=\"text\" name=\"pasangan[]\" class=\"form-control input-sm text-right um_ubah_pasangan\" style=\"max-width:50px;\" maxlength=\"2\" id=\"".$v['id']."\" value=\"".$v['pasangan']."\"/></td>";
                    // echo "<td class=\"text-right\">".number_format($v['nominalp'],0,',','.').",-</td>";
                    // echo "<td><input type=\"text\" name=\"anak[]\" class=\"form-control input-sm text-right tunjangan_ubah_anak\" style=\"max-width:50px;\" maxlength=\"2\" id=\"".$v['id']."\" value=\"".$v['anak']."\"/></td>";
                    // echo "<td class=\"text-right\">".number_format($v['nominala'],0,',','.').",-</td>";
                    // echo "<td class=\"text-right\">".number_format($v['nominalb'],0,',','.').",-</td>";
                    // echo "<td class=\"text-right\">".number_format($v['nominalt'],0,',','.').",-</td>";

                    echo "<td>";
                    echo "<button type=\"button\" class=\"btn btn-danger btn-flat btn-sm hapus_single\" id=\"".$v['id']."\"><i class=\"fa fa-trash\"></i></button>";
                    echo "</td>";
                    echo "</tr>";
                    // $totalg += $v['gaji'];
                    // $totalp += $v['pasangan'];
                    // $totalnp += $v['nominalp'];
                    // $totala += $v['anak'];
                    // $totalna += $v['nominala'];
                    // $totalb += $v['nominalb'];
                    // $total += $v['nominalt'];
                    $i++;
                  }
                  echo "<tr>";
                  echo "<th colspan=\"4\" class=\"text-center\">TOTAL</td>";
                  // echo "<th class=\"text-right\">";
                  // echo number_format($totalg,0,',','.');
                  // echo ",-</th>";
                  // echo "<th class=\"text-right\">";
                  // echo number_format($totalp,0,',','.');
                  // echo ",-</th>";
                  // echo "<th class=\"text-right\">";
                  // echo number_format($totalnp,0,',','.');
                  // echo ",-</th>";
                  // echo "<th class=\"text-right\">";
                  // echo number_format($totala,0,',','.');
                  // echo ",-</th>";
                  // echo "<th class=\"text-right\">";
                  // echo number_format($totalna,0,',','.');
                  // echo ",-</th>";
                  // echo "<th class=\"text-right\">";
                  // echo number_format($totalb,0,',','.');
                  // echo ",-</th>";
                  // echo "<th class=\"text-right\">";
                  // echo number_format($total,0,',','.');
                  // echo ",-</th>";
									echo "<th colspan=\"6\">&nbsp;</th>";
                  echo "<th>&nbsp;</th>";
                  echo "</tr>";
                  echo "</tbody>";
                  echo "</table>";

                  echo "<p>
                    <button type=\"button\" class=\"btn btn-danger btn-flat btn-sm hapus_data\"><i class=\"fa fa-trash\"></i>&nbsp;&nbsp;Hapus yang dipilih</button>
                    <button type=\"button\" class=\"btn btn-primary btn-flat btn-sm simpan_data\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan perubahan yang dibuat</button>
                  </p>";

                  echo "</div>";
                  echo "</form>";
                }else{
                  echo msgGagal("Tidak ada data yang diharapkan, sehingga harus melakukan proses data uang makan terlebih dahulu. Jangan lupa untuk memproses data gaji dan data tunjangan kesejahterahan terlebih dahulu.");
                }

            }else{
          ?>
          <p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="small text-bold"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Uang Makan</span>&nbsp;&nbsp; untuk memulai proses data uang makan.</p>
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
<div class="modal fade" id="kriteria_uangmakan" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-uangmakan" action="<?php echo $_PATH; ?>/process.php?page=<?php echo $_GET['page']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="um_proses"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Data Uang Makan</h5>
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
								if(isset($_SESSION['um']['proses']['status']) && in_array($k,$_SESSION['um']['proses']['status'])){
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
            <label for="bulan">Bulan Uang Makan:</label>
            <select name="bulan" id="bulan" class="form-control input-sm">
              <?php echo getBulanOption($_bulan); ?>
            </select>
          </div>
          <div class="form-group<?php echo $_cari4; ?>">
            <label for="tahun">Tahun Uang Makan:</label>
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
