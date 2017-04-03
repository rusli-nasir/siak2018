$(document).ready(function() {
    $('#example').DataTable();
} );


var site = "http://10.69.12.215/rsa/index.php/kepegawaian/cari_data";
        $(function(){
            $('.autocomplete').autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: site,
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                 onSelect: function (suggestion) {
                    $('#dtcari').val(''+suggestion.value); 
                    $('#dtcari2').val(''+suggestion.nip); 
                    
                }
            });
        });
        
        
     

