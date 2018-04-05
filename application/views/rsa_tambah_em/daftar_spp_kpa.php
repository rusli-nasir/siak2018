<script type="text/javascript">
	$(document).ready(function(){
		$(document).on("click","#pilih_tahun",function(){
//                        if($("#form_dpa").validationEngine("validate")){
//                            var sumber_dana = $('#sumber_dana').val();
                            window.location = "<?=site_url("rsa_tambah_ks/daftar_spp")?>/" + $("#tahun").val();

                    //        $('#tb-empty').hide(function(){
                    //                $('#tb-isi').show(function(){
                    //                    get_unit_dpa();

                    //                });
                    //            });


//                        }


                    });

			$(document).on("click","#createspp",function(){

                            window.location = "<?=site_url("rsa_tambah_ks/spp_tambah_ks")?>/" ;

                            // alert('t');



                    });
        });
        
        
</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->
                
                <div class="row">
                    <div class="col-lg-12">
                        <h2>DAFTAR SPP/SPM KS</h2> 
                    </div>
                </div>
                <hr />

		<div class="row">
			<div class="col-md-12">
                            
				<form id="kentut" class="form-horizontal">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-1">Tahun: </label>
								<div class="col-md-3">
									<?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'validate[required] form-control','id'=>'tahun'))?>
								</div>
								<div class="col-md-1">
									<button type="button" class="btn btn-primary btn-sm" id="pilih_tahun">Pilih Tahun</button>
								</div>
								<div class="col-md-7">
								<!--
									<button class="btn btn-danger" type="button" id="createspp" style="margin: 0 auto; width: 40%; display: block;" data-original-title="" title=""><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Create SPP</button>
									-->
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 table-responsive">
				<table class="table table-bordered table-striped table-hover small">
					<thead>
					<tr>
						<th class="text-center col-md-1">No</th>
                        <th class="text-center col-md-2">SPP</th>
                        <th class="text-center col-md-2">SPM</th>
						<th class="text-center col-md-2">Tanggal</th>
						<th class="text-center col-md-2">Nominal</th>
						<th class="text-center col-md-2">Status</th>
						<th class="text-center col-md-1">Lihat</th>
					</tr>
					</thead>
					<tbody>
	<?php
		if(!empty($daftar_spp)){
			foreach ($daftar_spp as $key => $value) {
	?>
					<tr>
						<td class="text-center"><?php echo $key + 1; ?>.</td>
						<td class="text-center"><?php echo $value->str_nomor_trx_spp; ?></td>
						<td class="text-center"><?php echo $value->str_nomor_trx_spm; ?></td>
                        <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_proses)); ?><br /></td>
                        <td class="text-center"><?php echo number_format($value->jumlah_bayar, 0, ",", "."); ?></td>
						<td class="text-center"><?php echo $value->posisi; ?></td>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_tambah_ks/spm_tambah_ks_kpa/').urlencode(base64_encode($value->str_nomor_trx_spp))?>">lihat</a> ]</b></td>
					</tr>
	<?php
			}
		}else{
	?>
					<tr>
						<td colspan="7" class="text-center alert-warning">
						Tidak ada data
						</td>
					</tr>
	<?php
		}
	?>
					<tr>
						<td colspan="7" >&nbsp;</td>
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
