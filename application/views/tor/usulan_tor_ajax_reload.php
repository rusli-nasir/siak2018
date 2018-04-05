<?php foreach ($akun_subakun as $key_subunit => $value_subunit): ?>
<div class="alert" data-toggle="collapse" data-target=".data_sub_subunit_<?php echo $key_subunit ?>" style="border-radius:0px;border:1px solid #fff;background-color: #006064;color: #fff;margin: 10px 0px 0px 0px;padding: 5px;cursor: pointer;">
	<b><?=$value_subunit['nama_subunit']?></b>
	<?php if ($value_subunit['notif_subunit'] > 0): ?>
		<span class="badge badge-danger" style="margin-top: 3px;margin-right: 10px;font-size: 18px;float: right;"><?=$value_subunit['notif_subunit']?></span>
	<?php endif ?>
</div>
	<?php foreach ($value_subunit['data'] as $key_sub_subunit => $value_sub_subunit): ?>
	<div class="data_sub_subunit_<?php echo $key_subunit ?> collapse in">
		<div class="alert" data-toggle="collapse" data-target=".data_akun4d_<?php echo $key_sub_subunit ?>" style="border-radius:0px;border:1px solid #ddd;background-color: #ef5350b8;color: #fff;margin: 0px;padding: 5px;cursor: pointer;">
			<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$value_sub_subunit['nama_sub_subunit']?></b>
			<?php if ($value_sub_subunit['notif_sub_subunit'] > 0): ?>
				<span class="badge badge-danger" style="margin-top: 3px;margin-right: 10px;font-size: 16px;float: right;"><?=$value_sub_subunit['notif_sub_subunit']?></span>
			<?php endif ?>
		</div>

		<?php foreach ($value_sub_subunit['data'] as $key4digit => $value4digit): ?>
			<div class="data_akun4d_<?php echo $key_sub_subunit ?> collapse">
				<div class="alert " data-toggle="collapse" data-target=".data_akun5d_<?php echo $value4digit['kode_usulan_belanja_22'] ?>" style="border-radius:0px;border:1px solid #ddd;border-bottom:0px;background-color: #00695c61;color: #04483f;margin: 0px;padding: 5px;cursor: pointer;">
					<span> 
						<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $key4digit ?> : <?php echo $value4digit['nama_akun4digit'] ?></b>
					</span>
					<?php if ($value4digit['notif_4d'] > 0): ?>
						<span class="badge badge-danger" style="margin-top: 3px;margin-right: 10px;font-size: 14px;float: right;"><?=$value4digit['notif_4d']?></span>
					<?php endif ?>
					<div class="row">
						<div class="col-md-4" style="padding-left: 50px;">
							
							<span class="label label-success" style="font-size: 13px;border-radius: 15px;">&nbsp;&nbsp;</span>
							&nbsp;&nbsp;
							<b class="text-success">Anggaran : Rp. <?php echo number_format($value4digit['anggaran'],2,',','.') ?></b>
						</div>
						<div class="col-md-4" style="padding-left: 50px;">
							<span class="label label-warning" style="font-size: 13px;border-radius: 15px;">&nbsp;&nbsp;</span>
							&nbsp;&nbsp;
							<b class="text-warning">Usulan : Rp. <?php echo number_format($value4digit['usulan_anggaran'],2,',','.') ?></b>
						</div>
						<div class="col-md-4" style="padding-left: 50px;">
							<span class="label label-danger" style="font-size: 13px;border-radius: 15px;">&nbsp;&nbsp;</span>
							&nbsp;&nbsp;
							<b class="text-danger">Sisa : Rp. <?php echo number_format($value4digit['sisa_anggaran'],2,',','.') ?></b>
						</div>
					</div>
				</div>
				
				<?php foreach ($value4digit['data'] as $key5digit => $value5digit): ?>
					<div class="data_akun5d_<?php echo $value4digit['kode_usulan_belanja_22'] ?> collapse">
						<div class="alert " data-toggle="collapse" data-target=".data_akun6d_<?php echo $value5digit['kode_usulan_belanja_23'] ?>" style="border-radius:0px;border:1px solid #ddd;color: #0d6d64;background-color: #0096884a;margin: 0px;padding: 5px;cursor: pointer;">
							<span>
								<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $key5digit ?> : <?php echo $value5digit['nama_akun5digit'] ?></b>
							</span>
							<?php if ($value5digit['notif_5d'] > 0): ?>
								<span class="badge badge-danger" style="margin-top: 3px;margin-right: 10px;font-size: 12px;float: right;"><?=$value5digit['notif_5d']?></span>
							<?php endif ?>
						</div> 
						<?php foreach ($value5digit['data'] as $key6digit => $value6digit): ?>
							<div id="<?php echo $value6digit['kode_usulan_belanja'] ;?>" class="data_akun6d_<?php echo $value5digit['kode_usulan_belanja_23'] ?> collapse">
								<div class="alert" data-toggle="collapse" data-target=".data_rsa_detail_<?php echo $value6digit['kode_usulan_belanja'] ?>" style="border-radius:0px;border:1px solid #ddd;color: #495d5b;background-color: #b2dfdb80;margin: 0px;padding: 5px;cursor: pointer;">
									<span>
										<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $key6digit ?> : <?php echo $value6digit['nama_akun'] ?></b>
									</span>
									<?php if ($value6digit['notif_6d'] > 0): ?>
										<span class="badge badge-danger" style="margin-top: 3px;margin-right: 10px;font-size: 10px;float: right;"><?=$value6digit['notif_6d']?></span>
									<?php endif ?>
								</div>
								<div id="data_detail_<?php echo $key6digit ?>" class="data_rsa_detail_<?php echo $value6digit['kode_usulan_belanja'] ?> collapse">
									<!-- <hr> -->
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th class="col-md-1 text-center" >Akun</th>
												<th class="col-md-3 text-center" >Rincian</th>
												<th class="col-md-1 text-center" >Volume</th>
												<th class="col-md-1 text-center" >Satuan</th>
												<th class="col-md-2 text-center" >Harga</th>
												<th class="col-md-2 text-center" >Jumlah</th>
												<th class="col-md-1 text-center" style="text-align:center">Aksi</th>
												<th class="col-md-1 text-center" style="text-align:center">Usulkan</th>
											</tr>
										</thead>
										<tbody id="usulan_tor_row_detail_<?php echo $value6digit['kode_usulan_belanja'] ?>">
											<?php foreach ($value6digit['data'] as $keydetail => $valdetail): ?>
												<tr  id="<?php echo $valdetail['id_rsa_detail'] ;?>">
													<td class="text-center">
														<?php
														if(substr($valdetail['proses'],1,1)=='1'){echo '<span class="badge badge-gup">GP</span>';}
														elseif(substr($valdetail['proses'],1,1)=='3'){echo '<span class="badge badge-tup">TP</span>';}
														elseif(substr($valdetail['proses'],1,1)=='2'){echo '<span class="badge badge-lp">LP</span>';}
														elseif(substr($valdetail['proses'],1,1)=='4'){echo '<span class="badge badge-l3">LK</span>';}
														elseif(substr($valdetail['proses'],1,1)=='5'){echo '<span class="badge badge-ks">KS</span>';}
														elseif(substr($valdetail['proses'],1,1)=='6'){echo '<span class="badge badge-ln">LN</span>';}
														elseif(substr($valdetail['proses'],1,1)=='7'){echo '<span class="badge badge-em">EM</span>';}
														else{}
														?>
														<?php echo $keydetail ?>
													</td>
													<td>
														<?php echo $valdetail['rincian'] ?>
														<?php if (!empty($valdetail['ket'])): ?>
															<span class="glyphicon glyphicon-question-sign" style="cursor:pointer" onclick="open_tolak('<?php echo $valdetail['ket'] ?>')" aria-hidden="true"></span>
														<?php endif ?>
													</td>
													<td class="text-center"><?php echo $valdetail['volume'] + 0 ?></td>
													<td class="text-center"><?php echo $valdetail['satuan'] ?></td>
													<td class="text-right"><?php echo number_format($valdetail['harga_satuan'],0,',','.') ?></td>
													<td class="text-right"><?php echo number_format($valdetail['jumlah_harga'],0,',','.') ?></td>
													<?php if($valdetail['proses'] == 0) : ?>
														<td align="center">
															<div class="btn-group">
																<button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $valdetail['id_rsa_detail'];?>" class="btn btn-default btn-sm" onclick="doedit('<?php echo $valdetail['id_rsa_detail'] ;?>','<?php echo $value6digit['kode_usulan_belanja'] ;?>',this)" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
																<button type="button" style="padding-left:5px;padding-right:5px;" rel="<?php echo $valdetail['id_rsa_detail'];?>" class="btn btn-default btn-sm" id="delete_<?=$valdetail['id_rsa_detail']?>" data-kode-usulan="<?php echo $value6digit['kode_usulan_belanja'];?>" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
															</div>
														</td>
														<td>
															<button type="button" class="btn btn-success btn-sm" rel="<?php echo $valdetail['id_rsa_detail'] ;?>" id="proses_<?php echo $valdetail['id_rsa_detail'] ;?>" aria-label="Center Align" data-kode-usulan="<?php echo $value6digit['kode_usulan_belanja'] ?>"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Pilih </button>
														</td>
													<?php elseif(substr($valdetail['proses'],0,1) == 1): ?>
														<td align="center">
															<div class="btn-group">
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
															</div>
														</td>
														<td>
															<button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> PPK </button>
														</td>
													<?php elseif(substr($valdetail['proses'],0,1) == 2): ?>
														<td align="center">
															<div class="btn-group">
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
															</div>
														</td>
														<td>
															<button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Ver </button>
														</td>
													<?php elseif(substr($valdetail['proses'],0,1) == 3): ?>
														<td align="center">
															<div class="btn-group">
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
															</div>
														</td>
														<td>
															<button type="button" disabled="disabled" class="btn btn-warning btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="text-success glyphicon glyphicon-ok" aria-hidden="true"></span> Siap </button>
														</td>
													<?php elseif(substr($valdetail['proses'],0,1) == 4): ?>
														<td align="center">
															<div class="btn-group">
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
															</div>
														</td>
														<td>
															<button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> SPP </button>
														</td>
													<?php elseif(substr($valdetail['proses'],0,1) == 5): ?>
														<td align="center">
															<div class="btn-group">
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
															</div>
														</td>
														<td>
															<button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> SPM </button>
														</td>
													<?php elseif(substr($valdetail['proses'],0,1) == 6): ?>
														<td align="center">
															<div class="btn-group">
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
															</div>
														</td>
														<td>
															<button type="button" disabled="disabled" class="btn btn-info btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Cair </button>
														</td>
													<?php else: ?>
														<td align="center">
															<div class="btn-group">
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" onclick="" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="edit"><span class="text-warning glyphicon glyphicon-edit" aria-hidden="true"></span></button>
																<button type="button" style="padding-left:5px;padding-right:5px;" disabled="disabled" rel="" class="btn btn-default btn-sm" id="" aria-label="Center Align" data-toggle="tooltip" data-placement="top" title="hapus"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span></button>
															</div>
														</td>
														<td>
															<button type="button" disabled="disabled" class="btn btn-danger btn-sm" rel="" id="proses_" aria-label="Center Align"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Proses </button>
														</td>
													<?php endif; ?>
												</tr>
									
											<?php endforeach ?>
											<tr id="form_add_detail_<?php echo $value6digit['kode_usulan_belanja'] ?>" class="">
												<td >
													<input name="revisi" id="revisi_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="hidden" value="<?=$revisi?>" />
													<input name="impor" id="impor_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="hidden" value="<?=$impor?>" />
													<input name="kode_akun_tambah" class="form-control" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="kode_akun_tambah_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="text" value="<?php echo $value6digit['next_kode_akun_tambah'] ?>" readonly="readonly" />
												</td>
												<td >
													<textarea name="deskripsi" class="validate[required] form-control" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="deskripsi_<?php echo $value6digit['kode_usulan_belanja'] ?>" rows="5"></textarea>
												</td>
												<td ><input name="volume" class="validate[required,funcCall[checkfloat]] calculate form-control xfloat" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="volume_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="text" value="" data-toggle="tooltip" data-placement="top" title="Silahkan masukan angka bulat atau pecahan." /></td>
												<td ><input name="satuan" class="validate[required,maxSize[30]] form-control" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="satuan_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="text" value="" /></td>
												<td ><input name="tarif" class="validate[required,custom[integer],min[1]] calculate form-control xnumber" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="tarif_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="text" value="" /></td>
												<td ><input name="jumlah" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="jumlah_<?php echo $value6digit['kode_usulan_belanja'] ?>" type="text" class="form-control" readonly="readonly" value="" /></td>
												<td align="center" colspan="2">
													<div class="btn-group">
														<button style="padding-left:5px;padding-right:5px;margin-right: 5px;" type="button" class="btn btn-default btn-sm" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="tambah_<?php echo $value6digit['kode_usulan_belanja'] ?>" aria-label="Left Align" title="tambah"><span class="text-success text-success glyphicon glyphicon-ok" aria-hidden="true"></span> Tambah</button>
														<button style="padding-left:5px;padding-right:5px;" type="button" class="btn btn-default btn-sm" rel="<?php echo $value6digit['kode_usulan_belanja'] ?>" id="reset_<?php echo $value6digit['kode_usulan_belanja'] ?>" aria-label="Center Align" title="reset"><span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span> Reset</button>
													</div>
												</td>
												<!-- <td>&nbsp;</td> -->
											</tr>
											<tr id="tr_kosong" height="25px" style="display: none" class="alert alert-warning" >
												<td colspan="8">- kosong / belum disetujui -</td>
											</tr>
										</tbody>

										<div style="display: none;" rel="<?=$value6digit['kode_usulan_belanja']?>" id="td_usulan_<?=$value6digit['kode_usulan_belanja']?>">
											<?=number_format($value4digit['anggaran'], 0, ",", ".")?>
										</div>
										<div style="display: none;" id="td_kumulatif_<?=$value6digit['kode_usulan_belanja']?>">
											<?=number_format($value4digit['usulan_anggaran'], 0, ",", ".")?>
										</div>
										<div style="display: none;" id="td_kumulatif_sisa_<?=$value6digit['kode_usulan_belanja']?>">
											<?=number_format($value4digit['sisa_anggaran'], 0, ",", ".")?>
										</div>

									</table>
									<hr>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				<?php endforeach ?>
			</div>
		<?php endforeach ?>
	</div>
	<?php endforeach ?>
<?php endforeach ?>