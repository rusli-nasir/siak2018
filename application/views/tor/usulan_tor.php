<script type="text/javascript">
	$(document).on("click",".btn-kontrak",function(){
		$.ajax({
			type:"POST",
			url:"<?=site_url("rsa_lsk/modal_data_kontrak")?>",
			success:function(respon){
				$("#modal_body").html(respon);
			},
			complete:function(){
				$('#myModalKontrak').modal('show');
			}
		});
	});

	$(document).ready(function(){

		need_to_expand_the_collapse();
		autosize($('textarea'));
// $('.xfloat').tooltip();
		$('body').tooltip({
			selector: '.xfloat'
		});


// bootbox.alert({
//     title: "PESAN",
//     message: "STOP DULU, LAGI DIPERBAIKI NIH.<br>THX.",
// });


// bootbox.alert({
//     title: "PESAN",
//     // message: "UNTUK DPA LS KONTRAK MAUPUN NON KONTRAK YANG TELAH CAIR PADA APLIKASI LS YANG LALU TETAPI AKTIF LAGI PADA APLIKASI LS SEKARANG, SILAHKAN DI TINGGAL SAJA ALIAS <U>TIDAK USAH DIPEDULIKAN</U>. JANGAN DI HAPUS ATAU DIRUBAH. NGIH. UNTUK LEBIH JELASNYA SILAHKAN HUB BAG. DIR. KEU<br>THX.",
//     message: "ANGGARAN SETELAH PERUBAHAN MWA SUDAH DI EKSPOR . APABILA ADA KEKELIRUAN DALAM ANGGARAN SILAHKAN HUB. BAPSI.  <br> <div class='alert alert warning'>MOHON DICEK NOMOR URUT DPA ( 3 DIGIT DIDEPAN ) NYA. APABILA ADA YANG KEMBAR / SALAH MOHON DIKONFIRMASI KE BAPSI ( IDRIS ).</div>  THX"
// });


		var ok_gup = true ;
		var ok_tup = true ;
		var ok_lsk = true ;
		var ok_lsnk = true ;
		$.get('<?=site_url("setting/get_posisi/gup")?>',function( data ) {
			if(data=='no'){
				ok_gup = false;
			}
		});

		$.get('<?=site_url("setting/get_posisi/tup")?>',function( data ) {
			if(data=='no'){
				ok_tup = false;
			}
		});


		$.get('<?=site_url("setting/get_posisi/lsk")?>',function( data ) {
			if(data=='no'){
				ok_lsk = false;
			}
		});

		$.get('<?=site_url("setting/get_posisi/lsnk")?>',function( data ) {
			if(data=='no'){
				ok_lsnk = false ;
			}
		});


		<?php
		if(!$this->cantik_model->get_status_override()){
			?>
		// tambahan dari dhanu
		$('#lampJenisLSPeg').load('<?php echo site_url("tor/getOpsiJenisPeg"); ?>',{'id':$('#jenisLSPeg').val()});
		$('#lampStatusLSPeg').load('<?php echo site_url("tor/getOpsiStatusPeg"); ?>',{'id':$('#statusLSPeg').val()});
		$('.lampUnitLSPeg').load('<?php echo site_url("tor/getOpsiUnitPeg"); ?>',{'id':$('#unitLSPeg').val()});
		// cocok LS
			$('#cocokSPPLSPeg').on('submit',function(e){
				var id_rsa_detail = $('#btn-usulkan').attr('rel');
				var proses = $("input[name='proses']:checked").val();
				var data = $('#cocokSPPLSPeg').serialize()+"&id_rsa_detail=" + id_rsa_detail + "&proses=" + proses;
				$('#temp_cocockSPPLSPeg').val(data);
			// $('.message_sppls').load("<?php echo site_url('tor/checkSPPLSPegawai'); ?>",data);
			$.get("<?php echo site_url('tor/checkSPPLSPegawai'); ?>",data,function(r){
				if(r!='1'){
					$('#myModalMessage .message_sppls').html(r);
				}
				else{
				// jika sukses melakukan check nominal SPP dan daftar pegawai
				var id_rsa_detail = $('#btn-usulkan').attr('rel');
				var proses = $("input[name='proses']:checked").val();
				var data = "id_rsa_detail=" + id_rsa_detail + "&proses=" + proses;
				$.ajax({
					type:"POST",
					url :"<?=site_url("tor/proses_tor_rsa_detail")?>",
					data:data,
					success:function(data){
						if(data == 'sukses'){

							location.reload();
						}
					}
				});
				}
			});
		$('#myModalMessage .message_sppls').show();
		$('#myModalMessage .message_sppls2').hide();
		$('#myModalMessage .variabel-tambahan').html('');
		$('#btn-cocok-ls').hide();

		e.preventDefault();
		});


		$('#btn-cocok-ls').on('click',function(e){
			// alert('Terkirim');
			$('#cocokSPPLSPeg').submit();
			e.preventDefault();
		});


		$(document).on('click','#reprocess_check_splss_pegawai',function(e){
			var data = $('#temp_cocockSPPLSPeg').val()+'&aksi=reprocess';
		// $('.message_sppls').load("<?php echo site_url('tor/checkSPPLSPegawai'); ?>",data);
		$.get("<?php echo site_url('tor/checkSPPLSPegawai'); ?>",data,function(r){
			if(r!='1'){
				$('#myModalMessage .message_sppls').html(r);
		// $('#myModalMessage .message_sppls2').show();
		// $('#btn-cocok-ls').show();
		}else{
		// jika sukses melakukan check nominal SPP dan daftar pegawai
		var id_rsa_detail = $('#btn-usulkan').attr('rel');
		var proses = $("input[name='proses']:checked").val();
		var data = "id_rsa_detail=" + id_rsa_detail + "&proses=" + proses;

			$.ajax({
				type:"POST",
				url :"<?=site_url("tor/proses_tor_rsa_detail")?>",
				data:data,
				success:function(data){
					if(data == 'sukses'){
						location.reload();
					}
				}
			});
		}
		});
		e.preventDefault();
		});


		$('#jenisLSPeg').on('change',function(e){
			var anu = 'jenisLSPeg='+$(this).val();
		// alert(anu); return false;
			$.ajax({
				type:"POST",
				url :"<?=site_url("tor/proses_lspeg_var")?>",
				data:anu,
				success:function(data){
					$('#myModalMessage .variabel-tambahan').html(data);
				}
			});
		});
// end here
		<?php
		}
		?>

		$('#backi').click(function(){
			window.location = "<?=site_url("dpa/daftar_dpa/").$sumber_dana?>";
		});

		$(document).on("click",'[id^="proses_"]',function(){
			var id_rsa_detail = $(this).attr('rel');
			var kode_usulan_belanja = $(this).attr('data-kode-usulan');
		//            var kode_usulan_belanja = kode_usulan_belanja_kode_akun_tambah.substr(0, 24);
		//            var kode_akun_tambah = kode_usulan_belanja_kode_akun_tambah.substr(24, 3);
		//            console.log(kode_usulan_belanja + ' - ' + kode_akun_tambah);
			$('[class^="rdo_"]').each(function(){
				$(this).prop('checked',false);
		//                        $(this).attr('readonly','readonly');
		//                         console.log($(this).attr('rel'));
			});
			// setTimeout(function(){
			$('#btn-usulkan').attr('rel',id_rsa_detail);
			$('#btn-usulkan').attr('data-kode-usulan',kode_usulan_belanja);
			$('#myModalCair').modal('show');
		});

		$(document).on("click",'#btn-usulkan',function(){
		// if(false){
		// tambahan dhanu
			var n = $("input[name='proses']:checked").length;
			if(n<=0){
				$('#myModalMsg .body-msg-text').html('<p class="alert alert-warning">Pilih salah satu untuk melanjutkan proses.</p>');
				$('#myModalMsg').modal('show');
				return false;
			}else{
			var v = $("input[name='proses']:checked").val() ;
			if((v == '11')&&(ok_gup==false)){
		// CHECK IF LSK

			bootbox.alert({
				title: "PESAN",
				message: "USULAN DPA GUP TELAH DI NON AKTIFKAN, SILAHKAN HUB. KBUU."
			});

			return false;

			}else if((v == '13')&&(ok_tup==false)){
			// CHECK IF LSK

			bootbox.alert({
				title: "PESAN",
				message: "USULAN DPA TUP TELAH DI NON AKTIFKAN, SILAHKAN HUB. KBUU."
			});

			return false;

			}else if((v == '14')&&(ok_lsk==false)){
			// CHECK IF LSK

			bootbox.alert({
				title: "PESAN",
				message: "USULAN DPA LSK TELAH DI NON AKTIFKAN, SILAHKAN HUB. KBUU."
			});

			return false;

			}else if((v == '16')&&(ok_lsnk==false)){
			// CHECK IF LSNK

			bootbox.alert({
				title: "PESAN",
				message: "USULAN DPA LSNK TELAH DI NON AKTIFKAN, SILAHKAN HUB. KBUU."
			});
			return false;
			}
			// return false;
			}
			// end here
			var id_rsa_detail = $(this).attr('rel');
			var kode_usulan_belanja = $(this).attr('data-kode-usulan');
			var proses = $("input[name='proses']:checked").val();
			var data = "id_rsa_detail=" + id_rsa_detail + "&proses=" + proses;
			// tambahan dari dhanu
			<?php
			if(!$this->cantik_model->get_status_override()){
				?>
				if(proses=='12'){
					$('#cocokSPPLSPeg')[0].reset();
					$('#myModalMessage .message_sppls').hide();
					$('#myModalMessage .message_sppls2').show();
					$('#myModalMessage').modal('show');
					$('#btn-cocok-ls').show();
					return false;
				}
				<?php	} ?>               
			// end tambahan dari dhanu

			$.ajax({
				type:"POST",
				url :"<?=site_url("tor/proses_tor_rsa_detail")?>",
				data:data,
				success:function(data){
			// $("#subunit").html(respon);
			//                            console.log(data);
			//$('#row_space').html(respon);
				if(data == 'sukses'){
					$('#myModalCair').modal('hide');
					localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
					localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
					localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
					localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
					localStorage.setItem("row_focus", "#"+id_rsa_detail);
					usulan_tor_ajax_reload(kode_usulan_belanja.substr(6, 10),'<?php echo $sumber_dana ?>'); 
					// location.reload();
				}
				}
			});
			// }
			// else{
				// $('#myModalCair').modal('show');
		// }
		// return false;
		});

// $('input.xnumber').focusin(function() {
		$(document).on("focusin","input.xnumber",function(){

			if($(this).val()=='0'){
				$(this).val('');
			}
			else{
				var str = $(this).val();
				$(this).val(angka_to_string(str));
			}
		});

// $('input.xnumber').focusout(function() {
		$(document).on("focusout","input.xnumber",function(){
			var kode_usulan_belanja = $(this).attr('rel');
			if($(this).val()==''){
				$(this).val('0');
			}
			else{
				var str = $(this).val();
				$(this).val(string_to_angka(str));
				calcinput(kode_usulan_belanja);

		}

		});

// $('input.xnumber').keyup(function(event) {
	$(document).on("keyup","input.xnumber",function(event){
// skip for arrow keys
		if(event.which >= 37 && event.which <= 40) return;
// format number
		$(this).val(function(index, value) {
			return value
			.replace(/\D/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
			;
		});
});

// $('input.xnumber').focusout(function() {
		$(document).on("focusout","input.xfloat",function(){
				var kode_usulan_belanja = $(this).attr('rel');
				if($(this).val()==''){
					$(this).val('0');
				}
				else{

			calcinput(kode_usulan_belanja);
			}
		});


// $('input.xnumber').keyup(function(event) {
		$(document).on("keyup","input.xfloat",function(event){

			var val = $(this).val();
			if(isNaN(val)){
				val = val.replace(/[^0-9\.]/g,'');
				if(val.split('.').length>2) 
					val =val.replace(/\.+$/,"");
			}
			$(this).val(val); 

		});


// $('#tambah').click(function(){
		$(document).on("click",'[id^="tambah_"]',function(){
			var kode_usulan_belanja = $(this).attr('rel');
				if($('#deskripsi_' + kode_usulan_belanja).validationEngine('validate') && $('#volume_' + kode_usulan_belanja).validationEngine('validate') && $('#satuan_' + kode_usulan_belanja).validationEngine('validate') && $('#tarif_' + kode_usulan_belanja).validationEngine('validate')){

					var total_usulan = parseInt(string_to_angka($("#td_usulan_" + kode_usulan_belanja ).html()));
					var total_rsa = parseInt(string_to_angka($("#td_kumulatif_" + kode_usulan_belanja ).html()));
					var total_rsa_sisa = parseInt(string_to_angka($("#td_kumulatif_sisa_" + kode_usulan_belanja ).html()));
					var jumlah = parseInt(string_to_angka($("#jumlah_" + kode_usulan_belanja ).val()));
		//            console.log(total_usulan + ' - ' + total_rsa + ' - ' + jumlah );
					if(total_usulan >= ( total_rsa + jumlah)){
		//                    console.log(kode_usulan_belanja);
					$.ajax({
						type: 'post',
						url: '<?php echo site_url('tor/add_rsa_detail_belanja');?>' ,
						data: 'kode_usulan_belanja=' + kode_usulan_belanja + '&deskripsi=' + encodeURIComponent($('#deskripsi_' + kode_usulan_belanja).val()) + '&sumber_dana=<?=$sumber_dana?>&volume=' + $('#volume_' + kode_usulan_belanja).val() + '&satuan=' + $('#satuan_' + kode_usulan_belanja).val() + '&harga_satuan=' + $('#tarif_' + kode_usulan_belanja).val() + '&kode_akun_tambah=' + $('#kode_akun_tambah_' + kode_usulan_belanja).val() + '&revisi=' + $('#revisi_' + kode_usulan_belanja).val() + '&impor=' + $('#impor_' + kode_usulan_belanja).val() ,
						success: function(data) {
							if(data == 'sukses'){
								localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
								localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
								localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
								localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
								localStorage.setItem("row_focus", "#deskripsi_"+kode_usulan_belanja);
					// location.reload();
					// $('#o-table').html('');
								usulan_tor_ajax_reload(kode_usulan_belanja.substr(6, 10),'<?php echo $sumber_dana ?>');
					// bootbox.alert({
					//     title: "PESAN",
					//     message: "<i class='fa fa-check fa-2x text-success'></i> Data Berhasil Ditambahkan",
					//     animate:true,
					// });
								}
						}
					});
				}else{
					alert('Tidak bisa karena jumlah melebihi sisa.');
					$("#tarif_" + kode_usulan_belanja ).focus();
					return false;
				}
			}
		});

		$(document).on("click",'[id^="reset_"]',function(){
			var kode_usulan_belanja = $(this).attr('rel');
	//            console.log(kode_usulan_belanja);
			$('#deskripsi_' + kode_usulan_belanja).val('') ;
			$('#volume_' + kode_usulan_belanja).val('') ;
			$('#satuan_' + kode_usulan_belanja).val('') ;
			$('#tarif_' + kode_usulan_belanja).val('') ;
			$('#jumlah_' + kode_usulan_belanja).val('') ;

			$('#deskripsi_' + kode_usulan_belanja).focus() ;
			/*
			$('#deskripsi_' + kode_usulan_belanja).validationEngine('hide') ;
			$('#volume_' + kode_usulan_belanja).validationEngine('hide') ;
			$('#satuan_' + kode_usulan_belanja).validationEngine('hide') ;
			$('#tarif_' + kode_usulan_belanja).validationEngine('hide') ;
			*/
			// $(".formError").remove();
			$('.deskripsi_' + kode_usulan_belanja + 'formError').remove();
			$('.volume_' + kode_usulan_belanja + 'formError').remove();
			$('.satuan_' + kode_usulan_belanja + 'formError').remove();
			$('.tarif_' + kode_usulan_belanja + 'formError').remove();
		});

		// get_kode_akun_tambah();

		$(document).on("click",'[id^="delete_"]',function(){
//                clearinput()
//                $('#add-detail').validationEngine('hide');
//                $('#edit-detail').validationEngine('hide');
			var id_rsa_detail = $(this).attr('rel');
			var kode_usulan_belanja = $(this).attr('data-kode-usulan');

			if(confirm('Yakin akan menghapus ?')){
				$.ajax({
					type: 'post',
					url: '<?php echo site_url('tor/delete_rsa_detail_belanja');?>' ,
					data: 'id_rsa_detail=' + id_rsa_detail ,
					success: function(data) {
						if(data == 'sukses'){
							localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
							localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
							localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
							localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
							localStorage.setItem("row_focus", "#deskripsi_"+kode_usulan_belanja);
							usulan_tor_ajax_reload(kode_usulan_belanja.substr(6, 10),'<?php echo $sumber_dana ?>');

						}
					}
				});
			}
		});

});

		function need_to_expand_the_collapse(){
			var row_sub_subunit = localStorage.getItem("row_expand_sub_subunit");
			var row_akun4d = localStorage.getItem("row_expand_akun4d");
			var row_akun5d = localStorage.getItem("row_expand_akun5d");
			var row_akun6d = localStorage.getItem("row_expand_akun6d");
			var row_focus = localStorage.getItem("row_focus");

			$(row_sub_subunit).addClass("in");
			$(row_akun4d).addClass("in");
			$(row_akun5d).addClass("in");
			$(row_akun6d).addClass("in");
			$(row_focus).focus();

		}

		function usulan_tor_ajax_reload(kode,sumber_dana){
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('tor/usulan_tor_ajax_reload');?>/'+kode+'/'+sumber_dana ,
				data: '' ,
				success: function(data) {
					$('#o-table').html(data);
				},
				complete: function (data) {
					// get_kode_akun_tambah();
					need_to_expand_the_collapse();
				}
			});
		}

		function doedit(rel,kode,el){
		//        clearinput();
		//        $('#add-detail').validationEngine('hide');
		//        $('#edit-detail').validationEngine('hide');
		//        $('#form-add-detail').hide();
			$('#' + rel).load('<?php echo site_url('tor/form_edit_detail');?>/' + rel,function(){autosize($('textarea'));});
			$('#' + rel).addClass('alert-success') ;
			$('#form_add_detail_' + kode).hide();


		}

		function refresh_row(){
		// $("#row_space").load("<?=site_url('tor/get_row')?>");
		}

		function string_to_angka(str){
			return str.split('.').join("");
		}

		function angka_to_string(num){
			var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			return str_hasil;
		}

		function calcinput(kode_usulan_belanja){

			if ($('#volume_edit').length) {
				if(isNaN(parseFloat($('#volume_edit').val()))){var vol	= 0;}else{var vol	= parseFloat($('#volume_edit').val());}
				if(isNaN(parseInt($('#tarif_edit').val()))){var tarif	= 0;}else{var tarif	= parseInt($('#tarif_edit').val());}

				if(vol.length==0){ vol = 0;}
				if(tarif.length==0){ tarif = 0;}
				if(isNaN(vol*tarif)){ var hasil	= 0;}else{ var hasil	= vol*tarif; }
		// console.log(vol + ' - ' + tarif + ' - ' + hasil.toFixed(0));
			$('#jumlah_edit').val(parseInt(hasil.toFixed(0)));
			}
			else{
				if(isNaN(parseFloat($('#volume_' + kode_usulan_belanja).val()))){var vol	= 0;}else{var vol	= parseFloat($('#volume_' + kode_usulan_belanja).val());}
				if(isNaN(parseInt($('#tarif_' + kode_usulan_belanja).val()))){var tarif	= 0;}else{var tarif	= parseInt($('#tarif_' + kode_usulan_belanja).val());}

				if(vol.length==0){ vol = 0;}
				if(tarif.length==0){ tarif = 0;}
				if(isNaN(vol*tarif)){ var hasil	= 0;}else{ var hasil	= vol*tarif; }
			// console.log(vol + ' - ' + tarif + ' - ' + hasil);
				$('#jumlah_' + kode_usulan_belanja).val(parseInt(hasil.toFixed(0)));
			}
		}

		function canceledit(kode){
			$('#usulan_tor_row_detail_'+kode).load('<?php echo site_url('tor/refresh_usulan_tor_detail')?>/'+ kode +'/<?php echo $sumber_dana ?>', function(){
			// $('#form_add_detail_' + kode).show();
			// get_kode_akun_tambah();
			});
		}

		// function get_kode_akun_tambah(){
		// 	$('[id^="kode_akun_tambah_"]').each(function(){

		// 		var kode_akun_tambah = $(this).attr('rel') ;
		// 		var sumber_dana = '<?=$sumber_dana?>' ;
		// 		var el = $(this);
		// 		$.ajax({
		// 			type: 'get',
		// 			url: '<?php echo site_url('tor/get_next_kode_akun_tambah');?>/' + kode_akun_tambah + '/' + sumber_dana ,
		// 			data: '' ,
		// 			success: function(data) {
		// 				$(el).val(data);
		// 			}
		// 		});
		// 	});
		// }

