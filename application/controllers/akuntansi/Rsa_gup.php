<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class rsa_gup extends MY_Controller{
    public function __construct(){ 
        parent::__construct();
        $this->cek_session_in();
    }
    
    function index(){
        $data['tab'] = 'rsa_gup';
        $data['content'] = $this->load->view('akuntansi/rsa_gup_detail',$this->data,true);
        $this->load->view('akuntansi/content_template',$data,false);
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
        $data['cur_tahun'] = $tahun;
        if(strlen($kd_unit)==2){
            $data['unit_kerja'] = $this->unit_model->get_nama($kd_unit);
            $data['unit_id'] = $kd_unit ;
            $data['kd_unit'] = $kd_unit ;
            $data['alias'] = $this->unit_model->get_alias($kd_unit);
        }
        elseif(strlen($kd_unit)==4){
                $data['unit_kerja'] = $this->unit_model->get_nama($kd_unit) . ' - ' . $this->unit_model->get_real_nama($kd_unit);
                $data['unit_id'] = $kd_unit;
                $data['kd_unit'] = $kd_unit ;
                $data['alias'] = $this->unit_model->get_alias($kd_unit);
        }
                                
                               
        $dokumen_gup = $this->rsa_gup_model->check_dokumen_gup_by_str_trx($no_spm);

        $data['doc_up'] = $dokumen_gup;

        $nomor_trx_spp =  $_spm->str_nomor_trx;
//        $nomor_trx_spp = $this->rsa_gup_model->get_nomor_spp($kd_unit,$tahun); 
                                
                                
        $data_spp = (object)array(
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

            $data_spp = $this->rsa_gup_model->get_data_spp($nomor_trx_spp);

            $data_kuitansi = $this->kuitansi_model->get_id_detail_by_str_nomor_spp($nomor_trx_spp);
            $kuitansi_d = array();
            if(!empty($data_kuitansi)){
                foreach($data_kuitansi as $dk){
                    $kuitansi_d[] = $dk->id_kuitansi;
                }
            }
            $du_ = json_encode($kuitansi_d);
            $data_url = urlencode(base64_encode($du_));
            $du = $data_url ;
            $data_url = urldecode($data_url);
            if( base64_encode(base64_decode($data_url, true)) === $data_url){
                //$array_id = base64_decode($data_url) ;
                $array_id = $data_spp->data_kuitansi;
                $data_ = array(
                    'kode_unit_subunit' => $kd_unit,
                    'array_id' => json_decode($array_id),
                    'tahun' => $data['cur_tahun'],
                );
                
                $pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
            }else{
                $pengeluaran = 0;
            }

            $data['detail_gup']   = array(
                                            'nom' => $data_spp->jumlah_bayar,
                                            'terbilang' => $data_spp->terbilang, 

                                        );

            $data['detail_pic']  = (object) array(
                'untuk_bayar' => $data_spp->untuk_bayar,
                'penerima' => $data_spp->penerima,
                'alamat_penerima' => $data_spp->alamat,
                'nama_bank_penerima' => $data_spp->nmbank,
                'no_rek_penerima' => $data_spp->rekening,
                'npwp_penerima' => $data_spp->npwp,
                'nmbendahara' => $data_spp->nmbendahara,
                'nipbendahara' => $data_spp->nipbendahara,


            );


            $data['tgl_spp'] = $data_spp->tgl_spp;

            $data['cur_tahun_spp'] = $data_spp->tahun;
            setlocale(LC_ALL, 'id_ID.utf8');$data['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 


        }else{

           $data['cur_tahun_spp'] = '';

        }


        //$nomor_trx_spm = '';

        if(($dokumen_gup == 'SPM-DRAFT-PPK') || ($dokumen_gup == 'SPM-DRAFT-KPA') || ($dokumen_gup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_gup == 'SPM-FINAL-KBUU')){

            $nomor_trx_spm = $this->rsa_gup_model->get_nomor_spm($kd_unit,$tahun);  

            $data_spm = $this->rsa_gup_model->get_data_spm($nomor_trx_spm);
            $data['detail_gup_spm']   = array(
                                            'nom' => $data_spm->jumlah_bayar,
                                            'terbilang' => $data_spm->terbilang, 

                                        );

            $data['detail_ppk']  = (object)array(
                'nm_lengkap' => $data_spm->nmppk,
                'nomor_induk' => $data_spm->nipppk
            );
            $data['detail_kpa']  = (object)array(
                'nm_lengkap' => $data_spm->nmkpa,
                'nomor_induk' => $data_spm->nipkpa
            );
            $data['detail_verifikator']  = (object)array(
                'nm_lengkap' => $data_spm->nmverifikator,
                'nomor_induk' => $data_spm->nipverifikator
            );
            $data['detail_kuasa_buu']  = (object)array(
                'nm_lengkap' => $data_spm->nmkbuu,
                'nomor_induk' => $data_spm->nipkbuu
            );
            $data['detail_buu']  = (object)array(
                'nm_lengkap' => $data_spm->nmbuu,
                'nomor_induk' => $data_spm->nipbuu
            );

            $data['detail_pic_spm']  = (object) array(
                'untuk_bayar' => $data_spm->untuk_bayar,
                'penerima' => $data_spm->penerima,
                'alamat_penerima' => $data_spm->alamat,
                'nama_bank_penerima' => $data_spm->nmbank,
                'no_rek_penerima' => $data_spm->rekening,
                'npwp_penerima' => $data_spm->npwp,

    //                                        'tgl_spp' => $data_spp->tgl_spp,

            );

            $data['tgl_spm'] = $data_spm->tgl_spm;

            $data['cur_tahun_spm'] = $data_spm->tahun;

        }else{

            $data['cur_tahun_spm'] = '';
            $data['tgl_spm'] = '' ;
        }

        $data_akun_pengeluaran = array();
        $data_spp_pajak = array();
        $data_akun_rkat = array();
        $data_akun_pengeluaran_lalu = array();
        $rincian_akun_pengeluaran = array();
        $rincian_keluaran = array();
        $daftar_kuitansi = array();


        if($pengeluaran > 0){
            $data__ = array(
                'kode_unit_subunit' => $kd_unit,
                'tahun' => $tahun,
                'array_id' => json_decode($array_id)
            );
            $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__);


            $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);
            $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__);
            $data_akun5digit = array();
            foreach($data_akun_pengeluaran as $da){
                $data_akun5digit[] =  $da->kode_akun5digit ;
            }

            $data___ = array(
                'kode_unit_subunit' => $kd_unit,
                'tahun' => $tahun,
                'kode_akun5digit' => $data_akun5digit
            );


            $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);

            $nomor_spm = $this->rsa_gup_model->get_spm_by_spp($nomor_trx_spp);


            if(empty($nomor_spm)){

                $data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($kd_unit,$tahun);


            }else{

                $nomor_spm_cair_before = $this->rsa_gup_model->get_nomer_spm_cair_lalu($kd_unit,$tahun);



                $data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_spm($nomor_spm);

                if($nomor_spm_cair_before != $nomor_spm){
                     $data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($kd_unit,$tahun);
                }
            }




                $data_akun5digit_before = array();

                if(!empty($data_akun_before)){
                    foreach($data_akun_before as $dk){
                        $data_akun5digit_before[] =  $dk->kode_akun5digit ;
                    }

                    $data___lalu = array(
                        'kode_unit_subunit' => $kd_unit,
                        'tahun' => $tahun,
                        'kode_akun5digit' => $data_akun5digit_before
                    );


                    $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___lalu);

                }
            $rincian_keluaran = $this->rsa_gup_model->get_keluaran($nomor_trx_spp);

            $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
        }

        $data['data_akun_pengeluaran'] = $data_akun_pengeluaran;
        $data['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
        $data['data_akun_rkat'] = $data_akun_rkat;
        $data['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
        $data['data_spp_pajak'] = $data_spp_pajak;
        $data['rincian_keluaran'] = $rincian_keluaran;
        $data['rel_kuitansi'] = $du;
        $data['daftar_kuitansi'] = $daftar_kuitansi;
        $data['nomor_spp'] = $nomor_trx_spp;

        $data['nomor_spm'] = $nomor_trx_spm;


        $data['tgl_spm_kpa'] = $this->rsa_gup_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);

        $data['tgl_spm_verifikator'] = $this->rsa_gup_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);

        $data['tgl_spm_kbuu'] = $this->rsa_gup_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);

        $data['ket'] = $this->rsa_gup_model->lihat_ket($kd_unit,$tahun);

        $this->load->model('akun_kas6_model');

        $data['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();
                //$data['main_content']           = $this->load->view("rsa_gup/spm_gup_kbuu",$data,TRUE);
                //$this->load->view('main_template',$data);
            
        $data['tab'] = 'rsa_gup';
        $data['content'] = $this->load->view('akuntansi/rsa_gup_detail',$data,true);
        $this->load->view('akuntansi/content_template',$data);
    }
}
