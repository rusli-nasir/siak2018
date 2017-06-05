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

        // console.log(anggaran);

        var n = 0 ;

        if(parseInt(anggaran) > parseInt(serapan)){

            n = parseInt(anggaran) - parseInt(serapan) ;

            tot_b = tot_b + n ;

            el.text('(' + angka_to_string(n) + ')');

        }else{

            n = parseInt(serapan) - parseInt(anggaran) ;

            tot_b = tot_b + n ;

            el.text(angka_to_string(n));

        }

        $('#tot_b').html('<b>' + angka_to_string(tot_b) + '</b>');


        var p = 0 ;

        if( parseInt(serapan) > 0 ){
            p = Math.round((parseFloat(serapan)/parseFloat(anggaran))*100 * 10) / 10;
        }

        $('.kode_akun_c_' + kode_akun).text(p);

    });


    var p2 = 0 ;
    if( parseInt(tot_b) > 0 ){
        var tot_a = parseInt(string_to_angka(s_tot_a));
        var tot_s = parseInt(string_to_angka(s_tot_s));
        p2 = Math.round((parseFloat(tot_s)/parseFloat(tot_a))*100 * 10) / 10;
    }

    $('#tot_c').html('<b>' + angka_to_string(p2) + '</b>');


    // var t5 = 0 ;

    $('[class^="kode_akun_a5_"]').each(function(){

        var kode_akun = $(this).attr('rel');

        var el = $(this) ;

        var t5 = 0 ;

        // console.log(kode_akun);

        $('[class^="kode_akun_a_' +  kode_akun + '"]').each(function(){

            // console.log($(this).text());

            t5 = t5 + parseInt(string_to_angka($(this).text()));

            el.text(angka_to_string(t5));

        });

    });

    $('[class^="kode_akun_s5_"]').each(function(){

        var kode_akun = $(this).attr('rel');

        var el = $(this) ;

        var t5 = 0 ;

        // console.log(kode_akun);

        $('[class^="kode_akun_s_' +  kode_akun + '"]').each(function(){

            // console.log($(this).text());

            t5 = t5 + parseInt(string_to_angka($(this).text()));

            el.text(angka_to_string(t5));

        });

    });


    $('[class^="kode_akun_b5_"]').each(function(){

        var kode_akun = $(this).attr('rel');

        // console.log(kode_akun);

        var el = $(this);

        var anggaran = string_to_angka($(".kode_akun_a5_" + kode_akun).text());
        var serapan = string_to_angka($(".kode_akun_s5_" + kode_akun).text());

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
            p = Math.round((parseFloat(serapan)/parseFloat(anggaran))*100 * 10) / 10;
        }

        $('.kode_akun_c5_' + kode_akun).text(p);

    });


    ////

    $('[class^="kode_akun_a2_"]').each(function(){

        var kode_akun = $(this).attr('rel');

        var el = $(this) ;

        var t2 = 0 ;

        // console.log(kode_akun);

        $('[class^="kode_akun_a5_' +  kode_akun + '"]').each(function(){

            // console.log($(this).text());

            t2 = t2 + parseInt(string_to_angka($(this).text()));

            el.text(angka_to_string(t2));

        });

    });

    $('[class^="kode_akun_s2_"]').each(function(){

        var kode_akun = $(this).attr('rel');

        var el = $(this) ;

        var t2 = 0 ;

        // console.log(kode_akun);

        $('[class^="kode_akun_s5_' +  kode_akun + '"]').each(function(){

            // console.log($(this).text());

            t2 = t2 + parseInt(string_to_angka($(this).text()));

            el.text(angka_to_string(t2));

        });

    });


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
            p = Math.round((parseFloat(serapan)/parseFloat(anggaran))*100 * 10) / 10;
        }

        $('.kode_akun_c2_' + kode_akun).text(p);

    });


    ////

    $('[class^="kode_akun_a1_"]').each(function(){

        var kode_akun = $(this).attr('rel');

        var el = $(this) ;

        var t1 = 0 ;

        // console.log(kode_akun);

        $('[class^="kode_akun_a2_' +  kode_akun + '"]').each(function(){

            // console.log($(this).text());

            t1 = t1 + parseInt(string_to_angka($(this).text()));

            el.text(angka_to_string(t1));

        });

    });

    $('[class^="kode_akun_s1_"]').each(function(){

        var kode_akun = $(this).attr('rel');

        var el = $(this) ;

        var t1 = 0 ;

        // console.log(kode_akun);

        $('[class^="kode_akun_s2_' +  kode_akun + '"]').each(function(){

            // console.log($(this).text());

            t1 = t1 + parseInt(string_to_angka($(this).text()));

            el.text(angka_to_string(t1));

        });

    });


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
            p = Math.round((parseFloat(serapan)/parseFloat(anggaran))*100 * 10) / 10;
        }

        $('.kode_akun_c1_' + kode_akun).text(p);

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
                            <li role="presentation" id="a-undip" ><a href="#" >AKUN UNDIP</a></li>
                            <li role="presentation" id="a-dikti" ><a href="<?=site_url('serapan/dikti')?>" target="_blank" >AKUN DIKTI</a></li>
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



                    
			<div id="temp" style="display:none"></div>




                        <div id="o-table">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr style="background-color: #EEE;" >
                                        <th class="col-md-5" style="text-align:center;vertical-align: middle;">URAIAN</th>
                                        <th class="col-md-2" style="text-align:center;vertical-align: middle;">ANGGARAN</th>
                                        <th class="col-md-2" style="text-align:center;vertical-align: middle;">REALISASI</th>
                                        <th class="col-md-2" style="text-align:center;vertical-align: middle;">REALISASI DIATAS<br>(DIBAWAH)<br>ANGGARAN</th>
                                        <th class="col-md-1" style="text-align:center;vertical-align: middle;">%</th>
                                </tr>
                            </thead>
                            <tbody id="tb-isi" >
                                <?php if(!empty($data_akun)): ?>
                                    <?php $tot_pendapatan_biaya = 0 ; ?>
                                    <?php $tot_pendapatan_anggaran = 0 ; ?>
                                    <?php $tot_pendapatan_serapan = 0 ; ?>

                                    <?php $tot_biaya = 0 ; ?>
                                    <?php $tot_anggaran = 0 ; ?>
                                    <?php $tot_serapan = 0 ; ?>

                                    <?php $surdef_anggaran = 0 ; ?>
                                    <?php $surdef_serapan = 0 ; ?>
                                    <?php $a1 = array() ; ?>
                                    <?php $a2 = array() ; ?>
                                    <?php $a5 = array() ; ?>
                                    <?php $a6 = array() ; ?>
                                    <?php foreach($data_akun as $i => $d): ?>
                                        <?php if (!(in_array($d->kode_akun1digit, $a1))): ?>
                                        <tr >
                                            <td><?=$d->kode_akun1digit.' - '.$d->nama_akun1digit?></td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun1digit?>" class="kode_akun_a1_<?=$d->kode_akun1digit?>">0</td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun1digit?>" class="kode_akun_s1_<?=$d->kode_akun1digit?>">0</td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun1digit?>" class="kode_akun_b1_<?=$d->kode_akun1digit?>">0</td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun1digit?>" class="kode_akun_c1_<?=$d->kode_akun1digit?>">0</td>
                                        </tr>
                                        <?php $a1[] = $d->kode_akun1digit ; ?>
                                        <?php endif; ?>
                                        <?php if (!(in_array($d->kode_akun2digit, $a2))): ?>
                                        <tr >
                                            <td style="padding-left:20px"><?=$d->kode_akun2digit.' - '.$d->nama_akun2digit?></td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun2digit?>" class="kode_akun_a2_<?=$d->kode_akun2digit?>">0</td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun2digit?>" class="kode_akun_s2_<?=$d->kode_akun2digit?>">0</td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun2digit?>" class="kode_akun_b2_<?=$d->kode_akun2digit?>">0</td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun2digit?>" class="kode_akun_c2_<?=$d->kode_akun2digit?>">0</td>
                                        </tr>
                                        <?php $a2[] = $d->kode_akun2digit ; ?>
                                        <?php endif; ?>
                                        <?php if (!(in_array($d->kode_akun5digit, $a5))): ?>
                                        <tr >
                                            <td style="padding-left:40px"><?=$d->kode_akun5digit.' - '.$d->nama_akun5digit?></td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun5digit?>" class="kode_akun_a5_<?=$d->kode_akun5digit?>">0</td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun5digit?>" class="kode_akun_s5_<?=$d->kode_akun5digit?>">0</td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun5digit?>" class="kode_akun_b5_<?=$d->kode_akun5digit?>">0</td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun5digit?>" class="kode_akun_c5_<?=$d->kode_akun5digit?>">0</td>
                                        </tr>
                                        <?php $a5[] = $d->kode_akun5digit ; ?>
                                        <?php endif; ?>
                                        <tr >
                                            <td style="padding-left:60px"><?=$d->kode_akun.' - '.$d->nama_akun?></td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun?>" class="kode_akun_a_<?=$d->kode_akun?>"><?=number_format($d->anggaran, 0, ",", ".")?></td>
                                            <?php // number_format($d->jum, 0, ",", "."); ?>
                                            <td style="text-align:right" rel="<?=$d->kode_akun?>" class="kode_akun_s_<?=$d->kode_akun?>"><?=number_format($d->serapan, 0, ",", ".")?></td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun?>" class="kode_akun_b_<?=$d->kode_akun?>">0</td>
                                            <td style="text-align:right" rel="<?=$d->kode_akun?>" class="kode_akun_c_<?=$d->kode_akun?>">0</td>
                                        </tr>
                                        <?php $tot_biaya = $tot_biaya ; ?>
                                        <?php $tot_anggaran = $tot_anggaran + $d->anggaran ; ?>
                                        <?php $tot_serapan = $tot_serapan + $d->serapan ; ?>
                                        
                                    <?php endforeach; ?>
                                    <tr >
                                            <td style="text-align:center;"><b>Jumlah Biaya</b></td>
                                            <td style="text-align:right" id="tot_a"><b><?=number_format($tot_anggaran, 0, ",", ".")?></b></td>
                                            <?php // number_format($tot_biaya, 0, ",", "."); ?>
                                            <td style="text-align:right" id="tot_s"><b><?=number_format($tot_serapan, 0, ",", ".")?></b></td>
                                            <td style="text-align:right" id="tot_b"><b>0</b></td>
                                            <td style="text-align:right" id="tot_c"><b>0</b></td>
                                        </tr>
                                        <?php $surdef_anggaran = $tot_pendapatan_anggaran - $tot_anggaran ; ?>
                                        <?php $surdef_serapan  = $tot_pendapatan_serapan - $tot_serapan ; ?>
                                    
                                    <tr >
                                            <td style="text-align:center;"><b>Surplus/Defisit Tahun Berjalan</b></td>
                                            <td style="text-align:right" id="surdef_a"><b>0</b></td>
                                            <?php // number_format($tot_biaya, 0, ",", "."); ?>
                                            <td style="text-align:right" id="surdef_s"><b>0</b></td>
                                            <td style="text-align:right" id="surdef_b"><b>0</b></td>
                                            <td style="text-align:right" id="surdef_c"><b>0</b></td>
                                        </tr>
                                <?php else : ?>
                                    <tr >
                                        <td colspan="5"> - kosong -</td>
                                    </tr>
                                <?php endif; ?>
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
