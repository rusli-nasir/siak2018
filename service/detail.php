<?php
require_once "koneksi.php";

class DetailWebService{
    
    protected $kode_usulan_belanja;
    protected $deskripsi;
    
    //misal API yg dikasih utk client
    protected $API = 'Detail8488';
    
    public function setKode_usulan_belanja($kode_usulan_belanja){
        
        $this->kode_usulan_belanja = $kode_usulan_belanja;
    }
    public function getKode_usulan_belanja(){
        
        return $this->kode_usulan_belanja;
    }
    
    public function setDeskripsi($deskripsi){
 
        $this->deskripsi = $deskripsi;
    }
    public function getDeskripsi(){
        
        return $this->deskripsi;
    }
    
    public function validateAPI($api){
        
        if($this->API !== $api)
            return false;
            
        return true;
    }
    
    
    public function getDetail(){
					
       $objAr= new ActiveRecord();
       
       /*Query blm pake bind params, silahkan edit sendiri*/
       $sql = "SELECT * FROM rsa_detail_belanja_ WHERE 1=1 AND RIGHT(proses,1)='4' ";
          if($this->getKode_usulan_belanja()){        
              $sql .=" AND kode_usulan_belanja LIKE '%{$this->getKode_usulan_belanja()}%' ";
          }
          if($this->getDeskripsi()){
            $sql .=" AND deskripsi LIKE '%{$this->getDeskripsi()}%' ";
          }
		
      return $objAr->fetchObject($sql);
       
    }	
}