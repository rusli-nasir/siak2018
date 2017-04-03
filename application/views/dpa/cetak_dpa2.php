<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">

var unit = <?=isset($kode_parent_unit)?$kode_parent_unit:'99'?> ;

$(document).ready(function(){

	$(document).on("click","#show",function(){

		if($("#form_laporan").validationEngine("validate")){
			$("#form_laporan").submit();
		}

	});

	$('#reset').click(function(){
		$('#form_laporan').validationEngine('hide');
	});



	<?php if($_SESSION['rba_level'] == '31'):?>
	$(document).on("change","#jenis",function(){
		if($(this).val()==''){

		}else{
			if($(this).val()==1){

			}else{

			}

		}
	});
	<?php elseif($_SESSION['rba_level'] == '3'):?>
	$(document).on("change","#jenis",function(){
                $("#div_sub_subunit").hide();
		$("#sub_subunit").html('<option value="">[kosong]</option>');

		if($(this).val()==''){

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');

		}else{
			if(($(this).val()==1)||($(this).val()==2)||($(this).val()==3)||($(this).val()==4)||($(this).val()==5)){
				$("#sub_subunit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_sub_subunit")?>",
						data:'kode_sub_subunit=' + <?=$_SESSION['rba_kode_unit_subunit']?>,
						success:function(respon){
							$("#sub_subunit").html(respon);
						}
					})
					$("#div_sub_subunit").show();

			}else{
				$("#div_sub_subunit").hide();
				$("#sub_subunit").html('<option value="">[kosong]</option>');		

			}

		}
	});


	<?php elseif($_SESSION['rba_level'] == '2'):?>
	$(document).on("change","#jenis",function(){
                $("#div_subunit").hide();
                $("#sub_unit").html('<option value="">[kosong]</option>');

                $("#div_sub_subunit").hide();
                $("#sub_subunit").html('<option value="">[kosong]</option>');
                
		if($(this).val()==''){

			$("#div_subunit").hide();
			$("#sub_unit").html('<option value="">[kosong]</option>');

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');
		}else{
			if(($(this).val()==1)||($(this).val()==2)||($(this).val()==3)||($(this).val()==4)||($(this).val()==5)){
				$("#subunit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_subunit")?>",
						data:'kode_subunit=' + <?=$_SESSION['rba_kode_unit_subunit']?>,
						success:function(respon){
							$("#subunit").html(respon);
						}
					})
                                        
                                        $("#div_subunit").show();
                                        
			}else if(($(this).val()==6)||($(this).val()==7)){
                                $("#subunit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_subunit")?>",
						data:'kode_subunit=' + <?=$_SESSION['rba_kode_unit_subunit']?>,
						success:function(respon){
							$("#subunit").html(respon);
						}
					})
                                        
                                        $("#div_subunit").show();

			}
                        else{
                            $("#div_subunit").hide();
                            $("#subunit").html('<option value="">[kosong]</option>');
                            
                            $("#div_sub_subunit").hide();
                            $("#sub_subunit").html('<option value="">[kosong]</option>');
                        
                        }
		}

	});

	$(document).on("change","#subunit",function(){
		if($(this).val()==''){

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');

		}else{
                    if(($('#jenis').val()==6)||($('#jenis').val()==7)){
                        
                    }
                    else{
                        $("#sub_subunit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_sub_subunit")?>",
						data:'kode_sub_subunit=' + $(this).val(),
						success:function(respon){
							$("#sub_subunit").html(respon);
						}
					})

					$("#div_sub_subunit").show();
                        
                    }
			
		}

	});


	<?php elseif($_SESSION['rba_level'] == '1'):?>
	$(document).on("change","#jenis",function(){
                $("#div_unit").hide();
                $("#unit").html('<option value="">[kosong]</option>');

                $("#div_subunit").hide();
                $("#sub_unit").html('<option value="">[kosong]</option>');

                $("#div_sub_subunit").hide();
                $("#sub_subunit").html('<option value="">[kosong]</option>');
                
		if($(this).val()==''){

			$("#div_unit").hide();
			$("#unit").html('<option value="">[kosong]</option>');

			$("#div_subunit").hide();
			$("#sub_unit").html('<option value="">[kosong]</option>');

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');
		}else{
			if(($(this).val()==1)||($(this).val()==2)||($(this).val()==3)||($(this).val()==4)||($(this).val()==5)||($(this).val()==6)||($(this).val()==7)||($(this).val()==8)||($(this).val()==9)){
				$("#unit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_unit")?>",
						data:'kode_unit=' + <?=$_SESSION['rba_kode_unit_subunit']?>,
						success:function(respon){
							$("#unit").html(respon);
						}
					})
					$("#div_unit").show();
                                        
                        }else if(($(this).val()==6)||($(this).val()==7)){
                        
                                $("#unit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_unit")?>",
						data:'kode_unit=' + <?=$_SESSION['rba_kode_unit_subunit']?>,
						success:function(respon){
							$("#unit").html(respon);
						}
					})
					$("#div_unit").show();
                        
			}else if(($(this).val()==8)||($(this).val()==9)){
                        
                                $("#unit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_unit")?>",
						data:'kode_unit=' + <?=$_SESSION['rba_kode_unit_subunit']?>,
						success:function(respon){
							$("#unit").html(respon);
						}
					})
					$("#div_unit").show();
                        
			}else{

                            $("#div_unit").hide();
                            $("#unit").html('<option value="">[kosong]</option>');

                            $("#div_subunit").hide();
                            $("#sub_unit").html('<option value="">[kosong]</option>');

                            $("#div_sub_subunit").hide();
                            $("#sub_subunit").html('<option value="">[kosong]</option>');
				

			}
		}

	});

	$(document).on("change","#unit",function(){
		if($(this).val()==''){

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');

			$("#div_subunit").hide();
			$("#subunit").html('<option value="">[kosong]</option>');

		}else if(($('#jenis').val()==6)||($('#jenis').val()==7)){
                    $("#subunit").removeAttr('disabled');
                                $.ajax({
                                        type:"POST",
                                        url :"<?=site_url("laporan/get_subunit")?>",
                                        data:'kode_subunit=' + $(this).val(),
                                        success:function(respon){
                                                $("#subunit").html(respon);
                                        }
                                })

                                $("#div_subunit").show();


		}else if(($('#jenis').val()==8)||($('#jenis').val()==9)){
                
                }else{
			
                        $("#subunit").removeAttr('disabled');
                                $.ajax({
                                        type:"POST",
                                        url :"<?=site_url("laporan/get_subunit")?>",
                                        data:'kode_subunit=' + $(this).val(),
                                        success:function(respon){
                                                $("#subunit").html(respon);
                                        }
                                })

                                $("#div_subunit").show();
			}

	});

        $(document).on("change","#subunit",function(){
		if($(this).val()==''){

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');

		}else{
                    if(($('#jenis').val()==6)||($('#jenis').val()==7)){
                        
                    }
                    else{
                        $("#sub_subunit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_sub_subunit")?>",
						data:'kode_sub_subunit=' + $(this).val(),
						success:function(respon){
							$("#sub_subunit").html(respon);
						}
					})

					$("#div_sub_subunit").show();
                        
                    }
			
		}

	});
	<?php elseif($_SESSION['rba_level'] == '100'):?>
	$(document).on("change","#jenis",function(){
                $("#div_unit").hide();
                $("#unit").html('<option value="">[kosong]</option>');

                $("#div_subunit").hide();
                $("#sub_unit").html('<option value="">[kosong]</option>');

                $("#div_sub_subunit").hide();
                $("#sub_subunit").html('<option value="">[kosong]</option>');
                
		if($(this).val()==''){

			$("#div_unit").hide();
			$("#unit").html('<option value="">[kosong]</option>');

			$("#div_subunit").hide();
			$("#sub_unit").html('<option value="">[kosong]</option>');

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');
		}else{
			if(($(this).val()==1)||($(this).val()==2)||($(this).val()==3)||($(this).val()==4)||($(this).val()==5)||($(this).val()==6)||($(this).val()==7)||($(this).val()==8)||($(this).val()==9)){
				$("#unit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_unit")?>",
						data:'kode_unit=' + <?=$_SESSION['rba_kode_unit_subunit']?>,
						success:function(respon){
							$("#unit").html(respon);
						}
					})
					$("#div_unit").show();
                                        
                        }else if(($(this).val()==6)||($(this).val()==7)){
                        
                                $("#unit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_unit")?>",
						data:'kode_unit=' + <?=$_SESSION['rba_kode_unit_subunit']?>,
						success:function(respon){
							$("#unit").html(respon);
						}
					})
					$("#div_unit").show();
                        
			}else if(($(this).val()==8)||($(this).val()==9)){
                        
                                $("#unit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_unit")?>",
						data:'kode_unit=' + <?=$_SESSION['rba_kode_unit_subunit']?>,
						success:function(respon){
							$("#unit").html(respon);
						}
					})
					$("#div_unit").show();
                        
			}else{

                            $("#div_unit").hide();
                            $("#unit").html('<option value="">[kosong]</option>');

                            $("#div_subunit").hide();
                            $("#sub_unit").html('<option value="">[kosong]</option>');

                            $("#div_sub_subunit").hide();
                            $("#sub_subunit").html('<option value="">[kosong]</option>');
				

			}
		}

	});

	$(document).on("change","#unit",function(){
		if($(this).val()==''){

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');

			$("#div_subunit").hide();
			$("#subunit").html('<option value="">[kosong]</option>');

		}else if(($('#jenis').val()==6)||($('#jenis').val()==7)){
                    $("#subunit").removeAttr('disabled');
                                $.ajax({
                                        type:"POST",
                                        url :"<?=site_url("laporan/get_subunit")?>",
                                        data:'kode_subunit=' + $(this).val(),
                                        success:function(respon){
                                                $("#subunit").html(respon);
                                        }
                                })

                                $("#div_subunit").show();


		}else if(($('#jenis').val()==8)||($('#jenis').val()==9)){
                
                }else{
			
                        $("#subunit").removeAttr('disabled');
                                $.ajax({
                                        type:"POST",
                                        url :"<?=site_url("laporan/get_subunit")?>",
                                        data:'kode_subunit=' + $(this).val(),
                                        success:function(respon){
                                                $("#subunit").html(respon);
                                        }
                                })

                                $("#div_subunit").show();
			}

	});

        $(document).on("change","#subunit",function(){
		if($(this).val()==''){

			$("#div_sub_subunit").hide();
			$("#sub_subunit").html('<option value="">[kosong]</option>');

		}else{
                    if(($('#jenis').val()==6)||($('#jenis').val()==7)){
                        
                    }
                    else{
                        $("#sub_subunit").removeAttr('disabled');
					$.ajax({
						type:"POST",
						url :"<?=site_url("laporan/get_sub_subunit")?>",
						data:'kode_sub_subunit=' + $(this).val(),
						success:function(respon){
							$("#sub_subunit").html(respon);
						}
					})

					$("#div_sub_subunit").show();
                        
                    }
			
		}

	});


	<?php endif;?>


	$(document).on("change","#usulan_belanja",function(){
		if($(this).val()!=""){

		}else{
			
		}

	});


			


});

