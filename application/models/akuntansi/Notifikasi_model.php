<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->load->model('akuntansi/Jurnal_rsa_model', 'jurnal_rsa_model');
    }    
    
    function get_jumlah_notifikasi(){
        $level = $this->session->userdata('level') - 1;
        $kode_unit = $this->session->userdata('kode_unit');
        $result = array();
        if($kode_unit) {
            $unit = 'AND substr(kode_unit,1,2)="'.$kode_unit.'"';
            $unit_jadi = 'AND unit_kerja="'.$kode_unit.'"';
            $subunit = '='.$kode_unit;
            $tup_string = " AND substr(trx_tup.kode_unit_subunit,1,2)=$kode_unit";
            $ks_string = " AND substr(trx_ks.kode_unit_subunit,1,2)=$kode_unit";
            $em_string = " AND substr(trx_em.kode_unit_subunit,1,2)=$kode_unit";
        } else {
            $unit = '';
            $unit_jadi = '';
            $subunit = 'like \'%\'';
            $tup_string = '';
            $ks_string = '';
            $em_string = '';
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
        
        $condstr="1";
        switch($level){
            case 0: //operator
                $condstr = "((flag=1 AND status='revisi') OR (flag=1 AND status='proses'))";
                break;
                
            case 1: //verifikator
                $condstr = "((status='proses' AND flag=1) OR (status='direvisi' AND flag=1))";
                //break;
                
            case 2: //posting
                $query2 = $this->db->query("SELECT jenis, COUNT(jenis) as c FROM akuntansi_kuitansi_jadi WHERE tipe<>'pajak' AND flag=2 AND status='proses' $unit_jadi GROUP BY jenis");
                                
                $result['gup_posting'] = 0;
                $result['gu_posting'] = 0;
                $result['ls_posting'] = 0;
                $result['spm_posting'] = 0;
                $result['tup_posting'] = 0;
                $result['up_posting'] = 0;
                $result['tup_nihil_posting'] = 0;
                $result['gup_nihil_posting'] = 0;
                $result['pup_posting'] = 0;
                $result['tup_pengembalian_posting'] = 0;
                $result['gup_pengembalian_posting'] = 0;
                $result['lk_posting'] = 0;
                $result['ln_posting'] = 0;
                $result['ks_posting'] = 0;
                $result['em_posting'] = 0;
                
                foreach($query2->result_array() as $sub_query){
                    $key = $sub_query['jenis'];
                    if($key == 'GP') $result['gup_posting'] = $sub_query['c'];
                    else if($key == 'GUP') $result['gu_posting'] = $sub_query['c'];
                    else if($key == 'UP') $result['up_posting'] = $sub_query['c'];
                    else if($key == 'PUP') $result['pup_posting'] = $sub_query['c'];
                    else if($key == 'TUP') $result['tup_posting'] = $sub_query['c'];
                    else if($key == 'TUP_NIHIL') $result['tup_nihil_posting'] = $sub_query['c'];
                    else if($key == 'GUP_NIHIL') $result['gup_nihil_posting'] = $sub_query['c'];
                    else if($key == 'NK') $result['spm_posting'] = $sub_query['c'];
                    else if($key == 'LK') $result['lk_posting'] = $sub_query['c'];
                    else if($key == 'LN') $result['ln_posting'] = $sub_query['c'];
                    else if($key == 'TUP_PENGEMBALIAN') $result['tup_pengembalian_posting'] = $sub_query['c'];
                    else if($key == 'GUP_PENGEMBALIAN') $result['gup_pengembalian_posting'] = $sub_query['c'];
                    else if($key == 'KS') $result['ks_posting'] = $sub_query['c'];
                    else if($key == 'EM') $result['em_posting'] = $sub_query['c'];
                }
                // echo "<pre>";
                // print_r($result);die();
                
                break;
        }
		$query = $this->db->query("SELECT
            (SELECT count(*) FROM trx_spm_up_data, trx_up WHERE nomor_trx_spm = id_trx_nomor_up_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=$level AND substr(trx_up.kode_unit_subunit,1,2) $subunit) AS up,
            (SELECT COUNT(*) FROM trx_spm_pup_data, trx_pup WHERE nomor_trx_spm = id_trx_nomor_pup_spm AND posisi='SPM-FINAL-KBUU'  AND flag_proses_akuntansi=$level AND trx_spm_pup_data.kode_unit_subunit $subunit) AS pup,
            --(SELECT Count(*) FROM trx_spm_tup_data, trx_tup WHERE nomor_trx_spm = id_trx_nomor_tup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=$level AND trx_spm_tup_data.kode_unit_subunit $subunit) AS tup,
            (SELECT Count(*) FROM trx_spm_tup_data, trx_tup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_tup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx $tup_string AND debet != 0 ) AS tup,
            (SELECT Count(*) FROM trx_spm_ks_data, trx_ks, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_ks_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx $ks_string ) AS ks,

            -- (SELECT Count(*) FROM trx_spm_em_data, trx_em, kas_undip WHERE nomor_trx_spm = id_trx_nomor_em_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx $em_string ) AS em,

            (SELECT count(*) FROM trx_spm_gup_data, trx_gup WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND posisi='SPM-FINAL-KBUU' AND untuk_bayar != 'GUP NIHIL' AND flag_proses_akuntansi=$level AND substr(trx_gup.kode_unit_subunit,1,2) $subunit) AS gu,
            -- (SELECT count(*) FROM trx_spm_gup_data, trx_gup WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND posisi='SPM-FINAL-KBUU' AND untuk_bayar = 'GUP NIHIL' AND flag_proses_akuntansi=$level AND substr(trx_gup.kode_unit_subunit,1,2) $subunit) AS gup_nihil,
            (SELECT count(*) FROM rsa_kuitansi as tk, trx_spm_gup_data as tg WHERE tk.str_nomor_trx_spm = tg.str_nomor_trx AND tg.untuk_bayar = 'GUP NIHIL' AND tk.cair = 1  AND tk.flag_proses_akuntansi=$level $unit) AS gup_nihil,
            -- (SELECT count(*) FROM trx_spm_tup_nihil_data, trx_tup_nihil WHERE nomor_trx_spm = id_trx_nomor_tup AND posisi='SPM-FINAL-KBUU' AND trx_spm_tup_nihil_data.kode_unit_subunit $subunit) AS tup_nihil,
            -- (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1 AND jenis='GP' AND flag_proses_akuntansi=$level $unit) AS gup,
            (SELECT count(*) FROM rsa_kuitansi as tk, trx_spm_gup_data as tg WHERE tk.str_nomor_trx_spm = tg.str_nomor_trx AND tg.untuk_bayar != 'GUP NIHIL' AND tk.cair = 1  AND tk.flag_proses_akuntansi=$level $unit) AS gup,
            -- (SELECT COUNT(*) FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND flag_proses_akuntansi=$level $unit) AS ls,
            (SELECT COUNT(*) FROM rsa_kuitansi_pengembalian WHERE cair=1 AND flag_proses_akuntansi=$level $unit AND jenis='TP' ) AS tup_pengembalian,
            (SELECT COUNT(*) FROM rsa_kuitansi_pengembalian WHERE cair=1 AND flag_proses_akuntansi=$level $unit AND jenis='GP' ) AS gup_pengembalian,
            (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1 AND flag_proses_akuntansi=$level $unit AND jenis='EM' ) AS em,
            (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1  AND jenis='TP' AND flag_proses_akuntansi=$level $unit ) AS tup_nihil,
            -- (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1  AND jenis='GP' AND flag_proses_akuntansi=$level $unit ) AS gup_nihil,
            (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1  AND jenis='LN' AND flag_proses_akuntansi=$level $unit ) AS ln,
            (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1  AND jenis='LK' AND flag_proses_akuntansi=$level $unit ) AS lk,
            (SELECT COUNT(*) FROM `kepeg_tr_spmls` WHERE `flag_proses_akuntansi` =$level AND `proses` = 5 AND substr(unitsukpa,1,2) $subunit) AS spm");
        
        $temp = $query->row_array();
        // echo "SELECT COUNT(*) FROM `kepeg_tr_spmls` WHERE `flag_proses_akuntansi` =$level AND `proses` = 5 AND substr(unitsukpa,1,2) $subunit) AS spm";
        // echo "<pre>";
        // print_r($temp);
        // die("SELECT count(*) FROM trx_spm_gup_data, trx_gup WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND posisi='SPM-FINAL-KBUU' AND untuk_bayar != 'GUP NIHIL' AND flag_proses_akuntansi=$level AND substr(trx_gup.kode_unit_subunit,1,2) $subunit");
        // die("SELECT Count(*) FROM trx_spm_em_data, trx_em, kas_undip WHERE nomor_trx_spm = id_trx_nomor_em_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx $em_string");
        // die("SELECT Count(*) FROM trx_spm_em_data, trx_em WHERE nomor_trx_spm = id_trx_nomor_em_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0  $em_string");
        // die("SELECT Count(*) FROM trx_spm_ks_data, trx_ks, kas_kerjasama WHERE nomor_trx_spm = id_trx_nomor_ks_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx $ks_string");

        $result =  array_merge($result, $temp);

        $result['belum'] = $temp;
        
        $result['kuitansi'] = $result['up'] + $result['pup'] + $result['gup'] + $result['gu'] + $result['gup_nihil'] + $result['tup'] + $result['tup_nihil']  + $result['lk'] + $result['ln'] + $result['spm'] + $result['tup_pengembalian'] + $result['gup_pengembalian'] + $result['ks'] + $result['em'];
        
        // $query2 = $this->db->query("SELECT jenis, COUNT(jenis) as c FROM akuntansi_kuitansi_jadi WHERE tipe<>'pajak' AND $condstr $unit_jadi GROUP BY jenis");
         $query2 = $this->db->query("SELECT jenis, COUNT(jenis) as c FROM akuntansi_kuitansi_jadi ak WHERE tipe<>'pajak' AND $condstr $unit_jadi AND ak.akun_debet NOT IN (select kode_akun from rba_2018.akun_belanja ab where ab.nama_akun LIKE '[ JANGAN%') GROUP BY ak.jenis");
                                 
        $result['gup_jadi'] = 0;
        $result['gu_jadi'] = 0;
        $result['ls_jadi'] = 0;
        $result['lk_jadi'] = 0;
        $result['ln_jadi'] = 0;
        $result['spm_jadi'] = 0;
        $result['tup_jadi'] = 0;
        $result['up_jadi'] = 0;
        $result['tup_nihil_jadi'] = 0;
        $result['gup_nihil_jadi'] = 0;
        $result['pup_jadi'] = 0;
        $result['tup_pengembalian_jadi'] = 0;
        $result['gup_pengembalian_jadi'] = 0;
        $result['ks_jadi'] = 0;
        $result['em_jadi'] = 0;
        $result['akun_invalid'] = count($this->Jurnal_rsa_model->get_akun_invalid());

        foreach($query2->result_array() as $sub_query){
            $key = $sub_query['jenis'];
            if($key == 'GP') $result['gup_jadi'] = $sub_query['c'];
            else if($key == 'GUP') $result['gu_jadi'] = $sub_query['c'];
            else if($key == 'UP') $result['up_jadi'] = $sub_query['c'];
            else if($key == 'PUP') $result['pup_jadi'] = $sub_query['c'];
            else if($key == 'TUP') $result['tup_jadi'] = $sub_query['c'];
            else if($key == 'TUP_NIHIL') $result['tup_nihil_jadi'] = $sub_query['c'];
            else if($key == 'GUP_NIHIL') $result['gup_nihil_jadi'] = $sub_query['c'];
            else if($key == 'LK') $result['lk_jadi'] = $sub_query['c'];
            else if($key == 'LN') $result['ln_jadi'] = $sub_query['c'];
            else if($key == 'NK') $result['spm_jadi'] = $sub_query['c'];
            else if($key == 'TUP_PENGEMBALIAN') $result['tup_pengembalian_jadi'] = $sub_query['c'];
            else if($key == 'GUP_PENGEMBALIAN') $result['gup_pengembalian_jadi'] = $sub_query['c'];
            else if($key == 'KS') $result['ks_jadi'] = $sub_query['c'];
            else if($key == 'EM') $result['em_jadi'] = $sub_query['c'];
        }
        
        $result['kuitansi_jadi'] = $result['gup_jadi'] + $result['gu_jadi']  + $result['lk_jadi'] + $result['ln_jadi'] + $result['spm_jadi'] + $result['tup_jadi'] + $result['up_jadi'] + $result['tup_nihil_jadi'] + $result['gup_nihil_jadi'] + $result['pup_jadi'] + $result['tup_pengembalian_jadi'] + $result['gup_pengembalian_jadi'] + $result['ks_jadi'] + $result['em_jadi'];

        // $level = 1;

        // $query = $this->db->query("SELECT
        //     (SELECT count(*) FROM trx_spm_up_data, trx_up WHERE nomor_trx_spm = id_trx_nomor_up_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=$level AND substr(trx_up.kode_unit_subunit,1,2) $subunit) AS up,
        //     (SELECT COUNT(*) FROM trx_spm_pup_data, trx_pup WHERE nomor_trx_spm = id_trx_nomor_pup_spm AND posisi='SPM-FINAL-KBUU'  AND flag_proses_akuntansi=$level AND trx_spm_pup_data.kode_unit_subunit $subunit) AS pup,
        //     (SELECT Count(*) FROM trx_spm_tup_data, trx_tup WHERE nomor_trx_spm = id_trx_nomor_tup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=$level AND trx_spm_tup_data.kode_unit_subunit $subunit) AS tup,
        //     (SELECT count(*) FROM trx_spm_gup_data, trx_gup WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=$level AND substr(trx_gup.kode_unit_subunit,1,2) $subunit) AS gu,
        //     -- (SELECT count(*) FROM trx_spm_tup_nihil_data, trx_tup_nihil WHERE nomor_trx_spm = id_trx_nomor_tup AND posisi='SPM-FINAL-KBUU' AND trx_spm_tup_nihil_data.kode_unit_subunit $subunit) AS tup_nihil,
        //     (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1 AND jenis='GP' AND flag_proses_akuntansi=$level $unit) AS gup,
        //     (SELECT 0) AS gup_nihil,
        //     (SELECT COUNT(*) FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND flag_proses_akuntansi=$level $unit) AS ls,
        //     (SELECT COUNT(*) FROM rsa_kuitansi_pengembalian WHERE cair=1 AND flag_proses_akuntansi=$level $unit) AS tup_pengembalian,
        //     (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1  AND jenis='TP' AND flag_proses_akuntansi=$level $unit ) AS tup_nihil,
        //     (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1  AND jenis='LN' AND flag_proses_akuntansi=$level $unit ) AS ln,
        //     (SELECT COUNT(*) FROM rsa_kuitansi WHERE cair=1  AND jenis='LK' AND flag_proses_akuntansi=$level $unit ) AS lk,
        //     (SELECT COUNT(*) FROM `kepeg_tr_spmls` WHERE `flag_proses_akuntansi` =$level AND `proses` = 5 AND substr(unitsukpa,1,2) $subunit) AS spm");

        // $temp = $query->row_array();

        // $result =  array_merge($result, $temp);

        // print_r($result);die();

        // $result['sudah'] = $temp;
      
        return (object)$result;
	}

}