<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on("click","#btn-ubah",function(){
		//$('.edit').live('click',function(){
			//$('#temp').html($('#edit_area').html());
			//$('#edit_area').html($('#form_edit').html());
			$('#display-tahun').hide(function(){$('#input-tahun').show()});
			$('#btn-ubah').hide(function(){$('#btn-submit').show()});
		});
		$(document).on("click","#btn-ubah",function(){
		//$('.edit').live('click',function(){
			//$('#temp').html($('#edit_area').html());
			//$('#edit_area').html($('#form_edit').html());
			$('#display-tahun').hide(function(){$('#input-tahun').show()});
		});
		$(document).on("click",".cancel",function(){
		//$('.cancel').live('click',function(){
			$('#edit_area').html($('#temp').html());
			$('#temp').html('');
		});
		$(document).on("click",".message-correct",function(){
		//$('.message-correct').live('click',function(){
			$(this).fadeOut('slow');
		});
	});
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>SETTING TAHUN</h2>
                   </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-lg-12">

<!--

<?=form_open('setting/tahun');?>
<table align="center" width="750px" cellspacing="0"border="0" class="units option" style="margin:auto">
<tbody>
	<tr id='edit_area'>
		<td style="padding:15px" width='450px'>Tahun yang digunakan untuk Rencana Anggaran dan Belanja (RAB) :</td>
		<td style="padding:15px" width='100px' align='center'><b><?=$cur_tahun?></b></td>
		<td style="padding:15px" width='200px' align='center'>
			<input type='button' class='edit' name='edit' value='edit' style='width:130px'>
		</td>
	</tr>
</tbody>
</table>
<?=form_close()?>


<div id='temp' style='display:none'></div>
<table>
	<tr id='form_edit' style='display:none'>
		<td style="padding:15px" width='450px'>Tahun yang digunakan untuk Rencana Anggaran dan Belanja (RAB) :</td>
		<td style="padding:15px" width='100px' align='center'><?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun)?></td>
		<td style="padding:15px" width='200px' align='center'>
			<input type='submit' name='submit' value='Submit'>
			<input type='button' class='cancel' name='cancel' value='Cancel'>
		</td>
	</tr>
</table>

-->


<?php echo form_open('setting/tahun',array('class'=>'form-horizontal col-md-6 col-md-offset-3'))?>

<div class="panel panel-info">
	<div class="panel-heading">Tahun RSA</div>
	  <div class="panel-body">
	    <div class="form-group">
		    <div class="col-md-6" >
		    	<label for="inputEmail3" id="display-tahun" class="control-label">Setting Tahun RSA Aktif : <span class="text-danger"><?=$cur_tahun?></span></label>
		       <?=form_dropdown('tahun',$this->option->get_option_tahun(date('Y'),date('Y')+7),$cur_tahun,array('class'=>'form-control','id'=>'input-tahun','style'=>'display:none'))?>
		    </div>
		    <div class="col-sm-6" style="text-align:right">
		      <button type="submit" name="submit" id="btn-submit" class="btn btn-primary" style="display:none"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Submit</button>
		      <button type="button" name="edit" id="btn-ubah" class="btn btn-warning"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</button>
		    </div>
		  </div>
	  </div>

</div>



  
</form>
</div>
	  </div>
	  
</div>
</div>