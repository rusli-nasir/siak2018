<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tor_model extends CI_Model {
    /* -------------- Constructor ------------- */

    private $db2;
    public function __construct()
    {
                // Call the CI_Model constructor
        parent::__construct();
        $this->db2 = $this->load->database('rba', TRUE);
        $this->load->helper('vayes_helper');
    }


    public function get_db2()
    {
      return $this->db2->get('detail_belanja_');
  }
  function get_detail_unit($kode_unit){
    $rba = $this->load->database('rba', TRUE);
    $query = "SELECT rba_2018.unit.kode_unit, rba_2018.unit.nama_unit "
    . "FROM rba_2018.unit "
    . "WHERE rba_2018.unit.kode_unit = '{$kode_unit}' ";

    $q = $rba->query($query);
    $result = $q->row();
    return $result;

}

function get_tor_usul($kode_rka){

    $rba = $this->load->database('rba', TRUE);
    $kegiatan = substr($kode_rka,0,2);
    $output = substr($kode_rka,2,2);
    $program = substr($kode_rka,4,2);
    $komponen_input = substr($kode_rka,6,2);
    $subkomponen_input = substr($kode_rka,8,2);

    $query = "SELECT kegiatan.kode_kegiatan,output.kode_output,program.kode_program,komponen_input.kode_komponen,subkomponen_input.kode_subkomponen,kegiatan.nama_kegiatan,output.nama_output,program.nama_program,komponen_input.nama_komponen,subkomponen_input.nama_subkomponen "
    . "FROM subkomponen_input "
    . "JOIN kegiatan ON subkomponen_input.kode_kegiatan = kegiatan.kode_kegiatan "
    . "JOIN output ON subkomponen_input.kode_kegiatan = output.kode_kegiatan AND subkomponen_input.kode_output = output.kode_output "
    . "JOIN program ON subkomponen_input.kode_kegiatan = program.kode_kegiatan AND subkomponen_input.kode_output = program.kode_output AND subkomponen_input.kode_program = program.kode_program "
    . "JOIN komponen_input ON subkomponen_input.kode_kegiatan = komponen_input.kode_kegiatan AND subkomponen_input.kode_output = komponen_input.kode_output AND subkomponen_input.kode_program = komponen_input.kode_program AND subkomponen_input.kode_komponen = komponen_input.kode_komponen "
    . "WHERE subkomponen_input.kode_kegiatan = '{$kegiatan}' AND subkomponen_input.kode_output = '{$output}' AND subkomponen_input.kode_program = '{$program}' AND subkomponen_input.kode_komponen = '{$komponen_input}' AND subkomponen_input.kode_subkomponen = '{$subkomponen_input}' ";

    $q = $rba->query($query);
    $result = $q->row();
    return $result;

}

function get_detail_rsa($unit,$kode,$sumber_dana,$tahun){

            //$unit = substr($kode,0,2);
    $lenunit = strlen($unit);
            $rka = $kode;//substr($kode,2,10);

            $query  = "SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_usulan_belanja,rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun,rba_2018.subunit.nama_subunit,rba_2018.sub_subunit.nama_sub_subunit,rsa_detail_belanja_.volume,rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan,rsa_detail_belanja_.kode_akun_tambah,RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) AS akun,rsa_detail_belanja_.impor,rsa_detail_belanja_.proses,rsa_detail_belanja_tolak.ket FROM "
            . "rsa_detail_belanja_ "
            . "JOIN rba_2018.akun_belanja ON RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) = rba_2018.akun_belanja.kode_akun AND rsa_detail_belanja_.sumber_dana = rba_2018.akun_belanja.sumber_dana "
            . "JOIN rba_2018.subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,4) = rba_2018.subunit.kode_subunit "
            . "JOIN rba_2018.sub_subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,6) = rba_2018.sub_subunit.kode_sub_subunit "
            . "LEFT JOIN rsa_detail_belanja_tolak ON rsa_detail_belanja_.id_rsa_detail = rsa_detail_belanja_tolak.id_rsa_detail "
            . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' "
            . "AND rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}') "
            . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
            . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
            . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
            . "rsa_detail_belanja_.kode_akun_tambah ASC" ;


            $query      = $this->db->query($query) ;
            if ($query->num_rows()>0){
                return $query->result();
            }else{
                return array();
            }
        }

        function get_detail_rsa_to_validate($unit,$kode,$sumber_dana,$tahun){

            $lenunit = strlen($unit);
            $rka = $kode;//substr($kode,2,10);

            $query  = "SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_usulan_belanja,rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun,rba_2018.subunit.nama_subunit,rba_2018.sub_subunit.nama_sub_subunit,rsa_detail_belanja_.volume,rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan,rsa_detail_belanja_.kode_akun_tambah,RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) AS akun,rsa_detail_belanja_.impor,rsa_detail_belanja_.proses,rsa_detail_belanja_tolak.ket FROM "
            . "rsa_detail_belanja_ "
            . "JOIN rba_2018.akun_belanja ON RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) = rba_2018.akun_belanja.kode_akun AND rsa_detail_belanja_.sumber_dana = rba_2018.akun_belanja.sumber_dana "
            . "JOIN rba_2018.subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,4) = rba_2018.subunit.kode_subunit "
            . "JOIN rba_2018.sub_subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,6) = rba_2018.sub_subunit.kode_sub_subunit "
            . "LEFT JOIN rsa_detail_belanja_tolak ON rsa_detail_belanja_.id_rsa_detail = rsa_detail_belanja_tolak.id_rsa_detail "
            . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' "
            . "AND rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ "
            . "WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}') "
            . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
            . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
            . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
            . "rsa_detail_belanja_.kode_akun_tambah ASC" ;
//                 var_dump($query);die;
            $query      = $this->db->query($query) ;

            if ($query->num_rows()>0){
                return $query->result();
            }else{
                return array();
            }
        }

        function get_detail_rsa_dpa($unit,$kode,$sumber_dana,$tahun){

//            $unit = substr($kode,0,2);
            $lenunit = strlen($unit);
            $rka = $kode;//substr($kode,2,10);

            $query1  = "SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_usulan_belanja,rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun,rba_2018.subunit.nama_subunit,rba_2018.sub_subunit.nama_sub_subunit,"
            . "rsa_detail_belanja_.kode_akun_tambah,SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,6) AS akun,rsa_detail_belanja_.impor,rsa_detail_belanja_.proses,rkd1.id_kuitansi,"
            . "rsa_detail_belanja_.volume,rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan,rsa_kuitansi.aktif,rkd1.id_kuitansi AS rsa_kuitansi_detail_id_kuitansi,rsa_kuitansi.no_bukti,rsa_kuitansi.str_nomor_trx,rsa_kuitansi.str_nomor_trx_spm "
            . "FROM rsa_detail_belanja_ "
            . "JOIN rba_2018.akun_belanja ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,6) = rba_2018.akun_belanja.kode_akun AND rsa_detail_belanja_.sumber_dana = rba_2018.akun_belanja.sumber_dana "
            . "JOIN rba_2018.subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,4) = rba_2018.subunit.kode_subunit "
            . "JOIN rba_2018.sub_subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,6) = rba_2018.sub_subunit.kode_sub_subunit "
            . "LEFT JOIN rsa_kuitansi_detail AS rkd1 ON rsa_detail_belanja_.kode_usulan_belanja = rkd1.kode_usulan_belanja AND rsa_detail_belanja_.kode_akun_tambah = rkd1.kode_akun_tambah "
            . "LEFT JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rkd1.id_kuitansi "
            . "WHERE SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' AND SUBSTR(rsa_detail_belanja_.proses,1,1) > 2 "
            . "AND rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' GROUP BY rsa_detail_belanja_.impor ) "
            . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
            . "AND ( rkd1.id_kuitansi = (SELECT MAX(rkd2.id_kuitansi) FROM rsa_kuitansi_detail AS rkd2 WHERE rkd2.kode_usulan_belanja = rkd1.kode_usulan_belanja AND rkd2.kode_akun_tambah = rkd1.kode_akun_tambah AND rkd2.sumber_dana = '{$sumber_dana}' AND rkd2.tahun = '{$tahun}'  ) "
                    . "OR ISNULL(rkd1.id_kuitansi) ) " // -> DI COMMENT OLEH IDRIS
                    . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6), "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6), "
                    . "rsa_detail_belanja_.kode_akun_tambah "
                    . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "rsa_detail_belanja_.kode_akun_tambah ASC " ;


                    $query  = "SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_usulan_belanja,rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun,rba_2018.subunit.nama_subunit,rba_2018.sub_subunit.nama_sub_subunit,"
                    . "rsa_detail_belanja_.kode_akun_tambah,SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,6) AS akun,rsa_detail_belanja_.impor,rsa_detail_belanja_.proses,"
                    . "rsa_detail_belanja_.volume,rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan "
                    . "FROM rsa_detail_belanja_ "
                    . "JOIN rba_2018.akun_belanja ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,19,6) = rba_2018.akun_belanja.kode_akun AND rsa_detail_belanja_.sumber_dana = rba_2018.akun_belanja.sumber_dana "
                    . "JOIN rba_2018.subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,4) = rba_2018.subunit.kode_subunit "
                    . "JOIN rba_2018.sub_subunit ON SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,6) = rba_2018.sub_subunit.kode_sub_subunit "
                    . "WHERE SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,{$lenunit}) = '{$unit}' AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' AND SUBSTR(rsa_detail_belanja_.proses,1,1) > 2 "
                    . "AND rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' GROUP BY rsa_detail_belanja_.impor ) "
                    . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' "
                    . "GROUP BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6), "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6), "
                    . "rsa_detail_belanja_.kode_akun_tambah "
                    . "ORDER BY LEFT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "RIGHT(rsa_detail_belanja_.kode_usulan_belanja,6) ASC, "
                    . "rsa_detail_belanja_.kode_akun_tambah ASC " ;


                    $query      = $this->db->query($query) ;
                    if ($query->num_rows()>0){
                        return $query->result();
                    }else{
                        return array();
                    }
                }


                function get_status_jenis($rka,$sumber_dana,$tahun){

                    $kode_usulan_belanja = substr($rka,0,24);
                    $kode_akun_tambah = substr($rka,24,3);

                    $query = "SELECT rsa_detail_belanja_.proses FROM rsa_detail_belanja_ WHERE rsa_detail_belanja_.kode_usulan_belanja = '{$kode_usulan_belanja}' AND rsa_detail_belanja_.kode_akun_tambah = '{$kode_akun_tambah}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}'" ;

                    $query = $this->db->query($query) ;
                    return $query->row()->proses;
                }



                function get_status_dpa($rka,$sumber_dana,$tahun){

                    $kode_usulan_belanja = substr($rka,0,24);
                    $kode_akun_tambah = substr($rka,24,3);

                    $query = "SELECT rsa_kuitansi.id_kuitansi,rsa_kuitansi.aktif,rsa_kuitansi.no_bukti,rsa_kuitansi.str_nomor_trx,rsa_kuitansi.str_nomor_trx_spm,rsa_detail_belanja_.proses
                        FROM rsa_kuitansi_detail
                        JOIN rsa_detail_belanja_ ON rsa_detail_belanja_.kode_usulan_belanja = rsa_kuitansi_detail.kode_usulan_belanja AND rsa_detail_belanja_.kode_akun_tambah = rsa_kuitansi_detail.kode_akun_tambah
                        JOIN rsa_kuitansi ON rsa_kuitansi.id_kuitansi = rsa_kuitansi_detail.id_kuitansi
                        WHERE rsa_kuitansi_detail.kode_usulan_belanja = '{$kode_usulan_belanja}' AND rsa_kuitansi_detail.kode_akun_tambah = '{$kode_akun_tambah}'
                        ORDER BY rsa_kuitansi_detail.id_kuitansi_detail";


                    $query      = $this->db->query($query) ;
                    return $query->result_array();

                }

                function get_single_detail_rsa_dpa($kode_usulan_belanja,$kode_akun_tambah,$sumber_dana,$tahun){

                    $unit = substr($kode_usulan_belanja,0,2);

                    $query  = "SELECT rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.volume,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan "
                    . "FROM rsa_detail_belanja_ "
                    . "WHERE rsa_detail_belanja_.kode_usulan_belanja = '{$kode_usulan_belanja}' AND rsa_detail_belanja_.kode_akun_tambah = '{$kode_akun_tambah}' "
                    . "AND rsa_detail_belanja_.impor = ( SELECT MAX(rsa_detail_belanja_.impor) FROM rsa_detail_belanja_ WHERE LEFT(rsa_detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' ) "
                    . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' AND rsa_detail_belanja_.tahun = '{$tahun}' " ;

                    $query      = $this->db->query($query) ;
                    if ($query->num_rows()>0){
                        return $query->row();
                    }else{
                        return array();
                    }
                }

                function get_detail_akun_rba($unit,$kode,$sumber_dana,$tahun){
                    $lenunit = strlen($unit);
            $rka = $kode;//substr($kode,2,10);

            $rba = $this->load->database('rba', TRUE);

            $query  = "SELECT rba_2018.detail_belanja_.kode_usulan_belanja,rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun,rba_2018.subunit.nama_subunit,rba_2018.sub_subunit.nama_sub_subunit,SUM(rba_2018.detail_belanja_.volume*rba_2018.detail_belanja_.harga_satuan) AS total_harga,rba_2018.detail_belanja_.revisi FROM "
            . "rba_2018.detail_belanja_ "
            . "JOIN rba_2018.akun_belanja ON RIGHT(rba_2018.detail_belanja_.kode_usulan_belanja,6) = rba_2018.akun_belanja.kode_akun AND rba_2018.detail_belanja_.sumber_dana = rba_2018.akun_belanja.sumber_dana "
            . "JOIN rba_2018.subunit ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,1,4) = rba_2018.subunit.kode_subunit "
            . "JOIN rba_2018.sub_subunit ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,1,6) = rba_2018.sub_subunit.kode_sub_subunit "
            . "WHERE LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}' AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' "
            . "AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' "
            . "AND rba_2018.detail_belanja_.revisi = (SELECT MAX(rba_2018.detail_belanja_.revisi) FROM rba_2018.detail_belanja_ WHERE LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,{$lenunit}) = '{$unit}') "
            . "GROUP BY LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,6),RIGHT(rba_2018.detail_belanja_.kode_usulan_belanja,6) "
            . "ORDER BY LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,6) ASC, "
            . "RIGHT(rba_2018.detail_belanja_.kode_usulan_belanja,6) ASC " ;

            $query      = $rba->query($query) ;
            if ($query->num_rows()>0){
                return $query->result();
            }else{
                return array();
            }
        }

    function get_detail_akun_subakun_rba($unit,$kode,$sumber_dana,$tahun,$proses='',$jenis=''){

        $rba = $this->load->database('rba', TRUE);
        // print_r($unit);
        $unit_login = $unit;
        $unit = substr($unit,0,2);

        if (strlen($unit_login) == 2) {
            /************************ QUERY ************************/
            $query_kode_subunit = "SELECT DISTINCT substr(kode_usulan_belanja,1,4) as kode_subunit, substr(kode_usulan_belanja, 17,2) as kode_sumber_dana FROM detail_belanja_ WHERE substr(kode_usulan_belanja,7,10) = '{$kode}' AND substr(kode_usulan_belanja,1,2) = '{$unit}' and sumber_dana = '{$sumber_dana}' ORDER by substr(kode_usulan_belanja,1,4)";

            $query_kode_subunit  = $rba->query($query_kode_subunit);
            $result_kode_subunit = $query_kode_subunit->result();
            /************************ ! END QUERY ************************/
        }else if(strlen($unit_login) == 4){
            /************************ QUERY ************************/
            $query_kode_subunit = "SELECT DISTINCT substr(kode_usulan_belanja,1,4) as kode_subunit, substr(kode_usulan_belanja, 17,2) as kode_sumber_dana FROM detail_belanja_ WHERE substr(kode_usulan_belanja,7,10) = '{$kode}' AND substr(kode_usulan_belanja,1,4) = '{$unit_login}' and sumber_dana = '{$sumber_dana}' ORDER by substr(kode_usulan_belanja,1,4)";

            $query_kode_subunit  = $rba->query($query_kode_subunit);
            $result_kode_subunit = $query_kode_subunit->result();
            /************************ ! END QUERY ************************/
        }else if(strlen($unit_login) == 6){
            /************************ QUERY ************************/
            $query_kode_subunit = "SELECT DISTINCT substr(kode_usulan_belanja,1,4) as kode_subunit, substr(kode_usulan_belanja, 17,2) as kode_sumber_dana FROM detail_belanja_ WHERE substr(kode_usulan_belanja,7,10) = '{$kode}' AND substr(kode_usulan_belanja,1,4) = '".substr($unit_login,0,4)."' and sumber_dana = '{$sumber_dana}' ORDER by substr(kode_usulan_belanja,1,4)";

            $query_kode_subunit  = $rba->query($query_kode_subunit);
            $result_kode_subunit = $query_kode_subunit->result();
            /************************ ! END QUERY ************************/
        }
      
        foreach ($result_kode_subunit as $res_kode_subunit) {
            $kode_sumber_dana = $res_kode_subunit->kode_sumber_dana;
            $kode_subunit     = $res_kode_subunit->kode_subunit;

            /************************ QUERY ************************/
            $query_nama_subunit = "SELECT nama_subunit
            FROM subunit
            WHERE kode_subunit = '{$kode_subunit}'
            ";
            $query_nama_subunit = $rba->query($query_nama_subunit);
            $result_nama_subunit = $query_nama_subunit->row();
            /************************ ! END QUERY ************************/

            $data[$kode_subunit] = array(
                'nama_subunit'  => $result_nama_subunit->nama_subunit,
                'notif_subunit'     => '',
                'data'  => array()
            );
        }

        foreach ($data as $key_subunit => $val_subunit) {
            $sum_notif_sub_subunit = 0;
            
            if (strlen($unit_login) == 2) {
                /************************ QUERY ************************/
                $query_kode_sub_subunit = "SELECT DISTINCT substr(kode_usulan_belanja,1,6) as kode_sub_subunit FROM detail_belanja_ WHERE substr(kode_usulan_belanja,7,10) = '{$kode}' AND substr(kode_usulan_belanja,1,2) = '{$unit}' AND substr(kode_usulan_belanja,1,4) = '{$key_subunit}'  and sumber_dana = '{$sumber_dana}' ORDER by substr(kode_usulan_belanja,1,6)";

                $query_kode_sub_subunit   = $rba->query($query_kode_sub_subunit);
                $result_kode_sub_subunit  = $query_kode_sub_subunit->result();
                /************************ ! END QUERY ************************/
            }else if(strlen($unit_login) == 4){
                /************************ QUERY ************************/
                $query_kode_sub_subunit = "SELECT DISTINCT substr(kode_usulan_belanja,1,6) as kode_sub_subunit FROM detail_belanja_ WHERE substr(kode_usulan_belanja,7,10) = '{$kode}' AND substr(kode_usulan_belanja,1,2) = '{$unit}' AND substr(kode_usulan_belanja,1,4) = '{$key_subunit}'  and sumber_dana = '{$sumber_dana}' ORDER by substr(kode_usulan_belanja,1,6)";

                $query_kode_sub_subunit   = $rba->query($query_kode_sub_subunit);
                $result_kode_sub_subunit  = $query_kode_sub_subunit->result();
                /************************ ! END QUERY ************************/
                // vdebug($unit_login);
            }else if(strlen($unit_login) == 6){
                /************************ QUERY ************************/
                $query_kode_sub_subunit = "SELECT DISTINCT substr(kode_usulan_belanja,1,6) as kode_sub_subunit FROM detail_belanja_ WHERE substr(kode_usulan_belanja,7,10) = '{$kode}' AND substr(kode_usulan_belanja,1,6) = '{$unit_login}'  and sumber_dana = '{$sumber_dana}' ORDER by substr(kode_usulan_belanja,1,6)";

                $query_kode_sub_subunit   = $rba->query($query_kode_sub_subunit);
                $result_kode_sub_subunit  = $query_kode_sub_subunit->result();
                /************************ ! END QUERY ************************/
                // vdebug($unit_login);
            }

            foreach ($result_kode_sub_subunit as $res_kode_sub_subunit) {
                $kode_sub_subunit = $res_kode_sub_subunit->kode_sub_subunit;

                /************************ QUERY ************************/
                $query_nama_sub_subunit = "SELECT nama_sub_subunit
                FROM sub_subunit
                WHERE kode_sub_subunit = '{$kode_sub_subunit}'";

                $query_nama_sub_subunit = $rba->query($query_nama_sub_subunit);
                $result_nama_sub_subunit = $query_nama_sub_subunit->row();
                /************************ ! END QUERY ************************/

                $data[$key_subunit]['data'][$kode_sub_subunit] = array(
                'nama_sub_subunit'      => $result_nama_sub_subunit->nama_sub_subunit,
                'notif_sub_subunit'     => '',
                'data'  => array()
                );
            }

            foreach ($data[$key_subunit]['data'] as $key_sub_subunit => $val_sub_subunit) { 
                $sum_notif_4d = 0;

                /************************ QUERY ************************/
                $query_get_akun4d = "SELECT DISTINCT substr(kode_usulan_belanja,19,4) as kode_akun4d FROM detail_belanja_ WHERE substr(kode_usulan_belanja,7,10) = '{$kode}' AND substr(kode_usulan_belanja,1,2) = '{$unit}' AND substr(kode_usulan_belanja,1,6) = '{$key_sub_subunit}' and sumber_dana = '{$sumber_dana}' ORDER by substr(kode_usulan_belanja,19,4)";

                $query_get_akun4d = $rba->query($query_get_akun4d);
                $result_get_akun4d = $query_get_akun4d->result();
                /************************ ! END QUERY ************************/

                foreach ($result_get_akun4d as $data_akun4d) {
                    $kode_akun4d = $data_akun4d->kode_akun4d;
                    $kode_usulan18 = $key_sub_subunit.$kode.$kode_sumber_dana;
                    $kode_usulan22 = $kode_usulan18.$kode_akun4d;

                    /************************ QUERY ************************/
                    $query_nama_akun4d = "SELECT DISTINCT nama_akun4digit FROM akun_belanja WHERE kode_akun4digit = '{$kode_akun4d}' AND sumber_dana = '{$sumber_dana}' ORDER BY kode_akun4digit";
                    $query_nama_akun4d = $rba->query($query_nama_akun4d);
                    $result_nama_akun4d = $query_nama_akun4d->row();
                    /************************ ! END QUERY ************************/

                    /************************ QUERY ************************/
                    $query_anggaran_rba  = "SELECT SUM(volume*harga_satuan) AS anggaran FROM detail_belanja_ WHERE SUBSTR(kode_usulan_belanja,1,22) = '{$kode_usulan22}' AND sumber_dana = '{$sumber_dana}' AND tahun = '{$tahun}'";

                    $query_anggaran_rba = $rba->query($query_anggaran_rba);
                    $result_anggaran_rba = $query_anggaran_rba->row();
                    /************************ ! END QUERY ************************/

                    $data[$key_subunit]['data'][$key_sub_subunit]['data'][$kode_akun4d] = array(
                        'nama_akun4digit' => $result_nama_akun4d->nama_akun4digit,
                        'anggaran' => $result_anggaran_rba->anggaran,
                        'kode_usulan_belanja_22' => $kode_usulan22,
                        'sisa_anggaran' => '',
                        'usulan_anggaran'   => '',
                        'notif_4d'     => '',
                        'data'  => array()
                    );
                }

                foreach ($data[$key_subunit]['data'][$key_sub_subunit]['data'] as $key_akun4d=>$val_akun4d) {
                    $jumlah_harga_per_akun4d = 0;
                    $sum_notif_5d = 0;
                    $sisa_anggaran = 0;

                    /************************ QUERY ************************/
                    $query_akun5d = "SELECT DISTINCT kode_akun5digit,nama_akun5digit FROM akun_belanja WHERE kode_akun4digit = '{$key_akun4d}' AND sumber_dana = '{$sumber_dana}' ORDER BY kode_akun5digit";
                    $query_akun5d = $rba->query($query_akun5d);
                    $result_akun5d = $query_akun5d->result();
                    /************************ ! END QUERY ************************/

                    $akun5d = array();

                    foreach ($result_akun5d as $res_akun5d) {
                        $akun5d[$res_akun5d->kode_akun5digit] = array(
                            'nama_akun5digit' => $res_akun5d->nama_akun5digit,
                            'kode_usulan_belanja_23' => $kode_usulan18.$res_akun5d->kode_akun5digit,
                            'usulan_anggaran'   => '',
                            'notif_5d'     => '',
                            'data' => array() 
                        );
                    }

                    $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['data'] = $akun5d;

                    foreach ($akun5d as $key_akun5d => $val_akun5d) {
                        $jumlah_harga_per_akun5d = 0;
                        $sum_notif_6d = 0;

                        /************************ QUERY ************************/
                        $query_akun6d = "SELECT DISTINCT kode_akun,nama_akun FROM akun_belanja WHERE kode_akun5digit = '{$key_akun5d}' AND sumber_dana = '{$sumber_dana}' ORDER BY kode_akun";
                        $query_akun6d = $rba->query($query_akun6d);
                        $result_akun6d = $query_akun6d->result();
                        /************************ ! END QUERY ************************/

                        $akun6d = array();

                        foreach ($result_akun6d as $res_akun6d) {
                            $akun6d[$res_akun6d->kode_akun] = array(
                                'nama_akun' => $res_akun6d->nama_akun,
                                'kode_usulan_belanja' => $kode_usulan18.$res_akun6d->kode_akun,
                                'usulan_anggaran'   => '',
                                'notif_6d'     => '',
                                'next_kode_akun_tambah'     => '',
                                'data'  => array()
                            );
                        }

                        $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['data'][$key_akun5d]['data'] = $akun6d;

                        foreach ($akun6d as $key_akun6d => $val_akun6d) {
                            $jumlah_harga_per_akun6d = 0;
                            $kode_usulan24 = $kode_usulan18.$key_akun6d;

                            $next_tambah = $this->get_next_kode_akun_tambah($val_akun6d['kode_usulan_belanja'],$sumber_dana,$tahun);
                            $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['data'][$key_akun5d]['data'][$key_akun6d]['next_kode_akun_tambah'] = $next_tambah;
                            // vdebug($data);

                            /************************ QUERY ************************/
                            $where_proses = '';
                            $where_jenis = '';

                            if (is_array($proses)) {
                                $where_proses = ' AND ( ';
                                foreach ($proses as $item_proses) {
                                    $where_proses .= " SUBSTR(rsa_detail_belanja_.proses,1,1) = '".$item_proses["proses"]."' OR";
                                }
                                $where_proses = rtrim($where_proses,'OR');
                                $where_proses .= ')';
                                // vdebug($where_proses);
                            }else{
                                if ($proses != '') {
                                    $where_proses = 'AND SUBSTR(rsa_detail_belanja_.proses,1,1) = '.$proses;
                                }
                            }

                            if ($jenis != '') {
                                $where_jenis = 'AND SUBSTR(rsa_detail_belanja_.proses,2,1) = '.$jenis;
                            }
                            
                            $query_detail_belanja_rsa = "
                            SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_akun_tambah,rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.volume,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan,rsa_detail_belanja_.proses,rsa_detail_belanja_.impor,rsa_detail_belanja_.revisi,
                            rsa_detail_belanja_tolak.ket
                            FROM rsa_detail_belanja_
                            LEFT JOIN rsa_detail_belanja_tolak
                                ON rsa_detail_belanja_.id_rsa_detail = rsa_detail_belanja_tolak.id_rsa_detail 
                            WHERE rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor)
                                                                FROM rsa_detail_belanja_
                                                                WHERE rsa_detail_belanja_.kode_usulan_belanja = '{$kode_usulan24}')
                            AND rsa_detail_belanja_.kode_usulan_belanja = '{$kode_usulan24}'
                            ".$where_proses." ".$where_jenis."
                            ORDER BY rsa_detail_belanja_.kode_akun_tambah ASC";

                            // vdebug($query_detail_belanja_rsa);
                            $query_detail_belanja_rsa = $this->db->query($query_detail_belanja_rsa);
                            $result_detail_belanja_rsa = $query_detail_belanja_rsa->result();
                            /************************ ! END QUERY ************************/

                            $detail_akun6d = array();

                            foreach ($result_detail_belanja_rsa as $res_detail_belanja_rsa) {
                                $jumlah_harga = $res_detail_belanja_rsa->volume * $res_detail_belanja_rsa->harga_satuan;

                                $detail_akun6d[$res_detail_belanja_rsa->kode_akun_tambah] = array(
                                    'id_rsa_detail' => $res_detail_belanja_rsa->id_rsa_detail,
                                    'rincian'   => $res_detail_belanja_rsa->deskripsi,
                                    'volume'    => $res_detail_belanja_rsa->volume,
                                    'satuan'    => $res_detail_belanja_rsa->satuan,
                                    'harga_satuan'  => $res_detail_belanja_rsa->harga_satuan,
                                    'jumlah_harga'  => $jumlah_harga,
                                    'proses'    => $res_detail_belanja_rsa->proses,
                                    'ket'    => $res_detail_belanja_rsa->ket,
                                    'impor' => $res_detail_belanja_rsa->impor,
                                    'revisi'    => $res_detail_belanja_rsa->revisi
                                );

                                $jumlah_harga_per_akun4d = $jumlah_harga_per_akun4d + $jumlah_harga;
                                $jumlah_harga_per_akun5d = $jumlah_harga_per_akun5d + $jumlah_harga;
                                $jumlah_harga_per_akun6d = $jumlah_harga_per_akun6d + $jumlah_harga;
                            }

                            $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['data'][$key_akun5d]['data'][$key_akun6d]['data'] = $detail_akun6d;
                            $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['data'][$key_akun5d]['data'][$key_akun6d]['usulan_anggaran']  = $jumlah_harga_per_akun6d;

                            $count_for_notif_akun6d = count($data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['data'][$key_akun5d]['data'][$key_akun6d]['data']);
                            $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['data'][$key_akun5d]['data'][$key_akun6d]['notif_6d'] = $count_for_notif_akun6d;
                            $sum_notif_6d = $sum_notif_6d + $count_for_notif_akun6d;

                        }
                        $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['data'][$key_akun5d]['usulan_anggaran']  = $jumlah_harga_per_akun5d;

                        $count_for_notif_akun5d = $sum_notif_6d;
                        $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['data'][$key_akun5d]['notif_5d'] = $count_for_notif_akun5d;
                        $sum_notif_5d = $sum_notif_5d + $count_for_notif_akun5d;
                    }
                    $sisa_anggaran  = $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['anggaran'] - $jumlah_harga_per_akun4d;

                    $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['sisa_anggaran']    = $sisa_anggaran;
                    $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['usulan_anggaran']  = $jumlah_harga_per_akun4d;

                    $count_for_notif_akun4d = $sum_notif_5d;
                    $data[$key_subunit]['data'][$key_sub_subunit]['data'][$key_akun4d]['notif_4d'] = $count_for_notif_akun4d;
                    $sum_notif_4d = $sum_notif_4d + $count_for_notif_akun4d;
                }
                $count_for_notif_sub_subunit = $sum_notif_4d;
                $data[$key_subunit]['data'][$key_sub_subunit]['notif_sub_subunit'] = $count_for_notif_sub_subunit;
                $sum_notif_sub_subunit = $sum_notif_sub_subunit + $count_for_notif_sub_subunit;
            }
            $count_for_notif_subunit = $sum_notif_sub_subunit;
            $data[$key_subunit]['notif_subunit'] = $count_for_notif_subunit;
        }
        // vdebug($data);
        return $data;
    }

    function refresh_usulan_tor_row($kode_usulan_belanja,$sumber_dana,$tahun,$proses=''){

        $rba = $this->load->database('rba', TRUE);

        $kode_sumber_dana = substr($kode_usulan_belanja,16,2);
        $kode_subunit     = substr($kode_usulan_belanja,0,4);
        $kode_sub_subunit = substr($kode_usulan_belanja,0,6);

        /************************ QUERY ************************/
        $query_nama_subunit = "SELECT nama_subunit
        FROM subunit
        WHERE kode_subunit = '{$kode_subunit}'
        ";
        $query_nama_subunit = $rba->query($query_nama_subunit);
        $result_nama_subunit = $query_nama_subunit->row();
        /************************ ! END QUERY ************************/

        $data[$kode_subunit] = array(
            'nama_subunit'  => $result_nama_subunit->nama_subunit,
            'notif_subunit' => '',
            'data'  => array()
        );  

        /************************ QUERY ************************/
        $query_nama_sub_subunit = "SELECT nama_sub_subunit
        FROM sub_subunit
        WHERE kode_sub_subunit = '{$kode_sub_subunit}'";

        $query_nama_sub_subunit = $rba->query($query_nama_sub_subunit);
        $result_nama_sub_subunit = $query_nama_sub_subunit->row();
        /************************ ! END QUERY ************************/

        $data[$kode_subunit]['data'][$kode_sub_subunit] = array(
            'nama_sub_subunit'  => $result_nama_sub_subunit->nama_sub_subunit,
            'notif_sub_subunit' => '',
            'data'  => array()
        );

        $kode_akun4d = substr($kode_usulan_belanja,18,4);
        $kode_akun5d = substr($kode_usulan_belanja,18,5);
        $kode_akun6d = substr($kode_usulan_belanja,18,6);
        $kode_usulan18 = substr($kode_usulan_belanja,0,18);
        $kode_usulan22 = substr($kode_usulan_belanja,0,22);
        $kode_usulan23 = substr($kode_usulan_belanja,0,23);

        /************************ QUERY ************************/
        $query_nama_akun4d = "SELECT DISTINCT nama_akun4digit FROM akun_belanja WHERE kode_akun4digit = '{$kode_akun4d}' AND sumber_dana = '{$sumber_dana}' ORDER BY kode_akun4digit";
        $query_nama_akun4d = $rba->query($query_nama_akun4d);
        $result_nama_akun4d = $query_nama_akun4d->row();
        /************************ ! END QUERY ************************/

        /************************ QUERY ************************/
        $query_anggaran_rba  = "SELECT SUM(volume*harga_satuan) AS anggaran FROM detail_belanja_ WHERE SUBSTR(kode_usulan_belanja,1,22) = '{$kode_usulan22}' AND sumber_dana = '{$sumber_dana}' AND tahun = '{$tahun}'";

        $query_anggaran_rba = $rba->query($query_anggaran_rba);
        $result_anggaran_rba = $query_anggaran_rba->row();
        /************************ ! END QUERY ************************/


        $data[$kode_subunit]['data'][$kode_sub_subunit]['data'][$kode_akun4d] = array(
            'nama_akun4digit' => $result_nama_akun4d->nama_akun4digit,
            'anggaran' => $result_anggaran_rba->anggaran,
            'sisa_anggaran' => '',
            'usulan_anggaran'   => '',
            'kode_usulan_belanja_22' => $kode_usulan22,
            'notif_4d'     => '',
            'data'  => array()
        );

        /************************ QUERY ************************/
        $query_akun5d = "SELECT DISTINCT kode_akun5digit,nama_akun5digit FROM akun_belanja WHERE kode_akun5digit = '{$kode_akun5d}' AND sumber_dana = '{$sumber_dana}' ORDER BY kode_akun5digit";
        $query_akun5d = $rba->query($query_akun5d);
        $result_akun5d = $query_akun5d->row();
        /************************ ! END QUERY ************************/


        $data[$kode_subunit]['data'][$kode_sub_subunit]['data'][$kode_akun4d]['data'][$kode_akun5d] = array(
            'nama_akun5digit' => $result_akun5d->nama_akun5digit,
            'usulan_anggaran'   => '',
            'kode_usulan_belanja_23' => $kode_usulan23,
            'notif_5d'     => '',
            'data' => array() 
        );

        /************************ QUERY ************************/
        $query_akun6d = "SELECT DISTINCT kode_akun,nama_akun FROM akun_belanja WHERE kode_akun = '{$kode_akun6d}' AND sumber_dana = '{$sumber_dana}' ORDER BY kode_akun";
        $query_akun6d = $rba->query($query_akun6d);
        $result_akun6d = $query_akun6d->row();
        /************************ ! END QUERY ************************/

        $data[$kode_subunit]['data'][$kode_sub_subunit]['data'][$kode_akun4d]['data'][$kode_akun5d]['data'][$kode_akun6d] = array(
            'nama_akun' => $result_akun6d->nama_akun,
            'kode_usulan_belanja' => $kode_usulan_belanja,
            'usulan_anggaran'   => '',
            'notif_6d'     => '',
            'data'  => array()
        );

        /************************ QUERY ************************/
        $where = '';
        if ($proses != '') {
            $where = 'AND SUBSTR(rsa_detail_belanja_.proses,1,1) = '.$proses;
        }

        $query_detail_belanja_rsa = "
        SELECT rsa_detail_belanja_.id_rsa_detail,rsa_detail_belanja_.kode_akun_tambah,rsa_detail_belanja_.deskripsi,rsa_detail_belanja_.volume,rsa_detail_belanja_.satuan,rsa_detail_belanja_.harga_satuan,rsa_detail_belanja_.proses,rsa_detail_belanja_.impor,rsa_detail_belanja_.revisi,
        rsa_detail_belanja_tolak.ket
        FROM rsa_detail_belanja_
        LEFT JOIN rsa_detail_belanja_tolak
            ON rsa_detail_belanja_.id_rsa_detail = rsa_detail_belanja_tolak.id_rsa_detail 
        WHERE rsa_detail_belanja_.impor = (SELECT MAX(rsa_detail_belanja_.impor)
                                            FROM rsa_detail_belanja_
                                            WHERE rsa_detail_belanja_.kode_usulan_belanja = '{$kode_usulan_belanja}')
        AND rsa_detail_belanja_.kode_usulan_belanja = '{$kode_usulan_belanja}'
        ".$where."
        ORDER BY rsa_detail_belanja_.kode_akun_tambah ASC
        ";

        $query_detail_belanja_rsa = $this->db->query($query_detail_belanja_rsa);
        $result_detail_belanja_rsa = $query_detail_belanja_rsa->result();
        /************************ ! END QUERY ************************/

        foreach ($result_detail_belanja_rsa as $res_detail_belanja_rsa) {
            $jumlah_harga = $res_detail_belanja_rsa->volume * $res_detail_belanja_rsa->harga_satuan;

            $data[$kode_subunit]['data'][$kode_sub_subunit]['data'][$kode_akun4d]['data'][$kode_akun5d]['data'][$kode_akun6d]['data'][$res_detail_belanja_rsa->kode_akun_tambah] = array(
                'id_rsa_detail' => $res_detail_belanja_rsa->id_rsa_detail,
                'rincian'       => $res_detail_belanja_rsa->deskripsi,
                'volume'        => $res_detail_belanja_rsa->volume,
                'satuan'        => $res_detail_belanja_rsa->satuan,
                'harga_satuan'  => $res_detail_belanja_rsa->harga_satuan,
                'jumlah_harga'  => $jumlah_harga,
                'proses'        => $res_detail_belanja_rsa->proses,
                'ket'           => $res_detail_belanja_rsa->ket,
                'impor'         => $res_detail_belanja_rsa->impor,
                'revisi'        => $res_detail_belanja_rsa->revisi
            );
        }            
            // vdebug($data);
        return $data;
    }

    function get_detail_akun_rba_to_validate_sub_kegiatan($kode,$sumber_dana,$tahun){
        $unit = substr($kode,0,2);
        $rba = $this->load->database('rba', TRUE);

        $query  = "SELECT SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,10) AS kode_usulan_belanja, "
        . "rba_2018.kegiatan.kode_kegiatan,rba_2018.kegiatan.nama_kegiatan,rba_2018.output.kode_output,rba_2018.output.nama_output,rba_2018.program.kode_program,rba_2018.program.nama_program,rba_2018.komponen_input.kode_komponen,rba_2018.komponen_input.nama_komponen,rba_2018.subkomponen_input.kode_subkomponen,rba_2018.subkomponen_input.nama_subkomponen "
        . "FROM rba_2018.detail_belanja_ "
        . "JOIN rba_2018.kegiatan ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,2) = rba_2018.kegiatan.kode_kegiatan "
        . "JOIN rba_2018.output ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,2) = output.kode_kegiatan AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,9,2) = output.kode_output "
        . "JOIN rba_2018.program ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,2) = program.kode_kegiatan AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,9,2) = program.kode_output AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,11,2) = program.kode_program "
        . "JOIN rba_2018.komponen_input ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,2) = komponen_input.kode_kegiatan AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,9,2) = komponen_input.kode_output AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,11,2) = komponen_input.kode_program AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,13,2) = komponen_input.kode_komponen "
        . "JOIN rba_2018.subkomponen_input ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,2) = subkomponen_input.kode_kegiatan AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,9,2) = subkomponen_input.kode_output AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,11,2) = subkomponen_input.kode_program AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,13,2) = subkomponen_input.kode_komponen AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,15,2) = subkomponen_input.kode_subkomponen "
        . "WHERE LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,2) = '{$unit}' "
        . "AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' "
        . "AND rba_2018.detail_belanja_.revisi = (SELECT MAX(rba_2018.detail_belanja_.revisi) FROM rba_2018.detail_belanja_ WHERE LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,2) = '{$unit}') "
        . "GROUP BY SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,10) "
        . "ORDER BY SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,10) ASC " ;

        $query      = $rba->query($query) ;
        if ($query->num_rows()>0){
            return $query->result();
        }else{
            return array();
        }

    }

    function get_detail_akun_rba_to_validate($kode,$sumber_dana,$tahun){
        $unit = substr($kode,0,2);
//            $rka = substr($kode,2,10);

        $rba = $this->load->database('rba', TRUE);

        $query  = "SELECT rba_2018.detail_belanja_.kode_usulan_belanja,rba_2018.akun_belanja.kode_akun,rba_2018.akun_belanja.nama_akun,rba_2018.subunit.nama_subunit,rba_2018.sub_subunit.nama_sub_subunit,SUM(rba_2018.detail_belanja_.volume*rba_2018.detail_belanja_.harga_satuan) AS total_harga,rba_2018.detail_belanja_.revisi, "
        . "rba_2018.kegiatan.kode_kegiatan,rba_2018.kegiatan.nama_kegiatan,rba_2018.output.kode_output,rba_2018.output.nama_output,rba_2018.program.kode_program,rba_2018.program.nama_program,rba_2018.komponen_input.kode_komponen,rba_2018.komponen_input.nama_komponen,rba_2018.subkomponen_input.kode_subkomponen,rba_2018.subkomponen_input.nama_subkomponen "
        . "FROM rba_2018.detail_belanja_ "
        . "JOIN rba_2018.akun_belanja ON RIGHT(rba_2018.detail_belanja_.kode_usulan_belanja,6) = rba_2018.akun_belanja.kode_akun AND rba_2018.detail_belanja_.sumber_dana = rba_2018.akun_belanja.sumber_dana "
        . "JOIN rba_2018.subunit ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,1,4) = rba_2018.subunit.kode_subunit "
        . "JOIN rba_2018.sub_subunit ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,1,6) = rba_2018.sub_subunit.kode_sub_subunit "
        . "JOIN rba_2018.kegiatan ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,2) = rba_2018.kegiatan.kode_kegiatan "
        . "JOIN rba_2018.output ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,2) = output.kode_kegiatan AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,9,2) = output.kode_output "
        . "JOIN rba_2018.program ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,2) = program.kode_kegiatan AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,9,2) = program.kode_output AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,11,2) = program.kode_program "
        . "JOIN rba_2018.komponen_input ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,2) = komponen_input.kode_kegiatan AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,9,2) = komponen_input.kode_output AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,11,2) = komponen_input.kode_program AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,13,2) = komponen_input.kode_komponen "
        . "JOIN rba_2018.subkomponen_input ON SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,7,2) = subkomponen_input.kode_kegiatan AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,9,2) = subkomponen_input.kode_output AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,11,2) = subkomponen_input.kode_program AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,13,2) = subkomponen_input.kode_komponen AND SUBSTR(rba_2018.detail_belanja_.kode_usulan_belanja,15,2) = subkomponen_input.kode_subkomponen "
        . "WHERE LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,2) = '{$unit}' "
        . "AND rba_2018.detail_belanja_.sumber_dana = '{$sumber_dana}' AND rba_2018.detail_belanja_.tahun = '{$tahun}' "
        . "AND rba_2018.detail_belanja_.revisi = (SELECT MAX(rba_2018.detail_belanja_.revisi) FROM rba_2018.detail_belanja_ WHERE LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,2) = '{$unit}') "
        . "GROUP BY LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,16),RIGHT(rba_2018.detail_belanja_.kode_usulan_belanja,6) "
        . "ORDER BY LEFT(rba_2018.detail_belanja_.kode_usulan_belanja,16) ASC, "
        . "RIGHT(rba_2018.detail_belanja_.kode_usulan_belanja,6) ASC " ;

        $query      = $rba->query($query) ;
        if ($query->num_rows()>0){
            return $query->result();
        }else{
            return array();
        }

    }

    function do_delete_rsa_detail_belanja($id_rsa_detail){
        return $this->db->delete('rsa_detail_belanja_', array('id_rsa_detail' => $id_rsa_detail));
    }

    function add_rsa_detail_belanja($data){
        return $this->db->insert('rsa_detail_belanja_',$data);
    }

    function edit_rsa_detail_belanja($data,$id_rsa_detail){
        return $this->db->update('rsa_detail_belanja_', $data, array('id_rsa_detail'=>$id_rsa_detail));
    }

    function get_next_kode_akun_tambah($kode_usul_belanja,$sumber_dana,$tahun)
    {

        $query = "SELECT IFNULL(MAX(kode_akun_tambah),0) AS next_kode_akun_tambah FROM rsa_detail_belanja_ WHERE kode_usulan_belanja = '{$kode_usul_belanja}' AND sumber_dana = '{$sumber_dana}' AND tahun = '{$tahun}'" ; 

        $q = $this->db->query($query);
        $row = $q->row();

        $x = intval($row->next_kode_akun_tambah) + 1;
        if(strlen($x)==1){
            $x = '00'.$x;
        }
        elseif(strlen($x)==2){
            $x = '0'.$x;
        }
        elseif(strlen($x)==3){
            $x = $x;
        }elseif(strlen($x)==4){
            echo 'ERROR ADD DPA , MELEBIHI KUOTA 999'; die;
        }
        return $x;
    }

    function get_single_detail($id='')
    {
        /* running query    */
        $query = $this->db->get_where('rsa_detail_belanja_', array('id_rsa_detail' => $id));
        if ($query->num_rows()>0){
            return $query->row();
        }else{
            return '';
        }
    }

    function post_proses_tor($kode,$sumber_dana,$tahun){

        $unit = substr($kode,0,2);
        $rka = substr($kode,2,10);
        $query = "UPDATE rsa_detail_belanja_ SET rsa_detail_belanja_.proses = '1' WHERE SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,1,2) = '{$unit}' "
        . "AND SUBSTR(rsa_detail_belanja_.kode_usulan_belanja,7,10) = '{$rka}' "
        . "AND rsa_detail_belanja_.sumber_dana = '{$sumber_dana}' "
        . "AND rsa_detail_belanja_.tahun = '{$tahun}'" ;

        return $this->db->query($query);

    }

    function post_proses_tor_rsa_detail($id_rsa_detail,$proses){
        $query = "UPDATE rsa_detail_belanja_ SET rsa_detail_belanja_.proses = '{$proses}' WHERE rsa_detail_belanja_.id_rsa_detail = '{$id_rsa_detail}' " ;
        return $this->db->query($query);

    }

    function post_proses_tor_to_validate($id_rsa_detail,$proses){
        $query = "UPDATE rsa_detail_belanja_ SET rsa_detail_belanja_.proses = '{$proses}' WHERE rsa_detail_belanja_.id_rsa_detail = '{$id_rsa_detail}' " ;
        return $this->db->query($query);
    }

    function post_proses_rsa_to_validate($id_rsa_detail){
        $query = "UPDATE rsa_detail_belanja_ SET rsa_detail_belanja_.proses = '2' WHERE rsa_detail_belanja_.id_rsa_detail = '{$id_rsa_detail}' " ;
        return $this->db->query($query);
    }

    function add_rsa_tolak_dpa($data){
        $data['tanggal_tolak'] = date('Y-m-d H:i:s');
        $this->db->delete('rsa_detail_belanja_tolak', array('id_rsa_detail' => $data['id_rsa_detail']));
        return $this->db->insert('rsa_detail_belanja_tolak',$data);
    }



    function get_tor($where=""){
        if(!$where==""){
            $this->db2->where('kode_usulan_belanja',$where);
        }
        $this->db2->order_by("kode_usulan_belanja");

        $query = $this->db2->get("detail_belanja_");
        if($query->num_rows()>0){
            return $query->result();
        }else{
            return array();
        }
    }
    function search_tor($sumber_dana='',$kata_kunci=''){
        /*  Filter xss n sepecial char */
        $kata_kunci  = form_prep($kata_kunci);
        $sumber_dana = form_prep($sumber_dana);
        if($sumber_dana == ''){
            if($kata_kunci!='')
            {
                $where = "kode_usulan_belanja LIKE '%{$kata_kunci}%' OR deskripsi LIKE '%{$kata_kunci}%'";
                $this->db2->where($where);
            }

        }else{
            $where = "sumber_dana = '{$sumber_dana}'";
            if($kata_kunci!='')
            {
                $where .= " AND (kode_usulan_belanja LIKE '%{$kata_kunci}%' OR nama_akun LIKE '%{$kata_kunci}%')";
            }
            $this->db2->where($where);
        }
        $this->db2->order_by("kode_usulan_belanja", "asc");
        /* running query    */
        $query      = $this->db2->get('detail_belanja_');
        if ($query->num_rows()>0){
            return $query->result();
        }else{
            return array();
        }
    }

    function get_tor_kegiatan_usul($unit,$sumber_dana,$tahun){
      $rba = $this->load->database('rba', TRUE);

      $query = "SELECT LEFT(detail_belanja_.kode_usulan_belanja,2) AS k_unit,kegiatan.nama_kegiatan,kegiatan.kode_kegiatan,output.nama_output,output.kode_output,program.nama_program,program.kode_program,SUM(detail_belanja_.volume*detail_belanja_.harga_satuan) AS jumlah_tot "
      . "FROM detail_belanja_ "
      . "JOIN kegiatan ON SUBSTR(detail_belanja_.kode_usulan_belanja,7,2) = kegiatan.kode_kegiatan "
      . "JOIN output ON SUBSTR(detail_belanja_.kode_usulan_belanja,7,2) = output.kode_kegiatan AND SUBSTR(detail_belanja_.kode_usulan_belanja,9,2) = output.kode_output "
      . "JOIN program ON SUBSTR(detail_belanja_.kode_usulan_belanja,7,2) = program.kode_kegiatan AND SUBSTR(detail_belanja_.kode_usulan_belanja,9,2) = program.kode_output AND SUBSTR(detail_belanja_.kode_usulan_belanja,11,2) = program.kode_program "
      . "WHERE LEFT(detail_belanja_.kode_usulan_belanja,2) = '{$unit}' AND detail_belanja_.sumber_dana = '{$sumber_dana}' AND detail_belanja_.tahun = '{$tahun}' "
      . "GROUP BY SUBSTR(detail_belanja_.kode_usulan_belanja,7,6) "
      . "ORDER BY SUBSTR(detail_belanja_.kode_usulan_belanja,7,6) ASC";

      $query = $rba->query($query);
      $result = $query->result();
      return $result ;

  }

  function get_alias_unit($kode_unit){
    $rba = $this->load->database('rba', TRUE);
    if(strlen($kode_unit)=='4'){
        $kode_unit_ = substr($kode_unit,0,2);
        $kode_subunit = substr($kode_unit,2,2);
        if($kode_unit_ == '41'){
            switch ($kode_subunit){
                case '11'       : return 'W11'; break;
                case '13'       : return 'W12'; break;
                case '12'       : return 'W13'; break;
                case '14'       : return 'W14'; break;
            }
        }elseif($kode_unit_ == '42'){
            switch ($kode_subunit){
                case '11'       : return 'W21'; break;
                case '13'       : return 'W22'; break;
                case '12'       : return 'W23'; break;
                case '14'       : return 'W24'; break;
            }
        }elseif($kode_unit_ == '43'){
            switch ($kode_subunit){
                case '11'       : return 'W31'; break;
                case '13'       : return 'W32'; break;
                case '12'       : return 'W33'; break;
                case '14'       : return 'W34'; break;
            }
        }elseif($kode_unit_ == '44'){
            switch ($kode_subunit){
                case '11'       : return 'W41'; break;
                case '13'       : return 'W42'; break;
                case '12'       : return 'W43'; break;
                case '14'       : return 'W44'; break;
            }
        }else{
            $rba->where('unit.kode_unit',substr($kode_unit,0,2));
            $q = $rba->get('rba_2018.unit')->row();

            return $q->alias ;
        }
    }elseif(strlen($kode_unit)=='6'){
        $kode_unit_ = substr($kode_unit,0,2);
        $kode_subunit = substr($kode_unit,2,2);
        if($kode_unit_ == '41'){
            switch ($kode_subunit){
                case '11'       : return 'W11'; break;
                case '13'       : return 'W12'; break;
                case '12'       : return 'W13'; break;
                case '14'       : return 'W14'; break;
            }
        }elseif($kode_unit_ == '42'){
            switch ($kode_subunit){
                case '11'       : return 'W21'; break;
                case '13'       : return 'W22'; break;
                case '12'       : return 'W23'; break;
                case '14'       : return 'W24'; break;
            }
        }elseif($kode_unit_ == '43'){
            switch ($kode_subunit){
                case '11'       : return 'W31'; break;
                case '13'       : return 'W32'; break;
                case '12'       : return 'W33'; break;
                case '14'       : return 'W34'; break;
            }
        }elseif($kode_unit_ == '44'){
            switch ($kode_subunit){
                case '11'       : return 'W41'; break;
                case '13'       : return 'W42'; break;
                case '12'       : return 'W43'; break;
                case '14'       : return 'W44'; break;
            }
        }else{
            $rba->where('unit.kode_unit',substr($kode_unit,0,2));
            $q = $rba->get('rba_2018.unit')->row();

            return $q->alias ;
        }
    }else{
        $rba->where('unit.kode_unit',$kode_unit);
        $q = $rba->get('rba_2018.unit')->row();

        return $q->alias ;
    }

}

