<script type="text/javascript">
$(document).ready(function(){

        $('#backi').click(function(){
            window.location = "<?=site_url("dpa/daftar_dpa/").$sumber_dana?>";
        });

        // $('.xfloat').tooltip();

    $('body').tooltip({
        selector: '.xfloat'
    });

        $(document).on("click",'[id^="proses_"]',function(){
            var id_rsa_detail = $(this).attr('rel');
//            var kode_usulan_belanja = kode_usulan_belanja_kode_akun_tambah.substr(0, 24);
//            var kode_akun_tambah = kode_usulan_belanja_kode_akun_tambah.substr(24, 3);
//            console.log(kode_usulan_belanja + ' - ' + kode_akun_tambah);
            if(confirm('Yakin akan memproses ?')){
                var data = "id_rsa_detail=" + id_rsa_detail;
                $.ajax({
                    type:"POST",
                    url :"<?=site_url("tor/proses_tor_rsa_detail")?>",
                    data:data,
                    success:function(data){
                            // $("#subunit").html(respon);
    //                        console.log(respon);
                            //$('#row_space').html(respon);
                                if(data == 'sukses'){
                                    location.reload();

                               }
                    }
                });

            }

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

            var kode_usulan_belanja = $(this).attr('rel');

                if($(this).val()==''){
                        $(this).val('0');

                }
                else{
                        var str = $(this).val();
                        $(this).val(string_to_angka(str));

                        calcinput(kode_usulan_belanja);

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

        // $('input.xnumber').focusout(function() {
        $(document).on("focusout","input.xfloat",function(){

            var kode_usulan_belanja = $(this).attr('rel');

                if($(this).val()==''){
                        $(this).val('0');

                }
                else{
                        // var str = $(this).val();
                        // $(this).val(string_to_angka(str));

                        calcinput(kode_usulan_belanja);

                        //alert(str);
                        //$(this).val(str);
                }

        });


        // $('input.xnumber').keyup(function(event) {
        $(document).on("keyup","input.xfloat",function(event){

            var val = $(this).val();
            if(isNaN(val)){
                 val = val.replace(/[^0-9\.]/g,'');
                 if(val.split('.').length>2) 
                     val =val.replace(/\.+$/,"");
            }
            $(this).val(val); 

        });

        		// $('#tambah').click(function(){
        $(document).on("click",'[id^="tambah_"]',function(){
            var kode_usulan_belanja = $(this).attr('rel');

            if($('#deskripsi_' + kode_usulan_belanja).validationEngine('validate') && $('#volume_' + kode_usulan_belanja).validationEngine('validate') && $('#satuan_' + kode_usulan_belanja).validationEngine('validate') && $('#tarif_' + kode_usulan_belanja).validationEngine('validate')){

                var total_usulan = parseInt(string_to_angka($("#td_usulan_" + kode_usulan_belanja ).html()));
                var total_rsa = parseInt(string_to_angka($("#td_kumulatif_" + kode_usulan_belanja ).html()));
                var total_rsa_sisa = parseInt(string_to_angka($("#td_kumulatif_sisa_" + kode_usulan_belanja ).html()));
                var jumlah = parseInt(string_to_angka($("#jumlah_" + kode_usulan_belanja ).val()));

//            console.log(total_usulan + ' - ' + total_rsa + ' - ' + jumlah );

                if(total_usulan >= ( total_rsa + jumlah)){


    //                    console.log(kode_usulan_belanja);
                        $.ajax({
                                type: 'post',
                                url: '<?php echo site_url('tor/add_rsa_detail_belanja');?>' ,
                                data: 'kode_usulan_belanja=' + kode_usulan_belanja + '&deskripsi=' + encodeURIComponent($('#deskripsi_' + kode_usulan_belanja).val()) + '&sumber_dana=<?=$sumber_dana?>&volume=' + $('#volume_' + kode_usulan_belanja).val() + '&satuan=' + $('#satuan_' + kode_usulan_belanja).val() + '&harga_satuan=' + $('#tarif_' + kode_usulan_belanja).val() + '&kode_akun_tambah=' + $('#kode_akun_tambah_' + kode_usulan_belanja).val() + '&revisi=' + $('#revisi_' + kode_usulan_belanja).val() + '&impor=' + $('#impor_' + kode_usulan_belanja).val() ,
                                success: function(data) {
                                         if(data == 'sukses'){
                                              location.reload();

                                         }
                                }
                        });

                }else{
                    alert('Tidak bisa karena jumlah melebihi sisa.');
                    $("#tarif_" + kode_usulan_belanja ).focus();
                    return false;
                }
            }
        });

        $(document).on("click",'[id^="reset_"]',function(){
            var kode_usulan_belanja = $(this).attr('rel');
//            console.log(kode_usulan_belanja);
            $('#deskripsi_' + kode_usulan_belanja).val('') ;
            $('#volume_' + kode_usulan_belanja).val('') ;
            $('#satuan_' + kode_usulan_belanja).val('') ;
            $('#tarif_' + kode_usulan_belanja).val('') ;
            $('#jumlah_' + kode_usulan_belanja).val('') ;
            /*
            $('#deskripsi_' + kode_usulan_belanja).validationEngine('hide') ;
            $('#volume_' + kode_usulan_belanja).validationEngine('hide') ;
            $('#satuan_' + kode_usulan_belanja).validationEngine('hide') ;
            $('#tarif_' + kode_usulan_belanja).validationEngine('hide') ;
            */
            // $(".formError").remove();
            $('.deskripsi_' + kode_usulan_belanja + 'formError').remove();
            $('.volume_' + kode_usulan_belanja + 'formError').remove();
            $('.satuan_' + kode_usulan_belanja + 'formError').remove();
            $('.tarif_' + kode_usulan_belanja + 'formError').remove();
        });

        get_kode_akun_tambah();

        $(document).on("click",'[id^="delete_"]',function(){
//                clearinput()
//                $('#add-detail').validationEngine('hide');
//                $('#edit-detail').validationEngine('hide');
                var id_rsa_detail = $(this).attr('rel');

                if(confirm('Yakin akan menghapus ?')){
                    $.ajax({
                            type: 'post',
                            url: '<?php echo site_url('tor/delete_rsa_detail_belanja');?>' ,
                            data: 'id_rsa_detail=' + id_rsa_detail ,
                            success: function(data) {
                                     if(data == 'sukses'){
                                         location.reload();

                                     }
                            }
                    });
                }
        });


});

function doedit(rel,kode,el){
//        clearinput();
//        $('#add-detail').validationEngine('hide');
//        $('#edit-detail').validationEngine('hide');
//        $('#form-add-detail').hide();

        $('#row_space').load('<?php echo site_url('tor/refresh_row_detail_to_validate_ppk').'/'.$kode.'/'.$sumber_dana.'/'.$tahun;?>', function(){
            $('#' + rel).load('<?php echo site_url('tor/form_edit_detail_to_validate_ppk');?>/' + rel,function(){autosize($('textarea'));});
            $('#' + rel).addClass('alert-success') ;
            $('#form_add_detail_' + kode).hide();
            

        });
}

function do_yes(rel,kode,el){
//        clearinput();
//        $('#add-detail').validationEngine('hide');
//        $('#edit-detail').validationEngine('hide');
//        $('#form-add-detail').hide();
        var id_rsa_detail = rel ;
        var proses = $('#proses_' + rel).val();
//        console.log(id_rsa_detail + ' | ' + proses);
        if(confirm('Yakin akan menyetujui ?')){
                    $.ajax({
                            type: 'post',
                            url: '<?php echo site_url('tor/proses_tor_rsa_to_validate');?>' ,
                            data: 'id_rsa_detail=' + id_rsa_detail + '&proses=' + proses ,
                            success: function(data) {
                                     if(data == 'sukses'){
                                         location.reload();

                                     }
                            }
                    });

//            $('#row_space').load('<?php echo site_url('tor/refresh_row_detail_to_validate').'/'.$kode.'/'.$sumber_dana.'/'.$tahun;?>', function(){
//                $('#' + rel).load('<?php echo site_url('tor/form_edit_detail_to_validate');?>/' + rel,function(){autosize($('textarea'));});
//                $('#' + rel).addClass('alert-success') ;
//                $('#form_add_detail_' + kode).hide();
//
//            });

        }



}


function do_cek_salah(rel,kode,el,akun_tambah){

    var id_rsa_detail = rel ;
    var proses = $('#proses_' + rel).val();

    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('rsa_lsk/get_data_kontrak_by_id_rsa_detail/')?>' + id_rsa_detail ,
        success: function(r) {

            

            var data = JSON.parse(r);

            // console.log(jQuery.isEmptyObject(data));

            if(!jQuery.isEmptyObject(data)){

                    bootbox.dialog({
                            title: "Rincian Kontrak",
                            message: "No Kontrak : " + data.nomor_kontrak + "<br> Nilai Kontrak : " + angka_to_string(data.nilai_kontrak) + "<br> Nilai Terbayar : " + angka_to_string(data.kontrak_terbayar) + "<br> Termin : " + data.termin + "<br> Jenis Kegiatan : " + data.jenis_kegiatan + "<br> No BAP : " + data.nomor_bap + "<br> No BAST : " + data.nomor_bast + "<br> <br>Nilai kontrak yang terbayar tidak sama dengan nilai DPA, silahkan <u>edit</u> nilai DPA sehingga sesuai dengan nilai kontrak yang terbayar. Atau anda dapat membatalkan DPA dengan meng-klik tombol <u>batal</u>.",
                            buttons: {
                                cancel: {
                                    label: '<span class="glyphicon glyphicon-share" aria-hidden="true"></span> Kembali',
                                    className: 'btn-success',
                                },
                                noclose: {
                                    label: '<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Batal',
                                    className: 'btn-danger',
                                    callback: function(){
                                        if(confirm('Yakin akan menolak ?')){
                                            $.ajax({
                                                    type: 'post',
                                                    url: '<?php echo site_url('tor/proses_tor_rsa_to_validate');?>' ,
                                                    data: 'id_rsa_detail=' + id_rsa_detail + '&proses=0',
                                                    success: function(data) {
                                                             if(data == 'sukses'){
                                                                 location.reload();

                                                             }
                                                    }
                                            });
                                        }else{
                                            return false;
                                        }
                                    }
                                }
                            }
                        });
            }else{
                bootbox.dialog({
                            title: "PESAN",
                            message: "TIDAK DITEMUKAN DATA RINCIAN KONTRAK.<br>Silahkan anda menghubungi bagian SIKONTRAK dengan memberikan informasi :<br>kode_usulan_belanja : " + kode + "<br>kode_akun_tambah : " + akun_tambah + "<hr>CP SIKONTRAK ( WA ) : 085642630391 ( MAS IMAN ULP )",
                            buttons: {
                                cancel: {
                                    label: '<span class="glyphicon glyphicon-share" aria-hidden="true"></span> Kembali',
                                    className: 'btn-success',
                                },
                                noclose: {
                                    label: '<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Batal',
                                    className: 'btn-danger',
                                    callback: function(){
                                        if(confirm('Yakin akan menolak ?')){
                                            $.ajax({
                                                    type: 'post',
                                                    url: '<?php echo site_url('tor/proses_tor_rsa_to_validate');?>' ,
                                                    data: 'id_rsa_detail=' + id_rsa_detail + '&proses=0',
                                                    success: function(data) {
                                                             if(data == 'sukses'){
                                                                 location.reload();

                                                             }
                                                    }
                                            });
                                        }else{
                                            return false;
                                        }
                                    }
                                }
                            }
                        });
            }

        }
    });

}

function do_cek_ok(rel,kode,el,akun_tambah){

    var id_rsa_detail = rel ;
    var proses = $('#proses_' + rel).val();

    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('rsa_lsk/get_data_kontrak_by_id_rsa_detail/')?>' + id_rsa_detail ,
        success: function(r) {

            

            var data = JSON.parse(r);

            // console.log(jQuery.isEmptyObject(data));

            if(!jQuery.isEmptyObject(data)){

                    bootbox.dialog({
                            title: "Rincian Kontrak",
                            message: "No Kontrak : " + data.nomor_kontrak + "<br> Nama Bank : " + data.rekanan.bank_rekanan + "<br> Nama Rek : " + data.rekanan.nama_rekening_bank + "<br> No Rek : " + data.rekanan.rekening_rekanan + "<br> No NPWP : " + data.rekanan.npwp +  "<br> Nilai Kontrak : " + angka_to_string(data.nilai_kontrak) + "<br> Nilai Terbayar : " + angka_to_string(data.kontrak_terbayar) + "<br> Termin : " + data.termin + "<br> Jenis Kegiatan : " + data.jenis_kegiatan + "<br> No BAP : " + data.nomor_bap + "<br> No BAST : " + data.nomor_bast + "<br> <br>Nilai DPA sesuai dengan nilai kontrak yang terbayar, apabila anda menyetujui DPA ini dengan kriteria rincian diatas dengan menekan tombol <u>Yes</u> dan apabila tidak dengan menekan tombol <u>No</u>",
                            buttons: {
                                ok: {
                                    label: '<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Yes',
                                    className: 'btn-success',
                                    callback: function(){
                                        if(confirm('Yakin akan menyetujui ?')){
                                            $.ajax({
                                                    type: 'post',
                                                    url: '<?php echo site_url('tor/proses_tor_rsa_to_validate');?>' ,
                                                    data: 'id_rsa_detail=' + id_rsa_detail + '&proses=' + proses ,
                                                    success: function(data) {
                                                             if(data == 'sukses'){
                                                                 location.reload();

                                                             }
                                                    }
                                            });

                                        }else{
                                            return false;
                                        }

                                    }
                                },
                                noclose: {
                                    label: '<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> No',
                                    className: 'btn-danger',
                                    callback: function(){
                                        if(confirm('Yakin akan menolak ?')){
                                            $.ajax({
                                                    type: 'post',
                                                    url: '<?php echo site_url('tor/proses_tor_rsa_to_validate');?>' ,
                                                    data: 'id_rsa_detail=' + id_rsa_detail + '&proses=0',
                                                    success: function(data) {
                                                             if(data == 'sukses'){
                                                                 location.reload();

                                                             }
                                                    }
                                            });
                                        }else{
                                            return false;
                                        }
                                    }
                                }
                            }
                        });
            }else{
                bootbox.dialog({
                            title: "PESAN",
                            message: "TIDAK DITEMUKAN DATA RINCIAN KONTRAK.",
                            buttons: {
                                cancel: {
                                    label: '<span class="glyphicon glyphicon-share" aria-hidden="true"></span> Kembali',
                                    className: 'btn-success',
                                },
                                noclose: {
                                    label: '<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Batal',
                                    className: 'btn-danger',
                                    callback: function(){
                                        if(confirm('Yakin akan menolak ?')){
                                            $.ajax({
                                                    type: 'post',
                                                    url: '<?php echo site_url('tor/proses_tor_rsa_to_validate');?>' ,
                                                    data: 'id_rsa_detail=' + id_rsa_detail + '&proses=0',
                                                    success: function(data) {
                                                             if(data == 'sukses'){
                                                                 location.reload();

                                                             }
                                                    }
                                            });
                                        }else{
                                            return false;
                                        }
                                    }
                                }
                            }
                        });
            }

        }
    });

    

}

