<script type="text/javascript">
var status_edit = true;
$(document).ready(function(){
	//action untuk tambah data kegiatan
	$(document).on("click","#add",function(){
	//$("#add").live("click",function(){
		var data=$("#form_add_ikw").serialize();
		if($("#form_add_ikw").validationEngine("validate")){
			$.ajax({
				type:"POST",
				url:"<?=site_url("rsa_ikw/exec_add_ikw")?>",
				data:data,
				success:function(respon){
					if (respon=="berhasil"){
						alert(r);
					} else {
						var r = respon; 
						while (r.search(/<[^>]*>/)!=-1){
							r = r.replace(/<[^>]*>/,'');
						}
						alert(r);
					}
				}
			});
		}
	})
	
	//action untuk mengambil form ubah data ref_akun
	
});

</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                   <h2 align="center">Form Input Data IKW</h2><hr>
                    </div>
 <form id="form_add_ikw" class="form-horizontal col-md-10 col-md-offset-1" onsubmit="return false">
 <div class="form-group">
			<label for="bulan">Id Transaksi</label>
			<input type="text" class="validate[required] form-control" id="id_trans" placeholder="id_trans" ">
		</div>
	<div class="form-group">
			<label for="bulan">Bulan</label>
			<input type="text" class="validate[required] form-control" id="bulan" placeholder="bulan" ">
		</div>
	<div class="form-group">
			<label for="tahun">Tahun</label>
			<input type="text" class="validate[required] form-control" id="tahun" placeholder="tahun">
		</div>
		<div class="form-group">
			<label for="nip">nip</label>
			<input type="text" class="validate[required] form-control" id="nip" placeholder="nip">
		</div>
		
		<div class="form-group">
			<label for="ikw">IKW</label>
			<input type="text" class="validate[required] form-control" id="ikw" placeholder="ikw">
		</div>
		
		<div class="form-group">
			<label for="pot_ikw">Potongan IKW</label>
			<input type="text" class="validate[required] form-control" id="pot_ikw" placeholder="Potongan IKW">
		</div>
		<div class="form-group">
			<label for="bruto">bruto</label>
			<input type="text" class="validate[required] form-control" id="bruto" placeholder="bruto">
		</div>
		<div class="form-group">
			<label for="pajak">Pajak</label>
			<input type="text" class="validate[required] form-control" id="pajak" placeholder="Pajak">
		</div>
		<div class="form-group">
			<label for="jml_pajak">jml_pajak</label>
			<input type="text" class="validate[required] form-control" id="jml_pajak" placeholder="jml_pajak">
		</div>
		<div class="form-group">
			<label for="byr_stlh_pajak">byr_stlh_pajak</label>
			<input type="text" class="validate[required] form-control" id="byr_stlh_pajak" placeholder="byr_stlh_pajak">
		</div>
		<div class="form-group">
			<label for="pot_lainnya">pot_lainnya</label>
			<input type="text" class="validate[required] form-control" id="pot_lainnya" placeholder="pot_lainnya">
		</div>
		<div class="form-group">
			<label for="netto">netto</label>
			<input type="text" class="validate[required] form-control" id="netto" placeholder="netto">
		</div>
    
  <div class="alert alert-warning" style="text-align:center">
    	<button type="submit" id="add" class="btn btn-lg btn-warning">Simpan<span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></button>
  </div>
</form>

  </div>
	  </div>
	  
</div>


