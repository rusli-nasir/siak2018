<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jurnal_rsa_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->load->model('akuntansi/Spm_model', 'Spm_model');
    }

    public function get_rekening_by_unit($kode_unit){
        $query = $this->db->query("SELECT * FROM akuntansi_aset_6 WHERE (kode_unit='".$kode_unit."' OR kode_unit='all')");
        return $query;
    }

    public function get_sole_rekening_of_unit($kode_unit){
        $query = $this->db->query("SELECT * FROM akuntansi_aset_6 WHERE (kode_unit='".$kode_unit."')");
        return $query;
    }

    public function get_akun_sal_by_unit($kode_unit)
    {
        $this->db->where('kode_unit',$kode_unit);

        return $this->db->get('akuntansi_sal_6')->row_array();
    }

    public function get_akun_sal_by_jenis($jenis,$tipe)
    {
        
    }

    public function get_akun_invalid(){
        $kuitansi_jadi = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE tipe<>'pajak' AND status='proses' AND unit_kerja = '{$this->session->userdata('kode_unit')}'")->result_array();  
        $akun_belanja_invalid = $this->db2->query("SELECT DISTINCT kode_akun,nama_akun FROM `akun_belanja` WHERE `nama_akun` LIKE '[ JANGAN%'")->result_array();
        foreach ($kuitansi_jadi as $key => $value) {
            foreach ($akun_belanja_invalid as $values) {
                if ($value['akun_debet'] == $values['kode_akun']) {
                    $arr_invalid[] = $value;
                }
            }
        }    
        return $arr_invalid;
    }

    public function check_kuitansi_exist($check)
    {
        // $this->db->where($check);
        // $this->db->from('akuntansi_kuitansi_jadi');
        // echo $this->db->get_compiled_select();die();
        return $this->db->get_where('akuntansi_kuitansi_jadi',$check)->num_rows() > 0;
    }

    public function get_kuitansi($id_kuitansi,$tabel,$tabel_detail,$jenis = null)
    {
        $hasil = $this->db->get_where($tabel,array('id_kuitansi'=>$id_kuitansi))->row_array();

        $hasil['kode_akun'] = $this->db->query('SELECT SUBSTR(kode_usulan_belanja,-6) as kode_akun FROM rsa_kuitansi_detail WHERE id_kuitansi='.$hasil['id_kuitansi'])->row_array()['kode_akun'];
        $hasil['kode_usulan_belanja'] = $this->db->query('SELECT kode_usulan_belanja FROM rsa_kuitansi_detail WHERE id_kuitansi='.$hasil['id_kuitansi'])->row_array()['kode_usulan_belanja'];


        $hasil['kode_unit'] = substr($hasil['kode_unit'], 0,2);
        $hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$hasil['kode_unit']))->row_array()['nama_unit'];
        $hasil['tanggal_bukti'] = $this->reKonversiTanggal(date('Y-m-d', strtotime($hasil['tgl_kuitansi'])));
        $tgl = strtotime($this->Spm_model->get_tanggal_spm($hasil['str_nomor_trx_spm'],$jenis));
        // print_r($hasil['str_nomor_trx_spm']);die();
        $hasil['tanggal'] = $this->reKonversiTanggal(date('Y-m-d', $tgl));

        if ($jenis == 'TUP_NIHIL') {
           $hasil['jenis'] = $jenis;
        }

        $hasil['akun_debet_kas'] = $hasil['kode_akun'] . " - ". $this->db->get_where('akun_belanja',array('kode_akun'=>$hasil['kode_akun']))->row_array()['nama_akun'];

        $query = "SELECT SUM(rsa_2018.$tabel_detail.volume*rsa_2018.$tabel_detail.harga_satuan) AS pengeluaran FROM $tabel,$tabel_detail WHERE $tabel.id_kuitansi = $tabel_detail.id_kuitansi AND $tabel.id_kuitansi=$id_kuitansi GROUP BY rsa_2018.$tabel.id_kuitansi";
        $hasil['pengeluaran'] = number_format($this->db->query($query)->row_array()['pengeluaran'],2,',','.');

        // echo "<pre>";

        // print_r($tgl);
        // print_r($tabel_detail);

        // die($jenis);

        return $hasil;
    }

    public function get_kuitansi_tup_pengembalian($id_kuitansi)
    {
        $tabel = 'rsa_kuitansi_pengembalian';
        $tabel_detail = 'rsa_kuitansi_detail_pengembalian';
        $jenis = "TUP_PENGEMBALIAN";

        $hasil = $this->db->get_where($tabel,array('id_kuitansi'=>$id_kuitansi))->row_array();

        $hasil['kode_akun'] = $this->db->query("SELECT SUBSTR(kode_usulan_belanja,-6) as kode_akun FROM $tabel_detail WHERE id_kuitansi=".$hasil['id_kuitansi'])->row_array()['kode_akun'];
        $hasil['kode_usulan_belanja'] = $this->db->query("SELECT kode_usulan_belanja FROM $tabel_detail WHERE id_kuitansi=".$hasil['id_kuitansi'])->row_array()['kode_usulan_belanja'];

        $hasil['kode_unit'] = substr($hasil['kode_unit'], 0,2);
        $hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$hasil['kode_unit']))->row_array()['nama_unit'];
        $hasil['tanggal_bukti'] = $this->reKonversiTanggal(date('Y-m-d', strtotime($hasil['tgl_kuitansi'])));
        $tgl = strtotime($this->Spm_model->get_tanggal_spm($hasil['str_nomor_trx_spm'],$jenis));
        // print_r($tgl);die();
        $hasil['tanggal'] = $this->reKonversiTanggal(date('Y-m-d', $tgl));

        $hasil['jenis'] = $jenis;

        $hasil['akun_debet_kas'] = $hasil['kode_akun'] . " - ". $this->db->get_where('akun_belanja',array('kode_akun'=>$hasil['kode_akun']))->row_array()['nama_akun'];

        $query = "SELECT SUM(rsa_2018.$tabel_detail.volume*rsa_2018.$tabel_detail.harga_satuan) AS pengeluaran FROM $tabel,$tabel_detail WHERE $tabel.id_kuitansi = $tabel_detail.id_kuitansi AND $tabel.id_kuitansi=$id_kuitansi GROUP BY rsa_2018.$tabel.id_kuitansi";
        $hasil['pengeluaran'] = number_format($this->db->query($query)->row_array()['pengeluaran'],2,',','.');


        // print_r($hasil);
        // print_r($tabel_detail);

        // die($jenis);

        return $hasil;
    }

    public function get_kuitansi_pengembalian($id_kuitansi,$jenis)
    {
        $tabel = 'rsa_kuitansi_pengembalian';
        $tabel_detail = 'rsa_kuitansi_detail_pengembalian';

        $hasil = $this->db->get_where($tabel,array('id_kuitansi'=>$id_kuitansi))->row_array();

        $hasil['kode_akun'] = $this->db->query('SELECT SUBSTR(kode_usulan_belanja,-6) as kode_akun FROM $tabel_detail WHERE id_kuitansi='.$hasil['id_kuitansi'])->row_array()['kode_akun'];
        $hasil['kode_usulan_belanja'] = $this->db->query('SELECT kode_usulan_belanja FROM $tabel_detail WHERE id_kuitansi='.$hasil['id_kuitansi'])->row_array()['kode_usulan_belanja'];



        $hasil['kode_unit'] = substr($hasil['kode_unit'], 0,2);
        $hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$hasil['kode_unit']))->row_array()['nama_unit'];
        $hasil['tanggal_bukti'] = $this->reKonversiTanggal(date('Y-m-d', strtotime($hasil['tgl_kuitansi'])));
        $tgl = strtotime($this->Spm_model->get_tanggal_spm($hasil['str_nomor_trx_spm'],$jenis));
        // print_r($tgl);die();
        $hasil['tanggal'] = $this->reKonversiTanggal(date('Y-m-d', $tgl));

        $hasil['jenis'] = $jenis;

        $hasil['akun_debet_kas'] = $hasil['kode_akun'] . " - ". $this->db->get_where('akun_belanja',array('kode_akun'=>$hasil['kode_akun']))->row_array()['nama_akun'];

        $query = "SELECT SUM(rsa_2018.$tabel_detail.volume*rsa_2018.$tabel_detail.harga_satuan) AS pengeluaran FROM $tabel,$tabel_detail WHERE $tabel.id_kuitansi = $tabel_detail.id_kuitansi AND $tabel.id_kuitansi=$id_kuitansi GROUP BY rsa_2018.$tabel.id_kuitansi";
        $hasil['pengeluaran'] = number_format($this->db->query($query)->row_array()['pengeluaran'],2,',','.');

        // print_r($hasil);
        // print_r($tabel_detail);

        // die($jenis);

        return $hasil;
    }

    public function get_kuitansi_lsnk($id_kuitansi)
    {
        $tabel = 'rsa_kuitansi';
        $tabel_detail = 'rsa_kuitansi_detail';
        $jenis = "LN";

        $hasil = $this->db->get_where($tabel,array('id_kuitansi'=>$id_kuitansi))->row_array();



        $hasil['kode_unit'] = substr($hasil['kode_unit'], 0,2);
        $hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$hasil['kode_unit']))->row_array()['nama_unit'];
        $hasil['tanggal_bukti'] = $this->reKonversiTanggal(date('Y-m-d', strtotime($hasil['tgl_kuitansi'])));
        $tgl = strtotime($this->Spm_model->get_tanggal_spm($hasil['str_nomor_trx_spm'],$jenis));
        // print_r($tgl);die();
        $hasil['tanggal'] = $this->reKonversiTanggal(date('Y-m-d', $tgl));

        $hasil['jenis'] = $jenis;

        $hasil['akun_debet_kas'] = $hasil['kode_akun'] . " - ". $this->db->get_where('akun_belanja',array('kode_akun'=>$hasil['kode_akun']))->row_array()['nama_akun'];

        $query = "SELECT SUM(rsa_2018.$tabel_detail.volume*rsa_2018.$tabel_detail.harga_satuan) AS pengeluaran FROM $tabel,$tabel_detail WHERE $tabel.id_kuitansi = $tabel_detail.id_kuitansi AND $tabel.id_kuitansi=$id_kuitansi GROUP BY rsa_2018.$tabel.id_kuitansi";
        $hasil['pengeluaran'] = number_format($this->db->query($query)->row_array()['pengeluaran'],2,',','.');

        // print_r($hasil);
        // print_r($tabel_detail);

        // die($jenis);

        return $hasil;
    }

    public function get_kuitansi_lsk($id_kuitansi)
    {
        $tabel = 'rsa_kuitansi';
        $tabel_detail = 'rsa_kuitansi_detail';
        $jenis = "LK";

        $hasil = $this->db->get_where($tabel,array('id_kuitansi'=>$id_kuitansi))->row_array();



        $hasil['kode_unit'] = substr($hasil['kode_unit'], 0,2);
    	$hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$hasil['kode_unit']))->row_array()['nama_unit'];
        $hasil['tanggal_bukti'] = $this->reKonversiTanggal(date('Y-m-d', strtotime($hasil['tgl_kuitansi'])));
        $tgl = strtotime($this->Spm_model->get_tanggal_spm($hasil['str_nomor_trx_spm'],$jenis));
        // print_r($tgl);die();
        $hasil['tanggal'] = $this->reKonversiTanggal(date('Y-m-d', $tgl));

        $hasil['jenis'] = $jenis;

    	$hasil['akun_debet_kas'] = $hasil['kode_akun'] . " - ". $this->db->get_where('akun_belanja',array('kode_akun'=>$hasil['kode_akun']))->row_array()['nama_akun'];

    	$query = "SELECT SUM(rsa_2018.$tabel_detail.volume*rsa_2018.$tabel_detail.harga_satuan) AS pengeluaran FROM $tabel,$tabel_detail WHERE $tabel.id_kuitansi = $tabel_detail.id_kuitansi AND $tabel.id_kuitansi=$id_kuitansi GROUP BY rsa_2018.$tabel.id_kuitansi";
    	$hasil['pengeluaran'] = number_format($this->db->query($query)->row_array()['pengeluaran'],2,',','.');

        // print_r($hasil);
        // print_r($tabel_detail);
