<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">
<style type="text/css">
.form-control{border:1px solid #bdbdbd;}
</style>
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Saldo</li>
	</ol>
</div><!--/.row-->
<hr/>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header" style="margin-top:-10px;">Saldo</h1>
	</div>
	<div class="col-sm-3" align="right">
		<a href="<?php echo site_url('akuntansi/saldo/index'); ?>"><button type="button" class="btn btn-warning">Kembali</button></a>
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-12">
		<?php
		if($this->input->get('balasan')==1){
			echo '<div class="alert alert-success">Berhasil memasukan data</div>';
		}else if($this->input->get('balasan')==2){
			echo '<div class="alert alert-danger">Gagal memasukan data</div>';
		}else if($this->input->get('balasan')==3){
			echo '<div class="alert alert-warning">Saldo untuk akun tersebut sudah ada</div>';
		}
		?>
		<form class="form-horizontal" action="<?php echo site_url('akuntansi/saldo/tambah_proses'); ?>" method="post" onsubmit="return confirm('Simpan Data?')">
			<div class="form-group">
				<label class="control-label col-sm-3">Kode Akun</label>
				<div class="col-sm-8">
					<select name="kode_akun" class="form-control" id="selectizemepleaseT_T">
						<?php foreach($query_1->result() as $result){ ?>
						<option value="<?php echo $result->akun_6; ?>"><?php echo $result->akun_6.' - '.$result->nama; ?></option>
						<?php } ?>
						<?php foreach($query_2->result() as $result){ ?>
						<option value="<?php echo $result->akun_6; ?>"><?php echo $result->akun_6.' - '.$result->nama; ?></option>
						<?php } ?>
						<?php foreach($query_3->result() as $result){ ?>
						<option value="<?php echo $result->akun_6; ?>"><?php echo $result->akun_6.' - '.$result->nama; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">Tahun</label>
				<div class="col-sm-2">
					<select class="form-control" name="tahun">
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Saldo Debet
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="control-label col-sm-3">Saldo Awal</label>
								<div class="col-sm-6">
									<input type="text" name="saldo_awal" maxlength="30" class="form-control" placeholder="4500000" pattern="[0-9]{1,30}" required>
									Isi dengan angka saja tanpa spasi, ex : 12500000
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Saldo Kredit
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="control-label col-sm-3">Saldo Awal</label>
								<div class="col-sm-6">
									<input type="text" name="saldo_kredit_awal" maxlength="30" class="form-control" placeholder="4500000" pattern="[0-9]{1,30}" required>
									Isi dengan angka saja tanpa spasi, ex : 12500000
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<center>
					<button type="submit" class="btn btn-primary">Submit</button>
			</center>
		</form>
	</div>
</div>
<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>
<script>
    $("#selectizemepleaseT_T").selectize()
</script>

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