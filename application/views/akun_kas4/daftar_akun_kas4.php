<script type="text/javascript">
var status_edit = true;
	$(document).ready(function(){
		//action untuk tambah data program
		$(document).on("click","#add",function(){
		//$("#add").live("click",function(){
			var data=$("#form_add_akun_kas4").serialize();
			data = data+"&kd_kas_2="+$("#kd_kas_2").html()+"&kd_kas_3="+$("#kd_kas_3").html();
			if($("#form_add_akun_kas4").validationEngine("validate")){
				$.ajax({
					url:"<?=site_url("akun_kas4/exec_add_akun_kas4")?>",
					data:data,
					type:"POST",
					success:function(respon){
                 if (respon=="berhasil"){
                         refresh_row();
                 } else {
                         var r = respon; 
                         while (r.search(/<[^>]*>/)!=-1){
                                 r = r.replace(/<[^>]*>/,'');
                         }
                         alert(r);
                 }
					
					}
				})
			}
		})
		
		//action untuk mengambil form ubah data program
		$(document).on("click",".edit",function(){
		//$(".edit").live("click",function(){
			if(status_edit){
				status_edit = false;
				$("#form_add_akun_kas4").validationEngine('hide');
				$("#form_edit_akun_kas4").validationEngine('hide');
				$("#add_akun_kas4").hide();
				
				// RESET CLASS //

			$('tr.alert-success').removeClass('alert-success');
			$('tr.form-horizontal').removeClass('form-horizontal');

			// END RESET CLASS //

			$(this).closest('tr').addClass('alert-success').addClass('form-horizontal');
			
				//cek ada data di temporari atau tidak
				if($("#temp").html()!=""){
					//kembalikan ke semula
					var id_temp = $("#temp td:first").html();
					$("#"+id_temp).html($("#temp").html());
					$("#temp").empty();
				}
				
				var id=$(this).attr("rel");
				var kd_kas_2 = $("#kd_kas_2").html();
				var kd_kas_3 = $("#kd_kas_3").html();
				$("#temp").html($("#"+id).html());
				$("#"+id).html("<td colspan='5' align='center'>Loading..</td>");
				var data= "kd_kas_4="+id+"&kd_kas_2="+kd_kas_2+"&kd_kas_3="+kd_kas_3;
				//load form edit
				$.ajax({
					type:"POST",
					url:"<?=site_url("akun_kas4/get_form_edit")?>",
					data:data,
					success:function(respon){
						$("#"+id).html(respon);
						status_edit = true;
					}
				});
			}
		})
		
		//action untuk membatalkan pengubahan data
		$(document).on("click",".cancel",function(){
		//$(".cancel").live("click",function(){
			$("#form_edit_akun_kas4").validationEngine('hide');
			
			$(this).closest('tr').removeClass('alert-success').removeClass('form-horizontal');
			
			var id=$(this).attr("rel");
			$("#"+id).html($("#temp").html());
			$("#temp").empty();
			$("#add_akun_kas4").show();
		});
		
		$('#reset').click(function(){
			$('#form_add_akun_kas4').validationEngine('hide');
		});
		
		//action untuk mengubah data program
		$(document).on("click",".submit",function(){
		//$(".submit").live("click",function(){
			var kd_kas_2 = $("#kd_kas_2").html();
			var kd_kas_3 = $("#kd_kas_3").html();
			var kd_kas_4 = $(this).attr("rel");
			var nm_kas_4 = $("#"+kd_kas_4+" input.nm_kas_4").val();
			
			//var bidang =$("#bidang").val();
			var data="kd_kas_4="+kd_kas_4+"&nm_kas_4="+nm_kas_4+"&kd_kas_2="+kd_kas_2+"&kd_kas_3="+kd_kas_3;
			if($("#form_edit_akun_kas4").validationEngine('validate')){
				$("#"+kd_kas_4).html("<td colspan='5' align='center'>Loading..</td>");
				$.ajax({
					type:"POST",
					url :"<?=site_url("akun_kas4/exec_edit_akun_kas4")?>",
					data:data,
					success:function(respon){
						$("#"+kd_kas_4).replaceWith(respon);
						$("#temp").empty();
						$("#add_akun_kas4").show();
					}
				})
			}
		});
		
		//action untuk hapus data program
		$(document).on("click",".delete",function(){
		//$(".delete").live("click",function(){
			$("#myModal").load('<?php echo site_url('akun_kas4/confirmation_delete/');?>/' + $("#kd_kas_2").html()  + '/' + $("#kd_kas_3").html()  + '/' + $(this).attr('rel')
			,function(){
				$("#myModal").modal('show');
			}
		);
		
		});
		
		//action untuk filterisasi
		$("#filter_akun_kas4").bind("keyup",function(){
			$("#form_add_akun_kas4").validationEngine('hide');
			$("#form_edit_akun_kas4").validationEngine('hide');
			var keyword = $(this).val();
			var kd_kas_2 = $("#kd_kas_2").html();
			var kd_kas_3 = $("#kd_kas_3").html();
			if (keyword!="- Masukkan kata kunci untuk memfilter data -"){
				$.ajax({
					data 	: "keyword="+keyword+"&kd_kas_2="+kd_kas_2+"&kd_kas_3="+kd_kas_3,
					url 	: "<?=site_url("akun_kas4/filter_akun_kas4")?>",
					type	: "POST",
					success	: function(respon){
						$("#row_space").html(respon);
						$("#add_akun_kas4").show();
					}
				});
			}
		});
		
		$("#filter_akun_kas4").click(function(){
			$(this).val("");
		});
		
		$("#filter_akun_kas4").bind("blur",function(){
			if($(this).val()==''){
				$(this).val("- Masukkan kata kunci untuk memfilter data -");
			};
		})
		
		$("#tampil_semua").click(function(){
			refresh_row();
			$("#add_akun_kas4").show();
		});
	});
	
	function refresh_row(){
		$("#form_add_akun_kas4").validationEngine('hide');
		$("#form_edit_akun_kas4").validationEngine('hide');
		$("#filter_akun_kas4").val("- Masukkan kata kunci untuk memfilter data -");
		$("#row_space").load("<?=site_url("akun_kas4/get_row_akun_kas4")?>/"+$("#kd_kas_2").html()+"/"+$("#kd_kas_3").html());
		$("#add_akun_kas4 input[type='text']").val("");
	}
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
<div class="row">
                    <div class="col-lg-12">
                        <h2>DAFTAR AKUN KAS 4 DIGIT</h2>
                    </div>
                </div>
                <hr />
