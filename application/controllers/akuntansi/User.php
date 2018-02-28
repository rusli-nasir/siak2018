<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
        $this->load->library('grocery_CRUD');       
        $this->db2 = $this->db2 = $this->load->database('rba',TRUE);
        $this->load->model('akuntansi/User_akuntansi_model', 'User_akuntansi_model');
        $this->load->model('akuntansi/Unit_kerja_model', 'Unit_kerja_model');
    }

	public function manage(){
		$crud = new grocery_CRUD();

		$crud->set_table('akuntansi_user');
   		// $crud->set_primary_key("id_pejabat",'akuntansi_pejabat');

		$crud->field_type('level','dropdown',
												array('1' => 'Operator','2' => 'Verifikator','3' => 'Universitas','4' => 'Monitoring','10' => 'Audit-Unit',));

		$crud->where('level <> 9 and level <> 5');

		$unit = $this->db2->get('unit')->result_array();

		$array_unit = array();
		foreach ($unit as $entry) {
			$array_unit[$entry['kode_unit']] = $entry['nama_unit'];
		}

		$crud->field_type('kode_unit','dropdown',$array_unit);
		$crud->field_type('aktif','dropdown',array('1' => 'Aktif', '2' => 'Tidak Aktif'));
		$crud->field_type('kode_user','hidden');
		$crud
				->field_type('password','password')
				->callback_before_insert(array($this,'fill_form_callback'))
		;

		$crud->unset_edit();

        $output = $crud->render(); 
        $output->title = 'Manajemen User';
        $output->menu12 = true;
        $temp_data['content'] = $this->load->view('akuntansi/crud/manage',$output,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function manage_menu()
	{
		$crud = new grocery_crud();

		$crud
			->set_theme('bootstrap')
			->unset_bootstrap()
			->set_table('akuntansi_jenis_user')
			->set_relation_n_n('pilihan_menu','akuntansi_menu_by_level','akuntansi_menu','level_user','id_menu','nama_menu',null,"is_parent = 1 or parent_id IS NULL")
		;

		$output = $crud->render(); 
		$output->title = 'Manajemen Menu Untuk User';
		$temp_data['content'] = $this->load->view('akuntansi/crud/manage',$output,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);

	}

	public function cek_menu()
	{
		$this->load->view('akuntansi/template/main',$this->data);

	}

	function fill_form_callback($post_array, $primary_key) {
	 
	    //Encrypt password only if is not empty. Else don't change the password to an empty field
	    if(!empty($post_array['password']))
	    {
	        $post_array['password'] = sha1($post_array['password']);
	    }
	    else
	    {
	        unset($post_array['password']);
	    }

	   	$post_array['kode_user'] = $this->User_akuntansi_model->generate_kode_user($post_array['kode_unit']);
	 
	  return $post_array;
	}



	public function list_akun()
	{
		$this->data['array_jenis'] = ['akuntansi_aset','akuntansi_hutang','akuntansi_lra','akuntansi_aset_bersih','akuntansi_pembiayaan'];

		$temp_data['content'] = $this->load->view('akuntansi/akun_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}

	public function generate_akun()
	{
		$unit = $this->db2->get('unit')->result_array();
		$array_level = array ( 
			'1' => 'operator',
			'2' => 'verifikator',
			'6' => 'kasubbag',
		);
		$array_user = array();
		foreach ($unit as $entry) {
			$alias = strtolower($entry['alias']);

			foreach ($array_level as $key => $username) {
				$user = array(
					'username' => $username.'_'.$alias,
					'kode_unit' => $entry['kode_unit'],
					'level' => $key,
					'aktif' => 1,
				);
				$user['password'] = sha1($user['username']);
				$array_user[]=$user;
				# code...
			}
		}
		$array_level = array ( 
			'6' => 'wd'
		);
		foreach ($unit as $entry) {
			$alias = strtolower($entry['alias']);

			foreach ($array_level as $key => $username) {
				$user = array(
					'username' => $username.'_'.$alias,
					'kode_unit' => $entry['kode_unit'],
					'level' => $key,
					'aktif' => 1,
				);
				$user['password'] = sha1($user['username']);
				$array_user[]=$user;
				# code...
			}
		}

		foreach ($array_user as $user) {
			$user['kode_user'] = $this->User_akuntansi_model->generate_kode_user($user['kode_unit']);

			// $this->db->insert('akuntansi_user',$user);
		}

	}

	public function print_akun()
	{
		$hasil = $this->db->get('akuntansi_user')->result_array();

		$array_user = array();
		foreach ($hasil as $entry) {
			if ($entry['kode_unit'] != null) {
				$array_user[$this->Unit_kerja_model->get_nama_unit($entry['kode_unit'])][] = $entry;
			} else {
				$array_user['lainnya'][] = $entry;
			}
		}


		$level = array ( 
			'1' => 'Operator',
			'2' => 'Verifikator',
			'3' => 'LK Akuntansi',
			'4' => 'Monitoring universitas',
			'5' => 'Rupiah Murni',
			'6' => 'Monitoring unit',
			'7' => 'Audit',
			'9' => 'admin',
		);


		foreach ($array_user as $unit => $users) {
			foreach ($users as $user) {
				echo $user['username'].";".$user['username'].";".$level[$user['level']] . ";" .$unit."\n";
			}
		}

		// print_r($array_user);
	}
}
