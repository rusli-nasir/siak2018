<style type="text/css">



</style>
<script type="text/javascript">


     
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


var keluaran = [];

	$(document).ready(function(){

        
        keluaran = [];
            
            if($('#tb-data').visible()){
                $('#panel-jml').show();
                // on = '1' ;
                // console.log('0') ;

            }else{
                $('#panel-jml').hide();
            }
            
            $('#<?=$k_tab?>').addClass('active');
            
            
            var aktv = '0';    

            $("#cetak").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("#div-cetak").printArea( options );
                });


            $(document).on('keyup', '#cr_nomor', function(event){
                if (event.keyCode == 13) {
                    window.location = "<?=current_url()?>?n=" + $(this).val();
                }
            });


            $(document).on('click', '#cr_tgl', function(event){
                // if (event.keyCode == 13) {
                    window.location = "<?=current_url()?>?t=" + $('#dp1').val();
                // }
            });


            $(document).on('keyup', '#cr_uraian', function(event){
                if (event.keyCode == 13) {
                    window.location = "<?=current_url()?>?r=" + $(this).val();
                }
            });

            // $("input:checkbox:disabled").each(function(){

            //     console.log($(this).attr('rel'));

            // });


            // $('#datetimepicker1').datetimepicker({
            //                                                             //viewMode: 'months',
            //                                                             format: 'DD MMMM YYYY',
            //                                                              widgetPositioning: 
            //                                                              {
            //                                                                 horizontal: 'left', 
            //                                                                 vertical: 'bottom'
            //                                                              } 

            //                                                         });


            $('#dp1').datepicker({
                format: 'yyyy-mm-dd'
            });

                
                $(document).on('change', '[class^="all_ck"]', function(){
                    
                    if($(this).is(':checked')){
                        $('[class^="ck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                    //                        aktv = '0';
    //                        if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                            if($(this).is(':enabled')){
                                // $('#btn-kuitansi').removeAttr('disabled');
                    //                            aktv = '1';
                    //                            return false;
                                $(this).prop('checked',true);
                                aktv = '1' ;
                                $('.btn_proses').each(function(){
                                    aktv = '0';
                                    return false;
                                });
                                if(aktv == '1'){
                                    $('#btn-spp').removeAttr('disabled');
                                    // $('#btn-pindah').removeAttr('disabled');
                                }else{
                                    $('#btn-spp').attr('disabled','disabled');
                                    // $('#btn-pindah').attr('disabled','disabled');
                                }

                                 $('#btn-pindah').removeAttr('disabled');

                            }
                        });

                        
                    }else{
                        $('[class^="ck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                    //                        aktv = '0';
    //                        if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                            if($(this).is(':enabled')){
                                // $('#btn-kuitansi').removeAttr('disabled');
                    //                            aktv = '1';
                    //                            return false;
                                $(this).prop('checked',false);
                                
                                $('#btn-spp').attr('disabled','disabled');
                                $('#btn-pindah').attr('disabled','disabled');

                            }
                        });
                    }


                        // UNTUK MENGHITUNG JUMLAH KUITANSI //

                        var jml_kuitansi = 0 ;

                        $('[class^="ck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                var arel = $(this).attr('rel');

                                var jml_k = parseInt(string_to_angka($("#td_sub_tot_" + arel).text()));
                                jml_kuitansi = jml_kuitansi + jml_k ; 

                                
                            }
                            
                        });

                        $('[class^="pck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                var arel = $(this).attr('rel');

                                var jml_k = parseInt(string_to_angka($("#td_sub_tot_pengembalian_" + arel).text()));
                                jml_kuitansi = jml_kuitansi + jml_k ; 

                                
                            }
                            
                        });

                        $('.jml_kuitansi').text(angka_to_string(jml_kuitansi));

                        // END //



                    

                    
                });

                $(document).on('change', '[class^="all_pck"]', function(){
                    
                    if($(this).is(':checked')){
                        $('[class^="pck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                    //                        aktv = '0';
    //                        if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                            if($(this).is(':enabled')){
                                // $('#btn-kuitansi').removeAttr('disabled');
                    //                            aktv = '1';
                    //                            return false;
                                $(this).prop('checked',true);
                                aktv = '1' ;
                                $('.btn_proses').each(function(){
                                    aktv = '0';
                                    return false;
                                });
                                if(aktv == '1'){
                                    $('#btn-spp').removeAttr('disabled');
                                    // $('#btn-pindah').removeAttr('disabled');
                                }else{
                                    $('#btn-spp').attr('disabled','disabled');
                                    // $('#btn-pindah').attr('disabled','disabled');
                                }

                                 $('#btn-pindah').removeAttr('disabled');

                            }
                        });

                        
                    }else{
                        $('[class^="pck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                    //                        aktv = '0';
    //                        if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                            if($(this).is(':enabled')){
                                // $('#btn-kuitansi').removeAttr('disabled');
                    //                            aktv = '1';
                    //                            return false;
                                $(this).prop('checked',false);
                                
                                $('#btn-spp').attr('disabled','disabled');
                                $('#btn-pindah').attr('disabled','disabled');

                            }
                        });
                    }


                        // UNTUK MENGHITUNG JUMLAH KUITANSI //

                        var jml_kuitansi = 0 ;

                        $('[class^="pck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                var arel = $(this).attr('rel');

                                var jml_k = parseInt(string_to_angka($("#td_sub_tot_pengembalian_" + arel).text()));
                                jml_kuitansi = jml_kuitansi + jml_k ; 

                                
                            }
                            
                        });

                        $('[class^="ck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                var arel = $(this).attr('rel');

                                var jml_k = parseInt(string_to_angka($("#td_sub_tot_" + arel).text()));
                                jml_kuitansi = jml_kuitansi + jml_k ; 

                                
                            }
                            
                        });

                        $('.jml_kuitansi').text(angka_to_string(jml_kuitansi));

                        // END //



                    

                    
                });
                
            $('[class^="all_ck"]').each(function(){
                //$('#btn-kuitansi').attr('disabled','disabled');
        //                        aktv = '0';
                if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                    // $('#btn-kuitansi').removeAttr('disabled');
        //                            aktv = '1';
        //                            return false;
                    $(this).prop('checked',false);

                }
            });

            $('[class^="all_pck"]').each(function(){
                //$('#btn-kuitansi').attr('disabled','disabled');
        //                        aktv = '0';
                if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                    // $('#btn-kuitansi').removeAttr('disabled');
        //                            aktv = '1';
        //                            return false;
                    $(this).prop('checked',false);

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

                $('[class^="pck_"]').each(function(){
                        //$('#btn-kuitansi').attr('disabled','disabled');
//                        aktv = '0';
                        if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                            // $('#btn-kuitansi').removeAttr('disabled');
//                            aktv = '1';
//                            return false;
                            $(this).prop('checked',false);

                        }
                    });

                $('[class^="pck_"]').each(function(){
                        //$('#btn-kuitansi').attr('disabled','disabled');
//                        aktv = '0';
                        if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                            // $('#btn-kuitansi').removeAttr('disabled');
//                            aktv = '1';
//                            return false;
                            $(this).prop('checked',false);

                        }
                    });


//                $(document).on("click",".btn_proses",function(){
//                    <?php if($_SESSION["rsa_level"] == '4'): ?>
//                    $('#myModalKonfirmKuitansi').modal('show');
//                    <?php elseif($_SESSION["rsa_level"] == '13'): ?>        
//                    document.location.href = "<?=site_url('rsa_gup/spp_gup')?>";
//                    <?php endif; ?>
//                });
                $(document).on("click",".btn_batal",function(){
                        if(confirm('Apakah anda yakin ?')){
                            var id = $(this).attr('rel');
                            var el = $(this);
                            $.ajax({
                                type:"POST",
                                url :"<?=site_url("kuitansi/proses_kuitansi")?>",
                                data:'id=' + id,
                                success:function(data){
//                                    el.removeClass('btn_batal');
//                                    el.attr('disabled','disabled');
//                                    el.attr('rel','');
//                                    
//                                    $('.ck_' + id).attr('disabled','disabled');
//                                    $('.ck_' + id).attr('rel','');

                                    window.location.reload();
                                }
                            });
                        }

                    });
                
		$(document).on("click","#pilih_tahun",function(){

                            window.location = "<?=site_url($tsite)?>/" + $("#jenis").val() + "/" + $("#tahun").val() + '/' + $("#unit").val() ;

                    });
                
                $(document).on('change', '[class^="ck_"]', function(){

                        var str = $(this).attr('rel');
//                        var kd_usulan = str.substr(0,24);
//                        var badge_ = $('#badge_id_' + str).html();
//                        var badge = badge_.trim();
                        var el = $(this) ;
                        
                        if(el.is(':enabled')){
//                            $('[class^="all_ck_"]').prop('checked',false);
                            if(el.is(':checked')){
                                // checkbox is checked
                                // alert('t');
//                                if((kd_usulan_tmp != kd_usulan) || badge_tmp != badge ){
//                                    $('[class^="ck_"]').each(function(){
//                                        $(this).prop('checked',false);
                //                        $(this).attr('readonly','readonly');
                //                         console.log($(this).attr('rel'));
//                                    });
//                                }

                                el.prop('checked',true);
                //                console.log(kd_usulan_tmp + ' | ' + kd_usulan);
//                                kd_usulan_tmp = kd_usulan ;
//                                badge_tmp = badge ;
                                

                            }else if(!(el.is(':checked'))){
                                $('[class^="all_ck"]').prop('checked',false);
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

                        // UNTUK MENGHITUNG JUMLAH KUITANSI //

                        var jml_kuitansi = 0 ;

                        $('[class^="pck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                var arel = $(this).attr('rel');

                                var jml_k = parseInt(string_to_angka($("#td_sub_tot_pengembalian_" + arel).text()));
                                jml_kuitansi = jml_kuitansi + jml_k ; 
                                
                            }

                        });

                        $('[class^="ck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                var arel = $(this).attr('rel');

                                var jml_k = parseInt(string_to_angka($("#td_sub_tot_" + arel).text()));
                                jml_kuitansi = jml_kuitansi + jml_k ; 
                                
                            }

                        });

                        $('.jml_kuitansi').text(angka_to_string(jml_kuitansi));

                        // END //

                        $('.btn_proses').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            aktv = '0';
