<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		$(document).on("click",".ok",function(){
		//$('.ok').live("click",function(){
			<?php echo !empty($pre_action)?$pre_action:'';?>
			//$.colorbox.close();
			<?php echo !empty($after_action)?$after_action:'';?>
			//$('#detail').load('<?php echo site_url('usulan_belanja/refresh_row_detail');?>');
			$("#myModal").modal('hide')
		});
	});
</script>

<!--
<table width="400px" align="center" border="0" cellpadding="5" cellspacing="0" class="<?php echo isset($class)?$class:'';?>">
<tr height="30px">
	<td align="center">
		<?php echo isset($message)?$message:'';?>
	</td>
</tr>
<tr height="30px">
	<td align="right">
		<input type="button" value="OK" name="ok" class="ok" id="<?php echo isset($class_btn)?$class_btn:'ya';?>" />
	</td>
</tr>
</table>
-->

<!-- Modal -->
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalMsgLabel">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <?php echo isset($message)?$message:'';?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" name="ok" class="ok" id="<?php echo isset($class_btn)?$class_btn:'ya';?>" >Done</button>
      </div>
    </div>
  </div>
