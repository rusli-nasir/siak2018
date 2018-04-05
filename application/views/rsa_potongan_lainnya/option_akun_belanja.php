	<option value="">- Pilih Data Belanja Untuk Kelebihan Pembayaran -</option>
<?php foreach ($data_belanja as $data): ?>
	<option value="<?php echo $data->full_kode_usulan_belanja ?>" style="font-weight: bold;" >[<?php echo $data->kode_usulan_belanja ?>] <?php echo $data->nama_akun ?>, <?php echo $data->deskripsi ?></option>
<?php endforeach ?>