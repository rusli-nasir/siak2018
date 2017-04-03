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
class Kas_up_model extends CI_Model{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
	}
    //put your code here
    
            
        function get_kas_up($kode_unit,$tahun){
            $query = "SELECT * FROM kas_up WHERE kd_unit = '{$kode_unit}' AND tahun = '{$tahun}' AND aktif = '1'" ;

//                        echo $query; die;

            $q = $this->db->query($query);

            $result = $q->result();

//                var_dump($result);die;

            return $result ;
            
        }
        
        function get_kas_saldo($kode_unit,$tahun){
            $query = "SELECT saldo FROM kas_up WHERE kd_unit = '{$kode_unit}' AND tahun = '{$tahun}' AND aktif = '1'" ;

            $q = $this->db->query($query);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->saldo;
                }else{
                    return 0;
                } 
            
        }
        
        function get_total_pencairan_up($tahun){
            $query = "SELECT SUM(debet) AS total FROM kas_up WHERE tahun = '{$tahun}' " ;

            $q = $this->db->query($query);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->total;
                }else{
                    return 0;
                } 
            
        }
}
