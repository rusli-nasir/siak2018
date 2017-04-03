<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends MY_Controller {
	private $data;

	public function __construct(){
        parent::__construct();
        $this->cek_session_in();
    }

	public function input_jurnal($id_kuitansi){
		echo $id_kuitansi;
	}
}
