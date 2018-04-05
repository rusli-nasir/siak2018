<script type="text/javascript">
$(document).ready(function(){

    $("#sumber_dana").val("<?=$sumber_dana?>");
    $("#unit").val("<?=$unit?>");
    $("#triwulan").val("<?=$triwulan?>");


    $('#<?=$a_tab?>').addClass('active');
	

    // var tot_a = 0 ;
    
    // $('[class^="kode_akun_a_"]').each(function(){

    //     var kode_akun = $(this).attr('rel');

    //     // console.log(kode_akun);

    //     var el = $(this);

        

    //     $.ajax({
    //                 type:"POST",
    //                 url :"<?=site_url("serapan/get_anggaran/")?>" + kode_akun + '/<?=$sumber_dana?>/<?=$unit?>/<?=$tahun?>' ,
    //                 data:'',
    //                 success:function(respon){
    //                     el.text(angka_to_string(respon));
    //                     tot_a = tot_a + parseInt(respon) ;
    //                     $('#tot_a').html('<b>' + angka_to_string(tot_a) + '</b>');
    //                 }
    //         })

    // });

    // var tot_s = 0 ;

    // $('[class^="kode_akun_s_"]').each(function(){

    //     var kode_akun = $(this).attr('rel');

    //     // console.log(kode_akun);

    //     var el = $(this);

        

    //     $.ajax({
    //                 type:"POST",
    //                 url :"<?=site_url("serapan/get_serapan/")?>" + kode_akun + '/<?=$sumber_dana?>/<?=$unit?>/<?=$tahun?>/<?=$triwulan?>' ,
    //                 data:'',
    //                 success:function(respon){
    //                     el.text(angka_to_string(respon));
    //                     tot_s = tot_s + parseInt(respon) ;
    //                     $('#tot_s').html('<b>' + angka_to_string(tot_s) + '</b>');
    //                 }
    //         })

    // });

    
        
// });

// $(document).ajaxStop(function () {
      // 0 === $.active

    var tot_b = 0 ;
    var tot_c = 0 ;

    var s_tot_a = $('#tot_a').text();
    var s_tot_s = $('#tot_s').text();

    $('[class^="kode_akun_b_"]').each(function(){

        var kode_akun = $(this).attr('rel');

        // console.log(kode_akun);

        var el = $(this);

        var anggaran = string_to_angka($(".kode_akun_a_" + kode_akun).text());
        var serapan = string_to_angka($(".kode_akun_s_" + kode_akun).text());

        console.log('anggaran ='+anggaran);
        console.log('serapan ='+serapan);

        var n = 0 ;

        if(parseInt(anggaran) > parseInt(serapan)){

            n = parseInt(anggaran) - parseInt(serapan) ;
            console.log('n ='+n);
            tot_b = tot_b + n ;
            console.log('tot_b ='+tot_b);

            el.text('(' + angka_to_string(n) + ')');

        }else{
            n = parseInt(serapan) - parseInt(anggaran) ;
            console.log('n ='+n);
            tot_b = tot_b + n ;
            console.log('tot_b ='+tot_b);

            if (anggaran == 0) {
                // n = '';
                // $(".kode_akun_a_" + kode_akun).text('');

            }

            el.text(angka_to_string(n));

        }

        $('#tot_b').html('<b>' + angka_to_string(tot_b) + '</b>');


        var p = 0 ;

        if( parseInt(serapan) > 0 && parseInt(anggaran) > 0 ){
            // p = Math.round((parseFloat(serapan)/parseFloat(anggaran))*100 * 10) / 10;
            p = parseFloat(((parseFloat(serapan)/parseFloat(anggaran))*100 * 10) / 10);
            p = p.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0] ;
        }
        console.log('p ='+p);

        $('.kode_akun_c_' + kode_akun).text(p+'%');

        console.log('----==-----');
    });


    var p2 = 0 ;
    if( parseInt(tot_b) > 0 && parseInt(string_to_angka(s_tot_a)) > 0){
        var tot_a = parseInt(string_to_angka(s_tot_a));
        var tot_s = parseInt(string_to_angka(s_tot_s));
        // p2 = Math.round((parseFloat(tot_s)/parseFloat(tot_a))*100 * 10) / 10;
        p2 = parseFloat(((parseFloat(tot_s)/parseFloat(tot_a))*100 * 10) / 10);
        p2 = p2.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0] ;
    }
    console.log('p2 ='+p2);

    if (tot_a > tot_s) {
        $('#tot_b').html('('+$('#tot_b').html()+')');
    }
    $('#tot_c').html('<b>' + angka_to_string(p2) + '%</b>');

    ////

    $('[class^="kode_akun_b2_"]').each(function(){

        var kode_akun = $(this).attr('rel');

        // console.log(kode_akun);

        var el = $(this);

        var anggaran = string_to_angka($(".kode_akun_a2_" + kode_akun).text());
        var serapan = string_to_angka($(".kode_akun_s2_" + kode_akun).text());

        // console.log(anggaran);

        var n = 0 ;

        if(parseInt(anggaran) > parseInt(serapan)){

            n = parseInt(anggaran) - parseInt(serapan) ;

            // tot_b = tot_b + n ;

            el.text('(' + angka_to_string(n) + ')');

        }else{

            n = parseInt(serapan) - parseInt(anggaran) ;

            // tot_b = tot_b + n ;

            el.text(angka_to_string(n));

        }

        // $('#tot_b').html('<b>' + angka_to_string(tot_b) + '</b>');


        var p = 0 ;

        if( parseInt(serapan) > 0 ){
            // p = Math.round((parseFloat(serapan)/parseFloat(anggaran))*100 * 10) / 10;
            p = parseFloat(((parseFloat(serapan)/parseFloat(anggaran))*100 * 10) / 10);
            p = p.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0] ;
        }

        $('.kode_akun_c2_' + kode_akun).text(p+'%');

    });


    ////

    $('[class^="kode_akun_b1_"]').each(function(){

        var kode_akun = $(this).attr('rel');

        // console.log(kode_akun);

        var el = $(this);

        var anggaran = string_to_angka($(".kode_akun_a1_" + kode_akun).text());
        var serapan = string_to_angka($(".kode_akun_s1_" + kode_akun).text());

        // console.log(anggaran);

        var n = 0 ;

        if(parseInt(anggaran) > parseInt(serapan)){

            n = parseInt(anggaran) - parseInt(serapan) ;

            // tot_b = tot_b + n ;

            el.text('(' + angka_to_string(n) + ')');

        }else{

            n = parseInt(serapan) - parseInt(anggaran) ;

            // tot_b = tot_b + n ;

            el.text(angka_to_string(n));

        }

        // $('#tot_b').html('<b>' + angka_to_string(tot_b) + '</b>');


        var p = 0 ;

        if( parseInt(serapan) > 0 ){
            // p = Math.round((parseFloat(serapan)/parseFloat(anggaran))*100 * 10) / 10;
            p = parseFloat(((parseFloat(serapan)/parseFloat(anggaran))*100 * 10) / 10);
            p = p.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
        }

        $('.kode_akun_c1_' + kode_akun).text(p+'%');

    });

    var scrollEventHandler = function() {
        if($('#panel-user').visible()) { 
                $('#panel_buka_semua').hide();
            } else {
                if($('#o-table').visible()){
                	if ($(window).width() < 769) {
                		$('#panel_buka_semua').hide();
                	}
                	else {
                		$('#panel_buka_semua').show();
                	}
                }
            }  

    };

    function unbindScrollEventHandler() {
        $(document).unbind('scroll', scrollEventHandler);
    }

    $(document).scroll(scrollEventHandler);

    function isScrolledIntoView(el) {
        var elemTop = el.getBoundingClientRect().top;
        var elemBottom = el.getBoundingClientRect().bottom;

        var isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
        console.log(elemTop);
        console.log(elemBottom);
        return isVisible;
    }

    $(document).on("change","[id^='btn_buka_semua_4d']",function(){
        // var kode_akun = $(this).attr('rel');
        var kode_akun = '';
        if ($(this).prop('checked') == true) {
            $("#btn_buka_semua_6d").prop('checked',false);
            if($("[id^='row_collapse_2d_"+kode_akun+"']").hasClass("out")) {
                $("[id^='row_collapse_2d_"+kode_akun+"']").addClass("in");
                $("[id^='row_collapse_2d_"+kode_akun+"']").removeClass("out");
            }
            if($("[id^='row_collapse_3d_"+kode_akun+"']").hasClass("out")) {
                $("[id^='row_collapse_3d_"+kode_akun+"']").addClass("in");
                $("[id^='row_collapse_3d_"+kode_akun+"']").removeClass("out");
            }
            if($("[id^='row_collapse_4d_"+kode_akun+"']").hasClass("out")) {
                $("[id^='row_collapse_4d_"+kode_akun+"']").addClass("in");
                $("[id^='row_collapse_4d_"+kode_akun+"']").removeClass("out");
            }
            if($("[id^='row_collapse_5d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_5d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_5d_"+kode_akun+"']").removeClass("in");
            }
            if($("[id^='row_collapse_6d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_6d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_6d_"+kode_akun+"']").removeClass("in");
            }
        }else{

            if($("[id^='row_collapse_2d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_2d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_2d_"+kode_akun+"']").removeClass("in");
            }
            if($("[id^='row_collapse_3d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_3d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_3d_"+kode_akun+"']").removeClass("in");
            }
            if($("[id^='row_collapse_4d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_4d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_4d_"+kode_akun+"']").removeClass("in");
            }
            if($("[id^='row_collapse_5d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_5d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_5d_"+kode_akun+"']").removeClass("in");
            }
            if($("[id^='row_collapse_6d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_6d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_6d_"+kode_akun+"']").removeClass("in");
            }
        }

        return true
    });

    $(document).on("change","[id^='btn_buka_semua_6d']",function(){
        // var kode_akun = $(this).attr('rel');
        var kode_akun = '';
        if ($(this).prop('checked') == true) {
            $("#btn_buka_semua_4d").prop('checked',false);
            if($("[id^='row_collapse_2d_"+kode_akun+"']").hasClass("out")) {
                $("[id^='row_collapse_2d_"+kode_akun+"']").addClass("in");
                $("[id^='row_collapse_2d_"+kode_akun+"']").removeClass("out");
            }
            if($("[id^='row_collapse_3d_"+kode_akun+"']").hasClass("out")) {
                $("[id^='row_collapse_3d_"+kode_akun+"']").addClass("in");
                $("[id^='row_collapse_3d_"+kode_akun+"']").removeClass("out");
            }
            if($("[id^='row_collapse_4d_"+kode_akun+"']").hasClass("out")) {
                $("[id^='row_collapse_4d_"+kode_akun+"']").addClass("in");
                $("[id^='row_collapse_4d_"+kode_akun+"']").removeClass("out");
            }
            if($("[id^='row_collapse_5d_"+kode_akun+"']").hasClass("out")) {
                $("[id^='row_collapse_5d_"+kode_akun+"']").addClass("in");
                $("[id^='row_collapse_5d_"+kode_akun+"']").removeClass("out");
            }
            if($("[id^='row_collapse_6d_"+kode_akun+"']").hasClass("out")) {
                $("[id^='row_collapse_6d_"+kode_akun+"']").addClass("in");
                $("[id^='row_collapse_6d_"+kode_akun+"']").removeClass("out");
            }
        }else{

            if($("[id^='row_collapse_2d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_2d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_2d_"+kode_akun+"']").removeClass("in");
            }
            if($("[id^='row_collapse_3d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_3d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_3d_"+kode_akun+"']").removeClass("in");
            }
            if($("[id^='row_collapse_4d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_4d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_4d_"+kode_akun+"']").removeClass("in");
            }
            if($("[id^='row_collapse_5d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_5d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_5d_"+kode_akun+"']").removeClass("in");
            }
            if($("[id^='row_collapse_6d_"+kode_akun+"']").hasClass("in")) {
                $("[id^='row_collapse_6d_"+kode_akun+"']").addClass("out");
                $("[id^='row_collapse_6d_"+kode_akun+"']").removeClass("in");
            }
        }

        return true
    });

    $(document).on("click","[id^='row_collapse_2d_']",function(){
        var kode_akun = $(this).attr('rel');

        if($("[id^='row_collapse_3d_"+kode_akun+"']").hasClass("out")) {
            $("[id^='row_collapse_3d_"+kode_akun+"']").addClass("in");
            $("[id^='row_collapse_3d_"+kode_akun+"']").removeClass("out");
        } else {
            $("[id^='row_collapse_3d_"+kode_akun+"']").addClass("out");
            $("[id^='row_collapse_3d_"+kode_akun+"']").removeClass("in");
        }

        if($("[id^='row_collapse_4d_"+kode_akun+"']").hasClass("in")) {
            $("[id^='row_collapse_4d_"+kode_akun+"']").addClass("out");
            $("[id^='row_collapse_4d_"+kode_akun+"']").removeClass("in");
        }
        if($("[id^='row_collapse_5d_"+kode_akun+"']").hasClass("in")) {
            $("[id^='row_collapse_5d_"+kode_akun+"']").addClass("out");
            $("[id^='row_collapse_5d_"+kode_akun+"']").removeClass("in");
        }
        if($("[id^='row_collapse_6d_"+kode_akun+"']").hasClass("in")) {
            $("[id^='row_collapse_6d_"+kode_akun+"']").addClass("out");
            $("[id^='row_collapse_6d_"+kode_akun+"']").removeClass("in");
        }
    });

    $(document).on("click","[id^='row_collapse_3d_']",function(){
        var kode_akun = $(this).attr('rel');

        if($("[id^='row_collapse_4d_"+kode_akun+"']").hasClass("out")) {
            $("[id^='row_collapse_4d_"+kode_akun+"']").addClass("in");
            $("[id^='row_collapse_4d_"+kode_akun+"']").removeClass("out");
        } else {
            $("[id^='row_collapse_4d_"+kode_akun+"']").addClass("out");
            $("[id^='row_collapse_4d_"+kode_akun+"']").removeClass("in");
        }

        if($("[id^='row_collapse_5d_"+kode_akun+"']").hasClass("in")) {
            $("[id^='row_collapse_5d_"+kode_akun+"']").addClass("out");
            $("[id^='row_collapse_5d_"+kode_akun+"']").removeClass("in");
        }
        if($("[id^='row_collapse_6d_"+kode_akun+"']").hasClass("in")) {
            $("[id^='row_collapse_6d_"+kode_akun+"']").addClass("out");
            $("[id^='row_collapse_6d_"+kode_akun+"']").removeClass("in");
        }
    });

    $(document).on("click","[id^='row_collapse_4d_']",function(){
        var kode_akun = $(this).attr('rel');

        if($("[id^='row_collapse_5d_"+kode_akun+"']").hasClass("out")) {
            $("[id^='row_collapse_5d_"+kode_akun+"']").addClass("in");
            $("[id^='row_collapse_5d_"+kode_akun+"']").removeClass("out");
        } else {
            $("[id^='row_collapse_5d_"+kode_akun+"']").addClass("out");
            $("[id^='row_collapse_5d_"+kode_akun+"']").removeClass("in");
        }

        if($("[id^='row_collapse_6d_"+kode_akun+"']").hasClass("in")) {
            $("[id^='row_collapse_6d_"+kode_akun+"']").addClass("out");
            $("[id^='row_collapse_6d_"+kode_akun+"']").removeClass("in");
        }
    });

    $(document).on("click","[id^='row_collapse_5d_']",function(){
        var kode_akun = $(this).attr('rel');

        if($("[id^='row_collapse_6d_"+kode_akun+"']").hasClass("out")) {
            $("[id^='row_collapse_6d_"+kode_akun+"']").addClass("in");
            $("[id^='row_collapse_6d_"+kode_akun+"']").removeClass("out");
        } else {
            $("[id^='row_collapse_6d_"+kode_akun+"']").addClass("out");
            $("[id^='row_collapse_6d_"+kode_akun+"']").removeClass("in");
        }

    });
});



    $(document).on("click","#dl",function(){

        $('#tb-hidden').html($('#tb-isi').html());


        $('#tb-hidden').find('td').css('border','1px solid #000');

        var uri = $("#table-serapan").excelexportjs({
                                    containerid: "table-serapan"
                                    , datatype: "table"
                                    , returnUri: true
                                });

        // var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");


        // var uri = tablesToExcel(['table_spp','table_f1a','table_spj','table_rekapakun'], ['SPP','F1A','SPJ','REKAP'], 'download_rsa_excel.xls');

        // var uri = tablesToExcel(['table_spp'], ['SPP'], 'download_rsa_excel.xls');

        // (['tbl1','tbl2'], ['ProductDay1','ProductDay2'], 'TestBook.xls', 'Excel')

        var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");
        
        saveAs(blob, 'download_serapan_dikti.xls');

        // tablesToExcel(['table_spp','table_spp'], ['first','second'], 'myfile.xls');
        // tablesToExcel(['1', '2'], ['first', 'second'], 'myfile.xls');
    });


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

        <?php if($r_unit != '99') : ?>
        window.location.href = "<?=site_url('/serapan/index/')?>" + $('#sumber_dana').val() + '/' + $('#triwulan').val() ;
        <?php else: ?>
        window.location.href = "<?=site_url('/serapan/index/')?>" + $('#sumber_dana').val() + '/' + $('#triwulan').val() + '/' + $('#unit').val() ;
        <?php endif; ?>
 
    }
    
    
});


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
                     <h2>REALISASI</h2>    
                    </div>
                </div>
                <hr />
                <div class="row">  
                    <div class="col-lg-12">

                    <div class="row">

                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" id="a-undip" ><a href="<?=site_url('serapan/index')?>" >AKUN UNDIP</a></li>
                            <!-- <li role="presentation" id="a-dikti" ><a href="<?=site_url('serapan/dikti')?>" >AKUN DIKTI</a></li> -->
                        </ul>
                    </div>

                    <br />

                    </div>

