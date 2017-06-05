<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Check_session{

	 public function __construct()
        {
                // Call the CI_Model constructor
                // parent::__construct();
        }
	
	function user_session(){
		return (isset($_SESSION['rsa_kode_unit_subunit']) && isset($_SESSION['rsa_level']) && isset($_SESSION['rsa_nama_unit']) && isset($_SESSION['rsa_username']) && isset($_SESSION['rsa_kd_pisah']));
	}
	
	function set_session($username='', $kode_unit_subunit='',$level='',$nama_unit='', $alias = '', $kd_pisah = '' ){
		if(strlen($username) > 0 && strlen($level) > 0 && strlen($kode_unit_subunit) > 0 && strlen($nama_unit) > 0 && strlen($alias) > 0){
			// $_SESSION['rsa_kode_unit_subunit']		= (strlen($kode_unit_subunit)==2 && $level==2)?form_prep($kode_unit_subunit).'99':form_prep($kode_unit_subunit);
			$_SESSION['rsa_kode_unit_subunit']		= form_prep($kode_unit_subunit);
			$_SESSION['rsa_ori_kode_unit_subunit']          = form_prep($kode_unit_subunit);
			$_SESSION['rsa_level']                          = form_prep($level);
			$_SESSION['rsa_nama_unit']			= form_prep($nama_unit);
            $_SESSION['rsa_alias']              = form_prep($alias);
			$_SESSION['rsa_username']           = form_prep($username);
			$_SESSION['rsa_kd_pisah']			= form_prep($kd_pisah);
		}
	}
	
	function get_level(){
		return $_SESSION['rsa_level'];
	}
	
	function get_unit(){
		return $_SESSION['rsa_kode_unit_subunit'];
	}
	
	function get_ori_unit(){
		return $_SESSION['rsa_ori_kode_unit_subunit'];
	}
	
	function get_nama_unit(){
		return $_SESSION['rsa_nama_unit'];
	}
        
        function get_alias(){
		return $_SESSION['rsa_alias'];
	}
	
	function get_username(){
		return $_SESSION['rsa_username'];
	}
	function get_kd_pisah(){
		return $_SESSION['rsa_kd_pisah'];
	}
	/*
        function get_user_revisi(){
		return $_SESSION['rsa_user_revisi'];
	}
        * /
         */
    
    public function datetostr($date){
        $list = 
            array(
                'JANUARI',
                'FEBRUARI',
                'MARET',
                'APRIL',
                'MEI',
                'JUNI',
                'JULI',
                'AGUSTUS',
                'SEPTEMBER',
                'OKTOBER',
                'NOVEMBER',
                'DESEMBER'
                 );
        $tokens = explode('-', $date);
        $tokens[1] = ucfirst(strtolower($list[intval($tokens[1])-1]));
        return $tokens[2].' '.$tokens[1].' '.$tokens[0];
    }
    
    public function strtodate($str){
        if(!$str) return null;
        $list = 
            array(
                'JANUARI'=>'01',
                'FEBRUARI'=>'02',
                'MARET'=>'03',
                'APRIL'=>'04',
                'MEI'=>'05',
                'JUNI'=>'06',
                'JULI'=>'07',
                'AGUSTUS'=>'08',
                'SEPTEMBER'=>'09',
                'OKTOBER'=>'10',
                'NOVEMBER'=>'11',
                'DESEMBER'=>'12'
                 );
        $tokens = explode(' ', $str);
        $tokens[1] = $list[strtoupper($tokens[1])];
        return $tokens[2].'-'.$tokens[1].'-'.$tokens[0];
    }
}
?>