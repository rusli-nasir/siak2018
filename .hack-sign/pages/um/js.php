<script>
	$(function(){
		$('#form-uangmakan').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_uangmakan').modal('hide');
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
			$('#form-uangmakan #act').val('um_lihat');
			$.post($('#form-uangmakan').attr('action'),$('#form-uangmakan').serialize(),function(data){
				if(data!=1){
					$('.result_data').html(data);
					$('#form-uangmakan #act').val('um_proses');
				}else{
					window.location.reload();
				}
			});
		});
		$('.reset_data').click(function(e){
			e.preventDefault();
			var a=confirm('Reset/Bersihkan halaman ini?');
			if(a){
				$('#form-uangmakan #act').val('um_reset');
				$.post($('#form-uangmakan').attr('action'),$('#form-uangmakan').serialize(),function(data){
					if(data!=1){
						$('.result_data').html(data);
						$('#form-uangmakan #act').val('um_proses');
					}else{
						window.location.reload();
					}
				});
			}
		});

		// checkbox
		$('.master_id').change(function () {
	    if ($(this).prop('checked')) {
	        $('.id_tr_um:checkbox').prop('checked', true);
	    } else {
	        $('.id_tr_um:checkbox').prop('checked', false);
	    }
		});
		$('.master_id').trigger('change');

		// aksi berantai
		$('.hapus_data').click(function(e){
			e.preventDefault();
			var n = ($( ".id_tr_um:checked" ).length);
			if(n>0){
				var a=confirm('Yakin akan menghapus data uang makan terpilih ini?');
				if(a){
					$.post($('#jamaah').attr('action'),$('#jamaah').serialize(),function(data){
						if(data!="1"){
							alert(data);
						}else{
							window.location.reload();
						}
					});
				}
			}
		});
		$('.hapus_single').click(function(e){
			e.preventDefault();
			var a=confirm('Yakin akan menghapus data uang makan ini?');
			if(a){
				$.post($('#jamaah').attr('action'),{'act':'um_hapus_single', 'id':$(this).attr('id')},function(data){
					if(data!="1"){
						alert(data);
					}else{
						window.location.reload();
					}
				});
			}
		});
		// simpan data yang sudah dimasukkan.
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
			$('#jamaah #act').val('um_simpan_data');
			$('#jamaah').submit();
		});
		$('.um_ubah_jumlahh').change(function(e){
			e.preventDefault();
			$('.jumlahh').text($('.um_ubah_jumlahh').val());
		});
	});
</script>
