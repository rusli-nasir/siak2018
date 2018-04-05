<script>
	$('#tgl_sspb').datepicker({
			format: "yyyy-mm-dd"
		}).on('changeDate', function (e) {
		var bulan = new Date(e.date).getMonth() + 1;
		var tahun = String(e.date).split(" ")[3];

		if (bulan == "1") {
			var bulan_str = "JAN";
		}else if (bulan == "2") {
			var bulan_str = "FEB";
		}else if (bulan == "3") {
			var bulan_str = "MAR";
		}else if (bulan == "4") {
			var bulan_str = "APR";
		}else if (bulan == "5") {
			var bulan_str = "MEI";
		}else if (bulan == "6") {
			var bulan_str = "JUN";
		}else if (bulan == "7") {
			var bulan_str = "JUL";
		}else if (bulan == "8") {
			var bulan_str = "AGU";
		}else if (bulan == "9") {
			var bulan_str = "SEP";
		}else if (bulan == "10") {
			var bulan_str = "OKT";
		}else if (bulan == "11") {
			var bulan_str = "NOV";
		}else if (bulan == "12") {
			var bulan_str = "DES";
		}

		var no_sspb = $("#nomor_sspb").val();
		// alert();
		$("#nomor_sspb").val(no_sspb.replace(no_sspb.substr(-8,8),bulan_str+"/"+tahun));
		// console.log('ddasda');
	});

	$("#reset").click(function(){
			$("#lihat_modal").modal('toggle');
		});

	$(document).on("click","#add_modal",function(){
		if($("#form_sspb").validationEngine("validate")){
			var nominal = $("#nominal").val();
			var nominal_pengembalian = $("#nominal_pengembalian").val();
			if (nominal_pengembalian < nominal){
	           $("#form_sspb").submit();            
			}else{
				bootbox.alert({
							title: " <span style='color: red;'>PERHATIAN !!",
							message: "Nominal SSPB lebih besar dari nominal belanja",
							callback: function(){ 
								$("#nominal_pengembalian").focus();
								$("#nominal_pengembalian").css("border", "1.5px solid #f30808");
							}
						});
			}
		}
    	
  	});

  	$(document).on("keyup","input.xnumber",function(event){
			// skip for arrow keys
			if(event.which >= 37 && event.which <= 40) return;
			// format number
			$(this).val(function(index, value) {
				return  value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
				;
			});

			$('#nominal_pengembalian').blur(function () {
			        var val = string_to_angka(this.value);
			 	$("#nominal_pengembalian").val(val);     			    
			 });

			$('#nominal_pengembalian').focus(function () {
			        var val = angka_to_string(this.value);
			 	$("#nominal_pengembalian").val(val);     			    
			 });

		});

		function string_to_angka(str){
			return str.split('.').join("");
		}

		function angka_to_string(num){
			var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			return str_hasil;
		}
	
</script>
<div id="page-inner">
	<div class="row">
		<div class="col-lg-12">
			<h4><b>Form Tambah SSPB</b></h4><hr>
			<div id="temp" style="display:none">
			</div>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active">
					<form id="form_sspb" method="post" action="<?=site_url("rsa_sspb/exec_add_sspb")?>">
						<table class="table-condensed">
							<tbody>
								<tr>
									<td class="col-md-3"><b>Nomor SPM</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control" value="<?php echo $spm ?>" id="nomor_spm" name="nomor_spm" readonly="readonly" >
									</td>
								</tr>
								<tr>
									<td class="col-md-3"><b>Kode Ususlan Belanja</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control" value="<?php echo $data_akun->kode_usulan_belanja ?>" id="kode_usulan_belanja" name="kode_usulan_belanja" readonly="readonly" >
									</td>
								</tr>
								<tr>
									<td><b>Kode Akun Tambah</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control" value="<?php echo $data_akun->kode_akun_tambah ?>" id="kode_akun_tambah" name="kode_akun_tambah" readonly="readonly" >
									</td>
								</tr>
								<tr>
									<td><b>Deskripsi</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control" value="<?php echo $data_akun->deskripsi ?>" id="deskripsi" name="deskripsi" readonly="readonly" >
									</td>
								</tr>
								<tr>
									<td><b>Sumber Dana</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control" value="<?php echo $data_akun->sumber_dana ?>" id="sumber_dana" name="sumber_dana" readonly="readonly" >
									</td>
								</tr>
								<tr>
									<td><b>Nominal Realisasi</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control" value="<?php echo number_format($data_akun->nominal,0,',','.') ?>" id="nominal" name="nominal" readonly="readonly" >
									</td>
								</tr>
								<tr>
									<td class="col-md-2"><b>Tanggal SSPB</b></td>
									<td align="left">
										<div class="input-group">
											<label class="input-group-addon btn" for="tgl_sspb">
												&nbsp;<span class="glyphicon glyphicon-calendar"></span>
											</label>  
											<input type="text" class="validate[required] form-control readonly" id="tgl_sspb" name="tgl_sspb" required>
										</div>
									</td>
								</tr>
								<tr>
									<td><b>Nomor SSPB</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control" value="<?php echo $nomor_sspb ?>" id="nomor_sspb" name="nomor_sspb" readonly="readonly">
									</td>
								</tr>
								<tr>
									<td><b>Nominal Pengembalian</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control xnumber" value="" id="nominal_pengembalian" name="nominal_pengembalian"  >
									</td>
								</tr>
								<tr>
									<td><b>BANK</b></td>
									<td align="left">
										<select style="min-width: 617px;" class="validate[required] form-control" name="bank" id="bank" readonly="readonly">
										<option id="" value="<?php echo $bank['kode_akun'] ?>">
											<?php echo $bank['nama_akun'] ?>
										</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><b>Keterangan</b></td>
									<td align="left">
										<textarea rows="4" cols="50" type="text"  class="validate[required] form-control" id="keterangan" name="keterangan" value=""></textarea>
									</td>
								</tr>
								<tr>
									<td align="left" colspan="2">
										<div class="btn-group " >
											<button type="button" class="btn btn-primary btn-sm" id="add_modal" aria-label="Left Align" style="margin-right: 5px;">SIMPAN</button>
											<button type="reset" class="btn btn-warning btn-sm" id="reset" aria-label="Center Align">BATAL</button>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>