<div class="row">
                    <div class="col-sm-8">

<form class="form-horizontal alert alert-warning" method="post" id="form_dpa" action="">
        <?php if($r_unit == '99'): ?>
        <div class="form-group"  >
            <label for="input1" class="col-md-4 control-label">Unit</label>
            <div class="col-md-8">
                <select name="unit" id="unit" class="validate[required] form-control">
                    <!--<option value="">-pilih-</option>-->
                    <option value="99">99 - [ SEMUA ]</option>
                    <?php foreach($data_unit as $du): ?>
                    <option value="<?=$du->kode_unit?>"><?=$du->kode_unit?> - <?=$du->nama_unit?> [ <?=$du->alias?> ]</option>
                    <?php endforeach; ?>
                    <option value="99">99 - [ SEMUA ]</option>
                </select>
            </div>
        </div>
        <?php endif; ?>
        <div class="form-group"  >
            <label for="input1" class="col-md-4 control-label">Triwulan</label>
            <div class="col-md-8">
                <select name="triwulan" id="triwulan" class="validate[required] form-control">
                    <!--<option value="">-pilih-</option>-->
                    <option value="1">[ S/D - 31 Maret ] - KE I</option>
                    <option value="2">[ S/D - 30 Juni ] - KE II</option>
                    <option value="3">[ S/D - 30 September ] - KE III</option>
                    <option value="4">[ S/D - 31 Desember ] - KE IV</option>
                    <option value="5">[ S/D - Sekarang ]</option>
                </select>
            </div>
        </div>

        <div class="form-group"  >
            <label for="input1" class="col-md-4 control-label">Sumber Dana</label>
            <div class="col-md-8">
                <select name="sumber_dana" id="sumber_dana" class="validate[required] form-control">
                    <!--<option value="">-pilih-</option>-->
                    <option value="SELAIN-APBN">SELAIN APBN</option>
                    <option value="APBN-BPPTNBH">APBN (BPPTNBH)</option>
                    <option value="APBN-LAINNYA">SPI - SILPA - PINJAMAN</option>
                </select>
            </div>
        </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="button" class="btn btn-primary" id="show"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search</button>
          <button type="reset" class="btn btn-info" id="reset"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset</button>
        </div>
      </div>

            </form>
