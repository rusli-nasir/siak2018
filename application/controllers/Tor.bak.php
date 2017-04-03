<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Tor extends CI_Controller {

    private $cur_tahun = '' ;

    public function __construct()
    {
            parent::__construct();

            $this->cur_tahun = $this->setting_model->get_tahun();

            if ($this->check_session->user_session()){
		/*	Load library, helper, dan Model	*/
		$this->load->library(array('form_validation','option'));
		$this->load->helper('form');
		$this->load->model('tor_model');
    $this->load->model('user_model');
		$this->load->model('menu_model');
		$this->load->model('unit_model');
		$this->load->model('subunit_model');
		$this->load->model('master_unit_model');
            }else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

/* -------------- Method ------------- */
	function index()
	{
		/* check session	*/
		if($this->check_session->user_session()){
			redirect('tor/daftar_tor/','refresh');
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

        function usulan_tor($kode,$sumber_dana){

            $data['cur_tahun'] = $this->cur_tahun ;

            /* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
                        $unit = $this->check_session->get_unit() ;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
                        $subdata['tor_usul']            = $this->tor_model->get_tor_usul(substr($kode,2,10));

                        $subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($kode,$sumber_dana,$this->cur_tahun);
                        $subdata['detail_rsa']          = $this->tor_model->get_detail_rsa($kode,$sumber_dana,$this->cur_tahun);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                        $subdata['sumber_dana'] 	= $sumber_dana;
                        $subdata['kode']                = $kode;
			$data['main_content'] 		= $this->load->view("tor/usulan_tor",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

        }


        function usulan_tor_to_validate($kode,$sumber_dana,$tahun){

            $data['cur_tahun'] = $this->cur_tahun ;

            /* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
                        $unit = $this->check_session->get_unit() ;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
                        $subdata['tor_usul']            = $this->tor_model->get_tor_usul(substr($kode,2,10));

                        $subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($kode,$sumber_dana,$tahun);
                        $subdata['detail_rsa_to_validate']          = $this->tor_model->get_detail_rsa_to_validate($kode,$sumber_dana,$tahun);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                        $subdata['sumber_dana'] 	= $sumber_dana;
                        $subdata['tahun'] 	= $tahun;
                        $subdata['kode']                = $kode;
			$data['main_content'] 		= $this->load->view("tor/usulan_tor_to_validate",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

        }

        function realisasi_tor($kode,$sumber_dana){

            $data['cur_tahun'] = $this->cur_tahun ;

            /* check session	*/
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==13))){
                        $unit = $this->check_session->get_unit() ;
			$data['main_menu']              = $this->load->view('main_menu','',TRUE);
//			$subdata['rsa_usul'] 		= $this->dpa_model->get_dpa_program_usul($unit,'SELAIN-APBN','2017');
                        $subdata['tor_usul']            = $this->tor_model->get_tor_usul(substr($kode,2,10));

                        $subdata['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($kode,$sumber_dana,$this->cur_tahun);
                        $subdata['detail_rsa_dpa']      = $this->tor_model->get_detail_rsa_dpa($kode,$sumber_dana,$this->cur_tahun);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
                        $subdata['sumber_dana'] 	= $sumber_dana;
                        $subdata['kode']                = $kode;
                        $subdata['tahun']               = $this->cur_tahun ;
                        $subdata['kode_unit']             = $this->check_session->get_unit();
                        $subdata['nm_unit']             = $this->check_session->get_nama_unit();
                        $subdata['alias']               = $this->tor_model->get_alias_unit($this->check_session->get_unit());
                        $subdata['pic_kuitansi']        = $this->tor_model->get_pic_kuitansi($this->check_session->get_unit());
			$data['main_content'] 		= $this->load->view("tor/realisasi_tor",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($subdata);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}

        }

        function get_next_kode_akun_tambah($kode,$sumber_dana){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
                echo $this->tor_model->get_next_kode_akun_tambah($kode,$sumber_dana,$this->cur_tahun);
            }

        }

        function delete_rsa_detail_belanja(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
                $id_rsa_detail = $this->input->post('id_rsa_detail');
                if($this->tor_model->do_delete_rsa_detail_belanja($id_rsa_detail)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Data berhasil dihapus.</div>');
                    echo "sukses";
                }
                else{
                    echo "gagal";
                }
            }
        }

        function add_rsa_detail_belanja(){

            $this->form_validation->set_rules('kode_akun_tambah','Kode Akun Tambah','xss_clean|required');
            $this->form_validation->set_rules('deskripsi','Deskripsi','xss_clean|required');
            $this->form_validation->set_rules('volume','Volume','xss_clean|required|is_natural_no_zero');
            $this->form_validation->set_rules('satuan','Satuan','xss_clean|required');
            $this->form_validation->set_rules('harga_satuan','Harga satuan','xss_clean|required|is_natural_no_zero');
            if($this->form_validation->run()==TRUE){
                $data = array(
                            'id_detail' => '0',
                            'kode_usulan_belanja' => $this->input->post('kode_usulan_belanja'),
                            'deskripsi' => $this->input->post('deskripsi'),
                            'sumber_dana' => $this->input->post('sumber_dana'),
                            'volume' => $this->input->post('volume'),
                            'satuan' => $this->input->post('satuan'),
                            'harga_satuan' => $this->input->post('harga_satuan'),
                            'tahun' => $this->cur_tahun,
                            'username' => substr($this->input->post('kode_usulan_belanja'),0,6),
                            'tanggal_transaksi' => date("Y-m-d H:i:s"),
                            'flag_cetak' => '1',
                            'revisi' => $this->input->post('revisi'),
                            'kode_akun_tambah' => $this->input->post('kode_akun_tambah'),
                            'impor' => $this->input->post('impor'),
                            'tanggal_impor' => date("Y-m-d H:i:s"),
                            'proses' => '0',
                        );
//                        var_dump($data);die;
                if($this->tor_model->add_rsa_detail_belanja($data)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Data berhasil disimpan.</div>');
                    echo "sukses";
                }else{
                    echo "gagal";
                }
            }


        }

        function edit_rsa_detail_belanja(){

//            $this->form_validation->set_rules('kode_akun_tambah','Kode Akun Tambah','xss_clean|required');
            $this->form_validation->set_rules('deskripsi','Deskripsi','xss_clean|required');
            $this->form_validation->set_rules('volume','Volume','xss_clean|required|is_natural_no_zero');
            $this->form_validation->set_rules('satuan','Satuan','xss_clean|required');
            $this->form_validation->set_rules('harga_satuan','Harga satuan','xss_clean|required|is_natural_no_zero');

            $id_rsa_detail = $this->input->post('id_rsa_detail');
            if($this->form_validation->run()==TRUE){
                $data = array(
//                            'id_detail' => '0',
//                            'kode_usulan_belanja' => $this->input->post('kode_usulan_belanja'),
                            'deskripsi' => $this->input->post('deskripsi'),
//                            'sumber_dana' => $this->input->post('sumber_dana'),
                            'volume' => $this->input->post('volume'),
                            'satuan' => $this->input->post('satuan'),
                            'harga_satuan' => $this->input->post('harga_satuan'),
//                            'tahun' => $this->cur_tahun,
//                            'username' => substr($this->input->post('kode_usulan_belanja'),0,6),
//                            'tanggal_transaksi' => date("Y-m-d H:i:s"),
//                            'flag_cetak' => '1',
//                            'revisi' => $this->input->post('revisi'),
//                            'kode_akun_tambah' => $this->input->post('kode_akun_tambah'),
//                            'impor' => $this->input->post('impor'),
//                            'tanggal_impor' => date("Y-m-d H:i:s"),
//                            'proses' => '0',
                        );
//                        var_dump($data);die;
                if($this->tor_model->edit_rsa_detail_belanja($data,$id_rsa_detail)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Data berhasil diubah.</div>');
                    echo "sukses";
                }else{
                    echo "gagal";
                }
            }


        }

        function proses_tor(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
                $kode = $this->input->post('kode');
                $sumber_dana = $this->input->post('sumber_dana');
                if($this->tor_model->post_proses_tor($kode, $sumber_dana, $this->cur_tahun)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Usulan sub kegiatan terkirim !</div>');
                    echo "sukses";
                }else{
                    echo "gagal";
                }

            }

        }

        function proses_tor_rsa_detail(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
                $id_rsa_detail = $this->input->post('id_rsa_detail');
                $proses = $this->input->post('proses');
                if($this->tor_model->post_proses_tor_rsa_detail($id_rsa_detail,$proses)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Usulan berhasil dikirim.</div>');
                    echo "sukses";
                }else{
                    echo "gagal";
                }

            }
        }

        function proses_tor_rsa_to_validate(){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
                $id_rsa_detail = $this->input->post('id_rsa_detail');
                $proses = $this->input->post('proses');

                // tambahan dari dhanu
                if(intval($proses) == 0){
                    $sql = "DELETE FROM kepeg_tr_temp_sppls WHERE id_rsa_detail = ".intval($id_rsa_detail);
                    $this->db->query($sql);
                }
                // end tambahan dari dhanu

                if($this->tor_model->post_proses_tor_to_validate($id_rsa_detail,$proses)){
                    $this->session->set_flashdata('message', '<div class="alert alert-success" style="text-align:center"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Usulan berhasil divalidasi.</div>');
                    echo "sukses";
                }else{
                    echo "gagal";
                }

            }
        }



        function refresh_row_detail($kode,$sumber_dana){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2))){
                $data['detail_rsa']          = $this->tor_model->get_detail_rsa($kode,$sumber_dana,$this->cur_tahun);
                $data['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($kode,$sumber_dana,$this->cur_tahun);
                $this->load->view('tor/usulan_tor_row',$data);
            }
        }

        function form_edit_detail($id_rsa_detail){
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==2)))
		{
			$data['value']	= $this->tor_model->get_single_detail($id_rsa_detail);

			$this->load->view('tor/row_edit_tor',$data);
		}else{
			show_404();
		}
	}

        function refresh_row_detail_to_validate($kode,$sumber_dana,$tahun){
            if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11))){
//                $data['detail_rsa']          = $this->tor_model->get_detail_rsa($kode,$sumber_dana,$this->cur_tahun);
                $data['detail_rsa_to_validate']          = $this->tor_model->get_detail_rsa_to_validate($kode,$sumber_dana,$tahun);
                $data['detail_akun_rba']     = $this->tor_model->get_detail_akun_rba($kode,$sumber_dana,$tahun);
                $this->load->view('tor/usulan_tor_row_to_validate',$data);
            }
        }

        function form_edit_detail_to_validate($id_rsa_detail){
		if($this->check_session->user_session() && (($this->check_session->get_level()==100)||($this->check_session->get_level()==11)))
		{
			$data['value']	= $this->tor_model->get_single_detail($id_rsa_detail);

			$this->load->view('tor/row_edit_tor_to_validate',$data);
		}else{
			show_404();
		}
	}

	function daftar_tor_()
	{
		/* check session	*/
		if($this->check_session->user_session() && $this->check_session->get_level()==1){
			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			//$data['main_content']	= $this->load->view('main_content','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);

			//$subdata_tor['result'] 		= $this->tor_model->get_tor();
			//$subdata['row_tor'] 				= $this->load->view("row_tor",$subdata_tor,TRUE);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 				= $this->load->view("daftar_tor",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($data);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}

	function daftar_tor()
	{

		/* check session	*/
		if($this->check_session->user_session() && $this->check_session->get_level()==1){
			/*	Set data untuk main template */


			// $data['user_menu']	= $this->load->view('user_menu','',TRUE);
			//$data['main_content']	= $this->load->view('main_content','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);

			$subdata_tor['result'] 		= $this->tor_model->get_tor();
			// $subdata['row_tor'] 				= $this->load->view("row_tor",$subdata_tor,TRUE);
			$subdata['opt_sumber_dana'] 	= $this->option->sumber_dana();
			$data['main_content'] 		= $this->load->view("tor/daftar_tor",$subdata,TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($data);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}
	function get_sub_subunit(){
		if($this->input->post()){
			$this->load->model('master_sub_subunit_model');
			$result = $this->master_sub_subunit_model->get_child_sub_subunit($this->input->post('kode_sub_subunit'));
			$return = '<option value="">-pilih-</option>';
			foreach($result as $r){
				$return .= '<option value="'.$r->kode_sub_subunit.'">'.$r->kode_sub_subunit.' - '.$r->nama_sub_subunit.' [sub_subunit]</option>';
			}
			echo $return ;
		}
	}

	function get_subunit(){
		if($this->input->post()){
			$this->load->model('subunit_model');
			$result = $this->subunit_model->get_child_subunit($this->input->post('kode_subunit'));
			$return = '<option value="">-pilih-</option>';
			foreach($result as $r){
				$return .= '<option value="'.$r->kode_subunit.'">'.$r->kode_subunit.' - '.$r->nama_subunit.' [subunit]</option>';
			}
			echo $return ;
		}
	}
	function get_unit(){
		if($this->input->post()){
			$this->load->model('master_unit_model');
			$result = $this->master_unit_model->get_child_unit($this->input->post('kode_unit'));
			$return = '<option value="">-pilih-</option>';
			foreach($result as $r){
				$return .= '<option value="'.$r->kode_unit.'">'.$r->kode_unit.' - '.$r->nama_unit.' [unit]</option>';
			}
			echo $return ;
		}
	}
	function get_row($sumber_dana=''){
		if($this->check_session->user_session() && ($this->check_session->get_level()==1)){
			$data['result'] = $this->tor_model->search_tor($sumber_dana);
			//print_r($data);die;
			$this->load->view("row_tor",$data);
		}else{
			show_404('page');
		}
	}
	function filter(){
		if($this->check_session->user_session() && ($this->check_session->get_level()==1)){
			$keyword 		= form_prep($this->input->post("keyword"));
			$sumber_dana 	= form_prep($this->input->post("sumber_dana"));
			$data['result'] = $this->tor_model->search_tor($sumber_dana,$keyword);
			//print_r($data);die;
			$this->load->view("row_tor",$data);
		}else{
			show_404('page');
		}
	}
	function input_tor()
	{
		/* check session	*/
		if($this->check_session->user_session() && $this->check_session->get_level()==1){
			/*	Set data untuk main template */
			$data['user_menu']	= $this->load->view('user_menu','',TRUE);
			//$data['main_content']	= $this->load->view('main_content','',TRUE);
			$data['main_menu']	= $this->load->view('main_menu','',TRUE);


			$data['main_content'] 				= $this->load->view("input_tor","",TRUE);
			/*	Load main template	*/
//			echo '<pre>';var_dump($data);echo '</pre>';die;
			$this->load->view('main_template',$data);
		}else{
			redirect('welcome','refresh');	// redirect ke halaman home
		}
	}
        function show_komponen_input(){
            if($this->check_session->user_session() && $this->check_session->get_level()==1){
                if($this->input->post()){
                    $unit = $this->input->post('unit');
                    $sumber_dana = $this->input->post('sumber_dana');
                    $tahun = $this->input->post('tahun');

                    $tor_kegiatan_usul = $this->tor_model->get_tor_kegiatan_usul($unit,$sumber_dana,$tahun);

//                    var_dump($tor_kegiatan_usul);die;

                    $data['tor_kegiatan_usul'] = $tor_kegiatan_usul ;
//                    var_dump($data);die;
                    $this->load->view('tor/row_tor',$data);


                }
            }

        }




    // CREATE BY DHANU // DELETE BUT CONFIRM IF CAUSED ERROR
    function msgSukses($m){
    return "<div class=\"alert alert-success alert-dismissible text-center\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"glyphicon glyphicon-lamp\"></i>&nbsp;&nbsp;".$m."</div>";
    }

    function msgGagal($m){
    return "<div class=\"alert alert-danger alert-dismissible text-center\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"glyphicon glyphicon-alert\"></i>&nbsp;&nbsp;".$m."</div>";
    }

    function getOpsiJenisPeg(){
    $result = array(1=>'Dosen Pengajar', 2=>'Tenaga Kependidikan');
    $return = '<option value=""> seluruhnya </option>';
    foreach($result as $k => $v){
    $return .= '<option value="'.$k.'">'.$v.'</option>';
    }
    echo $return ;
    }

    function getOpsiStatusPeg(){
    $result = array(1=>'Pegawai Negeri Sipil',2=>'Pegawai Tetap Non PNS (BLU)',4=>'Tenaga Kerja Kontrak');
    $return = '<option value=""> seluruhnya </option>';
    foreach($result as $k => $v){
    $return .= '<option value="'.$k.'">'.$v.'</option>';
    }
    echo $return ;
    }

    function getOpsiStatusPeg2(){
    $result = array(1=>'Pegawai Negeri Sipil',2=>'Pegawai Tetap Non PNS (BLU)',4=>'Tenaga Kerja Kontrak');
    // $return = '<option value=""> seluruhnya </option>';
    foreach($result as $k => $v){
    // $return .= '<option value="'.$k.'">'.$v.'</option>';
      $return .= '<div class="col-md-3 col-lg-3">';
      $return .= '<div class="input-group small checkbox" style="border-bottom:1px solid #f00;margin:0;vertical-align:top;"><label style="margin:0;line-height:1;display:block;">';
      $return .= '<input type="checkbox" name="lampStatusLSPeg[]" id="lampStatusLSPeg" value="'.$k.'" style="line-height:1;margin-top:0;"/>';
      $return .= $v;
      $return .= '</label></div>';
      $return .= '</div>';
    }
    echo $return ;
    }

    function getOpsiUnitPeg(){
    $result = $this->db->query("SELECT * FROM kepeg_unit")->result();
    $i=0;
    $return = '<div class="row">';
    foreach($result as $v){
    if($i%4==0){
    $return.= '</div><div class="row">';
    }
    $return .= '<div class="col-md-3 col-lg-3">';
    $return .= '<div class="input-group small checkbox" style="border-bottom:1px solid #f00;margin:0;vertical-align:top;"><label style="margin:0;line-height:1;display:block;">';
    $return .= '<input type="checkbox" name="lampUnitLSPeg[]" id="lampUnitLSPeg" value="'.$v->id.'" style="line-height:1;margin-top:0;"/>';
    $return .= $v->unit;
    $return .= '</label></div>';
    $return .= '</div>';
    $i++;
    }
    $return.= '</div>';
    echo $return ;
    }

    function wordMonth($nilai){
    switch(intval($nilai)){
    case 1 : return "Januari";break;
    case 2 : return "Februari";break;
    case 3 : return "Maret";break;
    case 4 : return "April";break;
    case 5 : return "Mei";break;
    case 6 : return "Juni";break;
    case 7 : return "Juli";break;
    case 8 : return "Agustus";break;
    case 9 : return "September";break;
    case 10 : return "Oktober";break;
    case 11 : return "November";break;
    case 12 : return "Desember";break;
    }
    }

    function wordMonthShort($nilai){
    switch(intval($nilai)){
    case 1 : return "Jan";break;
    case 2 : return "Feb";break;
    case 3 : return "Mar";break;
    case 4 : return "Apr";break;
    case 5 : return "Mei";break;
    case 6 : return "Jun";break;
    case 7 : return "Jul";break;
    case 8 : return "Agu";break;
    case 9 : return "Sep";break;
    case 10 : return "Okt";break;
    case 11 : return "Nov";break;
    case 12 : return "Des";break;
    }
    }

    function getMonth($date){
    $exp=explode(" ",$date);
    $exl=explode("-",$exp[0]);
    return $exl[1];
    }

    function checkSPPLSPegawai(){
        if(isset($_GET)){
            $_POST = $_GET;
        }
        $button = "<a href=\"javascript:;\" id=\"reprocess_check_splss_pegawai\" class=\"btn btn-primary btn-flat btn-sm\"><i class=\"glyphicon glyphicon-repeat\"></i> Reprocess</a>";
        // echo "<pre>"; print_r($_GET); echo "</pre>"; echo $button; exit;
        $sql = "";
        $array = array('ikw','ipp');
        if(!isset($_POST['jenisLSPeg']) || !in_array(strtolower($_POST['jenisLSPeg']),$array)){
            echo "<p class=\"alert alert-warning\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i>&nbsp;&nbsp;&nbsp;Pilih jenis SPP LS Pegawai. Diperuntukan untuk pembuatan lampiran.</p>";
            exit;
        }
        $vSQL = " WHERE id_trans!= 0";
        if(isset($_POST['lampJenisLSPeg']) && in_array($_POST['lampJenisLSPeg'],array(1,2))){
            $vSQL .= " AND jenispeg = ".$_POST['lampJenisLSPeg'];
        }
        if(isset($_POST['lampStatusLSPeg']) && in_array($_POST['lampStatusLSPeg'],array(1,2,4))){
            if($_POST['lampStatusLSPeg']==1){
                $vSQL .= " AND ( statuspeg = 1 OR statuspeg = 3 )";
            }else{
                $vSQL .= " AND statuspeg = ".$_POST['lampStatusLSPeg'];
            }
        }
        if(isset($_POST['lampUnitLSPeg']) && count($_POST['lampUnitLSPeg'])>0){
            $vSQL .= " AND ( unitid = ".$_POST['lampUnitLSPeg'][0];
            if(count($_POST['lampUnitLSPeg'])>1){
                for($i=1;$i<(count($_POST['lampUnitLSPeg']));$i++){
                    $vSQL .= " OR unitid = ".$_POST['lampUnitLSPeg'][$i];
                }
            }
            $vSQL .= " )";
        }
        $sql.="SELECT * FROM rsa_detail_belanja_ WHERE id_rsa_detail = ".intval($_POST['id_rsa_detail']);
        // echo $sql.$button; exit;
        $hasil = $this->db->query($sql)->result();
        if(count($hasil)<=0){
            echo $this->msgGagal("Tidak ada data detail sub kegiatan yang dimaksud. <br/>".$button); exit;
        }
        if(isset($_POST['jenisLSPeg']) && strtolower($_POST['jenisLSPeg'])=='ipp'){
            $vSQL.=" AND tgl_transaksi LIKE '".$hasil[0]->tahun."%'";
            $sql = "SELECT SUM(a.ipp) AS total, SUM(a.netto) AS jumlah, SUM(a.potongan) AS potongan, a.unitid, b.unit, a.jenispeg, a.statuspeg, DATE_FORMAT(a.tgl_transaksi,'%Y') AS tahun, a.tgl_transaksi
                FROM kepeg_tr_ipp a LEFT JOIN kepeg_unit b ON a.unitid = b.id
                ".$vSQL." GROUP BY DATE_FORMAT(a.tgl_transaksi,'%Y')";
            // echo $sql.$button; exit;
            $penting = $this->db->query($sql)->result();
            if(count($penting)<=0){
                echo $this->msgGagal("Buat daftar penerima IPP untuk LS Pegawai terlebih dahulu melalui menu kepegawaian.<br/>".$button); exit;
            }
            if($hasil[0]->harga_satuan != $penting[0]->total){
                echo $this->msgGagal("Jumlah dana yang dibutuhkan antara daftar lampiran tidak sama dengan jumlah dana usulan.<br/>Cek kembali daftar pembayaran pegawai Anda.<br/>Jumlah Dana yang terdapat pada Daftar Pegawai : ".number_format($penting[0]->total,0,',','.')."<br/>Jumlah Dana yang diusulkan : ".number_format($hasil[0]->harga_satuan,0,',','.')."<br/>".$button); exit;
            }
            // masukkan ke tabel temporary, menunggu dibuat menjadi spp
            $_POST['tahun'] = $hasil[0]->tahun;
            $variabel = base64_encode(serialize($_POST));
            $sql = "INSERT INTO kepeg_tr_temp_sppls(id_rsa_detail, kode_akun_tambah, kode_usulan_belanja, variabel, waktu) VALUES('".intval($_POST['id_rsa_detail'])."', '".$hasil[0]->kode_akun_tambah."', '".$hasil[0]->kode_usulan_belanja."', '".$variabel."', NOW())";
            // echo $sql.$button;exit;
            $this->db->query($sql); // execute it
            echo "1"; exit;
        }elseif (isset($_POST['jenisLSPeg']) && strtolower($_POST['jenisLSPeg'])=='ikw'){
            $vSQL.=" AND a.tahun LIKE '".$hasil[0]->tahun."'";
            $sql = "SELECT SUM(a.ikw) AS total, SUM(a.netto) AS jumlah, SUM(a.pot_ikw) AS potongan, SUM(a.jml_pajak) AS jml_pajak, SUM(a.pot_lainnya) AS pot_lainnya, a.unitid, b.unit, a.jenispeg, a.statuspeg, a.tahun FROM kepeg_tr_ikw a LEFT JOIN kepeg_unit b ON a.unitid = b.id
            ".$vSQL." GROUP BY a.tahun";
            // echo $sql; exit;
            $penting = $this->db->query($sql)->result();
            if(count($penting)<=0){
                echo $this->msgGagal("Buat daftar penerima IKW untuk LS Pegawai terlebih dahulu melalui menu kepegawaian.<br/>".$button); exit;
            }
            if($hasil[0]->harga_satuan != $penting[0]->total){
                echo $this->msgGagal("Jumlah dana yang dibutuhkan antara daftar lampiran tidak sama dengan jumlah dana usulan.<br/>Cek kembali daftar pembayaran pegawai Anda.<br/>Jumlah Dana yang terdapat pada Daftar Pegawai : ".number_format($penting[0]->total,0,',','.')."<br/>Jumlah Dana yang diusulkan : ".number_format($hasil[0]->harga_satuan,0,',','.')."<br/>".$button); exit;
            }
            // masukkan ke tabel temporary, menunggu dibuat menjadi spp
            $_POST['tahun'] = $hasil[0]->tahun;
            $variabel = base64_encode(serialize($_POST));
            $sql = "INSERT INTO kepeg_tr_temp_sppls(id_rsa_detail, kode_akun_tambah, kode_usulan_belanja, variabel, waktu) VALUES('".intval($_POST['id_rsa_detail'])."', '".$hasil[0]->kode_akun_tambah."', '".$hasil[0]->kode_usulan_belanja."', '".$variabel."', NOW())";
            // echo $sql.$button;exit;
            $this->db->query($sql); // execute it
            echo "1"; exit;
        }
    }

    function getDataIPP($data){
        $vSQL = " WHERE id_trans!= 0";
        if(isset($data['lampJenisLSPeg']) && in_array($data['lampJenisLSPeg'],array(1,2))){
            $vSQL .= " AND jenispeg = ".$data['lampJenisLSPeg'];
        }
        if(isset($data['lampStatusLSPeg']) && in_array($data['lampStatusLSPeg'],array(1,2,4))){
            if($data['lampStatusLSPeg']==1){
                $vSQL .= " AND ( statuspeg = 1 OR statuspeg = 3 )";
            }else{
                $vSQL .= " AND statuspeg = ".$data['lampStatusLSPeg'];
            }
        }
        if(isset($data['lampUnitLSPeg']) && count($data['lampUnitLSPeg'])>0){
            $vSQL .= " AND ( unitid = ".$data['lampUnitLSPeg'][0];
            if(count($data['lampUnitLSPeg'])>1){
                for($i=1;$i<(count($data['lampUnitLSPeg']));$i++){
                    $vSQL .= " OR unitid = ".$data['lampUnitLSPeg'][$i];
                }
            }
            $vSQL .= " )";
        }
        $vSQL.=" AND tgl_transaksi LIKE '".$data['tahun']."%'";
        $sql = "SELECT SUM(a.ipp) AS total, SUM(a.netto) AS jumlah, SUM(a.potongan) AS pajak, a.unitid, b.unit, a.jenispeg, a.statuspeg, DATE_FORMAT(a.tgl_transaksi,'%Y') AS tahun, a.tgl_transaksi
            FROM kepeg_tr_ipp a LEFT JOIN kepeg_unit b ON a.unitid = b.id
            ".$vSQL." GROUP BY DATE_FORMAT(a.tgl_transaksi,'%Y')";
        $penting = $this->db->query($sql)->result();
        return array('jumlah_bayar'=>$penting[0]->jumlah, 'pajak'=>$penting[0]->pajak, 'potongan'=>0, 'tanggal'=>$penting[0]->tgl_transaksi);
    }

    function getDataIKW($data){
        $vSQL = " WHERE id_trans!= 0";
        if(isset($data['lampJenisLSPeg']) && in_array($data['lampJenisLSPeg'],array(1,2))){
            $vSQL .= " AND jenispeg = ".$data['lampJenisLSPeg'];
        }
        if(isset($data['lampStatusLSPeg']) && in_array($data['lampStatusLSPeg'],array(1,2,4))){
            if($data['lampStatusLSPeg']==1){
                $vSQL .= " AND ( statuspeg = 1 OR statuspeg = 3 )";
            }else{
                $vSQL .= " AND statuspeg = ".$data['lampStatusLSPeg'];
            }
        }
        if(isset($data['lampUnitLSPeg']) && count($data['lampUnitLSPeg'])>0){
            $vSQL .= " AND ( unitid = ".$data['lampUnitLSPeg'][0];
            if(count($data['lampUnitLSPeg'])>1){
                for($i=1;$i<(count($data['lampUnitLSPeg']));$i++){
                    $vSQL .= " OR unitid = ".$data['lampUnitLSPeg'][$i];
                }
            }
            $vSQL .= " )";
        }
        $vSQL.=" AND a.tahun LIKE '".$hasil[0]->tahun."'";
            $sql = "SELECT SUM(a.ikw) AS total, SUM(a.netto) AS jumlah, SUM(a.pot_ikw) AS potongan, SUM(a.jml_pajak) AS jml_pajak, SUM(a.pot_lainnya) AS pot_lainnya, a.unitid, b.unit, a.jenispeg, a.statuspeg, a.tahun FROM kepeg_tr_ikw a LEFT JOIN kepeg_unit b ON a.unitid = b.id
            ".$vSQL." GROUP BY a.tahun";
        $penting = $this->db->query($sql)->result();
        return array('jumlah_bayar'=>$penting[0]->jumlah, 'pajak'=>$penting[0]->jml_pajak, 'potongan'=>($penting[0]->pot_lainnya+$penting[0]->potongan), 'tanggal'=>date('Y-m-d'));
    }

    function checkSPPLSExist($data){
        $sqlCheck = "SELECT id_sppls FROM kepeg_tr_sppls WHERE detail_belanja LIKE '".$data['akun_i']."' AND jenissppls LIKE '".$data['jenisLSPeg']."' AND tahun LIKE '".$data['tahun']."'";
        $cek = $this->db->query($sqlCheck)->result();
        if(count($cek)>0){
            return true;
        }
        return false;
    }

    function getSPPLSID($data){
        $sqlCheck = "SELECT id_sppls FROM kepeg_tr_sppls WHERE detail_belanja LIKE '".$data['akun_i']."' AND jenissppls LIKE '".$data['jenisLSPeg']."' AND tahun LIKE '".$data['tahun']."'";
        $cek = $this->db->query($sqlCheck)->result();
        if(count($cek)>0){
            return $cek[0]->id_sppls;
        }
        return false;
    }

    function createSPPLSPeg($data){
        $sql = "INSERT INTO kepeg_tr_sppls(tahun, tanggal, jumlah_bayar, total_sumberdana, jenissppls, detail_belanja, potongan, pajak, namabpsukpa, nipbpsukpa, unitsukpa) VALUES ('".$data['tahun']."', NOW(), ".$data['jumlah_bayar'].", ".$data['total_sumberdana'].", '".$data['jenisLSPeg']."', '".$data['akun_i']."', '".$data['potongan']."', '".$data['pajak']."', '".$data['namabpsukpa']."', '".$data['nipbpsukpa']."', '".$data['unitsukpa']."')";
        $this->db->query($sql);
        $id_sppls = $this->db->insert_id();
        $id_sppls2 = "";
        $jm = strlen($id_sppls);
        for($i=0;$i<(5-$jm);$i++){
            $id_sppls2 .= "0";
        }
        $id_sppls2 .= $id_sppls;
        $alias = $this->check_session->get_alias();
        $cur_tahun= $data['tahun'];
        $cur_bulan = $this->wordMonthShort(date('m'));
        $nomor = $id_sppls2."/".$alias."/SPP-LS PGW/".strtoupper($cur_bulan)."/".$cur_tahun;
        $sql = "UPDATE kepeg_tr_sppls SET nomor = '".$nomor."' WHERE id_sppls = ".$id_sppls;
        $this->db->query($sql);
        return $id_sppls; exit;
    }

    function createSPMfromSPP($id){
        $sql = "SELECT * FROM kepeg_tr_sppls WHERE id_sppls = ".$id." AND proses = 2";
        $r = $this->db->query($sql)->result();
        if(count($r)>0){
            $bpp = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], $_SESSION['rsa_level']);
            $ppk = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '14');
            $kpa = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], '2');
            $buu = $this->user_model->get_detail_rsa_user('99', '5');
            $kbuu = $this->user_model->get_detail_rsa_user('99', '11');
            $bver = $this->user_model->get_detail_rsa_user('99', '3');
            $sql = "INSERT INTO kepeg_tr_spmls(
                        id_tr_sppls,
                        namabp,
                        nipbp,
                        jumlah_bayar,
                        nomor,
                        tanggal,
                        tahun,
                        detail_belanja,
                        potongan,
                        pajak,
                        total_sumberdana,
                        namappk,
                        nipppk,
                        namakpa,
                        nipkpa,
                        namaver,
                        nipver,
                        namabuu,
                        nipbuu,
                        namakbuu,
                        nipkbuu,
                        unitsukpa,
                        namaunitsukpa
                    ) VALUES (
                        '".$id."',
                        '".$bpp->nm_lengkap."',
                        '".$bpp->nomor_induk."',
                        '".$r[0]->jumlah_bayar."',
                        '',
                        NOW(),
                        '".$r[0]->tahun."',
                        '".$r[0]->detail_belanja."',
                        '".$r[0]->potongan."',
                        '".$r[0]->pajak."',
                        '".$r[0]->total_sumberdana."',
                        '".$ppk->nm_lengkap."',
                        '".$ppk->nomor_induk."',
                        '".$kpa->nm_lengkap."',
                        '".$kpa->nomor_induk."',
                        '".$bver->nm_lengkap."',
                        '".$bver->nomor_induk."',
                        '".$buu->nm_lengkap."',
                        '".$buu->nomor_induk."',
                        '".$kbuu->nm_lengkap."',
                        '".$kbuu->nomor_induk."',
                        '".$r[0]->unitsukpa."',
                        '".$_SESSION['rsa_nama_unit']."'
                    )";
            // echo $sql; exit;
            $this->db->query($sql);
            $id_spmls = $this->db->insert_id();
            $id_spmls2 = "";
            $jm = strlen($id_spmls);
            for($i=0;$i<(5-$jm);$i++){
                $id_spmls2 .= "0";
            }
            $id_spmls2 .= $id_spmls;
            $alias = $this->check_session->get_alias();
            $cur_tahun= $r[0]->tahun;
            $cur_bulan = $this->wordMonthShort(date('m'));
            $nomor = $id_spmls2."/".$alias."/SPM-LS PGW/".strtoupper($cur_bulan)."/".$cur_tahun;
            $sql = "UPDATE kepeg_tr_spmls SET nomor = '".$nomor."' WHERE id_spmls = ".$id_spmls;
            $this->db->query($sql);
            return $id_spmls; exit;
        }
    }

    function prosesSPPLS(){
        // print_r($_POST); exit;
        $sql = "";
        $akun = explode(",",$_POST['akunSPPLS']);
        $akun_k = array_search('', $akun);
        unset($akun[$akun_k]);
        $sql.="SELECT SUM(harga_satuan) AS nominal, tahun FROM rsa_detail_belanja_ WHERE id_rsa_detail!=0 AND ";
        $sql2 = "SELECT variabel FROM kepeg_tr_temp_sppls WHERE id!=0 AND ";
        $i=0;
        foreach ($akun as $k => $v) {
            $vSQL2[$i]="(kode_usulan_belanja LIKE '".substr($v, 0, -3)."' AND kode_akun_tambah LIKE '".substr($v, -3)."')";
            $i++;
        }
        $vSQL2 = implode(" OR ", $vSQL2);
        $sql = $sql.$vSQL2." GROUP BY tahun";
        $sql2 = $sql2.$vSQL2;
        // echo $sql; echo "<br />"; echo $sql2; exit;
        $hasil = $this->db->query($sql)->result();
        $penting = $this->db->query($sql2)->result();
        $data['pajak'] = 0;
        $data['jumlah_bayar'] = 0;
        $data['potongan'] = 0;
        foreach ($penting as $key => $value) {
            $x = unserialize(base64_decode($value->variabel));
            // print_r($x);
            if($x['jenisLSPeg']=='ipp'){
                $y = $this->getDataIPP($x);
            }elseif($x['jenisLSPeg']=='ikw'){
                $y = $this->getDataIKW($x);
            }
            $data['jumlah_bayar'] += $y['jumlah_bayar'];
            $data['pajak'] += $y['pajak'];
            $data['potongan'] += $y['potongan'];
            $data['jenisLSPeg'] = $x['jenisLSPeg'];
        }
        $data['akun_i'] = implode(",", $akun);
        $data['total_sumberdana'] = $hasil[0]->nominal;
        $data['tahun'] = $hasil[0]->tahun;
        $data['namabpsukpa'] = "-";
        $data['nipbpsukpa'] = "-";
        $data['unitsukpa'] = $_SESSION['rsa_kode_unit_subunit'];
        $q = $this->db->query("SELECT * FROM rsa_user WHERE kode_unit_subunit = '".$this->check_session->get_unit()."' AND flag_aktif LIKE 'ya' AND level = '13'")->result();
        if(count($q[0])>0){
            $data['namabpsukpa'] = $q[0]->nm_lengkap;
            $data['nipbpsukpa'] = $q[0]->nomor_induk;
        }
        unset($q);
        // cek spplspeg
        // print_r($data); exit;
        // var_dump($this->checkSPPLSExist($data)); exit;
        if(!$this->checkSPPLSExist($data)){

            echo $this->createSPPLSPeg($data);
        }else{
            echo $this->getSPPLSID($data);
        }
        exit;
    }

    function sppLS(){
        $d = $this->uri->uri_to_assoc(3);
        $sql = "SELECT * FROM kepeg_tr_sppls WHERE id_sppls =".intval($d['id']);
        $sub = $this->db->query($sql)->result();
        $akun = explode(",",$sub[0]->detail_belanja);
        $sql = "SELECT * FROM rsa_detail_belanja_ WHERE id_rsa_detail!=0 AND";
        $i=0;
        foreach ($akun as $k => $v) {
            $vSQL2[$i]="kode_usulan_belanja LIKE '".substr($v, 0, -3)."' AND kode_akun_tambah LIKE '".substr($v, -3)."'";
            $i++;
        }
        $vSQL2 = implode(" OR ", $vSQL2);
        $sql = $sql."(".$vSQL2.") ORDER BY kode_akun_tambah ASC";
        $akun = $this->db->query($sql)->result();
        $subdata['cur_tahun'] = $sub[0]->tahun;
        $subdata['cur_bulan'] = $this->wordMonthShort($this->getMonth($sub['0']->tanggal));
        $subdata['tgl_spp'] = $sub[0]->tanggal;
        $subdata['unit_kerja'] = $this->check_session->get_nama_unit();
        $subdata['unit_id'] = $this->check_session->get_unit();
        $subdata['alias'] = $this->check_session->get_alias();
        $subdata['detail_up'] = $sub[0];
        $subdata['akun_detail'] = $akun;
        $jm = strlen($sub[0]->id_sppls);
        $subdata['id_sppls'] = "";
        for($i=0;$i<(5-$jm);$i++){
            $subdata['id_sppls'] .= "0";
        }
        $subdata['id_sppls'] .= $sub[0]->id_sppls;
        $q = $this->db->query("SELECT * FROM rsa_user WHERE kode_unit_subunit = '".$this->check_session->get_unit()."' AND level = '13'")->result();
        if(count($q)>0){
            $subdata['detail_pic'] = $q[0];
        }else{
            $subdata['detail_pic'] = "";
        }
        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view("tor/form-sppls",$subdata,TRUE);
        $this->load->view('main_template',$data);
    }
    function simpanSPPLSPeg(){
        $sql = "UPDATE `kepeg_tr_sppls` SET `".$_POST['id']."` = '".htmlentities($_POST['value'],ENT_QUOTES)."' WHERE id_sppls = ".$_POST['key'];
        $this->db->query($sql);
        exit;
    }
    function sppLScetak(){
        $d = $this->uri->uri_to_assoc(3);
        $sql = "SELECT * FROM kepeg_tr_sppls WHERE id_sppls =".intval($d['id']);
        $sub = $this->db->query($sql)->result();
        $jm = strlen($sub[0]->id_sppls);
        $subdata['id_sppls'] = "";
        for($i=0;$i<(5-$jm);$i++){
            $subdata['id_sppls'] .= "0";
        }
        $subdata['id_sppls'] .= $sub[0]->id_sppls;
        if($this->input->post('dtable')){
            $data['main_content'] = base64_decode($this->input->post('dtable'));
            $this->load->view('cetak_template',$data);
        }
    }
    function daftar_spplspeg(){
        $vSQL = "";
        if($_SESSION['rsa_level']=='14'){
            $vSQL= " AND proses = 1";
        }
        $subdata['daftar_spplspeg'] = array();
        $subdata['cur_tahun'] = 0;
        $sql = "SELECT tahun FROM kepeg_tr_sppls GROUP BY tahun ORDER BY tahun ASC";
        $subdata['tahun'] = $this->db->query($sql)->result();
        $d = $this->uri->uri_to_assoc(3);
        if(isset($d['tahun'])){
            $sql = "SELECT a.*,DATE_FORMAT(a.tanggal, '%d %M %Y') as tanggal2,COUNT(b.id) AS jml_tolak FROM kepeg_tr_sppls a LEFT JOIN kepeg_tr_sppls_detail b ON a.id_sppls = b.id_tr_sppls WHERE tahun LIKE '".intval($d['tahun'])."'".$vSQL." GROUP BY a.id_sppls ORDER BY a.tanggal DESC";
            $subdata['daftar_spplspeg'] = $this->db->query($sql)->result();
            $subdata['cur_tahun'] = $d['tahun'];
        }
        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view("tor/daftar_spplspeg",$subdata,TRUE);
        $this->load->view('main_template',$data);
    }
    function spp_to_spm(){
        $status = "Pengajuan";
        if($_POST['proses']==0){
            $pelaku = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], $_SESSION['rsa_level']);
            $sql = "INSERT INTO kepeg_tr_sppls_detail(id_tr_sppls, alasan_tolak, penolak, waktu_proses) VALUES('".$_POST['id_sppls']."', '".htmlentities($_POST['alasan_tolak'],ENT_QUOTES)."', '".$pelaku->nama." - ".$_SESSION['rsa_nama_unit']."', NOW())";
            $this->db->query($sql);
            $status = "Ditolak PPPK";
        }
        if($_POST['proses']==2){
            $status = "disetujui PPPK";
        }
        if($_POST['proses']==3){
            $status = "diajukan SPM";
            $this->createSPMfromSPP($_POST['id_sppls']);
        }
        $sql = "UPDATE kepeg_tr_sppls SET proses = ".intval($_POST['proses']).", status = '".$status."' WHERE id_sppls = ".intval($_POST['id_sppls']);
        if($this->db->query($sql)){
            echo "1"; exit;
        }
        echo $this->msgGagal('Kegagalan sistem memproses perintah.');
        exit;
    }
    function spp_tolak_detail(){
        if(isset($_POST['id_sppls'])){
            $sql = "SELECT * FROM kepeg_tr_sppls_detail WHERE id_tr_sppls = ".intval($_POST['id_sppls']);
            $r = $this->db->query($sql)->result();
            if(count($r)>0){
                echo "<table class=\"table table-bordered small\">";
                echo "<tr><th class=\"text-center\">No</th><th class=\"text-center\">Tanggal</th><th class=\"text-center\">Alasan</th><th class=\"text-center\">Penolak</th></tr>";
                $i=1;
                foreach ($r as $k => $v) {
                    echo "<tr>";
                    echo "<td class=\"text-right\">".$i."</td>";
                    echo "<td>".$v->waktu_proses."</td>";
                    echo "<td>".html_entity_decode($v->alasan_tolak,ENT_QUOTES)."</td>";
                    echo "<td>".$v->penolak."</td>";
                    echo "</tr>";
                    $i++;
                }
                echo "</table>";
            }else{
                echo "<p class=\"alert alert-warning\">Tidak ada data penolakan.</p>";
            }
            exit;
        }
    }
    function daftar_spmlspeg(){
        $vSQL = "";
        if($_SESSION['rsa_level']=='2'){
            $vSQL= " AND a.proses = 1";
            $subdata['rel'] = 2;
        }
        if($_SESSION['rsa_level']=='3'){
            $vSQL= " AND a.proses = 2";
            $subdata['rel'] = 3;
        }
        if($_SESSION['rsa_level']=='5'){
            $vSQL= " AND a.proses = 3";
            $subdata['rel'] = 4;
        }
        if($_SESSION['rsa_level']=='11'){
            $vSQL= " AND (a.proses = 4 OR a.proses = 3)";
            $subdata['rel'] = 5;
        }
        $subdata['daftar_spmlspeg'] = array();
        $subdata['cur_tahun'] = 0;
        $sql = "SELECT tahun FROM kepeg_tr_spmls GROUP BY tahun ORDER BY tahun ASC";
        $subdata['tahun'] = $this->db->query($sql)->result();
        $sql = "SELECT * FROM akun_kas6 WHERE kd_kas_6 LIKE '%1'";
        $subdata['akun_cair'] = $this->db->query($sql)->result();
        $d = $this->uri->uri_to_assoc(3);
        if(isset($d['tahun'])){
            $sql = "SELECT a.*,DATE_FORMAT(a.tanggal, '%d %M %Y') as tanggal2,COUNT(b.id) AS jml_tolak, c.untuk_bayar FROM kepeg_tr_spmls a LEFT JOIN kepeg_tr_spmls_detail b ON a.id_spmls = b.id_tr_spmls LEFT JOIN kepeg_tr_sppls c ON a.id_tr_sppls = c.id_sppls WHERE a.tahun LIKE '".intval($d['tahun'])."'".$vSQL." GROUP BY a.id_spmls ORDER BY a.tanggal DESC";
            $subdata['daftar_spmlspeg'] = $this->db->query($sql)->result();
            $subdata['cur_tahun'] = $d['tahun'];
        }
        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view("tor/daftar_spmlspeg",$subdata,TRUE);
        $this->load->view('main_template',$data);
    }
    function spm_to_cair(){
        $pelaku = $this->user_model->get_detail_rsa_user($_SESSION['rsa_kode_unit_subunit'], $_SESSION['rsa_level']);
        $status = "Pengajuan";
        if($_POST['proses']==0){
            $sql = "INSERT INTO kepeg_tr_spmls_detail(id_tr_spmls, alasan_tolak, penolak, waktu_proses) VALUES('".$_POST['id_spmls']."', '".htmlentities($_POST['alasan_tolak'],ENT_QUOTES)."', '".$pelaku->nama."', NOW())";
            $this->db->query($sql);
            $status = "Ditolak ".$pelaku->nama;
        }
        if($_POST['proses']==1){
            $status = "Pengajuan ke KPA";
        }
        if(in_array(intval($_POST['proses']),array(2,3,4))){
            $status = "disetujui ".$pelaku->nama;
        }
        if($_POST['proses']==5){
            $status = "dicairkan oleh KBUU";
            // $this->createSPMfromSPP($_POST['id_sppls']);
        }
        $sql = "UPDATE `kepeg_tr_spmls` SET `proses` = ".intval($_POST['proses']).", `status` = '".$status."' WHERE `id_spmls` = ".intval($_POST['id_spmls']);
        if($this->db->query($sql)){
            echo "1"; exit;
        }
        echo $this->msgGagal('Kegagalan sistem memproses perintah.');
        exit;
    }
    function spm_tolak_detail(){
        if(isset($_POST['id_spmls'])){
            $sql = "SELECT * FROM kepeg_tr_spmls_detail WHERE id_tr_spmls = ".intval($_POST['id_spmls']);
            $r = $this->db->query($sql)->result();
            if(count($r)>0){
                echo "<table class=\"table table-bordered small\">";
                echo "<tr><th class=\"text-center\">No</th><th class=\"text-center\">Tanggal</th><th class=\"text-center\">Alasan</th><th class=\"text-center\">Penolak</th></tr>";
                $i=1;
                foreach ($r as $k => $v) {
                    echo "<tr>";
                    echo "<td class=\"text-right\">".$i."</td>";
                    echo "<td>".$v->waktu_proses."</td>";
                    echo "<td>".html_entity_decode($v->alasan_tolak,ENT_QUOTES)."</td>";
                    echo "<td>".$v->penolak."</td>";
                    echo "</tr>";
                    $i++;
                }
                echo "</table>";
            }else{
                echo "<p class=\"alert alert-warning\">Tidak ada data penolakan.</p>";
            }
            exit;
        }
    }
    function spmls(){
        $d = $this->uri->uri_to_assoc(3);
        $sql = "SELECT * FROM kepeg_tr_spmls WHERE id_spmls =".intval($d['id']);
        $sub = $this->db->query($sql)->result();
        $akun = explode(",",$sub[0]->detail_belanja);
        $sql = "SELECT * FROM rsa_detail_belanja_ WHERE id_rsa_detail!=0 AND";
        $i=0;
        foreach ($akun as $k => $v) {
            $vSQL2[$i]="kode_usulan_belanja LIKE '".substr($v, 0, -3)."' AND kode_akun_tambah LIKE '".substr($v, -3)."'";
            $i++;
        }
        $vSQL2 = implode(" OR ", $vSQL2);
        $sql = $sql."(".$vSQL2.") ORDER BY kode_akun_tambah ASC";
        $akun = $this->db->query($sql)->result();
        $subdata['cur_tahun'] = $sub[0]->tahun;
        $subdata['cur_bulan'] = $this->wordMonthShort($this->getMonth($sub['0']->tanggal));
        $subdata['tgl_spp'] = $sub[0]->tanggal;
        $subdata['unit_kerja'] = $sub[0]->namaunitsukpa;
        // $subdata['unit_id'] = $this->check_session->get_unit();
        $subdata['alias'] = "WR2";
        $subdata['detail_up'] = $sub[0];
        $subdata['akun_detail'] = $akun;
        $jm = strlen($sub[0]->id_spmls);
        $subdata['id_spmls'] = "";
        for($i=0;$i<(5-$jm);$i++){
            $subdata['id_spmls'] .= "0";
        }
        $subdata['id_spmls'] .= $sub[0]->id_spmls;
        $subdata['bpp'] = $this->user_model->get_detail_rsa_user($sub[0]->unitsukpa, '13');
        $subdata['ppk'] = $this->user_model->get_detail_rsa_user($sub[0]->unitsukpa, '14');
        $subdata['kpa'] = $this->user_model->get_detail_rsa_user($sub[0]->unitsukpa, '2');
        $subdata['buu'] = $this->user_model->get_detail_rsa_user('99', '5');
        $subdata['kbuu'] = $this->user_model->get_detail_rsa_user('99', '11');
        $subdata['bver'] = $this->user_model->get_detail_rsa_user('99', '3');
        $data['user_menu']  = $this->load->view('user_menu','',TRUE);
        $data['main_menu']  = $this->load->view('main_menu','',TRUE);
        $data['main_content'] = $this->load->view("tor/form-spmls",$subdata,TRUE);
        $this->load->view('main_template',$data);
    }
    // END HERE
}
