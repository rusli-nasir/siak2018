<!-- javascript -->
<style type="text/css">
table {
        width:1800px;
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
	width:1800px;
    overflow-x: auto;
}


tbody td, thead th {
    width: 110px;
    float: left;
}
</style>
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
  <li role="presentation" class="<?php if(isset($tab1)){ if($tab1==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/UP/1'); ?>">UP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->up_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->up_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab2)){ if($tab2==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/PUP/1'); ?>">PUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->pup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->pup_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab3)){ if($tab3==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/GP/1'); ?>">GUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_jadi; ?></span></a></li>
    <li role="presentation" class="<?php if(isset($tab9)){ if($tab9==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/GUP/1'); ?>">GU&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gu_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gu_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab4)){ if($tab4==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/GP_NIHIL/1'); ?>">GUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_nihil_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_nihil_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab5)){ if($tab5==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/TUP/1'); ?>">TUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab6)){ if($tab6==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/TUP_NIHIL/1'); ?>">TUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_nihil_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_nihil_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab7)){ if($tab7==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi_ls'); ?>">LS- 3&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->ls_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->ls_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab8)){ if($tab8==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi_spm'); ?>">LS - PG&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->spm_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->spm_jadi; ?></span></a></li>

  <li role="presentation" class="<?php if(isset($tab_tup_pengembalian_jadi)){ if($tab_tup_pengembalian_jadi==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/TUP_PENGEMBALIAN/1'); ?>">TUP Peng.&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_pengembalian_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_pengembalian_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab_gup_pengembalian_jadi)){ if($tab_gup_pengembalian_jadi==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/GUP_PENGEMBALIAN/1'); ?>">GUP Peng.&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_pengembalian_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_pengembalian_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab_gup_nihil_jadi)){ if($tab_gup_nihil_jadi==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/GUP_NIHIL/1'); ?>">GUP Nihil.&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_nihil_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_nihil_jadi; ?></span></a></li>
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
					<?php echo 'Total Belum di Verifikasi: <br/><span style="color:#000;font-size:16pt;">'.$kuitansi_pasif.'</span>'; ?>
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
		<table class="table">
			<thead>
				<tr>
					<th style="width:50px;">NO</th>
					<th>AKSI</th>
					<th>TANGGAL</th>
					<th style="width:150px;">NO.SPM</th>
					<th style="width:250px;">KODE KEGIATAN</th>
					<th style="width:150px;">UNIT</th>
					<th style="width:600px !important" nowrap>NO. AKUN <br/><span style="color:blue;">KAS</span><br/>AKRUAL</th>
					<th style="width:110px;">DEBET</th>
					<th style="width:110px;">KREDIT</th>
					<th>STATUS</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($query as $result){ ?>
				<tr>
					<td style="width:50px;"><?php echo $no; ?></td>
                    <td>						
							<a href="<?php echo site_url('akuntansi/rsa_gup/lspg/id/'.get_id_spm($result->no_spm));?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
						<?php if($this->session->userdata('level')==1){ ?>
							<?php if($result->flag==1 AND $result->status=='revisi'){ ?>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/edit_kuitansi_jadi/'.$result->id_kuitansi_jadi.'/revisi'); ?>"><button type="button" class="btn btn-sm btn-success">Revisi</button></a>
							<?php }else{ ?>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-danger">Detil</button></a>
							<?php } ?>
						<?php }else if($this->session->userdata('level')==2){ ?>
							<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/evaluasi'); ?>"><button type="button" class="btn btn-sm btn-warning">Verifikasi</button></a>
							<a href="<?php echo site_url('akuntansi/jurnal_rsa/ganti_status/'.$result->id_kuitansi_jadi.'/list'); ?>"><button type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> Terima</button></a>
						<?php }else if($this->session->userdata('level')==3){ ?>
							<a href="#"><button type="button" class="btn btn-sm btn-success">Posting</button></a>
						<?php } ?>
					</td>
					<td><?php echo date("d/m/Y", strtotime($result->tanggal)); ?></td>
					<td style="width:150px;"><?php echo $result->no_spm; ?></td>
					<td style="width:250px;"><?php echo str_replace(',', '<br/>,', $result->kode_kegiatan); ?></td>
					<td style="width:150px;">-</td>
					<td style="width:600px !important" nowrap>
						<?php echo '<b style="color:blue">'.$result->akun_debet.' - '.$result->nama_akun_debet.'<br/>'.$result->akun_kredit.' - '.$result->nama_akun_kredit.'</b><br/>'.$result->akun_debet_akrual.' - ';
					 	if(substr($result->akun_debet_akrual,0,1)=='7'){
						 	$uraian_akun = explode(' ', $result->nama_akun_debet_akrual);
				            if($uraian_akun[0]!='Beban' OR $uraian_akun[0]!='beban'){
				              $uraian_akun[0] = 'Beban';
				            }
				            $hasil_uraian = implode(' ', $uraian_akun);
				        }else{
				        	$hasil_uraian = $result->nama_akun_debet_akrual;
				        }
			            echo $hasil_uraian;
            			echo '<br/>'.$result->akun_kredit_akrual.' - '.$result->nama_akun_kredit_akrual; ?></td>
					<td style="width:110px;"><?php echo number_format($result->jumlah_debet).'<br/><br/>'.number_format($result->jumlah_debet); ?></td>
					<td style="width:110px;"><?php echo '<br/>'.number_format($result->jumlah_kredit).'<br/><br/>'.number_format($result->jumlah_kredit); ?></td>
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
	if (strpos($no_bukti, '-')) {
		return null;
	}

	$hasil = $ci->db->get_where(get_tabel_by_jenis($jenis),array('no_bukti' => $no_bukti))->result_array();
	
	$data = array();

	foreach ($hasil as $entry) {
		$detail = $ci->db->get_where('akuntansi_pajak',array('jenis_pajak' => $entry['jenis_pajak']))->row_array();
		if ($detail != null)
			$data[] = array_merge($entry,$detail);
	}

	return $data;
}
?>