<script type="text/javascript">

$(document).ready(function(){
    
    $('#spm_tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
      });

      // store the currently selected tab in the hash value
      $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
      });

      // on load of the page: switch to the currently selected tab
      var hash = window.location.hash;
      $('#spm_tab a[href="' + hash + '"]').tab('show');
    
    $("#cetak").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("#div-cetak").printArea( options );
                });
                
                $("#cetak-spm").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("#div-cetak-spm").printArea( options );
                });
    
    var pos = $('.ttd').position();

    var width = $('.ttd').width();


$('#myModalKonfirm').on('hidden.bs.modal', function (e) {
            // do something...
            $('#proses_spm_').hide();
            $('#proses_spm').show();
        })
    
    $(document).on("click",'#proses_spp',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPP-FINAL' + '&nomor_trx=' + $('#nomor_trx').html() + '&jenis=' + 'SPP'  + '&id_nomor_<?=$jenis?>=' + '<?=$id_nomor?>' ;
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_'.$jenis.'/proses_spp_'.$jenis.'')?>",
                data:data,
                success:function(data){

                        if(data=='sukses'){
                            // location.reload();
                            window.location = "<?=site_url('rsa_'.$jenis.'/spm_'.$jenis.'_lanjut/'.$hash_url)?>#spm" ;
                        }

                }
            });
        }
    });
    
    
    $(document).on("click",'#tolak_spp_',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPP-DITOLAK' + '&nomor_trx=' + $('#nomor_trx').html() + '&jenis=' + 'SPP' + '&ket=' + $('#ket').val() + '&id_nomor_<?=$jenis?>=' + '<?=$id_nomor?>' ;
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_'.$jenis.'/proses_spp_'.$jenis.'')?>",
                data:data,
                success:function(data){

                        if(data=='sukses'){
                            // location.reload();
                            window.location = '<?=site_url('rsa_'.$jenis.'/daftar_spm')?>';
                        }
                      
                }
            });
        }
    });
    
    $('#myModalTolakSPP').on('shown.bs.modal', function (e) {
        // do something...
        $('#ket').focus();
      })
    
    $(document).on("click","#down",function(){
                    var uri = $("#table_spp_tambah_ks").excelexportjs({
                                    containerid: "table_spp_tambah_ks"
                                    , datatype: "table"
                                    , returnUri: true
                                });

        $('#dtable').val(uri);
        $('#form_spp').submit();

    
    });
    
    $(document).on("click","#down_2",function(){
                    var uri = $("#table_spm_tambah_ks").excelexportjs({
                                    containerid: "table_spm_tambah_ks"
                                    , datatype: "table"
                                    , returnUri: true
                                });

        $('#dtable_2').val(uri);
        $('#form_spm').submit();

    
    });

});

function string_to_angka(str){
	//I.S str merupakan string yang berisi angka berformat (.000.000,00)
	//F.S num merupakan angka tanpa format

		// var num;
		
		// if (!isNaN(str)){
		// 	return 0;
		// }
		// // str = str.replace(/\./g,"");

		// str = str.split('.').join("");
		// //num = parseInt(str);
		// return str;
		
		return str.split('.').join("");
		

		
	}

	function angka_to_string(num){
	//I.S num merupakan angka tanpa format
	//F.S str_hasil merupakan string yang berisi angka berformat (.000.000,00)
		// var str;
		// var str_hasil="";
		// str = num +"";
		// for (var j=str.length-1;j>=0;j--){
		// 	if (((str.length-1-j)%3==0) && (j!=(str.length-1)) && ((str[0]!='-') || (j!=0))){
		// 		str_hasil="."+str_hasil;
		// 	}
		// 	str_hasil=str[j]+str_hasil;
		// }

		var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

		return str_hasil;
	}


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

<div id="page-wrapper" >
<div id="page-inner">
    <div class="row">
                    <div class="col-lg-12">
                     <h2>SPP/SPM</h2>    
                    </div>
                </div>
                <hr />

                <div class="row">  
                    <div class="col-lg-12">
                        
    <?php 
    $stts_bendahara = '';
    $stts_ppk = '';
    $stts_kpa = '';
    $stts_verifikator = '';
    $stts_kbuu = '';
    ?>
                        
    <?php $stts_bendahara = 'done'; $stts_ppk = 'active'; ?>
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP menunggu persetujuan <b><span class="text-danger" >PPK SUKPA</span></b> .</div>

        
<div class="progress-round">
  <div class="circle <?=$stts_bendahara?>">
    <span class="label">1</span>
    <span class="title">Bendahara</span>
  </div>
  <span class="bar <?=$stts_bendahara?>"></span>
  <div class="circle <?=$stts_ppk?>">
    <span class="label">2</span>
    <span class="title">PPK</span>
  </div>
  <span class="bar <?=$stts_ppk?>"></span>
  <div class="circle <?=$stts_kpa?>">
    <span class="label">3</span>
    <span class="title">KPA</span>
  </div>
  <span class="bar <?=$stts_kpa?>"></span>
  <div class="circle <?=$stts_verifikator?>">
    <span class="label">4</span>
    <span class="title">Verifikator</span>
  </div>
  <span class="bar <?=$stts_verifikator?>"></span>
  <div class="circle <?=$stts_kbuu?>">
    <span class="label">5</span>
    <span class="title">KBUU</span>
  </div>
