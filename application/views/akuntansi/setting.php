
<div class="container-fluid">
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Setting</li>
	</ol>
</div><!--/.row-->
<hr/>

<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Setting Tahun</h1>
	</div>

</div><!--/.row-->
<div class="container-fluid">
	<?php echo form_open('akuntansi/Setting/setting_tahun',array("class"=>"form-horizontal","id" => "form_pop")); ?>
	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-2 control-label">Pilih tahun</label>  
		<div class="col-md-2">
			<select name="tahun" class="form-control" required="">
				<?php foreach ($tahun as $data): ?>
				<option value="<?php echo $data ?>" <?php echo  ($data == $tahun_selected ? 'selected' : null); ?> ><?php echo $data ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="col-md-2">
			<button id="simpan" name="simpan" class="btn btn-success" type="submit">Simpan</button>
		</div>

	</div>

	<?php echo form_close(); ?>
</div>
</div>

