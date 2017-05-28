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
		<li class="active">Monitor</li>
	</ol>
</div><!--/.row-->
<hr/>
<div style="font-size:20pt">
	<span class="glyphicon glyphicon-dashboard"></span> Monitoring
</div>
<form class="form-horizontal" action="#" method="post">
	<div class="form-group">
	    <label class="col-md-2 control-label"></label>  
	    <div class="col-md-6">
	    	<input class="form-control" type="text" name="daterange">
	    </div>
	    <div class="col-md-2">
	    	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Cari</button>
	    </div>
	</div>
</form>
<div class="row">
	<div class="col-lg-12">
		<table class="tes">
			<thead>
				<tr>
					<th style="width:200px !important">Nama Unit</th>
					<th style="width:100px !important" align="center">Total Kuitansi</th>
					<th style="width:100px !important" align="center">Belum verifikasi</th>
					<th style="width:100px !important" align="center">Disetujui</th>
					<th style="width:100px !important" align="center">Direvisi</th>
					<th style="width:100px !important" align="center">Posting</th>
				</tr>
			</thead>
			<tbody>		
		<?php $no=1;foreach($query_unit->result() as $result){ ?>
			<tr style="font-size:12pt;">
				<td style="width:200px !important"><?php echo $result->nama_unit; ?></td>
				<td style="width:100px !important"><?php echo get_total_kuitansi($result->kode_unit); ?></td>
				<td style="width:100px !important"><?php echo get_total_data($result->kode_unit, 'non_verif'); ?></td>
				<td style="width:100px !important"><span style="color:green"><?php echo get_total_data($result->kode_unit, 'setuju'); ?></span></td>
				<td style="width:100px !important"><span style="color:orange"><?php echo get_total_data($result->kode_unit, 'revisi'); ?></span></td>
				<td style="width:100px !important"><?php echo get_total_data($result->kode_unit, 'posting'); ?></td>
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

<?php
function get_total_kuitansi($kode_unit){
	$ci =& get_instance();

	$query = "SELECT * FROM rsa_kuitansi WHERE kode_unit='$kode_unit' AND cair=1";
	$q = $ci->db->query($query)->num_rows();
	return $q;
}
function get_total_data($kode_unit, $jenis){
	$ci =& get_instance();

	if($jenis=='setuju'){
		$query = "SELECT * FROM akuntansi_kuitansi_jadi WHERE unit_kerja='$kode_unit' AND status='proses' AND flag=2";
	}else if($jenis=='revisi'){
		$query = "SELECT * FROM akuntansi_kuitansi_jadi WHERE unit_kerja='$kode_unit' AND status='revisi' AND flag=1";
	}else if($jenis=='posting'){
		$query = "SELECT * FROM akuntansi_kuitansi_jadi WHERE unit_kerja='$kode_unit' AND status='posted'";
	}else if($jenis=='non_verif'){
		$query = "SELECT * FROM akuntansi_kuitansi_jadi WHERE unit_kerja='$kode_unit' AND status='proses' AND flag=1";
	}
	$q = $ci->db->query($query)->num_rows();
	return $q;
}
?>