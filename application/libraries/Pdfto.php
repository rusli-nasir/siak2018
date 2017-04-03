<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdfto {


  public function __construct(){
//    define('DOMPDF_ENABLE_AUTOLOAD', false);

  }

  public function generate($html,$filename)
  {
    require 'vendor/autoload.php';
//    use Dompdf\Dompdf;

    $dompdf = new Dompdf\Dompdf(); // previously used new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream($filename.'.pdf',array("Attachment"=>0));
  }
}
