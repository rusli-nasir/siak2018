<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kas_undip_model
 *
 * @author U.L.T.R.O.N
 */
class Kas_undip_model extends CI_Model{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
/* -------------- Method ------------- */
	/*	Fungsi untuk mencari data subkomponen input	*/
	
	
	}
    //put your code here
    
            
        function get_nominal($kd_akun_kas){
            $this->db->where('kd_akun_kas',$kd_akun_kas);
            $this->db->where('aktif','1');
            // $this->db->where('kd_unit','99');

            $q = $this->db->get('kas_undip');
            
            if($q->num_rows() > 0){
                   return $q->row()->saldo ;
                }else{
                    return '0';
                } 

        }
        
        function isi_trx($data){
            
            $this->db->where('aktif', '1');
            $this->db->where('kd_akun_kas', $data['kd_akun_kas']);
            // $this->db->where('kd_unit', $data['kd_unit']);
            $this->db->update('kas_undip', array('aktif'=>'0')); 
            
            return $this->db->insert("kas_undip",$data);

        }
        
        function get_total_kas(){
            $s = "SELECT SUM(saldo) AS total_kas FROM kas_undip WHERE aktif = '1' ";
            $q = $this->db->query($s);
            
            if($q->num_rows() > 0){
                   return $q->row()->total_kas ;
                }else{
                    return '0';
                } 
        }
        
}
