<script type="text/javascript">

$(document).ready(function(){
    $(document).on("click",'#btn-proses',function(){
        if($('input[name="kd_akun_kas"]:checked').length > 0){
            var kd_akun_kas = $("input[name='kd_akun_kas']:checked").val();
            var nominal = string_to_angka($('#nominal').html());
            var saldo_kas = string_to_angka($('#h_input_' + kd_akun_kas).val());
            
            console.log(nominal + ' ' + saldo_kas);
            
            if(parseInt(saldo_kas) < parseInt(nominal)){
                alert('Mohon maaf, saldo kas tidak mencukupi');
                    
            }else{
                if(confirm('Apakah anda yakin ?')){
                    
                    var data = 'proses=' + 'SPM-FINAL-KBUU' + '&nomor_trx=' + $('#nomor_trx_spm').html() + '&jenis=' + 'SPM' + '&tahun=' + '<?=$cur_tahun?>' +'&kd_unit=' + '<?=$kd_unit?>' + '&kd_akun_kas=' + kd_akun_kas + '&kredit=' + '<?=$detail_up['nom']?>' + '&deskripsi=' + 'UP <?=$alias?>' + '&nominal=' + nominal ;
                    $.ajax({
                        type:"POST",
                        url :"<?=site_url('rsa_up/proses_final_up')?>",
                        data:data,
                        success:function(data){
        //                        console.log(data)
        //                        $('#no_bukti').html(data);
        //                        $('#myModalKuitansi').modal('show');
                                if(data=='sukses'){
                                    location.reload();
                                }
        //                        
                        }
                    });
                }
            }
            
        }else{
            alert('Mohon pilih salah satu akun dahulu.');
        }
    });
    
    $(document).on("click",'#proses_spm_kpa',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPM-FINAL-KBUU' + '&kd_unit=' + '<?=$kd_unit?>';
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_up/proses_spm_up')?>",
                data:data,
                success:function(data){
//                        console.log(data)
//                        $('#no_bukti').html(data);
//                        $('#myModalKuitansi').modal('show');
                        if(data=='sukses'){
                            location.reload();
                        }
//                        
                }
            });
        }
    });
    
    $(document).on("click",'#tolak_spm_kpa',function(){
        if(confirm('Apakah anda yakin ?')){
            var data = 'proses=' + 'SPM-DITOLAK-KBUU' + '&nomor_trx=' + $('#nomor_trx_spm').html() + '&jenis=' + 'SPM' + '&ket=' + $('#ket').val() + '&kd_unit=' + '<?=$kd_unit?>' + '&tahun=' + '<?=$cur_tahun?>';
            $.ajax({
                type:"POST",
                url :"<?=site_url('rsa_up/proses_spm_up')?>",
                data:data,
                success:function(data){
//                        console.log(data)
//                        $('#no_bukti').html(data);
//                        $('#myModalKuitansi').modal('show');
                        if(data=='sukses'){
                            location.reload();
                        }
//                        
                }
            });
        }
    });
    
    $('#myModalTolakSPMPPK').on('shown.bs.modal', function (e) {
        // do something...
        $('#ket').focus();
      })
    
    $(document).on("click","#down",function(){
                    var uri = $("#table_spp_up").excelexportjs({
                                    containerid: "table_spp_up"
                                    , datatype: "table"
                                    , returnUri: true
                                });

        $('#dtable').val(uri);
        $('#form_spp').submit();

    
    });
    
    $(document).on("click","#down_2",function(){
                    var uri = $("#table_spm_up").excelexportjs({
                                    containerid: "table_spm_up"
                                    , datatype: "table"
                                    , returnUri: true
                                });

        $('#dtable_2').val(uri);
        $('#form_spm').submit();

    
    });

});


