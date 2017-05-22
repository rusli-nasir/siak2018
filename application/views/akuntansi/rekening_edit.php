<style type="text/css">
.form-control{border:1px solid #bdbdbd;}
</style>
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
		<a href="<?php echo site_url('akuntansi/rekening/index'); ?>"><button type="button" class="btn btn-warning">Kembali</button></a>
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-8">
		<?php
		if($this->input->get('balasan')==1){
			echo '<div class="alert alert-success">Berhasil mengubah data</div>';
		}else if($this->input->get('balasan')==2){
			echo '<div class="alert alert-danger">Gagal memasukan data</div>';
		}
		?>
		<form class="form-horizontal" action="<?php echo site_url('akuntansi/rekening/edit_proses/'.$id); ?>" method="post">
			<div class="form-group">
				<label class="control-label col-sm-3">Unit</label>
				<div class="col-sm-5">
					<select class="form-control" name="kode_unit">
						<option value="all">all - tampil pada semua unit</option>
						<option value="none">none - tidak tampil pada semua unit</option>
						<?php foreach($query_unit->result() as $result){ ?>
							<option value="<?php echo $result->kode_unit; ?>" <?php if($query['kode_unit']==$result->kode_unit) echo 'selected'; ?>><?php echo $result->kode_unit.' - '.$result->nama_unit; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">Kode Rekening</label>
				<div class="col-sm-4">
					<input type="text" name="kode_rekening" value="<?php echo $query['akun_6']; ?>" maxlength="50" class="form-control" placeholder="111101" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">Uraian</label>
				<div class="col-sm-9">
					<input type="text" name="uraian" value="<?php echo $query['nama']; ?>" maxlength="255" class="form-control" placeholder="Kas Bank Mandiri Operasional BLU No Rek. 1360020080005" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3"></label>
				<div class="col-sm-9">
					<button type="submit" class="btn btn-primary" onclick="return confirm('Simpan Data?')">Submit</button>
				</div>
			</div>
		</form>
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