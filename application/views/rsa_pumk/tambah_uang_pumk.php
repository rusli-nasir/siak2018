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

		var no_pumk = $("#nomor_trx_rsa_pumk").val();
		// alert();
		$("#nomor_trx_rsa_pumk").val(no_pumk.replace(no_pumk.substr(-8,8),bulan_str+"/"+tahun));
		// console.log('ddasda');
	});


	$(document).on("click","#add",function(){
		if($("#form_uang_pumk").validationEngine("validate")){
			var nomor = $("#nomor_trx_rsa_pumk").val();
			
	       $.ajax({
		            type: "POST",
		            url: "<?=site_url("rsa_pumk/is_nomor_pumk")?>",
		            dataType: "json",
		            data: "nomor_trx_rsa_pumk="+nomor,                      
		            success: function(data){
		                if(data.valid){
		          			$("#form_uang_pumk").submit();
		                }else{
		                	$("#nomor_trx_rsa_pumk").focus();
		                	$("#nomor_trx_rsa_pumk").css("border", "1.5px solid #f30808");
		            	}
		            }
		        	});
	   }

   });
	

	$("#username").change(function() {
		var isi = $(this).val();
			set_nomor(isi);
			set_nama_pumk(isi);
	});

	function set_nomor(username){
		var personal = $("#personal").val();
		var pumk = $("#pumk").val();
		if (username == "personal") {
			$("#nomor_trx_rsa_pumk").val(personal);
		}else{
			$("#nomor_trx_rsa_pumk").val(pumk);
		}
	}


	function set_nama_pumk(username){
		var data = "username="+username;
		$.ajax({
			type:"POST",
			url:"<?=site_url('rsa_pumk/get_pumk')?>",
			data:data,
			success:function(respon){
				$("#nama_nip_pumk").html(respon);
			}
		});
	}


});

</script>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<div>
					<h2><b>UANG PANJAR</b></h2><hr>
					<div id="temp" style="display:none"></div>
					<!-- Nav tabs -->

				<!-- Tab panes -->
			
				<!-- form add user -->
				</div>
				<div role="tabpanel" class="tab-pane"  id="uang_pumk">
					<br>
					
					<form id="form_uang_pumk" method="post" action="<?=site_url("rsa_pumk/exec_add_uang_pumk")?>">
						<table class="table-condensed">
							<tbody>
								<tr>
									<td><b>Penerima</b></td>
									<td align="left">
										<select style="min-width: 617px;" class="validate[required] form-control" name="username" id="username">
											<option value=""><=Pilih=></option>
											<option value="personal" style ="color:red">Personal</option>
										<?php foreach ($opt_username as $key => $value): ?>
											<option id="" value="<?php echo $value['username'] ?>">
												<?php echo $value['username'] ?>
											</option>
										<?php endforeach ?>
										</select>
									</td>
								</tr>
							</tbody>	
							<tbody id="nama_nip_pumk">

								<tr>
									<td class="col-md-2"><b>Nama</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control"  id="nama_pumk" name="nama_pumk" >
									</td>
								</tr>
								<tr>
									<td class="col-md-2"><b>NIP</b></td>
									<td align="left">
										<input type="text" class="validate[required]  form-control"  id="nip" name="nip" >
									</td>
								</tr>
							</tbody>
							<tbody>	
								<tr>
									<td class="col-md-2"><b>Nomor Transaksi</b></td>
									<td align="left">
										<input id="personal" style="display: none;" value="<?php echo $nomor['personal']?>"></input>
										<input id="pumk" style="display: none;" value="<?php echo $nomor['pumk'] ?>"></input>
										<input type="text" class="validate[required]  form-control"  id="nomor_trx_rsa_pumk" name="nomor_trx_rsa_pumk" readonly="readonly">
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
										<input type="text" class="validate[required]  form-control xnumber" id="jumlah_dana" name="jumlah_dana">
									</td>
								</tr>
								<tr>
									<td><b>Keperluan</b></td>
									<td align="left">
										<textarea rows="4" cols="50" type="text"  class="validate[required] form-control" id="keperluan" name="keperluan" value=""></textarea>
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
