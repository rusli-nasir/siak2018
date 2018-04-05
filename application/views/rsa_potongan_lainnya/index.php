<script type="text/javascript">
$(document).ready(function(){
    $("#notif-ptla").load( "<?=site_url('rsa_potongan_lainnya/get_notif_ptla_approve')?>");
});
</script>

<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<h2>KELOLA POTONGAN LAINNYA</h2>   
				<hr>
			</div>
			<div class="row text-center pad-top">
				<div class="row" style="padding-left: 15px;">
					<?php if($this->check_session->get_level() == 13) : //bendhara ?>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_potongan_lainnya/tambah_potongan_lainnya" >
									<i class="fa fa-scissors fa-5x"></i>
									<h4>Tambah Potongan Lainnya</h4>
								</a>
							</div>             
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
							<div class="div-square">
								<a href="<?php echo base_url(); ?>index.php/rsa_potongan_lainnya/daftar_potongan_lainnya" >
									<i class="fa fa-file-text fa-5x"></i>
									<h4>Daftar Potongan Lainnya</h4>
								</a>
							</div>             
						</div>
					<?php elseif($this->check_session->get_level() == 3 || $this->check_session->get_level() == 11) : //verif || kbuu ?>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
							<div class="div-square">
								<?php $username = $this->check_session->get_username(); ?>
								<a href="<?php echo base_url(); ?>index.php/rsa_potongan_lainnya/daftar_unit/<?php echo $username ?>" >
									<i class="fa fa-file-text fa-5x"></i>
									<h4>Daftar Potongan Lainnya</h4>
								</a>
							</div>  
							<span class="badge badge-danger bg-notif" id="notif-ptla">0</span>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
		<!-- /. PAGE INNER  -->
	</div>
	<!-- /. PAGE WRAPPER  -->
</div>