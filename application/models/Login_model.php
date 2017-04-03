<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model {
/* -------------- Constructor ------------- */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
/* -------------- Method ------------- */
	/*	Fungsi untuk mengecek kevalidan user	*/
	function check_user(){
		/*	Filter xss n sepecial char */
		$username	= form_prep($this->input->post("username"));
		$password	= form_prep($this->input->post("password"));
		
		/* running query	*/
		$query		= $this->db->query("SELECT * FROM rsa_user WHERE username='{$username}' and password=sha1(sha1(md5('{$password}'))) and flag_aktif='ya'");
		if ($query->num_rows()==1){
			$row = $query->row();
			return ($row->username==$username)?TRUE:FALSE;
		}else{
			return FALSE;
		}
	}
	
	/*	Fungsi untuk mendapatkan data detail user	*/
	function get_detail_user($username,$password){
		/*	Filter xss n sepecial char */
		// $username	= form_prep($this->input->post("username"));
		// $password	= form_prep($this->input->post("password"));
		
		/* running query	*/
		$query		= $this->db->query("SELECT * FROM rsa_user WHERE username='{$username}' and password=sha1(sha1(md5('{$password}'))) and flag_aktif='ya'");
		//var_dump($query->result());die;
		return $query->result();
	}
	
	/*	Fungsi untuk mendapatkan nama user	*/
	function get_nama_user($ori_username='',$level=''){
		
                if(($level==1)||($level==11)||($level==3)||($level==5)){	// jika user yang aktif unit pusat
			return	'Unit Pusat';
		}
		else{
			if($level==2){	// jika user yang aktif unit
				/*	Set table name n field*/
                            if(strlen($ori_username) == '2'){
				$table	= 'rba.unit';
				$field	= 'kode_unit';
				$result	= 'nama_unit';
				$value	= $ori_username;
                            }elseif(strlen($ori_username) == '4'){
                                $table	= 'rba.subunit';
				$field	= 'kode_subunit';
				$result	= 'nama_subunit';
				$value	= $ori_username;
                            }else{
                                
                            }
			}else if($level==13){	// jika user yang aktif sub unit
				/*	Set table name n field*/
                            if(strlen($ori_username) == '2'){
				$table	= 'rba.unit';
				$field	= 'kode_unit';
				$result	= 'nama_unit';
				$value	= $ori_username;
                            }elseif(strlen($ori_username) == '4'){
                                $table	= 'rba.subunit';
				$field	= 'kode_subunit';
				$result	= 'nama_subunit';
				$value	= $ori_username;
                            }else{
                                
                            }
			}else if($level==14){	// jika user yang aktif sub unit
				/*	Set table name n field*/
				if(strlen($ori_username) == '2'){
				$table	= 'rba.unit';
				$field	= 'kode_unit';
				$result	= 'nama_unit';
				$value	= $ori_username;
                            }elseif(strlen($ori_username) == '4'){
                                $table	= 'rba.subunit';
				$field	= 'kode_subunit';
				$result	= 'nama_subunit';
				$value	= $ori_username;
                            }else{
                                
                            }
			}else if ($level==4){ // PUMK USER VARIASI 4 dan 6 DIGIT
                            if(strlen($ori_username) == '2'){
				$table	= 'rba.unit';
				$field	= 'kode_unit';
				$result	= 'nama_unit';
				$value	= $ori_username;
                            }elseif(strlen($ori_username) == '4'){
                                if((substr($ori_username,0,2)=='41')||(substr($ori_username,0,2)=='42')||(substr($ori_username,0,2)=='43')||(substr($ori_username,0,2)=='44')){
                                    $table	= 'rba.subunit';
                                    $field	= 'kode_subunit';
                                    $result	= 'nama_subunit';
                                    $value	= $ori_username;
                                }else{
                                    $table	= 'rba.subunit';
                                    $field	= 'kode_subunit';
                                    $result	= 'nama_subunit';
                                    $value	= $ori_username;
                                }
                            }elseif(strlen($ori_username) == '6'){
                                if((substr($ori_username,0,2)=='41')||(substr($ori_username,0,2)=='42')||(substr($ori_username,0,2)=='43')||(substr($ori_username,0,2)=='44')){
                                    $table	= 'rba.sub_subunit';
                                    $field	= 'kode_sub_subunit';
                                    $result	= 'nama_sub_subunit';
                                    $value	= $ori_username;
                                }else{
                                    $table	= 'rba.sub_subunit';
                                    $field	= 'kode_sub_subunit';
                                    $result	= 'nama_sub_subunit';
                                    $value	= $ori_username;
                                }
                            }else{
                                
                            }
                       
			}
//                        else if ($level==15){
//				$table	= 'rba.unit';
//				$field	= 'kode_unit';
//				$value	= $ori_username;
//				$result	= 'nama_unit';
//                        }
//			else if($level==31){	// jika user yang aktif sub sub unit ADDED BY IDRIS
//				/*	Set table name n field*/
//				$table	= 'sub_subunit';
//				$field	= 'kode_sub_subunit';
//				$value	= $ori_username;
//				$result	= 'nama_sub_subunit';
//			}
                        else if ($level==100){
				return 'REKTOR';
			}
			
			/*	Running query	*/
			$query		= $this->db->query("SELECT {$result} FROM {$table} WHERE {$field}='{$value}'");
			//var_dump($query);die;
			if ($query->num_rows() > 0){
			   foreach ($query->result() as $row)
			   {
				  return $row->$result;
			   }
			}else{
				return '';
			}
		}
	}
        
        function get_alias_user($ori_username='',$level=''){
        if(($level==1)||($level==11)||($level==3)||($level==5)){	
			return	'Unit Pusat';
		}
		else{
			if($level==2){	// jika user yang aktif unit
				/*	Set table name n field*/
                            
                            if(strlen($ori_username) == 2){
				$table	= 'rba.unit';
				$field	= 'kode_unit';
				$result	= 'alias';
				$value	= $ori_username;
                            }elseif(strlen($ori_username) == 4){
                                $table	= 'rba.subunit';
				$field	= 'kode_subunit';
				$result	= 'nama_subunit';
				$value	= $ori_username;
                            }else{
                                
                            }
				
			}else if($level==13){	// jika user yang aktif sub unit
				/*	Set table name n field*/
                            if(strlen($ori_username) == 2){
                				$table	= 'rba.unit';
                				$field	= 'kode_unit';
                				$result	= 'alias';
                				$value	= $ori_username;
                            }elseif(strlen($ori_username) == 4){
                                $table	= 'rba.subunit';
                				$field	= 'kode_subunit';
                				$result	= 'nama_subunit';
                				$value	= $ori_username;
                            }else{
                                
                            }
			}else if($level==14){	// jika user yang aktif sub unit
				/*	Set table name n field*/
                            if(strlen($ori_username) == 2){
				$table	= 'rba.unit';
				$field	= 'kode_unit';
				$result	= 'alias';
				$value	= $ori_username;
                            }elseif(strlen($ori_username) == 4){
                                $table	= 'rba.subunit';
				$field	= 'kode_subunit';
				$result	= 'nama_subunit';
				$value	= $ori_username;
                            }else{
                                
                            }
			}else if($level==4){ // PUMK USER VARIASI 4 dan 6 DIGIT	// jika user yang aktif sub unit
				/*	Set table name n field*/
                            if(strlen($ori_username) == 2){
                				$table	= 'rba.unit';
                				$field	= 'kode_unit';
                				$result	= 'alias';
                				$value	= $ori_username;
                            }elseif(strlen($ori_username) == 4){
                                if((substr($ori_username,0,2)=='41')||(substr($ori_username,0,2)=='42')||(substr($ori_username,0,2)=='43')||(substr($ori_username,0,2)=='44')){
                                    $table	= 'rba.subunit';
                                    $field	= 'kode_subunit';
                                    $result	= 'nama_subunit';
                                    $value	= $ori_username;
                                }else{
                                    $table	= 'rba.unit';
                                    $field	= 'kode_unit';
                                    $result	= 'alias';
                                    $value	= substr($ori_username,0,2);
                                }
                            }elseif(strlen($ori_username) == 6){
                                if((substr($ori_username,0,2)=='41')||(substr($ori_username,0,2)=='42')||(substr($ori_username,0,2)=='43')||(substr($ori_username,0,2)=='44')){
                                    $table	= 'rba.sub_subunit';
                                    $field	= 'kode_sub_subunit';
                                    $result	= 'nama_sub_subunit';
                                    $value	= $ori_username;
                                }else{
                                    $table	= 'rba.unit';
                                    $field	= 'kode_unit';
                                    $result	= 'alias';
                                    $value	= substr($ori_username,0,2);
                                }
                            }else{
                                
                            }
			}
//			else if($level==31){	// jika user yang aktif sub sub unit ADDED BY IDRIS
//				/*	Set table name n field*/
//				$table	= 'sub_subunit';
//				$field	= 'kode_sub_subunit';
//				$value	= $ori_username;
//				$result	= 'nama_sub_subunit';
//			}
            else if ($level==15){
				$table	= 'rba.unit';
				$field	= 'kode_unit';
				$value	= $ori_username;
				$result	= 'nama_unit';
                        
			}else if ($level==100){
				return 'TESTER';
			}
			
			/*	Running query	*/
			$query		= $this->db->query("SELECT {$result} FROM {$table} WHERE {$field}='{$value}'");
            // echo "SELECT {$result} FROM {$table} WHERE {$field}='{$value}'" ; 
			// var_dump($query->result());die;
			if ($query->num_rows() > 0){
			   foreach ($query->result() as $row)
			   {
                               if(strlen($ori_username) == 2){
                                   return $row->$result;
                               }elseif(strlen($ori_username) == 4){
                                    if(substr($ori_username,0,2) == '41'){
                                        switch ($row->$result){
                                            case 'BAA'     : return 'W11'; break;
                                            case 'BAK'     : return 'W12'; break;
                                            case 'BAUK'    : return 'W13'; break;
                                            case 'BAPSI'   : return 'W14'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '42'){
                                        switch ($row->$result){
                                            case 'BAA'     : return 'W21'; break;
                                            case 'BAK'     : return 'W22'; break;
                                            case 'BAUK'    : return 'W23'; break;
                                            case 'BAPSI'   : return 'W24'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '43'){
                                        switch ($row->$result){
                                            case 'BAA'     : return 'W31'; break;
                                            case 'BAK'     : return 'W32'; break;
                                            case 'BAUK'    : return 'W33'; break;
                                            case 'BAPSI'   : return 'W34'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '44'){
                                        switch ($row->$result){
                                            case 'BAA'     : return 'W41'; break;
                                            case 'BAK'     : return 'W42'; break;
                                            case 'BAUK'    : return 'W43'; break;
                                            case 'BAPSI'   : return 'W44'; break;
                                        }
                                    }else{
                                        return $row->$result;
                                    }
                               }elseif(strlen($ori_username) == 6){
                                    if(substr($ori_username,0,2) == '41'){
                                        switch (substr($ori_username,0,4)){
                                            case '4111'    : return 'W11'; break;
                                            case '4113'    : return 'W12'; break;
                                            case '4112'    : return 'W13'; break;
                                            case '4114'    : return 'W14'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '42'){
                                        switch (substr($ori_username,0,4)){
                                            case '4211'    : return 'W21'; break;
                                            case '4213'    : return 'W22'; break;
                                            case '4212'    : return 'W23'; break;
                                            case '4214'    : return 'W24'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '43'){
                                        switch (substr($ori_username,0,4)){
                                            case '4311'    : return 'W31'; break;
                                            case '4313'    : return 'W32'; break;
                                            case '4312'    : return 'W33'; break;
                                            case '4314'    : return 'W34'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '44'){
                                        switch (substr($ori_username,0,4)){
                                            case '4411'    : return 'W41'; break;
                                            case '4413'    : return 'W42'; break;
                                            case '4412'    : return 'W43'; break;
                                            case '4414'    : return 'W44'; break;
                                        }
                                    }else{
                                        return $row->$result;
                                    }
                               }else{
                                   
                               }
				  
			   }
			}else{
				return '';
			}
		}
	}
	
	function get_old_password($data){
		$this->db->where('username',$data);
		$result = $this->db->get('rsa_user');
		return $result->result();
	}
	
	function set_new_password($kode,$data){
		$this->db->where('username',$kode);
		$this->db->update('rsa_user',$data);
		return TRUE;
	}
	
}
?>
