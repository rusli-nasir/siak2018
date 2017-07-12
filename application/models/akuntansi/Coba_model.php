<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coba_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        // $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model',true);
        $this->load->model('akuntansi/Posting_model', 'Posting_model');
        $this->load->database('default', TRUE);
        $this->db_laporan = $this->load->database('laporan',TRUE);
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
    }
	
	public function fixing_nk()
	{
		$this->db->join('kepeg_tr_spmls','akuntansi_kuitansi_jadi.no_spm = kepeg_tr_spmls.nomor');
		// $this->db->where('akuntansi_kuitansi_jadi.no_bukti = kepeg_tr_spmls.no_bukti');
		$this->db->where('akuntansi_kuitansi_jadi.jumlah_debet != kepeg_tr_spmls.total_sumberdana');
		$this->db->where("tipe <> 'pajak'");
		$this->db->where("jenis = 'nk'");
		$this->db->from('akuntansi_kuitansi_jadi');
		$this->db->select('akuntansi_kuitansi_jadi.id_kuitansi_jadi,akuntansi_kuitansi_jadi.jumlah_debet,akuntansi_kuitansi_jadi.flag,akuntansi_kuitansi_jadi.status,akuntansi_kuitansi_jadi.jumlah_kredit,kepeg_tr_spmls.total_sumberdana,kepeg_tr_spmls.jumlah_bayar');

		// die($this->db->get_compiled_select());

		$query = $this->db->get()->result_array();

		print_r($query);
		die();

		$updater = array();
		$array_updater = array();
		foreach ($query as $entry) {
			$updater['jumlah_debet'] = $entry['total_sumberdana'];
			$updater['jumlah_kredit'] = $entry['total_sumberdana'];
			$this->db->where('id_kuitansi_jadi',$entry['id_kuitansi_jadi']);
			$this->db->update('akuntansi_kuitansi_jadi',$updater);
			$this->db_laporan->where('id_kuitansi_jadi',$entry['id_kuitansi_jadi']);
			$this->db_laporan->update('akuntansi_kuitansi_jadi',$updater);
		}

		
	}

	public function fixing_gp()
	{
		// $this->load->model('Kuitansi_model', 'Kuitansi_model',true);
		$this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');

		$query = "SELECT k.id_kuitansi_jadi,k.no_bukti,k.jenis,k.tipe,k.id_pajak, p.jenis_pajak,k.status, sum(rupiah_pajak) as jumlah_pajak, count(Distinct 'jenis_pajak') as macam_pajak FROM akuntansi_kuitansi_jadi as k, rsa_kuitansi_detail_pajak as p WHERE k.no_bukti = p.no_bukti AND k.jenis='GP' AND p.jenis_pajak in ('Lainnya','PPh_Ps_4(2)') AND rupiah_pajak != 0 AND k.tipe!='pajak' GROUP BY p.jenis_pajak,p.no_bukti";
		$query = $this->db->query($query)->result_array();
		

		print_r($query);die();


		$array_update = array();
		foreach ($query as $entry_pajak) {
			// $array_update[$entry_pajak['id_kuitansi_jadi']]
			$no_bukti = $entry_pajak['no_bukti'];
			// print_r($entry_pajak);die();
			// echo "SELECT no_bukti,count(distinct 'jenis_pajak') as jenis FROM rsa_kuitansi_detail_pajak WHERE no_bukti='$no_bukti' AND jenis_pajak in ('Lainnya','PPh_Ps_4(2)')";die();
			// $query2 = "SELECT *,count(distinct 'jenis_pajak') as jenis FROM rsa_kuitansi_detail_pajak WHERE no_bukti='$no_bukti' AND jenis_pajak in ('Lainnya','PPh_Ps_4(2)','PPh_Ps_23')";
			// $query2 = "SELECT *,COUNT(distinct jenis_pajak) as macam FROM `rsa_kuitansi_detail_pajak` WHERE `no_bukti` LIKE '$no_bukti' AND jenis_pajak in ('Lainnya','PPh_Ps_4(2)')";

			if ($entry_pajak['id_pajak'] != 0) {
				$entry['no_bukti'] = $entry_pajak['no_bukti'];
				$entry['id_kuitansi_jadi'] = $entry_pajak['id_pajak'];
				$entry['akun'] = 411128;
				$entry['jumlah'] = $entry_pajak['jumlah_pajak'];
				$entry['jenis_pajak'] = 'PPh_final';
				$entry['jenis'] = 'pajak';
				$this->db->insert('akuntansi_relasi_kuitansi_akun',$entry);
				// print_r($entry);
			} else {
				$entry['no_bukti'] = $entry_pajak['no_bukti'];
				$entry['akun'] = 411128;
				$entry['jumlah'] = $entry_pajak['jumlah_pajak'];
				$entry['jenis_pajak'] = 'PPh_final';
				$entry['jenis'] = 'pajak';

				$kuitansi = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' => $entry_pajak['id_kuitansi_jadi']))->row_array();
		    	$kuitansi['tipe'] = 'pajak';

	    		$kuitansi['akun_debet'] = 0;
	    		$kuitansi['akun_debet_akrual'] = 0;
	    		$kuitansi['jumlah_debet'] = 0;
	    		$kuitansi['akun_kredit'] = 0;
	    		$kuitansi['akun_kredit_akrual'] = 0;
	    		$kuitansi['jumlah_kredit'] = 0;
	            $kuitansi['uraian'] = "Pemungutan dan Penyetoran Pajak " . $kuitansi['uraian'];


	    		$id_kuitansi_awal = $kuitansi['id_kuitansi_jadi'];


	    		unset($kuitansi['id_kuitansi_jadi']);
	            unset($kuitansi['id_pengembalian']);

	    		$this->db->insert('akuntansi_kuitansi_jadi',$kuitansi);	
		        $id_kuitansi = $this->db->insert_id();

		        $entry['id_kuitansi_jadi'] = $id_kuitansi;

		        $this->db->insert('akuntansi_relasi_kuitansi_akun',$entry);

		        $updater['id_pajak'] = $id_kuitansi;

            	$this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_awal);


		    }

		    if ($entry_pajak['id_pajak'] != 0) {
		    	$this->db_laporan->where('id_kuitansi_jadi',$entry_pajak['id_pajak'])->delete('akuntansi_kuitansi_jadi');
		    	$this->db_laporan->where('id_kuitansi_jadi',$entry_pajak['id_pajak'])->delete('akuntansi_relasi_kuitansi_akun');
		    	$q6 = $this->Posting_model->posting_kuitansi_full($entry_pajak['id_pajak']);
		    } else {
				$q6 = $this->Posting_model->posting_kuitansi_full($id_kuitansi);
		    	$this->db_laporan->where('id_kuitansi_jadi',$entry_pajak['id_kuitansi_jadi'])->delete('akuntansi_kuitansi_jadi');
		    	$this->db_laporan->where('id_kuitansi_jadi',$entry_pajak['id_kuitansi_jadi'])->delete('akuntansi_relasi_kuitansi_akun');

		    	$q6 = $this->Posting_model->posting_kuitansi_full($entry_pajak['id_kuitansi_jadi']);
		    }
		    

		    }

			// echo $query2;
			// die();
			// $query2 = $this->db->query($query2)->result_array();
			// print_r($entry);
			// die('aa');
		
	}

	
}