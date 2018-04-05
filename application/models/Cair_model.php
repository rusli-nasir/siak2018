<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cair_model extends CI_Model {
/* -------------- Constructor ------------- */


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();

        }


        function get_spm_cair($tahun,$kode_unit_subunit='',$jenis='',$bulan="",$sort=''){

            //edited
            //end edit
            $rba = $this->load->database('rba', TRUE);

            $where = '' ;

            $select = '' ;

            $join = '' ;

            // vdebug($bulan);
            $select2 = '' ;

            $join2 = '' ;

            $where_bulan = '';

            if($bulan != ''){
                $where_bulan = "AND a.bulan = '{$bulan}'" ;
            }
             // vdebug($where_bulan);

            if($kode_unit_subunit != '99'){

                $where .= "AND a.kode_unit_subunit LIKE '{$kode_unit_subunit}%' " ;

            }

            if($jenis != '00'){

                $where .= "AND a.jenis_trx = '{$jenis}' " ;

            }

            if($jenis == 'LSK'){

                $select = ",b.alias_spp" ;
                $join = " JOIN trx_spp_lsk_data AS b ON b.str_nomor_trx = a.str_nomor_trx_spp " ;

                $select2 = ",c.alias_spm" ;
                $join2 = " JOIN trx_spm_lsk_data AS c ON c.str_nomor_trx = a.str_nomor_trx_spm " ;

            }

            if($jenis == 'LSNK'){

                $select = ",b.alias_spp" ;
                $join = " JOIN trx_spp_lsnk_data AS b ON b.str_nomor_trx = a.str_nomor_trx_spp " ;

                $select2 = ",c.alias_spm" ;
                $join2 = " JOIN trx_spm_lsnk_data AS c ON c.str_nomor_trx = a.str_nomor_trx_spm " ;

            }

            if ($sort == 'daftar_sp2d') {
                $sort = 'SUBSTR(a.str_nomor_trx_spm, 6,3),a.bulan,SUBSTR(a.str_nomor_trx_spm, 1,4)';
            }else{
                $sort = 'a.no_urut';
            }

            $query = "SELECT a.* {$select}{$select2} FROM trx_urut_spm_cair AS a {$join}{$join2} WHERE a.tahun = '{$tahun}' ".$where." ".$where_bulan." ORDER BY {$sort}  ";


                       // echo $query ; die;

            $q = $this->db->query($query);
            $result = $q->result();

            // $i = 1;
            foreach ($result as $key => $value) {
                $query2 = "SELECT spm_cair.nominal,spm_cair.jenis_trx,
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
                            WHERE spm_cair.str_nomor_trx_spm = '{$value->str_nomor_trx_spm}' ";
                $query2 = $this->db->query($query2);
                $res = $query2->row();
                if ($res->jenis_trx != 'LSP') {
                    $result[$key]->pajak = $res->jumlah_pajak;
                    $result[$key]->netto = $res->netto_cair;
                    $result[$key]->potongan_lainnya = $res->potongan_lainnya;
                }else{
                    $result[$key]->pajak = $res->jumlah_pajakls;
                    $result[$key]->netto = $res->netto_cairls;
                    $result[$key]->potongan_lainnya = $res->potongan_lainnyals;
                }
                // if ($i==177) {
                    
                // vdebug($result);
                // }
                // $i++;
            }
            return $result;

        }

        function get_nominal_sp2d($no_spm,$jenis,$kode_unit_subunit){
            $this->db->select('nominal_sudah_sp2d');
            $this->db->where('str_nomor_trx_spm', $no_spm);
            $this->db->where('jenis_trx', $jenis);
            $this->db->where('kode_unit_subunit', $kode_unit_subunit);
            $q = $this->db->get('trx_urut_spm_cair');

            return $q->row();
        }

        function get_nominal_cair($no_spm){
            $this->db->select('nominal');
            $this->db->where('str_nomor_trx_spm', $no_spm);
            $q = $this->db->get('trx_urut_spm_cair');

            return $q->row()->nominal;
        }

        function update_nominal_sp2d($no_spm,$jenis,$kode_unit_subunit,$data){
            $this->db->where('str_nomor_trx_spm', $no_spm);
            $this->db->where('jenis_trx', $jenis);
            $this->db->where('kode_unit_subunit', $kode_unit_subunit);
            $q = $this->db->update('trx_urut_spm_cair', $data);

            if ($q) {
                return TRUE;
            }else{
                return FALSE;
            }
            
        }

}
