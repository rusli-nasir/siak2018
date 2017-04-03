<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<div class="container">
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend><center>INPUT JURNAL PENGELUARAN KAS</center></legend>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" for="no_bukti">No. Bukti</label>  
  <div class="col-md-4">
  <input id="no_bukti" name="no_bukti" type="text" placeholder="No.Bukti" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="no_spm">No. SPM</label>  
  <div class="col-md-4">
  <input id="no_spm" name="no_spm" type="text" placeholder="No. SPM" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="tanggal">Tanggal</label>  
  <div class="col-md-4">
  <input id="tanggal" name="tanggal" type="text" placeholder="Tanggal" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="jenis_transaksi">Jenis Transaksi</label>  
  <div class="col-md-4">
  <input id="jenis_transaksi" name="jenis_transaksi" type="text" placeholder="Jenis Transaksi" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="kode_kegiatan">Kode Kegiatan</label>  
  <div class="col-md-4">
  <input id="kode_kegiatan" name="kode_kegiatan" type="text" placeholder="Kode Kegiatan" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="unit_kerja">Unit Kerja</label>  
  <div class="col-md-4">
  <input id="unit_kerja" name="unit_kerja" type="text" placeholder="Unit Kerja" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="uraian">Uraian</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="uraian" name="uraian"></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="jenis_pembatasan_dana">Jenis Pembatasan Dana</label>
  <div class="col-md-4">
    <select id="jenis_pembatasan_dana" name="jenis_pembatasan_dana" class="form-control">
      <option value="terikat">Tidak Terikat</option>
      <option value="tidak_terikat">Terikat</option>
      <option value="???">???</option>
    </select>
  </div>
</div>

<!-- Text input-->
<fieldset>
  <legend>
    <div class="col-md-4 control-label">Jenis Pembatasan Dana</div>
    <div class="col-md-4 control-label">Jurnal Basis Akrual</div>
    <div class="col-md-4 control-label">Jumlah (Rp)</div>
  </legend> <br/>
  <div class="form-group">
    <label class="col-md-4 control-label" for="kas_akun_debet">Akun Debet (kas)</label>  
    <div class="col-md-2">
    <input id="kas_akun_debet" name="kas_akun_debet" type="text" placeholder="Akun Debet" class="form-control input-md" required="">
      
    </div>
    <label class="col-md-2 control-label" for="akrual_akun_debet">Akun Debet</label>  
    <div class="col-md-2">
    <input id="akrual_akun_debet" name="akrual_akun_debet" type="text" placeholder="Akun Debet" class="form-control input-md" required="">
      
    </div>
    <div class="col-md-2">
    <input id="jumlah_akun_debet" name="jumlah_akun_debet" type="text" placeholder="Jumlah Akun Debet" class="form-control input-md" required="">
      
    </div>

  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="kas_akun_kredit">Akun Kredit (kas)</label>  
    <div class="col-md-2">
    <input id="kas_akun_kredit" name="kas_akun_kredit" type="text" placeholder="Akun Kredit" class="form-control input-md" required="">
      
    </div>
    <label class="col-md-2 control-label" for="akrual_akun_kredit">Akun Kredit</label>  
    <div class="col-md-2">
    <input id="akrual_akun_kredit" name="akrual_akun_kredit" type="text" placeholder="Akun Kredit" class="form-control input-md" required="">
      
    </div>
    <div class="col-md-2">
    <input id="jumlah_akun_kredit" name="jumlah_akun_kredit" type="text" placeholder="Jumlah Akun Kredit" class="form-control input-md" required="">
      
    </div>
  </div>


</fieldset>


<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="simpan"></label>
  <div class="col-md-8">
    <button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
    <button id="keluar" name="keluar" class="btn btn-danger">Keluar</button>
  </div>
</div>

</fieldset>
</form>
</div>