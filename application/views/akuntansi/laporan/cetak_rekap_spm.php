<!DOCTYPE>
<?php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=rekap_spm.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<html>
	<head>
		<title>Rekap SPM</title>
		<style type="text/css">
		.border {
		    border-collapse: collapse;
		}

		.border td,
		.border th{
		    border: 1px solid black;
		}
		</style>
		<script type="text/javascript">
		</script>
	</head>
	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<div class="row">
			<div style="width:1000px">
				<center><h1>REKAP SPM <?php echo get_unit($kode_unit); ?></h1>
					<div style="font-size:12pt;"><?php echo $periode; ?></div></center>
				<hr/>
				<table class="table border">
					<thead>
						<tr>
							<th>No</th>
							<th>Jenis</th>
							<th>Tanggal</th>
							<th>No. SPM</th>
							<th width="300px !important">Keterangan</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1;$total=0; ?>
						<?php if($up->num_rows() > 0){
							foreach($up->result() as $result){ 
							if($result->flag_proses_akuntansi==1){ 
								echo '<tr style="background-color:#EFF6F7">';
							}else{
								echo '<tr>';
							}?>			
							<td><?php echo $no; ?>.</td>
							<td>UP</td>
							<td><?php echo date("d-m-Y", strtotime($result->tgl_spm)); ?></td>
							<td><?php echo $result->str_nomor_trx; ?></td>			
							<td><?php echo $result->untuk_bayar; ?></td>
							<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
						</tr>
						<?php $no++; } } ?>
						<?php if($gu->num_rows() > 0){
							foreach($gu->result() as $result){ 
							if($result->flag_proses_akuntansi==1){ 
								echo '<tr style="background-color:#EFF6F7">';
							}else{
								echo '<tr>';
							}?>			
							<td><?php echo $no; ?>.</td>
							<td>GU</td>
							<td><?php echo date("d-m-Y", strtotime($result->tgl_spm)); ?></td>
							<td><?php echo $result->str_nomor_trx; ?></td>			
							<td><?php echo $result->untuk_bayar; ?></td>
							<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
						</tr>
						<?php $no++; } } ?>
						<?php if($pup->num_rows() > 0){
							foreach($pup->result() as $result){ 
							if($result->flag_proses_akuntansi==1){ 
								echo '<tr style="background-color:#EFF6F7">';
							}else{
								echo '<tr>';
							}?>			
							<td><?php echo $no; ?>.</td>
							<td>PUP</td>
							<td><?php echo date("d-m-Y", strtotime($result->tgl_spm)); ?></td>
							<td><?php echo $result->str_nomor_trx; ?></td>			
							<td><?php echo $result->untuk_bayar; ?></td>
							<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
						</tr>
						<?php $no++; } } ?>
						<?php if($tup->num_rows() > 0){
							foreach($tup->result() as $result){ 
							if($result->flag_proses_akuntansi==1){ 
								echo '<tr style="background-color:#EFF6F7">';
							}else{
								echo '<tr>';
							}?>			
							<td><?php echo $no; ?>.</td>
							<td>TUP</td>
							<td><?php echo date("d-m-Y", strtotime($result->tgl_spm)); ?></td>
							<td><?php echo $result->str_nomor_trx; ?></td>			
							<td><?php echo $result->untuk_bayar; ?></td>
							<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
						</tr>
						<?php $no++; } } ?>
						<?php if($ls3->num_rows() > 0){
							foreach($ls3->result() as $result){ 
							if($result->flag_proses_akuntansi==1){ 
								echo '<tr style="background-color:#EFF6F7">';
							}else{
								echo '<tr>';
							}?>			
							<td><?php echo $no; ?>.</td>
							<td>LSPHK3</td>
							<td><?php echo date("d-m-Y", strtotime($result->tgl_spm)); ?></td>
							<td><?php echo $result->str_nomor_trx; ?></td>			
							<td><?php echo $result->untuk_bayar; ?></td>
							<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
						</tr>
						<?php $no++; } } ?>
						<?php if($lspg->num_rows() > 0){
							foreach($lspg->result() as $result){ 
							if($result->flag_proses_akuntansi==1){ 
								echo '<tr style="background-color:#EFF6F7">';
							}else{
								echo '<tr>';
							}?>			
							<td><?php echo $no; ?>.</td>
							<td>LSPG</td>
							<td><?php echo date("d-m-Y", strtotime($result->tanggal)); ?></td>
							<td><?php echo $result->nomor; ?></td>			
							<td><?php echo $result->untuk_bayar; ?></td>
							<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
						</tr>
						<?php $no++; } } ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="5" align="right">Total</th>
							<th><?php echo number_format($total); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</body>
</html>
<?php
function get_unit($unit){
	if($unit==null or $unit=='all'){
		return "SEMUA FAKULTAS";
	}else{	
		$ci =& get_instance();
		$ci->db2 = $ci->load->database('rba', true);

		$query = "SELECT * FROM unit WHERE kode_unit='$unit'";
		$q = $ci->db2->query($query)->result();
		foreach($q as $result){
			return $result->nama_unit;
		}
	}
}
?>