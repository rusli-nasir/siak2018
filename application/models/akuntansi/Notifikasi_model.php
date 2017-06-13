<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }    
    
    function get_jumlah_notifikasi(){
        $level = $this->session->userdata('level') - 1;
        $kode_unit = $this->session->userdata('kode_unit');
        if($kode_unit) {
            $unit = 'AND kode_unit="'.$kode_unit.'"';
            $unit_jadi = 'AND unit_kerja="'.$kode_unit.'"';
            $subunit = '='.$kode_unit;
        } else {
            $unit = '';
            $unit_jadi = '';
            $subunit = 'like \'%\'';
        }
        
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '1';
        }else{
            if($this->session->userdata('alias')=='WR2'){
                $alias = 'W23';
            }else{
                $alias = $this->session->userdata('alias');
            }
            $filter_unit = "substr(nomor,7,3)='".$alias."'";
        }
        
        $condstr="1"; $condstr2="";
        switch($level){
            case 0: //operator
                $condstr = "((flag=1 AND status='revisi') OR (flag=2 AND status='proses'))";
                break;
                
            case 1: //verifikator
                $condstr = "(flag=1 AND (status='direvisi' OR status='proses'))";
                //break;
                
            case 2: //posting
                $condstr2 = ",(SELECT COUNT(*) FROM kepeg_tr_spmls) AS spm, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='GP' AND jenis<>'pajak' AND (flag=2 AND status='proses') $unit_jadi) AS gup_posting, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='GUP' AND jenis<>'pajak' AND (flag=2 AND status='proses') $unit_jadi) AS gu_posting, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='GUP_NIHIL' AND jenis<>'pajak' AND (flag=2 AND status='proses') $unit_jadi) AS gup_nihil_posting, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='UP' AND jenis<>'pajak' AND (flag=2 AND status='proses') $unit_jadi) AS up_posting, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='TUP' AND jenis<>'pajak' AND (flag=2 AND status='proses') $unit_jadi) AS tup_posting, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='TUP_NIHIL' AND jenis<>'pajak' AND (flag=2 AND status='proses') $unit_jadi) AS tup_nihil_posting, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='PUP' AND jenis<>'pajak' AND (flag=2 AND status='proses') $unit_jadi) AS pup_posting, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='GUP_NIHIL' AND jenis<>'pajak' AND (flag=2 AND status='proses') $unit_jadi) AS gup_nihil_posting, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='L3' AND jenis<>'pajak' AND (flag=2 AND status='proses')) AS ls_posting, (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='NK' AND jenis<>'pajak' AND (flag=2 AND status='proses')) AS spm_posting";
                break;
        }
		$query = $this->db->query("SELECT
            (SELECT count(*) FROM trx_spm_up_data, trx_up WHERE nomor_trx_spm = id_trx_nomor_up AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=$level AND substr(trx_up.kode_unit_subunit,1,2) $subunit) AS up,
            (SELECT COUNT(*) FROM trx_spm_tambah_up_data, trx_tambah_up WHERE nomor_trx_spm = id_trx_nomor_tambah_up AND posisi='SPM-FINAL-KBUU'  AND flag_proses_akuntansi=$level AND trx_spm_tambah_up_data.kode_unit_subunit $subunit) AS pup,
            (SELECT Count(*) FROM trx_spm_tambah_tup_data, trx_tambah_tup WHERE nomor_trx_spm = id_trx_nomor_tambah_tup AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=$level AND trx_spm_tambah_tup_data.kode_unit_subunit $subunit) AS tup,
            (SELECT COUNT(*) FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE id_trx_spm_gup_data = id_trx_nomor_gup AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi='$level' AND no_spm = str_nomor_trx AND trx_spm_gup_data.kode_unit_subunit $subunit) AS gu,
            (SELECT count(*) FROM trx_spm_tup_data, trx_tup WHERE nomor_trx_spm = id_trx_nomor_tup AND posisi='SPM-FINAL-KBUU' AND trx_spm_tup_data.kode_unit_subunit $subunit) AS tup_nihil,
            (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1 AND flag_proses_akuntansi=$level $unit) AS gup,
            (SELECT 0) AS gup_nihil,
            (SELECT COUNT(*) FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND flag_proses_akuntansi=$level) AS ls,
            (SELECT COUNT(*) FROM `kepeg_tr_spmls` WHERE `flag_proses_akuntansi` =$level AND `proses` = 5 AND substr(unitsukpa,1,2) $subunit) AS spm,
            (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='GP' AND jenis<>'pajak' AND $condstr $unit_jadi) AS gup_jadi,
            (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='TUP' AND jenis<>'pajak' AND $condstr $unit_jadi) AS tup_jadi,
            (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='UP' AND jenis<>'pajak' AND $condstr $unit_jadi) AS up_jadi,
            (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='TUP_NIHIL' AND jenis<>'pajak' AND $condstr $unit_jadi) AS tup_nihil_jadi,
            (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='PUP' AND jenis<>'pajak' AND $condstr $unit_jadi) AS pup_jadi,
            (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='GUP' AND jenis<>'pajak' AND $condstr $unit_jadi) AS gu_jadi,
            (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='GUP_NIHIL' AND jenis<>'pajak' AND $condstr $unit_jadi) AS gup_nihil_jadi,
            (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='L3' AND jenis<>'pajak' AND $condstr $unit_jadi) AS ls_jadi,
            (SELECT COUNT(*) FROM akuntansi_kuitansi_jadi WHERE jenis='NK' AND jenis<>'pajak' AND $condstr $unit_jadi) AS spm_jadi $condstr2");
        $result =  $query->row_array();
        
        $result['kuitansi'] = $result['up'] +$result['pup'] + $result['gup'] + $result['gu'] + $result['gup_nihil']  +$result['tup'] +$result['tup_nihil'] + $result['ls'] + $result['spm'];
        $result['kuitansi_jadi'] = $result['gup_jadi'] + $result['gu_jadi'] + $result['ls_jadi'] + $result['spm_jadi'] + $result['tup_jadi'] + $result['up_jadi'] + $result['tup_nihil_jadi'] + $result['gup_nihil_jadi'] + $result['pup_jadi'];
        return (object)$result;
	}

}