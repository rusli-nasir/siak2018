<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
	$(document).ready(function () {

		<?php if(isset($_SESSION['subkomponen-input']['kode'])){?>

		$("#input-iku").load('<?php echo site_url('iku/get_iku');?>/' + '<?=$_SESSION['kegiatan']['kode']?>' + '/' + '<?=$_SESSION['output']['kode']?>',function(){

					var kode_iku_json = <?php  echo json_encode($_SESSION['kode_iku']); ?> ;

					$.each(kode_iku_json, function( index, value ) {
						
				  		$('input[type="checkbox"]').each(function(){

							if($(this).val() == value){

								$(this).prop('checked', true);
							}

						});
					});

		});





		<?php } ?>

		if($("#kode-akun").val()!=''){
			$("#btn-submit").removeAttr('disabled');

		}


		$("#sumber-dana").change(function () {
		        // var end = this.value;
		        // var firstDropVal = $('#pick').val();
		        if($.trim($(this).val())==''){
		        	$("#cr-akun").attr('disabled','disabled');
		        }
		        else{
		        	$("#cr-akun").removeAttr('disabled');
		        }

		        $("#kode-akun").val('');
		        $("#text-akun").val('');
		        $("#btn-submit").attr('disabled','disabled');

		    });


		$(document).on("click",".btn_pick_1",function(){
		//$('.display-member').live('focus', function(){
			$('#form-usulan-belanja').validationEngine('hide');

			$("#myModal").load('<?php echo base_url();?>index.php/' + $(this).attr('rel'),
				function(){
					$("#myModal").modal("show");
				}
			);

			return false;

		});

		$(document).on("click",".btn_pick_2",function(){
		//$('.display-member').live('focus', function(){
			$('#form-usulan-belanja').validationEngine('hide');

			var sumber_dana = $("#sumber-dana").val();

			$("#myModal").load('<?php echo base_url();?>index.php/' + $(this).attr('rel') + '/' + sumber_dana,
				function(){
					$("#myModal").modal("show");
				}
			);

		});
		
	$(document).on("submit","#form-usulan-belanja",function(){		
	//$('#form-usulan-belanja').live('submit', function(){
			$('input[type="text"]').each(function(){
				if($(this).is(':disabled')){
					$(this).removeAttr('disabled');
				}
			});

			return $('#form-usulan-belanja').validationEngine('validate');
		});
	});





</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                   <h2 align="center">Form Input Data SPP</h2><hr>
                    </div>
            


<?php echo form_open('usulan_belanja/index','id="form-usulan-belanja" class="form-horizontal col-md-10 col-md-offset-1"'); ?>
	<div class="form-group">
			<label for="kd_spm">Kode SPM</label>
			<input type="text" class="validate[required] form-control" id="kd_spm" placeholder="Kode SPM" value="<?=$kd_spm?>" disabled>
		</div>
	<div class="form-group">
			<label for="id">id</label>
			<input type="text" class="validate[required] form-control" id="id" placeholder="id">
		</div>
		<div class="form-group">
			<label for="tahun">Tahun</label>
			<input type="text" class="validate[required] form-control" id="tahun" placeholder="tahun">
		</div>
		
		<div class="form-group">
			<label for="tgl_spm">Tanggal SPM</label>
			<input type="text" class="validate[required] form-control" id="tgl_spm" placeholder="Tanggal SPM">
		</div>
		
		<div class="form-group">
			<label for="no_spm">No SPM</label>
			<input type="text" class="validate[required] form-control" id="no_spm" placeholder="Nomor SPM">
		</div>
		<div class="form-group">
			<label for="kode_unit">Kode Unit</label>
			<input type="text" class="validate[required] form-control" id="kode_unit" placeholder="Kode Unit">
		</div>
		<div class="form-group">
			<label for="jumlah">Jumlah</label>
			<input type="text" class="validate[required] form-control" id="jumlah" placeholder="Jumlah">
		</div>
		<div class="form-group">
			<label for="penerima">Penerima</label>
			<input type="text" class="validate[required] form-control" id="penerima" placeholder="Penerima SPM">
		</div>
		<div class="form-group">
			<label for="posisi">Posisi</label>
			<input type="text" class="validate[required] form-control" id="posisi" placeholder="posisi SPM">
		</div>
		<div class="form-group">
			<label for="revisi">Revisi</label>
			<input type="text" class="validate[required] form-control" id="revisi" placeholder="Revisi SPM">
		</div>
		<div class="form-group">
			<label for="status">Status</label>
			<input type="text" class="validate[required] form-control" id="status" placeholder="Status SPM">
		</div>
    
  <div class="alert alert-warning" style="text-align:center">

    	<button type="submit" class="btn btn-lg btn-warning" id="btn-submit" disabled="disabled">Simpan SPP <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></button>

  </div>

  <div class="alert alert-info" style="text-align:center">

  	<a href="<?php echo site_url('spm/daftar_spm');?>" class="btn btn-success" id="link_usulan_belanja"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></span> Daftar SPP</a>
	
  </div>


</form>

  </div>
	  </div>
	  
</div>


