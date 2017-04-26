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
				<th align="center">Jumlah Notifikasi</th>
				<th>Aksi</th>
			</tr>		
		<?php foreach($query_unit->result() as $result){ ?>
            <?php if(isset($jumlah[$result->kode_unit])) $jml = $jumlah[$result->kode_unit]; else $jml = null?>
			<tr>
				<td><?php echo $result->nama_unit; ?></td>
				<td align="center"><div class="badge <?= $jml?'badge-notify':'' ?>"><?= $jml?$jml:'0' ?></div></td>
				<td>
					<a href="<?php echo site_url('akuntansi/kuitansi/set_unit_session/'.$result->kode_unit); ?>"><button type="button" class="btn btn-primary">Pilih</button></a>
				</td>
			</tr>
		<?php } ?>
		</table>
	</div>
</div>