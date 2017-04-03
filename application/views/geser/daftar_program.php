<script type="text/javascript">
$(document).ready(function(){
	
	$.ajax({
                type:"POST",
                url :"<?=site_url("tor/get_unit")?>",
                data:'kode_unit=' + <?=$_SESSION['kode_unit']?>,
                success:function(respon){
                        $("#kode_unit").html(respon);

                }
        });

	$('#reset').click(function(){
		$('#form_tor').validationEngine('hide');
                $("#div_sub_subunit").hide();
                $("#div_subunit").hide();
	});
        
});

function string_to_angka(str){

	
	return str.split('.').join("");
	
}

function angka_to_string(num){

	var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

	return str_hasil;
}

function refresh_row(){

	// $("#row_space").load("<?=site_url('tor/get_row')?>");
        
}

$(document).on("click","#show",function(){
    if($("#form_tor").validationEngine("validate")){
        $('#tb-empty').hide(function(){
                $('#tb-isi').show(function(){
                    get_unit_dpa();
                });
            });
        
 
    }
    
    
});

function get_unit_dpa(){
    $('[class="tr-kode_unit"]').each(function(){
        
       var el = $(this); 
        el.find('td.rkat').load("<?php echo site_url(); ?>/geser/get_impor_rkat_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
        el.find('td.rsa').load("<?php echo site_url(); ?>/geser/get_impor_rsa_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
              
            
    });
}

$(document).on("click",".tb-impor",function(){
    var kode_unit = $(this).attr('rel');
    var sumber_dana = $('#sumber_dana').val();
    var tahun = $('#tahun').val();
    
    var rkat = $(this).parent().parent().find('td.rkat').html();
    
    var el = $(this);
    
    if(rkat != '0'){
    
        if(confirm('Apakah anda yakin, impor kode_unit : '+kode_unit+' ?')){

            // el.attr('disabled','disabled');
            el.hide(function(){
                el.siblings('div.progress').show();
            });
            

            $.ajax({
                    type:"POST",
                    url :"<?=site_url("dpa/post_impor_unit")?>",
                    data:'kode_unit=' + kode_unit +'&sumber_dana='+ sumber_dana +'&tahun='+tahun,
                    success:function(respon){
    //                        $("#subunit").html(respon);
                        if(respon == 'sukses'){
                            get_unit_dpa();
//                            el.removeAttr('disabled');
                            el.show(function(){
                                el.siblings('div.progress').hide();
                            });
                        }
                    }
            })
        }
    }
    else{
        alert('Maaf, nilai RKAT tidak boleh kosong !');
    }
});
//REVISI IMPORT
$(document).on("click",".tb-revisi",function(){
    var kode_unit = $(this).attr('rel');
    var sumber_dana = $('#sumber_dana').val();
    var tahun = $('#tahun').val();
    
    var rkat = $(this).parent().parent().find('td.rkat').html();
    
    var el = $(this);
    
    if(rkat != '0'){
    
        if(confirm('Apakah anda yakin, impor Revisi kode_unit Ke RKAT : '+kode_unit+' ?')){

            // el.attr('disabled','disabled');
            el.hide(function(){
                el.siblings('div.progress').show();
            });
            

            $.ajax({
                    type:"POST",
                    url :"<?=site_url("geser/post_revisi_unit")?>",
                    data:'kode_unit=' + kode_unit +'&sumber_dana='+ sumber_dana +'&tahun='+tahun,
                    success:function(respon){
    //                        $("#subunit").html(respon);
                        if(respon == 'sukses'){
                            get_unit_dpa();
//                            el.removeAttr('disabled');
                            el.show(function(){
                                el.siblings('div.progress').hide();
                            });
                        }
                    }
            })
        }
    }
    else{
        alert('Maaf, nilai RKAT tidak boleh kosong !');
    }
});
//END REVISI IMPORT


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
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
<h2>DAFTAR DETAIL PROGRAM</h2>
 <div id="o-table">
<table class="table table-striped">
	  <thead>
	<tr>
		<td>KODE PROGRAM</td><td>RKAT</td><td>RSA</td>
	</tr>
  </thead>
   <tbody id="tb-isi">
 <?php foreach($unit_usul as $i => $u){ ?>
	 <tr rel="<?=$u->kode_unit?>" class="tr-kode_unit" height="25px">
		<td><?=$u->program?></td>
		<td style="text-align: right" class="rkat"><?php //echo number_format($u->total,0,",",".");?></td>
        <td style="text-align: right" class="rsa">&nbsp;</td>
	</tr>
 <?php }
 ?>
</tbody>
</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>