<!-- javascript -->
<script type="text/javascript" src="<?php echo base_url();?>/assets/akuntansi/js/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/akuntansi/css/daterangepicker.css" />

<style type="text/css">
table
{
	margin:0 auto;
	border-collapse: collapse;
}

thead
{
	display: block;
	overflow: auto;
	color: #1c1c1c;
	background: #e6e6e6;
}

tbody
{
	display: block;
	height: 400px;
	background: #fff;
	overflow: auto;
}

th,td
{
	padding: .5em 1em;
	text-align: left;
	vertical-align: top;
	border-left: 1px solid #fff;
	border-bottom: 1px solid #000;
}
tr > td{
	color:#bdbdbd;
}
.blink_me {
	font-size:14pt;
	font-weight:bold;
  animation: blinker 1s linear infinite;
}

@keyframes blinker {  
  50% { opacity: 0.2; }
}

.green{color:green;}
.orange{color:orange;}
.blue{color:blue;}
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
		<li class="active">Monitor</li>
	</ol>
</div><!--/.row-->
<hr/>
<div style="font-size:20pt">
	<span class="glyphicon glyphicon-dashboard"></span> Monitoring
</div>
<form class="form-horizontal" action="<?php echo site_url('akuntansi/kuitansi/monitor'); ?>" method="post">
	<div class="form-group">
	    <label class="col-md-2 control-label"></label>  
	    <div class="col-md-6">
	    	<input class="form-control" type="text" name="daterange">
	    </div>
	    <div class="col-md-1">
	    	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Cari</button>
	    </div>
	    <div class="col-md-1">
	    	<a href="<?php echo site_url('akuntansi/kuitansi/monitor/print'); ?>" target="_blank"><button type="button" class="btn btn-success"><span class="glyphicon glyphicon-print"></span> Print</button></a>
	    </div>
	</div>
</form>
<div class="row">
	<div class="col-lg-12">
		<center>Periode: <b><?php echo $periode; ?></b></center>
		<table class="tes">
			<thead>
				<tr>
					<th style="width:200px !important">Nama Unit</th>
					<th style="width:100px !important" align="center">Belum dijurnal</th>
					<th style="width:100px !important" align="center">Belum verifikasi</th>
					<th style="width:100px !important" align="center">Disetujui</th>
					<th style="width:100px !important" align="center">Revisi</th>
					<th style="width:100px !important" align="center">Sudah direvisi</th>
					<th style="width:100px !important" align="center">Posting</th>
				</tr>
			</thead>
			<tbody>		
		<?php $no=0;foreach($query_unit->result() as $result){ ?>
			<tr style="font-size:12pt;">
				<td style="width:200px !important;color:#1c1c1c"><?php echo $result->nama_unit; ?></td>
				<td class="<?php if($total_kuitansi[$no] > 0) echo 'blink_me'; ?>" style="text-align:center;width:100px !important; <?php if($total_kuitansi[$no] > 0) echo 'color:red;' ?>"><?php echo $total_kuitansi[$no]; ?></td>
				<td class="<?php if($non_verif[$no] > 0) echo 'blink_me'; ?>" style="text-align:center;width:100px !important; <?php if($non_verif[$no] > 0) echo 'color:red !important;' ?>"><?php echo $non_verif[$no]; ?></td>
				<td class="<?php if($setuju[$no] > 0) echo 'blink_me green'; ?>" style="text-align:center;width:100px !important"><?php echo $setuju[$no]; ?></td>
				<td class="<?php if($revisi[$no] > 0) echo 'blink_me orange'; ?>" style="text-align:center;width:100px !important"><?php echo $revisi[$no]; ?></td>
				<td class="<?php if($direvisi[$no] > 0) echo 'blink_me blue'; ?>" style="text-align:center;width:100px !important"><?php echo $direvisi[$no]; ?></td>
				<td style="text-align:center;width:100px !important;color:#1c1c1c"><span class="glyphicon glyphicon-ok"></span> <?php echo $posting[$no]; ?></td>
			</tr>
		<?php $no++;
		
		} ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">   
  $('input[name="daterange"]').daterangepicker(
        {
          locale: {
              format: 'DD MMMM YYYY',
               "separator": " - ",
                "applyLabel": "Simpan",
                "cancelLabel": "Batalkan",
                "fromLabel": "Dari",
                "toLabel": "Sampai",
                "customRangeLabel": "Tentukan Periode",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Min",
                    "Sen",
                    "Sel",
                    "Rab",
                    "Kam",
                    "Jum",
                    "Sab"
                ],
                "monthNames": [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember"
                ],
                "firstDay": 1
          },
          ranges: {
            'Triwulan I': [moment().month(0).startOf('month'), moment().month(2).endOf('month')],
            'Triwulan II': [moment().month(3).startOf('month'), moment().month(5).endOf('month')],
            'Triwulan III': [moment().month(6).startOf('month'), moment().month(8).endOf('month')],
            'Triwulan IV': [moment().month(9).startOf('month'), moment().month(11).endOf('month')],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          showDropdowns: true
        }
    );
</script>