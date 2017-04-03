<!-- javascript -->
<script type="text/javascript">
	$(document).ready(function(){
		var host = location.protocol + '//' + location.host + '/sisrenbang/index.php/';

		$("#filter_tahun").change(function(){
			$("#form_filter_tahun").submit();
		});
		$("#filter_status").change(function(){
			$("#form_filter").submit();
		});
	});
</script>
<!-- javascript -->

<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Rencana RUP</li>
	</ol>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Rencana RUP</h1>
	</div>
	<div class="col-sm-3" align="right">
		<?php if($this->session->userdata('level')==4){ ?>
			<a href="<?php echo site_url('rup/tambah'); ?>"><button type="button" class="btn btn-primary btn-title">Buat Rencana RUP</button></a>
		<?php } ?>
	</div>
</div><!--/.row-->