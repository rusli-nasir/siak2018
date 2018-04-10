<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kuitansi_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->db_laporan = $this->load->database('laporan',TRUE);
        $this->load->model('akuntansi/Unit_kerja_model', 'Unit_kerja_model');
        $this->load->model('akuntansi/Spm_model', 'Spm_model');
    }

    public function konversi_jenis_view($asal)
    {
        switch ($asal) {
            case 'LK':
                    return "LS-Kontrak";
                break;
            case 'LN':
                    return "LS-Non kontrak";
                break;            
            default:
                    return $asal;
                break;
        }
    }

    public function cari_kuitansi_dari_rsa($spm,$jumlah)
    {
        // print_r(explode('/', $spm));
        echo "<pre>";
        $tabel = null;
        $jenis = explode('/', $spm)[2];
        $array_jenis = $this->Spm_model->get_array_jenis_spm();
        if (isset($array_jenis[$jenis])){
            $tabel = $array_jenis[$jenis];
        }
        print_r($this->read_spm_rsa($spm,$jumlah));
    }

    public function read_sp2d_siak($unit,$jumlah,$jenis)
    {
        set_time_limit(900);
        // $array_kelompok = Array
        //     (
        //         ['UP'] => array (
        //                         'tabel' => 'trx_spm_up_data',
        //                     ),
        //         ['GUP'] => ,
        //         ['LS'] => ,
        //         ['LS3'] => ,
        //         ['TUP'] => ,
        //         ['TUP BBM'] => ,
        //         ['TUP NIHIL'] => ,
        //         ['LS4'] => ,
        //         ['LSPG'] => ,
        //         ['PUP'] => ,
        //     );

        $tabel_jenis = array(
            'UP' => 'up',
            'GUP' => 'gup',
            'LS' => 'rsa_kuitansi',
            'TUP' => 'tambah_tup',
            'LS3' => 'rsa_kuitansi',
            'TUP BBM' => 'tambah_tup',
            'TUP NIHIL' => 'tup',
            'LS4' => 'rsa_kuitansi',
            'LSPG' => 'kepeg_tr_spmls',
            'PUP' => 'tambah_up',
            'KS' => 'tambah_ks',
        );

        $tabel_konversi_jenis = array(
            'UP' => 'UP',
            'GUP' => 'GUP',
            'LS' => 'LSK',
            'TUP' => 'TUP',
            'LS3' => 'LSK',
            'TUP BBM' => 'TUP',
            'TUP NIHIL' => 'TUP_NIHIL',
            'LS4' => 'LS',
            'LSPG' => 'LS',
            'PUP' => 'PUP',
            'KS' => 'KS',
        );

        $masuk_spm = array('UP','GUP','TUP','PUP','TUP NIHIL','TUP BBM');

        $masuk_pgw = array('LSPG','LS');

        $masuk_ls = array('LS3','LS4','LSK','LS','LSNK');

        $masuk_ks = array('KS');

        $spm_ketemu_siak = '';
        $spm_ketemu_rsa = '';

        // CARI DI SIAK
        
        $spm = $this->db->select('no_spm')
                        ->where(array('jumlah_debet' => $jumlah,'unit_kerja' => $unit, 'jenis' => $tabel_konversi_jenis[$jenis]))
                        ->where("tipe <> 'pajak'")
                        ->get('akuntansi_kuitansi_jadi')
                        ->result_array();

        foreach ($spm as $found_spm) {
            $spm_ketemu_siak .= $found_spm['no_spm'].",";
        }

        if (in_array($jenis,$masuk_ls)){
            $spm = $this->db->select('no_spm')
                        ->where(array('jumlah_debet' => $jumlah,'unit_kerja' => $unit))
                        ->where("(jenis = 'LK' or jenis = 'LN')")
                        ->where("tipe <> 'pajak'")
                        ->get('akuntansi_kuitansi_jadi')
                        ->result_array();

            foreach ($spm as $found_spm) {
                $spm_ketemu_siak .= $found_spm['no_spm'].",";
            }
        }

        if (in_array($jenis,$masuk_ks)){
            $spm = $this->db->select('no_spm')
                        ->where(array('jumlah_debet' => $jumlah,'unit_kerja' => $unit))
                        ->where("jenis = 'KS' ")
                        ->where("tipe <> 'pajak'")
                        ->get('akuntansi_kuitansi_jadi')
                        ->result_array();

            foreach ($spm as $found_spm) {
                $spm_ketemu_siak .= $found_spm['no_spm'].",";
            }
        }

        if (in_array($jenis,$masuk_pgw)){
            $spm = $this->db->select('no_spm')
                        ->where(array('jumlah_debet' => $jumlah,'unit_kerja' => $unit, 'jenis' => 'NK'))
                        ->where("tipe <> 'pajak'")
                        ->get('akuntansi_kuitansi_jadi')
                        ->result_array();

            foreach ($spm as $found_spm) {
                $spm_ketemu_siak .= $found_spm['no_spm'].",";
            }
        }

        // $spm_ketemu_siak = ''; //UNTUK FORCE SEARCH KE RSA

        if (strlen($spm_ketemu_siak) == 0){
            $spm_ketemu_siak = "tidak ketemu di siak";
            // CARI DI RSA
            // Kalau masuk SPM
            if (in_array($jenis,$masuk_spm)){ 
                $tabel_spm = $tabel_jenis[$jenis];
                
                $where_unit = 'AND substr(trx_'.$tabel_spm.'.kode_unit_subunit,1,2)="'.$unit.'"';

                $string_query = "
                                    SELECT 
                                        posisi,ket,str_nomor_trx as no_spm,
                                        jumlah_bayar as jumlah,
                                        tgl_proses
                                    FROM 
                                        trx_spm_".$tabel_spm."_data, trx_".$tabel_spm."                                         
                                    WHERE 
                                        nomor_trx_spm = id_trx_nomor_".$tabel_spm."  AND 
                                        jumlah_bayar = $jumlah AND
                                        id_trx_".$tabel_spm." IN (select distinct max(id_trx_".$tabel_spm.") from trx_".$tabel_spm." group by id_trx_nomor_".$tabel_spm.")
                                        $where_unit 
                                    GROUP BY
                                        nomor_trx_spm
                                    ORDER BY 
                                        nomor_trx_spm,tgl_proses DESC";

                $spm = $this->db->query($string_query)->result_array();
                foreach ($spm as $found_spm) {
                    $spm_ketemu_rsa .= $found_spm['no_spm']."(".$found_spm['posisi']."),";
                }
            }
            // Kalau masuk KS
            if (in_array($jenis,$masuk_ks)){ 
                $tabel_spm = $tabel_jenis[$jenis];
                
                $where_unit = 'AND substr(trx_'.$tabel_spm.'.kode_unit_subunit,1,2)="'.$unit.'"';

                $string_query = "
                                    SELECT 
                                        posisi,ket,str_nomor_trx as no_spm,
                                        jumlah_bayar as jumlah,
                                        tgl_proses
                                    FROM 
                                        trx_spm_".$tabel_spm."_data, trx_".$tabel_spm."                                         
                                    WHERE 
                                        nomor_trx_spm = id_trx_nomor_".$tabel_spm."_spm  AND 
                                        jumlah_bayar = $jumlah AND
                                        id_trx_".$tabel_spm." IN (select distinct max(id_trx_".$tabel_spm.") from trx_".$tabel_spm." group by id_trx_nomor_".$tabel_spm.")
                                        $where_unit 
                                    GROUP BY
                                        nomor_trx_spm
                                    ORDER BY 
                                        nomor_trx_spm,tgl_proses DESC";

                $spm = $this->db->query($string_query)->result_array();
                foreach ($spm as $found_spm) {
                    $spm_ketemu_rsa .= $found_spm['no_spm']."(".$found_spm['posisi']."),";
                }
            }
            // Kalau masuk LS3
            if (in_array($jenis,$masuk_ls)){
                $string_query = "
                                    SELECT 
                                        if(cair=1,'cair','belum cair') as posisi, 
                                        str_nomor_trx_spm as no_spm, 
                                        sum(volume*harga_satuan) as jumlah
                                    FROM 
                                        rsa_kuitansi,
                                        rsa_kuitansi_detail 
                                    WHERE 
                                        rsa_kuitansi.id_kuitansi=rsa_kuitansi_detail.id_kuitansi AND
                                        (jenis = 'LK' OR jenis = 'LN') AND
                                        substr(kode_unit,1,2) = $unit
                                    GROUP BY 
                                        str_nomor_trx_spm
                                    HAVING
                                        jumlah = $jumlah
                                    ";
                $spm = $this->db->query($string_query)->result_array();
                foreach ($spm as $found_spm) {
                    $spm_ketemu_rsa .= $found_spm['no_spm']."(".$found_spm['posisi']."),";
                }
            }
            // Kalau masuk LS PG
            if (in_array($jenis,$masuk_pgw)){
                $string_query = "
                                    SELECT 
                                        IF(proses = 5 ,'selesai','belum selesai') as posisi, 
                                        status as ket, 
                                        nomor as no_spm, 
                                        total_sumberdana as jumlah
                                    FROM 
                                        kepeg_tr_spmls 
                                    WHERE 
                                        total_sumberdana = $jumlah AND
                                        substr(unitsukpa,1,2) = $unit         
                                    ";
                $spm = $this->db->query($string_query)->result_array();
                foreach ($spm as $found_spm) {
                    $spm_ketemu_rsa .= $found_spm['no_spm']."(".$found_spm['posisi']."),";
                }
            }

            if (strlen($spm_ketemu_rsa) == 0){
                $spm_ketemu_rsa = "tidak ketemu di rsa";
            }else{
                $spm_ketemu_rsa = substr($spm_ketemu_rsa,0,-1);
            }
            
        }else{
            $spm_ketemu_siak = substr($spm_ketemu_siak,0,-1);
        }


        $result = array(
            'siak' => $spm_ketemu_siak,
            'rsa' => $spm_ketemu_rsa,
        );

        return $result;


    }

    public function get_jenis_kuitansi_non_input()
    {
        return $this->db->where("basis != 'input'")->get('akuntansi_jenis_transaksi')->result_array();
    }


    public function read_spm_rsa($spm,$jumlah,$kode_unit=null)
    {
        $jenis_spm = explode('/', $spm)[2];
        $tabel_jenis = array('SPM-UP' => 'up',
            'SPM-GUP' => 'gup',
            'SPP-GUP' => 'gup',
            'SPM-TUP' => 'tambah_tup',
            'SPM-PUP' => 'tambah_up',
            'SPM-TUP-NIHIL' => 'tup',
            'SPM-LS PGW' => 'kepeg_tr_spmls',
            'SPM-LSK' => 'rsa_kuitansi',
            'SPM-LS' => 'rsa_kuitansi',
            'SPM-LSNK' => 'rsa_kuitansi',
            'SPM-LS K-3 NONKONTRAK' => 'rsa_kuitansi',
            'SPM-LS PIHAK KE-3' => 'rsa_kuitansi');

        $masuk_spm = array('SPM-UP','SPM-GUP','SPM-TUP','SPM-PUP','SPM-TUP-NIHIL');

        $masuk_pgw = array('SPM-LS PGW');

        $masuk_ls = array('SPM-LS K-3 NONKONTRAK','SPM-LS PIHAK KE-3','SPM-LSK','SPM-LS','SPM-LSNK');

        $status = array();


        if (isset($tabel_jenis[$jenis_spm])){
            $tabel_spm = $tabel_jenis[$jenis_spm];
            if (in_array($jenis_spm,$masuk_spm)){ // Kalau masuk SPM
                if($kode_unit!=null){
                    $unit = 'AND substr(trx_'.$tabel_spm.'.kode_unit_subunit,1,2)="'.$kode_unit.'"';
                }else{
                    $unit = '';
                }

                $string_query = "SELECT posisi,ket,str_nomor_trx as no_spm,jumlah_bayar as jumlah FROM trx_spm_".$tabel_spm."_data, trx_".$tabel_spm." WHERE nomor_trx_spm = id_trx_nomor_".$tabel_spm."  AND 
                (str_nomor_trx LIKE '$spm') $unit ORDER BY tgl_proses DESC LIMIT 0,1";

                // die($string_query);
                $query = $this->db->query($string_query);
                $status = $query->result_array();
                if ($status == null){
                    $status['posisi'] = 'belum ada di rsa';
                    $status['ket'] = '-';
                    $status['no_spm'] = '-';
                    $status['jumlah'] = '-';
                }else{
                    $status = $status[0];
                }
                $status['sama_nominal'] = 0;
                return $status;
            }elseif(in_array($jenis_spm,$masuk_pgw)){ // Kalau masuk LS Pegawai
                $string_query = "SELECT IF(proses = 5 ,'selesai','belum selesai') as posisi, status as ket, nomor as no_spm, total_sumberdana as jumlah, IF(total_sumberdana = $jumlah AND nomor NOT LIKE '$spm',1,0) as sama_nominal FROM kepeg_tr_spmls WHERE nomor LIKE '$spm' OR total_sumberdana = $jumlah";
                $query = $this->db->query($string_query);
                $status = $query->result_array();
                if ($status == null){
                    $status['posisi'] = 'belum ada di rsa';
                    $status['ket'] = '-';
                    $status['no_spm'] = '-';
                    $status['jumlah'] = '-';
                    $status['sama_nominal'] = 0;
                }else{
                    $status = $status[0];
                }
                return $status;

            }elseif (in_array($jenis_spm, $masuk_ls)) { // Kalau masuk LS pihak ketiga
                $string_query = "SELECT if(cair=1,'cair','belum cair') as posisi, str_nomor_trx_spm as no_spm, sum(volume*harga_satuan) as jumlah,IF(sum(volume*harga_satuan) = $jumlah AND str_nomor_trx_spm NOT LIKE '$spm',1,0) as sama_nominal FROM rsa_kuitansi,rsa_kuitansi_detail WHERE rsa_kuitansi.id_kuitansi=rsa_kuitansi_detail.id_kuitansi GROUP BY str_nomor_trx_spm HAVING (no_spm LIKE '$spm' OR jumlah=$jumlah)";
                $query = $this->db->query($string_query);
                $status = $query->result_array();
                if ($status == null){
                    $status['posisi'] = 'belum ada di rsa';
                    $status['ket'] = '-';
                    $status['no_spm'] = '-';
                    $status['jumlah'] = '-';
                    $status['sama_nominal'] = 0;
                }else{
                    $status = $status[0];
                    $status['ket'] = '-';
                }
                return $status;
            }
        }else{
            $status['posisi'] = 'tidak ditemukan';
            $status['ket'] = '-';
            $status['no_spm'] = '-';
            $status['jumlah'] = '-';
            $status['sama_nominal'] = 0;
            return $status;
        }
    }

    public function read_kuitansi_all($status = null)
    {
        $array_hasil = array();
        $list_unit = $this->Unit_kerja_model->get_all_unit_kerja();
        foreach ($list_unit as $unit) {
            $kode_unit = $unit['kode_unit'];
            $nama_unit = $unit['alias'];
            $query_s = "
            SELECT DISTINCT
              rsa.akuntansi_kuitansi_jadi.no_spm,
              -- rsa.akuntansi_kuitansi_jadi.tanggal,
              -- rsa.akuntansi_kuitansi_jadi.jenis,
              -- rsa.akuntansi_kuitansi_jadi.unit_kerja,
              rsa.akuntansi_kuitansi_jadi.jumlah_debet AS jumlah
            FROM
              rsa.akuntansi_kuitansi_jadi
            WHERE
              rsa.akuntansi_kuitansi_jadi.tanggal BETWEEN '2017-01-01' AND '2017-09-30' AND
              rsa.akuntansi_kuitansi_jadi.jenis NOT IN ('GP', 'LK', 'LN','TUP_PENGEMBALIAN') AND
              rsa.akuntansi_kuitansi_jadi.unit_kerja = $kode_unit  AND
              rsa.akuntansi_kuitansi_jadi.status = '$status' AND
              rsa.akuntansi_kuitansi_jadi.tipe = 'pengeluaran'
            ";
            $array_s = $this->db->query($query_s)->result_array();
            $query_k = "
            SELECT DISTINCT
              rsa.akuntansi_kuitansi_jadi.no_spm,
              -- rsa.akuntansi_kuitansi_jadi.tanggal,
              -- rsa.akuntansi_kuitansi_jadi.jenis,
              -- rsa.akuntansi_kuitansi_jadi.unit_kerja,
              Sum(rsa.akuntansi_kuitansi_jadi.jumlah_debet) AS jumlah
            FROM
              rsa.akuntansi_kuitansi_jadi
            WHERE
              rsa.akuntansi_kuitansi_jadi.tanggal BETWEEN '2017-01-01' AND '2017-09-30' AND
              rsa.akuntansi_kuitansi_jadi.jenis IN ('GP', 'LK', 'LN','TUP_NIHIL') AND
              rsa.akuntansi_kuitansi_jadi.unit_kerja = $kode_unit AND
              rsa.akuntansi_kuitansi_jadi.status = '$status' AND
              rsa.akuntansi_kuitansi_jadi.tipe = 'pengeluaran'
            GROUP BY
              rsa.akuntansi_kuitansi_jadi.no_spm
            ";
            $array_k = $this->db->query($query_k)->result_array();
            $array_hasil = array_merge($array_hasil,array_merge($array_s,$array_k));
        }
        $array_return = array();
        foreach ($array_hasil as $value) {
            $value['no_spm'] = str_replace(' ','',$value['no_spm']);
            $array_return['spm'][] = $value['no_spm'];
            $array_return['jumlah_spm'][$value['no_spm']] = $value['jumlah'];
        }
        return $array_return;
    }

	
    function read_kuitansi($limit = null, $start = null, $keyword = null, $kode_unit = null, $jenis = null){
        $added_query = "1 ";

        if ($jenis != null){
            $added_query .= "AND jenis='$jenis'";
        }

        if($kode_unit!=null){
            $unit = 'AND substr(kode_unit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("
                                            SELECT 
                                                tk.*,
                                                SUBSTR(td.kode_usulan_belanja,-6) as kode_akun 
                                            FROM 
                                                rsa_kuitansi AS tk, 
                                                rsa_kuitansi_detail as td 
                                            WHERE 
                                                $added_query AND 
                                                tk.id_kuitansi = td.id_kuitansi AND 
                                                cair=1 AND 
                                                flag_proses_akuntansi=0 AND
                                                (tk.no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') 
                                                $unit 
                                            ORDER BY 
                                                str_nomor_trx_spm ASC, 
                                                tk.no_bukti ASC 
                                            LIMIT $start, $limit
                                    ");
        }else{
            $query = $this->db->query("
                                            SELECT 
                                                tk.*,
                                                SUBSTR(td.kode_usulan_belanja,-6) as kode_akun 
                                            FROM 
                                                rsa_kuitansi AS tk, 
                                                rsa_kuitansi_detail as td 
                                            WHERE 
                                                $added_query AND 
                                                tk.id_kuitansi = td.id_kuitansi AND 
                                                cair=1 AND 
                                                flag_proses_akuntansi=0 AND
                                                (tk.no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') 
                                                $unit 
                                            ORDER BY 
                                                str_nomor_trx_spm ASC, 
                                                tk.no_bukti ASC 
                                    ");
        }
        return $query;
    }

	function read_kuitansi_gup($limit = null, $start = null, $keyword = null, $kode_unit = null, $jenis = null, $spm = null){

        if ($jenis == 'GUP'){
            $jenis_req = "tg.untuk_bayar != 'GUP NIHIL'";
        }elseif ($jenis == 'GUP_NIHIL') {
            $jenis_req = "tg.untuk_bayar = 'GUP NIHIL'";
        }

        if ($spm == true){
            $spm_group = "GROUP BY tk.str_nomor_trx_spm";
        }else{
            $spm_group = "";
        }

        if($kode_unit!=null){
            $unit_req = 'substr(kode_unit,1,2)="'.$kode_unit.'"';
        }else{
            $unit_req = '';
        }

        if ($spm_group == null){
            $spm_group = "GROUP BY id_kuitansi";
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("
                SELECT 
                        tk.*,SUBSTR(td.kode_usulan_belanja,-6) as kode_akun FROM rsa_kuitansi as tk, trx_spm_gup_data as tg,rsa_kuitansi_detail as td
                WHERE 
                        tk.str_nomor_trx_spm = tg.str_nomor_trx AND 
                        tk.id_kuitansi = td.id_kuitansi AND
                        $jenis_req AND
                        $unit_req AND 
                        (tk.no_bukti LIKE '%$keyword%' OR tk.str_nomor_trx_spm LIKE '%$keyword%') AND
                        tk.flag_proses_akuntansi=0 AND
                        tk.cair = 1
                $spm_group
                ORDER BY 
                        tk.str_nomor_trx_spm ASC, 
                        tk.no_bukti ASC 
                LIMIT 
                        $start, $limit
                ");
		}else{
			$query = $this->db->query("
                SELECT 
                        tk.*,SUBSTR(td.kode_usulan_belanja,-6) as kode_akun FROM rsa_kuitansi as tk, trx_spm_gup_data as tg,rsa_kuitansi_detail as td
                WHERE 
                        tk.str_nomor_trx_spm = tg.str_nomor_trx AND 
                        tk.id_kuitansi = td.id_kuitansi AND
                        tg.untuk_bayar = 'GUP NIHIL' AND
                        tk.cair = 1
                        AND (tk.no_bukti LIKE '%$keyword%' OR tk.str_nomor_trx_spm LIKE '%$keyword%')
                        $unit
                $spm_group
                ORDER BY 
                        tk.str_nomor_trx_spm ASC, 
                        tk.no_bukti ASC ");
		}
		return $query;
	}

    public function read_kuitansi_tup_pengembalian($limit = null, $start = null, $keyword = null, $kode_unit = null, $jenis = null)
    {
        $added_query = "1 ";

        if($kode_unit!=null){
            $unit = 'AND substr(kode_unit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM rsa_kuitansi_pengembalian WHERE $added_query AND cair=1 AND flag_proses_akuntansi=0 AND jenis='TP' AND
            (no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit ORDER BY str_nomor_trx_spm ASC, no_bukti ASC LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM rsa_kuitansi_pengembalian WHERE $added_query AND cair=1 AND flag_proses_akuntansi=0 AND jenis='TP' AND
            (no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit ORDER BY str_nomor_trx_spm ASC, no_bukti ASC");
        }

        return $query;
    }

    public function read_kuitansi_pengembalian($limit = null, $start = null, $keyword = null, $kode_unit = null, $jenis = null)
    {
        $added_query = "1 ";

        if($kode_unit!=null){
            $unit = 'AND substr(kode_unit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        $query_jenis = '';
        if ($jenis != null){
            $query_jenis = " AND jenis='$jenis' ";
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT *, CONCAT(uraian,'; Penerima : ',nmbendahara) AS uraian FROM rsa_kuitansi_pengembalian WHERE $added_query AND cair=1 AND flag_proses_akuntansi=0 $query_jenis AND
            (no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit ORDER BY str_nomor_trx_spm ASC, no_bukti ASC LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT *, CONCAT(uraian,'; Penerima : ',nmbendahara) FROM rsa_kuitansi_pengembalian WHERE $added_query AND cair=1 AND flag_proses_akuntansi=0 $query_jenis AND
            (no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit ORDER BY str_nomor_trx_spm ASC, no_bukti ASC");
        }

        return $query;

    }

    function read_kuitansi_spm($limit = null, $start = null, $keyword = null, $kode_unit = null,$jenis = null){
         $added_query = "1 ";

        if ($jenis != null){
            $added_query .= "AND jenis='$jenis'";
        }

        if($kode_unit!=null){
            $unit = 'AND substr(kode_unit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM rsa_kuitansi WHERE $added_query AND cair=1 AND flag_proses_akuntansi=0 AND
            (no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit GROUP BY str_nomor_trx_spm ORDER BY str_nomor_trx_spm ASC, no_bukti ASC LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM rsa_kuitansi WHERE $added_query AND cair=1 AND flag_proses_akuntansi=0 AND
            (no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit ORDER BY str_nomor_trx_spm ASC, no_bukti ASC GROUP BY str_nomor_trx_spm");
        }
        return $query;
    }

    function read_kuitansi_spm_tup_pengembalian($limit = null, $start = null, $keyword = null, $kode_unit = null,$jenis = null){
         $added_query = "1 ";

        if ($jenis != null){
            $added_query .= "AND jenis='$jenis'";
        }

        if($kode_unit!=null){
            $unit = 'AND substr(kode_unit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM rsa_kuitansi_pengembalian WHERE $added_query AND cair=1 AND flag_proses_akuntansi=0 AND
            (no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit GROUP BY str_nomor_trx_spm ORDER BY str_nomor_trx_spm ASC, no_bukti ASC LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM rsa_kuitansi_pengembalian WHERE $added_query AND cair=1 AND flag_proses_akuntansi=0 AND
            (no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit ORDER BY str_nomor_trx_spm ASC, no_bukti ASC GROUP BY str_nomor_trx_spm");
        }
        return $query;
    }

    function read_kuitansi_spm_pengembalian($limit = null, $start = null, $keyword = null, $kode_unit = null,$jenis = null){
         $added_query = "1 ";

        if ($jenis != null){
            $added_query .= "AND jenis='$jenis'";
        }

        if($kode_unit!=null){
            $unit = 'AND substr(kode_unit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM rsa_kuitansi_pengembalian WHERE $added_query AND cair=1 AND flag_proses_akuntansi=0 AND
            (no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit GROUP BY str_nomor_trx_spm ORDER BY str_nomor_trx_spm ASC, no_bukti ASC LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM rsa_kuitansi_pengembalian WHERE $added_query AND cair=1 AND flag_proses_akuntansi=0 AND
            (no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit ORDER BY str_nomor_trx_spm ASC, no_bukti ASC GROUP BY str_nomor_trx_spm");
        }
        return $query;
    }

    public function get_no_spp_ls($no_spm)
    {
        $hasil = $this->db->where('str_nomor_trx_spm',$no_spm)->select('str_nomor_trx')->get('rsa_kuitansi')->row_array();

        // var_dump($hasil);
        // die();
        return $hasil['str_nomor_trx'];
    }

    public function get_no_spp_em($no_spm)
    {
        $this->db->select(array('kode_unit_subunit','nomor_trx'));
        $where = $this->db->get_where('trx_nomor_em',array('str_nomor_trx' => $no_spm))->row_array();
        $where['aktif'] = 1;
        $where['jenis'] = 'SPP';
        $hasil = $this->db->get_where('trx_nomor_em',$where)->row_array();

        if ($hasil != null){
            return $hasil['str_nomor_trx'];
        }

    }

    public function get_no_spp($no_spm,$table)
    {
        $this->db->select(array('kode_unit_subunit','nomor_trx'));
        $where = $this->db->get_where($table,array('str_nomor_trx' => $no_spm))->row_array();
        $where['aktif'] = 1;
        $where['jenis'] = 'SPP';
        $hasil = $this->db->get_where($table,$where)->row_array();

        if ($hasil != null){
            return $hasil['str_nomor_trx'];
        }

    }

    
    function read_up($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_up.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT *, str_nomor_trx AS str_nomor_trx_spm, id_trx_spm_up_data AS id_kuitansi, CONCAT(untuk_bayar,'; Penerima : ',penerima) AS uraian, kd_akun_kas AS kode_akun FROM trx_spm_up_data, trx_up, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_up_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT *, str_nomor_trx AS str_nomor_trx_spm, id_trx_spm_up_data AS id_kuitansi, CONCAT(untuk_bayar,'; Penerima : ',penerima) AS uraian, kd_akun_kas AS kode_akun FROM trx_spm_up_data, trx_up, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_up_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit");
		}
		return $query;
	}

    function read_gup($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_gup.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }


        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT *, id_trx_spm_gup_data AS id_kuitansi, str_nomor_trx AS str_nomor_trx_spm, CONCAT(untuk_bayar,'; Penerima : ',penerima) AS uraian, debet AS jumlah, kd_akun_kas AS kode_akun FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND untuk_bayar != 'GUP NIHIL' AND
            (str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT *, id_trx_spm_gup_data AS id_kuitansi, str_nomor_trx AS str_nomor_trx_spm, CONCAT(untuk_bayar,'; Penerima : ',penerima) AS uraian, debet AS jumlah, kd_akun_kas AS kode_akun FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND untuk_bayar != 'GUP NIHIL' AND
            (str_nomor_trx LIKE '%$keyword%') $unit");
        }
        return $query;
    }

  //   function read_gup_nihil($limit = null, $start = null, $keyword = null, $kode_unit = null){
  //       if($kode_unit!=null){
  //           $unit = 'AND substr(trx_gup.kode_unit_subunit,1,2)="'.$kode_unit.'"';
  //       }else{
  //           $unit = '';
  //       }

		// if($limit!=null OR $start!=null){
		// 	$query = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND kredit=0 AND untuk_bayar = '' AND
		// 	(str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
		// }else{
		// 	$query = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND kredit=0 AND untuk_bayar = 'GUP NIHIL' AND
		// 	(str_nomor_trx LIKE '%$keyword%') $unit");
		// }
		// return $query;
  //   }
    
    function read_pup($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_pup.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT *, str_nomor_trx AS str_nomor_trx_spm, id_trx_spm_pup_data AS id_kuitansi FROM trx_spm_pup_data, trx_pup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_pup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT *, str_nomor_trx AS str_nomor_trx_spm, id_trx_spm_pup_data AS id_kuitansi FROM trx_spm_pup_data, trx_pup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_pup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit");
		}
		return $query;
	}
    
    function read_tup($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_tup.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT *, str_nomor_trx AS str_nomor_trx_spm, id_trx_spm_tup_data AS id_kuitansi, CONCAT(untuk_bayar,'; Penerima : ',penerima) AS uraian, kd_akun_kas AS kode_akun FROM trx_spm_tup_data, trx_tup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_tup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
            (str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT *, str_nomor_trx AS str_nomor_trx_spm, id_trx_spm_tup_data AS id_kuitansi, CONCAT(untuk_bayar,'; Penerima : ',penerima) AS uraian, kd_akun_kas AS kode_akun FROM trx_spm_tup_data, trx_tup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_tup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
            (str_nomor_trx LIKE '%$keyword%') $unit");
        }
        return $query;
    }
    
    function read_em($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_em.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM trx_spm_em_data, trx_em, kas_undip WHERE nomor_trx_spm = id_trx_nomor_em_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
            (str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM trx_spm_em_data, trx_em, kas_undip WHERE nomor_trx_spm = id_trx_nomor_em_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
            (str_nomor_trx LIKE '%$keyword%') $unit");
        }
        // die("SELECT * FROM trx_spm_em_data, trx_em, kas_undip WHERE nomor_trx_spm = id_trx_nomor_em_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND (str_nomor_trx LIKE '%$keyword%') $unit");
        return $query;
    }

    function read_ks($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_ks.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        $disabler = "";


		if($limit!=null OR $start!=null){
			$query = $this->db->query("  
                                        SELECT 
                                            *, trx_spp_ks_data.str_nomor_trx as no_spp, 
                                            trx_spm_ks_data.str_nomor_trx AS str_nomor_trx_spm, 
                                            trx_spm_ks_data.str_nomor_trx AS no_spm, 
                                            id_trx_spm_ks_data AS id_kuitansi,
                                            kas_bendahara.kd_akun_kas AS kd_akun_kas,
                                            kas_bendahara.debet
                                        FROM 
                                            trx_spm_ks_data, 
                                            trx_ks, 
                                            kas_bendahara,
                                            -- kas_kerjasama, 
                                            trx_spp_ks_data 
                                        WHERE 
                                            trx_spm_ks_data.nomor_trx_spm = id_trx_nomor_ks_spm AND 
                                            posisi='SPM-FINAL-KBUU' AND 
                                            flag_proses_akuntansi=0 AND
                                            kas_bendahara.no_spm = trx_spm_ks_data.str_nomor_trx AND 
                                            -- no_spm = trx_spm_ks_data.str_nomor_trx AND 
                                            nomor_trx_spp=id_trx_nomor_ks $disabler AND
                                             (trx_spm_ks_data.str_nomor_trx LIKE '%$keyword%') $unit 
                                        LIMIT 
                                            $start, $limit
                                        ");
		}else{
			$query = $this->db->query("  
                                        SELECT 
                                            *, trx_spp_ks_data.str_nomor_trx as no_spp, 
                                            trx_spm_ks_data.str_nomor_trx AS str_nomor_trx_spm, 
                                            trx_spm_ks_data.str_nomor_trx AS no_spm, 
                                            id_trx_spm_ks_data AS id_kuitansi,
                                            kas_bendahara.kd_akun_kas AS kd_akun_kas,
                                            kas_bendahara.debet
                                        FROM 
                                            trx_spm_ks_data, 
                                            trx_ks, 
                                            kas_bendahara,
                                            -- kas_kerjasama, 
                                            trx_spp_ks_data 
                                        WHERE 
                                            trx_spm_ks_data.nomor_trx_spm = id_trx_nomor_ks_spm AND 
                                            posisi='SPM-FINAL-KBUU' AND 
                                            flag_proses_akuntansi=0 AND
                                            kas_bendahara.no_spm = trx_spm_ks_data.str_nomor_trx AND 
                                            -- no_spm = trx_spm_ks_data.str_nomor_trx AND 
                                            nomor_trx_spp=id_trx_nomor_ks $disabler AND
                                             (trx_spm_ks_data.str_nomor_trx LIKE '%$keyword%') $unit 
                                        ");
		}
        // vdebug($query->result_array());
		return $query;
	}
    
    function read_tup_nihil($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_tup_nihil.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM trx_spm_tup_nihil_data, trx_tup_nihil, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_tup AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM trx_spm_tup_nihil_data, trx_tup_nihil, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_tup AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit");
		}
		return $query;
	}

    function read_spm($limit = null, $start = null, $keyword = null){
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '';
        }else{
            if($this->session->userdata('alias')=='WR2'){
                $alias = 'W23';
            }elseif($this->session->userdata('alias')=='WR1'){
                $alias = 'W11';
            }else{
                $alias = $this->session->userdata('alias');
            }
            $filter_unit = "AND substr(kepeg_tr_spmls.nomor,7,3)='".$alias."'";
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT kepeg_tr_spmls.*, kepeg_tr_spmls.nomor AS str_nomor_trx_spm, id_spmls AS id_kuitansi, untuk_bayar AS uraian, SUBSTR(kepeg_tr_spmls.detail_belanja,19,6) AS kode_akun FROM kepeg_tr_spmls JOIN kepeg_tr_sppls ON id_tr_sppls=id_sppls WHERE flag_proses_akuntansi=0 AND kepeg_tr_spmls.proses=5 AND kepeg_tr_spmls.nomor LIKE '%$keyword%' $filter_unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT kepeg_tr_spmls.*, kepeg_tr_spmls.nomor AS str_nomor_trx_spm, id_spmls AS id_kuitansi, untuk_bayar AS uraian, SUBSTR(kepeg_tr_spmls.detail_belanja,19,6) AS kode_akun FROM kepeg_tr_spmls JOIN kepeg_tr_sppls ON id_tr_sppls=id_sppls WHERE flag_proses_akuntansi=0 AND kepeg_tr_spmls.proses=5 AND kepeg_tr_spmls.nomor LIKE '%$keyword%' $filter_unit");
        }
        return $query;
    }

    function read_kuitansi_jadi($limit = null, $start = null, $keyword = null, $kode_unit = null, $jenis = 'GP'){
        if($kode_unit!=null){
            $unit = 'AND unit_kerja="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($this->session->userdata('level')==1){
            $verifikasi = "AND ((status='revisi' AND flag=1) OR (status='proses' AND flag=1))";
            $order = "ORDER BY status DESC,no_bukti ASC";
            //$order = "ORDER BY FIELD(status, 'revisi', 'proses', 'terima', 'posted')";
        }else{
            $verifikasi = "AND ((status='proses' AND flag=1) OR (status='direvisi' AND flag=1))";
            $order = "ORDER BY no_bukti ASC";
           //$order = "ORDER BY FIELD(status, 'proses', 'revisi', 'terima', 'posted')";
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='$jenis' AND (tipe<>'memorial' AND tipe<>'jurnal_umum' AND tipe<>'pajak') AND status<>'posted' $verifikasi AND
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit $order LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='$jenis' AND (tipe<>'memorial' AND tipe<>'jurnal_umum' AND tipe<>'pajak') AND status<>'posted' $verifikasi AND 
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit $order");
        }
        return $query;
    }

    function read_kuitansi_jadi_group_spm($limit = null, $start = null, $keyword = null, $kode_unit = null, $jenis = 'GP'){
        if($kode_unit!=null){
            $unit = 'AND unit_kerja="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($this->session->userdata('level')==1){
            $verifikasi = "";
        }else{
            $verifikasi = "AND ((status='proses' AND flag=1) OR (status='direvisi' AND flag=1))";
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='$jenis' AND (tipe<>'memorial' AND tipe<>'jurnal_umum' AND tipe<>'pajak') AND status<>'posted' $verifikasi
            $unit GROUP BY no_spm ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted') LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='$jenis' AND (tipe<>'memorial' AND tipe<>'jurnal_umum' AND tipe<>'pajak') AND status<>'posted' $verifikasi 
            $unit GROUP BY no_spm ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted')");
        }
        return $query;
    }

    function read_posting_group_spm($limit = null, $start = null, $keyword = null, $kode_unit = null, $jenis = 'GP'){
        if($kode_unit!=null){
            $unit = 'AND unit_kerja="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='$jenis' AND tipe<>'pajak'  
            $unit AND status='proses' AND flag=2 GROUP BY no_spm LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='$jenis' AND tipe<>'pajak'  
            $unit AND status='proses' AND flag=2 GROUP BY no_spm");
        }
        return $query;
    }

	function read_kuitansi_ls($limit = null, $start = null, $keyword = null, $kode_unit=null){
		if($kode_unit!=null){
            $unit = 'AND substr(trx_lsphk3.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM trx_spm_lsphk3_data, trx_lsphk3, (select id_kuitansi, kode_akun, uraian, no_bukti, cair from rsa_kuitansi_lsphk3) as  rsa_kuitansi_lsphk3 WHERE id_trx_spm_lsphk3_data = id_trx_nomor_lsphk3 AND posisi='SPM-FINAL-KBUU' AND trx_lsphk3.id_kuitansi = rsa_kuitansi_lsphk3.id_kuitansi AND trx_spm_lsphk3_data.flag_proses_akuntansi=0 AND rsa_kuitansi_lsphk3.cair = 1 AND
			(str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM trx_spm_lsphk3_data, trx_lsphk3, (select id_kuitansi, kode_akun, uraian, no_bukti, cair from rsa_kuitansi_lsphk3) as  rsa_kuitansi_lsphk3 WHERE id_trx_spm_lsphk3_data = id_trx_nomor_lsphk3 AND posisi='SPM-FINAL-KBUU' AND trx_lsphk3.id_kuitansi = rsa_kuitansi_lsphk3.id_kuitansi AND trx_spm_lsphk3_data.flag_proses_akuntansi=0 AND rsa_kuitansi_lsphk3.cair = 1 AND
			(str_nomor_trx LIKE '%$keyword%') $unit");
		}
		return $query;
	}
    
    function read_kuitansi_posting($limit = null, $start = null, $keyword = null, $kode_unit = null,  $jenis = 'GP'){
        if($kode_unit!=null){
            $unit = 'AND unit_kerja="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='$jenis' AND tipe<>'pajak' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='$jenis' AND tipe<>'pajak' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit");
        }
        return $query;
    }

    function read_kuitansi_posting_ls($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND unit_kerja="'.$kode_unit.'"';
        }else{
            $unit = '';
        }
        
        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='L3' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='L3' AND
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit");
        }
        return $query;
    }

    function read_kuitansi_posting_spm($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND unit_kerja="'.$kode_unit.'"';
        }else{
            $unit = '';
        }
        
        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='NK' AND jenis<>'pajak' AND tipe<>'pajak' AND 
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='NK' AND jenis<>'pajak' AND tipe<>'pajak' AND
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit");
        }
        return $query;
    }

    /*----------------Penerimaan & memorial ---------------------*/

    function read_by_tipe($limit = null, $start = null, $keyword = null, $tipe = 'penerimaan'){
        if($this->session->userdata('level')==1 || $this->session->userdata('level')==5 || $this->session->userdata('level')==8){
            $filter_unit = "AND unit_kerja='".$this->session->userdata('kode_unit')."'";
        }else{
            $filter_unit = '';
        }

        // echo $filter_unit;die();

        // print_r($this->session->userdata());die();
        if ($this->session->userdata('kode_user') == 'RM' and $tipe == 'jurnal_umum'){
            $filter_unit = '';   
        }

        $date_now = $this->session->userdata('setting_tahun');

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE tipe='$tipe' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') AND tanggal LIKE '%".$date_now."%' $filter_unit ORDER BY id_kuitansi_jadi DESC LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE tipe='$tipe' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') AND tanggal LIKE '%".$date_now."%' $filter_unit ORDER BY id_kuitansi_jadi DESC");
        }

        return $query;
    }

    /*----------------Penerimaan & memorial ---------------------*/

    public function get_nama_unit($kode_unit){
        $hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$kode_unit))->row_array()['nama_unit'];
        return $hasil;
    }

    public function get_kuitansi_transfer($id_kuitansi,$tabel,$tabel_detail,$jenis = null)
    {
        // die($jenis);
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->load->model('akuntansi/Spm_model', 'Spm_model');

        $hasil = $this->db->get_where($tabel,array('id_kuitansi'=>$id_kuitansi))->row_array();

        $hasil['kode_akun'] = $this->db->query('SELECT SUBSTR(kode_usulan_belanja,-6) as kode_akun FROM rsa_kuitansi_detail WHERE id_kuitansi='.$hasil['id_kuitansi'])->row_array()['kode_akun'];
        $hasil['kode_usulan_belanja'] = $this->db->query('SELECT kode_usulan_belanja FROM rsa_kuitansi_detail WHERE id_kuitansi='.$hasil['id_kuitansi'])->row_array()['kode_usulan_belanja'];

        $hasil['kode_unit'] = substr($hasil['kode_unit'], 0,2);

        $hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$hasil['kode_unit']))->row_array()['nama_unit'];
        $hasil['akun_debet'] = $hasil['kode_akun'];

        if ($jenis == 'EM'){
            $hasil['akun_debet'] = $this->Akun_model->get_akun_belanja_bbm()['akun_6'];
        }

        $query = "SELECT SUM(rsa_2018.$tabel_detail.volume*rsa_2018.$tabel_detail.harga_satuan) AS pengeluaran FROM $tabel,$tabel_detail WHERE $tabel.id_kuitansi = $tabel_detail.id_kuitansi AND $tabel.id_kuitansi=$id_kuitansi GROUP BY rsa_2018.$tabel.id_kuitansi";
        $hasil['jumlah_debet'] = $this->db->query($query)->row_array()['pengeluaran'];



        $hasil['tanggal'] = $this->Spm_model->get_tanggal_spm($hasil['str_nomor_trx_spm'],$jenis);
        $hasil['tanggal_bukti'] = $hasil['tgl_kuitansi'];
        $hasil['no_spm'] = $hasil['str_nomor_trx_spm'];
        $hasil['kode_kegiatan'] = $hasil['kode_usulan_belanja'];
        $hasil['unit_kerja'] = $hasil['kode_unit'];

        $field_tujuan = $this->db->list_fields('akuntansi_kuitansi_jadi');
        $field_asal = array_keys($hasil);

        foreach ($field_asal as $field) {
            if (!in_array($field, $field_tujuan)){
                unset($hasil[$field]);
            }
        }

        // print_r($hasil);die();
        return $hasil;

    }

    public function get_kuitansi_jadi($id_kuitansi_jadi)
    {
    	$this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
    	$hasil =  $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi'=>$id_kuitansi_jadi))->row_array();
        $hasil['kode_unit'] = $hasil['unit_kerja'];
    	$hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$hasil['unit_kerja']))->row_array()['nama_unit'];
        $hasil['tgl_kuitansi'] = $hasil['tanggal'];
        $hasil['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal($hasil['tanggal']);
    	$hasil['tanggal_bukti'] = $this->Jurnal_rsa_model->reKonversiTanggal($hasil['tanggal_bukti']);
    	$hasil['akun_debet_kas'] = $hasil['akun_debet'] . " - ". $this->Akun_model->get_nama_akun($hasil['akun_debet']);
    	return $hasil;

    }

    public function get_kuitansi_jadi_by_kode_kegiatan($kode_kegiatan)
    {
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->db->where("tipe <> 'pajak' AND tipe <> 'pengembalian'");
        $this->db->where('kode_kegiatan',$kode_kegiatan);

        $data = $this->db->get('akuntansi_kuitansi_jadi')->result_array();
        // ->where("tipe <> 'memorial' AND tipe <> 'jurnal_umum' AND tipe <> 'pajak' AND tipe <> 'penerimaan' AND tipe <> 'pengembalian'")
        $array_multi_akun = array('memorial','jurnal_umum','penerimaan','pengembalian');
        foreach ($data as $key => $entry) {
            $temp_detail = array();
            $detail = array();
            if (!in_array($entry['tipe'],$array_multi_akun)) {
                $detail['akun'] = $entry['akun_debet_akrual'];
                $detail['tipe'] = 'debet';
                $detail['jumlah'] = $entry['jumlah_debet'];
                $detail['jenis'] = 'akrual';

                $temp_detail[] = $detail;

                $detail['akun'] = $entry['akun_debet'];
                $detail['jenis'] = 'kas';

                $temp_detail[] = $detail;

                $detail['akun'] = $entry['akun_kredit_akrual'];
                $detail['tipe'] = 'kredit';
                $detail['jumlah'] = $entry['jumlah_kredit'];
                $detail['jenis'] = 'akrual';

                $temp_detail[] = $detail;

                $detail['akun'] = $entry['akun_kredit'];
                $detail['jenis'] = 'kas';

                $temp_detail[] = $detail;
            } else {
                $this->db->where('id_kuitansi_jadi',$entry['id_kuitansi_jadi']);
                $this->db->select('akun,tipe,jumlah,jenis');
                $temp_detail = $this->db->get('akuntansi_relasi_kuitansi_akun')->result_array();
            }
            $data[$key]['detail'] = $temp_detail;

            if ($entry['id_pajak'] != 0){
                $this->db->where('id_kuitansi_jadi',$entry['id_pajak']);
                $this->db->select('akun,tipe,jumlah,jenis');
                $data[$key]['pajak'] = $this->db->get('akuntansi_relasi_kuitansi_akun')->result_array();
            }else {
                $data[$key]['pajak'] = null;
            }

            if ($entry['id_pengembalian'] != 0){
                $this->db->where('id_kuitansi_jadi',$entry['id_pengembalian']);
                $this->db->select('akun,tipe,jumlah,jenis');
                $data[$key]['pengembalian'] = $this->db->get('akuntansi_relasi_kuitansi_akun')->result_array();
            }else {
                $data[$key]['pengembalian'] = null;
            }

            unset($data[$key]['akun_debet']);
            unset($data[$key]['akun_debet_akrual']);
            unset($data[$key]['akun_kredit']);
            unset($data[$key]['akun_kredit_akrual']);
            unset($data[$key]['jumlah_debet']);
            unset($data[$key]['jumlah_kredit']);
        }
        return $data;
    }

    public function get_kuitansi_aset_by_kode_kegiatan($kode_usulan_belanja,$kode_akun_tambah=null)
    {
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->db->select('rsa_kuitansi.id_kuitansi');
        $this->db->select('jenis');
        $this->db->select('kode_akun as akun');
        $this->db->select('str_nomor_trx_spm');
        $this->db->select('rsa_kuitansi_detail.kode_akun_tambah');

        $this->db->join('rsa_kuitansi_detail','rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi');

        if ($kode_akun_tambah != null){
            $this->db->where('kode_akun_tambah',$kode_akun_tambah);
        }

        // $this->db->select('jumlah');
        $this->db->where("(jenis = 'LN' or jenis = 'LK')");
        $this->db->where("cair = 1");
        $this->db->where('rsa_kuitansi.kode_usulan_belanja',$kode_usulan_belanja);

        // echo $this->db->get_compiled_select();die();

        $data = $this->db->get('rsa_kuitansi')->result_array();
        // print_r($data);die();

        $hasil = array();
        foreach ($data as $entry) {
            $jenis = $entry['jenis'];
            $temp_data = $this->get_kuitansi_transfer($entry['id_kuitansi'],$this->get_tabel_by_jenis($jenis),$this->get_tabel_detail_by_jenis($jenis),$jenis);
            $temp_data['no_spm'] = $entry['str_nomor_trx_spm'];
            $temp_data['kode_akun_tambah'] = $entry['kode_akun_tambah'];
            $temp_data['tanggal'] = $this->Spm_model->get_tanggal_spm($entry['str_nomor_trx_spm'],$jenis);
            $temp_data['pajak'] = $this->Pajak_model->get_detail_pajak($entry['id_kuitansi'],$jenis);
            $temp_data['detail'][] = array(
                                        'akun' => $temp_data['akun_debet'],
                                        'jumlah' => $temp_data['jumlah_debet'],
                                    );
            unset($temp_data['akun_debet']);
            unset($temp_data['jumlah_debet']);

            if ($jenis == 'LK'){
                $table_suffix = 'lsk';
            }elseif ($jenis == 'LN') {
                $table_suffix = 'lsnk';
            }
            $table = 'trx_spm_'.$table_suffix."_data";
            $table_status = 'trx_'.$table_suffix;
            $no_lookup_spm = $this->db->get_where($table,array('str_nomor_trx' => $entry['str_nomor_trx_spm']))->row_array()['nomor_trx_spm'];
            $temp_data['tanggal_verifikator'] = $this->db->get_where($table_status,array('id_trx_nomor_'.$table_suffix.'_spm' => $no_lookup_spm,'posisi' => 'SPM-FINAL-VERIFIKATOR'))->row_array()['tgl_proses'];
            $temp_data['tanggal_final_kbuu'] = $this->db->get_where($table_status,array('id_trx_nomor_'.$table_suffix.'_spm' => $no_lookup_spm,'posisi' => 'SPM-FINAL-KBUU'))->row_array()['tgl_proses'];

            $hasil[] = $temp_data;
        }

        return $hasil;
    }

    public function get_kuitansi_nk($id_spmls)
    {
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
    	$this->load->model('akuntansi/Akun_model', 'Akun_model');
    	$hasil =  $this->db->get_where('kepeg_tr_spmls',array('id_spmls'=>$id_spmls))->row_array();
    	$hasil['no_bukti'] = '';
    	$hasil['kode_usulan_belanja'] =  $hasil['detail_belanja'];
    	$hasil['unit_kerja'] = '';
        $hasil['unit_kerja'] = substr($hasil['unit_kerja'], 0,2);
    	$hasil['jenis'] = 'NK';
    	$hasil['pengeluaran'] = $hasil['total_sumberdana'];
    	$hasil['str_nomor_trx_spm'] = $hasil['nomor'];
    	$hasil['tgl_kuitansi'] = $hasil['tanggal'];
    	$hasil['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal($hasil['tanggal']);
    	$hasil['uraian'] = $this->db->get_where('kepeg_tr_sppls',array('id_sppls' => $hasil['id_tr_sppls']))->row_array()['untuk_bayar'];
    	$hasil['akun_debet'] = substr($hasil['detail_belanja'],18,6);
        $hasil['kode_akun'] = $hasil['akun_debet'];
    	$hasil['akun_debet_kas'] = $hasil['akun_debet'] . " - ". $this->Akun_model->get_nama_akun($hasil['akun_debet']);
    	return $hasil;
    }

    public function get_kuitansi_transfer_nk($id_spmls)
    {
    	$hasil = $this->get_kuitansi_nk($id_spmls);

    	$hasil['akun_debet'] = $hasil['kode_akun'];

    	$hasil['jumlah_debet'] = $hasil['pengeluaran'];


    	$hasil['tanggal'] = $hasil['tgl_kuitansi'];
        $hasil['tanggal_bukti'] = $hasil['tanggal'];
    	$hasil['no_spm'] = $hasil['str_nomor_trx_spm'];
    	$hasil['kode_kegiatan'] = $hasil['kode_usulan_belanja'];
        $hasil['uraian'] = $this->db->get_where('kepeg_tr_sppls',array('id_sppls' => $hasil['id_tr_sppls']))->row_array()['untuk_bayar'];
    	$hasil['unit_kerja'] = '';

    	$field_tujuan = $this->db->list_fields('akuntansi_kuitansi_jadi');
    	$field_asal = array_keys($hasil);

    	foreach ($field_asal as $field) {
    		if (!in_array($field, $field_tujuan)){
    			unset($hasil[$field]);
    		}
    	}


    	return $hasil;
    }

    function add_kuitansi_jadi($params,$type = null)
    {
        if ($type == 'post') {
            $this->db_laporan->insert('akuntansi_kuitansi_jadi',$params);
            return $this->db_laporan->insert_id();   
        } else {
            $this->db->insert('akuntansi_kuitansi_jadi',$params);
            return $this->db->insert_id();
        }
    }

    function edit_kuitansi_jadi($params,$id_kuitansi_jadi = null)
    {
        $this->db->where('id_kuitansi_jadi', $id_kuitansi_jadi);
        $query = $this->db->update('akuntansi_kuitansi_jadi',$params);
        return $query;
    }

    function edit_kuitansi_jadi_post($params,$id_kuitansi_jadi = null)
    {
        $this->db_laporan->where('id_kuitansi_jadi', $id_kuitansi_jadi);
        $query = $this->db_laporan->update('akuntansi_kuitansi_jadi',$params);
        return $query;
    }

    public function get_tabel_by_jenis($jenis)
    {
    	if ($jenis == 'GP' or $jenis == 'TUP_NIHIL' or $jenis == 'GUP_NIHIL' or $jenis == 'LN' or $jenis == 'LK' or $jenis == 'EM') {
    		return 'rsa_kuitansi';
    	}elseif ($jenis == 'L3') {
    		return 'rsa_kuitansi_lsphk3';
    	}elseif ($jenis == 'TUP_PENGEMBALIAN' or $jenis == 'GUP_PENGEMBALIAN') {
            return 'rsa_kuitansi_pengembalian';
        }
    }
    public function get_tabel_detail_by_jenis($jenis)
    {
    	if ($jenis == 'GP' or $jenis == 'TUP_NIHIL'  or $jenis == 'GUP_NIHIL' or $jenis == 'LN'or $jenis == 'LK'  or $jenis == 'EM') {
    		return 'rsa_kuitansi_detail';
    	}elseif ($jenis == 'L3') {
    		return 'rsa_kuitansi_detail_lsphk3';
    	}elseif ($jenis == 'TUP_PENGEMBALIAN'  or $jenis == 'GUP_PENGEMBALIAN') {
            return 'rsa_kuitansi_detail_pengembalian';
        }
    }

    function get_detail_pajak($no_bukti,$jenis)
    {   
        $data = array();
        if (in_array($jenis,array('GP','TP','LK','LN'))) {
            $tabel = 'rsa_kuitansi_detail_pajak';
        }elseif ($jenis == 'L3') {
            $tabel = 'rsa_kuitansi_detail_pajak_lsphk3';
        }
        $hasil = $this->db->get_where($tabel,array('no_bukti' => $no_bukti))->result_array();
        
        foreach ($hasil as $entry) {
            $detail = $this->db->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row();

            if (!empty($detail)){
                $data[] = $detail->nama_akun.' '.$entry['persen_pajak']." (Rp. ".number_format($entry['rupiah_pajak'],2,',','.').')';
            }
                // $data[] = array_merge($entry,$detail);
        }

        return $data;
    }

    function get_kuitansi_jumlah($id_kuitansi){

        $query = $this->db->query("SELECT SUM(volume*harga_satuan) AS pengeluaran FROM rsa_kuitansi_detail WHERE id_kuitansi='$id_kuitansi'")->row();
        return number_format($query->pengeluaran);
    }


    public function get_kuitansi_posting($id_kuitansi_jadi)
    {
        $hasil = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi'=>$id_kuitansi_jadi))->row_array();
        unset($hasil['status']);
        unset($hasil['flag']);
        return $hasil;
    }

    function update_kuitansi($id_kuitansi,$tabel,$params)
    {
        $this->db->where('id_kuitansi',$id_kuitansi);
        $response = $this->db->update($tabel,$params);
        if($response)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function update_kuitansi_jadi($id_kuitansi_jadi,$params)
    {
        $this->db->where('id_kuitansi_jadi',$id_kuitansi_jadi);
        $response = $this->db->update('akuntansi_kuitansi_jadi',$params);
         if($response)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function update_kuitansi_jadi_post($id_kuitansi_jadi,$params)
    {
    	$this->db_laporan->where('id_kuitansi_jadi',$id_kuitansi_jadi);
        $response = $this->db_laporan->update('akuntansi_kuitansi_jadi',$params);
         if($response)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function update_kuitansi_nk($id_spmls,$params)
    {
    	$this->db->where('id_spmls',$id_spmls);
        $response = $this->db->update('kepeg_tr_spmls',$params);
         if($response)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function read_total($cond, $table){
        $this->db->where($cond);
        $query = $this->db->get($table);
        return $query;
    }

    public function read_total_gup($jenis,$unit,$flag)
    {
        $query_unit = "AND substr(kode_unit,1,2) = $unit";
        if ($jenis == 'GUP_NIHIL'){
            $query = $this->db->query("SELECT tk.* FROM rsa_kuitansi as tk, trx_spm_gup_data as tg WHERE tk.str_nomor_trx_spm = tg.str_nomor_trx AND tg.untuk_bayar = 'GUP NIHIL' AND tk.jenis='GP' AND tk.cair = 1 AND tk.flag_proses_akuntansi=$flag $query_unit");
        }elseif ($jenis == 'GUP') {
            $query = $this->db->query("SELECT tk.* FROM rsa_kuitansi as tk, trx_spm_gup_data as tg WHERE tk.str_nomor_trx_spm = tg.str_nomor_trx AND tg.untuk_bayar != 'GUP NIHIL' AND tk.jenis='GP' AND tk.cair = 1 AND tk.flag_proses_akuntansi=$flag $query_unit");
        }
        // die("SELECT tk.* FROM rsa_kuitansi as tk, trx_spm_gup_data as tg WHERE tk.str_nomor_trx_spm = tg.str_nomor_trx AND tg.untuk_bayar != 'GUP NIHIL' AND tk.jenis='GP' AND tk.cair = 1 AND tk.flag_proses_akuntansi=$flag $query_unit");
        return $query;
    }

    public function total_up($posisi, $flag){
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '';
        }else{
            $filter_unit = 'AND substr(T.kode_unit_subunit,1,2)='.$this->session->userdata('kode_unit').'';
        }

        $query = $this->db->query("SELECT * FROM trx_up T, trx_spm_up_data U WHERE T.id_trx_nomor_up_spm=U.nomor_trx_spm AND T.posisi='$posisi' AND U.flag_proses_akuntansi='$flag' $filter_unit");
        return $query;
    }

    public function total_ks($posisi, $flag){
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '';
        }else{
            $filter_unit = 'AND substr(T.kode_unit_subunit,1,2)='.$this->session->userdata('kode_unit').'';
        }

        $query = $this->db->query("SELECT * FROM trx_ks T, trx_spm_ks_data U WHERE T.id_trx_nomor_ks_spm=U.nomor_trx_spm AND T.posisi='$posisi' AND U.flag_proses_akuntansi='$flag' $filter_unit");
        return $query;
    }

    public function total_em($posisi, $flag){
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '';
        }else{
            $filter_unit = 'AND substr(T.kode_unit_subunit,1,2)='.$this->session->userdata('kode_unit').'';
        }

        $query = $this->db->query("SELECT * FROM trx_em T, trx_spm_em_data U WHERE T.id_trx_nomor_em_spm=U.nomor_trx_spm AND T.posisi='$posisi' AND U.flag_proses_akuntansi='$flag' $filter_unit");
        return $query;
    }

    public function total_pup($posisi, $flag){
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '';
        }else{
            $filter_unit = 'AND substr(T.kode_unit_subunit,1,2)='.$this->session->userdata('kode_unit').'';
        }

        $query = $this->db->query("SELECT * FROM trx_pup T, trx_spm_pup_data U WHERE T.id_trx_nomor_pup_spm=U.nomor_trx_spm AND T.posisi='$posisi' AND U.flag_proses_akuntansi='$flag' $filter_unit");
        return $query;
    }

    public function total_tup($posisi, $flag){
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '';
        }else{
            $filter_unit = 'AND substr(T.kode_unit_subunit,1,2)='.$this->session->userdata('kode_unit').'';
        }

        $query = $this->db->query("SELECT * FROM trx_tup T, trx_spm_tup_data U WHERE T.id_trx_nomor_tup_spm=U.nomor_trx_spm AND T.posisi='$posisi' AND U.flag_proses_akuntansi='$flag' $filter_unit");
        return $query;
    }
    
    public function total_gup($posisi, $flag){
        
        if($this->session->userdata('kode_unit')!=null){
            $unit = 'AND substr(trx_gup.kode_unit_subunit,1,2)="'.$this->session->userdata('kode_unit').'"';
        }else{
            $unit = '';
        }

        
            $query = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND untuk_bayar != 'GUP NIHIL'  AND posisi='$posisi' AND flag_proses_akuntansi='$flag' AND no_spm = str_nomor_trx $unit AND kredit=0");
        return $query;
    }

    public function total_gup_nihil($posisi, $flag){
        
        if($this->session->userdata('kode_unit')!=null){
            $unit = 'AND substr(trx_gup.kode_unit_subunit,1,2)="'.$this->session->userdata('kode_unit').'"';
        }else{
            $unit = '';
        }
        
            $query = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND untuk_bayar == 'GUP NIHIL' AND posisi='$posisi' AND flag_proses_akuntansi='$flag' AND no_spm = str_nomor_trx $unit AND kredit=0");
        return $query;
    }
}