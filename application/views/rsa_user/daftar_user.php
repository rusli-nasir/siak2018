<script type="text/javascript">
var status_edit = true;

$(document).ready(function(){


	$(document).on("click","#reset_form_verifikator",function(e){
		$('#form_verifikator').validationEngine('hide');
    });


	$("#level").change(function() {
		var isi = $(this).val();
		var namalevel2 = document.getElementById('level').selectedOptions[0].text;
		var aksi = $("#subunit").attr('data-aksi');
		$("#tr-alert-level").hide();
		$("#subunit").css("border", "");
		set_sub_unit(isi,'',aksi);
		if (isi == '2' || isi == '5' || isi == '13' || isi == '14') {
			$("#namalevel").html(namalevel2);
			$("#tr-peringatan-level").show();
			$("#subunit").focus();
		}
	});

$(document).on("change","#level_edit",function(){
		var isi = $(this).val();
		var aksi = $("#subunit_edit").attr('data-aksi');
		// alert(aksi);
		set_sub_unit(isi,'',aksi);

		$("#subunit_edit").focus();
	});

	$("#tr-alert-level").hide();
	$("#tr-peringatan-level").hide();


	$(document).on("submit","#form_add_user,#form_user_edit",function(e){
      var aksi = $(this).attr('data-aksi');
      if (aksi == 'tambah') {
      var namalevel = document.getElementById('level').selectedOptions[0].text;
      var namasukpa = document.getElementById('subunit').selectedOptions[0].text; 
      } 
      // alert(aksi);
      if (aksi == 'tambah') {
      	var level = $('#level').val();
      	var subunit = $('#subunit').val(); 
      }else if (aksi == 'edit') {
      	var level = $('#level_edit').val();
      	var subunit = $('#subunit_edit').val(); 
      }
      if (aksi == 'edit') {
	    		edit();
	    		$("#user_edit_modal").modal('toggle');
	    	}
        if (level == '2' || level == '5' || level == '13' || level == '14') {
        		e.preventDefault();
                //<---- stop submiting the forms
	        $.ajax({
	            type: "POST",
	            url: "<?=site_url("user/is_kpa_unit")?>",
	            dataType: "json",
	            data: "level="+level+"&subunit="+subunit,                      
	            success: function(data){
	                if(data.valid){
	                    if (aksi == 'tambah') {
								tambah();
							}
	                       //<---- submit the forms
	                }else{
                    if (aksi == 'tambah') {
								$("#tr-peringatan-level").hide();
		                	$("#tr-alert-level").show();
		                	$("#nama-level").html(namalevel);
		                	$("#nama-sukpa").html(namasukpa);
		                	$("#subunit").focus();
		                	$("#subunit").css("border", "1.5px solid #f30808");
							}
	            	}
	            }
	        	});
	    	}
	    else{
	    	if (aksi == 'tambah') {
	    		tambah();
	    	}
	    }
    });

	$(document).on("submit","#form_verifikator",function(e){
      var aksi = $(this).attr('data-aksi');
      var verifikator = $('#nama_verifikator').val();
      var unit = $('#unit_verifikator').val();
  		e.preventDefault();
          //<---- stop submiting the forms
     $.ajax({
         type: "POST",
         url: "<?=site_url("user/is_verifikator")?>",
         dataType: "json",
         data: "verifikator="+verifikator+"&unit="+unit,   
         // data: { "email": email, "password": password },                      
         success: function(data){
             if(data.valid){
                 if (aksi == 'tambah') {
						tambah();
					}
             }else{
              if (aksi == 'tambah') {
						edit_verifikator();
					}
         	}
         }
     	});
    });

	$("#user_edit_modal").on("hide.bs.modal",function(){
		var id=$('#close_edit').attr("rel");
		$("#form_edit_user").validationEngine('hide');

		$(this).closest('tr').removeClass('alert-success').removeClass('form-horizontal');

		$("#"+id).html($("#temp").html());
		$("#temp").empty();
		$("#add_user").show();
		$("#link_tambah").show();
	});
	//action untuk tambah data user

	function tambah(){
		var data=$("#form_add_user").serialize();
		if($("#form_add_user").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url:"<?=site_url("user/exec_add_user")?>",
				data:data,
				success:function(respon){
					if (respon=="berhasil"){
						refresh_row();
						bootbox.alert({
						    message: "Data Berhasil Disimpan",
						    animate: false,


						   //  callback: function(){ 
						   //      setTimeout(function() {
									//     // that's enough of that
									//     dialog.modal('hide');
									// }, 10);
						   //  }
						});

						
						// $("#add-simpan").notify("Data berhasil disimpan.", "success");
						


						//redirect('user/daftar_user','refresh');
						
						// alert('data berhasil disimpan');
						// bootbox.alert({
						//     message: "Data Berhasil Disimpan",
						//     callback: function(){ 
						//         window.location.reload();
						//     }
						// });
						// location.reload();
						
						 // window.location = "<?=site_url("user/daftar_user")?>";
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
	}

	function edit_verifikator(){
		var data= $("#form_verifikator").serialize();
		if($("#form_verifikator").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url:"<?=site_url("user/exec_verifikator")?>",
				data:data,
				success:function(respon){
					if (respon=="berhasil"){
						//refresh_row();
						//redirect('user/daftar_user','refresh');    
						bootbox.alert({
							title: "Konfirmasi",
						    message: "Mapping Berhasil Disimpan",
						    animate: false,
						    callback: function(){ 
						        window.location.reload();
						    }
						});
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
	}

	$(document).on("click",".delete_verifikator",function(){
		var data = $(this).val();
		var id = $(this).attr('rel');

	    if (confirm("Apakah yakin menghapus?")) {
	       $.ajax({
				type:"POST",
				url:"<?=site_url("user/exec_verifikator_delete")?>",
				data:"unit="+data,
				success:function(respon){
					if (respon=="berhasil"){
						//refresh_row();
						//redirect('user/daftar_user','refresh');    
						 $('#tr_'+id).remove();
						 // location.reload();
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
	    return false;	
    });


	//action untuk mengambil form ubah data user
	$(document).on("click",".edit",function(){
		if(status_edit){
			$("#link_tambah").hide();
			$("#form_edit_user").validationEngine('hide');
			$("#form_add_user").validationEngine('hide');
			status_edit = false;
			$("#add_user").show();


			//cek ada data di temporari atau tidak
			if($("#temp").html()!=""){
				//kembalikan ke semula
				//var id_temp = $("#temp td:first").html();
				var id_temp = $("#temp td").eq(2).html();;
				$("#"+id_temp).html($("#temp").html());
				$("#temp").empty();
			}

			var id=$(this).attr("rel");
			var kd_unit=$(this).attr("data-unit");
			var aksi = 'edit';
			$("#temp").html($("#"+id).html());
			// $("#"+id).html("<td colspan='8' align='center'>Loading..</td>");
			var data= "user_username="+id;
			//load form edit
			$.ajax({
				type:"POST",
				url:"<?=site_url("user/get_form_edit")?>",
				data:data,
				success:function(respon){
					$("#modal_content").html(respon);
					var isi = $('#level_edit').val();
					set_sub_unit(isi,kd_unit,aksi);
					//refres_row();
					status_edit = true;
				},
				complete:function(){
					$('#user_edit_modal').modal('show');
				}
			});
		}
	});

	//action untuk mengubah data user
function edit (){
		var user_username 	= $("#user_username").val();
		var user_password 	= $("#user_password").val();
		var level 				= $("#level_edit").val();
		var subunit			= $("#subunit_edit").val();
		var aktif			= $("#flag_aktif").val();
		var nm_lengkap		= $("#nm_lengkap").val();
		var nomor_induk		= $("#nomor_induk").val();
		var nama_bank		= $("#nama_bank").val();
		var no_rek			= $("#no_rek").val();
		var npwp			= $("#npwp").val();
		var alamat			= $("#alamat").val();
		var kd_pisah		= $("#kd_pisah").val();
		var data="user_username="+user_username+"&user_password="+user_password+"&level="+level+"&subunit="+subunit+"&flag_aktif="+aktif+"&nm_lengkap="+nm_lengkap+"&nomor_induk="+nomor_induk+"&nama_bank="+nama_bank+"&no_rek="+no_rek+"&npwp="+npwp+"&alamat="+alamat+"&kd_pisah="+kd_pisah;
		if($("#form_edit_user").validationEngine("validate")){
			//$("#"+user_username).html("<td colspan='8' align='center'>Loading..</td>");
			$.ajax({
				type:"POST",
				url :"<?=site_url("user/exec_edit_user")?>",
				data:data,
				success:function(respon){
					if (respon=="berhasil"){
						// $("#"+user_username).html("<td colspan='8' align='center'>Loading..</td>");
						bootbox.alert({
							title: "PESAN",
							message: 'Data "'+user_username+'" berhasil disimpan'
						});
						refresh_row();
						$("#temp").empty();
						$("#add_user").show();
						$("#link_tambah").show();
					} else {
						var r = respon;
						while (r.search(/<[^>]*>/)!=-1){
							r = r.replace(/<[^>]*>/,'');
						}
						alert(r);
					}
					//$("#"+user_username).replaceWith(respon);

				}
			})
		}
	}

	$('#reset').click(function(){
		$('#form_add_user').validationEngine('hide');
	});

	//bisa
	//action untuk hapus data user
$(document).on("click",".delete",function(){

	$("#myModal").load('<?php echo site_url('user/confirmation_delete/');?>' + $(this).attr('rel')
			,function(){
				$("#myModal").modal('show');
			}
		);

		// $.colorbox({
		// 	href: '<?php echo site_url('user/confirmation_delete/');?>/' + $(this).attr('rel'),
		// 	opacity : 0.65,
		// 	onCleanup:function(){
		// 		refresh_row();
		// 		$("#add_user").show();
		// 	}
		// });
	});

	//bisa
	//action untuk filterisasi
	$("#filter_user").bind("keyup",function(){
		$("#form_edit_user").validationEngine('hide');
		$("#form_add_user").validationEngine('hide');
		var keyword = $(this).val();
		if (keyword!="- Masukkan kata kunci untuk memfilter data -"){
			$.ajax({
				data 	: "keyword="+keyword,
				url 	: "<?=site_url("user/filter_user")?>",
				type	: "POST",
				success	: function(respon){
					$("#row_space").html(respon);
					$("#add_user").show();
				}
			});
		}
	});

	$("#filter_user").click(function(){
		$(this).val("");
	});

	$("#filter_user").bind("blur",function(){
		if($(this).val()==''){
			$(this).val("- Masukkan kata kunci untuk memfilter data -");
		};
	});

	$("#tampil_semua").click(function(){
		refresh_row();
		$("#add_user").show();
	});

	function link_tambah(){
		$("#user_username").focus();
	}

	$('#myTabs a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	});

	$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
	  var id = $(e.target).attr("href").substr(1);
	  window.location.hash = id;
	});

	var hash = window.location.hash;
	$('.nav-tabs a[href="' + hash + '"]').tab('show');

});

function refresh_row(){
	$("#form_edit_user").validationEngine('hide');
	$("#form_add_user").validationEngine('hide');
	$("#filter_user").val("- Masukkan kata kunci untuk memfilter data -");
	$("#row_space").load("<?=site_url('user/get_row_user')?>");
	$("#add_user input[type='text']").val("");
}

function aktifkan1(){
	$.ajax({
		type:"POST",
		url:"<?=site_url("user/aktif")?>",
		data:"",
		success:function(respon){
			refresh_row();
		},
		complete:function(){
			// alert('aktifkan selesai');
		}
	});
}

function non_aktif1(){
	$.ajax({
		type:"POST",
		url:"<?=site_url("user/non_aktif")?>",
		data:"",
		success:function(respon){
			refresh_row();
		},
		complete:function(){
			// alert('non aktifkan selesai');
		}
	});
}

function set_sub_unit(isi,kd_unit,aksi){
	// var isi = $(this).val();
	// alert($(this).attr('value'));
	var data = "level="+isi+"&kode_unit="+kd_unit;
	// alert(data);
	var items = [];
	$.ajax({
		type:"POST",
		url:"<?=site_url('user/get_dropdown_unit')?>",
		data:data,
		success:function(respon){
			if (aksi == 'tambah') {
				$("#subunit").html(respon);
			}
			else if (aksi == 'edit') {
				$("#subunit_edit").html(respon);
			}
			
		// 	var obj = JSON.parse(respon);
		// 		$('#subunit').html('');
		// 			$.each(obj, function(i,val){
		// 				items.push(
		// 					'<option value='+i+'>'+val.nama+'</option>'
		// 					);
		// 			});
		// 		$('#subunit').append.apply($('#subunit'), items);					
		}
	});
}

// function set_verifikator(isi){
// 	// var isi = $(this).val();
// 	// alert($(this).attr('value'));
// 	var data = "unit="+isi;
// 	// alert(data);
// 	var items = [];
// 	$.ajax({
// 		type:"POST",
// 		url:"<?=site_url('user/get_dropdown_verifikator')?>",
// 		data:data,
// 		success:function(respon){
// 			if (respon) {
// 				$("#nama_verifikator").html(respon);
// 			}			
// 		}
// 	});
// }


function changeunit(){
			var kode = $("#subunit").val();
			$("#user_username").val(kode);

	}

//action untuk membatalkan pengubahan data


</script>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<div>
					<h2><b>DAFTAR USER</b></h2><hr>
					<div id="temp" style="display:none"></div>
					<!-- Nav tabs -->
					<div class="tab-base">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
							<a href="#daftar_user" aria-controls="daftar_user" role="tab" data-toggle="tab"><b>Daftar User</b></a></li>
							<li role="presentation">
							<a href="#tambah_user" aria-controls="tambah_user" role="tab" data-toggle="tab"><b>Tambah User</b></a></li>
						</ul>
					</div>
					<div class="modal" id="user_edit_modal" tabindex="-1" role="dialog" 
					aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" style="margin-top: 80px;">
							<div class="modal-content" id="modal_content">
							</div>
						</div>
					</div>

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="daftar_user">
						</br>
						<!--
						<div class="col-md-5 col-md-offset-7 alert alert-success" style="text-align: right;">
							<div class="col-md-6">
								<button type="button" style="text-align: center;" class="btn btn-primary col-md-12" name="aktifkan" onclick="aktifkan1();"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> aktifkan semua</button>
							</div>
							<div class="col-md-6">
								<button type="button" style="text-align: center;" class="btn btn-danger col-md-12" name="non_aktif" onclick="non_aktif1();"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> non-aktifkan semua</button>
							</div>
						</div>
						-->
						<form id="form_edit_user" onsubmit="return false" >
							<table class="table table-condensed">	
								<thead>
								<tr height="30px" class="blue-gradient" style="font-size: 16px; color: white;">
									<th class="col-md-6">Unit</th>
									<th class="col-md-2">Level</th>
									<th class="col-md-2">Username</th>
									<!-- <th class="col-md-2">Password</th> -->
									<!-- <th class="col-md-1" style="text-align:center">Aktif</th> -->
									<th class="col-md-2" colspan="2" style="text-align:center">Aksi</th>
								</tr>
								<!--
								<tr>
									<th colspan="5" align="center" ><input type="text" class="form-control" style="text-align:center;" name="filter" id="filter_user" value="- Masukkan kata kunci untuk memfilter data -"></th>
									<th colspan="2" align="center" ><input type="button" class="form-control btn btn-default" name="show_all" style="text-align:center;" id="tampil_semua" value="Tampilkan Semua"></th>
								</tr>
								-->
							</thead>
							<tbody id="row_space">
								<?=isset($row_user)?$row_user:""?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="7">&nbsp;</td>
								</tr>
							</tfoot>
						</table>
					</form>

				<!-- form add user -->
				</div>
				<div role="tabpanel" class="tab-pane"  id="tambah_user">
					<br>
					
					<form id="form_add_user" onsubmit="return false" data-aksi="tambah" >
						<?php
						$level = [''=>'-Pilih Level User-'] + $level;
						?>
						<table class="table-condensed" id="add_user">
							<tbody>
								<tr>
									<td><b>Level</b></td>
									<td align="left">
										<?php echo form_dropdown('level',isset($level)?$level:array(),($this->input->post('level'))?$this->input->post('level'):'-','id="level" class="validate[required] form-control "');?>
									</td>
								</tr>
								<tr id="tr-peringatan-level">
									<td>
									</td>
									<td>
										Dalam setiap sukpa hanya dapat memiliki satu <b><span id="namalevel" style="color: red"></b></span>
									</td>
								</tr>
								<tr>
									<td class="col-md-2"><b>Unit</b></td>
									<td align="left">
										<select style="min-width: 617px;" class="validate[required] form-control" name="subunit" id="subunit" data-aksi="tambah"></select>
									</td>
								</tr>
								<tr id="tr-alert-level">
									<td>
									</td>
									<td>
										Level <b><span id="nama-level" style="color: red"></span></b> sudah ada pada sukpa <b><span id="nama-sukpa" style="color: red"></span></b>
									</td>
								</tr>
								<tr>
									<td><b>Username</b></td>
									<td align="left">
										<input type="text" class="validate[required,minSize[2],maxSize[30]] form-control" id="user_username" name="user_username">
									</td>
								</tr>
								<tr>
									<td><b>Password</b></td>
									<td align="left"><input type="text" class="validate[required] form-control" id="user_password" name="user_password" value=""></td>
								</tr>
								<input type="hidden" class="form-control" id="user_aktif" name="flag_aktif" value="ya">
								<!--
								<tr>
									<td><b>Aktif</b></td>
									<td align="left">
										<?php echo form_dropdown('flag_aktif',isset($aktif)?$aktif:array(),($this->input->post('aktif'))?$this->input->post('aktif'):'-','id="user_aktif" class="validate[required] form-control"');?>
									</td>
								</tr>
								-->
								<tr>
									<td><b>Nama Lengkap</b></td>
									<td align="left"><input type="text" class="form-control" id="nm_lengkap" name="nm_lengkap" value=""></td>
								</tr>
								<tr>
									<td><b>NIP</b></td>
									<td align="left"><input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value=""></td>
								</tr>
								<tr style="display:none;"">
									<td><b>No.Rekening</b></td>
									<td align="left"><input type="text" class="form-control" id="no_rek" name="no_rek" value=""></td>
								</tr>
								<tr style="display:none;"">
									<td><b>NPWP</b></td>
									<td align="left"><input type="text" class="form-control" id="npwp" name="npwp" value=""></td>
								</tr>
								<input type="hidden" class="form-control" id="alamat" name="alamat" value="-">
								<!--
								<tr>
									<td><b>Alamat</b></td>
									<td align="left"><input type="text" class="form-control" id="alamat" name="alamat" value=""></td>
								</tr>
								-->
								<tr>
									<td align="left" colspan="2">
										<div class="btn-group " >
											<button type="submit" class="btn btn-primary btn-sm" id="add-simpan" aria-label="Left Align" style="margin-right: 5px;"">SIMPAN</button>
											<button type="reset" class="btn btn-warning btn-sm" id="reset" aria-label="Center Align">BATAL</button>
										</div>
										
									

										<!-- <input type="submit" class="btn btn-default" name="submit" id="add" value="simpan"> -->
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
</div>
</div>
<!----<tr>
		<td>Kode Unit Pemisah(WR)</td><td align="left">
			<select class="validate[required,minSize[2],maxSize[30]] form-control" id="kd_pisah" name="kd_pisah"></select>
			<input type="hidden" name="kd_pisah_hidden" id="kd_pisah_hidden" value=""/>
		</td>
	</tr>---->
