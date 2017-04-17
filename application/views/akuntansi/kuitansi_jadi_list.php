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
  <li role="presentation" class="<?php if(isset($tab1)){ if($tab1==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi'); ?>">GUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab2)){ if($tab2==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi_ls'); ?>">L3&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->ls_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->ls_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab3)){ if($tab3==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi_spm'); ?>">SPM non-kuitansi&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->spm_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->spm_jadi; ?></span></a></li>
</ul>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Kuitansi Jadi</h1>
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
					<th>STATUS</th>
					<th>AKSI</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($query->result() as $result){ ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo date("d/m/Y", strtotime($result->tanggal)); ?></td>
					<td><?php echo $result->no_bukti; ?></td>
					<td><?php echo $result->no_spm; ?></td>
					<td><?php echo $result->jenis; ?></td>
					<td><?php echo $result->kode_kegiatan; ?></td>
					<td><?php echo $result->unit_kerja; ?></td>
					<td><?php echo $result->uraian; ?></td>
					<td><?php echo $result->akun_debet; ?></td>
					<td><?php echo $result->akun_kredit; ?></td>
					<td><?php echo get_pengeluaran($result->id_kuitansi); ?></td>
					<td>
						<?php if($result->flag==1){ ?>
							<?php if($result->status=='revisi'){ ?>
							<button class="btn btn-xs btn-danger disabled"><span class="glyphicon glyphicon-repeat"></span> Revisi</button>
							<?php }else{ ?>
							<button class="btn btn-xs btn-default disabled">Proses verifikasi</button>
							<?php } ?>
						<?php }else if($result->flag==2){ ?>
						<button class="btn btn-xs btn-success disabled">Disetujui</button>
						<?php } ?>
					</td>
					<td>						
							<a href="<?php echo site_url('akuntansi/rsa_gup/jurnal/?spm='.urlencode($result->no_spm));?>"><button type="button" class="btn btn-sm btn-primary">Jurnal</button></a>
						<?php if($this->session->userdata('level')==1){ ?>
							<?php if($result->flag==1 AND $result->status=='revisi'){ ?>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/edit_kuitansi_jadi/'.$result->id_kuitansi_jadi.'/revisi'); ?>"><button type="button" class="btn btn-sm btn-success">Revisi</button></a>
							<?php }else{ ?>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-danger">Lihat</button></a>
							<?php } ?>
						<?php }else if($this->session->userdata('level')==2){ ?>
							<?php if($result->flag==1 AND ($result->status=='proses' OR $result->status=='direvisi')){ ?>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/evaluasi'); ?>"><button type="button" class="btn btn-sm btn-warning">Verifikasi</button></a>
							<?php }else{ ?>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-danger">Lihat</button></a>
							<?php } ?>
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
?>