<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
	/* -------------- Method ------------- */
	function all()
	{
		$menu = $this->db->query("SELECT * FROM rsa_menu ORDER BY level ASC");
		return $menu->result();
	}
	
	function show()
	{
		$menu = $this->db->query("SELECT * FROM rsa_menu WHERE active='1'");
		return $menu->result();
	}
	
	function menu_aktif($level)
	{
		$menu = $this->db->query("SELECT * FROM rsa_menu WHERE active='1' AND level='{$level}'");
		return $menu->result();
	}
	
	function activation($id,$active)
	{
		if($active == "1"){
			$aktif = "0";
		}else if($active == "0"){
			$aktif = "1";
		}
		$status = $this->db->query("UPDATE `rsa_menu` SET `active`= '$aktif' WHERE `id` = '$id'");
		if($status){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}