
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
<hr>
<!-- Text input-->
<fieldset>  
  <div class="col-md-6" style="border-right:1px solid #eee" id="group-kas">
      <div class="col-md-12 control-label" style="text-align: center;"><h3><strong>Kas</strong></h3></div>
      <div class="col-md-12 control-label" style="text-align: left;"><h4>Kredit<button id="add-akunKredit_kas" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h4></div>
      <div class="col-md-12" id="group-akunKredit_kas">
        <div class="form-group"> 
          <div class="col-md-5">
            <select name="akun_kredit_kas[]" class="form-control akun_kredit_kas" required="">
                <option value="">Pilih Akun</option>
                <option value="">
                 <?php foreach ($akun_kredit as $key => $value) {
                  ?>
              <option value="<?=$value['akun_6']?>"><?=$value['akun_6'].' - '.$value['nama']?></option>
                  <?php
                }
                ?> 
            </select> 
          </div>

          <div class="col-md-6">
          <input name="jumlah_akun_kredit_kas[]" type="text"  placeholder="Jumlah Akun Kredit" class="form-control input-md jumlah_akun_kredit_kas" required="">
          </div>

        </div>
      </div>
      <div class="col-md-12 control-label" style="text-align: left"><h4>Debet<button id="add-akunDebet_kas" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h4></div>
      <div class="col-md-12" id="group-akunDebet_kas">
        <div class="form-group"> 
          <div class="col-md-5">
            <select name="akun_debet_kas[]" class="form-control akun_debet_kas" required="">
                <option value="">Pilih Akun</option>
                <option value="">
                 <?php foreach ($akun_kredit as $key => $value) {
                  ?>
              <option value="<?=$value['akun_6']?>"><?=$value['akun_6'].' - '.$value['nama']?></option>
                  <?php
                }
                ?> 
            </select> 
          </div>

          <div class="col-md-6">
          <input name="jumlah_akun_debet_kas[]" type="text"  placeholder="Jumlah Akun Debet" class="form-control input-md jumlah_akun_debet_kas" required="">
          </div>

        </div>
      </div>
      <hr>
      <div class="col-md-12 control-label">Jumlah kredit : <span id="total_kredit_kas">0</span></div>
      <div class="col-md-12 control-label">Jumlah debet : <span id="total_debet_kas">0</span></div>
      <div class="col-md-12 control-label">Selisih : <span id="selisih_kas">0</span></div>
  </div>
  <div class="col-md-6" style="border-left:1px solid #eee" id="group-akrual">
      <div class="col-md-12 control-label" style="text-align: center;"><h3><strong>Akrual</strong></h3></div>
      <div class="col-md-12 control-label" style="text-align: left;"><h4>Kredit<button id="add-akunKredit_akrual" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h4></div>
      <div class="col-md-12" id="group-akunKredit_akrual">
        <div class="form-group"> 
          <div class="col-md-5">
            <select name="akun_kredit_akrual[]" class="form-control akun_kredit_akrual" required="">
                <option value="">Pilih Akun</option>
                <option value="">
                 <?php foreach ($akun_debet as $key=>$value) {
                  ?>
              <option value="<?=$value['akun_6']?>"><?=$value['akun_6'].' - '.$value['nama']?></option>
                  <?php
                }
                ?> 
            </select> 
          </div>

          <div class="col-md-6">
          <input name="jumlah_akun_kredit_akrual[]" type="text"  placeholder="Jumlah Akun Kredit" class="form-control input-md jumlah_akun_kredit_akrual" required="">
          </div>

        </div>
      </div>
      <div class="col-md-12 control-label" style="text-align: left"><h4>Debet<button id="add-akunDebet_akrual" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h4></div>
      <div class="col-md-12" id="group-akunDebet_akrual">
        <div class="form-group"> 
          <div class="col-md-5">
            <select name="akun_debet_akrual[]" class="form-control akun_debet_akrual" required="">
                <option value="">Pilih Akun</option>
                <option value="">
                 <?php foreach ($akun_debet as $key=>$value) {
                  ?>
              <option value="<?=$value['akun_6']?>"><?=$value['akun_6'].' - '.$value['nama']?></option>
                  <?php
                }
                ?> 
            </select> 
          </div>

          <div class="col-md-6">
          <input name="jumlah_akun_debet_akrual[]" type="text"  placeholder="Jumlah Akun Debet" class="form-control input-md jumlah_akun_debet_akrual" required="">
          </div>

        </div>
      </div>
      <hr>
      <div class="col-md-12 control-label">Jumlah kredit : <span id="total_kredit_akrual">0</span></div>
      <div class="col-md-12 control-label">Jumlah debet : <span id="total_debet_akrual">0</span></div>
      <div class="col-md-12 control-label">Selisih : <span id="selisih_akrual">0</span></div>
  </div>

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

