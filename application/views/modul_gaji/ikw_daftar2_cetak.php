          	<h4 style="text-align:center">
            	Daftar Potongan berdasarkan Kinerja Penerima Insentif Kinerja Wajib <?php echo $this->cantik_model->getJenisPeg($_SESSION['ikw']['jnspeg']); ?><br/>Universitas Diponegoro<br/>
              Semester <?php echo $this->cantik_model->wordMonth($_SESSION['ikw']['bulan']); ?> Tahun <?php echo $_SESSION['ikw']['tahun']; ?>
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
                  <th style="text-align:center">Nominal IKW</th>
                  <th style="text-align:center">Capaian Semester Sebelum</th>
                  <th style="text-align:center">Kinerja Wajib</th>
                  <th style="text-align:center">Kinerja tidak tercapai</th>
                  <th style="text-align:center">Jumlah Potongan</th>
                </tr>
               </thead>
               <tbody>
<?php
if(isset($dt) && is_array($dt) && count($dt)>0){
	$i=1;
	$total_bruto = 0; $total_pajak = 0; $total_netto = 0; $total_potlainnya = 0;
	foreach($dt as $k => $v){
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
                    <td style="text-align:center"><?php echo $v->nmbank; ?></td>
                    <td style="text-align:center">'<?php echo $v->nmpemilik; ?></td>
                    <td style="text-align:center">'<?php echo $v->norekening; ?></td>
                    <td style="text-align:center;">'<?php echo $v->ikw; ?></td>
                    <td style="text-align:center"><?php echo $v->capaian_smt_sblm; ?></td>
                    <td style="text-align:center;"><?php echo $v->kinerja_wajib; ?></td>
                    <td style="text-align:center;"><?php echo $v->kinerja_tdk_tercapai; ?></td>
                    <td style="text-align:center;">'<?php echo $v->pot_ikw; ?></td>
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
                  	<th colspan="10">Total</th>
                    <th style="text-align:right;">'<?php echo $total_bruto; ?></th>
                    <th>&nbsp;</th>
                    <th style="text-align:right;">'<?php echo $total_pajak; ?></th>
                    <th style="text-align:right;">'<?php echo $total_potlainnya; ?></th>
                    <th style="text-align:right;">'<?php echo $total_netto; ?></th>
                  </tr>
<?php
}
?>
                <tr>
                <?php
                    for($i=0;$i<15;$i++){
                ?>
                  <td>&nbsp;</td>
                <?php
                    }
                ?>
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
                  <td colspan="5">
                    <?php echo date("d")." ".$this->cantik_model->wordMonth(date("m"))." ".date("Y"); ?><br />
                    Pembuat Daftar,<br />
                    <br /><br /><br /><br />
                    .................................<br />
                    NIP. ............................
                  </td>
                </tr>
              </tbody>
            </table>