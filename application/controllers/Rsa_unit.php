<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Rsa_unit extends CI_Controller{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
			//load library, helper, and model
			$this->load->library(array('form_validation','option'));
			$this->load->helper('form');
			$this->load->model(array('rsa_unit_model'));
			$this->load->model("user_model");
			$this->load->helper("security");
			
		}
		
		#methods ======================
		
		//define method index()
		function index(){
			show_404('page');
		}
		
		//define method daftar_unit()
		function daftar_rsa_unit(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				$subdata_rsa_unit['result_rsa_unit'] 		= $this->rsa_unit_model->get_rsa_unit();
				$subdata['opt_subunit']				= $this->rsa_unit_model->get_subunit2();
				$subdata['opt_unit_kepeg']		= $this->option->opt_unit_kepeg();
				$subdata['row_rsa_unit'] 			= $this->load->view("rsa_unit/row_rsa_unit",$subdata_rsa_unit,TRUE);
				$data['main_content'] 			= $this->load->view("rsa_unit/daftar_rsa_unit",$subdata,TRUE);
				$this->load->view('main_template',$data);
			}
			else{
				redirect('home','refresh');	// redirect ke halaman home
			}		
		}
		
		//define method exec_add_unit()
		//execute add data unit
		function exec_add_rsa_unit(){

			if($this->input->post()){

				if($this->check_session->user_session() && $this->check_session->get_level()==100){
				
						// get kode otomatis
						// $top_unit = $this->master_unit_model->get_unit('',array('kode_unit !=' => '99'),'kode_unit DESC',1);

						// if(count($top_unit)>0) $top_unit=$top_unit[0];

						// $kode = strlen(($top_unit->kode_unit+1)+"")==1?"0".($top_unit->kode_unit+1):$top_unit->kode_unit+1;
                                        if($this->input->post()){
											
                                            $this->form_validation->set_rules('kode_rsa_unit','Kode RSA Unit','required|is_natural_no_zero|min_length[2]|callback_check_exist_rsa_unit');
											$this->form_validation->set_rules('kode_unit_rba','Kode RBA Unit','required|is_natural_no_zero|callback_check_exist_rba_unit');
                                            $this->form_validation->set_rules('kode_unit_kepeg','Kode Unit Kepegawaian','required');
                                           // $this->form_validation->set_rules('kode_unit_rba','Kode Unit RBA','required');
                                            if ($this->form_validation->run()){
                                                $data = array(
							// 'kode_unit' => $kode,
                            'kode_rsa_unit' => form_prep($this->input->post('kode_rsa_unit')),
							'kode_unit_kepeg' => form_prep($this->input->post('kode_unit_kepeg')),
							'kode_unit_rba' => form_prep($this->input->post('kode_unit_rba')),
							
						);
							//data untuk sub unit dekanat
//						$data_sub = array(
//								'kode_subunit' 	=> $kode.'99',
//								'nama_subunit'	=> $data['nama_unit'],
//								'nama_pejabat'	=> '...............................',
//								'golongan'		=> '0'
//								);

						// if($this->unit_model->add_unit($data) && $this->master_unit_model->add_subunit($data_sub)){	
						// if($this->unit_model->add_unit($data)){	

						// }
                                                
                                                $this->rsa_unit_model->add_rsa_unit($data);
                                                echo "berhasil";
                                                
                                            }else{
                                                    echo validation_errors();

                                            }
                                
                                        }
						
						
				}
				else{
					show_404('page');
				}

			}


		}		
		
		//define method get_form_edit()
		//get form for edit unit
		function get_form_edit(){
			if($this->check_session->user_session() && $this->check_session->get_level()==1){
				$kode_unit 	= form_prep($this->input->post('kode_unit'));
				$data['result_unit'] = $this->unit_model->get_unit($kode_unit);
				$this->load->view('form_edit_unit_',$data);
			}
			else{
				show_404('page');
			}
		}
		
		//define method exec_edit_unit()
		//execute edit process
		function exec_edit_unit(){
			if($this->check_session->user_session() && $this->check_session->get_level()==1){
				$kode_unit = form_prep($this->input->post('kode_unit'));
				$nama_unit = form_prep($this->input->post('nama_unit'));
				$data_edit = array(
					'nama_unit' => $nama_unit,
				);
				$this->unit_model->edit_unit($data_edit,$kode_unit);
				$data['result_unit'] = $this->unit_model->get_unit($kode_unit);
				$this->load->view('row_unit_',$data);
			}
			else{
				show_404('page');
			}
		}
		
		//define method confirmation_delete()
		//call confirmation before delete unit
		function confirmation_delete(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				if($this->uri->segment(3)!='99'){ //jika bukan user pusat
					$data['url']		= site_url('rsa_unit/exec_delete/'.$this->uri->segment(3));
					$data['message']	= "Apakah anda yakin akan menghapus data ini ( kode : ".$this->uri->segment(3).") ?";
					$this->load->view('confirmation_',$data);
				}else{ //jika user pusat
					$data['class']	 = 'option box';
					$data['class_btn']	 = 'ya';
					$data['message'] = 'Unit pusat tidak diijinkan untuk dihapus';
					$this->load->view('messagebox_',$data);
				}
			}
			else{
				show_404('page');
			}
		}
		
		//define method exec_delete()
		//execute delete process
		function exec_delete(){
			print_r($this->uri->segment(3));die;
		if($this->check_session->user_session() && $this->check_session->get_level()==100){
			if($this->uri->segment(3)){
				if($this->rsa_unit_model->delete_rsa_unit(array('no'=>$this->uri->segment(3)))){
					$data['class']	 = 'option box';
					$data['class_btn']	 = 'ya';
					$data['message'] = 'Data berhasil dihapus';
				}else{
					$data['class']	 = 'boxerror';
					$data['class_btn']	 = 'tidak';
					$data['message'] = 'Data gagal dihapus';
				}
			}else{
				$data['class']	 = 'boxerror';
				$data['class_btn']	 = 'tidak';
				$data['message'] = 'Tidak ada data yang dihapus';
			}
			$this->load->view('messagebox_',$data);
		}else{
			show_404('page');
		}
	}
		
		//define method get_row_unit()
		//this method for refresh list unit
		function get_row_rsa_unit(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				$data['result_rsa_unit'] = $this->rsa_unit_model->get_rsa_unit();
				$this->load->view('rsa_unit/row_rsa_unit',$data);
			}
			else{
				show_404('page');
			}
		}
		
		//define search_unit()
		//this method for search unit
		function filter_rsa_unit(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				$keyword = form_prep($this->input->post('keyword'));
				$data['result_rsa_unit'] = $this->rsa_unit_model->search_rsa_unit($keyword);
				$this->load->view('rsa_unit/row_rsa_unit',$data);
			}
			else{
				show_404('page');
			}
                        
                        
		}
                
               function check_exist_rsa_unit($kode_rsa_unit){

                        $this->form_validation->set_message('check_exist_rsa_unit', 'Maaf, kode RSA tsb sudah terdaftar');

                        $result = $this->rsa_unit_model->get_rsa_unit($kode_rsa_unit);

                        if(empty($result)){
                                return true;
                        }
                        else{
                                return false;
                        }

                }
				 function check_exist_rba_unit($kode_unit_rba){

                        $this->form_validation->set_message('check_exist_rba_unit', 'Maaf, kode RBA Unit tsb sudah terdaftar');

                        $result = $this->rsa_unit_model->get_rsa_unit($kode_unit_rba);

                        if(empty($result)){
                                return true;
                        }
                        else{
                                return false;
                        }

                }
		
	}

?>
