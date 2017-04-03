<script type="text/javascript">
$(document).ready(function(){

        $('.kode_usulan_belanja').each(function(){
                    var rel = $(this).attr('rel') ;
                    // setTimeout(function() {
                        $.ajax({
                          type:"POST",
                          url :"<?php echo site_url("dpa/get_nama_sub_subunit"); ?>/" + rel,
                          success:function(data1){
                                $('.nama_' + rel).text(data1);
                          }
                        });
                    // },100);
        });


    $("#dl_xls").click(function(){
        var uri = $("#tbl-kroscek").excelexportjs({
                                    containerid: "tbl-kroscek"
                                    , datatype: "table"
                                    , returnUri: true
                                });


        var blob = b64toBlob(uri, "application/vnd.ms-excel;charset=charset=utf-8");
        
        saveAs(blob, 'download_tbl_kroscek.xls');

    });

    $(document).on("click","#show",function(){
        if($("#form_tor").validationEngine("validate")){
            // $('#tb-empty').hide(function(){
            //         $('#tb-isi').show(function(){
            //             get_unit_dpa();
            //         });
            //     });
            
                var total_rba = 0 ;
                var total_rsa = 0 ;
                var total_selisih = 0 ;
                
                $('.kode_usulan_belanja').each(function(){
                    var rel = $(this).attr('rel') ;
                    // setInterval(function() {
                    
                    // $.ajax({
                    //       type:"POST",
                    //       url :"<?php echo site_url("dpa/get_nama_sub_subunit"); ?>/" + rel,
                    //       success:function(data1){
                    //             $('.nama_' + rel).text(data1);
                                $.ajax({
                                  type:"POST",
                                  url :"<?php echo site_url("dpa/get_rba"); ?>/" + rel + '/' + $("#sumber_dana").val() + "/" + $("#tahun").val(),
                                  success:function(data2){
                                        $('.rba_' + rel).text(angka_to_string(data2));
                                        total_rba = parseInt(total_rba) + parseInt(data2) ;
                                        $.ajax({
                                          type:"POST",
                                          url :"<?php echo site_url("dpa/get_rsa"); ?>/" + rel + '/' + $("#sumber_dana").val() + "/" + $("#tahun").val(),
                                          success:function(data3){
                                                $('.rsa_' + rel).text(angka_to_string(data3));
                                                total_rsa = parseInt(total_rsa) + parseInt(data3) ;
                                                var rba =  string_to_angka($('.rba_' + rel).text());
                                                var rsa =  string_to_angka($('.rsa_' + rel).text());
                                                var selisih = angka_to_string(parseInt(rba) - parseInt(rsa)) ;
                                                if((parseInt(rba) - parseInt(rsa)) < 0 ){
                                                    $('.tr_' + rel ).addClass('danger');
                                                    $('.r_' + rel ).html('<span class="badge badge-danger">ERR</span>');
                                                }
                                                $('.selisih_' + rel).text(selisih);
                                                total_selisih = parseInt(total_selisih) + parseInt(parseInt(rba) - parseInt(rsa)) ;

                                                $('#total_rba').text(angka_to_string(total_rba));
                                                $('#total_rsa').text(angka_to_string(total_rsa));
                                                $('#total_selisih').text(angka_to_string(total_selisih));
                                          }
                                        });
                                  }
                                });
                                
                        //   }
                        // });

                    // $.ajax({
                    //       type:"POST",
                    //       url :"<?php echo site_url("dpa/get_rba"); ?>/" + rel,
                    //       success:function(data){
                    //             $('.rba_' + rel).text(string_to_angka(data));
                    //       }
                    //     });

                    // $.ajax({
                    //       type:"POST",
                    //       url :"<?php echo site_url("dpa/get_rsa"); ?>/" + rel,
                    //       success:function(data){
                    //             $('.rsa_' + rel).text(angka_to_string(data));
                    //       }
                    //     });

                    // }, 1000);
                });

                // $('#o-table').show();
     
        }
        
        
    });
        
});