function do_no(rel,kode,el){
//        clearinput();
//        $('#add-detail').validationEngine('hide');
//        $('#edit-detail').validationEngine('hide');
//        $('#form-add-detail').hide();
        var id_rsa_detail = rel ;

        bootbox.prompt({
            title: "Silahkan masukan alasan penolakan",
            inputType: 'textarea',
            callback: function (res) {
                

                if (res != null){

                    res = res.trim() ;

                    if(res != ''){

                        // console.log(res);

                        $.ajax({
                                type: 'post',
                                url: '<?php echo site_url('tor/proses_tor_rsa_to_validate');?>' ,
                                data: 'id_rsa_detail=' + id_rsa_detail + '&proses=0&ket=' + encodeURIComponent(res),
                                success: function(data) {
                                         if(data == 'sukses'){
                                             location.reload();
                                            
                                         }
                                }
                        });

                    }else{
                        alert('Mohon masukan alasan terlebih dahulu.');
                        return false;
                    }
                }
                

            }
        });

        // if(confirm('Yakin akan menolak ?')){
        //             $.ajax({
        //                     type: 'post',
        //                     url: '<?php echo site_url('tor/proses_tor_rsa_to_validate');?>' ,
        //                     data: 'id_rsa_detail=' + id_rsa_detail + '&proses=0',
        //                     success: function(data) {
        //                              if(data == 'sukses'){
        //                                  location.reload();
                                        
        //                              }
        //                     }
        //             });
            
        // }
        

        
}

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

