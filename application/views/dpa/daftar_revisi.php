<script type="text/javascript">
$(document).ready(function(){
	
/*	$.ajax({
                type:"POST",
                url :"<?=site_url("revisi/get_unit")?>",
                data:'kode_unit=' + <?=$_SESSION['rba_kode_unit_subunit']?>,
                success:function(respon){
                        $("#unit").html(respon);

                }
        });*/
		   //edited w $(this).attr('rel')
	  //  el.find('td.impor').load("<?php echo site_url('dpa/get_impor_number_unit'); ?>/"+$(this).attr('rel')+"/"+$("#tahun").val());
		//el.find('td.impor').load("<?php echo site_url('dpa/get_impor_number_unit'); ?>/"+$(this).attr('rel')+"/"+$("#tahun").val());
        //edited w
		$('[class="tr-unit"]').each(function(){
        
            var el = $(this); 
            var rel = $(this).attr('rel');
    		el.find('td.revisi').load("<?php echo site_url('dpa/get_revisi_number_unit'); ?>/"+$(this).attr('rel'));
    		el.find('td.rkat-selain-apbn').load("<?php echo site_url('dpa/get_impor_rkat_unit'); ?>/"+el.attr('rel')+"/SELAIN-APBN/<?php echo $cur_tahun; ?>", function(r) {
                  $(this).html('<a href="<?=site_url('dpa/cetak_dpa')?>/unit/'+rel+'/sumber_dana/SELAIN-APBN" target="_blank"><b>'+r+'</b></a>');
                });
            el.find('td.rkat-apbn-bpptnbh').load("<?php echo site_url('dpa/get_impor_rkat_unit'); ?>/"+el.attr('rel')+"/APBN-BPPTNBH/<?php echo $cur_tahun; ?>", function(r) {
                  $(this).html('<a href="<?=site_url('dpa/cetak_dpa')?>/unit/'+rel+'/sumber_dana/APBN-BPPTNBH" target="_blank"><b>'+r+'</b></a>');
                });
            el.find('td.rkat-apbn-lainnya').load("<?php echo site_url('dpa/get_impor_rkat_unit'); ?>/"+el.attr('rel')+"/APBN-LAINNYA/<?php echo $cur_tahun; ?>", function(r) {
                  $(this).html('<a href="<?=site_url('dpa/cetak_dpa')?>/unit/'+rel+'/sumber_dana/APBN-LAINNYA" target="_blank"><b>'+r+'</b></a>');
                });
            
        });
        

	$('#reset').click(function(){
		$('#form_tor').validationEngine('hide');
                $("#div_sub_subunit").hide();
                $("#div_subunit").hide();
	});
        
});


