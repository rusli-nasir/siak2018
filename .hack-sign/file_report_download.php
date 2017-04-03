<?php
session_name('ci_session');
session_start();
// start require config.php (include db)
require_once("inc/config.php");

// set $_POST = $_GET
if(isset($_POST['page'])){
	$_GET['page'] = $_POST['page'];
}

require_once("inc/config2.php");

if(isset($_GET['page'])){
	if($_GET['page']=='ipp'){
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header('Content-Disposition: attachment; filename='.date('Ymd').'_'.$_SESSION['ipp']['tgl_transaksi'].$_SESSION['ipp']['semester'].'_daftar_ipp_'.getStatusKepeg($_SESSION['ipp']['status_kepeg']).getJenisPeg($_SESSION['ipp']['jnspeg']).'_'.strtolower(str_replace(" ","_",getValue($_SESSION['ipp']['unit_id'],'kepeg_unit','id','unit_short'))).'.xls');
    echo "<html>";
    echo "<head>";
    echo "<style>@page{size:landscape;}</style>";
    echo "</head>";
    echo "<body>";
    echo "<div class=\"table-responsive no-padding\">
          <h4 style=\"text-align:center;\">Tabel Insentif Perbaikan Penghasilan ".getJenisPeg($_SESSION['ipp']['jnspeg'])." ".getStatusKepeg($_SESSION['ipp']['status_kepeg'])."<br/>";
      if(isset($_SESSION['ipp']['unit_id']) && isExist($_SESSION['ipp']['unit_id'],'kepeg_unit','id')){
        echo getValue($_SESSION['ipp']['unit_id'],'kepeg_unit','id','unit');
      }
    echo "<br/>Semester ".getSemester($_SESSION['ipp']['semester'])."<br/>Tanggal Transaksi ".balikTgl(getInputDate(str_replace("/","-",$_SESSION['ipp']['tgl_transaksi'])))."</h4>";

      $VStatusPeg = "a.`statuspeg` = ".$_SESSION['ipp']['status_kepeg'];
			if($_SESSION['ipp']['status_kepeg']==1 || $_SESSION['ipp']['status_kepeg']==3){
				$VStatusPeg = "(a.`statuspeg` = 1 OR a.`statuspeg` = 3)";
				$_jenisrek = $_CONFIG['rek_tunj_pns'];
			}else{
				if($_SESSION['ipp']['status_kepeg']==4){
					$_jenisrek = $_CONFIG['rek_nonpns'];
				}elseif($_SESSION['ipp']['status_kepeg']==2){
					$_jenisrek = $_CONFIG['rek_nonpnsblu'];
				}
			}
      $sql = "SELECT a.*, c.`nama`, c.`npwp`, d.`gol`, e.`jabatan`, f.`norekening` FROM `kepeg_tr_ipp` a LEFT JOIN `kepeg_tb_pegawai` c ON a.`nip` = c.`nip` LEFT JOIN `kepeg_tb_golongan` d ON c.`golongan_id` = d.`id` LEFT JOIN `kepeg_tb_jabatan` e ON c.`jabatan_id` = e.`id` LEFT JOIN `kepeg_tb_rekening` f ON c.`id` = f.`pegawai_id` WHERE a.`tgl_transaksi` LIKE '".$_SESSION['ipp']['tgl_transaksi']."%' AND a.`semester` = ".$_SESSION['ipp']['semester']." AND ".$VStatusPeg." AND a.`jenispeg` = ".$_SESSION['ipp']['jnspeg']." AND f.jenisrek = ".$_jenisrek;
			// echo $sql; exit;
      if(isset($_SESSION['ipp']['unit_id'])){
        $sql.=" AND a.`unitid` = ".$_SESSION['ipp']['unit_id'];
      }

      if(isset($_SESSION['ipp']['proses']['status']) && is_array($_SESSION['ipp']['proses']['status']) && count($_SESSION['ipp']['proses']['status'])>1){
        $sql.= " AND ( c.`status` = ".implode(" OR c.`status` = ", $_SESSION['ipp']['proses']['status']).")";
      }elseif(isset($_SESSION['ipp']['proses']['status']) && is_array($_SESSION['ipp']['proses']['status']) && count($_SESSION['ipp']['proses']['status'])==1){
        $sql.= " AND c.`status` = ".$_SESSION['ipp']['proses']['status'][0];
      }

      // echo $sql;
      $jum = getRow($sql);
      if($jum>0){
        $data = getdatadb($sql);
        echo showDaftarIPPCetak($data);
      }else{
        echo msgGagal("Tidak ada data yang diharapkan, sehingga harus melakukan proses data tunjangan IPP terlebih dahulu.");
      }
    echo "</div>";
    echo "</body>";
    echo "</html>";
    exit;
	}
	if($_GET['page']=='ikw' && $_GET['act']=='totalan'){
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header('Content-Disposition: attachment; filename='.date('Ymd').'_'.$_SESSION['ikw']['tahun'].$_SESSION['ikw']['bulan'].'_daftar_ikw_'.getStatusKepeg($_SESSION['ikw']['status_kepeg']).getJenisPeg($_SESSION['ikw']['jnspeg']).'_'.strtolower(str_replace(" ","_",getValue($_SESSION['ikw']['unit_id'],'kepeg_unit','id','unit_short'))).'.xls');
    echo "<html>";
    echo "<head>";
    echo "<style>@page{size:landscape;}</style>";
    echo "</head>";
    echo "<body>";
		echo "<div class=\"table-responsive no-padding\">
									<h4 class=\"text-center\">Tabel Insentif Kinerja Wajib ".getStatusKepeg($_SESSION['ikw']['status_kepeg'])."<br/>";

		if(isset($_SESSION['ikw']['unit_id']) && isExist($_SESSION['ikw']['unit_id'],'kepeg_unit','id')){
			echo getValue($_SESSION['ikw']['unit_id'],'kepeg_unit','id','unit');
		}

		echo " <br/> Bulan ".wordMonth($_SESSION['ikw']['bulan'])." Tahun ".$_SESSION['ikw']['tahun']." </h4>";
		$VStatusPeg = "a.`statuspeg` = ".$_SESSION['ikw']['status_kepeg'];
		if($_SESSION['ikw']['status_kepeg']==1 || $_SESSION['ikw']['status_kepeg']==3){
			$VStatusPeg = "(a.`statuspeg` = 1 OR a.`statuspeg` = 3)";
			$_jenisrek = $_CONFIG['rek_tunj_pns'];
		}else{
			if($_SESSION['ikw']['status_kepeg']==4){
				$_jenisrek = $_CONFIG['rek_nonpns'];
			}elseif($_SESSION['ikw']['status_kepeg']==2){
				$_jenisrek = $_CONFIG['rek_nonpnsblu'];
			}
		}
		$sql = "SELECT a.*, c.`nip`, c.`nama`, c.`npwp`, c.`status`,c.`npwp`, d.`gol`, e.`jabatan`, f.`norekening`, f.`nmbank`, c.`unit_id` FROM `kepeg_tr_ikw` a LEFT JOIN `kepeg_tb_pegawai` c ON a.`nip` = c.`nip` LEFT JOIN `kepeg_tb_golongan` d ON c.`golongan_id` = d.`id` LEFT JOIN `kepeg_tb_jabatan` e ON c.`jabatan_id` = e.`id` LEFT JOIN kepeg_tb_rekening f ON c.id = f.pegawai_id WHERE a.`bulan` LIKE '".$_SESSION['ikw']['bulan']."' AND a.`tahun` LIKE '".$_SESSION['ikw']['tahun']."' AND ".$VStatusPeg." AND a.`jenispeg` = ".$_SESSION['ikw']['jnspeg']." AND jenisrek = ".$_jenisrek;
		if(isset($_SESSION['ikw']['unit_id'])){
			$sql.=" AND a.`unitid` = ".$_SESSION['ikw']['unit_id'];
		}
		if(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])>1){
			$sql.= " AND ( c.`status` = ".implode(" OR c.`status` = ", $_SESSION['ikw']['proses']['status']).")";
		}elseif(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])==1){
			$sql.= " AND c.`status` = ".$_SESSION['ikw']['proses']['status'][0];
		}
		$sql.=$_CONFIG['ikw']['order'];
		$jum = getRow($sql);
		if($jum>0){
			$data = getdatadb($sql);
			echo showDaftarIKWCetak($data);
		}else{
			echo msgGagal("Tidak ada data yang diharapkan, sehingga harus melakukan proses data tunjangan Insentif Kinerja Wajib terlebih dahulu.");
		}
		echo "</div>";
		echo "</body>";
    echo "</html>";
		exit;
	}
	if($_GET['page']=='ikw' && $_GET['act']=='potongan'){
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header('Content-Disposition: attachment; filename='.date('Ymd').'_'.$_SESSION['ikw']['tahun'].$_SESSION['ikw']['bulan'].'_daftar_ikw_pot_'.getStatusKepeg($_SESSION['ikw']['status_kepeg']).getJenisPeg($_SESSION['ikw']['jnspeg']).'_'.strtolower(str_replace(" ","_",getValue($_SESSION['ikw']['unit_id'],'kepeg_unit','id','unit_short'))).'.xls');
    echo "<html>";
    echo "<head>";
    echo "<style>@page{size:landscape;}</style>";
    echo "</head>";
    echo "<body>";
    echo "<div class=\"table-responsive no-padding\">
    							<h4 class=\"text-center\">Tabel Potongan Insentif Kinerja Wajib ".getStatusKepeg($_SESSION['ikw']['status_kepeg'])."<br/>";

		if(isset($_SESSION['ikw']['unit_id']) && isExist($_SESSION['ikw']['unit_id'],'kepeg_unit','id')){
			echo getValue($_SESSION['ikw']['unit_id'],'kepeg_unit','id','unit');
		}

		echo	"<br/>
					Bulan ".wordMonth($_SESSION['ikw']['bulan'])." Tahun ".$_SESSION['ikw']['tahun']." </h4>";

		$VStatusPeg = "a.`statuspeg` = ".$_SESSION['ikw']['status_kepeg'];
		if($_SESSION['ikw']['status_kepeg']==1 || $_SESSION['ikw']['status_kepeg']==3){
			$VStatusPeg = "(a.`statuspeg` = 1 OR a.`statuspeg` = 3)";
			$_jenisrek = $_CONFIG['rek_tunj_pns'];
		}else{
			if($_SESSION['ikw']['status_kepeg']==4){
				$_jenisrek = $_CONFIG['rek_nonpns'];
			}elseif($_SESSION['ikw']['status_kepeg']==2){
				$_jenisrek = $_CONFIG['rek_nonpnsblu'];
			}
		}
		$sql = "SELECT a.ikw, a.nip, a.pajak, c.status, c.npwp,  c.nama, d.gol, e.jabatan, b.*, f.norekening, f.nmbank FROM kepeg_tr_ikw a RIGHT JOIN kepeg_tr_pot_ikw b ON a.id_trans = b.id_trans_ikw LEFT JOIN kepeg_tb_pegawai c ON a.nip = c.nip LEFT JOIN kepeg_tb_golongan d ON c.golongan_id = d.id LEFT JOIN kepeg_tb_jabatan e ON c.jabatan_id = e.id LEFT JOIN kepeg_tb_rekening f ON c.id = f.pegawai_id WHERE a.bulan LIKE '".$_SESSION['ikw']['bulan']."' AND a.tahun LIKE '".$_SESSION['ikw']['tahun']."' AND ".$VStatusPeg." AND a.jenispeg = ".$_SESSION['ikw']['jnspeg']." AND jenisrek = ".$_jenisrek;
		if(isset($_SESSION['ikw']['unit_id'])){
			$sql.=" AND a.unitid = ".$_SESSION['ikw']['unit_id'];
		}
		if(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])>1){
			$sql.= " AND ( c.status = ".implode(" OR c.status = ", $_SESSION['ikw']['proses']['status']).")";
		}elseif(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])==1){
			$sql.= " AND c.status = ".$_SESSION['ikw']['proses']['status'][0];
		}
		$sql.=$_CONFIG['ikw']['order'];
		$jum = getRow($sql);
		if($jum>0){
			$data = getdatadb($sql);
			echo showDaftarPotonganIKWCetak($data);
		}else{
			echo msgGagal("Tidak ada data yang diharapkan, sehingga harus melakukan proses data tunjangan Insentif Kinerja Wajib terlebih dahulu.");
		}
		echo "</div>";
    echo "</body>";
    echo "</html>";
    exit;
  }
}
?>
