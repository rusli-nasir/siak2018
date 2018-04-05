<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
	$(document).ready(function(){

		$('#toggle-gup').change(function() {
	      

	      if($(this).prop('checked')){

	      	$.ajax({
                type:"GET",
                url :"<?=site_url("setting/proses_buka_tutup/gup/on")?>",
                data:'',
                success:function(data){
                    if(data == 'sukses'){
            	      	bootbox.alert({
				            title: "PESAN",
				            message: "PEMBUATAN DPA GUP TELAH DI AKTIFKAN"
				        });

                   }
                }
            });


	      }else{

	      	$.ajax({
                type:"GET",
                url :"<?=site_url("setting/proses_buka_tutup/gup/off")?>",
                data:'',
                success:function(data){
                    if(data == 'sukses'){
            	      	bootbox.alert({
				            title: "PESAN",
				            message: "PEMBUATAN DPA GUP TELAH DI NON AKTIFKAN"
				        });

                   }
                }
            });

	      	
	      }

	    });

	    $('#toggle-tup').change(function() {
	      

	      if($(this).prop('checked')){

	      	$.ajax({
                type:"GET",
                url :"<?=site_url("setting/proses_buka_tutup/tup/on")?>",
                data:'',
                success:function(data){
                    if(data == 'sukses'){
            	      	bootbox.alert({
				            title: "PESAN",
				            message: "PEMBUATAN DPA TUP TELAH DI AKTIFKAN"
				        });

                   }
                }
            });


	      }else{

	      	$.ajax({
                type:"GET",
                url :"<?=site_url("setting/proses_buka_tutup/tup/off")?>",
                data:'',
                success:function(data){
                    if(data == 'sukses'){
            	      	bootbox.alert({
				            title: "PESAN",
				            message: "PEMBUATAN DPA TUP TELAH DI NON AKTIFKAN"
				        });

                   }
                }
            });

	      	
	      }

	    });

		$('#toggle-lsk').change(function() {
	      

	      if($(this).prop('checked')){

	      	$.ajax({
                type:"GET",
                url :"<?=site_url("setting/proses_buka_tutup/lsk/on")?>",
                data:'',
                success:function(data){
                    if(data == 'sukses'){
            	      	bootbox.alert({
				            title: "PESAN",
				            message: "PEMBUATAN DPA LSK TELAH DI AKTIFKAN"
				        });

                   }
                }
            });


	      }else{

	      	$.ajax({
                type:"GET",
                url :"<?=site_url("setting/proses_buka_tutup/lsk/off")?>",
                data:'',
                success:function(data){
                    if(data == 'sukses'){
            	      	bootbox.alert({
				            title: "PESAN",
				            message: "PEMBUATAN DPA LSNK TELAH DI NON AKTIFKAN"
				        });

                   }
                }
            });

	      	
	      }

	    });

	    $('#toggle-lsnk').change(function() {
	      

	      if($(this).prop('checked')){

	      	$.ajax({
                type:"GET",
                url :"<?=site_url("setting/proses_buka_tutup/lsnk/on")?>",
                data:'',
                success:function(data){
                    if(data == 'sukses'){
            	      	bootbox.alert({
				            title: "PESAN",
				            message: "PEMBUATAN DPA LSNK TELAH DI AKTIFKAN"
				        });

                   }
                }
            });


	      }else{

	      	$.ajax({
                type:"GET",
                url :"<?=site_url("setting/proses_buka_tutup/lsnk/off")?>",
                data:'',
                success:function(data){
                    if(data == 'sukses'){
            	      	bootbox.alert({
				            title: "PESAN",
				            message: "PEMBUATAN DPA LSK TELAH DI NON AKTIFKAN"
				        });

                   }
                }
            });

	      	
	      }

	    });

	});
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>BUKA TUTUP</h2>
                   </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-lg-12">

<?php echo form_open('',array('class'=>'form-horizontal col-md-3'))?>

<div class="panel panel-info">
	<div class="panel-heading">GUP</div>
	  <div class="panel-body">
	    <div class="form-group">
		    <div class="col-md-12" >
		    	<input id="toggle-gup" type="checkbox" <?php echo ($gup=='1')?'checked':''; ?> data-toggle="toggle" data-size="large">
		    </div>
		  </div>
	  </div>

</div>



  
</form>

<?php echo form_open('',array('class'=>'form-horizontal col-md-3'))?>

<div class="panel panel-warning">
	<div class="panel-heading">TUP</div>
	  <div class="panel-body">
	    <div class="form-group">
		    <div class="col-md-12" >
		    	<input id="toggle-tup" type="checkbox" <?php echo ($tup=='1')?'checked':''; ?> data-toggle="toggle" data-size="large">
		    </div>
		  </div>
	  </div>

</div>



  
</form>


<?php echo form_open('',array('class'=>'form-horizontal col-md-3'))?>

<div class="panel panel-success">
	<div class="panel-heading">LSK</div>
	  <div class="panel-body">
	    <div class="form-group">
		    <div class="col-md-12" >
		    	<input id="toggle-lsk" type="checkbox" <?php echo ($lsk=='1')?'checked':''; ?> data-toggle="toggle" data-size="large">
		    </div>
		  </div>
	  </div>

</div>



  
</form>

<?php echo form_open('',array('class'=>'form-horizontal col-md-3'))?>

<div class="panel panel-danger">
	<div class="panel-heading">LSNK</div>
	  <div class="panel-body">
	    <div class="form-group">
		    <div class="col-md-12" >
		    	<input id="toggle-lsnk" type="checkbox" <?php echo ($lsnk=='1')?'checked':''; ?> data-toggle="toggle" data-size="large">
		    </div>
		  </div>
	  </div>

</div>



  
</form>
</div>
	  </div>
	  
</div>
</div>