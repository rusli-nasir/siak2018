
<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">
<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap-datepicker.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>/assets/akuntansi/js/easynumber/jquery.number.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#jumlah_akun_debet").number(true,2);
    $("#jumlah_akun_kredit").number(true,2);
  })
</script>

<div class="row">
  <ol class="breadcrumb">
    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
    <li class="active">Penerimaan</li>
  </ol>
</div><!--/.row-->

<fieldset>

<?php echo validation_errors(); ?>
<!-- Form Name -->
<legend><center>INPUT JURNAL PENERIMAAN KAS</center></legend>

<!-- Text input-->
<?php echo form_open('akuntansi/penerimaan/input_penerimaan',array("class"=>"form-horizontal")); ?>

<div class="form-group">
  <label class="col-md-2 control-label" for="no_bukti">No. Bukti</label>  
  <div class="col-md-4">
  <input id="no_bukti" name="no_bukti" type="text" value="<?php echo $no_bukti ?>" class="form-control input-md" required="" readonly="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="tanggal">Tanggal</label>  
  <div class="col-md-4">
  <input id="tanggal" name="tanggal" type="text" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="unit_kerja">Unit Kerja</label>  
  <div class="col-md-4">
  <!-- <input id="unit_kerja" name="unit_kerja" type="text" placeholder="Unit Kerja" class="form-control input-md" required=""> -->
      <select id="unit_kerja" name="unit_kerja" class="form-control" required="">
        <option value="">Pilih Unit</option>
        <?php foreach ($all_unit_kerja as $unit) {
          ?>
          <option value="<?=$unit['kode_unit']?>"><?=$unit['kode_unit'].' - '.$unit['nama_unit']?></option>
          <?php
        }
        ?>
      </select>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-2 control-label" for="uraian">Uraian</label>
  <div class="col-md-6">                     
    <textarea class="form-control" id="uraian" name="uraian"></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-2 control-label" for="jenis_pembatasan_dana">Jenis Pembatasan Dana</label>
  <div class="col-md-4">
    <select id="jenis_pembatasan_dana" name="jenis_pembatasan_dana" class="form-control" required="">
      <option value="">Pilih Jenis</option>
      <option value="tidak_terikat" >Tidak Terikat</option>
      <option value="terikat_temporer">Terikat Temporer</option>
      <option value="terikat_permanen">Terikat Permanen</option>
    </select>
  </div>
</div>

