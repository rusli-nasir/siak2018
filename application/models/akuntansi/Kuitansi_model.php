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

    function read_kuitansi_jadi($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND unit_kerja="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='GP' AND tipe!='memorial' AND tipe!='jurnal_umum' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted') LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='GP' AND tipe!='memorial' AND tipe!='jurnal_umum' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted')");
        }
        return $query;
    }

	function read_kuitansi_ls($limit = null, $start = null, $keyword = null){
		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND flag_proses_akuntansi=0 AND
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND flag_proses_akuntansi=0 AND
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%')");
		}
		return $query;
	}

    function read_kuitansi_jadi_ls($limit = null, $start = null, $keyword = null){
        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='L3' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') ORDER BY FIELD(status, 'revisi', 'terima', 'proses', 'posted') LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis='L3' AND
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
    
    function read_kuitansi_posting($limit = null, $start = null, $keyword = null, $kode_unit = null){
        if($kode_unit!=null){
            $unit = 'AND unit_kerja="'.$kode_unit.'"';
        }else{
            $unit = '';
        }

        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='GP' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') $unit LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='GP' AND  
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
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='NK' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE flag=2 AND jenis='NK' AND
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%')");
        }
        return $query;
    }

    /*----------------Penerimaan & memorial ---------------------*/

    function read_by_tipe($limit = null, $start = null, $keyword = null, $tipe = 'penerimaan'){
        if($limit!=null OR $start!=null){
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE tipe='$tipe' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%') LIMIT $start, $limit");
        }else{
            $query = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE tipe='$tipe' AND  
            (no_bukti LIKE '%$keyword%' OR no_spm LIKE '%$keyword%')");
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
    	$hasil['akun_debet_kas'] = $hasil['akun_debet'] . " - ". $this->db->get_where('akun_belanja',array('kode_akun'=>$hasil['akun_debet']))->row_array()['nama_akun'];
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
}