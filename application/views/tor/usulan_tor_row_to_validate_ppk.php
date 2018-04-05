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

    <?php foreach($detail_rsa_to_validate as $ul){ ?>
        <?php $impor = $ul->impor; ?>
        <?php if($ul->kode_usulan_belanja == $u->kode_usulan_belanja): ?>
            <tr id="<?php echo $ul->id_rsa_detail ;?>" height="25px">
                <td style="text-align: right">
                    <?php // if(substr($ul->proses,1,1)=='1'){echo '<span class="badge badge-gup">GP</span>';}elseif(substr($ul->proses,1,1)=='3'){echo '<span class="badge badge-tup">TP</span>';}elseif(substr($ul->proses,1,1)=='2'){echo '<span class="badge badge-lp">LP</span>';}elseif(substr($ul->proses,1,1)=='4'){echo '<span class="badge badge-l3">L3</span>';}elseif(substr($ul->proses,1,1)=='4'){echo '<span class="badge badge-ks">KS</span>';}elseif(substr($ul->proses,1,1)=='6'){echo '<span class="badge badge-l3nk">L3NK</span>';}else{} ?>

                    <?php if(substr($ul->proses,1,1)=='1'){echo '<span class="badge badge-gup">GP</span>';}elseif(substr($ul->proses,1,1)=='3'){echo '<span class="badge badge-tup">TP</span>';}elseif(substr($ul->proses,1,1)=='2'){echo '<span class="badge badge-lp">LP</span>';}elseif(substr($ul->proses,1,1)=='4'){echo '<span class="badge badge-l3">LK</span>';}elseif(substr($ul->proses,1,1)=='5'){echo '<span class="badge badge-ks">KS</span>';}elseif(substr($ul->proses,1,1)=='6'){echo '<span class="badge badge-ln">LN</span>';}elseif(substr($ul->proses,1,1)=='7'){echo '<span class="badge badge-em">EM</span>';}else{} ?> <?=$ul->kode_akun_tambah?>

                    <input type="hidden" id="proses_<?php echo $ul->id_rsa_detail;?>" value="2<?=substr($ul->proses,1,1)?>" />
                </td>
                <td ><?=$ul->deskripsi?></td>
                <td ><?=$ul->volume + 0?></td>
                <td ><?=$ul->satuan?></td>
                <td style="text-align: right"><?=number_format($ul->harga_satuan, 0, ",", ".")?></td>
                <td style="text-align: right">
                    <?php $total_ = $total_ + ($ul->volume*$ul->harga_satuan); ?>
                    <?php $total_per_akun = $total_per_akun + ($ul->volume*$ul->harga_satuan); ?>
                    <?=number_format($ul->volume*$ul->harga_satuan, 0, ",", ".")?>
                    <?php
													
													if(substr($ul->proses,1,1)=='4'){
                                                        // echo "<br><br>";
														// if(isset($detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar) && $detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar != 0){
														// 	echo "<br /><a title=\"Kontrak Terbayar untuk Akun ini.\">KT: ".$this->cantik_model->number($detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar)."<br/>termin :".$detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->termin."</a>";
														// }
													}
													?></td>

                                                <?php if($ul->proses == 0) : ?>

                                                    <td align="center">
                                                        <div class="btn-group">
                                                            <button type="button" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>
                                                        </div>
                                                    </td>
                                                    <td >
                                                        <button type="button" disabled="disabled" class="btn btn-success btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
                                                    </td>

                                                <?php elseif(substr($ul->proses,0,1) == 1): ?>

                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-default btn-sm" onclick="doedit('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this)" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>
                                                        <!--<button type="button" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-default btn-sm" id="delete_<?=$ul->id_rsa_detail?>" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>-->
                                                    </div>
                                                </td>
                                                <td >
                                                    
                            <?php
                                if(substr($ul->proses,1,1)=='4'){

                                    $nilaikontrak = 0;

                                    $kx = $ul->kode_usulan_belanja.$ul->kode_akun_tambah ;

                                    // if(isset($detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar) && $detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar != 0){

                                    //  $nilaikontrak=$detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar;

                                    // }

                                    if(!empty($detail_rsa_kontrak[$kx])){

                                        $nilaikontrak = $detail_rsa_kontrak[$kx]['kontrak_terbayar'] ;

                                    }

                                    // $nilaikontrak = $nilaikontrak + 1 ;

                                    $nilai_dpa = $ul->volume*$ul->harga_satuan;

                                    // echo $nilaikontrak . '   ' . $nilai_dpa ;

                                    if($nilaikontrak != $nilai_dpa){ // NILAI DPA TIDAK SAMA DENGAN KONTRAK

                                        // if(strpos(strtolower($ul->deskripsi),'listrik')!==false || strpos(strtolower($ul->deskripsi),'bpjs')!==false){ 

                                        /// KONDISI INI TIDAK TERPAKAI KARENA BELUM MUDENG - IDRIS ///

                                         // } 

                                    ?>

                                        <button type="button" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-danger btn-sm" onclick="do_cek_salah('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this,'<?php echo $ul->kode_akun_tambah ;?>')" aria-label="Center Align"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Cek</button>


                                <?php }else{ // NILAI DPA SAMA DENGAN NILAI KONTRAK ?>


                                    <button type="button" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-danger btn-sm" onclick="do_cek_ok('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this,'<?php echo $ul->kode_akun_tambah ;?>')" aria-label="Center Align"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Cek</button>
                                    
                                <?php } ?>

                            <?php }else{ ?>

                                <div class="btn-group">

                                <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-success btn-sm" onclick="do_yes('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this)" aria-label="Left Align">Yes</button>
                                <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-danger btn-sm" onclick="do_no('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this)" aria-label="Center Align">No</button>

                                </div>
                            
                            <?php } ?>
                                                    
                                                </td>
                                                <?php elseif(substr($ul->proses,0,1) == 2): ?>
                                                <td align="center">
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
                                                        <div class="btn-group">
                                                            <button type="button" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>
                                                        </div>
                                                    </td>
                                                    <td >
                                                        <button type="button" disabled="disabled" class="btn btn-warning btn-sm" rel="" id="proses_<?php echo $ul->id_rsa_detail ;?>" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
                                                    </td>

                                                <?php endif; ?>
            </tr>

        <?php endif; ?>
    <?php } ?>

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
