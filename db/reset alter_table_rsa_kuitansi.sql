UPDATE rsa_kuitansi SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE rsa_kuitansi_lsphk3 SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE kepeg_tr_spmls SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_gup_data SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_tup_data SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_tambah_up_data SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_tambah_tup_data SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_up_data SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_lsphk3_data SET flag_proses_akuntansi = 0 WHERE 1;

TRUNCATE TABLE akuntansi_kuitansi_jadi;
TRUNCATE TABLE akuntansi_relasi_kuitansi_akun;