// function get_kode_akun_tambah_on_refresh(kode_usulan_belanja,sumber_dana){
//    $.ajax({
//       type: 'get',
//       url: '<?php echo site_url('tor/get_next_kode_akun_tambah');?>/' + kode_usulan_belanja + '/' + sumber_dana ,
//       data: '' ,
//       success: function(data) {
//          $('#kode_akun_tambah_'+kode_usulan_belanja).val(data);
//       }
//    });
// }

		function submitedit(id_rsa_detail,kode_usulan_belanja){
		//    var kode_usulan_belanja = $(this).attr('rel');
			if($('#deskripsi_edit').validationEngine('validate') && $('#volume_edit').validationEngine('validate') && $('#satuan_edit').validationEngine('validate') && $('#tarif_edit').validationEngine('validate')){
				var total_usulan = parseInt(string_to_angka($("#td_usulan_" + kode_usulan_belanja ).html()));
				var total_rsa = parseInt(string_to_angka($("#td_kumulatif_" + kode_usulan_belanja ).html()));
				var total_rsa_sisa = parseInt(string_to_angka($("#td_kumulatif_sisa_" + kode_usulan_belanja ).html()));
				var jumlah = parseInt(string_to_angka($("#jumlah_edit").val()));
				var jumlah_edit_before = parseInt(string_to_angka($("#jumlah_edit_before").val()));

		//            console.log(total_usulan + ' - ' + total_rsa + ' - ' + jumlah + ' - ' + jumlah_edit_before );

			if(total_usulan >= ( (total_rsa - jumlah_edit_before) + jumlah )){
				$.ajax({
					type: 'post',
					url: '<?php echo site_url('tor/edit_rsa_detail_belanja');?>',
					data: 'id_rsa_detail=' + id_rsa_detail + '&deskripsi=' +  encodeURIComponent($('#deskripsi_edit').val()) + '&volume=' + $('#volume_edit').val() + '&satuan=' + $('#satuan_edit').val() + '&harga_satuan=' + $('#tarif_edit').val() ,
					success: function(data) {
						if(data == 'sukses'){
							localStorage.setItem("row_expand_sub_subunit", ".data_akun4d_"+kode_usulan_belanja.substr(0, 6));
							localStorage.setItem("row_expand_akun4d", ".data_akun5d_"+kode_usulan_belanja.substr(0, 22));
							localStorage.setItem("row_expand_akun5d", ".data_akun6d_"+kode_usulan_belanja.substr(0, 23));
							localStorage.setItem("row_expand_akun6d", ".data_rsa_detail_"+kode_usulan_belanja);
							localStorage.setItem("row_focus", "#deskripsi_"+kode_usulan_belanja);
							usulan_tor_ajax_reload(kode_usulan_belanja.substr(6, 10),'<?php echo $sumber_dana ?>');

						}
					}
				});
			}else{
				alert('Tidak bisa karena jumlah melebihi sisa.');
				$("#tarif_edit").focus();
				return false;

			}
			}

		}

		function checkfloat(field, rules, i, options){
			var v = field.val() ;
			if(v == ''){
				return "* Isian salah, con : 999999,99" ;
			} 

		}


		function open_tolak(s){
			bootbox.alert({
				title: "PESAN",
				message: s,
				animate:false,
			});
		}


