<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_akuntansi_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }
	
	public function generate_kode_user($kode_unit){
		$last_user = $this->db->order_by('id','desc')->get_where('akuntansi_user',array('kode_unit' => $kode_unit))->row_array();

		$unit_short = $this->db2->get_where('unit', array('kode_unit' => $kode_unit))->row_array()['alias'];

		if ($last_user == null) {
			return $unit_short.'-01';
		} else {
			$no_user = (int)substr($last_user['kode_user'],4);
			$no_user++;

			return $unit_short.'-'.sprintf("%02d", $no_user);
		}
	}
    
    public function ganti_password(){
		$id_user = $this->db->get_where('akuntansi_user',array('id'=>$this->session->userdata('id'), 'password' => sha1($this->input->post('password_lama'))));
        
        if($id_user->num_rows()){
            $this->db->set('password', sha1($this->input->post('password_baru')));
            $this->db->where('id', $this->session->userdata('id'));
            $this->db->update('akuntansi_user');
            return true;
        } else {
            return false;
        }
	}
  
    // Reset password. Jika $password tidak diberikan, dirandom password 5 karakter. Return $password saat berhasil. Return false saat $id_user tidak ditemukan.
    public function reset_password($user_id, $password = null){
        if($password == null){
          $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
          $base = strlen($charset);
          $result = '';

          $now = explode(' ', microtime())[1];
          while ($now >= $base){
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
          }
          $password = substr($result, -5);
        }
      
		$id_user = $this->db->get_where('akuntansi_user',array('id'=>$user_id));
        
        if($id_user->num_rows()){
            $this->db->set('password', sha1($password));
            $this->db->where('id', $user_id);
            $this->db->update('akuntansi_user');
            return $password;
        } else {
            return false;
        }
	}
}