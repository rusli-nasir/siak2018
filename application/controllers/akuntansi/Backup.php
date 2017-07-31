<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends MY_Controller {
	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
        $this->load->library('grocery_CRUD');       
        $this->db2 = $this->db2 = $this->load->database('rba',TRUE);
        $this->load->model('akuntansi/Backup_model', 'Backup_model');
    }

	public function backup_transaksi(){
		$data = $this->Backup_model->backup_rsa();

		file_put_contents(FCPATH."assets/akuntansi/backup/backup.txt", serialize($data));

		// echo FCPATH."assets/akuntansi/backup/backup.txt";

		echo "<br/>Data telah dibackup";
	}

	public function restore_transaksi(){

		// $data1 = $this->Backup_model->backup_rsa();

		// $data = unserialize(file_get_contents(FCPATH."assets/akuntansi/backup/backup.txt"));

		$this->Backup_model->restore_rsa();

	}

	public function list_akun()
	{
		$this->data['array_jenis'] = ['akuntansi_aset','akuntansi_hutang','akuntansi_lra','akuntansi_aset_bersih','akuntansi_pembiayaan'];

		$temp_data['content'] = $this->load->view('akuntansi/akun_list',$this->data,true);
		$this->load->view('akuntansi/content_template',$temp_data,false);
	}
}
