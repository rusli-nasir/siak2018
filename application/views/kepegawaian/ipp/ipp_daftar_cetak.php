          	<h4 style="text-align:center;">
            	Daftar Penerima Insentif Perbaikan Penghasilan <?php echo $this->cantik_model->getJenisPeg($_SESSION['ipp']['jnspeg']); ?><br/>Universitas Diponegoro<br/>
              Semester <?php echo $this->cantik_model->getSemester($_SESSION['ipp']['semester']); ?> Tahun <?php echo $_SESSION['ipp']['tahun']; ?>
            </h4>
            <p style="font-weight:bold;">
            	Unit : <?php echo $daftar_unit; ?><br />
              Status Pegawai : <?php echo $daftar_status; ?>
            </p>
            <table style="border-collapse:collapse;" border="1" align="center">
            	<thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NIP</th>
                  <th>Unit</th>
                  <th>Gol.</th>
                  <th>Status</th>
                  <th>NPWP</th>
                  <th>Bank</th>
                  <th>No. Rek.</th>
                  <th>Nama Pemilik</th>
                  <th>Bruto</th>
                  <th>Pajak</th>
                  <th>Jumlah Pajak</th>
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
                    <td><?php echo $i; ?></td>
                    <td><?php echo $v->nama; ?></td>
                    <td>'<?php echo $v->nip; ?></td>
                    <td><?php echo $this->cantik2_model->getUnit($v->unitid); ?></td>
                    <td><?php echo $v->golpeg; ?></td>
                    <td><?php echo $this->cantik2_model->getStatus($v->status); ?></td>
                    <td>'<?php echo $v->npwp; ?></td>
                    <td><?php echo $v->nmbank; ?></td>
                    <td><?php echo $v->nmpemilik; ?></td>
                    <td>'<?php echo $v->norekening; ?></td>
                    <td><?php echo $v->ipp; ?></td>
                    <td><?php echo $this->cantik_model->pajak($v->pajak); ?></td>
                    <td><?php echo $v->potongan; ?></td>
                    <td><?php echo $v->netto; ?></td>
                  </tr>
<?php
		$total_bruto+=$v->ipp;
		$total_pajak+=$v->potongan;
		$total_netto+=$v->netto;
		$i++;
	}
?>
									<tr>
                  	<th colspan="10">Total</th>
                    <th><?php echo $total_bruto; ?></th>
                    <th>&nbsp;</th>
                    <th><?php echo $total_pajak; ?></th>
                    <th><?php echo $total_netto; ?></th>
                  </tr>
<?php
}else{
?>
                  <tr>
                  	<th colspan="14" class="alert alert-warning text-center">
                    	Tidak ditemukan data yang ada pada daftar kriteria ini.
                    </th>
                  </tr>
<?php
}
?>
									<tr>
                  	<th colspan="14" style="border:none;">&nbsp;</th>
                  </tr>
									<tr>
                  <td colspan="5" style="border:none;">
                    Mengetahui,<br />
                    Pejabat Penatausahaan Keuangan SUKPA,<br />
                    <br /><br /><br /><br />
                    <?php echo $ppk->nm_lengkap; ?><br />
                    NIP. <?php echo $ppk->nomor_induk; ?>
                  </td>
                  <td colspan="4" style="border:none;">
                    &nbsp;<br />
                    Bendahara Pengeluaran SUKPA,<br />
                    <br /><br /><br /><br />
                    <?php echo $bpp->nm_lengkap; ?><br />
                    NIP. <?php echo $bpp->nomor_induk; ?>
                  </td>
                  <td colspan="5" style="border:none;">
                    <?php echo date("d")." ".$this->cantik_model->wordMonth(date("m"))." ".date("Y"); ?><br />
                    Pembuat Daftar,<br />
                    <br /><br /><br /><br />
                    .................................<br />
                    NIP. ............................
                  </td>
                </tr>
               </tbody>
            </table>