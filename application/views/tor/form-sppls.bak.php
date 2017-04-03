<?php
    function doone2($onestr,$answer) {
        $tsingle = array("","satu ","dua ","tiga ","empat ","lima ",
        "enam ","tujuh ","delapan ","sembilan ");
           return strtoupper($tsingle[$onestr]);
    }

    function doone($onestr,$answer) {
        $tsingle = array("","se","dua ","tiga ","empat ","lima ", "enam ","tujuh ","delapan ","sembilan ");
           return strtoupper($tsingle[$onestr]);
    }

    function dotwo($twostr,$answer) {
        $tdouble = array("","puluh ","dua puluh ","tiga puluh ","empat puluh ","lima puluh ", "enam puluh ","tujuh puluh ","delapan puluh ","sembilan puluh ");
        $teen = array("sepuluh ","sebelas ","dua belas ","tiga belas ","empat belas ","lima belas ", "enam belas ","tujuh belas ","delapan belas ","sembilan belas ");
        if ( substr($twostr,1,1) == '0') {
            $ret = doone2(substr($twostr,0,1), $answer);
        } else if (substr($twostr,1,1) == '1') {
            $ret = $teen[substr($twostr,0,1)];
        } else {
            $ret = $tdouble[substr($twostr,1,1)] . doone2(substr($twostr,0,1),$answer);
        }
        return strtoupper($ret);
    }

    function convertAngka($num) {
        $tdiv = array("","","ratus ","ribu ", "ratus ", "juta ", "ratus ","miliar ");
        $divs = array( 0,0,0,0,0,0,0);
        $pos = 0; // index into tdiv;
        // make num a string, and reverse it, because we run through it backwards
        // bikin num ke string dan dibalik, karena kita baca dari arah balik
        $num=strval(strrev(number_format($num,2,'.','')));
        $answer = ""; // mulai dari sini
        while (strlen($num)) {
            if ( strlen($num) == 1 || ($pos >2 && $pos % 2 == 1))  {
                $answer = doone(substr($num,0,1),$answer) . $answer;
                $num= substr($num,1);
            } else {
                $answer = dotwo(substr($num,0,2), $answer) . $answer;
                $num= substr($num,2);
                if ($pos < 2)
                    $pos++;
            }
            if (substr($num,0,1) == '.') {
                if (! strlen($answer))
                    $answer = "";
                $answer = "" . $answer . "";
                $num= substr($num,1);
                // kasih tanda "nol" jika tidak ada
                if (strlen($num) == 1 && $num == '0') {
                    $answer = "" . $answer;
                    $num= substr($num,1);
                }
            }
            // add separator
            if ($pos >= 2 && strlen($num)) {
                if (substr($num,0,1) != 0  || (strlen($num) >1 && substr($num,1,1) != 0
                    && $pos %2 == 1)  ) {
                    // check for missed millions and thousands when doing hundreds
                    // cek kalau ada yg lepas pada juta, ribu dan ratus
                    if ( $pos == 4 || $pos == 6 ) {
                        if ($divs[$pos -1] == 0)
                            $answer = $tdiv[$pos -1 ] . $answer;
                    }
                    // standard
                    $divs[$pos] = 1;
                    $answer = $tdiv[$pos++] . $answer;
                } else {
                    $pos++;
                }
            }
        }
        return strtoupper($answer);
    }
?>
<script type="text/javascript">

