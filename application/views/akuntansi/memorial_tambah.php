
<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">
<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap-datepicker.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker.css" rel="stylesheet">

<script src="<?php echo base_url();?>/assets/akuntansi/js/easynumber/jquery.number.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var host = "<?=site_url('/')?>";
  Number.prototype.format = function(n, x, s, c) {
      var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
          num = this.toFixed(Math.max(0, ~~n));

      return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
  };
  $("#kegiatan").change(function(){
    var kode_kegiatan = $(this).val();
    $.ajax({
      url:host+'akuntansi/memorial/get_output/'+kode_kegiatan,
      data:{},
      success:function(data){
        $("#output").html(data);
        $("#program").html('<option value="">----</option>');
      }
    })
  })

  $("#output").change(function(){
    var kode_kegiatan = $("#kegiatan").val();
    var kode_output = $(this).val();
    $.ajax({
      url:host+'akuntansi/memorial/get_program/'+kode_kegiatan+'/'+kode_output,
      data:{},
      success:function(data){
        $("#program").html(data);
      }
    })
  })

  $("#tambah_pajak_btn").click(function(){
    $.ajax({
      url:host+'akuntansi/memorial/add_pajak',
      data:{},
      success:function(data){
        $("#field_pajak").append(data);
        $(".number_pajak").number(true,2);
      }
    })
  })

  $(document).on('click', '.del_pajak', function(){
      $(this).parents('tr').remove();
  });
})
</script>

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
<?php echo form_open('akuntansi/memorial/input_memorial',array("class"=>"form-horizontal", "onsubmit" => "return validateForm()")); ?>

<div class="form-group">
  <label class="col-md-2 control-label" for="no_bukti">No. Bukti</label>  
  <div class="col-md-4">
  <input id="no_bukti" name="no_bukti" value="<?= $no_bukti; ?>" type="text" class="form-control input-md" required="" readonly>
    
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
  <label class="col-md-2 control-label" for="jenis">Jenis Transaksi</label>  
  <div class="col-md-4">
  <!-- <input name="jenis" type="text" placeholder="Jenis Transaksi" class="form-control input-md" required=""> -->
  <select id="jenis" name="jenis" class="form-control" required="">
      <option value="">Pilih Jenis</option>
      <option value="MEMORIAL" selected="">Memorial</option>
      <option value="GP" >GUP</option>
      <option value="LS-Gaji">LS-Gaji</option>
      <option value="TUP">TUP</option>
      <option value="LSPHK3">LS PIHAK KE 3</option>
    </select>
  </div>
    
</div>

<!-- Text input-->
<!-- <div class="form-group">
  <label class="col-md-2 control-label" for="kode_kegiatan">Kode Kegiatan</label>  
  <div class="col-md-4">
  <input id="kode_kegiatan" name="kode_kegiatan" type="text" placeholder="Kode Kegiatan" class="form-control input-md" required="">

  </div>
</div> -->

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="unit_kerja">Unit Kerja</label>  
  <div class="col-md-4">
  <!-- <input id="unit_kerja" name="unit_kerja" type="text" placeholder="Unit Kerja" class="form-control input-md" required=""> -->
      <?php if($this->session->userdata('level')==1 or $this->session->userdata('level')==2 or $this->session->userdata('level')==5){ ?>
          <?php foreach($all_unit_kerja as $unit){
            if($unit['kode_unit']==$this->session->userdata('kode_unit')){
              $nama_unit = $unit['nama_unit'];
            }
          }
          ?>
          <input type="hidden" class="form-control" name="unit_kerja" value="<?php echo $this->session->userdata('kode_unit') ?>">
          <input type="text" class="form-control" value="<?php echo $nama_unit; ?>" readonly>
          <?php }else{ ?>
          <select id="unit_kerja" name="unit_kerja" class="form-control" required="">
            <option value="">Pilih Unit</option>
            <?php foreach ($all_unit_kerja as $unit) {
              ?>
              <option value="<?=$unit['kode_unit']?>"><?=$unit['kode_unit'].' - '.$unit['nama_unit']?></option>
              <?php
            }
            ?>
            <?php if($this->session->userdata('kode_unit')==9999): ?>
            <option value="9999">Penerimaan</option>
          <?php endif ?>
          </select>
          <?php } ?>    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label">Kegiatan</label>  
  <div class="col-md-6">
      <select id="kegiatan" name="kegiatan" class="form-control" required="">
        <option value="">Pilih Kegiatan</option>
        <?php foreach ($kegiatan->result() as $result) {
          ?>
          <option value="<?=$result->kode_kegiatan;?>"><?=$result->kode_kegiatan.' - '.$result->nama_kegiatan?></option>
          <?php
        }
        ?>
      </select>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label">Output</label>  
  <div class="col-md-6">
      <select id="output" name="output" class="form-control" required="">
        <option value="">----</option>
      </select>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label">Program</label>  
  <div class="col-md-6">
      <select id="program" name="program" class="form-control" required="">
        <option value="">----</option>
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

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-2 control-label" for="untuk">Untuk</label>
  <div class="col-md-6">                     
    <textarea class="form-control" id="untuk" name="untuk"></textarea>
  </div>
</div>

<div class="form-group checkbox" align="center">
    <label><input type="checkbox" id="no-kas">  Kosongkan Kas</label>
