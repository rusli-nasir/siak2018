<script type="text/javascript">

$(document).ready(function(){
    
    $("#cetak").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("#div-cetak").printArea( options );
                });
    
    var pos = $('.ttd').position();

    // .outerWidth() takes into account border and padding.
    var width = $('.ttd').width();

    //show the menu directly over the placeholder
//    $("#status_spp").css({
////        position: "absolute",
//        top: (pos.top - 10) + "px",
//        left: (pos.left - 10) + "px"
//    }).show();

        $('#myModalKonfirm').on('hidden.bs.modal', function (e) {
            // do something...
            $('#proses_spp_').hide();
            $('#proses_spp').show();
        })
    
    
    $(document).on("click",'#proses_spp',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPP-DRAFT' + '&nomor_trx=' + $('#nomor_trx').html() + '&jenis=' + 'SPP' + '&jumlah_bayar=' + string_to_angka($('#jumlah_bayar').text()) + '&terbilang=' + $('#terbilang').text() + '&untuk_bayar=' + $('#untuk_bayar').text() + '&penerima=' + $('#penerima').text() + '&alamat=' + $('#alamat').text() + '&nmbank=' + $('#nmbank').text() + '&rekening=' + $('#rekening').text() + '&npwp=' + $('#npwp').text() + '&nmbendahara=' + $('#nmbendahara').text() + '&nipbendahara=' + $('#nipbendahara').text() ;
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_up/usulkan_spp_up')?>",
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
    });
    
    $(document).on("click","#down",function(){
                    $("#status_spp").replaceWith( "<br><br><br>" );
                    var uri = $("#table_spp_up").excelexportjs({
                                    containerid: "table_spp_up"
                                    , datatype: "table"
                                    , returnUri: true
                                });
//                                
//                    var uri = $("#table_spp_up").html();
//                            var blob = new Blob([myJsonString], {
//                                type: "application/vnd.ms-excel;charset=charset=utf-8"
//                            });
//                     var blob = b64toBlob(uri2, "application/pdf");
//
//                     saveAs(blob, '<?=$alias.'_'.$cur_tahun;?>_SPP_UP.pdf');

        $('#dtable').val(uri);
        $('#form_spp').submit();
    
//                html2canvas(document.getElementById("table_spp_up"), {
//                    onrendered: function(canvas) {
//                    document.body.appendChild(canvas);
//                },
//                    width: 300,
//                    height: 300
//                });
    
//            var canvas = document.getElementById("table_spp_up");
////            var ctx = canvas.getContext("2d");
//            // draw to canvas...
//            canvas.toBlob(function(blob) {
//                saveAs(blob, "pretty image.png");
//            });
                            
                            
//                var doc = new jsPDF('p', 'pt', 'a4');
//                var specialElementHandlers = {};
//                doc.fromHTML($('#table_spp_up').get(0), 15, 15, {
//                        'width': 250,
//                        'margin': 1,
//                        'pagesplit': true, //This will work for multiple pages
//                        'elementHandlers': specialElementHandlers
//                });
//
//                doc.save('sample-file.pdf');

//            {
//            var pdf = new jsPDF('p', 'pt', 'letter');
//            // source can be HTML-formatted string, or a reference
//            // to an actual DOM element from which the text will be scraped.
//            source = $('#table_spp_up')[0];

            // we support special element handlers. Register them with jQuery-style 
            // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            // There is no support for any other type of selectors 
            // (class, of compound) at this time.
//            specialElementHandlers = {
//                // element with id of "bypass" - jQuery style selector
////                '#bypassme': function(element, renderer) {
////                    // true = "handled elsewhere, bypass text extraction"
////                    return true
////                }
//            };
//            margins = {
//                top: 80,
//                bottom: 60,
//                left: 40,
//                width: 522
//            };
//            // all coords and widths are in jsPDF instance's declared units
//            // 'inches' in this case
//            pdf.fromHTML(
//                    source, // HTML string or DOM elem ref.
//                    margins.left, // x coord
//                    margins.top, {// y coord
//                        'width': margins.width, // max width of content on PDF
//                        'elementHandlers': specialElementHandlers
//                    },
//            function(dispose) {
//                // dispose: object with X, Y of the last line add to the PDF 
//                //          this allow the insertion of new lines after html
//                pdf.save('Test.pdf');
//            }
//            , margins);
//        }                 

//        var pdf = new jsPDF('p', 'pt', 'a4');
////        pdf.canvas.height = 72 * 11;
////        pdf.canvas.width = 72 * 8.5;
//        html2pdf($('#page-inner').html(), pdf, function(pdf){
//                window.location = pdf.output('datauristring');
//	  });               
//
//	});


//        var pdf = new jsPDF('p', 'pt', 'a4');
//        // source can be HTML-formatted string, or a reference
//        // to an actual DOM element from which the text will be scraped.
//        source = $('#page-inner').html();
//
//        // we support special element handlers. Register them with jQuery-style 
//        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
//        // There is no support for any other type of selectors 
//        // (class, of compound) at this time.
//        specialElementHandlers = {
//            // element with id of "bypass" - jQuery style selector
////            '#bypassme': function (element, renderer) {
////                // true = "handled elsewhere, bypass text extraction"
////                return true
////            }
//        };
//        margins = {
//            top: 3,
//            bottom: 3,
//            left: 3,
//            width: 21
//        };
//        // all coords and widths are in jsPDF instance's declared units
//        // 'inches' in this case
//        pdf.fromHTML(
//        source, // HTML string or DOM elem ref.
//        margins.left, // x coord
//        margins.top, { // y coord
//            'width': margins.width, // max width of content on PDF
//            'elementHandlers': specialElementHandlers
//        },
//
//        function (dispose){
//            // dispose: object with X, Y of the last line add to the PDF 
//            //          this allow the insertion of new lines after html
//            pdf.save('Test.pdf');
//        }, margins);
    
    
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
                        
    <?php if($doc_up == ''){ $stts_bendahara = 'active'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPP UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> belum diusulkan oleh bendahara.</div>
    <?php }elseif($doc_up == 'SPP-DRAFT'){ $stts_bendahara = 'done'; $stts_ppk = 'active'; ?>
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >PPK SUKPA</span></b> .</div>
    <?php }elseif($doc_up == 'SPP-DITOLAK'){ $stts_bendahara = 'active'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPP UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >PPK SUKPA</span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_up == 'SPP-FINAL'){ $stts_bendahara = 'done';  $stts_ppk = 'done'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah diterima oleh <b><span class="text-danger" >PPK SUKPA</span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DRAFT-PPK'){ $stts_bendahara = 'done'; $stts_ppk = 'done';  $stts_kpa = 'active'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KPA </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DRAFT-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'active';  ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >VERIFIKATOR </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DITOLAK-KPA'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KPA </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_up == 'SPM-FINAL-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'active' ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DITOLAK-VERIFIKATOR'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >VERIFIKATOR </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_up == 'SPM-FINAL-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done' ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah disetujui oleh <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DITOLAK-KBUU'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KUASA BUU </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_up == 'SPM-FINAL-BUU'){ $stts_bendahara = 'done'; ?> 
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah difinalisasi oleh <b><span class="text-danger" >BUU </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DITOLAK-BUU'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >BUU </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
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
    <div id="div-cetak">
		<table id="table_spp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
			<tbody>
                            <tr >
                                <td colspan="5" style="text-align: right;font-size: 30px;padding: 10px;"><b>F1</b></td>
                            </tr>
                            
                            <tr >
                                <td colspan="5" style="text-align: center;padding-top: 5px;padding-bottom: 5px;"><img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60"></td>
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
                                    <td style="border-left: none;border-top: none;border-bottom: none;"><b>JENIS : UP</b></td>
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
                                    <td colspan="5"><b>Unit Kerja : <?=$unit_kerja?> &nbsp;&nbsp; Kode Unit Kerja : <?=$unit_id?></b></td>
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
                                            <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar"><?=number_format($detail_up['nom'], 0, ",", ".")?></span>,-<br>
                                                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang"><?=ucwords($detail_up['terbilang'])?> <?php echo substr($detail_up['terbilang'],strlen($detail_up['terbilang'])-6,6) == 'Rupiah' ? '' : 'Rupiah' ; ?></span></b>)</li>
                                                <li>Untuk keperluan : <span id="untuk_bayar"><?=isset($detail_pic->untuk_bayar)?$detail_pic->untuk_bayar:'Pengisian uang persediaan'?></span></li>
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
                                                            <td colspan='3' style="text-align: center">
									<b>PENGELUARAN</b>
								</td>
								<td colspan='2' style="text-align: center">
									<b>PERHITUNGAN TERKAIT PIHAK LAIN</b>
								</td>
							</tr>
							<tr>
                                                            <td style="text-align: center" rowspan="2">
									NAMA AKUN
								</td>
								<td style="text-align: center" rowspan="2">
									KODE AKUN
								</td>
								<td style="text-align: center" rowspan="2">
									JUMLAH UANG
								</td>
								<td colspan="2" style="text-align: center">
									PENERIMAAN DARI PIHAK KE-3
								</td>
								
							</tr>
                                                        <tr>
                                                            <td style="text-align: center">Akun</td>
                                                            <td style="text-align: center">Jumlah Uang</td>
                                                        </tr>
							<tr>
								<td>
									Kas di bendahara pengeluaran
								</td>
								<td  style="text-align: center;">
									12111
								</td>
                                                                <td style="text-align: right;padding-right: 10px;">
									Rp. <?=number_format($detail_up['nom'], 0, ",", ".")?>
								</td>
                                                                <td  style="text-align: center;">&nbsp;</td>
								<td  style="text-align: right;">&nbsp;</td>
							</tr>
                                                        <tr>
								<td>
									&nbsp;
								</td>
								<td>
									&nbsp;
								</td>
								<td>
									&nbsp;
								</td>
                                                                <td style="padding-left: 10px;"><b>Jumlah Penerimaan</b></td>
								<td  style="text-align: right;">Rp. 0</td>
							</tr>
							<tr>
								<td rowspan="3">
								&nbsp;								
								</td>
								<td rowspan="3">
								&nbsp;								
								</td>
								<td rowspan="3">
								&nbsp;								
								</td>
								<td colspan="2" style="text-align: center">
									POTONGAN UNTUK PIHAK LAIN
								</td>
							</tr>
							<tr>
								<td style="text-align: center">
									Akun Pajak dan Potongan Lainnya
								</td>
								<td style="text-align: center">
									Jumlah Uang
								</td>
							</tr>
							<tr>
								<td >
									&nbsp;
								</td>
								<td  style="text-align: right;">
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="2">
								Jumlah Pengeluaran
								</td>
								<td style="text-align: right;padding-right: 10px;">
									Rp. <?=number_format($detail_up['nom'], 0, ",", ".")?>
								</td>
								<td>
									&nbsp;
								</td>
								<td  style="text-align: right;">
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="2">
								Dikurangi : Jumlah potongan untuk pihak lain
								</td>
								<td  style="text-align: right;padding-right: 10px;">
									Rp. 0
								</td>
								<td>
									&nbsp;
								</td>
								<td  style="text-align: right;">
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<strong>Jumlah dana yang dikeluarkan</strong>
								</td>
								<td  style="text-align: right;padding-right: 10px;">
									Rp. <?=number_format($detail_up['nom'], 0, ",", ".")?>
								</td>
                                                                <td style="padding-left: 10px;">
									<b>Jumlah Potongan</b>
								</td>
								<td  style="text-align: right;">
									Rp. 0
								</td>
							</tr>
	
				<tr style="border-bottom: none;">
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;">
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
<img id="status_spp" style="display: none" src="<?php echo base_url(); ?>/assets/img/verified.png" width="150">
<br />
<form action="<?=site_url('rsa_up/cetak_spp')?>" id="form_spp" method="post" style="display: none"  >
    <input type="text" name="dtable" id="dtable" value="" />
    <input type="text" name="dunit" id="dunit" value="<?=$alias?>" />
    <input type="text" name="dtahun" id="dtahun" value="<?=$cur_tahun?>" />
</form>
            <div class="alert alert-warning" style="text-align:center">
                <?php if(($doc_up == '')||($doc_up == 'SPP-DITOLAK')||($doc_up == 'SPM-DITOLAK-KPA')||($doc_up == 'SPM-DITOLAK-VERIFIKATOR')||($doc_up == 'SPM-DITOLAK-KBUU')||($doc_up == 'SPM-DITOLAK-BUU')){ ?>
                    <a href="#" data-toggle="modal" class="btn btn-warning" data-target="#myModalKonfirm" id="proses_spp_"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></span> Proses SPP</a>
                    <a href="#" class="btn btn-warning" style="display: none" id="proses_spp"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></span> Proses SPP</a>
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></span> Download</a>-->
                <?php }else{ ?>
                    <a href="#" class="btn btn-warning" disabled="disabled"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></span> Proses SPP</a>
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></span> Download</a>-->
                <?php } ?>
                    

              </div>
	</div>
      
	</div>

</div>
      
	</div>


<!-- Modal -->
<div class="modal fade" id="myModalLihatKet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Perhatian</h4>
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
        <h4 class="modal-title">Perhatian</h4>
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