<?php
    $_alert = " alert-warning";
    $ac = $this->cantik_model->get_status_form($detail_up->proses, 'spm');
    if($detail_up->proses == 9){
        $_alert = ' alert-danger';
    }
    if($detail_up->proses == 3){
        $_alert = ' alert-success';
    }
?>
<script type="text/javascript">

$(document).ready(function(){
    $('#back').on('click',function(e){
        e.preventDefault();
        window.history.back();
    });
    $('#list').on('click',function(e){
        e.preventDefault();
        window.location='<?php echo site_url('tor/daftar_spmlspeg')."/tahun/".$detail_up->tahun; ?>';
    });
    $('#down').on('click',function(e){
        var uri = $("#table_spp_up").excelexportjs({
            containerid: "table_spp_up"
            , datatype: "table"
            , returnUri: true
        });
        $('#dtable').val(uri);
        $('#form_spp').submit();
    });
});

function b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || '';
    sliceSize = sliceSize || 512;

    var byteCharacters = atob(b64Data);
    var byteArrays = [];

    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    var blob = new Blob(byteArrays, {type: contentType});
    return blob;
}

</script>
<style type="text/css">
    .edit{border-bottom: 1px solid #f00;}
</style>

<div id="page-wrapper" >
    <div id="page-inner">

        <div>
            <h4 class="page-header" style="margin-top:0;">SPM LS-PGW Nomor : <span><?php echo $detail_up->nomor; ?></span></h4>
            <div class="alert<?php echo $_alert; ?> small text-center" style="padding:3px;"><strong>Status saat ini</strong> : <?php echo $detail_up->status; ?></div>
        </div>
        <div class="progress-round">
            <div class="circle done">
                <span class="label">1</span>
                <span class="title">Bendahara</span>
            </div>
            <span class="bar done"></span>
            <div class="circle done">
                <span class="label">2</span>
                <span class="title">PPK</span>
            </div>
            <span class="bar done"></span>
            <div class="circle<?php echo $ac[1]; ?>">
                <span class="label">3</span>
                <span class="title">KPA</span>
            </div>
            <span class="bar<?php echo $ac[1]; ?>"></span>
            <div class="circle<?php echo $ac[2]; ?>">
                <span class="label">4</span>
                <span class="title">Verifikator</span>
            </div>
            <span class="bar<?php echo $ac[2]; ?>"></span>
            <div class="circle<?php echo $ac[3]; ?>">
                <span class="label">5</span>
                <span class="title">KBUU</span>
            </div>
        </div>
        <div style="background-color: #EEE; padding: 10px;">
            <?php //print_r($detail_up); ?>
            <div id="table_spp_up">
                <style type="text/css">
                    .kotak_cetak{
                        border:.5pt solid #000;padding:0;width:750px;margin-left: auto;margin-right: auto;
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
                        padding:1px;
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
                        padding:1px;
                    }
                    .kotak3 td:last-child, .kotak3 th:last-child{
                        border-right:0;
                    }
                </style>
                <div class="kotak_cetak">
                    <div style="text-align:right;border-bottom:.5pt solid #000;font-size:15pt;font-weight: bold;">F2</div>
                    <div style="text-align:center;border-bottom:.5pt solid #000;"><img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60"></div>
                    <div style="text-align:center;font-weight: bold;font-size:12pt;">
                        UNIVERSITAS DIPONEGORO<br />
                        SURAT PERINTAH MEMBAYAR
                    </div>
                    <div style="text-align:left;">
                        TAHUN ANGGARAN : <?php echo $cur_tahun?>
                        <div style="float:right;margin-top:0;padding-top:0;">
                            JENIS : LS-PEGAWAI
                        </div>
                    </div>
                    <div style="text-align:left;">
                        Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?strftime("%d %B %Y"):strftime("%d %B %Y", strtotime($tgl_spp)); ?></b>
                        <div style="float:right;margin-top:0;padding-top:0;background:none;">
                            Nomor : <?php echo $detail_up->nomor; ?>
                        </div>
                    </div>
                    <div style="border-top:.5pt solid #000;border-bottom:.5pt solid #000;">
                        Satuan Unit Kerja Pengguna Anggaran (SUKPA): <?php echo $unit_kerja?>
                    </div>
                    <div style="height:50pt;">
                        <div style="width:200pt;float:right;text-align: left;">
                                Kepada Yth.<br />
                                <!-- Kuasa Pengguna Anggaran<br /> -->
                                <!-- SUKPA <?php echo $unit_kerja?><br /> -->
                                Bendahara Umum Undip (BUU)<br />
                                di Semarang
                        </div>
                    </div>
                    <!-- <div class="clear:both;"></div> -->
                    <div>
                        <p>
                            Dengan Berpedoman pada Dokumen SPP yang disampaikan bendahara pengeluaran dan telah diteliti keabsahannya ole PPK-SUKPA, bersama ini kami memerintahkan kepada Kuasa BUU untuk membayar sebagai berikut:
                        </p>
                        <ol style="list-style-type: lower-alpha;">
                            <li>Jumlah pembayaran yang diminta : <?php echo number_format($detail_up->total_sumberdana, 0, ",", ".")?>,-<br />
                                 (Terbilang : <strong><?php echo ucwords(strtolower($this->cantik_model->convertAngka($detail_up->total_sumberdana))); ?> <?php //echo $detail_up->total_sumberdana;?> Rupiah</strong>)</li>
                            <li>Untuk keperluan : <?php echo $this->cantik_model->decodeText($detail_up->untuk_bayar); ?></li>
                            <li>Nama Penerima : <?php echo $detail_up->penerima; ?></li>
                            <li>Alamat : <?php echo $detail_up->alamat; ?></li>
                            <li>Nama Bank : <?php echo $detail_up->nama_bank; ?></li>
                            <li>No. Rekening Bank : <?php echo $detail_up->rekening; ?></span></li>
                            <li>No. NPWP : <?php echo $detail_up->npwp; ?></li>
                            <!-- <li>Sumber dana dari Selain PNBP : <?php echo number_format($detail_up->total_sumberdana, 0, ",", "."); ?>,-</li> -->
                            <?php /*
                            <li>Nama Penerima : <span contenteditable="true" rel="penerima" class="edit"><?php echo $detail_up->penerima; ?></span></li>
                            <li>Alamat : <span contenteditable="true" rel="alamat" class="edit"><?php echo $detail_up->alamat; ?></span></li>
                            <li>No. Rekening Bank : <span contenteditable="true" rel="rekening" class="edit"><?php echo $detail_up->rekening; ?></span></li>
                            <li>No. NPWP : <span contenteditable="true" rel="npwp" class="edit"><?php echo $detail_up->npwp; ?></span></li>
                            <li>Sumber dana dari Selain PNBP : <?php echo number_format($detail_up->total_sumberdana, 0, ",", "."); ?>,-</li>
                            */ ?>
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
                                                            if(substr($akun_detail[$i]->kode_usulan_belanja,-6,4)==substr($akun_detail[$i+1]->kode_usulan_belanja,-6,4)){
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
                                                    <td><?php echo $this->akun_model->get_nama_akun(substr($akun_detail[$i]->kode_usulan_belanja,-6,4)); ?></td>
                                                    <td><?php echo substr($akun_detail[$i]->kode_usulan_belanja,-6,4); ?></td>
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
                                                    <td style="text-align: right;"><?php echo number_format(($detail_up->potongan+$detail_up->pajak+$detail_up->potongan_pajak), 0, ",", ".")?>,-</td>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="text-align: left;">Jumlah Pembayaran yang diminta</th>
                                                    <th style="text-align: right;"><?php echo number_format($detail_up->jumlah_bayar, 0, ",", ".")?>,-</th>
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
                                                    <td>Tabungan Pajak Penghasilan</td>
                                                    <td style="text-align: right;"><?php echo number_format($detail_up->pajak, 0, ",", ".")?>,-</td>
                                                </tr>
                                                <tr>
                                                    <td>Potongan Pajak Penghasilan</td>
                                                    <td style="text-align: right;"><?php echo number_format($detail_up->potongan_pajak, 0, ",", ".")?>,-</td>
                                                </tr>
                                                <tr>
                                                    <td>Potongan Lainnya</td>
                                                    <td style="text-align: right;"><?php echo number_format($detail_up->potongan, 0, ",", ".")?>,-</td>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left;">Jumlah Potongan</th>
                                                    <th style="text-align: right;"><?php echo number_format(($detail_up->potongan+$detail_up->pajak+$detail_up->potongan_pajak), 0, ",", ".")?>,-</th>
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
                        Surat Perintah Membayar (SPM) Sebagaimana dimaksud diatas, disusun sesuai dengan dokumen lampiran yang persyaratkan dan disampaikan secara bersamaan serta merupakan bagian yang tidak terpisahkan dari surat ini.
                        </p>
                    </div>
                    <table style="height:90pt;width:100%;background-color:#fff;">
                        <tr>
                            <td style="width:5pt;">&nbsp;</td>
                            <td style="width:200pt;padding-bottom:5pt;">
                              <br/>
                              Lampirannya telah diverifikasi,<br/>
                              PPK SUKPA
                              <br/><br/><br/><br/><br/>
                              <?php echo $detail_up->namappk; ?>
                              <br/>
                              NIP. <?php echo $detail_up->nipppk; ?>
                            </td>
                            <td>&nbsp;</td>
                            <td style="width:200pt;padding-left:5pt;padding-bottom:5pt;">
                                Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?strftime("%d %B %Y"):strftime("%d %B %Y", strtotime($tgl_spp)); ?>
                                <br/>
                                <?php if($kd_unit != '91'): ?>
                                Kuasa Pengguna Anggaran,
                                <?php else: ?>
                                Pejabat Penandatangan SPM
                                <?php endif; ?>
                                <br/><br/><br/><br/><br/><br/>
                                <?php echo $detail_up->namakpa; ?>
                                <br/>
                                NIP. <?php echo $detail_up->nipkpa; ?>
                            </td>
                        </tr>
                    </table>
                    <div style="border-top:1px solid #000;">
                        <p style="font-weight: bold;">Keterangan:</p>
                        <ul>
                            <li style="text-align: justify;">Semua bukti-bukti pengeluaran untuk pekerjaan dengan perjanjian yang disahkan Pejabat Pembuat Komitmen telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan diusahakan oleh Pejabat Penatasuahaan Keuangan SUKPA.</li>
                            <li style="text-align: justify;">Semua Bukti-bukti pengeluaran untuk pekerjaan yang disahkan Pejabat dan pengendali Kegiatan (PPPK) telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan SUKPA.</li>
                            <li style="text-align: justify;">Kebenaran perhitungan dan isi tertuang dalam SPM ini menjadi tanggung Jawab Pengguna/Kuasa Pengguna Anggaran.</li>
                        </ul>
                    </div>
                    <div style="border-top:1px solid #000;padding-top:0;padding-bottom:0;border-bottom:1px solid #000;">
                    <?php
                        $_ver = $this->db->query("SELECT b.nm_lengkap, b.nomor_induk FROM rsa_verifikator_unit a LEFT JOIN rsa_user b ON a.id_user_verifikator = b.id WHERE a.kode_unit_subunit LIKE '".substr($_SESSION['rsa_kode_unit_subunit'], 0, 2)."'")->row();
                        // echo "SELECT b.nm_lengkap, b.nomor_induk FROM rsa_verifikator_unit a LEFT JOIN rsa_user b ON a.id_user_verifikator = b.id WHERE kode_unit_subunit LIKE '".substr($_SESSION['rsa_kode_unit_subunit'], 0, 2)."'";
                	//print_r($bver);
			//echo $_SESSION['rsa_level'];
                        // strftime("%d %B %Y");
		?>
                      <table width="100%">
                        <tr>
                          <td width="33%" style="padding:3px;">
                            <br/>
                            Dokumen SPM, dan lampirannya telah diverifikasi kelengkapannya.<br/>
                            Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $detail_up->tglver==''?'':strftime("%d %B %Y", strtotime($detail_up->tglver)); ?>
                            <br/><br/><br/><br/><br/><br/>
                            <?php
                              if( !in_array(intval($_SESSION['rsa_level']),array(3,11)) ){
                                // echo $detail_up->namaver;
                                echo $_ver->nm_lengkap;
                              }else{
                                echo $detail_up->namaver;
                              }
				//echo $detail_up->namaver;
                            ?>
                            <br/>
                            NIP.
                            <?php
                              if( !in_array(intval($_SESSION['rsa_level']),array(3,11)) ){
                                // echo $detail_up->nipver;
                                echo $_ver->nomor_induk;
                              }else{
                                echo $detail_up->nipver;
                              }
                            ?>
                          </td>
                          <td style="border-left:.5pt solid #000;padding:3px;">
                    <?php
                      if($detail_up->jumlah_bayar>=100000000){
                    ?>
                            Setuju dibayar :<br/>
                            Kuasa Bendahara Umum Undip harap membayar kepada sesuai SPM dari Pengguna/KPA
                            <br/><br/><br/><br/><br/><br/><br/>
                            <?php echo $detail_up->namabuu; ?>
                            <br/>
                            NIP. <?php echo $detail_up->nipbuu; ?>
                    <?php
                      }
                    ?>
                          </td>
                          <td width="33%" style="border-left:.5pt solid #000;padding:3px;">
                            Nomor:<br/>
                            Tanggal:<br/>
                            Telah dibayar oleh
                            <br/><br/><br/><br/><br/><br/><br/>
                            <?php echo $detail_up->namakbuu; ?>
                            <br/>
                            NIP. <?php echo $detail_up->nipkbuu; ?>
                          </td>
                        </tr>
                      </table>
                      <!-- <div style="float:left;width:33%;background:#none;">

                      </div>
                      <div style="float:left;width:33%;border-left:1pt solid #000;background:#none;">

                      </div>
                      <div style="float:right;width:150pt;border-left:1pt solid #000;background:#none;">
                        <br/><br/>
                      </div> -->
                    </div>
                </div>
            </div>
        </div>


        <form action="<?php echo site_url("tor/spmLScetak"); ?>/id/<?php echo $detail_up->id_spmls; ?>" id="form_spp" method="post" style="display: none" target="_blank">
            <input type="text" name="dtable" id="dtable" value="" />
        </form>
        <div class="alert alert-warning" style="text-align:center">
            <a href="#" class="btn btn-default btn-sm btn-flat" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></span> Download</a>
            <a href="javascript:void(0);" class="btn btn-default btn-sm btn-flat" id="list"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></span> Daftar SPM LS-Peg</a>
            <!-- <a href="javascript:void(0);" class="btn btn-default btn-sm btn-flat" id="back"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></span> Kembali ke Daftar</a> -->
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
          <div class="modal-body message_sppls" style="margin:15px;padding:0px;padding-bottom: 15px;word-wrap: break-word;">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> OK</button>
          </div>
        </div>
    </div>
</div>