function calcinput(kode_usulan_belanja){

        if ($('#volume_edit').length) {
                if(isNaN(parseFloat($('#volume_edit').val()))){var vol	= 0;}else{var vol	= parseFloat($('#volume_edit').val());}
                if(isNaN(parseInt($('#tarif_edit').val()))){var tarif	= 0;}else{var tarif	= parseInt($('#tarif_edit').val());}

                if(vol.length==0){ vol = 0;}
                if(tarif.length==0){ tarif = 0;}
                if(isNaN(vol*tarif)){ var hasil	= 0;}else{ var hasil	= vol*tarif; }
                $('#jumlah_edit').val(parseInt(hasil.toFixed(0)));
        }
        else{
                if(isNaN(parseFloat($('#volume_' + kode_usulan_belanja).val()))){var vol = 0;}else{var vol	= parseFloat($('#volume_' + kode_usulan_belanja).val());}
                if(isNaN(parseInt($('#tarif_' + kode_usulan_belanja).val()))){var tarif	= 0;}else{var tarif	= parseInt($('#tarif_' + kode_usulan_belanja).val());}

                if(vol.length==0){ vol = 0;}
                if(tarif.length==0){ tarif = 0;}
                if(isNaN(vol*tarif)){ var hasil	= 0;}else{ var hasil	= vol*tarif; }
                $('#jumlah_' + kode_usulan_belanja).val(parseInt(hasil.toFixed(0)));
        }
}

