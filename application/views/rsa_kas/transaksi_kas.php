<script type="text/javascript">
var status_edit = true;

	<?php if ($this->session->flashdata('error')): ?>
		bootbox.alert({
            title: "<b style='color:orange;'>PERHATIAN !</b> ",
            message: "<?php echo $this->session->flashdata('error') ?>",
            animate: false,
        });
	<?php endif ?>

$(document).ready(function(){
	 $(document).on("click","#keluar",function(){
		
		   $('#lihat_modal').modal("toggle");

   });

	$(document).on("click","#modal_ubah",function(){
		$.ajax({
			type:"POST",
			url:"<?=site_url("rsa_kas/ganti_kas")?>",
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
					<h3>DAFTAR TRANSAKSI KAS UNDIP</h3><hr>

				</br>
				<div class="alert alert-warning" style="text-align:right">
					<button type="button" class="btn btn-danger" id="modal_ubah" rel=""><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> UBAH KAS</button>
				</div>
				<table class="table table-bordered table-striped table-hover small">
					<thead>
						<tr class="blue-gradient" style="color: white;" >
							<th  style="text-align: center">No</th>
							<th  style="text-align: center">Akun</th>
							<th class="col-md-2" style="text-align: center">Tanggal Transaksi</th>
							<th  style="text-align: center">Unit</th>
							<th class="col-md-2" style="text-align: center">Deskirpsi </th>
							<th class="col-md-3" style="text-align: center">Nomor SPM </th>
							<th class="col-md-2" style="text-align: center">Debet </th>
							<th class="col-md-2" style="text-align: center">Kredit </th>
							<th class="col-md-2" style="text-align: center">Saldo</th>
						</tr>
					</thead>
					
					<tbody id="row_space" style="font-size: 12px">
						<?php $i = 1 ?>
						<?php foreach ($daftar_transaksi_kas as $daftar): ?>
							<tr>
								<td>
									<?php echo $i ?>
								</td>
								<td>
									<?php echo $daftar->kd_akun_kas ?>
								</td>
								<td style="text-align: center">
									<?php echo substr($daftar->tgl_trx,0,10) ?>
								</td>
								<td>
									<?php echo $daftar->kd_unit ?>
								</td>
								<td>
									<?php echo $daftar->deskripsi ?>
								</td>
								<td style="text-align: center">
									<?php echo $daftar->no_spm ?>
								</td>
								<td style="text-align: right">
									Rp.<?php echo number_format($daftar->debet,0,',','.') ?>,-
								</td>
								<td style="text-align: right">
									Rp.<?php echo number_format($daftar->kredit,0,',','.') ?>,-
								</td>
								<td style="text-align: right">
									Rp.<?php echo number_format($daftar->saldo,0,',','.') ?>,-
								</td>
							</tr>
							<?php  $i++; endforeach  ?>
						</tbody>
						<tbody>
							<tr>
								<td colspan="9">&nbsp;</td>
							</tr>
						</tbody>
						<tbody>
							<tr>
									<td rowspan="<?php echo count($daftar_saldo)+1?>" colspan="4" style="vertical-align: middle;text-align: center;font-size: 24px;"><b>SALDO</b></td>
								
							</tr>
							<?php foreach ($daftar_saldo as $saldo): ?>
								<tr>
								<td colspan="1" style="text-align: center;border-right: none;"><strong>Kode Akun : <?php echo $saldo->kd_akun_kas ?></strong> </td>
								<td colspan="2" style="text-align:left;border-left: none;">(<?php echo $saldo->nama_akun ?>)</td>
								<td colspan="1" style="text-align: right;border-right: none;"><b> Rp.</b></td>
								<td colspan="12" style="text-align: right;border-left: none;"><b><?php echo number_format($saldo->saldo,2,',','.')  ?></b></td>
							</tr>
							<?php endforeach ?>
							
						</tbody>
					</table>
				</div>
				<div class="modal" id="lihat_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg" style="margin-top: 80px;">
						<div class="modal-content" id="modal_content">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>