<script>
$(document).on('click','.simpan-db',function(e){
	e.preventDefault();
	var data = $('#masukkan-db').serialize();
	$.ajax({
	  type:"POST",
	  url :"<?php echo $_PATH; ?>/process.php",
	  data:data,
	  success:function(data){
		if($.isNumeric(data)){
			
		}else{
			$('.message_sppls').html(data);
			$('#myModalMessage').modal('show');
		}
	  }
	});
});
</script>