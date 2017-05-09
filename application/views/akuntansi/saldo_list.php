<script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<script type="text/javascript">
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>

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
		<a href="<?php echo site_url('akuntansi/saldo/tambah'); ?>"><button type="button" class="btn btn-primary">Tambah Saldo</button></a>
	</div>
</div><!--/.row-->
<ul class="nav nav-tabs">
  <li role="presentation" class="<?php if(isset($tab1)){ if($tab1==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/saldo/index/1'); ?>">1</a></li>
  <li role="presentation" class="<?php if(isset($tab2)){ if($tab2==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/saldo/index/2'); ?>">2</a></li>
  <li role="presentation" class="<?php if(isset($tab3)){ if($tab3==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/saldo/index/3'); ?>">3</a></li>
</ul>
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
		<table class="table table-striped" id="myTable">
			<thead>
				<tr>
					<th>Tahun</th>
					<th>Kode Akun</th>
					<th>Nama</th>
					<th>Saldo Awal</th>
					<th>Saldo Sekarang</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($query->result() as $result){ ?>
				<tr>
					<td><?php echo $result->tahun; ?></td>
					<td><?php echo $result->akun; ?></td>
					<td><?php echo get_nama($result->akun); ?></td>
					<td><?php echo number_format($result->saldo_awal); ?></td>
					<td><?php echo number_format($result->saldo_sekarang); ?></td>
					<td>						
						<a href="<?php echo site_url('akuntansi/saldo/edit/'.$result->id); ?>"><button type="button" class="btn btn-sm btn-default">Edit</button></a>
						<a href="<?php echo site_url('akuntansi/saldo/delete/'.$result->id); ?>" onclick="return confirm('Hapus saldo akun <?php echo $result->akun; ?>?')"><button type="button" class="btn btn-sm btn-danger">Delete</button></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php
function get_nama($akun){
	$ci =& get_instance();
	$ci->db2 = $ci->load->database('default', true);

	if(substr($akun, 0, 1)=='1'){
		$table = 'akuntansi_aset_6';
	}else if(substr($akun, 0, 1)=='2'){
		$table = 'akuntansi_hutang_6';
	}else if(substr($akun, 0, 1)=='3'){
		$table = 'akuntansi_aset_bersih_6';
	}
	$query = "SELECT * FROM $table WHERE akun_6='$akun'";
	$q = $ci->db2->query($query)->result();
	foreach($q as $result){
		return $result->nama;
	}
}
?>