<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Akun_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
        function get_nama_akun5digit($kode_akun,$sumber_dana){
            
            $rba = $this->load->database('rba', TRUE);
            $q = $rba->query("SELECT nama_akun5digit FROM akun_belanja WHERE  kode_akun = '{$kode_akun}' AND sumber_dana = '{$sumber_dana}' ");
            
            if($q->num_rows() > 0){
               return $q->row()->nama_akun5digit ;
            }else{
                return '';
            }
            
        }

}