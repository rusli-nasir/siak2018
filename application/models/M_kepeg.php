<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_kepeg extends CI_Model {
/* -------------- Constructor ------------- */

		
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				$this->db2 = $this->load->database('rba', TRUE);
        }
        
        function getpegawai(){
            
            $data=$this->db->query('select kepeg_tb_pegawai.nama,kepeg_tb_pegawai.nip,kepeg_tb_pegawai.golongan_id from kepeg_tb_pegawai ');	
            // $data=$this->db->query('select kepeg_tb_pegawai.nama,kepeg_tb_pegawai.nip,kepeg_tb_golongan.gol from kepeg_tb_pegawai LEFT OUTER JOIN kepeg_tb_golongan on kepeg_tb_pegawai.golongan_id=kepeg_tb_golongan.gol');	
            return $data;
        }
        
        
        
        function jmlpeg(){
		return $this->db->get('kepeg_tb_pegawai')->num_rows();
	}
        
        
        function caridata(){
		return $this->db->get('kepeg_tb_pegawai')->num_rows();
	}
        
        function cari_judul($kode)
            {
             $this->db->like('nama',$kode);
             $this->db->like('nip',$kode);
             $this->db->order_by('nama', 'ASC');
             $query=$this->db->get('kepeg_tb_pegawai');
             return $query->result();
            }
            
        function get_pegawai_fakultas($id_fak){
            $query="SELECT * FROM kepeg_tb_pegawai WHERE unit_id='$id_fak' order by nip";
            $data = $this->db->query($query);
            return $data;
        } 
        
         function getpegawai_pns_dosen_fak($id_fak){
            $query="select * from kepeg_tb_pegawai where (status='1' ) and jnspeg='1' and status_kepeg='1' and unit_id='$id_fak' order by nip";
            $data=$this->db->query($query);	
            return $data;
        }
        
        function getpegawai_pns_fak($id_fak){
            $query="select * from kepeg_tb_pegawai where status='1' and status_kepeg='1' and unit_id='$id_fak' order by nip";
            $data=$this->db->query($query);	
            return $data;
        }
        
         function getpegawai_blu_fak($id_fak){
            $query="select * from kepeg_tb_pegawai where status='1'  and jnspeg='2' and status_kepeg='2' and unit_id='$id_fak' order by nip";
            $data=$this->db->query($query);	
            return $data;
        }
        
         function getpegawai_cpns_fak($id_fak){
            $query="select * from kepeg_tb_pegawai where status='1' and jnspeg='2' and status_kepeg='3' and unit_id='$id_fak' order by nip";
            $data=$this->db->query($query);	
            return $data;
        }
        
        function getpegawai_kontrak_fak($id_fak){
            $query="select * from kepeg_tb_pegawai where status='1'  and jnspeg='2' and status_kepeg='4' and unit_id='$id_fak' order by nip";
            $data=$this->db->query($query);	
            return $data;
        }
        
        function get_gaji($bulan,$tahun,$nip){
            $query="SELECT bersih from kepeg_tb_transaksi_gaji WHERE bulan='$bulan' and tahun='$tahun' and nip='$nip'";
            $data = $this->db->query($query);
            return $data;
            
        }
        
         function cari_get_gaji_q($bulan,$tahun,$nip){
            $query="SELECT count(nip) as hasil  FROM `kepeg_tb_transaksi_gaji` WHERE `bulan`='$bulan' and `tahun`='$tahun' and `nip`='$nip'";
            $data = $this->db->query($query);
            return $data;
            
        }
        
         function cari_get_gaji_q_nonpns($bulan,$tahun,$nip){
            $query="SELECT count(nip) as hasil  FROM `kepeg_tr_gaji_nonpns` WHERE `bulan`='$bulan' and `tahun`='$tahun' and `nip` like '%$nip%'";
            $data = $this->db->query($query);
            return $data;
            
        }
        
           function cari_get_gaji_data($bulan,$tahun,$nip){
            $query="SELECT *  FROM `kepeg_tb_transaksi_gaji` WHERE `bulan`='$bulan' and `tahun`='$tahun' and `nip`='$nip'";
            $data = $this->db->query($query);
            return $data;
            
        }
        
         function cari_get_gaji_data_nonpns($bulan,$tahun,$nip){
            $query="SELECT *  FROM `kepeg_tr_gaji_nonpns` WHERE `bulan`='$bulan' and `tahun`='$tahun' and `nip` like '%$nip%'";
            $data = $this->db->query($query);
            return $data;
            
        }
        
        
        
         function cari_get_gaji($bulan,$tahun,$nip){
            $this->db->where('bulan', $bulan);
            $this->db->where('tahun', $tahun);
            $this->db->where('nip', $nip);
            $this->db->from('kepeg_tb_transaksi_gaji');
            $data= $this->db->count_all_results();
            return $data;
            
        }
        
        function TanggalIndo($date){
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);
 
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
	return($result);
}


function get_nm_fak($id_fak){
    if($id_fak=="1"){
                    $nama_fak="Fakultas Hukum";
                }else 
                if($id_fak=="2"){
                    $nama_fak="Fakultas Hukum";
                }else 
                if($id_fak=="3"){
                    $nama_fak="Fakultas Teknik";
                }else     
                if($id_fak=="4"){
                    $nama_fak="Fakultas Kedokteran";
                }else 
                if($id_fak=="5"){
                    $nama_fak="Fakultas Peternakan dan Pertanian";
                }else 
                if($id_fak=="6"){
                    $nama_fak="Fakultas Ilmu Budaya";
                }else 
                if($id_fak=="7"){
                    $nama_fak="Fakultas Ilmu Sosial dan Ilmu Politik";
                }else     
                if($id_fak=="8"){
                    $nama_fak="Fakultas Sains dan Matematika";
                }else
                if($id_fak=="9"){
                    $nama_fak="Fakultas Kesehatan Masyarakat";
                }else
                if($id_fak=="10"){
                    $nama_fak="Fakultas Perikanan dan Ilmu Kelautan";
                }else
                if($id_fak=="11"){
                    $nama_fak="Fakultas Psikologis";
                }else    
                if($id_fak=="12"){
                    $nama_fak="Sekolah Pascasarjana";
                }   
                return $nama_fak;
}


}