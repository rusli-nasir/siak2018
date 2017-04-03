<script src="<?php echo $_CONFIG['path']; ?>/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo $_CONFIG['path']; ?>/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo $_CONFIG['path']; ?>/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script>
	$(function(){

		//Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy");

		// untuk form
		$('#form-ipp').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_ipp').modal('hide');
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
			$('#form-ipp #act').val('ipp_lihat');
			$.post($('#form-ipp').attr('action'),$('#form-ipp').serialize(),function(data){
				if(data!=1){
					$('.result_data').html(data);
					$('#form-ipp #act').val('ipp_proses');
				}else{
					window.location.reload();
				}
			});
		});
		$('.reset_data').click(function(e){
			e.preventDefault();
			var a=confirm('Reset/Bersihkan halaman ini?');
			if(a){
				$('#form-ipp #act').val('ipp_reset');
				$.post($('#form-ipp').attr('action'),$('#form-ipp').serialize(),function(data){
					if(data!=1){
						$('.result_data').html(data);
						$('#form-ipp #act').val('ipp_proses');
					}else{
						window.location.reload();
					}
				});
			}
		});

		// checkbox
		$('.master_id').change(function () {
	    if ($(this).prop('checked')) {
	        $('.id:checkbox').prop('checked', true);
	    } else {
	        $('.id:checkbox').prop('checked', false);
	    }
		});
		$('.master_id').trigger('change');

		// aksi berantai
		$('.cetak_data').click(function(e){
			e.preventDefault();
			window.location = '<?php echo $_CONFIG['path']; ?>/file_report_download.php?page=ipp&act=totalan';			
		});
		$('.hapus_data').click(function(e){
			e.preventDefault();
			var n = ($( ".id:checked" ).length);
			if(n>0){
				var a=confirm('Yakin akan menghapus data tunjangan IPP terpilih ini?');
				if(a){
					$('#jamaah').submit();
				}
			}
		});
		$('.hapus_single').click(function(e){
			e.preventDefault();
			var a=confirm('Yakin akan menghapus data tunjangan IPP ini?');
			if(a){
				$.post($('#jamaah').attr('action'),{'act':'ipp_hapus_single', 'id':$(this).attr('id')},function(data){
					if(data!="1"){
						$('.message-jamaah').html(data);
					}else{
						window.location.reload();
					}
				});
			}
		});

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
	});
</script>
