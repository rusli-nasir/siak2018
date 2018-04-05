<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
	$(document).ready(function () {
		$('#tidak').click(function(){
			<?php echo !empty($no_action)?$no_action:'';?>
			$("#myModal").modal('hide');
			//$.colorbox.close();
		});
	});
	
	$(document).ready(function () {
		$('#ya').click(function(){
			//$('.modal-message').load('<?php echo isset($url)?$url:'';?>');

			var flag = true ;

			$('#myModal').on('hidden.bs.modal', function () {

				if(flag){
					$("#myModal").load('<?php echo isset($url)?$url:'';?>'
						,function(){
							$("#myModal").modal('show');
							refresh_row();
							flag = false;
						}
					);

				}


				    // do something…
			})


			$("#myModal").modal('hide');

			/*
			
			$("#myModalMsg").load('<?php echo isset($url)?$url:'';?>'
				,function(){
					$("#myModalMsg").modal('show');
					refresh_row();
				}
			);

			*/
			

			<?php echo !empty($yes_action)?$yes_action:'';?>
			//$.colorbox.resize();
		});
	});

	$(document).ready(function () {
        
    });



</script>

<!--
<button type="button" class="btn btn-primary btn-lg btn-block" name="ya" id="ya">Block level button</button>
<button type="button" class="btn btn-default btn-lg btn-block" name="tidak" id="tidak">Block level button</button>
-->
<!--
<div class="modal-message">
<table width="400px" align="center" border="0" cellpadding="5" cellspacing="0" class="boxcorrect">
<tr height="30px">
	<td align="center">
		<?php echo isset($message)?$message:'';?>
	</td>
</tr>
<tr height="30px">
	<td align="right">
		<input type="button" value="Ya" name="ya" id="ya" /><input type="button" value="Tidak" name="tidak" id="tidak" />
	</td>
</tr>
</table>
</div>
-->

<!-- Modal -->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <?php echo isset($message)?$message:'';?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" name="ya" id="ya">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" name="tidak" id="tidak">Cancel</button>
      </div>
    </div>
  </div>