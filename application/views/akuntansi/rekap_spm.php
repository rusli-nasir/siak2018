<!-- javascript -->
<?php
	$tahun = $this->session->userdata('setting_tahun');
?>
<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/akuntansi/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/akuntansi/css/daterangepicker.css" />


<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/akuntansi/js/daterangepicker.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url();?>/assets/akuntansi/js/datatables.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>/assets/akuntansi/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/akuntansi/js/excellentexport.min.js"></script>
<script src="<?php echo base_url();?>/assets/akuntansi/js/jquery.print.js"></script>


<script type="text/javascript">
	$(document).ready(function(){
		var host = location.protocol + '//' + location.host + '/sisrenbang/index.php/';

		$("#filter_tahun").change(function(){
			$("#form_filter_tahun").submit();
		});
		$("#filter_status").change(function(){
			$("#form_filter").submit();
		});
		$('#unit_list').selectize();
	});
</script>
<!-- javascript -->
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Rekap SPM</li>
	</ol>
</div><!--/.row-->
<hr/>
<div style="font-size:20pt;margin-bottom:20px;">
	<span class="glyphicon glyphicon-dashboard"></span> Rekap SPM<div style="font-size:12pt;margin-left:35px;"><?php echo $periode; ?></div>
</div>
<div class="row">
	<div class="col-sm-8">
		<form class="form-horizontal" action="<?php echo site_url('akuntansi/laporan/rekap_spm'); ?>" method="post">
			<div class="form-group">
			    <div class="col-md-5">
			    	<select id="unit_list" name="unit" class="form-control" required="" <?php if (in_array($this->session->userdata('level'),$array_unit)): ?> disabled <?php endif ?>>
		              <option value="all" selected=""> Semua</option>
			            <?php foreach($query_unit->result() as $unit): ?>
			              <option value="<?php echo $unit->kode_unit ?>" <?php if(isset($kode_unit)){ if($kode_unit==$unit->kode_unit) echo 'selected'; } ?>><?= $unit->alias." - ".$unit->nama_unit ?></option>
			            <?php endforeach; ?>
			        </select>
			    </div>
			    <div class="col-md-5">
			    	<input class="form-control" type="text" name="daterange" id="daterange">
			    </div>
			    <div class="col-md-2">
			    	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Cari</button>
			    </div>
			</div>
		</form>
	</div>
	<div class="col-sm-2">
		<form class="form-horizontal" action="<?php echo site_url('akuntansi/laporan/rekap_spm/cetak'); ?>" method="post" target="_blank">
			<input type="hidden" name="unit" value="<?php if(isset($kode_unit)) echo $kode_unit; ?>">
			<input type="hidden" name="daterange" value="<?php if(isset($periode)) echo $periode; ?>">
			<!-- <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-print"></span> Download Excel</button> -->
			<a download="rekap_spm.xls" id="download_excel" class="no-print"><button  class="btn btn-success" type="button">Download excel</button></a>
			<button class="btn btn-success no-print" type="button" id="print_tabel">Cetak</button>
		</form>
	</div>
</div>
	    
<div class="row">
	<div class="col-sm-2">
		<div style="width:50px;height:30px;background-color:#DAEEF3;border:2px solid #1c1c1c"></div>
		Sudah dijurnal
	</div>
	<div class="col-sm-2">
		<div style="width:50px;height:30px;background-color:#fff;border:2px solid #1c1c1c"></div>
		Belum dijurnal
	</div>
