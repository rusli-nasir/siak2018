<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coba extends MY_Controller {
	public function __construct(){
        // $this->cek_session_in();

		parent::__construct();
        $this->load->model(array('rsa_gup_model','setting_up_model'));
        $this->load->model("user_model");
        $this->load->model("unit_model");
        $this->load->model('menu_model');
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
        $this->load->model('akuntansi/Akun_model', 'Akun_model');
        $this->load->model('akuntansi/Coba_model', 'Coba_model');
        $this->load->model('akuntansi/Pajak_model', 'Pajak_model');
        $this->load->model('akuntansi/Laporan_model', 'Laporan_model');
        $this->load->model('akuntansi/Spm_model', 'Spm_model');
        $this->load->model('akuntansi/User_akuntansi_model', 'User_akuntansi_model');
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->load->model('akuntansi/Unit_kerja_model', 'Unit_kerja_model');
        $this->load->model('akuntansi/Akun_belanja_rsa_model', 'Akun_belanja_rsa_model');
	}

    public function array_mesh() {
        // Combine multiple associative arrays and sum the values for any common keys
        // The function can accept any number of arrays as arguments
        // The values must be numeric or the summed value will be 0
        
        // Get the number of arguments being passed
        $numargs = func_num_args();
        
        // Save the arguments to an array
        $arg_list = func_get_args();
        
        // Create an array to hold the combined data
        $out = array();

        // Loop through each of the arguments
        for ($i = 0; $i < $numargs; $i++) {
            $in = $arg_list[$i]; // This will be equal to each array passed as an argument

            // Loop through each of the arrays passed as arguments
            foreach($in as $key => $value) {
                // If the same key exists in the $out array
                if(array_key_exists($key, $out)) {
                    // Sum the values of the common key
                    $sum = $in[$key] + $out[$key];
                    // Add the key => value pair to array $out
                    $out[$key] = $sum;
                }else{
                    // Add to $out any key => value pairs in the $in array that did not have a match in $out
                    $out[$key] = $in[$key];
                }
            }
        }
        
        return $out;
    }

    public function index()
    {

        echo $this->session->userdata('setting_tahun');
        // $this->load->helper('cookie');
        // 
        // setcookie ("cookie", "", time() - 3600);

        // setcookie("cookie[three]", "cookiethree");
        // setcookie("cookie[two]", "cookietwo");
        // setcookie("cookie[one]", "cookieone");

        // $_COOKIE['hai'] = 'haaaa0i';
        // $_COOKIE['login'] = 'yes0';


        // $this->load->view('akuntansi/coba2');

        // $teks = "20 September 2017";
        // $_POST = $_GET;
        // echo "<pre>";
        // echo urlencode($teks);
        // echo "\n";
        // echo urldecode($teks);
        // echo "\n";
        // print_r($this->input->post());
        // $a = array(
        //     'a' => array(1,2,3),
        //     'b' => 1
        // );

        // $b = array(
        //     'a' => array(3,4,5),
        //     'b' => 2
        // );



        // $c = array_merge_recursive($a,$b);

        // print_r($a);
        // print_r($b);
        // print_r($c);
        // 
        

    }

    public function rekap_spm_unit()
    {
        $list_unit = $this->Unit_kerja_model->get_all_unit_kerja();
        foreach ($list_unit as $unit) {
            $kode_unit = $unit['kode_unit'];
            $nama_unit = $unit['alias'];
            $query_s = "
            SELECT
              rsa.akuntansi_kuitansi_jadi.no_spm,
              rsa.akuntansi_kuitansi_jadi.tanggal,
              rsa.akuntansi_kuitansi_jadi.jenis,
              rsa.akuntansi_kuitansi_jadi.unit_kerja,
              rsa.akuntansi_kuitansi_jadi.jumlah_debet AS jumlah
            INTO OUTFILE \"d:/rekap/".$nama_unit."_s.csv\"
              FIELDS TERMINATED BY ',' 
                LINES TERMINATED BY \"\\n\"
            FROM
              rsa.akuntansi_kuitansi_jadi
            WHERE
              rsa.akuntansi_kuitansi_jadi.tanggal BETWEEN '2017-01-01' AND '2017-09-30' AND
              rsa.akuntansi_kuitansi_jadi.jenis NOT IN ('GP', 'LK', 'LN') AND
              rsa.akuntansi_kuitansi_jadi.unit_kerja = $kode_unit  AND
              rsa.akuntansi_kuitansi_jadi.status = 'posted' AND
              rsa.akuntansi_kuitansi_jadi.tipe = 'pengeluaran'
            ";
            $this->db->query($query_s);
            $query_k = "
            SELECT
              rsa.akuntansi_kuitansi_jadi.no_spm,
              rsa.akuntansi_kuitansi_jadi.tanggal,
              rsa.akuntansi_kuitansi_jadi.jenis,
              rsa.akuntansi_kuitansi_jadi.unit_kerja,
              Sum(rsa.akuntansi_kuitansi_jadi.jumlah_debet) AS jumlah
            INTO OUTFILE \"d:/rekap/".$nama_unit."_k.csv\"
              FIELDS TERMINATED BY ',' 
                LINES TERMINATED BY \"\\n\"
            FROM
              rsa.akuntansi_kuitansi_jadi
            WHERE
              rsa.akuntansi_kuitansi_jadi.tanggal BETWEEN '2017-01-01' AND '2017-09-30' AND
              rsa.akuntansi_kuitansi_jadi.jenis IN ('GP', 'LK', 'LN','TUP_PENGEMBALIAN') AND
              rsa.akuntansi_kuitansi_jadi.unit_kerja = $kode_unit AND
              rsa.akuntansi_kuitansi_jadi.status = 'posted' AND
              rsa.akuntansi_kuitansi_jadi.tipe = 'pengeluaran'
            GROUP BY
              rsa.akuntansi_kuitansi_jadi.no_spm
            ";
            $this->db->query($query_k);
        }
    }

    public function coba_123()
    {
        $hasil = $this->db->get('akuntansi_aset_6')->result_array();
        foreach ($hasil as $key => $entry) {
            echo $entry['nama']." - ".$entry['akun_6']."<br/>";
        }
    }

    public function coba_akun_biaya()
    {
        print_r($this->Akun_model->get_all_akun_biaya());
    }


    public function cek_129()
    {
        $array_akun = array(129);
        print_r($this->Laporan_model->get_buku_besar($array_akun,null,null,null,"2017-01-01","2017-12-31",'neraca'));
    }

    public function coba_regex()
    {
        echo preg_replace("[']",'',"'12-12-1234");
    }

    public function coba_backup()
    {
        print_r($this->Coba_model->backup_rsa());
    }

    public function coba_akrual($value='')
    {
        print_r($this->Akun_belanja_rsa_model->get_all_akun_belanja());
    }

    public function coba_api($x)
    {
        // $user = json_decode(
        //     file_get_contents('http://admin:1234@example.com/index.php/api/user/id/1/format/json')
        //     file_get_contents('http://4P1_undip:q1w2e3r4asdf@localhost/rsa/index.php/akuntansi/api/kuitansi_by_kode_kegiatan/id/haii/')
        // );

        // echo file_get_contents('http://4P1_undip:q1w2e3r4asdf@localhost/rsa/index.php/akuntansi/api/kuitansi_by_kode_kegiatan/id/haii/');
        $this->Kuitansi_model->get_kuitansi_aset_by_kode_kegiatan($x);
    }

    

    public function cek_memori($value='')
    {
        ini_set('memory_limit', '256M');
        $memory_limit = ini_get('memory_limit');
        if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
            if ($matches[2] == 'M') {
                $memory_limit = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
            } else if ($matches[2] == 'K') {
                $memory_limit = $matches[1] * 1024; // nnnK -> nnn KB
            }
        }

        $ok = ($memory_limit >= 640 * 1024 * 1024); // at least 64M?

        echo '<phpmem>';
        echo '<val>' . $memory_limit . '</val>';
        echo '<ok>' . ($ok ? 1 : 0) . '</ok>';
        echo '</phpmem>';
    }

	public function pajak()
	{
        $array_pajak = $this->Pajak_model->get_transfer_pajak(5);
		print_r($array_pajak);
        $pajak = $this->Pajak_model->get_akun_by_jenis('PPh_Ps_21');
        print_r($pajak);
	}

    public function pajak2()
    {
        print_r($this->Pajak_model->get_detail_pajak('FTE00010','GP'));
    }

    // public function fixing_nk()
    // {
    //     // die('aa');
    //     print_r($this->Coba_model->fixing_nk());
    // }

    // public function fixing_pajak($start,$end)
    // {
    //     // die('aa');
    //     print_r($this->Coba_model->fixing_pajak($start,$end));
    // }

    // public function fixing_gp()
    // {
    //     // die('aa');
    //     // $this->Kuitansi_model->coba();
    //     print_r($this->Coba_model->fixing_gp());
    // }

    public function spm()
    {
        print_r($this->Spm_model->get_spm_input(24,'up'));
    }

    public function user()
    {
        print_r($this->User_akuntansi_model->generate_kode_user(11));
    }

    public function sal()
    {
        print_r($this->Jurnal_rsa_model->get_akun_sal_by_unit('1','all'));
    }

    public function akun()
    {
        print_r($this->Akun_model->get_nama_akun('111112'));
    }

    public function tgl_spm()
    {
        $data = $this->rsa_gup_model->get_data_spm("00003/FHU/SPM-GUP/FEB/2017");
        echo $data->tgl_spm;
        echo "<br/>";
        $data = $this->rsa_gup_model->get_data_spm("00004/FHU/SPM-LS PGW/MAR/2017");
        echo $data->tgl_spm;

    }

	function spm_gup_kbuu($kd_unit=11,$cur_tahun=2017){
		if(true){
                //set data for main template   
                //$subdata_rsa_up['result_rsa_up']      = $this->rsa_up_model->search_rsa_up();

			$this->load->model('unit_model');
			$this->cur_tahun = $cur_tahun;
			$tahun = $cur_tahun;
			$subdata['cur_tahun'] = $tahun;
			if(strlen($kd_unit)==2){
				$subdata['unit_kerja'] = $this->unit_model->get_nama($kd_unit);
				$subdata['unit_id'] = $kd_unit ;
				$subdata['kd_unit'] = $kd_unit ;
				$subdata['alias'] = $this->unit_model->get_alias($kd_unit);
			}
			elseif(strlen($kd_unit)==4){
                $subdata['unit_kerja'] = $this->unit_model->get_nama($kd_unit) . ' - ' . $this->unit_model->get_real_nama($kd_unit);//$this->check_session->get_nama_unit();
                $subdata['unit_id'] = $kd_unit;
                $subdata['kd_unit'] = $kd_unit ;
                $subdata['alias'] = $this->unit_model->get_alias($kd_unit);
            }

                //$subdata['alias'] = $this->unit_model->get_alias($kd_unit);// $this->check_session->get_alias();

            $dokumen_gup = $this->rsa_gup_model->check_dokumen_gup($kd_unit,$tahun);

            $subdata['doc_up'] = $dokumen_gup;

            $nomor_trx_spp = $this->rsa_gup_model->get_nomor_spp($kd_unit,$tahun); 

//                                echo $nomor_trx_spp ; die;

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
//                                    var_dump($data_spp);die;

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
                    		$array_id = base64_decode($data_url) ;
//                                            $array_id = $this->input->post('rel_kuitansi');
//                                            echo $array_id ; die ;
                    		$array_id = $data_spp->data_kuitansi;
//                                            echo $array_id ; die ;
                    		$data_ = array(
                    			'kode_unit_subunit' => $kd_unit,
                    			'array_id' => json_decode($array_id),
                    			'tahun' => $this->cur_tahun,
                    			);
                    		$pengeluaran = $this->kuitansi_model->get_pengeluaran_by_array_id($data_);
                    	}else{
                    		$pengeluaran = 0;
                    	}

                    	$subdata['detail_gup']   = array(
                    		'nom' => $data_spp->jumlah_bayar,
                    		'terbilang' => $data_spp->terbilang, 

                    		);

//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                    	$subdata['detail_pic']  = (object) array(
                    		'untuk_bayar' => $data_spp->untuk_bayar,
                    		'penerima' => $data_spp->penerima,
                    		'alamat_penerima' => $data_spp->alamat,
                    		'nama_bank_penerima' => $data_spp->nmbank,
                    		'no_rek_penerima' => $data_spp->rekening,
                    		'npwp_penerima' => $data_spp->npwp,
                    		'nmbendahara' => $data_spp->nmbendahara,
                    		'nipbendahara' => $data_spp->nipbendahara,

//                                        'tgl_spp' => $data_spp->tgl_spp,

                    		);



