<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekening_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }

    function create($data){
        $query = $this->db->insert('akuntansi_aset_6', $data);
        return $query;
    }

    function update($cond, $data){
        $this->db->where($cond);
        $query = $this->db->update('akuntansi_aset_6', $data);
        return $query;
    }
	
	function read($cond){
        if($cond!=null){         
            $this->db->where($cond);
        }
        $this->db->order_by('id_akuntansi_aset_6', 'ASC');
        $query = $this->db->get('akuntansi_aset_6');
		return $query;
	}

    function read_unit(){
        $query = $this->db2->query("SELECT * FROM unit");
        return $query;
    }

    function delete($cond){
        $this->db->where($cond);
        $query = $this->db->delete('akuntansi_aset_6');
        return $query;
    }
}