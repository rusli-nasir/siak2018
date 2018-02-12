<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fixer extends MY_Controller {
	public function __construct(){
        // $this->cek_session_in();

		parent::__construct();
        $this->load->model(array('rsa_gup_model','setting_up_model'));
        $this->load->model("user_model");
        $this->load->model("unit_model");
        $this->load->model('menu_model');
        $this->load->model('akuntansi/Kuitansi_model', 'Kuitansi_model');
        $this->load->model('akuntansi/Akun_model', 'Akun_model');
        $this->load->model('akuntansi/Coba_model', 'Coba_model');
        $this->load->model('akuntansi/Pajak_model', 'Pajak_model');
        $this->load->model('akuntansi/Laporan_model', 'Laporan_model');
        $this->load->model('akuntansi/Spm_model', 'Spm_model');
        $this->load->model('akuntansi/User_akuntansi_model', 'User_akuntansi_model');
        $this->load->model('akuntansi/Jurnal_rsa_model', 'Jurnal_rsa_model');
        $this->load->model('akuntansi/Akun_belanja_rsa_model', 'Akun_belanja_rsa_model');
	}

    public function fix_double()
    {
        die('disabled');
        $data = array();
        $awal = $this->db->query(
                "SELECT *, COUNT(*) c FROM 
                    (SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis <> 'penerimaan' AND jenis <> 'NK') as tabel
                GROUP BY uraian,no_bukti,id_kuitansi,jenis HAVING c > 1
                "
        )->result_array();

        // print_r($awal);die();


        // $entry = $awal[0];
        // $del = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi' => $entry['id_kuitansi'],'no_bukti' => $entry['no_bukti'], 'jenis'=> $entry['jenis'],'uraian' => $entry['uraian']))->row_array();
        // $each = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi' => $entry['id_kuitansi'],'no_bukti' => $entry['no_bukti'], 'jenis'=> $entry['jenis'],'uraian' => $entry['uraian']))->result_array();

        foreach ($awal as $entry) {
            $del = $this->db->get_where('akuntansi_kuitansi_jadi',array('id_kuitansi' => $entry['id_kuitansi'],'no_bukti' => $entry['no_bukti'], 'jenis'=> $entry['jenis'],'uraian' => $entry['uraian']))->row_array();
            $this->deletion_double($del);
        }
        die('selesai');

        // $this->deletion_double($del);
        // if ($this->input->post('del_double')){
        //     $data['jenis'] = 'hapus';
        //     $this->load->view('akuntansi/fixer/form_fix_double',$data);
        //     $this->deletion_double($del);
        // }else{
        //     $data['jenis'] = 'list';
        //     $this->load->view('akuntansi/fixer/form_fix_double',$data);
        //     echo "<pre>";
        //     print_r($del);
        //     print_r($each);
        //     echo "</pre>";
        // }
    }

    public function deletion_double($del)
    {
        die('disabled');
        $hasil = true;
        if ($del['id_pajak'] != null){
            $this->db->where('id_kuitansi_jadi',$del['id_pajak']);
            $hasil = $hasil and $this->db->delete('akuntansi_kuitansi_jadi');
        }
        $this->db->where($del);
        $hasil = $hasil and $this->db->delete('akuntansi_kuitansi_jadi');
        // $hasil = $this->db->get('akuntansi_kuitansi_jadi')->result_array();
        if ($hasil){
            echo "berhasil menghapus ".$del['id_kuitansi']." <br/>";
        }else{
            echo "gagal menghapus ".$del['id_kuitansi']."<br/>";
        }
    }

    public function fix_lspg()
    {
        die('disabled');
        $awal = $this->db->query("SELECT * FROM `akuntansi_kuitansi_jadi` WHERE `jenis` = 'NK' AND `tanggal_jurnal` > '2017-07-19' AND `tipe` != 'pajak'")->result_array();
        foreach ($awal as $entry) {
            $this->deletion_double($entry);
        }
        
    }

    public function fix_kode_kegiatan_lspg()
    {
        $data_siak = $this->db->query("SELECT * FROM akuntansi_kuitansi_jadi WHERE jenis = 'NK' AND LENGTH(kode_kegiatan) = 100")->result_array();

        echo "<pre>";

        foreach ($data_siak as $kuitansi) {
            $this->db
                    ->select('detail_belanja')
                    ->from('kepeg_tr_spmls')
                    ->where('nomor',$kuitansi['no_spm'])
                    ->where('flag_proses_akuntansi',1)
                ;

            echo $kuitansi['kode_kegiatan']."\n";
            echo $this->db->get()->row_array()['detail_belanja']."\n";
            echo "\n";
        }
    }



    
    }
