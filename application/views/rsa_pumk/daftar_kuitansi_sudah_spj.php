<script>

	$(document).ready(function(){

		$(document).on('change', '.ck', function(){
			if($(this).is(':checked')){
				var value = $(this).attr("rel");
			}
		});

		

		$("#spj_pumk").click(function(event){
			event.preventDefault();
			var kuitansi = $(".ck:checkbox:checked").map(function(){
				return $(this).attr("rel");
		    }).get(); // <----
			var data = "data="+kuitansi;
			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_pumk/form_tambah_spj_pumk")?>",
				data:data,
				success:function(respon){
					$("#modal_content").html(respon);
				},
				complete:function(){
					$('#lihat_modal').modal('show');
				}
			});
		});

		function string_to_angka(str){
			return str.split('.').join("");
		}

		function angka_to_string(num){
			var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			return str_hasil;
		}

		$(document).on("click",'.btn-lihat',function(){

                        var rel = $(this).attr('rel');
                        $.ajax({
									type:"POST",
									url:"<?=site_url("rsa_pumk/get_jenis")?>",
									data:'id=' + rel,
									success:function(respon){
										if (respon == 'LK') {
											$("#jenis_ppk").html('Pejabat Pembuat Komitmen (PPK)');
	                             }else{
											$("#jenis_ppk").html('Pejabat Pelaksana dan Pengendali Kegiatan (PPPK)');
                             	}
									}
								});


                        $.ajax({
                            type:"POST",
                            url :"<?=site_url("kuitansi/get_data_kuitansi")?>",
                            data:'id=' + rel,
                            success:function(data){
//                                    console.log(data);
                                    var obj = jQuery.parseJSON(data);
                                    var kuitansi = obj.kuitansi ;
                                    var kuitansi_detail = obj.kuitansi_detail ;
                                    var kuitansi_detail_pajak = obj.kuitansi_detail_pajak ;
                                    $('#kuitansi_id_kuitansi').text(kuitansi.id_kuitansi);
                                    $('#kuitansi_tahun').text(kuitansi.tahun);
                                    $('#kuitansi_no_bukti').text(kuitansi.no_bukti);
                                    $('#kuitansi_jenis').text(kuitansi.jenis);
                                    if((!!kuitansi.alias_no_bukti)&&(kuitansi.alias_no_bukti!='')){
                                        $('#alias_no_bukti').text('( ' + kuitansi.alias_no_bukti + ' )');
                                        $('#alias_no_bukti').show();
                                    }else{
                                        $('#alias_no_bukti').text('');
                                        $('#alias_no_bukti').hide();
                                    }
                                    $('#kuitansi_txt_akun').text(kuitansi.nama_akun);
                                    $('#uraian').text(kuitansi.uraian);
                                    $('#nm_subkomponen').text(kuitansi.nama_subkomponen);
                                    $('#penerima_uang').text(kuitansi.penerima_uang);
                                    // var s = kuitansi.penerima_uang_nip ;
                                    // console.log(s.trim());
                                    // if((s.trim() != '-')&&(s.trim() != '.')){
                                        // console.log('t');
                                        $('#penerima_uang_nip').text(kuitansi.penerima_uang_nip);
                                    // }
                                    // else{
                                        // console.log('f');
                                        // $('#snip').hide();
                                    // }
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
                                        str_isi = str_isi + '<td colspan="3" style="border:1px solid #000;">' + (i+1) + '. ' + v.deskripsi + '</td>' ; 
                                        str_isi = str_isi + '<td style="text-align:center;border:1px solid #000;">' + (v.volume * 1) + '</td>' ;
                                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;border:1px solid #000;">' + v.satuan + '</td>' ;
                                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;border:1px solid #000;">' + angka_to_string(v.harga_satuan) + '</td>' ;
                                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;border:1px solid #000;" class="sub_tot_bruto_' + i +'">' + angka_to_string((v.bruto * 1)) + '</td>' ;
                                        var str_pajak = '' ;
                                        var str_pajak_nom = '' ;
                                        $.each(kuitansi_detail_pajak,function(ii,vv){
                                            if(vv.id_kuitansi_detail == v.id_kuitansi_detail){
                                                var jenis_pajak_ = vv.jenis_pajak ;
                                                var jenis_pajak = jenis_pajak_.split("_").join(" ");
                                                var dpp = vv.dpp == '0' ? '' : '(dpp)';
                                                // console.log(vv.persen_pajak);
                                                var str_99 = (vv.persen_pajak == '99')||(vv.persen_pajak == '98')||(vv.persen_pajak == '97')||(vv.persen_pajak == '96')||(vv.persen_pajak == '95')||(vv.persen_pajak == '94')||(vv.persen_pajak == '89')? '' : vv.persen_pajak + '% ' ;
                                                str_pajak = str_pajak + jenis_pajak + ' ' + str_99 + dpp + '<br>' ;
                                                
                                                str_pajak_nom = str_pajak_nom + '<span rel="'+ i +'" class="sub_tot_pajak_'+ i +'">'+ angka_to_string(vv.rupiah_pajak) +'</span><br>' ; 
                                            }
                                        });
                                        str_isi = str_isi + '<td style="padding: 0 5px 0 5px;border:1px solid #000;">'+ str_pajak +'</td>' ; 
                                        str_pajak_nom = (str_pajak_nom=='')?'<span rel="'+ i +'" class="sub_tot_pajak_'+ i +'">'+'0'+'</span>':str_pajak_nom;
                                        str_isi = str_isi + '<td style="text-align:right;padding: 0 5px 0 5px;border:1px solid #000;" >'+ str_pajak_nom +'</td>' ;  
                                        
                                        str_isi = str_isi + '<td style="border:1px solid #000;border-right:none;"><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></td>' ;
                                        str_isi = str_isi + '<td style="text-align:right;border:1px solid #000;border-left:none;" rel="'+ i +'" class="sub_tot_netto_'+ i +'">0</td>' ; 
                                        
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
                                            
                                            $('[class^="sub_tot_netto_"]').each(function(){
                                                var prel = $(this).attr('rel');
                                                var sub_tot_pajak__  = 0 ;
//                                                console.log(prel + ' ' + sub_tot_pajak__);
                                                $('.sub_tot_pajak_' + prel).each(function(){
                                                    sub_tot_pajak__ = sub_tot_pajak__ + parseInt(string_to_angka($(this).text())) ;
                                                });
                                                var sub_tot_bruto_ = parseInt(string_to_angka($('.sub_tot_bruto_' + prel ).text())) ;
                                                $(this).html(angka_to_string(sub_tot_bruto_ - sub_tot_pajak__));
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

                        });

                    });

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

		
	});

</script>

<div class="row">
	<div class="col-lg-12">
		<div>
			<h2>DAFTAR KUITANSI SUDAH SPJ</h2><hr>
		</br>
		<table class="table table-bordered table-striped small"  style="" >
			<thead>
				<tr>
					<th colspan="9" class="text-center alert-success">DAFTAR KUITANSI</th>
				</tr>
				<tr>
					<th class="text-center col-md-1" style="vertical-align: middle;">No</th>
					<th class="text-center col-md-1" style="vertical-align: middle;">Unit</th>
					<th class="text-center col-md-2" style="vertical-align: middle;">Nomor</th>
					<th class="text-center col-md-2" style="vertical-align: middle;">Tanggal</th>
					<th class="text-center col-md-2" style="vertical-align: middle;">Uraian</th>
					<th class="text-center col-md-1" style="vertical-align: middle;">Pengeluaran</th>
					<th class="text-center col-md-1" style="vertical-align: middle;">&nbsp;</th>
					<th class="text-center col-md-1" style="vertical-align: middle;">Status</th>
					<!--<th class="text-center col-md-1">Proses</th>-->
					<th class="text-center col-md-1">
						<div class="input-group">
							<span class="input-group-addon" style="background-color: #f9ff83;"> 
								<input type="checkbox" aria-label="" rel="" class="all_ck">
							</span>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				
				<?php foreach ($data as $key => $value): ?>
					<tr>
						<td class="text-center"><?php echo $key + 1; ?>.</td>
						<td class="text-center"><?php echo $value->kode_unit; ?></td>
						<td class="text-center"><?php echo $value->no_bukti; ?></td>
						<td class="text-center" id="tgl_kuitansi_<?=$value->id_kuitansi?>"><?php setlocale(LC_ALL, 'id_ID.utf8'); echo strftime("%d %B %Y", strtotime($value->tgl_kuitansi)); ?><br /></td>
						<td class="" id="td_uraian_<?=$value->id_kuitansi?>"><?php echo $value->uraian; ?></td>
						<td class="text-right" id="td_sub_tot_<?=$value->id_kuitansi?>">
							<?php echo $value->pengeluaran + 0; //number_format($value->pengeluaran, 0, ",", "."); ?>
						</td>
						<td class="text-center">
							<div class="btn-group">
								<button  class="btn btn-default btn-sm btn-lihat" rel="<?php echo $value->id_kuitansi; ?>" ><i class="glyphicon glyphicon-search"></i></button>
							</div>
						</td>
						<td class="text-center">
							<?php if ($value->proses == 1 || $value->proses == 2): ?>
								<span class="label label-danger" >SUDAH SPJ</span> 
							<?php else: ?>
								<span class="label label-success ">BELUM SPJ</span>
							<?php endif ?>									
						</td>
						<td class="text-center">
							<div class="input-group">
								<span class="input-group-addon">
									<?php if ($value->proses == 1 || $value->proses == 2  ): ?>
										<input type="checkbox" aria-label="" rel="<?=$value->id_kuitansi?>" class="ck" id="ck_<?=$value->id_kuitansi?>" disabled>
									<?php else: ?>
										<input type="checkbox" aria-label="" rel="<?=$value->id_kuitansi?>" class="ck" id="ck_<?=$value->id_kuitansi?>">
									<?php endif ?>
								</span>
							</div>
						</td>
					</tr>
				</tbody>
			<?php endforeach ?>
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
							<td rowspan="4" style="text-align: center" colspan="2">
								<img src="<?php echo base_url(); ?>/assets/img/logo_1.png" width="60">
							</td>
							<td >&nbsp;<span id="kuitansi_id_kuitansi" style="display:none">0</span></td>
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
							<td colspan="2" ><span id="kuitansi_no_bukti">-</span> <span id="alias_no_bukti" style="display:none"></span> <span style="display:none">[ <a href="#" id="edit_alias_no_bukti">alias</a> ]</span> <br></td>
						</tr>
						<tr class="tr_up">
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>

							<td colspan="2">Jenis</td>
							<td style="text-align: center">:</td>
							<td colspan="2" id="kuitansi_jenis">-</td>
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
							<td colspan="7">Pejabat Pembuat Komitmen/ Pejabat Pelaksana dan Pengendali Kegiatan SUKPA <?=$nm_unit?></td>
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
							<td colspan="3" style="border:1px solid #000;"><b>Deskripsi</b></td>
							<td style="text-align:center;border:1px solid #000;"><b>Kuantitas</b></td>
							<td style="padding: 0 5px 0 5px;border:1px solid #000;"><b>Satuan</b></td>
							<td style="padding: 0 5px 0 5px;border:1px solid #000;"><b>Harga@</b></td>
							<td style="padding: 0 5px 0 5px;border:1px solid #000;"><b>Bruto</b></td>
							<td style="padding: 0 5px 0 5px;border:1px solid #000;" colspan="2"><b>Pajak</b></td>
							<td colspan="2" style="padding: 0 5px 0 5px;border:1px solid #000;"><b>Netto</b></td>
						</tr>
						<tr id="tr_isi">
							<td colspan="11">&nbsp;</td>
						</tr>


						<tr>
							<td style="border:1px solid #000;" colspan="4">&nbsp;</td>
							<td style="padding: 0 5px 0 5px;border:1px solid #000;"><b>Jumlah</b></td>
							<td style="border:1px solid #000;">&nbsp;</td>
							<td style="text-align:right;padding: 0 5px 0 5px;border:1px solid #000;"><b><span class="sum_tot_bruto">0</span></b></td>
							<td style="border:1px solid #000;" >&nbsp;</td>
							<td style="text-align:right;padding: 0 5px 0 5px;border:1px solid #000;"><b><span class="sum_tot_pajak">0</span></b></td>
							<td style="border:1px solid #000;border-right:none;"><b><span style="margin-left:10px;margin-right:10px;">=</span><span style="margin-left:10px;margin-right:10px;">Rp.</span></b></td>
							<td style="text-align: right;border:1px solid #000;border-left:none;"><b><span class="sum_tot_netto">0</span></b></td>
						</tr>
						<tr>
							<td colspan="11">
								&nbsp;
							</td>
						</tr>
						<tr>
							<td colspan="7" style="vertical-align: top;">Setuju dibebankan pada mata anggaran berkenaan, <br />
								a.n. Kuasa Pengguna Anggaran <br />
								<span id="jenis_ppk"></span>

							</td>
							<td colspan="4" style="vertical-align: top;">
								Semarang, <span id="tgl_kuitansi">-</span> <span style="display:none">[ <a href="#" id="edit_tgl_kuitansi">edit</a> ]</span><br />
								Penerima Uang
							</td>
						</tr>
						<tr>
							<td colspan="11">
								<br>
								<br>
								<br>
								<br>
							</td>
						</tr>
						<tr >
							<td colspan="7" style="border-bottom: 1px solid #000;vertical-align: bottom;"><span id="nmpppk">-</span><br>
								NIP. <span id="nippppk">-</span></td>
								<td colspan="4" style="border-bottom: 1px solid #000;vertical-align: bottom;"><span class="edit_here" style="white-space: pre-line;" id="penerima_uang">-</span><br />
									<span id="snip">NIP. <span class="edit_here" id="penerima_uang_nip">-</span></span>
								</td>
							</tr>
							<tr >
								<td colspan="7">Setuju dibayar tgl : <br>
									Bendahara Pengeluaran
								</td>
								<td colspan="4" ><span style="display: none" id="td_tglpumk">Lunas dibayar tgl : <br>
								Pemegang Uang Muka Kerja</span>
							</td>
						</tr>
						<tr>
							<td colspan="11">
								<br>
								<br>
								<br>
							</td>
						</tr>
						<tr>
							<td colspan="7"><span id="nmbendahara"></span><br>
								NIP. <span id="nipbendahara"></span>
							</td>
							<td colspan="4" ><span style="display: none" id="td_nmpumk"><span id="nmpumk"></span><br>
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
				<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Tutup</button>
			</div>
		</div>
	</div>
</div>
