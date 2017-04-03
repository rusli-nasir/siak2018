<?php
	$akun_kas5  = $result_akun_kas5[0];
?>
<td align="center"><label class="control-label"><?=$akun_kas5->kd_kas_5?></label></td>
			<td align="center"><input type="text" name="nm_kas_5" id="nm_kas_5" class="nm_kas_5 validate[required] form-control" value="<?=$akun_kas5->nm_kas_5?>"></td>
<!--			<td align="center"><input type="text" name="nominal_kas_5" id="nominal_kas_5" class="validate[required,custom[integer],min[1]] form-control nominal_kas_5 xnumber" value="<?=$akun_kas5->nominal?>"></td>-->
			<td align="center" colspan="2" style="text-align:center">
				<div class="btn-group">
					<button type="submit" rel="<?=$akun_kas5->kd_kas_5?>" class="btn btn-default submit btn-sm" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
					<button type="reset" rel="<?=$akun_kas5->kd_kas_5?>" name="cancel" id="reset" class="btn btn-default cancel btn-sm" aria-label="Center Align"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span></button>
				</div>
				<!-- <input type="submit" class="btn btn-default" name="submit" id="add" value="simpan"> -->
			</td>