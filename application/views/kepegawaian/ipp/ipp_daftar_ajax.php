<?php

if(isset($dt) && is_array($dt) && count($dt)>0){
	$i=1;
	$total_bruto = 0; $total_pajak = 0; $total_netto = 0;
	foreach($dt as $k => $v){
?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $v->nama; ?><br/><?php echo $v->nip; ?></td>
                    <td><?php echo $this->cantik2_model->getUnit($v->unitid); ?></td>
                    <td><?php echo $v->golpeg; ?></td>
                    <td><?php echo $this->cantik2_model->getStatus($v->status); ?></td>
                    <td><?php echo $this->cantik_model->number($v->ipp); ?></td>
                    <td>
                    	<a title="NPWP : <?php echo $v->npwp; ?>"><?php echo $this->cantik_model->pajak($v->pajak); ?></a>
                    </td>
                    <td><?php echo $this->cantik_model->number($v->potongan); ?></td>
                    <td><?php echo $this->cantik_model->number($v->netto); ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-danger btn-xs trash _tooltip" title="hapus data ini dari daftar"
                    id="<?php echo $v->id_trans; ?>"><i class="glyphicon glyphicon-trash"></i></button>
                    </td>
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