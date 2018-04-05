<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Akun_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
        function get_nama_akun5digit($kode_akun,$sumber_dana='SELAIN-APBN'){
            
            $rba = $this->load->database('rba', TRUE);
            $q = $rba->query("SELECT nama_akun5digit FROM akun_belanja WHERE  kode_akun = '{$kode_akun}' AND sumber_dana = '{$sumber_dana}' ");
            
            if($q->num_rows() > 0){
               return $q->row()->nama_akun5digit ;
            }else{
                return '';
            }
            
        }

        function get_nama_akun($kode_akun,$sumber_dana='SELAIN-APBN'){
            
            $rba = $this->load->database('rba', TRUE);
            $f = "kode_akun";
            $h = "nama_akun";
            if(strlen($kode_akun) == 4){
                $f = "kode_akun4digit";
                $h = "nama_akun4digit";
            }elseif(strlen($kode_akun) == 3){
                $f = "kode_akun3digit";
                $h = "nama_akun3digit";
            }elseif(strlen($kode_akun) == 2){
                $f = "kode_akun2digit";
                $h = "nama_akun2digit";
            }elseif(strlen($kode_akun) == 1){
                $f = "kode_akun1digit";
                $h = "nama_akun1digit";
            }

            
            $q = $rba->query("SELECT ".$h." FROM akun_belanja WHERE  ".$f." = '{$kode_akun}' AND sumber_dana = '{$sumber_dana}' ");


            if($q->num_rows() > 0){
               return $q->row()->$h ;
            }else{
                return '';
            }
            
        }

        function get_akun_by_id($id_akun_belanja){
            
            $rba = $this->load->database('rba', TRUE);

            
            $q = $rba->query("SELECT * FROM akun_belanja WHERE id_akun_belanja = '{$id_akun_belanja}' ");


            if($q->num_rows() > 0){
               return $q->row() ;
            }else{
                return '';
            }
            
        }


        function get_list_akun_1d($kode_akun1digit,$sumber_dana='SELAIN-APBN'){

            $rba = $this->load->database('rba', TRUE);

            
            $q = $rba->query("SELECT * FROM akun_belanja WHERE  kode_akun1digit = '{$kode_akun1digit}' AND sumber_dana = '{$sumber_dana}' ");


            if($q->num_rows() > 0){
               return $q->result() ;
            }else{
                return array();
            }

        }

        function search_akun_belanja_all($sumber_dana='SELAIN-APBN'){

            $rba = $this->load->database('rba', TRUE);

            $q = $rba->query("SELECT * FROM akun_belanja WHERE kode_akun1digit = '5' AND sumber_dana = '{$sumber_dana}' ");

            if($q->num_rows() > 0){
               return $q->result() ;
            }else{
                return array();
            }

        }

}