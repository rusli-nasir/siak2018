<html>
    <head>
      
    </head>
    <body>
        <h2>Detail Belanja Web Service</h2>
        <form method="get" action="">
            Kode Usulan Belanja  : <input type="text" name="kode_usulan_belanja"/>
            
            Deskripsi  : <input type="text" name="deskripsi"/>
            
            <button type="submit">Search</button>
        </form>
         <?php 
        
            if($_GET){
            
                $s_kode_usulan_belanja= isset($_GET['kode_usulan_belanja']) ? $_GET['kode_usulan_belanja'] : '';
                $s_deskripsi= isset($_GET['deskripsi']) ? $_GET['deskripsi'] : '';

                $url  = "http://".$_SERVER['HTTP_HOST']."/rsa/service/web_service.php?API=Detail8488&kode_usulan_belanja={$s_kode_usulan_belanja}&deskripsi={$s_deskripsi}";
                
                $fields = array(
                    'kode_usulan_belanja' => $s_kode_usulan_belanja,
                    'deskripsi' => $s_deskripsi
                );
                
                $data = http_build_query($fields);

                $context = stream_context_create(array(
                    'http' =>  array(
                        'method'  => 'GET',
                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $data,
                    )
                ));

                $result = file_get_contents($url, false, $context);
				//var_dump($result);die;
                //decode json nya ke array
                $vr = json_decode($result,true);
                
                echo "<pre>";
                    print_r($vr);
                echo "</pre>";
            }
            
        
        ?>
    </body>
</html>