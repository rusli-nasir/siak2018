          	<table align="center" style="width:700px;border:none;margin-right: auto; margin-left: auto;" border="0">
              <tbody>
                <tr>
                  <td colspan="7" style="font-weight: bold;text-align: center;">
            	Daftar Penerima Gaji Tenaga Kerja Kontrak <?php echo $this->cantik_model->getJenisPeg($_SESSION['tkk']['jnspeg']); ?><br/>Universitas Diponegoro<br/>
              bulan <?php echo $this->cantik_model->wordMonth($_SESSION['tkk']['bulan']); ?> tahun <?php echo $_SESSION['tkk']['tahun']; ?>
                  </td>
                </tr>
                <tr><td colspan="7">&nbsp;</td></tr>
              </tbody>
            </table>
            <table align="center" style="width:700px;border:none;margin-right: auto; margin-left: auto;" border="0">
              <tbody>
                <tr>
                  <td>
                    Unit :
                  </td>
                  <td colspan="6">
                    <?php echo $daftar_unit; ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    Status Pegawai : 
                  </td>
                  <td colspan="6">
                    <?php echo $daftar_status; ?>
                  </td>
                </tr>
                <tr><td colspan="7">&nbsp;</td></tr>
              </tbody>
            </table>
            <table style="border-collapse:collapse;width:700px;margin-right: auto; margin-left: auto;" border="1" align="center" cellpadding="3">
            	<thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NIP</th>
                  <th>Unit</th>
                  <th>Bank</th>
                  <th>No. Rek.</th>
                  <th>Netto</th>
                </tr>
               </thead>
               <tbody>
<?php
if(isset($dt) && is_array($dt) && count($dt)>0){
	$i=1;
	$total_bruto = 0; $total_pajak = 0; $total_netto = 0;
	foreach($dt as $k => $v){
?>
                  <tr>
                    <td style="text-align: right;"><?php echo $i; ?></td>
                    <td style="text-align: left;"><?php echo $v->nama; ?></td>
                    <td style="text-align: center;">'<?php echo $v->nip; ?></td>
                    <td style="text-align: center;"><?php echo $v->unit_short; ?></td>
                    <td style="text-align: center;"><?php echo $v->kelompok_bank; ?></td>
                    <td style="text-align: center;">'<?php echo $v->norekening; ?></td>
                    <td style="text-align: right;"><?php echo $this->cantik_model->number($v->nominalg); ?></td>
                  </tr>
<?php
		$total_netto+=$v->nominalg;
		$i++;
	}
?>
									<tr>
                  	<td colspan="6" style="text-align:center;">Total</td>
                    <td style="text-align: right;"><?php echo $this->cantik_model->number($total_netto); ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align:center;border:none;">Terbilang</td>
                    <td colspan="5" style="text-align:left;border:none;"><?php echo ucwords(strtolower($this->cantik_model->convertAngka($total_netto))); ?></td>
                  </tr>
<?php
}else{
?>
                  <tr>
                  	<td colspan="7" class="alert alert-warning text-center">
                    	Tidak ditemukan data yang ada pada daftar kriteria ini.
                    </td>
                  </tr>
<?php
}
?>
									<!-- <tr>
                  	<td colspan="7" style="border:none;">&nbsp;</td>
                  </tr> -->
               </tbody>
            </table>
            <table align="center" style="width:700px;border:none;margin-right: auto; margin-left: auto;" border="0">
              <tbody>
                <tr><td colspan="7">&nbsp;</td></tr>
								<tr>
                  <td colspan="4">
                    Mengetahui,<br />
                    Pejabat Penatausahaan Keuangan SUKPA,<br />
                    <br /><br /><br /><br />
                    <?php echo $ppk->nm_lengkap; ?><br />
                    NIP. <?php echo $ppk->nomor_induk; ?>
                  </td>
                  <td colspan="3">
                    &nbsp;<br />
                    Bendahara Pengeluaran SUKPA,<br />
                    <br /><br /><br /><br />
                    <?php echo $bpp->nm_lengkap; ?><br />
                    NIP. <?php echo $bpp->nomor_induk; ?>
                  </td>
                </tr>
              </tbody>
            </table>