$(function() {
        $('#error_message, #success_message').hide();
		$( "#namatim" ).autocomplete({
			source: "autocomplete-grup.php",
			minLength: 2,
			select: function( event, ui ) {
				$('#id').val(ui.item.id);
			}
		});
    $( "#namaint" ).autocomplete({
			source: "autocomplete-institusi.php",
			minLength: 2,
			select: function( event, ui ) {
				$('#idint').val(ui.item.id);
			}
		});
    $( "#nama" ).autocomplete({
			source: "autocomplete-cp.php",
			minLength: 2,
			select: function( event, ui ) {
				$('#idtim').val(ui.item.id);
			}
		});
    $('#form-register').submit(function(e){
        $.post('proses.php',$('#form-register').serialize(),function(data){
           if(data!='1'){
                $('#success_message').hide();
                $('#error_message_body').html(data);
                $('#error_message').show();
                return false;
           }else{
                $('#error_message').hide();
                $('#success_message_body').html('Anda berhasil melakukan aktivasi ini. Silahkan untuk mengecek inbox sesuai dengan alamat email yang Anda masukkan. Gunakan username dan password tertera untuk melakukan login.<br /><br />Terimakasih.');
                $('#success_message').show();
                $('#form-register')[0].reset();
                return false;
           } 
        });
        return false;
    });
});