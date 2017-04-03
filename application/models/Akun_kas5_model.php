<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Akun_kas5_model extends CI_Model{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
	}
	
/* -------------- Method ------------- */
	/*	Fungsi untuk mencari data output	*/
	function search_akun_kas5($kd_kas_2='', $kd_kas_3='', $kd_kas_4='', $kata_kunci=''){
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		$where = "kd_kas_2 = '{$kd_kas_2}' AND kd_kas_3 = '{$kd_kas_3}' AND kd_kas_4 = '{$kd_kas_4}'";
		if($kata_kunci!='')
		{
			$where .= " AND (kd_kas_5 LIKE '%{$kata_kunci}%' OR nm_kas_5 LIKE '%{$kata_kunci}%')";
		}
		$this->db->where($where);
		$this->db->order_by("kd_kas_5", "asc"); 
		/* running query	*/
		$query		= $this->db->get('akun_kas5');

		//echo'</pre>'; echo $kd_kas_2 . '|' . $kd_kas_3 . '|' . $kd_kas_4 . '|'  ; var_dump($query->result());echo'</pre>';die;


		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function get_akun_kas5($where=""){

		if(is_array($where)){
			$this->db->where($where);
			/*$this->db->where("kd_kas_2",$where["kd_kas_2"]);
			$this->db->where("kd_kas_3",$where["kd_kas_3"]);
			$this->db->where("kd_kas_4",$where["kd_kas_4"]);
			$this->db->where("kd_kas_5",$where["kd_kas_5"]);
			*/
		}

		$query = $this->db->get("akun_kas5");
		//var_dump($where);
		if ($query->num_rows() >0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function add_akun_kas5($data){
		
		return $this->db->insert("akun_kas5",$data);
	}
	
	function edit_akun_kas5($data,$where){
		if(is_array($where)){
			$this->db->where("kd_kas_5",$where["kd_kas_5"]);
			$this->db->where("kd_kas_3",$where["kd_kas_3"]);
			$this->db->where("kd_kas_2",$where["kd_kas_2"]);
			$this->db->where("kd_kas_4",$where["kd_kas_4"]);
		}
		return $this->db->update("akun_kas5",$data);
	}
	
	function delete_akun_kas5($where){
		// $this->db->where("kd_kas_5",$kd_kas_5);
		// return $this->db->delete("komponen_input");

		$this->db->delete("akun_kas5",$where);
		$this->db->delete("akun_kas6",$where);

		return true;
	}

	function get_single_akun_kas5($where,$field){

		$this->db->where($where);

		$query = $this->db->get('akun_kas5')->row();

		if(empty($field)){
			return $query ;
		}
		elseif($field=='nama'){
			return $query->nm_kas_5 ;
		}


	}
        
        function get_all_akun_kas5($where){

		$this->db->where($where);

		$query = $this->db->get('akun_kas5');

		return $query->result();

	}
        
        function get_akun_kas5_saldo(){
            
            $s = "SELECT akun_kas5.kd_kas_5,akun_kas6.kd_kas_6,akun_kas5.nm_kas_5,akun_kas6.nm_kas_6,saldo "
                    . "FROM akun_kas6 "
                    . "LEFT JOIN akun_kas5 ON akun_kas5.kd_kas_5 = SUBSTR(akun_kas6.kd_kas_6,1,5) "
                    . "LEFT JOIN kas_undip ON kas_undip.kd_akun_kas = akun_kas6.kd_kas_6 "
                    . "WHERE aktif = '1'" ;
            
            $s2 = "SELECT akun_kas5.kd_kas_5,akun_kas5.nm_kas_5,kas_undip.kd_akun_kas,saldo "
                    . "FROM akun_kas5 "
                    . "LEFT JOIN kas_undip ON SUBSTR(kas_undip.kd_akun_kas,1,5) = akun_kas5.kd_kas_5 "
                    . "WHERE aktif = '1' AND RIGHT(kas_undip.kd_akun_kas,1) = '1'" ;
            
//            echo $s2; die;
            $q = $this->db->query($s2);
//            var_dump($q->result());die;
            return $q->result();
            
        }
}
?>