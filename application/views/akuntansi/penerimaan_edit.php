
<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">
<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap-datepicker.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>/assets/akuntansi/js/easynumber/jquery.number.js"></script>
<script type="text/javascript">
var host = "<?=site_url('/')?>";
  Number.prototype.format = function(n, x, s, c) {
      var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
          num = this.toFixed(Math.max(0, ~~n));

      return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
  };
  $(document).ready(function(){
    $("#jumlah_akun_debet").number(true,2);
    $("#jumlah_akun_kredit").number(true,2);

    //get akun
    var id_kuitansi_jadi = <?=$id_kuitansi_jadi?>;
    //kas kredit
    $.ajax({
      url:host+'akuntansi/memorial/get_kas_debet/'+id_kuitansi_jadi+'/kredit/kas',
      data:{},
      success:function(data){ 
        if(data['hasil'][0]['akun']==""){
          $('#group-kas').attr('style', 'display:none');
          $('#group-akrual').attr('class', 'col-md-12');
          no_kas = true;
          $("#no-kas").prop('checked', true);
        }
        $.each(data['hasil'], function(index, val){
          var template = $("#template_akun_kas_kredit").clone();
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
          if(index==0){
            template.find('.remove_btn').remove();
          }
          var $select_akun = template.find('select').selectize();
              registerEvents();

          var selectize_akun = $select_akun[0].selectize;
          selectize_akun.setValue(data['hasil'][index]['akun']);
          template.find('.input-md').val(data['hasil'][index]['jumlah']);

          var inputan = template.find('.input-md');
          $(inputan).number(true,2);
            updateSelisih_kas();
        });
      },
      error: function (request, status, error) {
          $('#group-kas').attr('style', 'display:none');
          $('#group-akrual').attr('class', 'col-md-12');
          no_kas = true;
          $("#no-kas").prop('checked', true);
      }
    })

    //kas debet
    $.ajax({
      url:host+'akuntansi/memorial/get_kas_debet/'+id_kuitansi_jadi+'/debet/kas',
      data:{},
      success:function(data){
        $.each(data['hasil'], function(index, val){
          var template = $("#template_akun_kas_debet").clone();
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
          if(index==0){
            template.find('.remove_btn').remove();
          }

          var $select_akun = template.find('select').selectize();
              registerEvents();

          var selectize_akun = $select_akun[0].selectize;
          selectize_akun.setValue(data['hasil'][index]['akun']);
          template.find('.input-md').val(data['hasil'][index]['jumlah']);

          var inputan = template.find('.input-md');
          $(inputan).number(true,2);
            updateSelisih_kas();
        });
      }
    })

    //akrual kredit
    $.ajax({
      url:host+'akuntansi/memorial/get_kas_debet/'+id_kuitansi_jadi+'/kredit/akrual',
      data:{},
      success:function(data){
        $.each(data['hasil'], function(index, val){
          var template = $("#template_akun_akrual_kredit").clone();
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
          if(index==0){
            template.find('.remove_btn').remove();
          }
          var $select_akun = template.find('select').selectize();
              registerEvents();

          var selectize_akun = $select_akun[0].selectize;
          selectize_akun.setValue(data['hasil'][index]['akun']);
          template.find('.input-md').val(data['hasil'][index]['jumlah']);
          var inputan = template.find('.input-md');
          $(inputan).number(true,2);
            updateSelisih_akrual();
        });
      }
    })

    //akrual debet
    $.ajax({
      url:host+'akuntansi/memorial/get_kas_debet/'+id_kuitansi_jadi+'/debet/akrual',
      data:{},
      success:function(data){
        $.each(data['hasil'], function(index, val){
          var template = $("#template_akun_akrual_debet").clone();
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
          if(index==0){
            template.find('.remove_btn').remove();
          }

          var $select_akun = template.find('select').selectize();
              registerEvents();

          var selectize_akun = $select_akun[0].selectize;
          selectize_akun.setValue(data['hasil'][index]['akun']);
          template.find('.input-md').val(data['hasil'][index]['jumlah']);
          var inputan = template.find('.input-md');
          $(inputan).number(true,2);
            updateSelisih_akrual();
        });
      }
    })
  })
</script>

<div class="row">
  <ol class="breadcrumb">
    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
    <li class="active">Penerimaan</li>
  </ol>
</div><!--/.row-->

<?php
    echo form_open('akuntansi/penerimaan/edit_penerimaan/'.$id_kuitansi_jadi.'/'.$mode,array("class"=>"form-horizontal"));
