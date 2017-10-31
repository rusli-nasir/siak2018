<?php if ($jenis == 'list'): ?>
	<form method="post" action="<?php echo site_url('akuntansi/fixer/fix_double'); ?>">
		<input type="submit" name="del_double" value="HAPUS !!">
	</form>	
<?php else: ?>
	<a href="<?php echo site_url('akuntansi/fixer/fix_double'); ?>" >Reload</a>
<?php endif ?>
