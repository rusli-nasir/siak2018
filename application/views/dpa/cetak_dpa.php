<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
function b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || '';
    sliceSize = sliceSize || 512;

    var byteCharacters = atob(b64Data);
    var byteArrays = [];

    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    var blob = new Blob(byteArrays, {type: contentType});
    return blob;
}

$(document).on("click","#cetak",function(){
	var html = $('#table-dpa').html();
	$('#table-cetak-dpa').html(html);
	$( "#table-cetak-dpa > thead" ).prepend('<tr><td colspan="5" align="center" style="height:50px;background-color:#EEE;"><b>DPA <?=$sumber_dana?></b></td></tr>');
	var html_cetak = $('#table-cetak-dpa').get(0).outerHTML;
	var strenc = $.base64.encode( html_cetak );
	var blob = b64toBlob(strenc, "application/vnd.ms-word;charset=charset=utf-8");
                            
    saveAs(blob, 'dpa_<?=preg_replace('/\s+/', '_', $sumber_dana)?>.doc');
});
$(document).on("click","#print",function(){
	var html = $('#table-dpa-detail').html();
	$('#table-print-dpa').html(html);
	$( "#table-print-dpa > thead" ).prepend('<tr><td colspan="5" align="center" style="height:50px;background-color:#EEE;font-family:Bookman Old Style;font-size: 14px;"><b>DPA <?=$sumber_dana?></b></td></tr>');
	var html_cetak = $('#table-print-dpa').get(0).outerHTML;
	var strenc = $.base64.encode( html_cetak );
	var blob = b64toBlob(strenc, "application/vnd.ms-word;charset=charset=utf-8");
                            
    saveAs(blob, 'dpa_detail_<?=preg_replace('/\s+/', '_', $sumber_dana)?>.doc');
});
	

$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
$('#myTabs a[href="#profile"]').tab('show') 
$('#myTabs a:first').tab('show')
$('#myTabs a:last').tab('show')
$('#myTabs li:eq(2) a').tab('show')
</script>
<div id="page-wrapper" >
<div id="page-inner">
 <div id="temp" style="display:none"></div> 
 <?php //foreach($unit_usul as $i => $u){ 
 ini_set('display_errors', 0);
 $u = isset($result_program_usul[0])?$result_program_usul[0]:'';
 //var_dump($u);
 $total = isset($result_jumlah_usul[0])?$result_jumlah_usul[0]:'';
 ?>
 <div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Cetak DPA</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Ringkasan DPA</a></li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
		<div class="alert alert-warning" style="text-align:center">

<button type="button" class="btn btn-primary" name="cetak" id="cetak" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>

		<!--
		<button type="button" class="btn btn-primary" name="cetak" id="cetak" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
		-->
