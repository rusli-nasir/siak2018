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
		
        if(($level==1)||($level==11)||($level==3)||($level==5)||($level==17)||($level==55)){	// jika user yang aktif unit pusat
			return	'Unit Pusat';
		}
		else{
			if($level==2){	// KPA
				/*	Set table name n field*/
                            if(strlen($ori_username) == '2'){
                				$table	= 'rba_2018.unit';
                				$field	= 'kode_unit';
                				$result	= 'nama_unit';
                				$value	= $ori_username;
                            }elseif(strlen($ori_username) == '4'){
                                $table	= 'rba_2018.subunit';
                				$field	= 'kode_subunit';
                				$result	= 'nama_subunit';
                				$value	= $ori_username;
                            }else{
                                
                            }
			}else if($level==13){	// BENDAHARA
				/*	Set table name n field*/
                            if(strlen($ori_username) == '2'){
                				$table	= 'rba_2018.unit';
                				$field	= 'kode_unit';
                				$result	= 'nama_unit';
                				$value	= $ori_username;
                            }elseif(strlen($ori_username) == '4'){
                                $table	= 'rba_2018.subunit';
                				$field	= 'kode_subunit';
                				$result	= 'nama_subunit';
                				$value	= $ori_username;
                            }else{
                                
                            }
			}else if($level==14){	// PPK SUKPA
				/*	Set table name n field*/
				if(strlen($ori_username) == '2'){
				$table	= 'rba_2018.unit';
				$field	= 'kode_unit';
				$result	= 'nama_unit';
				$value	= $ori_username;
                            }elseif(strlen($ori_username) == '4'){
                                $table	= 'rba_2018.subunit';
				$field	= 'kode_subunit';
				$result	= 'nama_subunit';
				$value	= $ori_username;
                            }else{
                                
                            }
			}else if ($level==4){ // PUMK USER VARIASI 4 dan 6 DIGIT
                            if(strlen($ori_username) == '2'){
				$table	= 'rba_2018.unit';
				$field	= 'kode_unit';
				$result	= 'nama_unit';
				$value	= $ori_username;
                            }elseif(strlen($ori_username) == '4'){
                                if((substr($ori_username,0,2)=='14')||(substr($ori_username,0,2)=='15')||(substr($ori_username,0,2)=='16')||(substr($ori_username,0,2)=='17')){
                                    $table	= 'rba_2018.subunit';
                                    $field	= 'kode_subunit';
                                    $result	= 'nama_subunit';
                                    $value	= $ori_username;
                                }else{
                                    $table	= 'rba_2018.subunit';
                                    $field	= 'kode_subunit';
                                    $result	= 'nama_subunit';
                                    $value	= $ori_username;
                                }
                            }elseif(strlen($ori_username) == '6'){
                                if((substr($ori_username,0,2)=='14')||(substr($ori_username,0,2)=='15')||(substr($ori_username,0,2)=='16')||(substr($ori_username,0,2)=='17')){
                                    $table	= 'rba_2018.sub_subunit';
                                    $field	= 'kode_sub_subunit';
                                    $result	= 'nama_sub_subunit';
                                    $value	= $ori_username;
                                }else{
                                    $table	= 'rba_2018.sub_subunit';
                                    $field	= 'kode_sub_subunit';
                                    $result	= 'nama_sub_subunit';
                                    $value	= $ori_username;
                                }
                            }else{
                                
                            }
                       
			}
            else if ($level==100){
				return 'REKTOR';
			}else{
                echo 'MAAF ANDA TIDAK BISA LOGIN <a href="' . base_url() . '">KEMBALI</a>' ;
                die;
            }
			
			/*	Running query	*/

            // echo "SELECT {$result} FROM {$table} WHERE {$field}='{$value}'"; die;

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
        if(($level==1)||($level==11)||($level==3)||($level==5)||($level==17)||($level==55)){	
			return	'Unit Pusat';
		}
		else{
			if($level==2){	// jika user yang aktif unit
				/*	Set table name n field*/
                            
                            if(strlen($ori_username) == 2){
				$table	= 'rba_2018.unit';
				$field	= 'kode_unit';
				$result	= 'alias';
				$value	= $ori_username;
                            }elseif(strlen($ori_username) == 4){
                                $table	= 'rba_2018.subunit';
				$field	= 'kode_subunit';
				$result	= 'nama_subunit';
				$value	= $ori_username;
                            }else{
                                
                            }
				
			}else if($level==13){	// jika user yang aktif sub unit
				/*	Set table name n field*/
                            if(strlen($ori_username) == 2){
                				$table	= 'rba_2018.unit';
                				$field	= 'kode_unit';
                				$result	= 'alias';
                				$value	= $ori_username;
                            }elseif(strlen($ori_username) == 4){
                                $table	= 'rba_2018.subunit';
                				$field	= 'kode_subunit';
                				$result	= 'nama_subunit';
                				$value	= $ori_username;
                            }else{
                                
                            }
			}else if($level==14){	// jika user yang aktif sub unit
				/*	Set table name n field*/
                            if(strlen($ori_username) == 2){
				$table	= 'rba_2018.unit';
				$field	= 'kode_unit';
				$result	= 'alias';
				$value	= $ori_username;
                            }elseif(strlen($ori_username) == 4){
                                $table	= 'rba_2018.subunit';
				$field	= 'kode_subunit';
				$result	= 'nama_subunit';
				$value	= $ori_username;
                            }else{
                                
                            }
			}else if($level==4){ // PUMK USER VARIASI 4 dan 6 DIGIT	// jika user yang aktif sub unit
				/*	Set table name n field*/
                            if(strlen($ori_username) == 2){
                				$table	= 'rba_2018.unit';
                				$field	= 'kode_unit';
                				$result	= 'alias';
                				$value	= $ori_username;
                            }elseif(strlen($ori_username) == 4){
                                if((substr($ori_username,0,2)=='14')||(substr($ori_username,0,2)=='15')||(substr($ori_username,0,2)=='16')||(substr($ori_username,0,2)=='17')){
                                    $table	= 'rba_2018.subunit';
                                    $field	= 'kode_subunit';
                                    $result	= 'nama_subunit';
                                    $value	= $ori_username;
                                }else{
                                    $table	= 'rba_2018.unit';
                                    $field	= 'kode_unit';
                                    $result	= 'alias';
                                    $value	= substr($ori_username,0,2);
                                }
                            }elseif(strlen($ori_username) == 6){
                                if((substr($ori_username,0,2)=='14')||(substr($ori_username,0,2)=='15')||(substr($ori_username,0,2)=='16')||(substr($ori_username,0,2)=='17')){
                                    $table	= 'rba_2018.sub_subunit';
                                    $field	= 'kode_sub_subunit';
                                    $result	= 'nama_sub_subunit';
                                    $value	= $ori_username;
                                }else{
                                    $table	= 'rba_2018.unit';
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
				$table	= 'rba_2018.unit';
				$field	= 'kode_unit';
				$value	= $ori_username;
				$result	= 'nama_unit';
                        
			}
			else if ($level==100){
				return 'TESTER';
			}
			
			/*	Running query	*/
			$query		= $this->db->query("SELECT {$result} FROM {$table} WHERE {$field}='{$value}'");
            // echo "SELECT {$result} FROM {$table} WHERE {$field}='{$value}'" ; die;
			// var_dump($query->result());die;
			if ($query->num_rows() > 0){
			   foreach ($query->result() as $row)
			   {
                               if(strlen($ori_username) == 2){
                                   return $row->$result;
                               }elseif(strlen($ori_username) == 4){
                                    if(substr($ori_username,0,2) == '14'){
                                        switch ($row->$result){
                                            case 'Biro Administrasi Akademik'     : return 'W11'; break;
                                            case 'Biro Administrasi Umum dan Keuangan'     : return 'W12'; break;
                                            case 'Biro Administrasi Kemahasiswaan'    : return 'W13'; break;
                                            case 'Biro Administrasi Perencanaan dan Sistem Informasi'   : return 'W14'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '15'){
                                        switch ($row->$result){
                                            case 'Biro Administrasi Akademik'    : return 'W21'; break;
                                            case 'Biro Administrasi Umum dan Keuangan'    : return 'W22'; break;
                                            case 'Biro Administrasi Kemahasiswaan'    : return 'W23'; break;
                                            case 'Biro Administrasi Perencanaan dan Sistem Informasi'    : return 'W24'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '16'){
                                        switch ($row->$result){
                                            case 'Biro Administrasi Akademik'     : return 'W31'; break;
                                            case 'Biro Administrasi Umum dan Keuangan'    : return 'W32'; break;
                                            case 'Biro Administrasi Kemahasiswaan'     : return 'W33'; break;
                                            case 'Biro Administrasi Perencanaan dan Sistem Informasi'    : return 'W34'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '17'){
                                        switch ($row->$result){
                                            case 'Biro Administrasi Akademik'    : return 'W41'; break;
                                            case 'Biro Administrasi Umum dan Keuangan'     : return 'W42'; break;
                                            case 'Biro Administrasi Kemahasiswaan'    : return 'W43'; break;
                                            case 'Biro Administrasi Perencanaan dan Sistem Informasi'    : return 'W44'; break;
                                        }
                                    }else{
                                        return $row->$result;
                                    }
                               }elseif(strlen($ori_username) == 6){
                                    if(substr($ori_username,0,2) == '14'){
                                        switch (substr($ori_username,0,4)){
                                            case '1401'    : return 'W11'; break;
                                            case '1402'    : return 'W12'; break;
                                            case '1403'    : return 'W13'; break;
                                            case '1404'    : return 'W14'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '15'){
                                        switch (substr($ori_username,0,4)){
                                            case '1501'    : return 'W21'; break;
                                            case '1502'    : return 'W22'; break;
                                            case '1503'    : return 'W23'; break;
                                            case '1504'    : return 'W24'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '16'){
                                        switch (substr($ori_username,0,4)){
                                            case '1601'    : return 'W31'; break;
                                            case '1602'    : return 'W32'; break;
                                            case '1603'    : return 'W33'; break;
                                            case '1604'    : return 'W34'; break;
                                        }
                                    }elseif(substr($ori_username,0,2) == '17'){
                                        switch (substr($ori_username,0,4)){
                                            case '1701'    : return 'W41'; break;
                                            case '1702'    : return 'W42'; break;
                                            case '1703'    : return 'W43'; break;
                                            case '1704'    : return 'W44'; break;
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
