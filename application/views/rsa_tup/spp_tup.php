<script type="text/javascript">


var tablesToExcel2 = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , tmplWorkbookXML = '<?xml version="1.0"?><?mso-application progid="Excel.Sheet"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
      + '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office"><Author>Axel Richter</Author><Created>{created}</Created></DocumentProperties>'
      + '<Styles>'
      + '<Style ss:ID="Currency"><NumberFormat ss:Format="Currency"></NumberFormat></Style>'
      + '<Style ss:ID="Date"><NumberFormat ss:Format="Medium Date"></NumberFormat></Style>'
      + '</Styles>' 
      + '{worksheets}</Workbook>'
    , tmplWorksheetXML = '<Worksheet ss:Name="{nameWS}"><Table>{rows}</Table></Worksheet>'
    , tmplCellXML = '<Cell{attributeStyleID}{attributeFormula}><Data ss:Type="{nameType}">{data}</Data></Cell>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }


    return function(tables, wsnames, wbname, appname) {
      var ctx = "";
      var workbookXML = "";
      var worksheetsXML = "";
      var rowsXML = "";

      for (var i = 0; i < tables.length; i++) {
        if (!tables[i].nodeType) tables[i] = document.getElementById(tables[i]);
        for (var j = 0; j < tables[i].rows.length; j++) {
          rowsXML += '<Row>'
          for (var k = 0; k < tables[i].rows[j].cells.length; k++) {
            var dataType = tables[i].rows[j].cells[k].getAttribute("data-type");
            var dataStyle = tables[i].rows[j].cells[k].getAttribute("data-style");
            var dataValue = tables[i].rows[j].cells[k].getAttribute("data-value");
            dataValue = (dataValue)?dataValue:tables[i].rows[j].cells[k].innerHTML;
            var dataFormula = tables[i].rows[j].cells[k].getAttribute("data-formula");
            dataFormula = (dataFormula)?dataFormula:(appname=='Calc' && dataType=='DateTime')?dataValue:null;
            ctx = {  attributeStyleID: (dataStyle=='Currency' || dataStyle=='Date')?' ss:StyleID="'+dataStyle+'"':''
                   , nameType: (dataType=='Number' || dataType=='DateTime' || dataType=='Boolean' || dataType=='Error')?dataType:'String'
                   , data: (dataFormula)?'':dataValue
                   , attributeFormula: (dataFormula)?' ss:Formula="'+dataFormula+'"':''
                  };
            rowsXML += format(tmplCellXML, ctx);
          }
          rowsXML += '</Row>'
        }
        ctx = {rows: rowsXML, nameWS: wsnames[i] || 'Sheet' + i};
        worksheetsXML += format(tmplWorksheetXML, ctx);
        rowsXML = "";
      }

      ctx = {created: (new Date()).getTime(), worksheets: worksheetsXML};
      workbookXML = format(tmplWorkbookXML, ctx);

    // console.log(workbookXML);

      var link = document.createElement("A");
      link.href = uri + base64(workbookXML);
      link.download = wbname || 'Workbook.xls';
      link.target = '_blank';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  })();

