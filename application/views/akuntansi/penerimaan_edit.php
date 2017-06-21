
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
  <legend>
    <div class="col-md-2 control-label">Jurnal Basis Kas</div>
    <div class="col-md-5 control-label">Jurnal Basis Akrual</div>
    <div class="col-md-3 control-label">Jumlah (Rp)</div>
  </legend> <br/>
  <div class="form-group">
    <label class="col-md-2 control-label" for="kas_akun_debet">Akun Debet</label>  
    <div class="col-md-3">

      <select id="kas_akun_debet" name="kas_akun_debet" class="form-control" required="">
          <option <?php if ($akun_debet == '911101'): ?> selected <?php endif ?> value="911101">911101 - SAL</option>
          <?php foreach ($akun_kas_akrual as $akun) {
            ?>
            <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
            <?php
          }
          ?> 
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
          <?php foreach ($akun_kas_akrual as $akun) {
            ?>
            <option value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
            <?php
          }
          ?>
          ?> 
      </select> 
        
    </div>


    <div class="col-md-3">
    <input id="jumlah_akun_debet" name="jumlah_akun_debet" type="text"  placeholder="Jumlah Akun Debet" value="<?=$jumlah_debet?>" class="form-control input-md" required="">
      
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
    <input id="jumlah_akun_kredit" name="jumlah_akun_kredit" type="text" placeholder="Jumlah Akun Kredit" value="<?=$jumlah_kredit?>" class="form-control input-md"  required="">
      
    </div>
  </div>
  <hr/>

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

<script>

  $('#tanggal').datepicker({
      format: "yyyy-mm-dd"
  });

  var $select1 = $('#akun_debet_akrual').selectize();  // This initializes the selectize control
  var selectize1 = $select1[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  <?php if (isset($akun_debet_akrual)): ?>
        selectize1.setValue('<?=$akun_debet_akrual?>');  
  <?php endif ?>
  



  // var $select3 = $('#unit_kerja').selectize();  // This initializes the selectize control
  // var selectize3 = $select3[0].selectize; // This stores the selectize object to a variable (with name 'selectize')
  <?php if (isset($kode_unit)): ?>
      selectize3.setValue('<?=$kode_unit?>');
  <?php endif ?>

  var $select4 = $('#akun_kredit').selectize();  // This initializes the selectize control
  var selectize4 = $select4[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  <?php if (isset($akun_kredit)): ?>
      selectize4.setValue('<?=$akun_kredit?>');
  <?php endif ?>


  var $select5 = $('#akun_kredit_akrual').selectize();  // This initializes the selectize control
  var selectize5 = $select5[0].selectize; // This stores the selectize object to a variable (with 

  <?php if (isset($akun_kredit_akrual)): ?>
      selectize5.setValue('<?=$akun_kredit_akrual?>');
  <?php endif ?>

  $('#jumlah_akun_debet').keyup(function () {
    var current_val = $(this).val();
    $('#jumlah_akun_kredit').val(current_val);
  })
</script>
