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
		<li class="active">SPM Non-Kuitansi</li>
	</ol>
</div><!--/.row-->
<hr/>
<ul class="nav nav-tabs">
  <li role="presentation" class="<?php if(isset($tab1)){ if($tab1==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/UP/1'); ?>">UP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->up_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->up_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab2)){ if($tab2==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/PUP/1'); ?>">PUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->pup_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->pup_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab3)){ if($tab3==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/GP/1'); ?>">GUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_posting; ?></span></a></li>
    <li role="presentation" class="<?php if(isset($tab9)){ if($tab9==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/GUP/1'); ?>">GU&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gu_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gu_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab4)){ if($tab4==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/GP_NIHIL/1'); ?>">GUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_nihil_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_nihil_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab5)){ if($tab5==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/TUP/1'); ?>">TUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab6)){ if($tab6==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/TUP_NIHIL/1'); ?>">TUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_nihil_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_nihil_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab7)){ if($tab7==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting_ls'); ?>">LS- 3&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->ls_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->ls_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab8)){ if($tab8==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting_spm'); ?>">LS - PG&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->spm_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->spm_posting; ?></span></a></li>
</ul>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">SPM Non-Kuitansi</h1>
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
		<table class="table table-striped">
            <?php
                echo form_open('akuntansi/rest_kuitansi/posting_kuitansi_batch/',array("id"=>"form-posting"));
                echo form_close();
            
                echo form_open('akuntansi/rest_kuitansi/posting_kuitansi_batch/',array("id"=>"form-posting-all"));
                foreach($all_query as $r)
                    echo "<input style='display:none' type='checkbox' name='id_kuitansi_jadi[]' value='{$r->id_kuitansi_jadi}' checked=''/>";
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
					<th><input type="submit" class="btn btn-primary" value="Batch Post" form="form-posting">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-warning" value="Post Semua Data" form="form-posting-all"><br><div class="checkbox"><label><input type="checkbox" id="select-all" form="form-posting">  Check All</label></th>
				</tr>
			</thead>
			<tbody>
                
				<?php foreach($query as $result){ ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo date("d/m/Y", strtotime($result->tanggal)); ?></td>
					<td><?php echo $result->no_bukti; ?></td>
					<td><?php echo '<b style="color:blue">'.$result->akun_debet.' - '.$result->nama_akun_debet.'<br/>'.$result->akun_kredit.' - '.$result->nama_akun_kredit.'</b><br/>'.$result->akun_debet_akrual.' - '.$result->nama_akun_debet_akrual.'<br/>'.$result->akun_kredit_akrual.' - '.$result->nama_akun_kredit_akrual; ?></td>
					<td><?php echo $result->jumlah_debet.'<br/><br/>'.$result->jumlah_debet; ?></td>
					<td><?php echo '<br/>'.$result->jumlah_kredit.'<br/><br/>'.$result->jumlah_kredit; ?></td>
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
							<a href="<?php echo site_url('akuntansi/rsa_gup/lspg/id/'.get_id_spm($result->no_spm));?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
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

function get_id_spm($no_spm){
    $ci =& get_instance();

	$query = "SELECT id_spmls FROM kepeg_tr_spmls WHERE nomor='$no_spm'";
	$q = $ci->db->query($query)->row();
	return $q->id_spmls;
}
?>