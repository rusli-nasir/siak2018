<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kas_up_model
 *
 * @author U.L.T.R.O.N
 */
class Kas_bendahara_model extends CI_Model{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
	}
    //put your code here
    
            
        function get_kas_bendahara($kode_unit,$tahun){
            $query = "SELECT * FROM kas_bendahara WHERE kd_unit = '{$kode_unit}' AND tahun = '{$tahun}' AND aktif = '1'" ;

//                        echo $query; die;

            $q = $this->db->query($query);

            $result = $q->row();

//                var_dump($result);die;

            return $result ;
            
        }

        function get_kas_bendahara_tup($kode_unit,$tahun){
            $query = "SELECT * FROM kas_bendahara WHERE kd_unit = '{$kode_unit}' AND tahun = '{$tahun}' AND aktif = '2'" ;

//                        echo $query; die;

            $q = $this->db->query($query);

            $result = $q->row();

//                var_dump($result);die;

            return $result ;
            
        }
        
        function get_kas_saldo($kode_unit,$tahun){
            $query = "SELECT saldo FROM kas_bendahara WHERE kd_unit = '{$kode_unit}' AND tahun = '{$tahun}' AND aktif = '1'" ;

            // echo $query ; 

            $q = $this->db->query($query);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->saldo;
                }else{
                    return 0;
                } 
            
        }

        function get_kas_saldo_up($kode_unit,$tahun){
            $query = "SELECT saldo FROM kas_bendahara WHERE kd_unit = '{$kode_unit}' AND tahun = '{$tahun}' AND jenis = 'UP' AND aktif = '1'" ;

            // echo $query ; 

            $q = $this->db->query($query);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->saldo;
                }else{
                    return 0;
                } 
            
        }

        function get_kas_saldo_tup($kode_unit,$tahun){
            $query = "SELECT saldo FROM kas_bendahara WHERE kd_unit = '{$kode_unit}' AND tahun = '{$tahun}' AND jenis = 'TUP' AND aktif = '1'" ;

            // echo $query ; 

            $q = $this->db->query($query);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->saldo;
                }else{
                    return 0;
                } 
            
        }

        function get_last_spm_tup_cair($kode_unit,$tahun){
            $query = "SELECT no_spm FROM kas_bendahara WHERE kd_unit = '{$kode_unit}' AND tahun = '{$tahun}' AND jenis = 'TUP' AND aktif = '1'" ;

            // echo $query ; 

            $q = $this->db->query($query);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->no_spm;
                }else{
                    return '';
                } 
            
        }

        function get_last_spm_gup_cair($kode_unit,$tahun){
            $query = "SELECT no_spm FROM kas_bendahara WHERE kd_unit = '{$kode_unit}' AND tahun = '{$tahun}' AND jenis = 'UP' AND aktif = '1'" ;

            // echo $query ; 

            $q = $this->db->query($query);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->no_spm;
                }else{
                    return '';
                } 
            
        }

        

        function get_kas_saldo_ks($kode_unit,$tahun){
            $query = "SELECT saldo FROM kas_bendahara WHERE kd_unit = '{$kode_unit}' AND tahun = '{$tahun}' AND aktif = '1'" ;

            // echo $query ; 

            $q = $this->db->query($query);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->saldo;
                }else{
                    return 0;
                } 
            
        }
        
        function get_total_pencairan_bendahara($tahun){
            $query = "SELECT SUM(debet) AS total FROM kas_bendahara WHERE tahun = '{$tahun}' " ;

            $q = $this->db->query($query);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->total;
                }else{
                    return 0;
                } 
            
        }
        
        function get_total_pengeluaran_bendahara($kd_unit,$tahun){
            $query = "SELECT SUM(kredit) AS total FROM kas_bendahara WHERE tahun = '{$tahun}' AND kd_unit = '{$kd_unit}' " ;

            // echo $query; 

            $q = $this->db->query($query);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->total;
                }else{
                    return 0;
                } 
            
        }

        function get_kas_bendahara_by_kd_akun_and_unit($kd_akun_kas,$kd_unit,$jenis,$tahun){
            $query = "SELECT saldo FROM kas_bendahara WHERE kd_akun_kas = '{$kd_akun_kas}' AND kd_unit = '{$kd_unit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}' AND aktif = '1'" ;

            $q = $this->db->query($query);

            if($q->num_rows() > 0){
                   return $q->row()->saldo;
                }else{
                    return 0;
                } 

        }

        function get_kas_bendahara_by_spm($nomor_trx_spm_cair){
            $query = "SELECT saldo FROM kas_bendahara WHERE no_spm = '{$nomor_trx_spm_cair}' AND aktif = '1'" ;

            $q = $this->db->query($query);

            if($q->num_rows() > 0){
                   return $q->row()->saldo;
                }else{
                    return 0;
                } 

        }

        

        function get_kas_bendahara_kd_akun($kd_unit,$jenis,$tahun){

            $query = "SELECT kd_akun_kas FROM kas_bendahara WHERE kd_unit = '{$kd_unit}' AND jenis = '{$jenis}' AND tahun = '{$tahun}' AND aktif = '1'" ;

            $q = $this->db->query($query);

            if($q->num_rows() > 0){
                   return $q->row()->kd_akun_kas;
                }else{
                    return '';
                } 

        }

        function get_kas_bendahara_kd_akun_by_spm($nomor_trx_spm_cair){

            $query = "SELECT kd_akun_kas FROM kas_bendahara WHERE no_spm = '{$nomor_trx_spm_cair}' AND aktif = '1'" ;

            $q = $this->db->query($query);

            if($q->num_rows() > 0){
                   return $q->row()->kd_akun_kas;
                }else{
                    return '';
                } 

        }
        
}
