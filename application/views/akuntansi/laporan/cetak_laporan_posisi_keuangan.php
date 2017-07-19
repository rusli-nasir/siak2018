<!DOCTYPE>
<html>
	<head>
		<title>Laporan Aktifitas</title>
		<style type="text/css">
		@page{
			size:landscape;
		}
		.border {
		    border-collapse: collapse;
		}

		.border td,
		.border th{
		    border: 1px solid black;
		}
		.tab0{padding-left:0px !important;font-weight:bold;}
		.tab1{padding-left:20px !important;font-weight:bold;}
		.tab2{padding-left:40px !important;}
		.btn{padding:10px;box-shadow:1px 1px 2px #bdbdbd;border:0px;}
    	.excel{background-color:#A3A33E;color:#fff;}
    	.pdf{background-color:#588097;color:#fff;}
		</style>
		<script type="text/javascript">
		</script>
	</head>
	<body style="font-family:arial;margin:20px 20px 20px 20px;">
		<div align="center">
			<div style="font-weight:bold">
				UNIVERSITAS DIPONEGORO<br/>
				Laporan Posisi Keuangan<br/>
				31 DESEMBER 20X1<br/>
			</div>
			(Disajikan dalam Rupiah, kecuali dinyatakan lain)<br/><br/>
		</div>
		<table style="width:1100px;font-size:10pt;margin:0 auto" class="border">
			<thead>
				<tr style="background-color:#ECF379;height:45px">
					<th width="30px"></th>
					<th width="750px">URAIAN</th>
					<th>31 Des 20X1</th>
					<th>31 Des 20X0</th>
					<th>Selisih/Kenaikan</th>
					<th>%</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($nama as $key=>$value){ ?>
				<tr>
					<td></td>
					<td class="tab0"><?php echo $value; ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php } ?>
				<tr>
					<td></td>
					<td class="tab1">ASET LANCAR</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td class="tab1" style="font-weight:0;">Kas dan Setara Kas</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td class="tab2">Kas Bank Mandiri</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td class="tab2">Kas Bank BNI</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</body>
</html>
<?php
public function get_nama_akun_by_level($kode_akun,$level,$tabel)
{
	$sub_kode = substr($kode_akun,0,1);

	if ($sub_kode == 6) {
		$kode_akun = substr_replace($kode_akun,'4',0,1);
	}

	if ($sub_kode == 5 or $sub_kode == 7) {
		$kode_akun = substr_replace($kode_akun,'5',0,1);

		$this->db2->select("nama_akun".$level."digit as nama");
		$this->db2
				 ->like("kode_akun".$level."digit",$kode_akun,'after')
				 ->where("kode_akun".$level."digit",$kode_akun)
				 ->group_by("kode_akun".$level."digit")
				 ->from("akun_belanja")
		;

		return ucwords(str_replace("Biaya","Beban",$this->db2->get()->row_array()['nama']));
	} else {
		$this->db
			->like("akun_$level",$kode_akun,'after')
			->from("akuntansi_".$tabel."_".$level)
			->where("akun_$level",$kode_akun)
		;

		return ucwords($this->db->get()->row_array()['nama']);
	}

}
?>