function string_to_angka(str){

	
	return str.split('.').join("");
	
}

function angka_to_string(num){

	var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

	return str_hasil;
}

//var valnow = 0 ; 
//
//var count_r = 0 ;

function doing_calc(){
    
    var valnow = 0 ; 

    var count_r = $('[class^="kegiatan_"]').length + $('[class^="total_sub_sub_volume_"]').length + $('[class^="total_sub_volume_"]').length + $('[class^="total_sub_akun_"]').length + $('[class^="akun_"]').length + $('[class^="subkomponen_"]').length  + $('[class^="komponen_"]').length
                                + $('[class^="program_"]').length + $('[class^="output_"]').length + $('[class^="akun_"]').length + $('[class^="jenis_subkomponen_"]').length + $('[class^="jenis_komponen_"]').length + $("#rekap tbody tr.ishidden").length ;
    
    var dly = 0 ;
                        
    // count_r = $('[class^="total_sub_sub_volume_"]').length + $('[class^="total_sub_volume_"]').length + $('[class^="total_sub_akun_"]').length + $('[class^="akun_"]').length + $('[class^="subkomponen_"]').length  + $('[class^="komponen_"]').length
    //                           + $('[class^="program_"]').length + $('[class^="output_"]').length + $('[class^="akun_"]').length + $('[class^="jenis_subkomponen_"]').length + $('[class^="jenis_komponen_"]').length  ;
                       
//                        console.log(' count_r : ' + count_r);

                                
                           <?php if($_SESSION['rba_level'] != '5'): ?> 
                                   
                                $('[class^="total_sub_sub_volume_"]').each(function(){
                                    var akun = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                    
                                    setTimeout( function(){
                                        
					$('[class^="total_sub_sub_volume_'+akun+'"]').each(function(){
						var total = parseInt($(this).text());
						ztotal = parseInt(ztotal) + parseInt(total) ;
//                                                console.log(ztotal);
                                                
					});
                                        
                                        $('.total_sub_volume_'+akun).text(ztotal);
                                        
                                        valnow++ ;
                                        
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                        
                                    },dly );
                                        
//                                        console.log(' percentage : ' + percentage);

				});
                               
                                
                                $('[class^="total_sub_volume_"]').each(function(){
                                    var akun = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                    
                                    setTimeout( function(){
					$('[class^="total_sub_volume_'+akun+'"]').each(function(){
						var total = parseInt($(this).text());
						ztotal = parseInt(ztotal) + parseInt(total) ;
                                                
                                                
					});
                                        
                                        $('.total_volume_'+akun).text(ztotal);
                                    
                                        valnow++ ;
					
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                        
                                    },dly );
                                    
//                                        console.log(' percentage : ' + percentage);
					
				});
                                
                                $('[class^="total_sub_akun_"]').each(function(){
                                    
                                    var akun = $(this).attr('rel') ;
                                    var ztotal = 0 ;
//                                    var i = 1 ;
//                                    console.log('k+'+akun +' :' + $('[class^="total_sub_akun_'+akun+'"]').length);
                                    setTimeout( function(){
//                                        console.log('j+'+akun +' :' + $('[class^="total_sub_akun_'+akun+'"]').length);
					$('[class^="total_sub_akun_'+akun+'"]').each(function(){
                                            
						var total = string_to_angka($(this).text());
						ztotal = parseFloat(ztotal) + parseFloat(total) ;
//                                                console.log('a-'+i+' :' + akun);
//                                                console.log('z-'+i+' :' + ztotal);
//						i++ ;

					});
                                        
                                        $('.akun_'+akun).text(angka_to_string(ztotal));
//                                        console.log('a :' + akun);
//                                        console.log('z :' + ztotal);
                                    
                                        valnow++ ;
                                        
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                        
                                    },dly );
                                    
//                                        console.log(' percentage : ' + percentage);
					
				});
                                
                           <?php // endif; ?>
                               
                                
				$('[class^="akun_"]').each(function(){
                                    
                                    var subkomponen = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                   
                                    setTimeout( function(){    
					$('[class^="akun_'+subkomponen+'"]').each(function(){

						var total = string_to_angka($(this).text());
						ztotal = parseFloat(ztotal) + parseFloat(total) ;

						
					});
                                        
                                        $('.subkomponen_'+subkomponen).text(angka_to_string(ztotal));
//                                        console.log('s :' + subkomponen);
//                                        console.log('z :' + ztotal);
                                        
                                        valnow++ ;
					
                                        go_progress("#progress-calc",valnow,count_r);
                                       
                                        
                                    },dly );
                                    
//                                        console.log(' percentage : ' + percentage);
					
				});
                                

				$('[class^="subkomponen_"]').each(function(){
                                    
                                    var komponen = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                   
                                   
                                    setTimeout( function(){
					$('[class^="subkomponen_'+komponen+'"]').each(function(){

						var total = string_to_angka($(this).text());
						ztotal = parseFloat(ztotal) + parseFloat(total) ;
    
						
					});
                                        
                                        $('.komponen_'+komponen).text(angka_to_string(ztotal));
                                    
                                        valnow++ ;
					
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                        
                                    },dly );
                                    
//                                        console.log(' percentage : ' + percentage);
					
				});
                                

				$('[class^="komponen_"]').each(function(){ 
                                    
                                    var program = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                        
                                    
                                    setTimeout( function(){
                                        
					$('[class^="komponen_'+program+'"]').each(function(){
						var total = string_to_angka($(this).text());
						ztotal = parseFloat(ztotal) + parseFloat(total) ;
						
					});
                                        valnow++ ;
					$('.program_'+program).text(angka_to_string(ztotal));
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                    },dly );   
//                                        console.log(' percentage : ' + percentage);
					
				});
                                

				$('[class^="program_"]').each(function(){
                                
                                    var output = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                    
                                    
                                    setTimeout( function(){
					$('[class^="program_'+output+'"]').each(function(){
						var total = string_to_angka($(this).text());
						ztotal = parseFloat(ztotal) + parseFloat(total) ;
						

					});
                                        valnow++ ;
					$('.output_'+output).text(angka_to_string(ztotal));
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                    },dly );  
                                     
//                                        console.log(' percentage : ' + percentage);

				});
                                

				$('[class^="output_"]').each(function(){
                                
                                    var kegiatan = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                    
                                    
                                    setTimeout( function(){
					$('[class^="program_'+kegiatan+'"]').each(function(){
						var total = string_to_angka($(this).text());
						ztotal = parseFloat(ztotal) + parseFloat(total) ;

					});
                                        valnow++ ;
					$('.kegiatan_'+kegiatan).text(angka_to_string(ztotal));
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                    },dly ); 
                                    
//                                        console.log(' percentage : ' + percentage);
					
				});
                                
                                $('[class^="kegiatan_"]').each(function(){
                                
                                    var total_global = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                    
                                    
                                    setTimeout( function(){
					$('[class^="kegiatan_'+total_global+'"]').each(function(){
						var total = string_to_angka($(this).text());
						ztotal = parseFloat(ztotal) + parseFloat(total) ;

					});
                                        valnow++ ;
					$('.total_global_'+total_global).text(angka_to_string(ztotal));
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                    },dly ); 
                                    
//                                        console.log(' percentage : ' + percentage);
					
				});
                                

				/////////////////////////////////////////////////

				$('[class^="akun_"]').each(function(){
                                    
                                    var jenis_subkomponen = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                    
                                    
                                    setTimeout( function(){
					$('[class^="akun_'+jenis_subkomponen+'"]').each(function(){
						var total = string_to_angka($(this).text());
						ztotal = parseFloat(ztotal) + parseFloat(total) ;
						

					});
                                        valnow++ ;
					$('.jenis_subkomponen_'+jenis_subkomponen).text(angka_to_string(ztotal));
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                    },dly ); 
                                    
//                                        console.log(' percentage : ' + percentage);
					
				});
                                
				$('[class^="jenis_subkomponen_"]').each(function(){
                              
                                    var jenis_komponen = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                    
                                    
                                    setTimeout( function(){
					$('[class^="jenis_subkomponen_'+jenis_komponen+'"]').each(function(){
						var total = string_to_angka($(this).text());
						ztotal = parseFloat(ztotal) + parseFloat(total) ;
						
					});
                                        valnow++ ;
					$('.jenis_komponen_'+jenis_komponen).text(angka_to_string(ztotal));
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                    },dly ); 
//                                        console.log(' percentage : ' + percentage);
					
				});

				$('[class^="jenis_komponen_"]').each(function(){
                          
                                    var jenis_biaya = $(this).attr('rel') ;
                                    var ztotal = 0 ;
                                    
                                    
                                    setTimeout( function(){
					$('[class^="jenis_komponen_'+jenis_biaya+'"]').each(function(){
						var total = string_to_angka($(this).text());
						ztotal = parseFloat(ztotal) + parseFloat(total) ;
						
					});
                                        valnow++ ;
                                        
					$('.jenis_biaya_'+jenis_biaya).text(angka_to_string(ztotal));
                                        
                                        go_progress("#progress-calc",valnow,count_r);
                                        
                                    },dly ); 
//                                        console.log(' percentage : ' + percentage);
					
				});
                                
                                
                                
        
                                $("#rekap tbody tr.ishidden").each(function () {
                                    var that = this;
                                    setTimeout( function(){
                                        // if($(this).css('visibility') == 'hidden' || $(this).css('display') == 'none'){
                                            $(that).remove();

                                            valnow++ ;

//    console.log(' v : ' + valnow);
//    console.log(' c : ' + count_r);
//    console.log(' percentage : ' + Math.floor(( valnow / count_r ) * 100));
//    console.log(' e : ' + $(that).attr('rel'));
                                            
                                            
                                            go_progress("#progress-calc",valnow,count_r);
                                            
                                   },dly );
                                    
                                });
                                
                                // $("#fixrekap").html( $("#rekap" ).html() );
                                
                                // $("#fixrekap").html( $("#rekap" ).html() );
                                
                                
                                
                                
                                

                               if((valnow == 0)&&(count_r == 0)){ // LAPORAN KK
                                   valnow = 100 ;
                                   count_r = 100 ;
                                   setTimeout( function(){
                                       go_progress("#progress-calc",valnow,count_r);
                                   },dly );
                               }
                                
                            // if ( valnow == count_r)
                            // {

                            // }
                               
                                
//                                console.log(' valnow : ' + valnow);

                                // if( percentage >= 100 ){
                                    // setTimeout(function(){$("#loading_view").modal('hide')}, 2000);
                                // }
                            
                            <?php else:?>
                                go_progress("#progress-calc",valnow,count_r);
                                
                            <?php endif; ?>
                                
                                
}


