<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ol class="breadcrumb">
<?php
	if(is_array($list)){
		foreach($list as $value){
			echo "<li ".(isset($value[1])?' '.$value[1]:'').">".(isset($value[0])?$value[0]:'')."</li>";
		}
	}
?>
</ol>