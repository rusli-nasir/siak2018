<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editor extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
        $this->load->library('grocery_CRUD');       
        $this->db2 = $this->load->database('rba',TRUE);
        $this->db_laporan = $this->load->database('laporan',TRUE);
    }

	public function edit_kuitansi(){
		$crud = new grocery_CRUD();

		if ($this->session->userdata('level') != 2 and $this->session->userdata('level') != 3){
			die("akses tidak diperbolehkan");
		}

		$crud->set_table('akuntansi_kuitansi_jadi');
		$crud->set_primary_key('id_kuitansi_jadi');
		$crud->where("tipe != 'memorial' AND tipe != 'jurnal_umum' AND tipe != 'pajak' AND tipe != 'penerimaan' AND tipe != 'pengembalian'");
		// $crud->set_theme('datatables');

		if ($this->session->userdata('level') == 2){
			$crud->where('unit_kerja',$this->session->userdata('kode_unit'));
		}

		// $crud->unset_edit();
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_delete();
		$crud->unset_export();
		$crud->unset_texteditor('uraian','untuk');
		$crud->unset_fields('id_pajak','id_pengembalian','tanggal_jurnal','tanggal_verifikasi','tanggal_posting','status','flag','kode_user','tipe','jenis','tanggal','tanggal_bukti','id_kuitansi');
		$crud->unset_print();

		$unit = $this->db2->get('unit')->result_array();
    	$array_unit = array();
		foreach ($unit as $entry) {
			$array_unit[$entry['kode_unit']] = $entry['nama_unit'];
		}
		$array_unit['9999'] = 'Penerimaan';

		$crud->field_type('unit_kerja','dropdown',$array_unit);

		$crud->callback_after_update(array($this, 'update_kuitansi_posted'));

		// $crud->add_action('Edit', 'ui-icon-pencil', 'akuntansi/jurnal_rsa/edit_kuitansi_jadi','ui-icon-pencil');

        $output = $crud->render(); 
        $output->title = 'Edit Khusus untuk transaksi non multi-akun';
        $output->menu12 = true;
        $temp_data['content'] = $this->load->view('akuntansi/crud/manage',$output,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);   
	}

	public function update_kuitansi_posted($post_array,$primary_key)
	{
		$check_posted = $this->db_laporan->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi_jadi' => $primary_key))->result_array();
		// print_r($post_array);die();
		if ($check_posted != null){
			$this->db_laporan->where('id_kuitansi_jadi',$primary_key);
			$this->db_laporan->update('akuntansi_kuitansi_jadi',$post_array);
			return true;
		}else{
			return true;
		}
	}

	public function list_akun()
	{
		$this->data['array_jenis'] = ['akuntansi_aset','akuntansi_hutang','akuntansi_lra','akuntansi_aset_bersih','akuntansi_pembiayaan'];

		$temp_data['content'] = $this->load->view('akuntansi/akun_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
}
