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
                    <td><?php echo $this->cantik2_model->getUnit($v->unitid); ?></td>
                    <td><?php echo $this->cantik2_model->getJabatanPeg($v->pegid)." (".$v->golpeg.")"; ?></td>
                    <td><?php echo $this->cantik2_model->getStatus($v->status); ?></td>
                    <td class="text-right"><?php echo $this->cantik_model->number($v->bruto); ?></td>
                    <td class="text-right">
                    	<a title="NPWP : <?php echo $v->npwp; ?>"><?php echo $this->cantik_model->pajak($v->pajak); ?></a>
											<br />
											Bank: <?php echo $v->bank; ?>
                    </td>
                    <td class="text-right"><?php echo $this->cantik_model->number($v->jml_pajak); ?></td>
                    <td>
                    	<input type="text" name="pot_lainnya[]" id="pot_lainnya_<?php echo $v->id_trans; ?>" class="text-right form-control input-sm pot_lainnya" value="<?php echo $v->pot_lainnya; ?>"/>
                      <input type="hidden" name="pot_lainnya_old[]" value="<?php echo $v->pot_lainnya; ?>" />
                    </td>
                    <td class="text-right"><?php echo $this->cantik_model->number($v->netto); ?></td>
                    <td><button type="button" class="btn btn-danger btn-xs trash" title="hapus data ini dari daftar"
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