//                                if(($dokumen_gup == '') || ($dokumen_gup == 'SPP-DITOLAK') || ($dokumen_gup == 'SPM-DITOLAK')){
//                                    $subdata['siap_spp'] = 'ok';
//                                }else{
//                                    $subdata['siap_spp'] = 'no_ok';
//                                }

                    	$subdata['tgl_spp'] = $data_spp->tgl_spp;

                    	$subdata['cur_tahun_spp'] = $data_spp->tahun;
                    	setlocale(LC_ALL, 'id_ID.utf8');$subdata['bulan'] = strftime("%B", strtotime($data_spp->tgl_spp)); 


                    }else{

                    	$subdata['cur_tahun_spp'] = '';

                    }

//                                $subdata['tgl_spm'] = $this->rsa_up_model->get_tgl_spm($kd_unit,$tahun);

                    $nomor_trx_spm = '';

                    if(($dokumen_gup == 'SPM-DRAFT-PPK') || ($dokumen_gup == 'SPM-DRAFT-KPA') || ($dokumen_gup == 'SPM-FINAL-VERIFIKATOR')  || ($dokumen_gup == 'SPM-FINAL-KBUU')){

                    	$nomor_trx_spm = $this->rsa_gup_model->get_nomor_spm($kd_unit,$tahun);  

                    	$data_spm = $this->rsa_gup_model->get_data_spm($nomor_trx_spm);
                    	$subdata['detail_gup_spm']   = array(
                    		'nom' => $data_spm->jumlah_bayar,
                    		'terbilang' => $data_spm->terbilang, 

                    		);

                    	$subdata['detail_ppk']  = (object)array(
                    		'nm_lengkap' => $data_spm->nmppk,
                    		'nomor_induk' => $data_spm->nipppk
                    		);
                    	$subdata['detail_kpa']  = (object)array(
                    		'nm_lengkap' => $data_spm->nmkpa,
                    		'nomor_induk' => $data_spm->nipkpa
                    		);
                    	$subdata['detail_verifikator']  = (object)array(
                    		'nm_lengkap' => $data_spm->nmverifikator,
                    		'nomor_induk' => $data_spm->nipverifikator
                    		);
                    	$subdata['detail_kuasa_buu']  = (object)array(
                    		'nm_lengkap' => $data_spm->nmkbuu,
                    		'nomor_induk' => $data_spm->nipkbuu
                    		);
                    	$subdata['detail_buu']  = (object)array(
                    		'nm_lengkap' => $data_spm->nmbuu,
                    		'nomor_induk' => $data_spm->nipbuu
                    		);

//                                    $subdata['detail_pic']  = $this->user_model->get_detail_rsa_user($this->check_session->get_unit(),'13');
                    	$subdata['detail_pic_spm']  = (object) array(
                    		'untuk_bayar' => $data_spm->untuk_bayar,
                    		'penerima' => $data_spm->penerima,
                    		'alamat_penerima' => $data_spm->alamat,
                    		'nama_bank_penerima' => $data_spm->nmbank,
                    		'no_rek_penerima' => $data_spm->rekening,
                    		'npwp_penerima' => $data_spm->npwp,

//                                        'tgl_spp' => $data_spp->tgl_spp,

                    		);

                    	$subdata['tgl_spm'] = $data_spm->tgl_spm;

                    	$subdata['cur_tahun_spm'] = $data_spm->tahun;

                    }else{

                    	$subdata['cur_tahun_spm'] = '';
                    	$subdata['tgl_spm'] = '' ;
                    }

                    $data_akun_pengeluaran = array();
                    $data_spp_pajak = array();
                    $data_akun_rkat = array();
                    $data_akun_pengeluaran_lalu = array();
                    $rincian_akun_pengeluaran = array();
                    $rincian_keluaran = array();
                    $daftar_kuitansi = array();

