<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Revisi_session{
	 public function __construct()
        {
                // Call the CI_Model constructor
                // parent::__construct();
        }
	
	function is_revisi(){
		return (isset($_SESSION['revisi_ke']) && isset($_SESSION['revisi_status']) && $_SESSION['revisi_status']=='disetujui');
	}
	
	function set_session($ke='', $status=''){
		if(strlen($ke) > 0 && strlen($status) > 0){
			$_SESSION['revisi_ke']				= form_prep($ke);
			$_SESSION['revisi_status']			= form_prep($status);
		}
	}
	
	function get_revisi_ke(){
		return !empty($_SESSION['revisi_ke'])?$_SESSION['revisi_ke']:'';
	}
	
	function get_status(){
		return !empty($_SESSION['revisi_status'])?$_SESSION['revisi_status']:'';
	}
}
?>