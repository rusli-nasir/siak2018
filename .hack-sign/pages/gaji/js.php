<script>
	$(function(){
		$('#prosesgaji').submit(function(e){
			e.preventDefault();
			$.post($(this).attr('action'),$(this).serialize(),function(data){
				if(data!=1){
					$('.result_data').html(data);
				}else{
					window.location.reload();
				}
			});
		});
		$('.lihat_data').click(function(e){
			$('#act').val('gaji_lihat');
			$.post($('#prosesgaji').attr('action'),$('#prosesgaji').serialize(),function(data){
				if(data!=1){
					$('.result_data').html(data);
					$('#act').val('gaji_proses');
				}else{
					window.location.reload();
				}
			});
		});
		$('.reset_data').click(function(e){
			e.preventDefault();
			var a=confirm('Reset/Bersihkan halaman ini?');
			if(a){
				$('#prosesgaji #act').val('gaji_reset');
				$.post($('#prosesgaji').attr('action'),$('#prosesgaji').serialize(),function(data){
					if(data!=1){
						$('.result_data').html(data);
						$('#prosesgaji #act').val('gaji_proses');
					}else{
						window.location.reload();
					}
				});
			}
		});

		// checkbox
		$('.master_id').change(function () {
	    if ($(this).prop('checked')) {
	        $('.id_tr_gaji:checkbox').prop('checked', true);
	    } else {
	        $('.id_tr_gaji:checkbox').prop('checked', false);
	    }
		});
		$('.master_id').trigger('change');
		// $('.tabel_gaji tr').click(function(event) {
		//   if (event.target.type !== 'checkbox') {
		//     $(':checkbox', this).trigger('click');
		//   }
		// });

		// aksi berantai
		$('.hapus_data').click(function(e){
			e.preventDefault();
			var n = ($( ".id_tr_gaji:checked" ).length);
			if(n>0){
				var a=confirm('Yakin akan menghapus data gaji ini?');
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
			var a=confirm('Yakin akan menghapus data gaji ini?');
			if(a){
				$.post($('#jamaah').attr('action'),{'act':'gaji_hapus_single', 'id':$(this).attr('id')},function(data){
					if(data!="1"){
						alert(data);
					}else{
						window.location.reload();
					}
				});
			}
		});
	});
</script>
