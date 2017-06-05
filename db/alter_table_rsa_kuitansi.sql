ALTER TABLE `rsa_kuitansi` ADD `flag_proses_akuntansi` INT NOT NULL DEFAULT '0' ;
ALTER TABLE `rsa_kuitansi_lsphk3` ADD `flag_proses_akuntansi` INT NOT NULL DEFAULT '0' ;
ALTER TABLE `kepeg_tr_spmls` ADD `flag_proses_akuntansi` INT NOT NULL DEFAULT '0' ;

ALTER TABLE `trx_spm_gup_data` ADD `flag_proses_akuntansi` INT NOT NULL DEFAULT '0' ;
ALTER TABLE `trx_spm_tup_data` ADD `flag_proses_akuntansi` INT NOT NULL DEFAULT '0' ;
ALTER TABLE `trx_spm_tambah_tup_data` ADD `flag_proses_akuntansi` INT NOT NULL DEFAULT '0' ;
ALTER TABLE `trx_spm_tambah_up_data` ADD `flag_proses_akuntansi` INT NOT NULL DEFAULT '0' ;
ALTER TABLE `trx_spm_up_data` ADD `flag_proses_akuntansi` INT NOT NULL DEFAULT '0' ;
ALTER TABLE `trx_spm_lsphk3_data` ADD `flag_proses_akuntansi` INT NOT NULL DEFAULT '0' ;