var tablesToExcel = (function () {
    // var uri = 'data:application/vnd.ms-excel;base64,'
    var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv="Content-type" content="text/html;charset=utf-8" /><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets>'
    , templateend = '</x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>'
    , body = '<body>'
    , tablevar = '{table'
    , tablevarend = '}'
    , bodyend = '</body></html>'
    , worksheet = '<x:ExcelWorksheet><x:Name>'
    , worksheetend = '</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet>'
    , worksheetvar = '{worksheet'
    , worksheetvarend = '}'
    , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
    , wstemplate = ''
    , tabletemplate = '';

    return function (table, name, filename) {
        var tables = table;

        for (var i = 0; i < tables.length; ++i) {
            wstemplate += worksheet + worksheetvar + i + worksheetvarend + worksheetend;
            tabletemplate += tablevar + i + tablevarend;
        }

        var allTemplate = template + wstemplate + templateend;
        var allWorksheet = body + tabletemplate + bodyend;
        var allOfIt = allTemplate + allWorksheet;

        var ctx = {};
        for (var j = 0; j < tables.length; ++j) {
            ctx['worksheet' + j] = name[j];
        }

        for (var k = 0; k < tables.length; ++k) {
            var exceltable;
            // if (!tables[k].nodeType) exceltable = document.getElementById(tables[k]);
            exceltable = ConvertFromTable(tables[k]);
            // ctx['table' + k] = exceltable.innerHTML;
            ctx['table' + k] = exceltable.replace(/"/g, '\'');
        }

        //document.getElementById("dlink").href = uri + base64(format(template, ctx));
        //document.getElementById("dlink").download = filename;
        //document.getElementById("dlink").click();

        // window.location.href = uri + base64(format(allOfIt, ctx));

        // console.log(format(allOfIt, ctx));


        return base64(format(allOfIt, ctx));

    }
})();

function ConvertFromTable(tbl) {
            var result = $('<div>').append($('#' + tbl).clone()).html();
            return result;
}

$(document).ready(function(){
    
    var id_cetak = 'div-cetak' ;

    var id_xls = 'table_spp' ;
    
    var keluaran = [];
    
    var nm_subkomponen = [] ;
//    var pj_p_nilai_all = [];

    var ind = 0 ;
    $('[class^="nm_subkomponen"]').each(function(){
        nm_subkomponen[ind] = $(this).attr('rel');
        ind++ ;
    });
    $('#myCarousel').on('slid.bs.carousel', function (e) {
  // do something…
        var id = e.relatedTarget.id;
        //console.log(id);
        if(id == 'a'){
            id_cetak = 'div-cetak' ;
            id_xls = 'table_spp' ;
        }else if(id == 'b'){
            id_cetak = 'div-cetak-f1a' ;
            id_xls = 'table_f1a' ;
        }else if(id == 'c'){
            id_cetak = 'div-cetak-lampiran-spj' ;
            id_xls = 'table_spj' ;
        }else if(id == 'd'){
            id_cetak = 'div-cetak-lampiran-rekapakun' ;
            id_xls = 'table_rekapakun' ;
        }else if(id == 'e'){
            id_cetak = 'div-cetak-lampiran-rekappajak' ;
            id_xls = 'table_rekappajak' ;
        }
    });
    
    
    $("#cetak").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("#" + id_cetak).printArea( options );
                });



    

    $("#xls").click(function(){

        console.log('t');
        var uri = $("#" + id_xls).excelexportjs({
                                    containerid: id_xls
                                    , datatype: "table"
                                    , returnUri: true
                                });

        // var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");


        // var uri = tablesToExcel(['table_spp','table_f1a','table_spj','table_rekapakun'], ['SPP','F1A','SPJ','REKAP'], 'download_rsa_excel.xls');

        // var uri = tablesToExcel(['table_spp'], ['SPP'], 'download_rsa_excel.xls');

        // (['tbl1','tbl2'], ['ProductDay1','ProductDay2'], 'TestBook.xls', 'Excel')

        var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");
        
        saveAs(blob, 'download_rsa_excel.xls');

        // tablesToExcel(['table_spp','table_spp'], ['first','second'], 'myfile.xls');
        // tablesToExcel(['1', '2'], ['first', 'second'], 'myfile.xls');
    });

    <?php if(($doc_tup == '')&&($detail_tup['nom']== '0'))://if($detail_tup['nom'] == '0'):?>
            $('#myModalKonfirmKuitansi').modal({
                backdrop: 'static',
                keyboard: true
              });
    <?php endif; ?>
    var pos = $('.ttd').position();

    // .outerWidth() takes into account border and padding.
    var width = $('.ttd').width();

    //show the menu directly over the placeholder
//    $("#status_spp").css({
////        position: "absolute",
//        top: (pos.top - 10) + "px",
//        left: (pos.left - 10) + "px"
//    }).show();

        $('#myModalKonfirm').on('show.bs.modal', function (e) {
            // do something...
            // alert('te');
            var ok = true;
        
            $('[class^="keluaran_"]').each(function(){
                if($( ".td_zonk" ).length){
                    ok = false ; 
                    return false;
                }
            });
            
            if(keluaran.length == 0){ 

                ok = false ;
            }
            
            if(ok){
                return true;
            }else{
                $('#myModalKonfirmZonk').modal('show');
                $('#myCarousel').carousel(1);
                return false;
            }
            
        })    

        $('#myModalKonfirm').on('hidden.bs.modal', function (e) {
            // do something...
            $('#proses_spp_').hide();
            $('#proses_spp').show();
        })
    
    
    
    $(document).on("click",'#proses_spp',function(){
        
        var ok = true;
        
        $('[class^="keluaran_"]').each(function(){
            if($( ".td_zonk" ).length){
                ok = false ; 
                return false;
            }
        });
        
        if(keluaran.length == 0){ 
            
            ok = false ;
        }
        
        if(ok){
        
            if(confirm('Apakah anda yakin ?')){
                var data = 'proses=' + 'SPP-DRAFT' + '&nomor_trx=' + $('#nomor_trx').html() + '&jenis=' + 'SPP' + '&jumlah_bayar=' + string_to_angka($('#jumlah_bayar').text()) + '&terbilang=' + $('#terbilang').text() + '&untuk_bayar=' + $('#untuk_bayar').text() + '&penerima=' + $('#penerima').text() + '&alamat=' + $('#alamat').text() + '&nmbank=' + $('#nmbank').text() + '&rekening=' + $('#rekening').text() + '&npwp=' + $('#npwp').text() + '&nmbendahara=' + $('#nmbendahara').text() + '&nipbendahara=' + $('#nipbendahara').text() + '&rel_kuitansi=' + encodeURIComponent('<?=$rel_kuitansi?>') + '&keluaran=' + JSON.stringify(keluaran) + '&nm_subkomponen=' + JSON.stringify(nm_subkomponen) ;
                $.ajax({
                    type:"POST",
                    url :"<?=site_url('rsa_tup/usulkan_spp_tup')?>",
                    data:data,
                    success:function(data){
    //                        console.log(data)
    //                        $('#no_bukti').html(data);
    //                        $('#myModalKuitansi').modal('show');
                            if(data=='sukses'){
                                location.reload();
                            }
    //                        
                    }
                });
            }
        }else{
            $('#myModalKonfirmZonk').modal('show');
            $('#myCarousel').carousel(1);
            
        }
        return false;
    });
    
    $(document).on("click","#down",function(){
                    $("#status_spp").replaceWith( "<br><br><br>" );
                    var uri = $("#table_spp_up").excelexportjs({
                                    containerid: "table_spp_up"
                                    , datatype: "table"
                                    , returnUri: true
                                });


        $('#dtable').val(uri);
        $('#form_spp').submit();
    
    
    
    });
    
        $(document).on("click",".hapus_keluaran",function(){
            var rel__ = $(this).attr('rel');
            var rel_ = rel__.split(",");
            var n = rel_[0];
            var rel = rel_[1] ;
            keluaran[n] = [] ; 
            $('#tr_n_' + n).remove();
            console.log(JSON.stringify(keluaran));
            console.log(rel);
            console.log($('.tr_k_' + rel).length);
            if($('.tr_k_' + rel).length == 0){
                $('#td_k_' + rel).addClass('td_zonk');
            }
            
            
            return false;
        });
    
       $(document).on("click","#btn_simpan_keluaran",function(){
            if($("#simpan_keluaran").validationEngine("validate")){
                var rel = $('#idkeluaran').val();
                var keluaran_ = [] ;
                    keluaran_[0] = $('#idkeluaran').val();
                    keluaran_[1] = encodeURIComponent($('#keluaran').val());
                    keluaran_[2] = $('#volumekeluaran').val();
                    keluaran_[3] = $('#satuankeluaran').val();
                
                var n = keluaran.length ;
                    keluaran[n] = keluaran_ ;
                    
                var str = '<tr id="tr_n_'+ n +'" class="tr_k_'+ rel +'">' ;
                    str =  str + '<td class="text-center" >&nbsp;</td>';
                    str =  str + '<td style="padding-left: 10px;">'+ $('#keluaran').val() +' [ <a href="#" rel="' + n + ','+ rel +'" class="hapus_keluaran" style="cursor:pointer">hapus</a> ]</td>';
                    str =  str + '<td class="text-center">'+ $('#volumekeluaran').val() +'</td>';
                    str =  str + '<td class="text-center">'+ $('#satuankeluaran').val() +'</td>';
                    str =  str + '<td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>';
                    str =  str + '</tr>' ;
                    str =  str + '<tr class="keluaran_'+ rel +'">' ;
                    str =  str + '<td class="text-center" >&nbsp;</td>';
                    str =  str + '<td style="padding-left: 10px;" id="td_k_'+ rel +'">[ <a href="#" rel="'+ rel +'" id="" class="a_tambah_keluaran">tambah</a> ]</td>';
                    str =  str + '<td class="text-center">&nbsp;</td>';
                    str =  str + '<td class="text-center">&nbsp;</td>';
                    str =  str + '<td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>';
                    str =  str + '</tr>' ;
//                    console.log(str);
                $(".keluaran_" + rel ).replaceWith(str);
                $('#myModalRincianKeluaran').modal('hide');
//                var n = keluaran.length ;
//                    keluaran[n] = keluaran_ ;
//                     console.log(JSON.stringify(keluaran));
            }else{
                return false;
            }
        });
        
        $(document).on("click",".a_tambah_keluaran",function(event){
            $('.formError').hide();
            $('#simpan_keluaran')[0].reset();
            $('#myModalRincianKeluaran').modal('show');
            $('#idkeluaran').val($(this).attr('rel'));
            return false;
        });
        
        $(document).on("focusin","input.xnumber",function(){

                if($(this).val()=='0'){
                        $(this).val('');
                }
                else{
                        var str = $(this).val();
                        $(this).val(angka_to_string(str));
                }
        });
        
        $(document).on("focusout","input.xnumber",function(){

            var kode_usulan_belanja = $(this).attr('rel');

                if($(this).val()==''){
                        $(this).val('0');

                }
                else{
                        var str = $(this).val();
                        $(this).val(string_to_angka(str));

//                        calcinput(kode_usulan_belanja);

                        //alert(str);
                        //$(this).val(str);
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

function string_to_angka(str){
	//I.S str merupakan string yang berisi angka berformat (.000.000,00)
	//F.S num merupakan angka tanpa format

		// var num;
		
		// if (!isNaN(str)){
		// 	return 0;
		// }
		// // str = str.replace(/\./g,"");

		// str = str.split('.').join("");
		// //num = parseInt(str);
		// return str;
		
		return str.split('.').join("");
		

		
	}

	function angka_to_string(num){
	//I.S num merupakan angka tanpa format
	//F.S str_hasil merupakan string yang berisi angka berformat (.000.000,00)
		// var str;
		// var str_hasil="";
		// str = num +"";
		// for (var j=str.length-1;j>=0;j--){
		// 	if (((str.length-1-j)%3==0) && (j!=(str.length-1)) && ((str[0]!='-') || (j!=0))){
		// 		str_hasil="."+str_hasil;
		// 	}
		// 	str_hasil=str[j]+str_hasil;
		// }

		var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

		return str_hasil;
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
</script> 

<div id="page-wrapper" >
<div id="page-inner">
    
    <div class="row">
                    <div class="col-lg-12">
                     <h2>SPP/SPM</h2>    
                    </div>
                </div>
                <hr />

                <div class="row">  
                    <div class="col-lg-12">
                        
    <?php 
    $stts_bendahara = '';
    $stts_ppk = '';
    $stts_kpa = '';
    $stts_verifikator = '';
    $stts_kbuu = '';
    ?>
                        
    <?php if((substr($doc_tup,4,7)=='DITOLAK')&&($detail_tup['nom'] > 0)){ $stts_bendahara = 'active'; ?>   
    <div class="alert alert-warning" style="border:1px solid #a94442;">SPP TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> belum diusulkan oleh bendahara.</div>
    <?php }else{ ?>                 
    <?php if($doc_tup == ''){ $stts_bendahara = 'active'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPP TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> belum diusulkan oleh bendahara.</div>
    <?php }elseif($doc_tup == 'SPP-DRAFT'){ $stts_bendahara = 'done'; $stts_ppk = 'active'; ?>
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >PPK </span></b> .</div>
    <?php }elseif($doc_tup == 'SPP-DITOLAK'){ $stts_bendahara = 'active'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPP TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >PPK </span></b> <b>[ <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_tup == 'SPP-FINAL'){ $stts_bendahara = 'done';  $stts_ppk = 'done'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah diterima oleh <b><span class="text-danger" >PPK </span></b> .</div>
    <?php }elseif($doc_tup == 'SPM-DRAFT-PPK'){ $stts_bendahara = 'done'; $stts_ppk = 'done';  $stts_kpa = 'active'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPM TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KPA </span></b> .</div>
    <?php }elseif($doc_tup == 'SPM-DRAFT-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'active';  ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPM TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >VERIFIKATOR </span></b> .</div>
    <?php }elseif($doc_tup == 'SPM-DITOLAK-KPA'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KPA </span></b> <b>[ <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_tup == 'SPM-FINAL-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'active' ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc_tup == 'SPM-DITOLAK-VERIFIKATOR'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >VERIFIKATOR </span></b> <b>[ <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_tup == 'SPM-FINAL-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done' ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah disetujui oleh <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc_tup == 'SPM-DITOLAK-KBUU'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KUASA BUU </span></b> <b>[ <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_tup == 'SPM-FINAL-BUU'){ $stts_bendahara = 'done'; ?> 
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah difinalisasi oleh <b><span class="text-danger" >BUU </span></b> .</div>
    <?php }elseif($doc_tup == 'SPM-DITOLAK-BUU'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM TUP-NIHIL Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >BUU </span></b> <b>[ <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php } ?>
        
    <?php } ?>
        
                        

<div class="progress-round">
  <div class="circle <?=$stts_bendahara?>">
    <span class="label">1</span>
    <span class="title">Bendahara</span>
  </div>
  <span class="bar <?=$stts_bendahara?>"></span>
  <div class="circle <?=$stts_ppk?>">
    <span class="label">2</span>
    <span class="title">PPK</span>
  </div>
  <span class="bar <?=$stts_ppk?>"></span>
  <div class="circle <?=$stts_kpa?>">
    <span class="label">3</span>
    <span class="title">KPA</span>
  </div>
  <span class="bar <?=$stts_kpa?>"></span>
  <div class="circle <?=$stts_verifikator?>">
    <span class="label">4</span>
    <span class="title">Verifikator</span>
  </div>
  <span class="bar <?=$stts_verifikator?>"></span>
  <div class="circle <?=$stts_kbuu?>">
    <span class="label">5</span>
    <span class="title">KBUU</span>
  </div>
</div>

    
<div id="temp" style="display:none"></div> 

<div style="background-color: #EEE; padding: 10px;">
<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
<!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active">1</li>
        <li data-target="#myCarousel" data-slide-to="1">2</li>
        <li data-target="#myCarousel" data-slide-to="2">3</li>
        <li data-target="#myCarousel" data-slide-to="3">4</li>
        <li data-target="#myCarousel" data-slide-to="4">5</li>
      </ol>
<div class="carousel-inner" role="listbox">
<div class="item active" id="a">
<div id="div-cetak">
		<table id="table_spp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
			<tbody>
                            <tr >
                                <td colspan="5" style="text-align: right;font-size: 30px;padding: 10px;"><b>F1</b></td>
                            </tr>
                            
                            <tr >
                                <td colspan="5" style="text-align: center;padding-top: 5px;padding-bottom: 5px;height: 72px;" align="center">
                                        <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
                                </td>
                            </tr>
                            <tr style="">
                                    <td colspan="5" style="text-align: center;font-size: 20px;border-bottom: none;"><b>UNIVERSITAS DIPONEGORO</b></td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="5" style="text-align: center;font-size: 16px;border-bottom: none;border-top: none;"><b>SURAT PERMINTAAN PEMBAYARAN</b></td>
                                </tr>
                                <tr style="border-top: none;border-bottom: none;">
                                    <td colspan="2" style="border-right: none;border-right: none;border-top: none;border-bottom: none;"><b>TAHUN ANGGARAN : <?=$cur_tahun?></b></td>
                                    <td style="text-align: center;border-right: none;border-left: none;border-top: none;border-bottom: none;" colspan="2">&nbsp;</td>
                                    <td style="border-left: none;border-top: none;border-bottom: none;"><b>JENIS : TUP-NIHIL</b></td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="2" style="border-right: none;border-top:none;"><b>Tanggal	: <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?'':strftime("%d %B %Y", strtotime($tgl_spp)); ?></b></td>
                                    <td style="text-align: center;border-left: none;border-right: none;border-top:none;" colspan="2" >&nbsp;</td>
                                                                                                                          <td style="border-left: none;border-top:none;"><b>Nomor : <span id="nomor_trx"><?=$nomor_spp?></span><!--00001/<?=$alias?>/SPP-UP/JAN/<?=$cur_tahun?>--></b></td>
                                </tr>
                                <tr >
                                    <td colspan="5"><b>Satuan Unit Kerja Pengguna Anggaran (SUKPA) : <?=$unit_kerja?></b></td>
                                </tr>
                                <tr >
                                    <td colspan="5" ><b>Unit Kerja : <?=$unit_kerja?> &nbsp;&nbsp; Kode Unit Kerja : <?=$unit_id?></b></td>
                                </tr>
				<tr style="border-bottom: none;">
                                    
                                    <td colspan="4" style="border-right: none;border-bottom: none;">&nbsp;</td>
                                    <td style="line-height: 16px;border-left: none;border-bottom: none;">Kepada Yth.<br>
                                                    Pengguna Anggaran<br>
                                                    SUKPA <?=$unit_kerja?><br>
                                                    di Semarang
                                    </td>
				</tr>
                                <tr >
                                        <td colspan="5" style="border-bottom: none;border-top: none;">&nbsp;</td>
                                </tr>
                                <tr >
                                        <td colspan="5" style="border-bottom: none;border-top: none;">Dengan Berpedoman pada Dokumen RKAT yang telah disetujui oleh MWA, bersama ini kami mengajukan Surat Permintaan Pembayaran sebagai berikut:</td>
                                </tr>
				<tr>
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;border-top: none;">
                                        <ol style="list-style-type: lower-alpha;margin-top: 0px;margin-bottom: 0px;" >
                                            <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar" style='mso-number-format:"\@";'><?=number_format($detail_tup['nom'], 0, ",", ".")?></span>,-<br>
                                                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang"><?=ucwords($detail_tup['terbilang'])?> <?php echo substr($detail_tup['terbilang'],strlen($detail_tup['terbilang'])-6,6) == 'Rupiah' ? '' : 'Rupiah' ; ?></span></b>)</li>
                                                <li>Untuk keperluan : <span id="untuk_bayar"><?=isset($detail_pic->untuk_bayar)?$detail_pic->untuk_bayar:'Pertanggungjawaban tambahan uang persediaan'?></span></li>
                                                <li>Nama bendahara pengeluaran : <span id="penerima"><?=isset($detail_pic->penerima)?$detail_pic->penerima:''?></span></li>
                                                <li>Alamat : <span id="alamat"><?=isset($detail_pic->alamat_penerima)?$detail_pic->alamat_penerima:''?></span></li>
                                                <li>Nama Bank : <span id="nmbank"><?=isset($detail_pic->nama_bank_penerima)?$detail_pic->nama_bank_penerima:''?></span></li>
                                                <li>No. Rekening Bank : <span id="rekening"><?=isset($detail_pic->no_rek_penerima)?$detail_pic->no_rek_penerima:''?></span></li>
                                                <li>No. NPWP : <span id="npwp"><?=isset($detail_pic->npwp_penerima)?$detail_pic->npwp_penerima:''?></span></li>
                                        </ol>
                                    </td>
                                </tr>
                                                               
                                                                
                                <tr>
                                        <td colspan="5" style="border-top: none;">
                                        Pembayaran sebagaimana tersebut diatas, dibebankan pada pengeluaran dengan uraian sebagai berikut :<br>							
                                        </td>
                                </tr>
							<tr >
                                                            <td colspan="3" style="vertical-align: top;border-top:none;padding-left: 0;">
                                                                <table style="font-family:arial;font-size:12px;line-height: 21px;border-collapse: collapse;width: 100%;border: 1px solid #000;background-color: #FFF;border-left: none;border-right:none;" cellspacing="0" border="1" cellpadding="0">
                                                                    <tr>
                                                                        <td style="text-align: center" colspan="3"><b>PENGELUARAN</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;text-align: center;">NAMA AKUN</td>
                                                                        <td style="border-right: solid 1px #000;text-align: center;">KODE AKUN</td>
                                                                        <td style="text-align: center;">JUMLAH UANG</td>
                                                                    </tr>
                                                                    <?php $jml_pengeluaran = 0; ?>
                                                                    <?php $sub_kegiatan = '' ; ?>
                                                                    <?php if(!empty($data_akun_pengeluaran)): ?>
                                                                    <?php foreach($data_akun_pengeluaran as $data):?>
                                                                    <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                                                                     <tr>
                                                                        <td colspan="3">
                                                                             <b><?=$data->nama_subkomponen?></b>
                                                                        </td>
                                                                     </tr>
                                                                    <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                                                                    <?php endif; ?>
                                                                    <tr>
                                                                            <td style="border-right: solid 1px #000">
                                                                                    <?=$data->nama_akun5digit?>
                                                                            </td>
                                                                            <td  style="text-align: center;border-right: solid 1px #000;">
                                                                                    <?=$data->kode_akun5digit?>
                                                                            </td>
                                                                            <td style='text-align: right;mso-number-format:"\@";'>
                                                                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                                                                    Rp. <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                                                            </td>
                                                                    </tr>
                                                                    <?php endforeach;?>
                                                                    <?php else: ?>
                                                                    <tr>
                                                                            <td style="border-right: solid 1px #000">
                                                                                    &nbsp;
                                                                            </td>
                                                                            <td  style="text-align: center;border-right: solid 1px #000;">
                                                                                    &nbsp;
                                                                            </td>
                                                                            <td style="text-align: right;">
                                                                                    Rp. 0
                                                                            </td>
                                                                    </tr>
                                                                    <?php endif; ?>
                                                                    <tr>
                                                                        <td colspan="2" style="border-right: solid 1px #000">
                                                                            Jumlah Pengeluaran
                                                                        </td>
                                                                        <td  style='text-align: right;mso-number-format:"\@";'>
                                                                                Rp. <?=number_format($jml_pengeluaran, 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="border-right: solid 1px #000">
                                                                            Dikurangi : Jumlah potongan untuk pihak lain
                                                                        </td>
                                                                        <td  style='text-align: right;mso-number-format:"\@";'>
                                                                            <?php $tot_pajak__ = 0 ; 
                                                                            if(!empty($data_spp_pajak)){
                                                                                foreach($data_spp_pajak as $data){
                                                                                   $tot_pajak__ = $tot_pajak__ + $data->rupiah ;
                                                                                }
                                                                            } ?>
                                                                                Rp. <?=number_format($tot_pajak__, 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                    <td colspan="2" style="border-right: solid 1px #000">
                                                                        <strong>Jumlah dana yang dikeluarkan</strong>
                                                                    </td>
                                                                    <td  style='text-align: right;mso-number-format:"\@";'>
                                                                            Rp. <?=number_format(($jml_pengeluaran - $tot_pajak__), 0, ",", ".")?>
                                                                    </td>
                                                                </table>
                                                            </td>
                                                            <td colspan="2" style="vertical-align: top;border-top:none;padding-right: 0;">
                                                                <table style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 100%;border: 1px solid #000;background-color: #FFF;border-left: none;border-right:none;" cellspacing="0" border="1" cellpadding="0">
                                                                    <tr>
                                                                        <td style="text-align: center" colspan="2"><b>PERHITUNGAN TERKAIT PIHAK LAIN</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align: center" colspan="2">PENERIMAAN DARI PIHAK KE-3</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;width: 50%;text-align: center;">Akun</td>
                                                                        <td style="width: 50%;text-align: center;">Jumlah Uang</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;text-align: center;">-</td>
                                                                        <td style='text-align: right;mso-number-format:"\@";'>Rp. 0</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;"><b>Jumlah Penerimaan</b></td>
                                                                        <td  style='text-align: right;mso-number-format:"\@";'>Rp. 0</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="text-align: center">
                                                                                POTONGAN UNTUK PIHAK LAIN
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                            <td style="text-align: center;border-right: solid 1px #000;">
                                                                                    Akun Pajak dan Potongan Lainnya
                                                                            </td>
                                                                            <td style="text-align: center">
                                                                                    Jumlah Uang
                                                                            </td>
                                                                    </tr>
                                                                    <?php $tot_pajak_ = 0 ; ?>
                                                                    <?php if(!empty($data_spp_pajak)): ?>
                                                                    <?php foreach($data_spp_pajak as $data):?>
                                                                    <tr>
                                                                            <td style="border-right: solid 1px #000;">
                                                                                    <?php 
                                                                                    if($data->jenis == 'PPN'){
                                                                                            echo 'Pajak Pertambahan Nilai';
                                                                                    }elseif($data->jenis == 'PPh'){
                                                                                            echo 'Pajak Penghasilan';
                                                                                    }else{
                                                                                            echo 'Lainnya';
                                                                                    }
                                                                                    ?>
                                                                            </td>
                                                                            <td  style='text-align: right;mso-number-format:"\@";'>
                                                                                    <?php $tot_pajak_ = $tot_pajak_ + $data->rupiah ?>
                                                                                    Rp. <?=number_format($data->rupiah, 0, ",", ".")?>
                                                                            </td>
                                                                    </tr>
                                                                    <?php endforeach;?>
                                                                    <?php else: ?>
                                                                    <tr>
                                                                            <td style="border-right: solid 1px #000;">
                                                                                    &nbsp;
                                                                            </td>
                                                                            <td  style="text-align: right;">
                                                                                    &nbsp;
                                                                            </td>
                                                                    </tr>
                                                                    <?php endif; ?>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;">
                                                                                <b>Jumlah Potongan</b>
                                                                        </td>
                                                                        <td  style='text-align: right;mso-number-format:"\@";'>
                                                                                Rp. <?=number_format($tot_pajak_, 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
							</tr>
                                <tr >
                                        <td colspan="5" style="border-bottom: none;">&nbsp;</td>
                                </tr>
				<tr style="border-bottom: none;">
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;border-top:none;">
						SPP Sebagaimana dimaksud diatas, disusun sesuai dengan dokumen lampiran yang persyaratkan dan disampaikan secara bersamaan serta merupakan bagian yang tidak terpisahkan dari surat ini.<br><br>														
					</td>
				<tr>
				<tr style="border-top: none;"> 
				
                                    <td colspan="4" style="border-right: none;border-top:none;">&nbsp;</td>
								<td  style="line-height: 16px;border-left: none;border-top:none;" class="ttd">
									Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
									Bendahara Pengeluaran SUKPA<br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
                                                                        <span id="nmbendahara"><?=isset($detail_pic->nmbendahara)?$detail_pic->nmbendahara:''?></span><br>
                                                                        NIP. <span id="nipbendahara"><?=isset($detail_pic->nipbendahara)?$detail_pic->nipbendahara:''?></span><br>
								</td>
				</tr>
				<tr>
					<td colspan="5"  style="line-height: 16px;">
						<strong>Keterangan:</strong>
						<ul>
							<li>Semua bukti pengeluaran untuk pekerjaan dengan perjanjian yang disahkan Pejabat Pembuat Komitmen telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan Keuangan SUKPA</li>
							<li>Semua bukti-bukti pengeluaran untuk pekerjaan yang disahkan Pejabat Pelaksana dan Pengendali Kegiatan (PPPK) telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan SUKPA.</li>
							<li>Kebenaran perhitungan dan isi tertuang dalam SPP ini menjadi tanggung jawab Bendahara Pengeluaran sepanjang sesuai dengan bukti-bukti pengeluaran yang telah ditandatangani oleh PPPK atau PPK</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
</div>
</div>
<div class="item" id="b">
<div id="div-cetak-f1a">
                <table id="table_f1a" class="table_lamp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                                <td colspan="7" style="text-align: right;font-size: 30px;padding: 10px;"><b>F1A</b></td>
                            </tr>
                            <tr >
                            <td colspan="7" style="text-align: center;border-bottom: none;height: 72px;">
                                <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
                            </td>
                            </tr>
                            <tr >
                            <td colspan="7" style="text-align: center;border-bottom: none;">
                                <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                <h5><b>RINCIAN SURAT PERMINTAAN PEMBAYARAN TUP-NIHIL</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="2" style="border: none;">
                                <b>NO SPP : <?=$nomor_spp?></b>
                            </td>
                            <td style="border: none;">&nbsp;</td>
                            <td colspan="3" style="border-left: none;border-top: none;border-bottom: none;">
                                <b>TANGGAL : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="2" style="border: none;text-transform: uppercase">
                                <b>SUKPA : <?=$unit_kerja?></b>
                            </td>
                            <td style="border: none;">&nbsp;</td>
                            <td colspan="3" style="border-left: none;border-top: none;border-bottom: none;text-transform: uppercase">
                                <b>UNIT KERJA : <?=$unit_kerja?></b>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="7" style="border-top: none;border-bottom: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-right: none;border-top: none;">
                                <ol>
                                    <li>Nomor dan tanggal SPK / Kontrak </li>
                                    <li>Nilai SPK / Kontrak </li>
                                    <li>Total nilai SPK / Kontrak yang terbayar</li>
                                    <li>Termin pembayaran saat ini</li>
                                    <li>Jenis kegiatan</li>
                                    <li>Nomer / tanggal berita acara pembayaran</li>
                                    <li>Nomer / tanggal berita acara penerimaan barang</li>
                                    <li>Rincian pembebanan belanja</li>
                                </ol>
                            </td>
                            <td colspan="5" style="border-left: none;border-top: none;">
                                <ol style="list-style: none;">
                                    <li>: -</li>
                                    <li>: -</li>
                                    <li>: -</li>
                                    <li>: Lunas</li>
                                    <li>: Non Fisik</li>
                                    <li>: Terlampir</li>
                                    <li>: Terlampir</li>
                                    <li>:</li>
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" rowspan="2" style="width: 50px;">NO</td>
                            <td class="text-center">KEGIATAN DAN AKUN</td>
                            <td class="text-center">PAGU DALAM RKAT<br>( Rp )</td>
                            <td class="text-center">SPP/SPM S.D.<br>YANG LALU( Rp )</td>
                            <td class="text-center">SPP INI<br>( Rp )</td>
                            <td class="text-center">JUMLAH S.D.<br>SPP INI( Rp )</td>
                            <td class="text-center">SISA DANA<br>( Rp )</td>
                        </tr>
                        <tr>
                            <td class="text-center">a</td>
                            <td class="text-center">b</td>
                            <td class="text-center">c</td>
                            <td class="text-center">d</td>
                            <td class="text-center">e = c + d</td>
                            <td class="text-center">f = b - e</td>
                        </tr>
                        
                        <?php $jml_pengeluaran = 0; ?>
                        <?php $sub_kegiatan = '' ; ?>
                        <?php $i = 1 ; ?>
                        <?php if(!empty($data_akun_pengeluaran)): ?>
                        <?php foreach($data_akun_pengeluaran as $data):?>
                        <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                         <tr>
                            <td class="text-center"><?=$i?></td>
                            <td style="padding-left: 10px;">
                                 <b><?=$data->nama_subkomponen?></b>
                            </td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                         </tr>
                        <?php $pagu_rkat = 0 ;?>
                        <?php $jml_spm_lalu = 0 ;?>
                        <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                        <?php $i = $i + 1 ; ?> 
                        <?php endif; ?>
                            <tr>
                                <td class="text-center">&nbsp;</td>
                                <td style="padding-left: 10px;"><?=$data->nama_akun5digit?></td>
                                <?php if(!empty($data_akun_rkat)):?> 
                                    <?php foreach($data_akun_rkat as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><?=number_format($da->pagu_rkat, 0, ",", ".")?></td>
                                            <?php $pagu_rkat =  $da->pagu_rkat ;?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><?=number_format('0', 0, ",", ".")?></td>
                                <?php $pagu_rkat =  0 ;?>
                                <?php endif;?>
                                <?php $empty_pengeluaran_lalu = false ; ?>
                                <?php if(!empty($data_akun_pengeluaran_lalu)): ?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php $empty_pengeluaran_lalu = true ; ?>
                                            <?php endif;?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif;?>
                                <?php if(!$empty_pengeluaran_lalu): ?> 
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'>
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><?php echo number_format(($jml_spm_lalu + $data->pengeluaran), 0, ",", "."); ?></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><?php echo number_format(($pagu_rkat - ($jml_spm_lalu + $data->pengeluaran)), 0, ",", "."); ?></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="7">- data kosong -</td>
                        </tr>
                        <?php endif; ?>
<!--                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>-->
                        <tr>
                            <td class="text-center" colspan="4"><b>Total Nilai ( Rp )</b></td>
                            <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($jml_pengeluaran, 0, ",", ".")?></b></td>
                            <td class="text-center" style="background-color:#ccc">&nbsp;</td>
                            <td class="text-center" style="background-color:#ccc">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="" style="border-right:none;" colspan="2">
                                <ol start="9" style="">
                                    <li>Laporan keluaran kegiatan non fisik</li>
                                </ol>
                            </td>
                            <td class="text-left" style="border-left: none; border-right:none;" colspan="2" >
                                <ol style="list-style: none;margin: 10px;"> 
                                    <li>: </li>
                                </ol>
                            </td>
                            <td colspan="3" style="border-bottom: none;border-left: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" rowspan="2">NO</td>
                            <td class="text-center" >RINCIAN KELUARAN YANG<br>DIHASILKAN PER KEGIATAN</td>
                            <td class="text-center" >VOLUME<br>KUANTITAS</td>
                            <td class="text-center" >SATUAN<br>VOLUME</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" >a</td>
                            <td class="text-center" >b</td>
                            <td class="text-center" >c</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php $i = 1; ?>
                        <?php $sub_kegiatan = '' ; ?>
                        <?php if(!empty($data_akun_pengeluaran)): ?>
                        <?php // var_dump($data_akun_pengeluaran); die; ?>
                        <?php foreach($data_akun_pengeluaran as $data):?> 
                        <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                        <tr>
                            <td class="text-center" ><?=$i?></td>
                            <td style="padding-left: 10px;" rel="<?=$data->kode_usulan_rkat?>" class="nm_subkomponen"><b><?=$data->nama_subkomponen?></b></td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php if(!empty($rincian_keluaran)): ?>
                        <?php foreach($rincian_keluaran as $kel):?> 
                        <?php if($kel->kode_usulan_rka == $data->rka):?>
                        <tr class="keluaran_<?=$data->rka?>">
                            <td class="text-center" >&nbsp;</td>
                            <td style="padding-left: 10px;"><?=$kel->keluaran?></td>
                            <td class="text-center"><?=$kel->volume?></td>
                            <td class="text-center"><?=$kel->satuan?></td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach;?>
                        <?php else: ?>
                        <tr class="keluaran_<?=$data->rka?>">
                            <td class="text-center" >&nbsp;</td>
                            <td style="padding-left: 10px;" class="td_zonk">[ <a href="#" rel="<?=$data->rka?>" id="" class="a_tambah_keluaran">tambah</a> ]</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php endif; ?>
                        <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                        <?php $i = $i + 1 ; ?> 
                        <?php endif; ?>
                        <?php endforeach;?>
                        <?php else: ?>
                        
                                    <tr>
                                        <td class="text-center" colspan="4">- data kosong -</td>
                                        <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                                     </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="4" style="height: 50px;border-right:none;border-bottom: none;">&nbsp;</td>
                            <td class="text-center" colspan="3" style="height: 50px;border-left:none;border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="border-right:none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="3" style="border-left:none;border-top: none;border-bottom: none;">
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
                                Bendahara Pengeluaran SUKPA<br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <span ><?=isset($detail_pic->nmbendahara)?$detail_pic->nmbendahara:''?></span><br>
                                NIP. <span ><?=isset($detail_pic->nipbendahara)?$detail_pic->nipbendahara:''?></span><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="7" style="border-top: none;">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
</div>
</div>
<div class="item" id="c">
<div id="div-cetak-lampiran-spj">
            <table id="table_spj" class="table_lamp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                            <td colspan="6" style="text-align: center;height: 72px;">
                                <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
                            </td>
                            </tr>
                            <tr >
                                <td colspan="6" class="text-center" style="text-align: center;border: none;">
                                    <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                    <h5><b>SURAT PERTANGGUNGJAWABAN UANG PERSEDIAAN BENDAHARA PENGELUARAN</b></h5>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border: none;">&nbsp;</td>
                                <td colspan="2" style="text-transform: uppercase;border: none;"><b>SUKPA : <?=$unit_kerja?></b></td>
                                <td colspan="2" style="text-transform: uppercase;border: none;"><b>UNIT KERJA : <?=$unit_kerja?></b></td>
                            </tr>
                            <tr>
                                <td style="border-top:none;" colspan="6">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 50px;">NO</td>
                                <td class="text-center">KODE SUB KEGIATAN<br>/ RINCIAN AKUN</td>
                                <td class="text-center">URAIAN</td>
                                <td class="text-center">SPJ TUP-NIHIL s.d BULAN LALU<br>( Rp )</td>
                                <td class="text-center">SPJ TUP-NIHIL BULAN INI<br>( Rp )</td>
                                <td class="text-center">SPJ TUP-NIHIL s.d BULAN INI<br>( Rp )</td>
                            </tr>
                            <tr >
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                            </tr>
                        <?php $jml_pengeluaran = 0; ?>
                        <?php $sub_kegiatan = '' ; ?>
                        <?php $i = 1 ; ?>
                        <?php if(!empty($data_akun_pengeluaran)): ?>
                        <?php foreach($data_akun_pengeluaran as $data):?>
                        <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                         <tr>
                            <td class="text-center"><?=$i?></td>
                            <td class="text-center">&nbsp;</td>
                            <td style="padding-left: 10px;">
                                 <b><?=$data->nama_subkomponen?></b>
                            </td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                         </tr>
                        <?php $pagu_rkat = 0 ;?>
                        <?php $jml_spm_lalu = 0 ;?>
                        <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                        <?php $i = $i + 1 ; ?> 
                        <?php endif; ?>
                            <tr>
                                <td class="text-center">&nbsp;</td>
                                <td class="text-center"><?=$data->kode_akun5digit?></td>
                                <td style="padding-left: 10px;"><?=$data->nama_akun5digit?></td>
                                <?php $empty_pengeluaran_lalu = false ; ?>
                                <?php if(!empty($data_akun_pengeluaran_lalu)):?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php $empty_pengeluaran_lalu = true ; ?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php endif;?>
                                <?php if(!$empty_pengeluaran_lalu): ?> 
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'>
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><?php echo number_format(($jml_spm_lalu + $data->pengeluaran), 0, ",", "."); ?></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="6">- data kosong -</td>
                        </tr>
                        <?php endif; ?>
<!--                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>-->
                        <tr>
                            <td class="text-center" colspan="4"><b>Total Nilai ( Rp )</b></td>
                            <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($jml_pengeluaran, 0, ",", ".")?></b></td>
                            <td class="text-center" style="background-color:#ccc">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="6" style="border-bottom: none;border-right: none;border-left: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="border : none;"><b>Potongan :</b></td>
                        </tr>
                        <?php $tot_pajak_ = 0 ; ?>
                        <?php $n = 1 ; ?>
                        <?php if(!empty($data_spp_pajak)): ?>
                        <?php foreach($data_spp_pajak as $data):?>
                        <tr>
                            <td class="text-center" style="border:none;">
                                <?php echo $n; ?>
                            </td>
                                <td style="border:none;">
                                        <?php 
                                        if($data->jenis == 'PPN'){
                                                echo 'Pajak Pertambahan Nilai';
                                        }elseif($data->jenis == 'PPh'){
                                                echo 'Pajak Penghasilan';
                                        }else{
                                                echo 'Lainnya';
                                        }
                                        ?>
                                </td>
                                <td style='border:none;mso-number-format:"\@";' class="text-right">
                                        <?php $tot_pajak_ = $tot_pajak_ + $data->rupiah ?>
                                        Rp. <?=number_format($data->rupiah, 0, ",", ".")?>
                                </td>
                                <td class="text-center" colspan="3" style="border: none;">&nbsp;</td>
                        </tr>
                        <?php $n++; ?>
                        <?php endforeach;?>
                        <?php else: ?>
                        <tr>
                               <td class="text-center" colspan="3" style="border: none;">&nbsp;</td>
                               <td class="text-center" colspan="3" style="border: none;">&nbsp;</td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                               <td class="text-center" colspan="2" style="border: none;">&nbsp;</td>
                               <td style="border-top: none;border-right: none;border-left: none;">&nbsp;</td>
                               <td class="text-center" colspan="3" style="border: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border : none;"><b>Total Potongan :</b></td>
                            <td style='border : none;mso-number-format:"\@";' class="text-right">
                                    Rp. <?=number_format($tot_pajak_, 0, ",", ".")?>
                            </td>
                            <td colspan="3" style="border: none">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="border: none">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none;">&nbsp;</td>
                            <td colspan="2" style="border: none;">
                                Telah diperiksa kebenarannya oleh,<br>
                                PPK SUKPA<br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <span ><?=isset($detail_ppk->nm_lengkap)?$detail_ppk->nm_lengkap:''?></span><br>
                                NIP. <span ><?=isset($detail_ppk->nomor_induk)?$detail_ppk->nomor_induk:''?></span><br>
                            </td>
                            <td colspan="2" style="border: none;">
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
                                Bendahara Pengeluaran SUKPA<br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <span ><?=isset($detail_pic->nmbendahara)?$detail_pic->nmbendahara:''?></span><br>
                                NIP. <span ><?=isset($detail_pic->nipbendahara)?$detail_pic->nipbendahara:''?></span><br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="border: none">&nbsp;</td>
                        </tr>
                    </tbody>
            </table>
</div>
</div>
<div class="item" id="d">
    <div class="free dragscroll" style="overflow-x: scroll;width: 900px;margin: 0 auto;cursor: pointer;">
        <div id="div-cetak-lampiran-rekapakun">
        
            <?php // var_dump($rincian_akun_pengeluaran);  die; ?>
                 
            <table id="table_rekapakun" class="table_lamp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 1300px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                                <td colspan="14" class="text-center" style="text-align: center;border: none;">
                                    <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                    <h5>REKAPITULASI PERTANGGUNGJAWABAN PENGELUARAN</h5>
                                    <h5><b>SETIAP SUB KEGIATAN PER RINCIAN AKUN</b></h5>
                                    <b style="text-transform: uppercase;">SUKPA : <?=$unit_kerja?> <span style="display: inline-block;width: 100px;">&nbsp;</span> UNIT KERJA : <?=$unit_kerja?></b><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="14" style="border: none;">&nbsp;</td>
                            </tr>
                            <?php $jk = 1; ?>
                            <?php if(!empty($data_akun_pengeluaran)): ?>
                            
                            <?php $tot_bruto_ = 0 ;?>
                            <?php $tot_pajak_ = 0 ;?>

                            <?php foreach($data_akun_pengeluaran as $data):?>  
                            <tr>
                                <td colspan="14" style="border-bottom: none;">&nbsp;</td>
                            </tr>     
                            <tr >
                                <td colspan="14" class="text-center" style="text-align: center;border: none;">
                                    <b style="text-transform: uppercase;">KEGIATAN : <?=$data->nama_komponen?> </b><br>
                                    <b style="text-transform: uppercase;">SUB KEGIATAN : <?=$data->nama_subkomponen?> </b><br>
                                    <b style="text-transform: uppercase;">KODE AKUN  : <?=$data->kode_akun5digit?> <span style="display: inline-block;width: 100px;">&nbsp;</span> URAIAN AKUN : <?=$data->nama_akun5digit?></b><br>
                                    <b style="text-transform: uppercase;">BULAN  : <?=$bulan?> <span style="display: inline-block;width: 100px;">&nbsp;</span> TAHUN : <?=$cur_tahun?></b><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="14" style="border-top: none;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 50px;">NO</td>
                                <td class="text-center" style="width: 100px;">TANGGAL</td>
                                <td class="text-center" style="width: 100px;">KD UNIT</td>
                                <td class="text-center" style="width: 150px;">RINCIAN AKUN</td>
                                <td class="text-center" style="width: 100px;">KODE RINCIAN<br>AKUN</td>
                                <td class="text-center" style="width: 150px;">KODE-URAIAN RINCIAN<br>AKUN</td>
                                <td class="text-center" style="width: 100px;">NO BUKTI</td>
                                <td class="text-center">PENGELUARAN<br>( Rp )</td>
                                <td class="text-center">KUANTITAS<br>KELUARAN</td>
                                <td class="text-center">SATUAN<br>KELUARAN</td>
                                <td class="text-center" style="width: 150px;">KETERANGAN KELUARAN</td>
                                <td class="text-center" style="width: 125px;">JENIS POT<br>PAJAK</td>
                                <td class="text-center" style="width: 100px;">NILAI POT</td>
                                <td class="text-center" style="width: 100px;">NETTO</td>
                            </tr>
                            <?php $kl = 1 ;?>
                            <?php $tot_bruto = 0 ;?>
                            <?php $tot_pajak = 0 ;?>
                            <?php foreach($rincian_akun_pengeluaran as $rincian): ?>
                            <?php if(($rincian->rka == $data->rka)&&($rincian->kode_akun5digit == $data->kode_akun5digit)):?>
                            <tr>
                                <td class="text-center" style="vertical-align: top"><?=$kl?></td>
                                <td class="text-center" style="vertical-align: top"><?php echo strftime("%d-%m-%Y", strtotime($rincian->tgl_kuitansi)) ;?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->kdunit?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->nama_akun?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->kode_akun?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->kode_akun_tambah?> - <?=$rincian->deskripsi?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->no_bukti?></td>
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format(($rincian->volume*$rincian->harga_satuan), 0, ",", ".")?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->volume + 0?></td>
                                <td class="text-center" style="vertical-align: top;"><?=$rincian->satuan?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->uraian?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->pajak_nom?></td>
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($rincian->total_pajak, 0, ",", ".")?></td>
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format(($rincian->bruto-$rincian->total_pajak), 0, ",", ".")?></td>
                                <?php $tot_bruto = $tot_bruto + $rincian->bruto ;?>
                                <?php $tot_pajak = $tot_pajak + $rincian->total_pajak ;?>
                            </tr>
                            <?php $kl++ ; ?>
                            <?php endif;?>
                            <?php endforeach;?>
                            <tr>
                                <td colspan="7" style="border-bottom: none; padding-left: 10px;"><b>Total Pengeluaran</b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_bruto, 0, ",", ".")?></b></td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_bruto - $tot_pajak, 0, ",", ".")?></b></td>
                            </tr>
                            <?php $tot_bruto_ = $tot_bruto_ + $tot_bruto ;?>
                            <?php $tot_pajak_ = $tot_pajak_ + $tot_pajak ;?>
                            
                            <?php endforeach;?>
                            <tr>
                                <td colspan="7" style="border-bottom: none; padding-left: 10px;"><b>Grand Total</b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_bruto_, 0, ",", ".")?></b></td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_bruto_ - $tot_pajak_, 0, ",", ".")?></b></td>
                            </tr>
                            <tr>
                                <td colspan="14" style="border-bottom: none;">&nbsp;</td>
                            </tr>
                            <?php else: ?>
                            <tr>
                                <td class="text-center" colspan="14">- data kosong -</td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="10" style="border-bottom: none;border-top: none;border-right:none;">&nbsp;</td>
                                <td colspan="4" style="border-bottom: none;border-top: none;border-left:none;">
                                    Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
                                    Bendahara Pengeluaran SUKPA<br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <span ><?=isset($detail_pic->nmbendahara)?$detail_pic->nmbendahara:''?></span><br>
                                    NIP. <span ><?=isset($detail_pic->nipbendahara)?$detail_pic->nipbendahara:''?></span><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="14" style="border-top: none;">&nbsp;</td>
                            </tr>
                    </tbody>
            </table>
    </div>
</div>
</div>
<div class="item" id="e">
    <div class="free dragscroll" style="overflow-x: scroll;width: 900px;margin: 0 auto;cursor: pointer;">
        <div id="div-cetak-lampiran-rekappajak">
        
            <?php // var_dump($rincian_akun_pengeluaran);  die; ?>
                 
            <table id="table_rekappajak" class="table_lamppajak" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 1300px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                                <td colspan="15" class="text-left" style="text-align: left;border: none;padding-left:20px;">
                                    <!--<h4><b>UNIVERSITAS DIPONEGORO</b></h4>-->
                                    <h5><b>Lampiran Pajak</b></h5>
                                    <h5><b>Nomor SPP : <?=$nomor_spp?></b></h5>
                                    <!--<b style="text-transform: uppercase;">SUKPA : <?=$unit_kerja?> <span style="display: inline-block;width: 100px;">&nbsp;</span> UNIT KERJA : <?=$unit_kerja?></b><br>-->
                                </td>
                            </tr>
                            <tr >
                                <td colspan="2" class="text-left" style="text-align: left;border: none;padding-left:20px;">
                                    <!--<h4><b>UNIVERSITAS DIPONEGORO</b></h4>-->
                                    <b>Nama Wajib Pajak</b>
                                    <!--<b style="text-transform: uppercase;">SUKPA : <?=$unit_kerja?> <span style="display: inline-block;width: 100px;">&nbsp;</span> UNIT KERJA : <?=$unit_kerja?></b><br>-->
                                </td>
                                <td colspan="13" class="text-left" style="text-align: left;border: none;padding-left:20px;">
                                    : Bendahara Pengeluaran Undip
                                </td>
                            </tr>
                            <tr >
                                <td colspan="2" class="text-left" style="text-align: left;border: none;padding-left:20px;">
                                    <!--<h4><b>UNIVERSITAS DIPONEGORO</b></h4>-->
                                    <b>NPWP</b>
                                    <!--<b style="text-transform: uppercase;">SUKPA : <?=$unit_kerja?> <span style="display: inline-block;width: 100px;">&nbsp;</span> UNIT KERJA : <?=$unit_kerja?></b><br>-->
                                </td>
                                <td colspan="13" class="text-left" style="text-align: left;border: none;padding-left:20px;">
                                    : 00.018.856.5-517.000
                                </td>
                            </tr>
                            <tr>
                                <td colspan="15" style="border: none;">&nbsp;</td>
                            </tr>
                            <?php $jk = 1; ?>
                            <?php if(!empty($data_rekap_pajak)): ?>

                            <?php $tot_bruto_ = 0 ;?>

                            <?php $tot_pajak_ppn_ = 0 ;?>
                            <?php $tot_pajak_21_ = 0 ;?>
                            <?php $tot_pajak_22_ = 0 ;?>
                            <?php $tot_pajak_23_ = 0 ;?>
                            <?php $tot_pajak_4_2_ = 0 ;?>
                            <?php $tot_pajak_26_ = 0 ;?>
                            <?php $tot_pajak_lainnya_ = 0 ;?>

                            <?php $tot_sub_pajak_ = 0 ;?>
                            <?php $tot_pajak_ = 0 ;?> 

                            <?php foreach($data_rekap_pajak as $data_pajak => $akun ):?>  

                            <tr>
                                <td colspan="15" style="border-bottom: none;">&nbsp;</td>
                            </tr>
 
                            <tr>
                                <td class="text-center" style="width: 50px;"  rowspan="3"><b>NO</b></td>
                                <td class="text-center" style="width: 100px;" rowspan="3"><b>AKUN</b></td>
                                <td class="text-center" style="width: 100px;" rowspan="3"><b>KUITANSI</b></td>
                                <td class="text-center" style="width: 150px;" rowspan="3"><b>PENERIMA</b></td>
                                <td class="text-center" style="width: 150px;" rowspan="3"><b>URAIAN</b></td>
                                <td class="text-center" rowspan="2"><b>Jml Kotor</b></td>
                                <td class="text-center" rowspan="2"><b>PPN</b></td>
                                <td class="text-center" colspan="5"><b>PPh</b></td>
                                <td class="text-center" rowspan="2"><b>Lainnya</b></td>
                                <td class="text-center" rowspan="2"><b>Jml Pajak</b></td>
                                <td class="text-center" rowspan="2"><b>Jml Bersih</b></td>
                            </tr>    
                            <tr>    
                                <td class="text-center"><b>21</b></td>
                                <td class="text-center"><b>22</b></td>
                                <td class="text-center"><b>23</b></td>
                                <td class="text-center"><b>4 ayat (2)</b></td>
                                <td class="text-center"><b>26</b></td>
                            </tr>    
                            <tr>     
                                <td class="text-center"><b>Rp</b></td>
                                <td class="text-center"><b>Rp</b></td>
                                <td class="text-center"><b>Rp</b></td>
                                <td class="text-center"><b>Rp</b></td>
                                <td class="text-center"><b>Rp</b></td>
                                <td class="text-center"><b>Rp</b></td>
                                <td class="text-center"><b>Rp</b></td>
                                <td class="text-center"><b>Rp</b></td>
                                <td class="text-center"><b>Rp</b></td>
                                <td class="text-center"><b>Rp</b></td>
                            </tr>


                            <?php // echo $akun ; ?>

                            <?php $kl = 1 ;?>
                            <?php $tot_bruto = 0 ;?>

                            <?php $tot_pajak_ppn = 0 ;?>
                            <?php $tot_pajak_21 = 0 ;?>
                            <?php $tot_pajak_22 = 0 ;?>
                            <?php $tot_pajak_23 = 0 ;?>
                            <?php $tot_pajak_4_2 = 0 ;?>
                            <?php $tot_pajak_26 = 0 ;?>
                            <?php $tot_pajak_lainnya = 0 ;?>

                            <?php $tot_sub_pajak = 0 ;?>
                            <?php $tot_pajak = 0 ;?> 

                            <?php foreach($akun as $i => $data):?> 

                               
                           
                            <tr>
                                <td class="text-center" style="vertical-align: top"><?=$kl?></td>
                                <td class="text-center" style="vertical-align: top"><?=$data->kode_akun?></td>
                                <td class="text-center" style="vertical-align: top"><?=$data->no_bukti?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$data->penerima_uang?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$data->uraian?></td>
                                <!--
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data->jml_bruto, 0, ",", ".")?></td>
                                -->

                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data_rekap_bruto[$data_pajak][$i]->jml_bruto, 0, ",", ".")?><?php var_dump(); ?></td>

                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data->PPN, 0, ",", ".")?></td>
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data->PPh21, 0, ",", ".")?></td>
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data->PPh22, 0, ",", ".")?></td>
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data->PPh23, 0, ",", ".")?></td>
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data->PPh4_2, 0, ",", ".")?></td>
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data->PPh26, 0, ",", ".")?></td>
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data->Lainnya, 0, ",", ".")?></td>
                                <?php $tot_sub_pajak =  $data->PPN +  $data->PPh21 +  $data->PPh22 +  $data->PPh23  + $data->PPh4_2 +  $data->PPh26 + $data->Lainnya;?> 
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($tot_sub_pajak, 0, ",", ".")?></td>
                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data_rekap_bruto[$data_pajak][$i]->jml_bruto - $tot_sub_pajak, 0, ",", ".")?></td>

                                <?php $tot_bruto = $tot_bruto + $data_rekap_bruto[$data_pajak][$i]->jml_bruto ;?>
                                <?php $tot_pajak_ppn = $tot_pajak_ppn + $data->PPN ;?>
                                <?php $tot_pajak_21 = $tot_pajak_21 + $data->PPh21 ;?>
                                <?php $tot_pajak_22 = $tot_pajak_22 + $data->PPh22 ;?>
                                <?php $tot_pajak_23 = $tot_pajak_23 + $data->PPh23 ;?>
                                <?php $tot_pajak_4_2 = $tot_pajak_4_2 + $data->PPh4_2 ;?>
                                <?php $tot_pajak_26 = $tot_pajak_26 + $data->PPh26 ;?>
                                <?php $tot_pajak_lainnya = $tot_pajak_lainnya + $data->Lainnya ;?>
                                <?php $tot_pajak = $tot_pajak + $tot_sub_pajak ;?>

                            </tr>
                            <?php $kl++ ; ?>

                            <?php endforeach;?>

                            <tr>
                                <td colspan="5" style="border-bottom: none; padding-left: 10px;"><b>Sub Jumlah Akun - <?=$data_pajak?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_bruto, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_ppn, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_21, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_22, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_23, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_4_2, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_26, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_lainnya, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak, 0, ",", ".")?></b></td>
                                
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_bruto - $tot_pajak, 0, ",", ".")?></b></td>
                                
                                
                            </tr>
                            

                            <?php $tot_bruto_ = $tot_bruto_ + $tot_bruto ;?>
                            <?php $tot_pajak_ppn_ = $tot_pajak_ppn_ + $tot_pajak_ppn ;?>
                            <?php $tot_pajak_21_ = $tot_pajak_21_ + $tot_pajak_21 ;?>
                            <?php $tot_pajak_22_ = $tot_pajak_22_ + $tot_pajak_22 ;?>
                            <?php $tot_pajak_23_ = $tot_pajak_23_ + $tot_pajak_23 ;?>
                            <?php $tot_pajak_4_2_ = $tot_pajak_4_2_ + $tot_pajak_4_2 ;?>
                            <?php $tot_pajak_26_ = $tot_pajak_26_ + $tot_pajak_26 ;?>
                            <?php $tot_pajak_lainnya_ = $tot_pajak_lainnya_ + $tot_pajak_lainnya ;?>
                            <?php $tot_pajak_ = $tot_pajak_ + $tot_pajak ;?>

                            


                            <?php endforeach;?>
                            <tr>
                                <td colspan="5" style="border-bottom: none; padding-left: 10px;"><b>Jumlah</b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_bruto_, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_ppn_, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_21_, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_22_, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_23_, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_4_2_, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_26_, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_lainnya_, 0, ",", ".")?></b></td>
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_pajak_, 0, ",", ".")?></b></td>
                                
                                <td class="text-right" style='padding-right: 10px;mso-number-format:"\@";'><b><?=number_format($tot_bruto_ - $tot_pajak_, 0, ",", ".")?></b></td>
                                
                                
                            </tr>
                            <tr>
                                <td colspan="15" style="border-bottom: none;">&nbsp;</td>
                            </tr>
                            <?php else: ?>
                            <tr>
                                <td class="text-center" colspan="15">- data kosong -</td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="11" style="border-bottom: none;border-top: none;border-right:none;">&nbsp;</td>
                                <td colspan="4" style="border-bottom: none;border-top: none;border-left:none;">
                                    Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
                                    Bendahara Pengeluaran SUKPA<br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <span ><?=isset($detail_pic->nmbendahara)?$detail_pic->nmbendahara:''?></span><br>
                                    NIP. <span ><?=isset($detail_pic->nipbendahara)?$detail_pic->nipbendahara:''?></span><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="15" style="border-top: none;">&nbsp;</td>
                            </tr>
                    </tbody>
            </table>
    </div>
