<table class="table table-striped">
	<thead>
	<tr >
		<th class="col-md-3" >Tujuan</th>
                <th class="col-md-3" >Sasaran</th>
		<th class="col-md-3" >Program</th>
                <th class="col-md-2" >Jumlah</th>
		<th class="col-md-2" colspan="2" style="text-align:center">Aksi</th>
	</tr>
        </thead>
        <tbody id="row_space">
<?php $temp_text_kegiatan = ''; ?>
<?php $temp_text_output = ''; ?>
<?php $total_g = 0 ; ?>
<?php if(!empty($tor_kegiatan_usul)): ?>
<?php foreach($tor_kegiatan_usul as $num_row => $row){ ?>
<tr id="<?=$row->kode_usulan_belanja?>" height="25px">
        <?php if($temp_text_kegiatan != $row->nama_kegiatan): ?>
            <td ><?=$row->nama_kegiatan?></td>
            <?php $temp_text_kegiatan = $row->nama_kegiatan; ?>
        <?php else: ?>
            <td >&nbsp;</td>
        <?php endif; ?>
        <?php if($temp_text_output != $row->nama_output): ?>
            <td ><?=$row->nama_output?></td>
            <?php $temp_text_output = $row->nama_output; ?>
        <?php else: ?>
            <td >&nbsp;</td>
        <?php endif; ?>
	<td ><?=$row->nama_program?></a></td>
        <td style="text-align: right">Rp.<?=number_format($row->jumlah_tot, 0, ",", ".")?><?php $total_g = $total_g + $row->jumlah_tot; ?></td>
	<td align="center"><a type="button" class="btn btn-warning" href="<?=site_url("tor/input_tor/".$row->k_unit.$row->kode_kegiatan.$row->kode_output.$row->kode_program)?>" class="edit" rel="<?=$row->k_unit.$row->kode_kegiatan.$row->kode_output.$row->kode_program?>" name="edit">Expor</a></td>
</tr>
<?php };?>
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
                <td colspan="6"> - kosong -</td>
</tr>
<?php endif; ?>

</tbody>
	
        <tfoot>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
        </tfoot>
</table>