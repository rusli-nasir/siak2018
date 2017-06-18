<style type="text/css">
table {
        width:1900px;
    }

thead, tbody, tr, td, th { display: block; }

tr:after {
    content: ' ';
    display: block;
    visibility: hidden;
    clear: both;
}

thead th {
    height: 80px !important;

    /*text-align: left;*/
}

tbody {
    height: 320px;
    overflow-y: auto;
}

thead {
	width:1900px;
    overflow-x: auto;
}


tbody td, thead th {
    width: 110px;
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
		<li class="active">Kuitansi Jadi</li>
	</ol>
</div><!--/.row-->
<hr/>
<ul class="nav nav-tabs">
  <li role="presentation" class="<?php if(isset($tab1)){ if($tab1==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/1/UP'); ?>">UP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->up_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->up_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab2)){ if($tab2==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/1/PUP'); ?>">PUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->pup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->pup_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab3)){ if($tab3==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/1/GP'); ?>">GUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_jadi; ?></span></a></li>
    <li role="presentation" class="<?php if(isset($tab9)){ if($tab9==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/1/GUP'); ?>">GU&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gu_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gu_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab4)){ if($tab4==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/1/GP_NIHIL'); ?>">GUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_nihil_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab5)){ if($tab5==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/1/TUP'); ?>">TUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab6)){ if($tab6==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/1/TUP_NIHIL'); ?>">TUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_nihil_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_nihil_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab7)){ if($tab7==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi_ls'); ?>">LS- 3&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->ls_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->ls_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab8)){ if($tab8==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi_spm'); ?>">LS - PG&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->spm_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->spm_jadi; ?></span></a></li>
</ul>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Kuitansi Jadi <?php if($this->session->userdata('kode_unit')!=null){ echo get_nama_unit($this->session->userdata('kode_unit')); } ?></h1>
		<div class="row">
			<div class="col-sm-4">
				<div class="box-t">
					<?php echo 'Total Kuitansi Disetujui: <br/><span style="color:green;font-size:16pt;">'.$kuitansi_ok.'</span>'; ?>
				</div>			
			</div>
			<div class="col-sm-4">
				<div class="box-t">
					<?php echo 'Total Kuitansi Direvisi: <br/><span style="color:orange;font-size:16pt;">'.$kuitansi_revisi.'</span>'; ?>
				</div>				
			</div>
			<div class="col-sm-4">
				<div class="box-t">
					<?php echo 'Total Kuitansi di Verifikasi: <br/><span style="color:#000;font-size:16pt;">'.$kuitansi_pasif.'</span>'; ?>
				</div>
			</div>
		</div>		
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-4">
		<?php if(isset($tab1)){ ?>
		<form action="<?php echo site_url('akuntansi/kuitansi/jadi'); ?>" method="post">
			<div class="input-group">
				<span class="input-group-btn">
	        		<a href="<?php echo site_url('akuntansi/kuitansi/reset_search_jadi'); ?>"><button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-refresh"></span> Reset</button></a>
	      		</span>
	      		<input type="text" class="form-control" placeholder="No.bukti/No.SPM/Uraian" name="keyword_jadi" value="<?php if($this->session->userdata('keyword_jadi')) echo $this->session->userdata('keyword_jadi'); ?>">
	      		<span class="input-group-btn">
	        		<button class="btn btn-default" type="submit">Cari</button>
	      		</span>
	    	</div>
	    </form>
	    <?php }else{ ?>
	    <form action="<?php echo site_url('akuntansi/kuitansi/index_ls'); ?>" method="post">
			<div class="input-group">
				<span class="input-group-btn">
	        		<a href="<?php echo site_url('akuntansi/kuitansi/reset_search_jadi_ls'); ?>"><button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-refresh"></span> Reset</button></a>
	      		</span>
	      		<input type="text" class="form-control" placeholder="No.bukti/No.SPM/Uraian" name="keyword_ls" value="<?php if($this->session->userdata('keyword_ls')) echo $this->session->userdata('keyword_ls'); ?>">
	      		<span class="input-group-btn">
	        		<button class="btn btn-default" type="submit">Cari</button>
	      		</span>
	    	</div>
	    </form>
	    <?php } ?>
	</div>
	<?php if($this->session->userdata('level')=='2' AND $this->session->userdata('username')=='verifikator'){ ?>
	<div class="col-sm-4">	
		<a href="<?php echo site_url('akuntansi/kuitansi/pilih_unit'); ?>"><button type="button" class="btn btn-primary">Pilih Unit</button></a>
	</div>
	<?php } ?>
</div>
<br/>
<div class="row">
	<div class="col-sm-12">
		<table class="table">
			<thead>
				<tr>
					<th style="width:2% !important;">NO</th>
					<th style="width:110px;">TANGGAL</th>
					<th style="width:110px;">NO.SPM</th>
					<th style="width:70px;">JENIS</th>
					<th style="width:70px;">KODE KEGIATAN</th>
					<th style="width:70px;">UNIT</th>
					<th style="width:110px;">URAIAN</th>
					<th style="width:500px !important" nowrap>NO. AKUN <br/><span style="color:blue;">KAS</span><br/>AKRUAL</th>
					<th style="width:110px;">DEBET</th>
					<th style="width:110px;">KREDIT</th>
					<th style="width:250px">PAJAK</th>
					<th style="width:110px;">STATUS</th>
					<th style="width:110px;">AKSI</th>
				</tr>
			</thead>
			<tbody>
				
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

function get_tabel_by_jenis($jenis)
{
	if ($jenis == 'GP') {
		return 'rsa_kuitansi_detail_pajak';
	}elseif ($jenis == 'L3') {
		return 'rsa_kuitansi_detail_pajak_lsphk3';
	}
}
function get_detail_pajak($no_bukti,$jenis)
{
	$ci =& get_instance();
	$hasil = $ci->db->get_where(get_tabel_by_jenis($jenis),array('no_bukti' => $no_bukti))->result_array();
	
	$data = array();

	foreach ($hasil as $entry) {
		$detail = $ci->db->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row_array();
		$data[] = array_merge($entry,$detail);
	}

	return $data;
}
?>