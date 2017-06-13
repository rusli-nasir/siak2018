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

// add a page
$pdf->AddPage('L');

$html_head = 
	'<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<div align="center" style="font-weight:bold">
			UNIVERSITAS DIPONEGORO<br/>
			NERACA SALDO<br/>
			'.$teks_periode.'<br/><br/>
		</div>';
$pdf->writeHTML($html_head, true, false, true, false, '');
			$html = '<table style="font-size:10pt;">
						<tr>
							<td width="250px"><b>Unit Kerja</b></td>
							<td>UNIVERSITAS DIPONEGORO</td>
						</tr>
						<tr>
							<td><b>Tahun Anggaran</b></td>
							<td>2017</td>
						</tr>
				</table>';
			$html .= '<table style="width:800px;font-size:10pt;" border="1">
					<thead>
						<tr style="background-color:#ECF379;height:45px">
							<th rowspan="2">No</th>
							<th rowspan="2">Kode</th>
							<th rowspan="2">Uraian</th>
							<th align="center" colspan="2">Mutasi</th>
							<th align="center" colspan="2">Neraca Saldo</th>
						</tr>
						<tr style="background-color:#ECF379;height:45px">
							<th>DEBIT</th>
							<th>KREDIT</th>
							<th>DEBIT</th>
							<th>KREDIT</th>
						</tr>
					</thead>
					<tbody>';

			$i = 1;

			$jumlah_debet = 0;
		    $jumlah_kredit = 0;
	        $jumlah_neraca_debet = 0;
	        $jumlah_neraca_kredit = 0;

			foreach ($query as $key => $entry) {
				$saldo = get_saldo_awal($key);
		    	$debet = 0;
		    	$kredit = 0;

				$html .= '<tr>
						<td>'.$i.'</td>
						<td>'.$key.'</td>
						<td>'.get_nama_akun_v((string)$key).'</td>';
					foreach ($entry as $transaksi) {
		    			if ($transaksi['tipe'] == 'debet'){
		    				$saldo += $transaksi['jumlah'];
		    				$debet += $transaksi['jumlah'];
		    			} else if ($transaksi['tipe'] == 'kredit'){
							$saldo -= $transaksi['jumlah'];
							$kredit += $transaksi['jumlah'];
		    			}
		    		}


		    		$jumlah_debet += $debet;
		    		$jumlah_kredit += $kredit;
		    		$saldo_neraca = $debet - $kredit;

				$html .= '<td align="right">'.number_format($debet,2).'</td>
						<td align="right">'.number_format($kredit,2).'</td>';
					if ($saldo_neraca > 0) {
		                $jumlah_neraca_debet += $saldo_neraca;
		                $html .= '<td align="right">0.00</td>';
		                $html .= '<td align="right">'.number_format($saldo_neraca,2).'</td>';
		            } elseif ($saldo_neraca < 0) {
		                $saldo_neraca = abs($saldo_neraca);
		                $jumlah_neraca_kredit += $saldo_neraca;
		                $html .= '<td align="right">0.00</td>';
		                $html .= '<td align="right">'.number_format($saldo_neraca,2).'</td>';
		            }else{
		            	$html .= '<td align="right">0.00</td>';
		            	$html .= '<td align="right">0.00</td>';
		            }

				$html .= '</tr>';
				
				$i++;
			}
    		$html .= '</tbody>
	    			<tfoot>
					 	<tr>
		    				<td align="right" colspan="3" style="background-color:#B1E9F2"><b>Jumlah Total</b></td>
		    				<td align="right">'.number_format($jumlah_debet,2).'</td>
		    				<td align="right">'.number_format($jumlah_kredit,2).'</td>
		    				<td align="right">'.number_format($jumlah_neraca_debet,2).'</td>
		    				<td align="right">'.number_format($jumlah_neraca_kredit,2).'</td>
		    			</tr>
	    			</tfoot>
				</table></body>';

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
$pejabat = get_pejabat($unit, 'kpa');
$pdf->cell(210,$cell_height,'',0,0,'C');
$pdf->cell(60,$cell_height,'Semarang, '.date("d-m-Y", strtotime($periode_akhir)),0,0,'L');
$pdf->ln($cell_height); 
$pdf->cell(210,$cell_height,'',0,0,'C');
$pdf->cell(60,$cell_height,'Pengguna Anggaran',0,0,'L');
$pdf->ln($cell_height); 
$pdf->cell(210,$cell_height,'',0,0,'C');
$pdf->cell(60,$cell_height,get_nama_unit($unit),0,0,'L');
$pdf->ln($cell_height+20); 
$pdf->cell(210,$cell_height,'',0,0,'C');
$pdf->MultiCell(60,$cell_height,$pejabat['nama'],0,0,'L');
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