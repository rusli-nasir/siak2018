<?php 
$tahun = $this->session->userdata('setting_tahun');
 ?>
<style type="text/css">
table {
        width: 100% !important;
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
	width:1200px;
    overflow-x: auto;
}


tbody td, thead th {
    width: 100px;
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
  <li role="presentation" class="<?php if(isset($tab4)){ if($tab4==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_up'); ?>">UP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->up ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->up; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab6)){ if($tab6==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_pup'); ?>">PUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->pup ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->pup; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab1)){ if($tab1==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index'); ?>">GUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab9)){ if($tab9==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_gup'); ?>">GU&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gu ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gu; ?></span></a></li>
  <!-- <li role="presentation" class="<?php if(isset($tab7)){ if($tab7==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_nihil'); ?>">GUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_nihil ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_nihil; ?></span></a></li> -->
  <li role="presentation" class="<?php if(isset($tab5)){ if($tab5==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_tup'); ?>">TUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab8)){ if($tab8==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_tup_nihil'); ?>">TUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_nihil ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_nihil; ?></span></a></li>
    <li role="presentation" class="<?php if(isset($tab11)){ if($tab11==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_lk'); ?>">LS-K&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->lk ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->lk; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab12)){ if($tab12==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_lnk'); ?>">LS-NK&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->ln ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->ln; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab3)){ if($tab3==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_spm'); ?>">LS - PG&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->spm ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->spm; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab10)){ if($tab10==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_tup_pengembalian'); ?>">TUP Peng.&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_pengembalian ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_pengembalian; ?></span></a></li>

  <!-- <li role="presentation" class="<?php if(isset($tab_ks)){ if($tab_ks==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_ks'); ?>">Kerja Sama&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->ks ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->ks; ?></span></a></li> -->

  <li role="presentation" class="<?php if(isset($tab_gup_nihil)){ if($tab_gup_nihil==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_misc/gup_nihil'); ?>">GUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_nihil ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_nihil; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab_gup_pengembalian)){ if($tab_gup_pengembalian==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index_misc/gup_pengembalian'); ?>">GUP Pengembalian&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_pengembalian ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_pengembalian; ?></span></a></li>
</ul>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Kuitansi <?php if($this->session->userdata('kode_unit')!=null){ echo get_nama_unit($this->session->userdata('kode_unit')); } ?></h1>
		<div class="row">
			<div class="col-sm-4">
				<div class="box-t">
					<?php echo 'Total Kuitansi Belum di Jurnal: <br/><span style="color:red;font-size:16pt;">'.$kuitansi_non_jadi.'</span>'; ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="box-t">
					<?php echo 'Total Kuitansi Sudah di Jurnal: <br/><span style="color:green;font-size:16pt;">'.$kuitansi_jadi.'</span>'; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<div class="row">
	<div class="col-sm-4">
		<?php if(isset($tab5)){ ?>
		<form action="<?php echo site_url('akuntansi/kuitansi/index'); ?>" method="post">
			<div class="input-group">
				<span class="input-group-btn">
	        		<a href="<?php echo site_url('akuntansi/kuitansi/reset_search'); ?>"><button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-refresh"></span> Reset</button></a>
	      		</span>
	      		<input type="text" class="form-control" placeholder="No.bukti/No.SPM/Uraian" name="keyword_pup" value="<?php if($this->session->userdata('keyword_pup')) echo $this->session->userdata('keyword_pup'); ?>">
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
					<th style="width:4% !important">NO</th>
					<th>AKSI</th>
					<th>TANGGAL</th>
					<!-- <th>NO.BUKTI</th> -->
					<th>NO.SPM</th>
					<th>JENIS</th>
					<!-- <th>KODE KEGIATAN</th> -->
					<th>UNIT</th>
					<th style="width:250px !important">URAIAN</th>
					<th>AKUN DEBET</th>
					<th>AKUN KREDIT</th>
					<th>PAJAK</th>
					<th>JUMLAH</th>
				</tr>
			</thead>
			<tbody style="font-size:12pt;">
				<?php foreach($query->result() as $result){?>

				<tr>
					<td style="width:4% !important"><?php echo $no; ?></td>
					<?php if ($jenis == 'KS'): ?>
						<td>						
							<a href="<?php echo site_url('akuntansi/rsa_tambah_ks/spm_tambah_ks_lihat/'.urlencode(base64_encode($result->no_spp))).'/'.$this->session->userdata('kode_unit').'/'.$tahun?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							<a href="<?php echo site_url('akuntansi/jurnal_rsa/input_jurnal/'.$result->nomor_trx_spm).'/KS'; ?>"><button type="button" class="btn btn-sm btn-danger">Isi Jurnal</button></a>
						</td>
						<td><?php echo date("d/m/Y", strtotime($result->tgl_spm)); ?></td>
						<!-- <td><?php /*echo $result->no_bukti;*/ ?></td> -->
						<td><?php echo $result->str_nomor_trx; ?></td>
						<td><?php echo "KS"; ?></td>
						<!-- <td><?php /*echo substr($result->kode_usulan_belanja,6,2);*/ ?></td> -->
						<td><?php echo get_unit($result->kode_unit_subunit); ?></td>
						<td style="width:250px !important"><?php echo $result->untuk_bayar."<br>Penerima: ".$result->penerima; ?></td>
						<td><?php echo $result->kd_akun_kas; ?></td>
	                    <td><?php echo '?'; ?></td>
	                    <td><?php echo '-'; ?></td>
						<td><?php echo $result->debet; ?></td>					
					<?php elseif ($jenis == 'GUP_NIHIL'): ?>
						<td>						
							<a href="<?php echo site_url('akuntansi/rsa_gup/jurnal/'.$result->id_kuitansi.'/?spm='.urlencode($result->str_nomor_trx_spm));?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							
							<a href="<?php echo site_url('akuntansi/jurnal_rsa/input_jurnal/'.$result->id_kuitansi)."/$jenis"; ?>"><button type="button" class="btn btn-sm btn-danger">Isi Jurnal</button></a>
						</td>
						<td>
							<?php
								$ci =& get_instance();
								$ci->load->model('akuntansi/Spm_model', 'Spm_model');
								$result->tgl_kuitansi = $ci->Spm_model->get_tanggal_spm($result->str_nomor_trx_spm,$result->jenis);
								// echo $result->tgl_kuitansi;
						 		echo date("d/m/Y", strtotime($result->tgl_kuitansi)); 
					 		?>
					 	</td>
						<!-- <td><?php /*echo $result->no_bukti;*/ ?></td> -->
						<td><?php echo $result->str_nomor_trx; ?></td>
						<td><?php echo $jenis; ?></td>
						<!-- <td><?php /*echo substr($result->kode_usulan_belanja,6,2);*/ ?></td> -->
						<td><?php echo get_unit($result->kode_unit); ?></td>
						<td style="width:250px !important"><?php echo $result->uraian; ?></td>
						<td><?php echo $result->kode_akun; ?></td>
	                    <td><?php echo '?'; ?></td>
	                    <?php 
						$pajak = get_detail_pajak($result->no_bukti, 'GP'); 
						?>
						<td style="width:200px">
						<?php foreach ($pajak as $entry_pajak): ?>
			              
			              	<?php echo $entry_pajak['nama_akun'].' '.$entry_pajak['persen_pajak']." (Rp. ".number_format($entry_pajak['rupiah_pajak'],2,',','.').')<br/>'; ?>
			              
			          	<?php endforeach ?>
			          	</td>
						<td><?php echo get_pengeluaran($result->id_kuitansi); ?></td>		
					<?php elseif ($jenis == 'GUP_PENGEMBALIAN'): ?>
						<td>						
							<a href="<?php echo site_url('akuntansi/rsa_gup/spm_gup_lihat_99/'.urlencode(base64_encode($result->str_nomor_trx_spm)).'/'.$this->session->userdata('kode_unit').'/'.$tahun);?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							<a href="<?php echo site_url('akuntansi/jurnal_rsa/input_jurnal/'.$result->id_kuitansi)."/$jenis"; ?>"><button type="button" class="btn btn-sm btn-danger">Isi Jurnal</button></a>
						</td>
						<td><?php echo date("d/m/Y", strtotime($result->tgl_kuitansi)); ?></td>
						<td><?php echo $result->no_bukti; ?></td>
						<td><?php echo $result->str_nomor_trx_spm; ?></td>
						<td>GUP Pengembalian</td>
						<!-- <td><?php echo substr($result->kode_usulan_belanja,6,2); ?></td> -->
						<td><?php echo get_unit($result->kode_unit); ?></td>
						<td style="width:250px"><?php echo $result->uraian; ?></td>
						<td><?php echo $result->kode_akun; ?></td>
						<td><?php echo '?'; ?></td>
						<td><?php echo '-'; ?></td>
						<td><?php echo get_pengeluaran($result->id_kuitansi); ?></td>
					<?php endif ?>
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
    return $unit;
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
	if ($jenis == 'GP' or $jenis == 'GUP_NIHIL' or $jenis == 'gup_nihil') {
		return 'rsa_kuitansi_detail_pajak';
	}elseif ($jenis == 'L3') {
		return 'rsa_kuitansi_detail_pajak_lsphk3';
	}
}
function get_detail_pajak($no_bukti,$jenis)
{
	$ci =& get_instance();

	$ci->load->model('akuntansi/Pajak_model', 'Pajak_model');

	return $ci->Pajak_model->get_detail_pajak($no_bukti,$jenis);
}
?>