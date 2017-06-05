<script type="text/javascript">
	$(document).ready(function(){
            
            $("#cetak").click(function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("#div-cetak").printArea( options );
                });
                
                $('[class^="ck_"]').each(function(){
                        //$('#btn-kuitansi').attr('disabled','disabled');
//                        aktv = '0';
                        if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                            // $('#btn-kuitansi').removeAttr('disabled');
//                            aktv = '1';
//                            return false;
                            $(this).prop('checked',false);

                        }
                    });
                $(document).on("click",".btn_proses",function(){
					var id = $(this).attr('rel');
					var rel = [];
					rel[0] = id;
					$('#rel_kuitansi').val(JSON.stringify(rel));
                    $('#form_usulkan_spp').submit();
				// var id = Base64.encode(id); 
                // document.location.href = "<?=site_url("rsa_lsphk3/spp_lsphk3")?>/"+id;
				//	window.location="<?=site_url("rsa_lsphk3/spp_lsphk3")?>/"+encodeURIComponent(JSON.stringify(rel));
                });
                $(document).on("click",".btn_batal",function(){
                        if(confirm('Apakah anda yakin ?')){
                            var id = $(this).attr('rel');
                            var el = $(this);
                            $.ajax({
                                type:"POST",
                                url :"<?=site_url("kuitansi_lsphk3/proses_kuitansi")?>",
                                data:'id=' + id,
                                success:function(data){
//                                    el.removeClass('btn_batal');
//                                    el.attr('disabled','disabled');
//                                    el.attr('rel','');
//                                    
//                                    $('.ck_' + id).attr('disabled','disabled');
//                                    $('.ck_' + id).attr('rel','');

                                    window.location.reload();
                                }
                            });
                        }

                    });
                
		$(document).on("click","#pilih_tahun",function(){

                            window.location = "<?=site_url("kuitansi_lsphk3/daftar_kuitansi2")?>/L3/" + $("#tahun").val();

                    });
                var aktv = '0';    
                $(document).on('change', '[class^="ck_"]', function(){

                        var str = $(this).attr('rel');
//                        var kd_usulan = str.substr(0,24);
//                        var badge_ = $('#badge_id_' + str).html();
//                        var badge = badge_.trim();
                        var el = $(this) ;
                        if(el.is(':enabled')){
//                            $('[class^="all_ck_"]').prop('checked',false);
                            if(el.is(':checked')){
                                // checkbox is checked
                                // alert('t');
//                                if((kd_usulan_tmp != kd_usulan) || badge_tmp != badge ){
//                                    $('[class^="ck_"]').each(function(){
//                                        $(this).prop('checked',false);
                //                        $(this).attr('readonly','readonly');
                //                         console.log($(this).attr('rel'));
//                                    });
//                                }

                                el.prop('checked',true);
                //                console.log(kd_usulan_tmp + ' | ' + kd_usulan);
//                                kd_usulan_tmp = kd_usulan ;
//                                badge_tmp = badge ;

                            }else if(!(el.is(':checked'))){
            //                    $('[class^="all_ck_"]').prop('checked',false);
                            }
                        }
                        $('[class^="ck_"]').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            aktv = '0';
                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
                                aktv = '1';
                                return false;

                            }
                        });
                        $('.btn_proses').each(function(){
                            //$('#btn-kuitansi').attr('disabled','disabled');
                            aktv = '0';
//                            if(($(this).is(':checked'))&&($(this).is(':enabled'))){
                                // $('#btn-kuitansi').removeAttr('disabled');
//                                aktv = '1';
                                return false;

//                            }
                        });
                        if(aktv == '1'){
//                            $('#btn-kuitansi').attr('rel',kd_usulan);
//                            $('#btn-submit-kuitansi').attr('rel',kd_usulan);
                            $('#btn-spp').removeAttr('disabled');
                            // untuk spp ls created by dhanu
//                            $('#btn-buat-ls').attr('rel',str);
//                            $('#btn-buat-ls').removeAttr('disabled');
                            // end here

//                            $('#kode_badge').text(badge_tmp);
                        }else{
//                            $('#btn-kuitansi').attr('rel','');
//                            $('#btn-submit-kuitansi').attr('rel','');
                            $('#btn-spp').attr('disabled','disabled');
                            // untuk spp ls created by dhanu
//                            $('#btn-buat-ls').attr('rel', '');
//                            $('#btn-buat-ls').attr('disabled','disabled');
                            // end here
                        }
                    });
                    
                    $(document).on("click",'.btn-spp',function(){
						//var rel_kuitansi = $(this).attr('rel');
						var rel_kuitansi = [];
						rel_kuitansi[0] = $(this).attr('rel');
                        $('#rel_kuitansi').val(JSON.stringify(rel_kuitansi));
                        $('#form_usulkan_spp').submit();
//                        console.log(JSON.stringify(rel_kuitansi));
                    });
                    
                    
                    $(document).on("click",'#btn-lihat',function(){
                        var rel = $(this).attr('rel');
                        $.ajax({
                            type:"POST",
                            url :"<?=site_url("kuitansi_lsphk3/get_data_kuitansi")?>",
                            data:'id=' + rel,
                            success:function(data){
//                                    console.log(data);
                                    var obj = jQuery.parseJSON(data);
                                    var kuitansi = obj.kuitansi ;
                                    var kuitansi_detail = obj.kuitansi_detail ;
                                    var kuitansi_detail_pajak = obj.kuitansi_detail_pajak ;
                                    $('#kode_badge').text('L3');
                                    $('#kuitansi_tahun').text(kuitansi.tahun);
                                    $('#kuitansi_no_bukti').text(kuitansi.no_bukti);
                                    $('#kuitansi_txt_akun').text(kuitansi.nama_akun);
                                    $('#uraian').text(kuitansi.uraian);
                                    $('#nm_subkomponen').text(kuitansi.nama_subkomponen);
                                    $('#penerima_uang').text(kuitansi.penerima_uang);
                                    var a = moment(kuitansi.tgl_kuitansi);
//                                    var b = moment(a).add('hours', 1);
//                                    var c = b.format("YYYY-MM-DD HH-mm-ss");
                                    $('#tgl_kuitansi').text(a.locale("id").format("D MMMM YYYY"));//kuitansi.tgl_kuitansi);
                                    $('#nmpppk').text(kuitansi.nmpppk);
                                    $('#nippppk').text(kuitansi.nippppk);
                                    $('#nmbendahara').text(kuitansi.nmbendahara);
                                    $('#nipbendahara').text(kuitansi.nipbendahara);
                                    if(kuitansi.nmpumk != ''){
                                        $('#td_tglpumk').show();
                                        $('#td_nmpumk').show();
                                    }else{
                                        $('#td_tglpumk').hide();
                                        $('#td_nmpumk').hide();
                                    }
                                    $('#nmpumk').text(kuitansi.nmpumk);
                                    $('#nippumk').text(kuitansi.nippumk);
                                    $('#penerima_barang').text(kuitansi.penerima_barang);
                                    $('#penerima_barang_nip').text(kuitansi.penerima_barang_nip);
                                    
                                    $('#tr_isi').remove();
                                    $('.tr_new').remove();
                                    $('<tr id="tr_isi"><td colspan="11">&nbsp;</td></tr>').insertAfter($('#before_tr_isi'));
                                    
                                    var str_isi = '';
                                    $.each(kuitansi_detail,function(i,v){ 
                                        str_isi = str_isi + '<tr class="tr_new">';
                                        str_isi = str_isi + '<td colspan="3">' + (i+1) + '. ' + v.deskripsi + '</td>' ; 
                                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">' + v.volume + '</td>' ;
                                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">' + v.satuan + '</td>' ;
                                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;">' + angka_to_string(v.harga_satuan) + '</td>' ;
                                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;" class="sub_tot_bruto_' + i +'">' + angka_to_string(v.bruto) + '</td>' ;
                                        var str_pajak = '' ;
                                        var str_pajak_nom = '' ;
                                        $.each(kuitansi_detail_pajak,function(ii,vv){
                                            if(vv.id_kuitansi_detail == v.id_kuitansi_detail){
                                                var jenis_pajak_ = vv.jenis_pajak ;
                                                var jenis_pajak = jenis_pajak_.split("_").join(" ");
                                                var dpp = vv.dpp == '0' ? '' : '(dpp)';
                                                var str_99 = (vv.persen_pajak == '99')? '' : vv.persen_pajak + '% ' ;
                                                str_pajak = str_pajak + jenis_pajak + ' ' + str_99 + dpp + '<br>' ;
                                                
                                                str_pajak_nom = str_pajak_nom + '<span rel="'+ i +'" class="sub_tot_pajak_'+ i +'">'+ angka_to_string(vv.rupiah_pajak) +'</span><br>' ; 
                                            }
                                        });
                                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;">'+ str_pajak +'</td>' ; 
                                        str_pajak_nom = (str_pajak_nom=='')?'<span rel="'+ i +'" class="sub_tot_pajak_'+ i +'">'+'0'+'</span>':str_pajak_nom;
                                        str_isi = str_isi + '<td style="text-align:right;" >'+ str_pajak_nom +'</td>' ;  
                                        
                                        str_isi = str_isi + '<td><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></td>' ;
                                        str_isi = str_isi + '<td style="text-align:right" class="sub_tot_netto_'+ i +'">0</td>' ; 
                                        
                                            str_isi = str_isi + '</tr>' ;

                                            });

                                            
                                            
                                            $('#tr_isi').replaceWith(str_isi);
                                            
                                            var sum_tot_bruto = 0 ;
                                            $('[class^="sub_tot_bruto_"').each(function(){
                                                sum_tot_bruto = sum_tot_bruto + parseInt(string_to_angka($(this).html()));
                                            });
                                            $('.sum_tot_bruto').html(angka_to_string(sum_tot_bruto));
                                            
                                            var sub_tot_pajak = 0 ;
                                            $('[class^="sub_tot_pajak_"]').each(function(){
                                                sub_tot_pajak = sub_tot_pajak + parseInt(string_to_angka($(this).text())) ;
                                            });
                                            $('.sum_tot_pajak').html(angka_to_string(sub_tot_pajak));
                                            
                                            $('[class^="sub_tot_pajak_"]').each(function(){
                                                var prel = $(this).attr('rel');
                                                var sub_tot_pajak__  = 0 ;
//                                                console.log(prel + ' ' + sub_tot_pajak__);
                                                $('[class^="sub_tot_pajak_' + prel + '"]').each(function(){
                                                    sub_tot_pajak__ = sub_tot_pajak__ + parseInt(string_to_angka($(this).text())) ;
                                                });
                                                var sub_tot_bruto_ = parseInt(string_to_angka($('.sub_tot_bruto_' + prel ).text())) ;
                                                $('.sub_tot_netto_' + prel).html(angka_to_string(sub_tot_bruto_ - sub_tot_pajak__));
                                            });

                                            var sum_tot_netto = 0 ;
                                            $('[class^="sub_tot_netto_"').each(function(){
                                                sum_tot_netto = sum_tot_netto + parseInt(string_to_angka($(this).html()));
                                            });

                                            $('.sum_tot_netto').html(angka_to_string(sum_tot_netto));

                                            $('.text_tot').html(terbilang(sum_tot_bruto));
                                            
                                            $('#nbukti').val(kuitansi.no_bukti);
                                            $('#myModalKuitansi').modal('show');
    //                                        i++ ;
                                        }

            //                        location.reload();
                        });
            
                        
                    });
                    
                        $(document).on("click","#down",function(){
                        
//                                        var uri = $("#kuitansi").excelexportjs({
//                                                        containerid: "kuitansi"
//                                                        , datatype: "table"
//                                                        , returnUri: true
//                                                    });

                            var uri = $.base64.encode($("#bd-kuitansi").html()) ;

                            
                            $('#dtable').val(uri);
                            $('#form_kuitansi').submit();



                        });
        });
        
