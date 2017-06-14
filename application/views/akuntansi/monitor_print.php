<!DOCTYPE>
<html>
	<head>
		<title>Monitor</title>
		<style type="text/css">
		.border {
			width:1000px;
		    border-collapse: collapse;
		}

		.border td,
		.border th{
		    border: 1px solid black;
		}
		</style>
		<script type="text/javascript">
		window.print();
		</script>
	</head>
	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<div class="row">
			<div style="width:1000px">
				<center><h1>PROGRAM AKUNTANSI MONITORING</h1></center>
				<hr/>
				<hr/>
				Periode: <b><?php echo $periode; ?></b>
				<table class="border">
					<thead>
						<tr>
							<th style="width:40px !important">No</th>
							<th style="width:200px !important">Nama Unit</th>
							<th style="width:100px !important" align="center">Total Kuitansi</th>
							<th style="width:100px !important" align="center">Belum verifikasi</th>
							<th style="width:100px !important" align="center">Disetujui</th>
							<th style="width:100px !important" align="center">Direvisi</th>
							<th style="width:100px !important" align="center">Posting</th>
						</tr>
					</thead>
					<tbody>		
				<?php $no=0;foreach($query_unit->result() as $result){ ?>
					<tr style="font-size:12pt;">
						<td style="width:40px !important" align="center"><?php echo $no+1; ?></td>
						<td style="width:200px !important"><?php echo $result->nama_unit; ?></td>
						<td style="width:100px !important;font-weight:bold;" align="center"><?php echo $total_kuitansi[$no]; ?></td>
						<td style="width:100px !important;font-weight:bold;" align="center"><?php echo $non_verif[$no]; ?></td>
						<td style="width:100px !important;font-weight:bold;" align="center"><span style="color:green"><?php echo $setuju[$no]; ?></span></td>
						<td style="width:100px !important;font-weight:bold;" align="center"><span style="color:orange"><?php echo $revisi[$no]; ?></span></td>
						<td style="width:100px !important;font-weight:bold;" align="center"><?php echo $posting[$no]; ?></td>
					</tr>
				<?php $no++;
				
				} ?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>