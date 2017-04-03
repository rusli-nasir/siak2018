$(document).ready(function(){
	var host = location.protocol + '//' + location.host + '/ulp_undip/index.php/';
	//get kegiatan
	$("#subunit").change(function(){
		var subunit = $(this).val();
		$.ajax({
			url:host+'pagu/get_kegiatan/'+subunit,
			data:{},
			success:function(data){
				$("#kegiatan").html(data);
				$("#output").html('<option value="">----</option>');
				$("#suboutput").html('<option value="">----</option>');
				$("#komponen_input").html('<option value="">----</option>');
				$("#subkomponen_input").html('<option value="">----</option>');
				$("#akun_belanja").html('<option value="">----</option>');
				$("#detail_belanja").html('');
				get_pagu_total();
			}
		});
	});
	//get output
	$("#kegiatan").change(function(){
		var kode_kegiatan = $(this).val();
		var kode_subunit = $("#subunit").val();
		$.ajax({
			url:host+'pagu/get_output/'+kode_kegiatan+'/'+kode_subunit,
			data:{},
			success:function(data){
				$("#output").html(data);
				$("#suboutput").html('<option value="">----</option>');
				$("#komponen_input").html('<option value="">----</option>');
				$("#subkomponen_input").html('<option value="">----</option>');
				$("#akun_belanja").html('<option value="">----</option>');
				$("#detail_belanja").html('');
				get_pagu_total();
			}
		});
	});
	//get suboutput & komponen input dll
	$("#output").change(function(){
		var kode_subunit = $("#subunit").val();
		var kode_kegiatan = $("#kegiatan").val();
		var kode_output = $(this).val();
		$.ajax({
			url:host+'pagu/get_suboutput/'+kode_subunit+'/'+kode_kegiatan+'/'+kode_output,
			data:{},
			success:function(data){
				$("#suboutput").html(data);
				$("#komponen_input").html('<option value="">----</option>');
				$("#subkomponen_input").html('<option value="">----</option>');
				$("#akun_belanja").html('<option value="">----</option>');
				$("#detail_belanja").html('');
				get_pagu_total();
			}
		});
	});
	$("#suboutput").change(function(){
		var kode_subunit = $("#subunit").val();
		var kode_kegiatan = $("#kegiatan").val();
		var kode_output = $("#output").val();
		var kode_suboutput = $(this).val();
		$.ajax({
			url:host+'pagu/get_komponeninput/'+kode_subunit+'/'+kode_kegiatan+'/'+kode_output+'/'+kode_suboutput,
			data:{},
			success:function(data){
				$("#komponen_input").html(data);
				$("#subkomponen_input").html('<option value="">----</option>');
				$("#akun_belanja").html('<option value="">----</option>');
				$("#detail_belanja").html('');
				get_pagu_total();
			}
		});
	});
	//get sub komponen input
	$("#komponen_input").change(function(){
		var kode_subunit = $("#subunit").val();
		var kode_kegiatan = $("#kegiatan").val();
		var kode_output = $("#output").val();
		var kode_suboutput = $("#suboutput").val();
		var kode_komponen = $(this).val();
		$.ajax({
			url:host+'pagu/get_subkomponeninput/'+kode_subunit+'/'+kode_komponen+'/'+kode_output+'/'+kode_kegiatan+'/'+kode_suboutput,
			data:{},
			success:function(data){
				$("#subkomponen_input").html(data);
				$("#akun_belanja").html('<option value="">----</option>');
				$("#detail_belanja").html('');
				get_pagu_total();
			}
		});
	});
	//get akun belanja
	$("#subkomponen_input").change(function(){
		var kode_subunit = $("#subunit").val();
		var kode_kegiatan = $("#kegiatan").val();
		var kode_output = $("#output").val();
		var kode_suboutput = $("#suboutput").val();
		var kode_komponen = $("#komponen_input").val();
		var kode_subkomponen = $(this).val();
		var sumber_dana = $("#sumber_dana").val();
		$.ajax({
			url:host+'pagu/get_akun_belanja/'+kode_subunit+'/'+kode_kegiatan+'/'+kode_output+'/'+kode_suboutput+'/'+kode_komponen+'/'+kode_subkomponen+'/'+sumber_dana,
			data:{},
			success:function(data){
				$("#akun_belanja").html(data);
				$("#detail_belanja").html('');
				get_pagu_total();
			}
		});
	});
	/*$("#akun_belanja").change(function(){
		var kode_subunit = $("#subunit").val();
		var kode_kegiatan = $("#kegiatan").val();
		var kode_output = $("#output").val();
		var kode_suboutput = $("#suboutput").val();
		var kode_komponen = $("#komponen_input").val();
		var kode_subkomponen = $("#subkomponen_input").val();
		var akun_belanja = $(this).val();
		$.ajax({
			url:host+'pagu/get_detail_belanja/'+kode_subunit+'/'+kode_kegiatan+'/'+kode_output+'/'+kode_suboutput+'/'+kode_komponen+'/'+kode_subkomponen+'/'+akun_belanja,
			data:{},
			success:function(data){
				$("#detail_belanja").html(data);
				get_pagu_total();
			}
		});
	});*/
});
