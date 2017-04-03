<script type="text/javascript">
$(document).on("click","#show",function(){
    if($("#form_").validationEngine("validate")){
        window.location = "<?=site_url('rsa_up/saldo/')?>" + $('#tahun').val();
         
    }

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
                     <h2>SALDO UP</h2>    
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
                                        <th class="col-md-6" >Unit</th>
                                        <th class="col-md-2" >Jumlah</th>
                                        <th class="col-md-2" >&nbsp;</th>
                                        <th class="col-md-2" style="text-align:center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tb-isi" >
                                <?php foreach($unit_usul as $i => $u){ ?>
                                    <tr rel="<?=$u->kode_unit?>" class="tr-unit" height="25px">
                                        <td class=""><b><?=$u->kode_unit?></b></td>
                                        <td class="text-danger"><b><?=$u->nama_unit?></b></td>
                                        <td class="" style="text-align: right"><?=number_format($u->saldo, 0, ",", ".")?></td>
                                        <td class="">&nbsp;</td>
                                        <td align="center">
                                            <?php if(empty($u->saldo)):?>
                                            <button disabled="disabled" class="btn btn-warning"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</button>
                                            
                                            <?php else: ?>
                                            <a href="<?=site_url('rsa_up/spm_up_verifikator/').$u->kode_unit?>" class="btn btn-warning"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>
                                            <?php endif; ?>
                                        </td>
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


	
                        </div>

	    </div>
	  </div>
</div>
