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
                   <h2 align="center">Form Input Data UP</h2><hr>
                    </div>
            


<?php echo form_open('rsa_ikw/index','id="form-usulan-belanja" class="form-horizontal col-md-10 col-md-offset-1"'); ?>
	<div class="form-group">
			<label for="kode_unit_kepeg">kode_unit_kepeg</label>
			<input type="text" class="validate[required] form-control" id="kode_unit_kepeg" placeholder="kode_unit_kepeg" ">
		</div>
	<div class="form-group">
			<label for="tgl_transaksi">tgl_transaksi</label>
			<input type="text" class="validate[required] form-control" id="tgl_transaksi" placeholder="tgl_transaksi">
		</div>
		<div class="form-group">
			<label for="kd_transaksi">kd_transaksi</label>
			<input type="text" class="validate[required] form-control" id="kd_transaksi" placeholder="kd_transaksi">
		</div>
		
		<div class="form-group">
			<label for="debet">debet</label>
			<input type="text" class="validate[required] form-control" id="debet" placeholder="debet">
		</div>
		
		<div class="form-group">
			<label for="kredit">kredit</label>
			<input type="text" class="validate[required] form-control" id="kredit" placeholder="kredit">
		</div>
		<div class="form-group">
			<label for="bruto">bruto</label>
			<input type="text" class="validate[required] form-control" id="bruto" placeholder="bruto">
		</div>
		<div class="form-group">
			<label for="pajak">saldo</label>
			<input type="text" class="validate[required] form-control" id="saldo" placeholder="saldo">
		</div>
		
  <div class="alert alert-warning" style="text-align:center">

    	<button type="submit" class="btn btn-lg btn-warning" id="btn-submit" disabled="disabled">Simpan<span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></button>

  </div>

 
</form>

  </div>
	  </div>
	  
</div>


