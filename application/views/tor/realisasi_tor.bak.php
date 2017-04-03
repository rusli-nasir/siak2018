<script type="text/javascript">

var in_kode = 0;
//var in_all = 0;
var pj_p_kode_usulan_all = [];
var pj_p_id_all = [];
var pj_p_jenis_all = [];
var pj_p_persen_all = [];
var pj_p_dpp_all = [];
var pj_p_nilai_all = [];

$(document).ready(function(){

  // == CREATE BY DHANU // DELETE BUT CONFIRM IF CAUSED ERROR
  // script dari dhanu
    // untuk spp ls
    $('#btn-buat-ls').on('click',function(e){
        e.preventDefault();
        var j="";
        var n = ($( '[class^="ck_"]:checked' ).length);
        if(n<=0){
            alert('Pilih salah satu proses dengan sistem LS-Pegawai');
        }else{
            $( '[class^="ck_"]:checked' ).each(function(index){
                // j[index] = $( this ).attr('rel');
                console.log('Row '+ index + ' ' + $( this ).attr('rel'));
                j += $( this ).attr('rel')+','
            });
            // $('#akunSPPLS').val(j);
            data = 'akunSPPLS='+j;
            console.log('Akun SPPLS : ' + j);
            $.ajax({
              type:"POST",
              url :"<?=site_url("tor/prosesSPPLS")?>",
              data:data,
              success:function(data){
                if($.isNumeric(data)){
                    window.location = '<?php echo site_url("tor/sppLS"); ?>/id/'+data;
                }else{
                    $('.message_sppls').html(data);
                    $('#myModalMessage').modal('show');
                }
              }
            });
        }
    });
    // untuk pembatalan dpa
    $('.btn_batal').on('click',function(e){
      e.preventDefault();
      var akun = $(this).attr('rel');
      $('.yakin_batal').prop('id',akun);
      $('#myModalBatal').modal('show');
      console.log('Kode akun yang dipindahkan : '+$('.yakin_batal').attr('id'));
    });
    $('.yakin_batal').on('click',function(e){
      e.preventDefault();
      var data = 'akunne='+$(this).attr('id');
      console.log('tr tabel yang dihapus : tr_'+$(this).attr('id'));
      // $('#tr_'+$('.yakin_batal').attr('id')).hide();
      // $('#myModalBatal').modal('hide');
      var akun = '#tr_'+$(this).attr('id');
      $.ajax({
        type:"POST",
        url :"<?=site_url("tor/prosesBatalDPA")?>",
        data:data,
        success:function(data){
          if(data=='1'){
            $('#myModalBatal').modal('hide');
            $(akun).hide();
            // $('#tr_'+$('.yakin_batal').attr('id')).hide();
            $('.message_sppls').html("<p class='alert alert-success text-center'>Sukses membatalkan DPA</p>");
            $('#myModalMessage').modal('show');
          }else{
            $('#myModalBatal').modal('hide');
            $('.message_sppls').html(data);
            $('#myModalMessage').modal('show');
          }
        }
      });
    });
    // end here
  // == END HERE

        $('#backi').click(function(){
            window.location = "<?=site_url("dpa/daftar_dpa/").$sumber_dana?>";
        });

        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
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
//        $(document).on("focusout","input.xnumber",function(){
//
////            var kode_usulan_belanja = $(this).attr('rel');
//
//                if($(this).val()==''){
//                        $(this).val('0');
//
//                }
//                else{
//                        var str = $(this).val();
//                        $(this).val(string_to_angka(str));
//
////                        calcinput(kode_usulan_belanja);
//
//                        //alert(str);
//                        //$(this).val(str);
//                }
//
//        });

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

        $('[id^="td_kumulatif_"]').each(function(){
            var kd_usul = $(this).attr('rel');

            if($(this).html() == '0'){
//                console.log(kd_usul);
                $('[id^="tr_empty_'+ kd_usul +'"]').hide();
                $('[id^="tr_unit_'+ kd_usul +'"]').hide();
                $('[id^="tr_akun_'+ kd_usul +'"]').hide();
                $('[id^="tr_total_'+ kd_usul +'"]').hide();
                $('[id^="tr_usulan_'+ kd_usul +'"]').hide();
                $('[id^="tr_sisa_'+ kd_usul +'"]').hide();
            }

        });

        var kd_usulan_x_tmp = '';
        var kd_usulan_tmp = '';
        var badge_tmp = '' ;
        var aktv = '0';

        $('[class^="all_ck_"]').each(function(){
                var str = $(this).attr('rel');
                var badge_on = '';
                var on = 'true' ;
                $('[id^="badge_id_'+ str +'"]').each(function(){
                    if( $(this).text() != badge_on ){
                        if(badge_on == ''){
                            badge_on = $(this).text();
                        }else{
                            on = 'false';
                        }

                    }
                });
                if(on == 'false'){
                    $(this).attr('disabled','disabled');
                }
        });

        $(document).on('change', '[class^="all_ck_"]', function(){
            var str = $(this).attr('rel');
            var badge_ = $('[id^="badge_id_'+ str +'"]').html();
//            console.log(badge_);
            var badge = badge_.trim();
//            var kd_usulan_x = str.substr(0,18);
            var el = $(this) ;
//            if( kd_usulan_x_tmp != kd_usulan_x ){
                $('[class^="all_ck_"]').each(function(){
                    if($(this).attr('rel') != str){
                        $(this).prop('checked',false);
                    }
//                        $(this).attr('readonly','readonly');
////                         console.log($(this).attr('rel'));
                });
//            }
                $('[class^="ck_"]').each(function(){
                    $(this).prop('checked',false);
//                        $(this).attr('readonly','readonly');
////                         console.log($(this).attr('rel'));
                });

//            el.prop('checked',true);
            if(el.is(':enabled')){
                if(el.is(':checked')){
                    $('[class^="ck_'+ str +'"]').each(function(){
                        $(this).prop('checked',true);
                        badge_tmp = badge ;
                    });
                }else{
                    $('[class^="ck_'+ str +'"]').each(function(){
                        $(this).prop('checked',false);
                    });
                }
            }

            $('[class^="all_ck_"]').each(function(){
                //$('#btn-kuitansi').attr('disabled','disabled');
                aktv = '0';
                if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                    // $('#btn-kuitansi').removeAttr('disabled');
                    aktv = '1';
                    return false;

                }
            });
            if(aktv == '1'){
                $('#btn-kuitansi').attr('rel',str);
                $('#btn-submit-kuitansi').attr('rel',str);
                $('#btn-kuitansi').removeAttr('disabled');
                // untuk spp ls created by dhanu
                $('#btn-buat-ls').attr('rel', str);
                $('#btn-buat-ls').show();
                // end here

                $('#kode_badge').text(badge_tmp);
            }else{
                $('#btn-kuitansi').attr('rel','');
                $('#btn-submit-kuitansi').attr('rel','');
                $('#btn-kuitansi').attr('disabled','disabled');
                // untuk spp ls created by dhanu
                $('#btn-buat-ls').attr('rel', '');
                $('#btn-buat-ls').hide();
                // end here
            }

        });

        $(document).on('change', '[class^="ck_"]', function(){

            var str = $(this).attr('rel');
            var kd_usulan = str.substr(0,24);
            var badge_ = $('#badge_id_' + str).html();
            var badge = badge_.trim();
            var el = $(this) ;
            if(el.is(':enabled')){
                $('[class^="all_ck_"]').prop('checked',false);
                if(el.is(':checked')){
                    // checkbox is checked
                    // alert('t');
                    if((kd_usulan_tmp != kd_usulan) || badge_tmp != badge ){
                        $('[class^="ck_"]').each(function(){
                            $(this).prop('checked',false);
    //                        $(this).attr('readonly','readonly');
    //                         console.log($(this).attr('rel'));
                        });
                    }

                    el.prop('checked',true);
    //                console.log(kd_usulan_tmp + ' | ' + kd_usulan);
                    kd_usulan_tmp = kd_usulan ;
                    badge_tmp = badge ;

                }else if(!(el.is(':checked'))){
//                    $('[class^="all_ck_"]').prop('checked',false);
                }
            }
            $('[class^="ck_"]').each(function(){
                //$('#btn-kuitansi').attr('disabled','disabled');
                aktv = '0';
                if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                    // $('#btn-kuitansi').removeAttr('disabled');
                    aktv = '1';
                    return false;

                }
            });
            if(aktv == '1'){
                $('#btn-kuitansi').attr('rel',kd_usulan);
                $('#btn-submit-kuitansi').attr('rel',kd_usulan);
                $('#btn-kuitansi').removeAttr('disabled');
                // untuk spp ls created by dhanu
                $('#btn-buat-ls').attr('rel', str);
                $('#btn-buat-ls').show();
                // end here

                $('#kode_badge').text(badge_tmp);
            }else{
                $('#btn-kuitansi').attr('rel','');
                $('#btn-submit-kuitansi').attr('rel','');
                $('#btn-kuitansi').attr('disabled','disabled');
                // untuk spp ls created by dhanu
                $('#btn-buat-ls').attr('rel', '');
                $('#btn-buat-ls').hide();
                // end here
            }
        });

        $(document).on("click",'#btn-kuitansi',function(){
            // PREPARE GLOBAL VAR
//            in_all = 0;
            pj_p_jenis_all = [];
            pj_p_persen_all = [];
            pj_p_dpp_all = [];
            pj_p_nilai_all = [];
            /// PREPARE TABLE ELEMENT
            $('#tr_new_').replaceWith('<tr id="tr_isi"><td colspan="8">tr_isi</td></tr>');
            $('#uraian').html("- edit here -");
            $('#penerima_uang').html("- edit here -");
//            $('#penerima_uang_nip').html("- edit here -");
            $('#penerima_barang').html("- edit here -");
            $('#penerima_barang_nip').html("- edit here -");
            $(".tr_new").remove();
            var str = $(this).attr('rel') ;
            var kd_usulan = str.substr(0,24);
            var nm_akun = $('#nm_akun_' + kd_usulan).html();
            var str_isi = '<tr id="tr_new_" style="display:none"><td>&nbsp;</td></tr>';
            var i = 0 ;

            //$('#tr_isi').replaceWith(str_isi);

            $('[class^="ck_"]').each(function(){
                //$('#btn-kuitansi').attr('disabled','disabled');
                var el = $(this).attr('rel');


                if(($(this).is(':checked'))&&($(this).is(':enabled'))){

                    str_isi = str_isi + '<tr class="tr_new">' ;

                    // $('#btn-kuitansi').removeAttr('disabled');
                    var l_td = $('#tr_' + el + ' > td').length ; // .not(':first').not(':last')
//                    console.log(l_td);
                    $('#tr_' + el + ' > td').each(function(ii){
                        if(ii == 1){
                            str_isi = str_isi + '<td colspan="3">' + (i+1) + '. ' + $(this).html() + '</td>' ;
                        }
                        else if(ii == 2){
                            str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">' + $(this).html() + '</td>' ;
                        }
                        else if(ii == 3){
                            str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">' + $(this).html() + '</td>' ;
                        }
                        else if(ii == 4){
                            str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;">' + $(this).html() + '</td>' ;
                        }
                        else if(ii == 5){
                            str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;" class="sub_tot_bruto_'+ el +'">' + $(this).html() + '</td>\n\
                                        <td class="row_pajak_'+ el +'" style="padding: 0 5px 0 5px;">[<a data-toggle="modal" rel="'+ i + '_' + el +'" id="pilih_pajak_'+ el +'" href="#myModalPajak">Edit</a>]</td>\n\
                                        <td style="text-align:right;" class="row_pajak_nom_'+ el +'">0</td>\n\
                                        <td ><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></td>\n\
                                        <td style="text-align:right" rel="'+ el +'" class="sub_tot_netto_'+ el +'">0</td>';
                        }
//                        else if(ii == 5){
//                            str_isi = str_isi + '<td ><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></td><td style="text-align:right" class="sub_tot_'+ el +'">' + $(this).html() + '</td>' ;
//                        }
                        else{
//                            if( ( ii != 0 ) && ( ii != (l_td - 1) ) && ( ii != (l_td - 2)) ) {
//                                str_isi = str_isi + '<td >' + $(this).html() + '</td>' ;
//                            }
                        }

                        pj_p_kode_usulan_all[i] =  el;
                        pj_p_id_all[i] = [];
                        pj_p_jenis_all[i] = [];
                        pj_p_persen_all[i] = [];
                        pj_p_dpp_all[i] = [];
                        pj_p_nilai_all[i] = [];
                    });

                    str_isi = str_isi + '</tr>' ;
                    i++ ;
                }

            });
/*
            <td colspan="3">1. Alat Kesehatan, tulis  dan seminar kit x @ rp. 25.000 </td>
                            <td style="text-align: center">80 </td>
                            <td>Paket Seminar KIT </td>
                            <td>=</td>
                            <td style="text-align: right">2.000.000</td>
 * /
                             */
            $('#tr_isi').replaceWith(str_isi);
            var sum_tot_bruto = 0 ;
            $('[class^="sub_tot_bruto_"').each(function(){
                sum_tot_bruto = sum_tot_bruto + parseInt(string_to_angka($(this).html()));
            });
            $('.sum_tot_bruto').html(angka_to_string(sum_tot_bruto));

            var sum_tot_netto = 0 ;
            $('[class^="sub_tot_netto_"').each(function(){
                var nrel = $(this).attr('rel');
                var sub_tot_bruto = parseInt(string_to_angka($('.sub_tot_bruto_' + nrel).text()));
                var pajak = parseInt(string_to_angka($('.row_pajak_nom_' + nrel).text()));
                var sub_tot_netto = sub_tot_bruto - pajak;
                $(this).text(angka_to_string(sub_tot_netto));
                sum_tot_netto = sum_tot_netto + sub_tot_netto ;

            });
            $('.sum_tot_netto').html(angka_to_string(sum_tot_netto));

            $('.text_tot').html(terbilang(sum_tot_netto));

            $('#txt_akun').html(nm_akun);
            $('#nm_subkomponen_kuitansi').html($('#nm_subkomponen').html());

            var data = "alias=<?=$alias?>" ; //&sumber_dana=<?=$sumber_dana?>&jenis=" + badge_tmp ;

//            $('[id^="pilih_pajak_"]').each(function(){
//                $(this).editable({
//                    type: 'select',
//                    title: 'Pilih pajak',
//                    placement: 'top',
//                    value: '',
//                    source: [
//                                {
//                                    text: "PPn",
//                                    children: [
//                                        {value: '10', text: "PPn [dipotong]"},
//                                        {value: '0',  text: "PPn [tdk dipotong]"},
//                                    ]
//                                },
//                                {
//                                    text: "PPh",
//                                    children: [
//                                        {value: '5',   text: "PPh [P.21 - 5%]"},
//                                        {value: '6',   text: "PPh [P.21 - 6%]"},
//                                        {value: '15',  text: "PPh [P.21 - 15%]"},
//                                        {value: '1.5', text: "PPh [P.22 - 1.5%]"},
//                                        {value: '2',   text: "PPh [P.23 - 2%]"},
//                                        {value: '20',  text: "PPh [P.26 - 20%]"}
//                                    ]
//                                },
//
//                                {
//                                    text: "Lainnya",
//                                    children: [
//                                        {value: '-', text: "- lainnya -"},
//                                    ]
//                                }
//                            ],
//                    display: function(value, sourceData) {
//                                    //display checklist as comma-separated values
////                                    console.log(value);
//                                    if(value == ''){
//                                        $(this).text('- pilih -');
//                                    }
//                                    else if(value == '-'){
//                                        $(this).text('');
//                                    }else{
//                                        $(this).text(value + '%');
//
//                                        var rel = $(this).attr('rel');
//                                        var v_tot_ = $('#td_sub_tot_'+ rel).html();
//                                        var v_tot = parseInt(string_to_angka(v_tot_.trim()));
//                                        var v_pajak = parseInt(value);
//
//                                        var v_tot_pajak = v_tot - ( ( v_tot * v_pajak ) / 100 ) ;
//
//                                        $('.sub_tot_'+ rel).html(angka_to_string(v_tot_pajak));
//
//                                        var sum_tot = 0 ;
//                                        $('[class^="sub_tot_"]').each(function(){
//                                            sum_tot = sum_tot + parseInt(string_to_angka($(this).text())); ;
//                                            $('.sum_tot').html(angka_to_string(sum_tot));
//                                        });
//                                    }
//
//                                },
//                });
//
//            });


            $.ajax({
                type:"POST",
                url :"<?=site_url("kuitansi/get_next_id")?>",
                data:data,
                success:function(data){
//                        console.log(data)
                        $('#no_bukti').html(data);
                        $('#myModalKuitansi').modal('show');
//                        location.reload();
                }
            });


        });

        $(document).on('click', '[id^="pilih_pajak_"]',  function(e){
            var rel = $(this).attr('rel');
            $("#myModalPajak").attr('rel',rel);
        });


        $("#myModalPajak").on('show.bs.modal', function (event) {

                $('[id^="pj_p_"]').each(function(){
                    $(this).prop('checked',false);
                });
                $('[id^="pj_dpp_"]').each(function(){
                    $(this).prop('checked',false);
                    $(this).attr('disabled','disabled');
                });
                $('[id^="pj_nilai_"]').each(function(){
                    $(this).val('');
                    $(this).attr('disabled','disabled');
                });
                $('#total_pajak').text('0');
        });

        $(document).on('focus', '.edit_here',  function(e){
                // console.log("focused on " + e.target.id);
                var uraian_ = $(this).html();
                if( uraian_.trim() == '- edit here -' ){

                    $(this).html('_');
                    $(this).focus();

                }
        });

        $(document).on('keydown', '.edit_here',  function(e){
                // console.log("focused on " + e.target.id);
//                $(this).html(function(i,h){
//                                    return h.replace(/&nbsp;/g,'');
//                                });
                var uraian_ = $(this).text();
                var uraian = uraian_.trim();
                if( uraian.charAt(0) === '_' ){
                    uraian = uraian.substr(1);
                    $(this).html(uraian);
//                    $(this).focus();

                }
        });

        $(document).on('blur', '.edit_here',  function(e){
                // console.log("focused on " + e.target.id);
//                $(this).html(function(i,h){
//                                    return h.replace(/&nbsp;/g,'');
//                                });
                var uraian_ = $(this).text();
//                console.log(uraian_.trim());
                if( ( uraian_.trim() == '' ) || ( uraian_.trim() == '_' ) ) {
                    $(this).html('- edit here -');
                }
        });