</div>
</div>
    
    
</div>

    
<!-- Left and right controls -->
<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev" style="background-image: none;width: 25px;">
  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next" style="background-image: none;width: 25px;">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Next</span>
</a>

</div>
    
</div>
    

<img id="status_spp" style="display: none" src="<?php echo base_url(); ?>/assets/img/verified.png" width="150">
<br />
<form action="<?=site_url('rsa_up/cetak_spp')?>" id="form_spp" method="post" style="display: none"  >
    <input type="text" name="dtable" id="dtable" value="" />
    <input type="text" name="dunit" id="dunit" value="<?=$alias?>" />
    <input type="text" name="dtahun" id="dtahun" value="<?=$cur_tahun?>" />
</form>
            <div class="alert alert-warning" style="text-align:center">
                <?php if($doc_tup == ''){ ?>
                    <a href="#" data-toggle="modal" class="btn btn-warning" data-target="#myModalKonfirm" id="proses_spp_"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></span> Proses SPP</a>
                    <!--<a href="#" data-toggle="modal" class="btn btn-warning" data-target="#myModalKonfirm" id="proses_spp_"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></span> Proses SPP</a>-->
                    <a href="#" class="btn btn-warning" style="display: none" id="proses_spp"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Proses SPP</a>
                    <a href="<?=site_url('kuitansi/daftar_kuitansi/GP')?>" class="btn btn-success" ><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Daftar Kuitansi</a>
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <button type="button" class="btn btn-default" id="xls" rel=""><span class="fa fa-file-excel-o" aria-hidden="true"></span> Unduh .xls</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></span> Download</a>-->
                <?php }elseif(($doc_tup == 'SPP-DITOLAK')||($doc_tup == 'SPM-DITOLAK-KPA')||($doc_tup == 'SPM-DITOLAK-VERIFIKATOR')||($doc_tup == 'SPM-DITOLAK-KBUU')||($doc_tup == 'SPM-DITOLAK-BUU')){ ?>
                    <?php if($detail_tup['nom'] == '0'):?>
                    <a href="#" class="btn btn-warning" disabled="disabled"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></span> Proses SPP</a>
                    <?php else: ?>
                    <a href="#" data-toggle="modal" class="btn btn-warning" data-target="#myModalKonfirm" id="proses_spp_"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></span> Proses SPP</a>
                    <?php endif; ?>
                    <!--<a href="#" data-toggle="modal" class="btn btn-warning" data-target="#myModalKonfirm" id="proses_spp_"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></span> Proses SPP</a>-->
                    <a href="#" class="btn btn-warning" style="display: none" id="proses_spp"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Proses SPP</a>
                    <a href="<?=site_url('kuitansi/daftar_kuitansi/GP')?>" class="btn btn-success" ><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Daftar Kuitansi</a>
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <button type="button" class="btn btn-default" id="xls" rel=""><span class="fa fa-file-excel-o" aria-hidden="true"></span> Unduh .xls</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></span> Download</a>-->
                <?php }else{ ?>
                    <a href="#" class="btn btn-warning" disabled="disabled"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Proses SPP</a>
                    <a href="<?=site_url('kuitansi/daftar_kuitansi/GP')?>" class="btn btn-success" ><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Daftar Kuitansi</a>
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <button type="button" class="btn btn-default" id="xls" rel=""><span class="fa fa-file-excel-o" aria-hidden="true"></span> Unduh .xls</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></span> Download</a>-->
                <?php } ?>
                    

              </div>
	</div>
      
	</div>
                
                </div>
