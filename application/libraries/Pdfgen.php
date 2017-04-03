<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once './vendor/dompdf/dompdf/autoload.inc.php';

//require_once './vendor/spipu/html2pdf/html2pdf.class.php';
require_once './vendor/autoload.php';

//use Spipu\Html2Pdf\Html2Pdf;

class Pdfgen {

    private $html2pdf ;

  public function __construct(){
//    define('DOMPDF_ENABLE_AUTOLOAD', false);
//        require_once('html2pdf-4.4.0/html2pdf.class.php');
//        $width_in_mm = $width_in_inches * 25.4;
//        $height_in_mm = $height_in_inches * 25.4; array('215','330')
        $this->html2pdf = new HTML2PDF('P', array('215','330') , 'en');

  }

  public function cetak($html,$nama_file){
      //      $html2pdf->setModeDebug();
        $this->html2pdf->setDefaultFont('Arial');
//        $this->html2pdf->pdf->SetDisplayMode('fullpage');
        $this->html2pdf->writeHTML($html);
        $this->html2pdf->Output($nama_file.'.pdf');
  }
}
