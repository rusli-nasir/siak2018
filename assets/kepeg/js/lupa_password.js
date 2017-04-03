$(function() {
        $('#error_message, #success_message').hide();
    $('#lupa_password').submit(function(e){
        $.post('proses.php',$('#lupa_password').serialize(),function(data){
           if(data!='1'){
                $('#success_message').hide();
                $('#error_message_body').html(data);
                $('#error_message').show();
                return false;
           }else{
                $('#error_message').hide();
                $('#success_message_body').html('Anda berhasil melakukan pengiriman email pemulihan password Anda. Silahkan untuk mengecek inbox/spam sesuai dengan alamat email yang Anda masukkan. Gunakan username dan password tertera untuk melakukan login.<br /><br />Terimakasih.');
                $('#success_message').show();
                $('#lupa_password')[0].reset();
                return false;
           } 
        });
        return false;
    });
});