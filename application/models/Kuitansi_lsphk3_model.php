<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Kuitansi_lsphk3_model extends CI_Model{
/* -------------- Constructor ------------- */
    public function __construct()
    {
            parent::__construct();
    }
    function get_kuitansi_id($data){
        //$pekerjaan = 0 ;
        foreach($data['array_id'] as $id){
            $str = "SELECT * FROM rsa_kuitansi_lsphk3 WHERE id_kuitansi = '{$id}' ";

           //var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }
        }

        //return $pekerjaan;
    }
    function insert_data_kuitansi($data){

        $this->db->insert('rsa_kuitansi_lsphk3',$data);

        //$customerID=$db->insert_id;
        $q = $this->db->query("SELECT MAX(id_kuitansi) AS id_k FROM rsa_kuitansi_lsphk3 WHERE kode_unit='{$data['kode_unit']}' AND tahun='{$data['tahun']}' AND sumber_dana='{$data['sumber_dana']}'");
        $row = $q->row();

        return $row->id_k;
    }

    function insert_data_usulan($data){

        $this->db->insert('rsa_kuitansi_detail_lsphk3',$data);

        //$customerID=$db->insert_id;
        $q = $this->db->query("SELECT MAX(id_kuitansi_detail) AS id_k FROM rsa_kuitansi_detail_lsphk3 WHERE id_kuitansi='{$data['id_kuitansi']}' AND kode_usulan_belanja='{$data['kode_usulan_belanja']}' ");
        $row = $q->row();

        return $row->id_k;
    }

    function insert_data_pajak($data){
//        var_dump($data);die;
        $this->db->insert('rsa_kuitansi_detail_pajak_lsphk3',$data);

    }

    function get_next_id($data){
        //echo  "SELECT IFNULL(MAX(RIGHT(no_bukti,5)),0) AS next_no_bukti FROM rsa_kuitansi WHERE LEFT(no_bukti,3) = '{$data['alias']}' AND tahun = '{$data['tahun']}' "; exit;
//        $q = $this->db->query("SELECT IFNULL(MAX(RIGHT(no_bukti,5)),0) AS next_no_bukti FROM rsa_kuitansi WHERE LEFT(no_bukti,3) = '{$data['alias']}' AND jenis = '{$data['jenis']}' AND sumber_dana = '{$data['sumber_dana']}' AND tahun = '{$data['tahun']}'");
        $q = $this->db->query("SELECT IFNULL(MAX(RIGHT(no_bukti,5)),0) AS next_no_bukti FROM rsa_kuitansi_lsphk3 WHERE LEFT(no_bukti,3) = '{$data['alias']}' AND tahun = '{$data['tahun']}' ");
        $row = $q->row();

        $x = intval($row->next_no_bukti) + 1;
        if(strlen($x)==1){
                        $x = '0000'.$x;
        }
        elseif(strlen($x)==2){
                        $x = '000'.$x;
        }
        elseif(strlen($x)==3){
                        $x = '00'.$x;
        }
        elseif(strlen($x)==4){
                        $x = '0'.$x;
        }
        elseif(strlen($x)==5){
                        $x = $x;
        }

        return $data['alias'].$x;

    }

    function get_kuitansi($jenis,$kode_unit_subunit,$tahun){
//        $kode_unit_subunit = substr($kode_unit_subunit,0,2);
        $lenunit = strlen($kode_unit_subunit);
        $str1 = "SELECT rsa.rsa_kuitansi_lsphk3.id_kuitansi,rsa.rsa_kuitansi_lsphk3.tgl_kuitansi,rba.akun_belanja.nama_akun5digit,"
                . "rsa.rsa_kuitansi_lsphk3.kode_akun5digit,rsa.rsa_kuitansi_detail_lsphk3.kode_akun_tambah,"
                . "rsa.rsa_kuitansi_lsphk3.no_bukti,"
                . "SUM(rsa.rsa_kuitansi_detail_lsphk3.volume*rsa.rsa_kuitansi_detail_lsphk3.harga_satuan) AS pengeluaran,"
                . "rsa.rsa_kuitansi_lsphk3.uraian,"
                . "SUM(rsa.rsa_kuitansi_detail_pajak_lsphk3.rupiah_pajak) AS potongan,rsa.rsa_kuitansi_lsphk3.aktif,rsa.rsa_kuitansi_lsphk3.str_nomor_trx,rsa.rsa_kuitansi_lsphk3.cair "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "JOIN rba.akun_belanja ON rba.akun_belanja.kode_akun5digit = rsa.rsa_kuitansi_lsphk3.kode_akun5digit "
                . "AND rba.akun_belanja.kode_akun = rsa.rsa_kuitansi_lsphk3.kode_akun "
                . "AND rba.akun_belanja.sumber_dana = rsa.rsa_kuitansi_lsphk3.sumber_dana "
                . "JOIN rsa.rsa_kuitansi_detail_pajak_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_pajak_lsphk3.id_kuitansi_detail = rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail "
                . "WHERE LEFT(rsa.rsa_kuitansi_lsphk3.kode_unit,2) = '{$kode_unit_subunit}' "
                . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$tahun}' "
                . "AND rsa.rsa_kuitansi_lsphk3.jenis = '{$jenis}' "
                . "GROUP BY rsa.rsa_kuitansi_lsphk3.id_kuitansi";

        $str = "SELECT rsa.rsa_kuitansi_lsphk3.id_kuitansi,rsa.rsa_kuitansi_lsphk3.no_bukti,"
                . "rsa.rsa_kuitansi_lsphk3.tgl_kuitansi,rsa.rsa_kuitansi_lsphk3.uraian,"
                . "SUM(rsa.rsa_kuitansi_detail_lsphk3.volume*rsa.rsa_kuitansi_detail_lsphk3.harga_satuan) AS pengeluaran,"
                . "rsa.rsa_kuitansi_lsphk3.str_nomor_trx,rsa.rsa_kuitansi_lsphk3.str_nomor_trx_spm,rsa.rsa_kuitansi_lsphk3.aktif,rsa.rsa_kuitansi_lsphk3.cair "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail_lsphk3 ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "WHERE LEFT(rsa.rsa_kuitansi_lsphk3.kode_unit,{$lenunit}) = '{$kode_unit_subunit}' AND rsa.rsa_kuitansi_lsphk3.tahun = '{$tahun}' "
                . "AND rsa.rsa_kuitansi_lsphk3.jenis = '{$jenis}' "
                . "GROUP BY rsa.rsa_kuitansi_lsphk3.id_kuitansi";

//        print_r($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
//                    var_dump($q->result());die;
                   return $q->result();
                }else{
                    return '';
                }
    }
    
    function get_kuitansi_own($jenis,$kode_unit_subunit,$tahun){
//        $kode_unit_subunit = substr($kode_unit_subunit,0,2);
//        $lenunit = strlen($kode_unit_subunit);

        $str = "SELECT rsa.rsa_kuitansi_lsphk3.id_kuitansi,rsa.rsa_kuitansi_lsphk3.no_bukti,"
                . "rsa.rsa_kuitansi_lsphk3.tgl_kuitansi,rsa.rsa_kuitansi_lsphk3.uraian,"
                . "SUM(rsa.rsa_kuitansi_detail_lsphk3.volume*rsa.rsa_kuitansi_detail_lsphk3.harga_satuan) AS pengeluaran,"
                . "rsa.rsa_kuitansi_lsphk3.str_nomor_trx,rsa.rsa_kuitansi_lsphk3.aktif,rsa.rsa_kuitansi_lsphk3.cair "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail_lsphk3 ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$kode_unit_subunit}' AND rsa.rsa_kuitansi_lsphk3.tahun = '{$tahun}' "
                . "AND rsa.rsa_kuitansi_lsphk3.jenis = '{$jenis}' "
                . "GROUP BY rsa.rsa_kuitansi_lsphk3.id_kuitansi";

