<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class rsa_ikw extends CI_Controller{
/* -------------- Constructor ------------- */
	public function __construct(){
		parent::__construct();
			//load library, helper, and model
			$this->load->library(array('form_validation','option'));
			$this->load->helper('form');
			$this->load->model(array('rsa_ikw_model'));
			$this->load->model("user_model");
			$this->load->helper("security");
			
		}
		
		#methods ======================
		
		//define method index()
		function index(){
			show_404('page');
		}
		
		function daftar_rsa_ikw(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				$subdata_rsa_ikw['result_rsa_ikw'] 		= $this->rsa_ikw_model->get_rsa_ikw();
				$subdata['row_rsa_ikw'] 			= $this->load->view("rsa_ikw/row_rsa_ikw",$subdata_rsa_ikw,TRUE);
				$data['main_content'] 			= $this->load->view("rsa_ikw/daftar_rsa_ikw",$subdata,TRUE);
				$this->load->view('main_template',$data);
			}
			else{
				redirect('home','refresh');	// redirect ke halaman home
			}		
		}
		function input_rsa_ikw(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				//set data for main template
				$data['user_menu']	= $this->load->view('user_menu','',TRUE);
				$data['main_menu']	= $this->load->view('main_menu','',TRUE);		
				$data['main_content'] 			= $this->load->view("rsa_ikw/input_rsa_ikw","",TRUE);
				$this->load->view('main_template',$data);
			}
			else{
				redirect('home','refresh');	// redirect ke halaman home
			}		
		}
		
		//define method exec_add_unit()
		//execute add data unit
		function exec_add_ikw(){

			if($this->input->post()){

				if($this->check_session->user_session() && $this->check_session->get_level()==100){
				
                                        if($this->input->post()){
											$this->form_validation->set_rules('id_trans','ID Transaksi','required|is_natural_no_zero|min_length[5]|callback_check_exist_rsa_ikw');
											$this->form_validation->set_rules('bulan','Bulan','required');
                                            $this->form_validation->set_rules('tahun','Tahun','required');
											$this->form_validation->set_rules('nip','NIP','required');
											$this->form_validation->set_rules('ikw','IKW','required');
											$this->form_validation->set_rules('pot_ikw','Potongan IKW','required');
											$this->form_validation->set_rules('bruto','Bruto','required');
											//$this->form_validation->set_rules('pajak','Pajak','required');
											$this->form_validation->set_rules('jml_pajak','Jumlah Pajak','required');
											$this->form_validation->set_rules('byr_stlh_pajak','Bayar Setelah Pajak','required');
											//$this->form_validation->set_rules('pot_lainnya','Potongan Lainnya','required');
											$this->form_validation->set_rules('netto','Netto','required');
                                          
                                            if ($this->form_validation->run()){
                                                $data = array(
													'id_trans' => form_prep($this->input->post('id_trans')),
													'bulan' => form_prep($this->input->post('bulan')),
													'tahun' => form_prep($this->input->post('tahun')),
													'nip' => form_prep($this->input->post('nip')),
													'ikw' => form_prep($this->input->post('ikw')),
													'pot_ikw' => form_prep($this->input->post('pot_ikw')),
													'id_trans' => form_prep($this->input->post('id_trans')),
													'bruto' => form_prep($this->input->post('bruto')),
													'pajak' => form_prep($this->input->post('pajak')),
													'jml_pajak' => form_prep($this->input->post('jml_pajak')),
													'byr_stlh_pajak' => form_prep($this->input->post('byr_stlh_pajak')),
													'pot_lainnya' => form_prep($this->input->post('pot_lainnya')),
													'netto' => form_prep($this->input->post('netto')),
							
						);
							                                               
                                                $this->rsa_ikw_model->add_rsa_ikw($data);
												
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
					$data['url']		= site_url('rsa_ikw/exec_delete/'.$this->uri->segment(3));
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
				if($this->rsa_ikw_model->delete_rsa_ikw(array('no'=>$this->uri->segment(3)))){
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
		function get_row_rsa_ikw(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				$data['result_rsa_ikw'] = $this->rsa_ikw_model->get_rsa_ikw();
				$this->load->view('rsa_ikw/row_rsa_ikw',$data);
			}
			else{
				show_404('page');
			}
		}
		
		//define search_unit()
		//this method for search unit
		function filter_rsa_ikw(){
			if($this->check_session->user_session() && $this->check_session->get_level()==100){
				$keyword = form_prep($this->input->post('keyword'));
				$data['result_rsa_ikw'] = $this->rsa_ikw_model->search_rsa_ikw($keyword);
				$this->load->view('rsa_ikw/row_rsa_ikw',$data);
			}
			else{
				show_404('page');
			}
                        
                        
		}
                
               function check_exist_rsa_ikw($kode_rsa_ikw){

                        $this->form_validation->set_message('check_exist_rsa_ikw', 'Maaf, kode RSA tsb sudah terdaftar');

                        $result = $this->rsa_ikw_model->get_rsa_ikw($kode_rsa_ikw);

                        if(empty($result)){
                                return true;
                        }
                        else{
                                return false;
                        }

                }
				 function check_exist_rba_unit($kode_unit_rba){

                        $this->form_validation->set_message('check_exist_rba_unit', 'Maaf, kode RBA Unit tsb sudah terdaftar');

                        $result = $this->rsa_ikw_model->get_rsa_ikw($kode_unit_rba);

                        if(empty($result)){
                                return true;
                        }
                        else{
                                return false;
                        }

                }
		
	}

?>
