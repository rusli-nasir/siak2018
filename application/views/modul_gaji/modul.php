<div id="page-wrapper" >
	<div id="page-inner">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h3 class="page-header">
						<i class="fa fa-users"></i>&nbsp;&nbsp;
						Kepegawaian #2
					</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="input-group input-group-lg">
						<div class="input-group-btn">
							<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="width:100%;">
								<i class="fa fa-spinner"></i>&nbsp;&nbsp;Gaji Pegawai
								<span class="fa fa-caret-down"></span>
							</button>
							<ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-briefcase"></i>&nbsp;&nbsp;Gaji Tenaga Tetap Non PNS</a></li>
                <li><a href="#"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Gaji Tenaga Kerja Kontrak</a></li>
              </ul>
						</div>
					</div>
				</div>
				<!-- /.col -->
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="input-group input-group-lg">
						<div class="input-group-btn">
							<button type="button" class="btn btn-success btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="width:100%;">
								<i class="fa fa-spinner"></i>&nbsp;&nbsp;Insentif
								<span class="fa fa-caret-down"></span>
							</button>
							<ul class="dropdown-menu">
                <li><a href="<?php echo site_url('ikw'); ?>"><i class="fa fa-coffee"></i>&nbsp;&nbsp;Insentif Kinerja Wajib</a></li>
                <li><a href="<?php echo site_url('modul_gaji/ipp'); ?>"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Insentif Perbaikan Penghasilan</a></li>
                <li><a href="<?php echo site_url('tutam'); ?>"><i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Insentif Tugas Tambahan</a></li>
             <?php
						 	if(intval($_SESSION['rsa_kode_unit_subunit'])==51){
						 ?>
                <li><a href="<?php echo site_url('tutam_rsnd'); ?>"><i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Insentif Tugas Tambahan RSND</a></li>
             <?php
							}
						 ?>
              </ul>
						</div>
					</div>
				</div>
				<!-- /.col -->
				<!-- <div class="col-md-3 col-sm-6 col-xs-12">
					<div class="input-group input-group-lg">
						<div class="input-group-btn">
							<button type="button" class="btn btn-warning btn-flat" style="width:100%;" onclick="javascript:window.location='<?php echo site_url('uangmakan'); ?>';">
								<i class="fa fa-cutlery"></i>&nbsp;&nbsp;Uang Makan Pegawai
							</button>
						</div>
					</div>
				</div> -->
				<!-- /.col -->
			</div>
			<!-- <div class="row">
				<h3 class="page-header">SESI : <?php echo session_name(); ?></h3>
				<pre><?php print_r($_SESSION); ?></pre>
			</div> -->
	</div>
</div>