function go_progress(el,v,c){
    var percentage = Math.floor(( v / c ) * 100) ;
//    $("#progress-calc");
//    setTimeout(function() {
      $(el).css('width',percentage+'%').attr('aria-valuenow',percentage).html(percentage+'%');
//      $(el).animate({width:percentage+'%'}, 0).attr('aria-valuenow',percentage).html(percentage+'%');
//    }, 50);
//    $("#progress-calc");
//    if ( ( v / c ) * 100 >= 100)
//    {
//        setTimeout(function(){$("#loading_view").modal('hide')}, 1000);
//    }

//    console.log(' v : ' + v);
//    console.log(' c : ' + c);
//    console.log(' percentage : ' + percentage);

    if( percentage >= 100 ){
        
//        $(el).css('width','0%').attr('aria-valuenow','0').html('0%');
        // setTimeout(run_fixrekap,1000);


        setTimeout(function(){$("#loading_view").modal('hide')}, 1000);


    }

}

function run_fixrekap(){
    
        var rl = $("#rekap").find("*").filter(":hidden").length ;
        var nrl = 0 ;
       
        var percentage = 0 ;
        
        $("#fixrekap").html( $("#rekap" ).html() );
        
        $("#fixrekap").find("*").filter(":hidden").each(function () {
                                    
            setTimeout( function(){
                // if($(this).css('visibility') == 'hidden' || $(this).css('display') == 'none'){
                    $(this).remove()
                // }
                nrl++ ;
                
                percentage = Math.floor(( nrl / rl ) * 100) ;
                
//                console.log(' nrl : ' + nrl);
//                console.log(' rl : ' + rl);
//                console.log(' percentage : ' + percentage);

                
                $("#progress-calc").css('width',(100-percentage)+'%').attr('aria-valuenow',(100-percentage)).html('');//(100-percentage)+'%');
                $("#progress-down").css('width',percentage+'%').attr('aria-valuenow',percentage).html(percentage+'%');
                
                if( percentage >= 100 ){
        
                    setTimeout(function(){$("#loading_view").modal('hide')}, 1000);


                }

            },0 ); 
        });
        
    

//        $("#fixrekap").html( $("#rekap" ).html() );
    
}

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

