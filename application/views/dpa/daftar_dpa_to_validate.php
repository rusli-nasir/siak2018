<script type="text/javascript">
$(document).ready(function(){

	$('#reset').click(function(){
		$('#form_dpa').validationEngine('hide');
                $("#div_sub_subunit").hide();
                $("#div_subunit").hide();
	});
        
        $('#sumber_dana').val("<?=$sumber_dana?>");

        $('#txt_rkat').text($('#tot_rkat_txt').text()); 
    $('#txt_rsa').text($('#tot_rsa_txt').text()); 


    var jml_usulan_baru = 0 ;


    $('.ada_usulan').each(function(){
        var i = $(this).text() ; 

        jml_usulan_baru = jml_usulan_baru + parseInt(i.trim()) ;
    });


    $('#jml_dpa_baru').text(jml_usulan_baru);
        
});

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

$(document).on("click","#show",function(){
    if($("#form_dpa").validationEngine("validate")){
        var sumber_dana = $('#sumber_dana').val();
        window.location = "<?=site_url("dpa/daftar_dpa")?>/" + sumber_dana;
        
//        $('#tb-empty').hide(function(){
//                $('#tb-isi').show(function(){
                    get_unit_dpa();
                    
//                });
//            });
        
 
    }
    
    
});

function get_unit_dpa(){
//    $('[class="tr-unit"]').each(function(){
//        
//        var el = $(this); 
//
//        el.find('td.impor').load("<?php echo site_url('dpa/get_impor_number_unit'); ?>/"+$(this).attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
//        el.find('td.rkat').load("<?php echo site_url(); ?>/dpa/get_impor_rkat_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
//        el.find('td.rsa').load("<?php echo site_url(); ?>/dpa/get_impor_rsa_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
//              
//            
//    });
    var sumber_dana = $('#sumber_dana').val();
    var tahun = $('#tahun').val();
    $('#tb-isi').load("<?php echo site_url('dpa/tabel_dpa'); ?>/"+ sumber_dana +"/"+ tahun);
}

$(document).on("click",".tb-buat-tor",function(){
    var unit_komponen_subkomponen = $(this).attr('rel');
//    var sumber_dana = $('#sumber_dana').val();
//    var tahun = $('#tahun').val();
    
//    var rkat = $(this).parent().parent().find('td.rkat').html();
    
//    if(rkat != '0'){
        
        window.location = "<?=site_url("tor/usulan_tor_to_validate/")?>" + unit_komponen_subkomponen + "/<?=$sumber_dana.'/'.$tahun."/".$unit?>"   ;
    
//        if(confirm('Apakah anda yakin, impor unit : '+ unit_komponen_subkomponen +' ?')){

//            $.ajax({
//                    type:"POST",
//                    url :"<?=site_url("dpa/post_impor_unit")?>",
//                    data:'unit=' + unit +'&sumber_dana='+ sumber_dana +'&tahun='+tahun,
//                    success:function(respon){
    //                        $("#subunit").html(respon);
//                        if(respon == 'sukses'){
//                            get_unit_dpa()
//                        }
//                    }
//            });
//        }
//    }
//    else{
//        alert('Maaf, nilai RKAT tidak boleh kosong !');
//    }
});

        
 


</script>
<?php
$tgl=getdate();
$cur_tahun=$tgl['year']+1;
?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>DAFTAR USULAN DPA</h2>    
                    </div>
                </div>
                <hr />
                <div class="row">  
                    <div class="col-lg-12">

                        <div class="row" style="margin: 0">    
                    <div class="col-md-6 ">
                        <ul class="list-group" style="margin:0 0 5px;">
                            <li class="list-group-item" style="background: #EEE;">
                                <div class="row" style="margin: 0">
                                                                        <div class="col-md-4"><b>UNIT</b></div><div class="col-md-8">: <span class="text-danger"><b><?=$nama_unit?></b></span></div> 
                                                                    </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row" style="margin: 0">
                                                                        <div class="col-md-4"><b>DPA baru</b></div><div class="col-md-8">: <span class="text-danger"><b><span id="jml_dpa_baru">0</span></b></span></div> 
                                                                    </div>
                            </li>
                        </ul>
                    </div>
                                        <div class="col-md-6">
                    <ul class="list-group" style="margin:0 0 5px;">
                            <li class="list-group-item">
                                <div class="row" style="margin: 0">
                                    <div class="col-md-4"><b>RKAT</b></div><div class="col-md-8">: <span class="text-danger" ><b id="txt_rkat">0</b></span></div> 
                                                                    </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row" style="margin: 0">
                                    <div class="col-md-4"><b>RSA</b></div><div class="col-md-8">: <span class="text-danger" ><b id="txt_rsa">0</b></span></div> 
                                </div>
                            </li>
                        </ul>
                    </div>
