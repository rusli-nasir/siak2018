<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<h2>KELOLA UANG PANJAR</h2>   
			</div>

			<?php if($this->check_session->get_level() == 13) : ?>

				<div class="col-lg-12">
					<div class="alert alert-danger" style="font-size: 18px">Uang panjar yang telah diberikan : <span style="color: red"><b>Rp.&nbsp;<?php echo number_format($dana_pumk,0,',','.') ?>,00</b> </span></div>   
				</div>
			<?php elseif($this->check_session->get_level() == 4) : ?>
				<div class="col-lg-12">
					<div class="alert alert-danger" style="font-size: 18px">Uang Panjar : <span style="color: red"><b>Rp.&nbsp;<?php echo number_format($dana,0,',','.') ?>,00</b> </span></div>
				</div>
			<?php endif ?>      
			<hr />
			<div class="row text-center pad-top">
				<?php if($this->check_session->get_level() == 13) : //bendhara ?>
					<div class="row" style="padding-left: 15px;">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_pumk/tambah_uang_pumk" >
									<i class="fa fa-money fa-5x"></i>
									<h4>Uang Panjar</h4>
								</a>
							</div>             
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_pumk/spj_pumk" >
									<i class="fa fa-file-text fa-5x"></i>
									<h4>SPJ Panjar Personal</h4>
								</a>
							</div>             
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_pumk/kembali_uang_pumk" >
									<i class="fa fa-undo fa-5x"></i>
									<h4>Uang Kembali Personal</h4>
								</a>
							</div>             
						</div>
					</div>

					<div class="row" style="padding-left: 15px;">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_pumk/daftar_pumk" >
									<i class="fa fa-list fa-5x"></i>
									<h4>Daftar Uang Panjar</h4>
								</a>
							</div>             
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_pumk/daftar_sudah_spj" >
									<i class="fa fa-list fa-5x"></i>
									<h4>Daftar Sudah SPJ</h4>
								</a>
							</div>             
						</div>

						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_pumk/daftar_uang_kembali" >
									<i class="fa fa-list fa-5x"></i>
									<h4>Daftar Uang Kembali</h4>
								</a>
							</div>             
						</div>
					</div>


				<?php elseif($this->check_session->get_level() == 4) ://PUMK ?> 
					<div class="row" style="padding-left: 15px;">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_pumk/spj_pumk" >
									<i class="fa fa-file-text fa-5x"></i>
									<h4>SPJ Panjar</h4>
								</a>
							</div>             
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_pumk/kembali_uang_pumk" >
									<i class="fa fa-undo fa-5x"></i>
									<h4>Uang Kembali</h4>
								</a>
							</div>             
						</div>
					</div>

					<div class="row" style="padding-left: 15px;">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_pumk/daftar_pumk" >
									<i class="fa fa-list fa-5x"></i>
									<h4>Daftar Uang Panjar</h4>
								</a>
							</div>             
						</div>

						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_pumk/daftar_uang_kembali" >
									<i class="fa fa-list fa-5x"></i>
									<h4>Daftar Uang Kembali</h4>
								</a>
							</div>             
						</div>    
					</div>
				<?php endif ?>

			</div>
		</div>
		<!-- /. PAGE INNER  -->
	</div>
	<!-- /. PAGE WRAPPER  -->
</div>