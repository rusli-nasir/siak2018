<style type="text/css">
table {
        width: 100%;
    }

thead, tbody, tr, td, th { display: block; }

tr:after {
    content: ' ';
    display: block;
    visibility: hidden;
    clear: both;
}

thead th {
    height: 30px;

    /*text-align: left;*/
}

tbody {
    height: 320px;
    overflow-y: auto;
}

thead {
    /* fallback */
}


tbody td, thead th {
    width: 8%;
    float: left;
}
</style>
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
		<li class="active">Kuitansi</li>
	</ol>
</div><!--/.row-->
<hr/>
<ul class="nav nav-tabs">
  <li role="presentation" class="<?php if(isset($tab1)){ if($tab1==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index'); ?>">GUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab2)){ if($tab2==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_ls'); ?>">L3&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->ls ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->ls; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab3)){ if($tab3==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_spm'); ?>">SPM non-kuitansi&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->spm ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->spm; ?></span></a></li>
</ul>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Kuitansi <?php if($this->session->userdata('kode_unit')!=null){ echo get_nama_unit($this->session->userdata('kode_unit')); } ?></h1>
		<div class="row">
			<div class="col-sm-4">
				<?php echo 'Total Kuitansi Belum di Jurnal: <span style="color:red">'.$kuitansi_non_jadi.'</span>'; ?>
			</div>
			<div class="col-sm-4">
				<?php echo 'Total Kuitansi Sudah di Jurnal: <span style="color:green">'.$kuitansi_jadi.'</span>'; ?>
			</div>
		</div>
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-4">
		<?php if(isset($tab1)){ ?>
		<form action="<?php echo site_url('akuntansi/kuitansi/index'); ?>" method="post">
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
	    <?php }else{ ?>
	    <form action="<?php echo site_url('akuntansi/kuitansi/index_ls'); ?>" method="post">
			<div class="input-group">
				<span class="input-group-btn">
	        		<a href="<?php echo site_url('akuntansi/kuitansi/reset_search_ls'); ?>"><button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-refresh"></span> Reset</button></a>
	      		</span>
	      		<input type="text" class="form-control" placeholder="No.bukti/No.SPM/Uraian" name="keyword_ls" value="<?php if($this->session->userdata('keyword_ls')) echo $this->session->userdata('keyword_ls'); ?>">
	      		<span class="input-group-btn">
	        		<button class="btn btn-default" type="submit">Cari</button>
	      		</span>
	    	</div>
	    </form>
	    <?php } ?>
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
					<th>NO.SPM</th>
					<th>JENIS</th>
					<th>KODE KEGIATAN</th>
					<th>UNIT</th>
					<th>URAIAN</th>
					<th>AKUN DEBET</th>
					<th>AKUN KREDIT</th>
					<th>JUMLAH</th>
					<th>AKSI</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($query->result() as $result){ ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo date("d/m/Y", strtotime($result->tgl_kuitansi)); ?></td>
					<td><?php echo $result->no_bukti; ?></td>
					<td><?php echo $result->str_nomor_trx_spm; ?></td>
					<td><?php echo $result->jenis; ?></td>
					<td><?php echo substr($result->kode_usulan_belanja,6,2); ?></td>
					<td><?php echo get_unit($result->kode_unit); ?></td>
					<td><?php echo $result->uraian; ?></td>
					<td><?php echo $result->kode_akun; ?></td>
					<td><?php echo '?'; ?></td>
					<td><?php echo get_pengeluaran($result->id_kuitansi); ?></td>
					<td>						
							<a href="<?php echo site_url('akuntansi/rsa_gup/jurnal/?spm='.urlencode($result->str_nomor_trx_spm));?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
						<?php if($this->session->userdata('level')==1){ ?>
							<?php if(isset($tab1)){ ?>
							<a href="<?php echo site_url('akuntansi/jurnal_rsa/input_jurnal/'.$result->id_kuitansi).'/GP'; ?>"><button type="button" class="btn btn-sm btn-danger">Isi Jurnal</button></a>
							<?php }else{ ?>
							<a href="<?php echo site_url('akuntansi/jurnal_rsa/input_jurnal/'.$result->id_kuitansi).'/L3'; ?>"><button type="button" class="btn btn-sm btn-danger">Isi Jurnal</button></a>
							<?php } ?>
						<?php }else if($this->session->userdata('level')==2){ ?>
							<a href="#"><button type="button" class="btn btn-sm btn-warning">Verifikasi</button></a>
						<?php }else if($this->session->userdata('level')==3){ ?>
							<a href="#"><button type="button" class="btn btn-sm btn-success">Posting</button></a>
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