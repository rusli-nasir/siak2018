<script type="text/javascript">
var status_edit = true;
$(document).ready(function(){
	//action untuk tambah data kegiatan
	$(document).on("click","#add",function(){
	//$("#add").live("click",function(){
		var data=$("#form_add_akun_kas2").serialize();
		if($("#form_add_akun_kas2").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url:"<?=site_url("akun_kas2/exec_add_akun_kas2")?>",
				data:data,
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
			});
		}
	})
	
	//action untuk mengambil form ubah data kegiatan
	$(document).on("click",".edit",function(){
	//$(".edit").live('click',function(){
		if(status_edit){
			$("#form_edit_akun_kas2").validationEngine('hide');
			$("#form_add_akun_kas2").validationEngine('hide');
			status_edit = false;
			$("#add_akun_kas2").hide();
			
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
			$("#temp").html($("#"+id).html());
			$("#"+id).html("<td colspan='4' align='center'>Loading..</td>");
			var data= "kd_kas_2="+id;
			//load form edit
			$.ajax({
				type:"POST",
				url:"<?=site_url("akun_kas2/get_form_edit")?>",
				data:data,
				success:function(respon){
					$("#"+id).html(respon);
					status_edit = true;
				}
			});
		}
	});
	
	//action untuk mengubah data kegiatan
	$(document).on("click",".submit",function(){
	//$(".submit").live("click",function(){
		var kd_kas_2 = $(this).attr("rel");
		var nm_kas_2 = $("#"+kd_kas_2+" input.nm_kas_2").val();
		var data="kd_kas_2="+kd_kas_2+"&nm_kas_2="+nm_kas_2;
		if($("#form_edit_akun_kas2").validationEngine("validate")){
			$("#"+kd_kas_2).html("<td colspan='4' align='center'>Loading..</td>");
			$.ajax({
				type:"POST",
				url :"<?=site_url("akun_kas2/exec_edit_akun_kas2")?>",
				data:data,
				success:function(respon){
					$("#"+kd_kas_2).replaceWith(respon);
					$("#temp").empty();
					$("#add_akun_kas2").show();
				}
			})
		}
	})
	
	//action untuk membatalkan pengubahan data
	$(document).on("click",".cancel",function(){
	//$(".cancel").live("click",function(){
		var id=$(this).attr("rel");
		$("#form_edit_akun_kas2").validationEngine('hide');
		
		$(this).closest('tr').removeClass('alert-success').removeClass('form-horizontal');

		$("#"+id).html($("#temp").html());
		$("#temp").empty();
		$("#add_akun_kas2").show();
	});
	
	$('#reset').click(function(){
		$('#form_add_akun_kas2').validationEngine('hide');
	});
	
	//action untuk hapus data kegiatan
	$(document).on("click",".delete",function(){
	//$(".delete").live("click",function(){


		$("#myModal").load('<?php echo site_url('akun_kas2/confirmation_delete/');?>/' + $(this).attr('rel')
			,function(){
				$("#myModal").modal('show');
			}
		);

		/*

		$.colorbox({
			href: '<?php echo site_url('kegiatan/confirmation_delete/');?>/' + $(this).attr('rel'),
			opacity : 0.65,
			onCleanup:function(){
				refresh_row();
				$("#add_kegiatan").show();
			}
		});

		*/

	})
	
	//action untuk filterisasi
	$("#filter_akun_kas2").bind("keyup",function(){
		$("#form_edit_akun_kas2").validationEngine('hide');
		$("#form_add_akun_kas2").validationEngine('hide');
		var keyword = $(this).val();
		if (keyword!="- Masukkan kata kunci untuk memfilter data -"){
			$.ajax({
				data 	: "keyword="+keyword,
				url 	: "<?=site_url("akun_kas2/filter_akun_kas2")?>",
				type	: "POST",
				success	: function(respon){
					$("#row_space").html(respon);
					$("#add_akun_kas2").show();
				}
			});
		}
	})
	
	$("#filter_akun_kas2").click(function(){
		$(this).val("");
	});
	
	$("#filter_akun_kas2").bind("blur",function(){
		if($(this).val()==''){
			$(this).val("- Masukkan kata kunci untuk memfilter data -");
		};
	})
	
	$("#tampil_semua").click(function(){
		refresh_row();
		$("#add_akun_kas2").show();
	});
});
function refresh_row(){
	$("#form_edit_akun_kas2").validationEngine('hide');
	$("#form_add_akun_kas2").validationEngine('hide');
	$("#filter_akun_kas2").val("- Masukkan kata kunci untuk memfilter data -");
	$("#row_space").load("<?=site_url('akun_kas2/get_row_akun_kas2')?>");
	$("#add_akun_kas2 input[type='text']").val("");
}
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">

                <div class="row">
                    <div class="col-lg-12">
                        <h2>DAFTAR AKUN ASET</h2>    
                    </div>
                </div>
                <hr />
<div id="temp" style="display:none"></div>
<?php
	$akun_kas = isset($result_akun_kas[0])?$result_akun_kas[0]:'';
?>
<table class="table table-striped table-bordered">
<tbody>

<tr>
	<td class="col-md-2">KODE KAS 1 DIGIT</td>
	<td ><span id="kd_kas_2"><?=isset($akun_kas->kode_akun1digit)?$akun_kas->kode_akun1digit:''?></span></td>
</tr>
<tr>
	<td class="col-md-2">NAMA KAS 1 DIGIT</td>

	<td><?=isset($akun_kas->nama_akun1digit)?$akun_kas->nama_akun1digit:''?></td>
</tr>

</tbody>

</table>
<div id="temp" style="display:none"></div>
<form id="form_edit_akun_kas2" onsubmit="return false">
<table class="table table-striped table-bordered table-hover">
    <thead>
	<tr >
		<th class="col-md-1" >Kode 2</th>
		<th class="col-md-10" >Nama Kode 2</th>
		<!-- <th class="col-md-1" colspan="2" style="text-align:center">Aksi</th> -->
	</tr>
<!-- 	<tr>
		<th colspan="2" align="center"><input type="text" name="filter" class="form-control" id="filter_akun_kas2" value="- Masukkan kata kunci untuk memfilter data -" style="text-align:center"></th>
		<th colspan="2" align="center"><input type="button" name="show_all" class="btn btn-default" id="tampil_semua" value="Tampilkan Semua"></th>
	</tr> -->
	</thead>
	<tbody id="row_space">
	<?=isset($row_akun_kas2)?$row_akun_kas2:""?>
	</tbody>
</table>
</form>
<!-- <form id="form_add_akun_kas2" onsubmit="return false">
<table class="table table-striped">
<tbody>
	<tr id="add_akun_kas2">
		<td class="col-md-1"><input type="text" class="validate[required,maxSize[2],minSize[2],custom[integer]] form-control" id="kd_kas_2" name="kd_kas_2"></td>
		<td class="col-md-10"><input type="text" class="validate[required] form-control" id="nm_kas_2" name="nm_kas_2"></td>
		<td align="center" class="col-md-1">
			<div class="btn-group">
				<button type="submit" class="btn btn-default btn-sm" id="add" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
				<button type="reset" class="btn btn-default btn-sm" id="reset" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			</div>
			<input type="submit" class="btn btn-default" name="submit" id="add" value="simpan">
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