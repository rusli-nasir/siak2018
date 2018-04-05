<script type="text/javascript">
$(function(){
	$('.home').on('click', function(e){
		window.location = '<?php echo site_url('modul_gaji/ipp'); ?>';
	});

	$('.cetak_daftar').on('click', function(e){
		window.location = '<?php echo site_url('modul_gaji/daftar_cetak'); ?>';
	});

	$('.lihat_data').on('click',function(e){
		$('#kriteria_ipp_lihat').modal('hide');
		$.post($('#form-ipp-lihat').attr('action'),$('#form-ipp-lihat').serialize(),function(data){
			if(data!=1){
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
			}else{
				window.location.reload();
			}
		});
	});

	// checkbox
	$('#master_unit_id').change(function () {
		if ($(this).prop('checked')) {
				$('.unit_id:checkbox').prop('checked', true);
		} else {
				$('.unit_id:checkbox').prop('checked', false);
		}
		cek_checked();
	});
	//$('#master_unit_id').trigger('change');
	// checkbox
	$('#master_status_kepeg').change(function () {
		if ($(this).prop('checked')) {
				$('.status_kepeg:checkbox').prop('checked', true);
		} else {
				$('.status_kepeg:checkbox').prop('checked', false);
		}
		cek_checked();
	});
	//$('#master_status_kepeg').trigger('change');
	// checkbox
	$('#master_status').change(function () {
		if ($(this).prop('checked')) {
				$('.status:checkbox').prop('checked', true);
		} else {
				$('.status:checkbox').prop('checked', false);
		}
		cek_checked();
	});
	//$('#master_status').trigger('change');

	// modal madul // reset status jika cancel
	$('#kriteria_ipp').on('hidden.bs.modal', function () {
			$('#form-ipp-lihat')[0].reset();
			cek_checked();
	});

	$('input[type=checkbox]').each(function(){
		$(this).on('change',function(){
			cek_checked();
		});
	});

	cek_checked();

	$('.trash').on('click',function(){
		var a=confirm('Yakin akan menghapus data ini?');
		if(a){
		$.post('<?php echo site_url('modul_gaji/ipp_proses'); ?>',{'id':$(this).attr('id'), 'act':'ipp_hapus_single'},function(data){
			if(data!='1'){$('#myModalMsg .body-msg-text').html(data);$('#myModalMsg').modal('show');}else{
				window.location.reload();}});
		}
	});

});

function cek_checked(){
	$('input[type=checkbox]').each(function () {
			this.checked ? $(this).parent().addClass('color-red') : $(this).parent().removeClass('color-red');
	});
}
</script>
<style type="text/css">
	.scroll-150{
    overflow-x:hidden;max-height:100px;
  }
  .input-group-addon{
  	min-width: inherit;
  }
	label{
		cursor:pointer;
	}
	.color-red{
		color:#f00;
		font-weight:normal;
	}
</style>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h4 class="page-header">
					<i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Data Insentif Perbaikan Penghasilan - <a href="<?php echo site_url('modul_gaji'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #2</a>
				</h4>
				<p class="text-right">
        	<button type="button" class="btn btn-primary btn-sm home"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;Beranda Insentif Perbaikan Penghasilan</button>
					<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#kriteria_ipp_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Perbaikan Penghasilan</button>
				</p>
			</div>
		  <div class="col-md-12">
        <div class="col-md-12" style="background-color:#ccc;padding:5px;">
        	<p class="text-right">
            <button type="button" class="btn btn-default btn-sm cetak_daftar"><i class="glyphicon glyphicon-print"></i>&nbsp;&nbsp;&nbsp;Cetak daftar ini</button>
          </p>
        	<div class="col-md-12" style="background-color:#fff;padding:3px;">
          	<h4 class="text-center">
            	Daftar Penerima Insentif Perbaikan Penghasilan <?php echo $this->cantik_model->getJenisPeg($_SESSION['ipp']['jnspeg']); ?><br/>Universitas Diponegoro<br/>
              Semester <?php echo $this->cantik_model->getSemester($_SESSION['ipp']['semester']); ?> Tahun <?php echo $_SESSION['ipp']['tahun']; ?>
            </h4>
            <p style="font-weight:bold;" class="small">
            	Unit : <?php echo $daftar_unit; ?><br />
              Status Pegawai : <?php echo $daftar_status; ?>
            </p>
            <table class="table table-bordered table-striped small">
            	<thead>
                <tr>
                  <th>No</th>
                  <th>Nama/NIP</th>
                  <th>Unit</th>
                  <th>Gol.</th>
                  <th>Status</th>
                  <th>Bruto</th>
                  <th>Pajak</th>
                  <th>Jumlah Pajak</th>
                  <th>Netto</th>
                  <th>&nbsp;</th>
                </tr>
               </thead>
               <tbody>
