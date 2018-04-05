<script type="text/javascript">
	$(document).ready(function(){
            
            $('#spm_tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
      });

      // store the currently selected tab in the hash value
      $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
      });

      // on load of the page: switch to the currently selected tab
      var hash = window.location.hash;
      $('#spm_tab a[href="' + hash + '"]').tab('show');
      
      
		$(document).on("click","#pilih_tahun",function(){
                    
                        var type = window.location.hash.substr(1);

                            window.location = "<?=site_url("rsa_up/daftar_spm")?>/" + $("#tahun").val() + '#' + type;


                    });
                    $(document).on("click","#pilih_tahun_pup",function(){
                    
                        var type = window.location.hash.substr(1);

                            window.location = "<?=site_url("rsa_up/daftar_spm")?>/" + $("#tahun_pup").val() + '#' + type;


                    });
        });
        
        
</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->
                
                <div class="row">
                    <div class="col-lg-12">
                        <h2>DAFTAR SPM</h2> 
                    </div>
                </div>
                <hr />
                
     <div class="row">
			<div class="col-md-12">           
                
                 <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="spm_tab">
        <li role="presentation" class="active"><a href="#up" aria-controls="home" role="tab" data-toggle="tab">UP</a></li>
        <li role="presentation"><a href="#pup" aria-controls="profile" role="tab" data-toggle="tab">PUP</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="up">
          
          <br>

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
                                                <th class="text-center col-md-3">Nomor</th>
						<th class="text-center col-md-3">Tanggal</th>
						<th class="text-center col-md-3">Status</th>
						<th class="text-center col-md-2">Lihat</th>
					</tr>
					</thead>
					<tbody>
	<?php
		if(!empty($daftar_spm)){
			foreach ($daftar_spm as $key => $value) {
	?>
					<tr>
						<td class="text-center"><?php echo $key + 1; ?>.</td>
						<td class="text-center"><?php echo $value->str_nomor_trx; ?></td>
                                                <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_proses)); ?><br /></td>
						<td class="text-center"><?php echo $value->posisi; ?></td>
						<td class="text-center">&nbsp;</td>
					</tr>
	<?php
			}
		}else{
	?>
					<tr>
						<td colspan="5" class="text-center alert-warning">
						Tidak ada data
						</td>
					</tr>
	<?php
		}
	?>
					<tr>
						<td colspan="5" >&nbsp;</td>
					</tr>
                                        </tbody>
				</table>
			</div>
		</div>

		<!-- end content -->
                </div>
                <div role="tabpanel" class="tab-pane" id="pup">
          
          <br>

		<div class="row">
			<div class="col-md-12">
                            
				<form id="kentut_pup" class="form-horizontal">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-1">Tahun: </label>
								<div class="col-md-3">
									<?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'validate[required] form-control','id'=>'tahun_pup'))?>
								</div>
								<div class="col-md-1">
									<button type="button" class="btn btn-primary btn-sm" id="pilih_tahun_pup">Pilih Tahun</button>
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
                                                <th class="text-center col-md-3">Nomor</th>
						<th class="text-center col-md-3">Tanggal</th>
						<th class="text-center col-md-3">Status</th>
						<th class="text-center col-md-2">Lihat</th>
					</tr>
					</thead>
					<tbody>
	<?php
		if(!empty($daftar_spm_pup)){
			foreach ($daftar_spm_pup as $key => $value) {
	?>
					<tr>
						<td class="text-center"><?php echo $key + 1; ?>.</td>
						<td class="text-center"><?php echo $value->str_nomor_trx; ?></td>
                                                <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_proses)); ?><br /></td>
						<td class="text-center"><?php echo $value->posisi; ?></td>
						<td class="text-center">&nbsp;</td>
					</tr>
	<?php
			}
		}else{
	?>
					<tr>
						<td colspan="5" class="text-center alert-warning">
						Tidak ada data
						</td>
					</tr>
	<?php
		}
	?>
					<tr>
						<td colspan="5" >&nbsp;</td>
					</tr>
                                        </tbody>
				</table>
			</div>
		</div>

		<!-- end content -->
                </div>
</div>
                </div>
</div>
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
