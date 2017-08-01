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
		<li class="active">Memorial</li>
	</ol>
</div><!--/.row-->
<hr/>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Memorial</h1>
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-4">
		<form action="#" method="post">
			<div class="input-group">
				<span class="input-group-btn">
	        		<a href="<?php echo site_url('akuntansi/kuitansi/reset_search'); ?>"><button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-refresh"></span> Reset</button></a>
	      		</span>
	      		<input type="text" class="form-control" placeholder="No.bukti/No.SPM/Uraian" name="keyword" value="<?php if($this->session->userdata('keyword')) echo $this->session->userdata('keyword'); ?>">
	      		<span class="input-group-btn">
	        		<button class="btn btn-default" type="submit">Cari</button>
	      		</span>
	    	</div>
	    </form>
	</div>
	<div class="col-sm-8" align="right">
		<a href="<?php echo site_url('akuntansi/memorial/input_memorial'); ?>"><button type="button" class="btn btn-primary">Isi Memorial</button></a>
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
					<th>JENIS</th>
					<th>KODE KEGIATAN</th>
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
					<td><?php echo $result->jenis; ?></td>
					<td><?php echo $result->kode_kegiatan; ?></td>
					<td><?php echo get_unit($result->unit_kerja); ?></td>
					<td><?php echo $result->uraian; ?></td>
					<td>						
						<?php if($this->session->userdata('level')==2){ ?>
							<?php if($result->flag==1 AND ($result->status=='proses' OR $result->status=='direvisi')){ ?>
								<a href="<?php echo site_url('akuntansi/memorial/detail_memorial/'.$result->id_kuitansi_jadi.'/evaluasi'); ?>"><button type="button" class="btn btn-sm btn-warning">Verifikasi</button></a>
							<?php }else{ ?>
								<a href="<?php echo site_url('akuntansi/memorial/detail_memorial/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-danger">Lihat</button></a>
							<?php } ?>
						<?php }else if($this->session->userdata('level')==3 OR $this->session->userdata('level')==1 OR $this->session->userdata('level')==5 OR $this->session->userdata('level')==8){ ?>
							<a href="<?php echo site_url('akuntansi/memorial/edit_memorial/'.$result->id_kuitansi_jadi); ?>"><button type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-cog"></span> Edit</button></a>
							<a href="<?php echo site_url('akuntansi/memorial/print_memorial/'.$result->id_kuitansi_jadi); ?>" target="_blank"><button type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-cog"></span> Print</button></a>
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