<?php $total_ = 0 ;?>
<?php $temp_text_unit = '' ;?>
<?php $temp_text_akun = '' ;?>
<?php $i_row = 0 ; ?>
<?php $total_per_akun = 0 ;?>
<?php $impor = 0 ; ?>
<?php foreach($detail_akun_rba as $u){ ?>
    <?php if($temp_text_unit != $u->nama_subunit.$u->nama_sub_subunit): ?>
    <tr >
        <td colspan="8">&nbsp;</td>
    </tr>
    <tr id="" class="alert alert-info" height="25px">
        <td colspan="8"><b><?='<span class="text-warning">'.$u->nama_subunit.'</span> : <span class="text-success">'.$u->nama_sub_subunit.'</span>'?></b></td>
    </tr>
        <?php $temp_text_unit = $u->nama_subunit.$u->nama_sub_subunit; ?>
        <?php $temp_text_akun = '' ;?>
    <?php endif; ?>
    <?php if($temp_text_akun != $u->kode_akun): ?>
    <tr id="<?php echo $u->kode_usulan_belanja ;?>" height="25px" class="text-danger">
        <td colspan="8"><b><?=$u->kode_akun.' : '.$u->nama_akun?></b></td>
    </tr>
        <?php $temp_text_akun = $u->kode_akun; ?>
        <?php $total_per_akun = 0 ;?>
    <?php else: ?>
        <!--<td colspan="8">&nbsp;</td>-->
    <?php endif; ?>

    <?php foreach($detail_rsa as $ul){ ?>
        <?php $impor = $ul->impor; ?>
        <?php if($ul->kode_usulan_belanja == $u->kode_usulan_belanja): ?>
            <tr id="<?php echo $ul->id_rsa_detail ;?>" height="25px">
                <td style="text-align: right">
                    <?php if(substr($ul->proses,1,1)=='1'){echo '<span class="badge badge-gup">GP</span>';}elseif(substr($ul->proses,1,1)=='2'){echo '<span class="badge badge-ls">LS</span>';}elseif(substr($ul->proses,1,1)=='3'){echo '<span class="badge badge-tup">TP</span>';}elseif(substr($ul->proses,1,1)=='4'){echo '<span class="badge badge-ks">KS</span>';}else{} ?> <?=$ul->kode_akun_tambah?>
                </td>
                <td ><?=$ul->deskripsi?></td>
                <td ><?=$ul->volume + 0?></td>
                <td ><?=$ul->satuan?></td>
                <td style="text-align: right"><?=number_format($ul->harga_satuan, 0, ",", ".")?></td>
                <td style="text-align: right">
                    <?php $total_ = $total_ + ($ul->volume*$ul->harga_satuan); ?>
                    <?php $total_per_akun = $total_per_akun + ($ul->volume*$ul->harga_satuan); ?>
                    <?=number_format($ul->volume*$ul->harga_satuan, 0, ",", ".")?>
                </td>


                                                <?php if($ul->proses == 0) : ?>

                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-default btn-sm" onclick="doedit('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this)" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-default btn-sm" id="delete_<?=$ul->id_rsa_detail?>" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm" rel="<?php echo $ul->id_rsa_detail ;?>" id="proses_<?php echo $ul->id_rsa_detail ;?>" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
                                                </td>
                                                <?php elseif(substr($ul->proses,0,1) == 1): ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> PPK </button>
                                                </td>
                                                <?php elseif(substr($ul->proses,0,1) == 2): ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Ver </button>
                                                </td>
                                                <?php elseif(substr($ul->proses,0,1) == 3): ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-warning btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Siap </button>
                                                </td>
                                               <?php elseif(substr($ul->proses,0,1) == 4): ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> SPP </button>
                                                </td>
                                              <?php elseif(substr($ul->proses,0,1) == 5): ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> SPM </button>
                                                </td>
                                              <?php elseif(substr($ul->proses,0,1) == 6): ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Cair </button>
                                                </td>
                                                <?php else: ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Proses </button>
                                                </td>
                                                <?php endif; ?>
            </tr>

        <?php endif; ?>
    <?php } ?>
    <tr id="form_add_detail_<?=$u->kode_usulan_belanja?>" class="alert alert-success">
            <td >
                <input name="revisi" id="revisi_<?=$u->kode_usulan_belanja?>" type="hidden" value="<?=$u->revisi?>" />
                <input name="impor" id="impor_<?=$u->kode_usulan_belanja?>" type="hidden" value="<?=$impor?>" />
                <input name="kode_akun_tambah" class="form-control" rel="<?=$u->kode_usulan_belanja?>" id="kode_akun_tambah_<?=$u->kode_usulan_belanja?>" type="text" value="" readonly="readonly" />
            </td>
            <td >
                <textarea name="deskripsi" class="validate[required] form-control" rel="<?=$u->kode_usulan_belanja?>" id="deskripsi_<?=$u->kode_usulan_belanja?>" rows="1"></textarea>
            </td>
            <td ><input name="volume" class="validate[required,funcCall[checkfloat]] calculate form-control xfloat" rel="<?=$u->kode_usulan_belanja?>" id="volume_<?=$u->kode_usulan_belanja?>" type="text" value="" data-toggle="tooltip" data-placement="top" title="Silahkan masukan angka bulat atau pecahan. Kalo masih error silahkan kontak sy. thx" /></td>
            <td ><input name="satuan" class="validate[required,maxSize[30]] form-control" rel="<?=$u->kode_usulan_belanja?>" id="satuan_<?=$u->kode_usulan_belanja?>" type="text" value="" /></td>
            <td ><input name="tarif" class="validate[required,custom[integer],min[1]] calculate form-control xnumber" rel="<?=$u->kode_usulan_belanja?>" id="tarif_<?=$u->kode_usulan_belanja?>" type="text" value="" /></td>
            <td ><input name="jumlah" rel="<?=$u->kode_usulan_belanja?>" id="jumlah_<?=$u->kode_usulan_belanja?>" type="text" class="form-control" readonly="readonly" value="" /></td>
            <td align="center" >
                    <div class="btn-group">
                                    <button type="button" style="padding-left:5px;padding-right:5px;" class="btn btn-default btn-sm" rel="<?=$u->kode_usulan_belanja?>" id="tambah_<?=$u->kode_usulan_belanja?>" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                                    <button type="button" style="padding-left:5px;padding-right:5px;" class="btn btn-default btn-sm" rel="<?=$u->kode_usulan_belanja?>" id="reset_<?=$u->kode_usulan_belanja?>" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>


                            </div>
            </td>
            <td>&nbsp;</td>
    </tr>       
    <tr class="alert alert-danger">
        <td colspan="4" style="text-align: right;">Usulan</td> 
        <td style="text-align: right;">:</td>
        <td style="text-align: right;" rel="<?=$u->kode_usulan_belanja?>" id="td_usulan_<?=$u->kode_usulan_belanja?>"><?=number_format($u->total_harga, 0, ",", ".")?></td>
        <td >&nbsp;</td> 
        <td >&nbsp;</td> 
    </tr>
    <tr class="alert alert-info">
            <td colspan="4" style="text-align: right;">Total</td> 
            <td style="text-align: right;">:</td>
            <td style="text-align: right;" id="td_kumulatif_<?=$u->kode_usulan_belanja?>"><?=number_format($total_per_akun, 0, ",", ".")?></td>
            <td >&nbsp;</td>
            <td >&nbsp;</td> 
    </tr>
    <tr  class="alert alert-warning">
            <td colspan="4" style="text-align: right;">Sisa</td> 
            <td style="text-align: right;">:</td>
            <td style="text-align: right;" id="td_kumulatif_sisa_<?=$u->kode_usulan_belanja?>"><?=number_format(($u->total_harga - $total_per_akun), 0, ",", ".")?></td>
            <td >&nbsp;</td>
            <td >&nbsp;</td> 
    </tr>

    <?php $i_row++; ?>



<?php } ?>
    <tr id="" height="25px">
        <td colspan="8">&nbsp;</td>
    </tr>
    <tr id="" height="25px" class="alert alert-danger" style="font-weight: bold">
        <td colspan="4" style="text-align: center">Total </td>
        <td style="text-align: right">:</td>
        <td style="text-align: right"><?=number_format($total_, 0, ",", ".")?></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td> 
    </tr>