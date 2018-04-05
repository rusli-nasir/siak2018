<script type="text/javascript">

</script>

<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>DAFTAR KUITANSI BELUM SESUAI</h2>    
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
                                        <th>ID Kuitansi</th>
                                        <th>ID Kuitansi Detail</th>
                                        <th>STR NOMOR TRX</th>
                                        <th>Kode Usulan Belanja</th>
                                        <th>Tanggal Kuitansi</th>
                                        <th>Revisi</th>
                                        <th>Impor</th>
                                        <th>Proses</th>
                                                        
                                </tr>
                            </thead>
                            <tbody id="tb-isi" >
                                <?php $no = 1; ?>
                                <?php foreach ($querys as $query): ?>
                                    <tr>
                                        <td><?php echo $no ?></td>
                                        <td><?php echo $query->id_kuitansi ?></td>
                                        <td><?php echo $query->id_kuitansi_detail ?></td>
                                        <td><?php echo $query->str_nomor_trx ?></td>
                                        <td><?php echo $query->kode_usulan_belanja ?></td>
                                        <td><?php echo $query->tgl_kuitansi ?></td>
                                        <td><?php echo $query->revisi ?></td>
                                        <td><?php echo $query->impor ?></td>
                                        <td><?php echo $query->proses ?></td>
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