//        $(document).on('click', '[id^="pilih_pajak_"]', function(){
////            var rel = $(this).attr('rel');
//             // alert('tes');
//        });

        $(document).on('change', '[id^="pj_p_"]', function(){
            var rel_ = $(this).attr('rel');
            var rel_a = rel_.split("_");
            var rel = rel_a[0];
            var rel_1 = rel_a[1];
            var rel_modal_ = $("#myModalPajak").attr('rel');
            var rel_modal_a = rel_modal_.split("_");
            var rel_modal = rel_modal_a[1];
            if($(this).val() != '99'){
                if($(this).is(':checked')){

                    var el = $(this);

                    $('.pj_p_' + rel_1 ).each(function(){

                        var rel__ = $(this).attr('rel');
                        var rel__a = rel__.split("_");
                        var rel__1 = rel__a[1];

                        $(this).prop('checked',false);

                        $('.pj_dpp_' + rel__1).attr('disabled','disabled');
                        $('.pj_dpp_' + rel__1).prop('checked',false);
                        $('.pj_nilai_' + rel__1).val('');
                    });

                    $('#pj_dpp_' + rel).removeAttr('disabled');

                    el.prop('checked',true);
                    var bruto_ = $('.sub_tot_bruto_' + rel_modal).text();
                    var bruto = string_to_angka(bruto_);
                    var pajak = el.val() ;
                    var bruto = (bruto * pajak) / 100 ;
                    $('#pj_nilai_' + rel).val(angka_to_string(bruto));
                }else{
                    $('#pj_dpp_' + rel).prop('checked',false);
                    $('#pj_dpp_' + rel).attr('disabled','disabled');
                    $('#pj_nilai_' + rel).val('');
                }
            }else{
                if($(this).is(':checked')){
                    $('#pj_nilai_' + rel).removeAttr('disabled');
                    $('#pj_nilai_' + rel).focus();
                }else{
                    $('#pj_nilai_' + rel).val('');
                    $('#pj_nilai_' + rel).attr('disabled','disabled');
                }
            }
            get_total_pajak();
        });

        $(document).on('change', '[id^="pj_dpp_"]', function(){
            var rel = $(this).attr('rel');
            var rel_modal_ = $("#myModalPajak").attr('rel');
            var rel_modal_a = rel_modal_.split("_");
            var rel_modal = rel_modal_a[1];
            if($(this).is(':checked')){
//                $('#pj_dpp_' + rel).removeAttr('disabled');

                var bruto_ = $('.sub_tot_bruto_' + rel_modal).text();
                var bruto = string_to_angka(bruto_);
                var pajak = $('#pj_p_' + rel).val() ;
                var bruto = (parseInt(pajak) * ((100 / (110)) * bruto))/100 ;
//                console.log(Math.round(bruto) + ' ' + rel);
                $('#pj_nilai_' + rel).val(angka_to_string(Math.round(bruto)));
            }else{
//                $('#pj_dpp_' + rel).attr('disabled','disabled');
                var bruto_ = $('.sub_tot_bruto_' + rel_modal).text();
                var bruto = string_to_angka(bruto_);
                var pajak = $('#pj_p_' + rel).val() ;
                var bruto = (bruto * parseInt(pajak)) / 100 ;
                $('#pj_nilai_' + rel).val(angka_to_string(bruto));
            }
            get_total_pajak();
        });

        $(document).on('focusout', '.pj_nilai_lainnya', function(){
            get_total_pajak();
        });

        $(document).on('click', '#btn-submit-pajak', function(){
            var rel = $('#myModalPajak').attr('rel');

            var rel_ = $("#myModalPajak").attr('rel');
            var rel_a = rel_.split("_");
            var rel = rel_a[1];
            var in_all = rel_a[0];

            var bruto = $('.sub_tot_bruto_' + rel).text();
            var total_pajak = $('#total_pajak').text();
            var netto = parseInt(string_to_angka(bruto)) - parseInt(string_to_angka(total_pajak));


            $('.sub_tot_netto_' + rel ).text(angka_to_string(netto));
            var pj_p_id = [];
            var pj_p_jenis = [];
            var pj_p_persen = [];
            var pj_p_dpp = [];
            var pj_p_nilai = [];
            var ii = 0 ;
            $('[id^="pj_p_"]').each(function(){
                if($(this).is(':checked')){
                    var jenis_ = $(this).attr('rel');
                    var jenis_a = jenis_.split("_");
                    var jenis = jenis_a[1];
                    pj_p_id[ii] = jenis_a[0];
                    pj_p_jenis[ii] = jenis ;
                    pj_p_persen[ii] = $(this).val() ;
                    if($('#pj_dpp_' + jenis_a[0]).is(':checked')){
                        pj_p_dpp[ii] = '1';
                    }else{
                        pj_p_dpp[ii] = '0';
                    }
                    pj_p_nilai[ii] = $('#pj_nilai_' + jenis_a[0]).val() ;
                    ii++ ;
                }
            });
            pj_p_id_all[in_all] = pj_p_id;
            pj_p_jenis_all[in_all] = pj_p_jenis;
            pj_p_dpp_all[in_all] = pj_p_dpp;
            pj_p_persen_all[in_all] = pj_p_persen;
            pj_p_nilai_all[in_all] = pj_p_nilai;
//            var pj_p_persen = [];
//            var pj_p_dpp = [];
//            var pj_p_nilai = [];
            var str_h = '';
            var str_i = '';
            $.each(pj_p_jenis, function(k,v) {
                if(v == 'ppn'){v = 'PPN'}
                else if(v == 'pphps21'){v = 'PPh Ps 21'}
                else if(v == 'pphps22'){v = 'PPh Ps 22'}
                else if(v == 'pphps23'){v = 'PPh Ps 23'}
                else if(v == 'pphps26'){v = 'PPh Ps 26'}
                else if(v == 'pphps42'){v = 'PPh Ps 4(2)'}

                if(pj_p_dpp[k]=='1'){
                    str_h = str_h + v + ' ' + pj_p_persen[k] + '% (dpp) <br />' ;
                }else{
                    if(pj_p_persen[k] != '99'){
                        str_h = str_h + v + ' ' + pj_p_persen[k] + '%  <br />' ;
                    }else{
                        str_h = str_h + v + ' <br />' ;
                    }

                }

                str_i = str_i + '<span class="sub_tot_pajak">' + pj_p_nilai[k] +'</span>' + '<br />' ;

            });

            if(str_h == ''){
                $('.row_pajak_' + rel).html('<a data-toggle="modal" rel="'+ in_all + '_' + rel +'" id="edit_p_' + rel + '" href="#myModalPajakEdit" style="margin: 0 5px 0 5px;">- pilih -</a>');
                $('.row_pajak_nom_' + rel).html(str_i);
            }else{
                $('.row_pajak_' + rel).html(str_h + '[<a data-toggle="modal" href="#myModalPajakEdit" rel="'+ in_all + '_' + rel +'" id="edit_p_' + rel + ' " >Edit</a>]');
                if(str_i==''){
                    str_i = '0';
                }
                $('.row_pajak_nom_' + rel).html(str_i);
            }

            var sub_tot_pajak = 0 ;
            $('.sub_tot_pajak').each(function(){
                sub_tot_pajak = sub_tot_pajak + parseInt(string_to_angka($(this).text())) ;
            });
            $('.sum_tot_pajak').html(angka_to_string(sub_tot_pajak));

            var sum_tot_netto = 0 ;
            $('[class^="sub_tot_netto_"').each(function(){
                sum_tot_netto = sum_tot_netto + parseInt(string_to_angka($(this).html()));
            });

            $('.sum_tot_netto').html(angka_to_string(sum_tot_netto));

            $('.text_tot').html(terbilang(sum_tot_netto));

            $('#myModalPajak').modal('hide');

//            pj_p_kode_usulan_all[in_all] = rel ;
//            console.log(JSON.stringify(pj_p_kode_usulan_all));
//            console.log(JSON.stringify(pj_p_id_all));
//            console.log(JSON.stringify(pj_p_jenis_all));
//            console.log(JSON.stringify(pj_p_dpp_all));
//            console.log(JSON.stringify(pj_p_persen_all));
//            console.log(JSON.stringify(pj_p_nilai_all));

//            in_all++ ;
        });

        $(document).on('change', '[id^="edit_pj_p_"]', function(){
            var rel_ = $(this).attr('rel');
            var rel_a = rel_.split("_");
            var rel = rel_a[0];
            var rel_1 = rel_a[1];
            var rel_modal_ = $("#myModalPajakEdit").attr('rel');
            var rel_modal_a = rel_modal_.split("_");
            var rel_modal = rel_modal_a[1];
//            console.log(rel_modal);
            if($(this).val() != '99'){
                if($(this).is(':checked')){

                    var el = $(this);

                    $('.edit_pj_p_' + rel_1 ).each(function(){

                        var rel__ = $(this).attr('rel');
                        var rel__a = rel__.split("_");
                        var rel__1 = rel__a[1];

                        $(this).prop('checked',false);

                        $('.edit_pj_dpp_' + rel__1).attr('disabled','disabled');
                        $('.edit_pj_dpp_' + rel__1).prop('checked',false);
                        $('.edit_pj_nilai_' + rel__1).val('');
                    });

                    $('#edit_pj_dpp_' + rel).removeAttr('disabled');

                    el.prop('checked',true);
                    var bruto_ = $('.sub_tot_bruto_' + rel_modal).text();
                    var bruto = string_to_angka(bruto_);
                    var pajak = el.val() ;
                    var bruto = (bruto * pajak) / 100 ;
                    $('#edit_pj_nilai_' + rel).val(angka_to_string(bruto));
                }else{
                    $('#edit_pj_dpp_' + rel).prop('checked',false);
                    $('#edit_pj_dpp_' + rel).attr('disabled','disabled');
                    $('#edit_pj_nilai_' + rel).val('');
                }
            }else{
                if($(this).is(':checked')){
                    $('#edit_pj_nilai_' + rel).removeAttr('disabled');
                    $('#edit_pj_nilai_' + rel).focus();
                }else{
                    $('#edit_pj_nilai_' + rel).val('');
                    $('#edit_pj_nilai_' + rel).attr('disabled','disabled');
                }
            }
            get_total_pajak_edit();
        });

        $(document).on('change', '[id^="edit_pj_dpp_"]', function(){
            var rel = $(this).attr('rel');

            var rel_modal_ = $("#myModalPajakEdit").attr('rel');
            var rel_modal_a = rel_modal_.split("_");
            var rel_modal = rel_modal_a[1];


            if($(this).is(':checked')){
//                $('#pj_dpp_' + rel).removeAttr('disabled');

                var bruto_ = $('.sub_tot_bruto_' + rel_modal).text();
                var bruto = string_to_angka(bruto_);
                var pajak = $('#edit_pj_p_' + rel).val() ;
                var bruto = (parseInt(pajak) * ((100 / (110)) * bruto))/100 ;
//                console.log(Math.round(bruto) + ' ' + rel);
                $('#edit_pj_nilai_' + rel).val(angka_to_string(Math.round(bruto)));
            }else{
//                $('#pj_dpp_' + rel).attr('disabled','disabled');
                var bruto_ = $('.sub_tot_bruto_' + rel_modal).text();
                var bruto = string_to_angka(bruto_);
                var pajak = $('#edit_pj_p_' + rel).val() ;
                var bruto = (bruto * parseInt(pajak)) / 100 ;
                $('#edit_pj_nilai_' + rel).val(angka_to_string(bruto));
            }
            get_total_pajak_edit();
        });

        $(document).on('focusout', '.edit_pj_nilai_lainnya', function(){
            get_total_pajak_edit();
        });

        $(document).on('click', '[id^="edit_p_"]',  function(e){
            var rel_ = $(this).attr('rel');
            var rel_a = rel_.split("_");
            var rel = rel_a[1];
            var id_in_all = rel_a[0];

            var pj_p_id_all_ = pj_p_id_all[id_in_all];
            var pj_p_jenis_all_ = pj_p_jenis_all[id_in_all];
            var pj_p_persen_all_ = pj_p_persen_all[id_in_all];
            var pj_p_dpp_all_ = pj_p_dpp_all[id_in_all];
            var pj_p_nilai_all_ = pj_p_nilai_all[id_in_all]

            $.each(pj_p_id_all_,function(k,v){
                $('#edit_pj_p_' + v).prop('checked',true);
                $('#edit_pj_dpp_' + v).removeAttr('disabled');
                if(pj_p_dpp_all_[k] == '1'){

                    $('#edit_pj_dpp_' + v).prop('checked',true);
                }

                if(pj_p_persen_all_[k] == '99'){
                    $('#edit_pj_nilai_' + v).removeAttr('disabled');
                }

                $('#edit_pj_nilai_' + v).val(pj_p_nilai_all_[k]);
            });

            $("#myModalPajakEdit").attr('rel',id_in_all + '_' + rel);
            get_total_pajak_edit();
        });

        $("#myModalPajakEdit").on('show.bs.modal', function (event) {

                $('[id^="edit_pj_p_"]').each(function(){
                    $(this).prop('checked',false);
                });
                $('[id^="edit_pj_dpp_"]').each(function(){
                    $(this).prop('checked',false);
                    $(this).attr('disabled','disabled');
                });
                $('[id^="edit_pj_nilai_"]').each(function(){
                    $(this).val('');
                    $(this).attr('disabled','disabled');
                });
                $('#edit_total_pajak').text('0');
        });

        $(document).on('click', '#btn-edit-pajak', function(){
            var rel_ = $('#myModalPajakEdit').attr('rel');

//            var rel_ = $(this).attr('rel');
            var rel_a = rel_.split("_");
            var rel = rel_a[1];
            var id_in_all = rel_a[0];

            var bruto = $('.sub_tot_bruto_' + rel).text();
            var total_pajak = $('#edit_total_pajak').text();
            var netto = parseInt(string_to_angka(bruto)) - parseInt(string_to_angka(total_pajak));

            $('.sub_tot_netto_' + rel ).text(angka_to_string(netto));
            var pj_p_id = [];
            var pj_p_jenis = [];
            var pj_p_persen = [];
            var pj_p_dpp = [];
            var pj_p_nilai = [];
            var ii = 0 ;
            $('[id^="edit_pj_p_"]').each(function(){
                if($(this).is(':checked')){
                    var jenis_ = $(this).attr('rel');
                    var jenis_a = jenis_.split("_");
                    var jenis = jenis_a[1];
                    pj_p_id[ii] = jenis_a[0];
                    pj_p_jenis[ii] = jenis ;
                    pj_p_persen[ii] = $(this).val() ;
                    if($('#edit_pj_dpp_' + jenis_a[0]).is(':checked')){
                        pj_p_dpp[ii] = '1';
                    }else{
                        pj_p_dpp[ii] = '0';
                    }
                    pj_p_nilai[ii] = $('#edit_pj_nilai_' + jenis_a[0]).val() ;
                    ii++ ;
                }
            });
            pj_p_id_all[id_in_all] = pj_p_id;
            pj_p_jenis_all[id_in_all] = pj_p_jenis;
            pj_p_dpp_all[id_in_all] = pj_p_dpp;
            pj_p_persen_all[id_in_all] = pj_p_persen;
            pj_p_nilai_all[id_in_all] = pj_p_nilai;

//            console.log(JSON.stringify(pj_p_jenis_all));
//            console.log(JSON.stringify(pj_p_dpp_all));
//            console.log(JSON.stringify(pj_p_persen_all));
//            console.log(JSON.stringify(pj_p_nilai_all));

//            var pj_p_persen = [];
//            var pj_p_dpp = [];
//            var pj_p_nilai = [];
            var str_h = '';
            var str_i = '';
            $.each(pj_p_jenis, function(k,v) {
                if(v == 'ppn'){v = 'PPN'}
                else if(v == 'pphps21'){v = 'PPh Ps 21'}
                else if(v == 'pphps22'){v = 'PPh Ps 22'}
                else if(v == 'pphps23'){v = 'PPh Ps 23'}
                else if(v == 'pphps26'){v = 'PPh Ps 26'}
                else if(v == 'pphps42'){v = 'PPh Ps 4(2)'}

                if(pj_p_dpp[k]=='1'){
                    str_h = str_h + v + ' ' + pj_p_persen[k] + '% (dpp) <br />' ;
                }else{
                    if(pj_p_persen[k] != '99'){
                        str_h = str_h + v + ' ' + pj_p_persen[k] + '%  <br />' ;
                    }else{
                        str_h = str_h + v + ' <br />' ;
                    }

                }
                str_i = str_i + '<span class="sub_tot_pajak">' + pj_p_nilai[k] +'</span>' + '<br />' ;


            });
            $('.row_pajak_' + rel).html(str_h + '[<a data-toggle="modal" href="#myModalPajakEdit" rel="'+ id_in_all + '_' + rel +'" id="edit_p_' + rel + '">Edit</a>]');
            if(str_i==''){
                    str_i = '0';
                }
            $('.row_pajak_nom_' + rel).html(str_i);
            var sub_tot_pajak = 0 ;
            $('.sub_tot_pajak').each(function(){
                sub_tot_pajak = sub_tot_pajak + parseInt(string_to_angka($(this).text())) ;
            });
            $('.sum_tot_pajak').html(angka_to_string(sub_tot_pajak));

            var sum_tot_netto = 0 ;
            $('[class^="sub_tot_netto_"').each(function(){
                sum_tot_netto = sum_tot_netto + parseInt(string_to_angka($(this).html()));
            });

            $('.sum_tot_netto').html(angka_to_string(sum_tot_netto));

            $('.text_tot').html(terbilang(sum_tot_netto));

            $('#myModalPajakEdit').modal('hide');

//            console.log(JSON.stringify(pj_p_kode_usulan_all));
//            console.log(JSON.stringify(pj_p_id_all));
//            console.log(JSON.stringify(pj_p_jenis_all));
//            console.log(JSON.stringify(pj_p_dpp_all));
//            console.log(JSON.stringify(pj_p_persen_all));
//            console.log(JSON.stringify(pj_p_nilai_all));

//            in_all++ ;
        });

        $(document).on("click",'#btn-submit-kuitansi',function(){


            var str = $(this).attr('rel') ;
            var kd_usulan = str.substr(0,24);
            // var kd_tambah = str.substr(24,3);

            var no_bukti = $('#no_bukti').text();

            var uraian = $('#uraian').text();

            var penerima_uang = $('#penerima_uang').text();

//            var penerima_uang_nip_ = $('#penerima_uang_nip').html();
//            var penerima_uang_nip = penerima_uang_nip_.trim();

            var penerima_barang = $('#penerima_barang').text();

            var penerima_barang_nip = $('#penerima_barang_nip').text();

            var kode_usulan_belanja = kd_usulan;
            // var kode_akun_tambah = kd_tambah;
            var ok = 'true';
            $('.edit_here').each(function(){
                var el = $(this).text();
                if( el.trim() == '- edit here -' ){

                    ok = 'false';

                }
            });

            if($('.sum_tot_netto').text()[0] == '0'){
                ok = 'false';
            }
//            $('[id^="pilih_pajak_"]').each(function(){
////            $('.edit_here').each(function(){
//                var el = $(this).text();
//                if( el.trim() == '- pilih -' ){
//
//                    ok = 'false';
//
//                }
//            });

            if( ok == 'true'){

            if(confirm('Yakin akan memproses ?')){

                var kode_akun_tambah_ = [];
                var i = 0 ;
                $('[class^="ck_'+ kode_usulan_belanja +'"]').each(function(){
                    //$('#btn-kuitansi').attr('disabled','disabled');
                    var el = $(this).attr('rel');
                    var kode_akun_tambah = el.substr(24,3);

                    if(($(this).is(':checked'))&&($(this).is(':enabled'))){

                        kode_akun_tambah_[i] = kode_akun_tambah;
                        i++ ;
                    }



                });

//                var pajak_ = [];
//                var i = 0 ;
//                $('[id^="pilih_pajak_"]').each(function(){
//                    //$('#btn-kuitansi').attr('disabled','disabled');
//
//                        var pajak = $(this).text();
//                        pajak_[i] = pajak.slice(0, -1);;
//                        i++ ;
//
//
//
//
//                });

//                console.log(kode_akun_tambah_);

                var data =  'kode_unit=' + '<?=$kode_unit?>' + '&no_bukti='+ no_bukti + '&uraian=' + uraian + '&jenis=' + badge_tmp + '&sumber_dana=<?=$sumber_dana?>' + '&kode_usulan_belanja=' + kode_usulan_belanja + '&kode_akun_tambah=' + kode_akun_tambah_ + '&penerima_uang=' + penerima_uang + '&penerima_barang=' + penerima_barang + '&penerima_barang_nip=' + penerima_barang_nip + '&pajak_kode_usulan=' + JSON.stringify(pj_p_kode_usulan_all) + '&pajak_id_input=' + JSON.stringify(pj_p_id_all) + '&pajak_jenis=' + JSON.stringify(pj_p_jenis_all) + '&pajak_dpp=' + JSON.stringify(pj_p_dpp_all) + '&pajak_persen=' + JSON.stringify(pj_p_persen_all) + '&pajak_nilai=' +JSON.stringify(pj_p_nilai_all) ; // '&penerima_uang_nip=' + penerima_uang_nip +
                $.ajax({
                    type:"POST",
                    url :"<?=site_url("kuitansi/submit_kuitansi")?>",
                    data:data,
                    success:function(data){
//                        console.log(data)
                            location.reload();
                    }
                });


            }
            }else{
                alert('Silahkan diperiksa isiannya dahulu !');
            }

        });

});

