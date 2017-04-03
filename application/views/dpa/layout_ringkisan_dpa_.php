<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<table id="rekap" style="font-family:tahoma;font-size:14px; border-collapse: separate;width: auto;" cellspacing="0px" border="1">
		<tbody>
			<tr>
				<td colspan="<?=8+count($akun_dipakai)?>" align="center" border="2">
				<b>RINGKASAN<br>
				DOKUMEN PELAKSANAAN ANGGARAN (DPA) SUKPA<BR>
				UNIVERSITAS DIPONEGORO TA 2017<br>
				NOMOR : /DPA/2017 TANGGAL:</b></td>
			</tr>
			<tr>
				<td colspan="<?=8+count($akun_dipakai)?>" align="center"><b>TAHUN ANGGARAN <?=$tahun?></b></td>
			</tr>
			<tr>
				<td colspan="<?=8+count($akun_dipakai)?>" align="center"><b>SUMBER DANA <?=$sumber_dana?></b></td>
			</tr>
			<tr>
				<td >UNIT KERJA</td>
				<td colspan="<?=7+count($akun_dipakai)?>">: <?=$unit?> (<?=$kode_unit?>)</td>
			</tr>
			<tr>
				<td >TOTAL ANGGARAN</td>
				<td colspan="<?=7+count($akun_dipakai)?>">: Rp. <span class="total_global_0">0</span><?php // echo number_format($total_anggaran, 0, ",", ".");?></td>
			</tr>
			<tr>
				<td style="text-align:center" rowspan="2"><b>TUJUAN/SASARAN</b></td>
				<td style="text-align:center" rowspan="2"><b>PROGRAM</b></td>
				<td style="text-align:center" rowspan="2"><b>KEGIATAN</b></td>
				<td style="text-align:center" rowspan="2"><b>SUB KEGIATAN</b></td>
				<td style="text-align:center" rowspan="2"><b>SUB UNIT KERJA</b></td>
				<td style="text-align:center" colspan="2" ><b>TARGET</b></td>
				<?php if(count($akun_dipakai)>0){ ?>
				<td style="text-align:center" colspan="<?=count($akun_dipakai)?>" ><b>AKUN</b></td>
				<?php }?>
				<td style="text-align:center" rowspan="2" ><b>JUMLAH</b></td>
			</tr>
			<tr>
				<td style="text-align:center" ><b>VOLUME</b></td>
				<td style="text-align:center" ><b>SATUAN</b></td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style="text-align:center" ><b><?=$akun?></b></td>
				<?php } ?>
			</tr>

			<?php $n = 0;?>
			<?php $check_kode_1  = array(); ?>
			<?php $check_kode_2  = array(); ?>
			<?php $check_kode_3  = array(); ?>
			<?php $check_kode_4  = array(); ?>
			<?php $check_kode_5  = array(); ?>

			<?php $check_unit_ = array() ;?>

			<?php $check_user = array() ; ?>
                        
                        <?php $check_user_sub_subunit = array() ; ?>

			<?php foreach($kode as $k){?>

			<?php $is_exist = false ; ?>

			<?php foreach($data_detail_belanja as $dt){

					if(!empty($dt)){
						foreach($dt as $d_){
							if(substr($d_->kode_usulan_belanja,0,16)==$k['kode_subkomponen_input']){
								$is_exist = true;
								break;
							}

						}
					} 

			 } ?>

			<?php if($is_exist){ ?>

			<?php if (!(in_array($rincian_kode_usulan[$n]->kode_kegiatan, $check_kode_1))){ ?>
			<tr class="alert alert-danger" style="font-weight: bold;font-size: 18px;" >
				<td colspan="3" >Tujuan : (<?=$rincian_kode_usulan[$n]->kode_kegiatan?>) <?=$rincian_kode_usulan[$n]->nama_kegiatan?></td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="1" class="kegiatan_<?=$akun.substr($k['kode_subkomponen_input'],6,2)?>">0</td>
				<?php } ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="0" class="kegiatan_<?=substr($k['kode_subkomponen_input'],6,2)?>">0</td>
			</tr>
			<?php $check_kode_1[] = $rincian_kode_usulan[$n]->kode_kegiatan; $check_kode_2  = array(); $check_kode_3  = array(); $check_kode_4  = array(); $check_kode_5  = array(); $check_user = array() ; $check_user_sub_subunit = array() ; }else{  }?>

			<?php if (!(in_array($rincian_kode_usulan[$n]->kode_output, $check_kode_2))){ ?>
			<tr class="alert alert-success" style="font-weight: bold;font-size: 16px;">
				<td colspan="3" >(<?=$rincian_kode_usulan[$n]->kode_output?>) <?=$rincian_kode_usulan[$n]->nama_output?></td>
				<td >&nbsp;</td> 
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=$akun.substr($k['kode_subkomponen_input'],6,2)?>" class="output_<?=$akun.substr($k['kode_subkomponen_input'],6,4)?>">0</td>
				<?php } ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=substr($k['kode_subkomponen_input'],6,2)?>" class="output_<?=substr($k['kode_subkomponen_input'],6,4)?>">0</td>
			</tr>
			<?php $check_kode_2[] = $rincian_kode_usulan[$n]->kode_output; $check_kode_3  = array(); $check_kode_4  = array(); $check_kode_5  = array(); $check_user = array() ; $check_user_sub_subunit = array() ; }else{  }?>
			
			<?php if (!(in_array($rincian_kode_usulan[$n]->kode_program, $check_kode_3))){ ?>
			<tr class="alert alert-warning" style="font-weight: bold;font-style: italic;font-size: 16px;">
				<td >&nbsp;</td>
				<td colspan="2" >(<?=$rincian_kode_usulan[$n]->kode_program?>) <?=$rincian_kode_usulan[$n]->nama_program?></td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=$akun.substr($k['kode_subkomponen_input'],6,4)?>" class="program_<?=$akun.substr($k['kode_subkomponen_input'],6,6)?>">0</td>
				<?php } ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=substr($k['kode_subkomponen_input'],6,4)?>" class="program_<?=substr($k['kode_subkomponen_input'],6,6)?>">0</td>
			</tr>
			<?php $check_kode_3[] = $rincian_kode_usulan[$n]->kode_program; $check_kode_4  = array(); $check_kode_5  = array(); $check_user = array() ; $check_user_sub_subunit = array() ; }else{  }?>

			<?php if (!(in_array($rincian_kode_usulan[$n]->kode_komponen, $check_kode_4))){ ?>
			<tr class="alert alert-info" style="font-weight: bold;font-size: 14px;">
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >(<?=$rincian_kode_usulan[$n]->kode_komponen?>) <?=$rincian_kode_usulan[$n]->nama_komponen?></td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=$akun.substr($k['kode_subkomponen_input'],6,6)?>" class="komponen_<?=$akun.substr($k['kode_subkomponen_input'],6,8)?>">0</td>
				<?php } ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=substr($k['kode_subkomponen_input'],6,6)?>" class="komponen_<?=substr($k['kode_subkomponen_input'],6,8)?>">0</td>
			</tr>
			<?php $check_kode_4[] = $rincian_kode_usulan[$n]->kode_komponen; $check_kode_5  = array(); $check_user = array() ; $check_user_sub_subunit = array() ; }else{ }?>
			<?php if (!(in_array($rincian_kode_usulan[$n]->kode_subkomponen, $check_kode_5))){ ?>
			<tr class="alert bg-ijo-pupus" style="font-weight: bold;font-style: italic;font-size: 14px;">
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >(<?=$rincian_kode_usulan[$n]->kode_subkomponen?>) <?=$rincian_kode_usulan[$n]->nama_subkomponen?></td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
				<?php foreach($akun_dipakai as $akun) { ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=$akun.substr($k['kode_subkomponen_input'],6,8)?>" class="subkomponen_<?=$akun.substr($k['kode_subkomponen_input'],6,10)?>">0</td>
				<?php } ?>
				<td style='text-align: right;mso-number-format:"\@";' rel="<?=substr($k['kode_subkomponen_input'],6,8)?>" class="subkomponen_<?=substr($k['kode_subkomponen_input'],6,10)?>">0</td>
			</tr>
			<?php $check_kode_5[] = $rincian_kode_usulan[$n]->kode_subkomponen; $check_user = array() ; $check_user_sub_subunit = array() ; }else{ }?>

			<?php $i = 1 ; ?>
			<?php $check_unit = '';?>
			<?php $sub_total = 0 ; ?>
			<?php foreach($data_detail_belanja[$n] as $detail_belanja) { ?>

				<?php // if($check_unit != $detail_belanja->username) { ?>

				<?php if (!(in_array(substr($detail_belanja->username,0,4), $check_user))){ ?>

				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td ><b><?php echo get_unit_name(substr($detail_belanja->username,0,4)) ;?></b></td>
					<td class="total_volume_<?=substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,4)?>">0</td>
					<td ><?=$k['indikator_keluaran']?></td>
					<?php foreach($akun_dipakai as $akun) { ?>
					<td style='text-align: right;mso-number-format:"\@";' rel="<?=$akun.substr($k['kode_subkomponen_input'],6,10)?>" class="akun_<?=$akun.substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,4)?>">0</td>
					<?php } ?>
					<td style='text-align: right;mso-number-format:"\@";' rel="<?=substr($k['kode_subkomponen_input'],6,10)?>"  class="akun_<?=substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,4)?>">0</td>
				</tr>

				<?php } ?>
                                
                                <?php if (!(in_array(substr($detail_belanja->username,0,6), $check_user_sub_subunit))){ ?>
                                    
                                    <tr class="ishidden" rel="<?=$i?>" style="display: none">
                                        <td rel="<?=substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,4)?>" colspan="<?php echo 8 + count($akun) ; ?>" class="total_sub_volume_<?=substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,6)?>"><?=$k['volume']?></td>
                                    </tr>
                                    <?php $check_user_sub_subunit[] = substr($detail_belanja->username,0,6); ?>
                                <?php } ?>

				<tr class="ishidden" rel="<?=$i?>" style="display: none">
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td > - <?=$detail_belanja->deskripsi?></td>
					<td ><?=$detail_belanja->volume?></td>
					<td ><?=$detail_belanja->satuan?></td>
					<?php foreach($akun_dipakai as $akun) { ?>
						<?php if($akun == $detail_belanja->kode_akun){ ?>
							<td rel="<?=$akun.substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,4)?>" class="total_sub_akun_<?=$akun.substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,4)?>"><?=$detail_belanja->volume*$detail_belanja->harga_satuan?></td>
							<?php $sub_total = $sub_total + ($detail_belanja->volume*$detail_belanja->harga_satuan) ?>
						<?php }else{ ?>
							<td rel="<?=$akun.substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,4)?>" class="total_sub_akun_<?=$akun.substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,4)?>">0</td>
						<?php } ?>
					<?php } ?>
					<td rel="<?=substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,4)?>" class="total_sub_akun_<?=substr($k['kode_subkomponen_input'],6,10).substr($detail_belanja->username,0,4)?>"><?php echo $sub_total; ?></td>
				</tr>

				<?php $sub_total = 0 ; ?>

				<?php $check_unit = $detail_belanja->username; ?>

				<?php $check_user[] = substr($detail_belanja->username,0,4); ?>

			<?php $i++ ; ?>

			<?php } ?>
			
			<?php } ?>

			<?php $n++ ; ?>

			<?php } ?>
			
		</tbody>
	</table>