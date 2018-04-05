<script>
	
	$("#cetak").click(function(){
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("#div-cetak").printArea( options );
    });

</script>

<div class="row">
	<div class="col-lg-12">
		<h3><b>CETAK KUITANSI PUMK</b></h3><hr>
		<div id="temp" style="display:none">
		</div>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active">
				<div style="background-color: #EEE;">
					<div id="div-cetak">
						<table id="table" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0">
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
									<td style="border:0px;width: 1%;white-space:nowrap;"></td>
									<td style="border:0px;width: 0.1%;white-space:nowrap;"></td>
								</tr>
								<tr >
									<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
								</tr>
								<tr style="">
									<td colspan="7" style="text-align: center;font-size: 20px;border-bottom: none;border-top: none"><b>UNIVERSITAS DIPONEGORO</b></td>
								</tr>
								<tr style="border-top: none;">
									<td colspan="7" style="text-align: center;font-size: 16px;border-bottom: none;border-top: none;"><b>KUITANSI PEMBERIAN UANG PANJAR</b></td>
								</tr>
								<tr >
									<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
								</tr>
								<tr>
									<td style="border-right: none;">&nbsp;</td>
									<td colspan="2" style="border-right: none;border-left: none;"><b>Tanggal	: <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($data_pumk->tanggal_proses)?'':strftime("%d %B %Y", strtotime($data_pumk->tanggal_proses)); ?></b></td>
									<td style="text-align: center;border-left: none;border-right: none;" colspan="2">&nbsp;</td>
									<td style="border-left: none;border-right: none;"><b>Nomor : <?php echo $data_pumk->nomor_trx_rsa_pumk ?></b></td>
									<td style="border-left: none;border-right: none;">&nbsp;</td>
								</tr>
								<tr >
									<td style="border-right: none;">&nbsp;</td>
									<td style="border-left: none;border-right: none;" colspan="5" ><b>Satuan Unit Kerja Pengguna Anggaran (SUKPA) : <?php echo $data_pumk->nama_subunit ?> </b></td>
									<td style="border-left: none;">&nbsp;</td>
								</tr>
								<tr>
									<td style="border-right: none;">&nbsp;</td>
									<td colspan="2" style="border-right: none;border-left: none;"><b>Unit Kerja :  <?php echo $data_pumk->nama_unit ?></b> </td> 
									<td style="text-align: center;border-left: none;border-right: none;" colspan="2">&nbsp;</td>
									<td style="border-left: none;border-right: none;"><b>Kode Unit Kerja : <?php echo $data_pumk->kode_unit ?> </b></td>
									<td style="border-left: none;">&nbsp;</td>
								</tr>
								<tr >
									<td colspan="7" style="border-bottom: none;border-top: none;">&nbsp;</td>
								</tr>
								<tr >
									<td style="border-right: none;border-bottom: none;border-top: none;">&nbsp;</td>
									<td colspan="5" style="border-bottom: none;border-top: none;border-right: none;border-left: none;">Bendahara Pengeluaran SUKPA memberikan uang panjar sebagai berikut :</td>
									<td style="border-left: none;border-bottom: none;border-top: none;">&nbsp;</td>
								</tr>
								<tr>
									<td style="border-right: none;border-bottom: none;border-top: none;">&nbsp;</td>
									<td colspan="5" style="border-right: none;border-left: none;line-height: 16px;border-bottom: none;border-top: none;">
										<ol style="list-style-type: lower-alpha;margin-top: 0px;margin-bottom: 0px;" >
											<li>Jumlah dana : Rp. <?php echo number_format($data_pumk->jumlah_dana,0,',','.') ?>,-<br>
											&nbsp;&nbsp;&nbsp;( Terbilang : <?=ucwords($terbilang)?> <?php echo substr($terbilang,strlen($terbilang)-6,6) == 'Rupiah' ? '' : 'Rupiah' ; ?> )</li>
											<li>Nama Penerima : <?php echo $data_pumk->nama_pumk ?></li>
											<li>NIP : <?php echo $data_pumk->nomor_induk ?></li>
											<li>Untuk keperluan : <?php echo $data_pumk->keperluan ?></li>
										</ol>
									</td>
									<td style="border-left: none;border-bottom: none;border-top: none;">&nbsp;</td>
								</tr>
								<tr>
									<td style="border-right: none;border-top: none;">&nbsp;</td>
									<td colspan="5" style="line-height: 16px;border-bottom: none;border-top: none;border-left: none;border-right: none;">
										Kuitansi sebagaimana dimaksud diatas, disusun dan disampaikan kepada pengguna/kuasa pengguna anggaran sebagai bukti pemberian uang panjar dari dana uang persediaan bendahara pengeluaran.<br><br>														
									</td>
									<td style="border-left: none;border-bottom: none;border-top: none;">&nbsp;</td>
								</tr>
								<tr>
									<td style="border-right: none;">&nbsp;</td>
									<td colspan="2" style="line-height: 16px;border-right: none;border-left: none;" class="ttd">
										Penerima<br>
										<br>
										<br>
										<br>
										<br>
										<br>
										<span id=""><?php echo $data_pumk->nama_pumk ?></span><br>
										NIP. <span id=""><?php echo $data_pumk->nomor_induk ?></span><br>
									</td>
									<td colspan="2" style="border-right: none;border-left: none;">&nbsp;</td>
									<td colspan="1" style="line-height: 16px;border-left: none;border-right: none;" class="ttd">
										Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($data_pumk->tanggal_proses)?'':strftime("%d %B %Y", strtotime($data_pumk->tanggal_proses)); ?> <br>
										Bendahara Pengeluaran SUKPA<br>
										<br>
										<br>
										<br>
										<br>
										<span id=""><?php echo $bendahara->nm_lengkap ?></span><br>
										NIP. <span id=""><?php echo $bendahara->nomor_induk ?></span><br>
									</td>
									<td style="border-left: none;">&nbsp;</td>
								</tr>
								<tr>
									<td style="border-right: none;">&nbsp;</td>
									<td colspan="5"  style="line-height: 16px;border-right: none;border-left: none">
										<strong>Keterangan:</strong>
										<ul>
											<li>BUKTI PEMBERIAN UANG</li>
										</ul>
									</td>
									<td style="border-left: none;">&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="alert alert-warning" style="text-align:center">
	<button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
</div>
