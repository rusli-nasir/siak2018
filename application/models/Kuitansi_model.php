<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Kuitansi_model extends CI_Model{
/* -------------- Constructor ------------- */
    public function __construct()
    {
            parent::__construct();
    }
    function insert_data_kuitansi($data){

        $this->db->insert('rsa_kuitansi',$data);

        //$customerID=$db->insert_id;
        $q = $this->db->query("SELECT MAX(id_kuitansi) AS id_k FROM rsa_kuitansi WHERE kode_unit='{$data['kode_unit']}' AND tahun='{$data['tahun']}' AND sumber_dana='{$data['sumber_dana']}'");
        $row = $q->row();

        return $row->id_k;
    }

    function insert_data_usulan($data){

        $this->db->insert('rsa_kuitansi_detail',$data);

        //$customerID=$db->insert_id;
        $q = $this->db->query("SELECT MAX(id_kuitansi_detail) AS id_k FROM rsa_kuitansi_detail WHERE id_kuitansi='{$data['id_kuitansi']}' AND kode_usulan_belanja='{$data['kode_usulan_belanja']}' ");
        $row = $q->row();

        return $row->id_k;
    }

    function insert_data_pajak($data){
//        var_dump($data);die;
        $this->db->insert('rsa_kuitansi_detail_pajak',$data);

    }

    function get_next_id($data){
      //  echo  "SELECT IFNULL(MAX(RIGHT(no_bukti,5)),0) AS next_no_bukti FROM rsa_kuitansi WHERE LEFT(no_bukti,3) = '{$data['alias']}' AND tahun = '{$data['tahun']}' "; exit;
//        $q = $this->db->query("SELECT IFNULL(MAX(RIGHT(no_bukti,5)),0) AS next_no_bukti FROM rsa_kuitansi WHERE LEFT(no_bukti,3) = '{$data['alias']}' AND jenis = '{$data['jenis']}' AND sumber_dana = '{$data['sumber_dana']}' AND tahun = '{$data['tahun']}'");
        $q = $this->db->query("SELECT IFNULL(MAX(RIGHT(no_bukti,5)),0) AS next_no_bukti FROM rsa_kuitansi WHERE SUBSTR(no_bukti,1,3) = '{$data['alias']}' AND tahun = '{$data['tahun']}' ");
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

    function get_kuitansi($jenis,$kode_unit_subunit,$tahun,$status){
//        $kode_unit_subunit = substr($kode_unit_subunit,0,2);
        $lenunit = strlen($kode_unit_subunit);
        
        $stts = '' ;
        if($status == 'AKTIF'){
            $stts = "AND ( rsa_2018.rsa_kuitansi.aktif = '1' AND rsa_2018.rsa_kuitansi.cair = '0' ) " ;
        }
        elseif($status == 'BATAL'){
            $stts = "AND ( rsa_2018.rsa_kuitansi.aktif = '0' AND rsa_2018.rsa_kuitansi.cair = '0' ) " ;
        }
        elseif($status == 'CAIR'){
            $stts = "AND ( rsa_2018.rsa_kuitansi.aktif = '1' AND rsa_2018.rsa_kuitansi.cair = '1' ) " ;
        }
        $str1 = "SELECT rsa_2018.rsa_kuitansi.id_kuitansi,rsa_2018.rsa_kuitansi.tgl_kuitansi,rba_2018.akun_belanja.nama_akun5digit,"
                . "rsa_2018.rsa_kuitansi.kode_akun5digit,rsa_2018.rsa_kuitansi_detail.kode_akun_tambah,"
                . "rsa_2018.rsa_kuitansi.no_bukti,"
                . "SUM(rsa_2018.rsa_kuitansi_detail.volume*rsa_2018.rsa_kuitansi_detail.harga_satuan) AS pengeluaran,"
                . "rsa_2018.rsa_kuitansi.uraian,"
                . "SUM(rsa_2018.rsa_kuitansi_detail_pajak.rupiah_pajak) AS potongan,rsa_2018.rsa_kuitansi.aktif,rsa_2018.rsa_kuitansi.str_nomor_trx,rsa_2018.rsa_kuitansi.cair "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail "
                . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "JOIN rba_2018.akun_belanja ON rba_2018.akun_belanja.kode_akun5digit = rsa_2018.rsa_kuitansi.kode_akun5digit "
                . "AND rba_2018.akun_belanja.kode_akun = rsa_2018.rsa_kuitansi.kode_akun "
                . "AND rba_2018.akun_belanja.sumber_dana = rsa_2018.rsa_kuitansi.sumber_dana "
                . "JOIN rsa_2018.rsa_kuitansi_detail_pajak "
                . "ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,2) = '{$kode_unit_subunit}' "
                . "AND rsa_2018.rsa_kuitansi.tahun = '{$tahun}' "
                . "AND rsa_2018.rsa_kuitansi.jenis = '{$jenis}' "
                . "GROUP BY rsa_2018.rsa_kuitansi.id_kuitansi";

        $str = "SELECT rsa_2018.rsa_kuitansi.id_kuitansi,rsa_2018.rsa_kuitansi.kode_unit,rsa_2018.rsa_kuitansi.no_bukti,"
                . "rsa_2018.rsa_kuitansi.tgl_kuitansi,rsa_2018.rsa_kuitansi.uraian,"
                . "SUM(rsa_2018.rsa_kuitansi_detail.volume*rsa_2018.rsa_kuitansi_detail.harga_satuan) AS pengeluaran,"
                . "rsa_2018.rsa_kuitansi.str_nomor_trx,rsa_2018.rsa_kuitansi.str_nomor_trx_spm,rsa_2018.rsa_kuitansi.aktif,rsa_2018.rsa_kuitansi.cair "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenunit}) = '{$kode_unit_subunit}' AND rsa_2018.rsa_kuitansi.tahun = '{$tahun}' "
                . "AND rsa_2018.rsa_kuitansi.jenis = '{$jenis}' "
                . $stts
                . "GROUP BY rsa_2018.rsa_kuitansi.id_kuitansi "
                . "ORDER BY rsa_2018.rsa_kuitansi.tgl_kuitansi DESC";

       // print_r($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
//                    var_dump($q->result());die;
                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_kuitansi_unit($jenis,$kode_unit_subunit,$tahun,$status){
//        $kode_unit_subunit = substr($kode_unit_subunit,0,2);
        $lenunit = strlen($kode_unit_subunit);
        
        $stts = '' ;
        if($status == 'AKTIF'){
            $stts = "AND ( rsa_2018.rsa_kuitansi.aktif = '1' AND rsa_2018.rsa_kuitansi.cair = '0' ) " ;
        }
        elseif($status == 'BATAL'){
            $stts = "AND ( rsa_2018.rsa_kuitansi.aktif = '0' AND rsa_2018.rsa_kuitansi.cair = '0' ) " ;
        }
        elseif($status == 'CAIR'){
            $stts = "AND ( rsa_2018.rsa_kuitansi.aktif = '1' AND rsa_2018.rsa_kuitansi.cair = '1' ) " ;
        }

        $str = "SELECT rsa_2018.rsa_kuitansi.kode_unit,rba_2018.unit.nama_unit,rba_2018.subunit.nama_subunit,rba_2018.sub_subunit.nama_sub_subunit "
                . "FROM rsa_2018.rsa_kuitansi "
                . "LEFT JOIN rba_2018.unit ON rba_2018.unit.kode_unit = rsa_2018.rsa_kuitansi.kode_unit "
                . "LEFT JOIN rba_2018.subunit ON rba_2018.subunit.kode_subunit = rsa_2018.rsa_kuitansi.kode_unit "
                . "LEFT JOIN rba_2018.sub_subunit ON rba_2018.sub_subunit.kode_sub_subunit = rsa_2018.rsa_kuitansi.kode_unit "
                . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenunit}) = '{$kode_unit_subunit}' AND rsa_2018.rsa_kuitansi.tahun = '{$tahun}' "
                . "AND rsa_2018.rsa_kuitansi.jenis = '{$jenis}' "
                . $stts
                . "GROUP BY rsa_2018.rsa_kuitansi.kode_unit "
                . "ORDER BY rsa_2018.rsa_kuitansi.kode_unit ASC";

       // print_r($str);die;

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
       $lenunit = strlen($kode_unit_subunit);

        $str = "SELECT rsa_2018.rsa_kuitansi.id_kuitansi,rsa_2018.rsa_kuitansi.no_bukti,"
                . "rsa_2018.rsa_kuitansi.tgl_kuitansi,rsa_2018.rsa_kuitansi.uraian,"
                . "SUM(rsa_2018.rsa_kuitansi_detail.volume*rsa_2018.rsa_kuitansi_detail.harga_satuan) AS pengeluaran,"
                . "rsa_2018.rsa_kuitansi.str_nomor_trx,rsa_2018.rsa_kuitansi.aktif,rsa_2018.rsa_kuitansi.cair "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenunit}) = '{$kode_unit_subunit}' AND rsa_2018.rsa_kuitansi.tahun = '{$tahun}' "
                . "AND rsa_2018.rsa_kuitansi.jenis = '{$jenis}' "
                . "GROUP BY rsa_2018.rsa_kuitansi.id_kuitansi";

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

        $lenunit = strlen($kode_unit_subunit);

        $str = "SELECT rsa_2018.rsa_kuitansi.tgl_kuitansi,rba_2018.akun_belanja.nama_akun5digit,"
                . "rsa_2018.rsa_kuitansi.kode_akun5digit,rsa_2018.rsa_detail_belanja_.kode_akun_tambah,"
                . "rsa_2018.rsa_detail_belanja_.deskripsi,rsa_2018.rsa_kuitansi.no_bukti,"
                . "(rsa_2018.rsa_detail_belanja_.volume*rsa_2018.rsa_detail_belanja_.harga_satuan) AS pengeluaran,"
                . "rsa_2018.rsa_detail_belanja_.volume,rsa_2018.rsa_detail_belanja_.satuan,rsa_2018.rsa_kuitansi.uraian,"
                . "SUM(rsa_2018.rsa_kuitansi_detail_pajak.rupiah_pajak) AS potongan "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail "
                . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "JOIN rsa_2018.rsa_detail_belanja_ "
                . "ON rsa_2018.rsa_detail_belanja_.kode_usulan_belanja = rsa_2018.rsa_kuitansi_detail.kode_usulan_belanja "
                . "AND rsa_2018.rsa_detail_belanja_.kode_akun_tambah = rsa_2018.rsa_kuitansi_detail.kode_akun_tambah "
                . "JOIN rba_2018.akun_belanja ON rba_2018.akun_belanja.kode_akun5digit = rsa_2018.rsa_kuitansi.kode_akun5digit "
                . "AND rba_2018.akun_belanja.kode_akun = rsa_2018.rsa_kuitansi.kode_akun "
                . "AND rba_2018.akun_belanja.sumber_dana = rsa_2018.rsa_kuitansi.sumber_dana "
                . "JOIN rsa_2018.rsa_kuitansi_detail_pajak "
                . "ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenunit}) = '{$kode_unit_subunit}' "
                . "AND rsa_2018.rsa_kuitansi.tahun = '{$tahun}' "
                . "AND rsa_2018.rsa_kuitansi.jenis = '{$jenis}' "
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

    function get_data_kuitansi($id_kuitansi,$tahun){

        $str = "SELECT 
a.id_kuitansi,
a.tgl_kuitansi,
a.tahun,
a.jenis,
a.no_bukti,
a.alias_no_bukti,
c.nama_akun4digit AS nama_akun,
SUM(b.volume*b.harga_satuan) AS pengeluaran,
a.uraian,
d.nama_subkomponen,
a.penerima_uang,
a.penerima_uang_nip,
a.penerima_barang,
a.penerima_barang_nip,
a.nmpppk,
a.nippppk,
a.nmbendahara,
a.nipbendahara,
a.nmpumk,
a.nippumk,
a.penerima_uang,
a.aktif,
a.str_nomor_trx 
FROM rsa_2018.rsa_kuitansi AS a
JOIN rsa_2018.rsa_kuitansi_detail AS b ON b.id_kuitansi = a.id_kuitansi 
JOIN rba_2018.akun_belanja AS c ON c.kode_akun4digit = a.kode_akun4digit AND c.sumber_dana = a.sumber_dana 
JOIN rba_2018.subkomponen_input AS d ON d.kode_kegiatan = SUBSTR(a.kode_usulan_belanja,7,2) AND d.kode_output = SUBSTR(a.kode_usulan_belanja,9,2) AND d.kode_program = SUBSTR(a.kode_usulan_belanja,11,2) AND d.kode_komponen = SUBSTR(a.kode_usulan_belanja,13,2) AND d.kode_subkomponen = SUBSTR(a.kode_usulan_belanja,15,2) 
LEFT JOIN rsa_2018.rsa_kuitansi_detail_pajak AS e ON e.id_kuitansi_detail = b.id_kuitansi_detail 
WHERE a.id_kuitansi = '{$id_kuitansi}' AND a.tahun = '{$tahun}' 
GROUP BY a.id_kuitansi";

           // echo $str;die;

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
        $str = "SELECT rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail,rsa_2018.rsa_kuitansi_detail.deskripsi,rsa_2018.rsa_kuitansi_detail.volume,"
                . "rsa_2018.rsa_kuitansi_detail.satuan,rsa_2018.rsa_kuitansi_detail.harga_satuan,(ROUND(rsa_2018.rsa_kuitansi_detail.volume * rsa_2018.rsa_kuitansi_detail.harga_satuan)) AS bruto "
                . "" //,GROUP_CONCAT(rsa_kuitansi_detail_pajak.jenis_pajak SEPARATOR '<br>') AS pajak_nom "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail "
                . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "LEFT JOIN rsa_2018.rsa_kuitansi_detail_pajak "
                . "ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                . "WHERE rsa_2018.rsa_kuitansi.id_kuitansi = '{$id_kuitansi}' "
                . "AND rsa_2018.rsa_kuitansi.tahun = '{$tahun}' "
                . "GROUP BY rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail";

           // echo $str; die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){

                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_data_detail_pajak_kuitansi($id_kuitansi,$tahun){
        $str = "SELECT rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail,rsa_2018.rsa_kuitansi_detail_pajak.jenis_pajak,rsa_2018.rsa_kuitansi_detail_pajak.persen_pajak,"
                . "rsa_2018.rsa_kuitansi_detail_pajak.dpp,rsa_2018.rsa_kuitansi_detail_pajak.rupiah_pajak "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail "
                . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail_pajak "
                . "ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                . "WHERE rsa_2018.rsa_kuitansi.id_kuitansi = '{$id_kuitansi}' "
                . "AND rsa_2018.rsa_kuitansi.tahun = '{$tahun}' "
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

    function get_rekap_detail_kuitansi($data){

        $str_ = '';
                if(count($data['array_id']) > 1){
                    foreach($data['array_id'] as $id){
                        $str_ .= "rsa_2018.rsa_kuitansi.id_kuitansi = '{$id}' OR " ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
                }else{
                    $str_ = "rsa_2018.rsa_kuitansi.id_kuitansi = '{$data['array_id'][0]}'" ;
                }

        $str1 = "SELECT SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) AS rka,
        SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,1,6) AS kdunit,
        rsa_2018.rsa_kuitansi.no_bukti,
        rsa_2018.rsa_kuitansi.tgl_kuitansi,
        rsa_2018.rsa_kuitansi.uraian,
        rba_2018.akun_belanja.nama_akun,
        rsa_2018.rsa_kuitansi.kode_akun5digit,
        rsa_2018.rsa_kuitansi.kode_akun,
        rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail,
        rsa_2018.rsa_kuitansi_detail.kode_akun_tambah,
        rsa_2018.rsa_kuitansi_detail.deskripsi,
        rsa_2018.rsa_kuitansi_detail.volume,
        rsa_2018.rsa_kuitansi_detail.satuan,
        rsa_2018.rsa_kuitansi_detail.harga_satuan,
        (rsa_2018.rsa_kuitansi_detail.volume * rsa_2018.rsa_kuitansi_detail.harga_satuan) AS bruto,
        GROUP_CONCAT(IF((rsa_kuitansi_detail_pajak.persen_pajak = '99') OR (rsa_kuitansi_detail_pajak.persen_pajak = '98') OR (rsa_kuitansi_detail_pajak.persen_pajak = '89') OR (rsa_kuitansi_detail_pajak.persen_pajak = '97') OR (rsa_kuitansi_detail_pajak.persen_pajak = '96') OR (rsa_kuitansi_detail_pajak.persen_pajak = '95') OR (rsa_kuitansi_detail_pajak.persen_pajak = '94'),rsa_kuitansi_detail_pajak.jenis_pajak,CONCAT(rsa_kuitansi_detail_pajak.jenis_pajak,' [ ',rsa_kuitansi_detail_pajak.persen_pajak,'% ] ')) SEPARATOR ',<br>') AS pajak_nom,
        SUM(rsa_kuitansi_detail_pajak.rupiah_pajak) AS total_pajak 
        FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail "
                . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "LEFT JOIN rsa_2018.rsa_kuitansi_detail_pajak "
                . "ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                . "JOIN rba_2018.akun_belanja ON rba_2018.akun_belanja.kode_akun = rsa_2018.rsa_kuitansi.kode_akun "
                . "AND rba_2018.akun_belanja.sumber_dana = rsa_2018.rsa_kuitansi.sumber_dana "
                . "WHERE rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' "
                . "AND ( " . $str_ . " ) "
                . "GROUP BY rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                . "ORDER BY SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) ASC,"
                . "SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,1,6) ASC,"
                . "rsa_2018.rsa_kuitansi.tgl_kuitansi ASC,"
                . "rsa_2018.rsa_kuitansi.kode_akun ASC,"
                . "rsa_2018.rsa_kuitansi.no_bukti ASC,"
                . "rsa_2018.rsa_kuitansi_detail.kode_akun_tambah ASC,"
                . "rsa_2018.rsa_kuitansi_detail_pajak.jenis_pajak ASC";


        $str = "SELECT 
SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) AS rka, 
SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,1,6) AS kdunit,
rsa_2018.rsa_kuitansi.no_bukti,
rsa_2018.rsa_kuitansi.tgl_kuitansi,
rsa_2018.rsa_kuitansi.uraian,
rba_2018.akun_belanja.nama_akun,
rba_2018.akun_belanja.kode_akun,
rba_2018.akun_belanja.kode_akun4digit,
rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail,
rsa_2018.rsa_kuitansi_detail.kode_akun_tambah,
rsa_2018.rsa_kuitansi_detail.deskripsi,
rsa_2018.rsa_kuitansi_detail.volume,
rsa_2018.rsa_kuitansi_detail.satuan,
rsa_2018.rsa_kuitansi_detail.harga_satuan,
(rsa_2018.rsa_kuitansi_detail.volume * rsa_2018.rsa_kuitansi_detail.harga_satuan) AS bruto,
GROUP_CONCAT(IF((rsa_kuitansi_detail_pajak.persen_pajak = '99') OR (rsa_kuitansi_detail_pajak.persen_pajak = '98') OR (rsa_kuitansi_detail_pajak.persen_pajak = '89') OR (rsa_kuitansi_detail_pajak.persen_pajak = '97') OR (rsa_kuitansi_detail_pajak.persen_pajak = '96') OR (rsa_kuitansi_detail_pajak.persen_pajak = '95') OR (rsa_kuitansi_detail_pajak.persen_pajak = '94'),rsa_kuitansi_detail_pajak.jenis_pajak,CONCAT(rsa_kuitansi_detail_pajak.jenis_pajak,' [ ',rsa_kuitansi_detail_pajak.persen_pajak,'% ] ')) SEPARATOR ',
') AS pajak_nom,
SUM(rsa_kuitansi_detail_pajak.rupiah_pajak) AS total_pajak 
FROM rsa_2018.rsa_kuitansi 
JOIN rsa_2018.rsa_kuitansi_detail 
    ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi 
LEFT JOIN rsa_2018.rsa_kuitansi_detail_pajak 
    ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail 
JOIN rba_2018.akun_belanja 
    ON rba_2018.akun_belanja.kode_akun = SUBSTR(rsa_2018.rsa_kuitansi_detail.kode_usulan_belanja,19,6)
    AND rba_2018.akun_belanja.sumber_dana = rsa_2018.rsa_kuitansi.sumber_dana 
WHERE rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' 
AND ( " . $str_ . " ) 
GROUP BY rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail 
ORDER BY 
SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) ASC,
SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,1,6) ASC,
rsa_2018.rsa_kuitansi.tgl_kuitansi ASC,
rba_2018.akun_belanja.kode_akun ASC,
rsa_2018.rsa_kuitansi.no_bukti ASC,
rsa_2018.rsa_kuitansi_detail.kode_akun_tambah ASC,
rsa_2018.rsa_kuitansi_detail_pajak.jenis_pajak ASC";

           // echo $str;die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){

                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_pengeluaran($kode_unit_subunit,$tahun){

        $lenunit = strlen($kode_unit_subunit);

        $str = "SELECT  SUM(rsa_2018.rsa_kuitansi_detail.volume*rsa_2018.rsa_kuitansi_detail.harga_satuan) AS pengeluaran "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail "
                . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenunit}) = '{$kode_unit_subunit}' "
                . "AND rsa_2018.rsa_kuitansi.tahun = '{$tahun}' "
                . "AND rsa_2018.rsa_kuitansi.jenis = 'GP' "
                . "AND rsa_2018.rsa_kuitansi.aktif = '1' "
                . "AND rsa_2018.rsa_kuitansi.str_nomor_trx IS NOT NULL "
                . "AND rsa_2018.rsa_kuitansi.cair = '0' "
                . "GROUP BY SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenunit})";

           // var_dump($str);

            $q = $this->db->query($str);
               // var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->pengeluaran;
                }else{
                    return 0;
                }
    }

    function get_pengeluaran_tup($kode_unit_subunit,$tahun){

        $lenunit = strlen($kode_unit_subunit);

        $str = "SELECT  SUM(rsa_2018.rsa_kuitansi_detail.volume*rsa_2018.rsa_kuitansi_detail.harga_satuan) AS pengeluaran "
                . "FROM rsa_2018.rsa_kuitansi "
                . "JOIN rsa_2018.rsa_kuitansi_detail "
                . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenunit}) = '{$kode_unit_subunit}' "
                . "AND rsa_2018.rsa_kuitansi.tahun = '{$tahun}' "
                . "AND rsa_2018.rsa_kuitansi.jenis = 'TP' "
                . "AND rsa_2018.rsa_kuitansi.aktif = '1' "
                . "AND rsa_2018.rsa_kuitansi.str_nomor_trx IS NOT NULL "
                . "AND rsa_2018.rsa_kuitansi.cair = '0' "
                . "GROUP BY SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenunit})";

           // var_dump($str);

            $q = $this->db->query($str);
               // var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->row()->pengeluaran;
                }else{
                    return 0;
                }
    }

    function get_pengeluaran_by_array_id($data){

        $pengeluaran = 0 ;

        $id_kuitansi = '' ;

        if(count($data['array_id']) > 0){

            foreach($data['array_id'] as $id){

                $id_kuitansi = $id_kuitansi . '"' .$id . '",' ;

            }

            $id_kuitansi = substr($id_kuitansi, 0, -1) ; 

        }else{

            $id_kuitansi = "''";

        }

        $lenkode = strlen($data['kode_unit_subunit']);

        $str = "SELECT SUM(rsa_2018.rsa_detail_belanja_.volume*rsa_2018.rsa_detail_belanja_.harga_satuan) AS pengeluaran "
            . "FROM rsa_2018.rsa_kuitansi "
            . "JOIN rsa_2018.rsa_kuitansi_detail "
            . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
            . "JOIN rsa_2018.rsa_detail_belanja_ "
            . "ON rsa_2018.rsa_detail_belanja_.kode_usulan_belanja = rsa_2018.rsa_kuitansi_detail.kode_usulan_belanja "
            . "AND rsa_2018.rsa_detail_belanja_.kode_akun_tambah = rsa_2018.rsa_kuitansi_detail.kode_akun_tambah "
            . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenkode}) = '{$data['kode_unit_subunit']}' "
            . "AND rsa_2018.rsa_kuitansi.id_kuitansi IN ({$id_kuitansi}) "
            . "AND rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' "
            . "GROUP BY SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenkode})" ;

       // echo $str;die;

        $q = $this->db->query($str);