</div>

            <div class="col-sm-4">
            <button class="btn btn-danger" id="dl" style="height: 150px; margin: 25px auto; width: 40%; display: block;"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> <br>Download<br>(.xls)</button>
            </div>

           </div>    

            <div class="text-center" style="font-size: 14px;background-color: red;padding: 5px;width: 250px;position: fixed;top: 300px;left: 50px;display: none;color: #fff;" id="panel_buka_semua">
                <label for="btn_buka_semua_4d"><b>Buka Semua Sampai 4 Digit</b></label>
                <input type="checkbox" id="btn_buka_semua_4d" name="buka_semua_4d" value="1" rel="5">
                <br>
                <label for="btn_buka_semua_6d"><b>Buka Semua Sampai 6 Digit</b></label>
                <input type="checkbox" id="btn_buka_semua_6d" name="buka_semua_6d" value="1" rel="5">
                <br>
                <span style="color: #000;font-size: 11px;background-color: yellow;padding: 3px;">*Klik pada akun untuk membuka/menutup-nya</span>
            </div>
           
			<div id="temp" style="display:none"></div>
                         <div id="o-table" class="col-md-4">
                            <table class="table table-striped table-bordered" >
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">JENIS</th>
                                        <th style="text-align: center;">JUMLAH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total=0; ?>
                                    <?php foreach ($jumlah_proses as $jumlah ): ?>
                                        <?php $proses = '';
                                            if ($jumlah->proses == '61') {
                                                $proses = 'GUP';
                                            }elseif ($jumlah->proses == '62') {
                                                $proses = 'LSP';
                                            }elseif ($jumlah->proses == '63') {
                                                $proses = 'TUP';
                                            }elseif ($jumlah->proses == '64') {
                                                $proses = 'LSK';
                                            }elseif ($jumlah->proses == '65') {
                                                $proses = 'KS';
                                            }elseif ($jumlah->proses == '66') {
                                                $proses = 'LSNK';
                                            }elseif ($jumlah->proses == '67') {
                                                $proses = 'EMONEY';
                                            }
                                         ?>
                                        <tr>
                                            <td>
                                             <?php   if(substr($jumlah->proses,1,1)=='1'){echo '<span class="badge badge-gup">GP</span>';}
                                             elseif(substr($jumlah->proses,1,1)=='3'){echo '<span class="badge badge-tup">TP</span>';}
                                             elseif(substr($jumlah->proses,1,1)=='2'){echo '<span class="badge badge-lp">LP</span>';}
                                             elseif(substr($jumlah->proses,1,1)=='4'){echo '<span class="badge badge-l3">LK</span>';}
                                             elseif(substr($jumlah->proses,1,1)=='5'){echo '<span class="badge badge-ks">KS</span>';}
                                             elseif(substr($jumlah->proses,1,1)=='6'){echo '<span class="badge badge-ln">LN</span>';}
                                             elseif(substr($jumlah->proses,1,1)=='7'){echo '<span class="badge badge-em">EM</span>';}
                                             else{}
                                                ?>
                                            <?php echo $proses ?>
                                            </td>
                                            <td style="text-align: right;"><?=number_format($jumlah->jumlah, 0, ",", ".")?></td>
                                        </tr>
                                        <?php $total += $jumlah->jumlah ?>
                                    <?php endforeach ?>
                                    <tr>
                                        <td>
                                            <b>TOTAL</b>
                                        </td>
                                        <td style="text-align: right;">
                                            <b><?=number_format( $total, 0, ",", ".")?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="o-table">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr style="background-color: #EEE;" >
                                        <th class="col-md-5" style="text-align:center;vertical-align: middle;">URAIAN</th>
                                        <th class="col-md-2" style="text-align:center;vertical-align: middle;">ANGGARAN</th>
                                        <th class="col-md-2" style="text-align:center;vertical-align: middle;">REALISASI</th>
                                        <th class="col-md-2" style="text-align:center;vertical-align: middle;">REALISASI DIATAS<br>(DIBAWAH)<br>ANGGARAN</th>
                                        <th class="col-md-1" style="text-align:center;vertical-align: middle;">% Realisasi</th>
                                </tr>
                            </thead>
                            <tbody id="tb-isi" class="tb-isi">
                                <?php foreach ($data_anggaran_serapan as $key_1d => $value_1d): ?>
                                    <tr>
                                        <td style="background-color: #ffb0b0;">
                                            <b><?=$key_1d.' - '.$value_1d['nama_akun1d']?></b>
                                        </td>
                                        <td style="text-align:right;background-color: #ffb0b0;" rel="<?=$key_1d?>" class="kode_akun_a1_<?=$key_1d?>"><?=number_format($value_1d['anggaran'], 0, ",", ".")?></td>
                                        <td style="text-align:right;background-color: #ffb0b0;" rel="<?=$key_1d?>" class="kode_akun_s1_<?=$key_1d?>"><?=number_format($value_1d['serapan'], 0, ",", ".")?></td>
                                        <td style="text-align:right;background-color: #ffb0b0;" rel="<?=$key_1d?>" class="kode_akun_b1_<?=$key_1d?>">0</td>
                                        <td style="text-align:right;background-color: #ffb0b0;" rel="<?=$key_1d?>" class="kode_akun_c1_<?=$key_1d?>">0</td>
                                    </tr>
                                    <?php foreach ($data_anggaran_serapan[$key_1d]['data'] as $key_2d => $value_2d): ?>
                                        <tr id="row_collapse_2d_<?=$key_2d?>" rel="<?=$key_2d?>" style="cursor: pointer;">
                                            <td style="padding-left: 20px;background-color: #f1ffa3;"><b><?=$key_2d.' - '.$value_2d['nama_akun2d']?></b></td>
                                            <td style="text-align:right;background-color: #f1ffa3" rel="<?=$key_2d?>" class="kode_akun_a2_<?=$key_2d?>"><?=number_format($value_2d['anggaran'], 0, ",", ".")?></td>
                                            <td style="text-align:right;background-color: #f1ffa3" rel="<?=$key_2d?>" class="kode_akun_s2_<?=$key_2d?>"><?=number_format($value_2d['serapan'], 0, ",", ".")?></td>
                                            <td style="text-align:right;background-color: #f1ffa3" rel="<?=$key_2d?>" class="kode_akun_b2_<?=$key_2d?>">0</td>
                                            <td style="text-align:right;background-color: #f1ffa3" rel="<?=$key_2d?>" class="kode_akun_c2_<?=$key_2d?>">0</td>
                                        </tr>
                                        <?php foreach ($data_anggaran_serapan[$key_1d]['data'][$key_2d]['data'] as $key_3d => $value_3d): ?>
                                            <tr id="row_collapse_3d_<?=$key_3d?>" rel="<?=$key_3d?>" class="collapse out" style="cursor: pointer;">
                                                <td style="padding-left: 40px;background-color: #cae8fd;;"><b><?=$key_3d.' - '.$value_3d['nama_akun3d']?></b></td>
                                                <td style="text-align:right;background-color: #cae8fd;" rel="<?=$key_3d?>" class="kode_akun_a2_<?=$key_3d?>"><?=number_format($value_3d['anggaran'], 0, ",", ".")?></td>
                                                <td style="text-align:right;background-color: #cae8fd;" rel="<?=$key_3d?>" class="kode_akun_s2_<?=$key_3d?>"><?=number_format($value_3d['serapan'], 0, ",", ".")?></td>
                                                <td style="text-align:right;background-color: #cae8fd;" rel="<?=$key_3d?>" class="kode_akun_b2_<?=$key_3d?>">0</td>
                                                <td style="text-align:right;background-color: #cae8fd;" rel="<?=$key_3d?>" class="kode_akun_c2_<?=$key_3d?>">0</td>
                                            </tr>
                                            <?php foreach ($data_anggaran_serapan[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'] as $key_4d => $value_4d): ?>
                                                <tr id="row_collapse_4d_<?=$key_4d?>" rel="<?=$key_4d?>" class="collapse out" style="cursor: pointer;">
                                                    <td style="padding-left: 60px;background-color: #deffa9;">
                                                        <b>
                                                            <span class="col-md-2" style="padding:0px;"><?=$key_4d?>&nbsp;-&nbsp;</span>
                                                            <span class="col-md-10" style="padding:0px;"><?=$value_4d['nama_akun4d']?></span>
                                                        </b>
                                                    </td>
                                                    <td style="text-align:right;background-color: #deffa9;" rel="<?=$key_4d?>" class="kode_akun_a_<?=$key_4d?>"><?=number_format($value_4d['anggaran'], 0, ",", ".")?></td>
                                                    <td style="text-align:right;background-color: #deffa9;" rel="<?=$key_4d?>" class="kode_akun_s_<?=$key_4d?>"><?=number_format($value_4d['serapan'], 0, ",", ".")?></td>
                                                    <td style="text-align:right;background-color: #deffa9;" rel="<?=$key_4d?>" class="kode_akun_b_<?=$key_4d?>">0</td>
                                                    <td style="text-align:right;background-color: #deffa9;" rel="<?=$key_4d?>" class="kode_akun_c_<?=$key_4d?>">0</td>
                                                </tr>
                                                <?php foreach ($data_anggaran_serapan[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'] as $key_5d => $value_5d): ?>
                                                    <tr id="row_collapse_5d_<?=$key_5d?>" rel="<?=$key_5d?>" class="collapse out" style="cursor: pointer;">
                                                        <td style="padding-left: 80px;background-color: #e7ffdf;">
                                                            <b>
                                                                <span class="col-md-2" style="padding:0px;"><?=$key_5d?>&nbsp;-&nbsp;</span>
                                                                <span class="col-md-10" style="padding:0px;"><?=$value_5d['nama_akun5d']?></span>
                                                            </b>
                                                        </td>
                                                        <!-- <td style="text-align:right" rel="<?=$key_5d?>" class="kode_akun_a_<?=$key_5d?>"></td>
                                                        <td style="text-align:right" rel="<?=$key_5d?>" class="kode_akun_s_<?=$key_5d?>"><?=number_format($value_5d['serapan'], 0, ",", ".")?></td> -->
                                                        <!-- <td style="text-align:right" rel="<?=$key_5d?>" class="kode_akun_b_<?=$key_5d?>">0</td> -->
                                                        <!-- <td style="text-align:right" rel="<?=$key_5d?>" class="kode_akun_c_<?=$key_5d?>">0</td> -->
                                                        <td style="text-align:right;background-color: #e7ffdf;" rel="<?=$key_5d?>"></td>
                                                        <td style="text-align:right;background-color: #e7ffdf;" rel="<?=$key_5d?>"><?=number_format($value_5d['serapan'], 0, ",", ".")?></td>
                                                        <td style="text-align:right;background-color: #e7ffdf;" rel="<?=$key_5d?>"></td>
                                                        <td style="text-align:right;background-color: #e7ffdf;" rel="<?=$key_5d?>"></td>
                                                    </tr>
                                                    <?php foreach ($data_anggaran_serapan[$key_1d]['data'][$key_2d]['data'][$key_3d]['data'][$key_4d]['data'][$key_5d]['data'] as $key_6d => $value_6d): ?>
                                                            <tr id="row_collapse_6d_<?=$key_6d?>" rel="<?=$key_6d?>" class="collapse out" >
                                                                <td style="padding-left: 100px;">
                                                                    <span class="col-md-2" style="padding:0px;"><?=$key_6d?>&nbsp;-&nbsp;</span>
                                                                    <span class="col-md-9" style="padding:0px;"><?=$value_6d['nama_akun6d']?></span>
                                                                </td>
                                                                <!-- <td style="text-align:right" rel="<?=$key_6d?>" class="kode_akun_a_<?=$key_6d?>"></td> -->
                                                                <!-- <td style="text-align:right" rel="<?=$key_6d?>" class="kode_akun_s_<?=$key_6d?>"><?=number_format($value_6d['serapan'], 0, ",", ".")?></td> -->
                                                                <!-- <td style="text-align:right" rel="<?=$key_6d?>" class="kode_akun_b_<?=$key_6d?>">0</td> -->
                                                                <!-- <td style="text-align:right" rel="<?=$key_6d?>" class="kode_akun_c_<?=$key_6d?>">0</td> -->
                                                                <td style="text-align:right" rel="<?=$key_6d?>"></td>
                                                                <td style="text-align:right" rel="<?=$key_6d?>"><?=number_format($value_6d['serapan'], 0, ",", ".")?></td>
                                                                <td style="text-align:right" rel="<?=$key_6d?>"></td>
                                                                <td style="text-align:right" rel="<?=$key_6d?>"></td>
                                                            </tr>
                                                        
                                                    <?php endforeach ?>
                                                <?php endforeach ?>
                                            <?php endforeach ?>
                                        <?php endforeach ?>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                                    <tr >
                                        <td style="text-align:center;"><b>Jumlah Biaya</b></td>
                                        <td style="text-align:right" id="tot_a"><b><?=number_format($anggaran_all, 0, ",", ".")?></b></td>
                                        <?php // number_format($tot_biaya, 0, ",", "."); ?>
                                        <td style="text-align:right" id="tot_s"><b><?=number_format($serapan_all, 0, ",", ".")?></b></td>
                                        <td style="text-align:right" id="tot_b"><b>0</b></td>
                                        <td style="text-align:right" id="tot_c"><b>0</b></td>
                                    </tr>

                                    <tr >
                                        <td style="text-align:center;"><b>Surplus/Defisit Tahun Berjalan</b></td>
                                        <td style="text-align:right" id="surdef_a"><b>0</b></td>
                                        <?php // number_format($tot_biaya, 0, ",", "."); ?>
                                        <td style="text-align:right" id="surdef_s"><b>0</b></td>
                                        <td style="text-align:right" id="surdef_b"><b>0</b></td>
                                        <td style="text-align:right" id="surdef_c"><b>0</b></td>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>

                        <div id="hidden-table" style="display:none">
                        <table class="" id="table-serapan">
                            <thead>
                                <tr style="" >
                                        <th class="" style="text-align:center;vertical-align: middle;" colspan="5">
                                        <h5><b>
                                        UNIVERSITAS DIPONEGORO<br/>
                                        LAPORAN REALISASI ANGGARAN<br/>
                                        TAHUN ANGGARAN <?=$tahun?><br/>
                                        <?=$cur_triwulan?></b>
                                        </h5>
                                        </th>
                                </tr>
                                <tr style="" >
                                        <th  style="text-align:center;vertical-align: middle;border:1px solid #000;background-color: #EEE;">URAIAN</th>
                                        <th  style="text-align:center;vertical-align: middle;border:1px solid #000;background-color: #EEE;">ANGGARAN</th>
                                        <th  style="text-align:center;vertical-align: middle;border:1px solid #000;background-color: #EEE;">REALISASI</th>
                                        <th  style="text-align:center;vertical-align: middle;border:1px solid #000;background-color: #EEE;">REALISASI DIATAS<br>(DIBAWAH)<br>ANGGARAN</th>
                                        <th  style="text-align:center;vertical-align: middle;border:1px solid #000;background-color: #EEE;">%</th>
                                </tr>
                            </thead>
                            <tbody id="tb-hidden" >
                                    <tr colspan="5">
                                            <td>&nbsp;</td>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td >&nbsp;</td>
                                    <td colspan="4">
                                        Semarang, <br>
                                        Kuasa Pengguna Anggaran / Rektor<br>
                                        <br>
                                        <br>
                                        <br>
                                        Prof. Dr. Yos Johan Utama, S.H., M.Hum.<br>
                                        NIP. 196211101987031004
                                    </td>
                                </tr>
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
