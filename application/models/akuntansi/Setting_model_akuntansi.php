<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model_akuntansi extends CI_Model {

	public function setting_tahun($data)
	{
			//print_r($this->get_tahun());die();
		  $this->db->select('id');
        $this->db->where('nilai',$data['nilai']);
        $query = $this->db->get('setting_akuntansi');

        if($query->num_rows() > 0){
        	$this->db->set('flag',0);
        	$this->db->where('nilai',$this->get_tahun());
        	$this->db->update('setting_akuntansi');
        	$this->db->set('flag',1);
        	$this->db->where('nilai',$data['nilai']);
        	$this->db->update('setting_akuntansi');
        } else{
        	$this->db->set('flag',0);
        	$this->db->where('nilai',$this->get_tahun());
        	$this->db->update('setting_akuntansi');
        	
     		$this->db->insert('setting_akuntansi', $data); 
        }
		
	}

	public function get_tahun()
	{
		  $this->db->select('nilai');
        $this->db->where('flag',1);
        $query = $this->db->get('setting_akuntansi');
        if ($query->num_rows() > 0){
	        return $query->row()->nilai;	
        }
	}
	

}

/* End of file Setting_model.php */
/* Location: ./application/models/akuntansi/Setting_model.php */