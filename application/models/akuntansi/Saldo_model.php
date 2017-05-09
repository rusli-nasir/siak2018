<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saldo_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }

    function create($data){
        $query = $this->db->insert('akuntansi_saldo', $data);
        return $query;
    }

    function update($cond, $data){
        $this->db->where($cond);
        $query = $this->db->update('akuntansi_saldo', $data);
        return $query;
    }
	
	function read($cond){
        if($cond!=null){         
            $this->db->where($cond);
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('akuntansi_saldo');
		return $query;
	}

    function read_akun_6($table, $cond){
        if($cond!=null){         
            $this->db->where($cond);
        }
        $this->db->order_by('akun_6', 'ASC');
        $query = $this->db->get($table);
        return $query;
    }

    function read_by_akun($akun){
        $query = $this->db->query("SELECT * FROM akuntansi_saldo WHERE akun LIKE '$akun%' ORDER BY id DESC");
        return $query;
    }

    function read_unit(){
        $query = $this->db2->query("SELECT * FROM unit");
        return $query;
    }

    function delete($cond){
        $this->db->where($cond);
        $query = $this->db->delete('akuntansi_saldo');
        return $query;
    }
}