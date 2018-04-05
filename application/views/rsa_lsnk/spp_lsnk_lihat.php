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

    var id_cetak_4 = 'div-cetak-lampiran-rekappajak' ;

    var id_xls_1 = 'table_spp' ;

    var id_xls_2 = 'table_spm' ;

    var id_xls_3 = 'table_spj' ;

    var id_xls_4 = 'table_rekappajak' ;
    
    var keluaran = [];
//    var pj_p_nilai_all = [];
    
    $('#myCarousel').on('slid.bs.carousel', function (e) {
  // do something…
        var id = e.relatedTarget.id;
//        console.log(id);
        if(id == 'a'){
            id_cetak = 'div-cetak' ;
            id_xls_1 = 'table_spp' ;
        }else if(id == 'b'){
            id_cetak = 'div-cetak-f1a' ;
            id_xls_1 = 'table_f1a' ;
        }
    });
    
    $('#myCarouselSPM').on('slid.bs.carousel', function (e) {
  // do something…
        var id = e.relatedTarget.id;
//        console.log(id);
        if(id == 'e'){
            id_cetak_2 = 'div-cetak-2' ;
            id_xls_2 = 'table_spm' ;
        }else if(id == 'f'){
            id_cetak_2 = 'div-cetak-f1a-2' ;
            id_xls_2 = 'table_f2a' ;
        }
    });
    
    $('#myCarouselLampiran').on('slid.bs.carousel', function (e) {
  // do something…
        var id = e.relatedTarget.id;
//        console.log(id);
        if(id == 'c'){
            id_cetak_3 = 'div-cetak-lampiran-spj' ;
            id_xls_3 = 'table_spj' ;
        }else if(id == 'd'){
            id_cetak_3 = 'div-cetak-lampiran-rekapakun' ;
            id_xls_3 = 'table_rekapakun' ;
        }
    });
    
    
    $("#cetak").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
//                    console.log($("#" + id_cetak).html());
                    $("#" + id_cetak).printArea( options );
                });
                
    $("#cetak-spm").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
//                    console.log($("#" + id_cetak_2).html());
                    $("#" + id_cetak_2).printArea( options );
                });
    
    $("#cetak-lampiran").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
//                    console.log($("#" + id_cetak).html());
                    $("#" + id_cetak_3).printArea( options );
                });
                
    $("#cetak-kuitansi").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
//                    console.log($("#" + id_cetak).html());
                    $("#div-cetak-kuitansi").printArea( options );
                });

    $("#cetak-showpengembalian").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
//                    console.log($("#" + id_cetak).html());
                    $("#div-cetak-showpengembalian").printArea( options );
                });

    $("#cetak-rekappajak").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