?>

<fieldset>

<?php echo validation_errors(); ?>
<!-- Form Name -->
<legend><center>JURNAL PENERIMAAN KAS</center></legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="no_bukti">Status</label>  
  <div class="col-md-4" style="margin-top:5px;">
    <?php if($flag==1){ ?>
      <?php if($status=='revisi'){ ?>
        <button class="btn btn-xs btn-danger disabled"><span class="glyphicon glyphicon-repeat"></span> Revisi</button>
        <br/>Alasan: <?php echo $komentar; ?>
      <?php }else{ ?>
        <button class="btn btn-xs btn-default disabled">Proses verifikasi</button>
      <?php } ?>
    <?php }else if($flag==2){ ?>
      <button class="btn btn-xs btn-success">Disetujui</button>
    <?php } ?>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="no_bukti">No. Bukti</label>  
  <div class="col-md-4">
  <input id="no_bukti" name="no_bukti" value="<?=$no_bukti?>" type="text" placeholder="No.Bukti" class="form-control input-md" disabled required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="tanggal">Tanggal</label>  
  <div class="col-md-4">
  <input id="tanggal" name="tanggal" type="text" value="<?=$tgl_kuitansi?>" placeholder="Tanggal" class="form-control input-md" required="">
    
  </div>
</div>


<!-- Textarea -->
<div class="form-group">
  <label class="col-md-2 control-label" for="uraian">Uraian</label>
  <div class="col-md-6">                     
    <textarea class="form-control" id="uraian" name="uraian"><?=$uraian?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-2 control-label" for="jenis_pembatasan_dana">Jenis Pembatasan Dana</label>
  <div class="col-md-4">
    <select id="jenis_pembatasan_dana" name="jenis_pembatasan_dana" class="form-control" required="">
      <option value="">Pilih Jenis</option>
      <option <?php if ($jenis_pembatasan_dana == 'tidak_terikat'): ?> selected <?php endif ?>  value="tidak_terikat" >Tidak Terikat</option>
      <option <?php if ($jenis_pembatasan_dana == 'terikat_temporer'): ?> selected <?php endif ?> value="terikat_temporer">Terikat Temporer</option>
      <option <?php if ($jenis_pembatasan_dana == 'terikat_permanen'): ?> selected <?php endif ?>  value="terikat_permanen">Terikat Permanen</option>
    </select>
  </div>
</div>

<!-- Text input-->
<fieldset>  
    
  <div class="col-md-6" style="border-right:1px solid #eee" id="group-kas">
      <div class="col-md-12 control-label" style="text-align: center;"><h3><strong>Kas</strong></h3></div>
      
      <div class="col-md-12 control-label" style="text-align: left"><h4>Debet<button id="add-akunDebet_kas" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h4></div>
      <div class="col-md-12" id="group-akunDebet_kas">
        <div class="form-group" style="display:none"> 
          <div class="col-md-5">
            <select name="akun_debet_kas[]" class="form-control akun_debet_kas">
                <option value="911101">911101 - SAL</option>
                <?php foreach ($akun_kas_akrual as $akun) {
                  ?>
                  <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                }
                ?>
            </select> 
          </div>

          <div class="col-md-6">
          <input name="jumlah_akun_debet_kas[]" type="text" class="form-control input-md jumlah_akun_debet_kas">
          </div>

        </div>
      </div>
      
      <div class="col-md-12 control-label" style="text-align: left;"><h4>Kredit<button id="add-akunKredit_kas" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h4></div>
      <div class="col-md-12" id="group-akunKredit_kas">
        <div class="form-group" style="display:none"> 
          <div class="col-md-5">
            <select name="akun_kredit_kas[]" class="form-control akun_kredit_kas">
                <option value="">Pilih Akun</option>
                <?php foreach ($data_akun_debet as $akun) {
                  ?>
                  <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                }
                ?>
                <?php foreach ($sal_penerimaan as $akun) {
                  ?>
                  <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                }
                ?>
            </select> 
          </div>

          <div class="col-md-6">
          <input name="jumlah_akun_kredit_kas[]" type="text" class="form-control input-md jumlah_akun_kredit_kas">
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
      
      <div class="col-md-12 control-label" style="text-align: left"><h4>Debet<button id="add-akunDebet_akrual" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h4></div>
      <div class="col-md-12" id="group-akunDebet_akrual">
        <div class="form-group" style="display:none"> 
          <div class="col-md-5">
            <select name="akun_debet_akrual[]" class="form-control akun_debet_akrual" required="">
                <option value="">Pilih Akun</option>
                <?php foreach ($akun_kas_akrual as $akun) {
                  ?>
                  <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                }
                ?> 
            </select> 
          </div>

          <div class="col-md-6">
          <input name="jumlah_akun_debet_akrual[]" type="text" class="form-control input-md jumlah_akun_debet_akrual" required="">
          </div>

        </div>
      </div>
      
      <div class="col-md-12 control-label" style="text-align: left;"><h4>Kredit<button id="add-akunKredit_akrual" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h4></div>
      <div class="col-md-12" id="group-akunKredit_akrual">
        <div class="form-group" style="display:none"> 
          <div class="col-md-5">
            <select name="akun_kredit_akrual[]" class="form-control akun_kredit_akrual" required="">
                <option value="">Pilih Akun</option>
                <?php foreach ($data_akun_kredit as $akun) {
                  ?>
                  <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                }
                ?>
                <?php foreach ($sal_penerimaan as $akun) {
                  ?>
                  <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
                  <?php
                }
                ?>
            </select> 
          </div>

          <div class="col-md-6">
            <input name="jumlah_akun_kredit_akrual[]" type="text" class="form-control input-md jumlah_akun_kredit_akrual" required="">
          </div>

        </div>
      </div>
      
      <hr>
      <div class="col-md-12 control-label">Jumlah kredit : <span id="total_kredit_akrual">0</span></div>
      <div class="col-md-12 control-label">Jumlah debet : <span id="total_debet_akrual">0</span></div>
      <div class="col-md-12 control-label">Selisih : <span id="selisih_akrual">0</span></div>
  </div>

</fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="simpan"></label>
  <div class="col-md-8">
    <button id="simpan" name="simpan" class="btn btn-success" type="submit">Simpan</button>
    <a href="<?php echo site_url('akuntansi/penerimaan/index'); ?>"><button id="keluar" name="keluar" class="btn btn-danger" type="button">Keluar</button></a>
  </div>
</div>

</fieldset>
</form>


<!-- template akun kas debet -->
<div class="form-group" id="template_akun_kas_debet" style="display:none;"> 
  <div class="col-md-5">
    <select class="form-control">
        <option value="911101">911101 - SAL</option>
        <?php foreach ($akun_kas_akrual as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?>
    </select> 
  </div>

  <div class="col-md-6">
  <input type="text" class="form-control input-md">
  </div>
    
  <div class="col-md-1 remove_btn">
      <a role="button" class="remove-entry close" style="background:#F44336; padding: 2px 8px; color:white; opacity:1">-</a>
  </div>

</div>

<!-- template akun kas kredit -->
<div class="form-group" id="template_akun_kas_kredit" style="display:none;"> 
  <div class="col-md-5">
    <select class="form-control">
        <option value="">Pilih Akun</option>
        <?php foreach ($data_akun_debet as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?>
        <?php foreach ($sal_penerimaan as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?>
    </select> 
  </div>

  <div class="col-md-6">
  <input type="text" class="form-control input-md">
  </div>
    
  <div class="col-md-1 remove_btn">
      <a role="button" class="remove-entry close" style="background:#F44336; padding: 2px 8px; color:white; opacity:1">-</a>
  </div>

</div>

<!-- template akun akrual debet -->
<div class="form-group" id="template_akun_akrual_debet" style="display:none;"> 
  <div class="col-md-5">
    <select class="form-control" required="">
        <option value="">Pilih Akun</option>
        <option value="">
         <?php foreach ($akun_kas_akrual as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?> 
    </select> 
  </div>

  <div class="col-md-6">
  <input type="text" class="form-control input-md" required="">
  </div>
    
  <div class="col-md-1 remove_btn">
      <a role="button" class="remove-entry close" style="background:#F44336; padding: 2px 8px; color:white; opacity:1">-</a>
  </div>

</div>

<!-- template akun akrual kredit -->
<div class="form-group" id="template_akun_akrual_kredit" style="display:none;"> 
  <div class="col-md-5">
    <select class="form-control" required="">
        <option value="">Pilih Akun</option>
        <?php foreach ($sal_penerimaan as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?>
        <?php foreach ($data_akun_kredit as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?>
    </select> 
  </div>

  <div class="col-md-6">
  <input type="text" class="form-control input-md" required="">
  </div>
    
  <div class="col-md-1 remove_btn">
      <a role="button" class="remove-entry close" style="background:#F44336; padding: 2px 8px; color:white; opacity:1">-</a>
  </div>

</div>

<script>
  var jml_kredit_kas = 0;
  var jml_debet_kas = 0;
  var jml_total_kas = 0;
  var jml_kredit_akrual = 0;
  var jml_debet_akrual = 0;
  var jml_total_akrual = 0;

  function registerEvents(){
      $(".remove-entry").click(function(){
          $(this).parent().parent().remove();
          updateSelisih_akrual();
          updateSelisih_kas();
      });
      console.log("register");
      $(".jumlah_akun_debet_kas").on('input', function(){
          updateSelisih_kas();
      });
      $(".jumlah_akun_kredit_kas").on('input', function(){
          updateSelisih_kas();
      });
      $(".jumlah_akun_debet_akrual").on('input', function(){
          updateSelisih_akrual();
      });
      $(".jumlah_akun_kredit_akrual").on('input', function(){
          updateSelisih_akrual();
      });
  }
    
  function updateSelisih_kas(){
      jml_debet_kas = 0;
      $(".jumlah_akun_debet_kas").each(function(){
          jml_debet_kas += $(this).val()*1;
      });
      $('#total_debet_kas').text(jml_debet_kas.format(0, 3, '.', ''));
      
      jml_kredit_kas = 0;
      $(".jumlah_akun_kredit_kas").each(function(){
          jml_kredit_kas += $(this).val()*1;
      });
      jml_total_kas = jml_kredit_kas-jml_debet_kas;
      $('#total_kredit_kas').text(jml_kredit_kas.format(0, 3, '.', ''));
      
      $('#selisih_kas').text(jml_total_kas.format(0, 3, '.', ''));
      if(jml_total_kas==0) $('#selisih_kas').removeAttr('style');
      else $('#selisih_kas').attr('style', 'color:red');
  }
  function updateSelisih_akrual(){
      jml_debet_akrual = 0;
      $(".jumlah_akun_debet_akrual").each(function(){
          jml_debet_akrual += $(this).val()*1;
      });
      $('#total_debet_akrual').text(jml_debet_akrual.format(0, 3, '.', ''));
      
      jml_kredit_akrual = 0;
      $(".jumlah_akun_kredit_akrual").each(function(){
          jml_kredit_akrual += $(this).val()*1;
      });
      $('#total_kredit_akrual').text(jml_kredit_akrual.format(0, 3, '.', ''));
      jml_total_akrual = jml_kredit_akrual-jml_debet_akrual;
      
      $('#selisih_akrual').text(jml_total_akrual.format(0, 3, '.', ''));
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

  $(".jumlah_akun_kredit_kas").number(true,2);
  $(".jumlah_akun_debet_kas").number(true,2);
  $(".jumlah_akun_kredit_akrual").number(true,2);
  $(".jumlah_akun_debet_akrual").number(true,2);

  $('#add-akunKredit_kas').click(function () {
        var template = $("#template_akun_kas_kredit").clone();
        template.removeAttr("id");
        template.removeAttr("style");
        $('#group-akunKredit_kas').append(template);
        template.find('select').attr('class', template.find('select').attr('class') + ' akun_kredit_kas');
        template.find('select').attr('name', 'akun_kredit_kas[]');
        template.find('.input-md').attr('class', template.find('.input-md').attr('class') + ' jumlah_akun_kredit_kas');
        template.find('.input-md').attr('name', 'jumlah_akun_kredit_kas[]');
        template.find('select').selectize();
            registerEvents();

        var inputan = template.find('.input-md');
        $(inputan).number(true,2);
  });
    
  $('#add-akunDebet_kas').click(function () {
        var template = $("#template_akun_kas_debet").clone();
        template.removeAttr("id");
        template.removeAttr("style");
        $('#group-akunDebet_kas').append(template);
        template.find('select').attr('class', template.find('select').attr('class') + ' akun_debet_kas');
        template.find('select').attr('name', 'akun_debet_kas[]');
        template.find('.input-md').attr('class', template.find('.input-md').attr('class') + ' jumlah_akun_debet_kas');
        template.find('.input-md').attr('name', 'jumlah_akun_debet_kas[]');
        template.find('select').selectize();
            registerEvents();

        var inputan = template.find('.input-md');
        $(inputan).number(true,2);
  });

  $('#add-akunKredit_akrual').click(function () {
        var template = $("#template_akun_akrual_kredit").clone();
        template.removeAttr("id");
        template.removeAttr("style");
        $('#group-akunKredit_akrual').append(template);
        template.find('select').attr('class', template.find('select').attr('class') + ' akun_kredit_akrual');
        template.find('select').attr('name', 'akun_kredit_akrual[]');
        template.find('.input-md').attr('class', template.find('.input-md').attr('class') + ' jumlah_akun_kredit_akrual');
        template.find('.input-md').attr('name', 'jumlah_akun_kredit_akrual[]');
        template.find('select').selectize();
      registerEvents();
        var inputan = template.find('.input-md');
        $(inputan).number(true,2);
  });
    
  $('#add-akunDebet_akrual').click(function () {
        var template = $("#template_akun_akrual_debet").clone();
        template.removeAttr("id");
        template.removeAttr("style");
        $('#group-akunDebet_akrual').append(template);
        template.find('select').attr('class', template.find('select').attr('class') + ' akun_debet_akrual');
        template.find('select').attr('name', 'akun_debet_akrual[]');
        template.find('.input-md').attr('class', template.find('.input-md').attr('class') + ' jumlah_akun_debet_akrual');
        template.find('.input-md').attr('name', 'jumlah_akun_debet_akrual[]');
        template.find('select').selectize();
            registerEvents();
        var inputan = template.find('.input-md');
        $(inputan).number(true,2);
  });
    
  var no_kas = false;
    
  $("#no-kas").click(function(){
    if(this.checked) {
        $('#group-kas').attr('style', 'display:none');
        $('#group-akrual').attr('class', 'col-md-12');
        no_kas = true;
    }
    else {
        $('#group-kas').attr('style', 'border-right:1px solid #eee');
        $('#group-akrual').attr('class', 'col-md-6');
        no_kas = false;
    }
  });
    
  function validateForm(){
      if(no_kas){
          if (jml_total_akrual != 0){
              $('#alert-selisih').attr('style', 'text-align:center');
              $('#alert-jumlah').attr('style', 'text-align:center;display:none;');
              return false;
          } else {
              $('#alert-jumlah').attr('style', 'text-align:center;display:none;');
              $('#alert-selisih').attr('style', 'text-align:center;display:none;');
          }
      } else{
          if ((jml_kredit_kas != jml_kredit_akrual) || (jml_debet_kas != jml_debet_akrual) || (jml_total_kas != jml_total_akrual)){
              $('#alert-jumlah').attr('style', 'text-align:center');
              $('#alert-selisih').attr('style', 'text-align:center;display:none;');
              return false;
          } else if (jml_total_kas != 0){
              $('#alert-selisih').attr('style', 'text-align:center');
              $('#alert-jumlah').attr('style', 'text-align:center;display:none;');
              return false;
          } else {
              $('#alert-jumlah').attr('style', 'text-align:center;display:none;');
              $('#alert-selisih').attr('style', 'text-align:center;display:none;');
          }
      }
  }

  $('#tanggal').datepicker({
      format: "yyyy-mm-dd"
  });

  // var $select1 = $('#akun_debet_akrual').selectize();  // This initializes the selectize control
  // var selectize1 = $select1[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  // <?php if (isset($akun_debet_akrual)): ?>
  //       selectize1.setValue('<?=$akun_debet_akrual?>');  
  // <?php endif ?>
  



  // var $select3 = $('#unit_kerja').selectize();  // This initializes the selectize control
  // var selectize3 = $select3[0].selectize; // This stores the selectize object to a variable (with name 'selectize')
  // <?php if (isset($kode_unit)): ?>
  //     selectize3.setValue('<?=$kode_unit?>');
  // <?php endif ?>

  // var $select4 = $('#akun_kredit').selectize();  // This initializes the selectize control
  // var selectize4 = $select4[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  // <?php if (isset($akun_kredit)): ?>
  //     selectize4.setValue('<?=$akun_kredit?>');
  // <?php endif ?>


  // var $select5 = $('#akun_kredit_akrual').selectize();  // This initializes the selectize control
  // var selectize5 = $select5[0].selectize; // This stores the selectize object to a variable (with 

  // <?php if (isset($akun_kredit_akrual)): ?>
  //     selectize5.setValue('<?=$akun_kredit_akrual?>');
  // <?php endif ?>

  // $('#jumlah_akun_debet').keyup(function () {
  //   var current_val = $(this).val();
  //   $('#jumlah_akun_kredit').val(current_val);
  // })
</script>
