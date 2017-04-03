<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

ini_set("memory_limit","320M");



function pdf_create($html, $filename, $paper='a4', $orentation='potrait', $stream=TRUE) 
{
	require_once(BASEPATH."plugins/dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	$dompdf->set_paper($paper, $orentation); 
	$dompdf->load_html($html);
	$dompdf->render();
	$dompdf->stream($filename.".pdf");
}
?>