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
			JURNAL UMUM<br/>
			'.$teks_periode.'<br/>
			'.$teks_tahun_anggaran.'<br/><br/>
		</div>';
$pdf->writeHTML($html_head, true, false, true, false, '');
	$html = '<table style="width:800px;font-size:10pt;" border="1">
			<thead>
				<tr style="background-color:#ECF379;height:45px">
					<th width="30px;">No</th>
					<th>Tanggal</th>
					<th>NO. SPM</th>
					<th>NO. BUKTI</th>
					<th>OUTPUT</th>
					<th>Kode Akun</th>
					<th>URAIAN</th>
					<th>DEBET</th>
					<th>KREDIT</th>
				</tr>
			</thead>
			<tbody>';
				$iter = 1;

		        $jumlah_debet = 0;
		        $jumlah_kredit = 0;

		        $baris = 6;
		        $total_data = 24;//count($query);

		        foreach ($query as $entry) {
		        	$transaksi = $entry['transaksi'];
            		$akun = $entry['akun'];
            		$nama_unit = get_nama_unit($transaksi['unit_kerja']);
            		
            		$html .= '<tr>
            				<td align="center" style="background-color:#D0FCEE" width="30px;">'.$iter.'</td>
            				<td align="center" colspan="5" style="background-color:#D0FCEE" align="right">Keterangan</td>
            				<td colspan="3">'.$nama_unit.':<br/>'.$transaksi['uraian'].'</td>
            			</tr>';
            		$baris+=1;
            		foreach ($akun as $in_akun) {			
            			$html .= '<tr>
            					<td width="30px;"></td>
            					<td>'.date("d M Y", strtotime($transaksi['tanggal'])).'</td>
            					<td>'.$transaksi['no_spm'].'</td>
            					<td>'.$transaksi['no_bukti'].'</td>
            					<td>'.substr($transaksi['kode_kegiatan'],6,4).'</td>
            					<td>'.$in_akun['akun'].'</td>
            					<td>'.get_nama_akun_v($in_akun['akun']).'</td>';
            					if ($in_akun['tipe'] == 'debet'){
				                    $html .= '<td align="right">'.number_format($in_akun['jumlah'],2).'</td>';
				                    $html .= '<td align="right">0.00</td>';
				                    $jumlah_debet += $in_akun['jumlah'];
				                }elseif ($in_akun['tipe'] == 'kredit') {
				                    $html .= '<td align="right">0.00</td>';
				                    $html .= '<td align="right">'.number_format($in_akun['jumlah'],2).'</td>';
				                    $jumlah_kredit += $in_akun['jumlah'];
				                }
            			$html .= '</tr>';
            			$baris+=1;            			
            		}
		        	$iter++;
		        	// add a page
		        	if($baris%20 == 5){
		        		$html .= '<br pagebreak="true"/>';
		        	}
		        }

			$html .= '</tbody>';
			$html .= '<tr>
    				<td align="right" colspan="7" style="background-color:#B1E9F2"><b>Jumlah Total</b></td>
    				<td align="right">'.number_format($jumlah_debet,2).'</td>
    				<td align="right">'.number_format($jumlah_kredit,2).'</td>
    			</tr>';
		$html .= '</table>';

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
$pdf->cell(60,$cell_height,$pejabat['nama'],0,0,'L');
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