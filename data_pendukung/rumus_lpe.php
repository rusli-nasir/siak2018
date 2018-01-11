<?php
	a = 4 tidak_terikat
	b = 4 terikat_temporer
	c = 5 tidak_terikat
	d = 5 terikat_temporer

	surplus / defisit = (a['nett'] + b['nett']) - (c['nett'] + d['nett'])



	$a = $this->Laporan_model->get_rekap(array(4),null,'kas',null,'sum',tidak_terikat,$start_date,$end_date); 

	===============================================================================================================

	$akun_3 = $this->Laporan_model->get_rekap(array(3),null,'kas',null,'sum',null,$start_date,$end_date); 	

	$akun_3['saldo']
?>