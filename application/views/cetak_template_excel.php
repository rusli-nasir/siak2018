<?php
	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
  header('Content-Disposition: attachment; filename='.date('Ymd His').'_daftar_demi_undip.xls');
?>
<html>
	<body>
		<?php echo (isset($main_content))?$main_content:'';?>
	</body>
</html>