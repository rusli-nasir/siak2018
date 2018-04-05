<script type="text/javascript">
$(document).ready(function(){

	$('#reset').click(function(){
		$('#form_dpa').validationEngine('hide');
                $("#div_sub_subunit").hide();
                $("#div_subunit").hide();
	});
        
        $('#sumber_dana').val("<?=$sumber_dana?>");


    // $('.tb-buat-tor').each(function(){

    // });

    var jml_usulan_baru = 0 ;

    $('.ada_usulan').each(function(){
        var i = $(this).text() ; 

        jml_usulan_baru = jml_usulan_baru + parseInt(i.trim()) ;
    });


    $('#jml_dpa_baru').text(jml_usulan_baru);
        
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
    if($("#form_dpa").validationEngine("validate")){
        var sumber_dana = $('#sumber_dana').val();
        window.location = "<?=site_url("dpa/realisasi_dpa")?>/" + sumber_dana + '/<?=$jenis?>' ;
        
//        $('#tb-empty').hide(function(){
//                $('#tb-isi').show(function(){
//                    get_unit_dpa();
                    
//                });
//            });
        
 
    }
    
    
});

function get_unit_dpa(){
//    $('[class="tr-unit"]').each(function(){
//        
//        var el = $(this); 
//
//        el.find('td.impor').load("<?php echo site_url('dpa/get_impor_number_unit'); ?>/"+$(this).attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
//        el.find('td.rkat').load("<?php echo site_url(); ?>/dpa/get_impor_rkat_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
//        el.find('td.rsa').load("<?php echo site_url(); ?>/dpa/get_impor_rsa_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
//              
//            
//    });
    var sumber_dana = $('#sumber_dana').val();
    var tahun = $('#tahun').val();
    $('#tb-isi').load("<?php echo site_url('dpa/tabel_dpa'); ?>/"+ sumber_dana +"/"+ tahun);
}

