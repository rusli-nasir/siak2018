<?php
	include "inc/error_inc.php";

	if(isset($_GET['page']) && strlen(trim($_GET['page']))>0){
		if(file_exists($_CONFIG['folder'].$_GET['page']."/index.php")){
			unset($default);
			require_once $_CONFIG['folder'].$_GET['page']."/index.php";
		}else{
			include $_CONFIG['folder']."404.php";
		}
	}else{

	}
?>
