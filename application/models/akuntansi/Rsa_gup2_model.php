<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rsa_gup2_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }
    
    function get_spm_detail($no_spm, $columns){
        return $this->db
                    ->select($columns)
                    ->where('str_nomor_trx_spm', $no_spm)
                    ->limit(1)
                    ->get('rsa_kuitansi')
                    ->row() /*or 
                $this->db
                    ->query("SELECT kepeg_tr_spmls.tahun as tahun, kepeg_tr_spmls.unitsukpa as kode_unit, kepeg_tr_sppls.nomor as str_nomor_trx FROM kepeg_tr_spmls, kepeg_tr_sppls WHERE kepeg_tr_spmls.id_tr_sppls = kepeg_tr_sppls.id_sppls AND kepeg_tr_spmls.nomor = '$no_spm'")
                    ->row()*/;
    }

}