$(document).on("click",".tb-buat-tor",function(){
    var unit_komponen_subkomponen = $(this).attr('rel');
    var sumber_dana = $('#sumber_dana').val();
//    var tahun = $('#tahun').val();
    
    var rkat = $(this).parent().parent().find('td.rkat').html();
    
    if(rkat != '0'){
        
        window.location = "<?=site_url("tor/realisasi_tor/")?>" + unit_komponen_subkomponen + "/" + sumber_dana + '/<?=$jenis?>' ;
    
//        if(confirm('Apakah anda yakin, impor unit : '+ unit_komponen_subkomponen +' ?')){

//            $.ajax({
//                    type:"POST",
//                    url :"<?=site_url("dpa/post_impor_unit")?>",
//                    data:'unit=' + unit +'&sumber_dana='+ sumber_dana +'&tahun='+tahun,
//                    success:function(respon){
    //                        $("#subunit").html(respon);
//                        if(respon == 'sukses'){
//                            get_unit_dpa()
//                        }
//                    }
//            });
//        }
    }
    else{
        alert('Maaf, nilai RKAT tidak boleh kosong !');
    }
});
$(document).on("click",".tb-buat-tor-lsphk3",function(){
    var unit_komponen_subkomponen = $(this).attr('rel');
    var sumber_dana = $('#sumber_dana').val();
//    var tahun = $('#tahun').val();
    
    var rkat = $(this).parent().parent().find('td.rkat').html();
    
    if(rkat != '0'){
        
        window.location = "<?=site_url("tor/realisasi_tor_lsphk3/")?>" + unit_komponen_subkomponen + "/" + sumber_dana + '/<?=$jenis?>' ;
    
//        if(confirm('Apakah anda yakin, impor unit : '+ unit_komponen_subkomponen +' ?')){

//            $.ajax({
//                    type:"POST",
//                    url :"<?=site_url("dpa/post_impor_unit")?>",
//                    data:'unit=' + unit +'&sumber_dana='+ sumber_dana +'&tahun='+tahun,
//                    success:function(respon){
    //                        $("#subunit").html(respon);
//                        if(respon == 'sukses'){
//                            get_unit_dpa()
//                        }
//                    }
//            });
//        }
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


</script>
<?php
$tgl=getdate();
$cur_tahun=$tgl['year']+1;
?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>REALISASI DPA</h2>    
                    </div>
                </div>
                <hr />
                <div class="row">  
                    <div class="col-lg-12">


                    <div class="row">
                <div class="col-lg-8">

<form class="form-horizontal alert alert-warning" method="post" id="form_dpa" action="">
                <!--
                <div class="form-group"  >
			<label for="input1" class="col-md-4 control-label">Tahun</label>
			<div class="col-md-8">
                        <?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'validate[required] form-control','id'=>'tahun'))?>
                                    
			</div>
		</div>
                -->
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
            </div>

            <div class="col-lg-4">
            <div class="alert alert-warning" style="border: 1px solid #a94442">
            Jumlah usulan DPA siap proses : <span id="jml_dpa_baru">0</span> 
            </div>
            </div>
            </div>


			<div id="temp" style="display:none"></div>
                        <div id="o-table">
                        <table class="table table-striped">
                            <thead>
                                <tr >
                                        <th class="col-md-3" >IKU</th>
                                        <th class="col-md-3" >Kegiatan</th>
                                        <th class="col-md-3" >Sub Kegiatan</th>
                                        <th class="col-md-1" >RKAT</th>
                                        <th class="col-md-1" >RSA</th>
                                        <th class="col-md-1" style="text-align:center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tb-isi" style="">
                                <?php $temp_text_program = ''; ?>
                                <?php $temp_text_komponen = ''; ?>
                                <?php $total_g = 0 ; ?>
                                <?php $total_h = 0 ; ?>
                                <?php if(!empty($rsa_usul)): ?>
                                <?php foreach($rsa_usul as $i => $u){ ?>
                                    <tr rel="<?=$u->k_unit.$u->kode_rka?>" class="tr-unit" height="25px">
                                        <?php if($temp_text_program != $u->nama_program): ?>
                                            <td class=""><b><?=$u->nama_program?></b></td>
                                            <?php $temp_text_program = $u->nama_program; ?>
                                        <?php else: ?>
                                            <td class="">&nbsp;</td>
                                        <?php endif; ?>
                                        <?php if($temp_text_komponen != $u->nama_komponen): ?>
                                            <td class=""><b><?=$u->nama_komponen?></b></td>
                                            <?php $temp_text_komponen = $u->nama_komponen; ?>
                                        <?php else: ?>
                                            <td class="">&nbsp;</td>
                                        <?php endif; ?>
                                        <td class=""><?=$u->nama_subkomponen?></td>
                                        <td class="" style="text-align: right"><?=number_format($u->jumlah_tot, 0, ",", ".")?><?php $total_g = $total_g + $u->jumlah_tot; ?></td>
                                        <td class="" style="text-align: right"><?=number_format($u->jumlah_rsa, 0, ",", ".")?><?php $total_h = $total_h + $u->jumlah_rsa; ?></td>
                                        <!--<td style="text-align: right" class="rkat">&nbsp;</td>-->
                                        <!--<td style="text-align: right" class="rsa">&nbsp;</td>-->
                                        
                                            <td align="center">
                                               
												<?php // if($jenis=='4'){ ?>
												 <!-- <buttton type="button" class="btn btn-warning btn-sm tb-buat-tor-lsphk3" rel="<?=$u->kode_rka?><?php //$u->k_unit.$u->kode_rka;?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</buttton> -->
												<?php // }else{ ?>
												

                                                    <?php if($u->jml_proses > 0){ ?>
                                                    <buttton type="button" class="btn btn-danger btn-sm tb-buat-tor ada_usulan" rel="<?=$u->kode_rka?>" > <?=$u->jml_proses?> </buttton>
                                                    <?php }else{ ?>

                                                        <buttton type="button" class="btn btn-default btn-sm tb-buat-tor" rel="<?=$u->kode_rka?>" > - </buttton>

                                                    <?php } ?>

												<?php // } ?>
												
                                            </td>
                                        
                                        
                                    </tr>

                                <?php } ?>
                                    <tr >
                                        <td colspan="6">&nbsp;</td>
                                    </tr>
                                    <tr id="" height="25px" class="alert alert-danger" style="font-weight: bold">
                                        <td colspan="2" style="text-align: center">Total </td>
                                        <td style="text-align: right">:</td>
                                        <td style="text-align: right"><?=number_format($total_g, 0, ",", ".")?></td>
                                        <td style="text-align: right"><?=number_format($total_h, 0, ",", ".")?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php else: ?>
                                <tr id="tr-empty">
                                                <td colspan="6"> - kosong / belum disetujui - </td>
                                </tr>
                                <?php endif; ?>
                                
                            </tbody>
<!--                            <tbody id="tb-empty">
                                <tr id="tr-empty">
                                    <td colspan="4"> - kosong -</td>
                                </tr>
                            </tbody>-->
                            <tfoot>
                                <tr>
                                    <td colspan="6">&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>


	
                        </div>

	    </div>
	  </div>
</div>
