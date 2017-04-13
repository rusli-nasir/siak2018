<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kuitansi_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }
	
	function read_kuitansi($limit = null, $start = null, $keyword = null){
		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM rsa_kuitansi WHERE cair=1 AND 
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM rsa_kuitansi WHERE cair=1 AND 
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%')");
		}
		return $query;
	}

	function read_kuitansi_ls($limit = null, $start = null, $keyword = null){
		if($limit!=null OR $start!=null){
			$query = $this->db->query("SELECT * FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND 
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%') LIMIT $start, $limit");
		}else{
			$query = $this->db->query("SELECT * FROM rsa_kuitansi_lsphk3 WHERE cair=1 AND 
			(no_bukti LIKE '%$keyword%' OR str_nomor_trx_spm LIKE '%$keyword%')");
		}
		return $query;
	}

	public function get_kuitansi_transfer($id_kuitansi,$tabel,$tabel_detail)
    {
    	$hasil = $this->db->get_where($tabel,array('id_kuitansi'=>$id_kuitansi))->row_array();

    	$hasil['unit_kerja'] = $this->db2->get_where('unit',array('kode_unit'=>$hasil['kode_unit']))->row_array()['nama_unit'];
    	$hasil['akun_debet'] = $hasil['kode_akun'];



    	$query = "SELECT SUM(rsa.$tabel_detail.volume*rsa.$tabel_detail.harga_satuan) AS pengeluaran FROM $tabel,$tabel_detail WHERE $tabel.id_kuitansi = $tabel_detail.id_kuitansi AND $tabel.id_kuitansi=$id_kuitansi GROUP BY rsa.$tabel.id_kuitansi";
    	$hasil['jumlah_debet'] = $this->db->query($query)->row_array()['pengeluaran'];


    	$hasil['tanggal'] = $hasil['tgl_kuitansi'];
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

    public function get_kuitansi_jadi($id_kuitansi)
    {
    	return $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi'=>$id_kuitansi))->row_array();
    }

    function add_kuitansi_jadi($params)
    {
        $this->db->insert('akuntansi_kuitansi_jadi',$params);
        return $this->db->insert_id();
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

}