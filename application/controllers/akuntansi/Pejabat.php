<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pejabat extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
        $this->load->library('grocery_CRUD');
    }

	public function manage(){
		$crud = new grocery_CRUD();

		$crud->set_table('akuntansi_pejabat');
   		// $crud->set_primary_key("id_pejabat",'akuntansi_pejabat');

		$crud->set_field_upload('scan_ttd','assets/akuntansi/ttd');

		$crud->field_type('jabatan','dropdown',

												array('kabag' => 'kabag','kasubbag' => 'kasubbag','operator' => 'operator','verifikator' => 'verifikator'));
		// $level = substr($tabel, -1,1);

  //       $crud
  //       	->set_table($tabel)
  //       	->unique_fields(array("akun_$level"))
  //       		;

  //       if ($level > 1){
	 //        for ($i=1;$i<$level;$i++){
	 //        	if ($i != 5){
	 //        		$temp_tabel = substr_replace($tabel,$i,-1);
	 //        		$crud->set_primary_key("akun_$i",$temp_tabel);
	 //        		$crud->set_relation("akun_$i",$temp_tabel,"{akun_$i} - {nama}");
	 //        	}
	 //        }
  //       }

        $output = $crud->render(); 
        $this->load->view('akuntansi/crud/manage',$output,false);
	}

	public function list_akun()
	{
		$this->data['array_jenis'] = ['akuntansi_aset','akuntansi_hutang','akuntansi_lra','akuntansi_aset_bersih','akuntansi_pembiayaan'];

		$temp_data['content'] = $this->load->view('akuntansi/akun_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
}