</div>
<hr>
<!-- Text input-->
<fieldset>  
    
  <div class="col-md-6" style="border-right:1px solid #eee" id="group-kas">
      <div class="col-md-12 control-label" style="text-align: center;"><h3><strong>Kas</strong></h3></div>
      
      <div class="col-md-12 control-label" style="text-align: left"><h4>Debet<button id="add-akunDebet_kas" class="close" style="background:#1B5E20; padding: 0px 4px; color:white; opacity:1" type="button">+</button></h4></div>
      <div class="col-md-12" id="group-akunDebet_kas">
        <div class="form-group"> 
          <div class="col-md-5">
            <select name="akun_debet_kas[]" class="form-control akun_debet_kas">
                <option value="">Pilih Akun</option>
                <option value="">
                 <?php foreach ($akun_kas as $akun) {
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
        <div class="form-group"> 
          <div class="col-md-5">
            <select name="akun_kredit_kas[]" class="form-control akun_kredit_kas">
                <option value="">Pilih Akun</option>
                <option value="">
                 <?php foreach ($akun_kas as $akun) {
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
        <div class="form-group"> 
          <div class="col-md-5">
            <select name="akun_debet_akrual[]" class="form-control akun_debet_akrual" required="">
                <option value="">Pilih Akun</option>
                <option value="">
                 <?php foreach ($akun_akrual as $akun) {
                  ?>
              <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '; ?>
                <?php
                if(substr($akun['akun_6'], 0, 1)=='7'){
                  $uraian_akun = explode(' ', $akun['nama']);
                  if($uraian_akun[0]!='beban'){
                    $uraian_akun[0] = 'Beban';
                  }
                  $hasil_uraian = implode(' ', $uraian_akun);
                  echo $hasil_uraian;
                }else{
                  echo $akun['nama'];
                }
                ?>
              </option>
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
        <div class="form-group"> 
          <div class="col-md-5">
            <select name="akun_kredit_akrual[]" class="form-control akun_kredit_akrual" required="">
                <option value="">Pilih Akun</option>
                <option value="">
                 <?php foreach ($akun_akrual as $akun) {
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

<fieldset>
  <hr>
  <div class="col-sm-12 control-label" style="text-align: center;"><h3><strong>Pajak</strong></h3></div>
  <div class="col-sm-8 col-sm-offset-2">
    <table class="table">
      <thead>
        <tr>
          <th style="width:30%">Jenis Pajak</th>
          <th style="width:35%">Jumlah</th>
          <th style="width:10%">Aksi</th>
        </tr>
      </thead>
      <tbody id="field_pajak">
        <tr>
          <td>
            <select class="form-control" name="id_pajak[]">
              <option value="">Pilih Jenis</option>
              <?php foreach($akun_pajak->result() as $result){ ?>
              <option value="<?php echo $result->id_akun_pajak; ?>"><?php echo $result->nama_akun; ?></option>
              <?php } ?>
            </select>
          </td>
          <td><input type="text" name="jumlah[]" pattern="[0-9.,]{1,20}" maxlength="20" class="form-control number_pajak"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" align="right"><button type="button" id="tambah_pajak_btn" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-plus"></span> Tambah Pajak</button></td>
        </tr>
      </tfoot>
    </table>
  </div>
</fieldset>


<!-- Button (Double) -->
<div class="form-group" style="margin-top:12px;">
  <div id="alert-jumlah" class="col-md-12" style="text-align:center;display:none">
      <p style="color:red">Semua angka jumlah pada basis kas harus sama dengan angka jumlah pada basis akrual</p>
  </div>
  <div id="alert-selisih" class="col-md-12" style="text-align:center;display:none">
      <p style="color:red">Selisih kredit dan debet harus nol</p>
  </div>
  <div class="col-md-12" style="text-align:center;">
    <button id="simpan" name="simpan" class="btn btn-success" type="submit">Simpan</button>
    <a href="<?php echo site_url('akuntansi/memorial/index'); ?>"><button id="keluar" name="keluar" class="btn btn-danger" type="button">Keluar</button></a>
  </div>
</div>

</fieldset>
<?= form_close(); ?>

<!-- template akun kredit -->
<div class="form-group" id="template_akun_kas" style="display:none;"> 
  <div class="col-md-5">
    <select class="form-control">
        <option value="">Pilih Akun</option>
        <option value="">
         <?php foreach ($akun_kas as $akun) {
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
    
  <div class="col-md-1">
      <a role="button" class="remove-entry close" style="background:#F44336; padding: 2px 8px; color:white; opacity:1">-</a>
  </div>

</div>

<!-- template akun debet -->
<div class="form-group" id="template_akun_akrual" style="display:none;"> 
  <div class="col-md-5">
    <select class="form-control" required="">
        <option value="">Pilih Akun</option>
        <option value="">
         <?php foreach ($akun_akrual as $akun) {
          ?>
          <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '; ?>
                <?php
                if(substr($akun['akun_6'], 0, 1)=='7'){
                  $uraian_akun = explode(' ', $akun['nama']);
                  if($uraian_akun[0]!='beban'){
                    $uraian_akun[0] = 'Beban';
                  }
                  $hasil_uraian = implode(' ', $uraian_akun);
                  echo $hasil_uraian;
                }else{
                  echo $akun['nama'];
                }
                ?>
              </option>
          <?php
        }
        ?> 
    </select> 
  </div>

  <div class="col-md-6">
  <input type="text" class="form-control input-md" required="">
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
  $(".number_pajak").number(true,2);

  $('#add-akunKredit_kas').click(function () {
        var template = $("#template_akun_kas").clone();
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
        var template = $("#template_akun_kas").clone();
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
        var template = $("#template_akun_akrual").clone();
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
        var template = $("#template_akun_akrual").clone();
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
    
    var $select3 = $('#unit_kerja').selectize();  // This initializes the selectize control
  var selectize3 = $select3[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  <?php if (isset($unit_kerja)): ?>
      selectize3.setValue('<?=$unit_kerja?>');
  <?php endif ?>

</script>