function get_pic_kuitansi($kode_unit){

    if((substr($kode_unit,0,2) == '14')||(substr($kode_unit,0,2) == '15')||(substr($kode_unit,0,2) == '16')||(substr($kode_unit,0,2) == '17')){
        $kode_unit = $kode_unit;

    }else{
        $kode_unit = substr($kode_unit,0,2);
    }
    $data = array();
    $this->db->where('rsa_user.kode_unit_subunit',$kode_unit);
    $this->db->where('rsa_user.level','15');
    $q = $this->db->get('rsa_user')->row();
    $pppk_nm_lengkap = isset($q->nm_lengkap)?$q->nm_lengkap:'- belum ada -';
    $pppk_nip = isset($q->nip)?$q->nip:'- belum ada -';

    if((substr($kode_unit,0,2) == '14')||(substr($kode_unit,0,2) == '15')||(substr($kode_unit,0,2) == '16')||(substr($kode_unit,0,2) == '17')){
        $kode_unit = substr($kode_unit,0,4) ;
    }

    $this->db->where('rsa_user.kode_unit_subunit',$kode_unit);
    $this->db->where('rsa_user.level','13');
    $q = $this->db->get('rsa_user')->row();
    $bendahara_nm_lengkap = isset($q->nm_lengkap)?$q->nm_lengkap:'- belum ada -';
    $bendahara_nip = isset($q->nomor_induk)?$q->nomor_induk:'- belum ada -';

//            $this->db->where('rsa_user.kode_unit_subunit',$kode_unit);
//            $this->db->where('rsa_user.level','4');
//            $q = $this->db->get('rsa_user')->row();
//            $pumk_nm_lengkap = isset($q->nm_lengkap)?$q->nm_lengkap:'- belum ada -';
//            $pumk_nip = isset($q->nip)?$q->nip:'- belum ada -';

    return array('pppk_nm_lengkap' => $pppk_nm_lengkap , 'pppk_nip' => $pppk_nip , 'bendahara_nm_lengkap' => $bendahara_nm_lengkap , 'bendahara_nip' => $bendahara_nip );
}



