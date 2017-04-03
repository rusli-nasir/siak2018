<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		$('#keyword').keyup(function(){
			var keyword = $(this).val();
			$.ajax({
				type: 'post',
				url: '<?php echo site_url('output/responds_output');?>',
				data: "kode-kegiatan=<?=$kode['kode-kegiatan']?>&keyword=" + keyword,
				success: function(data) {
					$('.result').html(data);
				}
			});
		});
		
		$('#show-all').click(function(){
			$('#keyword').val('');
			$.ajax({
				type: 'post',
				url: '<?php echo site_url('output/responds_output/');?>',
				data: "kode-kegiatan=<?=$kode['kode-kegiatan']?>&keyword=",
				success: function(data) {
					$('.result').html(data);
				}
			});
			$('#keyword').val('- Masukkan kata kunci untuk memfilter data -');
		});
		
		$('#keyword').focus(function(){
			$('#keyword').val($.trim($('#keyword').val()));
			if($('#keyword').val()=='- Masukkan kata kunci untuk memfilter data -'){
				$('#keyword').val('');
			}
		});
		
		$('#keyword').blur(function(){
			$('#keyword').val($.trim($('#keyword').val()));
			if($('#keyword').val()==''){
				$('#keyword').val('- Masukkan kata kunci untuk memfilter data -');
			}
		});
		
		$('#keyword').val('- Masukkan kata kunci untuk memfilter data -');
	});


	function outputdopick(rel,alt){

		var prev_value = $('#kode-output').val();

			var kode_kegiatan = alt;
			var kode_text_kegiatan = kode_kegiatan.split('/');
			$('#kode-output').val(kode_text_kegiatan[1]);
			$('#text-output').val(kode_text_kegiatan[1] + ' - ' + rel);

			var next_value = $('#kode-output').val();
			

			if( prev_value != next_value ){

				$('#kode-program').val('');
				$('#text-program').val('');
				$('#cr-program').removeAttr('disabled')
				.val('')
				.attr('rel','program/search_program/' + alt);

				$('#kode-komponen-input').val('');
				$('#text-komponen-input').val('');
				$('#cr-komponen-input').attr('disabled','disabled')
				.attr('rel','program/search_program/');

				$('#kode-subkomponen-input').val('');
				$('#text-subkomponen-input').val('');
				$('#cr-subkomponen-input').attr('disabled','disabled')
				.attr('rel','program/search_program/');

				$('#input-iku').html('.............................');

//				$('#keluaran').val('');
//				$('#keluaran').attr('disabled','disabled');

				$('#volume').val('');
				$('#volume').attr('disabled','disabled');

				$('#satuan').val('');
				$('#text-satuan').val('');
				$('#text-satuan').attr('disabled','disabled');

				$('#jenis_biaya').val('');
				$('#text-jenis_biaya').val('');
				$('#text-jenis_biaya').attr('disabled','disabled');

				$('#jenis_komponen').val('');
				$('#text-jenis_komponen').val('');
				$('#text-jenis_komponen').attr('disabled','disabled');

				$('#sumber-dana').val('');
				$('#sumber-dana').attr('disabled','disabled');

				$('#kode-akun').val('');
				$('#text-akun').val('');
				$('#cr-akun').attr('disabled','disabled')
				.attr('rel','akun_belanja/search_akun_belanja');

				$('#btn-submit').attr('disabled','disabled');
					
			}

			$("#myModal").modal("hide");

		}
			
</script>

<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    Cari Sasaran
  </div>
  <div class="modal-body">
  	<div class="modal-message">
  		<form class="form-search" onsubmit="return false;">
		<table class="table table-striped">
			<thead>
			<tr>
				<th class="col-md-1">Kode</th>
				<th class="col-md-10" style="text-align:center">Sasaran</th>
				<th class="col-md-1" style="text-align:center">Aksi</th>
			</tr>
			<tr>
				<th colspan="2">
					<input type="text" name="keyword" id="keyword" class="input form-control col-md-2" autocomplete="off" style="text-align:center" />
				</th>
				<th><input type="button" class="btn btn-default" name="show-all" id="show-all" value="Tampilkan Semua" /></th>
			</tr>
			</thead>
			<tbody class="result">
					<?php echo isset($output)?$output:'';?>
			</tbody>
			<tfoot>
			<tr>
				<td align="left" colspan="3" style="color:#ff0000;">
					Ket : Klik salah satu kegiatan untuk memilihnya.
				</td>
			</tr>
			</tfoot>
		</table>
		</form>
	</div>
   
  </div>
  <!--
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
  </div>
  -->
</div>
</div>