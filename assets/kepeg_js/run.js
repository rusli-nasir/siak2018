

$('#b_dtpeg').click(function(){  // load class dengan nama tombol
		 $.ajax({  //gunakan ajax
				url:'http://10.69.12.215/rsa/index.php/kepegawaian/load_dtpeg',  //alamat url function load data
			 	method:"POST",                                    // dengan method post
			 	dataType:"HTML",								  // type data HTML ( bisa json/xml)
			 	success:function(dttable){                        // return data
					$('#contain-page').html(dttable);
				   }
			 });

 });
 
 