//        print_r($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
//                    var_dump($q->result());die;
                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_kuitansi_detail($jenis,$kode_unit_subunit,$tahun){
        $str = "SELECT rsa.rsa_kuitansi_lsphk3.tgl_kuitansi,rba.akun_belanja.nama_akun5digit,"
                . "rsa.rsa_kuitansi_lsphk3.kode_akun5digit,rsa.rsa_detail_belanja_.kode_akun_tambah,"
                . "rsa.rsa_detail_belanja_.deskripsi,rsa.rsa_kuitansi_lsphk3.no_bukti,"
                . "(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS pengeluaran,"
                . "rsa.rsa_detail_belanja_.volume,rsa.rsa_detail_belanja_.satuan,rsa.rsa_kuitansi_lsphk3.uraian,"
                . "SUM(rsa.rsa_kuitansi_detail_pajak_lsphk3.rupiah_pajak) AS potongan "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "JOIN rsa.rsa_detail_belanja_ "
                . "ON rsa.rsa_detail_belanja_.kode_usulan_belanja = rsa.rsa_kuitansi_detail_lsphk3.kode_usulan_belanja "
                . "AND rsa.rsa_detail_belanja_.kode_akun_tambah = rsa.rsa_kuitansi_detail_lsphk3.kode_akun_tambah "
                . "JOIN rba.akun_belanja ON rba.akun_belanja.kode_akun5digit = rsa.rsa_kuitansi_lsphk3.kode_akun5digit "
                . "AND rba.akun_belanja.kode_akun = rsa.rsa_kuitansi_lsphk3.kode_akun "
                . "AND rba.akun_belanja.sumber_dana = rsa.rsa_kuitansi_lsphk3.sumber_dana "
                . "JOIN rsa.rsa_kuitansi_detail_pajak_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_pajak_lsphk3.id_kuitansi_detail = rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail "
                . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$kode_unit_subunit}' "
                . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$tahun}' "
                . "AND rsa.rsa_kuitansi_lsphk3.jenis = '{$jenis}' "
                . "GROUP BY rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_data_kuitansi($id_kuitansi,$tahun){
        $str = "SELECT rsa.rsa_kuitansi_lsphk3.tgl_kuitansi,rsa.rsa_kuitansi_lsphk3.tahun,rsa.rsa_kuitansi_lsphk3.no_bukti,rsa_kuitansi_lsphk3.jenis,"
                . "rba.akun_belanja.nama_akun,"
                ."SUM(rsa.rsa_kuitansi_detail_lsphk3.volume*rsa.rsa_kuitansi_detail_lsphk3.harga_satuan) AS pengeluaran,"
                . "rsa.rsa_kuitansi_lsphk3.uraian,rba.subkomponen_input.nama_subkomponen,"
                . "rsa.rsa_kuitansi_lsphk3.penerima_uang,rsa.rsa_kuitansi_lsphk3.penerima_barang,rsa.rsa_kuitansi_lsphk3.penerima_barang_nip,"
                . "rsa.rsa_kuitansi_lsphk3.nmpppk,rsa.rsa_kuitansi_lsphk3.nippppk,rsa.rsa_kuitansi_lsphk3.nmbendahara,rsa.rsa_kuitansi_lsphk3.nipbendahara,rsa.rsa_kuitansi_lsphk3.nmpumk,rsa.rsa_kuitansi_lsphk3.nippumk,rsa.rsa_kuitansi_lsphk3.penerima_uang,rsa.rsa_kuitansi_lsphk3.aktif,rsa.rsa_kuitansi_lsphk3.str_nomor_trx "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "JOIN rba.akun_belanja ON rba.akun_belanja.kode_akun5digit = rsa.rsa_kuitansi_lsphk3.kode_akun5digit "
                . "AND rba.akun_belanja.kode_akun = rsa.rsa_kuitansi_lsphk3.kode_akun "
                . "AND rba.akun_belanja.sumber_dana = rsa.rsa_kuitansi_lsphk3.sumber_dana "
                . "JOIN rba.subkomponen_input ON rba.subkomponen_input.kode_kegiatan = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,2) "
                . "AND rba.subkomponen_input.kode_output = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,9,2) "
                . "AND rba.subkomponen_input.kode_program = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,11,2) "
                . "AND rba.subkomponen_input.kode_komponen = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,13,2) "
                . "AND rba.subkomponen_input.kode_subkomponen = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,15,2) "
                . "LEFT JOIN rsa.rsa_kuitansi_detail_pajak_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_pajak_lsphk3.id_kuitansi_detail = rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail "
                . "WHERE rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id_kuitansi}' "
                . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$tahun}' "
                . "GROUP BY rsa.rsa_kuitansi_lsphk3.id_kuitansi";

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

    function get_data_detail_kuitansi($id_kuitansi,$tahun){
        $str = "SELECT rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail,rsa.rsa_kuitansi_detail_lsphk3.deskripsi,rsa.rsa_kuitansi_detail_lsphk3.volume,"
                . "rsa.rsa_kuitansi_detail_lsphk3.satuan,rsa.rsa_kuitansi_detail_lsphk3.harga_satuan,(rsa.rsa_kuitansi_detail_lsphk3.volume * rsa.rsa_kuitansi_detail_lsphk3.harga_satuan) AS bruto "
                . "" //,GROUP_CONCAT(rsa_kuitansi_detail_pajak_lsphk3.jenis_pajak SEPARATOR '<br>') AS pajak_nom "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "LEFT JOIN rsa.rsa_kuitansi_detail_pajak_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_pajak_lsphk3.id_kuitansi_detail = rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail "
                . "WHERE rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id_kuitansi}' "
                . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$tahun}' "
                . "GROUP BY rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){

                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_data_detail_pajak_kuitansi($id_kuitansi,$tahun){
        $str = "SELECT rsa.rsa_kuitansi_detail_pajak_lsphk3.id_kuitansi_detail,rsa.rsa_kuitansi_detail_pajak_lsphk3.jenis_pajak,rsa.rsa_kuitansi_detail_pajak_lsphk3.persen_pajak,"
                . "rsa.rsa_kuitansi_detail_pajak_lsphk3.dpp,rsa.rsa_kuitansi_detail_pajak_lsphk3.rupiah_pajak "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "JOIN rsa.rsa_kuitansi_detail_pajak_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_pajak_lsphk3.id_kuitansi_detail = rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail "
                . "WHERE rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id_kuitansi}' "
                . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$tahun}' "
                . "GROUP BY rsa.rsa_kuitansi_detail_pajak_lsphk3.id_kuitansi_detail_pajak";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }

     function get_rekap_detail_kuitansi($data){

        $str_ = '';
                if(count($data['array_id']) > 1){
                    foreach($data['array_id'] as $id){
                        $str_ .= "rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id}' OR " ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
                }else{
                    $str_ = "rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$data['array_id'][0]}'" ;
                }

        $str = "SELECT SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,10) AS rka,rsa.rsa_kuitansi_lsphk3.no_bukti,rsa.rsa_kuitansi_lsphk3.tgl_kuitansi,rsa.rsa_kuitansi_lsphk3.uraian,rba.akun_belanja.nama_akun,rsa.rsa_kuitansi_lsphk3.kode_akun5digit,rsa.rsa_kuitansi_lsphk3.kode_akun,rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail,rsa.rsa_kuitansi_detail_lsphk3.kode_akun_tambah,rsa.rsa_kuitansi_detail_lsphk3.deskripsi,rsa.rsa_kuitansi_detail_lsphk3.volume,"
                . "rsa.rsa_kuitansi_detail_lsphk3.satuan,rsa.rsa_kuitansi_detail_lsphk3.harga_satuan,(rsa.rsa_kuitansi_detail_lsphk3.volume * rsa.rsa_kuitansi_detail_lsphk3.harga_satuan) AS bruto,"
                . "GROUP_CONCAT(CONCAT(rsa_kuitansi_detail_pajak_lsphk3.jenis_pajak,' [ ',rsa_kuitansi_detail_pajak_lsphk3.persen_pajak,'% ] ') SEPARATOR ',<br>') AS pajak_nom,"
                . "SUM(rsa_kuitansi_detail_pajak_lsphk3.rupiah_pajak) AS total_pajak "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "LEFT JOIN rsa.rsa_kuitansi_detail_pajak_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_pajak_lsphk3.id_kuitansi_detail = rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail "
                . "JOIN rba.akun_belanja ON rba.akun_belanja.kode_akun = rsa.rsa_kuitansi_lsphk3.kode_akun "
                . "AND rba.akun_belanja.sumber_dana = rsa.rsa_kuitansi_lsphk3.sumber_dana "
                . "WHERE rsa.rsa_kuitansi_lsphk3.tahun = '{$data['tahun']}' "
                . "AND ( " . $str_ . " ) "
                . "GROUP BY rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail "
                . "ORDER BY SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,10) ASC,"
                . "rsa.rsa_kuitansi_lsphk3.kode_akun ASC,"
                . "rsa.rsa_kuitansi_detail_lsphk3.kode_akun_tambah ASC,"
                . "rsa.rsa_kuitansi_lsphk3.tgl_kuitansi,"
                . "rsa.rsa_kuitansi_detail_pajak_lsphk3.jenis_pajak ASC";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){

                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_pengeluaran($kode_unit_subunit,$tahun){
        $str = "SELECT  SUM(rsa.rsa_kuitansi_detail_lsphk3.volume*rsa.rsa_kuitansi_detail_lsphk3.harga_satuan) AS pengeluaran "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$kode_unit_subunit}' "
                . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$tahun}' "
                . "AND rsa.rsa_kuitansi_lsphk3.aktif = '1' "
                . "AND rsa.rsa_kuitansi_lsphk3.cair = '0' "
                . "GROUP BY rsa.rsa_kuitansi_lsphk3.kode_unit";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->pengeluaran;
                }else{
                    return 0;
                }
    }

    function get_pengeluaran_by_array_id($data){
        $pengeluaran = 0 ;
        foreach($data['array_id'] as $id){
            $str = "SELECT SUM(rsa.rsa_detail_belanja_.volume*rsa.rsa_detail_belanja_.harga_satuan) AS pengeluaran "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                . "JOIN rsa.rsa_detail_belanja_ "
                . "ON rsa.rsa_detail_belanja_.kode_usulan_belanja = rsa.rsa_kuitansi_detail_lsphk3.kode_usulan_belanja "
                . "AND rsa.rsa_detail_belanja_.kode_akun_tambah = rsa.rsa_kuitansi_detail_lsphk3.kode_akun_tambah "
                . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$data['kode_unit_subunit']}' "
                . "AND rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id}' "
                . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$data['tahun']}' "
                . "GROUP BY rsa.rsa_kuitansi_lsphk3.kode_unit";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   $pengeluaran = $pengeluaran + $q->row()->pengeluaran;
                }
        }

        return $pengeluaran;
    }

    function insert_spp($data){

        $rel_kuitansi = json_decode($data['rel_kuitansi']);

        foreach($rel_kuitansi as $rel){
            $this->db->where('id_kuitansi', $rel);
            $this->db->update('rsa_kuitansi_lsphk3', array('str_nomor_trx'=>$data['str_nomor_trx']));
        }

    }
    
    function insert_spm($data){

        $rel_kuitansi = json_decode($data['rel_kuitansi']);

        foreach($rel_kuitansi as $rel){
            $this->db->where('id_kuitansi', $rel);
            $this->db->update('rsa_kuitansi_lsphk3', array('str_nomor_trx_spm'=>$data['str_nomor_trx_spm']));
        }

    }
    
    function tolak_spp($data){

        $rel_kuitansi = json_decode($data['rel_kuitansi']);

        foreach($rel_kuitansi as $rel){
            $query = "UPDATE rsa_kuitansi_lsphk3 SET str_nomor_trx = NULL WHERE id_kuitansi = '{$rel}'";
            $this->db->query($query);
//            $this->db->where('id_kuitansi', $rel);
//            $this->db->update('rsa_kuitansi', array('str_nomor_trx'=>''));//array('str_nomor_trx'=>$data['str_nomor_trx']));
        }

    }
    
    function tolak_spm($data){

        $rel_kuitansi = json_decode($data['rel_kuitansi']);

        foreach($rel_kuitansi as $rel){
            $query = "UPDATE rsa_kuitansi_lsphk3 SET str_nomor_trx = NULL,str_nomor_trx_spm = NULL WHERE id_kuitansi = '{$rel}'";
            $this->db->query($query);
//            $this->db->where('id_kuitansi', $rel);
//            $this->db->update('rsa_kuitansi_lsphk3', array('str_nomor_trx'=>''));//array('str_nomor_trx'=>$data['str_nomor_trx']));
        }

    }

    function get_pengeluaran_by_akun5digit($data){
//        var_dump($data);die;
                $str_ = '';
                if(count($data['array_id']) > 1){
                    foreach($data['array_id'] as $id){
                        $str_ .= "rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id}' OR " ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
                }else{
                    $str_ = "rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$data['array_id'][0]}'" ;
                }
   //     echo $str_ ; die;
                
                $str = "SELECT SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,10) AS rka,rsa.rsa_kuitansi_lsphk3.id_kuitansi,SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,10) AS kode_usulan_rkat,rba.komponen_input.nama_komponen,rba.subkomponen_input.nama_subkomponen,rba.akun_belanja.nama_akun5digit,"
                        . "rsa.rsa_kuitansi_lsphk3.kode_akun5digit,SUM(rsa.rsa_kuitansi_detail_lsphk3.volume*rsa.rsa_kuitansi_detail_lsphk3.harga_satuan) AS pengeluaran "
                        . "FROM rsa.rsa_kuitansi_lsphk3 "
                        . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                        . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                        . "JOIN rba.komponen_input ON rba.komponen_input.kode_kegiatan = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,2) "
                        . "AND rba.komponen_input.kode_output = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,9,2) "
                        . "AND rba.komponen_input.kode_program = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,11,2) "
                        . "AND rba.komponen_input.kode_komponen = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,13,2) "
                        . "JOIN rba.subkomponen_input ON rba.subkomponen_input.kode_kegiatan = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,2) "
                        . "AND rba.subkomponen_input.kode_output = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,9,2) "
                        . "AND rba.subkomponen_input.kode_program = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,11,2) "
                        . "AND rba.subkomponen_input.kode_komponen = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,13,2) "
                        . "AND rba.subkomponen_input.kode_subkomponen = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,15,2) "
                        . "JOIN rba.akun_belanja ON rba.akun_belanja.kode_akun5digit = rsa.rsa_kuitansi_lsphk3.kode_akun5digit "
                        . "AND rba.akun_belanja.kode_akun = rsa.rsa_kuitansi_lsphk3.kode_akun "
                        . "AND rba.akun_belanja.sumber_dana = rsa.rsa_kuitansi_lsphk3.sumber_dana "
                        . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$data['kode_unit_subunit']}' "
                        . "AND rsa.rsa_kuitansi_lsphk3.jenis = 'L3' "
                        . "AND ( " . $str_ . " ) "
                        . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$data['tahun']}' "
                        . "GROUP BY SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,10),SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,19,5) "
                        . "ORDER BY SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,10) ASC,SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,19,5) ASC";

       //                 echo $str;die;