//            var_dump($q->num_rows());die;
        if($q->num_rows() > 0){
               $pengeluaran = $pengeluaran + $q->row()->pengeluaran ;
        }

        return $pengeluaran;

    }

    function get_data_by_array_id($data){

        $id_kuitansi = '' ;

        if(count($data['array_id']) > 0){

            foreach($data['array_id'] as $id){

                $id_kuitansi = $id_kuitansi . '"' .$id . '",' ;

            }

            $id_kuitansi = substr($id_kuitansi, 0, -1) ; 

        }else{

            $id_kuitansi = "''";

        }

        $str = "SELECT * FROM rsa_kuitansi_detail WHERE rsa_kuitansi_detail.id_kuitansi IN ({$id_kuitansi}) AND rsa_kuitansi_detail.tahun = '{$data['tahun']}' " ;

        $q = $this->db->query($str);
//            var_dump($q->num_rows());die;
        if($q->num_rows() > 0){
            return $q->result() ;
        }else{
            return array();
        }

    }

    function get_rekap_pajak_by_array_id($data,$tahun){

        $arr = "" ;

        foreach($data['array_id'] as $id){
            $arr = $arr . ',' . $id ;
        }

         $arr = ltrim( $arr, ',');

        // echo $arr ; die;



        $str1 = "SELECT rsa_kuitansi.no_bukti,rsa_kuitansi.kode_akun,rsa_kuitansi.no_bukti, rsa_kuitansi.penerima_uang, rsa_kuitansi.uraian, (rsa_kuitansi_detail.harga_satuan*rsa_kuitansi_detail.volume) AS jml_bruto,SUM(CASE WHEN rsa_kuitansi_detail_pajak.jenis_pajak = 'PPN' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) PPN,SUM(CASE WHEN LEFT(rsa_kuitansi_detail_pajak.jenis_pajak,3) = 'PPh' AND RIGHT(rsa_kuitansi_detail_pajak.jenis_pajak,2) = '21' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) PPh21,SUM(CASE WHEN LEFT(rsa_kuitansi_detail_pajak.jenis_pajak,3) = 'PPh' AND RIGHT(rsa_kuitansi_detail_pajak.jenis_pajak,2) = '22' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) PPh22,SUM(CASE WHEN LEFT(rsa_kuitansi_detail_pajak.jenis_pajak,3) = 'PPh' AND RIGHT(rsa_kuitansi_detail_pajak.jenis_pajak,2) = '23' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) PPh23,SUM(CASE WHEN LEFT(rsa_kuitansi_detail_pajak.jenis_pajak,3) = 'PPh' AND RIGHT(rsa_kuitansi_detail_pajak.jenis_pajak,2) = '26' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) PPh26,SUM(CASE WHEN LENGTH(rsa_kuitansi_detail_pajak.jenis_pajak) = 11 THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) 'PPh4_2',SUM(CASE WHEN rsa_kuitansi_detail_pajak.jenis_pajak='Lainnya' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) Lainnya FROM rsa_kuitansi JOIN rsa_kuitansi_detail ON rsa_kuitansi_detail.id_kuitansi = rsa_kuitansi.id_kuitansi LEFT JOIN rsa_kuitansi_detail_pajak ON rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_kuitansi_detail.id_kuitansi_detail WHERE rsa_kuitansi.id_kuitansi IN ( ".$arr." ) GROUP BY rsa_kuitansi.id_kuitansi ORDER BY rsa_kuitansi.kode_akun ASC,rsa_kuitansi.id_kuitansi ASC" ;

        // echo $str1;die;


        $str = "SELECT 
rsa_kuitansi.no_bukti,
SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,19,4) AS kode_akun,
rsa_kuitansi.no_bukti, 
rsa_kuitansi.penerima_uang, 
rsa_kuitansi.uraian, 
SUM(rsa_kuitansi_detail.harga_satuan*rsa_kuitansi_detail.volume) AS jml_bruto,
SUM(CASE WHEN rsa_kuitansi_detail_pajak.jenis_pajak = 'PPN' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) PPN,SUM(CASE WHEN LEFT(rsa_kuitansi_detail_pajak.jenis_pajak,3) = 'PPh' AND RIGHT(rsa_kuitansi_detail_pajak.jenis_pajak,2) = '21' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) PPh21,SUM(CASE WHEN LEFT(rsa_kuitansi_detail_pajak.jenis_pajak,3) = 'PPh' AND RIGHT(rsa_kuitansi_detail_pajak.jenis_pajak,2) = '22' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) PPh22,SUM(CASE WHEN LEFT(rsa_kuitansi_detail_pajak.jenis_pajak,3) = 'PPh' AND RIGHT(rsa_kuitansi_detail_pajak.jenis_pajak,2) = '23' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) PPh23,SUM(CASE WHEN LEFT(rsa_kuitansi_detail_pajak.jenis_pajak,3) = 'PPh' AND RIGHT(rsa_kuitansi_detail_pajak.jenis_pajak,2) = '26' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) PPh26,SUM(CASE WHEN LENGTH(rsa_kuitansi_detail_pajak.jenis_pajak) = 11 THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) 'PPh4_2',SUM(CASE WHEN rsa_kuitansi_detail_pajak.jenis_pajak='Lainnya' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) Lainnya,
    SUM(CASE WHEN rsa_kuitansi_detail_pajak.jenis_pajak = 'Tabungan Pajak' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) Tabungan_Pajak,
    SUM(CASE WHEN rsa_kuitansi_detail_pajak.jenis_pajak = 'Potongan Pajak' THEN rsa_kuitansi_detail_pajak.rupiah_pajak ELSE 0 END) Potongan_Pajak
