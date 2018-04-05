<script type="text/javascript">

$(document).ready(function(){
    
    <?php if($doc_tambah_ks == ''):?>
    
    <?php // if(($doc_tambah_ks == '')||($doc_tambah_ks == 'SPP-DITOLAK')||($doc_tambah_ks == 'SPM-DITOLAK-KPA')||($doc_tambah_ks == 'SPM-DITOLAK-VERIFIKATOR')||($doc_tambah_ks == 'SPM-DITOLAK-KBUU')||($doc_tambah_ks == 'SPM-DITOLAK-BUU')):?>
    
        <?php if($detail_tambah_ks['nom'] == '0' ): ?>

            <?php // if(!($this->session->flashdata('message'))): ?>
                $('#myModalTambahUP').modal({
                    backdrop: 'static',
                    keyboard: true
                  });
            <?php // endif; ?>
        <?php endif; ?>
            
            $('#btn_batal_2').hide();
            $('#btn_batal_1').show();
        
    <?php elseif(($doc_tambah_ks == 'SPP-DITOLAK')||($doc_tambah_ks == 'SPM-DITOLAK-KPA')||($doc_tambah_ks == 'SPM-DITOLAK-VERIFIKATOR')||($doc_tambah_ks == 'SPM-DITOLAK-KBUU')||($doc_tambah_ks == 'SPM-DITOLAK-BUU')):?>

        // $('#myModalKonfirmDitolak').modal({
        //         backdrop: 'static',
        //         keyboard: true
        //       });
            
        //     $('#btn_batal_1').hide();
        //     $('#btn_batal_2').show();
            
            
    <?php elseif($doc_tambah_ks == 'SPM-FINAL-KBUU'):?>
    
        // $('#myModalKonfirmDiterima').modal({
        //         backdrop: 'static',
        //         keyboard: true
        //       });
              
        //     $('#btn_batal_1').hide();
        //     $('#btn_batal_2').show();
            
    <?php endif; ?>


    $("#untuk_pekerjaan").typeahead({
          source: function(query, process) {
                    return $.get("<?=site_url('rsa_tambah_ks/get_data_untuk_pekerjaan')?>", { query : query }, function (data) {
                        // console.log(data);
                        data = $.parseJSON(data);
                        return process(data);
                    });
            },
          autoSelect: true
        });


    $("#nama_pihak_ketiga").typeahead({
          source: function(query, process) {
                    return $.get("<?=site_url('rsa_tambah_ks/get_data_penerima')?>", { query : query }, function (data) {
                        // console.log(item);
                        data = $.parseJSON(data);
                        return process(data);
                        // var results = data.map(function(item) {
                        // var someItem = { nama_pihak_ketiga: item.nama_pihak_ketiga, alamat_ketiga: item.alamat_ketiga };
                        //     return JSON.stringify(someItem.contactname);
                        // });
                        // return process(results);
                    });
            },
             updater: function (obj) {
                // var item = JSON.parse(obj);
                // console.log(obj);
                // $('#nama_pihak_ketiga').attr('value', item.id);
                // $('#alamat_ketiga').attr('value', item.alamat_ketiga);

                var arr = obj.split('|');
                $('#alamat_ketiga').val(arr[1]);
                $('#nama_bank').val(arr[2]);
                $('#nama_rek_bank').val(arr[3]);
                $('#nomor_rek_bank').val(arr[4]);
                $('#nomor_npwp').val(arr[5]);
                return arr[0];
            },
          autoSelect: true
        });


    // $(document).on("click",'#btn_simpan_rincian_spp',function(){


    //     if($("#simpan_rincian_spp").validationEngine("validate")){

    //         $('#untuk_bayar').text($('#untuk_pekerjaan').val());

    //         $('#penerima').text($('#nama_pihak_ketiga').val());

    //         $('#alamat').text($('#alamat_ketiga').val());

    //         $('#nmbank').text($('#nama_bank').val());

    //         $('#nmrekening').text($('#nama_rek_bank').val());

    //         $('#rekening').text($('#nomor_rek_bank').val());

    //         $('#npwp').text($('#nomor_npwp').val());

    //         $('#myModalTambahUP').modal('hide');
    //     }

    // });

    $(document).on("click",'#btn-edit-rincian',function(){

        // if($("#simpan_rincian_spp").validationEngine("validate")){
            $('#untuk_pekerjaan').val($('#untuk_bayar').text());

            $('#nama_pihak_ketiga').val($('#penerima').text());

            $('#alamat_ketiga').val($('#alamat').text());

            $('#nama_bank').val($('#nmbank').text());

            $('#nama_rek_bank').val($('#nmrekening').text());

            $('#nomor_rek_bank').val($('#rekening').text());

            $('#nomor_npwp').val($('#npwp').text());

            $('#myModalTambahUP').modal('show');
        // }

        return false;

    });
        
    
    $("#cetak").click(function(){
                    var mode = 'iframe'; //poTAMBAH KS
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
        
        $(document).on("click",'#btn_buat_lagi',function(){
            $('#myModalKonfirmDitolak').modal('hide');
            $('#myModalKonfirmDiterima').modal('hide');
            $('#myModalTambahUP').modal({
                backdrop: 'static',
                keyboard: true
              });
        });
    
    $(document).on("click",'#btn_penyesuaian',function(){
        
        // if($('#jml_penyesuaian').validationEngine('validate')){
//            console.log($('#jml_penyesuaian').val());


        if($("#simpan_rincian_spp").validationEngine("validate")){

            $('#untuk_bayar').text($('#untuk_pekerjaan').val());

            $('#penerima').text($('#nama_pihak_ketiga').val());

            $('#alamat').text($('#alamat_ketiga').val());

            $('#nmbank').text($('#nama_bank').val());

            $('#nmrekening').text($('#nama_rek_bank').val());

            $('#rekening').text($('#nomor_rek_bank').val());

            $('#npwp').text($('#nomor_npwp').val());

            $('#myModalTambahUP').modal('hide');

        // }


            var jml = $('#jml_penyesuaian').val(); 
            $('#jumlah_bayar').text(angka_to_string(jml));
            $('.jumlah_bayar').text(angka_to_string(jml));
            $('#terbilang').text(terbilang(jml));
            
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_tambah_ks/get_next_nomor_spp')?>",
                data:'' ,
                success:function(data){
//                        console.log(data)
//                        $('#no_bukti').html(data);
//                        $('#myModalKuitansi').modal('show');
//                        if(data=='sukses'){
                            
                            $('#btn_buat_lagi').attr('disabled','disabled');
                            $('#edit-tambah-ks').removeAttr('disabled');
                            $('#proses_spp_').removeAttr('disabled');
                            $('#proses_spp_').attr('data-target','#myModalKonfirm')
                            $('#nomor_trx').text(data);
                            $('#myModalTambahUP').modal('hide');
//                        }
//                        
                }
            });
            
        }
    });
    
    $(document).on("click",'#edit-tambah-ks',function(){
        $('#myModalTambahUP').modal({
                backdrop: 'static',
                keyboard: true
              });
        $('#btn_batal_1').hide();
        $('#btn_batal_2').show();
    });
    
    $(document).on("click",'#proses_spp',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPP-DRAFT' + '&nomor_trx=' + $('#nomor_trx').html() + '&jenis=' + 'SPP' + '&jumlah_bayar=' + string_to_angka($('#jumlah_bayar').text()) + '&terbilang=' + $('#terbilang').text() + '&untuk_bayar=' + $('#untuk_bayar').text() + '&penerima=' + $('#penerima').text() + '&alamat=' + $('#alamat').text() + '&nmbank=' + $('#nmbank').text() + '&rekening=' + $('#rekening').text() + '&nmrekening=' + $('#nmrekening').text() + '&npwp=' + $('#npwp').text() + '&nmbendahara=' + $('#nmbendahara').text() + '&nipbendahara=' + $('#nipbendahara').text() + '&id_nomor_tambah_ks=' + '<?=$id_nomor_tambah_ks?>' ;
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_tambah_ks/usulkan_spp_tambah_ks')?>",
                data:data,
                success:function(data){
//                        console.log(data)
//                        $('#no_bukti').html(data);
//                        $('#myModalKuitansi').modal('show');
                        if(data!='gagal'){
                            window.location = "<?=site_url('rsa_tambah_ks/spp_tambah_ks_lihat/')?>" + data;
                        }else{
                          location.reload();
                        }
//                        
                }
            });
        }
    });
    
    $(document).on("click","#down",function(){
                    $("#status_spp").replaceWith( "<br><br><br>" );
                    var uri = $("#table_spp_tambah_ks").excelexportjs({
                                    containerid: "table_spp_tambah_ks"
                                    , datatype: "table"
                                    , returnUri: true
                                });

        $('#dtable').val(uri);
        $('#form_spp').submit();
   
    
    
    });
    
            // $('input.xnumber').focusin(function() {
        $(document).on("focusin","input.xnumber",function(){

                if($(this).val()=='0'){
                        $(this).val('');
                }
                else{
                        var str = $(this).val();
                        $(this).val(angka_to_string(str));
                }
        });

        // $('input.xnumber').focusout(function() {
        $(document).on("focusout","input.xnumber",function(){

//            var kode_usulan_belanja = $(this).attr('rel');

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
        
        // $('input.xnumber').keyup(function(event) {
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


function terbilang(bilangan) {

 bilangan    = String(bilangan);
 var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
 var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
 var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

 var panjang_bilangan = bilangan.length;

 /* pengujian panjang bilangan */
 if (panjang_bilangan > 15) {
   kaLimat = "Diluar Batas";
   return kaLimat;
 }

 /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
 for (i = 1; i <= panjang_bilangan; i++) {
   angka[i] = bilangan.substr(-(i),1);
 }

 i = 1;
 j = 0;
 kaLimat = "";


 /* mulai proses iterasi terhadap array angka */
 while (i <= panjang_bilangan) {

   subkaLimat = "";
   kata1 = "";
   kata2 = "";
   kata3 = "";

   /* untuk Ratusan */
   if (angka[i+2] != "0") {
     if (angka[i+2] == "1") {
       kata1 = "Seratus";
     } else {
       kata1 = kata[angka[i+2]] + " Ratus";
     }
   }

   /* untuk Puluhan atau Belasan */
   if (angka[i+1] != "0") {
     if (angka[i+1] == "1") {
       if (angka[i] == "0") {
         kata2 = "Sepuluh";
       } else if (angka[i] == "1") {
         kata2 = "Sebelas";
       } else {
         kata2 = kata[angka[i]] + " Belas";
       }
     } else {
       kata2 = kata[angka[i+1]] + " Puluh";
     }
   }

   /* untuk Satuan */
   if (angka[i] != "0") {
     if (angka[i+1] != "1") {
       kata3 = kata[angka[i]];
     }
   }

   /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
   if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
     subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
   }

   /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
   kaLimat = subkaLimat + kaLimat;
   i = i + 3;
   j = j + 1;

 }

 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
 if ((angka[5] == "0") && (angka[6] == "0")) {
   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
 }

 return kaLimat + "Rupiah";
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
                        
    <?php if($doc_tambah_ks == ''){ $stts_bendahara = 'active'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> belum diusulkan oleh bendahara.</div>
    <?php }elseif($doc_tambah_ks == 'SPP-DRAFT'){ $stts_bendahara = 'done'; $stts_ppk = 'active'; ?>
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >PPK SUKPA</span></b> .</div>
    <?php }elseif($doc_tambah_ks == 'SPP-DITOLAK'){ $stts_bendahara = 'done'; $stts_ppk = 'tolak'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >PPK SUKPA</span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_tambah_ks == 'SPP-FINAL'){ $stts_bendahara = 'done';  $stts_ppk = 'done'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah diterima oleh <b><span class="text-danger" >PPK SUKPA</span></b> .</div>
    <?php }elseif($doc_tambah_ks == 'SPM-DRAFT-PPK'){ $stts_bendahara = 'done'; $stts_ppk = 'done';  $stts_kpa = 'active'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KPA </span></b> .</div>
    <?php }elseif($doc_tambah_ks == 'SPM-DRAFT-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'active';  ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >VERIFIKATOR </span></b> .</div>
    <?php }elseif($doc_tambah_ks == 'SPM-DITOLAK-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'tolak' ; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KPA </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_tambah_ks == 'SPM-FINAL-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'active' ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc_tambah_ks == 'SPM-DITOLAK-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'tolak'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >VERIFIKATOR </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_tambah_ks == 'SPM-FINAL-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done'; ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah disetujui oleh <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc_tambah_ks == 'SPM-DITOLAK-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'tolak'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KUASA BUU </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_tambah_ks == 'SPM-FINAL-BUU'){$stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done'; $stts_buu = 'done';  ?> 
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah difinalisasi oleh <b><span class="text-danger" >BUU </span></b> .</div>
    <?php }elseif($doc_tambah_ks == 'SPM-DITOLAK-BUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done'; $stts_buu = 'tolak'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >BUU </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
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
                                    <td style="border-left: none;border-top: none;border-bottom: none;"><b>JENIS : KS</b></td>
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
                                            <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar"><?=number_format($detail_tambah_ks['nom'], 0, ",", ".")?></span>,-<br>
                                                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang"><?=ucwords($detail_tambah_ks['terbilang'])?> <?php echo substr($detail_tambah_ks['terbilang'],strlen($detail_tambah_ks['terbilang'])-6,6) == 'Rupiah' ? '' : 'Rupiah' ; ?></span></b>)</li>
                                                <li>Untuk keperluan : <span id="untuk_bayar"><?=isset($detail_pic->untuk_bayar)?$detail_pic->untuk_bayar:'-'?></span></li>
                                                <li>Nama PIC : <span id="penerima"><?=isset($detail_pic->penerima)?$detail_pic->penerima:'-'?></span></li>
                                                <li>Alamat : <span id="alamat"><?=isset($detail_pic->alamat_penerima)?$detail_pic->alamat_penerima:'-'?></span></li>
                                                <li>Nama Bank : <span id="nmbank"><?=isset($detail_pic->nama_bank_penerima)?$detail_pic->nama_bank_penerima:'-'?></span></li>
                                                <li>Nama Rekening Bank : <span id="nmrekening"><?=isset($detail_pic->nama_rek_penerima)?$detail_pic->nama_rek_penerima:'-'?></span></li>
                                                <li>No. Rekening Bank : <span id="rekening"><?=isset($detail_pic->no_rek_penerima)?$detail_pic->no_rek_penerima:'-'?></span></li>
                                                <li>No. NPWP : <span id="npwp"><?=isset($detail_pic->npwp_penerima)?$detail_pic->npwp_penerima:'-'?></span> <!--[ <a href="#" id="btn-edit-rincian">edit</a> ]--></li>
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
									Kas di PIC Kerja Sama
								</td>
								<td  style="text-align: center;">
									13111
								</td>
                                                                <td style="text-align: right;padding-right: 10px;">
                                                                    Rp. <span class="jumlah_bayar"><?=number_format($detail_tambah_ks['nom'], 0, ",", ".")?></span>
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
                                                                    Rp. <span class="jumlah_bayar"><?=number_format($detail_tambah_ks['nom'], 0, ",", ".")?></span>
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
                                                                    Rp. <span class="jumlah_bayar"><?=number_format($detail_tambah_ks['nom'], 0, ",", ".")?></span>
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
<form action="<?=site_url('rsa_tambah_ks/cetak_spp')?>" id="form_spp" method="post" style="display: none"  >
    <input type="text" name="dtable" id="dtable" value="" />
    <input type="text" name="dunit" id="dunit" value="<?=$alias?>" />
    <input type="text" name="dtahun" id="dtahun" value="<?=$cur_tahun?>" />
</form>
            <div class="alert alert-warning" style="text-align:center">
                <?php if(($doc_tambah_ks == '')||($doc_tambah_ks == 'SPP-DITOLAK')||($doc_tambah_ks == 'SPM-DITOLAK-KPA')||($doc_tambah_ks == 'SPM-DITOLAK-VERIFIKATOR')||($doc_tambah_ks == 'SPM-DITOLAK-KBUU')||($doc_tambah_ks == 'SPM-DITOLAK-BUU')){ ?>
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></span> Download</a>-->
                <?php }elseif($doc_tambah_ks == 'SPM-FINAL-KBUU'){ ?>
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></span> Download</a>-->
                <?php }else{ ?>
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

<!-- Modal -->
<div class="modal" id="myModalTambahUP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">TAMBAH KS</h4>
      </div>
    <div class="modal-body">
         <form class="form-horizontal" id="simpan_rincian_spp">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Untuk Keperluan</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control validate[required]" id="untuk_pekerjaan" placeholder="" data-provide="typeahead">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Nama PIC</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control validate[required]" id="nama_pihak_ketiga" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Alamat</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control validate[required]" id="alamat_ketiga" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Nama Bank</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control validate[required]" id="nama_bank" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Nama Rekening</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control validate[required]" id="nama_rek_bank" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">No Rekening Bank</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control validate[required]" id="nomor_rek_bank" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">No NPWP</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control validate[required]" id="nomor_npwp" placeholder="">
                  </div>
                </div>
                <div class="form-group">
              <label class="col-sm-3 control-label">Jumlah</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control validate[required,custom[integer],min[1]] xnumber" placeholder="" id="jml_penyesuaian" value="0">
                  </div>
            </div>
              </form>
            

    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn_penyesuaian" ><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Submit</button>
        <a href="<?php echo site_url('rsa_ks');?>" class="btn btn-danger" id="btn_batal_1"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_batal_2"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal" id="myModalKonfirmDitolak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Perhatian</h4>
      </div>
      <div class="modal-body">
          <p ><b>Mohon perhatian :</b></p>
        <p>
            <div class="form-group">
                <blockquote class="">
                <p class="text-danger">SPP/SPM anda ditolak, anda ingin mengajukannya lagi ?.</p>
              </blockquote>
            </div>
        </p>
      </div>
      <div class="modal-footer">
          <div class="alert alert-warning text-center">
              <!--<a href="<?php echo site_url('rsa_tambah_ks');?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tidak</a>-->
              <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tidak</button>
          </div>
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>-->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal" id="myModalKonfirmDiterima" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Perhatian</h4>
      </div>
      <div class="modal-body">
          <p ><b>Mohon perhatian :</b></p>
        <p>
            <div class="form-group">
                <blockquote class="">
                <p class="text-danger">SPM anda telah diterima, anda ingin mengajukannya lagi ?.</p>
              </blockquote>
            </div>
        </p>
      </div>
      <div class="modal-footer">
          <div class="alert alert-warning text-center">
              <!--<a href="<?php echo site_url('rsa_tambah_ks');?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tidak</a>-->
              <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tidak</button>
          </div>
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>-->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->