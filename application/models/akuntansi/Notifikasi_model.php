<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }
    
    function get_jumlah_notifikasi(){
		$query = $this->db->query("SELECT (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1 AND flag_proses_akuntansi=".($this->session->userdata('level') - 1) . ") AS gup, (SELECT COUNT(*) FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND flag_proses_akuntansi=".($this->session->userdata('level') - 1) . ") AS ls, (SELECT COUNT(*) FROM kepeg_tr_spmls) AS spm, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi) AS gup_jadi, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='L3') AS ls_jadi, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='SPM') AS spm_jadi");
        $result =  $query->row_array();
        $result['kuitansi'] = $result['gup'] + $result['ls'] + $result['spm'];
        $result['kuitansi_jadi'] = $result['gup_jadi'] + $result['ls_jadi'] + $result['spm_jadi'];
        return (object)$result;
	}
}