FROM rsa_kuitansi 
JOIN rsa_kuitansi_detail 
    ON rsa_kuitansi_detail.id_kuitansi = rsa_kuitansi.id_kuitansi
LEFT JOIN rsa_kuitansi_detail_pajak 
    ON rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_kuitansi_detail.id_kuitansi_detail 
WHERE rsa_kuitansi.id_kuitansi IN ( ".$arr." ) AND rsa_kuitansi.tahun = '{$tahun}'
GROUP BY rsa_kuitansi.id_kuitansi 
ORDER BY SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,19,4) ASC,rsa_kuitansi.id_kuitansi ASC";

        // echo $str ; die ;

        $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
        if($q->num_rows() > 0){
            $res = array();

            $kode_akun = array() ;

            $kode_akun_ = '' ;

            foreach($q->result() as $r){
                if (!(in_array($r->kode_akun, $kode_akun))){

                    $kode_akun_ = $r->kode_akun;
                    $kode_akun[] = $r->kode_akun ;
                }

                 $res[$kode_akun_][] = $r ;
            }
            // echo '<pre>' ;
            // var_dump($res) ; 
            // echo '</pre>' ;
            // die;
           return $res;
        }else{
            return array();
        }

    }


    function get_rekap_bruto_by_array_id($data,$tahun){

        $arr = "" ;

        foreach($data['array_id'] as $id){
            $arr = $arr . ',' . $id ;
        }

         $arr = ltrim( $arr, ',');

        // echo $arr ; die;

        $str1 = "SELECT rsa_kuitansi.kode_akun, SUM(rsa_detail_belanja_.harga_satuan*rsa_detail_belanja_.volume) jml_bruto FROM rsa_detail_belanja_ JOIN rsa_kuitansi ON rsa_kuitansi.kode_usulan_belanja = rsa_detail_belanja_.kode_usulan_belanja JOIN rsa_kuitansi_detail ON rsa_kuitansi_detail.id_kuitansi =rsa_kuitansi.id_kuitansi AND rsa_kuitansi_detail.kode_akun_tambah = rsa_detail_belanja_.kode_akun_tambah WHERE rsa_kuitansi.id_kuitansi IN ( ".$arr." ) GROUP BY rsa_kuitansi.id_kuitansi ORDER BY rsa_kuitansi.kode_akun ASC,rsa_kuitansi.id_kuitansi ASC" ;


        $str = "SELECT 
SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,19,4) AS kode_akun, 
SUM(rsa_detail_belanja_.harga_satuan*rsa_detail_belanja_.volume) AS jml_bruto 
FROM rsa_detail_belanja_ 
JOIN rsa_kuitansi_detail ON rsa_kuitansi_detail.kode_usulan_belanja = rsa_detail_belanja_.kode_usulan_belanja AND rsa_kuitansi_detail.kode_akun_tambah = rsa_detail_belanja_.kode_akun_tambah
JOIN rsa_kuitansi ON rsa_kuitansi_detail.id_kuitansi =rsa_kuitansi.id_kuitansi
WHERE rsa_kuitansi.id_kuitansi IN ( ".$arr." ) AND rsa_kuitansi.tahun = '{$tahun}' 
GROUP BY rsa_kuitansi.id_kuitansi 
ORDER BY SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,19,4) ASC,rsa_kuitansi.id_kuitansi ASC";

        // echo $str ; die ;

        $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
        if($q->num_rows() > 0){
            $res = array();

            $kode_akun = array() ;

            $kode_akun_ = '' ;

            foreach($q->result() as $r){
                if (!(in_array($r->kode_akun, $kode_akun))){

                    $kode_akun_ = $r->kode_akun;
                    $kode_akun[] = $r->kode_akun;
                }

                 $res[$kode_akun_][] = $r ;
            }
            // echo '<pre>' ;
            // var_dump($res) ; 
            // echo '</pre>' ;
            // die;
           return $res;
        }else{
            return array();
        }

    }

    function insert_spp($data){

        $rel_kuitansi = json_decode($data['rel_kuitansi']);
        if(!empty($rel_kuitansi)){
            foreach($rel_kuitansi as $rel){
                $this->db->where('id_kuitansi', $rel);
                $this->db->update('rsa_kuitansi', array('str_nomor_trx'=>$data['str_nomor_trx']));
            }
        }

    }
    
    function insert_spm($data){

        $rel_kuitansi = json_decode($data['rel_kuitansi']);
        if(!empty($rel_kuitansi)){
            foreach($rel_kuitansi as $rel){
                $this->db->where('id_kuitansi', $rel);
                $this->db->update('rsa_kuitansi', array('str_nomor_trx_spm'=>$data['str_nomor_trx_spm']));
            }
        }

    }
    
    function tolak_spp($data){

        $rel_kuitansi = json_decode($data['rel_kuitansi']);
        
        $str = '' ;

        if(count($rel_kuitansi)>0){
            foreach($rel_kuitansi as $rel){
                // $query = "UPDATE rsa_kuitansi_pengembalian SET str_nomor_trx = NULL,str_nomor_trx_spm = NULL WHERE id_kuitansi = '{$rel}'";
                // $this->db->query($query);
    //            $this->db->where('id_kuitansi', $rel);
    //            $this->db->update('rsa_kuitansi', array('str_nomor_trx'=>''));//array('str_nomor_trx'=>$data['str_nomor_trx']));

                $str .= "'". $rel . "'," ;

            }

            $str = substr($str, 0, -1);

            $query = "UPDATE rsa_kuitansi SET str_nomor_trx = NULL WHERE id_kuitansi IN ({$str})";
        
            $this->db->query($query);

        }

        

    }
    
    function tolak_spm($data){

        $rel_kuitansi = json_decode($data['rel_kuitansi']);

        $str = '' ;

        if(count($rel_kuitansi)>0){
            foreach($rel_kuitansi as $rel){
                // $query = "UPDATE rsa_kuitansi_pengembalian SET str_nomor_trx = NULL,str_nomor_trx_spm = NULL WHERE id_kuitansi = '{$rel}'";
                // $this->db->query($query);
    //            $this->db->where('id_kuitansi', $rel);
    //            $this->db->update('rsa_kuitansi', array('str_nomor_trx'=>''));//array('str_nomor_trx'=>$data['str_nomor_trx']));

                $str .= "'". $rel . "'," ;

            }

            $str = substr($str, 0, -1);

            $query = "UPDATE rsa_kuitansi SET str_nomor_trx = NULL,str_nomor_trx_spm = NULL WHERE id_kuitansi IN ({$str})";
        
            $this->db->query($query);

        }

        

    }
    
    function set_cair($data){

        $rel_kuitansi = json_decode($data['rel_kuitansi']);

        if(count($rel_kuitansi) > 0){
            foreach($rel_kuitansi as $rel){
                $this->db->where('id_kuitansi', $rel);
                $this->db->update('rsa_kuitansi', array('cair'=>'1'));
            }
        }

    }

    function get_pengeluaran_by_akun5digit($data,$jenis = 'GP'){

//  var_dump($data);die;

                $str_ = '';
                if(count($data['array_id']) > 1){
                    foreach($data['array_id'] as $id){
                        $str_ .= "rsa_2018.rsa_kuitansi.id_kuitansi = '{$id}' OR " ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
                }else{
                    $str_ = "rsa_2018.rsa_kuitansi.id_kuitansi = '{$data['array_id'][0]}'" ;
                }

//  echo $str_ ; die;

                $lenkode = strlen($data['kode_unit_subunit']) ;
                
                $str1 = "SELECT SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) AS rka,rsa_2018.rsa_kuitansi.id_kuitansi,SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) AS kode_usulan_rkat,rba_2018.komponen_input.nama_komponen,rba_2018.subkomponen_input.nama_subkomponen,rba_2018.akun_belanja.nama_akun5digit,"
                        . "rsa_2018.rsa_kuitansi.kode_akun5digit,SUM(rsa_2018.rsa_kuitansi_detail.volume*rsa_2018.rsa_kuitansi_detail.harga_satuan) AS pengeluaran "
                        . "FROM rsa_2018.rsa_kuitansi "
                        . "JOIN rsa_2018.rsa_kuitansi_detail "
                        . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                        . "JOIN rba_2018.komponen_input ON rba_2018.komponen_input.kode_kegiatan = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,2) "
                        . "AND rba_2018.komponen_input.kode_output = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,9,2) "
                        . "AND rba_2018.komponen_input.kode_program = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,11,2) "
                        . "AND rba_2018.komponen_input.kode_komponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,13,2) "
                        . "JOIN rba_2018.subkomponen_input ON rba_2018.subkomponen_input.kode_kegiatan = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,2) "
                        . "AND rba_2018.subkomponen_input.kode_output = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,9,2) "
                        . "AND rba_2018.subkomponen_input.kode_program = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,11,2) "
                        . "AND rba_2018.subkomponen_input.kode_komponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,13,2) "
                        . "AND rba_2018.subkomponen_input.kode_subkomponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,15,2) "
                        . "JOIN rba_2018.akun_belanja ON rba_2018.akun_belanja.kode_akun5digit = rsa_2018.rsa_kuitansi.kode_akun5digit "
                        . "AND rba_2018.akun_belanja.kode_akun = rsa_2018.rsa_kuitansi.kode_akun "
                        . "AND rba_2018.akun_belanja.sumber_dana = rsa_2018.rsa_kuitansi.sumber_dana "
                        . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenkode}) = '{$data['kode_unit_subunit']}' "
                        . "AND rsa_2018.rsa_kuitansi.jenis = '{$jenis}' "
                        . "AND ( " . $str_ . " ) "
                        . "AND rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' "
                        . "GROUP BY SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10),SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,19,5) "
                        . "ORDER BY SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) ASC,SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,19,5) ASC";


