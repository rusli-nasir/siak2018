<script type="text/javascript">

	
$(document).ready(function(){
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


			$('#jumlah_dana').blur(function () {
			        var val = string_to_angka(this.value);
			 	$("#jumlah_dana").val(val);     			    
			 });

			$('#jumlah_dana').focus(function () {
			        var val = angka_to_string(this.value);
			 	$("#jumlah_dana").val(val);     			    
			 });
		});
			function string_to_angka(str){
				return str.split('.').join("");
			}

			function angka_to_string(num){
				var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
				return str_hasil;
			}

	$('#tanggal_proses').datepicker({
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

		var no_pumk_kembali = $("#nomor_trx_rsa_pumk_kembali").val();
		// alert();
		$("#nomor_trx_rsa_pumk_kembali").val(no_pumk_kembali.replace(no_pumk_kembali.substr(-8,8),bulan_str+"/"+tahun));
		// console.log('ddasda');
	});

	$(document).on("click","#add",function(e){
		if($("#form_uang_kembali").validationEngine("validate")){
			var harga = $("#jumlah_dana").val();
			var nip = $("#nip_pumk").val();
			e.preventDefault();
	         $.ajax({
	             type:"POST",
	             url:"<?=site_url("rsa_pumk/is_cek_harga")?>",
	             data:{ harga: harga, nip : nip},
	             success:function(respon){
	                 if(respon == "true"){
	                    $("#form_uang_kembali").submit();
	                 }else if(respon == "false"){
	                     bootbox.alert({
	                                 title: " <span style='color: red;'>PERHATIAN !!",
	                                 message: "UANG KEMBALI <b>MELEBIHI</b> UANG PANJAR atau <span style='color: red;'><b>DATA TIDAK SESUAI</b>",
	                                 callback: function(){ 
	                                     window.location.reload();
	                                 }
	                             });
	                 }

	             }
	         });
		}
    	
  	});

});

</script>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<div>
					<h2><b>UANG KEMBALI</b></h2><hr>
					<div id="temp" style="display:none"></div>
					<!-- Nav tabs -->

				<!-- Tab panes -->
			
				<!-- form add user -->
				</div>
				<div role="tabpanel" class="tab-pane"  id="uang_kembali">
					<br>
					
					<form id="form_uang_kembali" method="post" action="<?=site_url("rsa_pumk/exec_add_uang_kembali")?>">
						<table class="table-condensed">
							<tbody>
								<?php $level 				= $this->check_session->get_level(); ?>
								<?php  if($level == 13){ ?>
									<tr>
										<td class="col-md-2"><b>Nama Pemberi</b></td>
										<td align="left">
											<input type="text" class="validate[required] form-control" value="" id="nama_pumk" name="nama_pumk" >
										</td>
									</tr>
									<tr>
										<td class="col-md-2"><b>NIP </b></td>
										<td align="left">
											<input type="text" class="validate[required] form-control" value="" id="nip_pumk" name="nip_pumk" >
										</td>
									</tr>
            				<?php } elseif ($level == 4) {?>
            					<tr>
										<td class="col-md-2"><b>Nama Bendahara</b></td>
										<td align="left">
											<input type="text" class="validate[required] form-control" value="<?php echo $bendahara->nm_lengkap?>" id="nama_bendahara" name="nama_bendahara"  readonly="readonly">
										</td>
									</tr>
									<tr>
										<td class="col-md-2"><b>NIP Bendahara</b></td>
										<td align="left">
											<input type="text" class="validate[required] form-control" value="<?php echo $bendahara->nomor_induk ?>" id="nip_ben" name="nip_ben" readonly="readonly" >
										</td>
									</tr>
            				<?php  }?>
							</tbody>	
							<tbody>	
								<tr>
									<td class="col-md-2"><b>Nomor Transaksi</b></td>
									<td align="left">
										<input type="text" class="validate[required] form-control"  value="<?php echo $nomor['pumk'] ?>" id="nomor_trx_rsa_pumk_kembali" name="nomor_trx_rsa_pumk_kembali" readonly="readonly">
									</td>
								</tr><tr>
									<td class="col-md-2"><b>Tanggal</b></td>
									<td align="left">
										<div class="input-group">
											<label class="input-group-addon btn" for="tanggal_proses">
												&nbsp;<span class="glyphicon glyphicon-calendar"></span>
											</label>  
											<input type="text" class="validate[required] form-control readonly" id="tanggal_proses" name="tanggal_proses" required>
										</div>
									</td>
								</tr>
								<tr>
									<td class="col-md-2"><b>Jumlah Dana</b></td>
									<td align="left">
										<input type="text" class="validate[required] form-control xnumber" id="jumlah_dana" name="jumlah_dana">
									</td>
								</tr>
								<tr>
									<td><b>Keterangan</b></td>
									<td align="left">
										<textarea rows="4" cols="50" type="text" class="validate[required] form-control" id="keterangan" name="keterangan" value=""></textarea>
									</td>
								</tr>
								<tr>
									<td align="left" colspan="2">
										<div class="btn-group " >
											<button type="button" class="btn btn-primary btn-sm" id="add" aria-label="Left Align" style="margin-right: 5px;">SIMPAN</button>
											<button type="reset" class="btn btn-warning btn-sm" id="reset" aria-label="Center Align">RESET</button>
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
