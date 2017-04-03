<script type="text/javascript">
var status_edit = true;
	$(document).ready(function(){
		//action untuk tambah data output
		$(document).on("click","#add",function(){
		//$("#add").live("click",function(){
			var data=$("#form_add_akun_kas3").serialize();
			data = data+"&kd_kas_2="+$("#kd_kas_2").html();
			if($("#form_add_akun_kas3").validationEngine("validate")){
				$.ajax({
					url:"<?=site_url("akun_kas3/exec_add_akun_kas3")?>",
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
		
		//action untuk mengambil form ubah data output
		$(document).on("click",".edit",function(){
		//$(".edit").live("click",function(){
			if(status_edit){
				status_edit = false;
				$('#form_add_akun_kas3').validationEngine('hide');
				$('#form_edit_akun_kas3').validationEngine('hide');
				$("#add_akun_kas3").hide();
				//cek ada data di temporari atau tidak
				
				// RESET CLASS //

			$('tr.alert-success').removeClass('alert-success');
			$('tr.form-horizontal').removeClass('form-horizontal');

			// END RESET CLASS //
			$(this).closest('tr').addClass('alert-success').addClass('form-horizontal');
			
				if($("#temp").html()!=""){
					//kembalikan ke semula
					var id_temp = $("#temp td:first").html();
					$("#"+id_temp).html($("#temp").html());
					$("#temp").empty();
				}
				
				var id=$(this).attr("rel");
				$("#temp").html($("#"+id).html());
				$("#"+id).html("<td colspan='4' align='center'>Loading..</td>");
				var data= "kd_kas_3="+id+"&kd_kas_2="+$("#kd_kas_2").html();
				//load form edit
				$.ajax({
					type:"POST",
					url:"<?=site_url("akun_kas3/get_form_edit")?>",
					data:data,
					success:function(respon){
						$("#"+id).html(respon);
						status_edit = true;
					}
				});
			}
		})
		
		//action untuk membatalkan pengubahan data
	//	$(".cancel").live("click",function(){
			$(document).on("click",".cancel",function(){
			$('#form_edit_akun_kas3').validationEngine('hide');
                        
			$(this).closest('tr').removeClass('alert-success').removeClass('form-horizontal');
			
			var id=$(this).attr("rel");
			$("#"+id).html($("#temp").html());
			$("#temp").empty();
			$("#add_akun_kas3").show();
		});
		
		$('#reset').click(function(){
			$('#form_add_akun_kas3').validationEngine('hide');
		});
		
		//action untuk mengubah data output
		$(document).on("click",".submit",function(){
		//$(".submit").live("click",function(){
			var kd_kas_2 = $("#kd_kas_2").html();
			var kd_kas_3 = $(this).attr("rel");
			var nm_kas_3 = $("#"+kd_kas_3+" input.nm_kas_3").val();
			var data="kd_kas_3="+kd_kas_3+"&nm_kas_3="+nm_kas_3+"&kd_kas_2="+kd_kas_2;
			if($("#form_edit_akun_kas3").validationEngine('validate')){
				$("#"+kd_kas_3).html("<td colspan='4' align='center'>Loading..</td>");
				$.ajax({
					type:"POST",
					url :"<?=site_url("akun_kas3/exec_edit_akun_kas3")?>",
					data:data,
					success:function(respon){
						$("#"+kd_kas_3).replaceWith(respon);
						$("#temp").empty();
						$("#add_akun_kas3").show();
					}
				})
			};
		});
		
		//action untuk hapus data output
		$(document).on("click",".delete",function(){
		//$(".delete").live("click",function(){
			$("#myModal").load('<?php echo site_url('akun_kas3/confirmation_delete/');?>/' + $("#kd_kas_2").html()  + '/' + $(this).attr('rel')
			,function(){
				$("#myModal").modal('show');
			}
		);
		/*
			var kd_kas_2 = $("#kd_kas_2").html();
			$.colorbox({
				href: '<?php echo site_url('output/confirmation_delete/');?>/' + $(this).attr('rel') +"/" + kd_kas_2,
				opacity : 0.65,
				onCleanup:function(){
					refresh_row();
					$("#add_akun_kas3").show();
				}
			});
			*/
		});
		
		//action untuk filterisasi
		$("#filter_akun_kas3").bind("keyup",function(){
			$('#form_add_akun_kas3').validationEngine('hide');
			$('#form_edit_akun_kas3').validationEngine('hide');
			var keyword = $(this).val();
			var kd_kas_2 = $("#kd_kas_2").html();
			if (keyword!="- Masukkan kata kunci untuk memfilter data -"){
				$.ajax({
					data 	: "keyword="+keyword+"&kd_kas_2="+kd_kas_2,
					url 	: "<?=site_url("akun_kas3/filter_akun_kas3")?>",
					type	: "POST",
					success	: function(respon){
						$("#row_space").html(respon);
						$("#add_akun_kas3").show();
					}
				});
			}
		});
		
		$("#filter_akun_kas3").click(function(){
			$(this).val("");
		});
		
		$("#filter_akun_kas3").bind("blur",function(){
			if($(this).val()==''){
				$(this).val("- Masukkan kata kunci untuk memfilter data -");
			};
		})
		
		$("#tampil_semua").click(function(){
			refresh_row();
			$("#add_akun_kas3").show();
		});
	});
	
	function refresh_row(){
		$('#form_add_akun_kas3').validationEngine('hide');
		$('#form_edit_akun_kas3').validationEngine('hide');
		$("#filter_akun_kas3").val("- Masukkan kata kunci untuk memfilter data -");
		$("#row_space").load("<?=site_url("akun_kas3/get_row_akun_kas3")?>/"+$("#kd_kas_2").html());
		$("#add_akun_kas3 input[type='text']").val("");
	}
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>DAFTAR AKUN KAS 3 DIGIT</h2>
                    </div>
                </div>
                <hr />

<div id="temp" style="display:none"></div>
<?php
	$akun_kas2 = isset($result_akun_kas2[0])?$result_akun_kas2[0]:'';
?>
<table class="table table-striped table-bordered">
<tbody>

<tr>
	<td class="col-md-2">KODE KAS 2 DIGIT</td>
	<td ><span id="kd_kas_2"><?=isset($akun_kas2->kd_kas_2)?$akun_kas2->kd_kas_2:''?></span></td>
</tr>
<tr>
	<td class="col-md-2">NAMA KAS 2 DIGIT</td>

	<td><?=isset($akun_kas2->nm_kas_2)?$akun_kas2->nm_kas_2:''?></td>
</tr>

</tbody>

</table>
<div id="temp" style="display:none"></div>
<form id="form_edit_akun_kas3" onsubmit="return false">
<table class="table table-striped">
<thead>
	<tr>
		<th class="col-md-2">Kode Kas 3</th>
		<th class="col-md-9">Nama Kas 3</th>
		<th class="col-md-1" colspan="2" style="text-align:center">Aksi</th>
	</tr>
	<tr>
		<th colspan="2" align="center"><input type="text" name="filter" class="form-control" id="filter_akun_kas3" value="- Masukkan kata kunci untuk memfilter data -" style="text-align:center"></td>
		<th colspan="2" align="center"><input type="button" class="btn btn-default" name="tampil_semua" id="tampil_semua" value="Tampilkan Semua"></th>
	</tr>
</thead>
<tbody id="row_space">
<?=isset($row_akun_kas3)?$row_akun_kas3:""?>
</tbody>
</table>
</form>
<form id="form_add_akun_kas3" onsubmit="return false">
<input type=hidden name=kd_kas_2 id=kd_kas_2_ed value="<?php echo !empty($akun_kas2->kd_kas_2)?$akun_kas2->kd_kas_2:''; ?>" />
<table class="table table-striped">
<tbody>
<tr id="add_akun_kas3">
	<td class="col-md-2">
		 <div class="input-group">
                        <span class="input-group-addon" id="text-addon"><?php echo !empty($akun_kas2->kd_kas_2)?$akun_kas2->kd_kas_2:'';?></span>
                        <input type="text" id="kd_kas_3" class="validate[required,custom[integer],maxSize[1],minSize[1]] form-control" name="kd_kas_3" style="text-align:center"/>
                    </div>
		
	</td>
	<td class="col-md-9" align="center" ><input type="text" class="validate[required] form-control" id="nm_kas_3" name="nm_kas_3"></td>
	<td align="center" class="col-md-1">
			<div class="btn-group">
				<button type="submit" class="btn btn-default btn-sm" id="add" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
				<button type="reset" class="btn btn-default btn-sm" id="reset" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
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