$str = "SELECT 
SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) AS rka,
rsa_2018.rsa_kuitansi.id_kuitansi,
SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) AS kode_usulan_rkat,
rba_2018.komponen_input.nama_komponen,
rba_2018.subkomponen_input.nama_subkomponen,
rba_2018.akun_belanja.nama_akun5digit,
rba_2018.akun_belanja.kode_akun5digit,
SUM(rsa_2018.rsa_kuitansi_detail.volume*rsa_2018.rsa_kuitansi_detail.harga_satuan) AS pengeluaran 
FROM rsa_2018.rsa_kuitansi 
JOIN rsa_2018.rsa_kuitansi_detail 
    ON 
    rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi 
JOIN rba_2018.komponen_input 
    ON 
    rba_2018.komponen_input.kode_kegiatan = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,2) 
    AND rba_2018.komponen_input.kode_output = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,9,2) 
    AND rba_2018.komponen_input.kode_program = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,11,2) 
    AND rba_2018.komponen_input.kode_komponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,13,2) 
JOIN rba_2018.subkomponen_input 
    ON 
    rba_2018.subkomponen_input.kode_kegiatan = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,2) 
    AND rba_2018.subkomponen_input.kode_output = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,9,2) 
    AND rba_2018.subkomponen_input.kode_program = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,11,2) 
    AND rba_2018.subkomponen_input.kode_komponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,13,2) 
    AND rba_2018.subkomponen_input.kode_subkomponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,15,2) 