//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }
	//nk 5 digit
	function get_pengeluaran_by_akun5digitnk($data){
//        var_dump($data);die;
                $str_ = '';
                if(count($data['array_id']) > 1){
                    foreach($data['array_id'] as $id){
                        $str_ .= "rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id}' OR " ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
                }else{
                    $str_ = "rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$data['array_id'][0]}'" ;
                }
   //     echo $str_ ; die;
                
                $str = "SELECT SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,10) AS rka,rsa.rsa_kuitansi_lsphk3.id_kuitansi,SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,10) AS kode_usulan_rkat,rba.komponen_input.nama_komponen,rba.subkomponen_input.nama_subkomponen,rba.akun_belanja.nama_akun5digit,"
                        . "rsa.rsa_kuitansi_lsphk3.kode_akun5digit,SUM(rsa.rsa_kuitansi_detail_lsphk3.volume*rsa.rsa_kuitansi_detail_lsphk3.harga_satuan) AS pengeluaran "
                        . "FROM rsa.rsa_kuitansi_lsphk3 "
                        . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                        . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                        . "JOIN rba.komponen_input ON rba.komponen_input.kode_kegiatan = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,2) "
                        . "AND rba.komponen_input.kode_output = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,9,2) "
                        . "AND rba.komponen_input.kode_program = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,11,2) "
                        . "AND rba.komponen_input.kode_komponen = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,13,2) "
                        . "JOIN rba.subkomponen_input ON rba.subkomponen_input.kode_kegiatan = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,2) "
                        . "AND rba.subkomponen_input.kode_output = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,9,2) "
                        . "AND rba.subkomponen_input.kode_program = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,11,2) "
                        . "AND rba.subkomponen_input.kode_komponen = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,13,2) "
                        . "AND rba.subkomponen_input.kode_subkomponen = SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,15,2) "
                        . "JOIN rba.akun_belanja ON rba.akun_belanja.kode_akun5digit = rsa.rsa_kuitansi_lsphk3.kode_akun5digit "
                        . "AND rba.akun_belanja.kode_akun = rsa.rsa_kuitansi_lsphk3.kode_akun "
                        . "AND rba.akun_belanja.sumber_dana = rsa.rsa_kuitansi_lsphk3.sumber_dana "
                        . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$data['kode_unit_subunit']}' "
                        . "AND rsa.rsa_kuitansi_lsphk3.jenis = 'L3NK' "
                        . "AND ( " . $str_ . " ) "
                        . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$data['tahun']}' "
                        . "GROUP BY SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,10),SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,19,5) "
                        . "ORDER BY SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,7,10) ASC,SUBSTR(rsa.rsa_kuitansi_lsphk3.kode_usulan_belanja,19,5) ASC";

       //                 echo $str;die;
