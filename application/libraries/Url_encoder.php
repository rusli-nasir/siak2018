<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class Url_encoder{
	private $key = "kUnc!_Sup3r_4L@y_s3kaA4l1";
	private $CI = '';
	
	 public function __construct()
        {
                // Call the CI_Model constructor

		$this->CI =& get_instance();
		$this->CI->load->library('encrypt');
	}
	
	function get_token(){
		return sha1(md5($this->key));
	}
	function encode($url)
	{
		return $this->_str_to_hex($this->CI->encrypt->encode($url, $this->_get_key()));
	}
	
	function decode($enc_url){
		return $this->CI->encrypt->decode($this->_hex_to_str($enc_url),$this->_get_key());
	}
	
	private function _get_key(){
		return $this->key;
	}
	
	private function _str_to_hex($str){
		$hex = '';
		for($i=0;$i<strlen($str);$i++)
		{
			$hex.=dechex(ord($str[$i]));
		}
		return $hex;
	}
	
	private function _hex_to_str($hex){
		$str = '';
		for($i=0;$i<strlen($hex)-1;$i+=2)
		{
			$str.=chr(hexdec($hex[$i].$hex[$i+1]));
		}
		return $str;
	}
}
?>