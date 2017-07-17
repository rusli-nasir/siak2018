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
        $this->load->model('akuntansi/Pajak_model', 'Pajak_model');
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

		die($this->db->get_compiled_select());

		$query = $this->db->get()->result_array();

		$updater = array();
		$array_updater = array();
		foreach ($query as $entry) {
			$updater['jumlah_debet'] = $entry['total_sumberdana'];
			$updater['jumlah_kredit'] = $entry['total_sumberdana'];
			$this->db->where('id_kuitansi_jadi',$entry['id_kuitansi_jadi']);
			$this->db->update('akuntansi_kuitansi_jadi',$updater);
			if ($entry['status'] == 'posted') {
				$this->db_laporan->where('id_kuitansi_jadi',$entry['id_kuitansi_jadi']);
				$this->db_laporan->update('akuntansi_kuitansi_jadi',$updater);
			}
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

	public function fixing_pajak($start,$end)
	{
		// $query = "SELECT FROM akuntansi_kuitansi_jadi AS ak, rsa_kuitansi AS rk, rsa_kuitansi_detail as rd, rsa_kuitansi_detail_pajak AS rp 
		// 			WHERE ak.id_kuitansi = rk.id_kuitansi AND rk.id_kuitansi = rd.id_kuitansi AND rk.id_kuitansi_detail = rp.kuitansi_detail_pajak AND ak.tipe = 'pengeluaran'
		// 			";
		$query = "SELECT id_kuitansi_jadi,id_kuitansi,no_bukti,jenis,id_pajak,status FROM akuntansi_kuitansi_jadi WHERE jenis in ('GP','L3','LSPHK3') AND (id_kuitansi_jadi BETWEEN $start AND $end) AND tipe <> 'pajak' AND tipe <> 'pengembalian'";
		// echo $query;
		// $this->db->select('id_kuitansi_jadi,id_kuitansi,no_bukti,jenis')->where_in('jenis',array('GP','NK'));
		$data = $this->db->query($query)->result_array();
		// print_r($data);die();

		$array_pajak = array();

		foreach ($data as $key => $kuitansi) {
			// print_r($kuitansi);
			// $array_pajak[$key] = $kuitansi;
			// $array_pajak[$i]['lama'] = $this->Pajak_model->get_detail_pajak($kuitansi['no_bukti'],$kuitansi['jenis']);
			$lama = $this->Pajak_model->get_detail_pajak_lama($kuitansi['no_bukti'],$kuitansi['jenis']);
			$baru = $this->Pajak_model->get_detail_pajak_baru($kuitansi['id_kuitansi'],$kuitansi['jenis']);
			if ($baru != $lama) {
				$array_pajak[$key]['kuitansi'] = $kuitansi;
				$array_pajak[$key]['lama'] = $lama;
				$array_pajak[$key]['baru'] = $baru;
			}
		}

		//print_r($array_pajak);die();


		foreach ($array_pajak as $pajak) {
			$lama = $pajak['lama'];
			$baru = $pajak['baru'];
			$kuitansi = $pajak['kuitansi'];

			if ($lama != null and $baru != null ) {
				$this->db->where('id_kuitansi_jadi',$kuitansi['id_pajak'])->delete('akuntansi_relasi_kuitansi_akun');
				foreach ($baru as $array_pajak) {
					$entry['no_bukti'] = $array_pajak['no_bukti'];
					$entry['id_kuitansi_jadi'] = $kuitansi['id_pajak'];
					$entry['akun'] = $this->Pajak_model->get_akun_by_jenis($array_pajak['jenis_pajak'])['kode_akun'];
					$entry['jumlah'] = $array_pajak['rupiah_pajak'];
					$entry['jenis_pajak'] = $array_pajak['jenis_pajak'];
					$entry['jenis'] = 'pajak';

					$this->db->insert('akuntansi_relasi_kuitansi_akun',$entry);
				}
				if ($kuitansi['status'] == 'posted') {
					$this->db_laporan->where('id_kuitansi_jadi',$kuitansi['id_pajak'])->delete('akuntansi_kuitansi_jadi');
			    	$this->db_laporan->where('id_kuitansi_jadi',$kuitansi['id_pajak'])->delete('akuntansi_relasi_kuitansi_akun');
			    	$q6 = $this->Posting_model->posting_kuitansi_full($kuitansi['id_pajak']);
				}
			}
			elseif ($lama != null and $baru == null) {
				$this->db->where('id_kuitansi_jadi',$kuitansi['id_pajak'])->delete('akuntansi_kuitansi_jadi');
				$this->db->where('id_kuitansi_jadi',$kuitansi['id_pajak'])->delete('akuntansi_relasi_kuitansi_akun');
				if ($kuitansi['status'] == 'posted') {
					$this->db_laporan->where('id_kuitansi_jadi',$kuitansi['id_pajak'])->delete('akuntansi_kuitansi_jadi');
					$this->db_laporan->where('id_kuitansi_jadi',$kuitansi['id_pajak'])->delete('akuntansi_relasi_kuitansi_akun');
				}
				$updater = array();
				$updater['id_pajak'] = 0;
				$this->Kuitansi_model->edit_kuitansi_jadi($updater,$kuitansi['id_kuitansi_jadi']);
				if ($kuitansi['status'] == 'posted') {
					$this->Kuitansi_model->edit_kuitansi_jadi_post($updater,$kuitansi['id_kuitansi_jadi']);
				}
			}
			elseif ($lama == null and $baru != null) {
				$kuitansi_pajak = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' => $kuitansi['id_kuitansi_jadi']))->row_array();
		    	$kuitansi_pajak['tipe'] = 'pajak';

	    		$kuitansi_pajak['akun_debet'] = 0;
	    		$kuitansi_pajak['akun_debet_akrual'] = 0;
	    		$kuitansi_pajak['jumlah_debet'] = 0;
	    		$kuitansi_pajak['akun_kredit'] = 0;
	    		$kuitansi_pajak['akun_kredit_akrual'] = 0;
	    		$kuitansi_pajak['jumlah_kredit'] = 0;
	            $kuitansi_pajak['uraian'] = "Pemungutan dan Penyetoran Pajak " . $kuitansi_pajak['uraian'];


	    		$id_kuitansi_awal = $kuitansi_pajak['id_kuitansi_jadi'];

	    		unset($kuitansi_pajak['id_kuitansi_jadi']);
	            unset($kuitansi_pajak['id_pengembalian']);

	    		$this->db->insert('akuntansi_kuitansi_jadi',$kuitansi_pajak);	
		        $id_kuitansi_pajak = $this->db->insert_id();


				foreach ($baru as $array_pajak) {
					$entry['no_bukti'] = $kuitansi_pajak['no_bukti'];
					$entry['id_kuitansi_jadi'] = $id_kuitansi_pajak;
					$entry['akun'] = $this->Pajak_model->get_akun_by_jenis($array_pajak['jenis_pajak'])['kode_akun'];
					$entry['jumlah'] = $array_pajak['rupiah_pajak'];
					$entry['jenis_pajak'] = $array_pajak['jenis_pajak'];
					$entry['jenis'] = 'pajak';

					$this->db->insert('akuntansi_relasi_kuitansi_akun',$entry);
				}

				$updater['id_pajak'] = $id_kuitansi_pajak;

            	$this->Kuitansi_model->edit_kuitansi_jadi($updater,$id_kuitansi_awal);


            	if ($kuitansi['status'] == 'posted') {
					$q6 = $this->Posting_model->posting_kuitansi_full($id_kuitansi_pajak);
			    	$this->db_laporan->where('id_kuitansi_jadi',$id_kuitansi_awal)->delete('akuntansi_kuitansi_jadi');
			    	$this->db_laporan->where('id_kuitansi_jadi',$id_kuitansi_awal)->delete('akuntansi_relasi_kuitansi_akun');

			    	$q6 = $this->Posting_model->posting_kuitansi_full($id_kuitansi_awal);
				}

				
			}
		}
		

		return ($array_pajak);


	}

	
}