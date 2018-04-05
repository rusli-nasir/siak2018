<script>
$(document).ready(function(){
	$("#cetak").click(function(){
    var mode = 'iframe'; //popup
    var close = mode == "popup";
    var options = { mode : mode, popClose : close};
    $("#div-cetak").printArea( options );


});


	$("#kembali").click(function(){
		window.location.href = "<?php echo base_url(); ?>index.php/rsa_sspb/daftar_spm";
	});

	$("#tolak").click(function(){
    var nomor_sspb = $("#tolak").attr('rel');
	var nomor_trx_spm = $("#tolak").attr('data');
			$.ajax({
			type:"POST",
			url:"<?=site_url("rsa_sspb/modal_tolak")?>",
			data:'nomor_sspb='+nomor_sspb+'&nomor_trx_spm='+nomor_trx_spm,
			success:function(respon){
				$("#modal_content").html(respon);
			},
			complete:function(){
				$('#alasan').modal('show');
			}
		});
});
});

$(document).on("click","#setuju",function(e){
	if(confirm('Anda yakin menyetujui ?')){
			var nomor_sspb = $("#setuju").attr('rel');
			var nomor_trx_spm = $("#setuju").attr('data');
			e.preventDefault();
	         $.ajax({
	             type:"POST",
	             url:"<?=site_url("rsa_sspb/update_status_setuju")?>",
	             data:'nomor_sspb='+nomor_sspb+'&nomor_trx_spm='+nomor_trx_spm,
	             success:function(respon){
	                 if(respon == "true"){
	                    bootbox.alert({
	                                 title: " <span style='color: green;'>SUKSES",
	                                 message: "Dokumen SSPB telah di setujui",
	                                 callback: function(){ 
	                                     window.location.reload();
	                                 }
	                             });
	                 }else if(respon == "false"){
	                     bootbox.alert({
	                                 title: " <span style='color: red;'>PERHATIAN !!",
	                                 message: "GAGAL",
	                                 callback: function(){ 
	                                     window.location.reload();
	                                 }
	                             });
	                 }

	             }
	         });
	     }
	     return false;
    	
  	});




</script>

<div id="page-wrapper" >
	<div id="page-inner">
		<h3><b>CETAK SSPB</b></h3><hr>
		 <?php 
    $stts_bendahara = '';
    $stts_ppk = '';
    $stts_kpa = '';
    $stts_verifikator = '';
    $stts_kbuu = '';
    ?>
                        
        <?php if($doc == ''){ $stts_bendahara = 'active'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> belum diusulkan oleh bendahara.</div>
    <?php }elseif($doc == 'SSPB-DRAFT'){ $stts_bendahara = 'done'; $stts_ppk = 'active'; ?>
        <div class="alert alert-info" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >PPK SUKPA</span></b> .</div>
    <?php }elseif($doc == 'SSPB-DITOLAK'){ $stts_bendahara = 'done'; $stts_ppk = 'tolak'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >PPK SUKPA</span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc == 'SSPB-FINAL'){ $stts_bendahara = 'done';  $stts_ppk = 'done'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah diterima oleh <b><span class="text-danger" >PPK SUKPA</span></b> .</div>
    <?php }elseif($doc == 'SSPB-DRAFT-PPK'){ $stts_bendahara = 'done'; $stts_ppk = 'done';  $stts_kpa = 'active'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KPA </span></b> .</div>
    <?php }elseif($doc == 'SSPB-DRAFT-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'active';  ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >VERIFIKATOR </span></b> .</div>
    <?php }elseif($doc == 'SSPB-DITOLAK-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'tolak' ; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KPA </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc == 'SSPB-FINAL-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'active' ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc == 'SSPB-DITOLAK-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'tolak'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >VERIFIKATOR </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc == 'SSPB-FINAL-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done'; ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah disetujui oleh <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc == 'SSPB-DITOLAK-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'tolak'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KUASA BUU </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc == 'SSPB-FINAL-BUU'){$stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done'; $stts_buu = 'done';  ?> 
        <div class="alert alert-success" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah difinalisasi oleh <b><span class="text-danger" >BUU </span></b> .</div>
    <?php }elseif($doc == 'SSPB-DITOLAK-BUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done'; $stts_buu = 'tolak'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SSPB Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >BUU </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php } ?>
        
<div class="progress-round">
  <div class="circle <?=$stts_bendahara?>">
    <span class="label">1</span>
    <span class="title">Bendahara</span>
  </div>
  <span class="bar <?=$stts_bendahara?>"></span>
  <div class="circle <?=$stts_ppk?>">
    <span class="label">2</span>
    <span class="title">PPK</span>
  </div>
  <span class="bar <?=$stts_ppk?>"></span>
  <div class="circle <?=$stts_kpa?>">
    <span class="label">3</span>
    <span class="title">KPA</span>
  </div>
  <span class="bar <?=$stts_kpa?>"></span>
  <div class="circle <?=$stts_verifikator?>">
    <span class="label">4</span>
    <span class="title">Verifikator</span>
  </div>
  <span class="bar <?=$stts_verifikator?>"></span>
  <div class="circle <?=$stts_kbuu?>">
    <span class="label">5</span>
    <span class="title">KBUU</span>
  </div>
