<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>UBAH PASSWORD</h2>
                   </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-lg-12">
 <!--
<?php echo form_open('ubah_password')?>
	<table class="units" align="center" cellspacing="1">
		<tr>
			<th colspan=2>Ganti Password</th>
		</tr>
		<tr>
			<td>Password Lama</td>
			<td><input type="password" name="old_pass" /></td>
		</tr>
		<tr>
			<td>Password Baru</td>
			<td><input type="password" name="new_pass" /></td>
		</tr>
		<tr>
			<td>Ketik Ulang Password</td>
			<td><input type="password" name="retype_pass"></td>
		</tr>
		<?php if($msg!=''):?>
			<tr>
				<td colspan="2">
					<?php echo $msg?>
				</td>
			</tr>
		<?php endif?>
		<tr>
			<td colspan="2" align="right">
				<input type="submit" value="Ubah" name="submit">
			</td>
		</tr>
	</table>
</form>
-->
   <?php echo (isset($message))?$message:'';?>
<?php echo form_open('user/ubah_password',array('class'=>'form-horizontal col-md-6 col-md-offset-3'))?>
  <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Password Lama</label>
    <div class="col-md-8">
      <input type="text" name="old_pass" class="form-control" placeholder="password lama">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Password Baru</label>
    <div class="col-md-8">
      <input type="text" name="new_pass" class="form-control" placeholder="password baru">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-md-4 control-label">Ulangi</label>
    <div class="col-md-8">
      <input type="text" name="retype_pass" class="form-control" placeholder="ulangi">
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
</div>
