<script type="text/javascript">
var status_edit = true;
$(document).ready(function(){
	//action untuk tambah data spm
$(document).on("click","#add",function(){
	//$("#add").live("click",function(){
		var data=$("#form_add_rsa_unit").serialize();
		if($("#form_add_rsa_unit").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_unit/exec_add_rsa_unit")?>",
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
			$("#form_edit_rsa_unit").validationEngine('hide');
			$("#form_add_rsa_unit").validationEngine('hide');
			status_edit = false;
			$("#add_rsa_unit").hide();

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
		var kode_rsa_unit 	= $(this).attr("rel");
		var kode_unit_kepeg 	= $("#kode_unit_kepeg").val();
		var kode_unit_rba			= $("#kode_unit_rba").val(); 
	
		var data="kode_rsa_unit="+kode_rsa_unit+"&kode_unit_kepeg="+kode_unit_kepeg+"&kode_unit_rba="+kode_unit_rba;
		if($("#form_edit_rsa_unit").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url :"<?=site_url("rsa_unit/exec_edit_rsa_unit")?>",
				data:data,
				success:function(respon){
					if (respon=="berhasil"){
						$("#"+spm_spmname).html("<td colspan='8' align='center'>Loading..</td>");
						refresh_row();
						$("#temp").empty();
						$("#add_rsa_unit").show();
						$("#link_tambah").show();
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
		$('#form_add_rsa_unit').validationEngine('hide');
	});
	
	//bisa
	//action untuk hapus data spm
$(document).on("click",".delete",function(){
	$("#myModal").load('<?php echo site_url('rsa_unit/confirmation_delete/');?>/' + $(this).attr('rel')
			,function(){
				$("#myModal").modal('show');
			}
		);
	})
	
	//bisa
	//action untuk filterisasi
	$("#filter_rsa_unit").bind("keyup",function(){
		$("#form_edit_rsa_unit").validationEngine('hide');
		$("#form_add_rsa_unit").validationEngine('hide');
		var keyword = $(this).val();
		if (keyword!="- Masukkan kata kunci untuk memfilter data -"){
			$.ajax({
				data 	: "keyword="+keyword,
				url 	: "<?=site_url("rsa_unit/filter_rsa_unit")?>",
				type	: "POST",
				success	: function(respon){
					$("#row_space").html(respon);
					$("#add_rsa_unit").show();
				}
			});
		}
	})
	
	$("#filter_rsa_unit").click(function(){
		$(this).val("");
	});
	
	$("#filter_rsa_unit").bind("blur",function(){
		if($(this).val()==''){
			$(this).val("- Masukkan kata kunci untuk memfilter data -");
		};
	})
	
	$("#tampil_semua").click(function(){
		refresh_row();
		$("#add_rsa_unit").show();
	});
	
	
});

function refresh_row(){
	$("#form_edit_rsa_unit").validationEngine('hide');
	$("#form_add_rsa_unit").validationEngine('hide');
	$("#filter_rsa_unit").val("- Masukkan kata kunci untuk memfilter data -");
	$("#row_space").load("<?=site_url('rsa_unit/get_row_rsa_unit')?>");
	$("#add_rsa_unit input[type='text']").val("");
}

function link_tambah(){
	$("#add_rsa_unit").focus();
}
function changeunit(){

	var kode = $("#subunit").val();
	$("#user_username").val(kode);

	if(kode.length == '2'){
		$("#level").val('2');
	}
	else if(kode.length == '4'){
		$("#level").val('3');
	}
	else if(kode.length == '6'){
		$("#level").val('31');
	}

	
}


</script>

<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>DAFTAR IKW</h2>    
                    </div>
                </div>
                <hr />
       
			<div id="temp" style="display:none"></div>
    <a href="<?php echo base_url(); ?>index.php/rsa_ikw/input_rsa_ikw" class="btn btn-default"></i>ISI FORM IKW</a>          
<form id="form_edit_rsa_unit" onsubmit="return false">
<table class="table table-striped">
	<thead>
	<tr >
		<th class="col-md-1" >ID</th>
		<th class="col-md-1" >BULAN</th>
		<th class="col-md-1" >TAHUN</th>
		<th class="col-md-2" >NIP</th>
		<th class="col-md-3" >POT_IKW</th>
		<th class="col-md-1" >BRUTO</th>
		<th class="col-md-1" >PAJAK</th>
		<th class="col-md-1" colspan="2" style="text-align:center">AKSI</th>
	</tr>
	<tr>
		<th colspan="10" align="center"><input type="text" name="filter" class="form-control" id="filter_rsa_unit" value="- Masukkan kata kunci untuk memfilter data -" style="text-align:center"></th>
		<th colspan="2" align="center"><input type="button" name="show_all" class="btn btn-default" id="tampil_semua" value="Tampilkan Semua"></th>
	</tr>
	</thead>
	<tbody id="row_space">
	<?=isset($row_rsa_ikw)?$row_rsa_ikw:""?>
	</tbody>
</table>
</form>



    </div>
  </div>
</div>
				
	    </div>
	  </div>
	  
</div>

