<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>

<link href="<?php echo base_url();?>/assets/akuntansi/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker3.css" rel="stylesheet">
<link href="<?php echo base_url();?>/assets/akuntansi/css/styles.css" rel="stylesheet">
<link href="<?php echo base_url();?>/assets/akuntansi/css/my_style.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-3.1.0/jquery-3.1.0.min.js"></script>

<style type="text/css">
	body {
	  zoom: 120%;
	}
</style>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body class="body-login">
	<div class="container">
		<div class="row">
			<center>
				<img src="<?php echo base_url('assets/akuntansi/assets/images/logo_undip.png'); ?>"><br/>
				<div style="color:#0665A2;font-size:24pt;font-weight:bold;">
					Sistem Akuntansi (SiAk)
				</div>
				<div style="font-size:20pt;margin-top:-5px;font-family:calibri;color:#4A4A4A">
					Universitas Diponegoro 
				</div>
			</center>
		</div>
		<br/>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<?php if (isset($report)) if($report==2){ ?>		
					<div class="alert alert-danger">
						Username / Password anda salah.
					</div>
				<?php } ?>	
				<form role="form" method="post" action="<?php echo site_url('akuntansi/login/login_proses'); ?>">
					<fieldset>
						<div class="form-group">
							<input class="form-control form-log" placeholder="Username" name="username" type="text" autofocus="">
						</div>
						<div class="form-group">
							<input class="form-control form-log" placeholder="Password" name="password" type="password" value="">
						</div>
						<!--<div class="checkbox">
							<label>
								<input name="remember" type="checkbox" value="Remember Me">Remember Me
							</label>
						</div>-->
						<input type="hidden" name="submit" value="true">
						<input type="submit" class="btn btn-primary btn-log" value="Login">
					</fieldset>
				</form>
			</div><!-- /.col-->
		</div><!-- /.row -->
	</div>	
	<div style="font-size:8pt;color:#1c1c1c;margin-top:20px;font-weight:bold;" align="center">
		&copy; 2017 Universitas Diponegoro 
	</div>

	<?php if (isset($is_demo)): ?>
		<?php if ($is_demo): ?>
			<div id="myModal" class="modal fade">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                <h4 class="modal-title text-danger">PERHATIAN</h4>
			            </div>
			            <div class="modal-body">
			                <p class="text-danger"><strong>Sistem di PAK ini hanya untuk keperluan demo dan testing, untuk sistem yang benar dapat diakses di <a href="http://rsa.apps.undip.ac.id/index.php/akuntansi/login"> SINI </a></strong></p>
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			            </div>
			        </div>
			    </div>
			</div>

			<script type="text/javascript">
				$(document).ready(function(){
					$("#myModal").modal('show');
				});
			</script>
		<?php endif ?>
	<?php endif ?>

	<?php if (isset($maintenance)): ?>
		<?php if ($maintenance): ?>
			<div id="myModal" class="modal fade">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                <h4 class="modal-title text-danger">PERHATIAN</h4>
			            </div>
			            <div class="modal-body">
			                <p class="text-danger"><strong><?php echo $maintenance ?></a></strong></p>
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			            </div>
			        </div>
			    </div>
			</div>

			<script type="text/javascript">
				$(document).ready(function(){
					$("#myModal").modal('show');
				});
			</script>
		<?php endif ?>
	<?php endif ?>
	
		

	<script src="<?php echo base_url();?>/assets/akuntansi/js/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap.min.js"></script>
	<!--<script src="<?php echo base_url();?>/js/chart.min.js"></script>
	<script src="<?php echo base_url();?>/js/chart-data.js"></script>
	<script src="<?php echo base_url();?>/js/easypiechart.js"></script>
	<script src="<?php echo base_url();?>/js/easypiechart-data.js"></script>-->
	<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
