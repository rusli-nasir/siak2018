<script type="text/javascript">

</script>
		<div class="row">
			<div class="col-lg-12">
				<div>
					<h4>DAFTAR KONTRAK</h4><hr>
					<span style="color: red;"><strong>[*jika data kontrak tidak ada disini berarti data belum ada dan silahkan menghubungi SIKONTRAK]</strong></span>
				
				<table class="table table-bordered" style="font-size: 12px">
					<thead >
						<tr class="blue-gradient" style="color: white;text-align: center;" >
							<th class="" style="text-align: center;">No</th>
							<th class="col-md-2" style="text-align: center;">Kode Usulan Belanja </th>
							<th class="col-md-2" style="text-align: center;">Kode Akun Tambah </th>	
							<th class="col-md-2" style="text-align: center;">Nomor  Kontrak </th>
							<th class="col-md-1" style="text-align: center;">Tanggal</th>
							<th class="col-md-2" style="text-align: center;">Nilai Kontrak</th>
							<th class="col-md-4" style="text-align: center;">Deskripsi</th>
							<th class="col-md-1" style="text-align: center;">Rekanan</th>
							<th class="col-md-1" style="text-align: center;">Termin</th>
						</tr>
					</thead>
					<tbody id="row_space">
						<?php $i = 1 ?>
						<?php foreach ($daftar_kontrak as $key => $daftar_pumk): ?>
							
							<tr>
								<td>
									<?php echo $i ?>
								</td>
								<td style="text-align: center;">
									<?php echo $daftar_pumk['kode_usulan_belanja'] ?>
								</td>
								<td  style="text-align: center;">
									<?php echo $daftar_pumk['kode_akun_tambah'] ?>
								</td>
								<td style="text-align: center;">
									<?php echo $daftar_pumk['nomor_kontrak'] ?>
								</td>
								<td style="text-align: ">
									<?php echo $daftar_pumk['tanggal'] ?>
								</td>
								<td style="text-align: right">
									<?php echo number_format($daftar_pumk['nilai_kontrak'],0,',','.') ?>
								</td>
								<td style="text-align: ">
									<?php echo $daftar_pumk['kontrak']['deskripsi'] ?>
								</td>
								<td style="text-align: ">
									<?php echo $daftar_pumk['rekanan']['nama_rekanan'] ?>
								</td>
								<td style="text-align: center;">
									<?php echo $daftar_pumk['termin'] ?>
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


