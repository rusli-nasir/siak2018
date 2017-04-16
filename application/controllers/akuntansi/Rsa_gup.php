<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class rsa_gup extends MY_Controller{
    public function __construct(){ 
        parent::__construct();
        $this->cek_session_in();
    }
    
    function index(){
        $this->data['tab'] = 'rsa_gup';
        $this->data['content'] = $this->load->view('akuntansi/rsa_gup_detail',$this->data,true);
        $this->load->view('akuntansi/content_template',$this->data,false);
    }
    
    function jurnal(){
//        $no_spm="00003/FTE/SPM-GUP/FEB/2017";
        $no_spm = urldecode($this->input->get('spm'));
        $this->load->model('akuntansi/rsa_gup2_model');
        $_spm = $this->rsa_gup2_model->get_spm_detail($no_spm, 'tahun', 'kode_unit', 'str_nomor_trx');
        
        $kd_unit = $_spm->kode_unit;
        $tahun = $_spm->tahun;
                                
        $this->load->model('unit_model');
        $this->load->model('rsa_gup_model');
        $this->load->model('kuitansi_model');
        $this->data['cur_tahun'] = $tahun;
        if(strlen($kd_unit)==2){
            $this->data['unit_kerja'] = $this->unit_model->get_nama($kd_unit);
            $this->data['unit_id'] = $kd_unit ;
            $this->data['kd_unit'] = $kd_unit ;
            $this->data['alias'] = $this->unit_model->get_alias($kd_unit);
        }
        elseif(strlen($kd_unit)==4){
                $this->data['unit_kerja'] = $this->unit_model->get_nama($kd_unit) . ' - ' . $this->unit_model->get_real_nama($kd_unit);
                $this->data['unit_id'] = $kd_unit;
                $this->data['kd_unit'] = $kd_unit ;
                $this->data['alias'] = $this->unit_model->get_alias($kd_unit);
        }
                                
                               
        $dokumen_gup = $this->rsa_gup_model->check_dokumen_gup_by_str_trx($no_spm);

        $this->data['doc_up'] = $dokumen_gup;

        $nomor_trx_spp =  $_spm->str_nomor_trx;
//        $nomor_trx_spp = $this->rsa_gup_model->get_nomor_spp($kd_unit,$tahun); 
                                
                                
        $this->data_spp = (object)array(
            'jumlah_bayar' => '0',
            'terbilang' => '',
            'untuk_bayar' => '',
            'penerima' => '',
            'alamat' => '',
            'nmbank' => '',
            'rekening' => '',
            'npwp' => '',
            'nmbendahara' => '',
            'nipbendahara' => '',
            'tgl_spp' => ''
        );
        // SPP

        $array_id = '';
        $pengeluaran = 0;
        $du = '' ;

        if(($dokumen_gup == 'SPP-FINAL') || ($dokumen_gup == 'SPP-DRAFT') || ($dokumen_gup == 'SPM-DRAFT-PPK') || ($dokumen_gup == 'SPM-DRAFT-KPA') || ($dokumen_gup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_gup == 'SPM-FINAL-KBUU')){

            $this->data_spp = $this->rsa_gup_model->get_data_spp($nomor_trx_spp);

            $this->data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
            $kuitansi_d = array();
            if(!empty($this->data_kuitansi)){
                foreach($this->data_kuitansi as $dk){
                    $kuitansi_d[] = $dk->id_kuitansi;
                }
            }
            $du_ = json_encode($kuitansi_d);
            $this->data_url = urlencode(base64_encode($du_));
            $du = $this->data_url ;
            $this->data_url = urldecode($this->data_url);
            if( base64_encode(base64_decode($this->data_url, true)) === $this->data_url){
                //$array_id = base64_decode($this->data_url) ;
                $array_id = $this->data_spp->data_kuitansi;
                $this->data_ = array(
                    'kode_unit_subunit' => $kd_unit,
                    'array_id' => json_decode($array_id),
                    'tahun' => $this->data['cur_tahun'],
                );
                
                $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($this->data_);
            }else{
                $pengeluaran = 0;
            }

            $this->data['detail_gup']   = array(
                                            'nom' => $this->data_spp->jumlah_bayar,
                                            'terbilang' => $this->data_spp->terbilang, 

                                        );

            $this->data['detail_pic']  = (object) array(
                'untuk_bayar' => $this->data_spp->untuk_bayar,
                'penerima' => $this->data_spp->penerima,
                'alamat_penerima' => $this->data_spp->alamat,
                'nama_bank_penerima' => $this->data_spp->nmbank,
                'no_rek_penerima' => $this->data_spp->rekening,
                'npwp_penerima' => $this->data_spp->npwp,
                'nmbendahara' => $this->data_spp->nmbendahara,
                'nipbendahara' => $this->data_spp->nipbendahara,


            );


            $this->data['tgl_spp'] = $this->data_spp->tgl_spp;

            $this->data['cur_tahun_spp'] = $this->data_spp->tahun;
            setlocale(LC_ALL, 'id_ID.utf8');$this->data['bulan'] = strftime("%B", strtotime($this->data_spp->tgl_spp)); 


        }else{

           $this->data['cur_tahun_spp'] = '';

        }


        //$nomor_trx_spm = '';

        if(($dokumen_gup == 'SPM-DRAFT-PPK') || ($dokumen_gup == 'SPM-DRAFT-KPA') || ($dokumen_gup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_gup == 'SPM-FINAL-KBUU')){

            $nomor_trx_spm = $this->rsa_gup_model->get_nomor_spm($kd_unit,$tahun);  

            $this->data_spm = $this->rsa_gup_model->get_data_spm($nomor_trx_spm);
            $this->data['detail_gup_spm']   = array(
                                            'nom' => $this->data_spm->jumlah_bayar,
                                            'terbilang' => $this->data_spm->terbilang, 

                                        );

            $this->data['detail_ppk']  = (object)array(
                'nm_lengkap' => $this->data_spm->nmppk,
                'nomor_induk' => $this->data_spm->nipppk
            );
            $this->data['detail_kpa']  = (object)array(
                'nm_lengkap' => $this->data_spm->nmkpa,
                'nomor_induk' => $this->data_spm->nipkpa
            );
            $this->data['detail_verifikator']  = (object)array(
                'nm_lengkap' => $this->data_spm->nmverifikator,
                'nomor_induk' => $this->data_spm->nipverifikator
            );
            $this->data['detail_kuasa_buu']  = (object)array(
                'nm_lengkap' => $this->data_spm->nmkbuu,
                'nomor_induk' => $this->data_spm->nipkbuu
            );
            $this->data['detail_buu']  = (object)array(
                'nm_lengkap' => $this->data_spm->nmbuu,
                'nomor_induk' => $this->data_spm->nipbuu
            );

            $this->data['detail_pic_spm']  = (object) array(
                'untuk_bayar' => $this->data_spm->untuk_bayar,
                'penerima' => $this->data_spm->penerima,
                'alamat_penerima' => $this->data_spm->alamat,
                'nama_bank_penerima' => $this->data_spm->nmbank,
                'no_rek_penerima' => $this->data_spm->rekening,
                'npwp_penerima' => $this->data_spm->npwp,

    //                                        'tgl_spp' => $this->data_spp->tgl_spp,

            );

            $this->data['tgl_spm'] = $this->data_spm->tgl_spm;

            $this->data['cur_tahun_spm'] = $this->data_spm->tahun;

        }else{

            $this->data['cur_tahun_spm'] = '';
            $this->data['tgl_spm'] = '' ;
        }

        $this->data_akun_pengeluaran = array();
        $this->data_spp_pajak = array();
        $this->data_akun_rkat = array();
        $this->data_akun_pengeluaran_lalu = array();
        $rincian_akun_pengeluaran = array();
        $rincian_keluaran = array();
        $daftar_kuitansi = array();


        if($pengeluaran > 0){
            $this->data__ = array(
                'kode_unit_subunit' => $kd_unit,
                'tahun' => $tahun,
                'array_id' => json_decode($array_id)
            );
            $this->data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($this->data__);


            $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($this->data__);
            $this->data_spp_pajak = $this->kuitansi_model->get_spp_pajak($this->data__);
            $this->data_akun5digit = array();
            foreach($this->data_akun_pengeluaran as $da){
                $this->data_akun5digit[] =  $da->kode_akun5digit ;
            }

            $this->data___ = array(
                'kode_unit_subunit' => $kd_unit,
                'tahun' => $tahun,
                'kode_akun5digit' => $this->data_akun5digit
            );


            $this->data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($this->data___);

            $nomor_spm = $this->rsa_gup_model->get_spm_by_spp($nomor_trx_spp);


            if(empty($nomor_spm)){

                $this->data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($kd_unit,$tahun);


            }else{

                $nomor_spm_cair_before = $this->rsa_gup_model->get_nomer_spm_cair_lalu($kd_unit,$tahun);



                $this->data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_spm($nomor_spm);

                if($nomor_spm_cair_before != $nomor_spm){
                     $this->data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($kd_unit,$tahun);
                }
            }




                $this->data_akun5digit_before = array();

                if(!empty($this->data_akun_before)){
                    foreach($this->data_akun_before as $dk){
                        $this->data_akun5digit_before[] =  $dk->kode_akun5digit ;
                    }

                    $this->data___lalu = array(
                        'kode_unit_subunit' => $kd_unit,
                        'tahun' => $tahun,
                        'kode_akun5digit' => $this->data_akun5digit_before
                    );


                    $this->data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($this->data___lalu);

                }
            $rincian_keluaran = $this->rsa_gup_model->get_keluaran($nomor_trx_spp);

            $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
        }

        $this->data['data_akun_pengeluaran'] = $this->data_akun_pengeluaran;
        $this->data['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
        $this->data['data_akun_rkat'] = $this->data_akun_rkat;
        $this->data['data_akun_pengeluaran_lalu'] = $this->data_akun_pengeluaran_lalu;
        $this->data['data_spp_pajak'] = $this->data_spp_pajak;
        $this->data['rincian_keluaran'] = $rincian_keluaran;
        $this->data['rel_kuitansi'] = $du;
        $this->data['daftar_kuitansi'] = $daftar_kuitansi;
        $this->data['nomor_spp'] = $nomor_trx_spp;

        $this->data['nomor_spm'] = $nomor_trx_spm;


        $this->data['tgl_spm_kpa'] = $this->rsa_gup_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);

        $this->data['tgl_spm_verifikator'] = $this->rsa_gup_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);

        $this->data['tgl_spm_kbuu'] = $this->rsa_gup_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);

        $this->data['ket'] = $this->rsa_gup_model->lihat_ket($kd_unit,$tahun);

        $this->load->model('akun_kas6_model');

        $this->data['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();
                //$this->data['main_content']           = $this->load->view("rsa_gup/spm_gup_kbuu",$this->data,TRUE);
                //$this->load->view('main_template',$this->data);
            
        $this->data['tab'] = 'rsa_gup';
        $this->data['content'] = $this->load->view('akuntansi/rsa_gup_detail',$this->data,true);
        $this->load->view('akuntansi/content_template',$this->data);
    }
}
