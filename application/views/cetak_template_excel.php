<?php
	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	if(!isset($filename) || is_null($filename)){
		$filename = date('Ymd His')."_daftar_demi_undip.xls";
	}
  header('Content-Disposition: attachment; filename='.$filename);
?>
<html>
	<body>
		<?php echo (isset($main_content))?$main_content:'';?>
	</body>
</html>