</div>
    
<div id="temp" style="display:none"></div> 

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="spm_tab">
        <li role="presentation" class="active"><a href="#spp" aria-controls="home" role="tab" data-toggle="tab">SPP</a></li>
        <li role="presentation"><a href="#spm" aria-controls="profile" role="tab" data-toggle="tab">SPM</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="spp">
          
          <div style="background-color: #EEE; padding: 10px;">
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
                                    <td colspan="2" style="border-right: none;border-right: none;border-top: none;border-bottom: none;"><b>TAHUN ANGGARAN : <?=$cur_tahun_spp?></b></td>
                                    <td style="text-align: center;border-right: none;border-left: none;border-top: none;border-bottom: none;" colspan="2">&nbsp;</td>
                                    <td style="border-left: none;border-top: none;border-bottom: none;"><b>JENIS : <?=strtoupper($jenis)?></b></td>
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
                                    <td colspan="5"><b>Unit Kerja : <?=$unit_kerja?> &nbsp;&nbsp; Kode Unit Kerja : <?=$unit_id?></b></td>
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
                                            <li>Jumlah pembayaran yang diminta : Rp. <span id="jumlah_bayar_spp"><?=number_format($detail_permintaan_spm['nom'], 0, ",", ".")?></span>,-<br>
                                                &nbsp;&nbsp;&nbsp;(Terbilang : <b><span id="terbilang_spp"><?=ucwords($detail_permintaan_spm['terbilang'])?><?php echo substr($detail_permintaan_spm['terbilang'],strlen($detail_permintaan_spm['terbilang'])-6,6) == 'Rupiah' ? '' : 'Rupiah' ; ?></span></b>)</li>
                                                <li>Untuk Keperluan : <span id="untuk_bayar_spp"><?=isset($detail_pic->untuk_bayar)?$detail_pic->untuk_bayar:'-'?></span></li>
                                                <li>Nama Penerima : <span id="penerima_spp"><?=isset($detail_pic->penerima)?$detail_pic->penerima:'-'?></span></li>
                                                <li>Alamat : <span id="alamat_spp"><?=isset($detail_pic->alamat_penerima)?$detail_pic->alamat_penerima:'-'?></span></li>
                                                <li>Nama Bank : <span id="nmbank_spp"><?=isset($detail_pic->nama_bank_penerima)?$detail_pic->nama_bank_penerima:'-'?></span></li>
                                                <li>Nama Rekening Bank : <span id="nmrekening_spp"><?=isset($detail_pic->nama_rek_penerima)?$detail_pic->nama_rek_penerima:'-'?></span></li>
                                                <li>No. Rekening Bank : <span id="rekening_spp"><?=isset($detail_pic->no_rek_penerima)?$detail_pic->no_rek_penerima:'-'?></span></li>
                                                <li>No. NPWP : <span id="npwp_spp"><?=isset($detail_pic->npwp_penerima)?$detail_pic->npwp_penerima:'-'?></span> <!--[ <a href="#" id="btn-edit-rincian">edit</a> ]--></li>
                                        </ol>
                                    </td>
                                </tr>
                                                               
                                                                
                                <tr>
                                        <td colspan="5" style="border-top: none;">
                                        Pembayaran sebagaimana tersebut diatas, dibebankan pada pengeluaran dengan uraian sebagai berikut :<br>							
                                        </td>
				
                                
                                </tr>
						
                                            
                                    </tr>

							<tr >
                                                            <td colspan='3' style="text-align: center">
									<b>PENGELUARAN</b>
								</td>
								<td colspan='2' style="text-align: center">
									<b>PERHITUNGAN TERKAIT PIHAK LAIN</b>
								</td>
							</tr>
							<tr>
                                                            <td style="text-align: center" rowspan="2">
									NAMA AKUN
								</td>
								<td style="text-align: center" rowspan="2">
									KODE AKUN
								</td>
								<td style="text-align: center" rowspan="2">
									JUMLAH UANG
								</td>
								<td colspan="2" style="text-align: center">
									PENERIMAAN DARI PIHAK KE-3
								</td>
								
							</tr>
                                                        <tr>
                                                            <td style="text-align: center">Akun</td>
                                                            <td style="text-align: center">Jumlah Uang</td>
                                                        </tr>
							<tr>
								<td style="vertical-align: top;">
                                    <span id="id_akun_belanja" style="display:none"><?=$akun['id_akun_belanja']?></span>
                                    <b><span id="akun_belanja_nama5d"><?=$akun['nama_akun5digit']?></span></b><br/>
                                  <span id="akun_belanja_nama"><?=$akun['nama_akun']?></span>
                                </td>
                                <td  style="padding-left: 10px;vertical-align: top;">
                                    <b><span id="akun_belanja_kode5d"><?=$akun['kode_akun5digit']?></span></b><br/>
                                  <span id="akun_belanja_kode"><?=$akun['kode_akun']?></span>
                                </td>
                                <td style="text-align: right;padding-right: 10px;vertical-align: top;">
									Rp. <?php echo isset($detail_permintaan['nom'])?number_format($detail_permintaan['nom'], 0, ",", "."):''; ?>
								</td>
                                                                <td  style="text-align: center;">&nbsp;</td>
								<td  style="text-align: right;">&nbsp;</td>
							</tr>
                                                        <tr>
								<td>
									&nbsp;
								</td>
								<td>
									&nbsp;
								</td>
								<td>
									&nbsp;
								</td>
                                                                <td style="padding-left: 10px;"><b>Jumlah Penerimaan</b></td>
								<td  style="text-align: right;">Rp. 0</td>
							</tr>
							<tr>
								<td rowspan="3">
								&nbsp;								
								</td>
								<td rowspan="3">
								&nbsp;								
								</td>
								<td rowspan="3">
								&nbsp;								
								</td>
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
								<td >
									&nbsp;
								</td>
								<td  style="text-align: right;">
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="2">
								Jumlah Pengeluaran
								</td>
								<td style="text-align: right;padding-right: 10px;">
									Rp. <?php echo isset($detail_permintaan['nom'])?number_format($detail_permintaan['nom'], 0, ",", "."):''; ?>
								</td>
								<td>
									&nbsp;
								</td>
								<td  style="text-align: right;">
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="2">
								Dikurangi : Jumlah potongan untuk pihak lain
								</td>
								<td  style="text-align: right;padding-right: 10px;">
									Rp. 0
								</td>
								<td>
									&nbsp;
								</td>
								<td  style="text-align: right;">
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<strong>Jumlah dana yang dikeluarkan</strong>
								</td>
								<td  style="text-align: right;padding-right: 10px;">
									Rp. <?php echo isset($detail_permintaan['nom'])?number_format($detail_permintaan['nom'], 0, ",", "."):''; ?>
								</td>
								<td style="padding-left: 10px;">
									<b>Jumlah Potongan</b>
								</td>
								<td  style="text-align: right;">
									Rp. 0
								</td>
							</tr>
	
				<tr style="border-bottom: none;">
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;">
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
<br />
<form action="<?=site_url('rsa_tambah_ks/cetak_spp')?>" id="form_spp" method="post" style="display: none"  >
    <input type="text" name="dtable" id="dtable" value="" />
