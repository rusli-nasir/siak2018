<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
        $this->load->library('grocery_CRUD');
        $this->db2 = $this->load->database('rba',TRUE);
    }

	public function manage($tabel){
		$crud = new grocery_CRUD(); 
		$level = substr($tabel, -1,1);

        $crud
        	->set_table($tabel)
        	->unique_fields(array("akun_$level"))
        		;

        if ($level > 1){
	        for ($i=1;$i<$level;$i++){
	        	if ($i != 5){
	        		$temp_tabel = substr_replace($tabel,$i,-1);
	        		$crud->set_primary_key("akun_$i",$temp_tabel);
	        		$crud->set_relation("akun_$i",$temp_tabel,"{akun_$i} - {nama}");
	        	}
	        }
        }



        if (in_array(substr($tabel,0,-2),array('akuntansi_sal','akuntansi_aset'))) {
        	$unit = $this->db2->get('unit')->result_array();
        	$array_unit = array();
			foreach ($unit as $entry) {
				$array_unit[$entry['kode_unit']] = $entry['nama_unit'];
			}
			$array_unit['9999'] = 'Penerimaan';
			$array_unit['all'] = 'Semua (All)';

			$crud->field_type('kode_unit','dropdown',$array_unit);
        }

        if ($this->session->userdata('level')!= 9 and $this->session->userdata('level')!= 3) {
        	$crud->unset_add()->unset_edit()->unset_delete();
		}

        $output = $crud->render(); 
        $output->title = "Manajemen Akun";
        $this->load->view('akuntansi/crud/manage',$output,false);
	}

	public function manage_relasi_akun_unit(){
		$crud = new grocery_CRUD(); 

		$crud
			->set_table('akuntansi_relasi_unit')
			->set_subject('Relasi Akun')
		;


		$unit = $this->db2->get('unit')->result_array();
    	$array_unit = array();
		foreach ($unit as $entry) {
			$array_unit[$entry['kode_unit']] = $entry['nama_unit'];
		}
		$array_unit['9999'] = 'Penerimaan';
		$array_unit['all'] = 'Semua (All)';

		// vdebug($array_unit);

		$crud->field_type('kode_unit','dropdown',$array_unit);
		$crud->set_primary_key('kode_akun', 'akun_belanja_filtered');
		$crud->set_relation('kode_akun','akun_belanja_filtered','nama_akun');

		$crud->set_theme('bootstrap');
		$crud->unset_bootstrap();
		$crud->unset_jquery();
		$crud->unset_jquery_ui();

		$output = $crud->render(); 
        $output->title = "Manajemen Relasi Akun Unit";
        $data = array();
        $data['content'] = $this->load->view('akuntansi/crud/manage',$output,true);

        $this->load->view('akuntansi/content_template',$data,false);
		
	}

	public function list_akun()
	{
		$this->data['array_jenis'] = ['akuntansi_aset','akuntansi_hutang','akuntansi_lra','akuntansi_sal','akuntansi_pembiayaan','akuntansi_aset_bersih'];

		$temp_data['content'] = $this->load->view('akuntansi/akun_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
}
