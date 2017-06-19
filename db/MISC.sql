UPDATE rsa_kuitansi SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE rsa_kuitansi_lsphk3 SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE kepeg_tr_spmls SET flag_proses_akuntansi = 0 WHERE 1;

UPDATE trx_spm_gup_data SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_tup_data SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_up_data SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_tambah_up_data SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_tambah_tup_data SET flag_proses_akuntansi = 0 WHERE 1;
UPDATE trx_spm_lsphk3_data SET flag_proses_akuntansi = 0 WHERE 1;

UPDATE trx_spm_gup_data SET flag_proses_akuntansi=0 WHERE CHAR_LENGTH( kode_unit_subunit ) >3
UPDATE trx_spm_up_data SET flag_proses_akuntansi=0 WHERE CHAR_LENGTH( kode_unit_subunit ) >3
UPDATE trx_spm_tup_data SET flag_proses_akuntansi=0 WHERE CHAR_LENGTH( kode_unit_subunit ) >3


SELECT * FROM trx_spm_gup_data WHERE CHAR_LENGTH( kode_unit_subunit ) >3;
SELECT * FROM trx_spm_up_data WHERE CHAR_LENGTH( kode_unit_subunit ) >3;
SELECT * FROM trx_spm_tup_data WHERE CHAR_LENGTH( kode_unit_subunit ) >3;
-- SELECT * FROM trx_spm_tambah_up_data WHERE CHAR_LENGTH( kode_unit_subunit ) >3
-- SELECT * FROM trx_spm_tambah_tup_data WHERE CHAR_LENGTH( kode_unit_subunit ) >3
-- SELECT * FROM trx_spm_lsphk3_data WHERE CHAR_LENGTH( kode_unit_subunit ) >3