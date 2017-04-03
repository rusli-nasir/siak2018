<script type="text/javascript">
$(document).ready(function(){
	
	$.ajax({
                type:"POST",
                url :"<?=site_url("tor/get_unit")?>",
                data:'kode_unit=' + <?=$_SESSION['rsa_kode_unit_subunit']?>,
                success:function(respon){
                        $("#unit").html(respon);

                }
        });

	$('#reset').click(function(){
		$('#form_tor').validationEngine('hide');
                $("#div_sub_subunit").hide();
                $("#div_subunit").hide();
	});
        
});
function refresh_row(){

	$("#row_space").load("<?=site_url('tor/get_row')?>");
}

$(document).on("click","#show",function(){
    if($("#form_tor").validationEngine("validate")){
        var data= "unit="+$("#unit").val()+"&sumber_dana="+$("#sumber_dana").val()+"&tahun="+$("#tahun").val();
        $.ajax({
                type:"POST",
                url :"<?=site_url("tor/show_komponen_input")?>",
                data:data,
                success:function(respon){
                        // $("#subunit").html(respon);
//                        console.log(respon);
                        $('#row_space').html(respon);
                }
        })
        
    }
    
    
});


$(document).on("change","#unit",function(){
		if($(this).val()==''){

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');

			$("#div_subunit").hide();
			$("#subunit").html('<option value="">[kosong]</option>');

		}else{
			
                        $("#subunit").removeAttr('disabled');
                                $.ajax({
                                        type:"POST",
                                        url :"<?=site_url("tor/get_subunit")?>",
                                        data:'kode_subunit=' + $(this).val(),
                                        success:function(respon){
                                                $("#subunit").html(respon);
                                        }
                                })

                                $("#div_subunit").show();
                                
                        $("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');
                        
			}

	});

        $(document).on("change","#subunit",function(){
		if($(this).val()==''){

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');

		}else{
                    
                        $("#sub_subunit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("tor/get_sub_subunit")?>",
						data:'kode_sub_subunit=' + $(this).val(),
						success:function(respon){
							$("#sub_subunit").html(respon);
						}
					})

					$("#div_sub_subunit").show();
                        
           
			
		}

	});
	if ( $("#rekap").length ) {
            
            perform_calc();
//$("#excel_view").modal('show');
                       
            // $( "#down" ).trigger( "click" );
		            
	}
        
        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
        
        

	function perform_calc(){

                            $("#loading_view").on('hide.bs.modal', function (e) {
                                //console.log('modal show');
                                $("#excel_view").on('show.bs.modal', function (e) {
                                    //console.log('modal show');
                                    
                                    
                                });
                                
                                $("#excel_view").modal('show');

                            });
                            
                            $("#loading_view").on('show.bs.modal', function (e) {
                                    //console.log('modal show');
                                    setTimeout(doing_calc,100);
//                                  run_calc();
                            });
                                
                             $("#loading_view").modal('show');       
//                            $("#excel_view").modal('show');
                            
}


</script>
<?php
$tgl=getdate();
$cur_tahun=$tgl['year']+1;
?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>DAFTAR AKUN KAS</h2>    
                    </div>
                </div>
                <hr />
                <div class="row">  
                    <div class="col-lg-12">
<table class="table table-striped table-bordered">
<tr>
	<td class="col-md-2">Kegiatan</td>
	<td><span id="kode_komponen"><?=$tor_usul->kode_komponen?></span> - <?=$tor_usul->nama_komponen?></td>
</tr>
<tr>
	<td class="col-md-2">Sub Kegiatan</td>
	<td><span id="kode_subkomponen"><?=$tor_usul->kode_subkomponen?></span> - <?=$tor_usul->nama_subkomponen?></td>
</tr>
</table>
                    
			<div id="temp" style="display:none"></div>
                        <div id="o-table">
                        <table class="table table-striped">
                            <thead>
                                <tr >
                                        <th class="col-md-3" >Unit</th>
                                        <th class="col-md-3" >&nbsp;</th>
                                        <th class="col-md-3" >RKAT</th>
                                        <th class="col-md-2" >RSA</th>
                                        <th class="col-md-2" style="text-align:center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="row_space">
                                <?php foreach($unit_rkat_rsa as $u){ ?>
                                    <tr id="tr-empty" height="25px">
                                        <td ><?=$u->nama_unit?></td>
                                        <td ><?=$u->impor_ke?></td>
                                        <td ><?=$u->rkat?></td>
                                        <td ><?=$u->rsa?></td>
                                        <td align="center"><a type="button" class="btn btn-warning" href="<?=site_url("tor/input_tor/".$row->k_unit.$row->kode_kegiatan.$row->kode_output.$row->kode_program)?>" class="edit" rel="<?=$row->k_unit.$row->kode_kegiatan.$row->kode_output.$row->kode_program?>" name="edit">Expor</a></td>
                                    </tr>
                                    
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>


	
                        </div>

	    </div>
	  </div>
</div>