function get_pppk($kode_unit_subunit){
    $lenunit = strlen($kode_unit_subunit);

    $query  = "SELECT id,nm_lengkap,nomor_induk "
    . "FROM rsa_user "
    . "WHERE LEFT(kode_unit_subunit,{$lenunit}) = '{$kode_unit_subunit}' "
    . "AND level = '15' "
    . "ORDER BY rsa_user.id ASC " ;

    $query = $this->db->query($query) ;

    if ($query->num_rows()>0){
        return $query->result();
    }else{
        return array();
    }

}
function get_ppk($kode_unit_subunit){
    $lenunit = strlen($kode_unit_subunit);

    $query  = "SELECT id,nm_lengkap,nomor_induk "
    . "FROM rsa_user "
    . "WHERE LEFT(kode_unit_subunit,{$lenunit}) = '{$kode_unit_subunit}' "
    . "AND level = '16' "
    . "ORDER BY rsa_user.id ASC " ;

    $query = $this->db->query($query) ;

    if ($query->num_rows()>0){
        return $query->result();
    }else{
        return array();
    }

}
function get_allppk(){
           // $lenunit = strlen($kode_unit_subunit);

    $query  = "SELECT id,nm_lengkap,nomor_induk "
    . "FROM rsa_user "
    . "WHERE level = '16' "
    . "ORDER BY rsa_user.id ASC " ;

    $query = $this->db->query($query) ;

    if ($query->num_rows()>0){
        return $query->result();
    }else{
        return array();
    }

}
function get_allpppk(){
           // $lenunit = strlen($kode_unit_subunit);

    $query  = "SELECT id,nm_lengkap,nomor_induk "
    . "FROM rsa_user "
    . "WHERE level = '15' "
    . "ORDER BY rsa_user.id ASC " ;

    $query = $this->db->query($query) ;

    if ($query->num_rows()>0){
        return $query->result();
    }else{
        return array();
    }

}

