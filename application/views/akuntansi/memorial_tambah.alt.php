
<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">
<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap-datepicker.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker.css" rel="stylesheet">

<div class="row">
  <ol class="breadcrumb">
    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
    <li class="active">Memorial</li>
  </ol>
</div><!--/.row-->

<fieldset>

<?php echo validation_errors(); ?>
<!-- Form Name -->
<legend><center>INPUT JURNAL UMUM (MEMORIAL)</center></legend>

<!-- Text input-->
<?php echo form_open('akuntansi/memorial/input_memorial',array("class"=>"form-horizontal")); ?>

<div class="form-group">
  <label class="col-md-2 control-label" for="no_bukti">No. Bukti</label>  
  <div class="col-md-4">
  <input id="no_bukti" name="no_bukti" value="<?= $no_bukti; ?>" type="text" placeholder="No.Bukti" class="form-control input-md" required="" readonly>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="tanggal">Tanggal</label>  
  <div class="col-md-4">
  <input id="tanggal" name="tanggal" type="text" placeholder="Tanggal" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="jenis">Jenis Transaksi</label>  
  <div class="col-md-4">
  <!-- <input name="jenis" type="text" placeholder="Jenis Transaksi" class="form-control input-md" required=""> -->
  <select id="jenis" name="jenis" class="form-control" required="">
      <option value="">Pilih Jenis</option>
      <option value="GP" >GUP</option>
      <option value="LS-Gaji">LS-Gaji</option>
      <option value="TUP">TUP</option>
    </select>
  </div>
    
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="kode_kegiatan">Kode Kegiatan</label>  
  <div class="col-md-4">
  <input id="kode_kegiatan" name="kode_kegiatan" type="text" placeholder="Kode Kegiatan" class="form-control input-md" required="">

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
<div class="form-group">
  <input type="checkbox" id="no-kas">  Kosongkan Kas
</div>
<!-- Text input-->
<fieldset>  
  <legend>
    <div class="col-md-4 control-label"><center>Kas</center></div>
    <div class="col-md-4 control-label"><center>Akrual</center></div>
    <div class="col-md-4 control-label"><center>Jumlah (Rp)</center></div>
  </legend>
    <hr>
  <div class="col-md-12" id="group-kredit">
      <div class="col-md-12 control-label" style="margin-top:-24px;"><center><h3>Kredit<button id="add-akunKredit" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h3></center></div>
      <div class="col-md-12" id="group-akunKredit">
        <div class="form-group"> 
          <div class="col-md-4">
            <select name="akun_kredit_kas[]" class="form-control akun_kredit_kas" required="">
                <option value="">Pilih Akun Kredit Kas</option>
                <option value="">
                 <?php foreach ($akun_kredit as $akun) {
                  ?>
              <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                }
                ?> 
            </select> 
          </div>
            
          <div class="col-md-4">
            <select name="akun_kredit_akrual[]" class="form-control akun_kredit_akrual" required="">
                <option value="">Pilih Akun Kredit Akrual</option>
                <option value="">
                 <?php foreach ($akun_kredit as $akun) {
                  ?>
              <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                }
                ?> 
            </select> 
          </div>

          <div class="col-md-3">
          <input name="jumlah_akun_kredit[]" type="text"  placeholder="Jumlah Akun Kredit" class="form-control input-md jumlah_akun_kredit" required="">
          </div>

        </div>
      </div>
  </div>
    <hr />
  <div class="col-md-12" id="group-debet">
      <div class="col-md-12 control-label"><center><h3>Debet<button id="add-akunDebet" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h3></center></div>
      <div class="col-md-12" id="group-akunDebet">
        <div class="form-group"> 
          <div class="col-md-4">
            <select name="akun_debet_kas[]" class="form-control akun_debet_kas" required="">
                <option value="">Pilih Akun Debet Kas</option>
                <option value="">
                 <?php foreach ($akun_debet as $akun) {
                  ?>
              <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                }
                ?> 
            </select> 
          </div>
            
          <div class="col-md-4">
            <select name="akun_debet_akrual[]" class="form-control akun_debet_akrual" required="">
                <option value="">Pilih Akun Debet Akrual</option>
                <option value="">
                 <?php foreach ($akun_debet as $akun) {
                  ?>
              <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                }
                ?> 
            </select> 
          </div>

          <div class="col-md-3">
          <input name="jumlah_akun_debet[]" type="text"  placeholder="Jumlah Akun Debet" class="form-control input-md jumlah_akun_debet" required="">
          </div>

        </div>
      </div>
  </div>
  <legend>
      <div class="col-md-12 control-label">Jumlah kredit : <span id="total_kredit">0</span></div>
      <div class="col-md-12 control-label">Jumlah debet : <span id="total_debet">0</span></div>
      <div class="col-md-12 control-label">Selisih : <span id="selisih">0</span></div>
  </legend>

</fieldset>


<!-- Button (Double) -->
<div class="form-group" style="margin-top:12px;">
  <div class="col-md-12" style="text-align:center;">
    <button id="simpan" name="simpan" class="btn btn-success" type="submit">Simpan</button>
    <a href="<?php echo site_url('akuntansi/penerimaan/index'); ?>"><button id="keluar" name="keluar" class="btn btn-danger" type="button">Keluar</button></a>
  </div>
</div>

</fieldset>
<?= form_close(); ?>

