<div role="tabpanel" class="tab-pane active" id="spp">
          
<div style="background-color: #EEE; padding: 10px;">
<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
<div class="carousel-inner" role="listbox">
<div class="item active" id="a">
<div id="div-cetak">
		<table id="table_spp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
			<tbody>
                            <tr >
                                <td colspan="5" style="text-align: right;font-size: 30px;padding: 10px;"><b>F1</b></td>
                            </tr>
                            
                            <tr >
                                <td colspan="5" style="text-align: center;padding-top: 5px;padding-bottom: 5px;"><img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60"></td>
                            </tr>
                            <tr style="">
                                    <td colspan="5" style="text-align: center;font-size: 20px;border-bottom: none;"><b>UNIVERSITAS DIPONEGORO</b></td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="5" style="text-align: center;font-size: 16px;border-bottom: none;border-top: none;"><b>SURAT PERMINTAAN PEMBAYARAN</b></td>
                                </tr>
                                <tr style="border-top: none;border-bottom: none;">
                                    <td colspan="2" style="border-right: none;border-right: none;border-top: none;border-bottom: none;"><b>TAHUN ANGGARAN : <?=$cur_tahun?></b></td>
                                    <td style="text-align: center;border-right: none;border-left: none;border-top: none;border-bottom: none;" colspan="2">&nbsp;</td>
                                    <td style="border-left: none;border-top: none;border-bottom: none;"><b>JENIS : GUP</b></td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="2" style="border-right: none;border-top:none;"><b>Tanggal	: <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); ?></b></td>
                                    <td style="text-align: center;border-left: none;border-right: none;border-top:none;" colspan="2" >&nbsp;</td>
                                    <td style="border-left: none;border-top:none;"><b>Nomor : <span id="nomor_trx"><?=$nomor_spp?></span><!--00001/<?=$alias?>/SPP-UP/JAN/<?=$cur_tahun?>--></b></td>
                                </tr>
                                <tr >
                                    <td colspan="5"><b>Satuan Unit Kerja Pengguna Anggaran (SUKPA) : <?=$unit_kerja?></b></td>
                                </tr>
                                <tr >
                                    <td colspan="5" ><b>Unit Kerja : <?=$unit_kerja?> &nbsp;&nbsp; Kode Unit Kerja : <?=$unit_id?></b></td>
                                </tr>
				<tr style="border-bottom: none;">
                                    
                                    <td colspan="4" style="border-right: none;border-bottom: none;">&nbsp;</td>
                                    <td style="line-height: 16px;border-left: none;border-bottom: none;">Kepada Yth.<br>
                                                    Pengguna Anggaran<br>
                                                    SUKPA <?=$unit_kerja?><br>
                                                    di Semarang
                                    </td>
				</tr>
                                <tr >
                                        <td colspan="5" style="border-bottom: none;border-top: none;">&nbsp;</td>
                                </tr>
                                <tr >
                                        <td colspan="5" style="border-bottom: none;border-top: none;">Dengan Berpedoman pada Dokumen RKAT yang telah disetujui oleh MWA, bersama ini kami mengajukan Surat Permintaan Pembayaran sebagai berikut:</td>
                                </tr>
				<tr>
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;border-top: none;">
                                        <ol style="list-style-type: lower-alpha;margin-top: 0px;margin-bottom: 0px;" >
                                            <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar_spp"><?php echo isset($detail_gup['nom'])?number_format($detail_gup['nom'], 0, ",", "."):''; ?></span>,-<br>
                                                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang_spp"><?php echo isset($detail_gup['terbilang'])?ucwords($detail_gup['terbilang']):''; ?></span></b>)</li>
                                                <li>Untuk keperluan : <span id="untuk_bayar_spp"><?=isset($detail_pic->untuk_bayar)?$detail_pic->untuk_bayar:''?></span></li>
                                                <li>Nama bendahara pengeluaran : <span id="penerima_spp"><?=isset($detail_pic->penerima)?$detail_pic->penerima:''?></span></li>
                                                <li>Alamat : <span id="alamat_spp"><?=isset($detail_pic->alamat_penerima)?$detail_pic->alamat_penerima:''?></span></li>
                                                <li>Nama Bank : <span id="nmbank_spp"><?=isset($detail_pic->nama_bank_penerima)?$detail_pic->nama_bank_penerima:''?></span></li>
                                                <li>No. Rekening Bank : <span id="rekening_spp"><?=isset($detail_pic->no_rek_penerima)?$detail_pic->no_rek_penerima:''?></span></li>
                                                <li>No. NPWP : <span id="npwp_spp"><?=isset($detail_pic->npwp_penerima)?$detail_pic->npwp_penerima:''?></span></li>
                                        </ol>
                                    </td>
                                </tr>
                                                               
                                                                
                                <tr>
                                        <td colspan="5" style="border-top: none;border-bottom:none;">
                                        Pembayaran sebagaimana tersebut diatas, dibebankan pada pengeluaran dengan uraian sebagai berikut :<br>							
                                        </td>
				
                                
                                </tr>
							<tr >
                                                            <td colspan="3" style="vertical-align: top;border-bottom: none;border-top:none;padding-left: 0;">
                                                                <table style="font-family:arial;font-size:12px;line-height: 21px;border-collapse: collapse;width: 100%;border: 1px solid #000;background-color: #FFF;border-left: none;border-right:none;" cellspacing="0" border="1" cellpadding="0">
                                                                    <tr>
                                                                        <td style="text-align: center" colspan="3"><b>PENGELUARAN</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;text-align: center;">NAMA AKUN</td>
                                                                        <td style="border-right: solid 1px #000;text-align: center;">KODE AKUN</td>
                                                                        <td style="text-align: center;">JUMLAH UANG</td>
                                                                    </tr>
                                                                    <?php $jml_pengeluaran = 0; ?>
                                                                    <?php $sub_kegiatan = '' ; ?>
                                                                    <?php if(!empty($data_akun_pengeluaran)): ?>
                                                                    <?php foreach($data_akun_pengeluaran as $data):?>
                                                                    <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                                                                     <tr>
                                                                        <td colspan="3">
                                                                             <b><?=$data->nama_subkomponen?></b>
                                                                        </td>
                                                                     </tr>
                                                                    <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                                                                    <?php endif; ?>
                                                                    <tr>
                                                                            <td style="border-right: solid 1px #000">
                                                                                    <?=$data->nama_akun5digit?>
                                                                            </td>
                                                                            <td  style="text-align: center;border-right: solid 1px #000;">
                                                                                    <?=$data->kode_akun5digit?>
                                                                            </td>
                                                                            <td style="text-align: right;">
                                                                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                                                                    Rp. <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                                                            </td>
                                                                    </tr>
                                                                    <?php endforeach;?>
                                                                    <?php else: ?>
                                                                    <tr>
                                                                            <td style="border-right: solid 1px #000">
                                                                                    &nbsp;
                                                                            </td>
                                                                            <td  style="text-align: center;border-right: solid 1px #000;">
                                                                                    &nbsp;
                                                                            </td>
                                                                            <td style="text-align: right;">
                                                                                    Rp. 0
                                                                            </td>
                                                                    </tr>
                                                                    <?php endif; ?>
                                                                    <tr>
                                                                        <td colspan="2" style="border-right: solid 1px #000">
                                                                            Jumlah Pengeluaran
                                                                        </td>
                                                                        <td  style="text-align: right;">
                                                                                Rp. <?=number_format($jml_pengeluaran, 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="border-right: solid 1px #000">
                                                                            Dikurangi : Jumlah potongan untuk pihak lain
                                                                        </td>
                                                                        <td  style="text-align: right;">
                                                                            <?php $tot_pajak__ = 0 ; 
                                                                            if(!empty($data_spp_pajak)){
                                                                                foreach($data_spp_pajak as $data){
                                                                                   $tot_pajak__ = $tot_pajak__ + $data->rupiah ;
                                                                                }
                                                                            } ?>
                                                                                Rp. <?=number_format($tot_pajak__, 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                    <td colspan="2" style="border-right: solid 1px #000">
                                                                        <strong>Jumlah dana yang dikeluarkan</strong>
                                                                    </td>
                                                                    <td  style="text-align: right;">
                                                                            Rp. <?=number_format(($jml_pengeluaran - $tot_pajak__), 0, ",", ".")?>
                                                                    </td>
                                                                </table>
                                                            </td>
                                                            <td colspan="2" style="vertical-align: top;border-bottom: none;border-top:none;padding-right: 0;">
                                                                <table style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 100%;border: 1px solid #000;background-color: #FFF;border-left: none;border-right:none;" cellspacing="0" border="1" cellpadding="0">
                                                                    <tr>
                                                                        <td style="text-align: center" colspan="2"><b>PERHITUNGAN TERKAIT PIHAK LAIN</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align: center" colspan="2">PENERIMAAN DARI PIHAK KE-3</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;width: 50%;text-align: center;">Akun</td>
                                                                        <td style="width: 50%;text-align: center;">Jumlah Uang</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;text-align: center;">-</td>
                                                                        <td style="text-align: right;">Rp. 0</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;"><b>Jumlah Penerimaan</b></td>
                                                                        <td  style="text-align: right;">Rp. 0</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="text-align: center">
                                                                                POTONGAN UNTUK PIHAK LAIN
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                            <td style="text-align: center;border-right: solid 1px #000;">
                                                                                    Akun Pajak dan Potongan Lainnya
                                                                            </td>
                                                                            <td style="text-align: center">
                                                                                    Jumlah Uang
                                                                            </td>
                                                                    </tr>
                                                                    <?php $tot_pajak_ = 0 ; ?>
                                                                    <?php if(!empty($data_spp_pajak)): ?>
                                                                    <?php foreach($data_spp_pajak as $data):?>
                                                                    <tr>
                                                                            <td style="border-right: solid 1px #000;">
                                                                                    <?php 
                                                                                    if($data->jenis == 'PPN'){
                                                                                            echo 'Pajak Pertambahan Nilai';
                                                                                    }elseif($data->jenis == 'PPh'){
                                                                                            echo 'Pajak Penghasilan';
                                                                                    }else{
                                                                                            echo 'Lainnya';
                                                                                    }
                                                                                    ?>
                                                                            </td>
                                                                            <td  style="text-align: right;">
                                                                                    <?php $tot_pajak_ = $tot_pajak_ + $data->rupiah ?>
                                                                                    Rp. <?=number_format($data->rupiah, 0, ",", ".")?>
                                                                            </td>
                                                                    </tr>
                                                                    <?php endforeach;?>
                                                                    <?php else: ?>
                                                                    <tr>
                                                                            <td style="border-right: solid 1px #000;">
                                                                                    &nbsp;
                                                                            </td>
                                                                            <td  style="text-align: right;">
                                                                                    &nbsp;
                                                                            </td>
                                                                    </tr>
                                                                    <?php endif; ?>
                                                                    <tr>
                                                                        <td style="border-right: solid 1px #000;">
                                                                                <b>Jumlah Potongan</b>
                                                                        </td>
                                                                        <td  style="text-align: right;">
                                                                                Rp. <?=number_format($tot_pajak_, 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
							</tr>
                                <tr >
                                        <td colspan="5" style="border-bottom: none;border-top: none;">&nbsp;</td>
                                </tr>
				<tr style="border-bottom: none;">
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;border-top:none;">
						SPP Sebagaimana dimaksud diatas, disusun sesuai dengan dokumen lampiran yang persyaratkan dan disampaikan secara bersamaan serta merupakan bagian yang tidak terpisahkan dari surat ini.<br><br>														
					</td>
				<tr>
				<tr style="border-top: none;"> 
				
                                    <td colspan="4" style="border-right: none;border-top:none;">&nbsp;</td>
								<td  style="line-height: 16px;border-left: none;border-top:none;" class="ttd">
									Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
									Bendahara Pengeluaran SUKPA<br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
                                                                        <span id="nmbendahara"><?=isset($detail_pic->nmbendahara)?$detail_pic->nmbendahara:''?></span><br>
                                                                        NIP. <span id="nipbendahara"><?=isset($detail_pic->nipbendahara)?$detail_pic->nipbendahara:''?></span><br>
								</td>
				</tr>
				<tr>
					<td colspan="5"  style="line-height: 16px;">
						<strong>Keterangan:</strong>
						<ul>
							<li>Semua bukti pengeluaran untuk pekerjaan dengan perjanjian yang disahkan Pejabat Pembuat Komitmen telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan Keuangan SUKPA</li>
							<li>Semua bukti-bukti pengeluaran untuk pekerjaan yang disahkan Pejabat Pelaksana dan Pengendali Kegiatan (PPPK) telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan SUKPA.</li>
							<li>Kebenaran perhitungan dan isi tertuang dalam SPP ini menjadi tanggung jawab Bendahara Pengeluaran sepanjang sesuai dengan bukti-bukti pengeluaran yang telah ditandatangani oleh PPPK atau PPK</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
</div>
</div>
<div class="item" id="b">
<div id="div-cetak-f1a">
                <table id="table_f1a" class="table_lamp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                                <td colspan="7" style="text-align: right;font-size: 30px;padding: 10px;"><b>F1A</b></td>
                            </tr>
                            <tr >
                            <td colspan="7" style="text-align: center;border-bottom: none;">
                                <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
                                <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                <h5><b>RINCIAN SURAT PERMINTAAN PEMBAYARAN GUP</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="2" style="border: none;">
                                <b>NO SPP : <?=$nomor_spp?></b>
                            </td>
                            <td style="border: none;">&nbsp;</td>
                            <td colspan="3" style="border-left: none;border-top: none;border-bottom: none;">
                                <b>TANGGAL : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> </b>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="2" style="border: none;text-transform: uppercase">
                                <b>SUKPA : <?=$unit_kerja?></b>
                            </td>
                            <td style="border: none;">&nbsp;</td>
                            <td colspan="3" style="border-left: none;border-top: none;border-bottom: none;text-transform: uppercase">
                                <b>UNIT KERJA : <?=$unit_kerja?></b>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="7" style="border-top: none;border-bottom: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-right: none;border-top: none;">
                                <ol>
                                    <li>Nomor dan tanggal SPK / Kontrak </li>
                                    <li>Nilai SPK / Kontrak </li>
                                    <li>Total nilai SPK / Kontrak yang terbayar</li>
                                    <li>Termin pembayaran saat ini</li>
                                    <li>Jenis kegiatan</li>
                                    <li>Nomer / tanggal berita acara pembayaran</li>
                                    <li>Nomer / tanggal berita acara penerimaan barang</li>
                                    <li>Rincian pembebanan belanja</li>
                                </ol>
                            </td>
                            <td colspan="5" style="border-left: none;border-top: none;">
                                <ol style="list-style: none;">
                                    <li>: -</li>
                                    <li>: -</li>
                                    <li>: -</li>
                                    <li>: Lunas</li>
                                    <li>: Non Fisik</li>
                                    <li>: Terlampir</li>
                                    <li>: Terlampir</li>
                                    <li>:</li>
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" rowspan="2" style="width: 50px;">NO</td>
                            <td class="text-center">KEGIATAN DAN AKUN</td>
                            <td class="text-center">PAGU DALAM RKAT<br>( Rp )</td>
                            <td class="text-center">SPP/SPM S.D.<br>YANG LALU( Rp )</td>
                            <td class="text-center">SPP INI<br>( Rp )</td>
                            <td class="text-center">JUMLAH S.D.<br>SPP INI( Rp )</td>
                            <td class="text-center">SISA DANA<br>( Rp )</td>
                        </tr>
                        <tr>
                            <td class="text-center">a</td>
                            <td class="text-center">b</td>
                            <td class="text-center">c</td>
                            <td class="text-center">d</td>
                            <td class="text-center">e = c + d</td>
                            <td class="text-center">f = b - e</td>
                        </tr>
                        
                        <?php $jml_pengeluaran = 0; ?>
                        <?php $sub_kegiatan = '' ; ?>
                        <?php $i = 1 ; ?>
                        <?php if(!empty($data_akun_pengeluaran)): ?>
                        <?php foreach($data_akun_pengeluaran as $data):?>
                        <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                         <tr>
                            <td class="text-center"><?=$i?></td>
                            <td style="padding-left: 10px;">
                                 <b><?=$data->nama_subkomponen?></b>
                            </td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                         </tr>
                        <?php $pagu_rkat = 0 ;?>
                        <?php $jml_spm_lalu = 0 ;?>
                        <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                        <?php $i = $i + 1 ; ?> 
                        <?php endif; ?>
                            <tr>
                                <td class="text-center">&nbsp;</td>
                                <td style="padding-left: 10px;"><?=$data->nama_akun5digit?></td>
                                <?php if(!empty($data_akun_rkat)):?> 
                                    <?php foreach($data_akun_rkat as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->pagu_rkat, 0, ",", ".")?></td>
                                            <?php $pagu_rkat =  $da->pagu_rkat ;?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $pagu_rkat =  0 ;?>
                                <?php endif;?>
                                <?php $empty_pengeluaran_lalu = false ; ?>
                                <?php if(!empty($data_akun_pengeluaran_lalu)): ?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php $empty_pengeluaran_lalu = true ; ?>
                                            <?php endif;?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif;?>
                                <?php if(!$empty_pengeluaran_lalu): ?> 
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style="padding-right: 10px;">
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style="padding-right: 10px;"><?php echo number_format(($jml_spm_lalu + $data->pengeluaran), 0, ",", "."); ?></td>
                                <td class="text-right" style="padding-right: 10px;"><?php echo number_format(($pagu_rkat - ($jml_spm_lalu + $data->pengeluaran)), 0, ",", "."); ?></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="7">- data kosong -</td>
                        </tr>
                        <?php endif; ?>
<!--                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>-->
                        <tr>
                            <td class="text-center" colspan="4">Total Nilai ( Rp )</td>
                            <td class="text-right" style="padding-right: 10px;"><?=number_format($jml_pengeluaran, 0, ",", ".")?></td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="" style="border-right:none;" colspan="2">
                                <ol start="9" style="">
                                    <li>Laporan keluaran kegiatan non fisik</li>
                                </ol>
                            </td>
                            <td class="text-left" style="border-left: none; border-right:none;" colspan="2" >
                                <ol style="list-style: none;margin: 10px;"> 
                                    <li>: </li>
                                </ol>
                            </td>
                            <td colspan="3" style="border-bottom: none;border-left: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" rowspan="2">NO</td>
                            <td class="text-center" >RINCIAN KELUARAN YANG<br>DIHASILKAN PER KEGIATAN</td>
                            <td class="text-center" >VOLUME<br>KUANTITAS</td>
                            <td class="text-center" >SATUAN<br>VOLUME</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" >a</td>
                            <td class="text-center" >b</td>
                            <td class="text-center" >c</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php $i = 1; ?>
                        <?php $sub_kegiatan = '' ; ?>
                        <?php if(!empty($data_akun_pengeluaran)): ?>
                        <?php // var_dump($data_akun_pengeluaran); die; ?>
                        <?php foreach($data_akun_pengeluaran as $data):?> 
                        <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                        <tr>
                            <td class="text-center" ><?=$i?></td>
                            <td style="padding-left: 10px;"><b><?=$data->nama_subkomponen?></b></td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php if(!empty($rincian_keluaran)): ?>
                        <?php foreach($rincian_keluaran as $kel):?> 
                        <?php if($kel->kode_usulan_rka == $data->rka):?>
                        <tr class="keluaran_<?=$data->rka?>">
                            <td class="text-center" >&nbsp;</td>
                            <td style="padding-left: 10px;"><?=$kel->keluaran?></td>
                            <td class="text-center"><?=$kel->volume?></td>
                            <td class="text-center"><?=$kel->satuan?></td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach;?>
                        <?php else: ?>
                        <tr class="keluaran_<?=$data->rka?>">
                            <td class="text-center" >&nbsp;</td>
                            <td style="padding-left: 10px;" class="td_zonk">[ <a href="#" rel="<?=$data->rka?>" id="" class="a_tambah_keluaran">tambah</a> ]</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php endif; ?>
                        <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                        <?php $i = $i + 1 ; ?> 
                        <?php endif; ?>
                        <?php endforeach;?>
                        <?php else: ?>
                        
                                    <tr>
                                        <td class="text-center" colspan="4">- data kosong -</td>
                                        <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                                     </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="4" style="height: 50px;border-right:none;border-bottom: none;">&nbsp;</td>
                            <td class="text-center" colspan="3" style="height: 50px;border-left:none;border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="border-right:none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="3" style="border-left:none;border-top: none;border-bottom: none;">
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
                                Bendahara Pengeluaran SUKPA<br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <span ><?=isset($detail_pic->nmbendahara)?$detail_pic->nmbendahara:''?></span><br>
                                NIP. <span ><?=isset($detail_pic->nipbendahara)?$detail_pic->nipbendahara:''?></span><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="7" style="border-top: none;">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
</div>
</div>
 
</div>

    
<!-- Left and right controls -->
<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev" style="background-image: none;width: 25px;">
  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next" style="background-image: none;width: 25px;">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Next</span>
</a>

</div>
    
</div>
<br />
      
      </div>

<div role="tabpanel" class="tab-pane" id="lampiran">
          <div style="background-color: #EEE; padding: 10px;">
            <div id="myCarouselLampiran" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner" role="listbox">
<div class="item active" id="c">
<div id="div-cetak-lampiran-spj">
            <table id="table_spj" class="table_lamp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                                <td colspan="6" class="text-center" style="text-align: center;border: none;">
                                    <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
                                    <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                    <h5><b>SURAT PERTANGGUNGJAWABAN UANG PERSEDIAAN BENDAHARA PENGELUARAN</b></h5>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border: none;">&nbsp;</td>
                                <td colspan="2" style="text-transform: uppercase;border: none;"><b>SUKPA : <?=$unit_kerja?></b></td>
                                <td colspan="2" style="text-transform: uppercase;border: none;"><b>UNIT KERJA : <?=$unit_kerja?></b></td>
                            </tr>
                            <tr>
                                <td style="border-top:none;" colspan="6">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 50px;">NO</td>
                                <td class="text-center">KODE SUB KEGIATAN<br>/ RINCIAN AKUN</td>
                                <td class="text-center">URAIAN</td>
                                <td class="text-center">SPJ GUP s.d BULAN LALU<br>( Rp )</td>
                                <td class="text-center">SPJ GUP BULAN INI<br>( Rp )</td>
                                <td class="text-center">SPJ GUP s.d BULAN INI<br>( Rp )</td>
                            </tr>
                            <tr >
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                            </tr>
                        <?php $jml_pengeluaran = 0; ?>
                        <?php $sub_kegiatan = '' ; ?>
                        <?php $i = 1 ; ?>
                        <?php if(!empty($data_akun_pengeluaran)): ?>
                        <?php foreach($data_akun_pengeluaran as $data):?>
                        <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                         <tr>
                            <td class="text-center"><?=$i?></td>
                            <td class="text-center">&nbsp;</td>
                            <td style="padding-left: 10px;">
                                 <b><?=$data->nama_subkomponen?></b>
                            </td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                         </tr>
                        <?php $pagu_rkat = 0 ;?>
                        <?php $jml_spm_lalu = 0 ;?>
                        <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                        <?php $i = $i + 1 ; ?> 
                        <?php endif; ?>
                            <tr>
                                <td class="text-center">&nbsp;</td>
                                <td class="text-center"><?=$data->kode_akun5digit?></td>
                                <td style="padding-left: 10px;"><?=$data->nama_akun5digit?></td>
                                <?php $empty_pengeluaran_lalu = false ; ?>
                                <?php if(!empty($data_akun_pengeluaran_lalu)):?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php $empty_pengeluaran_lalu = true ; ?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php endif;?>
                                <?php if(!$empty_pengeluaran_lalu): ?> 
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style="padding-right: 10px;">
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style="padding-right: 10px;"><?php echo number_format(($jml_spm_lalu + $data->pengeluaran), 0, ",", "."); ?></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="6">- data kosong -</td>
                        </tr>
                        <?php endif; ?>
<!--                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>-->
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-right" style="padding-right: 10px;"><?=number_format($jml_pengeluaran, 0, ",", ".")?></td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="6" style="border-bottom: none;border-right: none;border-left: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="border : none;"><b>Potongan :</b></td>
                        </tr>
                        <?php $tot_pajak_ = 0 ; ?>
                        <?php $n = 1 ; ?>
                        <?php if(!empty($data_spp_pajak)): ?>
                        <?php foreach($data_spp_pajak as $data):?>
                        <tr>
                            <td class="text-center" style="border:none;">
                                <?php echo $n; ?>
                            </td>
                                <td style="border:none;">
                                        <?php 
                                        if($data->jenis == 'PPN'){
                                                echo 'Pajak Pertambahan Nilai';
                                        }elseif($data->jenis == 'PPh'){
                                                echo 'Pajak Penghasilan';
                                        }else{
                                                echo 'Lainnya';
                                        }
                                        ?>
                                </td>
                                <td style="border:none;" class="text-right">
                                        <?php $tot_pajak_ = $tot_pajak_ + $data->rupiah ?>
                                        Rp. <?=number_format($data->rupiah, 0, ",", ".")?>
                                </td>
                                <td class="text-center" colspan="3" style="border: none;">&nbsp;</td>
                        </tr>
                        <?php $n++; ?>
                        <?php endforeach;?>
                        <?php else: ?>
                        <tr>
                               <td class="text-center" colspan="3" style="border: none;">&nbsp;</td>
                               <td class="text-center" colspan="3" style="border: none;">&nbsp;</td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                               <td class="text-center" colspan="2" style="border: none;">&nbsp;</td>
                               <td style="border-top: none;border-right: none;border-left: none;">&nbsp;</td>
                               <td class="text-center" colspan="3" style="border: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border : none;"><b>Total Potongan :</b></td>
                            <td style="border : none;" class="text-right">
                                    Rp. <?=number_format($tot_pajak_, 0, ",", ".")?>
                            </td>
                            <td colspan="3" style="border: none">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="border: none">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none;">&nbsp;</td>
                            <td colspan="2" style="border: none;">
                                Telah diperiksa kebenarannya oleh,<br>
                                PPK SUKPA<br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <span ><?=isset($detail_ppk->nm_lengkap)?$detail_ppk->nm_lengkap:''?></span><br>
                                NIP. <span ><?=isset($detail_ppk->nomor_induk)?$detail_ppk->nomor_induk:''?></span><br>
                            </td>
                            <td colspan="2" style="border: none;">
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
                                Bendahara Pengeluaran SUKPA<br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <span ><?=isset($detail_pic->nmbendahara)?$detail_pic->nmbendahara:''?></span><br>
                                NIP. <span ><?=isset($detail_pic->nipbendahara)?$detail_pic->nipbendahara:''?></span><br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="border: none">&nbsp;</td>
                        </tr>
                    </tbody>
            </table>
</div>
</div>
<div class="item" id="d">
    <div class="free dragscroll" style="overflow-x: scroll;width: 900px;margin: 0 auto;cursor: pointer;">
        <div id="div-cetak-lampiran-rekapakun">
    
                 
            <table id="table_rekapakun" class="table_lamp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 1200px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                                <td colspan="13" class="text-center" style="text-align: center;border: none;">
                                    <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                    <h5>REKAPITULASI PERTANGGUNGJAWABAN PENGELUARAN</h5>
                                    <h5><b>SETIAP SUB KEGIATAN PER RINCIAN AKUN</b></h5>
                                    <b style="text-transform: uppercase;">SUKPA : <?=$unit_kerja?> <span style="display: inline-block;width: 100px;">&nbsp;</span> UNIT KERJA : <?=$unit_kerja?></b><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13" style="border: none;">&nbsp;</td>
                            </tr>
                            <?php $jk = 1; ?>
                            <?php if(!empty($data_akun_pengeluaran)): ?>
                            <?php foreach($data_akun_pengeluaran as $data):?>       
                            <tr >
                                <td colspan="13" class="text-center" style="text-align: center;border: none;">
                                    <b style="text-transform: uppercase;">KEGIATAN : <?=$data->nama_komponen?> </b><br>
                                    <b style="text-transform: uppercase;">SUB KEGIATAN : <?=$data->nama_subkomponen?> </b><br>
                                    <b style="text-transform: uppercase;">KODE AKUN  : <?=$data->kode_akun5digit?> <span style="display: inline-block;width: 100px;">&nbsp;</span> URAIAN AKUN : <?=$data->nama_akun5digit?></b><br>
                                    <b style="text-transform: uppercase;">BULAN  : <?=$bulan?> <span style="display: inline-block;width: 100px;">&nbsp;</span> TAHUN : <?=$cur_tahun?></b><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13" style="border-top: none;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 50px;">NO</td>
                                <td class="text-center" style="width: 100px;">TANGGAL</td>
                                <td class="text-center" style="width: 150px;">RINCIAN AKUN</td>
                                <td class="text-center">KODE RINCIAN<br>AKUN</td>
                                <td class="text-center" style="width: 150px;">KODE-URAIAN RINCIAN<br>AKUN</td>
                                <td class="text-center">NO BUKTI</td>
                                <td class="text-center">PENGELUARAN<br>( Rp )</td>
                                <td class="text-center">KUANTITAS<br>KELUARAN</td>
                                <td class="text-center">SATUAN<br>KELUARAN</td>
                                <td class="text-center" style="width: 150px;">KETERANGAN KELUARAN</td>
                                <td class="text-center" style="width: 100px;">JENIS POT<br>PAJAK</td>
                                <td class="text-center" style="width: 100px;">NILAI POT</td>
                                <td class="text-center" style="width: 100px;">NETTO</td>
                            </tr>
                            <?php $kl = 1 ;?>
                            <?php $tot_bruto = 0 ;?>
                            <?php foreach($rincian_akun_pengeluaran as $rincian): ?>
                            <?php if(($rincian->rka == $data->rka)&&($rincian->kode_akun5digit == $data->kode_akun5digit)):?>
                            <tr>
                                <td class="text-center" style="vertical-align: top"><?=$kl?></td>
                                <td class="text-center" style="vertical-align: top"><?php echo strftime("%d-%m-%Y", strtotime($rincian->tgl_kuitansi)) ;?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->nama_akun?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->kode_akun?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->kode_akun_tambah?> - <?=$rincian->deskripsi?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->no_bukti?></td>
                                <td class="text-right" style="vertical-align: top;padding-right: 10px;"><?=number_format(($rincian->volume*$rincian->harga_satuan), 0, ",", ".")?></td>
                                <td class="text-center" style="vertical-align: top"><?=$rincian->volume?></td>
                                <td class="text-center" style="vertical-align: top;"><?=$rincian->satuan?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->uraian?></td>
                                <td class="text-left" style="vertical-align: top;padding-left: 10px;"><?=$rincian->pajak_nom?></td>
                                <td class="text-right" style="vertical-align: top;padding-right: 10px;"><?=number_format($rincian->total_pajak, 0, ",", ".")?></td>
                                <td class="text-right" style="vertical-align: top;padding-right: 10px;"><?=number_format(($rincian->bruto-$rincian->total_pajak), 0, ",", ".")?></td>
                                <?php $tot_bruto = $tot_bruto + $rincian->bruto ;?>
                            </tr>
                            <?php $kl++ ; ?>
                            <?php endif;?>
                            <?php endforeach;?>
                            <tr>
                                <td colspan="6" style="border-bottom: none; padding-left: 10px;"><b>Total Pengeluaran</b></td>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format($tot_bruto, 0, ",", ".")?></td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="13" style="border-bottom: none;">&nbsp;</td>
                            </tr>
                            <?php endforeach;?>
                            <?php else: ?>
                            <tr>
                                <td class="text-center" colspan="13">- data kosong -</td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="9" style="border-bottom: none;border-top: none;border-right:none;">&nbsp;</td>
                                <td colspan="4" style="border-bottom: none;border-top: none;border-left:none;">
                                    Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo !isset($tgl_spp)?'':strftime("%d %B %Y", strtotime($tgl_spp)); //  ?> <br>
                                    Bendahara Pengeluaran SUKPA<br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <span ><?=isset($detail_pic->nmbendahara)?$detail_pic->nmbendahara:''?></span><br>
                                    NIP. <span ><?=isset($detail_pic->nipbendahara)?$detail_pic->nipbendahara:''?></span><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13" style="border-top: none;">&nbsp;</td>
                            </tr>
                    </tbody>
            </table>
    </div>
</div>
</div>
                </div>
                
<!-- Left and right controls -->
<a class="left carousel-control" href="#myCarouselLampiran" role="button" data-slide="prev" style="background-image: none;width: 25px;">
  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarouselLampiran" role="button" data-slide="next" style="background-image: none;width: 25px;">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Next</span>
</a>
                
            </div>
          </div>
          <br />
          
          
      </div>
<div role="tabpanel" class="tab-pane" id="spm">
    <div style="background-color: #EEE; padding: 10px;">
    <div id="myCarouselSPM" class="carousel slide" data-ride="carousel" data-interval="false">
    <div class="carousel-inner" role="listbox">
    <div class="item active" id="e">
    <div id="div-cetak-2">
        <table id="table_spp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
            <tbody>
                <tr>
                    <td colspan="5" style="text-align: right;font-size: 30px;padding: 10px;"><b>F2</b></td>
                </tr>
                
                <tr>
                    <td colspan="5" style="text-align: center;padding-top: 5px;padding-bottom: 5px;"><img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60"></td>
                </tr>
                
                <tr style="">
                    <td colspan="5" style="text-align: center;font-size: 20px;border-bottom: none;"><b>UNIVERSITAS DIPONEGORO</b></td>
                </tr>
                
                <tr style="border-top: none;">
                    <td colspan="5" style="text-align: center;font-size: 16px;border-bottom: none;border-top: none;"><b>SURAT PERINTAH MEMBAYAR</b></td>
                </tr>
                <tr style="border-top: none;border-bottom: none;">
                <td colspan="2" style="border-right: none;border-right: none;border-top: none;border-bottom: none;"><b>TAHUN ANGGARAN : <?=$cur_tahun_spm?></b></td>
                <td style="text-align: center;border-right: none;border-left: none;border-top: none;border-bottom: none;" colspan="2">&nbsp;</td>
                <td style="border-left: none;border-top: none;border-bottom: none;"><b>JENIS : GUP</b></td>
                </tr>
                <tr style="border-top: none;">
                <td colspan="2" style="border-right: none;border-top:none;"><b>Tanggal  : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm==''?'':strftime("%d %B %Y", strtotime($tgl_spm)); ?></td>
                <td style="text-align: center;border-left: none;border-right: none;border-top:none;" colspan="2" >&nbsp;</td>
                <td style="border-left: none;border-top:none;"><b>Nomor : <span id="nomor_trx_spm"><?=$nomor_spm?></span><!--01/<?=$alias?>/SPM-UP/JAN/<?=$cur_tahun?>--></b></td>
                </tr>
                <tr >
                <td colspan="5"><b>Satuan Unit Kerja Pengguna Anggaran (SUKPA) : <?=$unit_kerja?></b></td>
                </tr>
                <tr >
                <td colspan="5"><b>Unit Kerja : <?=$unit_kerja?> &nbsp;&nbsp; Kode Unit Kerja : <?=$unit_id?></b></td>
                </tr>
                <tr style="border-bottom: none;">

                <td colspan="4" style="border-right: none;border-bottom: none;">&nbsp;</td>
                <td style="line-height: 16px;border-left: none;border-bottom: none;">Kepada Yth.<br>
                Bendahara Umum Undip ( BUU )<br>
                di Semarang
                </td>
                </tr>
                <tr >
                <td colspan="5" style="border-bottom: none;border-top: none;">&nbsp;</td>
                </tr>
                <tr >
                <td colspan="5" style="border-bottom: none;border-top: none;">Dengan Berpedoman pada Dokumen SPP yang disampaikan bendahara pengeluaran dan telah diteliti keabsahan dan kebenarannya oleh PPK-SUKPA. bersama ini kami memerintahkan kepada Kuasa BUU untuk membayar sebagai berikut :
                </tr>
                <tr>
                <td colspan="5" style="line-height: 16px;border-bottom: none;border-top: none;">
                <ol style="list-style-type: lower-alpha;margin-top: 0px;margin-bottom: 0px;" >
                <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar"><?php echo isset($detail_gup_spm['nom'])?number_format($detail_gup_spm['nom'], 0, ",", "."):''; ?></span>,-<br>
                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang"><?php echo isset($detail_gup_spm['terbilang'])?ucwords($detail_gup_spm['terbilang']):''; ?></span></b>)</li>
                <li>Untuk keperluan : <span id="untuk_bayar"><?=isset($detail_pic->untuk_bayar)?$detail_pic->untuk_bayar:''?></span></li>
                <li>Nama bendahara pengeluaran : <span id="penerima"><?=isset($detail_pic->penerima)?$detail_pic->penerima:''?></span></li>
                <li>Alamat : <span id="alamat"><?=isset($detail_pic->alamat_penerima)?$detail_pic->alamat_penerima:''?></span></li>
                <li>Nama Bank : <span id="nmbank"><?=isset($detail_pic->nama_bank_penerima)?$detail_pic->nama_bank_penerima:''?></span></li>
                <li>No. Rekening Bank : <span id="rekening"><?=isset($detail_pic->no_rek_penerima)?$detail_pic->no_rek_penerima:''?></span></li>
                <li>No. NPWP : <span id="npwp"><?=isset($detail_pic->npwp_penerima)?$detail_pic->npwp_penerima:''?></span></li>
                </ol>
                </td>
                </tr>


                <tr>
                <td colspan="5" style="border-top: none;border-bottom:none;">
                Pembayaran sebagaimana tersebut diatas, dibebankan pada pengeluaran dengan uraian sebagai berikut :<br>                         
                </td>


                </tr>

                <tr >
                <td colspan="3" style="vertical-align: top;border-bottom: none;border-top:none;padding-left: 0;">
                <table style="font-family:arial;font-size:12px;line-height: 21px;border-collapse: collapse;width: 100%;border: 1px solid #000;background-color: #FFF;border-left: none;border-right:none;" cellspacing="0" border="1" cellpadding="0">
                <tr>
                <td style="text-align: center" colspan="3"><b>PENGELUARAN</b></td>
                </tr>
                <tr>
                <td style="border-right: solid 1px #000;text-align: center;">NAMA AKUN</td>
                <td style="border-right: solid 1px #000;text-align: center;">KODE AKUN</td>
                <td style="text-align: center;">JUMLAH UANG</td>
                </tr>
                <?php $jml_pengeluaran = 0; ?>
                <?php $sub_kegiatan = '' ; ?>
                <?php if(!empty($data_akun_pengeluaran)): ?>
                <?php foreach($data_akun_pengeluaran as $data):?>
                <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                <tr>
                <td colspan="3">
                 <b><?=$data->nama_subkomponen?></b>
                </td>
                </tr>
                <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                <?php endif; ?>
                <tr>
                <td style="border-right: solid 1px #000">
                        <?=$data->nama_akun5digit?>
                </td>
                <td  style="text-align: center;border-right: solid 1px #000;">
                        <?=$data->kode_akun5digit?>
                </td>
                <td style="text-align: right;">
                        <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                        Rp. <?=number_format($data->pengeluaran, 0, ",", ".")?>
                </td>
                </tr>
                <?php endforeach;?>
                <?php else: ?>
                <tr>
                <td style="border-right: solid 1px #000">
                        &nbsp;
                </td>
                <td  style="text-align: center;border-right: solid 1px #000;">
                        &nbsp;
                </td>
                <td style="text-align: right;">
                        Rp. 0
                </td>
                </tr>
                <?php endif; ?>
                <tr>
                <td colspan="2" style="border-right: solid 1px #000">
                Jumlah Pengeluaran
                </td>
                <td  style="text-align: right;">
                    Rp. <?=number_format($jml_pengeluaran, 0, ",", ".")?>
                </td>
                </tr>
                <tr>
                <td colspan="2" style="border-right: solid 1px #000">
                Dikurangi : Jumlah potongan untuk pihak lain
                </td>
                <td  style="text-align: right;">
                <?php $tot_pajak__ = 0 ; 
                if(!empty($data_spp_pajak)){
                    foreach($data_spp_pajak as $data){
                       $tot_pajak__ = $tot_pajak__ + $data->rupiah ;
                    }
                } ?>
                    Rp. <?=number_format($tot_pajak__, 0, ",", ".")?>
                </td>
                </tr>
                <td colspan="2" style="border-right: solid 1px #000">
                <strong>Jumlah dana yang dikeluarkan</strong>
                </td>
                <td  style="text-align: right;">
                Rp. <?=number_format(($jml_pengeluaran - $tot_pajak__), 0, ",", ".")?>
                </td>
                </table>
                </td>
                <td colspan="2" style="vertical-align: top;border-bottom: none;border-top:none;padding-right: 0;">
                <table style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 100%;border: 1px solid #000;background-color: #FFF;border-left: none;border-right:none;" cellspacing="0" border="1" cellpadding="0">
                <tr>
                <td style="text-align: center" colspan="2"><b>PERHITUNGAN TERKAIT PIHAK LAIN</b></td>
                </tr>
                <tr>
                <td style="text-align: center" colspan="2">PENERIMAAN DARI PIHAK KE-3</td>
                </tr>
                <tr>
                <td style="border-right: solid 1px #000;width: 50%;text-align: center;">Akun</td>
                <td style="width: 50%;text-align: center;">Jumlah Uang</td>
                </tr>
                <tr>
                <td style="border-right: solid 1px #000;text-align: center;">-</td>
                <td style="text-align: right;">Rp. 0</td>
                </tr>
                <tr>
                <td style="border-right: solid 1px #000;"><b>Jumlah Penerimaan</b></td>
                <td  style="text-align: right;">Rp. 0</td>
                </tr>
                <tr>
                <td colspan="2" style="text-align: center">
                    POTONGAN UNTUK PIHAK LAIN
                </td>
                </tr>
                <tr>
                <td style="text-align: center;border-right: solid 1px #000;">
                        Akun Pajak dan Potongan Lainnya
                </td>
                <td style="text-align: center">
                        Jumlah Uang
                </td>
                </tr>
                <?php $tot_pajak_ = 0 ; ?>
                <?php if(!empty($data_spp_pajak)): ?>
                <?php foreach($data_spp_pajak as $data):?>
                <tr>
                <td style="border-right: solid 1px #000;">
                        <?php 
                        if($data->jenis == 'PPN'){
                                echo 'Pajak Pertambahan Nilai';
                        }elseif($data->jenis == 'PPh'){
                                echo 'Pajak Penghasilan';
                        }else{
                                echo 'Lainnya';
                        }
                        ?>
                </td>
                <td  style="text-align: right;">
                        <?php $tot_pajak_ = $tot_pajak_ + $data->rupiah ?>
                        Rp. <?=number_format($data->rupiah, 0, ",", ".")?>
                </td>
                </tr>
                <?php endforeach;?>
                <?php else: ?>
                <tr>
                <td style="border-right: solid 1px #000;">
                        &nbsp;
                </td>
                <td  style="text-align: right;">
                        &nbsp;
                </td>
                </tr>
                <?php endif; ?>
                <tr>
                <td style="border-right: solid 1px #000;">
                    <b>Jumlah Potongan</b>
                </td>
                <td  style="text-align: right;">
                    Rp. <?=number_format($tot_pajak_, 0, ",", ".")?>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr >
                <td colspan="5" style="border-bottom: none;border-top: none;">&nbsp;</td>
                </tr>

                <tr style="border-bottom: none;">
                <td colspan="5" style="line-height: 16px;border-bottom: none;border-top:none;">
                Surat Perintah Membayar ( SPM ) Sebagaimana dimaksud diatas, disusun sesuai dengan dokumen lampiran yang persyaratkan dan disampaikan secara bersamaan serta merupakan bagian yang tidak terpisahkan dari surat ini.<br><br>                                                        
                </td>
                <tr>
                <tr style="border-top: none;"> 

                <td colspan="3" style="line-height: 16px;border-right: none;border-top:none;">
                Dokumen SPM, dan lampirannya telah diverifikasi keabsahannya<br>
                PPK-SUKPA<br>
                <br>
                <br>
                <br>
                <br>
                <span id="nmppk"><?=isset($detail_ppk->nm_lengkap)?$detail_ppk->nm_lengkap:''?></span><br>
                NIP. <span id="nipppk"><?=isset($detail_ppk->nomor_induk)?$detail_ppk->nomor_induk:''?></span><br>
                </td>

                <td  style="border-left: none;border-right: none;border-top:none;">&nbsp;</td>
                <td  style="line-height: 16px;border-left: none;border-top:none;">
                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm_kpa==''?'':strftime("%d %B %Y", strtotime($tgl_spm_kpa)); ?><br />
                Kuasa Pengguna Anggaran<br>
                <br>
                <br>
                <br>
                <br>
                <span id="nmkpa"><?=isset($detail_kpa->nm_lengkap)?$detail_kpa->nm_lengkap:''?></span><br>
                NIP. <span id="nipkpa"><?=isset($detail_kpa->nomor_induk)?$detail_kpa->nomor_induk:''?></span><br>
                </td>
                </tr>
                <tr>
                <td colspan="5"  style="line-height: 16px;">
                <strong>Keterangan:</strong>
                <ul>
                <li>Semua bukti pengeluaran untuk pekerjaan dengan perjanjian yang disahkan Pejabat Pembuat Komitmen telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan Keuangan SUKPA</li>
                <li>Semua bukti-bukti pengeluaran untuk pekerjaan yang disahkan Pejabat Pelaksana dan Pengendali Kegiatan (PPPK) telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan SUKPA.</li>
                <li>Kebenaran perhitungan dan isi tertuang dalam SPP ini menjadi tanggung jawab Bendahara Pengeluaran sepanjang sesuai dengan bukti-bukti pengeluaran yang telah ditandatangani oleh PPPK atau PPK</li>
                </ul>
                </td>
                </tr>
                <tr>
                <td colspan="2" style="vertical-align: top;line-height: 16px;">
                Dokumen SPM. dan Lampirannya telah <br>
                diverifikasi kelengkapannya<br>
                Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm_verifikator==''?'':strftime("%d %B %Y", strtotime($tgl_spm_verifikator)); ?><br />
                <br>
                <br>
                <br>
                <br>
                <span id="nmverifikator"><?php echo isset($detail_verifikator->nm_lengkap)? $detail_verifikator->nm_lengkap : '' ; ?></span><br>
                NIP. <span id="nipverifikator"><?php echo isset($detail_verifikator->nomor_induk)? $detail_verifikator->nomor_induk : '' ;?></span><br>
                </td>
                <td colspan="2" style="vertical-align: top;line-height: 16px;padding-left: 10px;">
                <?php if(isset($detail_gup_spm['nom'])){ ?>
                <?php if($detail_gup_spm['nom'] >= 100000000){ ?>
                Setuju dibayar : <br>
                Kuasa Bendahara Umum Undip harap membayar<br>
                kepada nama yang tersebut sesuai SPM dari KPA<br>
                Bendahara Umum Undip<br>
                <br>
                <br>
                <br>
                <span id="nmbuu"><?=$detail_buu->nm_lengkap?></span><br>
                NIP. <span id="nipbuu"><?=$detail_buu->nomor_induk?></span><br>
                <?php }else{ ?>
                <span style="display: inline-block;width: 280px;">&nbsp;</span>
                <?php } ?>
                <?php }else{ ?>
                <span style="display: inline-block;width: 280px;">&nbsp;</span>
                <?php } ?>
                </td>
                <td style="vertical-align: top;line-height: 16px;padding-left: 10px;">
                Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm_kbuu==''?'':strftime("%d %B %Y", strtotime($tgl_spm_kbuu)); ?><br />
                Telah dibayar oleh <br>
                Kuasa Bendahara Umum Undip<br>
                <br>
                <br>
                <br>
                <br>
                <span id="nmkbuu"><?php echo isset($detail_kuasa_buu->nm_lengkap)?$detail_kuasa_buu->nm_lengkap:''; ?></span><br>
                NIP. <span id="nipkbuu"><?php echo isset($detail_kuasa_buu->nomor_induk)?$detail_kuasa_buu->nomor_induk:'';?></span><br>
                </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="item" id="f">
<div id="div-cetak-f1a-2">
                <table id="table_f1a" class="table_lamp" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 900px;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
                    <tbody>
                            <tr >
                                <td colspan="7" style="text-align: right;font-size: 30px;padding: 10px;"><b>F2A</b></td>
                            </tr>
                            <tr >
                            <td colspan="7" style="text-align: center;border-bottom: none;">
                                <img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
                                <h4><b>UNIVERSITAS DIPONEGORO</b></h4>
                                <h5><b>RINCIAN SURAT PERINTAH MEMBAYAR GUP</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="2" style="border: none;">
                                <b>NO SPM : <?=$nomor_spm?></b>
                            </td>
                            <td style="border: none;">&nbsp;</td>
                            <td colspan="3" style="border-left: none;border-top: none;border-bottom: none;">
                                <b>TANGGAL : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm==''?'':strftime("%d %B %Y", strtotime($tgl_spm)); ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="2" style="border: none;text-transform: uppercase">
                                <b>SUKPA : <?=$unit_kerja?></b>
                            </td>
                            <td style="border: none;">&nbsp;</td>
                            <td colspan="3" style="border-left: none;border-top: none;border-bottom: none;text-transform: uppercase">
                                <b>UNIT KERJA : <?=$unit_kerja?></b>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="7" style="border-top: none;border-bottom: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-right: none;border-top: none;">
                                <ol>
                                    <li>Nomor dan tanggal SPK / Kontrak </li>
                                    <li>Nilai SPK / Kontrak </li>
                                    <li>Total nilai SPK / Kontrak yang terbayar</li>
                                    <li>Termin pembayaran saat ini</li>
                                    <li>Jenis kegiatan</li>
                                    <li>Nomer / tanggal berita acara pembayaran</li>
                                    <li>Nomer / tanggal berita acara penerimaan barang</li>
                                    <li>Rincian pembebanan belanja</li>
                                </ol>
                            </td>
                            <td colspan="5" style="border-left: none;border-top: none;">
                                <ol style="list-style: none;">
                                    <li>: -</li>
                                    <li>: -</li>
                                    <li>: -</li>
                                    <li>: Lunas</li>
                                    <li>: Non Fisik</li>
                                    <li>: Terlampir</li>
                                    <li>: Terlampir</li>
                                    <li>:</li>
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" rowspan="2" style="width: 50px;">NO</td>
                            <td class="text-center">KEGIATAN DAN AKUN</td>
                            <td class="text-center">PAGU DALAM RKAT<br>( Rp )</td>
                            <td class="text-center">SPP/SPM S.D.<br>YANG LALU( Rp )</td>
                            <td class="text-center">SPP INI<br>( Rp )</td>
                            <td class="text-center">JUMLAH S.D.<br>SPP INI( Rp )</td>
                            <td class="text-center">SISA DANA<br>( Rp )</td>
                        </tr>
                        <tr>
                            <td class="text-center">a</td>
                            <td class="text-center">b</td>
                            <td class="text-center">c</td>
                            <td class="text-center">d</td>
                            <td class="text-center">e = c + d</td>
                            <td class="text-center">f = b - e</td>
                        </tr>
                        
                        <?php $jml_pengeluaran = 0; ?>
                        <?php $sub_kegiatan = '' ; ?>
                        <?php $i = 1 ; ?>
                        <?php if(!empty($data_akun_pengeluaran)): ?>
                        <?php foreach($data_akun_pengeluaran as $data):?>
                        <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                         <tr>
                            <td class="text-center"><?=$i?></td>
                            <td style="padding-left: 10px;">
                                 <b><?=$data->nama_subkomponen?></b>
                            </td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                         </tr>
                        <?php $pagu_rkat = 0 ;?>
                        <?php $jml_spm_lalu = 0 ;?>
                        <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                        <?php $i = $i + 1 ; ?> 
                        <?php endif; ?>
                            <tr>
                                <td class="text-center">&nbsp;</td>
                                <td style="padding-left: 10px;"><?=$data->nama_akun5digit?></td>
                                <?php if(!empty($data_akun_rkat)):?> 
                                    <?php foreach($data_akun_rkat as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->pagu_rkat, 0, ",", ".")?></td>
                                            <?php $pagu_rkat =  $da->pagu_rkat ;?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $pagu_rkat =  0 ;?>
                                <?php endif;?>
                                <?php $empty_pengeluaran_lalu = false ; ?>
                                <?php if(!empty($data_akun_pengeluaran_lalu)): ?> 
                                    <?php foreach($data_akun_pengeluaran_lalu as $da): ?>
                                        <?php if($da->kode_usulan_rkat == $data->kode_usulan_rkat):?> 
                                            <?php if($da->kode_akun5digit == $data->kode_akun5digit):?>
                                            <td class="text-right" style="padding-right: 10px;"><?=number_format($da->jml_spm_lalu, 0, ",", ".")?></td>
                                            <?php $jml_spm_lalu =  $da->jml_spm_lalu ;?>
                                            <?php $empty_pengeluaran_lalu = true ; ?>
                                            <?php endif;?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif;?>
                                <?php if(!$empty_pengeluaran_lalu): ?> 
                                <td class="text-right" style="padding-right: 10px;"><?=number_format('0', 0, ",", ".")?></td>
                                <?php $jml_spm_lalu =  0 ;?>
                                <?php endif;?>
                                <td class="text-right" style="padding-right: 10px;">
                                    <?php $jml_pengeluaran = $jml_pengeluaran + $data->pengeluaran ; ?>
                                    <?=number_format($data->pengeluaran, 0, ",", ".")?>
                                </td>
                                <td class="text-right" style="padding-right: 10px;"><?php echo number_format(($jml_spm_lalu + $data->pengeluaran), 0, ",", "."); ?></td>
                                <td class="text-right" style="padding-right: 10px;"><?php echo number_format(($pagu_rkat - ($jml_spm_lalu + $data->pengeluaran)), 0, ",", "."); ?></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="7">- data kosong -</td>
                        </tr>
                        <?php endif; ?>
<!--                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>-->
                        <tr>
                            <td class="text-center" colspan="4">Total Nilai ( Rp )</td>
                            <td class="text-right" style="padding-right: 10px;"><?=number_format($jml_pengeluaran, 0, ",", ".")?></td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" style="border-right:none;" colspan="2">
                                <ol start="9" style="margin: 10px;">
                                    <li>Laporan keluaran kegiatan non fisik</li>
                                </ol>
                            </td>
                            <td class="text-left" style="border-left: none; border-right:none;" colspan="2" >
                                <ol style="list-style: none;margin: 10px;"> 
                                    <li>: </li>
                                </ol>
                            </td>
                            <td colspan="3" style="border-bottom: none;border-left: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" rowspan="2">NO</td>
                            <td class="text-center" >RINCIAN KELUARAN YANG<br>DIHASILKAN PER KEGIATAN</td>
                            <td class="text-center" >VOLUME<br>KUANTITAS</td>
                            <td class="text-center" >SATUAN<br>VOLUME</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" >a</td>
                            <td class="text-center" >b</td>
                            <td class="text-center" >c</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php $i = 1; ?>
                        <?php $sub_kegiatan = '' ; ?>
                        <?php if(!empty($data_akun_pengeluaran)): ?>
                        <?php // var_dump($data_akun_pengeluaran); die; ?>
                        <?php foreach($data_akun_pengeluaran as $data):?> 
                        <?php if($sub_kegiatan != $data->nama_subkomponen): ?>
                        <tr>
                            <td class="text-center" ><?=$i?></td>
                            <td style="padding-left: 10px;"><b><?=$data->nama_subkomponen?></b></td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php if(!empty($rincian_keluaran)): ?>
                        <?php foreach($rincian_keluaran as $kel):?> 
                        <?php if($kel->kode_usulan_rka == $data->rka):?>
                        <tr class="keluaran_<?=$data->rka?>">
                            <td class="text-center" >&nbsp;</td>
                            <td style="padding-left: 10px;"><?=$kel->keluaran?></td>
                            <td class="text-center"><?=$kel->volume?></td>
                            <td class="text-center"><?=$kel->satuan?></td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach;?>
                        <?php else: ?>
                        <tr class="keluaran_<?=$data->rka?>">
                            <td class="text-center" >&nbsp;</td>
                            <td style="padding-left: 10px;" class="td_zonk">[ <a href="#" rel="<?=$data->rka?>" id="" class="a_tambah_keluaran">tambah</a> ]</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <?php endif; ?>
                        <?php $sub_kegiatan = $data->nama_subkomponen ; ?>
                        <?php $i = $i + 1 ; ?> 
                        <?php endif; ?>
                        <?php endforeach;?>
                        <?php else: ?>
                        
                                    <tr>
                                        <td class="text-center" colspan="4">- data kosong -</td>
                                        <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                                     </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" >&nbsp;</td>
                            <td class="text-center" colspan="3" style="border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="4" style="height: 50px;border-right:none;border-bottom: none;">&nbsp;</td>
                            <td class="text-center" colspan="3" style="height: 50px;border-left:none;border-bottom: none;border-top: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="border-right:none;border-top: none;border-bottom: none;">&nbsp;</td>
                            <td colspan="3" style="border-left:none;border-top: none;border-bottom: none;">
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm==''?'':strftime("%d %B %Y", strtotime($tgl_spm)); ?><br>
                                Bendahara Pengeluaran SUKPA<br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <span ><?=isset($detail_pic->nmbendahara)?$detail_pic->nmbendahara:''?></span><br>
                                NIP. <span ><?=isset($detail_pic->nipbendahara)?$detail_pic->nipbendahara:''?></span><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="7" style="border-top: none;">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
</div>
</div>

</div>

    
<!-- Left and right controls -->
<a class="left carousel-control" href="#myCarouselSPM" role="button" data-slide="prev" style="background-image: none;width: 25px;">
  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarouselSPM" role="button" data-slide="next" style="background-image: none;width: 25px;">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="color: #f00"></span>
  <span class="sr-only">Next</span>
</a>

</div>
    
</div>
<br />

          
      </div>