function b64toBlob(b64Data, contentType, sliceSize){
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


function string_to_angka(str){

    
    return str.split('.').join("");
    
}

function angka_to_string(num){

    var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    return str_hasil;
}

function refresh_row(){

    // $("#row_space").load("<?=site_url('tor/get_row')?>");
        
}


</script>
<?php
//$tgl=getdate();
//$cur_tahun=$tgl['year']+1;
?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>KROSCEK</h2>    
                    </div>
                </div>
                <hr />
                <div class="row">  
                    <div class="col-lg-12">

<form class="form-horizontal alert alert-warning col-sm-8" method="post" id="form_tor" action="<?php echo site_url('tor/daftar_tor');?>">
     <div class="form-group"  >
            <label for="input1" class="col-md-4 control-label">Tahun</label>
            <div class="col-md-8">
                        <?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'validate[required] form-control','id'=>'tahun'))?>
                                    
            </div>
        </div>
                <div class="form-group"  >
            <label for="input1" class="col-md-4 control-label">Sumber Dana</label>
            <div class="col-md-8">
                <select name="sumber_dana" id="sumber_dana" class="validate[required] form-control">
                  <option value="">-pilih-</option>
                  <option value="SELAIN-APBN">SELAIN APBN</option>
                  <option value="APBN-BPPTNBH">APBN (BPPTNBH)</option>
                  <option value="APBN-LAINNYA">SPI - SILPA - PINJAMAN</option>
                </select>
            </div>
        </div>
    <!--
                <div id="div_unit">
        <div class="form-group" >
                <label for="" class="col-md-4 control-label">Unit</label>
                <div class="col-md-8">
                  <select name="unit" id="unit" class="validate[required] form-control">
                      <option value="">-pilih-</option>
                    </select>
                </div>
              </div>
        </div>
    -->
    <!--
        <div id="div_subunit" style="display:none">
        <div class="form-group" >
                <label for="" class="col-md-4 control-label">SubUnit</label>
                <div class="col-md-8">
                  <select name="subunit" id="subunit" class="validate[required] form-control">
                      <option value="">-pilih-</option>
                    </select>
                </div>
                            </div>
        </div>
        <div id="div_sub_subunit" style="display:none">
        <div class="form-group" >
                <label for="" class="col-md-4 control-label">Sub SubUnit</label>
                <div class="col-md-8">
                  <select name="sub_subunit" id="sub_subunit" class="validate[required] form-control">
                      <option value="">-pilih-</option>
                    </select>
                </div>
                            </div>
        </div>
    -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="button" class="btn btn-primary" id="show"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search</button>
          <button type="reset" class="btn btn-info" id="reset"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset</button>
        </div>
      </div>

            </form>
                    
            <div id="temp" style="display:none"></div>
                        <div id="o-table">
                        <table class="table table-striped" id="tbl-kroscek" >
    <thead>
    <tr >
        <th class="col-md-3" >UNIT</th>
        <th class="col-md-2" >KODE</th>
        <th class="col-md-2" >RBA</th>
        <th class="col-md-2" >RSA</th>
        <th class="col-md-2" >SISA</th>
        <th class="col-md-1" >STATUS</th>
    </tr>
        </thead>
        <tbody id="row_space">

<?php if(!empty($akun_kroscek)): ?>
<?php foreach($akun_kroscek as $row){ ?>
<tr id="" class="tr_<?=$row?>" height="25px">
    <td class="nama_<?=$row?>">&nbsp;</td>
    <td class="kode_usulan_belanja" rel="<?=$row?>" style='mso-number-format:"\@";'><?=$row?></td>
    <td class="rba_<?=$row?>" style='text-align: right;mso-number-format:"\@";'>&nbsp;</td>
    <td class="rsa_<?=$row?>" style='text-align: right;mso-number-format:"\@";'>&nbsp;</td>
    <td class="selisih_<?=$row?>" style='text-align: right;mso-number-format:"\@";'>&nbsp;</td>
    <td class="r_<?=$row?>" style="text-align:right">&nbsp;</td>
</tr>
<?php };?>
<tr >
    <td colspan="6">&nbsp;</td>
</tr>

<tr id="" height="25px" class="alert alert-danger" style="font-weight: bold">
    <td colspan="2" style="text-align: center">Total </td>
    <td style='text-align: right;mso-number-format:"\@";'>: <span id="total_rba">&nbsp;</span><?php // number_format($total_g, 0, ",", "."); ?></td>
    <td style='text-align: right;mso-number-format:"\@";'><span id="total_rsa">&nbsp;</span></td>
    <td style='text-align: right;mso-number-format:"\@";'><span id="total_selisih">&nbsp;</span></td>
    <td style="">&nbsp;</td>
</tr>

<?php else: ?>
<tr id="tr-empty">
                <td colspan="6"> - kosong -</td>
</tr>
<?php endif; ?>

</tbody>
    
        <tfoot>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
        </tfoot>
</table>

<div class="alert alert-warning" style="text-align:center" >
    <button type="button" class="btn btn-success" id="dl_xls"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Unduh .xls</button>
</div>
                        </div>


    
                        </div>

        </div>
      </div>
</div>