<!-- Text input-->
<fieldset>
  <legend>
    <div class="col-md-2 control-label">Jurnal Basis Kas</div>
    <div class="col-md-5 control-label">Jurnal Basis Akrual</div>
    <div class="col-md-3 control-label">Jumlah (Rp)</div>
  </legend> <br/>
  <div class="form-group">
    <label class="col-md-2 control-label" for="kas_akun_debet">Akun Debet</label>  
    <div class="col-md-3">

      <select id="kas_akun_debet" name="kas_akun_debet" class="form-control" required="">
          <option value="911101">911101 - SAL</option>
      </select> 
    <!-- <input id="kas_akun_debet" name="kas_akun_debet"  type="text" placeholder="Akun Debet" class="form-control input-md" required=""> -->
      
    </div>

    

    <!-- <label class="col-md-1 control-label" for="akrual_akun_debet">Akun Debet</label>  
    <div class="col-md-3">
    <input id="akrual_akun_debet" name="akrual_akun_debet" value="<?=$akun_debet_kas?>" type="text" placeholder="Akun Debet" class="form-control input-md" required="" disabled>      
    </div> -->

    <label class="col-md-1 control-label" for="akun_debet_akrual">Akun Debet</label>
    <div class="col-md-3">
      <!-- <input id="akun_debet_akrual" name="akun_debet_akrual" type="text" placeholder="Akun Debet" class="form-control input-md" required=""> -->
      <select id="akun_debet_akrual" name="akun_debet_akrual" class="form-control" required="">
          <option value="">Pilih Akun</option>
           <?php foreach ($akun_kas_akrual as $akun) {
            ?>
            <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
            <?php
          }
          ?> 
      </select> 
        
    </div>


    <div class="col-md-3">
    <input id="jumlah_akun_debet" name="jumlah_akun_debet" type="text" class="form-control input-md" required="">
      
    </div>

  </div>

  <!-- Text input-->
  <div class="form-group">
    <!-- <label class="col-md-2 control-label" for="kas_akun_kredit">Akun Kredit </label>  
    <div class="col-md-3">
    <input id="kas_akun_kredit" name="kas_akun_kredit" type="text" placeholder="Akun Kredit" class="form-control input-md" required="" >
      
    </div> -->
    <label class="col-md-2 control-label" for="akun_kredit">Akun Kredit</label>
    <div class="col-md-3">
      <select id="akun_kredit" name="akun_kredit" class="form-control" required="">
        <option value="">Pilih Akun</option>
        <?php foreach ($data_akun_debet as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?>
      </select>
    </div>
    <!-- <label class="col-md-1 control-label" for="akrual_akun_kredit">Akun Kredit</label>   -->
    <!-- <div class="col-md-3">
    <input id="akrual_akun_kredit" name="akrual_akun_kredit" type="text" placeholder="Akun Kredit" class="form-control input-md" required="" >
      
    </div> -->
    <label class="col-md-1 control-label" for="akun_kredit_akrual">Akun Kredit</label>
    <div class="col-md-3">
      <select id="akun_kredit_akrual" name="akun_kredit_akrual" class="form-control" required="">
        <option value="">Pilih Akun</option>
        <?php foreach ($data_akun_kredit as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?>
      </select>
    </div>
    <div class="col-md-3">
    <input id="jumlah_akun_kredit" name="jumlah_akun_kredit" type="text" class="form-control input-md" style="background-color:#e6e6e6 !important" readonly>
      <div style="font-size:9pt;color:#1c1c1c">
        Masukan Jumlah pada kolom <b>Akun Debet</b>
      </div>
    </div>
  </div>
  <hr/>

</fieldset>


<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="simpan"></label>
  <div class="col-md-8">
    <button id="simpan" name="simpan" class="btn btn-success" type="submit">Simpan</button>
    <a href="<?php echo site_url('akuntansi/penerimaan/index'); ?>"><button id="keluar" name="keluar" class="btn btn-danger" type="button">Keluar</button></a>
  </div>
</div>

</fieldset>
</form>

<script>

  $('#tanggal').datepicker({
      format: "yyyy-mm-dd"
  });

  var $select1 = $('#akun_debet_akrual').selectize();  // This initializes the selectize control
  var selectize1 = $select1[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  <?php if (isset($akun_debet_akrual)): ?>
        selectize1.setValue('<?=$akun_debet_akrual?>');  
  <?php endif ?>
  

  var $select2 = $('#kas_akun_debet').selectize();  // This initializes the selectize control
  var selectize2 = $select2[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  <?php if (isset($kas_akun_debet)): ?>
      selectize2.setValue('<?=$kas_akun_debet?>');
  <?php endif ?>

  var $select3 = $('#unit_kerja').selectize();  // This initializes the selectize control
  var selectize3 = $select3[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  <?php if (isset($unit_kerja)): ?>
      selectize3.setValue('<?=$unit_kerja?>');
  <?php endif ?>


  var $select4 = $('#akun_kredit').selectize();  // This initializes the selectize control
  var selectize4 = $select2[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  // <?php if (isset($kas_akun_debet)): ?>
  //     selectize4.setValue('<?=$kas_akun_debet?>');
  // <?php endif ?>


  var $select5 = $('#akun_kredit_akrual').selectize();  // This initializes the selectize control
  var selectize5 = $select5[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  <?php if (isset($kas_akun_debet)): ?>
      selectize.setValue('<?=$kas_akun_debet?>');
  <?php endif ?>

  /*$('#jumlah_akun_kredit').keyup(function () {
    $('#jumlah_akun_debet').val(this.value)
  })*/

  $('#jumlah_akun_debet').keyup(function () {
    var current_val = $(this).val();
    $('#jumlah_akun_kredit').val(current_val);
  })
</script>
