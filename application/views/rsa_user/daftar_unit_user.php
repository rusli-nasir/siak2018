	<?php foreach ($opt_subunit as $key => $value): ?>
		<?php  
		if ($value['id_unit'] == '14' || $value['id_unit'] == '15' || $value['id_unit'] == '16' || $value['id_unit'] == '17' ){ ?>
		<option id="" style="background-color:#95d2ef85"  value="<?php echo $value['id'] ?>" <?php if($key == $kd_unit){echo 'selected';} ?> disabled>
			<?php echo $value['nama'] ?>
		</option>
		<?php				
			}else{
		?>
		<option id="" value="<?php echo $value['id'] ?>" <?php if($key == $kd_unit){echo 'selected';} ?> >
			<?php echo $value['nama'] ?>
		</option>
	<?php } ?>
	<?php endforeach ?>