<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Potongan_lainnya_model extends CI_Model {
/* -------------- Constructor ------------- */

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    function get_ptla_by_spm_sp2d($tahun,$kode_unit_subunit='',$jenis='',$bulan=""){

        $rba = $this->load->database('rba', TRUE);

        $where = '' ;

        $where_bulan = '';

        if($bulan != ''){
            $where_bulan = "AND spm_cair.bulan = '{$bulan}'" ;
        }
        if($kode_unit_subunit != '99'){
            $where .= "AND spm_cair.kode_unit_subunit LIKE '{$kode_unit_subunit}%' " ;
        }

        if($jenis != '00'){
            $where .= "AND spm_cair.jenis_trx = '{$jenis}' " ;
        }

            $query2 = "SELECT spm_cair.id_trx_urut_spm_cair ,spm_cair.tgl_proses,spm_cair.kode_unit_subunit,spm_cair.str_nomor_trx_spm,spm_cair.nominal,spm_cair.jenis_trx,ptla.proses,ptla.tolaktgl,ptla.tolakuser,ptla.tolakket,ptla.tolakstatus,
                        COALESCE(SUM(pajak.rupiah_pajak), 0 ) as jumlah_pajak,
                        COALESCE(spmls.pajak, 0 ) as jumlah_pajakls,
                        COALESCE((spm_cair.nominal - COALESCE(SUM(pajak.rupiah_pajak), 0 )), 0 ) as netto_cair,
                        COALESCE((spmls.total_sumberdana - COALESCE(spmls.pajak, 0 )), 0 ) as netto_cairls,
                        COALESCE(
                                (SELECT SUM(c.rupiah_pajak)
                                FROM rsa_kuitansi as a
                                JOIN rsa_kuitansi_detail as b
                                    ON a.id_kuitansi = b.id_kuitansi 
                                JOIN rsa_kuitansi_detail_pajak as c
                                    ON b.id_kuitansi_detail = c.id_kuitansi_detail 
                                WHERE c.jenis_pajak = 'lainnya' 
                                AND a.str_nomor_trx_spm = spm_cair.str_nomor_trx_spm
                                GROUP BY a.str_nomor_trx_spm), 0 ) as potongan_lainnya,
                        COALESCE(SUM(spmls.potongan), 0 ) as potongan_lainnyals
                        FROM trx_urut_spm_cair as spm_cair
                        LEFT JOIN rsa_kuitansi as kuitansi
                            ON spm_cair.str_nomor_trx_spm = kuitansi.str_nomor_trx_spm
                        LEFT JOIN rsa_kuitansi_detail as kuitansi_detail
                            ON kuitansi.id_kuitansi = kuitansi_detail.id_kuitansi
                        LEFT JOIN rsa_kuitansi_detail_pajak as pajak
                            ON pajak.id_kuitansi_detail = kuitansi_detail.id_kuitansi_detail
                        LEFT JOIN kepeg_tr_spmls as spmls
                            ON spmls.nomor = spm_cair.str_nomor_trx_spm
                        LEFT JOIN (SELECT DISTINCT ptl.str_nomor_trx_spm,ptl.proses,ptl.bulan_ajukan,ptl.tolaktgl,ptl.tolakuser,ptl.tolakket,ptl.tolakstatus FROM trx_urut_potongan_lainnya as ptl) as ptla
                            ON ptla.str_nomor_trx_spm = spm_cair.str_nomor_trx_spm 
                        WHERE spm_cair.tahun = '{$tahun}'
                        {$where}{$where_bulan}
                        AND (ptla.proses IS NULL OR ptla.proses = 0)
                        AND spm_cair.str_nomor_trx_spm IN (SELECT DISTINCT str_nomor_trx_spm FROM trx_urut_spm_sp2d)
                        GROUP BY spm_cair.str_nomor_trx_spm
                            HAVING potongan_lainnyals > 0
                            OR potongan_lainnya > 0
                        ";

            $query2 = $this->db->query($query2);
            $result = $query2->result();

            foreach ($result as $key => $res) {
                if ($res->jenis_trx != 'LSP') {
                    $result[$key]->pajak = $res->jumlah_pajak;
                    $result[$key]->netto = $res->netto_cair;
                    $result[$key]->potongan_lainnya = $res->potongan_lainnya;
                }else{
                    $result[$key]->pajak = $res->jumlah_pajakls;
                    $result[$key]->netto = $res->netto_cairls;
                    $result[$key]->potongan_lainnya = $res->potongan_lainnyals;
                }
            }
            
            // vdebug($query2);
        return $result;

    }

    function get_daftar_ptla($tahun,$kode_unit_subunit='',$jenis='',$bulan=""){

        $rba = $this->load->database('rba', TRUE);

        $where = '' ;
        $where_bulan = '';
        $where_level = '';

        if($kode_unit_subunit != '99'){
            $where .= "AND spm_cair.kode_unit_subunit LIKE '{$kode_unit_subunit}%' " ;
        }

        if($jenis != '00'){
            $where .= "AND spm_cair.jenis_trx = '{$jenis}' " ;
        }

        if($bulan != ''){
            $where_bulan = "AND ptla.bulan_ajukan = '{$bulan}'" ;
        }

        if($this->check_session->get_level()==3){
            $where_level = "AND ptla.proses >= 1" ;
        }elseif($this->check_session->get_level()==11){
            $where_level = "AND ptla.proses >= 2" ;
        }elseif($this->check_session->get_level()==13){
            $where_level = "AND ptla.proses >= 0" ;
        }

            $query2 = "SELECT spm_cair.id_trx_urut_spm_cair ,spm_cair.tgl_proses,spm_cair.kode_unit_subunit,spm_cair.str_nomor_trx_spm,spm_cair.nominal,spm_cair.jenis_trx,ptla.proses,ptla.tolaktgl,ptla.tolakuser,ptla.tolakket,ptla.tolakstatus,
                        COALESCE(SUM(pajak.rupiah_pajak), 0 ) as jumlah_pajak,
                        COALESCE(spmls.pajak, 0 ) as jumlah_pajakls,
                        COALESCE((spm_cair.nominal - COALESCE(SUM(pajak.rupiah_pajak), 0 )), 0 ) as netto_cair,
                        COALESCE((spmls.total_sumberdana - COALESCE(spmls.pajak, 0 )), 0 ) as netto_cairls,
                        COALESCE(
                                (SELECT SUM(c.rupiah_pajak)
                                FROM rsa_kuitansi as a
                                JOIN rsa_kuitansi_detail as b
                                    ON a.id_kuitansi = b.id_kuitansi 
                                JOIN rsa_kuitansi_detail_pajak as c
                                    ON b.id_kuitansi_detail = c.id_kuitansi_detail 
                                WHERE c.jenis_pajak = 'lainnya' 
                                AND a.str_nomor_trx_spm = spm_cair.str_nomor_trx_spm
                                GROUP BY a.str_nomor_trx_spm), 0 ) as potongan_lainnya,
                        COALESCE(SUM(spmls.potongan), 0 ) as potongan_lainnyals
                        FROM trx_urut_spm_cair as spm_cair
                        LEFT JOIN rsa_kuitansi as kuitansi
                            ON spm_cair.str_nomor_trx_spm = kuitansi.str_nomor_trx_spm
                        LEFT JOIN rsa_kuitansi_detail as kuitansi_detail
                            ON kuitansi.id_kuitansi = kuitansi_detail.id_kuitansi
                        LEFT JOIN rsa_kuitansi_detail_pajak as pajak
                            ON pajak.id_kuitansi_detail = kuitansi_detail.id_kuitansi_detail
                        LEFT JOIN kepeg_tr_spmls as spmls
                            ON spmls.nomor = spm_cair.str_nomor_trx_spm
                        LEFT JOIN (SELECT DISTINCT ptl.str_nomor_trx_spm,ptl.proses,ptl.bulan_ajukan,ptl.tolaktgl,ptl.tolakuser,ptl.tolakket,ptl.tolakstatus FROM trx_urut_potongan_lainnya as ptl) as ptla
                            ON ptla.str_nomor_trx_spm = spm_cair.str_nomor_trx_spm
                        WHERE spm_cair.tahun = '{$tahun}'
                        {$where}{$where_bulan}{$where_level}
                        AND spm_cair.str_nomor_trx_spm IN (SELECT DISTINCT str_nomor_trx_spm FROM trx_urut_spm_sp2d)
                        GROUP BY spm_cair.str_nomor_trx_spm
                            HAVING potongan_lainnyals > 0
                            OR potongan_lainnya > 0
                        ";

            $query2 = $this->db->query($query2);
            $result = $query2->result();

            foreach ($result as $key => $res) {
                if ($res->jenis_trx != 'LSP') {
                    $result[$key]->pajak = $res->jumlah_pajak;
                    $result[$key]->netto = $res->netto_cair;
                    $result[$key]->potongan_lainnya = $res->potongan_lainnya;
                }else{
                    $result[$key]->pajak = $res->jumlah_pajakls;
                    $result[$key]->netto = $res->netto_cairls;
                    $result[$key]->potongan_lainnya = $res->potongan_lainnyals;
                }
            }
            // vdebug($result);

        return $result;

    }

    function insert_ptla($data){
        $insert = $this->db->insert('trx_urut_potongan_lainnya', $data);
        if ($insert) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function get_data_ptla($spm){
        $query = "SELECT a.* , b.nama_unit,c.nama_subunit
        FROM trx_urut_potongan_lainnya as a
        LEFT JOIN rba_2018.unit as b
        ON b.kode_unit = substr(a.kode_unit_subunit,1,2)
        LEFT JOIN rba_2018.subunit as c
        ON c.kode_subunit = a.kode_unit_subunit
        WHERE str_nomor_trx_spm = '{$spm}'
        ";
        $query = $this->db->query($query);
        $result = $query->result();

        $jml_ptla = 0;
        foreach ($result as $res) {
            $new_array = array(
                'str_nomor_trx_spm' => $res->str_nomor_trx_spm,
                'kode_unit_subunit' => $res->kode_unit_subunit,
                'jenis_trx'         => $res->jenis_trx,
                'nmbendahara'       => $res->nmbendahara,
                'nipbendahara'      => $res->nipbendahara,
                'tglbendahara'      => $res->tglbendahara,
                'nmverifikator'     => $res->nmverifikator,
                'nipverifikator'    => $res->nipverifikator,
                'tglverifikator'    => $res->tglverifikator,
                'nmkbuu'            => $res->nmkbuu,
                'nipkbuu'           => $res->nipkbuu,
                'tglkbuu'           => $res->tglkbuu,
                'nama_unit'         => $res->nama_unit,
                'nama_subunit'      => $res->nama_unit,
                'proses'            => $res->proses,
            );
            $jml_ptla = $jml_ptla + $res->nominal;
        }
        $new_array['jml_ptla'] = $jml_ptla;
        $new_array['terbilang'] = $this->convertion->terbilang((int)$jml_ptla);

        $new_array['data'] = $result;
        $new_array = (object) $new_array;

        // vdebug($new_array);
        if ($query->num_rows() > 0) {
            return $new_array;
        }else{
            return 0;
        }
    }

    function get_riwayat_sp2d_retur($no_spm){
        $query = "SELECT SUBSTR(str_nomor_trx_retur ,10,5) AS jenis_trx,
                        str_nomor_trx_retur AS no_trx,
                        tgl_retur AS tgl_trx,
                        tgl_proses AS tgl_proses,
                        bank AS bank,
                        nominal AS nominal,
                        keterangan AS keterangan
                    FROM trx_urut_sp2d_retur 
                    WHERE str_nomor_trx_spm = '{$no_spm}'
                        UNION
                    SELECT SUBSTR(str_nomor_trx_sp2d,10,4) AS jenis_trx,
                        str_nomor_trx_sp2d AS no_trx,
                        tgl_sp2d AS tgl_trx,
                        tgl_proses AS tgl_proses,
                        bank AS bank,
                        nominal AS nominal,
                        keterangan AS keterangan
                    FROM trx_urut_potongan_lainnya 
                    WHERE str_nomor_trx_spm = '{$no_spm}'
                    Order by tgl_proses
                ";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return array();
        }
    }

    function get_akun_belanja(){
        $rba   = $this->load->database('rba', TRUE);
        $query = "SELECT DISTINCT(rsa_2018.kas_undip.kd_akun_kas) as kode_akun, rba_2018.akun_belanja.nama_akun
                    From rsa_2018.kas_undip
                    JOIN rba_2018.akun_belanja
                        ON rsa_2018.kas_undip.kd_akun_kas = rba_2018.akun_belanja.kode_akun
                    WHERE rba_2018.akun_belanja.sumber_dana = 'SELAIN-APBN'
                ";
        $query = $rba->query($query);

        if($query->num_rows()>0){
            return $query->result();
        }else{
            return array();
        }
    }

    function get_sp2d_by_id($id){
        $query = "SELECT * FROM trx_urut_potongan_lainnya WHERE id_trx_urut_potongan_lainnya = '{$id}'";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return 0;
        }
    }

    public function update_sp2d($data,$id){
        $this->db->where('id_trx_urut_potongan_lainnya', $id);
        $query = $this->db->update('trx_urut_potongan_lainnya', $data);
        return ($query) ? true : false;
    }

    function get_nominal_ptla($no_spm,$jenis,$kode_unit_subunit){
        $query = "SELECT COALESCE(SUM(nominal), 0 ) as nominal_sudah_ptla
                    FROM trx_urut_potongan_lainnya
                    WHERE str_nomor_trx_spm = '{$no_spm}' 
                        AND jenis_trx = '{$jenis}' 
                        AND kode_unit_subunit = '{$kode_unit_subunit}'
                        ";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return 0;
        }
    }

    function get_ptla_per_spm($unit){

        $where_unit = '';
        if ($unit != 99) {
            $where_unit = 'WHERE a.kode_unit_subunit = '.$unit;
        }

        $query = "
                    SELECT a.str_nomor_trx_spm AS no_spm,
                        a.jenis_trx AS jenis_trx,
                        a.tgl_proses AS tgl_proses,
                        a.jenis_potongan AS jenis_potongan,
                        a.nominal AS nominal,
                        a.keterangan AS keterangan,
                        b.alias AS nama_unit,
                        c.nama_subunit AS nama_subunit
                    FROM trx_urut_potongan_lainnya as a
                    LEFT JOIN rba_2018.unit as b
                      ON b.kode_unit = SUBSTR(a.kode_unit_subunit,1,2)
                    LEFT JOIN rba_2018.subunit as c
                      ON c.kode_subunit = SUBSTR(a.kode_unit_subunit,1,4)
                    {$where_unit}
                    Order by tgl_proses
                ";
        $query = $this->db->query($query);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            // vdebug($result);
            return $result;
        }else{
            return array();
        }
    }

    function get_potongan_lainnya($no_spm=""){
        $query = "
                    SELECT potongan as potongan_lainnya
                    FROM kepeg_tr_spmls
                    WHERE nomor = '{$no_spm}'
                    UNION
                    SELECT SUM(rsa_kuitansi_detail_pajak.rupiah_pajak) as potongan_lainnya
                    FROM rsa_kuitansi 
                    JOIN rsa_kuitansi_detail 
                        ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi 
                    JOIN rsa_kuitansi_detail_pajak 
                        ON rsa_kuitansi_detail.id_kuitansi_detail = rsa_kuitansi_detail_pajak.id_kuitansi_detail 
                    WHERE rsa_kuitansi_detail_pajak.jenis_pajak = 'lainnya' 
                    AND rsa_kuitansi.str_nomor_trx_spm = '{$no_spm}'
                    GROUP BY rsa_kuitansi.str_nomor_trx_spm
                ";
        $query = $this->db->query($query);
        $result = $query->row();
        if ($query->num_rows() > 0) {
            return $result->potongan_lainnya;
        }else{
            return 0;
        }
    }

    function get_no_spm_ptla_per_bulan($bulan='',$unit){
         if($bulan == '1'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses) BETWEEN '2018-01-01 00:00:00' AND '2018-01-31 23:59:59' " ;
            }elseif($bulan == '2'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-02-01 00:00:00' AND '2018-02-28 23:59:59' " ;
            }elseif($bulan == '3'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-03-01 00:00:00' AND '2018-03-31 23:59:59' " ;
            }elseif($bulan == '4'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-04-01 00:00:00' AND '2018-04-30 23:59:59' " ;
            }elseif($bulan == '5'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-05-01 00:00:00' AND '2018-05-31 23:59:59' " ;
            }elseif($bulan == '6'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-06-01 00:00:00' AND '2018-06-30 23:59:59' " ;
            }elseif($bulan == '7'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-07-01 00:00:00' AND '2018-07-31 23:59:59' " ;
            }elseif($bulan == '8'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-08-01 00:00:00' AND '2018-08-31 23:59:59' " ;
            }elseif($bulan == '9'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-09-01 00:00:00' AND '2018-09-30 23:59:59' " ;
            }elseif($bulan == '10'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-10-01 00:00:00' AND '2018-10-31 23:59:59' " ;
            }elseif($bulan == '11'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-11-01 00:00:00' AND '2018-11-30 23:59:59' " ;
            }elseif($bulan == '12'){
                $where_date_ptla = "WHERE DATE(a.tgl_proses)  BETWEEN '2018-12-01 00:00:00' AND '2018-12-31 23:59:59' "  ;
            }elseif($bulan == '13'){
                $nw = date('Y-m-d H:i:s');
                $where_date_ptla = "WHERE a.tgl_proses  BETWEEN '2018-01-01 00:00:00' AND '{$nw}' " ;
            }else{
                $where_date_ptla = '';
            }

            $where_unit = '';
            if ($unit != 99) {
                $where_unit = 'AND a.kode_unit_subunit = '.$unit;
            }

            $query = "
                    SELECT a.str_nomor_trx_spm AS no_spm,
                        a.tgl_proses AS tgl_proses
                    FROM trx_urut_potongan_lainnya as a
                    LEFT JOIN rba_2018.unit as b
                      ON b.kode_unit = SUBSTR(a.kode_unit_subunit,1,2)
                    LEFT JOIN rba_2018.subunit as c
                      ON c.kode_subunit = SUBSTR(a.kode_unit_subunit,1,4)
                    {$where_date_ptla}{$where_unit}
                    Order by tgl_proses
                ";
        $query = $this->db->query($query);
        $result = $query->result();

        foreach ($result as $key => $value) {
            $arr_no_spm[$value->no_spm] = $value->no_spm;
        }

        if ($query->num_rows() > 0) {
            return (object) $arr_no_spm;
        }else{
            return array();
        }

    }

    function get_akun_belanja_option($no_spm,$jenis){
        if ($jenis == 'LSP') {
                $query2 ="SELECT detail_belanja
                            FROM kepeg_tr_spmls
                            WHERE nomor = '{$no_spm}'
                            ";
                $query2 = $this->db->query($query2);
                $result2 = $query2->row();

                $pecah = explode(',',$result2->detail_belanja);
                // vdebug($pecah);

                foreach ($pecah as $value) {
                    $query = " SELECT a.kode_usulan_belanja, a.kode_akun_tambah, {$value} as full_kode_usulan_belanja,d.nama_akun, a.deskripsi, c.jenis_trx as jenis
                            FROM rsa_detail_belanja_ as a
                            JOIN kepeg_tr_spmls as b
                                ON a.kode_usulan_belanja = SUBSTR('{$value}',1,24) AND a.kode_akun_tambah = SUBSTR('{$value}',25,27)
                            JOIN trx_urut_spm_cair as c
                                ON c.str_nomor_trx_spm = b.nomor
                            JOIN rba_2018.akun_belanja as d
                                ON d.kode_akun = SUBSTR('{$value}',19,6)
                            WHERE b.nomor = '{$no_spm}'
                            ";
                    
                    $query = $this->db->query($query);
                    $result[] = $query->row();
                }
                // $result = (object) $result;
        }else{
            $query ="SELECT a.kode_usulan_belanja, a.kode_akun_tambah, SUBSTR(a.kode_usulan_belanja,19,6) as kode_akun,e.nama_akun, a.deskripsi, d.jenis_trx as jenis
                        FROM rsa_detail_belanja_ as a
                        JOIN rsa_kuitansi_detail as b
                            ON a.kode_usulan_belanja = b.kode_usulan_belanja AND a.kode_akun_tambah = b.kode_akun_tambah
                        JOIN rsa_kuitansi as c
                            ON c.id_kuitansi = b.id_kuitansi
                        JOIN trx_urut_spm_cair as d
                            ON d.str_nomor_trx_spm = c.str_nomor_trx_spm
                        JOIN rba_2018.akun_belanja as e
                            ON e.kode_akun = SUBSTR(a.kode_usulan_belanja,19,6)
                        WHERE c.str_nomor_trx_spm = '{$spm}'
                        ";
            $query = $this->db->query($query);
            $result = $query->result();
        }
        // vdebug($result);

        if ($query->num_rows() > 0){
            return $result;
        }else{
            return array();
        }
    }

    function get_bendahara($unit){
        $query = "SELECT nm_lengkap, nomor_induk
        FROM rsa_user
        WHERE kode_unit_subunit = '{$unit}' AND level = '13'
        ";
        $query = $this->db->query($query); 
        if ($query->num_rows() > 0){
            return $query->row(); 
        }else{
            return 0;
        }
    }

    function get_verifikator($unit){

        $unit = substr($unit,0,2);
        
        $query = "SELECT nm_lengkap, nomor_induk
        FROM rsa_user as a
        JOIN rsa_verifikator_unit as b
        ON a.id = b.id_user_verifikator
        WHERE b.kode_unit_subunit = '{$unit}' AND a.level = '3'
        ";
        $query = $this->db->query($query); 
        if ($query->num_rows() > 0){
            return $query->row(); 
        }else{
            return 0;
        }
    }

    function get_kuasabuu(){
        $query = "SELECT nm_lengkap, nomor_induk
        FROM rsa_user
        WHERE level = '11'
        ";
        $query = $this->db->query($query); 
        if ($query->num_rows() > 0){
            return $query->row(); 
        }else{
            return 0;
        }
    }

    function update_ptla_proses($no_spm,$data_update){
        $this->db->where('str_nomor_trx_spm', $no_spm);
        $query = $this->db->update('trx_urut_potongan_lainnya', $data_update);
        return ($query) ? true : false;
    }

    function daftar_unit_verifikator($username){
        $query = "SELECT d.kode_subunit as kode_unit , d.nama_subunit as nama_unit,
                (SELECT COUNT(DISTINCT str_nomor_trx_spm)
            FROM trx_urut_potongan_lainnya 
            WHERE kode_unit_subunit = d.kode_subunit AND proses = '1') AS jumlah
        FROM rba_2018.unit as a
        JOIN rba_2018.subunit as d
        ON substr(d.kode_subunit,1,2) = a.kode_unit
        JOIN rsa_verifikator_unit as b
        ON b.kode_unit_subunit = a.kode_unit
        JOIN rsa_user as c
        ON b.id_user_verifikator = c.id
        WHERE c.username = '{$username}' AND (a.kode_unit = '14' OR a.kode_unit = '15' OR a.kode_unit = '16' OR a.kode_unit = '17')
        UNION
        SELECT a.kode_unit , a.nama_unit, 
            (SELECT COUNT(DISTINCT str_nomor_trx_spm)
            FROM trx_urut_potongan_lainnya 
            WHERE kode_unit_subunit = a.kode_unit AND proses = '1') AS jumlah
        FROM rba_2018.unit as a
        JOIN rsa_verifikator_unit as b
        ON b.kode_unit_subunit = a.kode_unit
        JOIN rsa_user as c
        ON b.id_user_verifikator = c.id
        WHERE c.username = '{$username}'
        ORDER BY kode_unit
        ";
        $query = $this->db->query($query);
        // vdebug($query->result());
        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return array();
        }
    }

    function daftar_unit_kbuu(){
        $query = "SELECT d.kode_subunit as kode_unit , d.nama_subunit as nama_unit, 
            (SELECT COUNT(DISTINCT str_nomor_trx_spm)
            FROM trx_urut_potongan_lainnya 
            WHERE kode_unit_subunit = d.kode_subunit AND proses = '2') AS jumlah
        FROM rba_2018.unit as a
        JOIN rba_2018.subunit as d
        ON substr(d.kode_subunit,1,2) = a.kode_unit
        WHERE  a.kode_unit = '14' OR a.kode_unit = '15' OR a.kode_unit = '16' OR a.kode_unit = '17'
        UNION
        SELECT a.kode_unit , a.nama_unit, 
            (SELECT COUNT(DISTINCT str_nomor_trx_spm)
            FROM trx_urut_potongan_lainnya 
            WHERE kode_unit_subunit = a.kode_unit AND proses = '2') AS jumlah
        FROM rba_2018.unit as a
        ORDER BY kode_unit
        ";
        $query = $this->db->query($query);
        // vdebug($query->result());
        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return array();
        }
    }

    function update_ptla_tolak($no_spm,$data_update){
        $this->db->where('str_nomor_trx_spm', $no_spm);
        $query = $this->db->update('trx_urut_potongan_lainnya', $data_update);
        return ($query) ? true : false;
    }

    function get_notif($level="",$username="",$unit=""){
        if ($level == 11) {
        $query = "SELECT COUNT(DISTINCT str_nomor_trx_spm) as jumlah
            FROM trx_urut_potongan_lainnya 
            WHERE proses = 2";
        } elseif($level == 3){
            $query = "SELECT COUNT(DISTINCT str_nomor_trx_spm) as jumlah
                FROM trx_urut_potongan_lainnya as a
                JOIN rsa_verifikator_unit as b
                    ON SUBSTR(b.kode_unit_subunit,1,2) = SUBSTR(a.kode_unit_subunit,1,2)
                JOIN rsa_user as c
                    ON b.id_user_verifikator = c.id
                WHERE c.username = '{$username}' AND a.proses = 1";
            // vdebug($query);
        }

        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row()->jumlah;
        }else{
            return 0;
        }

    }

    public function update_ptla_edit($id,$data){
        $this->db->where('id_trx_urut_potongan_lainnya', $id);
        $query = $this->db->update('trx_urut_potongan_lainnya', $data);
        return ($query) ? true : false;
    }
}
