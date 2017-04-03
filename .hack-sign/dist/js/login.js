$(function() {
        $('#error_message, #success_message').hide();
    $('#form-login').submit(function(e){
        $.post('proses.php',$('#form-login').serialize(),function(data){
           if(data!='1'){
                $('#success_message').hide();
                $('#error_message_body').html(data);
                $('#error_message').show();
                return false;
           }else{
                $('#error_message').hide();
                window.location.reload();
                $('#form-register')[0].reset();
                return false;
           } 
        });
        return false;
    });
});