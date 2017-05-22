<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Rekening</li>
	</ol>
</div><!--/.row-->
<hr/>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header" style="margin-top:-10px;">Rekening</h1>
	</div>
	<div class="col-sm-3" align="right">
		<a href="<?php echo site_url('akuntansi/rekening/tambah'); ?>"><button type="button" class="btn btn-primary">Tambah Rekening</button></a>
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-12">
		<?php
		if($this->input->get('balasan')==1){
			echo '<div class="alert alert-success">Berhasil memasukan data</div>';
		}else if($this->input->get('balasan')==3){
			echo '<div class="alert alert-success">Berhasil menghapus data</div>';
		}else if($this->input->get('balasan')==4){
			echo '<div class="alert alert-danger">Gagal menghapus data</div>';
		}
		?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Kode Rekening</th>
					<th>Uraian</th>
					<th>Unit</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($query->result() as $result){ ?>
				<tr>
					<td><?php echo $result->akun_6; ?></td>
					<td><?php echo $result->nama; ?></td>
					<td>
						<?php 
						if($result->kode_unit=='all'){
							echo 'all';
						}else if($result->kode_unit=='none'){
							echo 'none';
						}else{
							echo get_nama_unit($result->kode_unit); 
						}
						?>
					</td>
					<td>						
						<a href="<?php echo site_url('akuntansi/rekening/edit/'.$result->id_akuntansi_aset_6); ?>"><button type="button" class="btn btn-sm btn-default">Edit</button></a>
						<a href="<?php echo site_url('akuntansi/rekening/delete/'.$result->id_akuntansi_aset_6); ?>" onclick="return confirm('Hapus rekening <?php echo $result->akun_6.' - '.$result->nama; ?>?')"><button type="button" class="btn btn-sm btn-danger">Delete</button></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php
function get_unit($unit){
	$ci =& get_instance();
	$ci->db2 = $ci->load->database('rba', true);

	$query = "SELECT * FROM unit WHERE kode_unit='$unit'";
	$q = $ci->db2->query($query)->result();
	foreach($q as $result){
		return $result->alias;
	}
}
function get_nama_unit($unit){
	$ci =& get_instance();
	$ci->db2 = $ci->load->database('rba', true);

	$query = "SELECT * FROM unit WHERE kode_unit='$unit'";
	$q = $ci->db2->query($query)->result();
	foreach($q as $result){
		return $result->nama_unit;
	}
}
?>