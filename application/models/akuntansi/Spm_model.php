<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spm_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->load->model('rsa_gup_model');
        $this->load->model('akuntansi/Akun_model', 'Akun_model');
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
    }
	
	public function get_tanggal_spm($no_spm,$jenis = null)
	{
		if ($jenis != 'NK'){
			$data = $this->rsa_gup_model->get_data_spm($no_spm);
        	return $data->tgl_spm;
		}

		$data = $this->db->get_where('kepeg_tr_spmls',array('nomor' => $no_spm))->row_array();
		if ($data != null) {
			return $data['tanggal'];
		}
	}

	public function get_jenis_spm()
	{
		return array('UP','TUP','GUP','PUP','LSPHK3','TUP_NIHIL','GUP_NIHIL');
	}

	public function get_array_jenis()
	{
		return array(
						'UP' => 'trx_spm_up_data',
						'GUP' => 'trx_spm_gup_data',
						'TUP' => 'trx_spm_tambah_tup_data',
						'PUP' => 'trx_spm_tambah_up_data',
						'TUP_NIHIL' => 'trx_spm_tup_data',
						'LSPHK3' => 'trx_lsphk3_data',
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
            	->where('nomor_trx_spm',$nomor_trx_spm)
            	->from($tabel_data)
            ;

            $inti = $this->db->get()->row_array();

            $unit = $this->db2->get_where('unit',array('kode_unit' => $inti['kode_unit_subunit']))->row_array()['nama_unit'];

            $inti['id_kuitansi'] = $nomor_trx_spm;
            $inti['unit_kerja'] = $unit;
            $inti['no_bukti'] = null;
            $inti['kode_usulan_belanja'] = null;

            $inti['uraian'] = $inti['untuk_bayar'] . " " . $unit;

            $inti['str_nomor_trx_spm'] = $inti['str_nomor_trx'];

          	$inti['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal(date('Y-m-d', strtotime($inti['tgl_spm'])));
          	$inti['tanggal_bukti'] = $inti['tanggal'];

          	$inti['jenis'] = $jenis;

          	$inti['pajak'] = null;


          	$debet = $this->db->get_where($tabel_debet,array('no_spm' => $inti['str_nomor_trx']))->row_array();
          	$kredit = $this->db->get_where($tabel_kredit,array('no_spm' => $inti['str_nomor_trx']))->row_array();

          	$inti['akun_debet'] = $debet['kd_akun_kas'];
          	$inti['jumlah_debet'] = $debet['debet'];
          	$inti['akun_debet_kas'] = $inti['akun_debet'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_debet']);

          	$inti['akun_kredit'] = $kredit['kd_akun_kas'];
          	$inti['jumlah_kredit'] = $kredit['kredit'];
          	$inti['kas_akun_kredit'] = $inti['akun_kredit'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_kredit']);

          	return $inti;
            
        }
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
            	->where('nomor_trx_spm',$nomor_trx_spm)
            	->from($tabel_data)
            ;

            $inti = $this->db->get()->row_array();

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

          	$inti['akun_debet'] = $debet['kd_akun_kas'];
          	$inti['jumlah_debet'] = $debet['debet'];
          	$inti['akun_debet_kas'] = $inti['akun_debet'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_debet']);

          	$inti['akun_kredit'] = $kredit['kd_akun_kas'];
          	$inti['jumlah_kredit'] = $kredit['kredit'];
          	$inti['kas_akun_kredit'] = $inti['akun_kredit'] ." - ". $this->Akun_model->get_nama_akun($inti['akun_kredit']);

          	$field_tujuan = $this->db->list_fields('akuntansi_kuitansi_jadi');

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