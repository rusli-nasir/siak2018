<script type="text/javascript">
$(document).ready(function(){

    $("#notif-sspb").load( "<?=site_url('rsa_sspb/get_notif_sspb_approve')?>");
});
</script>

<div id="page-wrapper" >
	<div id="page-inner">
		<h2>KELOLA SSPB</h2>   
		<hr/>
		
		<div class="row">
			<div class="col-lg-12">
				<div class="row text-center pad-top">
					<?php if($this->check_session->get_level() == 13) : //bendhara ?>
						<div class="row" style="padding-left: 15px;">
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
								<div class="div-square">
									<a href="<?php echo base_url(); ?>index.php/rsa_sspb/daftar_spm" >
										<i class="fa fa-money fa-5x"></i>
										<h4>Tambah SSPB</h4>
									</a>
								</div>             
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
								<div class="div-square">
									<a href="<?php echo base_url(); ?>index.php/rsa_sspb/daftar_sspb" >
										<i class="fa fa-file-text fa-5x"></i>
										<h4>Daftar SSPB</h4>
									</a>
								</div>             
							</div>
						<?php elseif($this->check_session->get_level() == 3 || $this->check_session->get_level() == 11) : //bendhara ?>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
								<div class="div-square">
									<?php $username = $this->check_session->get_username(); ?>
									<a href="<?php echo base_url(); ?>index.php/rsa_sspb/daftar_unit_/<?php echo $username ?>" >
										<i class="fa fa-file-text fa-5x"></i>
										<h4>Daftar SSPB</h4>
									</a>
								</div>  
								<span class="badge badge-danger bg-notif" id="notif-sspb">0</span>           
							</div>
						<?php else :?>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
								<div class="div-square">
									<a href="<?php echo base_url(); ?>index.php/rsa_sspb/daftar_sspb" >
										<i class="fa fa-file-text fa-5x"></i>
										<h4>Daftar SSPB</h4>
									</a>
								</div> 
								<span class="badge badge-danger bg-notif" id="notif-sspb">0</span>            
							</div>
						<?php endif ?>
					</div>
				</div>
			</div>
			<!-- /. PAGE INNER  -->
		</div>
		<!-- /. PAGE WRAPPER  -->
	</div>
</div>