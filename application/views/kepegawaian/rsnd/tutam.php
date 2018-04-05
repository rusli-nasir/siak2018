<style type="text/css">
	._update{
		border-bottom:1px #f00 dashed;
	}
	/*.select2-close-mask{
		z-index: 2099;
	}
	.select2-dropdown{
		z-index: 3051;
	}*/
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
	.list_{
		margin: 0;
		padding: 0;
	}
	.list_ li{
		font-size: .85em;
		list-style: none;
		margin: 0;
		padding: 3px;
		border:1px solid #ccc;
	}
	.list_ li:hover{
		background: #ddd;
	}
</style>

<script type="text/javascript">
	function mwa_ajax(){
		$('#daftar-mwa-ajax').load("<?php echo site_url('tutam_rsnd/daftar_rsnd_ajax'); ?>");
	}

	function selectItem(id){
		$('#yang_dipilih').hide();
		$('#yang_dipilih').html('');
		$('#pegid2').val(id);
		$.post('<?php echo site_url('tutam_rsnd/daftar_rsnd_ajax_pegawai_id'); ?>',{'id':id},function(r){
			console.log(r);
			q = $.parseJSON(r);
			console.log(q);
			if(!$.isEmptyObject(q)){
				$('#nama2').val(q.glr_dpn+' '+q.nama+' '+q.glr_blkg);
				$('#nip2').val(q.nip);
				$('#npwp2').val(q.npwp);
				$('#golongan_id2').val(q.golongan_id);
				$('#status2').val(q.status);
				$('#nmbank2').val(q.kelompok_bank);
				$('#norekening2').val(q.norekening);
				$('#nmpemilik2').val(q.nmpemilik);
				$('#unit_id2').val(q.unit_id);
				$('#jabatan_id2').val(q.jabatan_id);
				$('#tugas_tambahan2').focus();
			}
		});
	}

	$(function(){
		$('#form-tutam').on('submit',function(e){
			e.preventDefault();
			var a = confirm('Yakin memproses data Tugas Tambahan?');
			if(a){
				$('#kriteria_tutam').modal('hide');
				$.post('<?php echo site_url('tutam_rsnd/tutam_proses'); ?>',$('#form-tutam').serialize(),function(data){
					if(data!='1'){
						$('#myModalMsg .body-msg-text').html(data);
						$('#myModalMsg').modal('show');
						return false;
					}else{
						window.location='<?php echo site_url('tutam_rsnd/daftar'); ?>';
						return false;
					}
				});
			}
			return false;
		});

		$('#form-tutam-lihat').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_tutam_lihat').modal('hide');
			$.post('<?php echo site_url('tutam_rsnd/tutam_proses'); ?>',$('#form-tutam-lihat').serialize(),function(data){
				if(data!=1){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					window.location='<?php echo site_url('tutam_rsnd/daftar'); ?>';
					return false;
					//$('#form-ipp')[0].reset();
				}
			});
		});

		$('#mwa_daftar').on('shown.bs.modal',function(e){
			mwa_ajax();
		});

		// $('#mwa_tambah').on('shown.bs.modal',function(e){
		// 	$('#mwa_daftar').modal('hide');
		// });

		$('#_add_mwa').on('submit',function(e){
			e.preventDefault();
			var obj = $(this);
			var data = obj.serialize();
			if(confirm("Yakin akan menyimpan data?")){
				$.post('<?php echo site_url('tutam_rsnd/daftar_rsnd_ajax_add'); ?>',data,function(r){
				if(!$.isNumeric(r)){
					$('#myModalMsg .body-msg-text').html(r);
					$('#myModalMsg').modal('show');
				}else{
					mwa_ajax();
					obj[0].reset();
				}
			});
			}
		});

		$('#nama2').on('keyup',function(e){
			var obj = $(this);
			if(obj.val().length > 0){
				$.post('<?php echo site_url('tutam_rsnd/daftar_rsnd_ajax_pegawai'); ?>',{'q':obj.val()},function(r){
					$('#yang_dipilih').show();
					$('#yang_dipilih').html(r);
				});
			}else{
				$('#yang_dipilih').hide();
				$('#yang_dipilih').html('');
			}
		});

		$('._refresh').on('click',function(e){
			mwa_ajax();
		});
		
	});

	$(document).on('blur','._update',function(e){
		var obj = $(this);
		var rel = obj.attr('rel').split('.');
		var id = rel[1];
		var field = rel[0];
		var value = obj.text();

		$.post('<?php echo site_url('tutam_rsnd/daftar_rsnd_ajax_update'); ?>',{'field':field,'id':id,'value':value},function(r){
			if(!$.isNumeric(r)){
				$('#myModalMsg .body-msg-text').html(r);
				$('#myModalMsg').modal('show');
			}else{
				mwa_ajax();
			}
		});
	});

	$(document).on('change','._update-select',function(e){
		var obj = $(this);
		var rel = obj.attr('rel').split('.');
		var id = rel[1];
		var field = rel[0];
		var value = obj.val();

		$.post('<?php echo site_url('tutam_rsnd/daftar_rsnd_ajax_update'); ?>',{'field':field,'id':id,'value':value},function(r){
			if(!$.isNumeric(r)){
				$('#myModalMsg .body-msg-text').html(r);
				$('#myModalMsg').modal('show');
			}else{
				mwa_ajax();
			}
		});
	});

	$(document).on('click','._delete',function(e){
		var obj = $(this);
		var id = obj.attr('rel');

		if(confirm("Hapus data ini?")){
			$.post('<?php echo site_url('tutam_rsnd/daftar_rsnd_ajax_delete'); ?>',{'id':id},function(r){
				if(!$.isNumeric(r)){
					$('#myModalMsg .body-msg-text').html(r);
					$('#myModalMsg').modal('show');
				}else{
					mwa_ajax();
				}
			});
		}
	});


