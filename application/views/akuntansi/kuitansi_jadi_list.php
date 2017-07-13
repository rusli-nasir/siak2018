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
  <li role="presentation" class="<?php if(isset($tab1)){ if($tab1==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/UP/1'); ?>">UP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->up_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->up_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab2)){ if($tab2==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/PUP/1'); ?>">PUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->pup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->pup_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab3)){ if($tab3==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/GP/1'); ?>">GUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_jadi; ?></span></a></li>
    <li role="presentation" class="<?php if(isset($tab9)){ if($tab9==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/GUP/1'); ?>">GU&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gu_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gu_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab4)){ if($tab4==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/GP_NIHIL/1'); ?>">GUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->gup_nihil_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->gup_nihil_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab5)){ if($tab5==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/TUP/1'); ?>">TUP&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab6)){ if($tab6==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi/TUP_NIHIL/1'); ?>">TUP Nihil&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->tup_nihil_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->tup_nihil_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab7)){ if($tab7==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi_ls'); ?>">LS- 3&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->ls_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->ls_jadi; ?></span></a></li>
  <li role="presentation" class="<?php if(isset($tab8)){ if($tab8==true) echo 'active'; } ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi_spm'); ?>">LS - PG&nbsp;&nbsp;<span class="badge <?= $jumlah_notifikasi->spm_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->spm_jadi; ?></span></a></li>
</ul>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Kuitansi Jadi <?php if($this->session->userdata('kode_unit')!=null){ echo get_nama_unit($this->session->userdata('kode_unit')); } ?></h1>
		<div class="row">
			<div class="col-sm-4">
				<div class="box-t">
					<?php echo 'Total Kuitansi Diverifikasi: <br/><span style="color:green;font-size:16pt;">'.$kuitansi_ok.'</span>'; ?>
				</div>			
			</div>
			<div class="col-sm-4">
				<div class="box-t">
					<?php echo 'Total Kuitansi Direvisi: <br/><span style="color:orange;font-size:16pt;">'.$kuitansi_revisi.'</span>'; ?>
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
	    <form action="<?php echo site_url('akuntansi/kuitansi/jadi/1/'.$jenis); ?>" method="post">
			<div class="input-group">
				<span class="input-group-btn">
	        		<a href="<?php echo site_url('akuntansi/kuitansi/reset_search_jadi'); ?>"><button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-refresh"></span> Reset</button></a>
	      		</span>
	      		<input type="text" class="form-control" placeholder="No.bukti/No.SPM" name="keyword_jadi_<?php echo $jenis; ?>" value="<?php if($this->session->userdata('keyword_jadi_'.$jenis)) echo $this->session->userdata('keyword_jadi_'.$jenis); ?>">
	      		<span class="input-group-btn">
	        		<button class="btn btn-default" type="submit">Cari</button>
	      		</span>
	    	</div>
	    </form>
	</div>
	<?php if($this->session->userdata('level')=='2' AND $this->session->userdata('username')=='verifikator'){ ?>
	<div class="col-sm-4">	
		<a href="<?php echo site_url('akuntansi/kuitansi/pilih_unit'); ?>"><button type="button" class="btn btn-primary">Pilih Unit</button></a>
	</div>
	<?php } ?>
	<div class="col-sm-4">
		<?php if(isset($tab3)){ ?>
		<form action="<?php echo site_url('akuntansi/kuitansi/jadi'); ?>" method="post">
			<div class="input-group">
	      		<select name="keyword_jadi_GP" class="form-control">
					<option value="">Tampil Semua SPM</option>
					<?php 
					foreach($query_spm->result_array() as $result){ 
					?>
					<option value="<?php echo $result['no_spm']; ?>"
						<?php 
						if($this->session->userdata('keyword_jadi_GP')){
							if($result['no_spm']==$this->session->userdata('keyword_jadi_GP')){
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
		<table class="table">
			<thead>
				<tr>
					<th style="width:2% !important;">NO</th>
					<th style="width:110px;">AKSI</th>
					<th style="width:110px;">TANGGAL</th>
					<th style="width:110px;" style="width:110px;">NO.BUKTI</th>
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
				</tr>
			</thead>
			<tbody>
				<?php foreach($query as $result){ ?>
                <?php 
                    if($this->session->userdata('level') == 2){
                        //if(!($result->flag==1 && ($result->status=="direvisi" || $result->status=="proses"))) continue;
                    }
                ?>
				<tr>
					<td style="width:2% !important;"><?php echo $no; ?></td>
					<td style="width:110px;">						
							
                            <?php if(isset($tab1)){ ?>
								<a href="<?php $r=up_get_details($result->no_spm); echo site_url('akuntansi/rsa_gup/up/'.$r->kode_unit_subunit.'/'.explode('/', $result->no_spm)[4]);?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
							<?php } else if(isset($tab5)){ ?>
								<a href="<?php $r=tup_get_details($result->no_spm); echo site_url('akuntansi/rsa_gup/tup/'.$r->kode_unit_subunit.'/'.explode('/', $result->no_spm)[4]);?>" target="_blank"><button type="button" class="btn btn-sm btn-primary">Bukti</button></a>
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
							<?php if($result->flag==1 AND ($result->status=='proses' OR $result->status=='direvisi')){ ?>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/evaluasi'); ?>"><button type="button" class="btn btn-sm btn-warning">Verifikasi</button></a>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/ganti_status/'.$result->id_kuitansi_jadi.'/list'); ?>"><button type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> Terima</button></a>
							<?php }else{ ?>
								<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-danger">Detil</button></a>
							<?php } ?>
						<?php }else if($this->session->userdata('level')==3){ ?>
							<a href="<?php echo site_url('akuntansi/jurnal_rsa/detail_kuitansi/'.$result->id_kuitansi_jadi.'/lihat'); ?>"><button type="button" class="btn btn-sm btn-success">Posting</button></a>
						<?php } ?>
					</td>
					<td style="width:110px;"><?php echo date("d/m/Y", strtotime($result->tanggal)); ?></td>
					<td style="width:110px;"><?php echo $result->no_bukti; ?></td>
					<td style="width:110px;"><?php echo $result->no_spm; ?></td>
					<td style="width:70px;"><?php echo $result->jenis; ?></td>
					<td style="width:70px;"><?php echo substr($result->kode_kegiatan,6,2); ?></td>
					<td style="width:70px;"><?php echo get_unit($result->unit_kerja); ?></td>
					<td style="width:110px;"><?php echo $result->uraian; ?></td>
					<td style="width:500px !important" nowrap>
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
					<?php 
					$pajak = get_detail_pajak($result->no_bukti, $result->jenis); 
					?>
					<td style="width:250px;font-size:12pt;">

					<?php if($pajak != null) foreach ($pajak as $entry_pajak): ?>
		              
		              	<?php echo $entry_pajak['nama_akun'].' '.$entry_pajak['persen_pajak']." (Rp. ".number_format($entry_pajak['rupiah_pajak'],2,',','.').')<br/>'; ?>
		              
		          <?php endforeach ?>
		          	</td>
					<td style="width:110px;">
						<?php if($result->flag==1){ ?>
							<?php if($result->status=='revisi'){ ?>
							<button class="btn btn-xs btn-danger disabled"><span class="glyphicon glyphicon-repeat"></span> Revisi</button>
							<?php }else{ ?>
							<button class="btn btn-xs btn-default disabled">Proses verifikasi</button>
							<?php } ?>
						<?php }else if($result->flag==2){ ?>
						<button class="btn btn-xs btn-success disabled">Diverifikasi</button>
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