<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekening_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }

    function create($data){
        $query = $this->db->insert('akuntansi_kas_rekening', $data);
        return $query;
    }

    function update($cond, $data){
        $this->db->where($cond);
        $query = $this->db->update('akuntansi_kas_rekening', $data);
        return $query;
    }
	
	function read($cond){
        if($cond!=null){         
            $this->db->where($cond);
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('akuntansi_kas_rekening');
		return $query;
	}

    function read_unit(){
        $query = $this->db2->query("SELECT * FROM unit");
        return $query;
    }

    function delete($cond){
        $this->db->where($cond);
        $query = $this->db->delete('akuntansi_kas_rekening');
        return $query;
    }
}