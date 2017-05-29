
<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">

<div class="row">
  <ol class="breadcrumb">
    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
    <li class="active">Kuitansi</li>
  </ol>
</div><!--/.row-->
<?php
  if($mode == 'lihat')
    echo form_open('#',array("class"=>"form-horizontal"));
  elseif ($mode == 'evaluasi') {
    echo form_open('akuntansi/jurnal_rsa/ganti_status/'.$id_kuitansi_jadi,array("class"=>"form-horizontal"));
  }
  elseif ($mode == 'posting') {
    echo form_open('akuntansi/rest_kuitansi/posting_kuitansi/'.$id_kuitansi_jadi,array("class"=>"form-horizontal"));
  }
?>

<fieldset>

<?php echo validation_errors(); ?>
<!-- Form Name -->
<legend><center>INPUT JURNAL PENGELUARAN KAS</center></legend>

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
  <input id="no_bukti" name="no_bukti" value="<?=$no_bukti?>" type="text" placeholder="No.Bukti" class="form-control input-md" required="" disabled>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="no_spm">No. SPM</label>  
  <div class="col-md-4">
  <input id="no_spm" name="no_spm" type="text" value="<?=$no_spm?>" placeholder="No. SPM" class="form-control input-md" required="" disabled>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="tanggal">Tanggal SPM</label>  
  <div class="col-md-4">
  <input id="tanggal" name="tanggal" type="text" value="<?=$tanggal?>" placeholder="Tanggal" class="form-control input-md" required="" disabled>
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="tanggal">Tanggal Bukti</label>  
  <div class="col-md-4">
  <input id="tanggal" name="tanggal" type="text" value="<?=$tanggal_bukti?>" placeholder="Tanggal" class="form-control input-md" required="" disabled>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="jenis_transaksi">Jenis Transaksi</label>  
  <div class="col-md-4">
  <input id="jenis_transaksi" name="jenis_transaksi" value="<?=$jenis?>" type="text" placeholder="Jenis Transaksi" class="form-control input-md" required="" disabled>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="kode_kegiatan">Kode Kegiatan</label>  
  <div class="col-md-4">
  <input id="kode_kegiatan" name="kode_kegiatan" type="text" value="<?=$kode_kegiatan?>" placeholder="Kode Kegiatan" class="form-control input-md" required="" disabled>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="unit_kerja">Unit Kerja</label>  
  <div class="col-md-4">
  <input id="unit_kerja" name="unit_kerja" type="text" value="<?=$unit_kerja?>" placeholder="Unit Kerja" class="form-control input-md" required="" disabled>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-2 control-label" for="uraian">Uraian</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="uraian" name="uraian" disabled><?=$uraian?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-2 control-label" for="jenis_pembatasan_dana">Jenis Pembatasan Dana</label>
  <div class="col-md-4">
    <select id="jenis_pembatasan_dana" name="jenis_pembatasan_dana" class="form-control" required="" disabled>
      <option value="">Pilih Jenis</option>
      <option <?php if ($jenis_pembatasan_dana == 'tidak_terikat'): ?> selected <?php endif ?> value="tidak_terikat" >Tidak Terikat</option>
      <option <?php if ($jenis_pembatasan_dana == 'terikat_temporer'): ?> selected <?php endif ?> value="terikat_temporer">Terikat Temporer</option>
      <option <?php if ($jenis_pembatasan_dana == 'terikat_permanen'): ?> selected <?php endif ?> value="terikat_permanen">Terikat Permanen</option>
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
    <input id="kas_akun_debet" name="kas_akun_debet" value="<?=$akun_debet_kas?>"  type="text" placeholder="Akun Debet" class="form-control input-md" required="" disabled>
      
    </div>

    

    <!-- <label class="col-md-1 control-label" for="akrual_akun_debet">Akun Debet</label>  
    <div class="col-md-3">
    <input id="akrual_akun_debet" name="akrual_akun_debet" value="<?=$akun_debet_kas?>" type="text" placeholder="Akun Debet" class="form-control input-md" required="" disabled>      
    </div> -->

    <label class="col-md-1 control-label" for="akun_debet_akrual">Akun Debet</label>
    <div class="col-md-3">
      <?php $akun_debet_akrual = $akun_debet_kas;
            $akun_debet_akrual[0] = 7;
            $kode_akun_akrual = $akun_debet;
            $kode_akun_akrual[0] = 7;
       ?>
      <input id="akun_debet_akrual" name="akun_debet_akrual_" value="<?php $uraian_akun = explode(' ', $akun_debet_akrual);
            if($uraian_akun[2]!='beban'){
              $uraian_akun[2] = 'beban';
            }
            $hasil_uraian = implode(' ', $uraian_akun);
            echo $hasil_uraian;
            ?>" type="text" placeholder="Akun Debet" class="form-control input-md" required="" disabled>
      <input type="hidden" name="akun_debet_akrual" value="<?=$kode_akun_akrual?>" disabled>
        