</script>
<?php
$tgl=getdate();
$cur_tahun=$tgl['year']+1;
?>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<h2>DETAIL SUB KEGIATAN</h2>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-lg-12">
				<table class="table table-striped table-bordered">
					<tr>
						<td class="col-md-2">
							IKU
						</td>
						<td>
							<span id="kode_program"><?=$tor_usul->kode_program?></span> - <?=$tor_usul->nama_program?>
						</td>
					</tr>
					<tr>
						<td class="col-md-2">
							Kegiatan
						</td>
						<td>
							<span id="kode_komponen"><?=$tor_usul->kode_komponen?></span> - <?=$tor_usul->nama_komponen?>
						</td>
					</tr>
					<tr>
						<td class="col-md-2">
							Sub Kegiatan
						</td>
						<td><span id="kode_subkomponen"><?=$tor_usul->kode_subkomponen?></span> - <?=$tor_usul->nama_subkomponen?></td>
					</tr>
				</table>

				<table class="table table-striped table-bordered" >
					<tr class="alert alert-danger"style="font-weight: bold">
						<td class="col-md-2">Sumber Dana</td>
						<td>
							<span id="kode_sumber_dana"><?=$sumber_dana?></span>
						</td>
					</tr>
					<tr class="">
						<td class="col-md-2">
							Ket
						</td>
						<td>
							<span class="label badge-gup">&nbsp;</span> : GUP &nbsp;&nbsp;<span class="label badge-tup">&nbsp;</span> : TUP &nbsp;&nbsp;<span class="label badge-lp">&nbsp;</span> : LS-PEGAWAI &nbsp;&nbsp;<span class="label badge-l3">&nbsp;</span> : LS-KONTRAK &nbsp;&nbsp;<span class="label badge-ln">&nbsp;</span> : LS-NON-KONTRAK &nbsp;&nbsp;<span class="label badge-ks">&nbsp;</span> : KERJA-SAMA &nbsp;&nbsp;<span class="label badge-em">&nbsp;</span> : EMONEY
						</td>
					</tr>
				</table>
				<div class="alert alert-info col-lg-12" style="border-color:#3793a7;">
					<button type="button" class="btn btn-success btn-daftar-akun" data-toggle="modal" data-target="#myModalRefAkun" >
                            <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>
                            Referensi Akun Belanja
                        </button>
                        <button type="button" class=" btn-kontrak btn btn-info"  id="btn-kontrak">
                            <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>
                            Referensi Kontrak
                        </button>
				</div>
				<div id="temp" style="display:none"></div>
				<div id="o-table" class="col-md-12">
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
				</div>
			</div>
		</div>
	</div>

	<!-- POP UP PILIH PENCAIRAN -->
	<div class="modal" id="myModalCair" tabindex="-1" role="dialog" aria-labelledby="myModalCairLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleInputEmail1">Pilih Mekanisme Pencairan ?</label>
						<div class="row">
							<div class="col-md-6">
								<div class="input-group">
									<span class="input-group-addon">
										<input type="radio" aria-label="" rel="" class="rdo_up" name="proses" value="11">
									</span>
									<input type="text" class="form-control" aria-label="" value="GUP" readonly="readonly">
								</div><!-- /input-group -->
							</div><!-- /.col-lg-6 -->
							<div class="col-md-6">
								<div class="input-group">
									<span class="input-group-addon">
										<input type="radio" aria-label="" rel="" class="rdo_up" name="proses" value="12">
									</span>
									<input type="text" class="form-control" aria-label="" value="LS-PEGAWAI" readonly="readonly">
								</div><!-- /input-group -->
							</div><!-- /.col-lg-6 -->
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="input-group">
									<span class="input-group-addon">
										<input type="radio" aria-label="" rel="" class="rdo_ls" name="proses" value="13">
									</span>
									<input type="text" class="form-control" aria-label="" value="TUP" readonly="readonly">
								</div><!-- /input-group -->
							</div><!-- /.col-lg-6 -->
							<div class="col-lg-6">
								<div class="input-group">
									<span class="input-group-addon">
										<input type="radio" aria-label="" rel="" class="rdo_ph3" name="proses" value="14">
									</span>
									<input type="text" class="form-control" aria-label="" value="LS-KONTRAK" readonly="readonly">
								</div><!-- /input-group -->
							</div><!-- /.col-lg-6 -->
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="input-group">
									<span class="input-group-addon">
										<input type="radio" aria-label="" rel="" class="rdo_ls" name="proses" value="15">
									</span>
									<input type="text" class="form-control" aria-label="" value="KERJA-SAMA" readonly="readonly">
								</div><!-- /input-group -->
							</div><!-- /.col-lg-6 -->
							<div class="col-lg-6">
								<div class="input-group">
									<span class="input-group-addon">
										<input type="radio" aria-label="" rel="" class="rdo_ph3non" name="proses" value="16">
									</span>
									<input type="text" class="form-control" aria-label="" value="LS-NON-KONTRAK" readonly="readonly">
								</div><!-- /input-group -->
							</div><!-- /.col-lg-6 -->
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="input-group">
									<span class="input-group-addon">
										<input type="radio" aria-label="" rel="" class="rdo_ph3non" name="proses" value="17">
									</span>
									<input type="text" class="form-control" aria-label="" value="EMONEY" readonly="readonly">
								</div><!-- /input-group -->
							</div><!-- /.col-lg-6 -->
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-success" id="btn-usulkan" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Usulkan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Batal</button>
				</div>
			</div>
		</div>
	</div>

	<!-- tambahan dari dhanu -->
	<div class="modal" id="myModalMessage" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-exclamation-sign"></i> Pencocokan Lampiran LS Pegawai:</h4>
				</div>
				<form id="cocokSPPLSPeg">
					<input type="hidden" name="temp_cocockSPPLSPeg" id="temp_cocockSPPLSPeg" value="" />
					<div class="modal-body message_sppls" style="margin:15px;padding:0px;padding-bottom: 15px;word-wrap: break-word;"></div>
					<div class="modal-body message_sppls2" style="margin:15px;padding:0px;padding-bottom: 15px;word-wrap: break-word;">
						<div class="row">
							<div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
								<div class="form-group" style="vertical-align: top;">
									<label for="jenisLSPeg" class="control-label col-md-3 small">Jenis LS-Pegawai:</label>
									<div class="col-md-9">
										<select name="jenisLSPeg" id="jenisLSPeg" class="form-control input-sm">
											<?php
											$array = array(''=>'pilih salah satu','ikw'=>'Insentif Kinerja Wajib','ipp'=>'Insentif Perbaikan Penghasilan','tutam'=>'Tugas Tambahan','tutam_rsnd'=>'Tugas Tambahan RSND');
											foreach ($array as $k => $v) {
												echo "<option value=\"".$k."\">".$v."</option>";
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
								<div class="form-group variabel-tambahan">
									&nbsp;pilih jenis LSPEG terlebih dahulu&nbsp;
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
								<div class="form-group">
									<label for="lampJenisLSPeg" class="control-label col-md-3 small">Jenis Pegawai:</label>
									<div class="col-md-9">
										<select name="lampJenisLSPeg" id="lampJenisLSPeg" class="form-control input-sm">
											<option></option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
								<div class="form-group">
									<label for="lampStatusLSPeg" class="control-label col-md-3 small">Status Pegawai:</label>
									<div class="col-md-9">
										<select name="lampStatusLSPeg" id="lampStatusLSPeg" class="form-control input-sm">
											<option></option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="lampUnitLSPeg" class="small">Unit Pegawai:</label>
							<div class="lampUnitLSPeg" style="overflow-x:hidden;overflow-y: scroll;max-height:250px;"></div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="btn-cocok-ls" rel="" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> !Cocokkan Total Sumber Dana!</button>
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Tutup</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
	<!-- end here -->
	<div class="modal" id="myModalKontrak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" style="margin-top: 80px;">
				<div class="modal-content" id="modal_content">
					 <div class="modal-body" id="modal_body">
					 </div>
					 <div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Close</button>
					</div>
				</div>
				
			</div>
		</div>

	<!-- POP UP PILIH PENCAIRAN -->
	<div class="modal" id="myModalRefAkun" tabindex="-1" role="dialog" aria-labelledby="myModalCairLabel">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Referensi Akun Belanja</h4>

				</div>
				<div class="modal-body">
<table class="table table-bordered table-highlight ">
		<thead>
		<tr>

			<th class="col-md-1">Kode Akun4D</th>
			<th class="col-md-2">Nama Akun4D</th>
			<th class="col-md-1">Kode Akun5D</th>
			<th class="col-md-2">Nama Akun5D</th>
			<th class="col-md-1">Kode Akun6D</th>
			<th class="col-md-2">Nama Akun6D</th>

		</tr>
		</thead>
		<tbody id="row_space">
<?php $arr_akun = array() ; $i = 0 ; $n = 0 ; $s = '' ;?>
<?php if(!empty($akun_belanja)):?>
<?php foreach($akun_belanja as $row):?>
<tr id="<?=$row->kode_akun?>" height="25px" >

			<td align="center" rel="<?=$row->kode_akun4digit?>" style="background-color:#c6ffe4" ><?=$row->kode_akun4digit?></td>
			<td style="background-color:#c6ffe4" ><?=$row->nama_akun4digit?></td>

				<?php if(!in_array($row->kode_akun5digit,$arr_akun)){$s = 'background-color: #e7e6e6 !important;'; $arr_akun[] = $row->kode_akun5digit ;}else{$s='';}?>

				<td align="center" rel="<?=$row->kode_akun5digit?>" style="<?=$s?>" ><?=$row->kode_akun5digit?></td>
				<td style="<?=$s?>"><?=$row->nama_akun5digit?></td>

	<td align="center" rel="<?=$row->kode_akun?>" style="<?=$s?>" ><?=$row->kode_akun?></td>
	<td style="<?=$s?>"><?=$row->nama_akun?></td>

</tr>
<?php endforeach; ?>
<?php endif; ?>
		</tbody>
	</table>
</form>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>