</div>

      


<!-- Modal -->
<div class="modal" id="myModalLihatKet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Perhatian</h5>
      </div>
      <div class="modal-body">
        <p>Alasan penolakan :</p>
        <p>
            <div class="form-group">
            <blockquote>
  <p><?=$ket?></p>
</blockquote>
            </div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div class="modal" id="myModalKonfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Perhatian</h5>
      </div>
      <div class="modal-body">
          <p ><b>Mohon perhatian :</b></p>
        <p>
            <div class="form-group">
                <blockquote class="">
                <p class="text-danger">Sebelum melakukan proses SPP silahkan anda terlebih dahulu mencetak dan menandatangani form tsb. Terima kasih.</p>
              </blockquote>
            </div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal" id="myModalKonfirmKuitansi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <h5 class="modal-title">Perhatian</h5>
      </div>
      <div class="modal-body">
          <p ><b>Mohon perhatian :</b></p>
        <p>
            <div class="form-group">
                <blockquote class="">
                <p class="text-danger">Untuk membuat SPP TUP-NIHIL silahkan anda memulai dari daftar kuitansi yang akan diusulkan.</p>
              </blockquote>
            </div>
        </p>
      </div>
      <div class="modal-footer">
        <a href="<?=site_url('kuitansi/daftar_kuitansi/GP')?>" class="btn btn-success" ><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Daftar Kuitansi</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal" id="myModalRincianKeluaran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <h5 class="modal-title">Rincian Keluaran</h5>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" id="simpan_keluaran">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Keluaran</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control validate[required]" id="keluaran" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Volume</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control validate[required,min[1]] xnumber" id="volumekeluaran" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Satuan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control validate[required]" id="satuankeluaran" placeholder="">
                    <input type="hidden" id="idkeluaran" value="">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" class="btn btn-success" id="btn_simpan_keluaran"><span class="glyphicon glyphicon-plus-sign"></span> Tambah</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat"></span> Batal</button>
                  </div>
                </div>
              </form>
      </div>
      <div class="modal-footer">
        <!--<a href="<?=site_url('kuitansi/daftar_kuitansi/GP')?>" class="btn btn-success" ><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Daftar Kuitansi</a>-->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal" id="myModalKonfirmZonk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Perhatian</h5>
      </div>
      <div class="modal-body">
          <p ><b>Mohon perhatian :</b></p>
        <p>
            <div class="form-group">
                <blockquote class="">
                <p class="text-danger">Silahkan masukan min. satu (1) keluaran di masing - masing subkegiatan yang terkait sebelum SPP diproses. Terima kasih.</p>
              </blockquote>
            </div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->