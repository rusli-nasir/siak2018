$(function() {
    $('#form-info-institusi').submit(function(e){
        $.post('proses.php',$('#form-info-institusi').serialize(),function(data){
           alert(data); 
        });
        return false;
    });
});