</form>
            <div class="alert alert-warning" style="text-align:center">

                    <button type="button" class="btn btn-warning" id="proses_spp"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Setujui SPP</button>
                    <button type="button" class="btn btn-warning" id="tolak_spp" data-toggle="modal" data-target="#myModalTolakSPP"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tolak SPP</button>
                    <button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
                    <!-- <button type="button" class="btn btn-default" id="xls_spp" rel=""><span class="fa fa-file-excel-o" aria-hidden="true"></span> Unduh .xls</button> -->


              </div>
          
      </div>
      <div role="tabpanel" class="tab-pane" id="spm">
          
          <div style="background-color: #EEE; padding: 10px;">
            <div id="div-cetak-spm">



        <div class="alert alert-danger" style="background-color: #FFF;">
            Tidak ada SPM karena SPP terkait belum dibuat.
        </div>


            </div>
</div>
<br />
            <div class="alert alert-warning" style="text-align:center">
                
                    <button type="button" class="btn btn-warning" disabled="disabled"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Proses SPM</button>
                    <button type="button" class="btn btn-info" id="cetak-spm" disabled="disabled" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>


              </div>
          
      </div>


  </div>

</div>

</div>
</div>


	</div>
      
	</div>

<img id="status_spp" style="display: none" src="<?php echo base_url(); ?>/assets/img/verified.png" width="150">

<!-- Modal -->
<div class="modal" id="myModalTolakSPP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <p>Alasan penolakan :</p>
        <p>
            <div class="form-group">
            <textarea class="form-control" id="ket" name="ket"> </textarea>
            </div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="tolak_spp_">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div class="modal fade" id="myModalLihatKet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Perhatian</h4>
      </div>
      <div class="modal-body">
        <p>Alasan penolakan :</p>
        <p>
            <div class="form-group">
            <blockquote>
  <p><?=$ket?></p>
</blockquote>
            </div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div class="modal" id="myModalKonfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Perhatian</h4>
      </div>
      <div class="modal-body">
          <p><b>Mohon perhatian :</b></p>
        <p>
            <div class="form-group">
            <blockquote >
                <p class="text-danger">Sebelum melakukan proses SPM silahkan anda terlebih dahulu mencetak dan menandatangani form tsb. Terima kasih.</p>
              </blockquote>
            </div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
