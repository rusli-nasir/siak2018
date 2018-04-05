<script type="text/javascript">
var status_edit = true;

$(document).ready(function(){

$(document).on("click",".lihat_cetak",function(){
		var id = $(this).val();
		var data= "id="+id;
		$.ajax({
			type:"POST",
			url:"<?=site_url("rsa_pumk/cetak_kembali")?>",
			data:data,
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
					<h2>DAFTAR UANG KEMBALI</h2><hr>

				</br>
				<table class="table table-striped">
					<thead>
						<tr class="blue-gradient" style="color: white;" >
							<th class="col-md-1">No</th>
							<th class="col-md-2">Nomor Transaksi</th>
							<th class="col-md-2">Username</th>
							<th class="col-md-2">Nama </th>
							<th class="col-md-2">Jumlah Dana </th>
							<th class="col-md-2">Keterangan </th>
							<th class="col-md-1" style="text-align: center;">Aksi</th>
						</tr>
					</thead>
					<tbody id="row_space">
						<?php $i = 1 ?>
						<?php foreach ($daftar_pumk as $key => $daftar_pumk): ?>
							
							<tr>
								<td>
									<?php echo $i ?>
								</td>
								<td>
									<?php echo $daftar_pumk->nomor_trx_rsa_pumk_kembali ?>
								</td>
								<td>
									<?php echo $daftar_pumk->username ?>
								</td>
								<td>
									<?php echo $daftar_pumk->nama_pumk ?>
								</td>
								<td style="text-align: right">
									<?php echo number_format($daftar_pumk->jumlah_dana,0,',','.') ?>
								</td>
								<td>
									<?php echo $daftar_pumk->keterangan ?>
								</td>
								<td>
									<button type="button" class="lihat_cetak btn btn-info btn-sm" rel="" value="<?php echo $daftar_pumk->nomor_trx_rsa_pumk_kembali ?>" id="lihat_<?php echo $daftar_pumk->id_trx_rsa_pumk_kembali ?>" aria-label="Center Align">Lihat</button>
								</td>
							</tr>
							<?php  $i++; endforeach  ?>
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