//                                if($pengeluaran > 0){
//                                    $data__ = array(
//                                        'kode_unit_subunit' => $kd_unit,
//                                        'tahun' => $this->cur_tahun,
//                                        'array_id' => json_decode($array_id)
//                                    );
////                                    print_r($data__);die;
//                                    $data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__);
////                                    $data_array_id = json_decode($array_id);
////                                    if(count($data_array_id) > 1){
////                                        foreach($data_array_id as $id){
//////                                            $str_ .= "rsa.rsa_kuitansi.id_kuitansi = '{$id}' OR " ;
////                                            $rincian_akun_pengeluaran[] = $this->kuitansi_model->get_rekap_detail_kuitansi($id,$this->cur_tahun);
////                                        }
//////                                        $str_ = substr($str_,0,  strlen($str_) - 3 );
////                                    }else{
////                                        $rincian_akun_pengeluaran[] = $this->kuitansi_model->get_rekap_detail_kuitansi($data_array_id[0],$this->cur_tahun);
//////                                        $str_ = "rsa.rsa_kuitansi.id_kuitansi = '{$data['array_id'][0]}'" ;
////                                    }
//                                    
////                                    function get_data_detail_kuitansi($id_kuitansi,$tahun){
////                                    $rincian_akun_pengeluaran = 
//                                    $rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);
////                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
//                                    $data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__);
//                                    $data_akun5digit = array();
////                                    if(!empty($data_akun_pengeluaran)){
//                                    foreach($data_akun_pengeluaran as $da){
//                                        $data_akun5digit[] =  $da->kode_akun5digit ;
//                                    }
////                                    
////                                    echo '<pre>';print_r($data___);echo '</pre>';die;
//                                    
//                                    $data___ = array(
//                                        'kode_unit_subunit' => $kd_unit,
//                                        'tahun' => $this->cur_tahun,
//                                        'kode_akun5digit' => $data_akun5digit
//                                    );
////                                    echo '<pre>';print_r($data___);echo '</pre>';die;
//                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
//                                    
//                                    $data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___);
////                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
////                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
////                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
////                                    var_dump($data_spp_pajak);die;
//                                    $rincian_keluaran = $this->rsa_gup_model->get_keluaran($nomor_trx_spp);
//                                    $daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
//                                }

                    if($pengeluaran > 0){
                    	$data__ = array(
                    		'kode_unit_subunit' => $kd_unit,
                    		'tahun' => $tahun,
                    		'array_id' => json_decode($array_id)
                    		);
//                                    print_r($data__);die;
                    	$data_akun_pengeluaran = $this->kuitansi_model->get_pengeluaran_by_akun5digit($data__);
                   // var_dump($data_akun_pengeluaran);die;
//                                    $data_array_id = json_decode($array_id);
//                                    if(count($data_array_id) > 1){
//                                        foreach($data_array_id as $id){
////                                            $str_ .= "rsa.rsa_kuitansi.id_kuitansi = '{$id}' OR " ;
//                                            $rincian_akun_pengeluaran[] = $this->kuitansi_model->get_rekap_detail_kuitansi($id,$this->cur_tahun);
//                                        }
////                                        $str_ = substr($str_,0,  strlen($str_) - 3 );
//                                    }else{
//                                        $rincian_akun_pengeluaran[] = $this->kuitansi_model->get_rekap_detail_kuitansi($data_array_id[0],$this->cur_tahun);
////                                        $str_ = "rsa.rsa_kuitansi.id_kuitansi = '{$data['array_id'][0]}'" ;
//                                    }

//                                    function get_data_detail_kuitansi($id_kuitansi,$tahun){
//                                    $rincian_akun_pengeluaran = 
                    	$rincian_akun_pengeluaran = $this->kuitansi_model->get_rekap_detail_kuitansi($data__);
                   // echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                    	$data_spp_pajak = $this->kuitansi_model->get_spp_pajak($data__);
                    	$data_akun5digit = array();
//                                    if(!empty($data_akun_pengeluaran)){
                    	foreach($data_akun_pengeluaran as $da){
                    		$data_akun5digit[] =  $da->kode_akun5digit ;
                    	}
//                                    
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;

                    	$data___ = array(
                    		'kode_unit_subunit' => $kd_unit,
                    		'tahun' => $tahun,
                    		'kode_akun5digit' => $data_akun5digit
                    		);
//                                    echo '<pre>';print_r($data___);echo '</pre>';die;
//                                    $data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);
//                                    
//                                    $nomor_spm_cair_lalu = $this->rsa_gup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);
//                                    
//                                    $nomor_spp_cair_lalu = $this->rsa_gup_model->get_spp_by_spm($nomor_spm_cair_lalu);
//                                    
//                                    echo $nomor_spm_cair_lalu; die;

                    	$data_akun_rkat = $this->kuitansi_model->get_pengeluaran_by_akun_rkat($data___);

                    	$nomor_spm = $this->rsa_gup_model->get_spm_by_spp($nomor_trx_spp);

//                                    echo $nomor_spm_cair_before; die;

                    	if(empty($nomor_spm)){

                    		$data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($kd_unit,$tahun);

//                                        var_dump($data_akun_before); die;

                    	}else{

                    		$nomor_spm_cair_before = $this->rsa_gup_model->get_nomer_spm_cair_lalu($kd_unit,$tahun);

                        // echo $nomor_spm_cair_before ; die;

                    		$data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_spm($nomor_spm);

                    		if($nomor_spm_cair_before != $nomor_spm){
                    			$data_akun_before = $this->kuitansi_model->get_gup_akun_before_by_unit($kd_unit,$tahun);
                    		}
                    	}


//                                    
//                                    $nomor_spm_cair_before = $this->rsa_gup_model->get_nomer_spm_cair_lalu($this->check_session->get_unit(),$this->cur_tahun);

//                                    if($nomor_spp_cair_lalu != $nomor_trx){
//                                        $data_akun_lalu = $this->kuitansi_model->get_gup_akun_lalu($this->check_session->get_unit(),$this->cur_tahun);

//                                    echo '<pre>';print_r($data_akun_lalu);echo '</pre>';die;

                    	$data_akun5digit_before = array();

//                                    if(!empty($data_akun_pengeluaran)){

                    	if(!empty($data_akun_before)){
                    		foreach($data_akun_before as $dk){
                    			$data_akun5digit_before[] =  $dk->kode_akun5digit ;
                    		}

                    		$data___lalu = array(
                    			'kode_unit_subunit' => $kd_unit,
                    			'tahun' => $tahun,
                    			'kode_akun5digit' => $data_akun5digit_before
                    			);

//                                    echo '<pre>';print_r($data___lalu);echo '</pre>';die;

                    		$data_akun_pengeluaran_lalu = $this->kuitansi_model->get_pengeluaran_by_akun5digit_lalu($data___lalu);

                    	}


//                                    }



//                                    echo '<pre>';print_r($data_akun_pengeluaran);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_pengeluaran_lalu);echo '</pre>';die;
//                                    echo '<pre>';print_r($data_akun_rkat);echo '</pre>';die;
//                                    var_dump($data_spp_pajak);die;
//                                    $rincian_keluaran = $this->rsa_gup_model->get_keluaran($nomor_trx);
//                                    echo '<pre>';print_r($rincian_akun_pengeluaran);echo '</pre>';die;
                    	$rincian_keluaran = $this->rsa_gup_model->get_keluaran($nomor_trx_spp);

                    	$daftar_kuitansi = $this->kuitansi_model->get_kuitansi_by_url_id(base64_decode(urldecode($du)));
                    }

                    $subdata['data_akun_pengeluaran'] = $data_akun_pengeluaran;
                    $subdata['rincian_akun_pengeluaran'] = $rincian_akun_pengeluaran;
                    $subdata['data_akun_rkat'] = $data_akun_rkat;
                    $subdata['data_akun_pengeluaran_lalu'] = $data_akun_pengeluaran_lalu;
                    $subdata['data_spp_pajak'] = $data_spp_pajak;
                    $subdata['rincian_keluaran'] = $rincian_keluaran;
                    $subdata['rel_kuitansi'] = $du;
                    $subdata['daftar_kuitansi'] = $daftar_kuitansi;
                    $subdata['nomor_spp'] = $nomor_trx_spp;

                    $subdata['nomor_spm'] = $nomor_trx_spm;

