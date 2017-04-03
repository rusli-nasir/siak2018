<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Akun_kas6_model extends CI_Model{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
/* -------------- Method ------------- */
	/*	Fungsi untuk mencari data subkomponen input	*/
	
	
	}
	
	function search_akun_kas6($kd_kas_2='', $kd_kas_3='', $kd_kas_4='', $kd_kas_5='', $kata_kunci='')
	{
		/*	Filter xss n sepecial char */
		$kata_kunci	= form_prep($kata_kunci);
		$where = "kd_kas_2 = '{$kd_kas_2}' AND kd_kas_3 = '{$kd_kas_3}' AND kd_kas_4 = '{$kd_kas_4}' 
		AND kd_kas_5='{$kd_kas_5}'";
		//var_dump ($where); die;
		if($kata_kunci!='')
		{
			$where .= " AND (kd_kas_6 LIKE '%{$kata_kunci}%' OR nm_kas_6 LIKE '%{$kata_kunci}%')";
		}
		$this->db->where($where);

		//var_dump($this->db->where($where));die;
		$this->db->order_by("kd_kas_6", "asc"); 
		/* running query	*/
		$query		= $this->db->get('akun_kas6');
		
		if ($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function get_max_kode($kd_kas_2='', $kd_kas_3='', $kd_kas_4='', $kd_kas_5='')
	{
		/* running query	*/
		$query		= $this->db->query("SELECT MAX(kd_kas_6) As kode FROM subkomponen_input WHERE kd_kas_2 = '{$kd_kas_2}' AND kd_kas_3 = '{$kd_kas_3}' AND kd_kas_4 = '{$kd_kas_4}' AND kd_kas_5 = '{$kd_kas_5}'");
		if ($query->num_rows()>0){
			$row = $query->row();
			$row = $row->kode + 1;
			switch(strlen($row))
			{
				case 3 : return $row; break;
				case 2 : return '0'.$row; break;
				case 1 : return '00'.$row; break;
				default : return '001'; break;
			}
		}else{
			return '001';
		}
	}
	/*
	function add_akun_kas6($kd_kas_6='',$nm_kas_6='',$kd_kas_5='',$kd_kas_3='',$kd_kas_4='',$kd_kas_2='')
	{
		$data = array(
				'kd_kas_6'	=>$kd_kas_6,
				'nm_kas_6'	=>$nm_kas_6,
				'kd_kas_5'		=>$kd_kas_5,
				'kd_kas_3'		=>$kd_kas_3,
				'kd_kas_4'		=>$kd_kas_4,
				'kd_kas_2'		=>$kd_kas_2,
				);
		running query	
		return $this->db->insert("akun_kas6",$data);
	}
	*/
	function get_akun_kas6($where=""){
		if(is_array($where)){
			$this->db->where($where);
			/*$this->db->where("kd_kas_5",$where["kd_kas_5"]);
			$this->db->where("kd_kas_4",$where["kd_kas_4"]);
			$this->db->where("kd_kas_3",$where["kd_kas_3"]);
			$this->db->where("kd_kas_2",$where["kd_kas_2"]);*/
		}
		
		$query = $this->db->get("akun_kas6");
		//var_dump($query);die;
		if ($query->num_rows() > 0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function add_akun_kas6($data){
		return $this->db->insert("akun_kas6",$data);
	}
	
	function edit_akun_kas6($data,$where){
		if(is_array($where)){
			$this->db->where("kd_kas_6",$where["kd_kas_6"]);
			$this->db->where("kd_kas_5",$where["kd_kas_5"]);
			$this->db->where("kd_kas_4",$where["kd_kas_4"]);
			$this->db->where("kd_kas_3",$where["kd_kas_3"]);
			$this->db->where("kd_kas_2",$where["kd_kas_2"]);
			
		}
		//var_dump($data);die;
		return $this->db->update("akun_kas6",$data);
	}
	
	function delete_akun_kas6($where){
		$this->db->delete("akun_kas6",$where);

		return true;;
	}

	// ADD IDRIS

	function get_single_subkomponen_ref_akun($where=""){

		$this->db->where($where);

		$this->db->join('ref_akun', 'subkomponen_input.biaya = ref_akun.kode_akun_sub');
		$query = $this->db->get("subkomponen_input");
		if ($query->num_rows() > 0){
			return $query->row();
		}else{
			return array();
		}
	}

	function get_single_akun_kas6($where,$field){

		$this->db->where($where);

		$query = $this->db->get('akun_kas6')->row();

		if(empty($field)){
			return $query ;
		}
		elseif($field=='nama'){
			return $query->nm_kas_6 ;
		}


	}
        
        function get_akun_kas6_saldo(){
           
            
            $s2 = "SELECT akun_kas6.kd_kas_6,akun_kas6.nm_kas_6,kas_undip.kd_akun_kas,saldo "
                    . "FROM akun_kas6 "
                    . "LEFT JOIN kas_undip ON kas_undip.kd_akun_kas = akun_kas6.kd_kas_6 "
                    . "WHERE aktif = '1' " ;
            
//            echo $s2; die;
            $q = $this->db->query($s2);
//            var_dump($q->result());die;
            return $q->result();
            
        }

}
?>