</script>
<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
$(function(){
    $('.kepeg_numeric').inputmask("numeric", {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 0,
        autoGroup: true,
        rightAlign: true,
        oncleared: function () { $(this).val('0'); }
    });
});
</script>

<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h4 class="page-header">
					<i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Data Insentif Tugas Tambahan (Rumah Sakit Nasional Diponegoro) - <a href="<?php echo site_url('kepegawaian'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #3</a>
				</h4>
				<p class="text-right">
					<button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#mwa_tambah"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;&nbsp;Tambah RSND</button>
					<button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#mwa_daftar"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;&nbsp;Daftar RSND</button>
					<button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_tutam_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Tugas Tambahan</button>
					<button type="button" class="btn btn-primary btn-flat btn-sm" data-toggle="modal" data-target="#kriteria_tutam"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Insentif Tugas Tambahan</button>
				</p>
			</div>
		  <div class="col-md-12 result_data">
				<p class="alert alert-warning text-center"><i class="glyphicon glyphicon-lamp"></i>&nbsp;&nbsp;Gunakan &nbsp;&nbsp;<span class="small text-bold"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Pilih Kriteria Proses Insentif Tugas Tambahan</span>&nbsp;&nbsp; untuk memulai proses data Insentif Tugas Tambahan.</p>
        <pre>
        	<?php //print_r($_SESSION); ?>
        </pre>
			</div>
		</div>
	</div>
</div>



