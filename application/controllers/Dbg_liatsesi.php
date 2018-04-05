<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Dbg_liatsesi extends CI_Controller {
  private $cur_tahun = '' ;
  public function __construct(){
    parent::__construct();
    $this->load->model('cantik_model');
  }
  public function index(){
  	// echo $this->cantik_model->get_unit_rba($_SESSION['rsa_kode_unit_subunit']);
  	echo "<pre>";
  	print_r($_SESSION); 
  	echo "</pre>";
  	exit;
  }
}

?>