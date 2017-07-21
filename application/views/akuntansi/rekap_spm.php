<!-- javascript -->
<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">
<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/akuntansi/js/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/akuntansi/css/daterangepicker.css" />
<script type="text/javascript">
	$(document).ready(function(){
		var host = location.protocol + '//' + location.host + '/sisrenbang/index.php/';

		$("#filter_tahun").change(function(){
			$("#form_filter_tahun").submit();
		});
		$("#filter_status").change(function(){
			$("#form_filter").submit();
		});
		$('#unit_list').selectize();
	});
</script>
<!-- javascript -->
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Rekap SPM</li>
	</ol>
</div><!--/.row-->
<hr/>
<div style="font-size:20pt;margin-bottom:20px;">
	<span class="glyphicon glyphicon-dashboard"></span> Rekap SPM
</div>
<div class="row">
	<div class="col-sm-6">
		<form class="form-horizontal" action="<?php echo site_url('akuntansi/laporan/rekap_spm'); ?>" method="post">
			<div class="form-group">
			    <div class="col-md-10">
			    	<select id="unit_list" name="unit" class="form-control" required="">
		              <option value="all" selected=""> Semua</option>
			            <?php foreach($query_unit->result() as $unit): ?>
			              <option value="<?php echo $unit->kode_unit ?>" <?php if(isset($kode_unit)){ if($kode_unit==$unit->kode_unit) echo 'selected'; } ?>><?= $unit->alias." - ".$unit->nama_unit ?></option>
			            <?php endforeach; ?>
			        </select>
			    </div>
			    <div class="col-md-2">
			    	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Cari</button>
			    </div>
			</div>
		</form>
	</div>
	<div class="col-sm-2">
		<form class="form-horizontal" action="<?php echo site_url('akuntansi/laporan/rekap_spm/cetak'); ?>" method="post" target="_blank">
			<input type="hidden" name="unit" value="<?php if(isset($kode_unit)) echo $kode_unit; ?>">
			<button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-print"></span> Cetak</button>
		</form>
	</div>
</div>
	    
<div class="row">
	<div class="col-sm-2">
		<div style="width:50px;height:30px;background-color:#DAEEF3;border:2px solid #1c1c1c"></div>
		Sudah dijurnal
	</div>
	<div class="col-sm-2">
		<div style="width:50px;height:30px;background-color:#fff;border:2px solid #1c1c1c"></div>
		Belum dijurnal
	</div>
</div>
<div class="row">
	<div class="col-sm-12">	
		<table class="table">
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
				<?php $no=1; ?>
				<?php if($up->num_rows() > 0){
					foreach($up->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>UP</td>
					<td><?php echo date("d-m-Y, H:i:s", strtotime($result->tgl_spm)); ?></td>
					<td><?php echo $result->str_nomor_trx; ?></td>			
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php echo number_format($result->jumlah_bayar); ?></td>
				</tr>
				<?php $no++; } } ?>
				<?php if($gu->num_rows() > 0){
					foreach($gu->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>GU</td>
					<td><?php echo date("d-m-Y, H:i:s", strtotime($result->tgl_spm)); ?></td>
					<td><?php echo $result->str_nomor_trx; ?></td>			
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php echo number_format($result->jumlah_bayar); ?></td>
				</tr>
				<?php $no++; } } ?>
				<?php if($pup->num_rows() > 0){
					foreach($pup->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>PUP</td>
					<td><?php echo date("d-m-Y, H:i:s", strtotime($result->tgl_spm)); ?></td>
					<td><?php echo $result->str_nomor_trx; ?></td>			
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php echo number_format($result->jumlah_bayar); ?></td>
				</tr>
				<?php $no++; } } ?>
				<?php if($tup->num_rows() > 0){
					foreach($tup->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>TUP</td>
					<td><?php echo date("d-m-Y, H:i:s", strtotime($result->tgl_spm)); ?></td>
					<td><?php echo $result->str_nomor_trx; ?></td>			
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php echo number_format($result->jumlah_bayar); ?></td>
				</tr>
				<?php $no++; } } ?>
				<?php if($ls3->num_rows() > 0){
					foreach($ls3->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>LSPHK3</td>
					<td><?php echo date("d-m-Y, H:i:s", strtotime($result->tgl_spm)); ?></td>
					<td><?php echo $result->str_nomor_trx; ?></td>			
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php echo number_format($result->jumlah_bayar); ?></td>
				</tr>
				<?php $no++; } } ?>
				<?php if($lspg->num_rows() > 0){
					foreach($lspg->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>LSPG</td>
					<td><?php echo date("d-m-Y", strtotime($result->tanggal)); ?></td>
					<td><?php echo $result->nomor; ?></td>			
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php echo number_format($result->jumlah_bayar); ?></td>
				</tr>
				<?php $no++; } } ?>
			</tbody>
		</table>
	</div>
</div>