function get_kontrak($kode){
    $unit = substr($kode,0,2);
    $rka = substr($kode,2,10);

    $query  = "SELECT * FROM rsa_spm_kontrakpihak3 WHERE kode_usulan_belanja='{$kode}' AND LEFT(kode_usulan_belanja,2) = '{$unit}' AND SUBSTR(kode_usulan_belanja,7,10) = '{$rka}' ORDER BY kode_usulan_belanja ASC " ;
            //var_dump($query);die;
    $query      = $this->db->query($query) ;

    if ($query->num_rows()>0){
        return $query->result();
    }else{
        return array();
    }

}

function get_detail_rsa_kontrak($kodex,$tahun,$kode_akun_tambah,$unit){

            //AND SUBSTR(kode_usulan_belanja,17,2) =
    $query  = "SELECT * FROM rsa_spm_kontrakpihak3 WHERE kode_usulan_belanja='{$kodex}' AND kode_akun_tambah='{$kode_akun_tambah}' GROUP BY kode_akun_tambah" ;
                        //  AND DATE_FORMAT(tanggal,'%Y')='{$tahun}'
                        // echo $query; exit;
               // var_dump($query);die;
    $query      = $this->db->query($query) ;
    if ($query->num_rows()>0){
        return $query->result();
    }else{
        return array();
    }
}
function get_detail_rsa_kontrak2($kode,$akun_tambah,$tahun,$nominal,$unit){

            //AND SUBSTR(kode_usulan_belanja,17,2) =
    $query  = "SELECT * FROM rsa_spm_kontrakpihak3 WHERE kode_usulan_belanja='{$kode}' AND kode_akun_tambah='{$akun_tambah}' AND kontrak_terbayar='{$nominal}' AND DATE_FORMAT(tanggal,'%Y')='{$tahun}'  ORDER BY kode_usulan_belanja ASC" ;
                   // var_dump($query);die;
    $query      = $this->db->query($query) ;
    if ($query->num_rows()>0){
        return $query->result();
    }else{
        return array();
    }
}

}