JOIN rba_2018.akun_belanja 
    ON 
    rba_2018.akun_belanja.kode_akun5digit = SUBSTR(rsa_2018.rsa_kuitansi_detail.kode_usulan_belanja,19,5)
    AND rba_2018.akun_belanja.kode_akun = SUBSTR(rsa_2018.rsa_kuitansi_detail.kode_usulan_belanja,19,6)
    AND rba_2018.akun_belanja.sumber_dana = rsa_2018.rsa_kuitansi.sumber_dana 
WHERE 
    SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenkode}) = '{$data['kode_unit_subunit']}' 
    AND rsa_2018.rsa_kuitansi.jenis = '{$jenis}' 
    AND ( " . $str_ . " )
    AND rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' 
GROUP BY 
    SUBSTR(rsa_2018.rsa_kuitansi_detail.kode_usulan_belanja,7,10),
    SUBSTR(rsa_2018.rsa_kuitansi_detail.kode_usulan_belanja,19,5) 
ORDER BY 
    SUBSTR(rsa_2018.rsa_kuitansi_detail.kode_usulan_belanja,7,10) ASC,
    SUBSTR(rsa_2018.rsa_kuitansi_detail.kode_usulan_belanja,19,5) ASC" ;

// echo $str;die;

// var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }


    function get_pengeluaran_by_akun4digit($data,$jenis = 'GP'){

//  var_dump($data);die;

                $str_ = '';

                if(count($data['array_id']) > 1){
                    foreach($data['array_id'] as $id){
                        $str_ = $str_ . '"' . $id . '",' ;
                    }
                    $str_ = substr($str_, 0, -1) ;
                }else{
                    $str_ = '"' . $data['array_id'][0] . '"';
                }


//  echo $str_ ; die;

                $lenkode = strlen($data['kode_unit_subunit']) ;


$str = "SELECT 
SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) AS rka,
rsa_2018.rsa_kuitansi.id_kuitansi,
SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) AS kode_usulan_rkat,
rba_2018.komponen_input.nama_komponen,
rba_2018.subkomponen_input.nama_subkomponen,
rba_2018.akun_belanja.nama_akun4digit,
rba_2018.akun_belanja.kode_akun4digit,
SUM(rsa_2018.rsa_kuitansi_detail.volume*rsa_2018.rsa_kuitansi_detail.harga_satuan) AS pengeluaran 
FROM rsa_2018.rsa_kuitansi 
JOIN rsa_2018.rsa_kuitansi_detail 
    ON 
    rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi 
JOIN rba_2018.komponen_input 
    ON 
    rba_2018.komponen_input.kode_kegiatan = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,2) 
    AND rba_2018.komponen_input.kode_output = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,9,2) 
    AND rba_2018.komponen_input.kode_program = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,11,2) 
    AND rba_2018.komponen_input.kode_komponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,13,2) 
JOIN rba_2018.subkomponen_input 
    ON 
    rba_2018.subkomponen_input.kode_kegiatan = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,2) 
    AND rba_2018.subkomponen_input.kode_output = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,9,2) 
    AND rba_2018.subkomponen_input.kode_program = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,11,2) 
    AND rba_2018.subkomponen_input.kode_komponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,13,2) 
    AND rba_2018.subkomponen_input.kode_subkomponen = SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,15,2) 
JOIN rba_2018.akun_belanja 
    ON 
    rba_2018.akun_belanja.kode_akun = SUBSTR(rsa_2018.rsa_kuitansi_detail.kode_usulan_belanja,19,6)
    AND rba_2018.akun_belanja.sumber_dana = rsa_2018.rsa_kuitansi.sumber_dana 
WHERE 
    SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$lenkode}) = '{$data['kode_unit_subunit']}' 
    AND rsa_2018.rsa_kuitansi.jenis = '{$jenis}' 
    AND rsa_2018.rsa_kuitansi.id_kuitansi IN ( " . $str_ . " )
    AND rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' 
GROUP BY 
    SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10),
    rsa_2018.rsa_kuitansi.kode_akun4digit 
ORDER BY 
    SUBSTR(rsa_2018.rsa_kuitansi.kode_usulan_belanja,7,10) ASC,
    rsa_2018.rsa_kuitansi.kode_akun4digit ASC" ;

