
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Manage Akun</li>
	</ol>
</div><!--/.row-->
<hr/>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Pilih Akun</h1>
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<br />
<div class="container">
	<!-- Text input-->
	
    <div class="form-group">
      <label class="col-md-2 control-label">Jenis Akun</label>  
      <div class="col-md-6">
          <select id="tabel_akun" name="tabel_akun" class="form-control" required="">
            <?php foreach ($array_jenis as $jenis): ?>
              <option value="<?php echo $jenis?>"><?php echo ucwords(str_replace("_", " ", $jenis)); ?></option>
            <?php endforeach ?>
          </select>
      </div>
    </div>
    <br/>
    <div class="form-group">
      <label class="col-md-2 control-label">Level Akun</label>  
      <div class="col-md-6">
          <select id="level_akun" name="tabel" class="form-control" required="">
            <?php for ($i=1; $i <= 6; $i++) { 
              if ($i != 5) {?>
                  <option value="<?php echo $i ?>">Level <?php echo $i ?></option>
                <?php 
              }
            } ?>
          </select>
      </div>
    </div>
    <!-- Button (Double) -->
    <br/>
    <div class="form-group">
      <div class="col-md-12" style="text-align:center;">
        <button id="simpan" name="simpan" class="btn btn-success"  onClick="popuper(); return false;">Buka Tabel</button>
      </div>
    </div>
</div>
<br/>

<script type="text/javascript">
  function popuper() {
    var link = $('#tabel_akun option:selected').val() + '_' + $('#level_akun').val()
    MyWindow=window.open('<?php echo site_url('akuntansi/akun/manage/') ?>'+link,'MyWindow',width='80%',height='600');
  }
</script>
<div class="row">
	<div class="col-sm-12">
		<?php //foreach($query_debet->result() as $result){ ?>
			<?php //echo $result->akun_debet; ?><br/>
		<?php //} ?>
		<?php //foreach($query_debet_akrual->result() as $result){ ?>
			<?php //echo $result->akun_debet_akrual; ?><br/>
		<?php //} ?>
		<?php //foreach($query_kredit->result() as $result){ ?>
			<?php //echo $result->akun_kredit; ?><br/>
		<?php //} ?>
		<?php //foreach($query_kredit_akrual->result() as $result){ ?>
			<?php //echo $result->akun_kredit_akrual; ?><br/>
		<?php //} ?>
	</div>
</div>

