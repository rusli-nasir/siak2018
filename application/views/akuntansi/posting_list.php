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
        $("#select-all").click(function(){
            $('.checkbox-posting').not(this).prop('checked', this.checked);
        });
	});
</script>
<!-- javascript -->

<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Posting</li>
	</ol>
</div><!--/.row-->
<hr/>
<ul class="nav nav-tabs">
  <li role="presentation" class="<?php if(isset($tab1)){ if($tab1==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting'); ?>">GUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab2)){ if($tab2==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting_ls'); ?>">L3&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->ls_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->ls_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab3)){ if($tab3==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting_spm'); ?>">SPM non-kuitansi&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->spm_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->spm_posting; ?></span></a></li>
</ul>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Kuitansi Jadi <?php if($this->session->userdata('kode_unit')!=null){ echo get_nama_unit($this->session->userdata('kode_unit')); } ?></h1>
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
	<?php if($this->session->userdata('level')!='1'){ ?>
	<div class="col-sm-4">	
		<a href="<?php echo site_url('akuntansi/kuitansi/pilih_unit'); ?>"><button type="button" class="btn btn-primary">Pilih Unit</button></a>
	</div>
	<?php } ?>
</div>
<br/>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped">
            <?php
                echo form_open('akuntansi/rest_kuitansi/posting_kuitansi_batch/',array("id"=>"form-posting"));
                echo form_close();
            ?>
			<thead>
				<tr>
					<th>NO</th>
					<th>TANGGAL</th>
					<th>NO.BUKTI</th>
					<th>NO. AKUN <br/><span style="color:blue;">KAS</span><br/>AKRUAL</th>
					<th>DEBET</th>
					<th>KREDIT</th>
					<th>STATUS</th>
					<th>AKSI</th>
					<th><input type="submit" class="btn btn-primary" value="Batch Post" form="form-posting"><input type="checkbox" id="select-all" form="form-posting">  Check All</th>
				</tr>
			</thead>
			<tbody>
                
				<?php foreach($query as $result){ ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo date("d/m/Y", strtotime($result->tanggal)); ?></td>
					<td><?php echo $result->no_bukti; ?></td>
					<td><?php echo '<b style="color:blue">'.$result->akun_debet.' - '.$result->nama_akun_debet.'<br/>'.$result->akun_kredit.' - '.$result->nama_akun_kredit.'</b><br/>'.$result->akun_debet_akrual.' - '.$result->nama_akun_debet_akrual.'<br/>'.$result->akun_kredit_akrual.' - '.$result->nama_akun_kredit_akrual; ?></td>
					<td><?php echo number_format($result->jumlah_debet).'<br/><br/>'.number_format($result->jumlah_debet); ?></td>
					<td><?php echo '<br/>'.number_format($result->jumlah_kredit).'<br/><br/>'.number_format($result->jumlah_kredit); ?></td>
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
							<a href="<?php echo site_url('akuntansi/rsa_gup/jurnal/?spm='.urlencode($result->no_spm));?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
						<?php if($this->session->userdata('level')==1){ ?>
							<?php if($result->flag==1 AND $result->status=='revisi'){ ?>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/edit_kuitansi_jadi/'.$result->id_kuitansi_jadi.'/revisi'); ?>"><button type="button" class="btn btn-sm btn-success">Revisi</button></a>
							<?php }else{ ?>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-danger">Detil</button></a>
							<?php } ?>
						<?php }else if($this->session->userdata('level')==2){ ?>
							
                            <a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-danger">Detil</button></a>

                           <!--  <a href="<?php echo site_url('akuntansi/rest_kuitansi/posting_kuitansi/'.$result->id_kuitansi_jadi); ?>"><button type="button" class="btn btn-sm btn-success">Posting</button></a> -->
							
						<?php }else if($this->session->userdata('level')==3){ ?>
<!-- 							<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-success">Posting</button></a> -->
						<?php } ?>
					</td>
                    <td><input type="checkbox" name="id_kuitansi_jadi[]" class="checkbox-posting" value="<?= $result->id_kuitansi_jadi; ?>" form="form-posting"></td>
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