</div>
		<table class="table" id="table-dpa" style="font-family:Bookman Old Style;font-size: 14px;">
			<tr>
				<td width="20%">
					<img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="50" height="60">
				</td>
				<td width="70%" align="middle">
					<b>SURAT PENGESAHAN<br>
					DOKUMEN PELAKSANAAN ANGGARAN (DPA) SUKPA <br>
					UNIVERSITAS DIPONEGORO TAHUN ANGGARAN <?=$u->tahun?><br>
					NOMOR:</b> ....................................
				</td>
				<td width="10%" >
				
				</td>
			</tr>
			<tr align="justify">
				<td colspan="3"><br><br>
				A. Dasar Hukum
					<ol type="1" style=" text-align: justify;">
						<li>Undang Undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional Lembaran Negara RI tahun 2003 nomor 78, Tambahan Lembaran Negara RI No.4301);</li>
						<li>Undang-Undang Nomor 12 Tahun 2012 tentang Pendidikan Tinggi (Lembaran Negara Republik Indonesia Tahun 2012 Nomor 158, Tambahan Lembaran Negara Republik Indonesia Nomor 5336);</li>
						<li>Peraturan Pemerintah Nomor 4 Tahun 2014 tentang Penyelenggaraan Pendidikan dan Pengelolaan Perguruan Tinggi (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 16, Tambahan Lembaran Negara Republik Indonesia Nomor 5500);</li>
						<li>Peraturan Pemerintah Nomor 81 Tahun 2014 tentang Penetapan Universitas Diponegoro Sebagai Perguruan Tinggi Negeri Badan Hukum (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 302);</li>
						<li>Peraturan Pemerintah Republik Indonesia Nomor 26 Tahun 2015 tentang Bentuk dan Mekanisme Pendanaan Perguruan Tinggi Negeri Badan Hukum (Lembaran Negara Republik Indonesia Tahun 2015 Nomor 110, tambahan Lembaran Negara Nomor 5699);</li>
						<li>Peraturan Pemerintah Republik Indonesia Nomor 52 Tahun 2015 tentang Statuta Universitas Diponegoro (Lembaran Negara Republik Indonesia Tahun 2015 Nomor 170, Tambahan Lembaran Negara Nomor 5721);</li>
						<li>Keputusan Menteri Ristek, Teknologi, dan Pendidikan Tinggi Nomor 146/M/KP/IV/2015 tentang Pengangkatan Rektor Universitas Diponegoro;</li>
						<li>Peraturan Majelis Wali Amanat Universitas Diponegoro Nomor 2 Tahun 2016 tentang Organisasi dan Tata Kerja Universitas Diponegoro;</li>
						<li>Peraturan Majelis Wali Amanat Universitas Diponegoro Nomor 7 Tahun 2016 tentang Kebijakan Umum Universitas Diponegoro;</li>
						<li>Peraturan Rektor Nomor 4 Tahun 2016 tentang Organisasi dan Tata Kerja Unsur-Unsur Dibawah Rektor Universitas Diponegoro;</li>
						<li>Peraturan Rektor Universitas Diponegoro Nomor 16 tahun 2016, tentang Rencana Kerja dan Anggaran Tahun 2017;</li>
					</ol>
					
				B. Dengan ini disahkan alokasi anggaran untuk :
				<ol type="1" style=" text-align: justify;">
						<li>Unit Kerja/SUKPA: <?=$u->nama_unit?></li>
						<li>Kode: <?=$u->kode_unit?></li>
				</ol>
				C. Sumber dana berasal dari 
				<ol type="1" style=" text-align: justify;">
				
					<li>
					<?php
						if ($u->sumber_dana=="SELAIN-APBN"){
							echo "SELAIN-APBN";
						}else if ($u->sumber_dana=="APBN-BPPTNBH"){
							echo "APBN (BPPTNBH)";
						}else if ($u->sumber_dana=="APBN-LAINNYA"){
							echo "SPI - SILPA - PINJAMAN";
						}
					?>:&nbsp; Rp. <?=number_format($total->total,0,",",".")?>&nbsp;(<?=$terbilang?> rupiah) </li>
				</ol>
				D. Pernyataan syarat dan ketentuan: 
				<ol type="1" style=" text-align: justify;">
					<li>DPA berfungsi sebagai dasar pelaksanaan kegiatan unit kerja dan pencairan dana/pengesahan bagi Bendahara Umum Undip/Bendahara SUKPA. </li>
					<li>Tanggung jawab terhadap penggunaan anggaran yang tertuang dalam DPA sepenuhnya berada pada Pengguna Anggaran/Kuasa Pengguna Anggaran. </li>
					<li>DPA berlaku sejak tanggal 1 Januari 2017 sampai dengan 31 Desember 2017.</li>
					<li>Dokumen ini merupakan ringkasan DPA SUKPA dan merupakan persetujuan penerbitan Rincian DPA SUKPA.</li>
				</ol>
				</td>
			</tr>
			<tr>
				<td colspan="1" align="left">
			<?php
			$revisi=$u->impor;
			$tgl=$u->tanggal_impor;
			$revisix=$revisi-1;
			if($revisix==0){
			?>
			Revisi : -<br>
			Tanggal : -
			<?php
			}else{
			?>
			Revisi : <?=$revisix?><br>
			Tanggal : <?=date_format($tgl, 'Y-m-d H:i:s');?>
			<?php
			}
			?>
				</td>
			
				<td colspan="2" align="right">
				<div style="width:300px;float:right;">
					Semarang, 30 Desember 2016<br>
					Bendahara Umum Undip<br>
					<br>
					
					
					<br>
					<br>
					Dr. Darsono, SE, Akt, MBA<br>
					NIP. 1962081319900110011
				</div>
				</td>
			</tr>
			
		</table>

		<div style="display:none">
		<table id="table-cetak-dpa"  style="font-family:Bookman Old Style;font-size: 14.5px; border-collapse: separate;width: auto;text-align:justify" cellspacing="0px" cellpadding="0px" border="0">
