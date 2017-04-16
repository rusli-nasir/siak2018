<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rsa_gup2_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }
	
	function readby_spm($no_spm){
        $query = "SELECT posisi "
                . "FROM trx_nomor_gup AS tt1 "
                . "JOIN trx_gup AS t1 ON t1.id_trx_nomor_gup = tt1.id_trx_nomor_gup "
                . "WHERE tt1.str_nomor_trx = '{$no_spm}' "
                . "AND t1.tgl_proses IN ( "
                . "SELECT MAX(t2.tgl_proses) FROM trx_gup AS t2 "
                . "WHERE t2.id_trx_nomor_gup = t1.id_trx_nomor_gup )" ;
        
        $result = $this->db->query($query);
        
        if($result->num_rows()==0){
            return null;
        }
        
        $posisi = $result->row()->posisi;
        
        if(($posisi == 'SPP-FINAL') || ($posisi == 'SPP-DRAFT') || ($posisi == 'SPM-DRAFT-PPK') || ($posisi == 'SPM-DRAFT-KPA') || ($posisi == 'SPM-FINAL-VERIFIKATOR')  || ($posisi == 'SPM-FINAL-KBUU')){
            return $this->db
                    ->where('str_nomor_trx_spm', $no_spm)
                    ->get('rsa_kuitansi');
        } else {
            return null;
        }
    }
    
    function get_spm_detail($no_spm, ... $params){
        return $this->db
                    ->select($params)
                    ->where('str_nomor_trx_spm', $no_spm)
                    ->limit(1)
                    ->get('rsa_kuitansi')
                    ->row();
    }

}