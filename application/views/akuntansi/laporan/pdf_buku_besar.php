<?php
$this->load->library('Kepdf');
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, 0, PDF_MARGIN_RIGHT);
$pdf->SetPrintHeader(false);
$pdf->SetHeaderMargin(false);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);
$pdf->SetMargins(10, 10, 0, true); // set the margins 

// add a page
$pdf->AddPage('L');

$html_head = 
	'<body style="font-family:arial;">
		<div align="center" style="font-weight:bold">
			'.$teks_unit.'<br/>
			BUKU BESAR<br/>
			'.$periode_text.'
		</div><br/><br/>';
$pdf->writeHTML($html_head, true, false, true, false, '');

$html = '';
		$baris = 4;
		$item = 1;
		$total_data = 4;//count($query); 
		$break = 'on';
		foreach ($query as $key=>$entry){
			$html.= '<table style="font-size:10pt;">
					<tr>
						<td width="140px" style="font-weight:bold;">Unit Kerja</td>
						<td>'.$teks_unit.'</td>
					</tr>
					<tr>
						<td style="font-weight:bold;">Tahun Anggaran</td>
						<td>'.$teks_tahun_anggaran.'</td>
					</tr>
					<tr>
						<td style="font-weight:bold;">Kode Akun</td>
						<td>'.$key.'</td>
					</tr>
					<tr>
						<td style="font-weight:bold;">Nama Akun</td>
						<td>'.get_nama_akun_v((string)$key).'</td>
					</tr>
				</table>';
			$baris += 4;
			$case_hutang = in_array(substr($key,0,1),[2,3]);

			$saldo = $this->Akun_model->get_saldo_awal($key);
			if ($saldo != null) {
				$saldo = $saldo['saldo_awal'];
			}
			// print_r($entry);die();
	    	$jumlah_debet = 0;
	    	$jumlah_kredit = 0;

	    	$html.= '<table border="1" style="font-size:10pt;width:840px;border:1px solid #bdbdbd;margin-bottom:20px;" class="border">
	    			<thead>
	    				<tr style="background-color:#ECF379">
	    					<th width="40px">No</th>
	    					<th>Tanggal</th>
	    					<th>No. Bukti</th>
	    					<th>Uraian</th>
	    					<th>Ref</th>
	    					<th>Debet<br/>(Rp)</th>
	    					<th>Kredit<br/>(Rp)</th>
	    					<th>Saldo<br/>(Rp)</th>
	    				</tr>
	    			</thead>
	    			<tbody>';
	    			/*$html.= '<tr>
    					<td>1</td>
    					<td>1 Januari 2017</td>
    					<td></td>
    					<td>Saldo Awal</td>
    					<td></td>
    					<td></td>
    					<td></td>
    					<td align="right">'.number_format($saldo).'</td>
    				</tr>';
    				$baris += 2;*/
    		$iter = 0;
	    	foreach ($entry as $transaksi) {	
	    		$iter++;
				$html.= '<tr>
					<td width="40px">'.$iter.'</td>
					<td>'.$transaksi['tanggal'].'</td>
					<td>'.$transaksi['no_bukti'].'</td>
					<td>'.$transaksi['uraian'].'</td>
					<td>'.$transaksi['kode_user'].'</td>';
					if ($transaksi['tipe'] == 'debet'){
	    				$html.= '<td align="right">'.eliminasi_negatif($transaksi['jumlah']).'</td>';
	    				$html.= '<td align="right">0</td>';
	    				if ($case_hutang) {
	                        $saldo -= $transaksi['jumlah'];
	                    } else {
	    				    $saldo += $transaksi['jumlah'];
	                    }
	    				$jumlah_debet += $transaksi['jumlah'];
	    			} else if ($transaksi['tipe'] == 'kredit'){
	    				$html.= '<td align="right">0</td>';
						$html.= '<td align="right">'.eliminasi_negatif($transaksi['jumlah']).'</td>';
						if ($case_hutang) {
	                        $saldo += $transaksi['jumlah'];
	                    } else {
	                        $saldo -= $transaksi['jumlah'];
	                    }
						$jumlah_kredit += $transaksi['jumlah'];
	    			}
				$html.= '<td align="right">'.eliminasi_negatif($saldo).'</td>
				</tr>';
				$baris+=1;
    		}
    		$html.= '</tbody>
    			<tfoot>
    				<tr>
    					<td align="right" colspan="5" style="background-color:#B1E9F2">Jumlah Total</td>
    					<td align="right" style="background-color:#B1E9F2">'.eliminasi_negatif($jumlah_debet).'</td>
    					<td align="right" style="background-color:#B1E9F2">'.eliminasi_negatif($jumlah_kredit).'</td>
    					<td align="right" style="background-color:#B1E9F2">'.eliminasi_negatif($saldo).'</td>
    				</tr>
    			</tfoot>
    			</table><br/><br/>';
    		$baris+=1;
		$item++;
		}
	