// 
        // die($jenis);

    	return $hasil;
    }

    public function get_akun_kas_mandiri()
    {
        return $this->db->get_where('akuntansi_aset_6',array('akun_6' => '111148'));
    }

    public function get_jenis_pembatasan_dana($id_kuitansi,$tabel)
    {
        $jenis = $this->db->get_where($tabel,array('id_kuitansi'=>$id_kuitansi))->row_array()['sumber_dana'];

        if ($jenis == 'SELAIN-APBN' or $jenis == 'SPI-SILPA'){
            return 'tidak_terikat';
        } elseif ($jenis == 'APBN-BPPTNBH' or $jenis == 'APBN-LAINNYA') {  
            return 'terikat_temporer';
        }elseif ($jenis =='DANA-ABADI' ) {
            return 'terikat_permanen';
        }
    }


    public function reKonversiTanggal($value = null)
	{
		if ($value == null){
			return "";
		}
		$perkata = explode('-', $value);
		$daftar['01'] = 'Januari';
		$daftar['02'] = 'Februari';
		$daftar['03'] = 'Maret';
		$daftar['04'] = 'April';
		$daftar['05'] = 'Mei';
		$daftar['06'] = 'Juni';
		$daftar['07'] = 'Juli';
		$daftar['08'] = 'Agustus';
		$daftar['09'] = 'September';
		$daftar['10'] = 'Oktober';
		$daftar['11'] = 'November';
		$daftar['12'] = 'Desember';
		return $perkata[2]." ".$daftar[$perkata[1]]." ".$perkata[0];
	}

    public function get_view_jenis($value)
    {
        $array_tampil = array(
                            'NK' => 'LS-PGW',
                            'GP' => 'GUP',
                            'GUP' => 'GU',
                            'LK' => 'LS-Kontrak',
                            'LN' => 'LS-Non Kontrak'
                        );

        foreach ($array_tampil as $key => $tampil) {
            if ($value == $key)
                return $tampil;
        }
        return $value;

    }

	
	function get_data_kuitansi($id_kuitansi){
        $str = "SELECT rsa_2018.rsa_kuitansi.tgl_kuitansi,rsa_2018.rsa_kuitansi.tahun,rsa_2018.rsa_kuitansi.no_bukti,"
                . "rba_2018.akun_belanja.nama_akun,"
                . "SUM(rsa_2018.rsa_kuitansi_detail.volume*rsa_2018.rsa_kuitansi_detail.harga_satuan) AS pengeluaran,"
                . "rsa_2018.rsa_kuitansi.uraian,rba_2018.subkomponen_input.nama_subkomponen,"
                . "rsa_2018.rsa_kuitansi.penerima_uang,rsa_2018.rsa_kuitansi.penerima_uang_nip,rsa_2018.rsa_kuitansi.penerima_barang,rsa_2018.rsa_kuitansi.penerima_barang_nip,"
                . "rsa_2018.rsa_kuitansi.nmpppk,rsa_2018.rsa_kuitansi.nippppk,rsa_2018.rsa_kuitansi.nmbendahara,rsa_2018.rsa_kuitansi.nipbendahara,rsa_2018.rsa_kuitansi.nmpumk,rsa_2018.rsa_kuitansi.nippumk,rsa_2018.rsa_kuitansi.penerima_uang,rsa_2018.rsa_kuitansi.aktif,rsa_2018.rsa_kuitansi.str_nomor_trx "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail "
                . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "JOIN rba_2018.akun_belanja ON rba_2018.akun_belanja.kode_akun5digit = rsa_2018.rsa_kuitansi.kode_akun5digit "
                . "AND rba_2018.akun_belanja.kode_akun = rsa_2018.rsa_kuitansi.kode_akun "
                . "AND rba_2018.akun_belanja.sumber_dana = rsa_2018.rsa_kuitansi.sumber_dana "
                . "JOIN rba_2018.subkomponen_input ON rba_2018.subkomponen_input.kode_kegiatan = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,2) "
                . "AND rba_2018.subkomponen_input.kode_output = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,9,2) "
                . "AND rba_2018.subkomponen_input.kode_program = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,11,2) "
                . "AND rba_2018.subkomponen_input.kode_komponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,13,2) "
                . "AND rba_2018.subkomponen_input.kode_subkomponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,15,2) "
                . "LEFT JOIN rsa_2018.rsa_kuitansi_detail_pajak "
                . "ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                . "WHERE rsa_2018.rsa_kuitansi.id_kuitansi = '{$id_kuitansi}' "
                . "GROUP BY rsa_2018.rsa_kuitansi.id_kuitansi";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
//                    var_dump($q->row());die;
                   return $q->row();
                }else{
                    return '';
                }
    }

    function get_data_detail_kuitansi($id_kuitansi){
        $str = "SELECT rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail,rsa_2018.rsa_kuitansi_detail.deskripsi,rsa_2018.rsa_kuitansi_detail.volume,"
                . "rsa_2018.rsa_kuitansi_detail.satuan,rsa_2018.rsa_kuitansi_detail.harga_satuan,(rsa_2018.rsa_kuitansi_detail.volume * rsa_2018.rsa_kuitansi_detail.harga_satuan) AS bruto "
                . "" //,GROUP_CONCAT(rsa_kuitansi_detail_pajak.jenis_pajak SEPARATOR '<br>') AS pajak_nom "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail "
                . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "LEFT JOIN rsa_2018.rsa_kuitansi_detail_pajak "
                . "ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                . "WHERE rsa_2018.rsa_kuitansi.id_kuitansi = '{$id_kuitansi}' "
                . "GROUP BY rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){

                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_data_detail_pajak_kuitansi($id_kuitansi){
        $str = "SELECT rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail,rsa_2018.rsa_kuitansi_detail_pajak.jenis_pajak,rsa_2018.rsa_kuitansi_detail_pajak.persen_pajak,"
                . "rsa_2018.rsa_kuitansi_detail_pajak.dpp,rsa_2018.rsa_kuitansi_detail_pajak.rupiah_pajak "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail "
                . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail_pajak "
                . "ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                . "WHERE rsa_2018.rsa_kuitansi.id_kuitansi = '{$id_kuitansi}' "
                . "GROUP BY rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail_pajak";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }
}