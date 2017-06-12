<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">
<style type="text/css">
.form-control{border:1px solid #bdbdbd;}
</style>
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Saldo</li>
	</ol>
</div><!--/.row-->
<hr/>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header" style="margin-top:-10px;">Ganti Password</h1>
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-12">
		<?php
		if($this->session->flashdata('error')){ ?>
			<div class="alert alert-danger" role="alert"><?= $this->session->flashdata("error") ?></div>
        <?php
		}
		?>
        
        <?php
        if($this->session->flashdata('success')){ ?>
			<div class="alert alert-success" role="alert"><?= $this->session->flashdata("success") ?></div>
        <?php
		}
		?>
		<form class="form-horizontal" action="<?php echo site_url('akuntansi/pengaturan/ganti_password_proses'); ?>" method="post">
			<div class="form-group">
                <label for="tahun_lulus" class="col-sm-2 control-label">Password Lama</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" name="password_lama" placeholder="Password Lama" required>
                </div>
            </div>
			<div class="form-group">
                <label for="tahun_lulus" class="col-sm-2 control-label">Password Baru</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" name="password_baru" placeholder="Password Baru" required>
                </div>
            </div>
			<div class="form-group">
                <label for="tahun_lulus" class="col-sm-2 control-label">Ulangi Password Baru</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" name="password_confirm" placeholder="Ulangi Password Baru" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Ganti Password</button>
                </div>
            </div>
		</form>
	</div>
</div>