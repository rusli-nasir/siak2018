<script type="text/javascript">

</script>

<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>DAFTAR BELANJA BELUM SESUAI</h2>    
                    </div>
                </div>
                <hr />
                <div class="row">  
                    <div class="col-lg-12">

                    
            <div id="temp" style="display:none"></div>
                        <div id="o-table">
                        <table class="table table-striped">
                            <thead>
                                <tr >
                                        <th class="col-md-0.5" >No</th>
                                        <th class="col-md-2" >Kode Usulan Belanja</th>
                                        <th class="col-md-4" >Deskripsi</th>
                                        <th class="col-md-2" >Sumber Dana</th>
                                        <th class="col-md-2" >Tanggal Transaksi</th>
                                        <th class="col-md-2" >Tanggal Impor</th>
                                        
                                </tr>
                            </thead>
                            <tbody id="tb-isi" >
                                <?php $no = 1; ?>
                                <?php foreach ($querys as $query): ?>
                                    <tr>
                                        <?php $thun = substr($query->tanggal_transaksi, 0,-15)  ?>
                                        <?php $thun1 = substr($query->tanggal_impor, 0,-15)  ?>
                                        <?php if ($thun == '2018'): ?>
                                            <?php $warna = 'class= text-danger bgcolor="#FFF0F5"' ?>

                                        <?php else: ?>
                                            <?php $warna = ''?>
                                        <?php endif ?>

                                          <?php if ($thun1 == '2018'): ?>
                                            <?php $w1arna = 'class= text-danger bgcolor="#FFF0F5"' ?>
                                        <?php else: ?>
                                            <?php $w1arna = ''?>
                                        <?php endif ?>

                                        <td><?php echo $no ?></td>
                                        <td><?php echo $query->kode_usulan_belanja ?></td>
                                        <td><?php echo $query->deskripsi ?></td>
                                        <td><?php echo $query->sumber_dana ?></td>
                                        <td <?php echo $warna ?>><b><?php echo $query->tanggal_transaksi ?></b></td>
                                        <td <?php echo $w1arna ?>><b><?php echo $query->tanggal_impor ?></b></td>
                                  </tr>
                                  <?php $no ++; ?>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>


    
                        </div>

        </div>
      </div>
</div>
