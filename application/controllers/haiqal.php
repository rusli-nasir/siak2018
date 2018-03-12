<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Haiqal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{

      for ($i=1; $i <= 9 ; $i++) { 

        if ($i == 5) {
          $i = 8;
        }

        switch ($i) {
          case '1':
          $tabel = 'aset';
          break;

          case '2':
          $tabel = 'hutang';
          break;

          case '3':
          $tabel = 'aset_bersih';
          break;

          case '4':
          $tabel = 'lra';
          break;

          case '8':
          $tabel = 'pembiayaan';
          break;

          case '9':
          $tabel = 'sal';
          break;
          
          
        }

        $this->db->query("CREATE VIEW akuntansi_".$tabel."_1 AS
          SELECT DISTINCT kode_akun1digit as id_akuntansi_".$tabel."_1, kode_akun1digit as akun_1, nama_akun1digit as nama
          FROM rba_2018.akun_belanja
          WHERE kode_akun1digit = ".$i."");

        $this->db->query("CREATE VIEW akuntansi_".$tabel."_2 AS
        SELECT DISTINCT kode_akun2digit as id_".$tabel."_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama
        FROM rba_2018.akun_belanja
        WHERE kode_akun1digit = ".$i."
        ORDER BY akun_1");

          $this->db->query("CREATE VIEW akuntansi_".$tabel."_3 AS
        	SELECT DISTINCT kode_akun3digit as id_".$tabel."_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama
        	FROM rba_2018.akun_belanja
        WHERE kode_akun1digit = ".$i."
        ORDER BY akun_1");

        $this->db->query("CREATE VIEW akuntansi_".$tabel."_4 AS
        	SELECT DISTINCT kode_akun4digit as  id_".$tabel."_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama
        	FROM rba_2018.akun_belanja
        	WHERE kode_akun1digit = ".$i."
        	ORDER BY akun_1");

        $this->db->query("CREATE VIEW akuntansi_".$tabel."_5 AS
        	SELECT DISTINCT kode_akun5digit as  id_".$tabel."_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama
        	FROM rba_2018.akun_belanja
        	WHERE kode_akun1digit = ".$i."
        	ORDER BY akun_1");

        $this->db->query("CREATE VIEW akuntansi_".$tabel."_6 AS
        	SELECT DISTINCT kode_akun as  id_".$tabel."_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama
        	FROM rba_2018.akun_belanja
        	WHERE kode_akun1digit = ".$i."
        	ORDER BY akun_1");
  
        // SELECT DISTINCT kode_akun3digit as id, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama
        // FROM `akun_belanja`
        // ORDER BY akun_1
    }
  }
	

}

/* End of file haiqal.php */
/* Location: ./application/controllers/haiqal.php */