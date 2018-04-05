<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker.css" rel="stylesheet">

<script type="text/javascript">
	$(document).ready(function(){

		$(document).on("click","#pilih_tahun",function(){
//                        if($("#form_dpa").validationEngine("validate")){
//                            var sumber_dana = $('#sumber_dana').val();
                            window.location = "<?=site_url("rsa_cair/spm/")?>" + $("#tahun").val() + '/' + $("#unit").val() + '/' + $("#jenis").val()  ;

                    //        $('#tb-empty').hide(function(){
                    //                $('#tb-isi').show(function(){
                    //                    get_unit_dpa();

                    //                });
                    //            });


//                        }


                    });

			// $(document).on("click","#createspp",function(){

   //                          window.location = "<?=site_url("rsa_cair/spm/")?>/" ;

   //                          // alert('t');



   //                  });


    });
</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->
                
		<div class="row">
			<div class="col-lg-12">
				<h2>DAFTAR SPM CAIR</h2> 
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
					                    <option value="99">99 - [ SEMUA ]</option>
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
					                    <option value="00">[ SEMUA ]</option>
					                    <option value="UP">[ UP ]</option>
					                    <option value="PUP">[ PUP ]</option>
					                    <option value="GUP">[ GUP ]</option>
					                    <option value="TUP">[ TUP ]</option>
					                    <option value="TUP-NIHIL">[ TUP-NIHIL ]</option>
					                    <option value="LSP">[ LSP ]</option>
					                    <!--
					                    <option value="LS3">[ LS3 ]</option>
					                    -->
					                    <option value="LSK">[ LSK ]</option>
					                    <option value="LSNK">[ LSNK ]</option>
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

			<div class="col-md-12 table-responsive">
				<table class="table table-bordered table-striped table-hover small">
					<thead>
					<tr>
						<th class="text-center col-md-1">No</th>
                  <th class="text-center col-md-2">SPP</th>
                  <th class="text-center col-md-2">SPM</th>
                  <th class="text-center col-md-1">JENIS</th>
						<th class="text-center col-md-2">Tanggal</th>
						<th class="text-center col-md-1">Nominal</th>
						<th class="text-center col-md-1">Lihat</th>
					</tr>
					</thead>
					<tbody>
	<?php
		if(!empty($daftar_spm)){
			foreach ($daftar_spm as $key => $value) {
	?>
					<tr>
						<td class="text-center"><?php echo $value->no_urut; ?></td>
						<td class="text-center"><?php echo $value->str_nomor_trx_spp; ?> <?php echo isset($value->alias_spp)&&($value->alias_spp!='-')?'<span class="text-danger">( '.$value->alias_spp.' )</span>':'' ; ?></td>
						<td class="text-center"><?php echo $value->str_nomor_trx_spm; ?> <?php echo isset($value->alias_spm)&&($value->alias_spm!='-')?'<span class="text-danger">( '.$value->alias_spm.' )</span>':'' ; ?></td>
						<td class="text-center"><?php echo $value->jenis_trx; ?></td>
                        <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_proses)); ?><br /></td>
                        <td class="text-right"><?php echo number_format($value->nominal, 0, ",", "."); ?></td>
                        <?php if($value->jenis_trx == 'UP'): ?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_up/spm_up_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp)).'/'.$value->kode_unit_subunit.'/'.$cur_tahun.'#spm'?>">lihat</a> ]</b></td>
                        <?php elseif($value->jenis_trx == 'GUP'): ?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_gup/spm_gup_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp)).'/'.$value->kode_unit_subunit.'/'.$cur_tahun.'#spm'?>">lihat</a> ]</b></td>
						<?php elseif($value->jenis_trx == 'PUP'): ?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_tambah_up/spm_tambah_up_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp)).'/'.$value->kode_unit_subunit.'/'.$cur_tahun.'#spm'?>">lihat</a> ]</b></td>
						<?php elseif($value->jenis_trx == 'TUP'): ?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_tambah_tup/spm_tambah_tup_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp)).'/'.$value->kode_unit_subunit.'/'.$cur_tahun.'#spm'?>">lihat</a> ]</b></td>
						<?php elseif($value->jenis_trx == 'TUP-NIHIL'): ?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_tup/spm_tup_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp)).'/'.$value->kode_unit_subunit.'/'.$cur_tahun.'#spm'?>">lihat</a> ]</b></td>
						<?php elseif($value->jenis_trx == 'LSP'): ?>
						<td class="text-center"><b>[ <a href="<?=site_url('/tor/spmls/').get_id_by_nomor_lsp($value->str_nomor_trx_spm)?>">lihat</a> ]</b></td>
						<?php elseif($value->jenis_trx == 'LSK'): ?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_lsk/spm_lsk_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp)).'#spm'?>">lihat</a> ]</b></td>
						<?php elseif($value->jenis_trx == 'LSNK'): ?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_lsnk/spm_lsnk_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp)).'#spm'?>">lihat</a> ]</b></td>
						<?php elseif($value->jenis_trx == 'KS'): ?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_ks/spm_ks_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp)).'#spm'?>">lihat</a> ]</b></td>
						<?php elseif($value->jenis_trx == 'EM'): ?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_em/spm_em_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp)).'#spm'?>">lihat</a> ]</b></td>
						<?php endif; ?>
					</tr>

	<?php
			}
		}else{
	?>
					<tr>
						<td colspan="8" class="text-center alert-warning">
						Tidak ada data
						</td>
					</tr>
	<?php
		}
	?>
					<tr>
						<td colspan="8" >&nbsp;</td>
					</tr>
                                        </tbody>
				</table>
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