<?php
if(isset($dt) && is_array($dt) && count($dt)>0){
	$i=1;
	$total_bruto = 0; $total_pajak = 0; $total_netto = 0;
	foreach($dt as $k => $v){
?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $v->nama; ?><br/><?php echo $v->nip; ?></td>
                    <td><?php echo $v->unit; ?></td>
                    <td><?php echo $this->cantik_model->getGolongan($v->golongan_id); ?></td>
                    <td><?php echo $this->cantik_model->getStatus($v->status); ?></td>
                    <td><?php echo $this->cantik_model->number($v->ipp); ?></td>
                    <td>
                    	<a title="NPWP : <?php echo $v->npwp; ?>"><?php echo $this->cantik_model->pajak($v->pajak); ?></a>
                    </td>
                    <td><?php echo $this->cantik_model->number($v->potongan); ?></td>
                    <td><?php echo $this->cantik_model->number($v->netto); ?></td>
                    <td><button type="button" class="btn btn-danger btn-sm trash" title="hapus data ini dari daftar"
                    id="<?php echo $v->id_trans; ?>"><i class="glyphicon glyphicon-trash"></i></button></td>
                  </tr>
<?php
		$total_bruto+=$v->ipp;
		$total_pajak+=$v->potongan;
		$total_netto+=$v->netto;
		$i++;
	}
?>
									<tr>
                  	<th colspan="5">Total</th>
                    <th><?php echo $this->cantik_model->number($total_bruto); ?></th>
                    <th>&nbsp;</th>
                    <th><?php echo $this->cantik_model->number($total_pajak); ?></th>
                    <th><?php echo $this->cantik_model->number($total_netto); ?></th>
                    <th>&nbsp;</th>
                  </tr>
<?php
}else{
?>
                  <tr>
                  	<th colspan="10" class="alert alert-warning text-center">
                    	Tidak ditemukan data yang ada pada daftar kriteria ini.
                    </th>
                  </tr>
<?php
}
?>
               </tbody>
            </table>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>


<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ipp_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ipp-lihat" action="<?php echo site_url('modul_gaji/ipp_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ipp_lihat"/>
        <!-- <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/> -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data Insentif Perbaikan Penghasilan</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
          <div class="row">
          	<div class="col-md-12 col-xs-12">
		          <div class="form-group">
		            <label for="unit_id">Unit Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" id="master_unit_id"/>&nbsp;cek semua</label></label>
		            <div class="row">
                	<?php echo $unitList; ?>
                </div>
		          </div>
	        	</div>
          </div>
          <div class="row">
	        	<div class="col-md-12 col-xs-12">
							<div class="form-group">
		            <label for="status_kepeg">Status Kepegawaian:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" id="master_status_kepeg"/>&nbsp;cek semua</label></label>
                <div class="row">
                  <?php echo $statusKepegOption; ?>
                </div>
		          </div>
		        </div>
		      </div>
		      <div class="row">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-12">
										<label>Status Pegawai:&nbsp;<label class="small" style="background-color:#eee;padding:3px;vertical-align:center;"><input type="checkbox" id="master_status"/>&nbsp;cek semua</label></label>
									</div>
								</div>
								<div class="col-md-12">
	            <?php
							/*
								$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar', '13'=>'Diberhentikan sementara');
								foreach ($stt as $k => $v) {
									$ch = "";
									if(isset($_SESSION['ipp']['status']) && in_array($k,$_SESSION['ipp']['status'])){
										$ch = " checked = \"checked\"";
									}
							?>
		              <div class="small col-md-3 col-sm-6 col-xs-12">
		                <label>
		                  <input type="checkbox" class="status" name="status[]" id="status" value="<?php echo $k; ?>"<?php echo $ch; ?>/>
		                  <?php echo $v; ?>
		                </label>
		              </div>
							<?php
								}
								*/
								echo $this->cantik_model->opsiStatusKepeg($_SESSION['ipp']['status']);
							?>
								</div>
							</div>
	          </div>
	        </div>
        	<div class="row">
          	<div class="col-md-4">
            	<div class="form-group">
                <label for="jnspeg">Jenis Pegawai:</label>
                <select name="jnspeg" id="jnspeg" class="form-control input-sm">
                  <?php
                    $_jenispeg = array(array(1,'Dosen Pengajar'),array(2,'Tenaga Kependidikan'));
                    foreach ($_jenispeg as $k => $v) {
                      $_s = "";
                      if(isset($_SESSION['ipp']['jnspeg']) && $_SESSION['ipp']['jnspeg']==$v[0]){
                        $_s = " selected";
                      }
                  ?>
                  <option value="<?php echo $v[0]; ?>"<?php echo $_s; ?>><?php echo $v[1]; ?></option>
                  <?php

                    }
                  ?>
                </select>
              </div>
            </div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan IPP:</label>
	              <input type="text" class="form-control input-sm" value="<?php echo $_SESSION['ipp']['tahun']; ?>" name="tahun" id="tahun"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="tahun">Semester Pencairan IPP:</label>
		            <select name="semester" id="semester" class="form-control input-sm">
						<?php
							foreach (array(array(1,'Ganjil'),array(2,'Genap')) as $k => $v) {
								$_s = "";
								if(isset($_SESSION['ipp']['semester']) && $_SESSION['ipp']['semester']==$v[0]){
									$_s = " selected=\"selected\"";
								}
						?>
									<option value="<?php echo $v[0]; ?>"<?php echo $_s; ?>><?php echo $v[1]; ?></option>
						<?php
							}
						?>
								</select>
		          </div>
						</div>
					</div>

        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-primary btn-flat btn-sm lihat_data"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
