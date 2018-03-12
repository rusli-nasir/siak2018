<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
        $this->load->model('akuntansi/Spm_model', 'Spm_model');
    }

	public function index(){
		$hasil = array();
        $var_belum = $this->data['jumlah_notifikasi']->belum;
        $var_sudah = $this->data['jumlah_notifikasi']->sudah;
        foreach ($var_belum as $key => $value) {
        	$temp = array();
        	$temp['belum'] = $var_belum[$key];
        	$temp['sudah'] = $var_sudah[$key];
        	$hasil[] = $temp;
        }
        $var = array();
        $var['data']= $hasil;
        $this->load->view('akuntansi/dashboard/dashboard_operator',$var);
	}

    public function dashboard_proses($mode,$jenis = null)
    {
        // echo "<pre>";

        $array_all = array_keys($this->Spm_model->get_array_proses_spm());
        $data['spm'] = json_encode($this->Spm_model->get_spm_proses_rsa($mode,$array_all));
        $data['rekap'] = json_encode($this->Spm_model->get_spm_proses_rsa('total'));
        // echo json_encode($data);
        // print_r($this->Spm_model->get_spm_proses_rsa('total'));
        // print_r($data);
        // die();
        $this->data['content'] = $this->load->view('akuntansi/dashboard/dashboard_proses_spm',$data,true);
        $this->load->view('akuntansi/content_template',$this->data,false);
    }

    public function dashboard_spm_terjurnal()
    {
        
        // die($query);
        $data = $this->Spm_model->get_rekap_spm_terjurnal();
        $data['index'] = json_encode($data['index']);
        $data['rekap'] = json_encode($data['rekap']);
        // echo "<pre>";
        // print_r($data['index']);
        // die();

        $this->data['content'] = $this->load->view('akuntansi/dashboard/dashboard_spm_terjurnal',$data,true);
        $this->load->view('akuntansi/content_template',$this->data,false);
    }

    public function dashboard_compare_spm()
    {
        $array_unit = array(1,2,6);

        if (in_array($this->session->userdata('level'),$array_unit)){
            $_POST['unit'] = $this->session->userdata('kode_unit');
            $unit = $this->session->userdata('kode_unit');
        }

        $_POST['daterange'] = "01 Januari 2017 - 31 Desember 2017";

        if($this->input->post('daterange')!=null){
            $daterange = $this->input->post('daterange');
            $date_t = explode(' - ', $daterange);
            $periode_awal = strtodate($date_t[0]);
            $periode_akhir = strtodate($date_t[1]);
            $this->data['periode'] = $daterange;
            $this->data['teks_periode'] = "Periode " . $daterange;
        }else{
            $periode_awal = null;
            $periode_akhir = null;
            $this->data['periode'] = 'Semua Periode';
            $this->data['teks_periode'] = 'Semua Periode';
        }


        $jenis_kuitansi = $this->Spm_model->get_jenis_kuitansi();
        $jenis_pengembalian = $this->Spm_model->get_jenis_pengembalian();
        $jenis_spm = $this->Spm_model->get_jenis_spm();
        $jenis_lspg = $this->Spm_model->get_jenis_lspg();

        $jenis_all = array_merge($jenis_kuitansi,$jenis_spm,$jenis_pengembalian,$jenis_lspg);

        $jenis_all = $jenis_kuitansi;

        $array_spec_jenis = array(
                                    'spm' => array(
                                                    'field_unit' => "substr(kode_unit_subunit,1,2)",
                                                    'field_tanggal' => "tgl_spm",
                                                ),
                                    'kuitansi' => array(
                                                    'field_unit' => "substr(kode_unit,1,2)",
                                                    'field_tanggal' => "tgl_spm",
                                                    'tabel' => 'rsa_kuitansi',
                                                ),
                                    'pengembalian' => array(
                                                    'field_unit' => "substr(kode_unit,1,2)",
                                                    'field_tanggal' => "tgl_spm",
                                                    "tabel" => 'rsa_kuitansi_pengembalian',
                                                ),
                                    'lspg' => array(
                                                    'field_unit' => "substr(kode_unit_subunit,1,2)",
                                                    'field_tanggal' => "tanggal",
                                                ),
                                );

        $array_spec_uraian = array(
                                    'GUP' => "AND untuk_bayar != 'GUP NIHIL'",
                                    'GP' => "AND untuk_bayar != 'GUP NIHIL'",
                                    'GUP_NIHIL' => "AND untuk_bayar = 'GUP NIHIL'",
                                );

        $array_assoc_spm = $this->Spm_model->get_tabel_assoc_spm();        

        echo "<pre>";
        $data = array();
        foreach ($jenis_all as $jenis) {
            // BLOK KODE AMBIL SEMUA SPM TRANSAKSI BERKUITANSI
            if (in_array($jenis, $jenis_kuitansi)){
                $spec_jenis = $array_spec_jenis['kuitansi'];
                extract($spec_jenis);
                $added_query = '';
                if (!isset($unit)){
                    $added_query = '';
                }else{
                    $added_query .= " AND $field_unit='$unit' ";
                }

                if ($periode_akhir != null){
                    $added_query .= " AND ($field_tanggal BETWEEN '$periode_awal' AND '$periode_akhir') ";
                }

                if (isset($array_spec_uraian[$jenis])){
                    $added_query .= $array_spec_uraian[$jenis];   
                }

                $tabel_assoc = $array_assoc_spm[$jenis];

                $query = "  SELECT 
                                str_nomor_trx_spm as nomor_spm,
                                tgl_spm as tanggal,
                                sum(volume*harga_satuan) as nominal_rsa
                                -- sum(jumlah_debet) as nominal_siak
                            FROM 
                                rsa_kuitansi,
                                rsa_kuitansi_detail,
                                -- akuntansi_kuitansi_jadi,
                                $tabel_assoc 
                            WHERE 1 AND
                                rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi AND
                                rsa_kuitansi.str_nomor_trx_spm = $tabel_assoc.str_nomor_trx AND
                                -- rsa_kuitansi.str_nomor_trx_spm = akuntansi_kuitansi_jadi.no_spm AND
                                rsa_kuitansi.cair = 1
                                $added_query 
                            GROUP BY str_nomor_trx_spm
                ";


                $result = $this->db->query($query)->result_array();

                foreach ($result as $index => $each_result) {
                    $no_spm = $each_result['nomor_spm'];
                    $query = "
                                SELECT 
                                    sum(jumlah_debet) as jumlah
                                FROM    
                                    akuntansi_kuitansi_jadi
                                WHERE 
                                    jenis='$jenis' AND
                                    no_spm = '$no_spm'
                            ";
                    $result[$index]['nominal_siak'] = $this->db->query($query)->row_array()['jumlah'];
                    $result[$index]['selisih'] = $result[$index]['nominal_siak'] - $result[$index]['nominal_rsa'];
                    // if ($result[$index]['selisih'] == 0){
                    //     unset($result[$index]);
                    // }
                }
                $data = array_merge($data,$result);
            }
        }

        print_r($data);
        die();



        

        if($this->input->post('unit')==null or $this->input->post('unit')=='all'){
            $filter_unit_gu = '';
            $filter_unit_up = '';
            $filter_unit_gup = '';
            $filter_unit_pup = '';
            $filter_unit_tup = '';
            $filter_unit_ls3 = '';
            $filter_unit_lsphk3 = '';
            $filter_unit_lspg = '';

            if($this->input->post('unit')=='all'){
                $kode_unit = $this->input->post('unit');
                $this->data['kode_unit'] = $kode_unit;
            }
        }else{   
            $kode_unit = $this->input->post('unit');
            $this->data['kode_unit'] = $kode_unit;        
            $filter_unit_gu = "AND substr(trx_gup.kode_unit_subunit,1,2)='".$kode_unit."'";
            $filter_unit_up = "AND substr(trx_up.kode_unit_subunit,1,2)='".$kode_unit."'";
            $filter_unit_gup = "AND substr(kode_unit,1,2)='".$kode_unit."'";
            $filter_unit_pup = "AND substr(trx_pup.kode_unit_subunit,1,2)='".$kode_unit."'";
            $filter_unit_tup = "AND substr(trx_tup.kode_unit_subunit,1,2)='".$kode_unit."'";
            $filter_unit_lsphk3 = "AND substr(trx_lsphk3.kode_unit_subunit,1,2)='".$kode_unit."'";
            $filter_unit_ls3 = "AND substr(tk.kode_unit,1,2)='".$kode_unit."'";
            $filter_unit_lspg = "AND P.unitsukpa=".$kode_unit."";
        }

        if($this->input->post('daterange')!=null){
            $daterange = $this->input->post('daterange');
            $date_t = explode(' - ', $daterange);
            $periode_awal = strtodate($date_t[0]);
            $periode_akhir = strtodate($date_t[1]);
            $this->data['periode'] = $daterange;
            $this->data['teks_periode'] = "Periode " . $daterange;
            $filter_periode = "AND (tgl_spm BETWEEN '$periode_awal' AND '$periode_akhir')";
            $filter_periode_lspg = "AND (S.tanggal BETWEEN '$periode_awal' AND '$periode_akhir')";
            $filter_periode_ls3 = "AND (ts.tgl_spm BETWEEN '$periode_awal' AND '$periode_akhir')";

        }else{
            $periode_awal = null;
            $periode_akhir = null;
            $this->data['periode'] = 'Semua Periode';
            $this->data['teks_periode'] = 'Semua Periode';
            $filter_periode = "";
            $filter_periode_lspg = "";
            $filter_periode_ls3 = "";
        }

        //up
        $this->data['up'] = $this->db->query("SELECT * FROM trx_spm_up_data, trx_up, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_up_spm AND posisi='SPM-FINAL-KBUU' AND no_spm = str_nomor_trx
            $filter_unit_up $filter_periode");

        //gu
        $this->data['gu'] = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND untuk_bayar !='GUP NIHIL' AND posisi='SPM-FINAL-KBUU' AND no_spm = str_nomor_trx AND kredit=0 
            $filter_unit_gu $filter_periode");
        // gu
        // $this->data['gu'] = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND uraian !='GUP NIHIL' AND posisi='SPM-FINAL-KBUU' AND no_spm = str_nomor_trx AND kredit=0 
        //     $filter_unit_gu $filter_periode");

        //pup
        $this->data['pup'] = $this->db->query("SELECT * FROM trx_spm_pup_data, trx_pup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_pup_spm AND posisi='SPM-FINAL-KBUU' AND no_spm = str_nomor_trx 
            $filter_unit_pup $filter_periode");

        //tup
        $this->data['tup'] = $this->db->query("SELECT * FROM trx_spm_tup_data, trx_tup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_tup_spm AND posisi='SPM-FINAL-KBUU' AND no_spm = str_nomor_trx
            $filter_unit_tup $filter_periode");

        //ls3
        $this->data['ls3'] = $this->db->query("SELECT * FROM trx_spm_lsphk3_data, trx_lsphk3, (select id_kuitansi, kode_akun, uraian, no_bukti, cair from rsa_kuitansi_lsphk3) as  rsa_kuitansi_lsphk3 WHERE id_trx_spm_lsphk3_data = id_trx_nomor_lsphk3 AND posisi='SPM-FINAL-KBUU' AND trx_lsphk3.id_kuitansi = rsa_kuitansi_lsphk3.id_kuitansi AND trx_spm_lsphk3_data.flag_proses_akuntansi=0 AND rsa_kuitansi_lsphk3.cair = 1 
            AND FALSE
            $filter_unit_lsphk3 $filter_periode");

        $this->data['lk'] = $this->db->query("
                    SELECT 
                        tk.str_nomor_trx_spm as no_spm,
                        tk.str_nomor_trx as no_spp,
                        tk.id_kuitansi,
                        ts.untuk_bayar,
                        ts.tgl_spm as tgl_proses,
                        if (count(case when cair = 1 then 1 else null end) = count(case when flag_proses_akuntansi = 1 then 1 else null end),1,0) as flag_proses_akuntansi, 
                        SUM(td.volume * td.harga_satuan) as jumlah_bayar 
                    FROM 
                        rsa_kuitansi as tk, rsa_kuitansi_detail as td, trx_spm_lsk_data as ts, trx_lsk as th
                    WHERE 
                        tk.id_kuitansi = td.id_kuitansi 
                        AND ts.str_nomor_trx = tk.str_nomor_trx_spm
                        AND ts.nomor_trx_spm = th.id_trx_nomor_lsk_spm 
                        AND th.posisi = 'SPM-FINAL-KBUU'
                        AND jenis='LK' 
                        $filter_unit_ls3
                        $filter_periode_ls3
                    GROUP BY tk.str_nomor_trx_spm
        ");

        $this->data['ln'] = $this->db->query("
                    SELECT 
                        tk.str_nomor_trx_spm as no_spm,
                        tk.str_nomor_trx as no_spp,
                        tk.id_kuitansi,
                        ts.untuk_bayar,
                        ts.tgl_spm as tgl_proses,
                        if (count(case when cair = 1 then 1 else null end) = count(case when flag_proses_akuntansi = 1 then 1 else null end),1,0) as flag_proses_akuntansi, 
                        SUM(td.volume * td.harga_satuan) as jumlah_bayar 
                    FROM 
                        rsa_kuitansi as tk, rsa_kuitansi_detail as td, trx_spm_lsnk_data as ts, trx_lsnk as th
                    WHERE 
                        tk.id_kuitansi = td.id_kuitansi 
                        AND ts.str_nomor_trx = tk.str_nomor_trx_spm
                        AND ts.nomor_trx_spm = th.id_trx_nomor_lsnk_spm 
                        AND th.posisi = 'SPM-FINAL-KBUU'
                        AND jenis='LN' 
                        $filter_unit_ls3
                        $filter_periode_ls3
                    GROUP BY tk.str_nomor_trx_spm
        ");

        //lspg
        $this->data['lspg'] = $this->db->query("SELECT *,S.nomor as nomor FROM kepeg_tr_spmls S, kepeg_tr_sppls P WHERE S.id_tr_sppls=P.id_sppls AND S.proses=5 $filter_unit_lspg $filter_periode_lspg");

        //gup
        //$this->data['gup'] = $this->db->query("SELECT * FROM rsa_kuitansi WHERE cair=1 $filter_unit_gup ORDER BY str_nomor_trx_spm ASC, no_bukti ASC");

        $this->db2 = $this->load->database('rba', true);
        $this->data['query_unit'] = $this->db2->query("SELECT * FROM unit");
        $this->data['array_unit'] = $array_unit;

        if($cetak==null){
            $temp_data['content'] = $this->load->view('akuntansi/rekap_spm',$this->data,true);
            $this->load->view('akuntansi/content_template',$temp_data,false);
        }else{
            $this->load->view('akuntansi/laporan/cetak_rekap_spm',$this->data);
        }
    }
}
