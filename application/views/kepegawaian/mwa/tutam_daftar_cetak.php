          	<h4 class="text-center">
            	Daftar Penerima Insentif Tugas Tambahan<br/>Universitas Diponegoro<br/>
              Bulan <?php echo $this->cantik_model->wordMonth($_SESSION['tutam_mwa']['bulan']); ?> Tahun <?php echo $_SESSION['tutam_mwa']['tahun']; ?>
            </h4>

            <table style="border-collapse:collapse;" border="1" align="center">
               <tr>
                  <th style="text-align:center;">No</th>
                  <th style="text-align:center;">Nama</th>
                  <th style="text-align:center;">NIP</th>
                  <th style="text-align:center;">Tugas Tambahan</th>
                  <th style="text-align:center;">Unit Asal</th>
                  <th style="text-align:center;">Status</th>
                  <th style="text-align:center;">NPWP</th>
                  <th style="text-align:center;">Nama Bank</th>
                  <th style="text-align:center;">Nama Pemilik</th>
                  <th style="text-align:center;">Rekening</th>
                  <th style="text-align:center;">Nominal TuTam</th>
                  <th style="text-align:center;">Pajak</th>
                  <th style="text-align:center;">Jumlah Pajak</th>
                  <th style="text-align:center;">Netto</th>
                </tr>
<?php
					$j = 0;
          $i=1;
          $total = 0;
          $total_pajak = 0;
          $total_selanjutnya = 0;
				if(is_array($dt) && count($dt)>0){
          foreach ($dt as $k => $v) {
				    // $rek = $this->cantik_model->get_rekening_tutam($v->nip);
?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $v->nama; ?></td>
                  <td>'<?php echo $v->nip; ?></td>
                  <td><?php echo $v->tugas_tambahan; ?> <?php echo $v->det_tgs_tambahan; ?></td>
                  <td>
                    <?php 
                      if(strlen(trim($v->unit_id))>0 && is_numeric($v->unit_id) && $v->unit_id != 0){ 
                        echo $this->cantik2_model->getUnit($v->unit_id); 
                      }
                    ?>  
                  </td>
                  <td>
                    <?php 
                      if(strlen(trim($v->status))>0 && is_numeric($v->status) && $v->status != 0){
                        echo $this->cantik2_model->getStatus($v->status);
                      }
                    ?>
                  </td>
                  <td>'<?php echo $v->npwp; ?></td>
                  <td><?php echo $v->nmbank; ?></td>
                  <td><?php echo $v->nmpemilik; ?></td>
                  <td>'<?php echo $v->norekening; ?></td>
                  <td align="right"><?php echo $v->nominal; ?></td>
                  <td align="right"><?php echo $this->cantik_model->pajak($v->pajak); ?></td>
                  <td align="right"><?php //echo $v->nom_pajak; ?>
                    <?php echo ($nom_pajak = ceil($v->pajak*$v->nominal)); ?>
                  </td>
                  <td align="right">
                    <?php //echo $v->bersih; ?>
                    <?php echo ($bersih = ($v->nominal-$nom_pajak)); ?>  
                  </td>
                </tr>
<?php
						$total+=$v->nominal;
						$total_pajak+=$nom_pajak;
						$total_selanjutnya+=$bersih;
            $i++;
          }
?>
                <tr>
                  <th colspan="10">&nbsp;</th>
                  <th align="right"><?php echo $total; ?></th>
                  <th>&nbsp;</th>
                  <th align="right"><?php echo $total_pajak; ?></th>
                  <th align="right"><?php echo $total_selanjutnya; ?></th>
                </tr>
<?php
				}else{
?>
        				<tr><td colspan="13">Tidak ada data Insentif Tugas Tambahan untuk <?php echo $this->cantik_model->wordMonth($_SESSION['tutam_mwa']['bulan']); ?> <?php echo $_SESSION['tutam_mwa']['tahun']; ?></td></tr>
<?php
				}
?>
            </table>
            <table style="border-collapse:collapse;" border="0" align="center">
                <tr><td colspan="13">&nbsp;</td></tr>
                <tr><td colspan="13">&nbsp;</td></tr>
								<tr>
                  <td colspan="4">
                    Mengetahui,<br />
                    Pejabat Penatausahaan Keuangan SUKPA,<br />
                    <br /><br /><br /><br />
                    <?php echo $ppk->nm_lengkap; ?><br />
                    NIP. <?php echo $ppk->nomor_induk; ?>
                  </td>
                  <td colspan="4">
                    &nbsp;<br />
                    Bendahara Pengeluaran SUKPA,<br />
                    <br /><br /><br /><br />
                    <?php echo $bpp->nm_lengkap; ?><br />
                    NIP. <?php echo $bpp->nomor_induk; ?>
                  </td>
                  <td colspan="5">
                    '<?php echo date("d")." ".$this->cantik_model->wordMonth(date("m"))." ".date("Y"); ?><br />
                    Pembuat Daftar,<br />
                    <br /><br /><br /><br />
                    .................................<br />
                    NIP. ............................
                  </td>
                </tr>
        		</table>
