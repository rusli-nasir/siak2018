<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spm_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->load->model('rsa_gup_model');
        $this->load->model('akuntansi/Akun_model', 'Akun_model');
        $this->load->model('akuntansi/Pajak_model', 'Pajak_model');
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
    }
	
	public function get_tanggal_spm($no_spm,$jenis = null)
	{
    // die($jenis);
    if ($jenis == 'TP' or $jenis == 'TUP_NIHIL' or $jenis == 'TUP') {
      $data = $this->db->get_where('trx_spm_tup_nihil_data',array('str_nomor_trx' => $no_spm))->row_array();
      return $data['tgl_spm'];
    }

    if ($jenis == 'LN'){
      $data = $this->db->get_where('trx_spm_lsnk_data',array('str_nomor_trx' => $no_spm))->row_array();
      return $data['tgl_spm'];
    }

    if ($jenis == 'EM'){
      $data = $this->db->get_where('trx_spm_em_data',array('str_nomor_trx' => $no_spm))->row_array();
      // print_r($data);die();
      return $data['tgl_spm'];
    }

    if ($jenis == 'LK'){
      $data = $this->db->get_where('trx_spm_lsk_data',array('str_nomor_trx' => $no_spm))->row_array();
      // die($data);
      return $data['tgl_spm'];
    }

    if ($jenis == 'TUP_PENGEMBALIAN') {
      $data = $this->db->get_where('trx_spm_tup_nihil_data',array('str_nomor_trx' => $no_spm))->row_array();
      return $data['tgl_spm'];
    }

    if ($jenis == 'UP') {
      $data = $this->db->get_where('trx_spm_up_data',array('str_nomor_trx' => $no_spm))->row_array();
      return $data['tgl_spm'];
    }

		if ($jenis != 'NK'){
			$data = $this->rsa_gup_model->get_data_spm($no_spm);
        	return $data->tgl_spm;
		}

		$data = $this->db->get_where('kepeg_tr_spmls',array('nomor' => $no_spm))->row_array();
		if ($data != null) {
			return $data['tanggal'];
		}
	}

  public function get_rekap_spm_terjurnal($value='')
  {
    if ($unit = $this->session->userdata('kode_unit')){
        $unit_query = "AND unit_kerja='$unit'";
    }else{
        $unit_query = '';
    }
    $query = "SELECT no_spm as nomor_spm,max(tanggal) as tanggal_spm,max(tanggal_jurnal) as tanggal_jurnal,jumlah_debet as jumlah,jenis FROM akuntansi_kuitansi_jadi WHERE tipe='pengeluaran' $unit_query GROUP BY concat(no_spm,jenis) ORDER BY jenis,min(id_kuitansi)";

    $result = $this->db->query($query)->result_array();

    $temp_data = array();


    foreach ($result as $entry) {
      $temp_data[$entry['jenis']][] = $entry;
    }

    $temp_data['all'] = $result;

    $query = "SELECT distinct jenis as real_jenis FROM akuntansi_kuitansi_jadi WHERE tipe='pengeluaran' $unit_query GROUP BY concat(no_spm,jenis)";

    $temp_index = $this->db->query($query)->result_array();


    $array_index['all'] = array(
                        'real_jenis' => 'all',
                        'jenis' => 'Semua',
                        'jumlah' => count($temp_data['all']),
                  );

    foreach ($temp_index as $each_index) {
      $each_index['jenis'] = $this->konversi_jenis_spm($each_index['real_jenis']);
      $each_index['jumlah'] = count($temp_data[$each_index['real_jenis']]);
      
      // $array_index[$each_index['jenis']] = $each_index;
      $array_index[$each_index['jenis']] = $each_index;
    }



    $data['rekap'] = $temp_data;
    $data['index'] = $array_index;

    // echo "<pre>";
    // print_r($array_index);die();


    return $data;


  }

	public function get_jenis_spm() // yang lewat kas undip & kas bendahara
	{
		return array('UP','TUP','GUP','PUP','TUP_NIHIL','KS'); 
	}

  public function get_jenis_kuitansi($value='')
  {
    return array('GP','GUP_NIHIL','LK','LN','EM');
  }

  public function get_jenis_pengembalian($value='')
  {
    return array('GUP_PENGEMBALIAN','TUP_PENGEMBALIAN');
  }

  public function get_jenis_lspg($value='')
  {
    return array('NK'); 
  }

  public function get_tabel_assoc_spm($value='')
  {
    return array(
          'GP' => 'trx_spm_gup_data',
          'EM' => 'trx_spm_em_data',
          'GUP_NIHIL' => 'trx_spm_gup_data',
          'LK' => 'trx_spm_lsk_data',
          'LN' => 'trx_spm_lsnk_data',
          'TUP_PENGEMBALIAN' => 'trx_spm_tup_nihil_data',
          'TUP_NIHIL' => 'trx_spm_tup_nihil_data',
    );
  }


	public function get_array_jenis() // yang lewat kas undip & kas bendahara
	{
		return array(
						'UP' => 'trx_spm_up_data',
            'GUP' => 'trx_spm_gup_data',
						// 'GUP_NIHIL' => 'trx_spm_gup_data',
						'TUP' => 'trx_spm_tup_data',
            'PUP' => 'trx_spm_pup_data',
						'KS' => 'trx_spm_ks_data',
            'TUP_NIHIL' => 'rsa_kuitansi',
            // 'EM' => 'trx_spm_em_data',
            // 'LK' => 'rsa_kuitansi',
						// 'LN' => 'rsa_kuitansi',
						'LSPHK3' => 'trx_spm_lsphk3_data',
		);
	}


  public function get_array_proses_spm() // Array jenis dan tabel untuk checking proses SPM
  {
    return array (
      'EM' => 'trx_spm_em_data',
      'GUP' => 'trx_spm_gup_data',
      'LSK' => 'trx_spm_lsk_data',
      'LSNK' => 'trx_spm_lsnk_data',
      'KS' => 'trx_spm_ks_data',
      'TUP' => 'trx_spm_tup_data',
      'TUP_NIHIL' => 'trx_spm_tup_nihil_data',
      'PUP' => 'trx_spm_pup_data',
      'UP' => 'trx_spm_up_data',
    );
  }

  public function get_array_case_spm() // array yang di refer dengan id_[jenis]_spm
  {
    return array('KS','EM','LSK','LSNK');
  }

  public function get_array_jenis_spm()
  {
    return array(
            'SPM-UP' => 'trx_spm_up_data',
            'SPM-GUP' => 'trx_spm_gup_data',
            'SPP-GUP' => 'trx_spm_gup_data',
            'SPM-TUP' => 'trx_spm_tup_data',
            'SPM-PUP' => 'trx_spm_pup_data',
            'SPM-TUP-NIHIL' => 'rsa_kuitansi',
            'SPM-LS PGW' => 'rsa_kuitansi',
            'SPM-LSK' => 'rsa_kuitansi',
            'SPM-LS' => 'rsa_kuitansi',
            'SPM-LSNK' => 'rsa_kuitansi',
            'SPM-LS K-3 NONKONTRAK' => 'rsa_kuitansi',
            'SPM-LS PIHAK KE-3' => 'rsa_kuitansi',
    );
  }

  public function konversi_jenis_spm($jenis)
  {
    $tabel_konversi = array(
      'GUP' => 'GU',
      'NK' => 'LSPG',
      'LN' => 'LSNK',
      'LK' => 'LSK',
    );
    if (isset($tabel_konversi[$jenis])){
      return $tabel_konversi[$jenis];
    }else{
      return $jenis;
    }
  } 

  public function get_spm_proses_rsa($mode,$array_params = null)
  {
    $tabel_jenis = $this->get_array_proses_spm();
    $tabel_case_spm = $this->get_array_case_spm();
    $data = array();
    // echo "<pre>";
    if ($mode == 'total'){
      foreach ($tabel_jenis as $jenis_spm => $tabel_sumber) {
        $entry = array(
          'jenis' => $this->konversi_jenis_spm($jenis_spm),
        );
        $tabel_posisi = str_replace('spm_', '', str_replace('_data','',$tabel_sumber));
        $jenis_spm = str_replace('trx_spm_', '', str_replace('_data','',$tabel_sumber));
        $jenis_spm = strtolower($jenis_spm);
        $search_id = "id_trx_nomor_$jenis_spm";
        if (in_array(strtoupper(str_replace('tambah_','',$jenis_spm)), $tabel_case_spm)){
          $search_id .= "_spm";
        }
        $query = "SELECT 
                        count(*) AS jumlah 
                  FROM 
                          $tabel_sumber,
                          (SELECT $search_id,posisi FROM $tabel_posisi WHERE $tabel_posisi.id_trx_$jenis_spm IN (SELECT max(id_trx_$jenis_spm) as id_trx_$jenis_spm FROM $tabel_posisi GROUP BY $search_id)) AS tabel_posisi
                  WHERE 
                          tabel_posisi.$search_id = $tabel_sumber.nomor_trx_spm AND 
                          tabel_posisi.posisi NOT IN ('SPM-DITOLAK-VERIFIKATOR','SPM-DITOLAK-KBUU','SPM-DITOLAK-KPA','SPP-DITOLAK','SPM-FINAL-KBUU')
                  ";

        // echo $query;
        $entry['jumlah'] = $this->db->query($query)->row_array()['jumlah'];
        $entry['real_jenis'] = $jenis_spm;
        $data[] = $entry;
      }
      // die();
    }elseif ($mode == 'each') {
      foreach ($array_params as $params) {
        $jenis_spm = $params;
        $init_jenis = $params;
        $tabel_sumber = $tabel_jenis[$jenis_spm];

        $tabel_posisi = str_replace('spm_', '', str_replace('_data','',$tabel_sumber));
        $jenis_spm = str_replace('trx_spm_', '', str_replace('_data','',$tabel_sumber));
        $jenis_spm = strtolower($jenis_spm);
        $search_id = "id_trx_nomor_$jenis_spm";
        if (in_array(strtoupper(str_replace('tambah_','',$jenis_spm)), $tabel_case_spm)){
          $search_id .= "_spm";
        }
        $query = "SELECT 
                        $tabel_sumber.str_nomor_trx as nomor_spm,
                        $tabel_sumber.jumlah_bayar,
                        $tabel_sumber.untuk_bayar,
                        '$jenis_spm' as real_jenis,
                        '$init_jenis' as jenis,
                        posisi
                  FROM 
                          $tabel_sumber,
                          (SELECT $search_id,posisi FROM $tabel_posisi WHERE $tabel_posisi.id_trx_$jenis_spm IN (SELECT max(id_trx_$jenis_spm) as id_trx_$jenis_spm FROM $tabel_posisi GROUP BY $search_id)) AS tabel_posisi
                  WHERE 
                          tabel_posisi.$search_id = $tabel_sumber.nomor_trx_spm AND 
                          tabel_posisi.posisi NOT IN ('SPM-DITOLAK-VERIFIKATOR','SPM-DITOLAK-KBUU','SPM-DITOLAK-KPA','SPP-DITOLAK','SPM-FINAL-KBUU')
                  ";
        $data[$jenis_spm] = $this->db->query($query)->result_array();
      }
      foreach ($data as $each_data) {
        foreach ($each_data as $entry_data){
          $data['all'][] = $entry_data;
        }
      }
    }
    return $data;
  }


	public function update_spm($nomor_trx_spm,$updater,$jenis)
	{
		$tabel_jenis = $this->get_array_jenis();

		$this->db->where('nomor_trx_spm',$nomor_trx_spm);
        $response = $this->db->update($tabel_jenis[$jenis],$updater);	

        return $response;
	}


	public function get_spm_input($nomor_trx_spm,$jenis)
	{
		$array_jenis = $this->get_jenis_spm();

		$tabel_jenis = $this->get_array_jenis();

        if ($jenis != null and in_array($jenis,$array_jenis)) {
            $tabel_data = $tabel_jenis[$jenis];
            $tabel_debet = "kas_bendahara";
            $tabel_kredit = "kas_undip";

            if ($jenis == 'KS'){
              $tabel_debet = 'kas_kerjasama';
            }

            $this->db
            	->where('nomor_trx_spm',$nomor_trx_spm)
            	->from($tabel_data)
            ;

            $inti = $this->db->get()->row_array();

            // echo $tabel_data;
            // print_r($inti);die();

            $inti['kode_unit_subunit'] = substr($inti['kode_unit_subunit'],0,2);

            $unit = $this->db2->get_where('unit',array('kode_unit' => $inti['kode_unit_subunit']))->row_array()['nama_unit'];

            $inti['id_kuitansi'] = $nomor_trx_spm;
            $inti['unit_kerja'] = $unit;
            

            $inti['uraian'] = $inti['untuk_bayar'] . " " . $unit;

            $inti['str_nomor_trx_spm'] = $inti['str_nomor_trx'];

            $inti['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal(date('Y-m-d', strtotime($inti['tgl_spm'])));
            $inti['tanggal_bukti'] = $inti['tanggal'];

            $inti['jenis'] = $jenis;

            $inti['pajak'] = null;



          	$debet = $this->db->get_where($tabel_debet,array('no_spm' => $inti['str_nomor_trx']))->row_array();
          	$kredit = $this->db->get_where($tabel_kredit,array('no_spm' => $inti['str_nomor_trx']))->row_array();

            // $inti['akun_debet'] = $debet['kd_akun_kas'];
            // $inti['jumlah_debet'] = $debet['debet'];
            // $inti['akun_debet_kas'] = $inti['akun_debet'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_debet']);

            // $inti['akun_kredit'] = $kredit['kd_akun_kas'];
            // $inti['jumlah_kredit'] = $kredit['kredit'];
            // $inti['kas_akun_kredit'] = $inti['akun_kredit'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_kredit']);

            $sal_univ = $this->Jurnal_rsa_model->get_akun_sal_by_unit('all');
            $sal_unit = $this->Jurnal_rsa_model->get_akun_sal_by_unit($inti['kode_unit_subunit']);

          	$inti['akun_debet'] = $sal_unit['akun_6'];
          	$inti['jumlah_debet'] = $debet['debet'];
          	$inti['akun_debet_kas'] = $sal_unit['akun_6'] ." - ". $sal_unit['nama'];

          	$inti['akun_kredit'] = $sal_univ['akun_6'];
          	$inti['jumlah_kredit'] = $kredit['kredit'];
          	$inti['kas_akun_kredit'] = $sal_univ['akun_6'] ." - ". $sal_univ['nama'];

          	$inti['no_bukti'] = $this->generate_no_bukti($inti['str_nomor_trx'],$jenis);
            $inti['kode_usulan_belanja'] = $this->generate_kode_kegiatan($inti,$jenis);

            if ($jenis == 'KS'){
              $inti['akun_debet'] = $debet['kd_akun_kas'];
              $inti['akun_kredit'] = $kredit['kd_akun_kas'];
              $inti['akun_debet_kas'] = $debet['kd_akun_kas'] .' - '. $this->Akun_model->get_nama_akun($debet['kd_akun_kas']);
              $inti['akun_kredit_kas'] = $kredit['kd_akun_kas'] .' - '. $this->Akun_model->get_nama_akun($kredit['kd_akun_kas']);
            }

          	if ($jenis == 'LSPHK3') {
          		$this->db
          				->where('posisi','SPM-FINAL-KBUU')
          				->where('id_trx_nomor_lsphk3',$nomor_trx_spm)
          		;

          		$id_kuitansi = $this->db->get('trx_lsphk3')->row_array()['id_kuitansi'];

          		$kuitansi = $this->db->get_where('rsa_kuitansi_lsphk3',array('id_kuitansi' => $id_kuitansi))->row_array();

          		$inti['no_bukti'] = $kuitansi['no_bukti'];
          		$inti['kode_usulan_belanja'] = $kuitansi['kode_usulan_belanja'];
          		$inti['akun_debet'] = $kuitansi['kode_akun'];
          		$inti['jumlah_debet'] = $inti['jumlah_bayar'];
          		$inti['akun_debet_kas'] = $inti['akun_debet'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_debet']);

          		$inti['akun_kredit'] = $kredit['kd_akun_kas'];
	          	$inti['jumlah_kredit'] = $inti['jumlah_bayar'];
	          	$inti['kas_akun_kredit'] = $inti['akun_kredit'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_kredit']);
          		// print_r($id_kuitansi);
          		$inti['pajak'] = $this->Pajak_model->get_detail_pajak($kuitansi['no_bukti'],'L3');
          		// print_r($kuitansi);
          		// die();
          	}

            if ($jenis == 'GUP' or $jenis == 'EM') {
              $inti['jumlah_debet'] = $inti['jumlah_kredit'];
            }

          	return $inti;
            
        }
	}

	public function generate_no_bukti($spm,$jenis)
	{
		$temp = $spm;

		$no_bukti = $jenis ."-". substr($temp,5,3) . substr($temp,0,4);
		
		return $no_bukti;
	}

	public function generate_kode_kegiatan($spm,$jenis)
	{
		return null;
		
		$array_sumber = array(
						'UP' => '01',
						'GUP' => '01',
						'TUP' => '01',
						'PUP' => '01',
						'TUP_NIHIL' => '01',
						'LSPHK3' => '01',
		);

		$kode_kegiatan = $spm['kode_unit_subunit'] . '00000000000000'. $array_sumber[$jenis] . $spm['akun_debet'];

		// $no_bukti = $jenis . substr($temp,6,3) . substr($temp,0,5);
		
		return $kode_kegiatan;
	}

	public function get_spm_transfer($nomor_trx_spm,$jenis)
	{
		$array_jenis = $this->get_jenis_spm();

		$tabel_jenis = $this->get_array_jenis();

        if ($jenis != null and in_array($jenis,$array_jenis)) {
            $tabel_data = $tabel_jenis[$jenis];
            $tabel_debet = "kas_bendahara";
            $tabel_kredit = "kas_undip";

            if ($jenis == 'KS'){
              $tabel_debet = 'kas_kerjasama';
            }

            $this->db
            	->where('nomor_trx_spm',$nomor_trx_spm)
            	->from($tabel_data)
            ;

            $inti = $this->db->get()->row_array();

            $inti['kode_unit_subunit'] = substr($inti['kode_unit_subunit'],0,2);

            $unit = $this->db2->get_where('unit',array('kode_unit' => $inti['kode_unit_subunit']))->row_array()['nama_unit'];

            $inti['id_kuitansi'] = $nomor_trx_spm;
            $inti['unit_kerja'] = $inti['kode_unit_subunit'];
            $inti['no_bukti'] = null;
            $inti['kode_usulan_belanja'] = null;

            $inti['uraian'] = $inti['untuk_bayar'] . " " . $unit;

            $inti['no_spm'] = $inti['str_nomor_trx'];

          	$inti['tanggal'] = $inti['tgl_spm'];
          	$inti['tanggal_bukti'] = $inti['tanggal'];

          	$inti['jenis'] = $jenis;

          	$inti['pajak'] = null;


          	$debet = $this->db->get_where($tabel_debet,array('no_spm' => $inti['str_nomor_trx']))->row_array();
          	$kredit = $this->db->get_where($tabel_kredit,array('no_spm' => $inti['str_nomor_trx']))->row_array();

          	// $inti['akun_debet'] = $debet['kd_akun_kas'];
          	// $inti['jumlah_debet'] = $debet['debet'];
          	// $inti['akun_debet_kas'] = $inti['akun_debet'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_debet']);

          	// $inti['akun_kredit'] = $kredit['kd_akun_kas'];
          	// $inti['jumlah_kredit'] = $kredit['kredit'];
          	// $inti['kas_akun_kredit'] = $inti['akun_kredit'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_kredit']);

            $sal_univ = $this->Jurnal_rsa_model->get_akun_sal_by_unit('all');
            $sal_unit = $this->Jurnal_rsa_model->get_akun_sal_by_unit($inti['kode_unit_subunit']);

            $inti['akun_debet'] = $sal_unit['akun_6'];
            $inti['jumlah_debet'] = $debet['debet'];
            $inti['akun_debet_kas'] = $sal_unit['akun_6'] ." - ". $sal_unit['nama'];

            $inti['akun_kredit'] = $sal_univ['akun_6'];
            $inti['jumlah_kredit'] = $kredit['kredit'];
            $inti['kas_akun_kredit'] = $sal_univ['akun_6'] ." - ". $sal_univ['nama'];

            if ($jenis == 'KS'){
              $akun_kerjasama_permintaan = $this->Akun_model->get_akun_kerjasama_permintaan();

              $inti['akun_debet'] = $akun_kerjasama_permintaan['akun_debet']['akun_6'];
              // $inti['akun_debet'] = $debet['kd_akun_kas'];
              $inti['akun_kredit'] = $kredit['kd_akun_kas'];
              $inti['akun_debet_kas'] = $debet['kd_akun_kas'] .' - '. $this->Akun_model->get_nama_akun($debet['kd_akun_kas']);
              $inti['akun_kredit_kas'] = $kredit['kd_akun_kas'] .' - '. $this->Akun_model->get_nama_akun($kredit['kd_akun_kas']);
              // echo "<pre>";
              // print_r($akun_kerjasama_permintaan);die;
              
              // die('aaa');
            }

            if ($jenis == 'EM'){
                $inti['akun_debet'] = $this->Akun_model->get_akun_belanja_bbm()['akun_6'];
                $inti['akun_kredit'] = $this->Akun_model->get_sal_bbm()['akun_6'];
                $inti['akun_debet_kas'] = $this->Akun_model->get_akun_belanja_bbm()['nama'];
                $inti['akun_kredit_kas'] = $this->Akun_model->get_sal_bbm()['nama'];
                $inti['jumlah_debet'] = $inti['jumlah_bayar'];
                $inti['jumlah_kredit'] = $inti['jumlah_bayar'];
                // $inti['unit_kerja'] = $inti['kode_unit'];
                // $inti['akun_debet_akrual_em'] = $this->Akun_model->get_akun_belanja_bbm('akrual');
                // $inti['akun_kredit_akrual_em'] = $this->Akun_model->get_kas_bbm();
            }

          	$field_tujuan = $this->db->list_fields('akuntansi_kuitansi_jadi');

          	if ($jenis == 'LSPHK3') {
          		$this->db
          				->where('posisi','SPM-FINAL-KBUU')
          				->where('id_trx_nomor_lsphk3',$nomor_trx_spm)
          		;

          		$id_kuitansi = $this->db->get('trx_lsphk3')->row_array()['id_kuitansi'];

          		$kuitansi = $this->db->get_where('rsa_kuitansi_lsphk3',array('id_kuitansi' => $id_kuitansi))->row_array();

          		$inti['no_bukti'] = $kuitansi['no_bukti'];
          		$inti['kode_kegiatan'] = $kuitansi['kode_usulan_belanja'];
          		$inti['akun_debet'] = $kuitansi['kode_akun'];
          		$inti['jumlah_debet'] = $inti['jumlah_bayar'];
          		$inti['akun_debet_kas'] = $inti['akun_debet'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_debet']);
              $inti['id_kuitansi'] = $id_kuitansi;

              $sal_univ = $this->Jurnal_rsa_model->get_akun_sal_by_unit('all');

              $inti['akun_kredit'] = $sal_univ['akun_6'];
              $inti['jumlah_kredit'] = $kredit['kredit'];
              $inti['kas_akun_kredit'] = $sal_univ['akun_6'] ." - ". $sal_univ['nama'];

          		// $inti['akun_kredit'] = $kredit['kd_akun_kas'];
	          	// $inti['jumlah_kredit'] = $kredit['kredit'];
	          	// $inti['kas_akun_kredit'] = $inti['akun_kredit'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_kredit']);

          		// print_r($id_kuitansi);
          		// print_r($kuitansi);
          		// die();
          	}

            if ($jenis == 'GUP' or $jenis == 'GUP_NIHIL') {
              $inti['jumlah_debet'] = $inti['jumlah_kredit'];
            }

	    	$field_asal = array_keys($inti);

	    	foreach ($field_asal as $field) {
	    		if (!in_array($field, $field_tujuan)){
	    			unset($inti[$field]);
	    		}
	    	}

          	return $inti;
            
        }
	}

  public function get_kode_kegiatan_spm($spm)
  {
      $this->db->select('kode_usulan_belanja as kode_kegiatan');
      $hasil = $this->db->get_where('rsa_kuitansi',array('str_nomor_trx_spm' => $spm, 'aktif' => 1, 'cair' => 1))->row_array();
      if ($hasil != null){
        return $hasil['kode_kegiatan'];
      }
  }


}