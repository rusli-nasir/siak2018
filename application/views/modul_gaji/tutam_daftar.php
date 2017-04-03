<script type="text/javascript">
	$(function(){
		$('.home').on('click', function(e){
			window.location = '<?php echo site_url('tutam'); ?>';
		});
		
		$('.cetak_daftar').on('click', function(e){
			window.location = '<?php echo site_url('tutam/daftar_cetak'); ?>';
		});

		$('.hapus_daftar').on('click', function(e){
			var a=confirm('Hapus daftar ini?\nUntuk memproses daftar kembali, lakukan melalui menu proses data tugas tambahan.');
			if(a){
				$.post('<?php echo site_url('tutam/hapus_daftar_tutam'); ?>',function(r){
					if(!$.isNumeric(r)){
						$('#myModalMsg .body-msg-text').html(r);
						$('#myModalMsg').modal('show');
					}else{
						window.location.reload();
					}
				});
			}
		});
		
		$('#form-tutam-lihat').on('submit',function(e){
			e.preventDefault();
			$('#kriteria_tutam_lihat').modal('hide');
			$.post('<?php echo site_url('tutam/tutam_proses'); ?>',$('#form-tutam-lihat').serialize(),function(data){
				if(data!=1){
					$('#myModalMsg .body-msg-text').html(data);
					$('#myModalMsg').modal('show');
					return false;
				}else{
					window.location='<?php echo site_url('tutam/daftar'); ?>';
					return false;
					//$('#form-ipp')[0].reset();
				}
			});
		});
		
		// modal madul // reset status jika cancel
		$('#kriteria_tutam').on('hidden.bs.modal', function () {
				$('#form-tutam')[0].reset();
		});
		
		$('.opsi-float-bar').on('click',function(){ $('#float-bar').toggle(); });
		
		$('.trash').on('click',function(){
			var a=confirm('Yakin akan menghapus data ini?');
			if(a){
				var id = $(this).attr('id');
				$.post('<?php echo site_url('tutam/tutam_proses'); ?>',{'id':id, 'act':'tutam_hapus_single'},function(data){ 
					if(data!='1'){
						$('#myModalMsg .body-msg-text').html(data); $('#myModalMsg').modal('show');
					}else{
						/*$('#tr_' + id).remove();*/
						window.location.reload();
					}
				});
			}
		});
		
	});
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
					<i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Data Insentif Tugas Tambahan - <a href="<?php echo site_url('modul_gaji'); ?>" title="ke Menu Utama Kepegawaian">Kepegawaian #2</a>
				</h4>
        <p class="text-right">
        	<button type="button" class="btn btn-primary btn-sm home"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;Beranda Insentif Tugas Tambahan</button>
					<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#kriteria_tutam_lihat"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;&nbsp;Lihat Daftar Insentif Tugas Tambahan</button>
				</p>
			</div>
		  <div class="col-md-12 result_data">
				<div class="col-md-12" style="background-color:#ccc;padding:5px;">
        	<div class="text-right" style="position:fixed;top:55%;z-index:1;right:0;">
          	<span id="float-bar" style="display:none;">
              <button type="button" class="btn btn-info btn-sm cetak_daftar" title="Cetak daftar ini"><i class="glyphicon glyphicon-print"></i>&nbsp;&nbsp;&nbsp;Cetak</button>
              <button type="button" class="btn btn-warning btn-sm hapus_daftar" title="Hapus daftar ini"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;&nbsp;Hapus Data Ini</button>
            </span>
            <button type="button" class="btn btn-danger btn-sm opsi-float-bar" title="Opsi untuk daftar yang ada"><i class="glyphicon glyphicon-option-vertical">&nbsp;</i></button>
          </div>
        	<div class="col-md-12" style="background-color:#fff;padding:3px;">
          	<h4 class="text-center">
            	Daftar Penerima Insentif Tugas Tambahan<br/>Universitas Diponegoro<br/>
              Bulan <?php echo $this->cantik_model->wordMonth($_SESSION['tutam']['bulan']); ?> Tahun <?php echo $_SESSION['tutam']['tahun']; ?>
            </h4>

            <table class="table table-bordered table-striped small">
               <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Nama / NIP</th>
                  <th class="text-center">Tugas Tambahan / Unit Asal</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Nama Bank / Rekening</th>
                  <th class="text-center">Nominal TuTam</th>
                  <th class="text-center">Pajak</th>
                  <th class="text-center">Jumlah Pajak</th>
                  <th class="text-center">Netto</th>
                  <th class="text-center">&nbsp;</th>
                </tr>