function b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || '';
    sliceSize = sliceSize || 512;

    var byteCharacters = atob(b64Data);
    var byteArrays = [];

    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    var blob = new Blob(byteArrays, {type: contentType});
    return blob;
}

$(document).ready(function(){

	$(document).on("click","#down",function(){
                            
                            var uri = $("#rekap").excelexportjs({
                                    containerid: "rekap"
                                    , datatype: 'table'
                                    , returnUri: true
                                });
//                                
                            // $(this).attr('download', '<?=$file_name;?>').attr('href', uri).attr('target', '_blank');
                            
//                            var blob = new Blob([myJsonString], {
//                                type: "application/vnd.ms-excel;charset=charset=utf-8"
//                            });
                            var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");
                            
                            saveAs(blob, '<?=$file_name;?>');

//                            var tablestr = $("#rekap").get(0).outerHTML;
//                            var strenc = $.base64.encode( tablestr );
//                            var urienc = encodeURIComponent(tablestr);
//                            var lstr = tablestr.length ;
//                            
//                            $("#base64str").val(tablestr);
//                            $("#nama_file").val('<?=$file_name;?>');
//                            $("#lstr").val(lstr);
//                            $("#formdowntable").submit();
                            

                           

	});

	if ( $("#rekap").length ) {
            
            perform_calc();
//$("#excel_view").modal('show');
                       
            // $( "#down" ).trigger( "click" );
		            
	}
        
        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
        
        
});

