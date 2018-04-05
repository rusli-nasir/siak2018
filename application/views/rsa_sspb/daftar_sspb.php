<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="tambah_sp2d">
				<div class="row">
					<div class="col-lg-12">
						<h2>DAFTAR SSPB</h2> 
					</div>
				</div>
				<hr />
				<div class="row">
					<div class="col-md-12 table-responsive">
						<table class="table table-bordered table-striped table-hover small" style="font-size: 12px;">
							<thead>
								<tr >
									<th class="text-center ">No</th>
									<th class="text-center col-md-2">SPM</th>
									<th class="text-center col-md-2">NO SSPB</th>
									<th class="text-center col-md-2">Kode Usulan Belanja</th>
									<th class="text-center col-md-1">Kode Akun Tambah</th>
									<th class="text-center col-md-2">Tanggal</th>
									<th class="text-center col-md-1">Nominal</th>
									<th class="text-center col-md-2">Status</th>
									<th class="text-center col-md-2">Aksi</th>
								</tr>
							</thead>
							<tbody>

								<?php $i = 1; ?>
								<?php foreach ($daftar_sspb as $value): ?>
									
								<?php 
								if ($value->posisi == 'SSPB-DRAFT'){
									$bcolor = '#fff4cc';	
								}else if ($value->posisi == 'SSPB-DRAFT-PPK'){
									$bcolor = '#fff4cc';	
								}else if ($value->posisi == 'SSPB-DITOLAK-PPK'){
									$bcolor = '#ffd7dd';	
								} else if ($value->posisi == 'SSPB-DRAFT-KPA'){
									$bcolor = '#fff4cc';	
								} else if ($value->posisi == 'SSPB-DITOLAK-KPA'){
									$bcolor = '#ffd7dd';	
								} else if ($value->posisi == 'SSPB-FINAL-VERIFIKATOR'){
									$bcolor = '#fff4cc';	
								} else if ($value->posisi == 'SSPB-DITOLAK-VERIFIKATOR'){
									$bcolor = '#ffd7dd';	
								} else if ($value->posisi == 'SSPB-FINAL-KBUU'){
									$bcolor = '#cfe0ff7a';	
								} else if ($value->posisi == 'SSPB-DITOLAK-KBUU'){
									$bcolor = '#ffd7dd';	
								}   
								?>
								<tr>
									<td class="text-center"><?php echo $i ?>.</td>
									<td class="text-center"><?php echo $value->nomor_trx_spm ?></a></td>
									<td class="text-center"><?php echo $value->nomor_sspb ?></td>
									<td class="text-center"><?php echo $value->kode_usulan_belanja ?></td>
									<td class="text-center"><?php echo $value->kode_akun_tambah ?></td>
									<td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($value->tgl_sspb)?'':strftime("%d %B %Y", strtotime($value->tgl_sspb)); ?> </td>
									<td class="text-right"><?php echo number_format($value->jumlah_bayar, 0, ",", ".") ?></td>
									<td class="text-center" style="background-color: <?php echo $bcolor ?>;"><b><?php echo $value->posisi ?></b></td>
									<td class="text-center" >
										<div class="btn-group" role="group">
											<a href="<?php echo base_url(); ?>index.php/rsa_sspb/cetak_sspb/<?php echo urlencode(base64_encode($value->nomor_sspb)) ?>" class="btn-sm btn-info">LIHAT</a>
										</div>
									</td>
								</tr>
								<?php $i++; ?>
								<?php endforeach ?>
								<tr>
									<td colspan="6" style="text-align: right;"><b>Total Setoran ( <span class="text-danger">SSPB-FINAL-KBUU</span> )</b></td>
									<td style="text-align: right;"><b><?php echo number_format($total_sspb, 0, ",", ".") ?></b></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- end content -->
	</div>
</div>