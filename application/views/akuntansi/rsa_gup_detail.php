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
    
    var id_cetak = 'div-cetak' ;
    
    var id_cetak_2 = 'div-cetak-2' ;
    
    var id_cetak_3 = 'div-cetak-lampiran-spj' ;
    
    var keluaran = [];
//    var pj_p_nilai_all = [];
    
    $('#myCarousel').on('slid.bs.carousel', function (e) {
  // do something…
        var id = e.relatedTarget.id;
//        console.log(id);
        if(id == 'a'){
            id_cetak = 'div-cetak' ;
        }else if(id == 'b'){
            id_cetak = 'div-cetak-f1a' ;
        }
    });
    
    $('#myCarouselSPM').on('slid.bs.carousel', function (e) {
  // do something…
        var id = e.relatedTarget.id;
//        console.log(id);
        if(id == 'e'){
            id_cetak_2 = 'div-cetak-2' ;
        }else if(id == 'f'){
            id_cetak_2 = 'div-cetak-f1a-2' ;
        }
    });
    
    $('#myCarouselLampiran').on('slid.bs.carousel', function (e) {
  // do something…
        var id = e.relatedTarget.id;
//        console.log(id);
        if(id == 'c'){
            id_cetak_3 = 'div-cetak-lampiran-spj' ;
        }else if(id == 'd'){
            id_cetak_3 = 'div-cetak-lampiran-rekapakun' ;
        }
    });
    
                
    $("#cetak-kuitansi").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
