<script type="text/javascript" src="<?php echo base_url(); ?>/frontpage/js/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
$(function(){
	$('.home').on('click', function(e){
		window.location = '<?php echo site_url('ikw'); ?>';
	});
	$('.pot_ikw').on('click', function(e){
		window.location = '<?php echo site_url('ikw/daftar_pot'); ?>';
	});
	$('.ikw_jadi').on('click', function(e){
		window.location = '<?php echo site_url('ikw/daftar'); ?>';
	});
	$('.cetak_daftar').on('click', function(e){
		window.location = '<?php echo site_url('ikw/daftar_cetak'); ?>';
	});
	
	$('#form-ikw-lihat').on('submit',function(e){
		e.preventDefault();
		$('#kriteria_ikw_lihat').modal('hide');
		$.post('<?php echo site_url('ikw/ikw_proses'); ?>',$('#form-ikw-lihat').serialize(),function(data){
			if(data!=1){
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
				return false;
			}else{
				window.location='<?php echo site_url('ikw/daftar'); ?>';
				return false;
				//$('#form-ipp')[0].reset();
			}
		});
	});
	
	$('#sword_art_online').on('submit',function(e){
		e.preventDefault();
		$.post('<?php echo site_url('ikw/ikw_proses'); ?>',$('#sword_art_online').serialize(),function(data){
			if(data!=1){
				$('#myModalMsg .body-msg-text').html(data);
				$('#myModalMsg').modal('show');
				return false;
			}else{
				window.location.reload();
				return false;
				//$('#form-ipp')[0].reset();
			}
		});
	});
	
	$('#simpan_pot').on('click',function(e){
		var a=confirm('Yakin menyimpan potongan ini?');
		if(a){
			$('#sword_art_online').submit();
		}
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
	$('#kriteria_ikw').on('hidden.bs.modal', function () {
			$('#form-ikw-lihat')[0].reset();
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
			var id = $(this).attr('id');
			$.post('<?php echo site_url('ikw/ikw_proses'); ?>',{'id':id, 'act':'ikw_hapus_single'},function(data){ 
				if(data!='1'){
					$('#myModalMsg .body-msg-text').html(data); $('#myModalMsg').modal('show');
				}else{
					/*$('#tr_' + id).remove();*/
					window.location.reload();
				}
			});
		}
	});
	
	$('.opsi-float-bar').on('click',function(){ $('#float-bar').toggle(); });
	
	$('.pot_lainnya').inputmask("numeric", {
		radixPoint: ",",
		groupSeparator: ".",
		digits: 0,
		autoGroup: true,
/*		prefix: 'Rp. ', //Space after $, this will not truncate the first character.*/
		rightAlign: true,
		oncleared: function () { self.Value('0'); }
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
					<i class="fa fa-coffee"></i>&nbsp;&nbsp;Data Insentif Kinerja Wajib - <a href="<?php echo site_url('modul_gaji'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #2</a>
				</h4>
				<p class="text-right">
        	<button type="button" class="btn btn-primary btn-sm home"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;Beranda Insentif Kinerja Wajib</button>
					<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#kriteria_ikw_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Kinerja Wajib</button>
				</p>
			</div>
		  <div class="col-md-12">
        <div class="col-md-12" style="background-color:#ccc;padding:5px;">
        	<div class="text-right" style="position:fixed;top:55%;z-index:1;right:0;">
          	<span id="float-bar" style="display:none;">
              <button type="button" class="btn btn-primary btn-sm" id="simpan_pot" title="Simpan data potongan yang sudah dimasukkan"><i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Simpan</button>
              <button type="button" class="btn btn-default btn-sm cetak_daftar" title="Cetak daftar ini"><i class="glyphicon glyphicon-print"></i>&nbsp;&nbsp;&nbsp;Cetak</button>
            </span>
            <button type="button" class="btn btn-danger btn-sm opsi-float-bar" title="Opsi untuk daftar yang ada"><i class="glyphicon glyphicon-option-vertical">&nbsp;</i></button>
          </div>
        	<div class="col-md-12" style="background-color:#fff;padding:3px;">
          	<h4 class="text-center">
            	Daftar Penerima Insentif Kinerja Wajib <?php echo $this->cantik_model->getJenisPeg($_SESSION['ikw']['jnspeg']); ?><br/>Universitas Diponegoro<br/>
              Semester <?php echo $this->cantik_model->wordMonth($_SESSION['ikw']['bulan']); ?> Tahun <?php echo $_SESSION['ikw']['tahun']; ?>
            </h4>
            <p style="font-weight:bold;" class="small">
            	Unit : <?php echo $daftar_unit; ?><br />
              Status Pegawai : <?php echo $daftar_status; ?>
            </p>
            <div>
            	<ul class="nav nav-tabs" role="tablist" id="kentut_tab">
              	<li role="presentation"><a href="javascript:void();" role="tab" data-toggle="tab" aria-expanded="true" data-original-title="" title="Daftar Potongan IKW berdasarkan absensi" class="pot_ikw"><i class="glyphicon glyphicon-list"></i>Pot. IKW</a></li>
                <li role="presentation" class="active"><a href="javascript:void();" role="tab" data-toggle="tab" aria-expanded="true" data-original-title="" title="Daftar IKW hasil jadi" class="ikw_jadi"><i class="glyphicon glyphicon-list"></i>IKW Total</a></li>
              </ul>
            </div>
            <form id="sword_art_online">
            <input type="hidden" name="act" value="ikw_simpan_pot" />
            <table class="table table-bordered table-striped small">
            	<thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Nama/NIP</th>
                  <th class="text-center">Unit</th>
                  <th class="text-center">Jabatan / Gol.</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Bruto</th>
                  <th class="text-center">Pajak</th>
                  <th class="text-center">Jumlah Pajak</th>
                  <th class="text-center" nowrap="nowrap">Potongan Lainnya</th>
                  <th class="text-center">Netto</th>
                  <th>&nbsp;</th>
                </tr>
               </thead>
               <tbody>
<?php
if(isset($dt) && is_array($dt) && count($dt)>0){
	$i=1;
	$total_bruto = 0; $total_pajak = 0; $total_netto = 0; $total_potlainnya = 0;
	foreach($dt as $k => $v){
?>
									<input type="hidden" name="id[]" value="<?php echo $v->id_trans; ?>" />
                  <input type="hidden" name="byr_stlh_pajak[]" value="<?php echo $v->byr_stlh_pajak; ?>" />
                  <tr id="tr_<?php echo $v->id_trans;?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $v->nama; ?><br/><?php echo $v->nip; ?></td>
                    <td><?php echo $v->unit; ?></td>
                    <td><?php echo $v->jabatan." (".$this->cantik_model->getGolongan($v->golongan_id).")"; ?></td>
                    <td><?php echo $this->cantik_model->getStatus($v->status); ?></td>
                    <td class="text-right"><?php echo $this->cantik_model->number($v->bruto); ?></td>
                    <td class="text-right">
                    	<a title="NPWP : <?php echo $v->npwp; ?>"><?php echo $this->cantik_model->pajak($v->pajak); ?></a>
                    </td>
                    <td class="text-right"><?php echo $this->cantik_model->number($v->jml_pajak); ?></td>
                    <td>
                    	<input type="text" name="pot_lainnya[]" id="pot_lainnya_<?php echo $v->id_trans; ?>" class="text-right form-control input-sm pot_lainnya" value="<?php echo $v->pot_lainnya; ?>"/>
                      <input type="hidden" name="pot_lainnya_old[]" value="<?php echo $v->pot_lainnya; ?>" />
                    </td>
                    <td class="text-right"><?php echo $this->cantik_model->number($v->netto); ?></td>
                    <td><button type="button" class="btn btn-danger btn-sm trash" title="hapus data ini dari daftar" 
                    id="<?php echo $v->id_trans; ?>"><i class="glyphicon glyphicon-trash"></i></button></td>
                  </tr>
<?php
		$total_bruto+=$v->bruto;
		$total_pajak+=$v->jml_pajak;
		$total_netto+=$v->netto;
		$total_potlainnya+=$v->pot_lainnya;
		$i++;
	}
?>
									<tr>
                  	<th colspan="5">Total</th>
                    <th class="text-right"><?php echo $this->cantik_model->number($total_bruto); ?></th>
                    <th>&nbsp;</th>
                    <th class="text-right"><?php echo $this->cantik_model->number($total_pajak); ?></th>
                    <th class="text-right"><?php echo $this->cantik_model->number($total_potlainnya); ?></th>
                    <th class="text-right"><?php echo $this->cantik_model->number($total_netto); ?></th>
                    <th>&nbsp;</th>
                  </tr>
<?php
}else{
?>
                  <tr>
                  	<th colspan="11" class="alert alert-warning text-center">
                    	Tidak ditemukan data yang ada pada daftar kriteria ini.
                    </th>
                  </tr>
<?php
}
?>
               </tbody>
            </table>
            </form>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>


<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_ikw_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-ikw-lihat" action="<?php echo site_url('ikw/ikw_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="ikw_lihat"/>
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data Insentif Kinerja Wajib</h5>
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
								$stt = array( '1'=>'Aktif Bekerja', '2'=>'Pensiun', '3'=>'Cuti', '4'=>'Meninggal Dunia', '5'=>'Pindah Instansi Lain', '6'=>'Ijin Belajar', '7'=>'Non Aktif', '8'=>'Diberhentikan', '9'=>'Mengundurkan Diri', '10'=>'Dipekerjakan', '11'=>'Diperbantukan', '12'=>'Tugas Belajar', '13'=>'Diberhentikan sementara' );
								foreach ($stt as $k => $v) {
									$ch = "";
									if(isset($_SESSION['ikw']['status']) && in_array($k,$_SESSION['ikw']['status'])){
										$ch = " checked = \"checked\"";
									}
							?>
		              <div class="small col-md-2 col-sm-6 col-xs-12">
		                <label>
		                  <input type="checkbox" class="status" name="status[]" id="status" value="<?php echo $k; ?>"<?php echo $ch; ?>/>
		                  <?php echo $v; ?>
		                </label>
		              </div>
							<?php
								}
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
                      if(isset($_SESSION['ikw']['jnspeg']) && $_SESSION['ikw']['jnspeg']==$v[0]){
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
								<label>Tahun Pencairan IKW:</label>
	              <input type="text" class="form-control input-sm" value="<?php echo $cur_tahun; ?>" readonly="readonly"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="bulan">Bulan Pencairan IKW:</label>
		            <select name="bulan" id="bulan" class="form-control input-sm">
						<?php
							echo $bulanOption;
						?>
								</select>
		          </div>
						</div>
					</div>

        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-primary btn-flat btn-sm lihat_data"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button>
            <!-- <button type="button" class="btn btn-default btn-flat btn-sm lihat_data"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button> -->
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>