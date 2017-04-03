<script>
	$(function(){
		$('#form-tunjangan').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_tunjangan').modal('hide');
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
			$('#form-tunjangan #act').val('tunjangan_lihat');
			$.post($('#form-tunjangan').attr('action'),$('#form-tunjangan').serialize(),function(data){
				if(data!=1){
					$('.result_data').html(data);
					$('#form-tunjangan #act').val('tunjangan_proses');
				}else{
					window.location.reload();
				}
			});
		});
		$('.reset_data').click(function(e){
			e.preventDefault();
			var a=confirm('Reset/Bersihkan halaman ini?');
			if(a){
				$('#form-tunjangan #act').val('tunjangan_reset');
				$.post($('#form-tunjangan').attr('action'),$('#form-tunjangan').serialize(),function(data){
					if(data!=1){
						$('.result_data').html(data);
						$('#form-tunjangan #act').val('tunjangan_proses');
					}else{
						window.location.reload();
					}
				});
			}
		});

		// checkbox
		$('.master_id').change(function () {
	    if ($(this).prop('checked')) {
	        $('.id_tr_tunjangan:checkbox').prop('checked', true);
	    } else {
	        $('.id_tr_tunjangan:checkbox').prop('checked', false);
	    }
		});
		$('.master_id').trigger('change');

		// aksi berantai
		$('.hapus_data').click(function(e){
			e.preventDefault();
			var n = ($( ".id_tr_tunjangan:checked" ).length);
			if(n>0){
				var a=confirm('Yakin akan menghapus data tunjangan terpilih ini?');
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
			var a=confirm('Yakin akan menghapus data tunjangan ini?');
			if(a){
				$.post($('#jamaah').attr('action'),{'act':'tunjangan_hapus_single', 'id':$(this).attr('id')},function(data){
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
			$('#jamaah #act').val('tunjangan_simpan_data');
			$('#jamaah').submit();
		})
	});
</script>
