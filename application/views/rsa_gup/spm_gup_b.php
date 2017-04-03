<script type="text/javascript">

$(document).ready(function(){
    
    $('#spm_tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
      });

      // store the currently selected tab in the hash value
      $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
      });

      // on load of the page: switch to the currently selected tab
      var hash = window.location.hash;
      $('#spm_tab a[href="' + hash + '"]').tab('show');
    
    $("#cetak").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("#div-cetak").printArea( options );
                });
                
                $("#cetak-spm").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("#div-cetak-spm").printArea( options );
                });
    
    var pos = $('.ttd').position();

    // .outerWidth() takes into account border and padding.
    var width = $('.ttd').width();

    //show the menu directly over the placeholder
//    $("#status_spp").css({
//        position: "absolute",
//        top: (pos.top - 10) + "px",
//        left: (pos.left - 10) + "px"
//    }).show();

$('#myModalKonfirm').on('hidden.bs.modal', function (e) {
            // do something...
            $('#proses_spm_').hide();
            $('#proses_spm').show();
        })
    
    $(document).on("click",'#proses_spp',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPP-FINAL' + '&nomor_trx=' + $('#nomor_trx').html() + '&jenis=' + 'SPP' ;
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_gup/proses_spp_gup')?>",
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
    
    $(document).on("click",'#proses_spm',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPM-DRAFT-PPK' + '&nomor_trx=' + $('#nomor_trx_spm').html() + '&jenis=' + 'SPM' + '&nomor_trx_spp=' + $('#nomor_trx').html() + '&jumlah_bayar=' + string_to_angka($('#jumlah_bayar').text()) + '&terbilang=' + $('#terbilang').text() + '&untuk_bayar=' + $('#untuk_bayar').text() + '&penerima=' + $('#penerima').text() + '&alamat=' + $('#alamat').text() + '&nmbank=' + $('#nmbank').text() + '&rekening=' + $('#rekening').text() + '&npwp=' + $('#npwp').text() + '&nmppk=' + $('#nmppk').text() + '&nipppk=' + $('#nipppk').text() + '&nmkpa=' + $('#nmkpa').text() + '&nipkpa=' + $('#nipkpa').text() + '&nmkbuu=' + $('#nmkbuu').text() + '&nipkbuu=' + $('#nipkbuu').text() + '&nmbuu=' + $('#nmbuu').text() + '&nipbuu=' + $('#nipbuu').text()
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_gup/usulkan_spm_gup')?>",
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
    
    $(document).on("click",'#tolak_spp_',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPP-DITOLAK' + '&nomor_trx=' + $('#nomor_trx').html() + '&jenis=' + 'SPP' + '&ket=' + $('#ket').val();
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_up/proses_spp_up')?>",
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
    
    $('#myModalTolakSPP').on('shown.bs.modal', function (e) {
        // do something...
        $('#ket').focus();
      })
    
    $(document).on("click","#down",function(){
                    var uri = $("#table_spp_up").excelexportjs({
                                    containerid: "table_spp_up"
                                    , datatype: "table"
                                    , returnUri: true
                                });

        $('#dtable').val(uri);
        $('#form_spp').submit();

    
    });
    
    $(document).on("click","#down_2",function(){
                    var uri = $("#table_spm_up").excelexportjs({
                                    containerid: "table_spm_up"
                                    , datatype: "table"
                                    , returnUri: true
                                });

        $('#dtable_2').val(uri);
        $('#form_spm').submit();

    
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
    <?php }elseif($doc_up == 'SPP-FINAL'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah diterima oleh <b><span class="text-danger" >PPK SUKPA</span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DRAFT-PPK'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'active'; ?>   
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

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="spm_tab">
        <li role="presentation" class="active"><a href="#spp" aria-controls="home" role="tab" data-toggle="tab">SPP</a></li>
        <li role="presentation"><a href="#spm" aria-controls="profile" role="tab" data-toggle="tab">SPM</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="spp">
          
          <div style="background-color: #EEE; padding: 10px;">
<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
<div class="carousel-inner" role="listbox">
<div class="item active" id="a">
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
                                    <td style="border-left: none;border-top: none;border-bottom: none;"><b>JENIS : GUP</b></td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="2" style="border-right: none;border-top:none;"><b>Tanggal	: <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); ?></b></td>
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
                                            <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar_spp"><?php echo isset($detail_up['nom'])?number_format($detail_up['nom'], 0, ",", "."):''; ?></span>,-<br>
                                                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang_spp"><?php echo isset($detail_up['terbilang'])?ucwords($detail_up['terbilang']):''; ?></span></b>)</li>
                                                <li>Untuk keperluan : <span id="untuk_bayar_spp"><?=isset($detail_pic->untuk_bayar)?$detail_pic->untuk_bayar:''?></span></li>
                                                <li>Nama bendahara pengeluaran : <span id="penerima_spp"><?=isset($detail_pic->penerima)?$detail_pic->penerima:''?></span></li>
                                                <li>Alamat : <span id="alamat_spp"><?=isset($detail_pic->alamat_penerima)?$detail_pic->alamat_penerima:''?></span></li>
                                                <li>Nama Bank : <span id="nmbank_spp"><?=isset($detail_pic->nama_bank_penerima)?$detail_pic->nama_bank_penerima:''?></span></li>
                                                <li>No. Rekening Bank : <span id="rekening_spp"><?=isset($detail_pic->no_rek_penerima)?$detail_pic->no_rek_penerima:''?></span></li>
                                                <li>No. NPWP : <span id="npwp_spp"><?=isset($detail_pic->npwp_penerima)?$detail_pic->npwp_penerima:''?></span></li>
                                        </ol>
                                    </td>
                                </tr>
                                                               
                                                                
                                <tr>
                                        <td colspan="5" style="border-top: none;border-bottom:none;">
                                        Pembayaran sebagaimana tersebut diatas, dibebankan pada pengeluaran dengan uraian sebagai berikut :<br>							
                                        </td>
				
                                
                                </tr>
							<tr >
                                                            <td colspan="3" style="vertical-align: top;border-bottom: none;border-top:none;padding-left: 0;">
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
                                                                            <td style="text-align: right;">
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
                                                                        <td  style="text-align: right;">
                                                                                Rp. <?=number_format($jml_pengeluaran, 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="border-right: solid 1px #000">
                                                                            Dikurangi : Jumlah potongan untuk pihak lain
                                                                        </td>
                                                                        <td  style="text-align: right;">
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
                                                                    <td  style="text-align: right;">
                                                                            Rp. <?=number_format(($jml_pengeluaran - $tot_pajak__), 0, ",", ".")?>
                                                                    </td>
                                                                </table>
                                                            </td>
                                                            <td colspan="2" style="vertical-align: top;border-bottom: none;border-top:none;padding-right: 0;">
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
                                                                        <td style="text-align: right;">Rp. 0</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;"><b>Jumlah Penerimaan</b></td>
                                                                        <td  style="text-align: right;">Rp. 0</td>
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
                                                                            <td  style="text-align: right;">
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
                                                                        <td  style="text-align: right;">
                                                                                Rp. <?=number_format($tot_pajak_, 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
							</tr>
                                <tr >
                                        <td colspan="5" style="border-bottom: none;border-top: none;">&nbsp;</td>
                                </tr>
				<tr style="border-bottom: none;">
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;border-top:none;">
						SPP Sebagaimana dimaksud diatas, disusun sesuai dengan dokumen lampiran yang persyaratkan dan disampaikan secara bersamaan serta merupakan bagian yang tidak terpisahkan dari surat ini.<br><br>														
					</td>
				<tr>
				<tr style="border-top: none;"> 
				
                                    <td colspan="4" style="border-right: none;border-top:none;">&nbsp;</td>
								<td  style="line-height: 16px;border-left: none;border-top:none;" class="ttd">
									Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
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
                            <td colspan="7" style="text-align: center;border-bottom: none;">
                                <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
                                <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                <h5><b>RINCIAN SURAT PERMINTAAN PEMBAYARAN GUP</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="2" style="border: none;">
                                <b>NO SPP : <?=$nomor_spp?></b>
                            </td>
                            <td style="border: none;">&nbsp;</td>
                            <td colspan="3" style="border-left: none;border-top: none;border-bottom: none;">
                                <b>TANGGAL : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> </b>
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
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->pagu_rkat, 0, ",", ".")?></td>
                                            <?php $pagu_rkat =  $da->pagu_rkat ;?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $pagu_rkat =  0 ;?>
                                <?php endif;?>
                                <?php if(!empty($data_akun_pengeluaran_lalu)):?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style="padding-right: 10px;">
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format(($data_akun_pengeluaran_lalu + $data->pengeluaran), 0, ",", ".")?></td>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format(($pagu_rkat - ($data_akun_pengeluaran_lalu + $data->pengeluaran)), 0, ",", ".")?></td>
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
                            <td class="text-center" colspan="4">Total Nilai ( Rp )</td>
                            <td class="text-right" style="padding-right: 10px;"><?=number_format($jml_pengeluaran, 0, ",", ".")?></td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" style="border-right:none;" colspan="2">
                                <ol start="9" style="margin: 10px;">
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
                        <tr>
                            <td class="text-center" >1</td>
                            <td class="text-center" >Lokakarya ( 2 hari )</td>
                            <td class="text-center" >peserta</td>
                            <td class="text-center" >80</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
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
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
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
                                <td colspan="6" class="text-center" style="text-align: center;border: none;">
                                    <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
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
                                <td class="text-center">SPJ GUP s.d BULAN LALU<br>( Rp )</td>
                                <td class="text-center">SPJ GUP BULAN INI<br>( Rp )</td>
                                <td class="text-center">SPJ GUP s.d BULAN INI<br>( Rp )</td>
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
                                <?php if(!empty($data_akun_pengeluaran_lalu)):?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style="padding-right: 10px;">
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format(($data_akun_pengeluaran_lalu + $data->pengeluaran), 0, ",", ".")?></td>
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
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-right" style="padding-right: 10px;"><?=number_format($jml_pengeluaran, 0, ",", ".")?></td>
                            <td class="text-center">&nbsp;</td>
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
                                <td style="border:none;" class="text-right">
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
                            <td style="border : none;" class="text-right">
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
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
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
    
                 
            <table id="table_rekapakun" class="table_lamp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 1200px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                                <td colspan="13" class="text-center" style="text-align: center;border: none;">
                                    <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                    <h5>REKAPITULASI PERTANGGUNGJAWABAN PENGELUARAN</h5>
                                    <h5><b>SETIAP SUB KEGIATAN PER RINCIAN AKUN</b></h5>
                                    <b style="text-transform: uppercase;">SUKPA : <?=$unit_kerja?> <span style="display: inline-block;width: 100px;">&nbsp;</span> UNIT KERJA : <?=$unit_kerja?></b><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13" style="border: none;">&nbsp;</td>
                            </tr>
                            <?php $jk = 1; ?>
                            <?php if(!empty($data_akun_pengeluaran)): ?>
                            <?php foreach($data_akun_pengeluaran as $data):?>       
                            <tr >
                                <td colspan="13" class="text-center" style="text-align: center;border: none;">
                                    <b style="text-transform: uppercase;">KEGIATAN : <?=$data->nama_komponen?> </b><br>
                                    <b style="text-transform: uppercase;">SUB KEGIATAN : <?=$data->nama_subkomponen?> </b><br>
                                    <b style="text-transform: uppercase;">KODE AKUN  : <?=$data->kode_akun5digit?> <span style="display: inline-block;width: 100px;">&nbsp;</span> URAIAN AKUN : <?=$data->nama_akun5digit?></b><br>
                                    <b style="text-transform: uppercase;">BULAN  : <?=$bulan?> <span style="display: inline-block;width: 100px;">&nbsp;</span> TAHUN : <?=$cur_tahun?></b><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13" style="border-top: none;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 50px;">NO</td>
                                <td class="text-center" style="width: 100px;">TANGGAL</td>
                                <td class="text-center" style="width: 150px;">RINCIAN AKUN</td>
                                <td class="text-center">KODE RINCIAN<br>AKUN</td>
                                <td class="text-center" style="width: 150px;">KODE-URAIAN RINCIAN<br>AKUN</td>
                                <td class="text-center">NO BUKTI</td>
                                <td class="text-center">PENGELUARAN<br>( Rp )</td>
                                <td class="text-center">KUANTITAS<br>KELUARAN</td>
                                <td class="text-center">SATUAN<br>KELUARAN</td>
                                <td class="text-center" style="width: 150px;">KETERANGAN KELUARAN</td>
                                <td class="text-center" style="width: 100px;">JENIS POT<br>PAJAK</td>
                                <td class="text-center" style="width: 100px;">NILAI POT</td>
                                <td class="text-center" style="width: 100px;">NETTO</td>
                            </tr>
                            <?php $kl = 1 ;?>
                            <?php $tot_bruto = 0 ;?>
                            <?php foreach($rincian_akun_pengeluaran as $rincian): ?>
                            <?php if(($rincian->rka == $data->rka)&&($rincian->kode_akun5digit == $data->kode_akun5digit)):?>
                            <tr>
                                <td class="text-center" style="vertical-align: top"><?=$kl?></td>
                                <td class="text-center" style="vertical-align: top"><?php echo strftime("%d-%m-%Y", strtotime($rincian->tgl_kuitansi)) ;?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->nama_akun?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->kode_akun?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->kode_akun_tambah?> - <?=$rincian->deskripsi?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->no_bukti?></td>
                                <td class="text-right" style="vertical-align: top;padding-right: 10px;"><?=number_format(($rincian->volume*$rincian->harga_satuan), 0, ",", ".")?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->volume?></td>
                                <td class="text-center" style="vertical-align: top;"><?=$rincian->satuan?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->uraian?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->pajak_nom?></td>
                                <td class="text-right" style="vertical-align: top;padding-right: 10px;"><?=number_format($rincian->total_pajak, 0, ",", ".")?></td>
                                <td class="text-right" style="vertical-align: top;padding-right: 10px;"><?=number_format(($rincian->bruto-$rincian->total_pajak), 0, ",", ".")?></td>
                                <?php $tot_bruto = $tot_bruto + $rincian->bruto ;?>
                            </tr>
                            <?php $kl++ ; ?>
                            <?php endif;?>
                            <?php endforeach;?>
                            <tr>
                                <td colspan="6" style="border-bottom: none; padding-left: 10px;"><b>Total Pengeluaran</b></td>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format($tot_bruto, 0, ",", ".")?></td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="13" style="border-bottom: none;">&nbsp;</td>
                            </tr>
                            <?php endforeach;?>
                            <?php else: ?>
                            <tr>
                                <td class="text-center" colspan="13">- data kosong -</td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="9" style="border-bottom: none;border-top: none;border-right:none;">&nbsp;</td>
                                <td colspan="4" style="border-bottom: none;border-top: none;border-left:none;">
                                    Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
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
                                <td colspan="13" style="border-top: none;">&nbsp;</td>
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
<br />
<form action="<?=site_url('rsa_up/cetak_spp')?>" id="form_spp" method="post" style="display: none"  >
    <input type="text" name="dtable" id="dtable" value="" />
</form>
            <div class="alert alert-warning" style="text-align:center">
                
                <?php if($doc_up == 'SPP-DRAFT'){ ?>
                    <a href="#" class="btn btn-warning" id="proses_spp"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Setujui SPP</a>
                    <a href="#" class="btn btn-warning" id="tolak_spp" data-toggle="modal" data-target="#myModalTolakSPP"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tolak SPP</a>
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</a>-->
                <?php }else{ ?> 
                    <a href="#" class="btn btn-warning" disabled="disabled" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Setujui SPP</a>
                    <a href="#" class="btn btn-warning" disabled="disabled"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tolak SPP</a>
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</a>-->
                <?php } ?>
                

                    

              </div>
          
      </div>
      <div role="tabpanel" class="tab-pane" id="spm">
          
          <div style="background-color: #EEE; padding: 10px;">
<div id="myCarouselSPM" class="carousel slide" data-ride="carousel" data-interval="false">
<div class="carousel-inner" role="listbox">
<div class="item active" id="a">
<div id="div-cetak-2">
		<table id="table_spp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
            <tbody>
                            <tr >
                                <td colspan="5" style="text-align: right;font-size: 30px;padding: 10px;"><b>F2</b></td>
                            </tr>
                            
                            <tr >
                                <td colspan="5" style="text-align: center;padding-top: 5px;padding-bottom: 5px;"><img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60"></td>
                            </tr>
                            <tr style="">
                                    <td colspan="5" style="text-align: center;font-size: 20px;border-bottom: none;"><b>UNIVERSITAS DIPONEGORO</b></td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="5" style="text-align: center;font-size: 16px;border-bottom: none;border-top: none;"><b>SURAT PERINTAH MEMBAYAR</b></td>
                                </tr>
                                <tr style="border-top: none;border-bottom: none;">
                                    <td colspan="2" style="border-right: none;border-right: none;border-top: none;border-bottom: none;"><b>TAHUN ANGGARAN : <?=$cur_tahun_spm?></b></td>
                                    <td style="text-align: center;border-right: none;border-left: none;border-top: none;border-bottom: none;" colspan="2">&nbsp;</td>
                                    <td style="border-left: none;border-top: none;border-bottom: none;"><b>JENIS : GUP</b></td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="2" style="border-right: none;border-top:none;"><b>Tanggal  : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm==''?'':strftime("%d %B %Y", strtotime($tgl_spm)); ?></td>
                                    <td style="text-align: center;border-left: none;border-right: none;border-top:none;" colspan="2" >&nbsp;</td>
                                    <td style="border-left: none;border-top:none;"><b>Nomor : <span id="nomor_trx_spm"><?=$nomor_spm?></span><!--01/<?=$alias?>/SPM-UP/JAN/<?=$cur_tahun?>--></b></td>
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
                                                    Bendahara Umum Undip ( BUU )<br>
                                                    di Semarang
                                    </td>
                </tr>
                                <tr >
                                        <td colspan="5" style="border-bottom: none;border-top: none;">&nbsp;</td>
                                </tr>
                                <tr >
                                        <td colspan="5" style="border-bottom: none;border-top: none;">Dengan Berpedoman pada Dokumen SPP yang disampaikan bendahara pengeluaran dan telah diteliti keabsahan dan kebenarannya oleh PPK-SUKPA. bersama ini kami memerintahkan kepada Kuasa BUU untuk membayar sebagai berikut :
                                </tr>
                <tr>
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;border-top: none;">
                                        <ol style="list-style-type: lower-alpha;margin-top: 0px;margin-bottom: 0px;" >
                                            <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar"><?php echo isset($detail_up['nom'])?number_format($detail_up['nom'], 0, ",", "."):''; ?></span>,-<br>
                                                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang"><?php echo isset($detail_up['terbilang'])?ucwords($detail_up['terbilang']):''; ?></span></b>)</li>
                                                <li>Untuk keperluan : <span id="untuk_bayar"><?=isset($detail_pic->untuk_bayar)?$detail_pic->untuk_bayar:''?></span></li>
                                                <li>Nama bendahara pengeluaran : <span id="penerima"><?=isset($detail_pic->penerima)?$detail_pic->penerima:''?></span></li>
                                                <li>Alamat : <span id="alamat"><?=isset($detail_pic->alamat_penerima)?$detail_pic->alamat_penerima:''?></span></li>
                                                <li>Nama Bank : <span id="nmbank"><?=isset($detail_pic->nama_bank_penerima)?$detail_pic->nama_bank_penerima:''?></span></li>
                                                <li>No. Rekening Bank : <span id="rekening"><?=isset($detail_pic->no_rek_penerima)?$detail_pic->no_rek_penerima:''?></span></li>
                                                <li>No. NPWP : <span id="npwp"><?=isset($detail_pic->npwp_penerima)?$detail_pic->npwp_penerima:''?></span></li>
                                        </ol>
                                    </td>
                                </tr>
                                                               
                                                                
                                <tr>
                                        <td colspan="5" style="border-top: none;border-bottom:none;">
                                        Pembayaran sebagaimana tersebut diatas, dibebankan pada pengeluaran dengan uraian sebagai berikut :<br>                         
                                        </td>
                
                                
                                </tr>
                        
                                            
                                    </tr>

                            <tr >
                                                            <td colspan="3" style="vertical-align: top;border-bottom: none;border-top:none;padding-left: 0;">
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
                                                                            <td style="text-align: right;">
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
                                                                        <td  style="text-align: right;">
                                                                                Rp. <?=number_format($jml_pengeluaran, 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="border-right: solid 1px #000">
                                                                            Dikurangi : Jumlah potongan untuk pihak lain
                                                                        </td>
                                                                        <td  style="text-align: right;">
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
                                                                    <td  style="text-align: right;">
                                                                            Rp. <?=number_format(($jml_pengeluaran - $tot_pajak__), 0, ",", ".")?>
                                                                    </td>
                                                                </table>
                                                            </td>
                                                            <td colspan="2" style="vertical-align: top;border-bottom: none;border-top:none;padding-right: 0;">
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
                                                                        <td style="text-align: right;">Rp. 0</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;"><b>Jumlah Penerimaan</b></td>
                                                                        <td  style="text-align: right;">Rp. 0</td>
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
                                                                            <td  style="text-align: right;">
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
                                                                        <td  style="text-align: right;">
                                                                                Rp. <?=number_format($tot_pajak_, 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                            </tr>
                                                        <tr >
                                        <td colspan="5" style="border-bottom: none;border-top: none;">&nbsp;</td>
                                </tr>
    
                <tr style="border-bottom: none;">
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;border-top:none;">
                        Surat Perintah Membayar ( SPM ) Sebagaimana dimaksud diatas, disusun sesuai dengan dokumen lampiran yang persyaratkan dan disampaikan secara bersamaan serta merupakan bagian yang tidak terpisahkan dari surat ini.<br><br>                                                        
                    </td>
                <tr>
                <tr style="border-top: none;"> 
                                    
                                    <td colspan="3" style="line-height: 16px;border-right: none;border-top:none;">
                                    Dokumen SPM, dan lampirannya telah diverifikasi keabsahannya<br>
                                                                        PPK-SUKPA<br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
                                                                        <span id="nmppk"><?=isset($detail_ppk->nm_lengkap)?$detail_ppk->nm_lengkap:''?></span><br>
                                                                        NIP. <span id="nipppk"><?=isset($detail_ppk->nomor_induk)?$detail_ppk->nomor_induk:''?></span><br>
                                </td>
                
                                    <td  style="border-left: none;border-right: none;border-top:none;">&nbsp;</td>
                                <td  style="line-height: 16px;border-left: none;border-top:none;">
                                    Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm_kpa==''?'':strftime("%d %B %Y", strtotime($tgl_spm_kpa)); ?><br />
                                    Kuasa Pengguna Anggaran<br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
                                                                        <span id="nmkpa"><?=isset($detail_kpa->nm_lengkap)?$detail_kpa->nm_lengkap:''?></span><br>
                                                                        NIP. <span id="nipkpa"><?=isset($detail_kpa->nomor_induk)?$detail_kpa->nomor_induk:''?></span><br>
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
                                <tr>
                                    <td colspan="2" style="vertical-align: top;line-height: 16px;">
                                        Dokumen SPM. dan Lampirannya telah <br>
                                        diverifikasi kelengkapannya<br>
                                        Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm_verifikator==''?'':strftime("%d %B %Y", strtotime($tgl_spm_verifikator)); ?><br />
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <span id="nmverifikator"><?php echo isset($detail_verifikator->nm_lengkap)? $detail_verifikator->nm_lengkap : '' ; ?></span><br>
                                        NIP. <span id="nipverifikator"><?php echo isset($detail_verifikator->nomor_induk)? $detail_verifikator->nomor_induk : '' ;?></span><br>
                                    </td>
                                    <td colspan="2" style="vertical-align: top;line-height: 16px;padding-left: 10px;">
                                        <?php if(isset($detail_spm_up['nom'])){ ?>
                                            <?php if($detail_spm_up['nom'] >= 100000000){ ?>
                                            Setuju dibayar : <br>
                                            Kuasa Bendahara Umum Undip harap membayar<br>
                                            kepada nama yang tersebut sesuai SPM dari KPA<br>
                                            Bendahara Umum Undip<br>
                                            <br>
                                            <br>
                                            <br>
                                            <span id="nmbuu"><?=$detail_buu->nm_lengkap?></span><br>
                                            NIP. <span id="nipbuu"><?=$detail_buu->nomor_induk?></span><br>
                                            <?php }else{ ?>
                                            <span style="display: inline-block;width: 280px;">&nbsp;</span>
                                            <?php } ?>
                                        <?php }else{ ?>
                                        <span style="display: inline-block;width: 280px;">&nbsp;</span>
                                        <?php } ?>
                                    </td>
                                    <td style="vertical-align: top;line-height: 16px;padding-left: 10px;">
                                        Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm_kbuu==''?'':strftime("%d %B %Y", strtotime($tgl_spm_kbuu)); ?><br />
                                        Telah dibayar oleh <br>
                                        Kuasa Bendahara Umum Undip<br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <span id="nmkbuu"><?=$detail_kuasa_buu->nm_lengkap?></span><br>
                                        NIP. <span id="nipkbuu"><?=$detail_kuasa_buu->nomor_induk?></span><br>
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
                            <td colspan="7" style="text-align: center;border-bottom: none;">
                                <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
                                <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                <h5><b>RINCIAN SURAT PERINTAH MEMBAYAR GUP</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="2" style="border: none;">
                                <b>NO SPP : <?=$nomor_spm?></b>
                            </td>
                            <td style="border: none;">&nbsp;</td>
                            <td colspan="3" style="border-left: none;border-top: none;border-bottom: none;">
                                <b>TANGGAL : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm==''?'':strftime("%d %B %Y", strtotime($tgl_spm)); ?></b>
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
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->pagu_rkat, 0, ",", ".")?></td>
                                            <?php $pagu_rkat =  $da->pagu_rkat ;?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $pagu_rkat =  0 ;?>
                                <?php endif;?>
                                <?php if(!empty($data_akun_pengeluaran_lalu)):?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style="padding-right: 10px;">
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format(($data_akun_pengeluaran_lalu + $data->pengeluaran), 0, ",", ".")?></td>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format(($pagu_rkat - ($data_akun_pengeluaran_lalu + $data->pengeluaran)), 0, ",", ".")?></td>
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
                            <td class="text-center" colspan="4">Total Nilai ( Rp )</td>
                            <td class="text-right" style="padding-right: 10px;"><?=number_format($jml_pengeluaran, 0, ",", ".")?></td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" style="border-right:none;" colspan="2">
                                <ol start="9" style="margin: 10px;">
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
                        <tr>
                            <td class="text-center" >1</td>
                            <td class="text-center" >Lokakarya ( 2 hari )</td>
                            <td class="text-center" >peserta</td>
                            <td class="text-center" >80</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
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
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm==''?'':strftime("%d %B %Y", strtotime($tgl_spm)); ?><br>
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
                                <td colspan="6" class="text-center" style="text-align: center;border: none;">
                                    <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
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
                                <td class="text-center">SPJ GUP s.d BULAN LALU<br>( Rp )</td>
                                <td class="text-center">SPJ GUP BULAN INI<br>( Rp )</td>
                                <td class="text-center">SPJ GUP s.d BULAN INI<br>( Rp )</td>
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
                                <?php if(!empty($data_akun_pengeluaran_lalu)):?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style="padding-right: 10px;">
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format(($data_akun_pengeluaran_lalu + $data->pengeluaran), 0, ",", ".")?></td>
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
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-right" style="padding-right: 10px;"><?=number_format($jml_pengeluaran, 0, ",", ".")?></td>
                            <td class="text-center">&nbsp;</td>
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
                                <td style="border:none;" class="text-right">
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
                            <td style="border : none;" class="text-right">
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
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm==''?'':strftime("%d %B %Y", strtotime($tgl_spm)); ?><br>
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
    
                 
            <table id="table_rekapakun" class="table_lamp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 1200px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                                <td colspan="13" class="text-center" style="text-align: center;border: none;">
                                    <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                    <h5>REKAPITULASI PERTANGGUNGJAWABAN PENGELUARAN</h5>
                                    <h5><b>SETIAP SUB KEGIATAN PER RINCIAN AKUN</b></h5>
                                    <b style="text-transform: uppercase;">SUKPA : <?=$unit_kerja?> <span style="display: inline-block;width: 100px;">&nbsp;</span> UNIT KERJA : <?=$unit_kerja?></b><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13" style="border: none;">&nbsp;</td>
                            </tr>
                            <?php $jk = 1; ?>
                            <?php if(!empty($data_akun_pengeluaran)): ?>
                            <?php foreach($data_akun_pengeluaran as $data):?>       
                            <tr >
                                <td colspan="13" class="text-center" style="text-align: center;border: none;">
                                    <b style="text-transform: uppercase;">KEGIATAN : <?=$data->nama_komponen?> </b><br>
                                    <b style="text-transform: uppercase;">SUB KEGIATAN : <?=$data->nama_subkomponen?> </b><br>
                                    <b style="text-transform: uppercase;">KODE AKUN  : <?=$data->kode_akun5digit?> <span style="display: inline-block;width: 100px;">&nbsp;</span> URAIAN AKUN : <?=$data->nama_akun5digit?></b><br>
                                    <b style="text-transform: uppercase;">BULAN  : <?=$bulan?> <span style="display: inline-block;width: 100px;">&nbsp;</span> TAHUN : <?=$cur_tahun?></b><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13" style="border-top: none;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 50px;">NO</td>
                                <td class="text-center" style="width: 100px;">TANGGAL</td>
                                <td class="text-center" style="width: 150px;">RINCIAN AKUN</td>
                                <td class="text-center">KODE RINCIAN<br>AKUN</td>
                                <td class="text-center" style="width: 150px;">KODE-URAIAN RINCIAN<br>AKUN</td>
                                <td class="text-center">NO BUKTI</td>
                                <td class="text-center">PENGELUARAN<br>( Rp )</td>
                                <td class="text-center">KUANTITAS<br>KELUARAN</td>
                                <td class="text-center">SATUAN<br>KELUARAN</td>
                                <td class="text-center" style="width: 150px;">KETERANGAN KELUARAN</td>
                                <td class="text-center" style="width: 100px;">JENIS POT<br>PAJAK</td>
                                <td class="text-center" style="width: 100px;">NILAI POT</td>
                                <td class="text-center" style="width: 100px;">NETTO</td>
                            </tr>
                            <?php $kl = 1 ;?>
                            <?php $tot_bruto = 0 ;?>
                            <?php foreach($rincian_akun_pengeluaran as $rincian): ?>
                            <?php if(($rincian->rka == $data->rka)&&($rincian->kode_akun5digit == $data->kode_akun5digit)):?>
                            <tr>
                                <td class="text-center" style="vertical-align: top"><?=$kl?></td>
                                <td class="text-center" style="vertical-align: top"><?php echo strftime("%d-%m-%Y", strtotime($rincian->tgl_kuitansi)) ;?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->nama_akun?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->kode_akun?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->kode_akun_tambah?> - <?=$rincian->deskripsi?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->no_bukti?></td>
                                <td class="text-right" style="vertical-align: top;padding-right: 10px;"><?=number_format(($rincian->volume*$rincian->harga_satuan), 0, ",", ".")?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->volume?></td>
                                <td class="text-center" style="vertical-align: top;"><?=$rincian->satuan?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->uraian?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->pajak_nom?></td>
                                <td class="text-right" style="vertical-align: top;padding-right: 10px;"><?=number_format($rincian->total_pajak, 0, ",", ".")?></td>
                                <td class="text-right" style="vertical-align: top;padding-right: 10px;"><?=number_format(($rincian->bruto-$rincian->total_pajak), 0, ",", ".")?></td>
                                <?php $tot_bruto = $tot_bruto + $rincian->bruto ;?>
                            </tr>
                            <?php $kl++ ; ?>
                            <?php endif;?>
                            <?php endforeach;?>
                            <tr>
                                <td colspan="6" style="border-bottom: none; padding-left: 10px;"><b>Total Pengeluaran</b></td>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format($tot_bruto, 0, ",", ".")?></td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="13" style="border-bottom: none;">&nbsp;</td>
                            </tr>
                            <?php endforeach;?>
                            <?php else: ?>
                            <tr>
                                <td class="text-center" colspan="13">- data kosong -</td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="9" style="border-bottom: none;border-top: none;border-right:none;">&nbsp;</td>
                                <td colspan="4" style="border-bottom: none;border-top: none;border-left:none;">
                                    Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm==''?'':strftime("%d %B %Y", strtotime($tgl_spm)); ?><br>
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
                                <td colspan="13" style="border-top: none;">&nbsp;</td>
                            </tr>
                    </tbody>
            </table>
    </div>
</div>
</div>
    
    
</div>

    
<!-- Left and right controls -->
<a class="left carousel-control" href="#myCarouselSPM" role="button" data-slide="prev" style="background-image: none;width: 25px;">
  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarouselSPM" role="button" data-slide="next" style="background-image: none;width: 25px;">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Next</span>
</a>

</div>
    
</div>
<br />
<form action="<?=site_url('rsa_up/cetak_spp')?>" id="form_spp" method="post" style="display: none"  >
    <input type="text" name="dtable" id="dtable" value="" />
</form>
            <div class="alert alert-warning" style="text-align:center">
                
                <?php if($doc_up == 'SPP-FINAL'){ ?>
                    <a href="#" data-toggle="modal" class="btn btn-warning" data-target="#myModalKonfirm" id="proses_spm_"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Proses SPM</a>
                    <a href="#spm" class="btn btn-warning" id="proses_spm" style="display: none"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Proses SPM</a>
                    <button type="button" class="btn btn-info" id="cetak-spm" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <!--<a href="#" class="btn btn-warning" id="tolak_spp" data-toggle="modal" data-target="#myModalTolakSPP"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></span> Tolak SPP</a>-->
                    <!--<a href="#" class="btn btn-success" id="down_2"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</a>-->
                <?php }else{ ?> 
                    <a href="#" class="btn btn-warning" disabled="disabled" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Proses SPM</a>
                    <!--<a href="#" class="btn btn-warning" disabled="disabled"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></span> Tolak SPP</a>-->
                    <!--<a href="#" class="btn btn-success" id="down_2"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</a>-->
                    <button type="button" class="btn btn-info" id="cetak-spm" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                <?php } ?>
                

                    

              </div>
          
      </div>
          
      </div>
  </div>

</div>

</div>
</div>


	</div>
      
	</div>

<img id="status_spp" style="display: none" src="<?php echo base_url(); ?>/assets/img/verified.png" width="150">

<!-- Modal -->
<div class="modal" id="myModalTolakSPP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <p>Alasan penolakan :</p>
        <p>
            <div class="form-group">
            <textarea class="form-control" id="ket" name="ket"> </textarea>
            </div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="tolak_spp_">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div class="modal" id="myModalLihatKet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
          <p><b>Mohon perhatian :</b></p>
        <p>
            <div class="form-group">
            <blockquote >
                <p class="text-danger">Sebelum melakukan proses SPM silahkan anda terlebih dahulu mencetak dan menandatangani form tsb. Terima kasih.</p>
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
