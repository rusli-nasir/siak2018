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
		<li class="active">Pilih Unit</li>
	</ol>
</div><!--/.row-->
<hr/>
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<table class="table table-striped">
			<tr>
				<th>Nama Unit</th>
				<th align="center">Menunggu Verifikasi</th>
                <th align="center">Menunggu Posting</th>
				<th>Aksi</th>
			</tr>		
		<?php foreach($query_unit->result() as $result){ ?>
            <?php if(isset($jumlah_verifikasi[$result->kode_unit])) $jmlv = $jumlah_verifikasi[$result->kode_unit]; else $jmlv = null?>
            <?php if(isset($jumlah_posting[$result->kode_unit])) $jmlp = $jumlah_posting[$result->kode_unit]; else $jmlp = null?>
			<tr>
				<td><?php echo $result->nama_unit; ?></td>
				<td align="center"><a class="badge <?= $jmlv?'badge-notify':'' ?>" href="<?php echo site_url('akuntansi/kuitansi/set_unit_session/'.$result->kode_unit); ?>"><?= $jmlv?$jmlv:'0' ?></a></td>
				<td align="center"><a class="badge <?= $jmlp?'badge-notify':'' ?>" href="<?php echo site_url('akuntansi/kuitansi/set_unit_session/'.$result->kode_unit.'/posting'); ?>"><?= $jmlp?$jmlp:'0' ?></a></td>
				<td>
					<a href="<?php echo site_url('akuntansi/kuitansi/set_unit_session/'.$result->kode_unit); ?>"><button type="button" class="btn btn-primary">Pilih</button></a>
				</td>
			</tr>
		<?php } ?>
		</table>
	</div>
</div>