// echo $str;die;

// var_dump($str);die;

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
                        // $str_ .= "SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) = '{$kode}' OR " ;
                        $str_ .= "'{$kode}'," ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 1 );
                }else{
                    // $str_ = "SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) = '{$data['kode_akun5digit'][0]}'" ;
                    $str_ = "'{$data['kode_akun5digit'][0]}'" ;
                }
                $lenunit = strlen($data['kode_unit_subunit']);
                $str = "SELECT SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) AS kode_usulan_rkat,"
                        . "SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) AS kode_akun5digit,"
                        . "SUM(rsa_detail_belanja_.volume*rsa_detail_belanja_.harga_satuan) AS jml_spm_lalu "
                        . "FROM rsa_detail_belanja_ "
                        . "WHERE SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$data['kode_unit_subunit']}' "
                        . "AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) IN ( " . $str_ . " ) "
                        . "AND rsa_detail_belanja_.tahun = '{$data['tahun']}' "
                        . "AND SUBSTR(rsa_detail_belanja_.proses,1,1) = '6' "
                        . "AND rsa_detail_belanja_.revisi = ( SELECT MAX(rsa_detail_belanja_.revisi) FROM rsa_detail_belanja_ WHERE SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$data['kode_unit_subunit']}' AND rsa_detail_belanja_.tahun = '{$data['tahun']}' ) "
                        . "GROUP BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10),SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) "
                        . "ORDER BY SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) ASC,SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) ASC" ;


                        echo $str ; die ;

           // var_dump($str);die;

//            var_dump($str);die;

            $q = $this->db->query($str);
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_pengeluaran_by_akun4digit_lalu($data){

                $str_ = '';
                if(count($data['kode_akun4digit']) > 1){
                    foreach($data['kode_akun4digit'] as $kode){
                        // $str_ .= "SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) = '{$kode}' OR " ;
                        $str_ .= "'{$kode}'," ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 1 );
                }else{
                    // $str_ = "SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,5) = '{$data['kode_akun5digit'][0]}'" ;
                    $str_ = "'{$data['kode_akun4digit'][0]}'" ;
                }
                $lenunit = strlen($data['kode_unit_subunit']);
                $str = "SELECT SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) AS kode_usulan_rkat,
                SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,4) AS kode_akun4digit,
                SUM(rsa_detail_belanja_.volume*rsa_detail_belanja_.harga_satuan) AS jml_spm_lalu
                FROM rsa_detail_belanja_
                WHERE SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$data['kode_unit_subunit']}'
                AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,4) IN ( " . $str_ . " ) 
                AND rsa_detail_belanja_.tahun = '{$data['tahun']}' 
                AND SUBSTR(rsa_detail_belanja_.proses,1,1) = '6' 
                AND rsa_detail_belanja_.revisi = ( SELECT MAX(rsa_detail_belanja_.revisi) FROM rsa_detail_belanja_ WHERE SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$data['kode_unit_subunit']}' AND rsa_detail_belanja_.tahun = '{$data['tahun']}' ) 
                GROUP BY 
                    SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10),
                    SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,4) 
                ORDER BY 
                    SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) ASC,
                    SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,4) ASC" ;


                        // echo $str ; die ;

           // var_dump($str);die;

