          	<h4 style="text-align:center">
            	Daftar Penerima Insentif Kinerja Wajib <?php echo $this->cantik_model->getJenisPeg($_SESSION['ikw']['jnspeg']); ?><br/>Universitas Diponegoro<br/>
              Bulan <?php echo $this->cantik_model->wordMonth($_SESSION['ikw']['bulan']); ?> Tahun <?php echo $_SESSION['ikw']['tahun']; ?>
            </h4>
            <p style="font-weight:bold;">
            	Unit : <?php echo $daftar_unit; ?><br />
              Status Pegawai : <?php echo $daftar_status; ?>
            </p>
            <table style="border-collapse:collapse;" align="center" border="1" width="1000">
            	<thead>
                <tr>
                  <th style="text-align:center">No</th>
                  <th style="text-align:center">Nama</th>
                  <th style="text-align:center">NIP</th>
                  <th style="text-align:center">Unit</th>
                  <th style="text-align:center">Jabatan</th>
                  <th style="text-align:center">Gol.</th>
                  <th style="text-align:center">Status</th>
                  <th style="text-align:center">NPWP</th>
                  <th style="text-align:center">Bank</th>
                  <th style="text-align:center">Nama Rek.</th>
                  <th style="text-align:center">No. Rek.</th>
                  <th style="text-align:center">IKW 100%</th>
            <?php
              $skp = "";
              if($_SESSION['ikw']['jenispeg']!=2){
                $skp = $this->load->database('skp', TRUE);
              }
              $tot_ = 11;
              if($_SESSION['ikw']['jnspeg'] == 1){
                $tot_ = 14;
            ?>
                  <th style="text-align:center">SKS Capaian</th>
                  <th style="text-align:center">SKS Target</th>
                  <th style="text-align:center">Komposisi</th>
            <?php
              }
            ?>
                  <th style="text-align:center">Presentase Terima</th>
                  <th style="text-align:center">Bruto</th>
                  <th style="text-align:center">Pajak</th>
                  <th style="text-align:center">Jumlah Pajak</th>
                  <th style="text-align:center" nowrap="nowrap">Potongan Lainnya</th>
                  <th style="text-align:center">Netto</th>
                </tr>
               </thead>
               <tbody>
