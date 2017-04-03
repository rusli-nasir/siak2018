<script type="text/javascript">


$(document).ready(function(){

	var total_setting_up = $("#total_setting_up").text();
	
//	var total_setting_setting_up = $("#total_setting_setting_up").text();


	//$("#total_sisa_setting_up").text(angka_to_string(string_to_angka(total_setting_setting_up) - string_to_angka(total_setting_up)));
        var tot_nom_41 = 0 ;
        var tot_nom_42 = 0 ;
        var tot_nom_43 = 0 ;
        var tot_nom_44 = 0 ;
        $('[id^="setting_up_subunit_41_"]').each(function(){
            var nom = parseInt($(this).val());
            tot_nom_41 = tot_nom_41 + nom ;
        });
        $('[id^="setting_up_subunit_42_"]').each(function(){
            var nom = parseInt($(this).val());
            tot_nom_42 = tot_nom_42 + nom ;
        });
        $('[id^="setting_up_subunit_43_"]').each(function(){
            var nom = parseInt($(this).val());
            tot_nom_43 = tot_nom_43 + nom ;
        });
        $('[id^="setting_up_subunit_44_"]').each(function(){
            var nom = parseInt($(this).val());
            tot_nom_44 = tot_nom_44 + nom ;
        });
        $('input[name="setting_up[41]"]').val(tot_nom_41);
        $('input[name="setting_up[42]"]').val(tot_nom_42);
        $('input[name="setting_up[43]"]').val(tot_nom_43);
        $('input[name="setting_up[44]"]').val(tot_nom_44);
        
        var tot_up = 0 ;
        $('.setting_up').each(function(){
            var nom = parseInt($(this).val());
            tot_up = tot_up + nom ;
        });
        document.getElementById("total_setting_up").innerHTML = angka_to_string(tot_up);
	document.getElementById("total_setting_up_hidden").value = tot_up;
        
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
				//update_total_unit();
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

	$("#total_setting_up_hidden").val();

	$("#total_setting_setting_up_hidden").val();

	$("#total_sisa_setting_up_hidden").val($("#total_sisa_setting_up_hidden").val() - $("#total_sisa_setting_up_hidden").val());


	$("#total_sisa_setting_up").html(angka_to_string($("#total_setting_setting_up_hidden").val() - $("#total_setting_up_hidden").val()));
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

	function update_total_unit(){
		var setting_up;
		var total_setting_up=0;
		var form = document.form_edit_setting_up;
		//var array_alokasi = form.elements["alokasi"];

		var array_setting_up = document.forms["form_edit_setting_up"].getElementsByClassName("setting_up");
		
		if (array_setting_up.length==undefined) array_setting_up = new Array(array_setting_up);

		for (var i=0;i<array_setting_up.length;i++){
			setting_up = array_setting_up[i].value;
			if (isNaN(setting_up)){
				setting_up="0";
				//form.elements["UnitBaru["+kdUnit+"]"].value=0;
			}
			setting_up 	= parseInt(setting_up);
			total_setting_up	= total_setting_up + setting_up;
		}
		document.getElementById("total_setting_up").innerHTML = angka_to_string(total_setting_up);
		document.getElementById("total_setting_up_hidden").value = total_setting_up;
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
	function onchange_setting_up(){
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
                     <h2>PEMBAGIAN UP</h2>    
                    </div>
                </div>
                <hr />
<?php echo form_open('setting_up',array('id'=>'form_edit_setting_up', 'name'=>'form_edit_setting_up')); ?>
<table class="table table-striped table-condensed">
	<thead>
		<tr height="30px">
			<th class="col-md-3">Unit / Sub Unit</th>
			<th class="col-md-3">JUMLAH</th>
		
		</tr>
	</thead>
	<tbody>

	<?php 
	// if ($this->check_session->get_level()==11){ // IF ADMIN
	$i = 0 ;
        $n = 0 ;
	foreach($result_unit as $row){ ?>
            
            <?php if(($row->kode_unit == '41')||($row->kode_unit == '42')||($row->kode_unit == '43')||($row->kode_unit == '44')): ?>
            <tr class="form-horizontal" style="background-color: #f1bdbd">
                    <td >
                            <label class="control-label text-success"><?=$row->nama_unit?></label>
                        </td>
                        <td align="center">
                            <input type="text" class="form-control setting_up" id="setting_up<?php echo $i; ?>" name="setting_up[<?=$row->kode_unit?>]" value="0" style="text-align:right" onchange="onchange_setting_up();" readonly="readonly">
                            </td>
		</tr>
                <?php foreach($result_subunit as $row_){ ?>
                    <?php //if(substr($row_->kode_subunit,0,2)==$row->kode_unit){ ?>
                    <?php foreach($row_ as $row__){ ?>
                    <?php if(substr($row__->kode_subunit,0,2)==$row->kode_unit){ ?>
                    <tr class="form-horizontal">
                        <td style="padding-left: 30px;">
                                <label class="control-label text-success"><?=$row__->nama_subunit?></label>
                            </td>
                            <td align="center">
                                            <input type="text" class="validate[required,custom[integer],min[0]] form-control setting_up_subunit" id="setting_up_subunit_<?=$row->kode_unit?>_<?php echo $n; ?>" name="setting_up_subunit[<?=$row__->kode_subunit?>]" value="<?=isset($setting_up_subunit[$n][$row__->kode_subunit])?$setting_up_subunit[$n][$row__->kode_subunit]:0?>" style="text-align:right" onchange="onchange_setting_up();">
                            </td>

                    </tr>
                    
                    <?php $n++ ; ?>
                    <?php } ?>
                    <?php } ?>
                <?php } ?>
               <?php $i++ ; ?>
            <?php else: ?>

		<tr class="form-horizontal">
			<td>
                            <label class="control-label text-success"><?=$row->nama_unit?></label>
                        </td>
                        <td align="center">
                                        <input type="text" class="validate[required,custom[integer],min[0]] form-control setting_up" id="setting_up<?php echo $i; ?>" name="setting_up[<?=$row->kode_unit?>]" value="<?=isset($setting_up[$i][$row->kode_unit])?$setting_up[$i][$row->kode_unit]:0?>" style="text-align:right" onchange="onchange_setting_up();">
                        </td>
			
		</tr>
                <?php $i++ ; ?>
            <?php endif; ?>

		<?php //$i++ ; ?>

	<?php  
		} 
        // }
	?>
	<tr >
		<td colspan="4" style="padding:0">&nbsp;</td>
	</tr>
	</tbody>
	<tfoot style="" id="tfoot-alokasi">
		<tr class="form-horizontal info" style="height:50px;border-bottom:solid 2px #CCC;">
			<td style="font-weight:bold;"><label class="control-label text-danger" >Total UP :</label></td>
			<td align="right" style="font-weight:bold;">
				<input type="hidden" id="total_setting_up_hidden" name="total" value="<?php // isset($total_setting_up)?$total_setting_up:0; ?>" />
				<label class="control-label text-danger" ><span id="total_setting_up"><?php // number_format(isset($total_setting_up)?$total_setting_up:0, 0, ",", "."); ?></span></label>
			</td>
			
		</tr>
		
	<?php if ($this->check_session->get_level()==2){ ?>

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