//                    console.log($("#" + id_cetak).html());
                    $("#" + id_cetak_4).printArea( options );
                });

    $("#xls_spp").click(function(){
        var uri = $("#" + id_xls_1).excelexportjs({
                                    containerid: id_xls_1
                                    , datatype: "table"
                                    , returnUri: true
                                });


        var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");
        
        saveAs(blob, 'download_rsa_excel.xls');

    });

    $("#xls_spm").click(function(){
        var uri = $("#" + id_xls_2).excelexportjs({
                                    containerid: id_xls_2
                                    , datatype: "table"
                                    , returnUri: true
                                });


        var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");
        
        saveAs(blob, 'download_rsa_excel.xls');

    });


    $("#xls_lamp").click(function(){
        var uri = $("#" + id_xls_3).excelexportjs({
                                    containerid: id_xls_3
                                    , datatype: "table"
                                    , returnUri: true
                                });


        var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");
        
        saveAs(blob, 'download_rsa_excel.xls');

    });

    $("#xls_rekappajak").click(function(){
        var uri = $("#" + id_xls_3).excelexportjs({
                                    containerid: id_xls_4
                                    , datatype: "table"
                                    , returnUri: true
                                });


        var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");
        
        saveAs(blob, 'download_rsa_excel.xls');

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
    
    $(document).on("click",'#proses_spm_ppk',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPM-DRAFT-KPA' + '&nomor_trx=' + $('#nomor_trx_spm').html() + '&jenis=' + 'SPM' ;
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_tup/proses_spm_tup')?>",
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
    
    $(document).on("click",'#tolak_spm_ppk',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPM-DITOLAK-KPA' + '&nomor_trx=' + $('#nomor_trx_spm').html() + '&jenis=' + 'SPM' + '&ket=' + $('#ket').val() + '&rel_kuitansi=' + encodeURIComponent('<?=$rel_kuitansi?>') ;
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_tup/proses_spm_tup')?>",
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
    
    $(document).on("click",'.btn-lihat',function(){
                        var rel = $(this).attr('rel');
                        $.ajax({
                            type:"POST",
                            url :"<?=site_url("kuitansi/get_data_kuitansi")?>",
                            data:'id=' + rel,
                            success:function(data){
//                                    console.log(data);
                                    var obj = jQuery.parseJSON(data);
                                    var kuitansi = obj.kuitansi ;
                                    var kuitansi_detail = obj.kuitansi_detail ;
                                    var kuitansi_detail_pajak = obj.kuitansi_detail_pajak ;
                                    $('#kode_badge').text(kuitansi.jenis);
                                    $('#kuitansi_tahun').text(kuitansi.tahun);
                                    $('#kuitansi_no_bukti').text(kuitansi.no_bukti);
                                    $('#kuitansi_txt_akun').text(kuitansi.nama_akun);
                                    $('#uraian').text(kuitansi.uraian);
                                    $('#nm_subkomponen').text(kuitansi.nama_subkomponen);
                                    $('#penerima_uang').text(kuitansi.penerima_uang);
                                    // var s = kuitansi.penerima_uang_nip ;
                                    // console.log(s.trim());
                                    // if((s.trim() != '-')&&(s.trim() != '.')){
                                        // console.log('t');
                                        $('#penerima_uang_nip').text(kuitansi.penerima_uang_nip);
                                    // }
                                    // else{
                                        // console.log('f');
                                        // $('#snip').hide();
                                    // }
                                    var a = moment(kuitansi.tgl_kuitansi);
//                                    var b = moment(a).add('hours', 1);
//                                    var c = b.format("YYYY-MM-DD HH-mm-ss");
                                    $('#tgl_kuitansi').text(a.locale("id").format("D MMMM YYYY"));//kuitansi.tgl_kuitansi);
                                    $('#nmpppk').text(kuitansi.nmpppk);
                                    $('#nippppk').text(kuitansi.nippppk);
                                    $('#nmbendahara_kuitansi').text(kuitansi.nmbendahara);
                                    $('#nipbendahara_kuitansi').text(kuitansi.nipbendahara);
                                    if(kuitansi.nmpumk != ''){
                                        $('#td_tglpumk').show();
                                        $('#td_nmpumk').show();
                                    }else{
                                        $('#td_tglpumk').hide();
                                        $('#td_nmpumk').hide();
                                    }
                                    $('#nmpumk').text(kuitansi.nmpumk);
                                    $('#nippumk').text(kuitansi.nippumk);
                                    $('#penerima_barang').text(kuitansi.penerima_barang);
                                    $('#penerima_barang_nip').text(kuitansi.penerima_barang_nip);
                                    
                                    $('#tr_isi').remove();
                                    $('.tr_new').remove();
                                    $('<tr id="tr_isi"><td colspan="11">&nbsp;</td></tr>').insertAfter($('#before_tr_isi'));
                                    
                                    var str_isi = '';
                                    $.each(kuitansi_detail,function(i,v){ 

                                        str_isi = str_isi + '<tr class="tr_new">';
                                        str_isi = str_isi + '<td colspan="3">' + (i+1) + '. ' + v.deskripsi + '</td>' ; 
                                        str_isi = str_isi + '<td style="text-align:center">' + (v.volume * 1) + '</td>' ;
                                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">' + v.satuan + '</td>' ;
                                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;">' + angka_to_string(v.harga_satuan) + '</td>' ;
                                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;" class="sub_tot_bruto_' + i +'">' + angka_to_string((v.bruto * 1)) + '</td>' ;
                                        var str_pajak = '' ;
                                        var str_pajak_nom = '' ;
                                        $.each(kuitansi_detail_pajak,function(ii,vv){
                                            if(vv.id_kuitansi_detail == v.id_kuitansi_detail){
                                                var jenis_pajak_ = vv.jenis_pajak ;
                                                var jenis_pajak = jenis_pajak_.split("_").join(" ");
                                                var dpp = vv.dpp == '0' ? '' : '(dpp)';
                                                // console.log(vv.persen_pajak);
                                                var str_99 = (vv.persen_pajak == '99')||(vv.persen_pajak == '98')||(vv.persen_pajak == '97')||(vv.persen_pajak == '96')||(vv.persen_pajak == '95')||(vv.persen_pajak == '94')||(vv.persen_pajak == '89')? '' : vv.persen_pajak + '% ' ;
                                                str_pajak = str_pajak + jenis_pajak + ' ' + str_99 + dpp + '<br>' ;
                                                
                                                str_pajak_nom = str_pajak_nom + '<span rel="'+ i +'" class="sub_tot_pajak_'+ i +'">'+ angka_to_string(vv.rupiah_pajak) +'</span><br>' ; 
                                            }
                                        });
                                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">'+ str_pajak +'</td>' ; 
                                        str_pajak_nom = (str_pajak_nom=='')?'<span rel="'+ i +'" class="sub_tot_pajak_'+ i +'">'+'0'+'</span>':str_pajak_nom;
                                        str_isi = str_isi + '<td style="text-align:right;" >'+ str_pajak_nom +'</td>' ;  
                                        
                                        str_isi = str_isi + '<td><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></td>' ;
                                        str_isi = str_isi + '<td style="text-align:right" rel="'+ i +'" class="sub_tot_netto_'+ i +'">0</td>' ; 
                                        
                                            str_isi = str_isi + '</tr>' ;

                                            });

                                            
                                            
                                            $('#tr_isi').replaceWith(str_isi);
                                            
                                            var sum_tot_bruto = 0 ;
                                            $('[class^="sub_tot_bruto_"').each(function(){
                                                sum_tot_bruto = sum_tot_bruto + parseInt(string_to_angka($(this).html()));
                                            });
                                            $('.sum_tot_bruto').html(angka_to_string(sum_tot_bruto));
                                            
                                            var sub_tot_pajak = 0 ;
                                            $('[class^="sub_tot_pajak_"]').each(function(){
                                                sub_tot_pajak = sub_tot_pajak + parseInt(string_to_angka($(this).text())) ;
                                            });
                                            $('.sum_tot_pajak').html(angka_to_string(sub_tot_pajak));
                                            
                                            $('[class^="sub_tot_netto_"]').each(function(){
                                                var prel = $(this).attr('rel');
                                                var sub_tot_pajak__  = 0 ;
//                                                console.log(prel + ' ' + sub_tot_pajak__);
                                                $('.sub_tot_pajak_' + prel).each(function(){
                                                    sub_tot_pajak__ = sub_tot_pajak__ + parseInt(string_to_angka($(this).text())) ;
                                                });
                                                var sub_tot_bruto_ = parseInt(string_to_angka($('.sub_tot_bruto_' + prel ).text())) ;
                                                $(this).html(angka_to_string(sub_tot_bruto_ - sub_tot_pajak__));
                                            });

                                            var sum_tot_netto = 0 ;
                                            $('[class^="sub_tot_netto_"').each(function(){
                                                sum_tot_netto = sum_tot_netto + parseInt(string_to_angka($(this).html()));
                                            });

                                            $('.sum_tot_netto').html(angka_to_string(sum_tot_netto));

                                            $('.text_tot').html(terbilang(sum_tot_bruto));
                                            
                                            $('#nbukti').val(kuitansi.no_bukti);
                                            $('#myModalKuitansi').modal('show');
    //                                        i++ ;
                                        }

            //                        location.reload();
                        });
            
                        
                    });
    
    $(document).on("click",'.btn-lihat-pengembalian',function(){

                        var rel = $(this).attr('rel');
                        $.ajax({
                            type:"POST",
                            url :"<?=site_url("kuitansi/get_data_kuitansi_pengembalian")?>",
                            data:'id=' + rel,
                            success:function(data){
                                   // console.log(data);
                                    var obj = jQuery.parseJSON(data);
                                    var kuitansi = obj.kuitansi ;
                                    var kuitansi_detail = obj.kuitansi_detail ;
                                    var kuitansi_detail_pajak = obj.kuitansi_detail_pajak ;
                                    $('#kode_badge_showpengembalian').text(kuitansi.jenis);
                                    $('#kuitansi_tahun_showpengembalian').text(kuitansi.tahun);
                                    $('#kuitansi_no_bukti_showpengembalian').text(kuitansi.no_bukti);
                                    $('#kuitansi_txt_akun_showpengembalian').text(kuitansi.nama_akun);
                                    $('#uraian_showpengembalian').text(kuitansi.uraian);
                                    // $('#nm_subkomponen_showpengembalian').text(kuitansi.nama_subkomponen);
                                    $('#penerima_uang_showpengembalian').text(kuitansi.penerima_uang);
                                    // var s = kuitansi.penerima_uang_nip ;
                                    // console.log(s.trim());
                                    // if((s.trim() != '-')&&(s.trim() != '.')){
                                        // console.log('t');
                                        $('#penerima_uang_nip_showpengembalian').text(kuitansi.penerima_uang_nip);
                                    // }
                                    // else{
                                        // console.log('f');
                                        // $('#snip').hide();
                                    // }
                                    var a = moment(kuitansi.tgl_kuitansi);
//                                    var b = moment(a).add('hours', 1);
//                                    var c = b.format("YYYY-MM-DD HH-mm-ss");
                                    $('#tgl_kuitansi_showpengembalian').text(a.locale("id").format("D MMMM YYYY"));//kuitansi.tgl_kuitansi);
                                    $('#nmpppk_showpengembalian').text(kuitansi.nmpppk);
                                    $('#nippppk_showpengembalian').text(kuitansi.nippppk);
                                    $('#nmbendahara_showpengembalian').text(kuitansi.nmbendahara);
                                    $('#nipbendahara_showpengembalian').text(kuitansi.nipbendahara);
                                    if(kuitansi.nmpumk != ''){
                                        $('#td_tglpumk_showpengembalian').show();
                                        $('#td_nmpumk_showpengembalian').show();
                                    }else{
                                        $('#td_tglpumk_showpengembalian').hide();
                                        $('#td_nmpumk_showpengembalian').hide();
                                    }
                                    $('#nmpumk_showpengembalian').text(kuitansi.nmpumk);
                                    $('#nippumk_showpengembalian').text(kuitansi.nippumk);
                                    $('#penerima_barang_showpengembalian').text(kuitansi.penerima_barang);
                                    $('#penerima_barang_nip_showpengembalian').text(kuitansi.penerima_barang_nip);
                                    
                                    $('#tr_isi_showpengembalian').remove();
                                    $('.tr_new').remove();
                                    $('<tr id="tr_isi_showpengembalian"><td colspan="11">&nbsp;</td></tr>').insertAfter($('#before_tr_isi_showpengembalian'));
                                    
                                    var str_isi = '';
                                    $.each(kuitansi_detail,function(i,v){ 

                                        str_isi = str_isi + '<tr class="tr_new">';
                                        str_isi = str_isi + '<td colspan="3">' + (i+1) + '. ' + v.deskripsi + '</td>' ; 
                                        str_isi = str_isi + '<td style="text-align:center">' + (v.volume * 1) + '</td>' ;
                                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">' + v.satuan + '</td>' ;
                                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;">' + angka_to_string(v.harga_satuan) + '</td>' ;
                                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;" class="sub_tot_bruto_' + i +'">' + angka_to_string((v.bruto * 1)) + '</td>' ;
                                        var str_pajak = '' ;
                                        var str_pajak_nom = '' ;
                                        $.each(kuitansi_detail_pajak,function(ii,vv){
                                            if(vv.id_kuitansi_detail == v.id_kuitansi_detail){
                                                var jenis_pajak_ = vv.jenis_pajak ;
                                                var jenis_pajak = jenis_pajak_.split("_").join(" ");
                                                var dpp = vv.dpp == '0' ? '' : '(dpp)';
                                                // console.log(vv.persen_pajak);
                                                var str_99 = (vv.persen_pajak == '99')||(vv.persen_pajak == '98')||(vv.persen_pajak == '97')||(vv.persen_pajak == '96')||(vv.persen_pajak == '95')||(vv.persen_pajak == '94')||(vv.persen_pajak == '89')? '' : vv.persen_pajak + '% ' ;
                                                str_pajak = str_pajak + jenis_pajak + ' ' + str_99 + dpp + '<br>' ;
                                                
                                                str_pajak_nom = str_pajak_nom + '<span rel="'+ i +'" class="sub_tot_pajak_'+ i +'">'+ angka_to_string(vv.rupiah_pajak) +'</span><br>' ; 
                                            }
                                        });
                                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">'+ str_pajak +'</td>' ; 
                                        str_pajak_nom = (str_pajak_nom=='')?'<span rel="'+ i +'" class="sub_tot_pajak_'+ i +'">'+'0'+'</span>':str_pajak_nom;
                                        str_isi = str_isi + '<td style="text-align:right;" >'+ str_pajak_nom +'</td>' ;  
                                        
                                        str_isi = str_isi + '<td><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></td>' ;
                                        str_isi = str_isi + '<td style="text-align:right" rel="'+ i +'" class="sub_tot_netto_'+ i +'">0</td>' ; 
                                        
                                            str_isi = str_isi + '</tr>' ;

                                            });

                                            // console.log(str_isi);
                                            
                                            $('#tr_isi_showpengembalian').replaceWith(str_isi);
                                            
                                            var sum_tot_bruto = 0 ;
                                            $('[class^="sub_tot_bruto_"').each(function(){
                                                sum_tot_bruto = sum_tot_bruto + parseInt(string_to_angka($(this).html()));
                                            });
                                            $('.sum_tot_bruto_showpengembalian').html(angka_to_string(sum_tot_bruto));
                                            
                                            var sub_tot_pajak = 0 ;
                                            $('[class^="sub_tot_pajak_"]').each(function(){
                                                sub_tot_pajak = sub_tot_pajak + parseInt(string_to_angka($(this).text())) ;
                                            });
                                            $('.sum_tot_pajak_showpengembalian').html(angka_to_string(sub_tot_pajak));
                                            
                                            $('[class^="sub_tot_netto_"]').each(function(){
                                                var prel = $(this).attr('rel');
                                                var sub_tot_pajak__  = 0 ;
//                                                console.log(prel + ' ' + sub_tot_pajak__);
                                                $('.sub_tot_pajak_' + prel).each(function(){
                                                    sub_tot_pajak__ = sub_tot_pajak__ + parseInt(string_to_angka($(this).text())) ;
                                                });
                                                var sub_tot_bruto_ = parseInt(string_to_angka($('.sub_tot_bruto_' + prel ).text())) ;
                                                $(this).html(angka_to_string(sub_tot_bruto_ - sub_tot_pajak__));
                                            });

                                            var sum_tot_netto = 0 ;
                                            $('[class^="sub_tot_netto_"').each(function(){
                                                sum_tot_netto = sum_tot_netto + parseInt(string_to_angka($(this).html()));
                                            });

                                            $('.sum_tot_netto_showpengembalian').html(angka_to_string(sum_tot_netto));

                                            $('.text_tot_showpengembalian').html(terbilang(sum_tot_bruto));
                                            
                                            $('#nbukti_showpengembalian').val(kuitansi.no_bukti);
                                            $('#myModalKuitansiShowPengembalian').modal('show');
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
                        
<?php if($doc_lsnk == ''){ $stts_bendahara = 'active'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> belum diusulkan oleh bendahara.</div>
    <?php }elseif($doc_lsnk == 'SPP-DRAFT'){ $stts_bendahara = 'done'; $stts_ppk = 'active'; ?>
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >PPK SUKPA</span></b> .</div>
    <?php }elseif($doc_lsnk == 'SPP-DITOLAK'){ $stts_bendahara = 'done'; $stts_ppk = 'tolak'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >PPK SUKPA</span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_lsnk == 'SPP-FINAL'){ $stts_bendahara = 'done';  $stts_ppk = 'done'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah diterima oleh <b><span class="text-danger" >PPK SUKPA</span></b> .</div>
    <?php }elseif($doc_lsnk == 'SPM-DRAFT-PPK'){ $stts_bendahara = 'done'; $stts_ppk = 'done';  $stts_kpa = 'active'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KPA </span></b> .</div>
    <?php }elseif($doc_lsnk == 'SPM-DRAFT-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'active';  ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >VERIFIKATOR </span></b> .</div>
    <?php }elseif($doc_lsnk == 'SPM-DITOLAK-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'tolak' ; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KPA </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_lsnk == 'SPM-FINAL-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'active' ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc_lsnk == 'SPM-DITOLAK-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'tolak'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >VERIFIKATOR </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_lsnk == 'SPM-FINAL-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done'; ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah disetujui oleh <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc_lsnk == 'SPM-DITOLAK-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'tolak'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KUASA BUU </span></b> <b>[ <a href="#" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_lsnk == 'SPM-FINAL-BUU'){$stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done'; $stts_buu = 'done';  ?> 
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah difinalisasi oleh <b><span class="text-danger" >BUU </span></b> .</div>
    <?php }elseif($doc_lsnk == 'SPM-DITOLAK-BUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done'; $stts_buu = 'tolak'; ?>   
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

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="spm_tab">
        <li role="presentation" class="active"><a href="#spp" aria-controls="home" role="tab" data-toggle="tab">SPP</a></li>
        <li role="presentation"><a href="#lampiran" aria-controls="profile" role="tab" data-toggle="tab">LAMPIRAN</a></li>
        <li role="presentation"><a href="#kuitansi" aria-controls="profile" role="tab" data-toggle="tab">KUITANSI</a></li>
        <li role="presentation"><a href="#rekappajak" aria-controls="profile" role="tab" data-toggle="tab">REKAP PAJAK</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="spp">
          
          <div style="background-color: #EEE; padding: 10px;">
<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
<ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active">1</li>
        <li data-target="#myCarousel" data-slide-to="1">2</li>
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
                                    <td style="border-left: none;border-top: none;border-bottom: none;"><b>JENIS : LS-NON-KONTRAK</b></td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="2" style="border-right: none;border-top:none;"><b>Tanggal  : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); ?></b></td>
                                    <td style="text-align: center;border-left: none;border-right: none;border-top:none;" colspan="2" >&nbsp;</td>
                                                                                                                          <td style="border-left: none;border-top:none;"><b>Nomor : <span id="nomor_trx"><?=$nomor_spp?></span><br><span style="<?=(($alias_spp!='-')&&(!empty($alias_spp)))?'':'display:none'?>" id="alias_spp_text">( <?=isset($alias_spp)?$alias_spp:''?> )</span></b></td>
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
                                            <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar_spp" style='mso-number-format:"\@";'><?php echo isset($detail_lsnk['nom'])?number_format($detail_lsnk['nom'], 0, ",", "."):''; ?></span>,-<br>
                                                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang_spp"><?php echo isset($detail_lsnk['terbilang'])?ucwords($detail_lsnk['terbilang']):''; ?></span></b>)</li>
                                                

                                                <li>Untuk pekerjaan : <span id="untuk_bayar"><?=isset($detail_pic->untuk_bayar)?$detail_pic->untuk_bayar:'-'?></span></li>
                                                <li>Nama pihak ketiga : <span id="penerima"><?=isset($detail_pic->penerima)?$detail_pic->penerima:'-'?></span></li>
                                                <li>Alamat : <span id="alamat"><?=isset($detail_pic->alamat_penerima)?$detail_pic->alamat_penerima:'-'?></span></li>
                                                <li>Nama Bank : <span id="nmbank"><?=isset($detail_pic->nama_bank_penerima)?$detail_pic->nama_bank_penerima:'-'?></span></li>
                                                <li>Nama Rekening Bank : <span id="nmrekening"><?=isset($detail_pic->nama_rek_penerima)?$detail_pic->nama_rek_penerima:'-'?></span></li>
                                                <li>No. Rekening Bank : <span id="rekening"><?=isset($detail_pic->no_rek_penerima)?$detail_pic->no_rek_penerima:'-'?></span></li>
                                                <li>No. NPWP : <span id="npwp"><?=isset($detail_pic->npwp_penerima)?$detail_pic->npwp_penerima:'-'?></span></li>
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
                                                                                    // if($data->jenis == 'PPN'){
                                                                                    //         echo 'Pajak Pertambahan Nilai';
                                                                                    // }elseif($data->jenis == 'PPh'){
                                                                                    //         echo 'Pajak Penghasilan';
                                                                                    // }else{
                                                                                    //         echo 'Lainnya';
                                                                                    // }
                                                                                    echo $data->jenis;
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
                            <td colspan="7" style="text-align: center;border-bottom: none;height: 72px;">
                                <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
                            </td>
                            </tr>
                            <tr >
                            <td colspan="7" style="text-align: center;border-bottom: none;">
                                <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                <h5><b>RINCIAN SURAT PERMINTAAN PEMBAYARAN LS-NON-KONTRAK</b></h5>
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
                
                <?php if($doc_lsnk == 'SPP-DRAFT'){ ?>
                    <!--<a href="#" class="btn btn-warning" id="proses_spp"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Setujui SPP</a>-->
                    <!--<a href="#" class="btn btn-warning" id="tolak_spp" data-toggle="modal" data-target="#myModalTolakSPP"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tolak SPP</a>-->
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <button type="button" class="btn btn-default" id="xls_spp" rel=""><span class="fa fa-file-excel-o" aria-hidden="true"></span> Unduh .xls</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</a>-->
                <?php }else{ ?> 
                    <!--<a href="#" class="btn btn-warning" disabled="disabled" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Setujui SPP</a>-->
                    <!--<a href="#" class="btn btn-warning" disabled="disabled"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tolak SPP</a>-->
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <button type="button" class="btn btn-default" id="xls_spp" rel=""><span class="fa fa-file-excel-o" aria-hidden="true"></span> Unduh .xls</button>
                    <!--<a href="#" class="btn btn-success" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</a>-->
                <?php } ?>
                

                    

              </div>
          
      </div>
      
    <div role="tabpanel" class="tab-pane" id="lampiran">
          <div style="background-color: #EEE; padding: 10px;">
            <div id="myCarouselLampiran" class="carousel slide" data-ride="carousel" data-interval="false">
            <ol class="carousel-indicators">
        <li data-target="#myCarouselLampiran" data-slide-to="0" class="active">1</li>
        <li data-target="#myCarouselLampiran" data-slide-to="1">2</li>
      </ol>
                <div class="carousel-inner" role="listbox">
<div class="item active" id="c">
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
                                    <h5><b>SURAT PERTANGGUNGJAWABAN LS NON KONTRAK</b></h5>
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
                                <td class="text-center">SPJ LSNK s.d BULAN LALU<br>( Rp )</td>
                                <td class="text-center">SPJ LSNK BULAN INI<br>( Rp )</td>
                                <td class="text-center">SPJ LSNK s.d BULAN INI<br>( Rp )</td>
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
                                                                                    // if($data->jenis == 'PPN'){
                                                                                    //         echo 'Pajak Pertambahan Nilai';
                                                                                    // }elseif($data->jenis == 'PPh'){
                                                                                    //         echo 'Pajak Penghasilan';
                                                                                    // }else{
                                                                                    //         echo 'Lainnya';
                                                                                    // }
                                                                                    echo $data->jenis;
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
          <div class="alert alert-warning" style="text-align:center">
                
                    <button type="button" class="btn btn-info" id="cetak-lampiran" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <button type="button" class="btn btn-default" id="xls_lamp" rel=""><span class="fa fa-file-excel-o" aria-hidden="true"></span> Unduh .xls</button>
                    
              </div>
          
      </div>
      
      <div role="tabpanel" class="tab-pane" id="kuitansi">
          
          <div style="background-color: #EEE; padding: 10px;">
              	<div class="row">
            <div class="col-md-12 table-responsive">
                            <div style="background-color: #FFF;">
                <table class="table table-bordered table-striped table-hover small">
                    <thead>
                    <tr>
                        <th colspan="6" class="text-center alert-danger">DAFTAR KUITANSI PENGEMBALIAN</th>
                    </tr>
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
        if(!empty($daftar_kuitansi_pengembalian)){
//                    echo '<pre>';var_dump($daftar_kuitansi);echo '</pre>';
            $tot_kuitansi = 0 ;
            foreach ($daftar_kuitansi_pengembalian as $key => $value) {
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
                                                                <button  class="btn btn-default btn-sm btn-lihat-pengembalian" rel="<?php echo $value->id_kuitansi; ?>" ><i class="glyphicon glyphicon-search"></i></button>
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
                            </div>
            </div>
			<div class="col-md-12 table-responsive">
                            <div style="background-color: #FFF;">
				<table class="table table-bordered table-striped table-hover small">
					<thead>
                    <tr>
                        <th colspan="6" class="text-center alert-success">DAFTAR KUITANSI PEMBAYARAN</th>
                    </tr>
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
                                                                <button  class="btn btn-default btn-sm btn-lihat" rel="<?php echo $value->id_kuitansi; ?>" ><i class="glyphicon glyphicon-search"></i></button>
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
                            </div>
			</div>
		</div>
          </div>
          
          <br />
          
          <div class="alert alert-warning" style="text-align:center">
                
              &nbsp;
                

                    

              </div>
          
      </div>

      <div role="tabpanel" class="tab-pane" id="rekappajak">
          
          <div style="background-color: #EEE; padding: 10px;">

           <!-- -->                 
        <div class="free dragscroll" style="overflow-x: scroll;width: 900px;margin: 0 auto;cursor: pointer;">
        <div id="div-cetak-lampiran-rekappajak">
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

                                <td class="text-right" style='vertical-align: top;padding-right: 10px;mso-number-format:"\@";'><?=number_format($data_rekap_bruto[$data_pajak][$i]->jml_bruto, 0, ",", ".")?><?php // var_dump(); ?></td>

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
            <!-- -->
                            </div>

          
          <br />
          
          <div class="alert alert-warning" style="text-align:center">
                
              <button type="button" class="btn btn-info" id="cetak-rekappajak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <button type="button" class="btn btn-default" id="xls_rekappajak" rel=""><span class="fa fa-file-excel-o" aria-hidden="true"></span> Unduh .xls</button>
                

                    

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
<div class="modal" id="myModalTolakSPMPPK" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
        <button type="button" class="btn btn-primary" id="tolak_spm_ppk">Submit</button>
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

<div class="modal " id="myModalKuitansiShowPengembalian" role="dialog" aria-labelledby="myModalKuitansiLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabelShowPengembalian">Kuitansi : <span id="kode_badge_showpengembalian">-</span></h4>
          </div>
          <div class="modal-body" style="margin:0px;padding:15px;background-color: #EEE;">
              <div id="div-cetak-showpengembalian">
              <table class="table_print" id="kuitansi_showpengembalian" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 800px;border: 1px solid #000;background-color: #FFF;" cellspacing="0px" border="0">
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
                                <td colspan="2"><span id="kuitansi_tahun_showpengembalian">0000</span></td>
                        </tr>
                        <tr>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>

                                <td colspan="2">Nomor Bukti</td>
                                <td style="text-align: center">:</td>
                                <td colspan="2" id="kuitansi_no_bukti_showpengembalian">-</td>
                        </tr>
                        <tr class="tr_up">
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>

                                <td colspan="2">Anggaran</td>
                                <td style="text-align: center">:</td>
                                <td colspan="2" id="kuitansi_txt_akun_showpengembalian">-</td>

            </tr>
            <tr>
                                <td colspan="11">
                                    &nbsp;
                </td>
                        </tr>
            <tr>
                <td colspan="11">
                                    <h4 style="text-align: center"><b>KUITANSI / BUKTI PENGEMBALIAN</b></h4>
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
                                <td colspan="7"><b>Rp. <span class="sum_tot_bruto_showpengembalian">0</span>,-</b></td>
            </tr>
            <tr class="tr_up">
                <td colspan="3">Terbilang</td>
                <td>: </td>
                                <td colspan="7"><b><span class="text_tot_showpengembalian">-</span></b></td>
            </tr>
            <tr class="tr_up">
                <td colspan="3">Untuk Pembayaran</td>
                <td>: </td>
                                <td colspan="7"><span id="uraian_showpengembalian">-</span></td>
            </tr>
            <tr class="tr_up">
                <td colspan="3">Sub Kegiatan</td>
                <td>: </td>
                                <td colspan="7"><span id="nm_subkomponen_showpengembalian">-</span></td>
            </tr>
                        <tr>
                                <td colspan="11">
                                    &nbsp;
                </td>
                        </tr>
                        <tr id="before_tr_isi_showpengembalian">
                            <td colspan="3"><b>Deskripsi</b></td>
                            <td style="text-align:center"><b>Kuantitas</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Satuan</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Harga@</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Bruto</b></td>
                            <td style="padding: 0 5px 0 5px;" colspan="2"><b>Pajak</b></td>
                            <td >&nbsp;</td>
                            <td ><b>Netto</b></td>
            </tr>
                        <tr id="tr_isi_showpengembalian">
                            <td colspan="11">&nbsp;</td>
            </tr>
                        <tr>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td ><b>Jumlah</b></td>
                            <td >&nbsp;</td>
                            <td style="text-align: right"><b><span class="sum_tot_bruto_showpengembalian">0</span></b></td>
                            <td >&nbsp;</td>
                            <td style="text-align: right"><b><span class="sum_tot_pajak_showpengembalian">0</span></b></td>
                            <td ><b><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></b></td>
                            <td style="text-align: right"><b><span class="sum_tot_netto_showpengembalian">0</span></b></td>
            </tr>
                        <tr>
                                <td colspan="11">
                                    &nbsp;
                </td>
                        </tr>
            <tr>
                            <td colspan="7" style="vertical-align: top;">Setuju dibebankan pada mata anggaran berkenaan, <br />
                                a.n. Kuasa Pengguna Anggaran <br />
                                Pejabat Pelaksana dan Pengendali Kegiatan (PPPK)
                            </td>
                            <td colspan="4" style="vertical-align: top;">
                                Semarang, <span id="tgl_kuitansi_showpengembalian">-</span><br />
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
                            <td colspan="7" style="border-bottom: 1px solid #000;vertical-align: bottom;"><span id="nmpppk_showpengembalian">-</span><br>
                                    NIP. <span id="nippppk_showpengembalian">-</span></td>
                            <td colspan="4" style="border-bottom: 1px solid #000;vertical-align: bottom;"><span class="edit_here" style="white-space: pre-line;" id="penerima_uang_showpengembalian">-</span><br />
                                <span id="snip_showpengembalian">NIP. <span class="edit_here" id="penerima_uang_nip_showpengembalian">-</span></span>
                            </td>
            </tr>
                        <tr >
                            <td colspan="7">Setuju dibayar tgl : <br>
                                Bendahara Pengeluaran
                            </td>
                            <td colspan="4" ><span style="display: none" id="td_tglpumk_showpengembalian">Lunas dibayar tgl : <br>
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
                             <td colspan="7"><span id="nmbendahara_showpengembalian"></span><br>
                                 NIP. <span id="nipbendahara_showpengembalian"></span>
                            </td>
                            <td colspan="4" ><span style="display: none" id="td_nmpumk_showpengembalian"><span id="nmpumk_showpengembalian"></span><br>
                                    NIP. <span id="nippumk_showpengembalian"></span></span>
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
                            <td colspan="11" ><span id="penerima_barang_showpengembalian">-</span><br />
                                    NIP. <span id="penerima_barang_nip_showpengembalian">-</span>
                </td>
            </tr>

        </table>
              </div>
              </div> 
              <!-- <form action="<?=site_url('kuitansi/cetak_kuitansi')?>" id="form_kuitansi_showpengembalian" method="post" style="display: none"  >
                    <input type="text" name="dtable" id="dtable" value="" />
                    <input type="text" name="nbukti" id="nbukti" value="" />
                    <input type="text" name="dunit" id="dunit" value="<?=$alias?>" />
                    <input type="text" name="dtahun" id="dtahun" value="<?=$cur_tahun?>" />
                </form> -->
          
            

          <div class="modal-footer">
            <!--<button type="button" class="btn btn-success" id="down" ><span class="glyphicon glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</button>-->
            <button type="button" class="btn btn-info" id="cetak-showpengembalian" rel="" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
          </div>
        </div>
    </div>
</div>

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
</div>
