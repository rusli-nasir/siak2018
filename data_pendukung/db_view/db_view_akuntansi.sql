CREATE VIEW akuntansi_aset_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_aset_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1;
CREATE VIEW akuntansi_aset_2 AS SELECT DISTINCT kode_akun2digit as id_aset_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_3 AS SELECT DISTINCT kode_akun3digit as id_aset_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_4 AS SELECT DISTINCT kode_akun4digit as id_aset_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_5 AS SELECT DISTINCT kode_akun5digit as id_aset_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_6 AS SELECT DISTINCT kode_akun as id_aset_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1 ORDER BY akun_1;
CREATE VIEW akuntansi_hutang_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_hutang_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2;
CREATE VIEW akuntansi_hutang_2 AS SELECT DISTINCT kode_akun2digit as id_hutang_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2 ORDER BY akun_1;
CREATE VIEW akuntansi_hutang_3 AS SELECT DISTINCT kode_akun3digit as id_hutang_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2 ORDER BY akun_1;
CREATE VIEW akuntansi_hutang_4 AS SELECT DISTINCT kode_akun4digit as id_hutang_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2 ORDER BY akun_1;
CREATE VIEW akuntansi_hutang_5 AS SELECT DISTINCT kode_akun5digit as id_hutang_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2 ORDER BY akun_1;
CREATE VIEW akuntansi_hutang_6 AS SELECT DISTINCT kode_akun as id_hutang_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_bersih_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_aset_bersih_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3;
CREATE VIEW akuntansi_aset_bersih_2 AS SELECT DISTINCT kode_akun2digit as id_aset_bersih_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_bersih_3 AS SELECT DISTINCT kode_akun3digit as id_aset_bersih_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_bersih_4 AS SELECT DISTINCT kode_akun4digit as id_aset_bersih_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_bersih_5 AS SELECT DISTINCT kode_akun5digit as id_aset_bersih_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_bersih_6 AS SELECT DISTINCT kode_akun as id_aset_bersih_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3 ORDER BY akun_1;
CREATE VIEW akuntansi_lra_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_lra_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4;
CREATE VIEW akuntansi_lra_2 AS SELECT DISTINCT kode_akun2digit as id_lra_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4 ORDER BY akun_1;
CREATE VIEW akuntansi_lra_3 AS SELECT DISTINCT kode_akun3digit as id_lra_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4 ORDER BY akun_1;
CREATE VIEW akuntansi_lra_4 AS SELECT DISTINCT kode_akun4digit as id_lra_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4 ORDER BY akun_1;
CREATE VIEW akuntansi_lra_5 AS SELECT DISTINCT kode_akun5digit as id_lra_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4 ORDER BY akun_1;
CREATE VIEW akuntansi_lra_6 AS SELECT DISTINCT kode_akun as id_lra_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4 ORDER BY akun_1;
CREATE VIEW akuntansi_pembiayaan_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_pembiayaan_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8;
CREATE VIEW akuntansi_pembiayaan_2 AS SELECT DISTINCT kode_akun2digit as id_pembiayaan_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8 ORDER BY akun_1;
CREATE VIEW akuntansi_pembiayaan_3 AS SELECT DISTINCT kode_akun3digit as id_pembiayaan_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8 ORDER BY akun_1;
CREATE VIEW akuntansi_pembiayaan_4 AS SELECT DISTINCT kode_akun4digit as id_pembiayaan_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8 ORDER BY akun_1;
CREATE VIEW akuntansi_pembiayaan_5 AS SELECT DISTINCT kode_akun5digit as id_pembiayaan_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8 ORDER BY akun_1;
CREATE VIEW akuntansi_pembiayaan_6 AS SELECT DISTINCT kode_akun as id_pembiayaan_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8 ORDER BY akun_1;
CREATE VIEW akuntansi_sal_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_sal_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9;
CREATE VIEW akuntansi_sal_2 AS SELECT DISTINCT kode_akun2digit as id_sal_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9 ORDER BY akun_1;
CREATE VIEW akuntansi_sal_3 AS SELECT DISTINCT kode_akun3digit as id_sal_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9 ORDER BY akun_1;
CREATE VIEW akuntansi_sal_4 AS SELECT DISTINCT kode_akun4digit as id_sal_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9 ORDER BY akun_1;
CREATE VIEW akuntansi_sal_5 AS SELECT DISTINCT kode_akun5digit as id_sal_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9 ORDER BY akun_1;
CREATE VIEW akuntansi_sal_6 AS SELECT DISTINCT kode_akun as id_sal_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9 ORDER BY akun_1;