$html .= '</body>';

// print_r($html);die();

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
$height = $pdf->getY();
if($height>=135){
	// add a page
	$pdf->AddPage('L');
	$pdf->writeHTML($html_head, true, false, true, false, '');
	$pdf->writeHTML('<div align="center">................</div>', true, false, true, false, '');
	$pdf->ln(15); 
}
// set color for background
$pdf->SetFillColor(255, 255, 255);

// set color for text
$pdf->SetTextColor(0, 0, 0);

$cell_height = 5;
if ($unit == null) {
    $pejabat = get_pejabat('all','rektor');
    $teks_kpa = "Rektor";
    $teks_unit = "UNIVERSITAS DIPONEGORO";
} else {
    $pejabat = get_pejabat($unit,'kpa');
    $teks_kpa = "Pengguna Anggaran";
    $teks_unit = get_nama_unit($unit);
}
$pdf->cell(210,$cell_height,'',0,0,'C');
$pdf->cell(60,$cell_height,'Semarang, '.$periode_akhir,0,0,'L');
$pdf->ln($cell_height); 
$pdf->cell(210,$cell_height,'',0,0,'C');
$pdf->cell(60,$cell_height,$teks_kpa,0,0,'L');
$pdf->ln($cell_height); 
$pdf->cell(210,$cell_height,'',0,0,'C');
$pdf->cell(60,$cell_height,$teks_unit,0,0,'L');
$pdf->ln($cell_height+20); 
$pdf->cell(210,$cell_height,'',0,0,'L');
$pdf->MultiCell(60,$cell_height,$pejabat['nama'],0,'L');
$pdf->ln(0); 
$pdf->cell(210,$cell_height,'',0,0,'C');
$pdf->cell(60,$cell_height,'NIP. '.$pejabat['nip'],0,0,'L');
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

function get_nama_unit($kode_unit)
{
	$ci =& get_instance();
	$ci->db2 = $ci->load->database('rba', true);
    $hasil = $ci->db2->where('kode_unit',$kode_unit)->get('unit')->row_array();
    if ($hasil == null) {
        return '-';
    }
    return $hasil['nama_unit'];

}

function get_nama_akun_v($kode_akun){
	$ci =& get_instance();
	if (isset($kode_akun)){
		if (substr($kode_akun,0,1) == 5){
			return $ci->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
		} else if (substr($kode_akun,0,1) == 7){
			$kode_akun[0] = 5;
			$nama = $ci->db->get_where('akun_belanja',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
			$uraian_akun = explode(' ', $nama);
			if(isset($uraian_akun[2])){
	            if($uraian_akun[2]!='beban'){
	              $uraian_akun[2] = 'beban';
	            }
	        }
            $hasil_uraian = implode(' ', $uraian_akun);
            return $hasil_uraian;
		} else if (substr($kode_akun,0,1) == 6 or substr($kode_akun,0,1) == 4){
			$kode_akun[0] = 4;
			$hasil =  $ci->db->get_where('akuntansi_lra_6',array('akun_6' => $kode_akun))->row_array()['nama'];
			if ($hasil == null) {
				$hasil = $ci->db->get_where('akuntansi_pajak',array('kode_akun' => $kode_akun))->row_array()['nama_akun'];
			}
			return $hasil;
		} else if (substr($kode_akun,0,1) == 9){
			return 'SAL';
		} else if (substr($kode_akun,0,1) == 1){
			$hasil = $ci->db->get_where('akuntansi_kas_rekening',array('kode_rekening' => $kode_akun))->row_array()['uraian'];
			if ($hasil == null){
				$hasil = $ci->db->get_where('akun_kas6',array('kd_kas_6' => $kode_akun))->row_array()['nm_kas_6'];
			}
			if ($hasil == null){
				$hasil = $ci->db->get_where('akuntansi_aset_6',array('akun_6' => $kode_akun))->row_array()['nama'];
			}
			return $hasil;
		} else {
			return 'Nama tidak ditemukan';
		}
	}
	
}

function get_saldo_awal($kode_akun){
	return 1000000000;
}

function get_pejabat($unit, $jabatan){
	$ci =& get_instance();
	$ci->db->where('unit', $unit);
	$ci->db->where('jabatan', $jabatan);
	return $ci->db->get('akuntansi_pejabat')->row_array();
}

function eliminasi_negatif($value)
{
    if ($value < 0) 
        return "(". number_format(abs($value),2,',','.') .")";
    else
        return number_format($value,2,',','.');
}

function format_nip($value)
{
    return str_replace("'",'',$value);
}