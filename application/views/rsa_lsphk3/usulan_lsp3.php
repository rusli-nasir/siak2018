<script type="text/javascript">
$(document).ready(function(){
    
    autosize($('textarea'));

  // tambahan dari dhanu
  $('#lampJenisLSPeg').load('<?php echo site_url("tor/getOpsiJenisPeg"); ?>',{'id':$('#jenisLSPeg').val()});
  $('#lampStatusLSPeg').load('<?php echo site_url("tor/getOpsiStatusPeg"); ?>',{'id':$('#statusLSPeg').val()});
  $('.lampUnitLSPeg').load('<?php echo site_url("tor/getOpsiUnitPeg"); ?>',{'id':$('#unitLSPeg').val()});
  // cocok LS
  $('#cocokSPPLSPeg').on('submit',function(e){
      var id_rsa_detail = $('#btn-usulkan').attr('rel');
      var proses = $("input[name='proses']:checked").val();
      var data = $('#cocokSPPLSPeg').serialize()+"&id_rsa_detail=" + id_rsa_detail + "&proses=" + proses;
      $('#temp_cocockSPPLSPeg').val(data);
      // $('.message_sppls').load("<?php echo site_url('tor/checkSPPLSPegawai'); ?>",data);
      $.get("<?php echo site_url('tor/checkSPPLSPegawai'); ?>",data,function(r){
          if(r!='1'){
              $('#myModalMessage .message_sppls').html(r);
              // $('#myModalMessage .message_sppls2').show();
              // $('#btn-cocok-ls').show();
          }else{
               // jika sukses melakukan check nominal SPP dan daftar pegawai
              var id_rsa_detail = $('#btn-usulkan').attr('rel');
              var proses = $("input[name='proses']:checked").val();
              var data = "id_rsa_detail=" + id_rsa_detail + "&proses=" + proses;

              $.ajax({
                  type:"POST",
                  url :"<?=site_url("tor/proses_tor_rsa_detail")?>",
                  data:data,
                  success:function(data){
                      if(data == 'sukses'){
                          location.reload();
                      }
                  }
              });
          }
      });
      $('#myModalMessage .message_sppls').show();
      $('#myModalMessage .message_sppls2').hide();
      $('#myModalMessage .variabel-tambahan').html('');
      $('#btn-cocok-ls').hide();
      e.preventDefault();
  });
  $('#btn-cocok-ls').on('click',function(e){
      // alert('Terkirim');
      $('#cocokSPPLSPeg').submit();
      e.preventDefault();
  });
  $(document).on('click','#reprocess_check_splss_pegawai',function(e){
      var data = $('#temp_cocockSPPLSPeg').val()+'&aksi=reprocess';
      // $('.message_sppls').load("<?php echo site_url('tor/checkSPPLSPegawai'); ?>",data);
      $.get("<?php echo site_url('tor/checkSPPLSPegawai'); ?>",data,function(r){
          if(r!='1'){
              $('#myModalMessage .message_sppls').html(r);
              // $('#myModalMessage .message_sppls2').show();
              // $('#btn-cocok-ls').show();
          }else{
               // jika sukses melakukan check nominal SPP dan daftar pegawai
              var id_rsa_detail = $('#btn-usulkan').attr('rel');
              var proses = $("input[name='proses']:checked").val();
              var data = "id_rsa_detail=" + id_rsa_detail + "&proses=" + proses;

              $.ajax({
                  type:"POST",
                  url :"<?=site_url("tor/proses_tor_rsa_detail")?>",
                  data:data,
                  success:function(data){
                      if(data == 'sukses'){
                          location.reload();
                      }
                  }
              });
          }
      });
      e.preventDefault();
  });
  $('#jenisLSPeg').on('change',function(e){
    var anu = 'jenisLSPeg='+$(this).val();
    // alert(anu); return false;
    $.ajax({
      type:"POST",
      url :"<?=site_url("tor/proses_lspeg_var")?>",
      data:anu,
      success:function(data){
        $('#myModalMessage .variabel-tambahan').html(data);
      }
    });
  });
  // end here

        $('#backi').click(function(){
            window.location = "<?=site_url("dpa/daftar_dpa/").$sumber_dana?>";
        });

        $(document).on("click",'[id^="proses_"]',function(){
            var id_rsa_detail = $(this).attr('rel');
//            var kode_usulan_belanja = kode_usulan_belanja_kode_akun_tambah.substr(0, 24);
//            var kode_akun_tambah = kode_usulan_belanja_kode_akun_tambah.substr(24, 3);
//            console.log(kode_usulan_belanja + ' - ' + kode_akun_tambah);
            $('[class^="rdo_"]').each(function(){
                $(this).prop('checked',false);
    //                        $(this).attr('readonly','readonly');
    //                         console.log($(this).attr('rel'));
            });
            $('#btn-usulkan').attr('rel',id_rsa_detail);
            $('#myModalCair').modal('show');

            return false;

        });

        $(document).on("click",'#btn-usulkan',function(){
            // if(false){
            // tambahan dhanu
            var n = $("input[name='proses']:checked").length;
            if(n<=0){
                $('#myModalMsg .body-msg-text').html('<p class="alert alert-warning">Pilih salah satu untuk melanjutkan proses.</p>');
                $('#myModalMsg').modal('show');
                return false;
            }
            // end here

                var id_rsa_detail = $(this).attr('rel');
                var proses = $("input[name='proses']:checked").val();
                var data = "id_rsa_detail=" + id_rsa_detail + "&proses=" + proses;

                // tambahan dari dhanu
                if(proses=='12'){
                    $('#cocokSPPLSPeg')[0].reset();
                    $('#myModalMessage .message_sppls').hide();
                    $('#myModalMessage .message_sppls2').show();
                    $('#myModalMessage').modal('show');
                    $('#btn-cocok-ls').show();
                    return false;
                }
                // end tambahan dari dhanu

                $.ajax({
                    type:"POST",
                    url :"<?=site_url("tor/proses_tor_rsa_detail")?>",
                    data:data,
                    success:function(data){
                            // $("#subunit").html(respon);
//                            console.log(data);
                            //$('#row_space').html(respon);
                                if(data == 'sukses'){
                                    location.reload();

                               }
                    }
                });

            // }
            // else{
                $('#myModalCair').modal('show');
            // }
            return false;
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

        $('#row_space').load('<?php echo site_url('tor/refresh_row_detail').'/'.$kode.'/'.$sumber_dana;?>', function(){
            $('#' + rel).load('<?php echo site_url('tor/form_edit_detail');?>/' + rel,function(){autosize($('textarea'));});
            $('#' + rel).addClass('alert-success') ;
            $('#form_add_detail_' + kode).hide();

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
                if(isNaN(parseInt($('#volume_edit').val()))){var vol	= 0;}else{var vol	= parseInt($('#volume_edit').val());}
                if(isNaN(parseInt($('#tarif_edit').val()))){var tarif	= 0;}else{var tarif	= parseInt($('#tarif_edit').val());}

                if(vol.length==0){ vol = 0;}
                if(tarif.length==0){ tarif = 0;}
                if(isNaN(vol*tarif)){ var hasil	= 0;}else{ var hasil	= vol*tarif; }
                $('#jumlah_edit').val(hasil);
        }
        else{
                if(isNaN(parseInt($('#volume_' + kode_usulan_belanja).val()))){var vol	= 0;}else{var vol	= parseInt($('#volume_' + kode_usulan_belanja).val());}
                if(isNaN(parseInt($('#tarif_' + kode_usulan_belanja).val()))){var tarif	= 0;}else{var tarif	= parseInt($('#tarif_' + kode_usulan_belanja).val());}

                if(vol.length==0){ vol = 0;}
                if(tarif.length==0){ tarif = 0;}
                if(isNaN(vol*tarif)){ var hasil	= 0;}else{ var hasil	= vol*tarif; }
                $('#jumlah_' + kode_usulan_belanja).val(hasil);
        }
}

function canceledit(kode){
    $('#row_space').load('<?php echo site_url('tor/refresh_row_detail').'/'.$kode.'/'.$sumber_dana;?>', function(){
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


</script>
<?php
$tgl=getdate();
$cur_tahun=$tgl['year']+1;
?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>DETAIL SUB KEGIATAN KONTRAK LS P3</h2>
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
	<td><span id="kode_subkomponen"><?=$tor_usul->kode_subkomponen?></span> - <?=$tor_usul->nama_subkomponen?></td>
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

                                    <?php foreach($detail_rsa as $ul){ ?>
                                        <?php $impor = $ul->impor; ?>
                                        <?php if($ul->kode_usulan_belanja == $u->kode_usulan_belanja): ?>
                                            <tr id="<?php echo $ul->id_rsa_detail ;?>" height="25px">
                                                <td style="text-align: right">
                                                    <?php if(substr($ul->proses,1,1)=='1'){echo '<span class="badge badge-gup">GP</span>';}elseif(substr($ul->proses,1,1)=='3'){echo '<span class="badge badge-tup">TP</span>';}elseif(substr($ul->proses,1,1)=='2'){echo '<span class="badge badge-lp">LP</span>';}elseif(substr($ul->proses,1,1)=='4'){echo '<span class="badge badge-l3">L3</span>';}elseif(substr($ul->proses,1,1)=='5'){echo '<span class="badge badge-ks">KS</span>';}else{} ?> <?=$ul->kode_akun_tambah?>
                                                </td>
                                                <td ><?=$ul->deskripsi?></td>
                                                <td ><?=$ul->volume?></td>
                                                <td ><?=$ul->satuan?></td>
                                                <td style="text-align: right"><?=number_format($ul->harga_satuan, 0, ",", ".")?></td>
                                                <td style="text-align: right">
                                                    <?php $total_ = $total_ + ($ul->volume*$ul->harga_satuan); ?>
                                                    <?php $total_per_akun = $total_per_akun + ($ul->volume*$ul->harga_satuan); ?>
                                                    <?=number_format($ul->volume*$ul->harga_satuan, 0, ",", ".")?>
                                                </td>


                                                <?php if($ul->proses == 0) : ?>

                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-default btn-sm" onclick="doedit('<?php echo $ul->id_rsa_detail ;?>','<?php echo $ul->kode_usulan_belanja ;?>',this)" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $ul->id_rsa_detail;?>" class="btn btn-default btn-sm" id="delete_<?=$ul->id_rsa_detail?>" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm" rel="<?php echo $ul->id_rsa_detail ;?>" id="proses_<?php echo $ul->id_rsa_detail ;?>" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Proses</button>
                                                </td>
                                                <?php elseif(substr($ul->proses,0,1) == 1): ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Wait  &nbsp;</button>
                                                </td>
                                                <?php elseif(substr($ul->proses,0,1) == 2): ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Wait  &nbsp;</button>
                                                </td>
                                                <?php elseif(substr($ul->proses,0,1) == 3): ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Done  &nbsp;</button>
                                                </td>
                                                <?php else: ?>
                                                <td align="center">
                                                    <!--<buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$ul->kode_usulan_belanja?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span></buttton>-->
                                                    <div class="btn-group">
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                                        <button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Proses</button>
                                                </td>
                                                <?php endif; ?>
                                            </tr>

                                        <?php endif; ?>
                                    <?php } ?>
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
                                                                    <button style="padding-left:5px;padding-right:5px;" type="button" class="btn btn-default btn-sm" rel="<?=$u->kode_usulan_belanja?>" id="tambah_<?=$u->kode_usulan_belanja?>" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                                                                    <button style="padding-left:5px;padding-right:5px;" type="button" class="btn btn-default btn-sm" rel="<?=$u->kode_usulan_belanja?>" id="reset_<?=$u->kode_usulan_belanja?>" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>


                                                            </div>
                                            </td>
                                            <td>&nbsp;</td>
                                    </tr>
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

<!-- POP UP PILIH PENCAIRAN -->
<div class="modal" id="myModalCair" tabindex="-1" role="dialog" aria-labelledby="myModalCairLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
            <label for="exampleInputEmail1">Pilih Mekanisme Pencairan ?</label>
            <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <input type="radio" aria-label="" rel="" class="rdo_up" name="proses" value="11">
                    </span>
                      <input type="text" class="form-control" aria-label="" value="GUP" readonly="readonly">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <input type="radio" aria-label="" rel="" class="rdo_up" name="proses" value="12">
                    </span>
                      <input type="text" class="form-control" aria-label="" value="LS-PEGAWAI" readonly="readonly">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div>
            <div class="row">
                <div class="col-lg-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <input type="radio" aria-label="" rel="" class="rdo_ls" name="proses" value="13">
                    </span>
                      <input type="text" class="form-control" aria-label="" value="TUP" readonly="readonly">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <input type="radio" aria-label="" rel="" class="rdo_ls" name="proses" value="14">
                    </span>
                      <input type="text" class="form-control" aria-label="" value="LS-PIHAK-3" readonly="readonly">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div>
            <div class="row">
                <div class="col-lg-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <input type="radio" aria-label="" rel="" class="rdo_ls" name="proses" value="15">
                    </span>
                      <input type="text" class="form-control" aria-label="" value="KERJA-SAMA" readonly="readonly">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-usulkan" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Usulkan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
          </div>
        </div>
    </div>
</div>

<!-- tambahan dari dhanu -->
<div class="modal" id="myModalMessage" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i> Pencocokan Lampiran LS Pegawai:</h4>
          </div>
        <form id="cocokSPPLSPeg">
          <input type="hidden" name="temp_cocockSPPLSPeg" id="temp_cocockSPPLSPeg" value="" />
          <div class="modal-body message_sppls" style="margin:15px;padding:0px;padding-bottom: 15px;word-wrap: break-word;"></div>
          <div class="modal-body message_sppls2" style="margin:15px;padding:0px;padding-bottom: 15px;word-wrap: break-word;">
            <div class="row">
              <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
                <div class="form-group" style="vertical-align: top;">
                  <label for="jenisLSPeg" class="control-label col-md-3 small">Jenis LS-Pegawai:</label>
                  <div class="col-md-9">
                    <select name="jenisLSPeg" id="jenisLSPeg" class="form-control input-sm">
                      <?php
                        $array = array(''=>'pilih salah satu','ikw'=>'Insentif Kinerja Wajib','ipp'=>'Insentif Perbaikan Penghasilan');
                        foreach ($array as $k => $v) {
                            echo "<option value=\"".$k."\">".$v."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
                <div class="form-group variabel-tambahan">
                  &nbsp;ini untuk percontohan&nbsp;
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
                  <div class="form-group">
                      <label for="lampJenisLSPeg" class="control-label col-md-3 small">Jenis Pegawai:</label>
                      <div class="col-md-9">
                        <select name="lampJenisLSPeg" id="lampJenisLSPeg" class="form-control input-sm">
                          <option></option>
                        </select>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
                <div class="form-group">
                  <label for="lampStatusLSPeg" class="control-label col-md-3 small">Status Pegawai:</label>
                  <div class="col-md-9">
                    <select name="lampStatusLSPeg" id="lampStatusLSPeg" class="form-control input-sm">
                      <option></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="lampUnitLSPeg" class="small">Unit Pegawai:</label>
              <div class="lampUnitLSPeg" style="overflow-x:hidden;overflow-y: scroll;max-height:250px;"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-cocok-ls" rel="" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> !Cocokkan Total Sumber Dana!</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Tutup</button>
          </div>
        </form>
        </div>
    </div>
</div>
<!-- end here -->