//            var_dump($str);die;

            $q = $this->db->query($str);
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_pengeluaran_by_akun_rkat($data){

            $rba = $this->load->database('rba', TRUE);
            
            

                $str_ = '';
                if(count($data['kode_akun4digit']) > 1){
                    foreach($data['kode_akun4digit'] as $kode){
                        $str_ .= "SUBSTR(detail_belanja_.kode_usulan_belanja,19,4) = '{$kode}' OR " ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 3 );
                }else{
                    $str_ = "SUBSTR(detail_belanja_.kode_usulan_belanja,19,4) = '{$data['kode_akun4digit'][0]}'" ;
                }
                $lenunit = strlen($data['kode_unit_subunit']);

                $str = "SELECT SUBSTR(detail_belanja_.kode_usulan_belanja,7,10) AS kode_usulan_rkat,
                SUBSTR(detail_belanja_.kode_usulan_belanja,19,4) AS kode_akun4digit,
                SUM(detail_belanja_.volume*detail_belanja_.harga_satuan) AS pagu_rkat
                FROM detail_belanja_ 
                WHERE SUBSTR(detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$data['kode_unit_subunit']}' 
                AND ( " . $str_ . " ) 
                AND detail_belanja_.tahun = '{$data['tahun']}' 
                AND detail_belanja_.revisi = ( SELECT MAX(detail_belanja_.revisi) FROM detail_belanja_ WHERE SUBSTR(detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$data['kode_unit_subunit']}' AND detail_belanja_.tahun = '{$data['tahun']}' ) 
                GROUP BY SUBSTR(detail_belanja_.kode_usulan_belanja,7,10),
                SUBSTR(detail_belanja_.kode_usulan_belanja,19,4) 
                ORDER BY SUBSTR(detail_belanja_.kode_usulan_belanja,7,10) ASC,
                SUBSTR(detail_belanja_.kode_usulan_belanja,19,4) ASC" ;

           // echo $str;die;

            $q = $rba->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
    }

    function get_spp_pajak($data,$jenis = 'GP'){

                // if($jenis == ''){
                //     $jenis  = 'GP' ;
                // }else{
                //     $jenis  = 'GP' ;

                // }

                // switch ($jenis) {
                //     case '':
                //         $jenis = 'GP' ;
                //         break;
                //     case 'LSNK':
                //         $jenis = 'LN' ;
                //         break;
                //     case 'LSK':
                //         $jenis = 'LK' ;
                //         break;
                //     case 'EM':
                //         $jenis = 'EM' ;
                //         break;
                //     case 'TUP':
                //         $jenis = 'TP' ;
                //         break;
                //     case 'KS':
                //         $jenis = 'KS' ;
                //         break;
                //     default:
                //         $jenis = 'GP' ;
                //         break;
                // }

                $str_ = '';
                if(count($data['array_id']) > 1){
                    foreach($data['array_id'] as $id){
                        $str_ .= "'{$id}'," ;
                    }
                    $str_ = substr($str_,0,  strlen($str_) - 1 );
                }else{
                    $str_ = "'{$data['array_id'][0]}'" ;
                }

                $strlen = strlen($data['kode_unit_subunit']);

                // $str = "SELECT rsa_2018.rsa_kuitansi.id_kuitansi,"
                //         . "SUBSTR(rsa_2018.rsa_kuitansi_detail_pajak.jenis_pajak,1,3) AS jenis,"
                //         . "SUM(rsa_2018.rsa_kuitansi_detail_pajak.rupiah_pajak) AS rupiah "
                //         . "FROM rsa_2018.rsa_kuitansi "
                //         . "JOIN rsa_2018.rsa_kuitansi_detail "
                //         . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                //         . "JOIN rsa_2018.rsa_kuitansi_detail_pajak "
                //         . "ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                //         . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$strlen}) = '{$data['kode_unit_subunit']}' "
                //         . "AND rsa_2018.rsa_kuitansi.jenis = '{$jenis}' "
                //         . "AND rsa_2018.rsa_kuitansi.id_kuitansi IN ( " . $str_ . " ) "
                //         . "AND rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' "
                //         . "GROUP BY SUBSTR(rsa_2018.rsa_kuitansi_detail_pajak.jenis_pajak,1,3) "
                //         . "ORDER BY SUBSTR(rsa_2018.rsa_kuitansi_detail_pajak.jenis_pajak,1,3) DESC";

                $str = "SELECT rsa_2018.rsa_kuitansi.id_kuitansi,"
                        . "rsa_2018.rsa_kuitansi_detail_pajak.jenis_pajak AS jenis,"
                        . "SUM(rsa_2018.rsa_kuitansi_detail_pajak.rupiah_pajak) AS rupiah "
                        . "FROM rsa_2018.rsa_kuitansi "
                        . "JOIN rsa_2018.rsa_kuitansi_detail "
                        . "ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi "
                        . "JOIN rsa_2018.rsa_kuitansi_detail_pajak "
                        . "ON rsa_2018.rsa_kuitansi_detail_pajak.id_kuitansi_detail = rsa_2018.rsa_kuitansi_detail.id_kuitansi_detail "
                        . "WHERE SUBSTR(rsa_2018.rsa_kuitansi.kode_unit,1,{$strlen}) = '{$data['kode_unit_subunit']}' "
                        . "AND rsa_2018.rsa_kuitansi.jenis = '{$jenis}' "
                        . "AND rsa_2018.rsa_kuitansi.id_kuitansi IN ( " . $str_ . " ) "
                        . "AND rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' "
                        . "GROUP BY rsa_2018.rsa_kuitansi_detail_pajak.jenis_pajak "
                        . "ORDER BY SUBSTR(rsa_2018.rsa_kuitansi_detail_pajak.jenis_pajak,8,2) ASC";

           // var_dump($str);die;

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
        return $this->db->update('rsa_kuitansi',$data);
    }

    function get_id_detail_by_str_nomor_spp($nomor_trx,$jenis = 'GUP'){
        $this->db->where('str_nomor_trx',$nomor_trx);
        $q = '';
        if($jenis == 'GUP'){
                $q = $this->db->get('trx_spp_gup_data');
        }else if($jenis == 'GUP-NIHIL'){
                $q = $this->db->get('trx_spp_gup_nihil_data');
        }else if($jenis == 'TUP'){
                $q = $this->db->get('trx_spp_tup_nihil_data');
        }else if($jenis == 'LSNK'){
                $q = $this->db->get('trx_spp_lsnk_data');
        }else if($jenis == 'LSK'){
                $q = $this->db->get('trx_spp_lsk_data');
        }else if($jenis == 'EM'){
                $q = $this->db->get('trx_spp_em_data');
        }else if($jenis == 'KS'){
                $q = $this->db->get('trx_spp_ks_nihil_data');
        }

        
        //var_dump($q);die;
        if($q->num_rows() > 0){
            $str = $q->row()->data_kuitansi;
            $data_kuitansi = json_decode($str);
            // var_dump($data_kuitansi);die;
            $s_ = '';
            if(!empty($data_kuitansi)){
                foreach($data_kuitansi as $d){
                    $s_ = $s_ . $d . ',' ;
                }
                $s_ = substr($s_, 0, -1);

                $query = "SELECT * FROM rsa_kuitansi WHERE id_kuitansi IN ({$s_}) ";

                $q = $this->db->query($query);

                if($q->num_rows() > 0){
                        return $q->result();
                }else{
                     return '';
                }
            }else{
                 return '';
            }


         }else{
             return '';
         }


        // $q = $this->db->get('rsa_kuitansi');
		//var_dump($q);die;
        
    }
	
	function insert_data_kuitansi_kontrak($dt){
		$dt['waktu'] = date("Y-m-d H:i:s");
		$this->db->insert('rsa_kuitansi_pihak3',$dt);
	}
	//copy akun 5 digit P3
    
    function get_kuitansi_by_url_id($rel_kuitansi){
        $array_id = json_decode($rel_kuitansi);
        // var_dump($array_id); die;
        $id_kuitansi = '' ;


        if(count($array_id) > 0){

            foreach($array_id as $id){
               
    //            $q = $this->db->get('rsa_kuitansi');
                //var_dump($q);die;
                // $result[] = $q->row();
                $id_kuitansi = $id_kuitansi . '"' .$id . '",' ;

               } 

               $id_kuitansi = substr($id_kuitansi, 0, -1) ;
            

             $str = "SELECT rsa_2018.rsa_kuitansi.id_kuitansi,
             rsa_2018.rsa_kuitansi.no_bukti,
             rsa_2018.rsa_kuitansi.tgl_kuitansi,
             rsa_2018.rsa_kuitansi.uraian,
             SUM(rsa_2018.rsa_kuitansi_detail.volume*rsa_2018.rsa_kuitansi_detail.harga_satuan) AS pengeluaran,
             rsa_2018.rsa_kuitansi.str_nomor_trx,
             rsa_2018.rsa_kuitansi.str_nomor_trx_spm,
             rsa_2018.rsa_kuitansi.aktif,
             rsa_2018.rsa_kuitansi.cair 
             FROM rsa_2018.rsa_kuitansi 
             JOIN rsa_2018.rsa_kuitansi_detail 
                ON rsa_2018.rsa_kuitansi_detail.id_kuitansi = rsa_2018.rsa_kuitansi.id_kuitansi 
            WHERE rsa_2018.rsa_kuitansi.id_kuitansi IN ({$id_kuitansi}) GROUP BY rsa_2018.rsa_kuitansi.id_kuitansi";

            // echo $str; die;

           // print_r($str);die;

            $q = $this->db->query($str);

            if($q->num_rows() > 0){

                return $q->result() ;

            }else{
                return array();
            }
        }else{
                return array();
        }
    }
	//copy dr idris alaik
	function get_pekerjaan_by_array_id($data){
        $pekerjaan = 0 ;
        foreach($data['array_id'] as $id){
            $str = "SELECT * "
                . "FROM rsa_2018.rsa_kuitansi "
                . "WHERE rsa_2018.rsa_kuitansi.kode_unit = '{$data['kode_unit_subunit']}' "
                . "AND rsa_2018.rsa_kuitansi.id_kuitansi = '{$id}' "
                . "AND rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' ";

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
            $str = "SELECT * FROM rsa_spm_prosespihak3 LEFT JOIN rsa_kuitansi_pihak3 ON rsa_spm_prosespihak3.id_rup=rsa_kuitansi_pihak3.kontrak_id LEFT JOIN rsa_spm_rekananpihak3 ON rsa_spm_prosespihak3.id_rekanan=rsa_spm_rekananpihak3.id_rekanan WHERE kuitansi_id = '{$id}' ";
               // . "AND rsa_2018.rsa_kuitansi.id_kuitansi = '{$id}' "
                //. "AND rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' ";

         //   var_dump($str);die;

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
            $str = "SELECT * FROM rsa_spm_rinciankontrak LEFT JOIN rsa_kuitansi_pihak3 ON rsa_spm_rinciankontrak.id_pembayaran=rsa_kuitansi_pihak3.kontrak_id LEFT JOIN rsa_spm_kontrakpihak3 ON rsa_spm_rinciankontrak. 	id_pembayaran=rsa_spm_kontrakpihak3.id WHERE kuitansi_id = '{$id}' ";
               // . "AND rsa_2018.rsa_kuitansi.id_kuitansi = '{$id}' "
                //. "AND rsa_2018.rsa_kuitansi.tahun = '{$data['tahun']}' ";

         //   var_dump($str);die;

            $q = $this->db->query($str);
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }
        }

        //return $pekerjaan;
    }
    
    
    
    
    function get_gup_akun_lalu($kode_unit_subunit,$tahun){
        
            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE t1.kode_unit_subunit = '{$kode_unit_subunit}' AND t1.jenis_trx = 'GUP' AND t1.tahun = '{$tahun}' "
                    . "AND tgl_proses = ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.kode_unit_subunit = '{$kode_unit_subunit}' AND t2.jenis_trx = 'GUP' AND t2.tahun = '{$tahun}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
//                    echo $str; die;
                    
            $q = $this->db->query($str);
//            var_dump($q->result());die;
    //            var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
            
        }
        
        function get_gup_akun_before_by_spm($nomor_spm_cair_before){
            
            $tahun = substr($nomor_spm_cair_before,-4,4);
            
            $kdunit = substr($nomor_spm_cair_before,6,3);
//            echo $kdunit ; die;
            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE SUBSTR(t1.str_nomor_trx_spm,7,3) = '{$kdunit}' AND t1.jenis_trx = 'GUP' AND t1.tahun = '{$tahun}' "
                    . "AND tgl_proses < ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.str_nomor_trx_spm = '{$nomor_spm_cair_before}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
           // echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }

        function get_tup_akun_before_by_spm($nomor_spm_cair_before){
            
            $tahun = substr($nomor_spm_cair_before,-4,4);
            
            $kdunit = substr($nomor_spm_cair_before,6,3);
//            echo $kdunit ; die;
            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE SUBSTR(t1.str_nomor_trx_spm,7,3) = '{$kdunit}' AND t1.jenis_trx = 'TUP' AND t1.tahun = '{$tahun}' "
                    . "AND tgl_proses < ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.str_nomor_trx_spm = '{$nomor_spm_cair_before}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
           // echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }

        function get_lsnk_akun_before_by_spm($nomor_spm_cair_before){
            
            $tahun = substr($nomor_spm_cair_before,-4,4);
            
            $kdunit = substr($nomor_spm_cair_before,6,3);
//            echo $kdunit ; die;
            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE SUBSTR(t1.str_nomor_trx_spm,7,3) = '{$kdunit}' AND t1.jenis_trx = 'LSNK' AND t1.tahun = '{$tahun}' "
                    . "AND tgl_proses < ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.str_nomor_trx_spm = '{$nomor_spm_cair_before}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
           // echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }

        function get_em_akun_before_by_spm($nomor_spm_cair_before){
            
            $tahun = substr($nomor_spm_cair_before,-4,4);
            
            $kdunit = substr($nomor_spm_cair_before,6,3);
//            echo $kdunit ; die;
            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE SUBSTR(t1.str_nomor_trx_spm,7,3) = '{$kdunit}' AND t1.jenis_trx = 'EM' AND t1.tahun = '{$tahun}' "
                    . "AND tgl_proses < ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.str_nomor_trx_spm = '{$nomor_spm_cair_before}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
           // echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }

        function get_lsk_akun_before_by_spm($nomor_spm_cair_before){
            
            $tahun = substr($nomor_spm_cair_before,-4,4);
            
            $kdunit = substr($nomor_spm_cair_before,6,3);
//            echo $kdunit ; die;
            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE SUBSTR(t1.str_nomor_trx_spm,7,3) = '{$kdunit}' AND t1.jenis_trx = 'LSK' AND t1.tahun = '{$tahun}' "
                    . "AND tgl_proses < ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.str_nomor_trx_spm = '{$nomor_spm_cair_before}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
           // echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }


        function get_gup_akun_before_by_spp($nomor_spp_cair_before){
            
            $tahun = substr($nomor_spp_cair_before,-4,4);
            
            $kdunit = substr($nomor_spm_cair_before,6,3);
//            echo $kdunit ; die;


            $str = "SELECT str_nomor_trx_spm FROM trx_spp_spm "
                    . "JOIN trx_urut_cair" ;

            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE SUBSTR(t1.str_nomor_trx_spm,7,3) = '{$kdunit}' AND t1.jenis_trx = 'GUP' AND t1.tahun = '{$tahun}' "
                    . "AND tgl_proses < ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.str_nomor_trx_spm = '{$nomor_spm_cair_before}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
           // echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }
        
        function get_gup_akun_before_by_unit($kode_unit_subunit,$tahun){
//            $tahun = substr($nomor_spm_cair_before,-4,4);
            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE t1.kode_unit_subunit = '{$kode_unit_subunit}' AND t1.tahun = '{$tahun}' " ; // AND t1.jenis_trx = 'GUP'
//                    . "AND tgl_proses < ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.kode_unit_subunit = '{$kode_unit_subunit}' AND t2.jenis_trx = 'GUP' AND t2.tahun = '{$tahun}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
//            echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }

        function get_tup_akun_before_by_unit($kode_unit_subunit,$tahun){
//            $tahun = substr($nomor_spm_cair_before,-4,4);
            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE t1.kode_unit_subunit = '{$kode_unit_subunit}' AND t1.tahun = '{$tahun}' " ; // AND t1.jenis_trx = 'TUP'
//                    . "AND tgl_proses < ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.kode_unit_subunit = '{$kode_unit_subunit}' AND t2.jenis_trx = 'GUP' AND t2.tahun = '{$tahun}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
           // echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }

        function get_em_akun_before_by_unit($kode_unit_subunit,$tahun){
//            $tahun = substr($nomor_spm_cair_before,-4,4);
            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE t1.kode_unit_subunit = '{$kode_unit_subunit}' AND t1.tahun = '{$tahun}' " ; // AND t1.jenis_trx = 'TUP'
//                    . "AND tgl_proses < ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.kode_unit_subunit = '{$kode_unit_subunit}' AND t2.jenis_trx = 'GUP' AND t2.tahun = '{$tahun}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
           // echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }

        function get_akun_before_by_unit($kode_unit_subunit,$tahun){
//            $tahun = substr($nomor_spm_cair_before,-4,4);
            $str1 = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 
            JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm
            WHERE t1.kode_unit_subunit = '{$kode_unit_subunit}' AND t1.tahun = '{$tahun}' " ; 


            $str2 = "SELECT SUBSTR(rsa_kuitansi_detail.kode_usulan_belanja,19,5) AS kode_akun5digit FROM trx_urut_spm_cair AS t1 
            JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm
            JOIN rsa_kuitansi_detail ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi 
            WHERE t1.kode_unit_subunit = '{$kode_unit_subunit}' AND t1.tahun = '{$tahun}' " ;


            $str = "SELECT SUBSTR(a.kode_usulan_belanja,19,4)  AS kode_akun4digit 
            FROM rsa_detail_belanja_ AS a
            WHERE SUBSTR(a.proses,1,1) = '6'
            GROUP BY SUBSTR(a.kode_usulan_belanja,19,4)
            ORDER BY SUBSTR(a.kode_usulan_belanja,19,4) ASC" ;
            
           // echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }

        function get_lsk_akun_before_by_unit($kode_unit_subunit,$tahun){
//            $tahun = substr($nomor_spm_cair_before,-4,4);
            $str = "SELECT rsa_kuitansi.kode_akun5digit FROM trx_urut_spm_cair AS t1 "
                    . "JOIN rsa_kuitansi ON rsa_kuitansi.str_nomor_trx_spm = t1.str_nomor_trx_spm "
                    . "WHERE t1.kode_unit_subunit = '{$kode_unit_subunit}' AND t1.tahun = '{$tahun}' " ; // AND t1.jenis_trx = 'TUP'
//                    . "AND tgl_proses < ( SELECT MAX(tgl_proses) FROM trx_urut_spm_cair AS t2 WHERE t2.kode_unit_subunit = '{$kode_unit_subunit}' AND t2.jenis_trx = 'GUP' AND t2.tahun = '{$tahun}' ) " ;
//                    . "AND t1.str_nomor_trx_spm NOT LIKE '%{$trx_spm}%' " ;
            
           // echo $str; die;
                    
            $q = $this->db->query($str);
            
//            var_dump($q->result());die;
            
//                var_dump($q->num_rows());die;
                if($q->num_rows() > 0){
                   return $q->result();
                }else{
                    return '';
                }
            
        }


        function pindah_kuitansi_tup($data_kuitansi){
            $str = "UPDATE rsa_kuitansi JOIN rsa_kuitansi_detail ON rsa_kuitansi_detail.id_kuitansi = rsa_kuitansi.id_kuitansi JOIN rsa_detail_belanja_ ON rsa_detail_belanja_.kode_usulan_belanja = rsa_kuitansi_detail.kode_usulan_belanja AND rsa_detail_belanja_.kode_akun_tambah = rsa_kuitansi_detail.kode_akun_tambah SET rsa_kuitansi.jenis = 'TP',rsa_detail_belanja_.proses = '33'  WHERE rsa_kuitansi.id_kuitansi IN ({$data_kuitansi})";

            if($this->db->query($str)){
                return true;
            }else{
                false;
            }



        }

        function edit_tgl_kuitansi($id_kuitansi,$tgl_kuitansi,$tahun){

            $this->db->where('id_kuitansi', $id_kuitansi);
            $this->db->where('tahun', $tahun);
            return $this->db->update('rsa_kuitansi', array('tgl_kuitansi'=>$tgl_kuitansi));

        }

        function edit_alias_kuitansi($id_kuitansi,$alias_no_bukti,$tahun){

            $this->db->where('id_kuitansi', $id_kuitansi);
            $this->db->where('tahun', $tahun);
            return $this->db->update('rsa_kuitansi', array('alias_no_bukti'=>$alias_no_bukti.'A'));

        }

                        function edit_kuitansi($id_kuitansi,$data,$tahun){

                                // var_dump($data);die;

                                $this->db->where('id_kuitansi', $id_kuitansi);
                                $this->db->where('tahun', $tahun);
                                $this->db->update('rsa_kuitansi',$data);
                        }

        function check_valid_kuitansi_by_id($id_kuitansi,$tahun){
            $this->db->where('id_kuitansi', $id_kuitansi);
            $this->db->where('tahun', $tahun);
            $q = $this->db->get('rsa_kuitansi');
            if($q->num_rows() > 0){
                $data = $q->row();
                if(($data->str_nomor_trx === NULL)&&($data->str_nomor_trx_spm === NULL)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }

        function get_data_penerima($q,$kode_unit,$tahun){

            $query = "SELECT DISTINCT(CONCAT(penerima_uang,'|',penerima_uang_nip)) AS str_penerima FROM rsa_kuitansi WHERE penerima_uang LIKE '%{$q}%' AND kode_unit = '{$kode_unit}' AND tahun = '{$tahun}'
UNION
SELECT DISTINCT(CONCAT(penerima_barang,'|',penerima_barang_nip)) AS str_penerima FROM rsa_kuitansi WHERE penerima_barang LIKE '%{$q}%' AND kode_unit = '{$kode_unit}' AND tahun = '{$tahun}'  " ;

            // echo $query ; die;


            $q = $this->db->query($query);

                    if($q->num_rows() > 0){
                       return $q->result();
                    }else{
                        return array();
                    }

        }

        function get_data_penerima_only($q,$kode_unit,$tahun){

            $query = "SELECT penerima_uang AS str_penerima FROM rsa_kuitansi WHERE penerima_uang LIKE '%{$q}%' AND kode_unit = '{$kode_unit}' AND tahun = '{$tahun}'
UNION
SELECT penerima_uang_nip AS str_penerima FROM rsa_kuitansi WHERE penerima_uang_nip LIKE '%{$q}%' AND kode_unit = '{$kode_unit}' AND tahun = '{$tahun}' 
UNION
SELECT penerima_barang AS str_penerima FROM rsa_kuitansi WHERE penerima_barang LIKE '%{$q}%' AND kode_unit = '{$kode_unit}' AND tahun = '{$tahun}' 
UNION
SELECT penerima_barang_nip AS str_penerima FROM rsa_kuitansi WHERE penerima_barang_nip LIKE '%{$q}%' AND kode_unit = '{$kode_unit}' AND tahun = '{$tahun}' " ;

            // echo $query ; die;


            $q = $this->db->query($query);

                    if($q->num_rows() > 0){
                       return $q->result();
                    }else{
                        return array();
                    }

        }


        function get_data_uraian($q,$kode_unit,$tahun){

            $query = "SELECT uraian FROM rsa_kuitansi WHERE uraian LIKE '%{$q}%' AND kode_unit = '{$kode_unit}' AND tahun = '{$tahun}' GROUP BY uraian" ;

            // echo $query ; die;


            $q = $this->db->query($query);

                    if($q->num_rows() > 0){
                       return $q->result();
                    }else{
                        return array();
                    }

        }


}
