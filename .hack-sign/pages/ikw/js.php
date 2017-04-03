<script>
	$(function(){
		// umum
		$('._tab_').click(function(){
			$.post('<?php echo $_CONFIG['path']; ?>/process.php',{'act':'ikw-swicth-tab','id':$(this).attr('href')});
		});

		// untuk form
		$('#form-ikw').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_ikw').modal('hide');
			$.post($(this).attr('action'),$(this).serialize(),function(data){
				if(data!=1){
					$('.result_data').html(data);
				}else{
					window.location.reload();
				}
			});
		});
		$('.lihat_data').click(function(e){
			e.preventDefault();
			$('#form-ikw #act').val('ikw_lihat');
			$.post($('#form-ikw').attr('action'),$('#form-ikw').serialize(),function(data){
				if(data!=1){
					$('.result_data').html(data);
					$('#form-ikw #act').val('ikw_proses');
				}else{
					window.location.reload();
				}
			});
		});
		$('.reset_data').click(function(e){
			e.preventDefault();
			var a=confirm('Reset/Bersihkan halaman ini?');
			if(a){
				$('#form-ikw #act').val('ikw_reset');
				$.post($('#form-ikw').attr('action'),$('#form-ikw').serialize(),function(data){
					if(data!=1){
						$('.result_data').html(data);
						$('#form-ikw #act').val('ikw_proses');
					}else{
						window.location.reload();
					}
				});
			}
		});

		// checkbox // untuk potongan ikw
		$('.master_id').change(function () {
	    if ($(this).prop('checked')) {
	        $('.id_trans:checkbox').prop('checked', true);
	    } else {
	        $('.id_trans:checkbox').prop('checked', false);
	    }
		});
		$('.master_id').trigger('change');

		// aksi berantai // untuk potongan ikw
		$('.cetak_data').click(function(e){
			e.preventDefault();
			window.location = '<?php echo $_CONFIG['path']; ?>/file_report_download.php?page=ikw&act=potongan';			
		});
		$('.hapus_data').click(function(e){
			e.preventDefault();
			var n = ($( ".id_trans:checked" ).length);
			if(n>0){
				var a=confirm('Yakin akan menghapus data potongan tunjangan IKW terpilih ini?\ndata tunjangan ikw yang terhubung akan ikut terhapus.');
				if(a){
					$('#jamaah').submit();
				}
			}
		});
		$('.hapus_single').click(function(e){
			e.preventDefault();
			var a=confirm('Yakin akan menghapus data potongan tunjangan IKW ini?\ndata tunjangan ikw yang terhubung akan ikut terhapus.');
			if(a){
				$.post($('#jamaah').attr('action'),{'act':'ikw_pot_hapus_single', 'id':$(this).attr('id')},function(data){
					if(data!="1"){
						$('.message-jamaah').html(data);
					}else{
						window.location.reload();
					}
				});
			}
		});

		// simpan data yang sudah dimasukkan. // potongan ikw
		$('#jamaah').on('submit',function(e){
			e.preventDefault();
			$.post($(this).attr('action'),$(this).serialize(),function(data){
				if(data!=1){
					$('.message-jamaah').html(data);
				}else{
					window.location.reload();
				}
			});
		});
		$('.simpan_data').click(function(e){
			e.preventDefault();
			var a = confirm("Yakin akan menyimpan perubahan data yang sudah dilakukan?");
			if(a){
				$('#jamaah #act').val('ikw_pot_simpan_data');
				$('#jamaah').submit();
			}
		});

		// tunjangan IKW totalan
		// checkbox // untuk ikw
		$('.master_id2').change(function () {
	    if ($(this).prop('checked')) {
	        $('.id_trans2:checkbox').prop('checked', true);
	    } else {
	        $('.id_trans2:checkbox').prop('checked', false);
	    }
		});
		$('.master_id2').trigger('change');

		// aksi berantai // untuk ikw totalan
		$('.cetak_data2').click(function(e){
			e.preventDefault();
			window.location = '<?php echo $_CONFIG['path']; ?>/file_report_download.php?page=ikw&act=totalan';			
		});
		$('.hapus_data2').click(function(e){
			e.preventDefault();
			var n = ($( ".id_trans2:checked" ).length);
			if(n>0){
				var a=confirm('Yakin akan menghapus data tunjangan IKW terpilih ini?\ndata potongan tunjangan ikw yang terhubung akan ikut terhapus.');
				if(a){
					$('#jamaah2').submit();
				}
			}
		});
		$('.hapus_single2').click(function(e){
			e.preventDefault();
			var a=confirm('Yakin akan menghapus data potongan tunjangan IKW ini?\ndata tunjangan ikw yang terhubung akan ikut terhapus.');
			if(a){
				$.post($('#jamaah2').attr('action'),{'act':'ikw_hapus_single', 'id':$(this).attr('id')},function(data){
					if(data!="1"){
						$('.message-jamaah2').html(data);
					}else{
						window.location.reload();
					}
				});
			}
		});

		// simpan data yang sudah dimasukkan. // potongan ikw
		$('#jamaah2').on('submit',function(e){
			e.preventDefault();
			$.post($(this).attr('action'),$(this).serialize(),function(data){
				if(data!=1){
					$('.message-jamaah2').html(data);
				}else{
					window.location.reload();
				}
			});
		});
		$('.simpan_data2').click(function(e){
			e.preventDefault();
			var a = confirm("Yakin akan menyimpan perubahan data yang sudah dilakukan?");
			if(a){
				$('#jamaah2 #act').val('ikw_simpan_data');
				$('#jamaah2').submit();
			}
		});
	});
</script>
