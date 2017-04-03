<script type="text/javascript">
var status_edit = true;
$(document).ready(function(){
	//action untuk tambah data spm
$(document).on("click","#add",function(){
	//$("#add").live("click",function(){
		var data=$("#form_add_spm").serialize();
		if($("#form_add_spm").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url:"<?=site_url("spm/exec_add_spm")?>",
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
	
	//action untuk mengambil form ubah data spm
$(document).on("click",".edit",function(){
//$(".edit").live('click',function(){
		if(status_edit){
			$("#link_tambah").hide();
			$("#form_edit_spm").validationEngine('hide');
			$("#form_add_spm").validationEngine('hide');
			status_edit = false;
			$("#add_spm").hide();

			// RESET CLASS //

			$('tr.alert-success').removeClass('alert-success');
			$('tr.form-horizontal').removeClass('form-horizontal');

			// END RESET CLASS //

			$(this).closest('tr').addClass('alert-success').addClass('form-horizontal');

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
			var data= "id="+id;
			//load form edit
			$.ajax({
				type:"POST",
				url:"<?=site_url("spm/get_form_edit")?>",
				data:data,
				success:function(respon){
					$("#"+id).html(respon);
					//refres_row();
					status_edit = true;
				}
			});
		}
	});
	
	//action untuk mengubah data spm
$(document).on("click",".submit",function(){
	//$(".submit").live("click",function(){
		var id 	= $(this).attr("rel");
		var tahun 	= $("#tahun").val();
		var tgl_spm			= $("#tgl_spm").val(); 
		var kd_spm			= $("#kd_spm").val();
		var no_spm			= $("#no_spm").val();
		var kode_unit		= $("#kode_unit").val();
		var jumlah			= $("#jumlah").val();
		var penerima		= $("#penerima").val();
		var posisi			= $("#posisi").val();
		var revisi			= $("#revisi").val();
		var status			= $("#status").val();
		var data="id="+id+"&tahun="+tahun+"&tgl_spm="+tgl_spm+"&kd_spm="+kd_spm+"&no_spm="+no_spm+"&kode_unit="+kode_unit+"&jumlah="+jumlah+"&penerima="+penerima+"&posisi="+posisi+"&revisi="+revisi+"&status="+status;
		if($("#form_edit_spm").validationEngine("validate")){
			//$("#"+spm_spmname).html("<td colspan='8' align='center'>Loading..</td>");
			$.ajax({
				type:"POST",
				url :"<?=site_url("spm/exec_edit_spm")?>",
				data:data,
				success:function(respon){
					if (respon=="berhasil"){
						$("#"+spm_spmname).html("<td colspan='8' align='center'>Loading..</td>");
						refresh_row();
						$("#temp").empty();
						$("#add_spm").show();
						$("#link_tambah").show();
					} else {
						var r = respon; 
						while (r.search(/<[^>]*>/)!=-1){
							r = r.replace(/<[^>]*>/,'');
						}
						alert(r);
					}
					//$("#"+spm_spmname).replaceWith(respon);
					
				}
			})
		}
	})
	
	//action untuk membatalkan pengubahan data
$(document).on("click",".cancel",function(){
	//$(".cancel").live("click",function(){
		var id=$(this).attr("rel");
		$("#form_edit_spm").validationEngine('hide');

		$(this).closest('tr').removeClass('alert-success').removeClass('form-horizontal');

		$("#"+id).html($("#temp").html());
		$("#temp").empty();
		$("#add_spm").show();
		$("#link_tambah").show();
	});
	
	$('#reset').click(function(){
		$('#form_add_spm').validationEngine('hide');
	});
	
	//bisa
	//action untuk hapus data spm
$(document).on("click",".delete",function(){
//	$(".delete").live("click",function(){

	$("#myModal").load('<?php echo site_url('spm/confirmation_delete/');?>/' + $(this).attr('rel')
			,function(){
				$("#myModal").modal('show');
			}
		);

		// $.colorbox({
		// 	href: '<?php echo site_url('spm/confirmation_delete/');?>/' + $(this).attr('rel'),
		// 	opacity : 0.65,
		// 	onCleanup:function(){
		// 		refresh_row();
		// 		$("#add_spm").show();
		// 	}
		// });
	})
	
	//bisa
	//action untuk filterisasi
	$("#filter_spm").bind("keyup",function(){
		$("#form_edit_spm").validationEngine('hide');
		$("#form_add_spm").validationEngine('hide');
		var keyword = $(this).val();
		if (keyword!="- Masukkan kata kunci untuk memfilter data -"){
			$.ajax({
				data 	: "keyword="+keyword,
				url 	: "<?=site_url("spm/filter_spm")?>",
				type	: "POST",
				success	: function(respon){
					$("#row_space").html(respon);
					$("#add_spm").show();
				}
			});
		}
	})
	
	$("#filter_spm").click(function(){
		$(this).val("");
	});
	
	$("#filter_spm").bind("blur",function(){
		if($(this).val()==''){
			$(this).val("- Masukkan kata kunci untuk memfilter data -");
		};
	})
	
	$("#tampil_semua").click(function(){
		refresh_row();
		$("#add_spm").show();
	});
	
	
});

function refresh_row(){
	$("#form_edit_spm").validationEngine('hide');
	$("#form_add_spm").validationEngine('hide');
	$("#filter_spm").val("- Masukkan kata kunci untuk memfilter data -");
	$("#row_space").load("<?=site_url('spm/get_row_spm')?>");
	$("#add_spm input[type='text']").val("");
}

function link_tambah(){
	$("#spm_spmname").focus();
}

function aktifkan1(){
	$.ajax({
				type:"POST",
				url:"<?=site_url("spm/aktif")?>",
				data:"",
				success:function(respon){
					refresh_row();
				}
			});
}

function non_aktif1(){
	$.ajax({
				type:"POST",
				url:"<?=site_url("spm/non_aktif")?>",
				data:"",
				success:function(respon){
					refresh_row();
				}
			});
}

function changeunit(){

	var kode = $("#subunit").val();
	$("#spm_spmname").val(kode);

	if(kode.length == '2'){
		$("#level").val('2');
	}
	else if(kode.length == '4'){
		$("#level").val('3');
	}
	else if(kode.length == '6'){
		$("#level").val('4');
	}

	
}



</script>

<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>DAFTAR SPM</h2>    
                    </div>
                </div>
                <hr />
                <div class="col-lg-12 ">
					
                        <div class="alert alert-danger">
                            <p>
								SPM adalah SPP yang telah disetujui
							</p>
                        </div>
                       
                    </div>
                       
			<div id="temp" style="display:none"></div>
              
<table class="table table-striped">
	<thead>
	<tr>
		<th class="col-md-1" >Tahun</th>
		<th class="col-md-1" >Tgl SPM</th>
		<th class="col-md-1" >Kd SPM</th>
		<th class="col-md-2" >No SPM</th>
		<th class="col-md-1" >Kd Unit</th>
		<th class="col-md-1" >Jumlah</th>
		<th class="col-md-1" >Penerima</th>
		<th class="col-md-1" >Posisi</th>
		<th class="col-md-1" >Revisi</th>
		<th class="col-md-1" >Status</th>
		<th class="col-md-1" colspan="2" style="text-align:center">Aksi</th>
	</tr>
	<tr>
		<th colspan="11" align="center"><input type="text" name="filter2" class="form-control" id="filter2" value="- Masukkan kata kunci untuk memfilter data -" style="text-align:center"></th>
		<th colspan="2" align="center"><input type="button" name="tampil_semua" class="btn btn-default" id="tampil_semua" value="Tampilkan Semua"></th>
	</tr>
	</thead>
	<tbody id="row_space">
	<?php //isset($row_tor)?$row_tor:""?>
	</tbody>
</table>


    </div>
  </div>
</div>
				
	    </div>
	  </div>
	  
</div>

