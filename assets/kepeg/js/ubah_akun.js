$(function() {
    $('#error_message, #success_message, #error_message2, #success_message2').hide();
    $('#ubahakun_profil').submit(function(e){
        $.post('proses.php',$('#ubahakun_profil').serialize(),function(data){
           if(data!='1'){
                $('#success_message').hide();
                $('#error_message_body').html(data);
                $('#error_message').show();
                return false;
           }else{
                $('#error_message').hide();
                $('#success_message_body').html('Perubahan disimpan.');
                $('#success_message').show();
                $('#ubahakun_username')[0].reset();
                return false;
           } 
        });
        return false;
    });
    
    $('#ubahakun_password').submit(function(e){
        $.post('proses.php',$('#ubahakun_password').serialize(),function(data){
           if(data!='1'){
                $('#success_message2').hide();
                $('#error_message_body2').html(data);
                $('#error_message2').show();
                return false;
           }else{
                $('#error_message2').hide();
                $('#success_message_body2').html('Perubahan disimpan.');
                $('#success_message2').show();
                $('#ubahakun_password')[0].reset();
                return false;
           } 
        });
        return false;
    });
});