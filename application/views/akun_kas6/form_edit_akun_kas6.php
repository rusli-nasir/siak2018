<?php
	$akun_kas6  = $result_akun_kas6[0];
?>
<td align="center"><label class="control-label"><?=$akun_kas6->kd_kas_6?></label></td>
<td align="center">
    <input type="text" name="nm_kas_6" id="nm_kas_6" class="nm_kas_6 validate[required] form-control" style="width:98%" value="<?=$akun_kas6->nm_kas_6?>">
    <!--<input type="text" name="nominal_kas_6" id="nominal_kas_6" class="validate[required,custom[integer],max[1]] form-control nominal_kas_6 xnumber" value="<?=$akun_kas6->nominal?>" disabled="disabled">-->
</td>
<td style="text-align: right" class="form_nominal_akun">0</td>
<td align="center"><button class="btn btn-sm btn-warning" disabled="disabled"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Tambah</button></td>
<td align="center" colspan="2" style="text-align:center">
				<div class="btn-group">
					<button type="submit"  rel="<?=$akun_kas6->kd_kas_6?>" class="btn btn-default submit btn-sm" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
					<button type="reset"  rel="<?=$akun_kas6->kd_kas_6?>" name="cancel" id="reset" class="btn btn-default cancel btn-sm" aria-label="Center Align"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span></button>
				</div>
				<!-- <input type="submit" class="btn btn-default" name="submit" id="add" value="simpan"> -->
			</td>