function b64toBlob(b64Data, contentType, sliceSize){
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
        
        
</script>  

<div id="page-wrapper" >
<div id="page-inner">
    
    <div class="row">
                    <div class="col-lg-12">
                     <h2>USULAN SPP/SPM</h2>    
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
                        
    <?php if($doc_up == ''){ $stts_bendahara = 'active'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPP UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> belum diusulkan oleh bendahara.</div>
    <?php }elseif($doc_up == 'SPP-DRAFT'){ $stts_bendahara = 'done'; $stts_ppk = 'active'; ?>
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >PPK </span></b> .</div>
    <?php }elseif($doc_up == 'SPP-DITOLAK'){ $stts_bendahara = 'active'; ?>
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPP UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >PPK </span></b> <b>[ <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_up == 'SPP-FINAL'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPP UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah diterima oleh <b><span class="text-danger" >PPK </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DRAFT-PPK'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'active'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KPA </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DRAFT-KPA'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'active'; ?>   
        <div class="alert alert-info" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >VERIFIKATOR </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DITOLAK-KPA'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KPA </span></b> <b>[ <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_up == 'SPM-FINAL-VERIFIKATOR'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'active' ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> menunggu persetujuan <b><span class="text-danger" >KUASA BUU </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DITOLAK-VERIFIKATOR'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >VERIFIKATOR </span></b> <b>[ <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_up == 'SPM-FINAL-KBUU'){ $stts_bendahara = 'done'; $stts_ppk = 'done'; $stts_kpa = 'done' ; $stts_verifikator = 'done'; $stts_kbuu = 'done' ?>   
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah disetujui oleh <b><span class="text-danger" >BUU </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DITOLAK-KBUU'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >KUASA BUU </span></b> <b>[ <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php }elseif($doc_up == 'SPM-FINAL-BUU'){ $stts_bendahara = 'done'; ?> 
        <div class="alert alert-success" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah difinalisasi oleh <b><span class="text-danger" >BUU </span></b> .</div>
    <?php }elseif($doc_up == 'SPM-DITOLAK-BUU'){ $stts_bendahara = 'active'; ?>   
        <div class="alert alert-warning" style="border:1px solid #a94442;">SPM UP Tahun <b><span class="text-danger" ><?=$cur_tahun?></span></b> telah ditolak oleh <b><span class="text-danger" >BUU </span></b> <b>[ <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLihatKet" >alasan</a> ]</b>.</div>
    <?php } ?>
        
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



          <div style="background-color: #EEE; padding: 10px;">

		<table id="table_spm_up" style="font-family:arial;font-size:11px; line-height: 21px;border-collapse: collapse;width: auto;border: 1px solid #000;background-color: #FFF;" cellspacing="0" border="1" cellpadding="0" >
			<tbody>
                            <tr >
                                <td colspan="5" style="text-align: right;font-size: 30px;padding: 10px;"><b>F2</b></td>
                            </tr>
                            
                            <tr >
                                <td colspan="5" style="text-align: center;padding-top: 5px;padding-bottom: 5px;"><img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60"></td>
                            </tr>
                            <tr style="">
                                    <td colspan="5" style="text-align: center;font-size: 20px;border-bottom: none;"><b>UNIVERSITAS DIPONEGORO</b></td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="5" style="text-align: center;font-size: 16px;border-bottom: none;border-top: none;"><b>SURAT PERINTAH MEMBAYAR</b></td>
                                </tr>
                                <tr style="border-top: none;border-bottom: none;">
                                    <td colspan="2" style="border-right: none;border-right: none;border-top: none;border-bottom: none;"><b>TAHUN ANGGARAN : <?=$cur_tahun?></b></td>
                                    <td style="text-align: center;border-right: none;border-left: none;border-top: none;border-bottom: none;" colspan="2"><b>JENIS : UP</b></td>
                                    <td style="border-left: none;border-top: none;border-bottom: none;">&nbsp;</td>
                                </tr>
                                <tr style="border-top: none;">
                                    <td colspan="2" style="border-right: none;border-top:none;"><b>Tanggal	: <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm==''?'':strftime("%d %B %Y", strtotime($tgl_spm)); ?></td>
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
                                                    Kuasa Bendahara Umum Undip ( Kuasa BUU )<br>
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
                                            <li>Jumlah pembayaran yang diminta : Rp. <span id="nominal"><?=number_format($detail_up['nom'], 0, ",", ".")?></span>,-<br>
                                                &nbsp;&nbsp;&nbsp;(Terbilang : <b><?=ucwords($detail_up['terbilang']).'Rupiah'?></b>)</li>
                                                <li>Untuk keperluan : Pengisian uang persediaan</li>
                                                <li>Nama bendahara pengeluaran : <?=isset($detail_pic->nm_lengkap)?$detail_pic->nm_lengkap:''?></li>
                                                <li>Alamat : <?=isset($detail_pic->alamat)?$detail_pic->alamat:''?></li>
                                                <li>Nama Bank : <?=isset($detail_pic->nama_bank)?$detail_pic->nama_bank:''?></li>
                                                <li>No. Rekening Bank : <?=isset($detail_pic->no_rek)?$detail_pic->no_rek:''?></li>
                                                <li>No. NPWP : <?=isset($detail_pic->npwp)?$detail_pic->npwp:''?></li>
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
								<td>
									Kas di bendahara pengeluaran
								</td>
								<td>
									12111
								</td>
								<td>
									Rp. <?=number_format($detail_up['nom'], 0, ",", ".")?>
								</td>
                                                                <td >-</td>
								<td >Rp.-</td>
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
                                                                <td ><b>Jumlah Penerimaan</b></td>
								<td >Rp.0</td>
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
									Iuran wajib Pegawai
								</td>
								<td >
									Rp.0
								</td>
							</tr>
							<tr>
								<td colspan="2">
								Jumlah Pengeluaran
								</td>
								<td>
									Rp. <?=number_format($detail_up['nom'], 0, ",", ".")?>
								</td>
								<td>
									Pajak Penghasilan
								</td>
								<td >
									Rp.-
								</td>
							</tr>
							<tr>
								<td colspan="2">
								Dikurangi : Jumlah potongan untuk pihak lain
								</td>
								<td>
									Rp. 0
								</td>
								<td>
									
								</td>
								<td >
									Rp.0
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<strong>Jumlah pembayaran yang diminta</strong>
								</td>
								<td>
									Rp. <?=number_format($detail_up['nom'], 0, ",", ".")?>,-
								</td>
								<td>
									<b>Jumlah Potongan</b>
								</td>
								<td >
									Rp.0
								</td>
							</tr>
	
				<tr style="border-bottom: none;">
                                    <td colspan="5" style="line-height: 16px;border-bottom: none;">
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
									<?=isset($detail_ppk->nm_lengkap)?$detail_ppk->nm_lengkap:''?><br>
									NIP. <?=isset($detail_ppk->nomor_induk)?$detail_ppk->nomor_induk:''?><br>
								</td>
				
                                    <td  style="border-left: none;border-right: none;border-top:none;">&nbsp;</td>
								<td  style="line-height: 16px;border-left: none;border-top:none;">
									Semarang, <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm_kpa==''?'':strftime("%d %B %Y", strtotime($tgl_spm_kpa)); ?><br />
									Pengguna Anggaran/Kuasa Pengguna Anggaran<br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
                                                                        <br>
									<?=isset($detail_kpa->nm_lengkap)?$detail_kpa->nm_lengkap:''?><br>
									NIP. <?=isset($detail_kpa->nomor_induk)?$detail_kpa->nomor_induk:''?><br>
								</td>
				</tr>
				<tr>
					<td colspan="5"  style="line-height: 16px;">
						<strong>Keterangan:</strong>
						<ul>
							<li>Semua bukti Pengeluaran untuk pekerjaan dengan perjanjian yang disahkan Pejabat Pembuat Komitmen telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan diusahakan oleh Pejabat Penatasuahaan Keuangan SUKPA</li>
							<li>
							Semua Bukti-bukti pengeluaran untuk pekerjaan yang disahkan Pejabat Pelaksana dan Pengendali Kegiatan (PPPK) telah diuji dan dinyatakan memenuhi persyaratan untuk dilakukan pembayaran atas beban RKAT Undip, selanjutnya bukti-bukti pengeluaran dimaksud disimpan dan ditatausahakan oleh Pejabat Penatausahaan SUKPA.
							</li>
							<li>Kebenaran perhitungan dan isi tertuang dalam SPM ini menjadi tanggung Jawab bendahara Pengeluaran sepanjang sesuai dengan bukti-bukti pengeluaran yang telah ditandatangani oleh PPPK atau PPK</li>
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
                                        <?=$detail_verifikator->nm_lengkap?><br>
                                        NIP. <?=$detail_verifikator->nomor_induk?><br>
                                    </td>
                                    <td colspan="2" style="vertical-align: top;line-height: 16px;">
                                        <?php if($detail_up['nom'] >= 100000000){ ?>
                                        Setuju dibayar : <br>
                                        Kuasa Bendahara Umum Undip harap membayar<br>
                                        kepada nama yang tersebut sesuai SPM dari PA / KPA<br>
                                        Bendahara Umum Undip<br>
                                        <br>
                                        <br>
                                        <br>
                                        <?=$detail_buu->nm_lengkap?><br>
                                        NIP. <?=$detail_buu->nomor_induk?><br>
                                        <?php }else{ ?>
                                        &nbsp;
                                        <?php } ?>
                                    </td>
                                    <td style="vertical-align: top;line-height: 16px;">
                                        Tanggal : <?php setlocale(LC_ALL, 'id_ID.utf8'); echo $tgl_spm_kbuu==''?'':strftime("%d %B %Y", strtotime($tgl_spm_kbuu)); ?><br />
                                        Telah dibayar oleh <br>
                                        Kuasa Bendahara Umum Undip<br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <?=$detail_kuasa_buu->nm_lengkap?><br>
                                        NIP. <?=$detail_kuasa_buu->nomor_induk?><br>
                                    </td>
                                </tr>
			</tbody>
		</table>
</div>
<br />
<form action="<?=site_url('rsa_up/cetak_spm')?>" id="form_spm" method="post" style="display: none"  >
    <input type="text" name="dtable_2" id="dtable_2" value="" />
</form>
            <div class="alert alert-warning" style="text-align:center">
                
                <?php if($doc_up == 'SPM-FINAL-VERIFIKATOR'){ ?>
                    <a href="#" class="btn btn-warning" id="" data-toggle="modal" data-target="#myModalKas"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Setujui SPM</a>
                    <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#myModalTolakSPMPPK"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tolak SPM</a>
                    <a href="#" class="btn btn-success" id="down_2"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</a>
                <?php }else{ ?> 
                    <a href="#" class="btn btn-warning" disabled="disabled" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Setujui SPM</a>
                    <a href="#" class="btn btn-warning" disabled="disabled"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Tolak SPM</a>
                    <a href="#" class="btn btn-success" id="down_2"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</a>
                <?php } ?>
                

                    

              </div>
          



</div>


	</div>
      
	</div>
</div>
      
	</div>
<img style="display: none" id="status_spp" src="<?php echo base_url(); ?>/assets/img/waitting.png" width="200">

<!-- Modal -->
<div class="modal fade" id="myModalTolakSPMPPK" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
        <button type="button" class="btn btn-primary" id="tolak_spm_kpa">Submit</button>
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


<!-- POP UP PILIH PENCAIRAN -->
<div class="modal" id="myModalKas" tabindex="-1" role="dialog" aria-labelledby="myModalKas">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
            <label for="exampleInputEmail1">Pilih Kas [ Saldo Tersedia ] :</label>
            <?php foreach($kas_undip as $ku): ?>
            <div class="row">
                
                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <input type="radio" aria-label="" rel="" class="rdo_up" name="kd_akun_kas" value="<?=$ku->kd_akun_kas?>">
                    </span>
                      <input type="hidden" value="<?=$ku->saldo?>" name="h_input_<?=$ku->kd_akun_kas?>" id="h_input_<?=$ku->kd_akun_kas?>" />
                      <input type="text" class="form-control" aria-label="" value="<?=$ku->nm_kas_5?> [ Rp. <?=number_format($ku->saldo, 0, ",", ".")?>,- ] " readonly="readonly">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
               
            </div>
             <?php endforeach;?>
            </div>
          </div>
           
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-proses" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Pilih</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
          </div>
        </div>
    </div>
</div>