//                    console.log($("#" + id_cetak).html());
                    $("#kuitansi-print").printArea( options );
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
        
    $(document).on("click",'#btn-proses',function(){
        if($('input[name="kd_akun_kas"]:checked').length > 0){
            var kd_akun_kas = $("input[name='kd_akun_kas']:checked").val();
            var jumlah_bayar = string_to_angka($('#jumlah_bayar').html());
            var saldo_kas = string_to_angka($('#h_input_' + kd_akun_kas).val());
            
//            console.log(nominal + ' ' + saldo_kas);
            
            if(parseInt(saldo_kas) < parseInt(jumlah_bayar)){
                alert('Mohon maaf, saldo kas tidak mencukupi');
                    
            }else{
                if(confirm('Apakah anda yakin ?')){
                    
                    var data = 'proses=' + 'SPM-FINAL-KBUU' + '&nomor_trx=' + $('#nomor_trx_spm').html() + '&jenis=' + 'SPM' + '&tahun=' + '<?=$cur_tahun?>' +'&kd_unit=' + '<?=$kd_unit?>' + '&kd_akun_kas=' + kd_akun_kas + '&kredit=' + '<?php echo isset($detail_gup_spm['nom'])?$detail_gup_spm['nom']:''?>' + '&deskripsi=' + 'GUP <?=$alias?>' + '&nominal=' + jumlah_bayar + '&rel_kuitansi=' + encodeURIComponent('<?=$rel_kuitansi?>') ;
                    $.ajax({
                        type:"POST",
                        url :"<?=site_url('rsa_gup/proses_final_gup')?>",
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
            }
            
        }else{
            alert('Mohon pilih salah satu akun dahulu.');
        }
    });
    
    $(document).on("click",'#proses_spm_kpa',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPM-FINAL-KBUU' + '&kd_unit=' + '<?=$kd_unit?>';
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_up/proses_spm_up')?>",
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
    
    $(document).on("click",'#tolak_spm_kpa',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPM-DITOLAK-KBUU' + '&nomor_trx=' + $('#nomor_trx_spm').html() + '&jenis=' + 'SPM' + '&ket=' + $('#ket').val() + '&rel_kuitansi=' + encodeURIComponent('<?=$rel_kuitansi?>') + '&kd_unit=' + '<?=$kd_unit?>' + '&tahun=' + '<?=$cur_tahun?>';
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_gup/proses_spm_gup')?>",
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
    
 $('#myModalTolakSPMPPK').on('shown.bs.modal', function (e) {
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
    
       $(document).on("click",'#btn-lihat',function(){
        var rel = $(this).attr('rel');
        var tahun = $(this).attr('data-tahun');
        $.ajax({
            type:"POST",
            url :"<?=site_url("akuntansi/rsa_gup/get_data_kuitansi")?>",
            data:'id=' + rel + "&t="+tahun,
            success:function(data){
                    var obj = jQuery.parseJSON(data);
                    var kuitansi = obj.kuitansi ;
                    if($("#"+kuitansi.no_bukti).length != 0){$("#spm_tab").find("."+kuitansi.no_bukti).click(); return;} 
                    var template = $("#kuitansi-template").clone().attr("id", kuitansi.no_bukti);
                    template.attr("role", "tabpanel");
                    template.attr("class", "tab-pane");
                    template.removeAttr("style");
                    var kuitansi_detail = obj.kuitansi_detail ;
                    var kuitansi_detail_pajak = obj.kuitansi_detail_pajak ;
                    template.find('.kode_badge').text('GP');
                    template.find('.kuitansi_tahun').text(kuitansi.tahun);
                    template.find('.kuitansi_no_bukti').text(kuitansi.no_bukti);
                    template.find('.kuitansi_txt_akun').text(kuitansi.nama_akun);
                    template.find('.uraian').text(kuitansi.uraian);
                    template.find('.nm_subkomponen').text(kuitansi.nama_subkomponen);
                    template.find('.penerima_uang').text(kuitansi.penerima_uang);
                    template.find('.penerima_uang_nip').text(kuitansi.penerima_uang_nip);
                    var a = moment(kuitansi.tgl_kuitansi);
//                                    var b = moment(a).add('hours', 1);
//                                    var c = b.format("YYYY-MM-DD HH-mm-ss");
                    template.find('.tgl_kuitansi').text(a.locale("id").format("D MMMM YYYY"));//kuitansi.tgl_kuitansi);
                    template.find('.nmpppk').text(kuitansi.nmpppk);
                    template.find('.nippppk').text(kuitansi.nippppk);
                    template.find('.nmbendahara_kuitansi').text(kuitansi.nmbendahara);
                    template.find('.nipbendahara_kuitansi').text(kuitansi.nipbendahara);
                    if(kuitansi.nmpumk != ''){
                        template.find('.td_tglpumk').show();
                        template.find('.td_nmpumk').show();
                    }else{
                        template.find('.td_tglpumk').hide();
                        template.find('.td_nmpumk').hide();
                    }
                    template.find('.nmpumk').text(kuitansi.nmpumk);
                    template.find('.nippumk').text(kuitansi.nippumk);
                    template.find('.penerima_barang').text(kuitansi.penerima_barang);
                    template.find('.penerima_barang_nip').text(kuitansi.penerima_barang_nip);

                    template.find('.tr_isi').remove();
                    template.find('.tr_new').remove();
                    $('<tr class="tr_isi"><td colspan="11">&nbsp;</td></tr>').insertAfter(template.find('.before_tr_isi'));

                    var str_isi = '';
                    $.each(kuitansi_detail,function(i,v){ 
                        str_isi = str_isi + '<tr class="tr_new">';
                        str_isi = str_isi + '<td colspan="3">' + (i+1) + '. ' + v.deskripsi + '</td>' ; 
                        str_isi = str_isi + '<td style="text-align:center">' + v.volume + '</td>' ;
                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">' + v.satuan + '</td>' ;
                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;">' + angka_to_string(v.harga_satuan) + '</td>' ;
                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;" class="sub_tot_bruto_ sub_tot_bruto_'+i+'">' + angka_to_string(Math.round(v.bruto)) + '</td>' ;
                        var str_pajak = '' ;
                        var str_pajak_nom = '' ;
                        $.each(kuitansi_detail_pajak,function(ii,vv){
                            if(vv.id_kuitansi_detail == v.id_kuitansi_detail){
                                var jenis_pajak_ = vv.jenis_pajak ;
                                var jenis_pajak = jenis_pajak_.split("_").join(" ");
                                var dpp = vv.dpp == '0' ? '' : '(dpp)';
                                var str_99 = (vv.persen_pajak == '99')? '' : vv.persen_pajak + '% ' ;
                                str_pajak = str_pajak + jenis_pajak + ' ' + str_99 + dpp + '<br>' ;

                                str_pajak_nom = str_pajak_nom + '<span rel="'+ i +'" class="sub_tot_pajak_ sub_tot_pajak_'+i+'">'+ angka_to_string(vv.rupiah_pajak) +'</span><br>' ; 
                            }
                        });
                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">'+ str_pajak +'</td>' ; 
                        str_pajak_nom = (str_pajak_nom=='')?'<span rel="'+ i +'" class="sub_tot_pajak_ sub_tot_pajak_'+i+'">'+'0'+'</span>':str_pajak_nom;
                        str_isi = str_isi + '<td style="text-align:right;" >'+ str_pajak_nom +'</td>' ;  

                        str_isi = str_isi + '<td><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></td>' ;
                        str_isi = str_isi + '<td style="text-align:right" class="sub_tot_netto_ sub_tot_netto_'+i+'">0</td>' ; 

                            str_isi = str_isi + '</tr>' ;

                            });



                            template.find('.tr_isi').replaceWith(str_isi);

                            var sum_tot_bruto = 0 ;
                            template.find('.sub_tot_bruto_').each(function(){
                                sum_tot_bruto = parseInt(sum_tot_bruto) + parseInt(string_to_angka($(this).html()));
                            });
                            template.find('.sum_tot_bruto').html(angka_to_string(sum_tot_bruto));

                            var sub_tot_pajak = 0 ;
                            template.find('.sub_tot_pajak_').each(function(){
                                sub_tot_pajak = parseInt(sub_tot_pajak) + parseInt(string_to_angka($(this).text())) ;
                            });
                            template.find('.sum_tot_pajak').html(angka_to_string(sub_tot_pajak));

                            template.find('.sub_tot_pajak_').each(function(){
                                var prel = $(this).attr('rel');
                                var sub_tot_pajak__  = 0 ;
//                                                console.log(prel + ' ' + sub_tot_pajak__);
                                template.find('.sub_tot_pajak_' + prel).each(function(){
                                    sub_tot_pajak__ = parseInt(sub_tot_pajak__) + parseInt(string_to_angka($(this).text())) ;
                                });
                                var sub_tot_bruto_ = parseInt(string_to_angka(template.find('.sub_tot_bruto_' + prel ).text())) ;
                                template.find('.sub_tot_netto_' + prel).html(angka_to_string(parseInt(sub_tot_bruto_) - parseInt(sub_tot_pajak__)));
                            });

                            var sum_tot_netto = 0 ;
                            template.find('.sub_tot_netto_').each(function(){
                                sum_tot_netto = parseInt(sum_tot_netto) + parseInt(string_to_angka($(this).html()));
                            });

                            template.find('.sum_tot_netto').html(angka_to_string(sum_tot_netto));

                            template.find('.text_tot').html(terbilang(sum_tot_bruto));

                            template.find('.nbukti').val(kuitansi.no_bukti);
                            
                            $("#spm_tab-content").append(template);
                            $("#spm_tab").append('<li role="presentation"><a href="#'+ kuitansi.no_bukti +'" class="'+kuitansi.no_bukti+'" aria-controls="profile" role="tab" data-toggle="tab"><button class="close closeTab" type="button" >×</button>'+ kuitansi.no_bukti +'</a></li>');
                            $(".closeTab").click(function () {
                                //there are multiple elements which has .closeTab icon so close the tab whose close icon is clicked
                                var tabContentId = $(this).parent().attr("href");
                                if($(this).parent().parent().attr("class") == "active"){
                                    $(this).parent().parent().remove(); //remove li of tab
                                    $('#spm_tab a:last').tab('show'); // Select first tab
                                } else {
                                    $(this).parent().parent().remove(); //remove li of tab
                                }
                                
                                $(tabContentId).remove(); //remove respective tab content

                            });
                            $("#spm_tab a:last").click();
                            
                            //$('#myModalKuitansi').modal('show');
//                                        i++ ;
                        }

//                        location.reload();
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

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="spm_tab">
        <li role="presentation" class="active"><a href="#spp" aria-controls="home" role="tab" data-toggle="tab">SPP</a></li>
        <li role="presentation"><a href="#spm" aria-controls="profile" role="tab" data-toggle="tab">SPM</a></li>
        <li role="presentation"><a href="#lampiran" aria-controls="profile" role="tab" data-toggle="tab">LAMPIRAN</a></li>
        <li role="presentation"><a href="#kuitansi" aria-controls="profile" role="tab" data-toggle="tab">KUITANSI</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content" id="spm_tab-content">

      <div role="tabpanel" class="tab-pane" id="kuitansi">
          
          <div style="background-color: #EEE; padding: 10px;">
              	<div class="row" id="kuitansi-print">
			<div class="col-md-12 table-responsive">
                            <div style="background-color: #FFF;">
				<table class="table table-bordered table-striped table-hover small">
					<thead>
					<tr>
                                                <th class="text-center col-md-1" style="vertical-align: middle;">No</th>
                                                <th class="text-center col-md-2" style="vertical-align: middle;">Nomor</th>
						<th class="text-center col-md-2" style="vertical-align: middle;">Tanggal</th>
                                                <th class="text-center col-md-2" style="vertical-align: middle;">Uraian</th>
						<th class="text-center col-md-2" style="vertical-align: middle;">Pengeluaran</th>
						<th class="text-center col-md-1" style="vertical-align: middle;">&nbsp;</th>
                                                <!--<th class="text-center col-md-1" style="vertical-align: middle;">Status</th>-->
                                                <!--<th class="text-center col-md-1">Proses</th>-->
<!--                                                <th class="text-center col-md-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style="background-color: #f9ff83;"> 
                                                            <input type="checkbox" aria-label="" rel="" class="all_ck">
                                                        </span>
                                                    </div>
                                                </th>-->
					</tr>
					</thead>
					<tbody>
	<?php
		if(!empty($daftar_kuitansi)){
//                    echo '<pre>';var_dump($daftar_kuitansi);echo '</pre>';
            $tot_kuitansi = 0 ;
			foreach ($daftar_kuitansi as $key => $value) {
	?>
					<tr>
						<td class="text-center"><?php echo $key + 1; ?>.</td>
						<td class="text-center"><?php echo $value->no_bukti; ?></td>
                                                <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_kuitansi)); ?><br /></td>
						<td class=""><?php echo $value->uraian; ?></td>
						<td class="text-right">
                            <?=number_format($value->pengeluaran, 0, ",", ".")?>
                            <?php $tot_kuitansi = $tot_kuitansi + $value->pengeluaran ; ?>
                        </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                                <button  class="btn btn-default btn-sm" rel="<?php echo $value->id_kuitansi; ?>" id="btn-lihat" data-tahun="<?= $cur_tahun; ?>" ><i class="glyphicon glyphicon-search"></i></button>
							</div>
                                                </td>
					</tr>
                    
	<?php
			} 
    ?>
            <tr class="alert-warning" style="" >
                        <td colspan="4" class="text-right">
                            <b>Total :</b>
                        </td>
                        <td  class="text-right">
                            <b><?=number_format($tot_kuitansi, 0, ",", ".")?></b>
                        </td>
                        <td >
                        &nbsp;
                        </td>
                    </tr>
	<?php   
            }else{
	?>
					<tr>
						<td colspan="6" class="text-center alert-warning">
						Tidak ada data
						</td>
					</tr>
	<?php
		}
	?>
					<tr>
						<td colspan="6" >&nbsp;</td>
					</tr>
                                        </tbody>
				</table>
                                <button id="cetak-kuitansi">Cetak</button>
                            </div>
			</div>
		</div>
          </div>
          
          <br />
          
          <div class="alert alert-warning" style="text-align:center">
                
              &nbsp;
                

                    

              </div>
          
      </div>
      
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
                                            <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar_spp"><?php echo isset($detail_gup['nom'])?number_format($detail_gup['nom'], 0, ",", "."):''; ?></span>,-<br>
                                                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang_spp"><?php echo isset($detail_gup['terbilang'])?ucwords($detail_gup['terbilang']):''; ?></span></b>)</li>
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
                                <?php $empty_pengeluaran_lalu = false ; ?>
                                <?php if(!empty($data_akun_pengeluaran_lalu)): ?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php $empty_pengeluaran_lalu = true ; ?>
                                            <?php endif;?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif;?>
                                <?php if(!$empty_pengeluaran_lalu): ?> 
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style="padding-right: 10px;">
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style="padding-right: 10px;"><?php echo number_format(($jml_spm_lalu + $data->pengeluaran), 0, ",", "."); ?></td>
                                <td class="text-right" style="padding-right: 10px;"><?php echo number_format(($pagu_rkat - ($jml_spm_lalu + $data->pengeluaran)), 0, ",", "."); ?></td>
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
                            <td style="padding-left: 10px;"><b><?=$data->nama_subkomponen?></b></td>
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
      
      </div>

<div role="tabpanel" class="tab-pane" id="lampiran">
          <div style="background-color: #EEE; padding: 10px;">
            <div id="myCarouselLampiran" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner" role="listbox">
<div class="item active" id="c">
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
                                <?php $empty_pengeluaran_lalu = false ; ?>
                                <?php if(!empty($data_akun_pengeluaran_lalu)):?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php $empty_pengeluaran_lalu = true ; ?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php endif;?>
                                <?php if(!$empty_pengeluaran_lalu): ?> 
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style="padding-right: 10px;">
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style="padding-right: 10px;"><?php echo number_format(($jml_spm_lalu + $data->pengeluaran), 0, ",", "."); ?></td>
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
<a class="left carousel-control" href="#myCarouselLampiran" role="button" data-slide="prev" style="background-image: none;width: 25px;">
  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarouselLampiran" role="button" data-slide="next" style="background-image: none;width: 25px;">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Next</span>
</a>
                
            </div>
          </div>
          <br />
          
          
      </div>
<div role="tabpanel" class="tab-pane" id="spm">
    <div style="background-color: #EEE; padding: 10px;">
    <div id="myCarouselSPM" class="carousel slide" data-ride="carousel" data-interval="false">
    <div class="carousel-inner" role="listbox">
    <div class="item active" id="e">
    <div id="div-cetak-2">
        <table id="table_spp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
            <tbody>
                <tr>
                    <td colspan="5" style="text-align: right;font-size: 30px;padding: 10px;"><b>F2</b></td>
                </tr>
                
                <tr>
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
                <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar"><?php echo isset($detail_gup_spm['nom'])?number_format($detail_gup_spm['nom'], 0, ",", "."):''; ?></span>,-<br>
                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang"><?php echo isset($detail_gup_spm['terbilang'])?ucwords($detail_gup_spm['terbilang']):''; ?></span></b>)</li>
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
                <?php if(isset($detail_gup_spm['nom'])){ ?>
                <?php if($detail_gup_spm['nom'] >= 100000000){ ?>
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
                <span id="nmkbuu"><?php echo isset($detail_kuasa_buu->nm_lengkap)?$detail_kuasa_buu->nm_lengkap:''; ?></span><br>
                NIP. <span id="nipkbuu"><?php echo isset($detail_kuasa_buu->nomor_induk)?$detail_kuasa_buu->nomor_induk:'';?></span><br>
                </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="item" id="f">
<div id="div-cetak-f1a-2">
                <table id="table_f1a" class="table_lamp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                                <td colspan="7" style="text-align: right;font-size: 30px;padding: 10px;"><b>F2A</b></td>
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
                                <b>NO SPM : <?=$nomor_spm?></b>
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
                                <?php $empty_pengeluaran_lalu = false ; ?>
                                <?php if(!empty($data_akun_pengeluaran_lalu)): ?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php $empty_pengeluaran_lalu = true ; ?>
                                            <?php endif;?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif;?>
                                <?php if(!$empty_pengeluaran_lalu): ?> 
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style="padding-right: 10px;">
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style="padding-right: 10px;"><?php echo number_format(($jml_spm_lalu + $data->pengeluaran), 0, ",", "."); ?></td>
                                <td class="text-right" style="padding-right: 10px;"><?php echo number_format(($pagu_rkat - ($jml_spm_lalu + $data->pengeluaran)), 0, ",", "."); ?></td>
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
                        <?php $i = 1; ?>
                        <?php $sub_kegiatan = '' ; ?>
                        <?php if(!empty($data_akun_pengeluaran)): ?>
                        <?php // var_dump($data_akun_pengeluaran); die; ?>
                        <?php foreach($data_akun_pengeluaran as $data):?> 
                        <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                        <tr>
                            <td class="text-center" ><?=$i?></td>
                            <td style="padding-left: 10px;"><b><?=$data->nama_subkomponen?></b></td>
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
    </div>
      
</div>
</div>

<div id="kuitansi-template" style="display:none;">
      <div id="div-cetak-kuitansi">
      <table class="table_print kuitansi" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 800px;border: 1px solid #000;background-color: #FFF;" cellspacing="0px" border="0">
        <tr>
                    <td class="col-md-1">&nbsp;</td>
                    <td class="col-md-1">&nbsp;</td>
                    <td class="col-md-1">&nbsp;</td>
                    <td class="col-md-1">&nbsp;</td>
                    <td class="col-md-1">&nbsp;</td>
                    <td class="col-md-1">&nbsp;</td>
                    <td class="col-md-1">&nbsp;</td>
                    <td class="col-md-1">&nbsp;</td>
                    <td class="col-md-1">&nbsp;</td>
                    <td class="col-md-1">&nbsp;</td>
                    <td class="col-md-1">&nbsp;</td>
        </tr>
          <tr>
                        <td rowspan="3" style="text-align: center" colspan="2">
            <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
        </td>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>


                        <td colspan="2">Tahun Anggaran</td>
                        <td style="text-align: center">:</td>
                        <td colspan="2"><span class="kuitansi_tahun">0000</span></td>
                </tr>
                <tr>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>

                        <td colspan="2">Nomor Bukti</td>
                        <td style="text-align: center">:</td>
                        <td colspan="2" class="kuitansi_no_bukti">-</td>
                </tr>
                <tr class="tr_up">
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>

                        <td colspan="2">Anggaran</td>
                        <td style="text-align: center">:</td>
                        <td colspan="2" class="kuitansi_txt_akun">-</td>

    </tr>
    <tr>
                        <td colspan="11">
                            &nbsp;
        </td>
                </tr>
    <tr>
        <td colspan="11">
                            <h4 style="text-align: center"><b>KUITANSI / BUKTI PEMBAYARAN</b></h4>
        </td>
    </tr>
                <tr>
                        <td colspan="11">
                            &nbsp;
        </td>
                </tr>
    <tr class="tr_up">
        <td colspan="3">Sudah Diterima dari</td>
        <td>: </td>
                        <td colspan="7">Pejabat Pembuat Komitmen/ Pejabat Pelaksana dan Pengendali Kegiatan SUKPA <?=$unit_kerja?></td>
    </tr>
    <tr class="tr_up">
        <td colspan="3">Jumlah Uang</td>
        <td>: </td>
                        <td colspan="7"><b>Rp. <span class="sum_tot_bruto">0</span>,-</b></td>
    </tr>
    <tr class="tr_up">
        <td colspan="3">Terbilang</td>
        <td>: </td>
                        <td colspan="7"><b><span class="text_tot">-</span></b></td>
    </tr>
    <tr class="tr_up">
        <td colspan="3">Untuk Pembayaran</td>
        <td>: </td>
                        <td colspan="7"><span class="uraian">-</span></td>
    </tr>
    <tr class="tr_up">
        <td colspan="3">Sub Kegiatan</td>
        <td>: </td>
                        <td colspan="7"><span class="nm_subkomponen">-</span></td>
    </tr>
                <tr>
                        <td colspan="11">
                            &nbsp;
        </td>
                </tr>
                <tr class="before_tr_isi">
                    <td colspan="3"><b>Deskripsi</b></td>
                    <td style="text-align:center"><b>Kuantitas</b></td>
                    <td style="padding: 0 5px 0 5px;"><b>Satuan</b></td>
                    <td style="padding: 0 5px 0 5px;"><b>Harga@</b></td>
                    <td style="padding: 0 5px 0 5px;"><b>Bruto</b></td>
                    <td style="padding: 0 5px 0 5px;" colspan="2"><b>Pajak</b></td>
                    <td >&nbsp;</td>
                    <td ><b>Netto</b></td>
    </tr>
                <tr class="tr_isi">
                    <td colspan="11">&nbsp;</td>
    </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td ><b>Jumlah</b></td>
                    <td >&nbsp;</td>
                    <td style="text-align: right"><b><span class="sum_tot_bruto">0</span></b></td>
                    <td >&nbsp;</td>
                    <td style="text-align: right"><b><span class="sum_tot_pajak">0</span></b></td>
                    <td ><b><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></b></td>
                    <td style="text-align: right"><b><span class="sum_tot_netto">0</span></b></td>
    </tr>
                <tr>
                        <td colspan="11">
                            &nbsp;
        </td>
                </tr>
    <tr>
                    <td colspan="8">Setuju dibebankan pada mata anggaran berkenaan, <br />
                        a.n. Kuasa Pengguna Anggaran <br />
                        Pejabat Pelaksana dan Pengendali Kegiatan (PPPK)
                    </td>
                    <td colspan="3">
                        Semarang, <span class="tgl_kuitansi">-</span><br />
                        Penerima Uang
                    </td>
    </tr>
                <tr>
                        <td colspan="11">
                            <br>
                            <br>
                            <br>
                            <br>
        </td>
                </tr>
                <tr >
                    <td colspan="8" style="border-bottom: 1px solid #000"><span class="nmpppk">-</span><br>
                            NIP. <span class="nippppk">-</span></td>
                    <td colspan="3" style="border-bottom: 1px solid #000"><span class="edit_here penerima_uang">-</span><br />
                        NIP. <span class="edit_here penerima_uang_nip">-</span>
                    </td>
    </tr>
                <tr >
                    <td colspan="8">Setuju dibayar tgl : <br>
                        Bendahara Pengeluaran
                    </td>
                    <td colspan="3" ><span style="display: none" class="td_tglpumk">Lunas dibayar tgl : <br>
                            Pemegang Uang Muka Kerja</span>
                    </td>
                </tr>
                <tr>
                        <td colspan="11">
                            <br>
                            <br>
                            <br>
        </td>
                </tr>
                 <tr>
                     <td colspan="8"><span class="nmbendahara_kuitansi"></span><br>
                         NIP. <span class="nipbendahara_kuitansi"></span>
                    </td>
                    <td colspan="3" ><span style="display: none" class="td_nmpumk"><span class="nmpumk"></span><br>
                            NIP. <span class="nippumk"></span></span>
                    </td>
                </tr>
    <tr >
        <td colspan="11" style="border-top:1px solid #000">
        Barang/Pekerjaan tersebut telah diterima /diselesaikan  dengan lengkap dan baik.<br>
        Penerima Barang/jasa
        </td>
                </tr>
                <tr>
                        <td colspan="11">
                            <br>
                            <br>
                            <br>
        </td>
                </tr>
                <tr>
                    <td colspan="11" ><span class="penerima_barang">-</span><br />
                            NIP. <span class="penerima_barang_nip">-</span>
        </td>
    </tr>

</table>
      </div>
      </div> 

<!--
<div class="modal " id="myModalKuitansi" role="dialog" aria-labelledby="myModalKuitansiLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel">Kuitansi : <span id="kode_badge">-</span></h4>
          </div>
          <div class="modal-body" style="margin:0px;padding:15px;background-color: #EEE;">
              <div id="div-cetak-kuitansi">
              <table class="table_print" id="kuitansi" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 800px;border: 1px solid #000;background-color: #FFF;" cellspacing="0px" border="0">
                <tr>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                </tr>
                  <tr>
                                <td rowspan="3" style="text-align: center" colspan="2">
					<img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
				</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>


                                <td colspan="2">Tahun Anggaran</td>
                                <td style="text-align: center">:</td>
                                <td colspan="2"><span id="kuitansi_tahun">0000</span></td>
                        </tr>
                        <tr>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>

                                <td colspan="2">Nomor Bukti</td>
                                <td style="text-align: center">:</td>
                                <td colspan="2" id="kuitansi_no_bukti">-</td>
                        </tr>
                        <tr class="tr_up">
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>

                                <td colspan="2">Anggaran</td>
                                <td style="text-align: center">:</td>
                                <td colspan="2" id="kuitansi_txt_akun">-</td>

			</tr>
			<tr>
                                <td colspan="11">
                                    &nbsp;
				</td>
                        </tr>
			<tr>
				<td colspan="11">
                                    <h4 style="text-align: center"><b>KUITANSI / BUKTI PEMBAYARAN</b></h4>
				</td>
			</tr>
                        <tr>
                                <td colspan="11">
                                    &nbsp;
				</td>
                        </tr>
			<tr class="tr_up">
				<td colspan="3">Sudah Diterima dari</td>
				<td>: </td>
                                <td colspan="7">Pejabat Pembuat Komitmen/ Pejabat Pelaksana dan Pengendali Kegiatan SUKPA <?=$unit_kerja?></td>
			</tr>
			<tr class="tr_up">
				<td colspan="3">Jumlah Uang</td>
				<td>: </td>
                                <td colspan="7"><b>Rp. <span class="sum_tot_bruto">0</span>,-</b></td>
			</tr>
			<tr class="tr_up">
				<td colspan="3">Terbilang</td>
				<td>: </td>
                                <td colspan="7"><b><span class="text_tot">-</span></b></td>
			</tr>
			<tr class="tr_up">
				<td colspan="3">Untuk Pembayaran</td>
				<td>: </td>
                                <td colspan="7"><span id="uraian">-</span></td>
			</tr>
			<tr class="tr_up">
				<td colspan="3">Sub Kegiatan</td>
				<td>: </td>
                                <td colspan="7"><span id="nm_subkomponen">-</span></td>
			</tr>
                        <tr>
                                <td colspan="11">
                                    &nbsp;
				</td>
                        </tr>
                        <tr id="before_tr_isi">
                            <td colspan="3"><b>Deskripsi</b></td>
                            <td style="text-align:center"><b>Kuantitas</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Satuan</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Harga@</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Bruto</b></td>
                            <td style="padding: 0 5px 0 5px;" colspan="2"><b>Pajak</b></td>
                            <td >&nbsp;</td>
                            <td ><b>Netto</b></td>
			</tr>
                        <tr id="tr_isi">
                            <td colspan="11">&nbsp;</td>
			</tr>
                        <tr>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td ><b>Jumlah</b></td>
                            <td >&nbsp;</td>
                            <td style="text-align: right"><b><span class="sum_tot_bruto">0</span></b></td>
                            <td >&nbsp;</td>
                            <td style="text-align: right"><b><span class="sum_tot_pajak">0</span></b></td>
                            <td ><b><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></b></td>
                            <td style="text-align: right"><b><span class="sum_tot_netto">0</span></b></td>
			</tr>
                        <tr>
                                <td colspan="11">
                                    &nbsp;
				</td>
                        </tr>
			<tr>
                            <td colspan="8">Setuju dibebankan pada mata anggaran berkenaan, <br />
                                a.n. Kuasa Pengguna Anggaran <br />
                                Pejabat Pelaksana dan Pengendali Kegiatan (PPPK)
                            </td>
                            <td colspan="3">
                                Semarang, <span id="tgl_kuitansi">-</span><br />
                                Penerima Uang
                            </td>
			</tr>
                        <tr>
                                <td colspan="11">
                                    <br>
                                    <br>
                                    <br>
                                    <br>
				</td>
                        </tr>
                        <tr >
                            <td colspan="8" style="border-bottom: 1px solid #000"><span id="nmpppk">-</span><br>
                                    NIP. <span id="nippppk">-</span></td>
                            <td colspan="3" style="border-bottom: 1px solid #000"><span class="edit_here" id="penerima_uang">-</span><br />
                                NIP. <span class="edit_here" id="penerima_uang_nip">-</span>
                            </td>
			</tr>
                        <tr >
                            <td colspan="8">Setuju dibayar tgl : <br>
                                Bendahara Pengeluaran
                            </td>
                            <td colspan="3" ><span style="display: none" id="td_tglpumk">Lunas dibayar tgl : <br>
                                    Pemegang Uang Muka Kerja</span>
                            </td>
                        </tr>
                        <tr>
                                <td colspan="11">
                                    <br>
                                    <br>
                                    <br>
				</td>
                        </tr>
                         <tr>
                             <td colspan="8"><span id="nmbendahara_kuitansi"></span><br>
                                 NIP. <span id="nipbendahara_kuitansi"></span>
                            </td>
                            <td colspan="3" ><span style="display: none" id="td_nmpumk"><span id="nmpumk"></span><br>
                                    NIP. <span id="nippumk"></span></span>
                            </td>
                        </tr>
			<tr >
				<td colspan="11" style="border-top:1px solid #000">
				Barang/Pekerjaan tersebut telah diterima /diselesaikan  dengan lengkap dan baik.<br>
				Penerima Barang/jasa
				</td>
                        </tr>
                        <tr>
                                <td colspan="11">
                                    <br>
                                    <br>
                                    <br>
				</td>
                        </tr>
                        <tr>
                            <td colspan="11" ><span id="penerima_barang">-</span><br />
                                    NIP. <span id="penerima_barang_nip">-</span>
				</td>
			</tr>

		</table>
              </div>
              </div> 
          
            

          <div class="modal-footer">
            <button type="button" class="btn btn-info" id="cetak-kuitansi" rel="" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
          </div>
        </div>
    </div>
</div>-->
