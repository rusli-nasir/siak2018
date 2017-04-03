<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	function get_user($username, $password){
		$this->db->select('*');
		$this->db->where(array(
			'username'	=> $username,
			'password'	=> sha1($password),
			'aktif'		=> '1'
		));
		
		return $this->db->get('akuntansi_user');
	}
}