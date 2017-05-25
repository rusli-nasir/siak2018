<style type="text/css">
.chosen-search input{width:100% !important;}
.form-control{height:30px !important;}
</style>
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<div >
	<!-- page start-->
	<div class="row mt">
		<div class="col-md-8" style="width: 100%;display: block;">
	<?php echo $output; ?>
		</div>
	</div>
</div>