<?php
if(isset($dt) && is_array($dt) && count($dt)>0){
	$i=1;
	$total_bruto = 0; $total_pajak = 0; $total_netto = 0; $total_potlainnya = 0;
	foreach($dt as $k => $v){
    $ikw = $this->cantik_model->getIKWBruto($v->kelompok, $v->bobot);
    if($v->status_kepeg==2 && $v->kelompok == 2){
      $ikw = round($ikw * (1 / (1-$v->pajak)));
    }
    if($v->status == 12){
        $persen = ($pot_tugasbelajar*100)."%";
    }else{
      if($_SESSION['ikw']['jnspeg'] == 2){
        if($_SESSION['ikw']['bulan']>=1 && $_SESSION['ikw']['bulan']<=12){
          $persen = ($this->cantik_model->set_persentase_ikw($v->jam)*100)."%";
        }else{
          $persen = '100%';
        }
      }else{
        // if(is_null($v->persentase) || intval($v->persentase)<=0){
        //   $persen = '0%';
        // }else{
          $persen = ($v->persentase*100)."%";
        // }
      }
    }
?>
                  <tr id="tr_<?php echo $v->id_trans;?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $v->nama; ?></td>
                    <td>'<?php echo $v->nip; ?></td>
                    <td><?php echo $v->unit; ?></td>
                    <td><?php echo $v->jabatan; ?></td>
                    <td><?php echo $this->cantik_model->getGolongan($v->golongan_id); ?></td>
                    <td><?php echo $this->cantik_model->getStatus($v->status); ?></td>
                    <td style="text-align:center">'<?php echo $v->npwp; ?></td>
                    <td style="text-align:center"><?php echo $v->kelompok_bank; ?></td>
                    <td style="text-align:left"><?php echo $v->nmpemilik; ?></td>
                    <td style="text-align:center">'<?php echo $v->norekening; ?></td>
                    <td style="text-align:right;">'<?php echo $ikw; ?></td>
                  <?php
                    if($_SESSION['ikw']['jnspeg'] == 1){
                      $vDSQL = "";
              				if($_SESSION['ikw']['bulan']<=6 && $_SESSION['ikw']['bulan']>=1){
              					$smsDosen = ($_SESSION['ikw']['tahun']-1).'2';
              					$vDSQL = " AND `thnskp` LIKE '".$smsDosen."'";
              				}else
              				if($_SESSION['ikw']['bulan']<=12 && $_SESSION['ikw']['bulan']>=7){
              					$smsDosen = $_SESSION['ikw']['tahun'].'1';
              					$vDSQL = " AND `thnskp` LIKE '".$smsDosen."'";
              				}
                      $sql_dosen = "SELECT * FROM `dt_penetapan` WHERE `posisi_penetapan` = '3' AND `id_dosen` = '".$v->id_peg."'".$vDSQL;
  										$q = $skp->query($sql_dosen);
  										if($q->num_rows()<=0){
  											// $ikw = 0;
                        $ds['komposisi'] = 2;
                        $ds['sks_ikw'] = 0;
  										}else{
  											$ds = (array) $q->row();
  											// $persen = $this->cantik_model->set_persentase_ikw($t['sks_ikw'], $t['komposisi']);
  											// $ikw = round($ikw * $persen);
  										}
                  ?>
                    <td style="text-align:right;">'<?php echo $ds['sks_ikw']; ?></td>
                    <td style="text-align:right;">'16</td>
                    <td style="text-align:center;"><?php echo ($ds['komposisi']==1 ? "Sesuai" : "Tidak Sesuai") ?></td>
                  <?php
                    }
                  ?>
                    <td style="text-align:right;">'<?php echo $persen; ?></td>
                    <td style="text-align:right;"><?php echo $v->bruto; ?></td>
                    <td style="text-align:center"><?php echo $this->cantik_model->pajak($v->pajak); ?></td>
                    <td style="text-align:right;"><?php echo $v->jml_pajak; ?></td>
                    <td style="text-align:right;"><?php echo $v->pot_lainnya; ?></td>
                    <td style="text-align:right;"><?php echo $v->netto; ?></td>
                  </tr>
<?php
		$total_bruto+=$v->bruto;
		$total_pajak+=$v->jml_pajak;
		$total_netto+=$v->netto;
		$total_potlainnya+=$v->pot_lainnya;
		$i++;
	}
?>
									<tr>
                  	<th colspan="<?php echo $tot_; ?>">Total</th>
                    <th style="text-align:right;">'<?php echo $total_bruto; ?></th>
                    <th>&nbsp;</th>
                    <th style="text-align:right;">'<?php echo $total_pajak; ?></th>
                    <th style="text-align:right;">'<?php echo $total_potlainnya; ?></th>
                    <th style="text-align:right;">'<?php echo $total_netto; ?></th>
                  </tr>
<?php
}
?>
              </tbody>
            </table>
            <table style="border-collapse:collapse;" align="center" width="1000">
              <tbody>
                <tr>
                  <td colspan="15">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="5">
                    Mengetahui,<br />
                    Pejabat Penatausahaan Keuangan SUKPA,<br />
                    <br /><br /><br /><br />
                    <?php echo $ppk->nm_lengkap; ?><br />
                    NIP. <?php echo $ppk->nomor_induk; ?>
                  </td>
                  <td colspan="5">
                    &nbsp;<br />
                    Bendahara Pengeluaran SUKPA,<br />
                    <br /><br /><br /><br />
                    <?php echo $bpp->nm_lengkap; ?><br />
                    NIP. <?php echo $bpp->nomor_induk; ?>
                  </td>
                  <td colspan="5" align="left">
                    '<?php echo date("d")." ".$this->cantik_model->wordMonth(date("m"))." ".date("Y"); ?><br />
                    Pembuat Daftar,<br />
                    <br /><br /><br /><br />
                    .................................<br />
                    NIP. ............................
                  </td>
                </tr>
              </tbody>
            </table>
