<script type="text/javascript">


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
                                <?php foreach($unit as $i => $u): ?>
                                	<?php if ($u->kode_unit == '14' || $u->kode_unit == '15' || $u->kode_unit == '16'  || $u->kode_unit == '17'): ?>
	                                	<tr rel="<?=$u->kode_unit?>" class="tr-unit" height="25px">
	                                        <td class=""><b><?=$u->kode_unit?></b></td>
	                                        <td class="text-danger"><b><?=$u->nama_unit?></b></td>
	                                        <td class="">&nbsp;</td>
	                                        <td style="">&nbsp;</td>
	                                        <td align="center">&nbsp;</td>
	                                    </tr>
                                    <?php foreach ($unit as $key => $value): ?>
                                    		<?php if (strlen($value->kode_unit) == 4): ?>
                                    			<?php if (substr($value->kode_unit,0,2) == $u->kode_unit ): ?>
			                                	<tr rel="<?=$value->kode_unit?>" class="tr-unit warning" height="25px" style="background-color: ">
			                                        <td class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?=$value->kode_unit?></b></td>
			                                        <td class="text-danger">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?=$value->nama_unit?></b></td>
			                                        <td class="">
														<?php if ($value->jumlah > 0): ?>
			                                        		usulan baru : <span class="badge badge-danger"><?=$value->jumlah?>
														<?php else: ?>
			                                        		usulan baru : <span class="badge badge-success"><?=$value->jumlah?>
														<?php endif ?>

			                                        </td>
			                                        <td style="">&nbsp;</td>
			                                        <td align="center">&nbsp;
			                                        	<?php if ($value->jumlah > 0): ?>
			                                        	<a href="<?=site_url('rsa_sspb/daftar_sspb/'.$value->kode_unit)?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>
			                                        	<?php else: ?>
			                                        	<a href="<?=site_url('rsa_sspb/daftar_sspb/'.$value->kode_unit)?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>	
			                                        	<?php endif ?>
			                                        </td>
			                                    </tr>
                                    			<?php endif ?>
                                    		<?php endif ?>
                                    	<?php endforeach ?>	
                                    <?php elseif (strlen($u->kode_unit) == 4): ?>
                                	<?php else: ?>
                                    <tr rel="<?=$u->kode_unit?>" class="tr-unit" height="25px">
                                        <td class=""><b><?=$u->kode_unit?></b></td>
                                        <td class="text-danger"><b><?=$u->nama_unit?></b></td>
                                        <td class="">
                                        	<?php if ($u->jumlah > 0): ?>
                                        		usulan baru : <span class="badge badge-danger"><?=$u->jumlah?>
                                        		<?php else: ?>
                                        			usulan baru : <span class="badge badge-success"><?=$u->jumlah?>
                                        			<?php endif ?>
                                        </td>
                                        <td style="">&nbsp;</td>
                                        <td align="center">&nbsp;
                                        	<?php if ($u->jumlah > 0): ?>
											<a href="<?=site_url('rsa_sspb/daftar_sspb/'.$u->kode_unit)?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>
                                        	<?php else: ?>
                                    		<a href="<?=site_url('rsa_sspb/daftar_sspb/'.$u->kode_unit)?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Lihat</a>
                                        	<?php endif ?>
                                        </td>
                                    </tr>						
                                	<?php endif ?>
							<?php endforeach ?>
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
