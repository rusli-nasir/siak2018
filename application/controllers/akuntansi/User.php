<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
        $this->load->library('grocery_CRUD');       
        $this->db2 = $this->db2 = $this->load->database('rba',TRUE);

		$crud->unset_edit();

        $output = $crud->render(); 
        $output->title = 'Manajemen User';
        $output->menu12 = true;
        $temp_data['content'] = $this->load->view('akuntansi/crud/manage',$output,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
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

	 
	  return $post_array;
	}



	public function list_akun()
	{
		$this->data['array_jenis'] = ['akuntansi_aset','akuntansi_hutang','akuntansi_lra','akuntansi_aset_bersih','akuntansi_pembiayaan'];

		$temp_data['content'] = $this->load->view('akuntansi/akun_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
}
