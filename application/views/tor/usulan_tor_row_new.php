<?php foreach ($akun_subakun as $key_subunit => $value_subunit): ?>
    <?php foreach ($value_subunit['data'] as $key_sub_subunit => $value_sub_subunit): ?>
        <?php foreach ($value_sub_subunit['data'] as $key4digit => $value4digit): ?>
           <?php foreach ($value4digit['data'] as $key5digit => $value5digit): ?>
              <?php foreach ($value5digit['data'] as $key6digit => $value6digit): ?>
                 <?php if ($key6digit == $kode): ?>
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
                                        <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $valdetail['id_rsa_detail'];?>" class="btn btn-default btn-sm" onclick="doedit('<?php echo $valdetail['id_rsa_detail'] ;?>','<?php echo $value6digit['kode_usulan_belanja'] ;?>',this)" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                        <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $valdetail['id_rsa_detail'];?>" class="btn btn-default btn-sm" id="delete_<?=$valdetail['id_rsa_detail']?>" data-kode-usulan="<?php echo $value6digit['kode_usulan_belanja'];?>" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                    </div>
                                </td>
                                <td>
                                   <button type="button" class="btn btn-success btn-sm" rel="<?php echo $valdetail['id_rsa_detail'] ;?>" id="proses_<?php echo $valdetail['id_rsa_detail'] ;?>" aria-label="Center Align" data-kode-usulan="<?php echo $value6digit['kode_usulan_belanja'] ?>"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
                                </td>
                            <?php elseif(substr($valdetail['proses'],0,1) == 1): ?>
                                <td align="center">
                                    <div class="btn-group">
                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> PPK </button>
                                </td>
                            <?php elseif(substr($valdetail['proses'],0,1) == 2): ?>
                                <td align="center">
                                    <div class="btn-group">
                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Ver </button>
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
                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Proses </button>
                                </td>
                            <?php endif; ?>
                        </tr>
            
                    <?php endforeach ?>
                    <tr id="form_add_detail_<?php echo $value6digit['kode_usulan_belanja'] ?>" class="">
                        <td >
                            <input name="revisi" id="revisi_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="hidden" value="<?=$revisi?>" />
                            <input name="impor" id="impor_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="hidden" value="<?=$impor?>" />
                            <input name="kode_akun_tambah" class="form-control" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="kode_akun_tambah_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="hidden" value="" readonly="readonly" />
                        </td>
                        <td >
                            <textarea name="deskripsi" class="validate[required] form-control" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="deskripsi_<?php echo $value6digit['kode_usulan_belanja'] ?>" rows="1"></textarea>
                        </td>
                        <td ><input name="volume" class="validate[required,funcCall[checkfloat]] calculate form-control xfloat" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="volume_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="text" value="" data-toggle="tooltip" data-placement="top" title="Silahkan masukan angka bulat atau pecahan." /></td>
                        <td ><input name="satuan" class="validate[required,maxSize[30]] form-control" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="satuan_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="text" value="" /></td>
                        <td ><input name="tarif" class="validate[required,custom[integer],min[1]] calculate form-control xnumber" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="tarif_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="text" value="" /></td>
                        <td ><input name="jumlah" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="jumlah_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="text" class="form-control" readonly="readonly" value="" /></td>
                        <td align="center" colspan="2">
                            <div class="btn-group">
                                <button style="padding-left:5px;padding-right:5px;margin-right: 5px;" type="button" class="btn btn-default btn-sm" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="tambah_<?php echo $value6digit['kode_usulan_belanja'] ?>" aria-label="Left Align" title="tambah"><span class="text-success text-success glyphicon glyphicon-ok" aria-hidden="true"></span> Tambah</button>
                                <button style="padding-left:5px;padding-right:5px;" type="button" class="btn btn-default btn-sm" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="reset_<?php echo $value6digit['kode_usulan_belanja'] ?>" aria-label="Center Align" title="reset"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span> Reset</button>
                            </div>
                        </td>
                        <!-- <td>&nbsp;</td> -->
                    </tr>
                    <tr id="tr_kosong" height="25px" style="display: none" class="alert alert-warning" >
                        <td colspan="8">- kosong / belum disetujui -</td>
                    </tr>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endforeach ?>
        <?php endforeach ?>
    <?php endforeach ?>
<?php endforeach ?>