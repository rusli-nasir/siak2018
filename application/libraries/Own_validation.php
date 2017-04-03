<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Own_validation{
	 public function __construct()
        {
                // Call the CI_Model constructor
                // parent::__construct();
        }
        
	function val_akun($form_validation){
		$form_validation->set_rules('Akun10','Akun 10','xss_clean|required|is_natural|max_length[15]');
		$form_validation->set_message('xss_clean',' ');
		$form_validation->set_message('required','%s harus dipilih.');
		$form_validation->set_message('is_natural','%s invalid nilai.');
		$form_validation->set_message('max_length','%s invalid nilai.');
	}
	
	function set_akun_pendapatan($input){
		/*	Menangkap data akun yang dikirim	*/
		 $akun10     = form_prep($input->post('Akun10'));
		 
		 $_SESSION['akun_pendapatan']	= $akun10;	// set session akun
	}
	
	function set_akun_kegiatan($input){
		/*	Menangkap data akun yang dikirim	*/
		 $akun10     = form_prep($input->post('Akun10'));
		 
		 $_SESSION['akun_kegiatan']	= $akun10;	// set session akun
	}
	
	function val_detail($form_validation){
		$form_validation->set_rules('deskripsi','Deskripsi','xss_clean|required|max_length[225]');
		$form_validation->set_rules('volume','Volume','xss_clean|required|is_natural|max_length[10]');
		$form_validation->set_rules('satuan','Satuan','xss_clean|required|callback_no_sumber_lokasi|max_length[20]');
		$form_validation->set_rules('tarif','Tarif','xss_clean|required|is_natural|max_length[19]');
		$form_validation->set_rules('jumlah','Jumlah','max_length[19]');
		$form_validation->set_message('xss_clean',' ');
	}
	
	function val_ta($form_validation){
		// $form_validation->set_rules('indikator','indikator','xss_clean|callback_is_required');
		$form_validation->set_rules('ta1','TA1 '.(date('Y')+1),'xss_clean|required|is_natural|callback_not_in_loading|max_length[19]');
		$form_validation->set_rules('ta2','TA2 '.(date('Y')+2),'xss_clean|required|is_natural|callback_not_in_loading|max_length[19]');
		$form_validation->set_rules('ta3','TA3 '.(date('Y')+3),'xss_clean|required|is_natural|callback_not_in_loading|max_length[19]');
		$form_validation->set_rules('ta4','TA4 '.(date('Y')+4),'xss_clean|required|is_natural|callback_not_in_loading|max_length[19]');
		$form_validation->set_rules('ta5','TA5 '.(date('Y')+5),'xss_clean|required|is_natural|callback_not_in_loading|max_length[19]');
		$form_validation->set_rules('satuan','satuan','xss_clean|required|callback_not_in_loading|max_length[50]');
		$form_validation->set_message('xss_clean',' ');
		$form_validation->set_message('required','%s harus diisi');
	}
}
?>