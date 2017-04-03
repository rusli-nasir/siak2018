<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Revisif_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
/* -------------- Method ------------- */
	/*	Fungsi untuk mencari data kegiatan	*/
	function search_revisi($kata_kunci='',$get='',$tahun){
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		$and_id = "";
		$or_like = "";
		if($get=='id')
		{
			//$this->db->like('id_revisi', $kata_kunci);
			$and_id = "AND id_revisi = {$kata_kunci}";
		} else {
			if($kata_kunci!='')
			{
				/*
					$this->db->like('nama_subunit', $kata_kunci);
					$this->db->or_like('nomor_surat', $kata_kunci); 
					$this->db->or_like('keterangan', $kata_kunci); 
					$this->db->or_like('status', $kata_kunci); 
					$this->db->or_like('revisi', $kata_kunci);
				*/
				$or_like = "AND (nama_subunit like '%{$kata_kunci}%' OR nomor_surat like '%{$kata_kunci}%'
							OR keterangan like '%{$kata_kunci}%' OR status like '%{$kata_kunci}%'
							OR revisi like '%{$kata_kunci}%')";
			}
			//$this->db->order_by("tanggal", "desc"); 
		}
		/* running query	*/
		//$this->db->select('id_revisi, kode_unit_subunit, nama_subunit, tanggal, nomor_surat, keterangan, status, tahun, revisi');
		//$this->db->where('tahun',$tahun);
		//$this->db->from('manajemen_revisi');
		//$this->db->join('subunit', 'subunit.kode_subunit = manajemen_revisi.kode_unit_subunit');
		$query		= $this->db->query("SELECT id_revisi, kode_unit_subunit, nama_subunit, tanggal, 
										nomor_surat, keterangan, status, tahun, revisi
										FROM manajemen_revisi
										JOIN subunit ON subunit.kode_subunit = manajemen_revisi.kode_unit_subunit
										WHERE tahun = '{$tahun}' {$and_id} {$or_like}
										ORDER BY tanggal DESC");
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	/* Method untuk menghapus data revisi */
	function delete_revisi($id_revisi){
		return $this->db->delete("manajemen_revisi",array('id_revisi'=>$id_revisi));
	}
	
	/* Method untuk menambah data revisi */
	function add_revisi($data){
		return $this->db->insert("manajemen_revisi",$data);
	}
	
	function edit_revisi($data,$where){
		$this->db->where("id_revisi",$where);
		return $this->db->update('manajemen_revisi',$data);
	}
	
	/* Method untuk mengambil data subunit */
	function get_subunit(){
		$this->db->select('kode_subunit, nama_subunit');
		$this->db->from('subunit');
		$this->db->order_by("nama_subunit", "asc"); 
		$query = $this->db->get();
		if ($query->num_rows()>0){
			$subunit = $query->result();
				foreach($subunit as $row){
					$opt_subunit["$row->kode_subunit"] = $row->nama_subunit;
				}
			return $opt_subunit;
		
		}else{
			return array();
		}
	}
	
	function get_unit(){
		$query = $this->db->query("	SELECT 
									* 
								FROM 
									subunit
								WHERE
									(LEFT(kode_subunit,2)='99' OR RIGHT(kode_subunit,2)='99') AND
									kode_subunit!='9999' 
								ORDER BY nama_subunit ASC
							");
		if ($query->num_rows()>0){
			$subunit = $query->result();
				foreach($subunit as $row){
					$opt_subunit["$row->kode_subunit"] = $row->nama_subunit;
				}
			return $opt_subunit;
		
		}else{
			return array();
		}
	}

	// ADDED BY IDRIS
	
	function is_revisif(){

	}
}
?>