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
    if ($jenis == 'TP' or $jenis == 'TUP_NIHIL') {
      $data = $this->db->get_where('trx_spm_tup_data',array('str_nomor_trx' => $no_spm))->row_array();
      return $data['tgl_spm'];
    }

    if ($jenis == 'LN'){
      $data = $this->db->get_where('trx_spm_lsnk_data',array('str_nomor_trx' => $no_spm))->row_array();
      return $data['tgl_spm'];
    }

    if ($jenis == 'LK'){
      $data = $this->db->get_where('trx_spm_lsk_data',array('str_nomor_trx' => $no_spm))->row_array();
      // print_r($data);die();
      // die($data);
      return $data['tgl_spm'];
    }

    if ($jenis == 'TUP_PENGEMBALIAN') {
      $data = $this->db->get_where('trx_spm_tup_data',array('str_nomor_trx' => $no_spm))->row_array();
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

	public function get_jenis_spm() // yang lewat kas undip & kas bendahara
	{
		return array('UP','TUP','GUP','PUP','LSPHK3','TUP_NIHIL','GUP_NIHIL'); 
	}

	public function get_array_jenis() // yang lewat kas undip & kas bendahara
	{
		return array(
						'UP' => 'trx_spm_up_data',
						'GUP' => 'trx_spm_gup_data',
						'TUP' => 'trx_spm_tambah_tup_data',
						'PUP' => 'trx_spm_tambah_up_data',
            'TUP_NIHIL' => 'rsa_kuitansi',
            // 'LK' => 'rsa_kuitansi',
						// 'LN' => 'rsa_kuitansi',
						'LSPHK3' => 'trx_spm_lsphk3_data',
		);
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

            if ($jenis == 'GUP') {
              $inti['jumlah_debet'] = $inti['jumlah_kredit'];
            }

          	return $inti;
            
        }
	}

	public function generate_no_bukti($spm,$jenis)
	{
		$temp = $spm;

		$no_bukti = $jenis ."-". substr($temp,6,3) . substr($temp,0,5);
		
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

            if ($jenis == 'GUP') {
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


}