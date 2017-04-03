<?php
	//$user = $result_user[0];
	$user = isset($result_user)?$result_user:'';
	
?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
				<h4 align="center">UBAH DATA PRIBADI ANDA "<?=$user->username;?>"</h4><hr>
   <?php echo (isset($message))?$message:'';?>
<?php echo form_open('user/ubah_data',array('class'=>'form-horizontal col-md-6 col-md-offset-3'))?>
  <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Nama Lengkap (Title Lengkap)</label>
    <div class="col-md-8">
      <input type="text" class="validate[required] form-control" id="nm_lengkap" name="nm_lengkap" value="<?=$user->nm_lengkap?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">NIP</label>
    <div class="col-md-8">
      <input type="text" class="validate[required] form-control" id="nomor_induk" name="nomor_induk" value="<?=$user->nomor_induk?>">
    </div>
  </div>
   <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Nama Bank</label>
    <div class="col-md-8">
      <input type="text" class="validate[required] form-control" id="nama_bank" name="nama_bank" value="<?=$user->nama_bank?>">
    </div>
  </div>
	 <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Nomor rekening</label>
    <div class="col-md-8">
      <input type="text" class="validate[required] form-control" id="no_rek" name="no_rek" value="<?=$user->no_rek?>">
    </div>
  </div>
  	 <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">NPWP</label>
    <div class="col-md-8">
      <input type="text" class="validate[required] form-control" id="npwp" name="npwp" value="<?=$user->npwp?>">
    </div>
  </div>
   <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Alamat</label>
    <div class="col-md-8">
      <input type="text"  class="validate[required] form-control" id="alamat" name="alamat" value="<?=$user->alamat?>">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8" style="text-align:right">
      <button type="submit" name="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Submit</button>
    </div>
  </div>
</form>

 </div>  
</div>
</div>