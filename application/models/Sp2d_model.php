    <?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sp2d_model extends CI_Model {
/* -------------- Constructor ------------- */

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    function get_spm_cair($tahun,$kode_unit_subunit='',$jenis='',$bulan="",$yang_butuh=""){

        $rba = $this->load->database('rba', TRUE);

        $where = '' ;

        $where_bulan = '';
        $where_tambah_sp2d = '';

        if($bulan != ''){
            $where_bulan = "AND spm_cair.bulan = '{$bulan}'" ;
        }
        if($kode_unit_subunit != '99'){
            $where .= "AND spm_cair.kode_unit_subunit LIKE '{$kode_unit_subunit}%' " ;
        }

        if($jenis != '00'){
            $where .= "AND spm_cair.jenis_trx = '{$jenis}' " ;
        }

        if($yang_butuh == 'tambah_retur'){
            $where .= "AND spm_cair.nominal_sudah_sp2d > 0 " ;
        }elseif($yang_butuh == 'sp2d_100'){
            $where_tambah_sp2d = "HAVING spm_cair.nominal_sudah_sp2d = (spm_cair.nominal - potongan_lainnyals) OR spm_cair.nominal_sudah_sp2d = (spm_cair.nominal - potongan_lainnya)";
        }else{
            $where_tambah_sp2d = "HAVING spm_cair.nominal_sudah_sp2d < (spm_cair.nominal - potongan_lainnyals) AND spm_cair.nominal_sudah_sp2d < (spm_cair.nominal - potongan_lainnya)";
        }

            $query2 = "SELECT spm_cair.id_trx_urut_spm_cair,spm_cair.no_urut,spm_cair.nominal_sudah_sp2d,spm_cair.tgl_proses,spm_cair.kode_unit_subunit,spm_cair.str_nomor_trx_spm,spm_cair.nominal,spm_cair.jenis_trx,
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
                        WHERE spm_cair.tahun = '{$tahun}'
                        {$where}{$where_bulan}
                        GROUP BY spm_cair.str_nomor_trx_spm
                            {$where_tambah_sp2d}
                        ORDER BY spm_cair.no_urut
                        ";

            $query2 = $this->db->query($query2);
            $result = $query2->result();

            // vdebug($result);

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

    function insert_sp2d($data){
        $insert = $this->db->insert('trx_urut_spm_sp2d', $data);
        if ($insert) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function insert_retur($data){
        $insert = $this->db->insert('trx_urut_sp2d_retur', $data);
        $insert_id = $this->db->insert_id();

        if ($insert) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function get_all_sp2d(){


        $query = "SELECT a.id_trx_urut_spm_sp2d,a.str_nomor_trx_sp2d,a.str_nomor_trx_spm,a.tgl_sp2d,a.nominal as nominal_sp2d,b.nominal as nominal_spm_cair,b.nominal_sudah_sp2d,a.keterangan,a.bank,b.jenis_trx, nama_unit, nama_subunit, a.jenis_sp2d
                  FROM trx_urut_spm_sp2d as a
                  LEFT JOIN trx_urut_spm_cair as b
                    ON a.str_nomor_trx_spm = b.str_nomor_trx_spm AND a.kode_unit_subunit = b.kode_unit_subunit
                  LEFT JOIN rba_2018.unit as c
                    ON c.kode_unit = SUBSTR(a.kode_unit_subunit,1,2)
                  LEFT JOIN rba_2018.subunit as d
                    ON d.kode_subunit = SUBSTR(a.kode_unit_subunit,1,4)
                  ORDER BY SUBSTR(a.str_nomor_trx_sp2d, 1,4) ASC
                  ";
                  // -- ORDER BY SUBSTR(a.str_nomor_trx_spm, 6,3) ASC,b.bulan ASC, SUBSTR(a.str_nomor_trx_spm, 1,4) ASC, a.tgl_proses ASC;

        $query = $this->db->query($query);
        return $query->result();
    }

    function get_all_retur(){
        $query = "SELECT a.id_trx_urut_sp2d_retur,a.str_nomor_trx_retur,a.str_nomor_trx_spm,a.tgl_retur,a.nominal as nominal_retur,b.nominal as nominal_spm_cair,b.nominal_sudah_sp2d,a.keterangan,a.bank,b.jenis_trx,c.id_trx_urut_spm_sp2d
                  FROM trx_urut_sp2d_retur as a
                  LEFT JOIN trx_urut_spm_cair as b
                  ON a.str_nomor_trx_spm = b.str_nomor_trx_spm AND a.kode_unit_subunit = b.kode_unit_subunit
                  LEFT JOIN trx_urut_spm_sp2d as c
                  ON c.id_retur = a.id_trx_urut_sp2d_retur
                  ORDER BY SUBSTR(a.str_nomor_trx_retur, 1,4) ASC
                  ;
                 -- ORDER BY SUBSTR(a.str_nomor_trx_spm, 6,3) ASC,b.bulan ASC, SUBSTR(a.str_nomor_trx_spm, 1,4) ASC, a.tgl_retur ASC";

        $query = $this->db->query($query);
        $result = $query->result();
        foreach ($result as $key => $value) {
            if ($value->id_trx_urut_spm_sp2d != null) {
                $result[$key]->data_sp2d = $this->get_sp2d_by_id($value->id_trx_urut_spm_sp2d);
            }
        }
            // vdebug($result[$key]->data_sp2d->keterangan);
        return $result;
    }

    function get_new_no_sp2d($no_spm){
        // $query = "SELECT SUBSTR(str_nomor_trx_sp2d,1,4) as no_urut_sp2d FROM trx_urut_spm_sp2d WHERE SUBSTR(str_nomor_trx_sp2d,6,3) = SUBSTR('{$no_spm}',6,3) ORDER by SUBSTR(str_nomor_trx_sp2d,1,4) DESC limit 1";

        $query = "SELECT SUBSTR(str_nomor_trx_sp2d,1,4) as no_urut_sp2d FROM trx_urut_spm_sp2d ORDER by SUBSTR(str_nomor_trx_sp2d,1,4) DESC limit 1";

        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row()->no_urut_sp2d;
        }else{
            return 0;
        }
    }

    function get_new_no_retur($no_spm){
        $query = "SELECT SUBSTR(str_nomor_trx_retur,1,4) as no_urut_retur FROM trx_urut_sp2d_retur WHERE SUBSTR(str_nomor_trx_retur,6,3) = SUBSTR('{$no_spm}',6,3) ORDER by SUBSTR(str_nomor_trx_retur,1,4) DESC limit 1";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row()->no_urut_retur;
        }else{
            return 0;
        }
    }

    function get_riwayat_sp2d_retur($no_spm){
        $query = "SELECT a.str_nomor_trx_spm AS no_spm,
                        SUBSTR(a.str_nomor_trx_retur ,10,5) AS jenis_trx,
                        a.str_nomor_trx_retur AS no_trx,
                        a.tgl_retur AS tgl_trx,
                        a.tgl_proses AS tgl_proses,
                        a.jenis_retur AS jenis_sp2d_retur,
                        a.bank AS bank,
                        (-1 * a.nominal) AS nominal,
                        a.jenis_retur AS jenis_sp2d,
                        a.keterangan AS keterangan,
                        b.alias AS nama_unit,
                        c.nama_subunit AS nama_subunit
                    FROM trx_urut_sp2d_retur as a
                    LEFT JOIN rba_2018.unit as b
                      ON b.kode_unit = SUBSTR(a.kode_unit_subunit,1,2)
                    LEFT JOIN rba_2018.subunit as c
                      ON c.kode_subunit = SUBSTR(a.kode_unit_subunit,1,4)
                    WHERE a.str_nomor_trx_spm = '{$no_spm}'
                        UNION
                    SELECT d.str_nomor_trx_spm AS no_spm,
                        SUBSTR(d.str_nomor_trx_sp2d,10,4) AS jenis_trx,
                        d.str_nomor_trx_sp2d AS no_trx,
                        d.tgl_sp2d AS tgl_trx,
                        d.tgl_proses AS tgl_proses,
                        d.jenis_sp2d AS jenis_sp2d_retur,
                        d.bank AS bank,
                        d.nominal AS nominal,
                        d.jenis_sp2d AS jenis_sp2d,
                        d.keterangan AS keterangan,
                        e.alias AS nama_unit,
                        f.nama_subunit AS nama_subunit
                    FROM trx_urut_spm_sp2d as d
                    LEFT JOIN rba_2018.unit as e
                      ON e.kode_unit = SUBSTR(d.kode_unit_subunit,1,2)
                    LEFT JOIN rba_2018.subunit as f
                      ON f.kode_subunit = SUBSTR(d.kode_unit_subunit,1,4)
                    WHERE d.str_nomor_trx_spm = '{$no_spm}'
                    Order by tgl_proses
                ";
        $query = $this->db->query($query);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            // vdebug($result);
            return $result;
        }else{
            return 0;
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
        $query = "SELECT * FROM trx_urut_spm_sp2d WHERE id_trx_urut_spm_sp2d = '{$id}'";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return 0;
        }
    }
    function get_retur_by_id($id){
        $query = "SELECT * FROM trx_urut_sp2d_retur WHERE id_trx_urut_sp2d_retur = '{$id}'";
        $query = $this->db->query($query);
        // vdebug($query->row());
        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return 0;
        }

    }

    public function update_sp2d($data,$id){
        $this->db->where('id_trx_urut_spm_sp2d', $id);
        $query = $this->db->update('trx_urut_spm_sp2d', $data);
        return ($query) ? true : false;
    }
    public function update_retur($data,$id){
        $this->db->where('id_trx_urut_sp2d_retur', $id);
        $query = $this->db->update('trx_urut_sp2d_retur', $data);
        return ($query) ? true : false;
    }

    function get_nominal_sp2d_retur($no_spm){
        $query = "  SELECT SUM(nominal) as sum_sp2d_retur FROM (
                        SELECT str_nomor_trx_spm AS no_spm,
                               (-1 * nominal) AS nominal
                        FROM trx_urut_sp2d_retur 
                        WHERE str_nomor_trx_spm = '{$no_spm}'
                            UNION
                        SELECT str_nomor_trx_spm AS no_spm,
                               nominal AS nominal
                        FROM trx_urut_spm_sp2d 
                        WHERE str_nomor_trx_spm = '{$no_spm}'
                    ) as x
                    GROUP BY no_spm
                    ";
        $query = $this->db->query($query);
        $result = $query->row();
        if ($query->num_rows() > 0) {
            return $result->sum_sp2d_retur;
        }else{
            return array();
        }
    }

    function get_sp2d_per_spm(){
        $query = "SELECT a.str_nomor_trx_spm AS no_spm,
                        SUBSTR(a.str_nomor_trx_retur ,10,5) AS jenis_trx,
                        a.str_nomor_trx_retur AS no_trx,
                        a.tgl_retur AS tgl_trx,
                        a.tgl_proses AS tgl_proses,
                        a.jenis_retur AS jenis_sp2d_retur,
                        a.bank AS bank,
                        (-1 * a.nominal) AS nominal,
                        COALESCE(a.jenis_retur,'Retur') AS jenis_sp2d,
                        a.keterangan AS keterangan,
                        b.alias AS nama_unit,
                        c.nama_subunit AS nama_subunit
                    FROM trx_urut_sp2d_retur as a
                    LEFT JOIN rba_2018.unit as b
                      ON b.kode_unit = SUBSTR(a.kode_unit_subunit,1,2)
                    LEFT JOIN rba_2018.subunit as c
                      ON c.kode_subunit = SUBSTR(a.kode_unit_subunit,1,4)
                        UNION
                    SELECT d.str_nomor_trx_spm AS no_spm,
                        SUBSTR(d.str_nomor_trx_sp2d,10,4) AS jenis_trx,
                        d.str_nomor_trx_sp2d AS no_trx,
                        d.tgl_sp2d AS tgl_trx,
                        d.tgl_proses AS tgl_proses,
                        d.jenis_sp2d AS jenis_sp2d_retur,
                        d.bank AS bank,
                        d.nominal AS nominal,
                        d.jenis_sp2d AS jenis_sp2d,
                        d.keterangan AS keterangan,
                        e.alias AS nama_unit,
                        f.nama_subunit AS nama_subunit
                    FROM trx_urut_spm_sp2d as d
                    LEFT JOIN rba_2018.unit as e
                      ON e.kode_unit = SUBSTR(d.kode_unit_subunit,1,2)
                    LEFT JOIN rba_2018.subunit as f
                      ON f.kode_subunit = SUBSTR(d.kode_unit_subunit,1,4)
                    
                    Order by tgl_proses
                ";
        $query = $this->db->query($query);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            // vdebug($result);
            return $result;
        }else{
            return 0;
        }
    }

    function get_no_spm_sp2d_retur_per_bulan($bulan=''){
         if($bulan == '1'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d) BETWEEN '2018-01-01 00:00:00' AND '2018-01-31 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur) BETWEEN '2018-01-01 00:00:00' AND '2018-01-31 23:59:59' " ;
            }elseif($bulan == '2'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-02-01 00:00:00' AND '2018-02-28 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-02-01 00:00:00' AND '2018-02-28 23:59:59' " ;
            }elseif($bulan == '3'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-03-01 00:00:00' AND '2018-03-31 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-03-01 00:00:00' AND '2018-03-31 23:59:59' " ;
            }elseif($bulan == '4'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-04-01 00:00:00' AND '2018-04-30 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-04-01 00:00:00' AND '2018-04-30 23:59:59' " ;
            }elseif($bulan == '5'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-05-01 00:00:00' AND '2018-05-31 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-05-01 00:00:00' AND '2018-05-31 23:59:59' " ;
            }elseif($bulan == '6'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-06-01 00:00:00' AND '2018-06-30 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-06-01 00:00:00' AND '2018-06-30 23:59:59' " ;
            }elseif($bulan == '7'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-07-01 00:00:00' AND '2018-07-31 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-07-01 00:00:00' AND '2018-07-31 23:59:59' " ;
            }elseif($bulan == '8'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-08-01 00:00:00' AND '2018-08-31 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-08-01 00:00:00' AND '2018-08-31 23:59:59' " ;
            }elseif($bulan == '9'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-09-01 00:00:00' AND '2018-09-30 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-09-01 00:00:00' AND '2018-09-30 23:59:59' " ;
            }elseif($bulan == '10'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-10-01 00:00:00' AND '2018-10-31 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-10-01 00:00:00' AND '2018-10-31 23:59:59' " ;
            }elseif($bulan == '11'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-11-01 00:00:00' AND '2018-11-30 23:59:59' " ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-11-01 00:00:00' AND '2018-11-30 23:59:59' " ;
            }elseif($bulan == '12'){
                $where_date_sp2d = "WHERE DATE(d.tgl_sp2d)  BETWEEN '2018-12-01 00:00:00' AND '2018-12-31 23:59:59' "  ;
                $where_date_retur = "WHERE DATE(a.tgl_retur)  BETWEEN '2018-12-01 00:00:00' AND '2018-12-31 23:59:59' "  ;
            }elseif($bulan == '13'){
                $nw = date('Y-m-d H:i:s');
                $where_date_sp2d = "WHERE d.tgl_sp2d  BETWEEN '2018-01-01 00:00:00' AND '{$nw}' " ;
                $where_date_retur = "WHERE a.tgl_retur BETWEEN '2018-01-01 00:00:00' AND '{$nw}' " ;
            }else{
                $where_date_sp2d = '';
                $where_date_retur = '';
            }

            $query = "SELECT a.str_nomor_trx_spm AS no_spm,
                        a.tgl_proses AS tgl_proses
                    FROM trx_urut_sp2d_retur as a
                    LEFT JOIN rba_2018.unit as b
                      ON b.kode_unit = SUBSTR(a.kode_unit_subunit,1,2)
                    LEFT JOIN rba_2018.subunit as c
                      ON c.kode_subunit = SUBSTR(a.kode_unit_subunit,1,4)
                    $where_date_retur
                        UNION
                    SELECT d.str_nomor_trx_spm AS no_spm,
                        d.tgl_proses AS tgl_proses
                    FROM trx_urut_spm_sp2d as d
                    LEFT JOIN rba_2018.unit as e
                      ON e.kode_unit = SUBSTR(d.kode_unit_subunit,1,2)
                    LEFT JOIN rba_2018.subunit as f
                      ON f.kode_subunit = SUBSTR(d.kode_unit_subunit,1,4)
                    $where_date_sp2d
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
            return 0;
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

    function get_last_retur_id($no_spm){
        $query = "SELECT id_trx_urut_sp2d_retur
                    FROM trx_urut_sp2d_retur 
                    WHERE str_nomor_trx_spm = '{$no_spm}' 
                    ORDER BY id_trx_urut_sp2d_retur 
                    DESC LIMIT 1";

        $query = $this->db->query($query);
        $result = $query->row();
        if ($query->num_rows() > 0) {
            return $result->id_trx_urut_sp2d_retur;
        }else{
            return false;
        }

    }

    function cetak_daftar_sp2d($sp2d=""){
        $nomor = substr($sp2d,9,4);
        if ($nomor == 'SP2D') {
            $query = "SELECT a.str_nomor_trx_sp2d as nomor_trx, a.str_nomor_trx_spm, a.nominal, a.keterangan, a.bank,a.kode_unit_subunit, c.nama_unit, d.nama_subunit, a.jenis_sp2d,a.tgl_sp2d
                    FROM trx_urut_spm_sp2d as a
                    LEFT JOIN rba_2018.unit as c
                    ON SUBSTR(a.kode_unit_subunit, 1,2) = c.kode_unit
                    LEFT JOIN rba_2018.subunit as d
                    ON a.kode_unit_subunit = d.kode_subunit
                    WHERE a.str_nomor_trx_sp2d = '{$sp2d}'";
        }else{
         $query = "SELECT b.str_nomor_trx_retur as nomor_trx, b.str_nomor_trx_spm, b.nominal, b.keterangan, b.bank,b.kode_unit_subunit, e.nama_unit, f.nama_subunit, 'RETUR' as jenis_sp2d,b.tgl_retur as tgl_sp2d
                    FROM trx_urut_sp2d_retur as b
                    LEFT JOIN rba_2018.unit as e
                    ON SUBSTR(b.kode_unit_subunit, 1,2) = e.kode_unit
                    LEFT JOIN rba_2018.subunit as f
                    ON b.kode_unit_subunit = f.kode_subunit
                    WHERE b.str_nomor_trx_retur = '{$sp2d}'";
        }

        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return array();
        }
    }
}
