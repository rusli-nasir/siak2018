<!-- javascript -->
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
		<li class="active">Penerimaan</li>
	</ol>
</div><!--/.row-->
<hr/>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Penerimaan</h1>
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-4">
		<form action="<?php echo site_url('akuntansi/penerimaan/index'); ?>" method="post">
			<div class="input-group">
				<span class="input-group-btn">
	        		<a href="<?php echo site_url('akuntansi/penerimaan/reset_search'); ?>"><button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-refresh"></span> Reset</button></a>
	      		</span>
	      		<input type="text" class="form-control" placeholder="No.bukti/No.SPM/Uraian" name="keyword_penerimaan" value="<?php if($this->session->userdata('keyword_penerimaan')) echo $this->session->userdata('keyword_penerimaan'); ?>">
	      		<span class="input-group-btn">
	        		<button class="btn btn-default" type="submit">Cari</button>
	      		</span>
	    	</div>
	    </form>
	</div>
	<div class="col-sm-8" align="right">
		<a href="<?php echo site_url('akuntansi/penerimaan/input_penerimaan'); ?>"><button type="button" class="btn btn-primary">Isi Penerimaan</button></a>
	</div>
</div>
<br/>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>NO</th>
					<th>TANGGAL</th>
					<th>NO.BUKTI</th>
					<th>UNIT</th>
					<th>URAIAN</th>
					<th>AKSI</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($query->result() as $result){ ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo date("d/m/Y", strtotime($result->tanggal)); ?></td>
					<td><?php echo $result->no_bukti; ?></td>
					<td>UNIVERSITAS</td>
					<td><?php echo $result->uraian; ?></td>
					<td>						
						<?php if($this->session->userdata('level')==1){ ?>
							<?php if($result->flag==1 AND $result->status=='revisi'){ ?>
								<a href="<?php echo site_url('akuntansi/penerimaan/edit_penerimaan/'.$result->id_kuitansi_jadi.'/revisi'); ?>"><button type="button" class="btn btn-sm btn-success">Revisi</button></a>
							<?php }else{ ?>
								<a href="<?php echo site_url('akuntansi/penerimaan/detail_penerimaan/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-danger">Lihat</button></a>
							<?php } ?>
						<?php }else if($this->session->userdata('level')==2){ ?>
							<?php if($result->flag==1 AND ($result->status=='proses' OR $result->status=='direvisi')){ ?>
								<a href="<?php echo site_url('akuntansi/penerimaan/detail_penerimaan/'.$result->id_kuitansi_jadi.'/evaluasi'); ?>"><button type="button" class="btn btn-sm btn-warning">Verifikasi</button></a>
							<?php }else{ ?>
								<a href="<?php echo site_url('akuntansi/penerimaan/detail_penerimaan/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-danger">Lihat</button></a>
							<?php } ?>
						<?php }else if($this->session->userdata('level')==3 or $this->session->userdata('level')==8){ ?>
							<a href="<?php echo site_url('akuntansi/penerimaan/edit_penerimaan/'.$result->id_kuitansi_jadi); ?>"><button type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-cog"></span> Edit</button></a>
						<?php } ?>
					</td>
				</tr>
				<?php $no++; } ?>
			</tbody>
		</table>
		<center><?php echo $halaman; ?></center>
	</div>
</div>

<?php
function get_pengeluaran($id_kuitansi){
	$ci =& get_instance();

	$query = "SELECT SUM(volume*harga_satuan) AS pengeluaran FROM rsa_kuitansi_detail WHERE id_kuitansi='$id_kuitansi'";
	$q = $ci->db->query($query)->result();
	foreach($q as $result){
		return number_format($result->pengeluaran);
	}
}

function get_unit($unit){
	$ci =& get_instance();
	$ci->db2 = $ci->load->database('rba', true);

	$query = "SELECT * FROM unit WHERE kode_unit='$unit'";
	$q = $ci->db2->query($query)->result();
	foreach($q as $result){
		return $result->alias;
	}
}
?>