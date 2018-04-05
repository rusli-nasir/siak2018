<?php foreach ($akun_subakun as $key_subunit => $value_subunit): ?>
    <?php foreach ($value_subunit['data'] as $key_sub_subunit => $value_sub_subunit): ?>
        <?php foreach ($value_sub_subunit['data'] as $key4digit => $value4digit): ?>
           <?php foreach ($value4digit['data'] as $key5digit => $value5digit): ?>
                <?php foreach ($value5digit['data'] as $key6digit => $value6digit): ?>
                    <?php if ($key6digit == $kode): ?>
                        <?php if (!empty($value6digit['data'])): ?>
                            <?php foreach ($value6digit['data'] as $keydetail => $valdetail): ?>
                            <tr  id="<?php echo $valdetail['id_rsa_detail'] ;?>">
                                <td class="text-center">
                                    <?php
                                    if(substr($valdetail['proses'],1,1)=='1'){echo '<span class="badge badge-gup">GP</span>';}
                                    elseif(substr($valdetail['proses'],1,1)=='3'){echo '<span class="badge badge-tup">TP</span>';}
                                    elseif(substr($valdetail['proses'],1,1)=='2'){echo '<span class="badge badge-lp">LP</span>';}
                                    elseif(substr($valdetail['proses'],1,1)=='4'){echo '<span class="badge badge-l3">LK</span>';}
                                    elseif(substr($valdetail['proses'],1,1)=='5'){echo '<span class="badge badge-ks">KS</span>';}
                                    elseif(substr($valdetail['proses'],1,1)=='6'){echo '<span class="badge badge-ln">LN</span>';}
                                    elseif(substr($valdetail['proses'],1,1)=='7'){echo '<span class="badge badge-em">EM</span>';}
                                    else{}
                                    ?>
                                    <?php echo $keydetail ?>
                                    <input type="hidden" id="proses_<?php echo $valdetail['id_rsa_detail'];?>" value="3<?=substr($valdetail['proses'],1,1)?>" />
                                </td>
                                <td>
                                    <?php echo $valdetail['rincian'] ?>
                                    <?php if (!empty($valdetail['ket'])): ?>
                                        <span class="glyphicon glyphicon-question-sign" style="cursor:pointer" onclick="open_tolak('<?php echo $valdetail['ket'] ?>')" aria-hidden="true"></span>
                                    <?php endif ?>
                                </td>
                                <td class="text-center"><?php echo $valdetail['volume'] + 0 ?></td>
                                <td class="text-center"><?php echo $valdetail['satuan'] ?></td>
                                <td class="text-right"><?php echo number_format($valdetail['harga_satuan'],0,',','.') ?></td>
                                <td class="text-right"><?php echo number_format($valdetail['jumlah_harga'],0,',','.') ?></td>
                                <?php if($valdetail['proses'] == 0) : ?>
                                    <td align="center">
                                        <div class="btn-group">
                                            <button type="button" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="text-edit glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" disabled="disabled" class="btn btn-success btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
                                    </td>
                                <?php elseif(substr($valdetail['proses'],0,1) == 1): ?>
                                    <td align="center">
                                        <div class="btn-group">
                                            <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit">
                                                <span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                            <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align">
                                                <span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> PPK </button>
                                    </td>
                                <?php elseif(substr($valdetail['proses'],0,1) == 2): ?>
                                    <td align="center">
                                        <div class="btn-group">
                                            <button type="button" rel="<?php echo $valdetail['id_rsa_detail'];?>" class="btn btn-default btn-sm" onclick="doedit('<?php echo $valdetail['id_rsa_detail'] ;?>','<?php echo $value6digit['kode_usulan_belanja'] ;?>',this)" aria-label="Left Align"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>
                                        </div>
                                    </td>
                                    <td >
                                        <div class="btn-group">
                                            <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $valdetail['id_rsa_detail'];?>" class="btn btn-success btn-sm" onclick="do_yes('<?php echo $valdetail['id_rsa_detail'] ;?>','<?php echo $value6digit['kode_usulan_belanja'] ;?>',this)" aria-label="Left Align">Yes</button>
                                            <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $valdetail['id_rsa_detail'];?>" class="btn btn-danger btn-sm" onclick="do_no('<?php echo $valdetail['id_rsa_detail'] ;?>','<?php echo $value6digit['kode_usulan_belanja'] ;?>',this)" aria-label="Center Align">No</button>
                                        </div>
                                    </td>
                                <?php elseif(substr($valdetail['proses'],0,1) == 3): ?>
                                    <td align="center">
                                        <div class="btn-group">
                                            <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                            <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" disabled="disabled" class="btn btn-warning btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="text-success glyphicon glyphicon-ok" aria-hidden="true"></span> Siap </button>
                                    </td>
                                <?php elseif(substr($valdetail['proses'],0,1) == 4): ?>
                                    <td align="center">
                                        <div class="btn-group">
                                            <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                            <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> SPP </button>
                                    </td>
                                <?php elseif(substr($valdetail['proses'],0,1) == 5): ?>
                                    <td align="center">
                                        <div class="btn-group">
                                            <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                            <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> SPM </button>
                                    </td>
                                <?php elseif(substr($valdetail['proses'],0,1) == 6): ?>
                                    <td align="center">
                                        <div class="btn-group">
                                            <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                            <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Cair </button>
                                    </td>
                                <?php else: ?>
                                    <td align="center">
                                        <div class="btn-group">
                                           <button type="button" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>
                                        </div>
                                    </td>
                                    <td>
                                         <button type="button" disabled="disabled" class="btn btn-warning btn-sm" rel="" id="proses_<?php echo $valdetail['id_rsa_detail'];?>" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr id="tr_kosong" height="25px" class="alert text-center" >
                                <td colspan="8">- kosong -</td>
                            </tr>
                        <?php endif; ?>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endforeach ?>
        <?php endforeach ?>
    <?php endforeach ?>
<?php endforeach ?>