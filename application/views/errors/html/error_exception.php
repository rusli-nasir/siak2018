<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style type="text/css">
.glyphicon-alert:before{content:"\e209"}.alert{padding:15px;margin-bottom:20px;border:1px solid transparent;border-radius:4px}.alert h4{margin-top:0;color:inherit}.alert .alert-link{font-weight:700}.alert>p,.alert>ul{margin-bottom:0}.alert>p+p{margin-top:5px}.alert-dismissable,.alert-dismissible{padding-right:35px}.alert-dismissable .close,.alert-dismissible .close{position:relative;top:-2px;right:-21px;color:inherit}.alert-success{color:#3c763d;background-color:#dff0d8;border-color:#d6e9c6}.alert-success hr{border-top-color:#c9e2b3}.alert-success .alert-link{color:#2b542c}.alert-info{color:#31708f;background-color:#d9edf7;border-color:#bce8f1}.alert-info hr{border-top-color:#a6e1ec}.alert-info .alert-link{color:#245269}.alert-warning{color:#8a6d3b;background-color:#fcf8e3;border-color:#faebcc}.alert-warning hr{border-top-color:#f7e1b5}.alert-warning .alert-link{color:#66512c}.alert-danger{color:#a94442;background-color:#f2dede;border-color:#ebccd1}.alert-danger hr{border-top-color:#e4b9c0}.alert-danger .alert-link{color:#843534}@-webkit-keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}@-o-keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}@keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}
</style>

<div class="container" style="margin-top: 20px;">
	<div class="col-md-12" style="width: 80%;margin: 0px auto;">
		<div class="alert alert-danger text-center" style="text-align: center;">
			<h3>Mohon Maaf, Halaman ini sedang dalam perbaikan. Mohon tunggu sejenak, atau hubungi Programmer untuk informasi lebih lanjut. Terimakasih.</h3>
			<br>
			<b><u>Kontak Programmer</u> :</b><br>
			M Arief Kurniawan 
			<br>
			<a href="https://api.whatsapp.com/send?phone=6285641125599" target="_blank"><i class="fa fa-whatsapp fa-lg"></i> +62 856-4112-5599 </a>
			<br>
			M Fahmi Mukhlishin
			<br>
			<a href="https://api.whatsapp.com/send?phone=6285713745349" target="_blank"> <i class="fa fa-whatsapp fa-lg"></i> +62 857-1374-5349 </a>
		</div>
	</div>
</div>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>An uncaught Exception was encountered</h4>

<p>Type: <?php echo get_class($exception); ?></p>
<p>Message: <?php echo $message; ?></p>
<p>Filename: <?php echo $exception->getFile(); ?></p>
<p>Line Number: <?php echo $exception->getLine(); ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace:</p>
	<?php foreach ($exception->getTrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p style="margin-left:10px">
			File: <?php echo $error['file']; ?><br />
			Line: <?php echo $error['line']; ?><br />
			Function: <?php echo $error['function']; ?>
			</p>
		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>