</div>
		<div class="row">
			<div class="col-lg-12">
				
				<div id="temp" style="display:none">
				</div>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active">
						<div style="background-color: #EEE;">
							<div id="div-cetak" style="margin: 0px auto;">
								<table id="table" style="margin: 0px auto;font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0">
									<tbody>
										<tr>
											<td colspan="7" style="text-align: center;padding-top: 5px;padding-bottom: 5px;"><img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60"></td>
										</tr>
										<tr>
											<td style="border:0px;width: 0.1%;white-space:nowrap;"></td>
											<td style="border:0px;width: 1%;white-space:nowrap;"></td>
											<td style="border:0px;width: 1%;white-space:nowrap;"></td>
											<td style="border:0px;width: 1%;white-space:nowrap;"></td>
											<td style="border:0px;width: 1%;white-space:nowrap;"></td>
											<td style="border:0px;width: 2%;white-space:nowrap;"></td>
											<td style="border:0px;width: 0.1%;white-space:nowrap;"></td>
										</tr>
										<tr >
											<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr style="">
											<td colspan="7" style="text-align: center;font-size: 20px;border-bottom: none;border-top: none"><b>UNIVERSITAS DIPONEGORO</b></td>
										</tr>
										<tr style="border-top: none;">
											<td colspan="7" style="text-align: center;font-size: 16px;border-bottom: none;border-top: none;"><b>SURAT SETORAN PENGEMBALIAN BELANJA</b></td>
										</tr>
										<tr >
											<td colspan="7" style="border-bottom: none;border-top: none;"></td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="2" style="border-right: none;border-left: none;"><b>Tanggal	: <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_sspb)?'':strftime("%d %B %Y", strtotime($tgl_sspb)); ?></b></td>
											<td style="text-align: center;border-left: none;border-right: none;" colspan="2">&nbsp;</td>
											<td style="border-left: none;border-right: none;"><b>Nomor : <?php echo $nomor_sspb ?></b></td>
											<td style="border-left: none;border-right: none;">&nbsp;</td>
										</tr>
										<tr >
											<td style="border-right: none;">&nbsp;</td>
											<td style="border-left: none;border-right: none;" colspan="5" ><b>Satuan Unit Kerja Pengguna Anggaran (SUKPA) : <?php if ($nama_subunit ==""){
												echo $nama_unit;
											} else{
												echo $nama_subunit;
											}?>
												
											</b></td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="2" style="border-right: none;border-left: none;"><b>Unit Kerja : <?php echo $nama_unit ?> </b> </td> 
											<td style="text-align: center;border-left: none;border-right: none;" colspan="2">&nbsp;</td>
											<td style="border-left: none;border-right: none;"><b>Kode Unit Kerja : <?php echo $kode_unit_subunit ?> </b></td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
										<tr style="border-bottom: none;">

											<td colspan="5" style="border-right: none;border-bottom: none;">&nbsp;</td>
											<td colspan="2" style="line-height: 16px;border-left: none;border-bottom: none;">Kepada Yth.<br>
												Bendahara Umum Undip ( BUU )<br>
												di Semarang
											</td>
										</tr>
										<tr >
											<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr >
											<td style="border-right: none;border-bottom: none;border-top: none;">&nbsp;</td>
											<td colspan="5" style="border-bottom: none;border-top: none;border-right: none;border-left: none;">Bendahara Pengeluaran SUKPA menyampaikan setoran pengembalian belanja dengan informasi sebagai berikut :</td>
											<td style="border-left: none;border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;border-bottom: none;border-top: none;">&nbsp;</td>
											<td colspan="5" style="border-right: none;border-left: none;line-height: 16px;border-bottom: none;border-top: none;">
												<ol style="list-style-type: lower-alpha;margin-top: 0px;margin-bottom: 0px;" >
													<li>Jumlah dana : Rp. <?php echo number_format($jumlah_bayar, 0, ",", ".") ?> ,-<br>
													&nbsp;&nbsp;&nbsp;(Terbilang : <b><?php echo $terbilang ?> </b> )</li>
													<li>Atas SPM nomor : <?php echo $nomor_trx_spm ?> </li>
													<li>Dikembalikan ke Rekening Bank : <?php echo $nmrekening ?>
	                                                <li>No. Rekening Bank : <?php echo $rekening ?> </li>
													<li>Keterangan: <?php echo $keterangan ?></li>
												</ol>
											</td>
											<td style="border-left: none;border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;border-bottom: none;border-top: none;">&nbsp;</td>
											<td colspan="6" style="border-top: none;border-left: none;border-bottom: none;">
												Setoran sebagaimana tersebut diatas, menambah sisa anggaran dan mengurangi realisasi akun belanja sebagai berikut :<br>                         
											</td>
										</tr>
										<tr>
											<td colspan="7" style="border:none;">
												<table class="" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 100%;border: 0px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0">
													<thead>
														<th class="col-md-3" style="text-align: center;">NAMA AKUN</th>
														<th class="col-md-1" style="text-align: center;">KODE AKUN</th>
														<th class="col-md-2" style="text-align: center;">KODE USULAN BELANJA</th>
														<th class="col-md-1" style="text-align: center;">KODE AKUN TAMBAH</th>
														<th class="col-md-4" style="text-align: center;">DESKRIPSI</th>
														<th class="col-md-2" style="text-align: center;">DANA SETORAN</th>
													</thead>
													<tbody>
														<td style="padding-left: 10px;text-align: left;"><?php echo $nama_akun4digit ?></td>
														<td style="padding-left: 0px;text-align: center;"><?php echo $kode_akun4digit ?></td>
														<td style="padding-left: 0px;text-align: center;"><?php echo $kode_usulan_belanja ?></td>
														<td style="padding-left: 0px;text-align: center;"><?php echo $kode_akun_tambah ?></td>
														<td style="padding-left: 10px;"><?php echo $deskripsi ?></td>
														<td style="padding-right: 10px;text-align: right;"><?php echo number_format($jumlah_bayar, 0, ",", ".") ?></td>
													</tbody>
												</table>
											</td>
										</tr>
										<tr >
											<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;border-top: none;">&nbsp;</td>
											<td colspan="5" style="line-height: 16px;border-bottom: none;border-top: none;border-left: none;border-right: none;">
												SSPB sebagaimana dimaksud diatas, disusun dan disampaikan kepada Bendahara Umum Undip sebagai bukti setoran pengembalian belanja atas SPM yang telah diterbitkan sebelumnya.<br><br>														
											</td>
											<td style="border-left: none;border-bottom: none;border-top: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="2" style="line-height: 16px;border-right: none;border-left: none;" class="ttd">
												Dokumen SSPB telah diverifikasi keabsahannya <br>
												PPK-SUKPA<br>
												<br>
												<br>
												<br>
												<br>
												<span id=""><?php echo $nmppk ?></span><br>
												NIP. <span id=""><?php echo $nipppk ?></span><br>
											</td>
											<td colspan="2" style="border-right: none;border-left: none;">&nbsp;</td>
											<td colspan="1" style="line-height: 16px;border-left: none;border-right: none;" class="ttd">
												Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_sspb)?'':strftime("%d %B %Y", strtotime($tgl_sspb)); ?> <br>
												Bendahara Pengeluaran SUKPA<br>
												<br>
												<br>
												<br>
												<br>
												<span id=""><?php echo $nmbendahara ?></span><br>
												NIP. <span id=""><?php echo $nipbendahara ?></span><br>
											</td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="2" style="line-height: 16px;border-right: none;border-left: none;" class="ttd">
												Kuasa Pengguna Anggaran<br>
												<br>
												<br>
												<br>
												<br>
												<br>
												<br>
												<span id=""><?php echo $nmkpa ?></span><br>
												NIP. <span id=""><?php echo $nipkpa ?></span><br>
											</td>
											<td colspan="2" style="border-right: none;border-left: none;">&nbsp;</td>
											<td colspan="1" style="line-height: 16px;border-left: none;border-right: none;" class="ttd">
												Dokumen SSPB telah diverifikasi<br>
												kelengkapannya oleh Verifikator<br>
												Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_verif)?'':strftime("%d %B %Y", strtotime($tgl_verif)); ?><br />
												<br>
												<br>
												<br>
												<br>
												<span id=""><?php echo $nmverifikator ?></span><br>
												NIP. <span id=""><?php echo $nipverifikator ?></span><br>
											</td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="2" style="line-height: 16px;border-right: none;border-left: none;" class="ttd">
											Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_kbuu)?'':strftime("%d %B %Y", strtotime($tgl_kbuu)); ?><br>
												Telah disetorkan oleh <br>
												Kuasa Bendahara Umum Undip<br>
												<br>
												<br>
												<br>
												<br>
												<br>
												<br>
												<span id=""><?php echo $nmkbuu ?></span><br>
												NIP. <span id=""><?php echo $nipkbuu ?></span><br>
											</td>
											<td colspan="2" style="border-right: none;border-left: none;">&nbsp;</td>
											<td colspan="1" style="line-height: 16px;border-left: none;border-right: none;" class="ttd">
												
												<br>
												<br>
												<br>
												<br>
												<br>
												<br>
												<span id=""></span><br>
												<span id=""></span><br>
											</td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
										<tr>
											<td style="border-right: none;">&nbsp;</td>
											<td colspan="5"  style="line-height: 16px;border-right: none;border-left: none">
												
												<ul>
												</ul>
											</td>
											<td style="border-left: none;">&nbsp;</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
								<div class="alert alert-warning" style="text-align:center">
									<button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
									<button type="button" class="btn btn-warning" id="kembali" rel=""><span class="glyphicon glyphicon-back" aria-hidden="true"></span> Kembali</button>
								</div>
				</div>
			</div>
		</div>	

		<?php if($doc == ''){ $stts_bendahara = 'active'; ?>
       
		<?php }elseif($doc == 'SSPB-DRAFT'){ $stts_bendahara = 'done'; $stts_ppk = 'active'; ?>
		<?php if ($level == '14'): ?>
			<div class="alert alert-danger" style="text-align:center">
			<button type="button" class="btn btn-success" id="setuju" rel="<?php echo $nomor_sspb ?>" data="<?php echo $nomor_trx_spm ?>"><span class="glyphicon glyphicon" aria-hidden="true"></span>SETUJU</button>
			<button type="button" class="btn btn-danger" id="tolak" rel="<?php echo $nomor_sspb ?>" data="<?php echo $nomor_trx_spm ?>"><span class="glyphicon glyphicon-back" aria-hidden="true"></span>TOLAK</button>
		</div>
		<?php endif ?>
		
		<?php }elseif($doc == 'SSPB-DRAFT-PPK'){ $stts_bendahara = 'done'; $stts_ppk = 'done';  $stts_kpa = 'active'; ?>  
			<?php if ($level == '2'): ?>
				<div class="alert alert-danger" style="text-align:center">
				<button type="button" class="btn btn-success" id="setuju" rel="<?php echo $nomor_sspb ?>" data="<?php echo $nomor_trx_spm ?>"><span class="glyphicon glyphicon" aria-hidden="true"></span>SETUJU</button>
				<button type="button" class="btn btn-danger" id="tolak" rel="<?php echo $nomor_sspb ?>" data="<?php echo $nomor_trx_spm ?>"><span class="glyphicon glyphicon-back" aria-hidden="true"></span>TOLAK</button>
			</div>
			<?php endif ?>
		<?php }elseif($doc == 'SSPB-DITOLAK-PPK'){ $stts_bendahara = 'done'; $stts_ppk = 'tolak'; ?>


		<?php }elseif($doc == 'SSPB-DRAFT-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'active';  ?>  
		<?php if ($level == '3'): ?>
		 	<div class="alert alert-danger" style="text-align:center">
			<button type="button" class="btn btn-success" id="setuju" rel="<?php echo $nomor_sspb ?>" data="<?php echo $nomor_trx_spm ?>"><span class="glyphicon glyphicon" aria-hidden="true"></span>SETUJU</button>
			<button type="button" class="btn btn-danger" id="tolak" rel="<?php echo $nomor_sspb ?>" data="<?php echo $nomor_trx_spm ?>"><span class="glyphicon glyphicon-back" aria-hidden="true"></span>TOLAK</button>
		</div>
		 <?php endif ?> 
		
		<?php }elseif($doc == 'SSPB-DITOLAK-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'tolak' ; ?>   

		<?php }elseif($doc == 'SSPB-FINAL-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'active' ?> 
		<?php if ($level == '11'): ?>
		  	<div class="alert alert-danger" style="text-align:center">
			<button type="button" class="btn btn-success" id="setuju" rel="<?php echo $nomor_sspb ?>" data="<?php echo $nomor_trx_spm ?>"><span class="glyphicon glyphicon" aria-hidden="true"></span>SETUJU</button>
			<button type="button" class="btn btn-danger" id="tolak" rel="<?php echo $nomor_sspb ?>" data="<?php echo $nomor_trx_spm ?>"><span class="glyphicon glyphicon-back" aria-hidden="true"></span>TOLAK</button>
		</div>
		  <?php endif ?>  
		<?php }elseif($doc == 'SSPB-DITOLAK-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'tolak'; ?>   

		<?php }elseif($doc == 'SSPB-FINAL-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done'; ?>   
		<?php }elseif($doc == 'SSPB-DITOLAK-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'tolak'; ?>

		<?php } ?>
				
		
		
	</div>
</div>

<div class="modal" id="alasan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="margin-top: 80px;">
		<div class="modal-content" id="modal_content">
		</div>
	</div>
</div>
<div class="modal" id="myModalLihatKet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Perhatian</h4>
      </div>
      <div class="modal-body">
        <p>Alasan penolakan :</p>
        <p>
            <div class="form-group">
            <blockquote>
  <p><?=$ket?></p>
</blockquote>
            </div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


