<script type="text/javascript">
var status_edit = true;
$(document).ready(function(){
	//action untuk tambah data user
$(document).on("click","#add",function(){
		var data=$("#form_add_user").serialize();
		if($("#form_add_user").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url:"<?=site_url("user/exec_add_user")?>",
				data:data,
				success:function(respon){
					if (respon=="berhasil"){
						//refresh_row();
						//redirect('user/daftar_user','refresh');
						 window.location = "<?=site_url("user/daftar_user")?>";
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
	});

	//action untuk mengambil form ubah data user
$(document).on("click",".edit",function(){
		if(status_edit){
			$("#link_tambah").hide();
			$("#form_edit_user").validationEngine('hide');
			$("#form_add_user").validationEngine('hide');
			status_edit = false;
			$("#add_user").hide();


			//cek ada data di temporari atau tidak
			if($("#temp").html()!=""){
				//kembalikan ke semula
				//var id_temp = $("#temp td:first").html();
				var id_temp = $("#temp td").eq(2).html();;
				$("#"+id_temp).html($("#temp").html());
				$("#temp").empty();
			}

			var id=$(this).attr("rel");
			$("#temp").html($("#"+id).html());
			$("#"+id).html("<td colspan='8' align='center'>Loading..</td>");
			var data= "user_username="+id;
			//load form edit
			$.ajax({
				type:"POST",
				url:"<?=site_url("user/get_form_edit")?>",
				data:data,
				success:function(respon){
					$("#"+id).html(respon);
					set_sub_unit();
					//refres_row();
					status_edit = true;
				}
			});
		}
	});

	//action untuk mengubah data user
$(document).on("click",".submit",function(){
		var user_username 	= $("#user_username").val();
		var user_password 	= $("#user_password").val();
		var level			= $("#level").val();
		var subunit			= $("#subunit").val();
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
						$("#"+user_username).html("<td colspan='8' align='center'>Loading..</td>");
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
	})

	//action untuk membatalkan pengubahan data
$(document).on("click",".cancel",function(){
		var id=$(this).attr("rel");
		$("#form_edit_user").validationEngine('hide');

		$(this).closest('tr').removeClass('alert-success').removeClass('form-horizontal');

		$("#"+id).html($("#temp").html());
		$("#temp").empty();
		$("#add_user").show();
		$("#link_tambah").show();
	});

	$('#reset').click(function(){
		$('#form_add_user').validationEngine('hide');
	});

	//bisa
	//action untuk hapus data user
$(document).on("click",".delete",function(){

	$("#myModal").load('<?php echo site_url('user/confirmation_delete/');?>/' + $(this).attr('rel')
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

	function refresh_row(){
		$("#form_edit_user").validationEngine('hide');
		$("#form_add_user").validationEngine('hide');
		$("#filter_user").val("- Masukkan kata kunci untuk memfilter data -");
		$("#row_space").load("<?=site_url('user/get_row_user')?>");
		$("#add_user input[type='text']").val("");
	}

	function link_tambah(){
		$("#user_username").focus();
	}

	function aktifkan1(){
		$.ajax({
					type:"POST",
					url:"<?=site_url("user/aktif")?>",
					data:"",
					success:function(respon){
						refresh_row();
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
					}
				});
	}

	

	$('#myTabs a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	});

	$('#myTabs a[href="#tambah_user"]').tab('show')
	$('#myTabs a:first').tab('show')
	$('#myTabs a:last').tab('show')
	$('#myTabs li:eq(2) a').tab('show')

});

function set_sub_unit(){
	var subunit= $('#subunit').val();
	var kd_pisah= $('#kd_pisah_hidden').val();
	// alert(subunit);
	// return false;
	$.ajax({
		type: 'POST',
		data: "subunit="+subunit+'&kd_pisah='+kd_pisah,
		url: '<?php echo site_url('user/load_subunit'); ?>',
		success: function(result) {
			$('#kd_pisah').html(result);
		}
	});
}
function changeunit(){

			var kode = $("#subunit").val();
			$("#user_username").val(kode);

			

	}

</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
  <div>
<h2>DAFTAR USER</h2><hr>
<div id="temp" style="display:none"></div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#daftar_user" aria-controls="daftar_user" role="tab" data-toggle="tab">Daftar User</a></li>
    <li role="presentation"><a href="#tambah_user" aria-controls="tambah_user" role="tab" data-toggle="tab">Tambah User</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="daftar_user">
        <br />
	<div class="col-md-6 col-md-offset-6 alert alert-warning" style="text-align: right;">

			<button type="button" class="btn btn-success" name="aktifkan" onclick="aktifkan1();"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> aktifkan semua</button>
			<button type="button" class="btn btn-info" name="non_aktif" onclick="non_aktif1();"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> non-aktifkan semua</button>
			</div>
			<form id="form_edit_user" onsubmit="return false">
			<table class="table table-condensed">	<thead>
				<tr height="30px">
					<th class="col-md-2">Unit</th>
					<th class="col-md-3">Level</th>
					<th class="col-md-3">Username</th>
					<th class="col-md-1">Password</th>
					<th class="col-md-1" style="text-align:center">Aktif</th>
					<th class="col-md-2" colspan="2" style="text-align:center">Aksi</th>
				</tr>
				<tr>
					<th colspan="5" align="center" ><input type="text" class="form-control" style="text-align:center;" name="filter" id="filter_user" value="- Masukkan kata kunci untuk memfilter data -"></th>
					<th colspan="2" align="center" ><input type="button" class="form-control btn btn-default" name="show_all" style="text-align:center;" id="tampil_semua" value="Tampilkan Semua"></th>
				</tr>
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

	</div>
    <div role="tabpanel" class="tab-pane" id="tambah_user">
			<form id="form_add_user" onsubmit="return false">
<?php
$opt_subunit = [''=>'-pilih-'] + $opt_subunit;
//echo '<pre>';var_dump($opt_subunit);echo '</pre>';die;
?>

<table class="table-condensed" id="add_user">
<tbody>
	<tr>
		<td class="col-md-2">Unit</td><td align="left">
		<?php echo form_dropdown('subunit',isset($opt_subunit)?$opt_subunit:array(),($this->input->post('subunit'))?$this->input->post('subunit'):'-','id="subunit" class="validate[required] form-control"');?></td>
	</tr>
	
	<tr>
		<td>Level</td><td align="left"><?php echo form_dropdown('level',isset($level)?$level:array(),($this->input->post('level'))?$this->input->post('level'):'-','id="level" class="validate[required] form-control"');?></td>

	</tr>
	<tr>
		<td>Username</td><td align="left">
			<input type="text" class="validate[required,minSize[2],maxSize[30]] form-control" id="user_username" name="user_username">
		</td>
	</tr>
	<tr>
		<td>Password</td><td align="left"><input type="text" class="validate[required] form-control" id="user_password" name="user_password" value=""></td>
	</tr>
	<tr>
		<td>Aktif</td><td align="left"><?php echo form_dropdown('flag_aktif',isset($aktif)?$aktif:array(),($this->input->post('aktif'))?$this->input->post('aktif'):'-','id="user_aktif" class="validate[required] form-control"');?></td>
	</tr>
	<tr>
		<td>Nama Lengkap</td><td align="left"><input type="text" class="form-control" id="nm_lengkap" name="nm_lengkap" value=""></td>
	</tr>
	<tr>
		<td>NIP</td><td align="left"><input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value=""></td>
	</tr>
	<tr>
		<td>No.Rekening</td><td align="left"><input type="text" class="form-control" id="no_rek" name="no_rek" value=""></td>
	</tr>
	<tr>
		<td>NPWP</td><td align="left"><input type="text" class="form-control" id="npwp" name="npwp" value=""></td>
	</tr>
	<tr>
		<td>Alamat</td><td align="left"><input type="text" class="form-control" id="npwp" name="npwp" value=""></td>
	</tr>
	<tr>
		<td align="left" colspan="2">
			<div class="btn-group">
				<button type="submit" class="btn btn-success btn-sm" id="add" aria-label="Left Align">SIMPAN</button>
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
