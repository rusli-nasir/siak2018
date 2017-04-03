<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class rsa_gup extends MY_Controller{
    public function __construct(){ 
        parent::__construct();
        $this->cek_session_in();
    }
    
    function index(){
        $data['tab'] = 'rsa_gup';
        $data['content'] = $this->load->view('akuntansi/rsa_gup_detail',$this->data,true);
        $this->load->view('akuntansi/content_template',$data,false);
    }
}