<div class="debug"></div>
<?php
	$akun_kas = isset($result_akun_kas[0])?$result_akun_kas[0]:'';
	$akun_kas2 = isset($result_akun_kas2[0])?$result_akun_kas2[0]:'';
	$akun_kas3 = isset($result_akun_kas3[0])?$result_akun_kas3[0]:'';
	//var_dump($result_output);
?>
<table class="table table-striped table-bordered">
<tr>
	<td class="col-md-2">NAMA KAS 1 DIGIT</td>
	<td ><span id="kd_kas_2"><?=isset($akun_kas->kode_akun1digit)?$akun_kas->kode_akun1digit:''?></span> - <?=isset($akun_kas->nama_akun1digit)?$akun_kas->nama_akun1digit:''?> [ <a href="<?php echo site_url("akun_kas/daftar_akun_kas/")?>" style="text-decoration:underline">lihat</a> ]</td>
</tr>
<tr>
	<td  class="col-md-2">AKUN KAS 2 DIGIT</td>
	<td ><span id="kd_kas_2"><?=isset($akun_kas2->kode_akun2digit)?$akun_kas2->kode_akun2digit:''?></span> - <?=isset($akun_kas2->nama_akun2digit)?$akun_kas2->nama_akun2digit:''?> [ <a href="<?php echo site_url("akun_kas2/daftar_akun_kas2/".$akun_kas->kode_akun1digit)?>" style="text-decoration:underline">lihat</a> ]</td>
</tr>
<tr>
	<td class="col-md-2">AKUN KAS 3 DIGIT</td>
	<td ><span id="kd_kas_3"><?=isset($akun_kas3->kode_akun3digit)?$akun_kas3->kode_akun3digit:''?></span> - <?=isset($akun_kas3->nama_akun3digit)?$akun_kas3->nama_akun3digit:''?></td>
</tr>
</table>
<div id="temp" style="display:none"></div>
<form id="form_edit_akun_kas4" onsubmit="return false">
<table class="table table-striped table-bordered table-hover">
<thead>
	<tr>
		<th class="col-md-2">Kode Kas 4</th>
		<th class="col-md-9">Nama Kas 4</th>
		<!-- <th class="col-md-1" colspan="2" style="text-align:center">Aksi</th> -->
	</tr>
<!-- 	<tr>
		<th colspan="2" align="center"><input type="text" class="form-control" style="text-align:center" name="filter_akun_kas4" id="filter_akun_kas4" value="- Masukkan kata kunci untuk memfilter data -"></th>
		<th colspan="2" align="center"><input type="button" class="btn btn-default" style="" name="tampil_semua" id="tampil_semua" value="Tampilkan Semua"></th>
	</tr> -->
</thead>
<tbody id="row_space">
<?=isset($row_akun_kas4)?$row_akun_kas4:""?>
</tbody>
</table>
</form>
<!-- <form id="form_add_akun_kas4" onsubmit="return false">
<input type=hidden name=kd_kas_3 id=kd_kas_3_ed value="<?php echo !empty($akun_kas3->kd_kas_3)?$akun_kas3->kd_kas_3:''; ?>" />
<table class="table table-striped">
<tbody>
<tr id="add_akun_kas4">
	<td class="col-md-2">
		<div class="input-group">
         <span class="input-group-addon" id="text-addon"><?php echo !empty($akun_kas3->kd_kas_3)?$akun_kas3->kd_kas_3:'';?></span>
         <input type="text" id="kd_kas_4" class="validate[required,custom[integer],maxSize[1],minSize[1]] form-control" name="kd_kas_4" style="text-align:center"/>
     </div>
	</td>
	<td class="col-md-9"><input name="nm_kas_4" id="nm_kas_4" class="validate[required] form-control" type="text"></td>
	<td align="center" class="col-md-1">
	<div class="btn-group">
				<button type="submit" class="btn btn-default btn-sm" id="add" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
				<button type="reset" class="btn btn-default btn-sm" id="reset" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			</div>
	</td>
</tr>
</tbody>
</table>
</form> -->

</div>
</div>
</div>
</div>
</div>