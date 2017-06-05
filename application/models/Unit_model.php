<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Unit_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		
		#methods =======================
		
		//define method get_unit()
		function get_unit($where=""){
			if(!$where==""){
				$this->db->where('kode_unit',$where);
			}
			$this->db->order_by('kode_unit','asc');
			$query = $this->db->get('rsa_unit');
			if($query->num_rows()>0){
				return $query->result();			
			}
			else{
				return array();
			}
		}
		
		//define method edit_unit()
		function edit_unit($data, $where){
			$this->db->where('kode_unit',$where);
			return $this->db->update('rsa_unit',$data);
		}
		
		//define method delete_unit()
		function delete_unit($kode_unit){
			return $this->db->delete('rsa_unit',array('kode_unit'=>$kode_unit));
		}
		
		//define method add_unit()
		function add_unit($data){
			return $this->db->insert('rsa_unit',$data);
		}
		
		//define method search_unit()
		function search_unit($keyword=''){
			//filter xss and special character
			$keyword	= form_prep($keyword);
			if($keyword!='')
			{
				$this->db->like('kode_unit', $keyword);
				$this->db->or_like('nama_unit', $keyword); 
			}
			$this->db->order_by("kode_unit", "asc"); 
			$query		= $this->db->get('rsa_unit');
			if ($query->num_rows()>0){
				return $query->result();
			}else{
				return array();
			}
		}


		function get_single_unit($where="",$field){
                    
            $rba = $this->load->database('rba', TRUE);

			$rba->where('kode_unit',$where);

			$query = $rba->get('unit')->row();

			if(empty($field)){
				return $query ;
			}
			elseif($field=='nama'){
				return $query->nama_unit ;
			}

		}
                
                function get_alias($kd_unit){
                    
                        $rba = $this->load->database('rba', TRUE);
                        
                        if(strlen($kd_unit)==2){
                        
                            $rba->where('kode_unit',$kd_unit);

                            $query = $rba->get('unit')->row();

                            return $query->alias ;
                        }elseif(strlen($kd_unit)==4){
                          
                            $kode_unit_ = substr($kd_unit,0,2);
                            $kode_subunit = substr($kd_unit,2,2);
                            if($kode_unit_ == '41'){
                                switch ($kode_subunit){
                                    case '11'       : return 'W11'; break;
                                    case '12'       : return 'W12'; break;
                                    case '13'       : return 'W13'; break;
                                    case '14'       : return 'W14'; break;
                                }
                            }elseif($kode_unit_ == '42'){
                                switch ($kode_subunit){
                                    case '11'       : return 'W21'; break;
                                    case '12'       : return 'W22'; break;
                                    case '13'       : return 'W23'; break;
                                    case '14'       : return 'W24'; break;
                                }
                            }elseif($kode_unit_ == '43'){
                                switch ($kode_subunit){
                                    case '11'       : return 'W31'; break;
                                    case '12'       : return 'W32'; break;
                                    case '13'       : return 'W33'; break;
                                    case '14'       : return 'W34'; break;
                                }
                            }elseif($kode_unit_ == '44'){
                                switch ($kode_subunit){
                                    case '11'       : return 'W41'; break;
                                    case '12'       : return 'W42'; break;
                                    case '13'       : return 'W43'; break;
                                    case '14'       : return 'W44'; break;
                                }
                            }
                       }else{
                           
                       }
                }
                
                function get_real_nama($kd_unit){
                    
                        $rba = $this->load->database('rba', TRUE);
                        
                       if(strlen($kd_unit)==2){
                        
                            $rba->where('kode_unit',$kd_unit);

                            $query = $rba->get('unit')->row();

                            return $query->nama_unit ;
                       }elseif(strlen($kd_unit)==4){
                          
                            $rba->where('kode_subunit',$kd_unit);

                            $query = $rba->get('subunit')->row();

                            return $query->nama_subunit ; 
                       }else{
                           
                       }
                }
                function get_nama($kd_unit){
                    
                        $rba = $this->load->database('rba', TRUE);
                        
                       if(strlen($kd_unit)==4){
                          
                            $kd_unit = substr($kd_unit,0,2);
                       }
                       $rba->where('kode_unit',$kd_unit);

                        $query = $rba->get('unit')->row();

                        return $query->nama_unit ;
                }
                
                function get_nama_unit($kd_unit){
                    
                        $rba = $this->load->database('rba', TRUE);
      
                        $rba->where('kode_unit',$kd_unit);

                        $query = $rba->get('unit')->row();

                        return $query->nama_unit ;
                }
                
                function get_nama_subunit($kd_unit){
                    
                        $rba = $this->load->database('rba', TRUE);
      
                        $rba->where('kode_subunit',$kd_unit);

                        $query = $rba->get('subunit')->row();

                        return $query->nama_subunit ;
                }
                
                function get_nama_sub_subunit($kd_unit){
                    
                        $rba = $this->load->database('rba', TRUE);
      
                        $rba->where('kode_sub_subunit',$kd_unit);

                        $query = $rba->get('sub_subunit')->row();

                        return $query->nama_sub_subunit ;
                }

                function get_all_unit(){
                    $rba = $this->load->database('rba', TRUE);

                    $query = $rba->get('unit');

                    return $query->result() ;
                }

	}
?>