//                                $subdata['detail_verifikator']  = $this->rsa_up_model->get_verifikator($kd_unit,$tahun,$nomor_trx_spm);

                    $subdata['tgl_spm_kpa'] = $this->rsa_gup_model->get_tgl_spm_kpa($kd_unit,$tahun,$nomor_trx_spm);

                    $subdata['tgl_spm_verifikator'] = $this->rsa_gup_model->get_tgl_spm_verifikator($kd_unit,$tahun,$nomor_trx_spm);

                    $subdata['tgl_spm_kbuu'] = $this->rsa_gup_model->get_tgl_spm_kbuu($kd_unit,$tahun,$nomor_trx_spm);

                    $subdata['ket'] = $this->rsa_gup_model->lihat_ket($kd_unit,$tahun);

                    $this->load->model('akun_kas6_model');

                $subdata['kas_undip'] = $this->akun_kas6_model->get_akun_kas6_saldo();//(array('kd_kas_3'=>'111'));
                
//                                var_dump( $subdata['kas_undip']);die;
                
//$subdata['opt_unit_kepeg']        = $this->option->opt_unit_kepeg();
//                                var_dump($subdata);die;
                $this->load->view("akuntansi/coba",$subdata);

            } else {
            	echo 'no session';
            }
        }
    }
