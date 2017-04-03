<script type="text/javascript">
var status_edit = true;
$(document).ready(function(){
	//action untuk tambah data spm
$(document).on("click","#add",function(){
	//$("#add").live("click",function(){
		var data=$("#form_add_rsa_up").serialize();
		if($("#form_add_rsa_up").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_up/exec_add_rsa_up")?>",
				data:data,
				success:function(respon){
					if (respon=="berhasil"){
						//refresh_row();
						url:"<?=site_url("rsa_up/daftar_rsa_up")?>",
					} else {
						var r = respon; 
						while (r.search(/<[^>]*>/)!=-1){
							r = r.replace(/<[^>]*>/,'');
						}
						alert(r);
					}
				}
			});
		}
	})
});
</script>
<div id="page-wrapper" >
<div id="page-inner">
<div id="temp" style="display:none"></div>
<form id="form_add_rsa_up" onsubmit="return false">
<h3 align="center">SURAT PERMINTAAN PEMBAYARAN</h3>
 <h3  align="center">JENIS : UP</h3>
		<table class="table" width="100%">
			<tbody>
					<tr>
					<td><p align="left">
						<b>Nomor:</b> <input type="text" class="validate[required] form-control col-md-1" id="no_up" placeholder="no_up" name="no_up">
						</p>
						<p align="left">
						<b>Tanggal</b>	: <input type="text" value="<?php echo date('Y-m-d');?>" class="validate[required] form-control col-md-1" id="tgl_transaksi" placeholder="tgl_transaksi" name="tgl_transaksi" disabled>
						</p>
						<p align="left">
						<b>Kode Transaksi</b>	: <input type="text" class="validate[required] form-control col-md-1" id="kd_transaksi" placeholder="kd_transaksi" name="kd_transaksi">
						</p>
					</td>
				</tr>
				
				<tr>
					<td>Unit Kerja : <?php echo form_dropdown('kode_unit_kepeg',isset($opt_unit_kepeg)?$opt_unit_kepeg:array(),($this->input->post('kode_unit_kepeg'))?$this->input->post('kode_unit_kepeg'):'-','id="kode_unit_kepeg" class="validate[required] form-control"');?></td>
				</tr>
				
				<tr>
					<td>
						<table border=0>
							<tr>
								<td width='450'></td>
								<td>Kepada Yth.<br>
									<input type="text" class="validate[required] form-control col-md-1" id="kepada" placeholder="kepada" name="kepada">
								</td>
							</tr>
							<tr>
								<td colspan="2">
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p>
										Dengan Berpedoman pada Dokumen RKAT yang telah disetujui oleh MWA, bersama ini kami mengajukan Surat Permintaan Pembayaran sebagai berikut:<br>
										a. Jumlah Pembayaran Yang diminta: Rp.<input type="text" class="validate[required] form-control" id="debet" name="debet"><br>
										b. Untuk Keperluan : <b>Pengisian Uang Persediaan </b><br>
										c. Nama bendahara pengeluaran : <input type="text" class="validate[required] form-control" id="bendahara_bp" name="bendahara_bp"><br>
										d. Alamat	: <input type="text" class="validate[required] form-control" id="alamat" name="alamat"> <br>
										e. No Rekening Bank	: <input type="text" class="validate[required] form-control" id="no_rek" name="no_rek"> <br>
										f. No NPWP	: <input type="text" class="validate[required] form-control" id="npwp" name="npwp"> <br>
									
										Pembayaran sebagaimana tersebut diatas, dibebankan pada pengeluaran dengan uraian sebagai berikut:<br>	
									</p>
								<td>
							</tr>
							
						</table>
						
					</td>
				</tr>
				
				<tr>
					<td>
						SPP Sebagaimana dimaksud diatas, disusun sesuai dengan dokumen lampiran yang persyaratkan dan disampaikan secara bersamaan serta merupakan bagian yang tidak terpisahkan dari surat ini.<br><br>
						
																				
					</td>
				<tr>
				<tr>
					<td>
						<strong>Keterangan:</strong><br>
						<ul>
							<li>Semua bukti Pengeluaran untuk pekerjaan dengan perjanjian yang disahkan Pejabat Pembuat Komitmen telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan diusahakan oleh Pejabat Penatasuahaan Keuangan SUKPA</li>
							<li>
							Semua Bukti-bukti pengeluaran untuk pekerjaan yang disahkan Pejabat dan pengendali Kegiatan (PPPK) telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan SUKPA.
							</li>
							<li>Kebenaran perhitungan dan isi tertuang dalam SPP ini menjadi tanggung Jawab bendahara Pengeluaran sepanjang sesuai dengan bukti-bukti pengeluaran yang telah ditandatangani oleh PPPPK atau PPK</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="alert alert-warning" style="text-align:center">

    	<button type="submit" class="btn btn-lg btn-warning" id="add">Usulkan SPP<span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></button>

  </div>
	</form>


  </div>
	 
	  
</div>


