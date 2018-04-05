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
                    

                            window.location = "<?=site_url('rsa_'.$jenis.'/daftar_spm_verifikator')?>/" + $("#tahun").val() + '/' + '<?=$kode_unit?>' ;



                    });


         $(".doc-posisi").each(function(){
            var string = $(this).text() ,substring = "DITOLAK";
            if(string.indexOf(substring) !== -1){
                $(this).addClass('danger');
            }

            /*

        <?php var_dump($_SESSION); ?>
            */

            string = $(this).text() ,substring = "SPM-FINAL-KBUU";
            if(string.indexOf(substring) !== -1){
                $(this).addClass('info');
            }

            string = $(this).text() ,substring = "SPM-DRAFT-KPA";
            if(string.indexOf(substring) !== -1){
                $(this).addClass('success');
            }

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
                
                 <!-- Nav tabs -->

  <!-- Tab panes -->

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
                        <th class="text-center col-md-1">SPP</th>
                        <th class="text-center col-md-1">SPM</th>
                        <th class="text-center col-md-4">Deskripsi</th>
						<th class="text-center col-md-2">Tanggal</th>
						<th class="text-center col-md-1">Nominal</th>
						<th class="text-center col-md-1">Status</th>
						<th class="text-center col-md-1">Lihat</th>
					</tr>
					</thead>
					<tbody>
	<?php
		if(!empty($daftar_spm)){

			$n = count($daftar_spm) ; 
			$total_cair = 0 ;
			foreach ($daftar_spm as $key => $value) {
	?>
					<tr >
						<td class="text-center"><?php echo $key + 1; ?>.</td>
						<td class="text-center"><?php echo $value->str_nomor_trx_spp; ?></td>
						<td class="text-center"><?php echo $value->str_nomor_trx_spm; ?></td>
						<td class=""><?php echo $value->untuk_bayar; ?></td>
                        <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_proses)); ?><br /></td>
                        <td class="text-center"><?php echo number_format($value->jumlah_bayar, 0, ",", "."); ?></td>
						<td class="text-center doc-posisi"><?php echo $value->posisi; ?></td>
						<?php if(($value->posisi == 'SPP-DRAFT')||($value->posisi == 'SPP-FINAL')||($value->posisi == 'SPP-DITOLAK')):?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_'.$jenis.'/spp_'.$jenis.'_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp))?>">lihat</a> ]</b></td>
						<?php elseif($value->posisi == 'SPM-DRAFT-KPA'):?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_'.$jenis.'/spm_'.$jenis.'_verifikator/').urlencode(base64_encode($value->str_nomor_trx_spp))?>#spm">lihat</a> ]</b></td>
						<?php else:?>
						<td class="text-center"><b>[ <a href="<?=site_url('/rsa_'.$jenis.'/spm_'.$jenis.'_lihat/').urlencode(base64_encode($value->str_nomor_trx_spp))?>#spm">lihat</a> ]</b></td>
						<?php endif; ?>
					</tr>
	<?php
					if($value->posisi=='SPM-FINAL-KBUU'){$total_cair = $total_cair+$value->jumlah_bayar;}
			}
			?>
				<tr>
						<td colspan="5" style="text-align:right"><b>Total Cair ( <span class="text-danger">SPM-FINAL-KBUU</span> )</b></td>
						<td class="text-right"><?php echo number_format($total_cair, 0, ",", "."); ?></td>
						<td >&nbsp;</td>
						<td >&nbsp;</td>
				</tr>
			<?php 

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

                                        </tbody>
				</table>
			</div>
		</div>

		<!-- end content -->
	</div>
</div>