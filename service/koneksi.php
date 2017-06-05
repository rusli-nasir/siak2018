
<?php
ini_set('display_errors', '1');
class Koneksi {
    protected $dns 	= "mysql:host=10.37.19.43;dbname=rsa";     protected $db_user 	= "rba";
    protected $db_pass 	= "rbaund1p";
    protected $konek 	= "";

    public function getKon() {
	try{
			
	  $db = new PDO($this->dns,$this->db_user,$this->db_pass);
	  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  if($db===FALSE){
			
	     throw new Exception("Koneksi Gagal");
				
	  }else{
			
	    $this->konek = $db;
	  }
			
	}catch(Exception $e){
		
	   echo "Error : ".$e->getMessage();
	}

	return $this->konek;
   }
	
    public function closeKon(){
		
	$this->konek = NULL;
    }
}


class ActiveRecord extends Koneksi{
	
    public function fetchObject($sql){
	
	$clone = array();
		
	try{

	   $data =  $this->getKon()->prepare($sql);
	   $data->setFetchMode(PDO::FETCH_INTO,$this);
	   $data->execute(); 

	   while($result = $data->fetch()){
				
		$clone[] = clone $result;
	   }

	   $this->closeKon();
			
	}catch(PDOException $e){
		    
	    echo $e->getMessage();
	}
	
       return $clone;

   }
}
?>