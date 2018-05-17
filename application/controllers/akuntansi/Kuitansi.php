<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuitansi extends MY_Controller {
	public function __construct(){
        parent::__construct();
        //$this->data['menu1'] = true;
        $this->cek_session_in();
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
        $this->load->model('akuntansi/Spm_model', 'spm_model');
        $this->load->model('akuntansi/Jurnal_rsa_model', 'jurnal_rsa_model');
        $this->data['db2'] = $this->load->database('rba',TRUE);
    }

    public function pilih_unit(){
    	if($this->session->userdata('level')=='2' AND $this->session->userdata('username')=='verifikator'){	
	        //$this->db3 = $this->load->database('rsa', true);
	    	$this->db2 = $this->load->database('rba', true);
	    	$this->data['query_unit'] = $this->db2->query("SELECT * FROM unit ORDER BY nama_unit ASC");
	        $this->data['tmp'] = $this->db->query("SELECT unit_kerja, COUNT(*) as jumlah FROM akuntansi_kuitansi_jadi WHERE flag=1 AND tipe<>'pajak' AND (status='direvisi' OR status='proses') GROUP BY unit_kerja ORDER BY jumlah ASC");
	        foreach($this->data['tmp']->result_array() as $token){
	            $this->data['jumlah_verifikasi'][$token['unit_kerja']] = $token['jumlah'];
	        }
	        $this->data['tmp'] = $this->db->query("SELECT unit_kerja, COUNT(*) as jumlah FROM akuntansi_kuitansi_jadi WHERE flag=2 AND tipe<>'pajak' AND (status='proses') GROUP BY unit_kerja ORDER BY jumlah ASC");
	        foreach($this->data['tmp']->result_array() as $token){
	            $this->data['jumlah_posting'][$token['unit_kerja']] = $token['jumlah'];
	        }
	    	$temp_data['content'] = $this->load->view('akuntansi/pilih_unit',$this->data,true);
			$this->load->view('akuntansi/content_template',$temp_data,false);
		}else{
			redirect(site_url('akuntansi/kuitansi/jadi'));
		}
    }

    public function set_unit_session($kode_unit, $posting=null){
    	$this->session->set_userdata('kode_unit', $kode_unit);
    	if($posting) redirect(site_url('akuntansi/kuitansi/posting')); else redirect(site_url('akuntansi/kuitansi/jadi'));
	}
	
	public function lihat_kuitansi()
	{
		$data_jenis = $this->Kuitansi_model->get_jenis_kuitansi_non_input();
		
		if ($this->session->userdata('kuitansi_aktif')){
			$aktif = $this->session->userdata('kuitansi_aktif');
		}else{
			$aktif = 'GP';
		}
		for ($i=0; $i < count($data_jenis); $i++) { 
			$data_jenis[$i]['notif'] = $this->data['jumlah_notifikasi']->$data_jenis[$i]['nama_notifikasi'];
			$indeks_jadi = $data_jenis[$i]['nama_notifikasi'].'_jadi';
			$data_jenis[$i]['notif_jadi'] = $this->data['jumlah_notifikasi']->$indeks_jadi;
			if ($data_jenis[$i]['nama_terjurnal'] == $aktif){
				$data_jenis[$i]['aktif'] = true;
			}else {
				$data_jenis[$i]['aktif'] = false;
			}
		}
		
		$this->data['all_jenis'] = json_encode($data_jenis,JSON_PRETTY_PRINT);
		$this->data['jenis_aktif'] = $aktif;
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi/daftar_kuitansi',$this->data,true);

		$this->load->view('akuntansi/template/main',$temp_data);
	}

   public function lists($jenis){	
   	//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}
		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		//pagination
		$id = $this->uri->segment('6');
		if ($id == null AND ($this->input->get('page') != null) ) {
			$id = $this->input->get('page');
			$current_page = $id;
		}
		if($id==null){
			$id = 0;
			$current_page = $id;
			$this->data['no'] = $id+1;
		}else{
			$current_page = $id;
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}

		$config['per_page'] = 20;

		if ($jenis == 'UP') {
  			$this->data['tab4'] = true;

			//search
  			if(isset($_POST['keyword_up'])){
  				$keyword = $this->input->post('keyword_up');
  				$this->session->set_userdata('keyword_up', $keyword);		
  			}else{
  				if($this->session->userdata('keyword_up')!=null){
  					$keyword = $this->session->userdata('keyword_up');
  				}else{
  					$keyword = '';
  				}
  			}

  			$total_data = $this->Kuitansi_model->read_up(null, null, $keyword, $kode_unit);
  			$total = $total_data->num_rows();

			  $query = $this->data['query'] = $this->Kuitansi_model->read_up($config['per_page'], $id, $keyword, $kode_unit)->result_array();
			  

  			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_up('SPM-FINAL-KBUU', 0)->num_rows();
  			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_up('SPM-FINAL-KBUU', 1)->num_rows();

   	} elseif ($jenis == 'GP') {
   		$this->data['tab1'] = true;

   		$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit,'GP');
   		$total = $total_data->num_rows();

		   $this->data['jenis_isi'] = "GP";

		   $query = $this->data['query'] = $this->Kuitansi_model->read_kuitansi_gup($config['per_page'], $id, $keyword, $kode_unit,'GUP')->result_array();

		   $this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_gup($config['per_page'], $id, $keyword, $kode_unit,'GUP',true)->result_array();



   		// echo "<pre>";
   		// print_r ($this->data['query']);
   		// die();

   		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total_gup('GUP',$this->session->userdata('kode_unit'),0)->num_rows();
   		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total_gup('GUP',$this->session->userdata('kode_unit'),1)->num_rows();

   	}elseif ($jenis == 'TUP_NIHIL') {
  			$this->data['tab8'] = true;

  			$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit,'TP');
  			$total = $total_data->num_rows();

  			$query = $this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit,'TP')->result_array();

   		// echo "<pre>";
   		// print_r ($this->data['query']);

  			$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit,'TP')->result_array();

  			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0,'jenis'=>'TP', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
  			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1,'jenis'=>'TP', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
  			$this->data['jenis_isi'] = "TUP_NIHIL";

   	}elseif ($jenis == 'LK') {
   		$this->data['tab11'] = true;

   		$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit,'LK');
   		$total = $total_data->num_rows();

   		$query = $this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit,'LK')->result_array();

   		// foreach ($query as $key=>$parse) {
   		// 	$parsed = $this->Kuitansi_model->get_detail_pajak($parse['no_bukti'], $parse['jenis']);
   		// 	$this->data['query'][$key]['pajak'] = $parsed;
   		// 	$this->data['query'][$key]['url_bukti'] = $this->get_url($parse['id_kuitansi'],$parse['jenis'],null,$parse['str_nomor_trx'],$parse['tahun'], $kode_unit);
   		// }
   		// echo "<pre>";
   		// print_r ($this->data['query']);
   		// // die();

   		$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit,'LK')->result_array();

   		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0,'jenis'=>'LK', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
   		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1,'jenis'=>'LK', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
   		$this->data['jenis_isi'] = "LK";

   	}elseif ($jenis == 'LN') {
  			$this->data['tab12'] = true;

  			$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit,'LN');
  			$total = $total_data->num_rows();

  			$query = $this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit,'LN')->result_array();

  			// foreach ($query as $key=>$parse) {
   		// 	$parsed = $this->Kuitansi_model->get_detail_pajak($parse['no_bukti'], $parse['jenis']);
   		// 	$this->data['query'][$key]['pajak'] = $parsed;
   		// 	$this->data['query'][$key]['url_bukti'] = $this->get_url($parse['id_kuitansi'],$parse['jenis'],null,$parse['str_nomor_trx'],$parse['tahun'], $kode_unit);
   		// }
   		// echo "<pre>";
   		// print_r ($this->data['query']);
   		// // die();

  			$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit,'LN')->result_array();

  			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0,'jenis'=>'LN', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
  			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1,'jenis'=>'LN', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
  			$this->data['jenis_isi'] = "LN";

   	}elseif ($jenis == 'GUP_NIHIL') {
   		if(isset($_POST['keyword_'.$jenis])){
   			$keyword = $this->input->post('keyword');
   			$this->session->set_userdata('keyword', $keyword);		
   		}else{
   			if($this->session->userdata('keyword')!=null){
   				$keyword = $this->session->userdata('keyword');
   			}else{
   				$keyword = '';
   			}
   		}

  			$total_data = $this->Kuitansi_model->read_gup(null, null, $keyword, $kode_unit);
			$total = $total_data->num_rows();

			$query = $this->data['query'] = $this->Kuitansi_model->read_kuitansi_gup($config['per_page'], $id, $keyword, $kode_unit,'GUP_NIHIL')->result_array();

			$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_gup($config['per_page'], $id, $keyword, $kode_unit,'GUP_NIHIL',true)->result_array();
			$this->data['jenis'] = 'GUP_NIHIL';
			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total_gup('GUP_NIHIL',$this->session->userdata('kode_unit'),0)->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total_gup('GUP_NIHIL',$this->session->userdata('kode_unit'),1)->num_rows();
   	}elseif ($jenis == 'EM') {
  		
  		$total_data = $this->Kuitansi_model->read_em(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();

		$this->data['jenis'] = 'EM';

		$query = $this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit,'EM')->result_array();
		$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit,'EM')->result_array();

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0,'jenis'=>'EM', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1,'jenis'=>'EM', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();

   	}elseif ($jenis == 'PUP') {
   		$this->data['tab6'] = true;
		
			$total_data = $this->Kuitansi_model->read_pup(null, null, $keyword, $kode_unit);
			$total = $total_data->num_rows();
			
			$query = $this->data['query'] = $this->Kuitansi_model->read_pup($config['per_page'], $id, $keyword, $kode_unit)->result_array();

			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_pup('SPM-FINAL-KBUU', 0)->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_pup('SPM-FINAL-KBUU', 1)->num_rows();
		
   	}elseif ($jenis == 'GUP') {
  		$this->data['tab9'] = true;

			$total_data = $this->Kuitansi_model->read_gup(null, null, $keyword, $kode_unit);
			$total = $total_data->num_rows();

			$query = $this->data['query'] = $this->Kuitansi_model->read_gup($config['per_page'], $id, $keyword, $kode_unit)->result_array();


      // echo "<pre>";
      // print_r ($this->data['query']);
      // die();


			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_gup('SPM-FINAL-KBUU', 0)->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_gup('SPM-FINAL-KBUU', 1)->num_rows();

   	}elseif ($jenis == 'TUP') {
	  		$this->data['tab5'] = true;

			$total_data = $this->Kuitansi_model->read_tup(null, null, $keyword, $kode_unit);
			$total = $total_data->num_rows();

			$query = $this->data['query'] = $this->Kuitansi_model->read_tup($config['per_page'], $id, $keyword, $kode_unit)->result_array();

			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_tup('SPM-FINAL-KBUU', 0)->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_tup('SPM-FINAL-KBUU', 1)->num_rows();

   	}elseif ($jenis == 'NK') {
   		$total_data = $this->Kuitansi_model->read_spm(null, null, $keyword);
			$total = $total_data->num_rows();

  		$query = $this->data['query'] = $this->Kuitansi_model->read_spm($config['per_page'], $id, $keyword)->result_array();

   		// echo "<pre>";
   		// print_r ($this->data['query']);
   		// die();

			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'proses'=>5, 'substr(unitsukpa,1,2)'=>$this->session->userdata('kode_unit')), 'kepeg_tr_spmls')->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'proses'=>5, 'substr(unitsukpa,1,2)'=>$this->session->userdata('kode_unit')), 'kepeg_tr_spmls')->num_rows();

   	}elseif ($jenis == 'TUP_PENGEMBALIAN') {
   		$total_data = $this->Kuitansi_model->read_kuitansi_tup_pengembalian(null, null, $keyword, $kode_unit);
			$total = $total_data->num_rows();

   		$this->data['tab10'] = true;

   		$query = $this->data['query'] = $this->Kuitansi_model->read_kuitansi_pengembalian($config['per_page'], $id, $keyword, $kode_unit,'TP')->result_array();
			$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm_pengembalian($config['per_page'], $id, null, $kode_unit,'TP')->result_array();

			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'jenis' => 'TP','substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi_pengembalian')->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'jenis' => 'TP','substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi_pengembalian')->num_rows();
			$this->data['jenis_isi'] = "TUP ISI";
	  
   	}elseif ($jenis == 'GUP_PENGEMBALIAN') {
   		$total_data = $this->Kuitansi_model->read_kuitansi_pengembalian(null, null, $keyword, $kode_unit, 'GP');
			$total = $total_data->num_rows();

   		$query = $this->data['query'] = $this->Kuitansi_model->read_kuitansi_pengembalian($config['per_page'], $id, $keyword, $kode_unit,'GP')->result_array();
			$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm_pengembalian($config['per_page'], $id, null, $kode_unit,'GP')->result_array();
			$this->data['jenis'] = 'GUP_PENGEMBALIAN';

			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'jenis' => 'GP','substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi_pengembalian')->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'jenis' => 'GP','substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi_pengembalian')->num_rows();
  
   	}elseif ($jenis == 'KS') {
   		$total_data = $this->Kuitansi_model->read_ks(null, null, $keyword, $kode_unit);
			$total = $total_data->num_rows();

  			$query = $this->data['query'] = $this->Kuitansi_model->read_ks($config['per_page'], $id, $keyword, $kode_unit)->result_array();

			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_ks('SPM-FINAL-KBUU', 0)->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_ks('SPM-FINAL-KBUU', 1)->num_rows();

   	}

   	foreach ($query as $key=>$parse) {

   		$id_spmls = (isset($parse['id_spmls']) ? $parse['id_spmls'] : null);
      // $tanggal = (isset($parse['tgl_kuitansi']) ? $parse['tgl_kuitansi'] : $parse['tanggal']);

      if (isset($parse['debet'])) {
        $jumlah = $parse['debet'];
      } else {
        $jumlah = $this->Kuitansi_model->get_kuitansi_jumlah($parse['id_kuitansi']);
      }
      

   		if ($jenis == 'EM'|| $jenis == 'UP'|| $jenis == 'PUP'|| $jenis == 'GUP' || $jenis == 'TUP' || $jenis == 'KS' || $jenis == 'TUP_PENGEMBALIAN' || $jenis == 'GUP_PENGEMBALIAN'){
   			$this->data['query'][$key]['pajak'] = null;

   		} elseif ($jenis == 'NK') {
   			$parsed = array();
   			$parse['id_kuitansi'] = $id_spmls;
   			$parse['str_nomor_trx_spm'] = $parse['nomor'];
   			$parse['str_nomor_trx'] = null;
   			$parse['jenis'] = 'lspg';

   			$pajak = $parse['pajak'];
   			unset($this->data['query'][$key]['pajak']);
   			if ($pajak == 0) {
   				unset($this->data['query'][$key]['pajak']);
   				$this->data['query'][$key]['pajak'] = null;
   			}else {
   				$detail = $this->db->get_where('akuntansi_pajak',array('jenis_pajak' => 'PPh_Ps_21'));
   				$parsed[] = $detail->row()->nama_akun." (Rp. ".number_format($pajak,2,',','.').')';
   			}
   			$this->data['query'][$key]['pajak'] = $parsed;	
   		}else{
   			$parsed = $this->Kuitansi_model->get_detail_pajak($parse['no_bukti'], $parse['jenis']);
   			$this->data['query'][$key]['pajak'] = $parsed;
   		}
      $this->data['query'][$key]['jumlah'] = $jumlah;
      $this->data['query'][$key]['tanggal'] = $this->Spm_model->get_tanggal_spm($parse['str_nomor_trx_spm'],$jenis);
   		$this->data['query'][$key]['url_bukti'] = $this->get_url($parse['id_kuitansi'], $jenis, $parse['str_nomor_trx_spm'], $parse['str_nomor_trx'], $id_spmls, $parse['tahun'], $kode_unit);
   		$this->data['query'][$key]['url_jurnal'] = site_url('akuntansi/jurnal_rsa/input_jurnal/'.$parse['id_kuitansi'].'/'.$parse['jenis']);
   	}
   	// echo "<pre>";
   	// print_r ($this->data['query']);
   		// die();

	   $total = $this->data['kuitansi_non_jadi'];
	   
	   $last_page = 1;
	   $perpage = $config['per_page'];
	   $current_page = (int)$current_page;
	   while ($last_page * $perpage < $total) {
		   $last_page++;
	   }
	   if ($current_page == 1){
		    $next = $current_page + 1;
			$next_page = site_url('akuntansi/kuitansi/lists/'.$jenis)."?page=$next";
			$prev_page = null;
	   }elseif ($current_page == $last_page) {
		   $prev = $current_page - 1;
		   $prev_page = site_url('akuntansi/kuitansi/lists/'.$jenis)."?page=$prev";
		   $next_page = null;
	   }else{
			$next = $current_page + 1;
			$next_page = site_url('akuntansi/kuitansi/lists/'.$jenis)."?page=$next";
			$prev = $current_page - 1;
		   	$prev_page = site_url('akuntansi/kuitansi/lists/'.$jenis)."?page=$prev";
	   }

	   
	   $this->data["total"] = $total;
	   $this->data["per_page"] = $perpage;
	   $this->data["current_page"] = $current_page;
	   $this->data["last_page"] = $last_page;
	   $this->data["next_page_url"] =  $next_page;
	   $this->data["prev_page_url"] = $prev_page;
	   $this->data["from"] = ($perpage * ($current_page-1)) + 1;
	   $this->data["to"] = $current_page * $perpage;

		foreach ($query as $key=>$parse) {
			$this->data['query'][$key]['urutan'] = $this->data["from"] + $key;
		}

		$exported_data = $this->data;
		unset($exported_data['jumlah_notifikasi']);
		unset($exported_data['list_menu']);

    // echo "<pre>";
    // print_r($this->data);


		echo json_encode($exported_data,JSON_PRETTY_PRINT);

		// $temp_data['content'] = $this->load->view('akuntansi/kuitansi_list',$this->data,true);
		// $this->load->view('akuntansi/content_template',$temp_data,false);
   }

	public function index($id = 0){
		$this->data['tab1'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit,'GP');
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();
		$this->data['jenis_isi'] = "GP";

		// $this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit,'GP');
		// $this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit,'GP');
		// function read_kuitansi_gup($limit = null, $start = null, $keyword = null, $kode_unit = null, $jenis = null)
		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_gup($config['per_page'], $id, $keyword, $kode_unit,'GUP');
		$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_gup($config['per_page'], $id, $keyword, $kode_unit,'GUP',true);
		// $this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit,'GP');

		// $this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0,'jenis'=>'GP', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		// $this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1,'jenis'=>'GP', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total_gup('GUP',$this->session->userdata('kode_unit'),0)->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total_gup('GUP',$this->session->userdata('kode_unit'),1)->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_tup_nihil($id = 0){
		$this->data['tab8'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit,'TP');
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_tup_nihil');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit,'TP');
		$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit,'TP');

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0,'jenis'=>'TP', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1,'jenis'=>'TP', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['jenis_isi'] = "TUP_NIHIL";
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_lnk($id = 0){
		$this->data['tab12'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit,'LN');
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_lnk');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit,'LN');
		$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit,'LN');

		// $this->data['query'] = array();
		// $this->data['query_spm'] = array();

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0,'jenis'=>'LN', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1,'jenis'=>'LN', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['jenis_isi'] = "LN";
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_lk($id = 0){
		$this->data['tab11'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit,'LK');
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_lk');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit,'LK');
		$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit,'LK');

		// $this->data['query'] = array();
		// $this->data['query_spm'] = array();

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0,'jenis'=>'LK', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1,'jenis'=>'LK', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['jenis_isi'] = "LK";
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_tup_pengembalian($id = 0){
		$this->data['tab10'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_tup_pengembalian(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_tup_pengembalian');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_pengembalian($config['per_page'], $id, $keyword, $kode_unit,'TP');
		$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm_pengembalian($config['per_page'], $id, null, $kode_unit,'TP');

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'jenis' => 'TP','substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi_pengembalian')->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'jenis' => 'TP','substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi_pengembalian')->num_rows();
		$this->data['jenis_isi'] = "TUP ISI";
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_tup_pengembalian_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_gup_pengembalian($id = 0){
		$this->data['tab10'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_pengembalian(null, null, $keyword, $kode_unit, 'GP');
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_tup_pengembalian');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_pengembalian($config['per_page'], $id, $keyword, $kode_unit, 'GP');
		$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm_pengembalian($config['per_page'], $id, null, $kode_unit, 'GP');

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi_pengembalian')->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi_pengembalian')->num_rows();
		$this->data['jenis_isi'] = "GUP ISI";
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_pengembalian_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_gup($id = 0){
		$this->data['tab9'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword_gu'])){
			$keyword = $this->input->post('keyword_gu');
			$this->session->set_userdata('keyword_gu', $keyword);		
		}else{
			if($this->session->userdata('keyword_gu')!=null){
				$keyword = $this->session->userdata('keyword_gu');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_gup(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_gup');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_gup($config['per_page'], $id, $keyword, $kode_unit);

		// print_r($this->data['query']->result_array());die();


		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_gup('SPM-FINAL-KBUU', 0)->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_gup('SPM-FINAL-KBUU', 1)->num_rows();

		$temp_data['content'] = $this->load->view('akuntansi/up_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_misc($jenis,$id = 0){
		$this->data['tab_'.$jenis] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword_'.$jenis])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_gup(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('5')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_misc/'.$jenis);
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();
		// echo "<pre>";
		// print_r($this->data['halaman']);
		// die();
		if ($jenis == 'gup_nihil'){
			$this->data['query'] = $this->Kuitansi_model->read_kuitansi_gup($config['per_page'], $id, $keyword, $kode_unit,'GUP_NIHIL');
			$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_gup($config['per_page'], $id, $keyword, $kode_unit,'GUP_NIHIL',true);
			$this->data['jenis'] = 'GUP_NIHIL';
			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total_gup('GUP_NIHIL',$this->session->userdata('kode_unit'),0)->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total_gup('GUP_NIHIL',$this->session->userdata('kode_unit'),1)->num_rows();
			// echo "<pre/>";
			// print_r($this->data['query']->result());die();
		}elseif ($jenis == 'gup_pengembalian') {
			$this->data['query'] = $this->Kuitansi_model->read_kuitansi_pengembalian($config['per_page'], $id, $keyword, $kode_unit,'GP');
			$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm_pengembalian($config['per_page'], $id, null, $kode_unit,'GP');
			$this->data['jenis'] = 'GUP_PENGEMBALIAN';

			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'jenis' => 'GP','substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi_pengembalian')->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'jenis' => 'GP','substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi_pengembalian')->num_rows();
		}elseif ($jenis == 'em') {
			$this->data['query'] = $this->Kuitansi_model->read_em($config['per_page'], $id, $keyword, $kode_unit);

			$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_em('SPM-FINAL-KBUU', 0)->num_rows();
			$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_em('SPM-FINAL-KBUU', 1)->num_rows();
		}
		
		$temp_data['content'] = $this->load->view('akuntansi/misc_kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function index_nihil($id = 0){
		$this->data['tab7'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_nihil');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function index_up($id = 0){
		$this->data['tab4'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword_up'])){
			$keyword = $this->input->post('keyword_up');
			$this->session->set_userdata('keyword_up', $keyword);		
		}else{
			if($this->session->userdata('keyword_up')!=null){
				$keyword = $this->session->userdata('keyword_up');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_up(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_up');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

//		$this->data['query'] = $this->Kuitansi_model->total_up('SPM-FINAL-KBUU', 0);
		$this->data['query'] = $this->Kuitansi_model->read_up($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_up('SPM-FINAL-KBUU', 0)->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_up('SPM-FINAL-KBUU', 1)->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/up_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function index_pup($id = 0){
		$this->data['tab6'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_pup(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_pup');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_pup($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_pup('SPM-FINAL-KBUU', 0)->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_pup('SPM-FINAL-KBUU', 1)->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/up_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function index_ks($id = 0){
		$this->data['tab_ks'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_ks(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_ks');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_ks($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_ks('SPM-FINAL-KBUU', 0)->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_ks('SPM-FINAL-KBUU', 1)->num_rows();

		// $this->data['kuitansi_non_jadi'] = null;
		// $this->data['kuitansi_jadi'] = null;

		// echo "<pre>";
		// print_r($this->data['query']->result_array());
		// die();
		
		$temp_data['content'] = $this->load->view('akuntansi/ks_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_tup($id = 0){
		$this->data['tab5'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_tup(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_tup');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_tup($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_tup('SPM-FINAL-KBUU', 0)->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_tup('SPM-FINAL-KBUU', 1)->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/tup_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_em($id = 0){
		$this->data['tab_em'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_em(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_em');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();
		$this->data['jenis'] = 'EM';

		// $this->data['query'] = $this->Kuitansi_model->read_em($config['per_page'], $id, $keyword, $kode_unit);

		// $this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->total_em('SPM-FINAL-KBUU', 0)->num_rows();
		// $this->data['kuitansi_jadi'] = $this->Kuitansi_model->total_em('SPM-FINAL-KBUU', 1)->num_rows();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi($config['per_page'], $id, $keyword, $kode_unit,'EM');
		$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_spm($config['per_page'], $id, null, $kode_unit,'EM');

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0,'jenis'=>'EM', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1,'jenis'=>'EM', 'cair'=>1,'substr(kode_unit,1,2)'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		// echo "<pre>";
		// print_r($this->data['query']->result_array());die();
		
		$temp_data['content'] = $this->load->view('akuntansi/misc_kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
    
    public function index_tup_nihil_($id = 0){
		$this->data['tab8'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword'])){
			$keyword = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $keyword);		
		}else{
			if($this->session->userdata('keyword')!=null){
				$keyword = $this->session->userdata('keyword');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_tup_nihil(null, null, $keyword, $kode_unit);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_tup_nihil($config['per_page'], $id, $keyword, $kode_unit);

		$this->data['kuitansi_non_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/tup_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_ls($id = 0){
		$this->data['tab2'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword_ls'])){
			$keyword = $this->input->post('keyword_ls');
			$this->session->set_userdata('keyword_ls', $keyword);		
		}else{
			if($this->session->userdata('keyword_ls')!=null){
				$keyword = $this->session->userdata('keyword_ls');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_ls(null, null, $keyword);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_ls');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_ls($config['per_page'], $id, $keyword);

		$this->data['kuitansi_non_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		$this->data['kuitansi_jadi'] = 0;//$this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'cair'=>1,'kode_unit'=>$this->session->userdata('kode_unit')), 'rsa_kuitansi')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/lsphk3_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function index_spm($id = 0){
		$this->data['tab3'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			$kode_unit = null;
		}

		//search
		if(isset($_POST['keyword_spm'])){
			$keyword = $this->input->post('keyword_spm');
			$this->session->set_userdata('keyword_spm', $keyword);		
		}else{
			if($this->session->userdata('keyword_spm')!=null){
				$keyword = $this->session->userdata('keyword_spm');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_spm(null, null, $keyword);
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/index_spm');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_spm($config['per_page'], $id, $keyword);

		$this->data['kuitansi_non_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>0, 'proses'=>5, 'substr(unitsukpa,1,2)'=>$this->session->userdata('kode_unit')), 'kepeg_tr_spmls')->num_rows();
		$this->data['kuitansi_jadi'] = $this->Kuitansi_model->read_total(array('flag_proses_akuntansi'=>1, 'proses'=>5, 'substr(unitsukpa,1,2)'=>$this->session->userdata('kode_unit')), 'kepeg_tr_spmls')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/spm_non_kuitansi_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}	

  public function list_jadi($jenis = 'GP', $id = 0){
    //level unit
    if($this->session->userdata('kode_unit')!=null){
      $kode_unit = $this->session->userdata('kode_unit');
    }else{
      redirect(site_url('akuntansi/kuitansi/pilih_unit'));
      $kode_unit = null;
    }

    //search
    $keyword = '';
    if(isset($_POST['keyword_jadi_'.$jenis])){
      $keyword = $this->input->post('keyword_jadi_'.$jenis);
      $this->session->set_userdata('keyword_jadi_'.$jenis, $keyword);   
    }else{
      if($this->session->userdata('keyword_jadi_'.$jenis)!=null){
        $keyword = $this->session->userdata('keyword_jadi_'.$jenis);
      }else{
        $keyword = '';
      }
    }

    $total_data = $this->Kuitansi_model->read_kuitansi_jadi(null, null, $keyword, $kode_unit, $jenis);
    $total = $total_data->num_rows();
    $this->data['total_a'] = $total_data->num_rows();

    //pagination
    if($this->uri->segment('5')==null){
      $id = 0;
      $this->data['no'] = $id+1;
    }else{
      $id = ($id-1)*20;
      $this->data['no'] = $id+1;
    }

    $config['per_page'] = '20';

    $this->data['query'] = $this->Kuitansi_model->read_kuitansi_jadi($config['per_page'], $id, $keyword, $kode_unit, $jenis);
    $this->data['query'] = $this->data['query']->result_array();
        $this->load->model('akuntansi/Akun_model');
        // echo "<pre>";
        // print_r ($this->data['query']);
        // die();
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
            if ($this->data['query'][$key]['jenis'] == 'LK' or $this->data['query'][$key]['jenis'] == 'LN' ) {
              $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp_ls($this->data['query'][$key]['no_spm']);          
            }
            if ($this->data['query'][$key]['jenis'] == 'EM') {
              $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp_em($this->data['query'][$key]['no_spm']);          
            }
            if ($this->data['query'][$key]['jenis'] == 'KS') {
              $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp($this->data['query'][$key]['no_spm'],'trx_nomor_ks');         
            }
            $this->data['query'][$key] = (object) $this->data['query'][$key];
        }

        $tipe = ($jenis == 'NK' ? '<>pajak' : 'pengeluaran');

        $this->data['kuitansi_ok'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'tipe'=>$tipe, 'jenis'=>$jenis, 'flag'=>2,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif_1'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'tipe'=>'pengeluaran', 'jenis'=>$jenis, 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif_2'] = $this->Kuitansi_model->read_total(array('status'=>'direvisi', 'tipe'=>'pengeluaran', 'jenis'=>$jenis, 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif'] = $this->data['kuitansi_pasif_2'] + $this->data['kuitansi_pasif_1'];
        $this->data['kuitansi_revisi'] = $this->Kuitansi_model->read_total(array('status'=>'revisi', 'tipe'=>$tipe, 'jenis'=>$jenis, 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();

        if($jenis=='GP'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='TUP_NIHIL'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='LK'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='LN'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='EM'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='KS'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }

        $this->data['jenis'] = $jenis;

        unset($this->data['list_menu'], $this->data['jumlah_notifikasi'], $this->data['db2']);     
        echo json_encode($this->data, JSON_PRETTY_PRINT);
  }

	public function jadi($jenis = 'GP', $id = 0){
		$this->data['menu1'] = null;
		$this->data['menu2'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			redirect(site_url('akuntansi/kuitansi/pilih_unit'));
			$kode_unit = null;
		}

		//search
		$keyword = '';
		if(isset($_POST['keyword_jadi_'.$jenis])){
			$keyword = $this->input->post('keyword_jadi_'.$jenis);
			$this->session->set_userdata('keyword_jadi_'.$jenis, $keyword);		
		}else{
			if($this->session->userdata('keyword_jadi_'.$jenis)!=null){
				$keyword = $this->session->userdata('keyword_jadi_'.$jenis);
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_jadi(null, null, $keyword, $kode_unit, $jenis);
		$total = $total_data->num_rows();
		$this->data['total_a'] = $total_data->num_rows();

		//pagination
		if($this->uri->segment('5')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/jadi/'.$jenis);
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		if ($jenis == 'invalid') {
        	$this->data['query'] = $this->Jurnal_rsa_model->get_akun_invalid();
        	$this->data['menu99'] = true;
        	$this->data['menu2'] = null;
        }else{
        	$this->data['query'] = $this->Kuitansi_model->read_kuitansi_jadi($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['query'] = $this->data['query']->result_array();
        }
        // echo "<pre>";
        // print_r ($this->data['query']);
        // die();
		// $this->data['query'] = $this->data['query']->result_array();

        $this->load->model('akuntansi/Akun_model');
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
            if ($this->data['query'][$key]['jenis'] == 'LK' or $this->data['query'][$key]['jenis'] == 'LN' ) {
	            $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp_ls($this->data['query'][$key]['no_spm']);        	
            }
            if ($this->data['query'][$key]['jenis'] == 'EM') {
	            $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp_em($this->data['query'][$key]['no_spm']);        	
            }
            if ($this->data['query'][$key]['jenis'] == 'KS') {
	            $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp($this->data['query'][$key]['no_spm'],'trx_nomor_ks');        	
            }
            $this->data['query'][$key] = (object) $this->data['query'][$key];
        }

        $this->data['kuitansi_ok'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'tipe'=>'pengeluaran', 'jenis'=>$jenis, 'flag'=>2,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif_1'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'tipe'=>'pengeluaran', 'jenis'=>$jenis, 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif_2'] = $this->Kuitansi_model->read_total(array('status'=>'direvisi', 'tipe'=>'pengeluaran', 'jenis'=>$jenis, 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif'] = $this->data['kuitansi_pasif_2'] + $this->data['kuitansi_pasif_1'];
        $this->data['kuitansi_revisi'] = $this->Kuitansi_model->read_total(array('status'=>'revisi', 'tipe'=>'pengeluaran', 'jenis'=>$jenis, 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();

        if($jenis=='UP'){
        	$this->data['tab1'] = true;
        }else if($jenis=='PUP'){
        	$this->data['tab2'] = true;
        }else if($jenis=='GUP'){
        	$this->data['tab9'] = true;
        }else if($jenis=='GP'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab3'] = true;
        }else if($jenis=='GP_NIHIL'){
        	$this->data['tab4'] = true;
        }else if($jenis=='TUP'){
        	$this->data['tab5'] = true;
        }else if($jenis=='TUP_NIHIL'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab6'] = true;
        }else if($jenis=='TUP_PENGEMBALIAN'){
        	$this->data['tab_tup_pengembalian_jadi'] = true;
        }else if($jenis=='GUP_PENGEMBALIAN'){
        	$this->data['tab_gup_pengembalian_jadi'] = true;
        }else if($jenis=='GUP_NIHIL'){
        	$this->data['tab_gup_nihil_jadi'] = true;
        }else if($jenis=='LK'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab11'] = true;
        }else if($jenis=='LN'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab12'] = true;
        }else if($jenis=='EM'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab_em'] = true;
        }else if($jenis=='KS'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_kuitansi_jadi_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab_ks'] = true;
        }

        $this->data['jenis'] = $jenis;
        if ($jenis == 'invalid') {
        	$temp_data['content'] = $this->load->view('akuntansi/kuitansi_jadi_invalid',$this->data,true);
        }else{
        	$temp_data['content'] = $this->load->view('akuntansi/kuitansi_jadi_list',$this->data,true);
        }
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	// public function get_akun_invalid(){
	// 	$kuitansi_jadi = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE tipe<>'pajak' AND status='proses' AND unit_kerja = '{$this->session->userdata('kode_unit')}'")->result_array();	
	// 	$akun_belanja_invalid =  $this->data['db2']->query("SELECT * FROM `akun_belanja` WHERE `nama_akun` LIKE '[ JANGAN%'")->result_array();
	// 	foreach ($kuitansi_jadi as $key => $value) {
	// 		foreach ($akun_belanja_invalid as $values) {
	// 			if ($value['akun_debet'] == $values['kode_akun']) {
	// 				$arr_invalid[] = $value;
	// 			}
	// 		}
	// 	}	
	// 	echo "<pre>";
	// 	print_r ($arr_invalid);
	// 	die();
	// }

	public function jadi_ls($id = 0){
		$this->data['menu1'] = null;
		$this->data['menu2'] = true;
		$this->data['tab7'] = true;
        //level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			redirect(site_url('akuntansi/kuitansi/pilih_unit'));
			$kode_unit = null;
		}
        
		//search
		if(isset($_POST['keyword_jadi_ls'])){
			$keyword = $this->input->post('keyword_jadi_ls');
			$this->session->set_userdata('keyword_jadi_ls', $keyword);		
		}else{
			if($this->session->userdata('keyword_jadi_ls')!=null){
				$keyword = $this->session->userdata('keyword_jadi_ls');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_jadi(null, null, $keyword, $kode_unit, 'LSPHK3');
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/jadi_ls');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_jadi($config['per_page'], $id, $keyword, $kode_unit, 'LSPHK3');

		$this->data['kuitansi_ok'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'jenis'=>'LSPHK3', 'flag'=>2,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'jenis'=>'LSPHK3', 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_revisi'] = $this->Kuitansi_model->read_total(array('status'=>'revisi', 'jenis'=>'LSPHK3', 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
		
		$temp_data['content'] = $this->load->view('akuntansi/kuitansi_lsphk3_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function jadi_spm($id = 0){
		$this->data['menu1'] = null;
		$this->data['menu2'] = true;
		$this->data['tab8'] = true;
        //level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			redirect(site_url('akuntansi/kuitansi/pilih_unit'));
			$kode_unit = null;
		}
        
		//search
		if(isset($_POST['keyword_spm_jadi'])){
			$keyword = $this->input->post('keyword_spm_jadi');
			$this->session->set_userdata('keyword_spm_jadi', $keyword);		
		}else{
			if($this->session->userdata('keyword_spm_jadi')!=null){
				$keyword = $this->session->userdata('keyword_spm_jadi');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_jadi(null, null, $keyword, $kode_unit, 'NK');
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/jadi_spm');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_jadi($config['per_page'], $id, $keyword, $kode_unit, 'NK');
		$this->data['query'] = $this->data['query']->result_array();
        $this->load->model('akuntansi/Akun_model');
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
           $this->data['query'][$key] = (object) $this->data['query'][$key];
        }

		$this->data['kuitansi_ok'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'tipe<>'=>'pajak', 'jenis'=>'NK', 'flag'=>2,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif_1'] = $this->Kuitansi_model->read_total(array('status'=>'proses', 'tipe'=>'pengeluaran', 'jenis'=>'NK', 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif_2'] = $this->Kuitansi_model->read_total(array('status'=>'direvisi', 'tipe'=>'pengeluaran', 'jenis'=>'NK', 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
        $this->data['kuitansi_pasif'] = $this->data['kuitansi_pasif_2'] + $this->data['kuitansi_pasif_1'];
        $this->data['kuitansi_revisi'] = $this->Kuitansi_model->read_total(array('status'=>'revisi', 'tipe<>'=>'pajak', 'jenis'=>'NK', 'flag'=>1,'unit_kerja'=>$this->session->userdata('kode_unit')), 'akuntansi_kuitansi_jadi')->num_rows();
		
        // echo "<pre>";
        // print_r ($this->data);
        // die();
        /*print_r($this->data['query']);
        die();*/

		$temp_data['content'] = $this->load->view('akuntansi/spm_non_kuitansi_list_jadi',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function reset_search(){
		$this->session->unset_userdata('keyword');
		$this->session->unset_userdata('keyword_up');
		$this->session->unset_userdata('keyword_pup');
		$this->session->unset_userdata('keyword_gu');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_ls(){
		$this->session->unset_userdata('keyword_ls');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_spm(){
		$this->session->unset_userdata('keyword_spm');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_jadi(){
		$this->session->unset_userdata('keyword_jadi');
		$this->session->unset_userdata('keyword_jadi_UP');
		$this->session->unset_userdata('keyword_jadi_PUP');
		$this->session->unset_userdata('keyword_jadi_GP');
		$this->session->unset_userdata('keyword_jadi_GUP');
		$this->session->unset_userdata('keyword_jadi_TUP');
		$this->session->unset_userdata('keyword_jadi_UP_posting');
		$this->session->unset_userdata('keyword_jadi_PUP_posting');
		$this->session->unset_userdata('keyword_jadi_GP_posting');
		$this->session->unset_userdata('keyword_jadi_GUP_posting');
		$this->session->unset_userdata('keyword_jadi_TUP_posting');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_jadi_ls(){
		$this->session->unset_userdata('keyword_jadi_ls');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_search_jadi_spm(){
		$this->session->unset_userdata('keyword_spm_jadi');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function send_service($id_kuitansi_jadi = 0){
		$query = $this->Kuitansi_model->get_kuitansi_jadi($id_kuitansi_jadi);

		echo json_encode($query);
	}

  public function list_posting($jenis = 'GP', $id=0){

    if($this->session->userdata('kode_unit')!=null){
      $kode_unit = $this->session->userdata('kode_unit');
    }else{
      redirect(site_url('akuntansi/kuitansi/pilih_unit'));
      $kode_unit = null;
    }

    //search
    $keyword = '';
    if(isset($_POST['keyword_jadi_'.$jenis.'_posting'])){
      $keyword = $this->input->post('keyword_jadi_'.$jenis.'_posting');
      $this->session->set_userdata('keyword_jadi_'.$jenis.'_posting', $keyword);    
    }else{
      if($this->session->userdata('keyword_jadi_'.$jenis.'_posting')!=null){
        $keyword = $this->session->userdata('keyword_jadi_'.$jenis.'_posting');
      }else{
        $keyword = '';
      }
    }

    $total_data = $this->Kuitansi_model->read_kuitansi_posting(null, null, $keyword, $kode_unit, $jenis);
        
        $this->data['all_query'] = $total_data->result();
        
    $total = $total_data->num_rows();

    $config['per_page'] = '20';

    //pagination
    if($this->uri->segment('5')==null){
      $id = 0;
      $this->data['no'] = $id+1;
    }else{
      $id = ($id-1)*20;
      $this->data['no'] = $id+1;
    }

    if ($jenis == 'NK') {
      $this->data['query'] = $this->Kuitansi_model->read_kuitansi_posting_spm($config['per_page'], $id, $keyword, $kode_unit);
    }else{
    $this->data['query'] = $this->Kuitansi_model->read_kuitansi_posting($config['per_page'], $id, $keyword, $kode_unit, $jenis);
    }

    $this->data['query'] = $this->data['query']->result_array();
        $this->load->model('akuntansi/Akun_model');
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
            if ($this->data['query'][$key]['jenis'] == 'LK' or $this->data['query'][$key]['jenis'] == 'LN' ) {
              $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp_ls($this->data['query'][$key]['no_spm']);          
            }
            if ($this->data['query'][$key]['jenis'] == 'EM') {
              $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp_em($this->data['query'][$key]['no_spm']);          
            }
            if ($this->data['query'][$key]['jenis'] == 'KS') {
              $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp($this->data['query'][$key]['no_spm'],'trx_nomor_ks');         
            }
            $this->data['query'][$key] = (object) $this->data['query'][$key];
        }
        
        if($jenis=='GP'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='TUP_NIHIL'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='GUP_NIHIL'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='LK'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='LN'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='EM'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }else if($jenis=='KS'){
          $this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        }

        $this->data['jenis'] = $jenis;

        unset($this->data['list_menu'], $this->data['jumlah_notifikasi'], $this->data['db2']);     
        echo json_encode($this->data, JSON_PRETTY_PRINT);

    }
    
    public function posting($jenis = 'GP', $id=0){
		$this->data['menu3'] = true;
		//level unit
		if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			redirect(site_url('akuntansi/kuitansi/pilih_unit'));
			$kode_unit = null;
		}

		//search
		$keyword = '';
		if(isset($_POST['keyword_jadi_'.$jenis.'_posting'])){
			$keyword = $this->input->post('keyword_jadi_'.$jenis.'_posting');
			$this->session->set_userdata('keyword_jadi_'.$jenis.'_posting', $keyword);		
		}else{
			if($this->session->userdata('keyword_jadi_'.$jenis.'_posting')!=null){
				$keyword = $this->session->userdata('keyword_jadi_'.$jenis.'_posting');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_posting(null, null, $keyword, $kode_unit, $jenis);
        
        $this->data['all_query'] = $total_data->result();
        
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('5')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/posting/'.$jenis);
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_posting($config['per_page'], $id, $keyword, $kode_unit, $jenis);
		$this->data['query'] = $this->data['query']->result_array();
        $this->load->model('akuntansi/Akun_model');
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
            if ($this->data['query'][$key]['jenis'] == 'LK' or $this->data['query'][$key]['jenis'] == 'LN' ) {
	            $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp_ls($this->data['query'][$key]['no_spm']);        	
            }
            if ($this->data['query'][$key]['jenis'] == 'EM') {
	            $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp_em($this->data['query'][$key]['no_spm']);        	
            }
            if ($this->data['query'][$key]['jenis'] == 'KS') {
	            $this->data['query'][$key]['no_spp'] = $this->Kuitansi_model->get_no_spp($this->data['query'][$key]['no_spm'],'trx_nomor_tambah_ks');        	
            }
            $this->data['query'][$key] = (object) $this->data['query'][$key];
        }

        // echo "<pre>";
        // print_r ($this->data['query']);
        // die();
        
        if($jenis=='UP'){
        	$this->data['tab1'] = true;
        }else if($jenis=='PUP'){
        	$this->data['tab2'] = true;
        }else if($jenis=='GUP'){
        	$this->data['tab9'] = true;
        }else if($jenis=='GP'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab3'] = true;
        }else if($jenis=='GP_NIHIL'){
        	$this->data['tab4'] = true;
        }else if($jenis=='TUP'){
        	$this->data['tab5'] = true;
        }else if($jenis=='TUP_NIHIL'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab6'] = true;
        }else if($jenis=='GUP_PENGEMBALIAN'){
        	$this->data['tab_gup_pengembalian'] = true;
        }else if($jenis=='GUP_NIHIL'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab_gup_nihil'] = true;
        }else if($jenis=='TUP_PENGEMBALIAN'){
        	$this->data['tab10'] = true;
        }else if($jenis=='LK'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab11'] = true;
        }else if($jenis=='LN'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab12'] = true;
        }else if($jenis=='EM'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab_em'] = true;
        }else if($jenis=='KS'){
        	$this->data['query_spm'] = $this->Kuitansi_model->read_posting_group_spm($config['per_page'], $id, $keyword, $kode_unit, $jenis);
        	$this->data['tab_ks'] = true;
        }

        $this->data['jenis'] = $jenis;
        
		$temp_data['content'] = $this->load->view('akuntansi/posting_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
    }
    
    public function posting_ls(){
		$this->data['menu3'] = true;
		$this->data['tab2'] = true;
        
        if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			redirect(site_url('akuntansi/kuitansi/pilih_unit'));
			$kode_unit = null;
		}
        
		//search
		if(isset($_POST['keyword_jadi_ls'])){
			$keyword = $this->input->post('keyword_jadi_ls');
			$this->session->set_userdata('keyword_jadi_ls', $keyword);		
		}else{
			if($this->session->userdata('keyword_jadi_ls')!=null){
				$keyword = $this->session->userdata('keyword_jadi_ls');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_posting_ls(null, null, $keyword, $kode_unit);
        $this->data['all_query'] = $total_data->result();

        
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/jadi_ls');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_posting_ls($config['per_page'], $id, $keyword, $kode_unit);
        $this->data['query'] = $this->data['query']->result_array();
        $this->load->model('akuntansi/Akun_model');
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
            $this->data['query'][$key] = (object) $this->data['query'][$key];
        }
		
		$temp_data['content'] = $this->load->view('akuntansi/posting_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
    }
    
    public function posting_spm(){
		$this->data['menu3'] = true;
		$this->data['tab8'] = true;
        
        if($this->session->userdata('kode_unit')!=null){
			$kode_unit = $this->session->userdata('kode_unit');
		}else{
			redirect(site_url('akuntansi/kuitansi/pilih_unit'));
			$kode_unit = null;
		}
        
		//search
		if(isset($_POST['keyword_spm_jadi'])){
			$keyword = $this->input->post('keyword_spm_jadi');
			$this->session->set_userdata('keyword_spm_jadi', $keyword);		
		}else{
			if($this->session->userdata('keyword_spm_jadi')!=null){
				$keyword = $this->session->userdata('keyword_spm_jadi');
			}else{
				$keyword = '';
			}
		}

		$total_data = $this->Kuitansi_model->read_kuitansi_posting_spm(null, null, $keyword, $kode_unit);
        $this->data['all_query'] = $total_data->result();
        
		$total = $total_data->num_rows();
		//pagination
		if($this->uri->segment('4')==null){
			$id = 0;
			$this->data['no'] = $id+1;
		}else{
			$id = $this->uri->segment('4');
			$id = ($id-1)*20;
			$this->data['no'] = $id+1;
		}
		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['base_url'] = site_url('akuntansi/kuitansi/posting_spm');
	 	$config['per_page'] = '20';
	 	$config['use_page_numbers'] = TRUE;
		$config['first_link'] = 'Pertama';
		$config['next_link'] = 'Lanjut';
		$config['prev_link'] = 'Sebelum';
		$config['last_link'] = 'Terakhir';
		$config['full_tag_open'] = "<ul class=\"pagination\">";
		$config['first_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = "<li>";
		$config['prev_tag_open'] = $config['num_tag_open'] = "<li>";
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = "<li>";
		$config['prev_tag_close'] = $config['num_tag_close'] = "</li>";
		$config['full_tag_close'] = "</ul>";

		$this->pagination->initialize($config); 
		$this->data['halaman'] = $this->pagination->create_links();

		$this->data['query'] = $this->Kuitansi_model->read_kuitansi_posting_spm($config['per_page'], $id, $keyword, $kode_unit);
        $this->data['query'] = $this->data['query']->result_array();
        $this->load->model('akuntansi/Akun_model');
        foreach($this->data['query'] as $key=>$value){
            $this->data['query'][$key]['nama_akun_debet'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet']);
            $this->data['query'][$key]['nama_akun_debet_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_debet_akrual']);
            $this->data['query'][$key]['nama_akun_kredit'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit']);
            $this->data['query'][$key]['nama_akun_kredit_akrual'] = $this->Akun_model->get_nama_akun($this->data['query'][$key]['akun_kredit_akrual']);
            $this->data['query'][$key] = (object) $this->data['query'][$key];
        }

        // echo "<pre>";
        // print_r ($this->data['query']);
        // die();
		
		$temp_data['content'] = $this->load->view('akuntansi/posting_nk_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
    }

    /*=================================== MONITORING =========================================*/
    /*=================================== MONITORING =========================================*/
    /*=================================== MONITORING =========================================*/

    public function monitor($print = false){
    	$this->db2 = $this->load->database('rba', true);
    	if($this->session->userdata('kode_unit')!=null){
    		$filter = 'WHERE kode_unit="'.$this->session->userdata('kode_unit').'"';
    	}else{
    		$filter = "WHERE kode_unit != '99'";
    	}
    	$this->data['query_unit'] = $this->db2->query("SELECT * FROM unit $filter ORDER BY nama_unit ASC");

    	if($this->input->post('daterange')!=null){
	    	$daterange = $this->input->post('daterange');
	        $date_t = explode(' - ', $daterange);
	        $periode_awal = strtodate($date_t[0]);
	        $periode_akhir = strtodate($date_t[1]);
	        $this->data['periode'] = $daterange;
	    }else{
	    	$periode_awal = null;
	        $periode_akhir = null;
	        $this->data['periode'] = 'Semua Periode';
	    }

    	$i=0;
    	foreach($this->data['query_unit']->result() as $result){
    		$this->data['total_kuitansi'][$i] = $this->get_total_kuitansi($result->kode_unit, $periode_awal, $periode_akhir);
    		$this->data['non_verif'][$i] = $this->get_total_data($result->kode_unit, 'non_verif', $periode_awal, $periode_akhir);
    		$this->data['setuju'][$i] = $this->get_total_data($result->kode_unit, 'setuju', $periode_awal, $periode_akhir);
    		$this->data['revisi'][$i] = $this->get_total_data($result->kode_unit, 'revisi', $periode_awal, $periode_akhir);
    		$this->data['posting'][$i] = $this->get_total_data($result->kode_unit, 'posting', $periode_awal, $periode_akhir);
    		$this->data['direvisi'][$i] = $this->get_total_data($result->kode_unit, 'direvisi', $periode_awal, $periode_akhir);
    		$i++;
    	}

    	unset($this->data['menu1']);
    	$this->data['menu_monitor'] = true;
        /*$this->data['tmp'] = $this->db->query("SELECT unit_kerja, COUNT(*) as jumlah FROM akuntansi_kuitansi_jadi WHERE flag=1 AND (status='direvisi' OR status='proses') GROUP BY unit_kerja ORDER BY jumlah ASC");
        foreach($this->data['tmp']->result_array() as $token){
            $this->data['jumlah_verifikasi'][$token['unit_kerja']] = $token['jumlah'];
        }
        $this->data['tmp'] = $this->db->query("SELECT unit_kerja, COUNT(*) as jumlah FROM akuntansi_kuitansi_jadi WHERE flag=2 AND (status='proses') GROUP BY unit_kerja ORDER BY jumlah ASC");
        foreach($this->data['tmp']->result_array() as $token){
            $this->data['jumlah_posting'][$token['unit_kerja']] = $token['jumlah'];
        }*/

        if($print==true){
        	$this->load->view('akuntansi/monitor_print',$this->data,false);
        }else{
    		$temp_data['content'] = $this->load->view('akuntansi/monitor',$this->data,true);
			$this->load->view('akuntansi/content_template',$temp_data,false);
		}
    }

    function get_total_data($kode_unit, $jenis, $periode_awal, $periode_akhir){
		if($jenis=='setuju'){
			$cond = array('unit_kerja'=>$kode_unit, 'status'=>'proses', 'flag'=>2);
		}else if($jenis=='revisi'){
			$cond = array('unit_kerja'=>$kode_unit, 'status'=>'revisi', 'flag'=>1);
		}else if($jenis=='posting'){
			$cond = array('unit_kerja'=>$kode_unit, 'status'=>'posted');
		}else if($jenis=='non_verif'){
			$cond = array('unit_kerja'=>$kode_unit, 'status'=>'proses', 'flag'=>1);
		}else if($jenis=='direvisi'){
			$cond = array('unit_kerja'=>$kode_unit, 'status'=>'direvisi', 'flag'=>1);
		}
		$this->db->where($cond);
		if($periode_awal!=null AND $periode_akhir!=null){
    		$this->db->where("(tanggal BETWEEN '$periode_awal' AND '$periode_akhir')");
    	}
    	$this->db->where("tipe <> 'pajak' AND tipe <> 'pengembalian'");
		$query = $this->db->get('akuntansi_kuitansi_jadi');
		$q = $query->num_rows();
		return $q;
	}

	function get_total_kuitansi($kode_unit, $periode_awal, $periode_akhir){
		if($periode_awal!=null AND $periode_akhir!=null){
    		$filter_periode = "(tgl_kuitansi BETWEEN '$periode_awal' AND '$periode_akhir')";
    	}
		
		//gu
		$gu = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND posisi='SPM-FINAL-KBUU' AND untuk_bayar != 'GUP NIHIL' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx 
			AND substr(trx_gup.kode_unit_subunit,1,2)='".$kode_unit."'");
		$gu = $gu->num_rows();

		// echo "SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_gup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND kredit=0 
		// 	AND substr(trx_gup.kode_unit_subunit,1,2)='".$kode_unit."'";die();

		//up
		$up = $this->db->query("SELECT * FROM trx_spm_up_data, trx_up, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_up_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx 
			AND substr(trx_up.kode_unit_subunit,1,2)='".$kode_unit."'");
		$up = $up->num_rows();

		//gup
		$gup = $this->db->query("SELECT * FROM rsa_kuitansi WHERE cair=1 AND flag_proses_akuntansi=0 AND
			substr(kode_unit,1,2)='".$kode_unit."' ORDER BY str_nomor_trx_spm ASC, no_bukti ASC");
		$gup = $gup->num_rows();

		//gup
		$tup_pengembalian = $this->db->query("SELECT * FROM rsa_kuitansi_pengembalian WHERE cair=1 AND flag_proses_akuntansi=0 AND
			substr(kode_unit,1,2)='".$kode_unit."' ORDER BY str_nomor_trx_spm ASC, no_bukti ASC");
		$tup_pengembalian = $tup_pengembalian->num_rows();

		//pup
		$pup = $this->db->query("SELECT * FROM trx_spm_pup_data, trx_pup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_pup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx 
			AND substr(trx_pup.kode_unit_subunit,1,2)='".$kode_unit."'");
		$pup = $pup->num_rows();

		//tup
		$tup = $this->db->query("SELECT * FROM trx_spm_tup_data, trx_tup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_tup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx
			AND substr(trx_tup.kode_unit_subunit,1,2)='".$kode_unit."'");
		$tup = $tup->num_rows();


		//tup nihil
		$tup = $this->db->query("SELECT * FROM trx_spm_tup_data, trx_tup, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_tup_spm AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx
			AND substr(trx_tup.kode_unit_subunit,1,2)='".$kode_unit."'");
		$tup = $tup->num_rows();

		//ls3
		// $ls3 = $this->db->query("SELECT * FROM trx_spm_lsphk3_data, trx_lsphk3, (select id_kuitansi, kode_akun, uraian, no_bukti, cair from rsa_kuitansi_lsphk3) as  rsa_kuitansi_lsphk3 WHERE id_trx_spm_lsphk3_data = id_trx_nomor_lsphk3 AND posisi='SPM-FINAL-KBUU' AND trx_lsphk3.id_kuitansi = rsa_kuitansi_lsphk3.id_kuitansi AND trx_spm_lsphk3_data.flag_proses_akuntansi=0 AND rsa_kuitansi_lsphk3.cair = 1
		// 	AND substr(trx_lsphk3.kode_unit_subunit,1,2)='".$kode_unit."'");
		// $ls3 = $ls3->num_rows();
		$ls3 = 0;

		//lspg
		$lspg = $this->db->query("SELECT * FROM kepeg_tr_spmls S, kepeg_tr_sppls P WHERE S.id_tr_sppls=P.id_sppls AND S.flag_proses_akuntansi=0 AND S.proses=5 AND P.unitsukpa=".$kode_unit."");
		$lspg = $lspg->num_rows();

		// echo $up.'-'.$gup.'-'.$gu.'-'.$pup.'-'.$tup.'-'.$ls3.'-'.$lspg.'-'.$tup_pengembalian;die();

		return $up+$gup+$gu+$pup+$tup+$ls3+$lspg+$tup_pengembalian;


	}
    
    /****************** RUPIAH MURNI ************************/
    
    // Redirect ke memorial
    
    /****************** RUPIAH MURNI ************************/


    public function isi_kode_user(){
    	$query = $this->db->query("SELECT K.id_kuitansi_jadi,K.no_bukti,K.no_spm,U.kode_user FROM akuntansi_user U, akuntansi_kuitansi_jadi K WHERE K.unit_kerja=U.kode_unit AND U.username LIKE '%operator%' AND K.kode_user='' AND K.tipe='pajak' AND K.no_spm IS NULL");
    	foreach($query->result() as $result){
    		$this->db->query("UPDATE akuntansi_kuitansi_jadi SET kode_user='".$result->kode_user."' WHERE id_kuitansi_jadi=".$result->id_kuitansi_jadi."");
    		//echo $result->id_kuitansi_jadi.' = '.$result->kode_user.'<br/>';
    	}
    }

    public function isi_kode_user_non_rm(){
    	$query = $this->db->query("SELECT K.id_kuitansi_jadi,K.no_bukti,K.no_spm,U.kode_user FROM akuntansi_user U, akuntansi_kuitansi_jadi K WHERE K.unit_kerja=U.kode_unit AND U.username LIKE '%verifikator%' AND K.kode_user='' AND K.tipe='pajak' AND K.jenis<>'jurnal_umum'");
    	foreach($query->result() as $result){
    		$this->db->query("UPDATE akuntansi_kuitansi_jadi SET kode_user='".$result->kode_user."' WHERE id_kuitansi_jadi=".$result->id_kuitansi_jadi."");
    		//echo $result->id_kuitansi_jadi.' = '.$result->kode_user.'<br/>';
    	}
    }

    public function get_url($id_kuitansi, $jenis, $trx_spm=null, $trx=null, $id_spmls, $tahun, $kode_unit){
    	switch ($jenis) {
    		case 'TUP_PENGEMBALIAN':
    		$url = site_url('akuntansi/rsa_tup/spm_tup_lihat_99/'.urlencode(base64_encode($trx_spm))).'/'.$kode_unit.'/'.$tahun.'/'.$id_kuitansi;
    		break;
    		case 'LK':
    		$url = site_url('akuntansi/rsa_lsk/spm_lsk_lihat_99/'.urlencode(base64_encode($trx))).'/'.$kode_unit.'/'.$tahun.'/'.$id_kuitansi;
    		break;
    		case 'LN':
    		$url = site_url('akuntansi/rsa_lsnk/spm_lsnk_lihat_99/'.urlencode(base64_encode($trx))).'/'.$kode_unit.'/'.$tahun.'/'.$id_kuitansi;
    		break;
    		case 'TUP':
    		$url = site_url('akuntansi/rsa_tambah_tup/spm_tambah_tup_lihat_99/'.urlencode(base64_encode($trx_spm))).'/'.$kode_unit.'/'.$tahun.'/'.$id_kuitansi;
    		break;
    		case 'NK':
    		$url = site_url('akuntansi/rsa_gup/lspg/'.$id_spmls);
    		break;

    		default:
    		$url = site_url('akuntansi/rsa_gup/jurnal/'.$id_kuitansi.'/?spm='.urlencode($trx_spm));
    		break;
    	}

    	return $url;
    }

}
