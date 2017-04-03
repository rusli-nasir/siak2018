<?php $temp_text_program = ''; ?>
<?php $temp_text_komponen = ''; ?>
<?php $total_g = 0 ; ?>
<?php if(!empty($rsa_usul)): ?>
<?php foreach($rsa_usul as $i => $u){ ?>
    <tr rel="<?=$u->k_unit.$u->kode_rka?>" class="tr-unit" height="25px">
        <?php if($temp_text_program != $u->nama_program): ?>
            <td class=""><b><?=$u->nama_program?></b></td>
            <?php $temp_text_program = $u->nama_program; ?>
        <?php else: ?>
            <td class="">&nbsp;</td>
        <?php endif; ?>
        <?php if($temp_text_komponen != $u->nama_komponen): ?>
            <td class=""><b><?=$u->nama_komponen?></b></td>
            <?php $temp_text_komponen = $u->nama_komponen; ?>
        <?php else: ?>
            <td class="">&nbsp;</td>
        <?php endif; ?>
        <td class=""><?=$u->nama_subkomponen?></td>
        <td class="" style="text-align: right"><?=number_format($u->jumlah_tot, 0, ",", ".")?><?php $total_g = $total_g + $u->jumlah_tot; ?></td>
        <!--<td style="text-align: right" class="rkat">&nbsp;</td>-->
        <!--<td style="text-align: right" class="rsa">&nbsp;</td>-->
        <td align="center">
            <buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$u->k_unit.$u->kode_rka?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Buat Tor</buttton>
        </td>
    </tr>

<?php } ?>
    <tr >
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr id="" height="25px" class="alert alert-danger" style="font-weight: bold">
        <td colspan="3" style="text-align: center">Total </td>
        <td style="text-align: right">: Rp.<?=number_format($total_g, 0, ",", ".")?></td>
        <td>&nbsp;</td>
    </tr>
<?php else: ?>
<tr id="tr-empty">
                <td colspan="5"> - kosong / belum disetujui -</td>
</tr>
<?php endif; ?>