//                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
//                                aktv = '1';
                                return false;

//                            }
                        });
                        if(aktv == '1'){
//                            $('#btn-kuitansi').attr('rel',kd_usulan);
//                            $('#btn-submit-kuitansi').attr('rel',kd_usulan);
                            $('#btn-spp').removeAttr('disabled');
                            // $('#btn-pindah').removeAttr('disabled');
                            // untuk spp ls created by dhanu
//                            $('#btn-buat-ls').attr('rel',str);
//                            $('#btn-buat-ls').removeAttr('disabled');
                            // end here

//                            $('#kode_badge').text(badge_tmp);
                        }else{
//                            $('#btn-kuitansi').attr('rel','');
//                            $('#btn-submit-kuitansi').attr('rel','');
                            $('#btn-spp').attr('disabled','disabled');
                            // $('#btn-pindah').attr('disabled','disabled');
                            // untuk spp ls created by dhanu
//                            $('#btn-buat-ls').attr('rel', '');
//                            $('#btn-buat-ls').attr('disabled','disabled');
                            // end here
                        }

                        $('#btn-pindah').removeAttr('disabled');

                    });

                    $(document).on('change', '[class^="pck_"]', function(){

                        var str = $(this).attr('rel');
//                        var kd_usulan = str.substr(0,24);
//                        var badge_ = $('#badge_id_' + str).html();
//                        var badge = badge_.trim();
                        var el = $(this) ;
                        
                        if(el.is(':enabled')){
//                            $('[class^="all_ck_"]').prop('checked',false);
                            if(el.is(':checked')){
                                // checkbox is checked
                                // alert('t');
//                                if((kd_usulan_tmp != kd_usulan) || badge_tmp != badge ){
//                                    $('[class^="ck_"]').each(function(){
//                                        $(this).prop('checked',false);
                //                        $(this).attr('readonly','readonly');
                //                         console.log($(this).attr('rel'));
//                                    });
//                                }

                                el.prop('checked',true);
                //                console.log(kd_usulan_tmp + ' | ' + kd_usulan);
//                                kd_usulan_tmp = kd_usulan ;
//                                badge_tmp = badge ;
                                

                            }else if(!(el.is(':checked'))){
                                $('[class^="all_pck"]').prop('checked',false);
                            }
                        }
                        $('[class^="pck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            aktv = '0';
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                aktv = '1';
                                
                                return false;

                            }
                        });

                        // UNTUK MENGHITUNG JUMLAH KUITANSI //

                        var jml_kuitansi = 0 ;

                        $('[class^="pck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                var arel = $(this).attr('rel');

                                var jml_k = parseInt(string_to_angka($("#td_sub_tot_pengembalian_" + arel).text()));
                                jml_kuitansi = jml_kuitansi + jml_k ; 
                                
                            }

                        });

                        $('[class^="ck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                var arel = $(this).attr('rel');

                                var jml_k = parseInt(string_to_angka($("#td_sub_tot_" + arel).text()));
                                jml_kuitansi = jml_kuitansi + jml_k ; 
                                
                            }

                        });

                        $('.jml_kuitansi').text(angka_to_string(jml_kuitansi));

                        // END //

                        $('.btn_proses').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            aktv = '0';
//                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
//                                aktv = '1';
                                return false;

//                            }
                        });
                        if(aktv == '1'){
//                            $('#btn-kuitansi').attr('rel',kd_usulan);
//                            $('#btn-submit-kuitansi').attr('rel',kd_usulan);
                            $('#btn-spp').removeAttr('disabled');
                            // $('#btn-pindah').removeAttr('disabled');
                            // untuk spp ls created by dhanu
//                            $('#btn-buat-ls').attr('rel',str);
//                            $('#btn-buat-ls').removeAttr('disabled');
                            // end here

//                            $('#kode_badge').text(badge_tmp);
                        }else{
//                            $('#btn-kuitansi').attr('rel','');
//                            $('#btn-submit-kuitansi').attr('rel','');
                            $('#btn-spp').attr('disabled','disabled');
                            // $('#btn-pindah').attr('disabled','disabled');
                            // untuk spp ls created by dhanu
//                            $('#btn-buat-ls').attr('rel', '');
//                            $('#btn-buat-ls').attr('disabled','disabled');
                            // end here
                        }

                        $('#btn-pindah').removeAttr('disabled');

                    });

                    $(document).on("click",'#btn-pindah',function(){
                        if(confirm('Yakin akan memproses ?')){

                        var rel_kuitansi = [];
                        var i = 0 ;
                        var jenis = '<?=$jenis?>' ;

                        $('[class^="ck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
//                            aktv = '0';
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
//                                aktv = '1';
//                                return false;
                                    rel_kuitansi[i] = $(this).attr('rel');
                                    i++;
                            }

                        });


                        $.ajax({
                            type:"POST",
                            url :"<?=site_url("kuitansi/pindah_kuitansi_tup")?>",
                            data:'data=' + rel_kuitansi,
                            success:function(res){
                                // if(res == 'sukses'){
                                    // bootbox.alert({
                                    //     size: "small",
                                    //     title: "Perhatian",
                                    //     message: 'Kuitansi berhasil dipindah', // + JSON.stringify(rel_kuitansi),
                                    //     animate:false,
                                    // });
                                // }else{
                                    // bootbox.alert({
                                    //     size: "small",
                                    //     title: "Perhatian",
                                    //     message: 'Maaf, kuitansi gagal dipindah!', // + JSON.stringify(rel_kuitansi),
                                    //     animate:false,
                                    // });

                                // }
                                window.location.reload();

                            }
                        });

                            // if(saldo_kas >= tot_select){
                                
                            //     $('#rel_kuitansi').val(JSON.stringify(rel_kuitansi));
                            //     $('#form_usulkan_spp').submit();

                            // }else{
                                // bootbox.alert({
                                //     size: "small",
                                //     title: "Perhatian",
                                //     message: 'Belum bisa, wait a sec plis !' , // + JSON.stringify(rel_kuitansi),
                                //     animate:false,
                                // });
                                // return false;
                            // }


                        /* END KONDISI */

//                        console.log(JSON.stringify(rel_kuitansi));
                        }else{
                            return false;
                        }
                    });
                    
                    $(document).on("click",'#btn-spp',function(){

                        var rel_kuitansi = [];
                        var rel_kuitansi_pengembalian = [];
                        var i = 0 ;
                        var jenis = '<?=$jenis?>' ;

                        $('[class^="ck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
//                            aktv = '0';
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
//                                aktv = '1';
//                                return false;
                                    rel_kuitansi[i] = $(this).attr('rel');
                                    i++;
                            }
                        });

                        $('[class^="pck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
//                            aktv = '0';
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
//                                aktv = '1';
//                                return false;
                                    rel_kuitansi_pengembalian[i] = $(this).attr('rel');
                                    i++;
                            }
                        });

                        /* KONDISI TIDAK DIPAKAI BIAR BISA BUAT KUITANSI SEBANYAK BANYAKNYA DULU , DAN DIPINDAH PAS BUAT SPP */

                        var tot_select = 0 ;
                        var saldo_kas =  parseInt(string_to_angka($('#saldo_kas').text()));

                        $('[class^="ck_"]').each(function(){
                            var relck = $(this).attr('rel');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                var sub_tot_select = $('#td_sub_tot_' + relck).text();
                                    tot_select = tot_select + parseInt(string_to_angka(sub_tot_select));
                            }
                        });

                        $('[class^="pck_"]').each(function(){
                            var relck = $(this).attr('rel');
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                var sub_tot_select = $('#td_sub_tot_pengembalian_' + relck).text();
                                    tot_select = tot_select + parseInt(string_to_angka(sub_tot_select));
                            }
                        });

                        // console.log(saldo_kas + ' - ' + tot_select);

                        if(jenis == 'GP'){

                            if(saldo_kas >= tot_select){
                                
                                $('#rel_kuitansi').val(JSON.stringify(rel_kuitansi));
                                $('#rel_kuitansi_pengembalian').val(JSON.stringify(rel_kuitansi_pengembalian));
                                $('#form_usulkan_spp').submit();

                            }else{
                                bootbox.alert({
                                    size: "small",
                                    title: "Perhatian",
                                    message: 'Maaf jumlah saldo anda tidak cukup',
                                    animate:false,
                                });
                                return false;
                            }

                        }else if((jenis == 'TP') || (jenis == 'KS')){

                            if(saldo_kas == tot_select){
                                
                                $('#rel_kuitansi').val(JSON.stringify(rel_kuitansi));
                                $('#rel_kuitansi_pengembalian').val(JSON.stringify(rel_kuitansi_pengembalian));
                                $('#form_usulkan_spp').submit();

                            }else{
                                bootbox.alert({
                                    size: "small",
                                    title: "Perhatian",
                                    message: 'Maaf jumlah tidak sesuai saldo',
                                    animate:false,
                                });
                                return false;
                            }

                        }

                        /* END KONDISI */

