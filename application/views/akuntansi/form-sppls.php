
                <style type="text/css">
                    .kotak_cetak{
                        border:.5pt solid #000;padding:0;width:595pt;margin-left: auto;margin-right: auto;
                    }
                    .kotak_cetak div,.kotak_cetak table,.kotak_cetak table th,.kotak_cetak table td{
                        font-family: Arial;
                        font-size:8pt;
                        line-height: normal;
                    }
                    .kotak_cetak div{
                        padding:3pt;
                        background-color: #fff;
                    }
                    .kotak{
                        /*display: none;*/
                        width:100%;
                        border-collapse: collapse;
                        /*border-top:1pt solid #000;
                        border-bottom:1pt solid #000;*/
                    }
                    .kotak td, .kotak th{
                        word-wrap: break-word;
                        vertical-align: top;
                        border:1pt solid #000;
                    }
                    .kotak td.kolom1, .kotak td.kolom2{
                        width: 50%;
                        padding: 0;
                    }
                    .kotak td.kolom1{
                        border-left: 0;
                    }
                    .kotak td.kolom2{
                        border-right: 0;
                    }
                    .kotak2{
                        width: 100%;
                        border-collapse: collapse;
                        border:0;
                    }
                    .kotak2 td, .kotak2 th{
                        word-wrap: break-word;
                        /*border:.25pt solid #000;*/
                        border-top: 0;
                        border-left:0;
                    }
                    .kotak2 th{
                        text-align: center;
                    }
                    .kotak2 td:last-child, .kotak2 th:last-child{
                        border-right: 0;
                    }
                    .kotak3{
                        width: 100%;
                        border-collapse: collapse;
                        border-left: 0;
                        border:0;
                    }
                    .kotak3 td, .kotak3 th{
                        word-wrap: break-word;
                        /*border:1pt solid #000;*/
                        border-top: 0;
                        border-left:0;
                    }
                    .kotak3 td:last-child, .kotak3 th:last-child{
                        border-right:0;
                    }
                </style>
                <div class="kotak_cetak">
                    <div style="text-align:right;border-bottom:.5pt solid #000;font-size:15pt;font-weight: bold;">F1</div>
                    <div style="text-align:center;border-bottom:.5pt solid #000;"><img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60"></div>
                    <div style="text-align:center;font-weight: bold;font-size:12pt;">
                        UNIVERSITAS DIPONEGORO<br />
                        SURAT PERMINTAAN PEMBAYARAN
                    </div>
                    <div style="text-align:left;">
                        TAHUN ANGGARAN : <?php echo $detail_up->tahun; ?>
                        <div style="float:right;margin-top:0;padding-top:0;">
                            JENIS : LS-PEGAWAI
                        </div>
                    </div>
                    <div style="text-align:left;">
                        Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $detail_up->tanggal==''?strftime("%d %B %Y"):strftime("%d %B %Y", strtotime($detail_up->tanggal)); ?></b>
                        <div style="float:right;margin-top:0;padding-top:0;background:none;">
                            Nomor : <?php echo $detail_up->nomor; ?>
                        </div>
                    </div>
                    <div style="border-top:.5pt solid #000;">
                        Satuan Unit Kerja Pengguna Anggaran (SUKPA): <?php echo $detail_up->sukpa; ?>
                    </div>
                    <div style="border-top:.5pt solid #000;border-bottom:.5pt solid #000;">
                        Unit Kerja : <?php echo $detail_up->unit_kerja ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Kode Unit Kerja : <?php echo $detail_up->kode_uk; ?>
                    </div>
                    <div style="height:50pt;">
                        <div style="width:200pt;float:right;text-align: left;">
                                Kepada Yth.<br />
                                Pengguna Anggaran<br />
                                SUKPA <?php echo $detail_up->sukpa?><br />
                                di Semarang
                        </div>
                    </div>
                    <div class="clear:both;"></div>
                    <div>
                        <p>
                            Dengan Berpedoman pada Dokumen RKAT yang telah disetujui oleh MWA, bersama ini kami mengajukan Surat Permintaan Pembayaran sebagai berikut:
                        </p>
                        <ol style="list-style-type: lower-alpha;">
                            <li>Jumlah pembayaran yang diminta : <?php echo number_format($detail_up->total_sumberdana, 0, ",", ".")?>,-<br />
                                 (Terbilang : <strong><?php echo ucwords(strtolower(convertAngka($detail_up->total_sumberdana))); ?> Rupiah</strong>)</li>
                            <li>Untuk keperluan : <span contenteditable="true" rel="untuk_bayar" class="edit"><?php echo $this->cantik_model->decodeText($detail_up->untuk_bayar); ?></span></li>
                            <li>Nama Penerima : <span contenteditable="true" rel="penerima" class="edit"><?php echo $detail_up->penerima; ?></span></li>
                            <li>Alamat : <span contenteditable="true" rel="alamat" class="edit"><?php echo $detail_up->alamat; ?></span></li>
                            <li>Nama Bank : <span contenteditable="true" rel="nama_bank" class="edit"><?php echo $detail_up->nama_bank; ?></span></li>
                            <li>No. Rekening Bank : <span contenteditable="true" rel="rekening" class="edit"><?php echo $detail_up->rekening; ?></span></li>
                            <li>No. NPWP : <span contenteditable="true" rel="npwp" class="edit"><?php echo $detail_up->npwp; ?></span></li>
                            <!-- <li>Sumber dana dari Selain PNBP : <?php echo number_format($detail_up->total_sumberdana, 0, ",", "."); ?>,-</li> -->
                        </ol>
                        <p>
                            Pembayaran sebagaimana tersebut diatas, dibebankan pada pengeluaran dengan uraian sebagai berikut :
                        </p>
                    </div>
                    <div style="padding: 0;">
                        <table class="kotak">
                            <thead>
                                <tr>
                                    <th style="text-align:center;border-left:0;">PENGELUARAN</th>
                                    <th style="text-align:center;border-right:0;">PERHITUNGAN TERKAIT PIHAK LAIN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="kolom1">
                                        <table class="kotak3">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;border-left:0;">Nama Akun</th>
                                                    <th style="text-align:center;">Kode Akun</th>
                                                    <th style="text-align:center;">Jumlah Uang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- yang di-ulangi pake fetch -->
                                            <?php
                                                // $i=0;
                                                if(count($akun_detail)>0){
                                                    $jumlah = 0;
                                                    // foreach ($akun_detail as $k => $v) {
                                                    for($i=0;$i<count($akun_detail);$i++){
                                                        if($i<(count($akun_detail)-1)){
                                                            if(substr($akun_detail[$i]->kode_usulan_belanja,-6)==substr($akun_detail[$i+1]->kode_usulan_belanja,-6)){
                                                                $jumlah+=($akun_detail[$i]->volume * $akun_detail[$i]->harga_satuan);
                                                                continue;
                                                            }
                                                        }
                                                        $jumlah+=($akun_detail[$i]->volume * $akun_detail[$i]->harga_satuan);
                                            ?>
                                                <tr>
                                                    <td style="font-weight:bold;" colspan="3"><?php echo $this->cantik_model->get_subkomponen(substr($akun_detail[$i]->kode_usulan_belanja,6,12)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo get_nama_akun(substr($akun_detail[$i]->kode_usulan_belanja,-6)); ?></td>
                                                    <td><?php echo substr($akun_detail[$i]->kode_usulan_belanja,-6,5); ?></td>
                                                    <td style="text-align: right;"><?php echo number_format($jumlah, 0, ",", "."); ?>,-</td>
                                                </tr>
                                            <?php
                                                        if($i<(count($akun_detail)-1)){
                                                            if(substr($akun_detail[$i]->kode_usulan_belanja,-6)!=substr($akun_detail[$i+1]->kode_usulan_belanja,-6)){
                                                                $jumlah=0;
                                                            }
                                                        }
                                                        // $i++;
                                                    }
                                                }
                                            ?>
                                                <!-- brenti -->
                                                <tr>
                                                    <td colspan="2">Jumlah Pengeluaran</td>
                                                    <td style="text-align: right;"><?php echo number_format($detail_up->total_sumberdana, 0, ",", ".")?>,-</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Dikurangi : Jumlah potongan untuk pihak lain</td>
                                                    <td style="text-align: right;"><?php echo number_format(($detail_up->potongan+$detail_up->pajak), 0, ",", ".")?>,-</td>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="text-align: left;">Jumlah Pembayaran yang diminta</th>
                                                    <?php $detail_up->jumlah_bayar; $jml_hsl = $detail_up->total_sumberdana-($detail_up->potongan+$detail_up->pajak); ?>
                                                    <th style="text-align: right;"><?php echo number_format($jml_hsl, 0, ",", ".")?>,-</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </td>
                                    <td class="kolom2">
                                        <table class="kotak2">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="border-right:0;">
                                                        PENERIMAAN DARI PIHAK KE-3
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Akun</th>
                                                    <th>Jumlah Uang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>-</td>
                                                    <td style="text-align: right;">0,-</td>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left;">Jumlah Penerimaan</th>
                                                    <th style="text-align: right;">0,-</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="border-right:0;">
                                                        POTONGAN UNTUK PIHAK LAIN
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Akun Pajak &amp; Potongan Lainnya</th>
                                                    <th>Jumlah Uang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Pajak Penghasilan</td>
                                                    <td style="text-align: right;"><?php echo number_format($detail_up->pajak, 0, ",", ".")?>,-</td>
                                                </tr>
                                                <tr>
                                                    <td>Potongan Lainnya</td>
                                                    <td style="text-align: right;"><?php echo number_format($detail_up->potongan, 0, ",", ".")?>,-</td>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left;">Jumlah Potongan</th>
                                                    <th style="text-align: right;"><?php echo number_format(($detail_up->potongan+$detail_up->pajak), 0, ",", ".")?>,-</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <p>
                        SPP Sebagaimana dimaksud diatas, disusun sesuai dengan dokumen lampiran yang persyaratkan dan disampaikan secara bersamaan serta merupakan bagian yang tidak terpisahkan dari surat ini.
                        </p>
                    </div>
                    <!-- <div style="height:90pt;">
                        <div style="float:right;width:200pt;">
                            Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?strftime("%d %B %Y"):strftime("%d %B %Y", strtotime($tgl_spp)); ?>
                            <br/>
                            Bendahara Pengeluaran SUKPA
                            <br/><br/><br/><br/><br/><br/>
                            <?php echo $detail_up->namabpsukpa?>
                            <br/>
                            NIP. <?php echo $detail_up->nipbpsukpa?>
                        </div>
                    </div> -->
                    <table style="height:90pt;width:100%;background-color:#fff;">
                        <td width="33%">&nbsp;</td>
                        <td width="34%">&nbsp;</td>
                        <td width="33%">
                            Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?strftime("%d %B %Y"):strftime("%d %B %Y", strtotime($tgl_spp)); ?>
                            <br/>
                            Bendahara Pengeluaran SUKPA
                            <br/><br/><br/><br/><br/><br/>
                            <?php echo $detail_up->namabpsukpa?>
                            <br/>
                            NIP. <?php echo $detail_up->nipbpsukpa?>
                        </td>
                    </table>
                    <div style="border-top:1px solid #000;">
                        <p style="font-weight: bold;">Keterangan:</p>
                        <ul>
                            <li style="text-align: justify;">Semua bukti Pengeluaran untuk pekerjaan dengan perjanjian yang disahkan Pejabat Pembuat Komitmen telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan diusahakan oleh Pejabat Penatasuahaan Keuangan SUKPA.</li>
                            <li style="text-align: justify;">Semua Bukti-bukti pengeluaran untuk pekerjaan yang disahkan Pejabat dan pengendali Kegiatan (PPPK) telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan SUKPA.</li>
                            <li style="text-align: justify;">Kebenaran perhitungan dan isi tertuang dalam SPP ini menjadi tanggung Jawab bendahara Pengeluaran sepanjang sesuai dengan bukti-bukti pengeluaran yang telah ditandatangani oleh PPPPK atau PPK.</li>
                        </ul>
                    </div>
            