<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }


    public function get_jumlah_notifikasi_new($level,$status = 'proses')
    {
        return $this->db->get_where('akuntansi_kuitansi_jadi',array('flag'=>$level-1,'status' => $status))->num_rows();
        // $hasil = array();

        // $hasil['kode_akun'] = array_column($query, 'kode_akun');
        // $hasil['nama_akun'] = array_column($query, 'nama_akun');

        // return $hasil;
    }

    
    
    function get_jumlah_notifikasi(){
        $level = $this->session->userdata('level') - 1;
        switch($level){
            case 0: //operator
                $condstr = "((flag=1 AND status='revisi') OR (flag=2 AND status='proses'))";
                break;
                
            case 1: //verifikator
                $condstr = "(flag=1 AND (status='direvisi' OR status='proses'))";
                break;
                
            case 2: //posting
                $condstr = "(flag=2 AND status='proses')";
                break;
        }
		$query = $this->db->query("SELECT (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1 AND flag_proses_akuntansi=$level) AS gup, (SELECT COUNT(*) FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND flag_proses_akuntansi=$level) AS ls, (SELECT COUNT(*) FROM kepeg_tr_spmls) AS spm, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='GP' AND $condstr) AS gup_jadi, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='L3' AND $condstr) AS ls_jadi, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='NK' AND $condstr) AS spm_jadi");
        $result =  $query->row_array();
        $result['kuitansi'] = $result['gup'] + $result['ls'] + $result['spm'];
        $result['kuitansi_jadi'] = $result['gup_jadi'] + $result['ls_jadi'] + $result['spm_jadi'];
        return (object)$result;
	}

}