//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_pengeluaran_by_akun5digit_lalu($data){

                $str_ = '';
                if(count($data['kode_akun5digit']) > 1){
                    foreach($data['kode_akun5digit'] as $kode){
                        $str_ .= "SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) = '{$kode}' OR " ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
                }else{
                    $str_ = "SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) = '{$data['kode_akun5digit'][0]}'" ;
                }
                $lenunit = strlen($data['kode_unit_subunit']);
                $str = "SELECT SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) AS kode_usulan_rkat,"
                        . "SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) AS kode_akun5digit,"
                        . "SUM(rsa_detail_belanja_.volume*rsa_detail_belanja_.harga_satuan) AS jml_spm_lalu "
                        . "FROM rsa_detail_belanja_ "
                        . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$data['kode_unit_subunit']}' "
                        . "AND ( " . $str_ . " ) "
                        . "AND rsa_detail_belanja_.tahun = '{$data['tahun']}' "
                        . "AND SUBSTR(rsa_detail_belanja_.proses,0,1) = '6' "
                        . "AND rsa_detail_belanja_.revisi = ( SELECT MAX(rsa_detail_belanja_.revisi) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$data['kode_unit_subunit']}' AND rsa_detail_belanja_.tahun = '{$data['tahun']}' ) "
                        . "GROUP BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10),SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) "
                        . "ORDER BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) ASC,SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) ASC" ;

