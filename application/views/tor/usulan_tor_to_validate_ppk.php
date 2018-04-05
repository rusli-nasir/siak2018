<script type="text/javascript">
$(document).ready(function(){

    need_to_expand_the_collapse();
    autosize($('textarea'));

    $('#backi').click(function(){
        window.location = "<?=site_url("dpa/daftar_dpa/").$sumber_dana?>";
    });

    $('body').tooltip({
        selector: '.xfloat'
    });

    $(document).on("click",'[id^="proses_"]',function(){
        var id_rsa_detail = $(this).attr('rel');
        var kode_usulan_belanja = $(this).attr('rel');

        if(confirm('Yakin akan memproses ?')){
            var data = "id_rsa_detail=" + id_rsa_detail;
            $.ajax({
                type:"POST",
                url :"<?=site_url("tor/proses_tor_rsa_detail")?>",
                data:data,
                success:function(data){
                    if(data == 'sukses'){
                        localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                        localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                        localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                        localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                        localStorage.setItem("row_focus", "#"+id_rsa_detail);
                        location.reload();
                   }
                }
            });
        }
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

            calcinput(kode_usulan_belanja);
        }
    });

    $(document).on("keyup","input.xnumber",function(event){

        if(event.which >= 37 && event.which <= 40) return;

        $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            ;
        });
    });

    $(document).on("focusout","input.xfloat",function(){

        var kode_usulan_belanja = $(this).attr('rel');

            if($(this).val()==''){
                $(this).val('0');

            }
            else{
                calcinput(kode_usulan_belanja);
            }

    });

    $(document).on("keyup","input.xfloat",function(event){

        var val = $(this).val();
        if(isNaN(val)){
             val = val.replace(/[^0-9\.]/g,'');
             if(val.split('.').length>2) 
                 val =val.replace(/\.+$/,"");
        }
        $(this).val(val); 

    });

    $(document).on("click",'[id^="tambah_"]',function(){
        var kode_usulan_belanja = $(this).attr('rel');

        if($('#deskripsi_' + kode_usulan_belanja).validationEngine('validate') && $('#volume_' + kode_usulan_belanja).validationEngine('validate') && $('#satuan_' + kode_usulan_belanja).validationEngine('validate') && $('#tarif_' + kode_usulan_belanja).validationEngine('validate')){

            var total_usulan = parseInt(string_to_angka($("#td_usulan_" + kode_usulan_belanja ).html()));
            var total_rsa = parseInt(string_to_angka($("#td_kumulatif_" + kode_usulan_belanja ).html()));
            var total_rsa_sisa = parseInt(string_to_angka($("#td_kumulatif_sisa_" + kode_usulan_belanja ).html()));
            var jumlah = parseInt(string_to_angka($("#jumlah_" + kode_usulan_belanja ).val()));

            if(total_usulan >= ( total_rsa + jumlah)){

                $.ajax({
                        type: 'post',
                        url: '<?php echo site_url('tor/add_rsa_detail_belanja');?>' ,
                        data: 'kode_usulan_belanja=' + kode_usulan_belanja + '&deskripsi=' + encodeURIComponent($('#deskripsi_' + kode_usulan_belanja).val()) + '&sumber_dana=<?=$sumber_dana?>&volume=' + $('#volume_' + kode_usulan_belanja).val() + '&satuan=' + $('#satuan_' + kode_usulan_belanja).val() + '&harga_satuan=' + $('#tarif_' + kode_usulan_belanja).val() + '&kode_akun_tambah=' + $('#kode_akun_tambah_' + kode_usulan_belanja).val() + '&revisi=' + $('#revisi_' + kode_usulan_belanja).val() + '&impor=' + $('#impor_' + kode_usulan_belanja).val() ,
                        success: function(data) {
                                 if(data == 'sukses'){
                                    localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                                    localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                                    localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                                    localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                                    localStorage.setItem("row_focus", "#deskripsi_"+kode_usulan_belanja);
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

        $('#deskripsi_' + kode_usulan_belanja).val('') ;
        $('#volume_' + kode_usulan_belanja).val('') ;
        $('#satuan_' + kode_usulan_belanja).val('') ;
        $('#tarif_' + kode_usulan_belanja).val('') ;
        $('#jumlah_' + kode_usulan_belanja).val('') ;

        $('.deskripsi_' + kode_usulan_belanja + 'formError').remove();
        $('.volume_' + kode_usulan_belanja + 'formError').remove();
        $('.satuan_' + kode_usulan_belanja + 'formError').remove();
        $('.tarif_' + kode_usulan_belanja + 'formError').remove();
    });

    get_kode_akun_tambah();

    $(document).on("click",'[id^="delete_"]',function(){

        var id_rsa_detail = $(this).attr('rel');
        var kode_usulan_belanja = $(this).attr('rel');

        if(confirm('Yakin akan menghapus ?')){
            $.ajax({
                    type: 'post',
                    url: '<?php echo site_url('tor/delete_rsa_detail_belanja');?>' ,
                    data: 'id_rsa_detail=' + id_rsa_detail ,
                    success: function(data) {
                        if(data == 'sukses'){
                            localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                            localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                            localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                            localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                            localStorage.setItem("row_focus", "#"+id_rsa_detail);
                            location.reload();

                        }
                    }
            });
        }
    });

});

function need_to_expand_the_collapse(){
    var row_sub_subunit = localStorage.getItem("row_expand_sub_subunit");
    var row_akun4d = localStorage.getItem("row_expand_akun4d");
    var row_akun5d = localStorage.getItem("row_expand_akun5d");
    var row_akun6d = localStorage.getItem("row_expand_akun6d");
    var row_focus = localStorage.getItem("row_focus");

    $(row_sub_subunit).addClass("in");
    $(row_akun4d).addClass("in");
    $(row_akun5d).addClass("in");
    $(row_akun6d).addClass("in");
    $(row_focus).focus();

}

function usulan_tor_ajax_reload(kode,sumber_dana){
    $.ajax({
        type: 'get',
        url: '<?php echo site_url('tor/usulan_tor_ajax_reload');?>/'+kode+'/'+sumber_dana ,
        data: '' ,
        success: function(data) {
            $('#o-table').html(data);
        },
        complete: function (data) {
            get_kode_akun_tambah();
            need_to_expand_the_collapse();
        }
    });
}

function doedit(rel,kode,el){


    $('#' + rel).load('<?php echo site_url('tor/form_edit_detail_to_validate_ppk');?>/' + rel,function(){autosize($('textarea'));});
    $('#' + rel).addClass('alert-success') ;
    $('#form_add_detail_' + kode).hide();

}

function do_yes(rel,kode,el){

    var id_rsa_detail = rel ;
    var kode_usulan_belanja = kode ;
    var proses = $('#proses_' + rel).val();

    if(confirm('Yakin akan menyetujui ?')){
        $.ajax({
                type: 'post',
                url: '<?php echo site_url('tor/proses_tor_rsa_to_validate');?>' ,
                data: 'id_rsa_detail=' + id_rsa_detail + '&proses=' + proses ,
                success: function(data) {
                         if(data == 'sukses'){
                            localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                            localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                            localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                            localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                            localStorage.setItem("row_focus", "#"+id_rsa_detail);
                             location.reload();

                         }
                }
        });
    }
}

function do_cek_nilai_kontrak(rel,kode,el,akun_tambah,nilai_dpa){

    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('tor/check_nilai_kontrak/')?>' + kode + '/' + akun_tambah,
        success: function(r) {

            var nilai_kontrak = 0 ;

            var data = JSON.parse(r);

            if(!jQuery.isEmptyObject(data)){
                nilai_kontrak = data.kontrak_terbayar ;

                // console.log(nilai_kontrak + ' ' + nilai_dpa);
                if(nilai_kontrak == nilai_dpa){
                    do_cek_ok(rel,kode,el,akun_tambah);
                    // alert('1 : ' + nilai_kontrak + ' | ' + nilai_dpa );
                }else{
                    do_cek_salah(rel,kode,el,akun_tambah);
                    // alert('2 : ' + nilai_kontrak + ' | ' + nilai_dpa );
                }
            }else{
                do_cek_salah(rel,kode,el,akun_tambah);
                // alert('3 : ' + nilai_kontrak );
            }

        }
    });

}


function do_cek_salah(rel,kode,el,akun_tambah){

    var id_rsa_detail = rel ;
    var kode_usulan_belanja = kode ;

    var proses = $('#proses_' + rel).val();

    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('rsa_lsk/get_data_kontrak_by_id_rsa_detail/')?>' + id_rsa_detail ,
        success: function(r) {

            var data = JSON.parse(r);

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
                                            data: 'id_rsa_detail=' + id_rsa_detail + '&proses=0&ket=Nilai kontrak yang terbayar tidak sama dengan nilai DPA',
                                            success: function(data) {
                                                     if(data == 'sukses'){
                                                        localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                                                        localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                                                        localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                                                        localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                                                        localStorage.setItem("row_focus", "#"+id_rsa_detail);
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
                                            data: 'id_rsa_detail=' + id_rsa_detail + '&proses=0&ket=TIDAK DITEMUKAN DATA RINCIAN KONTRAK',
                                            success: function(data) {
                                                     if(data == 'sukses'){
                                                        localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                                                        localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                                                        localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                                                        localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                                                        localStorage.setItem("row_focus", "#"+id_rsa_detail);
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
    var kode_usulan_belanja = kode ;
    var proses = $('#proses_' + rel).val();

    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('rsa_lsk/get_data_kontrak_by_id_rsa_detail/')?>' + id_rsa_detail ,
        success: function(r) {

            var data = JSON.parse(r);

            if(!jQuery.isEmptyObject(data)){
                if (data.rekanan == null){
                    bootbox.dialog({
                        title: "PESAN",
                        message: "DATA KONTRAK ADA TAPI <span style='color:red;''>ADA DATA REKANAN KONTRAK YANG KURANG</span>",
                        buttons: {
                            cancel: {
                                label: '<span class="glyphicon glyphicon-share" aria-hidden="true"></span> Kembali',
                                className: 'btn-success',
                            },
                        }
                    });
                }else{
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
                                                            localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                                                            localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                                                            localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                                                            localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                                                            localStorage.setItem("row_focus", "#"+id_rsa_detail);
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
                                                            localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                                                            localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                                                            localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                                                            localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                                                            localStorage.setItem("row_focus", "#"+id_rsa_detail);
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
                                                        localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                                                        localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                                                        localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                                                        localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                                                        localStorage.setItem("row_focus", "#"+id_rsa_detail);
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
    var id_rsa_detail = rel ;
    var kode_usulan_belanja = kode ;

    bootbox.prompt({
        title: "Silahkan masukan alasan penolakan",
        inputType: 'textarea',
        callback: function (res) {
            

            if (res != null){

                res = res.trim() ;

                if(res != ''){

                    $.ajax({
                            type: 'post',
                            url: '<?php echo site_url('tor/proses_tor_rsa_to_validate');?>' ,
                            data: 'id_rsa_detail=' + id_rsa_detail + '&proses=0&ket=' + encodeURIComponent(res),
                            success: function(data) {
                                     if(data == 'sukses'){
                                        localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                                        localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                                        localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                                        localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                                        localStorage.setItem("row_focus", "#"+id_rsa_detail);
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
    $('#usulan_tor_row_detail_'+kode).load('<?php echo site_url('tor/refresh_row_detail_to_validate_ppk')?>/'+ kode +'/<?php echo $sumber_dana ?>', function(){
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
    
    if($('#deskripsi_edit').validationEngine('validate') && $('#volume_edit').validationEngine('validate') && $('#satuan_edit').validationEngine('validate') && $('#tarif_edit').validationEngine('validate')){
            var total_usulan = parseInt(string_to_angka($("#td_usulan_" + kode_usulan_belanja ).html()));
            var total_rsa = parseInt(string_to_angka($("#td_kumulatif_" + kode_usulan_belanja ).html()));
            var total_rsa_sisa = parseInt(string_to_angka($("#td_kumulatif_sisa_" + kode_usulan_belanja ).html()));
            var jumlah = parseInt(string_to_angka($("#jumlah_edit").val()));
            var jumlah_edit_before = parseInt(string_to_angka($("#jumlah_edit_before").val()));

            if(total_usulan >= ( (total_rsa - jumlah_edit_before) + jumlah )){
                $.ajax({
                        type: 'post',
                        url: '<?php echo site_url('tor/edit_rsa_detail_belanja');?>',
                        data: 'id_rsa_detail=' + id_rsa_detail + '&deskripsi=' +  encodeURIComponent($('#deskripsi_edit').val()) + '&volume=' + $('#volume_edit').val() + '&satuan=' + $('#satuan_edit').val() + '&harga_satuan=' + $('#tarif_edit').val() ,
                        success: function(data) {
                               if(data == 'sukses'){
                                            localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
                                            localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
                                            localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
                                            localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
                                            localStorage.setItem("row_focus", "#"+id_rsa_detail);
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
        <hr/>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td class="col-md-2">
                            IKU
                        </td>
                        <td>
                            <span id="kode_program"><?=$tor_usul->kode_program?></span> - <?=$tor_usul->nama_program?>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-2">
                            Kegiatan
                        </td>
                        <td>
                            <span id="kode_komponen"><?=$tor_usul->kode_komponen?></span> - <?=$tor_usul->nama_komponen?>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-2">
                            Sub Kegiatan
                        </td>
                        <td><span id="kode_subkomponen"><?=$tor_usul->kode_subkomponen?></span> - <?=$tor_usul->nama_subkomponen?></td>
                    </tr>
                </table>

                <table class="table table-striped table-bordered" >
                    <tr class="alert alert-danger"style="font-weight: bold">
                        <td class="col-md-2">Sumber Dana</td>
                        <td>
                            <span id="kode_sumber_dana"><?=$sumber_dana?></span>
                        </td>
                    </tr>
                    <tr class="">
                        <td class="col-md-2">
                            Ket
                        </td>
                        <td>
                            <span class="label badge-gup">&nbsp;</span> : GUP &nbsp;&nbsp;<span class="label badge-tup">&nbsp;</span> : TUP &nbsp;&nbsp;<span class="label badge-lp">&nbsp;</span> : LS-PEGAWAI &nbsp;&nbsp;<span class="label badge-l3">&nbsp;</span> : LS-KONTRAK &nbsp;&nbsp;<span class="label badge-ln">&nbsp;</span> : LS-NON-KONTRAK &nbsp;&nbsp;<span class="label badge-ks">&nbsp;</span> : KERJA-SAMA &nbsp;&nbsp;<span class="label badge-em">&nbsp;</span> : EMONEY
                        </td>
                    </tr>
                </table>

                <div id="temp" style="display:none"></div>
                <div id="o-table">
                    <?php foreach ($akun_subakun as $key_subunit => $value_subunit): ?>
                    <div class="alert" data-toggle="collapse" data-target=".data_sub_subunit_<?php echo $key_subunit ?>" style="border-radius:0px;border:1px solid #fff;background-color: #006064;color: #fff;margin: 10px 0px 0px 0px;padding: 5px;cursor: pointer;">
                        <b><?=$value_subunit['nama_subunit']?></b>
                        <?php if ($value_subunit['notif_subunit'] > 0): ?>
                            <span class="badge badge-danger" style="margin-top: 3px;margin-right: 10px;font-size: 18px;float: right;"><?=$value_subunit['notif_subunit']?></span>
                        <?php endif ?>
                    </div>
                        <?php foreach ($value_subunit['data'] as $key_sub_subunit => $value_sub_subunit): ?>
                        <div class="data_sub_subunit_<?php echo $key_subunit ?> collapse in">
                            <div class="alert" data-toggle="collapse" data-target=".data_akun4d_<?php echo $key_sub_subunit ?>" style="border-radius:0px;border:1px solid #ddd;background-color: #ef5350b8;color: #fff;margin: 0px;padding: 5px;cursor: pointer;">
                                <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$value_sub_subunit['nama_sub_subunit']?></b>
                                <?php if ($value_sub_subunit['notif_sub_subunit'] > 0): ?>
                                    <span class="badge badge-danger" style="margin-top: 3px;margin-right: 10px;font-size: 16px;float: right;"><?=$value_sub_subunit['notif_sub_subunit']?></span>
                                <?php endif ?>
                            </div>

                            <?php foreach ($value_sub_subunit['data'] as $key4digit => $value4digit): ?>
                                <div class="data_akun4d_<?php echo $key_sub_subunit ?> collapse">
                                    <div class="alert " data-toggle="collapse" data-target=".data_akun5d_<?php echo $value4digit['kode_usulan_belanja_22'] ?>" style="border-radius:0px;border:1px solid #ddd;border-bottom:0px;background-color: #00695c61;color: #04483f;margin: 0px;padding: 5px;cursor: pointer;">
                                        <span> 
                                            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $key4digit ?> : <?php echo $value4digit['nama_akun4digit'] ?></b>
                                        </span>
                                        <?php if ($value4digit['notif_4d'] > 0): ?>
                                            <span class="badge badge-danger" style="margin-top: 3px;margin-right: 10px;font-size: 14px;float: right;"><?=$value4digit['notif_4d']?></span>
                                        <?php endif ?>

                                        <div class="row">
                                            <div class="col-md-4" style="padding-left: 50px;">
                                                
                                                <span class="label label-success" style="font-size: 13px;border-radius: 15px;">&nbsp;&nbsp;</span>
                                                &nbsp;&nbsp;
                                                <b class="text-success">Anggaran : Rp. <?php echo number_format($value4digit['anggaran'],2,',','.') ?></b>
                                            </div>
                                            <div class="col-md-4" style="padding-left: 50px;">
                                                <span class="label label-warning" style="font-size: 13px;border-radius: 15px;">&nbsp;&nbsp;</span>
                                                &nbsp;&nbsp;
                                                <b class="text-warning">Usulan : Rp. <?php echo number_format($value4digit['usulan_anggaran'],2,',','.') ?></b>
                                            </div>
                                            <div class="col-md-4" style="padding-left: 50px;">
                                                <span class="label label-danger" style="font-size: 13px;border-radius: 15px;">&nbsp;&nbsp;</span>
                                                &nbsp;&nbsp;
                                                <b class="text-danger">Sisa : Rp. <?php echo number_format($value4digit['sisa_anggaran'],2,',','.') ?></b>
                                            </div>
                                        </div>
                                            
                                    </div>
                                    
                                    <?php foreach ($value4digit['data'] as $key5digit => $value5digit): ?>
                                        <div class="data_akun5d_<?php echo $value4digit['kode_usulan_belanja_22'] ?> collapse">
                                            <div class="alert " data-toggle="collapse" data-target=".data_akun6d_<?php echo $value5digit['kode_usulan_belanja_23'] ?>" style="border-radius:0px;border:1px solid #ddd;color: #0d6d64;background-color: #0096884a;margin: 0px;padding: 5px;cursor: pointer;">
                                                <span>
                                                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $key5digit ?> : <?php echo $value5digit['nama_akun5digit'] ?></b>
                                                </span>
                                                <?php if ($value5digit['notif_5d'] > 0): ?>
                                                    <span class="badge badge-danger" style="margin-top: 3px;margin-right: 10px;font-size: 12px;float: right;"><?=$value5digit['notif_5d']?></span>
                                                <?php endif ?>
                                            </div> 
                                            <?php foreach ($value5digit['data'] as $key6digit => $value6digit): ?>
                                                <div id="<?php echo $value6digit['kode_usulan_belanja'] ;?>" class="data_akun6d_<?php echo $value5digit['kode_usulan_belanja_23'] ?> collapse">
                                                    <div class="alert" data-toggle="collapse" data-target=".data_rsa_detail_<?php echo $value6digit['kode_usulan_belanja'] ?>" style="border-radius:0px;border:1px solid #ddd;color: #495d5b;background-color: #b2dfdb80;margin: 0px;padding: 5px;cursor: pointer;">
                                                        <span>
                                                            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $key6digit ?> : <?php echo $value6digit['nama_akun'] ?></b>
                                                        </span>
                                                        <?php if ($value6digit['notif_6d'] > 0): ?>
                                                            <span class="badge badge-danger" style="margin-top: 3px;margin-right: 10px;font-size: 10px;float: right;"><?=$value6digit['notif_6d']?></span>
                                                        <?php endif ?>
                                                    </div>
                                                    <div id="data_detail_<?php echo $key6digit ?>" class="data_rsa_detail_<?php echo $value6digit['kode_usulan_belanja'] ?> collapse">
                                                        <!-- <hr> -->
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th class="col-md-1 text-center" >Akun</th>
                                                                    <th class="col-md-3 text-center" >Rincian</th>
                                                                    <th class="col-md-1 text-center" >Volume</th>
                                                                    <th class="col-md-1 text-center" >Satuan</th>
                                                                    <th class="col-md-2 text-center" >Harga</th>
                                                                    <th class="col-md-2 text-center" >Jumlah</th>
                                                                    <th class="col-md-1 text-center" style="text-align:center">Aksi</th>
                                                                    <th class="col-md-1 text-center" style="text-align:center">Usulkan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="usulan_tor_row_detail_<?php echo $value6digit['kode_usulan_belanja'] ?>">
                                                                <?php if (!empty($value6digit['data'])): ?>
                                                                <?php foreach ($value6digit['data'] as $keydetail => $valdetail): ?>
                                                                    <tr  id="<?php echo $valdetail['id_rsa_detail'] ;?>">
                                                                        <td class="text-center">
                                                                            <?php
                                                                            if(substr($valdetail['proses'],1,1)=='1'){echo '<span class="badge badge-gup">GP</span>';}
                                                                            elseif(substr($valdetail['proses'],1,1)=='3'){echo '<span class="badge badge-tup">TP</span>';}
                                                                            elseif(substr($valdetail['proses'],1,1)=='2'){echo '<span class="badge badge-lp">LP</span>';}
                                                                            elseif(substr($valdetail['proses'],1,1)=='4'){echo '<span class="badge badge-l3">LK</span>';}
                                                                            elseif(substr($valdetail['proses'],1,1)=='5'){echo '<span class="badge badge-ks">KS</span>';}
                                                                            elseif(substr($valdetail['proses'],1,1)=='6'){echo '<span class="badge badge-ln">LN</span>';}
                                                                            elseif(substr($valdetail['proses'],1,1)=='7'){echo '<span class="badge badge-em">EM</span>';}
                                                                            else{}
                                                                            ?>
                                                                            <?php echo $keydetail ?>
                                                                            <input type="hidden" id="proses_<?php echo $valdetail['id_rsa_detail'];?>" value="2<?=substr($valdetail['proses'],1,1)?>" />
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
                                                                        <td class="text-right"><?php echo number_format($valdetail['jumlah_harga'],0,',','.') ?></td>
                                                                        <?php if($valdetail['proses'] == 0) : ?>
                                                                            <td align="center">
                                                                                <div class="btn-group">
                                                                                    <button type="button" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="text-edit glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" disabled="disabled" class="btn btn-success btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
                                                                            </td>
                                                                        <?php elseif(substr($valdetail['proses'],0,1) == 1): ?>
                                                                            <td align="center">
                                                                                <div class="btn-group">
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $valdetail['id_rsa_detail'];?>" data-kode-usulan="<?php echo $value6digit['kode_usulan_belanja'] ?>" class="btn btn-default btn-sm" onclick="doedit('<?php echo $valdetail['id_rsa_detail'] ;?>','<?php echo $value6digit['kode_usulan_belanja'] ;?>',this)" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit">
                                                                                        Edit
                                                                                        <span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                                                    </button>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                    if(substr($valdetail['proses'],1,1)=='4'){
                                                                                        $nilaikontrak = 0;
                                                                                        $kx = $value6digit['kode_usulan_belanja'].$keydetail ;
                                                                                        if(isset($detail_rsa_kontrak[$kx])){
                                                                                            if(!empty($detail_rsa_kontrak[$kx])){
                                                                                                $nilaikontrak = $detail_rsa_kontrak[$kx]['kontrak_terbayar'] ;
                                                                                            }
                                                                                        }

                                                                                        $nilai_dpa = $valdetail['volume']*$valdetail['satuan'];
                                                                                        if($nilaikontrak != $nilai_dpa){ 

                                                                                        }else{ // NILAI DPA SAMA DENGAN NILAI KONTRAK

                                                                                        }
                                                                                ?>

                                                                                        <button type="button" rel="<?php echo$valdetail['id_rsa_detail'];?>" class="btn btn-danger btn-sm" onclick="do_cek_nilai_kontrak('<?php echo $valdetail['id_rsa_detail'] ;?>','<?php echo $value6digit['kode_usulan_belanja'] ;?>',this,'<?php echo $keydetail ;?>','<?php echo $valdetail['jumlah_harga'];?>')" aria-label="Center Align">
                                                                                            <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                                                                                            Cek
                                                                                        </button>

                                                                                <?php
                                                                                    }else{
                                                                                ?>

                                                                                        <div class="btn-group">

                                                                                            <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $valdetail['id_rsa_detail'];?>" class="btn btn-success btn-sm" onclick="do_yes('<?php echo $valdetail['id_rsa_detail'] ;?>','<?php echo $value6digit['kode_usulan_belanja'] ;?>',this)" aria-label="Left Align">Yes</button>
                                                                                            <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $valdetail['id_rsa_detail'];?>" class="btn btn-danger btn-sm" onclick="do_no('<?php echo $valdetail['id_rsa_detail'] ;?>','<?php echo $value6digit['kode_usulan_belanja'] ;?>',this)" aria-label="Center Align">No</button>
                                                                                        </div>

                                                                                <?php
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                        <?php elseif(substr($valdetail['proses'],0,1) == 2): ?>
                                                                            <td align="center">
                                                                                <div class="btn-group">
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Ver </button>
                                                                            </td>
                                                                        <?php elseif(substr($valdetail['proses'],0,1) == 3): ?>
                                                                            <td align="center">
                                                                                <div class="btn-group">
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" disabled="disabled" class="btn btn-warning btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="text-success glyphicon glyphicon-ok" aria-hidden="true"></span> Siap </button>
                                                                            </td>
                                                                        <?php elseif(substr($valdetail['proses'],0,1) == 4): ?>
                                                                            <td align="center">
                                                                                <div class="btn-group">
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> SPP </button>
                                                                            </td>
                                                                        <?php elseif(substr($valdetail['proses'],0,1) == 5): ?>
                                                                            <td align="center">
                                                                                <div class="btn-group">
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> SPM </button>
                                                                            </td>
                                                                        <?php elseif(substr($valdetail['proses'],0,1) == 6): ?>
                                                                            <td align="center">
                                                                                <div class="btn-group">
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Cair </button>
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <td align="center">
                                                                                <div class="btn-group">
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit">
                                                                                        <span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                                                    </button>
                                                                                    <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus">
                                                                                        <span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                                                    </button>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                 <button type="button" disabled="disabled" class="btn btn-warning btn-sm" rel="" id="proses_<?php echo $valdetail['id_rsa_detail'];?>" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
                                                                            </td>
                                                                        <?php endif; ?>
                                                                    </tr>
                                                        
                                                                <?php endforeach ?>
                                                                <?php else: ?>
                                                                <tr id="tr_kosong" height="25px" class="alert text-center" >
                                                                    <td colspan="8">- kosong -</td>
                                                                </tr>                                 
                                                                <?php endif ?>
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
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <?php endforeach ?>
                    <?php endforeach ?>
	            </div>
	        </div>
        </div>
    </div>
</div>