function canceledit(kode){
    $('#row_space').load('<?php echo site_url('tor/refresh_row_detail_to_validate_ppk').'/'.$kode.'/'.$sumber_dana.'/'.$tahun;?>', function(){
        // $('#form_add_detail_' + kode).show();
        get_kode_akun_tambah();
    });
}

function get_kode_akun_tambah(){
    $('[id^="kode_akun_tambah_"]').each(function(){

            var kode_akun_tambah = $(this).attr('rel') ;
            var sumber_dana = '<?=$sumber_dana?>' ;
            var el = $(this);
            $.ajax({
                    type: 'get',
                    url: '<?php echo site_url('tor/get_next_kode_akun_tambah');?>/' + kode_akun_tambah + '/' + sumber_dana ,
                    data: '' ,
                    success: function(data) {
                                    $(el).val(data);
                    }
            });



        });
}

function submitedit(id_rsa_detail,kode_usulan_belanja){
//    var kode_usulan_belanja = $(this).attr('rel');
    if($('#deskripsi_edit').validationEngine('validate') && $('#volume_edit').validationEngine('validate') && $('#satuan_edit').validationEngine('validate') && $('#tarif_edit').validationEngine('validate')){
            var total_usulan = parseInt(string_to_angka($("#td_usulan_" + kode_usulan_belanja ).html()));
            var total_rsa = parseInt(string_to_angka($("#td_kumulatif_" + kode_usulan_belanja ).html()));
            var total_rsa_sisa = parseInt(string_to_angka($("#td_kumulatif_sisa_" + kode_usulan_belanja ).html()));
            var jumlah = parseInt(string_to_angka($("#jumlah_edit").val()));
            var jumlah_edit_before = parseInt(string_to_angka($("#jumlah_edit_before").val()));

//            console.log(total_usulan + ' - ' + total_rsa + ' - ' + jumlah + ' - ' + jumlah_edit_before );

            if(total_usulan >= ( (total_rsa - jumlah_edit_before) + jumlah )){
                $.ajax({
                        type: 'post',
                        url: '<?php echo site_url('tor/edit_rsa_detail_belanja');?>',
                        data: 'id_rsa_detail=' + id_rsa_detail + '&deskripsi=' +  encodeURIComponent($('#deskripsi_edit').val()) + '&volume=' + $('#volume_edit').val() + '&satuan=' + $('#satuan_edit').val() + '&harga_satuan=' + $('#tarif_edit').val() ,
                        success: function(data) {
                               if(data == 'sukses'){
                                            location.reload();

                                         }
                        }
                });
            }else{
                alert('Tidak bisa karena jumlah melebihi sisa.');
                $("#tarif_edit").focus();
                return false;

            }
    }

}