//            var_dump($str);die;

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_pengeluaran_by_akun_rkat($data){

            $rba = $this->load->database('rba', TRUE);
            
            

                $str_ = '';
                if(count($data['kode_akun5digit']) > 1){
                    foreach($data['kode_akun5digit'] as $kode){
                        $str_ .= "SUBSTR(detail_belanja_.kode_usulan_belanja,19,5) = '{$kode}' OR " ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
                }else{
                    $str_ = "SUBSTR(detail_belanja_.kode_usulan_belanja,19,5) = '{$data['kode_akun5digit'][0]}'" ;
                }
                $lenunit = strlen($data['kode_unit_subunit']);
                $str = "SELECT SUBSTR(detail_belanja_.kode_usulan_belanja,7,10) AS kode_usulan_rkat,"
                        . "SUBSTR(detail_belanja_.kode_usulan_belanja,19,5) AS kode_akun5digit,"
                        . "SUM(detail_belanja_.volume*detail_belanja_.harga_satuan) AS pagu_rkat "
                        . "FROM detail_belanja_ "
                        . "WHERE LEFT(detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$data['kode_unit_subunit']}' "
                        . "AND ( " . $str_ . " ) "
                        . "AND detail_belanja_.tahun = '{$data['tahun']}' "
                        . "AND detail_belanja_.revisi = ( SELECT MAX(detail_belanja_.revisi) FROM detail_belanja_ WHERE LEFT(detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$data['kode_unit_subunit']}' AND detail_belanja_.tahun = '{$data['tahun']}' ) "
                        . "GROUP BY SUBSTR(detail_belanja_.kode_usulan_belanja,7,10),SUBSTR(detail_belanja_.kode_usulan_belanja,19,5) "
                        . "ORDER BY SUBSTR(detail_belanja_.kode_usulan_belanja,7,10) ASC,SUBSTR(detail_belanja_.kode_usulan_belanja,19,5) ASC" ;

//            var_dump($str);die;

            $q = $rba->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_spp_pajak($data){

                $str_ = '';
                if(count($data['array_id']) > 1){
                    foreach($data['array_id'] as $id){
                        $str_ .= "rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id}' OR " ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
                }else{
                    $str_ = "rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$data['array_id'][0]}'" ;
                }

                $str = "SELECT rsa.rsa_kuitansi_lsphk3.id_kuitansi,"
                        . "SUBSTR(rsa.rsa_kuitansi_detail_pajak_lsphk3.jenis_pajak,1,3) AS jenis,"
                        . "SUM(rsa.rsa_kuitansi_detail_pajak_lsphk3.rupiah_pajak) AS rupiah "
                        . "FROM rsa.rsa_kuitansi_lsphk3 "
                        . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                        . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                        . "JOIN rsa.rsa_kuitansi_detail_pajak_lsphk3 "
                        . "ON rsa.rsa_kuitansi_detail_pajak_lsphk3.id_kuitansi_detail = rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail "
                        . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$data['kode_unit_subunit']}' "
                        . "AND rsa.rsa_kuitansi_lsphk3.jenis = 'L3' "
                        . "AND ( " . $str_ . " ) "
                        . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$data['tahun']}' "
                        . "GROUP BY SUBSTR(rsa.rsa_kuitansi_detail_pajak_lsphk3.jenis_pajak,1,3) "
                        . "ORDER BY SUBSTR(rsa.rsa_kuitansi_detail_pajak_lsphk3.jenis_pajak,1,3) DESC";

//            var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }


    function proses_kuitansi($data,$id){
        $this->db->where('id_kuitansi',$id);
        return $this->db->update('rsa_kuitansi_lsphk3',$data);
    }

    function get_id_detail_by_str_nomor_spp($nomor_trx){
		//var_dump($nomor_trx);die;
        $this->db->where('str_nomor_trx',$nomor_trx);
        $q = $this->db->get('rsa_kuitansi_lsphk3');
		//var_dump($q);die;
        if($q->num_rows() > 0){
            return $q->result();
         }else{
             return '';
         }
    }
	
	function insert_data_kuitansi_kontrak($dt){
		$dt['waktu'] = date("Y-m-d H:i:s");
		$this->db->insert('rsa_kuitansi_pihak3',$dt);
	}
	
	//copy dr idris alaik
	function get_pekerjaan_by_array_id($data){
        $pekerjaan = 0 ;
        foreach($data['array_id'] as $id){
            $str = "SELECT * "
                . "FROM rsa.rsa_kuitansi_lsphk3 "
                . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$data['kode_unit_subunit']}' "
                . "AND rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id}' "
                . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$data['tahun']}' ";

         //   var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                    return $q->result();
                }
        }

        //return $pekerjaan;
    }
	//add alaik get id_kontral
	function get_kontrakid_by_array_id($data){
        $pekerjaan = 0 ;
        foreach($data['array_id'] as $id){
            $str = "SELECT * FROM rsa_spm_prosespihak3 LEFT JOIN rsa_kuitansi_pihak3 ON rsa_spm_prosespihak3.id=rsa_kuitansi_pihak3.kontrak_id LEFT JOIN rsa_spm_rekananpihak3 ON rsa_spm_prosespihak3.id_rekanan=rsa_spm_rekananpihak3.id_rekanan WHERE kuitansi_id = '{$id}' ";
               // . "AND rsa.rsa_kuitansi.id_kuitansi = '{$id}' "
                //. "AND rsa.rsa_kuitansi.tahun = '{$data['tahun']}' ";

           // var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }
        }

        return $pekerjaan;
    }
	function get_kontrak_by_id($data){
        //$pekerjaan = 0 ;
        foreach($data['array_id'] as $id){
            $str = "SELECT * FROM rsa_spm_rinciankontrak LEFT JOIN rsa_spm_kontrakpihak3 ON rsa_spm_rinciankontrak.id_pembayaran=rsa_spm_kontrakpihak3.id LEFT JOIN rsa_kuitansi_pihak3 ON rsa_spm_kontrakpihak3.id_kontrak=rsa_kuitansi_pihak3.kontrak_id WHERE kuitansi_id = '{$id}' ";
               // . "AND rsa.rsa_kuitansi.id_kuitansi = '{$id}' "
                //. "AND rsa.rsa_kuitansi.tahun = '{$data['tahun']}' ";

           //var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }
        }

        //return $pekerjaan;
    }
	//
	function get_detail_rsa_dpa_lsphk3($unit,$kode,$sumber_dana,$tahun){
            
//            $unit = substr($kode,0,2);
            $lenunit = strlen($unit);
            $rka = $kode;//substr($kode,2,10);
            
            $query  = "SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_usulan_belanja,rba.akun_belanja.kode_akun,rba.akun_belanja.nama_akun,rba.subunit.nama_subunit,rba.sub_subunit.nama_sub_subunit,"
                    . "rsa_detail_belanja_.kode_akun_tambah,RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) AS akun,rsa_detail_belanja_.impor,rsa_detail_belanja_.proses,rkd1.id_kuitansi,"
                    . "rsa_detail_belanja_.volume,rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan,rsa_kuitansi_lsphk3.aktif,rkd1.id_kuitansi AS rsa_kuitansi_detail_id_kuitansi,rsa_kuitansi_lsphk3.str_nomor_trx,rsa_kuitansi_lsphk3.str_nomor_trx_spm "
                    . "FROM rsa_detail_belanja_ "
                    . "JOIN rba.akun_belanja ON RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) = rba.akun_belanja.kode_akun AND rsa_detail_belanja_.sumber_dana = rba.akun_belanja.sumber_dana "
                    . "JOIN rba.subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,4) = rba.subunit.kode_subunit "
                    . "JOIN rba.sub_subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,6) = rba.sub_subunit.kode_sub_subunit "
                    . "LEFT JOIN rsa_kuitansi_detail_lsphk3 AS rkd1 ON rsa_detail_belanja_.kode_usulan_belanja = rkd1.kode_usulan_belanja AND rsa_detail_belanja_.kode_akun_tambah = rkd1.kode_akun_tambah "
                    . "LEFT JOIN rsa_kuitansi_lsphk3 ON rsa_kuitansi_lsphk3.id_kuitansi = rkd1.id_kuitansi "
                    . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' AND LEFT(rsa_detail_belanja_.proses,1) > 2 "
                    . "AND rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' ) "
                    . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                    . "AND ( rkd1.id_kuitansi = (SELECT MAX(rkd2.id_kuitansi) FROM rsa_kuitansi_detail_lsphk3 AS rkd2 WHERE rkd2.kode_usulan_belanja = rkd1.kode_usulan_belanja AND rkd2.kode_akun_tambah = rkd1.kode_akun_tambah AND rkd2.sumber_dana = '{$sumber_dana}' AND rkd2.tahun = '{$tahun}' ) "
                    . "OR ISNULL(rkd1.id_kuitansi) ) "
                    . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6), "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6), "
                    . "rsa_detail_belanja_.kode_akun_tambah "
                    . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "rsa_detail_belanja_.kode_akun_tambah ASC " ;
                    
                