function string_to_angka(str){

        return str.split('.').join("");

}

function angka_to_string(num){

        var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        return str_hasil;
}

function terbilang(bilangan) {

 bilangan    = String(bilangan);
 var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
 var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
 var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

 var panjang_bilangan = bilangan.length;

 /* pengujian panjang bilangan */
 if (panjang_bilangan > 15) {
   kaLimat = "Diluar Batas";
   return kaLimat;
 }

 /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
 for (i = 1; i <= panjang_bilangan; i++) {
   angka[i] = bilangan.substr(-(i),1);
 }

 i = 1;
 j = 0;
 kaLimat = "";


 /* mulai proses iterasi terhadap array angka */
 while (i <= panjang_bilangan) {

   subkaLimat = "";
   kata1 = "";
   kata2 = "";
   kata3 = "";

   /* untuk Ratusan */
   if (angka[i+2] != "0") {
     if (angka[i+2] == "1") {
       kata1 = "Seratus";
     } else {
       kata1 = kata[angka[i+2]] + " Ratus";
     }
   }

   /* untuk Puluhan atau Belasan */
   if (angka[i+1] != "0") {
     if (angka[i+1] == "1") {
       if (angka[i] == "0") {
         kata2 = "Sepuluh";
       } else if (angka[i] == "1") {
         kata2 = "Sebelas";
       } else {
         kata2 = kata[angka[i]] + " Belas";
       }
     } else {
       kata2 = kata[angka[i+1]] + " Puluh";
     }
   }

   /* untuk Satuan */
   if (angka[i] != "0") {
     if (angka[i+1] != "1") {
       kata3 = kata[angka[i]];
     }
   }

   /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
   if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
     subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
   }

   /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
   kaLimat = subkaLimat + kaLimat;
   i = i + 3;
   j = j + 1;

 }

 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
 if ((angka[5] == "0") && (angka[6] == "0")) {
   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
 }

 return kaLimat + "Rupiah";
}
</script>
<div id="page-wrapper">
	<div id="page-inner">
		<!-- start content -->
                
                <div class="row">
                    <div class="col-lg-12">
                        <h2>DAFTAR DATA UNTUK SPP/SPM LS PIHAK 3 NON KONTRAK</h2> 
                    </div>
                </div>
                <hr />

		<div class="row">
			<div class="col-md-12">
                            
				<form id="kentut" class="form-horizontal">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-1">Tahun: </label>
								<div class="col-md-3">
									<?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'validate[required] form-control','id'=>'tahun'))?>
								</div>
								<div class="col-md-1">
									<button type="button" class="btn btn-primary btn-sm" id="pilih_tahun">Pilih Tahun</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
               
		<div class="row">
			<div class="col-md-12 table-responsive">
				<table class="table table-bordered table-striped table-hover small">
					<thead>
					<tr>
						<th class="text-center col-md-1">No</th>
                                                <th class="text-center col-md-2">Nomor</th>
						<th class="text-center col-md-2">Tanggal</th>
                                                <th class="text-center col-md-2">Uraian</th>
						<th class="text-center col-md-2">Pengeluaran</th>
						<th class="text-center col-md-1">&nbsp;</th>
                                                <th class="text-center col-md-1">Status</th>
                                                <th class="text-center col-md-1">Proses SPP</th>
						
					</tr>
					</thead>
					<tbody>
	<?php
		if(!empty($daftar_kuitansi)){
			foreach ($daftar_kuitansi as $key => $value) {
	?>
					<tr>
						<td class="text-center"><?php echo $key + 1; ?>.</td>
						<td class="text-center"><?php echo $value->no_bukti; ?></td>
                       <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_kuitansi)); ?><br /></td>
						<td class=""><?php echo $value->uraian; ?></td>
						<td class="text-right"><?=number_format($value->pengeluaran, 0, ",", ".")?></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                                <button  class="btn btn-default btn-sm" rel="<?php echo $value->id_kuitansi; ?>" id="btn-lihat" ><i class="glyphicon glyphicon-search"></i></button>
							</div>
                                                </td>
                                                <td class="text-center">
                                                    <?php if($value->aktif == "1"):?>
                                                        <?php if(is_null($value->str_nomor_trx)):?>
                                                        <button type="button" class="btn btn-danger btn-sm btn_batal" rel="<?php echo $value->id_kuitansi; ?>" title="Batal"><i class="glyphicon glyphicon-remove"></i></button>
                                                        <?php else: ?>
                                                            <?php if($value->cair == '0'):?>
                                                            <button type="button" class="btn btn-success btn-sm btn_proses" rel="<?php echo $value->id_kuitansi; ?>" title="Diajukan SPP/SPM"><i class="glyphicon glyphicon-file"></i></button>
                                                            <?php else: ?>
                                                            <button type="button" class="btn btn-info btn-sm" rel="<?php echo $value->id_kuitansi; ?>" title="Cair"><i class="glyphicon glyphicon-file"></i></button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                    <button type="button" class="btn btn-danger btn-sm btn_batal" rel="" disabled="disabled" ><i class="glyphicon glyphicon-remove"></i></button>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">                                                                                                      
                                                          <?php if($value->aktif == "1"):?>
                                                            <?php if(is_null($value->str_nomor_trx)):?>
                                                            <!--<input type="checkbox" aria-label="" rel="<?=$value->id_kuitansi?>" class="ck_<?=$value->id_kuitansi?>">-->
															<button class="btn btn-warning btn-spp" rel="<?=$value->id_kuitansi?>"><i class="fa fa-spinner"></i></button>
                                                            <?php else: ?>
                                                            <!--<input type="checkbox" checked="checked" aria-label="" rel="" disabled="disabled" class="">-->
                                                            <?php endif; ?>
                                                          
                                                          <?php else: ?>
                                                          <!--<input type="checkbox" aria-label="" rel="" disabled="disabled" class="ck_<?=$value->id_kuitansi?>">-->
                                                          <?php endif; ?>
                                                      
                                                </td>
					</tr>
	<?php
			}
		}else{
	?>
					<tr>
						<td colspan="8" class="text-center alert-warning">
						Tidak ada data
						</td>
					</tr>
	<?php
		}
	?>
					<tr>
						<td colspan="8" >&nbsp;</td>
					</tr>
                                        </tbody>
				</table>
				<form action="<?=site_url('rsa_lsphk3/create_spp_lsphk3_nk')?>" id="form_usulkan_spp" method="post" style="display: none">
					<input type="text" name="rel_kuitansi" id="rel_kuitansi" value=""/>
					<input type="text" name="proses" id="proses" value="SPP-DRAFT" />
				</form>
			</div>
		</div>

		<!-- end content -->
	</div>
