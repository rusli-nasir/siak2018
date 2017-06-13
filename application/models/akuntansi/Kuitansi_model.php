<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kuitansi_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
        $this->db_laporan = $this->load->database('laporan',TRUE);
    }
	
	function read_kuitansi($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND kode_unit="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM rsa_kuitansi WHERE cair=1 AND flag_proses_akuntansi=0 AND
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM rsa_kuitansi WHERE cair=1 AND flag_proses_akuntansi=0 AND
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') $unit");
		}
		return $query;
	}
    
    function read_up($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_up.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM trx_spm_up_data, trx_up, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_up AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM trx_spm_up_data, trx_up, kas_bendahara WHERE nomor_trx_spm = id_trx_nomor_up AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit");
		}
		return $query;
	}

    function read_gup($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND trx_spm_gup_data.kode_unit_subunit="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE id_trx_spm_gup_data = id_trx_nomor_gup AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
            (str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE id_trx_spm_gup_data = id_trx_nomor_gup AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
            (str_nomor_trx LIKE '%$keyword%') $unit");
        }
        return $query;
    }
    
    function read_pup($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_tambah_up.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM trx_spm_tambah_up_data, trx_tambah_up, kas_bendahara WHERE id_trx_spm_tambah_up_data = id_trx_nomor_tambah_up AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM trx_spm_tambah_up_data, trx_tambah_up, kas_bendahara WHERE id_trx_spm_tambah_up_data = id_trx_nomor_tambah_up AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit");
		}
		return $query;
	}
    
    function read_tup($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_tambah_tup.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM trx_spm_tambah_tup_data, trx_tambah_tup, kas_bendahara WHERE id_trx_spm_tambah_tup_data = id_trx_nomor_tambah_tup AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM trx_spm_tambah_tup_data, trx_tambah_tup, kas_bendahara WHERE id_trx_spm_tambah_tup_data = id_trx_nomor_tambah_tup AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit");
		}
		return $query;
	}
    
    function read_tup_nihil($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND substr(trx_tup.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM trx_spm_tup_data, trx_tup, kas_bendahara WHERE id_trx_spm_tup_data = id_trx_nomor_tup AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM trx_spm_tup_data, trx_tup, kas_bendahara WHERE id_trx_spm_tup_data = id_trx_nomor_tup AND posisi='SPM-FINAL-KBUU' AND flag_proses_akuntansi=0 AND no_spm = str_nomor_trx AND
			(str_nomor_trx LIKE '%$keyword%') $unit");
		}
		return $query;
	}

    function read_spm($limit = null, $start = null, $keyword = null){
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '';
        }else{
            if($this->session->userdata('alias')=='WR2'){
                $alias = 'W23';
            }else{
                $alias = $this->session->userdata('alias');
            }
            $filter_unit = "AND substr(nomor,7,3)='".$alias."'";
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM kepeg_tr_spmls WHERE flag_proses_akuntansi=0 AND nomor LIKE '%$keyword%' $filter_unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM kepeg_tr_spmls WHERE flag_proses_akuntansi=0 AND nomor LIKE '%$keyword%' $filter_unit");
        }
        return $query;
    }

    function read_kuitansi_jadi($limit = null, $start = null, $keyword = null, $kode_unit = null, $jenis = 'GP'){
        if($kode_unit!=null){
            $unit = 'AND unit_kerja="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='$jenis' AND (tipe<>'memorial' AND tipe<>'jurnal_umum' AND tipe<>'pajak') AND status<>'posted' AND
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted') LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='$jenis' AND (tipe<>'memorial' AND tipe<>'jurnal_umum' AND tipe<>'pajak') AND status<>'posted' AND 
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted')");
        }
        return $query;
    }

	function read_kuitansi_ls($limit = null, $start = null, $keyword = null, $kode_unit=null){
		if($kode_unit!=null){
            $unit = 'AND substr(trx_lsphk3.kode_unit_subunit,1,2)="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM trx_spm_lsphk3_data, trx_lsphk3, (select id_kuitansi, kode_akun, uraian, no_bukti, cair from rsa_kuitansi_lsphk3) as  rsa_kuitansi_lsphk3 WHERE id_trx_spm_lsphk3_data = id_trx_nomor_lsphk3 AND posisi='SPM-FINAL-KBUU' AND trx_lsphk3.id_kuitansi = rsa_kuitansi_lsphk3.id_kuitansi AND trx_spm_lsphk3_data.flag_proses_akuntansi=0 AND rsa_kuitansi_lsphk3.cair = 1 AND
			(str_nomor_trx LIKE '%$keyword%') $unit LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM trx_spm_lsphk3_data, trx_lsphk3, (select id_kuitansi, kode_akun, uraian, no_bukti, cair from rsa_kuitansi_lsphk3) as  rsa_kuitansi_lsphk3 WHERE id_trx_spm_lsphk3_data = id_trx_nomor_lsphk3 AND posisi='SPM-FINAL-KBUU' AND trx_lsphk3.id_kuitansi = rsa_kuitansi_lsphk3.id_kuitansi AND trx_spm_lsphk3_data.flag_proses_akuntansi=0 AND rsa_kuitansi_lsphk3.cair = 1 AND
			(str_nomor_trx LIKE '%$keyword%') $unit");
		}
		return $query;
	}

    function read_kuitansi_jadi_ls($limit = null, $start = null, $keyword = null){
        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='LSPHK3' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted') LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='LSPHK3' AND
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted')");
        }
        return $query;
    }

    function read_kuitansi_jadi_spm($limit = null, $start = null, $keyword = null){
        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='NK' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted') LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='NK' AND
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted')");
        }
        return $query;
    }
    
    function read_kuitansi_posting($limit = null, $start = null, $keyword = null, $kode_unit = null,  $jenis = 'GP'){
        if($kode_unit!=null){
            $unit = 'AND unit_kerja="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='$jenis' AND tipe<>'pajak' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='$jenis' AND tipe<>'pajak' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit");
        }
        return $query;
    }

    function read_kuitansi_posting_ls($limit = null, $start = null, $keyword = null){
        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='L3' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='L3' AND
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%')");
        }
        return $query;
    }

    function read_kuitansi_posting_spm($limit = null, $start = null, $keyword = null){
        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='NK' AND jenis<>'pajak' AND 
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='NK' AND jenis<>'pajak' AND
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%')");
        }
        return $query;
    }

    /*----------------Penerimaan & memorial ---------------------*/

    function read_by_tipe($limit = null, $start = null, $keyword = null, $tipe = 'penerimaan'){
        if($this->session->userdata('level')==1 || $this->session->userdata('level')==5){
            $filter_unit = "AND unit_kerja='".$this->session->userdata('kode_unit')."'";
        }else{
            $filter_unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE tipe='$tipe' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $filter_unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE tipe='$tipe' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $filter_unit");
        }
        return $query;
    }

    /*----------------Penerimaan & memorial ---------------------*/

    public function get_nama_unit($kode_unit){
        $hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$kode_unit))->row_array()['nama_unit'];
        return $hasil;
    }

	public function get_kuitansi_transfer($id_kuitansi,$tabel,$tabel_detail)
    {
    	$this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->load->model('akuntansi/Spm_model', 'Spm_model');

    	$hasil = $this->db->get_where($tabel,array('id_kuitansi'=>$id_kuitansi))->row_array();

    	$hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$hasil['kode_unit']))->row_array()['nama_unit'];
    	$hasil['akun_debet'] = $hasil['kode_akun'];



    	$query = "SELECT SUM(rsa.$tabel_detail.volume*rsa.$tabel_detail.harga_satuan) AS pengeluaran FROM $tabel,$tabel_detail WHERE $tabel.id_kuitansi = $tabel_detail.id_kuitansi AND $tabel.id_kuitansi=$id_kuitansi GROUP BY rsa.$tabel.id_kuitansi";
    	$hasil['jumlah_debet'] = $this->db->query($query)->row_array()['pengeluaran'];


    	$hasil['tanggal'] = $this->Spm_model->get_tanggal_spm($hasil['str_nomor_trx_spm']);
        $hasil['tanggal_bukti'] = $hasil['tgl_kuitansi'];
    	$hasil['no_spm'] = $hasil['str_nomor_trx_spm'];
    	$hasil['kode_kegiatan'] = $hasil['kode_usulan_belanja'];
    	$hasil['unit_kerja'] = $hasil['kode_unit'];

    	$field_tujuan = $this->db->list_fields('akuntansi_kuitansi_jadi');
    	$field_asal = array_keys($hasil);

    	foreach ($field_asal as $field) {
    		if (!in_array($field, $field_tujuan)){
    			unset($hasil[$field]);
    		}
    	}


    	return $hasil;
    }

    public function get_kuitansi_jadi($id_kuitansi_jadi)
    {
    	$this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
    	$hasil =  $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi'=>$id_kuitansi_jadi))->row_array();
        $hasil['kode_unit'] = $hasil['unit_kerja'];
    	$hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$hasil['unit_kerja']))->row_array()['nama_unit'];
        $hasil['tgl_kuitansi'] = $hasil['tanggal'];
        $hasil['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal($hasil['tanggal']);
    	$hasil['tanggal_bukti'] = $this->Jurnal_rsa_model->reKonversiTanggal($hasil['tanggal_bukti']);
    	$hasil['akun_debet_kas'] = $hasil['akun_debet'] . " - ". $this->Akun_model->get_nama_akun($hasil['akun_debet']);
    	return $hasil;

    }

    public function get_kuitansi_nk($id_spmls)
    {
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
    	$this->load->model('akuntansi/Akun_model', 'Akun_model');
    	$hasil =  $this->db->get_where('kepeg_tr_spmls',array('id_spmls'=>$id_spmls))->row_array();
    	$hasil['no_bukti'] = '';
    	$hasil['kode_usulan_belanja'] =  $hasil['detail_belanja'];
    	$hasil['unit_kerja'] = '';
    	$hasil['jenis'] = 'NK';
    	$hasil['pengeluaran'] = $hasil['jumlah_bayar'];
    	$hasil['str_nomor_trx_spm'] = $hasil['nomor'];
    	$hasil['tgl_kuitansi'] = $hasil['tanggal'];
    	$hasil['tanggal'] = $this->Jurnal_rsa_model->reKonversiTanggal($hasil['tanggal']);
    	$hasil['uraian'] = '';
    	$hasil['akun_debet'] = substr($hasil['detail_belanja'],18,6);
        $hasil['kode_akun'] = $hasil['akun_debet'];
    	$hasil['akun_debet_kas'] = $hasil['akun_debet'] . " - ". $this->Akun_model->get_nama_akun($hasil['akun_debet']);
    	return $hasil;
    }

    public function get_kuitansi_transfer_nk($id_spmls)
    {
    	$hasil = $this->get_kuitansi_nk($id_spmls);

    	$hasil['akun_debet'] = $hasil['kode_akun'];

    	$hasil['jumlah_debet'] = $hasil['pengeluaran'];


    	$hasil['tanggal'] = $hasil['tgl_kuitansi'];
        $hasil['tanggal_bukti'] = $hasil['tanggal'];
    	$hasil['no_spm'] = $hasil['str_nomor_trx_spm'];
    	$hasil['kode_kegiatan'] = $hasil['kode_usulan_belanja'];
    	$hasil['unit_kerja'] = '';

    	$field_tujuan = $this->db->list_fields('akuntansi_kuitansi_jadi');
    	$field_asal = array_keys($hasil);

    	foreach ($field_asal as $field) {
    		if (!in_array($field, $field_tujuan)){
    			unset($hasil[$field]);
    		}
    	}


    	return $hasil;
    }

    function add_kuitansi_jadi($params,$type = null)
    {
        if ($type == 'post') {
            $this->db_laporan->insert('akuntansi_kuitansi_jadi',$params);
            return $this->db_laporan->insert_id();   
        } else {
            $this->db->insert('akuntansi_kuitansi_jadi',$params);
            return $this->db->insert_id();
        }
    }

    function edit_kuitansi_jadi($params,$id_kuitansi_jadi = null)
    {
        $this->db->where('id_kuitansi_jadi', $id_kuitansi_jadi);
        $query = $this->db->update('akuntansi_kuitansi_jadi',$params);
        return $query;
    }

    public function get_tabel_by_jenis($jenis)
    {
    	if ($jenis == 'GP') {
    		return 'rsa_kuitansi';
    	}elseif ($jenis == 'L3') {
    		return 'rsa_kuitansi_lsphk3';
    	}
    }
    public function get_tabel_detail_by_jenis($jenis)
    {
    	if ($jenis == 'GP') {
    		return 'rsa_kuitansi_detail';
    	}elseif ($jenis == 'L3') {
    		return 'rsa_kuitansi_detail_lsphk3';
    	}
    }

    public function get_kuitansi_posting($id_kuitansi_jadi)
    {
        $hasil = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi'=>$id_kuitansi_jadi))->row_array();
        unset($hasil['status']);
        unset($hasil['flag']);
        return $hasil;
    }

    function update_kuitansi($id_kuitansi,$tabel,$params)
    {
        $this->db->where('id_kuitansi',$id_kuitansi);
        $response = $this->db->update($tabel,$params);
        if($response)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function update_kuitansi_jadi($id_kuitansi_jadi,$params)
    {
    	$this->db->where('id_kuitansi_jadi',$id_kuitansi_jadi);
        $response = $this->db->update('akuntansi_kuitansi_jadi',$params);
         if($response)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function update_kuitansi_nk($id_spmls,$params)
    {
    	$this->db->where('id_spmls',$id_spmls);
        $response = $this->db->update('kepeg_tr_spmls',$params);
         if($response)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function read_total($cond, $table){
        $this->db->where($cond);
        $query = $this->db->get($table);
        return $query;
    }

    public function total_up($posisi, $flag){
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '';
        }else{
            $filter_unit = 'AND substr(T.kode_unit_subunit,1,2)='.$this->session->userdata('kode_unit').'';
        }

        $query = $this->db->query("SELECT * FROM trx_up T, trx_spm_up_data U WHERE T.id_trx_nomor_up=U.nomor_trx_spm AND T.posisi='$posisi' AND U.flag_proses_akuntansi='$flag' $filter_unit");
        return $query;
    }

    public function total_pup($posisi, $flag){
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '';
        }else{
            $filter_unit = 'AND substr(T.kode_unit_subunit,1,2)='.$this->session->userdata('kode_unit').'';
        }

        $query = $this->db->query("SELECT * FROM trx_tambah_up T, trx_spm_tambah_up_data U WHERE T.id_trx_nomor_tambah_up=U.nomor_trx_spm AND T.posisi='$posisi' AND U.flag_proses_akuntansi='$flag' $filter_unit");
        return $query;
    }

    public function total_tup($posisi, $flag){
        if($this->session->userdata('kode_unit')==null){
            $filter_unit = '';
        }else{
            $filter_unit = 'AND substr(T.kode_unit_subunit,1,2)='.$this->session->userdata('kode_unit').'';
        }

        $query = $this->db->query("SELECT * FROM trx_tambah_tup T, trx_spm_tambah_tup_data U WHERE T.id_trx_nomor_tambah_tup=U.nomor_trx_spm AND T.posisi='$posisi' AND U.flag_proses_akuntansi='$flag' $filter_unit");
        return $query;
    }
    
    public function total_gup($posisi, $flag){
        if($this->session->userdata('kode_unit')!=null){
            $unit = 'AND trx_spm_gup_data.kode_unit_subunit="'.$this->session->userdata('kode_unit').'"';
        }else{
            $unit = '';
        }

        
            $query = $this->db->query("SELECT * FROM trx_spm_gup_data, trx_gup, kas_bendahara WHERE id_trx_spm_gup_data = id_trx_nomor_gup AND posisi='$posisi' AND flag_proses_akuntansi='$flag' AND no_spm = str_nomor_trx $unit");
        return $query;
    }
}