//                    echo $query ; die;
                    
                $query		= $this->db->query($query) ;
		if ($query->num_rows()>0){
//                    echo '<pre>';
//                    var_dump($query->result());echo '</pre>';die;
			return $query->result();
		}else{
			return array();
		}
        }
		//PAJAK NK
	function get_spp_pajaknk($data){

                $str_ = '';
                if(count($data['array_id']) > 1){
                    foreach($data['array_id'] as $id){
                        $str_ .= "rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$id}' OR " ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
                }else{
                    $str_ = "rsa.rsa_kuitansi_lsphk3.id_kuitansi = '{$data['array_id'][0]}'" ;
                }

                $str = "SELECT rsa.rsa_kuitansi_lsphk3.id_kuitansi,"
                        . "SUBSTR(rsa.rsa_kuitansi_detail_pajak_lsphk3.jenis_pajak,1,3) AS jenis,"
                        . "SUM(rsa.rsa_kuitansi_detail_pajak_lsphk3.rupiah_pajak) AS rupiah "
                        . "FROM rsa.rsa_kuitansi_lsphk3 "
                        . "JOIN rsa.rsa_kuitansi_detail_lsphk3 "
                        . "ON rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi = rsa.rsa_kuitansi_lsphk3.id_kuitansi "
                        . "JOIN rsa.rsa_kuitansi_detail_pajak_lsphk3 "
                        . "ON rsa.rsa_kuitansi_detail_pajak_lsphk3.id_kuitansi_detail = rsa.rsa_kuitansi_detail_lsphk3.id_kuitansi_detail "
                        . "WHERE rsa.rsa_kuitansi_lsphk3.kode_unit = '{$data['kode_unit_subunit']}' "
                        . "AND rsa.rsa_kuitansi_lsphk3.jenis = 'L3NK' "
                        . "AND ( " . $str_ . " ) "
                        . "AND rsa.rsa_kuitansi_lsphk3.tahun = '{$data['tahun']}' "
                        . "GROUP BY SUBSTR(rsa.rsa_kuitansi_detail_pajak_lsphk3.jenis_pajak,1,3) "
                        . "ORDER BY SUBSTR(rsa.rsa_kuitansi_detail_pajak_lsphk3.jenis_pajak,1,3) DESC";
            //var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }
}