</div>
<div class="row">
	<div class="col-sm-12">	
		<div id="printed_table">
		<style type="text/css">
			@media print {
			  a[href]:after {
			    content: none !important;
			  }
			}
		</style>
		<table class="table" id="tabel_spm">
			<thead>
				<tr>
					<th colspan="7" style="text-align: center;">
						REKAP SPM <br/> 
						<?php echo $teks_periode ?> <br/> <br/> 
					</th>
				</tr>
				<tr>
					<th>No</th>
					<th>Jenis</th>
					<th>Tanggal</th>
					<th>No. SPM</th>
					<th width="40% !important">Keterangan</th>
					<th>Jumlah</th>
					<th>terjurnal</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1;$total=0; ?>
				<?php if($up->num_rows() > 0){
					foreach($up->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>UP</td>
					<td><?php echo date("d-m-Y", strtotime($result->tgl_spm)); ?></td>
					<td>
						<a href="<?php $r=up_get_details($result->str_nomor_trx); echo site_url('akuntansi/rsa_gup/up/'.$r->kode_unit_subunit.'/'.explode('/', $result->str_nomor_trx)[4]);?>" target="_blank">
							<?php echo $result->str_nomor_trx; ?>
						</a>
					</td>			
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
					<td>
						<?php if ($result->flag_proses_akuntansi==1): ?>
							<span class="glyphicon glyphicon-ok text-success"> sudah</span>
						<?php else: ?>
							<span class="glyphicon glyphicon-remove text-danger"> belum</span>
						<?php endif ?>
					</td>
				</tr>
				<?php $no++; } } ?>
				<?php if($gu->num_rows() > 0){
					foreach($gu->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>	
					<td><?php echo $no; ?>.</td>
					<td>GU</td>
					<td>
						<?php 
							$tanggal = date("d-m-Y", strtotime($result->tgl_spm));
							$tahun = date("Y", strtotime($result->tgl_spm));
							echo $tanggal; 
						?>
					</td>
					<td>
						<a href="<?php echo site_url('akuntansi/rsa_gup/spm_gup_lihat_99/'.urlencode(base64_encode($result->str_nomor_trx)).'/'.$this->session->userdata('kode_unit').'/'.$tahun);?>" target="_blank">
							<?php echo $result->str_nomor_trx; ?>
						</a>
					</td>			
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
					<td>
						<?php if ($result->flag_proses_akuntansi==1): ?>
							<span class="glyphicon glyphicon-ok text-success"> sudah</span>
						<?php else: ?>
							<span class="glyphicon glyphicon-remove text-danger"> belum</span>
						<?php endif ?>
					</td>
				</tr>
				<?php $no++; } } ?>
				<?php if($pup->num_rows() > 0){
					foreach($pup->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>	
					<td><?php echo $no; ?>.</td>
					<td>PUP</td>
					<td><?php echo date("d-m-Y", strtotime($result->tgl_spm)); ?></td>

					<td>
						<!-- <a href="<?php echo site_url('akuntansi/rsa_gup/jurnal/'.$result->nomor_trx_spm.'/?spm='.urlencode($result->str_nomor_trx));?>" target="_blank"> -->
							<?php echo $result->str_nomor_trx; ?>	
						<!-- </a> -->
					</td>			

					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
					<td>
						<?php if ($result->flag_proses_akuntansi==1): ?>
							<span class="glyphicon glyphicon-ok text-success"> sudah</span>
						<?php else: ?>
							<span class="glyphicon glyphicon-remove text-danger"> belum</span>
						<?php endif ?>
					</td>		
				</tr>
				<?php $no++; } } ?>
				<?php if($tup->num_rows() > 0){
					foreach($tup->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>TUP</td>
					<!-- <td><?php echo date("d-m-Y", strtotime($result->tgl_spm)); ?></td> -->
					<!-- <td><?php echo $result->str_nomor_trx; ?></td>			 -->
					<td>
						<?php 
							$tanggal = date("d-m-Y", strtotime($result->tgl_spm));
							$tahun = date("Y", strtotime($result->tgl_spm));
							echo $tanggal; 
						?>
					</td>
					<td>
						<a href="<?php echo site_url('akuntansi/rsa_tambah_tup/spm_tambah_tup_lihat_99/'.urlencode(base64_encode($result->str_nomor_trx)).'/'.$this->session->userdata('kode_unit').'/'.$tahun);?>" target="_blank">
							<?php echo $result->str_nomor_trx; ?>
						</a>
					</td>
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
					<td>
						<?php if ($result->flag_proses_akuntansi==1): ?>
							<span class="glyphicon glyphicon-ok text-success"> sudah</span>
						<?php else: ?>
							<span class="glyphicon glyphicon-remove text-danger"> belum</span>
						<?php endif ?>
					</td>
				</tr>
				<?php $no++; } } ?>
				<?php if($lk->num_rows() > 0){
					foreach($lk->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>LSK</td>
					<!-- <td><?php echo date("d-m-Y", strtotime($result->tgl_proses)); ?></td> -->
					<!-- <td><?php echo $result->str_nomor_trx_spm; ?></td>			 -->
					<td>
						<?php 
							$tanggal = date("d-m-Y", strtotime($result->tgl_proses));
							$tahun = date("Y", strtotime($result->tgl_proses));
							echo $tanggal; 
						?>
					</td>
					<td>
						<a href="<?php echo site_url('akuntansi/rsa_lsk/spm_lsk_lihat_99/'.urlencode(base64_encode($result->no_spp))).'/'.$this->session->userdata('kode_unit').'/'.$tahun.'/'.$result->id_kuitansi;?>" target="_blank">
							<?php echo $result->no_spm; ?>
						</a>
					</td>
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
					<td>
						<?php if ($result->flag_proses_akuntansi==1): ?>
							<span class="glyphicon glyphicon-ok text-success"> sudah</span>
						<?php else: ?>
							<span class="glyphicon glyphicon-remove text-danger"> belum</span>
						<?php endif ?>
					</td>
				</tr>
				<?php $no++; } } ?>
				<?php if($ln->num_rows() > 0){
					foreach($ln->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>LNK</td>
					<!-- <td><?php echo date("d-m-Y", strtotime($result->tgl_proses)); ?></td> -->
					<!-- <td><?php echo $result->str_nomor_trx_spm; ?></td>			 -->
					<td>
						<?php 
							$tanggal = date("d-m-Y", strtotime($result->tgl_proses));
							$tahun = date("Y", strtotime($result->tgl_proses));
							echo $tanggal; 
						?>
					</td>
					<td>
						<a href="<?php echo site_url('akuntansi/rsa_lsnk/spm_lsnk_lihat_99/'.urlencode(base64_encode($result->no_spp))).'/'.$this->session->userdata('kode_unit').'/'.$tahun.'/'.$result->id_kuitansi;?>" target="_blank">
							<?php echo $result->no_spm; ?>
						</a>
					</td>
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php $total += $result->jumlah_bayar; echo number_format($result->jumlah_bayar); ?></td>
					<td>
						<?php if ($result->flag_proses_akuntansi==1): ?>
							<span class="glyphicon glyphicon-ok text-success"> sudah</span>
						<?php else: ?>
							<span class="glyphicon glyphicon-remove text-danger"> belum</span>
						<?php endif ?>
					</td>
				</tr>
				<?php $no++; } } ?>
				<?php if($lspg->num_rows() > 0){
					foreach($lspg->result() as $result){ 
					if($result->flag_proses_akuntansi==1){ 
						echo '<tr style="background-color:#DAEEF3">';
					}else{
						echo '<tr>';
					}?>			
					<td><?php echo $no; ?>.</td>
					<td>LSPG</td>
					<td><?php echo date("d-m-Y", strtotime($result->tanggal)); ?></td>
					<td>
						<a href="<?php echo site_url('akuntansi/rsa_gup/lspg/id/'.$result->id_spmls);?>" target="_blank">
							<?php echo $result->nomor; ?>
						</a>
					</td>			
					<td><?php echo $result->untuk_bayar; ?></td>
					<td><?php $total += $result->jumlah_bayar; echo number_format($result->total_sumberdana); ?></td>
					<td>
						<?php if ($result->flag_proses_akuntansi==1): ?>
							<span class="glyphicon glyphicon-ok text-success"> sudah</span>
						<?php else: ?>
							<span class="glyphicon glyphicon-remove text-danger"> belum</span>
						<?php endif ?>
					</td>
				</tr>
				<?php $no++; } } ?>
			</tbody>
			<tbody>
				<tr>
					<th colspan="5" align="right">Total</th>
					<th colspan="2"><?php echo number_format($total); ?></th>
				</tr>
			</tbody>
		</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#download_excel').click(function(){
		// var printed = jQuery.extend(true,{}, $('#printed_table'))
		var printed = $('#printed_table').clone()
		printed.find('label').first().remove()
		printed.find('div.dataTables_info').last().remove()
		printed.find('table').attr('border', '1')
		printed.find('tr').css("background-color", "");
        var result = 'data:application/vnd.ms-excel,'+ encodeURIComponent(printed.html()) 
        this.href = result;
        this.download = "rekap_spm.xls";


        return true;
    })
    
    $('#print_tabel').click(function(){
    	var printed = $('#printed_table').clone()
		printed.find('label').first().remove()
		printed.find('div.dataTables_info').last().remove()
		printed.find('table').attr('border', '1')
		printed.find('table').attr('width', '80%')
		printed.find('div').css("zoom", "90%");
		printed.find('tr').css("background-color", "");
        printed.print();
    })
</script>

<script type="text/javascript">   
  $('input[id="daterange"]').daterangepicker(
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

  $(document).ready(function(){
    var t = $('#tabel_spm').DataTable({
    	dom: 'Bfrtip',
    	paging: false,
    	buttons: [
            'excel',
        ],
    });

    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
  });


</script>

<?php
function up_get_details($no_spm){
    $ci =& get_instance();
    $ci->load->model('Rsa_up_model', 'up_model');
    
    return $ci->up_model->get_data_spm($no_spm);
}
?>