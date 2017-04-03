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

  if(isset($_POST['act']) && strlen(trim($_POST['act']))>0){
  	$_m = "";
  	switch ($_POST['act']) {
      //--- GAJI ---//
      case 'gaji_proses':
        if(!is_numeric($_POST['tahun']) && strlen(trim($_POST['tahun']))!=4){
          $_m = "Harap memasukkan tahun penggajian!</div>";
          echo msgGagal($_m);
          exit;
        }
        // set variable untuk mengambil gaji.
        if(isset($_POST['tahun']) && strlen(trim($_POST['tahun']))==4){
          $_SESSION['gaji']['tahun'] = $_POST['tahun'];
        }else{
          unset($_SESSION['gaji']['tahun']);
        }
        $_SESSION['gaji']['bulan'] = $_POST['bulan'];
        if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
          $_SESSION['gaji']['unit_id'] = $_POST['unit_id'];
        }else{
          if(isset($_SESSION['gaji']['unit_id'])){
            unset($_SESSION['gaji']['unit_id']);
          }
        }
        $_SESSION['gaji']['status_kepeg'] = $_POST['status_kepeg'];
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['gaji']['proses']['status'] = $_POST['status'];
          unset($_POST['status']);
        }else{
          if(isset($_SESSION['gaji']['proses']['status'])){
            unset($_SESSION['gaji']['proses']['status']);
          }
        }
        // untuk perintah eksekusi (bila tidak 1-1)
        echo showDialogProsesGaji($_POST);
        // echo 1;
        exit;
      break;
      case 'gaji_proses2':
        $data = explode(",",$_POST['data']);
        // $status = explode(";",$data['3']);
        $vSQL = "";
        if(isset($_SESSION['gaji']['proses']['status']) && is_array($_SESSION['gaji']['proses']['status']) && count($_SESSION['gaji']['proses']['status'])>1){
          $vSQL = " AND ( status = ".implode(" OR status = ", $_SESSION['gaji']['proses']['status']).")";
        }elseif(isset($_SESSION['gaji']['proses']['status']) && is_array($_SESSION['gaji']['proses']['status']) && count($_SESSION['gaji']['proses']['status'])==1){
          $vSQL = " AND status = ".$_SESSION['gaji']['proses']['status'][0];
        }
        $sql = "SELECT nip, unit_id, status_kepeg, mkth, golongan_id, ijazah_id FROM kepeg_tb_pegawai WHERE status_kepeg = ".intval($data[2]).$vSQL;
        if(is_numeric($data[1]) && isExist($data[1],'kepeg_unit','id')){
          $sql.=" AND unit_id = ".intval($data[1]);
        }
        // echo $sql; exit;
        $row=getRow($sql);
        if($row > 0){
          $last_id = 0;
          $r = getdatadb($sql);
          foreach ($r as $k => $v) {
            $sql_e = "SELECT id FROM kepeg_tr_dgaji WHERE nip LIKE '".$v['nip']."' AND bulan LIKE '".$data[3]."' AND tahun LIKE '".$data[4]."'";
            $row = getRow($sql_e);
            if($row==0){
              if($data[2]==2){ // jika merupakan BLU
                $gaji = gajiBLU($v['mkth'], $v['golongan_id']);
              }else{
                $gaji = gajiKontrak($v['ijazah_id']);
              }
              $sql_e = "INSERT INTO kepeg_tr_dgaji(bulan,tahun,nip,unitid,statuspeg,nominalg) VALUES('".$data[3]."', '".$data[4]."', '".$v['nip']."', '".$v['unit_id']."', '".$v['status_kepeg']."', '".$gaji."')";
              execute($sql_e);
            }
          }
          echo 1;
        }
        exit;
      break;
      case 'gaji_lihat':
        if(!is_numeric($_POST['tahun']) && strlen(trim($_POST['tahun']))!=4){
          $_m = "Harap memasukkan tahun penggajian!</div>";
          echo msgGagal($_m);
          exit;
        }

        // set variable untuk mengambil gaji.
        if(isset($_POST['tahun']) && strlen(trim($_POST['tahun']))==4){
          $_SESSION['gaji']['tahun'] = $_POST['tahun'];
        }else{
          unset($_SESSION['gaji']['tahun']);
        }
        $_SESSION['gaji']['bulan'] = $_POST['bulan'];
        if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
          $_SESSION['gaji']['unit_id'] = $_POST['unit_id'];
        }else{
          if(isset($_SESSION['gaji']['unit_id'])){
            unset($_SESSION['gaji']['unit_id']);
          }
        }
        $_SESSION['gaji']['status_kepeg'] = $_POST['status_kepeg'];
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['gaji']['proses']['status'] = $_POST['status'];
          unset($_POST['status']);
        }else{
          if(isset($_SESSION['gaji']['proses']['status'])){
            unset($_SESSION['gaji']['proses']['status']);
          }
        }

        echo 1;
        exit;
      break;
      case 'gaji_reset':
        // set variable untuk menghapus sesi gaji.
        unset($_SESSION['gaji']);
        echo 1;
        exit;
      break;
      case 'gaji_hapus_berjamaah':
        if(isset($_POST['id']) && count($_POST['id'])>0){
          $sql = "DELETE FROM kepeg_tr_dgaji WHERE id = 0";
          foreach ($_POST['id'] as $key => $value) {
            // hapus berjamaah
            $sql.=" OR id =".$value;
          }
          execute($sql);
          echo 1; exit;
        }
        echo "Tidak ada yang dapat dihapus.";
        exit;
      break;
      case 'gaji_hapus_single':
        if(isset($_POST['id']) && isExist(intval($_POST['id'],'kepeg_tr_dgaji','id'))){
          $sql = "DELETE FROM kepeg_tr_dgaji WHERE id = ".$_POST['id'];
          execute($sql);
          echo 1; exit;
        }
        echo "Tidak ada yang dapat dihapus.";
        exit;
      break;
      //--- END GAJI ---//

      //--- TUNJANGAN ---//
      case 'tunjangan_proses':
  			if(!is_numeric($_POST['tahun']) && strlen(trim($_POST['tahun']))!=4){
  				$_m = "Harap memasukkan tahun tunjangan!</div>";
  				echo msgGagal($_m);
  				exit;
  			}
  			// set variable untuk mengambil tunjangan.
        if(isset($_POST['tahun']) && strlen(trim($_POST['tahun']))==4){
          $_SESSION['tunjangan']['tahun'] = $_POST['tahun'];
        }else{
          unset($_SESSION['tunjangan']['tahun']);
        }
  			$_SESSION['tunjangan']['bulan'] = $_POST['bulan'];
  			if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
  				$_SESSION['tunjangan']['unit_id'] = $_POST['unit_id'];
  			}else{
          if(isset($_SESSION['tunjangan']['unit_id'])){
            unset($_SESSION['tunjangan']['unit_id']);
          }
        }
  			$_SESSION['tunjangan']['status_kepeg'] = $_POST['status_kepeg'];
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['tunjangan']['proses']['status'] = $_POST['status'];
          unset($_POST['status']);
        }else{
          if(isset($_SESSION['tunjangan']['proses']['status'])){
            unset($_SESSION['tunjangan']['proses']['status']);
          }
        }
        // untuk perintah eksekusi (bila tidak 1-1)
        if(isset($_POST['status_kepeg']) && (intval($_POST['status_kepeg'])==2 || intval($_POST['status_kepeg'])==4)){
          echo showDialogProsesTunjanganNonPNS($_POST);
        }
  			exit;
  		break;
      case 'tunjangan_proses2':
        $html = "";
  			$data = explode(",",$_POST['data']);
        $vSQL = "";
        if(isset($_SESSION['tunjangan']['proses']['status']) && is_array($_SESSION['tunjangan']['proses']['status']) && count($_SESSION['tunjangan']['proses']['status'])>1){
          $vSQL = " AND ( status = ".implode(" OR status = ", $_SESSION['tunjangan']['proses']['status']).")";
        }elseif(isset($_SESSION['tunjangan']['proses']['status']) && is_array($_SESSION['tunjangan']['proses']['status']) && count($_SESSION['tunjangan']['proses']['status'])==1){
          $vSQL = " AND status = ".$_SESSION['tunjangan']['proses']['status'][0];
        }
        $sql = "SELECT nip, unit_id, status_kepeg FROM kepeg_tb_pegawai WHERE status_kepeg = ".intval($data[2]).$vSQL;
        if(is_numeric($data[1]) && isExist($data[1],'kepeg_unit','id')){
          $sql.=" AND unit_id = ".intval($data[1]);
        }
        if($data[2]==2){
  				$row=getRow($sql);
  				if($row > 0){
  					$last_id = 0;
  					$r = getdatadb($sql);
            $nominalb = 0;
  					foreach ($r as $k => $v) {
  						$sql_e = "SELECT id FROM kepeg_tr_dtunjangan WHERE nip LIKE '".$v['nip']."' AND bulan LIKE '".$data[3]."' AND tahun LIKE '".$data[4]."'";
  						$row = getRow($sql_e);
  						if($row==0){
                $sql_c = "SELECT nominalg AS gaji FROM kepeg_tr_dgaji WHERE nip LIKE '".$v['nip']."' AND bulan LIKE '".$data[3]."' AND tahun LIKE '".$data[4]."'";
                $rw = getRow($sql_c);
                if($rw>0){
                  $g = getdata($sql_c);
                  $nominalb = tunjanganBLUBeras($g['gaji']);
                }
  							$sql_i = "INSERT INTO kepeg_tr_dtunjangan(bulan, tahun, nip, unitid, statuspeg, pasangan, nominalp, anak, nominala, nominalb, nominalt)
                          VALUES('".$data[3]."', '".$data[4]."', '".$v['nip']."', '".$v['unit_id']."', '".$v['status_kepeg']."', 0, 0, 0, 0, ".$nominalb.", ".$nominalb.")";
                //$html.=$sql."<br/>";
                execute($sql_i);
  						}
  					}
            //echo msgGagal($html);
            echo 1;
          }
				}elseif($data[2]==4){
          $row=getRow($sql);
          if($row > 0){
            echo 1;
          }
        }
  			exit;
  		break;
      case 'tunjangan_lihat':
        if(!is_numeric($_POST['tahun']) && strlen(trim($_POST['tahun']))!=4){
          $_m = "Harap memasukkan tahun tunjangan!</div>";
          echo msgGagal($_m);
          exit;
        }
        // set variable untuk mengambil tunjangan.
        if(isset($_POST['tahun']) && strlen(trim($_POST['tahun']))==4){
          $_SESSION['tunjangan']['tahun'] = $_POST['tahun'];
        }else{
          unset($_SESSION['tunjangan']['tahun']);
        }
  			$_SESSION['tunjangan']['bulan'] = $_POST['bulan'];
  			if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
  				$_SESSION['tunjangan']['unit_id'] = $_POST['unit_id'];
  			}else{
          if(isset($_SESSION['tunjangan']['unit_id'])){
            unset($_SESSION['tunjangan']['unit_id']);
          }
        }
  			$_SESSION['tunjangan']['status_kepeg'] = $_POST['status_kepeg'];
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['tunjangan']['proses']['status'] = $_POST['status'];
          unset($_POST['status']);
        }else{
          if(isset($_SESSION['tunjangan']['proses']['status'])){
            unset($_SESSION['tunjangan']['proses']['status']);
          }
        }

        echo 1;
        exit;
      break;
      case 'tunjangan_reset':
        // set variable untuk menghapus sesi tunjangan.
        unset($_SESSION['tunjangan']);
        echo 1;
        exit;
      break;
      case 'tunjangan_hapus_berjamaah':
        if(isset($_POST['id']) && count($_POST['id'])>0){
          $sql = "DELETE FROM kepeg_tr_dtunjangan WHERE id = 0";
          foreach ($_POST['id'] as $key => $value) {
            // hapus berjamaah
            $sql.=" OR id =".$value;
          }
          execute($sql);
          echo 1; exit;
        }
        echo "Tidak ada yang dapat dihapus.";
        exit;
      break;
      case 'tunjangan_hapus_single':
        // print_r($_POST); exit;
        if(isset($_POST['id']) && isExist(intval($_POST['id']),'kepeg_tr_dtunjangan','id')){
          $sql = "DELETE FROM kepeg_tr_dtunjangan WHERE id = ".$_POST['id'];
          execute($sql);
          echo 1; exit;
        }
        echo "Tidak ada yang dapat dihapus.";exit;
      break;
      case 'tunjangan_simpan_data':
        // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
        if(isset($_POST['_id']) && count($_POST['_id'])>0){
            $html = "";
            $sql = "";
            foreach ($_POST['_id'] as $k => $v) {
              $sql = "SELECT id, nip, bulan, tahun FROM kepeg_tr_dtunjangan WHERE id = ".$v;
              $row = getRow($sql);
              if($row>0){
                $d = getdata($sql);
                $sql_c = "SELECT nominalg AS gaji FROM kepeg_tr_dgaji WHERE nip LIKE '".$d['nip']."' AND bulan LIKE '".$d['bulan']."' AND tahun LIKE '".$d['tahun']."'";
                $rw = getRow($sql_c);
                if($rw>0){
                  $g = getdata($sql_c);
                  $anak = intval($_POST['anak'][$k]);
                  $pasangan = intval($_POST['pasangan'][$k]);
                  $jumlah = $anak+$pasangan+1;
                  $nominala = tunjanganBLUAnak(intval($_POST['anak'][$k]), $g['gaji']);
                  $nominalp = $pasangan*tunjanganBLUIstri($g['gaji']);
                  $nominalb = $jumlah*tunjanganBLUBeras($g['gaji']);
                  $nominalt = $nominalp + $nominala + $nominalb;
                  $sql_e = "UPDATE kepeg_tr_dtunjangan SET pasangan = ".$pasangan.", anak = ".$anak.", nominalp = ".$nominalp.", nominala = ".$nominala.", nominalb = ".$nominalb.", nominalt = ".$nominalt." WHERE id = ".$v;
                  execute($sql_e);
                  // $html.= $g['gaji'].": ".$sql_e."<br />";
                }
              }
            }
          // echo msgSukses($html); exit;
          echo 1; exit;
        }
        echo msgGagal('Tidak ada data yang dapat disimpan.'); exit;
      break;
      //--- END TUNJANGAN ---//

      //--- UANG MAKAN ---//
      case 'um_proses':
        if(!is_numeric($_POST['tahun']) && strlen(trim($_POST['tahun']))!=4){
          $_m = "Harap memasukkan tahun uang makan!</div>";
          echo msgGagal($_m);
          exit;
        }
        // set variable untuk mengambil uang makan.
        if(isset($_POST['tahun']) && strlen(trim($_POST['tahun']))==4){
          $_SESSION['um']['tahun'] = $_POST['tahun'];
        }else{
          unset($_SESSION['um']['tahun']);
        }
        $_SESSION['um']['bulan'] = $_POST['bulan'];
        if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
          $_SESSION['um']['unit_id'] = $_POST['unit_id'];
        }else{
          if(isset($_SESSION['um']['unit_id'])){
            unset($_SESSION['um']['unit_id']);
          }
        }
        $_SESSION['um']['status_kepeg'] = $_POST['status_kepeg'];
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['um']['proses']['status'] = $_POST['status'];
          unset($_POST['status']);
        }else{
          if(isset($_SESSION['um']['proses']['status'])){
            unset($_SESSION['um']['proses']['status']);
          }
        }
        // untuk perintah eksekusi (bila tidak 1-1)
        echo showDialogProsesUangMakan($_POST);
        exit;
      break;
      case 'um_proses2':
        $data = explode(",",$_POST['data']);
        $vSQL = "";
        if(isset($_SESSION['um']['proses']['status']) && is_array($_SESSION['um']['proses']['status']) && count($_SESSION['um']['proses']['status'])>1){
          $vSQL = " AND ( status = ".implode(" OR status = ", $_SESSION['um']['proses']['status']).")";
        }elseif(isset($_SESSION['um']['proses']['status']) && is_array($_SESSION['um']['proses']['status']) && count($_SESSION['um']['proses']['status'])==1){
          $vSQL = " AND status = ".$_SESSION['um']['proses']['status'][0];
        }
        $sql = "SELECT nip, unit_id, status_kepeg,ijazah_id FROM kepeg_tb_pegawai WHERE status_kepeg = ".intval($data[2]).$vSQL;
        if(is_numeric($data[1]) && isExist($data[1],'kepeg_unit','id')){
          $sql.=" AND unit_id = ".intval($data[1]);
        }

        $row=getRow($sql);
        if($row > 0){
          $last_id = 0;
          $r = getdatadb($sql);
          foreach ($r as $k => $v) {
            if($data[2]==2){
              $uangMakan = uangMakanBLU(1,getPend($v['ijazah_id']));
            }elseif($data[2]==4){
              $uangMakan = uangMakanKontrak(1,getPend($v['ijazah_id']));
            }
            $sql_e = "SELECT id FROM kepeg_tr_dmakan WHERE nip LIKE '".$v['nip']."' AND bulan LIKE '".$data[3]."' AND tahun LIKE '".$data[4]."'";
            $row = getRow($sql_e);
            if($row==0){
              $sql_i = "insert into kepeg_tr_dmakan(bulan,tahun,nip,unitid,statuspeg,jumlahh,perharih,nominalh,jumlahth,perharith,nominalth,totalh)
                values('".$data[3]."', '".$data[4]."', '".$v['nip']."', '".$v['unit_id']."', '".$v['status_kepeg']."', 0, '".$uangMakan."', 0, 0, '".$uangMakan."', 0, 0)";
              execute($sql_i);
            }
          }
          echo 1;
        }

        exit;
      break;
      case 'um_lihat':
        if(!is_numeric($_POST['tahun']) && strlen(trim($_POST['tahun']))!=4){
          $_m = "Harap memasukkan tahun uang makan!</div>";
          echo msgGagal($_m);
          exit;
        }
        // set variable untuk mengambil uang makan.
        if(isset($_POST['tahun']) && strlen(trim($_POST['tahun']))==4){
          $_SESSION['um']['tahun'] = $_POST['tahun'];
        }else{
          unset($_SESSION['um']['tahun']);
        }
        $_SESSION['um']['bulan'] = $_POST['bulan'];
        if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
          $_SESSION['um']['unit_id'] = $_POST['unit_id'];
        }else{
          if(isset($_SESSION['um']['unit_id'])){
            unset($_SESSION['um']['unit_id']);
          }
        }
        $_SESSION['um']['status_kepeg'] = $_POST['status_kepeg'];
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['um']['proses']['status'] = $_POST['status'];
          unset($_POST['status']);
        }else{
          if(isset($_SESSION['um']['proses']['status'])){
            unset($_SESSION['um']['proses']['status']);
          }
        }

        echo 1;
        exit;
      break;
      case 'um_reset':
        // set variable untuk menghapus sesi uang makan.
        unset($_SESSION['um']);
        echo 1;
        exit;
      break;
      case 'um_simpan_data':
        // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
        if(isset($_POST['_id']) && count($_POST['_id'])>0){
            $html = "";
            $sql = "";
            foreach ($_POST['_id'] as $k => $v) {
              $sql = "SELECT perharih FROM kepeg_tr_dmakan WHERE id = ".$v;
              // $html.=$sql."<br />";
              $row = getRow($sql);
              if($row>0){
                $g = getdata($sql);
                $nominalh = $g['perharih']*$_POST['jumlahh'];
                $jumlahh = $_POST['jumlahh'];
                $jumlahth = $_POST['jumlahth'][$k];
                $nominalth = $g['perharih']*$_POST['jumlahth'][$k];
                $totalh = $nominalh - $nominalth;
                $sql_e = "UPDATE kepeg_tr_dmakan SET
                  jumlahh = '".$jumlahh."',
                  jumlahth = '".$jumlahth."',
                  nominalh = '".$nominalh."',
                  nominalth = '".$nominalth."',
                  totalh = '".$totalh."'
                  WHERE id = ".$v;
                // $html.=$sql_e."<br />";
                execute($sql_e);
              }
            }
          // echo msgSukses($html); exit;
          echo 1; exit;
        }
        echo msgGagal('Tidak ada data yang dapat disimpan.'); exit;
      break;
      case 'um_hapus_berjamaah':
        if(isset($_POST['id']) && count($_POST['id'])>0){
          $sql = "DELETE FROM kepeg_tr_dmakan WHERE id = 0";
          foreach ($_POST['id'] as $key => $value) {
            // hapus berjamaah
            $sql.=" OR id =".$value;
          }
          execute($sql);
          echo 1; exit;
        }
        echo "Tidak ada yang dapat dihapus.";
        exit;
      break;
      case 'um_hapus_single':
        if(isset($_POST['id']) && isExist(intval($_POST['id'],'kepeg_tr_dmakan','id'))){
          $sql = "DELETE FROM kepeg_tr_dtmakan WHERE id = ".$_POST['id'];
          execute($sql);
          echo 1; exit;
        }
        echo "Tidak ada yang dapat dihapus.";
        exit;
      break;

      //--- TUNJANGAN TKK ---//
      case 'tunjangantkk_proses':
        if(!is_numeric($_POST['tahun']) && strlen(trim($_POST['tahun']))!=4){
          $_m = "Harap memasukkan tahun tunjangan kinerja tenaga kontrak!</div>";
          echo msgGagal($_m);
          exit;
        }
        // set variable untuk mengambil uang makan.
        if(isset($_POST['tahun']) && strlen(trim($_POST['tahun']))==4){
          $_SESSION['um']['tahun'] = $_POST['tahun'];
        }else{
          unset($_SESSION['um']['tahun']);
        }
        $_SESSION['um']['bulan'] = $_POST['bulan'];
        if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
          $_SESSION['um']['unit_id'] = $_POST['unit_id'];
        }else{
          if(isset($_SESSION['um']['unit_id'])){
            unset($_SESSION['um']['unit_id']);
          }
        }
        $_SESSION['um']['status_kepeg'] = $_POST['status_kepeg'];
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['um']['proses']['status'] = $_POST['status'];
          unset($_POST['status']);
        }else{
          if(isset($_SESSION['um']['proses']['status'])){
            unset($_SESSION['um']['proses']['status']);
          }
        }
        // untuk perintah eksekusi (bila tidak 1-1)
        echo showDialogProsesTunjanganTenagaKontrak($_POST);
        exit;
      break;


      //--- TUNJANGAN IKW ---//
      case 'ikw_proses':
        if(!is_numeric($_POST['tahun']) && strlen(trim($_POST['tahun']))!=4){
          $_m = "Harap memasukkan tahun Insentif Kinerja Wajib!</div>";
          echo msgGagal($_m);
          exit;
        }
        // print_r($_POST['status']); exit;
        // set variable untuk mengambil uang makan.
        if(isset($_POST['tahun']) && strlen(trim($_POST['tahun']))==4){
          $_SESSION['ikw']['tahun'] = $_POST['tahun'];
        }else{
          unset($_SESSION['ikw']['tahun']);
        }
        $_SESSION['ikw']['bulan'] = $_POST['bulan'];
        if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
          $_SESSION['ikw']['unit_id'] = $_POST['unit_id'];
        }else{
          if(isset($_SESSION['ikw']['unit_id'])){
            unset($_SESSION['ikw']['unit_id']);
          }
        }
        $_SESSION['ikw']['status_kepeg'] = $_POST['status_kepeg'];
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['ikw']['proses']['status'] = $_POST['status'];
          unset($_POST['status']);
        }else{
          if(isset($_SESSION['ikw']['proses']['status'])){
            unset($_SESSION['ikw']['proses']['status']);
          }
        }
        $_SESSION['ikw']['jnspeg'] = $_POST['jnspeg'];
        // untuk perintah eksekusi (bila tidak 1-1)
        echo showDialogProsesTunjanganIKW($_POST);
				// print_r($_POST);
        exit;
      break;
      case 'ikw_proses2':
        $data = explode(",",$_POST['data']);
        // print_r($data); exit;
        $vSQL = "";
        if(isset($_SESSION['ikw']['status_kepeg']) && intval($_SESSION['ikw']['status_kepeg'])==4){
          echo msgGagal("Mohon maaf, untuk tenaga Kontrak tidak mendapatkan tunjangan IKW karena belum adanya SK Rektor untuk itu.<br/>Terimakasih.");
        }
        if(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])>1){
          $vSQL = " AND ( status = ".implode(" OR status = ", $_SESSION['ikw']['proses']['status']).")";
        }elseif(isset($_SESSION['ikw']['proses']['status']) && is_array($_SESSION['ikw']['proses']['status']) && count($_SESSION['ikw']['proses']['status'])==1){
          $vSQL = " AND status = ".$_SESSION['ikw']['proses']['status'][0];
        }
        $_status_kepeg = "a.`status_kepeg` = ".intval($data[2]);
        if($data[2]==1 || $data[2]==3){
          $_status_kepeg = "(a.`status_kepeg` = 1 OR a.`status_kepeg` = 3)";
        }
        $sql = "SELECT a.`nip`, a.`unit_id`, a.`status_kepeg`, a.`status`, a.`jabatan_id`, a.`jnspeg`, b.`kelompok`, c.`bobot`, a.`npwp` FROM `kepeg_tb_pegawai` a LEFT JOIN `kepeg_tb_golongan` b ON a.`golongan_id` = b.`id` LEFT JOIN `kepeg_tb_jabatan` c ON a.`jabatan_id` = c.`id` WHERE ".$_status_kepeg." AND a.`jnspeg` = ".intval($data[3]).$vSQL;
        if(is_numeric($data[1]) && isExist($data[1],'kepeg_unit','id')){
          if($data[1]!=27){
            $sql.=" AND a.`unit_id` = ".intval($data[1]);
          }else{
            $sql.=" AND a.`unit_id` = 0";
          }
        }else{
          $sql.=" AND a.`unit_id` != 27";
        }
        //echo $sql; exit;
        $row=getRow($sql);
        if($row > 0){
          $last_id = 0;
          $r = getdatadb($sql);
          foreach ($r as $k => $v) {
            if($data[2]==4){
              exit;
            }else{
              $pajak = 0;
              if($data[2]==2){
                $ikw = getIKWBruto($v['kelompok'],$v['bobot']);
                if($v['bobot'] <= 11 ){
                  if(strlen(trim($v['npwp']))<10){
                    $pajak = 0.06;
                  }else{
                    $pajak = 0.05;
                  }
                }elseif($v['bobot'] >=12 ){
                  $pajak = 0.15;
                }
              }else{
                $ikw = getIKWBruto($v['kelompok'],$v['bobot']);
                if(($v['kelompok'] == 2 || $v['kelompok'] == 3) && $v['status_kepeg']==2 ){
                  $pajak = 0.05;
                }elseif($v['kelompok'] == 3 && $v['status_kepeg']!=2 ){
                  $pajak = 0.05;
                }elseif($v['kelompok'] >=4 ){
                  $pajak = 0.15;
                }
              }
            }
            if($v['status']=='12'){
              $ikw = ceil($ikw*0.75);
            }
            $sql_e = "SELECT id_trans FROM kepeg_tr_ikw WHERE nip LIKE '".$v['nip']."' AND bulan LIKE '".$data[4]."' AND tahun LIKE '".$data[5]."'";
            $row = getRow($sql_e);
            if($row==0){
              // selama masih belum ada skp
              $bruto = $ikw;
              $pot_ikw = 0;
              $jml_pajak = ceil($pajak*$bruto);
              // khusus BLU Golongan 2
              if($v['kelompok'] == 2 && $v['status_kepeg']==2 ){
                $ikw+=$jml_pajak;
                $bruto = $ikw;
              }
              $byr_stlh_pajak = $bruto - $jml_pajak;
              $netto = $byr_stlh_pajak;
              // end here
              $sql_i = "insert into kepeg_tr_ikw( bulan, tahun, nip, unitid, statuspeg, jenispeg, ikw, pajak, bruto, pot_ikw, jml_pajak, byr_stlh_pajak, netto )
                values('".$data[4]."', '".$data[5]."', '".$v['nip']."', '".$v['unit_id']."', '".$v['status_kepeg']."', '".$v['jnspeg']."', ".$ikw.", ".$pajak.", ".$bruto.", ".$pot_ikw.", ".$jml_pajak.", ".$byr_stlh_pajak.", ".$netto." )";
              $last_id = execute($sql_i);
              $sql_i = "insert into kepeg_tr_pot_ikw( id_trans_ikw ) VALUES ( ".$last_id." )";
              execute($sql_i);
            }
          }
          echo 1;
        }
        exit;
      break;
      case 'ikw_lihat':
        if(!is_numeric($_POST['tahun']) && strlen(trim($_POST['tahun']))!=4){
          $_m = "Harap memasukkan tahun tunjangan IKW!</div>";
          echo msgGagal($_m);
          exit;
        }
        // set variable untuk mengambil uang makan.
        if(isset($_POST['tahun']) && strlen(trim($_POST['tahun']))==4){
          $_SESSION['ikw']['tahun'] = $_POST['tahun'];
        }else{
          unset($_SESSION['ikw']['tahun']);
        }
        $_SESSION['ikw']['bulan'] = $_POST['bulan'];
        if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
          $_SESSION['ikw']['unit_id'] = $_POST['unit_id'];
        }else{
          if(isset($_SESSION['ikw']['unit_id'])){
            unset($_SESSION['ikw']['unit_id']);
          }
        }
        $_SESSION['ikw']['status_kepeg'] = $_POST['status_kepeg'];
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['ikw']['proses']['status'] = $_POST['status'];
          unset($_POST['status']);
        }else{
          if(isset($_SESSION['ikw']['proses']['status'])){
            unset($_SESSION['ikw']['proses']['status']);
          }
        }
        $_SESSION['ikw']['jnspeg'] = $_POST['jnspeg'];

        echo 1;
        exit;
      break;
      case 'ikw_reset':
        // set variable untuk menghapus sesi tunjangan IKW.
        unset($_SESSION['ikw']);
        echo 1;
        exit;
      break;
      case 'ikw_pot_hapus_berjamaah':
        // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
        $sql = "SELECT `id_trans_ikw` FROM `kepeg_tr_pot_ikw` WHERE `id_trans` = 0";
        $sql_d = "DELETE FROM `kepeg_tr_pot_ikw` WHERE `id_trans` = 0";
        foreach ($_POST['id'] as $k => $v) {
          $sql.=" OR id_trans = ".$v;
          $sql_d.=" OR id_trans = ".$v;
        }
        $rsl = getRow($sql);
        if($rsl>0){
          $rsl = getdatadb($sql);
          $sql_d2 = "DELETE FROM `kepeg_tr_ikw` WHERE `id_trans` = 0";
          foreach ($rsl as $k => $v) {
            $sql_d2.=" OR id_trans = ".$v['id_trans_ikw'];
          }
          // echo $sql_d."<br/>";
          // echo $sql_d2;
          execute($sql_d);
          execute($sql_d2);
        }
        echo 1;
        exit;
      break;
      case 'ikw_pot_hapus_single':
        // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
        $sql = "SELECT id_trans_ikw FROM `kepeg_tr_pot_ikw` WHERE id_trans = ".intval($_POST['id']);
        $sql_d = "DELETE FROM `kepeg_tr_pot_ikw` WHERE id_trans = ".intval($_POST['id']);
        execute($sql_d);
        $rsl = getRow($sql);
        if($rsl>0){
          $rsl = getdata($sql);
          $sql_d2 = "DELETE FROM kepeg_tr_ikw WHERE id_trans = ".$rsl['id_trans_ikw'];
          execute($sql_d2);
        }
        echo 1;
        exit;
      break;
      case 'ikw_pot_simpan_data':
        // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
        if(isset($_POST['_id']) && count($_POST['_id'])>0){
            $html = "";
            $sql = "";
            foreach ($_POST['_id'] as $k => $v) {
              $kinerja_tdk_tercapai = $_POST['kinerja_wajib'][$k] - $_POST['capaian_smt_sblm'][$k];
              if($kinerja_tdk_tercapai<=0){
                $kinerja_tdk_tercapai = 0;
                $jml_pot = 0;
              }else{
                $jml_pot = ceil(($kinerja_tdk_tercapai/$_POST['kinerja_wajib'][$k]) * $_POST['ikw'][$k]);
              }
              $sql_e = "UPDATE `kepeg_tr_pot_ikw` SET
                        `capaian_smt_sblm` = ".intval($_POST['capaian_smt_sblm'][$k]).",
                        `kinerja_wajib` = ".intval($_POST['kinerja_wajib'][$k]).",
                        `kinerja_tdk_tercapai` = ".intval($kinerja_tdk_tercapai).",
                        `jml_pot` = ".intval($jml_pot)."
                        WHERE `id_trans` = ".intval($v);
              // $html.=$sql_e."<br />";
              execute($sql_e);
              $bruto = $_POST['ikw'][$k] - $jml_pot;
              $jml_pajak = ceil($_POST['pajak'][$k]*$bruto);
              $byr_stlh_pajak = $bruto - $jml_pajak;
              $netto = $byr_stlh_pajak;
              $sql_e2 = "UPDATE `kepeg_tr_ikw` SET
                        `pot_ikw` = ".$jml_pot.",
                        `bruto` = ".$bruto.",
                        `jml_pajak` = ".$jml_pajak.",
                        `byr_stlh_pajak` = ".$byr_stlh_pajak.",
                        `netto` = ".$netto."
                        WHERE `id_trans` = ".intval($_POST['id_trans_ikw'][$k]);
              // $html.=$sql_e2."<br />";
              execute($sql_e2);
            }
          // echo msgSukses($html); exit;
          echo 1; exit;
        }
        echo msgGagal('Tidak ada data yang dapat disimpan.'); exit;
      break;
      case "ikw-swicth-tab" :
        if(isset($_POST['id']) && $_POST['id']=='#tab_2'){
          $_SESSION['ikw']['form']['tab'] = "2";
        }else{
          if(isset($_SESSION['ikw']['form']['tab'])){
            unset($_SESSION['ikw']['form']['tab']);
          }
        }
        exit;
      break;
      case 'ikw_hapus_berjamaah':
        // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
        $sql_d = "DELETE FROM `kepeg_tr_pot_ikw` WHERE `id_trans_ikw` = 0";
        $sql_d2 = "DELETE FROM `kepeg_tr_ikw` WHERE `id_trans` = 0";
        foreach ($_POST['id2'] as $k => $v) {
          $sql_d.=" OR id_trans = ".$v;
          $sql_d2.=" OR id_trans = ".$v;
        }
        // echo $sql_d."<br/>";
        execute($sql_d); execute($sql_d2);
        echo 1;
        exit;
      break;
      case 'ikw_hapus_single':
        // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
        $sql_d = "DELETE FROM `kepeg_tr_pot_ikw` WHERE `id_trans_ikw` = ".intval($_POST['id']);
        execute($sql_d);
        $sql_d2 = "DELETE FROM `kepeg_tr_ikw` WHERE `id_trans` = ".intval($_POST['id']);
        execute($sql_d2);
        echo 1;
        exit;
      break;
      case 'ikw_simpan_data':
        // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
        if(isset($_POST['_id2']) && count($_POST['_id2'])>0){
            $html = "";
            $sql = "";
            foreach ($_POST['_id2'] as $k => $v) {
              $netto = $_POST['byr_stlh_pajak'][$k] - $_POST['pot_lainnya'][$k];
              $sql_e = "UPDATE kepeg_tr_ikw SET
                        pot_lainnya = ".intval($_POST['pot_lainnya'][$k]).",
                        netto = ".$netto."
                        WHERE id_trans = ".intval($v);
              execute($sql_e);
            }
          // echo msgSukses($html); exit;
          echo 1; exit;
        }
        echo msgGagal('Tidak ada data yang dapat disimpan.'); exit;
      break;


      // --- TUNJANGAN IPP --- //
      case 'ipp_proses':
        if(!isset($_POST['tgl_transaksi']) && strlen(trim($_POST['tgl_transaksi']))!=4){
          echo msgGagal("Masukkan tahun transaksi untuk melakukan proses !");
          exit;
        }else{
          $_SESSION['ipp']['tgl_transaksi'] = $_POST['tgl_transaksi'];
        }

        $_SESSION['ipp']['semester'] = $_POST['semester'];

        if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
          $_SESSION['ipp']['unit_id'] = $_POST['unit_id'];
        }else{
          if(isset($_SESSION['ipp']['unit_id'])){
            unset($_SESSION['ipp']['unit_id']);
          }
        }
        if(isset($_POST['status_kepeg'])){
          $_SESSION['ipp']['status_kepeg'] = $_POST['status_kepeg'];
        }
        if(isset($_POST['jnspeg'])){
          $_SESSION['ipp']['jnspeg'] = $_POST['jnspeg'];
        }
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['ipp']['proses']['status'] = $_POST['status'];
          unset($_POST['status']); // langsung unset setelah menjadi $_SESSION;
        }else{
          if(isset($_SESSION['ipp']['proses']['status'])){
            unset($_SESSION['ipp']['proses']['status']);
          }
        }
        // untuk perintah eksekusi (bila tidak 1-1)
        echo showDialogProsesIPP($_POST);
        // echo 1;
        // echo msgSukses("Tampilan data yang akan diproses.");
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        exit;
      break;
      case 'ipp_proses2':
        $data = explode(",",$_POST['data']);
        // echo "<pre>"; print_r($data); echo "</pre>"; exit;
        if($data[2]==4){ // jika merupakan Tenaga KONTRAK
		      echo msgGagal("Maaf, kamu cantik! *_-");
        	exit;
        }
        $html="";
        if($data[2]!=1 && $data[2]!=3){ // jika merupakan tenaga CPNS/PNS
          $vSQL = "a.`status_kepeg` = ".intval($data[2]);
        }else{
          $vSQL = "(a.`status_kepeg` = 1 OR a.`status_kepeg` = 3)";
        }
        if(isset($_SESSION['ipp']['proses']['status']) && is_array($_SESSION['ipp']['proses']['status']) && count($_SESSION['ipp']['proses']['status'])>1){
          $vSQL .= " AND ( status = ".implode(" OR status = ", $_SESSION['ipp']['proses']['status']).")";
        }elseif(isset($_SESSION['ipp']['proses']['status']) && is_array($_SESSION['ipp']['proses']['status']) && count($_SESSION['ipp']['proses']['status'])==1){
          $vSQL .= " AND status = ".$_SESSION['ipp']['proses']['status'][0];
        }
        $sql = "SELECT a.`nip`, a.`unit_id`, a.`status_kepeg`, a.`jnspeg`, a.`golongan_id`, b.`kelompok`, a.`npwp` FROM `kepeg_tb_pegawai` a LEFT JOIN `kepeg_tb_golongan` b ON a.`golongan_id` = b.`id` WHERE ".$vSQL." AND a.`jnspeg` = ".intval($data[3]);
        if(is_numeric($data[1]) && isExist($data[1],'kepeg_unit','id')){
          $sql.=" AND unit_id = ".intval($data[1]);
        }
        $tgl_transaksi = "";
        //echo $sql; exit;
        $row=getRow($sql);
        if($row > 0){
          // $last_id = 0;
          // $_POST['tgl_transaksi'] = $_POST['tgl_transaksi'].'-01-01';
          $r = getdatadb($sql);
          // $i=1;
          foreach ($r as $k => $v) {
            $sql_e = "SELECT `id_trans` FROM kepeg_tr_ipp WHERE `nip` LIKE '".$v['nip']."' AND `tgl_transaksi` LIKE '".$data[4]."%' AND `semester` LIKE '".$data[5]."'";
            // $html.=$sql_e."<br />";
            $row = getRow($sql_e);
            if($row==0){
              if(intval($v['kelompok'])==4){
                $_pajak = 0.15;
              }elseif(intval($v['kelompok'])==3){
                $_pajak = 0.05;
              }else{
								if($v['status_kepeg']==2){
                  if(strlen(trim($v['npwp']))<10){
                    $_pajak = 0.06;
                  }else{
                    $_pajak = 0.05;
                  }
								}else{
									$_pajak = 0;
								}
              }
              $_potongan = ceil($_pajak * $_CONFIG['ipp']['nominal']);
              $_netto = $_CONFIG['ipp']['nominal'] - $_potongan;
              $tgl_transaksi = $data[4].'-01-01';
              $sql_e = "INSERT INTO `kepeg_tr_ipp`(tgl_transaksi, semester, nip, unitid, statuspeg, jenispeg, ipp, pajak, potongan, netto) VALUES('".$tgl_transaksi."', '".$data[5]."', '".$v['nip']."', '".$v['unit_id']."', '".$v['status_kepeg']."', '".$v['jnspeg']."', '".$_CONFIG['ipp']['nominal']."', '".$_pajak."', '".$_potongan."', '".$_netto."')";
              // echo $i.". ".$sql_e."<br/>";
              execute($sql_e);
            }
            // $i++;
          }
          // echo $html;
          echo 1;
        }
        exit;
      break;
      case 'ipp_lihat':
        // print_r($_POST); exit;
        if(!isset($_POST['tgl_transaksi']) && strlen(trim($_POST['tgl_transaksi']))!=4){
          echo msgGagal("Masukkan tahun transaksi untuk melakukan proses !");
          exit;
        }else{
          $_SESSION['ipp']['tgl_transaksi'] = $_POST['tgl_transaksi'];
        }

        $_SESSION['ipp']['semester'] = $_POST['semester'];

        if(is_numeric($_POST['unit_id']) && isExist($_POST['unit_id'],'kepeg_unit','id')){
          $_SESSION['ipp']['unit_id'] = $_POST['unit_id'];
        }else{
          if(isset($_SESSION['ipp']['unit_id'])){
            unset($_SESSION['ipp']['unit_id']);
          }
        }
        if(isset($_POST['status_kepeg'])){
          $_SESSION['ipp']['status_kepeg'] = $_POST['status_kepeg'];
        }
        if(isset($_POST['jnspeg'])){
          $_SESSION['ipp']['jnspeg'] = $_POST['jnspeg'];
        }
        if(isset($_POST['status']) && is_array($_POST['status']) && count($_POST['status'])>0){
          $_SESSION['ipp']['proses']['status'] = $_POST['status'];
          unset($_POST['status']);
        }else{
          if(isset($_SESSION['ipp']['proses']['status'])){
            unset($_SESSION['ipp']['proses']['status']);
          }
        }
        // echo msgSukses("Tampilan data yang sudah diproses.");
        echo 1;
        exit;
      break;
      case 'ipp_reset':
        // set variable untuk menghapus sesi ipp.
        unset($_SESSION['ipp']);
        echo 1;
        exit;
      break;
      case 'ipp_hapus_berjamaah':
        if(isset($_POST['id']) && count($_POST['id'])>0){
          $sql = "DELETE FROM `kepeg_tr_ipp` WHERE `id_trans` = 0";
          foreach ($_POST['id'] as $key => $value) {
            // hapus berjamaah
            $sql.=" OR id_trans =".$value;
          }
          execute($sql);
          echo 1; exit;
        }
        echo "Tidak ada yang dapat dihapus.";
        exit;
      break;
      case 'ipp_hapus_single':
        if(isset($_POST['id']) && isExist(intval($_POST['id'],'kepeg_tr_ipp','id'))){
          $sql = "DELETE FROM `kepeg_tr_ipp` WHERE `id_trans` = ".$_POST['id'];
          execute($sql);
          echo 1; exit;
        }
        echo "Tidak ada yang dapat dihapus.";
        exit;
      break;
      case 'ipp_download':

      break;
      // -- END IPP -- //



  		default:
  			# code...
  		break;
  	}
  }
?>
