

<?php 
	$unit_tmp = '';$rand_color = 'rgba('.rand(0,255).', '.rand(0,255).', '.rand(0,255).', 0.2)';$color_tmp = '#ffff';$rand_color2 = 'rgba('.rand(0,255).', '.rand(0,255).', '.rand(0,255).', 0.2)';

	foreach($result_user as $num_row=>$row):?>
<?php 
$convert_lvl = $this->convertion->get_user_level($row->level);

$bg_color = "";
if ($convert_lvl == "BENDAHARA") {
	$bg_color = "#009688";
} else if ($convert_lvl == "AKUNTANSI"){
	$bg_color = "#E53935";
} else if ($convert_lvl == "PPPK"){
	$bg_color = "#e823f1";
} else if ($convert_lvl == "PUMK"){
	$bg_color = "#337ab7";
} else if ($convert_lvl == "PPK"){
	$bg_color = "#f1c400";
} else if ($convert_lvl == "PPK SUKPA"){
	$bg_color = "#E65100";
} else if ($convert_lvl == "KPA"){
	$bg_color = "#d9534f";
} else if ($convert_lvl == "KUASA BUU"){
	$bg_color = "#8f9078";
} else if ($convert_lvl == "BUU"){
	$bg_color = "#5325e6";
} else if ($convert_lvl == "VERIFIKATOR"){
	$bg_color = "#795548";
}else{
	$bg_color = "#67ff65";
}


if ($row->nama_subunit != $unit_tmp) {
	if ($color_tmp == $rand_color) {
		$color_tmp= $rand_color2;
	}else{
		$color_tmp = $rand_color;
	}
}else{
	$color_tmp = $color_tmp;
}
?>


	<?php if ($row->nama_subunit != $unit_tmp): ?>
	<tr>
		<td colspan="7" style="background-color: #e6edef96;text-align: center;"><b><?php echo $row->nama_subunit ?></b></td>
	</tr>
	<?php endif ?>

	
<?php if($row->level != '11'): ?>
<tr id="<?=$row->username?>" height="25px" style="background-color: #ffff;">
	
		<td class="text-danger" style="color: #000;border-bottom: 1px solid #ddd;">
			<b><?=$row->nama_subunit?></b>
		</td>
	<td><span class="label" style="background-color: <?php echo $bg_color ?>;font-size: small;"><?=$convert_lvl?></span><b></td>
	<td><span><b><?=$row->username?></b></span></td>
	<td align="center" >
	<a href="javascript:void(0)" class="btn btn-sm btn-warning edit" data-unit="<?=$row->kode_unit_subunit?>" rel="<?=$row->username?>" name="edit">
		<i class="fa fa-pencil" aria-hidden="true"></i> Edit
	</a>
	</td>
	<td align="center" >
	<a href="javascript:void(0)" rel="<?=$row->username?>" class="btn btn-sm btn-danger delete">
	</i> Delete
	</a>
	</td>
	</tr>
<?php else: ?>
	<tr id="<?=$row->username?>" height="25px" style="background-color: #f9e3b6;">
		<td class="text-danger" style="border-left: 1px solid #ddd;"><b><?=$row->nama_subunit?></b></td>
		<td><span class="label" style="background-color: <?php echo $bg_color ?>;font-size: small;"><?=$convert_lvl?></span><b></td>
		<td><span><b><?=$row->username?></b></span></td>
		<!-- <td style="vertical-align:middle">terenkripsi</td> -->
		<!-- <td align="center" style="vertical-align:middle"><?=$row->flag_aktif?></td> -->
		<td align="center" style="vertical-align:middle"><button type="button" class="btn btn-sm btn-warning" disabled="disabled"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></td>
		<td align="center" style="vertical-align:middle;border-right: 1px solid #ddd;"><button type="button" class="btn btn-sm btn-danger" disabled="disabled"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button></td>
<?php endif; ?>
<?php $unit_tmp = $row->nama_subunit;endforeach;?>