$(document).ajaxComplete(function( event, xhr, settings ) {

    var tot_rkat_selain_apbn = 0 ;
    var tot_rkat_apbn_bpptnbh = 0 ;
    var tot_rkat_apbn_lainnya = 0 ;
        $('[class="tr-unit"]').each(function(){
            var el = $(this);
            tot_rkat_selain_apbn = tot_rkat_selain_apbn + parseInt(string_to_angka(el.find('td.rkat-selain-apbn').text()));
            tot_rkat_apbn_bpptnbh = tot_rkat_apbn_bpptnbh + parseInt(string_to_angka(el.find('td.rkat-apbn-bpptnbh').text()));
            tot_rkat_apbn_lainnya = tot_rkat_apbn_lainnya + parseInt(string_to_angka(el.find('td.rkat-apbn-lainnya').text()));
        });

        $('#tot_rkat_selain_apbn').text(angka_to_string(tot_rkat_selain_apbn));
        $('#tot_rkat_apbn_bpptnbh').text(angka_to_string(tot_rkat_apbn_bpptnbh));
        $('#tot_rkat_apbn_lainnya').text(angka_to_string(tot_rkat_apbn_lainnya));

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

/*$(document).on("click","#show",function(){
    if($("#form_tor").validationEngine("validate")){
        $('#tb-empty').hide(function(){
                $('#tb-isi').show(function(){
                    get_unit_dpa();
                });
            });
        
 
    }
    
    
});*/

function get_unit_dpa(){
    $('[class="tr-unit"]').each(function(){
        
        var el = $(this); 

     //   el.find('td.impor').load("<?php echo site_url('dpa/get_impor_number_unit'); ?>/"+$(this).attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
	//	 el.find('td.impor').load("<?php echo site_url('dpa/get_impor_number_unit'); ?>/"+$(this).attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
        //edited w
		el.find('td.revisi').load("<?php echo site_url('dpa/get_revisi_number_unit'); ?>/"+$(this).attr('rel'));
        // el.find('td.rkat').load("<?php echo site_url('dpa/get_impor_rkat_unit'); ?>/"+el.attr('rel'));
		el.find('td.rkat').load("<?php echo site_url('dpa/get_impor_rkat_unit'); ?>/"+el.attr('rel')+"/SELAIN-APBN/<?php echo $cur_tahun; ?>");
       // el.find('td.rsa').load("<?php echo site_url(); ?>/revisi/get_impor_rsa_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
              
            
    });
}

$(document).on("click",".tb-impor",function(){
    var unit = $(this).attr('rel');
    var sumber_dana = $('#sumber_dana').val();
    var tahun = $('#tahun').val();
    
    var rkat = $(this).parent().parent().find('td.rkat').html();
    
    var el = $(this);
    
    if(rkat != '0'){
    
        if(confirm('Apakah anda yakin, impor unit : '+unit+' ?')){

            // el.attr('disabled','disabled');
//            el.hide(function(){
//                el.siblings('div.progress').show();
//            });
            

            $.ajax({
                    type:"POST",
                    url :"<?=site_url("revisi/post_impor_unit")?>",
                    data:'unit=' + unit +'&sumber_dana='+ sumber_dana +'&tahun='+tahun,
                    success:function(respon){
    //                        $("#subunit").html(respon);
                        if(respon == 'sukses'){
                            get_unit_dpa();
//                            el.removeAttr('disabled');
//                            el.show(function(){
//                                el.siblings('div.progress').hide();
//                            });
                        }else{
                            alert('Silahkan melakukan revisi dahulu !');
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
    var unit = $(this).attr('rel');
    var sumber_dana = $('#sumber_dana').val();
    var tahun = $('#tahun').val();
    
    var rkat = $(this).parent().parent().find('td.rkat').html();
    
    var el = $(this);
    
    if(rkat != '0'){
    
        if(confirm('Apakah anda yakin, Submit Revisi unit Ke RKAT : '+unit+' ?')){

            // el.attr('disabled','disabled');
            //el.hide(function(){
           //     el.siblings('div.progress').show();
           // });
            

            $.ajax({
                    type:"POST",
                    url :"<?=site_url("revisi/post_revisi_unit")?>",
                    data:'unit=' + unit +'&sumber_dana='+ sumber_dana +'&tahun='+tahun,
                    success:function(respon){
                      //      $("#div_subunit").html(respon);
                       if(respon == 'sukses'){
                           get_unit_dpa();
						//}
//                            el.removeAttr('disabled');
                      //      el.show(function(){
                          //      el.siblings('div.progress').hide();
                        //    });
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
$(document).on("click",".tb-print",function(){
    var unit = $(this).attr('rel');
    var sumber_dana = $('#sumber_dana').val();
    var tahun = $('#tahun').val();
    
    var rkat = $(this).parent().parent().find('td.rkat').html();
    
    var el = $(this);
    
    if(rkat != '0'){
    
        //if(confirm('Apakah anda yakin, cetak unit : '+unit+' ?')){

            // el.attr('disabled','disabled');
            el.hide(function(){
                el.siblings('div.progress').show();
            });
            var data='unit/' + unit +'/sumber_dana/'+ sumber_dana +'/tahun/'+tahun;
			window.location="<?=site_url("revisi/cetak_dpa")?>/"+data;
            /*$.ajax({
                    type:"POST",
                    url :"<?=site_url("dpa/cetak_dpa")?>",
                    data:'unit=' + unit +'&sumber_dana='+ sumber_dana +'&tahun='+tahun,
                   /* success:function(respon){
    //                        $("#subunit").html(respon);
                        if(respon == 'sukses'){
                           window.open("<?=site_url("akun_kas5/get_form_edit")?>", {data:data});
                        }else{
							alert();
						}
                    }
            })*/
        //}
    }
    else{
        alert('Maaf, nilai RKAT tidak boleh kosong !');
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
//$tgl=getdate();
//$cur_tahun=$tgl['year']+1;
?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
<h2>DAFTAR REVISI</h2>   
</div>
                </div>
                <hr />
                <div class="row">  
                    <div class="col-lg-12">

<table class="table table-striped">
<thead>
    <tr >
           <th class="col-md-1" >Kode</th>
            <th class="col-md-3" >Unit</th>
          <!--  <th class="col-md-1" >APPROVAL</th>  //edited widi -->
            <th class="col-md-2" >Revisi</th> <!-- //edited widi -->
            <th class="col-md-2" style="text-align:right" >SELAIN-APBN</th>
            <th class="col-md-2" style="text-align:right" >APBN-BPPTNBH</th>
            <th class="col-md-2" style="text-align:right" >APBN-GAJI</th>
           <!-- <th class="col-md-2" >RSA</th> -->  <!-- //edited widi -->
           <!-- <th class="col-md-2" style="text-align:center">Aksi</th> -->
    </tr>
</thead>
<tbody id="tb-isi">
    <?php foreach($unit_usul as $i => $u){ ?>
        <tr rel="<?=$u->kode_unit?>" class="tr-unit" height="25px">
            <td class=""><b><?=$u->kode_unit?></b></td>
            <td class="text-danger"><!--<a href="<?=site_url("geser/daftar_program/".$u->kode_unit)?>">--><b><?=$u->nama_unit?></b><!--</a>--></td>
           <!-- <td class="impor">&nbsp;</td><!-- //edited widi -->
            <td class="revisi" >&nbsp;</td> <!-- //edited widi -->
            <td style="text-align: right" class="rkat-selain-apbn" ></td>
            <td style="text-align: right" class="rkat-apbn-bpptnbh" ></td>
            <td style="text-align: right" class="rkat-apbn-lainnya" ></td>
           <!-- <td style="text-align: right" class="rsa">&nbsp;</td> -->  <!-- //edited widi -->
            <!-- <td align="center">
                <div class="progress" style="display: none;margin-bottom: 14px;">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    </div>
                </div>
               
                <div class="btn-group" role="group" aria-label="..."> -->
                 <!--  <button type="button" class="btn btn-warning btn-sm tb-impor" rel="<?=$u->kode_unit?>"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Approve</buttton></button>-->  <!-- //edited widi -->
                  
                <!--    <button type="button" class="btn btn-success btn-sm tb-print" rel="<?=$u->kode_unit?>"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</buttton></button>-->  <!-- //edited widi -->
                 
                <!-- <button type="button" class="btn btn-info btn-sm tb-revisi" rel="<?=$u->kode_unit?>"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Revisi</buttton></button> -->
                <!-- 
                </div>
            </td> -->
        </tr>
        
    <?php } ?>
<!--<tbody id="tb-empty">
    <tr >
        <td colspan="6"> - kosong -</td>
    </tr>
</tbody>-->
<tfoot>
    <tr class="">
        <td colspan="7" style="text-align: center;font-weight:bold;"></td>
    </tr>
    <tr class="alert-warning">
        <td colspan="3" style="text-align: center;font-weight:bold;">Total :</td>
        <td style="text-align: right;font-weight:bold;" id="tot_rkat_selain_apbn">0</td>
        <td style="text-align: right;font-weight:bold;" id="tot_rkat_apbn_bpptnbh">0</td>
        <td style="text-align: right;font-weight:bold;" id="tot_rkat_apbn_lainnya">0</td>
    </tr>
</tfoot>
</table>

</div>

        </div>
      </div>
</div>