function checkfloat(field, rules, i, options){

            var v = field.val() ;
            if(v == ''){
                return "* Isian salah, con : 999999,99" ;
            } 
             
        }
function open_tolak(s){
      bootbox.alert({
          title: "PESAN",
          message: s,
          animate:false,
      });
}

</script>
<?php
$tgl=getdate();
$cur_tahun=$tgl['year']+1;
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
	<td class="col-md-2">IKU</td>
	<td><span id="kode_program"><?=$tor_usul->kode_program?></span> - <?=$tor_usul->nama_program?></td>
</tr>
<tr>
	<td class="col-md-2">Kegiatan</td>
	<td><span id="kode_komponen"><?=$tor_usul->kode_komponen?></span> - <?=$tor_usul->nama_komponen?></td>
</tr>
<tr>
	<td class="col-md-2">Sub Kegiatan</td>
	<td><span id="kode_subkomponen"><?=$tor_usul->kode_subkomponen?></span> - <?=$tor_usul->nama_subkomponen?></td>
</tr>
</table>

<table class="table table-striped table-bordered">
<tr class="alert alert-danger" style="font-weight: bold">
	<td class="col-md-2">Sumber Dana</td>
	<td><span id="kode_sumber_dana"><?=$sumber_dana?></span></td>
</tr>
<td class="col-md-2">Ket</td>
	<td>
           <span class="label badge-gup">&nbsp;</span> : GUP &nbsp;&nbsp;<span class="label badge-tup">&nbsp;</span> : TUP &nbsp;&nbsp;<span class="label badge-lp">&nbsp;</span> : LS-PEGAWAI &nbsp;&nbsp;<span class="label badge-l3">&nbsp;</span> : LS-KONTRAK &nbsp;&nbsp;<span class="label badge-ln">&nbsp;</span> : LS-NON-KONTRAK &nbsp;&nbsp;<span class="label badge-ks">&nbsp;</span> : KERJA-SAMA &nbsp;&nbsp;<span class="label badge-em">&nbsp;</span> : EMONEY
        </td>