<?php
					$j = 0;
          $i=1;
          $total = 0;
          $total_pajak = 0;
          $total_selanjutnya = 0;
				if(is_array($dt) && count($dt)>0){
          foreach ($dt as $k => $v) {
          	$rek = $this->cantik_model->get_rekening_tutam($v->nip);
?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $v->nama; ?><br/><?php echo $v->nip; ?>
                  </td>
                  <td><?php echo $v->tugas_tambahan; ?> <?php echo $v->det_tgs_tambahan; ?><br/><?php echo $this->cantik_model->getUnit($v->unit_id);?></td>
                  <td><?php echo $this->cantik_model->getStatus($v->status); ?></td>
                  <td><?php echo $rek->nmbank; ?><br /><?php echo $rek->nmpemilik; ?><br /><?php echo $rek->norekening; ?></td>
                  <td align="right"><?php echo $this->cantik_model->number($v->nominal); ?></td>
                  <td align="right"><?php echo $this->cantik_model->pajak($v->pajak); ?></td>
                  <td align="right"><?php echo $this->cantik_model->number($v->nom_pajak); ?></td>
                  <td align="right"><?php echo $this->cantik_model->number($v->bersih); ?></td>
                  <td><button type="button" class="btn btn-danger btn-sm trash" title="hapus data ini dari daftar" 
                    id="<?php echo $v->id; ?>"><i class="glyphicon glyphicon-trash"></i></button></td>
                </tr>
<?php
						$total+=$v->nominal;
						$total_pajak+=$v->nom_pajak;
						$total_selanjutnya+=$v->bersih;
            $i++;
          }
?>
                <tr>
                  <th colspan="5">&nbsp;</th>
                  <th><?php echo $this->cantik_model->number($total); ?></th>
                  <th>&nbsp;</th>
                  <th><?php echo $this->cantik_model->number($total_pajak); ?></th>
                  <th><?php echo $this->cantik_model->number($total_selanjutnya); ?></th>
                  <th>&nbsp;</th>
                </tr>
<?php
				}else{
?>
        				<tr><td colspan="9" class="alert alert-danger text-center">Tidak ada data Insentif Tugas Tambahan untuk <?php echo $this->cantik_model->wordMonth($_SESSION['tutam']['bulan']); ?> <?php echo $_SESSION['tutam']['tahun']; ?></td></tr>
<?php
				}
?>
        		</table>
					</div>
        </div>
			</div>
		</div>
	</div>
</div>

<!-- /.modal-dialog untuk menambahkan item transaksi-->
<div class="modal fade" id="kriteria_tutam_lihat" tabindex="-1" role="dialog" arialabelledby="myModalLabel">
  <!-- /.modal-content -->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form-tutam-lihat" action="<?php echo site_url('tutam/tutam_proses'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="act" name="act" value="tutam_lihat"/>
        <input type="hidden" id="tahun" name="tahun" value="<?php echo $cur_tahun; ?>"/>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h5 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;Cari Data Insentif Kinerja Wajib</h5>
        </div>
        <div class="modal-body">
          <span class="message"></span>
        	<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tahun Pencairan Tutam:</label>
	              <input type="text" class="form-control input-sm" value="<?php echo $cur_tahun; ?>" readonly="readonly"/>
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
            <!-- <button type="button" class="btn btn-default btn-flat btn-sm lihat_data"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button> -->
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>