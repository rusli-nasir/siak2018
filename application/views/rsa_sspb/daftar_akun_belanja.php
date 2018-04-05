<script>
$(document).ready(function(){
	$(document).on("click",".tambah_sspb",function(){
		var nomor = $(this).val();
		var jenis = $(this).attr("rel");
		var spm = $(this).attr("data");
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("rsa_sspb/modal_tambah_sspb")?>",
			data:"nomor="+nomor+"&jenis="+jenis+"&spm="+spm,                      
			success:function(respon){
				$("#modal_content").html(respon);
			},
			complete:function(){
				$('#lihat_modal').modal('show');
			}
		});

});

});

</script>

<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<div>
					<h3>Tambah SSPB</h3><hr>

				<div class="alert alert-warning col-lg-4">
					SPM : <span style="color: ;"><?php echo base64_decode(urldecode($this->uri->segment(4))) ?></span>
				</div>
				</br>
				<table class="table table-striped">
					<thead>
						<tr class="" style="" >
							<th class="col-md-1" style="text-align: center;" >No</th>
							<th class="col-md-5">Nomor Kode Usulan Belanja</th>
							<th class="col-md-2">Akun Tambah</th>
							<th class="col-md-2">Nominal</th>
							<th class="col-md-2" style="text-align: center;">Aksi</th>
						</tr>
					</thead>
					<tbody id="row_space">
						<?php $i = 1 ?>
						<?php foreach ($akun as $key => $akun): ?>
							
							<tr>
								<td style="text-align: center;">
									<?php echo $i ?>
								</td>
								<td>
									<?php echo $akun->kode_usulan_belanja ?>
								</td>
								<td>
									<?php echo $akun->kode_akun_tambah ?>
								</td>
								<td style="text-align: right;">
									<?php echo number_format($akun->nominal,0,',','.') ?>
								</td>
								<td style="text-align: center;">
									<button type="button" class="tambah_sspb btn btn-success btn-sm" rel="<?php echo $akun->jenis ?>" data="<?php echo $spm ?>" value="<?php echo $akun->kode_usulan_belanja ?><?php echo $akun->kode_akun_tambah ?>" id="" aria-label="Center Align">SSPB</button>
								</td>
							</tr>
							<?php  $i++; endforeach  ?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal" id="lihat_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="margin-top: 80px;">
		<div class="modal-content" id="modal_content">
		</div>
	</div>
</div>