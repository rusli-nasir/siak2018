	<?php foreach ($opt_verifikator as $key => $value): ?>
		<option id="" value="<?php echo $value->id ?>" <?php if($value->id == $kd_unit){echo 'selected';} ?> >
			<?php echo $value->username ?>
		</option>
	<?php endforeach ?>