</div>

<div class="modal" id="myModalMessage" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i> Perhatian :</h4>
          </div>
          <div class="modal-body" style="margin:15px;padding:0px;padding-bottom: 15px;word-wrap: break-word;">
          	<form id="alasan_nolak">
          		<input type="hidden" name="id_sppls" id="id_sppls" value=""/>
          		<input type="hidden" name="proses" id="proses" value="0"/>
          		<div class="form-group">
          			<label for="alasan_tolak">Alasan Menolak SPP:</label>
          			<textarea class="form-control" name="alasan_tolak" id="alasan_tolak"></textarea>
          		</div>
          	</form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning tolak_mentah2"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> OK</button>
          </div>
        </div>
    </div>
</div>

<div class="modal " id="myModalKuitansi" role="dialog" aria-labelledby="myModalKuitansiLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel">Kuitansi : <span id="kode_badge">-</span></h4>
          </div>
          <div class="modal-body" style="margin:0px;padding:15px;background-color: #EEE;">
              <div id="div-cetak">
              <table class="table_print" id="kuitansi" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 800px;border: 1px solid #000;background-color: #FFF;" cellspacing="0px" border="0">
                <tr>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                            <td class="col-md-1">&nbsp;</td>
                </tr>
                  <tr>
                                <td rowspan="3" style="text-align: center" colspan="2">
					<img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
				</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>


                                <td colspan="2">Tahun Anggaran</td>
                                <td style="text-align: center">:</td>
                                <td colspan="2"><span id="kuitansi_tahun">0000</span></td>
                        </tr>
                        <tr>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>

                                <td colspan="2">Nomor Bukti</td>
                                <td style="text-align: center">:</td>
                                <td colspan="2" id="kuitansi_no_bukti">-</td>
                        </tr>
                        <tr class="tr_up">
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>
                                <td >&nbsp;</td>

                                <td colspan="2">Anggaran</td>
                                <td style="text-align: center">:</td>
                                <td colspan="2" id="kuitansi_txt_akun">-</td>

			</tr>
			<tr>
                                <td colspan="11">
                                    &nbsp;
				</td>
                        </tr>
			<tr>
				<td colspan="11">
                                    <h4 style="text-align: center"><b>KUITANSI / BUKTI PEMBAYARAN</b></h4>
				</td>
			</tr>
                        <tr>
                                <td colspan="11">
                                    &nbsp;
				</td>
                        </tr>
			<tr class="tr_up">
				<td colspan="3">Sudah Diterima dari</td>
				<td>: </td>
                                <td colspan="7">Pejabat Pelaksana Dan Pengendali Kegiatan (PPPK)<!-- / Pejabat Pelaksana dan Pengendali Kegiatan --> <?=$nm_unit?></td>
			</tr>
			<tr class="tr_up">
				<td colspan="3">Jumlah Uang</td>
				<td>: </td>
                                <td colspan="7"><b>Rp. <span class="sum_tot_bruto">0</span>,-</b></td>
			</tr>
			<tr class="tr_up">
				<td colspan="3">Terbilang</td>
				<td>: </td>
                                <td colspan="7"><b><span class="text_tot">-</span></b></td>
			</tr>
			<tr class="tr_up">
				<td colspan="3">Untuk Pembayaran</td>
				<td>: </td>
                                <td colspan="7"><span id="uraian">-</span></td>
			</tr>
			<tr class="tr_up">
				<td colspan="3">Sub Kegiatan</td>
				<td>: </td>
                                <td colspan="7"><span id="nm_subkomponen">-</span></td>
			</tr>
                        <tr>
                                <td colspan="11">
                                    &nbsp;
				</td>
                        </tr>
                        <tr id="before_tr_isi">
                            <td colspan="3"><b>Deskripsi</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Kuantitas</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Satuan</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Harga@</b></td>
                            <td style="padding: 0 5px 0 5px;"><b>Bruto</b></td>
                            <td style="padding: 0 5px 0 5px;" colspan="2"><b>Pajak</b></td>
                            <td >&nbsp;</td>
                            <td ><b>Netto</b></td>
			</tr>
                        <tr id="tr_isi">
                            <td colspan="11">&nbsp;</td>
			</tr>
                        <tr>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td ><b>Jumlah</b></td>
                            <td >&nbsp;</td>
                            <td style="text-align: right"><b><span class="sum_tot_bruto">0</span></b></td>
                            <td >&nbsp;</td>
                            <td style="text-align: right"><b><span class="sum_tot_pajak">0</span></b></td>
                            <td ><b><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></b></td>
                            <td style="text-align: right"><b><span class="sum_tot_netto">0</span></b></td>
			</tr>
                        <tr>
                                <td colspan="11">
                                    &nbsp;
				</td>
                        </tr>
			<tr>
                            <td colspan="8">Setuju dibebankan pada mata anggaran berkenaan, <br />
                                a.n. Kuasa Pengguna Anggaran <br />
                                Pejabat Pelaksana Dan Pengendali Kegiatan (PPPK)
                            </td>
                            <td colspan="3">
                                Semarang, <span id="tgl_kuitansi">-</span><br />
                                Penerima Uang
                            </td>
			</tr>
                        <tr>
                                <td colspan="11">
                                    <br>
                                    <br>
				</td>
                        </tr>
                        <tr >
                            <td colspan="8" style="border-bottom: 1px solid #000"><span id="nmpppk">-</span><br>
                                    NIP. <span id="nippppk">-</span></td>
                            <td colspan="3" style="border-bottom: 1px solid #000"><span class="edit_here" id="penerima_uang">-</span><br />
                                <!--NIP. <span class="edit_here" contenteditable="true" id="penerima_uang_nip">- edit here -</span></td>-->
                            </td>
			</tr>
                        <tr >
                            <td colspan="8">Setuju dibayar tgl : <br>
                                Bendahara Pengeluaran
                            </td>
                            <td colspan="3" ><span style="display: none" id="td_tglpumk">Lunas dibayar tgl : <br>
                                    Pemegang Uang Kerja/ Bendahara Pengeluaran</span>
                            </td>
                        </tr>
                        <tr>
                                <td colspan="11">
                                    <br>
                                    <br>
				</td>
                        </tr>
                         <tr>
                             <td colspan="8"><span id="nmbendahara"></span><br>
                                 NIP. <span id="nipbendahara"></span>
                            </td>
                            <td colspan="3" ><span style="display: none" id="td_nmpumk"><span id="nmpumk"></span><br>
                                    NIP. <span id="nippumk"></span></span>
                            </td>
                        </tr>
			<tr >
				<td colspan="11" style="border-top:1px solid #000">
				Barang/Pekerjaan tersebut telah diterima /diselesaikan  dengan lengkap dan baik.<br>
				Penerima Barang/jasa
				</td>
                        </tr>
                        <tr>
                                <td colspan="11">
                                    <br>
                                    <br>
				</td>
                        </tr>
                        <tr>
                            <td colspan="11" ><span id="penerima_barang">-</span><br />
                                    NIP. <span id="penerima_barang_nip">-</span>
				</td>
			</tr>

		</table>
              </div>
              </div> 
              <form action="<?=site_url('kuitansi/cetak_kuitansi')?>" id="form_kuitansi" method="post" style="display: none"  >
                    <input type="text" name="dtable" id="dtable" value="" />
                    <input type="text" name="nbukti" id="nbukti" value="" />
                    <input type="text" name="dunit" id="dunit" value="<?=$alias?>" />
                    <input type="text" name="dtahun" id="dtahun" value="<?=$cur_tahun?>" />
                </form>
          
            

          <div class="modal-footer">
            <!--<button type="button" class="btn btn-success" id="down" ><span class="glyphicon glyphicon glyphicon-save-file" aria-hidden="true"></span> Download</button>-->
            <button type="button" class="btn btn-info" id="cetak" rel="" ><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
          </div>
        </div>
    </div>
</div>