//                        console.log(JSON.stringify(rel_kuitansi));
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
                                    $('#kode_badge').text('<?=$jenis?>');
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
                                    $('#nmbendahara').text(kuitansi.nmbendahara);
                                    $('#nipbendahara').text(kuitansi.nipbendahara);
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
                                    $('#kode_badge_showpengembalian').text('<?=$jenis?>');
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
                    
                        $(document).on("click","#down",function(){
                        
//                                        var uri = $("#kuitansi").excelexportjs({
//                                                        containerid: "kuitansi"
//                                                        , datatype: "table"
//                                                        , returnUri: true
//                                                    });

                            var uri = $.base64.encode($("#bd-kuitansi").html()) ;

                            
                            $('#dtable').val(uri);
                            $('#form_kuitansi').submit();



                        });

                        $(document).on("click","#btn-pengembalian",function(){
                                // http://rsa.apps.undip.ac.id/index.php/kuitansi/get_next_id
                                var alias = "<?=$alias?>" ;
                                // var kd_akun= "113111" ;
                                $.ajax({
                                    type:"POST",
                                    url :"<?=site_url("kuitansi/get_data_pengembalian")?>",
                                    data:'alias=' + alias + '&jenis=' + '<?=$jenis?>',
                                    success:function(ret){
                                        var o = jQuery.parseJSON(ret);
                                            $('#myModalKuitansiPengembalian #no_bukti_pengembalian').html(o.next_id);
                                            $('#myModalKuitansiPengembalian #txt_akun_pengembalian').html(o.nama_akun);

                                            $('#kode_badge_pengembalian').text('<?=$jenis?>');

                                            $('#nm_subkomponen_kuitansi_pengembalian').text(o.nama_subkegiatan);     

                                            $('#btn-submit-kuitansi-pengembalian').attr('rel',o.kode_usulan_belanja);

                                            $('#myModalKuitansiPengembalian').modal('show');


                                            
                                    }
                                });


                                
                                



                        });


                        $("#myModalDeskripsi").on('show.bs.modal', function (event) {

                $('.formError').hide();

                $('#myModalDeskripsi input').each(function(){
                    $(this).val('');
                    // console.log($(this).val());
                });
        });






                        
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


    $(document).on("click","#myModalKuitansiPengembalian #nmpppk_pengembalian",function(){
            $('#myModalP3K').modal('show');
    });

    $(document).on("click","#myModalKuitansiPengembalian #nippppk_pengembalian",function(){
            $('#myModalP3K').modal('show');
    });

    $(document).on("click","#btn-pilih-pppk-ojo-dikopi-id-iki-yo-lek",function(){
    if($('input[name="id_user"]:checked').length > 0){
        var id_user = $("input[name='id_user']:checked").val();
        var nm_pppk = $("#nm_input_" + id_user).val();
        var nip_pppk = $("#nip_input_" + id_user).val();

        $('#myModalKuitansiPengembalian #nmpppk_pengembalian').text(nm_pppk);
        $('#myModalKuitansiPengembalian #editpppk_pengembalian').remove();
        $('#myModalKuitansiPengembalian #nmpppk_pengembalian').after('<span id="editpppk_pengembalian"> [ <a href="#" data-toggle="modal" data-target="#myModalP3K" style="cursor:pointer">edit</a> ]</span>');
        $('#myModalKuitansiPengembalian #nippppk_pengembalian').text(nip_pppk);

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

    $(document).on("click",".tambah_deskripsi",function(){
            $('.formError').hide();
            $('#form_deskripsi')[0].reset();
            $('#myModalDeskripsi').modal('show');
            $('#iddeskripsi').val($(this).attr('rel'));
            return false;
    });

    // $(document).on("click","#btn-deskripsi",function(){
    //         if($("#form_deskripsi").validationEngine("validate")){
    //         }
    // });

            $(document).on("click","#btn-deskripsi",function(){
                if($("#form_deskripsi").validationEngine("validate")){
                    var rel = $('#iddeskripsi').val();
                    var keluaran_ = [] ;
                        keluaran_[0] = $('#iddeskripsi').val();
                        keluaran_[1] = encodeURIComponent($('#deskripsi').val());
                        keluaran_[2] = $('#kuantitas').val();
                        keluaran_[3] = $('#satuan').val();
                        keluaran_[4] = $('#jumlah').val();
                    
                    var n = keluaran.length ;
                        keluaran[n] = keluaran_ ;

                    var nomor = parseInt($('#iddeskripsi').val()) + 1 ;

                    var bruto = parseInt($('#kuantitas').val()) * parseInt($('#jumlah').val()) ;
                        
                    var str = '<tr id="tr_n_'+ n +'" class="tr_k_'+ n +'">' ;
                        str =  str + '<td colspan="3">'+ nomor + '.<span id="deskripsi_pengembalian">' + $('#deskripsi').val() +'</span> <span id="tb_hapus_des_'+ nomor +'">[ <a href="#" rel="' + n + '" class="hapus_deskripsi" style="cursor:pointer">hapus</a> ]</span></td>';
                        str =  str + '<td class="text-center"><span id="volume_pengembalian">'+ $('#kuantitas').val() +'</span></td>';
                        str =  str + '<td class="text-left"><span id="satuan_pengembalian">'+ $('#satuan').val() +'</span></td>';
                        str =  str + '<td class="text-right"><span id="harga_satuan_pengembalian">'+ angka_to_string($('#jumlah').val()) +'</span></td>';
                        str =  str + '<td style="text-align:right" rel="'+ n +'" class="sub_tot_bruto_'+ n +'" >'+ angka_to_string(bruto) +'</td>';
                        str =  str + '<td style="padding: 0 5px 0 5px;"></td>';
                        str =  str + '<td style="text-align:right;"><span rel="'+ rel +'" class="sub_tot_pajak_0">0</span></td>';
                        str =  str + '<td><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></td>';
                        str =  str + '<td style="text-align:right" rel="'+ n +'" class="sub_tot_netto_'+ n +'">'+ angka_to_string(bruto) +'</td>';
                        str =  str + '</tr>' ;
                        // str =  str + '<tr id="tr_isi_pengembalian"><td colspan="11">[ <a href="#" rel="'+ nomor +'" class="tambah_deskripsi" >tambah</a> ]</td></tr>' ;
                       // console.log(JSON.stringify(keluaran));
                    $('[id^="tb_hapus_des_"]').hide(); 
                    $("#tr_isi_pengembalian").replaceWith(str);

                    var tot_bruto = 0 ;
                    $('[class^="sub_tot_bruto_"]').each(function(){
                        tot_bruto = tot_bruto + parseInt(string_to_angka($(this).text()));
                    });
                    $('.sum_tot_bruto_pengembalian').text(angka_to_string(tot_bruto));
                    $('.sum_tot_netto_pengembalian').text(angka_to_string(tot_bruto));
                    $('.text_tot_pengembalian').html(terbilang(tot_bruto));

                    
                    $('#myModalDeskripsi').modal('hide');
    //                var n = keluaran.length ;
    //                    keluaran[n] = keluaran_ ;
    //                     console.log(JSON.stringify(keluaran));
                }else{
                    return false;
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



        $(document).on("click","#btn-submit-kuitansi-pengembalian",function(){


            var str = $(this).attr('rel') ;
            var kd_usulan = str.substr(0,24);
            // var kd_tambah = str.substr(24,3);

            var no_bukti = $('#myModalKuitansiPengembalian #no_bukti_pengembalian').text();

            var uraian = $('#myModalKuitansiPengembalian #uraian_pengembalian').text();

            var penerima_uang = $('#myModalKuitansiPengembalian #penerima_uang_pengembalian').text();

            var penerima_uang_nip =  $('#myModalKuitansiPengembalian #penerima_uang_nip_pengembalian').text();
//            var penerima_uang_nip = penerima_uang_nip_.trim();

            var penerima_barang = $('#myModalKuitansiPengembalian #penerima_barang_pengembalian').text();

            var penerima_barang_nip = $('#myModalKuitansiPengembalian #penerima_barang_nip_pengembalian').text();

            var kode_usulan_belanja = kd_usulan;
            // var kode_akun_tambah = kd_tambah;

            // NEW ADD
            var badge_tmp = $('#kode_badge_pengembalian').text();

            var ok = 'true';

            $('#myModalKuitansiPengembalian .input_boot').each(function(){
                var el = $(this).text();
                if( el.trim() == '- edit here -' ){

                    ok = 'false';

                }
            });


            $('#myModalKuitansiPengembalian .edit_here').each(function(){
                var el = $(this).text();
                if( el.trim() == '- edit here -' ){

                    ok = 'false';

                }
            });

//            console.log($('#myModalKuitansi .sum_tot_netto').text());

            if(ok == 'true'){
               if($('#myModalKuitansiPengembalian .sum_tot_netto').text() == '0'){
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

                var kode_akun_tambah_ = ['001'];
                var pj_p_kode_usulan_all = ["000000000000000000  001"];
                var pj_p_id_all = [];
                var pj_p_jenis_all = [];
                var pj_p_persen_all = [];
                var pj_p_dpp_all = [];
                var pj_p_nilai_all = [];

                var data_detail = { 'deskripsi' : $('#deskripsi_pengembalian').text() , 'volume' : $('#volume_pengembalian').text() , 'satuan' : $('#satuan_pengembalian').text() , 'harga_satuan' : string_to_angka($('#harga_satuan_pengembalian').text()) }; 

                // pajak_kode_usulan:["611111020201010401523159002"]
                // pajak_id_input:[["1","3"]]
                // pajak_jenis:[["ppn","pphps21"]]
                // pajak_dpp:[["0","1"]]
                // pajak_persen:[["10","15"]]
                // pajak_nilai:[["100.000","136.364"]]

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

                var data =  'kode_unit=' + '<?=$kode_unit?>' + '&no_bukti='+ no_bukti + '&uraian=' + encodeURIComponent(uraian) + '&jenis=' + badge_tmp + '&sumber_dana=<?=$sumber_dana?>' + '&kode_usulan_belanja=' + kode_usulan_belanja + '&kode_akun_tambah=' + JSON.stringify(kode_akun_tambah_) + '&penerima_uang=' + encodeURIComponent(penerima_uang) + '&penerima_uang_nip=' + penerima_uang_nip + '&penerima_barang=' + penerima_barang + '&penerima_barang_nip=' + penerima_barang_nip + '&nmpppk=' + $('#myModalKuitansiPengembalian #nmpppk_pengembalian').text() + '&nippppk=' + $('#myModalKuitansiPengembalian #nippppk_pengembalian').text() + '&nmbendahara=' + $('#myModalKuitansiPengembalian #nmbendahara_pengembalian').text() + '&nipbendahara=' + $('#myModalKuitansiPengembalian #nipbendahara_pengembalian').text() + '&nmpumk=' + $('#myModalKuitansiPengembalian #nmpumk_pengembalian').text() + '&nippumk=' + $('#myModalKuitansiPengembalian #nippumk_pengembalian').text() + '&pajak_kode_usulan=' + JSON.stringify(pj_p_kode_usulan_all) + '&pajak_id_input=' + JSON.stringify(pj_p_id_all) + '&pajak_jenis=' + JSON.stringify(pj_p_jenis_all) + '&pajak_dpp=' + JSON.stringify(pj_p_dpp_all) + '&pajak_persen=' + JSON.stringify(pj_p_persen_all) + '&pajak_nilai=' +JSON.stringify(pj_p_nilai_all) + '&data_detail=' + JSON.stringify(data_detail) ;

                // '&pajak_kode_usulan=' + JSON.stringify(pj_p_kode_usulan_all) + '&pajak_id_input=' + JSON.stringify(pj_p_id_all) + '&pajak_jenis=' + JSON.stringify(pj_p_jenis_all) + '&pajak_dpp=' + JSON.stringify(pj_p_dpp_all) + '&pajak_persen=' + JSON.stringify(pj_p_persen_all) + '&pajak_nilai=' +JSON.stringify(pj_p_nilai_all) ; // '&penerima_uang_nip=' + penerima_uang_nip +

                // console.log(JSON.stringify(data));


                $.ajax({
                    type:"POST",
                    url :"<?=site_url("kuitansi/submit_kuitansi_pengembalian")?>",
                    data: data,
                    success:function(data){
                       // console.log(data)
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
</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->
                
                <div class="row">
                    <div class="col-lg-12">
                        <h2>DAFTAR KUITANSI <?php 
                    if($jenis == 'GP'){echo 'GUP' ; }
                    else if($jenis == 'TP'){echo 'TUP' ;}
                    else if($jenis == 'LK'){echo 'LSK' ;}
                    else if($jenis == 'LN'){echo 'LSNK' ;}?> CAIR</h2> 
                    </div>
                </div>
                <hr />

                <div class="row">
            <div class="col-md-12">
                            
                <form id="kentut" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-1">Tahun : </label>
                                <div class="col-md-3">
                                    <?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'validate[required] form-control','id'=>'tahun'))?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1">Unit : </label>
                                <div class="col-md-6">
                                     <select name="unit" id="unit" class="validate[required] form-control">
                                        <!--<option value="">-pilih-</option>-->
                                        <!-- <option value="99">99 - [ SEMUA ]</option> -->
                                        <?php foreach($data_unit as $du): ?>
                                        <option value="<?=$du->kode_unit?>"><?=$du->kode_unit?> - <?=$du->nama_unit?> [ <?=$du->alias?> ]</option>
                                        <?php endforeach; ?>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1">Jenis : </label>
                                <div class="col-md-3">
                                     <select name="jenis" id="jenis" class="validate[required] form-control">
                                        <!--<option value="00">[ SEMUA ]</option>-->
                                        <option value="GP">[ GUP ]</option>
                                        <!-- <option value="TUP">[ TUP ]</option> -->
                                        <option value="TP">[ TUP-NIHIL ]</option>
                                        <!-- <option value="LSP">[ LSP ]</option> -->
                                        <option value="LK">[ LSK ]</option>
                                        <option value="LN">[ LSNK ]</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-1">
                                    &nbsp;
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-danger btn-sm" id="pilih_tahun"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Apply Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
        
        <div class="col-md-12">
        <div class="alert alert-info"><span class="text-warning"><b>Filter : </b></span> <b>Tahun [ <span class="text-danger"><b><?=$cur_tahun?></b></span> ] Unit [ <span class="text-danger"><b><?=$kode_unit_subunit?></b></span> ] Jenis [ <span class="text-danger"><b><?=$jenis?></b></span> ]</b></div>
        </div>

        </div>
<!--
		<div class="row">
			<div class="col-md-12">
                            
				<form id="kentut" class="form-horizontal">
					<div class="row">
						<div class="col-md-8">
                        <div class="alert alert-warning" style="border-color: #ebccd1;">
							<div class="form-group">
								<label class="col-md-2">Tahun: </label>
								<div class="col-md-4">
									<?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'validate[required] form-control','id'=>'tahun'))?>
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-primary btn-sm" id="pilih_tahun">Pilih Tahun</button>
								</div>
							</div>
                            </div>

                        </div>
                        <div class="col-md-4">

                        

                        <?php if($jenis == 'GP'): ?>
                        <div class="panel panel-danger" style="margin-bottom: 0;">
                            <div class="panel-heading">
                              <h3 class="panel-title">UP TERSEDIA</h3>
                            </div>
                            <div class="panel-body">
                                <h3 style="margin: 0"><span class="text-danger">Rp. <span id="saldo_kas"><?=number_format(get_saldo_up($_SESSION['rsa_kode_unit_subunit'],$cur_tahun), 0, ",", ".")?></span>,-</span></h3>
                            </div>
                        </div>
                        <?php elseif($jenis == 'TP'): ?>
                        <div class="panel panel-danger" style="margin-bottom: 0;">
                            <div class="panel-heading">
                              <h3 class="panel-title">TUP TERSEDIA</h3>
                            </div>
                            <div class="panel-body">
                                <h3 style="margin: 0"><span class="text-danger">Rp. <span id="saldo_kas"><?=number_format(get_saldo_tup($_SESSION['rsa_kode_unit_subunit'],$cur_tahun), 0, ",", ".")?> </span>,-</span></h3>
                            </div>
                        </div>
                    <?php elseif($jenis == 'KS'): ?>
                        <div class="panel panel-danger" style="margin-bottom: 0;">
                            <div class="panel-heading">
                              <h3 class="panel-title">KS TERSEDIA</h3>
                            </div>
                            <div class="panel-body">
                            <?php $i = array('1','2') ; $ni = count($i) ; foreach($i as $n): ?>
                                <h3 style="margin: 0"><span class="text-danger">KS-<?=$n?> | Rp. <span id="saldo_kas"><?=number_format(get_saldo_tup($_SESSION['rsa_kode_unit_subunit'],$cur_tahun), 0, ",", ".")?> </span>,-</span></h3>
                                <?php if($n != $ni){ echo '<hr>' ; } ?>
                            <?php endforeach; ?>
                            </div>
                        </div>

                            

                        <?php else: ?>
                                                    &nbsp;
                        <?php endif; ?>

                       

						</div>
					</div>
				</form>
			</div>
		</div>

         --> 

        <!--
                <?php if($_SESSION['rsa_level'] == 13) : ?>
                <div class="alert alert-warning" >
                    <button class="btn btn-warning" id="btn-spp" disabled="disabled" ><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Proses SPP</button>
                    <button class="btn btn-success" id="btn-lihat-spp" onclick="window.location = '<?php 
                    if($jenis == 'GP'){echo site_url('rsa_gup/spp_gup') ; }
                    else if($jenis == 'TP'){echo site_url('rsa_tup/spp_tup') ;}?>'" ><span class="glyphicon glyphicon-open-file" aria-hidden="true"></span> Lihat SPP Berjalan</button>
                    <?php if($jenis == 'GP'): ?>
                    <button class="btn btn-danger" id="btn-pindah" disabled="disabled" ><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> Pindah TUP</button>
                    <?php endif; ?>
                    <?php // if($jenis == 'TP'): ?>
                    <button class="btn btn-info" id="btn-pengembalian" ><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Pengembalian</button>
                    <?php // endif; ?>
                </div>
                <?php else: ?>
                <div class="alert alert-warning">
                    <button class="btn btn-warning" id="" disabled="disabled" ><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Proses SPP</button>
                </div>
                <?php endif; ?>

        -->

		<div class="row">
                    
                    <div class="col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <!--<li role="presentation" id="k-aktif" ><a href="<?=site_url('kuitansi/daftar_kuitansi/'.$jenis.'/')?>" >Kuitansi Aktif</a></li>-->
                        <!--<li role="presentation" id="k-batal" ><a href="<?=site_url('kuitansi/daftar_kuitansi_batal/'.$jenis.'/')?>" >Batal</a></li>-->
                        <li role="presentation" id="k-cair" ><a href="<?=site_url('kuitansi/daftar_kuitansi_cair/'.$jenis.'/'.$cur_tahun.'/'.$kode_unit_subunit)?>" >Cair</a></li>
                    </ul>
                    </div>
                    <br />
                    <br />




                    

<!---
                <div class="col-md-12" >
                    <div class="alert alert-info" style="border-color:#3793a7;" id="panel-jml-show">
                        <span class="text-danger">Jumlah aktif kuitansi dipilih : <b class="jml_kuitansi">0</b></span>
                    </div>
                </div>

                <div style="position: fixed;top: 79px;z-index:999;right:0px;width:300px;display:none;" id="panel-jml" >
                    <div class="alert alert-info" style="border-radius:0px;border-color:#3793a7;">
                        <span class="text-danger">Jumlah aktif kuitansi dipilih : <b class="jml_kuitansi">0</b></span>
                    </div>
                </div>

-->

            <div class="col-md-12 table-responsive" style="" id="tb-data-pengembalian">
                <table class="table table-bordered table-striped small"  style="" >
                    <thead>
                    <tr>
                        <th colspan="9" class="text-center alert-danger">DAFTAR KUITANSI PENGEMBALIAN</th>
                    </tr>
                    <tr>
                        <th class="text-center col-md-1" style="vertical-align: middle;">No</th>
                        <th class="text-center col-md-1" style="vertical-align: middle;">Unit</th>
                        <th class="text-center col-md-2" style="vertical-align: middle;">Nomor</th>
                        <th class="text-center col-md-2" style="vertical-align: middle;">Tanggal</th>
                                                <th class="text-center col-md-2" style="vertical-align: middle;">Uraian</th>
                        <th class="text-center col-md-1" style="vertical-align: middle;">Pengeluaran</th>
                        <th class="text-center col-md-1" style="vertical-align: middle;">&nbsp;</th>
                                                <th class="text-center col-md-1" style="vertical-align: middle;">Status</th>
                                                <!--<th class="text-center col-md-1">Proses</th>-->
                                                <th class="text-center col-md-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style="background-color: #f9ff83;"> 
                                                            <input type="checkbox" aria-label="" rel="" class="all_pck">
                                                        </span>
                                                    </div>
                                                </th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
        if(!empty($daftar_kuitansi_pengembalian)){
//                    echo '<pre>';var_dump($daftar_kuitansi);echo '</pre>';
            $tot_kuitansi_pengembalian = 0 ;
            foreach ($daftar_kuitansi_pengembalian as $key => $value) {

                ?>

                <tr>
                        <td class="text-center"><?php echo $key + 1; ?>.</td>
                        <td class="text-center"><?php echo $value->kode_unit; ?></td>
                        <td class="text-center"><?php echo $value->no_bukti; ?></td>
                                                <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_kuitansi)); ?><br /></td>
                        <td class=""><?php echo $value->uraian; ?></td>
                        <td class="text-right" id="td_sub_tot_pengembalian_<?=$value->id_kuitansi?>">
                                                <?=number_format($value->pengeluaran, 0, ",", ".")?>
                                                <?php $tot_kuitansi = $tot_kuitansi + $value->pengeluaran ; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                                <button  class="btn btn-default btn-sm btn-lihat-pengembalian" rel="<?php echo $value->id_kuitansi; ?>" ><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                                                </td>
                                                <td class="text-center">
                                                    <?php if($value->aktif == "1"):?>
                                                        <?php if(is_null($value->str_nomor_trx)):?>
                                                        <button type="button" class="btn btn-danger btn-sm btn_batal_pengembalian" rel="<?php echo $value->id_kuitansi; ?>" title="Batal"><i class="glyphicon glyphicon-remove"></i></button>
                                                        <?php else: ?>
                                                            <?php if($value->cair == '0'):?>
                                                                <?php if(!is_null($value->str_nomor_trx_spm)):?>
                                                                <button type="button" class="btn btn-success btn-sm btn_proses" rel="" onclick="bootbox.alert('STATUS : SPM <br>SPM : <?=$value->str_nomor_trx_spm?> <br>SPP : <?=$value->str_nomor_trx?>')" title="STATUS : SPM"><i class="glyphicon glyphicon-file"></i></button>
                                                                <?php else: ?>
                                                                    <?php if(!is_null($value->str_nomor_trx)):?>
                                                                    <button type="button" class="btn btn-warning btn-sm btn_proses" rel="" onclick="bootbox.alert('STATUS : SPP <br>SPP : <?=$value->str_nomor_trx?>')" title="STATUS : SPP"><i class="glyphicon glyphicon-file"></i></button>
                                                                    <!--<button type="button" class="btn btn-success btn-sm btn_proses" rel="<?php echo $value->id_kuitansi; ?>" title="Diajukan SPP"><i class="glyphicon glyphicon-file"></i></button>-->
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                        <?php 
                        $link = '' ;
                        if($jenis == 'GP'){
                            $link = site_url('/rsa_gup/spm_gup_lihat_99/').urlencode(base64_encode($value->str_nomor_trx_spm)).'/'.$kode_unit_subunit.'/'.$cur_tahun ;
                        }elseif($jenis == 'TP'){
                            $link = site_url('/rsa_tup/spm_tup_lihat_99/').urlencode(base64_encode($value->str_nomor_trx_spm)).'/'.$kode_unit_subunit.'/'.$cur_tahun ;
                        }elseif($jenis == 'LK'){
                            $link = site_url('/rsa_lsk/spm_lsk_lihat_99/').urlencode(base64_encode($value->str_nomor_trx)) ;
                        }elseif($jenis == 'LN'){
                            $link = site_url('/rsa_lsnk/spm_lsnk_lihat_99/').urlencode(base64_encode($value->str_nomor_trx)) ;
                        }  ?>
                                                            <button type="button" class="btn btn-info btn-sm btn_cair" rel="" onclick="bootbox.alert('STATUS : CAIR <br>SPM : <?=$value->str_nomor_trx_spm?> <br>SPP : <?=$value->str_nomor_trx?> <br>[ <a href=\'<?=$link?>\'>lihat</a> ]')" title="STATUS : CAIR"><i class="glyphicon glyphicon-file"></i></button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                    <button type="button" class="btn btn-danger btn-sm btn_batal_pengembalian" rel="" disabled="disabled" ><i class="glyphicon glyphicon-remove"></i></button>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                          <?php if($value->aktif == "1"):?>
                                                            <?php if(is_null($value->str_nomor_trx)):?>
                                                            <input type="checkbox" aria-label="" rel="<?=$value->id_kuitansi?>" class="pck_<?=$value->id_kuitansi?>">
                                                            <?php else: ?>
                                                            <input type="checkbox" checked="checked" aria-label="" rel="" disabled="disabled" class="">
                                                            <?php endif; ?>
                                                          
                                                          <?php else: ?>
                                                          <input type="checkbox" aria-label="" rel="" disabled="disabled" class="pck_<?=$value->id_kuitansi?>">
                                                          <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </td>
                    </tr>


                    <?php } ?>

                    <tr class="alert-warning" style="" >
                        <td colspan="5" class="text-right">
                            <b>Total :</b>
                        </td>
                        <td  class="text-right">
                            <b><?=number_format($tot_kuitansi, 0, ",", ".")?></b>
                        </td>
                        <td colspan="3" >
                        &nbsp;
                        </td>
                    </tr>

                    <?php
        }else{
    ?>
                    <tr>
                        <td colspan="9" class="text-center alert-warning">
                        Tidak ada data
                        </td>
                    </tr>
    <?php
        }
    ?>
                    <tr>
                        <td colspan="9" >&nbsp;</td>
                    </tr>
                                        </tbody>
                </table>
            </div>

            <?php 
                    if(isset($dgu)){
                    ?>
                    <div class="col-md-12">
                    <div class="alert alert-info" style="padding-top:5px;padding-bottom:5px;">
                        <span class="text-danger"><b>Filter :</b></span> unit [ <b><?=$dgu?></b> ]
                    </div>
                    </div>
                    <?php 
                    }
                    ?>

                    <?php 
                    if(isset($dgn)){
                    ?>
                    <div class="col-md-12">
                    <div class="alert alert-info" style="padding-top:5px;padding-bottom:5px;">
                        <span class="text-danger"><b>Filter :</b></span> nomor [ <b><?=$dgn?></b> ] <!-- <a href="<?=current_url()?>" class="">RESET</a> -->
                    </div>
                    </div>
                    <?php 
                    }
                    ?>

                    <?php 
                    if(isset($dgt)){

                        setlocale(LC_ALL, 'id_ID.utf8'); $dgt = strftime("%d %B %Y", strtotime($dgt));

                    ?>
                    <div class="col-md-12">
                    <div class="alert alert-info" style="padding-top:5px;padding-bottom:5px;">
                        <span class="text-danger"><b>Filter :</b></span> tanggal [ <b><?=$dgt?></b> ] <!-- <a href="<?=current_url()?>" class="">RESET</a> -->
                    </div>
                    </div>
                    <?php 
                    }
                    ?>

                    <?php 
                    if(isset($dgr)){
                    ?>
                    <div class="col-md-12">
                    <div class="alert alert-info" style="padding-top:5px;padding-bottom:5px;">
                        <span class="text-danger"><b>Filter :</b></span> uraian [ <b><?=$dgr?></b> ] <!-- <a href="<?=current_url()?>" class="">RESET</a> -->
                    </div>
                    </div>
                    <?php 
                    }
                    ?>



			<div class="col-md-12 table-responsive" style="" id="tb-data">
				<table class="table table-bordered table-striped small"  style="" >
					<thead>
                    <tr>
                        <th colspan="9" class="text-center alert-success">DAFTAR KUITANSI PEMBAYARAN</th>
                    </tr>
					<tr>
                        <th class="text-center col-md-1" style="vertical-align: middle;">No</th>
                        <th class="text-center col-md-1" style="vertical-align: middle;">Unit</th>
                        <th class="text-center col-md-2" style="vertical-align: middle;">Nomor</th>
						<th class="text-center col-md-2" style="vertical-align: middle;">Tanggal</th>
                                                <th class="text-center col-md-2" style="vertical-align: middle;">Uraian</th>
						<th class="text-center col-md-1" style="vertical-align: middle;">Pengeluaran</th>
						<th class="text-center col-md-1" style="vertical-align: middle;">&nbsp;</th>
                                                <th class="text-center col-md-1" style="vertical-align: middle;">Status</th>
                                                <!--<th class="text-center col-md-1">Proses</th>-->
                                                <th class="text-center col-md-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style="background-color: #f9ff83;"> 
                                                            <input type="checkbox" aria-label="" rel="" class="all_ck">
                                                        </span>
                                                    </div>
                                                </th>
					</tr>
					</thead>
					<tbody>
                        <tr>
                            <td class="text-center col-md-1" style="vertical-align: middle;">
                                <a href="<?=current_url()?>" class="btn btn-sm btn-success">RESET</a>
                            </td>
                            <td class="text-center col-md-1" style="vertical-align: middle;">
                            <!--
                                <div class="btn-group">
                                  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    - pilih unit -
                                  </button>
                                  <ul class="dropdown-menu">
                                    <?php foreach($daftar_kuitansi_unit as $dt): ?>
                                        <?php if(strlen($dt->kode_unit)==2): ?>
                                        <li><a href="?u=<?=$dt->kode_unit?>"><?=$dt->kode_unit.' - '.$dt->nama_unit?></a></li>
                                        <li role="separator" class="divider"></li>
                                        <?php elseif(strlen($dt->kode_unit)==4): ?>
                                        <li><a href="?u=<?=$dt->kode_unit?>"><?=$dt->kode_unit.' - '.$dt->nama_subunit?></a></li>
                                        <li role="separator" class="divider"></li>
                                        <?php elseif(strlen($dt->kode_unit)==6): ?>
                                        <li><a href="?u=<?=$dt->kode_unit?>"><?=$dt->kode_unit.' - '.$dt->nama_sub_subunit?></a></li>
                                        <li role="separator" class="divider"></li>  
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                        <li><a href="<?=current_url()?>">SEMUA</a></li>
                                  </ul>
                                </div>
                            -->
                            </td>
                            <td class="text-center col-md-2" style="vertical-align: middle;">
                                <input type="text" class="form-control input-sm" placeholder="cari.." id="cr_nomor">
                            </td>
                            <td class="text-center col-md-2" style="vertical-align: middle;">
                                <!-- <div class="form-group" style="margin-bottom: 0px;">
                                    <div class="input-group date" id="datetimepicker1">
                                        <input type='text' class="form-control input-sm" id="dp1" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div> -->
                                <div class="input-group">
                                      <input type="text" class="form-control input-sm" placeholder="cari.." id="dp1" >
                                      <span class="input-group-btn">
                                        <button class="btn btn-default btn-sm" type="button" id="cr_tgl">Cari</button>
                                      </span>
                                    </div><!-- /input-group -->

                            </td>
                            <td class="text-center col-md-2" style="vertical-align: middle;">
                                <input type="text" class="form-control input-sm" placeholder="cari.." id="cr_uraian">
                            </td>
                            <td class="text-center col-md-1" style="vertical-align: middle;">
                                <!-- <input type="text" class="form-control input-sm" placeholder="cari.."> -->
                            </td>
                            <td class="text-center col-md-1" style="vertical-align: middle;">&nbsp;</td>
                                                    <td class="text-center col-md-1" style="vertical-align: middle;">&nbsp;</td>
                                                    <!--<th class="text-center col-md-1">Proses</th>-->
                                                    <td class="text-center col-md-1">
                                                        &nbsp;
                                                    </td>
                        </tr>
	<?php
		if(!empty($daftar_kuitansi)){
//                    echo '<pre>';var_dump($daftar_kuitansi);echo '</pre>';
            $tot_kuitansi = 0 ;
			foreach ($daftar_kuitansi as $key => $value) {

                if(isset($dgu)||isset($dgn)||isset($dgt)||isset($dgr)){
                    setlocale(LC_ALL, 'id_ID.utf8');
                    if(($value->kode_unit == $dgu)||(stripos($value->no_bukti, $dgn)!== false)||(strftime("%d %B %Y", strtotime($value->tgl_kuitansi)) == $dgt)||(stripos($value->uraian, $dgr)!== false)){
                
	?>
					<tr>
						<td class="text-center"><?php echo $key + 1; ?>.</td>
                        <td class="text-center"><?php echo $value->kode_unit; ?></td>
						<td class="text-center"><?php echo $value->no_bukti; ?></td>
                                                <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_kuitansi)); ?><br /></td>
						<td class=""><?php echo $value->uraian; ?></td>
						<td class="text-right" id="td_sub_tot_<?=$value->id_kuitansi?>">
                                                <?=number_format($value->pengeluaran, 0, ",", ".")?>
                                                <?php $tot_kuitansi = $tot_kuitansi + $value->pengeluaran ; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                                <button  class="btn btn-default btn-sm btn-lihat" rel="<?php echo $value->id_kuitansi; ?>" ><i class="glyphicon glyphicon-search"></i></button>
							</div>
                                                </td>
                                                <td class="text-center">
                                                    <?php if($value->aktif == "1"):?>
                                                        <?php if(is_null($value->str_nomor_trx)):?>
                                                        <button type="button" class="btn btn-danger btn-sm btn_batal" rel="<?php echo $value->id_kuitansi; ?>" title="Batal"><i class="glyphicon glyphicon-remove"></i></button>
                                                        <?php else: ?>
                                                            <?php if($value->cair == '0'):?>
                                                                <?php if(!is_null($value->str_nomor_trx_spm)):?>
                                                                <button type="button" class="btn btn-success btn-sm btn_proses" rel="" onclick="bootbox.alert('STATUS : SPM <br>SPM : <?=$value->str_nomor_trx_spm?> <br>SPP : <?=$value->str_nomor_trx?>')" title="STATUS : SPM"><i class="glyphicon glyphicon-file"></i></button>
                                                                <?php else: ?>
                                                                    <?php if(!is_null($value->str_nomor_trx)):?>
                                                                    <button type="button" class="btn btn-warning btn-sm btn_proses" rel="" onclick="bootbox.alert('STATUS : SPP <br>SPP : <?=$value->str_nomor_trx?>')" title="STATUS : SPP"><i class="glyphicon glyphicon-file"></i></button>
                                                                    <!--<button type="button" class="btn btn-success btn-sm btn_proses" rel="<?php echo $value->id_kuitansi; ?>" title="Diajukan SPP"><i class="glyphicon glyphicon-file"></i></button>-->
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                        <?php 
                        $link = '' ;
                        if($jenis == 'GP'){
                            $link = site_url('/rsa_gup/spm_gup_lihat_99/').urlencode(base64_encode($value->str_nomor_trx_spm)).'/'.$kode_unit_subunit.'/'.$cur_tahun ;
                        }elseif($jenis == 'TP'){
                            $link = site_url('/rsa_tup/spm_tup_lihat_99/').urlencode(base64_encode($value->str_nomor_trx_spm)).'/'.$kode_unit_subunit.'/'.$cur_tahun ;
                        }elseif($jenis == 'LK'){
                            $link = site_url('/rsa_lsk/spm_lsk_lihat_99/').urlencode(base64_encode($value->str_nomor_trx)) ;
                        }elseif($jenis == 'LN'){
                            $link = site_url('/rsa_lsnk/spm_lsnk_lihat_99/').urlencode(base64_encode($value->str_nomor_trx)) ;
                        }  ?>
                                                            <button type="button" class="btn btn-info btn-sm btn_cair" rel="" onclick="bootbox.alert('STATUS : CAIR <br>SPM : <?=$value->str_nomor_trx_spm?> <br>SPP : <?=$value->str_nomor_trx?> <br>[ <a href=\'<?=$link?>\'>lihat</a> ]')" title="STATUS : CAIR"><i class="glyphicon glyphicon-file"></i></button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                    <button type="button" class="btn btn-danger btn-sm btn_batal" rel="" disabled="disabled" ><i class="glyphicon glyphicon-remove"></i></button>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                          <?php if($value->aktif == "1"):?>
                                                            <?php if(is_null($value->str_nomor_trx)):?>
                                                            <input type="checkbox" aria-label="" rel="<?=$value->id_kuitansi?>" class="ck_<?=$value->id_kuitansi?>">
                                                            <?php else: ?>
                                                            <input type="checkbox" checked="checked" aria-label="" rel="" disabled="disabled" class="">
                                                            <?php endif; ?>
                                                          
                                                          <?php else: ?>
                                                          <input type="checkbox" aria-label="" rel="" disabled="disabled" class="ck_<?=$value->id_kuitansi?>">
                                                          <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </td>
					</tr>
	<?php
                }
                    }

                    else{


                        ?>
            <tr>
                        <td class="text-center"><?php echo $key + 1; ?>.</td>
                        <td class="text-center"><?php echo $value->kode_unit; ?></td>
                        <td class="text-center"><?php echo $value->no_bukti; ?></td>
                                                <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_kuitansi)); ?><br /></td>
                        <td class=""><?php echo $value->uraian; ?></td>
                        <td class="text-right" id="td_sub_tot_<?=$value->id_kuitansi?>">
                                                <?=number_format($value->pengeluaran, 0, ",", ".")?>
                                                <?php $tot_kuitansi = $tot_kuitansi + $value->pengeluaran ; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                                <button  class="btn btn-default btn-sm btn-lihat" rel="<?php echo $value->id_kuitansi; ?>" ><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                                                </td>
                                                <td class="text-center">
                                                    <?php if($value->aktif == "1"):?>
                                                        <?php if(is_null($value->str_nomor_trx)):?>
                                                        <button type="button" class="btn btn-danger btn-sm btn_batal" rel="<?php echo $value->id_kuitansi; ?>" title="Batal"><i class="glyphicon glyphicon-remove"></i></button>
                                                        <?php else: ?>
                                                            <?php if($value->cair == '0'):?>
                                                                <?php if(!is_null($value->str_nomor_trx_spm)):?>
                                                                <button type="button" class="btn btn-success btn-sm btn_proses" rel="" onclick="bootbox.alert('STATUS : SPM <br>SPM : <?=$value->str_nomor_trx_spm?> <br>SPP : <?=$value->str_nomor_trx?>')" title="STATUS : SPM"><i class="glyphicon glyphicon-file"></i></button>
                                                                <?php else: ?>
                                                                    <?php if(!is_null($value->str_nomor_trx)):?>
                                                                    <button type="button" class="btn btn-warning btn-sm btn_proses" rel="" onclick="bootbox.alert('STATUS : SPP <br>SPP : <?=$value->str_nomor_trx?>')" title="STATUS : SPP"><i class="glyphicon glyphicon-file"></i></button>
                                                                    <!--<button type="button" class="btn btn-success btn-sm btn_proses" rel="<?php echo $value->id_kuitansi; ?>" title="Diajukan SPP"><i class="glyphicon glyphicon-file"></i></button>-->
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                        <?php 
                        $link = '' ;
                        if($jenis == 'GP'){
                            $link = site_url('/rsa_gup/spm_gup_lihat_99/').urlencode(base64_encode($value->str_nomor_trx_spm)).'/'.$kode_unit_subunit.'/'.$cur_tahun ;
                        }elseif($jenis == 'TP'){
                            $link = site_url('/rsa_tup/spm_tup_lihat_99/').urlencode(base64_encode($value->str_nomor_trx_spm)).'/'.$kode_unit_subunit.'/'.$cur_tahun ;
                        }elseif($jenis == 'LK'){
                            $link = site_url('/rsa_lsk/spm_lsk_lihat_99/').urlencode(base64_encode($value->str_nomor_trx)) ;
                        }elseif($jenis == 'LN'){
                            $link = site_url('/rsa_lsnk/spm_lsnk_lihat_99/').urlencode(base64_encode($value->str_nomor_trx)) ;
                        }?>
                                                            <button type="button" class="btn btn-info btn-sm btn_cair" rel="" onclick="bootbox.alert('STATUS : CAIR <br>SPM : <?=$value->str_nomor_trx_spm?> <br>SPP : <?=$value->str_nomor_trx?> <br>[ <a href=\'<?=$link?>\'>lihat</a> ]')" title="STATUS : CAIR"><i class="glyphicon glyphicon-file"></i></button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                    <button type="button" class="btn btn-danger btn-sm btn_batal" rel="" disabled="disabled" ><i class="glyphicon glyphicon-remove"></i></button>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                          <?php if($value->aktif == "1"):?>
                                                            <?php if(is_null($value->str_nomor_trx)):?>
                                                            <input type="checkbox" aria-label="" rel="<?=$value->id_kuitansi?>" class="ck_<?=$value->id_kuitansi?>">
                                                            <?php else: ?>
                                                            <input type="checkbox" checked="checked" aria-label="" rel="" disabled="disabled" class="">
                                                            <?php endif; ?>
                                                          
                                                          <?php else: ?>
                                                          <input type="checkbox" aria-label="" rel="" disabled="disabled" class="ck_<?=$value->id_kuitansi?>">
                                                          <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </td>
                    </tr>

    <?php 
			} 
        }

            ?>
                    <tr class="alert-warning" style="" >
                        <td colspan="5" class="text-right">
                            <b>Total :</b>
                        </td>
                        <td  class="text-right">
                            <b><?=number_format($tot_kuitansi, 0, ",", ".")?></b>
                        </td>
                        <td colspan="3" >
                        &nbsp;
                        </td>
                    </tr>
        <?php
		}else{
	?>
					<tr>
						<td colspan="9" class="text-center alert-warning">
						Tidak ada data
						</td>
					</tr>
	<?php
		}
	?>
					<tr>
						<td colspan="9" >&nbsp;</td>
					</tr>
                                        </tbody>
				</table>
                            <form action="<?php 
                    if($jenis == 'GP'){echo site_url('rsa_gup/create_spp_gup') ; }
                    else if($jenis == 'TP'){echo site_url('rsa_tup/create_spp_tup') ;}?>" id="form_usulkan_spp" method="post" style="display: none"  >
                                <input type="text" name="rel_kuitansi" id="rel_kuitansi" value="" />
                                <input type="text" name="rel_kuitansi_pengembalian" id="rel_kuitansi_pengembalian" value="" />
                                <input type="text" name="proses" id="proses" value="SPP-DRAFT" />
                            </form>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
			</div>
		</div>

		<!-- end content -->
	</div>
</div>

<div class="modal" id="myModalMessage" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i> Perhatian :</h4>
          </div>
          <div class="modal-body" style="margin:15px;padding:0px;padding-bottom: 15px;word-wrap: break-word;">
          	<form id="alasan_nolak">
          		<input type="hidden" name="id_sppls" id="id_sppls" value=""/>
          		<input type="hidden" name="proses" id="proses" value="0"/>
          		<div class="form-group">
          			<label for="alasan_tolak">Alasan Menolak SPP:</label>
          			<textarea class="form-control" name="alasan_tolak" id="alasan_tolak"></textarea>
          		</div>
          	</form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning tolak_mentah2"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> OK</button>
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
                            <td colspan="7" style="vertical-align: top;">Setuju dibebankan pada mata anggaran berkenaan, <br />
                                a.n. Kuasa Pengguna Anggaran <br />
                                <?php if($jenis== 'LK'): ?>
                                Pejabat Pembuat Komitmen (PPK)
                                <?php else: ?>
                                Pejabat Pelaksana dan Pengendali Kegiatan (PPPK)
                                <?php endif; ?>
                            </td>
                            <td colspan="4" style="vertical-align: top;">
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
                            <td colspan="7" style="border-bottom: 1px solid #000;vertical-align: bottom;"><span id="nmpppk">-</span><br>
                                    NIP. <span id="nippppk">-</span></td>
                            <td colspan="4" style="border-bottom: 1px solid #000;vertical-align: bottom;"><span class="edit_here" style="white-space: pre-line;" id="penerima_uang">-</span><br />
                                <span id="snip">NIP. <span class="edit_here" id="penerima_uang_nip">-</span></span>
                            </td>
			</tr>
                        <tr >
                            <td colspan="7">Setuju dibayar tgl : <br>
                                Bendahara Pengeluaran
                            </td>
                            <td colspan="4" ><span style="display: none" id="td_tglpumk">Lunas dibayar tgl : <br>
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
                             <td colspan="7"><span id="nmbendahara"></span><br>
                                 NIP. <span id="nipbendahara"></span>
                            </td>
                            <td colspan="4" ><span style="display: none" id="td_nmpumk"><span id="nmpumk"></span><br>
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
              <form action="<?=site_url('kuitansi/cetak_kuitansi')?>" id="form_kuitansi" method="post" style="display: none"  >
                    <input type="text" name="dtable" id="dtable" value="" />
                    <input type="text" name="nbukti" id="nbukti" value="" />
                    <input type="text" name="dunit" id="dunit" value="<?=$alias?>" />
                    <input type="text" name="dtahun" id="dtahun" value="<?=$cur_tahun?>" />
                </form>
          
            

          <div class="modal-footer">
            <!--<button type="button" class="btn btn-success" id="down" ><span class="glyphicon glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</button>-->
            <button type="button" class="btn btn-info" id="cetak" rel="" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
          </div>
        </div>
    </div>
</div>


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
                                <td colspan="7">Pejabat Pembuat Komitmen/ Pejabat Pelaksana dan Pengendali Kegiatan SUKPA <?=$nm_unit?></td>
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
            <button type="button" class="btn btn-info" id="cetak_showpengembalian" rel="" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
          </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal" id="myModalKonfirmKuitansi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                <p class="text-danger">Kuitansi telah diajukan SPP/SPM.</p>
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


<div class="modal " id="myModalKuitansiPengembalian" role="dialog" aria-labelledby="myModalKuitansiLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabelPengembalian">Kuitansi : <span id="kode_badge_pengembalian"><?=$jenis?></span></h4>
          </div>
          <div class="modal-body" style="margin:0px;padding:15px;background-color: #EEE;">
              <div id="div-cetak-pengembalian">
              <table class="table_print" id="kuitansi_pengembalian" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 800px;border: 1px solid #000;background-color: #FFF;" cellspacing="0px" border="0">
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
                                <td colspan="2" id="no_bukti_pengembalian">-</td>
                        </tr>
                        <tr class="tr_up">
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>

                                <td colspan="2">Anggaran</td>
                                <td style="text-align: center">:</td>
                                <td colspan="2" id="txt_akun_pengembalian">-</td>

            </tr>
            <tr>
                                <td colspan="11">&nbsp;

                </td>
                        </tr>
            <tr>
                <td colspan="11">
                                    <h4 style="text-align: center"><b>KUITANSI / BUKTI PENGEMBALIAN</b></h4>
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
                                <td colspan="7"><b>Rp. <span class="sum_tot_bruto_pengembalian">0</span>,-</b></td>
            </tr>
            <tr class="tr_up">
                <td colspan="3">Terbilang</td>
                <td>: </td>
                                <td colspan="7"><b><span class="text_tot_pengembalian">-</span></b></td>
            </tr>
            <tr class="tr_up">
                <td colspan="3">Untuk Pembayaran</td>
                <td>: </td>
                                <td colspan="7"><span id="uraian_pengembalian" >Pengembalian TUP</span></td> <!-- class="input_boot" style="cursor:pointer" --> <!--contenteditable="true" class="edit_here"-->
            </tr>
            <tr class="tr_up">
                <td colspan="3">Sub Kegiatan</td>
                <td>: </td>
                                <td colspan="7"><span id="nm_subkomponen_kuitansi_pengembalian">-</span></td>
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
                        <tr id="tr_isi_pengembalian">
                            <td colspan="11">[ <a href="#" rel="0" class="tambah_deskripsi" >tambah</a> ]</td>
            </tr>
<!--                        <tr>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td colspan="2"><b>Pajak ( Lump Sum ) </b></td>
                            <td >&nbsp;</td>
                            <td style="text-align: right"><b><span class="">&nbsp;</span></b></td>
                            <td class="row_pajak_lumpsum" style="padding: 0 5px 0 5px;">[<a data-toggle="modal" rel="" id="pilih_pajak_lumpsum" href="#myModalPajak">Edit</a>]</td>
                            <td style="text-align: right"><b><span class="sum_tot_pajak_lumpsum">0</span></b></td>
                            <td ><b><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">&nbsp;</span></b></td>
                            <td style="text-align: right"><b><span class="sum_tot_netto_lumpsum">&nbsp;</span></b></td>
            </tr>-->
                        <tr>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td ><b>Jumlah</b></td>
                            <td >&nbsp;</td>
                            <td style="text-align: right"><b><span class="sum_tot_bruto_pengembalian">0</span></b></td>
                            <td >&nbsp;</td>
                            <td style="text-align: right"><b><span class="sum_tot_pajak_pengembalian">0</span></b></td>
                            <td ><b><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></b></td>
                            <td style="text-align: right"><b><span class="sum_tot_netto_pengembalian">0</span></b></td>
            </tr>
                        <tr>
                                <td colspan="11">&nbsp;

                </td>
                        </tr>
            <tr>
                            <td colspan="7" style="vertical-align: top;">Setuju dibebankan pada mata anggaran berkenaan, <br />
                                a.n. Kuasa Pengguna Anggaran <br />
                                Pejabat Pelaksana dan Pengendali Kegiatan (PPPK)
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
                                <span class="edit_here" id="nmpppk_pengembalian" style="cursor:pointer"><?php // $pic_kuitansi['pppk_nm_lengkap']; ?>- edit here -</span><br>
                                    NIP. <span class="edit_here" id="nippppk_pengembalian" style="cursor:pointer"><?php // $pic_kuitansi['pppk_nip'] ; ?>- edit here -</span>
                                    </td>
                            <td colspan="4" style="border-bottom: 1px solid #000;vertical-align: bottom;"><span class="input_boot" style="cursor:pointer;white-space: pre-line;" id="penerima_uang_pengembalian">- edit here -</span><br />
                                NIP. <span class="input_boot" style="cursor:pointer" id="penerima_uang_nip_pengembalian">- edit here -</span>
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
                             <td colspan="11"><span id="nmbendahara_pengembalian"><?=$pic_kuitansi['bendahara_nm_lengkap']?></span><br>
                                 NIP. <span id="nipbendahara_pengembalian"><?=$pic_kuitansi['bendahara_nip']?></span>
                            </td>
                            <?php else: ?>
                            <td colspan="7"><span id="nmbendahara_pengembalian"><?=$pic_kuitansi['bendahara_nm_lengkap']?></span><br>
                                 NIP. <span id="nipbendahara_pengembalian"><?=$pic_kuitansi['bendahara_nip']?></span>
                            </td>
                            <td colspan="4"><span id="nmpumk_pengembalian"><?php echo isset($pumk->nm_lengkap)?$pumk->nm_lengkap:''; ?></span><br>
                                    NIP. <span id="nippumk_pengembalian"><?php echo isset($pumk->nomor_induk)?$pumk->nomor_induk:''; ?></span>
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
                            <td colspan="11" ><span class="input_boot" id="penerima_barang_pengembalian" style="cursor:pointer">- edit here -</span><br />
                                    NIP. <span class="input_boot" id="penerima_barang_nip_pengembalian" style="cursor:pointer">- edit here -</span>
                </td>
            </tr>

        </table>
              </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-submit-kuitansi-pengembalian" rel="" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Submit</button>
            <button type="button" class="btn btn-info" id="cetak_pengembalian" rel="" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
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
            <button type="button" class="btn btn-success" id="btn-pilih-pppk-ojo-dikopi-id-iki-yo-lek" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Pilih</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
          </div>
        </div>
    </div>
</div>


<!-- POP UP PILIH P3K -->
<div class="modal" id="myModalDeskripsi" tabindex="-1" role="dialog" aria-labelledby="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabelDeskripsi"">Konfirmasi</h4>
          </div>
          <div class="modal-body">
            <form id="form_deskripsi">
              <div class="form-group">
                <label for="">Deskripsi</label>
                <input type="text" class="form-control validate[required]" id="deskripsi" placeholder="">
              </div>
              <div class="form-group">
                <label for="">Kuantitas</label>
                <input type="text" class="form-control validate[required,min[1]] xnumber" id="kuantitas" placeholder="">
              </div>
              <div class="form-group">
                <label for="">Satuan</label>
                <input type="text" class="form-control validate[required]" id="satuan" placeholder="">
              </div>
              <div class="form-group">
                <label for="">Jumlah@</label>
                <input type="text" class="form-control validate[required,min[1]] xnumber" id="jumlah" placeholder="">
                <input type="hidden" id="iddeskripsi" value="">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-deskripsi" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Pilih</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
          </div>
        </div>
    </div>
</div>