$(document).ready(function(){
    $('#back').on('click',function(e){
        e.preventDefault();
        window.history.back();
    });
    $('.edit').on('blur',function(e){
        e.preventDefault();
        $.post('<?php echo site_url("tor/simpanSPPLSPeg"); ?>',{'id':$(this).attr('rel'),'value':$(this).html(),'key':'<?php echo $detail_up->id_sppls; ?>'}, function(data){
            // $('.message_sppls').html(data);
            // $('#myModalMessage').modal('show');
        });
    });
    $('#down').on('click',function(e){
        $("#status_spp").replaceWith( "<br><br><br>" );
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
    .edit{border-bottom: 1px solid #f00;padding:3px;}
</style>
<div id="page-wrapper" >
<div id="page-inner">

<div id="temp" style="display:none"></div>

<div style="background-color: #EEE; padding: 10px;">

		<table id="table_spp_up" style="font-family:arial;font-size:12px;font-size:11px; line-height: 21px;border-collapse: collapse;width: auto;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
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
                                    <td colspan="2" style="border-right: none;border-right: none;border-top: none;border-bottom: none;"><b>TAHUN ANGGARAN : <?php echo $cur_tahun?></b></td>
                                    <td style="text-align: center;border-right: none;border-left: none;border-top: none;border-bottom: none;" colspan="2"><b>JENIS : LS-PEGAWAI</b></td>
                                    <td style="border-left: none;border-top: none;border-bottom: none;">&nbsp;</td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="2" style="border-right: none;border-top:none;"><b>Tanggal	: <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?strftime("%d %B %Y"):strftime("%d %B %Y", strtotime($tgl_spp)); ?></b></td>
                                    <td style="text-align: center;border-left: none;border-right: none;border-top:none;" colspan="2" >&nbsp;</td>
                                    <td style="border-left: none;border-top:none;"><b>Nomor: <?php echo $id_sppls; ?>/<?php echo $alias?>/SPP-LS PGW/<?php echo strtoupper($cur_bulan); ?>/<?php echo $cur_tahun; ?></b></td>
                                </tr>
                                <tr >
                                    <td colspan="5"><b>Satuan Unit Kerja Pengguna Anggaran (SUKPA): <?php echo $unit_kerja?></b></td>
                                </tr>
                                <tr >
                                    <td colspan="5"><b>Unit Kerja : <?php echo $unit_kerja?> &nbsp;&nbsp; Kode Unit Kerja : <?php echo $unit_id?></b></td>
                                </tr>
				<tr style="border-bottom: none;">

                                    <td colspan="4" style="border-right: none;border-bottom: none;">&nbsp;</td>
                                    <td style="line-height: 16px;border-left: none;border-bottom: none;">Kepada Yth.<br>
                                                    Kuasa Pengguna Anggaran<br>
                                                    SUKPA <?php echo $unit_kerja?><br>
                                                    di Semarang
                                    </td>
				</tr>
                                <tr >
                                        <td colspan="5" style="border-bottom: none;border-top: none;">&nbsp;</td>
                                </tr>
				<tr>
                                    <td colspan="5"  style="line-height: 16px;border-bottom: none;border-top: none;">
                                        Dengan Berpedoman pada Dokumen RKAT yang telah disetujui oleh MWA, bersama ini kami mengajukan Surat Permintaan Pembayaran sebagai berikut:<br>
                                    a. Jumlah pembayaran yang diminta &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Rp. <?php echo number_format($detail_up->jumlah_bayar, 0, ",", ".")?>,-<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Terbilang : <b><?php echo ucwords(strtolower(convertAngka($detail_up->jumlah_bayar))); ?> Rupiah</b>)<br>
                                    b. Untuk keperluan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <span class="edit" rel="untuk_bayar" contenteditable="true"><?php echo $detail_up->untuk_bayar; ?></span><br>
                                    c. Nama Penerima &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <span class="edit" rel="penerima" contenteditable="true"><?php echo $detail_up->penerima; ?></span><br>
                                    d. Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :  <span class="edit" rel="alamat" contenteditable="true"><?php echo $detail_up->alamat; ?>&nbsp;</span><br>
                                    e. No. Rekening Bank &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <span class="edit" rel="rekening" contenteditable="true"><?php echo $detail_up->rekening; ?></span><br>
                                    f. No. NPWP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :<span class="edit" rel="npwp" contenteditable="true"><?php echo $detail_up->npwp; ?></span><br>
                                    g. Sumber dana dari Selain PNBP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Rp. <?php echo number_format($detail_up->total_sumberdana, 0, ",", "."); ?>,-
                                    </td>
                                </tr>
                                <tr>
								<td colspan="5" style="border-bottom: none;border-top: none;">
								&nbsp;
								</td>
                                </tr>

                                <tr>
								<td colspan="5" style="border-top: none;">
								Pembayaran sebagaimana tersebut diatas, dibebankan pada pengeluaran dengan uraian sebagai berikut :<br>
								</td>


                                </tr>


                                    </tr>

							<tr >
                  <td colspan='3' style="text-align: center;width:45%;">
									<b>PENGELUARAN</b>
								</td>
								<td colspan='2' style="text-align: center;width:45%;">
									<b>PERHITUNGAN TERKAIT PIHAK LAIN</b>
								</td>
							</tr>
                            <tr>
                                <td colspan="3" rowspan="7" valign="top">
                                <!-- tabel pengeluaran -->
                                    <table border="1" style="border-collapse: collapse;">
                                        <tr>
                                            <td style="text-align: center">
                                                NAMA AKUN
                                            </td>
                                            <td style="text-align: center">
                                                KODE AKUN
                                            </td>
                                            <td style="text-align: center">
                                                JUMLAH UANG
                                            </td>
                                        </tr>
                                    <?php
                                        if(count($akun_detail)>0){
                                            foreach ($akun_detail as $k => $v) {
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $v->deskripsi; ?>
                                            </td>
                                            <td style="text-align: center;min-width:100px;">
                                                <?php echo substr($v->kode_usulan_belanja,-6); ?>
                                            </td>
                                            <td style="text-align: right;min-width:100px;">
                                                <?php echo number_format($v->harga_satuan, 0, ",", "."); ?>,-
                                            </td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    </table>
                                </td>
                                <td colspan="2" style="text-align:center;">
                                    PENERIMAAN DARI PIHAK KE-3
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center">Akun</td>
                                <td style="text-align: center">Jumlah Uang</td>
                            </tr>
							<tr>
                                <td >-</td>
								<td style="text-align: right;">Rp.-</td>
							</tr>
                                                        <tr>
                                <td ><b>Jumlah Penerimaan</b></td>
								<td style="text-align: right;">Rp.0,-</td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: center">
									POTONGAN UNTUK PIHAK LAIN
								</td>
							</tr>
							<tr>
								<td style="text-align: center">
									Akun Pajak dan Potongan Lainnya
								</td>
								<td style="text-align: center">
									Jumlah Uang
								</td>
							</tr>
							<tr>
								<td>
									Iuran wajib Pegawai
								</td>
								<td style="text-align: right;">
									Rp. 0,-
								</td>
							</tr>
							<tr>
								<td colspan="2">
								Jumlah Pengeluaran
								</td>
								<td style="text-align: right;">
									Rp. <?php echo number_format($detail_up->total_sumberdana, 0, ",", ".")?>,-
								</td>
								<td>
									Pajak Penghasilan
								</td>
								<td style="text-align: right;">
									Rp. <?php echo number_format($detail_up->potongan, 0, ",", ".")?>,-
								</td>
							</tr>
							<tr>
								<td colspan="2">
								Dikurangi : Jumlah potongan untuk pihak lain
								</td>
								<td style="text-align: right;">
									Rp. <?php echo number_format($detail_up->potongan, 0, ",", ".")?>,-
								</td>
								<td>
									&nbsp;
								</td>
								<td >
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<strong>Jumlah pembayaran yang diminta</strong>
								</td>
								<td style="text-align: right;">
									Rp. <?php echo number_format($detail_up->jumlah_bayar, 0, ",", ".")?>,-
								</td>
								<td>
									<b>Jumlah Potongan</b>
								</td>
								<td style="text-align: right;">
									Rp. <?php echo number_format($detail_up->potongan, 0, ",", ".")?>,-
								</td>
							</tr>

				<tr style="border-bottom: none;">
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;">
						SPP Sebagaimana dimaksud diatas, disusun sesuai dengan dokumen lampiran yang persyaratkan dan disampaikan secara bersamaan serta merupakan bagian yang tidak terpisahkan dari surat ini.<br><br>
					</td>
				<tr>
				<tr style="border-top: none;">

                                    <td colspan="4" style="border-right: none;border-top:none;">&nbsp;</td>
								<td  style="line-height: 16px;border-left: none;border-top:none;">
									Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spp==''?strftime("%d %B %Y"):strftime("%d %B %Y", strtotime($tgl_spp)); ?> <br>
									Bendahara Pengeluaran SUKPA<br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
									<span class="edit" rel="namabpsukpa" contenteditable="true"><?php echo $detail_pic->nm_lengkap; ?></span><br>
									NIP. <span class="edit" rel="nipbpsukpa" contenteditable="true"><?php echo $detail_pic->nomor_induk; ?></span><br>
								</td>
				</tr>
				<tr>
					<td colspan="5"  style="line-height: 16px;">
						<strong>Keterangan:</strong>
						<ul>
							<li>Semua bukti Pengeluaran untuk pekerjaan dengan perjanjian yang disahkan Pejabat Pembuat Komitmen telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan diusahakan oleh Pejabat Penatasuahaan Keuangan SUKPA</li>
							<li>
							Semua Bukti-bukti pengeluaran untuk pekerjaan yang disahkan Pejabat dan pengendali Kegiatan (PPPK) telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan SUKPA.
							</li>
							<li>Kebenaran perhitungan dan isi tertuang dalam SPP ini menjadi tanggung Jawab bendahara Pengeluaran sepanjang sesuai dengan bukti-bukti pengeluaran yang telah ditandatangani oleh PPPPK atau PPK</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
</div>
<br />
<form action="<?php echo site_url("tor/sppLScetak"); ?>/id/<?php echo $detail_up->id_sppls; ?>" id="form_spp" method="post" style="display: none" target="_blank">
    <input type="text" name="dtable" id="dtable" value="" />
</form>
            <div class="alert alert-warning" style="text-align:center">
                <a href="javascript:void(0);" class="btn btn-default btn-sm btn-flat" id="down"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></span> Download</a>
                <a href="javascript:void(0);" class="btn btn-default btn-sm btn-flat" id="back"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></span> Kembali ke Daftar</a>
              </div>
	</div>

	</div>

<img style="display: none" id="status_spp" src="<?php echo base_url(); ?>/assets/img/waitting.png" width="200">

<div class="modal" id="myModalMessage" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i> Perhatian :</h4>
          </div>
          <div class="modal-body message_sppls" style="margin:15px;padding:0px;padding-bottom: 15px;">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> OK</button>
          </div>
        </div>
    </div>
</div>