<!--                    <div class="col-md-6">
                        <div class="panel panel-danger" style="margin-bottom: 0;">
                            <div class="panel-heading">
                              <h3 class="panel-title">UP TERSEDIA</h3>
                            </div>
                            <div class="panel-body">
                                <h3 style="margin: 0"><span class="text-danger">Rp. <span id="saldo_kas">1.974.768</span>,-</span></h3>
                            </div>
                        </div>
                    </div>-->
                                                        </div>

                                                        <br>

			<div id="temp" style="display:none"></div>
                        <div id="o-table">
                        <table class="table table-striped">
                            <thead>
                                <tr >
                                        <th class="col-md-3" >IKU</th>
                                        <th class="col-md-3" >Kegiatan</th>
                                        <th class="col-md-3" >Sub Kegiatan</th>
                                        <th class="col-md-1" >RKAT</th>
                                        <th class="col-md-1" >RSA</th>
                                        <th class="col-md-1" style="text-align:center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tb-isi" style="">
                                <?php $temp_text_program = ''; ?>
                                <?php $temp_text_komponen = ''; ?>
                                <?php $total_g = 0 ; ?>
                                <?php $total_h = 0 ; ?>
                                <?php if(!empty($rsa_usul_to_validate)): ?>
                                <?php foreach($rsa_usul_to_validate as $i => $u){ ?>
                                    <tr rel="<?=$u->k_unit.$u->kode_rka?>" class="tr-unit" height="25px">
                                        <?php if($temp_text_program != $u->nama_program): ?>
                                            <td class=""><b><?=$u->nama_program?></b></td>
                                            <?php $temp_text_program = $u->nama_program; ?>
                                        <?php else: ?>
                                            <td class="">&nbsp;</td>
                                        <?php endif; ?>
                                        <?php if($temp_text_komponen != $u->nama_komponen): ?>
                                            <td class=""><b><?=$u->nama_komponen?></b></td>
                                            <?php $temp_text_komponen = $u->nama_komponen; ?>
                                        <?php else: ?>
                                            <td class="">&nbsp;</td>
                                        <?php endif; ?>
                                        <td class=""><?=$u->nama_subkomponen?></td>
                                        <!--
                                        <?php if($u->jml_proses == 0){ ?>
                                        <td class="impor">
                                            usulan baru : <span class="badge"><?=$u->jml_proses?></span>
                                        </td>
                                        <?php }else{ ?>
                                        <td class="impor">
                                            usulan baru : <span class="badge badge-danger"><?=$u->jml_proses?></span>
                                        </td>
                                        <?php } ?>
                                        -->
                                        <td class="" style="text-align: right"><?=number_format($u->jumlah_tot, 0, ",", ".")?><?php $total_g = $total_g + $u->jumlah_tot; ?></td>
                                        <td class="" style="text-align: right"><?=number_format($u->jumlah_rsa, 0, ",", ".")?><?php $total_h = $total_h + $u->jumlah_rsa; ?></td>

                                        <td align="center">
                                            <?php if($u->jml_proses > 0){ ?>
                                            <buttton type="button" class="btn btn-danger btn-sm tb-buat-tor ada_usulan" rel="<?=$u->kode_rka?><?php // $u->k_unit.$u->kode_rka; ?>" > <?=$u->jml_proses?> </buttton>
                                            <?php }else{ ?>

                                                <buttton type="button" class="btn btn-default btn-sm tb-buat-tor" rel="<?=$u->kode_rka?><?php // $u->k_unit.$u->kode_rka; ?>" > - </buttton>

                                            <?php } ?>
                                            <!-- <buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$u->kode_rka?><?php //u->k_unit.$u->kode_rka ; ?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</buttton> -->
                                        </td>
                                        
                                        
                                    </tr>

                                <?php } ?>
                                    <tr >
                                        <td colspan="6">&nbsp;</td>
                                    </tr>
                                    <tr id="" height="25px" class="alert alert-danger" style="font-weight: bold">
                                        <td colspan="2" style="text-align: center">Total </td>
                                        <td style="text-align: right">:</td>
                                        <td style="text-align: right" id="tot_rkat_txt"><?=number_format($total_g, 0, ",", ".")?></td>
                                        <td style="text-align: right" id="tot_rsa_txt"><?=number_format($total_h, 0, ",", ".")?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    
                                <?php else: ?>
                                <tr id="tr-empty">
                                                <td colspan="6"> - kosong / belum ada usulan - </td>
                                </tr>
                                <?php endif; ?>
                                
                            </tbody>
<!--                            <tbody id="tb-empty">
                                <tr id="tr-empty">
                                    <td colspan="4"> - kosong -</td>
                                </tr>
                            </tbody>-->
                            <tfoot>
                                <tr>
                                    <td colspan="6">&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>


	
                        </div>

	    </div>
	  </div>
</div>