function refresh_row(){

	// $("#row_space").load("<?=site_url('tor/get_row')?>");

}


function string_to_angka(str){

        return str.split('.').join("");

}

function angka_to_string(num){

        var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        return str_hasil;
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

function get_total_pajak(){
    var total = 0 ;
    $('[id^="pj_nilai_"]').each(function(){
        var nilai_ = ($(this).val() == '' ? '0' : $(this).val()) ;
        var nilai = parseInt(string_to_angka(nilai_));
        total = total + nilai ;
    });
    $('#total_pajak').text(angka_to_string(total));
}

function get_total_pajak_edit(){
    var total = 0 ;
    $('[id^="edit_pj_nilai_"]').each(function(){
        var nilai_ = ($(this).val() == '' ? '0' : $(this).val()) ;
        var nilai = parseInt(string_to_angka(nilai_));
        total = total + nilai ;
    });
    $('#edit_total_pajak').text(angka_to_string(total));
}


</script>
<?php
$tgl=getdate();
$cur_tahun=$tgl['year']+1;
  // tambahan style dari dhanu
?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>DETAIL SUB KEGIATAN</h2>
                   </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-lg-12">
<table class="table table-striped table-bordered">
<!--
<tr>
	<td class="col-md-2">Tujuan</td>
	<td><span id="kode_kegiatan"><?=$tor_usul->kode_kegiatan?></span> - <?=$tor_usul->nama_kegiatan?></td>
</tr>
<tr>
	<td class="col-md-2">Sasaran</td>
	<td><span id="kode_sasaran"><?=$tor_usul->kode_output?></span> - <?=$tor_usul->nama_output?></td>
</tr>
-->
<tr>
	<td class="col-md-2">Program</td>
	<td><span id="kode_program"><?=$tor_usul->kode_program?></span> - <?=$tor_usul->nama_program?></td>
</tr>
<tr>
	<td class="col-md-2">Kegiatan</td>
	<td><span id="kode_komponen"><?=$tor_usul->kode_komponen?></span> - <?=$tor_usul->nama_komponen?></td>
</tr>
<tr>
	<td class="col-md-2">Sub Kegiatan</td>
        <td><span id="kode_subkomponen"><?=$tor_usul->kode_subkomponen?></span> - <span id="nm_subkomponen"><?=$tor_usul->nama_subkomponen?></span></td>
</tr>
</table>

<table class="table table-striped table-bordered" >
<tr class="alert alert-danger"style="font-weight: bold">
	<td class="col-md-2">Sumber Dana</td>
        <td><span id="kode_sumber_dana"><?=$sumber_dana?></span></td>
</tr>
<tr class="">
	<td class="col-md-2">Ket</td>
	<td>
            <span class="label label-success">&nbsp;</span> : siap diusulkan &nbsp;&nbsp;<span class="label label-danger">&nbsp;</span> : sedang diproses &nbsp;&nbsp;<span class="label label-info">&nbsp;</span> : telah disetujui
        </td>

</tr>
</table>
                        <div class="alert alert-warning col-sm-8">
                          <?php
                            if($jenis!=2){
                          ?>
                            <button type="button" class="btn btn-warning" id="btn-kuitansi" rel="" disabled="disabled" ><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Buat Kuitansi</button>
                          <?php }else{ ?>
                            <button type="button" class="btn btn-primary" id="btn-buat-ls" rel="" style="display: none;"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Buat SPP LSP</button>
                          <?php } ?>
                        </div>

			<div id="temp" style="display:none"></div>
                        <div id="o-table">
                        <table class="table">
                            <thead>
                                <tr >
                                    <th class="col-md-1" >Akun</th>
                                    <th class="col-md-3" >Rincian</th>
                                    <th class="col-md-1" >Volume</th>
                                    <th class="col-md-1" >Satuan</th>
                                    <th class="col-md-2" >Harga</th>
                                    <th class="col-md-2" >Jumlah</th>
                                    <th class="col-md-1" style="text-align:center">&nbsp;</th>
                                    <th class="col-md-1" style="text-align:center">Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="row_space">
                                <?php $total_ = 0 ;?>
                                <?php $temp_text_unit = '' ;?>
                                <?php $temp_text_akun = '' ;?>
                                <?php $i_row = 0 ; ?>
                                <?php $total_per_akun = 0 ;?>
                                <?php $impor = 0 ; ?>
                                <?php foreach($detail_akun_rba as $u){ ?>
                                    <?php if($temp_text_unit != $u->nama_subunit.$u->nama_sub_subunit): ?>
                                    <tr id="tr_empty_<?=$u->kode_usulan_belanja?>">
                                        <td colspan="8">&nbsp;</td>
                                    </tr>
                                    <tr id="tr_unit_<?=$u->kode_usulan_belanja?>" class="alert alert-info" height="25px">
                                        <td colspan="8"><b><?='<span class="text-warning">'.$u->nama_subunit.'</span> : <span class="text-success">'.$u->nama_sub_subunit.'</span>'?></b></td>
                                    </tr>

                                        <?php $temp_text_unit = $u->nama_subunit.$u->nama_sub_subunit; ?>
                                        <?php $temp_text_akun = '' ;?>
                                    <?php endif; ?>
                                    <?php if($temp_text_akun != $u->kode_akun): ?>
                                    <tr id="tr_akun_<?=$u->kode_usulan_belanja?>" height="25px" class="text-danger">
                                        <td colspan="7"><b><?=$u->kode_akun.' : <span id="nm_akun_'.$u->kode_usulan_belanja.'">'.$u->nama_akun.'</span>'?></b></td>
                                        <td >
                                            <div class="input-group">
                                                <span class="input-group-addon" style="background-color: #f9ff83">
                                                    <input type="checkbox" aria-label="" rel="<?=$u->kode_usulan_belanja?>" class="all_ck_<?php echo $u->kode_usulan_belanja ;?>">
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                        <?php $temp_text_akun = $u->kode_akun; ?>
                                        <?php $total_per_akun = 0 ;?>
                                    <?php else: ?>
                                        <!--<td colspan="8">&nbsp;</td>-->
                                    <?php endif; ?>

                                    <?php foreach($detail_rsa_dpa as $ul){ ?>
                                        <?php $impor = $ul->impor; ?>
                                        <?php if(( $ul->kode_usulan_belanja == $u->kode_usulan_belanja) && (substr($ul->proses,1,1) == $jenis) ): ?>
                                            <tr id="tr_<?=$ul->kode_usulan_belanja?><?php echo $ul->kode_akun_tambah ;?>" height="25px">
                                                <td style="text-align: right">
                                                    <?php if(substr($ul->proses,1,1)=='1'){echo '<span class="badge badge-gup" id="badge_id_'.$ul->kode_usulan_belanja.$ul->kode_akun_tambah.'">GP</span>';}elseif(substr($ul->proses,1,1)=='2'){echo '<span class="badge badge-ls" id="badge_id_'.$ul->kode_usulan_belanja.$ul->kode_akun_tambah.'">LS</span>';}elseif(substr($ul->proses,1,1)=='3'){echo '<span class="badge badge-tup" id="badge_id_'.$ul->kode_usulan_belanja.$ul->kode_akun_tambah.'">TP</span>';}elseif(substr($ul->proses,1,1)=='4'){echo '<span class="badge badge-ks" id="badge_id_'.$ul->kode_usulan_belanja.$ul->kode_akun_tambah.'">KS</span>';}else{} ?> <?=$ul->kode_akun_tambah?>
                                                </td>
                                                <td ><?=$ul->deskripsi?></td>
                                                <td ><?=$ul->volume?></td>
                                                <td ><?=$ul->satuan?></td>
                                                <td style="text-align: right"><?=number_format($ul->harga_satuan, 0, ",", ".")?></td>
                                                <td style="text-align: right" id="td_sub_tot_<?=$ul->kode_usulan_belanja?><?=$ul->kode_akun_tambah?>">
                                                    <?php $total_ = $total_ + ($ul->volume*$ul->harga_satuan); ?>
                                                    <?php $total_per_akun = $total_per_akun + ($ul->volume*$ul->harga_satuan); ?>
                                                    <?=number_format($ul->volume*$ul->harga_satuan, 0, ",", ".")?>
                                                </td>


                                                <?php if($ul->proses == 0) : ?>

                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
<!--                                                    <div class="btn-group">
                                                        <button type="button" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-default btn-sm" onclick="doedit('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this)" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-default btn-sm" id="delete_<?=$ul->id_rsa_detail?>" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>-->
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm" rel="<?php echo $ul->id_rsa_detail ;?>" id="proses_<?php echo $ul->id_rsa_detail ;?>" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Proses</button>
                                                </td>
                                                <?php elseif(substr($ul->proses,0,1) == 2): ?>
                                                <td align="center">
                                                  <?php if(is_null($ul->id_kuitansi)): ?>
                                                      <button type="button" class="btn btn-danger btn-sm btn_batal" rel="<?=$ul->kode_usulan_belanja?><?=$ul->kode_akun_tambah?>">Batal</button>
                                                  <?php endif;?>
                                                </td>
                                                <td>
                                                    <!--<button type="button" class="btn btn-success btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Buat SPP</button>-->
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <?php if(is_null($ul->id_kuitansi)): ?>
                                                                <input type="checkbox" aria-label="" rel="<?=$ul->kode_usulan_belanja?><?=$ul->kode_akun_tambah?>" class="ck_<?php echo $ul->kode_usulan_belanja ;?><?=$ul->kode_akun_tambah?>">
                                                            <?php else: ?>
                                                                <input type="checkbox" disabled="disabled" checked="checked" aria-label="" rel="" class="">
                                                            <?php endif;?>

                                                        </span>
                                                    </div>
                                                </td>
                                                <?php else: ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
<!--                                                    <div class="btn-group">
                                                        <button type="button" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>-->
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Proses</button>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                              <td colspan="8">ini aneh</td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php } ?>
                                    <!--
                                    <tr id="form_add_detail_<?=$u->kode_usulan_belanja?>" class="alert alert-success">
                                            <td >
                                                <input name="revisi" id="revisi_<?=$u->kode_usulan_belanja?>" type="hidden" value="<?=$u->revisi?>" />
                                                <input name="impor" id="impor_<?=$u->kode_usulan_belanja?>" type="hidden" value="<?=$impor?>" />
                                                <input name="kode_akun_tambah" class="form-control" rel="<?=$u->kode_usulan_belanja?>" id="kode_akun_tambah_<?=$u->kode_usulan_belanja?>" type="text" value="" readonly="readonly" />
                                            </td>
                                            <td >
                                                <textarea name="deskripsi" class="validate[required] form-control" rel="<?=$u->kode_usulan_belanja?>" id="deskripsi_<?=$u->kode_usulan_belanja?>" rows="1"></textarea>
                                            </td>
                                            <td ><input name="volume" class="validate[required,custom[integer],min[1]] calculate form-control xnumber" rel="<?=$u->kode_usulan_belanja?>" id="volume_<?=$u->kode_usulan_belanja?>" type="text" value="" /></td>
                                            <td ><input name="satuan" class="validate[required,maxSize[30]] form-control" rel="<?=$u->kode_usulan_belanja?>" id="satuan_<?=$u->kode_usulan_belanja?>" type="text" value="" /></td>
                                            <td ><input name="tarif" class="validate[required,custom[integer],min[1]] calculate form-control xnumber" rel="<?=$u->kode_usulan_belanja?>" id="tarif_<?=$u->kode_usulan_belanja?>" type="text" value="" /></td>
                                            <td ><input name="jumlah" rel="<?=$u->kode_usulan_belanja?>" id="jumlah_<?=$u->kode_usulan_belanja?>" type="text" class="form-control" readonly="readonly" value="" /></td>
                                            <td align="center" >
                                                    <div class="btn-group">
                                                                    <button type="button" class="btn btn-default btn-sm" rel="<?=$u->kode_usulan_belanja?>" id="tambah_<?=$u->kode_usulan_belanja?>" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                                                                    <button type="button" class="btn btn-default btn-sm" rel="<?=$u->kode_usulan_belanja?>" id="reset_<?=$u->kode_usulan_belanja?>" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>


                                                            </div>
                                            </td>
                                            <td>&nbsp;</td>
                                    </tr>
                                    -->
                                    <tr class="alert alert-danger" id="tr_usulan_<?=$u->kode_usulan_belanja?>">
                                        <td colspan="4" style="text-align: right;">Usulan</td>
                                        <td style="text-align: right;">:</td>
                                        <td style="text-align: right;" rel="<?=$u->kode_usulan_belanja?>" id="td_usulan_<?=$u->kode_usulan_belanja?>"><?=number_format($u->total_harga, 0, ",", ".")?></td>
                                        <td >&nbsp;</td>
                                        <td >&nbsp;</td>
                                    </tr>
                                    <tr class="alert alert-info" id="tr_total_<?=$u->kode_usulan_belanja?>">
                                            <td colspan="4" style="text-align: right;">Total</td>
                                            <td style="text-align: right;">:</td>
                                            <td style="text-align: right;" rel="<?=$u->kode_usulan_belanja?>" id="td_kumulatif_<?=$u->kode_usulan_belanja?>"><?=number_format($total_per_akun, 0, ",", ".")?></td>
                                            <td >&nbsp;</td>
                                            <td >&nbsp;</td>
                                    </tr>
                                    <tr  class="alert alert-warning" id="tr_sisa_<?=$u->kode_usulan_belanja?>">
                                            <td colspan="4" style="text-align: right;">Sisa</td>
                                            <td style="text-align: right;">:</td>
                                            <td style="text-align: right;" id="td_kumulatif_sisa_<?=$u->kode_usulan_belanja?>"><?=number_format(($u->total_harga - $total_per_akun), 0, ",", ".")?></td>
                                            <td >&nbsp;</td>
                                            <td >&nbsp;</td>
                                    </tr>
                                    <?php $i_row++; ?>



                                <?php } ?>
                                    <tr id="" height="25px">
                                        <td colspan="8">&nbsp;</td>
                                    </tr>
                                    <tr id="" height="25px" class="alert alert-info" style="font-weight: bold">
                                        <td colspan="4" style="text-align: center">Total </td>
                                        <td style="text-align: right">:</td>
                                        <td style="text-align: right"><?=number_format($total_, 0, ",", ".")?></td>
                                        <td >&nbsp;</td>
                                        <td >&nbsp;</td>
                                    </tr>

                            </tbody>
                        </table>
                        <!--
                        <div class="alert alert-warning" style="text-align:center">

                                <button type="button" class="btn btn-warning" name="backi" id="backi" ><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</button>
                                <button type="button" class="btn btn-success" name="proses" id="proses" ><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> Usulkan</button>

                        </div>
                        -->


                        </div>

	    </div>
	  </div>
</div>
</div>
<!-- POP UP PILIH PENCAIRAN -->
<div class="modal " id="myModalKuitansi" role="dialog" aria-labelledby="myModalKuitansiLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel">Kuitansi : <span id="kode_badge">-</span></h4>
          </div>
          <div class="modal-body" style="margin:15px;padding:0px;padding-bottom: 15px;">
              <table id="kuitansi" style="font-family:tahoma;line-height: 25px; border-collapse: separate;width: auto;border: 1px solid #000;" cellspacing="0px" border="0">
                  <tr>
                                <td rowspan="3" style="text-align: center">
					<img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
				</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >Tahun Anggaran</td>
                                <td style="text-align: center">:</td>
                                <td ><?=$tahun?></td>
                        </tr>
                        <tr>
                            <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >Nomor Bukti</td>
                                <td style="text-align: center">:</td>
                                <td id="no_bukti">-</td>
                        </tr>
                        <tr>
                            <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >Anggaran</td>
                                <td style="text-align: center">:</td>
                                <td id="txt_akun">-</td>

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
			<tr>
				<td>Sudah Diterima dari</td>
				<td>: </td>
                                <td colspan="9">Pejabat Pembuat Komitmen/ Pejabat Pelaksana dan Pengendali Kegiatan SUKPA <?=$nm_unit?>
				</td>
			</tr>
			<tr>
				<td>Jumlah Uang</td>
				<td>: </td>
                                <td colspan="9"><b>Rp. <span class="sum_tot_netto">0</span>,-</b></td>
			</tr>
			<tr>
				<td>Terbilang</td>
				<td>: </td>
                                <td colspan="9"><b><span class="text_tot">-</span></b></td>
			</tr>
			<tr>
				<td>Untuk Pembayaran</td>
				<td>: </td>
                                <td colspan="9" ><span class="edit_here" contenteditable="true" placeheld="yes" id="uraian">- edit here -</span></td>
			</tr>
			<tr>
				<td>Sub Kegiatan</td>
				<td>: </td>
                                <td colspan="9"><span id="nm_subkomponen_kuitansi">-</span></td>
			</tr>
                        <tr>
                                <td colspan="10">
                                    &nbsp;
				</td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Deskripsi</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Kuantitas</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Satuan</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Harga@</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Bruto</b></td>
                            <td style="padding: 0 5px 0 5px;" colspan="2"><b>Pajak</b></td>
                            <td >&nbsp;</td>
                            <td ><b>Netto</b></td>
			</tr>
                        <tr id="tr_isi">
                            <td colspan="11">tr_si</td>
			<tr>
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
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y"); ?><br />
                                Penerima Uang
                            </td>
			</tr>
                        <tr>
                                <td colspan="11">
                                    &nbsp;
				</td>
                        </tr>
                        <tr >
                            <td colspan="8" style="border-bottom: 1px solid #000"><?=$pic_kuitansi['pppk_nm_lengkap']?><br>
                                    NIP. <?=$pic_kuitansi['pppk_nip']?></td>
                            <td colspan="3" style="border-bottom: 1px solid #000"><span class="edit_here" contenteditable="true" id="penerima_uang">- edit here -</span><br />
                                <!--NIP. <span class="edit_here" contenteditable="true" id="penerima_uang_nip">- edit here -</span></td>-->
			</tr>
                        <tr >
                            <td colspan="8">Setuju dibayar Tanggal, <br>
                                Bendahara Pengeluaran
                            </td>
                            <td colspan="3">Lunas dibayar Tanggal,<br>
                                Pemegang Uang Kerja/ Bendahara Pengeluaran
                            </td>
                        </tr>
                        <tr>
                                <td colspan="11">
                                    &nbsp;
				</td>
                        </tr>
                         <tr>
                            <td colspan="8"><?=$pic_kuitansi['bendahara_nm_lengkap']?><br>
                                NIP. <?=$pic_kuitansi['bendahara_nip']?>
                            </td>
                            <td colspan="3"><?=$pic_kuitansi['pumk_nm_lengkap']?><br>
                                NIP. <?=$pic_kuitansi['pumk_nip']?>
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
                                    &nbsp;
				</td>
                        </tr>
                        <tr>
                            <td colspan="11" ><span class="edit_here" contenteditable="true" id="penerima_barang">- edit here -</span><br />
                                    NIP. <span class="edit_here" contenteditable="true" id="penerima_barang_nip">- edit here -</span>
				</td>
			</tr>

		</table>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-submit-kuitansi" rel="" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
          </div>
        </div>
    </div>
</div>

<!-- MODAL SELECT PAJEK -->
<div class="modal fade" id="myModalPajak" rel="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title">Pemotongan Pajak</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">
                <table class="table input-pjk">
                    <thead>
                        <tr><th>Jenis</th><th>DPP </th><th>Nilai</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class=""></td>
                        </tr>
                                                <tr>
                            <td colspan="3" class="alert-info"><b>PPN</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input name="pajak[0][0]" type="checkbox" rel="1_ppn" id="pj_p_1" class="pj_p_ppn" value="10" />
                                      10%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input disabled="disabled" name="pajak[0][1]" rel="1" id="pj_dpp_1" class="pj_dpp_ppn" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input class="form-control input-sm pj_nilai_ppn" disabled="disabled" name="pajak[0][2]" id="pj_nilai_1" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-warning"><b>PPh Ps 21</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="2_pphps21" id="pj_p_2" class="pj_p_pphps21" value="5" name="pajak[1][0]" type="checkbox"  />
                                      5%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="2" id="pj_dpp_2" class="pj_dpp_pphps21" disabled="disabled" name="pajak[1][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input class="form-control input-sm pj_nilai_pphps21" id="pj_nilai_2" disabled="disabled" name="pajak[1][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="3_pphps21" id="pj_p_3" name="pajak[2][0]" type="checkbox" class="pj_p_pphps21" value="15" />
                                      15%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="3" id="pj_dpp_3" class="pj_dpp_pphps21" disabled="disabled" name="pajak[2][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input class="form-control input-sm pj_nilai_pphps21" id="pj_nilai_3" disabled="disabled" name="pajak[2][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="4_pphps21" id="pj_p_4" name="pajak[3][0]" type="checkbox" class="pj_p_pphps21" value="6" />
                                      6%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="4" id="pj_dpp_4" class="pj_dpp_pphps21" disabled="disabled" name="pajak[3][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input class="form-control input-sm pj_nilai_pphps21" id="pj_nilai_4" disabled="disabled" name="pajak[3][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="5_pphps21" id="pj_p_5" name="pajak[4][0]" type="checkbox" class="pj_p_pphps21" value="0" />
                                      0%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="5" id="pj_dpp_5" class="pj_dpp_pphps21" disabled="disabled" name="pajak[4][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_5" class="form-control input-sm pj_nilai_pphps21" disabled="disabled" name="pajak[4][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-warning"><b>PPh Ps 22</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="6_pphps22" id="pj_p_6" class="pj_p_pphps22" value="1.5" name="pajak[5][0]" type="checkbox" value="1.5" />
                                      1.5%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="6" id="pj_dpp_6" class="pj_dpp_pphps22" disabled="disabled" name="pajak[5][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_6" class="form-control input-sm pj_nilai_pphps22" disabled="disabled" name="pajak[5][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="7_pphps22" id="pj_p_7" class="pj_p_pphps22" value="3" name="pajak[6][0]" type="checkbox" />
                                      3%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="7" id="pj_dpp_7" disabled="disabled" class="pj_dpp_pphps22" name="pajak[6][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_7" class="form-control input-sm pj_nilai_pphps22" disabled="disabled" name="pajak[6][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-warning"><b>PPh Ps 23</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="8_pphps23" id="pj_p_8" class="pj_p_pphps23" value="2" name="pajak[7][0]" type="checkbox" />
                                      2%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="8" id="pj_dpp_8" disabled="disabled" class="pj_dpp_pphps23" disabled="disabled" name="pajak[7][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_8" class="form-control input-sm pj_nilai_pphps23" disabled="disabled" name="pajak[7][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="9_pphps23" id="pj_p_9" class="pj_p_pphps23" value="4" name="pajak[8][0]" type="checkbox" />
                                      4%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="9" id="pj_dpp_9" disabled="disabled" class="pj_dpp_pphps23" disabled="disabled" name="pajak[8][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_9" class="form-control input-sm pj_nilai_pphps23" disabled="disabled" name="pajak[8][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="10_pphps23" id="pj_p_10" value="15" class="pj_p_pphps23" name="pajak[9][0]" type="checkbox" />
                                      15%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="10" id="pj_dpp_10" disabled="disabled" class="pj_dpp_pphps23" name="pajak[9][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_10" class="form-control input-sm pj_nilai_pphps23" disabled="disabled" name="pajak[9][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-warning"><b>PPh Ps 26</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="11_pphps26" id="pj_p_11" value="20" class="pj_p_pphps26" name="pajak[10][0]" type="checkbox" />
                                      20%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="11" id="pj_dpp_11" disabled="disabled" class="pj_dpp_pphps26" disabled="disabled" name="pajak[10][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_11" class="form-control input-sm pj_nilai_pphps26" disabled="disabled" name="pajak[10][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-warning"><b>PPh Ps 4(2)</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="12_pphps42" id="pj_p_12" value="2" class="pj_p_pphps42" name="pajak[11][0]" type="checkbox" />
                                      2%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="12" id="pj_dpp_12" disabled="disabled" class="pj_dpp_pphps42" disabled="disabled" name="pajak[11][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_12" class="form-control input-sm pj_nilai_pphps42" disabled="disabled" name="pajak[11][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="13_pphps42" id="pj_p_13" value="3" class="pj_p_pphps42" name="pajak[12][0]" type="checkbox" />
                                      3%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="13" id="pj_dpp_13" disabled="disabled" class="pj_dpp_pphps42" disabled="disabled" name="pajak[12][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_13" class="form-control input-sm pj_nilai_pphps42" disabled="disabled" name="pajak[12][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="14_pphps42" id="pj_p_14" value="4" class="pj_p_pphps42" name="pajak[13][0]" type="checkbox" />
                                      4%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="14" id="pj_dpp_14" disabled="disabled" class="pj_dpp_pphps42" disabled="disabled" name="pajak[13][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_14" class="form-control input-sm pj_nilai_pphps42" disabled="disabled" name="pajak[13][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="15_pphps42" id="pj_p_15" value="10" class="pj_p_pphps42" name="pajak[14][0]" type="checkbox" />
                                      10%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="15" id="pj_dpp_15" disabled="disabled" class="pj_dpp_pphps42" disabled="disabled" name="pajak[14][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_15" class="form-control input-sm pj_nilai_pphps42" disabled="disabled" name="pajak[14][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-success"><b>Lainnya</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="16_lainnya" id="pj_p_16" class="pj_p_lainnya" name="pajak[15][0]" type="checkbox" value="99" />
                                      Lainnya
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                      <input rel="16" id="pj_dpp_16" disabled="disabled" class="pj_dpp_lainnya" disabled="disabled" name="pajak[15][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_16" class="form-control input-sm pj_nilai_lainnya xnumber" disabled="disabled" name="pajak[15][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class=""></td>
                        </tr>
                        <tr class="alert-danger" style="font-weight: bold">
                            <td style="padding: 10px;">
                                Total
                            </td>
                            <td style="padding: 10px;">
                                :
                            </td>
                            <td id="total_pajak" style="padding: 10px;text-align: right">0</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-submit-pajak" rel="" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL EDIT PAJEK -->
<div class="modal fade" id="myModalPajakEdit" rel="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title">Pemotongan Pajak</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">
                <table class="table input-pjk">
                    <thead>
                        <tr><th>Jenis</th><th>DPP </th><th>Nilai</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class=""></td>
                        </tr>
                                                <tr>
                            <td colspan="3" class="alert-info"><b>PPN</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input name="pajak[0][0]" type="checkbox" rel="1_ppn" id="edit_pj_p_1" class="edit_pj_p_ppn" value="10" />
                                      10%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input disabled="disabled" name="pajak[0][1]" rel="1" id="edit_pj_dpp_1" class="edit_pj_dpp_ppn" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input class="form-control input-sm edit_pj_nilai_ppn" disabled="disabled" name="pajak[0][2]" id="edit_pj_nilai_1" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-warning"><b>PPh Ps 21</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="2_pphps21" id="edit_pj_p_2" class="edit_pj_p_pphps21" value="5" name="pajak[1][0]" type="checkbox"  />
                                      5%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="2" id="edit_pj_dpp_2" class="edit_pj_dpp_pphps21" disabled="disabled" name="pajak[1][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input class="form-control input-sm edit_pj_nilai_pphps21" id="edit_pj_nilai_2" disabled="disabled" name="pajak[1][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="3_pphps21" id="edit_pj_p_3" name="pajak[2][0]" type="checkbox" class="edit_pj_p_pphps21" value="15" />
                                      15%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="3" id="edit_pj_dpp_3" class="edit_pj_dpp_pphps21" disabled="disabled" name="pajak[2][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input class="form-control input-sm edit_pj_nilai_pphps21" id="edit_pj_nilai_3" disabled="disabled" name="pajak[2][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="4_pphps21" id="edit_pj_p_4" name="pajak[3][0]" type="checkbox" class="edit_pj_p_pphps21" value="6" />
                                      6%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="4" id="edit_pj_dpp_4" class="edit_pj_dpp_pphps21" disabled="disabled" name="pajak[3][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input class="form-control input-sm edit_pj_nilai_pphps21" id="edit_pj_nilai_4" disabled="disabled" name="pajak[3][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="5_pphps21" id="edit_pj_p_5" name="pajak[4][0]" type="checkbox" class="edit_pj_p_pphps21" value="0" />
                                      0%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="5" id="edit_pj_dpp_5" class="edit_pj_dpp_pphps21" disabled="disabled" name="pajak[4][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_5" class="form-control input-sm edit_pj_nilai_pphps21" disabled="disabled" name="pajak[4][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-warning"><b>PPh Ps 22</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="6_pphps22" id="edit_pj_p_6" class="edit_pj_p_pphps22" value="1.5" name="pajak[5][0]" type="checkbox" value="1.5" />
                                      1.5%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="6" id="edit_pj_dpp_6" class="edit_pj_dpp_pphps22" disabled="disabled" name="pajak[5][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_6" class="form-control input-sm edit_pj_nilai_pphps22" disabled="disabled" name="pajak[5][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="7_pphps22" id="edit_pj_p_7" class="edit_pj_p_pphps22" value="3" name="pajak[6][0]" type="checkbox" />
                                      3%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="7" id="edit_pj_dpp_7" disabled="disabled" class="edit_pj_dpp_pphps22" name="pajak[6][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_7" class="form-control input-sm edit_pj_nilai_pphps22" disabled="disabled" name="pajak[6][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-warning"><b>PPh Ps 23</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="8_pphps23" id="edit_pj_p_8" class="edit_pj_p_pphps23" value="2" name="pajak[7][0]" type="checkbox" />
                                      2%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="8" id="edit_pj_dpp_8" disabled="disabled" class="edit_pj_dpp_pphps23" disabled="disabled" name="pajak[7][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_8" class="form-control input-sm edit_pj_nilai_pphps23" disabled="disabled" name="pajak[7][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="9_pphps23" id="edit_pj_p_9" class="edit_pj_p_pphps23" value="4" name="pajak[8][0]" type="checkbox" />
                                      4%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="9" id="edit_pj_dpp_9" disabled="disabled" class="edit_pj_dpp_pphps23" disabled="disabled" name="pajak[8][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_9" class="form-control input-sm pj_nilai_pphps23" disabled="disabled" name="pajak[8][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="10_pphps23" id="edit_pj_p_10" value="15" class="edit_pj_p_pphps23" name="pajak[9][0]" type="checkbox" />
                                      15%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="10" id="edit_pj_dpp_10" disabled="disabled" class="edit_pj_dpp_pphps23" name="pajak[9][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_10" class="form-control input-sm edit_pj_nilai_pphps23" disabled="disabled" name="pajak[9][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-warning"><b>PPh Ps 26</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="11_pphps26" id="edit_pj_p_11" value="20" class="edit_pj_p_pphps26" name="pajak[10][0]" type="checkbox" />
                                      20%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="11" id="edit_pj_dpp_11" disabled="disabled" class="edit_pj_dpp_pphps26" disabled="disabled" name="pajak[10][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_11" class="form-control input-sm edit_pj_nilai_pphps26" disabled="disabled" name="pajak[10][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-warning"><b>PPh Ps 4(2)</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="12_pphps42" id="edit_pj_p_12" value="2" class="edit_pj_p_pphps42" name="pajak[11][0]" type="checkbox" />
                                      2%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="12" id="edit_pj_dpp_12" disabled="disabled" class="edit_pj_dpp_pphps42" disabled="disabled" name="pajak[11][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_12" class="form-control input-sm edit_pj_nilai_pphps42" disabled="disabled" name="pajak[11][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="13_pphps42" id="edit_pj_p_13" value="3" class="edit_pj_p_pphps42" name="pajak[12][0]" type="checkbox" />
                                      3%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="13" id="edit_pj_dpp_13" disabled="disabled" class="edit_pj_dpp_pphps42" disabled="disabled" name="pajak[12][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_13" class="form-control input-sm edit_pj_nilai_pphps42" disabled="disabled" name="pajak[12][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="14_pphps42" id="edit_pj_p_14" value="4" class="edit_pj_p_pphps42" name="pajak[13][0]" type="checkbox" />
                                      4%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="14" id="edit_pj_dpp_14" disabled="disabled" class="edit_pj_dpp_pphps42" disabled="disabled" name="pajak[13][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_14" class="form-control input-sm edit_pj_nilai_pphps42" disabled="disabled" name="pajak[13][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="15_pphps42" id="edit_pj_p_15" value="10" class="edit_pj_p_pphps42" name="pajak[14][0]" type="checkbox" />
                                      10%
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="15" id="edit_pj_dpp_15" disabled="disabled" class="edit_pj_dpp_pphps42" disabled="disabled" name="pajak[14][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_15" class="form-control input-sm edit_pj_nilai_pphps42" disabled="disabled" name="pajak[14][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="alert-success"><b>Lainnya</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="16_lainnya" id="edit_pj_p_16" class="edit_pj_p_lainnya" name="pajak[15][0]" type="checkbox" value="99" />
                                      Lainnya
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                      <input rel="16" id="edit_pj_dpp_16" disabled="disabled" class="edit_pj_dpp_lainnya" disabled="disabled" name="pajak[15][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_16" class="form-control input-sm edit_pj_nilai_lainnya xnumber" disabled="disabled" name="pajak[15][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class=""></td>
                        </tr>
                        <tr class="alert-danger" style="font-weight: bold">
                            <td style="padding: 10px;">
                                Total
                            </td>
                            <td style="padding: 10px;">
                                :
                            </td>
                            <td id="edit_total_pajak" style="padding: 10px;text-align: right">0</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-edit-pajak" rel="" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Edit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
            </div>
        </div>
    </div>
</div>

<!--// CREATED BY DHANU - DELETE BUT CONFIRM IF CAUSED ERROR //-->
<!-- dibuat oleh dhanu -->
<div class="modal" id="myModalMessage" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp;&nbsp;&nbsp;Perhatian :</h4>
          </div>
          <div class="modal-body message_sppls" style="margin:15px;padding:0px;padding-bottom: 15px;">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> OK</button>
          </div>
        </div>
    </div>
</div>

<div class="modal" id="myModalBatal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp;&nbsp;&nbsp;Perhatian :</h4>
          </div>
          <div class="modal-body" style="margin:15px;padding:0px;padding-bottom: 15px;">
            <div class="alert alert-danger">
              Anda akan menghapus sebuah DPA ?<br />
              Hal ini akan mempengaruhi SPP dan SPM yang sedang berlangsung.<br/>
              <p class="small">*) SPP dan SPM yang sedang berlangsung otomatis akan dibatalkan/tolak.</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm yakin_batal"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Ya</button>
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Ndak</button>
          </div>
        </div>
    </div>
</div>
<!-- end here dhanu -->
<!-- // END HERE // -->
