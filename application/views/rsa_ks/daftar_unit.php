<script type="text/javascript">
$(document).ready(function(){
	
//	$.ajax({
//                type:"POST",
//                url :"<?=site_url("tor/get_unit")?>",
//                data:'kode_unit=' + <?=$_SESSION['rsa_kode_unit_subunit']?>,
//                success:function(respon){
//                        $("#unit").html(respon);
//
//                }
//        });

	$('#reset').click(function(){
		$('#form_tor').validationEngine('hide');
                $("#div_sub_subunit").hide();
                $("#div_subunit").hide();
	});
        
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
    if($("#form_").validationEngine("validate")){
        window.location = "<?=site_url('rsa_up/daftar_unit/')?>" + $('#tahun').val();
        
 
    }
    
    
});

function get_unit_dpa(){
    $('[class="tr-unit"]').each(function(){
        
        var el = $(this); 

        // el.find('td.impor').load("<?php echo site_url('dpa/get_impor_number_unit'); ?>/"+$(this).attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
        // el.find('td.rkat').load("<?php echo site_url(); ?>/dpa/get_impor_rkat_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
        el.find('td.proses').load("<?php echo site_url('dpa/get_proses_number_to_validate'); ?>/"+$(this).attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
        el.find('td.rsa').load("<?php echo site_url(); ?>/dpa/get_impor_rsa_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
        el.find('td.dpa').load("<?php echo site_url(); ?>/dpa/get_impor_dpa_unit/"+el.attr('rel')+"/"+$("#sumber_dana").val()+"/"+$("#tahun").val());
              
            
    });
}

$(document).on("click",".tb-lihat",function(){
    var unit = $(this).attr('rel');
//    var sumber_dana = $('#sumber_dana').val();
    var tahun = $('#tahun').val();
    
    window.location = "<?=site_url("rsa_up/spm_up_verifikator/")?>" + unit + '/' + tahun; 
    
});


</script>
<?php
//$tgl=getdate();
//$cur_tahun=$tgl['year']+1;
?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>DAFTAR UNIT</h2>    
                    </div>
                </div>
                <hr />
                <div class="row">  
                    <div class="col-lg-12">
                        
    <form class="form-horizontal alert alert-warning col-sm-8" method="post" id="form_tor" action="<?php echo site_url('rsa_up/daftar_unit');?>">
	 <div class="form-group"  >
			<label for="input1" class="col-md-4 control-label">Tahun</label>
			<div class="col-md-8">
                        <?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'validate[required] form-control','id'=>'tahun'))?>
                                    
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
                                        <th class="col-md-1" >Kode</th>
                                        <th class="col-md-5" >Unit</th>
                                        <th class="col-md-2" >SPP / SPM</th>
                                        <th class="col-md-2" >TGL PROSES</th>
                                        <th class="col-md-2" style="text-align:center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tb-isi" >
                                <?php foreach($unit_usul as $i => $u){ ?>
                                    <?php if(($u->kode_unit == '41')||($u->kode_unit == '42')||($u->kode_unit == '43')||($u->kode_unit == '44')): ?>
                                    <tr rel="<?=$u->kode_unit?>" class="tr-unit" height="25px">
                                        <td class=""><b><?=$u->kode_unit?></b></td>
                                        <td class="text-danger"><b><?=$u->nama_unit?></b></td>
                                        <td class="">&nbsp;</td>
                                        <td style="">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                    </tr>
                                        <?php foreach($subunit_usul as $ii => $uu){ ?>
                                        <?php if(substr($uu->kode_subunit,0,2) == $u->kode_unit): ?>
                                        <tr rel="<?=$uu->kode_subunit?>" class="tr-unit warning" height="25px">
                                            <td class="" style="padding-left: 30px"><b><?=$uu->kode_subunit?></b></td>
                                            <td class="text-danger" style="padding-left: 30px"><b><?=$uu->nama_subunit?></b></td>
                                            <td class=""><?=$uu->posisi?></td>
                                            <td style=""><?php setlocale(LC_ALL, 'id_ID.utf8'); echo empty($uu->tgl_proses)?'':strftime("%d %B %Y", strtotime($uu->tgl_proses)); ?></td>
                                            <td align="center">
                                                <?php if($uu->posisi=='SPM-DRAFT-KPA'): ?>
                                                <button class="btn btn-success tb-lihat" rel="<?=$uu->kode_subunit?>"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</button>
                                                <!--<a href="<?=site_url('rsa_up/spm_up_verifikator/').$uu->kode_subunit?>" class="btn btn-warning"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>-->
                                                <?php elseif(($uu->posisi=='SPM-FINAL-VERIFIKATOR')||($uu->posisi=='SPM-FINAL-KBUU')||($uu->posisi=='SPM-FINAL-BUU')): ?>
                                                <button class="btn btn-danger tb-lihat" rel="<?=$uu->kode_subunit?>"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</button>
                                                <!--<a href="<?=site_url('rsa_up/spm_up_verifikator/').$uu->kode_subunit?>" class="btn btn-warning"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>-->
                                                <?php else: ?>
                                                <button disabled="disabled" class="btn btn-warning"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php } ?>
                                    <?php else: ?>
                                    <tr rel="<?=$u->kode_unit?>" class="tr-unit" height="25px">
                                        <td class=""><b><?=$u->kode_unit?></b></td>
                                        <td class="text-danger"><b><?=$u->nama_unit?></b></td>
                                        <td class=""><?=$u->posisi?></td>
                                        <td style=""><?php setlocale(LC_ALL, 'id_ID.utf8'); echo empty($u->tgl_proses)?'':strftime("%d %B %Y", strtotime($u->tgl_proses)); ?></td>
                                        <td align="center">
                                            <?php if($u->posisi=='SPM-DRAFT-KPA'): ?>
                                            <button class="btn btn-success tb-lihat" rel="<?=$u->kode_unit?>"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</button>
                                            <!--<a href="<?=site_url('rsa_up/spm_up_verifikator/').$u->kode_unit?>" class="btn btn-warning"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>-->
                                            <?php elseif(($u->posisi=='SPM-FINAL-VERIFIKATOR')||($u->posisi=='SPM-FINAL-KBUU')||($u->posisi=='SPM-FINAL-BUU')): ?>
                                            <button class="btn btn-danger tb-lihat" rel="<?=$u->kode_unit?>"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</button>
                                            <!--<a href="<?=site_url('rsa_up/spm_up_verifikator/').$u->kode_unit?>" class="btn btn-warning"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>-->
                                            <?php else: ?>
                                            <button disabled="disabled" class="btn btn-warning"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                <?php } ?>
                            </tbody>
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
