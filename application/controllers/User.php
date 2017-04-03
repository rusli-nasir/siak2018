<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


    public function __construct()
    {
            parent::__construct();
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model('user_model');
		$this->load->model('menu_model');
		$this->load->model('login_model');
	}

/* -------------- Method ------------- */
	function index()
	{
		/* check session	*/
		if($this->check_session->user_session()){
			redirect('user/daftar_user/','refresh');
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

	function daftar_user()
	{
		/* check session	*/
		if($this->check_session->user_session() && ( ($this->check_session->get_level()==100)||($this->check_session->get_level()==11)) ){
			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			$tahun = $this->setting_model->get_tahun();
			//$data['main_content']	= $this->load->view('main_content','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);
			$subdata['cur_tahun'] = $tahun;
			$subdata_user['result_user'] 		= $this->user_model->search_user();
			$subdata['row_user'] 				= $this->load->view("rsa_user/row_user",$subdata_user,TRUE);
			$subdata['aktif']					= $this->option->flag_aktif();
			$subdata['level']					= $this->option->user_level();
			$subdata['opt_subunit']				= $this->user_model->get_subunit2();
			$data['main_content'] 				= $this->load->view("rsa_user/daftar_user",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($data);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

	/* Method untuk filter data user */
	function filter_user(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==11 || $this->check_session->get_level()==2)){
			$keyword = form_prep($this->input->post("keyword"));
			$data['result_user'] = $this->user_model->search_user($keyword);
			$this->load->view("rsa_user/row_user",$data);
		}else{
			show_404('page');
		}
	}
	function load_subunit(){
		//if(in_array(intval($_POST['subunit']),array(41,42,43,44))){
			$cn = $this->load->database('rba', TRUE);
			$q = $cn->query("SELECT * FROM subunit WHERE kode_subunit LIKE '".$_POST['subunit']."%'");
			$dt = $q->result();
			// echo $dt->kode_subunit."-".$dt->nama_subunit;
			$html = "";
			if(count($dt)>0){
				foreach ($dt as $k => $v) {
					$s = "";
					if(isset($_POST['kd_pisah']) && $_POST['kd_pisah'] == $v->kode_subunit){
						$s = " selected=\"selected\"";
					}
					$html.="<option value=\"".$v->kode_subunit."\"".$s.">".$v->kode_subunit." - ".$v->nama_subunit."</option>";
				}
			}
			echo $html;
		//}
	}

	/* Method untuk refresh row data user */
	function get_row_user(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==11 || $this->check_session->get_level()==2)){
			$data['result_user'] = $this->user_model->search_user();
			$this->load->view("rsa_user/row_user",$data);
		}else{
			show_404('page');
		}
	}

	function confirmation_delete(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==11 || $this->check_session->get_level()==2)){
			if($this->uri->segment(3)!='9999'){
				$data['url']		= site_url('user/exec_delete/'.$this->uri->segment(3));
				$data['message']	= "Apakah anda yakin akan menghapus data ini?";
				$this->load->view('confirmation_',$data);
			}else{
				$data['class']	 = 'option box';
				$data['class_btn']	 = 'ya';
				$data['message'] = 'User admin tidak diijinkan dihapus';
				$this->load->view('messagebox_',$data);
			}
		}else{
			show_404('page');
		}
	}

	/* Method untuk mengeksekusi hapus data user */
	function exec_delete(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==11)){
			if($this->uri->segment(3)){
				if($this->user_model->delete_user($this->uri->segment(3))){
					$data['class']	 = 'option box';
					$data['class_btn']	 = 'ya';
					$data['message'] = 'Data berhasil dihapus';
				}else{
					$data['class']	 = 'boxerror';
					$data['class_btn']	 = 'tidak';
					$data['message'] = 'Data gagal dihapus';
				}
			}else{
				$data['class']	 = 'boxerror';
				$data['class_btn']	 = 'tidak';
				$data['message'] = 'Tidak ada data yang dihapus';
			}
			$this->load->view('messagebox_',$data);
		}else{
			show_404('page');
		}
	}

	/* Method untuk mengeksekusi tambah data user */
	function exec_add_user(){

		if($this->input->post()){
			if($this->check_session->user_session() && $this->check_session->get_level()==11){

				$this->form_validation->set_rules('user_username','Username','required|is_unique[rsa_user.username]|alpha_dash|min_length[2]|max_length[30]'); // KAMPRET LENGTH DADI LENGHT
				$this->form_validation->set_rules('user_password','Password','required');
				$this->form_validation->set_rules('level','Level','required');
				$this->form_validation->set_rules('subunit','Unit / Sub Unit','required');
				$this->form_validation->set_rules('flag_aktif','Aktif','required');
				//$this->form_validation->set_rules('nm_lengkap','Nama Lengkap','required');
				//$this->form_validation->set_rules('nomor_induk','Nomor Induk','required');
				//$this->form_validation->set_rules('no_rek','Nomor Rekening','required');
				//$this->form_validation->set_rules('npwp','NPWP','required');
				//$this->form_validation->set_message('is_unique', 'Maaf, {field} dengan sudah terdaftar');

				if ($this->form_validation->run()){
					if ($this->input->post("level")==2){
						$kode_unit_subunit = substr($this->input->post("subunit"),0,2);
					}
					else {
						$kode_unit_subunit = $this->input->post("subunit");
					}

					$data = array(
						"username" 			=> $this->input->post("user_username"),
						"password"			=> sha1(sha1(md5($this->input->post("user_password")))),
						"level"				=> $this->input->post("level"),
						"kode_unit_subunit"	=> $kode_unit_subunit,
						"flag_aktif"		=> $this->input->post("flag_aktif"),
						"nm_lengkap"		=> $this->input->post("nm_lengkap"),
						"nomor_induk"		=> $this->input->post("nomor_induk"),
						"no_rek"			=> $this->input->post("no_rek"),
						"npwp"				=> $this->input->post("npwp"),
						//"kd_pisah"			=> $this->input->post("kd_pisah"),
					);

					$this->user_model->add_user($data);
					echo "berhasil";
				} else {
					echo validation_errors();
				}

			}else{
				show_404('page');
			}
		}
	}

	/* Method untuk menampilkan form edit data user */
	function get_form_edit(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==100 || $this->check_session->get_level()==11)){

			$username 				= form_prep($this->input->post("user_username"));
			$data['aktif']			= $this->option->flag_aktif();
			$data['level']			= $this->option->user_level();
			$data['revisi']			= $this->option->user_revisi();
			$data['opt_subunit']	= $this->user_model->get_subunit2();
			$result					= $this->user_model->search_user($username,'','id');
			$data['result_user'] 	= $result;
			//if (strlen($result[0]->kode_unit_subunit)==2){
			//	$data['subunit'] = $result[0]->kode_unit_subunit."99";
			//}
			$this->load->view('rsa_user/form_edit_user',$data);
		}else{
			show_404('page');
		}
	}

	/* Method untuk mengeksekusi edit data user */
	function exec_edit_user(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==11 || $this->check_session->get_level()==2)){
				$this->form_validation->set_rules('user_username','Username','required|alpha_dash|min_length[2]|max_length[30]');
				$this->form_validation->set_rules('level','Level','required');
				$this->form_validation->set_rules('subunit','Unit / Sub Unit','required');
				//$this->form_validation->set_rules('user_revisi','Revisi','required');
				$this->form_validation->set_rules('flag_aktif','Aktif','required');

				if ($this->form_validation->run()){

				$username = $this->input->post("user_username");
				if ($this->input->post("level")==2){
					$kode_unit_subunit = substr($this->input->post("subunit"),0,2);
				} else {
					$kode_unit_subunit = $this->input->post("subunit");
				}

				$data_edit = array(
					"level"				=> $this->input->post("level"),
					"kode_unit_subunit"	=> $kode_unit_subunit,
					"flag_aktif"		=> $this->input->post("flag_aktif"),
					"nm_lengkap"		=> $this->input->post("nm_lengkap"),
					"nomor_induk"		=> $this->input->post("nomor_induk"),
					"nama_bank"		=> $this->input->post("nama_bank"),
					"no_rek"		=> $this->input->post("no_rek"),
					"npwp"		=> $this->input->post("npwp"),
					"alamat"		=> $this->input->post("alamat"),
					//"kd_pisah"		=> $this->input->post("kd_pisah"),
				);
				if ($this->input->post("user_password")!=""){
					$data_edit["password"] = sha1(sha1(md5($this->input->post("user_password"))));
				}
				$this->user_model->edit_user($data_edit,$username);
				echo "berhasil";
				} else {
					echo validation_errors();
				}
				//$data["result_user"] = $this->user_model->search_user($username,'id');
				//$this->load->view('row_user',$data);
		}
		else{
				show_404('page');
		}
	}

	function non_aktif(){
		$this->user_model->non_aktif();
	}

	function aktif(){
		$this->user_model->aktif();
	}

	function print_user(){
		$this->load->library('html_to_doc');

		$html ="";
		$name = "";

		$data_user = $this->user_model->search_user();
		$data['data_user'] = $data_user;
		$html = $this->load->view('print_user_',$data,true);

		$name = "user_RBA_UNDIP".(date("m_d_Y.H_i_s")).".doc";

		$this->html_to_doc->createDoc($html,$name,true);
	}


	function show_user(){
		$data['message'] = 'Anda login sebagai : ' . $this->check_session->get_nama_unit() ;
		$this->load->view('messagebox_',$data);
	}

		/*-- define constructor --*/
	function Ubah_password(){
		// print_r($_SESSION); exit;
		$this->load->model('login_model');
		$tahun = $this->setting_model->get_tahun();

		if($this->check_session->user_session()){
			$subdata['msg'] = '';
			$subdata['cur_tahun'] = $tahun;
			if($this->input->post()){
				$username = $this->check_session->get_username();
				$result = $this->login_model->get_old_password($username);
				$old_pass_db = $result[0]->password;
				//var_dump($result);die;
				//define rules validation for input value
				$this->form_validation->set_rules('old_pass','Password Lama','required|xss_clean');
				$this->form_validation->set_rules('new_pass','Password Baru','required|xss_clean');

				if($this->form_validation->run()==TRUE){ //check validation == true ??
					$old_pass_input = sha1(sha1(md5($this->input->post('old_pass')))); //encrypt new password
					$new_pass = $this->input->post('new_pass');
					$retype_pass = $this->input->post('retype_pass');

					if($old_pass_db == $old_pass_input){ //check old password == old password from input value ??
						if($new_pass == $retype_pass){ //check new password == retyped password ??
							$data = array('password'=>sha1(sha1(md5($new_pass))));
							$status = $this->login_model->set_new_password($username,$data);
							if($status){ //if new password has been saved in database
								$subdata['message'] = '<div class="alert alert-success" style="text-align:center">Password berhasil diubah</div>';
							}
						}
						else{ //set error message if new password =/= retyped password
							$subdata['message'] = '<div class="alert alert-danger" style="text-align:center">Password yang Anda ketikan tidak sama</div>';
						}
					}
					else{ //set error message if old password =/= old password from input value
						$subdata['message']= '<div class="alert alert-danger" style="text-align:center">Password lama Anda tidak sesuai</div>';
					}
				}
				else{ //set error message if input value not valid or empty input value
					$subdata['message'] = '<div class="alert alert-danger" style="text-align:center">Semua form harus diisi</div>';
				}
			}

			/*	Set data untuk main template */

			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			//$data['main_content']	= $this->load->view('main_content','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);
			$data['main_content'] 	= $this->load->view("rsa_user/form_ubah_password_",$subdata,TRUE);
			$this->load->view('main_template',$data);
		}
		else{ // user not login, cannot access ubah password, redirect to home page
			redirect('welcome','refresh');
		}


	}
	function Ubah_data(){
		//$this->load->model('login_model');
		if($this->check_session->user_session()){
			$username = $this->check_session->get_username();
			$level = $this->check_session->get_level();

			$subdata['msg'] = '';
			if($this->input->post()){
				$this->form_validation->set_rules('nm_lengkap','Nama Lengkap','required');
				$this->form_validation->set_rules('nomor_induk','Nomor Induk','required');
				//$this->form_validation->set_rules('no_rek','Nomor Rekening','required|is_unique');
				/*$this->form_validation->set_rules('nama_bank','Nama Bank','required');
				$this->form_validation->set_rules('npwp','NPWP','required');
				$this->form_validation->set_rules('alamat','Alamat','required');*/
				//$this->form_validation->set_message('is_unique', 'Maaf, {field} dengan sudah terdaftar');
				if($this->form_validation->run()==TRUE){
					$data_edit = array(
						"nm_lengkap" => $this->input->post('nm_lengkap'),
						"nomor_induk" => $this->input->post('nomor_induk'),
						"no_rek" => $this->input->post('no_rek'),
						"nama_bank" => $this->input->post('nama_bank'),
						"npwp" => $this->input->post('npwp'),
						"alamat" => $this->input->post('alamat'),
					);
					//var_dump($data_edit);die;
						$this->user_model->edit_user($data_edit,$username);
						//var_dump($username);die;
						$subdata['message'] = '<div class="alert alert-success" style="text-align:center">Data berhasil diubah</div>';
					}else {
						$subdata['message'] = '<div class="alert alert-success" style="text-align:center">Data Update Error</div>';
					}
				}

			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			//$data['main_content']	= $this->load->view('main_content','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);
			$subdata['result_user']  = $this->user_model->get_detail_edit_user($username,$level);
			//var_dump($subdata['result_user']);die;
			$data['main_content'] 	= $this->load->view("rsa_user/form_ubah_data",$subdata,TRUE);
			$this->load->view('main_template',$data);
		}
		else{ // user not login, cannot access ubah password, redirect to home page
			redirect('welcome','refresh');
		}



	}

	function check_username_exist($str){
		var_dump($str);die;
	}


	function logout(){
		session_unset();	/*	Unset User Session	*/
		session_destroy();	/*	Destroy User Session	*/
		redirect('welcome','refresh');	/*	Redirect to home page	*/
	}

	function remove_any_problems($text){
		// hancurkan seluruh musuh dalam scripting
		if(strlen(trim($text))>0 && strpos($text,'%')===false && strpos($text,'\\')===false){ 
			return true;
		}
		return false;
	}

	// EDIT BY IDRIS

	function login(){

		$this->form_validation->set_rules('username','username','callback_check_user');
		$this->form_validation->set_rules('password','password','xss_clean');
                
//                
//                    var_dump($this->input->post('username'));die;
		if($this->input->post('username') || $this->input->post('password')){

			if($this->form_validation->run()==TRUE){	/*	Run validasi jika Benar	*/
				if($this->remove_any_problems($this->input->post('username'))){
					/*	Get data user	*/
					$hasil	= $this->login_model->get_detail_user($this->input->post('username'),$this->input->post('password'));
	//				 var_dump($this->input->post('username'));die;
//                                        var_dump($hasil);die;
					if(count($hasil)>0){

						$row = $hasil[0];
						$username		= $row->username;
						$level			= $row->level;
						$kode			= $row->kode_unit_subunit;
						$kd_pisah   = $row->kd_pisah;

					}
                                        
                                        $kode = $row->kode_unit_subunit;
                                        
//                                        echo $kode ; die;

					$nama_unit = $this->login_model->get_nama_user($kode,$level);
					
	                                $alias = $this->login_model->get_alias_user($kode,$level);
                                        
                                       // echo $nama_unit . ' ' . $alias . ' ' . $kode . ' ' . $level ; die;

	                                // var_dump($alias);die;

					$this->check_session->set_session($username,$kode,$level,$nama_unit,$alias);	/*	Set user session	*/

	                                $sebagai = $this->convertion->get_user_level($level);
                                        if(strlen($kode)=='2'){
                                            $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Login berhasil, sebagai <b><span class="text-warning" style="text-transform: uppercase">'.$sebagai. ' : ' . $this->check_session->get_nama_unit() .'</span></b>.</div>');
                                        }elseif(strlen($kode)=='4'){
                                            if($sebagai == 'KPA'){
                                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Login berhasil, sebagai <b><span class="text-warning" style="text-transform: uppercase">'.$sebagai. ' : ' . get_h_unit(substr($kode,0,2)) . ' - ' . $this->check_session->get_nama_unit() .'</span></b>.</div>');
                                            }elseif($sebagai == 'PPK SUKPA'){
                                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Login berhasil, sebagai <b><span class="text-warning" style="text-transform: uppercase">'.$sebagai. ' : ' . get_h_unit(substr($kode,0,2)) . ' - ' . $this->check_session->get_nama_unit() .'</span></b>.</div>');
                                            }
                                            elseif($sebagai == 'BENDAHARA'){
                                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Login berhasil, sebagai <b><span class="text-warning" style="text-transform: uppercase">'.$sebagai. ' : ' . get_h_unit(substr($kode,0,2)) . ' - ' . $this->check_session->get_nama_unit() .'</span></b>.</div>');
                                            }elseif($sebagai == 'PUMK'){
                                                $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Login berhasil, sebagai <b><span class="text-warning" style="text-transform: uppercase">'.$sebagai. ' : ' . $this->check_session->get_nama_unit() .'</span></b>.</div>');
                                            }
                                        }elseif(strlen($kode)=='6'){
                                            $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Login berhasil, sebagai <b><span class="text-warning" style="text-transform: uppercase">'.$sebagai. ' : ' . $this->check_session->get_nama_unit() .'</span></b>.</div>');
                                        }


//                                        die;
                    redirect('serpis/index','refresh');                    	

					// redirect('dashboard','refresh');
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" style="text-align:center"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> Login anda salah, atau user tsb sudah <u>ditutup</u>.</div>');
					redirect('welcome','refresh');
				}
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" style="text-align:center"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> Login anda salah, atau user tsb sudah <u>ditutup</u>.</div>');
				redirect('welcome','refresh');
			}
		}
		else{
			redirect('welcome','refresh');
		}



	}

	function check_level($str1,$str2)
	{

		// $str1 = level
		// $str2 = kodeunit

		/*	set message error	*/
		$this->form_validation->set_message('check_level','Maaf level yang dipilih tidak sesuai dengan unit / sub unit');
		//$subunit = $this->input->post("subunit");



		// if ($str2=="9999" && ($str1=="1" || $str1=="4") ){ //pusat
		if (($str2=="9999" && ($str1=="1" )) ){ //pusat
			return true;
		}elseif (strlen($str2)=="9999" && $str1=="100" ){ //rektor
			return true;
		//} else if (substr($subunit,3,2)=="99" && $str=="2" ) { //unit
		}elseif (strlen($str2)==2 && $str1=="2" ){ //unit
			return true;
		//} else if (substr($subunit,3,2)!="99" && $str=="3"){ //sub unit
		// }elseif (strlen($str2)==4 && $str2!="9999" && $str1=="3"){ //sub unit
		}elseif (strlen($str2)==4 && $str1=="3"){ //sub unit
			return true;
		// }elseif (strlen($str2)==6 && $str2!="9999" && $str1=="31"){ //sub sub unit
		}elseif (strlen($str2)==6 && $str1=="31"){ //sub sub unit
			return true;
		}else{
			return false;
		}

	}


	function check_user($str){
		/*	set message error	*/
		// $this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="text-align:center"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> ', '</div>');
		// $this->form_validation->set_message('check_user','Maaf kombinasi username dan password Anda tidak tepat.');

		/* cek username,password */
		return $this->login_model->check_user();
	}



}
?>
