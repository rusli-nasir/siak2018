
<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">

<div class="row">
  <ol class="breadcrumb">
    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
    <li class="active">Kuitansi</li>
  </ol>
</div><!--/.row-->
<?php echo form_open('akuntansi/jurnal_rsa/input_jurnal/'.$id_kuitansi.'/'.$jenis,array("class"=>"form-horizontal")); ?>
<fieldset>

<?php echo validation_errors(); ?>
<!-- Form Name -->
<legend><center>INPUT JURNAL PENGELUARAN KAS</center></legend>

<!-- Text input-->
<?php
if($jenis=='NK'){
  $no_bukti = substr($str_nomor_trx_spm, 6, 3).substr($str_nomor_trx_spm, 0, 5); 
}else{
  $no_bukti = $no_bukti;
}
?>
<div class="form-group">
  <label class="col-md-2 control-label" for="no_bukti">No. Bukti</label>  
  <div class="col-md-4">
  <input id="no_bukti" name="no_bukti" value="<?php echo $no_bukti; ?>" type="text" placeholder="No.Bukti" class="form-control input-md" required="" readonly>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="no_spm">No. SPM</label>  
  <div class="col-md-4">
  <input id="no_spm" name="no_spm" type="text" value="<?=$str_nomor_trx_spm?>" placeholder="No. SPM" class="form-control input-md" required="" disabled>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="tanggal">Tanggal</label>  
  <div class="col-md-4">
  <input id="tanggal" name="tanggal" type="text" value="<?=$tanggal?>" placeholder="Tanggal" class="form-control input-md" required="" disabled>
    
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
  <input id="kode_kegiatan" name="kode_kegiatan" type="text" value="<?=$kode_usulan_belanja?>" placeholder="Kode Kegiatan" class="form-control input-md" required="" disabled>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="unit_kerja">Unit Kerja</label>  
  <div class="col-md-4">
  <input type="text" value="<?php echo $this->session->userdata('username'); ?>" placeholder="Unit Kerja" class="form-control input-md" required="" disabled>
  <input name="unit_kerja" type="hidden" value="<?php echo $this->session->userdata('kode_unit'); ?>">
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-2 control-label" for="uraian">Uraian</label>
  <div class="col-md-4">                     
    <textarea class="form-control" required="" id="uraian" name="uraian" <?php if (!isset($jenis_isian)): ?> disabled <?php endif ?>><?=$uraian?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-2 control-label" for="jenis_pembatasan_dana">Jenis Pembatasan Dana</label>
  <div class="col-md-4">
    <select id="jenis_pembatasan_dana" name="jenis_pembatasan_dana" class="form-control" required="">
      <option value="">Pilih Jenis</option><!-- 
      <option value="terikat">Tidak Terikat</option>
      <option value="tidak_terikat">Terikat Temporer</option>
      <option value="terikat_permanen">Terikat Permanen</option> -->
      <option <?php if (isset($jenis_pembatasan_dana)) if ($jenis_pembatasan_dana == 'tidak_terikat'): ?> selected <?php endif ?> value="tidak_terikat" >Tidak Terikat</option>
      <option <?php if (isset($jenis_pembatasan_dana)) if ($jenis_pembatasan_dana == 'terikat_temporer'): ?> selected <?php endif ?> value="terikat_temporer">Terikat Temporer</option>
      <option <?php if (isset($jenis_pembatasan_dana)) if ($jenis_pembatasan_dana == 'terikat_permanen'): ?> selected <?php endif ?> value="terikat_permanen">Terikat Permanen</option>
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
      <!-- <input id="akun_debet_akrual" name="akun_debet_akrual_" type="text" placeholder="Akun Debet" class="form-control input-md" required=""> -->
      <select id="akun_debet_akrual" name="akun_debet_akrual" class="form-control" required="">
          <option value="">Pilih Akun</option>
          <?php foreach($query_1->result() as $result){ ?>
            <option value="<?php echo $result->akun_6; ?>"><?php echo $result->akun_6.' - '.$result->nama; ?></option>
          <?php } ?>
          <?php foreach($query_2->result() as $result){ ?>
            <option value="<?php echo $result->akun_6; ?>"><?php echo $result->akun_6.' - '.$result->nama; ?></option>
          <?php } ?>
          <option value="">
           <?php foreach ($akun_belanja as $akun) {
            $akun['kode_akun'][0] = 7;
            ?>
            <option value="<?=$akun['kode_akun']?>"><?=$akun['kode_akun'].' - ';
            $uraian_akun = explode(' ', $akun['nama_akun']);
            if($uraian_akun[0]!='beban'){
              $uraian_akun[0] = 'beban';
            }
            $hasil_uraian = implode(' ', $uraian_akun);
            echo $hasil_uraian;
            ?></option>
            <?php
          }
          ?>         
      </select> 
        
    </div>

    <!-- <label class="col-md-1 control-label" for="akun_debet_akrual">Akun Debet</label>
    <div class="col-md-3">
      <input id="akun_debet_akrual" name="akun_debet_akrual_" value="<?=$akun_debet_akrual?>"  type="text" placeholder="Akun Debet" class="form-control input-md" required="" disabled>
      <input type="hidden" name="akun_debet_akrual" value="<?=$kode_akun_akrual?>"> -->
        
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

    <div class="col-md-3">
    <input id="jumlah_akun_debet" name="jumlah_akun_debet" type="text" value="<?=$pengeluaran?>" placeholder="Jumlah Akun Debet" class="form-control input-md" required="" disabled>
      
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
        <option value="911101">911101 - SAL</option>
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
        <?php foreach ($akun_kas as $akun) {
          ?>
          <option value="<?=$akun->akun_6?>"><?=$akun->akun_6.' - '.$akun->nama?></option>
          <?php
        }
        ?>
      </select>
    </div>
    <div class="col-md-3">
    <input id="jumlah_akun_kredit" name="jumlah_akun_kredit" type="text" placeholder="Jumlah Akun Kredit" class="form-control input-md" value="<?=$pengeluaran?>" disabled required="">
      
    </div>
  </div>


</fieldset>


<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="simpan"></label>
  <div class="col-md-8">
    <button id="simpan" name="simpan" class="btn btn-success" type="submit">Simpan</button>
    <button id="keluar" name="keluar" class="btn btn-danger" type="button">Keluar</button>
  </div>
</div>

</fieldset>
</form>

<script>
  var $select1 = $('#akun_debet_akrual').selectize();  // This initializes the selectize control
  var selectize1 = $select1[0].selectize; // This stores the selectize object to a variable (with name 'selectize')

  <?php if (isset($akun_debet_akrual)): ?>
        selectize1.setValue('<?=$akun_debet_akrual?>');  
  <?php endif ?>
</script>