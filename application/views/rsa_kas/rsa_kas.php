<script type="text/javascript">


$(document).ready(function(){

	var total_rsa_kas = $("#total_rsa_kas").text();
	
//	var total_setting_setting_up = $("#total_setting_setting_up").text();


	//$("#total_sisa_setting_up").text(angka_to_string(string_to_angka(total_setting_setting_up) - string_to_angka(total_setting_up)));


	$('input[type="text"]').focusin(function() {

		if($(this).val()=='0'){
			$(this).val('');
		}
  		else{
  			var str = $(this).val();
			$(this).val(angka_to_string(str));
  		}
	});

	$('input[type="text"]').focusout(function() {

		if($(this).val()==''){
			$(this).val('0');

		}
		else{
			var str = $(this).val();
			$(this).val(string_to_angka(str));
			
			//alert(str);
			//$(this).val(str);
		}

		

		// if($("#form_edit_alokasi").validationEngine('validate')){
				update_total_akun();
				//update_sisa_setting_up();

				
		// }

	})
	

	$('#form_edit_setting_up').submit(function(ev) {
	     // to stop the form from submitting
	    /* Validations go here */

	    if($("#form_edit_setting_up").validationEngine('validate')){

	    	//alert('te');

	    	// $(this).submit(); // If all the validations succeeded

	    	return true;

	    }
	    else{
	    	//ev.preventDefault();

	    }
	    
	});

	$("#total_rsa_kas_hidden").val();

	$("#total_setting_rsa_kas_hidden").val();

	$("#total_sisa_rsa_kas_hidden").val($("#total_sisa_rsa_kas_hidden").val() - $("#total_sisa_rsa_kas_hidden").val());


	$("#total_sisa_rsa_kas").html(angka_to_string($("#total_setting_rsa_kas_hidden").val() - $("#total_rsa_kas_hidden").val()));
	//$("#total_sisa_alokasi_rm").html(angka_to_string($("#total_setting_alokasi_rm_hidden").val() - $("#total_alokasi_rm_hidden").val()));
	//$("#total_sisa_alokasi_lainnya").html(angka_to_string($("#total_setting_alokasi_lainnya_hidden").val() - $("#total_alokasi_lainnya_hidden").val()));



	$('input[type="text"]').keyup(function(event) {

		  // skip for arrow keys
		  if(event.which >= 37 && event.which <= 40) return;

		  // format number
		  $(this).val(function(index, value) {
		    return value
		    .replace(/\D/g, "")
		    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
		    ;
		  });
		});
                

                $(window).keydown(function(event){
                  if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                  }
                });
                
            $('#reset').click(function(){
		$('#form_add_kegiatan').validationEngine('hide');
                location.reload();
            });


});




	function string_to_angka(str){
	//I.S str merupakan string yang berisi angka berformat (.000.000,00)
	//F.S num merupakan angka tanpa format

		// var num;
		
		// if (!isNaN(str)){
		// 	return 0;
		// }
		// // str = str.replace(/\./g,"");

		// str = str.split('.').join("");
		// //num = parseInt(str);
		// return str;
		
		return str.split('.').join("");
		

		
	}

	function angka_to_string(num){
	//I.S num merupakan angka tanpa format
	//F.S str_hasil merupakan string yang berisi angka berformat (.000.000,00)
		// var str;
		// var str_hasil="";
		// str = num +"";
		// for (var j=str.length-1;j>=0;j--){
		// 	if (((str.length-1-j)%3==0) && (j!=(str.length-1)) && ((str[0]!='-') || (j!=0))){
		// 		str_hasil="."+str_hasil;
		// 	}
		// 	str_hasil=str[j]+str_hasil;
		// }

		var str_hasil = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

		return str_hasil;
	}

	function update_total_akun(){
		var rsa_kas;
		var total_rsa_kas=0;
		var form = document.form_edit_rsa_kas;
		//var array_alokasi = form.elements["alokasi"];

		var array_rsa_kas = document.forms["form_edit_rsa_kas"].getElementsByClassName("rsa_kas");
		
		if (array_rsa_kas.length==undefined) array_rsa_kas = new Array(array_rsa_kas);

		for (var i=0;i<array_rsa_kas.length;i++){
			rsa_kas = array_rsa_kas[i].value;
			if (isNaN(rsa_kas)){
				rsa_kas="0";
				//form.elements["UnitBaru["+kdUnit+"]"].value=0;
			}
			rsa_kas 	= parseInt(rsa_kas);
			total_rsa_kas	= total_rsa_kas + rsa_kas;
		}
		document.getElementById("total_rsa_kas").innerHTML = angka_to_string(total_rsa_kas);
		document.getElementById("total_rsa_kas_hidden").value = total_rsa_kas;
	}
	/*

	function update_sisa_setting_up(){
		//var total_alokasi;
		//var total_unit;

		
		var total_setting_up = string_to_angka(document.getElementById("total_setting_up").innerHTML);

		//total_unit		= string_to_angka(document.getElementById("total_unit").innerHTML);
		var total_setting_setting_up = string_to_angka(document.getElementById("total_setting_setting_up").innerHTML);
		
		document.getElementById("total_sisa_setting_up").innerHTML = angka_to_string(total_setting_setting_up-total_setting_up);
		//document.getElementById("total_sisa_alokasi").innerHTML = angka_to_string(total_unit-total_alokasi);
	}*/
	
	//Event ketika onchange alokasi
	function onchange_rsa_kas(){
		// if($("#form_edit_alokasi").validationEngine('validate')){
		// 	update_total_unit();
		// 	update_sisa_alokasi();

		// }
		
	}
	

	
	

	

