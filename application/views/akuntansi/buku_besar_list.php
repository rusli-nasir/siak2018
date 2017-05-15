<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">
<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>
<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap-datepicker.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker.css" rel="stylesheet">
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
        $('.input-daterange input').each(function() {
            $(this).datepicker();
            $(this).datepicker('update', new Date());
        });
        $('#akun_kas_list').selectize();
        $('#akun_akrual_list').selectize();
        $('#unit_list').selectize();
	});
    
    $('#basis').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        if(optionSelected == 'kas'){
            $('#kas_list').removeAttr('style');
            $('#akrual_list').attr('style', 'display:none');
        } else {
            $('#akrual_list').removeAttr('style');
            $('#kas_list').attr('style', 'display:none');
        }
    });
</script>
<!-- javascript -->

<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Buku Besar</li>
	</ol>
</div><!--/.row-->
<hr/>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Buku Besar</h1>
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-4">
		<form action="<?php echo site_url('akuntansi/kuitansi/jadi'); ?>" method="post">
			<div class="input-group">
				<span class="input-group-btn">
	        		<a href="<?php echo site_url('akuntansi/kuitansi/reset_search_jadi'); ?>"><button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-refresh"></span> Reset</button></a>
	      		</span>
	      		<input type="text" class="form-control" placeholder="No.bukti/No.SPM/Uraian" name="keyword_jadi" value="<?php if($this->session->userdata('keyword_jadi')) echo $this->session->userdata('keyword_jadi'); ?>">
	      		<span class="input-group-btn">
	        		<button class="btn btn-default" type="submit">Cari</button>
	      		</span>
	    	</div>
	    </form>
	</div>
</div>
<br />
<div class="row">
    <?php echo form_open('akuntansi/memorial/input_memorial',array("class"=>"form-horizontal")); ?>
	<!-- Text input-->
    <div class="form-group">
      <label class="col-md-2 control-label">Unit</label>  
      <div class="col-md-6">
          <select id="unit_list" name="unit" class="form-control" required="">
            <?php foreach($query_unit->result() as $unit): ?>
              <option><?= $unit->alias." - ".$unit->nama_unit ?></option>
            <?php endforeach; ?>
          </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Periode</label>  
      <div class="col-md-6">
          <div class="input-group input-daterange">
            <input type="text" name="periode_awal" class="form-control">
            <div class="input-group-addon">sampai</div>
            <input type="text" name="periode_akhir" class="form-control">
          </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Sumber Dana</label>  
      <div class="col-md-6">
          <select id="sumber_dana" name="output" class="form-control" required="">
            <option value="tidak_terikat">Tidak Terikat</option>
            <option value="terikat_temporer">Terikat Temporer</option>
            <option value="terikat_permanen">Terikat Permanen</option>
          </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Basis</label>  
      <div class="col-md-6">
          <select id="basis" name="basis" class="form-control" required="">
            <option value="kas">Kas</option>
            <option value="akrual">Akrual</option>
          </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Akun</label>  
      <div class="col-md-6">
          <div id="kas_list">
              <select id="akun_kas_list" name="akun_kas[]" class="form-control" required="">
                <option value="semua_akun">Semua Akun</option>
                <?php foreach ($query_akun_kas as $akun) {
                  ?>
                  <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                } ?>
              </select>
          </div>
          <div id="kas_list" style="display:none">
              <select id="akun_akrual_list" name="akun_akrual[]" class="form-control" required="">
                <option value="semua_akun">Semua Akun</option>
                <?php foreach ($query_akun_akrual as $akun) {
                  ?>
                  <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                } ?>
              </select>
          </div>
      </div>
    </div>
    <!-- Button (Double) -->
    <div class="form-group">
      <div class="col-md-12" style="text-align:center;">
        <button id="simpan" name="simpan" class="btn btn-success" type="submit">Buka Buku Besar</button>
      </div>
    </div>
    <?php echo form_close(); ?>
</div>
<br/>
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

<?php
function get_pengeluaran($id_kuitansi){
	$ci =& get_instance();

	$query = "SELECT SUM(volume*harga_satuan) AS pengeluaran FROM rsa_kuitansi_detail WHERE id_kuitansi='$id_kuitansi'";
	$q = $ci->db->query($query)->result();
	foreach($q as $result){
		return number_format($result->pengeluaran);
	}
}
function get_unit($unit){
	$ci =& get_instance();
	$ci->db2 = $ci->load->database('rba', true);

	$query = "SELECT * FROM unit WHERE kode_unit='$unit'";
	$q = $ci->db2->query($query)->result();
	foreach($q as $result){
		return $result->alias;
	}
}
function get_nama_unit($unit){
	$ci =& get_instance();
	$ci->db2 = $ci->load->database('rba', true);

	$query = "SELECT * FROM unit WHERE kode_unit='$unit'";
	$q = $ci->db2->query($query)->result();
	foreach($q as $result){
		return $result->nama_unit;
	}
}
?>