<!--       <select id="akun_debet_akrual" name="akun_debet_akrual" class="form-control" required="">
        <option value="">Pilih Akun</option>
        <option value="">
         <?php foreach ($akun_belanja as $akun) {
          ?>
          <option value="<?=$akun['kode_akun']?>"><?=$akun['kode_akun'].' - '.$akun['nama_akun']?></option>
          <?php
        }
        ?> 
      </select> -->
    </div>

    <div class="col-md-3">
    <input id="jumlah_akun_debet" name="jumlah_akun_debet" type="text" value="<?=number_format($jumlah_debet,2,',','.');?>" placeholder="Jumlah Akun Debet" class="form-control input-md" required="" disabled>
      
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
      <select id="akun_kredit" name="akun_kredit" class="form-control" required="" disabled>
        <option value="">Pilih Akun</option>
        <?php foreach ($akun_kas as $akun) {
          ?>
          <option <?php if ($akun['kd_kas_6'] == $akun_kredit): ?> selected <?php endif ?> value="<?=$akun['kd_kas_6']?>"><?=$akun['kd_kas_6'].' - '.$akun['nm_kas_6']?></option>
          <?php
        }
        ?>
        <?php if(!$selected): ?><option value="911101" selected>911101 - SAL</option><?php endif; ?>
      </select>
    </div>
    <!-- <label class="col-md-1 control-label" for="akrual_akun_kredit">Akun Kredit</label>   -->
    <!-- <div class="col-md-3">
    <input id="akrual_akun_kredit" name="akrual_akun_kredit" type="text" placeholder="Akun Kredit" class="form-control input-md" required="" >
      
    </div> -->
    <label class="col-md-1 control-label" for="akun_kredit_akrual">Akun Kredit</label>
    <div class="col-md-3">
      <select id="akun_kredit_akrual" name="akun_kredit_akrual" class="form-control" required="" disabled>
        <option value="">Pilih Akun</option>
        <?php
          $selected = false;
          foreach ($akun_kas as $akun) {
          ?>
          <option <?php if ($akun['akun_6'] == $akun_kredit_akrual): ?> selected <?php $selected=true; endif; ?> value="<?=$akun['akun_6']?>"><?=$akun['akun_6'].' - '.$akun['nama']?></option>
          <?php
        }
        ?>
      </select>

    </div>
    <div class="col-md-3">
    <input id="jumlah_akun_kredit" name="jumlah_akun_kredit" type="text" placeholder="Jumlah Akun Kredit" class="form-control input-md" value="<?=number_format($jumlah_kredit,2,',','.');?>" disabled required="">
      
    </div>
  </div>
  <hr/>

  <?php if ($mode == 'evaluasi'): ?>
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-2 control-label" for="komentar">Komentar : </label>  
      <div class="col-md-4">
      <input id="komentar" name="komentar" type="text" placeholder="Komentar" class="form-control input-md" value=" ">
        
      </div>
    </div>
    <div class="form-group">
    <div class="col-sm-offset-2 col-md-8">
      <label class="radio-inline"><input type="radio" name="status" value='2' required>Diterima</label>
      <label class="radio-inline"><input type="radio" name="status" value='3' required>Revisi</label>
    </div>
  </div>
  <?php endif ?>


</fieldset>


<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="simpan"></label>
  <div class="col-md-8">
    <?php if ($mode == 'evaluasi'): ?>
    <button id="simpan" name="simpan" class="btn btn-success" type="submit">Simpan</button>
    <?php endif ?>
    <?php if ($mode == 'posting'): ?>
    <button id="posting" name="posting" class="btn btn-success" type="submit" onclick="return confirm('Yakin memposting ini?')">Posting</button>
    <?php endif ?>
    <?php if($mode=='lihat' AND $this->session->userdata('level')==3){ ?>
    <a href="<?php echo site_url('akuntansi/kuitansi/send_service/'.$id_kuitansi_jadi); ?>" onclick="return confirm('Kirim data ke aplikasi Laporan Akuntansi?')"><button name="posting" class="btn btn-success" type="button">Posting</button></a>
    <?php } ?>
    <a href="<?php echo site_url('akuntansi/kuitansi/jadi'); ?>"><button id="keluar" name="keluar" class="btn btn-danger" type="button">Keluar</button></a>
  </div>
</div>

</fieldset>
</form>

<script>
  // var $select = $('#akun_debet_akrual').selectize();  // This initializes the selectize control
  // var selectize = $select[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  // selectize.setValue('<?=$kode_akun?>');
</script>