</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>SETTING AKUN KAS BANK</h2>    
                    </div>
                </div>
<?php echo form_open('rsa_kas',array('id'=>'form_edit_rsa_kas', 'name'=>'form_edit_rsa_kas')); ?>
<table class="table table-striped table-condensed">
	<thead>
		<tr height="30px">
			<th class="col-md-3">AKUN</th>
			<th class="col-md-3">JUMLAH</th>
		
		</tr>
	</thead>
	<tbody>

	<?php 
	if ($this->check_session->get_level()==100){ // IF ADMIN
	$i = 0 ;
	foreach($result_akun4 as $row){ ?>

		<tr class="form-horizontal">
			<td><label class="control-label text-success"><?=$row->nm_kas_4?></label></td>
			
			<td align="center">
				<input type="text" class="validate[required,custom[integer],min[0]] form-control rsa_kas" id="rsa_kas<?php echo $i; ?>" name="rsa_kas[<?=$row->kd_kas_4?>]" value="<?=isset($rsa_kas[$i][$row->kd_kas_4])?$rsa_kas[$i][$row->kd_kas_4]:0?>" style="text-align:right" onchange="onchange_rsa_kas();">
		</td>
			
		</tr>

		<?php $i++ ; ?>

	<?php  
		} 
	}elseif ($this->check_session->get_level()==2){ // IF UNIT
		$i = 0 ;
		foreach($result_subunit as $row){ ?>

		<tr class="form-horizontal">
			<td><label class="control-label text-success"><?=$row->nama_subunit?></label></td>
			<td></td>
			<td align="center"><input type="text" class="validate[required,custom[integer],min[0]] form-control alokasi" id="alokasi<?php echo $i; ?>" name="alokasi[<?=$row->kode_subunit?>]" value="<?=isset($alokasi[$i][$row->kode_subunit])?$alokasi[$i][$row->kode_subunit]:0?>" style="text-align:right" onchange="onchange_alokasi();"></td>
			<td align="center"><input type="text" class="validate[required,custom[integer],min[0]] form-control rm" id="rm<?php echo $i; ?>" name="rm[<?=$row->kode_subunit?>]" value="<?=isset($alokasi[$i]['rm'.$row->kode_subunit])?$alokasi[$i]['rm'.$row->kode_subunit]:0?>" style="text-align:right" onchange="onchange_alokasi_rm();"></td>
			<td align="center"><input type="text" class="validate[required,custom[integer],min[0]] form-control lainnya" id="lainnya<?php echo $i; ?>" name="lainnya[<?=$row->kode_subunit?>]" value="<?=isset($alokasi[$i]['lainnya'.$row->kode_subunit])?$alokasi[$i]['lainnya'.$row->kode_subunit]:0?>" style="text-align:right" onchange="onchange_alokasi_lainnya();"></td>
		</tr>

		<?php $i++ ; ?>

	<?php  
		} 
	}elseif ($this->check_session->get_level()==3){ // IF UNIT
		$i = 0 ;
		foreach($result_sub_subunit as $row){ ?>

		<tr class="form-horizontal">
			<td><label class="control-label text-success"><?=$row->nama_sub_subunit?></label></td>
			<td align="center"><input type="text" class="validate[required,custom[integer],min[0]] form-control alokasi" id="alokasi<?php echo $i; ?>" name="alokasi[<?=$row->kode_sub_subunit?>]" value="<?=isset($alokasi[$i][$row->kode_sub_subunit])?$alokasi[$i][$row->kode_sub_subunit]:0?>" style="text-align:right" onchange="onchange_alokasi();"></td>
			<td align="center"><input type="text" class="validate[required,custom[integer],min[0]] form-control rm" id="rm<?php echo $i; ?>" name="rm[<?=$row->kode_sub_subunit?>]" value="<?=isset($alokasi[$i]['rm'.$row->kode_sub_subunit])?$alokasi[$i]['rm'.$row->kode_sub_subunit]:0?>" style="text-align:right" onchange="onchange_alokasi_rm();"></td>
			<td align="center"><input type="text" class="validate[required,custom[integer],min[0]] form-control lainnya" id="lainnya<?php echo $i; ?>" name="lainnya[<?=$row->kode_sub_subunit?>]" value="<?=isset($alokasi[$i]['lainnya'.$row->kode_sub_subunit])?$alokasi[$i]['lainnya'.$row->kode_sub_subunit]:0?>" style="text-align:right" onchange="onchange_alokasi_lainnya();"></td>
		</tr>

		<?php $i++ ; ?>

	<?php } } ?>

	<tr >
		<td colspan="4" style="padding:0">&nbsp;</td>
	</tr>
	</tbody>
	<tfoot style="" id="tfoot-alokasi">
		<tr class="form-horizontal info" style="height:50px;border-bottom:solid 2px #CCC;">
			<td style="font-weight:bold;"><label class="control-label text-danger" >Total RSA KAs :</label></td>
			<td align="right" style="font-weight:bold;">
				<input type="hidden" id="total_rsa_kas_hidden" name="total" value="<?=isset($total_rsa_kas)?$total_rsa_kas:0?>" />
				<label class="control-label text-danger" ><span id="total_rsa_kas"><?=number_format(isset($total_rsa_kas)?$total_rsa_kas:0, 0, ",", ".")?></span></label>
			</td>
			
		</tr>
		
	<?php if ($this->check_session->get_level()==2){ ?>
		<!--
		<tr style="background:#fff;">
			<td style="color:#ff0000;font-weight:bold;">Sisa Alokasi Dana</td>
			<td align="right" align="right" style="color:#ff0000;font-weight:bold;"><span id="sisa_alokasi"><?=(isset($alokasi_unit)&&isset($total_alokasi))?number_format(($alokasi_unit-$total_alokasi), 0, ",", "."):0?></span></td>
			<td align="right" align="right" style="color:#ff0000;font-weight:bold;"><span id="sisa_alokasi_rm"><?=(isset($alokasi_unit_rm)&&isset($total_alokasi_rm))?number_format(($alokasi_unit_rm-$total_alokasi_rm), 0, ",", "."):0?></span></td>
		</tr>
		<tr style="background:#ffe9e9;">
			<td style="color:#ff0000;font-weight:bold;">Alokasi Dana Fakultas</td>
			<td align="right" align="right" style="color:#ff0000;font-weight:bold;"><span id="total_unit"><?=(isset($alokasi_unit)&&($alokasi_unit!=0))?number_format($alokasi_unit, 0, ",", "."):0?></span></td>
			<td align="right" align="right" style="color:#ff0000;font-weight:bold;"><span id="total_unit_rm"><?=(isset($alokasi_unit_rm)&&($alokasi_unit_rm!=0))?number_format($alokasi_unit_rm, 0, ",", "."):0?></span></td>
			-->
	<?php } ?>
		
	</tfoot>
</table>

<hr />

<div class="alert alert-warning" style="text-align:right">


				<button type="submit" name="submit" id="add" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Submit</button>
		      	<button type="reset" name="edit" id="reset" class="btn btn-warning"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Reset</button>
</div>
</form>
	    </div>
	  </div>
	  
</div>