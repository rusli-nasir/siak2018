<script>
$("#alert-kpa-edit").hide();
$("#alert-buu-edit").hide();
$("#peringatan-kpa-edit").hide();
$("#level_edit").change(function() {
    var isi = $(this).val();
    var kd_unit = $(this).attr('data-unit');
    var aksi = $("#subunit_edit").attr('data-aksi');
    // alert(aksi);
    set_sub_unit(isi,kd_unit,aksi);
});
</script>
<?php
$user = $result_user[0];
$disabled="";
if ($user->level==1){
// $disabled="DISABLED";
}
?>
<form id="form_user_edit" onsubmit="return false" data-aksi="edit">
<div class="modal-header blue-gradient text-white">
    <button type="button" class="close" data-dismiss="modal" style="color: #fff;opacity: 1;">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    <h4 class="modal-title text-center" id="myModalLabel">
        Form Edit User <b style="color:#e3ff46;"><?=$user->username?></b>
    </h4>
</div>

<div class="modal-body">

    <table class="table-condensed" id="add_user" style="margin: auto;">
        <tbody>
            <tr>
                <td><b>Level</b></td>
                <td align="left" >
                    <?php echo form_dropdown('level',isset($level)?$level:array(),$user->level,'id="level_edit" class="validate[required] form-control" rel="'.$user->kode_unit_subunit.'"'.$disabled.'DISABLED');?>
                </td>
            </tr>
            <tr id="peringatan-kpa-edit">
                <td>
                </td>
                <td>
                    Dalam setiap unit/subunit hanya dapat memiliki satu <b><span style="color: red"><?php echo $level['2'] ?></b></span>
                </td>
            </tr>

            <tr>
                <td class="col-md-2"><b>Unit</b></td>
                <td align="left">
                    <select class="validate[required] form-control" name="subunit" id="subunit_edit" data-aksi="edit" data-unit="" DISABLED></select>
                </td>
            </tr>
            <tr id="alert-kpa-edit">
                <td>
                </td>
                <td>
                    level <b><span style="color: red"><?php echo $level['2'] ?></b></span> sudah ada pada unit/subunit <b><span style="color: red" id="nama_subunit_edit"></span></b>
                </td>
            </tr>
            <tr id="alert-buu-edit">
                <td>
                </td>
                <td>
                    level <b><span style="color: red"><?php echo $level['5'] ?></b></span> sudah ada pada unit  <b><span style="color: red" id="nama_subunit_edit">PUSAT</span></b>
                </td>
            </tr>
            <tr>
                <td><b>Username</b></td>
                <td align="left">
                    <input type="text" class="validate[required] form-control" id="user_username" name="user_username" value="<?=$user->username?>" DISABLED>
                </td>
            </tr>
            <tr>
                <td><b>Password</b></td>
                <td align="left">
                    <input type="text" class="validate[custom[onlyLetterNumber]] form-control" id="user_password" name="user_password" value=""  >
                </td>
            </tr>
            <input type="hidden"  class="form-control" id="flag_aktif" name="flag_aktif" value="<?=$user->flag_aktif?>">
            <!--
            <tr>
                <td><b>Aktif</b></td>
                <td align="left">
                    <?php echo form_dropdown('flag_aktif',isset($aktif)?$aktif:array(),$user->flag_aktif,'id="flag_aktif" class="validate[required] form-control" '.$disabled);?>
                </td>
            </tr>
            -->
            <tr>
                <td><b>Nama Lengkap</b></td>
                <td align="left">
                    <input type="text"  class="validate[required] form-control" id="nm_lengkap" name="nm_lengkap" value="<?=$user->nm_lengkap?>">
                </td>
            </tr>
            <tr>
                <td><b>NIP</b></td>
                <td align="left">
                    <input type="text"  class="validate[required] form-control" id="nomor_induk" name="nomor_induk" value="<?=$user->nomor_induk?>">
                </td>
            </tr>
            <tr style="display:none;"">
                <td><b>Nama Bank</b></td>
                <td align="left">
                    <input type="text"  class="validate[required] form-control" id="nama_bank" name="nama_bank" value="<?=$user->nama_bank?>">
                </td>
            </tr>
            <tr style="display:none;"">
                <td><b>No Rekening</b></td>
                <td align="left">
                    <input type="text"  class="form-control" id="no_rek" name="no_rek" value="<?=$user->no_rek?>">
                </td>
            </tr>
            <tr style="display:none;"">
                <td><b>NPWP</b></td>
                <td align="left">
                    <input type="text"  class="form-control" id="npwp" name="npwp" value="<?=$user->npwp?>">
                </td>
            </tr>
            <input type="hidden"  class="form-control" id="alamat" name="alamat" value="<?=$user->alamat?>">
            <!--
            <tr>
                <td><b>Alamat</b></td>
                <td align="left">
                    <input type="text"  class="form-control" id="alamat" name="alamat" value="<?=$user->alamat?>">
                </td>
            </tr>
            -->
        </tbody>
    </table>
</div>

<div class="modal-footer">
    <button type="reset" rel="<?=$user->username?>" name="cancel" id="close_edit" class="btn btn-default cancel btn-sm" aria-label="Center Align" data-dismiss="modal">
        Close
    </button>
    <button type="submit" rel="<?=$user->username?>" class="btn btn-primary submit btn-sm" aria-label="Left Align" >
        Save changes
    </button>
</div>
</form>