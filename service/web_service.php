<?php 
header('Content-Type: application/json');
require_once "koneksi.php";
require_once "detail.php"; //load Class MhsWebService
$hasil  = array();

$s_kode_usulan_belanja = $_GET['kode_usulan_belanja'];
$s_deskripsi = $_GET['deskripsi'];
$s_API  = $_GET['API'];

$detail = new DetailWebService();

if($detail->validateAPI($s_API)){
    
    //kirim params" nya
    $detail->setKode_usulan_belanja($s_kode_usulan_belanja);
    $detail->setDeskripsi($s_deskripsi);
    
    $data = $detail->getDetail();
    //print_r($data);
    reset($data);
    $i=0;
    //saya pake while, klo mau foreach silahkan :D
    while(list(,$r) =  each($data)){
	
        $hasil[$i]['kode_usulan_belanja'] = $r->kode_usulan_belanja;
        $hasil[$i]['deskripsi'] = $r->deskripsi;
		$hasil[$i]['sumber_dana'] = $r->sumber_dana;
		$hasil[$i]['volume'] = $r->volume;
		$hasil[$i]['satuan'] = $r->satuan;
		$hasil[$i]['harga_satuan'] = $r->harga_satuan;
		$hasil[$i]['tahun'] = $r->tahun;
		$hasil[$i]['username'] = $r->username;
		$hasil[$i]['tanggal_transaksi'] = $r->tanggal_transaksi;
		$hasil[$i]['flag_cetak'] = $r->flag_cetak;
		$hasil[$i]['revisi'] = $r->revisi;
		$hasil[$i]['kode_akun_tambah'] = $r->kode_akun_tambah;
		$hasil[$i]['impor'] = $r->impor;
		$hasil[$i]['tanggal_impor'] = $r->tanggal_impor;
		$hasil[$i]['proses'] = $r->proses;
		
        
        ++$i;
    }
   
   //hanya utk flag saja
   $hasil['status'] = TRUE;
    
}else{
    
    $hasil['status'] = FALSE;
}

echo json_encode($hasil);

?>