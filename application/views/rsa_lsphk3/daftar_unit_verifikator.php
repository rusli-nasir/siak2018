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
        window.location = "<?=site_url('rsa_lsphk3/daftar_spm_verifikator/'.$id_unit."/")?>" + $('#tahun').val();
        
 
    }
    
    
});




 $(document).on("click",".tb-lihat",function(){
					
					 var id = $(this).attr('rel');
					 var rel = [];
						rel[0] = id;
						$('#rel_kuitansi').val(JSON.stringify(rel));
						$('#form_usulkan_spm').submit();
					 //var data =Base64.encode(id); 
                   // document.location.href = "<?=site_url("rsa_lsphk3/spp_lsphk3")?>/"+id;
					//window.location="<?=site_url("rsa_lsphk3/spm_lsphk3")?>/"+id;
                });


</script>
<?php
$i = isset($spm_usul[0])?$spm_usul[0]:'';
?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>DAFTAR SPM LS PIHAK KE 3 </h2>    
                    </div>
                </div>
                <hr />
                <div class="row">  
                    <div class="col-lg-12">
                        
    <form class="form-horizontal alert alert-warning col-sm-8" method="post" id="form_tor" action="<?php echo site_url('rsa_lsphk3/daftar_spm_verifikator');?>">
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
                                        <th class="col-md-3" >Unit</th>
                                        <th class="col-md-4" >Nomor SPM</th>
										<th class="col-md-2" >Posisi</th>
                                        <th class="col-md-2" >TAHUN</th>
                                        <th class="col-md-2" style="text-align:center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tb-isi" >
                                <?php foreach($spm_usul as $i => $u){ ?>
                                  
                                    <tr rel="<?=$u->kode_unit?>" class="tr-unit" height="25px">
                                        <td class=""><b><?=$u->kode_unit?></b></td>
                                        <td class="text-danger"><b><?php echo get_h_subunit($u->kode_unit); ?></b></td>
                                        <td class=""><?=$u->str_nomor_trx;?></td>
                                        <td style=""><?=$u->posisi;?></td>
                                        <td align="center"><?=$u->tahun;?></td>
										<td align="center"><button class="btn btn-warning tb-lihat" rel="<?=$u->id_kuitansi?>"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</button></td>
                                    </tr>
                                       
								<?php } ?>
                                       
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
					<form action="<?=site_url('rsa_lsphk3/view_spm_lsphk3_verifikator')?>" id="form_usulkan_spm" method="post" style="display: none">
					<input type="text" name="rel_kuitansi" id="rel_kuitansi" value=""/>
				</form>

	
                        </div>

	    </div>
	  </div>
</div>