</table>
</div>
 
	</div>
    <div role="tabpanel" class="tab-pane" id="profile">
	<div class="alert alert-warning" style="text-align:center">

<button type="button" class="btn btn-primary" name="print" id="print" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>

		<!--
		<button type="button" class="btn btn-primary" name="cetak" id="cetak" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
		-->
</div>
	<table id="table-dpa-detail" style="font-family:Bookman Old Style;font-size: 14px; border-collapse: collapse;">
		<tbody>
		<tr>
			<td valign="middle" width="5%">
					<img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="50" height="60" align="center">
				</td>
				<td colspan="2" width="90%" align="middle">
					<b>RINGKASAN<br>
					DOKUMEN PELAKSANAAN ANGGARAN (DPA) SUKPA <br>
					UNIVERSITAS DIPONEGORO TAHUN ANGGARAN <?=$u->tahun?><br>
					NOMOR:</b> ..................................
				</td>
				<td width="5%">
				</td>
		</tr>
			
			<tr>
				<td colspan="4" align="left" ><br><br>UNIT KERJA/SUKPA: <?=$u->kode_unit?> (<?=$u->nama_unit?>)</td>
			</tr>
			<tr>
				<td colspan="4" align="left">TOTAL ANGGARAN: <b>Rp. <span class="total_global_0"></span><?=number_format($total->total, 0, ',', '.');?></b></td>
			</tr>
			<tr height="50px">
				<th width="30%" style="vertical-align:middle;text-align:center;border:1px solid #000;"  align="center"><b>TUJUAN</b></th>
				<th width="30%" style="vertical-align:middle;text-align:center;border:1px solid #000;"  align="center"><b>SASARAN</b></th>
				<th width="30%"style="vertical-align:middle;text-align:center;border:1px solid #000;"  align="center"><b>PROGRAM</b></th>
				<th width="10%"style="vertical-align:middle;text-align:center;border:1px solid #000;"  align="center"><b>JUMLAH (RP)</b></th>
			</tr>
		 <?php // BISMILLAAH
		 /*
			$i=0;
			foreach($result_program_usul as $r){
				$kode_usulan=$r->kode_usulan_belanja;
				$k[$i]=substr($kode_usulan,6,2);
				$i++;
			}
			$k=array_unique($k);
			//var_dump($k);exit;
			$i=0;
			foreach($result_program_usul as $r){
				$kode_usulan=$r->kode_usulan_belanja;
				$j[substr($kode_usulan,6,2)][$i]=substr($kode_usulan,8,2);
				$i++;
			}
			//$j=array_unique($j);
			//var_dump($j);exit;
			$i=0;
			foreach($result_program_usul as $r){
				$kode_usulan=$r->kode_usulan_belanja;
				$l[substr($kode_usulan,8,2)][$i]=array(substr($kode_usulan,10,2),$r->total);
				$i++;
			}
			foreach($j as $a => $b){
				$j[$a]=array_unique($b);
			}
		*/
			//foreach($result_program_usul as $num_row=>$row){ $kode=$row->kode_usulan_belanja;
		/*	 
		 foreach( $k as $x1 => $x2 ){
		?>
			<tr>
				<td style="vertical-align:top;text-align:left"><?php echo $x2;?>-<?php echo get_kegiatan_name($x2)?></td>
				<td colspan="3">
					<table border="1">
						
					<?php foreach( $j[$x2] as $x3 => $x4 ){?>
						<tr>
							<td width="30%" style="vertical-align:top;text-align:left"><?php echo $x4;?></td>
							<td>
								<table id="table-dpa-detail" border="1">
								
						<tr>
								
								<?php 
								$total=0;
								foreach($l[$x4] as $x5 => $x6 ){
									$total+=$x6[1];
									?>
									<tr>
										<td width="60%"><?php echo $x2.$x4.$x6[0];?>-
										</td>
										<td width="20%"  style=" text-align: right;">Rp. <b><?=number_format($x6[1],0,",",".")?></b></td>
										
									</tr>
									
								<?php } ?>
								<tr class="alert alert-warning">
										<td>TOTAL PER SASARAN</td>
										<td style=" text-align: right;"><b>Rp. <?=number_format($total,0,",",".")?></b></td>
									</tr>
								</table>
							</td>
						</tr>
					<?php }?>
					
					</table>
				</td>
				
				
			</tr>
		<?php 
		 }
			*/
			$i=0;
			$total=0;
                        $array_keg = array();
                        $tot_arr = count($result_program_usul); 
			for($i=0;$i<count($result_program_usul);$i++){
				$total+=$v->total;
				$sStyle="";
				if($i!=0){
					if($result_program_usul[$i]->nama_kegiatan!=$result_program_usul[($i-1)]->nama_kegiatan){
						$kegiatan = $result_program_usul[$i]->nama_kegiatan;
						$style = " style=\"border:1px solid #000;border-bottom:0;padding:3px;".$sStyle."\"";
					/*
					if($i!=0){				
		?>
		<tr>
			<td colspan="3" style="border:1px solid #000;text-align:center;">Total</td>
			<td style="text-align:right;border:1px solid #000;"><?php echo number_format($total,0,',','.');?>,-</td>
		</tr>
		<?php
					}
					*/
					}else{
						$kegiatan = "";
						$style = " style=\"border:1px solid #000;border-top:0;border-bottom:0;padding:3px;".$sStyle."\"";
					}
				}else{
					$kegiatan = $result_program_usul[$i]->nama_kegiatan;
					$style = " style=\"border:1px solid #000;border-bottom:0;padding:3px;".$sStyle."\"";
				}
		?>
                <?php if ( ( $kegiatan != "" ) && ( $i != 0 ) ) { ?>
                
                <tr>
			<td style="border:1px solid #000;" colspan="3" align="center">SUB TOTAL</td>
			
			<td style="border:1px solid #000;"><?php echo number_format($total,0,',','.'); ?>,-</td>
		</tr>
                <?php $total = 0 ; ?>
                <?php } ?>
                
		<tr>
			<td<?php echo $style; ?>><?php echo $kegiatan; ?></td>
			<td style="border:1px solid #000;"><?php echo $result_program_usul[$i]->nama_output; ?></td>
			<td style="border:1px solid #000;"><?php echo $result_program_usul[$i]->nama_program; ?></td>
			<td style="border:1px solid #000;text-align:right;"><?php echo number_format($result_program_usul[$i]->total,0,',','.'); ?>,-</td>
		</tr>
                <?php $total = $total + $result_program_usul[$i]->total ?>
                
                <?php if ( ($i + 1 ) == $tot_arr ) { ?>
                
                <tr>
				<td style="border:1px solid #000;" colspan="3" align="center">SUB TOTAL</td>
			<td style="border:1px solid #000;" ><?php echo number_format($total,0,',','.'); ?>,-</td>
		</tr>
                <?php $total = 0 ; ?>
                <?php } ?>
                
		<?php
			}
		?>
		 <tr>
				<td colspan="2" align="left" style="text-v">
			<?php
			$revisi=$u->impor;
			$tgl=$u->tanggal_impor;
			$revisix=$revisi-1;
			if($revisix==0){
			?>
			Revisi : -<br>
			Tanggal : -
			<?php
			}else{
			?>
			Revisi : <?=$revisix?><br>
			Tanggal : <?=date_format($tgl, 'Y-m-d H:i:s');?>
			<?php
			}
			?>
				</td>
				<td colspan="2" align="right">
				<div style="width:300px;float:right;">
					Semarang, 30 Desember 2016<br>
					Bendahara Umum Undip<br>
					<br>
					
					
					<br>
					<br>
					Dr. Darsono, SE, Akt, MBA<br>
					NIP. 1962081319900110011
				</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div style="display:none">
		<table id="table-print-dpa"  style="font-family:Bookman Old Style;font-size: 12px; border-collapse: collapse;" cellspacing="0px" cellpadding="0px" border="0">
</table>
</div>
	</div>
   
  </div>
	</div>
</div> 
</div>



          