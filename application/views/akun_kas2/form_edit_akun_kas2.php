<?php
	$akun_kas2 = $result_akun_kas2[0];
?>

			<td align="center"><label class="control-label"><?=$akun_kas2->kd_kas_2?></label></td>
			<td align="center"><input type="text" name="nm_kas_2" id="nm_kas_2" class="nm_kas_2 validate[required] form-control" value="<?=$akun_kas2->nm_kas_2?>"></td>
			<td align="center" colspan="2" style="text-align:center">
				<div class="btn-group">
					<button type="submit" rel="<?=$akun_kas2->kd_kas_2?>" class="btn btn-default submit btn-sm" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
					<button type="reset" rel="<?=$akun_kas2->kd_kas_2?>" name="cancel" id="reset" class="btn btn-default cancel btn-sm" aria-label="Center Align"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span></button>
				</div>
				<!-- <input type="submit" class="btn btn-default" name="submit" id="add" value="simpan"> -->
			</td>