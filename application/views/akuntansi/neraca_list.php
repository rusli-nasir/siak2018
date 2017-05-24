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
		<li class="active">Neraca Saldo</li>
	</ol>
</div><!--/.row-->
<hr/>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Neraca Saldo</h1>
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<br />
<div class="container">
    <?php echo form_open('akuntansi/laporan/get_neraca_saldo',array("class"=>"form-horizontal", "id" => "form_pop")); ?>
	<!-- Text input-->
	<div class="form-group">
      <label class="col-md-2 control-label">Unit</label>  
      <div class="col-md-6">
          <?php if($this->session->userdata('level')==1){ ?>
          <input type="hidden" class="form-control" name="unit" value="<?php echo $this->session->userdata('kode_unit') ?>">
          <input type="text" class="form-control" value="<?php echo $this->session->userdata('username') ?>" disabled>
          <?php }else{ ?>
          <select id="unit_list" name="unit" class="form-control" required="">
              <option value="all" selected=""> Semua</option>
            <?php foreach($query_unit->result() as $unit): ?>
              <option value="<?php echo $unit->kode_unit ?>"><?= $unit->alias." - ".$unit->nama_unit ?></option>
            <?php endforeach; ?>
          </select>
          <?php } ?>
      </div>
    </div>
    
    <div class="form-group">
      <label class="col-md-2 control-label">Periode</label>  
      <div class="col-md-6">
          <div class="input-group input-daterange">
            <input type="text" name="periode_awal" data-date-format='yyyy-mm-dd' class="form-control">
            <div class="input-group-addon">sampai</div>
            <input type="text" name="periode_akhir"  data-date-format='yyyy-mm-dd' class="form-control">
          </div>
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
    <!-- Button (Double) -->
    <div class="form-group">
      <div class="col-md-12" style="text-align:center;">
        <button id="simpan" name="simpan" class="btn btn-success" type="submit">Buka Neraca</button>
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

<script type="text/javascript">
  var myForm = document.getElementById('form_pop');
    myForm.onsubmit = function() {
        var lebar = 0.9 * document.body.clientWidth;
        var w = window.open('about:blank','Popup_Window','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width='+lebar+',height=700,left = 312,top = 234');
        this.target = 'Popup_Window';
    };
</script>

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