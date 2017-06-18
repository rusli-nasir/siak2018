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
		<li class="active">SPM Non-Kuitansi</li>
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
		<h1 class="page-header">SPM Non-Kuitansi</h1>
		<div class="row">
			<div class="col-sm-4">
				<div class="box-t">
					<?php echo 'Total SPM Diverifikasi: <br/><span style="color:green;font-size:16pt;">'.$kuitansi_ok.'</span>'; ?>
				</div>			
			</div>
			<div class="col-sm-4">
				<div class="box-t">
					<?php echo 'Total SPM Direvisi: <br/><span style="color:orange;font-size:16pt;">'.$kuitansi_revisi.'</span>'; ?>
				</div>				
			</div>
			<div class="col-sm-4">
				<div class="box-t">
					<?php echo 'Total SPM di Verifikasi: <br/><span style="color:#000;font-size:16pt;">'.$kuitansi_pasif.'</span>'; ?>
				</div>
			</div>
		</div>	
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-4">
		<form action="<?php echo site_url('akuntansi/kuitansi/jadi_spm'); ?>" method="post">
			<div class="input-group">
				<span class="input-group-btn">
	        		<a href="<?php echo site_url('akuntansi/kuitansi/reset_search_jadi_spm'); ?>"><button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-refresh"></span> Reset</button></a>
	      		</span>
	      		<input type="text" class="form-control" placeholder="No.SPM/Uraian" name="keyword_spm_jadi" value="<?php if($this->session->userdata('keyword_spm_jadi')) echo $this->session->userdata('keyword_spm_jadi'); ?>">
	      		<span class="input-group-btn">
	        		<button class="btn btn-default" type="submit">Cari</button>
	      		</span>
	    	</div>
	    </form>
	</div>
</div>
<br/>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped" style="table-layout:fixed">
			<thead>
				<tr>
					<th width="5%">NO</th>
					<th>TANGGAL</th>
					<th>NO.SPM</th>
					<th width="20%">KODE KEGIATAN</th>
					<th>UNIT</th>
					<th>AKUN DEBET</th>
					<th>AKUN KREDIT</th>
					<th>JUMLAH</th>
					<th>STATUS</th>
					<th>AKSI</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($query->result() as $result){ ?>
                <?php 
                    if($this->session->userdata('level') == 2){
                        if(!($result->flag==1 && ($result->status=="direvisi" || $result->status=="proses"))) continue;
                    }
                ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo date("d/m/Y", strtotime($result->tanggal)); ?></td>
					<td><?php echo $result->no_spm; ?></td>
					<td><?php echo str_replace(',', '<br/>,', $result->kode_kegiatan); ?></td>
					<td>-</td>
					<td><?php echo $result->akun_debet; ?></td>
					<td><?php echo $result->akun_kredit; ?></td>
					<td><?php echo number_format($result->jumlah_debet); ?></td>
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
							<a href="#" target="_blank"><button type="button" class="btn btn-sm btn-primary">Jurnal</button></a>
						<?php if($this->session->userdata('level')==1){ ?>
							<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-danger">Lihat</button></a>
						<?php }else if($this->session->userdata('level')==2){ ?>
							<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/evaluasi'); ?>""><button type="button" class="btn btn-sm btn-warning">Verifikasi</button></a>
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