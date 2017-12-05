<!-- javascript -->
<?php 
$tahun = gmdate('Y');
 ?>

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
  <li role="presentation" class="<?php if(isset($tab1)){ if($tab1==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/UP/1'); ?>">UP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->up_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->up_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab2)){ if($tab2==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/PUP/1'); ?>">PUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->pup_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->pup_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab3)){ if($tab3==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/GP/1'); ?>">GUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_posting; ?></span></a></li>
    <li role="presentation" class="<?php if(isset($tab9)){ if($tab9==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/GUP/1'); ?>">GU&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gu_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gu_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab4)){ if($tab4==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/GP_NIHIL/1'); ?>">GUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_nihil_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_nihil_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab5)){ if($tab5==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/TUP/1'); ?>">TUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab6)){ if($tab6==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/TUP_NIHIL/1'); ?>">TUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_nihil_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_nihil_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab11)){ if($tab11==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/LK'); ?>">LS-K&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->lk_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->lk_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab12)){ if($tab12==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/LN'); ?>">LS- NK&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->ln_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->ln_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab8)){ if($tab8==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting_spm'); ?>">LS - PG&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->spm_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->spm_posting; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab10)){ if($tab10==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting/TUP_PENGEMBALIAN/1'); ?>">TUP Peng.&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_pengembalian_posting ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_pengembalian_posting; ?></span></a></li>
</ul>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Posting Kuitansi Jadi <?php if($this->session->userdata('kode_unit')!=null){ echo get_nama_unit($this->session->userdata('kode_unit')); } ?></h1>
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-4">
		<form method="post">
			<div class="input-group">
				<span class="input-group-btn">
	        		<a href="<?php echo site_url('akuntansi/kuitansi/reset_search_jadi'); ?>"><button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-refresh"></span> Reset</button></a>
	      		</span>
	      		<input type="text" class="form-control" placeholder="No.bukti/No.SPM/Uraian" name="keyword_jadi_<?php echo $jenis; ?>_posting" value="<?php if($this->session->userdata('keyword_jadi_'.$jenis.'_posting')) echo $this->session->userdata('keyword_jadi_'.$jenis.'_posting'); ?>">
	      		<span class="input-group-btn">
	        		<button class="btn btn-default" type="submit">Cari</button>
	      		</span>
	    	</div>
	    </form>
	</div>
	<div class="col-sm-4">
		<?php if(isset($tab3) or isset($tab6) or isset($tab11) or isset($tab12)){ ?>
		<form action="<?php echo site_url('akuntansi/kuitansi/posting/'.$jenis); ?>" method="post">
			<div class="input-group">
	      		<select name="keyword_jadi_<?php echo $jenis ?>_posting" class="form-control">
					<option value="">Tampil Semua SPM</option>
					<?php 
					foreach($query_spm->result_array() as $result){ 
					?>
					<option value="<?php echo $result['no_spm']; ?>"
						<?php 
						if($this->session->userdata('keyword_jadi_'.$jenis.'_posting')){
							if($result['no_spm']==$this->session->userdata('keyword_jadi_'.$jenis.'_posting')){
								echo 'selected';
							} 
						}
						?>
						><?php echo $result['no_spm']; ?></option>
					<?php } ?>
				</select>
	      		<span class="input-group-btn">
	        		<button class="btn btn-default" type="submit">Filter</button>
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
					<th>NO.SPM</th>
					<th>NO. AKUN <br/><span style="color:blue;">KAS</span><br/>AKRUAL</th>
					<th>DEBET</th>
					<th>KREDIT</th>
					<th>STATUS</th>
					<th>AKSI</th>
					<th><input type="submit" class="btn btn-primary" value="Batch Post" form="form-posting">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-warning" value="Post Semua Data" form="form-posting-all"><br><div class="checkbox"><label><input type="checkbox" id="select-all" form="form-posting">  Check All</label></div></th>
				</tr>
			</thead>
			<tbody>
                
				<?php foreach($query as $result){ ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo date("d/m/Y", strtotime($result->tanggal)); ?></td>
					<td><?php echo $result->no_bukti; ?></td>
					<td><?php echo $result->no_spm; ?></td>
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
							<?php if(isset($tab1)){ ?>
								<a href="<?php $r=up_get_details($result->no_spm); echo site_url('akuntansi/rsa_gup/up/'.$r->kode_unit_subunit.'/'.explode('/', $result->no_spm)[4]);?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							<?php } else if(isset($tab5)){ ?>
								<a href="<?php echo site_url('akuntansi/rsa_tambah_tup/spm_tambah_tup_lihat_99/'.urlencode(base64_encode($result->no_spm))).'/'.$this->session->userdata('kode_unit').'/'.$tahun?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							<?php } else if(isset($tab6) or isset($tab10)){ ?>
								<a href="<?php echo site_url('akuntansi/rsa_tup/spm_tup_lihat_99/'.urlencode(base64_encode($result->no_spm))).'/'.$this->session->userdata('kode_unit').'/'.$tahun.'/'.$result->id_kuitansi;?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							<?php } else if(isset($tab11)){ ?>
								<a href="<?php echo site_url('akuntansi/rsa_lsk/spm_lsk_lihat_99/'.urlencode(base64_encode($result->no_spp))).'/'.$this->session->userdata('kode_unit').'/'.$tahun.'/'.$result->id_kuitansi;?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							<?php } else if(isset($tab12)){ ?>
								<a href="<?php echo site_url('akuntansi/rsa_lsnk/spm_lsnk_lihat_99/'.urlencode(base64_encode($result->no_spp))).'/'.$this->session->userdata('kode_unit').'/'.$tahun.'/'.$result->id_kuitansi;?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							<?php } else if(isset($tab9)){ ?>
								<a href="<?php echo site_url('akuntansi/rsa_gup/spm_gup_lihat_99/'.urlencode(base64_encode($result->no_spm)).'/'.$this->session->userdata('kode_unit').'/'.$tahun);?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							<?php }else{ ?>
								<a href="<?php echo site_url('akuntansi/rsa_gup/jurnal/'.$result->id_kuitansi.'/?spm='.urlencode($result->no_spm));?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							<?php } ?>
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

function up_get_details($no_spm){
    $ci =& get_instance();
    $ci->load->model('Rsa_up_model', 'up_model');
    
    return $ci->up_model->get_data_spm($no_spm);
}

function tup_get_details($no_spm){
    $ci =& get_instance();
    $ci->load->model('Rsa_tambah_tup_model', 'tup_model');
    
    return $ci->tup_model->get_data_spm($no_spm);
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