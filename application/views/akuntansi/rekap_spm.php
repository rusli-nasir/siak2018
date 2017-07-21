<!-- javascript -->
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
<!-- <form class="form-horizontal" action="<?php echo site_url('akuntansi/laporan/rekap_spm'); ?>" method="post">
	<div class="form-group">
	    <div class="col-md-6">
	    	<input class="form-control" type="text" name="no_spm" placeholder="no_spm" required>
	    </div>
	    <div class="col-md-1">
	    	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Cari</button>
	    </div>
	</div>
</form> -->
<ul class="nav nav-tabs">
  <li class="<?php if($tipe=='UP') echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_spm/UP/'); ?>">UP</a></li>
  <li class="<?php if($tipe=='PUP') echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_spm/PUP/'); ?>">PUP</a></li>
  <li class="<?php if($tipe=='GU') echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_spm/GU/'); ?>">GUP</a></li>
  <li class="<?php if($tipe=='TUP') echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_spm/TUP/'); ?>">TUP</a></li>
  <li class="<?php if($tipe=='LSPHK3') echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_spm/LSPHK3/'); ?>">LSPHK3</a></li>
  <li class="<?php if($tipe=='LSPG') echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_spm/LSPG/'); ?>">LSPG</a></li>
</ul>
<div class="row">
	<div class="col-lg-12">
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
				<?php if($query->num_rows() > 0){
					foreach($query->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td><?php echo $tipe; ?></td>
					<?php if($tipe=='LSPG'){ ?>
					<td><?php echo date("d-m-Y, H:i:s", strtotime($result->tanggal)); ?></td>
					<td><?php echo $result->nomor; ?></td>
					<?php }else{ ?>
					<td><?php echo date("d-m-Y, H:i:s", strtotime($result->tgl_spm)); ?></td>
					<td><?php echo $result->str_nomor_trx; ?></td>
					<?php } ?>				
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php echo number_format($result->jumlah_bayar); ?></td>
				</tr>
				<?php $no++; }
				} ?>
			</tbody>
		</table>
	</div>
</div>