</script>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="page-wrapper" >
<div id="page-inner">
 <div id="temp" style="display:none"></div> 

 	<table id="rekap" style="font-family:tahoma;font-size:14px; border-collapse: separate;width: auto;" cellspacing="0px" border="1">
		<tbody>
			<tr>
				<td colspan="<?=8+count($akun_dipakai)?>" align="center" border="2"><b>REKAPITULASI RENCANA KERJA DAN ANGGARAN</b></td>
			</tr>
			<tr>
				<td colspan="<?=8+count($akun_dipakai)?>" align="center"><b>TAHUN ANGGARAN <?=$tahun?></b></td>
			</tr>
			<tr>
				<td colspan="<?=8+count($akun_dipakai)?>" align="center"><b>SUMBER DANA <?=$sumber_dana?></b></td>
			</tr>
			<tr>
				<td >UNIT KERJA</td>
				<td colspan="<?=7+count($akun_dipakai)?>">: <?=$unit?> (<?=$kode_unit?>)</td>
			</tr>
			<tr>
				<td >TOTAL ANGGARAN</td>
				<td colspan="<?=7+count($akun_dipakai)?>">: Rp. <span class="total_global_0">0</span><?php // echo number_format($total_anggaran, 0, ",", ".");?></td>
			</tr>
			<tr>
				<td style="text-align:center" rowspan="2"><b>TUJUAN/SASARAN</b></td>
				<td style="text-align:center" rowspan="2"><b>PROGRAM</b></td>
				<td style="text-align:center" rowspan="2"><b>KEGIATAN</b></td>
				<td style="text-align:center" rowspan="2"><b>SUB KEGIATAN</b></td>
				<td style="text-align:center" rowspan="2"><b>SUB UNIT KERJA</b></td>
				<td style="text-align:center" colspan="2" ><b>TARGET</b></td>
				<?php if(count($akun_dipakai)>0){ ?>
				<td style="text-align:center" colspan="<?=count($akun_dipakai)?>" ><b>AKUN</b></td>
				<?php }?>
				<td style="text-align:center" rowspan="2" ><b>JUMLAH</b></td>
			</tr>
			<tr>
				<td style="text-align:center" ><b>VOLUME</b></td>
				<td style="text-align:center" ><b>SATUAN</b></td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style="text-align:center" ><b><?=$akun?></b></td>
				<?php } ?>
			</tr>

			<?php $n = 0;?>
			<?php $check_kode_1  = array(); ?>
			<?php $check_kode_2  = array(); ?>
			<?php $check_kode_3  = array(); ?>
			<?php $check_kode_4  = array(); ?>
			<?php $check_kode_5  = array(); ?>

			<?php $check_unit_ = array() ;?>

			<?php $check_user = array() ; ?>
                        
                        <?php $check_kriteria = array() ; ?>
                        
                        <?php $check_user_sub_subunit = array() ; ?>

			<?php foreach($kode as $k){?>

			<?php $is_exist = false ; ?>

			<?php foreach($data_rekap_belanja as $dr){

//					if(!empty($dt)){
//						foreach($dt as $d_){
							if($dr['u_unit'].$dr['kriteria_usul']==substr($k['kode_subkomponen_input'],0,4).substr($k['kode_subkomponen_input'],6,10)){
								$is_exist = true;
								break;
							}

//						}
//					} 

			 } ?>

			<?php if($is_exist){ ?>

			<?php if (!(in_array($rincian_kode_usulan[$n]->kode_kegiatan, $check_kode_1))){ ?>
			<tr class="alert alert-danger" style="font-weight: bold;font-size: 18px;" >
				<td colspan="3" >Tujuan : (<?=$rincian_kode_usulan[$n]->kode_kegiatan?>) <?=$rincian_kode_usulan[$n]->nama_kegiatan?></td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="1" class="kegiatan_<?=$akun.substr($k['kode_subkomponen_input'],6,2)?>">0</td>
				<?php } ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="0" class="kegiatan_<?=substr($k['kode_subkomponen_input'],6,2)?>">0</td>
			</tr>
			<?php $check_kode_1[] = $rincian_kode_usulan[$n]->kode_kegiatan; $check_kode_2  = array(); $check_kode_3  = array(); $check_kode_4  = array(); $check_kode_5  = array(); $check_user = array() ; $check_user_sub_subunit = array() ; }else{  }?>

			<?php if (!(in_array($rincian_kode_usulan[$n]->kode_output, $check_kode_2))){ ?>
			<tr class="alert alert-success" style="font-weight: bold;font-size: 16px;">
				<td colspan="3" >(<?=$rincian_kode_usulan[$n]->kode_output?>) <?=$rincian_kode_usulan[$n]->nama_output?></td>
				<td >&nbsp;</td> 
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=$akun.substr($k['kode_subkomponen_input'],6,2)?>" class="output_<?=$akun.substr($k['kode_subkomponen_input'],6,4)?>">0</td>
				<?php } ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=substr($k['kode_subkomponen_input'],6,2)?>" class="output_<?=substr($k['kode_subkomponen_input'],6,4)?>">0</td>
			</tr>
			<?php $check_kode_2[] = $rincian_kode_usulan[$n]->kode_output; $check_kode_3  = array(); $check_kode_4  = array(); $check_kode_5  = array(); $check_user = array() ; $check_user_sub_subunit = array() ; }else{  }?>
			
			<?php if (!(in_array($rincian_kode_usulan[$n]->kode_program, $check_kode_3))){ ?>
			<tr class="alert alert-warning" style="font-weight: bold;font-style: italic;font-size: 16px;">
				<td >&nbsp;</td>
				<td colspan="2" >(<?=$rincian_kode_usulan[$n]->kode_program?>) <?=$rincian_kode_usulan[$n]->nama_program?></td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=$akun.substr($k['kode_subkomponen_input'],6,4)?>" class="program_<?=$akun.substr($k['kode_subkomponen_input'],6,6)?>">0</td>
				<?php } ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=substr($k['kode_subkomponen_input'],6,4)?>" class="program_<?=substr($k['kode_subkomponen_input'],6,6)?>">0</td>
			</tr>
			<?php $check_kode_3[] = $rincian_kode_usulan[$n]->kode_program; $check_kode_4  = array(); $check_kode_5  = array(); $check_user = array() ; $check_user_sub_subunit = array() ; }else{  }?>

			<?php if (!(in_array($rincian_kode_usulan[$n]->kode_komponen, $check_kode_4))){ ?>
			<tr class="alert alert-info" style="font-weight: bold;font-size: 14px;">
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >(<?=$rincian_kode_usulan[$n]->kode_komponen?>) <?=$rincian_kode_usulan[$n]->nama_komponen?></td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=$akun.substr($k['kode_subkomponen_input'],6,6)?>" class="komponen_<?=$akun.substr($k['kode_subkomponen_input'],6,8)?>">0</td>
				<?php } ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=substr($k['kode_subkomponen_input'],6,6)?>" class="komponen_<?=substr($k['kode_subkomponen_input'],6,8)?>">0</td>
			</tr>
			<?php $check_kode_4[] = $rincian_kode_usulan[$n]->kode_komponen; $check_kode_5  = array(); $check_user = array() ; $check_user_sub_subunit = array() ; }else{ }?>
			<?php if (!(in_array($rincian_kode_usulan[$n]->kode_subkomponen, $check_kode_5))){ ?>
			<tr class="alert bg-ijo-pupus" style="font-weight: bold;font-style: italic;font-size: 14px;">
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >(<?=$rincian_kode_usulan[$n]->kode_subkomponen?>) <?=$rincian_kode_usulan[$n]->nama_subkomponen?></td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=$akun.substr($k['kode_subkomponen_input'],6,8)?>" class="subkomponen_<?=$akun.substr($k['kode_subkomponen_input'],6,10)?>">0</td>
				<?php } ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=substr($k['kode_subkomponen_input'],6,8)?>" class="subkomponen_<?=substr($k['kode_subkomponen_input'],6,10)?>">0</td>
			</tr>
			<?php $check_kode_5[] = $rincian_kode_usulan[$n]->kode_subkomponen; $check_user = array() ; $check_user_sub_subunit = array() ; }else{ }?>

			<?php $i = 1 ; ?>
			<?php $check_unit = '';?>
			<?php $sub_total = 0 ; ?>
                        <?php // $sum_total = 0 ; ?>
                        
                        <?php if (!(in_array(substr($k['kode_subkomponen_input'],0,4).substr($k['kode_subkomponen_input'],6,10), $check_kriteria))){ ?>
                        
			<?php foreach($data_rekap_belanja as $rekap_belanja) { ?>
                        
                                <?php if($rekap_belanja['kriteria_usul'] == substr($k['kode_subkomponen_input'],6,10)){?>
                                    <tr >
                                            <td >&nbsp;</td>
                                            <td >&nbsp;</td>
                                            <td >&nbsp;</td>
                                            <td >&nbsp;</td>
                                            <td ><b><?php echo get_unit_name($rekap_belanja['u_unit']) ;?></b></td>
                                            <td class="total_volume_<?=substr($k['kode_subkomponen_input'],6,10).$rekap_belanja['u_unit']?>"><?=$rekap_belanja['volume_b']?></td>
                                            <td ><?=$k['indikator_keluaran']?></td>
                                            
                                            <?php $sum_total = 0 ; ?>
                                            <?php foreach($akun_dipakai as $akun) { ?>
                                                <?php $j = 0 ;?>
                                                <?php $f = false ;?>
                                                <?php foreach($rekap_belanja['kode_akun'] as $akun_ ) { 
                                                    if($akun_ == $akun){
                                                        $f = true ;
                                                        
                                                        break;
                                                    }
                                                    $j++;
                                                } ?>
                                                    <?php // $k_u = isset($rekap_belanja['kode_akun'][$j])?$rekap_belanja['kode_akun'][$j]:'' ; ?>
                                                    <?php if($f == true){?>
                                                        <td rel="<?=$akun.substr($k['kode_subkomponen_input'],6,10)?>" class="akun_<?=$akun.substr($k['kode_subkomponen_input'],6,10).$rekap_belanja['u_unit']?>" style='text-align: right;mso-number-format:"\@";'><?=number_format($rekap_belanja['total_b'][$j], 0, ",", ".")?></td>
                                                        <?php $sum_total = $sum_total + $rekap_belanja['total_b'][$j]; ?>
                                                        <?php // $j = 0 ; $f = FALSE ;  ?>
                                                    <?php }else{ ?>
                                                        <td rel="<?=$akun.substr($k['kode_subkomponen_input'],6,10)?>" class="akun_<?=$akun.substr($k['kode_subkomponen_input'],6,10).$rekap_belanja['u_unit']?>" style='text-align: right;mso-number-format:"\@";'>0</td>
                                                    <?php } ?>
                                                <?php // } ?>
                                                
                                            <?php } ?>
                                            <td  rel="<?=substr($k['kode_subkomponen_input'],6,10)?>"  class="akun_<?=substr($k['kode_subkomponen_input'],6,10).$rekap_belanja['u_unit']?>" style='text-align: right;mso-number-format:"\@";'><?=number_format($sum_total, 0, ",", ".")?></td>
                                    </tr>
                                    
                                    
                                    
                                    
                                <?php $check_kriteria[] = $rekap_belanja['u_unit'].$rekap_belanja['kriteria_usul']; ?>
                                    
                                <?php } ?>
                                
                        <?php } ?>
                                    
                        <?php } ?>
                                
			
			<?php } ?>

			<?php $n++ ; ?>

			<?php } ?>
			
		</tbody>
	</table>
</div> 
</div>



          