<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_tutam" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-tutam" action="<?php echo site_url('tutam_rsnd/tutam_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="tutam_proses"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Kriteria Proses Insentif Tugas Tambahan</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
          <div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan Tugas Tambahan:</label>
	              <input type="text" class="form-control input-sm" name="tahun" value="<?php if(!isset($_SESSION['tutam_rsnd']['tahun'])){echo $cur_tahun;}else{echo $_SESSION['tutam_rsnd']['tahun'];} ?>" style="text-align:right;"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="bulan">Bulan Pencairan Tugas Tambahan:</label>
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
            <button type="submit" class="btn btn-primary btn-flat btn-sm do_data"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Proses Data</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_tutam_lihat" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-tutam-lihat" action="<?php echo site_url('tutam_rsnd/tutam_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="tutam_lihat"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data Tugas Tambahan</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
        	<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan Tutam:</label>
	              <input type="text" class="form-control input-sm" name="tahun" id="tahun" value="<?php if(!isset($_SESSION['tutam_rsnd']['tahun'])){echo $cur_tahun;}else{echo $_SESSION['tutam_rsnd']['tahun'];} ?>" style="text-align:right;"/>
	            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
		            <label for="bulan">Bulan Pencairan Tutam:</label>
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
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="mwa_daftar" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Daftar Tugas Tambahan RSND</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
        	<div class="row" id="daftar-mwa-ajax">
			</div>
        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
          	<button type="button" class="btn btn-default btn-sm _refresh"><i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;Refresh data</button>
            <button type="button" class="btn btn-default btn-sm _insert" data-toggle="modal" data-target="#mwa_tambah"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;&nbsp;Tambah Tutam RSND</button>
          </div>
        </div>


    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="mwa_tambah" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <form id="_add_mwa">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;&nbsp;Tambah Tutam RSND</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
			<div class="row">
        		<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Nama</span>
						<input type="text" name="nama" id="nama2" class="form-control input-sm"/>
						<div id="yang_dipilih" style="display: none;max-height: 100px;overflow-y: scroll;background: #eee;z-index: 9999;position: fixed;max-width:300px;margin-top:30px;"></div>
						<input type="hidden" name="pegid" id="pegid2"/>
						<input type="hidden" name="unit_id" id="unit_id2"/>
						<input type="hidden" name="jabatan_id" id="jabatan_id2"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">NIP</span>
						<input type="text" name="nip" id="nip2" class="form-control input-sm"/>
					</div>
        		</div>
        		<div class="col-md-4">
        			<div class="input-group">
						<span class="input-group-addon">Gol.</span>
						<?php echo $this->cantik2_model->opsiGolongan('golongan_id','golongan_id2',' form-control input-sm',''); ?>
					</div>
        			<div class="input-group">
						<span class="input-group-addon">Status</span>
						<?php echo $this->cantik2_model->opsiStatus('status','status2',' form-control input-sm',''); ?>
					</div>
        			
        		</div>
        		<div class="col-md-4">
        			<div class="input-group">
						<span class="input-group-addon">Jabatan</span>
						<input type="text" name="tugas_tambahan" id="tugas_tambahan2" class="form-control input-sm"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Unit</span>
						<input type="text" name="det_tgs_tambahan" id="det_tgs_tambahan2" class="form-control input-sm" value="Rumah Sakit Nasional Diponegoro"/>
					</div>
        			
        			
        		</div>
			</div>
			<div class="row">
        		<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">NPWP</span>
						<input type="text" name="npwp" id="npwp2" class="form-control input-sm"/>
					</div>
        		</div>
        		<div class="col-md-4">
        			<div class="input-group">
						<span class="input-group-addon">BANK</span>
						<input type="text" name="nmbank" id="nmbank2" class="form-control input-sm"/>
					</div>
        			<div class="input-group">
						<span class="input-group-addon">No Rek.</span>
						<input type="text" name="norekening" id="norekening2" class="form-control input-sm"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Nama Pem.</span>
						<input type="text" name="nmpemilik" id="nmpemilik2" class="form-control input-sm"/>
					</div>
        			
        		</div>
        		<div class="col-md-4">
        			<div class="input-group">
						<span class="input-group-addon">Nominal</span>
						<input type="text" name="nominal" id="nominal2" class="form-control input-sm kepeg_numeric" value="0"/>
					</div>
        			
        			
        		</div>
			</div>
        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
          	<button type="reset" class="btn btn-default btn-sm _reset"><i class="glyphicon glyphicon-erase"></i>&nbsp;&nbsp;&nbsp;Reset</button>
            <button type="submit" class="btn btn-primary btn-sm _save_insert"><i class="glyphicon glyphicon-save"></i>&nbsp;&nbsp;&nbsp;Simpan Data</button>
          </div>
        </div>
      </form>


    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>