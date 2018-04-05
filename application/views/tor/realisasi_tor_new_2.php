<?php // setlocale(LC_ALL, 'id_ID.utf8'); echo 'tgl : '  .strftime("%d %B %b %Y") . strftime("%d %B %b %Y", strtotime('2016-11-11')); die; ?>
<?php
    if($this->cantik_model->manual_override()){
?>
<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
$(function(){
    $('.kepeg_numeric').inputmask("numeric", {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 0,
        autoGroup: true,
        rightAlign: true,
        oncleared: function () { $(this).val('0'); }
    });
});
</script>
<?php
    }
?>
<script type="text/javascript">


// TAMBAH PANEL TAMBAH //

var scrollEventHandler = function() {
    if($('#panel-jml-show').visible()) {
            // $('#panel-jml').animate({'right': '-=30px'},'slow');
            $('#panel-jml').hide();
            // unbindScrollEventHandler();

        } else {

            if($('#tb-data').visible()){
                    $('#panel-jml').show();
                    // on = '1' ;
                    // console.log('0') ;

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
    return isVisible;
}

// END PANEL //

var in_kode = 0;
//var in_all = 0;
var pj_p_kode_usulan_all = [];
var pj_p_id_all = [];
var pj_p_jenis_all = [];
var pj_p_persen_all = [];
var pj_p_dpp_all = [];
var pj_p_nilai_all = [];

$(document).ready(function(){

    // $(document).ready(function(){

    var un = '<?php echo $this->uri->segment(5); ?>';

    if((un=='1') || (un=='3')){

        /*
        bootbox.alert({
            title: "PESAN",
            message: "SEKARANG SILAHKAN BUAT KUITANSI SEBANYAK-BANYAKNYA.<br>THX.",
        });
        */

    }

    autosize($('textarea'));


    $('.btn-ajx').each(function(){

        var rka = $(this).attr('rel');
        var el = $(this) ;
        $.ajax({
              type:"POST",
              url :"<?php echo site_url("tor/get_status_dpa"); ?>",
              data:'rka=' + rka +'&sumber_dana=' + '<?=$sumber_dana?>' + '&tahun=' + '<?=$cur_tahun?>' ,
              success:function(data){

                    if(data!=''){

                        var d = JSON.parse(data);
                        // if(d.no_bukti)
                        var s = d.proses;
                        var u = '<?php echo $this->uri->segment(5); ?>';

                        if(s.substr(0, 1) == '3'){
                            if((u=='1') || (u=='3') || (u=='4') || (u=='5') || (u=='6')  || (u=='7')){ // GUP , TP , KS , LN , dan LK
                                if(d.aktif=='1'){
                                    el.addClass('btn-primary');
                                    el.html('<i class="glyphicon glyphicon-file"></i>');
                                    el.attr('title','STATUS : KUITANSI');
                                    el.attr('data-original-title','STATUS : KUITANSI');
                                    el.attr('onclick','bootbox.alert("STATUS : KUITANSI <br>KUITANSI : '+ d.no_bukti +'")') ;

                                    //<input type="checkbox" disabled="disabled" checked="checked" aria-label="" rel="" class="">

                                    $('.ck_' + rka).prop('disabled','disabled');
                                    $('.ck_' + rka).prop('checked','checked');
                                    $('.ck_' + rka).prop('rel','');
                                    $('.ck_' + rka).prop('class','');
                                }else{
                                    el.addClass('btn-danger');
                                    el.addClass('btn_batal');
                                    el.attr('title','BATALKAN DPA !');
                                    el.attr('data-original-title','BATALKAN DPA !');
                                    el.removeAttr('onclick') ;
                                    el.html('<i class="glyphicon glyphicon-remove-sign"></i>');
                                }
                            }else if(u=='2'){ // LS PEGAWAI
                                    el.addClass('btn-danger');
                                    el.addClass('btn_batal');
                                    el.attr('title','BATALKAN DPA !');
                                    el.attr('data-original-title','BATALKAN DPA !');
                                    el.removeAttr('onclick') ;
                                    el.html('<i class="glyphicon glyphicon-remove-sign"></i>');
                            }

                        }else if(s.substr(0, 1) == '4'){
                                el.addClass('btn-warning');
                                el.html('<i class="glyphicon glyphicon-file"></i>');
                                el.attr('title','STATUS : SPP');
                                el.attr('data-original-title','STATUS : SPP');
                                el.attr('onclick','bootbox.alert("STATUS : SPP <br>KUITANSI : '+ d.no_bukti +'<br>SPP : '+ d.str_nomor_trx +'")') ;
                        }else if(s.substr(0, 1) == '5'){
                                el.addClass('btn-success');
                                el.attr('title','STATUS : SPM');
                                el.attr('data-original-title','STATUS : SPM');
                                el.attr('onclick','bootbox.alert("STATUS : SPM <br>KUITANSI : '+ d.no_bukti +'<br>SPP : '+ d.str_nomor_trx +'<br>SPM : '+ d.str_nomor_trx_spm +'")') ;
                                el.html('<i class="glyphicon glyphicon-file"></i>');
                        }else if(s.substr(0, 1) == '6'){
                                el.addClass('btn-info');
                                el.attr('title','STATUS : CAIR');
                                el.attr('data-original-title','STATUS : CAIR');
                                el.attr('onclick','bootbox.alert("STATUS : CAIR <br>KUITANSI : '+ d.no_bukti +'<br>SPP : '+ d.str_nomor_trx +'<br>SPM : '+ d.str_nomor_trx_spm +'")') ;
                                el.html('<i class="glyphicon glyphicon-file"></i>');
                        }
                    }else{
                        el.addClass('btn-danger');
                        el.addClass('btn_batal');
                        el.attr('title','BATALKAN DPA !');
                        el.attr('data-original-title','BATALKAN DPA !');
                        el.removeAttr('onclick') ;
                        el.html('<i class="glyphicon glyphicon-remove-sign"></i>');
                    }

              }
            });
    });

    $("#cetak").click(function(){
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("#div-cetak").printArea( options );
    });

    $(document).on('keypress','.edit_here[contenteditable="true"]', function(event){
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });

    $('[class^="ck_"]').each(function(){
        //$('#btn-kuitansi').attr('disabled','disabled');
//                        aktv = '0';
        if(($(this).is(':checked'))&&($(this).is(':enabled'))){
            // $('#btn-kuitansi').removeAttr('disabled');
//                            aktv = '1';
//                            return false;
            $(this).prop('checked',false);

        }
    });

    $('[class^="all_ck_"]').each(function(){
        //$('#btn-kuitansi').attr('disabled','disabled');
//                        aktv = '0';
        if(($(this).is(':checked'))&&($(this).is(':enabled'))){
            // $('#btn-kuitansi').removeAttr('disabled');
//                            aktv = '1';
//                            return false;
            $(this).prop('checked',false);

        }
    });

    $(document).on("click","#myModalKuitansi #nmpppk",function(){
            $('#myModalP3K').modal('show');
    });

    $(document).on("click","#myModalKuitansi #nippppk",function(){
            $('#myModalP3K').modal('show');
    });

    $(document).on("click","#btn-pilih-pppk-ojo-dikopi-id-iki-yo-lek",function(){
        if($('input[name="id_user"]:checked').length > 0){
            var id_user = $("input[name='id_user']:checked").val();
            var nm_pppk = $("#nm_input_" + id_user).val();
            var nip_pppk = $("#nip_input_" + id_user).val();

            $('#myModalKuitansi #nmpppk').text(nm_pppk);
            $('#myModalKuitansi #editpppk').remove();
            $('#myModalKuitansi #nmpppk').after('<span id="editpppk"> [ <a href="#" data-toggle="modal" data-target="#myModalP3K" style="cursor:pointer">edit</a> ]</span>');
            $('#myModalKuitansi #nippppk').text(nip_pppk);

            $('#myModalP3K').modal('hide');

        }else{
//            alert('Mohon pilih salah satu PPPK.');
                bootbox.alert({
                    size: "small",
                    title: "Perhatian",
                    message: "Mohon pilih salah satu PPPK.",
                    animate:false,
                });
        }

        });

        $('#myModalP3K').on('show.bs.modal', function (e) {
            // do something...


        })

  // == CREATE BY DHANU // DELETE BUT CONFIRM IF CAUSED ERROR
  $(document).on("focusin","#myModalKuitansi2 #nmpppk",function(){
            $('#myModalP3K3').modal('show');
        });

    $(document).on("focusin","#myModalKuitansi2 #nippppk",function(){
            $('#myModalP3K3').modal('show');
        });

    $(document).on("click","#btn-pilih-pppk",function(){
        if($('input[name="id_user"]:checked').length > 0){
            var id_user = $("input[name='id_user']:checked").val();
            var nm_pppk = $("#nm_input_" + id_user).val();
            var nip_pppk = $("#nip_input_" + id_user).val();

            $('#myModalKuitansi2 #nmpppk').text(nm_pppk);
            $('#myModalKuitansi2 #editpppk').remove();
            $('#myModalKuitansi2 #nmpppk').after('<span id="editpppk"> [ <a href="#" data-toggle="modal" data-target="#myModalP3K3" style="cursor:pointer">edit</a> ]</span>');
            $('#myModalKuitansi2 #nippppk').text(nip_pppk);

            $('#myModalP3K3').modal('hide');

        }else{
            alert('Mohon pilih salah satu PPPK.');
        }

        });

        $('#myModalP3K3').on('show.bs.modal', function (e) {
            // do something...


        })

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
<?php
    // show manual override, untuk masukkan data secara manual
    if(!$this->cantik_model->manual_override()){
?>

            $( '[class^="ck_"]:checked' ).each(function(index){
                console.log('Row '+ index + ' ' + $( this ).attr('rel'));
                j += $( this ).attr('rel')+','
            });
            data = 'akunSPPLS='+j;
            console.log('Akun SPPLS : ' + j);
            $.ajax({
              type:"POST",
              url :"<?php echo site_url("tor/prosesSPPLS"); ?>",
              data:data,
              success:function(data){
                if($.isNumeric(data)){
                    window.location = '<?php echo site_url("tor/daftar_spplspeg"); ?>';
                }else{
                    $('.message_sppls').html(data);
                    $('#myModalMessage').modal('show');
                }
              }
            });
<?php
    // end here
    }else{
?>
            $('#kriteria_override').modal('show');
<?php
    }
?>
        }
    });

<?php
    // show manual override, untuk masukkan data secara manual
    if($this->cantik_model->manual_override()){
?>
    $('#kriteria_override').on('hidden.bs.modal',function(e){
        $('#form_kriteria')[0].reset();
    });

    $('.master_unit_id').change(function () {
        if ($(this).prop('checked')) {
            $('.unit_id:checkbox').prop('checked', true);
        } else {
            $('.unit_id:checkbox').prop('checked', false);
        }
    });
    $('.master_status_kepeg').change(function () {
        if ($(this).prop('checked')) {
            $('.status_kepeg:checkbox').prop('checked', true);
        } else {
            $('.status_kepeg:checkbox').prop('checked', false);
        }
    });
    $('.master_status').change(function () {
        if ($(this).prop('checked')) {
            $('.status:checkbox').prop('checked', true);
        } else {
            $('.status:checkbox').prop('checked', false);
        }
    });
    $('#jenisSPPLSPeg').on('change',function(e){
        var jenis = $(this).val();
        if(jenis != 'ipp'){
            $('#form_kriteria #bulan_input_group').removeAttr('style');
            $('#form_kriteria #semester_input_group').attr('style','display:none');
        }else{
            $('#form_kriteria #semester_input_group').removeAttr('style');
            $('#form_kriteria #bulan_input_group').attr('style','display:none');
        }
    });
    $('#form_kriteria').on('submit',function(e){
        e.preventDefault();
        var j = "";
        $( '[class^="ck_"]:checked' ).each(function(index){
            console.log('Row '+ index + ' ' + $( this ).attr('rel'));
            j += $( this ).attr('rel')+','
        });
        var akun = 'akun='+j;
        console.log('Akun SPPLS : ' + j);
        var data = $(this).serialize() + '&' + akun;
                var a=confirm('Yakin dengan isian data yang di-isikan?');
                if(a){
        $.ajax({
            type:"POST",
            url :"<?php echo site_url("tor/proses_override_sppls"); ?>",
            data:data,
            success:function(r){
                if($.isNumeric(r)){
                    window.location = '<?php echo site_url("tor/daftar_spplspeg"); ?>';
                }else{
                    $('.message_sppls').html(r);
                    $('#myModalMessage').modal('show');
                }
            }
        });
                }else{
                    return false;
                }
    });
    $('.what_a_fck').on('click',function(e){
        e.preventDefault();
        $('#form_kriteria').submit();
    });
<?php
    }
?>

    // untuk pembatalan dpa
    // $('.btn_batal').on('click',function(e){ // TAK UBAH MAS , BY IDRIS
    $( document ).on( "click", ".btn_batal", function(e){
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


//     $(document).on("click",'#btn-kuitansi2',function(){
//             // PREPARE GLOBAL VAR
// //            in_all = 0;

//             pj_p_kode_usulan_all = [];
//             pj_p_id_all = [];
//             pj_p_jenis_all = [];
//             pj_p_dpp_all = [];
//             pj_p_persen_all = [];
//             pj_p_nilai_all = [];

//             /// PREPARE TABLE ELEMENT
//             $('#myModalKuitansi2 #tr_new_').replaceWith('<tr id="tr_isi"><td colspan="8">tr_isi</td></tr>');

//             $('#myModalKuitansi2 #uraian').html("- edit here -");
//             $('#myModalKuitansi2 #penerima_uang').html("- edit here -");
//             $('#myModalKuitansi2 #penerima_barang').html("- edit here -");
//             $('#myModalKuitansi2 #penerima_barang_nip').html("- edit here -");

//             $("#myModalKuitansi2 .tr_new").remove();
//             var str = $(this).attr('rel') ;
//             var kd_usulan = str.substr(0,24);
//             var nm_akun = $('#nm_akun_' + kd_usulan).html();
//             var str_isi = '<tr id="tr_new_" style="display:none"><td>&nbsp;</td></tr>';
//             var i = 0 ;
//             $('[class^="ck_"]').each(function(){
//                 var el = $(this).attr('rel');
//                 if(($(this).is(':checked'))&&($(this).is(':enabled'))){
//                     str_isi = str_isi + '<tr class="tr_new">' ;
//                     var l_td = $('#tr_' + el + ' > td').length ;
//                     $('#tr_' + el + ' > td').each(function(ii){
//                         if(ii == 1){
//                             str_isi = str_isi + '<td colspan="3">' + (i+1) + '. ' + $(this).html() + '</td>' ;
//                         }
//                         else if(ii == 2){
//                             str_isi = str_isi + '<td style="text-align:center">' + $(this).html() + '</td>' ;
//                         }
//                         else if(ii == 3){
//                             str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">' + $(this).html() + '</td>' ;
//                         }
//                         else if(ii == 4){
//                             str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;">' + $(this).html() + '</td>' ;
//                         }
//                         else if(ii == 5){
//                             str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;" class="sub_tot_bruto_'+ el +'">' + $(this).html() + '</td>\n\
//                                         <td class="row_pajak_'+ el +'" style="padding: 0 5px 0 5px;">[<a data-toggle="modal" rel="'+ i + '_' + el +'" id="pilih_pajak_'+ el +'" href="#myModalPajak">Edit</a>]</td>\n\
//                                         <td style="text-align:right;" class="row_pajak_nom_'+ el +'">0</td>\n\
//                                         <td ><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></td>\n\
//                                         <td style="text-align:right" rel="'+ el +'" class="sub_tot_netto_'+ el +'">0</td>';
//                         }else{

//                         }

//                         pj_p_kode_usulan_all[i] =  el;
//                         pj_p_id_all[i] = [];
//                         pj_p_jenis_all[i] = [];
//                         pj_p_persen_all[i] = [];
//                         pj_p_dpp_all[i] = [];
//                         pj_p_nilai_all[i] = [];
//                     });

//                     str_isi = str_isi + '</tr>' ;
//                     i++ ;
//                 }

//             });
//             $('#myModalKuitansi2 #tr_isi').replaceWith(str_isi);

//             var sum_tot_bruto = 0 ;
//             $('#myModalKuitansi2 [class^="sub_tot_bruto_"').each(function(){
//                 sum_tot_bruto = sum_tot_bruto + parseInt(string_to_angka($(this).html()));
//             });
//             $('#myModalKuitansi2 .sum_tot_bruto').html(angka_to_string(sum_tot_bruto));

//             var sum_tot_netto = 0 ;
//             $('#myModalKuitansi2 [class^="sub_tot_netto_"').each(function(){
//                 var nrel = $(this).attr('rel');
//                 var sub_tot_bruto = parseInt(string_to_angka($('#myModalKuitansi2 .sub_tot_bruto_' + nrel).text()));
//                 var pajak = parseInt(string_to_angka($('#myModalKuitansi2 .row_pajak_nom_' + nrel).text()));
//                 var sub_tot_netto = sub_tot_bruto - pajak;
//                 $(this).text(angka_to_string(sub_tot_netto));
//                 sum_tot_netto = sum_tot_netto + sub_tot_netto ;
//             });
//             $('#myModalKuitansi2 .sum_tot_netto').html(angka_to_string(sum_tot_netto));

//             $('#myModalKuitansi2 .text_tot').html(terbilang(sum_tot_bruto));

//             $('#myModalKuitansi2 #txt_akun').html(nm_akun);
//             $('#myModalKuitansi2 #nm_subkomponen_kuitansi').html($('#nm_subkomponen').html());
//             var data = "alias=<?=$alias?>" ;
//             $.ajax({
//                 type:"POST",
//                 url :"<?=site_url("kuitansi/get_next_id")?>",
//                 data:data,
//                 success:function(data){
//                         $('#myModalKuitansi2 #no_bukti').html(data);
//                         $('#myModalKuitansi2').modal('show');
//                 }
//             });
//         });

      //   $(document).on("click",'#btn-submit-kuitansi2',function(){
      //               var str = $(this).attr('rel') ;
      //               var kd_usulan = str.substr(0,24);
      //               var no_bukti = $('#myModalKuitansi2 #no_bukti').text();
      //               var uraian = $('#myModalKuitansi2 #uraian').text();
      //               var penerima_uang = $('#myModalKuitansi2 #penerima_uang').text();
      //               var penerima_barang = $('#myModalKuitansi2 #penerima_barang').text();
      //               var penerima_barang_nip = $('#myModalKuitansi2 #penerima_barang_nip').text();
      //               var kode_usulan_belanja = kd_usulan;
      //               var ok = 'true';
      //               $('#myModalKuitansi2 .edit_here').each(function(){
      //                   var el = $(this).text();
      //                   if( el.trim() == '- edit here -' ){
      //                       ok = 'false';
      //                   }
      //               });
      //               console.log($('#myModalKuitansi2 .sum_tot_netto').text());
      //               if(ok == 'true'){
      //                  if($('#myModalKuitansi2 .sum_tot_netto').text() == '0'){
      //                       ok = 'false';
      //                   }
      //               }
      //               if( ok == 'true'){
      //               if(confirm('Yakin akan memproses ?')){
      //                   // var kode_akun_tambah_ = str.substr(24,3);
                        // // var id_kontrak_ = $('.id_kontrak_' + ).val();
                        // // var checked = $('[class^="ck_'+ kode_usulan_belanja +'"]').
                        // var id_kontrak = '';
      //                   var i = 0 ;

      //                   $('[class^="ck_'+ kode_usulan_belanja +'"]').each(function(){
      //                       //$('#btn-kuitansi').attr('disabled','disabled');
      //                       var el = $(this).attr('rel');
      //                       var kode_akun_tambah = el.substr(24,3);
                        //  var id_kontrak_ = $('.id_kontrak_' + el ).val();
      //                       if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                        //      // id_kontrak[i] = $('[class^="id_kontrak_'+ kode_usulan_belanja +'"]')[i].val();
                        //      // id_kontrak[i] = id_kontrak_[i].value;
                        //      //id_kontrak[i] = $('.id_kontrak_'+str).val();
      //                           kode_akun_tambah_ = kode_akun_tambah;
                        //      id_kontrak = id_kontrak_;
      //                       }
                        //  i++;
      //                   });
      //                   var data =  'kode_unit=' + '<?=$kode_unit?>' + '&no_bukti='+ no_bukti + '&uraian=' + uraian + '&jenis=' + badge_tmp + '&sumber_dana=<?=$sumber_dana?>' + '&kode_usulan_belanja=' + kode_usulan_belanja + '&kode_akun_tambah=' + kode_akun_tambah_ + '&penerima_uang=' + penerima_uang + '&penerima_barang=' + penerima_barang + '&penerima_barang_nip=' + penerima_barang_nip + '&nmpppk=' + $('#myModalKuitansi2 #nmpppk').text() + '&nippppk=' + $('#myModalKuitansi2 #nippppk').text() + '&nmbendahara=' + $('#myModalKuitansi2 #nmbendahara').text() + '&nipbendahara=' + $('#myModalKuitansi2 #nipbendahara').text() + '&nmpumk=' + $('#myModalKuitansi2 #nmpumk').text() + '&nippumk=' + $('#myModalKuitansi2 #nippumk').text() + '&pajak_kode_usulan=' + JSON.stringify(pj_p_kode_usulan_all) + '&pajak_id_input=' + JSON.stringify(pj_p_id_all) + '&pajak_jenis=' + JSON.stringify(pj_p_jenis_all) + '&pajak_dpp=' + JSON.stringify(pj_p_dpp_all) + '&pajak_persen=' + JSON.stringify(pj_p_persen_all) + '&pajak_nilai=' +JSON.stringify(pj_p_nilai_all)+'&id_kontrak='+id_kontrak;
      //                   //$('#myModalMsg .body-msg-text').html(data);
      //                   //$('#myModalMsg').modal('show');
                        // //return false;
                        // $.ajax({
                        //  type:"POST",
                        //  url :"<?=site_url("kuitansi/submit_kuitansi2")?>",
                        //  data:data,
                        //  success:function(data){
                        //      //$('#myModalMsg .body-msg-text').html(data);
                        //      //$('#myModalMsg').modal('show');
                        //      location.reload();
                        //  }
                        // });
      //               }
      //             }else{
      //                 alert('Silahkan diperiksa isiannya dahulu !');
      //             }
      //           });

  // == END HERE

        $('#backi').click(function(){
            window.location = "<?=site_url("dpa/daftar_dpa/").$sumber_dana?>";
        });

//        $(document).on('hidden.bs.modal', '#myModalUraian', function () {
//            $('input').val('');
//            $('textarea').val('');
//            $('.formError').hide();
//        });
//
//        $(document).on('show.bs.modal', '.modal', function (event) {
//
//        });

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

            if($(this).text() != '0'){
//                console.log(kd_usul);
                //$('[id^="tr_empty_'+ kd_usul +'"]').hide();
                //$('[id^="tr_unit_'+ kd_usul +'"]').hide();
                //$('[id^="tr_akun_'+ kd_usul +'"]').hide();


                $('[class^="tr_dpa_'+ kd_usul +'"]').hide();
            }else{

                $('[id^="tr_total_'+ kd_usul +'"]').hide();
                $('[id^="tr_usulan_'+ kd_usul +'"]').hide();
                $('[id^="tr_sisa_'+ kd_usul +'"]').hide();

            }

        });

        var is_none_all = '0';

        $('[id^="usulan_tor_row_detail_"] tr').each(function(){

            if($(this).is(':visible')) {
                is_none_all = '1' ;
//                console.log('v');
                 return false ;
            }

        });

        if(is_none_all == '0'){
            $('#tr_kosong').show();
        }



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
           // console.log(badge_);
            var badge = '';

            if (!(badge_ === undefined || badge_ === null)) {
                 // do something
                 badge = badge_.trim();
            }

            // console.log(badge);

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
                        kd_usulan_tmp = str ;
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
                    $('[class^="ck_'+ str +'"]').each(function(){
                        if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                            aktv = '1';
                            return false;
                        }
                    });
                    if(aktv == '1'){
                       return false;
                    }


                }
            });
            if(aktv == '1'){
                $('#btn-kuitansi2').attr('rel',str);
                $('#btn-kuitansi').attr('rel',str);
                $('#btn-submit-kuitansi').attr('rel',str);
                        $('#btn-submit-kuitansi2').attr('rel',str);
                $('#btn-kuitansi').removeAttr('disabled');
                        $('#btn-kuitansi2').removeAttr('disabled');
                // untuk spp ls created by dhanu
                $('#btn-buat-ls').attr('rel',str);
                $('#btn-buat-ls').removeAttr('disabled');
                // end here
                        // untuk kuitansi created by alex
                        $('#btn-termin').attr('rel',str);
                $('#btn-submit-termin').attr('rel',str);
                $('#btn-termin').removeAttr('disabled');
                        // end here

                $('#kode_badge').text(badge_tmp);
                $('#myModalKuitansi2 #kode_badge').text(badge_tmp);
            }else{
                $('#btn-kuitansi').attr('rel','');
                        $('#btn-kuitansi2').attr('rel','');
                $('#btn-submit-kuitansi').attr('rel','');
                $('#btn-kuitansi').attr('disabled','disabled');
                        $('#btn-kuitansi2').attr('disabled','disabled');
                // untuk spp ls created by dhanu
                $('#btn-buat-ls').attr('rel', '');
                $('#btn-buat-ls').attr('disabled','disabled');
                // end here
                        // untuk kuitansi ls created by alex
                $('#btn-termin').attr('rel', '');
                $('#btn-termin').attr('disabled','disabled');
                // end here
            }

                        // UNTUK MENGHITUNG JUMLAH DPA //

                        var jml_dpa = 0 ;

                        $('[class^="ck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                var arel = $(this).attr('rel');

                                var jml_k = parseInt(string_to_angka($("#td_sub_tot_" + arel).text()));
                                jml_dpa = jml_dpa + jml_k ;


                            }

                        });

                        $('.jml_kuitansi').text(angka_to_string(jml_dpa));

                        // END //



        });

        $(document).on('change', '[class^="ck_"]', function(){

            var str = $(this).attr('rel');
            var kd_usulan = str.substr(0,24);
            var badge_ = $('#badge_id_' + str).html();
            var badge = '' ;

            if (!(badge_ === undefined || badge_ === null)) {
                 // do something
                 badge = badge_.trim();
            }

//            console.log( ' 1.' + kd_usulan_tmp + ' 2.' + kd_usulan + ' ' + badge_tmp);

            var el = $(this) ;
//            if(el.is(':enabled')){
                $('[class^="all_ck_"]').prop('checked',false);
                if(el.is(':checked')){
                    // checkbox is checked
                    // alert('t');
                    if((kd_usulan_tmp != kd_usulan) || (badge_tmp != badge) ){
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
//            }
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
                $('#btn-kuitansi2').attr('rel',kd_usulan);
                $('#btn-submit-kuitansi2').attr('rel',kd_usulan);
                $('#btn-kuitansi2').removeAttr('disabled');
                // untuk spp ls created by dhanu
                $('#btn-buat-ls').attr('rel',str);
                $('#btn-buat-ls').removeAttr('disabled');
                // end here
                        // untuk kuitansi created by alex
                        $('#btn-termin').attr('rel',kd_usulan);
                $('#btn-submit-termin').attr('rel',kd_usulan);
                $('#btn-termin').removeAttr('disabled');
                        // end here

                $('#kode_badge').text(badge_tmp);
                $('#myModalKuitansi2 #kode_badge').text(badge_tmp);
            }else{
                $('#btn-kuitansi').attr('rel','');
                $('#btn-submit-kuitansi').attr('rel','');
                $('#btn-kuitansi').attr('disabled','disabled');
                        $('#btn-kuitansi2').attr('rel','');
                $('#btn-submit-kuitansi2').attr('rel','');
                $('#btn-kuitansi2').attr('disabled','disabled');
                // untuk spp ls created by dhanu
                $('#btn-buat-ls').attr('rel', '');
                $('#btn-buat-ls').attr('disabled','disabled');
                // end here
                        // untuk kuitansi ls created by alex
                $('#btn-termin').attr('rel', '');
                $('#btn-termin').attr('disabled','disabled');
                // end here
            }


            // UNTUK MENGHITUNG JUMLAH DPA //

            var jml_dpa = 0 ;

            $('[class^="ck_"]').each(function(){
                //$('#btn-kuitansi').attr('disabled','disabled');
                if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                    // $('#btn-kuitansi').removeAttr('disabled');
                    var arel = $(this).attr('rel');

                    var jml_k = parseInt(string_to_angka($("#td_sub_tot_" + arel).text()));
                    jml_dpa = jml_dpa + jml_k ;


                }

            });

            $('.jml_kuitansi').text(angka_to_string(jml_dpa));

            // END //


        });

        <?php if($jenis == '4'): ?>

        /// TONI ///

        $(document).on('change', '[class^="ck_"]', function(){
            var this_el = $(this).attr('rel');

            if ($(this).prop('checked')) {

                $('[class^="ck_"]').each(function(){
                    if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                        $(this).prop('checked','');
                    }
                });

                $('.ck_' + this_el).prop('checked','checked');

            }


        });

        $('[class^="all_ck_"]').each(function(){

                $(this).attr('disabled','disabled');

        });

        <?php endif; ?>

        $(document).on("click",'#btn-kuitansi',function(){
            // PREPARE GLOBAL VAR
//            in_all = 0;

            pj_p_kode_usulan_all = [];
            pj_p_id_all = [];
            pj_p_jenis_all = [];
            pj_p_dpp_all = [];
            pj_p_persen_all = [];
            pj_p_nilai_all = [];

            /// PREPARE TABLE ELEMENT
            $('#tr_new_').replaceWith('<tr id="tr_isi"><td colspan="8">tr_isi</td></tr>');

            $('#myModalKuitansi #uraian').html("- edit here -");
            $('#myModalKuitansi #penerima_uang').html("- edit here -");
            $('#penerima_uang_nip').html("- edit here -");
            $('#myModalKuitansi #penerima_barang').html("- edit here -");
            $('#myModalKuitansi #penerima_barang_nip').html("- edit here -");
            $('#myModalKuitansi #nmpppk').html("- edit here -");
            $('#myModalKuitansi #nippppk').html("- edit here -");
            $('#editpppk').remove();

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
                            str_isi = str_isi + '<td colspan="3">' + (i+1) + '. ' + $(this).html() + '</td>' ; // + ' [ <a data-toggle="modal" rel="'+ i + '_' + el +'" id="isi_uraian_'+ el +'" href="#myModalUraian" >uraian</a> ]</td>' ;
                        }
                        else if(ii == 2){
                            str_isi = str_isi + '<td style="text-align:center">' + $(this).html() + '</td>' ;
                        }
                        else if(ii == 3){
                            str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">' + $(this).html() + '</td>' ;
                        }
                        else if(ii == 4){
                            str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;">' + $(this).html() + '</td>' ;
                        }
                        else if(ii == 5){
                            str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;" class="sub_tot_bruto_'+ el +'">' + $(this).html() + '</td>\n\
                                        <td class="row_pajak_'+ el +'" style="padding: 0 5px 0 5px;">[ <a data-toggle="modal" rel="'+ i + '_' + el +'" id="pilih_pajak_'+ el +'" href="#myModalPajak">edit</a> ]</td>\n\
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
            $('#myModalKuitansi .sum_tot_netto').html(angka_to_string(sum_tot_netto));

            $('#myModalKuitansi .text_tot').html(terbilang(sum_tot_bruto));

            $('#myModalKuitansi #txt_akun').html(nm_akun);
            $('#myModalKuitansi #nm_subkomponen_kuitansi').html($('#nm_subkomponen').html());

            var data = "alias=<?=$alias?>" ; //&sumber_dana=<?=$sumber_dana?>&jenis=" + badge_tmp ;



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


//            console.log(JSON.stringify(pj_p_kode_usulan_all));
//            console.log(JSON.stringify(pj_p_id_all));
//            console.log(JSON.stringify(pj_p_jenis_all));
//            console.log(JSON.stringify(pj_p_dpp_all));
//            console.log(JSON.stringify(pj_p_persen_all));
//            console.log(JSON.stringify(pj_p_nilai_all));


        });

        $('#myModalKuitansi').on('show.bs.modal', function (e) {
//            // do something...
//            td_sub_tot_121130010101010101521213001
//
//            ck_121130010101010101521213001

            $('input[name="id_user"]').each(function(){
                $(this).prop('checked', false);
            });




//            console.log(saldo_kas + ' | ' + tot_select);


            /* KONDISI TIDAK DIPAKAI BIAR BISA BUAT KUITANSI SEBANYAK BANYAKNYA DULU , DAN DIPINDAH PAS BUAT SPP */

            // var tot_select = 0 ;
            // var saldo_kas =  parseInt(string_to_angka($('#saldo_kas').text()));
            // $('[class^="ck_"]').each(function(){
            //     var relck = $(this).attr('rel');
            //     if(($(this).is(':checked'))&&($(this).is(':enabled'))){
            //         var sub_tot_select = $('#td_sub_tot_' + relck).text();
            //             tot_select = tot_select + parseInt(string_to_angka(sub_tot_select));
            //     }
            // });

            // if(saldo_kas >= tot_select){
            //     return true;
            // }else{
            //     bootbox.alert({
            //         size: "small",
            //         title: "Perhatian",
            //         message: 'Maaf jumlah saldo UP anda tidak cukup',
            //         animate:false,
            //     });
            //     return false;
            // }

            /* END KONDISI */

            return true;



        });

        $(document).on('click', '[id^="pilih_pajak_"]',  function(e){
            var rel = $(this).attr('rel');
            $("#myModalPajak").attr('rel',rel);
        });


        $("#myModalPajak").on('show.bs.modal', function (event) {

                $('.formError').hide();

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

            // console.log(rel_1);


            if(($(this).val() != '99')&&($(this).val() != '98')&&($(this).val() != '97')&&($(this).val() != '96')&&($(this).val() != '95')&&($(this).val() != '94')&&($(this).val() != '89')){
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

                        $('.pj_nilai_' + rel__1).attr('disabled','disabled');

                    });

                    $('#pj_dpp_' + rel).removeAttr('disabled');

                    el.prop('checked',true);

                    var bruto_ = $('.sub_tot_bruto_' + rel_modal).text();
                    var bruto = string_to_angka(bruto_);
                    var pajak = el.val() ;
//                    console.log('p : '+pajak);
//                    console.log('bra : '+bruto);
//                    console.log('pp : '+parseFloat(pajak));
                    var bruto = (bruto * parseFloat(pajak)) / 100 ;
//                    console.log('brp : '+bruto);
                    $('#pj_nilai_' + rel).val(angka_to_string(Math.round(bruto)));
                }else{
                    $('#pj_dpp_' + rel).prop('checked',false);
                    $('#pj_dpp_' + rel).attr('disabled','disabled');
                    $('#pj_nilai_' + rel).val('');

                    // console.log(rel_1);

                    // $('.pj_nilai_' + rel__1).attr('disabled','disabled');

                }
            }else{

                if(($(this).val() == '98')||($(this).val() == '97')||($(this).val() == '96')||($(this).val() == '95')||($(this).val() == '94')||($(this).val() == '89')){

                    if($(this).is(':checked')){

                        var el = $(this);

                        $('.pj_p_' + rel_1 ).each(function(){

                            var rel__ = $(this).attr('rel');
                            var rel__a = rel__.split("_");
                            var rel__1 = rel__a[1];

                            $(this).prop('checked',false);

                            // $('.pj_dpp_' + rel__1).attr('disabled','disabled');
                            // $('.pj_dpp_' + rel__1).prop('checked',false);
                            $('.pj_nilai_' + rel__1).val('');
                        });


                        el.prop('checked',true);

                    }



                }

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
                var bruto = (parseFloat(pajak) * ((100 / (110)) * bruto))/100 ;
//                console.log(Math.round(bruto) + ' ' + rel);
                $('#pj_nilai_' + rel).val(angka_to_string(Math.round(bruto)));
            }else{
//                $('#pj_dpp_' + rel).attr('disabled','disabled');
                var bruto_ = $('.sub_tot_bruto_' + rel_modal).text();
                var bruto = string_to_angka(bruto_);
                var pajak = $('#pj_p_' + rel).val() ;
                var bruto = (bruto * parseFloat(pajak)) / 100 ;
                $('#pj_nilai_' + rel).val(angka_to_string(Math.round(bruto)));
            }
            get_total_pajak();
        });

        $(document).on('focusout', '.pj_nilai_lainnya', function(){
            get_total_pajak();
        });

        $(document).on('focusout', '#pj_nilai_81', function(){
            get_total_pajak();
        });
        $(document).on('focusout', '#pj_nilai_51', function(){
            get_total_pajak();
        });
        $(document).on('focusout', '#pj_nilai_71', function(){
            get_total_pajak();
        });
        $(document).on('focusout', '#pj_nilai_101', function(){
            get_total_pajak();
        });
        $(document).on('focusout', '#pj_nilai_111', function(){
            get_total_pajak();
        });
        $(document).on('focusout', '#pj_nilai_151', function(){
            get_total_pajak();
        });

        $(document).on('click', '#btn-submit-pajak', function(){
            var p_ok = 'ok' ;

            if ($('#pj_p_16').is(':checked')) {
                if(!$('#pj_nilai_16').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#pj_p_51').is(':checked')) {
                if(!$('#pj_nilai_51').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#pj_p_71').is(':checked')) {
                if(!$('#pj_nilai_71').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#pj_p_101').is(':checked')) {
                if(!$('#pj_nilai_101').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#pj_p_111').is(':checked')) {
                if(!$('#pj_nilai_111').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#pj_p_151').is(':checked')) {
                if(!$('#pj_nilai_151').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#pj_p_81').is(':checked')) {
                if(!$('#pj_nilai_81').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if(p_ok == 'ok'){
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
                    if((pj_p_persen[k] != '99')&&(pj_p_persen[k] != '98')&&(pj_p_persen[k] != '97')&&(pj_p_persen[k] != '96')&&(pj_p_persen[k] != '95')&&(pj_p_persen[k] != '94')&&(pj_p_persen[k] != '89')){
                        str_h = str_h + v + ' ' + pj_p_persen[k] + '%  <br />' ;
                    }else{
                        str_h = str_h + v + ' <br />' ;
                    }

                }

                str_i = str_i + '<span class="sub_tot_pajak">' + pj_p_nilai[k] +'</span>' + '<br />' ;

            });

            if(str_h == ''){
                $('.row_pajak_' + rel).html('[ <a data-toggle="modal" rel="'+ in_all + '_' + rel +'" id="edit_p_' + rel + '" href="#myModalPajakEdit" style="margin: 0 5px 0 5px;">edit</a> ]');
                $('.row_pajak_nom_' + rel).html(str_i);
            }else{
                $('.row_pajak_' + rel).html(str_h + '[ <a data-toggle="modal" href="#myModalPajakEdit" rel="'+ in_all + '_' + rel +'" id="edit_p_' + rel + ' " >edit</a> ]');
                if(str_i==''){
                    str_i = '0';
                }
                $('.row_pajak_nom_' + rel).html(str_i);
            }

            var sum_tot_bruto = 0 ;
            $('[class^="sub_tot_bruto_"').each(function(){
                sum_tot_bruto = sum_tot_bruto + parseInt(string_to_angka($(this).html()));
            });
            $('.sum_tot_bruto').html(angka_to_string(sum_tot_bruto));

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

            $('.text_tot').html(terbilang(sum_tot_bruto));

            $('#myModalPajak').modal('hide');

//            pj_p_kode_usulan_all[in_all] = rel ;
//            console.log(JSON.stringify(pj_p_kode_usulan_all));
//            console.log(JSON.stringify(pj_p_id_all));
//            console.log(JSON.stringify(pj_p_jenis_all));
//            console.log(JSON.stringify(pj_p_dpp_all));
//            console.log(JSON.stringify(pj_p_persen_all));
//            console.log(JSON.stringify(pj_p_nilai_all));

//            in_all++ ;
            }

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
            if(($(this).val() != '99')&&($(this).val() != '98')&&($(this).val() != '97')&&($(this).val() != '96')&&($(this).val() != '95')&&($(this).val() != '94')&&($(this).val() != '89')){
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

                        $('.edit_pj_nilai_' + rel__1).attr('disabled','disabled');

                    });

                    $('#edit_pj_dpp_' + rel).removeAttr('disabled');

                    el.prop('checked',true);
                    var bruto_ = $('.sub_tot_bruto_' + rel_modal).text();
                    var bruto = string_to_angka(bruto_);
                    var pajak = el.val() ;
                    var bruto = (bruto * parseFloat(pajak)) / 100 ;
                    $('#edit_pj_nilai_' + rel).val(angka_to_string(Math.round(bruto)));
                }else{
                    $('#edit_pj_dpp_' + rel).prop('checked',false);
                    $('#edit_pj_dpp_' + rel).attr('disabled','disabled');
                    $('#edit_pj_nilai_' + rel).val('');
                }
            }else{

                if(($(this).val() == '98')||($(this).val() == '97')||($(this).val() == '96')||($(this).val() == '95')||($(this).val() == '94')||($(this).val() == '89')){

                    if($(this).is(':checked')){

                        var el = $(this);

                        $('.edit_pj_p_' + rel_1 ).each(function(){

                            var rel__ = $(this).attr('rel');
                            var rel__a = rel__.split("_");
                            var rel__1 = rel__a[1];

                            $(this).prop('checked',false);

                            // $('.pj_dpp_' + rel__1).attr('disabled','disabled');
                            // $('.pj_dpp_' + rel__1).prop('checked',false);
                            $('.edit_pj_nilai_' + rel__1).val('');
                        });


                        el.prop('checked',true);

                    }



                }

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
                var bruto = (parseFloat(pajak) * ((100 / (110)) * bruto))/100 ;
//                console.log(Math.round(bruto) + ' ' + rel);
                $('#edit_pj_nilai_' + rel).val(angka_to_string(Math.round(bruto)));
            }else{
//                $('#pj_dpp_' + rel).attr('disabled','disabled');
                var bruto_ = $('.sub_tot_bruto_' + rel_modal).text();
                var bruto = string_to_angka(bruto_);
                var pajak = $('#edit_pj_p_' + rel).val() ;
                var bruto = (bruto * parseFloat(pajak)) / 100 ;
                $('#edit_pj_nilai_' + rel).val(angka_to_string(Math.round(bruto)));
            }
            get_total_pajak_edit();
        });

        $(document).on('focusout', '.edit_pj_nilai_lainnya', function(){
            get_total_pajak_edit();
        });

        $(document).on('focusout', '#edit_pj_nilai_81', function(){
            get_total_pajak_edit();
        });
        $(document).on('focusout', '#edit_pj_nilai_71', function(){
            get_total_pajak_edit();
        });

        $(document).on('focusout', '#edit_pj_nilai_51', function(){
            get_total_pajak_edit();
        });
        $(document).on('focusout', '#edit_pj_nilai_101', function(){
            get_total_pajak_edit();
        });
        $(document).on('focusout', '#edit_pj_nilai_111', function(){
            get_total_pajak_edit();
        });
        $(document).on('focusout', '#edit_pj_nilai_151', function(){
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

                if((pj_p_persen_all_[k] == '99')||(pj_p_persen_all_[k] == '98')||(pj_p_persen_all_[k] == '97')||(pj_p_persen_all_[k] == '96')||(pj_p_persen_all_[k] == '95')||(pj_p_persen_all_[k] == '94')||(pj_p_persen_all_[k] == '89')){
                    $('#edit_pj_nilai_' + v).removeAttr('disabled');
                }

                $('#edit_pj_nilai_' + v).val(pj_p_nilai_all_[k]);
            });

            $("#myModalPajakEdit").attr('rel',id_in_all + '_' + rel);
            get_total_pajak_edit();
        });

        $("#myModalPajakEdit").on('show.bs.modal', function (event) {

                $('.formError').hide();

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
            var p_ok = 'ok' ;

            if ($('#edit_pj_p_16').is(':checked')) {
                if(!$('#edit_pj_nilai_16').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#edit_pj_p_51').is(':checked')) {
                if(!$('#edit_pj_nilai_51').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#edit_pj_p_71').is(':checked')) {
                if(!$('#edit_pj_nilai_71').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#edit_pj_p_101').is(':checked')) {
                if(!$('#edit_pj_nilai_101').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#edit_pj_p_111').is(':checked')) {
                if(!$('#edit_pj_nilai_111').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#edit_pj_p_151').is(':checked')) {
                if(!$('#edit_pj_nilai_151').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if ($('#edit_pj_p_81').is(':checked')) {
                if(!$('#edit_pj_nilai_81').validationEngine("validate")){

                    p_ok = 'not_ok';

                }
            }

            if(p_ok == 'ok'){
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
                    if((pj_p_persen[k] != '99')&&(pj_p_persen[k] != '98')&&(pj_p_persen[k] != '97')&&(pj_p_persen[k] != '96')&&(pj_p_persen[k] != '95')&&(pj_p_persen[k] != '94')&&(pj_p_persen[k] != '89')){
                        str_h = str_h + v + ' ' + pj_p_persen[k] + '%  <br />' ;
                    }else{
                        str_h = str_h + v + ' <br />' ;
                    }

                }
                str_i = str_i + '<span class="sub_tot_pajak">' + pj_p_nilai[k] +'</span>' + '<br />' ;


            });
            $('.row_pajak_' + rel).html(str_h + '[ <a data-toggle="modal" href="#myModalPajakEdit" rel="'+ id_in_all + '_' + rel +'" id="edit_p_' + rel + '">edit</a> ]');
            if(str_i==''){
                    str_i = '0';
                }
            $('.row_pajak_nom_' + rel).html(str_i);

            var sum_tot_bruto = 0 ;
            $('[class^="sub_tot_bruto_"').each(function(){
                sum_tot_bruto = sum_tot_bruto + parseInt(string_to_angka($(this).html()));
            });
            $('.sum_tot_bruto').html(angka_to_string(sum_tot_bruto));

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

            $('.text_tot').html(terbilang(sum_tot_bruto));

            $('#myModalPajakEdit').modal('hide');

//            console.log(JSON.stringify(pj_p_kode_usulan_all));
//            console.log(JSON.stringify(pj_p_id_all));
//            console.log(JSON.stringify(pj_p_jenis_all));
//            console.log(JSON.stringify(pj_p_dpp_all));
//            console.log(JSON.stringify(pj_p_persen_all));
//            console.log(JSON.stringify(pj_p_nilai_all));

//            in_all++ ;
            }
        });

        $(document).on("click",'#btn-submit-kuitansi',function(){


            var str = $(this).attr('rel') ;
            var kd_usulan = str.substr(0,24);
            // var kd_tambah = str.substr(24,3);

            var no_bukti = $('#myModalKuitansi #no_bukti').text();

            var uraian = $('#myModalKuitansi #uraian').text();

            var penerima_uang = $('#myModalKuitansi #penerima_uang').text();

            var penerima_uang_nip =  $('#myModalKuitansi #penerima_uang_nip').text();
//            var penerima_uang_nip = penerima_uang_nip_.trim();

            var penerima_barang = $('#myModalKuitansi #penerima_barang').text();

            var penerima_barang_nip = $('#myModalKuitansi #penerima_barang_nip').text();

            var kode_usulan_belanja = kd_usulan;
            // var kode_akun_tambah = kd_tambah;
            var ok = 'true';

            $('#myModalKuitansi .input_boot').each(function(){
                var el = $(this).text();
                if( el.trim() == '- edit here -' ){

                    ok = 'false';

                }
            });


            $('#myModalKuitansi .edit_here').each(function(){
                var el = $(this).text();
                if( el.trim() == '- edit here -' ){

                    ok = 'false';

                }
            });

//            console.log($('#myModalKuitansi .sum_tot_netto').text());

            if(ok == 'true'){
               if($('#myModalKuitansi .sum_tot_netto').text() == '0'){
                    ok = 'false';
                }
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
//
//            console.log(JSON.stringify(pj_p_kode_usulan_all));
//            console.log(JSON.stringify(pj_p_id_all));
//            console.log(JSON.stringify(pj_p_jenis_all));
//            console.log(JSON.stringify(pj_p_dpp_all));
//            console.log(JSON.stringify(pj_p_persen_all));
//            console.log(JSON.stringify(pj_p_nilai_all));

                var data =  'kode_unit=' + '<?=$kode_unit?>' + '&no_bukti='+ no_bukti + '&uraian=' + encodeURIComponent(uraian) + '&jenis=' + badge_tmp + '&sumber_dana=<?=$sumber_dana?>' + '&kode_usulan_belanja=' + kode_usulan_belanja + '&kode_akun_tambah=' + JSON.stringify(kode_akun_tambah_) + '&penerima_uang=' + encodeURIComponent(penerima_uang) + '&penerima_uang_nip=' + penerima_uang_nip + '&penerima_barang=' + penerima_barang + '&penerima_barang_nip=' + penerima_barang_nip + '&nmpppk=' + $('#myModalKuitansi #nmpppk').text() + '&nippppk=' + $('#myModalKuitansi #nippppk').text() + '&nmbendahara=' + $('#myModalKuitansi #nmbendahara').text() + '&nipbendahara=' + $('#myModalKuitansi #nipbendahara').text() + '&nmpumk=' + $('#myModalKuitansi #nmpumk').text() + '&nippumk=' + $('#myModalKuitansi #nippumk').text() + '&pajak_kode_usulan=' + JSON.stringify(pj_p_kode_usulan_all) + '&pajak_id_input=' + JSON.stringify(pj_p_id_all) + '&pajak_jenis=' + JSON.stringify(pj_p_jenis_all) + '&pajak_dpp=' + JSON.stringify(pj_p_dpp_all) + '&pajak_persen=' + JSON.stringify(pj_p_persen_all) + '&pajak_nilai=' +JSON.stringify(pj_p_nilai_all) ; // '&penerima_uang_nip=' + penerima_uang_nip +
                $.ajax({
                    type:"POST",
                    url :"<?=site_url("kuitansi/submit_kuitansi")?>",
                    data:data,
                    success:function(data){
//                        console.log(data)
                            location.reload();

                            // bootbox.alert({
                            //     size: "large",
                            //     title: "Perhatian",
                            //     message: 'maaf sedang diperbaiki !',
                            //     animate: false,
                            // });
                    }
                });


            }
            }else{
//                alert('Silahkan diperiksa isiannya dahulu !');
                bootbox.alert({
                    size: "small",
                    title: "Perhatian",
                    message: 'Silahkan diperiksa isiannya dahulu !',
                    animate:false,
                });
            }

        });

        $(document).on("click",".input_boot",function(){

            var el = $(this) ;

            var id_name = el.attr('id').toUpperCase();

            var elval = el.text();

            elval = elval.trim() ;

            var val = '' ;

            if(elval && (elval != '- edit here -')){
                val = elval ;
            }

            var dialog = bootbox.prompt({
              size: "large",
              title: id_name,
              value: val,
              inputType: 'textarea',
              onEscape: false,
              closeButton:false,
              animate:false,
              callback: function(res){
                if(res){
                    res = res.trim() ;
                    if(res != ''){
                        el.text(res);

                    }else{
                        el.text('- edit here -');
                    }
                }else{
                    if(elval == '- edit here -'){
                        el.text('- edit here -');

                    }else{
                        el.text(elval);
                    }
                }
              }
            }) ;


            dialog.init(function(){
                dialog.find('.bootbox-body').prepend( '<div class="alert alert-warning">Apabila isian kosong harap diberi tanpa strip "-" ( tanpa tanda kutip ) untuk keseragaman</div>');

            });



        });

        $(document).on("click","#uraian_simpan",function(){
            if($("#uraian_text").validationEngine("validate") && $("#uraian_kuantitas").validationEngine("validate") && $("#uraian_satuan").validationEngine("validate") && $("#uraian_harga").validationEngine("validate")){

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
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8">
                        <table class="table table-striped table-bordered">
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
                    </div>
                    <div class="col-lg-4">
                    </div>
                </div>
                <table class="table table-striped table-bordered" >
                    <tr class="alert alert-danger"style="font-weight: bold">
                        <td class="col-md-2">Sumber Dana</td>
                        <td><span id="kode_sumber_dana"><?=$sumber_dana?></span></td>
                    </tr>
                    <tr class="">
                        <td class="col-md-2">Ket</td>
                        <td>
                            <span class="label badge-gup">&nbsp;</span> : GUP &nbsp;&nbsp;<span class="label badge-tup">&nbsp;</span> : TUP &nbsp;&nbsp;<span class="label badge-lp">&nbsp;</span> : LS-PEGAWAI &nbsp;&nbsp;<span class="label badge-l3">&nbsp;</span> : LS-KONTRAK &nbsp;&nbsp;<span class="label badge-ln">&nbsp;</span> : LS-NON-KONTRAK &nbsp;&nbsp;<span class="label badge-ks">&nbsp;</span> : KERJA-SAMA &nbsp;&nbsp;<span class="label badge-em">&nbsp;</span> : EMONEY
                        </td>
                    </tr>
                </table>
                <div class="alert alert-warning col-sm-8">
                    <?php
                    if($jenis!=2){
                    ?>
                        <button type="button" class="btn btn-warning" id="btn-kuitansi" rel="" disabled="disabled" >
                            <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>
                            Buat Kuitansi
                        </button>
                        <a href="<?=site_url('kuitansi/daftar_kuitansi/')?><?php if($jenis=='1'){echo 'GP';}elseif($jenis=='2'){echo 'LP';}elseif($jenis=='4'){echo 'LK';}elseif($jenis=='3'){echo 'TP';}elseif($jenis=='5'){echo 'KS';}elseif($jenis=='6'){echo 'LN';}elseif($jenis=='7'){echo 'EM';}else{} ?>" class="btn btn-info">
                            <span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span> 
                            Daftar Kuitansi
                        </a>
                    <?php
                    }else{
                    ?>
                        <button type="button" class="btn btn-primary" id="btn-buat-ls" rel="" disabled="disabled">
                            <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> 
                            Buat SPP LSP
                        </button>
                    <?php
                    } 
                    ?>
                </div>

                <div class="alert alert-info col-md-12" style="border-color:#3793a7;" id="panel-jml-show">
                    <span class="text-danger">Jumlah aktif dpa dipilih : <b class="jml_kuitansi">0</b></span>
                </div>

                <div style="position: fixed;top: 79px;z-index:999;right:0px;width:300px;display:none;" id="panel-jml" >
                    <div class="alert alert-info" style="border-radius:0px;border-color:#3793a7;">
                        <span class="text-danger">Jumlah aktif dpa dipilih : <b class="jml_kuitansi">0</b></span>
                    </div>
                </div>

                <div id="temp" style="display:none"></div>
                <div id="o-table">

                    <?php foreach ($akun_subakun as $key_subunit => $value_subunit): ?>
                        <?php foreach ($value_subunit['data'] as $key_sub_subunit => $value_sub_subunit): ?>
                            <?php foreach ($value_sub_subunit['data'] as $key4digit => $value4digit): ?>
                                    <?php foreach ($value4digit['data'] as $key5digit => $value5digit): ?>
                                            <?php foreach ($value5digit['data'] as $key6digit => $value6digit): ?>
                                                        <table id="tb-data" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr id="tr_unit_<?=$value6digit['kode_usulan_belanja']?>" class="alert alert-info" height="25px">
                                                                    <td colspan="8"><b><?='<span class="text-warning">'.$value_subunit['nama_subunit'].'</span> : <span class="text-success">'.$value_sub_subunit['nama_sub_subunit'].'</span>'?></b></td>
                                                                </tr>
                                                                <tr id="tr_akun_<?=$value6digit['kode_usulan_belanja']?>" height="25px" class="text-danger">
                                                                    <td colspan="7"><b><?=substr($value6digit['kode_usulan_belanja'], 18,6).' : <span id="nm_akun_'.$value6digit['kode_usulan_belanja'].'">'.$value6digit['nama_akun'].'</span>'?></b></td>
                                                                    <td >
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon" style="background-color: #f9ff83">
                                                                                <input type="checkbox" aria-label="" rel="<?=$value6digit['kode_usulan_belanja']?>" class="all_ck_<?php echo $value6digit['kode_usulan_belanja'] ;?>">
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="col-md-1 text-center" >Akun</th>
                                                                    <th class="col-md-3 text-center" >Rincian</th>
                                                                    <th class="col-md-1 text-center" >Volume</th>
                                                                    <th class="col-md-1 text-center" >Satuan</th>
                                                                    <th class="col-md-2 text-center" >Harga</th>
                                                                    <th class="col-md-2 text-center" >Jumlah</th>
                                                                    <th colspan="2" class="col-md-2 text-center" style="text-align:center">Pilih</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="usulan_tor_row_detail_<?php echo $value6digit['kode_usulan_belanja'] ?>">
                                                                <?php foreach ($value6digit['data'] as $keydetail => $valdetail): ?>
                                                                    <?php if(substr($valdetail['proses'],1,1) == $jenis): ?>
                                                                    <tr  id="tr_<?=$value6digit['kode_usulan_belanja']?><?php echo $keydetail ;?>">
                                                                        <td class="text-right">
                                                                            <?php if(substr($valdetail['proses'],1,1)==4){ ?>
                                                                                <input type="hidden" class="id_kontrak_<?php echo $value6digit['kode_usulan_belanja'].$keydetail; ?>" value="<?php echo $kontrak[$value6digit['kode_usulan_belanja'].$keydetail][0]->id; ?>"/>
                                                                            <?php } ?>

                                                                            <?php
                                                                            if(substr($valdetail['proses'],1,1)=='1'){
                                                                                echo '<span class="badge badge-gup" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">GP</span>';
                                                                            }
                                                                            elseif(substr($valdetail['proses'],1,1)=='2'){
                                                                                echo '<span class="badge badge-lp" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">LP</span>';
                                                                            }
                                                                            elseif(substr($valdetail['proses'],1,1)=='4'){
                                                                                echo '<span class="badge badge-l3" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">LK</span>';
                                                                            }
                                                                            elseif(substr($valdetail['proses'],1,1)=='3'){
                                                                                echo '<span class="badge badge-tup" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">TP</span>';
                                                                            }
                                                                            elseif(substr($valdetail['proses'],1,1)=='5'){
                                                                                echo '<span class="badge badge-ks" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">KS</span>';
                                                                            }
                                                                            elseif(substr($valdetail['proses'],1,1)=='6'){
                                                                                echo '<span class="badge badge-ln" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">LN</span>';
                                                                            }
                                                                            elseif(substr($valdetail['proses'],1,1)=='7'){
                                                                                echo '<span class="badge badge-em" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">EM</span>';
                                                                            }
                                                                            else{} ?>
                                                                            <?php echo $keydetail ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $valdetail['rincian'] ?>
                                                                            <?php if (!empty($valdetail['ket'])): ?>
                                                                                <span class="glyphicon glyphicon-question-sign" style="cursor:pointer" onclick="open_tolak('<?php echo $valdetail['ket'] ?>')" aria-hidden="true"></span>
                                                                            <?php endif ?>
                                                                        </td>
                                                                        <td class="text-center"><?php echo $valdetail['volume'] + 0 ?></td>
                                                                        <td class="text-center"><?php echo $valdetail['satuan'] ?></td>
                                                                        <td class="text-right"><?php echo number_format($valdetail['harga_satuan'],0,',','.') ?></td>
                                                                        <td class="text-right" id="td_sub_tot_<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>">
                                                                            <?php echo number_format($valdetail['jumlah_harga'],0,',','.') ?>
                                                                        </td>
                                                                        <?php if(substr($valdetail['proses'],0,1) == 0) : ?>
                                                                            <td align="center">
                                                                                <buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$value6digit['kode_usulan_belanja']?>" >
                                                                                    <span class="glyphicon glyphicon-share" aria-hidden="true"></span>
                                                                                </buttton>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-success btn-sm" rel="<?php echo $valdetail['id_rsa_detail'] ;?>" id="proses_<?php echo $valdetail['id_rsa_detail'] ;?>" aria-label="Center Align">
                                                                                    <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                                                                                Proses</button>
                                                                            </td>
                                                                            <?php elseif(substr($valdetail['proses'],0,1) == 3): ?>
                                                                            <td align="center">
                                                                                <button type="button" class="btn btn-sm btn-default btn-ajx" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" onclick="bootbox.alert('sedang memuat status..')" title="wait..">
                                                                                        <i class="glyphicon glyphicon-repeat"></i>
                                                                                </button>
                                                                                <?php if( $jenis==4 ): ?>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <?php //if(is_null($valdetail['id_kuitansi'])): ?>
                                                                                            <!-- <input type="checkbox" aria-label="" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" class="ck_<?php echo $value6digit['kode_usulan_belanja'] ;?><?=$keydetail?>"> -->
                                                                                        <?php //else: ?>
                                                                                            <?php //if( $valdetail['aktif'] == '1' ) : ?>
                                                                                            <!-- <input type="checkbox" disabled="disabled" checked="checked" aria-label="" rel="" class=""> -->
                                                                                            <?php //else: ?>
                                                                                            <input type="checkbox" aria-label="" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" class="ck_<?php echo $value6digit['kode_usulan_belanja'] ;?><?=$keydetail?>">
                                                                                            <?php //endif; ?>
                                                                                        <?php //endif;?>
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                            <?php elseif(substr($valdetail['proses'],0,1) == 4): ?>
                                                                            <td align="center">
                                                                                <button type="button" class="btn btn-sm btn-default btn-ajx" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" onclick="bootbox.alert('sedang memuat status..')" title="wait.."><i class="glyphicon glyphicon-repeat"></i></button>
                                                                            </td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                     <input type="checkbox" disabled="disabled" checked="checked" aria-label="" rel="" class="">
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                            <?php elseif(substr($valdetail['proses'],0,1) == 5): ?>
                                                                            <td align="center">
                                                                                <button type="button" class="btn btn-sm btn-default btn-ajx" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" onclick="bootbox.alert('sedang memuat status..')" title="wait.."><i class="glyphicon glyphicon-repeat"></i></button>
                                                                            </td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                     <input type="checkbox" disabled="disabled" checked="checked" aria-label="" rel="" class="">
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                            <?php elseif(substr($valdetail['proses'],0,1) == 6): ?>
                                                                            <td align="center">
                                                                                <button type="button" class="btn btn-sm btn-default btn-ajx" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" onclick="bootbox.alert('sedang memuat status..')" title="wait.."><i class="glyphicon glyphicon-repeat"></i></button>
                                                                            </td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                     <input type="checkbox" disabled="disabled" checked="checked" aria-label="" rel="" class="">
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <td align="center">&nbsp;</td>
                                                                            <td>
                                                                                <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align">
                                                                                    <span class="glyphicon glyphicon-export" aria-hidden="true"></span> 
                                                                                    Proses
                                                                                </button>
                                                                            </td>
                                                                        <?php endif; ?>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php endforeach ?>
                                                                
                                                                <tr id="tr_kosong" height="25px" style="display: none" class="alert alert-warning" >
                                                                    <td colspan="8">- kosong / belum disetujui -</td>
                                                                </tr>
                                                            </tbody>

                                                            <div style="display: none;" rel="<?=$value6digit['kode_usulan_belanja']?>" id="td_usulan_<?=$value6digit['kode_usulan_belanja']?>">
                                                                <?=number_format($value4digit['anggaran'], 0, ",", ".")?>
                                                            </div>
                                                            <div style="display: none;" id="td_kumulatif_<?=$value6digit['kode_usulan_belanja']?>">
                                                                <?=number_format($value4digit['usulan_anggaran'], 0, ",", ".")?>
                                                            </div>
                                                            <div style="display: none;" id="td_kumulatif_sisa_<?=$value6digit['kode_usulan_belanja']?>">
                                                                <?=number_format($value4digit['sisa_anggaran'], 0, ",", ".")?>
                                                            </div>

                                                        </table>
                                                        <hr>
                                            <?php endforeach ?>
                                    <?php endforeach ?>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    <?php endforeach ?>

                    <table class="table" id="tb-data">
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
                            <?php if(!empty($detail_akun_rba)): ?>
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

                                <?php endif; ?>

                                <tr id="" height="25px" style="" class="tr_dpa_<?=$u->kode_usulan_belanja?>" >
                                    <td colspan="8" style="text-align:center">- kosong -</td>
                                </tr>
                                <tr id="" height="25px" style="" class="tr_dpa_<?=$u->kode_usulan_belanja?>" >
                                    <td colspan="8" style="text-align:center"></td>
                                </tr>

                                <?php $i=0; foreach($detail_rsa_dpa as $ul){ ?>
                                    <?php $impor = $ul->impor; ?>
                                    <?php if(( $value6digit['kode_usulan_belanja'] == $u->kode_usulan_belanja) && (substr($valdetail['proses'],1,1) == $jenis) ): ?>
                                    <tr id="tr_<?=$value6digit['kode_usulan_belanja']?><?php echo $keydetail ;?>" height="25px">
                                        <td style="text-align: right">
                                            <?php if(substr($valdetail['proses'],1,1)==4){ ?>
                                                <input type="hidden" class="id_kontrak_<?php echo $value6digit['kode_usulan_belanja'].$keydetail; ?>" value="<?php echo $kontrak[$value6digit['kode_usulan_belanja'].$keydetail][0]->id; ?>"/>
                                            <?php } ?>

                                            <?php
                                            if(substr($valdetail['proses'],1,1)=='1'){
                                                echo '<span class="badge badge-gup" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">GP</span>';
                                            }
                                            elseif(substr($valdetail['proses'],1,1)=='2'){
                                                echo '<span class="badge badge-lp" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">LP</span>';
                                            }
                                            elseif(substr($valdetail['proses'],1,1)=='4'){
                                                echo '<span class="badge badge-l3" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">LK</span>';
                                            }
                                            elseif(substr($valdetail['proses'],1,1)=='3'){
                                                echo '<span class="badge badge-tup" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">TP</span>';
                                            }
                                            elseif(substr($valdetail['proses'],1,1)=='5'){
                                                echo '<span class="badge badge-ks" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">KS</span>';
                                            }
                                            elseif(substr($valdetail['proses'],1,1)=='6'){
                                                echo '<span class="badge badge-ln" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">LN</span>';
                                            }
                                            elseif(substr($valdetail['proses'],1,1)=='7'){
                                                echo '<span class="badge badge-em" id="badge_id_'.$value6digit['kode_usulan_belanja'].$keydetail.'">EM</span>';
                                            }
                                            else{} ?>
                                            <?=$keydetail?>
                                        </td>
                                        <td ><?=$ul->deskripsi?></td>
                                        <td ><?=$ul->volume + 0?></td>
                                        <td ><?=$ul->satuan?></td>
                                        <td style="text-align: right"><?=number_format($ul->harga_satuan, 0, ",", ".")?></td>
                                        <td style="text-align: right" id="td_sub_tot_<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>">
                                            <?php $total_ = $total_ + ($ul->volume*$ul->harga_satuan); ?>
                                            <?php $total_per_akun = $total_per_akun + ($ul->volume*$ul->harga_satuan); ?>
                                            <?=number_format($ul->volume*$ul->harga_satuan, 0, ",", ".")?>
                                        </td>
                                            <?php if(substr($valdetail['proses'],0,1) == 0) : ?>
                                                <td align="center">
                                                    <buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$value6digit['kode_usulan_belanja']?>" >
                                                        <span class="glyphicon glyphicon-share" aria-hidden="true"></span>
                                                    </buttton>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm" rel="<?php echo $valdetail['id_rsa_detail'] ;?>" id="proses_<?php echo $valdetail['id_rsa_detail'] ;?>" aria-label="Center Align">
                                                        <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                                                    Proses</button>
                                                </td>
                                                <?php elseif(substr($valdetail['proses'],0,1) == 3): ?>
                                                <td align="center">
                                                    <button type="button" class="btn btn-sm btn-default btn-ajx" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" onclick="bootbox.alert('sedang memuat status..')" title="wait..">
                                                            <i class="glyphicon glyphicon-repeat"></i>
                                                    </button>
                                                    <?php if( $jenis==4 ): ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <?php if(is_null($ul->id_kuitansi)): ?>
                                                                <input type="checkbox" aria-label="" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" class="ck_<?php echo $value6digit['kode_usulan_belanja'] ;?><?=$keydetail?>">
                                                            <?php else: ?>
                                                                <?php if( $ul->aktif == '1' ) : ?>
                                                                <input type="checkbox" disabled="disabled" checked="checked" aria-label="" rel="" class="">
                                                                <?php else: ?>
                                                                <input type="checkbox" aria-label="" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" class="ck_<?php echo $value6digit['kode_usulan_belanja'] ;?><?=$keydetail?>">
                                                                <?php endif; ?>
                                                            <?php endif;?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <?php elseif(substr($valdetail['proses'],0,1) == 4): ?>
                                                <td align="center">
                                                    <button type="button" class="btn btn-sm btn-default btn-ajx" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" onclick="bootbox.alert('sedang memuat status..')" title="wait.."><i class="glyphicon glyphicon-repeat"></i></button>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" disabled="disabled" checked="checked" aria-label="" rel="" class="">
                                                        </span>
                                                    </div>
                                                </td>
                                                <?php elseif(substr($valdetail['proses'],0,1) == 5): ?>
                                                <td align="center">
                                                    <button type="button" class="btn btn-sm btn-default btn-ajx" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" onclick="bootbox.alert('sedang memuat status..')" title="wait.."><i class="glyphicon glyphicon-repeat"></i></button>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" disabled="disabled" checked="checked" aria-label="" rel="" class="">
                                                        </span>
                                                    </div>
                                                </td>
                                                <?php elseif(substr($valdetail['proses'],0,1) == 6): ?>
                                                <td align="center">
                                                    <button type="button" class="btn btn-sm btn-default btn-ajx" rel="<?=$value6digit['kode_usulan_belanja']?><?=$keydetail?>" onclick="bootbox.alert('sedang memuat status..')" title="wait.."><i class="glyphicon glyphicon-repeat"></i></button>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" disabled="disabled" checked="checked" aria-label="" rel="" class="">
                                                        </span>
                                                    </div>
                                                </td>
                                            <?php else: ?>
                                                <td align="center">&nbsp;</td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align">
                                                        <span class="glyphicon glyphicon-export" aria-hidden="true"></span> 
                                                        Proses
                                                    </button>
                                                </td>
                                            <?php endif; ?>
                                    </tr>
                                    <?php endif; ?>

                                    <?php $i++; } ?>
                                    <tr class="alert alert-danger" id="tr_usulan_<?=$u->kode_usulan_belanja?>">
                                        <td colspan="4" style="text-align: right;">Anggaran</td>
                                        <td style="text-align: right;">:</td>
                                        <td style="text-align: right;" rel="<?=$u->kode_usulan_belanja?>" id="td_usulan_<?=$u->kode_usulan_belanja?>"><?=number_format($u->total_harga, 0, ",", ".")?></td>
                                        <td >&nbsp;</td>
                                        <td >&nbsp;</td>
                                    </tr>
                                    <tr class="alert alert-info" id="tr_total_<?=$u->kode_usulan_belanja?>">
                                        <td colspan="4" style="text-align: right;">Usulan</td>
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

                                <?php else: ?>

                                <?php endif; ?>
                                    <tr id="tr_kosong" height="25px" style="display: none" class="alert alert-warning" >
                                        <td colspan="8">- kosong / belum disetujui -</td>
                                    </tr>
                        </tbody>
                        <tfoot>
                            <tr id="" height="25px">
                                <td colspan="8">&nbsp;</td>
                            </tr>
                        </tfoot>
                    </table>
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
            <div class="modal-body" style="margin:0px;padding:15px;background-color: #EEE;">
                <?php if($jenis == '4'): ?>
                    <!--- TIDAK JADI DIPAKAI -->
                <?php endif; ?>
                <div id="div-cetak">
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
                           <td colspan="2"><?=$tahun?></td>
                        </tr>
                        <tr>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>

                            <td colspan="2">Nomor Bukti</td>
                            <td style="text-align: center">:</td>
                            <td colspan="2" id="no_bukti">-</td>
                        </tr>
                        <tr class="tr_up">
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td colspan="2">Anggaran</td>
                            <td style="text-align: center">:</td>
                            <td colspan="2" id="txt_akun">-</td>
                        </tr>
                        <tr>
                            <td colspan="11">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <h4 style="text-align: center"><b>KUITANSI / BUKTI PEMBAYARAN</b></h4>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11">&nbsp;</td>
                        </tr>
                        <tr class="tr_up">
                            <td colspan="3">Sudah Diterima dari</td>
                            <td>: </td>
                            <td colspan="7">Pejabat Pembuat Komitmen/ Pejabat Pelaksana dan Pengendali Kegiatan SUKPA <?=$nm_unit?></td>
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
                            <td colspan="7"><span id="uraian" class="input_boot" style="cursor:pointer" title="iiii">- edit here -</span></td> <!--contenteditable="true" class="edit_here"-->
                        </tr>
                        <tr class="tr_up">
                            <td colspan="3">Sub Kegiatan</td>
                            <td>: </td>
                            <td colspan="7"><span id="nm_subkomponen_kuitansi">-</span></td>
                        </tr>
                        <tr>
                            <td colspan="11">&nbsp;

                            </td>
                        </tr>
                        <tr>
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
                            <td colspan="11">tr_si</td>
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
                            <td colspan="11">&nbsp;

                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" style="vertical-align: top;">Setuju dibebankan pada mata anggaran berkenaan, <br />
                                a.n. Kuasa Pengguna Anggaran <br />
                                <?php if($jenis== '4'): ?>
                                    Pejabat Pembuat Komitmen (PPK)
                                <?php else: ?>
                                    Pejabat Pelaksana dan Pengendali Kegiatan (PPPK)
                                <?php endif; ?>
                            </td>
                            <td colspan="4" style="vertical-align: top;">
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y"); ?><br />
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
                            <td colspan="7" style="border-bottom: 1px solid #000;vertical-align: bottom;">
                                <span class="edit_here" id="nmpppk" style="cursor:pointer"><?php // $pic_kuitansi['pppk_nm_lengkap']; ?>- edit here -</span><br>
                                NIP. <span class="edit_here" id="nippppk" style="cursor:pointer"><?php // $pic_kuitansi['pppk_nip'] ; ?>- edit here -</span>
                            </td>
                            <td colspan="4" style="border-bottom: 1px solid #000;vertical-align: bottom;"><span class="input_boot" style="cursor:pointer;white-space: pre-line;" id="penerima_uang">- edit here -</span><br />
                                NIP. <span class="input_boot" style="cursor:pointer" id="penerima_uang_nip">- edit here -</span>
                            </td>
                        </tr>
                        <tr >
                            <?php if($_SESSION['rsa_level'] == 13) : ?>
                                <td colspan="11">Setuju dibayar tgl : <br>
                                    Bendahara Pengeluaran
                                </td>
                            <?php else: ?>
                                <td colspan="7">Setuju dibayar tgl : <br>
                                    Bendahara Pengeluaran
                                </td>
                                <td colspan="4">Lunas dibayar tgl :<br>
                                    Pemegang Uang Muka Kerja
                                </td>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <?php if($_SESSION['rsa_level'] == 13) : ?>
                               <td colspan="11"><span id="nmbendahara"><?=$pic_kuitansi['bendahara_nm_lengkap']?></span><br>
                                   NIP. <span id="nipbendahara"><?=$pic_kuitansi['bendahara_nip']?></span>
                               </td>
                           <?php else: ?>
                                <td colspan="7"><span id="nmbendahara"><?=$pic_kuitansi['bendahara_nm_lengkap']?></span><br>
                                    NIP. <span id="nipbendahara"><?=$pic_kuitansi['bendahara_nip']?></span>
                                </td>
                                <td colspan="4"><span id="nmpumk"><?php echo isset($pumk->nm_lengkap)?$pumk->nm_lengkap:''; ?></span><br>
                                    NIP. <span id="nippumk"><?php echo isset($pumk->nomor_induk)?$pumk->nomor_induk:''; ?></span>
                                </td>
                            <?php endif; ?>
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
                            <td colspan="11" ><span class="input_boot" id="penerima_barang" style="cursor:pointer">- edit here -</span><br />
                                NIP. <span class="input_boot" id="penerima_barang_nip" style="cursor:pointer">- edit here -</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-submit-kuitansi" rel="" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Submit</button>
                <button type="button" class="btn btn-info" id="cetak" rel="" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SELECT PAJEK -->
<div class="modal" id="myModalPajak" rel="">
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
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="81_ppn" id="pj_p_81" name="pajak[80][0]" type="checkbox" class="pj_p_ppn" value="89" />
                                      Custom
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                      <input rel="81" id="pj_dpp_81" disabled="disabled" class="pj_dpp_ppn" name="pajak[80][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_81" class="form-control input-sm pj_nilai_ppn xnumber validate[required]" disabled="disabled" name="pajak[80][2]" type="text" />
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
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="51_pphps21" id="pj_p_51" name="pajak[41][0]" type="checkbox" class="pj_p_pphps21" value="98" />
                                      Custom
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                      <input rel="51" id="pj_dpp_51" disabled="disabled" class="pj_dpp_pphps21" name="pajak[41][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_51" class="form-control input-sm pj_nilai_pphps21 xnumber validate[required]" disabled="disabled" name="pajak[41][2]" type="text" />
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
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="71_pphps22" id="pj_p_71" name="pajak[61][0]" type="checkbox" class="pj_p_pphps22" value="97" />
                                      Custom
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                      <input rel="71" id="pj_dpp_71" disabled="disabled" class="pj_dpp_pphps22" name="pajak[61][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_71" class="form-control input-sm pj_nilai_pphps22 xnumber validate[required]" disabled="disabled" name="pajak[61][2]" type="text" />
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
                                      <input rel="8" id="pj_dpp_8" disabled="disabled" class="pj_dpp_pphps23" name="pajak[7][1]" type="checkbox" value="1" />
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
                                      <input rel="9" id="pj_dpp_9" disabled="disabled" class="pj_dpp_pphps23" name="pajak[8][1]" type="checkbox" value="1" />
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
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="101_pphps23" id="pj_p_101" name="pajak[91][0]" type="checkbox" class="pj_p_pphps23" value="96" />
                                      Custom
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                      <input rel="101" id="pj_dpp_101" disabled="disabled" class="pj_dpp_pphps23" name="pajak[91][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_101" class="form-control input-sm pj_nilai_pphps23 xnumber validate[required]" disabled="disabled" name="pajak[91][2]" type="text" />
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
                                      <input rel="11" id="pj_dpp_11" disabled="disabled" class="pj_dpp_pphps26" name="pajak[10][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_11" class="form-control input-sm pj_nilai_pphps26" disabled="disabled" name="pajak[10][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="111_pphps26" id="pj_p_111" name="pajak[101][0]" type="checkbox" class="pj_p_pphps26" value="95" />
                                      Custom
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                      <input rel="111" id="pj_dpp_111" disabled="disabled" class="pj_dpp_pphps26" name="pajak[101][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_111" class="form-control input-sm pj_nilai_pphps26 xnumber validate[required]" disabled="disabled" name="pajak[101][2]" type="text" />
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
                                      <input rel="12" id="pj_dpp_12" disabled="disabled" class="pj_dpp_pphps42" name="pajak[11][1]" type="checkbox" value="1" />
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
                                      <input rel="13" id="pj_dpp_13" disabled="disabled" class="pj_dpp_pphps42" name="pajak[12][1]" type="checkbox" value="1" />
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
                                      <input rel="14" id="pj_dpp_14" disabled="disabled" class="pj_dpp_pphps42" name="pajak[13][1]" type="checkbox" value="1" />
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
                                      <input rel="15" id="pj_dpp_15" disabled="disabled" class="pj_dpp_pphps42" name="pajak[14][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_15" class="form-control input-sm pj_nilai_pphps42" disabled="disabled" name="pajak[14][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                      <input rel="151_pphps42" id="pj_p_151" name="pajak[141][0]" type="checkbox" class="pj_p_pphps42" value="94" />
                                      Custom
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                      <input rel="151" id="pj_dpp_151" disabled="disabled" class="pj_dpp_pphps42" name="pajak[141][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_151" class="form-control input-sm pj_nilai_pphps42 xnumber validate[required]" disabled="disabled" name="pajak[141][2]" type="text" />
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
                                      <input rel="16" id="pj_dpp_16" disabled="disabled" class="pj_dpp_lainnya" name="pajak[15][1]" type="checkbox" value="1" />
                                    </label>
                                  </div>
                            </td>
                            <td>
                                <input id="pj_nilai_16" class="form-control input-sm pj_nilai_lainnya xnumber validate[required]" disabled="disabled" name="pajak[15][2]" type="text" />
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
<div class="modal" id="myModalPajakEdit" rel="">
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
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input rel="81_ppn" id="edit_pj_p_81" name="pajak[80][0]" type="checkbox" class="edit_pj_p_ppn" value="89" />
                                        Custom
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                        <input rel="81" id="edit_pj_dpp_81" disabled="disabled" class="edit_pj_dpp_ppn" name="pajak[80][1]" type="checkbox" value="1" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_81" class="form-control input-sm edit_pj_nilai_ppn xnumber validate[required]" disabled="disabled" name="pajak[80][2]" type="text" />
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
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input rel="51_pphps21" id="edit_pj_p_51" name="pajak[41][0]" type="checkbox" class="edit_pj_p_pphps21" value="98" />
                                        Custom
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                        <input rel="51" id="edit_pj_dpp_51" disabled="disabled" class="edit_pj_dpp_pphps21" name="pajak[41][1]" type="checkbox" value="1" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_51" class="form-control input-sm edit_pj_nilai_pphps21 xnumber validate[required]" disabled="disabled" name="pajak[41][2]" type="text" />
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
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input rel="71_pphps22" id="edit_pj_p_71" name="pajak[61][0]" type="checkbox" class="edit_pj_p_pphps22" value="97" />
                                        Custom
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                        <input rel="71" id="edit_pj_dpp_71" disabled="disabled" class="edit_pj_dpp_pphps22" name="pajak[61][1]" type="checkbox" value="1" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_71" class="form-control input-sm edit_pj_nilai_pphps22 xnumber validate[required]" disabled="disabled" name="pajak[61][2]" type="text" />
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
                                        <input rel="8" id="edit_pj_dpp_8" disabled="disabled" class="edit_pj_dpp_pphps23" name="pajak[7][1]" type="checkbox" value="1" />
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
                                        <input rel="9" id="edit_pj_dpp_9" disabled="disabled" class="edit_pj_dpp_pphps23" name="pajak[8][1]" type="checkbox" value="1" />
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
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input rel="101_pphps23" id="edit_pj_p_101" name="pajak[91][0]" type="checkbox" class="edit_pj_p_pphps23" value="96" />
                                        Custom
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                        <input rel="101" id="edit_pj_dpp_101" disabled="disabled" class="edit_pj_dpp_pphps23" name="pajak[91][1]" type="checkbox" value="1" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_101" class="form-control input-sm edit_pj_nilai_pphps23 xnumber validate[required]" disabled="disabled" name="pajak[91][2]" type="text" />
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
                                        <input rel="11" id="edit_pj_dpp_11" disabled="disabled" class="edit_pj_dpp_pphps26" name="pajak[10][1]" type="checkbox" value="1" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_11" class="form-control input-sm edit_pj_nilai_pphps26" disabled="disabled" name="pajak[10][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input rel="111_pphps26" id="edit_pj_p_111" name="pajak[101][0]" type="checkbox" class="edit_pj_p_pphps26" value="95" />
                                        Custom
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                        <input rel="111" id="edit_pj_dpp_111" disabled="disabled" class="edit_pj_dpp_pphps26" name="pajak[101][1]" type="checkbox" value="1" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_111" class="form-control input-sm edit_pj_nilai_pphps26 xnumber validate[required]" disabled="disabled" name="pajak[101][2]" type="text" />
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
                                        <input rel="12" id="edit_pj_dpp_12" disabled="disabled" class="edit_pj_dpp_pphps42" name="pajak[11][1]" type="checkbox" value="1" />
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
                                        <input rel="13" id="edit_pj_dpp_13" disabled="disabled" class="edit_pj_dpp_pphps42" name="pajak[12][1]" type="checkbox" value="1" />
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
                                        <input rel="14" id="edit_pj_dpp_14" disabled="disabled" class="edit_pj_dpp_pphps42" name="pajak[13][1]" type="checkbox" value="1" />
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
                                        <input rel="15" id="edit_pj_dpp_15" disabled="disabled" class="edit_pj_dpp_pphps42" name="pajak[14][1]" type="checkbox" value="1" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_15" class="form-control input-sm edit_pj_nilai_pphps42" disabled="disabled" name="pajak[14][2]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input rel="151_pphps42" id="edit_pj_p_151" name="pajak[141][0]" type="checkbox" class="edit_pj_p_pphps42" value="94" />
                                        Custom
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox" style="display: none">
                                    <label>
                                        <input rel="151" id="edit_pj_dpp_151" disabled="disabled" class="edit_pj_dpp_pphps42" name="pajak[141][1]" type="checkbox" value="1" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_151" class="form-control input-sm edit_pj_nilai_pphps42 xnumber validate[required]" disabled="disabled" name="pajak[141][2]" type="text" />
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
                                        <input rel="16" id="edit_pj_dpp_16" disabled="disabled" class="edit_pj_dpp_lainnya" name="pajak[15][1]" type="checkbox" value="1" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input id="edit_pj_nilai_16" class="form-control input-sm edit_pj_nilai_lainnya xnumber validate[required]" disabled="disabled" name="pajak[15][2]" type="text" />
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
                    Anda akan membatalkan DPA ?<br />
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

<?php
if($this->cantik_model->manual_override()){
    ?>
    <style>
    #form_kriteria label{
        display:inline;
        margin-bottom: inherit;
        font-weight: normal;
        max-width: inherit;
        font-size: 90%;
    }
</style>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_override" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
    <!-- /.modal-content -->
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_kriteria" method="post" enctype="multipart/form-data">
                <input type="hidden" id="act" name="act" value="override_spp"/>
                <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-question-sign"></i>&nbsp;<!-- Manual Override --> Kriteria untuk SPP dan SPM LS-PGW</h5>
                </div>
                <div class="modal-body">
                    <?php
                    if(strlen(trim($this->cantik_model->get_keterangan_override()))>0){
                        ?>
                        <div class="alert alert-warning small text-center" style="padding:3px;"><?php echo $this->cantik_model->get_keterangan_override(); ?></div>
                        <?php
                    }

                    if($this->uri->segment(4)=='APBN-BPPTNBH'){
                        ?>
                        <input type="hidden" id="beda" name="beda" value="<?php echo $this->uri->segment(4); ?>"/>
                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jenis SPP LS-PGW :</label>
                                <?php echo $jenisOption; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Potongan Pajak (keseluruhan):</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control input-sm kepeg_numeric" name="pajak" required="required" placeholder="0" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Potongan Lainnya (keseluruhan):</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control input-sm kepeg_numeric" name="potongan" required="required" placeholder="0"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label for="unit_id">Unit Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_unit_id"/>&nbsp;cek semua</label></label>
                                <div class="row">
                                    <?php
                                    if(strlen(trim($unitList))>0){ echo $unitList; }else{ echo "<p class=\"text-center text-info\" style=\"border:1px solid #31708f;margin-left:10px;margin-right:10px;\">Tidak perlu memilih unit untuk membuat SPP</p>"; }
                                        ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group">
                                    <label for="status_kepeg">Status Kepegawaian:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_status_kepeg"/>&nbsp;cek semua</label></label>
                                    <div class="row">
                                        <?php echo $statusKepegOption; ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-12">
                                        <label>Status Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" class="master_status"/>&nbsp;cek semua</label></label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    $stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar', '13'=>'Diberhentikan Sementara');
                                    foreach ($stt as $k => $v) {
                                        $ch = "";
                                        if(isset($_SESSION['ovr']['status']) && in_array($k,$_SESSION['ovr']['status'])){
                                            $ch = " checked = \"checked\"";
                                        }
                                        ?>
                                        <div class="small col-md-3 col-sm-6 col-xs-12">
                                            <label>
                                                <input type="checkbox" class="status" name="status[]" id="status" value="<?php echo $k; ?>"<?php echo $ch; ?>/>
                                                <?php echo $v; ?>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Jenis Pegawai :</span>
                                    <select name="jnspeg" id="jnspeg" class="form-control input-sm">
                                        <?php
                                        $_jenispeg = array(array(1,'Dosen Pengajar'),array(2,'Tenaga Kependidikan'));
                                        foreach ($_jenispeg as $k => $v) {
                                            $_s = "";
                                            if(isset($_SESSION['ovr']['jnspeg']) && $_SESSION['ovr']['jnspeg']==$v[0]){
                                                $_s = " selected";
                                            }
                                            ?>
                                            <option value="<?php echo $v[0]; ?>"<?php echo $_s; ?>><?php echo $v[1]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Tahun :</span>
                                    <input type="text" class="form-control input-sm" name="tahun" value="<?php echo $tahun; ?>" readonly="readonly"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group" id="bulan_input_group" style="display: none;">
                                    <span class="input-group-addon">Bulan<sup>*</sup> :</span>
                                    <select name="bulan" id="bulan" class="form-control input-sm">
                                        <?php
                                        echo $bulanOption;
                                        ?>
                                    </select>
                                </div>
                                <div class="input-group" id="semester_input_group">
                                    <span class="input-group-addon">Semester<sup>*</sup> :</span>
                                    <?php
                                    echo $semesterOption;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group pull-right">
                        <button type="submit" class="btn btn-primary btn-flat btn-sm what_a_fck"><i class="fa fa-spinner"></i>&nbsp;&nbsp;Proses <i>Override</i> SPP</button>
                    </div>
                </div>
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<?php
    }
?>
<!-- end here dhanu -->
<!-- // END HERE // -->

<!--// CREATED BY ALEX - DELETE BUT CONFIRM IF CAUSED ERROR //-->
<!-- dibuat oleh alex -->
<div class="modal" id="modalGedang" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp;&nbsp;&nbsp;Perhatian :</h4>
            </div>
            <form id="cocoklogi_dpa_kontrak">
                <input type="hidden" name="kode_akun_belanja" id="kode_akun_belanja" value=""/>
                <div class="modal-body" style="margin:15px;padding:0px;padding-bottom: 15px;">
                    <div class="row">
                        <div class="col-md-12">
                            <!--<div class="col-md-6">-->
                                <div class="form-group">
                                    <label for="daftar_kontrak">Daftar Kontrak:</label>
                                    <select name="daftar_kontrak" id="daftar_kontrak" class="form-control input-sm"></select>
                                </div>
                            <!--</div>-->
                        </div>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm yakin_termin"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Buat Kuitansi</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Ndak</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- POP UP PILIH PENCAIRAN -->
<div class="modal " id="myModalKuitansi2" role="dialog" aria-labelledby="myModalKuitansiLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Kuitansi : <span id="kode_badge">-</span></h4>
            </div>
            <div class="modal-body" style="margin:0px;padding:15px;background-color: #EEE;">
                <div id="div-cetak">
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
                            <td colspan="2"><?=$tahun?></td>
                        </tr>
                        <tr>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>

                            <td colspan="2">Nomor Bukti</td>
                            <td style="text-align: center">:</td>
                            <td colspan="2" id="no_bukti">-</td>
                        </tr>
                        <tr class="tr_up">
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>

                            <td colspan="2">Anggaran</td>
                            <td style="text-align: center">:</td>
                            <td colspan="2" id="txt_akun">-</td>

                        </tr>
                        <tr>
                            <td colspan="11">&nbsp;

                            </td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <h4 style="text-align: center"><b>KUITANSI / BUKTI PEMBAYARAN</b></h4>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11">&nbsp;

                            </td>
                        </tr>
                        <tr class="tr_up">
                            <td colspan="3">Sudah Diterima dari</td>
                            <td>: </td>
                            <td colspan="7">Pejabat Pembuat Komitmen/ Pejabat Pelaksana dan Pengendali Kegiatan SUKPA <?=$nm_unit?></td>
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
                            <td colspan="7"><span class="edit_here" contenteditable="true" placeheld="yes" id="uraian" >- edit here -</span></td>
                        </tr>
                        <tr class="tr_up">
                            <td colspan="3">Sub Kegiatan</td>
                            <td>: </td>
                            <td colspan="7"><span id="nm_subkomponen_kuitansi">-</span></td>
                        </tr>
                        <tr>
                            <td colspan="11">&nbsp;

                            </td>
                        </tr>
                        <tr>
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
                            <td colspan="11">tr_si</td>
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
                            <td colspan="11">&nbsp;

                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">Setuju dibebankan pada mata anggaran berkenaan, <br />
                                a.n. Kuasa Pengguna Anggaran <br />
                                Pejabat Pelaksana dan Pengendali Kegiatan (PPPK)
                            </td>
                            <td colspan="4">
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y"); ?><br />
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
                            <td colspan="7" style="border-bottom: 1px solid #000">
                                <span class="edit_here" contenteditable="true" id="nmpppk"><?php // $pic_kuitansi['pppk_nm_lengkap']; ?>- edit here -</span><br>
                                NIP. <span class="edit_here" contenteditable="true" id="nippppk"><?php // $pic_kuitansi['pppk_nip'] ; ?>- edit here -</span></td>
                            <td colspan="4" style="border-bottom: 1px solid #000"><span class="edit_here" contenteditable="true" id="penerima_uang">- edit here -</span><br />
                                    <!--NIP. <span class="edit_here" contenteditable="true" id="penerima_uang_nip">- edit here -</span></td>-->
                        </tr>
                        <tr >
                            <?php if($_SESSION['rsa_level'] == 13) : ?>
                            <td colspan="11">Setuju dibayar tgl : <br>
                                Bendahara Pengeluaran
                            </td>
                            <?php else: ?>
                            <td colspan="7">Setuju dibayar tgl : <br>
                                Bendahara Pengeluaran
                            </td>
                            <td colspan="4">Lunas dibayar tgl :<br>
                                Pemegang Uang Muka Kerja
                            </td>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <?php if($_SESSION['rsa_level'] == 13) : ?>
                             <td colspan="11"><span id="nmbendahara"><?=$pic_kuitansi['bendahara_nm_lengkap']?></span><br>
                                 NIP. <span id="nipbendahara"><?=$pic_kuitansi['bendahara_nip']?></span>
                            </td>
                            <?php else: ?>
                            <td colspan="7"><span id="nmbendahara"><?=$pic_kuitansi['bendahara_nm_lengkap']?></span><br>
                                 NIP. <span id="nipbendahara"><?=$pic_kuitansi['bendahara_nip']?></span>
                            </td>
                            <td colspan="4"><span id="nmpumk"><?php echo isset($pumk->nm_lengkap)?$pumk->nm_lengkap:''; ?></span><br>
                                    NIP. <span id="nippumk"><?php echo isset($pumk->nomor_induk)?$pumk->nomor_induk:''; ?></span>
                            </td>
                            <?php endif; ?>
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
                            <td colspan="11" ><span class="edit_here" contenteditable="true" id="penerima_barang">- edit here -</span><br />
                                NIP. <span class="edit_here" contenteditable="true" id="penerima_barang_nip">- edit here -</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-submit-kuitansi2" rel="" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Submit</button>
                <button type="button" class="btn btn-info" id="cetak" rel="" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- END HERE -->

<div class="modal" id="myModalUraian" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Uraian Kegiatan</h4>
            </div>
            <div class="modal-body" style="">
                <div class="alert alert-danger">
                    <b>Perhatian :</b> <br />
                    <ul>
                        <li>Total dari jumlah rupiah uraian yang diisi harus sama dengan jumlah rupiah dari kegiatan.</li>
                        <li>Apabila tidak sama maka dpa harus dibatalkan dan diusulan sesuai dengan realisasi.</li>
                    </ul>
                </div>
                <div class="alert alert-warning">
                    <button class="btn btn-warning btn-sm" id="uraian_tambah" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah</button>
                    <button class="btn btn-success btn-sm" id="uraian_simpan" ><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Simpan</button>
                </div>
                <table class="table">
                    <tbody>
                        <tr id="tr_head">
                            <td class="col-md-3">Uraian</td>
                            <td class="col-md-1">Kuantitas</td>
                            <td class="col-md-1">Satuan</td>
                            <td class="col-md-2">Harga@</td>
                            <td class="col-md-2">Bruto</td>
                            <td class="col-md-1">Pajak</td>
                            <td class="col-md-2">Netto</td>
                        </tr>
                        <tr>
                            <!--<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>-->
                            <td>
                                <textarea name="uraian_text" class="validate[required] form-control input-sm" id="uraian_text" rows="1"></textarea>
                            </td>
                            <td><input type="text" name="uraian_kuantitas" class="validate[required] form-control input-sm xnumber" id="uraian_kuantitas" ></td>
                            <td><input type="text" name="uraian_satuan" class="validate[required] form-control input-sm" id="uraian_satuan" ></td>
                            <td><input type="text" name="uraian_harga" class="validate[required] form-control input-sm xnumber" id="uraian_harga" ></td>
                            <td style="text-align: right"><span id="uraian_bruto" >100.000.000</span></td>
                            <td>[ <a href="#" >edit</a> ]</td>
                            <td style="text-align: right"><span id="uraian_netto" >100.000.000</span></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">&nbsp;</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" id="uraian_submit"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Submit</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- POP UP PILIH P3K -->
<div class="modal" id="myModalP3K" tabindex="-1" role="dialog" aria-labelledby="myModalKas">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php if($jenis=='4'): ?>
                        <label for="exampleInputEmail1">Pilih PPK :</label>
                            <?php if(!empty($ppk)): ?>
                                <?php foreach($ppk as $p): ?>
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="radio" aria-label="" rel="" class="rdo_up" name="id_user" value="<?=$p->id?>">
                                        </span>
                                        <input type="hidden" value="<?=$p->nm_lengkap?>" name="nm_input_<?=$p->id?>" id="nm_input_<?=$p->id?>" />
                                        <input type="hidden" value="<?=$p->nomor_induk?>" name="nip_input_<?=$p->id?>" id="nip_input_<?=$p->id?>" />
                                        <input type="text" class="form-control" aria-label="" value="<?=$p->nm_lengkap?>" readonly="readonly">
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                </div>
                                <?php endforeach;?>
                            <?php else: ?>
                            <div class="alert alert-warning">
                                Anda belum mengusulkan pejabat PPK kepusat.
                            </div>
                            <?php endif; ?>
                    <?php else: ?>

                        <label for="exampleInputEmail1">Pilih PPPK :</label>
                        <?php if(!empty($pppk)): ?>
                            <?php foreach($pppk as $p): ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="radio" aria-label="" rel="" class="rdo_up" name="id_user" value="<?=$p->id?>">
                                            </span>
                                            <input type="hidden" value="<?=$p->nm_lengkap?>" name="nm_input_<?=$p->id?>" id="nm_input_<?=$p->id?>" />
                                            <input type="hidden" value="<?=$p->nomor_induk?>" name="nip_input_<?=$p->id?>" id="nip_input_<?=$p->id?>" />
                                            <input type="text" class="form-control" aria-label="" value="<?=$p->nm_lengkap?>" readonly="readonly">
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 -->
                                </div>
                            <?php endforeach;?>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                Anda belum mengusulkan pejabat PPPK kepusat.
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-pilih-pppk-ojo-dikopi-id-iki-yo-lek" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Pilih</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- POP UP PILIH P3K3 copy alaik -->
<div class="modal" id="myModalP3K3" tabindex="-1" role="dialog" aria-labelledby="myModalKas">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Pilih PPPK :</label>
                    <?php if(!empty($pppk)): ?>
                        <?php foreach($pppk as $p): ?>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="radio" aria-label="" rel="" class="rdo_up" name="id_user" value="<?=$p->id?>">
                                        </span>
                                        <input type="hidden" value="<?=$p->nm_lengkap?>" name="nm_input_<?=$p->id?>" id="nm_input_<?=$p->id?>" />
                                        <input type="hidden" value="<?=$p->nomor_induk?>" name="nip_input_<?=$p->id?>" id="nip_input_<?=$p->id?>" />
                                        <input type="text" class="form-control" aria-label="" value="<?=$p->nm_lengkap?>" readonly="readonly">
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->

                            </div>

                        <?php endforeach;?>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            Anda belum mengusulkan pejabat PPPK kepusat.
                        </div>
                    <?php endif; ?>
                </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-pilih-pppk" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Pilih</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
          </div>
        </div>
    </div>
</div>
