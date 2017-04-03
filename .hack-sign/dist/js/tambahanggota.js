$(function() {
    $('#success_message, #error_message').hide();
		$( "#lcd_onboard" ).change(function() {
			var $input = $( this );
			if($input.is( ":checked" )){
				$('#jum_lcd').removeAttr("disabled");	
			} else {
				$('#jum_lcd').attr("disabled","disabled");
			}
		}).change();
		$( "#mic_onboard" ).change(function() {
			var $input2 = $( this );
			if($input2.is( ":checked" )){
				$('#jum_mic').removeAttr("disabled");	
			} else {
				$('#jum_mic').attr("disabled","disabled");
			}
		}).change();
    $('#proses').click(function(){
        $.post('proses.php',$('#ruang').serialize(),function(data){
           if(data!='1'){
                $('#success_message').hide();
                $('#error_message_body').html(data);
                $('#error_message').show();
           }else{
                $('#act').val('ruang-tambah-proses');
                $('#ruang').submit();
           }
        });
        return false;
    });
		$('#reset').click(function(){
			window.location.reload();
		});
});