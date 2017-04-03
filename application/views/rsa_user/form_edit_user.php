<?php
	$user = $result_user[0];
	$disabled="";
	if ($user->level==1){
		// $disabled="DISABLED";
	}
?>
<td colspan="8" class="alert alert-info">
	<?php
		// var_dump($user);
	?>
<h2 align="center">Form Edit User <?=$user->username?></h2><hr>
 <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Unit</label>
    <div class="col-md-8">
      <?php echo form_dropdown('subunit',isset($opt_subunit)?$opt_subunit:array(),isset($subunit)?$subunit:$user->kode_unit_subunit,'id="subunit"  onchange="javascript:set_sub_unit()" class="validate[required] form-control" '.$disabled);?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Level</label>
    <div class="col-md-8">
     <?php echo form_dropdown('level',isset($level)?$level:array(),$user->level,'id="level" class="validate[required] form-control" '.$disabled);?>
    </div>
  </div>
   <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Username</label>
    <div class="col-md-8">
     <input type="text" class="validate[required] form-control" id="user_username" name="user_username" value="<?=$user->username?>" DISABLED>
    </div>
  </div>
	 <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Password</label>
    <div class="col-md-8">
     <input type="text" class="validate[custom[onlyLetterNumber]] form-control" id="user_password" name="user_password" value=""  >
    </div>
  </div>
  	 <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Aktif</label>
    <div class="col-md-8">
     <?php echo form_dropdown('flag_aktif',isset($aktif)?$aktif:array(),$user->flag_aktif,'id="flag_aktif" class="validate[required] form-control" '.$disabled);?>
    </div>
  </div>
   <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Nama Lengkap</label>
    <div class="col-md-8">
      <input type="text"  class="validate[required] form-control" id="nm_lengkap" name="nm_lengkap" value="<?=$user->nm_lengkap?>">
    </div>
  </div>
   <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Nomor Induk</label>
    <div class="col-md-8">
      <input type="text"  class="validate[required] form-control" id="nomor_induk" name="nomor_induk" value="<?=$user->nomor_induk?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Bank</label>
    <div class="col-md-8">
      <input type="text"  class="validate[required] form-control" id="nama_bank" name="nama_bank" value="<?=$user->nama_bank?>">
    </div>
  </div>
   <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">No.Rekening</label>
    <div class="col-md-8">
      <input type="text"  class="form-control" id="no_rek" name="no_rek" value="<?=$user->no_rek?>">
    </div>
  </div>
   <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">NPWP</label>
    <div class="col-md-8">
      <input type="text"  class="form-control" id="npwp" name="npwp" value="<?=$user->npwp?>">
    </div>
  </div>
   <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Alamat</label>
    <div class="col-md-8">
      <input type="text"  class="form-control" id="alamat" name="alamat" value="<?=$user->alamat?>">
    </div>
  </div>
  <div class="btn-group">
					<button type="submit" rel="<?=$user->username?>" class="btn btn-default submit btn-sm" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
					<button type="reset" rel="<?=$user->username?>" name="cancel" id="reset" class="btn btn-default cancel btn-sm" aria-label="Center Align"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span></button>
				</div>
<td>
