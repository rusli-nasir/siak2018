<script type="text/javascript">
$(document).ready(function(){
	

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


$(document).on("click","#show",function(){
    if($("#form_").validationEngine("validate")){
        window.location = "<?=site_url('rsa_'.$jenis.'/daftar_unit/')?>" + $('#tahun').val();
        
 
    }
    
    
});


$(document).on("click",".tb-lihat",function(){
    var unit = $(this).attr('rel');
//    var sumber_dana = $('#sumber_dana').val();
    var tahun = $('#tahun').val();
    
    window.location = "<?=site_url('rsa_'.$jenis.'/daftar_spp/')?>" + unit + '/' + tahun; 
    
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
                        
    <form class="form-horizontal alert alert-warning col-sm-8" method="post" id="form_tor" >
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
                                        <th class="col-md-2" ><!--SPP / SPM--></th>
                                        <th class="col-md-2" ><!--TGL PROSES--></th>
                                        <th class="col-md-2" style="text-align:center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tb-isi" >
                                <?php foreach($unit_usul as $i => $u){ ?>
                                    <?php if(($u->kode_unit == '14')||($u->kode_unit == '15')||($u->kode_unit == '16')||($u->kode_unit == '17')): ?>
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
                                            <td class="">usulan baru : <span class="badge badge-danger"><?=$uu->jml?></span></td>
                                            <td style="">&nbsp;</td>
                                            <td align="center">

                                                <?php if($uu->jml > 0): ?>

                                                <a href="<?=site_url('rsa_'.$jenis.'/daftar_spm_verifikator/'.$cur_tahun.'/'.$uu->kode_subunit)?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>

                                                <?php else: ?>

                                                <a href="<?=site_url('rsa_'.$jenis.'/daftar_spm_verifikator/'.$cur_tahun.'/'.$uu->kode_subunit)?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>

                                                <?php endif; ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php } ?>
                                    <?php else: ?>
                                    <tr rel="<?=$u->kode_unit?>" class="tr-unit" height="25px">
                                        <td class=""><b><?=$u->kode_unit?></b></td>
                                        <td class="text-danger"><b><?=$u->nama_unit?></b></td>
                                        <td class="">usulan baru : <span class="badge badge-danger"><?=$u->jml?></span></td>
                                        <td style="">&nbsp;</td>
                                        <td align="center">
                                            <?php if($u->jml > 0): ?>

                                            <a href="<?=site_url('rsa_'.$jenis.'/daftar_spm_verifikator/'.$cur_tahun.'/'.$u->kode_unit)?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>

                                            <?php else: ?>

                                            <a href="<?=site_url('rsa_'.$jenis.'/daftar_spm_verifikator/'.$cur_tahun.'/'.$u->kode_unit)?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>

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
