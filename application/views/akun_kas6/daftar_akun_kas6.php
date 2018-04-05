<script type="text/javascript">
var status_edit = true;
	$(document).ready(function(){
		$(document).on("click","#add",function(){
		//action untuk tambah data subkomponen
		//$("#add").live("click",function(){
			var data=$("#form_add_akun_kas6").serialize();
			data = data+"&kd_kas_2="+$("#kd_kas_2").html()+"&kd_kas_3="+$("#kd_kas_3").html()+"&kd_kas_4="+$("#kd_kas_4").html()+"&kd_kas_5="+$("#kd_kas_5").html();
			if($("#form_add_akun_kas6").validationEngine("validate")){
				$.ajax({
					url:"<?=site_url("akun_kas6/exec_add_akun_kas6")?>",
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
		
		//action untuk mengambil form ubah data subkomponen
		$(document).on("click",".edit",function(){
		//$(".edit").live("click",function(){
                        
                
			if(status_edit){
				status_edit = false;
				$('#form_edit_akun_kas6').validationEngine('hide');
				$('#form_add_akun_kas6').validationEngine('hide');
				$("#add_akun_kas6").hide();
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
				var kd_kas_4 = $("#kd_kas_4").html();
				var kd_kas_5 = $("#kd_kas_5").html();
				$("#temp").html($("#"+id).html());
				$("#"+id).html("<td colspan='7' align='center'>Loading..</td>");
				var data= "kd_kas_6="+id+"&kd_kas_2="+kd_kas_2+"&kd_kas_3="+kd_kas_3+"&kd_kas_4="+kd_kas_4+"&kd_kas_5="+kd_kas_5;
				//load form edit
				$.ajax({
					type:"POST",
					url:"<?=site_url("akun_kas6/get_form_edit")?>",
					data:data,
					success:function(respon){
						$("#"+id).html(respon);
                                                
                                                
                                                    $.ajax({
                                                                type:"POST",
                                                                url :"<?=site_url("akun_kas6/get_nominal")?>",
                                                                data:'kd_akun_kas=' + id,
                                                                success:function(respon){
                                                                        $('.form_nominal_akun').text(angka_to_string(respon));
                                                                }
                                                        });
                                                
						status_edit = true;
					}
				});
                                
                                
                                
			}
		})
		
		//action untuk membatalkan pengubahan data
		$(document).on("click",".cancel",function(){
		//$(".cancel").live("click",function(){
			$('#form_edit_akun_kas6').validationEngine('hide');
                        
                        $(this).closest('tr').removeClass('alert-success').removeClass('form-horizontal');
                        
			var id=$(this).attr("rel");
			$("#"+id).html($("#temp").html());
			$("#temp").empty();
			$("#add_akun_kas6").show();
		});
		
		$('#reset').click(function(){
			$('#form_add_akun_kas6').validationEngine('hide');
		});
		
		//action untuk mengubah data subkomponen
		$(document).on("click",".submit",function(){
		//$(".submit").live("click",function(){
			var kd_kas_5 = $("#kd_kas_5").html();
			var kd_kas_2 = $("#kd_kas_2").html();
			var kd_kas_4 = $("#kd_kas_4").html();
			var kd_kas_3 = $("#kd_kas_3").html();
			var kd_kas_6 = $(this).attr("rel");
			var nm_kas_6 = $("#"+kd_kas_6+" input.nm_kas_6").val();
			var nominal_kas_6 = $("#"+kd_kas_6+" input.nominal_kas_6").val();
			var data="kd_kas_6="+kd_kas_6+"&nm_kas_6="+nm_kas_6+"&kd_kas_2="+kd_kas_2+"&kd_kas_3="+kd_kas_3+"&kd_kas_4="+kd_kas_4+"&kd_kas_5="+kd_kas_5+"&nominal="+nominal_kas_6;
			if($("#form_edit_akun_kas6").validationEngine('validate')){
				$("#"+kd_kas_6).html("<td colspan='7' align='center'>Loading..</td>");
				$.ajax({
					type:"POST",
					url :"<?=site_url("akun_kas6/exec_edit_akun_kas6")?>",
					data:data,
					success:function(respon){
						$("#"+kd_kas_6).replaceWith(respon);
						$("#temp").empty();
						$("#add_akun_kas6").show();
					}
				});
			}
		});
                
                $(document).on("click","#btn-nominal",function(){
                    var kd_akun_kas = $(this).attr('rel');
                    $('#kd_akun_kas').val(kd_akun_kas);
//                    $.ajax({
//                            type:"POST",
//                            url :"<?=site_url("akun_kas6/get_nominal")?>",
//                            data:'kd_akun_kas=' + kd_akun_kas,
//                            success:function(respon){
                                    $('#nominal').val('0');
                                    $('#myModalKas').modal('show');
//                            }
//                    });
                });
                
                $(document).on("click","#btn-proses",function(){
                    if($("#nominal").validationEngine('validate')){
                        var kd_akun_kas = $('#kd_akun_kas').val();
                        var nominal = $('#nominal').val();
                        $.ajax({
                                type:"POST",
                                url :"<?=site_url("akun_kas6/tambah_nominal")?>",
                                data:'kd_akun_kas=' + kd_akun_kas + '&nominal=' + nominal,
                                success:function(respon){
                                        if(respon == 'sukses'){
                                            location.reload();
                                        }
                                }
                        });    
                    }
                });
                
                $('.nominal_akun').each(function(){
                    var kd_akun_kas = $(this).attr('rel');
                    var el = $(this);
                    $.ajax({
                                type:"POST",
                                url :"<?=site_url("akun_kas6/get_nominal")?>",
                                data:'kd_akun_kas=' + kd_akun_kas,
                                success:function(respon){
                                        el.text(angka_to_string(respon));
                                }
                        });
                });
                
                $('#myModalKas').on('hidden.bs.modal', function (e) {
                    $(".nominalformError").hide();
                  })
                
		
		//action untuk hapus data subkomponen
		$(document).on("click",".delete",function(){
		//$(".delete").live("click",function(){
			$("#myModal").load('<?php echo site_url('akun_kas6/confirmation_delete/');?>/'  + $("#kd_kas_2").html()  + '/' + $("#kd_kas_3").html()  + '/' + $("#kd_kas_4").html() + '/' + $("#kd_kas_5").html() + '/' + $(this).attr('rel')
			,function(){
				$("#myModal").modal('show');
			}
		);
		/*
			var kd_kas_5 	= $("#kd_kas_5").html();
			var kd_kas_2 	= $("#kd_kas_2").html();
			var kd_kas_3 	= $("#kd_kas_3").html();
			var kd_kas_4 	= $("#kd_kas_4").html();
			$.colorbox({
				href: '<?php echo site_url('subkomponen_input/confirmation_delete/');?>/' + $(this).attr('rel')+"/" + kd_kas_5 +"/" +kd_kas_3+"/" + kd_kas_2,
				opacity : 0.65,
				onCleanup:function(){
					refresh_row();
					$("#add_akun_kas6").show();
				}
			}); */
		});
		
		//action untuk filterisasi
		$("#filter_akun_kas6").bind("keyup",function(){
			$('#form_add_akun_kas6').validationEngine('hide');
			$('#form_edit_akun_kas6').validationEngine('hide');
			var keyword = $(this).val();
			var kd_kas_2 = $("#kd_kas_2").html();
			var kd_kas_5 = $("#kd_kas_5").html();
			var kd_kas_3 = $("#kd_kas_3").html();
			var kd_kas_4 = $("#kd_kas_4").html();
			if (keyword!="- Masukkan kata kunci untuk memfilter data -"){
				$.ajax({
					data 	: "keyword="+keyword+"&kd_kas_2="+kd_kas_2+"&kd_kas_3="+kd_kas_3+"&kd_kas_4="+kd_kas_4+"&kd_kas_5="+kd_kas_5,
					url 	: "<?=site_url("akun_kas6/filter_akun_kas6")?>",
					type	: "POST",
					success	: function(respon){
						$("#row_space").html(respon);
						$("#add_akun_kas6").show();
					}
				});
			}
		});
		
		$("#filter_akun_kas6").click(function(){
			$(this).val("");
		});
		
		$("#filter_akun_kas6").bind("blur",function(){
			if($(this).val()==''){
				$(this).val("- Masukkan kata kunci untuk memfilter data -");
			};
		})
		
		$("#tampil_semua").click(function(){
			refresh_row();
			$("#add_akun_kas6").show();
		});
                
                $(document).on("focusout","input.xnumber",function(){

//                    var kode_usulan_belanja = $(this).attr('rel');

                        if($(this).val()==''){
                                $(this).val('0');

                        }
                        else{
                                var str = $(this).val();
                                $(this).val(string_to_angka(str));

//                                calcinput(kode_usulan_belanja);

                                //alert(str);
                                //$(this).val(str);
                        }

                });
                
                $(document).on("focusin","input.xnumber",function(){

//                    var kode_usulan_belanja = $(this).attr('rel');

                        if($(this).val()=='0'){
                                $(this).val('');
                        }
                        else{
                                var str = $(this).val();
                                $(this).val(angka_to_string(str));
                        }

                });
                
                    $(document).on("keyup","input.xnumber",function(event){

                        // skip for arrow keys
                        if(event.which >= 37 && event.which <= 40) return;

                        // format number
                        $(this).val(function(index, value) {
                            return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                            ;
                        });
                    });
                    
	});
	
	function refresh_row(){
		$('#form_add_akun_kas6').validationEngine('hide');
		$('#form_edit_akun_kas6').validationEngine('hide');
		$("#filter_akun_kas6").val("- Masukkan kata kunci untuk memfilter data -");
		var kd_akun5d = $("#kd_kas_5").html();
		// alert(kd_akun5d);
		$("#row_space").load("<?=site_url("akun_kas6/get_row_akun_kas6")?>/" + kd_akun5d);
		$("#add_akun_kas6 input[type='text']").val("");
	}
        
        function string_to_angka(str){


                return str.split('.').join("");

        }

function angka_to_string(num){

        var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        return str_hasil;
}
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
<div class="row">
                    <div class="col-lg-12">
                        <h2>DAFTAR AKUN KAS 6 DIGIT</h2>
                    </div>
                </div>
                <hr />
<div class="debug"></div>
<?php
	$akun_kas = isset($result_akun_kas[0])?$result_akun_kas[0]:'';
	$akun_kas2 	= isset($result_akun_kas2[0])?$result_akun_kas2[0]:'';
	$akun_kas3 	= isset($result_akun_kas3[0])?$result_akun_kas3[0]:'';
	$akun_kas4 	= isset($result_akun_kas4[0])?$result_akun_kas4[0]:'';
	$akun_kas5 	= isset($result_akun_kas5[0])?$result_akun_kas5[0]:'';
?>
<table class="table table-striped table-bordered"> 
<tr>
	<td class="col-md-2">NAMA KAS 1 DIGIT</td>
	<td ><span id="kd_kas_2"><?=isset($akun_kas->kode_akun1digit)?$akun_kas->kode_akun1digit:''?></span> - <?=isset($akun_kas->nama_akun1digit)?$akun_kas->nama_akun1digit:''?> [ <a href="<?php echo site_url("akun_kas/daftar_akun_kas/")?>" style="text-decoration:underline">lihat</a> ]</td>
</tr>
<tr>
	<td class="col-md-2">AKUN KAS 2 DIGIT</td>
	<td><span id="kd_kas_2"><?=isset($akun_kas2->kode_akun2digit)?$akun_kas2->kode_akun2digit:''?></span> - <?=isset($akun_kas2->nama_akun2digit)?$akun_kas2->nama_akun2digit:''?> [ <a href="<?php echo site_url("akun_kas2/daftar_akun_kas2/".substr($akun_kas2->kode_akun2digit,0,1))?>" style="text-decoration:underline">lihat</a> ]</td>
</tr>
<tr>
	<td class="col-md-2">AKUN KAS 3 DIGIT</td>
	<td><span id="kd_kas_3"><?=isset($akun_kas3->kode_akun3digit)?$akun_kas3->kode_akun3digit:''?></span> - <?=isset($akun_kas3->nama_akun3digit)?$akun_kas3->nama_akun3digit:''?> [ <a href="<?php echo site_url("akun_kas3/daftar_akun_kas3/".$akun_kas2->kode_akun2digit)?>" style="text-decoration:underline">lihat</a> ]</td>
</tr>
<tr>
	<td class="col-md-2">AKUN KAS 4 DIGIT</td>
	<td><span id="kd_kas_4"><?=isset($akun_kas4->kode_akun4digit)?$akun_kas4->kode_akun4digit:''?></span> - <?=isset($akun_kas4->nama_akun4digit)?$akun_kas4->nama_akun4digit:''?> [ <a href="<?php echo site_url("akun_kas4/daftar_akun_kas4/".$akun_kas3->kode_akun3digit)?>" style="text-decoration:underline">lihat</a> ]</td>
</tr>
<tr>
	<td class="col-md-2">AKUN KAS 5 DIGIT</td>
	<td><span id="kd_kas_5"><?=isset($akun_kas5->kode_akun5digit)?$akun_kas5->kode_akun5digit:''?></span> - <?=isset($akun_kas5->nama_akun5digit)?$akun_kas5->nama_akun5digit:''?></td>
</tr>
</table>
<div id="temp" style="display:none"></div>
<form id="form_edit_akun_kas6" onsubmit="return false">
<table class="table table-striped table-bordered table-hover">
<thead>
	<tr>
		<th class="col-md-2">Kode</th>
		<th class="col-md-6">Nama Akun Kas 6</th>
      <th class="col-md-2" style="text-align: center">Saldo</th>
<!--       <th class="col-md-1" style="text-align: center">&nbsp;</th> -->
		<th class="col-md-1" colspan="2" style="text-align:center">Aksi</th>
	</tr>
<!-- 	<tr>
		<th colspan="3" align="center"><input type="text" class="form-control" style="text-align:center" name="filter_akun_kas6" id="filter_akun_kas6" value="- Masukkan kata kunci untuk memfilter data -"></th>
		<th align="center" colspan="2"><input type="button" class="form-control" name="tampil_semua" id="tampil_semua" value="Tampilkan Semua"></th>
	</tr> -->
</thead>
<tbody id="row_space">
<?=isset($row_akun_kas6)?$row_akun_kas6:""?>
</tbody>
</table>
</form>
<!-- <form id="form_add_akun_kas6" onsubmit="return false">
<input type=hidden name=kd_kas_5 id=kd_kas_5_ed value="<?php echo !empty($akun_kas5->kd_kas_5)?$akun_kas5->kd_kas_5:''; ?>" />
<table  class="table table-striped">
<tbody>
<tr id="add_akun_kas6">
	<td class="col-md-2">
		<div class="input-group">
                        <span class="input-group-addon" id="text-addon"><?php echo !empty($akun_kas5->kd_kas_5)?$akun_kas5->kd_kas_5:'';?></span>
                        <input type="text" id="kd_kas_6" class="validate[required,custom[integer],maxSize[1],minSize[1]] form-control" name="kd_kas_6" style="text-align:center"/>
                    </div>
	</td>
        <td class="col-md-8"><input name="nm_kas_6" id="nm_kas_6" class="validate[required] form-control" type="text"><input name="nominal_kas_6" type="hidden" value="0" /></td>
        <td class="col-md-2"><input name="nominal_kas_6" id="nominal_kas_6" class="validate[required,custom[integer]] form-control xnumber" type="text" readonly="readonly"></td> //
	<td align="center" class="col-md-2">
			<div class="btn-group">
				<button type="submit" class="btn btn-default btn-sm" id="add" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
				<button type="reset" class="btn btn-default btn-sm" id="reset" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			</div>
			<input type="submit" class="btn btn-default" name="submit" id="add" value="simpan"> //
		</td>
</tr>
</tbody>
</table>
</form> -->

</div>
</div>
</div>
</div>

<!-- MASUKAN NOMINAL -->
<div class="modal" id="myModalKas" tabindex="-1" role="dialog" aria-labelledby="myModalKas">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
            <label for="exampleInputEmail1">Masukan nilai :</label>
            <div class="row">
                
                <div class="col-md-12">
                <div class="form-group form-group-lg">
                    <div class="col-sm-10">
                        <input type="hidden" name="kd_akun_kas" id="kd_akun_kas" value="" />
                        <input class="form-control input-lg validate[required,custom[integer],min[1]] xnumber" type="text" id="nominal" placeholder="">
                    </div>
                </div>
                </div><!-- /.col-lg-6 -->
               
            </div>
            </div>
          </div>
           
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-proses" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Pilih</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
          </div>
        </div>
    </div>
</div>
