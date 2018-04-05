<?php
  // echo "<td>KOPLAK</td>"; exit;
					$j = 0;
          $i=1;
          $total = 0;
          $total_pajak = 0;
          $total_selanjutnya = 0;
				if(is_array($dt) && count($dt)>0){
          foreach ($dt as $k => $v) {
?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $v->nama; ?><br/><?php echo $v->nip; ?>
                  </td>
                  <td><?php echo $v->tugas_tambahan; ?> <?php echo $v->det_tgs_tambahan; ?><br/><?php echo $this->cantik2_model->getUnit($v->unit_id);?></td>
                  <td><?php echo $this->cantik2_model->getStatus($v->status); ?></td>
                  <td><?php echo $v->nmbank; ?><br /><?php echo $v->nmpemilik; ?><br /><?php echo $v->norekening; ?></td>
                  <td align="right"><?php echo $this->cantik_model->number($v->nominal); ?></td>
                  <td align="right"><?php echo $this->cantik_model->pajak($v->pajak); ?></td>
                  <td align="right"><?php echo $this->cantik_model->number($v->nom_pajak); ?></td>
                  <td align="right"><?php echo $this->cantik_model->number($v->bersih); ?></td>
                  <td><button type="button" class="btn btn-danger btn-xs trash" title="hapus data ini dari daftar"
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
        				<tr><td colspan="10" class="alert alert-danger text-center">Tidak ada data Insentif Tugas Tambahan untuk <?php echo $this->cantik_model->wordMonth($_SESSION['tutam']['bulan']); ?> <?php echo $_SESSION['tutam']['tahun']; ?></td></tr>
<?php
				}

?>