<!-- template akun kredit -->
<div class="form-group" id="template_akun_kredit" style="display:none;"> 
  <div class="col-md-5">
    <select class="form-control" required="">
        <option value="">Pilih Akun</option>
        <option value="">
         <?php foreach ($akun_kredit as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?> 
    </select> 
  </div>

  <div class="col-md-6">
  <input type="text" placeholder="Jumlah Akun Kredit" class="form-control input-md" required="">
  </div>
    
  <div class="col-md-1">
      <a role="button" class="remove-entry close" style="background:#F44336; padding: 2px 8px; color:white; opacity:1">-</a>
  </div>

</div>

<!-- template akun debet -->
<div class="form-group" id="template_akun_debet" style="display:none;"> 
  <div class="col-md-5">
    <select class="form-control" required="">
        <option value="">Pilih Akun</option>
        <option value="">
         <?php foreach ($akun_debet as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?> 
    </select> 
  </div>

  <div class="col-md-6">
  <input type="text"  placeholder="Jumlah Akun Debet" class="form-control input-md" required="">
  </div>
    
  <div class="col-md-1">
      <a role="button" class="remove-entry close" style="background:#F44336; padding: 2px 8px; color:white; opacity:1">-</a>
  </div>

</div>

<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>

<script>
  var jml_kredit_kas = 0;
  var jml_debet_kas = 0;
  var jml_total_kas = 0;
  var jml_kredit_akrual = 0;
  var jml_debet_akrual = 0;
  var jml_total_akrual = 0;
    
  function registerEvents(){
      console.log("register");
      $(".jumlah_akun_debet_kas").on('input', function(){
          jml_debet_kas = 0;
          $(".jumlah_akun_debet_kas").each(function(){
              jml_debet_kas += $(this).val()*1;
          });
          jml_total_kas = jml_kredit_kas-jml_debet_kas;
          $('#total_debet_kas').text(jml_debet_kas);
          updateSelisih();
      });
      $(".jumlah_akun_kredit_kas").on('input', function(){
          jml_kredit_kas = 0;
          $(".jumlah_akun_kredit_kas").each(function(){
              jml_kredit_kas += $(this).val()*1;
          });
          jml_total_kas = jml_kredit_kas-jml_debet_kas;
          $('#total_kredit_kas').text(jml_kredit_kas);
          updateSelisih();
      });
      $(".jumlah_akun_debet_akrual").on('input', function(){
          jml_debet_akrual = 0;
          $(".jumlah_akun_debet_akrual").each(function(){
              jml_debet_akrual += $(this).val()*1;
          });
          jml_total_akrual = jml_kredit_akrual-jml_debet_akrual;
          $('#total_debet_akrual').text(jml_debet_akrual);
          updateSelisih();
      });
      $(".jumlah_akun_kredit_akrual").on('input', function(){
          jml_kredit_akrual = 0;
          $(".jumlah_akun_kredit_akrual").each(function(){
              jml_kredit_akrual += $(this).val()*1;
          });
          jml_total_akrual = jml_kredit_akrual-jml_debet_akrual;
          $('#total_kredit_akrual').text(jml_kredit_akrual);
          updateSelisih();
      });
  }
    
  function updateSelisih(){
      $('#selisih_kas').text(jml_total_kas);
      if(jml_total_kas==0) $('#selisih_kas').removeAttr('style');
      else $('#selisih_kas').attr('style', 'color:red');
      
      $('#selisih_akrual').text(jml_total_akrual);
      if(jml_total_akrual==0) $('#selisih_akrual').removeAttr('style');
      else $('#selisih_akrual').attr('style', 'color:red');
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


  $('#add-akunKredit_kas').click(function () {
        var template = $("#template_akun_kredit").clone();
        template.removeAttr("id");
        template.removeAttr("style");
        $('#group-akunKredit_kas').append(template);
        $(".remove-entry").click(function(){
            $(this).parent().parent().remove();
        });
        template.find('select').attr('class', template.find('select').attr('class') + ' akun_kredit_kas');
        template.find('select').attr('name', 'akun_kredit_kas[]');
        template.find('.input-md').attr('class', template.find('.input-md').attr('class') + ' jumlah_akun_kredit_kas');
        template.find('.input-md').attr('name', 'jumlah_akun_kredit_kas[]');
        template.find('select').selectize();
            registerEvents();

  });
    
  $('#add-akunDebet_kas').click(function () {
        var template = $("#template_akun_debet").clone();
        template.removeAttr("id");
        template.removeAttr("style");
        $('#group-akunDebet_kas').append(template);
        $(".remove-entry").click(function(){
            $(this).parent().parent().remove();
        });
        template.find('select').attr('class', template.find('select').attr('class') + ' akun_debet_kas');
        template.find('select').attr('name', 'akun_debet_kas[]');
        template.find('.input-md').attr('class', template.find('.input-md').attr('class') + ' jumlah_akun_debet_kas');
        template.find('.input-md').attr('name', 'jumlah_akun_debet_kas[]');
        template.find('select').selectize();
            registerEvents();

  });

  $('#add-akunKredit_akrual').click(function () {
        var template = $("#template_akun_kredit").clone();
        template.removeAttr("id");
        template.removeAttr("style");
        $('#group-akunKredit_akrual').append(template);
        $(".remove-entry").click(function(){
            $(this).parent().parent().remove();
        });
        template.find('select').attr('class', template.find('select').attr('class') + ' akun_kredit_akrual');
        template.find('select').attr('name', 'akun_kredit_akrual[]');
        template.find('.input-md').attr('class', template.find('.input-md').attr('class') + ' jumlah_akun_kredit_akrual');
        template.find('.input-md').attr('name', 'jumlah_akun_kredit_akrual[]');
        template.find('select').selectize();
      registerEvents();
  });
    
  $('#add-akunDebet_akrual').click(function () {
        var template = $("#template_akun_debet").clone();
        template.removeAttr("id");
        template.removeAttr("style");
        $('#group-akunDebet_akrual').append(template);
        $(".remove-entry").click(function(){
            $(this).parent().parent().remove();
        });
        template.find('select').attr('class', template.find('select').attr('class') + ' akun_debet_akrual');
        template.find('select').attr('name', 'akun_debet_akrual[]');
        template.find('.input-md').attr('class', template.find('.input-md').attr('class') + ' jumlah_akun_debet_akrual');
        template.find('.input-md').attr('name', 'jumlah_akun_debet_akrual[]');
        template.find('select').selectize();
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
