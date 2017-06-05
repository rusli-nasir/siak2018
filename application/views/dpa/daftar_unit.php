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
    $('[class="tr-unit"]').each(function(){
        
        var el = $(this); 

        el.find('td.impor').load("<?php echo site_url('dpa/get_impor_number_unit'); ?>/"+$(this).attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
		// el.find('td.impor').load("<?php echo site_url('dpa/get_impor_number_unit'); ?>/"+$(this).attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
        el.find('td.rkat').load("<?php echo site_url(); ?>/dpa/get_impor_rkat_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
        el.find('td.rsa').load("<?php echo site_url(); ?>/dpa/get_impor_rsa_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
              
            
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
                    url :"<?=site_url("dpa/post_impor_unit")?>",
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
    
        if(confirm('Apakah anda yakin, impor Revisi unit Ke RKAT : '+unit+' ?')){

            // el.attr('disabled','disabled');
            el.hide(function(){
                el.siblings('div.progress').show();
            });
            

            $.ajax({
                    type:"POST",
                    url :"<?=site_url("dpa/post_revisi_unit")?>",
                    data:'unit=' + unit +'&sumber_dana='+ sumber_dana +'&tahun='+tahun,
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
$(document).on("click",".tb-print",function(){
    var unit = $(this).attr('rel');
    var sumber_dana = $('#sumber_dana').val();
    var tahun = $('#tahun').val();
    
    var rkat = $(this).parent().parent().find('td.rkat').html();
    
    // var el = $(this);
    
    if(rkat != '0'){
    
        //if(confirm('Apakah anda yakin, cetak unit : '+unit+' ?')){

            // el.attr('disabled','disabled');
            // el.hide(function(){
            //     el.siblings('div.progress').show();
            // });
            var data='unit/' + unit +'/sumber_dana/'+ sumber_dana +'/tahun/'+tahun;
			window.location="<?=site_url("dpa/cetak_dpa")?>/"+data;
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
                     <h2>REVISI DPA</h2>    
                    </div>
                </div>
                <hr />
                <div class="row">  
                    <div class="col-lg-12">
<form class="form-horizontal alert alert-warning col-sm-8" method="post" id="form_tor" action="<?php echo site_url('tor/daftar_tor');?>">
	 <div class="form-group"  >
			<label for="input1" class="col-md-4 control-label">Tahun</label>
			<div class="col-md-8">
                        <?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'validate[required] form-control','id'=>'tahun'))?>
                                    
			</div>
		</div>
                <div class="form-group"  >
			<label for="input1" class="col-md-4 control-label">Sumber Dana</label>
			<div class="col-md-8">
			  	<select name="sumber_dana" id="sumber_dana" class="validate[required] form-control">
		      	  <option value="">-pilih-</option>
				  <option value="SELAIN-APBN">SELAIN APBN</option>
				  <option value="APBN-BPPTNBH">APBN (BPPTNBH)</option>
				  <option value="APBN-LAINNYA">SPI - SILPA - PINJAMAN</option>
				</select>
			</div>
		</div>
    <!--
                <div id="div_unit">
		<div class="form-group" >
			    <label for="" class="col-md-4 control-label">Unit</label>
			    <div class="col-md-8">
			      <select name="unit" id="unit" class="validate[required] form-control">
			      	  <option value="">-pilih-</option>
					</select>
			    </div>
			  </div>
		</div>
    -->
    <!--
		<div id="div_subunit" style="display:none">
		<div class="form-group" >
			    <label for="" class="col-md-4 control-label">SubUnit</label>
			    <div class="col-md-8">
			      <select name="subunit" id="subunit" class="validate[required] form-control">
			      	  <option value="">-pilih-</option>
					</select>
			    </div>
                            </div>
		</div>
		<div id="div_sub_subunit" style="display:none">
		<div class="form-group" >
			    <label for="" class="col-md-4 control-label">Sub SubUnit</label>
			    <div class="col-md-8">
			      <select name="sub_subunit" id="sub_subunit" class="validate[required] form-control">
			      	  <option value="">-pilih-</option>
					</select>
			    </div>
                            </div>
		</div>
    -->
	<div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="button" class="btn btn-primary" id="show"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search</button>
	      <button type="reset" class="btn btn-info" id="reset"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset</button>
	    </div>
	  </div>

			</form>
                    
			<div id="temp" style="display:none"></div>
                        <div id="o-table">
                        <table class="table table-striped">
                            <thead>
                                <tr >
                                        <th class="col-md-1" >Kode</th>
                                        <th class="col-md-4" >Unit</th>
                                        <th class="col-md-2" >&nbsp;</th>
                                        <th class="col-md-2" >RKAT</th>
                                        <!--<th class="col-md-2" >RSA</th>-->
                                        <th class="col-md-3" style="text-align:center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tb-isi" style="display: none">
                                <?php foreach($unit_usul as $i => $u){ ?>
                                    <tr rel="<?=$u->kode_unit?>" class="tr-unit" height="25px">
                                        <td class=""><b><?=$u->kode_unit?></b></td>
                                        <td class="text-danger"><a href="<?=site_url("geser/daftar_program/".$u->kode_unit)?>"><b><?=$u->nama_unit?></b></a></td>
                                        <td class="impor">&nbsp;</td>
                                        <td style="text-align: right" class="rkat">&nbsp;</td>
                                        <!--<td style="text-align: right" class="rsa">&nbsp;</td>-->
                                        <td align="center">
                                            <div class="progress" style="display: none;margin-bottom: 14px;">
                                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                </div>
                                            </div>
                                           
											<div class="btn-group" role="group" aria-label="...">
											  <!--<button type="button" class="btn btn-warning btn-sm tb-impor" rel="<?=$u->kode_unit?>"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Impor</buttton></button>-->
											  
											   <button type="button" class="btn btn-success btn-sm tb-print" rel="<?=$u->kode_unit?>"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</buttton></button>
											
											 
											  <!--<button type="button" class="btn btn-info btn-sm tb-revisi" rel="<?=$u->kode_unit?>"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Revisi</buttton></button>-->
											</div>
                                        </td>
                                    </tr>
                                    
                                <?php } ?>
                            </tbody>
                            <tbody id="tb-empty">
                                <tr >
                                    <td colspan="5"> - kosong -</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>


	
                        </div>

	    </div>
	  </div>
</div>
