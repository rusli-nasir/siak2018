<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->db_laporan = $this->load->database('laporan',TRUE);
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
    }

    function read_buku_besar_group($group = null){
        $query = $this->db_laporan->query("SELECT * FROM akuntansi_kuitansi_jadi GROUP BY $group");
        return $query;
    }

    function read_buku_besar_akun_group($group = null,$akun = null,$sumber_dana=null,$start_date=null,$end_date=null){

        $this->db_laporan
            ->where("tipe != 'memorial' AND tipe != 'jurnal_umum'")
            ->group_by($group);

        if ($akun != null){
            $this->db_laporan->like($group,$akun,'after');
        }

        if ($sumber_dana != null){
            $this->db_laporan->where('jenis_pembatasan_dana',$sumber_dana);
        }

        if ($start_date != null and $end_date != null){
            $this->db_laporan->where("(tanggal BETWEEN $start_date AND $end_date)");
        }


        $query = $this->db_laporan->get('akuntansi_kuitansi_jadi')->result_array();
        // $query = $this->db_laporan->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE $group LIKE '$akun%' AND tipe<>'memorial' AND tipe<>'jurnal_umum' GROUP BY $group")->result_array();
        return $query;
    }

    public function get_relasi_kuitansi_akun($id_kuitansi_jadi,$tipe,$jenis)
    {
        return $this->db_laporan->get_where('akuntansi_relasi_kuitansi_akun',array('id_kuitansi_jadi' => $id_kuitansi_jadi,'tipe' => $tipe, 'jenis' => $jenis))->result_array();
    }



    public function get_akun_tabel_utama($array_akun=null,$jenis=null,$sumber_dana=null,$start_date=null,$end_date=null){
        $array_tipe  = array('debet','kredit');

        $jenis = array();
        if ($jenis == null){
            $array_jenis = array('akrual','kas');
        }else {
            $array_jenis[] = $jenis;
        }

        $kolom = array(
                'debet' => array(
                        'kas' => 'akun_debet',
                        'akrual' => 'akun_debet_akrual',
                    ),
                'kredit' => array(
                        'kas' => 'akun_kredit',
                        'akrual' => 'akun_kredit_akrual'
                    ),
            );

        $data = array();
        foreach ($array_tipe as $tipe) {
            foreach ($array_jenis as $jenis) {
                foreach ($array_akun as $akun) {
                    $query = $this->read_buku_besar_akun_group($kolom[$tipe][$jenis],$akun);
                    foreach ($query as $hasil) {
                        $entry = $hasil;
                        $entry['tipe'] = $tipe;
                        $entry['jenis'] = $jenis;
                        $entry['akun'] = $hasil[$kolom[$tipe][$jenis]];
                        $entry['jumlah'] = $hasil['jumlah_'.$tipe];
                        $entry['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal($entry['tanggal']);
                        $data[] = $entry;
                    }
                }
                
            }
        }

        return ($data);

    }

    public function get_akun_tabel_relasi($array_akun,$jenis=null,$sumber_dana=null,$start_date=null,$end_date=null)
    {
        $data = array();
        foreach ($array_akun as $akun) {
            // $query = $this->db_laporan->query("SELECT * FROM akuntansi_relasi_kuitansi_akun WHERE akun LIKE '$akun%'")->result_array();

            $this->db_laporan->like('akun',$akun,'after');  

            if ($sumber_dana != null){
                $this->db_laporan->where('jenis_pembatasan_dana',$sumber_dana);
            }

            if ($start_date != null and $end_date != null){
                $this->db_laporan->where("(tanggal BETWEEN $start_date AND $end_date)");
            }

            if ($jenis != null){
                $this->db_laporan->where('jenis',$jenis);
            }


            $query = $this->db_laporan->get('akuntansi_relasi_kuitansi_akun')->result_array();
            // print_r($query);die();
            foreach ($query as $hasil) {
                $entry = array();
                $entry = $this->db_laporan->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' =>$hasil['id_kuitansi_jadi']))->row_array();
                $entry = array_merge($entry,$hasil);
                $entry['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal($entry['tanggal']);
                $data[] = $entry;
            }
            
        }
        return ($data);
    }

    public function get_data_buku_besar($array_akun)
    {
        $tabel_relasi = $this->Laporan_model->get_akun_tabel_relasi($array_akun);
        $tabel_utama = $this->Laporan_model->get_akun_tabel_utama($array_akun);

        $hasil = array_merge($tabel_utama,$tabel_relasi);

        $data = array();
        foreach ($hasil as $entry) {
            $data[$entry['akun']][] = $entry;
        }

        return $data;
    }

    // kode_akun = 123
    // tipe = debet
    // jenis = akrual
    // jumlah  = 1234
}