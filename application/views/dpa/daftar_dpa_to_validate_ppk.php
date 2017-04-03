<script type="text/javascript">
$(document).ready(function(){

	$('#reset').click(function(){
		$('#form_dpa').validationEngine('hide');
                $("#div_sub_subunit").hide();
                $("#div_subunit").hide();
	});
        
        $('#sumber_dana').val("<?=$sumber_dana?>");
        
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
        window.location = "<?=site_url("dpa/daftar_validasi_rsa_ppk/")?>" + sumber_dana;
        
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
        
        window.location = "<?=site_url("tor/usulan_tor_to_validate_ppk/")?>" + unit_komponen_subkomponen + "/<?=$sumber_dana.'/'.$tahun?>"  ;
    
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
<form class="form-horizontal alert alert-warning col-sm-8" method="post" id="form_tor" action="<?php echo site_url('dpa/daftar_validasi_rsa_ppk/');?>">
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
	<div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="button" class="btn btn-primary" id="show"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search</button>
	      <button type="reset" class="btn btn-info" id="reset"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset</button>
	    </div>
	  </div>

			</form>
			<div id="temp" style="display:none"></div>
                        <div id="o-table">
                        <table class="table table-striped">
                            <thead>
                                <tr >
                                        <th class="col-md-3" >Program</th>
                                        <th class="col-md-3" >Kegiatan</th>
                                        <th class="col-md-3" >Sub Kegiatan</th>
                                        <th class="col-md-2" >&nbsp;</th>
                                        <th class="col-md-1" style="text-align:center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tb-isi" style="">
                                <?php $temp_text_program = ''; ?>
                                <?php $temp_text_komponen = ''; ?>
                                <?php $total_g = 0 ; ?>
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
                                        <?php if($u->jml_proses == 0){ ?>
                                        <td class="impor">
                                            usulan baru : <span class="badge"><?=$u->jml_proses?></span>
                                        </td>
                                        <?php }else{ ?>
                                        <td class="impor">
                                            usulan baru : <span class="badge badge-danger"><?=$u->jml_proses?></span>
                                        </td>
                                        <?php } ?>
                                        
                                        <!--<td style="text-align: right" class="rkat">&nbsp;</td>-->
                                        <!--<td style="text-align: right" class="rsa">&nbsp;</td>-->

                                        <td align="center">
                                            <buttton type="button" class="btn btn-warning tb-buat-tor" rel="<?=$u->kode_rka?><?php //u->k_unit.$u->kode_rka ; ?>" ><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</buttton>
                                        </td>
                                        
                                        
                                    </tr>

                                <?php } ?>
                                    <tr >
                                        <td colspan="5">&nbsp;</td>
                                    </tr>
                                    
                                <?php else: ?>
                                <tr id="tr-empty">
                                                <td colspan="5"> - kosong / belum ada usulan - </td>
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
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>


	
                        </div>

	    </div>
	  </div>
</div>