</table>

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
                                    <th class="col-md-1" style="text-align:center">Aksi</th>
                                    <th class="col-md-1" style="text-align:center">Usulkan</th>
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
                                    <tr >
                                        <td colspan="8">&nbsp;</td>
                                    </tr>
                                    <tr id="" class="alert alert-info" height="25px">
                                        <td colspan="8"><b><?='<span class="text-warning">'.$u->nama_subunit.'</span> : <span class="text-success">'.$u->nama_sub_subunit.'</span>'?></b></td>
                                    </tr>
                                        <?php $temp_text_unit = $u->nama_subunit.$u->nama_sub_subunit; ?>
                                        <?php $temp_text_akun = '' ;?>
                                    <?php endif; ?>
                                    <?php if($temp_text_akun != $u->kode_akun): ?>
                                    <tr id="<?php echo $u->kode_usulan_belanja ;?>" height="25px" class="text-danger">
                                        <td colspan="8"><b><?=$u->kode_akun.' : '.$u->nama_akun?></b></td>
                                    </tr>
                                        <?php $temp_text_akun = $u->kode_akun; ?>
                                        <?php $total_per_akun = 0 ;?>
                                    <?php else: ?>
                                        <!--<td colspan="8">&nbsp;</td>-->
                                    <?php endif; ?>

                                    <?php foreach($detail_rsa_to_validate as $ul){ ?>
                                        <?php $impor = $ul->impor; ?>
                                        <?php if($ul->kode_usulan_belanja == $u->kode_usulan_belanja): ?>
                                            <tr id="<?php echo $ul->id_rsa_detail ;?>" height="25px">
                                                <td style="text-align: right">
                                                
                                                <?php if(substr($ul->proses,1,1)=='1'){echo '<span class="badge badge-gup">GP</span>';}elseif(substr($ul->proses,1,1)=='3'){echo '<span class="badge badge-tup">TP</span>';}elseif(substr($ul->proses,1,1)=='2'){echo '<span class="badge badge-lp">LP</span>';}elseif(substr($ul->proses,1,1)=='4'){echo '<span class="badge badge-l3">LK</span>';}elseif(substr($ul->proses,1,1)=='5'){echo '<span class="badge badge-ks">KS</span>';}elseif(substr($ul->proses,1,1)=='6'){echo '<span class="badge badge-ln">LN</span>';}elseif(substr($ul->proses,1,1)=='7'){echo '<span class="badge badge-em">EM</span>';}else{} ?> <?=$ul->kode_akun_tambah?>
                                                    <input type="hidden" id="proses_<?php echo $ul->id_rsa_detail;?>" value="2<?=substr($ul->proses,1,1)?>" />
                                                </td>
                                                <td ><?=$ul->deskripsi?> <?php if(!empty($ul->ket)){echo "<span class=\"glyphicon glyphicon-question-sign\" style=\"cursor:pointer\" onclick=\"open_tolak('".$ul->ket."')\" aria-hidden=\"true\"></span>";}else{} ?></td>
                                                <td ><?=$ul->volume + 0?></td>
                                                <td ><?=$ul->satuan?></td>
                                                <td style="text-align: right"><?=number_format($ul->harga_satuan, 0, ",", ".")?></td>
                                                <td style="text-align: right">
                                                    <?php $total_ = $total_ + ($ul->volume*$ul->harga_satuan); ?>
                                                    <?php $total_per_akun = $total_per_akun + ($ul->volume*$ul->harga_satuan); ?>
                                                    <?=number_format($ul->volume*$ul->harga_satuan, 0, ",", ".")?>
													<?php
													if(substr($ul->proses,1,1)=='4'){ /*
														foreach($detail_rsa_kontrak as $kt){
															echo "<li>KT:";
															echo number_format($ul->harga_satuan, 0, ",", ".");
															echo number_format($kt->kontrak_terbayar,0, ",", ".");
															echo "&nbsp;(";
															echo $kt->termin;
															echo ")</li>";


															//var_dump($kt);die;

														}*/
														// print_r($detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah]);
														// if(substr($ul->proses,1,1)=='4'){
														// 	if(isset($detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar) && $detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar != 0){
														// 		echo "<br /><a title=\"Kontrak Terbayar untuk Akun ini.\">KT: ".$this->cantik_model->number($detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar)."<br/>termin :".$detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->termin."</a>";
														// 	}
														// }
													}
													?>

                                                </td>
                                                <?php if($ul->proses == 0) : ?>

                                                <td align="center">
                                                        <div class="btn-group">
                                                            <button type="button" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>
                                                        </div>
                                                    </td>
                                                    <td >
                                                        <button type="button" disabled="disabled" class="btn btn-success btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
                                                    </td>

                                                <?php elseif(substr($ul->proses,0,1) == 1): // PPK ?>

                                                <td align="center">
                                                    <div class="btn-group">
                                                        <button type="button" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-default btn-sm" onclick="doedit('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this)" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>
                                                    </div>
                                                </td>
                                                <td >
                                                    
							<?php
								if(substr($ul->proses,1,1)=='4'){

									$nilaikontrak = 0;

                                    $kx = $ul->kode_usulan_belanja.$ul->kode_akun_tambah ;

									// if(isset($detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar) && $detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar != 0){

									// 	$nilaikontrak=$detail_rsa_kontrak[$ul->kode_usulan_belanja.$ul->kode_akun_tambah][0]->kontrak_terbayar;

									// }

                                    if(!empty($detail_rsa_kontrak[$kx])){

                                        $nilaikontrak = $detail_rsa_kontrak[$kx]['kontrak_terbayar'] ;

                                    }

                                    // $nilaikontrak = $nilaikontrak + 1 ;

									$nilai_dpa = $ul->volume*$ul->harga_satuan;

									if($nilaikontrak != $nilai_dpa){ // NILAI DPA TIDAK SAMA DENGAN KONTRAK

                                        // if(strpos(strtolower($ul->deskripsi),'listrik')!==false || strpos(strtolower($ul->deskripsi),'bpjs')!==false){ 

                                        /// KONDISI INI TIDAK TERPAKAI KARENA BELUM MUDENG - IDRIS ///

                                         // } 

                                    ?>
                                        <!--  title="Kontrak Terbayar tidak sama dengan nilai usulan DPA, nilai kontrak : <?=$nilaikontrak?> " -->
                                        <button type="button" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-danger btn-sm" onclick="do_cek_salah('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this,'<?php echo $ul->kode_akun_tambah ;?>')" aria-label="Center Align"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Cek</button>


								<?php }else{ // NILAI DPA SAMA DENGAN NILAI KONTRAK ?>

                                    <!-- title="Kontrak Terbayar tidak sama dengan nilai usulan DPA, nilai kontrak : <?=$nilaikontrak?> " -->

                                    <button type="button" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-danger btn-sm" onclick="do_cek_ok('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this,'<?php echo $ul->kode_akun_tambah ;?>')" aria-label="Center Align"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Cek</button>
									
                                <?php } ?>

							<?php }else{ ?>

                                <div class="btn-group">

                                <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-success btn-sm" onclick="do_yes('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this)" aria-label="Left Align">Yes</button>
                                <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-danger btn-sm" onclick="do_no('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this)" aria-label="Center Align">No</button>

                                </div>
                            
							<?php } ?>
                                                    
                                                </td>
                                                <?php elseif(substr($ul->proses,0,1) == 2): // VERIFIKATOR ?>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Ver </button>
                                                </td>
                                                <?php elseif(substr($ul->proses,0,1) == 3): ?>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-warning btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Siap </button>
                                                </td>
												<?php elseif(substr($ul->proses,0,1) == 4): ?>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> SPP </button>
                                                </td>
                                              <?php elseif(substr($ul->proses,0,1) == 5): ?>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> SPM </button>
                                                </td>
                                              <?php elseif(substr($ul->proses,0,1) == 6): ?>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Cair </button>
                                                </td>
                                                <?php else: ?>
                                                    <td align="center">
                                                        <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                        <div class="btn-group">
                                                            <button type="button" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>
    <!--                                                        <button type="button" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>-->
                                                        </div>
                                                    </td>
                                                    <td >
                                                        <button type="button" disabled="disabled" class="btn btn-warning btn-sm" rel="" id="proses_<?php echo $ul->id_rsa_detail ;?>" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
                                                    </td>

                                                <?php endif; ?>
                                            </tr>

                                        <?php endif; ?>
                                    <?php } ?>
                                            
                                    <tr class="alert alert-danger">
                                        <td colspan="4" style="text-align: right;">Anggaran</td>
                                        <td style="text-align: right;">:</td>
                                        <td style="text-align: right;" rel="<?=$u->kode_usulan_belanja?>" id="td_usulan_<?=$u->kode_usulan_belanja?>"><?=number_format($u->total_harga, 0, ",", ".")?></td>
                                        <td >&nbsp;</td>
                                        <td >&nbsp;</td>
                                    </tr>
                                    <tr class="alert alert-info">
                                            <td colspan="4" style="text-align: right;">Usulan</td>
                                            <td style="text-align: right;">:</td>
                                            <td style="text-align: right;" id="td_kumulatif_<?=$u->kode_usulan_belanja?>"><?=number_format($total_per_akun, 0, ",", ".")?></td>
                                            <td >&nbsp;</td>
                                            <td >&nbsp;</td>
                                    </tr>
                                    <tr  class="alert alert-warning">
                                            <td colspan="4" style="text-align: right;">Sisa</td>
                                            <td style="text-align: right;">:</td>
                                            <td style="text-align: right;" id="td_kumulatif_sisa_<?=$u->kode_usulan_belanja?>"><?=number_format(($u->total_harga - $total_per_akun), 0, ",", ".")?></td>
                                            <td >&nbsp;</td>
                                            <td >&nbsp;</td>
                                    </tr>

                                    <?php $i_row++; ?>



                                <?php } ?>
                                    <tr id="tr_kosong" height="25px" style="display: none" class="alert alert-warning" >
                                        <td colspan="8">- kosong / belum disetujui -</td>
                                    </tr>

                                    <!--
                                    <tr id="" height="25px" class="alert alert-info" style="font-weight: bold">
                                        <td colspan="4" style="text-align: center">Total </td>
                                        <td style="text-align: right">:</td>
                                        <td style="text-align: right"><?=number_format($total_, 0, ",", ".")?></td>
                                        <td >&nbsp;</td>
                                        <td >&nbsp;</td>
                                    </tr>
                                    -->
                            </tbody>
                            <tfoot>
                                <tr id="" height="25px">
                                        <td colspan="8">&nbsp;</td>
                                    </tr>
                            </tfoot>
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