<!-- template -->
<div class="form-group" id="template_kredit" style="display:none;"> 
  <div class="col-md-4">
    <select name="akun_kredit_kas[]" class="form-control" required="">
        <option value="">Pilih Akun Kredit Kas</option>
        <option value="">
         <?php foreach ($akun_kredit as $akun) {
          ?>
      <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?> 
    </select> 
  </div>

  <div class="col-md-4">
    <select name="akun_kredit_akrual[]" class="form-control" required="">
        <option value="">Pilih Akun Kredit Akrual</option>
        <option value="">
         <?php foreach ($akun_kredit as $akun) {
          ?>
      <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?> 
    </select> 
  </div>

  <div class="col-md-3">
  <input name="jumlah_akun_kredit[]" type="text"  placeholder="Jumlah Akun Kredit" class="form-control input-md jumlah_akun_kredit" required="">
  </div>

</div>

<!-- template debet -->
<div class="form-group" id="template_debet" style="display:none;"> 
  <div class="col-md-4">
    <select name="akun_debet_kas[]" class="form-control" required="">
        <option value="">Pilih Akun Debet Kas</option>
        <option value="">
         <?php foreach ($akun_debet as $akun) {
          ?>
      <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?> 
    </select> 
  </div>

  <div class="col-md-4">
    <select name="akun_debet_akrual[]" class="form-control" required="">
        <option value="">Pilih Akun Debet Akrual</option>
        <option value="">
         <?php foreach ($akun_debet as $akun) {
          ?>
      <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?> 
    </select> 
  </div>

  <div class="col-md-3">
  <input name="jumlah_akun_debet[]" type="text"  placeholder="Jumlah Akun Debet" class="form-control input-md jumlah_akun_debet" required="">
  </div>

</div>

<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>

<script>
  var jml_kredit = 0;
  var jml_debet = 0;
  var jml_total = 0;
    
  function registerEvents(){
      console.log("register");
      $(".jumlah_akun_debet").on('input', function(){
          jml_debet = 0;
          $(".jumlah_akun_debet").each(function(){
              jml_debet += $(this).val()*1;
          });
          jml_total = jml_kredit-jml_debet;
          $('#total_debet').text(jml_debet);
          updateSelisih();
      });
      $(".jumlah_akun_kredit").on('input', function(){
          jml_kredit = 0;
          $(".jumlah_akun_kredit").each(function(){
              jml_kredit += $(this).val()*1;
          });
          jml_total = jml_kredit-jml_debet;
          $('#total_kredit').text(jml_kredit);
          updateSelisih();
      });
  }
    
  function updateSelisih(){
      $('#selisih').text(jml_total);
      if(jml_total==0) $('#selisih').removeAttr('style');
      else $('#selisih').attr('style', 'color:red');
  }
    
  registerEvents();
  $('#tanggal').datepicker({
      format: "yyyy-mm-dd"
  });

  var $select1 = $('.akun_debet_kas').selectize();  // This initializes the selectize control
  var selectize1 = $select1[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  var $select2 = $('.akun_kredit_kas').selectize();  // This initializes the selectize control
  var selectize2 = $select2.selectize; // This stores the selectize object to a variable (with name 'selectize')
    
  var $select1 = $('.akun_debet_akrual').selectize();  // This initializes the selectize control
  var selectize1 = $select1[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  var $select2 = $('.akun_kredit_akrual').selectize();  // This initializes the selectize control
  var selectize2 = $select2.selectize; // This stores the selectize object to a variable (with name 'selectize')


  var $select3 = $('#unit_kerja').selectize();  // This initializes the selectize control
  var selectize3 = $select3[0].selectize; // This stores the selectize object to a variable (with name 'selectize')


  $('#add-akunKredit').click(function () {
        var template = $("#template_kredit").clone();
        template.removeAttr("id");
        template.removeAttr("style");
        $('#group-akunKredit').append(template);
        $(".remove-entry").click(function(){
            $(this).parent().parent().remove();
        });
        template.find('select:first-child').attr('class', template.find('select').attr('class') + ' akun_kredit_kas');
        template.find('select:last-child').attr('class', template.find('select').attr('class') + ' akun_kredit_akrual');
        template.find('select:first-child').selectize();
        template.find('select:last-child').selectize();
        registerEvents();

  });
    
  $('#add-akunDebet').click(function () {
        var template = $("#template_debet").clone();
        template.removeAttr("id");
        template.removeAttr("style");
        $('#group-akunDebet').append(template);
        $(".remove-entry").click(function(){
            $(this).parent().parent().remove();
        });
        template.find('select:first-child').attr('class', template.find('select').attr('class') + ' akun_debet_kas');
        template.find('select:last-child').attr('class', template.find('select').attr('class') + ' akun_debet_akrual');
        template.find('select:first-child').selectize();
        template.find('select:last-child').selectize();
        registerEvents();

  });
    
  $("#no-kas").click(function(){
    if(this.checked) {
        $('#group-kas').attr('style', 'display:none');
        $('#group-akrual').attr('class', 'col-md-12');
    }
    else {
        $('#group-kas').attr('style', 'border-right:1px solid #eee');
        $('#group-akrual').attr('class', 'col-md-6');
    }
  });


  <?php if (isset($unit_kerja)): ?>
      selectize3.setValue('<?=$unit_kerja?>');
  <?php endif ?>


</script>
